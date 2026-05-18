<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?= $this->Krs->breadcrumb('User', 'Tampilkan') ?>
    <div class="panel panel-inverse">
        <div class="panel-heading">
        <h4 class="panel-title">Halaman</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="portlet-body form">
                <div class="table-toolbar">
                    <div class="btn-group">
                      <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['controller' => 'users', 'action' => 'add'], ['class'=>'btn btn-inverse', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Add', 'escape' => false, 'fullBase'=>true]) ?>
                        <?= $this->Html->link('<i class="fa fa-download"></i>', ['controller' => 'users', 'action' => 'pdf'], ['class'=>'btn btn-green', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Download', 'escape' => false, 'fullBase'=>true]) ?>
                      </div>
                    </div>
                    <div class="btn-group pull-right">
                        <div class="portlet-body">
                           <?= $this->Form->create(null, ['type' => 'get']) ?>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari..." name="key" value="<?= $this->request->getQuery('key'); ?>">
                                <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>   
                </div>
                <br>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-td-valign-middle">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th width="100">Kode</th>
                                <th width="120">Jabatan</th>
                                <th>Nama</th>
                                <th width="150">Terakhir Login</th>
                                <th width="80">Status</th>
                                <th width="80">Kunjungan</th>
                                <th width="170">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user):
                                $linkPreview = array('action' => 'access', $user->id);
                                //$linkPreview = array('action' => 'view', $user->id);
                                $linkEdit = array('action' => 'edit', $user->id);
                                // $linkDelete = array('action' => 'delete', $user->id);
                                $linkResetPassword = array('action' => 'reset_password', $user->id);
                                $userLastLogin = (empty($user->last_login)) ? '' : date_format($user->last_login, 'd-m-Y (H:m:i)');

                                $btnAction = $this->Krs->btn('access', $linkPreview);
                                $btnAction .= $this->Krs->btn('edit', $linkEdit);
                                $btnAction .= $this->Krs->btn('resetPassword', $linkResetPassword, $user->name);
                                ?>
                            <tr>
                                <td><?= h($user->code) ?></td>
                                <td align="center"><?= h($user->staff) ?></td>
                                <td><?= h($user->name) ?></td>                        
                                <td align="center"><?= $userLastLogin ?></td>
                                <td align="center"><?= h($user->status) ?></td>
                                <td align="center"><?= $this->Number->format($user->visited) ?></td>
                                <td class="actions text-center">
                                    <?= $btnAction ?>                                   
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?= $this->Krs->paginators() ?>
            </div>
            <?php
            /*
            <?= $this->Krs->btn('delete', $linkDelete, $user->name) ?>
             <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>






            <div class="paginator">
                <ul class="pagination pagination-lg m-t-0 m-b-5">
                    <li class="page-item"><?= $this->Paginator->first('<< ' . __('first')) ?></li>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
            */
            ?>
        </div>
    </div>
<?php
/*
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('staff') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('password') ?></th>
                    <th><?= $this->Paginator->sort('help_hint_pwd') ?></th>
                    <th><?= $this->Paginator->sort('telp') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('devision') ?></th>
                    <th><?= $this->Paginator->sort('position') ?></th>
                    <th><?= $this->Paginator->sort('marketing_code') ?></th>
                    <th><?= $this->Paginator->sort('approved') ?></th>
                    <th><?= $this->Paginator->sort('approved_ceo') ?></th>
                    <th><?= $this->Paginator->sort('payment') ?></th>
                    <th><?= $this->Paginator->sort('pettycash_full_access') ?></th>
                    <th><?= $this->Paginator->sort('hris_approved') ?></th>
                    <th><?= $this->Paginator->sort('hris_knowing') ?></th>
                    <th><?= $this->Paginator->sort('hris_full_access') ?></th>
                    <th><?= $this->Paginator->sort('jurnal_type_acc') ?></th>
                    <th><?= $this->Paginator->sort('change_password') ?></th>
                    <th><?= $this->Paginator->sort('change_password_date') ?></th>
                    <th><?= $this->Paginator->sort('reset') ?></th>
                    <th><?= $this->Paginator->sort('reset_date') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('who_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('who_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('last_login') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('visited') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= $user->has('branch') ? $this->Html->link($user->branch->name, ['controller' => 'Branches', 'action' => 'view', $user->branch->id]) : '' ?></td>
                    <td><?= h($user->code) ?></td>
                    <td><?= h($user->staff) ?></td>
                    <td><?= h($user->name) ?></td>
                    <td><?= h($user->password) ?></td>
                    <td><?= h($user->help_hint_pwd) ?></td>
                    <td><?= h($user->telp) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->devision) ?></td>
                    <td><?= h($user->position) ?></td>
                    <td><?= h($user->marketing_code) ?></td>
                    <td><?= h($user->approved) ?></td>
                    <td><?= h($user->approved_ceo) ?></td>
                    <td><?= h($user->payment) ?></td>
                    <td><?= h($user->pettycash_full_access) ?></td>
                    <td><?= h($user->hris_approved) ?></td>
                    <td><?= h($user->hris_knowing) ?></td>
                    <td><?= h($user->hris_full_access) ?></td>
                    <td><?= h($user->jurnal_type_acc) ?></td>
                    <td><?= h($user->change_password) ?></td>
                    <td><?= h($user->change_password_date) ?></td>
                    <td><?= $this->Number->format($user->reset) ?></td>
                    <td><?= h($user->reset_date) ?></td>
                    <td><?= h($user->is_create) ?></td>
                    <td><?= h($user->is_update) ?></td>
                    <td><?= h($user->is_delete) ?></td>
                    <td><?= h($user->deleted) ?></td>
                    <td><?= h($user->is_active) ?></td>
                    <td><?= h($user->who_create) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->who_update) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td><?= h($user->last_login) ?></td>
                    <td><?= h($user->status) ?></td>
                    <td><?= h($user->level) ?></td>
                    <td><?= $this->Number->format($user->visited) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
