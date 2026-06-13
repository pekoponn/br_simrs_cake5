<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientAction $outpatientAction
 * @var \Cake\Collection\CollectionInterface|string[] $outpatientVisits
 * @var \Cake\Collection\CollectionInterface|string[] $masterTindakan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Outpatient Actions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientActions form content">
            <?= $this->Form->create($outpatientAction) ?>
            <fieldset>
                <legend><?= __('Add Outpatient Action') ?></legend>
                <?php
                    echo $this->Form->control('outpatient_visit_id', ['options' => $outpatientVisits]);
                    echo $this->Form->control('master_tindakan_id', ['options' => $masterTindakan, 'empty' => true]);
                    echo $this->Form->control('action_code');
                    echo $this->Form->control('action_name');
                    echo $this->Form->control('action_category');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('unit_price');
                    echo $this->Form->control('total_price');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('performed_by');
                    echo $this->Form->control('performed_at', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
