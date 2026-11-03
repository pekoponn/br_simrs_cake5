<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahKecamatan $daerahKecamatan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $daerahKecamatan->id_kec],
                ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKecamatan->id_kec), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Daerah Kecamatans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahKecamatans form content">
            <?= $this->Form->create($daerahKecamatan) ?>
            <fieldset>
                <legend><?= __('Edit Daerah Kecamatan') ?></legend>
                <?php
                    echo $this->Form->control('id_kab');
                    echo $this->Form->control('nama');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
