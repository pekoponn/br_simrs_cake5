<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientBilling[]|\Cake\Collection\CollectionInterface $outpatientBillings
 */
?>
<div class="outpatientBillings index content">
    <?= $this->Html->link(__('New Outpatient Billing'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Outpatient Billings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('billing_no') ?></th>
                    <th><?= $this->Paginator->sort('outpatient_visit_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('visit_date') ?></th>
                    <th><?= $this->Paginator->sort('polyclinic_name') ?></th>
                    <th><?= $this->Paginator->sort('insurance_type') ?></th>
                    <th><?= $this->Paginator->sort('insurance_no') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('total_action') ?></th>
                    <th><?= $this->Paginator->sort('total_medicine') ?></th>
                    <th><?= $this->Paginator->sort('total_lab') ?></th>
                    <th><?= $this->Paginator->sort('total_radiology') ?></th>
                    <th><?= $this->Paginator->sort('total_other') ?></th>
                    <th><?= $this->Paginator->sort('subtotal') ?></th>
                    <th><?= $this->Paginator->sort('discount_type') ?></th>
                    <th><?= $this->Paginator->sort('discount_value') ?></th>
                    <th><?= $this->Paginator->sort('discount_amount') ?></th>
                    <th><?= $this->Paginator->sort('grand_total') ?></th>
                    <th><?= $this->Paginator->sort('payment_method') ?></th>
                    <th><?= $this->Paginator->sort('paid_amount') ?></th>
                    <th><?= $this->Paginator->sort('change_amount') ?></th>
                    <th><?= $this->Paginator->sort('paid_at') ?></th>
                    <th><?= $this->Paginator->sort('cashier_id') ?></th>
                    <th><?= $this->Paginator->sort('cashier_name') ?></th>
                    <th><?= $this->Paginator->sort('is_referred') ?></th>
                    <th><?= $this->Paginator->sort('referred_to') ?></th>
                    <th><?= $this->Paginator->sort('is_inpatient') ?></th>
                    <th><?= $this->Paginator->sort('inpatient_referral_no') ?></th>
                    <th><?= $this->Paginator->sort('void_reason') ?></th>
                    <th><?= $this->Paginator->sort('voided_at') ?></th>
                    <th><?= $this->Paginator->sort('voided_by') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('modified_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outpatientBillings as $outpatientBilling): ?>
                <tr>
                    <td><?= $this->Number->format($outpatientBilling->id) ?></td>
                    <td><?= h($outpatientBilling->billing_no) ?></td>
                    <td><?= $outpatientBilling->has('outpatient_visit') ? $this->Html->link($outpatientBilling->outpatient_visit->id, ['controller' => 'OutpatientVisits', 'action' => 'view', $outpatientBilling->outpatient_visit->id]) : '' ?></td>
                    <td><?= $outpatientBilling->has('registration') ? $this->Html->link($outpatientBilling->registration->id, ['controller' => 'Registrations', 'action' => 'view', $outpatientBilling->registration->id]) : '' ?></td>
                    <td><?= $outpatientBilling->has('patient') ? $this->Html->link($outpatientBilling->patient->id, ['controller' => 'Patients', 'action' => 'view', $outpatientBilling->patient->id]) : '' ?></td>
                    <td><?= $outpatientBilling->has('doctor') ? $this->Html->link($outpatientBilling->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $outpatientBilling->doctor->id]) : '' ?></td>
                    <td><?= h($outpatientBilling->visit_date) ?></td>
                    <td><?= h($outpatientBilling->polyclinic_name) ?></td>
                    <td><?= h($outpatientBilling->insurance_type) ?></td>
                    <td><?= h($outpatientBilling->insurance_no) ?></td>
                    <td><?= h($outpatientBilling->status) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->total_action) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->total_medicine) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->total_lab) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->total_radiology) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->total_other) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->subtotal) ?></td>
                    <td><?= h($outpatientBilling->discount_type) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->discount_value) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->discount_amount) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->grand_total) ?></td>
                    <td><?= h($outpatientBilling->payment_method) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->paid_amount) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->change_amount) ?></td>
                    <td><?= h($outpatientBilling->paid_at) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->cashier_id) ?></td>
                    <td><?= h($outpatientBilling->cashier_name) ?></td>
                    <td><?= h($outpatientBilling->is_referred) ?></td>
                    <td><?= h($outpatientBilling->referred_to) ?></td>
                    <td><?= h($outpatientBilling->is_inpatient) ?></td>
                    <td><?= h($outpatientBilling->inpatient_referral_no) ?></td>
                    <td><?= h($outpatientBilling->void_reason) ?></td>
                    <td><?= h($outpatientBilling->voided_at) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->voided_by) ?></td>
                    <td><?= h($outpatientBilling->is_create) ?></td>
                    <td><?= h($outpatientBilling->is_update) ?></td>
                    <td><?= h($outpatientBilling->is_delete) ?></td>
                    <td><?= h($outpatientBilling->is_active) ?></td>
                    <td><?= h($outpatientBilling->created) ?></td>
                    <td><?= h($outpatientBilling->modified) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->created_by) ?></td>
                    <td><?= $this->Number->format($outpatientBilling->modified_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $outpatientBilling->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outpatientBilling->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outpatientBilling->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientBilling->id)]) ?>
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
