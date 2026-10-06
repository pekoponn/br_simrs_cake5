<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * PolyclinicQueues Controller
 *
 * @property \App\Model\Table\PolyclinicQueuesTable $PolyclinicQueues
 */
class PolyclinicQueuesController extends AppController
{
    private const SOURCE_WHATSAPP = 'WA';
    private const SOURCE_KIOSK = 'KIOSK';
    private const SOURCE_MOBILE_JKN = 'Mobile JKN';
    private const SOURCE_EMR_RUJUK = 'Rujukan';
    private const CHECKIN_PENDING = 'Belum Check-in';
    private const CHECKIN_DONE = 'Sudah Check-in';
    private const CALL_STATUS_WAITING = 'Menunggu';
    private const CALL_STATUS_CALLED = 'Dipanggil';
    private const QUEUE_SESSION_MORNING = 'morning';
    private const QUEUE_SESSION_AFTERNOON = 'afternoon';
    private const QUEUE_CODE_PREFIX_MORNING = 'A';
    private const QUEUE_CODE_PREFIX_AFTERNOON = 'B';
    private const KIOSK_MAX_ADMISSION_TIME = '20:00';

    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('PolyclinicQueues');
    }

    public function index()
    {
        $key = $this->request->getQuery('key');

        $query = $this->PolyclinicQueues->find()
            ->contain(['Registrations']);
        $query = $this->applyQueueVisitDateFilter($query, date('Y-m-d'));

        if (!empty($key)) {
            $query->where([
                'OR' => [
                    'PolyclinicQueues.code LIKE' => '%' . $key . '%',
                    'PolyclinicQueues.poly_name LIKE' => '%' . $key . '%',
                    'PolyclinicQueues.patients_name LIKE' => '%' . $key . '%',
                    'PolyclinicQueues.no_telp LIKE' => '%' . $key . '%',
                    'PolyclinicQueues.booking_code LIKE' => '%' . $key . '%',
                    'PolyclinicQueues.bpjs_number LIKE' => '%' . $key . '%',
                    'PolyclinicQueues.identity_number LIKE' => '%' . $key . '%',
                ]
            ]);
        }

        // Urutan ascending berdasarkan nomor antrian, supaya siapa yang
        // daftar/ambil nomor duluan tampil paling atas (nomor 1, 2, 3, ...).
        // Ini juga otomatis berlaku untuk antrian yang diambil untuk "besok":
        // begitu tanggalnya jadi hari ini, dia akan muncul di sini dan
        // urutannya tetap mengikuti nomor antriannya, bukan urutan dibuatnya.
        $this->paginate = [
            'order' => [
                'PolyclinicQueues.queue_number' => 'ASC',
                'PolyclinicQueues.id' => 'ASC',
            ]
        ];

        $polyclinicQueues = $this->paginate($query);

        $this->set(compact('polyclinicQueues'));
    }

    public function display()
    {
        $queues = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->order([
                'PolyclinicQueues.queue_number' => 'ASC',
                'PolyclinicQueues.id' => 'ASC',
            ])
            ->limit(60);
        $queues = $this->applyQueueVisitDateFilter($queues, date('Y-m-d'))->all();

        $calledQueueConditions = [
            'PolyclinicQueues.call_status' => self::CALL_STATUS_CALLED,
            'PolyclinicQueues.called_time IS NOT' => null,
        ];

        $calledQueue = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where($calledQueueConditions);
        $calledQueue = $this->applyQueueVisitDateFilter($calledQueue, date('Y-m-d'))
            ->order([
                'PolyclinicQueues.called_time' => 'DESC',
                'PolyclinicQueues.id' => 'DESC',
            ])
            ->first();

        $calledOnlineQueue = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where($calledQueueConditions)
            ->where([
                'PolyclinicQueues.source' => self::SOURCE_MOBILE_JKN,
            ]);
        $calledOnlineQueue = $this->applyQueueVisitDateFilter($calledOnlineQueue, date('Y-m-d'))
            ->order([
                'PolyclinicQueues.called_time' => 'DESC',
                'PolyclinicQueues.id' => 'DESC',
            ])
            ->first();

        $calledOnsiteQueue = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where($calledQueueConditions)
            ->where(function ($exp) {
                return $exp->or_([
                    'PolyclinicQueues.source !=' => self::SOURCE_MOBILE_JKN,
                    'PolyclinicQueues.source IS' => null,
                ]);
            });
        $calledOnsiteQueue = $this->applyQueueVisitDateFilter($calledOnsiteQueue, date('Y-m-d'))
            ->order([
                'PolyclinicQueues.called_time' => 'DESC',
                'PolyclinicQueues.id' => 'DESC',
            ])
            ->first();

        $stats = [
            'total' => 0,
            'waiting' => 0,
            'called' => 0,
            'checked_in' => 0,
            'registered' => 0,
        ];

        $polyclinicSummary = [];
        $nextQueue = null;
        $nextOnlineQueue = null;
        $nextOnsiteQueue = null;
        $onlineTotal = 0;
        $onsiteTotal = 0;
        $onlineWaiting = 0;
        $onsiteWaiting = 0;
        $waitingQueueList = [];

        foreach ($queues as $queue) {
            $stats['total']++;
            $polyName = (string)($queue->poly_name ?: 'Poli Tidak Diketahui');
            $isOnlineQueue = $queue->source === self::SOURCE_MOBILE_JKN;
            $isWaitingQueue = empty($queue->registration)
                && $queue->is_active === 'Y'
                && $queue->call_status !== self::CALL_STATUS_CALLED;

            $isQueueStillOnDisplayList = empty($queue->registration)
                && $queue->is_active === 'Y';

            // Daftar antrian aktif untuk panel kanan display.
            // Catatan: nomor yang sudah Dipanggil tetap ditampilkan selama belum menjadi registrasi.
            // Jika pasien sudah dibuatkan registrasi, relasi registration akan terisi
            // sehingga nomor antrian otomatis tidak masuk ke tabel ini.
            if ($isQueueStillOnDisplayList) {
                $waitingQueueList[] = $queue;
            }

            if ($isOnlineQueue) {
                $onlineTotal++;
            } else {
                $onsiteTotal++;
            }

            if (!isset($polyclinicSummary[$polyName])) {
                $polyclinicSummary[$polyName] = 0;
            }

            $polyclinicSummary[$polyName]++;

            if (!empty($queue->registration)) {
                $stats['registered']++;
                continue;
            }

            if ($queue->call_status === self::CALL_STATUS_CALLED) {
                $stats['called']++;
                continue;
            }

            if ($queue->source === self::SOURCE_MOBILE_JKN && $queue->checkin_status === self::CHECKIN_DONE) {
                $stats['checked_in']++;
            } elseif ($queue->is_active === 'Y') {
                $stats['waiting']++;
            }

            if ($nextQueue === null && $queue->is_active === 'Y') {
                $nextQueue = $queue;
            }

            if ($isWaitingQueue) {
                if ($isOnlineQueue) {
                    $onlineWaiting++;

                    if ($nextOnlineQueue === null) {
                        $nextOnlineQueue = $queue;
                    }
                } else {
                    $onsiteWaiting++;

                    if ($nextOnsiteQueue === null) {
                        $nextOnsiteQueue = $queue;
                    }
                }
            }
        }

        arsort($polyclinicSummary);

        $todayLabel = date('d F Y');

        if ($this->request->getQuery('ajax') === '1') {
            $currentSource = 'Belum ada panggilan';

            if ($calledQueue) {
                $currentSource = $calledQueue->source === self::SOURCE_MOBILE_JKN
                    ? self::SOURCE_MOBILE_JKN
                    : 'Loket Rumah Sakit';
            }

            $waitingQueuePayload = [];

            foreach ($waitingQueueList as $queueItem) {
                $waitingQueuePayload[] = [
                    'code' => (string)($queueItem->code ?: '-'),
                    'poly_name' => (string)($queueItem->poly_name ?: '-'),
                    'patients_name' => (string)($queueItem->patients_name ?: '-'),
                    'source' => $this->getSourceLabel((string)$queueItem->source),
                    'call_status' => (string)($queueItem->call_status ?: self::CALL_STATUS_WAITING),
                ];
            }

            $payload = [
                'currentCode' => $calledQueue ? (string)($calledQueue->code ?: '-') : '-',
                'currentPoly' => $calledQueue ? (string)($calledQueue->poly_name ?: '-') : '-',
                'currentSource' => $currentSource,
                'currentStatus' => $calledQueue ? 'Sedang dipanggil' : 'Belum ada panggilan',
                'hasCurrent' => (bool)$calledQueue,
                'onlineTotal' => $onlineTotal,
                'onsiteTotal' => $onsiteTotal,
                'onlineWaiting' => $onlineWaiting,
                'onsiteWaiting' => $onsiteWaiting,
                'waitingQueueList' => $waitingQueuePayload,
            ];

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($payload));
        }

        $this->set(compact(
            'queues',
            'waitingQueueList',
            'stats',
            'polyclinicSummary',
            'nextQueue',
            'calledQueue',
            'calledOnlineQueue',
            'calledOnsiteQueue',
            'nextOnlineQueue',
            'nextOnsiteQueue',
            'onlineTotal',
            'onsiteTotal',
            'onlineWaiting',
            'onsiteWaiting',
            'todayLabel'
        ));
    }

    public function view($id = null)
    {
        $polyclinicQueue = $this->PolyclinicQueues->get($id, [
            'contain' => ['Registrations'],
        ]);

        // Tambahan: sumber ditampilkan dalam bentuk label.
        // Ini menjaga halaman view tetap tampil "Rujukan" walaupun template menampilkan field source langsung.
        $polyclinicQueue->source_label = $this->getSourceLabel((string)$polyclinicQueue->source);

        $this->set(compact('polyclinicQueue'));
    }

    public function pdf($id = null)
    {
        $polyclinicQueue = $this->PolyclinicQueues->get($id, [
            'contain' => ['Registrations'],
        ]);

        $pdf = $this->buildQueueTicketPdf($polyclinicQueue);
        $filename = 'Nomor Antrian ' . preg_replace('/[^A-Za-z0-9_-]+/', '-', (string)$polyclinicQueue->code) . '.pdf';

        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withStringBody($pdf);
    }

    private function buildQueueTicketPdf($queue): string
    {
        $created = !empty($queue->created)
            ? $queue->created->format('d-m-Y H:i')
            : date('d-m-Y H:i');
        $source = $this->getSourceLabel((string)$queue->source);
        $isMobileJkn = $queue->source === self::SOURCE_MOBILE_JKN;
        $visitDate = !empty($queue->visit_date) ? $queue->visit_date->format('d-m-Y') : '-';
        $checkinTime = !empty($queue->checkin_time) ? $queue->checkin_time->format('d-m-Y H:i') : '-';

        $width = 420;
        $height = 595;
        $content = '';

        $content .= "1 1 1 rg 0 0 {$width} {$height} re f\n";
        $content .= "0.12 0.16 0.22 rg\n";
        $content .= $this->pdfText('SIMRS', 24, 210, 515, true);
        $content .= $this->pdfText('Nomor Antrian Poliklinik', 13, 210, 494, true);
        $content .= $this->pdfText('NO ANTRIAN', 14, 210, 455, true);
        $content .= "0.12 0.41 0.88 rg\n";
        $content .= $this->pdfText((string)($queue->code ?: '-'), 58, 210, 385, true);
        $content .= "0.65 0.70 0.78 rg 55 305 m 365 305 l S\n";
        $content .= "0.12 0.16 0.22 rg\n";

        $rowY = 280;
        $rowGap = 20;
        $content .= $this->pdfRow('Poliklinik', (string)($queue->poly_name ?: '-'), $rowY);
        $rowY -= $rowGap;
        $content .= $this->pdfRow('Pasien', (string)($queue->patients_name ?: '-'), $rowY);
        $rowY -= $rowGap;
        $content .= $this->pdfRow('No HP', (string)($queue->no_telp ?: '-'), $rowY);
        $rowY -= $rowGap;
        $content .= $this->pdfRow('Sumber', $source, $rowY);
        $rowY -= $rowGap;

        if ($isMobileJkn) {
            $content .= $this->pdfRow('Kode Booking', (string)($queue->booking_code ?: '-'), $rowY);
            $rowY -= $rowGap;
            $content .= $this->pdfRow('NIK', (string)($queue->identity_number ?: '-'), $rowY);
            $rowY -= $rowGap;
            $content .= $this->pdfRow('No BPJS', (string)($queue->bpjs_number ?: '-'), $rowY);
            $rowY -= $rowGap;
            $content .= $this->pdfRow('Tgl Periksa', $visitDate, $rowY);
            $rowY -= $rowGap;
            $content .= $this->pdfRow('Check-in', (string)($queue->checkin_status ?: self::CHECKIN_PENDING), $rowY);
            $rowY -= $rowGap;
            $content .= $this->pdfRow('Waktu Check-in', $checkinTime, $rowY);
            $rowY -= $rowGap;
        }

        $content .= $this->pdfRow('Waktu', $created, $rowY);
        $content .= $this->pdfText('Silakan menunggu sampai nomor antrian dipanggil oleh petugas.', 11, 210, 45, true);

        return $this->makeSimplePdf($content, $width, $height);
    }

    private function pdfRow(string $label, string $value, int $y): string
    {
        return $this->pdfText($label, 12, 70, $y)
            . $this->pdfText($value, 12, 205, $y);
    }

    private function pdfText(string $text, int $size, int $x, int $y, bool $center = false): string
    {
        $text = $this->escapePdfText($text);
        $adjustedX = $center ? $x - (int)(strlen($text) * $size * 0.25) : $x;

        return "BT /F1 {$size} Tf {$adjustedX} {$y} Td ({$text}) Tj ET\n";
    }

    private function escapePdfText(string $text): string
    {
        $text = str_replace(["\\", "(", ")", "\r", "\n"], ["\\\\", "\\(", "\\)", ' ', ' '], $text);

        return $text;
    }

    private function makeSimplePdf(string $content, int $width, int $height): string
    {
        $objects = [];
        $objects[] = "<< /Type /Catalog /Pages 2 0 R >>";
        $objects[] = "<< /Type /Pages /Kids [3 0 R] /Count 1 >>";
        $objects[] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 {$width} {$height}] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>";
        $objects[] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>";
        $objects[] = "<< /Length " . strlen($content) . " >>\nstream\n{$content}endstream";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $objectNumber = $index + 1;
            $pdf .= "{$objectNumber} 0 obj\n{$object}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string)$offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    public function add()
    {
        $polyclinicQueue = $this->PolyclinicQueues->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $polyName = trim((string)($data['poly_name'] ?? ''));
            $patientId = !empty($data['patient_id']) ? (int)$data['patient_id'] : null;
            $patientName = trim((string)($data['patients_name'] ?? ''));
            $phoneNumber = trim((string)($data['no_telp'] ?? ''));
            $visitDate = $this->normalizeQueueVisitDate((string)($data['visit_date'] ?? date('Y-m-d')));
            $queueSession = (string)($data['queue_session'] ?? '');

            $medicalRecordNo = null;

            if ($patientId !== null) {
            $this->loadModel('Patients');
            $patientSchema = $this->Patients->getSchema();
            $patientSelect = ['id', 'code', 'full_name', 'identity_number', 'phone_number'];
            if ($patientSchema->hasColumn('medical_record_no')) {
                $patientSelect[] = 'medical_record_no';
            }

            $patient = $this->Patients->find()
                ->select($patientSelect)
                ->where(['Patients.id' => $patientId])
                ->first();

            if ($patient) {
                $patientName = trim((string)$patient->full_name) !== ''
                    ? trim((string)$patient->full_name)
                    : $patientName;
                $phoneNumber = trim((string)$patient->phone_number) !== ''
                    ? trim((string)$patient->phone_number)
                    : $phoneNumber;
                $medicalRecordNo = (string)($patient->medical_record_no ?? $patient->code ?? '');
            } else {
                $patientId = null;
            }
        }

        if ($polyName === '') {
            $this->Flash->error(__('Poli tujuan belum dipilih.'));
            return $this->redirect(['action' => 'add']);
        }

        if ($patientName === '') {
            $this->Flash->error(__('Nama pasien wajib diisi.'));
            return $this->redirect(['action' => 'add']);
        }

        if ($phoneNumber === '') {
            $this->Flash->error(__('No HP / WhatsApp wajib diisi.'));
            return $this->redirect(['action' => 'add']);
        }

            if (!$this->isAllowedQueueVisitDate($visitDate)) {
                $this->Flash->error(__('Tanggal kunjungan hanya boleh hari ini atau besok.'));
                return $this->redirect(['action' => 'add']);
            }

            $queueSessionError = $this->getQueueSessionErrorForVisitDate($polyName, $queueSession, $visitDate);

            if ($queueSessionError !== null) {
                $this->Flash->error(__($queueSessionError));
                return $this->redirect(['action' => 'add']);
            }

            $queueCodePrefix = $this->getKioskQueueCodePrefix($queueSession);
            $nextNumber = $this->getNextQueueNumberByCodePrefix($queueCodePrefix, $visitDate);
            $doctorInfo = $this->getDoctorForPolySession($polyName, $queueSession, $visitDate);

            $data['poly_name'] = $polyName;
            $data['patients_name'] = $patientName;
            $data['no_telp'] = $phoneNumber;
            $data['queue_number'] = $nextNumber;
            $data['code'] = $this->formatQueueCode($nextNumber, $queueCodePrefix);
            $data['source'] = self::SOURCE_WHATSAPP;
            $data['visit_date'] = $visitDate;
            $data['checkin_status'] = self::CHECKIN_PENDING;
            $data['call_status'] = self::CALL_STATUS_WAITING;
            $data['call_count'] = 0;
            $data['is_create'] = 1;
            $data['is_update'] = 0;
            $data['is_delete'] = 0; 
            $data['is_active'] = 'Y';

            if ($this->PolyclinicQueues->getSchema()->hasColumn('doctor_id')) {
                $data['doctor_id'] = $doctorInfo['doctor_id'];
            }
            if ($this->PolyclinicQueues->getSchema()->hasColumn('doctor_name')) {
                $data['doctor_name'] = $doctorInfo['doctor_name'];
            }

            if (!$this->PolyclinicQueues->getSchema()->hasColumn('patient_id')) {
                unset($data['patient_id']);
            }

            unset($data['queue_session']);

            $polyclinicQueue = $this->PolyclinicQueues->patchEntity($polyclinicQueue, $data);

            if ($patientId !== null && $this->PolyclinicQueues->getSchema()->hasColumn('patient_id')) {
                $polyclinicQueue->patient_id = $patientId;
            }

            if ($medicalRecordNo !== null && $this->PolyclinicQueues->getSchema()->hasColumn('medical_record_no')) {
                $polyclinicQueue->medical_record_no = $medicalRecordNo;
            }

            if ($this->PolyclinicQueues->save($polyclinicQueue)) {
                $this->Flash->success(__('Pendaftaran antrian poli berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            debug($polyclinicQueue->getErrors());
            $this->Flash->error(__('Pendaftaran antrian poli gagal disimpan.'));
        }

        $polyclinicButtonData = $this->getPolyclinicButtonData();

        $this->set(compact('polyclinicQueue', 'polyclinicButtonData'));
    }

    public function getPolyclinicSchedule()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $visitDate = $this->normalizeQueueVisitDate(
            (string)$this->request->getQuery('visit_date', date('Y-m-d'))
        );

        if (!$this->isAllowedQueueVisitDate($visitDate)) {
            $visitDate = date('Y-m-d');
        }

        $data = array_values($this->getPolyclinicButtonData($visitDate));

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function searchPatients()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q'));

        $this->loadModel('Patients');

        $schema = $this->Patients->getSchema();
        $selectFields = [
            'id',
            'code',
            'full_name',
            'identity_number',
            'phone_number',
            'birth_date',
            'address',
            'insurance_card_no',
        ];

        if ($schema->hasColumn('medical_record_no')) {
            $selectFields[] = 'medical_record_no';
        }

        $query = $this->Patients->find()
            ->select($selectFields)
            ->order([
                'Patients.full_name' => 'ASC',
                'Patients.id' => 'ASC',
            ])
            ->limit(15);

        if ($q !== '') {
            $searchConditions = [
                'Patients.full_name LIKE' => '%' . $q . '%',
                'Patients.code LIKE' => '%' . $q . '%',
                'Patients.identity_number LIKE' => '%' . $q . '%',
                'Patients.phone_number LIKE' => '%' . $q . '%',
            ];

            if ($schema->hasColumn('medical_record_no')) {
                $searchConditions[] = ['Patients.medical_record_no LIKE' => '%' . $q . '%'];
            }

            $query->where([
                'OR' => $searchConditions,
            ]);
        }

        $data = [];

        foreach ($query as $patient) {
            $data[] = [
                'id' => $patient->id,
                'code' => (string)($patient->medical_record_no ?? $patient->code ?? ''),
                'full_name' => (string)($patient->full_name ?? ''),
                'identity_number' => (string)($patient->identity_number ?? ''),
                'phone_number' => (string)($patient->phone_number ?? ''),
                'birth_date' => !empty($patient->birth_date) ? $patient->birth_date->format('Y-m-d') : '',
                'address' => (string)($patient->address ?? ''),
                'insurance_card_no' => (string)($patient->insurance_card_no ?? ''),
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }

    public function mobileJkn()
    {
        $polyclinicQueue = $this->PolyclinicQueues->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $nextNumber = $this->getNextQueueNumber();

            $data['queue_number'] = $nextNumber;
            $data['code'] = $this->formatQueueCode($nextNumber);
            $data['source'] = self::SOURCE_MOBILE_JKN;
            $data['checkin_status'] = $data['checkin_status'] ?? self::CHECKIN_PENDING;
            $data['checkin_time'] = null;
            $data['is_create'] = 1;
            $data['is_update'] = 0;
            $data['is_delete'] = 0;
            $data['is_active'] = 'Y';

            $polyclinicQueue = $this->PolyclinicQueues->patchEntity($polyclinicQueue, $data);

            if ($this->PolyclinicQueues->save($polyclinicQueue)) {
                $this->Flash->success(__('Antrian simulasi Mobile JKN berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Antrian simulasi Mobile JKN gagal disimpan. Periksa kembali data input.'));
        }

        $polyclinicButtonData = $this->getPolyclinicButtonData();

        $this->set(compact('polyclinicQueue', 'polyclinicButtonData'));
    }

    public function checkIn($id = null)
    {
        $this->request->allowMethod(['post']);

        $polyclinicQueue = $this->PolyclinicQueues->get($id, [
            'contain' => ['Registrations'],
        ]);

        if ($polyclinicQueue->source !== self::SOURCE_MOBILE_JKN) {
            $this->Flash->error(__('Check-in hanya tersedia untuk antrian Mobile JKN.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($polyclinicQueue->is_active !== 'Y') {
            $this->Flash->error(__('Antrian ini sudah diproses atau tidak aktif.'));

            return $this->redirect(['action' => 'index']);
        }

        if (in_array((string)$polyclinicQueue->checkin_status, ['Batal', 'Selesai'], true)) {
            $this->Flash->error(__('Antrian Mobile JKN ini tidak bisa diproses karena statusnya ' . $polyclinicQueue->checkin_status . '.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($polyclinicQueue->checkin_status !== self::CHECKIN_DONE) {
            $polyclinicQueue->checkin_status = self::CHECKIN_DONE;
            $polyclinicQueue->checkin_time = date('Y-m-d H:i:s');
            $polyclinicQueue->is_update = 1;

            if (!$this->PolyclinicQueues->save($polyclinicQueue)) {
                $this->Flash->error(__('Check-in Mobile JKN gagal diproses.'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->Flash->success(__('Check-in Mobile JKN berhasil. Silakan lanjutkan pendaftaran pasien.'));

        return $this->redirect([
            'controller' => 'Registrations',
            'action' => 'addTemp',
            '?' => [
                'queue_id' => $polyclinicQueue->id,
                'queue_number' => $polyclinicQueue->queue_number,
                'queue_code' => $polyclinicQueue->code,
                'poly_name' => $polyclinicQueue->poly_name,
            ],
        ]);
    }

    public function callQueue($id = null)
    {
        $this->request->allowMethod(['post']);

        $polyclinicQueue = $this->PolyclinicQueues->get($id, [
            'contain' => ['Registrations'],
        ]);

        if ($polyclinicQueue->is_active !== 'Y') {
            $this->Flash->error(__('Antrian ini sudah diproses atau tidak aktif.'));

            return $this->redirect(['action' => 'index']);
        }

        if (!empty($polyclinicQueue->registration)) {
            $this->Flash->error(__('Antrian ini sudah menjadi registrasi.'));

            return $this->redirect(['action' => 'index']);
        }

        $polyclinicQueue->call_status = self::CALL_STATUS_CALLED;
        $polyclinicQueue->called_time = date('Y-m-d H:i:s');
        $polyclinicQueue->call_count = ((int)($polyclinicQueue->call_count ?? 0)) + 1;
        $polyclinicQueue->is_update = 1;

        if ($this->PolyclinicQueues->save($polyclinicQueue)) {
            $this->Flash->success(__('Nomor antrian ' . $polyclinicQueue->code . ' dipanggil.'));
        } else {
            $this->Flash->error(__('Gagal memanggil nomor antrian.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null)
    {
        $polyclinicQueue = $this->PolyclinicQueues->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $data['is_update'] = 1;

            $polyclinicQueue = $this->PolyclinicQueues->patchEntity(
                $polyclinicQueue,
                $data
            );

            if ($this->PolyclinicQueues->save($polyclinicQueue)) {
                $this->Flash->success(__('The polyclinic queue has been updated.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The polyclinic queue could not be updated.'));
        }

        $this->set(compact('polyclinicQueue'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);

        $polyclinicQueue = $this->PolyclinicQueues->get($id);

        $polyclinicQueue->is_delete = 1;
        $polyclinicQueue->is_active = 'N';
        $polyclinicQueue->deleted = date('Y-m-d H:i:s');
        $polyclinicQueue->delete_log = 'Deleted by user';

        if ($this->PolyclinicQueues->save($polyclinicQueue)) {
            $this->Flash->success(__('The polyclinic queue has been deleted.'));
        } else {
            $this->Flash->error(__('The polyclinic queue could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function kiosk()
    {
        $queueNumber = null;
        $queueCode = null;
        $queueVisitDate = null;

        if ($this->request->is('post')) {
            $polyclinicName = trim((string)$this->request->getData('poly_name'));
            $queueSession = (string)$this->request->getData('queue_session');
            $queueSessionError = $this->getKioskQueueSessionError($polyclinicName, $queueSession);

            if ($queueSessionError !== null) {
                $this->Flash->error(__($queueSessionError));
            } else {
                $queueCodePrefix = $this->getKioskQueueCodePrefix($queueSession);
                $visitDate = $this->getKioskQueueVisitDate($queueSession);
                $nextNumber = $this->getNextQueueNumberByCodePrefix($queueCodePrefix, $visitDate);
                $doctorInfo = $this->getDoctorForPolySession($polyclinicName, $queueSession, $visitDate);

                $queue = $this->PolyclinicQueues->newEmptyEntity();

                $queue->code = $this->formatQueueCode($nextNumber, $queueCodePrefix);
                $queue->source = self::SOURCE_KIOSK;
                $queue->poly_name = $polyclinicName;
                $queue->queue_number = $nextNumber;
                $queue->visit_date = $visitDate;
                $queue->is_create = 1;
                $queue->is_update = 0;
                $queue->is_delete = 0;
                $queue->is_active = 'Y';

                if ($this->PolyclinicQueues->getSchema()->hasColumn('doctor_id')) {
                    $queue->doctor_id = $doctorInfo['doctor_id'];
                }
                if ($this->PolyclinicQueues->getSchema()->hasColumn('doctor_name')) {
                    $queue->doctor_name = $doctorInfo['doctor_name'];
                }

                if ($this->PolyclinicQueues->save($queue)) {
                    $queueNumber = $nextNumber;
                    $queueCode = $queue->code;
                    $queueVisitDate = $visitDate;
                }
            }
        }

        $polyclinicButtonData = $this->getPolyclinicButtonData();

        $this->set(compact(
            'queueNumber',
            'queueCode',
            'queueVisitDate',
            'polyclinicButtonData'
        ));
    }

    /** Kiosk ringkas untuk memilih sumber antrean dan sesi kunjungan. */
    public function kioskNew()
    {
        $queueCode = null;
        $queueVisitDate = null;

        if ($this->request->is('post')) {
            $sourceType = strtoupper(trim((string)$this->request->getData('queue_source')));
            $queueSession = (string)$this->request->getData('queue_session');
            $source = $sourceType === 'MJKN' ? self::SOURCE_MOBILE_JKN : ($sourceType === 'ONSITE' ? self::SOURCE_KIOSK : '');
            $error = $this->getKioskQueueSessionError('Poli Umum', $queueSession);

            // Kiosk New hanya melayani antrean untuk hari ini. Setelah sesi
            // pagi lewat, tombol pagi menampilkan peringatan dan tidak
            // dialihkan menjadi antrean untuk hari berikutnya.
            if ($error === null && $queueSession === self::QUEUE_SESSION_MORNING && date('H:i') > '14:00') {
                $error = 'Waktu antrean pagi sudah terlewat. Silakan pilih antrean sore.';
            }

            if ($source === '' || $error !== null) {
                $this->Flash->error(__($error ?: 'Jenis antrean tidak valid.'));
            } else {
                $visitDate = date('Y-m-d');
                $prefix = $this->getKioskQueueCodePrefix($queueSession);
                $nextNumber = $this->getNextQueueNumberByCodePrefix($prefix, $visitDate);
                $queue = $this->PolyclinicQueues->newEmptyEntity();
                $queue->code = $this->formatQueueCode($nextNumber, $prefix);
                $queue->source = $source;
                $queue->poly_name = 'Poli Umum';
                $queue->queue_number = $nextNumber;
                $queue->visit_date = $visitDate;
                $queue->is_create = 1;
                $queue->is_update = 0;
                $queue->is_delete = 0;
                $queue->is_active = 'Y';
                $queue->checkin_status = self::CHECKIN_PENDING;
                $queue->call_status = self::CALL_STATUS_WAITING;
                if ($this->PolyclinicQueues->save($queue)) {
                    $queueCode = $queue->code;
                    $queueVisitDate = $visitDate;
                } else {
                    $this->Flash->error(__('Nomor antrean gagal dibuat.'));
                }
            }
        }

        $this->set(compact('queueCode', 'queueVisitDate'));
        $this->viewBuilder()->setTemplate('kiosk_new');
    }

private function getPolyclinicButtonData(?string $visitDate = null): array
{
    $visitDate = $visitDate ?: date('Y-m-d');
    $isToday = $visitDate === date('Y-m-d');

    $polyclinics = $this->getPolyclinicOptions();
        $queueTotals = [];
        $doctorNames = [];

        $queueRows = $this->PolyclinicQueues->find()
            ->select([
                'poly_name',
                'total' => $this->PolyclinicQueues->find()->func()->count('*'),
            ]);
        $queueRows = $this->applyQueueVisitDateFilter($queueRows, $visitDate)
            ->group(['poly_name'])
            ->enableHydration(false)
            ->toArray();

        foreach ($queueRows as $row) {
            $queueTotals[(string)$row['poly_name']] = (int)$row['total'];
        }

        $this->loadModel('DoctorSchedules');
        $scheduleRows = $this->DoctorSchedules->find()
            ->contain([
                'Doctors',
            ])
            ->where([
                'DoctorSchedules.day IN' => $this->getDayLabelsForDate($visitDate),
            ])
            ->order([
                'DoctorSchedules.start_time' => 'ASC',
                'DoctorSchedules.id' => 'ASC',
            ])
            ->all();

        $normalizePolyName = static function (string $value): string {
            return mb_strtolower(trim($value));
        };

        $polyHasScheduleNow = [];
        $polySessionData = [];        
        $polySessionAvailableNow = []; 

        foreach ($scheduleRows as $schedule) {
            $isScheduleActive = in_array($schedule->is_active ?? null, ['Y', 1, '1', true], true);

            if (!$isScheduleActive) {
                continue;
            }

            $doctor = $schedule->doctor ?? null;
            $rawPolyName = $doctor ? (string)($doctor->polyclinic_name ?? '') : '';
            $doctorName = $doctor ? (string)$doctor->doctor_name : '';

            if (trim($rawPolyName) === '' || $doctorName === '') {
                continue;
            }

            $polyKey = $normalizePolyName($rawPolyName);

            if (!isset($doctorNames[$polyKey])) {
                $doctorNames[$polyKey] = [];
            }

            if (!in_array($doctorName, $doctorNames[$polyKey], true)) {
                $doctorNames[$polyKey][] = $doctorName;
            }

            $startTime = $this->formatScheduleTime($schedule->start_time ?? null);
            $endTime = $this->formatScheduleTime($schedule->end_time ?? null);

            if ($startTime === null || $endTime === null) {
                continue;
            }

            $session = ($startTime < '12:00') ? 'morning' : 'afternoon';

            if (!isset($polySessionData[$polyKey])) {
                $polySessionData[$polyKey] = ['morning' => [], 'afternoon' => []];
            }

            $polySessionData[$polyKey][$session][] = [
                'doctor_id' => $schedule->doctor_id,
                'doctor_name' => $doctorName,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        }
       $currentTime = date('H:i');
        $kioskOpenTime = '07:00';       
        $defaultMorningClose = '14:00'; 
        $defaultAfternoonClose = '20:00'; 

        foreach ($polySessionData as $polyKey => $sessionsForPoly) {
            $polySessionAvailableNow[$polyKey] = ['morning' => false, 'afternoon' => false];

           if (!empty($sessionsForPoly['morning'])) {
    $morningClose = null;

    foreach ($sessionsForPoly['morning'] as $sch) {
        if ($morningClose === null || $sch['end_time'] > $morningClose) {
            $morningClose = $sch['end_time'];
        }
    }

    $morningClose = $morningClose ?? $defaultMorningClose;

    $polySessionAvailableNow[$polyKey]['morning'] = $isToday
        ? ($currentTime >= $kioskOpenTime && $currentTime <= $morningClose)
        : true;
    }

        if (!empty($sessionsForPoly['afternoon'])) {
            $afternoonClose = null;

            foreach ($sessionsForPoly['afternoon'] as $sch) {
                if ($afternoonClose === null || $sch['end_time'] > $afternoonClose) {
                    $afternoonClose = $sch['end_time'];
                }
            }

            $afternoonClose = $afternoonClose ?? $defaultAfternoonClose;
            $afternoonClose = min($afternoonClose, self::KIOSK_MAX_ADMISSION_TIME);

            $polySessionAvailableNow[$polyKey]['afternoon'] = $isToday
                ? ($currentTime >= $kioskOpenTime && $currentTime <= $afternoonClose)
                : true;
        }

            $polyHasScheduleNow[$polyKey] = !empty($sessionsForPoly['morning']) || !empty($sessionsForPoly['afternoon']);
        }

        $buttonData = [];

            foreach ($polyclinics as $value => $label) {
            $polyName = (string)$value;
            $polyKey = $normalizePolyName($polyName);

            $buttonData[$polyName] = [
                'value' => $polyName,
                'label' => (string)$label,
                'doctor' => !empty($doctorNames[$polyKey])
                    ? implode(', ', $doctorNames[$polyKey])
                    : 'Dokter belum tersedia',
                'total' => $queueTotals[$polyName] ?? 0,
                'is_featured' => strtolower($polyName) === 'poli umum',
                'has_schedule' => !empty($polyHasScheduleNow[$polyKey]),
                'sessions' => $polySessionData[$polyKey] ?? ['morning' => [], 'afternoon' => []],
                'morning_available' => !empty($polySessionAvailableNow[$polyKey]['morning']),
                'afternoon_available' => !empty($polySessionAvailableNow[$polyKey]['afternoon']),
            ];
        }

        return $buttonData;
    }

    private function getPolyclinicOptions(): array
    {
        return [
            'Poli Umum' => 'Poli Umum',
            'Poli Kandungan' => 'Poli Kandungan',
            'Poli Anak' => 'Poli Anak',
            'Poli Penyakit Dalam' => 'Poli Penyakit Dalam (Internis)',
            'Poli Bedah Umum' => 'Poli Bedah Umum',
            'Poli Rehab Medik' => 'Poli Rehab Medik',
            'Poli Saraf' => 'Poli Saraf',
            'Poli THT' => 'Poli THT',
            'Poli Urologi' => 'Poli Urologi',
            'Poli Paru' => 'Poli Paru',
            'Poli Orthopedi' => 'Poli Orthopedi',
            'Poli Gigi Konservasi' => 'Poli Gigi Konservasi / Endodonsi',
            'Poli Gigi Bedah Mulut' => 'Poli Gigi & Bedah Mulut',
            'Poli Jantung' => 'Poli Jantung & Pembuluh Darah',
            'Poli Jiwa' => 'Poli Jiwa',
            'Poli Kulit Kelamin' => 'Poli Kulit & Kelamin',
            'Poli Mata' => 'Poli Mata',
            'PPDP' => 'PPDP',
            'Executive' => 'Executive',
            'Bidan/KIA' => 'Bidan/KIA',
        ];
    }

    private function getDayLabelsForDate(string $date): array
    {
        $timestamp = strtotime($date);
        $englishDay = $timestamp ? date('l', $timestamp) : date('l');

        $map = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $indonesianDay = $map[$englishDay] ?? $englishDay;

        return array_values(array_unique([
            $englishDay,
            strtolower($englishDay),
            $indonesianDay,
            strtolower($indonesianDay),
        ]));
    }

    private function getTodayDayLabels(): array
    {
        $englishDay = date('l');
        $map = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $indonesianDay = $map[$englishDay] ?? $englishDay;

        return array_values(array_unique([
            $englishDay,
            strtolower($englishDay),
            $indonesianDay,
            strtolower($indonesianDay),
        ]));
    }

    private function applyQueueVisitDateFilter($query, string $visitDate)
    {
        $startDate = $visitDate . ' 00:00:00';
        $endDate = $visitDate . ' 23:59:59';

        return $query->where(function ($expression) use ($visitDate, $startDate, $endDate) {
            return $expression->or_([
                'PolyclinicQueues.visit_date' => $visitDate,
                $expression->and_([
                    'PolyclinicQueues.visit_date IS' => null,
                    'PolyclinicQueues.created >=' => $startDate,
                    'PolyclinicQueues.created <=' => $endDate,
                ]),
            ]);
        });
    }

    private function getKioskQueueSessionError(string $polyclinicName, string $queueSession): ?string
    {
        if ($polyclinicName === '') {
            return 'Silakan pilih poli tujuan terlebih dahulu.';
        }

        $currentTime = date('H:i');

        if ($queueSession === self::QUEUE_SESSION_MORNING) {
            if ($currentTime < '07:00') {
                return 'Antrian pagi dapat diambil mulai pukul 07:00.';
            }

            return null;
        }

        if ($queueSession === self::QUEUE_SESSION_AFTERNOON) {
            $polyclinicCloseTime = $this->getTodayPolyclinicCloseTime($polyclinicName);

            if ($currentTime < '07:00') {
                return 'Antrian sore hanya dapat diambil mulai pukul 07:00.';
            }

            if ($polyclinicCloseTime !== null && $currentTime > $polyclinicCloseTime) {
                return 'Antrian sore hanya dapat diambil sampai poli tutup.';
            }

            return null;
        }

        return 'Silakan pilih sesi antrian pagi atau sore.';
    }

    private function getKioskQueueCodePrefix(string $queueSession): string
    {
        if ($queueSession === self::QUEUE_SESSION_AFTERNOON) {
            return self::QUEUE_CODE_PREFIX_AFTERNOON;
        }

        return self::QUEUE_CODE_PREFIX_MORNING;
    }

    private function getQueueSessionErrorForVisitDate(string $polyclinicName, string $queueSession, string $visitDate): ?string
    {
        if (!in_array($queueSession, [self::QUEUE_SESSION_MORNING, self::QUEUE_SESSION_AFTERNOON], true)) {
            return 'Silakan pilih sesi antrian pagi atau sore.';
        }

        if ($visitDate !== date('Y-m-d')) {
            return null;
        }

        $currentTime = date('H:i');

        if ($currentTime < '07:00') {
            return 'Antrian dapat dibuat mulai pukul 07:00.';
        }

        if ($queueSession === self::QUEUE_SESSION_MORNING && $currentTime > '14:00') {
            return 'Antrian pagi untuk hari ini sudah lewat. Silakan pilih tanggal besok.';
        }

        if ($queueSession === self::QUEUE_SESSION_AFTERNOON) {
            $polyclinicCloseTime = $this->getTodayPolyclinicCloseTime($polyclinicName);

            if ($polyclinicCloseTime !== null && $currentTime > $polyclinicCloseTime) {
                return 'Antrian sore hanya dapat dibuat sampai poli tutup.';
            }
        }

        return null;
    }

    private function getKioskQueueVisitDate(string $queueSession): string
    {
        if ($queueSession === self::QUEUE_SESSION_MORNING && date('H:i') > '14:00') {
            return date('Y-m-d', strtotime('+1 day'));
        }

        return date('Y-m-d');
    }

    private function isAllowedQueueVisitDate(string $visitDate): bool
    {
        return in_array($visitDate, [
            date('Y-m-d'),
            date('Y-m-d', strtotime('+1 day')),
        ], true);
    }

    private function normalizeQueueVisitDate(string $visitDate): string
    {
        $visitDate = trim($visitDate);

        foreach (['Y-m-d', 'd-m-Y'] as $format) {
            $date = \DateTimeImmutable::createFromFormat('!' . $format, $visitDate);

            if ($date !== false && $date->format($format) === $visitDate) {
                return $date->format('Y-m-d');
            }
        }

        return $visitDate;
    }

    private function getTodayPolyclinicCloseTime(string $polyclinicName): ?string
    {
        $this->loadModel('DoctorSchedules');

        $scheduleRows = $this->DoctorSchedules->find()
            ->contain([
                'Doctors',
            ])
            ->where([
                'DoctorSchedules.day IN' => $this->getTodayDayLabels(),
                'DoctorSchedules.is_active' => 'Y',
            ])
            ->all();

        $closeTime = null;

        foreach ($scheduleRows as $schedule) {
            $doctor = $schedule->doctor ?? null;
            $schedulePolyName = $doctor ? (string)($doctor->polyclinic_name ?? '') : '';

            if ($schedulePolyName !== $polyclinicName) {
                continue;
            }

            $endTime = $this->formatScheduleTime($schedule->end_time ?? null);

            if ($endTime === null) {
                continue;
            }

            if ($closeTime === null || $endTime > $closeTime) {
                $closeTime = $endTime;
            }
        }

        if ($closeTime !== null && $closeTime > self::KIOSK_MAX_ADMISSION_TIME) {
            $closeTime = self::KIOSK_MAX_ADMISSION_TIME;
        }

        return $closeTime;
    }

        private function getDoctorForPolySession(string $polyName, string $session, string $visitDate): array
    {
        $this->loadModel('DoctorSchedules');

        $scheduleRows = $this->DoctorSchedules->find()
            ->contain(['Doctors'])
            ->where([
                'DoctorSchedules.day IN' => $this->getDayLabelsForDate($visitDate),
                'DoctorSchedules.is_active' => 'Y',
            ])
            ->order(['DoctorSchedules.start_time' => 'ASC'])
            ->all();

        $normalizePolyName = static function (string $value): string {
            return mb_strtolower(trim($value));
        };
        $targetPolyKey = $normalizePolyName($polyName);

        $candidates = [];

        foreach ($scheduleRows as $schedule) {
            $doctor = $schedule->doctor ?? null;

            if (!$doctor) {
                continue;
            }

            $schedulePolyKey = $normalizePolyName((string)($doctor->polyclinic_name ?? ''));

            if ($schedulePolyKey !== $targetPolyKey) {
                continue;
            }

            $startTime = $this->formatScheduleTime($schedule->start_time ?? null);
            $endTime = $this->formatScheduleTime($schedule->end_time ?? null);

            if ($startTime === null || $endTime === null) {
                continue;
            }

            $scheduleSession = ($startTime < '12:00') ? self::QUEUE_SESSION_MORNING : self::QUEUE_SESSION_AFTERNOON;

            if ($scheduleSession !== $session) {
                continue;
            }

            $candidates[] = [
                'doctor_id' => $schedule->doctor_id,
                'doctor_name' => (string)$doctor->doctor_name,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        }

        if (empty($candidates)) {
            return ['doctor_id' => null, 'doctor_name' => null];
        }

        // Kalau kunjungannya untuk hari ini, cocokkan ke dokter yang jam
        // praktiknya mencakup waktu sekarang.
        if ($visitDate === date('Y-m-d')) {
            $currentTime = date('H:i');

            foreach ($candidates as $candidate) {
                if ($currentTime >= $candidate['start_time'] && $currentTime <= $candidate['end_time']) {
                    return [
                        'doctor_id' => $candidate['doctor_id'],
                        'doctor_name' => $candidate['doctor_name'],
                    ];
                }
            }
        }

        // Fallback: dokter pertama di sesi tersebut.
        return [
            'doctor_id' => $candidates[0]['doctor_id'],
            'doctor_name' => $candidates[0]['doctor_name'],
        ];
    }

    private function formatScheduleTime($timeValue): ?string
    {
        if (empty($timeValue)) {
            return null;
        }

        if (is_object($timeValue) && method_exists($timeValue, 'format')) {
            return $timeValue->format('H:i');
        }

        $timestamp = strtotime((string)$timeValue);

        if ($timestamp === false) {
            return null;
        }

        return date('H:i', $timestamp);
    }

    private function getNextQueueNumber(): int
    {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');

        $lastQueue = $this->PolyclinicQueues
            ->find()
            ->where([
                'created >=' => $startDate,
                'created <=' => $endDate
            ])
            ->order([
                'queue_number' => 'DESC'
            ])
            ->first();

        return $lastQueue ? ((int)$lastQueue->queue_number + 1) : 1;
    }


    private function getNextQueueNumberByPoly(string $polyName, ?string $visitDate = null): int
    {
        $visitDate = $visitDate ?: date('Y-m-d');
        $startDate = $visitDate . ' 00:00:00';
        $endDate = $visitDate . ' 23:59:59';

        $lastQueue = $this->PolyclinicQueues
            ->find()
            ->where([
                'PolyclinicQueues.poly_name' => $polyName,
                'PolyclinicQueues.is_active' => 'Y',
            ])
            ->where(function ($expression) use ($visitDate, $startDate, $endDate) {
                return $expression->or_([
                    'PolyclinicQueues.visit_date' => $visitDate,
                    $expression->and_([
                        'PolyclinicQueues.visit_date IS' => null,
                        'PolyclinicQueues.created >=' => $startDate,
                        'PolyclinicQueues.created <=' => $endDate,
                    ]),
                ]);
            })
            ->order([
                'PolyclinicQueues.queue_number' => 'DESC',
                'PolyclinicQueues.id' => 'DESC',
            ])
            ->first();

        return $lastQueue ? ((int)$lastQueue->queue_number + 1) : 1;
    }

    private function getNextQueueNumberByCodePrefix(string $codePrefix, ?string $visitDate = null): int
    {
        $visitDate = $visitDate ?: date('Y-m-d');
        $startDate = $visitDate . ' 00:00:00';
        $endDate = $visitDate . ' 23:59:59';

        $lastQueue = $this->PolyclinicQueues
            ->find()
            ->where([
                'PolyclinicQueues.code LIKE' => $codePrefix . '-%',
            ])
            ->where(function ($expression) use ($visitDate, $startDate, $endDate) {
                return $expression->or_([
                    'PolyclinicQueues.visit_date' => $visitDate,
                    $expression->and_([
                        'PolyclinicQueues.visit_date IS' => null,
                        'PolyclinicQueues.created >=' => $startDate,
                        'PolyclinicQueues.created <=' => $endDate,
                    ]),
                ]);
            })
            ->order([
                'PolyclinicQueues.queue_number' => 'DESC',
                'PolyclinicQueues.id' => 'DESC',
            ])
            ->first();

        return $lastQueue ? ((int)$lastQueue->queue_number + 1) : 1;
    }

    private function formatQueueCode(int $queueNumber, string $codePrefix = self::QUEUE_CODE_PREFIX_MORNING): string
    {
        return $codePrefix . '-' . str_pad((string)$queueNumber, 3, '0', STR_PAD_LEFT);
    }

    private function getSourceLabel(string $source): string
    {
        $sourceLower = strtolower(trim($source));

        if (in_array($sourceLower, ['wa', 'whatsapp'], true)) {
            return 'WhatsApp';
        }

        if ($source === self::SOURCE_MOBILE_JKN) {
            return self::SOURCE_MOBILE_JKN;
        }

        if (in_array($sourceLower, ['rujukan', 'emr rujuk', 'emr_rujuk', 'emr rujukan'], true)) {
            return 'Rujukan';
        }

        if ($source === self::SOURCE_KIOSK) {
            return 'Manual';
        }

        return $source !== '' ? $source : 'Manual';
    }


    public function createReferralQueue()
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $polyName = trim((string)$this->request->getData('poly_name'));
        $patientName = trim((string)$this->request->getData('patient_name'));
        $phoneNumber = trim((string)$this->request->getData('phone_number'));
        $visitDate = trim((string)$this->request->getData('visit_date'));
        $doctorName = trim((string)$this->request->getData('doctor_name'));
        
        if ($polyName === '') {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Poliklinik belum dipilih.',
                ]));
        }

        if ($visitDate === '') {
            $visitDate = date('Y-m-d');
        }

        $nextNumber = $this->getNextQueueNumberByPoly($polyName, $visitDate);

        $queue = $this->PolyclinicQueues->newEmptyEntity();

        $queueData = [
            'code' => $this->formatQueueCode($nextNumber),
            'source' => self::SOURCE_EMR_RUJUK,
            'poly_name' => $polyName,
            'patients_name' => $patientName,
            'no_telp' => $phoneNumber,
            'queue_number' => $nextNumber,
            'visit_date' => $visitDate,
            'checkin_status' => self::CHECKIN_PENDING,
            'checkin_time' => null,
            'call_status' => self::CALL_STATUS_WAITING,
            'called_time' => null,
            'call_count' => 0,
            'is_create' => 1,
            'is_update' => 0,
            'is_delete' => 0,
            'is_active' => 'Y',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        ];

        $queue = $this->PolyclinicQueues->patchEntity($queue, $queueData);

        // Dipaksa lagi supaya tidak ketimpa default/source lama.
        $queue->source = self::SOURCE_EMR_RUJUK;

        if (!$this->PolyclinicQueues->save($queue)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Gagal membuat antrian.',
                    'errors' => $queue->getErrors(),
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'id' => $queue->id,
                'code' => $queue->code,
                'queue_number' => $queue->queue_number,
                'poly_name' => $queue->poly_name,
                'source' => $queue->source,
                'source_label' => $this->getSourceLabel((string)$queue->source),
                'message' => 'Antrian berhasil dibuat.',
            ]));
    }

    public function searchPoly()
    {
        // Alias lama, biar kalau masih ada JS yang memanggil searchPoly tetap jalan.
        return $this->searchPolyQueue();
    }

    public function searchPolyQueue()
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        $q = trim((string)$this->request->getQuery('q'));
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');

        // Sumber pilihan poli dari helper statis, bukan dari data antrian.
        // Jadi meskipun poli belum pernah ada di polyclinic_queues, tetap muncul dan nomor antri mulai dari 1.
        $polyclinics = $this->getPolyclinicOptions();
        $data = [];

        foreach ($polyclinics as $polyName => $label) {
            $polyName = (string)$polyName;
            $label = (string)$label;

            if ($q !== '' && stripos($polyName, $q) === false && stripos($label, $q) === false) {
                continue;
            }

            $lastQueue = $this->PolyclinicQueues->find()
                ->where([
                    'PolyclinicQueues.poly_name' => $polyName,
                    'PolyclinicQueues.created >=' => $todayStart,
                    'PolyclinicQueues.created <=' => $todayEnd,
                    'PolyclinicQueues.is_active' => 'Y',
                ])
                ->order([
                    'PolyclinicQueues.queue_number' => 'DESC',
                    'PolyclinicQueues.id' => 'DESC',
                ])
                ->first();

            $nextQueue = !empty($lastQueue)
                ? ((int)$lastQueue->queue_number + 1)
                : 1;

            $data[] = [
                'poly_name' => $polyName,
                'name' => $label,
                'nama' => $label,
                'queue_number' => $nextQueue,
                'queue_code' => $this->formatQueueCode($nextQueue),
            ];
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(array_values($data)));
    }
}
