<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bed $bed
 * @var array $rooms
 * @var array $roomsMeta
 * @var array $classList
 * @var array $statusList
 * @var array $activeList
 */
?>

<?= $this->Krs->breadcrumb('Bed Management', 'Tambah') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-bed"></i> Tambah Bed
        </h4>
    </div>

    <div class="panel-body">

        <?= $this->Form->create($bed) ?>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('code', [
                        'label' => 'Code Bed',
                        'class' => 'form-control',
                        'placeholder' => 'Kosongkan untuk auto-generate',
                        'id' => 'bed-code',
                        'required' => false,
                        'data-parsley-required' => 'false',
                    ]) ?>

                    <div class="form-check mt-2">
                        <input type="checkbox"
                            class="form-check-input"
                            id="auto-bed-code"
                            name="auto_code"
                            value="1"
                            checked>
                        <label class="form-check-label" for="auto-bed-code">
                            Generate otomatis
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('room_id', [
                        'label' => 'Room',
                        'options' => $rooms,
                        'empty' => '-- Pilih Room --',
                        'class' => 'form-control',
                        'id' => 'bed-room-id',
                    ]) ?>
                    <small id="room-capacity-info" class="text-muted"></small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('bed_no', [
                        'label' => 'Nomor TT',
                        'class' => 'form-control',
                        'placeholder' => 'Pilih room untuk generate nomor TT',
                        'id' => 'bed-no',
                        'readonly' => true,
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('name', [
                        'label' => 'Nama Bed',
                        'class' => 'form-control',
                        'placeholder' => 'Masukkan nama bed',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Class</label>
                    <?= $this->Form->hidden('class_name', ['id' => 'bed-class-name']) ?>
                    <input type="text"
                        id="bed-class-display"
                        class="form-control"
                        placeholder="Otomatis dari room"
                        readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('status', [
                        'type' => 'select',
                        'label' => 'Status Bed',
                        'options' => $statusList,
                        'empty' => '-- Pilih Status --',
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('is_active', [
                        'type' => 'select',
                        'label' => 'Status Active',
                        'options' => $activeList,
                        'class' => 'form-control',
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <div class="text-end">

            <?= $this->Html->link(
                '<i class="fa fa-arrow-left"></i> Kembali',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-default',
                    'escape' => false
                ]
            ) ?>

            <?= $this->Form->button(
                '<i class="fa fa-save"></i> Simpan',
                [
                    'class' => 'btn btn-success',
                    'id' => 'btn-save-bed',
                    'escapeTitle' => false
                ]
            ) ?>

        </div>

        <?= $this->Form->end() ?>

    </div>

</div>

<script>
    var ROOMS_META = <?= json_encode($roomsMeta ?? []) ?>;

    $(document).ready(function() {
        function toggleBedCode() {
            if ($('#auto-bed-code').is(':checked')) {
                $('#bed-code')
                    .prop('readonly', true)
                    .prop('required', false)
                    .removeAttr('required')
                    .attr('data-parsley-required', 'false')
                    .val('')
                    .css({
                        'background-color': '#e9ecef',
                        'cursor': 'not-allowed'
                    });
            } else {
                $('#bed-code')
                    .prop('readonly', false)
                    .attr('data-parsley-required', 'true')
                    .css({
                        'background-color': '',
                        'cursor': ''
                    });
            }
        }

        toggleBedCode();

        $('#auto-bed-code').on('change', function() {
            toggleBedCode();
        });

        function applyRoomMeta() {
            var roomId = $('#bed-room-id').val();
            var meta = ROOMS_META[roomId] || null;

            $('#bed-no').val('');
            $('#bed-class-name').val('');
            $('#bed-class-display').val('');
            $('#room-capacity-info').text('');

            if (!meta) {
                return;
            }

            $('#bed-class-name').val(meta.class_name || '');
            $('#bed-class-display').val(meta.class_name || '-');

            if (meta.next_bed_no) {
                $('#bed-no').val(meta.next_bed_no);
                $('#btn-save-bed').prop('disabled', false);
                $('#room-capacity-info')
                    .removeClass('text-danger')
                    .addClass('text-muted')
                    .text('Terpakai ' + meta.used + ' dari ' + meta.capacity + ' bed. Sisa ' + meta.remaining + '.');
            } else {
                $('#btn-save-bed').prop('disabled', true);
                $('#room-capacity-info')
                    .removeClass('text-muted')
                    .addClass('text-danger')
                    .text('Kapasitas ruangan sudah penuh.');
            }
        }

        applyRoomMeta();

        $('#bed-room-id').on('change', function() {
            applyRoomMeta();
        });
    });
</script>
