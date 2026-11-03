<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $polyclinicQueue
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $polyclinicQueue->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $polyclinicQueue->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Polyclinic Queues'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="polyclinicQueues form content">
            <?= $this->Form->create($polyclinicQueue) ?>
            <fieldset>
                <legend><?= __('Edit Polyclinic Queue') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('source');
                    echo $this->Form->control('poly_name');
                    echo $this->Form->control('patients_name');
                    echo $this->Form->control('no_telp');
                    echo $this->Form->control('queue_number');
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
