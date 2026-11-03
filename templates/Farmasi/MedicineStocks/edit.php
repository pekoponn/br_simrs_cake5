<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicineStock $medicineStock
 * @var string[]|\Cake\Collection\CollectionInterface $medicines
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $medicineStock->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $medicineStock->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Medicine Stocks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicineStocks form content">
            <?= $this->Form->create($medicineStock) ?>
            <fieldset>
                <legend><?= __('Edit Medicine Stock') ?></legend>
                <?php
                    echo $this->Form->control('branch_id');
                    echo $this->Form->control('medicine_id', ['options' => $medicines]);
                    echo $this->Form->control('last_so_date', ['empty' => true]);
                    echo $this->Form->control('hasil_so');
                    echo $this->Form->control('adjustment');
                    echo $this->Form->control('terima');
                    echo $this->Form->control('keluar');
                    echo $this->Form->control('saldo_akhir');
                    echo $this->Form->control('max_stock');
                    echo $this->Form->control('is_valid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
