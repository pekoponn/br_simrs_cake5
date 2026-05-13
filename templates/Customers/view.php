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
            <?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="customers view content">
            <h3><?= h($customer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $customer->has('branch') ? $this->Html->link($customer->branch->name, ['controller' => 'Branches', 'action' => 'view', $customer->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Ori') ?></th>
                    <td><?= h($customer->code_ori) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($customer->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $customer->has('user') ? $this->Html->link($customer->user->name, ['controller' => 'Users', 'action' => 'view', $customer->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Invoice') ?></th>
                    <td><?= $customer->has('data_invoice') ? $this->Html->link($customer->data_invoice->name, ['controller' => 'DataInvoices', 'action' => 'view', $customer->data_invoice->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Tax') ?></th>
                    <td><?= $customer->has('data_tax') ? $this->Html->link($customer->data_tax->name, ['controller' => 'DataTaxes', 'action' => 'view', $customer->data_tax->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($customer->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title Old') ?></th>
                    <td><?= h($customer->title_old) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nickname') ?></th>
                    <td><?= h($customer->nickname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nickname Old') ?></th>
                    <td><?= h($customer->nickname_old) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($customer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name Old') ?></th>
                    <td><?= h($customer->name_old) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name Fake') ?></th>
                    <td><?= h($customer->name_fake) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check Fake') ?></th>
                    <td><?= h($customer->check_fake) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deposit Mou') ?></th>
                    <td><?= h($customer->deposit_mou) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($customer->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= h($customer->group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Practice Day') ?></th>
                    <td><?= h($customer->practice_day) ?></td>
                </tr>
                <tr>
                    <th><?= __('Practice Hours Start') ?></th>
                    <td><?= h($customer->practice_hours_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Practice Hours End') ?></th>
                    <td><?= h($customer->practice_hours_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax') ?></th>
                    <td><?= h($customer->tax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pph') ?></th>
                    <td><?= h($customer->pph) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va') ?></th>
                    <td><?= h($customer->va) ?></td>
                </tr>
                <tr>
                    <th><?= __('Treatment') ?></th>
                    <td><?= h($customer->treatment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact Person') ?></th>
                    <td><?= h($customer->contact_person) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dept Person') ?></th>
                    <td><?= h($customer->dept_person) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telp Person') ?></th>
                    <td><?= h($customer->telp_person) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warehouse Address') ?></th>
                    <td><?= h($customer->warehouse_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warehouse Telp') ?></th>
                    <td><?= h($customer->warehouse_telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Supplier') ?></th>
                    <td><?= h($customer->supplier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Supplier') ?></th>
                    <td><?= h($customer->phone_supplier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax Supplier') ?></th>
                    <td><?= h($customer->fax_supplier) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name Invoice') ?></th>
                    <td><?= h($customer->name_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Invoice') ?></th>
                    <td><?= h($customer->phone_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax Invoice') ?></th>
                    <td><?= h($customer->fax_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name Tax Invoice') ?></th>
                    <td><?= h($customer->name_tax_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Tax Invoice') ?></th>
                    <td><?= h($customer->phone_tax_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax Tax Invoice') ?></th>
                    <td><?= h($customer->fax_tax_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An Ori') ?></th>
                    <td><?= h($customer->bank_an_ori) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name Ori') ?></th>
                    <td><?= h($customer->bank_name_ori) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek Ori') ?></th>
                    <td><?= h($customer->bank_norek_ori) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An') ?></th>
                    <td><?= h($customer->bank_an) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name') ?></th>
                    <td><?= h($customer->bank_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek') ?></th>
                    <td><?= h($customer->bank_norek) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va An') ?></th>
                    <td><?= h($customer->va_an) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va Name') ?></th>
                    <td><?= h($customer->va_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va No') ?></th>
                    <td><?= h($customer->va_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Giro No') ?></th>
                    <td><?= h($customer->giro_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rek Name') ?></th>
                    <td><?= h($customer->rek_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rek No') ?></th>
                    <td><?= h($customer->rek_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rek Bank') ?></th>
                    <td><?= h($customer->rek_bank) ?></td>
                </tr>
                <tr>
                    <th><?= __('Npwp') ?></th>
                    <td><?= h($customer->npwp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ppn') ?></th>
                    <td><?= h($customer->ppn) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($customer->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('Province') ?></th>
                    <td><?= h($customer->province) ?></td>
                </tr>
                <tr>
                    <th><?= __('District') ?></th>
                    <td><?= h($customer->district) ?></td>
                </tr>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= h($customer->country) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone3') ?></th>
                    <td><?= h($customer->phone3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone4') ?></th>
                    <td><?= h($customer->phone4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone5') ?></th>
                    <td><?= h($customer->phone5) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email1') ?></th>
                    <td><?= h($customer->email1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email2') ?></th>
                    <td><?= h($customer->email2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email3') ?></th>
                    <td><?= h($customer->email3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email4') ?></th>
                    <td><?= h($customer->email4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email5') ?></th>
                    <td><?= h($customer->email5) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fb1') ?></th>
                    <td><?= h($customer->fb1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fb2') ?></th>
                    <td><?= h($customer->fb2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ym1') ?></th>
                    <td><?= h($customer->ym1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ym2') ?></th>
                    <td><?= h($customer->ym2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ym3') ?></th>
                    <td><?= h($customer->ym3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ym4') ?></th>
                    <td><?= h($customer->ym4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ym5') ?></th>
                    <td><?= h($customer->ym5) ?></td>
                </tr>
                <tr>
                    <th><?= __('System') ?></th>
                    <td><?= h($customer->system) ?></td>
                </tr>
                <tr>
                    <th><?= __('Website') ?></th>
                    <td><?= h($customer->website) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($customer->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Who Create') ?></th>
                    <td><?= h($customer->who_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Who Update') ?></th>
                    <td><?= h($customer->who_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= h($customer->active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($customer->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($customer->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($customer->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($customer->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Marketing Id') ?></th>
                    <td><?= $this->Number->format($customer->marketing_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mou Id') ?></th>
                    <td><?= $this->Number->format($customer->mou_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Taxing') ?></th>
                    <td><?= $this->Number->format($customer->taxing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Postal') ?></th>
                    <td><?= $this->Number->format($customer->postal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Beginning Balance') ?></th>
                    <td><?= $this->Number->format($customer->beginning_balance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Platform') ?></th>
                    <td><?= $this->Number->format($customer->platform) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($customer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($customer->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($customer->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address Penghasil') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($customer->address_penghasil)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Address Supplier') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($customer->address_supplier)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Address Invoice') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($customer->address_invoice)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Address Tax Invoice') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($customer->address_tax_invoice)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($customer->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Cashes') ?></h4>
                <?php if (!empty($customer->acc_cashes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Cash Type') ?></th>
                            <th><?= __('Penyetor Penerima') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('No Cek') ?></th>
                            <th><?= __('Warkat Date') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Who Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->acc_cashes as $accCashes) : ?>
                        <tr>
                            <td><?= h($accCashes->id) ?></td>
                            <td><?= h($accCashes->number) ?></td>
                            <td><?= h($accCashes->customer_id) ?></td>
                            <td><?= h($accCashes->cash_type) ?></td>
                            <td><?= h($accCashes->penyetor_penerima) ?></td>
                            <td><?= h($accCashes->date) ?></td>
                            <td><?= h($accCashes->payment_type) ?></td>
                            <td><?= h($accCashes->no_cek) ?></td>
                            <td><?= h($accCashes->warkat_date) ?></td>
                            <td><?= h($accCashes->balance) ?></td>
                            <td><?= h($accCashes->total) ?></td>
                            <td><?= h($accCashes->description) ?></td>
                            <td><?= h($accCashes->who_create) ?></td>
                            <td><?= h($accCashes->created) ?></td>
                            <td><?= h($accCashes->who_update) ?></td>
                            <td><?= h($accCashes->modified) ?></td>
                            <td><?= h($accCashes->who_delete) ?></td>
                            <td><?= h($accCashes->deleted) ?></td>
                            <td><?= h($accCashes->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccCashes', 'action' => 'view', $accCashes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccCashes', 'action' => 'edit', $accCashes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccCashes', 'action' => 'delete', $accCashes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accCashes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Chart Of Accounts') ?></h4>
                <?php if (!empty($customer->acc_chart_of_accounts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Parent Account') ?></th>
                            <th><?= __('Parent Account Old') ?></th>
                            <th><?= __('Header Account') ?></th>
                            <th><?= __('Sub Header Account') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Code Old') ?></th>
                            <th><?= __('Code Old Program') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Contra Account') ?></th>
                            <th><?= __('Pca') ?></th>
                            <th><?= __('Pca Cash') ?></th>
                            <th><?= __('Bank') ?></th>
                            <th><?= __('Bank Cash') ?></th>
                            <th><?= __('Pca Bank') ?></th>
                            <th><?= __('Titipan Bank') ?></th>
                            <th><?= __('Mapping') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Sub Group') ?></th>
                            <th><?= __('Sub Group No') ?></th>
                            <th><?= __('Default') ?></th>
                            <th><?= __('Journal Types') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Types Journal') ?></th>
                            <th><?= __('Beginning Balance') ?></th>
                            <th><?= __('Beginning Balance Date') ?></th>
                            <th><?= __('Transaction') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Character') ?></th>
                            <th><?= __('Code Additional') ?></th>
                            <th><?= __('Additional') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->acc_chart_of_accounts as $accChartOfAccounts) : ?>
                        <tr>
                            <td><?= h($accChartOfAccounts->id) ?></td>
                            <td><?= h($accChartOfAccounts->branch_id) ?></td>
                            <td><?= h($accChartOfAccounts->parent_id) ?></td>
                            <td><?= h($accChartOfAccounts->lft) ?></td>
                            <td><?= h($accChartOfAccounts->rght) ?></td>
                            <td><?= h($accChartOfAccounts->level) ?></td>
                            <td><?= h($accChartOfAccounts->parent_account) ?></td>
                            <td><?= h($accChartOfAccounts->parent_account_old) ?></td>
                            <td><?= h($accChartOfAccounts->header_account) ?></td>
                            <td><?= h($accChartOfAccounts->sub_header_account) ?></td>
                            <td><?= h($accChartOfAccounts->code) ?></td>
                            <td><?= h($accChartOfAccounts->code_old) ?></td>
                            <td><?= h($accChartOfAccounts->code_old_program) ?></td>
                            <td><?= h($accChartOfAccounts->name) ?></td>
                            <td><?= h($accChartOfAccounts->customer_id) ?></td>
                            <td><?= h($accChartOfAccounts->type) ?></td>
                            <td><?= h($accChartOfAccounts->contra_account) ?></td>
                            <td><?= h($accChartOfAccounts->pca) ?></td>
                            <td><?= h($accChartOfAccounts->pca_cash) ?></td>
                            <td><?= h($accChartOfAccounts->bank) ?></td>
                            <td><?= h($accChartOfAccounts->bank_cash) ?></td>
                            <td><?= h($accChartOfAccounts->pca_bank) ?></td>
                            <td><?= h($accChartOfAccounts->titipan_bank) ?></td>
                            <td><?= h($accChartOfAccounts->mapping) ?></td>
                            <td><?= h($accChartOfAccounts->group) ?></td>
                            <td><?= h($accChartOfAccounts->sub_group) ?></td>
                            <td><?= h($accChartOfAccounts->sub_group_no) ?></td>
                            <td><?= h($accChartOfAccounts->default) ?></td>
                            <td><?= h($accChartOfAccounts->journal_types) ?></td>
                            <td><?= h($accChartOfAccounts->journal_type) ?></td>
                            <td><?= h($accChartOfAccounts->types_journal) ?></td>
                            <td><?= h($accChartOfAccounts->beginning_balance) ?></td>
                            <td><?= h($accChartOfAccounts->beginning_balance_date) ?></td>
                            <td><?= h($accChartOfAccounts->transaction) ?></td>
                            <td><?= h($accChartOfAccounts->description) ?></td>
                            <td><?= h($accChartOfAccounts->character) ?></td>
                            <td><?= h($accChartOfAccounts->code_additional) ?></td>
                            <td><?= h($accChartOfAccounts->additional) ?></td>
                            <td><?= h($accChartOfAccounts->is_create) ?></td>
                            <td><?= h($accChartOfAccounts->created) ?></td>
                            <td><?= h($accChartOfAccounts->is_update) ?></td>
                            <td><?= h($accChartOfAccounts->modified) ?></td>
                            <td><?= h($accChartOfAccounts->is_delete) ?></td>
                            <td><?= h($accChartOfAccounts->deleted) ?></td>
                            <td><?= h($accChartOfAccounts->status) ?></td>
                            <td><?= h($accChartOfAccounts->is_log) ?></td>
                            <td><?= h($accChartOfAccounts->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccChartOfAccounts', 'action' => 'view', $accChartOfAccounts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccChartOfAccounts', 'action' => 'edit', $accChartOfAccounts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccChartOfAccounts', 'action' => 'delete', $accChartOfAccounts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accChartOfAccounts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Banks') ?></h4>
                <?php if (!empty($customer->acc_journal_banks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Customer Id Ori') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Cek Bg') ?></th>
                            <th><?= __('Recipient Payer Id') ?></th>
                            <th><?= __('Recipient Payer Code') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('No Cek') ?></th>
                            <th><?= __('No Ref') ?></th>
                            <th><?= __('Warkat Date') ?></th>
                            <th><?= __('Job') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Grand Total') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->acc_journal_banks as $accJournalBanks) : ?>
                        <tr>
                            <td><?= h($accJournalBanks->id) ?></td>
                            <td><?= h($accJournalBanks->branch_id) ?></td>
                            <td><?= h($accJournalBanks->number) ?></td>
                            <td><?= h($accJournalBanks->code) ?></td>
                            <td><?= h($accJournalBanks->customer_id_ori) ?></td>
                            <td><?= h($accJournalBanks->customer_id) ?></td>
                            <td><?= h($accJournalBanks->journal_type) ?></td>
                            <td><?= h($accJournalBanks->name) ?></td>
                            <td><?= h($accJournalBanks->subject) ?></td>
                            <td><?= h($accJournalBanks->cek_bg) ?></td>
                            <td><?= h($accJournalBanks->recipient_payer_id) ?></td>
                            <td><?= h($accJournalBanks->recipient_payer_code) ?></td>
                            <td><?= h($accJournalBanks->date) ?></td>
                            <td><?= h($accJournalBanks->payment_type) ?></td>
                            <td><?= h($accJournalBanks->no_cek) ?></td>
                            <td><?= h($accJournalBanks->no_ref) ?></td>
                            <td><?= h($accJournalBanks->warkat_date) ?></td>
                            <td><?= h($accJournalBanks->job) ?></td>
                            <td><?= h($accJournalBanks->balance) ?></td>
                            <td><?= h($accJournalBanks->grand_total) ?></td>
                            <td><?= h($accJournalBanks->description) ?></td>
                            <td><?= h($accJournalBanks->status) ?></td>
                            <td><?= h($accJournalBanks->is_create) ?></td>
                            <td><?= h($accJournalBanks->created) ?></td>
                            <td><?= h($accJournalBanks->is_update) ?></td>
                            <td><?= h($accJournalBanks->modified) ?></td>
                            <td><?= h($accJournalBanks->is_delete) ?></td>
                            <td><?= h($accJournalBanks->deleted) ?></td>
                            <td><?= h($accJournalBanks->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalBanks', 'action' => 'view', $accJournalBanks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalBanks', 'action' => 'edit', $accJournalBanks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalBanks', 'action' => 'delete', $accJournalBanks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalBanks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Cashes') ?></h4>
                <?php if (!empty($customer->acc_journal_cashes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Customer Id Old') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Cek Bg') ?></th>
                            <th><?= __('Recipient Payer Id') ?></th>
                            <th><?= __('Recipient Payer Code') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('No Cek') ?></th>
                            <th><?= __('No Ref') ?></th>
                            <th><?= __('Warkat Date') ?></th>
                            <th><?= __('Job') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Grand Total') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->acc_journal_cashes as $accJournalCashes) : ?>
                        <tr>
                            <td><?= h($accJournalCashes->id) ?></td>
                            <td><?= h($accJournalCashes->branch_id) ?></td>
                            <td><?= h($accJournalCashes->number) ?></td>
                            <td><?= h($accJournalCashes->code) ?></td>
                            <td><?= h($accJournalCashes->customer_id_old) ?></td>
                            <td><?= h($accJournalCashes->customer_id) ?></td>
                            <td><?= h($accJournalCashes->journal_type) ?></td>
                            <td><?= h($accJournalCashes->name) ?></td>
                            <td><?= h($accJournalCashes->subject) ?></td>
                            <td><?= h($accJournalCashes->cek_bg) ?></td>
                            <td><?= h($accJournalCashes->recipient_payer_id) ?></td>
                            <td><?= h($accJournalCashes->recipient_payer_code) ?></td>
                            <td><?= h($accJournalCashes->date) ?></td>
                            <td><?= h($accJournalCashes->payment_type) ?></td>
                            <td><?= h($accJournalCashes->no_cek) ?></td>
                            <td><?= h($accJournalCashes->no_ref) ?></td>
                            <td><?= h($accJournalCashes->warkat_date) ?></td>
                            <td><?= h($accJournalCashes->job) ?></td>
                            <td><?= h($accJournalCashes->balance) ?></td>
                            <td><?= h($accJournalCashes->grand_total) ?></td>
                            <td><?= h($accJournalCashes->description) ?></td>
                            <td><?= h($accJournalCashes->status) ?></td>
                            <td><?= h($accJournalCashes->is_create) ?></td>
                            <td><?= h($accJournalCashes->created) ?></td>
                            <td><?= h($accJournalCashes->is_update) ?></td>
                            <td><?= h($accJournalCashes->modified) ?></td>
                            <td><?= h($accJournalCashes->is_delete) ?></td>
                            <td><?= h($accJournalCashes->deleted) ?></td>
                            <td><?= h($accJournalCashes->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalCashes', 'action' => 'view', $accJournalCashes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalCashes', 'action' => 'edit', $accJournalCashes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalCashes', 'action' => 'delete', $accJournalCashes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalCashes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Memorials') ?></h4>
                <?php if (!empty($customer->acc_journal_memorials)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Customer Id Old') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Cek Bg') ?></th>
                            <th><?= __('Recipient Payer Id') ?></th>
                            <th><?= __('Recipient Payer Code') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('No Cek') ?></th>
                            <th><?= __('No Ref') ?></th>
                            <th><?= __('Warkat Date') ?></th>
                            <th><?= __('Job') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Grand Total') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->acc_journal_memorials as $accJournalMemorials) : ?>
                        <tr>
                            <td><?= h($accJournalMemorials->id) ?></td>
                            <td><?= h($accJournalMemorials->branch_id) ?></td>
                            <td><?= h($accJournalMemorials->number) ?></td>
                            <td><?= h($accJournalMemorials->code) ?></td>
                            <td><?= h($accJournalMemorials->customer_id_old) ?></td>
                            <td><?= h($accJournalMemorials->customer_id) ?></td>
                            <td><?= h($accJournalMemorials->journal_type) ?></td>
                            <td><?= h($accJournalMemorials->name) ?></td>
                            <td><?= h($accJournalMemorials->subject) ?></td>
                            <td><?= h($accJournalMemorials->cek_bg) ?></td>
                            <td><?= h($accJournalMemorials->recipient_payer_id) ?></td>
                            <td><?= h($accJournalMemorials->recipient_payer_code) ?></td>
                            <td><?= h($accJournalMemorials->date) ?></td>
                            <td><?= h($accJournalMemorials->payment_type) ?></td>
                            <td><?= h($accJournalMemorials->no_cek) ?></td>
                            <td><?= h($accJournalMemorials->no_ref) ?></td>
                            <td><?= h($accJournalMemorials->warkat_date) ?></td>
                            <td><?= h($accJournalMemorials->job) ?></td>
                            <td><?= h($accJournalMemorials->balance) ?></td>
                            <td><?= h($accJournalMemorials->grand_total) ?></td>
                            <td><?= h($accJournalMemorials->description) ?></td>
                            <td><?= h($accJournalMemorials->status) ?></td>
                            <td><?= h($accJournalMemorials->is_create) ?></td>
                            <td><?= h($accJournalMemorials->created) ?></td>
                            <td><?= h($accJournalMemorials->is_update) ?></td>
                            <td><?= h($accJournalMemorials->modified) ?></td>
                            <td><?= h($accJournalMemorials->is_delete) ?></td>
                            <td><?= h($accJournalMemorials->deleted) ?></td>
                            <td><?= h($accJournalMemorials->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalMemorials', 'action' => 'view', $accJournalMemorials->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalMemorials', 'action' => 'edit', $accJournalMemorials->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalMemorials', 'action' => 'delete', $accJournalMemorials->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMemorials->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journals') ?></h4>
                <?php if (!empty($customer->acc_journals)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('From') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Journal Sub Id') ?></th>
                            <th><?= __('Code Old') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Customer Id Ori') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Cek Bg') ?></th>
                            <th><?= __('Recipient Payer Id') ?></th>
                            <th><?= __('Recipient Payer Name') ?></th>
                            <th><?= __('Recipient Payer Code') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Date Posting') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('No Cek') ?></th>
                            <th><?= __('No Ref') ?></th>
                            <th><?= __('Warkat Date') ?></th>
                            <th><?= __('Job') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Grand Total') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->acc_journals as $accJournals) : ?>
                        <tr>
                            <td><?= h($accJournals->id) ?></td>
                            <td><?= h($accJournals->branch_id) ?></td>
                            <td><?= h($accJournals->from) ?></td>
                            <td><?= h($accJournals->number) ?></td>
                            <td><?= h($accJournals->journal_sub_id) ?></td>
                            <td><?= h($accJournals->code_old) ?></td>
                            <td><?= h($accJournals->code) ?></td>
                            <td><?= h($accJournals->customer_id_ori) ?></td>
                            <td><?= h($accJournals->customer_id) ?></td>
                            <td><?= h($accJournals->journal_type) ?></td>
                            <td><?= h($accJournals->tax) ?></td>
                            <td><?= h($accJournals->name) ?></td>
                            <td><?= h($accJournals->subject) ?></td>
                            <td><?= h($accJournals->cek_bg) ?></td>
                            <td><?= h($accJournals->recipient_payer_id) ?></td>
                            <td><?= h($accJournals->recipient_payer_name) ?></td>
                            <td><?= h($accJournals->recipient_payer_code) ?></td>
                            <td><?= h($accJournals->date) ?></td>
                            <td><?= h($accJournals->date_posting) ?></td>
                            <td><?= h($accJournals->payment_type) ?></td>
                            <td><?= h($accJournals->no_cek) ?></td>
                            <td><?= h($accJournals->no_ref) ?></td>
                            <td><?= h($accJournals->warkat_date) ?></td>
                            <td><?= h($accJournals->job) ?></td>
                            <td><?= h($accJournals->balance) ?></td>
                            <td><?= h($accJournals->grand_total) ?></td>
                            <td><?= h($accJournals->description) ?></td>
                            <td><?= h($accJournals->is_create) ?></td>
                            <td><?= h($accJournals->created) ?></td>
                            <td><?= h($accJournals->is_update) ?></td>
                            <td><?= h($accJournals->modified) ?></td>
                            <td><?= h($accJournals->is_delete) ?></td>
                            <td><?= h($accJournals->deleted) ?></td>
                            <td><?= h($accJournals->status) ?></td>
                            <td><?= h($accJournals->is_active) ?></td>
                            <td><?= h($accJournals->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournals', 'action' => 'view', $accJournals->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournals', 'action' => 'edit', $accJournals->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournals', 'action' => 'delete', $accJournals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournals->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Certificates') ?></h4>
                <?php if (!empty($customer->certificates)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Processor') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->certificates as $certificates) : ?>
                        <tr>
                            <td><?= h($certificates->id) ?></td>
                            <td><?= h($certificates->branch_id) ?></td>
                            <td><?= h($certificates->customer_id) ?></td>
                            <td><?= h($certificates->type) ?></td>
                            <td><?= h($certificates->processor) ?></td>
                            <td><?= h($certificates->date) ?></td>
                            <td><?= h($certificates->description) ?></td>
                            <td><?= h($certificates->is_create) ?></td>
                            <td><?= h($certificates->is_update) ?></td>
                            <td><?= h($certificates->is_delete) ?></td>
                            <td><?= h($certificates->is_active) ?></td>
                            <td><?= h($certificates->is_log) ?></td>
                            <td><?= h($certificates->created) ?></td>
                            <td><?= h($certificates->modified) ?></td>
                            <td><?= h($certificates->deleted) ?></td>
                            <td><?= h($certificates->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Certificates', 'action' => 'view', $certificates->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Certificates', 'action' => 'edit', $certificates->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Certificates', 'action' => 'delete', $certificates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $certificates->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Commission Details') ?></h4>
                <?php if (!empty($customer->commission_details)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Commission Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Waste Id') ?></th>
                            <th><?= __('Index') ?></th>
                            <th><?= __('Percent') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->commission_details as $commissionDetails) : ?>
                        <tr>
                            <td><?= h($commissionDetails->id) ?></td>
                            <td><?= h($commissionDetails->branch_id) ?></td>
                            <td><?= h($commissionDetails->commission_id) ?></td>
                            <td><?= h($commissionDetails->customer_id) ?></td>
                            <td><?= h($commissionDetails->invoice_id) ?></td>
                            <td><?= h($commissionDetails->waste_id) ?></td>
                            <td><?= h($commissionDetails->index) ?></td>
                            <td><?= h($commissionDetails->percent) ?></td>
                            <td><?= h($commissionDetails->date) ?></td>
                            <td><?= h($commissionDetails->who_create) ?></td>
                            <td><?= h($commissionDetails->created) ?></td>
                            <td><?= h($commissionDetails->who_update) ?></td>
                            <td><?= h($commissionDetails->modified) ?></td>
                            <td><?= h($commissionDetails->active) ?></td>
                            <td><?= h($commissionDetails->status) ?></td>
                            <td><?= h($commissionDetails->is_create) ?></td>
                            <td><?= h($commissionDetails->is_update) ?></td>
                            <td><?= h($commissionDetails->is_delete) ?></td>
                            <td><?= h($commissionDetails->deleted) ?></td>
                            <td><?= h($commissionDetails->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CommissionDetails', 'action' => 'view', $commissionDetails->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CommissionDetails', 'action' => 'edit', $commissionDetails->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CommissionDetails', 'action' => 'delete', $commissionDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $commissionDetails->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoice Deposits') ?></h4>
                <?php if (!empty($customer->invoice_deposits)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Coa Bank Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Deposit Invoice Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Number Noppn') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('From') ?></th>
                            <th><?= __('For') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Deposit') ?></th>
                            <th><?= __('Cost') ?></th>
                            <th><?= __('Number Tax Invoice') ?></th>
                            <th><?= __('Commission') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Referense Po') ?></th>
                            <th><?= __('Payment Invoice Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Who') ?></th>
                            <th><?= __('Payment Jumlah') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Payment Bank') ?></th>
                            <th><?= __('Payment Bank Va') ?></th>
                            <th><?= __('Biaya Bank') ?></th>
                            <th><?= __('Pembulatan') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Pph No') ?></th>
                            <th><?= __('Pph Date') ?></th>
                            <th><?= __('Pph Jumlah') ?></th>
                            <th><?= __('Ppn 900 Date') ?></th>
                            <th><?= __('Ppn 900 Jumlah') ?></th>
                            <th><?= __('Delivery') ?></th>
                            <th><?= __('Delivery Date') ?></th>
                            <th><?= __('Delivery Media') ?></th>
                            <th><?= __('Delivery Up') ?></th>
                            <th><?= __('Delivery Desc All') ?></th>
                            <th><?= __('Delivery Desc') ?></th>
                            <th><?= __('Receive Date') ?></th>
                            <th><?= __('Receive') ?></th>
                            <th><?= __('Sign Id') ?></th>
                            <th><?= __('Director') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Posting Date') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Print') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->invoice_deposits as $invoiceDeposits) : ?>
                        <tr>
                            <td><?= h($invoiceDeposits->id) ?></td>
                            <td><?= h($invoiceDeposits->branch_id) ?></td>
                            <td><?= h($invoiceDeposits->acc_journal_id) ?></td>
                            <td><?= h($invoiceDeposits->coa_bank_id) ?></td>
                            <td><?= h($invoiceDeposits->invoice_id) ?></td>
                            <td><?= h($invoiceDeposits->deposit_invoice_id) ?></td>
                            <td><?= h($invoiceDeposits->number) ?></td>
                            <td><?= h($invoiceDeposits->number_noppn) ?></td>
                            <td><?= h($invoiceDeposits->tax) ?></td>
                            <td><?= h($invoiceDeposits->from) ?></td>
                            <td><?= h($invoiceDeposits->for) ?></td>
                            <td><?= h($invoiceDeposits->customer_id) ?></td>
                            <td><?= h($invoiceDeposits->mou_id) ?></td>
                            <td><?= h($invoiceDeposits->deposit) ?></td>
                            <td><?= h($invoiceDeposits->cost) ?></td>
                            <td><?= h($invoiceDeposits->number_tax_invoice) ?></td>
                            <td><?= h($invoiceDeposits->commission) ?></td>
                            <td><?= h($invoiceDeposits->date) ?></td>
                            <td><?= h($invoiceDeposits->due_date) ?></td>
                            <td><?= h($invoiceDeposits->referense_po) ?></td>
                            <td><?= h($invoiceDeposits->payment_invoice_date) ?></td>
                            <td><?= h($invoiceDeposits->payment) ?></td>
                            <td><?= h($invoiceDeposits->payment_date) ?></td>
                            <td><?= h($invoiceDeposits->payment_who) ?></td>
                            <td><?= h($invoiceDeposits->payment_jumlah) ?></td>
                            <td><?= h($invoiceDeposits->payment_desc) ?></td>
                            <td><?= h($invoiceDeposits->payment_method) ?></td>
                            <td><?= h($invoiceDeposits->payment_bank) ?></td>
                            <td><?= h($invoiceDeposits->payment_bank_va) ?></td>
                            <td><?= h($invoiceDeposits->biaya_bank) ?></td>
                            <td><?= h($invoiceDeposits->pembulatan) ?></td>
                            <td><?= h($invoiceDeposits->description) ?></td>
                            <td><?= h($invoiceDeposits->pph_no) ?></td>
                            <td><?= h($invoiceDeposits->pph_date) ?></td>
                            <td><?= h($invoiceDeposits->pph_jumlah) ?></td>
                            <td><?= h($invoiceDeposits->ppn_900_date) ?></td>
                            <td><?= h($invoiceDeposits->ppn_900_jumlah) ?></td>
                            <td><?= h($invoiceDeposits->delivery) ?></td>
                            <td><?= h($invoiceDeposits->delivery_date) ?></td>
                            <td><?= h($invoiceDeposits->delivery_media) ?></td>
                            <td><?= h($invoiceDeposits->delivery_up) ?></td>
                            <td><?= h($invoiceDeposits->delivery_desc_all) ?></td>
                            <td><?= h($invoiceDeposits->delivery_desc) ?></td>
                            <td><?= h($invoiceDeposits->receive_date) ?></td>
                            <td><?= h($invoiceDeposits->receive) ?></td>
                            <td><?= h($invoiceDeposits->sign_id) ?></td>
                            <td><?= h($invoiceDeposits->director) ?></td>
                            <td><?= h($invoiceDeposits->posting) ?></td>
                            <td><?= h($invoiceDeposits->posting_date) ?></td>
                            <td><?= h($invoiceDeposits->is_print) ?></td>
                            <td><?= h($invoiceDeposits->print) ?></td>
                            <td><?= h($invoiceDeposits->is_create) ?></td>
                            <td><?= h($invoiceDeposits->created) ?></td>
                            <td><?= h($invoiceDeposits->is_update) ?></td>
                            <td><?= h($invoiceDeposits->modified) ?></td>
                            <td><?= h($invoiceDeposits->is_log) ?></td>
                            <td><?= h($invoiceDeposits->is_delete) ?></td>
                            <td><?= h($invoiceDeposits->deleted) ?></td>
                            <td><?= h($invoiceDeposits->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InvoiceDeposits', 'action' => 'view', $invoiceDeposits->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InvoiceDeposits', 'action' => 'edit', $invoiceDeposits->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvoiceDeposits', 'action' => 'delete', $invoiceDeposits->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceDeposits->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoice Entries') ?></h4>
                <?php if (!empty($customer->invoice_entries)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Pph') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Customer Name') ?></th>
                            <th><?= __('Dpp') ?></th>
                            <th><?= __('Miscellaneous Expense') ?></th>
                            <th><?= __('Miscellaneous Expense Desc') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Pph Nominal') ?></th>
                            <th><?= __('Grand Total') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment No') ?></th>
                            <th><?= __('Payment Who') ?></th>
                            <th><?= __('Payment Date1') ?></th>
                            <th><?= __('Payment Method1') ?></th>
                            <th><?= __('Payment Jumlah1') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Payment Jumlah') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Receive Date') ?></th>
                            <th><?= __('Pph23 No') ?></th>
                            <th><?= __('Pph23 Date') ?></th>
                            <th><?= __('Pph23 Total') ?></th>
                            <th><?= __('Pph23 Media') ?></th>
                            <th><?= __('Payment Receipt Number') ?></th>
                            <th><?= __('Sign Id') ?></th>
                            <th><?= __('Director') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->invoice_entries as $invoiceEntries) : ?>
                        <tr>
                            <td><?= h($invoiceEntries->id) ?></td>
                            <td><?= h($invoiceEntries->branch_id) ?></td>
                            <td><?= h($invoiceEntries->number) ?></td>
                            <td><?= h($invoiceEntries->tax) ?></td>
                            <td><?= h($invoiceEntries->pph) ?></td>
                            <td><?= h($invoiceEntries->customer_id) ?></td>
                            <td><?= h($invoiceEntries->customer_name) ?></td>
                            <td><?= h($invoiceEntries->dpp) ?></td>
                            <td><?= h($invoiceEntries->miscellaneous_expense) ?></td>
                            <td><?= h($invoiceEntries->miscellaneous_expense_desc) ?></td>
                            <td><?= h($invoiceEntries->total) ?></td>
                            <td><?= h($invoiceEntries->pph_nominal) ?></td>
                            <td><?= h($invoiceEntries->grand_total) ?></td>
                            <td><?= h($invoiceEntries->date) ?></td>
                            <td><?= h($invoiceEntries->payment) ?></td>
                            <td><?= h($invoiceEntries->payment_no) ?></td>
                            <td><?= h($invoiceEntries->payment_who) ?></td>
                            <td><?= h($invoiceEntries->payment_date1) ?></td>
                            <td><?= h($invoiceEntries->payment_method1) ?></td>
                            <td><?= h($invoiceEntries->payment_jumlah1) ?></td>
                            <td><?= h($invoiceEntries->payment_date) ?></td>
                            <td><?= h($invoiceEntries->payment_method) ?></td>
                            <td><?= h($invoiceEntries->payment_jumlah) ?></td>
                            <td><?= h($invoiceEntries->payment_desc) ?></td>
                            <td><?= h($invoiceEntries->due_date) ?></td>
                            <td><?= h($invoiceEntries->receive_date) ?></td>
                            <td><?= h($invoiceEntries->pph23_no) ?></td>
                            <td><?= h($invoiceEntries->pph23_date) ?></td>
                            <td><?= h($invoiceEntries->pph23_total) ?></td>
                            <td><?= h($invoiceEntries->pph23_media) ?></td>
                            <td><?= h($invoiceEntries->payment_receipt_number) ?></td>
                            <td><?= h($invoiceEntries->sign_id) ?></td>
                            <td><?= h($invoiceEntries->director) ?></td>
                            <td><?= h($invoiceEntries->posting) ?></td>
                            <td><?= h($invoiceEntries->is_create) ?></td>
                            <td><?= h($invoiceEntries->created) ?></td>
                            <td><?= h($invoiceEntries->is_update) ?></td>
                            <td><?= h($invoiceEntries->modified) ?></td>
                            <td><?= h($invoiceEntries->is_delete) ?></td>
                            <td><?= h($invoiceEntries->deleted) ?></td>
                            <td><?= h($invoiceEntries->is_active) ?></td>
                            <td><?= h($invoiceEntries->is_log) ?></td>
                            <td><?= h($invoiceEntries->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InvoiceEntries', 'action' => 'view', $invoiceEntries->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InvoiceEntries', 'action' => 'edit', $invoiceEntries->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvoiceEntries', 'action' => 'delete', $invoiceEntries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceEntries->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoice Outs') ?></h4>
                <?php if (!empty($customer->invoice_outs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Pph') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Customer Name') ?></th>
                            <th><?= __('Dpp') ?></th>
                            <th><?= __('Miscellaneous Expense') ?></th>
                            <th><?= __('Miscellaneous Expense Desc') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Pph Nominal') ?></th>
                            <th><?= __('Grand Total') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment No') ?></th>
                            <th><?= __('Payment Who') ?></th>
                            <th><?= __('Payment Date1') ?></th>
                            <th><?= __('Payment Method1') ?></th>
                            <th><?= __('Payment Jumlah1') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Payment Jumlah') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Receive Date') ?></th>
                            <th><?= __('Pph23 No') ?></th>
                            <th><?= __('Pph23 Date') ?></th>
                            <th><?= __('Pph23 Total') ?></th>
                            <th><?= __('Pph23 Media') ?></th>
                            <th><?= __('Payment Receipt Number') ?></th>
                            <th><?= __('Sign Id') ?></th>
                            <th><?= __('Director') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->invoice_outs as $invoiceOuts) : ?>
                        <tr>
                            <td><?= h($invoiceOuts->id) ?></td>
                            <td><?= h($invoiceOuts->branch_id) ?></td>
                            <td><?= h($invoiceOuts->number) ?></td>
                            <td><?= h($invoiceOuts->tax) ?></td>
                            <td><?= h($invoiceOuts->pph) ?></td>
                            <td><?= h($invoiceOuts->customer_id) ?></td>
                            <td><?= h($invoiceOuts->customer_name) ?></td>
                            <td><?= h($invoiceOuts->dpp) ?></td>
                            <td><?= h($invoiceOuts->miscellaneous_expense) ?></td>
                            <td><?= h($invoiceOuts->miscellaneous_expense_desc) ?></td>
                            <td><?= h($invoiceOuts->total) ?></td>
                            <td><?= h($invoiceOuts->pph_nominal) ?></td>
                            <td><?= h($invoiceOuts->grand_total) ?></td>
                            <td><?= h($invoiceOuts->date) ?></td>
                            <td><?= h($invoiceOuts->payment) ?></td>
                            <td><?= h($invoiceOuts->payment_no) ?></td>
                            <td><?= h($invoiceOuts->payment_who) ?></td>
                            <td><?= h($invoiceOuts->payment_date1) ?></td>
                            <td><?= h($invoiceOuts->payment_method1) ?></td>
                            <td><?= h($invoiceOuts->payment_jumlah1) ?></td>
                            <td><?= h($invoiceOuts->payment_date) ?></td>
                            <td><?= h($invoiceOuts->payment_method) ?></td>
                            <td><?= h($invoiceOuts->payment_jumlah) ?></td>
                            <td><?= h($invoiceOuts->payment_desc) ?></td>
                            <td><?= h($invoiceOuts->due_date) ?></td>
                            <td><?= h($invoiceOuts->receive_date) ?></td>
                            <td><?= h($invoiceOuts->pph23_no) ?></td>
                            <td><?= h($invoiceOuts->pph23_date) ?></td>
                            <td><?= h($invoiceOuts->pph23_total) ?></td>
                            <td><?= h($invoiceOuts->pph23_media) ?></td>
                            <td><?= h($invoiceOuts->payment_receipt_number) ?></td>
                            <td><?= h($invoiceOuts->sign_id) ?></td>
                            <td><?= h($invoiceOuts->director) ?></td>
                            <td><?= h($invoiceOuts->posting) ?></td>
                            <td><?= h($invoiceOuts->is_create) ?></td>
                            <td><?= h($invoiceOuts->created) ?></td>
                            <td><?= h($invoiceOuts->is_update) ?></td>
                            <td><?= h($invoiceOuts->modified) ?></td>
                            <td><?= h($invoiceOuts->is_delete) ?></td>
                            <td><?= h($invoiceOuts->deleted) ?></td>
                            <td><?= h($invoiceOuts->is_active) ?></td>
                            <td><?= h($invoiceOuts->is_log) ?></td>
                            <td><?= h($invoiceOuts->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InvoiceOuts', 'action' => 'view', $invoiceOuts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InvoiceOuts', 'action' => 'edit', $invoiceOuts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvoiceOuts', 'action' => 'delete', $invoiceOuts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceOuts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoices') ?></h4>
                <?php if (!empty($customer->invoices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Parent Invoice Id') ?></th>
                            <th><?= __('Acc Journal Payment Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Number Old') ?></th>
                            <th><?= __('Number Noppn') ?></th>
                            <th><?= __('Ppn') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Taxing') ?></th>
                            <th><?= __('Pph') ?></th>
                            <th><?= __('From') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Deposit') ?></th>
                            <th><?= __('Beginning Deposit') ?></th>
                            <th><?= __('Rest Deposit') ?></th>
                            <th><?= __('Cost') ?></th>
                            <th><?= __('Number Tax Invoice') ?></th>
                            <th><?= __('Commission') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Referense Po') ?></th>
                            <th><?= __('Transport') ?></th>
                            <th><?= __('Transport Quantity') ?></th>
                            <th><?= __('Transport Unit') ?></th>
                            <th><?= __('Transport Date') ?></th>
                            <th><?= __('Transport 2') ?></th>
                            <th><?= __('Transport Quantity 2') ?></th>
                            <th><?= __('Transport Unit 2') ?></th>
                            <th><?= __('Transport 2 Date') ?></th>
                            <th><?= __('Handling') ?></th>
                            <th><?= __('Handling Quantity') ?></th>
                            <th><?= __('Handling Unit') ?></th>
                            <th><?= __('Handling Date') ?></th>
                            <th><?= __('Sales Discounts') ?></th>
                            <th><?= __('Discount') ?></th>
                            <th><?= __('Discount Percent') ?></th>
                            <th><?= __('Discount Nominal') ?></th>
                            <th><?= __('Discount Price') ?></th>
                            <th><?= __('Discount Quantity') ?></th>
                            <th><?= __('Discount Unit') ?></th>
                            <th><?= __('Biaya Lain Date') ?></th>
                            <th><?= __('Biaya Lain') ?></th>
                            <th><?= __('Biaya Lain Quantity') ?></th>
                            <th><?= __('Biaya Lain Unit') ?></th>
                            <th><?= __('Biaya Lain Desc') ?></th>
                            <th><?= __('Biaya Lain Date 2') ?></th>
                            <th><?= __('Biaya Lain 2') ?></th>
                            <th><?= __('Biaya Lain Quantity 2') ?></th>
                            <th><?= __('Biaya Lain Unit 2') ?></th>
                            <th><?= __('Biaya Lain Desc 2') ?></th>
                            <th><?= __('Biaya Lain Date 3') ?></th>
                            <th><?= __('Biaya Lain Quantity 3') ?></th>
                            <th><?= __('Biaya Lain 3') ?></th>
                            <th><?= __('Biaya Lain Unit 3') ?></th>
                            <th><?= __('Biaya Lain Desc 3') ?></th>
                            <th><?= __('Biaya Lain Date 4') ?></th>
                            <th><?= __('Biaya Lain 4') ?></th>
                            <th><?= __('Biaya Lain Quantity 4') ?></th>
                            <th><?= __('Biaya Lain Unit 4') ?></th>
                            <th><?= __('Biaya Lain Desc 4') ?></th>
                            <th><?= __('Biaya Lain Date 5') ?></th>
                            <th><?= __('Biaya Lain 5') ?></th>
                            <th><?= __('Biaya Lain Quantity 5') ?></th>
                            <th><?= __('Biaya Lain Unit 5') ?></th>
                            <th><?= __('Biaya Lain Desc 5') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment Status') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Who') ?></th>
                            <th><?= __('Payment Who Date') ?></th>
                            <th><?= __('Payment Jumlah Ori') ?></th>
                            <th><?= __('Payment Jumlah') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Payment Bank') ?></th>
                            <th><?= __('Payment Bank Va') ?></th>
                            <th><?= __('Payment Mou Is') ?></th>
                            <th><?= __('Payment Mou Saldo') ?></th>
                            <th><?= __('Payment Mou Date') ?></th>
                            <th><?= __('Payment Termin Is 1') ?></th>
                            <th><?= __('Payment Termin Is Date 1') ?></th>
                            <th><?= __('Payment Termin Method 1') ?></th>
                            <th><?= __('Payment Termin Jumlah 1') ?></th>
                            <th><?= __('Payment Termin Date 1') ?></th>
                            <th><?= __('Payment Termin Pph 1') ?></th>
                            <th><?= __('Payment Termin Pph No 1') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 1') ?></th>
                            <th><?= __('Payment Termin Ppn 1') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 1') ?></th>
                            <th><?= __('Payment Termin Is 2') ?></th>
                            <th><?= __('Payment Termin Is Date 2') ?></th>
                            <th><?= __('Payment Termin Method 2') ?></th>
                            <th><?= __('Payment Termin Jumlah 2') ?></th>
                            <th><?= __('Payment Termin Date 2') ?></th>
                            <th><?= __('Payment Termin Pph 2') ?></th>
                            <th><?= __('Payment Termin Pph No 2') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 2') ?></th>
                            <th><?= __('Payment Termin Ppn 2') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 2') ?></th>
                            <th><?= __('Payment Termin Is 3') ?></th>
                            <th><?= __('Payment Termin Is Date 3') ?></th>
                            <th><?= __('Payment Termin Method 3') ?></th>
                            <th><?= __('Payment Termin Jumlah 3') ?></th>
                            <th><?= __('Payment Termin Date 3') ?></th>
                            <th><?= __('Payment Termin Pph 3') ?></th>
                            <th><?= __('Payment Termin Pph No 3') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 3') ?></th>
                            <th><?= __('Payment Termin Ppn 3') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 3') ?></th>
                            <th><?= __('Payment Termin Is 4') ?></th>
                            <th><?= __('Payment Termin Is Date 4') ?></th>
                            <th><?= __('Payment Termin Method 4') ?></th>
                            <th><?= __('Payment Termin Jumlah 4') ?></th>
                            <th><?= __('Payment Termin Date 4') ?></th>
                            <th><?= __('Payment Termin Pph 4') ?></th>
                            <th><?= __('Payment Termin Pph No 4') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 4') ?></th>
                            <th><?= __('Payment Termin Ppn 4') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 4') ?></th>
                            <th><?= __('Payment Termin Is 5') ?></th>
                            <th><?= __('Payment Termin Is Date 5') ?></th>
                            <th><?= __('Payment Termin Method 5') ?></th>
                            <th><?= __('Payment Termin Jumlah 5') ?></th>
                            <th><?= __('Payment Termin Date 5') ?></th>
                            <th><?= __('Payment Termin Pph 5') ?></th>
                            <th><?= __('Payment Termin Pph No 5') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 5') ?></th>
                            <th><?= __('Payment Termin Ppn 5') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 5') ?></th>
                            <th><?= __('Payment Termin Is 6') ?></th>
                            <th><?= __('Payment Termin Is Date 6') ?></th>
                            <th><?= __('Payment Termin Method 6') ?></th>
                            <th><?= __('Payment Termin Jumlah 6') ?></th>
                            <th><?= __('Payment Termin Date 6') ?></th>
                            <th><?= __('Payment Termin Pph 6') ?></th>
                            <th><?= __('Payment Termin Pph No 6') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 6') ?></th>
                            <th><?= __('Payment Termin Ppn 6') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 6') ?></th>
                            <th><?= __('Payment Termin Is 7') ?></th>
                            <th><?= __('Payment Termin Is Date 7') ?></th>
                            <th><?= __('Payment Termin Method 7') ?></th>
                            <th><?= __('Payment Termin Jumlah 7') ?></th>
                            <th><?= __('Payment Termin Date 7') ?></th>
                            <th><?= __('Payment Termin Pph 7') ?></th>
                            <th><?= __('Payment Termin Pph No 7') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 7') ?></th>
                            <th><?= __('Payment Termin Ppn 7') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 7') ?></th>
                            <th><?= __('Payment Termin Is 8') ?></th>
                            <th><?= __('Payment Termin Is Date 8') ?></th>
                            <th><?= __('Payment Termin Method 8') ?></th>
                            <th><?= __('Payment Termin Jumlah 8') ?></th>
                            <th><?= __('Payment Termin Date 8') ?></th>
                            <th><?= __('Payment Termin Pph 8') ?></th>
                            <th><?= __('Payment Termin Pph No 8') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 8') ?></th>
                            <th><?= __('Payment Termin Ppn 8') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 8') ?></th>
                            <th><?= __('Payment Termin Is 9') ?></th>
                            <th><?= __('Payment Termin Is Date 9') ?></th>
                            <th><?= __('Payment Termin Method 9') ?></th>
                            <th><?= __('Payment Termin Jumlah 9') ?></th>
                            <th><?= __('Payment Termin Date 9') ?></th>
                            <th><?= __('Payment Termin Pph 9') ?></th>
                            <th><?= __('Payment Termin Pph No 9') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 9') ?></th>
                            <th><?= __('Payment Termin Ppn 9') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 9') ?></th>
                            <th><?= __('Payment Termin Is 10') ?></th>
                            <th><?= __('Payment Termin Is Date 10') ?></th>
                            <th><?= __('Payment Termin Method 10') ?></th>
                            <th><?= __('Payment Termin Jumlah 10') ?></th>
                            <th><?= __('Payment Termin Date 10') ?></th>
                            <th><?= __('Payment Termin Pph 10') ?></th>
                            <th><?= __('Payment Termin Pph No 10') ?></th>
                            <th><?= __('Payment Termin Pph Jumlah 10') ?></th>
                            <th><?= __('Payment Termin Ppn 10') ?></th>
                            <th><?= __('Payment Termin Ppn Jumlah 10') ?></th>
                            <th><?= __('Biaya Bank') ?></th>
                            <th><?= __('Pembulatan') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Komisi 1') ?></th>
                            <th><?= __('Komisi 2') ?></th>
                            <th><?= __('Komisi 3') ?></th>
                            <th><?= __('Komisi 4') ?></th>
                            <th><?= __('Komisi 5') ?></th>
                            <th><?= __('Rpt Berita Acara') ?></th>
                            <th><?= __('Rpt Berita Acara Date') ?></th>
                            <th><?= __('Rpt Invoice') ?></th>
                            <th><?= __('Rpt Invoice Date') ?></th>
                            <th><?= __('Rpt Tax Invoice') ?></th>
                            <th><?= __('Rpt Tax Invoice Date') ?></th>
                            <th><?= __('Pph No') ?></th>
                            <th><?= __('Pph Date') ?></th>
                            <th><?= __('Pph Jumlah') ?></th>
                            <th><?= __('Ppn 900 Date') ?></th>
                            <th><?= __('Ppn 900 Jumlah') ?></th>
                            <th><?= __('Delivery') ?></th>
                            <th><?= __('Delivery Date') ?></th>
                            <th><?= __('Delivery Media') ?></th>
                            <th><?= __('Delivery Up') ?></th>
                            <th><?= __('Delivery Desc All') ?></th>
                            <th><?= __('Delivery Desc') ?></th>
                            <th><?= __('Receive Date') ?></th>
                            <th><?= __('Receive') ?></th>
                            <th><?= __('Sign Id') ?></th>
                            <th><?= __('Director') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Posting Date') ?></th>
                            <th><?= __('Pay Promise Is 1') ?></th>
                            <th><?= __('Pay Promise Date 1') ?></th>
                            <th><?= __('Pay Promise Date Payment 1') ?></th>
                            <th><?= __('Pay Promise Who 1') ?></th>
                            <th><?= __('Pay Promise Desc 1') ?></th>
                            <th><?= __('Pay Promise Is 2') ?></th>
                            <th><?= __('Pay Promise Date 2') ?></th>
                            <th><?= __('Pay Promise Date Payment 2') ?></th>
                            <th><?= __('Pay Promise Who 2') ?></th>
                            <th><?= __('Pay Promise Desc 2') ?></th>
                            <th><?= __('Pay Promise Is 3') ?></th>
                            <th><?= __('Pay Promise Date 3') ?></th>
                            <th><?= __('Pay Promise Date Payment 3') ?></th>
                            <th><?= __('Pay Promise Who 3') ?></th>
                            <th><?= __('Pay Promise Desc 3') ?></th>
                            <th><?= __('Pay Promise Is 4') ?></th>
                            <th><?= __('Pay Promise Date 4') ?></th>
                            <th><?= __('Pay Promise Date Payment 4') ?></th>
                            <th><?= __('Pay Promise Who 4') ?></th>
                            <th><?= __('Pay Promise Desc 4') ?></th>
                            <th><?= __('Pay Promise Is 5') ?></th>
                            <th><?= __('Pay Promise Date 5') ?></th>
                            <th><?= __('Pay Promise Date Payment 5') ?></th>
                            <th><?= __('Pay Promise Who 5') ?></th>
                            <th><?= __('Pay Promise Desc 5') ?></th>
                            <th><?= __('Pay Promise Is 6') ?></th>
                            <th><?= __('Pay Promise Date 6') ?></th>
                            <th><?= __('Pay Promise Date Payment 6') ?></th>
                            <th><?= __('Pay Promise Who 6') ?></th>
                            <th><?= __('Pay Promise Desc 6') ?></th>
                            <th><?= __('Pay Promise Is 7') ?></th>
                            <th><?= __('Pay Promise Date 7') ?></th>
                            <th><?= __('Pay Promise Date Payment 7') ?></th>
                            <th><?= __('Pay Promise Who 7') ?></th>
                            <th><?= __('Pay Promise Desc 7') ?></th>
                            <th><?= __('Pay Promise Is 8') ?></th>
                            <th><?= __('Pay Promise Date 8') ?></th>
                            <th><?= __('Pay Promise Date Payment 8') ?></th>
                            <th><?= __('Pay Promise Who 8') ?></th>
                            <th><?= __('Pay Promise Desc 8') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->invoices as $invoices) : ?>
                        <tr>
                            <td><?= h($invoices->id) ?></td>
                            <td><?= h($invoices->branch_id) ?></td>
                            <td><?= h($invoices->parent_invoice_id) ?></td>
                            <td><?= h($invoices->acc_journal_payment_id) ?></td>
                            <td><?= h($invoices->number) ?></td>
                            <td><?= h($invoices->number_old) ?></td>
                            <td><?= h($invoices->number_noppn) ?></td>
                            <td><?= h($invoices->ppn) ?></td>
                            <td><?= h($invoices->tax) ?></td>
                            <td><?= h($invoices->taxing) ?></td>
                            <td><?= h($invoices->pph) ?></td>
                            <td><?= h($invoices->from) ?></td>
                            <td><?= h($invoices->customer_id) ?></td>
                            <td><?= h($invoices->mou_id) ?></td>
                            <td><?= h($invoices->deposit) ?></td>
                            <td><?= h($invoices->beginning_deposit) ?></td>
                            <td><?= h($invoices->rest_deposit) ?></td>
                            <td><?= h($invoices->cost) ?></td>
                            <td><?= h($invoices->number_tax_invoice) ?></td>
                            <td><?= h($invoices->commission) ?></td>
                            <td><?= h($invoices->date) ?></td>
                            <td><?= h($invoices->due_date) ?></td>
                            <td><?= h($invoices->referense_po) ?></td>
                            <td><?= h($invoices->transport) ?></td>
                            <td><?= h($invoices->transport_quantity) ?></td>
                            <td><?= h($invoices->transport_unit) ?></td>
                            <td><?= h($invoices->transport_date) ?></td>
                            <td><?= h($invoices->transport_2) ?></td>
                            <td><?= h($invoices->transport_quantity_2) ?></td>
                            <td><?= h($invoices->transport_unit_2) ?></td>
                            <td><?= h($invoices->transport_2_date) ?></td>
                            <td><?= h($invoices->handling) ?></td>
                            <td><?= h($invoices->handling_quantity) ?></td>
                            <td><?= h($invoices->handling_unit) ?></td>
                            <td><?= h($invoices->handling_date) ?></td>
                            <td><?= h($invoices->sales_discounts) ?></td>
                            <td><?= h($invoices->discount) ?></td>
                            <td><?= h($invoices->discount_percent) ?></td>
                            <td><?= h($invoices->discount_nominal) ?></td>
                            <td><?= h($invoices->discount_price) ?></td>
                            <td><?= h($invoices->discount_quantity) ?></td>
                            <td><?= h($invoices->discount_unit) ?></td>
                            <td><?= h($invoices->biaya_lain_date) ?></td>
                            <td><?= h($invoices->biaya_lain) ?></td>
                            <td><?= h($invoices->biaya_lain_quantity) ?></td>
                            <td><?= h($invoices->biaya_lain_unit) ?></td>
                            <td><?= h($invoices->biaya_lain_desc) ?></td>
                            <td><?= h($invoices->biaya_lain_date_2) ?></td>
                            <td><?= h($invoices->biaya_lain_2) ?></td>
                            <td><?= h($invoices->biaya_lain_quantity_2) ?></td>
                            <td><?= h($invoices->biaya_lain_unit_2) ?></td>
                            <td><?= h($invoices->biaya_lain_desc_2) ?></td>
                            <td><?= h($invoices->biaya_lain_date_3) ?></td>
                            <td><?= h($invoices->biaya_lain_quantity_3) ?></td>
                            <td><?= h($invoices->biaya_lain_3) ?></td>
                            <td><?= h($invoices->biaya_lain_unit_3) ?></td>
                            <td><?= h($invoices->biaya_lain_desc_3) ?></td>
                            <td><?= h($invoices->biaya_lain_date_4) ?></td>
                            <td><?= h($invoices->biaya_lain_4) ?></td>
                            <td><?= h($invoices->biaya_lain_quantity_4) ?></td>
                            <td><?= h($invoices->biaya_lain_unit_4) ?></td>
                            <td><?= h($invoices->biaya_lain_desc_4) ?></td>
                            <td><?= h($invoices->biaya_lain_date_5) ?></td>
                            <td><?= h($invoices->biaya_lain_5) ?></td>
                            <td><?= h($invoices->biaya_lain_quantity_5) ?></td>
                            <td><?= h($invoices->biaya_lain_unit_5) ?></td>
                            <td><?= h($invoices->biaya_lain_desc_5) ?></td>
                            <td><?= h($invoices->payment) ?></td>
                            <td><?= h($invoices->payment_status) ?></td>
                            <td><?= h($invoices->payment_date) ?></td>
                            <td><?= h($invoices->payment_who) ?></td>
                            <td><?= h($invoices->payment_who_date) ?></td>
                            <td><?= h($invoices->payment_jumlah_ori) ?></td>
                            <td><?= h($invoices->payment_jumlah) ?></td>
                            <td><?= h($invoices->payment_desc) ?></td>
                            <td><?= h($invoices->payment_method) ?></td>
                            <td><?= h($invoices->payment_bank) ?></td>
                            <td><?= h($invoices->payment_bank_va) ?></td>
                            <td><?= h($invoices->payment_mou_is) ?></td>
                            <td><?= h($invoices->payment_mou_saldo) ?></td>
                            <td><?= h($invoices->payment_mou_date) ?></td>
                            <td><?= h($invoices->payment_termin_is_1) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_1) ?></td>
                            <td><?= h($invoices->payment_termin_method_1) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_1) ?></td>
                            <td><?= h($invoices->payment_termin_date_1) ?></td>
                            <td><?= h($invoices->payment_termin_pph_1) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_1) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_1) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_1) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_1) ?></td>
                            <td><?= h($invoices->payment_termin_is_2) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_2) ?></td>
                            <td><?= h($invoices->payment_termin_method_2) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_2) ?></td>
                            <td><?= h($invoices->payment_termin_date_2) ?></td>
                            <td><?= h($invoices->payment_termin_pph_2) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_2) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_2) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_2) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_2) ?></td>
                            <td><?= h($invoices->payment_termin_is_3) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_3) ?></td>
                            <td><?= h($invoices->payment_termin_method_3) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_3) ?></td>
                            <td><?= h($invoices->payment_termin_date_3) ?></td>
                            <td><?= h($invoices->payment_termin_pph_3) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_3) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_3) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_3) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_3) ?></td>
                            <td><?= h($invoices->payment_termin_is_4) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_4) ?></td>
                            <td><?= h($invoices->payment_termin_method_4) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_4) ?></td>
                            <td><?= h($invoices->payment_termin_date_4) ?></td>
                            <td><?= h($invoices->payment_termin_pph_4) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_4) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_4) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_4) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_4) ?></td>
                            <td><?= h($invoices->payment_termin_is_5) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_5) ?></td>
                            <td><?= h($invoices->payment_termin_method_5) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_5) ?></td>
                            <td><?= h($invoices->payment_termin_date_5) ?></td>
                            <td><?= h($invoices->payment_termin_pph_5) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_5) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_5) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_5) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_5) ?></td>
                            <td><?= h($invoices->payment_termin_is_6) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_6) ?></td>
                            <td><?= h($invoices->payment_termin_method_6) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_6) ?></td>
                            <td><?= h($invoices->payment_termin_date_6) ?></td>
                            <td><?= h($invoices->payment_termin_pph_6) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_6) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_6) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_6) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_6) ?></td>
                            <td><?= h($invoices->payment_termin_is_7) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_7) ?></td>
                            <td><?= h($invoices->payment_termin_method_7) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_7) ?></td>
                            <td><?= h($invoices->payment_termin_date_7) ?></td>
                            <td><?= h($invoices->payment_termin_pph_7) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_7) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_7) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_7) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_7) ?></td>
                            <td><?= h($invoices->payment_termin_is_8) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_8) ?></td>
                            <td><?= h($invoices->payment_termin_method_8) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_8) ?></td>
                            <td><?= h($invoices->payment_termin_date_8) ?></td>
                            <td><?= h($invoices->payment_termin_pph_8) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_8) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_8) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_8) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_8) ?></td>
                            <td><?= h($invoices->payment_termin_is_9) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_9) ?></td>
                            <td><?= h($invoices->payment_termin_method_9) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_9) ?></td>
                            <td><?= h($invoices->payment_termin_date_9) ?></td>
                            <td><?= h($invoices->payment_termin_pph_9) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_9) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_9) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_9) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_9) ?></td>
                            <td><?= h($invoices->payment_termin_is_10) ?></td>
                            <td><?= h($invoices->payment_termin_is_date_10) ?></td>
                            <td><?= h($invoices->payment_termin_method_10) ?></td>
                            <td><?= h($invoices->payment_termin_jumlah_10) ?></td>
                            <td><?= h($invoices->payment_termin_date_10) ?></td>
                            <td><?= h($invoices->payment_termin_pph_10) ?></td>
                            <td><?= h($invoices->payment_termin_pph_no_10) ?></td>
                            <td><?= h($invoices->payment_termin_pph_jumlah_10) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_10) ?></td>
                            <td><?= h($invoices->payment_termin_ppn_jumlah_10) ?></td>
                            <td><?= h($invoices->biaya_bank) ?></td>
                            <td><?= h($invoices->pembulatan) ?></td>
                            <td><?= h($invoices->description) ?></td>
                            <td><?= h($invoices->komisi_1) ?></td>
                            <td><?= h($invoices->komisi_2) ?></td>
                            <td><?= h($invoices->komisi_3) ?></td>
                            <td><?= h($invoices->komisi_4) ?></td>
                            <td><?= h($invoices->komisi_5) ?></td>
                            <td><?= h($invoices->rpt_berita_acara) ?></td>
                            <td><?= h($invoices->rpt_berita_acara_date) ?></td>
                            <td><?= h($invoices->rpt_invoice) ?></td>
                            <td><?= h($invoices->rpt_invoice_date) ?></td>
                            <td><?= h($invoices->rpt_tax_invoice) ?></td>
                            <td><?= h($invoices->rpt_tax_invoice_date) ?></td>
                            <td><?= h($invoices->pph_no) ?></td>
                            <td><?= h($invoices->pph_date) ?></td>
                            <td><?= h($invoices->pph_jumlah) ?></td>
                            <td><?= h($invoices->ppn_900_date) ?></td>
                            <td><?= h($invoices->ppn_900_jumlah) ?></td>
                            <td><?= h($invoices->delivery) ?></td>
                            <td><?= h($invoices->delivery_date) ?></td>
                            <td><?= h($invoices->delivery_media) ?></td>
                            <td><?= h($invoices->delivery_up) ?></td>
                            <td><?= h($invoices->delivery_desc_all) ?></td>
                            <td><?= h($invoices->delivery_desc) ?></td>
                            <td><?= h($invoices->receive_date) ?></td>
                            <td><?= h($invoices->receive) ?></td>
                            <td><?= h($invoices->sign_id) ?></td>
                            <td><?= h($invoices->director) ?></td>
                            <td><?= h($invoices->posting) ?></td>
                            <td><?= h($invoices->posting_date) ?></td>
                            <td><?= h($invoices->pay_promise_is_1) ?></td>
                            <td><?= h($invoices->pay_promise_date_1) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_1) ?></td>
                            <td><?= h($invoices->pay_promise_who_1) ?></td>
                            <td><?= h($invoices->pay_promise_desc_1) ?></td>
                            <td><?= h($invoices->pay_promise_is_2) ?></td>
                            <td><?= h($invoices->pay_promise_date_2) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_2) ?></td>
                            <td><?= h($invoices->pay_promise_who_2) ?></td>
                            <td><?= h($invoices->pay_promise_desc_2) ?></td>
                            <td><?= h($invoices->pay_promise_is_3) ?></td>
                            <td><?= h($invoices->pay_promise_date_3) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_3) ?></td>
                            <td><?= h($invoices->pay_promise_who_3) ?></td>
                            <td><?= h($invoices->pay_promise_desc_3) ?></td>
                            <td><?= h($invoices->pay_promise_is_4) ?></td>
                            <td><?= h($invoices->pay_promise_date_4) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_4) ?></td>
                            <td><?= h($invoices->pay_promise_who_4) ?></td>
                            <td><?= h($invoices->pay_promise_desc_4) ?></td>
                            <td><?= h($invoices->pay_promise_is_5) ?></td>
                            <td><?= h($invoices->pay_promise_date_5) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_5) ?></td>
                            <td><?= h($invoices->pay_promise_who_5) ?></td>
                            <td><?= h($invoices->pay_promise_desc_5) ?></td>
                            <td><?= h($invoices->pay_promise_is_6) ?></td>
                            <td><?= h($invoices->pay_promise_date_6) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_6) ?></td>
                            <td><?= h($invoices->pay_promise_who_6) ?></td>
                            <td><?= h($invoices->pay_promise_desc_6) ?></td>
                            <td><?= h($invoices->pay_promise_is_7) ?></td>
                            <td><?= h($invoices->pay_promise_date_7) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_7) ?></td>
                            <td><?= h($invoices->pay_promise_who_7) ?></td>
                            <td><?= h($invoices->pay_promise_desc_7) ?></td>
                            <td><?= h($invoices->pay_promise_is_8) ?></td>
                            <td><?= h($invoices->pay_promise_date_8) ?></td>
                            <td><?= h($invoices->pay_promise_date_payment_8) ?></td>
                            <td><?= h($invoices->pay_promise_who_8) ?></td>
                            <td><?= h($invoices->pay_promise_desc_8) ?></td>
                            <td><?= h($invoices->who_create) ?></td>
                            <td><?= h($invoices->created) ?></td>
                            <td><?= h($invoices->who_update) ?></td>
                            <td><?= h($invoices->modified) ?></td>
                            <td><?= h($invoices->active) ?></td>
                            <td><?= h($invoices->status) ?></td>
                            <td><?= h($invoices->is_log) ?></td>
                            <td><?= h($invoices->is_create) ?></td>
                            <td><?= h($invoices->is_update) ?></td>
                            <td><?= h($invoices->is_delete) ?></td>
                            <td><?= h($invoices->deleted) ?></td>
                            <td><?= h($invoices->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoices->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoices->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Invoices', 'action' => 'delete', $invoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoices->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Manifest Insides') ?></h4>
                <?php if (!empty($customer->manifest_insides)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Date Manifest Mix') ?></th>
                            <th><?= __('Is Manifest Mix') ?></th>
                            <th><?= __('Permit Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Waste Id') ?></th>
                            <th><?= __('Vacancies') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Quantity Get') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Packing') ?></th>
                            <th><?= __('Date Entry') ?></th>
                            <th><?= __('Klh') ?></th>
                            <th><?= __('Date Shipping') ?></th>
                            <th><?= __('Shipping Purpose Id') ?></th>
                            <th><?= __('Transporter Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Processor Unit') ?></th>
                            <th><?= __('Processor Price') ?></th>
                            <th><?= __('Truck Id') ?></th>
                            <th><?= __('Driver Id') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Print') ?></th>
                            <th><?= __('Complete Permit') ?></th>
                            <th><?= __('Complete Permit Date') ?></th>
                            <th><?= __('Complete Weigh Letter') ?></th>
                            <th><?= __('Complete Weigh Letter Date') ?></th>
                            <th><?= __('Complete Manifest') ?></th>
                            <th><?= __('Complete Manifest Date') ?></th>
                            <th><?= __('Complete Desc') ?></th>
                            <th><?= __('Print Date') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->manifest_insides as $manifestInsides) : ?>
                        <tr>
                            <td><?= h($manifestInsides->id) ?></td>
                            <td><?= h($manifestInsides->branch_id) ?></td>
                            <td><?= h($manifestInsides->manifest_id) ?></td>
                            <td><?= h($manifestInsides->date_manifest_mix) ?></td>
                            <td><?= h($manifestInsides->is_manifest_mix) ?></td>
                            <td><?= h($manifestInsides->permit_id) ?></td>
                            <td><?= h($manifestInsides->number) ?></td>
                            <td><?= h($manifestInsides->code) ?></td>
                            <td><?= h($manifestInsides->type) ?></td>
                            <td><?= h($manifestInsides->customer_id) ?></td>
                            <td><?= h($manifestInsides->waste_id) ?></td>
                            <td><?= h($manifestInsides->vacancies) ?></td>
                            <td><?= h($manifestInsides->quantity) ?></td>
                            <td><?= h($manifestInsides->quantity_get) ?></td>
                            <td><?= h($manifestInsides->unit) ?></td>
                            <td><?= h($manifestInsides->packing) ?></td>
                            <td><?= h($manifestInsides->date_entry) ?></td>
                            <td><?= h($manifestInsides->klh) ?></td>
                            <td><?= h($manifestInsides->date_shipping) ?></td>
                            <td><?= h($manifestInsides->shipping_purpose_id) ?></td>
                            <td><?= h($manifestInsides->transporter_id) ?></td>
                            <td><?= h($manifestInsides->processor_id) ?></td>
                            <td><?= h($manifestInsides->processor_unit) ?></td>
                            <td><?= h($manifestInsides->processor_price) ?></td>
                            <td><?= h($manifestInsides->truck_id) ?></td>
                            <td><?= h($manifestInsides->driver_id) ?></td>
                            <td><?= h($manifestInsides->is_print) ?></td>
                            <td><?= h($manifestInsides->print) ?></td>
                            <td><?= h($manifestInsides->complete_permit) ?></td>
                            <td><?= h($manifestInsides->complete_permit_date) ?></td>
                            <td><?= h($manifestInsides->complete_weigh_letter) ?></td>
                            <td><?= h($manifestInsides->complete_weigh_letter_date) ?></td>
                            <td><?= h($manifestInsides->complete_manifest) ?></td>
                            <td><?= h($manifestInsides->complete_manifest_date) ?></td>
                            <td><?= h($manifestInsides->complete_desc) ?></td>
                            <td><?= h($manifestInsides->print_date) ?></td>
                            <td><?= h($manifestInsides->who_create) ?></td>
                            <td><?= h($manifestInsides->created) ?></td>
                            <td><?= h($manifestInsides->who_update) ?></td>
                            <td><?= h($manifestInsides->modified) ?></td>
                            <td><?= h($manifestInsides->is_create) ?></td>
                            <td><?= h($manifestInsides->is_update) ?></td>
                            <td><?= h($manifestInsides->is_delete) ?></td>
                            <td><?= h($manifestInsides->deleted) ?></td>
                            <td><?= h($manifestInsides->is_active) ?></td>
                            <td><?= h($manifestInsides->is_log) ?></td>
                            <td><?= h($manifestInsides->active) ?></td>
                            <td><?= h($manifestInsides->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ManifestInsides', 'action' => 'view', $manifestInsides->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ManifestInsides', 'action' => 'edit', $manifestInsides->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ManifestInsides', 'action' => 'delete', $manifestInsides->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manifestInsides->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Manifest Processors') ?></h4>
                <?php if (!empty($customer->manifest_processors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Delivery') ?></th>
                            <th><?= __('Delivery Date') ?></th>
                            <th><?= __('Delivery Media') ?></th>
                            <th><?= __('Delivery Up') ?></th>
                            <th><?= __('Delivery Desc All') ?></th>
                            <th><?= __('Delivery Desc') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Printed') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Cancel') ?></th>
                            <th><?= __('Canceled') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Status Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->manifest_processors as $manifestProcessors) : ?>
                        <tr>
                            <td><?= h($manifestProcessors->id) ?></td>
                            <td><?= h($manifestProcessors->branch_id) ?></td>
                            <td><?= h($manifestProcessors->manifest_id) ?></td>
                            <td><?= h($manifestProcessors->customer_id) ?></td>
                            <td><?= h($manifestProcessors->mou_id) ?></td>
                            <td><?= h($manifestProcessors->code) ?></td>
                            <td><?= h($manifestProcessors->date) ?></td>
                            <td><?= h($manifestProcessors->delivery) ?></td>
                            <td><?= h($manifestProcessors->delivery_date) ?></td>
                            <td><?= h($manifestProcessors->delivery_media) ?></td>
                            <td><?= h($manifestProcessors->delivery_up) ?></td>
                            <td><?= h($manifestProcessors->delivery_desc_all) ?></td>
                            <td><?= h($manifestProcessors->delivery_desc) ?></td>
                            <td><?= h($manifestProcessors->is_print) ?></td>
                            <td><?= h($manifestProcessors->printed) ?></td>
                            <td><?= h($manifestProcessors->is_create) ?></td>
                            <td><?= h($manifestProcessors->created) ?></td>
                            <td><?= h($manifestProcessors->is_update) ?></td>
                            <td><?= h($manifestProcessors->modified) ?></td>
                            <td><?= h($manifestProcessors->is_delete) ?></td>
                            <td><?= h($manifestProcessors->deleted) ?></td>
                            <td><?= h($manifestProcessors->is_cancel) ?></td>
                            <td><?= h($manifestProcessors->canceled) ?></td>
                            <td><?= h($manifestProcessors->is_active) ?></td>
                            <td><?= h($manifestProcessors->is_status) ?></td>
                            <td><?= h($manifestProcessors->is_log) ?></td>
                            <td><?= h($manifestProcessors->status) ?></td>
                            <td><?= h($manifestProcessors->status_date) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ManifestProcessors', 'action' => 'view', $manifestProcessors->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ManifestProcessors', 'action' => 'edit', $manifestProcessors->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ManifestProcessors', 'action' => 'delete', $manifestProcessors->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manifestProcessors->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Manifests') ?></h4>
                <?php if (!empty($customer->manifests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Sjp Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Acc Journal Piutang Deposit Id') ?></th>
                            <th><?= __('Acc Journal Piutang Selisih Id') ?></th>
                            <th><?= __('Acc Journal Hutang Id Old') ?></th>
                            <th><?= __('Acc Journal Hutang Id') ?></th>
                            <th><?= __('Invoice Hutang Id') ?></th>
                            <th><?= __('Permit Id') ?></th>
                            <th><?= __('Permit Code') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('No Festronik') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Type Ori') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Fake') ?></th>
                            <th><?= __('Package Status') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Waste Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Waste Price Id') ?></th>
                            <th><?= __('Marketing Id') ?></th>
                            <th><?= __('Manifest Processor Id') ?></th>
                            <th><?= __('Order Id') ?></th>
                            <th><?= __('Truck Schedule Id') ?></th>
                            <th><?= __('Vacancies') ?></th>
                            <th><?= __('Vacancies Date') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Price Netto') ?></th>
                            <th><?= __('Quantity Ori') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Quantity O') ?></th>
                            <th><?= __('Price Min') ?></th>
                            <th><?= __('Qty Min') ?></th>
                            <th><?= __('Cost Of Sales') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Packing') ?></th>
                            <th><?= __('Pcs') ?></th>
                            <th><?= __('Date Shipping') ?></th>
                            <th><?= __('Shipping Purpose Id') ?></th>
                            <th><?= __('Transporter Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Processor Unit') ?></th>
                            <th><?= __('Processor Price') ?></th>
                            <th><?= __('Truck Id') ?></th>
                            <th><?= __('Driver Id') ?></th>
                            <th><?= __('Moda Truck Id') ?></th>
                            <th><?= __('Moda Driver Id') ?></th>
                            <th><?= __('Nopol') ?></th>
                            <th><?= __('Driver') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Print') ?></th>
                            <th><?= __('Complete Manifest 1') ?></th>
                            <th><?= __('Complete Manifest 1 Date') ?></th>
                            <th><?= __('Complete Manifest 2') ?></th>
                            <th><?= __('Complete Manifest 2 Date') ?></th>
                            <th><?= __('Complete Manifest 3') ?></th>
                            <th><?= __('Complete Manifest 3 Date') ?></th>
                            <th><?= __('Complete Manifest 4') ?></th>
                            <th><?= __('Complete Manifest 4 Date') ?></th>
                            <th><?= __('Complete Manifest 5') ?></th>
                            <th><?= __('Complete Manifest 5 Date') ?></th>
                            <th><?= __('Complete Manifest 6') ?></th>
                            <th><?= __('Complete Manifest 6 Date') ?></th>
                            <th><?= __('Complete Manifest 7') ?></th>
                            <th><?= __('Complete Manifest 7 Date') ?></th>
                            <th><?= __('Complete Permit 1') ?></th>
                            <th><?= __('Complete Permit 1 Date') ?></th>
                            <th><?= __('Complete Permit 2') ?></th>
                            <th><?= __('Complete Permit 2 Date') ?></th>
                            <th><?= __('Complete Permit 3') ?></th>
                            <th><?= __('Complete Permit 3 Date') ?></th>
                            <th><?= __('Complete Permit 4') ?></th>
                            <th><?= __('Complete Permit 4 Date') ?></th>
                            <th><?= __('Complete Permit Customer') ?></th>
                            <th><?= __('Complete Permit Customer Date') ?></th>
                            <th><?= __('Complete Permit Processor') ?></th>
                            <th><?= __('Complete Permit Processor Date') ?></th>
                            <th><?= __('Complete Stempel Customer') ?></th>
                            <th><?= __('Complete Stempel Customer Date') ?></th>
                            <th><?= __('Complete Stempel Processor') ?></th>
                            <th><?= __('Complete Stempel Processor Date') ?></th>
                            <th><?= __('Complete Barcode') ?></th>
                            <th><?= __('Complete Barcode Date') ?></th>
                            <th><?= __('Complete Date In Customer') ?></th>
                            <th><?= __('Complete Date In Customer Is') ?></th>
                            <th><?= __('Complete Date In Customer Date') ?></th>
                            <th><?= __('Complete Date In Processor') ?></th>
                            <th><?= __('Complete Date In Processor Is') ?></th>
                            <th><?= __('Complete Date In Processor Date') ?></th>
                            <th><?= __('Complete Permit') ?></th>
                            <th><?= __('Complete Permit Date') ?></th>
                            <th><?= __('Complete Weigh Letter') ?></th>
                            <th><?= __('Complete Weigh Letter Date') ?></th>
                            <th><?= __('Complete Date Transport') ?></th>
                            <th><?= __('Complete Date Transport Is') ?></th>
                            <th><?= __('Complete Date Transport Date') ?></th>
                            <th><?= __('Complete Manifest') ?></th>
                            <th><?= __('Complete Manifest Date') ?></th>
                            <th><?= __('Complete Manifest Transport') ?></th>
                            <th><?= __('Complete Manifest Transport Date') ?></th>
                            <th><?= __('Complete Permit Transport') ?></th>
                            <th><?= __('Complete Permit Transport Date') ?></th>
                            <th><?= __('Complete Weigh Letter Transport') ?></th>
                            <th><?= __('Complete Weigh Letter Transport Date') ?></th>
                            <th><?= __('Complete Desc Transport') ?></th>
                            <th><?= __('Complete Desc') ?></th>
                            <th><?= __('Complete Approve') ?></th>
                            <th><?= __('Complete Approve Date') ?></th>
                            <th><?= __('Complete Approve Status') ?></th>
                            <th><?= __('Complete Approve Desc') ?></th>
                            <th><?= __('Description Cancel') ?></th>
                            <th><?= __('Date Received') ?></th>
                            <th><?= __('Total Submited1') ?></th>
                            <th><?= __('Total Submited') ?></th>
                            <th><?= __('Total Submited Unit') ?></th>
                            <th><?= __('Is Manifest In') ?></th>
                            <th><?= __('Date Manifest In') ?></th>
                            <th><?= __('Is Manifest Out') ?></th>
                            <th><?= __('Date Manifest Out') ?></th>
                            <th><?= __('Print Date') ?></th>
                            <th><?= __('Cor Id') ?></th>
                            <th><?= __('Cot Id') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Cancel') ?></th>
                            <th><?= __('Canceled') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Is Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Status Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->manifests as $manifests) : ?>
                        <tr>
                            <td><?= h($manifests->id) ?></td>
                            <td><?= h($manifests->branch_id) ?></td>
                            <td><?= h($manifests->sjp_id) ?></td>
                            <td><?= h($manifests->acc_journal_id) ?></td>
                            <td><?= h($manifests->acc_journal_piutang_deposit_id) ?></td>
                            <td><?= h($manifests->acc_journal_piutang_selisih_id) ?></td>
                            <td><?= h($manifests->acc_journal_hutang_id_old) ?></td>
                            <td><?= h($manifests->acc_journal_hutang_id) ?></td>
                            <td><?= h($manifests->invoice_hutang_id) ?></td>
                            <td><?= h($manifests->permit_id) ?></td>
                            <td><?= h($manifests->permit_code) ?></td>
                            <td><?= h($manifests->number) ?></td>
                            <td><?= h($manifests->no_festronik) ?></td>
                            <td><?= h($manifests->code) ?></td>
                            <td><?= h($manifests->type_ori) ?></td>
                            <td><?= h($manifests->type) ?></td>
                            <td><?= h($manifests->fake) ?></td>
                            <td><?= h($manifests->package_status) ?></td>
                            <td><?= h($manifests->invoice_id) ?></td>
                            <td><?= h($manifests->customer_id) ?></td>
                            <td><?= h($manifests->mou_id) ?></td>
                            <td><?= h($manifests->waste_id) ?></td>
                            <td><?= h($manifests->waste_type_id) ?></td>
                            <td><?= h($manifests->waste_price_id) ?></td>
                            <td><?= h($manifests->marketing_id) ?></td>
                            <td><?= h($manifests->manifest_processor_id) ?></td>
                            <td><?= h($manifests->order_id) ?></td>
                            <td><?= h($manifests->truck_schedule_id) ?></td>
                            <td><?= h($manifests->vacancies) ?></td>
                            <td><?= h($manifests->vacancies_date) ?></td>
                            <td><?= h($manifests->price) ?></td>
                            <td><?= h($manifests->price_netto) ?></td>
                            <td><?= h($manifests->quantity_ori) ?></td>
                            <td><?= h($manifests->quantity) ?></td>
                            <td><?= h($manifests->quantity_o) ?></td>
                            <td><?= h($manifests->price_min) ?></td>
                            <td><?= h($manifests->qty_min) ?></td>
                            <td><?= h($manifests->cost_of_sales) ?></td>
                            <td><?= h($manifests->unit) ?></td>
                            <td><?= h($manifests->packing) ?></td>
                            <td><?= h($manifests->pcs) ?></td>
                            <td><?= h($manifests->date_shipping) ?></td>
                            <td><?= h($manifests->shipping_purpose_id) ?></td>
                            <td><?= h($manifests->transporter_id) ?></td>
                            <td><?= h($manifests->processor_id) ?></td>
                            <td><?= h($manifests->processor_unit) ?></td>
                            <td><?= h($manifests->processor_price) ?></td>
                            <td><?= h($manifests->truck_id) ?></td>
                            <td><?= h($manifests->driver_id) ?></td>
                            <td><?= h($manifests->moda_truck_id) ?></td>
                            <td><?= h($manifests->moda_driver_id) ?></td>
                            <td><?= h($manifests->nopol) ?></td>
                            <td><?= h($manifests->driver) ?></td>
                            <td><?= h($manifests->is_print) ?></td>
                            <td><?= h($manifests->print) ?></td>
                            <td><?= h($manifests->complete_manifest_1) ?></td>
                            <td><?= h($manifests->complete_manifest_1_date) ?></td>
                            <td><?= h($manifests->complete_manifest_2) ?></td>
                            <td><?= h($manifests->complete_manifest_2_date) ?></td>
                            <td><?= h($manifests->complete_manifest_3) ?></td>
                            <td><?= h($manifests->complete_manifest_3_date) ?></td>
                            <td><?= h($manifests->complete_manifest_4) ?></td>
                            <td><?= h($manifests->complete_manifest_4_date) ?></td>
                            <td><?= h($manifests->complete_manifest_5) ?></td>
                            <td><?= h($manifests->complete_manifest_5_date) ?></td>
                            <td><?= h($manifests->complete_manifest_6) ?></td>
                            <td><?= h($manifests->complete_manifest_6_date) ?></td>
                            <td><?= h($manifests->complete_manifest_7) ?></td>
                            <td><?= h($manifests->complete_manifest_7_date) ?></td>
                            <td><?= h($manifests->complete_permit_1) ?></td>
                            <td><?= h($manifests->complete_permit_1_date) ?></td>
                            <td><?= h($manifests->complete_permit_2) ?></td>
                            <td><?= h($manifests->complete_permit_2_date) ?></td>
                            <td><?= h($manifests->complete_permit_3) ?></td>
                            <td><?= h($manifests->complete_permit_3_date) ?></td>
                            <td><?= h($manifests->complete_permit_4) ?></td>
                            <td><?= h($manifests->complete_permit_4_date) ?></td>
                            <td><?= h($manifests->complete_permit_customer) ?></td>
                            <td><?= h($manifests->complete_permit_customer_date) ?></td>
                            <td><?= h($manifests->complete_permit_processor) ?></td>
                            <td><?= h($manifests->complete_permit_processor_date) ?></td>
                            <td><?= h($manifests->complete_stempel_customer) ?></td>
                            <td><?= h($manifests->complete_stempel_customer_date) ?></td>
                            <td><?= h($manifests->complete_stempel_processor) ?></td>
                            <td><?= h($manifests->complete_stempel_processor_date) ?></td>
                            <td><?= h($manifests->complete_barcode) ?></td>
                            <td><?= h($manifests->complete_barcode_date) ?></td>
                            <td><?= h($manifests->complete_date_in_customer) ?></td>
                            <td><?= h($manifests->complete_date_in_customer_is) ?></td>
                            <td><?= h($manifests->complete_date_in_customer_date) ?></td>
                            <td><?= h($manifests->complete_date_in_processor) ?></td>
                            <td><?= h($manifests->complete_date_in_processor_is) ?></td>
                            <td><?= h($manifests->complete_date_in_processor_date) ?></td>
                            <td><?= h($manifests->complete_permit) ?></td>
                            <td><?= h($manifests->complete_permit_date) ?></td>
                            <td><?= h($manifests->complete_weigh_letter) ?></td>
                            <td><?= h($manifests->complete_weigh_letter_date) ?></td>
                            <td><?= h($manifests->complete_date_transport) ?></td>
                            <td><?= h($manifests->complete_date_transport_is) ?></td>
                            <td><?= h($manifests->complete_date_transport_date) ?></td>
                            <td><?= h($manifests->complete_manifest) ?></td>
                            <td><?= h($manifests->complete_manifest_date) ?></td>
                            <td><?= h($manifests->complete_manifest_transport) ?></td>
                            <td><?= h($manifests->complete_manifest_transport_date) ?></td>
                            <td><?= h($manifests->complete_permit_transport) ?></td>
                            <td><?= h($manifests->complete_permit_transport_date) ?></td>
                            <td><?= h($manifests->complete_weigh_letter_transport) ?></td>
                            <td><?= h($manifests->complete_weigh_letter_transport_date) ?></td>
                            <td><?= h($manifests->complete_desc_transport) ?></td>
                            <td><?= h($manifests->complete_desc) ?></td>
                            <td><?= h($manifests->complete_approve) ?></td>
                            <td><?= h($manifests->complete_approve_date) ?></td>
                            <td><?= h($manifests->complete_approve_status) ?></td>
                            <td><?= h($manifests->complete_approve_desc) ?></td>
                            <td><?= h($manifests->description_cancel) ?></td>
                            <td><?= h($manifests->date_received) ?></td>
                            <td><?= h($manifests->total_submited1) ?></td>
                            <td><?= h($manifests->total_submited) ?></td>
                            <td><?= h($manifests->total_submited_unit) ?></td>
                            <td><?= h($manifests->is_manifest_in) ?></td>
                            <td><?= h($manifests->date_manifest_in) ?></td>
                            <td><?= h($manifests->is_manifest_out) ?></td>
                            <td><?= h($manifests->date_manifest_out) ?></td>
                            <td><?= h($manifests->print_date) ?></td>
                            <td><?= h($manifests->cor_id) ?></td>
                            <td><?= h($manifests->cot_id) ?></td>
                            <td><?= h($manifests->who_create) ?></td>
                            <td><?= h($manifests->created) ?></td>
                            <td><?= h($manifests->who_update) ?></td>
                            <td><?= h($manifests->modified) ?></td>
                            <td><?= h($manifests->is_create) ?></td>
                            <td><?= h($manifests->is_update) ?></td>
                            <td><?= h($manifests->is_delete) ?></td>
                            <td><?= h($manifests->deleted) ?></td>
                            <td><?= h($manifests->is_cancel) ?></td>
                            <td><?= h($manifests->canceled) ?></td>
                            <td><?= h($manifests->is_active) ?></td>
                            <td><?= h($manifests->active) ?></td>
                            <td><?= h($manifests->is_status) ?></td>
                            <td><?= h($manifests->is_log) ?></td>
                            <td><?= h($manifests->status) ?></td>
                            <td><?= h($manifests->status_date) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Manifests', 'action' => 'view', $manifests->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Manifests', 'action' => 'edit', $manifests->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Manifests', 'action' => 'delete', $manifests->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manifests->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Mouses') ?></h4>
                <?php if (!empty($customer->mouses)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Transporter Id') ?></th>
                            <th><?= __('Template Id') ?></th>
                            <th><?= __('Invoice Name') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Code Name') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Date Contract') ?></th>
                            <th><?= __('Date Expired') ?></th>
                            <th><?= __('Deposit') ?></th>
                            <th><?= __('Date Deposit') ?></th>
                            <th><?= __('Saldo') ?></th>
                            <th><?= __('Saldo Use Journal') ?></th>
                            <th><?= __('Package Price') ?></th>
                            <th><?= __('Package Desc') ?></th>
                            <th><?= __('Bank Admin') ?></th>
                            <th><?= __('Delivery') ?></th>
                            <th><?= __('Delivery Date') ?></th>
                            <th><?= __('Delivery Media') ?></th>
                            <th><?= __('Delivery Up') ?></th>
                            <th><?= __('Delivery Desc All') ?></th>
                            <th><?= __('Delivery Desc') ?></th>
                            <th><?= __('Coldstorage') ?></th>
                            <th><?= __('Coldstorage Desc') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Class') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Price Netto') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Paket Desc') ?></th>
                            <th><?= __('Pic Name') ?></th>
                            <th><?= __('Pic Telp') ?></th>
                            <th><?= __('Pic Hp') ?></th>
                            <th><?= __('Pic Email') ?></th>
                            <th><?= __('Pic Title') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Template') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->mouses as $mouses) : ?>
                        <tr>
                            <td><?= h($mouses->id) ?></td>
                            <td><?= h($mouses->branch_id) ?></td>
                            <td><?= h($mouses->customer_id) ?></td>
                            <td><?= h($mouses->processor_id) ?></td>
                            <td><?= h($mouses->transporter_id) ?></td>
                            <td><?= h($mouses->template_id) ?></td>
                            <td><?= h($mouses->invoice_name) ?></td>
                            <td><?= h($mouses->code) ?></td>
                            <td><?= h($mouses->code_name) ?></td>
                            <td><?= h($mouses->name) ?></td>
                            <td><?= h($mouses->date_contract) ?></td>
                            <td><?= h($mouses->date_expired) ?></td>
                            <td><?= h($mouses->deposit) ?></td>
                            <td><?= h($mouses->date_deposit) ?></td>
                            <td><?= h($mouses->saldo) ?></td>
                            <td><?= h($mouses->saldo_use_journal) ?></td>
                            <td><?= h($mouses->package_price) ?></td>
                            <td><?= h($mouses->package_desc) ?></td>
                            <td><?= h($mouses->bank_admin) ?></td>
                            <td><?= h($mouses->delivery) ?></td>
                            <td><?= h($mouses->delivery_date) ?></td>
                            <td><?= h($mouses->delivery_media) ?></td>
                            <td><?= h($mouses->delivery_up) ?></td>
                            <td><?= h($mouses->delivery_desc_all) ?></td>
                            <td><?= h($mouses->delivery_desc) ?></td>
                            <td><?= h($mouses->coldstorage) ?></td>
                            <td><?= h($mouses->coldstorage_desc) ?></td>
                            <td><?= h($mouses->is_approve) ?></td>
                            <td><?= h($mouses->date_approve) ?></td>
                            <td><?= h($mouses->type) ?></td>
                            <td><?= h($mouses->class) ?></td>
                            <td><?= h($mouses->price) ?></td>
                            <td><?= h($mouses->price_netto) ?></td>
                            <td><?= h($mouses->unit) ?></td>
                            <td><?= h($mouses->paket_desc) ?></td>
                            <td><?= h($mouses->pic_name) ?></td>
                            <td><?= h($mouses->pic_telp) ?></td>
                            <td><?= h($mouses->pic_hp) ?></td>
                            <td><?= h($mouses->pic_email) ?></td>
                            <td><?= h($mouses->pic_title) ?></td>
                            <td><?= h($mouses->desc) ?></td>
                            <td><?= h($mouses->template) ?></td>
                            <td><?= h($mouses->is_active) ?></td>
                            <td><?= h($mouses->is_log) ?></td>
                            <td><?= h($mouses->is_create) ?></td>
                            <td><?= h($mouses->is_update) ?></td>
                            <td><?= h($mouses->who_create) ?></td>
                            <td><?= h($mouses->created) ?></td>
                            <td><?= h($mouses->who_update) ?></td>
                            <td><?= h($mouses->modified) ?></td>
                            <td><?= h($mouses->active) ?></td>
                            <td><?= h($mouses->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Mouses', 'action' => 'view', $mouses->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Mouses', 'action' => 'edit', $mouses->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Mouses', 'action' => 'delete', $mouses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mouses->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Offers') ?></h4>
                <?php if (!empty($customer->offers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Customer Name') ?></th>
                            <th><?= __('Customer Address') ?></th>
                            <th><?= __('Attn 1') ?></th>
                            <th><?= __('Attn 2') ?></th>
                            <th><?= __('Perihal') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Info') ?></th>
                            <th><?= __('Print') ?></th>
                            <th><?= __('Is Marketing') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Approve Date') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Print Date') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->offers as $offers) : ?>
                        <tr>
                            <td><?= h($offers->id) ?></td>
                            <td><?= h($offers->branch_id) ?></td>
                            <td><?= h($offers->number) ?></td>
                            <td><?= h($offers->code) ?></td>
                            <td><?= h($offers->date) ?></td>
                            <td><?= h($offers->customer_id) ?></td>
                            <td><?= h($offers->customer_name) ?></td>
                            <td><?= h($offers->customer_address) ?></td>
                            <td><?= h($offers->attn_1) ?></td>
                            <td><?= h($offers->attn_2) ?></td>
                            <td><?= h($offers->perihal) ?></td>
                            <td><?= h($offers->description) ?></td>
                            <td><?= h($offers->info) ?></td>
                            <td><?= h($offers->print) ?></td>
                            <td><?= h($offers->is_marketing) ?></td>
                            <td><?= h($offers->is_approve) ?></td>
                            <td><?= h($offers->approve_date) ?></td>
                            <td><?= h($offers->is_print) ?></td>
                            <td><?= h($offers->print_date) ?></td>
                            <td><?= h($offers->is_create) ?></td>
                            <td><?= h($offers->created) ?></td>
                            <td><?= h($offers->is_update) ?></td>
                            <td><?= h($offers->modified) ?></td>
                            <td><?= h($offers->is_delete) ?></td>
                            <td><?= h($offers->deleted) ?></td>
                            <td><?= h($offers->is_active) ?></td>
                            <td><?= h($offers->is_log) ?></td>
                            <td><?= h($offers->active) ?></td>
                            <td><?= h($offers->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Offers', 'action' => 'view', $offers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Offers', 'action' => 'edit', $offers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Offers', 'action' => 'delete', $offers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Operationals') ?></h4>
                <?php if (!empty($customer->operationals)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Permit Id') ?></th>
                            <th><?= __('No Surat Jalan') ?></th>
                            <th><?= __('Tgl Pengangkutan') ?></th>
                            <th><?= __('Jam Pengangkutan') ?></th>
                            <th><?= __('Tgl Pembongkaran') ?></th>
                            <th><?= __('Jam Pembongkaran') ?></th>
                            <th><?= __('Tgl Keterangan') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Lokasi Keterangan') ?></th>
                            <th><?= __('Km Awal') ?></th>
                            <th><?= __('Km Akhir') ?></th>
                            <th><?= __('Km Keterangan') ?></th>
                            <th><?= __('Truck Id') ?></th>
                            <th><?= __('Driver Id') ?></th>
                            <th><?= __('Helper Id') ?></th>
                            <th><?= __('Jenis Truk') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Taken') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Posting Date') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->operationals as $operationals) : ?>
                        <tr>
                            <td><?= h($operationals->id) ?></td>
                            <td><?= h($operationals->branch_id) ?></td>
                            <td><?= h($operationals->code) ?></td>
                            <td><?= h($operationals->permit_id) ?></td>
                            <td><?= h($operationals->no_surat_jalan) ?></td>
                            <td><?= h($operationals->tgl_pengangkutan) ?></td>
                            <td><?= h($operationals->jam_pengangkutan) ?></td>
                            <td><?= h($operationals->tgl_pembongkaran) ?></td>
                            <td><?= h($operationals->jam_pembongkaran) ?></td>
                            <td><?= h($operationals->tgl_keterangan) ?></td>
                            <td><?= h($operationals->customer_id) ?></td>
                            <td><?= h($operationals->processor_id) ?></td>
                            <td><?= h($operationals->lokasi_keterangan) ?></td>
                            <td><?= h($operationals->km_awal) ?></td>
                            <td><?= h($operationals->km_akhir) ?></td>
                            <td><?= h($operationals->km_keterangan) ?></td>
                            <td><?= h($operationals->truck_id) ?></td>
                            <td><?= h($operationals->driver_id) ?></td>
                            <td><?= h($operationals->helper_id) ?></td>
                            <td><?= h($operationals->jenis_truk) ?></td>
                            <td><?= h($operationals->status) ?></td>
                            <td><?= h($operationals->taken) ?></td>
                            <td><?= h($operationals->posting) ?></td>
                            <td><?= h($operationals->posting_date) ?></td>
                            <td><?= h($operationals->who_create) ?></td>
                            <td><?= h($operationals->created) ?></td>
                            <td><?= h($operationals->who_update) ?></td>
                            <td><?= h($operationals->modified) ?></td>
                            <td><?= h($operationals->is_create) ?></td>
                            <td><?= h($operationals->is_update) ?></td>
                            <td><?= h($operationals->is_delete) ?></td>
                            <td><?= h($operationals->deleted) ?></td>
                            <td><?= h($operationals->is_active) ?></td>
                            <td><?= h($operationals->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Operationals', 'action' => 'view', $operationals->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Operationals', 'action' => 'edit', $operationals->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Operationals', 'action' => 'delete', $operationals->id], ['confirm' => __('Are you sure you want to delete # {0}?', $operationals->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Order Regular Lines') ?></h4>
                <?php if (!empty($customer->order_regular_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Order Regular Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Waste Price Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Marketing Id') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->order_regular_lines as $orderRegularLines) : ?>
                        <tr>
                            <td><?= h($orderRegularLines->id) ?></td>
                            <td><?= h($orderRegularLines->order_regular_id) ?></td>
                            <td><?= h($orderRegularLines->customer_id) ?></td>
                            <td><?= h($orderRegularLines->waste_type_id) ?></td>
                            <td><?= h($orderRegularLines->waste_price_id) ?></td>
                            <td><?= h($orderRegularLines->mou_id) ?></td>
                            <td><?= h($orderRegularLines->marketing_id) ?></td>
                            <td><?= h($orderRegularLines->description) ?></td>
                            <td><?= h($orderRegularLines->is_create) ?></td>
                            <td><?= h($orderRegularLines->is_update) ?></td>
                            <td><?= h($orderRegularLines->is_delete) ?></td>
                            <td><?= h($orderRegularLines->created) ?></td>
                            <td><?= h($orderRegularLines->modified) ?></td>
                            <td><?= h($orderRegularLines->deleted) ?></td>
                            <td><?= h($orderRegularLines->is_active) ?></td>
                            <td><?= h($orderRegularLines->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrderRegularLines', 'action' => 'view', $orderRegularLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrderRegularLines', 'action' => 'edit', $orderRegularLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderRegularLines', 'action' => 'delete', $orderRegularLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderRegularLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Orders') ?></h4>
                <?php if (!empty($customer->orders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Po') ?></th>
                            <th><?= __('Qty Perkiraan') ?></th>
                            <th><?= __('Status Wait') ?></th>
                            <th><?= __('Status Approve') ?></th>
                            <th><?= __('Status Date') ?></th>
                            <th><?= __('Status Desc') ?></th>
                            <th><?= __('Waste Id') ?></th>
                            <th><?= __('Waste Price Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Order') ?></th>
                            <th><?= __('Date Order') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Date Manifest') ?></th>
                            <th><?= __('Date Estimate Schedule') ?></th>
                            <th><?= __('Permit Id') ?></th>
                            <th><?= __('Date Permit') ?></th>
                            <th><?= __('Truck Schedule Id') ?></th>
                            <th><?= __('Truck Schedule Date') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->orders as $orders) : ?>
                        <tr>
                            <td><?= h($orders->id) ?></td>
                            <td><?= h($orders->branch_id) ?></td>
                            <td><?= h($orders->customer_id) ?></td>
                            <td><?= h($orders->mou_id) ?></td>
                            <td><?= h($orders->number) ?></td>
                            <td><?= h($orders->po) ?></td>
                            <td><?= h($orders->qty_perkiraan) ?></td>
                            <td><?= h($orders->status_wait) ?></td>
                            <td><?= h($orders->status_approve) ?></td>
                            <td><?= h($orders->status_date) ?></td>
                            <td><?= h($orders->status_desc) ?></td>
                            <td><?= h($orders->waste_id) ?></td>
                            <td><?= h($orders->waste_price_id) ?></td>
                            <td><?= h($orders->waste_type_id) ?></td>
                            <td><?= h($orders->processor_id) ?></td>
                            <td><?= h($orders->unit) ?></td>
                            <td><?= h($orders->quantity) ?></td>
                            <td><?= h($orders->order) ?></td>
                            <td><?= h($orders->date_order) ?></td>
                            <td><?= h($orders->manifest_id) ?></td>
                            <td><?= h($orders->date_manifest) ?></td>
                            <td><?= h($orders->date_estimate_schedule) ?></td>
                            <td><?= h($orders->permit_id) ?></td>
                            <td><?= h($orders->date_permit) ?></td>
                            <td><?= h($orders->truck_schedule_id) ?></td>
                            <td><?= h($orders->truck_schedule_date) ?></td>
                            <td><?= h($orders->created) ?></td>
                            <td><?= h($orders->modified) ?></td>
                            <td><?= h($orders->status) ?></td>
                            <td><?= h($orders->is_create) ?></td>
                            <td><?= h($orders->is_update) ?></td>
                            <td><?= h($orders->is_delete) ?></td>
                            <td><?= h($orders->deleted) ?></td>
                            <td><?= h($orders->is_active) ?></td>
                            <td><?= h($orders->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Orders', 'action' => 'view', $orders->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Orders', 'action' => 'edit', $orders->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Orders', 'action' => 'delete', $orders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orders->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Orders Ori') ?></h4>
                <?php if (!empty($customer->orders_ori)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Status Wait') ?></th>
                            <th><?= __('Status Approve') ?></th>
                            <th><?= __('Status Date') ?></th>
                            <th><?= __('Status Desc') ?></th>
                            <th><?= __('Waste Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Order') ?></th>
                            <th><?= __('Date Order') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Date Manifest') ?></th>
                            <th><?= __('Date Estimate Schedule') ?></th>
                            <th><?= __('Permit Id') ?></th>
                            <th><?= __('Date Permit') ?></th>
                            <th><?= __('Sjp Id') ?></th>
                            <th><?= __('Date Sjp') ?></th>
                            <th><?= __('Truck Schedule Id') ?></th>
                            <th><?= __('Truck Schedule Date') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->orders_ori as $ordersOri) : ?>
                        <tr>
                            <td><?= h($ordersOri->id) ?></td>
                            <td><?= h($ordersOri->branch_id) ?></td>
                            <td><?= h($ordersOri->customer_id) ?></td>
                            <td><?= h($ordersOri->number) ?></td>
                            <td><?= h($ordersOri->status_wait) ?></td>
                            <td><?= h($ordersOri->status_approve) ?></td>
                            <td><?= h($ordersOri->status_date) ?></td>
                            <td><?= h($ordersOri->status_desc) ?></td>
                            <td><?= h($ordersOri->waste_id) ?></td>
                            <td><?= h($ordersOri->waste_type_id) ?></td>
                            <td><?= h($ordersOri->processor_id) ?></td>
                            <td><?= h($ordersOri->unit) ?></td>
                            <td><?= h($ordersOri->quantity) ?></td>
                            <td><?= h($ordersOri->order) ?></td>
                            <td><?= h($ordersOri->date_order) ?></td>
                            <td><?= h($ordersOri->manifest_id) ?></td>
                            <td><?= h($ordersOri->date_manifest) ?></td>
                            <td><?= h($ordersOri->date_estimate_schedule) ?></td>
                            <td><?= h($ordersOri->permit_id) ?></td>
                            <td><?= h($ordersOri->date_permit) ?></td>
                            <td><?= h($ordersOri->sjp_id) ?></td>
                            <td><?= h($ordersOri->date_sjp) ?></td>
                            <td><?= h($ordersOri->truck_schedule_id) ?></td>
                            <td><?= h($ordersOri->truck_schedule_date) ?></td>
                            <td><?= h($ordersOri->who_create) ?></td>
                            <td><?= h($ordersOri->created) ?></td>
                            <td><?= h($ordersOri->who_update) ?></td>
                            <td><?= h($ordersOri->modified) ?></td>
                            <td><?= h($ordersOri->active) ?></td>
                            <td><?= h($ordersOri->status) ?></td>
                            <td><?= h($ordersOri->is_create) ?></td>
                            <td><?= h($ordersOri->is_update) ?></td>
                            <td><?= h($ordersOri->is_delete) ?></td>
                            <td><?= h($ordersOri->deleted) ?></td>
                            <td><?= h($ordersOri->is_active) ?></td>
                            <td><?= h($ordersOri->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrdersOri', 'action' => 'view', $ordersOri->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrdersOri', 'action' => 'edit', $ordersOri->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrdersOri', 'action' => 'delete', $ordersOri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ordersOri->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Permits') ?></h4>
                <?php if (!empty($customer->permits)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Truck Schedule Id') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Operational Id Ori') ?></th>
                            <th><?= __('Operational Id') ?></th>
                            <th><?= __('Operational Date') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Date Loading') ?></th>
                            <th><?= __('Print Date') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Print') ?></th>
                            <th><?= __('No Pol') ?></th>
                            <th><?= __('Driver Name') ?></th>
                            <th><?= __('Driver Phone') ?></th>
                            <th><?= __('Coordinator Area') ?></th>
                            <th><?= __('Direct') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->permits as $permits) : ?>
                        <tr>
                            <td><?= h($permits->id) ?></td>
                            <td><?= h($permits->branch_id) ?></td>
                            <td><?= h($permits->number) ?></td>
                            <td><?= h($permits->invoice_id) ?></td>
                            <td><?= h($permits->truck_schedule_id) ?></td>
                            <td><?= h($permits->manifest_id) ?></td>
                            <td><?= h($permits->operational_id_ori) ?></td>
                            <td><?= h($permits->operational_id) ?></td>
                            <td><?= h($permits->operational_date) ?></td>
                            <td><?= h($permits->customer_id) ?></td>
                            <td><?= h($permits->date) ?></td>
                            <td><?= h($permits->date_loading) ?></td>
                            <td><?= h($permits->print_date) ?></td>
                            <td><?= h($permits->is_print) ?></td>
                            <td><?= h($permits->print) ?></td>
                            <td><?= h($permits->no_pol) ?></td>
                            <td><?= h($permits->driver_name) ?></td>
                            <td><?= h($permits->driver_phone) ?></td>
                            <td><?= h($permits->coordinator_area) ?></td>
                            <td><?= h($permits->direct) ?></td>
                            <td><?= h($permits->description) ?></td>
                            <td><?= h($permits->is_create) ?></td>
                            <td><?= h($permits->created) ?></td>
                            <td><?= h($permits->is_update) ?></td>
                            <td><?= h($permits->modified) ?></td>
                            <td><?= h($permits->active) ?></td>
                            <td><?= h($permits->status) ?></td>
                            <td><?= h($permits->is_log) ?></td>
                            <td><?= h($permits->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Permits', 'action' => 'view', $permits->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Permits', 'action' => 'edit', $permits->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Permits', 'action' => 'delete', $permits->id], ['confirm' => __('Are you sure you want to delete # {0}?', $permits->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Truck Schedules') ?></h4>
                <?php if (!empty($customer->truck_schedules)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Project Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Manifest Id Old') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Waste Price Id') ?></th>
                            <th><?= __('Order Id') ?></th>
                            <th><?= __('Date Shipping') ?></th>
                            <th><?= __('Date Up') ?></th>
                            <th><?= __('Driver Id') ?></th>
                            <th><?= __('Driver Id Old') ?></th>
                            <th><?= __('Helper Id') ?></th>
                            <th><?= __('Truck Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Quantity Packing') ?></th>
                            <th><?= __('Packing') ?></th>
                            <th><?= __('Realisasi Status') ?></th>
                            <th><?= __('Realisasi Date') ?></th>
                            <th><?= __('Realisasi Desc') ?></th>
                            <th><?= __('Realisasi Who Is') ?></th>
                            <th><?= __('Realisasi Who Is Date') ?></th>
                            <th><?= __('Moda Truck Id') ?></th>
                            <th><?= __('Moda Driver Id') ?></th>
                            <th><?= __('Moda Helper Id') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->truck_schedules as $truckSchedules) : ?>
                        <tr>
                            <td><?= h($truckSchedules->id) ?></td>
                            <td><?= h($truckSchedules->project_id) ?></td>
                            <td><?= h($truckSchedules->branch_id) ?></td>
                            <td><?= h($truckSchedules->customer_id) ?></td>
                            <td><?= h($truckSchedules->manifest_id_old) ?></td>
                            <td><?= h($truckSchedules->manifest_id) ?></td>
                            <td><?= h($truckSchedules->mou_id) ?></td>
                            <td><?= h($truckSchedules->waste_price_id) ?></td>
                            <td><?= h($truckSchedules->order_id) ?></td>
                            <td><?= h($truckSchedules->date_shipping) ?></td>
                            <td><?= h($truckSchedules->date_up) ?></td>
                            <td><?= h($truckSchedules->driver_id) ?></td>
                            <td><?= h($truckSchedules->driver_id_old) ?></td>
                            <td><?= h($truckSchedules->helper_id) ?></td>
                            <td><?= h($truckSchedules->truck_id) ?></td>
                            <td><?= h($truckSchedules->quantity) ?></td>
                            <td><?= h($truckSchedules->unit) ?></td>
                            <td><?= h($truckSchedules->quantity_packing) ?></td>
                            <td><?= h($truckSchedules->packing) ?></td>
                            <td><?= h($truckSchedules->realisasi_status) ?></td>
                            <td><?= h($truckSchedules->realisasi_date) ?></td>
                            <td><?= h($truckSchedules->realisasi_desc) ?></td>
                            <td><?= h($truckSchedules->realisasi_who_is) ?></td>
                            <td><?= h($truckSchedules->realisasi_who_is_date) ?></td>
                            <td><?= h($truckSchedules->moda_truck_id) ?></td>
                            <td><?= h($truckSchedules->moda_driver_id) ?></td>
                            <td><?= h($truckSchedules->moda_helper_id) ?></td>
                            <td><?= h($truckSchedules->who_create) ?></td>
                            <td><?= h($truckSchedules->created) ?></td>
                            <td><?= h($truckSchedules->who_update) ?></td>
                            <td><?= h($truckSchedules->modified) ?></td>
                            <td><?= h($truckSchedules->is_create) ?></td>
                            <td><?= h($truckSchedules->is_update) ?></td>
                            <td><?= h($truckSchedules->is_delete) ?></td>
                            <td><?= h($truckSchedules->deleted) ?></td>
                            <td><?= h($truckSchedules->is_active) ?></td>
                            <td><?= h($truckSchedules->active) ?></td>
                            <td><?= h($truckSchedules->status) ?></td>
                            <td><?= h($truckSchedules->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TruckSchedules', 'action' => 'view', $truckSchedules->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TruckSchedules', 'action' => 'edit', $truckSchedules->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TruckSchedules', 'action' => 'delete', $truckSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $truckSchedules->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Unidentified Incomes') ?></h4>
                <?php if (!empty($customer->unidentified_incomes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Acc Journal Unidentified Id') ?></th>
                            <th><?= __('Acc Journal Identified Id') ?></th>
                            <th><?= __('Coa Bank Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('From') ?></th>
                            <th><?= __('For') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Cost') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Date Identified') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Referense Po') ?></th>
                            <th><?= __('Revisi Id') ?></th>
                            <th><?= __('Revisi Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Posting Date') ?></th>
                            <th><?= __('Is Print') ?></th>
                            <th><?= __('Print') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->unidentified_incomes as $unidentifiedIncomes) : ?>
                        <tr>
                            <td><?= h($unidentifiedIncomes->id) ?></td>
                            <td><?= h($unidentifiedIncomes->branch_id) ?></td>
                            <td><?= h($unidentifiedIncomes->acc_journal_id) ?></td>
                            <td><?= h($unidentifiedIncomes->acc_journal_unidentified_id) ?></td>
                            <td><?= h($unidentifiedIncomes->acc_journal_identified_id) ?></td>
                            <td><?= h($unidentifiedIncomes->coa_bank_id) ?></td>
                            <td><?= h($unidentifiedIncomes->invoice_id) ?></td>
                            <td><?= h($unidentifiedIncomes->number) ?></td>
                            <td><?= h($unidentifiedIncomes->tax) ?></td>
                            <td><?= h($unidentifiedIncomes->from) ?></td>
                            <td><?= h($unidentifiedIncomes->for) ?></td>
                            <td><?= h($unidentifiedIncomes->status) ?></td>
                            <td><?= h($unidentifiedIncomes->customer_id) ?></td>
                            <td><?= h($unidentifiedIncomes->mou_id) ?></td>
                            <td><?= h($unidentifiedIncomes->cost) ?></td>
                            <td><?= h($unidentifiedIncomes->date) ?></td>
                            <td><?= h($unidentifiedIncomes->date_identified) ?></td>
                            <td><?= h($unidentifiedIncomes->due_date) ?></td>
                            <td><?= h($unidentifiedIncomes->referense_po) ?></td>
                            <td><?= h($unidentifiedIncomes->revisi_id) ?></td>
                            <td><?= h($unidentifiedIncomes->revisi_date) ?></td>
                            <td><?= h($unidentifiedIncomes->description) ?></td>
                            <td><?= h($unidentifiedIncomes->posting) ?></td>
                            <td><?= h($unidentifiedIncomes->posting_date) ?></td>
                            <td><?= h($unidentifiedIncomes->is_print) ?></td>
                            <td><?= h($unidentifiedIncomes->print) ?></td>
                            <td><?= h($unidentifiedIncomes->is_create) ?></td>
                            <td><?= h($unidentifiedIncomes->created) ?></td>
                            <td><?= h($unidentifiedIncomes->is_update) ?></td>
                            <td><?= h($unidentifiedIncomes->modified) ?></td>
                            <td><?= h($unidentifiedIncomes->is_log) ?></td>
                            <td><?= h($unidentifiedIncomes->is_delete) ?></td>
                            <td><?= h($unidentifiedIncomes->deleted) ?></td>
                            <td><?= h($unidentifiedIncomes->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'UnidentifiedIncomes', 'action' => 'view', $unidentifiedIncomes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'UnidentifiedIncomes', 'action' => 'edit', $unidentifiedIncomes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UnidentifiedIncomes', 'action' => 'delete', $unidentifiedIncomes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unidentifiedIncomes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Waste Prices') ?></h4>
                <?php if (!empty($customer->waste_prices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Packing') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Price Min') ?></th>
                            <th><?= __('Qty Min') ?></th>
                            <th><?= __('Price Netto') ?></th>
                            <th><?= __('Cost Of Sales') ?></th>
                            <th><?= __('Package Status') ?></th>
                            <th><?= __('Processor Price') ?></th>
                            <th><?= __('Processor Unit') ?></th>
                            <th><?= __('Collector Price') ?></th>
                            <th><?= __('Collector Unit') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->waste_prices as $wastePrices) : ?>
                        <tr>
                            <td><?= h($wastePrices->id) ?></td>
                            <td><?= h($wastePrices->branch_id) ?></td>
                            <td><?= h($wastePrices->waste_type_id) ?></td>
                            <td><?= h($wastePrices->customer_id) ?></td>
                            <td><?= h($wastePrices->mou_id) ?></td>
                            <td><?= h($wastePrices->is_approve) ?></td>
                            <td><?= h($wastePrices->date_approve) ?></td>
                            <td><?= h($wastePrices->date) ?></td>
                            <td><?= h($wastePrices->unit) ?></td>
                            <td><?= h($wastePrices->packing) ?></td>
                            <td><?= h($wastePrices->price) ?></td>
                            <td><?= h($wastePrices->price_min) ?></td>
                            <td><?= h($wastePrices->qty_min) ?></td>
                            <td><?= h($wastePrices->price_netto) ?></td>
                            <td><?= h($wastePrices->cost_of_sales) ?></td>
                            <td><?= h($wastePrices->package_status) ?></td>
                            <td><?= h($wastePrices->processor_price) ?></td>
                            <td><?= h($wastePrices->processor_unit) ?></td>
                            <td><?= h($wastePrices->collector_price) ?></td>
                            <td><?= h($wastePrices->collector_unit) ?></td>
                            <td><?= h($wastePrices->is_create) ?></td>
                            <td><?= h($wastePrices->created) ?></td>
                            <td><?= h($wastePrices->is_update) ?></td>
                            <td><?= h($wastePrices->modified) ?></td>
                            <td><?= h($wastePrices->is_delete) ?></td>
                            <td><?= h($wastePrices->deleted) ?></td>
                            <td><?= h($wastePrices->status) ?></td>
                            <td><?= h($wastePrices->is_active) ?></td>
                            <td><?= h($wastePrices->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'WastePrices', 'action' => 'view', $wastePrices->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'WastePrices', 'action' => 'edit', $wastePrices->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'WastePrices', 'action' => 'delete', $wastePrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastePrices->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Wastes') ?></h4>
                <?php if (!empty($customer->wastes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Processor Price') ?></th>
                            <th><?= __('Processor Unit') ?></th>
                            <th><?= __('Collector Id') ?></th>
                            <th><?= __('Collector Price') ?></th>
                            <th><?= __('Collector Unit') ?></th>
                            <th><?= __('Code Ori') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Code Std') ?></th>
                            <th><?= __('Codeu') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Class') ?></th>
                            <th><?= __('Hazardous Code') ?></th>
                            <th><?= __('Unna Code') ?></th>
                            <th><?= __('Packing Group') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Purchase Price') ?></th>
                            <th><?= __('Purchase Price Unit') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Paket Desc') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->wastes as $wastes) : ?>
                        <tr>
                            <td><?= h($wastes->id) ?></td>
                            <td><?= h($wastes->branch_id) ?></td>
                            <td><?= h($wastes->customer_id) ?></td>
                            <td><?= h($wastes->waste_type_id) ?></td>
                            <td><?= h($wastes->processor_id) ?></td>
                            <td><?= h($wastes->processor_price) ?></td>
                            <td><?= h($wastes->processor_unit) ?></td>
                            <td><?= h($wastes->collector_id) ?></td>
                            <td><?= h($wastes->collector_price) ?></td>
                            <td><?= h($wastes->collector_unit) ?></td>
                            <td><?= h($wastes->code_ori) ?></td>
                            <td><?= h($wastes->code) ?></td>
                            <td><?= h($wastes->code_std) ?></td>
                            <td><?= h($wastes->codeu) ?></td>
                            <td><?= h($wastes->name) ?></td>
                            <td><?= h($wastes->is_approve) ?></td>
                            <td><?= h($wastes->date_approve) ?></td>
                            <td><?= h($wastes->type) ?></td>
                            <td><?= h($wastes->class) ?></td>
                            <td><?= h($wastes->hazardous_code) ?></td>
                            <td><?= h($wastes->unna_code) ?></td>
                            <td><?= h($wastes->packing_group) ?></td>
                            <td><?= h($wastes->price) ?></td>
                            <td><?= h($wastes->purchase_price) ?></td>
                            <td><?= h($wastes->purchase_price_unit) ?></td>
                            <td><?= h($wastes->unit) ?></td>
                            <td><?= h($wastes->paket_desc) ?></td>
                            <td><?= h($wastes->is_active) ?></td>
                            <td><?= h($wastes->is_log) ?></td>
                            <td><?= h($wastes->is_create) ?></td>
                            <td><?= h($wastes->is_update) ?></td>
                            <td><?= h($wastes->who_create) ?></td>
                            <td><?= h($wastes->created) ?></td>
                            <td><?= h($wastes->who_update) ?></td>
                            <td><?= h($wastes->modified) ?></td>
                            <td><?= h($wastes->active) ?></td>
                            <td><?= h($wastes->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Wastes', 'action' => 'view', $wastes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Wastes', 'action' => 'edit', $wastes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Wastes', 'action' => 'delete', $wastes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
