<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $customer->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="customers form content">
            <?= $this->Form->create($customer) ?>
            <fieldset>
                <legend><?= __('Edit Customer') ?></legend>
                <?php
                    echo $this->Form->control('branch_id', ['options' => $branches]);
                    echo $this->Form->control('code_ori');
                    echo $this->Form->control('code');
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('marketing_id');
                    echo $this->Form->control('data_invoice_id', ['options' => $dataInvoices, 'empty' => true]);
                    echo $this->Form->control('data_tax_id', ['options' => $dataTaxes, 'empty' => true]);
                    echo $this->Form->control('mou_id');
                    echo $this->Form->control('title');
                    echo $this->Form->control('title_old');
                    echo $this->Form->control('nickname');
                    echo $this->Form->control('nickname_old');
                    echo $this->Form->control('name');
                    echo $this->Form->control('name_old');
                    echo $this->Form->control('name_fake');
                    echo $this->Form->control('check_fake');
                    echo $this->Form->control('deposit_mou');
                    echo $this->Form->control('type');
                    echo $this->Form->control('group');
                    echo $this->Form->control('practice_day');
                    echo $this->Form->control('practice_hours_start');
                    echo $this->Form->control('practice_hours_end');
                    echo $this->Form->control('tax');
                    echo $this->Form->control('taxing');
                    echo $this->Form->control('pph');
                    echo $this->Form->control('va');
                    echo $this->Form->control('treatment');
                    echo $this->Form->control('contact_person');
                    echo $this->Form->control('dept_person');
                    echo $this->Form->control('telp_person');
                    echo $this->Form->control('warehouse_address');
                    echo $this->Form->control('warehouse_telp');
                    echo $this->Form->control('address_penghasil');
                    echo $this->Form->control('supplier');
                    echo $this->Form->control('address_supplier');
                    echo $this->Form->control('phone_supplier');
                    echo $this->Form->control('fax_supplier');
                    echo $this->Form->control('name_invoice');
                    echo $this->Form->control('address_invoice');
                    echo $this->Form->control('phone_invoice');
                    echo $this->Form->control('fax_invoice');
                    echo $this->Form->control('name_tax_invoice');
                    echo $this->Form->control('address_tax_invoice');
                    echo $this->Form->control('phone_tax_invoice');
                    echo $this->Form->control('fax_tax_invoice');
                    echo $this->Form->control('bank_an_ori');
                    echo $this->Form->control('bank_name_ori');
                    echo $this->Form->control('bank_norek_ori');
                    echo $this->Form->control('bank_an');
                    echo $this->Form->control('bank_name');
                    echo $this->Form->control('bank_norek');
                    echo $this->Form->control('va_an');
                    echo $this->Form->control('va_name');
                    echo $this->Form->control('va_no');
                    echo $this->Form->control('giro_no');
                    echo $this->Form->control('rek_name');
                    echo $this->Form->control('rek_no');
                    echo $this->Form->control('rek_bank');
                    echo $this->Form->control('npwp');
                    echo $this->Form->control('ppn');
                    echo $this->Form->control('city');
                    echo $this->Form->control('province');
                    echo $this->Form->control('district');
                    echo $this->Form->control('postal');
                    echo $this->Form->control('country');
                    echo $this->Form->control('phone3');
                    echo $this->Form->control('phone4');
                    echo $this->Form->control('phone5');
                    echo $this->Form->control('email1');
                    echo $this->Form->control('email2');
                    echo $this->Form->control('email3');
                    echo $this->Form->control('email4');
                    echo $this->Form->control('email5');
                    echo $this->Form->control('fb1');
                    echo $this->Form->control('fb2');
                    echo $this->Form->control('ym1');
                    echo $this->Form->control('ym2');
                    echo $this->Form->control('ym3');
                    echo $this->Form->control('ym4');
                    echo $this->Form->control('ym5');
                    echo $this->Form->control('system');
                    echo $this->Form->control('website');
                    echo $this->Form->control('beginning_balance');
                    echo $this->Form->control('platform');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                    echo $this->Form->control('who_create');
                    echo $this->Form->control('who_update');
                    echo $this->Form->control('active');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
