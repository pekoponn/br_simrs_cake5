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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $masterIcd10->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $masterIcd10->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Master Icd10'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterIcd10 form content">
            <?= $this->Form->create($masterIcd10) ?>
            <fieldset>
                <legend><?= __('Edit Master Icd10') ?></legend>
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
