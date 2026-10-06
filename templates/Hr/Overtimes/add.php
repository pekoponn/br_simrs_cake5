<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Overtime $overtime
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Lembur', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>
<div class="panel panel-inverse">
    <?= $this->Krs->heading('Form Lembur'); ?>
    <?= $this->Form->create($overtime, ['id' => 'GroupAddForm']) ?>
    
    <div class="panel-body">
        <!-- Hidden fields -->
        <?= $this->Form->control('work_order_id', ['type' => 'hidden', 'value' => '']); ?>
        <?= $this->Form->control('is_create', ['type' => 'hidden', 'value' => '']); ?>
        
        <div class="panel-footer bg-dark p-t-10">
            <div class="row row-space-10">
                <div class="col-md-6">
                    <div class="form-group m-b-10">
                        <?= $this->Form->control('workOrderId', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nomor Surat...']); ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group m-b-10">
                        <?= $this->Form->button('Cari Data', ['class' => 'btn btn-orange width-80 m-r-5', 'type' => 'button', 'id' => 'dataWorkOrderSearch']); ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        
        <div class="table-responsive" style="overflow: auto; height: auto; background-color: #fff;">
            <table class="table table-striped table-hover dataWorkOrderIn">
                <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
                    <tr>
                        <th width="60" class="text-center">
                            <input type="checkbox" id="selectAllOrders" title="Pilih Semua">
                        </th>
                        <th class="text-center">Tanggal Surat</th>
                        <th>Nama</th>
                        <th class="text-center">Jam Mulai</th>
                        <th class="text-center">Jam Selesai</th>
                        <th class="text-center">Tugas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" colspan="6">Maaf, data tidak ditemukan...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="m-t-10 m-b-10">
            <button type="button" class="btn btn-success btn-sm" id="btnSelectChecked" style="display:none;">
                <i class="fas fa-check"></i> Pilih Data
            </button>
            <span class="text-muted info-ceklis" style="display:none;">Centang data lalu klik Pilih Data</span>
        </div>
        
        <hr>
        <h6>Data Lembur :</h6>
        <div class="table-responsive" style="overflow: auto; height: 400px; background-color: #fff;">
            <div class="col-md-12">
                <span class="text-muted">* Isi jam realisasi lembur sesuai dengan jam sebenarnya</span>
            </div>
            <br>
            <table class="table table-striped table-hover workOrderData">
                <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
                    <tr class="text-center">
                        <th rowspan="2" width="200" class="align-middle">Nama</th>
                        <th rowspan="2" width="200" class="align-middle">Tanggal Lembur</th>
                        <th colspan="2">Jam Estimasi</th>
                        <th rowspan="2" class="align-middle">Task</th>
                        <th colspan="2">Jam Realisasi</th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr class="text-center">
                        <th width="120">Jam Mulai</th>
                        <th width="120">Jam Selesai</th>
                        <th width="120">Jam Mulai</th>
                        <th width="120">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" colspan="7">Maaf, Data order kosong...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel-footer text-right bg-warning">
        <?= $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'id' => 'btn-add']); ?>
    </div>
    
    <?= $this->Form->end() ?>
</div>

<script>
    let dataArr = [];
    let orderMap = {};

    function formatDateYmd(d) {
        if (!d) return '';
        const date = new Date(d);
        if (isNaN(date)) return d; // fallback if already formatted
        const dd = String(date.getDate()).padStart(2,'0');
        const mm = String(date.getMonth()+1).padStart(2,'0');
        const yyyy = date.getFullYear();
        return `${dd}-${mm}-${yyyy}`;
    }

    $(document).ready(function() {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'Overtimes', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('.clockpicker').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "bottom",
            align: "left",
            autoclose: true,
        });

        $('#div').select2({
            placeholder: 'Pilih Jenis',
        });

        $('.tanggal').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        }).datepicker('setDate', 'now');

        $('.timepicker').timepicker({
        });
    });

    // Handle search button click
    $(document).on('click', '#dataWorkOrderSearch', function() {
        const workOrderCode = $('input[name="workOrderId"]').val();
        if (!workOrderCode) { Swal.fire('Silakan masukkan nomor Work Order'); return; }

        $.ajax({
            url: "<?php echo $this->Url->build(['prefix'=>'Hr','controller'=>'Overtimes','action'=>'getWorkOrder']); ?>",
            method: "GET",
            data: { code: workOrderCode },
            success: function(response) {
                $('.dataWorkOrderIn tbody').html('');
                orderMap = {};

                const woId   = (response.work_order && response.work_order.id) || '';
                const woDate = (response.work_order && response.work_order.date) || '';

                // isi otomatis ke form
                $('input[name="work_order_id"]').val(woId);
                if (woDate) {
                    // kalau datepicker, pakai setDate; jika format sudah dd-mm-yyyy, langsung set
                    $('.tanggal').datepicker('setDate', woDate);
                    $('input[name="date"]').val(woDate);
                }

                if (response.status === 'success' && response.data.length > 0) {
                    $.each(response.data, function(i, line) {
                        // simpan di map (bawa juga woDate)         
                        orderMap[line.id] = Object.assign({}, line, { work_order_date: woDate });

                        const row = `
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm p-l-15 p-r-15" onclick="addRecordFromMap('${line.id}')">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                    <input type="checkbox" class="select-order" value="${line.id}" style="display:none;">
                                </td>
                                <td class="text-center">${woDate || '-'}</td>
                                <td>${line.user ? line.user.name : '-'}</td>
                                <td class="text-center">${line.time_from || '-'}</td>
                                <td class="text-center">${line.time_end || '-'}</td>
                                <td class="text-center">${line.task || '-'}</td>
                            </tr>
                        `;
                        $('.dataWorkOrderIn tbody').append(row);
                    });
                    toggleBtnSelectChecked();
                } else {
                    $('.dataWorkOrderIn tbody').html('<tr><td class="text-center" colspan="6">' +
                        (response.message || 'Data tidak ditemukan') + '</td></tr>');
                    $('#btnSelectChecked').hide();
                    $('.info-ceklis').hide();
                }
            },
            error: function() {
                $('.dataWorkOrderIn tbody').html('<tr><td class="text-center" colspan="6">Terjadi kesalahan saat mengambil data</td></tr>');
                $('#btnSelectChecked').hide();
                $('.info-ceklis').hide();
            }
        });
    });

    // select all & toggle button
    $(document).on('change', '#selectAllOrders', function() {
        $('.select-order').prop('checked', this.checked);
        toggleBtnSelectChecked();
    });
    $(document).on('change', '.select-order', function() {
        const total = $('.select-order').length;
        const checked = $('.select-order:checked').length;
        $('#selectAllOrders').prop('checked', total === checked);
        toggleBtnSelectChecked();
    });
    function toggleBtnSelectChecked() {
        if ($('.select-order:checked').length > 0) {
            $('#btnSelectChecked').show();
            $('.info-ceklis').show();
        } else {
            $('#btnSelectChecked').hide();
            $('.info-ceklis').hide();
        }
    }

    function renderOvertimeTable() {
        const $tbody = $('.workOrderData>tbody');
        $tbody.html('');

        if (dataArr.length === 0) {
            $tbody.html('<tr><td class="text-center" colspan="9">Maaf, Data order kosong...</td></tr>');
            return;
        }

        $.each(dataArr, function(i, line) {
            const date = formatDateYmd(line.work_order_date);
            const description = line.task || '';
            const estFrom = line.time_from || '';
            const estEnd = line.time_end || '';
            const realFrom = line.real_from || estFrom;
            const realEnd = line.real_end || estEnd;

            const row = `
                <tr>
                    <td>
                        <input type="hidden" name="lines[${i}][work_order_line_id]" value="${line.id}">
                        <b>${line.user ? line.user.name : '-'}</b>
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="lines[${i}][date]" value="${line.work_order_date}">
                        ${date || '-'}
                    </td>
                    <td class="text-center">${estFrom || '-'}</td>
                    <td class="text-center">${estEnd || '-'}</td>
                    <td class="text-center">
                        <input type="hidden" name="lines[${i}][description]" value="${line.task}">
                        ${description || '-'}
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control clockpicker ot-real-from"
                            name="lines[${i}][time_from]" value="${realFrom}" autocomplete="off">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control clockpicker ot-real-end"
                            name="lines[${i}][time_end]" value="${realEnd}" autocomplete="off">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm p-l-15 p-r-15" onclick="delRecord(${i})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
            $tbody.append(row);
        });

        // Re-init clockpicker
        $('.clockpicker').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "bottom",
            align: "left",
            autoclose: true,
        });
    }

function addRecord(line) {
    const exists = dataArr.find(x => String(x.id) === String(line.id));
    if (exists) {
        SwalHelper.warning('Data Sudah Dimasukkan');
        return;
    }
    dataArr = [...dataArr, line];
    renderOvertimeTable();
    SwalHelper.success('Data Berhasil Ditambahkan');
    $('#btn-add').prop('disabled', false);
}

function delRecord(index) {
    dataArr.splice(index, 1);
    renderOvertimeTable();
    SwalHelper.success('Data Berhasil Dihapus');
}

// Pilih data
$(document).on('click', '#btnSelectChecked', function () {
    const selected = [];
    $('.select-order:checked').each(function () {
        const id = $(this).val();
        if (orderMap[id]) selected.push(orderMap[id]);
    });
    if (!selected.length) { SwalHelper.warning('Tidak ada data yang dicentang'); return; }
    selected.forEach(addRecord);
});

function addRecordFromMap(id) {
    if (orderMap[id]) {
        addRecord(orderMap[id]);
    } else {
        SwalHelper.warning('Data tidak ditemukan di orderMap');
    }
}
</script>