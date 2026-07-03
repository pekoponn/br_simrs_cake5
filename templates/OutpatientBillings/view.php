<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBilling $outpatientBilling
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Outpatient Billing'), ['action' => 'edit', $outpatientBilling->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Outpatient Billing'), ['action' => 'delete', $outpatientBilling->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientBilling->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Outpatient Billings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Outpatient Billing'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientBillings view content">
            <h3><?= h($outpatientBilling->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Billing No') ?></th>
                    <td><?= h($outpatientBilling->billing_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Outpatient Visit') ?></th>
                    <td><?= $outpatientBilling->has('outpatient_visit') ? $this->Html->link($outpatientBilling->outpatient_visit->id, ['controller' => 'OutpatientVisits', 'action' => 'view', $outpatientBilling->outpatient_visit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $outpatientBilling->has('registration') ? $this->Html->link($outpatientBilling->registration->id, ['controller' => 'Registrations', 'action' => 'view', $outpatientBilling->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $outpatientBilling->has('patient') ? $this->Html->link($outpatientBilling->patient->id, ['controller' => 'Patients', 'action' => 'view', $outpatientBilling->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $outpatientBilling->has('doctor') ? $this->Html->link($outpatientBilling->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $outpatientBilling->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Polyclinic Name') ?></th>
                    <td><?= h($outpatientBilling->polyclinic_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Insurance Type') ?></th>
                    <td><?= h($outpatientBilling->insurance_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Insurance No') ?></th>
                    <td><?= h($outpatientBilling->insurance_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($outpatientBilling->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Type') ?></th>
                    <td><?= h($outpatientBilling->discount_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($outpatientBilling->payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cashier Name') ?></th>
                    <td><?= h($outpatientBilling->cashier_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Referred To') ?></th>
                    <td><?= h($outpatientBilling->referred_to) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inpatient Referral No') ?></th>
                    <td><?= h($outpatientBilling->inpatient_referral_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Void Reason') ?></th>
                    <td><?= h($outpatientBilling->void_reason) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($outpatientBilling->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Action') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->total_action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Medicine') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->total_medicine) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Lab') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->total_lab) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Radiology') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->total_radiology) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Other') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->total_other) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtotal') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->subtotal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Value') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->discount_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Discount Amount') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->discount_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grand Total') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->grand_total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid Amount') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->paid_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Change Amount') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->change_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cashier Id') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->cashier_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Voided By') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->voided_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td><?= $this->Number->format($outpatientBilling->modified_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Visit Date') ?></th>
                    <td><?= h($outpatientBilling->visit_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid At') ?></th>
                    <td><?= h($outpatientBilling->paid_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Voided At') ?></th>
                    <td><?= h($outpatientBilling->voided_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outpatientBilling->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($outpatientBilling->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Referred') ?></th>
                    <td><?= $outpatientBilling->is_referred ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Inpatient') ?></th>
                    <td><?= $outpatientBilling->is_inpatient ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $outpatientBilling->is_create ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $outpatientBilling->is_update ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $outpatientBilling->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outpatientBilling->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
