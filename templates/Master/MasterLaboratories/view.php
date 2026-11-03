<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterLaboratory $masterLaboratory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Laboratory'), ['action' => 'edit', $masterLaboratory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Laboratory'), ['action' => 'delete', $masterLaboratory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterLaboratory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Laboratories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Laboratory'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterLaboratories view content">
            <h3><?= h($masterLaboratory->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterLaboratory->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterLaboratory->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($masterLaboratory->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterLaboratory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tariff') ?></th>
                    <td><?= $this->Number->format($masterLaboratory->tariff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterLaboratory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterLaboratory->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterLaboratory->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
