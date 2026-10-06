<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Absence[]|\Cake\Collection\CollectionInterface $absences
 */
?>
<?= $this->Krs->breadcrumb('HRGA', 'List Absensi', 'Tampilkan') ?>
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
                <div class="btn-group">
                    <a href="javascript:void(0);" id="btnDownloadExcel" class="btn btn-lime">
                        <i class="fa fa-download"></i> Download Excel
                    </a>
                </div>

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
                        <?= $this->Form->control('inout_mode', [
                            'label' => false, 
                            'options' => ['I' => 'Masuk', 'O' => 'Keluar'],
                            'empty' => 'Pilih Mode',
                            'id'    => 'inout_mode',
                            'class' => 'form-control select2', 
                            'value' => $this->request->getQuery('inout_mode')]); ?>
                    </div>
                    <!-- <div class="col-md-2">
                        <?= $this->Form->control('expression', [
                            'label' => false,
                            'options' => ['H' => 'Senang', 'I' => 'Biasa Saja'],
                            'empty' => 'Pilih Kondisi',
                            // 'placeholder' => 'Cari kondisi',
                            'id'    => 'expression',
                            'class' => 'form-control select2', 
                            'value' => $this->request->getQuery('expression')]); ?>
                    </div> -->
                    <div class="col-md-2">
                        <?= $this->Form->control('date_range', [
                            'type' => 'text',
                            'label' => false,
                            'id'    => 'date_range',
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
                <table class="table table-hover table-td-valign-middle data-absences">
                    <!--Bagian Header Table-->
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="">Nama</th>
                            <th width="">Tanggal</th>
                            <th width="">In/Out</th>
                            <th width="">Jam Masuk</th>
                            <th width="">Jam Keluar</th>
                            <th width="">Latitude</th>
                            <th width="">Longitude</th>
                            <th width="">Alamat</th>
                            <!-- <th width="">Lokasi</th> -->
                            <!-- <th width="">Kondisi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mapsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapsTitle">Lokasi</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height:500px; overflow-y:auto;">
        <iframe id="mapsFrame"
                width="100%"
                height="400"
                style="border:0;"
                loading="lazy">
        </iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>
<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'Absences', 'action' => 'view', '_full' => true]);
?>

<script>
    $(document).ready(function() {
        $('.data-absences').DataTable();
        $('.select2').select2({
            allowClear: true
        });
        searchhistory();
        const start = moment();
        const end = moment();   

        $('.daterange').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        // Tombol download Excel pakai filter aktif
    $('#btnDownloadExcel').on('click', function () {
        const dateRange = $('.daterange').val();
        let start_date = '';
        let end_date = '';

        if (dateRange) {
            [start_date, end_date] = dateRange.split(' - ').map(s => s.trim());
        }

        const params = {
            name: $('#name').val() || '',
            start_date: start_date || '',
            end_date: end_date || '',
            expression: $('#expression').val() || '',
            inout_mode: $('#inout_mode').val() || ''
        };

        const url = '<?= $this->Url->build(["prefix" => 'Hr', "controller" => "Absences", "action" => "excel"]) ?>?' + $.param(params);

        // buka langsung link untuk download
        window.location.href = url;
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
            expression: $('#expression').val(),
            inout_mode: $('#inout_mode').val(),
            // lead: $('#lead').val(),
            // types_id: $('#types').val()
        };
// console.log(filters);
    // SwalHelper.loading();

    $.ajax({
        url: '<?= $this->Url->build(["prefix" => 'Hr', "controller" => "Absences", "action" => "getHistory"]) ?>',
        method: 'GET',
        data: filters,
        dataType: 'json',
        success: function (res) {
            // console.log(res.data);
             loadHistoryData(res.data);
            // Swal.close(); 
        },
        error: function () {
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Gagal',
            //     text: 'Terjadi kesalahan saat mengambil data.'
            // });
        }
    });
}


function loadHistoryData() {
    const table = $('.data-absences').DataTable({
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
            url: '<?= $this->Url->build(["prefix" => 'Hr', "controller" => "Absences", "action" => "getHistory"]) ?>',
            type: 'GET',
            data: function (d) {
                const dateRange = $('.daterange').val();
                let start_date = '';
                let end_date = '';

                if (dateRange) {
                    [start_date, end_date] = dateRange.split(' - ').map(s => s.trim());
                }

                d.name = $('#name').val();
                d.expression = $('#expression').val();
                d.inout_mode = $('#inout_mode').val();
                d.start_date = start_date;
                d.end_date = end_date;
            }
        },
        columns: [
            {
                data: 'user.name',
                render: function (data) {
                    return data ?? '-';
                }
            },
            {
                data: 'date',
                render: function (data) {
                    if (!data) return '-';
                    const d = new Date(data);
                    return `${String(d.getDate()).padStart(2, '0')}-${String(d.getMonth() + 1).padStart(2, '0')}-${d.getFullYear()}`;
                }
            },
            {
                data: 'inout_mode',
                render: function (data, type, row) {
                    // console.log(data);
                    const statusOptions = {
                        'I': 'Masuk',
                        'O': 'Keluar',
                        'D': 'Dinamis'
                    };
                    let result = statusOptions[data] ?? 'Tidak diketahui';
                    if (row.conditions && row.conditions.trim() !== '') {
                        result += `<br>(${row.conditions})`;
                    }

                    return result;
                }
            },
            {
                data: 'time_in',
                render: function (data, type, row) {
                    if (!data) return '-';
                    const timezone = row.zona ?? 'WIB';
                    return `${data} (${timezone})`;
                }
            },
            {
                data: 'time_out',
                render: function (data, type, row) {
                    if (!data) return '-';
                    const timezone = row.zona ?? 'WIB';
                    return `${data} (${timezone})`;
                }
            },
            {
                data: 'latitude',
                render: function (data) {
                    return data ?? '-';
                }
            },
            {
                data: 'longitude',
                render: function (data) {
                    return data ?? '-';
                }
            },
            {
                data: null,
                render: function (row) {
                    if (row.latitude && row.longitude) {
                        const addressText = row.address ?? 'Lihat Lokasi';

                        return `
                            <a href="#" 
                            class="open-maps" 
                            data-latitude="${row.latitude}" 
                            data-longitude="${row.longitude}"
                            data-address="${addressText}">
                            📍 ${addressText}
                            </a>
                        `;
                    }
                    return '-';
                }
            },
            // {
            //     data: null,
            //     render: function (row) {
            //         if (row.latitude && row.longitude) {
            //             const mapsLink = `https://www.google.com/maps?q=${row.latitude},${row.longitude}`;
            //             const addressText = row.address ?? 'Lihat Lokasi';

            //             return `📍<a href="${mapsLink}" target="_blank">${addressText}</a>`;
            //         }
            //         return '-';
            //     }
            // },
            // {
            //     data: 'location',
            //     render: function (data) {
            //         if (data && data !== '-') {
            //             return `📍<a href="${data}" target="_blank">Lihat Lokasi</a>`;
            //         }
            //         return '-';
            //     }
            // },
            // {
            //     data: 'expression',
            //     render: function (data) {
            //         const statusOptions = {
            //             'H': 'Senang',
            //             'I': 'Biasa Saja'
            //         };
            //         return statusOptions[data] ?? 'Tidak diketahui';
            //     }
            // }
        ],
        // createdRow: function (row, data, dataIndex) {
        //     if (data.time_in) {
        //         const limit = '08:00:00';

        //         if (data.time_in > limit) {
        //             $(row).css('background-color', '#ffcccc');
        //         }
        //     }
        // }
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

    $(document).on('click', '.open-maps', function (e) {
        e.preventDefault();

        const lat = $(this).data('latitude');
        const lng = $(this).data('longitude');
        const address = $(this).data('address');

        const mapsUrl = `https://www.google.com/maps?q=${lat},${lng}&output=embed`;

        $('#mapsFrame').attr('src', mapsUrl);
        $('#mapsTitle').text(`Lokasi: ${address}`);
        $('#mapsModal').modal('show');
    });
}
</script>