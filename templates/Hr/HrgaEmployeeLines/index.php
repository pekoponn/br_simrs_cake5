<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployeeLine[]|\Cake\Collection\CollectionInterface $hrgaEmployeeLines
 */
?>
<div class="hrgaEmployeeLines index content">
    <?= $this->Html->link(__('New Hrga Employee Line'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Hrga Employee Lines') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('hrga_employee_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('status_family') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('no_ktp') ?></th>
                    <th><?= $this->Paginator->sort('telp') ?></th>
                    <th><?= $this->Paginator->sort('pekerjaan') ?></th>
                    <th><?= $this->Paginator->sort('bpjs_kesehatan') ?></th>
                    <th><?= $this->Paginator->sort('bpjs_kesehatan_status') ?></th>
                    <th><?= $this->Paginator->sort('bpjs_kesehatan_date') ?></th>
                    <th><?= $this->Paginator->sort('birthday') ?></th>
                    <th><?= $this->Paginator->sort('status_kesehatan') ?></th>
                    <th><?= $this->Paginator->sort('place_of_birth') ?></th>
                    <th><?= $this->Paginator->sort('riwayat_sakit') ?></th>
                    <th><?= $this->Paginator->sort('clothes_size') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hrgaEmployeeLines as $hrgaEmployeeLine): ?>
                <tr>
                    <td><?= $this->Number->format($hrgaEmployeeLine->id) ?></td>
                    <td><?= $hrgaEmployeeLine->has('hrga_employee') ? $this->Html->link($hrgaEmployeeLine->hrga_employee->name, ['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'view', $hrgaEmployeeLine->hrga_employee->id]) : '' ?></td>
                    <td><?= h($hrgaEmployeeLine->name) ?></td>
                    <td><?= h($hrgaEmployeeLine->status_family) ?></td>
                    <td><?= h($hrgaEmployeeLine->address) ?></td>
                    <td><?= h($hrgaEmployeeLine->no_ktp) ?></td>
                    <td><?= h($hrgaEmployeeLine->telp) ?></td>
                    <td><?= h($hrgaEmployeeLine->pekerjaan) ?></td>
                    <td><?= h($hrgaEmployeeLine->bpjs_kesehatan) ?></td>
                    <td><?= h($hrgaEmployeeLine->bpjs_kesehatan_status) ?></td>
                    <td><?= h($hrgaEmployeeLine->bpjs_kesehatan_date) ?></td>
                    <td><?= h($hrgaEmployeeLine->birthday) ?></td>
                    <td><?= h($hrgaEmployeeLine->status_kesehatan) ?></td>
                    <td><?= h($hrgaEmployeeLine->place_of_birth) ?></td>
                    <td><?= h($hrgaEmployeeLine->riwayat_sakit) ?></td>
                    <td><?= h($hrgaEmployeeLine->clothes_size) ?></td>
                    <td><?= $this->Number->format($hrgaEmployeeLine->is_create) ?></td>
                    <td><?= h($hrgaEmployeeLine->created) ?></td>
                    <td><?= $this->Number->format($hrgaEmployeeLine->is_update) ?></td>
                    <td><?= h($hrgaEmployeeLine->modified) ?></td>
                    <td><?= h($hrgaEmployeeLine->status) ?></td>
                    <td><?= h($hrgaEmployeeLine->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $hrgaEmployeeLine->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $hrgaEmployeeLine->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $hrgaEmployeeLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaEmployeeLine->id)]) ?>
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
