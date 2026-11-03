<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterIcd10 $masterIcd10
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master Icd10'), ['action' => 'edit', $masterIcd10->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master Icd10'), ['action' => 'delete', $masterIcd10->id], ['confirm' => __('Are you sure you want to delete # {0}?', $masterIcd10->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Master Icd10'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master Icd10'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masterIcd10 view content">
            <h3><?= h($masterIcd10->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Kode') ?></th>
                    <td><?= h($masterIcd10->kode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($masterIcd10->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $this->Number->format($masterIcd10->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($masterIcd10->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($masterIcd10->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Nama') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($masterIcd10->nama)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
