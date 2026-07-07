<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */
?>

<?= $this->Krs->breadcrumb('Pasien', 'Edit') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-edit"></i> Edit Pasien — <?= h($patient->full_name) ?>
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($patient) ?>

        <!-- ── SECTION 1: Data Utama ─────────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-id-card"></i> Data Utama
        </h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Kode Pasien</label>
                    <?= $this->Form->control('code', [
                        'label'    => false,
                        'class'    => 'form-control',
                        'readonly' => true,
                    ]) ?>
                    <small class="text-muted">Kode pasien otomatis, tidak bisa diubah.</small>
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <?= $this->Form->control('full_name', [
                        'label'       => false,
                        'class'       => 'form-control',
                        'placeholder' => 'Nama lengkap pasien',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Jenis Identitas</label>
                    <?= $this->Form->control('identity_type', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['KTP' => 'KTP', 'SIM' => 'SIM', 'Paspor' => 'Paspor',
                                      'KIA' => 'KIA', 'BPJS' => 'BPJS'],
                        'empty'   => '-- Pilih Jenis --',
                        'class'   => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Nomor Identitas</label>
                    <?= $this->Form->control('identity_number', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Gender <span class="text-danger">*</span></label>
                    <?= $this->Form->control('gender', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['Male' => '♂ Laki-laki', 'Female' => '♀ Perempuan'],
                        'empty'   => '-- Pilih Gender --',
                        'class'   => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Golongan Darah</label>
                    <?= $this->Form->control('blood_type', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'],
                        'empty'   => '-- Pilih --',
                        'class'   => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <?= $this->Form->control('birth_date', [
                        'type'  => 'date',
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>No. Telepon</label>
                    <?= $this->Form->control('phone_number', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Status Active</label>
                    <?= $this->Form->control('is_active', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => ['Y' => 'Active', 'N' => 'Non Active'],
                        'class'   => 'form-control',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <!-- ── SECTION 2: Data Sosial ─────────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-users"></i> Data Sosial
        </h5>
        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label>Agama</label>
                    <?= $this->Form->control('religion', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'Islam'    => 'Islam',   'Kristen' => 'Kristen',
                            'Katolik'  => 'Katolik', 'Hindu'   => 'Hindu',
                            'Buddha'   => 'Buddha',  'Konghucu'=> 'Konghucu',
                            'Lainnya'  => 'Lainnya',
                        ],
                        'empty' => '-- Pilih --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Pendidikan</label>
                    <?= $this->Form->control('education', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'SD' => 'SD', 'SMP' => 'SMP', 'SMA/SMK' => 'SMA/SMK',
                            'D3' => 'D3', 'S1' => 'S1', 'S2' => 'S2',
                            'S3' => 'S3', 'Lainnya' => 'Lainnya',
                        ],
                        'empty' => '-- Pilih --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Status Pernikahan</label>
                    <?= $this->Form->control('marital_status', [
                        'type'    => 'select',
                        'label'   => false,
                        'options' => [
                            'Belum Menikah' => 'Belum Menikah',
                            'Menikah'       => 'Menikah',
                            'Cerai Hidup'   => 'Cerai Hidup',
                            'Cerai Mati'    => 'Cerai Mati',
                        ],
                        'empty' => '-- Pilih --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <?= $this->Form->control('occupation', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Kewarganegaraan</label>
                    <?= $this->Form->control('nationality', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Citizenship</label>
                    <?= $this->Form->control('citizenship', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Suku</label>
                    <?= $this->Form->control('ethnic_group', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <!-- ── SECTION 3: Data Keluarga ───────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-user-friends"></i> Data Keluarga
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <?= $this->Form->control('mother_name', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <?= $this->Form->control('father_name', [
                        'label' => false,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>
        </div>

        <hr>

        <!-- ── SECTION 4: Alamat ──────────────────────────────── -->
        <h5 style="color:#2c3e50; font-weight:700; margin-bottom:14px; padding-bottom:6px;
                   border-bottom:2px solid #e9ecef;">
            <i class="fa fa-map-marker-alt"></i> Alamat
        </h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <?= $this->Form->control('address', [
                        'type'  => 'textarea',
                        'label' => false,
                        'class' => 'form-control',
                        'rows'  => 2,
                    ]) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Kelurahan</label>
                    <?= $this->Form->control('subdistrict', ['label' => false, 'class' => 'form-control']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Kecamatan</label>
                    <?= $this->Form->control('district', ['label' => false, 'class' => 'form-control']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Kota / Kabupaten</label>
                    <?= $this->Form->control('city', ['label' => false, 'class' => 'form-control']) ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Provinsi</label>
                    <?= $this->Form->control('province', ['label' => false, 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <hr>

        <div class="text-right">
            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                ['class' => 'btn btn-default', 'escape' => false]
            ) ?>
            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan Perubahan',
                ['class' => 'btn btn-success', 'escapeTitle' => false]
            ) ?>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>