<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DaerahProvinsi[]|\Cake\Collection\CollectionInterface $daerahProvinsis
 */
?>
<div class="daerahProvinsis index content">
    <?= $this->Html->link(__('New Daerah Provinsi'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Daerah Provinsis') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id_prov') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daerahProvinsis as $daerahProvinsi): ?>
                <tr>
                    <td><?= h($daerahProvinsi->id_prov) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $daerahProvinsi->id_prov]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $daerahProvinsi->id_prov]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $daerahProvinsi->id_prov], ['confirm' => __('Are you sure you want to delete # {0}?', $daerahProvinsi->id_prov)]) ?>
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
