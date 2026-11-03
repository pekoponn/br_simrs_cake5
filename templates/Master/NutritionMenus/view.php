<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NutritionMenu $nutritionMenu
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Nutrition Menu'), ['action' => 'edit', $nutritionMenu->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Nutrition Menu'), ['action' => 'delete', $nutritionMenu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nutritionMenu->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Nutrition Menus'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Nutrition Menu'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="nutritionMenus view content">
            <h3><?= h($nutritionMenu->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($nutritionMenu->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($nutritionMenu->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($nutritionMenu->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($nutritionMenu->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($nutritionMenu->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($nutritionMenu->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($nutritionMenu->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($nutritionMenu->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($nutritionMenu->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($nutritionMenu->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($nutritionMenu->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
