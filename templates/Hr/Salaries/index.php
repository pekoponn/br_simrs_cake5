<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary[]|\Cake\Collection\CollectionInterface $salaries
 */
?>
<?= $this->Krs->breadcrumb('HRGA', 'Gaji Pegawai', 'Tampilkan') ?>
<div class="table-toolbar">
    <div class="btn-group">
        <?= $this->Form->create($dataRows, ['type' => 'file', 'url' => ['action' => 'deliveryImportSave', 'save']]) ?>
        <?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
        <div class="portlet-body">
            <div class="note note-cyan">
                <div class="note-icon"><i class="fas fa-upload"></i></div>
                <div class="note-content text-end">                             
                    <h4><b>Upload <u>Data Gaji Pegawai</u> melalui file Excel...</b></h4>
                    <?php
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                    echo $this->Form->file('filename', array('label' => false, 'size' => '50'));
                    
                    echo $this->Form->button('Upload', ['class' => 'btn btn-primary', 'type' => 'button', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);
                    ?>
                    <div class="btn-group dropdown">
                        <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
                        <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?= $this->Html->link('Contoh Excel', ['prefix' => 'Hr', 'controller' => 'Salaries', 'action' => 'importExcel'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
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
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'excel']); ?>">Excel File</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">
                    <div class="col-md-3 m-b-10">
                        <?= $this->Form->control('filterEmployee', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Pegawai...', 'value' => $this->request->getQuery('filterEmployee')]); ?>
                    </div>
                    <div class="col-md-3 m-b-10">
                        <?= $this->Form->control('filterUnitBusiness', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Unit Bisnis...', 'value' => $this->request->getQuery('filterUnitBusiness')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Krs->btnSeach(); ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th width="120">NIP</th>
                            <th>Nama Pegawai</th>
                            <th width="250">Unit Bisnis</th>
                            <th width="180">Jabatan</th>
                            <th width="100">Divisi</th>
                            <th width="120">Total Gaji</th>
                            <th class="actions text-center" width="120"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($dataRows) > 0) {
                            foreach ($dataRows as $index => $data) {
                                $hrgaEmployee = $data->hrga_employee;
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);

                                $total = $data->gaji_pokok + $data->tunjangan_harian + $data->tunjangan_jabatan + $data->tunjangan_makan + $data->tunjangan_produktifitas + $data->tunjangan_struktural;
                        ?>
                                <tr>
                                    <td class="text-left"><strong><?= $hrgaEmployee->nip ?></strong></td>
                                    <td class="text-left"><strong><?= $hrgaEmployee->name ?></strong></td>
                                    <td class="text-center"><?= $hrgaEmployee->business_unit ?></td>
                                    <td class="text-center"><?= $hrgaEmployee->position ?></td>
                                    <td class="text-center"><?= $hrgaEmployee->devisi ?></td>
                                    <td class="text-right"><?= $this->Krs->_currency($total); ?></td>
                                    <td class="actions text-center">
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            }
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


<!-- modal view -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'Salaries', 'action' => 'view', '_full' => true]);
?>



<script>
$(document).ready(function() {
    var confirmTitleUpload = "Apakah anda ingin mengupload data tersebut ?";
    var formActionUpload = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'Salaries', 'action' => 'importExcelSave', 'save'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupUploadForm', 'btn-upload', confirmTitleUpload, formActionUpload);

    $('.slc').select2({
        placeholder: 'Pilih salah satu...',
        allowClear: true
    });

    <?php
    foreach ($dataRows as $rs) {
        echo 'handleFormPreview("btn-preview' . $rs->id . '", "' . $urlGetData . '/' . $rs->id . '");';
    }
    ?>

});
</script>
