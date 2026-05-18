<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicineMerk[]|\Cake\Collection\CollectionInterface $medicineMerks
 */
$pages = (empty($this->request->getQuery('page')))?'':$this->request->getQuery('page');
?>
<?= $this->Krs->breadcrumb('Master', 'Merk', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                  <div class="portlet-body">
                    <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add', $pages], ['class'=>'btn btn-inverse', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Add', 'escape' => false, 'fullBase'=>true]) ?>
                    <?= $this->Html->link('<i class="fa fa-download"></i>', ['action' => 'pdf', $pages], ['class'=>'btn btn-green', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Download', 'escape' => false, 'fullBase'=>true]) ?>
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
                            <th width="100">Kode</th>
                            <th>Nama</th>
                            <th width="80">Aktif</th>
                            <th  width="120" class="actions">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // pr($medicineMerk);
                        if (count($medicineMerks) > 0) {
                            foreach ($medicineMerks as $rowData){
                                $statusHiddenActive = ($rowData->is_active=='Y') ? "": ' style="display: none;"';
                                $statusHiddenInactive = ($rowData->is_active=='N') ? "": ' style="display: none;"';
                                $btnActive = "<div id='statusSpin".$rowData->id."'></div>";
                                $btnActive .= "<div id='statusActive".$rowData->id."'".$statusHiddenActive.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusActive('".$rowData->id."', 'N', '".$getUser->id."')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>";

                                $btnActive .= "<div id='statusInactive".$rowData->id."'".$statusHiddenInactive.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusInactive('".$rowData->id."', 'Y', '".$getUser->id."')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";


                                $statusTransaction = ($rowData->transaction=="y")? "<i class=\"fa fa-check\"></i>":"";
                                $bottonUp = $this->Html->link('<i class="fa fa-arrow-up"></i>', array("action"=>"moveup", $rowData->id), array("escape"=>false));
                                $buttonDown = $this->Html->link('<i class="fa fa-arrow-down"></i>', array("action"=>"movedown", $rowData->id), array("escape"=>false));
                                //$this->Krs->nominal($stock['in'])
                                

                                //, $pages
                                $linkEdit = array('action' => 'edit', $rowData->id);
                                $linkDelete = array('action' => 'delete', $rowData->id);

                                if($rowData->is_active=='Y'){
                                    $classCondition = "";
                                } else {
                                    $classCondition = 'class="table-warning"';
                                }
                            ?>
                           <tr <?= $classCondition ?>>
                                <td><b><?= h($rowData->code) ?></b></td>
                                <td><?= $rowData->name ?></td>                            
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
</div>
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>
<?php
$urlGetData = $this->Url->build(['controller' => 'TruckSchedules', 'action' => 'preview', '_full'=>true]);
?>
<script>

$(document).ready(function() {
    //datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');

    <?php
    if (count($medicineMerk) > 0) {
        foreach ($medicineMerk as $rowData) {
        echo 'handleFormPreview("btn-preview'.$rowData->id.'", "'.$urlGetData.'/'.$rowData->id.'");';
        }
    }
    ?>
});
</script>
<?php
/*
<div class="medicineMerks index content">
    <?= $this->Html->link(__('New Medicine Merk'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Medicine Merks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
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
                <?php foreach ($medicineMerks as $medicineMerk): ?>
                <tr>
                    <td><?= $this->Number->format($medicineMerk->id) ?></td>
                    <td><?= $medicineMerk->has('branch') ? $this->Html->link($medicineMerk->branch->name, ['controller' => 'Branches', 'action' => 'view', $medicineMerk->branch->id]) : '' ?></td>
                    <td><?= h($medicineMerk->code) ?></td>
                    <td><?= h($medicineMerk->name) ?></td>
                    <td><?= h($medicineMerk->type) ?></td>
                    <td><?= h($medicineMerk->description) ?></td>
                    <td><?= h($medicineMerk->img) ?></td>
                    <td><?= $this->Number->format($medicineMerk->qty_unit) ?></td>
                    <td><?= h($medicineMerk->unit) ?></td>
                    <td><?= $this->Number->format($medicineMerk->qty_packaging) ?></td>
                    <td><?= h($medicineMerk->packaging) ?></td>
                    <td><?= $this->Number->format($medicineMerk->is_create) ?></td>
                    <td><?= h($medicineMerk->created) ?></td>
                    <td><?= $this->Number->format($medicineMerk->is_update) ?></td>
                    <td><?= h($medicineMerk->modified) ?></td>
                    <td><?= $this->Number->format($medicineMerk->is_print) ?></td>
                    <td><?= h($medicineMerk->printed) ?></td>
                    <td><?= h($medicineMerk->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $medicineMerk->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicineMerk->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicineMerk->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicineMerk->id)]) ?>
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