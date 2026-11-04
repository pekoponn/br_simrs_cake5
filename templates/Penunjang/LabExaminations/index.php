<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item active">Laboratorium</li>
</ol>
<h1 class="page-header">Laboratorium <small>Instalasi Laboratorium</small></h1>

<div class="row">

    <!-- ===== MENU KIRI ===== -->
    <div class="col-lg-2 col-md-3">
        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-bars"></i> Menu</h4></div>
            <div class="panel-body p-2">
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-flask"></i> Isi Nilai Normal</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-user-md"></i> Nama Pengirim dan Petugas</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-vial"></i> Tindakan Laboratorium</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-history"></i> History Pemeriksaan</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left"><i class="fa fa-sticky-note"></i> Internal Memo</a>
            </div>
        </div>

        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-boxes"></i> Persediaan</h4></div>
            <div class="panel-body p-2">
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-box-open"></i> Persediaan Non Beban Pasien</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-file-invoice"></i> Permohonan Pembelian Persediaan</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-warehouse"></i> Informasi Stock</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-clipboard-list"></i> Permohonan Logistik</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left mb-1"><i class="fa fa-dolly"></i> Pemakaian Logistik</a>
                <a href="javascript:;" class="btn btn-default btn-block text-left"><i class="fa fa-list"></i> Daftar Stock Logistik</a>
            </div>
        </div>

        <a href="javascript:;" class="btn btn-info btn-block mb-1"><i class="fa fa-file-alt"></i> Laporan</a>
        <?= $this->Html->link('<i class="fa fa-sign-out-alt"></i> Keluar', ['prefix' => false, 'controller' => 'Dashboard', 'action' => 'index'], ['class' => 'btn btn-danger btn-block', 'escape' => false]) ?>
    </div>

    <!-- ===== KONTEN KANAN ===== -->
    <div class="col-lg-10 col-md-9">

        <!-- Info petugas -->
        <div class="panel panel-inverse">
            <div class="panel-body py-2">
                <div class="row text-center">
                    <div class="col-md-4"><b>Petugas :</b> <?= h($officer) ?></div>
                    <div class="col-md-4"><b>Shift :</b> 0</div>
                    <div class="col-md-4"><b>Jam :</b> <span id="lab-clock">--:--:--</span></div>
                </div>
            </div>
        </div>

        <!-- Tabel permintaan masuk (belum terhubung ke database) -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-inbox"></i> Permintaan Pemeriksaan Masuk</h4>
            </div>
            <div class="panel-body p-0">
                <div class="table-responsive" style="max-height:220px; overflow-y:auto;">
                    <table class="table table-bordered table-hover table-sm mb-0">
                        <thead class="thead-dark" style="position:sticky; top:0;">
                            <tr>
                                <th>No Daftar</th>
                                <th>Rek Medis</th>
                                <th>Tgl Masuk</th>
                                <th>Jam</th>
                                <th>Nama Pasien</th>
                                <th>Dr Pengirim</th>
                                <th>Asal</th>
                                <th>Pesan Dokter</th>
                                <th class="text-center" style="width:150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($requests) || count($requests) === 0): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fa fa-inbox fa-2x d-block mb-2"></i>
                                    Belum ada permintaan masuk
                                </td>
                            </tr>
                        <?php else: ?>
                        <?php foreach ($requests as $rq):
                            $tgl = $rq['tgl_order'];
                            $ts = $tgl ? strtotime((string)$tgl) : null;
                            $tglStr = $ts ? date('d-m-Y', $ts) : '-';
                            $jamStr = $ts ? date('H:i', $ts) : '-';
                            $asal = ['rawat_jalan' => 'Rawat Jalan', 'rawat_inap' => 'Rawat Inap', 'igd' => 'IGD'][$rq['service_type'] ?? ''] ?? '-';
                        ?>
                            <tr>
                                <td><code><?= h($rq['no_order']) ?></code></td>
                                <td><?= h($rq['rm']) ?></td>
                                <td><?= $tglStr ?></td>
                                <td><?= $jamStr ?></td>
                                <td><b><?= h($rq['patient_name']) ?></b><br><small class="text-muted"><?= h($rq['lab_names']) ?></small></td>
                                <td><?= h($rq['doctor_name']) ?></td>
                                <td><?= h($asal) ?></td>
                                <td><?= h($rq['pesan']) ?></td>
                                <td class="text-center">
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-play"></i> Proses',
                                        ['action' => 'proses', $rq['id']],
                                        ['class' => 'btn btn-xs btn-success', 'escape' => false, 'confirm' => 'Proses permintaan ini?']
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="panel panel-inverse">
            <div class="panel-body">
                <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
                <div class="form-row align-items-end">
                    <div class="col-md-2">
                        <label class="mb-1"><i class="fa fa-search"></i> Cari Pasien</label>
                        <?= $this->Form->select('by', [
                            'patient_name' => 'Nama Pasien',
                            'medical_record_no' => 'No RM',
                            'lab_no' => 'No Laborat',
                        ], ['value' => $by, 'class' => 'form-control', 'empty' => false]) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->text('q', ['value' => $q, 'class' => 'form-control', 'placeholder' => 'Ketik kata kunci...']) ?>
                    </div>
                    <div class="col-md-3">
                        <label class="mb-1"><i class="fa fa-calendar"></i> Pemeriksaan tanggal &gt;=</label>
                        <?= $this->Form->date('date_from', ['value' => $dateFrom, 'class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Cari</button>
                        <?= $this->Html->link('<i class="fa fa-sync"></i> Refresh Pasien', ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false]) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <!-- Tabel pemeriksaan -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-flask"></i> Daftar Pemeriksaan Laboratorium</h4>
            </div>
            <div class="panel-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width:150px;">Aksi</th>
                                <th>No Laborat</th>
                                <th>Rekmed</th>
                                <th>Nama Pasien</th>
                                <th>Tgl Diterima</th>
                                <th>Tgl Selesai</th>
                                <th>Pemeriksaan</th>
                                <th>Jenis Pasien</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($examinations->count() === 0): ?>
                            <tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data pemeriksaan</td></tr>
                        <?php endif; ?>
                        <?php foreach ($examinations as $e):
                            $badge = ['received' => 'badge-warning', 'processing' => 'badge-info', 'done' => 'badge-success'][$e->status] ?? 'badge-secondary';
                            $label = ['received' => 'Diterima', 'processing' => 'Diproses', 'done' => 'Selesai'][$e->status] ?? $e->status;
                        ?>
                            <tr>
                                <td class="text-center text-nowrap">
                                    <a href="javascript:;" class="btn btn-xs btn-primary" title="Hasil"><i class="fa fa-file-medical"></i> Hasil</a>
                                    <a href="javascript:;" class="btn btn-xs btn-default" title="Form Integrasi">Form Integrasi</a>
                                </td>
                                <td><code><?= h($e->lab_no) ?></code></td>
                                <td><?= h($e->medical_record_no) ?></td>
                                <td><b><?= h($e->patient_name) ?></b></td>
                                <td><?= $e->received_at ? $e->received_at->format('d-m-Y H:i') : '-' ?></td>
                                <td><?= $e->finished_at ? $e->finished_at->format('d-m-Y H:i') : '-' ?></td>
                                <td><?= h($e->examination_name) ?></td>
                                <td><?= h($e->patient_type) ?></td>
                                <td><span class="badge <?= $badge ?>"><?= h($label) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer d-flex justify-content-between align-items-center">
                <small class="text-muted"><?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}, total {{count}} data') ?></small>
                <ul class="pagination pagination-sm mb-0">
                    <?= $this->Paginator->prev('« Sebelumnya') ?>
                    <?= $this->Paginator->next('Berikutnya »') ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var el = document.getElementById('lab-clock');
    function tick() { el.textContent = new Date().toLocaleTimeString('id-ID', {hour12: false}); }
    tick(); setInterval(tick, 1000);
})();
</script>