<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahKabupaten $daerahKabupaten
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $daerahKabupaten->id_kab],
                ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKabupaten->id_kab), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Daerah Kabupatens'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahKabupatens form content">
            <?= $this->Form->create($daerahKabupaten) ?>
            <fieldset>
                <legend><?= __('Edit Daerah Kabupaten') ?></legend>
                <?php
                    echo $this->Form->control('id_prov');
                    echo $this->Form->control('nama');
                    echo $this->Form->control('id_jenis');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
