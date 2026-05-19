<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bed'), ['action' => 'edit', $bed->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bed'), ['action' => 'delete', $bed->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bed->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Beds'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bed'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="beds view content">
            <h3><?= h($bed->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($bed->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Room') ?></th>
                    <td><?= $bed->has('room') ? $this->Html->link($bed->room->id, ['controller' => 'Rooms', 'action' => 'view', $bed->room->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Bed No') ?></th>
                    <td><?= h($bed->bed_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($bed->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Class Name') ?></th>
                    <td><?= h($bed->class_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($bed->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bed->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($bed->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($bed->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($bed->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($bed->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($bed->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($bed->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($bed->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bed->delete_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Registrations') ?></h4>
                <?php if (!empty($bed->registrations)) : ?>
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
                        <?php foreach ($bed->registrations as $registrations) : ?>
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
