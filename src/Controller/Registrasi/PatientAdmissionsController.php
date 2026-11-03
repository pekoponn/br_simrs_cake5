<?php
declare(strict_types=1);

namespace App\Controller\Registrasi;

use App\Controller\AppController;

/**
 * PatientAdmissions Controller
 *
 * Halaman monitoring pendaftaran pasien.
 * Data dipanggil dari halaman instansi yang sudah ada:
 * - JKN / IGD / Rawat Inap: registrations
 * - Rawat Jalan: outpatient_visits
 * - Pra Registrasi: pra_registrations (langsung, belum diproses)
 */
class PatientAdmissionsController extends AppController
{
        public function initialize(): void
    {
        parent::initialize();

        $this->Registrations = $this->fetchTable('Registrations');
        $this->OutpatientVisits = $this->fetchTable('OutpatientVisits');
        $this->PraRegistrations = $this->fetchTable('PraRegistrations');
        $this->PolyclinicQueues = $this->fetchTable('PolyclinicQueues');
    }

    public function index()
    {
        $tab = (string)$this->request->getQuery('tab', 'jkn');
        $allowedTabs = [
            'jkn',
            'rawat_jalan',
            'igd',
            'rawat_inap',
            'tutup_sementara',
            'rencana_rawat_inap',
        ];

        if (!in_array($tab, $allowedTabs, true)) {
            $tab = 'jkn';
        }

        $q = trim((string)$this->request->getQuery('q', ''));
        $dateFrom = (string)$this->request->getQuery('date_from', date('Y-m-d'));
        $dateTo = (string)$this->request->getQuery('date_to', date('Y-m-d'));

        $dataSource = 'registrations';
        $paCustomPagination = null;

        if ($tab === 'rawat_jalan') {
            $dataSource = 'rawat_jalan_gabungan';

            $rows = $this->buildRawatJalanRows($q, $dateFrom, $dateTo);

            $limit = 50;
            $page = max(1, (int)$this->request->getQuery('page', 1));
            $totalRows = count($rows);
            $totalPages = max(1, (int)ceil($totalRows / $limit));
            $page = min($page, $totalPages);

            $admissions = array_slice($rows, ($page - 1) * $limit, $limit);

            $paCustomPagination = [
                'page' => $page,
                'pages' => $totalPages,
                'count' => $totalRows,
            ];
        } else {
            $query = $this->buildRegistrationQuery($tab, $q, $dateFrom, $dateTo);

            $this->paginate = [
                'limit' => 50,
            ];

            $admissions = $this->paginate($query);
        }

        $identity = $this->request->getAttribute('identity');
        $petugas = 'GR';
        if ($identity) {
            $petugas = $identity->name ?? $identity->username ?? $identity->email ?? 'GR';
        }

        $this->set(compact('admissions', 'dataSource', 'tab', 'q', 'dateFrom', 'dateTo', 'petugas', 'paCustomPagination'));
    }

    /**
     * @return array<int, 
     */
    private function buildRawatJalanRows(string $q, string $dateFrom, string $dateTo): array
    {
        $rows = [];

        $visitContain = [];
        if ($this->OutpatientVisits->associations()->has('Patients')) {
            $visitContain[] = 'Patients';
        }
        if ($this->OutpatientVisits->associations()->has('Doctors')) {
            $visitContain[] = 'Doctors';
        }

        $visitQuery = $this->OutpatientVisits->find()->contain($visitContain);

        if ($dateFrom !== '') {
            $visitQuery->where(['OutpatientVisits.visit_date >=' => $dateFrom]);
        }
        if ($dateTo !== '') {
            $visitQuery->where(['OutpatientVisits.visit_date <=' => $dateTo]);
        }

        foreach ($visitQuery->all() as $visit) {
            $rows[] = (object)[
                'queue_number' => $visit->queue_number ?? '-',
                'registration_no' => $visit->registration_no ?? '',
                'patient' => (object)[
                    'code' => $visit->patient->code ?? '',
                    'full_name' => $visit->patient->full_name ?? '',
                    'phone_number' => $visit->patient->phone_number ?? '',
                ],
                'doctor_name' => $visit->doctor->doctor_name ?? ($visit->doctor->name ?? ''),
                'visit_date' => $visit->visit_date ?? null,
                'visit_time' => $visit->visit_time ?? null,
                'polyclinic_name' => $visit->polyclinic_name ?? '',
                'room_name' => $visit->room_name ?? '',
                'status' => 'Sudah Registrasi',
                '_sort' => (string)($visit->visit_date ?? '') . ' ' . (string)($visit->visit_time ?? ''),
                '_url' => null,
            ];
        }

        $queueQuery = $this->PolyclinicQueues->find()
            ->where(['PolyclinicQueues.is_active' => 'Y']);

        if ($dateFrom !== '') {
            $queueQuery->where(['PolyclinicQueues.visit_date >=' => $dateFrom]);
        }
        if ($dateTo !== '') {
            $queueQuery->where(['PolyclinicQueues.visit_date <=' => $dateTo]);
        }

        foreach ($queueQuery->all() as $queue) {
            $rows[] = (object)[
                'queue_number' => $queue->code ?? ($queue->queue_number ?? '-'),
                'registration_no' => '',
                'patient' => (object)[
                    'code' => $queue->medical_record_no ?? '',
                    'full_name' => $queue->patients_name ?? '',
                    'phone_number' => $queue->no_telp ?? '',
                ],
                'doctor_name' => $queue->doctor_name ?? '',
                'visit_date' => $queue->visit_date ?? $queue->created ?? null,
                'visit_time' => null,
                'polyclinic_name' => $queue->poly_name ?? '',
                'room_name' => '',
                'status' => 'Belum Registrasi',
                '_sort' => (string)($queue->created ?? $queue->visit_date ?? ''),
                '_url' => $this->buildQueueAdmissionUrl($queue),
                '_call_queue_id' => $queue->id,
            ];
        }

        $praCodeCounters = [];

        $praQuery = $this->PraRegistrations->find()
            ->where([
                'PraRegistrations.registration_status' => 'diteruskan',
                'PraRegistrations.polyclinic_queue_id IS' => null,
            ])
            ->order([
                'PraRegistrations.appointment_date' => 'ASC',
                'PraRegistrations.appointment_time' => 'ASC',
                'PraRegistrations.id' => 'ASC',
            ]);

        if ($dateFrom !== '') {
            $praQuery->where(['PraRegistrations.appointment_date >=' => $dateFrom]);
        }
        if ($dateTo !== '') {
            $praQuery->where(['PraRegistrations.appointment_date <=' => $dateTo]);
        }

        foreach ($praQuery->all() as $pra) {
            $apptDateStr = !empty($pra->appointment_date)
                ? (is_object($pra->appointment_date) && method_exists($pra->appointment_date, 'format')
                    ? $pra->appointment_date->format('Y-m-d')
                    : (string)$pra->appointment_date)
                : date('Y-m-d');

            $apptTimeStr = !empty($pra->appointment_time)
                ? (is_object($pra->appointment_time) && method_exists($pra->appointment_time, 'format')
                    ? $pra->appointment_time->format('H:i')
                    : substr((string)$pra->appointment_time, 0, 5))
                : '';
            $prefix = ($apptTimeStr !== '' && $apptTimeStr < '12:00') ? 'A' : 'B';
            $counterKey = $apptDateStr . '|' . $prefix;

            if (!isset($praCodeCounters[$counterKey])) {
                $praCodeCounters[$counterKey] = $this->getNextAntrianCodeNumber($prefix, $apptDateStr);
            }

            $praCodeCounters[$counterKey]++;
            $virtualQueueCode = $this->formatAntrianCode($praCodeCounters[$counterKey], $prefix);

            $rows[] = (object)[
                'queue_number' => $virtualQueueCode,
                'registration_no' => '',
                'patient' => (object)[
                    'code' => $pra->medical_record_no ?? '',
                    'full_name' => $pra->patient_name ?? '',
                    'phone_number' => $pra->phone_number ?? '',
                ],
                'doctor_name' => $pra->doctor_name ?? '',
                'visit_date' => $pra->appointment_date ?? null,
                'visit_time' => $pra->appointment_time ?? null,
                'polyclinic_name' => $pra->poly_name ?? '',
                'room_name' => '',
                'status' => 'Belum Registrasi',
                '_sort' => (string)($pra->appointment_date ?? '') . ' ' . (string)($pra->appointment_time ?? ''),
                '_url' => $this->buildPraAdmissionUrl($pra),
            ];
        }

        if ($q !== '') {
            $needle = mb_strtolower($q);
            $rows = array_values(array_filter($rows, function ($row) use ($needle) {
                $haystack = mb_strtolower(implode(' ', [
                    (string)$row->registration_no,
                    (string)$row->patient->full_name,
                    (string)$row->patient->phone_number,
                    (string)$row->patient->code,
                    (string)$row->polyclinic_name,
                    (string)$row->doctor_name,
                    (string)$row->queue_number,
                ]));

                return mb_strpos($haystack, $needle) !== false;
            }));
        }

                usort($rows, function ($a, $b) {
            return $this->compareQueueRowsByNumber($a, $b);
        });

        return $rows;
    }

    private function compareQueueRowsByNumber($a, $b): int
    {
        [$prefixA, $numA] = $this->extractQueueSortKey((string)($a->queue_number ?? ''));
        [$prefixB, $numB] = $this->extractQueueSortKey((string)($b->queue_number ?? ''));

        if ($prefixA !== $prefixB) {
            return $prefixA <=> $prefixB;
        }

        return $numA <=> $numB;
    }

    /**
     * @return array{0: string, 1: int}
     */
    private function extractQueueSortKey(string $rawQueueNumber): array
    {
        if (preg_match('/^([A-Za-z]+)-(\d+)$/', trim($rawQueueNumber), $m)) {
            return [$m[1], (int)$m[2]];
        }

        if (ctype_digit(trim($rawQueueNumber))) {
            return ['', (int)$rawQueueNumber];
        }
        return ['~', PHP_INT_MAX];
    }

    private function buildQueueAdmissionUrl($queue): string
    {
        return \Cake\Routing\Router::url(['prefix' => 'Registrasi', 'controller' => 'Registrations',
            'action' => 'addTemp',
            '?' => ['queue_id' => $queue->id],
        ]);
    }

        private function buildPraAdmissionUrl($pra): string
    {
        return \Cake\Routing\Router::url(['prefix' => 'Registrasi', 'controller' => 'Registrations',
            'action' => 'add',
            '?' => [
                'from_pra_registration' => 1,
                'source_pra_registration_id' => $pra->id,
            ],
        ]);
    }

    private function getNextAntrianCodeNumber(string $prefix, string $visitDate): int
    {
        $startDate = $visitDate . ' 00:00:00';
        $endDate = $visitDate . ' 23:59:59';

        $last = $this->PolyclinicQueues->find()
            ->select(['queue_number'])
            ->where(['PolyclinicQueues.code LIKE' => $prefix . '-%'])
            ->where(function ($exp) use ($visitDate, $startDate, $endDate) {
                return $expression->or([
                    'PolyclinicQueues.visit_date' => $visitDate,
                    $expression->and([
                        'PolyclinicQueues.visit_date IS' => null,
                        'PolyclinicQueues.created >=' => $startDate,
                        'PolyclinicQueues.created <=' => $endDate,
                    ]),
                ]);
            })
            ->order(['PolyclinicQueues.queue_number' => 'DESC'])
            ->enableHydration(false)
            ->first();

        return $last ? (int)$last['queue_number'] : 0;
    }

    private function formatAntrianCode(int $number, string $prefix): string
    {
        return $prefix . '-' . str_pad((string)$number, 3, '0', STR_PAD_LEFT);
    }

    private function buildRegistrationQuery(string $tab, string $q, string $dateFrom, string $dateTo)
    {
        $contain = ['Patients', 'Doctors'];

        if ($this->Registrations->associations()->has('Rooms')) {
            $contain[] = 'Rooms';
        }
        if ($this->Registrations->associations()->has('Beds')) {
            $contain[] = 'Beds';
        }
        if ($this->Registrations->associations()->has('PolyclinicQueues')) {
            $contain[] = 'PolyclinicQueues';
        }

        $query = $this->Registrations->find()
            ->contain($contain)
            ->order([
                'Registrations.registration_date' => 'DESC',
                'Registrations.created' => 'DESC',
                'Registrations.id' => 'DESC',
            ]);

        if ($dateFrom !== '') {
            $query->where(['Registrations.registration_date >=' => $dateFrom]);
        }
        if ($dateTo !== '') {
            $query->where(['Registrations.registration_date <=' => $dateTo]);
        }

        if ($q !== '') {
            $query->where(function ($exp) use ($q) {
                $like = '%' . $q . '%';

                $or = [
                    'Registrations.registration_no LIKE' => $like,
                    'Registrations.insurance_card_no LIKE' => $like,
                    'Registrations.sep_no LIKE' => $like,
                    'Registrations.refferal_no LIKE' => $like,
                    'Registrations.bpjs_nik LIKE' => $like,
                    'Registrations.bpjs_name LIKE' => $like,
                    'Registrations.bpjs_group LIKE' => $like,
                    'Registrations.bpjs_type LIKE' => $like,
                    'Registrations.polyclinic_name LIKE' => $like,
                    'Registrations.room_name LIKE' => $like,
                    'Registrations.payment_method LIKE' => $like,
                    'Registrations.insurance_type LIKE' => $like,
                    'Patients.code LIKE' => $like,
                    'Patients.full_name LIKE' => $like,
                    'Patients.phone_number LIKE' => $like,
                    'Patients.identity_number LIKE' => $like,
                    'Doctors.doctor_name LIKE' => $like,
                ];

                // queue_no, patient_id, doctor_id, room_id, bed_id biasanya integer.
                if (ctype_digit($q)) {
                    $or['Registrations.queue_no'] = (int)$q;
                    $or['Registrations.id'] = (int)$q;
                    $or['Registrations.patient_id'] = (int)$q;
                }

                return $exp->or_($or);
            });
        }

        switch ($tab) {
            case 'jkn':
                $query->where(function ($exp) {
                    return $exp->or([
                        'Registrations.insurance_card_no IS NOT' => null,
                        'Registrations.sep_no IS NOT' => null,
                        'Registrations.bpjs_nik IS NOT' => null,
                        'Registrations.bpjs_name IS NOT' => null,
                        'Registrations.bpjs_type IS NOT' => null,
                        'Registrations.payment_method LIKE' => '%BPJS%',
                        'Registrations.payment_method LIKE' => '%JKN%',
                        'Registrations.insurance_type LIKE' => '%BPJS%',
                        'Registrations.insurance_type LIKE' => '%JKN%',
                    ]);
                });
                break;

            case 'igd':
                $query->where(['Registrations.service_type IN' => ['igd', 'gawat_darurat']]);
                break;

            case 'rawat_inap':
                $query->where(['Registrations.service_type' => 'rawat_inap']);
                break;

            case 'tutup_sementara':
                $query->where(['Registrations.status IN' => ['tutup_sementara', 'closed_temporary', 'temporary_closed']]);
                break;

            case 'rencana_rawat_inap':
                $query->where(function ($exp) {
                    return $exp->or([
                        'Registrations.service_type' => 'rencana_rawat_inap',
                        'Registrations.status IN' => ['rencana_rawat_inap', 'planned_inpatient', 'rencana'],
                    ]);
                });
                break;
        }

        return $query;
    }

    public function planInpatient($visitId = null)
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $visit = $this->OutpatientVisits->get($visitId, [
            'contain' => ['Patients', 'Doctors', 'Registrations'],
        ]);

        if (!empty($visit->is_planned_inpatient)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'message' => 'Kunjungan ini sudah direncanakan rawat inap sebelumnya.',
            ]));
        }

        $registrationId = $visit->registration_id ?? ($visit->registration->id ?? null);

        if (empty($registrationId)) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => false,
                'message' => 'Data registrasi untuk kunjungan ini tidak ditemukan.',
            ]));
        }

        $registration = $this->Registrations->get($registrationId);

        $conn = $this->Registrations->getConnection();
        $saved = false;

        try {
            $conn->transactional(function () use (&$saved, $registration, $visit) {
                $registration->status = 'rencana_rawat_inap';

                if (!$this->Registrations->save($registration, ['checkRules' => false])) {
                    throw new \Exception('registration');
                }

                $visit->is_planned_inpatient = 1;
                $visit->status = 'done';
                if ($this->OutpatientVisits->getSchema()->hasColumn('end_time')) {
                    $visit->end_time = date('Y-m-d H:i:s');
                }

                if (!$this->OutpatientVisits->save($visit, ['checkRules' => false])) {
                    throw new \Exception('visit');
                }

                $saved = true;
            });
        } catch (\Throwable $e) {
            $saved = false;
        }

        if ($saved) {
            return $this->response->withType('application/json')->withStringBody(json_encode([
                'success' => true,
                'registration_id' => $registration->id,
                'registration_no' => $registration->registration_no,
            ]));
        }

        return $this->response->withType('application/json')->withStringBody(json_encode([
            'success' => false,
            'message' => 'Gagal memperbarui status registrasi.',
            'errors' => array_merge($registration->getErrors(), $visit->getErrors()),
        ]));
    }
}