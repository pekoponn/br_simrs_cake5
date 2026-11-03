<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterSurgeryOperator $masterSurgeryOperator
 * @var string[]|\Cake\Collection\CollectionInterface $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $masterSurgeryOperator->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $masterSurgeryOperator->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Master Surgery Operators'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterSurgeryOperators form content">
            <?= $this->Form->create($masterSurgeryOperator) ?>
            <fieldset>
                <legend><?= __('Edit Master Surgery Operator') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('specialist');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
