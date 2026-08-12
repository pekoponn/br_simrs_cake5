<?php
use Cake\Utility\Hash;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal[]|\Cake\Collection\CollectionInterface $accJournals
 */
?>
<?= $this->Krs->breadcrumb('Accounting', 'Buku Besar', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
</div>

<?php
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
	echo $this->Form->create("AccJournal", array("url" => array('event_id' => $uuid, "controller"=>"acc_journals", "action" => "report_general_ledger"), "class" => "form-horizontal", "inputDefaults" => array("label" => false, "div" => false)));
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
								echo $this->Html->link('PDF', array('event_id' => $uuid, 'controller' => 'acc_journals', "action"=>"pdf_general_ledger/".$dataExport, 'full_base' => true), array('escape' => false), 'Apakah anda yakin untuk mengambil data dalam bentuk PDF?');
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