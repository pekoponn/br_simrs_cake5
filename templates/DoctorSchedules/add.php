<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule $doctorSchedule
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 */

$dataChild = $this->Html->link(
    'Doctor Schedule',
    ['action' => 'index'],
    ['full_base' => true]
);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">

        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">

            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">

                <i class="fa fa-expand"></i>

            </a>

        </div>

    </div>

    <?= $this->Form->create(
        $doctorSchedule,
        ['data-parsley-validate' => 'true']
    ) ?>

    <div class="panel-body">

        <!-- ROW 1 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Kode
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('code', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Kode Jadwal...',
                    'required' => true,
                    'data-parsley-required-message' =>
                        'Kode tidak boleh kosong!'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                Dokter
            </label>

            <div class="col-md-6">

                <?php
                echo $this->Form->control('doctor_id', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $doctors,
                    'empty' => '-- Pilih Dokter --',
                    'required' => true,
                    'data-parsley-required-message' =>
                        'Dokter wajib dipilih!'
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 2 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Hari
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('day', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => [
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu'
                    ],
                    'empty' => '-- Pilih Hari --',
                    'required' => true,
                    'data-parsley-required-message' =>
                        'Hari wajib dipilih!'
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                Kuota
            </label>

            <div class="col-md-2">

                <?php
                echo $this->Form->control('quota', [
                    'label' => false,
                    'type' => 'number',
                    'class' => 'form-control',
                    'placeholder' => 'Kuota...'
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 3 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Jam Mulai
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('start_time', [
                    'type' => 'time',
                    'label' => false,
                    'class' => 'form-control',
                    'step' => false
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-2">
                Jam Selesai
            </label>

            <div class="col-md-3">

                <?php
                echo $this->Form->control('end_time', [
                    'type' => 'time',
                    'label' => false,
                    'class' => 'form-control',
                    'step' => false
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 4 -->
        <div class="form-group row m-b-15">

            <label class="col-form-label col-md-1">
                Catatan
            </label>

            <div class="col-md-11">

                <?php
                echo $this->Form->control('note', [
                    'type' => 'textarea',
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Catatan jadwal...',
                    'rows' => 3
                ]);
                ?>

            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', [
            'value' => 1
        ]);

        echo $this->Form->hidden('is_update', [
            'value' => 0
        ]);

        echo $this->Form->hidden('is_delete', [
            'value' => 0
        ]);

        echo $this->Form->hidden('is_active', [
            'value' => 'Y'
        ]);
        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

        var confirmTitle =
            "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?= $this->Url->build(
            [
                'controller' => 'DoctorSchedules',
                'action' => 'add'
            ],
            ['fullBase' => true]
        ); ?>";

        handleFormConfirmSubmitValid(
            'DoctorScheduleAddForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>