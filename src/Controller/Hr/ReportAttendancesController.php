<?php

declare(strict_types=1);

namespace App\Controller\Hr;

use App\Controller\AppController;
use Cake\Chronos\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Cake\Http\CallbackStream;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Chronos\Chronos;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Datasource\Paging\Paginator;
use Cake\Datasource\ConnectionManager;

class ReportAttendancesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Absences');
        $this->loadModel('Leaves');
        $this->loadModel('LicenseEarlyLeaves');
        $this->loadModel('LicenseAbsents');
        $this->loadModel('Overtimes');
        $this->loadModel('Users'); 
        $this->loadModel('AbsentIssues');
    }

    public function index()
    {
        $users = $this->Users->find('list', ['keyField' => 'id','valueField' => 'name'])
            ->where(['is_active' => 'Y'])
            ->toArray();  

        $this->set(compact('users'));
    }

    public function getReport()
    {
        $this->request->allowMethod(['get']);
        $conn = ConnectionManager::get('default');
        $draw   = (int)$this->request->getQuery('draw');
        $start  = (int)$this->request->getQuery('start', 0);
        $length = (int)$this->request->getQuery('length', 10);

        $startDate = $this->request->getQuery('start_date');
        $endDate   = $this->request->getQuery('end_date');
        $users     = $this->request->getQuery('users');

        $datestart = $this->Krs->dateTo($startDate);
        $dateend   = $this->Krs->dateTo($endDate);
        $result = $this->buildReportQuery($users);
        $sql = $result['sql'];
        $bindings = [
            'start_date' => $datestart,
            'end_date'   => $dateend
        ];
        if (!empty($users)) {
            $bindings['users'] = $users;
        }
        $countSql = "
            SELECT COUNT(*) total
            FROM users u
            WHERE u.is_active = 'Y'
        ";

        $countBindings = [];

        if (!empty($users)) {
            $countSql .= " AND u.id = :users";
            $countBindings['users'] = $users;
        }

        $total = $conn
            ->execute($countSql, $countBindings)
            ->fetch('assoc');

        $recordsTotal = (int)($total['total'] ?? 0);
        $recordsFiltered = $recordsTotal;

        $sql .= " LIMIT {$length} OFFSET {$start}";

        $results = $conn
            ->execute($sql, $bindings)
            ->fetchAll('assoc');

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $results
            ]));
    }

    private function buildReportQuery($users = null)
    {
        $userSql = '';
        if (!empty($users)) {
            $userSql = " AND u.id = :users";
        }
        $sql = "
            SELECT
                u.id,
                u.name,
                COALESCE(a.hadir, 0) AS hadir,
                GREATEST(COALESCE(a.hadir, 0) - COALESCE(a.terlambat_lebih, 0), 0) AS hadir_terpotong,
                COALESCE(a.terlambat, 0) AS terlambat,
                COALESCE(a.terlambat_lebih, 0) AS terlambat_lebih,
                COALESCE(o.lembur, 0) AS lembur,
                COALESCE(la.ijin, 0) AS ijin,
                COALESCE(l.cuti, 0) AS cuti,
                COALESCE(lel.permisi, 0) AS permisi
            FROM users u
            LEFT JOIN (
                SELECT
                    x.user_id,
                    COUNT(*) AS hadir,
                    COUNT(
                        CASE
                            WHEN TIME(x.first_in) > x.jam_masuk
                            AND TIME(x.first_in) <= ADDTIME(x.jam_masuk, '00:10:00')
                            THEN 1
                        END
                    ) AS terlambat,
                    COUNT(
                        CASE
                            WHEN TIME(x.first_in) > ADDTIME(x.jam_masuk, '00:10:00')
                            THEN 1
                        END
                    ) AS terlambat_lebih
                FROM (
                    SELECT
                        ab.user_id,
                        ab.date,
                        MIN(CASE WHEN ab.inout_mode = 'I' THEN ab.time_in END) AS first_in,
                        MAKETIME(6 + COALESCE(us.working_hours, 2), 0, 0) AS jam_masuk
                    FROM absences ab
                    INNER JOIN users us ON us.id = ab.user_id
                    WHERE ab.date BETWEEN :start_date AND :end_date
                    AND ab.inout_mode IN ('I', 'O')
                    GROUP BY ab.user_id, ab.date, us.working_hours
                    HAVING COUNT(*) > 0
                ) x
                GROUP BY x.user_id
            ) a ON a.user_id = u.id
            LEFT JOIN (
                SELECT
                    CAST(is_create AS UNSIGNED) AS user_id,
                    SEC_TO_TIME(
                        SUM(
                            TIMESTAMPDIFF(
                                SECOND,
                                STR_TO_DATE(time_from, '%H:%i'),
                                STR_TO_DATE(time_end, '%H:%i')
                            )
                        )
                    ) AS lembur
                FROM overtimes
                WHERE status_approve = 'Y'
                AND date BETWEEN :start_date AND :end_date
                GROUP BY is_create
            ) o ON o.user_id = u.id
            LEFT JOIN (
                SELECT
                    CAST(is_create AS UNSIGNED) AS user_id,
                    COUNT(*) AS ijin
                FROM license_absents
                WHERE date_from BETWEEN :start_date AND :end_date
                GROUP BY is_create
            ) la ON la.user_id = u.id
            LEFT JOIN (
                SELECT
                    CAST(is_create AS UNSIGNED) AS user_id,
                    SUM(
                        CASE
                            WHEN date_from IS NOT NULL
                                AND date_end IS NOT NULL
                                AND date_from <= :end_date
                                AND date_end >= :start_date
                            THEN
                                DATEDIFF(
                                    LEAST(date_end, :end_date),
                                    GREATEST(date_from, :start_date)
                                ) + 1
                            ELSE 0
                        END
                        +
                        CASE
                            WHEN date_1 BETWEEN :start_date AND :end_date THEN 1
                            ELSE 0
                        END
                        +
                        CASE
                            WHEN date_2 BETWEEN :start_date AND :end_date THEN 1
                            ELSE 0
                        END
                        +
                        CASE
                            WHEN date_3 BETWEEN :start_date AND :end_date THEN 1
                            ELSE 0
                        END
                    ) AS cuti
                FROM leaves
                WHERE is_cancel = 0
                GROUP BY is_create
            ) l ON l.user_id = u.id

            LEFT JOIN (
                SELECT
                    CAST(is_create AS UNSIGNED) AS user_id,
                    COUNT(*) AS permisi
                FROM license_early_leaves
                WHERE date BETWEEN :start_date AND :end_date
                GROUP BY is_create
            ) lel ON lel.user_id = u.id
            WHERE u.is_active = 'Y'
            {$userSql}
            ORDER BY u.name ASC
        ";
        return ['sql' => $sql];
    }

    // LEFT JOIN (
    //     SELECT
    //         x.user_id,
    //         COUNT(*) AS hadir,
    //         COUNT(
    //             CASE
    //                 WHEN x.first_in > '08:00:00'
    //                 THEN 1
    //             END
    //         ) AS terlambat
    //     FROM (
    //         SELECT
    //             user_id,
    //             date,
    //             // MIN(time_in) AS first_in
    //             MIN(CASE WHEN inout_mode = 'I' THEN time_in END) AS first_in
    //         FROM absences
    //         // WHERE inout_mode = 'I'
    //         // AND date BETWEEN :start_date AND :end_date
    //         // GROUP BY user_id, date
    //         WHERE date BETWEEN :start_date AND :end_date
    //         AND inout_mode IN ('I', 'O') 
    //         GROUP BY user_id, date
    //         HAVING COUNT(*) > 0 
    //     ) x
    //     GROUP BY x.user_id
    // ) a ON a.user_id = u.id
    // LEFT JOIN (
    //     SELECT
    //         CAST(is_create AS UNSIGNED) AS user_id,
    //         COUNT(*) AS cuti
    //     FROM leaves
    //     WHERE approved > 0
    //     AND date_from <= :end_date
    //     AND date_end >= :start_date
    //     GROUP BY is_create
    // ) l ON l.user_id = u.id

    public function view($id = null)
    {
        $this->request->allowMethod(['get']);
        $conn = ConnectionManager::get('default');

        $startDate = $this->request->getQuery('start_date');
        $endDate   = $this->request->getQuery('end_date');

        $datestart = $this->Krs->dateTo($startDate);
        $dateend   = $this->Krs->dateTo($endDate);

        // Ambil data user
       $userSql = "SELECT id, name, working_hours FROM users WHERE id = :user_id AND is_active = 'Y' LIMIT 1";
        $user = $conn->execute($userSql, ['user_id' => $id])->fetch('assoc');

        $jamMasuk = $this->Krs->workingHoursSchedule($user['working_hours'])['in'];

        if (!$user) {
            throw new \Cake\Http\Exception\NotFoundException('User tidak ditemukan.');
        }

        // Query tanpa date generator - hanya mengambil tanggal yang ada data
        $sql = "
            SELECT
                d.date,
                MIN(CASE WHEN a.inout_mode = 'I' THEN a.time_in END) AS time_in,
                MAX(CASE WHEN a.inout_mode = 'O' THEN a.time_out END) AS time_out,
                CASE WHEN COUNT(CASE WHEN a.inout_mode IN ('I', 'O') THEN 1 END) > 0
                    THEN 'Y' ELSE 'N'
                END AS hadir,
                CASE
                    WHEN COUNT(CASE WHEN a.inout_mode = 'I' THEN 1 END) > 0
                    THEN
                        CASE
                            WHEN TIME(MIN(CASE WHEN a.inout_mode = 'I' THEN a.time_in END)) > TIME(:jam_masuk)
                            THEN CEIL(
                                TIMESTAMPDIFF(SECOND,
                                    TIME(:jam_masuk),
                                    TIME(MIN(CASE WHEN a.inout_mode = 'I' THEN a.time_in END))
                                ) / 60
                            )
                            ELSE 0
                        END
                    ELSE NULL
                END AS terlambat,
                CASE 
                    WHEN COUNT(CASE WHEN a.inout_mode = 'I' THEN 1 END) = 0 
                        AND COUNT(CASE WHEN a.inout_mode = 'O' THEN 1 END) > 0
                    THEN 'Tidak ada absen masuk' 
                    ELSE NULL 
                END AS keterangan_tanpa_absen_masuk,
                (
                    SELECT SEC_TO_TIME(
                        SUM(TIMESTAMPDIFF(SECOND,
                            STR_TO_DATE(o.time_from, '%H:%i'),
                            STR_TO_DATE(o.time_end, '%H:%i')
                        ))
                    )
                    FROM overtimes o
                    WHERE o.status_approve = 'Y'
                    AND CAST(o.is_create AS UNSIGNED) = :uid_lembur
                    AND o.date = d.date
                ) AS lembur,
                (
                    SELECT COUNT(*)
                    FROM license_absents la
                    WHERE CAST(la.is_create AS UNSIGNED) = :uid_ijin
                    AND la.date_from = d.date
                ) AS ijin,
                (
                    SELECT la.check_status
                    FROM license_absents la
                    WHERE CAST(la.is_create AS UNSIGNED) = :uid_ijin
                    AND la.date_from = d.date
                    AND la.check_status IS NOT NULL
                ) AS ijin_status,
                (
                    SELECT la.description
                    FROM license_absents la
                    WHERE CAST(la.is_create AS UNSIGNED) = :uid_ijin
                    AND la.date_from = d.date
                    LIMIT 1
                ) AS ijin_description_raw,
                (
                    SELECT COUNT(*)
                    FROM leaves l
                    WHERE CAST(l.is_create AS UNSIGNED) = :uid_cuti
                    AND l.is_cancel = 0
                    AND (
                        (
                            l.date_from IS NOT NULL
                            AND l.date_end IS NOT NULL
                            AND d.date BETWEEN l.date_from AND l.date_end
                        )
                        OR d.date = l.date_1
                        OR d.date = l.date_2
                        OR d.date = l.date_3
                    )
                ) AS cuti,
                (
                    SELECT l.description
                    FROM leaves l
                    WHERE CAST(l.is_create AS UNSIGNED) = :uid_cuti
                    AND l.date_from = d.date
                    LIMIT 1
                ) AS cuti_description_raw,
                (
                    SELECT COUNT(*)
                    FROM license_early_leaves lel
                    WHERE CAST(lel.is_create AS UNSIGNED) = :uid_permisi
                    AND lel.date = d.date
                ) AS permisi,
                (
                    SELECT lel.description
                    FROM license_early_leaves lel
                    WHERE CAST(lel.is_create AS UNSIGNED) = :uid_permisi
                    AND lel.date = d.date
                    LIMIT 1
                ) AS permisi_description_raw,
                (
                    SELECT ai.description
                    FROM absent_issues ai
                    WHERE CAST(ai.is_create AS UNSIGNED) = :uid_absen_issue
                    AND DATE(ai.created) = d.date
                    LIMIT 1
                ) AS absent_issue_description
            FROM (
                -- Ambil semua tanggal yang ada absensi dalam rentang
                SELECT DISTINCT date
                FROM absences
                WHERE user_id = :uid_absen
                    AND date BETWEEN :gen_start AND :gen_end
                
                UNION
                -- Ambil tanggal yang ada lembur
                SELECT DISTINCT date
                FROM overtimes
                WHERE status_approve = 'Y'
                    AND CAST(is_create AS UNSIGNED) = :uid_lembur
                    AND date BETWEEN :gen_start AND :gen_end
                
                UNION
                SELECT DISTINCT DATE(created) AS date
                FROM absent_issues
                WHERE CAST(is_create AS UNSIGNED) = :uid_absen_issue
                    AND DATE(created) BETWEEN :gen_start AND :gen_end
                UNION
                -- Ambil tanggal yang ada ijin
                SELECT DISTINCT date_from AS date
                FROM license_absents
                WHERE CAST(is_create AS UNSIGNED) = :uid_ijin
                    AND date_from BETWEEN :gen_start AND :gen_end
                UNION
                SELECT DISTINCT date AS date
                FROM license_early_leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_permisi
                    AND date BETWEEN :gen_start AND :gen_end
                UNION
                -- Cuti model lama (date_from - date_end)
                SELECT DISTINCT DATE_ADD(l.date_from, INTERVAL seq.seq DAY) AS date
                FROM leaves l
                CROSS JOIN (
                    SELECT t0.n + t1.n*10 + t2.n*100 AS seq
                    FROM
                        (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                        (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                        (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2
                ) seq
                WHERE CAST(l.is_create AS UNSIGNED) = :uid_cuti
                AND l.is_cancel = 0
                AND l.date_from IS NOT NULL
                AND l.date_end IS NOT NULL
                AND DATE_ADD(l.date_from, INTERVAL seq.seq DAY) <= l.date_end
                AND DATE_ADD(l.date_from, INTERVAL seq.seq DAY)
                    BETWEEN :gen_start AND :gen_end

                UNION
                -- Cuti model baru
                SELECT date_1 AS date
                FROM leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_cuti
                AND is_cancel = 0
                AND date_1 BETWEEN :gen_start AND :gen_end

                UNION
                SELECT date_2 AS date
                FROM leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_cuti
                AND approved > 0
                AND date_2 IS NOT NULL
                AND date_2 BETWEEN :gen_start AND :gen_end

                UNION
                SELECT date_3 AS date
                FROM leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_cuti
                AND approved > 0
                AND date_3 IS NOT NULL
                AND date_3 BETWEEN :gen_start AND :gen_end
            ) d
            LEFT JOIN absences a
                ON a.user_id = :uid_absen
                AND a.date = d.date
            GROUP BY d.date
            ORDER BY d.date ASC
        ";

        $rows = $conn->execute($sql, [
            'uid_lembur'  => $id,
            'uid_ijin'    => $id,
            'uid_cuti'    => $id,
            'uid_permisi' => $id,
            'uid_absen'   => $id,   
            'gen_start'   => $datestart,
            'gen_end'     => $dateend,
            'uid_absen_issue' => $id,
            'jam_masuk' => $jamMasuk
        ])->fetchAll('assoc');
        // debug($rows);
        // die;
        foreach ($rows as &$row) {
            $encodedFields = ['ijin_description_raw'    => 'ijin_description', 'cuti_description_raw'    => 'cuti_description', 'permisi_description_raw' => 'permisi_description'];
            foreach ($encodedFields as $rawKey => $targetKey) {
                if (!empty($row[$rawKey])) {
                    try {
                        $decoded = $this->Krs->fDecode($row[$rawKey]);
                        $row[$targetKey] = is_array($decoded) ? implode(', ', array_filter($decoded, 'is_scalar')) : $decoded;
                    } catch (\Throwable $e) {
                        $row[$targetKey] = null;
                    }
                } else {
                    $row[$targetKey] = null;
                }
            }
        }
        unset($row);

        $this->set(compact('user', 'rows', 'startDate', 'endDate'));
    }

    public function excel()
    {
        $this->request->allowMethod(['get']);
        $startDate = $this->request->getQuery('start_date');
        $endDate   = $this->request->getQuery('end_date');
        $users     = $this->request->getQuery('users');
        $result = $this->buildReportQuery($users);
        $sql = $result['sql'];
        $bindings = [
            'start_date' => $startDate,
            'end_date'   => $endDate
        ];
        if (!empty($users)) {
            $bindings['users'] = $users;
        }
        $conn = ConnectionManager::get('default');
        $data = $conn
            ->execute($sql, $bindings)
            ->fetchAll('assoc');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Periode
        $periode = date('d-m-Y', strtotime($startDate))
            . ' s/d ' .
            date('d-m-Y', strtotime($endDate));

        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'Periode : ' . $periode);
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFF2CC'
                ]
            ]
        ]);
        // Header tabel
        $sheet->fromArray(['No', 'Nama Pegawai', 'Hadir (Hari)', 'Hadir (Sudah Terpotong)', 'Terlambat (0-10 Menit)', 'Terlambat (>10 Menit)', 'Lembur (Jam)', 'Ijin', 'Cuti', 'Permisi'], null, 'A2');

        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => [
                'bold' => true
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D9EAD3'
                ]
            ]
        ]);

        // Data
        $row = 3;
        $no  = 1;
        foreach ($data as $item) {

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $item['name'] ?? '-');
            $sheet->setCellValue("C{$row}", $item['hadir'] ?? 0);
            $sheet->setCellValue("D{$row}", $item['hadir_terpotong'] ?? 0);
            $sheet->setCellValue("E{$row}", $item['terlambat'] ?? 0);
            $sheet->setCellValue("F{$row}", $item['terlambat_lebih'] ?? 0);
            $sheet->setCellValue("G{$row}", $item['lembur'] ?? 0);
            $sheet->setCellValue("H{$row}", $item['ijin'] ?? 0);
            $sheet->setCellValue("I{$row}", $item['cuti'] ?? 0);
            $sheet->setCellValue("J{$row}", $item['permisi'] ?? 0);

            $row++;
        }
        // Border seluruh tabel
        if ($row > 3) {
            $sheet->getStyle('A2:I' . ($row - 1))
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );
        }
        // Auto width
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Freeze header
        $sheet->freezePane('A3');

        $writer = new Xlsx($spreadsheet);

        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'Report_Attendance_' . date('Ymd_His');

        return $this->response
            ->withType(
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            )
            ->withHeader(
                'Content-Disposition',
                'attachment; filename="' . $filename . '.xlsx"'
            )
            ->withBody($stream);
    }

    public function excelSummary($id = null)
    {
        $this->request->allowMethod(['get']);
        set_time_limit(0);
        $conn = ConnectionManager::get('default');
        $startDate = $this->request->getQuery('start_date');
        $endDate   = $this->request->getQuery('end_date');
        $datestart = $this->Krs->dateTo($startDate);
        $dateend   = $this->Krs->dateTo($endDate);
        $userSql = "SELECT id, name, working_hours FROM users WHERE id = :user_id AND is_active = 'Y' LIMIT 1";
        $user = $conn->execute($userSql, ['user_id' => $id])->fetch('assoc');
        if (!$user) {
            throw new \Cake\Http\Exception\NotFoundException('User tidak ditemukan.');
        }
        $jamMasuk = $this->Krs->workingHoursSchedule($user['working_hours'])['in'];
        $sql = "
            SELECT
                d.date,
                MIN(CASE WHEN a.inout_mode = 'I' THEN a.time_in END) AS time_in,
                MAX(CASE WHEN a.inout_mode = 'O' THEN a.time_out END) AS time_out,
                CASE WHEN COUNT(CASE WHEN a.inout_mode IN ('I', 'O') THEN 1 END) > 0
                    THEN 'Y' ELSE 'N'
                END AS hadir,
               CASE
                    WHEN COUNT(CASE WHEN a.inout_mode = 'I' THEN 1 END) > 0
                    THEN
                        CASE
                            WHEN TIME(MIN(CASE WHEN a.inout_mode = 'I' THEN a.time_in END)) > TIME(:jam_masuk)
                            THEN CEIL(
                                TIMESTAMPDIFF(SECOND,
                                    TIME(:jam_masuk),
                                    TIME(MIN(CASE WHEN a.inout_mode = 'I' THEN a.time_in END))
                                ) / 60
                            )
                            ELSE 0
                        END
                    ELSE NULL
                END AS terlambat,
                CASE 
                    WHEN COUNT(CASE WHEN a.inout_mode = 'I' THEN 1 END) = 0 
                        AND COUNT(CASE WHEN a.inout_mode = 'O' THEN 1 END) > 0
                    THEN 'Tidak ada absen masuk' 
                    ELSE NULL 
                END AS keterangan_tanpa_absen_masuk,
                (
                    SELECT SEC_TO_TIME(
                        SUM(TIMESTAMPDIFF(SECOND,
                            STR_TO_DATE(o.time_from, '%H:%i'),
                            STR_TO_DATE(o.time_end, '%H:%i')
                        ))
                    )
                    FROM overtimes o
                    WHERE o.status_approve = 'Y'
                    AND CAST(o.is_create AS UNSIGNED) = :uid_lembur
                    AND o.date = d.date
                ) AS lembur,
                (
                    SELECT COUNT(*)
                    FROM license_absents la
                    WHERE CAST(la.is_create AS UNSIGNED) = :uid_ijin
                    AND la.date_from = d.date
                ) AS ijin,
                (
                    SELECT la.check_status
                    FROM license_absents la
                    WHERE CAST(la.is_create AS UNSIGNED) = :uid_ijin
                    AND la.date_from = d.date
                    AND la.check_status IS NOT NULL
                    LIMIT 1
                ) AS ijin_status,
                (
                    SELECT COUNT(*)
                    FROM leaves l
                    WHERE CAST(l.is_create AS UNSIGNED) = :uid_cuti
                    AND l.is_cancel = 0
                    AND (
                        (
                            l.date_from IS NOT NULL
                            AND l.date_end IS NOT NULL
                            AND d.date BETWEEN l.date_from AND l.date_end
                        )
                        OR d.date = l.date_1
                        OR d.date = l.date_2
                        OR d.date = l.date_3
                    )
                ) AS cuti,
                (
                    SELECT COUNT(*)
                    FROM license_early_leaves lel
                    WHERE CAST(lel.is_create AS UNSIGNED) = :uid_permisi
                    AND lel.date = d.date
                ) AS permisi
            FROM (
                SELECT DISTINCT date
                FROM absences
                WHERE user_id = :uid_absen
                    AND date BETWEEN :gen_start AND :gen_end
                
                UNION
                SELECT DISTINCT date
                FROM overtimes
                WHERE status_approve = 'Y'
                    AND CAST(is_create AS UNSIGNED) = :uid_lembur
                    AND date BETWEEN :gen_start AND :gen_end
                
                UNION
                SELECT DISTINCT date_from AS date
                FROM license_absents
                WHERE CAST(is_create AS UNSIGNED) = :uid_ijin
                    AND date_from BETWEEN :gen_start AND :gen_end
                -- CUTI MODEL LAMA
                UNION
                SELECT DISTINCT DATE_ADD(l.date_from, INTERVAL seq.seq DAY) AS date
                FROM leaves l
                CROSS JOIN (
                    SELECT t0.n + t1.n*10 + t2.n*100 AS seq
                    FROM
                        (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                        (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                        (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2
                ) seq
                WHERE CAST(l.is_create AS UNSIGNED) = :uid_cuti
                AND l.is_cancel = 0
                AND l.date_from IS NOT NULL
                AND l.date_end IS NOT NULL
                AND DATE_ADD(l.date_from, INTERVAL seq.seq DAY) <= l.date_end
                AND DATE_ADD(l.date_from, INTERVAL seq.seq DAY)
                    BETWEEN :gen_start AND :gen_end

                -- CUTI MODEL BARU
                UNION
                SELECT date_1 AS date
                FROM leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_cuti
                AND is_cancel = 0
                AND date_1 IS NOT NULL
                AND date_1 BETWEEN :gen_start AND :gen_end

                UNION
                SELECT date_2 AS date
                FROM leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_cuti
                AND is_cancel = 0
                AND date_2 IS NOT NULL
                AND date_2 BETWEEN :gen_start AND :gen_end

                UNION
                SELECT date_3 AS date
                FROM leaves
                WHERE CAST(is_create AS UNSIGNED) = :uid_cuti
                AND is_cancel = 0
                AND date_3 IS NOT NULL
                AND date_3 BETWEEN :gen_start AND :gen_end
            ) d
            LEFT JOIN absences a
                ON a.user_id = :uid_absen
                AND a.date = d.date
            GROUP BY d.date
            ORDER BY d.date ASC
        ";
        $rows = $conn->execute($sql, [
            'uid_lembur'  => $id,
            'uid_ijin'    => $id,
            'uid_cuti'    => $id,
            'uid_permisi' => $id,
            'uid_absen'   => $id,   
            'gen_start'   => $datestart,
            'gen_end'     => $dateend,
            'jam_masuk' => $jamMasuk
        ])->fetchAll('assoc');
        
        // Hitung total (sama seperti view)
        $totalHadir   = count(array_filter($rows, fn($r) => $r['hadir'] === 'Y'));
        $totalTelat   = count(array_filter($rows, fn($r) => !empty($r['terlambat']) && $r['terlambat'] > 0));
        $totalCuti    = array_sum(array_column($rows, 'cuti'));
        $totalPermisi = array_sum(array_column($rows, 'permisi'));
        $totalIjinS   = count(array_filter($rows, fn($r) => $r['ijin_status'] === 'Sesuai'));
        $totalIjinTS  = count(array_filter($rows, fn($r) => $r['ijin_status'] === 'Tidak Sesuai'));
        
        $totalLembur = 0;
        foreach ($rows as $r) {
            if (!empty($r['lembur'])) {
                [$h, $m, $s] = array_pad(explode(':', $r['lembur']), 3, 0);
                $totalLembur += ($h * 3600) + ($m * 60) + $s;
            }
        }
        $lemburJam   = floor($totalLembur / 3600);
        $lemburMenit = floor(($totalLembur % 3600) / 60);
        
        // Load PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set title sheet
        $sheet->setTitle('Summary ' . substr($user['name'], 0, 20));
        $row = 1;

        // LINE 1: PERIODE (merge semua kolom)
        $sheet->mergeCells('A' . $row . ':J' . $row);
        $sheet->setCellValue('A' . $row, 'Periode : ' . date('d/m/Y', strtotime($startDate)) . ' s/d ' . date('d/m/Y', strtotime($endDate)));
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFF2CC'
                ]
            ]
        ]);
        $row++;

        // LINE 2: NAMA USER (merge semua kolom)
        $sheet->mergeCells('A' . $row . ':J' . $row);
        $sheet->setCellValue('A' . $row, 'Nama : ' . $user['name']);
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFF2CC'
                ]
            ]
        ]);
        $row++;

        // LANGSUNG HEADER TABLE (tanpa spasi)
        $headers = ['No', 'Tanggal', 'Masuk', 'Keluar', 'Hadir', 'Terlambat', 'Lembur (Jam)', 'Ijin', 'Cuti', 'Permisi'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle($col . $row)->getFill()->getStartColor()->setARGB('FF343A40');
            $sheet->getStyle($col . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
            $col++;
        }
        $row++;
        // ============================================================
        // TABLE DATA (Sama persis dengan view)
        // ============================================================
        $no = 1;
        foreach ($rows as $data) {
            $col = 'A';
            $sheet->setCellValue($col++ . $row, $no++);
            $sheet->setCellValue($col++ . $row, date('d/m/Y', strtotime($data['date'])));
            $sheet->setCellValue($col++ . $row, !empty($data['time_in']) ? substr($data['time_in'], 0, 5) : '-');
            $sheet->setCellValue($col++ . $row, !empty($data['time_out']) ? substr($data['time_out'], 0, 5) : '-');
            // $sheet->setCellValue($col++ . $row, $data['hadir'] === 'Y' ? '✓' : '-');
            $hadirText = $data['hadir'] === 'Y' ? '✓' : '-';
            if ($data['hadir'] === 'Y' && !empty($data['keterangan_tanpa_absen_masuk'])) {
                $hadirText .= chr(10) . $data['keterangan_tanpa_absen_masuk'];
            }
            $hadirCell = $col++ . $row;
            $sheet->setCellValue($hadirCell, $hadirText);
            $sheet->getStyle($hadirCell)->getAlignment()->setWrapText(true);
            
            // Beri warna merah jika hanya absen keluar
            if ($data['hadir'] === 'Y' && !empty($data['keterangan_tanpa_absen_masuk'])) {
                $sheet->getStyle($hadirCell)->applyFromArray([
                    'font' => [
                        'color' => ['argb' => 'FFFF0000'],
                        'bold' => true
                    ]
                ]);
            }
            $terlambatText = '-';
            if (!empty($data['terlambat']) && $data['terlambat'] > 0) {
                $terlambatText = $data['terlambat'] . ' menit';
            }
            $sheet->setCellValue($col++ . $row, $terlambatText);
            $sheet->setCellValue($col++ . $row, !empty($data['lembur']) ? $data['lembur'] : '-');
            $ijinText = '-';
            if ($data['ijin'] > 0) {
                $ijinText = '✓';
                if (!empty($data['ijin_status'])) {
                    $ijinText .= chr(10) . ($data['ijin_status'] === 'Sesuai' ? '(Sesuai)' : '(Tdk Sesuai)');
                }
            }
            $ijinCell = $col++ . $row;
            $sheet->setCellValue($ijinCell, $ijinText);
            $sheet->getStyle($ijinCell)->getAlignment()->setWrapText(true);
            $sheet->setCellValue($col++ . $row, $data['cuti'] > 0 ? '✓' : '-');
            $sheet->setCellValue($col++ . $row, $data['permisi'] > 0 ? '✓' : '-');
            $sheet->getStyle('A' . $row . ':J' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $row . ':J' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            
            $row++;
        }
        
        // ============================================================
        // APPLY STYLING
        // ============================================================
        
        // Border untuk seluruh tabel
        $lastRow = $row - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        if ($lastRow >= 2) {
            $sheet->getStyle('A2:J' . $lastRow)->applyFromArray($styleArray);
        }
        
        // Auto size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set row height untuk baris data
        for ($i = 3; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(35);
        }
        
        // Wrap text untuk kolom Ijin (karena bisa multiline)
        $sheet->getStyle('H3:H' . $lastRow)->getAlignment()->setWrapText(true);
        
        // ============================================================
        // OUTPUT FILE
        // ============================================================
        $filename = 'Summary_Absensi_' . $user['name'] . '_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
