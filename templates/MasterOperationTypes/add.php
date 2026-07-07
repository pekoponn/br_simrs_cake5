<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterOperationType $masterOperationType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Master Operation Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterOperationTypes form content">
            <?= $this->Form->create($masterOperationType) ?>
            <fieldset>
                <legend><?= __('Add Master Operation Type') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('name');
                    echo $this->Form->control('category');
                    echo $this->Form->control('tariff');
                    echo $this->Form->control('jasa_rs');
                    echo $this->Form->control('jasa_dr');
                    echo $this->Form->control('jasa_paramedis');
                    echo $this->Form->control('unit');
                    echo $this->Form->control('description');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
