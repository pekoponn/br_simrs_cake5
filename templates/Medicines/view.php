<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicine $medicine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medicine'), ['action' => 'edit', $medicine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medicine'), ['action' => 'delete', $medicine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medicines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medicine'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicines view content">
            <h3><?= h($medicine->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $medicine->has('branch') ? $this->Html->link($medicine->branch->name, ['controller' => 'Branches', 'action' => 'view', $medicine->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Medicine Merk') ?></th>
                    <td><?= $medicine->has('medicine_merk') ? $this->Html->link($medicine->medicine_merk->name, ['controller' => 'MedicineMerks', 'action' => 'view', $medicine->medicine_merk->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Medicine Group') ?></th>
                    <td><?= $medicine->has('medicine_group') ? $this->Html->link($medicine->medicine_group->name, ['controller' => 'MedicineGroups', 'action' => 'view', $medicine->medicine_group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($medicine->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Kfa') ?></th>
                    <td><?= h($medicine->code_kfa) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($medicine->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Ifrs') ?></th>
                    <td><?= h($medicine->code_ifrs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Merk') ?></th>
                    <td><?= h($medicine->merk) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($medicine->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($medicine->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Img') ?></th>
                    <td><?= h($medicine->img) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($medicine->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Packaging') ?></th>
                    <td><?= h($medicine->packaging) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($medicine->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicine->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Unit') ?></th>
                    <td><?= $this->Number->format($medicine->qty_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Packaging') ?></th>
                    <td><?= $this->Number->format($medicine->qty_packaging) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($medicine->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($medicine->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Print') ?></th>
                    <td><?= $this->Number->format($medicine->is_print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicine->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicine->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Printed') ?></th>
                    <td><?= h($medicine->printed) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicine->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
