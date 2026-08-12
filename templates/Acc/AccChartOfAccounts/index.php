<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount[]|\Cake\Collection\CollectionInterface $accChartOfAccounts
 */
use Cake\Utility\Text;
?>
<?= $this->Krs->breadcrumb('Accounting', 'Perkiraan', 'Kelompok') ?>
<?php
// bg-gray-transparent-1
?>
<div class="panel panel-inverse">
    <div class="panel-body bg-gray-100">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['controller' => 'AccChartOfAccounts', 'action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <!-- <?= $this->Html->link('Template Excel', ['action' => 'templateExcel'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?> -->
                            <?= $this->Html->link('Excel', ['action' => 'xls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                /*
                <div class="btn-group pull-right">
                    <div class="portlet-body">
                        <?= $this->Form->create(null, ['type' => 'get']) ?>
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1" type="text" placeholder="Cari data ..." aria-label="Search" name="key" value="<?= $this->request->getQuery('key'); ?>">
                            <div class="input-group-append">
                                <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                */
                ?>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'post']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                 <div class="row row-space-10">                    
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterId', array('class' => 'form-control', 'required' => false, 'placeholder'=>'ID..', 'value'=>$dataLink['filterId']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterCode', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Kode..', 'value'=>$dataLink['filterCode']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterName', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Nama..', 'value'=>$dataLink['filterName']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->button('<i class="fas fa-search"></i>', array('class'=>'btn btn-warning width-60 m-r-10', 'type'=>'submit', 'id'=> 'btnSearch', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Cari"));
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>                            
                            <th width="30">ID</th>
                            <th>Nama</th>
                            <th width="50">Level</th>
                            <th width="40">Transaksi</th>
                            <th width="120">Jenis Jurnal</th>
                            <th width="100">Saldo Normal</th>
                            <th width="100">Post</th>
                            <th width="100">Saldo Awal-Debet</th>
                            <th width="100">Saldo Awal-Credit</th>
                            <th width="100">Saldo Akhir-Bank</th>
                            <th width="100">Permintaan Dana (D)</th>
                            <th width="100">Permintaan Dana (C)</th>
                            <th width="100">Posisi</th>
                            <th class="with-btn text-center" nowrap width="100">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //<th width="100">Kode</th>
                        $no = 1;
                        if (count($accChartOfAccounts) > 0) {
                            foreach ($accChartOfAccounts as $index => $data) :
                                $customer = $data['Customer'];

                                $codeCoa = ($data->level==4) ? "<b>".$data->code."</b>" : $data->code;
                                $statusTransaction = ($data->transaction=="y")? '<i class="fa fa-check"></i>':'';
                                $journalType = (empty($data->journal_type)) ? "" : $this->Krs->selectCOAType($data->journal_type);
                                $statusNormalBalance = (empty($data->normal_balance)) ? "" : $this->Krs->statusDC($data->normal_balance);
                                $statusGroup = (empty($data->groups)) ? "" : $this->Krs->statusPost($data->groups);
                                $journalBeginningBalanceDebet = (empty($data->beginning_balance_debet)) ? "" : $this->Krs->nom($data->beginning_balance_debet);
                                $journalBeginningBalanceCredit = (empty($data->beginning_balance_credit)) ? "" : $this->Krs->nom($data->beginning_balance_credit);
                                $journalEndingBalanceBank = (empty($data->ending_balance_bank)) ? "" : $this->Krs->nom($data->ending_balance_bank);
                                $dataLevel = $data->level;
                                $dataEndingBalanceBank = (empty($data->ending_balance_bank)) ? "" : $this->Krs->nom($data->ending_balance_bank);

                                //getParam URL
                                $getParam = $this->request->getAttribute('params');
                                // pr($getParam);

                                $getParamCode = (isset($getParam['?']['page'])) ? $getParam['?']['page'] : '';
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id, $getParamCode);
                                //, '?' => ['page'=>$getParam['?']['page']]
                                $linkDelete = array('action' => 'delete', $data->id);
                                $linkEndingBalance = array('action' => 'endingBalance', $data->id);
                                $dataSts = ($data->is_active == 'Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                                
                                // pr($getParam['?']);

                                if($dataLevel==1){
                                    $classCondition = "";
                                }elseif($dataLevel==2){
                                    $classCondition = 'class="table-warning"';
                                }elseif($dataLevel==3){
                                    $classCondition = 'class="table-danger"';
                                //}elseif($dataLevel==){
                                //    $classCondition = 'class="table-danger"';
                                }elseif($dataLevel==4){
                                    $classCondition = 'class="table-success"';
                                } else {
                                    $classCondition = "";
                                }

                                if($dataLevel>3){
                                    //$buttondown = $this->Form->postLink('<i class="fa fa-arrow-down"></i>', ['action' => 'moveDown',$data->id], ['confirm' => __('Are you sure you want to move down # {0}?',$data->id)]);

                                    $bottonup = $this->Html->link('<i class="fa fa-arrow-up"></i>', array('controller' => 'AccChartOfAccounts', 'action'=>'moveUp', $data->id), array("escape"=>false));
                                    $buttondown = $this->Html->link('<i class="fa fa-arrow-down"></i>', array('controller' => 'AccChartOfAccounts', 'action'=>'moveDown', $data->id), array("escape"=>false));
                                } else {
                                    $bottonup = '';
                                    $buttondown = '';
                                }
                                $dataName = (empty($data->name)) ? "" : $this->Text->truncate($data->name, 40, array('ellipsis' => '...', 'exact' => false)); 
                                //<td>$data->code</td>
                                //str_repeat('&nbsp;&nbsp;&nbsp;', $data->level).'('.$codeCoa.') '.$dataName;
                                //$this->Krs->btn('delete', $linkDelete, $data->name)

                                // Tombol untuk Permintaan Dana Debet
                                $statusSubmissionDebetHiddenActive = ($data->submission_debet=='Y') ? "": ' style="display: none;"';
                                $statusSubmissionDebetHiddenInactive = ($data->submission_debet=='N') ? "": ' style="display: none;"';
                                $btnSubmissionDebet = "<div id='statusSubmissionDebetSpin".$data->id."'></div>";
                                $btnSubmissionDebet .= "<div id='statusSubmissionDebetActive".$data->id."'".$statusSubmissionDebetHiddenActive.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusSubmissionDebetActive('".$data->id."', 'N', '".$getUser->id."')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>";

                                $btnSubmissionDebet .= "<div id='statusSubmissionDebetInactive".$data->id."'".$statusSubmissionDebetHiddenInactive.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusSubmissionDebetInactive('".$data->id."', 'Y', '".$getUser->id."')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";
                                $checkSubmissionDebet = ($dataLevel==4) ? $btnSubmissionDebet : '';

                                // Tombol untuk Permintaan Dana Credit
                                $statusSubmissionCreditHiddenActive = ($data->submission_credit=='Y') ? "": ' style="display: none;"';
                                $statusSubmissionCreditHiddenInactive = ($data->submission_credit=='N') ? "": ' style="display: none;"';
                                $btnSubmissionCredit = "<div id='statusSubmissionCreditSpin".$data->id."'></div>";
                                $btnSubmissionCredit .= "<div id='statusSubmissionCreditActive".$data->id."'".$statusSubmissionCreditHiddenActive.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusSubmissionCreditActive('".$data->id."', 'N', '".$getUser->id."')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>";

                                $btnSubmissionCredit .= "<div id='statusSubmissionCreditInactive".$data->id."'".$statusSubmissionCreditHiddenInactive.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusSubmissionCreditInactive('".$data->id."', 'Y', '".$getUser->id."')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";
                                $checkSubmissionCredit = ($dataLevel==4) ? $btnSubmissionCredit : '';
                        ?>
                                <tr <?= $classCondition ?>>
                                    <td><?= '<b>'.$data->id.'</b>' ?></td>
                                    <td><?= $codeCoa.'<br><b>'.$dataName.'</b>'; ?></td>
                                    <td class="text-center"><span class="badge bg-danger  rounded-pill px-3"><?= $data->level ?></span></td>
                                    <td class="text-center"><?= $statusTransaction ?></td>
                                    <td class="text-center"><?= $journalType ?></td>
                                    <td class="text-center"><?= $statusNormalBalance ?></td>
                                    <td class="text-center"><?= $statusGroup ?></td>
                                    <td class="text-right"><?= $journalBeginningBalanceDebet ?></td>
                                    <td class="text-right"><?= $journalBeginningBalanceCredit ?></td>
                                    <td class="text-right"><?= $dataEndingBalanceBank ?></td>
                                    <td class="text-center"><?= $checkSubmissionDebet ?></td>
                                    <td class="text-center"><?= $checkSubmissionCredit ?></td>
                                    <td class="text-center"><?= $bottonup.'&nbsp;&nbsp;'.$buttondown ?></td>
                                    <td class="with-btn" nowrap>
                                        <?php
                                          if ($dataLevel == 4) {
                                            echo '<button class="btn btn-purple btn-sm m-r-5 p-l-15 p-r-15 open-ending-balance-modal"data-id="' . $data->id . '" data-toggle="modal" data-target="#endingBalanceModal" title="Saldo Akhir">
                                            <i class="fa fa-dollar-sign"></i></button>';
                                          }
                                        ?> 
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                        <?= $this->Krs->btn('delete', $linkDelete, $data->name) ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            endforeach;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>



<!-- modal  -->
<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog">
</div>

<!-- modal Saldo Akhir -->
<div class="modal fade" id="endingBalanceModal" tabindex="-1" role="dialog" aria-labelledby="endingBalanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <?= $this->Form->create(null, ['url' => ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'endingBalance'], 'id' => 'endingBalanceForm']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="endingBalanceModalLabel">Saldo Akhir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->hidden('id', ['id' => 'endingBalanceId']); ?>
                <div class="form-group">
                <?= $this->Form->control('ending_balance_bank', [
                    'label' => 'Saldo Akhir',
                    'class' => 'form-control auto',
                    'required' => true
                ]); ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>

<?php
// $urlStatusData = $this->Html->url(array('event_id' => $uuid, "controller" => "acc_chart_of_accounts", "action" => "status_pca"));
$urlStatusData = $this->Url->build(['controller'=>'acc_chart_of_accounts', 'action' => 'status_submission'], ['fullBase' => true]);
?>

<script type="text/javascript">
jQuery(document).ready(function() {
    var confirmTitleUpload = "Apakah anda ingin mengupload data tersebut ?";
    var formActionUpload = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'importExcel'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupUploadForm', 'btn-upload', confirmTitleUpload, formActionUpload);
	"use strict";

    $(document).on('click', '.open-ending-balance-modal', function () {
        var orderId = $(this).data('id'); 
        console.log(orderId);
        $('#endingBalanceId').val(orderId); 
    });
    function autoNumber() {
        $('input.auto').autoNumeric({aSep: '.', aDec: ',', vMax: '99999999999'});
        $('input.qty').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000'});
        $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});
    }
    autoNumber();

	$(".select2FormClear").select2({ allowClear: true });

	window.changeStatusSubmissionDebetActive = function(status, values, userId){
		if (!$('#statusSubmissionDebetActive'+status).attr('complete')) {
			$('#statusSubmissionDebetSpin'+status).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
			$('#statusSubmissionDebetActive'+status).hide();
		}		
		
		if(status.length != 0) {
            const varCond = "debet";
			$.ajax({
	            type: 'POST', // Metode pengiriman data menggunakan POST
	          	url: '<?php echo $urlStatusData; ?>', // File pemroses data
	          	data: {
                    cond:varCond, id:status, yn:values,user:userId
                }, 
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                // data: 'cond=debet&id=' + status + '&values=' + values + '&userId=' + userId, // Data yang akan dikirim ke file pemroses
	           	
	           	cache: false,
                async: true,
	         	success: function(response) { // Jika berhasil
	         	    // alert(response);
		         	if(response=='Y') {
		         		$('#statusSubmissionDebetActive'+status).show();
		         	} 
		         	if(response=='N') {
		         		$('#statusSubmissionDebetInactive'+status).show();
		         	}
	              	$('#statusSubmissionDebetSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
	           	},
                error: function() {
                    // alert('gagal');
                    $('#statusSubmissionDebetSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                    console.log('error');
                }
	       	});	
		} else {
			 $('#statusSubmissionDebetSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
		}
	}

	window.changeStatusSubmissionDebetInactive = function(status, values, userId){
		if (!$('#statusSubmissionDebetInactive'+status).attr('complete')) {
			$('#statusSubmissionDebetSpin'+status).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
			$('#statusSubmissionDebetInactive'+status).hide();
		}

		if(status.length != 0) {
            const varCond = "debet";
			$.ajax({
	            type: 'POST', // Metode pengiriman data menggunakan POST
	          	url: '<?php echo $urlStatusData; ?>', // File pemroses data
                data: {
                    cond:varCond, id:status, yn:values,user:userId
                }, 
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },

	           	// data: 'cond=debet&id=' + status + '&values=' + values + '&userId=' + userId, // Data yang akan dikirim ke file pemroses
	           	cache: false,
                async: true,
	         	success: function(response) { // Jika berhasil
	         		// alert(response);
		         	if(response=='Y') {
		         		$('#statusSubmissionDebetActive'+status).show();
		         	} 
		         	if(response=='N') {
		         		$('#statusSubmissionDebetInactive'+status).show();
		         	}
	               	$('#statusSubmissionDebetSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
	           	},
                error: function() {
                    // alert('gagal');
                    $('#statusSubmissionDebetSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                    console.log('error');
                }
	       	});	
		} else {
			 $('#statusSubmissionDebetSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
		}
	}

    window.changeStatusSubmissionCreditActive = function(status, values, userId){
		if (!$('#statusSubmissionCreditActive'+status).attr('complete')) {
			$('#statusSubmissionCreditSpin'+status).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
			$('#statusSubmissionCreditActive'+status).hide();
		}		
		
		if(status.length != 0) {
            const varCond = "credit";
			$.ajax({
	            type: 'POST', // Metode pengiriman data menggunakan POST
	          	url: '<?php echo $urlStatusData; ?>', // File pemroses data
	          	data: {
                    cond:varCond, id:status, yn:values,user:userId
                }, 
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },
                // data: 'cond=debet&id=' + status + '&values=' + values + '&userId=' + userId, // Data yang akan dikirim ke file pemroses
	           	
	           	cache: false,
                async: true,
	         	success: function(response) { // Jika berhasil
	         	    // alert(response);
		         	if(response=='Y') {
		         		$('#statusSubmissionCreditActive'+status).show();
		         	} 
		         	if(response=='N') {
		         		$('#statusSubmissionCreditInactive'+status).show();
		         	}
	              	$('#statusSubmissionCreditSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
	           	},
                error: function() {
                    // alert('gagal');
                    $('#statusSubmissionCreditSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                    console.log('error');
                }
	       	});	
		} else {
			 $('#statusSubmissionCreditSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
		}
	}

	window.changeStatusSubmissionCreditInactive = function(status, values, userId){
		if (!$('#statusSubmissionCreditInactive'+status).attr('complete')) {
			$('#statusSubmissionCreditSpin'+status).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
			$('#statusSubmissionCreditInactive'+status).hide();
		}

		if(status.length != 0) {
            const varCond = "credit";
			$.ajax({
	            type: 'POST', // Metode pengiriman data menggunakan POST
	          	url: '<?php echo $urlStatusData; ?>', // File pemroses data
                data: {
                    cond:varCond, id:status, yn:values,user:userId
                }, 
                headers: {
                    'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                },

	           	// data: 'cond=debet&id=' + status + '&values=' + values + '&userId=' + userId, // Data yang akan dikirim ke file pemroses
	           	cache: false,
                async: true,
	         	success: function(response) { // Jika berhasil
	         		// alert(response);
		         	if(response=='Y') {
		         		$('#statusSubmissionCreditActive'+status).show();
		         	} 
		         	if(response=='N') {
		         		$('#statusSubmissionCreditInactive'+status).show();
		         	}
	               	$('#statusSubmissionCreditSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
	           	},
                error: function() {
                    // alert('gagal');
                    $('#statusSubmissionCreditSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                    console.log('error');
                }
	       	});	
		} else {
			 $('#statusSubmissionCreditSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
		}
	}
    });
</script>