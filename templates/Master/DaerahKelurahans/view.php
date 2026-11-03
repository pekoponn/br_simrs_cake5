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
            <?= $this->Html->link(__('Edit Daerah Kelurahan'), ['action' => 'edit', $daerahKelurahan->id_kel], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Daerah Kelurahan'), ['action' => 'delete', $daerahKelurahan->id_kel], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKelurahan->id_kel), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Daerah Kelurahans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Daerah Kelurahan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="daerahKelurahans view content">
            <h3><?= h($daerahKelurahan->id_kel) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id Kel') ?></th>
                    <td><?= h($daerahKelurahan->id_kel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Kec') ?></th>
                    <td><?= h($daerahKelurahan->id_kec) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id Jenis') ?></th>
                    <td><?= $this->Number->format($daerahKelurahan->id_jenis) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Nama') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($daerahKelurahan->nama)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
