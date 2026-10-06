<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployeeTraining $hrgaEmployeeTraining
 * @var string[]|\Cake\Collection\CollectionInterface $hrgaEmployees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $hrgaEmployeeTraining->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaEmployeeTraining->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Hrga Employee Trainings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaEmployeeTrainings form content">
            <?= $this->Form->create($hrgaEmployeeTraining) ?>
            <fieldset>
                <legend><?= __('Edit Hrga Employee Training') ?></legend>
                <?php
                    echo $this->Form->control('hrga_employee_id', ['options' => $hrgaEmployees, 'empty' => true]);
                    echo $this->Form->control('skill');
                    echo $this->Form->control('start_date', ['empty' => true]);
                    echo $this->Form->control('end_date', ['empty' => true]);
                    echo $this->Form->control('grade');
                    echo $this->Form->control('organizer');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
