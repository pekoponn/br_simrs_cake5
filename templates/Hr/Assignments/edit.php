<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Assignment $assignment
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $assignment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assignment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Assignments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="assignments form content">
            <?= $this->Form->create($assignment) ?>
            <fieldset>
                <legend><?= __('Edit Assignment') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('code');
                    echo $this->Form->control('devision');
                    echo $this->Form->control('position');
                    echo $this->Form->control('date_from', ['empty' => true]);
                    echo $this->Form->control('date_end', ['empty' => true]);
                    echo $this->Form->control('time_from');
                    echo $this->Form->control('time_end');
                    echo $this->Form->control('description');
                    echo $this->Form->control('knowing_description');
                    echo $this->Form->control('approved_description');
                    echo $this->Form->control('is_approve');
                    echo $this->Form->control('status_approve');
                    echo $this->Form->control('approved', ['empty' => true]);
                    echo $this->Form->control('is_knowing');
                    echo $this->Form->control('status_knowing');
                    echo $this->Form->control('knowing', ['empty' => true]);
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
