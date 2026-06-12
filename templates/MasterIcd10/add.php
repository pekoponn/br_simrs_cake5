<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterIcd10 $masterIcd10
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Master Icd10'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterIcd10 form content">
            <?= $this->Form->create($masterIcd10) ?>
            <fieldset>
                <legend><?= __('Add Master Icd10') ?></legend>
                <?php
                    echo $this->Form->control('kode');
                    echo $this->Form->control('nama');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
