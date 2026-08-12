<?= $this->Krs->breadcrumb('Accounting', 'Laba/Rugi (Multi)', 'Tampilkan') ?>
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
							<label class="col-form-label col-md-4">Bulan-Tahun</label>
							<div class="col-md-8">
								<div class="input-group">
									<div class="input-group input-daterange">
										<?php
										//div class="input-group input-small input-monthYear">
										// date-picker
										echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control filterDatePicker filterDate", 'id'=>'filterMonthYear', 'readonly' => true, 'placeholder' => 'Tgl Awal...'), 'filterDateEnd', array("class"=>"form-control filterDatePicker filterDate", 'id'=>'filterMonthYear1', 'readonly' => true, 'placeholder' => 'Tgl Akhir...'), 's/d', 'filterMonthYearReset');

										// echo $this->Form->input("filterMYDate", array("class" => "form-control filterMY", 'id'=>'filterMonthYear', "autocomplete"=>"off", "error" => false, 'placeholder' => 'Bulan-Tahun...', "required"=>false, 'readonly' => true));
										/*<span class="input-group-append">
											<button class="btn btn-inverse filterMonthYearReset" type="button"><i class="fa fa-times"></i></button>
										</span>*/
										?>
										

									</div>
								</div>
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
					<div data-scrollbar="true" data-height="400px">
						<table class="table table-striped table-hover">
							<thead class="thead-dark text-center">
								<tr>
									<tr>
										<th>Keterangan</th>
										<?php
										for ($i=$monthFrom; $i <= $monthEnd; $i++) {
											$monthIndo = $this->Krs->getMonth($i);

										echo '<th align="center"><b>'.$monthIndo.'</b></th>
										<th align="center" width="85">%</th>';
										}
										?>
									</tr>
								</tr>
							</thead>
							<tbody>
							<?php
							//pr($listCOAPendapatan);
$dataMonth = $monthFrom.'^'.$monthEnd;

$listCOASubTotalPendapatan = $this->Krs->incomeMultiPercentNew($listCOAPendapatan, $dataMonth, 'pendapatan');
$listCOASubTotalReturPendapatan = $this->Krs->incomeMultiPercentNew($listCOAReturPendapatan, $dataMonth, 'retur_pendapatan');
$listCOASubTotalPotonganPendapatan = $this->Krs->incomeMultiPercentNew($listCOAPotonganPendapatan, $dataMonth, 'potongan_pendapatan');
$listCOASubTotalBebanPokokPendapatan = $this->Krs->incomeMultiPercentNew($listCOABebanPokokPendapatan, $dataMonth, 'beban_pokok_pendapatan');
$listCOASubTotalBebanPendapatan = $this->Krs->incomeMultiPercentNew($listCOABebanPendapatan, $dataMonth, 'beban_pendapatan');
$listCOASubTotalBebanAdministrasiUmum = $this->Krs->incomeMultiPercentNew($listCOABebanAdministrasiUmum, $dataMonth, 'beban_administrasi_umum');
$listCOASubTotalPendapatanNonOperasional = $this->Krs->incomeMultiPercentNew($listCOAPendapatanNonOperasional, $dataMonth, 'pendapatan_non_operasional');
$listCOASubTotalBebanNonOperasional = $this->Krs->incomeMultiPercentNew($listCOABebanNonOperasional, $dataMonth, 'beban_non_operasional');


$subTotalCOA = array();
for ($ttCOA=$monthFrom; $ttCOA <= $monthEnd; $ttCOA++) {
	$monthDataz = str_pad($ttCOA, 2, '0', STR_PAD_LEFT);
	$subTotalCOA[$monthDataz]['pendapatan'] = $listCOASubTotalPendapatan[$monthDataz]['pendapatan'];
	$subTotalCOA[$monthDataz]['retur_pendapatan'] = $listCOASubTotalReturPendapatan[$monthDataz]['retur_pendapatan'];
	$subTotalCOA[$monthDataz]['potongan_pendapatan'] = $listCOASubTotalPotonganPendapatan[$monthDataz]['potongan_pendapatan'];
	$subTotalCOA[$monthDataz]['beban_pokok_pendapatan'] = $listCOASubTotalBebanPokokPendapatan[$monthDataz]['beban_pokok_pendapatan'];
	$subTotalCOA[$monthDataz]['beban_pendapatan'] = $listCOASubTotalBebanPendapatan[$monthDataz]['beban_pendapatan'];
	$subTotalCOA[$monthDataz]['beban_administrasi_umum'] = $listCOASubTotalBebanAdministrasiUmum[$monthDataz]['beban_administrasi_umum'];
	$subTotalCOA[$monthDataz]['pendapatan_non_operasional'] = $listCOASubTotalPendapatanNonOperasional[$monthDataz]['pendapatan_non_operasional'];
	$subTotalCOA[$monthDataz]['beban_non_operasional'] = $listCOASubTotalBebanNonOperasional[$monthDataz]['beban_non_operasional'];
}

$totalPercent = array();
$totalPendapatanPercent = array();
$totalReturPendapatanPercent = array();
$totalPotonganPendapatanPercent = array();
$totalBebanPokokPendapatanPercent = array();
$totalBebanPendapatanPercent = array();
$totalBebanAdministrasiUmumPercent = array();
$totalPendapatanNonOperasionalPercent = array();
$totalBebanNonOperasionalPercent = array();

// $totalBebanPemasaranPercent = array();
// $totalBebanLainLainPercent = array();
for ($ttl=$monthFrom; $ttl <= $monthEnd; $ttl++) {
	$monthData = str_pad($ttl, 2, '0', STR_PAD_LEFT);
	$totalPercent[$monthData] = (isset($subTotalCOA[$monthData])) ? round(array_sum($subTotalCOA[$monthData]), 2) : 0;
	$totalPendapatanPercent[$monthData] = (isset($listCOASubTotalPendapatan[$monthData])) ? round(array_sum($listCOASubTotalPendapatan[$monthData]), 2) : 0;
	$totalReturPendapatanPercent[$monthData] = (isset($listCOASubTotalReturPendapatan[$monthData])) ? round(array_sum($listCOASubTotalReturPendapatan[$monthData]), 2) : 0;

	$totalPotonganPendapatanPercent[$monthData] = (isset($listCOASubTotalPotonganPendapatan[$monthData])) ? round(array_sum($listCOASubTotalPotonganPendapatan[$monthData]), 2) : 0;
	$totalBebanPokokPendapatanPercent[$monthData] = (isset($listCOASubTotalBebanPokokPendapatan[$monthData])) ? round(array_sum($listCOASubTotalBebanPokokPendapatan[$monthData]), 2) : 0;
	$totalBebanPendapatanPercent[$monthData] = (isset($listCOASubTotalBebanPendapatan[$monthData])) ? round(array_sum($listCOASubTotalBebanPendapatan[$monthData]), 2) : 0;
	$totalBebanAdministrasiUmumPercent[$monthData] = (isset($listCOASubTotalBebanAdministrasiUmum[$monthData])) ? round(array_sum($listCOASubTotalBebanAdministrasiUmum[$monthData]), 2) : 0;
	$totalPendapatanNonOperasionalPercent[$monthData] = (isset($listCOASubTotalPendapatanNonOperasional[$monthData])) ? round(array_sum($listCOASubTotalPendapatanNonOperasional[$monthData]), 2) : 0;
	$totalBebanNonOperasionalPercent[$monthData] = (isset($listCOASubTotalBebanNonOperasional[$monthData])) ? round(array_sum($listCOASubTotalBebanNonOperasional[$monthData]), 2) : 0;
}
//pr($totalBebanPercent);

//pr($totalPercent);
//pr($totalPendapatanPercent);

// Pendapatan
//pr($dataBebanLainLainCOALevel5Values);
//$noPendapatan = 1;
$grandTotalPendapatans = array();
foreach ($listCOAPendapatan as $idPendapatanLevel4 => $detailPendapatan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPendapatan['Level5Name']) && $detailPendapatan['Level5Name']) {
		$level5NamePendapatan = array_unique($detailPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditPendapatans = array();
		$percentPendapatans = array();
		foreach ($level5NamePendapatan as $dataLevelCOAPendapatan) {
			//pr($dataLevelCOAPendapatan);
			if(isset($dataLevelCOAPendapatan)) {
				list($idDetailPendapatan, $codeDetailPendapatan, $nameDetailPendapatan) = explode('^', $dataLevelCOAPendapatan);
				echo '<tr>
						<td>('.$codeDetailPendapatan.') '.$nameDetailPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailPendapatan['Level5'][$monthData][$idDetailPendapatan]))) {
								$dataCOALevel5Values = $detailPendapatan['Level5'][$monthData][$idDetailPendapatan];
								list($codePendapatan, $debetCreditPendapatan, $beginningBalancePendapatan, $totalPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalPendapatan = $debetCreditPendapatan/$totalPendapatanPercent[$monthData]*100;

								$debetCreditPendapatans[$monthData][] = $debetCreditPendapatan;
								$percentPendapatans[$monthData][] = $percenTotalPendapatan;

								$percenPendapatan = $this->Krs->percent($percenTotalPendapatan).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditPendapatan);
							} else {
								$dataCOALevel5Value = 0;
								$percenPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenPendapatan.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
			//pr($debetCreditPendapatans['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePendapatan).'</b></td>';
				for ($Pendapatan=$monthFrom; $Pendapatan <= $monthEnd; $Pendapatan++) {
					$monthPendapatan = str_pad($Pendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4Pendapatan = isset($debetCreditPendapatans[$monthPendapatan]) ? array_sum($debetCreditPendapatans[$monthPendapatan]) : 0;
					$totalPercentLevel4Pendapatan = isset($percentPendapatans[$monthPendapatan]) ? array_sum($percentPendapatans[$monthPendapatan]) : 0;
					//pr($totalLevel4Pendapatan);
					// $totalLevel4Pendapatan = (isset($monthPendapatan) && $monthPendapatan!='99') ? array_sum($debetCreditPendapatans[$monthPendapatan]) : array();
					$nominalTotalLevel4Pendapatan = $this->Krs->cur($totalLevel4Pendapatan);
					$nominalTotalpercenPendapatan = $this->Krs->percent($totalPercentLevel4Pendapatan).'%';
					$grandTotalPendapatans[$monthPendapatan][] = $totalLevel4Pendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4Pendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}


/*


$grandTotalPendapatans = array();
foreach ($listCOAPendapatan as $idPendapatanLevel4 => $detailPendapatan) {
 	// Keterangan pada Kas serta Bank
	
	if(isset($detailPendapatan['Level5Name']) && $detailPendapatan['Level5Name']) {

		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
		echo '<tr>
				<td colspan="8"><b>'.strtoupper($namePendapatan).'</b></td>
			</tr>';
		//$noPendapatan++;
		}

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
							$monthData = str_pad(strval($i), 2, '0', STR_PAD_LEFT);

							//pr($detailPendapatan['Level5'][$monthData][$idDetailPendapatan]);

							if(isset($detailPendapatan['Level5'][$monthData][$idDetailPendapatan])) {
								$dataCOALevel5Values = $detailPendapatan['Level5'][$monthData][$idDetailPendapatan];
								list($codePendapatan, $debetCreditPendapatan, $beginningBalancePendapatan, $totalPendapatan) = explode('^', $dataCOALevel5Values);
								
								$percenTotalPendapatan = $debetCreditPendapatan/$totalPendapatanPercent[$monthData]*100;
								//$percenTotalPendapatan = $debetCreditPendapatan/$totalPercent[$monthData]*100;

								$debetCreditPendapatans[$monthData][] = $debetCreditPendapatan;
								$percentPendapatans[$monthData][] = $percenTotalPendapatan;
								$percenPendapatan = $this->Krs->percent($percenTotalPendapatan).'%';
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
					$monthPendapatan = str_pad(strval($pendapatan), 2, '0', STR_PAD_LEFT);
					
					$totalLevel4Pendapatan = isset($debetCreditPendapatans[$monthPendapatan]) ? array_sum($debetCreditPendapatans[$monthPendapatan]) : 0;
					$totalPercentLevel4Pendapatan = isset($percentPendapatans[$monthPendapatan]) ? array_sum($percentPendapatans[$monthPendapatan]) : 0;
					//pr($totalLevel4Pendapatan);
					// $totalLevel4Pendapatan = (isset($monthPendapatan) && $monthPendapatan!='99') ? array_sum($debetCreditPendapatans[$monthPendapatan]) : array();
					$nominalTotalLevel4Pendapatan = $this->Krs->cur($totalLevel4Pendapatan);
					$nominalTotalpercenPendapatan = $this->Krs->percent($totalPercentLevel4Pendapatan).'%';
					$grandTotalPendapatans[$monthPendapatan][] = $totalLevel4Pendapatan;
					
					echo '<td align="right">'.$nominalTotalLevel4Pendapatan.'</td>
					<td align="right">'.$nominalTotalpercenPendapatan.'</td>';
				}
			echo '</tr>';
		}
	}

}*/

//Retur Pendapatan
$grandTotalReturPendapatans = array();
foreach ($listCOAReturPendapatan as $idReturPendapatanLevel4 => $detailReturPendapatan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameReturPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailReturPendapatan['Level5Name']) && $detailReturPendapatan['Level5Name']) {
		$level5NameReturPendapatan = array_unique($detailReturPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditReturPendapatans = array();
		$percentReturPendapatans = array();
		foreach ($level5NameReturPendapatan as $dataLevelCOAReturPendapatan) {
			//pr($dataLevelCOAReturPendapatan);
			if(isset($dataLevelCOAReturPendapatan)) {
				list($idDetailReturPendapatan, $codeDetailReturPendapatan, $nameDetailReturPendapatan) = explode('^', $dataLevelCOAReturPendapatan);
				echo '<tr>
						<td>('.$codeDetailReturPendapatan.') '.$nameDetailReturPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan]))) {
								$dataCOALevel5Values = $detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan];
								list($codeReturPendapatan, $debetCreditReturPendapatan, $beginningBalanceReturPendapatan, $totalReturPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalReturPendapatan = $debetCreditReturPendapatan/$totalReturPendapatanPercent[$monthData]*100;

								$debetCreditReturPendapatans[$monthData][] = $debetCreditReturPendapatan;
								$percentReturPendapatans[$monthData][] = $percenTotalReturPendapatan;

								$percenReturPendapatan = $this->Krs->percent($percenTotalReturPendapatan).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditReturPendapatan);
							} else {
								$dataCOALevel5Value = 0;
								$percenReturPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenReturPendapatan.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
			//pr($debetCreditReturPendapatans['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameReturPendapatan).'</b></td>';
				for ($ReturPendapatan=$monthFrom; $ReturPendapatan <= $monthEnd; $ReturPendapatan++) {
					$monthReturPendapatan = str_pad($ReturPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4ReturPendapatan = isset($debetCreditReturPendapatans[$monthReturPendapatan]) ? array_sum($debetCreditReturPendapatans[$monthReturPendapatan]) : 0;
					$totalPercentLevel4ReturPendapatan = isset($percentReturPendapatans[$monthReturPendapatan]) ? array_sum($percentReturPendapatans[$monthReturPendapatan]) : 0;
					//pr($totalLevel4ReturPendapatan);
					// $totalLevel4ReturPendapatan = (isset($monthReturPendapatan) && $monthReturPendapatan!='99') ? array_sum($debetCreditReturPendapatans[$monthReturPendapatan]) : array();
					$nominalTotalLevel4ReturPendapatan = $this->Krs->cur($totalLevel4ReturPendapatan);
					$nominalTotalpercenReturPendapatan = $this->Krs->percent($totalPercentLevel4ReturPendapatan).'%';
					$grandTotalReturPendapatans[$monthReturPendapatan][] = $totalLevel4ReturPendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4ReturPendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenReturPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}

//Potongan Pendapatan
$grandTotalPotonganPendapatans = array();
foreach ($listCOAPotonganPendapatan as $idPotonganPendapatanLevel4 => $detailPotonganPendapatan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPotonganPendapatan['Level5']) && $detailPotonganPendapatan['Level4']) {
		list($codePotonganPendapatan, $namePotonganPendapatan) = explode('^', $detailPotonganPendapatan['Level4']);

		if(!empty($codePotonganPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePotonganPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPotonganPendapatan['Level5Name']) && $detailPotonganPendapatan['Level5Name']) {
		$level5NamePotonganPendapatan = array_unique($detailPotonganPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditPotonganPendapatans = array();
		$percentPotonganPendapatans = array();
		foreach ($level5NamePotonganPendapatan as $dataLevelCOAPotonganPendapatan) {
			//pr($dataLevelCOAPotonganPendapatan);
			if(isset($dataLevelCOAPotonganPendapatan)) {
				list($idDetailPotonganPendapatan, $codeDetailPotonganPendapatan, $nameDetailPotonganPendapatan) = explode('^', $dataLevelCOAPotonganPendapatan);
				echo '<tr>
						<td>('.$codeDetailPotonganPendapatan.') '.$nameDetailPotonganPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan]))) {
								$dataCOALevel5Values = $detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan];
								list($codePotonganPendapatan, $debetCreditPotonganPendapatan, $beginningBalancePotonganPendapatan, $totalPotonganPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalPotonganPendapatan = $debetCreditPotonganPendapatan/$totalPotonganPendapatanPercent[$monthData]*100;

								$debetCreditPotonganPendapatans[$monthData][] = $debetCreditPotonganPendapatan;
								$percentPotonganPendapatans[$monthData][] = $percenTotalPotonganPendapatan;

								$percenPotonganPendapatan = $this->Krs->percent($percenTotalPotonganPendapatan).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditPotonganPendapatan);
							} else {
								$dataCOALevel5Value = 0;
								$percenPotonganPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenPotonganPendapatan.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPotonganPendapatan['Level5']) && $detailPotonganPendapatan['Level4']) {
		list($codePotonganPendapatan, $namePotonganPendapatan) = explode('^', $detailPotonganPendapatan['Level4']);

		if(!empty($codePotonganPendapatan)) {
			//pr($debetCreditPotonganPendapatans['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePotonganPendapatan).'</b></td>';
				for ($PotonganPendapatan=$monthFrom; $PotonganPendapatan <= $monthEnd; $PotonganPendapatan++) {
					$monthPotonganPendapatan = str_pad($PotonganPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4PotonganPendapatan = isset($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) ? array_sum($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) : 0;
					$totalPercentLevel4PotonganPendapatan = isset($percentPotonganPendapatans[$monthPotonganPendapatan]) ? array_sum($percentPotonganPendapatans[$monthPotonganPendapatan]) : 0;
					//pr($totalLevel4PotonganPendapatan);
					// $totalLevel4PotonganPendapatan = (isset($monthPotonganPendapatan) && $monthPotonganPendapatan!='99') ? array_sum($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) : array();
					$nominalTotalLevel4PotonganPendapatan = $this->Krs->cur($totalLevel4PotonganPendapatan);
					$nominalTotalpercenPotonganPendapatan = $this->Krs->percent($totalPercentLevel4PotonganPendapatan).'%';
					$grandTotalPotonganPendapatans[$monthPotonganPendapatan][] = $totalLevel4PotonganPendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4PotonganPendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenPotonganPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}

/*
$grandTotalReturPendapatans = array();
foreach ($listCOAReturPendapatan as $idReturPendapatanLevel4 => $detailReturPendapatan) {
 	if(isset($detailReturPendapatan['Level5Name']) && $detailReturPendapatan['Level5Name']) {

		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
		echo '<tr>
				<td colspan="8"><b>'.strtoupper($nameReturPendapatan).'</b></td>
			</tr>';
		}

		$level5NameReturPendapatan = array_unique($detailReturPendapatan['Level5Name']);
	
		$a = 0;
		$debetCreditReturPendapatans = array();
		$percentReturPendapatans = array();
		foreach ($level5NameReturPendapatan as $dataLevelCOAReturPendapatan) {
			if(isset($dataLevelCOAReturPendapatan)) {
				list($idDetailReturPendapatan, $codeDetailReturPendapatan, $nameDetailReturPendapatan) = explode('^', $dataLevelCOAReturPendapatan);
				for ($i=$monthFrom; $i <= $monthEnd; $i++) {
					$monthData = str_pad(strval($i), 2, '0', STR_PAD_LEFT);

					if(isset($detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan])) {
						$dataCOALevel5Values = $detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan];
						list($codeReturPendapatan, $debetCreditReturPendapatan, $beginningBalanceReturPendapatan, $totalReturPendapatan) = explode('^', $dataCOALevel5Values);
						
						$percenTotalReturPendapatan = $debetCreditReturPendapatan/$totalReturPendapatanPercent[$monthData]*100;
						
						$debetCreditReturPendapatans[$monthData][] = $debetCreditReturPendapatan;
						$percentReturPendapatans[$monthData][] = $percenTotalReturPendapatan;
						$percenReturPendapatan = $this->Krs->percent($percenTotalReturPendapatan).'%';
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
				$monthReturPendapatan = str_pad(strval($ReturPendapatan), 2, '0', STR_PAD_LEFT);
				
				$totalLevel4ReturPendapatan = isset($debetCreditReturPendapatans[$monthReturPendapatan]) ? array_sum($debetCreditReturPendapatans[$monthReturPendapatan]) : 0;
				$totalPercentLevel4ReturPendapatan = isset($percentReturPendapatans[$monthReturPendapatan]) ? array_sum($percentReturPendapatans[$monthReturPendapatan]) : 0;
				
				$nominalTotalLevel4ReturPendapatan = $this->Krs->cur($totalLevel4ReturPendapatan);
				$nominalTotalpercenReturPendapatan = $this->Krs->percent($totalPercentLevel4ReturPendapatan).'%';
				$grandTotalReturPendapatans[$monthReturPendapatan][] = $totalLevel4ReturPendapatan;
				
				echo '<td align="right">'.$nominalTotalLevel4ReturPendapatan.'</td>
				<td align="right">'.$nominalTotalpercenReturPendapatan.'</td>';
			}
		echo '</tr>';
		}
	}
}*/

//Potongan Pendapatan
/*$grandTotalReturPendapatans = array();
foreach ($listCOAReturPendapatan as $idReturPendapatanLevel4 => $detailReturPendapatan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameReturPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailReturPendapatan['Level5Name']) && $detailReturPendapatan['Level5Name']) {
		$level5NameReturPendapatan = array_unique($detailReturPendapatan['Level5Name']);
		
		$a = 0;
		$debetCreditReturPendapatans = array();
		$percentReturPendapatans = array();
		foreach ($level5NameReturPendapatan as $dataLevelCOAReturPendapatan) {
			//pr($dataLevelCOAReturPendapatan);
			if(isset($dataLevelCOAReturPendapatan)) {
				list($idDetailReturPendapatan, $codeDetailReturPendapatan, $nameDetailReturPendapatan) = explode('^', $dataLevelCOAReturPendapatan);
				echo '<tr>
						<td>('.$codeDetailReturPendapatan.') '.$nameDetailReturPendapatan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan]))) {
								$dataCOALevel5Values = $detailReturPendapatan['Level5'][$monthData][$idDetailReturPendapatan];
								list($codeReturPendapatan, $debetCreditReturPendapatan, $beginningBalanceReturPendapatan, $totalReturPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalReturPendapatan = $debetCreditReturPendapatan/$totalReturPendapatanPercent[$monthData]*100;

								$debetCreditReturPendapatans[$monthData][] = $debetCreditReturPendapatan;
								$percentReturPendapatans[$monthData][] = $percenTotalReturPendapatan;

								$percenReturPendapatan = $this->Krs->percent($percenTotalReturPendapatan).'%';

								$dataCOALevel5Value = $this->Krs->cur($debetCreditReturPendapatan);
							} else {
								$dataCOALevel5Value = 0;
								$percenReturPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						echo '<td align="right">'.$dataCOALevel5Value.'</td>';
						echo '<td align="right">'.$percenReturPendapatan.'</td>';
						}
				echo '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
			//pr($debetCreditReturPendapatans['02']);

		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameReturPendapatan).'</b></td>';
				for ($ReturPendapatan=$monthFrom; $ReturPendapatan <= $monthEnd; $ReturPendapatan++) {
					$monthReturPendapatan = str_pad($ReturPendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4ReturPendapatan = isset($debetCreditReturPendapatans[$monthReturPendapatan]) ? array_sum($debetCreditReturPendapatans[$monthReturPendapatan]) : 0;
					$totalPercentLevel4ReturPendapatan = isset($percentReturPendapatans[$monthReturPendapatan]) ? array_sum($percentReturPendapatans[$monthReturPendapatan]) : 0;
					//pr($totalLevel4ReturPendapatan);
					// $totalLevel4ReturPendapatan = (isset($monthReturPendapatan) && $monthReturPendapatan!='99') ? array_sum($debetCreditReturPendapatans[$monthReturPendapatan]) : array();
					$nominalTotalLevel4ReturPendapatan = $this->Krs->cur($totalLevel4ReturPendapatan);
					$nominalTotalpercenReturPendapatan = $this->Krs->percent($totalPercentLevel4ReturPendapatan).'%';
					$grandTotalReturPendapatans[$monthReturPendapatan][] = $totalLevel4ReturPendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4ReturPendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenReturPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}*/

/*$grandTotalPotonganPendapatans = array();
foreach ($listCOAPotonganPendapatan as $idPotonganPendapatanLevel4 => $detailPotonganPendapatan) {
 	if(isset($detailPotonganPendapatan['Level5Name']) && $detailPotonganPendapatan['Level5Name']) {

		list($codePotonganPendapatan, $namePotonganPendapatan) = explode('^', $detailPotonganPendapatan['Level4']);

		if(!empty($codePotonganPendapatan)) {
		echo '<tr>
				<td colspan="8"><b>'.strtoupper($namePotonganPendapatan).'</b></td>
			</tr>';
		}

		$level5NamePotonganPendapatan = array_unique($detailPotonganPendapatan['Level5Name']);
	
		$a = 0;
		$debetCreditPotonganPendapatans = array();
		$percentPotonganPendapatans = array();
		foreach ($level5NamePotonganPendapatan as $dataLevelCOAPotonganPendapatan) {
			if(isset($dataLevelCOAPotonganPendapatan)) {
				list($idDetailPotonganPendapatan, $codeDetailPotonganPendapatan, $nameDetailPotonganPendapatan) = explode('^', $dataLevelCOAPotonganPendapatan);
				for ($i=$monthFrom; $i <= $monthEnd; $i++) {
					$monthData = str_pad(strval($i), 2, '0', STR_PAD_LEFT);

					if(isset($detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan])) {
						$dataCOALevel5Values = $detailPotonganPendapatan['Level5'][$monthData][$idDetailPotonganPendapatan];
						list($codePotonganPendapatan, $debetCreditPotonganPendapatan, $beginningBalancePotonganPendapatan, $totalPotonganPendapatan) = explode('^', $dataCOALevel5Values);
						
						$percenTotalPotonganPendapatan = $debetCreditPotonganPendapatan/$totalPotonganPendapatanPercent[$monthData]*100;
						
						$debetCreditPotonganPendapatans[$monthData][] = $debetCreditPotonganPendapatan;
						$percentPotonganPendapatans[$monthData][] = $percenTotalPotonganPendapatan;
						$percenPotonganPendapatan = $this->Krs->percent($percenTotalPotonganPendapatan).'%';
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
				$monthPotonganPendapatan = str_pad(strval($PotonganPendapatan), 2, '0', STR_PAD_LEFT);
				
				$totalLevel4PotonganPendapatan = isset($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) ? array_sum($debetCreditPotonganPendapatans[$monthPotonganPendapatan]) : 0;
				$totalPercentLevel4PotonganPendapatan = isset($percentPotonganPendapatans[$monthPotonganPendapatan]) ? array_sum($percentPotonganPendapatans[$monthPotonganPendapatan]) : 0;
				
				$nominalTotalLevel4PotonganPendapatan = $this->Krs->cur($totalLevel4PotonganPendapatan);
				$nominalTotalpercenPotonganPendapatan = $this->Krs->percent($totalPercentLevel4PotonganPendapatan).'%';
				$grandTotalPotonganPendapatans[$monthPotonganPendapatan][] = $totalLevel4PotonganPendapatan;
				
				echo '<td align="right">'.$nominalTotalLevel4PotonganPendapatan.'</td>
				<td align="right">'.$nominalTotalpercenPotonganPendapatan.'</td>';
			}
		echo '</tr>';
		}
	}
}*/


//TOTAL PENDAPATAN BERSIH							
echo '<tr>
	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL PENDAPATAN BERSIH</b></td>';
	for ($totalPendapatanBersih=$monthFrom; $totalPendapatanBersih <= $monthEnd; $totalPendapatanBersih++) {
		$monthTotalPendapatanBersih = str_pad(strval($totalPendapatanBersih), 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalPendapatan = isset($grandTotalPendapatans[$monthTotalPendapatanBersih]) ? round(array_sum($grandTotalPendapatans[$monthTotalPendapatanBersih]), 2) : 0;
		$dataGrandTotalReturPendapatan = isset($grandTotalReturPendapatans[$monthTotalPendapatanBersih]) ? round(array_sum($grandTotalReturPendapatans[$monthTotalPendapatanBersih]), 2) : 0;
		$dataGrandTotalPotonganPendapatan = isset($grandTotalPotonganPendapatans[$monthTotalPendapatanBersih]) ? round(array_sum($grandTotalPotonganPendapatans[$monthTotalPendapatanBersih]), 2) : 0;

		$grandTotalPendapatanBersih = $dataGrandTotalPendapatan-($dataGrandTotalReturPendapatan+$dataGrandTotalPotonganPendapatan);

		$nominalGrandTotalPendapatanBersih = $this->Krs->cur($grandTotalPendapatanBersih);
		$grandTotalPendapatanBersihData[$monthTotalPendapatanBersih] = $grandTotalPendapatanBersih;
		
		echo '<td align="right"><b>'.$nominalGrandTotalPendapatanBersih.'</b></td>
		<td align="right">100%</td>';
	}
echo '</tr>';


//Beban Pokok Pendapatan
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

								$percenBebanPokokPendapatan = $this->Krs->percent($percenTotalBebanPokokPendapatan).'%';

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
					$nominalTotalpercenBebanPokokPendapatan = $this->Krs->percent($totalPercentLevel4BebanPokokPendapatan).'%';
					$grandTotalBebanPokokPendapatans[$monthBebanPokokPendapatan][] = $totalLevel4BebanPokokPendapatan;
					
					echo '<td align="right"><b>'.$nominalTotalLevel4BebanPokokPendapatan.'</b></td>
					<td align="right"><b>'.$nominalTotalpercenBebanPokokPendapatan.'</b></td>';
				}
			echo '</tr>';
		}
	}
}

/*$grandTotalBebanPokokPendapatans = array();
foreach ($listCOABebanPokokPendapatan as $idBebanPokokPendapatanLevel4 => $detailBebanPokokPendapatan) {
 	if(isset($detailBebanPokokPendapatan['Level5Name']) && $detailBebanPokokPendapatan['Level5Name']) {

		list($codeBebanPokokPendapatan, $nameBebanPokokPendapatan) = explode('^', $detailBebanPokokPendapatan['Level4']);

		if(!empty($codeBebanPokokPendapatan)) {
		echo '<tr>
				<td colspan="8"><b>'.strtoupper($nameBebanPokokPendapatan).'</b></td>
			</tr>';
		}

		$level5NameBebanPokokPendapatan = array_unique($detailBebanPokokPendapatan['Level5Name']);
	
		$a = 0;
		$debetCreditBebanPokokPendapatans = array();
		$percentBebanPokokPendapatans = array();
		foreach ($level5NameBebanPokokPendapatan as $dataLevelCOABebanPokokPendapatan) {
			if(isset($dataLevelCOABebanPokokPendapatan)) {
				list($idDetailBebanPokokPendapatan, $codeDetailBebanPokokPendapatan, $nameDetailBebanPokokPendapatan) = explode('^', $dataLevelCOABebanPokokPendapatan);
				for ($i=$monthFrom; $i <= $monthEnd; $i++) {
					$monthData = str_pad(strval($i), 2, '0', STR_PAD_LEFT);

					if(isset($detailBebanPokokPendapatan['Level5'][$monthData][$idDetailBebanPokokPendapatan])) {
						$dataCOALevel5Values = $detailBebanPokokPendapatan['Level5'][$monthData][$idDetailBebanPokokPendapatan];
						list($codeBebanPokokPendapatan, $debetCreditBebanPokokPendapatan, $beginningBalanceBebanPokokPendapatan, $totalBebanPokokPendapatan) = explode('^', $dataCOALevel5Values);
						
						$percenTotalBebanPokokPendapatan = $debetCreditBebanPokokPendapatan/$totalBebanPokokPendapatanPercent[$monthData]*100;
						
						$debetCreditBebanPokokPendapatans[$monthData][] = $debetCreditBebanPokokPendapatan;
						$percentBebanPokokPendapatans[$monthData][] = $percenTotalBebanPokokPendapatan;
						$percenBebanPokokPendapatan = $this->Krs->percent($percenTotalBebanPokokPendapatan).'%';
						$dataCOALevel5Value = $this->Krs->cur($debetCreditBebanPokokPendapatan);
					} else {
						$debetCreditBebanPokokPendapatans[99] = 0;
						$dataCOALevel5Value = 0;
						$percenBebanPokokPendapatan = '0%';
					}
				}
				$a++;
			}
		}
	}
	
	if(isset($detailBebanPokokPendapatan['Level5']) && $detailBebanPokokPendapatan['Level4']) {
		list($codeBebanPokokPendapatan, $nameBebanPokokPendapatan) = explode('^', $detailBebanPokokPendapatan['Level4']);

		if(!empty($codeBebanPokokPendapatan)) {
		
	echo '<tr>
			<td>('.$codeBebanPokokPendapatan.') '.strtoupper($nameBebanPokokPendapatan).'</b></td>';
			for ($BebanPokokPendapatan=$monthFrom; $BebanPokokPendapatan <= $monthEnd; $BebanPokokPendapatan++) {
				$monthBebanPokokPendapatan = str_pad(strval($BebanPokokPendapatan), 2, '0', STR_PAD_LEFT);
				
				$totalLevel4BebanPokokPendapatan = isset($debetCreditBebanPokokPendapatans[$monthBebanPokokPendapatan]) ? array_sum($debetCreditBebanPokokPendapatans[$monthBebanPokokPendapatan]) : 0;
				$totalPercentLevel4BebanPokokPendapatan = isset($percentBebanPokokPendapatans[$monthBebanPokokPendapatan]) ? array_sum($percentBebanPokokPendapatans[$monthBebanPokokPendapatan]) : 0;
				
				$nominalTotalLevel4BebanPokokPendapatan = $this->Krs->cur($totalLevel4BebanPokokPendapatan);
				$nominalTotalpercenBebanPokokPendapatan = $this->Krs->percent($totalPercentLevel4BebanPokokPendapatan).'%';
				$grandTotalBebanPokokPendapatans[$monthBebanPokokPendapatan][] = $totalLevel4BebanPokokPendapatan;
				
				echo '<td align="right">'.$nominalTotalLevel4BebanPokokPendapatan.'</td>
				<td align="right">'.$nominalTotalpercenBebanPokokPendapatan.'</td>';
			}
		echo '</tr>';
		}
	}
}*/

//LABA KOTOR
echo '<tr>
	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA KOTOR</b></td>';
	for ($totalLabaKotor=$monthFrom; $totalLabaKotor <= $monthEnd; $totalLabaKotor++) {
		$monthTotalLabaKotor = str_pad($totalLabaKotor, 2, '0', STR_PAD_LEFT);
		
		//$dataGrandTotalPendapatanBersih = isset($grandTotalPendapatanBersihData[$monthTotalLabaKotor]) ? round(array_sum($grandTotalPendapatanBersihData[$monthTotalLabaKotor]), 2) : 0;
		$dataGrandTotalBebanPokokPendapatan = isset($grandTotalBebanPokokPendapatans[$monthTotalLabaKotor]) ? round(array_sum($grandTotalBebanPokokPendapatans[$monthTotalLabaKotor]), 2) : 0;

		$grandTotalLabaKotor = $grandTotalPendapatanBersihData[$monthTotalLabaKotor]-$dataGrandTotalBebanPokokPendapatan;

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

								$percenBebanPendapatan = $this->Krs->percent($percenTotalBebanPendapatan).'%';

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
					$nominalTotalpercenBebanPendapatan = $this->Krs->percent($totalPercentLevel4BebanPendapatan).'%';
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

								$percenBebanAdministrasiUmum = $this->Krs->percent($percenTotalBebanAdministrasiUmum).'%';

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
					$nominalTotalpercenBebanAdministrasiUmum = $this->Krs->percent($totalPercentLevel4BebanAdministrasiUmum).'%';
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
		
		$dataGrandTotalBebanPendapatan = isset($grandTotalBebanPendapatans[$monthTotalLabaOperasional]) ? round(array_sum($grandTotalBebanPendapatans[$monthTotalLabaOperasional]), 2) : 0;
		$dataGrandTotalBebanAdministrasiUmum = isset($grandTotalBebanAdministrasiUmums[$monthTotalLabaOperasional]) ? round(array_sum($grandTotalBebanAdministrasiUmums[$monthTotalLabaOperasional]), 2) : 0;
		
		$grandTotalLabaOperasional = $grandTotalLabaKotorData[$monthTotalLabaOperasional]-($dataGrandTotalBebanPendapatan+$dataGrandTotalBebanAdministrasiUmum);

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

								$percenPendapatanNonOperasional = $this->Krs->percent($percenTotalPendapatanNonOperasional).'%';

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
					$nominalTotalpercenPendapatanNonOperasional = $this->Krs->percent($totalPercentLevel4PendapatanNonOperasional).'%';
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

								$percenBebanNonOperasional = $this->Krs->percent($percenTotalBebanNonOperasional).'%';

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
					$nominalTotalpercenBebanNonOperasional = $this->Krs->percent($totalPercentLevel4BebanNonOperasional).'%';
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
		
		$dataGrandTotalPendapatanNonOperasional = isset($grandTotalPendapatanNonOperasionals[$monthTotalLabaBersihSebelumPajak]) ? round(array_sum($grandTotalPendapatanNonOperasionals[$monthTotalLabaBersihSebelumPajak]), 2) : 0;
		$dataGrandTotalBebanNonOperasional = isset($grandTotalBebanNonOperasionals[$monthTotalLabaBersihSebelumPajak]) ? round(array_sum($grandTotalBebanNonOperasionals[$monthTotalLabaBersihSebelumPajak]), 2) : 0;
		
		$grandTotalLabaBersihSebelumPajakPenjualan = ($grandTotalLabaOperasionalData[$monthTotalLabaBersihSebelumPajak]+$dataGrandTotalPendapatanNonOperasional)-$dataGrandTotalBebanNonOperasional;

		$nominalGrandTotalLabaBersihSebelumPajak = $this->Krs->cur($grandTotalLabaBersihSebelumPajakPenjualan);
		$grandTotalLabaBersihSebelumPajakData[$monthTotalLabaBersihSebelumPajak] = $grandTotalLabaBersihSebelumPajakPenjualan;
		
		echo '<td align="right"><b>'.$nominalGrandTotalLabaBersihSebelumPajak.'</b></td>
		<td align="right">&nbsp;</td>';
	}
echo '</tr>';
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
    var formAction = "<?php echo $this->Url->build(['controller'=>'AccJournals', 'action' => 'income_multi_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalIncomeGlobalReportForm', 'btn-search', confirmTitle, formAction);

	handleDateRange('filterMonthYear', 'filterMonthYearReset', 'filterDatePicker', 'mm-yyyy', 'y', 'filterMonthYear1');
});
</script>