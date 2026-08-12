<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankTopup $bankTopup
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bankTopup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bankTopup->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bank Topups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bankTopups form content">
            <?= $this->Form->create($bankTopup) ?>
            <fieldset>
                <legend><?= __('Edit Bank Topup') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('acc_coa_id');
                    echo $this->Form->control('payment_type');
                    echo $this->Form->control('nominal');
                    echo $this->Form->control('description');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
