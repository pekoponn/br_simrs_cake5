<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Patient $patient
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Patient'), ['action' => 'edit', $patient->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Patient'), ['action' => 'delete', $patient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patient->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Patients'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Patient'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="patients view content">
            <h3><?= h($patient->full_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Full Name') ?></th>
                    <td><?= h($patient->full_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identity Type') ?></th>
                    <td><?= h($patient->identity_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identity Number') ?></th>
                    <td><?= h($patient->identity_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gender') ?></th>
                    <td><?= h($patient->gender) ?></td>
                </tr>
                <tr>
                    <th><?= __('Blood Type') ?></th>
                    <td><?= h($patient->blood_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mother Name') ?></th>
                    <td><?= h($patient->mother_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Father Name') ?></th>
                    <td><?= h($patient->father_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number') ?></th>
                    <td><?= h($patient->phone_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nationality') ?></th>
                    <td><?= h($patient->nationality) ?></td>
                </tr>
                <tr>
                    <th><?= __('Citizenship') ?></th>
                    <td><?= h($patient->citizenship) ?></td>
                </tr>
                <tr>
                    <th><?= __('Province') ?></th>
                    <td><?= h($patient->province) ?></td>
                </tr>
                <tr>
                    <th><?= __('City') ?></th>
                    <td><?= h($patient->city) ?></td>
                </tr>
                <tr>
                    <th><?= __('District') ?></th>
                    <td><?= h($patient->district) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subdistrict') ?></th>
                    <td><?= h($patient->subdistrict) ?></td>
                </tr>
                <tr>
                    <th><?= __('Occupation') ?></th>
                    <td><?= h($patient->occupation) ?></td>
                </tr>
                <tr>
                    <th><?= __('Religion') ?></th>
                    <td><?= h($patient->religion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Education') ?></th>
                    <td><?= h($patient->education) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ethnic Group') ?></th>
                    <td><?= h($patient->ethnic_group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Marital Status') ?></th>
                    <td><?= h($patient->marital_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($patient->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($patient->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($patient->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($patient->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($patient->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Birth Date') ?></th>
                    <td><?= h($patient->birth_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($patient->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($patient->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($patient->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($patient->address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($patient->delete_log)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($patient->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Patient Pics') ?></h4>
                <?php if (!empty($patient->patient_pics)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient Id') ?></th>
                            <th><?= __('Full Name') ?></th>
                            <th><?= __('Identity Type') ?></th>
                            <th><?= __('Relationship Type') ?></th>
                            <th><?= __('Age') ?></th>
                            <th><?= __('Occupation') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Phone Number') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Delete Log') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Log') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->patient_pics as $patientPics) : ?>
                        <tr>
                            <td><?= h($patientPics->id) ?></td>
                            <td><?= h($patientPics->patient_id) ?></td>
                            <td><?= h($patientPics->full_name) ?></td>
                            <td><?= h($patientPics->identity_type) ?></td>
                            <td><?= h($patientPics->relationship_type) ?></td>
                            <td><?= h($patientPics->age) ?></td>
                            <td><?= h($patientPics->occupation) ?></td>
                            <td><?= h($patientPics->address) ?></td>
                            <td><?= h($patientPics->phone_number) ?></td>
                            <td><?= h($patientPics->is_create) ?></td>
                            <td><?= h($patientPics->created) ?></td>
                            <td><?= h($patientPics->is_update) ?></td>
                            <td><?= h($patientPics->modified) ?></td>
                            <td><?= h($patientPics->is_delete) ?></td>
                            <td><?= h($patientPics->deleted) ?></td>
                            <td><?= h($patientPics->delete_log) ?></td>
                            <td><?= h($patientPics->is_active) ?></td>
                            <td><?= h($patientPics->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientPics', 'action' => 'view', $patientPics->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientPics', 'action' => 'edit', $patientPics->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientPics', 'action' => 'delete', $patientPics->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientPics->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Registrations') ?></h4>
                <?php if (!empty($patient->registrations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registration Number') ?></th>
                            <th><?= __('Patient Id') ?></th>
                            <th><?= __('Registration Date') ?></th>
                            <th><?= __('Service Type') ?></th>
                            <th><?= __('Doctor Name') ?></th>
                            <th><?= __('Room Name') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Complaint') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Delete Log') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($patient->registrations as $registrations) : ?>
                        <tr>
                            <td><?= h($registrations->id) ?></td>
                            <td><?= h($registrations->registration_number) ?></td>
                            <td><?= h($registrations->patient_id) ?></td>
                            <td><?= h($registrations->registration_date) ?></td>
                            <td><?= h($registrations->service_type) ?></td>
                            <td><?= h($registrations->doctor_name) ?></td>
                            <td><?= h($registrations->room_name) ?></td>
                            <td><?= h($registrations->payment_method) ?></td>
                            <td><?= h($registrations->complaint) ?></td>
                            <td><?= h($registrations->status) ?></td>
                            <td><?= h($registrations->is_create) ?></td>
                            <td><?= h($registrations->created) ?></td>
                            <td><?= h($registrations->is_update) ?></td>
                            <td><?= h($registrations->modified) ?></td>
                            <td><?= h($registrations->is_delete) ?></td>
                            <td><?= h($registrations->deleted) ?></td>
                            <td><?= h($registrations->delete_log) ?></td>
                            <td><?= h($registrations->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Registrations', 'action' => 'view', $registrations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Registrations', 'action' => 'edit', $registrations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Registrations', 'action' => 'delete', $registrations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrations->id)]) ?>
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
