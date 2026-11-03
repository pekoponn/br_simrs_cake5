<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PraRegistration $praRegistration
 * @var array $masterPenjamins Daftar master penjamin/asuransi (value => label), sumbernya
 */

$polyclinics = $polyclinicButtonData ?? [];
$selectedPoly = $this->request->getData('poly_name') ?? '';
$todayDate = date('Y-m-d');
$maxDate = date('Y-m-d', strtotime('+1 day'));
$selectedVisitDate = $this->request->getData('visit_date') ?? $todayDate;
?>

<?= $this->Krs->breadcrumb('Pra Registrasi', 'Buat Pra Registrasi') ?>

<style>
    .queue-add-page,
    .queue-add-page * {
        box-sizing: border-box;
    }

    .queue-add-page {
        margin: -5px 0 20px;
        color: #172033;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .queue-add-shell {
        overflow: hidden;
        border: 1px solid #dfe8f1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(31, 45, 61, 0.08);
    }

    .queue-add-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
        border-bottom: 1px solid #e8eef4;
        background: linear-gradient(90deg, #f7fbfa, #f8fbff);
    }

    .queue-add-brand {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .queue-add-logo {
        width: 52px;
        height: 52px;
        padding: 3px;
        border: 1px solid #d8e3ec;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(15, 118, 110, 0.12);
    }

    .queue-add-logo img {
        display: block;
        width: 45px;
        height: 45px;
        object-fit: contain;
    }

    .queue-add-title {
        margin: 0;
        color: #112136;
        font-size: 24px;
        font-weight: 800;
    }

    .queue-add-subtitle {
        margin-top: 4px;
        color: #667085;
        font-size: 13px;
        font-weight: 600;
    }

    .queue-add-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #ecfdf7;
        color: #0f766e;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .queue-add-form {
        padding: 22px 28px 24px;
        background: #fff;
    }

    .queue-divider {
        margin: 20px 0;
        border: 0;
        border-top: 1px dashed #dfe8f1;
    }

    .queue-input-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
        align-items: start;
    }

    .queue-input-grid.cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .queue-input-grid.cols-name-rm {
        grid-template-columns: 2.4fr 1fr;
    }

    .queue-field label,
    .queue-field .form-label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 13px;
        font-weight: 800;
    }

    .queue-field .form-control {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        border: 1px solid #d9e2ec;
        border-radius: 10px;
        color: #172033;
        font-size: 15px;
        box-shadow: none;
    }

    .queue-field textarea.form-control {
        height: auto;
        min-height: 44px;
        max-height: 90px;
        padding: 10px 14px;
        resize: none;
    }

    .queue-field .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
    }

    .queue-field .form-control[readonly] {
        background: #f1f3f5;
        color: #667085;
        cursor: not-allowed;
    }

    .queue-field .form-control[readonly]:focus {
        border-color: #d9e2ec;
        box-shadow: none;
    }

    .visit-date-row {
        display: flex;
        align-items: stretch;
        gap: 8px;
    }

    .visit-date-display {
        max-width: 220px;
        background: #fff !important;
        color: #172033;
        font-weight: 700;
        cursor: pointer;
    }

    .poli-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 9px;
    }

    .poli-card {
        min-height: 88px;
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #dce6ef;
        border-radius: 14px;
        background: #fff;
        color: #172033;
        text-align: left;
        cursor: pointer;
        transition: border-color 0.16s ease, box-shadow 0.16s ease, background 0.16s ease;
    }

    .poli-card:hover,
    .poli-card:focus {
        border-color: #0f766e;
        box-shadow: 0 10px 22px rgba(15, 118, 110, 0.12);
        outline: none;
    }

    .poli-card.is-active {
        border-color: #0f766e;
        background: #ecfdf7;
        box-shadow: 0 12px 28px rgba(15, 118, 110, 0.15);
    }

    .poli-card.is-featured {
    grid-column: span 2;
    min-height: 112px;
    border-color: #bfe4d8;
    background: linear-gradient(135deg, #ecfdf7, #ffffff);
    }

    .poli-card.is-featured .poli-card-name {
        font-size: 17px;
    }

    .poli-card-name {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.25;
    }

    .poli-card-name i {
        display: none;
        color: #0f766e;
        font-size: 20px;
    }

    .poli-card.is-active .poli-card-name i {
        display: inline-block;
    }

    .poli-card-doctor {
        display: block;
        margin-top: 6px;
        color: #344054;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.25;
    }

    .poli-card-help {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 7px;
        padding: 4px 8px;
        border-radius: 999px;
        background: #f2f7fb;
        color: #667085;
        font-size: 11px;
        font-weight: 800;
    }

    .poli-card-sessions {
        display: flex;
        flex-direction: column;
        gap: 3px;
        margin-top: 6px;
    }

    .poli-session-line {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        line-height: 1.3;
    }

    .poli-session-tag {
        display: inline-block;
        padding: 1px 6px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        margin-right: 5px;
    }

    .poli-session-tag.morning {
        background: #dcfce7;
        color: #166534;
    }

    .poli-session-tag.afternoon {
        background: #dbeafe;
        color: #1e3a8a;
    }

    .poli-card:disabled,
    .poli-card.is-disabled {
        cursor: not-allowed;
        opacity: 0.5;
        background: #f1f3f5;
        border-color: #dce6ef;
        color: #98a2b3;
    }

    .poli-card:disabled:hover,
    .poli-card.is-disabled:hover {
        border-color: #dce6ef;
        box-shadow: none;
    }

    /* ==== Radio pill group (Jenis Rujukan / Melalui) ==== */
    .pill-radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pill-radio-group input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .pill-radio-group label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 14px;
        border: 1px solid #d9e2ec;
        border-radius: 999px;
        background: #fff;
        color: #344054;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        margin: 0;
        transition: background .15s ease, border-color .15s ease, color .15s ease;
    }

    .pill-radio-group input[type="radio"]:checked + label {
        background: #0f766e;
        border-color: #0f766e;
        color: #fff;
    }

    /* ==== Pencarian pasien (modal) - sama seperti PolyclinicQueues/add.php ==== */
    .patient-field-wrapper {
        position: relative;
    }

    .patient-input-row {
        display: flex;
        align-items: stretch;
        gap: 8px;
        width: 100%;
    }

    .patient-input-row .form-control {
    flex: 1 1 auto;
    min-width: 0;
    width: 800px;
    max-width: 100%;
    }

    .btn-search-patient {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
        height: 44px;
        padding: 0 16px;
        border: 1px solid #0f766e;
        border-radius: 10px;
        background: #fff;
        color: #0f766e;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
        cursor: pointer;
        transition: background .15s ease, color .15s ease;
    }

    .btn-search-patient:hover,
    .btn-search-patient:focus {
        background: #0f766e;
        color: #fff;
        outline: none;
    }

    .patient-selected-info {
        display: none;
        margin-top: 8px;
        padding: 8px 10px;
        border: 1px solid #bfe4d8;
        border-radius: 10px;
        background: #ecfdf7;
        color: #0f766e;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.35;
    }

    .patient-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 2000;
        align-items: flex-start;
        justify-content: center;
        padding: 60px 16px;
        background: rgba(17, 33, 54, 0.5);
    }

    .patient-modal-overlay.is-open {
        display: flex;
    }

    .patient-modal {
        width: 100%;
        max-width: 560px;
        max-height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.28);
        overflow: hidden;
    }

    .patient-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px;
        border-bottom: 1px solid #e8eef4;
        background: #f8fbff;
    }

    .patient-modal-header h4 {
        margin: 0;
        color: #112136;
        font-size: 16px;
        font-weight: 800;
    }

    .patient-modal-header h4 i {
        margin-right: 8px;
        color: #0f766e;
    }

    .patient-modal-close {
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 8px;
        background: #eef2f6;
        color: #475569;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
    }

    .patient-modal-close:hover {
        background: #e2e8f0;
    }

    .patient-modal-body {
        padding: 16px 20px 8px;
        overflow-y: auto;
    }

    .patient-modal-search {
        width: 100%;
        height: 46px;
        padding: 0 14px;
        border: 1px solid #d9e2ec;
        border-radius: 10px;
        font-size: 15px;
    }

    .patient-modal-search:focus {
        border-color: #0f766e;
        outline: none;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
    }

    .patient-modal-result {
        margin-top: 12px;
        min-height: 60px;
    }

    .patient-modal-item {
        display: block;
        width: 100%;
        padding: 12px 14px;
        margin-bottom: 8px;
        border: 1px solid #e8eef4;
        border-radius: 12px;
        background: #fff;
        color: #172033;
        text-align: left;
        cursor: pointer;
        transition: border-color .15s ease, background .15s ease;
    }

    .patient-modal-item:hover,
    .patient-modal-item:focus {
        border-color: #0f766e;
        background: #ecfdf7;
        outline: none;
    }

    .patient-modal-item-name {
        display: block;
        font-size: 14px;
        font-weight: 800;
        line-height: 1.3;
    }

    .patient-modal-item-meta {
        display: block;
        margin-top: 4px;
        color: #667085;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
    }

    .patient-modal-empty,
    .patient-modal-loading {
        padding: 18px 4px;
        color: #667085;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }

    .patient-modal-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px 18px;
        color: #667085;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
    }

    .patient-modal-footer i {
        color: #1d4ed8;
    }

    .queue-add-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #e8eef4;
    }

    .queue-help {
        color: #667085;
        font-size: 13px;
        line-height: 1.45;
    }

    .queue-help i {
        margin-right: 6px;
        color: #1d4ed8;
    }

    .queue-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-queue {
        min-width: 210px;
        height: 50px;
        padding: 0 22px;
        border: 0;
        border-radius: 12px;
        background: #149966;
        color: #fff;
        font-size: 15px;
        font-weight: 800;
        box-shadow: 0 12px 22px rgba(20, 153, 102, 0.20);
        cursor: pointer;
    }

    .btn-queue:hover,
    .btn-queue:focus {
        background: #0f8557;
        color: #fff;
    }

    .btn-queue-afternoon {
        background: #1d4ed8;
        box-shadow: 0 12px 22px rgba(29, 78, 216, 0.20);
    }

    .btn-queue-afternoon:hover,
    .btn-queue-afternoon:focus {
        background: #1e40af;
    }

    .btn-queue:disabled {
        background: #a8b5c2;
        box-shadow: none;
        cursor: not-allowed;
        opacity: 0.78;
    }

    @media (max-width: 1200px) {
        .poli-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .queue-input-grid,
        .queue-input-grid.cols-3 {
            grid-template-columns: 1fr;
        }

        .poli-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .poli-card.is-featured {
            grid-column: span 2;
        }
    }

    @media (max-width: 575px) {
        .queue-add-header,
        .queue-add-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .queue-add-badge {
            width: 100%;
            justify-content: center;
        }

        .poli-grid {
            grid-template-columns: 1fr;
        }

        .poli-card.is-featured {
            grid-column: span 1;
        }

        .patient-input-row {
            flex-direction: column;
        }

        .btn-search-patient {
            width: 100%;
            justify-content: center;
        }

        .patient-modal-overlay {
            padding: 16px;
        }

        .queue-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn-queue {
            width: 100%;
        }
    }
</style>

<div class="queue-add-page">
    <div class="queue-add-shell">
        <div class="queue-add-header">
            <div class="queue-add-brand">
                <div class="queue-add-logo">
                    <?= $this->Html->image('logo_br2.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?>
                </div>
                <div>
                    <h1 class="queue-add-title">Buat Pra Registrasi</h1>
                    <div class="queue-add-subtitle">Rumah Sakit Bhakti Rahayu</div>
                </div>
            </div>

            <div class="queue-add-badge">
                <i class="fa fa-calendar-check"></i>
                Perjanjian / Pra Registrasi Pasien
            </div>
        </div>

        <div class="queue-add-form">
            <?= $this->Flash->render() ?>

            <?= $this->Form->create($praRegistration, ['id' => 'praregis-add-form']) ?>
                <div class="queue-input-grid cols-name-rm">
                    <div class="queue-field patient-field-wrapper">
                        <label>Nama Pasien</label>
                        <div class="patient-input-row">
                            <?= $this->Form->control('patients_name', [
                                'type' => 'text',
                                'label' => false,
                                'class' => 'form-control',
                                'id' => 'patient-search',
                                'placeholder' => 'Isi manual untuk pasien baru, atau klik Cari Pasien',
                                'autocomplete' => 'off',
                                'required' => true,
                            ]) ?>
                            <button type="button" class="btn-search-patient" id="btn-open-patient-modal">
                                <i class="fa fa-search"></i> Cari Pasien
                            </button>
                        </div>
                        <?= $this->Form->hidden('patient_id', ['id' => 'patient-id']) ?>
                        <div id="patient-selected-info" class="patient-selected-info"></div>
                    </div>

                    <div class="queue-field">
                        <label>No. Rekam Medis</label>
                        <?= $this->Form->control('medical_record_no', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'id' => 'patient-rm',
                            'placeholder' => 'Terisi otomatis saat pilih pasien',
                            'readonly' => true,
                        ]) ?>
                    </div>
                </div>

                <div class="queue-input-grid cols-3">
                    <div class="queue-field">
                        <label>Tanggal Lahir</label>
                        <?= $this->Form->control('birth_date', [
                            'type' => 'date',
                            'label' => false,
                            'class' => 'form-control',
                            'id' => 'patient-birthdate',
                        ]) ?>
                    </div>

                    <div class="queue-field">
                        <label>No. HP / WhatsApp</label>
                        <?= $this->Form->control('phone_number', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'id' => 'patient-phone',
                            'placeholder' => 'Contoh: 081234567890',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="queue-field">
                        <label>NIK</label>
                        <?= $this->Form->control('nik', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'id' => 'patient-nik',
                            'placeholder' => 'Nomor Induk Kependudukan',
                        ]) ?>
                    </div>
                </div>

                <div class="queue-field" style="margin-bottom: 4px;">
                    <label>Alamat</label>
                    <?= $this->Form->control('address', [
                        'type' => 'text',
                        'label' => false,
                        'class' => 'form-control',
                        'id' => 'patient-address',
                    ]) ?>
                </div>

                <hr class="queue-divider">

                <?php
                    $masterPenjamins = $masterPenjamins ?? [];
                    $selectedInsuranceType = $this->request->getData('insurance_type') ?? ($rescheduleGuarantor ?? '');
                ?>
                <div class="queue-input-grid cols-3">
                    <div class="queue-field">
                        <label>Jenis Asuransi</label>
                        <select name="insurance_type" id="insurance-type" class="form-control select2Form">
                            <option value="">-- Pilih Jenis Asuransi --</option>
                            <?php foreach ($masterPenjamins as $value => $label): ?>
                                <option value="<?= h($value) ?>" <?= $selectedInsuranceType === (string)$value ? 'selected' : '' ?>><?= h($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="queue-field">
                        <label>No. Kartu</label>
                        <?= $this->Form->control('card_number', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'id' => 'patient-card-number',
                        ]) ?>
                    </div>

                    <div class="queue-field">
                        <label>No. Rujukan / Kontrol</label>
                        <?= $this->Form->control('referral_number', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                        ]) ?>
                    </div>
                </div>

                <div class="queue-input-grid">
                    <div class="queue-field">
                        <label>Jenis Rujukan</label>
                        <?= $this->Form->control('referral_type', [
                            'type' => 'select',
                            'label' => false,
                            'class' => 'form-control select2Form',
                            'id' => 'referral-type',
                            'options' => $this->Krs->referralTypes(),
                            'empty' => 'Pilih Jenis Rujukan',
                        ]) ?>
                    </div>

                    <div class="queue-field">
                        <label>Melalui</label>
                        <?= $this->Form->control('channel', [
                            'type' => 'select',
                            'label' => false,
                            'class' => 'form-control select2Form',
                            'id' => 'channel',
                            'options' => $this->Krs->referralChannels(),
                            'default' => 'wa',
                        ]) ?>
                    </div>
                </div>

                <div class="queue-input-grid cols-3">
                    <div class="queue-field">
                        <label>Rencana Tindakan</label>
                        <?= $this->Form->control('planned_action', [
                            'type' => 'textarea',
                            'label' => false,
                            'class' => 'form-control',
                            'rows' => 2,
                        ]) ?>
                    </div>

                    <div class="queue-field">
                        <label>Keterangan</label>
                        <?= $this->Form->control('notes', [
                            'type' => 'textarea',
                            'label' => false,
                            'class' => 'form-control',
                            'rows' => 2,
                        ]) ?>
                    </div>

                    <div class="queue-field">
                        <label>No. Reservasi</label>
                        <?= $this->Form->control('reservation_code', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Diisi otomatis oleh sistem',
                            'readonly' => true,
                        ]) ?>
                    </div>
                </div>

                <hr class="queue-divider">
                <div class="queue-field" style="margin-bottom: 18px;">
                    <label>Tanggal Kunjungan</label>
                    <div class="visit-date-row">
                        <input
                            type="date"
                            class="form-control visit-date-display"
                            id="visit-date"
                            name="visit_date"
                            value="<?= h($selectedVisitDate) ?>"
                            min="<?= h($todayDate) ?>"
                            max="<?= h($maxDate) ?>"
                            required>
                    </div>
                    <small class="text-muted">*Jam kunjungan &amp; nomor antrian mengikuti jadwal dokter yang dipilih di bawah.</small>
                </div>

                <input type="hidden" name="poly_name" id="selected-poly" value="<?= h($selectedPoly) ?>">
                <?= $this->Form->hidden('doctor_id', ['id' => 'hidden-doctor-id']) ?>
                <?= $this->Form->hidden('doctor_name', ['id' => 'hidden-doctor-name']) ?>
                <?= $this->Form->hidden('appointment_time', ['id' => 'hidden-appointment-time']) ?>

                <div class="poli-grid" id="poli-grid" role="listbox" aria-label="Pilihan poli tujuan">
                    <?php foreach ($polyclinics as $poly): ?>
                        <?php
                        $polyValue = (string)$poly['value'];
                        $polyLabel = (string)$poly['label'];
                        $queueTotal = (int)$poly['total'];
                        $isFeatured = !empty($poly['is_featured']);
                        $isActive = $selectedPoly !== '' && $selectedPoly === $polyValue;
                        $sessions = $poly['sessions'] ?? ['morning' => [], 'afternoon' => []];
                        $hasMorningSchedule = !empty($sessions['morning']);
                        $hasAfternoonSchedule = !empty($sessions['afternoon']);
                        $morningAvailable = !empty($poly['morning_available']);
                        $afternoonAvailable = !empty($poly['afternoon_available']);
                        $isCardDisabled = !$morningAvailable && !$afternoonAvailable;
                        // Dokter & jam pertama tiap sesi, dipakai untuk mengisi
                        // hidden field doctor_name & appointment_time saat kartu ini dipilih.
                        $firstMorning = $sessions['morning'][0] ?? null;
                        $firstAfternoon = $sessions['afternoon'][0] ?? null;
                        ?>
                        <button
                            type="button"
                            class="poli-card<?= $isActive ? ' is-active' : '' ?><?= $isFeatured ? ' is-featured' : '' ?><?= $isCardDisabled ? ' is-disabled' : '' ?>"
                            data-poly-value="<?= h($polyValue) ?>"
                            data-has-morning="<?= ($hasMorningSchedule && $morningAvailable) ? '1' : '0' ?>"
                            data-has-afternoon="<?= ($hasAfternoonSchedule && $afternoonAvailable) ? '1' : '0' ?>"
                            data-morning-doctor-id="<?= h($firstMorning['doctor_id'] ?? '') ?>"
                            data-morning-doctor="<?= h($firstMorning['doctor_name'] ?? '') ?>"
                            data-morning-time="<?= h($firstMorning['start_time'] ?? '') ?>"
                            data-afternoon-doctor-id="<?= h($firstAfternoon['doctor_id'] ?? '') ?>"
                            data-afternoon-doctor="<?= h($firstAfternoon['doctor_name'] ?? '') ?>"
                            data-afternoon-time="<?= h($firstAfternoon['start_time'] ?? '') ?>"
                            aria-pressed="<?= $isActive ? 'true' : 'false' ?>"
                            <?= $isCardDisabled ? 'disabled' : '' ?>>
                            <span class="poli-card-name">
                                <?= h($polyLabel) ?>
                                <i class="fa fa-check-circle"></i>
                            </span>

                            <?php if (empty($sessions['morning']) && empty($sessions['afternoon'])): ?>
                                <span class="poli-card-doctor">Dokter belum tersedia</span>
                            <?php else: ?>
                                <div class="poli-card-sessions">
                                    <?php foreach ($sessions['morning'] as $sch): ?>
                                        <div class="poli-session-line">
                                            <span class="poli-session-tag morning">Pagi</span>
                                            <?= h($sch['doctor_name']) ?> (<?= h($sch['start_time']) ?>&ndash;<?= h($sch['end_time']) ?>)
                                        </div>
                                    <?php endforeach; ?>
                                    <?php foreach ($sessions['afternoon'] as $sch): ?>
                                        <div class="poli-session-line">
                                            <span class="poli-session-tag afternoon">Sore</span>
                                            <?= h($sch['doctor_name']) ?> (<?= h($sch['start_time']) ?>&ndash;<?= h($sch['end_time']) ?>)
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <span class="poli-card-help">
                                <i class="fa fa-users"></i>
                                Total Antrian: <?= h($queueTotal) ?>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="queue-add-actions">
                    <div class="queue-help">
                        <i class="fa fa-info-circle"></i>
                        Pilih dokter/poli lalu tekan salah satu tombol untuk menyimpan pra registrasi sesuai sesi jadwal.
                    </div>

                    <div class="queue-buttons">
                        <button type="submit" class="btn-queue" id="btn-queue-morning" name="queue_session" value="morning" disabled>
                            Pra Registrasi Pagi (A)
                        </button>
                        <button type="submit" class="btn-queue btn-queue-afternoon" id="btn-queue-afternoon" name="queue_session" value="afternoon" disabled>
                            Pra Registrasi Sore (B)
                        </button>
                    </div>
                </div>
            <?= $this->Form->end() ?>

            <div class="patient-modal-overlay" id="patient-modal-overlay">
                <div class="patient-modal" role="dialog" aria-modal="true" aria-labelledby="patient-modal-title">
                    <div class="patient-modal-header">
                        <h4 id="patient-modal-title"><i class="fa fa-users"></i> Cari Pasien Terdaftar</h4>
                        <button type="button" class="patient-modal-close" id="patient-modal-close" aria-label="Tutup">&times;</button>
                    </div>
                    <div class="patient-modal-body">
                        <input
                            type="text"
                            id="patient-modal-search"
                            class="patient-modal-search"
                            placeholder="Cari nama / no RM / NIK / no WA"
                            autocomplete="off">
                        <div id="patient-modal-result" class="patient-modal-result"></div>
                    </div>
                    <div class="patient-modal-footer">
                        <i class="fa fa-info-circle"></i>
                        Pasien tidak ketemu? Tutup modal ini lalu isi nama &amp; No. HP secara manual untuk pasien baru.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var PolyQueuePicker = (function() {
        var selectedPolyInput = document.getElementById('selected-poly');
        var hiddenDoctorIdInput = document.getElementById('hidden-doctor-id');
        var hiddenDoctorIdInput = document.getElementById('hidden-doctor-id');
        var hiddenDoctorInput = document.getElementById('hidden-doctor-name');
        var hiddenTimeInput = document.getElementById('hidden-appointment-time');
        var morningBtn = document.getElementById('btn-queue-morning');
        var afternoonBtn = document.getElementById('btn-queue-afternoon');
        var grid = document.getElementById('poli-grid');

        function updateQueueButtons(card) {
            if (!card) {
                morningBtn.disabled = true;
                afternoonBtn.disabled = true;
                return;
            }
            morningBtn.disabled = card.getAttribute('data-has-morning') !== '1';
            afternoonBtn.disabled = card.getAttribute('data-has-afternoon') !== '1';
        }

        function selectPoly(card) {
            grid.querySelectorAll('.poli-card').forEach(function(item) {
                item.classList.remove('is-active');
                item.setAttribute('aria-pressed', 'false');
            });

            card.classList.add('is-active');
            card.setAttribute('aria-pressed', 'true');
            selectedPolyInput.value = card.getAttribute('data-poly-value') || '';
            updateQueueButtons(card);
        }

        // Isi hidden doctor_name & appointment_time dari kartu yang aktif,
        // sesuai sesi (morning/afternoon) tombol yang ditekan. Dipanggil
        // tepat sebelum form submit supaya kolom wajib di tabel selalu terisi.
        function fillSessionFieldsFromActiveCard(session) {
            var activeCard = grid.querySelector('.poli-card.is-active');
            if (!activeCard || !hiddenDoctorInput || !hiddenTimeInput) {
                return;
            }
            if (hiddenDoctorIdInput) {
                hiddenDoctorIdInput.value = activeCard.getAttribute('data-' + session + '-doctor-id') || '';
            }
            hiddenDoctorInput.value = activeCard.getAttribute('data-' + session + '-doctor') || '';
            hiddenTimeInput.value = activeCard.getAttribute('data-' + session + '-time') || '';
        }

        function bindCardClicks() {
            grid.querySelectorAll('.poli-card').forEach(function(card) {
                if (card.disabled) {
                    return;
                }
                card.addEventListener('click', function() {
                    selectPoly(card);
                });
            });
        }

        function bindSessionButtons() {
            if (morningBtn) {
                morningBtn.addEventListener('click', function() {
                    fillSessionFieldsFromActiveCard('morning');
                });
            }
            if (afternoonBtn) {
                afternoonBtn.addEventListener('click', function() {
                    fillSessionFieldsFromActiveCard('afternoon');
                });
            }
        }

        function initFromServerRender() {
            bindCardClicks();
            bindSessionButtons();
            var activeCard = grid.querySelector('.poli-card.is-active');
            updateQueueButtons(activeCard);
        }

        return {
            init: initFromServerRender,
            bindCardClicks: bindCardClicks,
            updateQueueButtons: updateQueueButtons,
            resetSelection: function() {
                selectedPolyInput.value = '';
                if (hiddenDoctorInput) hiddenDoctorInput.value = '';
                if (hiddenTimeInput) hiddenTimeInput.value = '';
                updateQueueButtons(null);
            }
        };
    })();

    PolyQueuePicker.init();

    $(document).ready(function () {
        $(".select2Form").select2();
    });

    (function() {
        var visitDateInput = document.getElementById('visit-date');
        var todayDate = '<?= h($todayDate) ?>';
        var maxDate = '<?= h($maxDate) ?>';
        var grid = document.getElementById('poli-grid');

        // Endpoint jadwal dokter dipakai bersama dengan modul Polyclinic Queue,
        // supaya sumber datanya satu (tidak duplikat logic jadwal dokter).
        var scheduleUrl = '<?= $this->Url->build(['controller' => 'PolyclinicQueues', 'action' => 'getPolyclinicSchedule']) ?>';

        if (!visitDateInput) {
            return;
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function sessionLinesHtml(sessions, type, label) {
            return (sessions[type] || []).map(function(sch) {
                return '<div class="poli-session-line">' +
                    '<span class="poli-session-tag ' + type + '">' + label + '</span>' +
                    escapeHtml(sch.doctor_name) + ' (' + escapeHtml(sch.start_time) + '&ndash;' + escapeHtml(sch.end_time) + ')' +
                    '</div>';
            }).join('');
        }

        function buildCardHtml(poly) {
            var sessions = poly.sessions || { morning: [], afternoon: [] };
            var hasMorning = (sessions.morning && sessions.morning.length > 0);
            var hasAfternoon = (sessions.afternoon && sessions.afternoon.length > 0);
            var isDisabled = !poly.morning_available && !poly.afternoon_available;
            var isFeatured = !!poly.is_featured;
            var firstMorning = hasMorning ? sessions.morning[0] : null;
            var firstAfternoon = hasAfternoon ? sessions.afternoon[0] : null;

            var classes = 'poli-card' + (isFeatured ? ' is-featured' : '') + (isDisabled ? ' is-disabled' : '');
            var doctorHtml = (!hasMorning && !hasAfternoon)
                ? '<span class="poli-card-doctor">Dokter belum tersedia</span>'
                : '<div class="poli-card-sessions">' +
                    sessionLinesHtml(sessions, 'morning', 'Pagi') +
                    sessionLinesHtml(sessions, 'afternoon', 'Sore') +
                    '</div>';

            return '<button type="button" class="' + classes + '"' +
                ' data-poly-value="' + escapeHtml(poly.value) + '"' +
                ' data-has-morning="' + (hasMorning && poly.morning_available ? '1' : '0') + '"' +
                ' data-has-afternoon="' + (hasAfternoon && poly.afternoon_available ? '1' : '0') + '"' +
                ' data-morning-doctor-id="' + escapeHtml(firstMorning ? firstMorning.doctor_id : '') + '"' +
                ' data-morning-doctor="' + escapeHtml(firstMorning ? firstMorning.doctor_name : '') + '"' +
                ' data-morning-time="' + escapeHtml(firstMorning ? firstMorning.start_time : '') + '"' +
                ' data-afternoon-doctor-id="' + escapeHtml(firstAfternoon ? firstAfternoon.doctor_id : '') + '"' +
                ' data-afternoon-doctor="' + escapeHtml(firstAfternoon ? firstAfternoon.doctor_name : '') + '"' +
                ' data-afternoon-time="' + escapeHtml(firstAfternoon ? firstAfternoon.start_time : '') + '"' +
                ' aria-pressed="false"' +
                (isDisabled ? ' disabled' : '') + '>' +
                '<span class="poli-card-name">' + escapeHtml(poly.label) + ' <i class="fa fa-check-circle"></i></span>' +
                doctorHtml +
                '<span class="poli-card-help"><i class="fa fa-users"></i> Total Antrian: ' + escapeHtml(poly.total) + '</span>' +
                '</button>';
        }

        function refreshScheduleForDate(dateValue) {
            if (!grid) {
                return;
            }

            fetch(scheduleUrl + '?visit_date=' + encodeURIComponent(dateValue), {
                headers: { 'Accept': 'application/json' }
            })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (!Array.isArray(data)) {
                        return;
                    }
                    grid.innerHTML = data.map(buildCardHtml).join('');
                    PolyQueuePicker.bindCardClicks();
                    PolyQueuePicker.resetSelection();
                })
                .catch(function() {
                    // Biarkan kartu lama tetap tampil kalau AJAX gagal.
                });
        }

        visitDateInput.addEventListener('click', function() {
            if (typeof visitDateInput.showPicker === 'function') {
                try {
                    visitDateInput.showPicker();
                } catch (e) {
                }
            }
        });

        visitDateInput.addEventListener('change', function() {
            var val = visitDateInput.value;

            if (!val || val < todayDate || val > maxDate) {
                val = todayDate;
                visitDateInput.value = todayDate;
            }

            refreshScheduleForDate(val);
        });

        var initialDate = visitDateInput.value || todayDate;
        if (!initialDate || initialDate < todayDate || initialDate > maxDate) {
            initialDate = todayDate;
            visitDateInput.value = todayDate;
        }
        refreshScheduleForDate(initialDate);
    })();

    // ==== Modal cari pasien terdaftar - identik dengan PolyclinicQueues/add.php ====
    (function() {
        var openBtn = document.getElementById('btn-open-patient-modal');
        var closeBtn = document.getElementById('patient-modal-close');
        var overlay = document.getElementById('patient-modal-overlay');
        var modalSearch = document.getElementById('patient-modal-search');
        var resultBox = document.getElementById('patient-modal-result');

        var nameInput = document.getElementById('patient-search');
        var phoneInput = document.getElementById('patient-phone');
        var rmInput = document.getElementById('patient-rm');
        var nikInput = document.getElementById('patient-nik');
        var addressInput = document.getElementById('patient-address');
        var birthdateInput = document.getElementById('patient-birthdate');
        var cardNumberInput = document.getElementById('patient-card-number');
        var patientIdInput = document.getElementById('patient-id');
        var selectedInfo = document.getElementById('patient-selected-info');

        // Endpoint pencarian pasien dipakai bersama dengan modul Polyclinic Queue
        // (satu master data patients, jangan bikin endpoint baru yang duplikat).
        var searchUrl = '<?= $this->Url->build(['controller' => 'PolyclinicQueues', 'action' => 'searchPatients']) ?>';
        var typingTimer = null;
        var lastSelectedName = '';

        if (!openBtn || !overlay || !modalSearch || !resultBox) {
            return;
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function showSelectedInfo(item) {
            if (!selectedInfo) {
                return;
            }

            var code = item.code || '-';
            var identityNumber = item.identity_number || '-';
            var phone = item.phone_number || '-';

            selectedInfo.innerHTML = '<i class="fa fa-check-circle"></i> Pasien dipilih | RM: ' +
                escapeHtml(code) + ' | NIK: ' + escapeHtml(identityNumber) + ' | WA: ' + escapeHtml(phone);
            selectedInfo.style.display = 'block';
        }

        function clearSelectedPatient() {
            patientIdInput.value = '';
            lastSelectedName = '';
            if (selectedInfo) {
                selectedInfo.style.display = 'none';
                selectedInfo.innerHTML = '';
            }
        }

        function openModal() {
            overlay.classList.add('is-open');
            modalSearch.value = '';
            resultBox.innerHTML = '';
            fetchPatients('');
            setTimeout(function() { modalSearch.focus(); }, 50);
        }

        function closeModal() {
            overlay.classList.remove('is-open');
        }

        function renderLoading() {
            resultBox.innerHTML = '<div class="patient-modal-loading">Mencari data pasien...</div>';
        }

        function renderResults(data) {
            resultBox.innerHTML = '';

            if (!data || data.length === 0) {
                resultBox.innerHTML = '<div class="patient-modal-empty">Pasien tidak ditemukan. Tutup modal ini dan isi data pasien baru secara manual.</div>';
                return;
            }

            data.forEach(function(item) {
                var button = document.createElement('button');
                button.type = 'button';
                button.className = 'patient-modal-item';
                button.innerHTML =
                    '<span class="patient-modal-item-name">' + escapeHtml(item.full_name || '-') + '</span>' +
                    '<span class="patient-modal-item-meta">RM: ' + escapeHtml(item.code || '-') +
                    ' | NIK: ' + escapeHtml(item.identity_number || '-') +
                    ' | WA: ' + escapeHtml(item.phone_number || '-') + '</span>';

                button.addEventListener('click', function() {
                    nameInput.value = item.full_name || '';
                    phoneInput.value = item.phone_number || '';
                    if (rmInput) rmInput.value = item.code || '';
                    if (nikInput) nikInput.value = item.identity_number || '';
                    if (addressInput) addressInput.value = item.address || '';
                    if (birthdateInput) birthdateInput.value = item.birth_date || '';
                    if (cardNumberInput) cardNumberInput.value = item.insurance_card_no || '';
                    patientIdInput.value = item.id || '';
                    lastSelectedName = nameInput.value;
                    showSelectedInfo(item);
                    closeModal();
                });

                resultBox.appendChild(button);
            });
        }

        function fetchPatients(keyword) {
            renderLoading();

            fetch(searchUrl + '?q=' + encodeURIComponent(keyword), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function(response) {
                    return response.json().then(function(payload) {
                        if (!response.ok) {
                            throw new Error(payload.message || 'Gagal mencari data pasien.');
                        }

                        return payload;
                    });
                })
                .then(function(data) {
                    if (data && data.patients) {
                        data = data.patients;
                    }

                    if (!Array.isArray(data)) {
                        throw new Error('Format data pasien tidak sesuai.');
                    }

                    renderResults(data);
                })
                .catch(function(error) {
                    resultBox.innerHTML = '<div class="patient-modal-empty">' + escapeHtml(error.message || 'Gagal mencari data pasien.') + '</div>';
                });
        }

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);

        overlay.addEventListener('click', function(event) {
            if (event.target === overlay) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && overlay.classList.contains('is-open')) {
                closeModal();
            }
        });

        modalSearch.addEventListener('input', function() {
            var keyword = modalSearch.value.trim();
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                fetchPatients(keyword);
            }, 300);
        });

        nameInput.addEventListener('input', function() {
            if (patientIdInput.value !== '' && nameInput.value !== lastSelectedName) {
                clearSelectedPatient();
            }
        });
    })();
</script>