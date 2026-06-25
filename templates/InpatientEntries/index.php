<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $registrations
 * @var array $rooms
 * @var string $q
 * @var string|null $roomId
 */

function formatInapDate($value, $format = 'd-m-Y H:i')
{
    if (empty($value)) {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format($format);
    }

    $time = strtotime((string)$value);
    return $time ? date($format, $time) : '-';
}
?>

<?= $this->Krs->breadcrumb('Rawat Inap', 'Instalasi Rawat Inap') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-bed"></i> Instalasi Rawat Inap
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <div style="background:#eef3ff; border:1px solid #cfd8ea; padding:10px; margin-bottom:10px;">
            <div class="row">
                <div class="col-md-5">
                    <label>Cari Pasien</label>
                    <input type="text" name="q" class="form-control"
                           placeholder="Nama pasien / No RM / No Registrasi / Dokter"
                           value="<?= h($q) ?>">
                </div>

                <div class="col-md-4">
                    <label>Bangsal</label>
                    <select name="room_id" class="form-control">
                        <option value="">Semua Bangsal</option>
                        <?php foreach ($rooms as $id => $name): ?>
                            <option value="<?= h($id) ?>" <?= (string)$roomId === (string)$id ? 'selected' : '' ?>>
                                <?= h($name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    <?= $this->Html->link(
                        '<i class="fa fa-plus"></i> Entry Rawat Inap',
                        ['controller' => 'Registrations', 'action' => 'add'],
                        ['escape' => false, 'class' => 'btn btn-primary']
                    ) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <div class="table-responsive">
            <table class="table table-bordered table-inap" style="font-size:12px;">
                <thead>
                    <tr>
                        <th width="34"></th>
                        <th width="34"></th>
                        <th width="58">Hasil</th>
                        <th width="74">Ass Awal</th>
                        <th width="34"></th>
                        <th width="95">Catatan</th>
                        <th width="72">Vital</th>
                        <th width="132">No Registrasi</th>
                        <th width="85">No RM</th>
                        <th>Nama Pasien</th>
                        <th width="64">Gender</th>
                        <th width="125">Tgl Masuk</th>
                        <th width="110">Ruang</th>
                        <th width="82">Kelas</th>
                        <th width="70">Bed</th>
                        <th width="120">Cara Bayar</th>
                        <th width="115">Rencana Pulang</th>
                        <th width="165">Dokter</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($registrations) || !count($registrations)): ?>
                    <tr>
                        <td colspan="18" class="text-center" style="padding:30px; color:#777;">
                            Data rawat inap tidak ditemukan
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

                        $roomName = $row->room->room_name
                            ?? $row->room_name
                            ?? '-';

                        $bedName = $row->bed->bed_no
                            ?? $row->bed->bed_name
                            ?? $row->bed->name
                            ?? '-';

                        $className = $row->class_name
                            ?? $row->bed->class_name
                            ?? $row->room->room_class
                            ?? '-';

                        $payment = $row->payment_method ?? '-';
                        if (!empty($row->insurance_type)) {
                            $payment .= ' - ' . $row->insurance_type;
                        }

                        $tglMasuk = '-';
                        if (!empty($row->registration_date)) {
                            $tglMasuk = formatInapDate($row->registration_date, 'd-m-Y');
                            if (!empty($row->admission_time)) {
                                $tglMasuk .= '<br><small>' . h($row->admission_time) . ' WIB</small>';
                            }
                        }

                        $rencanaPulang = $row->planned_discharge_date
                            ?? $row->planned_check_out_date
                            ?? null;
                        ?>

                        <tr style="background:<?= $rowColor ?>;">
                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-icon" title="Gambar / Dokumen">
                                    <i class="fa fa-image"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-icon" title="Edit / Input">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-blue" title="Hasil">
                                    Hasil
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-purple" title="Assessment Awal">
                                    Ass Awal
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-icon" title="Detail">
                                    <i class="fa fa-list-alt"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-green" title="Catatan Pengobatan">
                                    Cat. Pengobatan
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="#" class="btn-action btn-action-blue" title="Vital Sign">
                                    Vitalsign
                                </a>
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

                            <td><?= h($roomName) ?></td>

                            <td class="text-center">
                                <span class="badge-class"><?= h($className) ?></span>
                            </td>

                            <td class="text-center"><?= h($bedName) ?></td>

                            <td><?= h($payment) ?></td>

                            <td class="text-center">
                                <?= !empty($rencanaPulang) ? h(formatInapDate($rencanaPulang, 'd-m-Y')) : '-' ?>
                            </td>

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
.table-inap {
    margin-bottom: 0;
}

.table-inap > thead > tr > th {
    background:#1e3a5f !important;
    color:#fff !important;
    border-color:#2d4f7f !important;
    text-align:center;
    vertical-align:middle;
    font-size:11px;
    padding:5px 5px !important;
    height:28px;
    white-space:nowrap;
}

.table-inap td {
    vertical-align:middle !important;
    padding:3px 5px !important;
    height:28px;
    border-color:#9fb6c8 !important;
    white-space:nowrap;
}

.table-inap > tbody > tr:hover {
    background:#fff3cd !important;
}

.btn-action {
    display:inline-block;
    min-width:52px;
    height:23px;
    line-height:21px;
    padding:0 6px;
    font-size:10px;
    font-weight:600;
    border-radius:2px;
    border:1px solid #7d7d7d;
    background:#ececec;
    color:#333 !important;
    text-decoration:none !important;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.7);
}

.btn-action:hover {
    background:#dcdcdc;
    color:#000 !important;
}

.btn-action-icon {
    min-width:25px;
    width:25px;
    padding:0;
    text-align:center;
}

.btn-action-blue {
    background:#d9e7f5;
    border-color:#7f9db9;
    color:#1e3a5f !important;
}

.btn-action-green {
    background:#dfeedd;
    border-color:#7ea87a;
    color:#2d5a27 !important;
}

.btn-action-purple {
    background:#ebe1f5;
    border-color:#8e79a8;
    color:#4b2f69 !important;
}

.badge-class {
    background:#e9ecef;
    padding:1px 7px;
    border-radius:10px;
    font-size:10px;
    font-weight:600;
    border:1px solid #c9c9c9;
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