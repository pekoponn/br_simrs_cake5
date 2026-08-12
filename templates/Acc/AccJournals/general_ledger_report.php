<?php
use Cake\Utility\Hash;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal[]|\Cake\Collection\CollectionInterface $accJournals
 */
// pr($dataLink);
?>
<?= $this->Krs->breadcrumb('Accounting', 'Buku Besar', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-body bg-gray-100">
    	<?= $this->Form->create($accJournal) ?>
	    <div class="row">
			<div class="col-lg-1"></div>
			<div class="col-lg-10">
				<div class="panel panel-success">
					<div class="panel-heading">
			            <h4 class="panel-title">Cari data..</h4>
				        <div class="panel-heading-btn">
				            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				        </div>
			        </div>
			    	<div class="panel-body p-t-10">
			    		<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Nama Perkiraan (Level 4)</label>
							<div class="col-md-9">
								<?php
								// $dataAccounts = $this->Krs->_getCOA($data['account'], true);
								$dataAccounts = array();				
								echo $this->Form->input('filterLedgerGroupMulti', array('empty' => false, 'class' => 'form-control', 'id'=>'ledgerGroupCallId', 'type'=>'select'));
								//, 'multiple' => true
								?>
							</div>
						</div>
			       		<!-- <div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Nama Perkiraan (Level 5)</label>
							<div class="col-md-9">
								<?php
								// $dataAccounts = $this->Krs->_getCOA($data['account'], true);
								$dataAccounts = array();				
								echo $this->Form->input('filterLedgerMulti', array('empty' => false, 'class' => 'form-control', 'multiple' => true, 'id'=>'ledgerCallId', 'type'=>'select'));
								?>
							</div>
						</div> -->
						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Nama Perkiraan (Periode)</label>
							<div class="col-md-9">
								<div class="input-group">
									

									<?php
									//<select class="form-control" id='ledgerCallStartId' name="ledger_start" style="width:400px;"></select>
									//pr($dataAccount);

									// $dataAccounts = $this->Krs->getCOA($data['account'], true);
									$dataAccounts = array();
									echo $this->Form->input('filterLedgerStart', array('empty' => true, 'class' => 'form-control', 'id'=>'ledgerCallStartId', 'type'=>'select'));
									?>
									<div class="input-group-prepend">
								    <span class="input-group-text"> - </span>
								    </div>

									<?php
									echo $this->Form->input('filterLedgerEnd', array('empty' => true, 'class' => 'form-control', 'id'=>'ledgerCallEndId', 'type'=>'select'));
									?>
								</div>

								<?php
								
								?>
							</div>
						</div>

						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Bulan-Tahun</label>
							<div class="col-md-3">
								<div class="input-group">
									<div class="input-group input-daterange">
										<?php
										//div class="input-group input-small input-monthYear">
										// date-picker
										echo $this->Form->input("filterMYDate", array("class" => "form-control filterMY", 'id'=>'filterMonthYear', "autocomplete"=>"off", "error" => false, 'placeholder' => 'Bulan-Tahun...', "required"=>false, 'readonly' => true));
										?>
										<span class="input-group-append">
											<button class="btn btn-inverse filterMonthYearReset" type="button"><i class="fa fa-times"></i></button>
										</span>

									</div>
								</div>
							</div>
							<label class="col-form-label col-md-1">Tanggal</label>
							<div class="col-md-5">
								<?php
								echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Awal...'), 'filterDateEnd', array("class"=>"form-control filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Akhir...'), 's/d', 'resetDate');
								?>
							</div>
						</div>
						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Penanggung Jawab</label>
							<div class="col-md-6">
								<?php
								// echo $this->Form->input('filterRecipientPayerName', ['empty'=>true, 'options'=>$dataRowRecipientPayer, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2FormClear', 'autofocus'=>'autofocus', 'type'=>'select', 'id'=>'select-populates', 'default'=>'Memorial']);
								echo $this->Form->input('filterRecipientPayerName', array('class' => 'form-control', 'placeholder'=>'Penanggung Jawab..'));
								?>
							</div>
						</div>
						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Tampikan Kolom</label>
							<div class="col-md-9">
								<div class="custom-control custom-checkbox mb-1">
								<?php
								echo $this->Form->checkbox('filterCheckShow', array('value' => 'Y', 'hiddenField' => 'N', 'class' => 'checkboxes custom-control-input', 'id'=>'customCheck1'));
								?><label class="custom-control-label" for="customCheck1">Penanggung Jawab, Kode Jurnal dan Cabang</label>
								</div>
								<small class="f-s-12 text-grey-darker"><i class="fa fa-bullhorn"></i><i> Centang untuk menampilkan kolom tersebut..</i></small>
							</div>
						</div>			
					</div>
					<div class="panel-footer text-right bg-orange">
				    <?php
				    echo $this->Form->button('Tampilkan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-search']);
					?>
					</div>				
				</div>			
			</div>
		</div>	
		<?php echo $this->Form->end();?>
		<?php
		if(!empty($rowData)) {
			// pr($dataRows);
		?>
		<div class="panel-body">
			<legend class="m-b-15">
				<div class="table-toolbar">
					<div class="btn-group">
						<div class="portlet-body">
							Tanggal : 
							<?php 
							echo $data['dateTitle'];
							/*if(!empty($dataDate)) {
								list($dateStarts, $dateEnds) = explode('^', base64_decode($dataDate));
								$dateStart = $this->Krs->fDate($dateStarts, 'd M Y');
								$dateEnd = $this->Krs->fDate($dateEnds, 'd M Y');

								echo $dateStart.' sampai '.$dateEnd;
							} elseif(!empty($dataMonthYear)) {
								echo $dataMonthYear;
							}*/
							
							?>
						</div>
					</div>
					<div class="btn-group pull-right">
						<div class="btn-group dropdown">
	                        <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
	                        <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
	                        <div class="dropdown-menu dropdown-menu-right">
	                        <?= $this->Html->link('Pdf', ['action' => 'generalLedgerPdf'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
	                        <?= $this->Html->link('Excel', ['action' => 'generalLedgerXls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
	                        </div>
	                    </div>
					</div>
				</div>
			</legend>
			<br>

			<div class="portlet-body">
				<div class="table-responsive">
					<div data-scrollbar="true" data-height="400px">
						<table class="table table-striped table-hover">
							<thead class="thead-dark text-center">
								<tr>
									<tr>
										<th width="180">Cabang</th>
										<th>Uraian</th>
										<th width="40">COA ID Lawan Akun</th>
										<th width="40">D/K</th>
										<th width="120">Debit</th>
										<th width="120">Kredit</th>
										<th width="120">Keterangan</th>
									</tr>
								</tr>
							</thead>
							<tbody>
							<?php
							// $COA = Hash::combine(
							 			// $dataRows,
							 			// '{n}.acc_chart_of_account.id', '{n}.acc_chart_of_account.code');
							// pr($rowData);
							foreach ($rowData as $coaCode => $row) {
								list($COACode, $COAName, $COAGroupName, $COABeginningBalance, $COAGroup, $COAJournalType) = explode('^', $row['title']);

								//$totalBeginningBalance = 0;
								$totalBeginningBalance = round($COABeginningBalance, 2);
								// $totalBeginningBalance = round($beginningBalanceJournalTotal, 2)+round($beginningBalanceData,2);
								$beginningBalanceDate = '';
								$totalBeginningBalanceValue = $this->Krs->nom($totalBeginningBalance);
								//$totalBeginningBalanceValue = '';

								echo '<tr class="table-danger">
										<td colspan="4" class="bg-yellow-lemon">Nama Perkiraan: '.$COAGroupName.'</td>
										<td colspan="2" class="bg-yellow-lemon" align="right"><b>Saldo Awal : '.$beginningBalanceDate.'</b></td>
										<td align="right" class="bg-yellow-lemon"><b>'.$totalBeginningBalanceValue.'</b></td>
									</tr>';

								$totalDebets = array();
								$totalCredits = array();
								$totalTransaksis = array();
								$totalSaldos = array();
								foreach ($row['data'] as $rowData) {
									list($dataBranchName, $dataId, $dataCode, $dataDate, $dataName, $dataLedger, $dataDebets, $dataCredits, $dataRecipientPayerName, $coaIdLawan) = explode('^', $rowData);
									// $dataBranchName = '';

									$dataDebet = (!empty($dataDebets)) ? $dataDebets : 0;
									$dataCredit = (!empty($dataCredits)) ? $dataCredits : 0;
									$totalDebets[] = $dataDebet;
									$totalCredits[] = $dataCredit;
									$totalTransaksis[] = 1;
									$totalSaldo = ($dataLedger=='D') ? ($totalBeginningBalance+$dataDebet)-$dataCredit : ($totalBeginningBalance+$dataCredit)-$dataDebet;

									$totalSaldos[] = $totalSaldo;
									echo '<tr>
											<td align="left">';
											if($dataLink['filterCheckShow']=='Y') {
												echo '<b>Cabang </b>: '.$dataBranchName.'<br><b>Kode Jurnal</b> : '.$dataCode.'<br>';
											}
												echo '<b>Tanggal</b> : '.$dataDate.'</td>
											<td><b>Uraian</b> :<i>'.$dataName.'</i>';

											if($dataLink['filterCheckShow']=='Y') {
												echo '<br><b>Penanggung Jawab</b> : '.$dataRecipientPayerName;
											}

											echo '</td>
											<td align="center">'.$coaIdLawan.'</td>
											<td align="center">'.$dataLedger.'</td>
											<td align="right">'.$this->Krs->nom($dataDebet).'</td>
											<td align="right">'.$this->Krs->nom($dataCredit).'</td>
											<td align="right">'.$this->Krs->nom($totalSaldo).'</td>
										</tr>';

									//8109^2203-0001^09 Feb 2022^Terima Penarikan Dana Dari Rek 998^D^1152010.0000^
								}
							
							$totalTransaksi = count($totalTransaksis);
							$totalDebet = round(array_sum($totalDebets),2);
							$totalCredit = round(array_sum($totalCredits),2);
							$totalDC = round(array_sum($totalSaldos),2);
							// $totalSaldos
							// $totalDCs = ($totalBeginningBalance+$totalDebet)-$totalCredit;
							// $totalDC = round($totalDCs,2);
							
							$grandTotalDebet = $this->Krs->nom($totalDebet);
							$grandTotalCredit = $this->Krs->nom($totalCredit);
							$grandTotalDC = $this->Krs->nom($totalDC);
							echo '<tr class="table-warning">
									<td align="left" colspan="4"><b>Jumlah transaksi sebanyak : <i>'.$totalTransaksi.'</i></b></td>
									<td align="right"><b>'.$grandTotalDebet.'</b></td>
									<td align="right"><b>'.$grandTotalCredit.'</b></td>
									<td align="right"><b>'.$grandTotalDC.'</b></td>
								</tr>
								<tr class="table-success">
									<td align="right" colspan="4"><b>Net Activity : </b></td>
									<td align="right"><b>'.$grandTotalDC.'</b></td>
									<td align="right" colspan="2">&nbsp;</td>
								</tr>';
							}
							
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>


</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	var confirmTitle = "Apakah anda ingin menampilkan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'AccJournals', 'action' => 'general_ledger_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalGeneralLedgerReportForm', 'btn-search', confirmTitle, formAction);

	handleDateRange('filterDatePicker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
	handleDateRange('filterMonthYear', 'filterMonthYearReset', 'filterMY', 'mm-yyyy', 'y');

	var checkCOAbyName = "<?php echo $this->Url->build(['controller'=>'AccChartOfAccounts', 'action' => 'getCoa', 5], ['fullBase' => true]); ?>";
	var checkCOAbyNameGroup = "<?php echo $this->Url->build(['controller'=>'AccChartOfAccounts', 'action' => 'getCoa', 4], ['fullBase' => true]); ?>";

    
    handleFormSelect2Search('ledgerGroupCallId', 'Masukkan Nama Perkiraan (level 4)', 2, checkCOAbyNameGroup);
    handleFormSelect2Search('ledgerCallId', 'Masukkan Nama Perkiraan (level 5)', 2, checkCOAbyName);
    handleFormSelect2Search('ledgerCallStartId', 'Masukkan Nama Perkiraan', 2, checkCOAbyName, true);
    handleFormSelect2Search('ledgerCallEndId', 'Masukkan Nama Perkiraan', 2, checkCOAbyName, true);

	// datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');
	// datePickerReset('filterMonthYear', 'filterMonthYearReset', 'filterMonthYear', 'mm-yyyy', 'y');

	$(".select2Form").select2();
	$(".select2FormClear").select2({ allowClear: true });
	
});
</script>
<?php
/*foreach ($COA as $COAId => $COAData) {
list($COACode, $COAName, $COAGroupName, $COABeginningBalance, $COAGroup, $COAJournalType) = explode('^', $COAData);
$beginningBalanceDate = '';
$totalBeginningBalanceValue = '';

echo '<tr class="table-danger">
		<td class="bg-yellow-lemon">Nama Perkiraan</td>
		<td colspan="4" class="bg-yellow-lemon">: '.$COAGroupName.'</td>
		<td colspan="2" class="bg-yellow-lemon">Saldo Awal : '.$beginningBalanceDate.'</td>
		<td align="right" class="bg-yellow-lemon">'.$totalBeginningBalanceValue.'</td>
	</tr>';

$rows = array();
	$totalDebets = array();
	$totalCredits = array();
	$totalTransaksis = array();
	foreach ($data['rows'] as $view){
		$coa = $view["AccChartOfAccount"];
		$coaId = $coa['id'];
		if($coaId==$COAId) {
			$journal = $view["AccJournal"];
			$journalLine = $view['AccJournalLine'];
			
			$journalBranchId = $journal["branch_id"];
			// Mengambil data branch
			$dataBranchName = $dataSessionSetting["branch_data"][$journalBranchId];
			
			$journalId = $journal['id'];
			$journalCode = $journal['code'];
			$journalDate = (empty($journal['date'])) ? '' : $this->Time->format($format = 'd M Y', $journal['date']);
			$journalLineName = $journalLine['name'];
			$journalLineLedgerDC = $journalLine['ledger_dc'];
			$journalLineDebet = $this->Krs->__currency($journalLine['debet']);
			$journalLineCredit = $this->Krs->__currency($journalLine['credit']);
			//pr()
			$coaCode = $coa['code'];
			$coaName = $coa['name'];
			$totalDebets[] = $journalLine['debet'];
			$totalCredits[] = $journalLine['credit'];
			$totalTransaksis[] = 1;

			echo '<tr>
					<td align="center">'.$dataBranchName.'</td>
					<td align="center">'.$journalCode.'</td>
					<td align="center">'.$journalDate.'</td>
					<td>'.$journalLineName.'</td>
					<td align="center">'.$journalLineLedgerDC.'</td>
					<td align="right">'.$journalLineDebet.'</td>
					<td align="right">'.$journalLineCredit.'</td>
					<td>&nbsp;</td>
				</tr>';
		}
	}

}*/
/*
<tr class="active">
<td class="bg-yellow-gold">No Perkiraan</td>
<td colspan="7" class="bg-yellow-gold">: '.$COACode.'</td>
</tr>
*/
	
// foreach ($dataRows as $key => $value) {
// 	pr($value);
// }
// pr($COA);
/*
// Mengambil data session Setting
$dataSessionSetting = $this->Krs->sessionSetting();
//pr($data['rows']);

$COA = Set::combine($data['rows'], '{n}.AccChartOfAccount.id', array('{0}^{1}^{2} {3}^{4}^{5}^{6}', '{n}.AccChartOfAccount.code', '{n}.AccChartOfAccount.name', '{n}.CustomerCoa.title', '{n}.CustomerCoa.name', '{n}.AccChartOfAccount.beginning_balance', '{n}.AccChartOfAccount.group', '{n}.AccChartOfAccount.journal_type'));
//pr($COA);
// pr($data);
if(is_array($data['rows'])){
	// Mengambil data session Setting
	$dataSessionSetting = $this->Krs->sessionSetting();

	foreach ($COA as $COAId => $COAData) {
		list($COACode, $COAName, $COACustomerName, $COABeginningBalance, $COAGroup, $COAJournalType) = explode('^', $COAData);

		//pr($COAData);

		$beginningBalanceData = $COABeginningBalance;
		$beginningBalanceValue = $this->Krs->__currency($beginningBalanceData);
		$beginningBalanceDate = $this->Time->format($format = 'd M Y', $dateAfter);

		if($COAGroup=='laba-rugi'){
			$beginningBalanceJournalData = Set::extract('/AccJournalLine[acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournalLabaRugi);
		} else {											
			$beginningBalanceJournalData = Set::extract('/AccJournalLine[acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournal);
		}

		//pr($beginningBalanceJournalData);

		

		// pr($beginningBalanceDateYear);
		// pr($yearNow);
		//pr($beginningBalanceJournalData);

		if(!empty($beginningBalanceJournalData) && !empty($dateAfter)) {
			if($COAJournalType=="prive") {
				$beginningBalanceJournalTotal = 0;
			} else {
				$beginningBalanceJournalDatas = $beginningBalanceJournalData[0]['AccJournalLine'];
				$beginningBalanceDebet = $beginningBalanceJournalDatas['debet'];
				$beginningBalanceCredit = $beginningBalanceJournalDatas['credit'];
				$beginningBalanceJournalTotal = $beginningBalanceDebet-$beginningBalanceCredit;
			}
			//$beginningBalance = $dataBeginningBalance[$COAId];
			//pr($dataBeginningBalance);

			// pr($beginningBalanceDebet);
			// if($beginningBalanceDateYear!=$yearNow && $COAGroup=='laba-rugi') {
			// 	$beginningBalanceJournalTotal = 0;
			// } else {
				//$beginningBalanceJournalTotal = ($beginningBalanceDebet+$beginningBalance)-$beginningBalanceCredit;
			// }
		} else {
			$beginningBalanceJournalTotal = 0;
		}


		//$beginningBalanceData = $this->Krs->xBeginningBalance($data['beginningBalance'], $COAId, $beginningBalanceDates);
		// $beginningBalanceData = Set::extract('/AccBeginningBalance[acc_chart_of_account_id='.$COAId.']', $beginnigBalance);
		// pr($beginningBalanceData);

		// $beginningBalanceValue = $this->Krs->__currency($beginningBalanceData);
		// $beginningBalanceDate = $this->Time->format($format = 'd M Y', $beginningBalanceDates);
		//pr($beginningBalanceJournalTotal.' / '.$beginningBalanceData);

		
		// if($COAJournalType=="prive") {
		// 	$totalBeginningBalance = 0;
		// } else {
		//pr($beginningBalanceJournalTotal.' = '.$beginningBalanceData);

		$totalBeginningBalance = round($beginningBalanceJournalTotal, 2)+round($beginningBalanceData,2);
		// }
		//pr(round($beginningBalanceJournalTotal, 2).'+'.round($beginningBalanceData,2));

		$totalBeginningBalanceValue = $this->Krs->__currency($totalBeginningBalance);
		$COAOfName = (empty($COAName)) ? $COACustomerName : $COAName;
		
		echo '<tr class="active">
				<td class="bg-yellow-gold">No Perkiraan</td>
				<td colspan="7" class="bg-yellow-gold">: '.$COACode.'</td>
			</tr>
			<tr class="danger">
				<td class="bg-yellow-lemon">Nama Perkiraan</td>
				<td colspan="4" class="bg-yellow-lemon">: '.$COAOfName.'</td>
				<td colspan="2" class="bg-yellow-lemon">Saldo Awal : '.$beginningBalanceDate.'</td>
				<td align="right" class="bg-yellow-lemon">'.$totalBeginningBalanceValue.'</td>
			</tr>';

	$rows = array();
	$totalDebets = array();
	$totalCredits = array();
	$totalTransaksis = array();
	foreach ($data['rows'] as $view){
		$coa = $view["AccChartOfAccount"];
		$coaId = $coa['id'];
		if($coaId==$COAId) {
			$journal = $view["AccJournal"];
			$journalLine = $view['AccJournalLine'];
			
			$journalBranchId = $journal["branch_id"];
			// Mengambil data branch
			$dataBranchName = $dataSessionSetting["branch_data"][$journalBranchId];
			$journalId = $journal['id'];
			$journalCode = $journal['code'];
			$journalDate = (empty($journal['date'])) ? '' : $this->Time->format($format = 'd M Y', $journal['date']);
			$journalLineName = $journalLine['name'];
			$journalLineLedgerDC = $journalLine['ledger_dc'];
			$journalLineDebet = $this->Krs->__currency($journalLine['debet']);
			$journalLineCredit = $this->Krs->__currency($journalLine['credit']);
			//pr()
			$coaCode = $coa['code'];
			$coaName = $coa['name'];
			$totalDebets[] = $journalLine['debet'];
			$totalCredits[] = $journalLine['credit'];
			$totalTransaksis[] = 1;

			echo '<tr>
					<td align="center">'.$dataBranchName.'</td>
					<td align="center">'.$journalCode.'</td>
					<td align="center">'.$journalDate.'</td>
					<td>'.$journalLineName.'</td>
					<td align="center">'.$journalLineLedgerDC.'</td>
					<td align="right">'.$journalLineDebet.'</td>
					<td align="right">'.$journalLineCredit.'</td>
					<td>&nbsp;</td>
				</tr>';
		}
	}

	//pr($totalCredits);

	$totalTransaksi = count($totalTransaksis);
	$totalDebet = round(array_sum($totalDebets),2);
	$totalCredit = round(array_sum($totalCredits),2);
	//pr($totalCredit);

	//pr($totalBeginningBalance.'+'.$totalDebet.'-'.$totalCredit);
	$totalDCs = ($totalBeginningBalance+$totalDebet)-$totalCredit;
	$totalDC = round($totalDCs,2);
	//$totalDC = $beginningBalanceData+$beginningBalanceJournalTotal+$totalDebet-$totalCredit;

	//$totalDC = $beginningBalanceData+$totalDebet-$totalCredit;
	$grandTotalDebet = $this->Krs->__currency($totalDebet);
	$grandTotalCredit = $this->Krs->__currency($totalCredit);
	$grandTotalDC = $this->Krs->__currency($totalDC);
	echo '<tr>
			<td align="left" colspan="5" class="bg-blue-madison">Jumlah transaksi sebanyak : '.$totalTransaksi.'</td>
			<td align="right" class="bg-blue-madison"><b>'.$grandTotalDebet.'</b></td>
			<td align="right" class="bg-blue-madison"><b>'.$grandTotalCredit.'</b></td>
			<td align="right" class="bg-blue-madison"><b>'.$grandTotalDC.'</b></td>
		</tr>
		<tr>
			<td align="right" colspan="5" class="bg-blue-chambray">Net Activity : </td>
			<td align="right" class="bg-blue-chambray"><b>'.$grandTotalDC.'</b></td>
			<td align="right" colspan="2" class="bg-blue-chambray">&nbsp;</td>
		</tr>';
	}
	
}							
*/
/*if(is_array(!empty($dataBeginningBalance))){
	$accBeginingBalance = $dataBeginningBalance["AccBeginningBalance"];
	$dates = $accBeginingBalance["dates"];
}*/
// echo $this->Krs->errorModel($validationError);


/*$pages = (empty($this->params['named']['page']))?'':'/page:'.$this->params['named']['page'];

$dataParent = $this->Html->link('Beranda', array('event_id' => $uuid, 'controller' => 'users', 'action' => 'home', 'full_base' => true));
$dataChild = "Laporan";
$dataGrandChild = $data['page'];
echo $this->Krs->breadcrumb($dataParent,$dataChild,$dataGrandChild); 
?>
<div class="panel panel-inverse">
	<div class="panel-heading">
	    <div class="panel-heading-btn">
			<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
		</div>
		<h4 class="panel-title">Perincian</h4>
	</div>
	<?php
	echo $this->Form->create("AccJournal", array("url" => array('event_id' => $uuid, "controller"=>"AccJournals", "action" => "report_general_ledger"), "class" => "form-horizontal", "inputDefaults" => array("label" => false, "div" => false)));
	?>
	<div class="panel-body bg-silver">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg-8">
				<div class="panel panel-success">
					<div class="panel-heading">
			            <div class="panel-heading-btn">
			                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			            </div>
			            <h4 class="panel-title">Cari data...</h4>
			        </div>
			       <div class="panel-body">
			       	
						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Nama Perkiraan</label>
							<div class="col-md-9">
								<?php
								$dataAccounts = $this->Krs->_getCOA($data['account'], true);
												
								echo $this->Form->input('ledger', array('empty' => false, 'default' => 0, 'options' => $dataAccounts, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2Form', 'multiple' => true));
								?>
							</div>
						</div>
						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Nama Perkiraan (Periode)</label>
							<div class="col-md-9">
								<div class="input-group">
									<?php
									//pr($dataAccount);

									$dataAccounts = $this->Krs->getCOA($data['account'], true);
											
									echo $this->Form->input('ledger_start', array('empty' => true, 'default' => 0, 'options' => $dataAccounts, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2FormClear'));
									?>
									<span class="input-group-addon">-</span>
									<?php
										echo $this->Form->input('ledger_end', array('empty' => true, 'default' => 0, 'options' => $dataAccounts, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2FormClear'));

									
									?>
								</div>

								<?php
								
								?>
							</div>
						</div>

						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Bulan-Tahun</label>
							<div class="col-md-3">
								<div class="input-group">
									<div class="input-group input-small input-monthYear">
									<?php
									// date-picker
									echo $this->Form->input("filterDate", array("class" => "form-control form-control-inline input-small filterMonthYear", "autocomplete"=>"off", "error" => false, "required"=>false, 'readonly' => true));
									?>
									<span class="input-group-btn">
										<button class="btn default filterMonthYearReset" type="button"><i class="fa fa-times"></i></button>
									</span>
									</div>
								</div>
							</div>
							<label class="col-form-label col-md-1">Tanggal</label>
							<div class="col-md-5">
								<?php
								echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control form-control-inline input-small date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...'), 'filterDateEnd', array("class"=>"form-control form-control-inline input-small date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...'), 'ke', 'resetDate');
								?>
							</div>
						</div>
						<div class="form-group row m-b-15">
							
						</div>						
					</div>
					<div class="panel-footer text-right bg-orange">
					    <?php
					    //, 'id'=> 'btn-search'
					    echo $this->Form->button('Tampilkan..', array('class'=>'btn btn-primary', 'type'=>'submit', 'escape' => false));
						?>
					</div>
				</div>
			</div>
		</div>	
		<?php echo $this->Form->end();?>
		<br>
		<?php
		//pr($data['rows']);

		if($data['show']=='Y'){
			if(empty($data['rows'])) { 
			//if(empty($data['rows']) && empty($beginningBalanceJournal)) { 
		?>
		
		<div class="alert alert-danger">
			<h4 class="alert-heading">Warning!</h4>
			<p>Maaf data tidak ditemukan, silakan masukan data dengan benar!!.</p>
		</div>
		
		<?php 
			} else {
		?>
		<div class="panel-body">
			<legend class="m-b-15">
				<div class="table-toolbar">
					<div class="btn-group">
						<div class="portlet-body">
							Tanggal : 
							<?php 
							
							if(!empty($dataDate)) {
								list($dateStarts, $dateEnds) = explode('^', base64_decode($dataDate));
								$dateStart = $this->Time->format($format = 'd M Y', $dateStarts);
								$dateEnd = $this->Time->format($format = 'd M Y', $dateEnds);

								echo $dateStart.' sampai '.$dateEnd;
							} elseif(!empty($dataMonthYear)) {
								echo $dataMonthYear;
							}
							
							?>
						</div>
					</div>
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Unduh"><i class="fa fa-download"></i></button>
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="500" data-close-others="true"></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<?php
								echo $this->Html->link('PDF', array('event_id' => $uuid, 'controller' => 'AccJournals', "action"=>"pdf_general_ledger/".$dataExport, 'full_base' => true), array('escape' => false), 'Apakah anda yakin untuk mengambil data dalam bentuk PDF?');
								?>
							</li>
							
						</ul>
					</div>
				</div>
			</legend>
			<br>

			<div class="portlet-body">
				<div class="table-responsive">
					<div data-scrollbar="true" data-height="400px">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<tr>
										<th width="160">No. Ref</th>
										<th width="120">No. Ref</th>
										<th width="100">Tanggal</th>
										<th>Uraian</th>
										<th width="50">D/K</th>
										<th width="140">Debit</th>
										<th width="140">Kredit</th>
										<th width="150">Keterangan</th>
									</tr>
								</tr>
							</thead>
							<tbody>
							<?php
							// pr($data);
							// Mengambil data session Setting
							$dataSessionSetting = $this->Krs->sessionSetting();
							//pr($data['rows']);

							$COA = Set::combine($data['rows'], '{n}.AccChartOfAccount.id', array('{0}^{1}^{2} {3}^{4}^{5}^{6}', '{n}.AccChartOfAccount.code', '{n}.AccChartOfAccount.name', '{n}.CustomerCoa.title', '{n}.CustomerCoa.name', '{n}.AccChartOfAccount.beginning_balance', '{n}.AccChartOfAccount.group', '{n}.AccChartOfAccount.journal_type'));
								//pr($COA);
								// pr($data);
								if(is_array($data['rows'])){
									// Mengambil data session Setting
									$dataSessionSetting = $this->Krs->sessionSetting();

									foreach ($COA as $COAId => $COAData) {
										list($COACode, $COAName, $COACustomerName, $COABeginningBalance, $COAGroup, $COAJournalType) = explode('^', $COAData);

										//pr($COAData);

										$beginningBalanceData = $COABeginningBalance;
										$beginningBalanceValue = $this->Krs->__currency($beginningBalanceData);
										$beginningBalanceDate = $this->Time->format($format = 'd M Y', $dateAfter);

										if($COAGroup=='laba-rugi'){
											$beginningBalanceJournalData = Set::extract('/AccJournalLine[acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournalLabaRugi);
										} else {											
											$beginningBalanceJournalData = Set::extract('/AccJournalLine[acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournal);
										}

										//pr($beginningBalanceJournalData);

										

										// pr($beginningBalanceDateYear);
										// pr($yearNow);
										//pr($beginningBalanceJournalData);

										if(!empty($beginningBalanceJournalData) && !empty($dateAfter)) {
											if($COAJournalType=="prive") {
												$beginningBalanceJournalTotal = 0;
											} else {
												$beginningBalanceJournalDatas = $beginningBalanceJournalData[0]['AccJournalLine'];
												$beginningBalanceDebet = $beginningBalanceJournalDatas['debet'];
												$beginningBalanceCredit = $beginningBalanceJournalDatas['credit'];
												$beginningBalanceJournalTotal = $beginningBalanceDebet-$beginningBalanceCredit;
											}
											//$beginningBalance = $dataBeginningBalance[$COAId];
											//pr($dataBeginningBalance);

											// pr($beginningBalanceDebet);
											// if($beginningBalanceDateYear!=$yearNow && $COAGroup=='laba-rugi') {
											// 	$beginningBalanceJournalTotal = 0;
											// } else {
												//$beginningBalanceJournalTotal = ($beginningBalanceDebet+$beginningBalance)-$beginningBalanceCredit;
											// }
										} else {
											$beginningBalanceJournalTotal = 0;
										}


										//$beginningBalanceData = $this->Krs->xBeginningBalance($data['beginningBalance'], $COAId, $beginningBalanceDates);
										// $beginningBalanceData = Set::extract('/AccBeginningBalance[acc_chart_of_account_id='.$COAId.']', $beginnigBalance);
										// pr($beginningBalanceData);

										// $beginningBalanceValue = $this->Krs->__currency($beginningBalanceData);
										// $beginningBalanceDate = $this->Time->format($format = 'd M Y', $beginningBalanceDates);
										//pr($beginningBalanceJournalTotal.' / '.$beginningBalanceData);

										
										// if($COAJournalType=="prive") {
										// 	$totalBeginningBalance = 0;
										// } else {
										//pr($beginningBalanceJournalTotal.' = '.$beginningBalanceData);

										$totalBeginningBalance = round($beginningBalanceJournalTotal, 2)+round($beginningBalanceData,2);
										// }
										//pr(round($beginningBalanceJournalTotal, 2).'+'.round($beginningBalanceData,2));

										$totalBeginningBalanceValue = $this->Krs->__currency($totalBeginningBalance);
										$COAOfName = (empty($COAName)) ? $COACustomerName : $COAName;
										
										echo '<tr class="active">
												<td class="bg-yellow-gold">No Perkiraan</td>
												<td colspan="7" class="bg-yellow-gold">: '.$COACode.'</td>
											</tr>
											<tr class="danger">
												<td class="bg-yellow-lemon">Nama Perkiraan</td>
												<td colspan="4" class="bg-yellow-lemon">: '.$COAOfName.'</td>
												<td colspan="2" class="bg-yellow-lemon">Saldo Awal : '.$beginningBalanceDate.'</td>
												<td align="right" class="bg-yellow-lemon">'.$totalBeginningBalanceValue.'</td>
											</tr>';

									$rows = array();
									$totalDebets = array();
									$totalCredits = array();
									$totalTransaksis = array();
									foreach ($data['rows'] as $view){
										$coa = $view["AccChartOfAccount"];
										$coaId = $coa['id'];
										if($coaId==$COAId) {
											$journal = $view["AccJournal"];
											$journalLine = $view['AccJournalLine'];
											
											$journalBranchId = $journal["branch_id"];
											// Mengambil data branch
											$dataBranchName = $dataSessionSetting["branch_data"][$journalBranchId];

											
											//'AccJournal.id', 'AccJournal.journal_sub_id', 'AccJournal.code', 'AccJournal.journal_type', 'AccJournal.name', 'AccJournal.date', 'AccJournal.date_journal', 'AccJournal.grand_total', 'AccJournal.balance', 'AccJournalLine.id', 'AccJournalLine.acc_chart_of_account_id', 'AccJournalLine.ledger_dc', 'AccJournalLine.name', 'AccJournalLine.debet', 'AccJournalLine.credit', 'AccChartOfAccount.id', 'AccChartOfAccount.code', 'AccChartOfAccount.name', 'AccChartOfAccount.type'
											
											// $permitDates = (empty($permit['date'])) ? '': $this->Time->format($format = 'd', $permit['date']);
											$journalId = $journal['id'];
											$journalCode = $journal['code'];
											$journalDate = (empty($journal['date'])) ? '' : $this->Time->format($format = 'd M Y', $journal['date']);
											$journalLineName = $journalLine['name'];
											$journalLineLedgerDC = $journalLine['ledger_dc'];
											$journalLineDebet = $this->Krs->__currency($journalLine['debet']);
											$journalLineCredit = $this->Krs->__currency($journalLine['credit']);
											//pr()
											$coaCode = $coa['code'];
											$coaName = $coa['name'];
											$totalDebets[] = $journalLine['debet'];
											$totalCredits[] = $journalLine['credit'];
											$totalTransaksis[] = 1;

											echo '<tr>
													<td align="center">'.$dataBranchName.'</td>
													<td align="center">'.$journalCode.'</td>
													<td align="center">'.$journalDate.'</td>
													<td>'.$journalLineName.'</td>
													<td align="center">'.$journalLineLedgerDC.'</td>
													<td align="right">'.$journalLineDebet.'</td>
													<td align="right">'.$journalLineCredit.'</td>
													<td>&nbsp;</td>
												</tr>';
										}
									}

									//pr($totalCredits);

									$totalTransaksi = count($totalTransaksis);
									$totalDebet = round(array_sum($totalDebets),2);
									$totalCredit = round(array_sum($totalCredits),2);
									//pr($totalCredit);

									//pr($totalBeginningBalance.'+'.$totalDebet.'-'.$totalCredit);
									$totalDCs = ($totalBeginningBalance+$totalDebet)-$totalCredit;
									$totalDC = round($totalDCs,2);
									//$totalDC = $beginningBalanceData+$beginningBalanceJournalTotal+$totalDebet-$totalCredit;

									//$totalDC = $beginningBalanceData+$totalDebet-$totalCredit;
									$grandTotalDebet = $this->Krs->__currency($totalDebet);
									$grandTotalCredit = $this->Krs->__currency($totalCredit);
									$grandTotalDC = $this->Krs->__currency($totalDC);
									echo '<tr>
											<td align="left" colspan="5" class="bg-blue-madison">Jumlah transaksi sebanyak : '.$totalTransaksi.'</td>
											<td align="right" class="bg-blue-madison"><b>'.$grandTotalDebet.'</b></td>
											<td align="right" class="bg-blue-madison"><b>'.$grandTotalCredit.'</b></td>
											<td align="right" class="bg-blue-madison"><b>'.$grandTotalDC.'</b></td>
										</tr>
										<tr>
											<td align="right" colspan="5" class="bg-blue-chambray">Net Activity : </td>
											<td align="right" class="bg-blue-chambray"><b>'.$grandTotalDC.'</b></td>
											<td align="right" colspan="2" class="bg-blue-chambray">&nbsp;</td>
										</tr>';
									}
									
								}



							// <th width="150">Keterangan</th>
							// $result = Set::combine($beginningBalanceJournal, array('debet', '{n}.AccJournalLine.debet'), array('credit', '{n}.AccJournalLine.credit'), '{n}.AccJournalLine.acc_chart_of_account_id');

							
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php 
			}
		} 
		?>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() { 
	datePickerReset('input-daterange', 'resetDate', 'filterDate', 'dd-mm-yyyy');
	datePickerReset('filterMonthYear', 'filterMonthYearReset', 'filterMonthYear', 'mm-yyyy', 'y');

	$(".select2Form").select2();
	$(".select2FormClear").select2({ allowClear: true });
	
});
</script>
*/
?>