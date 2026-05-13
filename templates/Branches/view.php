<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Branch $branch
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Branch'), ['action' => 'edit', $branch->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Branch'), ['action' => 'delete', $branch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $branch->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Branches'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Branch'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="branches view content">
            <h3><?= h($branch->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($branch->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($branch->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Name') ?></th>
                    <td><?= h($branch->company_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Address') ?></th>
                    <td><?= h($branch->company_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Business Fields') ?></th>
                    <td><?= h($branch->business_fields) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Telp') ?></th>
                    <td><?= h($branch->company_telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Fax') ?></th>
                    <td><?= h($branch->company_fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Npwp') ?></th>
                    <td><?= h($branch->company_npwp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Director') ?></th>
                    <td><?= h($branch->company_director) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Director 1') ?></th>
                    <td><?= h($branch->company_director_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign Title 1') ?></th>
                    <td><?= h($branch->sign_title_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Director 2') ?></th>
                    <td><?= h($branch->company_director_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign Title 2') ?></th>
                    <td><?= h($branch->sign_title_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Director 3') ?></th>
                    <td><?= h($branch->company_director_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign Title 3') ?></th>
                    <td><?= h($branch->sign_title_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company Director 4') ?></th>
                    <td><?= h($branch->company_director_4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign Title 4') ?></th>
                    <td><?= h($branch->sign_title_4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warehouse Address') ?></th>
                    <td><?= h($branch->warehouse_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warehouse Telp') ?></th>
                    <td><?= h($branch->warehouse_telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warehouse Fax') ?></th>
                    <td><?= h($branch->warehouse_fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manifest Number') ?></th>
                    <td><?= h($branch->manifest_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Code') ?></th>
                    <td><?= h($branch->invoice_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Number') ?></th>
                    <td><?= h($branch->invoice_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Number Include') ?></th>
                    <td><?= h($branch->invoice_number_include) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Evidence Email') ?></th>
                    <td><?= h($branch->invoice_evidence_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Faktur Pajak Number') ?></th>
                    <td><?= h($branch->faktur_pajak_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Berita Acara Number') ?></th>
                    <td><?= h($branch->berita_acara_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Permit Number') ?></th>
                    <td><?= h($branch->permit_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offer Number') ?></th>
                    <td><?= h($branch->offer_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offer Year') ?></th>
                    <td><?= h($branch->offer_year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank') ?></th>
                    <td><?= h($branch->bank) ?></td>
                </tr>
                <tr>
                    <th><?= __('Norek') ?></th>
                    <td><?= h($branch->norek) ?></td>
                </tr>
                <tr>
                    <th><?= __('An') ?></th>
                    <td><?= h($branch->an) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name 1') ?></th>
                    <td><?= h($branch->bank_name_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek 1') ?></th>
                    <td><?= h($branch->bank_norek_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An 1') ?></th>
                    <td><?= h($branch->bank_an_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name 2') ?></th>
                    <td><?= h($branch->bank_name_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek 2') ?></th>
                    <td><?= h($branch->bank_norek_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An 2') ?></th>
                    <td><?= h($branch->bank_an_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name 3') ?></th>
                    <td><?= h($branch->bank_name_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek 3') ?></th>
                    <td><?= h($branch->bank_norek_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An 3') ?></th>
                    <td><?= h($branch->bank_an_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name 4') ?></th>
                    <td><?= h($branch->bank_name_4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek 4') ?></th>
                    <td><?= h($branch->bank_norek_4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An 4') ?></th>
                    <td><?= h($branch->bank_an_4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name 5') ?></th>
                    <td><?= h($branch->bank_name_5) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Norek 5') ?></th>
                    <td><?= h($branch->bank_norek_5) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank An 5') ?></th>
                    <td><?= h($branch->bank_an_5) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va Bank An') ?></th>
                    <td><?= h($branch->va_bank_an) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va Bank Name') ?></th>
                    <td><?= h($branch->va_bank_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va Bank Branch') ?></th>
                    <td><?= h($branch->va_bank_branch) ?></td>
                </tr>
                <tr>
                    <th><?= __('Va Bank Norek') ?></th>
                    <td><?= h($branch->va_bank_norek) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wa Invoice') ?></th>
                    <td><?= h($branch->wa_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('City Invoice') ?></th>
                    <td><?= h($branch->city_invoice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($branch->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Emergency Call') ?></th>
                    <td><?= h($branch->emergency_call) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offer Perihal') ?></th>
                    <td><?= h($branch->offer_perihal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offer Info') ?></th>
                    <td><?= h($branch->offer_info) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manifest Type') ?></th>
                    <td><?= h($branch->manifest_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manifest Code') ?></th>
                    <td><?= h($branch->manifest_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Offer Code') ?></th>
                    <td><?= h($branch->offer_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign 1') ?></th>
                    <td><?= h($branch->sign_1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign 2') ?></th>
                    <td><?= h($branch->sign_2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign 3') ?></th>
                    <td><?= h($branch->sign_3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sign 4') ?></th>
                    <td><?= h($branch->sign_4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mou Code') ?></th>
                    <td><?= h($branch->mou_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Header') ?></th>
                    <td><?= h($branch->header) ?></td>
                </tr>
                <tr>
                    <th><?= __('Footer') ?></th>
                    <td><?= h($branch->footer) ?></td>
                </tr>
                <tr>
                    <th><?= __('Desc') ?></th>
                    <td><?= h($branch->desc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($branch->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($branch->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($branch->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($branch->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($branch->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($branch->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transporter Id') ?></th>
                    <td><?= $this->Number->format($branch->transporter_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($branch->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($branch->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($branch->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Offer Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($branch->offer_description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($branch->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Transporters') ?></h4>
                <?php if (!empty($branch->transporters)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Data Invoice Id') ?></th>
                            <th><?= __('Data Tax Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Treatment') ?></th>
                            <th><?= __('Address Penghasil') ?></th>
                            <th><?= __('Supplier') ?></th>
                            <th><?= __('Address Supplier') ?></th>
                            <th><?= __('Phone Supplier') ?></th>
                            <th><?= __('Fax Supplier') ?></th>
                            <th><?= __('Name Invoice') ?></th>
                            <th><?= __('Address Invoice') ?></th>
                            <th><?= __('Phone Invoice') ?></th>
                            <th><?= __('Fax Invoice') ?></th>
                            <th><?= __('Name Tax Invoice') ?></th>
                            <th><?= __('Address Tax Invoice') ?></th>
                            <th><?= __('Phone Tax Invoice') ?></th>
                            <th><?= __('Fax Tax Invoice') ?></th>
                            <th><?= __('Npwp') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('System') ?></th>
                            <th><?= __('Website') ?></th>
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
                        <?php foreach ($branch->transporters as $transporters) : ?>
                        <tr>
                            <td><?= h($transporters->id) ?></td>
                            <td><?= h($transporters->branch_id) ?></td>
                            <td><?= h($transporters->code) ?></td>
                            <td><?= h($transporters->user_id) ?></td>
                            <td><?= h($transporters->data_invoice_id) ?></td>
                            <td><?= h($transporters->data_tax_id) ?></td>
                            <td><?= h($transporters->name) ?></td>
                            <td><?= h($transporters->treatment) ?></td>
                            <td><?= h($transporters->address_penghasil) ?></td>
                            <td><?= h($transporters->supplier) ?></td>
                            <td><?= h($transporters->address_supplier) ?></td>
                            <td><?= h($transporters->phone_supplier) ?></td>
                            <td><?= h($transporters->fax_supplier) ?></td>
                            <td><?= h($transporters->name_invoice) ?></td>
                            <td><?= h($transporters->address_invoice) ?></td>
                            <td><?= h($transporters->phone_invoice) ?></td>
                            <td><?= h($transporters->fax_invoice) ?></td>
                            <td><?= h($transporters->name_tax_invoice) ?></td>
                            <td><?= h($transporters->address_tax_invoice) ?></td>
                            <td><?= h($transporters->phone_tax_invoice) ?></td>
                            <td><?= h($transporters->fax_tax_invoice) ?></td>
                            <td><?= h($transporters->npwp) ?></td>
                            <td><?= h($transporters->tax) ?></td>
                            <td><?= h($transporters->city) ?></td>
                            <td><?= h($transporters->province) ?></td>
                            <td><?= h($transporters->postal) ?></td>
                            <td><?= h($transporters->country) ?></td>
                            <td><?= h($transporters->phone) ?></td>
                            <td><?= h($transporters->email) ?></td>
                            <td><?= h($transporters->system) ?></td>
                            <td><?= h($transporters->website) ?></td>
                            <td><?= h($transporters->is_create) ?></td>
                            <td><?= h($transporters->created) ?></td>
                            <td><?= h($transporters->is_update) ?></td>
                            <td><?= h($transporters->modified) ?></td>
                            <td><?= h($transporters->is_delete) ?></td>
                            <td><?= h($transporters->deleted) ?></td>
                            <td><?= h($transporters->is_active) ?></td>
                            <td><?= h($transporters->is_log) ?></td>
                            <td><?= h($transporters->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transporters', 'action' => 'view', $transporters->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transporters', 'action' => 'edit', $transporters->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transporters', 'action' => 'delete', $transporters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transporters->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Account Mappings') ?></h4>
                <?php if (!empty($branch->acc_account_mappings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_account_mappings as $accAccountMappings) : ?>
                        <tr>
                            <td><?= h($accAccountMappings->id) ?></td>
                            <td><?= h($accAccountMappings->branch_id) ?></td>
                            <td><?= h($accAccountMappings->acc_chart_of_account_id) ?></td>
                            <td><?= h($accAccountMappings->group) ?></td>
                            <td><?= h($accAccountMappings->name) ?></td>
                            <td><?= h($accAccountMappings->desc) ?></td>
                            <td><?= h($accAccountMappings->is_create) ?></td>
                            <td><?= h($accAccountMappings->created) ?></td>
                            <td><?= h($accAccountMappings->is_update) ?></td>
                            <td><?= h($accAccountMappings->modified) ?></td>
                            <td><?= h($accAccountMappings->is_delete) ?></td>
                            <td><?= h($accAccountMappings->deleted) ?></td>
                            <td><?= h($accAccountMappings->status) ?></td>
                            <td><?= h($accAccountMappings->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccAccountMappings', 'action' => 'view', $accAccountMappings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccAccountMappings', 'action' => 'edit', $accAccountMappings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccAccountMappings', 'action' => 'delete', $accAccountMappings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accAccountMappings->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Accounts') ?></h4>
                <?php if (!empty($branch->acc_accounts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Parent Code') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Transaction') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Character') ?></th>
                            <th><?= __('Code Additional') ?></th>
                            <th><?= __('Additional') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Who Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_accounts as $accAccounts) : ?>
                        <tr>
                            <td><?= h($accAccounts->id) ?></td>
                            <td><?= h($accAccounts->branch_id) ?></td>
                            <td><?= h($accAccounts->parent_id) ?></td>
                            <td><?= h($accAccounts->lft) ?></td>
                            <td><?= h($accAccounts->rght) ?></td>
                            <td><?= h($accAccounts->level) ?></td>
                            <td><?= h($accAccounts->code) ?></td>
                            <td><?= h($accAccounts->parent_code) ?></td>
                            <td><?= h($accAccounts->name) ?></td>
                            <td><?= h($accAccounts->type) ?></td>
                            <td><?= h($accAccounts->group) ?></td>
                            <td><?= h($accAccounts->journal_type) ?></td>
                            <td><?= h($accAccounts->transaction) ?></td>
                            <td><?= h($accAccounts->description) ?></td>
                            <td><?= h($accAccounts->character) ?></td>
                            <td><?= h($accAccounts->code_additional) ?></td>
                            <td><?= h($accAccounts->additional) ?></td>
                            <td><?= h($accAccounts->is_create) ?></td>
                            <td><?= h($accAccounts->is_update) ?></td>
                            <td><?= h($accAccounts->is_delete) ?></td>
                            <td><?= h($accAccounts->is_active) ?></td>
                            <td><?= h($accAccounts->who_create) ?></td>
                            <td><?= h($accAccounts->created) ?></td>
                            <td><?= h($accAccounts->who_update) ?></td>
                            <td><?= h($accAccounts->modified) ?></td>
                            <td><?= h($accAccounts->who_delete) ?></td>
                            <td><?= h($accAccounts->deleted) ?></td>
                            <td><?= h($accAccounts->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccAccounts', 'action' => 'view', $accAccounts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccAccounts', 'action' => 'edit', $accAccounts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccAccounts', 'action' => 'delete', $accAccounts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accAccounts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Beginning Balances') ?></h4>
                <?php if (!empty($branch->acc_beginning_balances)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Dates') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_beginning_balances as $accBeginningBalances) : ?>
                        <tr>
                            <td><?= h($accBeginningBalances->id) ?></td>
                            <td><?= h($accBeginningBalances->branch_id) ?></td>
                            <td><?= h($accBeginningBalances->acc_chart_of_account_id) ?></td>
                            <td><?= h($accBeginningBalances->dates) ?></td>
                            <td><?= h($accBeginningBalances->status) ?></td>
                            <td><?= h($accBeginningBalances->position) ?></td>
                            <td><?= h($accBeginningBalances->ledger_dc) ?></td>
                            <td><?= h($accBeginningBalances->debet) ?></td>
                            <td><?= h($accBeginningBalances->credit) ?></td>
                            <td><?= h($accBeginningBalances->is_active) ?></td>
                            <td><?= h($accBeginningBalances->is_create) ?></td>
                            <td><?= h($accBeginningBalances->created) ?></td>
                            <td><?= h($accBeginningBalances->is_update) ?></td>
                            <td><?= h($accBeginningBalances->modified) ?></td>
                            <td><?= h($accBeginningBalances->is_delete) ?></td>
                            <td><?= h($accBeginningBalances->deleted) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccBeginningBalances', 'action' => 'view', $accBeginningBalances->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccBeginningBalances', 'action' => 'edit', $accBeginningBalances->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccBeginningBalances', 'action' => 'delete', $accBeginningBalances->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accBeginningBalances->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Chart Of Accounts') ?></h4>
                <?php if (!empty($branch->acc_chart_of_accounts)) : ?>
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
                        <?php foreach ($branch->acc_chart_of_accounts as $accChartOfAccounts) : ?>
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
                <h4><?= __('Related Acc Journal Bank Lines') ?></h4>
                <?php if (!empty($branch->acc_journal_bank_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Bank Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_journal_bank_lines as $accJournalBankLines) : ?>
                        <tr>
                            <td><?= h($accJournalBankLines->id) ?></td>
                            <td><?= h($accJournalBankLines->branch_id) ?></td>
                            <td><?= h($accJournalBankLines->acc_journal_bank_id) ?></td>
                            <td><?= h($accJournalBankLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalBankLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalBankLines->ledger_dc) ?></td>
                            <td><?= h($accJournalBankLines->name) ?></td>
                            <td><?= h($accJournalBankLines->debet) ?></td>
                            <td><?= h($accJournalBankLines->credit) ?></td>
                            <td><?= h($accJournalBankLines->is_create) ?></td>
                            <td><?= h($accJournalBankLines->created) ?></td>
                            <td><?= h($accJournalBankLines->is_update) ?></td>
                            <td><?= h($accJournalBankLines->modified) ?></td>
                            <td><?= h($accJournalBankLines->is_delete) ?></td>
                            <td><?= h($accJournalBankLines->deleted) ?></td>
                            <td><?= h($accJournalBankLines->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalBankLines', 'action' => 'view', $accJournalBankLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalBankLines', 'action' => 'edit', $accJournalBankLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalBankLines', 'action' => 'delete', $accJournalBankLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalBankLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Banks') ?></h4>
                <?php if (!empty($branch->acc_journal_banks)) : ?>
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
                        <?php foreach ($branch->acc_journal_banks as $accJournalBanks) : ?>
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
                <h4><?= __('Related Acc Journal Cash Lines') ?></h4>
                <?php if (!empty($branch->acc_journal_cash_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Cash Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id Oris') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_journal_cash_lines as $accJournalCashLines) : ?>
                        <tr>
                            <td><?= h($accJournalCashLines->id) ?></td>
                            <td><?= h($accJournalCashLines->branch_id) ?></td>
                            <td><?= h($accJournalCashLines->acc_journal_cash_id) ?></td>
                            <td><?= h($accJournalCashLines->acc_chart_of_account_id_oris) ?></td>
                            <td><?= h($accJournalCashLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalCashLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalCashLines->ledger_dc) ?></td>
                            <td><?= h($accJournalCashLines->name) ?></td>
                            <td><?= h($accJournalCashLines->debet) ?></td>
                            <td><?= h($accJournalCashLines->credit) ?></td>
                            <td><?= h($accJournalCashLines->is_create) ?></td>
                            <td><?= h($accJournalCashLines->created) ?></td>
                            <td><?= h($accJournalCashLines->is_update) ?></td>
                            <td><?= h($accJournalCashLines->modified) ?></td>
                            <td><?= h($accJournalCashLines->is_delete) ?></td>
                            <td><?= h($accJournalCashLines->deleted) ?></td>
                            <td><?= h($accJournalCashLines->status) ?></td>
                            <td><?= h($accJournalCashLines->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalCashLines', 'action' => 'view', $accJournalCashLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalCashLines', 'action' => 'edit', $accJournalCashLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalCashLines', 'action' => 'delete', $accJournalCashLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalCashLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Cashes') ?></h4>
                <?php if (!empty($branch->acc_journal_cashes)) : ?>
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
                        <?php foreach ($branch->acc_journal_cashes as $accJournalCashes) : ?>
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
                <h4><?= __('Related Acc Journal Lines') ?></h4>
                <?php if (!empty($branch->acc_journal_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('From') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Journal Sub Id') ?></th>
                            <th><?= __('Journal Sub Line Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Invoice Hutang Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_journal_lines as $accJournalLines) : ?>
                        <tr>
                            <td><?= h($accJournalLines->id) ?></td>
                            <td><?= h($accJournalLines->branch_id) ?></td>
                            <td><?= h($accJournalLines->from) ?></td>
                            <td><?= h($accJournalLines->acc_journal_id) ?></td>
                            <td><?= h($accJournalLines->journal_sub_id) ?></td>
                            <td><?= h($accJournalLines->journal_sub_line_id) ?></td>
                            <td><?= h($accJournalLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalLines->manifest_id) ?></td>
                            <td><?= h($accJournalLines->invoice_hutang_id) ?></td>
                            <td><?= h($accJournalLines->invoice_id) ?></td>
                            <td><?= h($accJournalLines->position) ?></td>
                            <td><?= h($accJournalLines->ledger_dc) ?></td>
                            <td><?= h($accJournalLines->name) ?></td>
                            <td><?= h($accJournalLines->debet) ?></td>
                            <td><?= h($accJournalLines->credit) ?></td>
                            <td><?= h($accJournalLines->is_create) ?></td>
                            <td><?= h($accJournalLines->created) ?></td>
                            <td><?= h($accJournalLines->is_update) ?></td>
                            <td><?= h($accJournalLines->modified) ?></td>
                            <td><?= h($accJournalLines->is_delete) ?></td>
                            <td><?= h($accJournalLines->deleted) ?></td>
                            <td><?= h($accJournalLines->status) ?></td>
                            <td><?= h($accJournalLines->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalLines', 'action' => 'view', $accJournalLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalLines', 'action' => 'edit', $accJournalLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalLines', 'action' => 'delete', $accJournalLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Mappings') ?></h4>
                <?php if (!empty($branch->acc_journal_mappings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Sub Group') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Commentary') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_journal_mappings as $accJournalMappings) : ?>
                        <tr>
                            <td><?= h($accJournalMappings->id) ?></td>
                            <td><?= h($accJournalMappings->branch_id) ?></td>
                            <td><?= h($accJournalMappings->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalMappings->group) ?></td>
                            <td><?= h($accJournalMappings->sub_group) ?></td>
                            <td><?= h($accJournalMappings->type) ?></td>
                            <td><?= h($accJournalMappings->ledger_dc) ?></td>
                            <td><?= h($accJournalMappings->name) ?></td>
                            <td><?= h($accJournalMappings->commentary) ?></td>
                            <td><?= h($accJournalMappings->desc) ?></td>
                            <td><?= h($accJournalMappings->is_create) ?></td>
                            <td><?= h($accJournalMappings->created) ?></td>
                            <td><?= h($accJournalMappings->is_update) ?></td>
                            <td><?= h($accJournalMappings->modified) ?></td>
                            <td><?= h($accJournalMappings->is_delete) ?></td>
                            <td><?= h($accJournalMappings->deleted) ?></td>
                            <td><?= h($accJournalMappings->status) ?></td>
                            <td><?= h($accJournalMappings->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalMappings', 'action' => 'view', $accJournalMappings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalMappings', 'action' => 'edit', $accJournalMappings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalMappings', 'action' => 'delete', $accJournalMappings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMappings->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Memorial Lines') ?></h4>
                <?php if (!empty($branch->acc_journal_memorial_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Memorial Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->acc_journal_memorial_lines as $accJournalMemorialLines) : ?>
                        <tr>
                            <td><?= h($accJournalMemorialLines->id) ?></td>
                            <td><?= h($accJournalMemorialLines->branch_id) ?></td>
                            <td><?= h($accJournalMemorialLines->acc_journal_memorial_id) ?></td>
                            <td><?= h($accJournalMemorialLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalMemorialLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalMemorialLines->ledger_dc) ?></td>
                            <td><?= h($accJournalMemorialLines->name) ?></td>
                            <td><?= h($accJournalMemorialLines->debet) ?></td>
                            <td><?= h($accJournalMemorialLines->credit) ?></td>
                            <td><?= h($accJournalMemorialLines->is_create) ?></td>
                            <td><?= h($accJournalMemorialLines->created) ?></td>
                            <td><?= h($accJournalMemorialLines->is_update) ?></td>
                            <td><?= h($accJournalMemorialLines->modified) ?></td>
                            <td><?= h($accJournalMemorialLines->is_delete) ?></td>
                            <td><?= h($accJournalMemorialLines->deleted) ?></td>
                            <td><?= h($accJournalMemorialLines->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalMemorialLines', 'action' => 'view', $accJournalMemorialLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalMemorialLines', 'action' => 'edit', $accJournalMemorialLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalMemorialLines', 'action' => 'delete', $accJournalMemorialLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMemorialLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Memorials') ?></h4>
                <?php if (!empty($branch->acc_journal_memorials)) : ?>
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
                        <?php foreach ($branch->acc_journal_memorials as $accJournalMemorials) : ?>
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
                <?php if (!empty($branch->acc_journals)) : ?>
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
                        <?php foreach ($branch->acc_journals as $accJournals) : ?>
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
                <h4><?= __('Related Calks') ?></h4>
                <?php if (!empty($branch->calks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->calks as $calks) : ?>
                        <tr>
                            <td><?= h($calks->id) ?></td>
                            <td><?= h($calks->branch_id) ?></td>
                            <td><?= h($calks->date) ?></td>
                            <td><?= h($calks->acc_chart_of_account_id) ?></td>
                            <td><?= h($calks->desc) ?></td>
                            <td><?= h($calks->is_create) ?></td>
                            <td><?= h($calks->created) ?></td>
                            <td><?= h($calks->is_update) ?></td>
                            <td><?= h($calks->modified) ?></td>
                            <td><?= h($calks->is_delete) ?></td>
                            <td><?= h($calks->deleted) ?></td>
                            <td><?= h($calks->status) ?></td>
                            <td><?= h($calks->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Calks', 'action' => 'view', $calks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Calks', 'action' => 'edit', $calks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Calks', 'action' => 'delete', $calks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Certificates') ?></h4>
                <?php if (!empty($branch->certificates)) : ?>
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
                        <?php foreach ($branch->certificates as $certificates) : ?>
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
                <?php if (!empty($branch->commission_details)) : ?>
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
                        <?php foreach ($branch->commission_details as $commissionDetails) : ?>
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
                <h4><?= __('Related Commissions') ?></h4>
                <?php if (!empty($branch->commissions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Phone1') ?></th>
                            <th><?= __('Phone2') ?></th>
                            <th><?= __('Phone3') ?></th>
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
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->commissions as $commissions) : ?>
                        <tr>
                            <td><?= h($commissions->id) ?></td>
                            <td><?= h($commissions->branch_id) ?></td>
                            <td><?= h($commissions->code) ?></td>
                            <td><?= h($commissions->name) ?></td>
                            <td><?= h($commissions->phone1) ?></td>
                            <td><?= h($commissions->phone2) ?></td>
                            <td><?= h($commissions->phone3) ?></td>
                            <td><?= h($commissions->is_create) ?></td>
                            <td><?= h($commissions->created) ?></td>
                            <td><?= h($commissions->is_update) ?></td>
                            <td><?= h($commissions->modified) ?></td>
                            <td><?= h($commissions->is_delete) ?></td>
                            <td><?= h($commissions->deleted) ?></td>
                            <td><?= h($commissions->is_active) ?></td>
                            <td><?= h($commissions->is_log) ?></td>
                            <td><?= h($commissions->active) ?></td>
                            <td><?= h($commissions->status) ?></td>
                            <td><?= h($commissions->who_create) ?></td>
                            <td><?= h($commissions->who_update) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Commissions', 'action' => 'view', $commissions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Commissions', 'action' => 'edit', $commissions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Commissions', 'action' => 'delete', $commissions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $commissions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Creditors') ?></h4>
                <?php if (!empty($branch->creditors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Treatment') ?></th>
                            <th><?= __('Address Penghasil') ?></th>
                            <th><?= __('Supplier') ?></th>
                            <th><?= __('Address Supplier') ?></th>
                            <th><?= __('Phone Supplier') ?></th>
                            <th><?= __('Fax Supplier') ?></th>
                            <th><?= __('Name Invoice') ?></th>
                            <th><?= __('Address Invoice') ?></th>
                            <th><?= __('Phone Invoice') ?></th>
                            <th><?= __('Fax Invoice') ?></th>
                            <th><?= __('Name Tax Invoice') ?></th>
                            <th><?= __('Address Tax Invoice') ?></th>
                            <th><?= __('Phone Tax Invoice') ?></th>
                            <th><?= __('Fax Tax Invoice') ?></th>
                            <th><?= __('Npwp') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('System') ?></th>
                            <th><?= __('Website') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->creditors as $creditors) : ?>
                        <tr>
                            <td><?= h($creditors->id) ?></td>
                            <td><?= h($creditors->branch_id) ?></td>
                            <td><?= h($creditors->code) ?></td>
                            <td><?= h($creditors->user_id) ?></td>
                            <td><?= h($creditors->name) ?></td>
                            <td><?= h($creditors->treatment) ?></td>
                            <td><?= h($creditors->address_penghasil) ?></td>
                            <td><?= h($creditors->supplier) ?></td>
                            <td><?= h($creditors->address_supplier) ?></td>
                            <td><?= h($creditors->phone_supplier) ?></td>
                            <td><?= h($creditors->fax_supplier) ?></td>
                            <td><?= h($creditors->name_invoice) ?></td>
                            <td><?= h($creditors->address_invoice) ?></td>
                            <td><?= h($creditors->phone_invoice) ?></td>
                            <td><?= h($creditors->fax_invoice) ?></td>
                            <td><?= h($creditors->name_tax_invoice) ?></td>
                            <td><?= h($creditors->address_tax_invoice) ?></td>
                            <td><?= h($creditors->phone_tax_invoice) ?></td>
                            <td><?= h($creditors->fax_tax_invoice) ?></td>
                            <td><?= h($creditors->npwp) ?></td>
                            <td><?= h($creditors->tax) ?></td>
                            <td><?= h($creditors->city) ?></td>
                            <td><?= h($creditors->province) ?></td>
                            <td><?= h($creditors->postal) ?></td>
                            <td><?= h($creditors->country) ?></td>
                            <td><?= h($creditors->phone) ?></td>
                            <td><?= h($creditors->email) ?></td>
                            <td><?= h($creditors->system) ?></td>
                            <td><?= h($creditors->website) ?></td>
                            <td><?= h($creditors->is_create) ?></td>
                            <td><?= h($creditors->created) ?></td>
                            <td><?= h($creditors->is_update) ?></td>
                            <td><?= h($creditors->modified) ?></td>
                            <td><?= h($creditors->is_delete) ?></td>
                            <td><?= h($creditors->deleted) ?></td>
                            <td><?= h($creditors->is_active) ?></td>
                            <td><?= h($creditors->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Creditors', 'action' => 'view', $creditors->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Creditors', 'action' => 'edit', $creditors->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Creditors', 'action' => 'delete', $creditors->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditors->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Customers') ?></h4>
                <?php if (!empty($branch->customers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code Ori') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Marketing Id') ?></th>
                            <th><?= __('Data Invoice Id') ?></th>
                            <th><?= __('Data Tax Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Title Old') ?></th>
                            <th><?= __('Nickname') ?></th>
                            <th><?= __('Nickname Old') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Name Old') ?></th>
                            <th><?= __('Name Fake') ?></th>
                            <th><?= __('Check Fake') ?></th>
                            <th><?= __('Deposit Mou') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Practice Day') ?></th>
                            <th><?= __('Practice Hours Start') ?></th>
                            <th><?= __('Practice Hours End') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Taxing') ?></th>
                            <th><?= __('Pph') ?></th>
                            <th><?= __('Va') ?></th>
                            <th><?= __('Treatment') ?></th>
                            <th><?= __('Contact Person') ?></th>
                            <th><?= __('Dept Person') ?></th>
                            <th><?= __('Telp Person') ?></th>
                            <th><?= __('Warehouse Address') ?></th>
                            <th><?= __('Warehouse Telp') ?></th>
                            <th><?= __('Address Penghasil') ?></th>
                            <th><?= __('Supplier') ?></th>
                            <th><?= __('Address Supplier') ?></th>
                            <th><?= __('Phone Supplier') ?></th>
                            <th><?= __('Fax Supplier') ?></th>
                            <th><?= __('Name Invoice') ?></th>
                            <th><?= __('Address Invoice') ?></th>
                            <th><?= __('Phone Invoice') ?></th>
                            <th><?= __('Fax Invoice') ?></th>
                            <th><?= __('Name Tax Invoice') ?></th>
                            <th><?= __('Address Tax Invoice') ?></th>
                            <th><?= __('Phone Tax Invoice') ?></th>
                            <th><?= __('Fax Tax Invoice') ?></th>
                            <th><?= __('Bank An Ori') ?></th>
                            <th><?= __('Bank Name Ori') ?></th>
                            <th><?= __('Bank Norek Ori') ?></th>
                            <th><?= __('Bank An') ?></th>
                            <th><?= __('Bank Name') ?></th>
                            <th><?= __('Bank Norek') ?></th>
                            <th><?= __('Va An') ?></th>
                            <th><?= __('Va Name') ?></th>
                            <th><?= __('Va No') ?></th>
                            <th><?= __('Giro No') ?></th>
                            <th><?= __('Rek Name') ?></th>
                            <th><?= __('Rek No') ?></th>
                            <th><?= __('Rek Bank') ?></th>
                            <th><?= __('Npwp') ?></th>
                            <th><?= __('Ppn') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('District') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Phone4') ?></th>
                            <th><?= __('Phone5') ?></th>
                            <th><?= __('Email1') ?></th>
                            <th><?= __('Email2') ?></th>
                            <th><?= __('Email3') ?></th>
                            <th><?= __('Email4') ?></th>
                            <th><?= __('Email5') ?></th>
                            <th><?= __('Fb1') ?></th>
                            <th><?= __('Fb2') ?></th>
                            <th><?= __('Ym1') ?></th>
                            <th><?= __('Ym2') ?></th>
                            <th><?= __('Ym3') ?></th>
                            <th><?= __('Ym4') ?></th>
                            <th><?= __('Ym5') ?></th>
                            <th><?= __('System') ?></th>
                            <th><?= __('Website') ?></th>
                            <th><?= __('Beginning Balance') ?></th>
                            <th><?= __('Platform') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
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
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->customers as $customers) : ?>
                        <tr>
                            <td><?= h($customers->id) ?></td>
                            <td><?= h($customers->branch_id) ?></td>
                            <td><?= h($customers->code_ori) ?></td>
                            <td><?= h($customers->code) ?></td>
                            <td><?= h($customers->user_id) ?></td>
                            <td><?= h($customers->marketing_id) ?></td>
                            <td><?= h($customers->data_invoice_id) ?></td>
                            <td><?= h($customers->data_tax_id) ?></td>
                            <td><?= h($customers->mou_id) ?></td>
                            <td><?= h($customers->title) ?></td>
                            <td><?= h($customers->title_old) ?></td>
                            <td><?= h($customers->nickname) ?></td>
                            <td><?= h($customers->nickname_old) ?></td>
                            <td><?= h($customers->name) ?></td>
                            <td><?= h($customers->name_old) ?></td>
                            <td><?= h($customers->name_fake) ?></td>
                            <td><?= h($customers->check_fake) ?></td>
                            <td><?= h($customers->deposit_mou) ?></td>
                            <td><?= h($customers->type) ?></td>
                            <td><?= h($customers->group) ?></td>
                            <td><?= h($customers->practice_day) ?></td>
                            <td><?= h($customers->practice_hours_start) ?></td>
                            <td><?= h($customers->practice_hours_end) ?></td>
                            <td><?= h($customers->tax) ?></td>
                            <td><?= h($customers->taxing) ?></td>
                            <td><?= h($customers->pph) ?></td>
                            <td><?= h($customers->va) ?></td>
                            <td><?= h($customers->treatment) ?></td>
                            <td><?= h($customers->contact_person) ?></td>
                            <td><?= h($customers->dept_person) ?></td>
                            <td><?= h($customers->telp_person) ?></td>
                            <td><?= h($customers->warehouse_address) ?></td>
                            <td><?= h($customers->warehouse_telp) ?></td>
                            <td><?= h($customers->address_penghasil) ?></td>
                            <td><?= h($customers->supplier) ?></td>
                            <td><?= h($customers->address_supplier) ?></td>
                            <td><?= h($customers->phone_supplier) ?></td>
                            <td><?= h($customers->fax_supplier) ?></td>
                            <td><?= h($customers->name_invoice) ?></td>
                            <td><?= h($customers->address_invoice) ?></td>
                            <td><?= h($customers->phone_invoice) ?></td>
                            <td><?= h($customers->fax_invoice) ?></td>
                            <td><?= h($customers->name_tax_invoice) ?></td>
                            <td><?= h($customers->address_tax_invoice) ?></td>
                            <td><?= h($customers->phone_tax_invoice) ?></td>
                            <td><?= h($customers->fax_tax_invoice) ?></td>
                            <td><?= h($customers->bank_an_ori) ?></td>
                            <td><?= h($customers->bank_name_ori) ?></td>
                            <td><?= h($customers->bank_norek_ori) ?></td>
                            <td><?= h($customers->bank_an) ?></td>
                            <td><?= h($customers->bank_name) ?></td>
                            <td><?= h($customers->bank_norek) ?></td>
                            <td><?= h($customers->va_an) ?></td>
                            <td><?= h($customers->va_name) ?></td>
                            <td><?= h($customers->va_no) ?></td>
                            <td><?= h($customers->giro_no) ?></td>
                            <td><?= h($customers->rek_name) ?></td>
                            <td><?= h($customers->rek_no) ?></td>
                            <td><?= h($customers->rek_bank) ?></td>
                            <td><?= h($customers->npwp) ?></td>
                            <td><?= h($customers->ppn) ?></td>
                            <td><?= h($customers->city) ?></td>
                            <td><?= h($customers->province) ?></td>
                            <td><?= h($customers->district) ?></td>
                            <td><?= h($customers->postal) ?></td>
                            <td><?= h($customers->country) ?></td>
                            <td><?= h($customers->phone3) ?></td>
                            <td><?= h($customers->phone4) ?></td>
                            <td><?= h($customers->phone5) ?></td>
                            <td><?= h($customers->email1) ?></td>
                            <td><?= h($customers->email2) ?></td>
                            <td><?= h($customers->email3) ?></td>
                            <td><?= h($customers->email4) ?></td>
                            <td><?= h($customers->email5) ?></td>
                            <td><?= h($customers->fb1) ?></td>
                            <td><?= h($customers->fb2) ?></td>
                            <td><?= h($customers->ym1) ?></td>
                            <td><?= h($customers->ym2) ?></td>
                            <td><?= h($customers->ym3) ?></td>
                            <td><?= h($customers->ym4) ?></td>
                            <td><?= h($customers->ym5) ?></td>
                            <td><?= h($customers->system) ?></td>
                            <td><?= h($customers->website) ?></td>
                            <td><?= h($customers->beginning_balance) ?></td>
                            <td><?= h($customers->platform) ?></td>
                            <td><?= h($customers->is_active) ?></td>
                            <td><?= h($customers->is_log) ?></td>
                            <td><?= h($customers->who_create) ?></td>
                            <td><?= h($customers->created) ?></td>
                            <td><?= h($customers->who_update) ?></td>
                            <td><?= h($customers->modified) ?></td>
                            <td><?= h($customers->active) ?></td>
                            <td><?= h($customers->status) ?></td>
                            <td><?= h($customers->is_create) ?></td>
                            <td><?= h($customers->is_update) ?></td>
                            <td><?= h($customers->is_delete) ?></td>
                            <td><?= h($customers->deleted) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Customers Ori') ?></h4>
                <?php if (!empty($branch->customers_ori)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code Ori') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Marketing Id') ?></th>
                            <th><?= __('Data Invoice Id') ?></th>
                            <th><?= __('Data Tax Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Treatment') ?></th>
                            <th><?= __('Address Penghasil') ?></th>
                            <th><?= __('Supplier') ?></th>
                            <th><?= __('Address Supplier') ?></th>
                            <th><?= __('Phone Supplier') ?></th>
                            <th><?= __('Fax Supplier') ?></th>
                            <th><?= __('Name Invoice') ?></th>
                            <th><?= __('Address Invoice') ?></th>
                            <th><?= __('Phone Invoice') ?></th>
                            <th><?= __('Fax Invoice') ?></th>
                            <th><?= __('Name Tax Invoice') ?></th>
                            <th><?= __('Address Tax Invoice') ?></th>
                            <th><?= __('Phone Tax Invoice') ?></th>
                            <th><?= __('Fax Tax Invoice') ?></th>
                            <th><?= __('Npwp') ?></th>
                            <th><?= __('Ppn') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Phone4') ?></th>
                            <th><?= __('Phone5') ?></th>
                            <th><?= __('Email1') ?></th>
                            <th><?= __('Email2') ?></th>
                            <th><?= __('Email3') ?></th>
                            <th><?= __('Email4') ?></th>
                            <th><?= __('Email5') ?></th>
                            <th><?= __('Fb1') ?></th>
                            <th><?= __('Fb2') ?></th>
                            <th><?= __('Ym1') ?></th>
                            <th><?= __('Ym2') ?></th>
                            <th><?= __('Ym3') ?></th>
                            <th><?= __('Ym4') ?></th>
                            <th><?= __('Ym5') ?></th>
                            <th><?= __('System') ?></th>
                            <th><?= __('Website') ?></th>
                            <th><?= __('Is Active') ?></th>
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
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->customers_ori as $customersOri) : ?>
                        <tr>
                            <td><?= h($customersOri->id) ?></td>
                            <td><?= h($customersOri->branch_id) ?></td>
                            <td><?= h($customersOri->code_ori) ?></td>
                            <td><?= h($customersOri->code) ?></td>
                            <td><?= h($customersOri->user_id) ?></td>
                            <td><?= h($customersOri->marketing_id) ?></td>
                            <td><?= h($customersOri->data_invoice_id) ?></td>
                            <td><?= h($customersOri->data_tax_id) ?></td>
                            <td><?= h($customersOri->name) ?></td>
                            <td><?= h($customersOri->type) ?></td>
                            <td><?= h($customersOri->group) ?></td>
                            <td><?= h($customersOri->treatment) ?></td>
                            <td><?= h($customersOri->address_penghasil) ?></td>
                            <td><?= h($customersOri->supplier) ?></td>
                            <td><?= h($customersOri->address_supplier) ?></td>
                            <td><?= h($customersOri->phone_supplier) ?></td>
                            <td><?= h($customersOri->fax_supplier) ?></td>
                            <td><?= h($customersOri->name_invoice) ?></td>
                            <td><?= h($customersOri->address_invoice) ?></td>
                            <td><?= h($customersOri->phone_invoice) ?></td>
                            <td><?= h($customersOri->fax_invoice) ?></td>
                            <td><?= h($customersOri->name_tax_invoice) ?></td>
                            <td><?= h($customersOri->address_tax_invoice) ?></td>
                            <td><?= h($customersOri->phone_tax_invoice) ?></td>
                            <td><?= h($customersOri->fax_tax_invoice) ?></td>
                            <td><?= h($customersOri->npwp) ?></td>
                            <td><?= h($customersOri->ppn) ?></td>
                            <td><?= h($customersOri->tax) ?></td>
                            <td><?= h($customersOri->city) ?></td>
                            <td><?= h($customersOri->province) ?></td>
                            <td><?= h($customersOri->postal) ?></td>
                            <td><?= h($customersOri->country) ?></td>
                            <td><?= h($customersOri->phone3) ?></td>
                            <td><?= h($customersOri->phone4) ?></td>
                            <td><?= h($customersOri->phone5) ?></td>
                            <td><?= h($customersOri->email1) ?></td>
                            <td><?= h($customersOri->email2) ?></td>
                            <td><?= h($customersOri->email3) ?></td>
                            <td><?= h($customersOri->email4) ?></td>
                            <td><?= h($customersOri->email5) ?></td>
                            <td><?= h($customersOri->fb1) ?></td>
                            <td><?= h($customersOri->fb2) ?></td>
                            <td><?= h($customersOri->ym1) ?></td>
                            <td><?= h($customersOri->ym2) ?></td>
                            <td><?= h($customersOri->ym3) ?></td>
                            <td><?= h($customersOri->ym4) ?></td>
                            <td><?= h($customersOri->ym5) ?></td>
                            <td><?= h($customersOri->system) ?></td>
                            <td><?= h($customersOri->website) ?></td>
                            <td><?= h($customersOri->is_active) ?></td>
                            <td><?= h($customersOri->who_create) ?></td>
                            <td><?= h($customersOri->created) ?></td>
                            <td><?= h($customersOri->who_update) ?></td>
                            <td><?= h($customersOri->modified) ?></td>
                            <td><?= h($customersOri->active) ?></td>
                            <td><?= h($customersOri->status) ?></td>
                            <td><?= h($customersOri->is_create) ?></td>
                            <td><?= h($customersOri->is_update) ?></td>
                            <td><?= h($customersOri->is_delete) ?></td>
                            <td><?= h($customersOri->deleted) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CustomersOri', 'action' => 'view', $customersOri->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CustomersOri', 'action' => 'edit', $customersOri->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomersOri', 'action' => 'delete', $customersOri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customersOri->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Data Invoices') ?></h4>
                <?php if (!empty($branch->data_invoices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Fax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Phone4') ?></th>
                            <th><?= __('Phone5') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->data_invoices as $dataInvoices) : ?>
                        <tr>
                            <td><?= h($dataInvoices->id) ?></td>
                            <td><?= h($dataInvoices->branch_id) ?></td>
                            <td><?= h($dataInvoices->name) ?></td>
                            <td><?= h($dataInvoices->address) ?></td>
                            <td><?= h($dataInvoices->phone) ?></td>
                            <td><?= h($dataInvoices->fax) ?></td>
                            <td><?= h($dataInvoices->city) ?></td>
                            <td><?= h($dataInvoices->province) ?></td>
                            <td><?= h($dataInvoices->postal) ?></td>
                            <td><?= h($dataInvoices->country) ?></td>
                            <td><?= h($dataInvoices->phone3) ?></td>
                            <td><?= h($dataInvoices->phone4) ?></td>
                            <td><?= h($dataInvoices->phone5) ?></td>
                            <td><?= h($dataInvoices->email) ?></td>
                            <td><?= h($dataInvoices->is_create) ?></td>
                            <td><?= h($dataInvoices->created) ?></td>
                            <td><?= h($dataInvoices->is_update) ?></td>
                            <td><?= h($dataInvoices->modified) ?></td>
                            <td><?= h($dataInvoices->is_delete) ?></td>
                            <td><?= h($dataInvoices->deleted) ?></td>
                            <td><?= h($dataInvoices->is_active) ?></td>
                            <td><?= h($dataInvoices->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'DataInvoices', 'action' => 'view', $dataInvoices->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'DataInvoices', 'action' => 'edit', $dataInvoices->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'DataInvoices', 'action' => 'delete', $dataInvoices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dataInvoices->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Data Taxes') ?></h4>
                <?php if (!empty($branch->data_taxes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Fax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Phone4') ?></th>
                            <th><?= __('Phone5') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->data_taxes as $dataTaxes) : ?>
                        <tr>
                            <td><?= h($dataTaxes->id) ?></td>
                            <td><?= h($dataTaxes->branch_id) ?></td>
                            <td><?= h($dataTaxes->name) ?></td>
                            <td><?= h($dataTaxes->address) ?></td>
                            <td><?= h($dataTaxes->phone) ?></td>
                            <td><?= h($dataTaxes->fax) ?></td>
                            <td><?= h($dataTaxes->city) ?></td>
                            <td><?= h($dataTaxes->province) ?></td>
                            <td><?= h($dataTaxes->postal) ?></td>
                            <td><?= h($dataTaxes->country) ?></td>
                            <td><?= h($dataTaxes->phone3) ?></td>
                            <td><?= h($dataTaxes->phone4) ?></td>
                            <td><?= h($dataTaxes->phone5) ?></td>
                            <td><?= h($dataTaxes->email) ?></td>
                            <td><?= h($dataTaxes->is_create) ?></td>
                            <td><?= h($dataTaxes->created) ?></td>
                            <td><?= h($dataTaxes->is_update) ?></td>
                            <td><?= h($dataTaxes->modified) ?></td>
                            <td><?= h($dataTaxes->is_delete) ?></td>
                            <td><?= h($dataTaxes->deleted) ?></td>
                            <td><?= h($dataTaxes->is_active) ?></td>
                            <td><?= h($dataTaxes->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'DataTaxes', 'action' => 'view', $dataTaxes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'DataTaxes', 'action' => 'edit', $dataTaxes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'DataTaxes', 'action' => 'delete', $dataTaxes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dataTaxes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Deposits') ?></h4>
                <?php if (!empty($branch->deposits)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Transfer Mou Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Invoice Deposit Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Date Expired') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->deposits as $deposits) : ?>
                        <tr>
                            <td><?= h($deposits->id) ?></td>
                            <td><?= h($deposits->branch_id) ?></td>
                            <td><?= h($deposits->mou_id) ?></td>
                            <td><?= h($deposits->transfer_mou_id) ?></td>
                            <td><?= h($deposits->invoice_id) ?></td>
                            <td><?= h($deposits->invoice_deposit_id) ?></td>
                            <td><?= h($deposits->date) ?></td>
                            <td><?= h($deposits->type) ?></td>
                            <td><?= h($deposits->desc) ?></td>
                            <td><?= h($deposits->debet) ?></td>
                            <td><?= h($deposits->credit) ?></td>
                            <td><?= h($deposits->date_expired) ?></td>
                            <td><?= h($deposits->is_approve) ?></td>
                            <td><?= h($deposits->date_approve) ?></td>
                            <td><?= h($deposits->is_active) ?></td>
                            <td><?= h($deposits->is_log) ?></td>
                            <td><?= h($deposits->is_create) ?></td>
                            <td><?= h($deposits->is_update) ?></td>
                            <td><?= h($deposits->created) ?></td>
                            <td><?= h($deposits->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Deposits', 'action' => 'view', $deposits->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Deposits', 'action' => 'edit', $deposits->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Deposits', 'action' => 'delete', $deposits->id], ['confirm' => __('Are you sure you want to delete # {0}?', $deposits->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Depreciations') ?></h4>
                <?php if (!empty($branch->depreciations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Count Of Journal') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Last Date Of Journal') ?></th>
                            <th><?= __('Date Acquisition') ?></th>
                            <th><?= __('Date End') ?></th>
                            <th><?= __('Location') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Age Goods') ?></th>
                            <th><?= __('Method') ?></th>
                            <th><?= __('Percent') ?></th>
                            <th><?= __('Residual Value') ?></th>
                            <th><?= __('Per Month') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->depreciations as $depreciations) : ?>
                        <tr>
                            <td><?= h($depreciations->id) ?></td>
                            <td><?= h($depreciations->branch_id) ?></td>
                            <td><?= h($depreciations->code) ?></td>
                            <td><?= h($depreciations->supplier_id) ?></td>
                            <td><?= h($depreciations->name) ?></td>
                            <td><?= h($depreciations->count_of_journal) ?></td>
                            <td><?= h($depreciations->group) ?></td>
                            <td><?= h($depreciations->type) ?></td>
                            <td><?= h($depreciations->last_date_of_journal) ?></td>
                            <td><?= h($depreciations->date_acquisition) ?></td>
                            <td><?= h($depreciations->date_end) ?></td>
                            <td><?= h($depreciations->location) ?></td>
                            <td><?= h($depreciations->price) ?></td>
                            <td><?= h($depreciations->age_goods) ?></td>
                            <td><?= h($depreciations->method) ?></td>
                            <td><?= h($depreciations->percent) ?></td>
                            <td><?= h($depreciations->residual_value) ?></td>
                            <td><?= h($depreciations->per_month) ?></td>
                            <td><?= h($depreciations->status) ?></td>
                            <td><?= h($depreciations->is_create) ?></td>
                            <td><?= h($depreciations->created) ?></td>
                            <td><?= h($depreciations->is_update) ?></td>
                            <td><?= h($depreciations->modified) ?></td>
                            <td><?= h($depreciations->is_delete) ?></td>
                            <td><?= h($depreciations->deleted) ?></td>
                            <td><?= h($depreciations->is_active) ?></td>
                            <td><?= h($depreciations->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Depreciations', 'action' => 'view', $depreciations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Depreciations', 'action' => 'edit', $depreciations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Depreciations', 'action' => 'delete', $depreciations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $depreciations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Depreciationse') ?></h4>
                <?php if (!empty($branch->depreciationse)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Count Of Journal') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Last Date Of Journal') ?></th>
                            <th><?= __('Date Acquisition') ?></th>
                            <th><?= __('Date End') ?></th>
                            <th><?= __('Location') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Age Goods') ?></th>
                            <th><?= __('Method') ?></th>
                            <th><?= __('Percent') ?></th>
                            <th><?= __('Residual Value') ?></th>
                            <th><?= __('Per Month') ?></th>
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
                        <?php foreach ($branch->depreciationse as $depreciationse) : ?>
                        <tr>
                            <td><?= h($depreciationse->id) ?></td>
                            <td><?= h($depreciationse->branch_id) ?></td>
                            <td><?= h($depreciationse->code) ?></td>
                            <td><?= h($depreciationse->supplier_id) ?></td>
                            <td><?= h($depreciationse->name) ?></td>
                            <td><?= h($depreciationse->count_of_journal) ?></td>
                            <td><?= h($depreciationse->group) ?></td>
                            <td><?= h($depreciationse->last_date_of_journal) ?></td>
                            <td><?= h($depreciationse->date_acquisition) ?></td>
                            <td><?= h($depreciationse->date_end) ?></td>
                            <td><?= h($depreciationse->location) ?></td>
                            <td><?= h($depreciationse->price) ?></td>
                            <td><?= h($depreciationse->age_goods) ?></td>
                            <td><?= h($depreciationse->method) ?></td>
                            <td><?= h($depreciationse->percent) ?></td>
                            <td><?= h($depreciationse->residual_value) ?></td>
                            <td><?= h($depreciationse->per_month) ?></td>
                            <td><?= h($depreciationse->status) ?></td>
                            <td><?= h($depreciationse->is_create) ?></td>
                            <td><?= h($depreciationse->created) ?></td>
                            <td><?= h($depreciationse->is_update) ?></td>
                            <td><?= h($depreciationse->modified) ?></td>
                            <td><?= h($depreciationse->is_delete) ?></td>
                            <td><?= h($depreciationse->deleted) ?></td>
                            <td><?= h($depreciationse->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Depreciationse', 'action' => 'view', $depreciationse->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Depreciationse', 'action' => 'edit', $depreciationse->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Depreciationse', 'action' => 'delete', $depreciationse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $depreciationse->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Depreciationss') ?></h4>
                <?php if (!empty($branch->depreciationss)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Count Of Journal') ?></th>
                            <th><?= __('Last Date Of Journal') ?></th>
                            <th><?= __('Date Acquisition') ?></th>
                            <th><?= __('Date End') ?></th>
                            <th><?= __('Location') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Age Goods') ?></th>
                            <th><?= __('Method') ?></th>
                            <th><?= __('Percent') ?></th>
                            <th><?= __('Residual Value') ?></th>
                            <th><?= __('Per Month') ?></th>
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
                        <?php foreach ($branch->depreciationss as $depreciationss) : ?>
                        <tr>
                            <td><?= h($depreciationss->id) ?></td>
                            <td><?= h($depreciationss->branch_id) ?></td>
                            <td><?= h($depreciationss->code) ?></td>
                            <td><?= h($depreciationss->supplier_id) ?></td>
                            <td><?= h($depreciationss->name) ?></td>
                            <td><?= h($depreciationss->count_of_journal) ?></td>
                            <td><?= h($depreciationss->last_date_of_journal) ?></td>
                            <td><?= h($depreciationss->date_acquisition) ?></td>
                            <td><?= h($depreciationss->date_end) ?></td>
                            <td><?= h($depreciationss->location) ?></td>
                            <td><?= h($depreciationss->price) ?></td>
                            <td><?= h($depreciationss->age_goods) ?></td>
                            <td><?= h($depreciationss->method) ?></td>
                            <td><?= h($depreciationss->percent) ?></td>
                            <td><?= h($depreciationss->residual_value) ?></td>
                            <td><?= h($depreciationss->per_month) ?></td>
                            <td><?= h($depreciationss->status) ?></td>
                            <td><?= h($depreciationss->is_create) ?></td>
                            <td><?= h($depreciationss->created) ?></td>
                            <td><?= h($depreciationss->is_update) ?></td>
                            <td><?= h($depreciationss->modified) ?></td>
                            <td><?= h($depreciationss->is_delete) ?></td>
                            <td><?= h($depreciationss->deleted) ?></td>
                            <td><?= h($depreciationss->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Depreciationss', 'action' => 'view', $depreciationss->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Depreciationss', 'action' => 'edit', $depreciationss->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Depreciationss', 'action' => 'delete', $depreciationss->id], ['confirm' => __('Are you sure you want to delete # {0}?', $depreciationss->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Drivers') ?></h4>
                <?php if (!empty($branch->drivers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Rent Cost') ?></th>
                            <th><?= __('Phone1') ?></th>
                            <th><?= __('Phone2') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is View') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->drivers as $drivers) : ?>
                        <tr>
                            <td><?= h($drivers->id) ?></td>
                            <td><?= h($drivers->branch_id) ?></td>
                            <td><?= h($drivers->name) ?></td>
                            <td><?= h($drivers->rent_cost) ?></td>
                            <td><?= h($drivers->phone1) ?></td>
                            <td><?= h($drivers->phone2) ?></td>
                            <td><?= h($drivers->phone3) ?></td>
                            <td><?= h($drivers->group) ?></td>
                            <td><?= h($drivers->is_create) ?></td>
                            <td><?= h($drivers->created) ?></td>
                            <td><?= h($drivers->is_update) ?></td>
                            <td><?= h($drivers->modified) ?></td>
                            <td><?= h($drivers->is_delete) ?></td>
                            <td><?= h($drivers->deleted) ?></td>
                            <td><?= h($drivers->is_view) ?></td>
                            <td><?= h($drivers->is_active) ?></td>
                            <td><?= h($drivers->is_log) ?></td>
                            <td><?= h($drivers->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Drivers', 'action' => 'view', $drivers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Drivers', 'action' => 'edit', $drivers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Drivers', 'action' => 'delete', $drivers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $drivers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoice Deposits') ?></h4>
                <?php if (!empty($branch->invoice_deposits)) : ?>
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
                        <?php foreach ($branch->invoice_deposits as $invoiceDeposits) : ?>
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
                <?php if (!empty($branch->invoice_entries)) : ?>
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
                        <?php foreach ($branch->invoice_entries as $invoiceEntries) : ?>
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
                <h4><?= __('Related Invoice Hutangs') ?></h4>
                <?php if (!empty($branch->invoice_hutangs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Number') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('From') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
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
                            <th><?= __('Receive Date') ?></th>
                            <th><?= __('Receive') ?></th>
                            <th><?= __('Sign Id') ?></th>
                            <th><?= __('Director') ?></th>
                            <th><?= __('Posting') ?></th>
                            <th><?= __('Posting Date') ?></th>
                            <th><?= __('Created') ?></th>
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
                        <?php foreach ($branch->invoice_hutangs as $invoiceHutangs) : ?>
                        <tr>
                            <td><?= h($invoiceHutangs->id) ?></td>
                            <td><?= h($invoiceHutangs->branch_id) ?></td>
                            <td><?= h($invoiceHutangs->number) ?></td>
                            <td><?= h($invoiceHutangs->tax) ?></td>
                            <td><?= h($invoiceHutangs->from) ?></td>
                            <td><?= h($invoiceHutangs->date) ?></td>
                            <td><?= h($invoiceHutangs->due_date) ?></td>
                            <td><?= h($invoiceHutangs->payment) ?></td>
                            <td><?= h($invoiceHutangs->payment_date) ?></td>
                            <td><?= h($invoiceHutangs->payment_who) ?></td>
                            <td><?= h($invoiceHutangs->payment_jumlah) ?></td>
                            <td><?= h($invoiceHutangs->payment_desc) ?></td>
                            <td><?= h($invoiceHutangs->payment_method) ?></td>
                            <td><?= h($invoiceHutangs->payment_bank) ?></td>
                            <td><?= h($invoiceHutangs->payment_bank_va) ?></td>
                            <td><?= h($invoiceHutangs->biaya_bank) ?></td>
                            <td><?= h($invoiceHutangs->pembulatan) ?></td>
                            <td><?= h($invoiceHutangs->description) ?></td>
                            <td><?= h($invoiceHutangs->pph_no) ?></td>
                            <td><?= h($invoiceHutangs->pph_date) ?></td>
                            <td><?= h($invoiceHutangs->pph_jumlah) ?></td>
                            <td><?= h($invoiceHutangs->ppn_900_date) ?></td>
                            <td><?= h($invoiceHutangs->ppn_900_jumlah) ?></td>
                            <td><?= h($invoiceHutangs->receive_date) ?></td>
                            <td><?= h($invoiceHutangs->receive) ?></td>
                            <td><?= h($invoiceHutangs->sign_id) ?></td>
                            <td><?= h($invoiceHutangs->director) ?></td>
                            <td><?= h($invoiceHutangs->posting) ?></td>
                            <td><?= h($invoiceHutangs->posting_date) ?></td>
                            <td><?= h($invoiceHutangs->created) ?></td>
                            <td><?= h($invoiceHutangs->modified) ?></td>
                            <td><?= h($invoiceHutangs->active) ?></td>
                            <td><?= h($invoiceHutangs->status) ?></td>
                            <td><?= h($invoiceHutangs->is_log) ?></td>
                            <td><?= h($invoiceHutangs->is_create) ?></td>
                            <td><?= h($invoiceHutangs->is_update) ?></td>
                            <td><?= h($invoiceHutangs->is_delete) ?></td>
                            <td><?= h($invoiceHutangs->deleted) ?></td>
                            <td><?= h($invoiceHutangs->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InvoiceHutangs', 'action' => 'view', $invoiceHutangs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InvoiceHutangs', 'action' => 'edit', $invoiceHutangs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'InvoiceHutangs', 'action' => 'delete', $invoiceHutangs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceHutangs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoice Outs') ?></h4>
                <?php if (!empty($branch->invoice_outs)) : ?>
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
                        <?php foreach ($branch->invoice_outs as $invoiceOuts) : ?>
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
                <?php if (!empty($branch->invoices)) : ?>
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
                        <?php foreach ($branch->invoices as $invoices) : ?>
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
                <h4><?= __('Related Logs') ?></h4>
                <?php if (!empty($branch->logs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Controller') ?></th>
                            <th><?= __('Action') ?></th>
                            <th><?= __('Params') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->logs as $logs) : ?>
                        <tr>
                            <td><?= h($logs->id) ?></td>
                            <td><?= h($logs->branch_id) ?></td>
                            <td><?= h($logs->controller) ?></td>
                            <td><?= h($logs->action) ?></td>
                            <td><?= h($logs->params) ?></td>
                            <td><?= h($logs->url) ?></td>
                            <td><?= h($logs->description) ?></td>
                            <td><?= h($logs->type) ?></td>
                            <td><?= h($logs->created) ?></td>
                            <td><?= h($logs->modified) ?></td>
                            <td><?= h($logs->user_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Logs', 'action' => 'view', $logs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Logs', 'action' => 'edit', $logs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Logs', 'action' => 'delete', $logs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Manifest Directs') ?></h4>
                <?php if (!empty($branch->manifest_directs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Klh') ?></th>
                            <th><?= __('No Stemple') ?></th>
                            <th><?= __('Solid Liquid') ?></th>
                            <th><?= __('Waste Type') ?></th>
                            <th><?= __('Waste Name') ?></th>
                            <th><?= __('Date Of Entry') ?></th>
                            <th><?= __('Freight Date') ?></th>
                            <th><?= __('Sources Of Waste') ?></th>
                            <th><?= __('Nopol') ?></th>
                            <th><?= __('Driver') ?></th>
                            <th><?= __('Packaging') ?></th>
                            <th><?= __('Qty') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Waste Out Date') ?></th>
                            <th><?= __('Nopol Out') ?></th>
                            <th><?= __('Driver Out') ?></th>
                            <th><?= __('Qty Out') ?></th>
                            <th><?= __('Unit Out') ?></th>
                            <th><?= __('Destination Of Waste') ?></th>
                            <th><?= __('Evidence Document') ?></th>
                            <th><?= __('No Evidence Document') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Cancel') ?></th>
                            <th><?= __('Canceled') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Status') ?></th>
                            <th><?= __('Status Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->manifest_directs as $manifestDirects) : ?>
                        <tr>
                            <td><?= h($manifestDirects->id) ?></td>
                            <td><?= h($manifestDirects->branch_id) ?></td>
                            <td><?= h($manifestDirects->code) ?></td>
                            <td><?= h($manifestDirects->type) ?></td>
                            <td><?= h($manifestDirects->klh) ?></td>
                            <td><?= h($manifestDirects->no_stemple) ?></td>
                            <td><?= h($manifestDirects->solid_liquid) ?></td>
                            <td><?= h($manifestDirects->waste_type) ?></td>
                            <td><?= h($manifestDirects->waste_name) ?></td>
                            <td><?= h($manifestDirects->date_of_entry) ?></td>
                            <td><?= h($manifestDirects->freight_date) ?></td>
                            <td><?= h($manifestDirects->sources_of_waste) ?></td>
                            <td><?= h($manifestDirects->nopol) ?></td>
                            <td><?= h($manifestDirects->driver) ?></td>
                            <td><?= h($manifestDirects->packaging) ?></td>
                            <td><?= h($manifestDirects->qty) ?></td>
                            <td><?= h($manifestDirects->unit) ?></td>
                            <td><?= h($manifestDirects->waste_out_date) ?></td>
                            <td><?= h($manifestDirects->nopol_out) ?></td>
                            <td><?= h($manifestDirects->driver_out) ?></td>
                            <td><?= h($manifestDirects->qty_out) ?></td>
                            <td><?= h($manifestDirects->unit_out) ?></td>
                            <td><?= h($manifestDirects->destination_of_waste) ?></td>
                            <td><?= h($manifestDirects->evidence_document) ?></td>
                            <td><?= h($manifestDirects->no_evidence_document) ?></td>
                            <td><?= h($manifestDirects->description) ?></td>
                            <td><?= h($manifestDirects->is_create) ?></td>
                            <td><?= h($manifestDirects->created) ?></td>
                            <td><?= h($manifestDirects->is_update) ?></td>
                            <td><?= h($manifestDirects->modified) ?></td>
                            <td><?= h($manifestDirects->is_delete) ?></td>
                            <td><?= h($manifestDirects->deleted) ?></td>
                            <td><?= h($manifestDirects->is_cancel) ?></td>
                            <td><?= h($manifestDirects->canceled) ?></td>
                            <td><?= h($manifestDirects->is_active) ?></td>
                            <td><?= h($manifestDirects->is_log) ?></td>
                            <td><?= h($manifestDirects->is_status) ?></td>
                            <td><?= h($manifestDirects->status_date) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ManifestDirects', 'action' => 'view', $manifestDirects->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ManifestDirects', 'action' => 'edit', $manifestDirects->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ManifestDirects', 'action' => 'delete', $manifestDirects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manifestDirects->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Manifest Insides') ?></h4>
                <?php if (!empty($branch->manifest_insides)) : ?>
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
                        <?php foreach ($branch->manifest_insides as $manifestInsides) : ?>
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
                <h4><?= __('Related Manifest Logbooks') ?></h4>
                <?php if (!empty($branch->manifest_logbooks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Manifest Id') ?></th>
                            <th><?= __('Manifest Inside Id') ?></th>
                            <th><?= __('Quantity Get') ?></th>
                            <th><?= __('Unit Get') ?></th>
                            <th><?= __('Date Out') ?></th>
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
                        <?php foreach ($branch->manifest_logbooks as $manifestLogbooks) : ?>
                        <tr>
                            <td><?= h($manifestLogbooks->id) ?></td>
                            <td><?= h($manifestLogbooks->branch_id) ?></td>
                            <td><?= h($manifestLogbooks->manifest_id) ?></td>
                            <td><?= h($manifestLogbooks->manifest_inside_id) ?></td>
                            <td><?= h($manifestLogbooks->quantity_get) ?></td>
                            <td><?= h($manifestLogbooks->unit_get) ?></td>
                            <td><?= h($manifestLogbooks->date_out) ?></td>
                            <td><?= h($manifestLogbooks->is_create) ?></td>
                            <td><?= h($manifestLogbooks->created) ?></td>
                            <td><?= h($manifestLogbooks->is_update) ?></td>
                            <td><?= h($manifestLogbooks->modified) ?></td>
                            <td><?= h($manifestLogbooks->is_delete) ?></td>
                            <td><?= h($manifestLogbooks->deleted) ?></td>
                            <td><?= h($manifestLogbooks->is_active) ?></td>
                            <td><?= h($manifestLogbooks->is_log) ?></td>
                            <td><?= h($manifestLogbooks->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ManifestLogbooks', 'action' => 'view', $manifestLogbooks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ManifestLogbooks', 'action' => 'edit', $manifestLogbooks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ManifestLogbooks', 'action' => 'delete', $manifestLogbooks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $manifestLogbooks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Manifest Processors') ?></h4>
                <?php if (!empty($branch->manifest_processors)) : ?>
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
                        <?php foreach ($branch->manifest_processors as $manifestProcessors) : ?>
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
                <?php if (!empty($branch->manifests)) : ?>
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
                        <?php foreach ($branch->manifests as $manifests) : ?>
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
                <h4><?= __('Related Mou Cs') ?></h4>
                <?php if (!empty($branch->mou_cs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Mou Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Monthyear') ?></th>
                            <th><?= __('Cs Id') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->mou_cs as $mouCs) : ?>
                        <tr>
                            <td><?= h($mouCs->id) ?></td>
                            <td><?= h($mouCs->branch_id) ?></td>
                            <td><?= h($mouCs->mou_id) ?></td>
                            <td><?= h($mouCs->date) ?></td>
                            <td><?= h($mouCs->monthyear) ?></td>
                            <td><?= h($mouCs->cs_id) ?></td>
                            <td><?= h($mouCs->desc) ?></td>
                            <td><?= h($mouCs->is_create) ?></td>
                            <td><?= h($mouCs->created) ?></td>
                            <td><?= h($mouCs->is_update) ?></td>
                            <td><?= h($mouCs->modified) ?></td>
                            <td><?= h($mouCs->is_delete) ?></td>
                            <td><?= h($mouCs->deleted) ?></td>
                            <td><?= h($mouCs->status) ?></td>
                            <td><?= h($mouCs->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'MouCs', 'action' => 'view', $mouCs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'MouCs', 'action' => 'edit', $mouCs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'MouCs', 'action' => 'delete', $mouCs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mouCs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Mouses') ?></h4>
                <?php if (!empty($branch->mouses)) : ?>
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
                        <?php foreach ($branch->mouses as $mouses) : ?>
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
                <h4><?= __('Related Numbers') ?></h4>
                <?php if (!empty($branch->numbers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Format') ?></th>
                            <th><?= __('Last Number') ?></th>
                            <th><?= __('Pad') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->numbers as $numbers) : ?>
                        <tr>
                            <td><?= h($numbers->id) ?></td>
                            <td><?= h($numbers->branch_id) ?></td>
                            <td><?= h($numbers->name) ?></td>
                            <td><?= h($numbers->format) ?></td>
                            <td><?= h($numbers->last_number) ?></td>
                            <td><?= h($numbers->pad) ?></td>
                            <td><?= h($numbers->is_create) ?></td>
                            <td><?= h($numbers->created) ?></td>
                            <td><?= h($numbers->is_update) ?></td>
                            <td><?= h($numbers->modified) ?></td>
                            <td><?= h($numbers->is_delete) ?></td>
                            <td><?= h($numbers->deleted) ?></td>
                            <td><?= h($numbers->status) ?></td>
                            <td><?= h($numbers->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Numbers', 'action' => 'view', $numbers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Numbers', 'action' => 'edit', $numbers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Numbers', 'action' => 'delete', $numbers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $numbers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Offers') ?></h4>
                <?php if (!empty($branch->offers)) : ?>
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
                        <?php foreach ($branch->offers as $offers) : ?>
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
                <h4><?= __('Related Operational Lines') ?></h4>
                <?php if (!empty($branch->operational_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Operational Id') ?></th>
                            <th><?= __('Rent Cost') ?></th>
                            <th><?= __('Date Sum') ?></th>
                            <th><?= __('Bbm') ?></th>
                            <th><?= __('Bbm Keterangan') ?></th>
                            <th><?= __('Uang Makan') ?></th>
                            <th><?= __('Uang Makan Keterangan') ?></th>
                            <th><?= __('Uang Makan Driver') ?></th>
                            <th><?= __('Uang Makan Driver Keterangan') ?></th>
                            <th><?= __('Uang Makan Helper') ?></th>
                            <th><?= __('Uang Makan Helper Keterangan') ?></th>
                            <th><?= __('Uang Makan Helper Luar') ?></th>
                            <th><?= __('Uang Makan Helper Luar Keterangan') ?></th>
                            <th><?= __('Ritasi') ?></th>
                            <th><?= __('Ritasi Keterangan') ?></th>
                            <th><?= __('Ritasi Driver') ?></th>
                            <th><?= __('Ritasi Driver Keterangan') ?></th>
                            <th><?= __('Ritasi Helper') ?></th>
                            <th><?= __('Ritasi Helper Keterangan') ?></th>
                            <th><?= __('Ritasi Helper Luar') ?></th>
                            <th><?= __('Ritasi Helper Luar Keterangan') ?></th>
                            <th><?= __('Penginapan') ?></th>
                            <th><?= __('Penginapan Driver') ?></th>
                            <th><?= __('Penginapan Driver Keterangan') ?></th>
                            <th><?= __('Penginapan Helper') ?></th>
                            <th><?= __('Penginapan Helper Keterangan') ?></th>
                            <th><?= __('Penginapan Helper Luar') ?></th>
                            <th><?= __('Penginapan Helper Luar Keterangan') ?></th>
                            <th><?= __('Tol') ?></th>
                            <th><?= __('Tol Keterangan') ?></th>
                            <th><?= __('Timbangan Umum') ?></th>
                            <th><?= __('Timbangan Umum Keterangan') ?></th>
                            <th><?= __('Biaya Customer') ?></th>
                            <th><?= __('Biaya Customer Keterangan') ?></th>
                            <th><?= __('Biaya Customer Satpam') ?></th>
                            <th><?= __('Biaya Customer Satpam Keterangan') ?></th>
                            <th><?= __('Biaya Customer Tenaga Kerja') ?></th>
                            <th><?= __('Biaya Customer Tenaga Kerja Keterangan') ?></th>
                            <th><?= __('Biaya Customer Surat') ?></th>
                            <th><?= __('Biaya Customer Surat Keterangan') ?></th>
                            <th><?= __('Biaya Customer Timbangan') ?></th>
                            <th><?= __('Biaya Customer Timbangan Keterangan') ?></th>
                            <th><?= __('Biaya Customer Lain') ?></th>
                            <th><?= __('Biaya Customer Lain Keterangan') ?></th>
                            <th><?= __('Biaya Pengolah') ?></th>
                            <th><?= __('Biaya Pengolah Keterangan') ?></th>
                            <th><?= __('Biaya Pengolah Satpam') ?></th>
                            <th><?= __('Biaya Pengolah Satpam Keterangan') ?></th>
                            <th><?= __('Biaya Pengolah Tenaga Kerja') ?></th>
                            <th><?= __('Biaya Pengolah Tenaga Kerja Keterangan') ?></th>
                            <th><?= __('Biaya Pengolah Surat') ?></th>
                            <th><?= __('Biaya Pengolah Surat Keterangan') ?></th>
                            <th><?= __('Biaya Pengolah Timbangan') ?></th>
                            <th><?= __('Biaya Pengolah Timbangan Keterangan') ?></th>
                            <th><?= __('Biaya Pengolah Lain') ?></th>
                            <th><?= __('Biaya Pengolah Lain Keterangan') ?></th>
                            <th><?= __('Lain') ?></th>
                            <th><?= __('Lain Keterangan') ?></th>
                            <th><?= __('Lain Tenaga Kerja') ?></th>
                            <th><?= __('Lain Tenaga Kerja Keterangan') ?></th>
                            <th><?= __('Lain Perawatan Perlengkapan') ?></th>
                            <th><?= __('Lain Perawatan Perlengkapan Keterangan') ?></th>
                            <th><?= __('Lain Keamanan') ?></th>
                            <th><?= __('Lain Keamanan Keterangan') ?></th>
                            <th><?= __('Lain Jaldin') ?></th>
                            <th><?= __('Lain Jaldin Keterangan') ?></th>
                            <th><?= __('Lain External') ?></th>
                            <th><?= __('Lain External Keterangan') ?></th>
                            <th><?= __('Lain Perlengkapan') ?></th>
                            <th><?= __('Lain Perlengkapan Keterangan') ?></th>
                            <th><?= __('Lain Lain') ?></th>
                            <th><?= __('Lain Lain Keterangan') ?></th>
                            <th><?= __('Cash Bon') ?></th>
                            <th><?= __('Cash Bon Keterangan') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->operational_lines as $operationalLines) : ?>
                        <tr>
                            <td><?= h($operationalLines->id) ?></td>
                            <td><?= h($operationalLines->branch_id) ?></td>
                            <td><?= h($operationalLines->operational_id) ?></td>
                            <td><?= h($operationalLines->rent_cost) ?></td>
                            <td><?= h($operationalLines->date_sum) ?></td>
                            <td><?= h($operationalLines->bbm) ?></td>
                            <td><?= h($operationalLines->bbm_keterangan) ?></td>
                            <td><?= h($operationalLines->uang_makan) ?></td>
                            <td><?= h($operationalLines->uang_makan_keterangan) ?></td>
                            <td><?= h($operationalLines->uang_makan_driver) ?></td>
                            <td><?= h($operationalLines->uang_makan_driver_keterangan) ?></td>
                            <td><?= h($operationalLines->uang_makan_helper) ?></td>
                            <td><?= h($operationalLines->uang_makan_helper_keterangan) ?></td>
                            <td><?= h($operationalLines->uang_makan_helper_luar) ?></td>
                            <td><?= h($operationalLines->uang_makan_helper_luar_keterangan) ?></td>
                            <td><?= h($operationalLines->ritasi) ?></td>
                            <td><?= h($operationalLines->ritasi_keterangan) ?></td>
                            <td><?= h($operationalLines->ritasi_driver) ?></td>
                            <td><?= h($operationalLines->ritasi_driver_keterangan) ?></td>
                            <td><?= h($operationalLines->ritasi_helper) ?></td>
                            <td><?= h($operationalLines->ritasi_helper_keterangan) ?></td>
                            <td><?= h($operationalLines->ritasi_helper_luar) ?></td>
                            <td><?= h($operationalLines->ritasi_helper_luar_keterangan) ?></td>
                            <td><?= h($operationalLines->penginapan) ?></td>
                            <td><?= h($operationalLines->penginapan_driver) ?></td>
                            <td><?= h($operationalLines->penginapan_driver_keterangan) ?></td>
                            <td><?= h($operationalLines->penginapan_helper) ?></td>
                            <td><?= h($operationalLines->penginapan_helper_keterangan) ?></td>
                            <td><?= h($operationalLines->penginapan_helper_luar) ?></td>
                            <td><?= h($operationalLines->penginapan_helper_luar_keterangan) ?></td>
                            <td><?= h($operationalLines->tol) ?></td>
                            <td><?= h($operationalLines->tol_keterangan) ?></td>
                            <td><?= h($operationalLines->timbangan_umum) ?></td>
                            <td><?= h($operationalLines->timbangan_umum_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer) ?></td>
                            <td><?= h($operationalLines->biaya_customer_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer_satpam) ?></td>
                            <td><?= h($operationalLines->biaya_customer_satpam_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer_tenaga_kerja) ?></td>
                            <td><?= h($operationalLines->biaya_customer_tenaga_kerja_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer_surat) ?></td>
                            <td><?= h($operationalLines->biaya_customer_surat_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer_timbangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer_timbangan_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_customer_lain) ?></td>
                            <td><?= h($operationalLines->biaya_customer_lain_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_satpam) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_satpam_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_tenaga_kerja) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_tenaga_kerja_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_surat) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_surat_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_timbangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_timbangan_keterangan) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_lain) ?></td>
                            <td><?= h($operationalLines->biaya_pengolah_lain_keterangan) ?></td>
                            <td><?= h($operationalLines->lain) ?></td>
                            <td><?= h($operationalLines->lain_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_tenaga_kerja) ?></td>
                            <td><?= h($operationalLines->lain_tenaga_kerja_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_perawatan_perlengkapan) ?></td>
                            <td><?= h($operationalLines->lain_perawatan_perlengkapan_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_keamanan) ?></td>
                            <td><?= h($operationalLines->lain_keamanan_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_jaldin) ?></td>
                            <td><?= h($operationalLines->lain_jaldin_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_external) ?></td>
                            <td><?= h($operationalLines->lain_external_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_perlengkapan) ?></td>
                            <td><?= h($operationalLines->lain_perlengkapan_keterangan) ?></td>
                            <td><?= h($operationalLines->lain_lain) ?></td>
                            <td><?= h($operationalLines->lain_lain_keterangan) ?></td>
                            <td><?= h($operationalLines->cash_bon) ?></td>
                            <td><?= h($operationalLines->cash_bon_keterangan) ?></td>
                            <td><?= h($operationalLines->who_create) ?></td>
                            <td><?= h($operationalLines->created) ?></td>
                            <td><?= h($operationalLines->who_update) ?></td>
                            <td><?= h($operationalLines->modified) ?></td>
                            <td><?= h($operationalLines->status) ?></td>
                            <td><?= h($operationalLines->is_create) ?></td>
                            <td><?= h($operationalLines->is_update) ?></td>
                            <td><?= h($operationalLines->is_delete) ?></td>
                            <td><?= h($operationalLines->deleted) ?></td>
                            <td><?= h($operationalLines->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OperationalLines', 'action' => 'view', $operationalLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OperationalLines', 'action' => 'edit', $operationalLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OperationalLines', 'action' => 'delete', $operationalLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $operationalLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Operationals') ?></h4>
                <?php if (!empty($branch->operationals)) : ?>
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
                        <?php foreach ($branch->operationals as $operationals) : ?>
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
                <h4><?= __('Related Order Regulars') ?></h4>
                <?php if (!empty($branch->order_regulars)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Date') ?></th>
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
                        <?php foreach ($branch->order_regulars as $orderRegulars) : ?>
                        <tr>
                            <td><?= h($orderRegulars->id) ?></td>
                            <td><?= h($orderRegulars->branch_id) ?></td>
                            <td><?= h($orderRegulars->code) ?></td>
                            <td><?= h($orderRegulars->name) ?></td>
                            <td><?= h($orderRegulars->title) ?></td>
                            <td><?= h($orderRegulars->date) ?></td>
                            <td><?= h($orderRegulars->description) ?></td>
                            <td><?= h($orderRegulars->is_create) ?></td>
                            <td><?= h($orderRegulars->is_update) ?></td>
                            <td><?= h($orderRegulars->is_delete) ?></td>
                            <td><?= h($orderRegulars->created) ?></td>
                            <td><?= h($orderRegulars->modified) ?></td>
                            <td><?= h($orderRegulars->deleted) ?></td>
                            <td><?= h($orderRegulars->is_active) ?></td>
                            <td><?= h($orderRegulars->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrderRegulars', 'action' => 'view', $orderRegulars->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrderRegulars', 'action' => 'edit', $orderRegulars->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderRegulars', 'action' => 'delete', $orderRegulars->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderRegulars->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Orders') ?></h4>
                <?php if (!empty($branch->orders)) : ?>
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
                        <?php foreach ($branch->orders as $orders) : ?>
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
                <?php if (!empty($branch->orders_ori)) : ?>
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
                        <?php foreach ($branch->orders_ori as $ordersOri) : ?>
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
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($branch->payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Invoice Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Credit Nominal') ?></th>
                            <th><?= __('Credit Date') ?></th>
                            <th><?= __('Is Payment') ?></th>
                            <th><?= __('Method') ?></th>
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
                        <?php foreach ($branch->payments as $payments) : ?>
                        <tr>
                            <td><?= h($payments->id) ?></td>
                            <td><?= h($payments->branch_id) ?></td>
                            <td><?= h($payments->invoice_id) ?></td>
                            <td><?= h($payments->date) ?></td>
                            <td><?= h($payments->credit_nominal) ?></td>
                            <td><?= h($payments->credit_date) ?></td>
                            <td><?= h($payments->is_payment) ?></td>
                            <td><?= h($payments->method) ?></td>
                            <td><?= h($payments->is_create) ?></td>
                            <td><?= h($payments->created) ?></td>
                            <td><?= h($payments->is_update) ?></td>
                            <td><?= h($payments->modified) ?></td>
                            <td><?= h($payments->is_delete) ?></td>
                            <td><?= h($payments->deleted) ?></td>
                            <td><?= h($payments->is_active) ?></td>
                            <td><?= h($payments->is_log) ?></td>
                            <td><?= h($payments->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Permits') ?></h4>
                <?php if (!empty($branch->permits)) : ?>
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
                        <?php foreach ($branch->permits as $permits) : ?>
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
                <h4><?= __('Related Petty Cash Bank Topups') ?></h4>
                <?php if (!empty($branch->petty_cash_bank_topups)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Acc Chart Of Account Bank Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Project') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Detail Of Request') ?></th>
                            <th><?= __('Devision') ?></th>
                            <th><?= __('Purpose Of Advancing') ?></th>
                            <th><?= __('Applicant') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Approved Date') ?></th>
                            <th><?= __('Knowing') ?></th>
                            <th><?= __('Approved Acc') ?></th>
                            <th><?= __('Approved Acc Date') ?></th>
                            <th><?= __('Desc Acc') ?></th>
                            <th><?= __('Approved Ceo') ?></th>
                            <th><?= __('Approved Ceo Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Date Now') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('Payment Last') ?></th>
                            <th><?= __('Payment Nominal') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Payment Status') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
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
                        <?php foreach ($branch->petty_cash_bank_topups as $pettyCashBankTopups) : ?>
                        <tr>
                            <td><?= h($pettyCashBankTopups->id) ?></td>
                            <td><?= h($pettyCashBankTopups->branch_id) ?></td>
                            <td><?= h($pettyCashBankTopups->acc_journal_id) ?></td>
                            <td><?= h($pettyCashBankTopups->acc_chart_of_account_bank_id) ?></td>
                            <td><?= h($pettyCashBankTopups->acc_chart_of_account_id) ?></td>
                            <td><?= h($pettyCashBankTopups->code) ?></td>
                            <td><?= h($pettyCashBankTopups->project) ?></td>
                            <td><?= h($pettyCashBankTopups->date) ?></td>
                            <td><?= h($pettyCashBankTopups->due_date) ?></td>
                            <td><?= h($pettyCashBankTopups->quantity) ?></td>
                            <td><?= h($pettyCashBankTopups->price) ?></td>
                            <td><?= h($pettyCashBankTopups->amount) ?></td>
                            <td><?= h($pettyCashBankTopups->detail_of_request) ?></td>
                            <td><?= h($pettyCashBankTopups->devision) ?></td>
                            <td><?= h($pettyCashBankTopups->purpose_of_advancing) ?></td>
                            <td><?= h($pettyCashBankTopups->applicant) ?></td>
                            <td><?= h($pettyCashBankTopups->approved) ?></td>
                            <td><?= h($pettyCashBankTopups->approved_date) ?></td>
                            <td><?= h($pettyCashBankTopups->knowing) ?></td>
                            <td><?= h($pettyCashBankTopups->approved_acc) ?></td>
                            <td><?= h($pettyCashBankTopups->approved_acc_date) ?></td>
                            <td><?= h($pettyCashBankTopups->desc_acc) ?></td>
                            <td><?= h($pettyCashBankTopups->approved_ceo) ?></td>
                            <td><?= h($pettyCashBankTopups->approved_ceo_date) ?></td>
                            <td><?= h($pettyCashBankTopups->payment) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_date) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_date_now) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_type) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_last) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_nominal) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_desc) ?></td>
                            <td><?= h($pettyCashBankTopups->payment_status) ?></td>
                            <td><?= h($pettyCashBankTopups->is_approve) ?></td>
                            <td><?= h($pettyCashBankTopups->date_approve) ?></td>
                            <td><?= h($pettyCashBankTopups->description) ?></td>
                            <td><?= h($pettyCashBankTopups->is_create) ?></td>
                            <td><?= h($pettyCashBankTopups->is_update) ?></td>
                            <td><?= h($pettyCashBankTopups->is_delete) ?></td>
                            <td><?= h($pettyCashBankTopups->created) ?></td>
                            <td><?= h($pettyCashBankTopups->modified) ?></td>
                            <td><?= h($pettyCashBankTopups->deleted) ?></td>
                            <td><?= h($pettyCashBankTopups->is_active) ?></td>
                            <td><?= h($pettyCashBankTopups->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PettyCashBankTopups', 'action' => 'view', $pettyCashBankTopups->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PettyCashBankTopups', 'action' => 'edit', $pettyCashBankTopups->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PettyCashBankTopups', 'action' => 'delete', $pettyCashBankTopups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashBankTopups->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Petty Cash Banks') ?></h4>
                <?php if (!empty($branch->petty_cash_banks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Project') ?></th>
                            <th><?= __('Types') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Paid Accepted') ?></th>
                            <th><?= __('Ref Voucher') ?></th>
                            <th><?= __('Ref Vehicle') ?></th>
                            <th><?= __('Devision') ?></th>
                            <th><?= __('Purpose Of Advancing') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Applicant') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Approved Date') ?></th>
                            <th><?= __('Knowing') ?></th>
                            <th><?= __('Approved Acc') ?></th>
                            <th><?= __('Approved Acc Date') ?></th>
                            <th><?= __('Desc Acc') ?></th>
                            <th><?= __('Approved Ceo') ?></th>
                            <th><?= __('Approved Ceo Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Date Now') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('Payment Last') ?></th>
                            <th><?= __('Payment Nominal') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Payment Status') ?></th>
                            <th><?= __('Accountability Date') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->petty_cash_banks as $pettyCashBanks) : ?>
                        <tr>
                            <td><?= h($pettyCashBanks->id) ?></td>
                            <td><?= h($pettyCashBanks->branch_id) ?></td>
                            <td><?= h($pettyCashBanks->acc_journal_id) ?></td>
                            <td><?= h($pettyCashBanks->code) ?></td>
                            <td><?= h($pettyCashBanks->project) ?></td>
                            <td><?= h($pettyCashBanks->types) ?></td>
                            <td><?= h($pettyCashBanks->date) ?></td>
                            <td><?= h($pettyCashBanks->due_date) ?></td>
                            <td><?= h($pettyCashBanks->paid_accepted) ?></td>
                            <td><?= h($pettyCashBanks->ref_voucher) ?></td>
                            <td><?= h($pettyCashBanks->ref_vehicle) ?></td>
                            <td><?= h($pettyCashBanks->devision) ?></td>
                            <td><?= h($pettyCashBanks->purpose_of_advancing) ?></td>
                            <td><?= h($pettyCashBanks->description) ?></td>
                            <td><?= h($pettyCashBanks->applicant) ?></td>
                            <td><?= h($pettyCashBanks->approved) ?></td>
                            <td><?= h($pettyCashBanks->approved_date) ?></td>
                            <td><?= h($pettyCashBanks->knowing) ?></td>
                            <td><?= h($pettyCashBanks->approved_acc) ?></td>
                            <td><?= h($pettyCashBanks->approved_acc_date) ?></td>
                            <td><?= h($pettyCashBanks->desc_acc) ?></td>
                            <td><?= h($pettyCashBanks->approved_ceo) ?></td>
                            <td><?= h($pettyCashBanks->approved_ceo_date) ?></td>
                            <td><?= h($pettyCashBanks->payment) ?></td>
                            <td><?= h($pettyCashBanks->payment_date) ?></td>
                            <td><?= h($pettyCashBanks->payment_date_now) ?></td>
                            <td><?= h($pettyCashBanks->payment_type) ?></td>
                            <td><?= h($pettyCashBanks->payment_last) ?></td>
                            <td><?= h($pettyCashBanks->payment_nominal) ?></td>
                            <td><?= h($pettyCashBanks->payment_desc) ?></td>
                            <td><?= h($pettyCashBanks->payment_status) ?></td>
                            <td><?= h($pettyCashBanks->accountability_date) ?></td>
                            <td><?= h($pettyCashBanks->is_create) ?></td>
                            <td><?= h($pettyCashBanks->created) ?></td>
                            <td><?= h($pettyCashBanks->is_update) ?></td>
                            <td><?= h($pettyCashBanks->modified) ?></td>
                            <td><?= h($pettyCashBanks->is_delete) ?></td>
                            <td><?= h($pettyCashBanks->deleted) ?></td>
                            <td><?= h($pettyCashBanks->is_active) ?></td>
                            <td><?= h($pettyCashBanks->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PettyCashBanks', 'action' => 'view', $pettyCashBanks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PettyCashBanks', 'action' => 'edit', $pettyCashBanks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PettyCashBanks', 'action' => 'delete', $pettyCashBanks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashBanks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Petty Cash Topups') ?></h4>
                <?php if (!empty($branch->petty_cash_topups)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Acc Chart Of Account Cash Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Project') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Detail Of Request') ?></th>
                            <th><?= __('Devision') ?></th>
                            <th><?= __('Purpose Of Advancing') ?></th>
                            <th><?= __('Applicant') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Approved Date') ?></th>
                            <th><?= __('Knowing') ?></th>
                            <th><?= __('Approved Acc') ?></th>
                            <th><?= __('Approved Acc Date') ?></th>
                            <th><?= __('Desc Acc') ?></th>
                            <th><?= __('Approved Ceo') ?></th>
                            <th><?= __('Approved Ceo Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Date Now') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('Payment Last') ?></th>
                            <th><?= __('Payment Nominal') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Payment Status') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
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
                        <?php foreach ($branch->petty_cash_topups as $pettyCashTopups) : ?>
                        <tr>
                            <td><?= h($pettyCashTopups->id) ?></td>
                            <td><?= h($pettyCashTopups->branch_id) ?></td>
                            <td><?= h($pettyCashTopups->acc_journal_id) ?></td>
                            <td><?= h($pettyCashTopups->acc_chart_of_account_cash_id) ?></td>
                            <td><?= h($pettyCashTopups->acc_chart_of_account_id) ?></td>
                            <td><?= h($pettyCashTopups->code) ?></td>
                            <td><?= h($pettyCashTopups->project) ?></td>
                            <td><?= h($pettyCashTopups->date) ?></td>
                            <td><?= h($pettyCashTopups->due_date) ?></td>
                            <td><?= h($pettyCashTopups->quantity) ?></td>
                            <td><?= h($pettyCashTopups->price) ?></td>
                            <td><?= h($pettyCashTopups->amount) ?></td>
                            <td><?= h($pettyCashTopups->detail_of_request) ?></td>
                            <td><?= h($pettyCashTopups->devision) ?></td>
                            <td><?= h($pettyCashTopups->purpose_of_advancing) ?></td>
                            <td><?= h($pettyCashTopups->applicant) ?></td>
                            <td><?= h($pettyCashTopups->approved) ?></td>
                            <td><?= h($pettyCashTopups->approved_date) ?></td>
                            <td><?= h($pettyCashTopups->knowing) ?></td>
                            <td><?= h($pettyCashTopups->approved_acc) ?></td>
                            <td><?= h($pettyCashTopups->approved_acc_date) ?></td>
                            <td><?= h($pettyCashTopups->desc_acc) ?></td>
                            <td><?= h($pettyCashTopups->approved_ceo) ?></td>
                            <td><?= h($pettyCashTopups->approved_ceo_date) ?></td>
                            <td><?= h($pettyCashTopups->payment) ?></td>
                            <td><?= h($pettyCashTopups->payment_date) ?></td>
                            <td><?= h($pettyCashTopups->payment_date_now) ?></td>
                            <td><?= h($pettyCashTopups->payment_type) ?></td>
                            <td><?= h($pettyCashTopups->payment_last) ?></td>
                            <td><?= h($pettyCashTopups->payment_nominal) ?></td>
                            <td><?= h($pettyCashTopups->payment_desc) ?></td>
                            <td><?= h($pettyCashTopups->payment_status) ?></td>
                            <td><?= h($pettyCashTopups->is_approve) ?></td>
                            <td><?= h($pettyCashTopups->date_approve) ?></td>
                            <td><?= h($pettyCashTopups->description) ?></td>
                            <td><?= h($pettyCashTopups->is_create) ?></td>
                            <td><?= h($pettyCashTopups->is_update) ?></td>
                            <td><?= h($pettyCashTopups->is_delete) ?></td>
                            <td><?= h($pettyCashTopups->created) ?></td>
                            <td><?= h($pettyCashTopups->modified) ?></td>
                            <td><?= h($pettyCashTopups->deleted) ?></td>
                            <td><?= h($pettyCashTopups->is_active) ?></td>
                            <td><?= h($pettyCashTopups->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PettyCashTopups', 'action' => 'view', $pettyCashTopups->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PettyCashTopups', 'action' => 'edit', $pettyCashTopups->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PettyCashTopups', 'action' => 'delete', $pettyCashTopups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashTopups->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Petty Cashes') ?></h4>
                <?php if (!empty($branch->petty_cashes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Project') ?></th>
                            <th><?= __('Types') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Due Date') ?></th>
                            <th><?= __('Paid Accepted') ?></th>
                            <th><?= __('Ref Voucher') ?></th>
                            <th><?= __('Ref Vehicle') ?></th>
                            <th><?= __('Devision') ?></th>
                            <th><?= __('Purpose Of Advancing') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Applicant') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Approved Date') ?></th>
                            <th><?= __('Knowing') ?></th>
                            <th><?= __('Approved Acc') ?></th>
                            <th><?= __('Approved Acc Date') ?></th>
                            <th><?= __('Desc Acc') ?></th>
                            <th><?= __('Approved Ceo') ?></th>
                            <th><?= __('Approved Ceo Date') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Payment Date Now') ?></th>
                            <th><?= __('Payment Type') ?></th>
                            <th><?= __('Payment Last') ?></th>
                            <th><?= __('Payment Nominal') ?></th>
                            <th><?= __('Payment Desc') ?></th>
                            <th><?= __('Payment Status') ?></th>
                            <th><?= __('Accountability Date') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->petty_cashes as $pettyCashes) : ?>
                        <tr>
                            <td><?= h($pettyCashes->id) ?></td>
                            <td><?= h($pettyCashes->branch_id) ?></td>
                            <td><?= h($pettyCashes->acc_journal_id) ?></td>
                            <td><?= h($pettyCashes->code) ?></td>
                            <td><?= h($pettyCashes->project) ?></td>
                            <td><?= h($pettyCashes->types) ?></td>
                            <td><?= h($pettyCashes->date) ?></td>
                            <td><?= h($pettyCashes->due_date) ?></td>
                            <td><?= h($pettyCashes->paid_accepted) ?></td>
                            <td><?= h($pettyCashes->ref_voucher) ?></td>
                            <td><?= h($pettyCashes->ref_vehicle) ?></td>
                            <td><?= h($pettyCashes->devision) ?></td>
                            <td><?= h($pettyCashes->purpose_of_advancing) ?></td>
                            <td><?= h($pettyCashes->description) ?></td>
                            <td><?= h($pettyCashes->applicant) ?></td>
                            <td><?= h($pettyCashes->approved) ?></td>
                            <td><?= h($pettyCashes->approved_date) ?></td>
                            <td><?= h($pettyCashes->knowing) ?></td>
                            <td><?= h($pettyCashes->approved_acc) ?></td>
                            <td><?= h($pettyCashes->approved_acc_date) ?></td>
                            <td><?= h($pettyCashes->desc_acc) ?></td>
                            <td><?= h($pettyCashes->approved_ceo) ?></td>
                            <td><?= h($pettyCashes->approved_ceo_date) ?></td>
                            <td><?= h($pettyCashes->payment) ?></td>
                            <td><?= h($pettyCashes->payment_date) ?></td>
                            <td><?= h($pettyCashes->payment_date_now) ?></td>
                            <td><?= h($pettyCashes->payment_type) ?></td>
                            <td><?= h($pettyCashes->payment_last) ?></td>
                            <td><?= h($pettyCashes->payment_nominal) ?></td>
                            <td><?= h($pettyCashes->payment_desc) ?></td>
                            <td><?= h($pettyCashes->payment_status) ?></td>
                            <td><?= h($pettyCashes->accountability_date) ?></td>
                            <td><?= h($pettyCashes->is_create) ?></td>
                            <td><?= h($pettyCashes->created) ?></td>
                            <td><?= h($pettyCashes->is_update) ?></td>
                            <td><?= h($pettyCashes->modified) ?></td>
                            <td><?= h($pettyCashes->is_delete) ?></td>
                            <td><?= h($pettyCashes->deleted) ?></td>
                            <td><?= h($pettyCashes->is_active) ?></td>
                            <td><?= h($pettyCashes->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PettyCashes', 'action' => 'view', $pettyCashes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PettyCashes', 'action' => 'edit', $pettyCashes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PettyCashes', 'action' => 'delete', $pettyCashes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pettyCashes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Processor Prices') ?></h4>
                <?php if (!empty($branch->processor_prices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Processor Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Cost Of Sales') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
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
                        <?php foreach ($branch->processor_prices as $processorPrices) : ?>
                        <tr>
                            <td><?= h($processorPrices->id) ?></td>
                            <td><?= h($processorPrices->branch_id) ?></td>
                            <td><?= h($processorPrices->processor_id) ?></td>
                            <td><?= h($processorPrices->waste_type_id) ?></td>
                            <td><?= h($processorPrices->date) ?></td>
                            <td><?= h($processorPrices->cost_of_sales) ?></td>
                            <td><?= h($processorPrices->is_approve) ?></td>
                            <td><?= h($processorPrices->date_approve) ?></td>
                            <td><?= h($processorPrices->description) ?></td>
                            <td><?= h($processorPrices->is_create) ?></td>
                            <td><?= h($processorPrices->is_update) ?></td>
                            <td><?= h($processorPrices->is_delete) ?></td>
                            <td><?= h($processorPrices->created) ?></td>
                            <td><?= h($processorPrices->modified) ?></td>
                            <td><?= h($processorPrices->deleted) ?></td>
                            <td><?= h($processorPrices->is_active) ?></td>
                            <td><?= h($processorPrices->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProcessorPrices', 'action' => 'view', $processorPrices->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProcessorPrices', 'action' => 'edit', $processorPrices->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProcessorPrices', 'action' => 'delete', $processorPrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $processorPrices->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Processors') ?></h4>
                <?php if (!empty($branch->processors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Marketing Id') ?></th>
                            <th><?= __('Data Invoice Id') ?></th>
                            <th><?= __('Data Tax Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Treatment') ?></th>
                            <th><?= __('Address Penghasil') ?></th>
                            <th><?= __('Supplier') ?></th>
                            <th><?= __('Address Supplier') ?></th>
                            <th><?= __('Phone Supplier') ?></th>
                            <th><?= __('Fax Supplier') ?></th>
                            <th><?= __('Name Invoice') ?></th>
                            <th><?= __('Address Invoice') ?></th>
                            <th><?= __('Phone Invoice') ?></th>
                            <th><?= __('Fax Invoice') ?></th>
                            <th><?= __('Name Tax Invoice') ?></th>
                            <th><?= __('Address Tax Invoice') ?></th>
                            <th><?= __('Phone Tax Invoice') ?></th>
                            <th><?= __('Fax Tax Invoice') ?></th>
                            <th><?= __('Npwp') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('System') ?></th>
                            <th><?= __('Default') ?></th>
                            <th><?= __('Website') ?></th>
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
                        <?php foreach ($branch->processors as $processors) : ?>
                        <tr>
                            <td><?= h($processors->id) ?></td>
                            <td><?= h($processors->branch_id) ?></td>
                            <td><?= h($processors->code) ?></td>
                            <td><?= h($processors->marketing_id) ?></td>
                            <td><?= h($processors->data_invoice_id) ?></td>
                            <td><?= h($processors->data_tax_id) ?></td>
                            <td><?= h($processors->name) ?></td>
                            <td><?= h($processors->group) ?></td>
                            <td><?= h($processors->treatment) ?></td>
                            <td><?= h($processors->address_penghasil) ?></td>
                            <td><?= h($processors->supplier) ?></td>
                            <td><?= h($processors->address_supplier) ?></td>
                            <td><?= h($processors->phone_supplier) ?></td>
                            <td><?= h($processors->fax_supplier) ?></td>
                            <td><?= h($processors->name_invoice) ?></td>
                            <td><?= h($processors->address_invoice) ?></td>
                            <td><?= h($processors->phone_invoice) ?></td>
                            <td><?= h($processors->fax_invoice) ?></td>
                            <td><?= h($processors->name_tax_invoice) ?></td>
                            <td><?= h($processors->address_tax_invoice) ?></td>
                            <td><?= h($processors->phone_tax_invoice) ?></td>
                            <td><?= h($processors->fax_tax_invoice) ?></td>
                            <td><?= h($processors->npwp) ?></td>
                            <td><?= h($processors->tax) ?></td>
                            <td><?= h($processors->city) ?></td>
                            <td><?= h($processors->province) ?></td>
                            <td><?= h($processors->postal) ?></td>
                            <td><?= h($processors->country) ?></td>
                            <td><?= h($processors->phone) ?></td>
                            <td><?= h($processors->email) ?></td>
                            <td><?= h($processors->system) ?></td>
                            <td><?= h($processors->default) ?></td>
                            <td><?= h($processors->website) ?></td>
                            <td><?= h($processors->is_create) ?></td>
                            <td><?= h($processors->created) ?></td>
                            <td><?= h($processors->is_update) ?></td>
                            <td><?= h($processors->modified) ?></td>
                            <td><?= h($processors->is_delete) ?></td>
                            <td><?= h($processors->deleted) ?></td>
                            <td><?= h($processors->is_active) ?></td>
                            <td><?= h($processors->is_log) ?></td>
                            <td><?= h($processors->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Processors', 'action' => 'view', $processors->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Processors', 'action' => 'edit', $processors->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Processors', 'action' => 'delete', $processors->id], ['confirm' => __('Are you sure you want to delete # {0}?', $processors->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Projects') ?></h4>
                <?php if (!empty($branch->projects)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Date') ?></th>
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
                        <?php foreach ($branch->projects as $projects) : ?>
                        <tr>
                            <td><?= h($projects->id) ?></td>
                            <td><?= h($projects->branch_id) ?></td>
                            <td><?= h($projects->code) ?></td>
                            <td><?= h($projects->date) ?></td>
                            <td><?= h($projects->is_create) ?></td>
                            <td><?= h($projects->created) ?></td>
                            <td><?= h($projects->is_update) ?></td>
                            <td><?= h($projects->modified) ?></td>
                            <td><?= h($projects->is_delete) ?></td>
                            <td><?= h($projects->deleted) ?></td>
                            <td><?= h($projects->is_active) ?></td>
                            <td><?= h($projects->is_log) ?></td>
                            <td><?= h($projects->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Recipient Payers') ?></h4>
                <?php if (!empty($branch->recipient_payers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->recipient_payers as $recipientPayers) : ?>
                        <tr>
                            <td><?= h($recipientPayers->id) ?></td>
                            <td><?= h($recipientPayers->branch_id) ?></td>
                            <td><?= h($recipientPayers->code) ?></td>
                            <td><?= h($recipientPayers->name) ?></td>
                            <td><?= h($recipientPayers->status) ?></td>
                            <td><?= h($recipientPayers->position) ?></td>
                            <td><?= h($recipientPayers->is_active) ?></td>
                            <td><?= h($recipientPayers->is_log) ?></td>
                            <td><?= h($recipientPayers->is_create) ?></td>
                            <td><?= h($recipientPayers->created) ?></td>
                            <td><?= h($recipientPayers->is_update) ?></td>
                            <td><?= h($recipientPayers->modified) ?></td>
                            <td><?= h($recipientPayers->is_delete) ?></td>
                            <td><?= h($recipientPayers->deleted) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'RecipientPayers', 'action' => 'view', $recipientPayers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'RecipientPayers', 'action' => 'edit', $recipientPayers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'RecipientPayers', 'action' => 'delete', $recipientPayers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipientPayers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Settings') ?></h4>
                <?php if (!empty($branch->settings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Company Name') ?></th>
                            <th><?= __('Company Address') ?></th>
                            <th><?= __('Business Fields') ?></th>
                            <th><?= __('Company Telp') ?></th>
                            <th><?= __('Company Fax') ?></th>
                            <th><?= __('Company Npwp') ?></th>
                            <th><?= __('Company Director') ?></th>
                            <th><?= __('Company Director 1') ?></th>
                            <th><?= __('Company Director 2') ?></th>
                            <th><?= __('Manifest Number') ?></th>
                            <th><?= __('Invoice Number') ?></th>
                            <th><?= __('Invoice Number Include') ?></th>
                            <th><?= __('Faktur Pajak Number') ?></th>
                            <th><?= __('Berita Acara Number') ?></th>
                            <th><?= __('Permit Number') ?></th>
                            <th><?= __('Bapedal Registration') ?></th>
                            <th><?= __('Vehicle Identity') ?></th>
                            <th><?= __('Shipping Permit') ?></th>
                            <th><?= __('Offer Number') ?></th>
                            <th><?= __('Offer Year') ?></th>
                            <th><?= __('Bank') ?></th>
                            <th><?= __('Norek') ?></th>
                            <th><?= __('An') ?></th>
                            <th><?= __('Bank Name 1') ?></th>
                            <th><?= __('Bank Norek 1') ?></th>
                            <th><?= __('Bank An 1') ?></th>
                            <th><?= __('Bank Name 2') ?></th>
                            <th><?= __('Bank Norek 2') ?></th>
                            <th><?= __('Bank An 2') ?></th>
                            <th><?= __('Bank Name 3') ?></th>
                            <th><?= __('Bank Norek 3') ?></th>
                            <th><?= __('Bank An 3') ?></th>
                            <th><?= __('Bank Name 4') ?></th>
                            <th><?= __('Bank Norek 4') ?></th>
                            <th><?= __('Bank An 4') ?></th>
                            <th><?= __('Bank Name 5') ?></th>
                            <th><?= __('Bank Norek 5') ?></th>
                            <th><?= __('Bank An 5') ?></th>
                            <th><?= __('Offer Perihal') ?></th>
                            <th><?= __('Offer Description') ?></th>
                            <th><?= __('Offer Info') ?></th>
                            <th><?= __('Acc Start Date') ?></th>
                            <th><?= __('Acc Year Fiscal') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->settings as $settings) : ?>
                        <tr>
                            <td><?= h($settings->id) ?></td>
                            <td><?= h($settings->branch_id) ?></td>
                            <td><?= h($settings->company_name) ?></td>
                            <td><?= h($settings->company_address) ?></td>
                            <td><?= h($settings->business_fields) ?></td>
                            <td><?= h($settings->company_telp) ?></td>
                            <td><?= h($settings->company_fax) ?></td>
                            <td><?= h($settings->company_npwp) ?></td>
                            <td><?= h($settings->company_director) ?></td>
                            <td><?= h($settings->company_director_1) ?></td>
                            <td><?= h($settings->company_director_2) ?></td>
                            <td><?= h($settings->manifest_number) ?></td>
                            <td><?= h($settings->invoice_number) ?></td>
                            <td><?= h($settings->invoice_number_include) ?></td>
                            <td><?= h($settings->faktur_pajak_number) ?></td>
                            <td><?= h($settings->berita_acara_number) ?></td>
                            <td><?= h($settings->permit_number) ?></td>
                            <td><?= h($settings->bapedal_registration) ?></td>
                            <td><?= h($settings->vehicle_identity) ?></td>
                            <td><?= h($settings->shipping_permit) ?></td>
                            <td><?= h($settings->offer_number) ?></td>
                            <td><?= h($settings->offer_year) ?></td>
                            <td><?= h($settings->bank) ?></td>
                            <td><?= h($settings->norek) ?></td>
                            <td><?= h($settings->an) ?></td>
                            <td><?= h($settings->bank_name_1) ?></td>
                            <td><?= h($settings->bank_norek_1) ?></td>
                            <td><?= h($settings->bank_an_1) ?></td>
                            <td><?= h($settings->bank_name_2) ?></td>
                            <td><?= h($settings->bank_norek_2) ?></td>
                            <td><?= h($settings->bank_an_2) ?></td>
                            <td><?= h($settings->bank_name_3) ?></td>
                            <td><?= h($settings->bank_norek_3) ?></td>
                            <td><?= h($settings->bank_an_3) ?></td>
                            <td><?= h($settings->bank_name_4) ?></td>
                            <td><?= h($settings->bank_norek_4) ?></td>
                            <td><?= h($settings->bank_an_4) ?></td>
                            <td><?= h($settings->bank_name_5) ?></td>
                            <td><?= h($settings->bank_norek_5) ?></td>
                            <td><?= h($settings->bank_an_5) ?></td>
                            <td><?= h($settings->offer_perihal) ?></td>
                            <td><?= h($settings->offer_description) ?></td>
                            <td><?= h($settings->offer_info) ?></td>
                            <td><?= h($settings->acc_start_date) ?></td>
                            <td><?= h($settings->acc_year_fiscal) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Settings', 'action' => 'view', $settings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Settings', 'action' => 'edit', $settings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Settings', 'action' => 'delete', $settings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $settings->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Templates') ?></h4>
                <?php if (!empty($branch->templates)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is View') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->templates as $templates) : ?>
                        <tr>
                            <td><?= h($templates->id) ?></td>
                            <td><?= h($templates->branch_id) ?></td>
                            <td><?= h($templates->name) ?></td>
                            <td><?= h($templates->description) ?></td>
                            <td><?= h($templates->is_view) ?></td>
                            <td><?= h($templates->is_active) ?></td>
                            <td><?= h($templates->is_log) ?></td>
                            <td><?= h($templates->is_create) ?></td>
                            <td><?= h($templates->created) ?></td>
                            <td><?= h($templates->is_update) ?></td>
                            <td><?= h($templates->modified) ?></td>
                            <td><?= h($templates->is_delete) ?></td>
                            <td><?= h($templates->deleted) ?></td>
                            <td><?= h($templates->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Templates', 'action' => 'view', $templates->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Templates', 'action' => 'edit', $templates->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Templates', 'action' => 'delete', $templates->id], ['confirm' => __('Are you sure you want to delete # {0}?', $templates->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Transporter Prices') ?></h4>
                <?php if (!empty($branch->transporter_prices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Transporter Id') ?></th>
                            <th><?= __('Waste Type Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Cost Of Sales') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
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
                        <?php foreach ($branch->transporter_prices as $transporterPrices) : ?>
                        <tr>
                            <td><?= h($transporterPrices->id) ?></td>
                            <td><?= h($transporterPrices->branch_id) ?></td>
                            <td><?= h($transporterPrices->transporter_id) ?></td>
                            <td><?= h($transporterPrices->waste_type_id) ?></td>
                            <td><?= h($transporterPrices->date) ?></td>
                            <td><?= h($transporterPrices->cost_of_sales) ?></td>
                            <td><?= h($transporterPrices->is_approve) ?></td>
                            <td><?= h($transporterPrices->date_approve) ?></td>
                            <td><?= h($transporterPrices->description) ?></td>
                            <td><?= h($transporterPrices->is_create) ?></td>
                            <td><?= h($transporterPrices->is_update) ?></td>
                            <td><?= h($transporterPrices->is_delete) ?></td>
                            <td><?= h($transporterPrices->created) ?></td>
                            <td><?= h($transporterPrices->modified) ?></td>
                            <td><?= h($transporterPrices->deleted) ?></td>
                            <td><?= h($transporterPrices->is_active) ?></td>
                            <td><?= h($transporterPrices->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TransporterPrices', 'action' => 'view', $transporterPrices->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TransporterPrices', 'action' => 'edit', $transporterPrices->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TransporterPrices', 'action' => 'delete', $transporterPrices->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transporterPrices->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Truck Inspections') ?></h4>
                <?php if (!empty($branch->truck_inspections)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Truck Id') ?></th>
                            <th><?= __('Driver Id') ?></th>
                            <th><?= __('Km') ?></th>
                            <th><?= __('Date Stnk') ?></th>
                            <th><?= __('Date Kir') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Proposional Item') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->truck_inspections as $truckInspections) : ?>
                        <tr>
                            <td><?= h($truckInspections->id) ?></td>
                            <td><?= h($truckInspections->branch_id) ?></td>
                            <td><?= h($truckInspections->truck_id) ?></td>
                            <td><?= h($truckInspections->driver_id) ?></td>
                            <td><?= h($truckInspections->km) ?></td>
                            <td><?= h($truckInspections->date_stnk) ?></td>
                            <td><?= h($truckInspections->date_kir) ?></td>
                            <td><?= h($truckInspections->date) ?></td>
                            <td><?= h($truckInspections->proposional_item) ?></td>
                            <td><?= h($truckInspections->description) ?></td>
                            <td><?= h($truckInspections->is_create) ?></td>
                            <td><?= h($truckInspections->created) ?></td>
                            <td><?= h($truckInspections->is_update) ?></td>
                            <td><?= h($truckInspections->modified) ?></td>
                            <td><?= h($truckInspections->is_delete) ?></td>
                            <td><?= h($truckInspections->deleted) ?></td>
                            <td><?= h($truckInspections->is_active) ?></td>
                            <td><?= h($truckInspections->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TruckInspections', 'action' => 'view', $truckInspections->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TruckInspections', 'action' => 'edit', $truckInspections->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TruckInspections', 'action' => 'delete', $truckInspections->id], ['confirm' => __('Are you sure you want to delete # {0}?', $truckInspections->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Truck Schedules') ?></h4>
                <?php if (!empty($branch->truck_schedules)) : ?>
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
                        <?php foreach ($branch->truck_schedules as $truckSchedules) : ?>
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
                <h4><?= __('Related Trucks') ?></h4>
                <?php if (!empty($branch->trucks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Manifest Code') ?></th>
                            <th><?= __('Bapedal Registration') ?></th>
                            <th><?= __('Vehicle Identity') ?></th>
                            <th><?= __('Shipping Permit') ?></th>
                            <th><?= __('Vessel') ?></th>
                            <th><?= __('Rent Cost') ?></th>
                            <th><?= __('Phone1') ?></th>
                            <th><?= __('Phone2') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('View') ?></th>
                            <th><?= __('Is View') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->trucks as $trucks) : ?>
                        <tr>
                            <td><?= h($trucks->id) ?></td>
                            <td><?= h($trucks->branch_id) ?></td>
                            <td><?= h($trucks->name) ?></td>
                            <td><?= h($trucks->manifest_code) ?></td>
                            <td><?= h($trucks->bapedal_registration) ?></td>
                            <td><?= h($trucks->vehicle_identity) ?></td>
                            <td><?= h($trucks->shipping_permit) ?></td>
                            <td><?= h($trucks->vessel) ?></td>
                            <td><?= h($trucks->rent_cost) ?></td>
                            <td><?= h($trucks->phone1) ?></td>
                            <td><?= h($trucks->phone2) ?></td>
                            <td><?= h($trucks->phone3) ?></td>
                            <td><?= h($trucks->type) ?></td>
                            <td><?= h($trucks->group) ?></td>
                            <td><?= h($trucks->view) ?></td>
                            <td><?= h($trucks->is_view) ?></td>
                            <td><?= h($trucks->is_active) ?></td>
                            <td><?= h($trucks->is_log) ?></td>
                            <td><?= h($trucks->is_create) ?></td>
                            <td><?= h($trucks->is_update) ?></td>
                            <td><?= h($trucks->is_delete) ?></td>
                            <td><?= h($trucks->deleted) ?></td>
                            <td><?= h($trucks->who_create) ?></td>
                            <td><?= h($trucks->created) ?></td>
                            <td><?= h($trucks->who_update) ?></td>
                            <td><?= h($trucks->modified) ?></td>
                            <td><?= h($trucks->active) ?></td>
                            <td><?= h($trucks->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Trucks', 'action' => 'view', $trucks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Trucks', 'action' => 'edit', $trucks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Trucks', 'action' => 'delete', $trucks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trucks->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Trucks Ori') ?></h4>
                <?php if (!empty($branch->trucks_ori)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Bapedal Registration') ?></th>
                            <th><?= __('Vehicle Identity') ?></th>
                            <th><?= __('Shipping Permit') ?></th>
                            <th><?= __('Rent Cost') ?></th>
                            <th><?= __('Phone1') ?></th>
                            <th><?= __('Phone2') ?></th>
                            <th><?= __('Phone3') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('View') ?></th>
                            <th><?= __('Is View') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->trucks_ori as $trucksOri) : ?>
                        <tr>
                            <td><?= h($trucksOri->id) ?></td>
                            <td><?= h($trucksOri->branch_id) ?></td>
                            <td><?= h($trucksOri->name) ?></td>
                            <td><?= h($trucksOri->bapedal_registration) ?></td>
                            <td><?= h($trucksOri->vehicle_identity) ?></td>
                            <td><?= h($trucksOri->shipping_permit) ?></td>
                            <td><?= h($trucksOri->rent_cost) ?></td>
                            <td><?= h($trucksOri->phone1) ?></td>
                            <td><?= h($trucksOri->phone2) ?></td>
                            <td><?= h($trucksOri->phone3) ?></td>
                            <td><?= h($trucksOri->type) ?></td>
                            <td><?= h($trucksOri->group) ?></td>
                            <td><?= h($trucksOri->view) ?></td>
                            <td><?= h($trucksOri->is_view) ?></td>
                            <td><?= h($trucksOri->is_active) ?></td>
                            <td><?= h($trucksOri->is_create) ?></td>
                            <td><?= h($trucksOri->is_update) ?></td>
                            <td><?= h($trucksOri->is_delete) ?></td>
                            <td><?= h($trucksOri->deleted) ?></td>
                            <td><?= h($trucksOri->who_create) ?></td>
                            <td><?= h($trucksOri->created) ?></td>
                            <td><?= h($trucksOri->who_update) ?></td>
                            <td><?= h($trucksOri->modified) ?></td>
                            <td><?= h($trucksOri->active) ?></td>
                            <td><?= h($trucksOri->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TrucksOri', 'action' => 'view', $trucksOri->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TrucksOri', 'action' => 'edit', $trucksOri->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TrucksOri', 'action' => 'delete', $trucksOri->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trucksOri->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Unidentified Incomes') ?></h4>
                <?php if (!empty($branch->unidentified_incomes)) : ?>
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
                        <?php foreach ($branch->unidentified_incomes as $unidentifiedIncomes) : ?>
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
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($branch->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Staff') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Password R') ?></th>
                            <th><?= __('Password New') ?></th>
                            <th><?= __('Help Hint Pwd') ?></th>
                            <th><?= __('Telp') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Devision') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Marketing Code') ?></th>
                            <th><?= __('Approved') ?></th>
                            <th><?= __('Approved Acc') ?></th>
                            <th><?= __('Approved Ceo') ?></th>
                            <th><?= __('Payment') ?></th>
                            <th><?= __('Pettycash Full Access') ?></th>
                            <th><?= __('Hris Approved') ?></th>
                            <th><?= __('Hris Knowing') ?></th>
                            <th><?= __('Hris Full Access') ?></th>
                            <th><?= __('Rule') ?></th>
                            <th><?= __('Rules') ?></th>
                            <th><?= __('Rules Acc') ?></th>
                            <th><?= __('Rule Acc') ?></th>
                            <th><?= __('Jurnal Type Acc') ?></th>
                            <th><?= __('Change Password') ?></th>
                            <th><?= __('Change Password Date') ?></th>
                            <th><?= __('Reset') ?></th>
                            <th><?= __('Reset Date') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Who Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Who Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Last Login') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Visited') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($branch->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->branch_id) ?></td>
                            <td><?= h($users->code) ?></td>
                            <td><?= h($users->staff) ?></td>
                            <td><?= h($users->name) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->password_r) ?></td>
                            <td><?= h($users->password_new) ?></td>
                            <td><?= h($users->help_hint_pwd) ?></td>
                            <td><?= h($users->telp) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->devision) ?></td>
                            <td><?= h($users->position) ?></td>
                            <td><?= h($users->marketing_code) ?></td>
                            <td><?= h($users->approved) ?></td>
                            <td><?= h($users->approved_acc) ?></td>
                            <td><?= h($users->approved_ceo) ?></td>
                            <td><?= h($users->payment) ?></td>
                            <td><?= h($users->pettycash_full_access) ?></td>
                            <td><?= h($users->hris_approved) ?></td>
                            <td><?= h($users->hris_knowing) ?></td>
                            <td><?= h($users->hris_full_access) ?></td>
                            <td><?= h($users->rule) ?></td>
                            <td><?= h($users->rules) ?></td>
                            <td><?= h($users->rules_acc) ?></td>
                            <td><?= h($users->rule_acc) ?></td>
                            <td><?= h($users->jurnal_type_acc) ?></td>
                            <td><?= h($users->change_password) ?></td>
                            <td><?= h($users->change_password_date) ?></td>
                            <td><?= h($users->reset) ?></td>
                            <td><?= h($users->reset_date) ?></td>
                            <td><?= h($users->is_create) ?></td>
                            <td><?= h($users->is_update) ?></td>
                            <td><?= h($users->is_delete) ?></td>
                            <td><?= h($users->deleted) ?></td>
                            <td><?= h($users->is_active) ?></td>
                            <td><?= h($users->is_log) ?></td>
                            <td><?= h($users->who_create) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->who_update) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td><?= h($users->last_login) ?></td>
                            <td><?= h($users->status) ?></td>
                            <td><?= h($users->level) ?></td>
                            <td><?= h($users->visited) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Waste Prices') ?></h4>
                <?php if (!empty($branch->waste_prices)) : ?>
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
                        <?php foreach ($branch->waste_prices as $wastePrices) : ?>
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
                <h4><?= __('Related Waste Types') ?></h4>
                <?php if (!empty($branch->waste_types)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Is Approve') ?></th>
                            <th><?= __('Date Approve') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Class') ?></th>
                            <th><?= __('Hazardous Code') ?></th>
                            <th><?= __('Unna Code') ?></th>
                            <th><?= __('Packing Group') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Cost Of Sales') ?></th>
                            <th><?= __('Unit') ?></th>
                            <th><?= __('Paket Desc') ?></th>
                            <th><?= __('Is Show') ?></th>
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
                        <?php foreach ($branch->waste_types as $wasteTypes) : ?>
                        <tr>
                            <td><?= h($wasteTypes->id) ?></td>
                            <td><?= h($wasteTypes->branch_id) ?></td>
                            <td><?= h($wasteTypes->code) ?></td>
                            <td><?= h($wasteTypes->name) ?></td>
                            <td><?= h($wasteTypes->is_approve) ?></td>
                            <td><?= h($wasteTypes->date_approve) ?></td>
                            <td><?= h($wasteTypes->type) ?></td>
                            <td><?= h($wasteTypes->class) ?></td>
                            <td><?= h($wasteTypes->hazardous_code) ?></td>
                            <td><?= h($wasteTypes->unna_code) ?></td>
                            <td><?= h($wasteTypes->packing_group) ?></td>
                            <td><?= h($wasteTypes->price) ?></td>
                            <td><?= h($wasteTypes->cost_of_sales) ?></td>
                            <td><?= h($wasteTypes->unit) ?></td>
                            <td><?= h($wasteTypes->paket_desc) ?></td>
                            <td><?= h($wasteTypes->is_show) ?></td>
                            <td><?= h($wasteTypes->is_active) ?></td>
                            <td><?= h($wasteTypes->is_log) ?></td>
                            <td><?= h($wasteTypes->is_create) ?></td>
                            <td><?= h($wasteTypes->is_update) ?></td>
                            <td><?= h($wasteTypes->who_create) ?></td>
                            <td><?= h($wasteTypes->created) ?></td>
                            <td><?= h($wasteTypes->who_update) ?></td>
                            <td><?= h($wasteTypes->modified) ?></td>
                            <td><?= h($wasteTypes->active) ?></td>
                            <td><?= h($wasteTypes->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'WasteTypes', 'action' => 'view', $wasteTypes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'WasteTypes', 'action' => 'edit', $wasteTypes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'WasteTypes', 'action' => 'delete', $wasteTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wasteTypes->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Wastes') ?></h4>
                <?php if (!empty($branch->wastes)) : ?>
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
                        <?php foreach ($branch->wastes as $wastes) : ?>
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
