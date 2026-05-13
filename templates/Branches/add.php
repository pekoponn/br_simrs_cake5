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
            <?= $this->Html->link(__('List Branches'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="branches form content">
            <?= $this->Form->create($branch) ?>
            <fieldset>
                <legend><?= __('Add Branch') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('name');
                    echo $this->Form->control('company_name');
                    echo $this->Form->control('company_address');
                    echo $this->Form->control('business_fields');
                    echo $this->Form->control('company_telp');
                    echo $this->Form->control('company_fax');
                    echo $this->Form->control('company_npwp');
                    echo $this->Form->control('company_director');
                    echo $this->Form->control('company_director_1');
                    echo $this->Form->control('sign_title_1');
                    echo $this->Form->control('company_director_2');
                    echo $this->Form->control('sign_title_2');
                    echo $this->Form->control('company_director_3');
                    echo $this->Form->control('sign_title_3');
                    echo $this->Form->control('company_director_4');
                    echo $this->Form->control('sign_title_4');
                    echo $this->Form->control('warehouse_address');
                    echo $this->Form->control('warehouse_telp');
                    echo $this->Form->control('warehouse_fax');
                    echo $this->Form->control('manifest_number');
                    echo $this->Form->control('invoice_code');
                    echo $this->Form->control('invoice_number');
                    echo $this->Form->control('invoice_number_include');
                    echo $this->Form->control('invoice_evidence_email');
                    echo $this->Form->control('faktur_pajak_number');
                    echo $this->Form->control('berita_acara_number');
                    echo $this->Form->control('permit_number');
                    echo $this->Form->control('offer_number');
                    echo $this->Form->control('offer_year');
                    echo $this->Form->control('bank');
                    echo $this->Form->control('norek');
                    echo $this->Form->control('an');
                    echo $this->Form->control('bank_name_1');
                    echo $this->Form->control('bank_norek_1');
                    echo $this->Form->control('bank_an_1');
                    echo $this->Form->control('bank_name_2');
                    echo $this->Form->control('bank_norek_2');
                    echo $this->Form->control('bank_an_2');
                    echo $this->Form->control('bank_name_3');
                    echo $this->Form->control('bank_norek_3');
                    echo $this->Form->control('bank_an_3');
                    echo $this->Form->control('bank_name_4');
                    echo $this->Form->control('bank_norek_4');
                    echo $this->Form->control('bank_an_4');
                    echo $this->Form->control('bank_name_5');
                    echo $this->Form->control('bank_norek_5');
                    echo $this->Form->control('bank_an_5');
                    echo $this->Form->control('va_bank_an');
                    echo $this->Form->control('va_bank_name');
                    echo $this->Form->control('va_bank_branch');
                    echo $this->Form->control('va_bank_norek');
                    echo $this->Form->control('wa_invoice');
                    echo $this->Form->control('city_invoice');
                    echo $this->Form->control('email');
                    echo $this->Form->control('emergency_call');
                    echo $this->Form->control('offer_perihal');
                    echo $this->Form->control('offer_description');
                    echo $this->Form->control('offer_info');
                    echo $this->Form->control('manifest_type');
                    echo $this->Form->control('manifest_code');
                    echo $this->Form->control('offer_code');
                    echo $this->Form->control('sign_1');
                    echo $this->Form->control('sign_2');
                    echo $this->Form->control('sign_3');
                    echo $this->Form->control('sign_4');
                    echo $this->Form->control('mou_code');
                    echo $this->Form->control('transporter_id');
                    echo $this->Form->control('header');
                    echo $this->Form->control('footer');
                    echo $this->Form->control('desc');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
