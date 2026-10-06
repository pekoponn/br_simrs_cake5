<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Assignment[]|\Cake\Collection\CollectionInterface $assignments
 */
?>
<?= $this->Krs->breadcrumb('HRGA', 'Penugasan', 'Tampilkan') ?>
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <!-- <div class="btn-group dropdown">
                    <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                    <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'excel']); ?>">Excel</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="btnDownloadExcel">Excel</a>
                    </div>
                </div> -->
                <div class="btn-group">
                    <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                </div>
                <!-- <div class="btn-group">
                    <a href="javascript:void(0);" id="btnDownloadExcel" class="btn btn-lime">
                        <i class="fa fa-download"></i> Download Excel
                    </a>
                </div> -->

            </div>
            <br>
            <!--Bagian Search-->
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-aqua">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('filterUser', [
                            'label' => false, 
                            'type' => 'text',
                            'placeholder' => 'Cari nama karyawan',
                            'id'    => 'name',
                            'class' => 'form-control ', 
                            'value' => $this->request->getQuery('filterUser')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('date_range', [
                            'type' => 'text',
                            'label' => false,
                            'id'    => 'date_range',
                            'placeholder' => 'Rentang tanggal Penugasan',
                            'class' => 'form-control daterange'
                        ]); ?>    
                    </div>   
                    <div class="col-md-1">
                        <button type="button" class="btn btn-warning" onclick="searchHistory()">
                            <i class="fa fa-search"></i>
                        </button>   
                    </div>                
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle data-assignments">
                    <!--Bagian Header Table-->
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="">Nama</th>
                            <th width="">Devisi</th>
                            <th width="">Tanggal Penugasan</th>
                            <th width="">Berkas</th>
                            <th width="">Menyetujui</th>
                            <th width="">Mengetahui</th>
                            <th width="">Action</th>
                        </tr>
                    </thead>
                    <tbody> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal preview -->
<div class="modal fade" id="modalPreviewAssignments" tabindex="-1" role="dialog" aria-labelledby="modalPreviewAssignments">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalPreviewAssignmentsLabel">Detail Laporan Penugasan</h5>
                <!-- <button type="button" class="btn btn-sm btn-light text-dark ml-2" id="btnPrintPDF">
                    <i class="fas fa-print"></i> Print PDF
                </button> -->
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Nama:</div>
                        <div class="col-sm-4" id="previewCreated">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Devisi:</div>
                        <div class="col-sm-9" id="previewDevisi">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Tanggal Penugasan:</div>
                        <div class="col-sm-4" id="previewDateFrom">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Jam Mulai Penugasan:</div>
                        <div class="col-sm-4" id="previewTimeFrom">-</div>
                    </div>
                    <hr>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Deskripsi:</div>
                        <div class="col-sm-9" id="previewDeskripsi">-</div>
                    </div>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Catatan Approve:</div>
                        <div class="col-sm-9" id="previewCatatanApprove">-</div>
                    </div>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Catatan Mengetahui:</div>
                        <div class="col-sm-9" id="previewCatatanMengetahui">-</div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <div>
                                <strong>Menyetujui</strong>
                            </div>
                            <div id="previewApprove">-</div>
                        </div>
                        <div class="col-sm-6 ">
                            <div>
                                <strong>Mengetahui</strong>
                            </div>
                            <div id="previewKnowing">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Menyetujui Penugasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="itemForm">
                    <?= $this->Form->control('is_approve', ['type' => 'hidden', 'value' => $getUser->id]); ?> 
                    <?= $this->Form->control('id', ['type' => 'hidden', 'id' => 'assignmentIdApprove']); ?>
                    <?= $this->Form->control('approved', ['type' => 'hidden', 'id' => 'approvedAssignments', 'value' => '']); ?>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Nama:</div>
                        <div class="col-sm-4" id="approvedCreated">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Devisi:</div>
                        <div class="col-sm-9" id="approvedDevisi">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Tanggal Penugasan:</div>
                        <div class="col-sm-4" id="approvedDateFrom">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Jam Mulai Penugasan:</div>
                        <div class="col-sm-4" id="approvedTimeFrom">-</div>
                    </div>
                    <hr>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Deskripsi:</div>
                        <div class="col-sm-9" id="approvedDeskripsi">-</div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <?= $this->Form->control('approved_description', [
                            'type' => 'textarea',
                            'label' => 'Catatan Penyetujuan',
                            'id'    => 'descriptionApprovedAssignments',
                            'class' => 'form-control',
                            'rows' => 3,
                            'placeholder' => 'Catatan tambahan...',
                        ]); ?>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check">
                            <input type="checkbox" id="checkbox-approve" class="form-check-input" checked>
                            <label for="checkbox-approve" class="form-check-label">
                                Setujui Penugasan ini
                            </label>
                        </div>
                        <small class="text-muted">
                            Centang untuk menyetujui, hapus centang untuk menolak
                        </small>
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveItem()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Knowing -->
<div class="modal fade" id="knowingModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mengetahui Penugasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="itemForm">
                    <?= $this->Form->control('is_knowing', ['type' => 'hidden', 'value' => $getUser->id]); ?> 
                    <?= $this->Form->control('id', ['type' => 'hidden', 'id' => 'assignmentIdKnowing']); ?>
                    <?= $this->Form->control('knowing', ['type' => 'hidden', 'id' => 'knowingAssignments', 'value' => '']); ?>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Nama:</div>
                        <div class="col-sm-4" id="knowingCreated">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Devisi:</div>
                        <div class="col-sm-9" id="knowingDevisi">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Tanggal Penugasan:</div>
                        <div class="col-sm-4" id="knowingDateFrom">-</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Jam Mulai Penugasan:</div>
                        <div class="col-sm-4" id="knowingTimeFrom">-</div>
                    </div>
                    <hr>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Deskripsi:</div>
                        <div class="col-sm-9" id="knowingDeskripsi">-</div>
                    </div>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Catatan Penyetuju:</div>
                        <div class="col-sm-9" id="knowingApproveDeskripsi">-</div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <?= $this->Form->control('knowing_description', [
                            'type' => 'textarea',
                            'label' => 'Catatan Mengetahui',
                            'id'    => 'descriptionKnowingAssignments',
                            'class' => 'form-control',
                            'rows' => 3,
                            'placeholder' => 'Catatan tambahan...',
                        ]); ?>
                    </div>
                    <div class="form-group mt-3">
                        <div class="form-check">
                            <input type="checkbox" id="checkbox-knowing" class="form-check-input" checked>
                            <label for="checkbox-knowing" class="form-check-label">
                                Setujui Penugasan ini
                            </label>
                        </div>
                        <small class="text-muted">
                            Centang untuk menyetujui, hapus centang untuk menolak
                        </small>
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveItem2()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const baseUrl = '<?= $this->Url->build(["prefix" => 'Hr', "controller" => "Assignments"]) ?>';
    $('.data-assignments').DataTable();
    searchHistory();
    // console.log(searchHistory());
    $('.select2').select2({
        allowClear: true
    });
    const start = moment().startOf('month');  
    const end = moment().endOf('month'); 

    $('.daterange').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    // datePickerReset('input-daterange', 'resetDate', 'tanggal', 'dd-mm-yyyy');
});

function searchHistory() {
    const dateRange = $('.daterange').val();
    let start_date = '';
    let end_date = '';
    if (dateRange) [start_date, end_date] = dateRange.split(' - ').map(s => s.trim());

    const filters = {
        name: $('#name').val(),
        start_date,
        end_date
    };
    console.log('filters', filters);

    loadHistoryData(filters);
}
function loadHistoryData(filters = {}) {
    const table = $('.data-assignments').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        paging: true,
        pageLength: 10,
        lengthChange: false,
        ordering: true,
        info: true,
        searching: false,
        scrollX: true,
        ajax: {
            url: '<?= $this->Url->build(["controller" => "Assignments", "action" => "getHistory"]) ?>',
            type: 'GET',
            data: function(d) {
                // return $.extend({}, d, filters);
                const dateRange = $('.daterange').val();
                let start_date = '', end_date = '';
                if (dateRange) {
                    const parts = dateRange.split(' - ');
                    if (parts.length === 2) {
                        start_date = parts[0].trim();
                        end_date = parts[1].trim();
                    }
                }
                d.name = $('#name').val();
                d.start_date = start_date;
                d.end_date = end_date;
                return d;
            }
        },
        columns: [
            { 
                data: 'is_create_user.name', 
                className: 'text-center',
                defaultContent: '-' ,
                render: function (val, type, row) {
                    const name = val || '-';
                    const createdDate = row.created ? moment(row.created).format('DD-MM-YYYY') : '-';
                    return `
                        <div class="text-center">
                            <strong>${name}</strong><br>
                            <small class="text-muted">${createdDate}</small>
                        </div>
                    `;
                }
            },
            { 
                data: 'devision', 
                defaultContent: '-'
            },
            { 
                data: 'date_from', 
                className: 'text-center',
                defaultContent: '-',                
                render: function (val, type, row) {
                    const dateFrom = val ? moment(val).format('DD-MM-YYYY') : '-';
                    const dateEnd = row.date_end ? moment(row.date_end).format('DD-MM-YYYY') : '-';
                    let timeFrom = row.time_from ? moment(row.time_from, 'HH:mm').format('HH:mm') : '-';
                    let timeEnd = row.time_end ? moment(row.time_end, 'HH:mm').format('HH:mm') : '-';
                    // return `${dateFrom} s/d ${dateEnd}`;
                    if(row.time_from != '' && row.time_end != '') {
                        return `${dateFrom} s/d ${dateEnd} <br> (${timeFrom} - ${timeEnd})`;
                    } else {
                        return `${dateFrom} s/d ${dateEnd}`;
                    }
                }
            },
            {
                data: 'files',
                className: 'text-center',
                render: function (val, type, row) {

                    if (!val) {
                        return '-';
                    }

                    return `
                        <a href="<?= $this->Url->build('/files/', ['fullBase' => false]) ?>${val}"
                        target="_blank"
                        class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> Lihat
                        </a>
                    `;
                }
            },
            {
                data: 'is_approve_user.name',
                render: function (val, type, row) {
                    const name = val || '-';
                    const approveDate = row.approved ? moment(row.approved).format('DD-MM-YYYY') : '-';
                    let icon = '';
                    if (row.status_approve === 'Y'){
                        icon = '<i class="fas fa-check text-success"></i>';
                    } else if (row.status_approve === 'N') {
                        icon = '<i class="fas fa-times text-danger"></i>';
                    }
                    return `
                        <div class="text-center">
                            ${icon} <br>
                            <strong>${name}</strong><br>
                            <small class="text-muted">${approveDate}</small>
                        </div>
                    `;
                }
            },
            {
                data: 'is_knowing_user.name',
                render: function (val, type, row) {
                    const name = val || '-';
                    const approveDate = row.knowing ? moment(row.knowing).format('DD-MM-YYYY') : '-';
                    let icon = '';
                    if (row.status_knowing === 'Y'){
                        icon = '<i class="fas fa-check text-success"></i>';
                    } else if (row.status_knowing === 'N') {
                        icon = '<i class="fas fa-times text-danger"></i>';
                    }
                    return `
                        <div class="text-center">
                            ${icon} <br>
                            <strong>${name}</strong><br>
                            <small class="text-muted">${approveDate}</small>
                        </div>
                    `;
                }
            },
            {
                data: null,
                title: 'Actions',
                orderable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    let buttons = `
                        <button class="btn btn-sm btn-warning btn-preview m-1" data-id="${row.id}" title="Preview">
                            <i class="fas fa-desktop"></i>
                        </button>
                    `;
                    if (row.is_approve == null) {
                        buttons += `
                            <button class="btn btn-sm btn-success btn-approve m-1" data-id="${row.id}" title="Approve">
                                <i class="fa fa-check"></i>
                            </button>
                        `;
                    }
                    if (row.is_knowing == null && row.status_approve === 'Y') {
                        buttons += `
                            <button class="btn btn-sm btn-pink btn-knowing m-1" data-id="${row.id}" title="Knowing">
                                <i class="fa fa-thumbs-up"></i>
                            </button>
                        `;
                    }
                    return buttons;
                }

            }
        ],
    });
    // Event untuk daterangepicker
    $('.daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table.ajax.reload();
    });

    $('.daterange').on('cancel.daterangepicker', function () {
        $(this).val('');
        table.ajax.reload();
    });

    // Event untuk tombol search
    $('#name').on('keyup', function() {
        table.ajax.reload();
    });

    // Event untuk button search
    window.searchHistory = function() {
        table.ajax.reload();
    };
}

$(document).on('click', '.btn-preview', function () {  
    const id = $(this).data('id');
    const rawData = $('.data-assignments').DataTable().data().toArray();
    const masterData = rawData.find(item => item.id === id && !item.isDetail);
    // console.log('masterData', rawData);
    if (!masterData) return;

    // Set header details
    $('#previewCreated').text(masterData.is_create_user?.name || '-');
    $('#previewDevisi').text(masterData.devision || '-');
    $('#previewDateFrom').text(moment(masterData.date_from).format('DD-MM-YYYY') + ' s/d ' + (masterData.date_end ? moment(masterData.date_end).format('DD-MM-YYYY') : ' -'));
    $('#previewTimeFrom').text(masterData.time_from + ' s/d ' + (masterData.time_end ? masterData.time_end : '-'));
    $('#previewDeskripsi').html(masterData.description || '-');
    $('#previewCatatanApprove').html(masterData.approved_description || '-');
    $('#previewCatatanMengetahui').html(masterData.knowing_description || '-');
    if (masterData.status_approve === 'Y') {
        $('#previewApprove').html(`
            <div class="text-center">
                <span style="color:green;">✔️</span><br>
                <small>${masterData.is_approve_user?.name ?? '-'}</small><br>
                <small>${(moment(masterData.approved).format('DD-MM-YYYY'))}</small>
            </div>
        `);
    } else if (masterData.status_approve === 'N') {
        $('#previewApprove').html(`
            <div class="text-center">
                <span style="color:red;">❌</span><br>
                <small>${masterData.is_approve_user?.name ?? '-'}</small><br>
                <small>${(moment(masterData.approved).format('DD-MM-YYYY'))}</small>
            </div>
        `);
    } else {
        $('#previewApprove').html(`
            <div class="text-center">
                <span style="color:gray;">⏳</span><br>
                <small>-</small><br>
                <small>-</small>
            </div>
        `);
    }

    // Menyetujui
    if (masterData.status_knowing === 'Y') {
        $('#previewKnowing').html(`
            <div class="text-center">
                <span style="color:green;">✔️</span><br>
                <small>${masterData.is_knowing_user?.name ?? '-'}</small><br>
                <small>${(moment(masterData.knowing).format('DD-MM-YYYY'))}</small>
            </div>
        `);
    } else if (masterData.status_knowing === 'N') {
        $('#previewKnowing').html(`
            <div class="text-center">
                <span style="color:red;">❌</span><br>
                <small>${masterData.is_knowing_user?.name ?? '-'}</small><br>
                <small>${(moment(masterData.knowing).format('DD-MM-YYYY'))}</small>
            </div>
        `);
    } else {
        $('#previewKnowing').html(`
            <div class="text-center">
                <span style="color:gray;">⏳</span><br>
                <small>-</small><br>
                <small>-</small>
            </div>
        `);
    }
    $('#modalPreviewAssignments').modal('show');
});

<?php $baseUrl = $this->Url->build(['prefix' => 'Hr','controller' => 'Assignments','action' => 'approve']);?>
$('.data-assignments').on('click', '.btn-approve', function () {
    const id = $(this).data('id');
    $.ajax({
        url: '<?php echo $baseUrl; ?>/' + encodeURIComponent(id),
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const data = response.data;
            // console.log('data', data);
            $('#assignmentIdApprove').val(response.data.id);
            $('#approvedCreated').text(data.is_create_user?.name || '-');
            $('#approvedDevisi').text(data.devision || '-');
            $('#approvedDateFrom').text(moment(data.date_from).format('DD-MM-YYYY') + ' s/d ' + (data.date_end ? moment(data.date_end).format('DD-MM-YYYY') : ' -'));
            $('#approvedTimeFrom').text(data.time_from + ' s/d ' + (data.time_end ? data.time_end : '-'));
            $('#approvedDeskripsi').html(data.description || '-');
            $('#descriptionApprovedAssignments').val(data.approved_description || '');
            $('#checkbox-approve').prop('checked', data.status_approve !== 'N');
            $('#approveModal').modal('show');
        },
        error: function(xhr) {
            alert('Gagal mengambil data');
        }
    });
});
function saveItem() {

    SwalHelper.confirm('Apakah Anda yakin ingin menyimpan?', '', 'Ya, simpan', 'Batal')   
    .then((result) => {
        if (result.isConfirmed) {
            // const form = $('#assignmentIdApprove')[0];
            const formData = {id: $('#assignmentIdApprove').val(),
                is_approve: <?= $getUser->id ?>,
                approved_description: $('#descriptionApprovedAssignments').val(),
                status_approve: $('#checkbox-approve').is(':checked') ? 'Y' : 'N'}
        $.ajax({
            type: 'POST',
            url: '<?= $this->Url->build(['prefix' => 'Hr', 'controller' => 'Assignments','action' => 'approve']); ?>',
            data: formData,
            // processData: false,
            // contentType: false,
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            success: function (response) {
                if (response.status === true) {
                    SwalHelper.success('Data berhasil disimpan', 'Berhasil', 1500).then(() => {
                        window.location.href = '<?= $this->Url->build([
                            'prefix' => 'Hr',
                            'controller' => 'Assignments',
                            'action' => 'index'
                        ]) ?>';
                    });
                } else {
                    let errorMsg = '';
                    if (response.errors) {
                        for (const key in response.errors) {
                            if (response.errors.hasOwnProperty(key)) {
                                if (Array.isArray(response.errors[key])) {
                                    errorMsg += response.errors[key].join('<br>') + '<br>';
                                } else {
                                    errorMsg += response.errors[key] + '<br>';
                                }
                            }
                        }
                    } else {
                        errorMsg = 'Terjadi kesalahan yang tidak diketahui.';
                    }
                    SwalHelper.error(errorMsg, 'Gagal menyimpan');
                }
            },
            error: function () {
                SwalHelper.error('Terjadi kesalahan saat menyimpan data.', 'Error');
            }
        });
    }
    });
}

<?php $baseUrl = $this->Url->build(['prefix' => 'Hr','controller' => 'Assignments','action' => 'knowing']);?>
$('.data-assignments').on('click', '.btn-knowing', function () {
    const id = $(this).data('id');
    $.ajax({
        url: '<?php echo $baseUrl; ?>/' + encodeURIComponent(id),
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const data = response.data;
            console.log('data', data);
            $('#assignmentIdKnowing').val(response.data.id);

            $('#knowingCreated').text(data.is_create_user?.name || '-');
            $('#knowingDevisi').text(data.devision || '-');
            $('#knowingDateFrom').text(moment(data.date_from).format('DD-MM-YYYY') + ' s/d ' + (data.date_end ? moment(data.date_end).format('DD-MM-YYYY') : ' -'));
            $('#knowingTimeFrom').text(data.time_from + ' s/d ' + (data.time_end ? data.time_end : '-'));
            $('#knowingDeskripsi').html(data.description || '-');
            $('#knowingApproveDeskripsi').html(data.approved_description || '-');
            $('#descriptionKnowingAssignments').val(data.knowing_description || '');
            $('#checkbox-knowing').prop('checked', data.status_knowing !== 'N');
            // console.log($('#progresModal').length);

            $('#knowingModal').modal('show');
        },
        error: function(xhr) {
            alert('Gagal mengambil data');
            // console.error(xhr.responseText);
        }
    });
});
function saveItem2() {

    SwalHelper.confirm('Apakah Anda yakin ingin menyimpan?', '', 'Ya, simpan', 'Batal')   
    .then((result) => {
        if (result.isConfirmed) {
            const formData = {id: $('#assignmentIdKnowing').val(),
                is_knowing: <?= $getUser->id ?>,
                knowing_description: $('#descriptionKnowingAssignments').val(),
                status_knowing: $('#checkbox-knowing').is(':checked') ? 'Y' : 'N'}
        $.ajax({
            type: 'POST',
            url: '<?= $this->Url->build(['prefix' => 'Hr', 'controller' => 'Assignments','action' => 'knowing']); ?>',
            data: formData,
            // processData: false,
            // contentType: false,
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            success: function (response) {
                if (response.status === true) {
                    SwalHelper.success('Data berhasil disimpan', 'Berhasil', 1500).then(() => {
                        window.location.href = '<?= $this->Url->build([
                            'prefix' => 'Hr',
                            'controller' => 'Assignments',
                            'action' => 'index'
                        ]) ?>';
                    });
                } else {
                    let errorMsg = '';
                    if (response.errors) {
                        for (const key in response.errors) {
                            if (response.errors.hasOwnProperty(key)) {
                                if (Array.isArray(response.errors[key])) {
                                    errorMsg += response.errors[key].join('<br>') + '<br>';
                                } else {
                                    errorMsg += response.errors[key] + '<br>';
                                }
                            }
                        }
                    } else {
                        errorMsg = 'Terjadi kesalahan yang tidak diketahui.';
                    }
                    SwalHelper.error(errorMsg, 'Gagal menyimpan');
                }
            },
            error: function () {
                SwalHelper.error('Terjadi kesalahan saat menyimpan data.', 'Error');
            }
        });
    }
    });
}
</script>