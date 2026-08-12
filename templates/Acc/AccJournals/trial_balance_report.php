<?php
use Cake\Utility\Hash;
?>
<style>
.tableFixHead          { overflow: auto; height: 500px;}
.tableFixHead thead th { position: -webkit-sticky; position: sticky; top: 0; z-index: 1; }
.tableFixHead tbody th { position: -webkit-sticky; position: sticky; left: 0; display: block;}
.tableFixHead tfoot td { position: -webkit-sticky; position: sticky; bottom: 0; z-index: 1; }
}
</style>
<?= $this->Krs->breadcrumb('Accounting', 'Neraca (Saldo)', 'Tampilkan') ?>
<div class="panel panel-inverse">
	<div class="panel-body bg-gray-100">
    	<?= $this->Form->create($accJournal) ?>
	    <div class="row">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
				<div class="panel panel-success">
					<div class="panel-heading">
			            <h4 class="panel-title">Cari data..</h4>
				        <div class="panel-heading-btn">
				            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				        </div>
			        </div>
			    	<div class="panel-body p-t-10">
			       		<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Tanggal</label>
							<div class="col-md-8">
							<?php
							echo $this->Form->input("filterDate", array("class" => "form-control filterDateClass", 'id'=>'datepicker-autoClose', "autocomplete"=>"off", "error" => false, 'placeholder' => 'Tanggal...', "required"=>false, 'readonly' => true));
							?>
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
		if($data['show']=='Y') {
			// pr($dataRows);
		?>
		<div class="panel-body">
			<legend class="m-b-15">
				<div class="table-toolbar">
					<div class="btn-group pull-right">
						<div class="btn-group dropdown">
	                        <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
	                        <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
	                        <div class="dropdown-menu dropdown-menu-right">
	                        <?= $this->Html->link('Pdf', ['action' => 'pdf'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
	                        <?= $this->Html->link('Excel', ['action' => 'xls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
	                        </div>
	                    </div>
					</div>
				</div>
			</legend>
			<br>
			<br>
			<div class="portlet-body">
				<div class="table-responsive">
					<?php
					/*
					<div role="region" aria-labelledby="HeadersCol" tabindex="0" class="rowheaders">
					</div>
					 data-scrollbar="true"
					*/
					?>
					<div data-height="500px" class="tableFixHead">
						<table class="table table-striped table-hover">
							<thead class="thead-dark text-center">
									<tr>
										<th width="100" align="center" rowspan="2"><b>Kode Akun</b></th>
										<th rowspan="2"><b>Nama Akun</b></th>
										<th width="150" align="center"><b>NS</b></th>
										<th width="150" align="center"><b>Saldo Awal</b></th>
										<th align="center"><b>Debit</b></th>
										<th align="center"><b>Kredit</b></th>
										<th width="150" align="center"><b>Saldo Akhir</b></th>
									</tr>
							</thead>
							<tbody>
							<?php
							// pr($dataCOAs);
							$neracaSaldoDebets = array();
							$neracaSaldoCredits = array();
							$journalAdjustmentDebets = array();
							$journalAdjustmentCredits = array();
							$neracaLajurLabaRugiDebets = array();
							$neracaLajurLabaRugiCredits = array();
							$neracaLajurNeracaDebets = array();
							$neracaLajurNeracaCredits = array();
							$necaraSaldoDisesuaikanDebets = array();
							$necaraSaldoDisesuaikanCredits = array();
							$neracaSaldoLastSaldos = array();
							foreach ($dataCOAs as $dataCoa) {
								$coaId = $dataCoa->id;
								$coaCode = $dataCoa->code;
								$coaName = $dataCoa->name;
								$coaGroup = $dataCoa->groups;
								$coaNormalBalance = $dataCoa->normal_balance;

								// $coaNormalBalance = $dataCoa->normal_balance;
								$coaBeginningBalanceDebet = $dataCoa->beginning_balance_debet;
								$coaBeginningBalanceCredit = $dataCoa->beginning_balance_credit;
								
								$coaBeginningSaldo = $dataCoa->beginning_balance_debet-$dataCoa->beginning_balance_credit;
								//230728 ------
								// if($coaNormalBalance=='D') {
								// 	$coaBeginningSaldo = $dataCoa->beginning_balance_debet;
								// } else {
								// 	$coaBeginningSaldo = $dataCoa->beginning_balance_credit;
								// }
								//230728 ------

								$accJournalData = Hash::extract($data['rows'], '{n}[coaId='.$coaId.']');

								$accJournalDataAdjustment = Hash::extract($data['rowsAdjustment'], '{n}[coaId='.$coaId.']');
								// $data['rowsAdjustment']

								// pr($accJournalData);
								if(!empty($accJournalData)) {
									$accJournalRow = $accJournalData[0];
									$accJournalRowId = $accJournalRow->coaId;
									$accJournalRowTotalDebet = $accJournalRow->totalDebet;
									$accJournalRowTotalCredit = $accJournalRow->totalCredit;
								} else {
									$accJournalRowId = '';
									$accJournalRowTotalDebet = 0;
									$accJournalRowTotalCredit = 0;
								}

								if(!empty($accJournalDataAdjustment)) {
									$accJournalRowAdjustment = $accJournalDataAdjustment[0];
									$accJournalRowAdjustmentId = $accJournalRowAdjustment->coaId;
									$accJournalRowAdjustmentTotalDebet = $accJournalRowAdjustment->totalDebet;
									$accJournalRowAdjustmentTotalCredit = $accJournalRowAdjustment->totalCredit;
								} else {
									$accJournalRowAdjustmentId = '';
									$accJournalRowAdjustmentTotalDebet = 0;
									$accJournalRowAdjustmentTotalCredit = 0;
								}

								//Menampilkan data nominal Neraca Saldo
								$neracaSaldoDebet = $accJournalRowTotalDebet;
								$neracaSaldoCredit = $accJournalRowTotalCredit;
								// $neracaSaldoDebet = $coaBeginningBalanceDebet+$accJournalRowTotalDebet;
								// $neracaSaldoCredit = $coaBeginningBalanceCredit+$accJournalRowTotalCredit;
								$neracaSaldoDebetNominal = $this->Krs->cur($neracaSaldoDebet);
								$neracaSaldoCreditNominal = $this->Krs->cur($neracaSaldoCredit);
								$neracaSaldoDebets[] = $neracaSaldoDebet;
								$neracaSaldoCredits[] = $neracaSaldoCredit;

								//Menampilkan data nominal Jurnal Penyesuaian
								$journalAdjustmentDebetNominal = $this->Krs->cur($accJournalRowAdjustmentTotalDebet);
								$journalAdjustmentCreditNominal = $this->Krs->cur($accJournalRowAdjustmentTotalCredit);
								$journalAdjustmentDebets[] = $accJournalRowAdjustmentTotalDebet;
								$journalAdjustmentCredits[] = $accJournalRowAdjustmentTotalCredit;

								$necaraSaldoDisesuaikanDebet = ($coaNormalBalance=='D') ? ($neracaSaldoDebet-$neracaSaldoCredit)+($accJournalRowAdjustmentTotalDebet-$accJournalRowAdjustmentTotalCredit) : 0;
								$necaraSaldoDisesuaikanCredit = ($coaNormalBalance=='C') ? ($neracaSaldoCredit-$neracaSaldoDebet)+($accJournalRowAdjustmentTotalCredit-$accJournalRowAdjustmentTotalDebet) : 0;

								$neracaLajurLabaRugiDebet = ($coaGroup=='laba-rugi' && $coaNormalBalance=='D') ? $necaraSaldoDisesuaikanDebet:0;
								$neracaLajurLabaRugiCredit = ($coaGroup=='laba-rugi' && $coaNormalBalance=='C') ? $necaraSaldoDisesuaikanCredit:0;

								$neracaLajurNeracaDebet = ($coaGroup=='neraca' && $coaNormalBalance=='D') ? $necaraSaldoDisesuaikanDebet:0;
								$neracaLajurNeracaCredit = ($coaGroup=='neraca' && $coaNormalBalance=='C') ? $necaraSaldoDisesuaikanCredit:0;

								$neracaLajurLabaRugiDebetNominal = $this->Krs->cur($neracaLajurLabaRugiDebet);
								$neracaLajurLabaRugiCreditNominal = $this->Krs->cur($neracaLajurLabaRugiCredit);
								$neracaLajurLabaRugiDebets[] = $neracaLajurLabaRugiDebet;
								$neracaLajurLabaRugiCredits[] = $neracaLajurLabaRugiCredit;

								$neracaLajurNeracaDebetNominal = $this->Krs->cur($neracaLajurNeracaDebet);
								$neracaLajurNeracaCreditNominal = $this->Krs->cur($neracaLajurNeracaCredit);
								$neracaLajurNeracaDebets[] = $neracaLajurNeracaDebet;
								$neracaLajurNeracaCredits[] = $neracaLajurNeracaCredit;

								$necaraSaldoDisesuaikanDebetNominal = $this->Krs->cur($necaraSaldoDisesuaikanDebet);
								$necaraSaldoDisesuaikanCreditNominal = $this->Krs->cur($necaraSaldoDisesuaikanCredit);

								$neracaSaldoLastSaldo = ($coaBeginningSaldo+$necaraSaldoDisesuaikanDebet)-$necaraSaldoDisesuaikanCredit;
								$neracaSaldoLastSaldos[] = $neracaSaldoLastSaldo;

								$necaraSaldoDisesuaikanDebets[] = $necaraSaldoDisesuaikanDebet;
								$necaraSaldoDisesuaikanCredits[] = $necaraSaldoDisesuaikanCredit;

								if($necaraSaldoDisesuaikanDebet==0 && $necaraSaldoDisesuaikanCredit==0) {

								} else {

								echo '<tr>
										<td align="center">'.$coaCode.'</td>
										<td>'.$coaName.'</td>
										<td align="center">'.$coaNormalBalance.'</td>
										<td align="right">'.$this->Krs->cur($coaBeginningSaldo).'</td>
										<td align="right">'.$necaraSaldoDisesuaikanDebetNominal.'</td>
										<td align="right">'.$necaraSaldoDisesuaikanCreditNominal.'</td>
										<td align="right">'.$this->Krs->cur($neracaSaldoLastSaldo).'</td>
									</tr>';
								}

								/*echo '<tr>
									<td align="center">'.$coaCode.'</td>
									<td>'.$coaName.'</td>
									<td align="right" class="table-info">'.$neracaSaldoDebetNominal.'</td>
									<td align="right" class="table-info">'.$neracaSaldoCreditNominal.'</td>
									<td align="right" class="table-success">'.$journalAdjustmentDebetNominal.'</td>
									<td align="right" class="table-success">'.$journalAdjustmentCreditNominal.'</td>
									<td align="right" class="table-dark">'.$necaraSaldoDisesuaikanDebetNominal.'</td>
									<td align="right" class="table-dark">'.$necaraSaldoDisesuaikanCreditNominal.'</td>
									<td align="right" class="table-warning">'.$neracaLajurLabaRugiDebetNominal.'</td>
									<td align="right" class="table-warning">'.$neracaLajurLabaRugiCreditNominal.'</td>
									<td align="right" class="table-lime">'.$neracaLajurNeracaDebetNominal.'</td>
									<td align="right" class="table-lime">'.$neracaLajurNeracaCreditNominal.'</td>
								</tr>';*/

								// $accJournalDataId = (!empty($accJournalData)) ? $accJournalData[0] : '';
								// pr($accJournalDataId);
								//$pettyCashLineData = Hash::combine($pettyCashLine, '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);

								// $accJournalData = Hash::combine($data['rows'], '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);
								
								// $ AccJournal
								
							}

							// $dataCOAPendapatan = Hash::extract($dataCOA, '{n}[journal_type=pendapatan][level=5]', '{n}.id');
							// pr($accJournalData);
							/*$neracaSaldoDebets = array();
							$neracaSaldoCredits = array();
							$journalAdjustmentDebets = array();
							$journalAdjustmentCredits = array();
							$neracaLajurLabaRugiDebets = array();
							$neracaLajurLabaRugiCredits = array();
							$neracaLajurNeracaDebets = array();
							$neracaLajurNeracaCredits = array();
							$necaraSaldoDisesuaikanDebets = array();
							$necaraSaldoDisesuaikanCredits = array();
							foreach ($dataCOAs as $dataCoa) {
								$coaId = $dataCoa->id;
								$coaCode = $dataCoa->code;
								$coaName = $dataCoa->name;
								$coaGroup = $dataCoa->groups;
								$coaNormalBalance = $dataCoa->normal_balance;
								// $coaBeginningBalanceDebet = $dataCoa->beginning_balance_debet;
								// $coaBeginningBalanceCredit = $dataCoa->beginning_balance_credit;
								
								$accJournalData = Hash::extract($data['rows'], '{n}[coaId='.$coaId.']');

								$accJournalDataAdjustment = Hash::extract($data['rowsAdjustment'], '{n}[coaId='.$coaId.']');
								// $data['rowsAdjustment']

								// pr($accJournalData);
								if(!empty($accJournalData)) {
									$accJournalRow = $accJournalData[0];
									$accJournalRowId = $accJournalRow->coaId;
									$accJournalRowTotalDebet = $accJournalRow->totalDebet;
									$accJournalRowTotalCredit = $accJournalRow->totalCredit;
								} else {
									$accJournalRowId = '';
									$accJournalRowTotalDebet = 0;
									$accJournalRowTotalCredit = 0;
								}

								if(!empty($accJournalDataAdjustment)) {
									$accJournalRowAdjustment = $accJournalDataAdjustment[0];
									$accJournalRowAdjustmentId = $accJournalRowAdjustment->coaId;
									$accJournalRowAdjustmentTotalDebet = $accJournalRowAdjustment->totalDebet;
									$accJournalRowAdjustmentTotalCredit = $accJournalRowAdjustment->totalCredit;
								} else {
									$accJournalRowAdjustmentId = '';
									$accJournalRowAdjustmentTotalDebet = 0;
									$accJournalRowAdjustmentTotalCredit = 0;
								}

								//Menampilkan data nominal Neraca Saldo
								$neracaSaldoDebet = $accJournalRowTotalDebet;
								$neracaSaldoCredit = $accJournalRowTotalCredit;
								// $neracaSaldoDebet = $coaBeginningBalanceDebet+$accJournalRowTotalDebet;
								// $neracaSaldoCredit = $coaBeginningBalanceCredit+$accJournalRowTotalCredit;
								$neracaSaldoDebetNominal = $this->Krs->cur($neracaSaldoDebet);
								$neracaSaldoCreditNominal = $this->Krs->cur($neracaSaldoCredit);
								$neracaSaldoDebets[] = $neracaSaldoDebet;
								$neracaSaldoCredits[] = $neracaSaldoCredit;

								//Menampilkan data nominal Jurnal Penyesuaian
								$journalAdjustmentDebetNominal = $this->Krs->cur($accJournalRowAdjustmentTotalDebet);
								$journalAdjustmentCreditNominal = $this->Krs->cur($accJournalRowAdjustmentTotalCredit);
								$journalAdjustmentDebets[] = $accJournalRowAdjustmentTotalDebet;
								$journalAdjustmentCredits[] = $accJournalRowAdjustmentTotalCredit;

								$necaraSaldoDisesuaikanDebet = ($coaNormalBalance=='D') ? ($neracaSaldoDebet-$neracaSaldoCredit)+($accJournalRowAdjustmentTotalDebet-$accJournalRowAdjustmentTotalCredit) : 0;
								$necaraSaldoDisesuaikanCredit = ($coaNormalBalance=='C') ? ($neracaSaldoCredit-$neracaSaldoDebet)+($accJournalRowAdjustmentTotalCredit-$accJournalRowAdjustmentTotalDebet) : 0;

								$neracaLajurLabaRugiDebet = ($coaGroup=='laba-rugi' && $coaNormalBalance=='D') ? $necaraSaldoDisesuaikanDebet:0;
								$neracaLajurLabaRugiCredit = ($coaGroup=='laba-rugi' && $coaNormalBalance=='C') ? $necaraSaldoDisesuaikanCredit:0;

								$neracaLajurNeracaDebet = ($coaGroup=='neraca' && $coaNormalBalance=='D') ? $necaraSaldoDisesuaikanDebet:0;
								$neracaLajurNeracaCredit = ($coaGroup=='neraca' && $coaNormalBalance=='C') ? $necaraSaldoDisesuaikanCredit:0;

								$neracaLajurLabaRugiDebetNominal = $this->Krs->cur($neracaLajurLabaRugiDebet);
								$neracaLajurLabaRugiCreditNominal = $this->Krs->cur($neracaLajurLabaRugiCredit);
								$neracaLajurLabaRugiDebets[] = $neracaLajurLabaRugiDebet;
								$neracaLajurLabaRugiCredits[] = $neracaLajurLabaRugiCredit;

								$neracaLajurNeracaDebetNominal = $this->Krs->cur($neracaLajurNeracaDebet);
								$neracaLajurNeracaCreditNominal = $this->Krs->cur($neracaLajurNeracaCredit);
								$neracaLajurNeracaDebets[] = $neracaLajurNeracaDebet;
								$neracaLajurNeracaCredits[] = $neracaLajurNeracaCredit;

								$necaraSaldoDisesuaikanDebetNominal = $this->Krs->cur($necaraSaldoDisesuaikanDebet);
								$necaraSaldoDisesuaikanCreditNominal = $this->Krs->cur($necaraSaldoDisesuaikanCredit);
								$necaraSaldoDisesuaikanDebets[] = $necaraSaldoDisesuaikanDebet;
								$necaraSaldoDisesuaikanCredits[] = $necaraSaldoDisesuaikanCredit;
								if($necaraSaldoDisesuaikanDebet==0 && $necaraSaldoDisesuaikanCredit==0) {

								} else {
									echo '<tr>
										<td align="center">'.$coaCode.'</td>
										<td>'.$coaName.'</td>
										
										<td align="right">'.$necaraSaldoDisesuaikanDebetNominal.'</td>
										<td align="right">'.$necaraSaldoDisesuaikanCreditNominal.'</td>
										
									</tr>';
								}
								// <td align="right">'.$neracaSaldoDebetNominal.'</td>
								// 	<td align="right">'.$neracaSaldoCreditNominal.'</td>
								// 	<td align="right">'.$journalAdjustmentDebetNominal.'</td>
								// 	<td align="right">'.$journalAdjustmentCreditNominal.'</td>
								// <td align="right">'.$neracaLajurLabaRugiDebetNominal.'</td>
								// 	<td align="right">'.$neracaLajurLabaRugiCreditNominal.'</td>
								// 	<td align="right">'.$neracaLajurNeracaDebetNominal.'</td>
								// 	<td align="right">'.$neracaLajurNeracaCreditNominal.'</td>
								// $accJournalDataId = (!empty($accJournalData)) ? $accJournalData[0] : '';
								// pr($accJournalDataId);
								//$pettyCashLineData = Hash::combine($pettyCashLine, '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);

								// $accJournalData = Hash::combine($data['rows'], '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);
								
								// $ AccJournal
								
							}*/
							
							?>
							</tbody>
							<tfoot>
								<?php
								$neracaSaldoLastSaldoTotal = round(array_sum($neracaSaldoLastSaldos),2);

								$neracaSaldoDebetTotal = round(array_sum($neracaSaldoDebets),2);
								$neracaSaldoCreditTotal = round(array_sum($neracaSaldoCredits),2);
								$neracaSaldoDebetTotalNominal = $this->Krs->nom($neracaSaldoDebetTotal);
								$neracaSaldoCreditTotalNominal = $this->Krs->nom($neracaSaldoCreditTotal);

								$journalAdjustmentDebetTotal = round(array_sum($journalAdjustmentDebets),2);
								$journalAdjustmentCreditTotal = round(array_sum($journalAdjustmentCredits),2);
								$journalAdjustmentDebetTotalNominal = $this->Krs->nom($journalAdjustmentDebetTotal);
								$journalAdjustmentCreditTotalNominal = $this->Krs->nom($journalAdjustmentCreditTotal);

								$necaraSaldoDisesuaikanDebetTotal = round(array_sum($necaraSaldoDisesuaikanDebets),2);
								$necaraSaldoDisesuaikanCreditTotal = round(array_sum($necaraSaldoDisesuaikanCredits),2);
								$necaraSaldoDisesuaikanDebetTotalNominal = $this->Krs->nom($necaraSaldoDisesuaikanDebetTotal);
								$necaraSaldoDisesuaikanCreditTotalNominal = $this->Krs->nom($necaraSaldoDisesuaikanCreditTotal);

								$neracaLajurLabaRugiDebetTotal = round(array_sum($neracaLajurLabaRugiDebets),2);
								$neracaLajurLabaRugiCreditTotal = round(array_sum($neracaLajurLabaRugiCredits),2);
								$neracaLajurLabaRugiDebetTotalNominal = $this->Krs->nom($neracaLajurLabaRugiDebetTotal);
								$neracaLajurLabaRugiCreditTotalNominal = $this->Krs->nom($neracaLajurLabaRugiCreditTotal);

								$neracaLajurNeracaDebetTotal = round(array_sum($neracaLajurNeracaDebets),2);
								$neracaLajurNeracaCreditTotal = round(array_sum($neracaLajurNeracaCredits),2);
								$neracaLajurNeracaDebetTotalNominal = $this->Krs->nom($neracaLajurNeracaDebetTotal);
								$neracaLajurNeracaCreditTotalNominal = $this->Krs->nom($neracaLajurNeracaCreditTotal);

								

								echo '<tr class="table-success text-right">
										<td>&nbsp;</td>
										<td align="right" colspan="3"><b>TOTAL</b></td>
										<td align="right"><b>'.$necaraSaldoDisesuaikanDebetTotalNominal.'</b></td>
										<td align="right"><b>'.$necaraSaldoDisesuaikanCreditTotalNominal.'</b></td>
										<td align="right"><b>'.
										$this->Krs->nom($neracaSaldoLastSaldoTotal).'</b></td>
									</tr>';
									/*<td align="right" width="150"><b>'.$neracaSaldoDebetTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$neracaSaldoCreditTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$journalAdjustmentDebetTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$journalAdjustmentCreditTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$neracaLajurLabaRugiDebetTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$neracaLajurLabaRugiCreditTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$neracaLajurNeracaDebetTotalNominal.'</b></td>
									<td align="right" width="150"><b>'.$neracaLajurNeracaCreditTotalNominal.'</b></td>*/
									?>
							</tfoot>
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
    var formAction = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'trial_balance_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('TrialBalanceReportForm', 'btn-search', confirmTitle, formAction);

     $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

	//handleDateRange('filterDateId', 'filterDateReset', 'filterDateClass', 'dd-mm-yyyy');
	//handleDateRange('filterDatePicker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
});
</script>