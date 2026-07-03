<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Room[]|\Cake\Collection\CollectionInterface $rooms
 */

$pages = (empty($this->request->getQuery('page')))
    ? ''
    : $this->request->getQuery('page');

$bedStatusColor = [
    0 => ['class' => 'room-bed-available', 'label' => 'KOSONG'],
    1 => ['class' => 'room-bed-filled', 'label' => 'ISI'],
    2 => ['class' => 'room-bed-cleaning', 'label' => 'DIBERSIHKAN'],
    3 => ['class' => 'room-bed-maintenance', 'label' => 'MAINTENANCE'],
];
?>

<?= $this->Krs->breadcrumb('Master', 'Rooms', 'Tampilkan') ?>

<div class="panel panel-inverse">

    <div class="panel-heading">

        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;"
               class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand">

                <i class="fa fa-expand"></i>

            </a>
        </div>

    </div>

    <div class="panel-body">

        <div class="portlet-body form">

            <!-- TOOLBAR -->
            <div class="table-toolbar">

                <div class="btn-group">

                    <div class="portlet-body">

                        <?= $this->Html->link(
                            '<i class="fa fa-plus"></i>',
                            ['action' => 'add', $pages],
                            [
                                'class' => 'btn btn-inverse',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Add'
                            ]
                        ) ?>

                        <?= $this->Html->link(
                            '<i class="fa fa-download"></i>',
                            ['action' => 'pdf', $pages],
                            [
                                'class' => 'btn btn-green',
                                'escape' => false,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'data-original-title' => 'Download'
                            ]
                        ) ?>

                        <?= $this->Html->link(
                            '<i class="fa fa-tv"></i> Monitoring Bed',
                            ['action' => 'monitoring'],
                            [
                                'class' => 'btn btn-success btn-sm',
                                'escape' => false,
                                'style' => 'margin-left:5px;'
                            ]
                        ) ?>

                    </div>

                </div>

            </div>

            <br>

            <!-- SEARCH -->
            <?= $this->Form->create(null, ['type' => 'get']) ?>

            <div class="panel-footer bg-aqua text-white p-t-10">

                <div class="row row-space-10">

                    <div class="col-md-2 m-b-10">

                        <?= $this->Form->text(
                            'filterCode',
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Kode...',
                                'value' => $this->request->getQuery('filterCode')
                            ]
                        ) ?>

                    </div>

                    <div class="col-md-4 m-b-10">

                        <?= $this->Form->text(
                            'filterName',
                            [
                                'class' => 'form-control',
                                'placeholder' => 'Nama Room...',
                                'value' => $this->request->getQuery('filterName')
                            ]
                        ) ?>

                    </div>

                    <div class="col-md-1">

                        <?= $this->Krs->btnSeach(); ?>

                    </div>

                </div>

            </div>

            <?= $this->Form->end() ?>

            <!-- TABLE -->
            <div class="rooms-bed-layout">
                <div class="rooms-bed-left">
                    <div class="table-responsive">

                        <table class="table table-striped table-hover table-td-valign-middle rooms-select-table">

                            <thead class="thead-dark text-center">

                                <tr>

                                    <th width="100">
                                        Kode
                                    </th>

                                    <th>
                                        Nama Room
                                    </th>

                                    <th width="100">
                                        Kelas
                                    </th>

                                    <th width="90">
                                        Kapasitas
                                    </th>

                                    <th width="90">
                                        Lantai
                                    </th>

                                    <th width="80">
                                        List Kamar
                                    </th>

                                    <th width="80">
                                        Aktif
                                    </th>

                                    <th width="110" class="actions">
                                        &nbsp;
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                if (count($rooms) > 0) {

                                    foreach ($rooms as $rowData) {

                                        $statusHiddenActive =
                                            ($rowData->is_active == 'Y')
                                            ? ''
                                            : ' style="display:none;"';

                                        $statusHiddenInactive =
                                            ($rowData->is_active == 'N')
                                            ? ''
                                            : ' style="display:none;"';

                                        $btnActive = "";

                                        $btnActive .=
                                            "<div id='statusActive".$rowData->id."'".$statusHiddenActive.">".
                                            $this->Html->link(
                                                '<i class=\"fa fa-check\"></i>',
                                                'javascript:;',
                                                [
                                                    'escape' => false,
                                                    'class' =>
                                                        'btn btn-lime btn-icon btn-circle btn-sm'
                                                ]
                                            ).
                                            "</div>";

                                        $btnActive .=
                                            "<div id='statusInactive".$rowData->id."'".$statusHiddenInactive.">".
                                            $this->Html->link(
                                                '<i class=\"fa fa-times\"></i>',
                                                'javascript:;',
                                                [
                                                    'escape' => false,
                                                    'class' =>
                                                        'btn btn-danger btn-icon btn-circle btn-sm'
                                                ]
                                            ).
                                            "</div>";

                                        $rowClasses = ['room-select-row'];
                                        if ($rowData->is_active != 'Y') {
                                            $rowClasses[] = 'table-warning';
                                        }

                                        $beds = $rowData->beds ?? [];
                                        $totalBeds = count($beds);
                                        $filledBeds = 0;

                                        foreach ($beds as $bed) {
                                            if ((int)$bed->status === 1) {
                                                $filledBeds++;
                                            }
                                        }

                                        $linkEdit = [
                                            'action' => 'edit',
                                            $rowData->id
                                        ];

                                        $linkDelete = [
                                            'action' => 'delete',
                                            $rowData->id
                                        ];
                                ?>

                                <tr class="<?= h(implode(' ', $rowClasses)) ?>" data-room-id="<?= h($rowData->id) ?>">

                                    <td>
                                        <b><?= h($rowData->room_code) ?></b>
                                    </td>

                                    <td>
                                        <?= h($rowData->room_name) ?>
                                    </td>

                                    <td class="text-center">
                                        <?= h($rowData->room_class) ?>
                                    </td>

                                    <td class="text-center">
                                        <?= h($rowData->capacity) ?>
                                    </td>

                                    <td>
                                        <?= h($rowData->floor) ?>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-info btn-show-beds" data-room-id="<?= h($rowData->id) ?>">
                                            <?= h($filledBeds) ?>/<?= h($totalBeds) ?>
                                        </button>
                                    </td>

                                    <td align="center">
                                        <?= $btnActive ?>
                                    </td>

                                    <td class="actions text-center" width="150">

                                        <?= $this->Krs->btn(
                                            'edit',
                                            $linkEdit
                                        ) ?>

                                        <?= $this->Krs->btn(
                                            'delete',
                                            $linkDelete,
                                            $rowData->room_name
                                        ) ?>

                                    </td>

                                </tr>

                                <?php
                                    }
                                } else {

                                    echo $this->Krs->dataNull();

                                }
                                ?>

                            </tbody>

                        </table>

                    </div>
                </div>

                <div class="rooms-bed-right">
                    <div class="room-bed-panel">
                        <div class="room-bed-panel-header">
                            <div>
                                <span class="room-bed-panel-label">List Kamar</span>
                                <h5 id="selected-room-title">Pilih ruangan</h5>
                            </div>
                            <span id="selected-room-count" class="room-bed-count">0 bed</span>
                        </div>

                        <div id="room-bed-empty" class="room-bed-empty">
                            Klik salah satu ruangan di tabel kiri untuk melihat isi bed.
                        </div>

                        <div id="room-bed-content"></div>
                    </div>
                </div>
            </div>

            <div id="room-bed-source" style="display:none;">
                <?php foreach ($rooms as $rowData): ?>
                    <?php
                    $beds = $rowData->beds ?? [];
                    $totalBeds = count($beds);
                    $filledBeds = 0;
                    foreach ($beds as $bed) {
                        if ((int)$bed->status === 1) {
                            $filledBeds++;
                        }
                    }
                    ?>
                    <div class="room-bed-data"
                         data-room-id="<?= h($rowData->id) ?>"
                         data-room-name="<?= h($rowData->room_name) ?>"
                         data-total="<?= h($totalBeds) ?>"
                         data-filled="<?= h($filledBeds) ?>">
                        <?php if ($totalBeds > 0): ?>
                            <table class="table table-bordered table-condensed room-bed-detail-table">
                                <thead>
                                    <tr>
                                        <th width="90">NO. KAMAR</th>
                                        <th width="110">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beds as $bed): ?>
                                        <?php $status = $bedStatusColor[(int)$bed->status] ?? $bedStatusColor[0]; ?>
                                        <tr class="<?= h($status['class']) ?>">
                                            <td>
                                                <?= $this->Html->link(
                                                    h($bed->bed_no ?: $bed->name),
                                                    ['controller' => 'Beds', 'action' => 'view', $bed->id],
                                                    ['escape' => false]
                                                ) ?>
                                            </td>
                                            <td><?= h($status['label']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="room-bed-empty">Belum ada bed aktif pada ruangan ini.</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?= $this->Krs->paginators() ?>

        </div>

    </div>

</div>

<style>
.rooms-bed-layout { display:flex; gap:14px; align-items:flex-start; }
.rooms-bed-left { flex:1 1 62%; min-width:0; }
.rooms-bed-right { flex:0 0 38%; min-width:330px; }
.rooms-select-table tbody tr.room-select-row { cursor:pointer; }
.rooms-select-table tbody tr.room-select-row.active-room > td { background:#fff3cd !important; }
.btn-show-beds { min-width:48px; font-weight:600; }
.room-bed-panel { border:1px solid #d5dbe0; background:#fff; min-height:360px; }
.room-bed-panel-header { display:flex; justify-content:space-between; align-items:flex-start; gap:10px; padding:12px 14px; background:#2c3e50; color:#fff; }
.room-bed-panel-header h5 { margin:2px 0 0; color:#fff; font-size:15px; line-height:1.3; }
.room-bed-panel-label { display:block; font-size:11px; opacity:.78; text-transform:uppercase; letter-spacing:0; }
.room-bed-count { background:#fff; color:#2c3e50; border-radius:3px; padding:3px 8px; font-size:12px; font-weight:600; white-space:nowrap; }
.room-bed-empty { color:#6c757d; padding:18px 14px; font-size:13px; }
#room-bed-content { padding:0; overflow:auto; max-height:520px; }
.room-bed-detail-table { margin:0; font-size:13px; }
.room-bed-detail-table thead th { background:#f3f5f7; color:#333; text-align:center; border-bottom:1px solid #d5dbe0 !important; }
.room-bed-detail-table td { vertical-align:middle !important; }
.room-bed-detail-table td:first-child { font-weight:600; }
.room-bed-detail-table a { color:inherit; text-decoration:none; display:block; }
.room-bed-available td { background:#e9f7ef !important; color:#155724; }
.room-bed-filled td { background:#e91e3a !important; color:#fff; }
.room-bed-cleaning td { background:#fff176 !important; color:#5f5100; }
.room-bed-maintenance td { background:#e9ecef !important; color:#383d41; }
@media (max-width: 991px) {
    .rooms-bed-layout { display:block; }
    .rooms-bed-right { min-width:0; margin-top:12px; }
}
</style>

<script>
$(function () {
    function showRoomBeds(roomId) {
        var $source = $('#room-bed-source .room-bed-data[data-room-id="' + roomId + '"]');
        if (!$source.length) {
            return;
        }

        $('.room-select-row').removeClass('active-room');
        $('.room-select-row[data-room-id="' + roomId + '"]').addClass('active-room');

        $('#selected-room-title').text($source.data('room-name'));
        $('#selected-room-count').text($source.data('filled') + '/' + $source.data('total') + ' terisi');
        $('#room-bed-empty').hide();
        $('#room-bed-content').html($source.html()).show();
    }

    $(document).on('click', '.room-select-row', function (event) {
        if ($(event.target).closest('a, button').length) {
            return;
        }

        showRoomBeds($(this).data('room-id'));
    });

    $(document).on('click', '.btn-show-beds', function (event) {
        event.preventDefault();
        event.stopPropagation();
        showRoomBeds($(this).data('room-id'));
    });

    var firstRoomId = $('.room-select-row').first().data('room-id');
    if (firstRoomId) {
        showRoomBeds(firstRoomId);
    }
});
</script>
