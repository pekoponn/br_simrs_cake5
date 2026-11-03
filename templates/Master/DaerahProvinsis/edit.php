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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $daerahProvinsi->id_prov],
                ['confirm' => __('Are you sure you want to delete # {0}?', $daerahProvinsi->id_prov), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Daerah Provinsis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahProvinsis form content">
            <?= $this->Form->create($daerahProvinsi) ?>
            <fieldset>
                <legend><?= __('Edit Daerah Provinsi') ?></legend>
                <?php
                    echo $this->Form->control('nama');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
