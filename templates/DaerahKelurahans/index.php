<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahKelurahan[]|\Cake\Collection\CollectionInterface $daerahKelurahans
 */
?>
<div class="daerahKelurahans index content">
    <?= $this->Html->link(__('New Daerah Kelurahan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Daerah Kelurahans') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id_kel') ?></th>
                    <th><?= $this->Paginator->sort('id_kec') ?></th>
                    <th><?= $this->Paginator->sort('id_jenis') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daerahKelurahans as $daerahKelurahan): ?>
                <tr>
                    <td><?= h($daerahKelurahan->id_kel) ?></td>
                    <td><?= h($daerahKelurahan->id_kec) ?></td>
                    <td><?= $this->Number->format($daerahKelurahan->id_jenis) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $daerahKelurahan->id_kel]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $daerahKelurahan->id_kel]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $daerahKelurahan->id_kel], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahKelurahan->id_kel)]) ?>
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
