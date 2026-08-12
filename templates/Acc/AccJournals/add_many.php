<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal $accJournal
 */
$dataChild = $this->Html->link('Journal', ['action' => 'index'], ['full_base'=>true]);
?>
<?= $this->Krs->breadcrumb('Accounting', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">
    <?= $this->Krs->heading('Data Journal'); ?>
   
    <?= $this->Form->create($accJournal) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body bg-gray-100">
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-2">Cabang</label>
            <div class="col-md-4">
                <div class="input-group">
                    <?php
                    echo $this->Form->input('branch_id', ['empty'=>false, 'options'=>$data['getListBranch'], 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'autofocus'=>'autofocus', 'type'=>'select', 'id'=>'selectBranch']);
                    ?>
                </div>
            </div>
            <label class="col-form-label col-md-2">Tanggal</label>
            <div class="col-md-2">
                <div class="input-group" id="default-daterange">
                    <?php
                    echo $this->Form->input('date_journal', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control dateJournal', 'placeholder' => 'Tanggal..', 'value'=>date('d-m-Y')));
                    ?>
                    <span class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kode</label>
            <div class="col-md-4">
                <div class="input-group">
                <?php
                echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                echo $this->Form->control('branch_id', ['type' => 'hidden', 'value' => 1]);
                echo $this->Form->input('codes', ['id' => 'accJournal-code', 'class' => 'form-control', 'placeholder'=>'No..', 'value'=>$data['maxNumber'], 'autocomplete' => 'off']);
                //<p class="help-block"><i id="loading-check-desc"><i class="fa fa-microphone"></i> Silakan masukkan kode untuk mengecek..</i></p>
                ?>
                <span class="input-group-addon"><i id="loading-check-image"></i></span>
                </div>
                <small class="f-s-12 text-grey-darker"><i class="fa fa-bullhorn"></i><i> Silakan masukkan kode untuk mengecek..</i></small>
            </div>
            <label class="col-form-label col-md-2">Jenis Jurnal</label>
            <div class="col-md-2">
                <div class="input-group">
                    <?php
                    echo $this->Form->input('journal_type', ['empty'=>false, 'options'=>$this->Krs->journalType(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'type'=>'select', 'id'=>'select-populate', 'default'=>'Memorial']);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row m-b-15">            
            
            <label class="col-form-label col-md-2">Penanggung Jawab</label>
            <div class="col-md-10">
                <div class="input-group">
                    <select class="form-control" id='recipientPayers' name="recipient_payer_name" style="width:400px;"></select>
                    <?php
                    // echo $this->Form->input('recipient_payer_name', ['class'=>'form-control', 'id'=>'recipientPayers']);
                    // echo $this->Form->input('recipient_payer_name', ['empty'=>false, 'options'=>$dataRowRecipientPayer, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'autofocus'=>'autofocus', 'type'=>'select', 'id'=>'select-populates', 'default'=>'Memorial']);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Judul</label>
            <div class="col-md-10">
                <?php
                echo $this->Form->input('subject', ['class' => 'form-control', 'placeholder'=>'Judul..']);
                ?>
            </div>
            <?php
            /*
            <label class="col-form-label col-md-2">No. Ref</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('no_ref', ['class' => 'form-control', 'placeholder'=>'No.Ref..']);
                ?>
            </div>
            */
            ?>
        </div>        
        <div class="table-responsive">      
            <table class="table m-b-0 table-advance warning" id="tblGridJurnal">
                <thead>
                    <tr class="table-info text-center">
                        <th width="100">D/K</th>
                        <th>Nama Perkiraan</th>
                        <th width="250">Uraian</th>
                        <th width="120">Jumlah Debit</th>
                        <th width="120">Jumlah Kredit</th>
                        <th width="60"></th>
                    </tr>
                </thead>
                            
                <tbody>
                    <?php 
                    for($a=0;$a<=1;$a++){
                    ?>
                    <tr>
                        <td>
                            <?php
                            $dcStatus = ($a==0) ? "Debit":"Kredit";
                            $dcHiddenStatus = ($a==0) ? "D":"C";
                            echo $dcStatus;
                            echo $this->Form->input('cart.dc_status.'.$a, array("empty" => false, "value"=>$dcHiddenStatus, "id"=>"dcStatusLedger", "type"=>"hidden"));
                            ?>
                        </td>
                        <td>
                            <select class="form-control coaLedger" id='checkCOA<?php echo $a; ?>' name="cart[ledger_id][<?php echo $a; ?>]" style="width:400px;"></select>
                        </td>
                        <td>
                            <?php 
                            echo $this->Form->input('cart.desc.'.$a, array("type"=>"textarea", "rows" => "3", "cols"=>"20", "id"=>"descLedger", "class"=>"form-control descLedger firstDesc".$a, 'placeholder' => 'Keterangan..', 'style'=>"width:250px;"));
                            ?>
                        </td>
                        <td>
                            <?php 
                            $disabledDebetAmount = ($a==0) ? array():array("disabled"=>"disabled");
                            echo $this->Form->input('cart.debet_amount.'.$a, array("autocomplete"=>"off", 'class'=>'form-control auto amountDebet firstDebet'.$a, "id"=>"amountDebetLedger", $disabledDebetAmount, 'placeholder' => 'Debit..', 'style'=>"width:120px;")); 
                            ?>
                        </td>
                        <td>
                            <?php 
                            $disabledCreditAmount = ($a==0) ? array("disabled"=>"disabled"):array();
                            
                            echo $this->Form->input('cart.credit_amount.'.$a, array("autocomplete"=>"off", 'class'=>'form-control auto amountCredit firstCredit'.$a, "id"=>"amountCreditLedger", $disabledCreditAmount, 'placeholder' => 'Kredit..', 'style'=>"width:120px;"));
                            echo $this->Form->input('cart.linetotalDebet.'.$a, array("id"=>"line-total-debet", "class"=>"lineTotalDebet".$a, "type" => "hidden"));
                            echo $this->Form->input('cart.linetotalCredit.'.$a, array("id"=>"line-total-credit", "class"=>"lineTotalCredit".$a, "type" => "hidden"));
                            ?>
                        </td>
                        <td align="right">                                  
                            <?php 
                            if($a==0) {
                                echo $this->Form->button('<i class="fas fa-plus"></i>', ['class'=>'btn btn-purple addrow', 'type'=>'button', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Tambah"]);

                                // echo $this->Form->button('<i class="fa fa-plus"></i>', ['class'=>'btn btn-purple addrow', 'type'=>'button', 'escape' => false]);                               
                            }
                            ?>
                        </td>                               
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <thead>
                    <tr id="voucher-total">
                        <td colspan="3" align="right"><strong>Grand Total</strong></td>
                        <td id="grandTotalDebet" align="right">0</td>
                        <td id="grandTotalCredit" align="right">0</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="panel-footer text-right bg-orange" colspan="6">
                            <?php
                            echo $this->Form->button('<i class="fas fa-cart-plus"></i>', ['class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'id'=> 'addToProject', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Tambah", 'disabled'=>'disabled']);

                            // echo $this->Form->button('<i class="fas fa-cart-plus"></i>', array('class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'id'=>'addToProject', 'escape' => false, 'disabled'=>'disabled'));
                            ?>
                        </td>
                    </tr>
                </thead>
            </table>
            
        </div>
        
        <hr class="bg-orange" />
        <div class="form-group row m-b-15">
            <div class="col-md-12">
                <h5>
                    Data yang akan diJurnal:<span id="loading-image-cart"></span>
                </h5>
                <?php
                /*
                <div class="panel-body bg-blue overflow-y-scroll position-relative" style="height:300px;">
                </div>      
                */
                ?>
                    <div class="table-responsive" style="height:400px;">
                        <table class="table table-striped m-b-5 table-advance" id="tblGridCart">
                            
                        </table>
                    </div>
                                
            </div>
        </div>
    </div>
    <div class="panel-footer text-right bg-orange">
    <?php
    echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add', 'disabled'=>'disabled']);
    ?>
    </div>   
    <?= $this->Form->end() ?>
</div>
<?php

// $urlCartJurnalProcess = $this->Url->build(['controller'=>'acc_journals', 'action' => 'add_cart', '_full'=>true]);
?>
<script>
$(document).ready(function() {
    var cartJurnalProcess = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'add_cart'], ['fullBase' => true]); ?>";
    var checkCode = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'checkcode'], ['fullBase' => true]); ?>";
    var checkCodeByType = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'checkcodeByType'], ['fullBase' => true]); ?>";
    var checkCOAbyName = "<?php echo $this->Url->build(['controller'=>'acc_chart_of_accounts', 'action' => 'getCoa', 5], ['fullBase' => true]); ?>";
    var checkRecipientPayer = "<?php echo $this->Url->build(['controller'=>'recipient_payers', 'action' => 'getData'], ['fullBase' => true]); ?>";

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'add_many'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalAddForm', 'btn-add', confirmTitle, formAction);

    $(".select2Form").select2();
    $(".dc-dropdown").select2();
    $('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});

    handleFormSelect2Search('checkCOA0', 'Masukkan Nama Perkiraan', 2, checkCOAbyName);
    handleFormSelect2Search('checkCOA1', 'Masukkan Nama Perkiraan', 2, checkCOAbyName);

    handleFormSelect2Search('recipientPayers', 'Masukkan Penanggung Jawab', 2, checkRecipientPayer);
    

    var ctr = 400;
    $('.addrow').on('click', function (e) {
        if (e.originalEvent.defaultPrevented) return;
        ctr++;
        
        $(".dc-dropdown").select2();
        $('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});

        //autoLoad();
        var newTr = "";

        newTr += '<tr class="addField">';
        newTr += '<td><select name="cart[dc_status]['+ ctr +']" class="form-control dc-dropdown" id="dcStatusLedger" style="width:100px;">';
        newTr += '<option value="D">Debit</option>';
        newTr += '<option value="C">Kredit</option>';       
        newTr += '</select></td>';
        newTr += '<td><select class="form-control coaLedger" id="checkCOAs'+ ctr +'" name="cart[ledger_id]['+ ctr +']" style="width:400px;"></select></td>';     
        newTr += '<td><textarea name="cart[desc]['+ ctr +']" rows="3" cols="20" class="form-control" placeholder="Keterangan" id="descLedger" style="width:250px;"></textarea></td>';
        newTr += '<td><input name="cart[debet_amount]['+ ctr +']" class="form-control input-small amountDebet auto" autocomplete="off" type="text" id="amountDebetLedger" placeholder="Debit.." style="width:120px;"/></td>';
        newTr += '<td><input name="cart[credit_amount]['+ ctr +']" class="form-control input-small amountCredit auto" autocomplete="off" type="text" id="amountCreditLedger" disabled="disabled" placeholder="Kredit.." style="width:120px;"/><input type="hidden" name="cart[linetotalDebet]['+ ctr +']" id="line-total-debet"/><input type="hidden" name="cart[linetotalCredit]['+ ctr +']" id="line-total-credit"/></td>';      // disabled="disabled"
        newTr += '<td align="right"><button class="btn btn-danger" type="button" id="deleterow"><i class="fa fa-minus "></i></button></td></tr>';
        
        $('#tblGridJurnal').append(newTr);
        
        handleFormSelect2Search('checkCOAs'+ ctr, 'Masukkan Nama Kelompok', 2, checkCOAbyName);
        gridJournal();
        $(".dc-dropdown").select2();
        $('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});
        
    });

    $("table#tblGridJurnal").on("click", '#deleterow', function (event) {
        if (event.originalEvent.defaultPrevented) return;
        $(this).parent().parent().remove();
        calcGrandTotal();
    }); 

    function calcGrandTotal() {
        var grandTotalDebet = 0;
        var grandTotalCredit = 0;
        
        $("table#tblGridJurnal").find('input[id^="line-total-debet"]').each(function () {
            grandTotalDebet += +$(this).val();
        });

        $("table#tblGridJurnal").find('input[id^="line-total-credit"]').each(function () {
            grandTotalCredit += +$(this).val();
        });
        
        var grandTotalDebets=parseFloat(grandTotalDebet).toFixed(2); //"12.13"
        var grandTotalCredits=parseFloat(grandTotalCredit).toFixed(2); //"12.13"
        
        $("#grandTotalDebet").number(grandTotalDebets, 2, ",", ".");
        $("#grandTotalCredit").number(grandTotalCredits, 2, ",", ".");

        if (grandTotalDebets == grandTotalCredits && grandTotalDebets>0 && grandTotalCredits>0) {
            var bgColor = "#80FD99";
            var btnStatus = false;
        } else {
            var bgColor = "#D7684D";
            var btnStatus = true;
        }

        $("table tr #grandTotalDebet").css("background-color", bgColor);
        $("table tr #grandTotalCredit").css("background-color", bgColor);
        $("#addToProject").prop("disabled", btnStatus);
        return false;       
    }

    function calcRows() {
        $("table#tblGridJurnal").on("change", 'input[id^="amountDebetLedger"], input[id^="amountCreditLedger"]', function (event) {
            calcRow($(this).closest("tr"));
        });     
    }
    calcRows();

    $('.firstDesc0').on('keyup', function() {
        var firstDesc0 = $('.firstDesc0').val();
        $('.firstDesc1').val(firstDesc0);
    }); 

    $("table#tblGridJurnal").on("keyup", '.firstCredit1', function (event) {
        calcGrandTotal();        
    });

    $("table#tblGridJurnal").on("keyup", '.firstDebet0', function (event) {
    
        var firstDebet0d = $('.firstDebet0').val();
        var firstDebet0s = $('.firstDebet0').val().replace(/(?!^-)[^0-9\,]+/g,"");
        var firstDebet0 = firstDebet0s.replace(/,/g, '.');

        $('.firstCredit1').val(firstDebet0d);
        $('table tr .lineTotalCredit1').val(firstDebet0);
        $("table tr #grandTotalDebet").css("background-color", "#80FD99");
        $("table tr #grandTotalCredit").css("background-color", "#80FD99");
        $("#grandTotalDebet").number(firstDebet0, 2, ",", ".");
        $("#grandTotalCredit").number(firstDebet0, 2, ",", ".");
    }); 
    

    function calcRow(row) {
        //var prices = 0;
        var dataDebets = row.find('#amountDebetLedger').val().replace(/(?!^-)[^0-9\,]+/g,"");
        var dataDebet = dataDebets.replace(/,/g, '.');
        var dataCredits = row.find('#amountCreditLedger').val().replace(/(?!^-)[^0-9\,]+/g,"");
        var dataCredit = dataCredits.replace(/,/g, '.');
        var totalLineDebet = dataDebet;
        var totalLineCredit = dataCredit;
        row.find('#line-total-debet').val(dataDebet);
        row.find('#line-total-credit').val(dataCredit);
        //row.find('#line-total-debet').val(totalLineDebet.toFixed(2));
        //row.find('#line-total-credit').val(totalLineCredit.toFixed(2));
        calcGrandTotal();
        //gridJournal();
    }
    

    function gridJournal() {
        $(".dc-dropdown").on("change", function() {
            //Debit
            var drValue = $(this).parent().next().next().next().children().prop("value");
            //Credit
            var crValue = $(this).parent().next().next().next().next().children().prop("value");

            if ($(this).parent().next().children().val() == "0") {
                return;
            }
            
            if ($(this).prop("value") == "D") {
                if (drValue == 0 && crValue != 0) {
                    $(this).parent().next().next().next().children().prop("value", crValue);
                }

                //Debit
                $(this).parent().next().next().next().children().prop("disabled", "");
                //Credit
                $(this).parent().next().next().next().next().children().prop("value", "");
                $(this).parent().next().next().next().next().children().prop("disabled", "disabled");
                //Description
                $(this).parent().next().next().children().prop("disabled", "");
            } else {
                if (crValue == 0 && drValue != 0) {
                    $(this).parent().next().next().next().next().children().prop("value", drValue);
                }               
                //Debit
                $(this).parent().next().next().next().children().prop("value", "");
                $(this).parent().next().next().next().children().prop("disabled", "disabled");
                //Credit
                $(this).parent().next().next().next().next().children().prop("disabled", "");
                //Description
                $(this).parent().next().next().children().prop("disabled", "");
            }
            $(this).parent().next().next().next().children().trigger("change");
            $(this).parent().next().next().next().next().children().trigger("change");
            
        });
        
        return false;
    }

    $("table#tblGridJurnal").on("click", '#addToProject', function (event) {
        var dataForm = JSON.stringify($('form').serializeArray());
        var dataLink = btoa(encodeURIComponent(btoa(dataForm)));
        
        if(dataLink.length != 0) {  
            
            jQuery.ajax({
                url: cartJurnalProcess,
                type: "get",
                async: true,
                cache: false,
                dataType: "html",
                data: {
                    cond:'add', dataCart: dataLink
                }, 
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                success: function(data, textStatus, jqXHR) {
                    // var table = $('#'+classTable).DataTable(); 
                    // table.ajax.reload( null, false );
                    if ($(".addField").length > 0) {
                        //document.getElementById("addField").remove();
                        var list = document.getElementsByClassName("addField");
                        for(var i = list.length - 1; 0 <= i; i--)
                        if(list[i] && list[i].parentElement)
                        list[i].parentElement.removeChild(list[i]);
                    }

                    $(".coaLedger").empty();
                    $('input[id="descLedger"], textarea').val('');
                    $('input[id="amountDebetLedger"]').val('');
                    $('input[id="amountCreditLedger"]').val('');
                    $('input[id="line-total-debet"]').val('');
                    $('input[id="line-total-credit"]').val('');
                    $("#grandTotalDebet").number(0, 2, ",", ".");
                    $("#grandTotalCredit").number(0, 2, ",", ".");
                    document.getElementById('grandTotalDebet').style.removeProperty("background-color");
                    document.getElementById('grandTotalCredit').style.removeProperty("background-color");
                    $("#addToProject").prop("disabled", true);

                    showGridCart();
                    swal({
                      title: "Berhasil",
                      text: "Data Jurnal Berhasil ditambahkan!",
                      timer: 2000,
                      icon: 'success',
                      button: false,
                      // showConfirmButton: false,                          
                      //className: 'facebook',
                    });                     
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   swal("Error!", textStatus, "error");
                }
            });
        }
    });


    //Remove items from cart
    $("table#tblGridCart").on('click', '#removeCart', function(e) {
        var codeId = $(this).data('code');
        //alert(codeId);
        if(codeId.length != 0) {
            jQuery.ajax({
                url: cartJurnalProcess,
                type: "get",
                async: true,
                cache: false,
                dataType: "html",
                data: {
                    cond:'delete', idData: codeId
                }, 
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                success: function(data, textStatus, jqXHR) {
                    // var table = $('#'+classTable).DataTable(); 
                    // table.ajax.reload( null, false );
                    showGridCart();
                    swal({
                      title: "Berhasil",
                      text: "Data Jurnal berhasil dihapus!",
                      timer: 2000,
                      icon: 'success',
                      button: false,
                      // showConfirmButton: false,                          
                      //className: 'facebook',
                    });                     
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   swal("Error!", textStatus, "error");
                }
            });
        }
    });

    showGridCart();

    function showGridCart() {
        if (!$('#loading-image-cart').attr('complete')) {
            $('#loading-image-cart').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        }
        
        $("#tblGridCart").load(cartJurnalProcess+"?cond=view", function(responseTxt, statusTxt, xhr){
            // alert(responseTxt.length);
            if(statusTxt == "success") {
                $('#loading-image-cart').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            }
            if(statusTxt == "error") {
                alert( "Maaf ada kesalahan program, silakan hubungi admin..! 'Error': " + xhr.status + ": " + xhr.statusText );
                $('#loading-image-cart').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                $("#btn-add").prop("disabled", true);
            }

            if(responseTxt.length<=647) {
                $("#btn-add").prop("disabled", true);
            } else {
                $("#btn-add").prop("disabled", false);
            }
        });
    }

    function autoLoad() {
        
        $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});

        $("table tr #dr-diff").css("font-weight", "bold");
        $("table tr #cr-diff").css("font-weight", "bold");
    }
    autoLoad();

    $('#selectBranch').on('change', function() {
        if (!$('#loading-check-image').attr('complete')) {
            $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        }

        //var journalBranch = $('#selectBranch').find('option:selected').val();
        var dateJournal = $('.dateJournal').val();
        var journalType = $('#select-populate').find('option:selected').val();

        if($(this).val().length != 0) {
            $.getJSON(checkCodeByType,
            {branch: $(this).val(), type: journalType, dates: dateJournal},
            function(result) {
                if(result !== null) {
                    populateJournal(result);
                }
            }).done(function() {
                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                //console.log( "second success" );
            }).fail(function() {
                alert( "Maaf ada kesalahan program, silakan hubungi admin.." );
                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            })
        };
    });

    $('#select-populate').on('change', function() {
        if (!$('#loading-check-image').attr('complete')) {
            $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        }
        

        <?php
        //Sementara 220617 michael @office
        /*if(count($data['branchId']) > 1) {
        ?>
        var journalBranch = $('#select-populate-branch').find('option:selected').val();
        <?php } else { ?>
        var journalBranch = <?php echo $data['branchId'][0]; ?>;
        <?php } 
        */
        ?>
        var journalBranch = $('#selectBranch').find('option:selected').val();
        var dateJournal = $('.dateJournal').val();
        //var journalBranch = 1;
        

        if($(this).val().length != 0) {
            //alert($(this).val());
            $.getJSON(checkCodeByType,
            {branch: journalBranch, type: $(this).val(), dates: dateJournal},
            function(result) {
                //alert(result);
                if(result !== null) {
                    populateJournal(result);
                }
            }).done(function() {
                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                //console.log( "second success" );
            }).fail(function() {
                alert( "Maaf ada kesalahan modul cek kode program, silakan hubungi admin.." );
                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            })
        };
    });

    $('.dateJournal').on('change', function() {
        if (!$('#loading-check-image').attr('complete')) {
            $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        }        

        var journalBranch = $('#selectBranch').find('option:selected').val();
        var journalType = $('#select-populate').find('option:selected').val();

        if($(this).val().length != 0) {
            $.getJSON(checkCodeByType,
            {branch: journalBranch, type: journalType, dates: $(this).val()},
            function(result) {
                //alert(result);
                if(result !== null) {
                    populateJournal(result);
                }
            }).done(function() {
                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                //console.log( "second success" );
            }).fail(function() {
                alert( "Maaf ada kesalahan modul cek kode program, silakan hubungi admin.." );
                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            })
        };
    });

    function populateJournal(result) {
        // var options = '';
        // alert(result);

        $.each(result, function(id, value) {
            if (id=='code'){
                $( '#accJournal-code' ).val( value );
            }
        });
    }

});
</script>
<?php
/*
            $.ajaxSetup({ cache: false, async: true});
            $.getJSON(cartJurnalProcess, 
                {cond:'add', dataCart: dataLink},
            ).done(function() {
                swal({
                  title: "Berhasil",
                  text: "Data Jurnal Berhasil ditambahkan!",
                  timer: 1000,
                  showConfirmButton: false,
                  type: 'success',
                  customClass: 'facebook',
                });
                
                if ($(".addField").length > 0) {
                    //document.getElementById("addField").remove();
                    var list = document.getElementsByClassName("addField");
                    for(var i = list.length - 1; 0 <= i; i--)
                    if(list[i] && list[i].parentElement)
                    list[i].parentElement.removeChild(list[i]);
                }

                $('input[id="descLedger"], textarea').val('');
                $('input[id="amountDebetLedger"]').val('');
                $('input[id="amountCreditLedger"]').val('');
                $('input[id="line-total-debet"]').val('');
                $('input[id="line-total-credit"]').val('');
                $("#grandTotalDebet").number(0, 2, ",", ".");
                $("#grandTotalCredit").number(0, 2, ",", ".");
                document.getElementById('grandTotalDebet').style.removeProperty("background-color");
                document.getElementById('grandTotalCredit').style.removeProperty("background-color");
                $("#addToProject").prop("disabled", true);

                showGridCart();
                //if (event.originalEvent.defaultPrevented) return;
            }).fail(function() {
                alert( "Maaf ada kesalahan pada tambah jurnal, silakan hubungi admin.." );
            });*/
//alert($("#tblGridCart").length);
//alert(value);
//input-group-addon-type
// alert(codeId);
/*$.ajaxSetup({ cache: false, async: true});
$.getJSON('<?php //echo $urlCartJurnalProcess; ?>', 
    {cond:'delete', idData: codeId},
).done(function() {
    showGridCart();

    swal({
      title: "Berhasil",
      text: "Data Jurnal berhasil dihapus!",
      timer: 1000,
      showConfirmButton: false,
      type: 'success',
      customClass: 'facebook',
    });
}).fail(function() {
    alert( "Maaf ada kesalahan hapus data pada program, silakan hubungi admin.." );
});*/


/*$.ajaxSetup({ cache: false, async: true});
$.getJSON('<?php //echo $urlCartJurnalProcess; ?>', 
    {cond:'delete', idData: codeId},
    function(dataItems) {
        alert(dataItems);
        if(dataItems != null) {
           showGridCart();

           swal({
              title: "Berhasil",
              text: "Data Jurnal berhasil dihapus!",
              timer: 1000,
              showConfirmButton: false,
              type: 'success',
              customClass: 'facebook',
            });

        } else {
            //dataItemEmpty();
            //gridWasteEmpty();
        }
}).done(function() {
    //$('#loading-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
}).fail(function() {
    alert( "Maaf ada kesalahan hapus data pada program, silakan hubungi admin kita.." );
});*/



/*$.ajaxSetup({ cache: false, async: true});
$.getJSON(cartJurnalProcess, 
    {cond:'delete', idData: codeId},
).done(function() {
    showGridCart();

    swal({
      title: "Berhasil",
      text: "Data Jurnal berhasil dihapus!",
      timer: 1000,
      showConfirmButton: false,
      type: 'success',
      customClass: 'facebook',
    });
}).fail(function() {
    alert( "Maaf ada kesalahan hapus data pada program, silakan hubungi admin kita.." );
});*/
?>