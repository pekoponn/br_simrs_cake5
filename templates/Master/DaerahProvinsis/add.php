<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahProvinsi $daerahProvinsi
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Daerah Provinsis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahProvinsis form content">
            <?= $this->Form->create($daerahProvinsi) ?>
            <fieldset>
                <legend><?= __('Add Daerah Provinsi') ?></legend>
                <?php
                    echo $this->Form->control('nama');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
