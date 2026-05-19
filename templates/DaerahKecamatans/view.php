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
            <?= $this->Html->link(__('Edit Daerah Kecamatan'), ['action' => 'edit', $daerahKecamatan->id_kec], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Daerah Kecamatan'), ['action' => 'delete', $daerahKecamatan->id_kec], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKecamatan->id_kec), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Daerah Kecamatans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Daerah Kecamatan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahKecamatans view content">
            <h3><?= h($daerahKecamatan->id_kec) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id Kec') ?></th>
                    <td><?= h($daerahKecamatan->id_kec) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Kab') ?></th>
                    <td><?= h($daerahKecamatan->id_kab) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Nama') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($daerahKecamatan->nama)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
