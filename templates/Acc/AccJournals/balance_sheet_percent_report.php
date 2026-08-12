<?= $this->Krs->breadcrumb('Accounting', 'Neraca (%)', 'Tampilkan') ?>
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
							<label class="col-form-label col-md-4">Tanggal</label>
							<div class="col-md-8">
								<div class="input-group m-b-10" id="default-daterange">
									<?php
									list($filterDate, $filterCheckGlobal) = explode('^', $this->Krs->fDecode($dataFilter));

									$date = date_create($filterDate);
									$accJournalDate = (isset($date)) ? $this->Krs->fDate($date, 'd-m-Y') : date("d-m-Y");

									$filterCheckGlobalDefault = ($filterCheckGlobal=='Y') ? array('checked'=>true) : array();

									echo $this->Form->input('filterDate', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'readonly' => true, 'value'=>$accJournalDate));
									?>									
									<div class="input-group-append">
										<span class="input-group-text">
										<?php										
										echo $this->Form->checkbox('checkGlobal', ['value' => 'Y', 'hiddenField' => 'N', $filterCheckGlobalDefault]);
										//<div class="invalid-feedback">Centang bila hasil laporan Global.</div>
										//<p class="help-block"><i id="loading-check-desc"><i class="fa fa-microphone"></i> Centang bila hasil laporan Global.</i></p>
										?> Global</span>
									</div>
									<small class="f-s-12 text-grey-darker"><i class="fa fa-bullhorn"></i><i> Centang bila hasil laporan Global.</i></small>
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
					<div class="btn-group">
						<div class="portlet-body">
							<i class="fa fa-reorder"></i><span>per-<?php 
							// pr(strval($filterDate));
							// $date = date_create($filterDate);
							//echo date_format($date, 'd M Y');
							//echo $filterDate;
							echo $this->Krs->fDate($date, 'd M Y'); ?></span>
						</div>
					</div>
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
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6">
									<div class="table-responsive">
										<table width="100%" class="table-hover" cellpadding="3" cellspacing="0" border="0">
											<tr>
												<th align="left" colspan="3">ASET</th>
											</tr>
<?php
//MENGAMBIL NILAI TOTAL AKTIVA
echo '<tr>
	<td align="left"><b>Aset Lancar</b></td>
	<td align="right">&nbsp;</td>	
</tr>';

// Aset
$grandTotalAsets = array();
foreach ($listCOAAset as $idAset => $detailAset) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada Aset
		if(isset($detailAset['Level5']) && $detailAset['Level4']) {
			list($codeAset, $nameAset) = explode('^', $detailAset['Level4']);

			if(!empty($codeAset)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameAset).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailAset['Level5']) && $detailAset['Level5']) {
		$debetCreditDetailAsets = array();
		foreach ($detailAset['Level5'] as $dataCOAAset) {
			list($codeDetailAset, $nameDetailAset, $debetCreditDetailAset, $beginningBalanceDetailAset, $subTotalDetailAset) = explode('^', $dataCOAAset);
			//$totalAsets = $debetCreditDetailAset+$beginningBalanceDetailAset;
			$debetCreditDetailAsets[] = $subTotalDetailAset;
			$nominalDetailAset = $this->Krs->cur($subTotalDetailAset);

			//$dataPercentGlobalAset = $grandTotalPercentAset/$totalPercentAktiva*100;
			//$percenAset = $subTotalDetailAset/$grandTotalPercentAset*$dataPercentGlobalAset;
			//$nominalPercenAset = $this->Krs->percent($percenAset).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailAset.') '.$nameDetailAset.'</td>
					<td align="right">'.$nominalDetailAset.'</td>
					';
					//<td align="right">'.$nominalPercenAset.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailAset['Level5']) && $detailAset['Level4']) {
		list($codeAset, $nameAset) = explode('^', $detailAset['Level4']);

		if(!empty($codeAset)) {
			$totalLevel4Aset = array_sum($debetCreditDetailAsets);
			$nominalTotalLevel4Aset = $this->Krs->cur($totalLevel4Aset);
			$grandTotalAsets[] = $totalLevel4Aset;
			//$percenAsetBank = $subTotalDetailAsetBank/$grandTotalPercentAsetBank*$dataPercentGlobalAset;
			//$percenAsetBank = 0;
			
			//Percent
			// $dataPercentGlobalAset = $totalLevel4Aset/$totalPercentAktiva*100;
			// $nominalPercenAset = $this->Krs->percent($dataPercentGlobalAset).'%';

			//$percenTotalAset = $totalLevel4Aset/$totalPercentAktiva*100;
			//$nominalGrandPercentAset = $this->Krs->percent($percenTotalAset).'%';
			$titleTotalAset = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeAset.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalAset.' '.strtoupper($nameAset).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4Aset.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenAset.'</b></td>		
		}
	}
}

// Aset Lancar
$grandTotalAsetLancars = array();
foreach ($listCOAAsetLancar as $idAsetLancar => $detailAsetLancar) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada AsetLancar
		if(isset($detailAsetLancar['Level5']) && $detailAsetLancar['Level4']) {
			list($codeAsetLancar, $nameAsetLancar) = explode('^', $detailAsetLancar['Level4']);

			if(!empty($codeAsetLancar)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameAsetLancar).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailAsetLancar['Level5']) && $detailAsetLancar['Level5']) {
		$debetCreditDetailAsetLancars = array();
		foreach ($detailAsetLancar['Level5'] as $dataCOAAsetLancar) {
			list($codeDetailAsetLancar, $nameDetailAsetLancar, $debetCreditDetailAsetLancar, $beginningBalanceDetailAsetLancar, $subTotalDetailAsetLancar) = explode('^', $dataCOAAsetLancar);
			//$totalAsetLancars = $debetCreditDetailAsetLancar+$beginningBalanceDetailAsetLancar;
			$debetCreditDetailAsetLancars[] = $subTotalDetailAsetLancar;
			$nominalDetailAsetLancar = $this->Krs->cur($subTotalDetailAsetLancar);

			//$dataPercentGlobalAsetLancar = $grandTotalPercentAsetLancar/$totalPercentAktiva*100;
			//$percenAsetLancar = $subTotalDetailAsetLancar/$grandTotalPercentAsetLancar*$dataPercentGlobalAsetLancar;
			//$nominalPercenAsetLancar = $this->Krs->percent($percenAsetLancar).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailAsetLancar.') '.$nameDetailAsetLancar.'</td>
					<td align="right">'.$nominalDetailAsetLancar.'</td>
					';
					//<td align="right">'.$nominalPercenAsetLancar.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailAsetLancar['Level5']) && $detailAsetLancar['Level4']) {
		list($codeAsetLancar, $nameAsetLancar) = explode('^', $detailAsetLancar['Level4']);

		if(!empty($codeAsetLancar)) {
			$totalLevel4AsetLancar = array_sum($debetCreditDetailAsetLancars);
			$nominalTotalLevel4AsetLancar = $this->Krs->cur($totalLevel4AsetLancar);
			$grandTotalAsetLancars[] = $totalLevel4AsetLancar;
			//$percenAsetLancarBank = $subTotalDetailAsetLancarBank/$grandTotalPercentAsetLancarBank*$dataPercentGlobalAsetLancar;
			//$percenAsetLancarBank = 0;
			
			//Percent
			// $dataPercentGlobalAsetLancar = $totalLevel4AsetLancar/$totalPercentAktiva*100;
			// $nominalPercenAsetLancar = $this->Krs->percent($dataPercentGlobalAsetLancar).'%';

			//$percenTotalAsetLancar = $totalLevel4AsetLancar/$totalPercentAktiva*100;
			//$nominalGrandPercentAsetLancar = $this->Krs->percent($percenTotalAsetLancar).'%';
			$titleTotalAsetLancar = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeAsetLancar.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalAsetLancar.' '.strtoupper($nameAsetLancar).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AsetLancar.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenAsetLancar.'</b></td>		
		}
	}
}

// Kas Setara Kas
$grandTotalKasSetaraKass = array();
foreach ($listCOAKasSetaraKas as $idKasSetaraKas => $detailKasSetaraKas) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada KasSetaraKas
		if(isset($detailKasSetaraKas['Level5']) && $detailKasSetaraKas['Level4']) {
			list($codeKasSetaraKas, $nameKasSetaraKas) = explode('^', $detailKasSetaraKas['Level4']);

			if(!empty($codeKasSetaraKas)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameKasSetaraKas).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailKasSetaraKas['Level5']) && $detailKasSetaraKas['Level5']) {
		$debetCreditDetailKasSetaraKass = array();
		foreach ($detailKasSetaraKas['Level5'] as $dataCOAKasSetaraKas) {
			list($codeDetailKasSetaraKas, $nameDetailKasSetaraKas, $debetCreditDetailKasSetaraKas, $beginningBalanceDetailKasSetaraKas, $subTotalDetailKasSetaraKas) = explode('^', $dataCOAKasSetaraKas);
			//$totalKasSetaraKass = $debetCreditDetailKasSetaraKas+$beginningBalanceDetailKasSetaraKas;
			$debetCreditDetailKasSetaraKass[] = $subTotalDetailKasSetaraKas;
			$nominalDetailKasSetaraKas = $this->Krs->cur($subTotalDetailKasSetaraKas);

			//$dataPercentGlobalKasSetaraKas = $grandTotalPercentKasSetaraKas/$totalPercentAktiva*100;
			//$percenKasSetaraKas = $subTotalDetailKasSetaraKas/$grandTotalPercentKasSetaraKas*$dataPercentGlobalKasSetaraKas;
			//$nominalPercenKasSetaraKas = $this->Krs->percent($percenKasSetaraKas).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailKasSetaraKas.') '.$nameDetailKasSetaraKas.'</td>
					<td align="right">'.$nominalDetailKasSetaraKas.'</td>
					';
					//<td align="right">'.$nominalPercenKasSetaraKas.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailKasSetaraKas['Level5']) && $detailKasSetaraKas['Level4']) {
		list($codeKasSetaraKas, $nameKasSetaraKas) = explode('^', $detailKasSetaraKas['Level4']);

		if(!empty($codeKasSetaraKas)) {
			$totalLevel4KasSetaraKas = array_sum($debetCreditDetailKasSetaraKass);
			$nominalTotalLevel4KasSetaraKas = $this->Krs->cur($totalLevel4KasSetaraKas);
			$grandTotalKasSetaraKass[] = $totalLevel4KasSetaraKas;
			//$percenKasSetaraKasBank = $subTotalDetailKasSetaraKasBank/$grandTotalPercentKasSetaraKasBank*$dataPercentGlobalKasSetaraKas;
			//$percenKasSetaraKasBank = 0;
			
			//Percent
			// $dataPercentGlobalKasSetaraKas = $totalLevel4KasSetaraKas/$totalPercentAktiva*100;
			// $nominalPercenKasSetaraKas = $this->Krs->percent($dataPercentGlobalKasSetaraKas).'%';

			//$percenTotalKasSetaraKas = $totalLevel4KasSetaraKas/$totalPercentAktiva*100;
			//$nominalGrandPercentKasSetaraKas = $this->Krs->percent($percenTotalKasSetaraKas).'%';
			$titleTotalKasSetaraKas = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeKasSetaraKas.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalKasSetaraKas.' '.strtoupper($nameKasSetaraKas).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4KasSetaraKas.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenKasSetaraKas.'</b></td>		
		}
	}
}

// Investasi
$grandTotalInvestasis = array();
foreach ($listCOAInvestasi as $idInvestasi => $detailInvestasi) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada Investasi
		if(isset($detailInvestasi['Level5']) && $detailInvestasi['Level4']) {
			list($codeInvestasi, $nameInvestasi) = explode('^', $detailInvestasi['Level4']);

			if(!empty($codeInvestasi)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameInvestasi).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailInvestasi['Level5']) && $detailInvestasi['Level5']) {
		$debetCreditDetailInvestasis = array();
		foreach ($detailInvestasi['Level5'] as $dataCOAInvestasi) {
			list($codeDetailInvestasi, $nameDetailInvestasi, $debetCreditDetailInvestasi, $beginningBalanceDetailInvestasi, $subTotalDetailInvestasi) = explode('^', $dataCOAInvestasi);
			//$totalInvestasis = $debetCreditDetailInvestasi+$beginningBalanceDetailInvestasi;
			$debetCreditDetailInvestasis[] = $subTotalDetailInvestasi;
			$nominalDetailInvestasi = $this->Krs->cur($subTotalDetailInvestasi);

			//$dataPercentGlobalInvestasi = $grandTotalPercentInvestasi/$totalPercentAktiva*100;
			//$percenInvestasi = $subTotalDetailInvestasi/$grandTotalPercentInvestasi*$dataPercentGlobalInvestasi;
			//$nominalPercenInvestasi = $this->Krs->percent($percenInvestasi).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailInvestasi.') '.$nameDetailInvestasi.'</td>
					<td align="right">'.$nominalDetailInvestasi.'</td>
					';
					//<td align="right">'.$nominalPercenInvestasi.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailInvestasi['Level5']) && $detailInvestasi['Level4']) {
		list($codeInvestasi, $nameInvestasi) = explode('^', $detailInvestasi['Level4']);

		if(!empty($codeInvestasi)) {
			$totalLevel4Investasi = array_sum($debetCreditDetailInvestasis);
			$nominalTotalLevel4Investasi = $this->Krs->cur($totalLevel4Investasi);
			$grandTotalInvestasis[] = $totalLevel4Investasi;
			//$percenInvestasiBank = $subTotalDetailInvestasiBank/$grandTotalPercentInvestasiBank*$dataPercentGlobalInvestasi;
			//$percenInvestasiBank = 0;
			
			//Percent
			// $dataPercentGlobalInvestasi = $totalLevel4Investasi/$totalPercentAktiva*100;
			// $nominalPercenInvestasi = $this->Krs->percent($dataPercentGlobalInvestasi).'%';

			//$percenTotalInvestasi = $totalLevel4Investasi/$totalPercentAktiva*100;
			//$nominalGrandPercentInvestasi = $this->Krs->percent($percenTotalInvestasi).'%';
			$titleTotalInvestasi = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeInvestasi.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalInvestasi.' '.strtoupper($nameInvestasi).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4Investasi.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenInvestasi.'</b></td>		
		}
	}
}


// Piutang
$grandTotalPiutangs = array();
foreach ($listCOAPiutang as $idPiutang => $detailPiutang) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada Piutang
		if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
			list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

			if(!empty($codePiutang)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePiutang).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPiutang['Level5']) && $detailPiutang['Level5']) {
		$debetCreditDetailPiutangs = array();
		foreach ($detailPiutang['Level5'] as $dataCOAPiutang) {
			list($codeDetailPiutang, $nameDetailPiutang, $debetCreditDetailPiutang, $beginningBalanceDetailPiutang, $subTotalDetailPiutang) = explode('^', $dataCOAPiutang);
			//$totalPiutangs = $debetCreditDetailPiutang+$beginningBalanceDetailPiutang;
			$debetCreditDetailPiutangs[] = $subTotalDetailPiutang;
			$nominalDetailPiutang = $this->Krs->cur($subTotalDetailPiutang);

			//$dataPercentGlobalPiutang = $grandTotalPercentPiutang/$totalPercentAktiva*100;
			//$percenPiutang = $subTotalDetailPiutang/$grandTotalPercentPiutang*$dataPercentGlobalPiutang;
			//$nominalPercenPiutang = $this->Krs->percent($percenPiutang).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPiutang.') '.$nameDetailPiutang.'</td>
					<td align="right">'.$nominalDetailPiutang.'</td>
					';
					//<td align="right">'.$nominalPercenPiutang.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
		list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

		if(!empty($codePiutang)) {
			$totalLevel4Piutang = array_sum($debetCreditDetailPiutangs);
			$nominalTotalLevel4Piutang = $this->Krs->cur($totalLevel4Piutang);
			$grandTotalPiutangs[] = $totalLevel4Piutang;
			//$percenPiutangBank = $subTotalDetailPiutangBank/$grandTotalPercentPiutangBank*$dataPercentGlobalPiutang;
			//$percenPiutangBank = 0;
			
			//Percent
			// $dataPercentGlobalPiutang = $totalLevel4Piutang/$totalPercentAktiva*100;
			// $nominalPercenPiutang = $this->Krs->percent($dataPercentGlobalPiutang).'%';

			//$percenTotalPiutang = $totalLevel4Piutang/$totalPercentAktiva*100;
			//$nominalGrandPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';
			$titleTotalPiutang = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePiutang.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPiutang.' '.strtoupper($namePiutang).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4Piutang.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPiutang.'</b></td>		
		}
	}
}


// PiutangPemegangSaham
$grandTotalPiutangPemegangSahams = array();
foreach ($listCOAPiutangPemegangSaham as $idPiutangPemegangSaham => $detailPiutangPemegangSaham) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PiutangPemegangSaham
		if(isset($detailPiutangPemegangSaham['Level5']) && $detailPiutangPemegangSaham['Level4']) {
			list($codePiutangPemegangSaham, $namePiutangPemegangSaham) = explode('^', $detailPiutangPemegangSaham['Level4']);

			if(!empty($codePiutangPemegangSaham)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePiutangPemegangSaham).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPiutangPemegangSaham['Level5']) && $detailPiutangPemegangSaham['Level5']) {
		$debetCreditDetailPiutangPemegangSahams = array();
		foreach ($detailPiutangPemegangSaham['Level5'] as $dataCOAPiutangPemegangSaham) {
			list($codeDetailPiutangPemegangSaham, $nameDetailPiutangPemegangSaham, $debetCreditDetailPiutangPemegangSaham, $beginningBalanceDetailPiutangPemegangSaham, $subTotalDetailPiutangPemegangSaham) = explode('^', $dataCOAPiutangPemegangSaham);
			//$totalPiutangPemegangSahams = $debetCreditDetailPiutangPemegangSaham+$beginningBalanceDetailPiutangPemegangSaham;
			$debetCreditDetailPiutangPemegangSahams[] = $subTotalDetailPiutangPemegangSaham;
			$nominalDetailPiutangPemegangSaham = $this->Krs->cur($subTotalDetailPiutangPemegangSaham);

			//$dataPercentGlobalPiutangPemegangSaham = $grandTotalPercentPiutangPemegangSaham/$totalPercentAktiva*100;
			//$percenPiutangPemegangSaham = $subTotalDetailPiutangPemegangSaham/$grandTotalPercentPiutangPemegangSaham*$dataPercentGlobalPiutangPemegangSaham;
			//$nominalPercenPiutangPemegangSaham = $this->Krs->percent($percenPiutangPemegangSaham).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPiutangPemegangSaham.') '.$nameDetailPiutangPemegangSaham.'</td>
					<td align="right">'.$nominalDetailPiutangPemegangSaham.'</td>
					';
					//<td align="right">'.$nominalPercenPiutangPemegangSaham.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPiutangPemegangSaham['Level5']) && $detailPiutangPemegangSaham['Level4']) {
		list($codePiutangPemegangSaham, $namePiutangPemegangSaham) = explode('^', $detailPiutangPemegangSaham['Level4']);

		if(!empty($codePiutangPemegangSaham)) {
			$totalLevel4PiutangPemegangSaham = array_sum($debetCreditDetailPiutangPemegangSahams);
			$nominalTotalLevel4PiutangPemegangSaham = $this->Krs->cur($totalLevel4PiutangPemegangSaham);
			$grandTotalPiutangPemegangSahams[] = $totalLevel4PiutangPemegangSaham;
			//$percenPiutangPemegangSahamBank = $subTotalDetailPiutangPemegangSahamBank/$grandTotalPercentPiutangPemegangSahamBank*$dataPercentGlobalPiutangPemegangSaham;
			//$percenPiutangPemegangSahamBank = 0;
			
			//Percent
			// $dataPercentGlobalPiutangPemegangSaham = $totalLevel4PiutangPemegangSaham/$totalPercentAktiva*100;
			// $nominalPercenPiutangPemegangSaham = $this->Krs->percent($dataPercentGlobalPiutangPemegangSaham).'%';

			//$percenTotalPiutangPemegangSaham = $totalLevel4PiutangPemegangSaham/$totalPercentAktiva*100;
			//$nominalGrandPercentPiutangPemegangSaham = $this->Krs->percent($percenTotalPiutangPemegangSaham).'%';
			$titleTotalPiutangPemegangSaham = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePiutangPemegangSaham.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPiutangPemegangSaham.' '.strtoupper($namePiutangPemegangSaham).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PiutangPemegangSaham.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPiutangPemegangSaham.'</b></td>		
		}
	}
}


// PiutangAfiliasi
$grandTotalPiutangAfiliasis = array();
foreach ($listCOAPiutangAfiliasi as $idPiutangAfiliasi => $detailPiutangAfiliasi) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PiutangAfiliasi
		if(isset($detailPiutangAfiliasi['Level5']) && $detailPiutangAfiliasi['Level4']) {
			list($codePiutangAfiliasi, $namePiutangAfiliasi) = explode('^', $detailPiutangAfiliasi['Level4']);

			if(!empty($codePiutangAfiliasi)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePiutangAfiliasi).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPiutangAfiliasi['Level5']) && $detailPiutangAfiliasi['Level5']) {
		$debetCreditDetailPiutangAfiliasis = array();
		foreach ($detailPiutangAfiliasi['Level5'] as $dataCOAPiutangAfiliasi) {
			list($codeDetailPiutangAfiliasi, $nameDetailPiutangAfiliasi, $debetCreditDetailPiutangAfiliasi, $beginningBalanceDetailPiutangAfiliasi, $subTotalDetailPiutangAfiliasi) = explode('^', $dataCOAPiutangAfiliasi);
			//$totalPiutangAfiliasis = $debetCreditDetailPiutangAfiliasi+$beginningBalanceDetailPiutangAfiliasi;
			$debetCreditDetailPiutangAfiliasis[] = $subTotalDetailPiutangAfiliasi;
			$nominalDetailPiutangAfiliasi = $this->Krs->cur($subTotalDetailPiutangAfiliasi);

			//$dataPercentGlobalPiutangAfiliasi = $grandTotalPercentPiutangAfiliasi/$totalPercentAktiva*100;
			//$percenPiutangAfiliasi = $subTotalDetailPiutangAfiliasi/$grandTotalPercentPiutangAfiliasi*$dataPercentGlobalPiutangAfiliasi;
			//$nominalPercenPiutangAfiliasi = $this->Krs->percent($percenPiutangAfiliasi).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPiutangAfiliasi.') '.$nameDetailPiutangAfiliasi.'</td>
					<td align="right">'.$nominalDetailPiutangAfiliasi.'</td>
					';
					//<td align="right">'.$nominalPercenPiutangAfiliasi.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPiutangAfiliasi['Level5']) && $detailPiutangAfiliasi['Level4']) {
		list($codePiutangAfiliasi, $namePiutangAfiliasi) = explode('^', $detailPiutangAfiliasi['Level4']);

		if(!empty($codePiutangAfiliasi)) {
			$totalLevel4PiutangAfiliasi = array_sum($debetCreditDetailPiutangAfiliasis);
			$nominalTotalLevel4PiutangAfiliasi = $this->Krs->cur($totalLevel4PiutangAfiliasi);
			$grandTotalPiutangAfiliasis[] = $totalLevel4PiutangAfiliasi;
			//$percenPiutangAfiliasiBank = $subTotalDetailPiutangAfiliasiBank/$grandTotalPercentPiutangAfiliasiBank*$dataPercentGlobalPiutangAfiliasi;
			//$percenPiutangAfiliasiBank = 0;
			
			//Percent
			// $dataPercentGlobalPiutangAfiliasi = $totalLevel4PiutangAfiliasi/$totalPercentAktiva*100;
			// $nominalPercenPiutangAfiliasi = $this->Krs->percent($dataPercentGlobalPiutangAfiliasi).'%';

			//$percenTotalPiutangAfiliasi = $totalLevel4PiutangAfiliasi/$totalPercentAktiva*100;
			//$nominalGrandPercentPiutangAfiliasi = $this->Krs->percent($percenTotalPiutangAfiliasi).'%';
			$titleTotalPiutangAfiliasi = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePiutangAfiliasi.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPiutangAfiliasi.' '.strtoupper($namePiutangAfiliasi).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PiutangAfiliasi.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPiutangAfiliasi.'</b></td>		
		}
	}
}


// PiutangKaryawan
$grandTotalPiutangKaryawans = array();
foreach ($listCOAPiutangKaryawan as $idPiutangKaryawan => $detailPiutangKaryawan) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PiutangKaryawan
		if(isset($detailPiutangKaryawan['Level5']) && $detailPiutangKaryawan['Level4']) {
			list($codePiutangKaryawan, $namePiutangKaryawan) = explode('^', $detailPiutangKaryawan['Level4']);

			if(!empty($codePiutangKaryawan)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePiutangKaryawan).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPiutangKaryawan['Level5']) && $detailPiutangKaryawan['Level5']) {
		$debetCreditDetailPiutangKaryawans = array();
		foreach ($detailPiutangKaryawan['Level5'] as $dataCOAPiutangKaryawan) {
			list($codeDetailPiutangKaryawan, $nameDetailPiutangKaryawan, $debetCreditDetailPiutangKaryawan, $beginningBalanceDetailPiutangKaryawan, $subTotalDetailPiutangKaryawan) = explode('^', $dataCOAPiutangKaryawan);
			//$totalPiutangKaryawans = $debetCreditDetailPiutangKaryawan+$beginningBalanceDetailPiutangKaryawan;
			$debetCreditDetailPiutangKaryawans[] = $subTotalDetailPiutangKaryawan;
			$nominalDetailPiutangKaryawan = $this->Krs->cur($subTotalDetailPiutangKaryawan);

			//$dataPercentGlobalPiutangKaryawan = $grandTotalPercentPiutangKaryawan/$totalPercentAktiva*100;
			//$percenPiutangKaryawan = $subTotalDetailPiutangKaryawan/$grandTotalPercentPiutangKaryawan*$dataPercentGlobalPiutangKaryawan;
			//$nominalPercenPiutangKaryawan = $this->Krs->percent($percenPiutangKaryawan).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPiutangKaryawan.') '.$nameDetailPiutangKaryawan.'</td>
					<td align="right">'.$nominalDetailPiutangKaryawan.'</td>
					';
					//<td align="right">'.$nominalPercenPiutangKaryawan.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPiutangKaryawan['Level5']) && $detailPiutangKaryawan['Level4']) {
		list($codePiutangKaryawan, $namePiutangKaryawan) = explode('^', $detailPiutangKaryawan['Level4']);

		if(!empty($codePiutangKaryawan)) {
			$totalLevel4PiutangKaryawan = array_sum($debetCreditDetailPiutangKaryawans);
			$nominalTotalLevel4PiutangKaryawan = $this->Krs->cur($totalLevel4PiutangKaryawan);
			$grandTotalPiutangKaryawans[] = $totalLevel4PiutangKaryawan;
			//$percenPiutangKaryawanBank = $subTotalDetailPiutangKaryawanBank/$grandTotalPercentPiutangKaryawanBank*$dataPercentGlobalPiutangKaryawan;
			//$percenPiutangKaryawanBank = 0;
			
			//Percent
			// $dataPercentGlobalPiutangKaryawan = $totalLevel4PiutangKaryawan/$totalPercentAktiva*100;
			// $nominalPercenPiutangKaryawan = $this->Krs->percent($dataPercentGlobalPiutangKaryawan).'%';

			//$percenTotalPiutangKaryawan = $totalLevel4PiutangKaryawan/$totalPercentAktiva*100;
			//$nominalGrandPercentPiutangKaryawan = $this->Krs->percent($percenTotalPiutangKaryawan).'%';
			$titleTotalPiutangKaryawan = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePiutangKaryawan.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPiutangKaryawan.' '.strtoupper($namePiutangKaryawan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PiutangKaryawan.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPiutangKaryawan.'</b></td>		
		}
	}
}


// PiutangLainLain
$grandTotalPiutangLainLains = array();
foreach ($listCOAPiutangLainLain as $idPiutangLainLain => $detailPiutangLainLain) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PiutangLainLain
		if(isset($detailPiutangLainLain['Level5']) && $detailPiutangLainLain['Level4']) {
			list($codePiutangLainLain, $namePiutangLainLain) = explode('^', $detailPiutangLainLain['Level4']);

			if(!empty($codePiutangLainLain)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePiutangLainLain).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPiutangLainLain['Level5']) && $detailPiutangLainLain['Level5']) {
		$debetCreditDetailPiutangLainLains = array();
		foreach ($detailPiutangLainLain['Level5'] as $dataCOAPiutangLainLain) {
			list($codeDetailPiutangLainLain, $nameDetailPiutangLainLain, $debetCreditDetailPiutangLainLain, $beginningBalanceDetailPiutangLainLain, $subTotalDetailPiutangLainLain) = explode('^', $dataCOAPiutangLainLain);
			//$totalPiutangLainLains = $debetCreditDetailPiutangLainLain+$beginningBalanceDetailPiutangLainLain;
			$debetCreditDetailPiutangLainLains[] = $subTotalDetailPiutangLainLain;
			$nominalDetailPiutangLainLain = $this->Krs->cur($subTotalDetailPiutangLainLain);

			//$dataPercentGlobalPiutangLainLain = $grandTotalPercentPiutangLainLain/$totalPercentAktiva*100;
			//$percenPiutangLainLain = $subTotalDetailPiutangLainLain/$grandTotalPercentPiutangLainLain*$dataPercentGlobalPiutangLainLain;
			//$nominalPercenPiutangLainLain = $this->Krs->percent($percenPiutangLainLain).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPiutangLainLain.') '.$nameDetailPiutangLainLain.'</td>
					<td align="right">'.$nominalDetailPiutangLainLain.'</td>
					';
					//<td align="right">'.$nominalPercenPiutangLainLain.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPiutangLainLain['Level5']) && $detailPiutangLainLain['Level4']) {
		list($codePiutangLainLain, $namePiutangLainLain) = explode('^', $detailPiutangLainLain['Level4']);

		if(!empty($codePiutangLainLain)) {
			$totalLevel4PiutangLainLain = array_sum($debetCreditDetailPiutangLainLains);
			$nominalTotalLevel4PiutangLainLain = $this->Krs->cur($totalLevel4PiutangLainLain);
			$grandTotalPiutangLainLains[] = $totalLevel4PiutangLainLain;
			//$percenPiutangLainLainBank = $subTotalDetailPiutangLainLainBank/$grandTotalPercentPiutangLainLainBank*$dataPercentGlobalPiutangLainLain;
			//$percenPiutangLainLainBank = 0;
			
			//Percent
			// $dataPercentGlobalPiutangLainLain = $totalLevel4PiutangLainLain/$totalPercentAktiva*100;
			// $nominalPercenPiutangLainLain = $this->Krs->percent($dataPercentGlobalPiutangLainLain).'%';

			//$percenTotalPiutangLainLain = $totalLevel4PiutangLainLain/$totalPercentAktiva*100;
			//$nominalGrandPercentPiutangLainLain = $this->Krs->percent($percenTotalPiutangLainLain).'%';
			$titleTotalPiutangLainLain = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePiutangLainLain.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPiutangLainLain.' '.strtoupper($namePiutangLainLain).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PiutangLainLain.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPiutangLainLain.'</b></td>		
		}
	}
}


// PiutangPajak
$grandTotalPiutangPajaks = array();
foreach ($listCOAPiutangPajak as $idPiutangPajak => $detailPiutangPajak) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PiutangPajak
		if(isset($detailPiutangPajak['Level5']) && $detailPiutangPajak['Level4']) {
			list($codePiutangPajak, $namePiutangPajak) = explode('^', $detailPiutangPajak['Level4']);

			if(!empty($codePiutangPajak)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePiutangPajak).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPiutangPajak['Level5']) && $detailPiutangPajak['Level5']) {
		$debetCreditDetailPiutangPajaks = array();
		foreach ($detailPiutangPajak['Level5'] as $dataCOAPiutangPajak) {
			list($codeDetailPiutangPajak, $nameDetailPiutangPajak, $debetCreditDetailPiutangPajak, $beginningBalanceDetailPiutangPajak, $subTotalDetailPiutangPajak) = explode('^', $dataCOAPiutangPajak);
			//$totalPiutangPajaks = $debetCreditDetailPiutangPajak+$beginningBalanceDetailPiutangPajak;
			$debetCreditDetailPiutangPajaks[] = $subTotalDetailPiutangPajak;
			$nominalDetailPiutangPajak = $this->Krs->cur($subTotalDetailPiutangPajak);

			//$dataPercentGlobalPiutangPajak = $grandTotalPercentPiutangPajak/$totalPercentAktiva*100;
			//$percenPiutangPajak = $subTotalDetailPiutangPajak/$grandTotalPercentPiutangPajak*$dataPercentGlobalPiutangPajak;
			//$nominalPercenPiutangPajak = $this->Krs->percent($percenPiutangPajak).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPiutangPajak.') '.$nameDetailPiutangPajak.'</td>
					<td align="right">'.$nominalDetailPiutangPajak.'</td>
					';
					//<td align="right">'.$nominalPercenPiutangPajak.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPiutangPajak['Level5']) && $detailPiutangPajak['Level4']) {
		list($codePiutangPajak, $namePiutangPajak) = explode('^', $detailPiutangPajak['Level4']);

		if(!empty($codePiutangPajak)) {
			$totalLevel4PiutangPajak = array_sum($debetCreditDetailPiutangPajaks);
			$nominalTotalLevel4PiutangPajak = $this->Krs->cur($totalLevel4PiutangPajak);
			$grandTotalPiutangPajaks[] = $totalLevel4PiutangPajak;
			//$percenPiutangPajakBank = $subTotalDetailPiutangPajakBank/$grandTotalPercentPiutangPajakBank*$dataPercentGlobalPiutangPajak;
			//$percenPiutangPajakBank = 0;
			
			//Percent
			// $dataPercentGlobalPiutangPajak = $totalLevel4PiutangPajak/$totalPercentAktiva*100;
			// $nominalPercenPiutangPajak = $this->Krs->percent($dataPercentGlobalPiutangPajak).'%';

			//$percenTotalPiutangPajak = $totalLevel4PiutangPajak/$totalPercentAktiva*100;
			//$nominalGrandPercentPiutangPajak = $this->Krs->percent($percenTotalPiutangPajak).'%';
			$titleTotalPiutangPajak = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePiutangPajak.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPiutangPajak.' '.strtoupper($namePiutangPajak).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PiutangPajak.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPiutangPajak.'</b></td>		
		}
	}
}


// PersediaanBarang
$grandTotalPersediaanBarangs = array();
foreach ($listCOAPersediaanBarang as $idPersediaanBarang => $detailPersediaanBarang) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PersediaanBarang
		if(isset($detailPersediaanBarang['Level5']) && $detailPersediaanBarang['Level4']) {
			list($codePersediaanBarang, $namePersediaanBarang) = explode('^', $detailPersediaanBarang['Level4']);

			if(!empty($codePersediaanBarang)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePersediaanBarang).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPersediaanBarang['Level5']) && $detailPersediaanBarang['Level5']) {
		$debetCreditDetailPersediaanBarangs = array();
		foreach ($detailPersediaanBarang['Level5'] as $dataCOAPersediaanBarang) {
			list($codeDetailPersediaanBarang, $nameDetailPersediaanBarang, $debetCreditDetailPersediaanBarang, $beginningBalanceDetailPersediaanBarang, $subTotalDetailPersediaanBarang) = explode('^', $dataCOAPersediaanBarang);
			//$totalPersediaanBarangs = $debetCreditDetailPersediaanBarang+$beginningBalanceDetailPersediaanBarang;
			$debetCreditDetailPersediaanBarangs[] = $subTotalDetailPersediaanBarang;
			$nominalDetailPersediaanBarang = $this->Krs->cur($subTotalDetailPersediaanBarang);

			//$dataPercentGlobalPersediaanBarang = $grandTotalPercentPersediaanBarang/$totalPercentAktiva*100;
			//$percenPersediaanBarang = $subTotalDetailPersediaanBarang/$grandTotalPercentPersediaanBarang*$dataPercentGlobalPersediaanBarang;
			//$nominalPercenPersediaanBarang = $this->Krs->percent($percenPersediaanBarang).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPersediaanBarang.') '.$nameDetailPersediaanBarang.'</td>
					<td align="right">'.$nominalDetailPersediaanBarang.'</td>
					';
					//<td align="right">'.$nominalPercenPersediaanBarang.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPersediaanBarang['Level5']) && $detailPersediaanBarang['Level4']) {
		list($codePersediaanBarang, $namePersediaanBarang) = explode('^', $detailPersediaanBarang['Level4']);

		if(!empty($codePersediaanBarang)) {
			$totalLevel4PersediaanBarang = array_sum($debetCreditDetailPersediaanBarangs);
			$nominalTotalLevel4PersediaanBarang = $this->Krs->cur($totalLevel4PersediaanBarang);
			$grandTotalPersediaanBarangs[] = $totalLevel4PersediaanBarang;
			//$percenPersediaanBarangBank = $subTotalDetailPersediaanBarangBank/$grandTotalPercentPersediaanBarangBank*$dataPercentGlobalPersediaanBarang;
			//$percenPersediaanBarangBank = 0;
			
			//Percent
			// $dataPercentGlobalPersediaanBarang = $totalLevel4PersediaanBarang/$totalPercentAktiva*100;
			// $nominalPercenPersediaanBarang = $this->Krs->percent($dataPercentGlobalPersediaanBarang).'%';

			//$percenTotalPersediaanBarang = $totalLevel4PersediaanBarang/$totalPercentAktiva*100;
			//$nominalGrandPercentPersediaanBarang = $this->Krs->percent($percenTotalPersediaanBarang).'%';
			$titleTotalPersediaanBarang = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePersediaanBarang.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPersediaanBarang.' '.strtoupper($namePersediaanBarang).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PersediaanBarang.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPersediaanBarang.'</b></td>		
		}
	}
}


// UangMukaPembelian
$grandTotalUangMukaPembelians = array();
foreach ($listCOAUangMukaPembelian as $idUangMukaPembelian => $detailUangMukaPembelian) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada UangMukaPembelian
		if(isset($detailUangMukaPembelian['Level5']) && $detailUangMukaPembelian['Level4']) {
			list($codeUangMukaPembelian, $nameUangMukaPembelian) = explode('^', $detailUangMukaPembelian['Level4']);

			if(!empty($codeUangMukaPembelian)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameUangMukaPembelian).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailUangMukaPembelian['Level5']) && $detailUangMukaPembelian['Level5']) {
		$debetCreditDetailUangMukaPembelians = array();
		foreach ($detailUangMukaPembelian['Level5'] as $dataCOAUangMukaPembelian) {
			list($codeDetailUangMukaPembelian, $nameDetailUangMukaPembelian, $debetCreditDetailUangMukaPembelian, $beginningBalanceDetailUangMukaPembelian, $subTotalDetailUangMukaPembelian) = explode('^', $dataCOAUangMukaPembelian);
			//$totalUangMukaPembelians = $debetCreditDetailUangMukaPembelian+$beginningBalanceDetailUangMukaPembelian;
			$debetCreditDetailUangMukaPembelians[] = $subTotalDetailUangMukaPembelian;
			$nominalDetailUangMukaPembelian = $this->Krs->cur($subTotalDetailUangMukaPembelian);

			//$dataPercentGlobalUangMukaPembelian = $grandTotalPercentUangMukaPembelian/$totalPercentAktiva*100;
			//$percenUangMukaPembelian = $subTotalDetailUangMukaPembelian/$grandTotalPercentUangMukaPembelian*$dataPercentGlobalUangMukaPembelian;
			//$nominalPercenUangMukaPembelian = $this->Krs->percent($percenUangMukaPembelian).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailUangMukaPembelian.') '.$nameDetailUangMukaPembelian.'</td>
					<td align="right">'.$nominalDetailUangMukaPembelian.'</td>
					';
					//<td align="right">'.$nominalPercenUangMukaPembelian.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailUangMukaPembelian['Level5']) && $detailUangMukaPembelian['Level4']) {
		list($codeUangMukaPembelian, $nameUangMukaPembelian) = explode('^', $detailUangMukaPembelian['Level4']);

		if(!empty($codeUangMukaPembelian)) {
			$totalLevel4UangMukaPembelian = array_sum($debetCreditDetailUangMukaPembelians);
			$nominalTotalLevel4UangMukaPembelian = $this->Krs->cur($totalLevel4UangMukaPembelian);
			$grandTotalUangMukaPembelians[] = $totalLevel4UangMukaPembelian;
			//$percenUangMukaPembelianBank = $subTotalDetailUangMukaPembelianBank/$grandTotalPercentUangMukaPembelianBank*$dataPercentGlobalUangMukaPembelian;
			//$percenUangMukaPembelianBank = 0;
			
			//Percent
			// $dataPercentGlobalUangMukaPembelian = $totalLevel4UangMukaPembelian/$totalPercentAktiva*100;
			// $nominalPercenUangMukaPembelian = $this->Krs->percent($dataPercentGlobalUangMukaPembelian).'%';

			//$percenTotalUangMukaPembelian = $totalLevel4UangMukaPembelian/$totalPercentAktiva*100;
			//$nominalGrandPercentUangMukaPembelian = $this->Krs->percent($percenTotalUangMukaPembelian).'%';
			$titleTotalUangMukaPembelian = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeUangMukaPembelian.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalUangMukaPembelian.' '.strtoupper($nameUangMukaPembelian).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4UangMukaPembelian.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenUangMukaPembelian.'</b></td>		
		}
	}
}


// PajakDibayarDimuka
$grandTotalPajakDibayarDimukas = array();
foreach ($listCOAPajakDibayarDimuka as $idPajakDibayarDimuka => $detailPajakDibayarDimuka) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PajakDibayarDimuka
		if(isset($detailPajakDibayarDimuka['Level5']) && $detailPajakDibayarDimuka['Level4']) {
			list($codePajakDibayarDimuka, $namePajakDibayarDimuka) = explode('^', $detailPajakDibayarDimuka['Level4']);

			if(!empty($codePajakDibayarDimuka)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePajakDibayarDimuka).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPajakDibayarDimuka['Level5']) && $detailPajakDibayarDimuka['Level5']) {
		$debetCreditDetailPajakDibayarDimukas = array();
		foreach ($detailPajakDibayarDimuka['Level5'] as $dataCOAPajakDibayarDimuka) {
			list($codeDetailPajakDibayarDimuka, $nameDetailPajakDibayarDimuka, $debetCreditDetailPajakDibayarDimuka, $beginningBalanceDetailPajakDibayarDimuka, $subTotalDetailPajakDibayarDimuka) = explode('^', $dataCOAPajakDibayarDimuka);
			//$totalPajakDibayarDimukas = $debetCreditDetailPajakDibayarDimuka+$beginningBalanceDetailPajakDibayarDimuka;
			$debetCreditDetailPajakDibayarDimukas[] = $subTotalDetailPajakDibayarDimuka;
			$nominalDetailPajakDibayarDimuka = $this->Krs->cur($subTotalDetailPajakDibayarDimuka);

			//$dataPercentGlobalPajakDibayarDimuka = $grandTotalPercentPajakDibayarDimuka/$totalPercentAktiva*100;
			//$percenPajakDibayarDimuka = $subTotalDetailPajakDibayarDimuka/$grandTotalPercentPajakDibayarDimuka*$dataPercentGlobalPajakDibayarDimuka;
			//$nominalPercenPajakDibayarDimuka = $this->Krs->percent($percenPajakDibayarDimuka).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPajakDibayarDimuka.') '.$nameDetailPajakDibayarDimuka.'</td>
					<td align="right">'.$nominalDetailPajakDibayarDimuka.'</td>
					';
					//<td align="right">'.$nominalPercenPajakDibayarDimuka.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPajakDibayarDimuka['Level5']) && $detailPajakDibayarDimuka['Level4']) {
		list($codePajakDibayarDimuka, $namePajakDibayarDimuka) = explode('^', $detailPajakDibayarDimuka['Level4']);

		if(!empty($codePajakDibayarDimuka)) {
			$totalLevel4PajakDibayarDimuka = array_sum($debetCreditDetailPajakDibayarDimukas);
			$nominalTotalLevel4PajakDibayarDimuka = $this->Krs->cur($totalLevel4PajakDibayarDimuka);
			$grandTotalPajakDibayarDimukas[] = $totalLevel4PajakDibayarDimuka;
			//$percenPajakDibayarDimukaBank = $subTotalDetailPajakDibayarDimukaBank/$grandTotalPercentPajakDibayarDimukaBank*$dataPercentGlobalPajakDibayarDimuka;
			//$percenPajakDibayarDimukaBank = 0;
			
			//Percent
			// $dataPercentGlobalPajakDibayarDimuka = $totalLevel4PajakDibayarDimuka/$totalPercentAktiva*100;
			// $nominalPercenPajakDibayarDimuka = $this->Krs->percent($dataPercentGlobalPajakDibayarDimuka).'%';

			//$percenTotalPajakDibayarDimuka = $totalLevel4PajakDibayarDimuka/$totalPercentAktiva*100;
			//$nominalGrandPercentPajakDibayarDimuka = $this->Krs->percent($percenTotalPajakDibayarDimuka).'%';
			$titleTotalPajakDibayarDimuka = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePajakDibayarDimuka.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPajakDibayarDimuka.' '.strtoupper($namePajakDibayarDimuka).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PajakDibayarDimuka.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPajakDibayarDimuka.'</b></td>		
		}
	}
}


// Beban Dibayar Dimuka
$grandTotalBebanDibayarDimukas = array();
foreach ($listCOABebanDibayarDimuka as $idBebanDibayarDimuka => $detailBebanDibayarDimuka) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada BebanDibayarDimuka
		if(isset($detailBebanDibayarDimuka['Level5']) && $detailBebanDibayarDimuka['Level4']) {
			list($codeBebanDibayarDimuka, $nameBebanDibayarDimuka) = explode('^', $detailBebanDibayarDimuka['Level4']);

			if(!empty($codeBebanDibayarDimuka)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameBebanDibayarDimuka).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailBebanDibayarDimuka['Level5']) && $detailBebanDibayarDimuka['Level5']) {
		$debetCreditDetailBebanDibayarDimukas = array();
		foreach ($detailBebanDibayarDimuka['Level5'] as $dataCOABebanDibayarDimuka) {
			list($codeDetailBebanDibayarDimuka, $nameDetailBebanDibayarDimuka, $debetCreditDetailBebanDibayarDimuka, $beginningBalanceDetailBebanDibayarDimuka, $subTotalDetailBebanDibayarDimuka) = explode('^', $dataCOABebanDibayarDimuka);
			//$totalBebanDibayarDimukas = $debetCreditDetailBebanDibayarDimuka+$beginningBalanceDetailBebanDibayarDimuka;
			$debetCreditDetailBebanDibayarDimukas[] = $subTotalDetailBebanDibayarDimuka;
			$nominalDetailBebanDibayarDimuka = $this->Krs->cur($subTotalDetailBebanDibayarDimuka);

			//$dataPercentGlobalBebanDibayarDimuka = $grandTotalPercentBebanDibayarDimuka/$totalPercentAktiva*100;
			//$percenBebanDibayarDimuka = $subTotalDetailBebanDibayarDimuka/$grandTotalPercentBebanDibayarDimuka*$dataPercentGlobalBebanDibayarDimuka;
			//$nominalPercenBebanDibayarDimuka = $this->Krs->percent($percenBebanDibayarDimuka).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailBebanDibayarDimuka.') '.$nameDetailBebanDibayarDimuka.'</td>
					<td align="right">'.$nominalDetailBebanDibayarDimuka.'</td>
					';
					//<td align="right">'.$nominalPercenBebanDibayarDimuka.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailBebanDibayarDimuka['Level5']) && $detailBebanDibayarDimuka['Level4']) {
		list($codeBebanDibayarDimuka, $nameBebanDibayarDimuka) = explode('^', $detailBebanDibayarDimuka['Level4']);

		if(!empty($codeBebanDibayarDimuka)) {
			$totalLevel4BebanDibayarDimuka = array_sum($debetCreditDetailBebanDibayarDimukas);
			$nominalTotalLevel4BebanDibayarDimuka = $this->Krs->cur($totalLevel4BebanDibayarDimuka);
			$grandTotalBebanDibayarDimukas[] = $totalLevel4BebanDibayarDimuka;
			//$percenBebanDibayarDimukaBank = $subTotalDetailBebanDibayarDimukaBank/$grandTotalPercentBebanDibayarDimukaBank*$dataPercentGlobalBebanDibayarDimuka;
			//$percenBebanDibayarDimukaBank = 0;
			
			//Percent
			// $dataPercentGlobalBebanDibayarDimuka = $totalLevel4BebanDibayarDimuka/$totalPercentAktiva*100;
			// $nominalPercenBebanDibayarDimuka = $this->Krs->percent($dataPercentGlobalBebanDibayarDimuka).'%';

			//$percenTotalBebanDibayarDimuka = $totalLevel4BebanDibayarDimuka/$totalPercentAktiva*100;
			//$nominalGrandPercentBebanDibayarDimuka = $this->Krs->percent($percenTotalBebanDibayarDimuka).'%';
			$titleTotalBebanDibayarDimuka = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeBebanDibayarDimuka.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalBebanDibayarDimuka.' '.strtoupper($nameBebanDibayarDimuka).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4BebanDibayarDimuka.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenBebanDibayarDimuka.'</b></td>		
		}
	}
}

// Aset Lancar
$grandTotalAset = (empty($grandTotalAsets)) ? 0 : round(array_sum($grandTotalAsets),2);
$grandTotalAsetLancar = (empty($grandTotalAsetLancars)) ? 0 : round(array_sum($grandTotalAsetLancars),2);
$grandTotalKasSetaraKas = (empty($grandTotalKasSetaraKass)) ? 0 : round(array_sum($grandTotalKasSetaraKass),2);
$grandTotalInvestasi = (empty($grandTotalInvestasis)) ? 0 : round(array_sum($grandTotalInvestasis),2);
$grandTotalPiutang = (empty($grandTotalPiutangs)) ? 0 : round(array_sum($grandTotalPiutangs),2);
$grandTotalPiutangPemegangSaham = (empty($grandTotalPiutangPemegangSahams)) ? 0 : round(array_sum($grandTotalPiutangPemegangSahams),2);
$grandTotalPiutangAfiliasi = (empty($grandTotalPiutangAfiliasis)) ? 0 : round(array_sum($grandTotalPiutangAfiliasis),2);
$grandTotalPiutangKaryawan = (empty($grandTotalPiutangKaryawans)) ? 0 : round(array_sum($grandTotalPiutangKaryawans),2);
$grandTotalPiutangLainLain = (empty($grandTotalPiutangLainLains)) ? 0 : round(array_sum($grandTotalPiutangLainLains),2);
$grandTotalPiutangPajak = (empty($grandTotalPiutangPajaks)) ? 0 : round(array_sum($grandTotalPiutangPajaks),2);
$grandTotalPersediaanBarang = (empty($grandTotalPersediaanBarangs)) ? 0 : round(array_sum($grandTotalPersediaanBarangs),2);
$grandTotalUangMukaPembelian = (empty($grandTotalUangMukaPembelians)) ? 0 : round(array_sum($grandTotalUangMukaPembelians),2);
$grandTotalPajakDibayarDimuka = (empty($grandTotalPajakDibayarDimukas)) ? 0 : round(array_sum($grandTotalPajakDibayarDimukas),2);
$grandTotalBebanDibayarDimuka = (empty($grandTotalBebanDibayarDimukas)) ? 0 : round(array_sum($grandTotalBebanDibayarDimukas),2);


$totalAsetLancar = $grandTotalAset+$grandTotalAsetLancar+$grandTotalKasSetaraKas+$grandTotalInvestasi+$grandTotalPiutang+$grandTotalPiutangPemegangSaham+$grandTotalPiutangAfiliasi+$grandTotalPiutangKaryawan+$grandTotalPiutangLainLain+$grandTotalPiutangPajak+$grandTotalPersediaanBarang+$grandTotalUangMukaPembelian+$grandTotalPajakDibayarDimuka+$grandTotalBebanDibayarDimuka;


echo '<tr>
	<td align="left"><b>Total Aset Lancar</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalAsetLancar).'</b></td>	
</tr>';

//TOTAL AKTIVA


echo '<tr>
	<td align="left"><b>Aset Tidak Lancar</b></td>
	<td align="right">&nbsp;</td>	
</tr>';



// AsetTidakLancar
$grandTotalAsetTidakLancars = array();
foreach ($listCOAAsetTidakLancar as $idAsetTidakLancar => $detailAsetTidakLancar) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada AsetTidakLancar
		if(isset($detailAsetTidakLancar['Level5']) && $detailAsetTidakLancar['Level4']) {
			list($codeAsetTidakLancar, $nameAsetTidakLancar) = explode('^', $detailAsetTidakLancar['Level4']);

			if(!empty($codeAsetTidakLancar)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameAsetTidakLancar).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailAsetTidakLancar['Level5']) && $detailAsetTidakLancar['Level5']) {
		$debetCreditDetailAsetTidakLancars = array();
		foreach ($detailAsetTidakLancar['Level5'] as $dataCOAAsetTidakLancar) {
			list($codeDetailAsetTidakLancar, $nameDetailAsetTidakLancar, $debetCreditDetailAsetTidakLancar, $beginningBalanceDetailAsetTidakLancar, $subTotalDetailAsetTidakLancar) = explode('^', $dataCOAAsetTidakLancar);
			//$totalAsetTidakLancars = $debetCreditDetailAsetTidakLancar+$beginningBalanceDetailAsetTidakLancar;
			$debetCreditDetailAsetTidakLancars[] = $subTotalDetailAsetTidakLancar;
			$nominalDetailAsetTidakLancar = $this->Krs->cur($subTotalDetailAsetTidakLancar);

			//$dataPercentGlobalAsetTidakLancar = $grandTotalPercentAsetTidakLancar/$totalPercentAktiva*100;
			//$percenAsetTidakLancar = $subTotalDetailAsetTidakLancar/$grandTotalPercentAsetTidakLancar*$dataPercentGlobalAsetTidakLancar;
			//$nominalPercenAsetTidakLancar = $this->Krs->percent($percenAsetTidakLancar).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailAsetTidakLancar.') '.$nameDetailAsetTidakLancar.'</td>
					<td align="right">'.$nominalDetailAsetTidakLancar.'</td>
					';
					//<td align="right">'.$nominalPercenAsetTidakLancar.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailAsetTidakLancar['Level5']) && $detailAsetTidakLancar['Level4']) {
		list($codeAsetTidakLancar, $nameAsetTidakLancar) = explode('^', $detailAsetTidakLancar['Level4']);

		if(!empty($codeAsetTidakLancar)) {
			$totalLevel4AsetTidakLancar = array_sum($debetCreditDetailAsetTidakLancars);
			$nominalTotalLevel4AsetTidakLancar = $this->Krs->cur($totalLevel4AsetTidakLancar);
			$grandTotalAsetTidakLancars[] = $totalLevel4AsetTidakLancar;
			//$percenAsetTidakLancarBank = $subTotalDetailAsetTidakLancarBank/$grandTotalPercentAsetTidakLancarBank*$dataPercentGlobalAsetTidakLancar;
			//$percenAsetTidakLancarBank = 0;
			
			//Percent
			// $dataPercentGlobalAsetTidakLancar = $totalLevel4AsetTidakLancar/$totalPercentAktiva*100;
			// $nominalPercenAsetTidakLancar = $this->Krs->percent($dataPercentGlobalAsetTidakLancar).'%';

			//$percenTotalAsetTidakLancar = $totalLevel4AsetTidakLancar/$totalPercentAktiva*100;
			//$nominalGrandPercentAsetTidakLancar = $this->Krs->percent($percenTotalAsetTidakLancar).'%';
			$titleTotalAsetTidakLancar = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeAsetTidakLancar.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalAsetTidakLancar.' '.strtoupper($nameAsetTidakLancar).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AsetTidakLancar.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenAsetTidakLancar.'</b></td>		
		}
	}
}


// InvestasiJangkaPanjang
$grandTotalInvestasiJangkaPanjangs = array();
foreach ($listCOAInvestasiJangkaPanjang as $idInvestasiJangkaPanjang => $detailInvestasiJangkaPanjang) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada InvestasiJangkaPanjang
		if(isset($detailInvestasiJangkaPanjang['Level5']) && $detailInvestasiJangkaPanjang['Level4']) {
			list($codeInvestasiJangkaPanjang, $nameInvestasiJangkaPanjang) = explode('^', $detailInvestasiJangkaPanjang['Level4']);

			if(!empty($codeInvestasiJangkaPanjang)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameInvestasiJangkaPanjang).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailInvestasiJangkaPanjang['Level5']) && $detailInvestasiJangkaPanjang['Level5']) {
		$debetCreditDetailInvestasiJangkaPanjangs = array();
		foreach ($detailInvestasiJangkaPanjang['Level5'] as $dataCOAInvestasiJangkaPanjang) {
			list($codeDetailInvestasiJangkaPanjang, $nameDetailInvestasiJangkaPanjang, $debetCreditDetailInvestasiJangkaPanjang, $beginningBalanceDetailInvestasiJangkaPanjang, $subTotalDetailInvestasiJangkaPanjang) = explode('^', $dataCOAInvestasiJangkaPanjang);
			//$totalInvestasiJangkaPanjangs = $debetCreditDetailInvestasiJangkaPanjang+$beginningBalanceDetailInvestasiJangkaPanjang;
			$debetCreditDetailInvestasiJangkaPanjangs[] = $subTotalDetailInvestasiJangkaPanjang;
			$nominalDetailInvestasiJangkaPanjang = $this->Krs->cur($subTotalDetailInvestasiJangkaPanjang);

			//$dataPercentGlobalInvestasiJangkaPanjang = $grandTotalPercentInvestasiJangkaPanjang/$totalPercentAktiva*100;
			//$percenInvestasiJangkaPanjang = $subTotalDetailInvestasiJangkaPanjang/$grandTotalPercentInvestasiJangkaPanjang*$dataPercentGlobalInvestasiJangkaPanjang;
			//$nominalPercenInvestasiJangkaPanjang = $this->Krs->percent($percenInvestasiJangkaPanjang).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailInvestasiJangkaPanjang.') '.$nameDetailInvestasiJangkaPanjang.'</td>
					<td align="right">'.$nominalDetailInvestasiJangkaPanjang.'</td>
					';
					//<td align="right">'.$nominalPercenInvestasiJangkaPanjang.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailInvestasiJangkaPanjang['Level5']) && $detailInvestasiJangkaPanjang['Level4']) {
		list($codeInvestasiJangkaPanjang, $nameInvestasiJangkaPanjang) = explode('^', $detailInvestasiJangkaPanjang['Level4']);

		if(!empty($codeInvestasiJangkaPanjang)) {
			$totalLevel4InvestasiJangkaPanjang = array_sum($debetCreditDetailInvestasiJangkaPanjangs);
			$nominalTotalLevel4InvestasiJangkaPanjang = $this->Krs->cur($totalLevel4InvestasiJangkaPanjang);
			$grandTotalInvestasiJangkaPanjangs[] = $totalLevel4InvestasiJangkaPanjang;
			//$percenInvestasiJangkaPanjangBank = $subTotalDetailInvestasiJangkaPanjangBank/$grandTotalPercentInvestasiJangkaPanjangBank*$dataPercentGlobalInvestasiJangkaPanjang;
			//$percenInvestasiJangkaPanjangBank = 0;
			
			//Percent
			// $dataPercentGlobalInvestasiJangkaPanjang = $totalLevel4InvestasiJangkaPanjang/$totalPercentAktiva*100;
			// $nominalPercenInvestasiJangkaPanjang = $this->Krs->percent($dataPercentGlobalInvestasiJangkaPanjang).'%';

			//$percenTotalInvestasiJangkaPanjang = $totalLevel4InvestasiJangkaPanjang/$totalPercentAktiva*100;
			//$nominalGrandPercentInvestasiJangkaPanjang = $this->Krs->percent($percenTotalInvestasiJangkaPanjang).'%';
			$titleTotalInvestasiJangkaPanjang = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeInvestasiJangkaPanjang.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalInvestasiJangkaPanjang.' '.strtoupper($nameInvestasiJangkaPanjang).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4InvestasiJangkaPanjang.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenInvestasiJangkaPanjang.'</b></td>		
		}
	}
}

// AsetTetap
$grandTotalAsetTetaps = array();
foreach ($listCOAAsetTetap as $idAsetTetap => $detailAsetTetap) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada AsetTetap
		if(isset($detailAsetTetap['Level5']) && $detailAsetTetap['Level4']) {
			list($codeAsetTetap, $nameAsetTetap) = explode('^', $detailAsetTetap['Level4']);

			if(!empty($codeAsetTetap)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameAsetTetap).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailAsetTetap['Level5']) && $detailAsetTetap['Level5']) {
		$debetCreditDetailAsetTetaps = array();
		foreach ($detailAsetTetap['Level5'] as $dataCOAAsetTetap) {
			list($codeDetailAsetTetap, $nameDetailAsetTetap, $debetCreditDetailAsetTetap, $beginningBalanceDetailAsetTetap, $subTotalDetailAsetTetap) = explode('^', $dataCOAAsetTetap);
			//$totalAsetTetaps = $debetCreditDetailAsetTetap+$beginningBalanceDetailAsetTetap;
			$debetCreditDetailAsetTetaps[] = $subTotalDetailAsetTetap;
			$nominalDetailAsetTetap = $this->Krs->cur($subTotalDetailAsetTetap);

			//$dataPercentGlobalAsetTetap = $grandTotalPercentAsetTetap/$totalPercentAktiva*100;
			//$percenAsetTetap = $subTotalDetailAsetTetap/$grandTotalPercentAsetTetap*$dataPercentGlobalAsetTetap;
			//$nominalPercenAsetTetap = $this->Krs->percent($percenAsetTetap).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailAsetTetap.') '.$nameDetailAsetTetap.'</td>
					<td align="right">'.$nominalDetailAsetTetap.'</td>
					';
					//<td align="right">'.$nominalPercenAsetTetap.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailAsetTetap['Level5']) && $detailAsetTetap['Level4']) {
		list($codeAsetTetap, $nameAsetTetap) = explode('^', $detailAsetTetap['Level4']);

		if(!empty($codeAsetTetap)) {
			$totalLevel4AsetTetap = array_sum($debetCreditDetailAsetTetaps);
			$nominalTotalLevel4AsetTetap = $this->Krs->cur($totalLevel4AsetTetap);
			$grandTotalAsetTetaps[] = $totalLevel4AsetTetap;
			//$percenAsetTetapBank = $subTotalDetailAsetTetapBank/$grandTotalPercentAsetTetapBank*$dataPercentGlobalAsetTetap;
			//$percenAsetTetapBank = 0;
			
			//Percent
			// $dataPercentGlobalAsetTetap = $totalLevel4AsetTetap/$totalPercentAktiva*100;
			// $nominalPercenAsetTetap = $this->Krs->percent($dataPercentGlobalAsetTetap).'%';

			//$percenTotalAsetTetap = $totalLevel4AsetTetap/$totalPercentAktiva*100;
			//$nominalGrandPercentAsetTetap = $this->Krs->percent($percenTotalAsetTetap).'%';
			$titleTotalAsetTetap = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeAsetTetap.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalAsetTetap.' '.strtoupper($nameAsetTetap).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AsetTetap.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenAsetTetap.'</b></td>		
		}
	}
}


// AkumulasiDepresiasi
$grandTotalAkumulasiDepresiasis = array();
foreach ($listCOAAkumulasiDepresiasi as $idAkumulasiDepresiasi => $detailAkumulasiDepresiasi) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada AkumulasiDepresiasi
		if(isset($detailAkumulasiDepresiasi['Level5']) && $detailAkumulasiDepresiasi['Level4']) {
			list($codeAkumulasiDepresiasi, $nameAkumulasiDepresiasi) = explode('^', $detailAkumulasiDepresiasi['Level4']);

			if(!empty($codeAkumulasiDepresiasi)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameAkumulasiDepresiasi).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailAkumulasiDepresiasi['Level5']) && $detailAkumulasiDepresiasi['Level5']) {
		$debetCreditDetailAkumulasiDepresiasis = array();
		foreach ($detailAkumulasiDepresiasi['Level5'] as $dataCOAAkumulasiDepresiasi) {
			list($codeDetailAkumulasiDepresiasi, $nameDetailAkumulasiDepresiasi, $debetCreditDetailAkumulasiDepresiasi, $beginningBalanceDetailAkumulasiDepresiasi, $subTotalDetailAkumulasiDepresiasi) = explode('^', $dataCOAAkumulasiDepresiasi);
			//$totalAkumulasiDepresiasis = $debetCreditDetailAkumulasiDepresiasi+$beginningBalanceDetailAkumulasiDepresiasi;
			$debetCreditDetailAkumulasiDepresiasis[] = $subTotalDetailAkumulasiDepresiasi;
			$nominalDetailAkumulasiDepresiasi = $this->Krs->cur($subTotalDetailAkumulasiDepresiasi);

			//$dataPercentGlobalAkumulasiDepresiasi = $grandTotalPercentAkumulasiDepresiasi/$totalPercentAktiva*100;
			//$percenAkumulasiDepresiasi = $subTotalDetailAkumulasiDepresiasi/$grandTotalPercentAkumulasiDepresiasi*$dataPercentGlobalAkumulasiDepresiasi;
			//$nominalPercenAkumulasiDepresiasi = $this->Krs->percent($percenAkumulasiDepresiasi).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailAkumulasiDepresiasi.') '.$nameDetailAkumulasiDepresiasi.'</td>
					<td align="right">'.$nominalDetailAkumulasiDepresiasi.'</td>
					';
					//<td align="right">'.$nominalPercenAkumulasiDepresiasi.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailAkumulasiDepresiasi['Level5']) && $detailAkumulasiDepresiasi['Level4']) {
		list($codeAkumulasiDepresiasi, $nameAkumulasiDepresiasi) = explode('^', $detailAkumulasiDepresiasi['Level4']);

		if(!empty($codeAkumulasiDepresiasi)) {
			$totalLevel4AkumulasiDepresiasi = array_sum($debetCreditDetailAkumulasiDepresiasis);
			$nominalTotalLevel4AkumulasiDepresiasi = $this->Krs->cur($totalLevel4AkumulasiDepresiasi);
			$grandTotalAkumulasiDepresiasis[] = $totalLevel4AkumulasiDepresiasi;
			//$percenAkumulasiDepresiasiBank = $subTotalDetailAkumulasiDepresiasiBank/$grandTotalPercentAkumulasiDepresiasiBank*$dataPercentGlobalAkumulasiDepresiasi;
			//$percenAkumulasiDepresiasiBank = 0;
			
			//Percent
			// $dataPercentGlobalAkumulasiDepresiasi = $totalLevel4AkumulasiDepresiasi/$totalPercentAktiva*100;
			// $nominalPercenAkumulasiDepresiasi = $this->Krs->percent($dataPercentGlobalAkumulasiDepresiasi).'%';

			//$percenTotalAkumulasiDepresiasi = $totalLevel4AkumulasiDepresiasi/$totalPercentAktiva*100;
			//$nominalGrandPercentAkumulasiDepresiasi = $this->Krs->percent($percenTotalAkumulasiDepresiasi).'%';
			$titleTotalAkumulasiDepresiasi = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeAkumulasiDepresiasi.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalAkumulasiDepresiasi.' '.strtoupper($nameAkumulasiDepresiasi).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AkumulasiDepresiasi.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenAkumulasiDepresiasi.'</b></td>		
		}
	}
}


// AsetLainLain
$grandTotalAsetLainLains = array();
foreach ($listCOAAsetLainLain as $idAsetLainLain => $detailAsetLainLain) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada AsetLainLain
		if(isset($detailAsetLainLain['Level5']) && $detailAsetLainLain['Level4']) {
			list($codeAsetLainLain, $nameAsetLainLain) = explode('^', $detailAsetLainLain['Level4']);

			if(!empty($codeAsetLainLain)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameAsetLainLain).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailAsetLainLain['Level5']) && $detailAsetLainLain['Level5']) {
		$debetCreditDetailAsetLainLains = array();
		foreach ($detailAsetLainLain['Level5'] as $dataCOAAsetLainLain) {
			list($codeDetailAsetLainLain, $nameDetailAsetLainLain, $debetCreditDetailAsetLainLain, $beginningBalanceDetailAsetLainLain, $subTotalDetailAsetLainLain) = explode('^', $dataCOAAsetLainLain);
			//$totalAsetLainLains = $debetCreditDetailAsetLainLain+$beginningBalanceDetailAsetLainLain;
			$debetCreditDetailAsetLainLains[] = $subTotalDetailAsetLainLain;
			$nominalDetailAsetLainLain = $this->Krs->cur($subTotalDetailAsetLainLain);

			//$dataPercentGlobalAsetLainLain = $grandTotalPercentAsetLainLain/$totalPercentAktiva*100;
			//$percenAsetLainLain = $subTotalDetailAsetLainLain/$grandTotalPercentAsetLainLain*$dataPercentGlobalAsetLainLain;
			//$nominalPercenAsetLainLain = $this->Krs->percent($percenAsetLainLain).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailAsetLainLain.') '.$nameDetailAsetLainLain.'</td>
					<td align="right">'.$nominalDetailAsetLainLain.'</td>
					';
					//<td align="right">'.$nominalPercenAsetLainLain.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailAsetLainLain['Level5']) && $detailAsetLainLain['Level4']) {
		list($codeAsetLainLain, $nameAsetLainLain) = explode('^', $detailAsetLainLain['Level4']);

		if(!empty($codeAsetLainLain)) {
			$totalLevel4AsetLainLain = array_sum($debetCreditDetailAsetLainLains);
			$nominalTotalLevel4AsetLainLain = $this->Krs->cur($totalLevel4AsetLainLain);
			$grandTotalAsetLainLains[] = $totalLevel4AsetLainLain;
			//$percenAsetLainLainBank = $subTotalDetailAsetLainLainBank/$grandTotalPercentAsetLainLainBank*$dataPercentGlobalAsetLainLain;
			//$percenAsetLainLainBank = 0;
			
			//Percent
			// $dataPercentGlobalAsetLainLain = $totalLevel4AsetLainLain/$totalPercentAktiva*100;
			// $nominalPercenAsetLainLain = $this->Krs->percent($dataPercentGlobalAsetLainLain).'%';

			//$percenTotalAsetLainLain = $totalLevel4AsetLainLain/$totalPercentAktiva*100;
			//$nominalGrandPercentAsetLainLain = $this->Krs->percent($percenTotalAsetLainLain).'%';
			$titleTotalAsetLainLain = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeAsetLainLain.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalAsetLainLain.' '.strtoupper($nameAsetLainLain).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4AsetLainLain.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenAsetLainLain.'</b></td>		
		}
	}
}

//Aset tidak lancar
$grandTotalAsetTidakLancar = (empty($grandTotalAsetTidakLancars)) ? 0 : round(array_sum($grandTotalAsetTidakLancars),2);
$grandTotalInvestasiJangkaPanjang = (empty($grandTotalInvestasiJangkaPanjangs)) ? 0 : round(array_sum($grandTotalInvestasiJangkaPanjangs),2);
$grandTotalAsetTetap = (empty($grandTotalAsetTetaps)) ? 0 : round(array_sum($grandTotalAsetTetaps),2);
$grandTotalAkumulasiDepresiasi = (empty($grandTotalAkumulasiDepresiasis)) ? 0 : round(array_sum($grandTotalAkumulasiDepresiasis),2);
$grandTotalAsetLainLain = (empty($grandTotalAsetLainLains)) ? 0 : round(array_sum($grandTotalAsetLainLains),2);

$totalAsetTidakLancar = $grandTotalAsetTidakLancar+$grandTotalInvestasiJangkaPanjang+$grandTotalAsetTetap+$grandTotalAkumulasiDepresiasi+$grandTotalAsetLainLain;

echo '<tr>
	<td align="left"><b>Total Aset Tidak Lancar</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalAsetTidakLancar).'</b></td>
	
</tr>';

//TOTAL AKTIVA
$totalAktiva = $totalAsetLancar+$totalAsetTidakLancar;

echo '<tr>
	<td align="right">'.str_repeat('&nbsp;&nbsp;&nbsp;', 10).'<b>TOTAL ASET / AKTIVA</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalAktiva).'</b></td>
	
</tr>';
//<td align="right"><b>100%</b></td>





?>
										</table>
									</div>
								</div>



								<div class="col-md-6">
									<div class="table-responsive">
										<table width="100%" class="table-hover" cellpadding="3" cellspacing="0" border="0">
											<tr>
												<th align="left" colspan="3">PASIVA</th>
											</tr>
											<tr>
												<th align="left" colspan="3">PASIVA LANCAR</th>
											</tr>

<?php
// -------------------- MENGAMBIL NILAI TOTAL AKTIVA ---------------------
echo '<tr>
	<td align="left"><b>Kewajiban Lancar</b></td>
	<td align="right">&nbsp;</td>
	
</tr>';

// Kewajiban
$grandTotalKewajibans = array();
foreach ($listCOAKewajiban as $idKewajiban => $detailKewajiban) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada Kewajiban
		if(isset($detailKewajiban['Level5']) && $detailKewajiban['Level4']) {
			list($codeKewajiban, $nameKewajiban) = explode('^', $detailKewajiban['Level4']);

			if(!empty($codeKewajiban)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameKewajiban).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailKewajiban['Level5']) && $detailKewajiban['Level5']) {
		$debetCreditDetailKewajibans = array();
		foreach ($detailKewajiban['Level5'] as $dataCOAKewajiban) {
			list($codeDetailKewajiban, $nameDetailKewajiban, $debetCreditDetailKewajiban, $beginningBalanceDetailKewajiban, $subTotalDetailKewajiban) = explode('^', $dataCOAKewajiban);
			//$totalKewajibans = $debetCreditDetailKewajiban+$beginningBalanceDetailKewajiban;
			$debetCreditDetailKewajibans[] = $subTotalDetailKewajiban;
			$nominalDetailKewajiban = $this->Krs->cur($subTotalDetailKewajiban);

			//$dataPercentGlobalKewajiban = $grandTotalPercentKewajiban/$totalPercentAktiva*100;
			//$percenKewajiban = $subTotalDetailKewajiban/$grandTotalPercentKewajiban*$dataPercentGlobalKewajiban;
			//$nominalPercenKewajiban = $this->Krs->percent($percenKewajiban).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailKewajiban.') '.$nameDetailKewajiban.'</td>
					<td align="right">'.$nominalDetailKewajiban.'</td>
					';
					//<td align="right">'.$nominalPercenKewajiban.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailKewajiban['Level5']) && $detailKewajiban['Level4']) {
		list($codeKewajiban, $nameKewajiban) = explode('^', $detailKewajiban['Level4']);

		if(!empty($codeKewajiban)) {
			$totalLevel4Kewajiban = array_sum($debetCreditDetailKewajibans);
			$nominalTotalLevel4Kewajiban = $this->Krs->cur($totalLevel4Kewajiban);
			$grandTotalKewajibans[] = $totalLevel4Kewajiban;
			//$percenKewajibanBank = $subTotalDetailKewajibanBank/$grandTotalPercentKewajibanBank*$dataPercentGlobalKewajiban;
			//$percenKewajibanBank = 0;
			
			//Percent
			// $dataPercentGlobalKewajiban = $totalLevel4Kewajiban/$totalPercentAktiva*100;
			// $nominalPercenKewajiban = $this->Krs->percent($dataPercentGlobalKewajiban).'%';

			//$percenTotalKewajiban = $totalLevel4Kewajiban/$totalPercentAktiva*100;
			//$nominalGrandPercentKewajiban = $this->Krs->percent($percenTotalKewajiban).'%';
			$titleTotalKewajiban = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeKewajiban.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalKewajiban.' '.strtoupper($nameKewajiban).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4Kewajiban.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenKewajiban.'</b></td>		
		}
	}
}


// KewajibanLancar
// pr($listCOAKewajibanLancar);
$grandTotalKewajibanLancars = array();
foreach ($listCOAKewajibanLancar as $idKewajibanLancar => $detailKewajibanLancar) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada KewajibanLancar
		if(isset($detailKewajibanLancar['Level5']) && $detailKewajibanLancar['Level4']) {
			list($codeKewajibanLancar, $nameKewajibanLancar) = explode('^', $detailKewajibanLancar['Level4']);

			if(!empty($codeKewajibanLancar)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameKewajibanLancar).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailKewajibanLancar['Level5']) && $detailKewajibanLancar['Level5']) {
		$debetCreditDetailKewajibanLancars = array();
		foreach ($detailKewajibanLancar['Level5'] as $dataCOAKewajibanLancar) {
			list($codeDetailKewajibanLancar, $nameDetailKewajibanLancar, $debetCreditDetailKewajibanLancar, $beginningBalanceDetailKewajibanLancar, $subTotalDetailKewajibanLancar) = explode('^', $dataCOAKewajibanLancar);
			//$totalKewajibanLancars = $debetCreditDetailKewajibanLancar+$beginningBalanceDetailKewajibanLancar;
			$debetCreditDetailKewajibanLancars[] = $subTotalDetailKewajibanLancar;
			$nominalDetailKewajibanLancar = $this->Krs->cur($subTotalDetailKewajibanLancar);

			//$dataPercentGlobalKewajibanLancar = $grandTotalPercentKewajibanLancar/$totalPercentAktiva*100;
			//$percenKewajibanLancar = $subTotalDetailKewajibanLancar/$grandTotalPercentKewajibanLancar*$dataPercentGlobalKewajibanLancar;
			//$nominalPercenKewajibanLancar = $this->Krs->percent($percenKewajibanLancar).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailKewajibanLancar.') '.$nameDetailKewajibanLancar.'</td>
					<td align="right">'.$nominalDetailKewajibanLancar.'</td>
					';
					//<td align="right">'.$nominalPercenKewajibanLancar.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailKewajibanLancar['Level5']) && $detailKewajibanLancar['Level4']) {
		list($codeKewajibanLancar, $nameKewajibanLancar) = explode('^', $detailKewajibanLancar['Level4']);

		if(!empty($codeKewajibanLancar)) {
			$totalLevel4KewajibanLancar = array_sum($debetCreditDetailKewajibanLancars);
			$nominalTotalLevel4KewajibanLancar = $this->Krs->cur($totalLevel4KewajibanLancar);
			$grandTotalKewajibanLancars[] = $totalLevel4KewajibanLancar;
			//$percenKewajibanLancarBank = $subTotalDetailKewajibanLancarBank/$grandTotalPercentKewajibanLancarBank*$dataPercentGlobalKewajibanLancar;
			//$percenKewajibanLancarBank = 0;
			
			//Percent
			// $dataPercentGlobalKewajibanLancar = $totalLevel4KewajibanLancar/$totalPercentAktiva*100;
			// $nominalPercenKewajibanLancar = $this->Krs->percent($dataPercentGlobalKewajibanLancar).'%';

			//$percenTotalKewajibanLancar = $totalLevel4KewajibanLancar/$totalPercentAktiva*100;
			//$nominalGrandPercentKewajibanLancar = $this->Krs->percent($percenTotalKewajibanLancar).'%';
			$titleTotalKewajibanLancar = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeKewajibanLancar.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalKewajibanLancar.' '.strtoupper($nameKewajibanLancar).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4KewajibanLancar.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenKewajibanLancar.'</b></td>		
		}
	}
}


// HutangUsaha
//pr($listCOAHutangUsaha);
$grandTotalHutangUsahas = array();
foreach ($listCOAHutangUsaha as $idHutangUsaha => $detailHutangUsaha) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangUsaha
		if(isset($detailHutangUsaha['Level5']) && $detailHutangUsaha['Level4']) {
			list($codeHutangUsaha, $nameHutangUsaha) = explode('^', $detailHutangUsaha['Level4']);

			if(!empty($codeHutangUsaha)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangUsaha).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangUsaha['Level5']) && $detailHutangUsaha['Level5']) {
		$debetCreditDetailHutangUsahas = array();
		foreach ($detailHutangUsaha['Level5'] as $dataCOAHutangUsaha) {
			list($codeDetailHutangUsaha, $nameDetailHutangUsaha, $debetCreditDetailHutangUsaha, $beginningBalanceDetailHutangUsaha, $subTotalDetailHutangUsaha) = explode('^', $dataCOAHutangUsaha);
			//$totalHutangUsahas = $debetCreditDetailHutangUsaha+$beginningBalanceDetailHutangUsaha;
			$debetCreditDetailHutangUsahas[] = $subTotalDetailHutangUsaha;
			$nominalDetailHutangUsaha = $this->Krs->cur($subTotalDetailHutangUsaha);

			//$dataPercentGlobalHutangUsaha = $grandTotalPercentHutangUsaha/$totalPercentAktiva*100;
			//$percenHutangUsaha = $subTotalDetailHutangUsaha/$grandTotalPercentHutangUsaha*$dataPercentGlobalHutangUsaha;
			//$nominalPercenHutangUsaha = $this->Krs->percent($percenHutangUsaha).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangUsaha.') '.$nameDetailHutangUsaha.'</td>
					<td align="right">'.$nominalDetailHutangUsaha.'</td>
					';
					//<td align="right">'.$nominalPercenHutangUsaha.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangUsaha['Level5']) && $detailHutangUsaha['Level4']) {
		list($codeHutangUsaha, $nameHutangUsaha) = explode('^', $detailHutangUsaha['Level4']);

		if(!empty($codeHutangUsaha)) {
			$totalLevel4HutangUsaha = array_sum($debetCreditDetailHutangUsahas);
			$nominalTotalLevel4HutangUsaha = $this->Krs->cur($totalLevel4HutangUsaha);
			$grandTotalHutangUsahas[] = $totalLevel4HutangUsaha;
			//$percenHutangUsahaBank = $subTotalDetailHutangUsahaBank/$grandTotalPercentHutangUsahaBank*$dataPercentGlobalHutangUsaha;
			//$percenHutangUsahaBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangUsaha = $totalLevel4HutangUsaha/$totalPercentAktiva*100;
			// $nominalPercenHutangUsaha = $this->Krs->percent($dataPercentGlobalHutangUsaha).'%';

			//$percenTotalHutangUsaha = $totalLevel4HutangUsaha/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangUsaha = $this->Krs->percent($percenTotalHutangUsaha).'%';
			$titleTotalHutangUsaha = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangUsaha.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangUsaha.' '.strtoupper($nameHutangUsaha).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangUsaha.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangUsaha.'</b></td>		
		}
	}
}


// HutangAfiliasi
$grandTotalHutangAfiliasis = array();
foreach ($listCOAHutangAfiliasi as $idHutangAfiliasi => $detailHutangAfiliasi) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangAfiliasi
		if(isset($detailHutangAfiliasi['Level5']) && $detailHutangAfiliasi['Level4']) {
			list($codeHutangAfiliasi, $nameHutangAfiliasi) = explode('^', $detailHutangAfiliasi['Level4']);

			if(!empty($codeHutangAfiliasi)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangAfiliasi).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangAfiliasi['Level5']) && $detailHutangAfiliasi['Level5']) {
		$debetCreditDetailHutangAfiliasis = array();
		foreach ($detailHutangAfiliasi['Level5'] as $dataCOAHutangAfiliasi) {
			list($codeDetailHutangAfiliasi, $nameDetailHutangAfiliasi, $debetCreditDetailHutangAfiliasi, $beginningBalanceDetailHutangAfiliasi, $subTotalDetailHutangAfiliasi) = explode('^', $dataCOAHutangAfiliasi);
			//$totalHutangAfiliasis = $debetCreditDetailHutangAfiliasi+$beginningBalanceDetailHutangAfiliasi;
			$debetCreditDetailHutangAfiliasis[] = $subTotalDetailHutangAfiliasi;
			$nominalDetailHutangAfiliasi = $this->Krs->cur($subTotalDetailHutangAfiliasi);

			//$dataPercentGlobalHutangAfiliasi = $grandTotalPercentHutangAfiliasi/$totalPercentAktiva*100;
			//$percenHutangAfiliasi = $subTotalDetailHutangAfiliasi/$grandTotalPercentHutangAfiliasi*$dataPercentGlobalHutangAfiliasi;
			//$nominalPercenHutangAfiliasi = $this->Krs->percent($percenHutangAfiliasi).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangAfiliasi.') '.$nameDetailHutangAfiliasi.'</td>
					<td align="right">'.$nominalDetailHutangAfiliasi.'</td>
					';
					//<td align="right">'.$nominalPercenHutangAfiliasi.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangAfiliasi['Level5']) && $detailHutangAfiliasi['Level4']) {
		list($codeHutangAfiliasi, $nameHutangAfiliasi) = explode('^', $detailHutangAfiliasi['Level4']);

		if(!empty($codeHutangAfiliasi)) {
			$totalLevel4HutangAfiliasi = array_sum($debetCreditDetailHutangAfiliasis);
			$nominalTotalLevel4HutangAfiliasi = $this->Krs->cur($totalLevel4HutangAfiliasi);
			$grandTotalHutangAfiliasis[] = $totalLevel4HutangAfiliasi;
			//$percenHutangAfiliasiBank = $subTotalDetailHutangAfiliasiBank/$grandTotalPercentHutangAfiliasiBank*$dataPercentGlobalHutangAfiliasi;
			//$percenHutangAfiliasiBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangAfiliasi = $totalLevel4HutangAfiliasi/$totalPercentAktiva*100;
			// $nominalPercenHutangAfiliasi = $this->Krs->percent($dataPercentGlobalHutangAfiliasi).'%';

			//$percenTotalHutangAfiliasi = $totalLevel4HutangAfiliasi/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangAfiliasi = $this->Krs->percent($percenTotalHutangAfiliasi).'%';
			$titleTotalHutangAfiliasi = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangAfiliasi.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangAfiliasi.' '.strtoupper($nameHutangAfiliasi).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangAfiliasi.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangAfiliasi.'</b></td>		
		}
	}
}


// PendapatanDiterimaDimuka
$grandTotalPendapatanDiterimaDimukas = array();
foreach ($listCOAPendapatanDiterimaDimuka as $idPendapatanDiterimaDimuka => $detailPendapatanDiterimaDimuka) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada PendapatanDiterimaDimuka
		if(isset($detailPendapatanDiterimaDimuka['Level5']) && $detailPendapatanDiterimaDimuka['Level4']) {
			list($codePendapatanDiterimaDimuka, $namePendapatanDiterimaDimuka) = explode('^', $detailPendapatanDiterimaDimuka['Level4']);

			if(!empty($codePendapatanDiterimaDimuka)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($namePendapatanDiterimaDimuka).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailPendapatanDiterimaDimuka['Level5']) && $detailPendapatanDiterimaDimuka['Level5']) {
		$debetCreditDetailPendapatanDiterimaDimukas = array();
		foreach ($detailPendapatanDiterimaDimuka['Level5'] as $dataCOAPendapatanDiterimaDimuka) {
			list($codeDetailPendapatanDiterimaDimuka, $nameDetailPendapatanDiterimaDimuka, $debetCreditDetailPendapatanDiterimaDimuka, $beginningBalanceDetailPendapatanDiterimaDimuka, $subTotalDetailPendapatanDiterimaDimuka) = explode('^', $dataCOAPendapatanDiterimaDimuka);
			//$totalPendapatanDiterimaDimukas = $debetCreditDetailPendapatanDiterimaDimuka+$beginningBalanceDetailPendapatanDiterimaDimuka;
			$debetCreditDetailPendapatanDiterimaDimukas[] = $subTotalDetailPendapatanDiterimaDimuka;
			$nominalDetailPendapatanDiterimaDimuka = $this->Krs->cur($subTotalDetailPendapatanDiterimaDimuka);

			//$dataPercentGlobalPendapatanDiterimaDimuka = $grandTotalPercentPendapatanDiterimaDimuka/$totalPercentAktiva*100;
			//$percenPendapatanDiterimaDimuka = $subTotalDetailPendapatanDiterimaDimuka/$grandTotalPercentPendapatanDiterimaDimuka*$dataPercentGlobalPendapatanDiterimaDimuka;
			//$nominalPercenPendapatanDiterimaDimuka = $this->Krs->percent($percenPendapatanDiterimaDimuka).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailPendapatanDiterimaDimuka.') '.$nameDetailPendapatanDiterimaDimuka.'</td>
					<td align="right">'.$nominalDetailPendapatanDiterimaDimuka.'</td>
					';
					//<td align="right">'.$nominalPercenPendapatanDiterimaDimuka.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailPendapatanDiterimaDimuka['Level5']) && $detailPendapatanDiterimaDimuka['Level4']) {
		list($codePendapatanDiterimaDimuka, $namePendapatanDiterimaDimuka) = explode('^', $detailPendapatanDiterimaDimuka['Level4']);

		if(!empty($codePendapatanDiterimaDimuka)) {
			$totalLevel4PendapatanDiterimaDimuka = array_sum($debetCreditDetailPendapatanDiterimaDimukas);
			$nominalTotalLevel4PendapatanDiterimaDimuka = $this->Krs->cur($totalLevel4PendapatanDiterimaDimuka);
			$grandTotalPendapatanDiterimaDimukas[] = $totalLevel4PendapatanDiterimaDimuka;
			//$percenPendapatanDiterimaDimukaBank = $subTotalDetailPendapatanDiterimaDimukaBank/$grandTotalPercentPendapatanDiterimaDimukaBank*$dataPercentGlobalPendapatanDiterimaDimuka;
			//$percenPendapatanDiterimaDimukaBank = 0;
			
			//Percent
			// $dataPercentGlobalPendapatanDiterimaDimuka = $totalLevel4PendapatanDiterimaDimuka/$totalPercentAktiva*100;
			// $nominalPercenPendapatanDiterimaDimuka = $this->Krs->percent($dataPercentGlobalPendapatanDiterimaDimuka).'%';

			//$percenTotalPendapatanDiterimaDimuka = $totalLevel4PendapatanDiterimaDimuka/$totalPercentAktiva*100;
			//$nominalGrandPercentPendapatanDiterimaDimuka = $this->Krs->percent($percenTotalPendapatanDiterimaDimuka).'%';
			$titleTotalPendapatanDiterimaDimuka = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codePendapatanDiterimaDimuka.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalPendapatanDiterimaDimuka.' '.strtoupper($namePendapatanDiterimaDimuka).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4PendapatanDiterimaDimuka.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenPendapatanDiterimaDimuka.'</b></td>		
		}
	}
}


// BiayaYangMasihHarusDibayar
$grandTotalBiayaYangMasihHarusDibayars = array();
foreach ($listCOABiayaYangMasihHarusDibayar as $idBiayaYangMasihHarusDibayar => $detailBiayaYangMasihHarusDibayar) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada BiayaYangMasihHarusDibayar
		if(isset($detailBiayaYangMasihHarusDibayar['Level5']) && $detailBiayaYangMasihHarusDibayar['Level4']) {
			list($codeBiayaYangMasihHarusDibayar, $nameBiayaYangMasihHarusDibayar) = explode('^', $detailBiayaYangMasihHarusDibayar['Level4']);

			if(!empty($codeBiayaYangMasihHarusDibayar)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameBiayaYangMasihHarusDibayar).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailBiayaYangMasihHarusDibayar['Level5']) && $detailBiayaYangMasihHarusDibayar['Level5']) {
		$debetCreditDetailBiayaYangMasihHarusDibayars = array();
		foreach ($detailBiayaYangMasihHarusDibayar['Level5'] as $dataCOABiayaYangMasihHarusDibayar) {
			list($codeDetailBiayaYangMasihHarusDibayar, $nameDetailBiayaYangMasihHarusDibayar, $debetCreditDetailBiayaYangMasihHarusDibayar, $beginningBalanceDetailBiayaYangMasihHarusDibayar, $subTotalDetailBiayaYangMasihHarusDibayar) = explode('^', $dataCOABiayaYangMasihHarusDibayar);
			//$totalBiayaYangMasihHarusDibayars = $debetCreditDetailBiayaYangMasihHarusDibayar+$beginningBalanceDetailBiayaYangMasihHarusDibayar;
			$debetCreditDetailBiayaYangMasihHarusDibayars[] = $subTotalDetailBiayaYangMasihHarusDibayar;
			$nominalDetailBiayaYangMasihHarusDibayar = $this->Krs->cur($subTotalDetailBiayaYangMasihHarusDibayar);

			//$dataPercentGlobalBiayaYangMasihHarusDibayar = $grandTotalPercentBiayaYangMasihHarusDibayar/$totalPercentAktiva*100;
			//$percenBiayaYangMasihHarusDibayar = $subTotalDetailBiayaYangMasihHarusDibayar/$grandTotalPercentBiayaYangMasihHarusDibayar*$dataPercentGlobalBiayaYangMasihHarusDibayar;
			//$nominalPercenBiayaYangMasihHarusDibayar = $this->Krs->percent($percenBiayaYangMasihHarusDibayar).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailBiayaYangMasihHarusDibayar.') '.$nameDetailBiayaYangMasihHarusDibayar.'</td>
					<td align="right">'.$nominalDetailBiayaYangMasihHarusDibayar.'</td>
					';
					//<td align="right">'.$nominalPercenBiayaYangMasihHarusDibayar.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailBiayaYangMasihHarusDibayar['Level5']) && $detailBiayaYangMasihHarusDibayar['Level4']) {
		list($codeBiayaYangMasihHarusDibayar, $nameBiayaYangMasihHarusDibayar) = explode('^', $detailBiayaYangMasihHarusDibayar['Level4']);

		if(!empty($codeBiayaYangMasihHarusDibayar)) {
			$totalLevel4BiayaYangMasihHarusDibayar = array_sum($debetCreditDetailBiayaYangMasihHarusDibayars);
			$nominalTotalLevel4BiayaYangMasihHarusDibayar = $this->Krs->cur($totalLevel4BiayaYangMasihHarusDibayar);
			$grandTotalBiayaYangMasihHarusDibayars[] = $totalLevel4BiayaYangMasihHarusDibayar;
			//$percenBiayaYangMasihHarusDibayarBank = $subTotalDetailBiayaYangMasihHarusDibayarBank/$grandTotalPercentBiayaYangMasihHarusDibayarBank*$dataPercentGlobalBiayaYangMasihHarusDibayar;
			//$percenBiayaYangMasihHarusDibayarBank = 0;
			
			//Percent
			// $dataPercentGlobalBiayaYangMasihHarusDibayar = $totalLevel4BiayaYangMasihHarusDibayar/$totalPercentAktiva*100;
			// $nominalPercenBiayaYangMasihHarusDibayar = $this->Krs->percent($dataPercentGlobalBiayaYangMasihHarusDibayar).'%';

			//$percenTotalBiayaYangMasihHarusDibayar = $totalLevel4BiayaYangMasihHarusDibayar/$totalPercentAktiva*100;
			//$nominalGrandPercentBiayaYangMasihHarusDibayar = $this->Krs->percent($percenTotalBiayaYangMasihHarusDibayar).'%';
			$titleTotalBiayaYangMasihHarusDibayar = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeBiayaYangMasihHarusDibayar.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalBiayaYangMasihHarusDibayar.' '.strtoupper($nameBiayaYangMasihHarusDibayar).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4BiayaYangMasihHarusDibayar.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenBiayaYangMasihHarusDibayar.'</b></td>		
		}
	}
}


// HutangPajak
$grandTotalHutangPajaks = array();
foreach ($listCOAHutangPajak as $idHutangPajak => $detailHutangPajak) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangPajak
		if(isset($detailHutangPajak['Level5']) && $detailHutangPajak['Level4']) {
			list($codeHutangPajak, $nameHutangPajak) = explode('^', $detailHutangPajak['Level4']);

			if(!empty($codeHutangPajak)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangPajak).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangPajak['Level5']) && $detailHutangPajak['Level5']) {
		$debetCreditDetailHutangPajaks = array();
		foreach ($detailHutangPajak['Level5'] as $dataCOAHutangPajak) {
			list($codeDetailHutangPajak, $nameDetailHutangPajak, $debetCreditDetailHutangPajak, $beginningBalanceDetailHutangPajak, $subTotalDetailHutangPajak) = explode('^', $dataCOAHutangPajak);
			//$totalHutangPajaks = $debetCreditDetailHutangPajak+$beginningBalanceDetailHutangPajak;
			$debetCreditDetailHutangPajaks[] = $subTotalDetailHutangPajak;
			$nominalDetailHutangPajak = $this->Krs->cur($subTotalDetailHutangPajak);

			//$dataPercentGlobalHutangPajak = $grandTotalPercentHutangPajak/$totalPercentAktiva*100;
			//$percenHutangPajak = $subTotalDetailHutangPajak/$grandTotalPercentHutangPajak*$dataPercentGlobalHutangPajak;
			//$nominalPercenHutangPajak = $this->Krs->percent($percenHutangPajak).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangPajak.') '.$nameDetailHutangPajak.'</td>
					<td align="right">'.$nominalDetailHutangPajak.'</td>
					';
					//<td align="right">'.$nominalPercenHutangPajak.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangPajak['Level5']) && $detailHutangPajak['Level4']) {
		list($codeHutangPajak, $nameHutangPajak) = explode('^', $detailHutangPajak['Level4']);

		if(!empty($codeHutangPajak)) {
			$totalLevel4HutangPajak = array_sum($debetCreditDetailHutangPajaks);
			$nominalTotalLevel4HutangPajak = $this->Krs->cur($totalLevel4HutangPajak);
			$grandTotalHutangPajaks[] = $totalLevel4HutangPajak;
			//$percenHutangPajakBank = $subTotalDetailHutangPajakBank/$grandTotalPercentHutangPajakBank*$dataPercentGlobalHutangPajak;
			//$percenHutangPajakBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangPajak = $totalLevel4HutangPajak/$totalPercentAktiva*100;
			// $nominalPercenHutangPajak = $this->Krs->percent($dataPercentGlobalHutangPajak).'%';

			//$percenTotalHutangPajak = $totalLevel4HutangPajak/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangPajak = $this->Krs->percent($percenTotalHutangPajak).'%';
			$titleTotalHutangPajak = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangPajak.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangPajak.' '.strtoupper($nameHutangPajak).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangPajak.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangPajak.'</b></td>		
		}
	}
}


// HutangBank
$grandTotalHutangBanks = array();
foreach ($listCOAHutangBank as $idHutangBank => $detailHutangBank) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangBank
		if(isset($detailHutangBank['Level5']) && $detailHutangBank['Level4']) {
			list($codeHutangBank, $nameHutangBank) = explode('^', $detailHutangBank['Level4']);

			if(!empty($codeHutangBank)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangBank).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangBank['Level5']) && $detailHutangBank['Level5']) {
		$debetCreditDetailHutangBanks = array();
		foreach ($detailHutangBank['Level5'] as $dataCOAHutangBank) {
			list($codeDetailHutangBank, $nameDetailHutangBank, $debetCreditDetailHutangBank, $beginningBalanceDetailHutangBank, $subTotalDetailHutangBank) = explode('^', $dataCOAHutangBank);
			//$totalHutangBanks = $debetCreditDetailHutangBank+$beginningBalanceDetailHutangBank;
			$debetCreditDetailHutangBanks[] = $subTotalDetailHutangBank;
			$nominalDetailHutangBank = $this->Krs->cur($subTotalDetailHutangBank);

			//$dataPercentGlobalHutangBank = $grandTotalPercentHutangBank/$totalPercentAktiva*100;
			//$percenHutangBank = $subTotalDetailHutangBank/$grandTotalPercentHutangBank*$dataPercentGlobalHutangBank;
			//$nominalPercenHutangBank = $this->Krs->percent($percenHutangBank).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangBank.') '.$nameDetailHutangBank.'</td>
					<td align="right">'.$nominalDetailHutangBank.'</td>
					';
					//<td align="right">'.$nominalPercenHutangBank.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangBank['Level5']) && $detailHutangBank['Level4']) {
		list($codeHutangBank, $nameHutangBank) = explode('^', $detailHutangBank['Level4']);

		if(!empty($codeHutangBank)) {
			$totalLevel4HutangBank = array_sum($debetCreditDetailHutangBanks);
			$nominalTotalLevel4HutangBank = $this->Krs->cur($totalLevel4HutangBank);
			$grandTotalHutangBanks[] = $totalLevel4HutangBank;
			//$percenHutangBankBank = $subTotalDetailHutangBankBank/$grandTotalPercentHutangBankBank*$dataPercentGlobalHutangBank;
			//$percenHutangBankBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangBank = $totalLevel4HutangBank/$totalPercentAktiva*100;
			// $nominalPercenHutangBank = $this->Krs->percent($dataPercentGlobalHutangBank).'%';

			//$percenTotalHutangBank = $totalLevel4HutangBank/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangBank = $this->Krs->percent($percenTotalHutangBank).'%';
			$titleTotalHutangBank = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangBank.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangBank.' '.strtoupper($nameHutangBank).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangBank.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangBank.'</b></td>		
		}
	}
}


// HutangLeasing
$grandTotalHutangLeasings = array();
foreach ($listCOAHutangLeasing as $idHutangLeasing => $detailHutangLeasing) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangLeasing
		if(isset($detailHutangLeasing['Level5']) && $detailHutangLeasing['Level4']) {
			list($codeHutangLeasing, $nameHutangLeasing) = explode('^', $detailHutangLeasing['Level4']);

			if(!empty($codeHutangLeasing)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangLeasing).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangLeasing['Level5']) && $detailHutangLeasing['Level5']) {
		$debetCreditDetailHutangLeasings = array();
		foreach ($detailHutangLeasing['Level5'] as $dataCOAHutangLeasing) {
			list($codeDetailHutangLeasing, $nameDetailHutangLeasing, $debetCreditDetailHutangLeasing, $beginningBalanceDetailHutangLeasing, $subTotalDetailHutangLeasing) = explode('^', $dataCOAHutangLeasing);
			//$totalHutangLeasings = $debetCreditDetailHutangLeasing+$beginningBalanceDetailHutangLeasing;
			$debetCreditDetailHutangLeasings[] = $subTotalDetailHutangLeasing;
			$nominalDetailHutangLeasing = $this->Krs->cur($subTotalDetailHutangLeasing);

			//$dataPercentGlobalHutangLeasing = $grandTotalPercentHutangLeasing/$totalPercentAktiva*100;
			//$percenHutangLeasing = $subTotalDetailHutangLeasing/$grandTotalPercentHutangLeasing*$dataPercentGlobalHutangLeasing;
			//$nominalPercenHutangLeasing = $this->Krs->percent($percenHutangLeasing).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangLeasing.') '.$nameDetailHutangLeasing.'</td>
					<td align="right">'.$nominalDetailHutangLeasing.'</td>
					';
					//<td align="right">'.$nominalPercenHutangLeasing.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangLeasing['Level5']) && $detailHutangLeasing['Level4']) {
		list($codeHutangLeasing, $nameHutangLeasing) = explode('^', $detailHutangLeasing['Level4']);

		if(!empty($codeHutangLeasing)) {
			$totalLevel4HutangLeasing = array_sum($debetCreditDetailHutangLeasings);
			$nominalTotalLevel4HutangLeasing = $this->Krs->cur($totalLevel4HutangLeasing);
			$grandTotalHutangLeasings[] = $totalLevel4HutangLeasing;
			//$percenHutangLeasingBank = $subTotalDetailHutangLeasingBank/$grandTotalPercentHutangLeasingBank*$dataPercentGlobalHutangLeasing;
			//$percenHutangLeasingBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangLeasing = $totalLevel4HutangLeasing/$totalPercentAktiva*100;
			// $nominalPercenHutangLeasing = $this->Krs->percent($dataPercentGlobalHutangLeasing).'%';

			//$percenTotalHutangLeasing = $totalLevel4HutangLeasing/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangLeasing = $this->Krs->percent($percenTotalHutangLeasing).'%';
			$titleTotalHutangLeasing = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangLeasing.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangLeasing.' '.strtoupper($nameHutangLeasing).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangLeasing.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangLeasing.'</b></td>		
		}
	}
}


// HutangPemegangSaham
$grandTotalHutangPemegangSahams = array();
foreach ($listCOAHutangPemegangSaham as $idHutangPemegangSaham => $detailHutangPemegangSaham) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangPemegangSaham
		if(isset($detailHutangPemegangSaham['Level5']) && $detailHutangPemegangSaham['Level4']) {
			list($codeHutangPemegangSaham, $nameHutangPemegangSaham) = explode('^', $detailHutangPemegangSaham['Level4']);

			if(!empty($codeHutangPemegangSaham)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangPemegangSaham).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangPemegangSaham['Level5']) && $detailHutangPemegangSaham['Level5']) {
		$debetCreditDetailHutangPemegangSahams = array();
		foreach ($detailHutangPemegangSaham['Level5'] as $dataCOAHutangPemegangSaham) {
			list($codeDetailHutangPemegangSaham, $nameDetailHutangPemegangSaham, $debetCreditDetailHutangPemegangSaham, $beginningBalanceDetailHutangPemegangSaham, $subTotalDetailHutangPemegangSaham) = explode('^', $dataCOAHutangPemegangSaham);
			//$totalHutangPemegangSahams = $debetCreditDetailHutangPemegangSaham+$beginningBalanceDetailHutangPemegangSaham;
			$debetCreditDetailHutangPemegangSahams[] = $subTotalDetailHutangPemegangSaham;
			$nominalDetailHutangPemegangSaham = $this->Krs->cur($subTotalDetailHutangPemegangSaham);

			//$dataPercentGlobalHutangPemegangSaham = $grandTotalPercentHutangPemegangSaham/$totalPercentAktiva*100;
			//$percenHutangPemegangSaham = $subTotalDetailHutangPemegangSaham/$grandTotalPercentHutangPemegangSaham*$dataPercentGlobalHutangPemegangSaham;
			//$nominalPercenHutangPemegangSaham = $this->Krs->percent($percenHutangPemegangSaham).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangPemegangSaham.') '.$nameDetailHutangPemegangSaham.'</td>
					<td align="right">'.$nominalDetailHutangPemegangSaham.'</td>
					';
					//<td align="right">'.$nominalPercenHutangPemegangSaham.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangPemegangSaham['Level5']) && $detailHutangPemegangSaham['Level4']) {
		list($codeHutangPemegangSaham, $nameHutangPemegangSaham) = explode('^', $detailHutangPemegangSaham['Level4']);

		if(!empty($codeHutangPemegangSaham)) {
			$totalLevel4HutangPemegangSaham = array_sum($debetCreditDetailHutangPemegangSahams);
			$nominalTotalLevel4HutangPemegangSaham = $this->Krs->cur($totalLevel4HutangPemegangSaham);
			$grandTotalHutangPemegangSahams[] = $totalLevel4HutangPemegangSaham;
			//$percenHutangPemegangSahamBank = $subTotalDetailHutangPemegangSahamBank/$grandTotalPercentHutangPemegangSahamBank*$dataPercentGlobalHutangPemegangSaham;
			//$percenHutangPemegangSahamBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangPemegangSaham = $totalLevel4HutangPemegangSaham/$totalPercentAktiva*100;
			// $nominalPercenHutangPemegangSaham = $this->Krs->percent($dataPercentGlobalHutangPemegangSaham).'%';

			//$percenTotalHutangPemegangSaham = $totalLevel4HutangPemegangSaham/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangPemegangSaham = $this->Krs->percent($percenTotalHutangPemegangSaham).'%';
			$titleTotalHutangPemegangSaham = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangPemegangSaham.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangPemegangSaham.' '.strtoupper($nameHutangPemegangSaham).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangPemegangSaham.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangPemegangSaham.'</b></td>		
		}
	}
}


// HutangKaryawan
$grandTotalHutangKaryawans = array();
foreach ($listCOAHutangKaryawan as $idHutangKaryawan => $detailHutangKaryawan) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangKaryawan
		if(isset($detailHutangKaryawan['Level5']) && $detailHutangKaryawan['Level4']) {
			list($codeHutangKaryawan, $nameHutangKaryawan) = explode('^', $detailHutangKaryawan['Level4']);

			if(!empty($codeHutangKaryawan)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangKaryawan).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangKaryawan['Level5']) && $detailHutangKaryawan['Level5']) {
		$debetCreditDetailHutangKaryawans = array();
		foreach ($detailHutangKaryawan['Level5'] as $dataCOAHutangKaryawan) {
			list($codeDetailHutangKaryawan, $nameDetailHutangKaryawan, $debetCreditDetailHutangKaryawan, $beginningBalanceDetailHutangKaryawan, $subTotalDetailHutangKaryawan) = explode('^', $dataCOAHutangKaryawan);
			//$totalHutangKaryawans = $debetCreditDetailHutangKaryawan+$beginningBalanceDetailHutangKaryawan;
			$debetCreditDetailHutangKaryawans[] = $subTotalDetailHutangKaryawan;
			$nominalDetailHutangKaryawan = $this->Krs->cur($subTotalDetailHutangKaryawan);

			//$dataPercentGlobalHutangKaryawan = $grandTotalPercentHutangKaryawan/$totalPercentAktiva*100;
			//$percenHutangKaryawan = $subTotalDetailHutangKaryawan/$grandTotalPercentHutangKaryawan*$dataPercentGlobalHutangKaryawan;
			//$nominalPercenHutangKaryawan = $this->Krs->percent($percenHutangKaryawan).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangKaryawan.') '.$nameDetailHutangKaryawan.'</td>
					<td align="right">'.$nominalDetailHutangKaryawan.'</td>
					';
					//<td align="right">'.$nominalPercenHutangKaryawan.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangKaryawan['Level5']) && $detailHutangKaryawan['Level4']) {
		list($codeHutangKaryawan, $nameHutangKaryawan) = explode('^', $detailHutangKaryawan['Level4']);

		if(!empty($codeHutangKaryawan)) {
			$totalLevel4HutangKaryawan = array_sum($debetCreditDetailHutangKaryawans);
			$nominalTotalLevel4HutangKaryawan = $this->Krs->cur($totalLevel4HutangKaryawan);
			$grandTotalHutangKaryawans[] = $totalLevel4HutangKaryawan;
			//$percenHutangKaryawanBank = $subTotalDetailHutangKaryawanBank/$grandTotalPercentHutangKaryawanBank*$dataPercentGlobalHutangKaryawan;
			//$percenHutangKaryawanBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangKaryawan = $totalLevel4HutangKaryawan/$totalPercentAktiva*100;
			// $nominalPercenHutangKaryawan = $this->Krs->percent($dataPercentGlobalHutangKaryawan).'%';

			//$percenTotalHutangKaryawan = $totalLevel4HutangKaryawan/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangKaryawan = $this->Krs->percent($percenTotalHutangKaryawan).'%';
			$titleTotalHutangKaryawan = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangKaryawan.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangKaryawan.' '.strtoupper($nameHutangKaryawan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangKaryawan.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangKaryawan.'</b></td>		
		}
	}
}


// HutangLainLain
$grandTotalHutangLainLains = array();
foreach ($listCOAHutangLainLain as $idHutangLainLain => $detailHutangLainLain) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada HutangLainLain
		if(isset($detailHutangLainLain['Level5']) && $detailHutangLainLain['Level4']) {
			list($codeHutangLainLain, $nameHutangLainLain) = explode('^', $detailHutangLainLain['Level4']);

			if(!empty($codeHutangLainLain)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameHutangLainLain).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailHutangLainLain['Level5']) && $detailHutangLainLain['Level5']) {
		$debetCreditDetailHutangLainLains = array();
		foreach ($detailHutangLainLain['Level5'] as $dataCOAHutangLainLain) {
			list($codeDetailHutangLainLain, $nameDetailHutangLainLain, $debetCreditDetailHutangLainLain, $beginningBalanceDetailHutangLainLain, $subTotalDetailHutangLainLain) = explode('^', $dataCOAHutangLainLain);
			//$totalHutangLainLains = $debetCreditDetailHutangLainLain+$beginningBalanceDetailHutangLainLain;
			$debetCreditDetailHutangLainLains[] = $subTotalDetailHutangLainLain;
			$nominalDetailHutangLainLain = $this->Krs->cur($subTotalDetailHutangLainLain);

			//$dataPercentGlobalHutangLainLain = $grandTotalPercentHutangLainLain/$totalPercentAktiva*100;
			//$percenHutangLainLain = $subTotalDetailHutangLainLain/$grandTotalPercentHutangLainLain*$dataPercentGlobalHutangLainLain;
			//$nominalPercenHutangLainLain = $this->Krs->percent($percenHutangLainLain).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailHutangLainLain.') '.$nameDetailHutangLainLain.'</td>
					<td align="right">'.$nominalDetailHutangLainLain.'</td>
					';
					//<td align="right">'.$nominalPercenHutangLainLain.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailHutangLainLain['Level5']) && $detailHutangLainLain['Level4']) {
		list($codeHutangLainLain, $nameHutangLainLain) = explode('^', $detailHutangLainLain['Level4']);

		if(!empty($codeHutangLainLain)) {
			$totalLevel4HutangLainLain = array_sum($debetCreditDetailHutangLainLains);
			$nominalTotalLevel4HutangLainLain = $this->Krs->cur($totalLevel4HutangLainLain);
			$grandTotalHutangLainLains[] = $totalLevel4HutangLainLain;
			//$percenHutangLainLainBank = $subTotalDetailHutangLainLainBank/$grandTotalPercentHutangLainLainBank*$dataPercentGlobalHutangLainLain;
			//$percenHutangLainLainBank = 0;
			
			//Percent
			// $dataPercentGlobalHutangLainLain = $totalLevel4HutangLainLain/$totalPercentAktiva*100;
			// $nominalPercenHutangLainLain = $this->Krs->percent($dataPercentGlobalHutangLainLain).'%';

			//$percenTotalHutangLainLain = $totalLevel4HutangLainLain/$totalPercentAktiva*100;
			//$nominalGrandPercentHutangLainLain = $this->Krs->percent($percenTotalHutangLainLain).'%';
			$titleTotalHutangLainLain = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeHutangLainLain.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalHutangLainLain.' '.strtoupper($nameHutangLainLain).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4HutangLainLain.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenHutangLainLain.'</b></td>		
		}
	}
}

$grandTotalKewajiban = (empty($grandTotalKewajibans)) ? 0 : round(array_sum($grandTotalKewajibans),2);
$grandTotalKewajibanLancar = (empty($grandTotalKewajibanLancars)) ? 0 : round(array_sum($grandTotalKewajibanLancars),2);
$grandTotalHutangUsaha = (empty($grandTotalHutangUsahas)) ? 0 : round(array_sum($grandTotalHutangUsahas),2);
$grandTotalHutangAfiliasi = (empty($grandTotalHutangAfiliasis)) ? 0 : round(array_sum($grandTotalHutangAfiliasis),2);
$grandTotalPendapatanDiterimaDimuka = (empty($grandTotalPendapatanDiterimaDimukas)) ? 0 : round(array_sum($grandTotalPendapatanDiterimaDimukas),2);
$grandTotalBiayaYangMasihHarusDibayar = (empty($grandTotalBiayaYangMasihHarusDibayars)) ? 0 : round(array_sum($grandTotalBiayaYangMasihHarusDibayars),2);
$grandTotalHutangPajak = (empty($grandTotalHutangPajaks)) ? 0 : round(array_sum($grandTotalHutangPajaks),2);
$grandTotalHutangBank = (empty($grandTotalHutangBanks)) ? 0 : round(array_sum($grandTotalHutangBanks),2);
$grandTotalHutangLeasing = (empty($grandTotalHutangLeasings)) ? 0 : round(array_sum($grandTotalHutangLeasings),2);
$grandTotalHutangPemegangSaham = (empty($grandTotalHutangPemegangSahams)) ? 0 : round(array_sum($grandTotalHutangPemegangSahams),2);
$grandTotalHutangKaryawan = (empty($grandTotalHutangKaryawans)) ? 0 : round(array_sum($grandTotalHutangKaryawans),2);
$grandTotalHutangLainLain = (empty($grandTotalHutangLainLains)) ? 0 : round(array_sum($grandTotalHutangLainLains),2);


$totalKewajibanLancar = $grandTotalKewajiban+$grandTotalKewajibanLancar+$grandTotalHutangUsaha+$grandTotalHutangAfiliasi+$grandTotalPendapatanDiterimaDimuka+$grandTotalBiayaYangMasihHarusDibayar+$grandTotalHutangPajak+$grandTotalHutangBank+$grandTotalHutangLeasing+$grandTotalHutangPemegangSaham+$grandTotalHutangKaryawan+$grandTotalHutangLainLain;

echo '<tr>
	<td align="left"><b>Total Kewajiban Lancar</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalKewajibanLancar).'</b></td>
	
</tr>';


echo '<tr>
	<td align="left"><b>Kewajiban Tidak Lancar</b></td>
	<td align="right">&nbsp;</td>
	
</tr>';

// KewajibanTidakLancar
$grandTotalKewajibanTidakLancars = array();
foreach ($listCOAKewajibanTidakLancar as $idKewajibanTidakLancar => $detailKewajibanTidakLancar) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada KewajibanTidakLancar
		if(isset($detailKewajibanTidakLancar['Level5']) && $detailKewajibanTidakLancar['Level4']) {
			list($codeKewajibanTidakLancar, $nameKewajibanTidakLancar) = explode('^', $detailKewajibanTidakLancar['Level4']);

			if(!empty($codeKewajibanTidakLancar)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameKewajibanTidakLancar).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailKewajibanTidakLancar['Level5']) && $detailKewajibanTidakLancar['Level5']) {
		$debetCreditDetailKewajibanTidakLancars = array();
		foreach ($detailKewajibanTidakLancar['Level5'] as $dataCOAKewajibanTidakLancar) {
			list($codeDetailKewajibanTidakLancar, $nameDetailKewajibanTidakLancar, $debetCreditDetailKewajibanTidakLancar, $beginningBalanceDetailKewajibanTidakLancar, $subTotalDetailKewajibanTidakLancar) = explode('^', $dataCOAKewajibanTidakLancar);
			//$totalKewajibanTidakLancars = $debetCreditDetailKewajibanTidakLancar+$beginningBalanceDetailKewajibanTidakLancar;
			$debetCreditDetailKewajibanTidakLancars[] = $subTotalDetailKewajibanTidakLancar;
			$nominalDetailKewajibanTidakLancar = $this->Krs->cur($subTotalDetailKewajibanTidakLancar);

			//$dataPercentGlobalKewajibanTidakLancar = $grandTotalPercentKewajibanTidakLancar/$totalPercentAktiva*100;
			//$percenKewajibanTidakLancar = $subTotalDetailKewajibanTidakLancar/$grandTotalPercentKewajibanTidakLancar*$dataPercentGlobalKewajibanTidakLancar;
			//$nominalPercenKewajibanTidakLancar = $this->Krs->percent($percenKewajibanTidakLancar).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailKewajibanTidakLancar.') '.$nameDetailKewajibanTidakLancar.'</td>
					<td align="right">'.$nominalDetailKewajibanTidakLancar.'</td>
					';
					//<td align="right">'.$nominalPercenKewajibanTidakLancar.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailKewajibanTidakLancar['Level5']) && $detailKewajibanTidakLancar['Level4']) {
		list($codeKewajibanTidakLancar, $nameKewajibanTidakLancar) = explode('^', $detailKewajibanTidakLancar['Level4']);

		if(!empty($codeKewajibanTidakLancar)) {
			$totalLevel4KewajibanTidakLancar = array_sum($debetCreditDetailKewajibanTidakLancars);
			$nominalTotalLevel4KewajibanTidakLancar = $this->Krs->cur($totalLevel4KewajibanTidakLancar);
			$grandTotalKewajibanTidakLancars[] = $totalLevel4KewajibanTidakLancar;
			//$percenKewajibanTidakLancarBank = $subTotalDetailKewajibanTidakLancarBank/$grandTotalPercentKewajibanTidakLancarBank*$dataPercentGlobalKewajibanTidakLancar;
			//$percenKewajibanTidakLancarBank = 0;
			
			//Percent
			// $dataPercentGlobalKewajibanTidakLancar = $totalLevel4KewajibanTidakLancar/$totalPercentAktiva*100;
			// $nominalPercenKewajibanTidakLancar = $this->Krs->percent($dataPercentGlobalKewajibanTidakLancar).'%';

			//$percenTotalKewajibanTidakLancar = $totalLevel4KewajibanTidakLancar/$totalPercentAktiva*100;
			//$nominalGrandPercentKewajibanTidakLancar = $this->Krs->percent($percenTotalKewajibanTidakLancar).'%';
			$titleTotalKewajibanTidakLancar = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeKewajibanTidakLancar.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalKewajibanTidakLancar.' '.strtoupper($nameKewajibanTidakLancar).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4KewajibanTidakLancar.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenKewajibanTidakLancar.'</b></td>		
		}
	}
}


// KewajibanPajakTangguhan
$grandTotalKewajibanPajakTangguhans = array();
foreach ($listCOAKewajibanPajakTangguhan as $idKewajibanPajakTangguhan => $detailKewajibanPajakTangguhan) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada KewajibanPajakTangguhan
		if(isset($detailKewajibanPajakTangguhan['Level5']) && $detailKewajibanPajakTangguhan['Level4']) {
			list($codeKewajibanPajakTangguhan, $nameKewajibanPajakTangguhan) = explode('^', $detailKewajibanPajakTangguhan['Level4']);

			if(!empty($codeKewajibanPajakTangguhan)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameKewajibanPajakTangguhan).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailKewajibanPajakTangguhan['Level5']) && $detailKewajibanPajakTangguhan['Level5']) {
		$debetCreditDetailKewajibanPajakTangguhans = array();
		foreach ($detailKewajibanPajakTangguhan['Level5'] as $dataCOAKewajibanPajakTangguhan) {
			list($codeDetailKewajibanPajakTangguhan, $nameDetailKewajibanPajakTangguhan, $debetCreditDetailKewajibanPajakTangguhan, $beginningBalanceDetailKewajibanPajakTangguhan, $subTotalDetailKewajibanPajakTangguhan) = explode('^', $dataCOAKewajibanPajakTangguhan);
			//$totalKewajibanPajakTangguhans = $debetCreditDetailKewajibanPajakTangguhan+$beginningBalanceDetailKewajibanPajakTangguhan;
			$debetCreditDetailKewajibanPajakTangguhans[] = $subTotalDetailKewajibanPajakTangguhan;
			$nominalDetailKewajibanPajakTangguhan = $this->Krs->cur($subTotalDetailKewajibanPajakTangguhan);

			//$dataPercentGlobalKewajibanPajakTangguhan = $grandTotalPercentKewajibanPajakTangguhan/$totalPercentAktiva*100;
			//$percenKewajibanPajakTangguhan = $subTotalDetailKewajibanPajakTangguhan/$grandTotalPercentKewajibanPajakTangguhan*$dataPercentGlobalKewajibanPajakTangguhan;
			//$nominalPercenKewajibanPajakTangguhan = $this->Krs->percent($percenKewajibanPajakTangguhan).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailKewajibanPajakTangguhan.') '.$nameDetailKewajibanPajakTangguhan.'</td>
					<td align="right">'.$nominalDetailKewajibanPajakTangguhan.'</td>
					';
					//<td align="right">'.$nominalPercenKewajibanPajakTangguhan.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailKewajibanPajakTangguhan['Level5']) && $detailKewajibanPajakTangguhan['Level4']) {
		list($codeKewajibanPajakTangguhan, $nameKewajibanPajakTangguhan) = explode('^', $detailKewajibanPajakTangguhan['Level4']);

		if(!empty($codeKewajibanPajakTangguhan)) {
			$totalLevel4KewajibanPajakTangguhan = array_sum($debetCreditDetailKewajibanPajakTangguhans);
			$nominalTotalLevel4KewajibanPajakTangguhan = $this->Krs->cur($totalLevel4KewajibanPajakTangguhan);
			$grandTotalKewajibanPajakTangguhans[] = $totalLevel4KewajibanPajakTangguhan;
			//$percenKewajibanPajakTangguhanBank = $subTotalDetailKewajibanPajakTangguhanBank/$grandTotalPercentKewajibanPajakTangguhanBank*$dataPercentGlobalKewajibanPajakTangguhan;
			//$percenKewajibanPajakTangguhanBank = 0;
			
			//Percent
			// $dataPercentGlobalKewajibanPajakTangguhan = $totalLevel4KewajibanPajakTangguhan/$totalPercentAktiva*100;
			// $nominalPercenKewajibanPajakTangguhan = $this->Krs->percent($dataPercentGlobalKewajibanPajakTangguhan).'%';

			//$percenTotalKewajibanPajakTangguhan = $totalLevel4KewajibanPajakTangguhan/$totalPercentAktiva*100;
			//$nominalGrandPercentKewajibanPajakTangguhan = $this->Krs->percent($percenTotalKewajibanPajakTangguhan).'%';
			$titleTotalKewajibanPajakTangguhan = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeKewajibanPajakTangguhan.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalKewajibanPajakTangguhan.' '.strtoupper($nameKewajibanPajakTangguhan).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4KewajibanPajakTangguhan.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenKewajibanPajakTangguhan.'</b></td>		
		}
	}
}

$grandTotalKewajibanTidakLancar = (empty($grandTotalKewajibanTidakLancars)) ? 0 : round(array_sum($grandTotalKewajibanTidakLancars),2);
$grandTotalKewajibanPajakTangguhan = (empty($grandTotalKewajibanPajakTangguhans)) ? 0 : round(array_sum($grandTotalKewajibanPajakTangguhans),2);

$totalKewajibanTidakLancar = $grandTotalKewajibanTidakLancar+$grandTotalKewajibanPajakTangguhan;

echo '<tr>
	<td align="left"><b>Total Kewajiban Tidak Lancar</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalKewajibanTidakLancar).'</b></td>
	
</tr>';

echo '<tr>
	<td align="left"><b>Ekuitas</b></td>
	<td align="right">&nbsp;</td>
	
</tr>';
// Ekuitas
$grandTotalEkuitass = array();
foreach ($listCOAEkuitas as $idEkuitas => $detailEkuitas) {
	if($filterCheckGlobal=='N') {
	 	// Keterangan pada Ekuitas
		if(isset($detailEkuitas['Level5']) && $detailEkuitas['Level4']) {
			list($codeEkuitas, $nameEkuitas) = explode('^', $detailEkuitas['Level4']);

			if(!empty($codeEkuitas)) {
			echo '<tr>
					<td colspan="3"><b>'.strtoupper($nameEkuitas).'</b></td>
				</tr>';
			}
		}
	}

	if(isset($detailEkuitas['Level5']) && $detailEkuitas['Level5']) {
		$debetCreditDetailEkuitass = array();
		foreach ($detailEkuitas['Level5'] as $dataCOAEkuitas) {
			list($codeDetailEkuitas, $nameDetailEkuitas, $debetCreditDetailEkuitas, $beginningBalanceDetailEkuitas, $subTotalDetailEkuitas) = explode('^', $dataCOAEkuitas);
			//$totalEkuitass = $debetCreditDetailEkuitas+$beginningBalanceDetailEkuitas;
			$debetCreditDetailEkuitass[] = $subTotalDetailEkuitas;
			$nominalDetailEkuitas = $this->Krs->cur($subTotalDetailEkuitas);

			//$dataPercentGlobalEkuitas = $grandTotalPercentEkuitas/$totalPercentAktiva*100;
			//$percenEkuitas = $subTotalDetailEkuitas/$grandTotalPercentEkuitas*$dataPercentGlobalEkuitas;
			//$nominalPercenEkuitas = $this->Krs->percent($percenEkuitas).'%';
			if($filterCheckGlobal=='N') {
			echo '<tr>
					<td>('.$codeDetailEkuitas.') '.$nameDetailEkuitas.'</td>
					<td align="right">'.$nominalDetailEkuitas.'</td>
					';
					//<td align="right">'.$nominalPercenEkuitas.'</td>
			echo '</tr>';
			}
		}
	}

	if(isset($detailEkuitas['Level5']) && $detailEkuitas['Level4']) {
		list($codeEkuitas, $nameEkuitas) = explode('^', $detailEkuitas['Level4']);

		if(!empty($codeEkuitas)) {
			$totalLevel4Ekuitas = array_sum($debetCreditDetailEkuitass);
			$nominalTotalLevel4Ekuitas = $this->Krs->cur($totalLevel4Ekuitas);
			$grandTotalEkuitass[] = $totalLevel4Ekuitas;
			//$percenEkuitasBank = $subTotalDetailEkuitasBank/$grandTotalPercentEkuitasBank*$dataPercentGlobalEkuitas;
			//$percenEkuitasBank = 0;
			
			//Percent
			// $dataPercentGlobalEkuitas = $totalLevel4Ekuitas/$totalPercentAktiva*100;
			// $nominalPercenEkuitas = $this->Krs->percent($dataPercentGlobalEkuitas).'%';

			//$percenTotalEkuitas = $totalLevel4Ekuitas/$totalPercentAktiva*100;
			//$nominalGrandPercentEkuitas = $this->Krs->percent($percenTotalEkuitas).'%';
			$titleTotalEkuitas = ($filterCheckGlobal=='N') ? 'TOTAL' : '('.$codeEkuitas.')';
		echo '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>'.$titleTotalEkuitas.' '.strtoupper($nameEkuitas).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4Ekuitas.'</b></td>
								
			</tr>';
			//<td align="right"><b>'.$nominalPercenEkuitas.'</b></td>		
		}
	}
}


// Laba/Rugi Ditahan
if(!empty($grandTotalLabaRugiDitahan)) {
	//Percent
	// $dataPercentGlobalLabaRugiDitahan = $grandTotalLabaRugiDitahan/$totalPercentPasiva*100;
	// $nominalPercenLabaRugiDitahan = $this->Krs->percent($dataPercentGlobalLabaRugiDitahan).'%';

	if($filterCheckGlobal=='N') {
		echo '<tr>
		<td colspan="2"><b>'.strtoupper('Laba/Rugi Ditahan').'</b></td>
		</tr>';
		echo '<tr>
			<td>Laba/Rugi Ditahan</td>
			<td align="right">'.$this->Krs->cur($grandTotalLabaRugiDitahan).'</td>
		</tr>';
		echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL LABA/RUGI DITAHAN</b></td><td align="right"><b>'.$this->Krs->cur($grandTotalLabaRugiDitahan).'</b></td></tr>';
		//<td align="right"><b>'.$nominalPercenLabaRugiDitahan.'</b></td>
	} else {
		echo '<tr>
		<td><b>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).strtoupper('Laba/Rugi Ditahan').'</b></td>
		<td align="right"><b>'.$this->Krs->cur($grandTotalLabaRugiDitahan).'</b></td>
		</tr>';
		//<td align="right"><b>'.$nominalPercenLabaRugiDitahan.'</b></td>
	}
}


// Laba/Rugi Berjalan
if(!empty($grandTotalLabaRugiBerjalan)) {
	//Percent
	// $dataPercentGlobalLabaRugiBerjalan = $grandTotalLabaRugiBerjalan/$totalPercentPasiva*100;
	// $nominalPercenLabaRugiBerjalan = $this->Krs->percent($dataPercentGlobalLabaRugiBerjalan).'%';

	if($filterCheckGlobal=='N') {
		echo '<tr>
		<td colspan="2"><b>'.strtoupper('Laba/Rugi Berjalan').'</b></td>
		</tr>';
		echo '<tr>
			<td>Laba/Rugi Berjalan</td>
			<td align="right">'.$this->Krs->cur($grandTotalLabaRugiBerjalan).'</td>
		</tr>';
		echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL LABA/RUGI BERJALAN</b></td><td align="right"><b>'.$this->Krs->cur($grandTotalLabaRugiBerjalan).'</b></td></tr>';
		//<td align="right"><b>'.$nominalPercenLabaRugiBerjalan.'</b></td>
	} else {
		echo '<tr>
			<td><b>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).strtoupper('Laba/Rugi Berjalan').'</b></td>
			<td align="right"><b>'.$this->Krs->cur($grandTotalLabaRugiBerjalan).'</b></td>
		</tr>';
		//<td align="right"><b>'.$nominalPercenLabaRugiBerjalan.'</b></td>
		
	}
}	

$grandTotalEkuitas = (empty($grandTotalEkuitass)) ? 0 : round(array_sum($grandTotalEkuitass),2);

$totalEkuitas = $grandTotalEkuitas+$grandTotalLabaRugiDitahan+$grandTotalLabaRugiBerjalan;

echo '<tr>
	<td align="left"><b>Total Ekuitas</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalEkuitas).'</b></td>
	
</tr>';


//TOTAL PASIVA
$totalPasiva = $totalKewajibanLancar+$totalKewajibanTidakLancar+$totalEkuitas;

echo '<tr>
	<td align="right">'.str_repeat('&nbsp;&nbsp;&nbsp;', 10).'<b>TOTAL KEWAJIBAN DAN EKUITAS</b></td>
	<td align="right"><b>'.$this->Krs->cur($totalPasiva).'</b></td>
	
</tr>';
//<td align="right"><b>100%</b></td>

?>

										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<table class="table">
					<?php
					//$totalPasiva = 0;
					$classTotal = (round($totalAktiva,2)==round($totalPasiva,2)) ? "table-success":"table-danger";
					//$classTotal = ($totalAktiva<>$totalPasiva) ? "danger":"success";
					//pr($totalAktiva.'=='.$totalPasiva);
					//pr($classTotal);
					?>
					<tr class="<?php echo $classTotal; ?>">
						<td align="left"><b>TOTAL AKTIVA</b></td>
						<td align="right"><b><?php echo $this->Krs->cur($totalAktiva); ?></b></td>
						<td align="left"><b>TOTAL PASIVA</b></td>
						<td align="right"><b><?php echo $this->Krs->cur($totalPasiva); ?></b></td>
					</tr>
				</table>
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
    var formAction = "<?php echo $this->Url->build(['controller'=>'AccJournals', 'action' => 'balance_sheet_percent_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalIncomeGlobalReportForm', 'btn-search', confirmTitle, formAction);

    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

	//handleDateRange('filterDateId', 'filterDateReset', 'filterDateClass', 'dd-mm-yyyy');
});
</script>