<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PersonResponsible[]|\Cake\Collection\CollectionInterface $personResponsibles
 */
?>
<div class="personResponsibles index content">
    <?= $this->Html->link(__('New Person Responsible'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Person Responsibles') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('identity_type') ?></th>
                    <th><?= $this->Paginator->sort('identity_no') ?></th>
                    <th><?= $this->Paginator->sort('relation') ?></th>
                    <th><?= $this->Paginator->sort('age') ?></th>
                    <th><?= $this->Paginator->sort('job') ?></th>
                    <th><?= $this->Paginator->sort('phone') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personResponsibles as $personResponsible): ?>
                <tr>
                    <td><?= $this->Number->format($personResponsible->id) ?></td>
                    <td><?= $this->Number->format($personResponsible->registration_id) ?></td>
                    <td><?= h($personResponsible->name) ?></td>
                    <td><?= h($personResponsible->identity_type) ?></td>
                    <td><?= h($personResponsible->identity_no) ?></td>
                    <td><?= h($personResponsible->relation) ?></td>
                    <td><?= $this->Number->format($personResponsible->age) ?></td>
                    <td><?= h($personResponsible->job) ?></td>
                    <td><?= h($personResponsible->phone) ?></td>
                    <td><?= $this->Number->format($personResponsible->is_create) ?></td>
                    <td><?= h($personResponsible->created) ?></td>
                    <td><?= $this->Number->format($personResponsible->is_update) ?></td>
                    <td><?= h($personResponsible->modified) ?></td>
                    <td><?= $this->Number->format($personResponsible->is_delete) ?></td>
                    <td><?= h($personResponsible->deleted) ?></td>
                    <td><?= h($personResponsible->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $personResponsible->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $personResponsible->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $personResponsible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $personResponsible->id)]) ?>
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
