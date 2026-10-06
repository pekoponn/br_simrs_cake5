<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkOrder[]|\Cake\Collection\CollectionInterface $workOrders
 */
?>
<?= $this->Krs->breadcrumb('Data', 'Surat Perintah Kerja Lembur', 'Tampilkan') ?>
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                    </div>
                </div>
            </div>
            <br>
            <!--Bagian Search-->
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-dark text-white">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('code', [
                            'label' => false,
                            'placeholder' => 'Masukkan Nomor Surat',
                            'id' => 'nomorSuratSearch',
                            'class' => 'form-control',
                            'type' => 'text'
                        ]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('businessUnitSearch', [
                            'type' => 'select',
                            'label' => false,
                            'id'    => 'businessUnitSearch',
                            'class' => 'form-control select2',

                            'options' => $this->Krs->dataUbs(),
                            'empty' => '-- Pilih UBS --'
                        ]); ?>    
                    </div> 
                    <div class="col-md-2">
                        <?= $this->Form->control('date_range', [
                            'type' => 'text',
                            'label' => false,
                            'placeholder' => 'Pilih Rentang Tanggal',
                            'id'    => 'date_range',
                            'class' => 'form-control daterange'
                        ]); ?>    
                    </div>   
                    <div class="col-md-2">
                        <button type="button" class="btn btn-warning" onclick="searchHistory()">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>                
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle data-spkl">
                    <!--Bagian Header Table-->
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="">Nomor Surat</th>
                            <th width="">UBS</th>
                            <th width="">Tanggal Surat</th>
                            <th width="">Deskripsi</th>
                            <th width="">Approve</th>
                            <th class="actions text-center" width="170"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPreviewSpkl" tabindex="-1" role="dialog" aria-labelledby="previewSpklLabel">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="previewSpklLabel">Detail SPKL</h5>
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
                <div class="col-sm-3 font-weight-bold">Nomor Surat:</div>
                <div class="col-sm-4" id="previewCode">-</div>
                <div class="col-sm-2 font-weight-bold">Cabang:</div>
                <div class="col-sm-3" id="previewBusinessUnit">-</div>
            </div>
            <div class="row mb-2 row-aset">
                <div class="col-sm-3 font-weight-bold">Tanggal Surat :</div>
                <div class="col-sm-4" id="previewDate">-</div>
                <!-- <div class="col-sm-2 font-weight-bold">Kode Aset:</div>
                <div class="col-sm-3" id="previewKodeAset">-</div> -->
            </div>
            <hr>
            <div class="row mb-2">
                <div class="col-sm-3 font-weight-bold">Deskripsi:</div>
                <div class="col-sm-9" id="previewDescription">-</div>
            </div>
            <hr>
            <div class="row mb-2">
                <div class="col-sm-12">
                    <strong>Rincian Tugas</strong>
                    <table class="table table-bordered table-sm mt-2" id="previewTasksTable">
                        <thead>
                            <tr class="text-center thead-dark">
                                <th width="25%">Nama</th>
                                <th width="15%">Jam Mulai</th>
                                <th width="15%">Jam Akhir</th>
                                <th width="40%">Rincian Tugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi lewat JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row text-center">
                <div class="col-sm-6">
                    <div>
                        <strong>Dibuat Oleh</strong>
                    </div>
                    <div id="previewActionCreated">-</div>
                </div>
                <div class="col-sm-6">
                    <div>
                        <strong>Menyetujui</strong>
                    </div>
                    <div id="previewApproved">-</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal cancel help desk -->
 <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center">
                <form id="cancelForm">
                    <?= $this->Form->control('is_cancel', ['type' => 'hidden', 'value' => $getUser->id]); ?> 
                    <?= $this->Form->control('id', [
                        'type' => 'hidden',
                        'id' => 'workOrderCanceled'
                    ]); ?>
                    <?= $this->Form->control('canceled', [
                        'type' => 'hidden',
                        'id' => 'CanceledWorkOrder',
                        'value' => ''
                    ]); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= $this->Form->control('cancel_reason', [
                                'label' => 'Alasan Pembatalan',
                                'class' => 'form-control',
                                'required' => true,
                                'attr' => ['rows' => 3, 'maxlength' => 500]
                            ]); ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitCancel()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
let table;
$(document).ready(function() {
    const baseUrl = '<?= $this->Url->build(["prefix" => "Hr", "controller" => "WorkOrders"]) ?>';

    $('.data-spkl').DataTable();
    // searchHistory();
    $(document).on('click', '.btn-delete-spkl', function() {
        var id = $(this).data('id');
        if (confirm('Yakin ingin menghapus data ini?')) {
            $.ajax({
                url: `${baseUrl}/delete/${id}`,
                type: 'POST',
                headers: {'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')},
                success: function(res) {
                    searchHistory(); // reload data setelah delete sukses
                },
                error: function() {
                    alert('Gagal menghapus data.');
                }
            });
        }
    });
    $(document).on('click', '.btn-approve', function() {
        const id = $(this).data('id');
        const approveUrl = '<?= $this->Url->build(["prefix" => "Hr", "controller" => "WorkOrders", "action" => "approve"]) ?>/' + id;
        
        window.location.href = approveUrl;
    });

    $('.select2').select2({
        allowClear: true,
        closeOnSelect: true,
        // width: '100%'
    });

    const start = moment().startOf('month');  
    const end = moment().endOf('month'); 
    
    $('.daterange').daterangepicker({
        autoUpdateInput: false,
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });

    datePickerReset('input-daterange', 'resetDate', 'tanggal', 'dd-mm-yyyy');

    loadHistoryData(); // Jalankan setelah semua picker disiapkan
});

function searchHistory() {
    $('.data-spkl').DataTable().ajax.reload();
}

function loadHistoryData(){
    const table = $('.data-spkl').DataTable({
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
        searching: true , 
        scrollX: true,
        ajax: {
            url: '<?= $this->Url->build(["prefix" => "Hr", "controller" => "WorkOrders", "action" => "getHistory"]) ?>',
            type: 'GET',
            data: function (d) {
                const dateRange = $('.daterange').val();
                let start_date = '';
                let end_date = '';
                if (dateRange) {
                    [start_date, end_date] = dateRange.split(' - ').map(s => s.trim());
                }
                
                d.nomorSuratSearch = $('#nomorSuratSearch').val();
                d.businessUnitSearch = $('#businessUnitSearch').val();
                // d.NamaCabangSearch = $('#NamaCabangSearch').val();
                // d.NamaAreaSearch = $('#NamaAreaSearch').val();
                d.start_date = start_date;
                d.end_date = end_date;
            }
            // console.log(data)    
        },
        columns: [
            // {
            //     data: 'code',
            //     className: 'text-center'
            // },
            {
                data: 'code',
                className: 'text-center',
                render: function (data, type, row) {

                    // kalau dibatalkan
                    if (row.is_cancel > 0) {
                        return `
                            <div class="text-center">
                                <strong style="color:red;">${data ?? '-'}</strong>
                                <span style="color:red;"> ⇒ Batal</span><br>
                                <small>${row.cancel_user?.name ?? '-'}</small>
                                <small>(${row.canceled ? formatDate(row.canceled) : '-'})</small><br>
                                <small>${row.cancel_reason ?? '-'}</small>
                            </div>
                        `;
                    }

                    // normal
                    return data ?? '-';
                }
            },

            // 2. Cabang
            {
                data: 'business_unit',
                className: 'text-center'
            },

            // 3. Tanggal Surat
            {
                data: 'date',
                className: 'text-center',
                render: function (data) {
                    return data
                        ? moment(data).format('DD-MM-YYYY')
                        : '-';
                }
            },

            // 4. Deskripsi
            {
                data: 'description',
                defaultContent: '-'
            },
            // {
            //     data: null,
            //     className: 'text-center',
            //     render: function (data, type, row) {

            //         // PRIORITAS 1: CANCEL
            //         if (row.is_cancel > 0) {
            //             return `
            //                 <div class="text-center">
            //                     <span style="color:red;">❌</span><br>
            //                     <small>${row.cancel_user?.name ?? '-'}</small><br>
            //                     <small>${formatDate(row.canceled) ?? '-'}</small><br>
            //                     <small>${row.cancel_reason ?? '-'}</small>
            //                 </div>
            //             `;
            //         }

            //         // APPROVED
            //         if (row.status_approve === 'Y') {
            //             return `
            //                 <div class="text-center">
            //                     <span style="color:green;">✔️</span><br>
            //                     <small>${row.approve_user?.name ?? '-'}</small><br>
            //                     <small>${formatDate(row.approved)}</small>
            //                 </div>
            //             `;
            //         }

            //         // REJECTED
            //         if (row.status_approve === 'N') {
            //             return `
            //                 <div class="text-center">
            //                     <span style="color:red;">❌</span><br>
            //                     <small>${row.approve_user?.name ?? '-'}</small><br>
            //                     <small>${formatDate(row.approved)}</small>
            //                 </div>
            //             `;
            //         }

            //         // PENDING
            //         return `
            //             <div class="text-center">
            //                 <span style="color:gray;">⏳</span><br>
            //                 <small>-</small><br>
            //                 <small>-</small>
            //             </div>
            //         `;
            //     }
            // },
            {
                data: null,
                className: 'text-center',
                render: function (data, type, row) {
                    if (row.status_approve === 'Y') {
                        return `
                            <div class="text-center">
                                <span style="color:green;">✔️</span><br>
                                <small>${row.approve_user?.name ?? '-'}</small><br>
                                <small>${formatDate(row.approved)}</small>
                            </div>
                        `;
                    } else if (row.status_approve === 'N') {
                        return `
                            <div class="text-center">
                                <span style="color:red;">❌</span><br>
                                <small>${row.approve_user?.name ?? '-'}</small><br>
                                <small>${formatDate(row.approved)}</small>
                            </div>
                        `;
                    } else {
                        return `
                            <div class="text-center">
                                <span style="color:gray;">⏳</span><br>
                                <small>-</small><br>
                                <small>-</small>
                            </div>
                        `;
                    }
                }
            },

            // 5. Actions
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    let btn = `
                        <button class="btn btn-sm btn-warning btn-preview" data-id="${row.id}">
                            <i class="fas fa-desktop"></i>
                        </button>
                    `;

                    if (row.is_approve == 0 && row.is_cancel == 0) {
                        btn += `
                            <button class="btn btn-sm btn-success btn-approve" 
                                    data-id="${row.id}" 
                                    title="Approve">
                                <i class="fas fa-check"></i>
                            </button>
                        `;
                        btn += `
                            <button class="btn btn-sm btn-danger btn-cancel" data-id="${row.id}">
                                <i class="fas fa-ban"></i>
                            </button>
                        `;
                    }

                    return btn;
                }
            }
        ],
    });
    $('#nomorSuratSearch, #businessUnitSearch, .daterange').on('change', function () {
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

function formatDate(date) {
    if (!date) return '-';
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    return `${day}-${month}-${year}`;
}


$(document).on('click', '.btn-preview', function () {  
    const id = $(this).data('id');
    const rawData = $('.data-spkl').DataTable().data().toArray();
    const masterData = rawData.find(item => item.id === id && !item.isDetail);
    // console.log('masterData', masterData);

    if (!masterData) return;

    // Set header details
    // $('#previewName').text(masterData.is_create_user?.name || '-');
    // $('#previewCreated').text(masterData.created || '-');
    $('#previewCode').text(masterData.code || '-');
    $('#previewBusinessUnit').text(masterData.business_unit || '-');
    $('#previewDate').text(masterData.date ? moment(masterData.date).format('DD-MM-YYYY') : '-');
    $('#previewDescription').text(masterData.description || '-');
       
    $('#previewActionCreated').html(() => {
        const name = masterData.create_user?.name || '-';
        const date = masterData.created 
            ? moment(masterData.created).format('DD-MM-YYYY') 
            : '-';
        return `${name} <br> (${date})`; // Gabungkan nama dan tanggal
    });

    $('#previewApproved').html(() => {
        const status = masterData.status_approve;
        const name = masterData.approve_user?.name || '-';
        const date = masterData.approved 
            ? moment(masterData.approved).format('DD-MM-YYYY') 
            : '-';
    
        let statusIcon = '';
        if (status == 'Y') {
            statusIcon = '<span style="color:green;">✔️</span>';
        } else if (status == 'N') {
            statusIcon = '<span style="color:red;">❌</span>';
        } else {
            statusIcon = '⏳';
        }
    
        return `${statusIcon} <br> ${name} <br> (${date})`;
    }); 
    const tbody = $('#previewTasksTable tbody');
    tbody.empty(); // Kosongkan dulu

    if (masterData.work_order_lines && masterData.work_order_lines.length > 0) {
        masterData.work_order_lines.forEach(line => {
            tbody.append(`
                <tr>
                    <td class="text-center">${line.user?.name || '-'}</td>
                    <td class="text-center">${line.time_from ? moment(line.time_from, 'HH:mm:ss').format('HH:mm') : '-'}</td>
                    <td class="text-center">${line.time_end ? moment(line.time_end, 'HH:mm:ss').format('HH:mm') : '-'}</td>
                    <td>${line.task || '-'}</td>
                </tr>
            `);
        });
    } else {
        tbody.append(`
            <tr>
                <td colspan="4" class="text-center">Tidak ada data tugas</td>
            </tr>
        `);
    }
    $('#modalPreviewSpkl').modal('show');
});

$('.data-spkl').on('click', '.btn-cancel', function () {
    const id = $(this).data('id');

    $.ajax({
        url: '<?= $this->Url->build(["prefix" => "Hr", "controller" => "WorkOrders", "action" => "cancel"]) ?>/' + encodeURIComponent(id),
         method: 'GET',
         dataType: 'json',
        success: function(response) {
            const data = response.data;
            $('#workOrderCanceled').val(response.data.id);

            const $modal = $('#cancelModal');

            // // debugging singkat
            // console.log('#cancelModal count=', $('body').find('#cancelModal').length);
            // console.log('parents hidden count=', $modal.parents().filter(function(){ return $(this).is(':hidden'); }).length);
            // console.log('computed:', {
            //     display: $modal.css('display'),
            //     visibility: $modal.css('visibility'),
            //     opacity: $modal.css('opacity'),
            //     zIndex: $modal.css('z-index')
            // });

            $modal.appendTo('body');

            try {
                $modal.modal('show');
            } catch (err) {
                console.error('modal show error', err);
            }

          
            setTimeout(() => {
                if (!$modal.is(':visible')) {
                    $modal.addClass('show').css({ display: 'block', visibility: 'visible' });
                    if ($('.modal-backdrop').length === 0) {
                        $('<div class="modal-backdrop fade show"></div>').appendTo(document.body);
                    }
                    // pastikan z-index tinggi
                    $modal.css('z-index', 1060);
                }
            }, 80);
        },
        error: function(xhr) {
            alert('Gagal mengambil data');
            // console.error(xhr.responseText);
        }
    });
});
function valid(){
    // support textarea or input
    var alasanCancel = $('textarea[name="cancel_reason"], input[name="cancel_reason"]').val();
    if (!alasanCancel || !alasanCancel.trim()) {
        SwalHelper.warning("Alasan harus diisi!");
        return false;
    }
    return true;
}
async function submitCancel() {
    if (!valid()) {
        return;
    }
    SwalHelper.confirm('Apakah Anda yakin ingin menyimpan?', '', 'Ya, simpan', 'Batal')   
    .then((result) => {
        if (result.isConfirmed) {
            const form = $('#cancelForm')[0];
            const formData = new FormData(form);
        for (var pair of formData.entries()) {
        // console.log(pair[0] + ':', pair[1]);
    }

            $.ajax({
                type: 'POST',
                url: '<?= $this->Url->build(['prefix' => 'Hr', 'controller' => 'WorkOrders','action' => 'cancel']); ?>',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                success: function (response) {
                    if (response.status === true) {
                        SwalHelper.success('Data berhasil disimpan', 'Berhasil', 1500).then(() => {
                            window.location.href = '<?= $this->Url->build([
                                'prefix' => 'Hr',
                                'controller' => 'WorkOrders',
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