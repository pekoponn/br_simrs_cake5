<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $registrations
 * @var string $q
 */

function formatIgdDate($value, $format = 'd-m-Y')
{
    if (empty($value)) return '-';
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format($format);
    }
    $time = strtotime((string)$value);
    return $time ? date($format, $time) : '-';
}
?>

<?= $this->Krs->breadcrumb('IGD', 'Instalasi Rawat IGD') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-ambulance"></i> Instalasi Rawat IGD
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <div style="background:#eef3ff; border:1px solid #cfd8ea; padding:10px; margin-bottom:10px;">
            <div class="row">
                <div class="col-md-7">
                    <label>Cari Pasien</label>
                    <input type="text" name="q" class="form-control"
                           placeholder="Nama pasien / No RM / No Registrasi / Dokter"
                           value="<?= h($q) ?>">
                </div>

                <div class="col-md-5">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-search"></i> Cari
                    </button>

                    <?= $this->Html->link(
                        '<i class="fa fa-plus"></i> Entry IGD',
                        ['controller' => 'Registrations', 'action' => 'add'],
                        ['escape' => false, 'class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <div class="table-responsive">
            <table class="table table-bordered table-igd" style="font-size:12px;">
                <thead>
                    <tr>
                        <th width="34"></th>
                        <th width="34"></th>
                        <th width="60">Hasil</th>
                        <th width="80">Ass Awal</th>
                        <th width="70">Triase</th>
                        <th width="95">Catatan</th>
                        <th width="72">Vital</th>
                        <th width="135">No Registrasi</th>
                        <th width="90">No RM</th>
                        <th>Nama Pasien</th>
                        <th width="70">Gender</th>
                        <th width="130">Tgl Masuk</th>
                        <th width="130">Cara Bayar</th>
                        <th width="175">Dokter</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($registrations) || !count($registrations)): ?>
                    <tr>
                        <td colspan="14" class="text-center" style="padding:30px; color:#777;">
                            Data rawat IGD tidak ditemukan
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($registrations as $row): ?>
                        <?php
                        $gender = strtolower(trim($row->patient->gender ?? ''));

                        $isMale = in_array($gender, ['l', 'male', 'laki-laki', 'lakilaki'], true);
                        $isFemale = in_array($gender, ['p', 'female', 'perempuan'], true);

                        $rowColor = '#ffffff';
                        if ($isMale) {
                            $rowColor = '#cfefff';
                        } elseif ($isFemale) {
                            $rowColor = '#ffd6ec';
                        }

                        $registrationNo = $row->registration_no ?? $row->registration_number ?? '-';
                        $patientCode = $row->patient->code ?? '-';
                        $patientName = $row->patient->full_name ?? '-';

                        $doctorName = $row->doctor->doctor_name
                            ?? $row->doctor->name
                            ?? $row->doctor_name
                            ?? '-';

                        $payment = $row->payment_method ?? '-';
                        if (!empty($row->insurance_type)) {
                            $payment .= ' - ' . $row->insurance_type;
                        }

                        $tglMasuk = '-';
                        if (!empty($row->registration_date)) {
                            $tglMasuk = formatIgdDate($row->registration_date, 'd-m-Y');
                            if (!empty($row->admission_time)) {
                                $tglMasuk .= '<br><small>' . h($row->admission_time) . ' WIB</small>';
                            }
                        }
                        ?>

                        <tr style="background:<?= $rowColor ?>;">
                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-icon" title="Dokumen">
                                    <i class="fa fa-file"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-icon" title="Input">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-blue">Hasil</a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-purple">Ass Awal</a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-red">Triase</a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-green">Cat. IGD</a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-vital">Vitalsign</a>
                            </td>

                            <td style="font-family:monospace; font-weight:700;">
                                <?= h($registrationNo) ?>
                            </td>

                            <td><?= h($patientCode) ?></td>

                            <td style="font-weight:600;"><?= h($patientName) ?></td>

                            <td class="text-center">
                                <?php if ($isMale): ?>
                                    <span class="label label-info">L</span>
                                <?php elseif ($isFemale): ?>
                                    <span class="label label-danger">P</span>
                                <?php else: ?>
                                    <span class="label label-default">-</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $tglMasuk ?></td>

                            <td><?= h($payment) ?></td>

                            <td><?= h($doctorName) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= $this->Krs->paginators() ?>

    </div>
</div>

<style>
.table-igd > thead > tr > th {
    background:#1e3a5f !important;
    color:#fff !important;
    border-color:#2d4f7f !important;
    text-align:center;
    vertical-align:middle;
    font-size:11px;
    padding:5px !important;
    height:28px;
    white-space:nowrap;
}

.table-igd td {
    vertical-align:middle !important;
    padding:3px 5px !important;
    height:28px;
    border-color:#9fb6c8 !important;
    white-space:nowrap;
}

.table-igd > tbody > tr:hover {
    background:#fff3cd !important;
}

.btn-action {
    display:inline-block;
    min-width:58px;
    height:24px;
    line-height:22px;
    padding:0 6px;
    font-size:10px;
    font-weight:700;
    border-radius:2px;
    border:1px solid #4f4f4f;
    background:linear-gradient(to bottom, #f5f5f5 0%, #d6d6d6 50%, #c4c4c4 100%);
    color:#222 !important;
    text-decoration:none !important;
}

.btn-action:hover {
    background:linear-gradient(to bottom, #fff 0%, #e2e2e2 50%, #d0d0d0 100%);
    color:#000 !important;
}

.btn-action-icon {
    min-width:26px;
    width:26px;
    padding:0;
}

.btn-action-blue {
    background:linear-gradient(to bottom, #d5e8ff 0%, #9ec5f5 100%);
    border-color:#4c79a7;
    color:#143b67 !important;
}

.btn-action-green {
    background:linear-gradient(to bottom, #e4f2de 0%, #b7d7a8 100%);
    border-color:#5d8a52;
    color:#1e4e1e !important;
}

.btn-action-purple {
    background:linear-gradient(to bottom, #ede3fb 0%, #c7b2ea 100%);
    border-color:#7561a3;
    color:#43296a !important;
}

.btn-action-vital {
    background:linear-gradient(to bottom, #fff6d5 0%, #f2d680 100%);
    border-color:#a8862d;
    color:#5e4300 !important;
}

.btn-action-red {
    background:linear-gradient(to bottom, #ffdede 0%, #e49a9a 100%);
    border-color:#9a4b4b;
    color:#6b1f1f !important;
}

.label {
    padding:2px 7px;
    border-radius:4px;
    font-size:10px;
    font-weight:600;
}

.label-info {
    background:#5bc0de;
    color:#fff;
}

.label-danger {
    background:#d9534f;
    color:#fff;
}

.label-default {
    background:#777;
    color:#fff;
}
</style>