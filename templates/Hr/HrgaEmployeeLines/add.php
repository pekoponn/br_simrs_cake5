<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaEmployeeLine $hrgaEmployeeLine
 * @var \Cake\Collection\CollectionInterface|string[] $hrgaEmployees
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Hrga Employee Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaEmployeeLines form content">
            <?= $this->Form->create($hrgaEmployeeLine) ?>
            <fieldset>
                <legend><?= __('Add Hrga Employee Line') ?></legend>
                <?php
                    echo $this->Form->control('hrga_employee_id', ['options' => $hrgaEmployees]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('status_family');
                    echo $this->Form->control('address');
                    echo $this->Form->control('no_ktp');
                    echo $this->Form->control('telp');
                    echo $this->Form->control('pekerjaan');
                    echo $this->Form->control('bpjs_kesehatan');
                    echo $this->Form->control('bpjs_kesehatan_status');
                    echo $this->Form->control('bpjs_kesehatan_date', ['empty' => true]);
                    echo $this->Form->control('birthday', ['empty' => true]);
                    echo $this->Form->control('status_kesehatan');
                    echo $this->Form->control('place_of_birth');
                    echo $this->Form->control('riwayat_sakit');
                    echo $this->Form->control('clothes_size');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
