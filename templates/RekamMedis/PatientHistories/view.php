<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PatientHistory $patientHistory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Patient History'), ['action' => 'edit', $patientHistory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Patient History'), ['action' => 'delete', $patientHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Patient Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Patient History'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="patientHistories view content">
            <h3><?= h($patientHistory->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $patientHistory->has('registration') ? $this->Html->link($patientHistory->registration->id, ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $patientHistory->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($patientHistory->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($patientHistory->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($patientHistory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($patientHistory->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($patientHistory->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($patientHistory->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($patientHistory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($patientHistory->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($patientHistory->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($patientHistory->delete_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Documents') ?></h4>
                <?php if (!empty($patientHistory->patient_history_documents)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Document Name') ?></th>
                            <th><?= __('File Name') ?></th>
                            <th><?= __('File Path') ?></th>
                            <th><?= __('File Type') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_documents as $patientHistoryDocuments) : ?>
                        <tr>
                            <td><?= h($patientHistoryDocuments->id) ?></td>
                            <td><?= h($patientHistoryDocuments->patient_history_id) ?></td>
                            <td><?= h($patientHistoryDocuments->document_name) ?></td>
                            <td><?= h($patientHistoryDocuments->file_name) ?></td>
                            <td><?= h($patientHistoryDocuments->file_path) ?></td>
                            <td><?= h($patientHistoryDocuments->file_type) ?></td>
                            <td><?= h($patientHistoryDocuments->note) ?></td>
                            <td><?= h($patientHistoryDocuments->is_create) ?></td>
                            <td><?= h($patientHistoryDocuments->created) ?></td>
                            <td><?= h($patientHistoryDocuments->is_update) ?></td>
                            <td><?= h($patientHistoryDocuments->modified) ?></td>
                            <td><?= h($patientHistoryDocuments->is_delete) ?></td>
                            <td><?= h($patientHistoryDocuments->deleted) ?></td>
                            <td><?= h($patientHistoryDocuments->delete_log) ?></td>
                            <td><?= h($patientHistoryDocuments->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryDocuments', 'action' => 'view', $patientHistoryDocuments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryDocuments', 'action' => 'edit', $patientHistoryDocuments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryDocuments', 'action' => 'delete', $patientHistoryDocuments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryDocuments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Examinations') ?></h4>
                <?php if (!empty($patientHistory->patient_history_examinations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Payload Json') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_examinations as $patientHistoryExaminations) : ?>
                        <tr>
                            <td><?= h($patientHistoryExaminations->id) ?></td>
                            <td><?= h($patientHistoryExaminations->patient_history_id) ?></td>
                            <td><?= h($patientHistoryExaminations->status) ?></td>
                            <td><?= h($patientHistoryExaminations->note) ?></td>
                            <td><?= h($patientHistoryExaminations->payload_json) ?></td>
                            <td><?= h($patientHistoryExaminations->is_create) ?></td>
                            <td><?= h($patientHistoryExaminations->created) ?></td>
                            <td><?= h($patientHistoryExaminations->is_update) ?></td>
                            <td><?= h($patientHistoryExaminations->modified) ?></td>
                            <td><?= h($patientHistoryExaminations->is_delete) ?></td>
                            <td><?= h($patientHistoryExaminations->deleted) ?></td>
                            <td><?= h($patientHistoryExaminations->delete_log) ?></td>
                            <td><?= h($patientHistoryExaminations->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryExaminations', 'action' => 'view', $patientHistoryExaminations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryExaminations', 'action' => 'edit', $patientHistoryExaminations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryExaminations', 'action' => 'delete', $patientHistoryExaminations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryExaminations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Icares') ?></h4>
                <?php if (!empty($patientHistory->patient_history_icares)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Status') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_icares as $patientHistoryIcares) : ?>
                        <tr>
                            <td><?= h($patientHistoryIcares->id) ?></td>
                            <td><?= h($patientHistoryIcares->patient_history_id) ?></td>
                            <td><?= h($patientHistoryIcares->status) ?></td>
                            <td><?= h($patientHistoryIcares->note) ?></td>
                            <td><?= h($patientHistoryIcares->is_create) ?></td>
                            <td><?= h($patientHistoryIcares->created) ?></td>
                            <td><?= h($patientHistoryIcares->is_update) ?></td>
                            <td><?= h($patientHistoryIcares->modified) ?></td>
                            <td><?= h($patientHistoryIcares->is_delete) ?></td>
                            <td><?= h($patientHistoryIcares->deleted) ?></td>
                            <td><?= h($patientHistoryIcares->delete_log) ?></td>
                            <td><?= h($patientHistoryIcares->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryIcares', 'action' => 'view', $patientHistoryIcares->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryIcares', 'action' => 'edit', $patientHistoryIcares->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryIcares', 'action' => 'delete', $patientHistoryIcares->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryIcares->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Integrations') ?></h4>
                <?php if (!empty($patientHistory->patient_history_integrations)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Noted At') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Health Worker Name') ?></th>
                            <th><?= __('Profession') ?></th>
                            <th><?= __('Doctor Id') ?></th>
                            <th><?= __('Doctor Name') ?></th>
                            <th><?= __('Soap Sbar') ?></th>
                            <th><?= __('Instruction') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Payload Json') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_integrations as $patientHistoryIntegrations) : ?>
                        <tr>
                            <td><?= h($patientHistoryIntegrations->id) ?></td>
                            <td><?= h($patientHistoryIntegrations->patient_history_id) ?></td>
                            <td><?= h($patientHistoryIntegrations->noted_at) ?></td>
                            <td><?= h($patientHistoryIntegrations->user_id) ?></td>
                            <td><?= h($patientHistoryIntegrations->health_worker_name) ?></td>
                            <td><?= h($patientHistoryIntegrations->profession) ?></td>
                            <td><?= h($patientHistoryIntegrations->doctor_id) ?></td>
                            <td><?= h($patientHistoryIntegrations->doctor_name) ?></td>
                            <td><?= h($patientHistoryIntegrations->soap_sbar) ?></td>
                            <td><?= h($patientHistoryIntegrations->instruction) ?></td>
                            <td><?= h($patientHistoryIntegrations->status) ?></td>
                            <td><?= h($patientHistoryIntegrations->note) ?></td>
                            <td><?= h($patientHistoryIntegrations->payload_json) ?></td>
                            <td><?= h($patientHistoryIntegrations->is_create) ?></td>
                            <td><?= h($patientHistoryIntegrations->created) ?></td>
                            <td><?= h($patientHistoryIntegrations->is_update) ?></td>
                            <td><?= h($patientHistoryIntegrations->modified) ?></td>
                            <td><?= h($patientHistoryIntegrations->is_delete) ?></td>
                            <td><?= h($patientHistoryIntegrations->deleted) ?></td>
                            <td><?= h($patientHistoryIntegrations->delete_log) ?></td>
                            <td><?= h($patientHistoryIntegrations->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryIntegrations', 'action' => 'view', $patientHistoryIntegrations->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryIntegrations', 'action' => 'edit', $patientHistoryIntegrations->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryIntegrations', 'action' => 'delete', $patientHistoryIntegrations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryIntegrations->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Laboratories') ?></h4>
                <?php if (!empty($patientHistory->patient_history_laboratories)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Status') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_laboratories as $patientHistoryLaboratories) : ?>
                        <tr>
                            <td><?= h($patientHistoryLaboratories->id) ?></td>
                            <td><?= h($patientHistoryLaboratories->patient_history_id) ?></td>
                            <td><?= h($patientHistoryLaboratories->status) ?></td>
                            <td><?= h($patientHistoryLaboratories->note) ?></td>
                            <td><?= h($patientHistoryLaboratories->is_create) ?></td>
                            <td><?= h($patientHistoryLaboratories->created) ?></td>
                            <td><?= h($patientHistoryLaboratories->is_update) ?></td>
                            <td><?= h($patientHistoryLaboratories->modified) ?></td>
                            <td><?= h($patientHistoryLaboratories->is_delete) ?></td>
                            <td><?= h($patientHistoryLaboratories->deleted) ?></td>
                            <td><?= h($patientHistoryLaboratories->delete_log) ?></td>
                            <td><?= h($patientHistoryLaboratories->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryLaboratories', 'action' => 'view', $patientHistoryLaboratories->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryLaboratories', 'action' => 'edit', $patientHistoryLaboratories->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryLaboratories', 'action' => 'delete', $patientHistoryLaboratories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryLaboratories->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Prescriptions') ?></h4>
                <?php if (!empty($patientHistory->patient_history_prescriptions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Status') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_prescriptions as $patientHistoryPrescriptions) : ?>
                        <tr>
                            <td><?= h($patientHistoryPrescriptions->id) ?></td>
                            <td><?= h($patientHistoryPrescriptions->patient_history_id) ?></td>
                            <td><?= h($patientHistoryPrescriptions->status) ?></td>
                            <td><?= h($patientHistoryPrescriptions->note) ?></td>
                            <td><?= h($patientHistoryPrescriptions->is_create) ?></td>
                            <td><?= h($patientHistoryPrescriptions->created) ?></td>
                            <td><?= h($patientHistoryPrescriptions->is_update) ?></td>
                            <td><?= h($patientHistoryPrescriptions->modified) ?></td>
                            <td><?= h($patientHistoryPrescriptions->is_delete) ?></td>
                            <td><?= h($patientHistoryPrescriptions->deleted) ?></td>
                            <td><?= h($patientHistoryPrescriptions->delete_log) ?></td>
                            <td><?= h($patientHistoryPrescriptions->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryPrescriptions', 'action' => 'view', $patientHistoryPrescriptions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryPrescriptions', 'action' => 'edit', $patientHistoryPrescriptions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryPrescriptions', 'action' => 'delete', $patientHistoryPrescriptions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryPrescriptions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Patient History Radiologies') ?></h4>
                <?php if (!empty($patientHistory->patient_history_radiologies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Patient History Id') ?></th>
                            <th><?= __('Status') ?></th>
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
                        <?php foreach ($patientHistory->patient_history_radiologies as $patientHistoryRadiologies) : ?>
                        <tr>
                            <td><?= h($patientHistoryRadiologies->id) ?></td>
                            <td><?= h($patientHistoryRadiologies->patient_history_id) ?></td>
                            <td><?= h($patientHistoryRadiologies->status) ?></td>
                            <td><?= h($patientHistoryRadiologies->note) ?></td>
                            <td><?= h($patientHistoryRadiologies->is_create) ?></td>
                            <td><?= h($patientHistoryRadiologies->created) ?></td>
                            <td><?= h($patientHistoryRadiologies->is_update) ?></td>
                            <td><?= h($patientHistoryRadiologies->modified) ?></td>
                            <td><?= h($patientHistoryRadiologies->is_delete) ?></td>
                            <td><?= h($patientHistoryRadiologies->deleted) ?></td>
                            <td><?= h($patientHistoryRadiologies->delete_log) ?></td>
                            <td><?= h($patientHistoryRadiologies->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PatientHistoryRadiologies', 'action' => 'view', $patientHistoryRadiologies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PatientHistoryRadiologies', 'action' => 'edit', $patientHistoryRadiologies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PatientHistoryRadiologies', 'action' => 'delete', $patientHistoryRadiologies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patientHistoryRadiologies->id)]) ?>
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
