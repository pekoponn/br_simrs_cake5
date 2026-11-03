<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterSurgeryOperator $masterSurgeryOperator
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Surgery Operator'), ['action' => 'edit', $masterSurgeryOperator->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Surgery Operator'), ['action' => 'delete', $masterSurgeryOperator->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterSurgeryOperator->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Surgery Operators'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Surgery Operator'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterSurgeryOperators view content">
            <h3><?= h($masterSurgeryOperator->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterSurgeryOperator->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $masterSurgeryOperator->has('doctor') ? $this->Html->link($masterSurgeryOperator->doctor->doctor_name, ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'view', $masterSurgeryOperator->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterSurgeryOperator->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Specialist') ?></th>
                    <td><?= h($masterSurgeryOperator->specialist) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($masterSurgeryOperator->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterSurgeryOperator->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterSurgeryOperator->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterSurgeryOperator->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $masterSurgeryOperator->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($masterSurgeryOperator->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
