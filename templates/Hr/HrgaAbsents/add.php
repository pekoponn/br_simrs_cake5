<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaAbsent $hrgaAbsent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Hrga Absents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaAbsents form content">
            <?= $this->Form->create($hrgaAbsent) ?>
            <fieldset>
                <legend><?= __('Add Hrga Absent') ?></legend>
                <?php
                    echo $this->Form->control('employee_id');
                    echo $this->Form->control('date_start', ['empty' => true]);
                    echo $this->Form->control('date_end', ['empty' => true]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
