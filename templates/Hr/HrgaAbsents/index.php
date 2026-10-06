<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaAbsent[]|\Cake\Collection\CollectionInterface $hrgaAbsents
 */
?>
<div class="hrgaAbsents index content">
    <?= $this->Html->link(__('New Hrga Absent'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Hrga Absents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('date_start') ?></th>
                    <th><?= $this->Paginator->sort('date_end') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
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
                <?php foreach ($hrgaAbsents as $hrgaAbsent): ?>
                <tr>
                    <td><?= $this->Number->format($hrgaAbsent->id) ?></td>
                    <td><?= $this->Number->format($hrgaAbsent->employee_id) ?></td>
                    <td><?= h($hrgaAbsent->date_start) ?></td>
                    <td><?= h($hrgaAbsent->date_end) ?></td>
                    <td><?= h($hrgaAbsent->description) ?></td>
                    <td><?= $this->Number->format($hrgaAbsent->is_create) ?></td>
                    <td><?= h($hrgaAbsent->created) ?></td>
                    <td><?= $this->Number->format($hrgaAbsent->is_update) ?></td>
                    <td><?= h($hrgaAbsent->modified) ?></td>
                    <td><?= h($hrgaAbsent->status) ?></td>
                    <td><?= h($hrgaAbsent->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $hrgaAbsent->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $hrgaAbsent->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $hrgaAbsent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaAbsent->id)]) ?>
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
