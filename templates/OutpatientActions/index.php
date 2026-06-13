<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientAction[]|\Cake\Collection\CollectionInterface $outpatientActions
 */
?>
<div class="outpatientActions index content">
    <?= $this->Html->link(__('New Outpatient Action'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Outpatient Actions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('outpatient_visit_id') ?></th>
                    <th><?= $this->Paginator->sort('master_tindakan_id') ?></th>
                    <th><?= $this->Paginator->sort('action_code') ?></th>
                    <th><?= $this->Paginator->sort('action_name') ?></th>
                    <th><?= $this->Paginator->sort('action_category') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('total_price') ?></th>
                    <th><?= $this->Paginator->sort('performed_by') ?></th>
                    <th><?= $this->Paginator->sort('performed_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outpatientActions as $outpatientAction): ?>
                <tr>
                    <td><?= $this->Number->format($outpatientAction->id) ?></td>
                    <td><?= $outpatientAction->has('outpatient_visit') ? $this->Html->link($outpatientAction->outpatient_visit->id, ['controller' => 'OutpatientVisits', 'action' => 'view', $outpatientAction->outpatient_visit->id]) : '' ?></td>
                    <td><?= $outpatientAction->has('master_tindakan') ? $this->Html->link($outpatientAction->master_tindakan->id, ['controller' => 'MasterTindakan', 'action' => 'view', $outpatientAction->master_tindakan->id]) : '' ?></td>
                    <td><?= h($outpatientAction->action_code) ?></td>
                    <td><?= h($outpatientAction->action_name) ?></td>
                    <td><?= h($outpatientAction->action_category) ?></td>
                    <td><?= $this->Number->format($outpatientAction->quantity) ?></td>
                    <td><?= $this->Number->format($outpatientAction->unit_price) ?></td>
                    <td><?= $this->Number->format($outpatientAction->total_price) ?></td>
                    <td><?= h($outpatientAction->performed_by) ?></td>
                    <td><?= h($outpatientAction->performed_at) ?></td>
                    <td><?= h($outpatientAction->created) ?></td>
                    <td><?= h($outpatientAction->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $outpatientAction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outpatientAction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outpatientAction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientAction->id)]) ?>
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
