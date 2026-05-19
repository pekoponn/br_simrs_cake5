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
            <?= $this->Html->link(__('Edit Daerah Provinsi'), ['action' => 'edit', $daerahProvinsi->id_prov], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Daerah Provinsi'), ['action' => 'delete', $daerahProvinsi->id_prov], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahProvinsi->id_prov), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Daerah Provinsis'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Daerah Provinsi'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahProvinsis view content">
            <h3><?= h($daerahProvinsi->id_prov) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id Prov') ?></th>
                    <td><?= h($daerahProvinsi->id_prov) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Nama') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($daerahProvinsi->nama)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
