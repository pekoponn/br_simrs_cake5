<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PharmacyItem $pharmacyItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pharmacy Item'), ['action' => 'edit', $pharmacyItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pharmacy Item'), ['action' => 'delete', $pharmacyItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pharmacyItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pharmacy Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pharmacy Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pharmacyItems view content">
            <h3><?= h($pharmacyItem->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($pharmacyItem->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Region') ?></th>
                    <td><?= h($pharmacyItem->region) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($pharmacyItem->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($pharmacyItem->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Purchase Unit') ?></th>
                    <td><?= h($pharmacyItem->purchase_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sale Unit') ?></th>
                    <td><?= h($pharmacyItem->sale_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Therapy Class') ?></th>
                    <td><?= h($pharmacyItem->therapy_class) ?></td>
                </tr>
                <tr>
                    <th><?= __('Group Name') ?></th>
                    <td><?= h($pharmacyItem->group_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Producer') ?></th>
                    <td><?= h($pharmacyItem->producer) ?></td>
                </tr>
                <tr>
                    <th><?= __('Medicine Type') ?></th>
                    <td><?= h($pharmacyItem->medicine_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formula Name') ?></th>
                    <td><?= h($pharmacyItem->formula_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($pharmacyItem->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pharmacyItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Qjb') ?></th>
                    <td><?= $pharmacyItem->qjb === null ? '' : $this->Number->format($pharmacyItem->qjb) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cbg Rate') ?></th>
                    <td><?= $pharmacyItem->cbg_rate === null ? '' : $this->Number->format($pharmacyItem->cbg_rate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Formula Percentage') ?></th>
                    <td><?= $pharmacyItem->formula_percentage === null ? '' : $this->Number->format($pharmacyItem->formula_percentage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hpp') ?></th>
                    <td><?= $pharmacyItem->hpp === null ? '' : $this->Number->format($pharmacyItem->hpp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sale Price') ?></th>
                    <td><?= $pharmacyItem->sale_price === null ? '' : $this->Number->format($pharmacyItem->sale_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($pharmacyItem->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($pharmacyItem->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($pharmacyItem->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pharmacyItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pharmacyItem->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($pharmacyItem->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($pharmacyItem->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
