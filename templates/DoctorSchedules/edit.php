<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule $doctorSchedule
 * @var string[]|\Cake\Collection\CollectionInterface $doctors
 */

$dataChild = $this->Html->link(
    'Doctor Schedule',
    ['action' => 'index'],
    ['full_base' => true]
);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Edit') ?>

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
        [
            'data-parsley-validate' => 'true'
        ]
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
                    'placeholder' => 'Kode...',
                    'required' => true,
                    'value' => $doctorSchedule->code
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Dokter
            </label>

            <div class="col-md-7">

                <?php
                echo $this->Form->control('doctor_id', [
                    'label' => false,
                    'class' => 'form-control select2Form',
                    'options' => $doctors,
                    'empty' => '-- Pilih Dokter --',
                    'default' => $doctorSchedule->doctor_id
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
                    'default' => $doctorSchedule->day
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Mulai
            </label>

            <div class="col-md-2">

                <?php
                echo $this->Form->control('start_time', [
                    'type' => 'time',
                    'label' => false,
                    'class' => 'form-control',
                    'value' => !empty($doctorSchedule->start_time)
                        ? date('H:i', strtotime($doctorSchedule->start_time))
                        : ''
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Selesai
            </label>

            <div class="col-md-2">

                <?php
                echo $this->Form->control('end_time', [
                    'type' => 'time',
                    'label' => false,
                    'class' => 'form-control',
                    'value' => !empty($doctorSchedule->end_time)
                        ? date('H:i', strtotime($doctorSchedule->end_time))
                        : ''
                ]);
                ?>

            </div>

            <label class="col-form-label col-md-1">
                Kuota
            </label>

            <div class="col-md-1">

                <?php
                echo $this->Form->control('quota', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => '0',
                    'value' => $doctorSchedule->quota
                ]);
                ?>

            </div>

        </div>

        <!-- ROW 3 -->
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
                    'placeholder' => 'Catatan...',
                    'rows' => 3,
                    'value' => $doctorSchedule->note
                ]);
                ?>

            </div>

        </div>

        <!-- HIDDEN -->
        <?php
        echo $this->Form->hidden('is_create', [
            'value' => $doctorSchedule->is_create
        ]);

        echo $this->Form->hidden('is_update', [
            'value' => 1
        ]);

        echo $this->Form->hidden('is_delete', [
            'value' => $doctorSchedule->is_delete
        ]);

        echo $this->Form->hidden('is_active', [
            'value' => $doctorSchedule->is_active
        ]);
        ?>

    </div>

    <?= $this->Krs->btnSave(); ?>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2Form").select2();

        // FIX jquery validate error input type=time
        $('input[type="time"]').removeAttr('step');

        var confirmTitle =
            "Apakah anda ingin menyimpan data tersebut ?";

        var formAction = "<?= $this->Url->build(
            [
                'controller' => 'DoctorSchedules',
                'action' => 'edit',
                $doctorSchedule->id
            ],
            [
                'fullBase' => true
            ]
        ); ?>";

        handleFormConfirmSubmitValid(
            'DoctorScheduleEditForm',
            'btn-add',
            confirmTitle,
            formAction
        );

    });

</script>