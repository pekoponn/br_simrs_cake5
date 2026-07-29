<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PatientAdmissions Controller
 *
 * Halaman monitoring pendaftaran pasien.
 * Data dipanggil dari halaman instansi yang sudah ada:
 * - JKN / IGD / Rawat Inap: registrations
 * - Rawat Jalan: outpatient_visits
 */
class PatientAdmissionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Registrations');
        $this->loadModel('OutpatientVisits');
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

        if ($tab === 'rawat_jalan') {
            $dataSource = 'outpatient_visits';
            $query = $this->buildRawatJalanQuery($q, $dateFrom, $dateTo);
        } else {
            $query = $this->buildRegistrationQuery($tab, $q, $dateFrom, $dateTo);
        }

        $this->paginate = [
            'limit' => 50,
        ];

        $admissions = $this->paginate($query);

        $identity = $this->request->getAttribute('identity');
        $petugas = 'GR';
        if ($identity) {
            $petugas = $identity->name ?? $identity->username ?? $identity->email ?? 'GR';
        }

        $this->set(compact('admissions', 'dataSource', 'tab', 'q', 'dateFrom', 'dateTo', 'petugas'));
    }

    private function buildRawatJalanQuery(string $q, string $dateFrom, string $dateTo)
    {
        $contain = [];
        if ($this->OutpatientVisits->associations()->has('Patients')) {
            $contain[] = 'Patients';
        }
        if ($this->OutpatientVisits->associations()->has('Doctors')) {
            $contain[] = 'Doctors';
        }
        if ($this->OutpatientVisits->associations()->has('Registrations')) {
            $contain['Registrations'] = ['Rooms'];
        }

        $query = $this->OutpatientVisits->find()
            ->contain($contain)
            ->order([
                'OutpatientVisits.visit_date' => 'DESC',
                'OutpatientVisits.created' => 'DESC',
                'OutpatientVisits.id' => 'DESC',
            ]);

        if ($dateFrom !== '') {
            $query->where(['OutpatientVisits.visit_date >=' => $dateFrom]);
        }
        if ($dateTo !== '') {
            $query->where(['OutpatientVisits.visit_date <=' => $dateTo]);
        }

        if ($q !== '') {
            $query->where(function ($exp) use ($q) {
                $like = '%' . $q . '%';

                $or = [
                    'OutpatientVisits.registration_no LIKE' => $like,
                    'OutpatientVisits.polyclinic_name LIKE' => $like,
                    'OutpatientVisits.status LIKE' => $like,
                    'Patients.code LIKE' => $like,
                    'Patients.full_name LIKE' => $like,
                    'Patients.phone_number LIKE' => $like,
                    'Patients.identity_number LIKE' => $like,
                    'Doctors.doctor_name LIKE' => $like,
                ];

                // queue_number biasanya integer, jadi jangan pakai LIKE string.
                if (ctype_digit($q)) {
                    $or['OutpatientVisits.queue_number'] = (int)$q;
                    $or['OutpatientVisits.id'] = (int)$q;
                }

                return $exp->or_($or);
            });
        }

        return $query;
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
                    return $exp->or_([
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
                // Ikuti data instansi IGD dari registrations.
                // Kalau di database service_type kamu berupa string, ini aman.
                // Kalau masih error integer, berarti service_type di database kamu integer dan perlu mapping angka.
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
                    return $exp->or_([
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

        // Ambil registrasi yang SUDAH ADA untuk kunjungan ini — jangan buat baru.
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
                // Cukup ubah status registrasi yang sudah ada.
                // registration_no, service_type, poli, dokter TIDAK diubah.
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
