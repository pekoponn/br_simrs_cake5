<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $polyclinicQueue
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Polyclinic Queue'), ['action' => 'edit', $polyclinicQueue->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Polyclinic Queue'), ['action' => 'delete', $polyclinicQueue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $polyclinicQueue->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Polyclinic Queues'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Polyclinic Queue'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="polyclinicQueues view content">
            <h3><?= h($polyclinicQueue->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($polyclinicQueue->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Source') ?></th>
                    <td><?= h($polyclinicQueue->source) ?></td>
                </tr>
                <tr>
                    <th><?= __('Poly Name') ?></th>
                    <td><?= h($polyclinicQueue->poly_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patients Name') ?></th>
                    <td><?= h($polyclinicQueue->patients_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Telp') ?></th>
                    <td><?= h($polyclinicQueue->no_telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($polyclinicQueue->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($polyclinicQueue->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Queue Number') ?></th>
                    <td><?= $this->Number->format($polyclinicQueue->queue_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($polyclinicQueue->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($polyclinicQueue->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($polyclinicQueue->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($polyclinicQueue->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($polyclinicQueue->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($polyclinicQueue->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($polyclinicQueue->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
