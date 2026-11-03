<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterSupport[]|\Cake\Collection\CollectionInterface $masterSupports
 */
?>
<div class="masterSupports index content">
    <?= $this->Html->link(__('New Master Support'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Master Supports') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('tariff') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masterSupports as $masterSupport): ?>
                <tr>
                    <td><?= $this->Number->format($masterSupport->id) ?></td>
                    <td><?= h($masterSupport->code) ?></td>
                    <td><?= h($masterSupport->name) ?></td>
                    <td><?= h($masterSupport->category) ?></td>
                    <td><?= $this->Number->format($masterSupport->tariff) ?></td>
                    <td><?= h($masterSupport->unit) ?></td>
                    <td><?= h($masterSupport->is_active) ?></td>
                    <td><?= h($masterSupport->created) ?></td>
                    <td><?= h($masterSupport->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $masterSupport->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $masterSupport->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $masterSupport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterSupport->id)]) ?>
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
