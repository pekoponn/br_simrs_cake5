<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterOperationType $masterOperationType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Operation Type'), ['action' => 'edit', $masterOperationType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Operation Type'), ['action' => 'delete', $masterOperationType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterOperationType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Operation Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Operation Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterOperationTypes view content">
            <h3><?= h($masterOperationType->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterOperationType->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterOperationType->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($masterOperationType->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($masterOperationType->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterOperationType->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tariff') ?></th>
                    <td><?= $this->Number->format($masterOperationType->tariff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jasa Rs') ?></th>
                    <td><?= $this->Number->format($masterOperationType->jasa_rs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jasa Dr') ?></th>
                    <td><?= $this->Number->format($masterOperationType->jasa_dr) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jasa Paramedis') ?></th>
                    <td><?= $this->Number->format($masterOperationType->jasa_paramedis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterOperationType->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterOperationType->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterOperationType->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($masterOperationType->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
