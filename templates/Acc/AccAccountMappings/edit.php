<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccAccountMapping $accAccountMapping
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 * @var string[]|\Cake\Collection\CollectionInterface $accChartOfAccounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $accAccountMapping->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accAccountMapping->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Acc Account Mappings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accAccountMappings form content">
            <?= $this->Form->create($accAccountMapping) ?>
            <fieldset>
                <legend><?= __('Edit Acc Account Mapping') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('acc_chart_of_account_id', ['options' => $accChartOfAccounts, 'empty' => true]);
                    echo $this->Form->control('group');
                    echo $this->Form->control('name');
                    echo $this->Form->control('desc');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
