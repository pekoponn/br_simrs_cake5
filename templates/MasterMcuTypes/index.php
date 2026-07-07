<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterMcuType[]|\Cake\Collection\CollectionInterface $masterMcuTypes
 */
?>
<div class="masterMcuTypes index content">
    <?= $this->Html->link(__('New Master Mcu Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Master Mcu Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masterMcuTypes as $masterMcuType): ?>
                <tr>
                    <td><?= $this->Number->format($masterMcuType->id) ?></td>
                    <td><?= h($masterMcuType->code) ?></td>
                    <td><?= h($masterMcuType->name) ?></td>
                    <td><?= h($masterMcuType->is_active) ?></td>
                    <td><?= h($masterMcuType->is_delete) ?></td>
                    <td><?= h($masterMcuType->created) ?></td>
                    <td><?= h($masterMcuType->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $masterMcuType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $masterMcuType->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $masterMcuType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterMcuType->id)]) ?>
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
