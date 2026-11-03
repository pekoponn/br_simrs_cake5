<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NutritionCombine $nutritionCombine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Nutrition Combine'), ['action' => 'edit', $nutritionCombine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Nutrition Combine'), ['action' => 'delete', $nutritionCombine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nutritionCombine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Nutrition Combine'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Nutrition Combine'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="nutritionCombine view content">
            <h3><?= h($nutritionCombine->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($nutritionCombine->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($nutritionCombine->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($nutritionCombine->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nutrition Content Name') ?></th>
                    <td><?= h($nutritionCombine->nutrition_content_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Content Unit') ?></th>
                    <td><?= h($nutritionCombine->content_unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($nutritionCombine->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($nutritionCombine->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nutritional Value') ?></th>
                    <td><?= $nutritionCombine->nutritional_value === null ? '' : $this->Number->format($nutritionCombine->nutritional_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($nutritionCombine->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($nutritionCombine->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Print') ?></th>
                    <td><?= $this->Number->format($nutritionCombine->is_print) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($nutritionCombine->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($nutritionCombine->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Printed') ?></th>
                    <td><?= h($nutritionCombine->printed) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($nutritionCombine->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
