<?php
// echo $this->Html->css(array(
//     		'/plugins/bootstrap-sweetalert/sweetalert',
// 		), array('fullBase' => true));

// echo $this->Html->script(array(							
// 			'/plugins/bootstrap-sweetalert/sweetalert.min',
// 		), array('fullBase' => true));

// echo $this->Html->script(array('/acc/js/jquery.krs'), array('fullBase' => true));
$pages = (empty($this->params["named"]["page"]))?"":"/page:".$this->params["named"]["page"];
$dataTitle = $data['page'];
$dataParent = $this->Html->link('Beranda', array('event_id' => $uuid, 'controller' => 'users', 'action' => 'home', 'full_base' => true));
$dataChild = "Acc";
$dataGrandChild = $this->Html->link($dataTitle, array('event_id' => $uuid, 'controller' => 'acc_journals', 'action' => 'index', 'full_base' => true));
$dataGreatGrandChild = $data["breadcrumb"];

echo $this->Krs->breadcrumbEdit($dataParent,$dataChild,$dataGrandChild,$dataGreatGrandChild,$dataTitle);

//Menampilkan pesan error.
echo $this->Krs->errorModel($data['validationError']);

$cartJurnalProcess = $this->Html->url(array('event_id' => $uuid, "controller" => "acc_journals", "action" => "add_cart_one"));

$checkCode = $this->Html->url(array('event_id' => $uuid, 'controller' => 'acc_journals', 'action' => 'checkcode', 'full_base' => true));

$UserId = $this->Session->read("Auth.User.id");
//$urlImg = $this->Html->url(array("controller" => "img", "action" => "/", "input-spinner.gif", 'full_base' => true));
//$getData = $this->Html->url(array('event_id' => $uuid, "controller" => "acc_journals", "action" => "addrowgrid/kas", 'full_base' => true));
$optionDC = array("D"=>"Debit", "C"=>"Kredit");
// pr($data['rowAccount']);

$dataAccounts = $this->Krs->_getCOA($data['rowAccount'], 'Default');
//pr($dataAccounts);
?>
<div class="panel panel-inverse">
	<div class="panel-heading">
	    <div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Perincian</h4>
	</div>
	<?php
	echo $this->Form->create("AccJournal", array("id" => "fileinfo", "enctype"=>"multipart/form-data", "url" => array('event_id' => $uuid, "controller"=>"acc_journals", "action" => "add_many"), "class" => "form-horizontal",	"inputDefaults" => array("label" => false, "div" => false)));
	//echo $this->Form->create("AccJournal", array("url" => array('event_id' => $uuid, "controller"=>"petty_cashes", "action" => "add"), "class" => "form-horizontal", "inputDefaults" => array("label" => false, "div" => false)));
	?>
	<div class="panel-body bg-warning-transparent-4">
		<div class="form-group row m-b-15">
			<label class="col-form-label col-md-2">Cabang</label>
			<div class="col-md-3">
				<?php
				echo $this->Form->input('branch_id', array("empty" => false, 'options'=>$data['getListBranch'], 'class'=>'form-control select2', "id"=>"select-populate-branch"));
				?>
			</div>
		</div>
		<div class="form-group row m-b-15">

			<?php
			/*
			<label class="col-form-label col-md-2">Cabang</label>
			<div class="col-md-4">
				<div class="input-group">
					<?php
					if(count($data['branchId']) > 1) {
							arsort($data['getListBranch']);
							echo $this->Form->input("branch_id", array("empty" => false, "options"=>$data['getListBranch'], "class"=>"form-control select2", "data-placeholder"=>"Silakan pilih..", "id"=>"select-populate-branch"));
					} else {
						echo '<input type="text" readonly class="form-control-plaintext" value="'.$data['getListBranch'][$data['branchId'][0]].'">';
						// echo $data['getListBranch'][$data['branchId'][0]];
						echo $this->Form->input('branch_id', array('type' => 'hidden', 'value' => $data['branchId'][0]));
					}
					?>
				</div>
			</div>
			*/
			?>
			<label class="col-form-label col-md-2">Kode</label>
			<div class="col-md-4">
				<div class="input-group">
				<?php
				echo $this->Form->input('is_create', array('type' => 'hidden', 'value' => $session['id']));
				echo $this->Form->input("code", array('id' => 'accJournal-code', "class" => "form-control accJournal-codes", "value" => $data['maxNumber'], "error" => false, "required"=>false, 'autocomplete' => 'off'));
				?>
				<span class="input-group-addon"><i id="loading-check-image"></i></span>
				</div>
				<p class="help-block"><i id="loading-check-desc"><i class="fa fa-microphone"></i> Silakan masukkan kode untuk mengecek..</i></p>
			</div>
			<label class="col-form-label col-md-2">Jenis Jurnal</label>
			<div class="col-md-2">
				<div class="input-group">
					<?php
					echo $this->Form->input("journal_type", array("empty" => false, "options"=>$this->Krs->journalType(), "class"=>"form-control select2", "data-placeholder"=>"Silakan pilih..", "autofocus"=>"autofocus", "id"=>"select-populate", "default"=>"Memorial"));
					echo $this->Form->input('branch_id', array('type' => 'hidden', 'value' => '1'));
					?>
				</div>
			</div>
		</div>
		<div class="form-group row m-b-15">
			
			<label class="col-form-label col-md-2">Tanggal</label>
			<div class="col-md-4">
				<div class="row">
	                <div class="col-md-4">
					<?php
					echo $this->Form->input('date_journal', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'dd-mm-yyyy', 'value'=>date('d-m-Y')));
					?>
					</div>
				</div>
			</div>
		</div>
		<?php
		/*
		<div class="form-group row m-b-15">
			<label class="col-form-label col-md-2">Penyetor/Penerima</label>
			<div class="col-md-10">
				<div class="row">
					<div class="col-md-3">
						<?php
						echo $this->Form->input("recipient_payer_id", array("empty" => true, "options"=>$data['rowRecipientPayer'], "class"=>"form-control select2", "data-placeholder"=>"Silakan pilih..", "autofocus"=>"autofocus")); 
						?>
					</div>
					<div class="col-md-9">
						<?php
						echo $this->Form->input("customer_id", array("empty" => true, "options"=>$data['rowCustomer'], "class"=>"form-control select2", "data-placeholder"=>"Silakan pilih.."));

						?>
					</div>
				</div>
			</div>
		</div>
		*/
		?>
		<div class="form-group row m-b-15">
			<label class="col-form-label col-md-2">Cek/BG</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input("cek_bg", array("class" => "form-control", "error" => false, "required"=>false));
				?>
			</div>
			<label class="col-form-label col-md-2">No. Ref</label>
			<div class="col-md-4">
				<?php
				echo $this->Form->input("no_ref", array("class" => "form-control", "error" => false, "required"=>false));
				?>
			</div>
		</div>
		<div class="table-responsive">
	    	<table class="table m-b-0" id="tblGridToCart">
				<thead>
					<tr>
						<th>Nama Perkiraan</th>
						<th width="30%">Uraian</th>
						<th width="10%">Jumlah Debit</th>
						<th width="10%">Jumlah Kredit</th>
						<th width="6%"></th>
					</tr>
				</thead>
							
				<tbody>
					<?php 
					//for($a=0;$a<=1;$a++){
					$a=0
					?>
					<tr class="warning">
						<td>
							<?php
							echo $this->Form->input('cart.ledger_id.'.$a, array("empty" => false, "options"=>$dataAccounts, "id"=>"ledgerId", "data-placeholder"=>"Silakan pilih..", "class" => "form-control select2"));
							?>
						</td>
						<td>
							<?php 
							echo $this->Form->input('cart.desc.'.$a, array("type"=>"textarea", "rows" => "2", "cols"=>"20", "class"=>"form-control", "id"=>"descLedger", 'placeholder' => 'Keterangan..'));
							//, $readonlyDesc
							?>
						</td>
						<td>
							<?php 
							echo $this->Form->input('cart.debet_amount.'.$a, array("autocomplete"=>"off", 'class'=>'form-control auto', "id"=>"amountDebetLedger", 'placeholder' => 'Debit..')); 
							?>
						</td>
						<td>
							<?php 
							echo $this->Form->input('cart.credit_amount.'.$a, array("autocomplete"=>"off", 'class'=>'form-control auto', "id"=>"amountCreditLedger", 'placeholder' => 'Kredit..'));
							//echo $this->Form->input('cart.linetotalDebet.'.$a, array("id"=>"line-total-debet", "class"=>"lineTotalDebet".$a, "type" => "hidden"));
							//echo $this->Form->input('cart.linetotalCredit.'.$a, array("id"=>"line-total-credit", "class"=>"lineTotalCredit".$a, "type" => "hidden"));
							?>
						</td>
						<td align="right">									
							<?php 
							//if($a==0) {
								echo $this->Form->button('<i class="fa fa-plus"></i>', array('class'=>'btn btn-purple', 'type'=>'button', 'escape' => false, 'id'=>'addToCart'));								
							//}
							?>
						</td>								
					</tr>
					<?php
					//}
					?>
				</tbody>
				<?php
				/*
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
							echo $this->Form->button('<i class="fas fa-cart-plus"></i>', array('class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'id'=>'addToProject', 'escape' => false, 'disabled'=>'disabled'));
							?>
						</td>
					</tr>
				</thead>
				*/
				?>
			</table>
			
		</div>
		
		<hr class="bg-orange" />
		<div class="form-group row m-b-15">
			<div class="col-md-12">
				<h5>
        			Data yang diJurnal:<span id="loading-image-cart"></span>
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
						<?php
						/*
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
									//echo $this->Form->button('<i class="fas fa-cart-plus"></i>', array('class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'id'=>'addToProjects', 'escape' => false, 'disabled'=>'disabled'));
									?>
								</td>
							</tr>
						</thead>
						*/
						?>
					</div>
								
			</div>
		</div>
	</div>
	<div class="panel-footer text-right bg-orange">
	    <?php
	 	// echo "Centang (Cetak) ";
		// echo $this->Form->hidden('print', array('value' => 'N'));
		// echo $this->Form->input('print', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox'));

		// echo "&nbsp;&nbsp;";
		// echo "Centang (Posting) ";
		// echo $this->Form->hidden('status', array('value' => 'N'));
		// echo $this->Form->input('status', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox'));
		
		// echo "&nbsp;&nbsp;";
	    //echo $this->Form->button('<i class="fa fa-sun-o"></i> Simpan', array('class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add')); 
	    echo $this->Form->button('Simpan', array('class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add', 'disabled'=>'disabled'));
		?>
	</div>
	<?php echo $this->Form->end();?>
</div>
<?php
//pr($dataAccounts);
?>

<script type="text/javascript">
jQuery(document).ready(function() { 
	datePicker('date-picker', 'dd/mm/yyyy');	
	
	var confirmSave = "Apakah anda yakin menyimpan data Umum ?";
	var formAction = "<?php echo $this->Html->url(array('event_id' => $uuid, 'controller'=>'acc_journals', 'action' => 'add_only_one/'.$pages)); ?>";
	submitForm('btn-add', confirmSave, formAction);
	
	$("table#tblGridToCart").on("click", '#addToCart', function (event) {
		var dataForm = JSON.stringify($('form').serializeArray());
		var dataLink = btoa(encodeURIComponent(btoa(dataForm)));
	
		if(dataLink.length != 0) {	
			$.ajaxSetup({ cache: false, async: true});
			$.getJSON('<?php echo $cartJurnalProcess; ?>', 
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
	            $("#ledgerId").val('').trigger('change');
	            $('input[id="descLedger"], textarea').val('');
	           	$('input[id="amountDebetLedger"]').val('');
				$('input[id="amountCreditLedger"]').val('');
				//$('input[id="line-total-debet"]').val('');
				//$('input[id="line-total-credit"]').val('');
				
				showGridCart();
	        }).fail(function() {
			    alert( "Maaf ada kesalahan pada tambah jurnal, silakan hubungi admin.." );
			});
		}		
	});

	$('input[id="amountDebetLedger"]').bind("keyup change", function(e) {
		$('input[id="amountCreditLedger"]').val('');
	});

	$('input[id="amountCreditLedger"]').bind("keyup change", function(e) {
		$('input[id="amountDebetLedger"]').val('');
	});

	//Remove items from cart
	$("table#tblGridCart").on('click', '#removeCart', function(e) {
		var codeId = $(this).data('code');
		//alert(codeId);
		if(codeId.length != 0) {
			$.ajaxSetup({ cache: false, async: true});
			$.getJSON('<?php echo $cartJurnalProcess; ?>', 
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
			    alert( "Maaf ada kesalahan program, silakan hubungi admin.." );
			});
		}
	});

	showGridCart();

	function showGridCart() {
		if (!$('#loading-image-cart').attr('complete')) {
			$('#loading-image-cart').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
		}
		
		$("#tblGridCart").load("<?php echo $cartJurnalProcess; ?>?cond=view", function(responseTxt, statusTxt, xhr){
			var grantotalSelisih = $(responseTxt).find('#grandTotalSelisih').text();

			//alert(tempDom);
			//alert(responseTxt.length);
	        if(statusTxt == "success") {
	            $('#loading-image-cart').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
	        }
	        if(statusTxt == "error") {
	        	alert( "Maaf ada kesalahan program, silakan hubungi admin..! 'Error': " + xhr.status + ": " + xhr.statusText );
		    	$('#loading-image-cart').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
		    	$("#btn-add").prop("disabled", true);
	        }
	      	//alert(responseTxt.length);

	        if(responseTxt.length<=304) {
	        	$("#btn-add").prop("disabled", true);
	        } else {
	        	if(grantotalSelisih==0 && responseTxt.length>640) {
	        		$("#btn-add").prop("disabled", false);
	        	} else {
	        		$("#btn-add").prop("disabled", true);
	        	}
	        	//
	        }
	    });
	    //alert($("#tblGridCart").length);
	}

	function autoLoad() {
		$('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});
		$('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});

		$("table tr #dr-diff").css("font-weight", "bold");
		$("table tr #cr-diff").css("font-weight", "bold");

		$(".select2").select2();
    	$(".select2-clear").select2({ allowClear: true });
    	$(".select2-multiple").select2({ placeholder: "Select a state", allowClear: true });
	}
	autoLoad();

	$('#select-populate-branch').on('change', function() {
		if (!$('#loading-check-image').attr('complete')) {
			$('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
		}

		var checkCodeByType = "<?php echo $this->Html->url(array('event_id' => $uuid, 'controller'=>'acc_journals', 'action' => 'checkcodeByType')); ?>";
		var journalType = $('#select-populate').find('option:selected').val();

		if($(this).val().length != 0) {
			$.getJSON(checkCodeByType,
			{branch: $(this).val(), type:journalType},
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
		
		var checkCodeByType = "<?php echo $this->Html->url(array('event_id' => $uuid, 'controller'=>'acc_journals', 'action' => 'checkcodeByType')); ?>";
		<?php
		if(count($data['branchId']) > 1) {
		?>
		var journalBranch = $('#select-populate-branch').find('option:selected').val();
		<?php } else { ?>
		var journalBranch = <?php echo $data['branchId'][0]; ?>;
		<?php } ?>

		if($(this).val().length != 0) {
			$.getJSON(checkCodeByType,
			{branch: journalBranch, type: $(this).val()},
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

	function populateJournal(result) {
		// var options = '';
		$.each(result, function(id, value) {
			if (id=='code'){
				$( '#accJournal-code' ).val( value );
				//alert(value);
				//input-group-addon-type
			}
		});
	}

	function checkCodeForJurnal(idSelectBranch, idSelectType, idForm, checkCode, lengthKeyUp) {
		// $("#code").attr("maxlength", 10); 
		// var typeData = $('typeForm').val();

		$('#loading-check-image').ajaxComplete(function() {
			$('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
			// $('#loading-desc').html('').hide();
		});

		$('#' + idForm).on('keyup', function() {
			if ($(this).val().length == lengthKeyUp && !$('#loading-check-image').attr('complete')) {
				$('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
				// $('#loading-desc').html('Silakan masukkan kode untuk mengecek" />');
			}
			
			// alert($('#' + idForm).val());
			<?php
			if(count($data['branchId']) > 1) {
			?>
			var selectBranch = $('#' + idSelectBranch).find('option:selected').val();
			<?php } else { ?>
			var selectBranch = <?php echo $data['branchId'][0]; ?>;
			<?php } ?>
			var selectType = $('#' + idSelectType).find('option:selected').val();
			var cekcodes = checkCode + '?branch=' + selectBranch + '&type=' + selectType;
			if($(this).val().length == lengthKeyUp) {
			// if($(this).val().length != 0) {
				$.getJSON(cekcodes, {id: $(this).val()},
					function(resultCheck) {
						if(resultCheck !== null) {
							// alert(resultCheck);
							if(resultCheck == 0){
								$('#loading-check-desc').html('<i class="fa fa-check"></i> Kode bisa dipakai');
								
								var totalDebet = $("#grandTotalDebet").text().replace(/(?!^-)[^0-9\,]+/g,"");
								var totalCredit = $("#grandTotalCredit").text().replace(/(?!^-)[^0-9\,]+/g,"");
								
								if(totalDebet==totalCredit && (totalDebet>0 && totalCredit>0)) {
									$("#btn-add").prop("disabled", false);
								}							
							} else if(resultCheck == 1){
								$('#loading-check-desc').html('<i class="fa fa-times"></i> Maaf Kode tidak bisa dipakai..!');
								$("#btn-add").prop("disabled", true);
							} else{
			                   $('#loading-check-desc').html('<i class="fa fa-exclamation"></i> Database error!!');
			                   $("#btn-add").prop("disabled", true);
			                }
			                $('#loading-check-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
						}
					}
				);
			}
		});

		$('#code').keydown(function(e) {
			if (e.which == 32) {
				return false;
			}
		});
	}
});
</script>
<?php
?>