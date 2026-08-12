<?php
$UserId = $this->Session->read("Auth.User.id");
if(is_array(!empty($dataBeginningBalance))){
	$accBeginingBalance = $dataBeginningBalance["AccBeginningBalance"];
	$dates = $accBeginingBalance["dates"];
}
// echo $this->Krs->errorModel($validationError);
$pages = (empty($this->params['named']['page']))?'':'/page:'.$this->params['named']['page'];

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
	echo $this->Form->create("AccJournal", array("url" => array('event_id' => $uuid, "controller"=>"artama_acc_journals", "action" => "report_income_multi"), "class" => "form-horizontal", "inputDefaults" => array("label" => false, "div" => false)));

	?>
	<div class="panel-body bg-warning-transparent-4">
		<div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<div class="panel panel-success">
					<div class="panel-heading">
			            <div class="panel-heading-btn">
			                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
			            </div>
			            <h4 class="panel-title">Cari dataddd...</h4>
			        </div>
			       <div class="panel-body">
			       		<div class="form-group row m-b-15">
							<label class="col-form-label col-md-3">Bulan-Tahun</label>
							<div class="col-md-9">
								<div class="input-group">
									<?php
									echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control form-control-inline input-small date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...'), 'filterDateEnd', array("class"=>"form-control form-control-inline input-small date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tanggal...'), 'ke', 'resetDate');
									?>
									<?php
									/*
									<div class="input-group input-small input-monthYear">
									<?php
									// date-picker
									echo $this->Form->input("filterDate", array("class" => "form-control form-control-inline input-small filterMonthYear", "autocomplete"=>"off", "error" => false, "required"=>false, 'readonly' => true, 'placeholder' => 'Bulan-Tahun...'));
									?>
									<span class="input-group-btn">
										<button class="btn default filterMonthYearReset" type="button"><i class="fa fa-times"></i></button>
									</span>
									</div>
									*/
									?>
								</div>
							</div>
						</div>					
					</div>
					<div class="panel-footer text-right bg-orange">
					    <?php
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
		?>
		
		<div class="alert alert-danger">
			<h4 class="alert-heading">Warning!</h4>
			<p>Maaf data tidak ditemukan, silakan masukan data dengan benar!!.</p>
		</div>
		
		<?php 
			} else {
				//list($dateFrom, $dateTo) = explode("^", $dates);
		?>
		<div class="panel-body">
			<legend class="m-b-15">
				<div class="table-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Unduh"><i class="fa fa-download"></i></button>
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="500" data-close-others="true"></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
							<?php
							echo $this->Html->link('Excel', array('event_id' => $uuid, 'controller' => 'acc_journals', "action"=>"xls_income_multi/".$dataDate, 'full_base' => true), array('escape' => false), 'Apakah anda yakin untuk mengambil data dalam bentuk EXCEL?');
							?>
							</li>
							<li>
							<?php
							echo $this->Html->link('PDF', array('event_id' => $uuid, 'controller' => 'acc_journals', "action"=>"pdf_income_multi/".$dataDate, 'full_base' => true), array('escape' => false), 'Apakah anda yakin untuk mengambil data dalam bentuk EXCEL?');
							?>
							</li>
						</ul>
					</div>
				</div>
			</legend>
			<br>
			
			<div class="portlet-body">
				<div class="table-responsive">
					<div data-scrollbar="true" data-height="500px">
						<div class="portlet-body">
								<div class="table-responsive">
									<?php
									echo '<table width="100%" border="0" cellpadding="6" cellspacing="0" class="table-hover">';
									echo '<tr>
											<td align="center"><b>Keterangan</b></td>';
											for ($i=$monthFrom; $i <= $monthEnd; $i++) {
												$monthIndo = $this->Krs->get_month($i);

											echo '<td align="center"><b>'.$monthIndo.'</b></td>
											<td align="center">%</td>';
											}
										echo '</tr>';

//pr($listCOAPendapatan);
$dataMonth = $monthFrom.'^'.$monthEnd;
$listCOASubTotalPendapatan = $this->Krs->incomeMultiPercentNew($listCOAPendapatan, $dataMonth, 'pendapatan');
$listCOASubTotalReturPendapatan = $this->Krs->incomeMultiPercentNew($listCOAReturPendapatan, $dataMonth, 'retur_pendapatan');
$listCOASubTotalPotonganPendapatan = $this->Krs->incomeMultiPercentNew($listCOAPotonganPenjualan, $dataMonth, 'potongan_pendapatan');
$listCOASubTotalBebanPokokPendapatan = $this->Krs->incomeMultiPercentNew($listCOABebanPokokPendapatan, $dataMonth, 'beban_pokok_pendapatan');
$listCOASubTotalBebanPendapatan = $this->Krs->incomeMultiPercentNew($listCOABebanPendapatan, $dataMonth, 'beban_pendapatan');
$listCOASubTotalBebanAdministrasiUmum = $this->Krs->incomeMultiPercentNew($listCOABebanAdministrasiUmum, $dataMonth, 'beban_administrasi_umum');
$listCOASubTotalPendapatanNonOperasional = $this->Krs->incomeMultiPercentNew($listCOAPendapatanNonOperasional, $dataMonth, 'pendapatan_non_operasional');
$listCOASubTotalBebanNonOperasional = $this->Krs->incomeMultiPercentNew($listCOABebanNonOperasional, $dataMonth, 'beban_non_operasional');

//$subTotalCOA = array_merge_recursive($listCOASubTotalPendapatan, $listCOASubTotalBeban, $listCOASubTotalPendapatanLain, $listCOASubTotalHargaPokokPenjualan, $listCOASubTotalBebanPemasaran, $listCOASubTotalBebanLainLain);
//$subTotalBebanCOA = array_merge_recursive($listCOASubTotalBeban, $listCOASubTotalBebanPemasaran, $listCOASubTotalBebanLainLain);

$subTotalCOA = array();
for ($ttCOA=$monthFrom; $ttCOA <= $monthEnd; $ttCOA++) {
	$monthDataz = str_pad($ttCOA, 2, '0', STR_PAD_LEFT);
	$subTotalCOA[$monthDataz]['pendapatan'] = $listCOASubTotalPendapatan[$monthDataz]['pendapatan'];
	$subTotalCOA[$monthDataz]['retur_pendapatan'] = $listCOASubTotalReturPendapatan[$monthDataz]['retur_pendapatan'];
	$subTotalCOA[$monthDataz]['potongan_pendapatan'] = $listCOASubTotalPotonganPendapatan[$monthDataz]['potongan_pendapatan'];
	$subTotalCOA[$monthDataz]['beban_pokok_pendapatan'] = $listCOASubTotalBebanPokokPendapatan[$monthDataz]['beban_pokok_pendapatan'];
	$subTotalCOA[$monthDataz]['beban_administrasi_umum'] = $listCOASubTotalBebanAdministrasiUmum[$monthDataz]['beban_administrasi_umum'];
	$subTotalCOA[$monthDataz]['pendapatan_non_operasional'] = $listCOASubTotalPendapatanNonOperasional[$monthDataz]['pendapatan_non_operasional'];
	$subTotalCOA[$monthDataz]['beban_non_operasional'] = $listCOASubTotalBebanNonOperasional[$monthDataz]['beban_non_operasional'];
}

$totalPercent = array();
$totalPendapatanPercent = array();
$totalReturPendapatanPercent = array();
$totalPotonganPendapatanPercent = array();
$totalBebanPokokPendapatanPercent = array();
$totalBebanAdministrasiUmumPercent = array();
$totalPendapatanNonOperasionalPercent = array();
$totalBebanNonOperasionalPercent = array();

// $totalBebanPemasaranPercent = array();
// $totalBebanLainLainPercent = array();
for ($ttl=$monthFrom; $ttl <= $monthEnd; $ttl++) {
	$monthData = str_pad($ttl, 2, '0', STR_PAD_LEFT);
	$totalPercent[$monthData] = (isset($subTotalCOA[$monthData])) ? array_sum($subTotalCOA[$monthData]) : 0;
	$totalPendapatanPercent[$monthData] = (isset($listCOASubTotalPendapatan[$monthData])) ? array_sum($listCOASubTotalPendapatan[$monthData]) : 0;
	$totalReturPendapatanPercent[$monthData] = (isset($listCOASubTotalReturPendapatan[$monthData])) ? array_sum($listCOASubTotalReturPendapatan[$monthData]) : 0;

	$totalPotonganPendapatanPercent[$monthData] = (isset($listCOASubTotalPotonganPendapatan[$monthData])) ? array_sum($listCOASubTotalPotonganPendapatan[$monthData]) : 0;
	$totalBebanPokokPendapatanPercent[$monthData] = (isset($listCOASubTotalBebanPokokPendapatan[$monthData])) ? array_sum($listCOASubTotalBebanPokokPendapatan[$monthData]) : 0;
	$totalBebanAdministrasiUmumPercent[$monthData] = (isset($listCOASubTotalBebanAdministrasiUmum[$monthData])) ? array_sum($listCOASubTotalBebanAdministrasiUmum[$monthData]) : 0;
	$totalPendapatanNonOperasionalPercent[$monthData] = (isset($listCOASubTotalPendapatanNonOperasional[$monthData])) ? array_sum($listCOASubTotalPendapatanNonOperasional[$monthData]) : 0;
	$totalBebanNonOperasionalPercent[$monthData] = (isset($listCOASubTotalBebanNonOperasional[$monthData])) ? array_sum($listCOASubTotalBebanNonOperasional[$monthData]) : 0;
	
	// $totalBebanPercent[$monthData] = array_sum($listCOASubTotalBeban[$monthData]);	
	// $totalBebanPemasaranPercent[$monthData] = array_sum($listCOASubTotalBebanPemasaran[$monthData]);
	// $totalBebanLainLainPercent[$monthData] = array_sum($listCOASubTotalBebanLainLain[$monthData]);
}

// $subTotalBebanCOA = array();
// for ($ttBeban=$monthFrom; $ttBeban <= $monthEnd; $ttBeban++) {
// 	$monthDataz = str_pad($ttBeban, 2, '0', STR_PAD_LEFT);
// 	$subTotalBebanCOA[$monthDataz]['beban'] = $listCOASubTotalBeban[$monthDataz]['beban'];
// 	$subTotalBebanCOA[$monthDataz]['beban_pemasaran'] = $listCOASubTotalBebanPemasaran[$monthDataz]['beban_pemasaran'];
// 	$subTotalBebanCOA[$monthDataz]['beban_lain_lain'] = $listCOASubTotalBebanLainLain[$monthDataz]['beban_lain_lain'];
// }

// pr($listCOASubTotalBeban);
// pr($listCOASubTotalBebanPemasaran);
// pr($listCOASubTotalBebanLainLain);
//pr($subTotalBebanCOA);



//pr($totalBebanPercent);

//pr($totalPercent);
//pr($totalPendapatanPercent);

/*for ($i=$monthFrom; $i <= $monthEnd; $i++) {
	$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);
pr(array_sum($dataBebanLainLainCOALevel5Value[$monthData]));
}*/
//pr($dataBebanLainLainCOALevel5Values);

// Pendapatan
$grandTotalPendapatans = array();
foreach ($listCOAPendapatan as $idPendapatanLevel4 => $detailPendapatan) {
 	// Keterangan pada Kas serta Bank
	/*if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatan).'</b></td>
			</tr>';
		}
	}*/

	if(isset($detailPendapatan['Level5Name']) && $detailPendapatan['Level5Name']) {
		$level5NamePendapatan = array_unique($detailPendapatan['Level5Name']);
		//pr($detailPendapatan['Level5']);

		//pr(array_unique($detailPendapatan['Level5Name']));

		$a = 0;
		$debetCreditPendapatans = array();
		$percentPendapatans = array();
		foreach ($level5NamePendapatan as $dataLevelCOAPendapatan) {
			//pr($dataLevelCOAPendapatan);
			if(isset($dataLevelCOAPendapatan)) {
				list($idDetailPendapatan, $codeDetailPendapatan, $nameDetailPendapatan) = explode('^', $dataLevelCOAPendapatan);
				// echo '<tr>
				// 		<td>('.$codeDetailPendapatan.') '.$nameDetailPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							//pr($detailPendapatan['Level5'][$monthData][$idDetailPendapatan]);

							if(isset($detailPendapatan['Level5'][$monthData][$idDetailPendapatan])) {
								$dataCOALevel5Values = $detailPendapatan['Level5'][$monthData][$idDetailPendapatan];
								list($codePendapatan, $debetCreditPendapatan, $beginningBalancePendapatan, $totalPendapatan) = explode('^', $dataCOALevel5Values);
								
								$percenTotalPendapatan = $debetCreditPendapatan/$totalPendapatanPercent[$monthData]*100;
								//$percenTotalPendapatan = $debetCreditPendapatan/$totalPercent[$monthData]*100;

								$debetCreditPendapatans[$monthData][] = $debetCreditPendapatan;
								$percentPendapatans[$monthData][] = $percenTotalPendapatan;
								$percenPendapatan = $this->Krs->_percent($percenTotalPendapatan).'%';
								$dataCOALevel5Value = $this->Krs->cur($debetCreditPendapatan);
							} else {
								$debetCreditPendapatans[99] = 0;
								$dataCOALevel5Value = 0;
								$percenPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						// echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						// echo '<td align="right">'.$percenPendapatan.'</td>';
						}
				// echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
			//pr($debetCreditPendapatans['02']);

		echo '<tr>
				<td>('.$codePendapatan.') '.strtoupper($namePendapatan).'</b></td>';
				for ($pendapatan=$monthFrom; $pendapatan <= $monthEnd; $pendapatan++) {
					$monthPendapatan = str_pad($pendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4Pendapatan = isset($debetCreditPendapatans[$monthPendapatan]) ? array_sum($debetCreditPendapatans[$monthPendapatan]) : 0;
					$totalPercentLevel4Pendapatan = isset($percentPendapatans[$monthPendapatan]) ? array_sum($percentPendapatans[$monthPendapatan]) : 0;
					//pr($totalLevel4Pendapatan);
					// $totalLevel4Pendapatan = (isset($monthPendapatan) && $monthPendapatan!='99') ? array_sum($debetCreditPendapatans[$monthPendapatan]) : array();
					$nominalTotalLevel4Pendapatan = $this->Krs->cur($totalLevel4Pendapatan);
					$nominalTotalpercenPendapatan = $this->Krs->_percent($totalPercentLevel4Pendapatan).'%';
					$grandTotalPendapatans[$monthPendapatan][] = $totalLevel4Pendapatan;
					
					echo '<td align="right">'.$nominalTotalLevel4Pendapatan.'</td>
					<td align="right">'.$nominalTotalpercenPendapatan.'</td>';
				}
			echo '</tr>';
		}
	}
}

// Retur Pendapatan
$grandTotalReturPendapatans = array();
foreach ($listCOAReturPendapatan as $idReturPendapatanLevel4 => $detailReturPendapatan) {
 	if(isset($detailReturPendapatan['Level5Name']) && $detailReturPendapatan['Level5Name']) {
		$level5NameReturPendapatan = array_unique($detailReturPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditReturPendapatans = array();
		$percentReturPendapatans = array();
		foreach ($level5NameReturPendapatan as $dataLevelCOAReturPendapatan) {
			//pr($dataLevelCOAReturPendapatan);
			if(isset($dataLevelCOAReturPendapatan)) {
				list($idDetailReturPendapatan, $codeDetailReturPendapatan, $nameDetailReturPendapatan) = explode('^', $dataLevelCOAReturPendapatan);
				for ($i=$monthFrom; $i <= $monthEnd; $i++) {
					$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

					//pr($detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan]);

					if(isset($detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan])) {
						$dataCOALevel5Values = $detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan];
						list($codeReturPendapatan, $debetCreditReturPendapatan, $beginningBalanceReturPendapatan, $totalReturPendapatan) = explode('^', $dataCOALevel5Values);
						
						$percenTotalReturPendapatan = $debetCreditReturPendapatan/$totalReturPendapatanPercent[$monthData]*100;

						$debetCreditReturPendapatans[$monthData][] = $debetCreditReturPendapatan;
						$percentReturPendapatans[$monthData][] = $percenTotalReturPendapatan;
						$percenReturPendapatan = $this->Krs->_percent($percenTotalReturPendapatan).'%';
						$dataCOALevel5Value = $this->Krs->cur($debetCreditReturPendapatan);
					} else {
						$debetCreditReturPendapatans[99] = 0;
						$dataCOALevel5Value = 0;
						$percenReturPendapatan = '0%';
					}
				}
			$a++;
			}
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
		
		echo '<tr>
				<td>('.$codeReturPendapatan.') '.strtoupper($nameReturPendapatan).'</b></td>';
				for ($ReturPendapatan=$monthFrom; $ReturPendapatan <= $monthEnd; $ReturPendapatan++) {
					$monthReturPendapatan = str_pad($ReturPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4ReturPendapatan = isset($debetCreditReturPendapatans[$monthReturPendapatan]) ? array_sum($debetCreditReturPendapatans[$monthReturPendapatan]) : 0;
					$totalPercentLevel4ReturPendapatan = isset($percentReturPendapatans[$monthReturPendapatan]) ? array_sum($percentReturPendapatans[$monthReturPendapatan]) : 0;
					$nominalTotalLevel4ReturPendapatan = $this->Krs->cur($totalLevel4ReturPendapatan);
					$nominalTotalpercenReturPendapatan = $this->Krs->_percent($totalPercentLevel4ReturPendapatan).'%';
					$grandTotalReturPendapatans[$monthReturPendapatan][] = $totalLevel4ReturPendapatan;
					
					echo '<td align="right">'.$nominalTotalLevel4ReturPendapatan.'</td>
					<td align="right">'.$nominalTotalpercenReturPendapatan.'</td>';
				}
			echo '</tr>';
		}
	}
}


// Potongan Pendapatan
$grandTotalPotonganPendapatans = array();
foreach ($listCOAPotonganPendapatan as $idPotonganPendapatanLevel4 => $detailPotonganPendapatan) {
 	if(isset($detailPotonganPendapatan['Level5Name']) && $detailPotonganPendapatan['Level5Name']) {
		$level5NamePotonganPendapatan = array_unique($detailPotonganPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditPotonganPendapatans = array();
		$percentPotonganPendapatans = array();
		foreach ($level5NamePotonganPendapatan as $dataLevelCOAPotonganPendapatan) {
			//pr($dataLevelCOAPotonganPendapatan);
			if(isset($dataLevelCOAPotonganPendapatan)) {
				list($idDetailPotonganPendapatan, $codeDetailPotonganPendapatan, $nameDetailPotonganPendapatan) = explode('^', $dataLevelCOAPotonganPendapatan);
				for ($i=$monthFrom; $i <= $monthEnd; $i++) {
					$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

					//pr($detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan]);

					if(isset($detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan])) {
						$dataCOALevel5Values = $detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan];
						list($codePotonganPendapatan, $debetCreditPotonganPendapatan, $beginningBalancePotonganPendapatan, $totalPotonganPendapatan) = explode('^', $dataCOALevel5Values);
						
						$percenTotalPotonganPendapatan = $debetCreditPotonganPendapatan/$totalPotonganPendapatanPercent[$monthData]*100;

						$debetCreditPotonganPendapatans[$monthData][] = $debetCreditPotonganPendapatan;
						$percentPotonganPendapatans[$monthData][] = $percenTotalPotonganPendapatan;
						$percenPotonganPendapatan = $this->Krs->_percent($percenTotalPotonganPendapatan).'%';
						$dataCOALevel5Value = $this->Krs->cur($debetCreditPotonganPendapatan);
					} else {
						$debetCreditPotonganPendapatans[99] = 0;
						$dataCOALevel5Value = 0;
						$percenPotonganPendapatan = '0%';
					}
				}
			$a++;
			}
		}
	}

	if(isset($detailPotonganPendapatan['Level5']) && $detailPotonganPendapatan['Level4']) {
		list($codePotonganPendapatan, $namePotonganPendapatan) = explode('^', $detailPotonganPendapatan['Level4']);

		if(!empty($codePotonganPendapatan)) {
		
		echo '<tr>
				<td>('.$codePotonganPendapatan.') '.strtoupper($namePotonganPendapatan).'</b></td>';
				for ($PotonganPendapatan=$monthFrom; $PotonganPendapatan <= $monthEnd; $PotonganPendapatan++) {
					$monthPotonganPendapatan = str_pad($PotonganPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4PotonganPendapatan = isset($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) ? array_sum($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) : 0;
					$totalPercentLevel4PotonganPendapatan = isset($percentPotonganPendapatans[$monthPotonganPendapatan]) ? array_sum($percentPotonganPendapatans[$monthPotonganPendapatan]) : 0;
					$nominalTotalLevel4PotonganPendapatan = $this->Krs->cur($totalLevel4PotonganPendapatan);
					$nominalTotalpercenPotonganPendapatan = $this->Krs->_percent($totalPercentLevel4PotonganPendapatan).'%';
					$grandTotalPotonganPendapatans[$monthPotonganPendapatan][] = $totalLevel4PotonganPendapatan;
					
					echo '<td align="right">'.$nominalTotalLevel4PotonganPendapatan.'</td>
					<td align="right">'.$nominalTotalpercenPotonganPendapatan.'</td>';
				}
			echo '</tr>';
		}
	}
}

echo '<tr>
	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL PENDAPATAN BERSIH/b></td>';
	for ($totalPendapatanBersih=$monthFrom; $totalPendapatanBersih <= $monthEnd; $totalPendapatanBersih++) {
		$monthTotalPendapatanBersih = str_pad($totalPendapatanBersih, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalPendapatan = isset($grandTotalPendapatans[$monthTotalPendapatanBersih]) ? array_sum($grandTotalPendapatans[$monthTotalPendapatanBersih]) : 0;
		$dataGrandTotalReturPendapatan = isset($grandTotalReturPendapatans[$monthTotalPendapatanBersih]) ? array_sum($grandTotalReturPendapatans[$monthTotalPendapatanBersih]) : 0;
		$dataGrandTotalPotonganPendapatan = isset($grandTotalPotonganPendapatans[$monthTotalPendapatanBersih]) ? array_sum($grandTotalPotonganPendapatans[$monthTotalPendapatanBersih]) : 0;
		//$totalPercentLevel4Pendapatan = isset($percentPendapatans[$monthTotalPendapatanBersih]) ? array_sum($percentPendapatans[$monthTotalPendapatanBersih]) : 0;
		//$dataGrandTotalPendapatanLain = isset($grandTotalPendapatanLains[$monthTotalPendapatanBersih]) ? array_sum($grandTotalPendapatanLains[$monthTotalPendapatanBersih]) : 0;

		$grandTotalPendapatanBersih = $dataGrandTotalPendapatan-($dataGrandTotalReturPendapatan+$dataGrandTotalPotonganPendapatan);

		$nominalGrandTotalPendapatanBersih = $this->Krs->cur($grandTotalPendapatanBersih);
		$grandTotalPendapatanBersihData[$monthTotalPendapatanBersih] = $grandTotalPendapatanBersih;
		
		echo '<td align="right"><b>'.$nominalGrandTotalPendapatanBersih.'</b></td>
		<td align="right">100%</td>';
	}
echo '</tr>';

// Beban Pokok Pendapatan
$grandTotalBebanPokokPendapatans = array();
foreach ($listCOABebanPokokPendapatan as $idBebanPokokPendapatanLevel4 => $detailBebanPokokPendapatan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBebanPokokPendapatan['Level5']) && $detailBebanPokokPendapatan['Level4']) {
		list($codeBebanPokokPendapatan, $nameBebanPokokPendapatan) = explode('^', $detailBebanPokokPendapatan['Level4']);

		if(!empty($codeBebanPokokPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanPokokPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanPokokPendapatan['Level5Name']) && $detailBebanPokokPendapatan['Level5Name']) {
		$level5NameBebanPokokPendapatan = array_unique($detailBebanPokokPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditBebanPokokPendapatans = array();
		$percentBebanPokokPendapatans = array();
		foreach ($level5NameBebanPokokPendapatan as $dataLevelCOABebanPokokPendapatan) {
			//pr($dataLevelCOABebanPokokPendapatan);
			if(isset($dataLevelCOABebanPokokPendapatan)) {
				list($idDetailBebanPokokPendapatan, $codeDetailBebanPokokPendapatan, $nameDetailBebanPokokPendapatan) = explode('^', $dataLevelCOABebanPokokPendapatan);
				echo '<tr>
						<td>('.$codeDetailBebanPokokPendapatan.') '.$nameDetailBebanPokokPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBebanPokokPendapatan['Level5'][$monthData][$idDetailBebanPokokPendapatan]))) {
								$dataCOALevel5Values = $detailBebanPokokPendapatan['Level5'][$monthData][$idDetailBebanPokokPendapatan];
								list($codeBebanPokokPendapatan, $debetCreditBebanPokokPendapatan, $beginningBalanceBebanPokokPendapatan, $totalBebanPokokPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalBebanPokokPendapatan = $debetCreditBebanPokokPendapatan/$totalBebanPokokPendapatanPercent[$monthData]*100;

								$debetCreditBebanPokokPendapatans[$monthData][] = $debetCreditBebanPokokPendapatan;
								$percentBebanPokokPendapatans[$monthData][] = $percenTotalBebanPokokPendapatan;

								$percenBebanPokokPendapatan = $this->Krs->_percent($percenTotalBebanPokokPendapatan).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditBebanPokokPendapatan);
							} else {
								$dataCOALevel5Value = 0;
								$percenBebanPokokPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenBebanPokokPendapatan.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBebanPokokPendapatan['Level5']) && $detailBebanPokokPendapatan['Level4']) {
		list($codeBebanPokokPendapatan, $nameBebanPokokPendapatan) = explode('^', $detailBebanPokokPendapatan['Level4']);

		if(!empty($codeBebanPokokPendapatan)) {
			//pr($debetCreditBebanPokokPendapatans['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanPokokPendapatan).'</b></td>';
				for ($BebanPokokPendapatan=$monthFrom; $BebanPokokPendapatan <= $monthEnd; $BebanPokokPendapatan++) {
					$monthBebanPokokPendapatan = str_pad($BebanPokokPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4BebanPokokPendapatan = isset($debetCreditBebanPokokPendapatans[$monthBebanPokokPendapatan]) ? array_sum($debetCreditBebanPokokPendapatans[$monthBebanPokokPendapatan]) : 0;
					$totalPercentLevel4BebanPokokPendapatan = isset($percentBebanPokokPendapatans[$monthBebanPokokPendapatan]) ? array_sum($percentBebanPokokPendapatans[$monthBebanPokokPendapatan]) : 0;
					//pr($totalLevel4BebanPokokPendapatan);
					// $totalLevel4BebanPokokPendapatan = (isset($monthBebanPokokPendapatan) && $monthBebanPokokPendapatan!='99') ? array_sum($debetCreditBebanPokokPendapatans[$monthBebanPokokPendapatan]) : array();
					$nominalTotalLevel4BebanPokokPendapatan = $this->Krs->cur($totalLevel4BebanPokokPendapatan);
					$nominalTotalpercenBebanPokokPendapatan = $this->Krs->_percent($totalPercentLevel4BebanPokokPendapatan).'%';
					$grandTotalBebanPokokPendapatans[$monthBebanPokokPendapatan][] = $totalLevel4BebanPokokPendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4BebanPokokPendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenBebanPokokPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}


//LABA KOTOR
echo '<tr>
	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA KOTOR</b></td>';
	for ($totalLabaKotor=$monthFrom; $totalLabaKotor <= $monthEnd; $totalLabaKotor++) {
		$monthTotalLabaKotor = str_pad($totalLabaKotor, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalPendapatanBersih = isset($grandTotalPendapatanBersihData[$monthTotalLabaKotor]) ? array_sum($grandTotalPendapatanBersihData[$monthTotalLabaKotor]) : 0;
		$dataGrandTotalBebanPokokPendapatan = isset($grandTotalBebanPokokPendapatans[$monthTotalLabaKotor]) ? array_sum($grandTotalBebanPokokPendapatans[$monthTotalLabaKotor]) : 0;

		$grandTotalLabaKotor = $dataGrandTotalPendapatanBersih-$dataGrandTotalBebanPokokPendapatan;

		$nominalGrandTotalLabaKotor = $this->Krs->cur($grandTotalLabaKotor);
		$grandTotalLabaKotorData[$monthTotalLabaKotor] = $grandTotalLabaKotor;
		
		echo '<td align="right"><b>'.$nominalGrandTotalLabaKotor.'</b></td>
		<td align="right">&nbsp;</td>';
	}
echo '</tr>';


// Beban Pendapatan
$grandTotalBebanPendapatans = array();
foreach ($listCOABebanPendapatan as $idBebanPendapatanLevel4 => $detailBebanPendapatan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBebanPendapatan['Level5']) && $detailBebanPendapatan['Level4']) {
		list($codeBebanPendapatan, $nameBebanPendapatan) = explode('^', $detailBebanPendapatan['Level4']);

		if(!empty($codeBebanPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanPendapatan['Level5Name']) && $detailBebanPendapatan['Level5Name']) {
		$level5NameBebanPendapatan = array_unique($detailBebanPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditBebanPendapatans = array();
		$percentBebanPendapatans = array();
		foreach ($level5NameBebanPendapatan as $dataLevelCOABebanPendapatan) {
			//pr($dataLevelCOABebanPendapatan);
			if(isset($dataLevelCOABebanPendapatan)) {
				list($idDetailBebanPendapatan, $codeDetailBebanPendapatan, $nameDetailBebanPendapatan) = explode('^', $dataLevelCOABebanPendapatan);
				echo '<tr>
						<td>('.$codeDetailBebanPendapatan.') '.$nameDetailBebanPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBebanPendapatan['Level5'][$monthData][$idDetailBebanPendapatan]))) {
								$dataCOALevel5Values = $detailBebanPendapatan['Level5'][$monthData][$idDetailBebanPendapatan];
								list($codeBebanPendapatan, $debetCreditBebanPendapatan, $beginningBalanceBebanPendapatan, $totalBebanPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalBebanPendapatan = $debetCreditBebanPendapatan/$totalBebanPendapatanPercent[$monthData]*100;

								$debetCreditBebanPendapatans[$monthData][] = $debetCreditBebanPendapatan;
								$percentBebanPendapatans[$monthData][] = $percenTotalBebanPendapatan;

								$percenBebanPendapatan = $this->Krs->_percent($percenTotalBebanPendapatan).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditBebanPendapatan);
							} else {
								$dataCOALevel5Value = 0;
								$percenBebanPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenBebanPendapatan.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBebanPendapatan['Level5']) && $detailBebanPendapatan['Level4']) {
		list($codeBebanPendapatan, $nameBebanPendapatan) = explode('^', $detailBebanPendapatan['Level4']);

		if(!empty($codeBebanPendapatan)) {
			//pr($debetCreditBebanPendapatans['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanPendapatan).'</b></td>';
				for ($BebanPendapatan=$monthFrom; $BebanPendapatan <= $monthEnd; $BebanPendapatan++) {
					$monthBebanPendapatan = str_pad($BebanPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4BebanPendapatan = isset($debetCreditBebanPendapatans[$monthBebanPendapatan]) ? array_sum($debetCreditBebanPendapatans[$monthBebanPendapatan]) : 0;
					$totalPercentLevel4BebanPendapatan = isset($percentBebanPendapatans[$monthBebanPendapatan]) ? array_sum($percentBebanPendapatans[$monthBebanPendapatan]) : 0;
					//pr($totalLevel4BebanPendapatan);
					// $totalLevel4BebanPendapatan = (isset($monthBebanPendapatan) && $monthBebanPendapatan!='99') ? array_sum($debetCreditBebanPendapatans[$monthBebanPendapatan]) : array();
					$nominalTotalLevel4BebanPendapatan = $this->Krs->cur($totalLevel4BebanPendapatan);
					$nominalTotalpercenBebanPendapatan = $this->Krs->_percent($totalPercentLevel4BebanPendapatan).'%';
					$grandTotalBebanPendapatans[$monthBebanPendapatan][] = $totalLevel4BebanPendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4BebanPendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenBebanPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}


// Beban Administrasi Umum
$grandTotalBebanAdministrasiUmums = array();
foreach ($listCOABebanAdministrasiUmum as $idBebanAdministrasiUmumLevel4 => $detailBebanAdministrasiUmum) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBebanAdministrasiUmum['Level5']) && $detailBebanAdministrasiUmum['Level4']) {
		list($codeBebanAdministrasiUmum, $nameBebanAdministrasiUmum) = explode('^', $detailBebanAdministrasiUmum['Level4']);

		if(!empty($codeBebanAdministrasiUmum)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanAdministrasiUmum).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanAdministrasiUmum['Level5Name']) && $detailBebanAdministrasiUmum['Level5Name']) {
		$level5NameBebanAdministrasiUmum = array_unique($detailBebanAdministrasiUmum['Level5Name']);
		
		$a = 0;
		$debetCreditBebanAdministrasiUmums = array();
		$percentBebanAdministrasiUmums = array();
		foreach ($level5NameBebanAdministrasiUmum as $dataLevelCOABebanAdministrasiUmum) {
			//pr($dataLevelCOABebanAdministrasiUmum);
			if(isset($dataLevelCOABebanAdministrasiUmum)) {
				list($idDetailBebanAdministrasiUmum, $codeDetailBebanAdministrasiUmum, $nameDetailBebanAdministrasiUmum) = explode('^', $dataLevelCOABebanAdministrasiUmum);
				echo '<tr>
						<td>('.$codeDetailBebanAdministrasiUmum.') '.$nameDetailBebanAdministrasiUmum.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBebanAdministrasiUmum['Level5'][$monthData][$idDetailBebanAdministrasiUmum]))) {
								$dataCOALevel5Values = $detailBebanAdministrasiUmum['Level5'][$monthData][$idDetailBebanAdministrasiUmum];
								list($codeBebanAdministrasiUmum, $debetCreditBebanAdministrasiUmum, $beginningBalanceBebanAdministrasiUmum, $totalBebanAdministrasiUmum) = explode('^', $dataCOALevel5Values);
								$percenTotalBebanAdministrasiUmum = $debetCreditBebanAdministrasiUmum/$totalBebanAdministrasiUmumPercent[$monthData]*100;

								$debetCreditBebanAdministrasiUmums[$monthData][] = $debetCreditBebanAdministrasiUmum;
								$percentBebanAdministrasiUmums[$monthData][] = $percenTotalBebanAdministrasiUmum;

								$percenBebanAdministrasiUmum = $this->Krs->_percent($percenTotalBebanAdministrasiUmum).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditBebanAdministrasiUmum);
							} else {
								$dataCOALevel5Value = 0;
								$percenBebanAdministrasiUmum = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenBebanAdministrasiUmum.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBebanAdministrasiUmum['Level5']) && $detailBebanAdministrasiUmum['Level4']) {
		list($codeBebanAdministrasiUmum, $nameBebanAdministrasiUmum) = explode('^', $detailBebanAdministrasiUmum['Level4']);

		if(!empty($codeBebanAdministrasiUmum)) {
			//pr($debetCreditBebanAdministrasiUmums['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanAdministrasiUmum).'</b></td>';
				for ($BebanAdministrasiUmum=$monthFrom; $BebanAdministrasiUmum <= $monthEnd; $BebanAdministrasiUmum++) {
					$monthBebanAdministrasiUmum = str_pad($BebanAdministrasiUmum, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4BebanAdministrasiUmum = isset($debetCreditBebanAdministrasiUmums[$monthBebanAdministrasiUmum]) ? array_sum($debetCreditBebanAdministrasiUmums[$monthBebanAdministrasiUmum]) : 0;
					$totalPercentLevel4BebanAdministrasiUmum = isset($percentBebanAdministrasiUmums[$monthBebanAdministrasiUmum]) ? array_sum($percentBebanAdministrasiUmums[$monthBebanAdministrasiUmum]) : 0;
					//pr($totalLevel4BebanAdministrasiUmum);
					// $totalLevel4BebanAdministrasiUmum = (isset($monthBebanAdministrasiUmum) && $monthBebanAdministrasiUmum!='99') ? array_sum($debetCreditBebanAdministrasiUmums[$monthBebanAdministrasiUmum]) : array();
					$nominalTotalLevel4BebanAdministrasiUmum = $this->Krs->cur($totalLevel4BebanAdministrasiUmum);
					$nominalTotalpercenBebanAdministrasiUmum = $this->Krs->_percent($totalPercentLevel4BebanAdministrasiUmum).'%';
					$grandTotalBebanAdministrasiUmums[$monthBebanAdministrasiUmum][] = $totalLevel4BebanAdministrasiUmum;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4BebanAdministrasiUmum.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenBebanAdministrasiUmum.'</b></td>';
				}
			echo '</tr>';
		}
	}
}

// LABA OPERASIONAL
echo '<tr>
	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL LABA OPERASIONALfff</b></td>';
	for ($totalLabaOperasional=$monthFrom; $totalLabaOperasional <= $monthEnd; $totalLabaOperasional++) {
		$monthTotalLabaOperasional = str_pad($totalLabaOperasional, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalBebanPendapatan = isset($grandTotalBebanPendapatans[$monthTotalLabaOperasional]) ? array_sum($grandTotalBebanPendapatans[$monthTotalLabaOperasional]) : 0;
		$dataGrandTotalBebanAdministrasiUmum = isset($grandTotalBebanAdministrasiUmums[$monthTotalLabaOperasional]) ? array_sum($grandTotalBebanAdministrasiUmums[$monthTotalLabaOperasional]) : 0;
		
		$grandTotalLabaOperasional = $grandTotalLabaKotorData-($dataGrandTotalBebanPendapatan+$dataGrandTotalBebanAdministrasiUmum);

		$nominalGrandTotalLabaOperasional = $this->Krs->cur($grandTotalLabaOperasional);
		$grandTotalLabaOperasionalData[$monthTotalLabaOperasional] = $grandTotalLabaOperasional;
		
		echo '<td align="right"><b>'.$nominalGrandTotalLabaOperasional.'</b></td>
		<td align="right">&nbsp;</td>';
	}
echo '</tr>';


// Pendapatan Non Operasional
$grandTotalPendapatanNonOperasionals = array();
foreach ($listCOAPendapatanNonOperasional as $idPendapatanNonOperasionalLevel4 => $detailPendapatanNonOperasional) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPendapatanNonOperasional['Level5']) && $detailPendapatanNonOperasional['Level4']) {
		list($codePendapatanNonOperasional, $namePendapatanNonOperasional) = explode('^', $detailPendapatanNonOperasional['Level4']);

		if(!empty($codePendapatanNonOperasional)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatanNonOperasional).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPendapatanNonOperasional['Level5Name']) && $detailPendapatanNonOperasional['Level5Name']) {
		$level5NamePendapatanNonOperasional = array_unique($detailPendapatanNonOperasional['Level5Name']);
		
		$a = 0;
		$debetCreditPendapatanNonOperasionals = array();
		$percentPendapatanNonOperasionals = array();
		foreach ($level5NamePendapatanNonOperasional as $dataLevelCOAPendapatanNonOperasional) {
			//pr($dataLevelCOAPendapatanNonOperasional);
			if(isset($dataLevelCOAPendapatanNonOperasional)) {
				list($idDetailPendapatanNonOperasional, $codeDetailPendapatanNonOperasional, $nameDetailPendapatanNonOperasional) = explode('^', $dataLevelCOAPendapatanNonOperasional);
				echo '<tr>
						<td>('.$codeDetailPendapatanNonOperasional.') '.$nameDetailPendapatanNonOperasional.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailPendapatanNonOperasional['Level5'][$monthData][$idDetailPendapatanNonOperasional]))) {
								$dataCOALevel5Values = $detailPendapatanNonOperasional['Level5'][$monthData][$idDetailPendapatanNonOperasional];
								list($codePendapatanNonOperasional, $debetCreditPendapatanNonOperasional, $beginningBalancePendapatanNonOperasional, $totalPendapatanNonOperasional) = explode('^', $dataCOALevel5Values);
								$percenTotalPendapatanNonOperasional = $debetCreditPendapatanNonOperasional/$totalPendapatanNonOperasionalPercent[$monthData]*100;

								$debetCreditPendapatanNonOperasionals[$monthData][] = $debetCreditPendapatanNonOperasional;
								$percentPendapatanNonOperasionals[$monthData][] = $percenTotalPendapatanNonOperasional;

								$percenPendapatanNonOperasional = $this->Krs->_percent($percenTotalPendapatanNonOperasional).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditPendapatanNonOperasional);
							} else {
								$dataCOALevel5Value = 0;
								$percenPendapatanNonOperasional = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenPendapatanNonOperasional.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPendapatanNonOperasional['Level5']) && $detailPendapatanNonOperasional['Level4']) {
		list($codePendapatanNonOperasional, $namePendapatanNonOperasional) = explode('^', $detailPendapatanNonOperasional['Level4']);

		if(!empty($codePendapatanNonOperasional)) {
			//pr($debetCreditPendapatanNonOperasionals['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePendapatanNonOperasional).'</b></td>';
				for ($PendapatanNonOperasional=$monthFrom; $PendapatanNonOperasional <= $monthEnd; $PendapatanNonOperasional++) {
					$monthPendapatanNonOperasional = str_pad($PendapatanNonOperasional, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4PendapatanNonOperasional = isset($debetCreditPendapatanNonOperasionals[$monthPendapatanNonOperasional]) ? array_sum($debetCreditPendapatanNonOperasionals[$monthPendapatanNonOperasional]) : 0;
					$totalPercentLevel4PendapatanNonOperasional = isset($percentPendapatanNonOperasionals[$monthPendapatanNonOperasional]) ? array_sum($percentPendapatanNonOperasionals[$monthPendapatanNonOperasional]) : 0;
					//pr($totalLevel4PendapatanNonOperasional);
					// $totalLevel4PendapatanNonOperasional = (isset($monthPendapatanNonOperasional) && $monthPendapatanNonOperasional!='99') ? array_sum($debetCreditPendapatanNonOperasionals[$monthPendapatanNonOperasional]) : array();
					$nominalTotalLevel4PendapatanNonOperasional = $this->Krs->cur($totalLevel4PendapatanNonOperasional);
					$nominalTotalpercenPendapatanNonOperasional = $this->Krs->_percent($totalPercentLevel4PendapatanNonOperasional).'%';
					$grandTotalPendapatanNonOperasionals[$monthPendapatanNonOperasional][] = $totalLevel4PendapatanNonOperasional;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4PendapatanNonOperasional.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenPendapatanNonOperasional.'</b></td>';
				}
			echo '</tr>';
		}
	}
}


// Beban Non Operasional
$grandTotalBebanNonOperasionals = array();
foreach ($listCOABebanNonOperasional as $idBebanNonOperasionalLevel4 => $detailBebanNonOperasional) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBebanNonOperasional['Level5']) && $detailBebanNonOperasional['Level4']) {
		list($codeBebanNonOperasional, $nameBebanNonOperasional) = explode('^', $detailBebanNonOperasional['Level4']);

		if(!empty($codeBebanNonOperasional)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanNonOperasional).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanNonOperasional['Level5Name']) && $detailBebanNonOperasional['Level5Name']) {
		$level5NameBebanNonOperasional = array_unique($detailBebanNonOperasional['Level5Name']);
		
		$a = 0;
		$debetCreditBebanNonOperasionals = array();
		$percentBebanNonOperasionals = array();
		foreach ($level5NameBebanNonOperasional as $dataLevelCOABebanNonOperasional) {
			//pr($dataLevelCOABebanNonOperasional);
			if(isset($dataLevelCOABebanNonOperasional)) {
				list($idDetailBebanNonOperasional, $codeDetailBebanNonOperasional, $nameDetailBebanNonOperasional) = explode('^', $dataLevelCOABebanNonOperasional);
				echo '<tr>
						<td>('.$codeDetailBebanNonOperasional.') '.$nameDetailBebanNonOperasional.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBebanNonOperasional['Level5'][$monthData][$idDetailBebanNonOperasional]))) {
								$dataCOALevel5Values = $detailBebanNonOperasional['Level5'][$monthData][$idDetailBebanNonOperasional];
								list($codeBebanNonOperasional, $debetCreditBebanNonOperasional, $beginningBalanceBebanNonOperasional, $totalBebanNonOperasional) = explode('^', $dataCOALevel5Values);
								$percenTotalBebanNonOperasional = $debetCreditBebanNonOperasional/$totalBebanNonOperasionalPercent[$monthData]*100;

								$debetCreditBebanNonOperasionals[$monthData][] = $debetCreditBebanNonOperasional;
								$percentBebanNonOperasionals[$monthData][] = $percenTotalBebanNonOperasional;

								$percenBebanNonOperasional = $this->Krs->_percent($percenTotalBebanNonOperasional).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditBebanNonOperasional);
							} else {
								$dataCOALevel5Value = 0;
								$percenBebanNonOperasional = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenBebanNonOperasional.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBebanNonOperasional['Level5']) && $detailBebanNonOperasional['Level4']) {
		list($codeBebanNonOperasional, $nameBebanNonOperasional) = explode('^', $detailBebanNonOperasional['Level4']);

		if(!empty($codeBebanNonOperasional)) {
			//pr($debetCreditBebanNonOperasionals['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanNonOperasional).'</b></td>';
				for ($BebanNonOperasional=$monthFrom; $BebanNonOperasional <= $monthEnd; $BebanNonOperasional++) {
					$monthBebanNonOperasional = str_pad($BebanNonOperasional, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4BebanNonOperasional = isset($debetCreditBebanNonOperasionals[$monthBebanNonOperasional]) ? array_sum($debetCreditBebanNonOperasionals[$monthBebanNonOperasional]) : 0;
					$totalPercentLevel4BebanNonOperasional = isset($percentBebanNonOperasionals[$monthBebanNonOperasional]) ? array_sum($percentBebanNonOperasionals[$monthBebanNonOperasional]) : 0;
					//pr($totalLevel4BebanNonOperasional);
					// $totalLevel4BebanNonOperasional = (isset($monthBebanNonOperasional) && $monthBebanNonOperasional!='99') ? array_sum($debetCreditBebanNonOperasionals[$monthBebanNonOperasional]) : array();
					$nominalTotalLevel4BebanNonOperasional = $this->Krs->cur($totalLevel4BebanNonOperasional);
					$nominalTotalpercenBebanNonOperasional = $this->Krs->_percent($totalPercentLevel4BebanNonOperasional).'%';
					$grandTotalBebanNonOperasionals[$monthBebanNonOperasional][] = $totalLevel4BebanNonOperasional;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4BebanNonOperasional.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenBebanNonOperasional.'</b></td>';
				}
			echo '</tr>';
		}
	}
}


// LABA OPERASIONAL SEBELUM PAJAK
echo '<tr>
	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA BERSIH SEBELUM PAJAKsff</b></td>';
	for ($totalLabaBersihSebelumPajak=$monthFrom; $totalLabaBersihSebelumPajak <= $monthEnd; $totalLabaBersihSebelumPajak++) {
		$monthTotalLabaBersihSebelumPajak = str_pad($totalLabaBersihSebelumPajak, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalPendapatanNonOperasional = isset($grandTotalPendapatanNonOperasionals[$monthTotalLabaBersihSebelumPajak]) ? array_sum($grandTotalPendapatanNonOperasionals[$monthTotalLabaBersihSebelumPajak]) : 0;
		$dataGrandTotalBebanNonOperasional = isset($grandTotalBebanNonOperasionals[$monthTotalLabaBersihSebelumPajak]) ? array_sum($grandTotalBebanNonOperasionals[$monthTotalLabaBersihSebelumPajak]) : 0;
		
		$grandTotalLabaBersihSebelumPajakPenjualan = ($grandTotalLabaOperasionalData+$dataGrandTotalPendapatanNonOperasional)-$dataGrandTotalBebanNonOperasional;

		$nominalGrandTotalLabaBersihSebelumPajak = $this->Krs->cur($grandTotalLabaBersihSebelumPajakPenjualan);
		$grandTotalLabaBersihSebelumPajakData[$monthTotalLabaBersihSebelumPajak] = $grandTotalLabaBersihSebelumPajakPenjualan;
		
		echo '<td align="right"><b>'.$nominalGrandTotalLabaBersihSebelumPajak.'</b></td>
		<td align="right">&nbsp;</td>';
	}
echo '</tr>';


//echo "<tr><td></td></tr>";
echo "</table>";
									
									?>
								</div>
							</div>
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
	//datePickerReset('filterMonthYear', 'filterMonthYearReset', 'filterMonthYear', 'mm-yyyy', 'y');
	datePickerReset('input-daterange', 'resetDate', 'filterDate', 'mm-yyyy', 'y');
});
</script>
