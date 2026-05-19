<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration $registration
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Registration'), ['action' => 'edit', $registration->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Registration'), ['action' => 'delete', $registration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Registrations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Registration'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="registrations view content">
            <h3><?= h($registration->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Registration No') ?></th>
                    <td><?= h($registration->registration_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $registration->has('patient') ? $this->Html->link($registration->patient->id, ['controller' => 'Patients', 'action' => 'view', $registration->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration Date') ?></th>
                    <td><?= h($registration->registration_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Service Type') ?></th>
                    <td><?= h($registration->service_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $registration->has('doctor') ? $this->Html->link($registration->doctor->id, ['controller' => 'Doctors', 'action' => 'view', $registration->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Polyclinic Name') ?></th>
                    <td><?= h($registration->polyclinic_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Room') ?></th>
                    <td><?= $registration->has('room') ? $this->Html->link($registration->room->id, ['controller' => 'Rooms', 'action' => 'view', $registration->room->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Class Name') ?></th>
                    <td><?= h($registration->class_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entry Process') ?></th>
                    <td><?= h($registration->entry_process) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entry Method') ?></th>
                    <td><?= h($registration->entry_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($registration->payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Insurance Type') ?></th>
                    <td><?= h($registration->insurance_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Insurance Card No') ?></th>
                    <td><?= h($registration->insurance_card_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Refferal No') ?></th>
                    <td><?= h($registration->refferal_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sep No') ?></th>
                    <td><?= h($registration->sep_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Treatment Type') ?></th>
                    <td><?= h($registration->treatment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($registration->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($registration->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($registration->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bed Id') ?></th>
                    <td><?= $this->Number->format($registration->bed_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Person Responsible Id') ?></th>
                    <td><?= $this->Number->format($registration->person_responsible_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($registration->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($registration->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($registration->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($registration->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($registration->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($registration->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($registration->delete_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Person Responsible') ?></h4>
                <?php if (!empty($registration->person_responsible)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registration Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Identity Type') ?></th>
                            <th><?= __('Identity No') ?></th>
                            <th><?= __('Relation') ?></th>
                            <th><?= __('Age') ?></th>
                            <th><?= __('Job') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Phone') ?></th>
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
                        <?php foreach ($registration->person_responsible as $personResponsible) : ?>
                        <tr>
                            <td><?= h($personResponsible->id) ?></td>
                            <td><?= h($personResponsible->registration_id) ?></td>
                            <td><?= h($personResponsible->name) ?></td>
                            <td><?= h($personResponsible->identity_type) ?></td>
                            <td><?= h($personResponsible->identity_no) ?></td>
                            <td><?= h($personResponsible->relation) ?></td>
                            <td><?= h($personResponsible->age) ?></td>
                            <td><?= h($personResponsible->job) ?></td>
                            <td><?= h($personResponsible->address) ?></td>
                            <td><?= h($personResponsible->phone) ?></td>
                            <td><?= h($personResponsible->is_create) ?></td>
                            <td><?= h($personResponsible->created) ?></td>
                            <td><?= h($personResponsible->is_update) ?></td>
                            <td><?= h($personResponsible->modified) ?></td>
                            <td><?= h($personResponsible->is_delete) ?></td>
                            <td><?= h($personResponsible->deleted) ?></td>
                            <td><?= h($personResponsible->delete_log) ?></td>
                            <td><?= h($personResponsible->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PersonResponsible', 'action' => 'view', $personResponsible->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PersonResponsible', 'action' => 'edit', $personResponsible->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PersonResponsible', 'action' => 'delete', $personResponsible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $personResponsible->id)]) ?>
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
