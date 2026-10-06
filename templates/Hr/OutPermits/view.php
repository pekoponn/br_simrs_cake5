<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutPermit $outPermit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Out Permit'), ['action' => 'edit', $outPermit->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Out Permit'), ['action' => 'delete', $outPermit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outPermit->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Out Permits'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Out Permit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outPermits view content">
            <h3><?= h($outPermit->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $outPermit->has('branch') ? $this->Html->link($outPermit->branch->name, ['controller' => 'Branches', 'action' => 'view', $outPermit->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($outPermit->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Devision') ?></th>
                    <td><?= h($outPermit->devision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= h($outPermit->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time From') ?></th>
                    <td><?= h($outPermit->time_from) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time End') ?></th>
                    <td><?= h($outPermit->time_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Files') ?></th>
                    <td><?= h($outPermit->files) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Approve') ?></th>
                    <td><?= h($outPermit->status_approve) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Knowing') ?></th>
                    <td><?= h($outPermit->status_knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($outPermit->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($outPermit->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($outPermit->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($outPermit->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outPermit->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Approve') ?></th>
                    <td><?= $this->Number->format($outPermit->is_approve) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Knowing') ?></th>
                    <td><?= $this->Number->format($outPermit->is_knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($outPermit->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= h($outPermit->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Knowing') ?></th>
                    <td><?= h($outPermit->knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outPermit->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($outPermit->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($outPermit->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outPermit->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Knowing Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outPermit->knowing_description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Approved Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outPermit->approved_description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outPermit->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
