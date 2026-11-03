<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTenagaMedi $masterTenagaMedi
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Tenaga Medi'), ['action' => 'edit', $masterTenagaMedi->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Tenaga Medi'), ['action' => 'delete', $masterTenagaMedi->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterTenagaMedi->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Tenaga Medis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Tenaga Medi'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterTenagaMedis view content">
            <h3><?= h($masterTenagaMedi->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Kode') ?></th>
                    <td><?= h($masterTenagaMedi->kode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama') ?></th>
                    <td><?= h($masterTenagaMedi->nama) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($masterTenagaMedi->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterTenagaMedi->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterTenagaMedi->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterTenagaMedi->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterTenagaMedi->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
