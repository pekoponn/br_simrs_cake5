<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterMcuType $masterMcuType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Mcu Type'), ['action' => 'edit', $masterMcuType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Mcu Type'), ['action' => 'delete', $masterMcuType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterMcuType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Mcu Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Mcu Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterMcuTypes view content">
            <h3><?= h($masterMcuType->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterMcuType->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterMcuType->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterMcuType->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterMcuType->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterMcuType->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterMcuType->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $masterMcuType->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($masterMcuType->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
