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
    private const CHECKIN_PENDING = 'Belum Check-in';
    private const CHECKIN_DONE = 'Sudah Check-in';
    private const CALL_STATUS_WAITING = 'Menunggu';
    private const CALL_STATUS_CALLED = 'Dipanggil';

    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('PolyclinicQueues');
    }

    public function index()
    {
        $key = $this->request->getQuery('key');

        //Reset setiap hari tampilan antrian
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        $query = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where([
                'PolyclinicQueues.created >=' => $todayStart,
                'PolyclinicQueues.created <=' => $todayEnd,
            ]);

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

        $this->paginate = [
            'order' => [
                'PolyclinicQueues.id' => 'DESC'
            ]
        ];

        $polyclinicQueues = $this->paginate($query);

        $this->set(compact('polyclinicQueues'));
    }

    public function display()
    {
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');

        $queues = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where([
                'PolyclinicQueues.created >=' => $todayStart,
                'PolyclinicQueues.created <=' => $todayEnd,
            ])
            ->order([
                'PolyclinicQueues.queue_number' => 'ASC',
                'PolyclinicQueues.id' => 'ASC',
            ])
            ->limit(60)
            ->all();

        $calledQueueConditions = [
            'PolyclinicQueues.created >=' => $todayStart,
            'PolyclinicQueues.created <=' => $todayEnd,
            'PolyclinicQueues.call_status' => self::CALL_STATUS_CALLED,
            'PolyclinicQueues.called_time IS NOT' => null,
        ];

        $calledQueue = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where($calledQueueConditions)
            ->order([
                'PolyclinicQueues.called_time' => 'DESC',
                'PolyclinicQueues.id' => 'DESC',
            ])
            ->first();

        $calledOnlineQueue = $this->PolyclinicQueues->find()
            ->contain(['Registrations'])
            ->where($calledQueueConditions + [
                'PolyclinicQueues.source' => self::SOURCE_MOBILE_JKN,
            ])
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
            })
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

        foreach ($queues as $queue) {
            $stats['total']++;
            $polyName = (string)($queue->poly_name ?: 'Poli Tidak Diketahui');
            $isOnlineQueue = $queue->source === self::SOURCE_MOBILE_JKN;
            $isWaitingQueue = empty($queue->registration)
                && $queue->is_active === 'Y'
                && $queue->call_status !== self::CALL_STATUS_CALLED;

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
            ];

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($payload));
        }

        $this->set(compact(
            'queues',
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

            $nextNumber = $this->getNextQueueNumber();

            $data['queue_number'] = $nextNumber;

            $data['code'] = $this->formatQueueCode($nextNumber);

            // SOURCE WA
            $data['source'] = self::SOURCE_WHATSAPP;

            $data['is_create'] = 1;
            $data['is_update'] = 0;
            $data['is_delete'] = 0;
            $data['is_active'] = 'Y';

            $polyclinicQueue = $this->PolyclinicQueues
                ->patchEntity($polyclinicQueue, $data);

            if ($this->PolyclinicQueues->save($polyclinicQueue)) {

                $this->Flash->success(
                    __('Pendaftaran WA berhasil.')
                );

                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(
                __('Pendaftaran WA gagal.')
            );
        }

        $polyclinicButtonData = $this->getPolyclinicButtonData();

        $this->set(compact(
            'polyclinicQueue',
            'polyclinicButtonData'
        ));
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
            'action' => 'add',
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

        if ($this->request->is('post')) {
            $polyclinicName = $this->request->getData('poly_name');

            $nextNumber = $this->getNextQueueNumber();

            $queue = $this->PolyclinicQueues->newEmptyEntity();

            $queue->code = $this->formatQueueCode($nextNumber);
            $queue->source = self::SOURCE_KIOSK;
            $queue->poly_name = $polyclinicName;
            $queue->queue_number = $nextNumber;
            $queue->is_create = 1;
            $queue->is_update = 0;
            $queue->is_delete = 0;
            $queue->is_active = 'Y';

            if ($this->PolyclinicQueues->save($queue)) {
                $queueNumber = $nextNumber;
                $queueCode = $queue->code;
            }
        }

        $polyclinicButtonData = $this->getPolyclinicButtonData();

        $this->set(compact(
            'queueNumber',
            'queueCode',
            'polyclinicButtonData'
        ));
    }

    private function getPolyclinicButtonData(): array
    {
        $polyclinics = $this->getPolyclinicOptions();
        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd = date('Y-m-d 23:59:59');
        $queueTotals = [];
        $doctorNames = [];

        $queueRows = $this->PolyclinicQueues->find()
            ->select([
                'poly_name',
                'total' => $this->PolyclinicQueues->find()->func()->count('*'),
            ])
            ->where([
                'created >=' => $todayStart,
                'created <=' => $todayEnd,
            ])
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
                'DoctorSchedules.day IN' => $this->getTodayDayLabels(),
                'DoctorSchedules.is_active' => 'Y',
            ])
            ->order([
                'DoctorSchedules.start_time' => 'ASC',
                'DoctorSchedules.id' => 'ASC',
            ])
            ->all();

        foreach ($scheduleRows as $schedule) {
            $doctor = $schedule->doctor ?? null;
            $polyName = $doctor ? (string)($doctor->polyclinic_name ?? '') : '';
            $doctorName = $doctor ? (string)$doctor->doctor_name : '';

            if ($polyName === '' || $doctorName === '') {
                continue;
            }

            if (!isset($doctorNames[$polyName])) {
                $doctorNames[$polyName] = [];
            }

            if (!in_array($doctorName, $doctorNames[$polyName], true)) {
                $doctorNames[$polyName][] = $doctorName;
            }
        }

        $buttonData = [];

        foreach ($polyclinics as $value => $label) {
            $polyName = (string)$value;
            $buttonData[$polyName] = [
                'value' => $polyName,
                'label' => (string)$label,
                'doctor' => !empty($doctorNames[$polyName])
                    ? implode(', ', $doctorNames[$polyName])
                    : 'Dokter belum tersedia',
                'total' => $queueTotals[$polyName] ?? 0,
                'is_featured' => strtolower($polyName) === 'poli umum',
            ];
        }

        return $buttonData;
    }

    private function getPolyclinicOptions(): array
    {
        return [
            'Poli Umum' => 'Poli Umum',
            'Poli Gigi' => 'Poli Gigi',
            'Poli Anak' => 'Poli Anak',
            'Poli Kandungan' => 'Poli Kandungan',
            'Poli Penyakit Dalam' => 'Poli Penyakit Dalam',
            'Poli Mata' => 'Poli Mata',
            'Poli THT' => 'Poli THT',
            'Poli Bedah' => 'Poli Bedah',
            'Poli Saraf' => 'Poli Saraf',
            'Poli Kulit' => 'Poli Kulit',
            'Poli Jantung' => 'Poli Jantung',
        ];
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

    private function formatQueueCode(int $queueNumber): string
    {
        return 'A-' . str_pad((string)$queueNumber, 3, '0', STR_PAD_LEFT);
    }

    private function getSourceLabel(string $source): string
    {
        if (in_array(strtolower($source), ['wa', 'whatsapp'], true)) {
            return 'WhatsApp';
        }

        if ($source === self::SOURCE_MOBILE_JKN) {
            return self::SOURCE_MOBILE_JKN;
        }

        if ($source === self::SOURCE_KIOSK) {
            return 'Manual';
        }

        return $source !== '' ? $source : 'Manual';
    }

    // public function wa()
    // {
    //     $polyclinicQueue = $this->PolyclinicQueues->newEmptyEntity();

    //     if ($this->request->is('post')) {
    //         $data = $this->request->getData();

    //         $polyclinicName = $data['polyclinic_name'];

    //         $lastQueue = $this->PolyclinicQueues
    //             ->find()
    //             ->order([
    //                 'queue_number' => 'DESC'
    //             ])
    //             ->first();

    //         $nextNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

    //         $nextNumber = $lastQueue ? $lastQueue->queue_number + 1 : 1;

    //         $data['code'] = 'A-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    //         $data['source'] = 'WA';
    //         $data['queue_number'] = $nextNumber;
    //         $data['is_create'] = 1;
    //         $data['is_update'] = 0;
    //         $data['is_delete'] = 0;
    //         $data['is_active'] = 'Y';

    //         $polyclinicQueue = $this->PolyclinicQueues->patchEntity(
    //             $polyclinicQueue,
    //             $data
    //         );

    //         if ($this->PolyclinicQueues->save($polyclinicQueue)) {
    //             $this->Flash->success(__('Pendaftaran antrean via WA berhasil.'));

    //             return $this->redirect(['action' => 'index']);
    //         }

    //         $this->Flash->error(__('Pendaftaran antrean via WA gagal.'));
    //     }

    //     $this->set(compact('polyclinicQueue'));
    // }
}
