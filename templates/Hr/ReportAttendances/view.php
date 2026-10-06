<?php
/**
 * @var array $user
 * @var array $rows
 * @var string $startDate
 * @var string $endDate
 */
$totalHadir   = count(array_filter($rows, fn($r) => $r['hadir'] === 'Y'));
$totalTelat   = count(array_filter($rows, fn($r) => !empty($r['terlambat'])));
$totalCuti    = array_sum(array_column($rows, 'cuti'));
$totalPermisi = array_sum(array_column($rows, 'permisi'));
$totalIjinS   = count(array_filter($rows, fn($r) => $r['ijin_status'] === 'Sesuai'));
$totalIjinTS  = count(array_filter($rows, fn($r) => $r['ijin_status'] === 'Tidak Sesuai'));
$totalLembur  = 0;
foreach ($rows as $r) {
    if (!empty($r['lembur'])) {
        [$h, $m, $s] = array_pad(explode(':', $r['lembur']), 3, 0);
        $totalLembur += ($h * 3600) + ($m * 60) + $s;
    }
}
$lemburJam   = floor($totalLembur / 3600);
$lemburMenit = floor(($totalLembur % 3600) / 60);
// URL Excel
$excelUrl = $this->Url->build(['prefix'     => 'Hr', 'controller' => 'ReportAttendances', 'action'     => 'excelSummary', $user['id'],
]) . '?start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate);
?>

<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h5 class="modal-title mb-0 fw-bold"><i class="fa fa-user me-1"></i> <?= h($user['name']) ?> : <?= h($startDate) ?> s/d <?= h($endDate) ?></h5>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= $excelUrl ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Excel</a>
                <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        </div>
        <div class="modal-body">

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm mb-0 align-middle"
                       style="font-size:13px">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="40">No</th>
                            <th>Tanggal</th>
                            <!-- <th>Hari</th> -->
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Hadir</th>
                            <th>Terlambat</th>
                            <th>Lembur (Jam)</th>
                            <th>Ijin</th>
                            <th>Cuti</th>
                            <th>Permisi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                Tidak ada data.
                            </td>
                        </tr>
                    <?php else: ?>
                    <?php
                        $no = 1;
                        foreach ($rows as $row):
                            $dateObj  = new \DateTime($row['date']);
                            $dayEn    = $dateObj->format('l');
                            // $hariInd  = $dayNames[$dayEn] ?? $dayEn;
                            // $isMinggu = in_array($dayEn, ['Sunday']);
                            // $trStyle  = $isMinggu ? 'background:#f0f0f0;color:#aaa;' : '';
                    ?>
                    <tr >
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= date('d/m/Y', strtotime($row['date'])) ?></td>
                        <td class="text-center">
                            <?= !empty($row['time_in'])  ? $row['time_in'] : '-' ?>
                        </td>
                        <td class="text-center">
                            <?= !empty($row['time_out']) ? $row['time_out'] : '-' ?>
                        </td>
                        <td class="text-center">
                            <?php if ($row['hadir'] === 'Y'): ?>
                                <i class="fas fa-check text-success"></i>
                                <?php if (!empty($row['keterangan_tanpa_absen_masuk'])): ?>
                                    <br>
                                    <small class="text-danger ml-1">(<?= h($row['keterangan_tanpa_absen_masuk']) ?>)</small>
                                    <?php if (!empty($row['absent_issue_description'])): ?>
                                        <br>
                                        <small class="text-muted ml-1"><?= h($row['absent_issue_description']) ?></small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if (!empty($row['terlambat']) && $row['terlambat'] > 0): ?>
                                <span class="badge badge-danger">
                                    <i class="fas fa-clock"></i> <?= $row['terlambat'] ?> menit
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?= !empty($row['lembur']) ? $row['lembur'] : '-' ?>
                        </td>
                        <td class="text-center">
                            <?php if ($row['ijin'] > 0): ?>
                                <i class="fas fa-check text-success"></i>
                                <?php if (!empty($row['ijin_status'])): ?>
                                    <br>
                                    <?php if ($row['ijin_status'] === 'Sesuai'): ?>
                                        <small class="text-success ml-1">(Sesuai)</small>
                                    <?php elseif ($row['ijin_status'] === 'Tidak Sesuai'): ?>
                                        <small class="text-danger ml-1">(Tdk Sesuai)</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    
                                <?php endif; ?>
                                <?php if (!empty($row['ijin_description'])): ?>
                                    <br>
                                    <small class="text-muted ml-1"><?= h($row['ijin_description']) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($row['cuti'] > 0): ?>
                                <i class="fas fa-check text-success"></i>
                                <?php if (!empty($row['cuti_description'])): ?>
                                    <br>
                                    <small class="text-muted ml-1"><?= h($row['cuti_description']) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($row['permisi'] > 0): ?>
                                <i class="fas fa-check text-success"></i>
                                <?php if (!empty($row['permisi_description'])): ?>
                                    <br>
                                    <small class="text-muted ml-1"><?= h($row['permisi_description']) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>