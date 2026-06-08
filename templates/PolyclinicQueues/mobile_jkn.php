<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $polyclinicQueue
 */

$polyclinics = $polyclinicButtonData ?? [];
$selectedPoly = $this->request->getData('poly_name') ?? 'Poli Umum';
$selectedStatus = $this->request->getData('checkin_status') ?? 'Belum Check-in';
$statusList = [
    'Belum Check-in' => 'Belum Check-in',
    'Sudah Check-in' => 'Sudah Check-in',
    'Batal' => 'Batal',
    'Selesai' => 'Selesai',
];
?>

<?= $this->Krs->breadcrumb('Polyclinic Queue', 'Tambah Antrian Mobile JKN') ?>

<style>
    .mobile-jkn-page,
    .mobile-jkn-page * {
        box-sizing: border-box;
    }

    .mobile-jkn-page {
        margin: -5px 0 20px;
        color: #172033;
        font-family: "Open Sans", "Segoe UI", Arial, sans-serif;
    }

    .mobile-jkn-shell {
        overflow: hidden;
        border: 1px solid #dfe8f1;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(31, 45, 61, 0.08);
    }

    .mobile-jkn-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 22px;
        border-bottom: 1px solid #e8eef4;
        background: linear-gradient(90deg, #f7fbff, #f8f7ff);
    }

    .mobile-jkn-brand {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .mobile-jkn-logo {
        width: 52px;
        height: 52px;
        padding: 7px;
        border: 1px solid #d8e3ec;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(67, 56, 202, 0.12);
    }

    .mobile-jkn-logo img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .mobile-jkn-title {
        margin: 0;
        color: #112136;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 0;
    }

    .mobile-jkn-subtitle {
        margin-top: 4px;
        color: #667085;
        font-size: 13px;
        font-weight: 600;
    }

    .mobile-jkn-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #eef2ff;
        color: #3730a3;
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    .mobile-jkn-form {
        padding: 22px 28px 24px;
        background: #fff;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 12px;
        color: #112136;
        font-size: 18px;
        font-weight: 800;
    }

    .form-section-title i {
        color: #4338ca;
    }

    .mobile-jkn-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .mobile-jkn-field label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 13px;
        font-weight: 800;
    }

    .mobile-jkn-field .form-control {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        border: 1px solid #d9e2ec;
        border-radius: 10px;
        color: #172033;
        font-size: 15px;
        box-shadow: none;
    }

    .mobile-jkn-field .form-control:focus {
        border-color: #4338ca;
        box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.10);
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
        border-color: #4338ca;
        box-shadow: 0 10px 22px rgba(67, 56, 202, 0.12);
        outline: none;
    }

    .poli-card.is-active {
        border-color: #4338ca;
        background: #eef2ff;
        box-shadow: 0 12px 28px rgba(67, 56, 202, 0.15);
    }

    .poli-card.is-featured {
        grid-column: span 2;
        min-height: 104px;
        border-color: #c7d2fe;
        background: linear-gradient(135deg, #eef2ff, #ffffff);
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

    .poli-card-doctor {
        display: block;
        margin-top: 6px;
        color: #344054;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.25;
    }

    .poli-card-name i {
        display: none;
        color: #4338ca;
        font-size: 20px;
    }

    .poli-card.is-active .poli-card-name i {
        display: inline-block;
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

    .mobile-jkn-actions {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #e8eef4;
    }

    .mobile-jkn-help {
        color: #667085;
        font-size: 13px;
        line-height: 1.45;
    }

    .mobile-jkn-help i {
        margin-right: 6px;
        color: #4338ca;
    }

    .btn-submit-mobile-jkn {
        min-width: 250px;
        height: 50px;
        border: 0;
        border-radius: 12px;
        background: #4338ca;
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        box-shadow: 0 12px 22px rgba(67, 56, 202, 0.20);
    }

    .btn-submit-mobile-jkn:hover,
    .btn-submit-mobile-jkn:focus {
        background: #3730a3;
        color: #fff;
    }

    .btn-submit-mobile-jkn:disabled {
        background: #a8b5c2;
        box-shadow: none;
        cursor: not-allowed;
        opacity: 0.78;
    }

    @media (max-width: 1200px) {
        .mobile-jkn-grid,
        .poli-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 991px) {
        .mobile-jkn-grid,
        .poli-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .poli-card.is-featured {
            grid-column: span 2;
        }
    }

    @media (max-width: 575px) {
        .mobile-jkn-header,
        .mobile-jkn-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .mobile-jkn-grid,
        .poli-grid {
            grid-template-columns: 1fr;
        }

        .poli-card.is-featured {
            grid-column: span 1;
        }

        .mobile-jkn-badge,
        .btn-submit-mobile-jkn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="mobile-jkn-page">
    <div class="mobile-jkn-shell">
        <div class="mobile-jkn-header">
            <div class="mobile-jkn-brand">
                <div class="mobile-jkn-logo">
                    <?= $this->Html->image('logo_br.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?>
                </div>
                <div>
                    <h1 class="mobile-jkn-title">Tambah Antrian Mobile JKN</h1>
                    <div class="mobile-jkn-subtitle">Simulasi antrean online sebelum integrasi BPJS asli</div>
                </div>
            </div>

            <div class="mobile-jkn-badge">
                <i class="fa fa-mobile-alt"></i>
                Source: Mobile JKN
            </div>
        </div>

        <div class="mobile-jkn-form">
            <?= $this->Flash->render() ?>

            <?= $this->Form->create($polyclinicQueue, ['id' => 'mobile-jkn-form']) ?>
                <h3 class="form-section-title">
                    <i class="fa fa-ticket-alt"></i>
                    Data Booking Mobile JKN
                </h3>

                <div class="mobile-jkn-grid">
                    <div class="mobile-jkn-field">
                        <label>Kode Booking</label>
                        <?= $this->Form->control('booking_code', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Contoh: MJKN-20260604-001',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="mobile-jkn-field">
                        <label>Nama Pasien</label>
                        <?= $this->Form->control('patients_name', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Masukkan nama pasien',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="mobile-jkn-field">
                        <label>No. HP</label>
                        <?= $this->Form->control('no_telp', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Contoh: 081234567890',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="mobile-jkn-field">
                        <label>NIK</label>
                        <?= $this->Form->control('identity_number', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => '16 digit NIK',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="mobile-jkn-field">
                        <label>No Kartu BPJS</label>
                        <?= $this->Form->control('bpjs_number', [
                            'type' => 'text',
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'Nomor kartu BPJS',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="mobile-jkn-field">
                        <label>Tanggal Periksa</label>
                        <?= $this->Form->control('visit_date', [
                            'type' => 'date',
                            'label' => false,
                            'class' => 'form-control',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="mobile-jkn-field">
                        <label>Status Check-in</label>
                        <?= $this->Form->control('checkin_status', [
                            'type' => 'select',
                            'label' => false,
                            'class' => 'form-control',
                            'options' => $statusList,
                            'value' => $selectedStatus,
                        ]) ?>
                    </div>
                </div>

                <input type="hidden" name="poly_name" id="selected-poly" value="<?= h($selectedPoly) ?>">

                <h3 class="form-section-title">
                    <i class="fa fa-clinic-medical"></i>
                    Pilih Poli Tujuan
                </h3>

                <div class="poli-grid" role="listbox" aria-label="Pilihan poli tujuan">
                    <?php foreach ($polyclinics as $poly): ?>
                        <?php
                        $polyValue = (string)$poly['value'];
                        $polyLabel = (string)$poly['label'];
                        $doctorName = (string)$poly['doctor'];
                        $queueTotal = (int)$poly['total'];
                        $isFeatured = !empty($poly['is_featured']);
                        $isActive = $selectedPoly !== '' && $selectedPoly === $polyValue;
                        ?>
                        <button
                            type="button"
                            class="poli-card<?= $isActive ? ' is-active' : '' ?><?= $isFeatured ? ' is-featured' : '' ?>"
                            data-poly-value="<?= h($polyValue) ?>"
                            aria-pressed="<?= $isActive ? 'true' : 'false' ?>">
                            <span class="poli-card-name">
                                <?= h($polyLabel) ?>
                                <i class="fa fa-check-circle"></i>
                            </span>
                            <span class="poli-card-doctor"><?= h($doctorName) ?></span>
                            <span class="poli-card-help">
                                <i class="fa fa-users"></i>
                                Total Antrian: <?= h($queueTotal) ?>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="mobile-jkn-actions">
                    <div class="mobile-jkn-help">
                        <i class="fa fa-info-circle"></i>
                        Data ini masih dummy/simulasi. Nanti field ini bisa dipakai untuk mapping ke API Antrean Online BPJS.
                    </div>

                    <?= $this->Form->button('Simpan Antrian Mobile JKN', [
                        'class' => 'btn-submit-mobile-jkn',
                        'id' => 'btn-submit-mobile-jkn',
                        'disabled' => $selectedPoly === '',
                    ]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
    (function() {
        var selectedPolyInput = document.getElementById('selected-poly');
        var submitButton = document.getElementById('btn-submit-mobile-jkn');
        var poliCards = document.querySelectorAll('.poli-card');

        function selectPoly(card) {
            poliCards.forEach(function(item) {
                item.classList.remove('is-active');
                item.setAttribute('aria-pressed', 'false');
            });

            card.classList.add('is-active');
            card.setAttribute('aria-pressed', 'true');
            selectedPolyInput.value = card.getAttribute('data-poly-value') || '';
            submitButton.disabled = selectedPolyInput.value === '';
        }

        poliCards.forEach(function(card) {
            card.addEventListener('click', function() {
                selectPoly(card);
            });
        });
    })();
</script>
