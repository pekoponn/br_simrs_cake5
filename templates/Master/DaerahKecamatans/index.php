<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahKecamatan[]|\Cake\Collection\CollectionInterface $daerahKecamatans
 */
?>
<div class="daerahKecamatans index content">
    <?= $this->Html->link(__('New Daerah Kecamatan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Daerah Kecamatans') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id_kec') ?></th>
                    <th><?= $this->Paginator->sort('id_kab') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daerahKecamatans as $daerahKecamatan): ?>
                <tr>
                    <td><?= h($daerahKecamatan->id_kec) ?></td>
                    <td><?= h($daerahKecamatan->id_kab) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $daerahKecamatan->id_kec]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $daerahKecamatan->id_kec]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $daerahKecamatan->id_kec], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKecamatan->id_kec)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
