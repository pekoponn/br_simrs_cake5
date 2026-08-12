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
<?= $this->Krs->breadcrumb('Accounting', 'Neraca (Lajur)', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-body bg-gray-100">
    	<?= $this->Form->create($accJournal) ?>
	    <div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
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
							<div class="col-md-9">
								<?php
								echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Awal...'), 'filterDateEnd', array("class"=>"form-control filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Akhir...'), 's/d', 'resetDate');
								?>
								<?php
								/*
								<div class="input-group">
									<div class="input-group input-daterange">
										<?php
										echo $this->Form->input("filterDate", array("class" => "form-control filterDateClass", 'id'=>'filterDateId', "autocomplete"=>"off", "error" => false, 'placeholder' => 'Tanggal...', "required"=>false, 'readonly' => true));
										?>
										<span class="input-group-append">
											<button class="btn btn-inverse filterDateReset" type="button"><i class="fa fa-times"></i></button>
										</span>

									</div>
								</div>
								*/
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
										<th width="100" align="center"><b>Kode Akun</b></th>
										<th width="300"><b>Nama Akun</b></th>
										<th width="150" align="center" colspan="2"><b>(D) Neraca Saldo (K)</b></th>
										<th width="150" align="center" colspan="2"><b>(D) Jurnal Penyesuaian (K)</b></th>
										<th width="150" align="center" colspan="2"><b>(D) Neraca Saldo setelah disesuaikan (K)</b></th>
										<th width="150" align="center" colspan="2"><b>(D) Laba Rugi (K)</b></th>
										<th width="150" align="center" colspan="2"><b>(D) Neraca (K)</b></th>
									</tr>
								<?php
								/*
									<tr>
										<th width="100" align="center" rowspan="2"><b>Kode Akun</b></th>
										<th rowspan="2"><b>Nama Akun</b></th>
										<th align="center"><b>Debit</b></th>
										<th align="center"><b>Kredit</b></th>
										<th width="150" align="center" colspan="2"><b>Jurnal Penyesuaian</b></th>
										<th width="150" align="center" colspan="2"><b>Neraca Saldo setelah disesuaikan</b></th>
										<th width="150" align="center" colspan="2"><b>Laba Rugi</b></th>
										<th width="150" align="center" colspan="2"><b>Neraca</b></th>
									</tr>
									<tr>										
										<th width="150" align="center" colspan="2"><b>Neraca Saldo</b></th>
										<th align="center"><b>Debit</b></th>
										<th align="center"><b>Kredit</b></th>
										<th align="center"><b>Debit</b></th>
										<th align="center"><b>Kredit</b></th>
										<th align="center"><b>Debit</b></th>
										<th align="center"><b>Kredit</b></th>
										<th align="center"><b>Debit</b></th>
										<th align="center"><b>Kredit</b></th>
									</tr>
									*/
									?>
							</thead>
							<tbody>
							<?php
							
							// $dataCOAPendapatan = Hash::extract($dataCOA, '{n}[journal_type=pendapatan][level=5]', '{n}.id');
							// pr($accJournalData);
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
							foreach ($dataCOAs as $dataCoa) {
								$coaId = $dataCoa->id;
								$coaCode = $dataCoa->code;
								$coaName = $dataCoa->name;
								$coaGroup = $dataCoa->groups;
								$coaNormalBalance = $dataCoa->normal_balance;
								$coaBeginningBalanceDebet = $dataCoa->beginning_balance_debet;
								$coaBeginningBalanceCredit = $dataCoa->beginning_balance_credit;
								
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
								$neracaSaldoDebet = $coaBeginningBalanceDebet+$accJournalRowTotalDebet;
								$neracaSaldoCredit = $coaBeginningBalanceCredit+$accJournalRowTotalCredit;
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
								echo '<tr>
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
								</tr>';

								// $accJournalDataId = (!empty($accJournalData)) ? $accJournalData[0] : '';
								// pr($accJournalDataId);
								//$pettyCashLineData = Hash::combine($pettyCashLine, '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);

								// $accJournalData = Hash::combine($data['rows'], '{n}.petty_cash_no', ['%s^%s^%s^%s^%s^%s^%s', '{n}.id', '{n}.petty_cash_id', '{n}.petty_cash_no', '{n}.detail_of_request', '{n}.quantity', '{n}.price', '{n}.amount']);
								
								// $ ArtamaAccJournal
								
							}
							
							?>
							</tbody>
							<tfoot>
								<?php
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

								if($neracaLajurLabaRugiDebetTotal>$neracaLajurLabaRugiCreditTotal){
									$statusLabaRugiTotal = "Rugi";
									$statusLabaRugiTotals = $neracaLajurLabaRugiDebetTotal-$neracaLajurLabaRugiCreditTotal;
									$statusLabaRugiDebetTotalNominal = $statusLabaRugiTotals;
									$statusLabaRugiCreditTotalNominal = 0;

								}elseif($neracaLajurLabaRugiDebetTotal<$neracaLajurLabaRugiCreditTotal){
									$statusLabaRugiTotal = "Laba";
									$statusLabaRugiTotals = $neracaLajurLabaRugiCreditTotal-$neracaLajurLabaRugiDebetTotal;
									$statusLabaRugiDebetTotalNominal = 0;
									$statusLabaRugiCreditTotalNominal = $statusLabaRugiTotals;									
								} else {
									$statusLabaRugiTotal = "";
									$statusLabaRugiDebetTotalNominal = 0;
									$statusLabaRugiCreditTotalNominal = 0;
								}


								if($neracaLajurNeracaDebetTotal>$neracaLajurNeracaCreditTotal){
									$statusNeracaTotal = "Laba";
									$statusNeracaTotals = $neracaLajurNeracaDebetTotal-$neracaLajurNeracaCreditTotal;
									$statusNeracaDebetTotalNominal = $statusNeracaTotals;
									$statusNeracaCreditTotalNominal = 0;

								}elseif($neracaLajurNeracaDebetTotal<$neracaLajurNeracaCreditTotal){
									$statusNeracaTotal = "Rugi";
									$statusNeracaTotals = $neracaLajurNeracaCreditTotal-$neracaLajurNeracaDebetTotal;
									// $statusNeracaTotalNominal = $this->Krs->nom($statusNeracaTotals);
									$statusNeracaDebetTotalNominal = 0;
									$statusNeracaCreditTotalNominal = $statusNeracaTotals;

									
								} else {
									$statusNeracaTotal = "";
									// $statusNeracaTotalNominal = 0;
									$statusNeracaDebetTotalNominal = 0;
									$statusNeracaCreditTotalNominal = 0;
								}

								$grandTotalLabaRugiDebet = $neracaLajurLabaRugiDebetTotal-$statusLabaRugiDebetTotalNominal;
								$grandTotalLabaRugiCredit = $neracaLajurLabaRugiCreditTotal-$statusLabaRugiCreditTotalNominal;
								$grandTotalNeracaDebet = $neracaLajurNeracaDebetTotal-$statusNeracaDebetTotalNominal;
								$grandTotalNeracaCredit = $neracaLajurNeracaCreditTotal-$statusNeracaCreditTotalNominal;

								echo '<tr class="table-danger text-right">
										<td>&nbsp;</td>
										<td align="right"><b>TOTAL</b></td>
										<td align="right" width="150"><b>'.$neracaSaldoDebetTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$neracaSaldoCreditTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$journalAdjustmentDebetTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$journalAdjustmentCreditTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$necaraSaldoDisesuaikanDebetTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$necaraSaldoDisesuaikanCreditTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$neracaLajurLabaRugiDebetTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$neracaLajurLabaRugiCreditTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$neracaLajurNeracaDebetTotalNominal.'</b></td>
										<td align="right" width="150"><b>'.$neracaLajurNeracaCreditTotalNominal.'</b></td>
									</tr>';
								echo '<tr class="table-danger text-right">
										<td>&nbsp;</td>
										<td align="right">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150"><b>'.$statusLabaRugiTotal.'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($statusLabaRugiDebetTotalNominal).'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($statusLabaRugiCreditTotalNominal).'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($statusNeracaDebetTotalNominal).'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($statusNeracaCreditTotalNominal).'</b></td>
									</tr>';

								echo '<tr class="table-danger text-right">
										<td>&nbsp;</td>
										<td align="right">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150">&nbsp;</td>
										<td align="right" width="150"><b>'.$this->Krs->nom($grandTotalLabaRugiDebet).'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($grandTotalLabaRugiCredit).'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($grandTotalNeracaDebet).'</b></td>
										<td align="right" width="150"><b>'.$this->Krs->nom($grandTotalNeracaCredit).'</b></td>
									</tr>';

									?>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="row">
					<table class="table">
						<?php
						/*$neracaSaldoDebetTotal = round(array_sum($neracaSaldoDebets),2);
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

						

						echo '<tr>
								<td>&nbsp;</td>
								<td align="right"><b>TOTAL</b></td>
								<td align="right" width="150"><b>'.$neracaSaldoDebetTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$neracaSaldoCreditTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$journalAdjustmentDebetTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$journalAdjustmentCreditTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$necaraSaldoDisesuaikanDebetTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$necaraSaldoDisesuaikanCreditTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$neracaLajurLabaRugiDebetTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$neracaLajurLabaRugiCreditTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$neracaLajurNeracaDebetTotalNominal.'</b></td>
								<td align="right" width="150"><b>'.$neracaLajurNeracaCreditTotalNominal.'</b></td>
							</tr>';*/

						
						
						?>
					</table>
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
    var formAction = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'work_sheet_balance_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalIncomeGlobalReportForm', 'btn-search', confirmTitle, formAction);

	handleDateRange('filterDateId', 'filterDateReset', 'filterDateClass', 'dd-mm-yyyy');
	handleDateRange('filterDatePicker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
});
</script>
<?php
/*

 height: 100px; width: 240px;
.tableFixHead {
      width: 500px;
      table-layout: fixed;
      border-collapse: collapse;
    }
      .tableFixHead tbody {
      display: block;
      width: 100%;
      overflow: auto;
      height: 50px;
    }
    .tableFixHead thead tr {
      display: block;
    }
    .tableFixHead th,
    .tableFixHead  td {
      padding: 5px 10px;
      width: 200px;
    }


th {
	

  /*position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;*/

  /*position: sticky;
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
  top: 0; /* Don't forget this, required for the stickiness */
	// <td align="right">'.$nominalDebetDetailKasBank.'</td>
							// 		<td align="right">'.$nominalCreditDetailKasBank.'</td>
							// 		<td align="right">'.$nominalBeginningDetailKasBankDebit.'</td>
							// 		<td align="right">'.$nominalBeginningDetailKasBankCredit.'</td>
							// 		<td align="right">'.$nominalTotalDetailKasBank.'</td>';

							/*
							// pr($listCOAKasBank);
							$debetDetailKasBanks = array();
							$creditDetailKasBanks = array();
							$beginningDetailKasBanks = array();
							$totalDetailKasBanks = array();
							foreach ($listCOAKasBank as $idKasBank => $detailKasBank) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailKasBank['Level5']) && $detailKasBank['Level5']) {
									$debetCreditDetailKasBanks = array();
									
									foreach ($detailKasBank['Level5'] as $dataCOAKasBank) {
										list($codeDetailKasBank, $nameDetailKasBank, $totalDebetCreditDetailKasBank, $debetDetailKasBank, $creditDetailKasBank, $beginningBalanceDetailKasBankDebit, $beginningBalanceDetailKasBankCredit, $subTotalDetailKasBank) = explode('^', $dataCOAKasBank);

										$debetDetailKasBanks[] = $debetDetailKasBank;
										$creditDetailKasBanks[] = $creditDetailKasBank;
										$beginningDetailKasBanksDebit[] = $beginningBalanceDetailKasBankDebit;
										$beginningDetailKasBanksCredit[] = $beginningBalanceDetailKasBankCredit;
										$totalDetailKasBanks[] = $subTotalDetailKasBank;
										$nominalDebetDetailKasBank = $this->Krs->cur($debetDetailKasBank);
										$nominalCreditDetailKasBank = $this->Krs->cur($creditDetailKasBank);
										$nominalBeginningDetailKasBankDebit = $this->Krs->cur($beginningBalanceDetailKasBankDebit);
										$nominalBeginningDetailKasBankCredit = $this->Krs->cur($beginningBalanceDetailKasBankCredit);
										$nominalTotalDetailKasBank = $this->Krs->cur($subTotalDetailKasBank);

										echo '<tr>
												<td>'.$codeDetailKasBank.'</td>
												<td>'.$nameDetailKasBank.'</td>
												<td align="right">'.$nominalDebetDetailKasBank.'</td>
												<td align="right">'.$nominalCreditDetailKasBank.'</td>
												<td align="right">'.$nominalBeginningDetailKasBankDebit.'</td>
												<td align="right">'.$nominalBeginningDetailKasBankCredit.'</td>
												<td align="right">'.$nominalTotalDetailKasBank.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailPiutangs = array();
							$creditDetailPiutangs = array();
							$beginningDetailPiutangs = array();
							$totalDetailPiutangs = array();
							foreach ($listCOAPiutang as $idPiutang => $detailPiutang) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailPiutang['Level5']) && $detailPiutang['Level5']) {
									$debetCreditDetailPiutangs = array();
									foreach ($detailPiutang['Level5'] as $dataCOAPiutang) {
										list($codeDetailPiutang, $nameDetailPiutang, $totalDebetCreditDetailPiutang, $debetDetailPiutang, $creditDetailPiutang, $beginningBalanceDetailPiutangDebit, $beginningBalanceDetailPiutangCredit, $subTotalDetailPiutang) = explode('^', $dataCOAPiutang);
										//$totalPiutangs = $debetCreditDetailPiutang+$beginningBalanceDetailPiutang;
										$debetDetailPiutangs[] = $debetDetailPiutang;
										$creditDetailPiutangs[] = $creditDetailPiutang;
										$beginningDetailPiutangsDebit[] = $beginningBalanceDetailPiutangDebit;
										$beginningDetailPiutangsCredit[] = $beginningBalanceDetailPiutangCredit;
										$totalDetailPiutangs[] = $subTotalDetailPiutang;
										$nominalDebetDetailPiutang = $this->Krs->cur($debetDetailPiutang);
										$nominalCreditDetailPiutang = $this->Krs->cur($creditDetailPiutang);
										$nominalBeginningDetailPiutangDebit = $this->Krs->cur($beginningBalanceDetailPiutangDebit);
										$nominalBeginningDetailPiutangCredit = $this->Krs->cur($beginningBalanceDetailPiutangCredit);
										$nominalTotalDetailPiutang = $this->Krs->cur($subTotalDetailPiutang);

										echo '<tr>
												<td>'.$codeDetailPiutang.'</td>
												<td>'.$nameDetailPiutang.'</td>
												<td align="right">'.$nominalDebetDetailPiutang.'</td>
												<td align="right">'.$nominalCreditDetailPiutang.'</td>
												<td align="right">'.$nominalBeginningDetailPiutangDebit.'</td>
												<td align="right">'.$nominalBeginningDetailPiutangCredit.'</td>
												<td align="right">'.$nominalTotalDetailPiutang.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailAktivaTetaps = array();
							$creditDetailAktivaTetaps = array();
							$beginningDetailAktivaTetaps = array();
							$totalDetailAktivaTetaps = array();
							foreach ($listCOAAktivaTetap as $idAktivaTetap => $detailAktivaTetap) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level5']) {
									$debetCreditDetailAktivaTetaps = array();
									foreach ($detailAktivaTetap['Level5'] as $dataCOAAktivaTetap) {
										list($codeDetailAktivaTetap, $nameDetailAktivaTetap, $totalDebetCreditDetailAktivaTetap, $debetDetailAktivaTetap, $creditDetailAktivaTetap, $beginningBalanceDetailAktivaTetapDebit, $beginningBalanceDetailAktivaTetapCredit, $subTotalDetailAktivaTetap) = explode('^', $dataCOAAktivaTetap);
										//$totalAktivaTetaps = $debetCreditDetailAktivaTetap+$beginningBalanceDetailAktivaTetap;
										$debetDetailAktivaTetaps[] = $debetDetailAktivaTetap;
										$creditDetailAktivaTetaps[] = $creditDetailAktivaTetap;
										$beginningDetailAktivaTetapsDebit[] = $beginningBalanceDetailAktivaTetapDebit;
										$beginningDetailAktivaTetapsCredit[] = $beginningBalanceDetailAktivaTetapCredit;
										$totalDetailAktivaTetaps[] = $subTotalDetailAktivaTetap;
										$nominalDebetDetailAktivaTetap = $this->Krs->cur($debetDetailAktivaTetap);
										$nominalCreditDetailAktivaTetap = $this->Krs->cur($creditDetailAktivaTetap);

										$nominalBeginningDetailAktivaTetapDebit = $this->Krs->cur($beginningBalanceDetailAktivaTetapDebit);
										$nominalBeginningDetailAktivaTetapCredit = $this->Krs->cur($beginningBalanceDetailAktivaTetapCredit);

										$nominalTotalDetailAktivaTetap = $this->Krs->cur($subTotalDetailAktivaTetap);

										echo '<tr>
												<td>'.$codeDetailAktivaTetap.'</td>
												<td>'.$nameDetailAktivaTetap.'</td>
												<td align="right">'.$nominalDebetDetailAktivaTetap.'</td>
												<td align="right">'.$nominalCreditDetailAktivaTetap.'</td>
												<td align="right">'.$nominalBeginningDetailAktivaTetapDebit.'</td>
												<td align="right">'.$nominalBeginningDetailAktivaTetapCredit.'</td>
												<td align="right">'.$nominalTotalDetailAktivaTetap.'</td>';
										echo '</tr>';
									}
								}
							}


							$debetDetailAkumulasiPenyusutans = array();
							$creditDetailAkumulasiPenyusutans = array();
							$beginningDetailAkumulasiPenyusutans = array();
							$totalDetailAkumulasiPenyusutans = array();
							foreach ($listCOAAkumulasiPenyusutan as $idAkumulasiPenyusutan => $detailAkumulasiPenyusutan) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level5']) {
									$debetCreditDetailAkumulasiPenyusutans = array();
									foreach ($detailAkumulasiPenyusutan['Level5'] as $dataCOAAkumulasiPenyusutan) {
										list($codeDetailAkumulasiPenyusutan, $nameDetailAkumulasiPenyusutan, $totalDebetCreditDetailAkumulasiPenyusutan, $debetDetailAkumulasiPenyusutan, $creditDetailAkumulasiPenyusutan, $beginningBalanceDetailAkumulasiPenyusutanDebit, $beginningBalanceDetailAkumulasiPenyusutanCredit, $subTotalDetailAkumulasiPenyusutan) = explode('^', $dataCOAAkumulasiPenyusutan);
										//$totalAkumulasiPenyusutans = $debetCreditDetailAkumulasiPenyusutan+$beginningBalanceDetailAkumulasiPenyusutan;
										$debetDetailAkumulasiPenyusutans[] = $debetDetailAkumulasiPenyusutan;
										$creditDetailAkumulasiPenyusutans[] = $creditDetailAkumulasiPenyusutan;

										$beginningDetailAkumulasiPenyusutansDebit[] = $beginningBalanceDetailAkumulasiPenyusutanDebit;
										$beginningDetailAkumulasiPenyusutansCredit[] = $beginningBalanceDetailAkumulasiPenyusutanCredit;

										$totalDetailAkumulasiPenyusutans[] = $subTotalDetailAkumulasiPenyusutan;
										$nominalDebetDetailAkumulasiPenyusutan = $this->Krs->cur($debetDetailAkumulasiPenyusutan);
										$nominalCreditDetailAkumulasiPenyusutan = $this->Krs->cur($creditDetailAkumulasiPenyusutan);
										$nominalBeginningDetailAkumulasiPenyusutanDebit = $this->Krs->cur($beginningBalanceDetailAkumulasiPenyusutanDebit);
										$nominalBeginningDetailAkumulasiPenyusutanCredit = $this->Krs->cur($beginningBalanceDetailAkumulasiPenyusutanCredit);

										$nominalTotalDetailAkumulasiPenyusutan = $this->Krs->cur($subTotalDetailAkumulasiPenyusutan);

										echo '<tr>
												<td>'.$codeDetailAkumulasiPenyusutan.'</td>
												<td>'.$nameDetailAkumulasiPenyusutan.'</td>
												<td align="right">'.$nominalDebetDetailAkumulasiPenyusutan.'</td>
												<td align="right">'.$nominalCreditDetailAkumulasiPenyusutan.'</td>
												<td align="right">'.$nominalBeginningDetailAkumulasiPenyusutanDebit.'</td>
												<td align="right">'.$nominalBeginningDetailAkumulasiPenyusutanCredit.'</td>
												<td align="right">'.$nominalTotalDetailAkumulasiPenyusutan.'</td>';
										echo '</tr>';
									}
								}
							}


							$debetDetailHutangs = array();
							$creditDetailHutangs = array();
							$beginningDetailHutangs = array();
							$totalDetailHutangs = array();
							foreach ($listCOAHutang as $idHutang => $detailHutang) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailHutang['Level5']) && $detailHutang['Level5']) {
									$debetCreditDetailHutangs = array();
									foreach ($detailHutang['Level5'] as $dataCOAHutang) {
										list($codeDetailHutang, $nameDetailHutang, $totalDebetCreditDetailHutang, $debetDetailHutang, $creditDetailHutang, $beginningBalanceDetailHutangDebit, $beginningBalanceDetailHutangCredit, $subTotalDetailHutang) = explode('^', $dataCOAHutang);
										//$totalHutangs = $debetCreditDetailHutang+$beginningBalanceDetailHutang;
										$debetDetailHutangs[] = $debetDetailHutang;
										$creditDetailHutangs[] = $creditDetailHutang;
										$beginningDetailHutangsDebit[] = $beginningBalanceDetailHutangDebit;
										$beginningDetailHutangsCredit[] = $beginningBalanceDetailHutangCredit;

										$totalDetailHutangs[] = $subTotalDetailHutang;
										$nominalDebetDetailHutang = $this->Krs->cur($debetDetailHutang);
										$nominalCreditDetailHutang = $this->Krs->cur($creditDetailHutang);

										$nominalBeginningDetailHutangDebit = $this->Krs->cur($beginningBalanceDetailHutangDebit);
										$nominalBeginningDetailHutangCredit = $this->Krs->cur($beginningBalanceDetailHutangCredit);

										$nominalTotalDetailHutang = $this->Krs->cur($subTotalDetailHutang);

										echo '<tr>
												<td>'.$codeDetailHutang.'</td>
												<td>'.$nameDetailHutang.'</td>
												<td align="right">'.$nominalDebetDetailHutang.'</td>
												<td align="right">'.$nominalCreditDetailHutang.'</td>
												<td align="right">'.$nominalBeginningDetailHutangDebit.'</td>
												<td align="right">'.$nominalBeginningDetailHutangCredit.'</td>
												<td align="right">'.$nominalTotalDetailHutang.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailHutangLancars = array();
							$creditDetailHutangLancars = array();
							$beginningDetailHutangLancars = array();
							$totalDetailHutangLancars = array();
							foreach ($listCOAHutangLancar as $idHutangLancar => $detailHutangLancar) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level5']) {
									$debetCreditDetailHutangLancars = array();
									foreach ($detailHutangLancar['Level5'] as $dataCOAHutangLancar) {
										list($codeDetailHutangLancar, $nameDetailHutangLancar, $totalDebetCreditDetailHutangLancar, $debetDetailHutangLancar, $creditDetailHutangLancar, $beginningBalanceDetailHutangLancarDebit, $beginningBalanceDetailHutangLancarCredit, $subTotalDetailHutangLancar) = explode('^', $dataCOAHutangLancar);
										//$totalHutangLancars = $debetCreditDetailHutangLancar+$beginningBalanceDetailHutangLancar;
										$debetDetailHutangLancars[] = $debetDetailHutangLancar;
										$creditDetailHutangLancars[] = $creditDetailHutangLancar;

										$beginningDetailHutangLancarsDebit[] = $beginningBalanceDetailHutangLancarDebit;
										$beginningDetailHutangLancarsCredit[] = $beginningBalanceDetailHutangLancarCredit;

										$totalDetailHutangLancars[] = $subTotalDetailHutangLancar;
										$nominalDebetDetailHutangLancar = $this->Krs->cur($debetDetailHutangLancar);
										$nominalCreditDetailHutangLancar = $this->Krs->cur($creditDetailHutangLancar);
										
										$nominalBeginningDetailHutangLancarDebit = $this->Krs->cur($beginningBalanceDetailHutangLancarDebit);
										$nominalBeginningDetailHutangLancarCredit = $this->Krs->cur($beginningBalanceDetailHutangLancarCredit);

										$nominalTotalDetailHutangLancar = $this->Krs->cur($subTotalDetailHutangLancar);

										echo '<tr>
												<td>'.$codeDetailHutangLancar.'</td>
												<td>'.$nameDetailHutangLancar.'</td>
												<td align="right">'.$nominalDebetDetailHutangLancar.'</td>
												<td align="right">'.$nominalCreditDetailHutangLancar.'</td>
												<td align="right">'.$nominalBeginningDetailHutangLancarDebit.'</td>
												<td align="right">'.$nominalBeginningDetailHutangLancarCredit.'</td>
												<td align="right">'.$nominalTotalDetailHutangLancar.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailModals = array();
							$creditDetailModals = array();
							$beginningDetailModals = array();
							$totalDetailModals = array();
							foreach ($listCOAModal as $idModal => $detailModal) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailModal['Level5']) && $detailModal['Level5']) {
									$debetCreditDetailModals = array();
									foreach ($detailModal['Level5'] as $dataCOAModal) {
										list($codeDetailModal, $nameDetailModal, $totalDebetCreditDetailModal, $debetDetailModal, $creditDetailModal, $beginningBalanceDetailModalDebit, $beginningBalanceDetailModalCredit, $subTotalDetailModal) = explode('^', $dataCOAModal);
										//$totalModals = $debetCreditDetailModal+$beginningBalanceDetailModal;
										$debetDetailModals[] = $debetDetailModal;
										$creditDetailModals[] = $creditDetailModal;

										$beginningDetailModalsDebit[] = $beginningBalanceDetailModalDebit;
										$beginningDetailModalsCredit[] = $beginningBalanceDetailModalCredit;

										$totalDetailModals[] = $subTotalDetailModal;
										$nominalDebetDetailModal = $this->Krs->cur($debetDetailModal);
										$nominalCreditDetailModal = $this->Krs->cur($creditDetailModal);

										$nominalBeginningDetailModalDebit = $this->Krs->cur($beginningBalanceDetailModalDebit);
										$nominalBeginningDetailModalCredit = $this->Krs->cur($beginningBalanceDetailModalCredit);

										$nominalTotalDetailModal = $this->Krs->cur($subTotalDetailModal);

										echo '<tr>
												<td>'.$codeDetailModal.'</td>
												<td>'.$nameDetailModal.'</td>
												<td align="right">'.$nominalDebetDetailModal.'</td>
												<td align="right">'.$nominalCreditDetailModal.'</td>
												<td align="right">'.$nominalBeginningDetailModalDebit.'</td>
												<td align="right">'.$nominalBeginningDetailModalCredit.'</td>
												<td align="right">'.$nominalTotalDetailModal.'</td>';
										echo '</tr>';
									}
								}
							} 



							$grandTotalBeforeDebetPrives = array();
							$grandTotalBeforeCreditPrives = array();
							$grandTotalBeforePrives = array();
							foreach ($listCOABeforePrive as $idBeforePrive => $detailBeforePrive) {
							 	if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level5']) {
									$debetDetailBeforePrives = array();
									$creditDetailBeforePrives = array();
									$debetCreditDetailBeforePrives = array();
									foreach ($detailBeforePrive['Level5'] as $dataCOABeforePrive) {
										list($codeDetailBeforePrive, $nameDetailBeforePrive, $totalDebetCreditDetailBeforePrive, $debetDetailBeforePrive, $creditDetailBeforePrive, $beginningBalanceDetailBeforePriveDebit, $beginningBalanceDetailBeforePriveCredit, $subTotalDetailBeforePrive) = explode('^', $dataCOABeforePrive);

										//list($codeDetailBeforePrive, $nameDetailBeforePrive, $debetCreditDetailBeforePrive, $beginningBalanceDetailBeforePrive, $subTotalDetailBeforePrive) = explode('^', $dataCOABeforePrive);
										$debetDetailBeforePrives[] = $debetDetailBeforePrive;
										$creditDetailBeforePrives[] = $creditDetailBeforePrive;
										$debetCreditDetailBeforePrives[] = $subTotalDetailBeforePrive;
									}
								}

								if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level4']) {
									list($codeBeforePrive, $nameBeforePrive) = explode('^', $detailBeforePrive['Level4']);

									if(!empty($codeBeforePrive)) {
										$totalLevel4BeforeDebetPrive = array_sum($debetDetailBeforePrives);
										$totalLevel4BeforeCreditPrive = array_sum($creditDetailBeforePrives);
										$totalLevel4BeforePrive = array_sum($debetCreditDetailBeforePrives);
										$grandTotalBeforeDebetPrives[] = $totalLevel4BeforeDebetPrive;
										$grandTotalBeforeCreditPrives[] = $totalLevel4BeforeCreditPrive;
										$grandTotalBeforePrives[] = $totalLevel4BeforePrive;			
									}
								}
							}
							$grandTotalBeforeDebetPrive = (empty($grandTotalBeforeDebetPrives)) ? 0 : round(array_sum($grandTotalBeforeDebetPrives),2);
							$grandTotalBeforeCreditPrive = (empty($grandTotalBeforeCreditPrives)) ? 0 : round(array_sum($grandTotalBeforeCreditPrives),2);
							$grandTotalBeforePrive = (empty($grandTotalBeforePrives)) ? 0 : round(array_sum($grandTotalBeforePrives),2);

							//pr($listCOABeforePrive);
							//pr($listCOABeforeSaldoDitahan);
							//pr($listCOASaldoDitahan);
							$debetDetailSaldoDitahans = array();
							$creditDetailSaldoDitahans = array();
							$beginningDetailSaldoDitahans = array();
							$totalDetailSaldoDitahans = array();
							$grandTotalSaldoDitahans = array();
							foreach ($listCOASaldoDitahan as $idSaldoDitahan => $detailSaldoDitahan) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level5']) {
									//$debetCreditDetailSaldoDitahans = array();
									foreach ($detailSaldoDitahan['Level5'] as $dataCOASaldoDitahan) {
										list($codeDetailSaldoDitahan, $nameDetailSaldoDitahan, $totalDebetCreditDetailSaldoDitahan, $debetDetailSaldoDitahan, $creditDetailSaldoDitahan, $beginningBalanceDetailSaldoDitahanDebit, $beginningBalanceDetailSaldoDitahanCredit, $subTotalDetailSaldoDitahan) = explode('^', $dataCOASaldoDitahan);

										list($codeDetailBeforeSaldoDitahan, $nameDetailBeforeSaldoDitahan, $totalDebetCreditDetailBeforeSaldoDitahan, $debetDetailBeforeSaldoDitahan, $creditDetailBeforeSaldoDitahan, $beginningBalanceDetailBeforeSaldoDitahanDebit, $beginningBalanceDetailBeforeSaldoDitahanCredit, $subTotalDetailBeforeSaldoDitahan) = explode('^', $listCOABeforeSaldoDitahan[$idSaldoDitahan]['Level5'][0]);
										
										$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
										//pr($debetDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeDebetLabaRugiBerjalan.'+'.$grandTotalBeforeDebetPrive);

										$debetSaldoDitahan = ((int)$debetDetailBeforeSaldoDitahan+(int)$totalGrandBeforeDebetLabaRugiBerjalan+(int)$grandTotalBeforeDebetPrive);
										$creditSaldoDitahan = ((int)$creditDetailBeforeSaldoDitahan+(int)$totalGrandBeforeCreditLabaRugiBerjalan+(int)$grandTotalBeforeCreditPrive);
										//totalGrandBeforeCreditLabaRugiBerjalan
										$totalkus = ((int)$debetSaldoDitahan+((int)$beginningBalanceDetailSaldoDitahanDebit-(int)$beginningBalanceDetailSaldoDitahanCredit)-(int)$creditSaldoDitahan);
										$totalku = $this->Krs->cur($totalkus);

										$debetDetailSaldoDitahans[] = $debetSaldoDitahan;
										$creditDetailSaldoDitahans[] = $creditSaldoDitahan;

										$beginningDetailSaldoDitahansDebit[] = $beginningBalanceDetailSaldoDitahanDebit;
										$beginningDetailSaldoDitahansCredit[] = $beginningBalanceDetailSaldoDitahanCredit;

										$totalDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
										$nominalDebetDetailSaldoDitahan = $this->Krs->cur($debetSaldoDitahan);
										$nominalCreditDetailSaldoDitahan = $this->Krs->cur($creditSaldoDitahan);

										$nominalBeginningDetailSaldoDitahanDebit = $this->Krs->cur($beginningBalanceDetailSaldoDitahanDebit);
										$nominalBeginningDetailSaldoDitahanCredit = $this->Krs->cur($beginningBalanceDetailSaldoDitahanCredit);

										$nominalTotalDetailSaldoDitahan = $this->Krs->cur($subTotalBeforeSaldoDitahan);

										//$totalBeforeDebetLabaRugiBerjalanInfo = $grandTotalBeforeCreditPendapatan.'^'.$grandTotalBeforeCreditPendapatanLain.'^'.$grandTotalBeforeCreditHargaPokokPenjualan.'^'.$grandTotalBeforeCreditBeban.'^'.$grandTotalBeforeCreditBebanPemasaran.'^'.$grandTotalBeforeCreditBebanLainLain;
										list($lrPendapatan, $lrPendapatanLain, $lrHargaPokokPenjualan, $lrBeban, $lrBebanPemasaran, $lrBebanLainLain) = explode('^', $totalBeforeLabaRugiBerjalanInfo);

										list($lrDebetPendapatan, $lrDebetPendapatanLain, $lrDebetHargaPokokPenjualan, $lrDebetBeban, $lrDebetBebanPemasaran, $lrDebetBebanLainLain) = explode('^', $totalBeforeDebetLabaRugiBerjalanInfo);
										list($lrCreditPendapatan, $lrCreditPendapatanLain, $lrCreditHargaPokokPenjualan, $lrCreditBeban, $lrCreditBebanPemasaran, $lrCreditBebanLainLain) = explode('^', $totalBeforeCreditLabaRugiBerjalanInfo);

										$infoLR = "Pendapatan = ".$lrPendapatan."<br>"."Pendapatan Lain = ".$lrPendapatanLain."<br>"."HPP = ".$lrHargaPokokPenjualan."<br>"."Beban = ".$lrBeban."<br>"."Beban Pemasaran = ".$lrBebanPemasaran."<br>"."Beban Lain-lain = ".$lrBebanLainLain;

										$infoLRDebet = "Pendapatan = ".$lrDebetPendapatan."<br>"."Pendapatan Lain = ".$lrDebetPendapatanLain."<br>"."HPP = ".$lrDebetHargaPokokPenjualan."<br>"."Beban = ".$lrDebetBeban."<br>"."Beban Pemasaran = ".$lrDebetBebanPemasaran."<br>"."Beban Lain-lain = ".$lrDebetBebanLainLain;
										$infoLRCredit = "Pendapatan = ".$lrCreditPendapatan."<br>"."Pendapatan Lain = ".$lrCreditPendapatanLain."<br>"."HPP = ".$lrCreditHargaPokokPenjualan."<br>"."Beban = ".$lrCreditBeban."<br>"."Beban Pemasaran = ".$lrCreditBebanPemasaran."<br>"."Beban Lain-lain = ".$lrCreditBebanLainLain;
										//.' = '.$debetDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeDebetLabaRugiBerjalan.'+'.$grandTotalBeforeDebetPrive
										//.' = '.$creditDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeCreditLabaRugiBerjalan.'+'.$grandTotalBeforeCreditPrive.

										echo '<tr>
												<td>'.$codeDetailSaldoDitahan.'</td>
												<td>'.$nameDetailSaldoDitahan.'</td>
												<td align="right">'.$nominalDebetDetailSaldoDitahan.'</td>
												<td align="right">'.$nominalCreditDetailSaldoDitahan.'</td>
												<td align="right">'.$nominalBeginningDetailSaldoDitahanDebit.'</td>
												<td align="right">'.$nominalBeginningDetailSaldoDitahanCredit.'</td>
												<td align="right">'.$nominalTotalDetailSaldoDitahan.'</td>';
										echo '</tr>';
									}
								}
							}
							echo '</tr>';

							$debetDetailPrives = array();
							$creditDetailPrives = array();
							$beginningDetailPrives = array();
							$totalDetailPrives = array();
							foreach ($listCOAPrive as $idPrive => $detailPrive) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailPrive['Level5']) && $detailPrive['Level5']) {
									$debetCreditDetailPrives = array();
									foreach ($detailPrive['Level5'] as $dataCOAPrive) {
										list($codeDetailPrive, $nameDetailPrive, $totalDebetCreditDetailPrive, $debetDetailPrive, $creditDetailPrive, $beginningBalanceDetailPriveDebit, $beginningBalanceDetailBeforePriveCredit, $subTotalDetailPrive) = explode('^', $dataCOAPrive);
										//$totalPrives = $debetCreditDetailPrive+$beginningBalanceDetailPrive;
										$debetDetailPrives[] = $debetDetailPrive;
										$creditDetailPrives[] = $creditDetailPrive;
										$beginningDetailPrives[] = $beginningBalanceDetailPrive;
										$totalDetailPrives[] = $subTotalDetailPrive;
										$nominalDebetDetailPrive = $this->Krs->cur($debetDetailPrive);
										$nominalCreditDetailPrive = $this->Krs->cur($creditDetailPrive);

										$nominalBeginningDetailPriveDebit = $this->Krs->cur($beginningBalanceDetailPriveDebit);
										$nominalBeginningDetailPriveCredit = $this->Krs->cur($beginningBalanceDetailBeforePriveCredit);

										$nominalTotalDetailPrive = $this->Krs->cur($subTotalDetailPrive);

										echo '<tr>
												<td>'.$codeDetailPrive.'</td>
												<td>'.$nameDetailPrive.'</td>
												<td align="right">'.$nominalDebetDetailPrive.'</td>
												<td align="right">'.$nominalCreditDetailPrive.'</td>
												<td align="right">'.$nominalBeginningDetailPriveDebit.'</td>
												<td align="right">'.$nominalBeginningDetailPriveCredit.'</td>
												<td align="right">'.$nominalTotalDetailPrive.'</td>';
										echo '</tr>';
									}
								}
							}


							$debetDetailPendapatanShows = array();
							$creditDetailPendapatanShows = array();
							$beginningDetailPendapatanShows = array();
							$totalDetailPendapatanShows = array();
							foreach ($listCOAPendapatanShow as $idPendapatanShow => $detailPendapatanShow) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailPendapatanShow['Level5']) && $detailPendapatanShow['Level5']) {
									$debetCreditDetailPendapatanShows = array();
									foreach ($detailPendapatanShow['Level5'] as $dataCOAPendapatanShow) {
										list($codeDetailPendapatanShow, $nameDetailPendapatanShow, $totalDebetCreditDetailPendapatanShow, $debetDetailPendapatanShow, $creditDetailPendapatanShow, $beginningBalanceDetailPendapatanShowDebit
											, $beginningBalanceDetailPendapatanShowCredit, $subTotalDetailPendapatanShow) = explode('^', $dataCOAPendapatanShow);
										//$totalPendapatanShows = $debetCreditDetailPendapatanShow+$beginningBalanceDetailPendapatanShow;
										$debetDetailPendapatanShows[] = $debetDetailPendapatanShow;
										$creditDetailPendapatanShows[] = $creditDetailPendapatanShow;
										$beginningDetailPendapatanShows[] = $beginningBalanceDetailPendapatanShow;
										$totalDetailPendapatanShows[] = $subTotalDetailPendapatanShow;
										$nominalDebetDetailPendapatanShow = $this->Krs->cur($debetDetailPendapatanShow);
										$nominalCreditDetailPendapatanShow = $this->Krs->cur($creditDetailPendapatanShow);

										$nominalBeginningDetailPendapatanShowDebit = $this->Krs->cur($beginningBalanceDetailPendapatanShowDebit);
										$nominalBeginningDetailPendapatanShowCredit = $this->Krs->cur($beginningBalanceDetailPendapatanShowCredit);

										$nominalTotalDetailPendapatanShow = $this->Krs->cur($subTotalDetailPendapatanShow);

										echo '<tr>
												<td>'.$codeDetailPendapatanShow.'</td>
												<td>'.$nameDetailPendapatanShow.'</td>
												<td align="right">'.$nominalDebetDetailPendapatanShow.'</td>
												<td align="right">'.$nominalCreditDetailPendapatanShow.'</td>
												<td align="right">'.$nominalBeginningDetailPendapatanShowDebit.'</td>
												<td align="right">'.$nominalBeginningDetailPendapatanShowCredit.'</td>
												<td align="right">'.$nominalTotalDetailPendapatanShow.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailPendapatanLains = array();
							$creditDetailPendapatanLains = array();
							$beginningDetailPendapatanLains = array();
							$totalDetailPendapatanLains = array();
							foreach ($listCOAPendapatanLain as $idPendapatanLain => $detailPendapatanLain) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailPendapatanLain['Level5']) && $detailPendapatanLain['Level5']) {
									$debetCreditDetailPendapatanLains = array();
									foreach ($detailPendapatanLain['Level5'] as $dataCOAPendapatanLain) {
										list($codeDetailPendapatanLain, $nameDetailPendapatanLain, $totalDebetCreditDetailPendapatanLain, $debetDetailPendapatanLain, $creditDetailPendapatanLain, $beginningBalanceDetailPendapatanLainDebit, $beginningBalanceDetailPendapatanLainCredit, $subTotalDetailPendapatanLain) = explode('^', $dataCOAPendapatanLain);
										//$totalPendapatanLains = $debetCreditDetailPendapatanLain+$beginningBalanceDetailPendapatanLain;
										$debetDetailPendapatanLains[] = $debetDetailPendapatanLain;
										$creditDetailPendapatanLains[] = $creditDetailPendapatanLain;
										
										$beginningDetailPendapatanLainsDebit[] = $beginningBalanceDetailPendapatanLainDebit;
										$beginningDetailPendapatanLainsCredit[] = $beginningBalanceDetailPendapatanLainCredit;

										$totalDetailPendapatanLains[] = $subTotalDetailPendapatanLain;
										$nominalDebetDetailPendapatanLain = $this->Krs->cur($debetDetailPendapatanLain);
										$nominalCreditDetailPendapatanLain = $this->Krs->cur($creditDetailPendapatanLain);

										$nominalBeginningDetailPendapatanLainDebit = $this->Krs->cur($beginningBalanceDetailPendapatanLainDebit);
										$nominalBeginningDetailPendapatanLainCredit = $this->Krs->cur($beginningBalanceDetailPendapatanLainCredit);

										$nominalTotalDetailPendapatanLain = $this->Krs->cur($subTotalDetailPendapatanLain);

										echo '<tr>
												<td>'.$codeDetailPendapatanLain.'</td>
												<td>'.$nameDetailPendapatanLain.'</td>
												<td align="right">'.$nominalDebetDetailPendapatanLain.'</td>
												<td align="right">'.$nominalCreditDetailPendapatanLain.'</td>
												<td align="right">'.$nominalBeginningDetailPendapatanLainDebit.'</td>
												<td align="right">'.$nominalBeginningDetailPendapatanLainCredit.'</td>
												<td align="right">'.$nominalTotalDetailPendapatanLain.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailBebans = array();
							$creditDetailBebans = array();
							$beginningDetailBebans = array();
							$totalDetailBebans = array();
							foreach ($listCOABeban as $idBeban => $detailBeban) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailBeban['Level5']) && $detailBeban['Level5']) {
									$debetCreditDetailBebans = array();
									foreach ($detailBeban['Level5'] as $dataCOABeban) {
										list($codeDetailBeban, $nameDetailBeban, $totalDebetCreditDetailBeban, $debetDetailBeban, $creditDetailBeban, $beginningBalanceDetailBebanDebit, $beginningBalanceDetailBebanCredit, $subTotalDetailBeban) = explode('^', $dataCOABeban);
										//$totalBebans = $debetCreditDetailBeban+$beginningBalanceDetailBeban;
										$debetDetailBebans[] = $debetDetailBeban;
										$creditDetailBebans[] = $creditDetailBeban;
										$beginningDetailBebans[] = $beginningBalanceDetailBeban;
										$totalDetailBebans[] = $subTotalDetailBeban;
										$nominalDebetDetailBeban = $this->Krs->cur($debetDetailBeban);
										$nominalCreditDetailBeban = $this->Krs->cur($creditDetailBeban);

										$nominalBeginningDetailBebanDebit = $this->Krs->cur($beginningBalanceDetailBebanDebit);
										$nominalBeginningDetailBebanCredit = $this->Krs->cur($beginningBalanceDetailBebanCredit);

										$nominalTotalDetailBeban = $this->Krs->cur($subTotalDetailBeban);

										echo '<tr>
												<td>'.$codeDetailBeban.'</td>
												<td>'.$nameDetailBeban.'</td>
												<td align="right">'.$nominalDebetDetailBeban.'</td>
												<td align="right">'.$nominalCreditDetailBeban.'</td>
												<td align="right">'.$nominalBeginningDetailBebanDebit.'</td>
												<td align="right">'.$nominalBeginningDetailBebanCredit.'</td>
												<td align="right">'.$nominalTotalDetailBeban.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailBebanPemasarans = array();
							$creditDetailBebanPemasarans = array();
							$beginningDetailBebanPemasarans = array();
							$totalDetailBebanPemasarans = array();
							foreach ($listCOABebanPemasaran as $idBebanPemasaran => $detailBebanPemasaran) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailBebanPemasaran['Level5']) && $detailBebanPemasaran['Level5']) {
									$debetCreditDetailBebanPemasarans = array();
									foreach ($detailBebanPemasaran['Level5'] as $dataCOABebanPemasaran) {
										list($codeDetailBebanPemasaran, $nameDetailBebanPemasaran, $totalDebetCreditDetailBebanPemasaran, $debetDetailBebanPemasaran, $creditDetailBebanPemasaran, $beginningBalanceDetailBebanPemasaranDebit, $beginningBalanceDetailBebanPemasaranCredit, $subTotalDetailBebanPemasaran) = explode('^', $dataCOABebanPemasaran);
										//$totalBebanPemasarans = $debetCreditDetailBebanPemasaran+$beginningBalanceDetailBebanPemasaran;
										$debetDetailBebanPemasarans[] = $debetDetailBebanPemasaran;
										$creditDetailBebanPemasarans[] = $creditDetailBebanPemasaran;
										$beginningDetailBebanPemasarans[] = $beginningBalanceDetailBebanPemasaran;
										$totalDetailBebanPemasarans[] = $subTotalDetailBebanPemasaran;
										$nominalDebetDetailBebanPemasaran = $this->Krs->cur($debetDetailBebanPemasaran);
										$nominalCreditDetailBebanPemasaran = $this->Krs->cur($creditDetailBebanPemasaran);

										$nominalBeginningDetailBebanPemasaranDebit = $this->Krs->cur($beginningBalanceDetailBebanPemasaranDebit);
										$nominalBeginningDetailBebanPemasaranCredit = $this->Krs->cur($beginningBalanceDetailBebanPemasaranCredit);

										$nominalTotalDetailBebanPemasaran = $this->Krs->cur($subTotalDetailBebanPemasaran);

										echo '<tr>
												<td>'.$codeDetailBebanPemasaran.'</td>
												<td>'.$nameDetailBebanPemasaran.'</td>
												<td align="right">'.$nominalDebetDetailBebanPemasaran.'</td>
												<td align="right">'.$nominalCreditDetailBebanPemasaran.'</td>
												<td align="right">'.$nominalBeginningDetailBebanPemasaranDebit.'</td>
												<td align="right">'.$nominalBeginningDetailBebanPemasaranCredit.'</td>
												<td align="right">'.$nominalTotalDetailBebanPemasaran.'</td>';
										echo '</tr>';
									}
								}
							}

							$debetDetailBebanLainLains = array();
							$creditDetailBebanLainLains = array();
							$beginningDetailBebanLainLains = array();
							$totalDetailBebanLainLains = array();
							foreach ($listCOABebanLainLain as $idBebanLainLain => $detailBebanLainLain) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailBebanLainLain['Level5']) && $detailBebanLainLain['Level5']) {
									$debetCreditDetailBebanLainLains = array();
									foreach ($detailBebanLainLain['Level5'] as $dataCOABebanLainLain) {
										list($codeDetailBebanLainLain, $nameDetailBebanLainLain, $totalDebetCreditDetailBebanLainLain, $debetDetailBebanLainLain, $creditDetailBebanLainLain, $beginningBalanceDetailBebanLainLainDebit, $beginningBalanceDetailBebanLainLainCredit, $subTotalDetailBebanLainLain) = explode('^', $dataCOABebanLainLain);
										//$totalBebanLainLains = $debetCreditDetailBebanLainLain+$beginningBalanceDetailBebanLainLain;
										$debetDetailBebanLainLains[] = $debetDetailBebanLainLain;
										$creditDetailBebanLainLains[] = $creditDetailBebanLainLain;

										$beginningDetailBebanLainLainsDebit[] = $beginningBalanceDetailBebanLainLainDebit;
										$beginningDetailBebanLainLainsCredit[] = $beginningBalanceDetailBebanLainLainCredit;

										$totalDetailBebanLainLains[] = $subTotalDetailBebanLainLain;
										$nominalDebetDetailBebanLainLain = $this->Krs->cur($debetDetailBebanLainLain);
										$nominalCreditDetailBebanLainLain = $this->Krs->cur($creditDetailBebanLainLain);

										$nominalBeginningDetailBebanLainLainDebit = $this->Krs->cur($beginningBalanceDetailBebanLainLainDebit);
										$nominalBeginningDetailBebanLainLainCredit = $this->Krs->cur($beginningBalanceDetailBebanLainLainCredit);

										$nominalTotalDetailBebanLainLain = $this->Krs->cur($subTotalDetailBebanLainLain);

										echo '<tr>
												<td>'.$codeDetailBebanLainLain.'</td>
												<td>'.$nameDetailBebanLainLain.'</td>
												<td align="right">'.$nominalDebetDetailBebanLainLain.'</td>
												<td align="right">'.$nominalCreditDetailBebanLainLain.'</td>
												<td align="right">'.$nominalBeginningDetailBebanLainLainDebit.'</td>
												<td align="right">'.$nominalBeginningDetailBebanLainLainCredit.'</td>
												<td align="right">'.$nominalTotalDetailBebanLainLain.'</td>';
										echo '</tr>';
									}
								}
							}




							$debetDetailHargaPokokPenjualans = array();
							$creditDetailHargaPokokPenjualans = array();
							$beginningDetailHargaPokokPenjualans = array();
							$totalDetailHargaPokokPenjualans = array();
							foreach ($listCOAHargaPokokPenjualan as $idHargaPokokPenjualan => $detailHargaPokokPenjualan) {
							 	// Keterangan pada Kas serta Bank
								if(isset($detailHargaPokokPenjualan['Level5']) && $detailHargaPokokPenjualan['Level5']) {
									$debetCreditDetailHargaPokokPenjualans = array();
									foreach ($detailHargaPokokPenjualan['Level5'] as $dataCOAHargaPokokPenjualan) {
										list($codeDetailHargaPokokPenjualan, $nameDetailHargaPokokPenjualan, $totalDebetCreditDetailHargaPokokPenjualan, $debetDetailHargaPokokPenjualan, $creditDetailHargaPokokPenjualan, $beginningBalanceDetailHargaPokokPenjualanDebit, $beginningBalanceDetailHargaPokokPenjualanCredit, $subTotalDetailHargaPokokPenjualan) = explode('^', $dataCOAHargaPokokPenjualan);
										//$totalHargaPokokPenjualans = $debetCreditDetailHargaPokokPenjualan+$beginningBalanceDetailHargaPokokPenjualan;
										$debetDetailHargaPokokPenjualans[] = $debetDetailHargaPokokPenjualan;
										$creditDetailHargaPokokPenjualans[] = $creditDetailHargaPokokPenjualan;
										$beginningDetailHargaPokokPenjualans[] = $beginningBalanceDetailHargaPokokPenjualan;
										$totalDetailHargaPokokPenjualans[] = $subTotalDetailHargaPokokPenjualan;
										$nominalDebetDetailHargaPokokPenjualan = $this->Krs->cur($debetDetailHargaPokokPenjualan);
										$nominalCreditDetailHargaPokokPenjualan = $this->Krs->cur($creditDetailHargaPokokPenjualan);

										$nominalBeginningDetailHargaPokokPenjualanDebit = $this->Krs->cur($beginningBalanceDetailHargaPokokPenjualanDebit);
										$nominalBeginningDetailHargaPokokPenjualanCredit = $this->Krs->cur($beginningBalanceDetailHargaPokokPenjualanCredit);

										$nominalTotalDetailHargaPokokPenjualan = $this->Krs->cur($subTotalDetailHargaPokokPenjualan);

										echo '<tr>
												<td>'.$codeDetailHargaPokokPenjualan.'</td>
												<td>'.$nameDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalDebetDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalCreditDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalBeginningDetailHargaPokokPenjualanDebit.'</td>
												<td align="right">'.$nominalBeginningDetailHargaPokokPenjualanCredit.'</td>
												<td align="right">'.$nominalTotalDetailHargaPokokPenjualan.'</td>';
										echo '</tr>';
									}
								}
							}
							*/

							/*
						$totalDebetKasBankSums = round(array_sum($debetDetailKasBanks),2);
						$totalCreditKasBankSums = round(array_sum($creditDetailKasBanks),2);
						$totalBeginningKasBankSums = round(array_sum($beginningDetailKasBanks),2);
						$totalGrandKasBankSums = round(array_sum($totalDetailKasBanks),2);

						$totalDebetPiutangSums = round(array_sum($debetDetailPiutangs),2);
						$totalCreditPiutangSums = round(array_sum($creditDetailPiutangs),2);
						$totalBeginningPiutangSums = round(array_sum($beginningDetailPiutangs),2);
						$totalGrandPiutangSums = round(array_sum($totalDetailPiutangs),2);

						$totalDebetAktivaTetapSums = round(array_sum($debetDetailAktivaTetaps),2);
						$totalCreditAktivaTetapSums = round(array_sum($creditDetailAktivaTetaps),2);
						$totalBeginningAktivaTetapSums = round(array_sum($beginningDetailAktivaTetaps),2);
						$totalGrandAktivaTetapSums = round(array_sum($totalDetailAktivaTetaps),2);

						$totalDebetAkumulasiPenyusutanSums = round(array_sum($debetDetailAkumulasiPenyusutans),2);
						$totalCreditAkumulasiPenyusutanSums = round(array_sum($creditDetailAkumulasiPenyusutans),2);
						$totalBeginningAkumulasiPenyusutanSums = round(array_sum($beginningDetailAkumulasiPenyusutans),2);
						$totalGrandAkumulasiPenyusutanSums = round(array_sum($totalDetailAkumulasiPenyusutans),2);

						$totalDebetHutangSums = round(array_sum($debetDetailHutangs),2);
						$totalCreditHutangSums = round(array_sum($creditDetailHutangs),2);
						$totalBeginningHutangSums = round(array_sum($beginningDetailHutangs),2);
						$totalGrandHutangSums = round(array_sum($totalDetailHutangs),2);

						$totalDebetHutangLancarSums = round(array_sum($debetDetailHutangLancars),2);
						$totalCreditHutangLancarSums = round(array_sum($creditDetailHutangLancars),2);
						$totalBeginningHutangLancarSums = round(array_sum($beginningDetailHutangLancars),2);
						$totalGrandHutangLancarSums = round(array_sum($totalDetailHutangLancars),2);

						$totalDebetModalSums = round(array_sum($debetDetailModals),2);
						$totalCreditModalSums = round(array_sum($creditDetailModals),2);
						$totalBeginningModalSums = round(array_sum($beginningDetailModals),2);
						$totalGrandModalSums = round(array_sum($totalDetailModals),2);

						$totalDebetSaldoDitahanSums = round(array_sum($debetDetailSaldoDitahans),2);
						$totalCreditSaldoDitahanSums = round(array_sum($creditDetailSaldoDitahans),2);
						$totalBeginningSaldoDitahanSums = round(array_sum($beginningDetailSaldoDitahans),2);
						$totalGrandSaldoDitahanSums = round(array_sum($totalDetailSaldoDitahans),2);

						$totalDebetPriveSums = round(array_sum($debetDetailPrives),2);
						$totalCreditPriveSums = round(array_sum($creditDetailPrives),2);
						$totalBeginningPriveSums = round(array_sum($beginningDetailPrives),2);
						$totalGrandPriveSums = round(array_sum($totalDetailPrives),2);

						$totalDebetPendapatanShowSums = round(array_sum($debetDetailPendapatanShows),2);
						$totalCreditPendapatanShowSums = round(array_sum($creditDetailPendapatanShows),2);
						$totalBeginningPendapatanShowSums = round(array_sum($beginningDetailPendapatanShows),2);
						$totalGrandPendapatanShowSums = round(array_sum($totalDetailPendapatanShows),2);

						$totalDebetPendapatanLainSums = round(array_sum($debetDetailPendapatanLains),2);
						$totalCreditPendapatanLainSums = round(array_sum($creditDetailPendapatanLains),2);
						$totalBeginningPendapatanLainSums = round(array_sum($beginningDetailPendapatanLains),2);
						$totalGrandPendapatanLainSums = round(array_sum($totalDetailPendapatanLains),2);

						$totalDebetHargaPokokPenjualanSums = round(array_sum($debetDetailHargaPokokPenjualans),2);
						$totalCreditHargaPokokPenjualanSums = round(array_sum($creditDetailHargaPokokPenjualans),2);
						$totalBeginningHargaPokokPenjualanSums = round(array_sum($beginningDetailHargaPokokPenjualans),2);
						$totalGrandHargaPokokPenjualanSums = round(array_sum($totalDetailHargaPokokPenjualans),2);

						$totalDebetBebanLainLainSums = round(array_sum($debetDetailBebanLainLains),2);
						$totalCreditBebanLainLainSums = round(array_sum($creditDetailBebanLainLains),2);
						$totalBeginningBebanLainLainSums = round(array_sum($beginningDetailBebanLainLains),2);
						$totalGrandBebanLainLainSums = round(array_sum($totalDetailBebanLainLains),2);

						$totalDebetBebanSums = round(array_sum($debetDetailBebans),2);
						$totalCreditBebanSums = round(array_sum($creditDetailBebans),2);
						$totalBeginningBebanSums = round(array_sum($beginningDetailBebans),2);
						$totalGrandBebanSums = round(array_sum($totalDetailBebans),2);
						
						$totalDebetBebanPemasaranSums = round(array_sum($debetDetailBebanPemasarans),2);
						$totalCreditBebanPemasaranSums = round(array_sum($creditDetailBebanPemasarans),2);
						$totalBeginningBebanPemasaranSums = round(array_sum($beginningDetailBebanPemasarans),2);
						$totalGrandBebanPemasaranSums = round(array_sum($totalDetailBebanPemasarans),2);
						
						$totalDebetSum = ((int)$totalDebetKasBankSums+(int)$totalDebetPiutangSums+(int)$totalDebetAktivaTetapSums+(int)$totalDebetAkumulasiPenyusutanSums+(int)$totalDebetHutangSums+(int)$totalDebetHutangLancarSums+(int)$totalDebetModalSums+(int)$totalDebetSaldoDitahanSums+(int)$totalDebetPriveSums+(int)$totalDebetPendapatanShowSums+(int)$totalDebetPendapatanLainSums+(int)$totalDebetHargaPokokPenjualanSums+(int)$totalDebetBebanLainLainSums+(int)$totalDebetBebanSums+(int)$totalDebetBebanPemasaranSums);

						$totalCreditSum = ((int)$totalCreditKasBankSums+(int)$totalCreditPiutangSums+(int)$totalCreditAktivaTetapSums+(int)$totalCreditAkumulasiPenyusutanSums+(int)$totalCreditHutangSums+(int)$totalCreditHutangLancarSums+(int)$totalCreditModalSums+(int)$totalCreditSaldoDitahanSums+(int)$totalCreditPriveSums+(int)$totalCreditPendapatanShowSums+(int)$totalCreditPendapatanLainSums+(int)$totalCreditHargaPokokPenjualanSums+(int)$totalCreditBebanLainLainSums+(int)$totalCreditBebanSums+(int)$totalCreditBebanPemasaranSums);

						$totalBeginningSum = ((int)$totalBeginningKasBankSums+(int)$totalBeginningPiutangSums+(int)$totalBeginningAktivaTetapSums+(int)$totalBeginningAkumulasiPenyusutanSums+(int)$totalBeginningHutangSums+(int)$totalBeginningHutangLancarSums+(int)$totalBeginningModalSums+(int)$totalBeginningSaldoDitahanSums+(int)$totalBeginningPriveSums+(int)$totalBeginningPendapatanShowSums+(int)$totalBeginningPendapatanLainSums+(int)$totalBeginningHargaPokokPenjualanSums+(int)$totalBeginningBebanLainLainSums+(int)$totalBeginningBebanSums+(int)$totalBeginningBebanPemasaranSums);

						$totalGrandSum = ((int)$totalGrandKasBankSums+(int)$totalGrandPiutangSums+(int)$totalGrandAktivaTetapSums+(int)$totalGrandAkumulasiPenyusutanSums+(int)$totalGrandHutangSums+(int)$totalGrandHutangLancarSums+(int)$totalGrandModalSums+(int)$totalGrandSaldoDitahanSums+(int)$totalGrandPriveSums+(int)$totalGrandLabaRugiBerjalan+(int)$totalGrandPendapatanShowSums+(int)$totalGrandPendapatanLainSums+(int)$totalGrandHargaPokokPenjualanSums+(int)$totalGrandBebanLainLainSums+(int)$totalGrandBebanSums+(int)$totalGrandBebanPemasaranSums);

						//$totalGrandBalances = $totalBeginningSum+$totalDebetSum-$totalCreditSum-$totalGrandSum;
						$totalGrandBalances = ((int)$totalBeginningSum+(int)$totalDebetSum-(int)$totalCreditSum);
						$totalGrandBalance = $this->Krs->nom($totalGrandBalances);

						$totalDebetNominal = $this->Krs->nom($totalDebetSum);
						$totalCreditNominal = $this->Krs->nom($totalCreditSum);
						$totalBeginningNominal = $this->Krs->nom($totalBeginningSum);
						$totalGrandNominal = $this->Krs->nom($totalGrandSum);
						//$totalGrandBalance = 0;
						echo '<tr>
								<td>&nbsp;</td>
								<td align="right"><b>TOTAL</b></td>
								<td align="right" width="150"><b>'.$totalDebetNominal.'</b></td>
								<td align="right" width="150"><b>'.$totalCreditNominal.'</b></td>
								<td align="right" width="150"><b>'.$totalBeginningNominal.'</b></td>
								<td align="right" width="150"><b>'.$totalGrandNominal.'</b></td>
							</tr>
							<tr>
								<td colspan="2" align="right"><b>BALANCE</b></td>
								<td colspan="4" align="center"><b>'.$totalGrandBalance.'</b></td>
							</tr>';
						*/
						?>