<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployeeLine $hrgaEmployeeLine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Hrga Employee Line'), ['action' => 'edit', $hrgaEmployeeLine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Hrga Employee Line'), ['action' => 'delete', $hrgaEmployeeLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaEmployeeLine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Hrga Employee Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Hrga Employee Line'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaEmployeeLines view content">
            <h3><?= h($hrgaEmployeeLine->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Hrga Employee') ?></th>
                    <td><?= $hrgaEmployeeLine->has('hrga_employee') ? $this->Html->link($hrgaEmployeeLine->hrga_employee->name, ['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'view', $hrgaEmployeeLine->hrga_employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($hrgaEmployeeLine->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Family') ?></th>
                    <td><?= h($hrgaEmployeeLine->status_family) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($hrgaEmployeeLine->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Ktp') ?></th>
                    <td><?= h($hrgaEmployeeLine->no_ktp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telp') ?></th>
                    <td><?= h($hrgaEmployeeLine->telp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pekerjaan') ?></th>
                    <td><?= h($hrgaEmployeeLine->pekerjaan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bpjs Kesehatan') ?></th>
                    <td><?= h($hrgaEmployeeLine->bpjs_kesehatan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bpjs Kesehatan Status') ?></th>
                    <td><?= h($hrgaEmployeeLine->bpjs_kesehatan_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Kesehatan') ?></th>
                    <td><?= h($hrgaEmployeeLine->status_kesehatan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Place Of Birth') ?></th>
                    <td><?= h($hrgaEmployeeLine->place_of_birth) ?></td>
                </tr>
                <tr>
                    <th><?= __('Riwayat Sakit') ?></th>
                    <td><?= h($hrgaEmployeeLine->riwayat_sakit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clothes Size') ?></th>
                    <td><?= h($hrgaEmployeeLine->clothes_size) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($hrgaEmployeeLine->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($hrgaEmployeeLine->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($hrgaEmployeeLine->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($hrgaEmployeeLine->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($hrgaEmployeeLine->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bpjs Kesehatan Date') ?></th>
                    <td><?= h($hrgaEmployeeLine->bpjs_kesehatan_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Birthday') ?></th>
                    <td><?= h($hrgaEmployeeLine->birthday) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($hrgaEmployeeLine->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($hrgaEmployeeLine->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($hrgaEmployeeLine->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
