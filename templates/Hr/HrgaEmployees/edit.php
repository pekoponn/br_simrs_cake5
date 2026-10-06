<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployee $hrgaEmployee
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
$dataChild = $this->Html->link('Daftar Pegawai', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Form->create($hrgaEmployee, ['type' => 'file']) ?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">
    <?php echo $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>

    <ul class="nav nav-tabs nav-tabs-inverse">
        <li class="nav-item">
            <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                <span class="d-sm-none">Data Pribadi</span>
                <span class="d-sm-block d-none">Data Pribadi</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                <span class="d-sm-none">Fasilitas</span>
                <span class="d-sm-block d-none">Fasilitas</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                <span class="d-sm-none">Data Pendidikan</span>
                <span class="d-sm-block d-none">Data Pendidikan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                <span class="d-sm-none">Data Keluarga</span>
                <span class="d-sm-block d-none">Data Keluarga</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#default-tab-5" data-toggle="tab" class="nav-link">
                <span class="d-sm-none">Dokumen</span>
                <span class="d-sm-block d-none">Dokumen</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">

        <!-- tab Data Pribadi Karyawan -->
        <div class="tab-pane fade active show" id="default-tab-1">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('user_id', ['label' => 'Akun User', 'class' => 'form-control slc', 'placeholder' => 'Cari Nama', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('name', ['label' => 'Nama Lengkap', 'class' => 'form-control', 'placeholder' => 'Nama lengkap pegawai ...', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('gender', ['label' => 'Jenis Kelamin', 'class' => 'form-control slc', 'options' => ['Male' => 'Laki-laki', 'Female' => 'Perempuan'], 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('religion', ['label' => 'Agama', 'class' => 'form-control', 'placeholder' => 'Agama...', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('status_tanggungan', ['label' => 'Status Tanggungan', 'class' => 'form-control slc', 'options' => $this->Krs->statusTanggungan(), 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('place_of_birth', ['label' => 'Tempat Lahir', 'class' => 'form-control slc', 'placeholder' => 'Masukan Tempat Lahir ...', 'autocomplete' => 'off', 'options' => $kabupaten]); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?php echo $this->Form->control("date_of_births", ['label' => 'Tanggal Lahir', 'placeholder' => 'Tanggal Lahir', 'type' => 'text', 'class' => 'form-control tgl', 'autocomplete' => 'off', 'readonly', 'value' => date_format($hrgaEmployee->date_of_birth, 'd-m-Y')]); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('address', ['label' => 'Alamat', 'class' => 'form-control', 'placeholder' => 'Masukan Alamat', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('no_ktp', ['label' => 'KTP', 'class' => 'form-control nk', 'placeholder' => 'Masukan Nomor KTP ...', 'type' => 'text']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('no_kk', ['label' => 'Kartu Keluarga (KK)', 'class' => 'form-control nk', 'placeholder' => 'Masukan Nomor KK ...', 'type' => 'text']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('address_ktp', ['label' => 'Alamat KK', 'class' => 'form-control', 'placeholder' => 'Masukan Alamat', 'autocomplete' => 'off']); ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('nip', ['label' => 'NIP (Nomor Induk Pegawai)', 'class' => 'form-control', 'placeholder' => 'Masukan NIP...', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('pin', ['label' => 'PIN', 'class' => 'form-control', 'placeholder' => 'Masukan PIN yang ada di fingerprint...', 'autocomplete' => 'off']); ?>
                </div>
                <!-- <div class="col-md-4 mb-3">
                    <?= $this->Form->control('rfid', ['label' => 'RFID', 'class' => 'form-control', 'placeholder' => 'Masukan Kode RFID yang ada di fingerprint...', 'autocomplete' => 'off']); ?>
                </div> -->
                <!-- <div class="col-md-4 mb-3">
                    <?= $this->Form->control('branch', ['label' => 'Cabang', 'class' => 'form-control slc', 'placeholder' => 'Cari cabang', 'autocomplete' => 'off', 'empty' => 'Pilih salah satu', 'options' => $this->Krs->dataWarehouse()]); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('business_unit', ['label' => 'Unit Bisnis', 'class' => 'form-control slc', 'options' => $this->Krs->businessUnit(), 'empty' => 'Pilih salah satu...']); ?>
                </div> -->
                <div class="col-md-4 mb-3">
                    <?php echo $this->Form->control("work_dates", ['label' => 'Tanggal Masuk', 'placeholder' => 'Tanggal masuk kerja', 'type' => 'text', 'class' => 'form-control tgl', 'autocomplete' => 'off', 'readonly', 'value' => date_format($hrgaEmployee->work_date, 'd-m-Y')]); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?php echo $this->Form->control("status", ['label' => 'Status Karyawan', 'placeholder' => 'Status karyawan...', 'class' => 'form-control slc', 'autocomplete' => 'off', 'empty' => 'Pilih salah satu...', 'options' => $this->Krs->employeeStatus()]); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="">Tanggal Kontrak</label>
                    <div class="input-group input-daterange">
                        <?php echo $this->Form->text("contract_start_dates", ['label' => false, 'placeholder' => 'Tanggal mulai kontrak...', 'type' => 'text', 'class' => 'form-control form-control-inline tanggal', 'autocomplete' => 'off', 'readonly', 'value' => $hrgaEmployee->contract_start_date == null ? '' : $this->Krs->fDate($hrgaEmployee->contract_start_date, 'd-m-Y')]); ?>
                        <div class="input-group-prepend"><span class="input-group-text">s/d</span></div>
                        <?php echo $this->Form->text("contract_end_dates", ['label' => false, 'placeholder' => 'Tanggal berakhir kontrak...', 'type' => 'text', 'class' => 'form-control form-control-inline tanggal', 'autocomplete' => 'off', 'readonly', 'value' => $hrgaEmployee->contract_end_date == null ? '' : $this->Krs->fDate($hrgaEmployee->contract_end_date, 'd-m-Y')]); ?>
                        <div class="input-group-append"><?= $this->Form->button('<i class="fa fa-times"></i>', ['class' => 'btn btn-inverse resetDate', 'escape' => true, 'type' => 'button',  'fullBase' => true, 'escapeTitle' => false]); ?></div>
                    </div>
                    <!-- <div class="input-group input-daterange">
                        <?php echo $this->Form->text("contract_start_dates", ['label' => false, 'placeholder' => 'Tanggal mulai kontrak...', 'type' => 'text', 'class' => 'form-control form-control-inline tanggal', 'autocomplete' => 'off', 'readonly', 'value' => $hrgaEmployee->contract_start_date == null ? '' : $this->Krs->fDate($hrgaEmployee->contract_start_date, 'd-m-Y')]); ?>
                        <?php echo $this->Form->text("contract_end_dates", ['label' => false, 'placeholder' => 'Tanggal berakhir kontrak...', 'type' => 'text', 'class' => 'form-control form-control-inline tanggal', 'autocomplete' => 'off', 'readonly', 'value' => $hrgaEmployee->contract_end_date == null ? '' : $this->Krs->fDate($hrgaEmployee->contract_end_date, 'd-m-Y')]); ?>
                        <button type="button" class="btn btn-danger resetDate" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div> -->
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control email', 'placeholder' => 'Masukan Email...', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('telp', ['label' => 'Telepon', 'class' => 'form-control telp', 'placeholder' => 'Masukan Nomor Telepon', 'autocomplete' => 'off', 'type' => 'text', 'value' => $hrgaEmployee->telp]); ?>
                </div>
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('devisi', ['label' => 'Devisi', 'class' => 'form-control slc', 'options' => $this->Krs->subDivision(), 'autocomplete' => 'off']); ?>
                </div>
                <!-- <div class="col-md-4 mb-3">
                    <?= $this->Form->control('sub_devisi', ['label' => 'Sub Divisi', 'class' => 'form-control slc', 'options' => $this->Krs->subDevision(), 'autocomplete' => 'off', 'empty' => 'Pilih salah satu...']); ?>
                </div> -->
                <div class="col-md-4 mb-3">
                    <?= $this->Form->control('position', ['label' => 'Posisi / Jabatan', 'class' => 'form-control slc', 'options' => $this->Krs->position(), 'autocomplete' => 'off']); ?>
                </div>
            </div>
        </div>

        <!-- tab Data Fasilitas  -->
        <div class="tab-pane fade" id="default-tab-2">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->control('bank_name', ['label' => 'Nama Bank', 'class' => 'form-control', 'placeholder' => 'Masukan Nama Bank...', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('rek_name', ['label' => 'an. Rekening', 'class' => 'form-control', 'placeholder' => 'Masukan Nama Rek. Bank...', 'autocomplete' => 'off']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('rek_no', ['label' => 'No. Rekening', 'class' => 'form-control', 'placeholder' => 'Masukan Nomor Rekening..', 'autocomplete' => 'off', 'type' => 'number']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('npwp', ['label' => 'NPWP', 'class' => 'form-control npwp', 'placeholder' => 'NPWP', 'autocomplete' => 'off']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->control('jml_cuti', ['label' => 'Jumlah Cuti ', 'class' => 'form-control', 'placeholder' => 'Masukan Jumlah Cuti...', 'autocomplete' => 'off', 'type' => 'text']); ?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->control('bpjs_kesehatan', ['label' => 'Nomor BPJS ', 'class' => 'form-control bpjs', 'placeholder' => 'Masukan Nomor BPJS Kesehatan...', 'autocomplete' => 'off', 'type' => 'text']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('bpjs_kesehatan_dates', ['label' => 'Tanggal BPJS ', 'type' => 'text', 'class' => 'form-control tgl', 'placeholder' => 'Tanggal BPJS', 'autocomplete' => 'off', 'readonly', 'value' => date_format($hrgaEmployee->bpjs_kesehatan_date, 'd-m-Y')]); ?>
                </div>
                <div class="col-md-3">
                    <p></p>
                    <br>
                    <div class="form-check form-check-inline">
                        <?php
                        echo $this->Form->checkbox('bpjs_kesehatan_status', ['value' => 'Y', 'hiddenField' => true, 'checked' => $hrgaEmployee->bpjs_kesehatan_status == 'Y' ? 'checked' : '', 'class' => 'form-check-input']);
                        ?>
                        <label class="form-check-label">Status BPJS Kesehatan</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->control('bpjs_ketenagakerjaan', ['label' => 'No BPJS Ketenagakerjaan ', 'class' => 'form-control bpjs', 'placeholder' => 'Masukan Nomor BPJS Kesehatan...', 'autocomplete' => 'off', 'type' => 'text']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('bpjs_ketenagakerjaan_dates', ['label' => 'Tanggal BPJS Ketenagakerjaan ', 'type' => 'text', 'class' => 'form-control tgl', 'placeholder' => 'Tanggal BPJS Ketenagakerjaan', 'autocomplete' => 'off', 'readonly', 'value' => date_format($hrgaEmployee->bpjs_ketenagakerjaan_date, 'd-m-Y')]); ?>
                </div>
                <div class="col-md-3">
                    <p></p>
                    <br>
                    <div class="form-check form-check-inline">
                        <?php
                        echo $this->Form->checkbox('bpjs_ketenagakerjaan_status', ['value' => 'Y', 'hiddenField' => true, 'checked' => $hrgaEmployee->bpjs_ketenagakerjaan_status == 'Y' ? 'checked' : '', 'class' => 'form-check-input']);
                        ?>
                        <label class="form-check-label">Status BPJS Ketenagakerjaan</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- tab Data Pendidikan karyawan -->
        <div class="tab-pane fade" id="default-tab-3">
            <div class="row">
                <div class="col-md-3">
                    <?= $this->Form->control('pendidikan', ['label' => 'Sekolah/Universitas', 'class' => 'form-control', 'placeholder' => 'Nama sekolah/universitas']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('jurusan', ['label' => 'Jurusan', 'class' => 'form-control', 'placeholder' => 'Jurusan ...', 'autocomplete' => 'off']) ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('graduation_year', ['label' => 'Tahun Kelulusan', 'class' => 'form-control years', 'placeholder' => 'Tahun kelulusan ...', 'autocomplete' => 'off', 'readonly', 'value' => $hrgaEmployee->graduation_year == null ? date('Y') : $hrgaEmployee->graduation_year]) ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->control('title', ['label' => 'Gelar', 'class' => 'form-control', 'placeholder' => 'Gelar...', 'autocomplete' => 'off']) ?>
                </div>
            </div>
            <hr>
            <h6>RIWAYAT PELATIHAN/KURSUS</h6>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover trainings">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th width="5%">#</th>
                            <th width="20%">Keterampilan/Kursus</th>
                            <th width="15%">Tgl. Mulai</th>
                            <th width="15%">Tgl. Selesai</th>
                            <th width="15%">grade</th>
                            <th width="25%">Penyelenggara</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $number = 1;
                        if (count($hrgaEmployee->hrga_employee_trainings) != 0) {
                            foreach ($hrgaEmployee->hrga_employee_trainings as $key => $value) { ?>
                                <tr>
                                    <td class="text-center"><?= $number ?><?= $this->Form->text('hrga_employee_trainings[' . $key . '][id]', ['type' => 'hidden', 'value' => $value->id]); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_trainings[' . $key . '][skill]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama pelatihan/keterampilan', 'value' => $value->skill]); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_trainings[' . $key . '][start_date]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal mulai pelatihan...', 'readonly', 'value' => $value->start_date == null ? '' : $this->Krs->fDate($value->start_date, 'd-m-Y')]); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_trainings[' . $key . '][end_date]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal berakhir pelatihan...', 'readonly', 'value' => $value->end_date == null ? '' : $this->Krs->fDate($value->end_date, 'd-m-Y')]); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_trainings[' . $key . '][grade]', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->level(), 'empty' => 'Pilih salah satu...', 'value' => $value->grade]); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_trainings[' . $key . '][organizer]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama penyelenggara...', 'value' => $value->organizer]); ?></td>
                                    <td class="text-center"><?php echo $key > 0 ? $this->Form->button('<i class="fa fa-times"></i>', ['class' => 'btn btn-danger btn-sm', 'escape' => true, 'type' => 'button',  'disabled', 'fullBase' => true, 'escapeTitle' => false]) : $this->Form->button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-inverse btn-sm', 'escape' => true, 'type' => 'button',  'id' => "insertTraining",  'fullBase' => true, 'escapeTitle' => false]); ?></td>
                                </tr>
                            <?php
                                $number++;
                            }
                        } else { ?>
                            <tr>
                                <td class="text-center">1<?= $this->Form->text('hrga_employee_trainings[0][id]', ['type' => 'hidden', 'value' => ""]); ?></td>
                                <td><?= $this->Form->control('hrga_employee_trainings[0][skill]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama pelatihan/keterampilan']); ?></td>
                                <td><?= $this->Form->control('hrga_employee_trainings[0][start_date]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal mulai pelatihan...', 'readonly']); ?></td>
                                <td><?= $this->Form->control('hrga_employee_trainings[0][end_date]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal berakhir pelatihan...', 'readonly']); ?></td>
                                <td><?= $this->Form->control('hrga_employee_trainings[0][grade]', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->level(), 'empty' => 'Pilih salah satu...']); ?></td>
                                <td><?= $this->Form->control('hrga_employee_trainings[0][organizer]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama penyelenggara...']); ?></td>
                                <td class="text-center"><?= $this->Form->button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-inverse btn-sm', 'escape' => true, 'type' => 'button',  'id' => "insertTraining",  'fullBase' => true, 'escapeTitle' => false]); ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- tab data kelurga karyawan -->
        <div class="tab-pane fade" id="default-tab-4">
            <div class="panel-body">
                <h6 class="text-inverse">Data Keluarga</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover cntrol1">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%" class="text-center" style="vertical-align: middle" rowspan="2" scope="col">#</th>
                                <th width="15%" class="text-center">Nama</th>
                                <!-- <th width="15%" class="text-center">No. KTP</th> -->
                                <th width="10%" class="text-center">Tempat Lahir</th>
                                <th width="12%" class="text-center">Tgl. Lahir</th>
                                <th width="6%" class="text-center">Status</th>
                                <th width="20%" class="text-center">Alamat</th>
                                <th width="10%" class="text-center">Telepon</th>
                                <th width="8%" class="text-center">Pekerjaan</th>
                                <th width="9%" class="text-center">Ukuran Baju</th>
                                <th width="5%" class="text-center" style="vertical-align: middle" rowspan="2"></th>
                            </tr>
                            <tr class="text-center">
                                <th width="20%">No. KTP</th>
                                <th width="25%" colspan="2">Nomor BPJS</th>
                                <th width="10%">Status BPJS</th>
                                <th width="5%">Tanggal Aktif</th>
                                <th width="40%" colspan="3">Riwayat Sakit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (count($hrgaEmployee->hrga_employee_lines) != 0) {
                                foreach ($hrgaEmployee->hrga_employee_lines as $index => $value) { ?>
                                    <tr>
                                        <td rowspan="2" class="text-center"><?= $no; ?><input type="hidden" name="hrga_employee_lines[<?= $index ?>][id]" value="<?= $value->id ?>"></td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][name]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama anggota keluarga', 'value' => $value->name]); ?></td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][place_of_birth]', ['label' => false, 'class' => 'form-control slc', 'placeholder' => 'Tempat lahir...', 'options' => $kabupaten, 'value' => $value->place_of_birth]); ?></td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][birthday]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal lahir...', 'readonly', 'value' => $value->birthday == null ? '' : date_format($value->birthday, 'd-m-Y')]); ?></td>
                                        <td>
                                            <?= $this->Form->control('hrga_employee_lines[' . $index . '][status_family]', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->family(), 'value' => $value->status_family]); ?>
                                        </td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][address]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat...', 'value' => $value->address]); ?></td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][telp]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. telepon', 'value' => $value->telp]); ?></td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][pekerjaan]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Pekerjaan', 'value' => $value->pekerjaan]); ?></td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][clothes_size]', ['label' => false, 'class' => 'form-control slc', 'placeholder' => 'Ukuran baju',  'options' => $this->Krs->sized(), 'value' => $value->clothes_size]); ?></td>
                                        <td class="text-center" style="vertical-align: middle" rowspan="2"><?php echo $index > 0 ? $this->Form->button('<i class="fa fa-times"></i>', ['class' => 'btn btn-danger btn-sm', 'escape' => true, 'disabled', 'type' => 'button', 'fullBase' => true, 'escapeTitle' => false]) : $this->Form->button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-inverse btn-sm', 'escape' => true, 'id' => "insertRow", 'type' => 'button', 'fullBase' => true, 'escapeTitle' => false]); ?></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][no_ktp]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. KTP', 'value' => $value->no_ktp]); ?></td>
                                        <td colspan="2"><?= $this->Form->control('hrga_employee_lines[' . $index . '][bpjs_kesehatan]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'No. BPJS Kesehatan', 'value' => $value->bpjs_kesehatan]); ?></td>
                                        <td>
                                            <?= $this->Form->control('hrga_employee_lines[' . $index . '][bpjs_kesehatan_status]', ['label' => false, 'class' => 'form-control slc', 'options' => ['Y' => 'Aktif', 'N' => 'Non-Aktif', 'value' => $value->bpjs_kesehatan_status]]); ?>
                                        </td>
                                        <td><?= $this->Form->control('hrga_employee_lines[' . $index . '][bpjs_kesehatan_dates]', ['label' => false, 'class' => 'form-control tgl', 'readonly',  'placeholder' => 'Aktif sampai tanggal', 'value' => $value->bpjs_kesehatan_date == null ? '' : date_format($value->bpjs_kesehatan_date, 'd-m-Y')]); ?></td>
                                        <td colspan="3"><?= $this->Form->control('hrga_employee_lines[' . $index . '][riwayat_sakit]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Riwayat penyakit...', 'value' => $value->riwayat_sakit]); ?></td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                            } else { ?>
                                <tr>
                                    <td rowspan="2" class="text-center"><strong>1</strong><?= $this->Form->text('hrga_employee_lines[0][id]', ['type' => 'hidden', 'value' => ""]); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][name]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama...']); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][place_of_birth]', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Tempat lahir...', 'options' => $kabupaten, 'empty' => 'Choose one...']); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][birthday]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Tanggal lahir...', 'readonly']); ?></td>
                                    <td>
                                        <?= $this->Form->control('hrga_employee_lines[0][status_family]', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->family(), 'empty' => 'Choose one...']); ?>
                                    </td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][address]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Alamat...']); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][telp]', ['label' => false, 'class' => 'form-control telp', 'placeholder' => 'No. telepon']); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][pekerjaan]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Pekerjaan...']); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][clothes_size]', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Baju', 'options' => $this->Krs->sized(), 'empty' => 'Choose one...']); ?></td>
                                    <td class="text-center" style="vertical-align: middle" rowspan="2"><?= $this->Form->button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-inverse btn-sm', 'escape' => true, 'id' => "insertRow", 'type' => 'button', 'fullBase' => true, 'escapeTitle' => false]); ?></td>
                                </tr>
                                <tr class="table-info">
                                    <td><?= $this->Form->control('hrga_employee_lines[0][no_ktp]', ['label' => false, 'class' => 'form-control nk', 'placeholder' => 'No. KTP']); ?></td>
                                    <td colspan="2"><?= $this->Form->control('hrga_employee_lines[0][bpjs_kesehatan]', ['label' => false, 'class' => 'form-control bpjs', 'placeholder' => 'No. BPJS Kesehatan']); ?></td>
                                    <td> <?= $this->Form->control('hrga_employee_lines[0][bpjs_kesehatan_status]', ['label' => false, 'class' => 'form-control slc', 'options' => $this->Krs->status(), 'data-placeholder' => 'Status BPJS', 'empty' => 'Choose one...']); ?></td>
                                    <td><?= $this->Form->control('hrga_employee_lines[0][bpjs_kesehatan_dates]', ['label' => false, 'class' => 'form-control tgl', 'placeholder' => 'Aktif sampai tanggal', 'readonly']); ?></td>
                                    <td colspan="3"><?= $this->Form->control('hrga_employee_lines[0][riwayat_sakit]', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Riwayat penyakit...']); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- tab Data Dokumen -->
        <div class="tab-pane fade" id="default-tab-5">
            <div class="row">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("photo_path", ['label' => 'Foto Pegawai', 'type' => 'file', 'class' => 'photo_path', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_surat_lamaran", ['label' => 'Berkas Lamaran', 'type' => 'file', 'class' => 'berkas_surat_lamaran', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_cv", ['label' => 'Berkas CV', 'type' => 'file', 'class' => 'berkas_cv', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_ktp", ['label' => 'Berkas KTP', 'type' => 'file', 'class' => 'berkas_ktp', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_ijasah", ['label' => 'Berkas Ijazah', 'type' => 'file', 'class' => 'berkas_ijasah', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kk", ['label' => 'Berkas KK', 'type' => 'file', 'class' => 'berkas_kk', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_skck", ['label' => 'Berkas SKCK', 'type' => 'file', 'class' => 'berkas_skck', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_surat_dokter", ['label' => 'Berkas Surat Dokter', 'type' => 'file', 'class' => 'berkas_surat_dokter', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kartu_vaksin_1", ['label' => 'Berkas Vaksin 1', 'type' => 'file', 'class' => 'berkas_kartu_vaksin_1', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kartu_vaksin_2", ['label' => 'Berkas Vaksin 2', 'type' => 'file', 'class' => 'berkas_kartu_vaksin_2', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kartu_vaksin_3", ['label' => 'Berkas Vaksin 3', 'type' => 'file', 'class' => 'berkas_kartu_vaksin_3', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kartu_vaksin_4", ['label' => 'Berkas Vaksin 4', 'type' => 'file', 'class' => 'berkas_kartu_vaksin_4', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kontrak_1", ['label' => 'Berkas Kontrak 1', 'type' => 'file', 'class' => 'berkas_kontrak_1', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kontrak_2", ['label' => 'Berkas Kontrak 2', 'type' => 'file', 'class' => 'berkas_kontrak_2', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $this->Form->control("berkas_kartu_vaksin_4", ['label' => 'Berkas Vaksin 4', 'type' => 'file', 'class' => 'berkas_kartu_vaksin_4', 'data-preview-file-type' => 'text']); ?>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="tab-pane fade" id="default-tab-6">
            <div class="row">
                <div class="card-body">
                    <table class="table table-bordered table-hover penggajian">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th width="50">No. </th>
                                <th>Uraian</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><strong>1</strong></td>
                                <td><strong>Gaji Pokok</strong></td>
                                <td><?= $this->Form->control('acc_salaries.gaji_pokok', ['label' => false, 'class' => 'form-control text-right nominal gapok', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->gaji_pokok) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>2</strong></td>
                                <td><strong>Tunjangan Operasional</strong></td>
                                <td><?= $this->Form->control('acc_salaries.tunjangan_operasional', ['label' => false, 'class' => 'form-control text-right nominal tunjOp', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->tunjangan_operasional) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>3</strong></td>
                                <td><strong>Tunjangan Fungsi Group</strong></td>
                                <td><?= $this->Form->control('acc_salaries.tunjangan_fungsi_group', ['label' => false, 'class' => 'form-control text-right nominal tunjFG', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->tunjangan_fungsi_group) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>4</strong></td>
                                <td><strong>Tunjangan Lain</strong></td>
                                <td><?= $this->Form->control('acc_salaries.tunjangan_lain', ['label' => false, 'class' => 'form-control text-right nominal tunjLain', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->tunjangan_lain) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>5</strong></td>
                                <td><strong>Tunjangan Hadir</strong></td>
                                <td><?= $this->Form->control('acc_salaries.tunjangan_hadir', ['label' => false, 'class' => 'form-control text-right nominal tunjHadir', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->tunjangan_hadir) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>6</strong></td>
                                <td><strong>Tunjangan Jabatan</strong></td>
                                <td><?= $this->Form->control('acc_salaries.tunjangan_jabatan', ['label' => false, 'class' => 'form-control text-right nominal tunjJabatan', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->tunjangan_jabatan) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>7</strong></td>
                                <td><strong>Tunjangan Penanggung Jawab</strong></td>
                                <td><?= $this->Form->control('acc_salaries.tunjangan_penanggung_jawab', ['label' => false, 'class' => 'form-control text-right nominal tunjPJ', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->tunjangan_penanggung_jawab) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>8</strong></td>
                                <td><strong>Jasa Pelayanan</strong></td>
                                <td><?= $this->Form->control('acc_salaries.jasa_pelayanan', ['label' => false, 'class' => 'form-control text-right nominal tunjJasa', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->jasa_pelayanan) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>9</strong></td>
                                <td><strong>Insentif</strong></td>
                                <td><?= $this->Form->control('acc_salaries.insentif', ['label' => false, 'class' => 'form-control text-right nominal insentif', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->insentif) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>10</strong></td>
                                <td><strong>Insentif Hadir</strong></td>
                                <td><?= $this->Form->control('acc_salaries.insentif_hadir', ['label' => false, 'class' => 'form-control text-right nominal insentifHadir', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->insentif_hadir) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>11</strong></td>
                                <td><strong>Hadir Harian</strong></td>
                                <td><?= $this->Form->control('acc_salaries.hadir_harian', ['label' => false, 'class' => 'form-control text-right nominal hadirHarian', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->hadir_harian) : '']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><strong>12</strong></td>
                                <td><strong>Lembur Harian</strong></td>
                                <td><?= $this->Form->control('acc_salaries.lembur_harian', ['label' => false, 'class' => 'form-control text-right nominal lembur', 'placeholder' => '0', 'value' => !empty($hrgaEmployee->acc_salary) ? $this->Krs->_currency($hrgaEmployee->acc_salary->lembur_harian) : '']); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-danger">
                                <td class="text-center" colspan="2"><strong>TOTAL PENDAPATAN</strong></td>
                                <td class="text-right"><strong><span class="salaries"></span></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div> -->
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'edit', $hrgaEmployee->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
        datePickerReset('input-daterange', 'resetDate', 'tanggal', 'dd-mm-yyyy');

        $(".nk").mask("9999999999999999");

        $(".npwp").mask("99.999.999.9-999.999");

        $(".bpjs").mask("9999999999999");

        $(".telp").mask("999999999999", {autoclear: false});

        $('.tgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });


        $('.years').datepicker({
            format: "yyyy",
            weekStart: 1,
            autoclose: true,
            orientation: 'bottom',
            language: "{{ app.request.locale }}",
            keyboardNavigation: false,
            viewMode: "years",
            minViewMode: "years"
        });

        $('.slc').select2({
            placeholder: 'Pilih salah satu...',
        });


        function ca() {
            $(".penggajian>tbody").each(function() {
                var gapok = $(this).find(".gapok");
                var tunjOp = $(this).find(".tunjOp");
                var tunjFG = $(this).find(".tunjFG");
                var tunjLain = $(this).find(".tunjLain");
                var tunjHadir = $(this).find(".tunjHadir");
                var tunjJabatan = $(this).find(".tunjJabatan");
                var tunjPJ = $(this).find(".tunjPJ");
                var tunjJasa = $(this).find(".tunjJasa");
                var insentif = $(this).find(".insentif");
                var insentifHadir = $(this).find(".insentifHadir");
                var hadirHarian = $(this).find(".hadirHarian");
                var lembur = $(this).find(".lembur");

                gapok = parseFloat(gapok.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                tunjOp = parseFloat(tunjOp.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                tunjFG = parseFloat(tunjFG.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                tunjLain = parseFloat(tunjLain.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                tunjHadir = parseFloat(tunjHadir.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                tunjJabatan = parseFloat(tunjJabatan.val().replace(/[^0-9\,]+/g, "").replace(",", "."));

                tunjPJ = parseFloat(tunjPJ.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                tunjJasa = parseFloat(tunjJasa.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                insentif = parseFloat(insentif.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                insentifHadir = parseFloat(insentifHadir.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                hadirHarian = parseFloat(hadirHarian.val().replace(/[^0-9\,]+/g, "").replace(",", "."));
                lembur = parseFloat(lembur.val().replace(/[^0-9\,]+/g, "").replace(",", "."));


                if (isNaN(gapok)) {
                    gapok = 0;
                }

                if (isNaN(tunjOp)) {
                    tunjOp = 0;
                }

                if (isNaN(tunjFG)) {
                    tunjFG = 0;
                }

                if (isNaN(tunjLain)) {
                    tunjLain = 0;
                }

                if (isNaN(tunjHadir)) {
                    tunjHadir = 0;
                }

                if (isNaN(tunjJabatan)) {
                    tunjJabatan = 0;
                }

                if (isNaN(tunjPJ)) {
                    tunjPJ = 0;
                }

                if (isNaN(tunjJasa)) {
                    tunjJasa = 0;
                }

                if (isNaN(insentif)) {
                    insentif = 0;
                }

                if (isNaN(insentifHadir)) {
                    insentifHadir = 0;
                }

                if (isNaN(hadirHarian)) {
                    hadirHarian = 0;
                }

                if (isNaN(lembur)) {
                    lembur = 0;
                }

                var total = gapok + tunjOp + tunjFG + tunjLain + tunjJabatan + tunjHadir + tunjJasa + tunjPJ + insentif + insentifHadir + hadirHarian + lembur;
                var totals = parseFloat(total).toFixed(2);
                var rus = totals.replace(/\./g, ',');
                $('.salaries').number(rus, 2, ",", ".");
            });
        }

        $(function() {
            ca();
            $('input.gapok').bind('change keyup', function() {
                ca();
            });
            $('input.tunjOp').bind('change keyup', function() {
                ca();
            });
            $('input.tunjFG').bind('change keyup', function() {
                ca();
            });
            $('input.tunjLain').bind('change keyup', function() {
                ca();
            });
            $('input.tunjJabatan').bind('change keyup', function() {
                ca();
            });
            $('input.tunjHadir').bind('change keyup', function() {
                ca();
            });
            $('input.tunjJasa').bind('change keyup', function() {
                ca();
            });
            $('input.tunjPJ').bind('change keyup', function() {
                ca();
            });
            $('input.insentif').bind('change keyup', function() {
                ca();
            });
            $('input.insentifHarian').bind('change keyup', function() {
                ca();
            });
            $('input.hadirHarian').bind('change keyup', function() {
                ca();
            });
            $('input.lembur').bind('change keyup', function() {
                ca();
            });
        });


        $(".photo_path").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->photo_path, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->photo_path ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->photo_path ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->photo_path ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php   } ?>
        });


        $(".berkas_surat_lamaran").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_surat_lamaran, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_surat_lamaran ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_surat_lamaran ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_surat_lamaran ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php
                                } ?>
        });


        $(".berkas_cv").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_cv, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_cv ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_cv ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_cv ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_ktp").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_ktp, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_ktp ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_ktp ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_ktp ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_ijasah").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_ijasah, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_ijasah ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_ijasah ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_ijasah ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_kk").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kk, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kk ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kk ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kk ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_skck").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_skck, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_skck ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_skck ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_skck ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_surat_dokter").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_surat_dokter, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_surat_dokter ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_surat_dokter ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_surat_dokter ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_kartu_vaksin_1").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kartu_vaksin_1, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kartu_vaksin_1 ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_1 ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_1 ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php  } ?>
        });


        $(".berkas_kartu_vaksin_2").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kartu_vaksin_2, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kartu_vaksin_2 ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_2 ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_2 ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php   } ?>
        });


        $(".berkas_kartu_vaksin_3").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kartu_vaksin_3, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kartu_vaksin_3 ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_3 ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_3 ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php   } ?>
        });


        $(".berkas_kartu_vaksin_4").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kartu_vaksin_4, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kartu_vaksin_4 ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_4 ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kartu_vaksin_4 ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php   } ?>
        });

        $(".berkas_kontrak_1").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kontrak_1, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kontrak_1 ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kontrak_1 ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kontrak_1 ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php   } ?>
        });

        $(".berkas_kontrak_2").fileinput({
            'showUpload': false,
            'initialPreview': <?php
                                $ext = pathinfo($hrgaEmployee->berkas_kontrak_2, PATHINFO_EXTENSION);
                                if ($ext == 'pdf') { ?> '<object class="kv-preview-data file-preview-pdf" title="<?= $hrgaEmployee->berkas_kontrak_2 ?>" data="<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kontrak_2 ?>" type="application/pdf" style="width: 100%; height: 160px; position: relative;"><div class="file-preview-other"><span class="file-other-icon"><i class="bi-file-earmark-fill"></i></span></div></object>'
        <?php
                                } else if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg') { ?> "<img src='<?php echo $this->request->getAttribute('webroot') ?>upload/employees/<?= $hrgaEmployee->berkas_kontrak_2 ?>' class='file-preview-image'>"
        <?php
                                } else { ?>
            false
        <?php   } ?>
        });


        // data keluarga karyawan
        var counter = $('.cntrol1 tr').length - 2;
        $("#insertRow").on("click", function(event) {
            event.preventDefault();

            var col1 = '';

            // atas
            col1 += '<tr class="text-center" id=' + counter + '>';
            col1 += '<td rowspan="2" scrope="row" class="text-center"><strong>' + counter + '</strong></td>';
            col1 += '<td><input type="text" autocomplete="off" class="form-control" placeholder="Nama..." name="hrga_employee_lines[' + counter + '][name]"></td>';
            col1 += '<td><select class="form-control slc" name="hrga_employee_lines[' + counter + '][place_of_birth]" data-placeholer="Tempat lahir..." required><option value=""></option><?php foreach ($kabupaten as $key => $data) { ?><option value="<?= $key ?>"><?= $data ?></option><?php } ?></select></td>';
            col1 += '<td><input type="text" autocomplete="off" class="form-control tgl" placeholder="Tanggal lahir..." name="hrga_employee_lines[' + counter + '][birthday]" readonly></td>';
            col1 += '<td><select class="form-control slc" name="hrga_employee_lines[' + counter + '][status_family]" required><option value=""></option><?php foreach ($this->Krs->family() as $key => $data) { ?><option value="<?= $data ?>"><?= $data ?></option><?php } ?></select></td>';
            col1 += '<td><input type="text" autocomplete="off" class="form-control" placeholder="Alamat..." name="hrga_employee_lines[' + counter + '][address]"></td>';
            col1 += '<td><input type="text" autocomplete="off" class="form-control telp" placeholder="Telepon..." name="hrga_employee_lines[' + counter + '][telp]"></td>';
            col1 += '<td><input type="text" autocomplete="off" class="form-control" placeholder="Pekerjaan..." name="hrga_employee_lines[' + counter + '][pekerjaan]"></td>';
            col1 += '<td><select class="form-control slc" name="hrga_employee_lines[' + counter + '][clothes_size]" data-placeholer="Baju..." required><option value=""></option><?php foreach ($this->Krs->sized() as $key => $data) { ?><option value="<?= $data ?>"><?= $data ?></option><?php } ?></select></td>';
            col1 += '<td style="vertical-align: middle" rowspan="2" class="text-center"><button class="btn btn-danger btn-sm" type="button" id="deleteRow"><i class="fas fa-times"></i></button></td>';

            // bawah
            // var col2 = '';
            col1 += '<tr id=' + counter + ' class="table-info">'
            col1 += '<td><input type="text" autocomplete="off" class="form-control nk" placeholder="No. KTP" name="hrga_employee_lines[' + counter + '][no_ktp]"></td>';
            col1 += '<td colspan="2"><input type="text" autocomplete="off" class="form-control bpjs" placeholder="No. BPJS Kesehatan" name="hrga_employee_lines[' + counter + '][bpjs_kesehatan]"></td>';
            col1 += '<td><select class="form-control slc" name="hrga_employee_lines[' + counter + '][bpjs_kesehatan_status]" data-placeholder="Status BPJS"><option value=""></option><?php foreach ($this->Krs->status() as $key => $data) { ?><option value="<?= $key ?>"><?= $data ?></option><?php } ?></td>';
            col1 += '<td><input type="text" autocomplete="off" class="form-control tgl" placeholder="Aktif sampai tanggal" name="hrga_employee_lines[' + counter + '][bpjs_kesehatan_dates]" readonly></td>';
            col1 += '<td colspan="3"><input type="text" autocomplete="off" class="form-control" placeholder="Riwayat penyakit..." name="hrga_employee_lines[' + counter + '][riwayat_sakit]"></td>';


            // nambah baris didalam tabel
            $(".cntrol1").append(col1);
            // $(".cntrol2").append(col2);

            counter++;

            $('.tgl').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: 'bottom',
                todayHighlight: true,
            });

            $('.slc').select2({
                placeholder: 'Pilih salah satu...',
            });

            $(".nk").mask("9999999999999999");

            $(".bpjs").mask("9999999999999");

            $(".telp").mask("999999999999", {autoclear: false});

        });

        // training
        var index = $('.trainings tr').length;
        $("#insertTraining").on("click", function(event) {
            event.preventDefault();
            var rows = '';

            // atas
            rows += '<tr id=' + index + '>';
            rows += '<td scrope="row" class="text-center">' + index + '<input type="hidden" name="hrga_employee_trainings[' + index + '][id]"></td>';
            rows += '<td><input type="text" autocomplete="off" class="form-control" placeholder="Nama pelatihan/keterampilan..." name="hrga_employee_trainings[' + index + '][skill]"></td>';
            rows += '<td><input type="text" autocomplete="off" class="form-control tgl" placeholder="Tanggal mulai pelatihan..." name="hrga_employee_trainings[' + index + '][start_date]" readonly></td>';
            rows += '<td><input type="text" autocomplete="off" class="form-control tgl" placeholder="Tanggal berakhir pelatihan..." name="hrga_employee_trainings[' + index + '][end_date]" readonly></td>';
            rows += '<td><select class="form-control slc" name="hrga_employee_trainings[' + index + '][grade]" required><option value="">Pilih salah satu...</option><?php foreach ($this->Krs->level() as $key => $data) { ?><option value="<?= $data ?>"><?= $data ?></option><?php } ?></select></td>';
            rows += '<td><input type="text" autocomplete="off" class="form-control" placeholder="Nama penyelenggara..." name="hrga_employee_trainings[' + index + '][organizer]"></td>';
            rows += '<td class="text-center"><button class="btn btn-danger btn-sm" type="button" id="deleteTraining"><i class="fas fa-times"></i></button></td>';


            // nambah baris didalam tabel
            $(".trainings").append(rows);

            $('.tgl').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: 'bottom',
                todayHighlight: true,
            });

            $('.slc').select2({
                placeholder: 'Pilih salah satu...',
            });

            index++;

        });

        //Javascript menghapus kalau di klik
        $(document).on("click", "#deleteRow", function(event) {
            $(this).closest('tr').next().remove();
            $(this).closest('tr').remove();
        });

        $(document).on("click", "#deleteTraining", function(event) {
            let id = $(this).closest('tr').attr('id');
            $('table.trainings tr#' + id + '').remove();
        });

        $('input.nominal').autoNumeric({
            aSep: '.',
            aDec: ',',
            vMin: '-9999999999999.99',
            vMax: '9999999999999.99'
        });

    });
</script>
