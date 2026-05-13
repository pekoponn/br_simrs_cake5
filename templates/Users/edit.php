<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit User') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('code');
                    echo $this->Form->control('staff');
                    echo $this->Form->control('name');
                    echo $this->Form->control('password');
                    echo $this->Form->control('help_hint_pwd');
                    echo $this->Form->control('telp');
                    echo $this->Form->control('email');
                    echo $this->Form->control('devision');
                    echo $this->Form->control('position');
                    echo $this->Form->control('marketing_code');
                    echo $this->Form->control('approved');
                    echo $this->Form->control('approved_ceo');
                    echo $this->Form->control('payment');
                    echo $this->Form->control('pettycash_full_access');
                    echo $this->Form->control('hris_approved');
                    echo $this->Form->control('hris_knowing');
                    echo $this->Form->control('hris_full_access');
                    echo $this->Form->control('rule');
                    echo $this->Form->control('rules');
                    echo $this->Form->control('rule_acc');
                    echo $this->Form->control('jurnal_type_acc');
                    echo $this->Form->control('change_password');
                    echo $this->Form->control('change_password_date', ['empty' => true]);
                    echo $this->Form->control('reset');
                    echo $this->Form->control('reset_date', ['empty' => true]);
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                    echo $this->Form->control('who_create');
                    echo $this->Form->control('who_update');
                    echo $this->Form->control('last_login', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('level');
                    echo $this->Form->control('visited');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
