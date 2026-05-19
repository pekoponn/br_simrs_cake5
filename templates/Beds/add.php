<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var \Cake\Collection\CollectionInterface|string[] $rooms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Beds'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="beds form content">
            <?= $this->Form->create($bed) ?>
            <fieldset>
                <legend><?= __('Add Bed') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('room_id', ['options' => $rooms]);
                    echo $this->Form->control('bed_no');
                    echo $this->Form->control('name');
                    echo $this->Form->control('class_name');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('delete_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
