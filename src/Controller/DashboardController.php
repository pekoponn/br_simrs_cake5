<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * Dashboard Controller
 *
 * @property \App\Model\Table\DashboardTable $Dashboard
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function index()
    {
        $result = $this->getTodayAbsenceSummaryByUbs();
        $resultLicenseAbsents = $this->getLicenseAbsents();
        $resultLeaves = $this->getLeaves();

        foreach ($result as $project => $data) {
            $result[$project]['total_izin'] = $resultLicenseAbsents[$project]['total_izin'] ?? 0; 
            $result[$project]['total_cuti'] = $resultLeaves[$project]['total_cuti'] ?? 0;
        }

        $notifications = $this->getPendingApprovalNotifications();
        $totalNotifications = array_sum(array_column($notifications, 'count'));
        
        // Tambahkan flag apakah user memiliki akses approval (untuk menampilkan card)
        $hasApprovalAccess = $this->checkHasApprovalAccess();
        $workOrderNotifications = $this->getWorkOrderNotifications();

        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');
        $currentUserId = $dataSession['id'];
        $this->loadModel('Users');
        $user = $this->Users->get($currentUserId);
        $telegramChatId = $user->telegram_chat_id;
        $botUsername = Configure::read('Telegram.botUsername');
        $telegramLink = "https://t.me/{$botUsername}?start={$dataSession['id']}";
        $todayAttendance = $this->buildTodayAttendance($dataSession);
        $todaySummary = $this->getTodaySummary();
        $todayPresence = $this->getTodayPresence();
        $this->set(compact('result', 'notifications', 'totalNotifications', 'hasApprovalAccess', 'workOrderNotifications', 'telegramChatId', 'telegramLink', 'todayAttendance', 'todaySummary', 'todayPresence'));
    }

    /** Ringkasan kehadiran pegawai aktif berdasarkan absen masuk pertama hari ini. */
    private function getTodayPresence(): array
    {
        $this->loadModel('Users');
        $this->loadModel('Absences');
        $today = date('Y-m-d');
        $total = $this->Users->find()->where(['is_active' => 'Y'])->count();
        $present = $this->Absences->find()
            ->where(['date' => $today, 'inout_mode' => 'I'])
            ->select(['user_id'])->distinct(['user_id'])->count();
        $present = min($present, $total);

        return ['total' => $total, 'present' => $present, 'absent' => max(0, $total - $present)];
    }

    private function getTodaySummary(): array
    {
        $this->loadModel('Users');
        $this->loadModel('Absences');
        $this->loadModel('Leaves');
        $this->loadModel('LicenseAbsents');
        $this->loadModel('PermissionLates');
        $this->loadModel('LicenseEarlyLeaves');

        $today = date('Y-m-d');
        $lateAfter = '08:00:00'; // Jam masuk standar, ubah di sini bila kebijakan berubah.
        $activeUsers = ['Users.is_active' => 'Y'];

        // time_in disimpan sebagai TIME/scalar; MIN memastikan hanya absen masuk pertama per user.
        $late = $this->Absences->find()
            ->select(['user_id'])
            ->matching('Users', function ($q) use ($activeUsers) {
                return $q->where($activeUsers);
            })
            ->where(['Absences.date' => $today, 'Absences.inout_mode' => 'I'])
            ->group(['Absences.user_id'])
            ->having(['MIN(Absences.time_in) >' => $lateAfter])
            ->count();

        $cuti = $this->Leaves->find()->matching('Users', function ($q) use ($activeUsers) {
            return $q->where($activeUsers);
        })->where(['Leaves.date_from <=' => $today, 'Leaves.date_end >=' => $today])->count();
        $izinTidakMasuk = $this->LicenseAbsents->find()->matching('Users', function ($q) use ($activeUsers) {
            return $q->where($activeUsers);
        })->where(['LicenseAbsents.date_from <=' => $today, 'LicenseAbsents.date_end >=' => $today])->count();
        $izinTerlambat = $this->PermissionLates->find()->matching('Users', function ($q) use ($activeUsers) {
            return $q->where($activeUsers);
        })->where(['PermissionLates.date' => $today])->count();
        $pulangCepat = $this->LicenseEarlyLeaves->find()->matching('Users', function ($q) use ($activeUsers) {
            return $q->where($activeUsers);
        })->where(['LicenseEarlyLeaves.date' => $today])->count();

        return [
            'late' => $late,
            'cuti' => $cuti,
            'izin_tidak_masuk' => $izinTidakMasuk,
            'izin_terlambat' => $izinTerlambat,
            'pulang_cepat' => $pulangCepat,
        ];
    }

    public function todayAttendance()
    {
        $dataSession = $this->getRequest()->getSession()->read('Auth');
        $data = $this->buildTodayAttendance($dataSession);
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));
    }
    private function buildTodayAttendance($dataSession): array
    {
        $userId = (int)($dataSession['id'] ?? 0);

        $data = [
            'date' => date('d-m-Y'),
            'name' => $dataSession['name'] ?? '',
            'logs' => [],
        ];

        if ($userId <= 0) {
            return $data;
        }

        $this->loadModel('Absences');

        $today = date('Y-m-d');

        $logs = $this->Absences->find()
            ->select(['inout_mode', 'date', 'time_in', 'time_out', 'created'])
            ->where([
                'user_id' => $userId,
                'date' => $today,
            ])
            ->order(['created' => 'ASC', 'date' => 'ASC'])   // lama -> terbaru
            ->enableHydration(false)
            ->toArray();

        foreach ($logs as $log) {
            $isIn = $log['inout_mode'] === 'I';

            // I -> time_in, O -> time_out
            $raw = $isIn ? $log['time_in'] : $log['time_out'];

            if (empty($raw)) {
                $time = '-';
            } elseif (is_object($raw)) {
                $time = $raw->format('H:i');
            } else {
                $time = date('H:i', strtotime((string)$raw));
            }

            $data['logs'][] = [
                'mode' => $isIn ? 'Masuk' : 'Pulang',
                'type' => $log['inout_mode'],
                'time' => $time,
            ];
        }

        return $data;
    }

    private function getWorkOrderNotifications()
    {
        $userId = $this->Authentication->getIdentity()->id;
        $this->loadModel('WorkOrders');
        return $this->WorkOrders->find()
            ->select([
                'WorkOrders.id',
                'WorkOrders.code',
                'WorkOrders.date'
            ])
            ->matching('WorkOrderLines', function ($q) use ($userId) {
                return $q->where([
                    'WorkOrderLines.user_id' => $userId
                ]);
            })
            ->where([
                'WorkOrders.is_active' => 'Y' // sesuaikan kondisi aktif
            ])
            ->distinct(['WorkOrders.id'])
            ->toArray();
    }

    /**
     * Cek apakah user memiliki minimal 1 akses approve atau knowing
     */
    private function checkHasApprovalAccess(): bool
    {
        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');
        
        if (empty($dataSession)) {
            return false;
        }
        
        $rulesString = (string)($dataSession['rules'] ?? '');
        $rules = $this->Krs->_rule($rulesString);
        
        $moduleConfigs = ['leaves', 'licenseabsents', 'licenseearlyleaves', 'overtimes', 'assignments'];
        
        foreach ($moduleConfigs as $module) {
            $moduleRules = $rules[$module] ?? [];
            if (($moduleRules['approve'] ?? '0') === '1' || ($moduleRules['knowing'] ?? '0') === '1') {
                return true;
            }
        }
        
        return false;
    }

    public function getPendingApprovalNotifications(): array
    {
        $session = $this->getRequest()->getSession();
        $dataSession = $session->read('Auth');

        if (empty($dataSession)) {
            return [];
        }

        $rulesString = (string)($dataSession['rules'] ?? '');
        $rules = $this->Krs->_rule($rulesString);
        $teamUserIds = $this->getTeamUserIds($dataSession);

        if (empty($teamUserIds)) {
            return [];
        }

        $this->loadModel('Leaves');
        $this->loadModel('LicenseAbsents');
        $this->loadModel('LicenseEarlyLeaves');
        $this->loadModel('Overtimes');
        $this->loadModel('Assignments');

        $moduleConfigs = [
            [
                'rule_key' => 'leaves',
                'label' => 'Cuti',
                'table' => $this->Leaves,
                'approve_field' => 'approved',
                'knowing_field' => 'knowing',
                'route' => ['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'index'],
            ],
            [
                'rule_key' => 'licenseabsents',
                'label' => 'Izin Tidak Masuk',
                'table' => $this->LicenseAbsents,
                'approve_field' => 'approved',
                'knowing_field' => 'knowing',
                'route' => ['prefix' => 'Hr', 'controller' => 'LicenseAbsents', 'action' => 'index'],
            ],
            [
                'rule_key' => 'licenseearlyleaves',
                'label' => 'Izin Pulang Cepat',
                'table' => $this->LicenseEarlyLeaves,
                'approve_field' => 'is_approved',
                'knowing_field' => 'is_knowing',
                'route' => ['prefix' => 'Hr', 'controller' => 'LicenseEarlyLeaves', 'action' => 'index'],
            ],
            [
                'rule_key' => 'overtimes',
                'label' => 'Lembur',
                'table' => $this->Overtimes,
                'approve_field' => 'approved',
                'knowing_field' => 'knowing',
                'route' => ['prefix' => 'Hr', 'controller' => 'Overtimes', 'action' => 'index'],
            ],
            [
                'rule_key' => 'assignments',
                'label' => 'Penugasan',
                'table' => $this->Assignments,
                'approve_field' => 'approved',
                'knowing_field' => 'knowing',
                'route' => ['prefix' => 'Hr', 'controller' => 'Assignments', 'action' => 'index'],
            ],
        ];

        $notifications = [];

        foreach ($moduleConfigs as $module) {
            $moduleRules = $rules[$module['rule_key']] ?? [];

            if (($moduleRules['approve'] ?? '0') === '1') {
                $pendingApprove = $module['table']->find()
                    ->where([
                        'is_create IN' => $teamUserIds,
                        $module['approve_field'] . ' IS' => null,
                    ])
                    ->count();

                if ($pendingApprove > 0) {
                    $notifications[] = [
                        'title' => $module['label'] . ' menunggu disetujui',
                        'count' => $pendingApprove,
                        'action' => 'approve',
                        'route' => $module['route'],
                    ];
                }
            }

            if (($moduleRules['knowing'] ?? '0') === '1') {
                $pendingKnowing = $module['table']->find()
                    ->where([
                        // 'is_create IN' => $teamUserIds,
                        $module['knowing_field'] . ' IS' => null,
                    ])
                    ->count();

                if ($pendingKnowing > 0) {
                    $notifications[] = [
                        'title' => $module['label'] . ' menunggu diketahui',
                        'count' => $pendingKnowing,
                        'action' => 'knowing',
                        'route' => $module['route'],
                    ];
                }
            }
        }
        return $notifications;
    }

    private function getTeamUserIds($dataSession): array
    {
        $currentUserId = (int)($dataSession['id'] ?? 0);
        $userTeam = (string)($dataSession['user_team'] ?? '');
        $teamUserIds = array_filter(array_map('trim', explode(',', $userTeam)));
        $teamUserIds = array_map('intval', $teamUserIds);

        if ($currentUserId > 0) {
            $teamUserIds[] = $currentUserId;
        }

        $teamUserIds = array_values(array_unique(array_filter($teamUserIds)));

        return $teamUserIds;
    }

    public function getTodayAbsenceSummaryByUbs()
    {
        $this->loadModel('Users');
        $this->loadModel('Absences');

        $todayStart = date('Y-m-d') . ' 00:00:00';
        $todayEnd   = date('Y-m-d') . ' 23:59:59';

        // ambil semua UBS unik
        $projectList = $this->Users->find()
            ->select(['project'])
            ->distinct(['project'])
            ->where(['project IS NOT' => null])
            ->enableHydration(false)
            ->toArray();

        $result = [];

        foreach ($projectList as $row) {
            $project = $row['project'];

            // total user per UBS
            $totalUsers = $this->Users->find()
                ->where(['project' => $project, 'is_active' => 'Y'])
                ->count();

            // ambil user IDs per UBS
            $userIds = $this->Users->find()
                ->select(['id'])
                ->where(['project' => $project, 'is_active' => 'Y'])
                ->enableHydration(false)
                ->extract('id')
                ->toList();

            // total absensi hari ini
            $totalAbsentToday = 0;

            if (!empty($userIds)) {
                $totalAbsentToday = $this->Absences->find()
                    ->where([
                        'user_id IN' => $userIds,
                        'inout_mode' => 'I',
                        'date >=' => $todayStart,
                        'date <=' => $todayEnd,
                    ])
                    ->select(['user_id'])
                    ->distinct(['user_id'])
                    ->count();
            }

            $result[$project] = [
                'total_users' => $totalUsers,
                'total_absent_today' => $totalAbsentToday
            ];
        }

        return $result;
    }

    public function getLicenseAbsents()
    {
        $this->loadModel('Users');
        $this->loadModel('LicenseAbsents');

        $todayStart = date('Y-m-d') . ' 00:00:00';
        $todayEnd   = date('Y-m-d') . ' 23:59:59';

        // ambil semua UBS unik
        $projectList = $this->Users->find()
            ->select(['project'])
            ->distinct(['project'])
            ->where(['project IS NOT' => null])
            ->enableHydration(false)
            ->toArray();

        $result = [];

        foreach ($projectList as $row) {
            $project = $row['project'];

            // total user per UBS
            $totalUsers = $this->Users->find()
                ->where(['project' => $project, 'is_active' => 'Y'])
                ->count();

            // ambil user IDs per UBS
            $userIds = $this->Users->find()
                ->select(['id'])
                ->where(['project' => $project, 'is_active' => 'Y'])
                ->enableHydration(false)
                ->extract('id')
                ->toList();

            // total izin hari ini
            $totalIjinToday = 0;

            if (!empty($userIds)) {
                $totalIjinToday = $this->LicenseAbsents->find()
                    ->where([
                        'is_create IN' => $userIds,
                        'date_from <=' => $todayEnd,
                        'date_end >=' => $todayStart,
                    ])
                    ->count();
            }

            $result[$project] = [
                'total_users' => $totalUsers,
                'total_izin' => $totalIjinToday
            ];
        }

        return $result;
    }

    public function getLeaves()
    {
        $this->loadModel('Users');
        $this->loadModel('Leaves');

        $todayStart = date('Y-m-d') . ' 00:00:00';
        $todayEnd   = date('Y-m-d') . ' 23:59:59';

        // ambil semua UBS unik
        $projectList = $this->Users->find()
            ->select(['project'])
            ->distinct(['project'])
            ->where(['project IS NOT' => null])
            ->enableHydration(false)
            ->toArray();

        $result = [];

        foreach ($projectList as $row) {
            $project = $row['project'];

            // total user per UBS
            $totalUsers = $this->Users->find()
                ->where(['project' => $project, 'is_active' => 'Y'])
                ->count();

            // ambil user IDs per UBS
            $userIds = $this->Users->find()
                ->select(['id'])
                ->where(['project' => $project, 'is_active' => 'Y'])
                ->enableHydration(false)
                ->extract('id')
                ->toList();

            // total izin hari ini
            $totalCutiToday = 0;
            if (!empty($userIds)) {
                $totalCutiToday = $this->Leaves->find()
                    ->where([
                        'is_create IN' => $userIds,
                        'date_from <=' => $todayEnd,
                        'date_end >=' => $todayStart,
                    ])
                    ->count();
            }
            $result[$project] = [
                'total_users' => $totalUsers,
                'total_cuti' => $totalCutiToday
            ];
        }

        return $result;
    }

}
