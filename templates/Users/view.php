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
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $user->has('branch') ? $this->Html->link($user->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $user->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($user->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Staff') ?></th>
                    <td><?= h($user->staff) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password') ?></th>
                    <td><?= h($user->password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Help Hint Pwd') ?></th>
                    <td><?= h($user->help_hint_pwd) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telp') ?></th>
                    <td><?= h($user->telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Devision') ?></th>
                    <td><?= h($user->devision) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= h($user->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Marketing Code') ?></th>
                    <td><?= h($user->marketing_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= h($user->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved Ceo') ?></th>
                    <td><?= h($user->approved_ceo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment') ?></th>
                    <td><?= h($user->payment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pettycash Full Access') ?></th>
                    <td><?= h($user->pettycash_full_access) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hris Approved') ?></th>
                    <td><?= h($user->hris_approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hris Knowing') ?></th>
                    <td><?= h($user->hris_knowing) ?></td>
                </tr>
                <tr>
                    <th><?= __('Hris Full Access') ?></th>
                    <td><?= h($user->hris_full_access) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jurnal Type Acc') ?></th>
                    <td><?= h($user->jurnal_type_acc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Change Password') ?></th>
                    <td><?= h($user->change_password) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($user->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($user->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($user->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($user->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Who Create') ?></th>
                    <td><?= h($user->who_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Who Update') ?></th>
                    <td><?= h($user->who_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($user->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= h($user->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reset') ?></th>
                    <td><?= $this->Number->format($user->reset) ?></td>
                </tr>
                <tr>
                    <th><?= __('Visited') ?></th>
                    <td><?= $this->Number->format($user->visited) ?></td>
                </tr>
                <tr>
                    <th><?= __('Change Password Date') ?></th>
                    <td><?= h($user->change_password_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reset Date') ?></th>
                    <td><?= h($user->reset_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($user->deleted) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Login') ?></th>
                    <td><?= h($user->last_login) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Rule') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->rule)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Rules') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->rules)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Rule Acc') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->rule_acc)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($user->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Creditors') ?></h4>
                <?php if (!empty($user->creditors)) : ?>
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
                        <?php foreach ($user->creditors as $creditors) : ?>
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
                <?php if (!empty($user->customers)) : ?>
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
                            <th><?= __('Tax') ?></th>
                            <th><?= __('Pph') ?></th>
                            <th><?= __('Va') ?></th>
                            <th><?= __('Treatment') ?></th>
                            <th><?= __('Contact Person') ?></th>
                            <th><?= __('Dept Person') ?></th>
                            <th><?= __('Telp Person') ?></th>
                            <th><?= __('Warehouse Address') ?></th>
                            <th><?= __('Warehouse Telp') ?></th>
                            <th><?= __('Address') ?></th>
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
                        <?php foreach ($user->customers as $customers) : ?>
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
                            <td><?= h($customers->tax) ?></td>
                            <td><?= h($customers->pph) ?></td>
                            <td><?= h($customers->va) ?></td>
                            <td><?= h($customers->treatment) ?></td>
                            <td><?= h($customers->contact_person) ?></td>
                            <td><?= h($customers->dept_person) ?></td>
                            <td><?= h($customers->telp_person) ?></td>
                            <td><?= h($customers->warehouse_address) ?></td>
                            <td><?= h($customers->warehouse_telp) ?></td>
                            <td><?= h($customers->address) ?></td>
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
                                <?= $this->Html->link(__('View'), ['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Customers Ori') ?></h4>
                <?php if (!empty($user->customers_ori)) : ?>
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
                        <?php foreach ($user->customers_ori as $customersOri) : ?>
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
                <h4><?= __('Related Logs') ?></h4>
                <?php if (!empty($user->logs)) : ?>
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
                        <?php foreach ($user->logs as $logs) : ?>
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
                <h4><?= __('Related Suppliers') ?></h4>
                <?php if (!empty($user->suppliers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Npwp') ?></th>
                            <th><?= __('Ppn') ?></th>
                            <th><?= __('Tax') ?></th>
                            <th><?= __('City') ?></th>
                            <th><?= __('Province') ?></th>
                            <th><?= __('District') ?></th>
                            <th><?= __('Postal') ?></th>
                            <th><?= __('Country') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Fax') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Kesling Price') ?></th>
                            <th><?= __('Name Invoice') ?></th>
                            <th><?= __('Address Invoice') ?></th>
                            <th><?= __('Phone Invoice') ?></th>
                            <th><?= __('Fax Invoice') ?></th>
                            <th><?= __('Name Tax Invoice') ?></th>
                            <th><?= __('Address Tax Invoice') ?></th>
                            <th><?= __('Phone Tax Invoice') ?></th>
                            <th><?= __('Fax Tax Invoice') ?></th>
                            <th><?= __('System') ?></th>
                            <th><?= __('Website') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($user->suppliers as $suppliers) : ?>
                        <tr>
                            <td><?= h($suppliers->id) ?></td>
                            <td><?= h($suppliers->code) ?></td>
                            <td><?= h($suppliers->user_id) ?></td>
                            <td><?= h($suppliers->name) ?></td>
                            <td><?= h($suppliers->address) ?></td>
                            <td><?= h($suppliers->npwp) ?></td>
                            <td><?= h($suppliers->ppn) ?></td>
                            <td><?= h($suppliers->tax) ?></td>
                            <td><?= h($suppliers->city) ?></td>
                            <td><?= h($suppliers->province) ?></td>
                            <td><?= h($suppliers->district) ?></td>
                            <td><?= h($suppliers->postal) ?></td>
                            <td><?= h($suppliers->country) ?></td>
                            <td><?= h($suppliers->phone) ?></td>
                            <td><?= h($suppliers->fax) ?></td>
                            <td><?= h($suppliers->email) ?></td>
                            <td><?= h($suppliers->kesling_price) ?></td>
                            <td><?= h($suppliers->name_invoice) ?></td>
                            <td><?= h($suppliers->address_invoice) ?></td>
                            <td><?= h($suppliers->phone_invoice) ?></td>
                            <td><?= h($suppliers->fax_invoice) ?></td>
                            <td><?= h($suppliers->name_tax_invoice) ?></td>
                            <td><?= h($suppliers->address_tax_invoice) ?></td>
                            <td><?= h($suppliers->phone_tax_invoice) ?></td>
                            <td><?= h($suppliers->fax_tax_invoice) ?></td>
                            <td><?= h($suppliers->system) ?></td>
                            <td><?= h($suppliers->website) ?></td>
                            <td><?= h($suppliers->is_active) ?></td>
                            <td><?= h($suppliers->is_log) ?></td>
                            <td><?= h($suppliers->is_create) ?></td>
                            <td><?= h($suppliers->created) ?></td>
                            <td><?= h($suppliers->is_update) ?></td>
                            <td><?= h($suppliers->modified) ?></td>
                            <td><?= h($suppliers->is_delete) ?></td>
                            <td><?= h($suppliers->deleted) ?></td>
                            <td><?= h($suppliers->active) ?></td>
                            <td><?= h($suppliers->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Suppliers', 'action' => 'view', $suppliers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Suppliers', 'action' => 'edit', $suppliers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Suppliers', 'action' => 'delete', $suppliers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $suppliers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Transporters') ?></h4>
                <?php if (!empty($user->transporters)) : ?>
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
                        <?php foreach ($user->transporters as $transporters) : ?>
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
        </div>
    </div>
</div>
