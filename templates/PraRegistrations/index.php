<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PraRegistration[]|\Cake\Collection\CollectionInterface $praRegistrations
 *
 * CATATAN: ini baru tampilan (mockup). $praRegistrations, filter, dan aksi Daftarkan
 * masih dummy/placeholder, nanti disambung ke controller + FK master jadwal dokter,
 * patients, dll setelah tampilannya fix.
 */

$currentStatus = $this->request->getQuery('status', 'belum_diproses');

$statusLabel = function (string $status): array {
    if ($status === 'sudah_diproses') {
        return ['label' => 'Sudah Diproses', 'class' => 'label-checkin-done'];
    }
    if ($status === 'diteruskan') {
        return ['label' => 'Proses', 'class' => 'label-checkin-forwarded'];
    }
    if ($status === 'batal') {
        return ['label' => 'Batal', 'class' => 'label-checkin-batal'];
    }
    return ['label' => 'Belum Diproses', 'class' => 'label-checkin-pending'];
};

$dayNames = [
    'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu',
];

$formatDay = function ($date) use ($dayNames): string {
    if (empty($date)) {
        return '-';
    }
    $timestamp = is_object($date) && method_exists($date, 'format') ? strtotime($date->format('Y-m-d')) : strtotime((string)$date);
    if (!$timestamp) {
        return '-';
    }
    return $dayNames[date('l', $timestamp)] ?? date('l', $timestamp);
};

$formatDate = function ($date): string {
    if (empty($date)) {
        return '-';
    }
    $timestamp = is_object($date) && method_exists($date, 'format') ? strtotime($date->format('Y-m-d')) : strtotime((string)$date);
    return $timestamp ? date('d-m-Y', $timestamp) : '-';
};

$formatTime = function ($time): string {
    if (empty($time)) {
        return '-';
    }
    $timestamp = is_object($time) && method_exists($time, 'format') ? strtotime($time->format('H:i:s')) : strtotime((string)$time);
    return $timestamp ? date('H:i', $timestamp) : '-';
};
?>

<?= $this->Krs->breadcrumb('Pra Registrasi', 'Data Pra Registrasi') ?>

<style>
    .praregis-page .alert-primary {
        padding: 12px 16px;
        border: 0;
        border-radius: 4px;
        background: #cfe5f8;
        color: #0b3d75;
        font-size: 13px;
    }

    .praregis-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin: 16px 0 18px;
    }

    .praregis-toolbar .btn {
        margin-right: 8px;
    }

    .praregis-status-tabs {
        display: inline-flex;
        border: 1px solid #d9e2ec;
        border-radius: 8px;
        overflow: hidden;
    }

    .praregis-status-tabs a {
        display: inline-block;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 700;
        color: #344054;
        background: #fff;
        border-right: 1px solid #d9e2ec;
        text-decoration: none;
    }

    .praregis-status-tabs a:last-child {
        border-right: 0;
    }

    .praregis-status-tabs a.is-active {
        background: #0f766e;
        color: #fff;
    }

    .praregis-filter {
        padding: 10px 12px;
        background: #49b6d6;
        border-radius: 0;
    }

    .praregis-filter .form-control {
        height: 36px;
        border: 0;
        border-radius: 4px;
        font-size: 13px;
    }

    .praregis-filter .btn {
        height: 36px;
        min-width: 48px;
        border-radius: 4px;
        font-size: 14px;
    }

    .praregis-table {
        margin-bottom: 0;
        background: #fff;
        font-size: 12.5px;
    }

    .praregis-table thead th {
        padding: 9px 6px;
        border-color: #2d353c !important;
        background: #2d353c;
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        vertical-align: middle;
    }

    .praregis-table tbody td {
        padding: 8px 6px;
        border-top: 1px solid #e5e9ef;
        color: #172033;
        vertical-align: middle;
    }

    .praregis-table tbody tr:nth-child(odd) td {
        background: #f1f3f5;
    }

    .praregis-table tbody tr:nth-child(even) td {
        background: #fff;
    }

    .praregis-code {
        font-weight: 800;
        color: #172033;
    }

    .praregis-patient {
        font-weight: 700;
        line-height: 1.25;
    }

    .praregis-subtle {
        display: block;
        margin-top: 2px;
        color: #6c757d;
        font-size: 11px;
        font-weight: 600;
    }

    .praregis-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .label-checkin-pending { background: #f59c1a; color: #fff; }
    .label-checkin-done { background: #00acac; color: #fff; }
    .label-checkin-forwarded { background: #6366f1; color: #fff; }
    .label-checkin-batal { background: #dc3545; color: #fff; }

    .praregis-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        min-width: 150px;
    }

    .praregis-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        margin: 0;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .praregis-pagination {
        padding-top: 12px;
    }

    @media (max-width: 991px) {
        .praregis-filter .row > div {
            margin-bottom: 10px;
        }
    }
</style>

<div class="panel panel-inverse praregis-page">
    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="alert alert-primary">
            Halaman <strong>Data Pra Registrasi</strong>, digunakan untuk mengelola janji temu pasien sebelum
            didaftarkan ke antrian poliklinik.
        </div>

        <div class="portlet-body form">
            <div class="praregis-toolbar">
                <div class="btn-group">
                    <?= $this->Html->link(
                        '<i class="fa fa-plus"> Buat Pra Registrasi</i>',
                        ['action' => 'add'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Buat Pra Registrasi Baru',
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-sync-alt"></i> Refresh',
                        ['action' => 'index'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Refresh data pra registrasi',
                        ]
                    ) ?>
                </div>

                <div class="praregis-status-tabs">
                    <?= $this->Html->link('Batal', ['action' => 'index', '?' => ['status' => 'batal']], [
                        'class' => $currentStatus === 'batal' ? 'is-active' : '',
                    ]) ?>
                    <?= $this->Html->link('Belum Diproses', ['action' => 'index', '?' => ['status' => 'belum_diproses']], [
                        'class' => $currentStatus === 'belum_diproses' ? 'is-active' : '',
                    ]) ?>
                    <?= $this->Html->link('Proses', ['action' => 'index', '?' => ['status' => 'diteruskan']], [
                        'class' => $currentStatus === 'diteruskan' ? 'is-active' : '',
                    ]) ?>
                    <?= $this->Html->link('Sudah Diproses', ['action' => 'index', '?' => ['status' => 'sudah_diproses']], [
                        'class' => $currentStatus === 'sudah_diproses' ? 'is-active' : '',
                    ]) ?>
                    <?= $this->Html->link('Semua', ['action' => 'index', '?' => ['status' => 'all']], [
                        'class' => $currentStatus === 'all' ? 'is-active' : '',
                    ]) ?>
                </div>
            </div>

            <?= $this->Form->create(null, ['type' => 'get']) ?>
                <input type="hidden" name="status" value="<?= h($currentStatus) ?>">
                <div class="praregis-filter">
                    <div class="row row-space-10">
                        <div class="col-md-2 m-b-10">
                            <?= $this->Form->text('key', [
                                'class' => 'form-control',
                                'placeholder' => 'No. Reservasi...',
                                'value' => $this->request->getQuery('key'),
                            ]) ?>
                        </div>

                        <div class="col-md-3 m-b-10">
                            <?= $this->Form->text('key_label', [
                                'class' => 'form-control',
                                'placeholder' => 'Nama pasien / No RM / No Kartu...',
                                'value' => $this->request->getQuery('key_label'),
                            ]) ?>
                        </div>

                        <div class="col-md-5 m-b-10">
                            <input type="hidden" name="appointment_date" id="filter-appointment-date"
                                value="<?= h($appointmentDate ?? $this->request->getQuery('appointment_date')) ?>">
                            <input type="hidden" name="doctor_schedule_id" id="filter-doctor-schedule-id"
                                value="<?= h($doctorScheduleId ?? $this->request->getQuery('doctor_schedule_id')) ?>">

                            <button type="button"
                                class="form-control text-left"
                                id="btn-pilih-jadwal"
                                data-toggle="modal"
                                data-target="#modalPilihJadwal"
                                style="cursor:pointer; text-align:left;">
                                <i class="fa fa-calendar-alt"></i>
                                <span id="filter-jadwal-label">-- Pilih Tanggal &amp; Jadwal Dokter --</span>
                            </button>
                        </div>

                        <div class="col-md-2 m-b-10 d-flex" style="gap: 6px;">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-search"></i>
                            </button>
                            <?= $this->Html->link('<i class="fa fa-sync-alt"></i>', ['action' => 'index'], [
                                'class' => 'btn btn-inverse',
                                'escape' => false,
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?= $this->Form->end() ?>

            <div class="table-responsive queue-section">
                <table class="table table-bordered praregis-table">
                    <thead>
                        <tr>
                            <th>Antri</th>
                            <th>No Reservasi</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>Hari / Tanggal</th>
                            <th>Jam</th>
                            <th>Dokter</th>
                            <th>Tujuan</th>
                            <th>No Kartu</th>
                            <th>No Rujukan</th>
                            <th>Keterangan</th>
                            <th>Melalui</th>
                            <th>Tgl Input</th>
                            <th>Aksi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($praRegistrations)): ?>
                            <tr>
                                <td colspan="15" class="text-center text-muted">
                                    Data pra registrasi tidak ditemukan
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($praRegistrations as $item): ?>
                                <?php $badge = $statusLabel((string)($item->registration_status ?? 'belum_diproses')); ?>
                                <tr>
                                    <td class="text-center"><?= h($item->daily_queue_number ?? '-') ?></td>
                                    <td class="praregis-code"><?= h($item->reservation_code ?? '-') ?></td>
                                    <td><?= h($item->medical_record_no ?? '-') ?></td>
                                    <td>
                                        <span class="praregis-patient"><?= h($item->patient_name ?? '-') ?></span>
                                        <span class="praregis-subtle"><?= h($item->phone_number ?? '-') ?></span>
                                    </td>
                                    <td>
                                        <?= h($formatDay($item->appointment_date ?? null)) ?>
                                        <span class="praregis-subtle"><?= h($formatDate($item->appointment_date ?? null)) ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($item->estimated_call_time)): ?>
                                            <strong><?= h($item->estimated_call_time) ?></strong>
                                        <?php else: ?>
                                            <?= h($formatTime($item->appointment_time ?? null)) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= h($item->doctor_name ?? '-') ?></td>
                                    <td><?= h($item->poly_name ?? '-') ?></td>
                                    <td><?= h($item->card_number ?? '-') ?></td>
                                    <td><?= h($item->referral_number ?? '-') ?></td>
                                    <td><?= h($item->notes ?? '-') ?></td>
                                    <td><?= h($this->Krs->referralChannels()[$item->channel ?? ''] ?? ($item->channel ?? '-')) ?></td>
                                    <td><?= h($formatDate($item->created ?? null)) ?></td>
                                    <td class="praregis-actions">
                                        <?php $itemStatus = $item->registration_status ?? 'belum_diproses'; ?>
                                        <?php if ($itemStatus === 'belum_diproses' || $itemStatus === ''): ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-check"></i> Daftarkan',
                                                ['action' => 'register', $item->id ?? null],
                                                [
                                                    'class' => 'btn btn-sm btn-success',
                                                    'escape' => false,
                                                    'confirm' => 'Daftarkan pra registrasi ' . h($item->patient_name ?? '') . ' ke antrian poliklinik?',
                                                ]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-times"></i> Batalkan',
                                                ['action' => 'cancel', $item->id ?? null],
                                                [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'escape' => false,
                                                    'confirm' => 'Batalkan pra registrasi ' . h($item->patient_name ?? '') . '? Pasien perlu daftar ulang jika ingin mengambil jadwal baru.',
                                                ]
                                            ) ?>
                                        <?php elseif ($itemStatus === 'diteruskan'): ?>
                                            <span class="text-muted"><i class="fa fa-clock"></i> Proses</span>
                                        <?php elseif ($itemStatus === 'batal'): ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-redo"></i> Daftarkan Ulang',
                                                ['action' => 'add', '?' => ['reschedule_from' => $item->id ?? null]],
                                                ['class' => 'btn btn-sm btn-warning', 'escape' => false]
                                            ) ?>
                                        <?php else: ?>
                                            <span class="text-muted"><i class="fa fa-check-circle"></i> Terdaftar</span>
                                        <?php endif; ?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-eye"></i>',
                                            ['action' => 'view', $item->id ?? null],
                                            ['class' => 'btn btn-sm btn-default', 'escape' => false, 'title' => 'Detail']
                                        ) ?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-edit"></i>',
                                            ['action' => 'edit', $item->id ?? null],
                                            ['class' => 'btn btn-sm btn-warning', 'escape' => false, 'title' => 'Edit']
                                        ) ?>
                                    </td>
                                    <td><span class="praregis-badge <?= h($badge['class']) ?>"><?= h($badge['label']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="row praregis-pagination">
                <div class="col-md-6">
                    <p><?= $this->Paginator->counter('Menampilkan {{current}} data dari {{count}} total data') ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <ul class="pagination pagination-sm m-t-0 m-b-0 pull-right">
                        <?= $this->Paginator->first('<<') ?>
                        <?= $this->Paginator->prev('<') ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('>') ?>
                        <?= $this->Paginator->last('>>') ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pilih Tanggal & Jadwal Dokter -->
<div class="modal fade" id="modalPilihJadwal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:92%; max-width:1080px;">
        <div class="modal-content" style="border-radius:6px; overflow:hidden;">
            <div class="modal-header" style="background:#1e3a5f; color:#fff;">
                <h4 class="modal-title">
                    <i class="fa fa-calendar-alt"></i> Pilih Tanggal &amp; Jadwal Dokter
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="background:#eef2f7; padding:12px;">
                <div style="background:#dfe6f1; border:1px solid #b8c4d4; border-radius:5px; padding:10px; margin-bottom:10px;">
                    <div class="row">
                        <div class="col-md-4">
                            <label style="font-size:12px; font-weight:700; margin-bottom:5px; color:#24364d;">
                                Tanggal Kunjungan
                            </label>
                            <input type="date" id="modal-jadwal-date" class="form-control" style="height:34px; font-size:13px;">
                        </div>
                        <div class="col-md-8">
                            <label style="font-size:12px; font-weight:700; margin-bottom:5px; color:#24364d;">
                                Cari Dokter / Poli
                            </label>
                            <input type="text" id="modal-jadwal-search" class="form-control"
                                style="height:34px; font-size:13px;"
                                placeholder="Ketik nama dokter atau poli tujuan...">
                        </div>
                    </div>
                    <small style="display:block; margin-top:6px; color:#52606d; font-size:11px;">
                        Pilih tanggal dulu untuk menampilkan jadwal dokter yang praktik di hari tersebut, lalu klik salah satu baris jadwal untuk memilih.
                    </small>
                </div>

                <div style="background:#fff; border:1px solid #b8c4d4; max-height:420px; overflow:auto;">
                    <table class="table table-bordered table-hover" style="margin-bottom:0; font-size:12.5px;">
                        <thead>
                            <tr style="background:#2f4050; color:#fff;">
                                <th style="padding:7px 6px;">Dokter</th>
                                <th style="padding:7px 6px;">Poli</th>
                                <th style="padding:7px 6px; text-align:center;">Hari</th>
                                <th style="padding:7px 6px; text-align:center;">Jam</th>
                                <th style="padding:7px 6px; text-align:center;">Kuota</th>
                            </tr>
                        </thead>
                        <tbody id="modal-jadwal-result">
                            <tr>
                                <td colspan="5" class="text-center" style="padding:28px; color:#7b8794;">
                                    Pilih tanggal kunjungan terlebih dahulu untuk menampilkan jadwal dokter.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer" style="background:#e9edf3; padding:8px 12px; display:flex; justify-content:space-between; align-items:center;">
                <span id="modal-jadwal-count" style="font-size:12px; font-weight:700; color:#2f4050;">0 jadwal</span>
                <div>
                    <button type="button" class="btn btn-default btn-sm" id="btn-jadwal-clear">
                        <i class="fa fa-times"></i> Hapus Pilihan
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    var allDoctorSchedules = <?= json_encode(
        $doctorSchedulesForModal ?? [],
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
    ) ?>;

    // getDay() JS: 0=Minggu, 1=Senin, ..., 6=Sabtu
    var jsDayToIndonesian = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function dateToIndonesianDay(dateStr) {
        if (!dateStr) return '';
        var d = new Date(dateStr + 'T00:00:00');
        if (isNaN(d.getTime())) return '';
        return jsDayToIndonesian[d.getDay()];
    }

    function renderJadwalModal() {
        var dateVal = $('#modal-jadwal-date').val();
        var dayFilter = dateToIndonesianDay(dateVal);
        var keyword = ($('#modal-jadwal-search').val() || '').toLowerCase().trim();

        if (!dateVal) {
            $('#modal-jadwal-result').html(
                '<tr><td colspan="5" class="text-center" style="padding:28px; color:#7b8794;">' +
                'Pilih tanggal kunjungan terlebih dahulu untuk menampilkan jadwal dokter.</td></tr>'
            );
            $('#modal-jadwal-count').text('0 jadwal');
            return;
        }

        var filtered = allDoctorSchedules.filter(function (sch) {
            if (sch.day !== dayFilter) return false;
            if (!keyword) return true;
            var haystack = (sch.doctor_name + ' ' + sch.poly_name).toLowerCase();
            return haystack.indexOf(keyword) !== -1;
        });

        $('#modal-jadwal-count').text(filtered.length + ' jadwal');

        if (filtered.length < 1) {
            $('#modal-jadwal-result').html(
                '<tr><td colspan="5" class="text-center" style="padding:28px; color:#7b8794;">' +
                'Tidak ada jadwal dokter pada hari ' + escapeHtml(dayFilter) + '.</td></tr>'
            );
            return;
        }

        var html = '';
        filtered.forEach(function (sch) {
            var quotaLeft = Math.max(0, sch.quota - sch.quota_used);
            html += '<tr class="jadwal-row" style="cursor:pointer;" title="Klik untuk memilih jadwal ini"' +
                ' data-id="' + sch.id + '"' +
                ' data-doctor-name="' + escapeHtml(sch.doctor_name) + '"' +
                ' data-poly-name="' + escapeHtml(sch.poly_name) + '"' +
                ' data-day="' + escapeHtml(sch.day) + '"' +
                ' data-time="' + escapeHtml(sch.start_time + '-' + sch.end_time) + '">';
            html += '<td style="padding:6px;"><strong>' + escapeHtml(sch.doctor_name) + '</strong></td>';
            html += '<td style="padding:6px;">' + escapeHtml(sch.poly_name) + '</td>';
            html += '<td style="padding:6px; text-align:center;">' + escapeHtml(sch.day) + '</td>';
            html += '<td style="padding:6px; text-align:center;">' + escapeHtml(sch.start_time + '-' + sch.end_time) + '</td>';
            html += '<td style="padding:6px; text-align:center;">' + quotaLeft + '/' + sch.quota + '</td>';
            html += '</tr>';
        });

        $('#modal-jadwal-result').html(html);
    }

    $('#modal-jadwal-date, #modal-jadwal-search').on('change keyup', renderJadwalModal);

    $(document).on('click', '.jadwal-row', function () {
        var $row = $(this);
        var dateVal = $('#modal-jadwal-date').val();

        $('#filter-doctor-schedule-id').val($row.data('id'));
        $('#filter-appointment-date').val(dateVal);

        var label = $row.data('doctor-name') + ' — ' + $row.data('day') + ', ' +
            $row.data('time') + ' (' + dateVal + ')';
        $('#filter-jadwal-label').text(label);

        $('#modalPilihJadwal').modal('hide');
    });

    $('#btn-jadwal-clear').on('click', function () {
        $('#filter-doctor-schedule-id').val('');
        $('#filter-appointment-date').val('');
        $('#filter-jadwal-label').text('-- Pilih Tanggal & Jadwal Dokter --');
        $('#modal-jadwal-date').val('');
        $('#modal-jadwal-search').val('');
        renderJadwalModal();
        $('#modalPilihJadwal').modal('hide');
    });

    $('#modalPilihJadwal').on('shown.bs.modal', function () {
        var savedDate = $('#filter-appointment-date').val();
        if (savedDate) {
            $('#modal-jadwal-date').val(savedDate);
        }
        renderJadwalModal();
    });

    (function initFilterLabel() {
        var savedDate = $('#filter-appointment-date').val();
        var savedId = $('#filter-doctor-schedule-id').val();

        if (!savedDate || !savedId) return;

        var matched = allDoctorSchedules.filter(function (sch) {
            return String(sch.id) === String(savedId);
        })[0];

        if (matched) {
            var label = matched.doctor_name + ' — ' + matched.day + ', ' +
                matched.start_time + '-' + matched.end_time + ' (' + savedDate + ')';
            $('#filter-jadwal-label').text(label);
        }
    })();
});
</script>
</div>