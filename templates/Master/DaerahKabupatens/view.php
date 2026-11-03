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
            <?= $this->Html->link(__('Edit Daerah Kabupaten'), ['action' => 'edit', $daerahKabupaten->id_kab], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Daerah Kabupaten'), ['action' => 'delete', $daerahKabupaten->id_kab], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKabupaten->id_kab), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Daerah Kabupatens'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Daerah Kabupaten'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahKabupatens view content">
            <h3><?= h($daerahKabupaten->id_kab) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id Kab') ?></th>
                    <td><?= h($daerahKabupaten->id_kab) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Prov') ?></th>
                    <td><?= h($daerahKabupaten->id_prov) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Jenis') ?></th>
                    <td><?= $this->Number->format($daerahKabupaten->id_jenis) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Nama') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($daerahKabupaten->nama)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
