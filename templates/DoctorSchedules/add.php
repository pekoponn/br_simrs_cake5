<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule $doctorSchedule
 * @var array $doctors
 * @var array $doctorPolyclinics
 */
?>

<style>
    .dsf-page {
        background: #f4f7fb;
        padding: 18px;
        border-radius: 16px;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .dsf-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .dsf-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dsf-header-icon {
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

    .dsf-title {
        margin: 0;
        font-weight: 800;
        color: #1f2d3d;
        font-size: 19px;
    }

    .dsf-subtitle {
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        margin-top: 2px;
    }

    .dsf-btn-back {
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
        transition: background .15s ease, transform .15s ease;
    }

    .dsf-btn-back:hover {
        background: #f1f5f9;
        color: #334155;
        transform: translateY(-1px);
    }

    .dsf-card {
        background: #ffffff;
        border: 1px solid #e3e8ef;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(31, 45, 61, .06);
        padding: 24px;
    }

    .dsf-section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #2563eb;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eef2f7;
    }

    .dsf-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px 20px;
    }

    .dsf-grid .dsf-full {
        grid-column: 1 / -1;
    }

    .dsf-field label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .02em;
        color: #64748b;
        margin-bottom: 6px;
    }

    .dsf-field .input,
    .dsf-field select,
    .dsf-field textarea,
    .dsf-field input[type="text"],
    .dsf-field input[type="time"],
    .dsf-field input[type="number"] {
        width: 100%;
        height: 42px;
        border-radius: 10px !important;
        border: 1px solid #d7dee8 !important;
        font-size: 13.5px;
        padding: 0 12px;
        background: #fff;
        transition: border-color .15s ease, box-shadow .15s ease;
        box-sizing: border-box;
    }

    .dsf-field textarea {
        height: auto;
        padding: 10px 12px;
        resize: vertical;
    }

    .dsf-field select:focus,
    .dsf-field input:focus,
    .dsf-field textarea:focus {
        border-color: #93b4fb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        outline: none;
    }

    .dsf-field .help-block,
    .dsf-field .error-message {
        font-size: 11.5px;
        color: #dc2626;
        margin-top: 4px;
        font-weight: 600;
    }

    /* Field Poli - readonly, auto-terisi */
    .dsf-poli-wrap {
        position: relative;
    }

    .dsf-poli-wrap input {
        background: #f8fafc !important;
        color: #1d4ed8;
        font-weight: 800;
        cursor: not-allowed;
    }

    .dsf-poli-wrap .dsf-poli-tag {
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

    .dsf-actions {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #eef2f7;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .dsf-btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2563eb;
        border: none;
        color: #fff !important;
        font-weight: 700;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 11px 22px;
        box-shadow: 0 6px 14px rgba(37, 99, 235, .35);
        cursor: pointer;
        transition: background .15s ease, transform .15s ease;
    }

    .dsf-btn-save:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    @media (max-width: 720px) {
        .dsf-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="doctorSchedules dsf-page">

    <div class="dsf-header">
        <div class="dsf-header-left">
            <div class="dsf-header-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="3"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <line x1="12" y1="14" x2="12" y2="18"></line>
                    <line x1="10" y1="16" x2="14" y2="16"></line>
                </svg>
            </div>
            <div>
                <h3 class="dsf-title">Tambah Jadwal Dokter</h3>
                <div class="dsf-subtitle">Isi data jadwal praktik dokter di bawah ini</div>
            </div>
        </div>

        <?= $this->Html->link(
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg> Kembali ke Daftar',
            ['action' => 'index'],
            ['class' => 'dsf-btn-back', 'escape' => false]
        ) ?>
    </div>

    <div class="dsf-card">

        <?= $this->Form->create($doctorSchedule) ?>

        <div class="dsf-section-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>
            Detail Jadwal
        </div>

        <div class="dsf-grid">

            <div class="dsf-field">
                <?= $this->Form->control('doctor_id', [
                    'label' => 'Dokter',
                    'options' => $doctors,
                    'empty' => '-- Pilih Dokter --',
                    'class' => 'input select2Form',
                    'id' => 'ds-doctor-id',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

            <div class="dsf-field">
                <label for="ds-poli-display">Poli</label>
                <div class="dsf-poli-wrap">
                    <input
                        type="text"
                        id="ds-poli-display"
                        class="input"
                        value=""
                        placeholder="Otomatis terisi setelah memilih dokter"
                        readonly
                    >
                    <span class="dsf-poli-tag">Auto</span>
                </div>
            </div>

            <div class="dsf-field">
                <?= $this->Form->control('day', [
                    'label' => 'Hari',
                    'type' => 'select',
                    'options' => [
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu'
                    ],
                    'empty' => '-- Pilih Hari --',
                    'class' => 'input select2Form',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

            <div class="dsf-field">
                <?= $this->Form->control('is_active', [
                    'label' => 'Status',
                    'type' => 'select',
                    'options' => [
                        'Y' => 'Aktif',
                        'N' => 'Tidak Aktif'
                    ],
                    'class' => 'input select2Form',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

            <div class="dsf-field">
                <?= $this->Form->control('start_time', [
                    'label' => 'Jam Mulai',
                    'type' => 'time',
                    'class' => 'input',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

            <div class="dsf-field">
                <?= $this->Form->control('end_time', [
                    'label' => 'Jam Selesai',
                    'type' => 'time',
                    'class' => 'input',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

            <div class="dsf-field">
                <?= $this->Form->control('quota', [
                    'label' => 'Kuota Pasien',
                    'type' => 'number',
                    'class' => 'input',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

            <div class="dsf-field dsf-full">
                <?= $this->Form->control('note', [
                    'label' => 'Catatan',
                    'type' => 'textarea',
                    'rows' => 3,
                    'class' => 'input',
                    'templates' => [
                        'inputContainer' => '{{content}}',
                    ],
                ]) ?>
            </div>

        </div>

        <div class="dsf-actions">
            <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'dsf-btn-back']) ?>

            <?= $this->Form->button('
                Simpan Jadwal
            ', [
                'class' => 'dsf-btn-save',
                'escape' => false,
            ]) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<script>

$(document).ready(function () {
    $('.select2Form').select2({
        width: '100%',
        minimumResultsForSearch: 0
    });
});
(function () {
    // Mapping doctor_id => nama poli, dikirim dari controller (Doctors->polyclinic_name)
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

    $(doctorSelect).on('change', updatePoli);
    updatePoli();
})();
</script>