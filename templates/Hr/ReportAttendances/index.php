<?= $this->Krs->breadcrumb('Evaluasi Mapping', 'Report Evaluasi Penilaian', 'Tampilkan') ?>
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="panel-body bg-dark">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->control('date_range', [
                            'type' => 'text',
                            'label' => false,
                            'id'    => 'date_range',
                            'class' => 'form-control daterange'
                        ]); ?>    
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('user_id', [
                            'label' => false,
                            'id'    =>'user_id',
                            'class' => 'form-control users',
                            'data-placeholder' => 'Cari Nama Pegawai ...',
                            'empty' => 'Cari Nama Pegawai ...',
                            'options' => []
                        ]); ?>   
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-warning" id="btnSearch">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportExcel()">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>   
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered data-table" >
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama Pegawai</th>
                        <th>Hadir (Hari)</th>
                        <th>Hadir (Sudah Terpotong)</th>
                        <th>Terlambat (0-10 Menit)</th>
                        <th>Terlambat (&gt;10 Menit)</th>
                        <th>Lembur (Jam)</th>
                        <th>Ijin Tidak Masuk</th>
                        <th>Cuti</th>
                        <th>Keluar Sementara</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'ReportAttendances', 'action' => 'view', '_full' => true]);
?>
<script>
let table;
const viewUrlBase = '<?= $this->Url->build(["prefix" => 'Hr', "controller" => "ReportAttendances", "action" => "view"]) ?>';
$(document).ready(function() {
    $(document).on('click', '.btn-view-idea', function() {
        const userId    = $(this).data('id');
        const startDate = $(this).data('start');
        const endDate   = $(this).data('end');
        if (!userId) return;

        const url = `${viewUrlBase}/${userId}?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
        $('#modal-detail').load(url, function () {
            $('#modal-detail').modal('show');
        });
    });
    $('.select2Form').select2({
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

    $('.users').select2({
        placeholder: 'Masukkan 2 digit huruf dari Nama Pegawai',
        allowClear: true,
        width: '100%',
        minimumInputLength: 2, 
        ajax: {
            url: '<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Users','action' => 'getUsers']); ?>',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            id: item.id,
                            text: item.name
                        }
                    })
                };
            }
        }
    });    
    
    BindDataTable();
});

function BindDataTable(){
    // Initialize empty DataTable first
    table = $('.data-table').DataTable({
        processing: true,
        serverSide: false,
        data: [],
        columns: [
            {
                data: null,
                render: function(data, type, row, meta){
                    return meta.row + 1;
                }
            },
            { data: 'name', defaultContent: '-' },
            { data: 'hadir', defaultContent: 0 },
            { data: "hadir_terpotong", defaultContent: 0 },
            { data: "terlambat", defaultContent: 0 },
            { data: "terlambat_lebih", defaultContent: 0 },
            { data: 'lembur', defaultContent: 0 },
            { data: 'ijin', defaultContent: 0 },
            { data: 'cuti', defaultContent: 0 },
            { data: 'permisi', defaultContent: 0 },
            { data: null, defaultContent: '', orderable: false, searchable: false}
        ]
    });

    $('#btnSearch').on('click', function () {
        const [start_date, end_date] = $('.daterange').val().split(' - ').map(s => s.trim());
        const users = $('.users').val();
        
        if (table) {
            table.destroy();
        }
        
        table = $('.data-table').DataTable({
            // dom: 'Blfrtip',
            buttons: false,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '<?= $this->Url->build(["prefix" => 'Hr', "controller" => "ReportAttendances", "action" => "getReport"]) ?>',
                type: 'GET',
                data: function(d) {
                    d.start_date = start_date;
                    d.end_date = end_date;
                    d.users = users;
                    return d;
                }
            },
            columns: [
                {
                    data: null,
                    className: "dt-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "name",
                    defaultContent: "-"
                },
                {
                    data: "hadir",
                    defaultContent: 0
                },
                {   data: "hadir_terpotong",
                    defaultContent: 0 
                },
                {
                    data: "terlambat",
                    defaultContent: 0
                },
                {
                    data: "terlambat_lebih",
                    defaultContent: 0
                },
                {
                    data: "lembur",
                    defaultContent: 0
                },
                {
                    data: "ijin",
                    defaultContent: 0
                },
                {
                    data: "cuti",
                    defaultContent: 0
                },
                {
                    data: "permisi",
                    defaultContent: 0
                },
                {
                    data: null,
                    className: "dt-center",
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning m-1 btn-view-idea" data-id="${row.id}" data-start="${start_date}" data-end="${end_date}" title="View Detail">
                                <i class="fa fa-desktop"></i>
                            </a>
                        `;
                    }
                }
            ]
        });
    });
}

function exportExcel() {
    const dateRange = $('.daterange').val();
    const users = $('.users').val();

    let start_date = '';
    let end_date = '';

    if (dateRange) {
        [start_date, end_date] = dateRange.split(' - ').map(s => {
            const [day, month, year] = s.trim().split('-');
            return `${year}-${month}-${day}`;
        });
    }

    const params = new URLSearchParams({
        start_date: start_date,
        end_date: end_date
    });

    if (users) {
        params.append('users', users);
    }

    window.location.href =
        '<?= $this->Url->build([
            "controller" => "ReportAttendances",
            "action" => "excel"
        ]); ?>?' + params.toString();
}
</script>
