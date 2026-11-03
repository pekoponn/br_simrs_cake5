<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicineMerk $medicineMerk
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medicine Merk'), ['action' => 'edit', $medicineMerk->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medicine Merk'), ['action' => 'delete', $medicineMerk->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicineMerk->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medicine Merks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medicine Merk'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicineMerks view content">
            <h3><?= h($medicineMerk->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $medicineMerk->has('branch') ? $this->Html->link($medicineMerk->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $medicineMerk->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($medicineMerk->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($medicineMerk->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($medicineMerk->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($medicineMerk->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Img') ?></th>
                    <td><?= h($medicineMerk->img) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($medicineMerk->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Packaging') ?></th>
                    <td><?= h($medicineMerk->packaging) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($medicineMerk->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicineMerk->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Unit') ?></th>
                    <td><?= $this->Number->format($medicineMerk->qty_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Packaging') ?></th>
                    <td><?= $this->Number->format($medicineMerk->qty_packaging) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($medicineMerk->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($medicineMerk->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Print') ?></th>
                    <td><?= $this->Number->format($medicineMerk->is_print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicineMerk->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicineMerk->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Printed') ?></th>
                    <td><?= h($medicineMerk->printed) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicineMerk->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
