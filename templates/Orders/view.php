<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders view content">
            <h3><?= h($order->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('No Order') ?></th>
                    <td><?= h($order->no_order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $order->has('registration') ? $this->Html->link($order->registration->id, ['controller' => 'Registrations', 'action' => 'view', $order->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $order->has('patient') ? $this->Html->link($order->patient->id, ['controller' => 'Patients', 'action' => 'view', $order->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $order->has('doctor') ? $this->Html->link($order->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $order->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Status') ?></th>
                    <td><?= $order->has('order_status') ? $this->Html->link($order->order_status->id, ['controller' => 'OrderStatuses', 'action' => 'view', $order->order_status->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Lokasi Depo') ?></th>
                    <td><?= h($order->lokasi_depo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($order->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $this->Number->format($order->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Order') ?></th>
                    <td><?= h($order->tgl_order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($order->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($order->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Catatan') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->catatan)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Order Prescriptions') ?></h4>
                <?php if (!empty($order->order_prescriptions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Order Id') ?></th>
                            <th><?= __('Drug Id') ?></th>
                            <th><?= __('Drug Unit Id') ?></th>
                            <th><?= __('Is Kronis') ?></th>
                            <th><?= __('Jml Per Hari') ?></th>
                            <th><?= __('Qty Min') ?></th>
                            <th><?= __('Jml Hari') ?></th>
                            <th><?= __('Qty Satuan') ?></th>
                            <th><?= __('Aturan Pakai') ?></th>
                            <th><?= __('Harga') ?></th>
                            <th><?= __('Total Harga') ?></th>
                            <th><?= __('Keterangan') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($order->order_prescriptions as $orderPrescriptions) : ?>
                        <tr>
                            <td><?= h($orderPrescriptions->id) ?></td>
                            <td><?= h($orderPrescriptions->order_id) ?></td>
                            <td><?= h($orderPrescriptions->medicine_id) ?></td>
                            <td><?= h($orderPrescriptions->medicine_unit) ?></td>
                            <td><?= h($orderPrescriptions->is_kronis) ?></td>
                            <td><?= h($orderPrescriptions->jml_per_hari) ?></td>
                            <td><?= h($orderPrescriptions->qty_min) ?></td>
                            <td><?= h($orderPrescriptions->jml_hari) ?></td>
                            <td><?= h($orderPrescriptions->qty_satuan) ?></td>
                            <td><?= h($orderPrescriptions->aturan_pakai) ?></td>
                            <td><?= h($orderPrescriptions->harga) ?></td>
                            <td><?= h($orderPrescriptions->total_harga) ?></td>
                            <td><?= h($orderPrescriptions->keterangan) ?></td>
                            <td><?= h($orderPrescriptions->created) ?></td>
                            <td><?= h($orderPrescriptions->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'OrderPrescriptions', 'action' => 'view', $orderPrescriptions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'OrderPrescriptions', 'action' => 'edit', $orderPrescriptions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderPrescriptions', 'action' => 'delete', $orderPrescriptions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderPrescriptions->id)]) ?>
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
