<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AbsentIssue $absentIssue
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $absentIssue->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $absentIssue->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Absent Issues'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="absentIssues form content">
            <?= $this->Form->create($absentIssue) ?>
            <fieldset>
                <legend><?= __('Edit Absent Issue') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('file_1');
                    echo $this->Form->control('file_2');
                    echo $this->Form->control('description');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_done');
                    echo $this->Form->control('doned', ['empty' => true]);
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
