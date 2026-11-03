<?= $this->Krs->breadcrumb('Accounting', 'Laba/Rugi (Global)', 'Tampilkan') ?>
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
							<label class="col-form-label col-md-4">Bulan-Tahun</label>
							<div class="col-md-8">
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
										<th width="200">Bulan Ini</th>
										<th width="200">Kumulatif</th>
									</tr>
								</tr>
							</thead>
							<tbody>
							<?php

// Pendapatan
$grandTotalPendapatans = array();
$grandTotalAfterPendapatans = array();
foreach ($listCOAPendapatan as $idPendapatan => $detailPendapatan) {
 	
 	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level5']) {
		$debetCreditDetailPendapatans = array();
		$debetCreditDetailAfterPendapatans = array();
		foreach ($detailPendapatan['Level5'] as $dataCOAPendapatan) {
			list($codeDetailPendapatan, $nameDetailPendapatan, $debetCreditDetailPendapatan, $debetCreditDetailAfterPendapatan, $beginningBalanceDetailPendapatan, $subTotalDetailPendapatan, $subTotalDetailAfterPendapatan) = explode('^', $dataCOAPendapatan);
			$debetCreditDetailPendapatans[] = $debetCreditDetailPendapatan;
			$debetCreditDetailAfterPendapatans[] = $debetCreditDetailAfterPendapatan;
			$nominalDetailPendapatan = $this->Krs->cur($debetCreditDetailPendapatan);
			$nominalDetailAfterPendapatan = $this->Krs->cur($debetCreditDetailAfterPendapatan);

			echo '<tr>
					<td>('.$codeDetailPendapatan.') '.$nameDetailPendapatan.'</td>
					<td align="right">'.$nominalDetailPendapatan.'</td>
					<td align="right">'.$nominalDetailAfterPendapatan.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
			$totalLevel4Pendapatan = array_sum($debetCreditDetailPendapatans);
			$totalLevel4AfterPendapatan = array_sum($debetCreditDetailAfterPendapatans);
			$nominalTotalLevel4Pendapatan = $this->Krs->cur($totalLevel4Pendapatan);
			$nominalTotalLevel4AfterPendapatan = $this->Krs->cur($totalLevel4AfterPendapatan);
			$grandTotalPendapatans[] = $totalLevel4Pendapatan;
			$grandTotalAfterPendapatans[] = $totalLevel4AfterPendapatan;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePendapatan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4Pendapatan.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterPendapatan.'</b></td>
			</tr>';
		}
	}
}


// Retur Pendapatan
$grandTotalReturPendapatans = array();
$grandTotalAfterReturPendapatans = array();
foreach ($listCOAReturPendapatan as $idReturPendapatan => $detailReturPendapatan) {
 	
 	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameReturPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level5']) {
		$debetCreditDetailReturPendapatans = array();
		$debetCreditDetailAfterReturPendapatans = array();
		foreach ($detailReturPendapatan['Level5'] as $dataCOAReturPendapatan) {
			list($codeDetailReturPendapatan, $nameDetailReturPendapatan, $debetCreditDetailReturPendapatan, $debetCreditDetailAfterReturPendapatan, $beginningBalanceDetailReturPendapatan, $subTotalDetailReturPendapatan, $subTotalDetailAfterReturPendapatan) = explode('^', $dataCOAReturPendapatan);
			$debetCreditDetailReturPendapatans[] = $debetCreditDetailReturPendapatan;
			$debetCreditDetailAfterReturPendapatans[] = $debetCreditDetailAfterReturPendapatan;
			$nominalDetailReturPendapatan = $this->Krs->cur($debetCreditDetailReturPendapatan);
			$nominalDetailAfterReturPendapatan = $this->Krs->cur($debetCreditDetailAfterReturPendapatan);

			echo '<tr>
					<td>('.$codeDetailReturPendapatan.') '.$nameDetailReturPendapatan.'</td>
					<td align="right">'.$nominalDetailReturPendapatan.'</td>
					<td align="right">'.$nominalDetailAfterReturPendapatan.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
			$totalLevel4ReturPendapatan = array_sum($debetCreditDetailReturPendapatans);
			$totalLevel4AfterReturPendapatan = array_sum($debetCreditDetailAfterReturPendapatans);
			$nominalTotalLevel4ReturPendapatan = $this->Krs->cur($totalLevel4ReturPendapatan);
			$nominalTotalLevel4AfterReturPendapatan = $this->Krs->cur($totalLevel4AfterReturPendapatan);
			$grandTotalReturPendapatans[] = $totalLevel4ReturPendapatan;
			$grandTotalAfterReturPendapatans[] = $totalLevel4AfterReturPendapatan;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameReturPendapatan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4ReturPendapatan.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterReturPendapatan.'</b></td>
			</tr>';
		}
	}
}


/*
// Pendapatan
$grandTotalPendapatans = array();
$grandTotalAfterPendapatans = array();

foreach ($listCOAPendapatan as $idPendapatan => $detailPendapatan) {
	
	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level5']) {
		$debetCreditDetailPendapatans = array();
		$debetCreditDetailAfterPendapatans = array();
		
		foreach ($detailPendapatan['Level5'] as $dataCOAPendapatan) {

			list($codeDetailPendapatan, $nameDetailPendapatan, $debetCreditDetailPendapatan, $debetCreditDetailAfterPendapatan, $beginningBalanceDetailPendapatan, $subTotalDetailPendapatan, $subTotalDetailAfterPendapatan) = explode('^', $dataCOAPendapatan);
			$debetCreditDetailPendapatans[] = $debetCreditDetailPendapatan;

			$debetCreditDetailAfterPendapatans[] = $debetCreditDetailAfterPendapatan;
			$nominalDetailPendapatan = $this->Krs->cur($debetCreditDetailPendapatan);
			$nominalDetailAfterPendapatan = $this->Krs->cur($debetCreditDetailAfterPendapatan);
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codeDetailPendapatan, $nameDetailPendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codeDetailPendapatan)) {
			$totalLevel4Pendapatan = array_sum($debetCreditDetailPendapatans);
			$totalLevel4AfterPendapatan = array_sum($debetCreditDetailAfterPendapatans);
			$nominalTotalLevel4Pendapatan = $this->Krs->cur($totalLevel4Pendapatan);
			$nominalTotalLevel4AfterPendapatan = $this->Krs->cur($totalLevel4AfterPendapatan);
			$grandTotalPendapatans[] = $totalLevel4Pendapatan;
			$grandTotalAfterPendapatans[] = $totalLevel4AfterPendapatan;
		echo '<tr>
				<td>dd('.$codeDetailPendapatan.') '.strtoupper($nameDetailPendapatan).'</td>
				<td align="right">'.$nominalTotalLevel4Pendapatan.'</td>
				<td align="right">'.$nominalTotalLevel4AfterPendapatan.'</td>
			</tr>';
		}
	}
}

// Retur Pendapatan
$grandTotalReturPendapatans = array();
$grandTotalAfterReturPendapatans = array();
foreach ($listCOAReturPendapatan as $idReturPendapatan => $detailReturPendapatan) {
 	
	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameReturPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level5']) {
		$debetCreditDetailReturPendapatans = array();
		$debetCreditDetailAfterReturPendapatans = array();
		foreach ($detailReturPendapatan['Level5'] as $dataCOAReturPendapatan) {
			list($codeDetailReturPendapatan, $nameDetailReturPendapatan, $debetCreditDetailReturPendapatan, $debetCreditDetailAfterReturPendapatan, $beginningBalanceDetailReturPendapatan, $subTotalDetailReturPendapatan, $subTotalDetailAfterReturPendapatan) = explode('^', $dataCOAReturPendapatan);
			$debetCreditDetailReturPendapatans[] = $debetCreditDetailReturPendapatan;
			$debetCreditDetailAfterReturPendapatans[] = $debetCreditDetailAfterReturPendapatan;
			$nominalDetailReturPendapatan = $this->Krs->cur($debetCreditDetailReturPendapatan);
			$nominalDetailAfterReturPendapatan = $this->Krs->cur($debetCreditDetailAfterReturPendapatan);

			echo '<tr>
					<td>('.$codeDetailReturPendapatan.') '.$nameDetailReturPendapatan.'</td>
					<td align="right">'.$nominalDetailReturPendapatan.'</td>
					<td align="right">'.$nominalDetailAfterReturPendapatan.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailReturPendapatan['Level5']) && $detailReturPendapatan['Level4']) {
		list($codeReturPendapatan, $nameReturPendapatan) = explode('^', $detailReturPendapatan['Level4']);

		if(!empty($codeReturPendapatan)) {
			$totalLevel4ReturPendapatan = array_sum($debetCreditDetailReturPendapatans);
			$totalLevel4AfterReturPendapatan = array_sum($debetCreditDetailAfterReturPendapatans);
			$nominalTotalLevel4ReturPendapatan = $this->Krs->cur($totalLevel4ReturPendapatan);
			$nominalTotalLevel4AfterReturPendapatan = $this->Krs->cur($totalLevel4AfterReturPendapatan);
			$grandTotalReturPendapatans[] = $totalLevel4ReturPendapatan;
			$grandTotalAfterReturPendapatans[] = $totalLevel4AfterReturPendapatan;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameReturPendapatan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4ReturPendapatan.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterReturPendapatan.'</b></td>
			</tr>';
		}
	}
}*/


// Potongan Pendapatan
// pr($listCOAPotonganPenjualan);
$grandTotalPotonganPendapatans = array();
$grandTotalAfterPotonganPendapatans = array();
foreach ($listCOAPotonganPendapatan as $idPotonganPendapatan => $detailPotonganPendapatan) {
	// pr($detailPotonganPendapatan);
	if(isset($detailPotonganPendapatan['Level5']) && $detailPotonganPendapatan['Level4']) {
		list($codePotonganPendapatan, $namePotonganPendapatan) = explode('^', $detailPotonganPendapatan['Level4']);

		if(!empty($codePotonganPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePotonganPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPotonganPendapatan['Level5']) && $detailPotonganPendapatan['Level5']) {
		$debetCreditDetailPotonganPendapatans = array();
		$debetCreditDetailAfterPotonganPendapatans = array();
		foreach ($detailPotonganPendapatan['Level5'] as $dataCOAPotonganPendapatan) {
			list($codeDetailPotonganPendapatan, $nameDetailPotonganPendapatan, $debetCreditDetailPotonganPendapatan, $debetCreditDetailAfterPotonganPendapatan, $beginningBalanceDetailPotonganPendapatan, $subTotalDetailPotonganPendapatan, $subTotalDetailAfterPotonganPendapatan) = explode('^', $dataCOAPotonganPendapatan);
			$debetCreditDetailPotonganPendapatans[] = $debetCreditDetailPotonganPendapatan;
			$debetCreditDetailAfterPotonganPendapatans[] = $debetCreditDetailAfterPotonganPendapatan;
			$nominalDetailPotonganPendapatan = $this->Krs->cur($debetCreditDetailPotonganPendapatan);
			$nominalDetailAfterPotonganPendapatan = $this->Krs->cur($debetCreditDetailAfterPotonganPendapatan);

			echo '<tr>
					<td>('.$codeDetailPotonganPendapatan.') '.$nameDetailPotonganPendapatan.'</td>
					<td align="right">'.$nominalDetailPotonganPendapatan.'</td>
					<td align="right">'.$nominalDetailAfterPotonganPendapatan.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailPotonganPendapatan['Level5']) && $detailPotonganPendapatan['Level4']) {
		list($codePotonganPendapatan, $namePotonganPendapatan) = explode('^', $detailPotonganPendapatan['Level4']);

		if(!empty($codePotonganPendapatan)) {
			$totalLevel4PotonganPendapatan = array_sum($debetCreditDetailPotonganPendapatans);
			$totalLevel4AfterPotonganPendapatan = array_sum($debetCreditDetailAfterPotonganPendapatans);
			$nominalTotalLevel4PotonganPendapatan = $this->Krs->cur($totalLevel4PotonganPendapatan);
			$nominalTotalLevel4AfterPotonganPendapatan = $this->Krs->cur($totalLevel4AfterPotonganPendapatan);
			$grandTotalPotonganPendapatans[] = $totalLevel4PotonganPendapatan;
			$grandTotalAfterPotonganPendapatans[] = $totalLevel4AfterPotonganPendapatan;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePotonganPendapatan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PotonganPendapatan.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterPotonganPendapatan.'</b></td>
			</tr>';
		}
	}
}

// PENDAPATAN BERSIH
$grandTotalPendapatan = (empty($grandTotalPendapatans)) ? 0 : round(array_sum($grandTotalPendapatans),2);
$grandTotalAfterPendapatan = (empty($grandTotalAfterPendapatans)) ? 0 : round(array_sum($grandTotalAfterPendapatans),2);

$grandTotalReturPendapatan = (empty($grandTotalReturPendapatans)) ? 0 : round(array_sum($grandTotalReturPendapatans),2);
$grandTotalAfterReturPendapatan = (empty($grandTotalAfterReturPendapatans)) ? 0 : round(array_sum($grandTotalAfterReturPendapatans),2);

$grandTotalPotonganPendapatan = (empty($grandTotalPotonganPendapatans)) ? 0 : round(array_sum($grandTotalPotonganPendapatans),2);
$grandTotalAfterPotonganPendapatan = (empty($grandTotalAfterPotonganPendapatans)) ? 0 : round(array_sum($grandTotalAfterPotonganPendapatans),2);

$totalPendapatanBersih = $grandTotalPendapatan-($grandTotalReturPendapatan+$grandTotalPotonganPendapatan);
$totalPendapatanBersihAfter = $grandTotalAfterPendapatan-($grandTotalAfterReturPendapatan+$grandTotalAfterPotonganPendapatan);

if(!empty($totalPendapatanBersih) || !empty($totalPendapatanBersihAfter)) {
	echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL PENDAPATAN BERSIH</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalPendapatanBersih).'</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalPendapatanBersihAfter).'</b></td>
	</tr>';
}


// Beban Pokok Pendapatan
$grandTotalBebanPokokPendapatans = array();
$grandTotalAfterBebanPokokPendapatans = array();
foreach ($listCOABebanPokokPendapatan as $idBebanPokokPendapatan => $detailBebanPokokPendapatan) {
 	
 	if(isset($detailBebanPokokPendapatan['Level5']) && $detailBebanPokokPendapatan['Level4']) {
		list($codeBebanPokokPendapatan, $nameBebanPokokPendapatan) = explode('^', $detailBebanPokokPendapatan['Level4']);

		if(!empty($codeBebanPokokPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanPokokPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanPokokPendapatan['Level5']) && $detailBebanPokokPendapatan['Level5']) {
		$debetCreditDetailBebanPokokPendapatans = array();
		$debetCreditDetailAfterBebanPokokPendapatans = array();
		foreach ($detailBebanPokokPendapatan['Level5'] as $dataCOABebanPokokPendapatan) {
			list($codeDetailBebanPokokPendapatan, $nameDetailBebanPokokPendapatan, $debetCreditDetailBebanPokokPendapatan, $debetCreditDetailAfterBebanPokokPendapatan, $beginningBalanceDetailBebanPokokPendapatan, $subTotalDetailBebanPokokPendapatan, $subTotalDetailAfterBebanPokokPendapatan) = explode('^', $dataCOABebanPokokPendapatan);
			$debetCreditDetailBebanPokokPendapatans[] = $debetCreditDetailBebanPokokPendapatan;
			$debetCreditDetailAfterBebanPokokPendapatans[] = $debetCreditDetailAfterBebanPokokPendapatan;
			$nominalDetailBebanPokokPendapatan = $this->Krs->cur($debetCreditDetailBebanPokokPendapatan);
			$nominalDetailAfterBebanPokokPendapatan = $this->Krs->cur($debetCreditDetailAfterBebanPokokPendapatan);

			echo '<tr>
					<td>('.$codeDetailBebanPokokPendapatan.') '.$nameDetailBebanPokokPendapatan.'</td>
					<td align="right">'.$nominalDetailBebanPokokPendapatan.'</td>
					<td align="right">'.$nominalDetailAfterBebanPokokPendapatan.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailBebanPokokPendapatan['Level5']) && $detailBebanPokokPendapatan['Level4']) {
		list($codeBebanPokokPendapatan, $nameBebanPokokPendapatan) = explode('^', $detailBebanPokokPendapatan['Level4']);

		if(!empty($codeBebanPokokPendapatan)) {
			$totalLevel4BebanPokokPendapatan = array_sum($debetCreditDetailBebanPokokPendapatans);
			$totalLevel4AfterBebanPokokPendapatan = array_sum($debetCreditDetailAfterBebanPokokPendapatans);
			$nominalTotalLevel4BebanPokokPendapatan = $this->Krs->cur($totalLevel4BebanPokokPendapatan);
			$nominalTotalLevel4AfterBebanPokokPendapatan = $this->Krs->cur($totalLevel4AfterBebanPokokPendapatan);
			$grandTotalBebanPokokPendapatans[] = $totalLevel4BebanPokokPendapatan;
			$grandTotalAfterBebanPokokPendapatans[] = $totalLevel4AfterBebanPokokPendapatan;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanPokokPendapatan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4BebanPokokPendapatan.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterBebanPokokPendapatan.'</b></td>
			</tr>';
		}
	}
}

//LABA KOTOR
$grandTotalBebanPokokPendapatan = (empty($grandTotalBebanPokokPendapatans)) ? 0 : round(array_sum($grandTotalBebanPokokPendapatans),2);
$grandTotalAfterBebanPokokPendapatan = (empty($grandTotalAfterBebanPokokPendapatans)) ? 0 : round(array_sum($grandTotalAfterBebanPokokPendapatans),2);

$totalLabaKotor = $totalPendapatanBersih-$grandTotalBebanPokokPendapatan;
$totalLabaKotorAfter = $totalPendapatanBersihAfter-$grandTotalAfterBebanPokokPendapatan;

if(!empty($totalLabaKotor) || !empty($totalLabaKotorAfter)) {
	echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA KOTOR</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalLabaKotor).'</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalLabaKotorAfter).'</b></td>
	</tr>';
}


// Beban Pendapatan
$grandTotalBebanPendapatans = array();
$grandTotalAfterBebanPendapatans = array();
foreach ($listCOABebanPendapatan as $idBebanPendapatan => $detailBebanPendapatan) {
 	
	if(isset($detailBebanPendapatan['Level5']) && $detailBebanPendapatan['Level4']) {
		list($codeBebanPendapatan, $nameBebanPendapatan) = explode('^', $detailBebanPendapatan['Level4']);

		if(!empty($codeBebanPendapatan)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanPendapatan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanPendapatan['Level5']) && $detailBebanPendapatan['Level5']) {
		$debetCreditDetailBebanPendapatans = array();
		$debetCreditDetailAfterBebanPendapatans = array();
		foreach ($detailBebanPendapatan['Level5'] as $dataCOABebanPendapatan) {
			list($codeDetailBebanPendapatan, $nameDetailBebanPendapatan, $debetCreditDetailBebanPendapatan, $debetCreditDetailAfterBebanPendapatan, $beginningBalanceDetailBebanPendapatan, $subTotalDetailBebanPendapatan, $subTotalDetailAfterBebanPendapatan) = explode('^', $dataCOABebanPendapatan);
			$debetCreditDetailBebanPendapatans[] = $debetCreditDetailBebanPendapatan;
			$debetCreditDetailAfterBebanPendapatans[] = $debetCreditDetailAfterBebanPendapatan;
			$nominalDetailBebanPendapatan = $this->Krs->cur($debetCreditDetailBebanPendapatan);
			$nominalDetailAfterBebanPendapatan = $this->Krs->cur($debetCreditDetailAfterBebanPendapatan);

			echo '<tr>
					<td>('.$codeDetailBebanPendapatan.') '.$nameDetailBebanPendapatan.'</td>
					<td align="right">'.$nominalDetailBebanPendapatan.'</td>
					<td align="right">'.$nominalDetailAfterBebanPendapatan.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailBebanPendapatan['Level5']) && $detailBebanPendapatan['Level4']) {
		list($codeBebanPendapatan, $nameBebanPendapatan) = explode('^', $detailBebanPendapatan['Level4']);

		if(!empty($codeBebanPendapatan)) {
			$totalLevel4BebanPendapatan = array_sum($debetCreditDetailBebanPendapatans);
			$totalLevel4AfterBebanPendapatan = array_sum($debetCreditDetailAfterBebanPendapatans);
			$nominalTotalLevel4BebanPendapatan = $this->Krs->cur($totalLevel4BebanPendapatan);
			$nominalTotalLevel4AfterBebanPendapatan = $this->Krs->cur($totalLevel4AfterBebanPendapatan);
			$grandTotalBebanPendapatans[] = $totalLevel4BebanPendapatan;
			$grandTotalAfterBebanPendapatans[] = $totalLevel4AfterBebanPendapatan;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanPendapatan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4BebanPendapatan.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterBebanPendapatan.'</b></td>
			</tr>';
		}
	}
}


// Beban Administrasi Umum
$grandTotalBebanAdministrasiUmums = array();
$grandTotalAfterBebanAdministrasiUmums = array();
foreach ($listCOABebanAdministrasiUmum as $idBebanAdministrasiUmum => $detailBebanAdministrasiUmum) {
 	
	if(isset($detailBebanAdministrasiUmum['Level5']) && $detailBebanAdministrasiUmum['Level4']) {
		list($codeBebanAdministrasiUmum, $nameBebanAdministrasiUmum) = explode('^', $detailBebanAdministrasiUmum['Level4']);

		if(!empty($codeBebanAdministrasiUmum)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanAdministrasiUmum).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanAdministrasiUmum['Level5']) && $detailBebanAdministrasiUmum['Level5']) {
		$debetCreditDetailBebanAdministrasiUmums = array();
		$debetCreditDetailAfterBebanAdministrasiUmums = array();
		foreach ($detailBebanAdministrasiUmum['Level5'] as $dataCOABebanAdministrasiUmum) {
			list($codeDetailBebanAdministrasiUmum, $nameDetailBebanAdministrasiUmum, $debetCreditDetailBebanAdministrasiUmum, $debetCreditDetailAfterBebanAdministrasiUmum, $beginningBalanceDetailBebanAdministrasiUmum, $subTotalDetailBebanAdministrasiUmum, $subTotalDetailAfterBebanAdministrasiUmum) = explode('^', $dataCOABebanAdministrasiUmum);
			$debetCreditDetailBebanAdministrasiUmums[] = $debetCreditDetailBebanAdministrasiUmum;
			$debetCreditDetailAfterBebanAdministrasiUmums[] = $debetCreditDetailAfterBebanAdministrasiUmum;
			$nominalDetailBebanAdministrasiUmum = $this->Krs->cur($debetCreditDetailBebanAdministrasiUmum);
			$nominalDetailAfterBebanAdministrasiUmum = $this->Krs->cur($debetCreditDetailAfterBebanAdministrasiUmum);

			echo '<tr>
					<td>('.$codeDetailBebanAdministrasiUmum.') '.$nameDetailBebanAdministrasiUmum.'</td>
					<td align="right">'.$nominalDetailBebanAdministrasiUmum.'</td>
					<td align="right">'.$nominalDetailAfterBebanAdministrasiUmum.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailBebanAdministrasiUmum['Level5']) && $detailBebanAdministrasiUmum['Level4']) {
		list($codeBebanAdministrasiUmum, $nameBebanAdministrasiUmum) = explode('^', $detailBebanAdministrasiUmum['Level4']);

		if(!empty($codeBebanAdministrasiUmum)) {
			$totalLevel4BebanAdministrasiUmum = array_sum($debetCreditDetailBebanAdministrasiUmums);
			$totalLevel4AfterBebanAdministrasiUmum = array_sum($debetCreditDetailAfterBebanAdministrasiUmums);
			$nominalTotalLevel4BebanAdministrasiUmum = $this->Krs->cur($totalLevel4BebanAdministrasiUmum);
			$nominalTotalLevel4AfterBebanAdministrasiUmum = $this->Krs->cur($totalLevel4AfterBebanAdministrasiUmum);
			$grandTotalBebanAdministrasiUmums[] = $totalLevel4BebanAdministrasiUmum;
			$grandTotalAfterBebanAdministrasiUmums[] = $totalLevel4AfterBebanAdministrasiUmum;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanAdministrasiUmum).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4BebanAdministrasiUmum.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterBebanAdministrasiUmum.'</b></td>
			</tr>';
		}
	}
}


// LABA OPERASIONAL
$grandTotalBebanPendapatan = (empty($grandTotalBebanPendapatans)) ? 0 : round(array_sum($grandTotalBebanPendapatans),2);
$grandTotalAfterBebanPendapatan = (empty($grandTotalAfterBebanPendapatans)) ? 0 : round(array_sum($grandTotalAfterBebanPendapatans),2);

$grandTotalBebanAdministrasiUmum = (empty($grandTotalBebanAdministrasiUmums)) ? 0 : round(array_sum($grandTotalBebanAdministrasiUmums),2);
$grandTotalAfterBebanAdministrasiUmum = (empty($grandTotalAfterBebanAdministrasiUmums)) ? 0 : round(array_sum($grandTotalAfterBebanAdministrasiUmums),2);

$totalLabaOperasional = $totalLabaKotor-($grandTotalBebanPendapatan+$grandTotalBebanAdministrasiUmum);
$totalLabaOperasionalAfter = $totalLabaKotorAfter-($grandTotalAfterBebanPendapatan+$grandTotalAfterBebanAdministrasiUmum);

if(!empty($totalLabaOperasional) || !empty($totalLabaOperasionalAfter)) {
	echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA OPERASIONAL</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalLabaOperasional).'</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalLabaOperasionalAfter).'</b></td>
	</tr>';
}

// Pendapatan Non Operasional
// pr($listCOAPendapatanNonOperasional);
$grandTotalPendapatanNonOperasionals = array();
$grandTotalAfterPendapatanNonOperasionals = array();
foreach ($listCOAPendapatanNonOperasional as $idPendapatanNonOperasional => $detailPendapatanNonOperasional) {
 	
	if(isset($detailPendapatanNonOperasional['Level5']) && $detailPendapatanNonOperasional['Level4']) {
		list($codePendapatanNonOperasional, $namePendapatanNonOperasional) = explode('^', $detailPendapatanNonOperasional['Level4']);

		if(!empty($codePendapatanNonOperasional)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatanNonOperasional).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPendapatanNonOperasional['Level5']) && $detailPendapatanNonOperasional['Level5']) {
		$debetCreditDetailPendapatanNonOperasionals = array();
		$debetCreditDetailAfterPendapatanNonOperasionals = array();
		foreach ($detailPendapatanNonOperasional['Level5'] as $dataCOAPendapatanNonOperasional) {
			list($codeDetailPendapatanNonOperasional, $nameDetailPendapatanNonOperasional, $debetCreditDetailPendapatanNonOperasional, $debetCreditDetailAfterPendapatanNonOperasional, $beginningBalanceDetailPendapatanNonOperasional, $subTotalDetailPendapatanNonOperasional, $subTotalDetailAfterPendapatanNonOperasional) = explode('^', $dataCOAPendapatanNonOperasional);
			$debetCreditDetailPendapatanNonOperasionals[] = $debetCreditDetailPendapatanNonOperasional;
			$debetCreditDetailAfterPendapatanNonOperasionals[] = $debetCreditDetailAfterPendapatanNonOperasional;
			$nominalDetailPendapatanNonOperasional = $this->Krs->cur($debetCreditDetailPendapatanNonOperasional);
			$nominalDetailAfterPendapatanNonOperasional = $this->Krs->cur($debetCreditDetailAfterPendapatanNonOperasional);

			echo '<tr>
					<td>('.$codeDetailPendapatanNonOperasional.') '.$nameDetailPendapatanNonOperasional.'</td>
					<td align="right">'.$nominalDetailPendapatanNonOperasional.'</td>
					<td align="right">'.$nominalDetailAfterPendapatanNonOperasional.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailPendapatanNonOperasional['Level5']) && $detailPendapatanNonOperasional['Level4']) {
		list($codePendapatanNonOperasional, $namePendapatanNonOperasional) = explode('^', $detailPendapatanNonOperasional['Level4']);

		if(!empty($codePendapatanNonOperasional)) {
			$totalLevel4PendapatanNonOperasional = array_sum($debetCreditDetailPendapatanNonOperasionals);
			$totalLevel4AfterPendapatanNonOperasional = array_sum($debetCreditDetailAfterPendapatanNonOperasionals);
			$nominalTotalLevel4PendapatanNonOperasional = $this->Krs->cur($totalLevel4PendapatanNonOperasional);
			$nominalTotalLevel4AfterPendapatanNonOperasional = $this->Krs->cur($totalLevel4AfterPendapatanNonOperasional);
			$grandTotalPendapatanNonOperasionals[] = $totalLevel4PendapatanNonOperasional;
			$grandTotalAfterPendapatanNonOperasionals[] = $totalLevel4AfterPendapatanNonOperasional;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePendapatanNonOperasional).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PendapatanNonOperasional.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterPendapatanNonOperasional.'</b></td>
			</tr>';
		}
	}
}

// Beban Non Operasional
$grandTotalBebanNonOperasionals = array();
$grandTotalAfterBebanNonOperasionals = array();
foreach ($listCOABebanNonOperasional as $idBebanNonOperasional => $detailBebanNonOperasional) {
 	
	if(isset($detailBebanNonOperasional['Level5']) && $detailBebanNonOperasional['Level4']) {
		list($codeBebanNonOperasional, $nameBebanNonOperasional) = explode('^', $detailBebanNonOperasional['Level4']);

		if(!empty($codeBebanNonOperasional)) {
		echo '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanNonOperasional).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanNonOperasional['Level5']) && $detailBebanNonOperasional['Level5']) {
		$debetCreditDetailBebanNonOperasionals = array();
		$debetCreditDetailAfterBebanNonOperasionals = array();
		foreach ($detailBebanNonOperasional['Level5'] as $dataCOABebanNonOperasional) {
			list($codeDetailBebanNonOperasional, $nameDetailBebanNonOperasional, $debetCreditDetailBebanNonOperasional, $debetCreditDetailAfterBebanNonOperasional, $beginningBalanceDetailBebanNonOperasional, $subTotalDetailBebanNonOperasional, $subTotalDetailAfterBebanNonOperasional) = explode('^', $dataCOABebanNonOperasional);
			$debetCreditDetailBebanNonOperasionals[] = $debetCreditDetailBebanNonOperasional;
			$debetCreditDetailAfterBebanNonOperasionals[] = $debetCreditDetailAfterBebanNonOperasional;
			$nominalDetailBebanNonOperasional = $this->Krs->cur($debetCreditDetailBebanNonOperasional);
			$nominalDetailAfterBebanNonOperasional = $this->Krs->cur($debetCreditDetailAfterBebanNonOperasional);

			echo '<tr>
					<td>('.$codeDetailBebanNonOperasional.') '.$nameDetailBebanNonOperasional.'</td>
					<td align="right">'.$nominalDetailBebanNonOperasional.'</td>
					<td align="right">'.$nominalDetailAfterBebanNonOperasional.'</td>';
			echo '</tr>';
		}
	}

	if(isset($detailBebanNonOperasional['Level5']) && $detailBebanNonOperasional['Level4']) {
		list($codeBebanNonOperasional, $nameBebanNonOperasional) = explode('^', $detailBebanNonOperasional['Level4']);

		if(!empty($codeBebanNonOperasional)) {
			$totalLevel4BebanNonOperasional = array_sum($debetCreditDetailBebanNonOperasionals);
			$totalLevel4AfterBebanNonOperasional = array_sum($debetCreditDetailAfterBebanNonOperasionals);
			$nominalTotalLevel4BebanNonOperasional = $this->Krs->cur($totalLevel4BebanNonOperasional);
			$nominalTotalLevel4AfterBebanNonOperasional = $this->Krs->cur($totalLevel4AfterBebanNonOperasional);
			$grandTotalBebanNonOperasionals[] = $totalLevel4BebanNonOperasional;
			$grandTotalAfterBebanNonOperasionals[] = $totalLevel4AfterBebanNonOperasional;
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanNonOperasional).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4BebanNonOperasional.'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AfterBebanNonOperasional.'</b></td>
			</tr>';
		}
	}
}

// LABA OPERASIONAL SEBELUM PAJAK
$grandTotalPendapatanNonOperasional = (empty($grandTotalPendapatanNonOperasionals)) ? 0 : round(array_sum($grandTotalPendapatanNonOperasionals),2);
$grandTotalAfterPendapatanNonOperasional = (empty($grandTotalAfterPendapatanNonOperasionals)) ? 0 : round(array_sum($grandTotalAfterPendapatanNonOperasionals),2);

$grandTotalBebanNonOperasional = (empty($grandTotalBebanNonOperasionals)) ? 0 : round(array_sum($grandTotalBebanNonOperasionals),2);
$grandTotalAfterBebanNonOperasional = (empty($grandTotalAfterBebanNonOperasionals)) ? 0 : round(array_sum($grandTotalAfterBebanNonOperasionals),2);

$totalLabaOperasionalSebelumPajak = ($totalLabaOperasional+$grandTotalPendapatanNonOperasional)-$grandTotalBebanNonOperasional;
$totalLabaOperasionalSebelumPajakAfter = ($totalLabaOperasionalAfter+$grandTotalAfterPendapatanNonOperasional)-$grandTotalAfterBebanNonOperasional;

// Laba Besih Setelah Pajak
if(!empty($totalLabaOperasionalSebelumPajak) || !empty($totalLabaOperasionalSebelumPajakAfter)) {
	echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA BERSIH SEBELUM PAJAK</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalLabaOperasionalSebelumPajak).'</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalLabaOperasionalSebelumPajakAfter).'</b></td>
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
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'income_global_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalIncomeGlobalReportForm', 'btn-search', confirmTitle, formAction);

	handleDateRange('filterMonthYear', 'filterMonthYearReset', 'filterMY', 'mm-yyyy', 'y');
});
</script>