<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal $accJournal
 * @var string[]|\Cake\Collection\CollectionInterface $branches
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 * @var string[]|\Cake\Collection\CollectionInterface $recipientPayers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $accJournal->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accJournal->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Acc Journals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accJournals form content">
            <?= $this->Form->create($accJournal) ?>
            <fieldset>
                <legend><?= __('Edit Acc Journal') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('number');
                    echo $this->Form->control('journal_sub_id');
                    echo $this->Form->control('code_old');
                    echo $this->Form->control('code');
                    echo $this->Form->control('customer_id_ori');
                    echo $this->Form->control('customer_id', ['options' => $customers, 'empty' => true]);
                    echo $this->Form->control('journal_type');
                    echo $this->Form->control('tax');
                    echo $this->Form->control('name');
                    echo $this->Form->control('subject');
                    echo $this->Form->control('cek_bg');
                    echo $this->Form->control('recipient_payer_id', ['options' => $recipientPayers, 'empty' => true]);
                    echo $this->Form->control('recipient_payer_name');
                    echo $this->Form->control('recipient_payer_code');
                    echo $this->Form->control('date', ['empty' => true]);
                    echo $this->Form->control('date_posting', ['empty' => true]);
                    echo $this->Form->control('payment_type');
                    echo $this->Form->control('no_cek');
                    echo $this->Form->control('no_ref');
                    echo $this->Form->control('warkat_date', ['empty' => true]);
                    echo $this->Form->control('job');
                    echo $this->Form->control('balance');
                    echo $this->Form->control('grand_total');
                    echo $this->Form->control('description');
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
