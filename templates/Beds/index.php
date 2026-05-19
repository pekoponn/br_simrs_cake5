<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed[]|\Cake\Collection\CollectionInterface $beds
 */
?>
<div class="beds index content">
    <?= $this->Html->link(__('New Bed'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Beds') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('room_id') ?></th>
                    <th><?= $this->Paginator->sort('bed_no') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('class_name') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($beds as $bed): ?>
                <tr>
                    <td><?= $this->Number->format($bed->id) ?></td>
                    <td><?= h($bed->code) ?></td>
                    <td><?= $bed->has('room') ? $this->Html->link($bed->room->id, ['controller' => 'Rooms', 'action' => 'view', $bed->room->id]) : '' ?></td>
                    <td><?= h($bed->bed_no) ?></td>
                    <td><?= h($bed->name) ?></td>
                    <td><?= h($bed->class_name) ?></td>
                    <td><?= $this->Number->format($bed->status) ?></td>
                    <td><?= $this->Number->format($bed->is_create) ?></td>
                    <td><?= h($bed->created) ?></td>
                    <td><?= $this->Number->format($bed->is_update) ?></td>
                    <td><?= h($bed->modified) ?></td>
                    <td><?= $this->Number->format($bed->is_delete) ?></td>
                    <td><?= h($bed->deleted) ?></td>
                    <td><?= h($bed->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bed->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bed->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bed->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bed->id)]) ?>
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
