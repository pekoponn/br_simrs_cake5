<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkOrder $workOrder
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Work Order'), ['action' => 'edit', $workOrder->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Work Order'), ['action' => 'delete', $workOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workOrder->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Work Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Work Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="workOrders view content">
            <h3><?= h($workOrder->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($workOrder->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($workOrder->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($workOrder->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Approve') ?></th>
                    <td><?= $this->Number->format($workOrder->is_approve) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($workOrder->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($workOrder->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($workOrder->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($workOrder->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Approved') ?></th>
                    <td><?= h($workOrder->approved) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($workOrder->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($workOrder->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($workOrder->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($workOrder->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($workOrder->delete_log)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($workOrder->is_log)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Work Order Lines') ?></h4>
                <?php if (!empty($workOrder->work_order_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Work Order Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Time From') ?></th>
                            <th><?= __('Time End') ?></th>
                            <th><?= __('Task') ?></th>
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
                        <?php foreach ($workOrder->work_order_lines as $workOrderLines) : ?>
                        <tr>
                            <td><?= h($workOrderLines->id) ?></td>
                            <td><?= h($workOrderLines->work_order_id) ?></td>
                            <td><?= h($workOrderLines->user_id) ?></td>
                            <td><?= h($workOrderLines->time_from) ?></td>
                            <td><?= h($workOrderLines->time_end) ?></td>
                            <td><?= h($workOrderLines->task) ?></td>
                            <td><?= h($workOrderLines->is_create) ?></td>
                            <td><?= h($workOrderLines->created) ?></td>
                            <td><?= h($workOrderLines->is_update) ?></td>
                            <td><?= h($workOrderLines->modified) ?></td>
                            <td><?= h($workOrderLines->is_delete) ?></td>
                            <td><?= h($workOrderLines->deleted) ?></td>
                            <td><?= h($workOrderLines->delete_log) ?></td>
                            <td><?= h($workOrderLines->is_active) ?></td>
                            <td><?= h($workOrderLines->is_log) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'WorkOrderLines', 'action' => 'view', $workOrderLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'WorkOrderLines', 'action' => 'edit', $workOrderLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'WorkOrderLines', 'action' => 'delete', $workOrderLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workOrderLines->id)]) ?>
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
