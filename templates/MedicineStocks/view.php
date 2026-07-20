<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicineStock $medicineStock
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medicine Stock'), ['action' => 'edit', $medicineStock->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medicine Stock'), ['action' => 'delete', $medicineStock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicineStock->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medicine Stocks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medicine Stock'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicineStocks view content">
            <h3><?= h($medicineStock->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Medicine') ?></th>
                    <td><?= $medicineStock->has('medicine') ? $this->Html->link($medicineStock->medicine->name, ['controller' => 'Medicines', 'action' => 'view', $medicineStock->medicine->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Valid') ?></th>
                    <td><?= h($medicineStock->is_valid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicineStock->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Branch Id') ?></th>
                    <td><?= $this->Number->format($medicineStock->branch_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hasil So') ?></th>
                    <td><?= $this->Number->format($medicineStock->hasil_so) ?></td>
                </tr>
                <tr>
                    <th><?= __('Adjustment') ?></th>
                    <td><?= $this->Number->format($medicineStock->adjustment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Terima') ?></th>
                    <td><?= $this->Number->format($medicineStock->terima) ?></td>
                </tr>
                <tr>
                    <th><?= __('Keluar') ?></th>
                    <td><?= $this->Number->format($medicineStock->keluar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Saldo Akhir') ?></th>
                    <td><?= $this->Number->format($medicineStock->saldo_akhir) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Stock') ?></th>
                    <td><?= $this->Number->format($medicineStock->max_stock) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last So Date') ?></th>
                    <td><?= h($medicineStock->last_so_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicineStock->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicineStock->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
