<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $polyclinicQueue
 */

$polyclinics = $polyclinicButtonData ?? [];
$selectedPoly = $this->request->getData('poly_name') ?? 'Poli Umum';
?>

<?= $this->Krs->breadcrumb('Polyclinic Queue', 'Tambah Antrian WA') ?>

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
        padding: 7px;
        border: 1px solid #d8e3ec;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 18px rgba(15, 118, 110, 0.12);
    }

    .queue-add-logo img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .queue-add-title {
        margin: 0;
        color: #112136;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 0;
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
        color: #0f766e;
    }

    .queue-input-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 18px;
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

    .queue-field .form-control:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.10);
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
        min-height: 104px;
        border-color: #bfe4d8;
        background: linear-gradient(135deg, #ecfdf7, #ffffff);
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
        color: #0f766e;
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

    .btn-submit-queue {
        min-width: 250px;
        height: 50px;
        border: 0;
        border-radius: 12px;
        background: #149966;
        color: #fff;
        font-size: 16px;
        font-weight: 800;
        box-shadow: 0 12px 22px rgba(20, 153, 102, 0.20);
    }

    .btn-submit-queue:hover,
    .btn-submit-queue:focus {
        background: #0f8557;
        color: #fff;
    }

    .btn-submit-queue:disabled {
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
        .queue-input-grid {
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
        .queue-add-form,
        .queue-add-header,
        .queue-add-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .queue-add-badge,
        .btn-submit-queue {
            width: 100%;
            justify-content: center;
        }

        .poli-grid {
            grid-template-columns: 1fr;
        }

        .poli-card.is-featured {
            grid-column: span 1;
        }
    }
</style>

<div class="queue-add-page">
    <div class="queue-add-shell">
        <div class="queue-add-header">
            <div class="queue-add-brand">
                <div class="queue-add-logo">
                    <?= $this->Html->image('logo_br.png', ['alt' => 'Logo Rumah Sakit Bhakti Rahayu']) ?>
                </div>
                <div>
                    <h1 class="queue-add-title">Tambah Antrian WA</h1>
                    <div class="queue-add-subtitle">Rumah Sakit Bhakti Rahayu</div>
                </div>
            </div>

            <div class="queue-add-badge">
                <i class="fa fa-whatsapp"></i>
                Pendaftaran Antrian via WhatsApp
            </div>
        </div>

        <div class="queue-add-body">
            <div class="queue-add-form">
                <?= $this->Flash->render() ?>

                <?= $this->Form->create($polyclinicQueue, ['id' => 'queue-add-form']) ?>
                    <h3 class="form-section-title">
                        <i class="fa fa-id-card"></i>
                        Data Pasien
                    </h3>

                    <div class="queue-input-grid">
                        <div class="queue-field">
                            <label>Nama Pasien</label>
                            <?= $this->Form->control('patients_name', [
                                'type' => 'text',
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan nama pasien',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="queue-field">
                            <label>No. HP / WhatsApp</label>
                            <?= $this->Form->control('no_telp', [
                                'type' => 'text',
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Contoh: 081234567890',
                                'required' => true,
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

                    <div class="queue-add-actions">
                        <div class="queue-help">
                            <i class="fa fa-info-circle"></i>
                            Pastikan nama dan nomor WhatsApp pasien sudah benar sebelum menyimpan.
                        </div>

                        <?= $this->Form->button('Daftar Antrian WA', [
                            'class' => 'btn-submit-queue',
                            'id' => 'btn-submit-queue',
                            'disabled' => $selectedPoly === '',
                        ]) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var selectedPolyInput = document.getElementById('selected-poly');
        var submitButton = document.getElementById('btn-submit-queue');
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
