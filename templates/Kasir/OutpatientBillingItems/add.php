<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBillingItem $outpatientBillingItem
 * @var \Cake\Collection\CollectionInterface|string[] $outpatientBillings
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Outpatient Billing Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientBillingItems form content">
            <?= $this->Form->create($outpatientBillingItem) ?>
            <fieldset>
                <legend><?= __('Add Outpatient Billing Item') ?></legend>
                <?php
                    echo $this->Form->control('billing_id', ['options' => $outpatientBillings]);
                    echo $this->Form->control('item_type');
                    echo $this->Form->control('item_code');
                    echo $this->Form->control('item_name');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('unit');
                    echo $this->Form->control('unit_price');
                    echo $this->Form->control('total_price');
                    echo $this->Form->control('discount_amount');
                    echo $this->Form->control('final_price');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('is_covered');
                    echo $this->Form->control('sort_order');
                    echo $this->Form->control('is_delete');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
