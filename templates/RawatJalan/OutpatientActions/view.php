<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientAction $outpatientAction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Outpatient Action'), ['action' => 'edit', $outpatientAction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Outpatient Action'), ['action' => 'delete', $outpatientAction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientAction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Outpatient Actions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Outpatient Action'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientActions view content">
            <h3><?= h($outpatientAction->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Outpatient Visit') ?></th>
                    <td><?= $outpatientAction->has('outpatient_visit') ? $this->Html->link($outpatientAction->outpatient_visit->id, ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'view', $outpatientAction->outpatient_visit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Master Tindakan') ?></th>
                    <td><?= $outpatientAction->has('master_tindakan') ? $this->Html->link($outpatientAction->master_tindakan->id, ['prefix' => 'Master', 'controller' => 'MasterTindakan', 'action' => 'view', $outpatientAction->master_tindakan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Action Code') ?></th>
                    <td><?= h($outpatientAction->action_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action Name') ?></th>
                    <td><?= h($outpatientAction->action_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action Category') ?></th>
                    <td><?= h($outpatientAction->action_category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Performed By') ?></th>
                    <td><?= h($outpatientAction->performed_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outpatientAction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($outpatientAction->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($outpatientAction->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $this->Number->format($outpatientAction->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Performed At') ?></th>
                    <td><?= h($outpatientAction->performed_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outpatientAction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($outpatientAction->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outpatientAction->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
