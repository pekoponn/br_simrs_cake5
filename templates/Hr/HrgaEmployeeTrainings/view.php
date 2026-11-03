<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployeeTraining $hrgaEmployeeTraining
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Hrga Employee Training'), ['action' => 'edit', $hrgaEmployeeTraining->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Hrga Employee Training'), ['action' => 'delete', $hrgaEmployeeTraining->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaEmployeeTraining->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Hrga Employee Trainings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Hrga Employee Training'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaEmployeeTrainings view content">
            <h3><?= h($hrgaEmployeeTraining->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Hrga Employee') ?></th>
                    <td><?= $hrgaEmployeeTraining->has('hrga_employee') ? $this->Html->link($hrgaEmployeeTraining->hrga_employee->name, ['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'view', $hrgaEmployeeTraining->hrga_employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Skill') ?></th>
                    <td><?= h($hrgaEmployeeTraining->skill) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grade') ?></th>
                    <td><?= h($hrgaEmployeeTraining->grade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Organizer') ?></th>
                    <td><?= h($hrgaEmployeeTraining->organizer) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($hrgaEmployeeTraining->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($hrgaEmployeeTraining->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($hrgaEmployeeTraining->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Date') ?></th>
                    <td><?= h($hrgaEmployeeTraining->start_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($hrgaEmployeeTraining->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($hrgaEmployeeTraining->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($hrgaEmployeeTraining->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($hrgaEmployeeTraining->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
