<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Doctor $doctor
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Doctor'), ['action' => 'edit', $doctor->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Doctor'), ['action' => 'delete', $doctor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $doctor->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Doctors'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Doctor'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="doctors view content">
            <h3><?= h($doctor->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($doctor->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Region') ?></th>
                    <td><?= h($doctor->region) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nik Login') ?></th>
                    <td><?= h($doctor->nik_login) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nik') ?></th>
                    <td><?= h($doctor->nik) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor Name') ?></th>
                    <td><?= h($doctor->doctor_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Specialist') ?></th>
                    <td><?= h($doctor->specialist) ?></td>
                </tr>
                <tr>
                    <th><?= __('Polyclinic') ?></th>
                    <td><?= $doctor->has('polyclinic') ? $this->Html->link($doctor->polyclinic->name, ['controller' => 'Polyclinics', 'action' => 'view', $doctor->polyclinic->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Religion') ?></th>
                    <td><?= h($doctor->religion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sip Number') ?></th>
                    <td><?= h($doctor->sip_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Str Number') ?></th>
                    <td><?= h($doctor->str_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Str Expiry Date') ?></th>
                    <td><?= h($doctor->str_expiry_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number') ?></th>
                    <td><?= h($doctor->phone_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gender') ?></th>
                    <td><?= h($doctor->gender) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($doctor->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($doctor->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($doctor->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($doctor->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($doctor->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Str Issue Date') ?></th>
                    <td><?= h($doctor->str_issue_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($doctor->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($doctor->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($doctor->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($doctor->address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($doctor->delete_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Doctor Schedules') ?></h4>
                <?php if (!empty($doctor->doctor_schedules)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Doctor Id') ?></th>
                            <th><?= __('Day') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('End Time') ?></th>
                            <th><?= __('Quota') ?></th>
                            <th><?= __('Note') ?></th>
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
                        <?php foreach ($doctor->doctor_schedules as $doctorSchedules) : ?>
                        <tr>
                            <td><?= h($doctorSchedules->id) ?></td>
                            <td><?= h($doctorSchedules->code) ?></td>
                            <td><?= h($doctorSchedules->doctor_id) ?></td>
                            <td><?= h($doctorSchedules->day) ?></td>
                            <td><?= h($doctorSchedules->start_time) ?></td>
                            <td><?= h($doctorSchedules->end_time) ?></td>
                            <td><?= h($doctorSchedules->quota) ?></td>
                            <td><?= h($doctorSchedules->note) ?></td>
                            <td><?= h($doctorSchedules->is_create) ?></td>
                            <td><?= h($doctorSchedules->created) ?></td>
                            <td><?= h($doctorSchedules->is_update) ?></td>
                            <td><?= h($doctorSchedules->modified) ?></td>
                            <td><?= h($doctorSchedules->is_delete) ?></td>
                            <td><?= h($doctorSchedules->deleted) ?></td>
                            <td><?= h($doctorSchedules->delete_log) ?></td>
                            <td><?= h($doctorSchedules->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'DoctorSchedules', 'action' => 'view', $doctorSchedules->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'DoctorSchedules', 'action' => 'edit', $doctorSchedules->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'DoctorSchedules', 'action' => 'delete', $doctorSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $doctorSchedules->id)]) ?>
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
