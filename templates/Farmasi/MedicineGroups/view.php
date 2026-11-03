<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicineGroup $medicineGroup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medicine Group'), ['action' => 'edit', $medicineGroup->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medicine Group'), ['action' => 'delete', $medicineGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicineGroup->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medicine Groups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medicine Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicineGroups view content">
            <h3><?= h($medicineGroup->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $medicineGroup->has('branch') ? $this->Html->link($medicineGroup->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $medicineGroup->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($medicineGroup->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($medicineGroup->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($medicineGroup->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($medicineGroup->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Img') ?></th>
                    <td><?= h($medicineGroup->img) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($medicineGroup->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Packaging') ?></th>
                    <td><?= h($medicineGroup->packaging) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($medicineGroup->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicineGroup->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Unit') ?></th>
                    <td><?= $this->Number->format($medicineGroup->qty_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qty Packaging') ?></th>
                    <td><?= $this->Number->format($medicineGroup->qty_packaging) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($medicineGroup->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($medicineGroup->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Print') ?></th>
                    <td><?= $this->Number->format($medicineGroup->is_print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicineGroup->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicineGroup->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Printed') ?></th>
                    <td><?= h($medicineGroup->printed) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicineGroup->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
