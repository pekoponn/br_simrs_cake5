<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterSupport $masterSupport
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Support'), ['action' => 'edit', $masterSupport->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Support'), ['action' => 'delete', $masterSupport->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterSupport->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Supports'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Support'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterSupports view content">
            <h3><?= h($masterSupport->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterSupport->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterSupport->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($masterSupport->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($masterSupport->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterSupport->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tariff') ?></th>
                    <td><?= $this->Number->format($masterSupport->tariff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterSupport->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterSupport->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterSupport->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($masterSupport->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
