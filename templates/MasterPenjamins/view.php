<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterPenjamin $masterPenjamin
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Penjamin'), ['action' => 'edit', $masterPenjamin->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Penjamin'), ['action' => 'delete', $masterPenjamin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterPenjamin->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Penjamins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Penjamin'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterPenjamins view content">
            <h3><?= h($masterPenjamin->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterPenjamin->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterPenjamin->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($masterPenjamin->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($masterPenjamin->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterPenjamin->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterPenjamin->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterPenjamin->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
