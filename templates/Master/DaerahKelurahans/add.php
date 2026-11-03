<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahKelurahan $daerahKelurahan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Daerah Kelurahans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahKelurahans form content">
            <?= $this->Form->create($daerahKelurahan) ?>
            <fieldset>
                <legend><?= __('Add Daerah Kelurahan') ?></legend>
                <?php
                    echo $this->Form->control('id_kec');
                    echo $this->Form->control('nama');
                    echo $this->Form->control('id_jenis');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
