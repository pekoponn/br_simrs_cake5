<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkOrder $workOrder
 */
?>
<!-- <?= $this->Krs->breadcrumb('Data', $dataChild, 'Buat') ?> -->
 <?= $this->Krs->breadcrumb('Data', 'Surat Perintah Kerja Lembur', 'Buat') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Surat Perintah Kerja Lembur</h4>
        <div class="panel-heading-btn">
            <a href="javascript:" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($workOrder) ?>
    <?= $this->Form->hidden('is_create', ['value' => $this->request->getSession()->read('Auth.id')]) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Nomor Surat</label>
                    <div class="input-group m-b-10">
                        <?php
                        echo $this->Form->input('codes', ['class' => 'form-control', 'placeholder'=>'No..', 'value'=>$data['lastNumber'], 'disabled' => true]) 
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">                      
                    <div class="input-group">
                        <?php
                        // pr($getUser->project_status)
                        // $usbStatus = ($getUser->project_status=='Y') ? false : true
                        // $ubsHidden =  ($getUser->project_status=='Y') ? '' : ' <input type="hidden" name="devision" value="'.$getUser->project.'">'

                        // echo $this->Form->input('devision', ['empty'=>false, 'options'=>$this->Krs->devision(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$getUser->project])
                        // echo $ubsHidden
                        echo $this->Form->control('devision', [
                            'type' => 'select',
                            'label' => 'Divisi',
                            'options' => $this->Krs->devision(),
                            'empty' => false,
                            'class' => 'form-control select2Form',
                            'required' => true
                        ]);
                        //echo $this->Form->input('type', ['label' => 'Jenis', 'empty'=>false, 'options'=>$this->Krs->typePca(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form'])
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tanggal</label>                        
                    <div class="input-group">
                    <?php
                    echo $this->Form->input('date', ['data-placeholder'=>'Silakan pilih..', 'class'=>'form-control date1', 'type'=>'text'])
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->control('description', array('label' => 'Keterangan', 'type'=>'textarea', 'rows' => '6', 'cols'=>'75', 'class'=>'form-control', 'placeholder' => 'Keterangan'))
            ?>
        </div> 
        <hr>
        <h4>Rincian Surat Perintah Kerja Lembur</h4>
        <div class="table-responsive">
            <table class="table m-b-0 table-advance">
            <tr class="sum">
                <td>
                    <table cellpadding="0" class="adminlist" cellspacing="0" border="0" id="myTable" width="100%">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th width="25%">Nama</th>
                                <th width="15%">Jam Mulai</th>
                                <th width="15%">Jam Akhir</th>
                                <th width="40%">Rincian Tugas</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>  
                        <tbody>
                            <?php 
                            $a=1
                            ?>
                            <tr>
                                <td>
                                    <select name="work_order_lines[<?= $a ?>][user_id]" class="form-control select2-ajax" data-placeholder="Ketik minimal 2 huruf...">
                                        <option value="">-- Pilih User --</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <?= $this->Form->input(
                                            'work_order_lines.'.$a.'.time_from',
                                            [
                                                'class' => 'form-control clockpicker',
                                                'error' => false,
                                                'placeholder' => 'Jam..',
                                                'value' => date('H:i'), // ganti H:m jadi H:i (m = bulan, i = menit)
                                                'label' => false
                                            ]
                                        ) ?>
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock"></span>
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-group">
                                        <?= $this->Form->input(
                                            'work_order_lines.'.$a.'.time_end',
                                            [
                                                'class' => 'form-control clockpicker',
                                                'error' => false,
                                                'placeholder' => 'Jam..',
                                                'value' => date('H:i'),
                                                'label' => false
                                            ]
                                        ) ?>
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock"></span>
                                        </span>
                                    </div>
                                </td>

                                <td align="right">
                                    <?php 
                                    echo $this->Form->input('work_order_lines.'.$a.'.task', array('class' => 'form-control', 'placeholder' => 'Rincian Tugas..', 'type'=>'text'))
                                    ?>
                                </td>
                                <td align="right">
                                    <button class="btn btn-purple addrow" type="button" id="addrow"><i class="fa fa-plus"></i></button>

                                    <?php 
                                    // echo '<i class="fa fa-plus" id="addrow"></i>'
                                    ?>
                                </td>                               
                            </tr>
                        </tbody>
                        <!-- <thead>
                            <tr id="voucher-total">
                                <td colspan="3" align="right"><strong>Grand Total</strong></td>
                                <td id="grandTotal" align="right">0</td>
                                <td>&nbsp</td>
                            </tr>
                        </thead> -->
                    </table>

                </td>
            </tr>
            </table>
        </div>
    </div>
    <div class="panel-footer text-right bg-orange">
    <?php
    echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add'])
    ?>
    </div>   
    <?= $this->Form->end() ?>
</div>
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?"
    var formAction = "<?php echo $this->Url->build(['prefix'=>'Hr', 'controller'=>'WorkOrders', 'action' => 'add'], ['fullBase' => true]) ?>"
    handleFormConfirmSubmitValid('PettyCashAddForm', 'btn-add', confirmTitle, formAction)

    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    })

    $("#datepicker-autoClose1").datepicker({
        todayHighlight: true,
        autoclose: true
    })

    $(".date1").datepicker({
        todayHighlight: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    }).datepicker('setDate', new Date())
    
    $('.clockpicker').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "bottom",
            align: "left",
            autoclose: true,
        })

    hotkeyEnter()

    // Setup Select2 AJAX untuk field nama
    $('.select2-ajax').select2({
        ajax: {
            url: '<?= $this->Url->build(['prefix' => false, 'controller' => 'Users', 'action' => 'getSelect'], ['fullBase' => true]) ?>',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    search: params.term // term yang diketik user
                }
            },
            processResults: function (data) {
                return {
                    results: data
                }
            },
            cache: true
        },
        minimumInputLength: 2, // minimal 2 huruf
        placeholder: 'Ketik minimal 2 huruf...',
        allowClear: true
    })

    $(".select2Form").select2()
    $("select2-clear").on("select2-clear:close", function (e) {  
        $(this).valid() 
    })
    $('input.nominal').autoNumeric({aSep: '.', aDec: ','})

    function autoNumber() {
        $('input.auto').autoNumeric({aSep: '.', aDec: ',', mDec: 0})
        $('input.qty').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000'})
        $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'})
    }
    autoNumber()

    function hotkeyEnter(){
        $('input').keydown( function(e) {
            var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0
            if(key == 13) {
                e.preventDefault()
                var inputs = $(this).closest('form').find(':input:visible')
                inputs.eq( inputs.index(this)+ 1 ).focus()
            }
        })
    }

    var ctr = 999
    $('#addrow').on('click', function (e) {
        if (e.originalEvent.defaultPrevented) return
        ctr++
        
        autoNumber()
        var newTr = ""

        newTr += '<tr>'
        newTr += '<td><select name="work_order_lines['+ ctr +'][user_id]" class="form-control select2-ajax" data-placeholder="Ketik minimal 2 huruf..."><option value="">-- Pilih User --</option></select></td>'
         // Jam Mulai
        newTr += '<td>'
        newTr += '   <div class="input-group">'
        newTr += '       <input name="work_order_lines['+ ctr +'][time_from]" class="form-control clockpicker" placeholder="Jam.." type="text" value="<?= date('H:i') ?>" />'
        newTr += '       <span class="input-group-addon"><span class="fa fa-clock"></span></span>'
        newTr += '   </div>'
        newTr += '</td>'

        // Jam Akhir
        newTr += '<td>'
        newTr += '   <div class="input-group">'
        newTr += '       <input name="work_order_lines['+ ctr +'][time_end]" class="form-control clockpicker" placeholder="Jam.." type="text" value="<?= date('H:i') ?>" />'
        newTr += '       <span class="input-group-addon"><span class="fa fa-clock"></span></span>'
        newTr += '   </div>'
        newTr += '</td>'
        newTr += '<td><input name="work_order_lines['+ ctr +'][task]" class="form-control" placeholder="Rincian Tugas.." type="text" /></td>'
        newTr += '<td align="right"><button class="btn btn-danger deleterow" type="button"><i class="fa fa-minus"></i></button></td>'
        newTr += '</tr>'
        
        $('#myTable').append(newTr)

        autoNumber()
        
        // Re-init select2 AJAX untuk row baru
        $('.select2-ajax').select2({
            ajax: {
                url: '<?= $this->Url->build(['prefix' => false, 'controller' => 'Users', 'action' => 'getSelect'], ['fullBase' => true]) ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results: data
                    }
                },
                cache: true
            },
            minimumInputLength: 2,
            placeholder: 'Ketik minimal 2 huruf...',
            allowClear: true
        })
        
        // Re-init clockpicker untuk row baru
        $('.clockpicker').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: "bottom",
            align: "left",
            autoclose: true,
        })
    })

    // Delete Row
    $("table#myTable").on("click", '.deleterow', function (event) {
        event.preventDefault()
        $(this).closest("tr").remove()
        // calcGrandTotal()
    }) 

    // function calcRows() {
    //     $("table#myTable").on("change", 'input[id^="data-price"], input[id^="data-qty"]', function (event) {
    //         calcRow($(this).closest("tr"))
    //     })     
    // }
    
    // calcRows()

    // function calcRow(row) {
    //     //var prices = 0
    //     var prices = row.find('#data-price').val().replace(/(?!^-)[^0-9\,]+/g,"")
    //     var price = prices.replace(/,/g, '.')
    //     var qtys = row.find('#data-qty').val().replace(/(?!^-)[^0-9\,]+/g,"")
    //     var qty = qtys.replace(/,/g, '.')
    //     var totalLine = price*qty
    //     row.find('#line-totals').val(totalLine.toFixed(2))
    //     row.find("#line-total").number(totalLine, 2, ",", ".")
    //     calcGrandTotal()
    // }
        
    // function calcGrandTotal() {
    //     var grandTotal = 0
    //     $("table#myTable").find('input[id^="line-totals"]').each(function () {
    //         grandTotal += +$(this).val()
    //     })
    //     $("#grandTotal").number(grandTotal, 2, ",", ".")
    // }
    
})
</script>
