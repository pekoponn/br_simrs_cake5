<?php
//Menampilkan pesan error.

// pr($artamaAccJournalLine);
// $row = $data['rows'];
$accJournalLine = $artamaAccJournalLine;
// $accChartOfAccount = $row['AccChartOfAccount'];
$accJournal = $artamaAccJournalLine['artama_acc_journal'];
$accCoa = $artamaAccJournalLine['artama_acc_chart_of_account'];

$accJournalCode = $accJournal['code'];
// $accJournalLineCOAId = $accJournalLine['artama_acc_chart_of_account_id'];
$accJournalLineName = $accJournalLine['name'];
$accJournalLineDebet = $this->Krs->nom($accJournalLine['debet']);
$accJournalLineCredit = $this->Krs->nom($accJournalLine['credit']);
$accJournalLineId = $accJournalLine['id'];
//$accountDebetNominal = ($accountLedgerDc=="D")?$this->Krs->nominal($accJournalLine["debet"]):"";

$optionDC = array("D"=>"Debit", "C"=>"Kredit");

// pr($data['rowAccount']);

//$dataAccounts = $this->Krs->_getCOA($data['rowAccount'], 'Default');
?>
<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">Data : <?php echo $accJournalCode; ?></h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body" style="overflow:hidden;">
			<?= $this->Form->create($artamaAccJournalLine) ?>
			<?php
			// echo $this->Form->create("AccJournalLine", array("id" => "fileinfo", "enctype"=>"multipart/form-data", "url" => array('event_id' => $uuid, "controller"=>"acc_journal_lines", "action" => "edit"), "class" => "form-horizontal",	"inputDefaults" => array("label" => false, "div" => false)));
			?>
			<div class="panel-body bg-silver">
				<div class="form-group row m-b-15">
					<label class="col-form-label col-md-2">Nama Perkiraan</label>
					<div class="col-md-10">
						<?= $this->Form->control('line_coa_id', ['label' => false, 'class' => 'form-control coaLedger', 'id'=>'rowCOA', "style"=>"width:400px;", 'options' => [$accJournalLine->coaGroupId => $accJournalLine->coaGroupName]]); ?>

						 

						<?php
						//<select class="form-control coaLedger" id='rowCOA' name="cart[ledger_id]" style="width:400px;"></select>
						//echo $accJournalLineCOAId;
						// echo $this->Form->input('cart.ledger_id', array("empty" => false, "options"=>$data['rowAccount'], "data-placeholder"=>"Silakan pilih..", "class" => "form-control", "id"=>"select2insidemodal", 'default'=>$accJournalLineCOAId));
						echo $this->Form->control('line_user_id', ['type' => 'hidden', 'value' => $getUser->id, 'id'=>'isUpdate']);

						// echo $this->Form->input('cart.is_update', array('type' => 'hidden', 'id'=>'isUpdate', 'value' => $session['id']));
						?>
					</div>
				</div>
				<div class="form-group row m-b-15">
					<label class="col-form-label col-md-2">Uraian</label>
					<div class="col-md-10">
						<?php
						echo $this->Form->input('line_desc', array("type"=>"textarea", "rows" => "2", "cols"=>"40", "class"=>"form-control", "id"=>"descLedger", 'placeholder' => 'Keterangan..', 'value'=>$accJournalLineName));
						?>
					</div>
				</div>
				<div class="form-group row m-b-15">
					<label class="col-form-label col-md-2">Debit</label>
					<div class="col-md-4">
						<?php
						echo $this->Form->input('line_debet_amount', array("autocomplete"=>"off", 'class'=>'form-control auto', "id"=>"amountDebetLedger", 'placeholder' => 'Debit..', 'value'=>$accJournalLineDebet)); 
						?>
					</div>
					<label class="col-form-label col-md-2">Kredit</label>
					<div class="col-md-4">
						<?php
						echo $this->Form->input('line_credit_amount', array("autocomplete"=>"off", 'class'=>'form-control auto', "id"=>"amountCreditLedger", 'placeholder' => 'Kredit..', 'value'=>$accJournalLineCredit));
						?>
					</div>
				</div>
			</div>			
			<div class="panel-footer text-right bg-orange">
			    <?php
			    echo $this->Form->button('<i class="fas fa-save"></i>', ['class'=>'btn btn-indigo', 'type'=>'button', 'escapeTitle' => false, 'id'=> 'addToCart']);

			    // echo $this->Form->button('<i class="fa fa-save"></i>', array('class'=>'btn btn-purple', 'type'=>'button', 'escape' => false, 'id'=>'addToCart'));	
				?>
			</div>
			<?php echo $this->Form->end();?>
		</div>
		<div class="modal-footer">
			<a href="javascript:;" class="btn btn-warning" data-dismiss="modal">Close</a>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'artama_acc_journal_lines', 'action' => 'edit', $accJournalLine->id], ['fullBase' => true]); ?>";
    // handleFormConfirmSubmitValid('AccJournalLineEditForm', 'addToCart', confirmTitle, formAction);

    var checkCOAbyName = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'artama_acc_chart_of_accounts', 'action' => 'getCoa', 5], ['fullBase' => true]); ?>";
    handleFormSelect2Search('rowCOA', 'Masukkan Nama Perkiraan', 2, checkCOAbyName);
	
	$('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});

	$('input[id="amountDebetLedger"]').bind("keyup change", function(e) {
		$('input[id="amountCreditLedger"]').val('');
	});

	$('input[id="amountCreditLedger"]').bind("keyup change", function(e) {
		$('input[id="amountDebetLedger"]').val('');
	});

	$("#select2insidemodal").select2({
		dropdownParent: $("#ajax-modal"),
		width: '100%'
	});


	$('#addToCart').click(function(){
		var select2insidemodal = $("#select2insidemodal").val();
        var isUpdate = $("#isUpdate").val();
       	var rowCOA = $('#rowCOA').val();
        var descLedger = $('#descLedger').val();
        var amountDebetLedger = $("#amountDebetLedger").val();
        var amountCreditLedger = $("#amountCreditLedger").val();
       

        if(descLedger == '' || descLedger == null ){
            swal("Warning","Uraian tidak boleh kosong","warning");
            //$("#txtNumber").focus();
            return;
        } else {
	    	var $form = $(this).closest('form');
	        bootbox.confirm(confirmTitle, function(result) {
	            if(result==true) {
	                $form.attr('action', formAction);
	                
	                var value = {
	                    is_update: isUpdate,
	                    ledger_id: select2insidemodal,
                        coa_id: rowCOA,
                        desc: descLedger,
                        debet_amount:amountDebetLedger,
                        credit_amount:amountCreditLedger,
	                };
	                
	                $.ajax({
	                    type: "post",
	                    async: true,
	                    cache: false,
	                    dataType: "html",
	                    data: value,
	                    url: formAction,
	                   	headers: {
			            	'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
			            },
	                    success: function(data, textStatus, jqXHR) {
	                        //$('#ajax-modal').modal('show');
	                        
	                        var table = $('#myTable').DataTable(); 
	                        table.ajax.reload( null, false );
	                        swal({
	                          title: "Berhasil",
	                          text: "Data berhasil disimpan.",
	                          timer: 3500,
	                          button: false,
	                          icon: "success"
	                        });
	                        

	                        $("#addToCart").prop("disabled", false);
	                        //document.getElementById("addToCart").disabled = false;
	                        $('#ajax-modal').modal('hide');
	                    },
	                    error: function(jqXHR, textStatus, errorThrown) {
	                       swal("Error!", textStatus, "error");
	                    }
	                });

	            }
	        }); 
		}
    });

});
</script>