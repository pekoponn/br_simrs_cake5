<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTenagaMedi $masterTenagaMedi
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $masterTenagaMedi->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $masterTenagaMedi->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Master Tenaga Medis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterTenagaMedis form content">
            <?= $this->Form->create($masterTenagaMedi) ?>
            <fieldset>
                <legend><?= __('Edit Master Tenaga Medi') ?></legend>
                <?php
                    echo $this->Form->control('kode');
                    echo $this->Form->control('nama');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
