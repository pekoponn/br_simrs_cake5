<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterSurgeryOperator[]|\Cake\Collection\CollectionInterface $masterSurgeryOperators
 */
?>
<div class="masterSurgeryOperators index content">
    <?= $this->Html->link(__('New Master Surgery Operator'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Master Surgery Operators') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('specialist') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masterSurgeryOperators as $masterSurgeryOperator): ?>
                <tr>
                    <td><?= $this->Number->format($masterSurgeryOperator->id) ?></td>
                    <td><?= h($masterSurgeryOperator->code) ?></td>
                    <td><?= $masterSurgeryOperator->has('doctor') ? $this->Html->link($masterSurgeryOperator->doctor->doctor_name, ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'view', $masterSurgeryOperator->doctor->id]) : '' ?></td>
                    <td><?= h($masterSurgeryOperator->name) ?></td>
                    <td><?= h($masterSurgeryOperator->specialist) ?></td>
                    <td><?= h($masterSurgeryOperator->phone) ?></td>
                    <td><?= h($masterSurgeryOperator->is_active) ?></td>
                    <td><?= h($masterSurgeryOperator->created) ?></td>
                    <td><?= h($masterSurgeryOperator->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $masterSurgeryOperator->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $masterSurgeryOperator->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $masterSurgeryOperator->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterSurgeryOperator->id)]) ?>
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
