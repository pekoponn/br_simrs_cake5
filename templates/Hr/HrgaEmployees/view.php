<?php
ini_set('precision', 14);
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data Pegawai</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Nama Pegawai</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->name ?></span></div>
                        <div class="col-2 col-sm-2">
                            <b>NIP</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->nip ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Divisi</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->devisi ?></span></div>
                        <div class="col-2 col-sm-2">
                            <b>Jabatan</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->position ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>NPWP</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->npwp ?></span></div>
                        <div class="col-2 col-sm-2">
                            <b>Tanggungan</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->status_tanggungan ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Email</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->email ?></span></div>
                        <div class="col-2 col-sm-2">
                            <b>Telepon</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->telp ?></span></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>KTP / NIK</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->no_ktp ?></span></div>
                        <div class="col-2 col-sm-2">
                            <b>Kartu Keluarga (KK)</b>
                        </div>
                        <div class="col-4 col-sm-4">: <span><?= $hrgaEmployee->no_kk ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <b>Alamat</b>
                        </div>
                        <div class="col-8 col-sm-8">: <span><?= $hrgaEmployee->address ?></span></div>
                    </div>
                </div>
            </div>
            <hr>
            <b>ANGGOTA KELUARGA</b>
            <br>
            <br>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Keluarga</th>
                        <th>No. Bpjs</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($hrgaEmployee->hrga_employee_lines as $key => $value) { ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->status_family ?></td>
                            <td><?= $value->bpjs_kesehatan ?></td>
                            <td><span class="badge <?= ($value->bpjs_kesehatan_status == 'Y') ? 'bg-info' : 'bg-danger' ?>"><?= ($value->bpjs_kesehatan_status == 'Y') ? 'Aktif' : 'Non-aktif' ?></span></td>
                        </tr>
                    <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
