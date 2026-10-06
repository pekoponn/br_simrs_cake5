<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AbsenceIssue[]|\Cake\Collection\CollectionInterface $absences
 */
?>
<meta name="csrfToken" content="<?= $this->request->getAttribute('csrfToken') ?>">
<?= $this->Krs->breadcrumb('HRGA', 'Laporan Pengaduan Absensi', 'Tampilkan') ?>
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <!-- <div class="btn-group">
                    <div class="portlet-body">
                    </div>
                </div> -->
                <!-- <div class="btn-group dropdown">
                    <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                    <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'excel']); ?>">Excel</a>
                        <a class="dropdown-item" href="javascript:void(0);" id="btnDownloadExcel">Excel</a>
                    </div>
                </div> -->
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
                    <!-- <div class="col-md-2">
                        <?= $this->Form->control('filterUser', [
                            'label' => false, 
                            'type' => 'text',
                            'placeholder' => 'Cari nama karyawan',
                            'id'    => 'name',
                            'class' => 'form-control ', 
                            'value' => $this->request->getQuery('filterUser')]); ?>
                    </div> -->
                    <div class="col-md-3">
                        <?= $this->Form->control('date_range', [
                            'type' => 'text',
                            'label' => false,
                            'id'    => 'date_range',
                            'placeholder' => 'Pilih rentang tanggal pengaduan',
                            'class' => 'form-control daterange'
                        ]); ?>    
                    </div>   
                    <div class="col-md-1">
                        <button type="button" class="btn btn-warning" onclick="searchhistory()">
                            <i class="fa fa-search"></i>
                        </button>   
                    </div>                
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle data-absenceIssues">
                    <!--Bagian Header Table-->
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="50">No</th>
                            <th width="150">Tanggal Pengaduan</th>
                            <th width="350">Deskripsi</th>
                            <th width="200">Lampiran</th>
                            <th width="150">Status</th>
                            <th width="150">Action</th>
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
<div class="modal fade" id="modalPreviewAbsences" tabindex="-1" role="dialog" aria-labelledby="previewAbsencesIssues">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="previewAbsencesIssues">Detail Laporan Absensi</h5>
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
                        <div class="col-sm-3 font-weight-bold">Tanggal Pengaduan:</div>
                        <div class="col-sm-4" id="previewCreated">-</div>
                    <!-- <div class="col-sm-3 font-weight-bold">Lampiran:</div>
                    <div class="col-sm-9" id="previewTembusan">-</div> -->
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3 font-weight-bold">Lampiran:</div>
                        <div class="col-sm-4" id="previewLampiran">-</div>
                    </div>
                    <hr>
                    <div class="row mb-2">    
                        <div class="col-sm-3 font-weight-bold">Deskripsi:</div>
                        <div class="col-sm-9" id="previewDeskripsi">-</div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <div>
                                <strong>Dibuat</strong>
                            </div>
                            <div id="previewDibuat">-</div>
                        </div>
                        <div class="col-sm-6 ">
                            <div>
                                <strong>Selesai</strong>
                            </div>
                            <div id="previewSelesai">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Status dengan 2 Emoji -->
<div class="modal fade" id="statusConfirmModal" tabindex="-1" role="dialog" aria-labelledby="statusConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="statusConfirmLabel">Konfirmasi Status</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Apakah pengaduan ini sudah diselesaikan?</p>
                <input type="hidden" name="user_id" value="<?= $getUser->id ?>">
                <div class="row justify-content-center">
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-success btn-lg btn-confirm-status" data-status="Y" data-id="">
                            <i class="fas fa-check-circle fa-2x"></i><br>
                            <span class="mt-2 d-block">Ya (Y)</span>
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <button type="button" class="btn btn-danger btn-lg btn-confirm-status" data-status="N" data-id="">
                            <i class="fas fa-times-circle fa-2x"></i><br>
                            <span class="mt-2 d-block">Tidak (N)</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div> -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.data-absenceIssues').DataTable();
        $('.select2').select2({
            allowClear: true
        });
        searchhistory();
        // const start = moment();
        // const end = moment();   

        $('.daterange').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

    });
    function searchhistory() {
        const dateRange = $('.daterange').val();

        let start_date = '';
        let end_date = '';

        if (dateRange) {
            [start_date, end_date] = dateRange.split(' - ').map(s => s.trim());
        }

        const filters = {
            name: $('#name').val(),
            start_date: start_date,
            end_date: end_date,
        };

    $.ajax({
        url: '<?= $this->Url->build(["prefix" => false, "controller" => "AbsentIssues", "action" => "getHistory"]) ?>',
        method: 'GET',
        data: filters,
        dataType: 'json',
        success: function (res) {
            // console.log(res.data);
             loadHistoryData(res.data);
            // Swal.close(); 
        },
        error: function () {
        }
    });
}


function loadHistoryData() {
    const table = $('.data-absenceIssues').DataTable({
        // dom: 'Blfrtip',
        // buttons: ['excelHtml5'],
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
            url: '<?= $this->Url->build(["prefix" => false, "controller" => "AbsentIssues", "action" => "getHistory"]) ?>',
            type: 'GET',
            data: function (d) {
                const dateRange = $('.daterange').val();
                let start_date = '';
                let end_date = '';

                if (dateRange) {
                    [start_date, end_date] = dateRange.split(' - ').map(s => s.trim());
                }
                d.start_date = start_date;
                d.end_date = end_date;
            }
        },
        columns: [
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'is_create_user.name',
                className: 'text-center',
                render: function (val, type, row) {
                    const name = val || '-';
                    const createdDate = row.created
                        ? moment(row.created).format('DD-MM-YYYY')
                        : '-';

                    return `
                        <div class="text-center">
                            <strong>${name}</strong><br>
                            <small class="text-muted">${createdDate}</small>
                        </div>
                    `;
                }
            },
            {
                data: 'description',
                render: function(data) {
                    return data ?? '-';
                }
            },
            {
                data: null,
                orderable: false,
                className: 'text-center',
                render: function (data) {
                    let files = [];
                    for (let i = 1; i <= 2; i++) {
                        const key = `file_${i}`;
                        if (data[key]) {
                            const fileUrl = `<?= $this->Url->assetUrl('files/') ?>${data[key]}`;
                            files.push(`
                                <a href="${fileUrl}" data-lightbox="lampiran" style="margin:2px;display:inline-block;">
                                    <img src="${fileUrl}" alt="Dokumentasi" style="max-width:48px;max-height:48px;border:1px solid #ccc;">
                                </a>
                            `);
                        }
                    }

                    return files.length ? files.join('<br>') : '-';
                }
            },
            {
                data: 'is_done_user.name',
                className: 'text-center',
                render: function (val, type, row) {
                    const name = val || '-';
                    const donedDate = row.doned
                        ? moment(row.doned).format('DD-MM-YYYY')
                        : '-';

                    let icon = '<i class="fas fa-hourglass-half text-secondary fs-5"></i>'; // default jam pasir
                    if (row.status === 'Y') icon = '<i class="fas fa-check-circle text-success fs-5"></i>';
                    else if (row.status === 'N') icon = '<i class="fas fa-times-circle text-danger fs-5"></i>';
                    return `
                        <div class="text-center">
                            ${icon}<br>
                            <strong>${name}</strong><br>
                            <small class="text-muted">${donedDate}</small>
                        </div>
                    `;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    const baseUrl = '<?= $this->Url->build(["controller" => "AbsentIssues"]) ?>';
                    let buttons = `
                        <button class="btn btn-sm btn-warning btn-preview m-1" data-id="${row.id}" title="Preview">
                            <i class="fas fa-desktop"></i>
                        </button>`;
                    if(row.is_done == 0){
                        buttons += `
                            <button class="btn btn-sm btn-success btn-status m-1" data-id="${row.id}" title="done">
                                <i class="fas fa-check"></i>
                            </button>`;
                    }
                    return buttons;
                }
            }
        ]
    });

    // Reload tabel saat filter berubah
    $('#name, #expression, #inout_mode, .daterange').on('change', function () {
        table.ajax.reload();
    });

    // Daterangepicker apply/cancel
    $('.daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table.ajax.reload();
    });

    $('.daterange').on('cancel.daterangepicker', function () {
        $(this).val('');
        table.ajax.reload();
    });
}

$(document).on('click', '.btn-preview', function () {  
    const id = $(this).data('id');
    const rawData = $('.data-absenceIssues').DataTable().data().toArray();
    const masterData = rawData.find(item => item.id === id && !item.isDetail);
    // console.log('masterData', masterData);

    if (!masterData) return;

    // Set header details
    $('#previewCreated').text(masterData.created ? moment(masterData.created).format('DD MMMM YYYY') : '-');
    $('#previewTanggal').text(masterData.date ? moment(masterData.date).format('DD MMMM YYYY') : '-');
    $('#previewLampiran').html(() => {
        let files = [];
        for (let i = 1; i <= 2; i++) {
            const key = `file_${i}`;
            if (masterData[key]) {
                const fileUrl = `<?= $this->Url->assetUrl('files/') ?>${masterData[key]}`;
                files.push(`
                    <a href="${fileUrl}" data-lightbox="lampiran" style="margin:2px;display:inline-block;">
                        <img src="${fileUrl}" alt="Dokumentasi" style="max-width:48px;max-height:48px;border:1px solid #ccc;">
                    </a>
                `);
            }
        }
        return files.length ? files.join('<br>') : '-';
    });
    $('#previewDeskripsi').html(masterData.description || '-');
    $('#previewDibuat').html(`
        <div class="text-center">
            <small>${masterData.is_create_user?.name ?? '-'}</small><br>
            <small>${formatDate(masterData.created)}</small>
        </div>
    `);

    // Menyetujui
    if (masterData.status === 'Y') {
        $('#previewSelesai').html(`
            <div class="text-center">
                <span style="color:green;">✔️</span><br>
                <small>${masterData.is_done_user?.name ?? '-'}</small><br>
                <small>${formatDate(masterData.doned)}</small>
            </div>
        `);
    } else if (masterData.status === 'N') {
        $('#previewSelesai').html(`
            <div class="text-center">
                <span style="color:red;">❌</span><br>
                <small>${masterData.is_done_user?.name ?? '-'}</small><br>
                <small>${formatDate(masterData.doned)}</small>
            </div>
        `);
    } else {
        $('#previewSelesai').html(`
            <div class="text-center">
                <span style="color:gray;">⏳</span><br>
                <small>-</small><br>
                <small>-</small>
            </div>
        `);
    }

    $('#modalPreviewAbsences').modal('show');
});
<?php $baseUrl = $this->Url->build(['controller' => 'AbsentIssues', 'action' => 'status']); ?>

$('.data-absenceIssues').on('click', '.btn-status', function () {
    const id = $(this).data('id');
    $('#statusConfirmModal .btn-confirm-status').data('id', id);
    $('#statusConfirmModal').modal('show');
});
// Event ketika klik tombol Ya (centang) atau Tidak (silang)
$(document).on('click', '.btn-confirm-status', function() {
    const id = $(this).data('id');
    const statusValue = $(this).data('status');
    $('#statusConfirmModal').modal('hide');
    // Kirim AJAX untuk update status
    $.ajax({
        url: '<?php echo $baseUrl; ?>',
        method: 'POST',
        headers: {
            'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
        },
        data: {
            id: id,
            status: statusValue
        },
        dataType: 'json',
        success: function(response) {
            if(response.status) {
                toastr.success('Status berhasil diupdate');
                $('.data-absenceIssues').DataTable().ajax.reload();
            } else {
                toastr.error(response.message || 'Gagal update status');
            }
        },
        error: function() {
            toastr.error('Terjadi kesalahan pada server');
        }
    });
});

function formatDate(date) {
    if (!date) return '-';
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}-${month}-${year}`;
}
</script>
