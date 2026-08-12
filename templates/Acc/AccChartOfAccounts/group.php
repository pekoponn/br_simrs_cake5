<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount[]|\Cake\Collection\CollectionInterface $accChartOfAccounts
 */
?>
<?= $this->Krs->breadcrumb('Accounting', 'Perkiraan', 'Kelompok') ?>

<div class="panel">
    <div class="panel-body bg-warning-transparent-4">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime">Download</a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-download"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="" target="_blank">Pdf File</a>
                                <a class="dropdown-item" href="">Excel File</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-group pull-right">
                    <div class="portlet-body">
                        <?= $this->Form->create(null, ['type' => 'get']) ?>
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1" type="text" placeholder="Cari data ..." aria-label="Search" name="key" value="<?= $this->request->getQuery('key'); ?>">
                            <div class="input-group-append">
                                <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th width="20%">Kode</th>
                            <th width="40%">Tanggal</th>
                            <th class="actions text-center" width="15%"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($proacceptances) > 0) {
                            foreach ($proacceptances as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $dataSts = ($data->is_active == 'Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td><?= $data->code ?></td>
                                    <td><?php echo $this->Krs->fDate($data->date, 'd F Y') ?></td>                                   
                                    <td class="actions text-center">
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                        <?= $this->Krs->btn('delete', $linkDelete, $data->name) ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach;
                        } else {
                            ?>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">

</div>

<div class="accChartOfAccounts index content">
    <?= $this->Html->link(__('New Acc Chart Of Account'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Acc Chart Of Accounts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('parent_id') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('parent_account') ?></th>
                    <th><?= $this->Paginator->sort('header_account') ?></th>
                    <th><?= $this->Paginator->sort('sub_header_account') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('contra_account') ?></th>
                    <th><?= $this->Paginator->sort('mapping') ?></th>
                    <th><?= $this->Paginator->sort('group') ?></th>
                    <th><?= $this->Paginator->sort('sub_group') ?></th>
                    <th><?= $this->Paginator->sort('sub_group_no') ?></th>
                    <th><?= $this->Paginator->sort('default') ?></th>
                    <th><?= $this->Paginator->sort('journal_type') ?></th>
                    <th><?= $this->Paginator->sort('transaction') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('character') ?></th>
                    <th><?= $this->Paginator->sort('code_additional') ?></th>
                    <th><?= $this->Paginator->sort('additional') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accChartOfAccounts as $accChartOfAccount): ?>
                <tr>
                    <td><?= $this->Number->format($accChartOfAccount->id) ?></td>
                    <td><?= $accChartOfAccount->has('branch') ? $this->Html->link($accChartOfAccount->branch->name, ['controller' => 'Branches', 'action' => 'view', $accChartOfAccount->branch->id]) : '' ?></td>
                    <td><?= $accChartOfAccount->has('parent_acc_chart_of_account') ? $this->Html->link($accChartOfAccount->parent_acc_chart_of_account->name, ['controller' => 'AccChartOfAccounts', 'action' => 'view', $accChartOfAccount->parent_acc_chart_of_account->id]) : '' ?></td>
                    <td><?= $this->Number->format($accChartOfAccount->level) ?></td>
                    <td><?= h($accChartOfAccount->parent_account) ?></td>
                    <td><?= h($accChartOfAccount->header_account) ?></td>
                    <td><?= h($accChartOfAccount->sub_header_account) ?></td>
                    <td><?= h($accChartOfAccount->code) ?></td>
                    <td><?= h($accChartOfAccount->name) ?></td>
                    <td><?= h($accChartOfAccount->type) ?></td>
                    <td><?= h($accChartOfAccount->contra_account) ?></td>
                    <td><?= h($accChartOfAccount->mapping) ?></td>
                    <td><?= h($accChartOfAccount->group) ?></td>
                    <td><?= h($accChartOfAccount->sub_group) ?></td>
                    <td><?= h($accChartOfAccount->sub_group_no) ?></td>
                    <td><?= h($accChartOfAccount->default) ?></td>
                    <td><?= h($accChartOfAccount->journal_type) ?></td>
                    <td><?= h($accChartOfAccount->transaction) ?></td>
                    <td><?= h($accChartOfAccount->description) ?></td>
                    <td><?= h($accChartOfAccount->character) ?></td>
                    <td><?= h($accChartOfAccount->code_additional) ?></td>
                    <td><?= $this->Number->format($accChartOfAccount->additional) ?></td>
                    <td><?= h($accChartOfAccount->is_create) ?></td>
                    <td><?= h($accChartOfAccount->created) ?></td>
                    <td><?= h($accChartOfAccount->is_update) ?></td>
                    <td><?= h($accChartOfAccount->modified) ?></td>
                    <td><?= h($accChartOfAccount->is_delete) ?></td>
                    <td><?= h($accChartOfAccount->deleted) ?></td>
                    <td><?= h($accChartOfAccount->status) ?></td>
                    <td><?= h($accChartOfAccount->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $accChartOfAccount->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accChartOfAccount->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accChartOfAccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accChartOfAccount->id)]) ?>
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
