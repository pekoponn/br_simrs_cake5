<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterRadiology $masterRadiology
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Radiology'), ['action' => 'edit', $masterRadiology->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Radiology'), ['action' => 'delete', $masterRadiology->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterRadiology->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Radiologies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Radiology'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterRadiologies view content">
            <h3><?= h($masterRadiology->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterRadiology->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterRadiology->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($masterRadiology->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterRadiology->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tariff') ?></th>
                    <td><?= $this->Number->format($masterRadiology->tariff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterRadiology->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterRadiology->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterRadiology->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
