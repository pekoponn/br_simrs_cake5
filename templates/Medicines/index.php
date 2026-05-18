<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine[]|\Cake\Collection\CollectionInterface $medicines
 */
$pages = (empty($this->request->getQuery('page'))) ? '' : $this->request->getQuery('page');
?>
<?= $this->Krs->breadcrumb('Master', 'Obat', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                    class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="alert alert-primary">
            Halaman <strong>Obat</strong>, datanya digunakan untuk transaksi Order pada setiap <strong>UBS</strong>
            serta digunakan <strong>SCM</strong> untuk melakukan Order ke Supplier.
        </div>
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add', $pages], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <?= $this->Html->link('<i class="fa fa-download"></i>', ['action' => 'pdf', $pages], ['class' => 'btn btn-green', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Download', 'escape' => false, 'fullBase' => true]) ?>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">
                    <div class="col-md-2 m-b-10">
                        <?= $this->Form->text('filterCode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode...', 'value' => $this->request->getQuery('filterCode')]); ?>
                    </div>
                    <div class="col-md-4 m-b-10">
                        <?= $this->Form->text('filterName', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama...', 'value' => $this->request->getQuery('filterName')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Krs->btnSeach(); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="100">Kode Internal</th>
                            <th width="100">Kode KFA</th>
                            <th>Nama</th>
                            <th width="200">Nama Barang</th>
                            <th width="150">Merk</th>
                            <th width="80">Aktif</th>
                            <th width="120" class="actions">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // pr($medicines);
                        if (count($medicines) > 0) {
                            foreach ($medicines as $rowData) {
                                $statusHiddenActive = ($rowData->is_active == 'Y') ? "" : ' style="display: none;"';
                                $statusHiddenInactive = ($rowData->is_active == 'N') ? "" : ' style="display: none;"';
                                $btnActive = "<div id='statusSpin" . $rowData->id . "'></div>";
                                $btnActive .= "<div id='statusActive" . $rowData->id . "'" . $statusHiddenActive . ">" . $this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape" => false, "onClick" => "changeStatusActive('" . $rowData->id . "', 'N', '" . $getUser->id . "')", "class" => "btn btn-lime btn-icon btn-circle btn-sm")) . "</div>";

                                $btnActive .= "<div id='statusInactive" . $rowData->id . "'" . $statusHiddenInactive . ">" . $this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape" => false, "onClick" => "changeStatusInactive('" . $rowData->id . "', 'Y', '" . $getUser->id . "')", "class" => "btn btn-danger btn-icon btn-circle btn-sm")) . "</div>";


                                $statusTransaction = ($rowData->transaction == "y") ? "<i class=\"fa fa-check\"></i>" : "";
                                $bottonUp = $this->Html->link('<i class="fa fa-arrow-up"></i>', array("action" => "moveup", $rowData->id), array("escape" => false));
                                $buttonDown = $this->Html->link('<i class="fa fa-arrow-down"></i>', array("action" => "movedown", $rowData->id), array("escape" => false));
                                //$this->Krs->nominal($stock['in'])
                        

                                //, $pages
                                $linkEdit = array('action' => 'edit', $rowData->id);
                                $linkDelete = array('action' => 'delete', $rowData->id);

                                if ($rowData->is_active == 'Y') {
                                    $classCondition = "";
                                } else {
                                    $classCondition = 'class="table-warning"';
                                }

                                // $medicineGroupName = (!empty($rowData->medicine_group->name)) ? $rowData->medicine_group->name : '';
                                // $medicineMerkName = (!empty($rowData->medicine_merk->name)) ? $rowData->medicine_merk->name : '';
                                $medicineGroupName = (!empty($rowData->medicine_group_name)) ? $rowData->medicine_group_name : '';
                                $medicineMerkName = (!empty($rowData->medicine_merk_name)) ? $rowData->medicine_merk_name : '';
                                // pr($rowData);
                                ?>
                                <tr <?= $classCondition ?>>
                                    <td align="center"><b><?= h($rowData->code) ?></b></td>
                                    <td align="center"><b><?= h($rowData->code_kfa) ?></b></td>
                                    <td><?= $rowData->name ?></td>
                                    <td><?= $medicineGroupName ?></td>
                                    <td><?= $medicineMerkName ?></td>
                                    <td align="center"><?= $btnActive ?></td>
                                    <td class="actions" width="100">
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                        <?= $this->Krs->btn('delete', $linkDelete, $rowData->name) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
                <!-- #modal-dialog -->
                <!-- <div class="modal fade" tabindex="-1" role="dialog" id="modal-detail"></div> -->
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
    <div class="panel-footer">
        <div class="btn-group">
            <?= $this->Form->create($medicines, ['type' => 'file', 'url' => ['action' => 'dataExportImport', 'save']]) ?>
            <?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
            <div class="portlet-body">
                <div class="note note-warning">
                    <div class="note-icon"><i class="fas fa-upload"></i></div>
                    <div class="note-content text-end">
                        <h4><b>Upload Data Barang melalui file Excel...</b></h4>
                        <?php
                        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                        echo $this->Form->file('filename', array('label' => false, 'size' => '50'));

                        echo $this->Form->button('Upload', ['class' => 'btn btn-primary', 'type' => 'submit', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Upload", 'id' => 'btn-upload']);

                        // echo $this->Form->button('Upload', array('class'=>'btn btn-success', 'type'=>'button', 'escape' => false, 'id'=> 'btn-upload'));
                        ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    class="fa fa-caret-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?= $this->Html->link('Contoh Excel', ['action' => 'dataExportImportXls'], ['class' => 'dropdown-item', 'escape' => false, 'fullBase' => true]) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>
<?php
$urlGetData = $this->Url->build(['controller' => 'TruckSchedules', 'action' => 'preview', '_full' => true]);
?>
<script>

    $(document).ready(function () {
        //datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');

        <?php
        if (count($medicines) > 0) {
            foreach ($medicines as $rowData) {
                echo 'handleFormPreview("btn-preview' . $rowData->id . '", "' . $urlGetData . '/' . $rowData->id . '");';
            }
        }
        ?>
    });
</script>
<?php
/*
<div class="medicines index content">
    <?= $this->Html->link(__('New Medicine'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Medicines') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('medicine_merk_id') ?></th>
                    <th><?= $this->Paginator->sort('medicine_group_id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('code_kfa') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('code_ifrs') ?></th>
                    <th><?= $this->Paginator->sort('merk') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('img') ?></th>
                    <th><?= $this->Paginator->sort('qty_unit') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <th><?= $this->Paginator->sort('qty_packaging') ?></th>
                    <th><?= $this->Paginator->sort('packaging') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_print') ?></th>
                    <th><?= $this->Paginator->sort('printed') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicines as $medicine): ?>
                <tr>
                    <td><?= $this->Number->format($medicine->id) ?></td>
                    <td><?= $medicine->has('branch') ? $this->Html->link($medicine->branch->name, ['controller' => 'Branches', 'action' => 'view', $medicine->branch->id]) : '' ?></td>
                    <td><?= $medicine->has('medicine_merk') ? $this->Html->link($medicine->medicine_merk->name, ['controller' => 'MedicineMerks', 'action' => 'view', $medicine->medicine_merk->id]) : '' ?></td>
                    <td><?= $medicine->has('medicine_group') ? $this->Html->link($medicine->medicine_group->name, ['controller' => 'MedicineGroups', 'action' => 'view', $medicine->medicine_group->id]) : '' ?></td>
                    <td><?= h($medicine->code) ?></td>
                    <td><?= h($medicine->code_kfa) ?></td>
                    <td><?= h($medicine->name) ?></td>
                    <td><?= h($medicine->code_ifrs) ?></td>
                    <td><?= h($medicine->merk) ?></td>
                    <td><?= h($medicine->type) ?></td>
                    <td><?= h($medicine->description) ?></td>
                    <td><?= h($medicine->img) ?></td>
                    <td><?= $this->Number->format($medicine->qty_unit) ?></td>
                    <td><?= h($medicine->unit) ?></td>
                    <td><?= $this->Number->format($medicine->qty_packaging) ?></td>
                    <td><?= h($medicine->packaging) ?></td>
                    <td><?= $this->Number->format($medicine->is_create) ?></td>
                    <td><?= h($medicine->created) ?></td>
                    <td><?= $this->Number->format($medicine->is_update) ?></td>
                    <td><?= h($medicine->modified) ?></td>
                    <td><?= $this->Number->format($medicine->is_print) ?></td>
                    <td><?= h($medicine->printed) ?></td>
                    <td><?= h($medicine->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $medicine->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicine->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicine->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
*/
?>