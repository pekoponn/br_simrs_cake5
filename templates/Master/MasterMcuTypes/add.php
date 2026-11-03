<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterMcuType $masterMcuType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Master Mcu Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterMcuTypes form content">
            <?= $this->Form->create($masterMcuType) ?>
            <fieldset>
                <legend><?= __('Add Master Mcu Type') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_delete');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
