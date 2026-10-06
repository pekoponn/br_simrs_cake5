<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkOrder $workOrder
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $workOrder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $workOrder->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Work Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="workOrders form content">
            <?= $this->Form->create($workOrder) ?>
            <fieldset>
                <legend><?= __('Edit Work Order') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('is_approve');
                    echo $this->Form->control('approved', ['empty' => true]);
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
