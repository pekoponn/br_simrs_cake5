<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BedHistory[]|\Cake\Collection\CollectionInterface $bedHistories
 */
?>
<div class="bedHistories index content">
    <?= $this->Html->link(__('New Bed History'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bed Histories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('bed_id') ?></th>
                    <th><?= $this->Paginator->sort('room_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_name') ?></th>
                    <th><?= $this->Paginator->sort('registration_no') ?></th>
                    <th><?= $this->Paginator->sort('check_in_date') ?></th>
                    <th><?= $this->Paginator->sort('check_out_date') ?></th>
                    <th><?= $this->Paginator->sort('status_before') ?></th>
                    <th><?= $this->Paginator->sort('status_after') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bedHistories as $bedHistory): ?>
                <tr>
                    <td><?= $this->Number->format($bedHistory->id) ?></td>
                    <td><?= $bedHistory->has('bed') ? $this->Html->link($bedHistory->bed->name, ['prefix' => 'Master', 'controller' => 'Beds', 'action' => 'view', $bedHistory->bed->id]) : '' ?></td>
                    <td><?= $bedHistory->has('room') ? $this->Html->link($bedHistory->room->id, ['prefix' => 'Master', 'controller' => 'Rooms', 'action' => 'view', $bedHistory->room->id]) : '' ?></td>
                    <td><?= h($bedHistory->patient_name) ?></td>
                    <td><?= h($bedHistory->registration_no) ?></td>
                    <td><?= h($bedHistory->check_in_date) ?></td>
                    <td><?= h($bedHistory->check_out_date) ?></td>
                    <td><?= h($bedHistory->status_before) ?></td>
                    <td><?= h($bedHistory->status_after) ?></td>
                    <td><?= h($bedHistory->created_by) ?></td>
                    <td><?= h($bedHistory->created) ?></td>
                    <td><?= h($bedHistory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bedHistory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bedHistory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $bedHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bedHistory->id)]) ?>
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
