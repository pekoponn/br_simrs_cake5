<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterTreatmentPackage $masterTreatmentPackage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Treatment Package'), ['action' => 'edit', $masterTreatmentPackage->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Treatment Package'), ['action' => 'delete', $masterTreatmentPackage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterTreatmentPackage->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Treatment Packages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Treatment Package'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterTreatmentPackages view content">
            <h3><?= h($masterTreatmentPackage->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($masterTreatmentPackage->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($masterTreatmentPackage->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($masterTreatmentPackage->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterTreatmentPackage->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($masterTreatmentPackage->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterTreatmentPackage->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterTreatmentPackage->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
