<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient[]|\Cake\Collection\CollectionInterface $patients
 * @var string|null $key
 * @var string|null $gender
 * @var string|null $isActive
 */

// Helper hitung umur dari tanggal lahir
function hitungUmur($birthDate) {
    if (empty($birthDate)) return '—';
    try {
        if ($birthDate instanceof \Cake\I18n\FrozenDate || $birthDate instanceof \Cake\I18n\Date) {
            $birth = new \DateTime($birthDate->format('Y-m-d'));
        } else {
            $birth = new \DateTime((string)$birthDate);
        }
        $now  = new \DateTime();
        $diff = $now->diff($birth);
        return $diff->y . ' th';
    } catch (\Exception $e) {
        return '—';
    }
}
?>

<!-- <?= $this->Krs->breadcrumb('Pasien', 'Tambah', null, true) ?> -->

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-users"></i> Data Pasien
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
                           placeholder="Cari kode pasien / nama / NIK / telepon..."
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
            <table class="table table-striped table-hover table-bordered table-patients"
                   style="font-size:13px;">
                <thead>
                    <tr class="text-center">
                        <th width="40">#</th>
                        <th width="120">Kode Pasien</th>
                        <th>Nama Lengkap</th>
                        <th width="80">Gender</th>
                        <th width="60">Umur</th>
                        <th width="120">No. Identitas</th>
                        <th width="130">No. Telepon</th>
                        <th width="150">Kota / Kab</th>
                        <th width="80">Status</th>
                        <th width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                foreach ($patients as $patient):
                    $isAktif  = ($patient->is_active === 'Y' || $patient->is_active === 1);
                    $isMale   = (strtolower($patient->gender ?? '') === 'male');
                    $umur     = hitungUmur($patient->birth_date);
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>

                    <!-- Kode Pasien -->
                    <td class="text-center">
                        <code style="font-size:11px;"><?= h($patient->code) ?></code>
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
                            <span style="font-weight:600;"><?= h($patient->full_name) ?></span>
                        </div>
                        <?php if (!empty($patient->identity_type)): ?>
                        <small style="color:#888; font-size:10px; margin-left:35px;">
                            <?= h($patient->identity_type) ?>
                        </small>
                        <?php endif; ?>
                    </td>

                    <!-- Gender -->
                    <td class="text-center">
                        <?php if ($isMale): ?>
                            <span style="background:#dbeafe; color:#1d4ed8; padding:2px 9px;
                                         border-radius:12px; font-size:11px; font-weight:600;">
                                ♂ L
                            </span>
                        <?php else: ?>
                            <span style="background:#fce7f3; color:#be185d; padding:2px 9px;
                                         border-radius:12px; font-size:11px; font-weight:600;">
                                ♀ P
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- Umur -->
                    <td class="text-center">
                        <span style="font-size:12px; color:#495057;">
                            <?php if (!empty($patient->birth_date)): ?>
                                <strong><?= $umur ?></strong>
                                <br>
                                <span style="font-size:10px; color:#aaa;">
                                    <?php
                                    $bd = $patient->birth_date;
                                    if ($bd instanceof \Cake\I18n\FrozenDate || $bd instanceof \Cake\I18n\Date) {
                                        echo $bd->format('d-m-Y');
                                    } else {
                                        $ts = strtotime((string)$bd);
                                        echo $ts ? date('d-m-Y', $ts) : '—';
                                    }
                                    ?>
                                </span>
                            <?php else: ?>
                                <span style="color:#ccc;">—</span>
                            <?php endif; ?>
                        </span>
                    </td>

                    <!-- No Identitas -->
                    <td style="font-size:11px;">
                        <?= !empty($patient->identity_number) ? h($patient->identity_number) : '<span style="color:#ccc;">—</span>' ?>
                    </td>

                    <!-- Telepon -->
                    <td style="font-size:12px;">
                        <?php if (!empty($patient->phone_number)): ?>
                            <i class="fa fa-phone" style="color:#28a745; font-size:10px;"></i>
                            <?= h($patient->phone_number) ?>
                        <?php else: ?>
                            <span style="color:#ccc;">—</span>
                        <?php endif; ?>
                    </td>

                    <!-- Kota -->
                    <td style="font-size:12px;">
                        <?php if (!empty($patient->city)): ?>
                            <i class="fa fa-map-marker-alt" style="color:#6c757d; font-size:10px;"></i>
                            <?= h($patient->city) ?>
                            <?php if (!empty($patient->province)): ?>
                                <br><small style="color:#aaa; font-size:10px;"><?= h($patient->province) ?></small>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color:#ccc;">—</span>
                        <?php endif; ?>
                    </td>

                    <!-- Status Active -->
                    <td class="text-center">
                        <?php if ($isAktif): ?>
                            <span class="label label-success">Active</span>
                        <?php else: ?>
                            <span class="label label-default">Non</span>
                        <?php endif; ?>
                    </td>

                    <!-- Aksi -->
                    <td class="text-center">
                        <div style="display:flex; gap:3px; justify-content:center;">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['action' => 'view', $patient->id],
                                ['escape' => false, 'class' => 'btn btn-info btn-xs',
                                 'data-toggle' => 'tooltip', 'title' => 'Detail']
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fa fa-edit"></i>',
                                ['action' => 'edit', $patient->id],
                                ['escape' => false, 'class' => 'btn btn-warning btn-xs',
                                 'data-toggle' => 'tooltip', 'title' => 'Edit']
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                ['action' => 'delete', $patient->id],
                                ['escape' => false, 'class' => 'btn btn-danger btn-xs',
                                 'confirm' => __('Yakin hapus pasien {0}?', $patient->full_name),
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
.table-patients > thead > tr > th {
    background: #2c3e50 !important;
    color: #ffffff !important;
    border-color: #3d5166 !important;
    padding: 10px 8px;
    vertical-align: middle;
    font-size: 12px;
    font-weight: 600;
}
.table-patients > thead > tr > th a,
.table-patients > thead > tr > th a:hover {
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