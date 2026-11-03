<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployeeTraining[]|\Cake\Collection\CollectionInterface $hrgaEmployeeTrainings
 */
?>
<div class="hrgaEmployeeTrainings index content">
    <?= $this->Html->link(__('New Hrga Employee Training'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Hrga Employee Trainings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('hrga_employee_id') ?></th>
                    <th><?= $this->Paginator->sort('skill') ?></th>
                    <th><?= $this->Paginator->sort('start_date') ?></th>
                    <th><?= $this->Paginator->sort('end_date') ?></th>
                    <th><?= $this->Paginator->sort('grade') ?></th>
                    <th><?= $this->Paginator->sort('organizer') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hrgaEmployeeTrainings as $hrgaEmployeeTraining): ?>
                <tr>
                    <td><?= $this->Number->format($hrgaEmployeeTraining->id) ?></td>
                    <td><?= $hrgaEmployeeTraining->has('hrga_employee') ? $this->Html->link($hrgaEmployeeTraining->hrga_employee->name, ['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'view', $hrgaEmployeeTraining->hrga_employee->id]) : '' ?></td>
                    <td><?= h($hrgaEmployeeTraining->skill) ?></td>
                    <td><?= h($hrgaEmployeeTraining->start_date) ?></td>
                    <td><?= h($hrgaEmployeeTraining->end_date) ?></td>
                    <td><?= h($hrgaEmployeeTraining->grade) ?></td>
                    <td><?= h($hrgaEmployeeTraining->organizer) ?></td>
                    <td><?= $this->Number->format($hrgaEmployeeTraining->is_create) ?></td>
                    <td><?= $this->Number->format($hrgaEmployeeTraining->is_update) ?></td>
                    <td><?= h($hrgaEmployeeTraining->created) ?></td>
                    <td><?= h($hrgaEmployeeTraining->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $hrgaEmployeeTraining->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $hrgaEmployeeTraining->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $hrgaEmployeeTraining->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaEmployeeTraining->id)]) ?>
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
