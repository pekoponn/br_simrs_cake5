<?= $this->Krs->breadcrumb('HRGA', 'Data Karyawan', 'Tampilkan') ?>
<div class="table-toolbar">
    <div class="btn-group">
        <?= $this->Form->create($hrgaEmployees, ['type' => 'file', 'url' => ['action' => 'import', 'save']]) ?>
        <?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
        <div class="portlet-body">
            <div class="note note-cyan">
                <div class="note-icon"><i class="fas fa-upload"></i></div>
                <div class="note-content text-end">                             
                    <h4><b>Upload <u>Data Karyawan</u> melalui file Excel...</b></h4>
                    <?php
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                    echo $this->Form->file('filename', array('label' => false, 'size' => '50'));
                    
                    echo $this->Form->button('Upload', ['class' => 'btn btn-primary', 'type' => 'button', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);
                    ?>
                    <div class="btn-group dropdown">
                        <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
                        <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?= $this->Html->link('Contoh Excel', ['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'templateExcel'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                        </div>

                    </div>
                    <div class="stats-desc text-danger"><i>Perhatian: Proses data akan disimpan langsung tanpa melalui filter.</i></div>
                    <?php
                    // }
                    ?>
                </div>
                                  

            </div> 
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-angle-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?= $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'excel']); ?>">Excel File</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddCuti">
                            <i class="fa fa-calendar-plus"></i> Tambah Cuti
                        </button>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-aqua">
                <div class="row">
                    <div class="col-md-1">
                        <?= $this->Form->control('filternip', ['label' => false, 'class' => 'form-control', 'placeholder' => 'NIP...', 'value' => $this->request->getQuery('filternip')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <!-- <div class="col-md-2">
                        <?= $this->Form->control('filterbranch', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Cabang...', 'value' => $this->request->getQuery('filterbranch')]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('filterunit', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'unit bisnis...', 'options' => $this->Krs->businessUnit(), 'empty' => 'unit bisnis...', 'value' => $this->request->getQuery('filterunit')]); ?>
                    </div> -->
                    <div class="col-md-2">
                        <?= $this->Form->control('filterkepegawaian', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'kepegawaian...', 'options' => $this->Krs->employeeStatus(), 'empty' => 'Kepegawaian...', 'value' => $this->request->getQuery('filterkepegawaian')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'status...', 'options' => $this->Krs->status(), 'empty' => 'Status...', 'value' => $this->request->getQuery('filterstatus')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->button('Cari', ['class' => 'btn btn-yellow btn-block', 'type' => 'submit']); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <?php
            foreach ($expired as $key => $value) { ?>
            <?php
            $today = new DateTime();
            $endDate = new DateTime($value->contract_end_date);
            $interval = $today->diff($endDate);
            $days = $interval->days;
            $isPast = $today > $endDate;
            ?>
                <div class="alert <?= $value->is_active == 'N' ? "alert-danger" : "alert-yellow"; ?> alert-dismissible fade show">

                    <strong>Peringatan!.</strong> Karyawan atas nama <strong><?= $value->name ?></strong> (<?= $isPast ? "H+{$days}" : "H-{$days}" ?>) <?= $value->is_active == 'N' ? "sudah" : 'akan'; ?> memasuki berakhirnya kontrak. Segera lakukan tindakan perpanjangan kontrak lewat link berikut.
                    <a href="<?= $this->Url->build(['action' => 'edit', $value->id]); ?>" class="alert-link">Lanjutkan</a>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
            }
            ?>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th class="text-center" width="50">#</th>
                            <!-- <th class="text-left">Cabang</th> -->
                            <!-- <th class="text-left">Unit Bisnis</th> -->
                            <th class="text-left">Nama</th>
                            <th>NIP</th>
                            <th>Status Kepegawaian</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>No. Telepon</th>
                            <th>Sisa Cuti</th>
                            <th>Status</th>
                            <th class="actions text-center" width="200"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($hrgaEmployees) > 0) {
                            foreach ($hrgaEmployees as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                        ?>
                                <tr class="text-center <?= ($data->is_active == 'N') ? "table-danger" : ""; ?>">
                                    <td class="text-center"><?= $no; ?></td>
                                    <!-- <td class="text-left"><strong><?= $data->branch ?></strong></td> -->
                                    <!-- <td class="text-left"><strong><?= $data->business_unit ?></strong></td> -->
                                    <td class="text-left"><strong><?= $data->name . ' (' . $data->user->code . ')'  ?></strong></td>
                                    <td><strong><?= $data->nip ?></strong></td>
                                    <td><?= $this->Krs->employeeStatus($data->status); ?><?php if ($data->status != 'tetap') : ?><br><?= (date_format(new \DateTime($data->contract_end_date), 'd-m-Y')) ?><?php endif; ?></td>
                                    <td><?= $data->devisi ?></td>
                                    <td><?= $data->position ?></td>
                                    <td><?= $data->telp ?></td>
                                    <td><?= $data->jml_cuti ?></td>
                                    <td><span class="badge <?= ($data->is_active == 'Y') ? 'bg-success' : 'bg-default'; ?>"><?= ($data->is_active == 'Y') ? 'Aktif' : 'Non-Aktif'; ?></span><br><?= (date_format(new \DateTime($data->created), 'd-m-Y')) ?></td>
                                    <td class="actions text-center">
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach;
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<!-- modal add cuti -->
<div class="modal fade" id="modalAddCuti" tabindex="-1" role="dialog" aria-labelledby="modalAddCutiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, [
                'url' => ['action' => 'addCuti'],
                'id' => 'formAddCuti',
                'type' => 'post'
            ]) ?>
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddCutiLabel">Tambah Cuti Keseluruhan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Jumlah Cuti yang akan ditambah</label>
                    <?= $this->Form->control('jml_cuti', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Jumlah Cuti',
                        'type' => 'number',
                        'min' => 1,
                        'required' => true
                    ]) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<!-- modal view -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'view', '_full' => true]);
?>

<script>
$(document).ready(function() {
    var confirmTitleUpload = "Apakah anda ingin mengupload data tersebut ?";
    var formActionUpload = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'import', 'save'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupUploadForm', 'btn-upload', confirmTitleUpload, formActionUpload);

    $('.slc').select2({
        placeholder: 'Pilih salah satu...',
        allowClear: true
    });

    <?php
    foreach ($hrgaEmployees as $rs) {
        echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
    }
    ?>
    $('#formAddCuti').on('submit', function(e) {
        e.preventDefault();

        SwalHelper.confirm('Apakah Anda yakin ingin menyimpan?', '', 'Ya, simpan', 'Batal')
            .then((result) => {
                if (result.isConfirmed) {
                    const form = this;
                    const formData = new FormData(form);

                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                SwalHelper.success(response.message).then(() => {
                                    // Redirect ke halaman index
                                    window.location.href = '<?= $this->Url->build(['action' => 'index']); ?>';
                                });
                            } else {
                                SwalHelper.error('Gagal menyimpan data.');
                            }
                        },
                        error: function() {
                            SwalHelper.error('Terjadi kesalahan saat menyimpan data.');
                        }
                    });
                }
            });
    });
});

</script>
