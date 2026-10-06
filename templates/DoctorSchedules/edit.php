<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule $doctorSchedule
 * @var string[]|\Cake\Collection\CollectionInterface $doctors
 * @var array $doctorPolyclinics
 */

function fmtDsTimeForInput($val) {
    if (empty($val)) return '';
    if ($val instanceof \Cake\I18n\FrozenTime || $val instanceof \Cake\I18n\Time) {
        return $val->format('H:i');
    }
    $ts = strtotime((string)$val);
    return $ts ? date('H:i', $ts) : '';
}

$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
?>

<style>
    .ds-page {
        background: #f4f7fb;
        padding: 18px;
        border-radius: 16px;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .ds-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
        max-width: 680px;
    }

    .ds-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ds-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(145deg, #2563eb, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #ffffff;
        box-shadow: 0 6px 14px rgba(37, 99, 235, .30);
    }

    .ds-title {
        margin: 0;
        font-weight: 800;
        color: #1f2d3d;
        font-size: 19px;
    }

    .ds-subtitle {
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        margin-top: 2px;
    }

    .ds-btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #d7dee8;
        color: #334155 !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px 16px;
        transition: background .15s ease;
    }

    .ds-btn-back:hover {
        background: #f1f5f9;
        color: #334155;
    }

    .ds-card {
        background: #ffffff;
        border: 1px solid #e3e8ef;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(31, 45, 61, .06);
        padding: 24px;
        margin-bottom: 18px;
    }

    .ds-form-section-title {
        font-size: 13px;
        font-weight: 800;
        color: #1f2d3d;
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f7;
    }

    .ds-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    .ds-form-grid.ds-grid-3 {
        grid-template-columns: 1fr 1fr 1fr;
    }

    .ds-form-group {
        display: flex;
        flex-direction: column;
    }

    .ds-form-group.full {
        grid-column: 1 / -1;
    }

    .ds-form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    .ds-form-label .req {
        color: #dc2626;
    }

    .ds-form-control {
        height: 40px;
        border-radius: 10px !important;
        border: 1px solid #d7dee8 !important;
        font-size: 13.5px !important;
        padding: 0 12px !important;
    }

    textarea.ds-form-control {
        height: auto;
        padding: 10px 12px !important;
        min-height: 90px;
    }

    .ds-form-control:focus {
        border-color: #93b4fb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        outline: none;
    }

    .ds-toggle-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 10px;
        width: fit-content;
    }

    .ds-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 18px;
        border-top: 1px solid #eef2f7;
    }

    .ds-btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid #d7dee8;
        color: #334155 !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px 20px;
    }

    .ds-btn-cancel:hover {
        background: #f1f5f9;
        color: #334155;
    }

    .ds-btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563eb;
        border: none;
        color: #fff !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px 22px;
        box-shadow: 0 6px 14px rgba(37, 99, 235, .35);
        cursor: pointer;
    }

    .ds-btn-submit:hover {
        background: #1d4ed8;
    }

    /* Field Poli - readonly, auto-terisi */
    .ds-poli-wrap {
        position: relative;
    }

    .ds-estimasi-wrap {
        position: relative;
    }

    .ds-estimasi-wrap input {
        background: #f8fafc !important;
        color: #1d4ed8;
        font-weight: 800;
        cursor: not-allowed;
    }

    .ds-estimasi-wrap .ds-estimasi-tag {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        background: #eef2f7;
        padding: 3px 8px;
        border-radius: 999px;
        pointer-events: none;
    }

    .ds-poli-wrap input {
        background: #f8fafc !important;
        color: #1d4ed8;
        font-weight: 800;
        cursor: not-allowed;
    }

    .ds-poli-wrap .ds-poli-tag {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        background: #eef2f7;
        padding: 3px 8px;
        border-radius: 999px;
        pointer-events: none;
    }

    @media (max-width: 700px) {
        .ds-form-grid,
        .ds-form-grid.ds-grid-3 {
            grid-template-columns: 1fr;
        }
        .ds-header {
            max-width: 100%;
        }
    }
</style>

<div class="ds-page">

    <div class="ds-header">
        <div class="ds-header-left">
            <div class="ds-header-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                </svg>
            </div>
            <div>
                <h3 class="ds-title">Edit Jadwal Dokter</h3>
                <div class="ds-subtitle">Perbarui jadwal praktik dokter</div>
            </div>
        </div>

        <?= $this->Html->link(
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"></path><path d="M12 19l-7-7 7-7"></path></svg> Kembali',
            ['action' => 'index'],
            ['class' => 'ds-btn-back', 'escape' => false]
        ) ?>
    </div>

    <div class="ds-card">

        <?= $this->Form->create($doctorSchedule) ?>

        <div class="ds-form-section-title">Informasi Jadwal</div>

        <div class="ds-form-grid ds-grid-3">
            <div class="ds-form-group">
                <label class="ds-form-label">Kode</label>
                <?= $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control ds-form-control',
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>

            <div class="ds-form-group">
                <label class="ds-form-label">Dokter <span class="req">*</span></label>
                <?= $this->Form->control('doctor_id', [
                    'label' => false,
                    'options' => $doctors,
                    'class' => 'form-control ds-form-control select2Form',
                    'empty' => '-- Pilih Dokter --',
                    'id' => 'ds-doctor-id',
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>

            <div class="ds-form-group">
                <label class="ds-form-label">Poli</label>
                <div class="ds-poli-wrap">
                    <input
                        type="text"
                        id="ds-poli-display"
                        class="form-control ds-form-control"
                        value=""
                        placeholder="Otomatis terisi setelah memilih dokter"
                        readonly
                    >
                    <span class="ds-poli-tag">Auto</span>
                </div>
            </div>
        </div>

        <div class="ds-form-grid ds-grid-3">
            <div class="ds-form-group">
                <label class="ds-form-label">Hari <span class="req">*</span></label>
                <?= $this->Form->control('day', [
                    'type' => 'select',
                    'label' => false,
                    'options' => array_combine($days, $days),
                    'class' => 'form-control ds-form-control select2Form',
                    'empty' => '-- Pilih Hari --',
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>

            <div class="ds-form-group">
                <label class="ds-form-label">Jam Mulai <span class="req">*</span></label>
                <?= $this->Form->control('start_time', [
                    'type' => 'time',
                    'label' => false,
                    'value' => fmtDsTimeForInput($doctorSchedule->start_time),
                    'class' => 'form-control ds-form-control',
                    'id' => 'ds-start-time',
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>

            <div class="ds-form-group">
                <label class="ds-form-label">Jam Selesai <span class="req">*</span></label>
                <?= $this->Form->control('end_time', [
                    'type' => 'time',
                    'label' => false,
                    'value' => fmtDsTimeForInput($doctorSchedule->end_time),
                    'class' => 'form-control ds-form-control',
                    'id' => 'ds-end-time',
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>
        </div>

        <div class="ds-form-grid ds-grid-3">
            <div class="ds-form-group">
                <label class="ds-form-label">Kuota</label>
                <?= $this->Form->control('quota', [
                    'label' => false,
                    'type' => 'number',
                    'min' => 0,
                    'class' => 'form-control ds-form-control',
                    'placeholder' => 'Jumlah kuota pasien',
                    'id' => 'ds-quota',
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>

            <div class="ds-form-group">
                <label class="ds-form-label">Estimasi per Pasien</label>
                <div class="ds-estimasi-wrap">
                    <input
                        type="text"
                        id="ds-estimasi-display"
                        class="form-control ds-form-control"
                        value="<?= !empty($doctorSchedule->estimated_minutes) ? h($doctorSchedule->estimated_minutes) . ' menit/pasien' : '' ?>"
                        placeholder="Otomatis dihitung dari jam & kuota"
                        readonly
                    >
                    <span class="ds-estimasi-tag">Auto</span>
                </div>
            </div>

            <div class="ds-form-group full">
                <label class="ds-form-label">Catatan</label>
                <?= $this->Form->control('note', [
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control ds-form-control',
                    'placeholder' => 'Catatan tambahan (opsional)...',
                    'rows' => 3,
                    'templates' => ['inputContainer' => '{{content}}'],
                ]) ?>
            </div>
        </div>

        <div class="ds-form-section-title">Status</div>

        <div class="ds-toggle-wrap" style="margin-bottom:20px;">
            <?= $this->Form->control('is_active', [
                'type' => 'checkbox',
                'label' => 'Jadwal Aktif',
                'checked' => ($doctorSchedule->is_active === 'Y' || $doctorSchedule->is_active === 1 || $doctorSchedule->is_active === '1'),
                'value' => 1,
                'hiddenField' => true,
            ]) ?>
        </div>

        <?= $this->Form->hidden('is_update', ['value' => 1]) ?>

        <div class="ds-form-actions">
            <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'ds-btn-cancel']) ?>
            <?= $this->Form->button('Simpan Perubahan', [
                'class' => 'ds-btn-submit',
                'escape' => false,
            ]) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>

</div>

<script>
    $(document).ready(function () {
        if ($.fn.select2) {
            $(".select2Form").select2();
        }
    });

    (function () {
        var doctorPolyclinics = <?= json_encode($doctorPolyclinics ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

        var doctorSelect = document.getElementById('ds-doctor-id');
        var poliInput = document.getElementById('ds-poli-display');

        if (!doctorSelect || !poliInput) {
            return;
        }

        function updatePoli() {
            var selectedId = doctorSelect.value;
            var poli = doctorPolyclinics[selectedId];
            poliInput.value = poli ? poli : '';
        }

        doctorSelect.addEventListener('change', updatePoli);
        updatePoli();

        if (window.jQuery && jQuery.fn.select2) {
            jQuery(doctorSelect).on('select2:select select2:clear', updatePoli);
        }
    })();

    (function () {
    var startInput = document.getElementById('ds-start-time');
    var endInput = document.getElementById('ds-end-time');
    var quotaInput = document.getElementById('ds-quota');
    var estimasiInput = document.getElementById('ds-estimasi-display');

    if (!startInput || !endInput || !quotaInput || !estimasiInput) {
        return;
    }

    function updateEstimasi() {
        var start = startInput.value;
        var end = endInput.value;
        var quota = parseInt(quotaInput.value, 10);

        if (!start || !end || !quota || quota <= 0) {
            estimasiInput.value = '';
            return;
        }

        var startParts = start.split(':');
        var endParts = end.split(':');

        if (startParts.length < 2 || endParts.length < 2) {
            estimasiInput.value = '';
            return;
        }

        var startMinutes = (parseInt(startParts[0], 10) * 60) + parseInt(startParts[1], 10);
        var endMinutes = (parseInt(endParts[0], 10) * 60) + parseInt(endParts[1], 10);
        var totalMinutes = endMinutes - startMinutes;

        if (totalMinutes <= 0) {
            estimasiInput.value = 'Jam tidak valid';
            return;
        }

        var perPatient = Math.round(totalMinutes / quota);
        estimasiInput.value = perPatient + ' menit/pasien';
    }

    startInput.addEventListener('change', updateEstimasi);
    endInput.addEventListener('change', updateEstimasi);
    quotaInput.addEventListener('input', updateEstimasi);
})();
</script>