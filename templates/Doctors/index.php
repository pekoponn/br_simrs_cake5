<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctor[]|\Cake\Collection\CollectionInterface $doctors
 * @var string|null $key
 * @var string|null $gender
 * @var string|null $isActive
 */
?>

<?= $this->Krs->breadcrumb('Dokter', 'Tampilkan') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-user-md"></i> Data Dokter
        </h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">

        <!-- ── TOOLBAR ──────────────────────────────────────────────────── -->
        <div class="row m-b-10 align-items-end">

            <!-- Kiri: Tambah + Filter Gender + Filter Active -->
            <div class="col-md-6" style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">

                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> Tambah',
                    ['action' => 'add'],
                    ['class' => 'btn btn-inverse btn-sm', 'escape' => false]
                ) ?>

                <!-- Filter Gender -->
                <div class="btn-group btn-group-sm">
                    <?php
                    $genderFilters = [
                        ''       => ['label' => 'Semua',      'class' => 'btn-default'],
                        'Male'   => ['label' => '♂ Laki-laki', 'class' => 'btn-primary'],
                        'Female' => ['label' => '♀ Perempuan', 'class' => 'btn-pink'],
                    ];
                    foreach ($genderFilters as $val => $opt):
                        $active = ((string)($gender ?? '') === $val) ? 'active' : '';
                    ?>
                        <a href="<?= $this->Url->build(['action' => 'index', '?' => [
                            'gender'    => $val,
                            'key'       => $this->request->getQuery('key'),
                            'is_active' => $this->request->getQuery('is_active'),
                        ]]) ?>" class="btn <?= $opt['class'] ?> <?= $active ?>">
                            <?= $opt['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Filter Active -->
                <div class="btn-group btn-group-sm">
                    <?php
                    $activeFilters = [
                        ''  => ['label' => 'Semua',      'class' => 'btn-default'],
                        'Y' => ['label' => '✔ Aktif',     'class' => 'btn-success'],
                        'N' => ['label' => '✖ Non Aktif', 'class' => 'btn-danger'],
                    ];
                    foreach ($activeFilters as $val => $opt):
                        $active = ((string)($isActive ?? '') === $val) ? 'active' : '';
                    ?>
                        <a href="<?= $this->Url->build(['action' => 'index', '?' => [
                            'is_active' => $val,
                            'key'       => $this->request->getQuery('key'),
                            'gender'    => $this->request->getQuery('gender'),
                        ]]) ?>" class="btn <?= $opt['class'] ?> <?= $active ?>">
                            <?= $opt['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>

            </div>

            <!-- Kanan: Search -->
            <div class="col-md-6">
                <?= $this->Form->create(null, ['type' => 'get']) ?>
                <div class="input-group pull-right" style="max-width:400px; width:100%;">
                    <input type="text" name="key" class="form-control"
                           placeholder="Cari kode / nama / NIK / spesialis / poliklinik..."
                           value="<?= h($this->request->getQuery('key')) ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="<?= $this->Url->build(['action' => 'index']) ?>"
                           class="btn btn-default" title="Reset filter">
                            <i class="fa fa-rotate-left"></i>
                        </a>
                    </span>
                </div>
                <?= $this->Form->end() ?>
            </div>

        </div>

        <!-- ── TABLE ────────────────────────────────────────────────────── -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered table-doctors"
                   style="font-size:13px;">
                <thead>
                    <tr class="text-center">
                        <th width="40">#</th>
                        <th width="90">Kode</th>
                        <th width="220">Nama Dokter</th>
                        <th width="130">NIK</th>
                        <th width="130">Poliklinik</th>
                        <th width="80">Gender</th>
                        <th width="120">No. SIP</th>
                        <th width="120">No. STR</th>
                        <th width="120">No. Telepon</th>
                        <th width="80">Status</th>
                        <th width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($doctors as $doctor):
                    $isAktif = ($doctor->is_active === 'Y' || $doctor->is_active === 1);
                    $isMale  = (strtolower($doctor->gender ?? '') === 'male');
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>

                    <!-- Kode -->
                    <td class="text-center">
                        <code style="font-size:11px;"><?= h($doctor->code) ?></code>
                    </td>

                    <!-- Nama -->
                    <td>
                        <div style="display:flex; align-items:center; gap:7px;">
                            <span style="width:28px; height:28px; border-radius:50%;
                                        background:<?= $isMale ? '#dbeafe' : '#fce7f3' ?>;
                                        color:<?= $isMale ? '#1d4ed8' : '#be185d' ?>;
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:13px; flex-shrink:0;">
                                <?= $isMale ? '♂' : '♀' ?>
                            </span>
                            <span style="font-weight:600;"><?= h($doctor->doctor_name) ?></span>
                        </div>
                    </td>

                    <!-- NIK -->
                    <td style="font-size:11px;">
                        <?= !empty($doctor->nik) ? h($doctor->nik) : '<span style="color:#ccc;">—</span>' ?>
                    </td>

                    <!-- Poliklinik -->
                    <td style="font-size:12px;">
                        <?= !empty($doctor->polyclinic_name)
                            ? '<span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600;">' . h($doctor->polyclinic_name) . '</span>'
                            : '<span style="color:#ccc;">—</span>' ?>
                    </td>

                    <!-- Gender -->
                    <td class="text-center">
                        <?php if ($isMale): ?>
                            <span style="background:#dbeafe;color:#1d4ed8;padding:2px 9px;
                                        border-radius:12px;font-size:11px;font-weight:600;">
                                ♂ L
                            </span>
                        <?php else: ?>
                            <span style="background:#fce7f3;color:#be185d;padding:2px 9px;
                                        border-radius:12px;font-size:11px;font-weight:600;">
                                ♀ P
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- No SIP -->
                    <td style="font-size:11px;">
                        <?= !empty($doctor->sip_number) ? h($doctor->sip_number) : '<span style="color:#ccc;">—</span>' ?>
                    </td>

                    <!-- No STR -->
                    <td style="font-size:11px;">
                        <?= !empty($doctor->str_number) ? h($doctor->str_number) : '<span style="color:#ccc;">—</span>' ?>
                    </td>

                    <!-- Telepon -->
                    <td style="font-size:12px;">
                        <?php if (!empty($doctor->phone_number)): ?>
                            <i class="fa fa-phone" style="color:#28a745;font-size:10px;"></i>
                            <?= h($doctor->phone_number) ?>
                        <?php else: ?>
                            <span style="color:#ccc;">—</span>
                        <?php endif; ?>
                    </td>

                    <!-- Status -->
                    <td class="text-center">
                        <?php if ($isAktif): ?>
                            <span class="label label-success">Aktif</span>
                        <?php else: ?>
                            <span class="label label-default">Non</span>
                        <?php endif; ?>
                    </td>

                    <!-- Aksi -->
                    <td class="text-center">
                        <div style="display:flex; gap:3px; justify-content:center;">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['action' => 'view', $doctor->id],
                                ['escape' => false, 'class' => 'btn btn-info btn-xs',
                                'data-toggle' => 'tooltip', 'title' => 'Detail']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit"></i>',
                                ['action' => 'edit', $doctor->id],
                                ['escape' => false, 'class' => 'btn btn-warning btn-xs',
                                'data-toggle' => 'tooltip', 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                ['action' => 'delete', $doctor->id],
                                ['escape' => false, 'class' => 'btn btn-danger btn-xs',
                                'confirm' => __('Yakin hapus dokter {0}?', $doctor->doctor_name),
                                'data-toggle' => 'tooltip', 'title' => 'Hapus']
                            ) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?= $this->Krs->paginators() ?>

    </div>
</div>

<style>
.table-doctors > thead > tr > th {
    background: #2c3e50 !important;
    color: #ffffff !important;
    border-color: #3d5166 !important;
    padding: 10px 8px;
    vertical-align: middle;
    font-size: 12px;
    font-weight: 600;
}
.table-doctors > thead > tr > th a,
.table-doctors > thead > tr > th a:hover {
    color: #ffffff !important;
    text-decoration: none;
}
.btn-xs  { padding:3px 8px; font-size:12px; line-height:1.5; border-radius:4px; }
.btn-pink { background:#ec4899; border-color:#db2777; color:#fff; }
.btn-pink:hover, .btn-pink.active { background:#db2777; color:#fff; }
.label   { padding:4px 9px; border-radius:6px; font-size:11px; font-weight:600; display:inline-block; }
.label-success { background:#d1e7dd; color:#0f5132; }
.label-default { background:#e9ecef; color:#495057; }
</style>

<script>
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>