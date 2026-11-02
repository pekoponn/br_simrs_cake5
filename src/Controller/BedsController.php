<?php
declare(strict_types=1);

namespace App\Controller;

class BedsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        if ($this->components()->has('Security')) {
            $this->Security->setConfig('unlockedActions', [
                'updateStatus',
                'searchPatients',
                'getNextTt',
            ]);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // HELPER: Hitung info BPJS — hari rawat, overdue, biaya lebih
    // Dipanggil dari view / detail untuk menampilkan status BPJS.
    // Mengembalikan array atau null jika bukan pasien BPJS.
    // ─────────────────────────────────────────────────────────────
    public static function calcBpjsInfo(
    ?string $payerType,
    ?int    $bpjsLimitDays,
            $checkInDate,
            $plannedCheckOutDate,
    float   $tarifHari = 0
): ?array {
        if (strtoupper((string)$payerType) !== 'BPJS') {
            return null;
        }

        $limitDays = $bpjsLimitDays ?? 3;

        // Hitung hari rawat aktual (dari check_in sampai sekarang / planned keluar)
        $inTs = null;
        if (!empty($checkInDate)) {
            $inTs = is_string($checkInDate)
                ? strtotime($checkInDate)
                : strtotime((string)$checkInDate);
        }

        $todayTs        = mktime(0, 0, 0, (int)date('n'), (int)date('j'), (int)date('Y'));
        $hariRawatAktual = $inTs ? (int)floor(($todayTs - mktime(0,0,0,
                (int)date('n', $inTs), (int)date('j', $inTs), (int)date('Y', $inTs))) / 86400) : 0;

        // Hitung hari rencana keluar dari check_in
        $hariRencanaDari  = null;
        $plannedTs        = null;
        if (!empty($plannedCheckOutDate)) {
            $plannedTs = is_string($plannedCheckOutDate)
                ? strtotime($plannedCheckOutDate)
                : strtotime((string)$plannedCheckOutDate);
            if ($inTs && $plannedTs) {
                $hariRencanaDari = (int)floor(($plannedTs - mktime(0,0,0,
                        (int)date('n', $inTs), (int)date('j', $inTs), (int)date('Y', $inTs))) / 86400);
            }
        }

        // Hari yang ditanggung BPJS = min(hari rencana, limit)
        $hariDitanggung = min($hariRawatAktual, $limitDays);

        // Hari overdue (melebihi batas BPJS)
        $hariOverdue = max(0, $hariRawatAktual - $limitDays);

        // Biaya overdue
        $biayaOverdue = $hariOverdue * $tarifHari;

        // Status warna
        if ($hariRawatAktual > $limitDays) {
            $alertLevel = 'danger';   // sudah melewati batas
        } elseif ($hariRawatAktual === $limitDays) {
            $alertLevel = 'warning';  // tepat di batas
        } elseif ($hariRawatAktual >= ($limitDays - 1)) {
            $alertLevel = 'info';     // 1 hari lagi batas
        } else {
            $alertLevel = 'success';  // masih aman
        }

        return [
            'limit_days'           => $limitDays,
            'hari_rawat_aktual'    => $hariRawatAktual,
            'hari_ditanggung'      => $hariDitanggung,
            'hari_overdue'         => $hariOverdue,
            'biaya_overdue'        => $biayaOverdue,
            'tarif_hari'           => $tarifHari,
            'alert_level'          => $alertLevel,
            'planned_check_out_ts' => $plannedTs,
        ];
    }

    /**
     * Buat catatan otomatis berdasarkan status.
     */
    private function buildAutoNotes(int $statusAfter, int $statusBefore, ?string $patientName, string $now): ?string
    {
        $tgl = date('d-m-Y H:i', strtotime($now));

        if ($statusAfter === 1) {
            $nama = !empty($patientName) ? $patientName : 'pasien';
            return "Pasien {$nama} masuk pada {$tgl} WIB";
        }

        if ($statusAfter === 0) {
            if ($statusBefore === 1 && !empty($patientName)) {
                return "Pasien {$patientName} keluar pada {$tgl} WIB";
            }
            return "Bed tersedia sejak {$tgl} WIB";
        }

        return null;
    }

    // ─────────────────────────────────────────────────────────────
    // AUTO-ARCHIVE JADWAL MAKAN
    // ─────────────────────────────────────────────────────────────
    private function archivePatientMealSchedules(
        ?int    $patientId,
        ?string $patientName,
        int     $statusBefore,
        int     $statusAfter
    ): void {
        if ($statusBefore !== 1) {
            return;
        }

        if (empty($patientId) && empty($patientName)) {
            return;
        }

        try {
            $this->NutritionMealSchedules = $this->fetchTable('NutritionMealSchedules');

            $statusLabels = [
                0 => 'Tersedia',
                1 => 'Terisi',
                2 => 'Dibersihkan',
                3 => 'Maintenance',
            ];
            $statusAfterLabel = $statusLabels[$statusAfter] ?? "Status {$statusAfter}";

            $reason = "Bed berubah status menjadi {$statusAfterLabel}"
                    . (!empty($patientName) ? " (pasien: {$patientName})" : '');

            $now   = date('Y-m-d H:i:s');
            $today = date('Y-m-d');

            $conditions = [
                'NutritionMealSchedules.is_archived' => 0,
                'DATE(NutritionMealSchedules.schedule_date)' => $today,
            ];

            if (!empty($patientId)) {
                $conditions['NutritionMealSchedules.patient_id'] = $patientId;
            } else {
                $conditions['NutritionMealSchedules.patient_name'] = $patientName;
            }

            $schedules = $this->NutritionMealSchedules->find()
                ->where($conditions)
                ->all();

            foreach ($schedules as $schedule) {
                $schedule->is_archived     = 1;
                $schedule->archived_at     = $now;
                $schedule->archived_reason = $reason;
                $this->NutritionMealSchedules->save($schedule);
            }

        } catch (\Exception $e) {
            \Cake\Log\Log::warning(
                'archivePatientMealSchedules error: ' . $e->getMessage()
            );
        }
    }

    // ─────────────────────────────────────────────────────────────
    // GET NEXT TT — AJAX
    // ─────────────────────────────────────────────────────────────
    public function getNextTt($roomId = null)
    {
        $this->request->allowMethod(['get', 'ajax']);
        $this->viewBuilder()->setClassName('Json');

        if (empty($roomId)) {
            $this->set(['success' => false, 'message' => 'Room ID tidak ditemukan.']);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $existingBeds = $this->Beds->find()
            ->select(['bed_no'])
            ->where([
                'Beds.room_id' => $roomId,
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->order(['Beds.bed_no' => 'ASC'])
            ->all();

        $maxNo = 0;
        foreach ($existingBeds as $b) {
            $bedNo = $b->bed_no ?? '';
            if (preg_match('/(\d+)$/', $bedNo, $m)) {
                $maxNo = max($maxNo, (int)$m[1]);
            }
        }

        $nextNo = $maxNo + 1;
        $nextTt = 'TT' . str_pad((string)$nextNo, 2, '0', STR_PAD_LEFT);

        $this->set([
            'success'        => true,
            'next_tt'        => $nextTt,
            'existing_count' => count($existingBeds->toArray()),
            'next_no'        => $nextNo,
        ]);
        $this->viewBuilder()->setOption('serialize', ['success', 'next_tt', 'existing_count', 'next_no']);
    }

    // ─────────────────────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────────────────────
    public function index()
    {
        $query = $this->Beds->find()
            ->contain([
                'Rooms',
                'Patients',
                'BedHistories' => [
                    'sort' => ['BedHistories.created' => 'DESC'],
                ],
            ])
            ->where([
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->order(['Beds.id' => 'DESC']);

        $key = $this->request->getQuery('key');
        if (!empty($key)) {
            $query->where([
                'OR' => [
                    'Beds.code LIKE'          => '%' . $key . '%',
                    'Beds.bed_no LIKE'        => '%' . $key . '%',
                    'Beds.name LIKE'          => '%' . $key . '%',
                    'Beds.class_name LIKE'    => '%' . $key . '%',
                    'Rooms.room_name LIKE'    => '%' . $key . '%',
                    'Patients.full_name LIKE' => '%' . $key . '%',
                ],
            ]);
        }

        $roomId = $this->request->getQuery('room_id');
        if (!empty($roomId)) {
            $query->where(['Beds.room_id' => $roomId]);
        }

        $className = $this->request->getQuery('class_name');
        if (!empty($className)) {
            $query->where(['Beds.class_name' => $className]);
        }

        $status = $this->request->getQuery('status');
        if ($status !== null && $status !== '') {
            $query->where(['Beds.status' => $status]);
        }

        $this->paginate = ['limit' => 10];
        $beds = $this->paginate($query);

        $rooms = $this->Beds->Rooms->find('list', [
            'keyField'   => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->toArray();

        $classList   = $this->Beds->getClassList();
        $statusList  = $this->Beds->getStatusList();
        $statusLabel = $this->Beds->getStatusLabel();

        $this->set(compact(
            'beds', 'rooms', 'classList', 'statusList', 'statusLabel',
            'key', 'roomId', 'className', 'status'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // VIEW
    // ─────────────────────────────────────────────────────────────
    public function view($id = null)
    {
        $bed = $this->Beds->get($id, [
            'contain' => [
                'Rooms',
                'Patients',
                'BedHistories' => [
                    'sort' => ['BedHistories.created' => 'DESC'],
                ],
            ],
        ]);

        $statusLabel = $this->Beds->getStatusLabel();

        // Hitung info BPJS untuk ditampilkan di view
        $tarifHari = (float)($bed->room->tarif_hari ?? 0);
        $bpjsInfo  = self::calcBpjsInfo(
            $bed->payer_type ?? null,
            $bed->bpjs_limit_days ?? null,
            $bed->check_in_date ?? null,
            $bed->planned_check_out_date ?? null,
            $tarifHari
        );

        $this->set(compact('bed', 'statusLabel', 'bpjsInfo'));
    }

    // ─────────────────────────────────────────────────────────────
    // ADD
    // ─────────────────────────────────────────────────────────────
    public function add()
    {
        $bed = $this->Beds->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (empty(trim($data['code'] ?? ''))) {
                $lastBed = $this->Beds->find()
                    ->order(['Beds.id' => 'DESC'])
                    ->first();
                $lastId       = $lastBed ? ($lastBed->id + 1) : 1;
                $data['code'] = 'BED-' . str_pad((string)$lastId, 4, '0', STR_PAD_LEFT);
            }

            if (!empty($data['room_id']) && empty(trim($data['bed_no'] ?? ''))) {
                $data['bed_no'] = $this->_getNextTtForRoom((int)$data['room_id']);
            }

            if (!empty($data['room_id']) && empty(trim($data['class_name'] ?? ''))) {
                try {
                    $room      = $this->Beds->Rooms->get((int)$data['room_id']);
                    $roomClass = trim((string)($room->room_class ?? ''));

                    if (empty($roomClass)) {
                        $rn = strtolower((string)($room->room_name ?? ''));
                        if (str_contains($rn, 'vvip'))        $roomClass = 'VVIP';
                        elseif (str_contains($rn, 'vip'))     $roomClass = 'VIP';
                        elseif (str_contains($rn, 'nicu'))    $roomClass = 'NICU';
                        elseif (str_contains($rn, 'picu'))    $roomClass = 'PICU';
                        elseif (str_contains($rn, 'icu'))     $roomClass = 'ICU';
                        elseif (str_contains($rn, 'hcu'))     $roomClass = 'HCU';
                        elseif (str_contains($rn, 'isolasi')) $roomClass = 'Isolasi';
                        elseif (str_contains($rn, 'kelas 1') || str_contains($rn, 'kelas1')) $roomClass = 'Kelas 1';
                        elseif (str_contains($rn, 'kelas 2') || str_contains($rn, 'kelas2')) $roomClass = 'Kelas 2';
                        elseif (str_contains($rn, 'kelas 3') || str_contains($rn, 'kelas3')) $roomClass = 'Kelas 3';
                    }

                    if (!empty($roomClass)) {
                        $data['class_name'] = $roomClass;
                    }
                } catch (\Exception $e) {}
            }

            if (empty($data['is_active'])) {
                $data['is_active'] = 'Y';
            }
            if (!isset($data['status']) || $data['status'] === '') {
                $data['status'] = 0;
            }
            $data['status'] = (int)$data['status'];

            // Bersihkan field BPJS jika bukan pasien BPJS
            if (($data['payer_type'] ?? '') !== 'BPJS') {
                $data['bpjs_limit_days'] = null;
            }
            // Default batas BPJS 3 hari jika tidak diisi
            if (!empty($data['bpjs_limit_days'])) {
                $data['bpjs_limit_days'] = (int)$data['bpjs_limit_days'];
            }

            if (!empty($data['room_id'])) {
                $roomId = (int)$data['room_id'];
                try {
                    $room     = $this->Beds->Rooms->get($roomId);
                    $capacity = (int)($room->capacity ?? 0);

                    if ($capacity > 0) {
                        $activeBedCount = $this->Beds->find()
                            ->where([
                                'Beds.room_id'   => $roomId,
                                'Beds.is_active' => 'Y',
                                'OR' => [
                                    ['Beds.is_delete !=' => 1],
                                    ['Beds.is_delete IS' => null],
                                ],
                            ])->count();

                        if ($activeBedCount >= $capacity) {
                            $this->Flash->error(__(
                                'Room {0} sudah penuh! Kapasitas maksimal {1} bed, saat ini sudah ada {2} bed aktif.',
                                $room->room_name, $capacity, $activeBedCount
                            ));
                            $bed = $this->Beds->patchEntity($bed, $data);
                            $this->_setAddViewVars($bed);
                            return;
                        }
                    }
                } catch (\Exception $e) {}
            }

            $bed = $this->Beds->patchEntity($bed, $data);

            if ($this->Beds->save($bed)) {
                $this->Flash->success(__('Bed berhasil disimpan.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__(
                'Bed gagal disimpan. ' . implode(', ', array_map(
                    fn($e) => implode(', ', $e),
                    $bed->getErrors()
                ))
            ));
        }

        $this->_setAddViewVars($bed);
    }

    private function _setAddViewVars(\App\Model\Entity\Bed $bed): void
    {
        $rooms = $this->Beds->Rooms->find('list', [
            'keyField'   => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->toArray();

        $classList  = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $activeList = $this->Beds->getActiveList();

        $lastBed  = $this->Beds->find()->order(['Beds.id' => 'DESC'])->first();
        $lastId   = $lastBed ? ($lastBed->id + 1) : 1;
        $nextCode = 'BED-' . str_pad((string)$lastId, 4, '0', STR_PAD_LEFT);

        $allRooms = $this->Beds->Rooms->find()
            ->select(['id', 'room_name', 'room_code', 'room_class', 'capacity'])
            ->where([
                'OR' => [
                    ['Rooms.is_delete !=' => 1],
                    ['Rooms.is_delete IS' => null],
                ],
            ])
            ->all();

        $roomDetails = [];
        foreach ($allRooms as $r) {
            $bedCount = $this->Beds->find()
                ->where([
                    'Beds.room_id' => $r->id,
                    'OR' => [
                        ['Beds.is_delete !=' => 1],
                        ['Beds.is_delete IS' => null],
                    ],
                ])->count();

            $roomClass = trim((string)($r->room_class ?? ''));
            if (empty($roomClass)) {
                $rn = strtolower((string)($r->room_name ?? ''));
                if (str_contains($rn, 'vvip'))        $roomClass = 'VVIP';
                elseif (str_contains($rn, 'vip'))     $roomClass = 'VIP';
                elseif (str_contains($rn, 'nicu'))    $roomClass = 'NICU';
                elseif (str_contains($rn, 'picu'))    $roomClass = 'PICU';
                elseif (str_contains($rn, 'icu'))     $roomClass = 'ICU';
                elseif (str_contains($rn, 'hcu'))     $roomClass = 'HCU';
                elseif (str_contains($rn, 'isolasi')) $roomClass = 'Isolasi';
                elseif (str_contains($rn, 'kelas 1') || str_contains($rn, 'kelas1')) $roomClass = 'Kelas 1';
                elseif (str_contains($rn, 'kelas 2') || str_contains($rn, 'kelas2')) $roomClass = 'Kelas 2';
                elseif (str_contains($rn, 'kelas 3') || str_contains($rn, 'kelas3')) $roomClass = 'Kelas 3';
            }

            $roomDetails[$r->id] = [
                'room_name'  => $r->room_name ?? '',
                'room_class' => $roomClass,
                'capacity'   => (int)($r->capacity ?? 0),
                'bed_count'  => $bedCount,
            ];
        }

        $this->set(compact('bed', 'rooms', 'classList', 'statusList', 'activeList', 'nextCode', 'roomDetails'));
    }

    private function _getNextTtForRoom(int $roomId): string
    {
        $existingBeds = $this->Beds->find()
            ->select(['bed_no'])
            ->where([
                'Beds.room_id' => $roomId,
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->all();

        $maxNo = 0;
        foreach ($existingBeds as $b) {
            if (preg_match('/(\d+)$/', $b->bed_no ?? '', $m)) {
                $maxNo = max($maxNo, (int)$m[1]);
            }
        }

        return 'TT' . str_pad((string)($maxNo + 1), 2, '0', STR_PAD_LEFT);
    }

    // ─────────────────────────────────────────────────────────────
    // EDIT
    // ─────────────────────────────────────────────────────────────
    public function edit($id = null)
    {
        $bed = $this->Beds->get($id, ['contain' => ['Rooms', 'Patients']]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!isset($data['status']) || $data['status'] === '') {
                $data['status'] = $bed->status;
            }
            $data['status'] = (int)$data['status'];

            $statusBefore      = (int)$bed->status;
            $statusAfter       = $data['status'];
            $patientNameBefore = $bed->patient_name ?? null;
            $patientIdBefore   = $bed->patient_id   ?? null;
            $checkInBefore     = $bed->check_in_date ?? null;
            $now               = date('Y-m-d H:i:s');

            unset($data['check_in_date'], $data['check_out_date']);

            // ── BPJS: bersihkan jika bukan BPJS ──────────────────────
            if (($data['payer_type'] ?? '') !== 'BPJS') {
                $data['bpjs_limit_days'] = null;
            } else {
                $data['bpjs_limit_days'] = !empty($data['bpjs_limit_days'])
                    ? (int)$data['bpjs_limit_days']
                    : 3;
            }

            if ($statusAfter === 1) {
                if (empty($bed->check_in_date)) {
                    $data['check_in_date'] = $now;
                }
                $data['check_out_date'] = null;

                $patientId   = !empty($data['patient_id']) ? (int)$data['patient_id'] : null;
                $patientName = $data['patient_name'] ?? null;

                if ($patientId) {
                    $this->Patients = $this->fetchTable('Patients');
                    try {
                        $patient     = $this->Patients->get($patientId, ['fields' => ['id', 'full_name']]);
                        $patientName = $patient->full_name;
                    } catch (\Exception $e) {}
                }

                $data['patient_id']   = $patientId;
                $data['patient_name'] = $patientName;
                $data['notes']        = $this->buildAutoNotes($statusAfter, $statusBefore, $patientName, $now);

            } else {
                $data['patient_id']            = null;
                $data['patient_name']          = null;
                $data['planned_check_out_date'] = null;
                $data['payer_type']            = null;
                $data['bpjs_limit_days']       = null;

                if ($statusBefore === 1) {
                    $data['check_out_date'] = $now;
                }

                $autoNotes = $this->buildAutoNotes($statusAfter, $statusBefore, $patientNameBefore, $now);
                if ($autoNotes !== null) {
                    $data['notes'] = $autoNotes;
                }
            }

            $bed = $this->Beds->patchEntity($bed, $data);

            if ($this->Beds->save($bed)) {
                if ($statusBefore !== $statusAfter) {
                    $this->archivePatientMealSchedules(
                        $patientIdBefore,
                        $patientNameBefore,
                        $statusBefore,
                        $statusAfter
                    );
                }

                if ($statusBefore !== $statusAfter) {
                    $this->BedHistories = $this->fetchTable('BedHistories');
                    $history                  = $this->BedHistories->newEmptyEntity();
                    $history->bed_id          = $bed->id;
                    $history->room_id         = $bed->room_id;
                    $history->registration_no = $data['registration_no'] ?? null;
                    $history->status_before   = $statusBefore;
                    $history->status_after    = $statusAfter;
                    $history->notes           = $bed->notes ?? null;
                    $history->created_by      = 'system';

                    if ($statusAfter === 1) {
                        $history->patient_id     = $bed->patient_id   ?? null;
                        $history->patient_name   = $bed->patient_name ?? null;
                        $history->check_in_date  = $bed->check_in_date ?? null;
                        $history->check_out_date = null;
                    } else {
                        $history->patient_id     = $patientIdBefore;
                        $history->patient_name   = $patientNameBefore;
                        $history->check_in_date  = $checkInBefore;
                        $history->check_out_date = ($statusBefore === 1)
                            ? ($bed->check_out_date ?? null)
                            : null;
                    }

                    $this->BedHistories->save($history);
                }

                $this->Flash->success(__('Bed berhasil diupdate.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Bed gagal diupdate.'));
        }

        $rooms = $this->Beds->Rooms->find('list', [
            'keyField'   => 'id',
            'valueField' => 'room_name',
        ])->order(['Rooms.room_name' => 'ASC'])->toArray();

        $classList  = $this->Beds->getClassList();
        $statusList = $this->Beds->getStatusList();
        $activeList = $this->Beds->getActiveList();

        $this->set(compact('bed', 'rooms', 'classList', 'statusList', 'activeList'));
    }

    // ─────────────────────────────────────────────────────────────
    // DELETE — soft delete
    // ─────────────────────────────────────────────────────────────
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bed            = $this->Beds->get($id);
        $bed->is_delete = 1;

        if ($this->Beds->save($bed)) {
            $this->Flash->success(__('Bed berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Bed gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ─────────────────────────────────────────────────────────────
    // MONITORING
    // ─────────────────────────────────────────────────────────────
    public function monitoring()
    {
        $beds = $this->Beds->find()
            ->contain(['Rooms', 'Patients'])
            ->where([
                'Beds.is_active' => 'Y',
                'OR' => [
                    ['Beds.is_delete !=' => 1],
                    ['Beds.is_delete IS' => null],
                ],
            ])
            ->order(['Rooms.room_name' => 'ASC', 'Beds.bed_no' => 'ASC'])
            ->all();

        $statusLabel = $this->Beds->getStatusLabel();
        $grouped     = [];
        foreach ($beds as $bed) {
            $grouped[$bed->room->room_name][] = $bed;
        }

        $this->set(compact('grouped', 'statusLabel'));
    }

    // ─────────────────────────────────────────────────────────────
    // SEARCH PATIENTS — AJAX autocomplete
    // ─────────────────────────────────────────────────────────────
    public function searchPatients()
    {
        $this->request->allowMethod(['get', 'ajax']);
        $this->viewBuilder()->setClassName('Json');

        $key      = $this->request->getQuery('q', '');
        $patients = [];

        if (!empty(trim($key))) {
            $this->Patients = $this->fetchTable('Patients');
            $results = $this->Patients->find()
                ->select(['id', 'code', 'full_name'])
                ->where([
                    'OR' => [
                        'Patients.full_name LIKE' => '%' . trim($key) . '%',
                        'Patients.code LIKE'      => '%' . trim($key) . '%',
                    ],
                ])
                ->limit(15)
                ->order(['Patients.full_name' => 'ASC'])
                ->toArray();

            foreach ($results as $p) {
                $patients[] = [
                    'id'        => $p->id,
                    'code'      => $p->code,
                    'full_name' => $p->full_name,
                    'label'     => $p->full_name . ' (' . $p->code . ')',
                ];
            }
        }

        $this->set(['patients' => $patients]);
        $this->viewBuilder()->setOption('serialize', ['patients']);
    }

    // ─────────────────────────────────────────────────────────────
    // UPDATE STATUS — AJAX
    // ─────────────────────────────────────────────────────────────
    public function updateStatus($id = null)
    {
        $this->request->allowMethod(['post', 'ajax']);
        $this->viewBuilder()->setClassName('Json');
        $this->response = $this->response->withHeader('X-Content-Type-Options', 'nosniff');

        try {
            $bed = $this->Beds->get($id, ['contain' => ['Rooms']]);
        } catch (\Exception $e) {
            $this->set(['success' => false, 'message' => 'Bed tidak ditemukan.']);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $data = $this->request->getData();

        if (!isset($data['status']) || $data['status'] === '') {
            $this->set(['success' => false, 'message' => 'Status wajib dipilih.']);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $statusBefore      = (int)$bed->status;
        $statusAfter       = (int)$data['status'];
        $patientNameBefore = $bed->patient_name ?? null;
        $patientIdBefore   = $bed->patient_id   ?? null;
        $checkInBefore     = $bed->check_in_date ?? null;
        $now               = date('Y-m-d H:i:s');

        $saveData = ['status' => $statusAfter];

        if ($statusAfter === 1) {
            $patientId   = !empty($data['patient_id']) ? (int)$data['patient_id'] : null;
            $patientName = $data['patient_name'] ?? null;

            if ($patientId) {
                $this->Patients = $this->fetchTable('Patients');
                try {
                    $patient     = $this->Patients->get($patientId, ['fields' => ['id', 'full_name']]);
                    $patientName = $patient->full_name;
                } catch (\Exception $e) {}
            }

            $saveData['patient_id']     = $patientId;
            $saveData['patient_name']   = $patientName;
            $saveData['check_in_date']  = $now;
            $saveData['check_out_date'] = null;
            $saveData['notes']          = $this->buildAutoNotes($statusAfter, $statusBefore, $patientName, $now);

            // ── Info rencana keluar & BPJS ────────────────────────────
            $payerType  = !empty($data['payer_type']) ? trim($data['payer_type']) : null;
            $plannedOut = !empty($data['planned_check_out_date'])
                ? $data['planned_check_out_date']
                : null;

            $saveData['payer_type']              = $payerType;
            $saveData['planned_check_out_date']  = $plannedOut;

            if ($payerType === 'BPJS') {
                $saveData['bpjs_limit_days'] = !empty($data['bpjs_limit_days'])
                    ? (int)$data['bpjs_limit_days']
                    : 3;
            } else {
                $saveData['bpjs_limit_days'] = null;
            }

        } else {
            // Bukan Terisi → bersihkan semua data pasien & BPJS
            $saveData['patient_id']             = null;
            $saveData['patient_name']           = null;
            $saveData['planned_check_out_date'] = null;
            $saveData['payer_type']             = null;
            $saveData['bpjs_limit_days']        = null;

            if ($statusBefore === 1) {
                $saveData['check_out_date'] = $now;
            }

            $autoNotes = $this->buildAutoNotes($statusAfter, $statusBefore, $patientNameBefore, $now);
            if ($autoNotes !== null) {
                $saveData['notes'] = $autoNotes;
            } else {
                $saveData['notes'] = !empty($data['notes']) ? trim($data['notes']) : null;
            }
        }

        $bed = $this->Beds->patchEntity($bed, $saveData);

        if ($this->Beds->save($bed)) {
            $bedSaved  = $this->Beds->get($bed->id, ['contain' => ['Rooms']]);
            $tarifHari = (float)($bedSaved->room->tarif_hari ?? 0);

            // Hitung info BPJS untuk dikirim ke response
            $bpjsInfo = self::calcBpjsInfo(
                $bedSaved->payer_type ?? null,
                $bedSaved->bpjs_limit_days ?? null,
                $bedSaved->check_in_date ?? null,
                $bedSaved->planned_check_out_date ?? null,
                $tarifHari
            );

            // ── AUTO-ARCHIVE jadwal makan ─────────────────────────────
            if ($statusBefore !== $statusAfter) {
                $this->archivePatientMealSchedules(
                    $patientIdBefore,
                    $patientNameBefore,
                    $statusBefore,
                    $statusAfter
                );
            }

            if ($statusBefore !== $statusAfter) {
                $this->BedHistories = $this->fetchTable('BedHistories');
                $history                  = $this->BedHistories->newEmptyEntity();
                $history->bed_id          = $bedSaved->id;
                $history->room_id         = $bedSaved->room_id;
                $history->registration_no = $data['registration_no'] ?? null;
                $history->status_before   = $statusBefore;
                $history->status_after    = $statusAfter;
                $history->notes           = $bedSaved->notes ?? null;
                $history->created_by      = 'system';

                if ($statusAfter === 1) {
                    $history->patient_id     = $bedSaved->patient_id   ?? null;
                    $history->patient_name   = $bedSaved->patient_name  ?? null;
                    $history->check_in_date  = $bedSaved->check_in_date ?? null;
                    $history->check_out_date = null;
                } else {
                    $history->patient_id     = $patientIdBefore;
                    $history->patient_name   = $patientNameBefore;
                    $history->check_in_date  = $checkInBefore;
                    $history->check_out_date = ($statusBefore === 1)
                        ? ($bedSaved->check_out_date ?? null)
                        : null;
                }

                $this->BedHistories->save($history);
            }

            $this->set([
                'success'   => true,
                'message'   => 'Status bed berhasil diupdate.',
                'bpjs_info' => $bpjsInfo,
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message', 'bpjs_info']);
        } else {
            $errors = $bed->getErrors();
            $errMsg = '';
            foreach ($errors as $field => $errs) {
                $errMsg .= $field . ': ' . implode(', ', $errs) . '; ';
            }
            $this->set([
                'success' => false,
                'message' => 'Status bed gagal diupdate. ' . $errMsg,
                'errors'  => $errors,
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message', 'errors']);
        }
    }
}