<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PersonResponsible $personResponsible
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Person Responsible'), ['action' => 'edit', $personResponsible->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Person Responsible'), ['action' => 'delete', $personResponsible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $personResponsible->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Person Responsibles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Person Responsible'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="personResponsibles view content">
            <h3><?= h($personResponsible->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($personResponsible->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identity Type') ?></th>
                    <td><?= h($personResponsible->identity_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Identity No') ?></th>
                    <td><?= h($personResponsible->identity_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Relation') ?></th>
                    <td><?= h($personResponsible->relation) ?></td>
                </tr>
                <tr>
                    <th><?= __('Job') ?></th>
                    <td><?= h($personResponsible->job) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($personResponsible->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($personResponsible->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($personResponsible->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration Id') ?></th>
                    <td><?= $this->Number->format($personResponsible->registration_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Age') ?></th>
                    <td><?= $this->Number->format($personResponsible->age) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($personResponsible->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($personResponsible->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($personResponsible->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($personResponsible->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($personResponsible->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($personResponsible->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($personResponsible->address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($personResponsible->delete_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Registrations') ?></h4>
                <?php if (!empty($personResponsible->registrations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registration No') ?></th>
                            <th><?= __('Patient Id') ?></th>
                            <th><?= __('Registration Date') ?></th>
                            <th><?= __('Service Type') ?></th>
                            <th><?= __('Doctor Id') ?></th>
                            <th><?= __('Polyclinic Name') ?></th>
                            <th><?= __('Room Id') ?></th>
                            <th><?= __('Bed Id') ?></th>
                            <th><?= __('Class Name') ?></th>
                            <th><?= __('Entry Process') ?></th>
                            <th><?= __('Entry Method') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Insurance Type') ?></th>
                            <th><?= __('Insurance Card No') ?></th>
                            <th><?= __('Refferal No') ?></th>
                            <th><?= __('Sep No') ?></th>
                            <th><?= __('Person Responsible Id') ?></th>
                            <th><?= __('Treatment Type') ?></th>
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
                        <?php foreach ($personResponsible->registrations as $registrations) : ?>
                        <tr>
                            <td><?= h($registrations->id) ?></td>
                            <td><?= h($registrations->registration_no) ?></td>
                            <td><?= h($registrations->patient_id) ?></td>
                            <td><?= h($registrations->registration_date) ?></td>
                            <td><?= h($registrations->service_type) ?></td>
                            <td><?= h($registrations->doctor_id) ?></td>
                            <td><?= h($registrations->polyclinic_name) ?></td>
                            <td><?= h($registrations->room_id) ?></td>
                            <td><?= h($registrations->bed_id) ?></td>
                            <td><?= h($registrations->class_name) ?></td>
                            <td><?= h($registrations->entry_process) ?></td>
                            <td><?= h($registrations->entry_method) ?></td>
                            <td><?= h($registrations->payment_method) ?></td>
                            <td><?= h($registrations->insurance_type) ?></td>
                            <td><?= h($registrations->insurance_card_no) ?></td>
                            <td><?= h($registrations->refferal_no) ?></td>
                            <td><?= h($registrations->sep_no) ?></td>
                            <td><?= h($registrations->person_responsible_id) ?></td>
                            <td><?= h($registrations->treatment_type) ?></td>
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
                                <?= $this->Html->link(__('View'), ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $registrations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'edit', $registrations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'delete', $registrations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrations->id)]) ?>
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
