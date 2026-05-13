<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Branch[]|\Cake\Collection\CollectionInterface $branches
 */
?>
<div class="branches index content">
    <?= $this->Html->link(__('New Branch'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Branches') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('company_name') ?></th>
                    <th><?= $this->Paginator->sort('company_address') ?></th>
                    <th><?= $this->Paginator->sort('business_fields') ?></th>
                    <th><?= $this->Paginator->sort('company_telp') ?></th>
                    <th><?= $this->Paginator->sort('company_fax') ?></th>
                    <th><?= $this->Paginator->sort('company_npwp') ?></th>
                    <th><?= $this->Paginator->sort('company_director') ?></th>
                    <th><?= $this->Paginator->sort('company_director_1') ?></th>
                    <th><?= $this->Paginator->sort('sign_title_1') ?></th>
                    <th><?= $this->Paginator->sort('company_director_2') ?></th>
                    <th><?= $this->Paginator->sort('sign_title_2') ?></th>
                    <th><?= $this->Paginator->sort('company_director_3') ?></th>
                    <th><?= $this->Paginator->sort('sign_title_3') ?></th>
                    <th><?= $this->Paginator->sort('company_director_4') ?></th>
                    <th><?= $this->Paginator->sort('sign_title_4') ?></th>
                    <th><?= $this->Paginator->sort('warehouse_address') ?></th>
                    <th><?= $this->Paginator->sort('warehouse_telp') ?></th>
                    <th><?= $this->Paginator->sort('warehouse_fax') ?></th>
                    <th><?= $this->Paginator->sort('manifest_number') ?></th>
                    <th><?= $this->Paginator->sort('invoice_code') ?></th>
                    <th><?= $this->Paginator->sort('invoice_number') ?></th>
                    <th><?= $this->Paginator->sort('invoice_number_include') ?></th>
                    <th><?= $this->Paginator->sort('invoice_evidence_email') ?></th>
                    <th><?= $this->Paginator->sort('faktur_pajak_number') ?></th>
                    <th><?= $this->Paginator->sort('berita_acara_number') ?></th>
                    <th><?= $this->Paginator->sort('permit_number') ?></th>
                    <th><?= $this->Paginator->sort('offer_number') ?></th>
                    <th><?= $this->Paginator->sort('offer_year') ?></th>
                    <th><?= $this->Paginator->sort('bank') ?></th>
                    <th><?= $this->Paginator->sort('norek') ?></th>
                    <th><?= $this->Paginator->sort('an') ?></th>
                    <th><?= $this->Paginator->sort('bank_name_1') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek_1') ?></th>
                    <th><?= $this->Paginator->sort('bank_an_1') ?></th>
                    <th><?= $this->Paginator->sort('bank_name_2') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek_2') ?></th>
                    <th><?= $this->Paginator->sort('bank_an_2') ?></th>
                    <th><?= $this->Paginator->sort('bank_name_3') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek_3') ?></th>
                    <th><?= $this->Paginator->sort('bank_an_3') ?></th>
                    <th><?= $this->Paginator->sort('bank_name_4') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek_4') ?></th>
                    <th><?= $this->Paginator->sort('bank_an_4') ?></th>
                    <th><?= $this->Paginator->sort('bank_name_5') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek_5') ?></th>
                    <th><?= $this->Paginator->sort('bank_an_5') ?></th>
                    <th><?= $this->Paginator->sort('va_bank_an') ?></th>
                    <th><?= $this->Paginator->sort('va_bank_name') ?></th>
                    <th><?= $this->Paginator->sort('va_bank_branch') ?></th>
                    <th><?= $this->Paginator->sort('va_bank_norek') ?></th>
                    <th><?= $this->Paginator->sort('wa_invoice') ?></th>
                    <th><?= $this->Paginator->sort('city_invoice') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('emergency_call') ?></th>
                    <th><?= $this->Paginator->sort('offer_perihal') ?></th>
                    <th><?= $this->Paginator->sort('offer_info') ?></th>
                    <th><?= $this->Paginator->sort('manifest_type') ?></th>
                    <th><?= $this->Paginator->sort('manifest_code') ?></th>
                    <th><?= $this->Paginator->sort('offer_code') ?></th>
                    <th><?= $this->Paginator->sort('sign_1') ?></th>
                    <th><?= $this->Paginator->sort('sign_2') ?></th>
                    <th><?= $this->Paginator->sort('sign_3') ?></th>
                    <th><?= $this->Paginator->sort('sign_4') ?></th>
                    <th><?= $this->Paginator->sort('mou_code') ?></th>
                    <th><?= $this->Paginator->sort('transporter_id') ?></th>
                    <th><?= $this->Paginator->sort('header') ?></th>
                    <th><?= $this->Paginator->sort('footer') ?></th>
                    <th><?= $this->Paginator->sort('desc') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($branches as $branch): ?>
                <tr>
                    <td><?= $this->Number->format($branch->id) ?></td>
                    <td><?= h($branch->code) ?></td>
                    <td><?= h($branch->name) ?></td>
                    <td><?= h($branch->company_name) ?></td>
                    <td><?= h($branch->company_address) ?></td>
                    <td><?= h($branch->business_fields) ?></td>
                    <td><?= h($branch->company_telp) ?></td>
                    <td><?= h($branch->company_fax) ?></td>
                    <td><?= h($branch->company_npwp) ?></td>
                    <td><?= h($branch->company_director) ?></td>
                    <td><?= h($branch->company_director_1) ?></td>
                    <td><?= h($branch->sign_title_1) ?></td>
                    <td><?= h($branch->company_director_2) ?></td>
                    <td><?= h($branch->sign_title_2) ?></td>
                    <td><?= h($branch->company_director_3) ?></td>
                    <td><?= h($branch->sign_title_3) ?></td>
                    <td><?= h($branch->company_director_4) ?></td>
                    <td><?= h($branch->sign_title_4) ?></td>
                    <td><?= h($branch->warehouse_address) ?></td>
                    <td><?= h($branch->warehouse_telp) ?></td>
                    <td><?= h($branch->warehouse_fax) ?></td>
                    <td><?= h($branch->manifest_number) ?></td>
                    <td><?= h($branch->invoice_code) ?></td>
                    <td><?= h($branch->invoice_number) ?></td>
                    <td><?= h($branch->invoice_number_include) ?></td>
                    <td><?= h($branch->invoice_evidence_email) ?></td>
                    <td><?= h($branch->faktur_pajak_number) ?></td>
                    <td><?= h($branch->berita_acara_number) ?></td>
                    <td><?= h($branch->permit_number) ?></td>
                    <td><?= h($branch->offer_number) ?></td>
                    <td><?= h($branch->offer_year) ?></td>
                    <td><?= h($branch->bank) ?></td>
                    <td><?= h($branch->norek) ?></td>
                    <td><?= h($branch->an) ?></td>
                    <td><?= h($branch->bank_name_1) ?></td>
                    <td><?= h($branch->bank_norek_1) ?></td>
                    <td><?= h($branch->bank_an_1) ?></td>
                    <td><?= h($branch->bank_name_2) ?></td>
                    <td><?= h($branch->bank_norek_2) ?></td>
                    <td><?= h($branch->bank_an_2) ?></td>
                    <td><?= h($branch->bank_name_3) ?></td>
                    <td><?= h($branch->bank_norek_3) ?></td>
                    <td><?= h($branch->bank_an_3) ?></td>
                    <td><?= h($branch->bank_name_4) ?></td>
                    <td><?= h($branch->bank_norek_4) ?></td>
                    <td><?= h($branch->bank_an_4) ?></td>
                    <td><?= h($branch->bank_name_5) ?></td>
                    <td><?= h($branch->bank_norek_5) ?></td>
                    <td><?= h($branch->bank_an_5) ?></td>
                    <td><?= h($branch->va_bank_an) ?></td>
                    <td><?= h($branch->va_bank_name) ?></td>
                    <td><?= h($branch->va_bank_branch) ?></td>
                    <td><?= h($branch->va_bank_norek) ?></td>
                    <td><?= h($branch->wa_invoice) ?></td>
                    <td><?= h($branch->city_invoice) ?></td>
                    <td><?= h($branch->email) ?></td>
                    <td><?= h($branch->emergency_call) ?></td>
                    <td><?= h($branch->offer_perihal) ?></td>
                    <td><?= h($branch->offer_info) ?></td>
                    <td><?= h($branch->manifest_type) ?></td>
                    <td><?= h($branch->manifest_code) ?></td>
                    <td><?= h($branch->offer_code) ?></td>
                    <td><?= h($branch->sign_1) ?></td>
                    <td><?= h($branch->sign_2) ?></td>
                    <td><?= h($branch->sign_3) ?></td>
                    <td><?= h($branch->sign_4) ?></td>
                    <td><?= h($branch->mou_code) ?></td>
                    <td><?= $this->Number->format($branch->transporter_id) ?></td>
                    <td><?= h($branch->header) ?></td>
                    <td><?= h($branch->footer) ?></td>
                    <td><?= h($branch->desc) ?></td>
                    <td><?= h($branch->is_create) ?></td>
                    <td><?= h($branch->created) ?></td>
                    <td><?= h($branch->is_update) ?></td>
                    <td><?= h($branch->modified) ?></td>
                    <td><?= h($branch->is_delete) ?></td>
                    <td><?= h($branch->deleted) ?></td>
                    <td><?= h($branch->status) ?></td>
                    <td><?= h($branch->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $branch->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $branch->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $branch->id], ['confirm' => __('Are you sure you want to delete # {0}?', $branch->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
