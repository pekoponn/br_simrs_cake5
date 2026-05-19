<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PersonResponsible $personResponsible
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Person Responsibles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="personResponsibles form content">
            <?= $this->Form->create($personResponsible) ?>
            <fieldset>
                <legend><?= __('Add Person Responsible') ?></legend>
                <?php
                    echo $this->Form->control('registration_id');
                    echo $this->Form->control('name');
                    echo $this->Form->control('identity_type');
                    echo $this->Form->control('identity_no');
                    echo $this->Form->control('relation');
                    echo $this->Form->control('age');
                    echo $this->Form->control('job');
                    echo $this->Form->control('address');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('delete_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
