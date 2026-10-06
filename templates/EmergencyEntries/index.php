<?php
/**
 * @var \App\View\AppView $this
 * @var iterable $registrations
 * @var string $q
 * @var string $dateFrom
 * @var string $dateTo
 * @var iterable $doctorsList
 * @var iterable $triageNurses
 */

function formatIgdDate($value, $format = 'd-m-Y')
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

$dateFrom = $dateFrom ?? date('Y-m-d');
$dateTo   = $dateTo ?? date('Y-m-d');
$medicalRecordNos = $medicalRecordNos ?? [];
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
        <div style="background:#f8f9fa; border:1px solid #dee2e6; border-radius:8px; padding:10px 12px; margin-bottom:14px;">
            <div class="row" style="display:flex; align-items:flex-end;">
                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        Dari Selesai
                    </label>
                    <input type="text" id="igd-date-from" class="form-control input-sm igd-date-filter"
                           value="<?= h(date('d/m/Y', strtotime($dateFrom))) ?>" autocomplete="off">
                    <input type="hidden" name="date_from" id="igd-date-from-value" value="<?= h($dateFrom) ?>">
                </div>

                <div class="col-md-2">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        Sampai Selesai
                    </label>
                    <input type="text" id="igd-date-to" class="form-control input-sm igd-date-filter"
                           value="<?= h(date('d/m/Y', strtotime($dateTo))) ?>" autocomplete="off">
                    <input type="hidden" name="date_to" id="igd-date-to-value" value="<?= h($dateTo) ?>">
                </div>

                <div class="col-md-4">
                    <label style="font-size:11px; font-weight:600; color:#555;">
                        <i class="fa fa-search"></i> Cari Pasien
                    </label>
                    <input type="text" name="q" class="form-control input-sm"
                           placeholder="Nama pasien / No RM / No Registrasi / Dokter"
                           value="<?= h($q ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fa fa-search"></i> Cari
                    </button>

                    <?= $this->Html->link(
                        '<i class="fa fa-times"></i> Reset',
                        ['action' => 'index'],
                        ['escape' => false, 'class' => 'btn btn-default btn-sm']
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-plus"></i> Entry IGD',
                        ['controller' => 'Registrations', 'action' => 'add'],
                        ['escape' => false, 'class' => 'btn btn-primary btn-sm']
                    ) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <div style="margin-bottom:10px; display:flex; gap:8px; align-items:center;">
            <span style="font-size:12px; color:#6c757d;">
                <i class="fa fa-calendar-day"></i>
                <?php if ($dateFrom === $dateTo): ?>
                    Tanggal: <strong><?= $this->Krs->tanggalIndoLengkap($dateFrom, true) ?></strong>
                <?php else: ?>
                    Periode: <strong><?= $this->Krs->tanggalIndoLengkap($dateFrom, false) ?></strong>
                    &nbsp;—&nbsp;
                    <strong><?= $this->Krs->tanggalIndoLengkap($dateTo, false) ?></strong>
                <?php endif; ?>
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-igd" style="font-size:12px;">
                <thead>
                    <tr>
                        <th width="45">No<br>Antri</th>
                        <th width="360">Aksi</th>
                        <th width="90">No RM</th>
                        <th width="135">No Registrasi</th>
                        <th>Nama Pasien</th>
                        <th width="70">Gender</th>
                        <th width="130">Tgl Masuk</th>
                        <th width="150">Tgl Selesai</th>
                        <th width="140">Cara Bayar</th>
                        <th width="175">Dokter</th>
                    </tr>
                </thead>

                <?php
                $kmaCtxMap = [];
                $lastTglMasukKey = null;
                $noAntriCounter = 0;
                ?>
                <tbody>
                <?php if (empty($registrations) || !count($registrations)): ?>
                    <tr>
                        <td colspan="10" class="text-center" style="padding:30px; color:#777;">
                            Data rawat IGD tidak ditemukan
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($registrations as $row): ?>
                        <?php
                        // ── Tentukan tanggal masuk (untuk pemisah baris & reset nomor antri per hari) ──
                        $rowDateRaw = $row->registration_date ?? $row->created ?? null;
                        $tglMasukKey = null;
                        if (!empty($rowDateRaw)) {
                            $tglMasukKey = is_object($rowDateRaw)
                                ? $rowDateRaw->format('Y-m-d')
                                : date('Y-m-d', strtotime((string)$rowDateRaw));
                        }

                        if ($tglMasukKey !== $lastTglMasukKey) {
                            $lastTglMasukKey = $tglMasukKey;
                            $noAntriCounter = 1;
                        ?>
                            <tr class="date-separator-row-igd">
                                <td colspan="10">
                                    <i class="fa fa-calendar-day"></i>
                                    <?= $tglMasukKey ? $this->Krs->tanggalIndoLengkap($tglMasukKey, true) : 'Tanggal tidak diketahui' ?>
                                </td>
                            </tr>
                        <?php
                        } else {
                            $noAntriCounter++;
                        }

                        $gender = strtolower(trim($row->patient->gender ?? ''));

                        $isMale = in_array($gender, ['l', 'male', 'laki-laki', 'lakilaki'], true);
                        $isFemale = in_array($gender, ['p', 'female', 'perempuan'], true);

                        $rowColor = '#ffffff';
                        if ($isMale) {
                            $rowColor = '#cfefff';
                        } elseif ($isFemale) {
                            $rowColor = '#ffd6ec';
                        }

                        $registrationNo = $row->registration_no ?? '-';
                        $patientCode = $row->patient->code ?? '-';

                        $patientTitle = $row->patient->title ?? '';
                        $patientFullName = $row->patient->full_name ?? '-';
                        $patientName = trim(($patientTitle !== '' ? $patientTitle . ' ' : '') . $patientFullName);

                        $doctorName = $row->doctor->doctor_name ?? '-';

                        $payment = $row->payment_method ?? '-';
                        if (!empty($row->insurance_type)) {
                            $payment .= ' - ' . $row->insurance_type;
                        }

                        // Tgl Masuk tetap dari tanggal masuk registrasi, ditambah jam.
                        // Jika admission_time kosong, ambil jam dari created sebagai cadangan.
                        $tglMasuk = '-';
                        if (!empty($row->registration_date)) {
                            $tglMasuk = formatIgdDate($row->registration_date, 'd-m-Y');

                            if (!empty($row->admission_time)) {
                                $tglMasuk .= '<br><small>Jam ' . h(substr((string)$row->admission_time, 0, 5)) . ' WIB</small>';
                            } elseif (!empty($row->created)) {
                                $tglMasuk .= '<br><small>Jam ' . h(formatIgdDate($row->created, 'H:i')) . ' WIB</small>';
                            }
                        } elseif (!empty($row->created)) {
                            $tglMasuk = formatIgdDate($row->created, 'd-m-Y');
                            $tglMasuk .= '<br><small>Jam ' . h(formatIgdDate($row->created, 'H:i')) . ' WIB</small>';
                        }

                        $triaseTanggal = !empty($row->registration_date)
                            ? formatIgdDate($row->registration_date, 'd-m-Y')
                            : (!empty($row->created) ? formatIgdDate($row->created, 'd-m-Y') : '-');

                        $triaseJam = !empty($row->admission_time)
                            ? substr((string)$row->admission_time, 0, 5)
                            : (!empty($row->created) ? formatIgdDate($row->created, 'H:i') : '-');

                        $tglSelesai = '-';
                        if (!empty($row->modified)) {
                            $tglSelesai = formatIgdDate($row->modified, 'd-m-Y H:i') . ' WIB';
                        }

                        $queueNumber = $row->queue_number
                            ?? ($row->polyclinic_queue->queue_number ?? null)
                            ?? $noAntriCounter;

                        $kmaCtx = [
                            'id'                => (int)$row->id,
                            'registration_no'   => $registrationNo,
                            'medical_record_no' => $medicalRecordNos[$row->id] ?? $patientCode,
                            'patient_name'      => $row->patient->full_name ?? '-',
                            'doctor_name'       => $row->doctor->doctor_name ?? $row->doctor->name ?? '-',
                            'defaults'          => [
                                'tekanan_darah'             => (string)($row->blood_pressure ?? ''),
                                'nadi'                      => (string)($row->pulse ?? ''),
                                'napas'                     => (string)($row->respiratory_rate ?? ''),
                                'suhu'                      => (string)($row->temperature ?? ''),
                                'bb'                        => (string)($row->weight ?? ''),
                                'tb'                        => (string)($row->height ?? ''),
                                'skala_nyeri'               => (string)($row->pain_scale ?? ''),
                                'keluhan_utama'             => (string)($row->chief_complaint ?? ''),
                                'riwayat_penyakit_sekarang' => (string)($row->illness_history ?? ''),
                            ],
                        ];
                        $kmaCtxMap[$row->id] = $kmaCtx;
                        ?>

                        <tr style="background:<?= h($rowColor) ?>;">
                            <td class="text-center" style="font-weight:800; font-size:16px; color:#1e3a5f;">
                                <?= h($queueNumber) ?>
                            </td>

                                                        <td class="text-center">
                                <div style="display:flex; gap:3px; justify-content:center; flex-wrap:wrap;">

                                    <button type="button"
                                            class="btn btn-xs btn-purple btn-open-kajian-awal"
                                            data-id="<?= (int)$row->id ?>">
                                        <i class="fa fa-stethoscope"></i> Observasi
                                    </button>

                                    <?= $this->Html->link(
                                        '<i class="fa fa-notes-medical"></i> EMR',
                                        ['action' => 'emr', $row->id],
                                        ['escape' => false, 'class' => 'btn btn-xs btn-teal']
                                    ) ?>

                                    <?= $this->Html->link(
                                        '<i class="fa fa-syringe"></i> Tindakan',
                                        ['action' => 'tindakan', $row->id],
                                        ['escape' => false, 'class' => 'btn btn-xs btn-primary']
                                    ) ?>

                                    <?= $this->Html->link(
                                        '<i class="fa fa-file-medical"></i> Resume Medis',
                                        ['action' => 'resumeMedis', $row->id],
                                        ['escape' => false, 'class' => 'btn btn-xs btn-info']
                                    ) ?>

                                    <button type="button"
                                            class="btn btn-xs btn-labro btn-buka-lab-ro"
                                            data-id="<?= (int)$row->id ?>"
                                            data-noreg="<?= h($registrationNo) ?>"
                                            data-norm="<?= h($patientCode) ?>"
                                            data-nama="<?= h($patientName) ?>">
                                        <i class="fa fa-vial"></i> Lab/RO
                                    </button>

                                    <button type="button"
                                            class="btn btn-xs btn-danger btn-buka-triase"
                                            data-id="<?= (int)$row->id ?>"
                                            data-noreg="<?= h($registrationNo) ?>"
                                            data-norm="<?= h($patientCode) ?>"
                                            data-nama="<?= h($patientName) ?>"
                                            data-tanggal="<?= h($triaseTanggal) ?>"
                                            data-jam="<?= h($triaseJam) ?>">
                                        <i class="fa fa-heartbeat"></i> Triage
                                    </button>

                                    <button type="button"
                                            class="btn btn-xs btn-warning btn-buka-kajian-keperawatan"
                                            data-id="<?= (int)$row->id ?>"
                                            data-noreg="<?= h($registrationNo) ?>"
                                            data-norm="<?= h($patientCode) ?>"
                                            data-nama="<?= h($patientName) ?>"
                                            data-umur="<?= h((new DateTime())->diff(new DateTime($row->patient->birth_date ?? date('Y-m-d')))->y ?? '') ?>"
                                            data-gender="<?= h($isMale ? 'L' : ($isFemale ? 'P' : '')) ?>">
                                        <i class="fa fa-clipboard-list"></i> Kajian Keperawatan
                                    </button>

                                </div>
                            </td>

                            <td class="text-center"><?= h($patientCode) ?></td>
                            <td style="font-family:monospace; font-weight:700;"><?= h($registrationNo) ?></td>
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
                            <td><?= h($tglSelesai) ?></td>
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

<script>
window.KMA_CTX_MAP = <?= json_encode($kmaCtxMap) ?>;
</script>
<script>
$(function () {
    $('.igd-date-filter').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom auto'
    }).on('changeDate change', function () {
        var id = this.id;
        var parts = ($(this).val() || '').split('/');
        if (parts.length === 3 && parts[0].length === 2 && parts[1].length === 2 && parts[2].length === 4) {
            $('#' + id + '-value').val(parts[2] + '-' + parts[1] + '-' + parts[0]);
        }
    });

    $('#igd-date-from').on('changeDate', function (e) {
        $('#igd-date-to').datepicker('setStartDate', e.date);
    });
    $('#igd-date-to').on('changeDate', function (e) {
        $('#igd-date-from').datepicker('setEndDate', e.date);
    });
});
</script>

<div class="modal fade" id="modal-triase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-triase-dialog" role="document">
        <div class="modal-content triase-window">
            <div class="triase-title">
                <span><i class="fa fa-heartbeat"></i> Triase dan Pengkajian Instalasi Gawat Darurat (IGD)</span>
                <button type="button" class="triase-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form id="form-triase">
                <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
                <input type="hidden" id="tri-registration-id" name="registration_id" value="">

                <div class="triase-body">

                                        <!-- ── Baris identitas ── -->
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-sm-2">
                            <label>No. Triase</label>
                            <input type="text" id="tri-triase-no" class="form-control input-sm" readonly placeholder="Otomatis setelah simpan">
                        </div>
                        <div class="col-sm-3">
                            <label>No. Registrasi</label>
                            <input type="text" id="tri-noreg" class="form-control input-sm" readonly>
                        </div>
                        <div class="col-sm-2">
                            <label>No. RM</label>
                            <input type="text" id="tri-norm" class="form-control input-sm" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label>Nama Pasien</label>
                            <input type="text" id="tri-nama" class="form-control input-sm" readonly>
                        </div>
                        <div class="col-sm-1">
                            <label>Tanggal</label>
                            <input type="text" id="tri-tanggal" class="form-control input-sm" readonly>
                        </div>
                        <div class="col-sm-1">
                            <label>Jam</label>
                            <input type="text" id="tri-jam" class="form-control input-sm" readonly>
                        </div>
                    </div>

                                         <div class="row">
                        <div class="col-md-12">

                            <div class="row" style="margin-bottom:10px; align-items:flex-end;">
                                <div class="col-sm-5">
                                <label>Kategori Triage</label><br>
                                    <div class="triase-cat-group">
                                        <label class="triase-cat-btn triase-cat-merah" data-color="#e51f35">
                                            <input type="radio" name="triage_category" value="merah"> Merah
                                        </label>
                                        <label class="triase-cat-btn triase-cat-kuning" data-color="#f6c23a">
                                            <input type="radio" name="triage_category" value="kuning"> Kuning
                                        </label>
                                        <label class="triase-cat-btn triase-cat-hijau" data-color="#16c45b">
                                            <input type="radio" name="triage_category" value="hijau"> Hijau
                                        </label>
                                        <label class="triase-cat-btn triase-cat-hitam" data-color="#111111">
                                            <input type="radio" name="triage_category" value="hitam"> Hitam
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label>Nama Dokter</label>
                                    <select name="doctor_name" id="tri-dokter" class="form-control input-sm select2-triase">
                                        <option value="">-- Pilih Dokter --</option>
                                        <?php foreach ($doctorsList as $doc): ?>
                                            <option value="<?= h($doc->id) ?>">
                                                <?= h($doc->doctor_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Perawat Triage</label>
                                    <select name="triage_nurse" id="tri-perawat" class="form-control input-sm select2-triase">
                                        <option value="">-- Pilih Perawat --</option>
                                        <?php foreach ($triageNurses as $nurse): ?>
                                            <option value="<?= h($nurse->id) ?>">
                                                <?= h($nurse->nama) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Keluhan Utama</label>
                                    <textarea name="chief_complaint" id="tri-keluhan" class="form-control" rows="2"></textarea>

                                    <div style="margin-top:10px;">
                                        <label>Status Alergi</label><br>
                                        <label class="radio-inline" style="font-weight:400;"><input type="radio" name="allergy_status" value="tidak" id="tri-alergi-tidak" checked> Tidak</label>
                                        <label class="radio-inline" style="font-weight:400;"><input type="radio" name="allergy_status" value="ya" id="tri-alergi-ya"> Ya</label>
                                        <input type="text" name="allergy_detail" id="tri-alergi-detail" class="form-control input-sm" style="margin-top:4px;" disabled>
                                    </div>

                                    <div style="margin-top:10px;">
                                        <label>Gangguan Perilaku</label><br>
                                        <label style="font-weight:400; display:block;"><input type="checkbox" name="perilaku[]" value="tidak_terganggu"> Tidak terganggu</label>
                                        <label style="font-weight:400; display:block;"><input type="checkbox" name="perilaku[]" value="ada_terganggu"> Ada terganggu</label>
                                        <label style="font-weight:400; display:block;"><input type="checkbox" name="perilaku[]" value="tidak_membahayakan"> Tidak membahayakan</label>
                                        <label style="font-weight:700; color:#c0392b; display:block;"><input type="checkbox" name="perilaku[]" value="membahayakan"> Membahayakan diri sendiri / orang lain</label>
                                        <div style="font-size:10px; color:#777; font-style:italic;">Bila ada, lakukan pengkajian Restrain</div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="triase-section-title" style="margin-top:0;">Tanda Vital</div>
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <label>GCS - E</label>
                                            <input type="number" name="gcs_e" class="form-control input-sm">
                                        </div>
                                        <div class="col-xs-3">
                                            <label>V</label>
                                            <input type="number" name="gcs_v" class="form-control input-sm">
                                        </div>
                                        <div class="col-xs-3">
                                            <label>M</label>
                                            <input type="number" name="gcs_m" class="form-control input-sm">
                                        </div>
                                        <div class="col-xs-3">
                                            <label>Nadi</label>
                                            <input type="number" name="pulse" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:6px;">
                                        <div class="col-xs-4">
                                            <label>Pupil (mm/mm)</label>
                                            <div style="display:flex; gap:4px;">
                                                <input type="text" name="pupil_kanan" class="form-control input-sm">
                                                <input type="text" name="pupil_kiri" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Reflex Cahaya</label>
                                            <div style="display:flex; gap:4px;">
                                                <input type="text" name="reflex_kanan" class="form-control input-sm">
                                                <input type="text" name="reflex_kiri" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Tekanan Darah</label>
                                            <div style="display:flex; gap:4px; align-items:center;">
                                                <input type="number" name="td_sistol" class="form-control input-sm">
                                                <span>/</span>
                                                <input type="number" name="td_diastol" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:6px;">
                                        <div class="col-xs-4">
                                            <label>Suhu</label>
                                            <input type="number" step="0.1" name="temperature" class="form-control input-sm">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Pernafasan</label>
                                            <input type="number" name="respiratory_rate" class="form-control input-sm">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>SpO2</label>
                                            <input type="number" name="oxygen_saturation" class="form-control input-sm">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:6px;">
                                                                               <div class="col-xs-5">
                                            <label>Jenis Nadi</label>
                                            <div class="nadi-jenis-group">
                                                <label class="nadi-jenis-btn active">
                                                    <input type="radio" name="nadi_jenis" value="reguler" checked> Reguler
                                                </label>
                                                <label class="nadi-jenis-btn">
                                                    <input type="radio" name="nadi_jenis" value="ireguler"> Ireguler
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <label>Akral</label>
                                            <input type="text" name="akral" class="form-control input-sm">
                                        </div>
                                        <div class="col-xs-4">
                                            <label>Skala Nyeri</label>
                                            <input type="number" name="pain_scale" id="tri-nyeri-input" class="form-control input-sm" min="0" max="10" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ── Skala FLACC ── -->
                    <div class="triase-section-title" style="margin-top:14px;">Skala FLACC ( &lt; 6 Tahun )</div>
                    <div class="table-responsive">
                        <table class="table table-bordered triase-flacc-table">
                            <thead>
                                <tr>
                                    <th style="width:90px;">Pengkajian</th>
                                    <th>0</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th style="width:70px;">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Wajah</strong></td>
                                    <td>Tersenyum / tidak ada ekspresi khusus</td>
                                    <td>Terkadang meringis / menarik diri</td>
                                    <td>Sering menggetarkan dagu dan mengatupkan rahang</td>
                                    <td><input type="number" name="flacc[wajah]" class="form-control input-sm flacc-nilai" min="0" max="2" value="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Kaki</strong></td>
                                    <td>Gerakan normal / relaksasi</td>
                                    <td>Tidak tenang / tegang</td>
                                    <td>Kaki dibuat menendang / menarik diri</td>
                                    <td><input type="number" name="flacc[kaki]" class="form-control input-sm flacc-nilai" min="0" max="2" value="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Aktifitas</strong></td>
                                    <td>Tidur, posisi normal, mudah bergerak</td>
                                    <td>Gerakan menggeliat, berguling, kaku</td>
                                    <td>Melengkungkan punggung / kaku / menghentak</td>
                                    <td><input type="number" name="flacc[aktifitas]" class="form-control input-sm flacc-nilai" min="0" max="2" value="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Menangis</strong></td>
                                    <td>Tidak menangis (bangun tidur)</td>
                                    <td>Mengerang, merengek-rengek</td>
                                    <td>Menangis terus-menerus, terisak, menjerit</td>
                                    <td><input type="number" name="flacc[menangis]" class="form-control input-sm flacc-nilai" min="0" max="2" value="0"></td>
                                </tr>
                                <tr>
                                    <td><strong>Bersuara</strong></td>
                                    <td>Bersuara normal, tenang</td>
                                    <td>Tenang bila dipeluk, digendong, atau diajak bicara</td>
                                    <td>Sulit untuk menenangkan</td>
                                    <td><input type="number" name="flacc[bersuara]" class="form-control input-sm flacc-nilai" min="0" max="2" value="0"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align:right; font-weight:700;">TOTAL SCORE</td>
                                    <td><input type="text" id="tri-flacc-total" class="form-control input-sm" readonly value="0" style="font-weight:700; background:#f5f5f5;"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                 </div>

                <div class="triase-footer">
                    <button type="button" class="btn btn-default btn-sm" id="btn-pemeriksaan-fisik">
                        <i class="fa fa-stethoscope"></i> Pemeriksaan Fisik
                    </button>
                    <div>
                        <span id="tri-message" style="margin-right:10px; font-size:12px; font-weight:600;"></span>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-tambah-triase"><i class="fa fa-plus"></i> Tambah</button>
                        <button type="button" class="btn btn-success btn-sm" id="btn-simpan-triase"><i class="fa fa-save"></i> Simpan</button>
                                                <button type="button" class="btn btn-warning btn-sm" id="btn-edit-triase"><i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-default btn-sm" id="btn-riwayat-triase"><i class="fa fa-history"></i> Riwayat Triage</button>
                        <button type="button" class="btn btn-info btn-sm" id="btn-cetak-triase" disabled><i class="fa fa-print"></i> Cetak</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-sign-out-alt"></i> Keluar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── MODAL RIWAYAT TRIAGE ── -->
<div class="modal fade" id="modal-riwayat-triase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:520px; max-width:95%;" role="document">
        <div class="modal-content triase-window">
            <div class="triase-title">
                <span><i class="fa fa-history"></i> Riwayat Triage</span>
                <button type="button" class="triase-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div style="padding:14px;">
                <div id="tri-riwayat-box" class="triase-riwayat-box">
                    <div class="triase-riwayat-empty">Belum ada riwayat triage.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->element('kajian_keperawatan_modal') ?>

<?= $this->element('kajian_medis_awal_modal') ?>

<?= $this->element('lab_ro_modal') ?>

<style>
.table-igd > thead > tr > th {
    background:#1e3a5f !important;
    color:#fff !important;
    border-color:#2d4f7f !important;
    text-align:center;
    vertical-align:middle;
    font-size:11px;
    padding:6px 5px !important;
    height:30px;
    white-space:nowrap;
}
.table-igd td {
    vertical-align:middle !important;
    padding:4px 5px !important;
    height:30px;
    border-color:#9fb6c8 !important;
    white-space:nowrap;
}
.table-igd > tbody > tr:hover {
    background:#fff3cd !important;
}
.date-separator-row-igd td {
    background: #eef2f7 !important;
    color: #1e3a5f;
    font-weight: 700;
    font-size: 12px;
    padding: 8px 12px !important;
    border-top: 2px solid #1e3a5f !important;
    border-bottom: 1px solid #dbe3ee !important;
    white-space: normal !important;
}
.btn-xs {
    padding:3px 7px;
    font-size:11px;
    line-height:1.5;
    border-radius:4px;
}
.btn-teal {
    background-color:#17a2b8;
    border-color:#17a2b8;
    color:#fff !important;
}
.btn-teal:hover,
.btn-teal:focus {
    background-color:#138496;
    border-color:#117a8b;
    color:#fff !important;
}
.btn-purple {
    background-color:#6f42c1;
    border-color:#6f42c1;
    color:#fff !important;
}
.btn-purple:hover,
.btn-purple:focus {
    background-color:#5a32a3;
    border-color:#4e2a8e;
    color:#fff !important;
}
.btn-labro {
    background-color:#fd7e14;
    border-color:#fd7e14;
    color:#fff !important;
}
.btn-labro:hover,
.btn-labro:focus {
    background-color:#e8690b;
    border-color:#d35f0a;
    color:#fff !important;
}
.label {
    padding:2px 7px;
    border-radius:4px;
    font-size:10px;
    font-weight:600;
}
.label-info { background:#5bc0de; color:#fff; }
.label-danger { background:#d9534f; color:#fff; }
.label-default { background:#777; color:#fff; }

.modal-triase-dialog { width: 1100px; max-width: 98%; margin-top: 20px; }
.triase-window { border: 1px solid #1e3a5f; background: #f4f7fb; box-shadow: 0 4px 16px rgba(0,0,0,.3); border-radius: 3px; }
.triase-title {
    background: #1e3a5f; color: #fff; padding: 8px 12px; font-size: 13px; font-weight: 700;
    display: flex; justify-content: space-between; align-items: center;
}
.triase-close { border: 0; background: transparent; color: #fff; font-size: 20px; line-height: 20px; opacity: 1; }
.triase-body { padding: 14px; max-height: 68vh; overflow-y: auto; font-size: 12px; }
.triase-body .select2-container { width: 100% !important; }
.triase-body .select2-selection--single {
    height: 30px !important;
    border-radius: 4px !important;
    border-color: #ccc !important;
}
.triase-body .select2-selection__rendered {
    line-height: 28px !important;
    font-size: 12px !important;
}
.triase-body .select2-selection__arrow {
    height: 28px !important;
}
.triase-window label,
.triase-window .triase-section-title,
.triase-window .triase-title,
.triase-window th,
.triase-window .triase-riwayat-empty {
    -webkit-user-select: none;
    user-select: none;
    caret-color: transparent;
    cursor: default;
}

/* Kolom isian tetap bisa diketik dan diseleksi */
.triase-window input,
.triase-window textarea,
.triase-window select {
    -webkit-user-select: text;
    user-select: text;
    caret-color: auto;
}
.triase-section-title {
    background: #dbe6f4; border: 1px solid #b9cbe0; color: #1e3a5f; font-weight: 700;
    font-size: 11px; padding: 5px 8px; margin: 8px 0 6px;
}
.triase-nyeri-faces { display: flex; gap: 10px; }
.nyeri-face { text-align: center; cursor: pointer; }
.nyeri-face-circle {
    width: 46px; height: 46px; border-radius: 50%; border: 2px solid #ccc;
    display: flex; align-items: center; justify-content: center; font-size: 22px; background: #fff;
}
.nyeri-face.active .nyeri-face-circle { border-color: #1e3a5f; background: #dbe6f4; }
.nyeri-face-val { font-size: 11px; font-weight: 700; margin-top: 2px; }
.triase-riwayat-box {
    border: 1px solid #ccd5e0; background: #fff; border-radius: 4px; min-height: 260px;
    padding: 8px; font-size: 11px; color: #777;
}
.triase-riwayat-empty { text-align: center; padding: 20px 0; }
.triase-flacc-table { font-size: 11px; margin-bottom: 0; }
.triase-flacc-table th { background: #dbe6f4; text-align: center; vertical-align: middle; }
.triase-flacc-table td { vertical-align: middle; }
.triase-dot { display: inline-block; width: 14px; height: 14px; border-radius: 50%; margin-right: 3px; vertical-align: middle; border: 1px solid rgba(0,0,0,.2); }
.triase-footer {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 14px; border-top: 1px solid #ccd5e0; background: #eef2f7;
}
.triase-cat-group { display:flex; gap:6px; flex-wrap:wrap; }
.triase-cat-btn {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:6px; border:2px solid #ddd;
    cursor:pointer; font-weight:700; font-size:12px; background:#fff; color:#333;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
}
.triase-cat-btn input { display:none; }
.triase-cat-btn,
.nadi-jenis-btn {
    -webkit-user-select: none;
    user-select: none;
    caret-color: transparent;
    cursor: pointer;
}
.triase-cat-btn *,
.nadi-jenis-btn * {
    -webkit-user-select: none;
    user-select: none;
    caret-color: transparent;
}
.triase-cat-btn::before {
    content: '';
    width: 12px; height: 12px;
    border-radius: 50%;
    background: var(--cat);
    border: 1px solid rgba(0,0,0,.25);
}
.triase-cat-btn { border-color: var(--cat); background: var(--cat-soft); }
.triase-cat-btn:hover { background: var(--cat); color: #fff; }
.triase-cat-btn.active { background: var(--cat); border-color: var(--cat); color: #fff; box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--cat); }
.triase-cat-btn.active::before { background: #fff; }

.triase-cat-merah  { --cat:#e51f35; --cat-soft:#fdecee; }
.triase-cat-kuning { --cat:#f6c23a; --cat-soft:#fef8e6; }
.triase-cat-hijau  { --cat:#16c45b; --cat-soft:#e8f9ef; }
.triase-cat-hitam  { --cat:#111111; --cat-soft:#ececec; }

.triase-cat-kuning:hover, .triase-cat-kuning.active { color: #333; }
.triase-cat-kuning.active::before { background: #333; }

.nadi-jenis-group { display:flex; gap:6px; }
.nadi-jenis-btn {
    display:inline-flex; align-items:center; justify-content:center;
    padding:6px 8px; border-radius:6px; border:2px solid #ddd;
    cursor:pointer; font-weight:700; font-size:11px; background:#fff; color:#333;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
    flex: 1;
    white-space: nowrap;
}
.nadi-jenis-btn input { display:none; }
.nadi-jenis-btn.active {
    background:#1e3a5f; border-color:#1e3a5f; color:#fff;
}
</style>

<script>
$(document).on('click', '.btn-buka-triase', function () {
    var $btn = $(this);

    $('#tri-registration-id').val($btn.attr('data-id'));
    $('#tri-noreg').val($btn.attr('data-noreg') || '-');
    $('#tri-norm').val($btn.attr('data-norm') || '-');
    $('#tri-nama').val($btn.attr('data-nama') || '-');
    $('#tri-tanggal').val($btn.attr('data-tanggal') || '-');
    $('#tri-jam').val($btn.attr('data-jam') || '-');
    $('#tri-triase-no').val('');

    $('#form-triase')[0].reset();
    $('#tri-registration-id').val($btn.attr('data-id'));
    $('#tri-noreg').val($btn.attr('data-noreg') || '-');
    $('#tri-norm').val($btn.attr('data-norm') || '-');
    $('#tri-nama').val($btn.attr('data-nama') || '-');
    $('#tri-tanggal').val($btn.attr('data-tanggal') || '-');
    $('#tri-jam').val($btn.attr('data-jam') || '-');
    $('#tri-triase-no').val('');

    try {
        if (typeof $.fn.select2 === 'function' && !$('#tri-dokter').hasClass('select2-hidden-accessible')) {
            $('.select2-triase').select2({
                dropdownParent: $('#modal-triase'),
                width: '100%',
                placeholder: function () {
                    return $(this).find('option:first').text();
                }
            });
        }
    } catch (e) {
        console.warn('Select2 gagal diinisialisasi, dropdown pakai tampilan biasa.', e);
    }
    $('.select2-triase').val('').trigger('change');
    $('.triase-cat-btn').removeClass('active');
    $('.nadi-jenis-btn').removeClass('active');
    $('.nadi-jenis-btn').first().addClass('active');
    $('#tri-nyeri-input').val(0);
    $('#tri-flacc-total').val(0);
    $('#tri-message').text('');
    $('#tri-alergi-detail').prop('disabled', true).val('');
    $('#tri-riwayat-box').html('<div class="triase-riwayat-empty">Belum ada riwayat triage.</div>');

    $('#modal-triase').modal('show');
});

// Status alergi: aktifkan textbox detail hanya jika "Ya"
$(document).on('change', 'input[name="allergy_status"]', function () {
    $('#tri-alergi-detail').prop('disabled', $('#tri-alergi-ya').is(':checked') ? false : true);
});

// FLACC: hitung total otomatis
function hitungFlaccTotal() {
    var total = 0;
    $('.flacc-nilai').each(function () {
        total += parseInt($(this).val(), 10) || 0;
    });
    $('#tri-flacc-total').val(total);
}
$(document).on('input change', '.flacc-nilai', hitungFlaccTotal);

// Tombol Simpan (placeholder — backend belum dibuat)
$(document).on('click', '#btn-simpan-triase', function () {
    var $btn = $(this);
    $('#tri-message').text('').css('color', '');

    if (!$('#tri-registration-id').val()) {
        $('#tri-message').text('Data registrasi tidak ditemukan.').css('color', '#b91c1c');
        return;
    }

       var SIMPAN_TRIASE_URL = '<?= $this->Url->build('/') ?>triage-entries/add';

    var payload = $('#form-triase').serialize();

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: SIMPAN_TRIASE_URL,
        method: 'POST',
        data: payload,
        dataType: 'json'
    }).done(function (res) {
        if (res && res.success) {
            $('#tri-triase-no').val(res.triase_no || '-');
            $('#tri-message').text('Triase berhasil disimpan (' + (res.triase_no || '-') + ').').css('color', '#047857');
            $('#btn-cetak-triase').prop('disabled', false);
        } else {
            $('#tri-message').text((res && res.message) || 'Gagal menyimpan triase.').css('color', '#b91c1c');
        }
    }).fail(function (xhr) {
        $('#tri-message').text('Gagal menyimpan triase (' + xhr.status + ').').css('color', '#b91c1c');
    }).always(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
    });
});

$(document).on('click', '#btn-tambah-triase', function () {
    var regId = $('#tri-registration-id').val();
    var noreg = $('#tri-noreg').val();
    var norm = $('#tri-norm').val();
    var nama = $('#tri-nama').val();
    var tanggal = $('#tri-tanggal').val();
    var jam = $('#tri-jam').val();

    $('#form-triase')[0].reset();

    $('#tri-registration-id').val(regId);
    $('#tri-noreg').val(noreg);
    $('#tri-norm').val(norm);
    $('#tri-nama').val(nama);
    $('#tri-tanggal').val(tanggal);
    $('#tri-jam').val(jam);
    $('#tri-triase-no').val('');

    $('.triase-cat-btn').removeClass('active');
    $('.nadi-jenis-btn').removeClass('active');
    $('.nadi-jenis-btn').first().addClass('active');
    $('#tri-nyeri-input').val(0);
    $('#tri-alergi-detail').prop('disabled', true).val('');
    $('#btn-cetak-triase').prop('disabled', true);

    hitungFlaccTotal();
    $('#tri-message').text('Form dikosongkan, siap isi triase baru.').css('color', '#1e3a5f');
});

$(document).on('click', '#btn-pemeriksaan-fisik', function () {
    alert('Halaman Pemeriksaan Fisik belum dibuat.');
});

$(document).on('click', '#btn-riwayat-triase', function () {
    var registrationId = $('#tri-registration-id').val();

    if (!registrationId) {
        $('#tri-riwayat-box').html('<div class="triase-riwayat-empty">Data registrasi tidak ditemukan.</div>');
        $('#modal-riwayat-triase').modal('show');
        return;
    }

    $('#tri-riwayat-box').html('<div class="triase-riwayat-empty"><i class="fa fa-spinner fa-spin"></i> Memuat riwayat...</div>');
    $('#modal-riwayat-triase').modal('show');

    var HISTORY_URL = '<?= $this->Url->build('/') ?>triage-entries/history/' + registrationId;

    $.getJSON(HISTORY_URL, function (res) {
        if (!res.success || !res.data.length) {
            $('#tri-riwayat-box').html('<div class="triase-riwayat-empty">Belum ada riwayat triage.</div>');
            return;
        }

        var html = '';
        var catColor = { merah: '#e51f35', kuning: '#f6c23a', hijau: '#16c45b', hitam: '#111111' };

        $.each(res.data, function (i, row) {
            html += '<div style="border-bottom:1px solid #eee; padding:8px 4px;">';
            html += '  <div style="display:flex; justify-content:space-between; align-items:center;">';
            html += '    <strong>' + (row.triase_no || '-') + '</strong>';
            html += '    <span>' + row.tanggal + '</span>';
            html += '  </div>';
            html += '  <div style="margin-top:2px;">';
            html += '    <span class="triase-dot" style="background:' + (catColor[row.kategori] || '#999') + ';"></span>';
            html += '    <span style="text-transform:capitalize;">' + row.kategori + '</span>';
            html += '  </div>';
            html += '  <div>Keluhan: ' + (row.keluhan || '-') + '</div>';
            html += '  <div>Dokter: ' + row.dokter + ' | Perawat: ' + row.perawat + '</div>';
            html += '  <div>TD: ' + row.td + ' | Nadi: ' + (row.nadi || '-') + ' | Suhu: ' + (row.suhu || '-') + ' | SpO2: ' + (row.spo2 || '-') + '</div>';
            html += '  <div>Skala Nyeri: ' + row.pain_scale + ' | FLACC: ' + row.flacc_total + '</div>';
            html += '</div>';
        });

        $('#tri-riwayat-box').html(html);
    }).fail(function () {
        $('#tri-riwayat-box').html('<div class="triase-riwayat-empty">Gagal memuat riwayat triage.</div>');
    });
});

$(document).on('click', '.triase-cat-btn', function () {
    var $btn = $(this);
    $('.triase-cat-btn').removeClass('active');
    $btn.find('input[type="radio"]').prop('checked', true);
    $btn.addClass('active');
});

$(document).on('click', '.nadi-jenis-btn', function () {
    var $btn = $(this);
    $('.nadi-jenis-btn').removeClass('active');
    $btn.find('input[type="radio"]').prop('checked', true);
    $btn.addClass('active');
});
</script>
