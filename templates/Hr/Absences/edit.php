<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Absence $absence
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $absence->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $absence->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Absences'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="absences form content">
            <?= $this->Form->create($absence) ?>
            <fieldset>
                <legend><?= __('Edit Absence') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('latitude');
                    echo $this->Form->control('longitude');
                    echo $this->Form->control('address');
                    echo $this->Form->control('location');
                    echo $this->Form->control('expression');
                    echo $this->Form->control('inout_mode');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('time_in');
                    echo $this->Form->control('time_out');
                    echo $this->Form->control('description');
                    echo $this->Form->control('device');
                    echo $this->Form->control('browser_type');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('delete_log');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
