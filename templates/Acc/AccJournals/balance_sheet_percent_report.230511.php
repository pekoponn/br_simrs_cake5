<?= $this->Krs->breadcrumb('Accounting', 'Neraca (%)', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    
    <div class="panel-body bg-warning-transparent-4">
    	<?= $this->Form->create($triataAccJournal) ?>
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
									// is-invalid
									// echo $this->Form->input("filterDate", array("class" => "form-control filterDateClass is-invalid", 'id'=>'filterDateId', "autocomplete"=>"off", "error" => false, 'placeholder' => 'Tanggal...', "required"=>false, 'readonly' => true, 'value'=>$accJournalDate));
									//<input type="text" class="form-control" placeholder="Checkbox add on" />
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

								<?php
								/*
								<div class="input-group">
									<div class="input-group input-daterange">
									<?php
									
									// echo $this->Krs->fDate($date, 'd M Y')
									// pr($filterDate.', '.$filterCheckGlobal);

									

									echo $this->Form->input("filterDate", array("class" => "form-control filterDateClass is-invalid", 'id'=>'filterDateId', "autocomplete"=>"off", "error" => false, 'placeholder' => 'Tanggal...', "required"=>false, 'readonly' => true, 'value'=>$accJournalDate));
									?>
									
									<div class="input-group-append"><span class="input-group-text">
										<div class="form-check form-check-inline">
										<?php
										echo $this->Form->checkbox('checkGlobal', ['value' => 'Y', 'hiddenField' => 'N', $filterCheckGlobalDefault]);
										// echo $this->Form->hidden('checkGlobal', ['value' => 'N']);
										// echo $this->Form->input('checkGlobal', ['label' => false, 'hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'id'=>'checkbox-inline-2', $filterCheckGlobalDefault]);
										?><label class="form-check-label" for="checkbox-inline-2">Global</label>
										</div>
										
									</span></div>
									<div class="invalid-feedback">Centang bila hasil laporan Global.</div>
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
			<?php
			// -----------------------------------
			// -----------------------------------
			// 			Neraca Detail
			// -----------------------------------
			// -----------------------------------
			if($filterCheckGlobal=='N') {
			?>
			<div class="portlet-body">
				<div class="table-responsive">
					<div data-scrollbar="true" data-height="400px">
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6">
									<div class="table-responsive">
										<table width="100%" class="table-hover" cellpadding="3" cellspacing="0" border="0">
											<tr>
												<th align="left" colspan="3">AKTIVA</th>
											</tr>
											<tr>
												<th align="left" colspan="3">AKTIVA LANCAR</th>
											</tr>
			<?php
			//Aktiva
			//Total Percent
			$totalDetailKasBank = $this->Krs->totalCOADetail($listCOAKasBank);
			$totalDetailPiutang = $this->Krs->totalCOADetail($listCOAPiutang);
			$totalDetailAktivaTetap = $this->Krs->totalCOADetail($listCOAAktivaTetap);
			$totalDetailAktivaLancarLainnya = $this->Krs->totalCOADetail($listCOAAktivaLancarLainnya);
			$totalDetailAkumulasiPenyusutan = $this->Krs->totalCOADetail($listCOAAkumulasiPenyusutan);
			
			$grandTotalPercentKasBank = (empty($totalDetailKasBank)) ? 0 : round(array_sum($totalDetailKasBank),2);
			$grandTotalPercentPiutang = (empty($totalDetailPiutang)) ? 0 : round(array_sum($totalDetailPiutang),2);
			$grandTotalPercentAktivaTetap = (empty($totalDetailAktivaTetap)) ? 0 : round(array_sum($totalDetailAktivaTetap),2);
			$grandTotalPercentAktivaLancarLainnya = (empty($totalDetailAktivaLancarLainnya)) ? 0 : round(array_sum($totalDetailAktivaLancarLainnya),2);
			$grandTotalPercentAkumulasiPenyusutan = (empty($totalDetailAkumulasiPenyusutan)) ? 0 : round(array_sum($totalDetailAkumulasiPenyusutan),2);
			$totalPercentAktiva = $grandTotalPercentKasBank+$grandTotalPercentPiutang+$grandTotalPercentAktivaTetap+$grandTotalPercentAktivaLancarLainnya+$grandTotalPercentAkumulasiPenyusutan;
		
			// Kas Bank
			$grandTotalKasBanks = array();
			foreach ($listCOAKasBank as $idKasBank => $detailKasBank) {
			 	// Keterangan pada Kas serta Bank
				if(isset($detailKasBank['Level5']) && $detailKasBank['Level4']) {
					list($codeKasBank, $nameKasBank) = explode('^', $detailKasBank['Level4']);

					if(!empty($codeKasBank)) {
					echo '<tr>
							<td colspan="3"><b>'.strtoupper($nameKasBank).'</b></td>
						</tr>';
					}
				}

				if(isset($detailKasBank['Level5']) && $detailKasBank['Level5']) {
					$debetCreditDetailKasBanks = array();
					foreach ($detailKasBank['Level5'] as $dataCOAKasBank) {
						list($codeDetailKasBank, $nameDetailKasBank, $debetCreditDetailKasBank, $beginningBalanceDetailKasBank, $subTotalDetailKasBank) = explode('^', $dataCOAKasBank);
						//$totalKasBanks = $debetCreditDetailKasBank+$beginningBalanceDetailKasBank;
						$debetCreditDetailKasBanks[] = $subTotalDetailKasBank;
						$nominalDetailKasBank = $this->Krs->cur($subTotalDetailKasBank);

						$dataPercentGlobalKasBank = $grandTotalPercentKasBank/$totalPercentAktiva*100;
						$percenKasBank = $subTotalDetailKasBank/$grandTotalPercentKasBank*$dataPercentGlobalKasBank;
						//$percenKasBank = 0;
						$nominalPercenKasBank = $this->Krs->percent($percenKasBank).'%';

						echo '<tr>
								<td>('.$codeDetailKasBank.') '.$nameDetailKasBank.'</td>
								<td align="right">'.$nominalDetailKasBank.'</td>
								<td align="right">'.$nominalPercenKasBank.'</td>';
						echo '</tr>';
					}
				}

				if(isset($detailKasBank['Level5']) && $detailKasBank['Level4']) {
					list($codeKasBank, $nameKasBank) = explode('^', $detailKasBank['Level4']);

					if(!empty($codeKasBank)) {
						$totalLevel4KasBank = array_sum($debetCreditDetailKasBanks);
						$nominalTotalLevel4KasBank = $this->Krs->cur($totalLevel4KasBank);
						$grandTotalKasBanks[] = $totalLevel4KasBank;
						$percenTotalKasBank = $totalLevel4KasBank/$totalPercentAktiva*100;
						$nominalGrandPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';
					echo '<tr>
							<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameKasBank).'</b></td>
							<td align="right"><b>'.$nominalTotalLevel4KasBank.'</b></td>
							<td align="right"><b>'.$nominalGrandPercentKasBank.'</b></td>
						</tr>';
					}
				}
			}

			echo '<tr>
				<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL KAS & BANK</b></td>';
				
					$grandTotalKasBank = (empty($grandTotalKasBanks)) ? 0 : round(array_sum($grandTotalKasBanks),2);
					
					$percenTotalKasBank = $grandTotalKasBank/$totalPercentAktiva*100;

					$nominalGrandTotalPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';

					//$percenTotalKasBank = 0;
					//$percenTotalKasBank = $grandTotalKasBank/$totalPercentAktiva*100;

					$nominalGrandTotalPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';
					$totalGrandPercentKasBank = ($grandTotalKasBank>0) ? $nominalGrandTotalPercentKasBank:"0%";
						echo '<td align="right"><b>'.$this->Krs->cur($grandTotalKasBank).'</b></td><td align="right"><b>'.$totalGrandPercentKasBank.'</b></td>';
				//}
			echo '</tr>';


			// Piutang
			$grandTotalPiutangs = array();
			foreach ($listCOAPiutang as $idPiutang => $detailPiutang) {
			 	// Keterangan pada Kas serta Bank
				if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
					list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

					if(!empty($codePiutang)) {
					echo '<tr>
							<td colspan="3"><b>'.strtoupper($namePiutang).'</b></td>
						</tr>';
					}
				}

				if(isset($detailPiutang['Level5']) && $detailPiutang['Level5']) {
					$debetCreditDetailPiutangs = array();
					foreach ($detailPiutang['Level5'] as $dataCOAPiutang) {
						list($codeDetailPiutang, $nameDetailPiutang, $debetCreditDetailPiutang, $beginningBalanceDetailPiutang, $subTotalDetailPiutang) = explode('^', $dataCOAPiutang);
						//$totalPiutangs = $debetCreditDetailPiutang+$beginningBalanceDetailPiutang;
						$debetCreditDetailPiutangs[] = $subTotalDetailPiutang;
						$nominalDetailPiutang = $this->Krs->cur($subTotalDetailPiutang);

						$dataPercentGlobalPiutang = $grandTotalPercentPiutang/$totalPercentAktiva*100;
						$percenPiutang = $subTotalDetailPiutang/$grandTotalPercentPiutang*$dataPercentGlobalPiutang;
						//$percenPiutang = 0;
						$nominalPercenPiutang = $this->Krs->percent($percenPiutang).'%';

						echo '<tr>
								<td>('.$codeDetailPiutang.') '.$nameDetailPiutang.'</td>
								<td align="right">'.$nominalDetailPiutang.'</td>
								<td align="right">'.$nominalPercenPiutang.'</td>';
						echo '</tr>';
					}
				}

				if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
					list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

					if(!empty($codePiutang)) {
						$totalLevel4Piutang = array_sum($debetCreditDetailPiutangs);
						$nominalTotalLevel4Piutang = $this->Krs->cur($totalLevel4Piutang);
						$grandTotalPiutangs[] = $totalLevel4Piutang;
						$percenTotalPiutang = $totalLevel4Piutang/$totalPercentAktiva*100;
						$nominalGrandPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';
					echo '<tr>
							<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePiutang).'</b></td>
							<td align="right"><b>'.$nominalTotalLevel4Piutang.'</b></td>
							<td align="right"><b>'.$nominalGrandPercentPiutang.'</b></td>
						</tr>';
					}
				}
			}

			echo '<tr>
				<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL PIUTANG</b></td>';
				
					$grandTotalPiutang = (empty($grandTotalPiutangs)) ? 0 : round(array_sum($grandTotalPiutangs),2);
					
					$percenTotalPiutang = $grandTotalPiutang/$totalPercentAktiva*100;

					$nominalGrandTotalPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';

					//$percenTotalPiutang = 0;
					//$percenTotalPiutang = $grandTotalPiutang/$totalPercentAktiva*100;

					$nominalGrandTotalPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';
					$totalGrandPercentPiutang = ($grandTotalPiutang>0) ? $nominalGrandTotalPercentPiutang:"0%";
						echo '<td align="right"><b>'.$this->Krs->cur($grandTotalPiutang).'</b></td><td align="right"><b>'.$totalGrandPercentPiutang.'</b></td>';
				//}
			echo '</tr>';

			// Aktiva Tetap
			echo '<tr><th align="left" colspan="3">AKTIVA TETAP</th></tr>';

			// Aktiva Tetap
			$grandTotalAktivaTetaps = array();
			foreach ($listCOAAktivaTetap as $idAktivaTetap => $detailAktivaTetap) {
			 	// Keterangan pada Kas serta Bank
				if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level4']) {
					list($codeAktivaTetap, $nameAktivaTetap) = explode('^', $detailAktivaTetap['Level4']);

					if(!empty($codeAktivaTetap)) {
					echo '<tr>
							<td colspan="3"><b>'.strtoupper($nameAktivaTetap).'</b></td>
						</tr>';
					}
				}

				if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level5']) {
					$debetCreditDetailAktivaTetaps = array();
					foreach ($detailAktivaTetap['Level5'] as $dataCOAAktivaTetap) {
						list($codeDetailAktivaTetap, $nameDetailAktivaTetap, $debetCreditDetailAktivaTetap, $beginningBalanceDetailAktivaTetap, $subTotalDetailAktivaTetap) = explode('^', $dataCOAAktivaTetap);
						//$totalAktivaTetaps = $debetCreditDetailAktivaTetap+$beginningBalanceDetailAktivaTetap;
						$debetCreditDetailAktivaTetaps[] = $subTotalDetailAktivaTetap;
						$nominalDetailAktivaTetap = $this->Krs->cur($subTotalDetailAktivaTetap);

						$dataPercentGlobalAktivaTetap = $grandTotalPercentAktivaTetap/$totalPercentAktiva*100;
						$percenAktivaTetap = $subTotalDetailAktivaTetap/$grandTotalPercentAktivaTetap*$dataPercentGlobalAktivaTetap;
						//$percenAktivaTetap = 0;
						$nominalPercenAktivaTetap = $this->Krs->percent($percenAktivaTetap).'%';

						echo '<tr>
								<td>('.$codeDetailAktivaTetap.') '.$nameDetailAktivaTetap.'</td>
								<td align="right">'.$nominalDetailAktivaTetap.'</td>
								<td align="right">'.$nominalPercenAktivaTetap.'</td>';
						echo '</tr>';
					}
				}

				if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level4']) {
					list($codeAktivaTetap, $nameAktivaTetap) = explode('^', $detailAktivaTetap['Level4']);

					if(!empty($codeAktivaTetap)) {
						$totalLevel4AktivaTetap = array_sum($debetCreditDetailAktivaTetaps);
						$nominalTotalLevel4AktivaTetap = $this->Krs->cur($totalLevel4AktivaTetap);
						$grandTotalAktivaTetaps[] = $totalLevel4AktivaTetap;
						$percenTotalAktivaTetap = $totalLevel4AktivaTetap/$totalPercentAktiva*100;
						$nominalGrandPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';
					echo '<tr>
							<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameAktivaTetap).'</b></td>
							<td align="right"><b>'.$nominalTotalLevel4AktivaTetap.'</b></td>
							<td align="right"><b>'.$nominalGrandPercentAktivaTetap.'</b></td>
						</tr>';
					}
				}
			}

			echo '<tr>
				<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL AKTIVA TETAP</b></td>';
				
					$grandTotalAktivaTetap = (empty($grandTotalAktivaTetaps)) ? 0 : round(array_sum($grandTotalAktivaTetaps),2);
					
					$percenTotalAktivaTetap = $grandTotalAktivaTetap/$totalPercentAktiva*100;

					$nominalGrandTotalPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';

					//$percenTotalAktivaTetap = 0;
					//$percenTotalAktivaTetap = $grandTotalAktivaTetap/$totalPercentAktiva*100;

					$nominalGrandTotalPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';
					$totalGrandPercentAktivaTetap = ($grandTotalAktivaTetap>0) ? $nominalGrandTotalPercentAktivaTetap:"0%";
						echo '<td align="right"><b>'.$this->Krs->cur($grandTotalAktivaTetap).'</b></td><td align="right"><b>'.$totalGrandPercentAktivaTetap.'</b></td>';
				//}
			echo '</tr>';

			// Aktiva Lancar Lainnya
			$grandTotalAktivaLancarLainnyas = array();
			foreach ($listCOAAktivaLancarLainnya as $idAktivaLancarLainnya => $detailAktivaLancarLainnya) {
			 	// Keterangan pada Kas serta Bank
				if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level4']) {
					list($codeAktivaLancarLainnya, $nameAktivaLancarLainnya) = explode('^', $detailAktivaLancarLainnya['Level4']);

					if(!empty($codeAktivaLancarLainnya)) {
					echo '<tr>
							<td colspan="3"><b>'.strtoupper($nameAktivaLancarLainnya).'</b></td>
						</tr>';
					}
				}

				if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level5']) {
					$debetCreditDetailAktivaLancarLainnyas = array();
					foreach ($detailAktivaLancarLainnya['Level5'] as $dataCOAAktivaLancarLainnya) {
						list($codeDetailAktivaLancarLainnya, $nameDetailAktivaLancarLainnya, $debetCreditDetailAktivaLancarLainnya, $beginningBalanceDetailAktivaLancarLainnya, $subTotalDetailAktivaLancarLainnya) = explode('^', $dataCOAAktivaLancarLainnya);
						//$totalAktivaLancarLainnyas = $debetCreditDetailAktivaLancarLainnya+$beginningBalanceDetailAktivaLancarLainnya;
						$debetCreditDetailAktivaLancarLainnyas[] = $subTotalDetailAktivaLancarLainnya;
						$nominalDetailAktivaLancarLainnya = $this->Krs->cur($subTotalDetailAktivaLancarLainnya);

						$dataPercentGlobalAktivaLancarLainnya = $grandTotalPercentAktivaLancarLainnya/$totalPercentAktiva*100;
						$percenAktivaLancarLainnya = $subTotalDetailAktivaLancarLainnya/$grandTotalPercentAktivaLancarLainnya*$dataPercentGlobalAktivaLancarLainnya;
						//$percenAktivaLancarLainnya = 0;
						$nominalPercenAktivaLancarLainnya = $this->Krs->percent($percenAktivaLancarLainnya).'%';

						echo '<tr>
								<td>('.$codeDetailAktivaLancarLainnya.') '.$nameDetailAktivaLancarLainnya.'</td>
								<td align="right">'.$nominalDetailAktivaLancarLainnya.'</td>
								<td align="right">'.$nominalPercenAktivaLancarLainnya.'</td>';
						echo '</tr>';
					}
				}

				if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level4']) {
					list($codeAktivaLancarLainnya, $nameAktivaLancarLainnya) = explode('^', $detailAktivaLancarLainnya['Level4']);

					if(!empty($codeAktivaLancarLainnya)) {
						$totalLevel4AktivaLancarLainnya = array_sum($debetCreditDetailAktivaLancarLainnyas);
						$nominalTotalLevel4AktivaLancarLainnya = $this->Krs->cur($totalLevel4AktivaLancarLainnya);
						$grandTotalAktivaLancarLainnyas[] = $totalLevel4AktivaLancarLainnya;
						$percenTotalAktivaLancarLainnya = $totalLevel4AktivaLancarLainnya/$totalPercentAktiva*100;
						$nominalGrandPercentAktivaLancarLainnya = $this->Krs->percent($percenTotalAktivaLancarLainnya).'%';
					echo '<tr>
							<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameAktivaLancarLainnya).'</b></td>
							<td align="right"><b>'.$nominalTotalLevel4AktivaLancarLainnya.'</b></td>
							<td align="right"><b>'.$nominalGrandPercentAktivaLancarLainnya.'</b></td>
						</tr>';
					}
				}
			}

			// Akumulasi Penyusutan
			$grandTotalAkumulasiPenyusutans = array();
			foreach ($listCOAAkumulasiPenyusutan as $idAkumulasiPenyusutan => $detailAkumulasiPenyusutan) {
			 	// Keterangan pada Kas serta Bank
				if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level4']) {
					list($codeAkumulasiPenyusutan, $nameAkumulasiPenyusutan) = explode('^', $detailAkumulasiPenyusutan['Level4']);

					if(!empty($codeAkumulasiPenyusutan)) {
					echo '<tr>
							<td colspan="3"><b>'.strtoupper($nameAkumulasiPenyusutan).'</b></td>
						</tr>';
					}
				}

				if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level5']) {
					$debetCreditDetailAkumulasiPenyusutans = array();
					foreach ($detailAkumulasiPenyusutan['Level5'] as $dataCOAAkumulasiPenyusutan) {
						list($codeDetailAkumulasiPenyusutan, $nameDetailAkumulasiPenyusutan, $debetCreditDetailAkumulasiPenyusutan, $beginningBalanceDetailAkumulasiPenyusutan, $subTotalDetailAkumulasiPenyusutan) = explode('^', $dataCOAAkumulasiPenyusutan);
						//$totalAkumulasiPenyusutans = $debetCreditDetailAkumulasiPenyusutan+$beginningBalanceDetailAkumulasiPenyusutan;
						$debetCreditDetailAkumulasiPenyusutans[] = $subTotalDetailAkumulasiPenyusutan;
						$nominalDetailAkumulasiPenyusutan = $this->Krs->cur($subTotalDetailAkumulasiPenyusutan);

						$dataPercentGlobalAkumulasiPenyusutan = $grandTotalPercentAkumulasiPenyusutan/$totalPercentAktiva*100;
						$percenAkumulasiPenyusutan = $subTotalDetailAkumulasiPenyusutan/$grandTotalPercentAkumulasiPenyusutan*$dataPercentGlobalAkumulasiPenyusutan;
						//$percenAkumulasiPenyusutan = 0;
						$nominalPercenAkumulasiPenyusutan = $this->Krs->percent($percenAkumulasiPenyusutan).'%';

						echo '<tr>
								<td>('.$codeDetailAkumulasiPenyusutan.') '.$nameDetailAkumulasiPenyusutan.'</td>
								<td align="right">'.$nominalDetailAkumulasiPenyusutan.'</td>
								<td align="right">'.$nominalPercenAkumulasiPenyusutan.'</td>';
						echo '</tr>';
					}
				}

				if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level4']) {
					list($codeAkumulasiPenyusutan, $nameAkumulasiPenyusutan) = explode('^', $detailAkumulasiPenyusutan['Level4']);

					if(!empty($codeAkumulasiPenyusutan)) {
						$totalLevel4AkumulasiPenyusutan = array_sum($debetCreditDetailAkumulasiPenyusutans);
						$nominalTotalLevel4AkumulasiPenyusutan = $this->Krs->cur($totalLevel4AkumulasiPenyusutan);
						$grandTotalAkumulasiPenyusutans[] = $totalLevel4AkumulasiPenyusutan;
						$percenTotalAkumulasiPenyusutan = $totalLevel4AkumulasiPenyusutan/$totalPercentAktiva*100;
						$nominalGrandPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';
					echo '<tr>
							<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameAkumulasiPenyusutan).'</b></td>
							<td align="right"><b>'.$nominalTotalLevel4AkumulasiPenyusutan.'</b></td>
							<td align="right"><b>'.$nominalGrandPercentAkumulasiPenyusutan.'</b></td>
						</tr>';
					}
				}
			}

			echo '<tr>
				<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL AKUMULASI PENYUSUTAN</b></td>';
				
					$grandTotalAkumulasiPenyusutan = (empty($grandTotalAkumulasiPenyusutans)) ? 0 : round(array_sum($grandTotalAkumulasiPenyusutans),2);
					
					$percenTotalAkumulasiPenyusutan = $grandTotalAkumulasiPenyusutan/$totalPercentAktiva*100;

					$nominalGrandTotalPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';

					//$percenTotalAkumulasiPenyusutan = 0;
					//$percenTotalAkumulasiPenyusutan = $grandTotalAkumulasiPenyusutan/$totalPercentAktiva*100;

					$nominalGrandTotalPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';
					$totalGrandPercentAkumulasiPenyusutan = ($grandTotalAkumulasiPenyusutan>0) ? $nominalGrandTotalPercentAkumulasiPenyusutan:"0%";
						echo '<td align="right"><b>'.$this->Krs->cur($grandTotalAkumulasiPenyusutan).'</b></td><td align="right"><b>'.$totalGrandPercentAkumulasiPenyusutan.'</b></td>';
				//}
			echo '</tr>';

			//TOTAL AKTIVA
			$grandTotalAktivaKasBank = (empty($grandTotalKasBanks)) ? 0 : round(array_sum($grandTotalKasBanks),2);
			$grandTotalAktivaPiutang = (empty($grandTotalPiutangs)) ? 0 : round(array_sum($grandTotalPiutangs),2);
			$grandTotalAktivaAktivaTetap = (empty($grandTotalAktivaTetaps)) ? 0 : round(array_sum($grandTotalAktivaTetaps),2);
			$grandTotalAktivaAktivaLancarLainnya = (empty($grandTotalAktivaLancarLainnyas)) ? 0 : round(array_sum($grandTotalAktivaLancarLainnyas),2);
			$grandTotalAktivaAkumulasiPenyusutan = (empty($grandTotalAkumulasiPenyusutans)) ? 0 : round(array_sum($grandTotalAkumulasiPenyusutans),2);
			
			$totalAktiva = $grandTotalAktivaKasBank+$grandTotalAktivaPiutang+$grandTotalAktivaAktivaTetap+$grandTotalAktivaAktivaLancarLainnya+$grandTotalAktivaAkumulasiPenyusutan;
			
			//$totalAktiva = "";
			echo '<tr>
					<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 10).'<b>TOTAL AKTIVA</b></td>
					<td align="right"><b>'.$this->Krs->cur($totalAktiva).'</b></td>
					<td align="right">&nbsp;</td>
				</tr>';

		
		
			?>

										</table>
									</div>
								</div>
								<div class="col-md-6">
									<div class="table-responsive">
										<table width="100%" class="table-hover" cellpadding="3" cellspacing="0">
											<tr>
												<th align="left">PASIVA</th>
												<th align="right">&nbsp;</th>
											</tr>
											<tr><th align="left" colspan="3">KEWAJIBAN</th></tr>
											<?php
									//Aktiva
									//Total Percent
									$totalDetailHutang = $this->Krs->totalCOADetail($listCOAHutang);
									$totalDetailHutangLancar = $this->Krs->totalCOADetail($listCOAHutangLancar);
									$totalDetailModal = $this->Krs->totalCOADetail($listCOAModal);
									$totalDetailSaldoDitahans = $this->Krs->totalCOADetail($listCOASaldoDitahan);
									//$totalDetailSaldoDitahan = (empty($totalDetailSaldoDitahans)) ? $totalGrandBeforeLabaRugiBerjalan:$totalDetailSaldoDitahans;

									//pr($totalDetailSaldoDitahan);

									$totalDetailPrive = $this->Krs->totalCOADetailBefore($listCOAPrive);
									//$totalDetailBeforeSaldoDitahan = $this->Krs->totalCOADetailBefore($listCOABeforeSaldoDitahan);
									$totalDetailBeforePrive = $this->Krs->totalCOADetailBefore($listCOABeforePrive);

									$grandTotalPercentHutang = (empty($totalDetailHutang)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutang),2));
									$grandTotalPercentHutangLancar = (empty($totalDetailHutangLancar)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutangLancar),2));
									$grandTotalPercentModal = (empty($totalDetailModal)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailModal),2));
									$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));
									$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : round(array_sum($totalDetailPrive),2);
									//$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailPrive),2));

									//$grandTotalPercentBeforeSaldoDitahan = (empty($totalDetailBeforeSaldoDitahan)) ? 0 : round(array_sum($totalDetailBeforeSaldoDitahan),2);
									$grandTotalPercentBeforePrive = (empty($totalDetailBeforePrive)) ? 0 : round(array_sum($totalDetailBeforePrive),2);


									$grandTotalDetailBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;
									// $grandTotalDetailBeforeSaldoDitahan = $grandTotalPercentBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;

									$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$totalGrandLabaRugiBerjalan+$grandTotalPercentPrive+$grandTotalDetailBeforeSaldoDitahan;

									//pr($grandTotalDetailBeforeSaldoDitahan);


									// Hutang
									$grandTotalHutangs = array();
									foreach ($listCOAHutang as $idHutang => $detailHutang) {
									 	// Keterangan pada Kas serta Bank
										if(isset($detailHutang['Level5']) && $detailHutang['Level4']) {
											list($codeHutang, $nameHutang) = explode('^', $detailHutang['Level4']);

											if(!empty($codeHutang)) {
											echo '<tr>
													<td colspan="3"><b>'.strtoupper($nameHutang).'</b></td>
												</tr>';
											}
										}

										if(isset($detailHutang['Level5']) && $detailHutang['Level5']) {
											$debetCreditDetailHutangs = array();
											foreach ($detailHutang['Level5'] as $dataCOAHutang) {
												list($codeDetailHutang, $nameDetailHutang, $debetCreditDetailHutang, $beginningBalanceDetailHutang, $subTotalDetailHutang) = explode('^', $dataCOAHutang);
												//$totalHutangs = $debetCreditDetailHutang+$beginningBalanceDetailHutang;
												$debetCreditDetailHutangs[] = $subTotalDetailHutang;
												$nominalDetailHutang = $this->Krs->cur($subTotalDetailHutang);

												$dataPercentGlobalHutang = $grandTotalPercentHutang/$totalPercentPasiva*100;
												$percenHutang = $subTotalDetailHutang/$grandTotalPercentHutang*$dataPercentGlobalHutang;
												//$percenHutang = 0;
												$nominalPercenHutang = $this->Krs->percent($percenHutang).'%';

												echo '<tr>
														<td>('.$codeDetailHutang.') '.$nameDetailHutang.'</td>
														<td align="right">'.$nominalDetailHutang.'</td>
														<td align="right">'.$nominalPercenHutang.'</td>';
												echo '</tr>';
											}
										}

										if(isset($detailHutang['Level5']) && $detailHutang['Level4']) {
											list($codeHutang, $nameHutang) = explode('^', $detailHutang['Level4']);

											if(!empty($codeHutang)) {
												$totalLevel4Hutang = array_sum($debetCreditDetailHutangs);
												$nominalTotalLevel4Hutang = $this->Krs->cur($totalLevel4Hutang);
												$grandTotalHutangs[] = $totalLevel4Hutang;
												$percenTotalHutang = $totalLevel4Hutang/$totalPercentPasiva*100;
												$nominalGrandPercentHutang = $this->Krs->percent($percenTotalHutang).'%';
											echo '<tr>
													<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameHutang).'</b></td>
													<td align="right"><b>'.$nominalTotalLevel4Hutang.'</b></td>
													<td align="right"><b>'.$nominalGrandPercentHutang.'</b></td>
												</tr>';
											}
										}
									}

									// Hutang Lancar
									$grandTotalHutangLancars = array();
									foreach ($listCOAHutangLancar as $idHutangLancar => $detailHutangLancar) {
									 	// Keterangan pada Kas serta Bank
										if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level4']) {
											list($codeHutangLancar, $nameHutangLancar) = explode('^', $detailHutangLancar['Level4']);

											if(!empty($codeHutangLancar)) {
											echo '<tr>
													<td colspan="3"><b>'.strtoupper($nameHutangLancar).'</b></td>
												</tr>';
											}
										}

										if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level5']) {
											$debetCreditDetailHutangLancars = array();
											foreach ($detailHutangLancar['Level5'] as $dataCOAHutangLancar) {
												list($codeDetailHutangLancar, $nameDetailHutangLancar, $debetCreditDetailHutangLancar, $beginningBalanceDetailHutangLancar, $subTotalDetailHutangLancar) = explode('^', $dataCOAHutangLancar);
												//$totalHutangLancars = $debetCreditDetailHutangLancar+$beginningBalanceDetailHutangLancar;
												$debetCreditDetailHutangLancars[] = $subTotalDetailHutangLancar;
												$nominalDetailHutangLancar = $this->Krs->cur($subTotalDetailHutangLancar);

												$dataPercentGlobalHutangLancar = $grandTotalPercentHutangLancar/$totalPercentPasiva*100;
												$percenHutangLancar = $subTotalDetailHutangLancar/$grandTotalPercentHutangLancar*$dataPercentGlobalHutangLancar;
												//$percenHutangLancar = 0;
												$nominalPercenHutangLancar = $this->Krs->percent($percenHutangLancar).'%';

												echo '<tr>
														<td>('.$codeDetailHutangLancar.') '.$nameDetailHutangLancar.'</td>
														<td align="right">'.$nominalDetailHutangLancar.'</td>
														<td align="right">'.$nominalPercenHutangLancar.'</td>';
												echo '</tr>';
											}
										}

										if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level4']) {
											list($codeHutangLancar, $nameHutangLancar) = explode('^', $detailHutangLancar['Level4']);

											if(!empty($codeHutangLancar)) {
												$totalLevel4HutangLancar = array_sum($debetCreditDetailHutangLancars);
												$nominalTotalLevel4HutangLancar = $this->Krs->cur($totalLevel4HutangLancar);
												$grandTotalHutangLancars[] = $totalLevel4HutangLancar;
												$percenTotalHutangLancar = $totalLevel4HutangLancar/$totalPercentPasiva*100;
												$nominalGrandPercentHutangLancar = $this->Krs->percent($percenTotalHutangLancar).'%';
											echo '<tr>
													<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameHutangLancar).'</b></td>
													<td align="right"><b>'.$nominalTotalLevel4HutangLancar.'</b></td>
													<td align="right"><b>'.$nominalGrandPercentHutangLancar.'</b></td>
												</tr>';
											}
										}
									}

									echo '<tr>
										<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL HUTANG LANCAR</b></td>';
											$grandTotalHutang = (empty($grandTotalHutangs)) ? 0 : round(array_sum($grandTotalHutangs),2);
											$grandTotalHutangLancar = (empty($grandTotalHutangLancars)) ? 0 : round(array_sum($grandTotalHutangLancars),2);
											
											//pr($grandTotalHutang.'<br>'.$grandTotalHutangLancar);
											$percenGrandTotalHutangLancar = $grandTotalHutang+$grandTotalHutangLancar;
											$percenTotalHutangLancar = $percenGrandTotalHutangLancar/$totalPercentPasiva*100;

											$nominalGrandTotalPercentHutangLancar = $this->Krs->percent($percenTotalHutangLancar).'%';

											$totalGrandPercentHutangLancar = ($percenGrandTotalHutangLancar>0) ? $nominalGrandTotalPercentHutangLancar:"0%";
												echo '<td align="right"><b>'.$this->Krs->cur($percenGrandTotalHutangLancar).'</b></td><td align="right"><b>'.$totalGrandPercentHutangLancar.'</b></td>';
										//}
									echo '</tr>';

									echo '<tr><th align="left" colspan="3">&nbsp;</th><th align="left" colspan="3">EKUITAS</th></tr>';
									// Modal
									$grandTotalModals = array();
									foreach ($listCOAModal as $idModal => $detailModal) {
									 	// Keterangan pada Kas serta Bank
										if(isset($detailModal['Level5']) && $detailModal['Level4']) {
											list($codeModal, $nameModal) = explode('^', $detailModal['Level4']);

											if(!empty($codeModal)) {
											echo '<tr>
													<td colspan="3"><b>'.strtoupper($nameModal).'</b></td>
												</tr>';
											}
										}

										if(isset($detailModal['Level5']) && $detailModal['Level5']) {
											$debetCreditDetailModals = array();
											foreach ($detailModal['Level5'] as $dataCOAModal) {
												list($codeDetailModal, $nameDetailModal, $debetCreditDetailModal, $beginningBalanceDetailModal, $subTotalDetailModal) = explode('^', $dataCOAModal);
												//$totalModals = $debetCreditDetailModal+$beginningBalanceDetailModal;
												$debetCreditDetailModals[] = $subTotalDetailModal;
												$nominalDetailModal = $this->Krs->cur($subTotalDetailModal);

												$dataPercentGlobalModal = $grandTotalPercentModal/$totalPercentPasiva*100;
												$percenModal = $subTotalDetailModal/$grandTotalPercentModal*$dataPercentGlobalModal;
												//$percenModal = 0;
												$nominalPercenModal = $this->Krs->percent($percenModal).'%';

												echo '<tr>
														<td>('.$codeDetailModal.') '.$nameDetailModal.'</td>
														<td align="right">'.$nominalDetailModal.'</td>
														<td align="right">'.$nominalPercenModal.'</td>';
												echo '</tr>';
											}
										}

										if(isset($detailModal['Level5']) && $detailModal['Level4']) {
											list($codeModal, $nameModal) = explode('^', $detailModal['Level4']);

											if(!empty($codeModal)) {
												$totalLevel4Modal = array_sum($debetCreditDetailModals);
												$nominalTotalLevel4Modal = $this->Krs->cur($totalLevel4Modal);
												$grandTotalModals[] = $totalLevel4Modal;
												$percenTotalModal = $totalLevel4Modal/$totalPercentPasiva*100;
												$nominalGrandPercentModal = $this->Krs->percent($percenTotalModal).'%';
											echo '<tr>
													<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameModal).'</b></td>
													<td align="right"><b>'.$nominalTotalLevel4Modal.'</b></td>
													<td align="right"><b>'.$nominalGrandPercentModal.'</b></td>
												</tr>';
											}
										}
									}

									// Saldo Laba Ditahan
									$grandTotalBeforePrives = array();
									foreach ($listCOABeforePrive as $idBeforePrive => $detailBeforePrive) {
									 	if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level5']) {
											$debetCreditDetailBeforePrives = array();
											foreach ($detailBeforePrive['Level5'] as $dataCOABeforePrive) {
												list($codeDetailBeforePrive, $nameDetailBeforePrive, $debetCreditDetailBeforePrive, $beginningBalanceDetailBeforePrive, $subTotalDetailBeforePrive) = explode('^', $dataCOABeforePrive);
												$debetCreditDetailBeforePrives[] = $subTotalDetailBeforePrive;
											}
										}

										if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level4']) {
											list($codeBeforePrive, $nameBeforePrive) = explode('^', $detailBeforePrive['Level4']);

											if(!empty($codeBeforePrive)) {
												$totalLevel4BeforePrive = array_sum($debetCreditDetailBeforePrives);
												$grandTotalBeforePrives[] = $totalLevel4BeforePrive;			
											}
										}
									}
									$grandTotalBeforePrive = (empty($grandTotalBeforePrives)) ? 0 : round(array_sum($grandTotalBeforePrives),2);

									$grandTotalSaldoDitahans = array();
									foreach ($listCOASaldoDitahan as $idSaldoDitahan => $detailSaldoDitahan) {
									 	// Keterangan pada Kas serta Bank
										if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level4']) {
											list($codeSaldoDitahan, $nameSaldoDitahan) = explode('^', $detailSaldoDitahan['Level4']);

											if(!empty($codeSaldoDitahan)) {
											echo '<tr>
													<td colspan="3"><b>'.strtoupper($nameSaldoDitahan).'</b></td>
												</tr>';
											}
										}

										if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level5']) {
											$debetCreditDetailSaldoDitahans = array();
											foreach ($detailSaldoDitahan['Level5'] as $dataCOASaldoDitahan) {
												list($codeDetailSaldoDitahan, $nameDetailSaldoDitahan, $debetCreditDetailSaldoDitahan, $beginningBalanceDetailSaldoDitahan, $subTotalDetailSaldoDitahan) = explode('^', $dataCOASaldoDitahan);

												//list($codeDetailBeforeSaldoDitahan, $nameDetailBeforeSaldoDitahan, $debetCreditDetailBeforeSaldoDitahan, $beginningBalanceDetailBeforeSaldoDitahan, $subTotalDetailBeforeSaldoDitahan) = explode('^', $listCOABeforeSaldoDitahan[$idSaldoDitahan]['Level5'][0]);

												//$totalSaldoDitahans = $debetCreditDetailSaldoDitahan+$beginningBalanceDetailSaldoDitahan;
												$subTotalBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
												//$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
												


												$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
												//$debetCreditDetailSaldoDitahans[] = $subTotalDetailSaldoDitahan;
												$totalBeforeSaldoDitahan = $subTotalBeforeSaldoDitahan;
												$nominalDetailSaldoDitahan = $this->Krs->cur($subTotalBeforeSaldoDitahan);
												//$nominalDetailSaldoDitahan = $this->Krs->cur($subTotalDetailSaldoDitahan);

												$dataPercentGlobalSaldoDitahan = $grandTotalPercentSaldoDitahan/$totalPercentPasiva*100;
												$percenSaldoDitahan = ($dataPercentGlobalSaldoDitahan!=0) ? $subTotalBeforeSaldoDitahan/$grandTotalPercentSaldoDitahan*$dataPercentGlobalSaldoDitahan:0;
												//pr($percenSaldoDitahan);
												//pr($subTotalBeforeSaldoDitahan.'/'.$grandTotalPercentSaldoDitahan.'*'.$dataPercentGlobalSaldoDitahan);
												//$percenSaldoDitahan = $subTotalDetailSaldoDitahan/$grandTotalPercentSaldoDitahan*$dataPercentGlobalSaldoDitahan;
												//$percenSaldoDitahan = 0;
												$nominalPercenSaldoDitahan = $this->Krs->percent($percenSaldoDitahan).'%';
												//.' = '.$subTotalDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive
												
												echo '<tr>
														<td>('.$codeDetailSaldoDitahan.') '.$nameDetailSaldoDitahan.'</td>
														<td align="right">'.$nominalDetailSaldoDitahan.'</td>
														<td align="right">'.$nominalPercenSaldoDitahan.'</td>';
												echo '</tr>';
												//.' = '.$subTotalDetailBeforeSaldoDitahan.' = '.$totalGrandBeforeLabaRugiBerjalan.' -> '.$grandTotalBeforePrive
											}
										}

										if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level4']) {
											list($codeSaldoDitahan, $nameSaldoDitahan) = explode('^', $detailSaldoDitahan['Level4']);

											if(!empty($codeSaldoDitahan)) {
												$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
												$nominalTotalLevel4SaldoDitahan = $this->Krs->cur($totalLevel4SaldoDitahan);
												$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
												$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
												$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';
											echo '<tr>
													<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameSaldoDitahan).'</b></td>
													<td align="right"><b>'.$nominalTotalLevel4SaldoDitahan.'</b></td>
													<td align="right"><b>'.$nominalGrandPercentSaldoDitahan.'</b></td>
												</tr>';
											}
										} else {
											//pr($grandTotalBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive);
											$subTotalBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
											$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;

											$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
											$nominalTotalLevel4SaldoDitahan = $this->Krs->cur($totalLevel4SaldoDitahan);
											$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
											$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
											$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';
											
											if($totalLevel4SaldoDitahan>0) {
											$titleSaldoDitahan = "Saldo Laba Ditahan";		
											echo '<tr>
												<td colspan="3"><b>'.strtoupper($titleSaldoDitahan).'</b></td>
											</tr>';
											echo '<tr>
													<td>'.$titleSaldoDitahan.'</td>
													<td align="right">'.$nominalTotalLevel4SaldoDitahan.'</td>
													<td align="right">'.$nominalGrandPercentSaldoDitahan.'</td>
												</tr>';
											echo '<tr>
												<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($titleSaldoDitahan).'</b></td>
												<td align="right"><b>'.$nominalTotalLevel4SaldoDitahan.'</b></td>
												<td align="right"><b>'.$nominalGrandPercentSaldoDitahan.'</b></td>
											</tr>';
											echo '<tr>
												<td>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($titleSaldoDitahan).'</b></td>
												<td align="right"><b>'.$nominalTotalLevel4SaldoDitahan.'</b></td>
												<td align="right"><b>'.$nominalGrandPercentSaldoDitahan.'</b></td>
											</tr>';
											}
										}
									}

									// Laba/Rugi Berjalan
									$percenTotalLabaRugiBerjalan = $totalGrandLabaRugiBerjalan/$totalPercentPasiva*100;
									$nominalGrandPercentLabaRugiBerjalan = $this->Krs->percent($percenTotalLabaRugiBerjalan).'%';
									echo '<tr>
											<td colspan="2"><b>'.strtoupper('Laba/Rugi Berjalan').'</b></td>
										</tr>
										<tr>
											<td>Laba/Rugi Berjalan</td>
											<td align="right">'.$this->Krs->cur($totalGrandLabaRugiBerjalan).'</td><td align="right">'.$nominalGrandPercentLabaRugiBerjalan.'</td>
										</tr>
										<tr>
											<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL LABA/RUGI BERJALAN</b></td>';
										
											echo '<td align="right"><b>'.$this->Krs->cur($totalGrandLabaRugiBerjalan).'</b></td><td align="right"><b>'.$nominalGrandPercentLabaRugiBerjalan.'</b></td>';
										//}
									echo '</tr>';

									// Prive
									$grandTotalPrives = array();
									foreach ($listCOAPrive as $idPrive => $detailPrive) {
									 	// Keterangan pada Kas serta Bank
										if(isset($detailPrive['Level5']) && $detailPrive['Level4']) {
											list($codePrive, $namePrive) = explode('^', $detailPrive['Level4']);

											if(!empty($codePrive)) {
											echo '<tr>
													<td colspan="3"><b>'.strtoupper($namePrive).'</b></td>
												</tr>';
											}
										}

										if(isset($detailPrive['Level5']) && $detailPrive['Level5']) {
											$debetCreditDetailPrives = array();
											foreach ($detailPrive['Level5'] as $dataCOAPrive) {
												list($codeDetailPrive, $nameDetailPrive, $debetCreditDetailPrive, $beginningBalanceDetailPrive, $subTotalDetailPrive) = explode('^', $dataCOAPrive);
												//$totalPrives = $debetCreditDetailPrive+$beginningBalanceDetailPrive;
												$debetCreditDetailPrives[] = $subTotalDetailPrive;
												$nominalDetailPrive = $this->Krs->cur($subTotalDetailPrive);

												$dataPercentGlobalPrive = $grandTotalPercentPrive/$totalPercentPasiva*100;
												$percenPrive = $subTotalDetailPrive/$grandTotalPercentPrive*$dataPercentGlobalPrive;
												//$percenPrive = 0;
												$nominalPercenPrive = $this->Krs->percent($percenPrive).'%';

												echo '<tr>
														<td>('.$codeDetailPrive.') '.$nameDetailPrive.'</td>
														<td align="right">'.$nominalDetailPrive.'</td>
														<td align="right">'.$nominalPercenPrive.'</td>';
												echo '</tr>';
											}
										}

										if(isset($detailPrive['Level5']) && $detailPrive['Level4']) {
											list($codePrive, $namePrive) = explode('^', $detailPrive['Level4']);

											if(!empty($codePrive)) {
												$totalLevel4Prive = array_sum($debetCreditDetailPrives);
												$nominalTotalLevel4Prive = $this->Krs->cur($totalLevel4Prive);
												$grandTotalPrives[] = $totalLevel4Prive;
												$percenTotalPrive = $totalLevel4Prive/$totalPercentPasiva*100;
												$nominalGrandPercentPrive = $this->Krs->percent($percenTotalPrive).'%';
											echo '<tr>
													<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePrive).'</b></td>
													<td align="right"><b>'.$nominalTotalLevel4Prive.'</b></td>
													<td align="right"><b>'.$nominalGrandPercentPrive.'</b></td>
												</tr>';
											}
										}
									}

									//TOTAL PASIVA
									$grandTotalPasivaHutang = (empty($grandTotalHutangs)) ? 0 : round(array_sum($grandTotalHutangs),2);
									$grandTotalPasivaHutangLancar = (empty($grandTotalHutangLancars)) ? 0 : round(array_sum($grandTotalHutangLancars),2);
									$grandTotalPasivaModal = (empty($grandTotalModals)) ? 0 : round(array_sum($grandTotalModals),2);
									$grandTotalPasivaSaldoDitahan = (empty($grandTotalSaldoDitahans)) ? 0 : round(array_sum($grandTotalSaldoDitahans),2);
									$grandTotalPasivaPrive = (empty($grandTotalPrives)) ? 0 : round(array_sum($grandTotalPrives),2);


									$totalPasiva = $grandTotalPasivaHutang+$grandTotalPasivaHutangLancar+$grandTotalPasivaModal+$grandTotalPasivaSaldoDitahan+$grandTotalPasivaPrive+$totalGrandLabaRugiBerjalan;
									echo '<tr>
											<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 10).'<b>TOTAL PASIVA</b></td>
											<td align="right"><b>'.$this->Krs->cur($totalPasiva).'</b></td>
										</tr>';
										?>
										</table>
										
									</div>
								</div>
								<?php
								//$totalPasiva = "";
								?>
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
			} else {
// Group
/********************************************
				GROUP JOURNAL
********************************************/
			//Menampilkan Data Group
			?>
			<div class="portlet-body">
				<div class="table-responsive">
					<div data-scrollbar="true" data-height="400px">
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-6">
									<div class="table-responsive">
										<table width="100%" class="table-hover" cellpadding="3" cellspacing="0" border="0">
											<tr>
												<th align="left" colspan="3">AKTIVA</th>
											</tr>
											<tr>
												<th align="left" colspan="3">AKTIVA LANCAR</th>
											</tr>
		<?php
		//Aktiva
		//Total Percent
		$totalDetailKasBank = $this->Krs->totalCOADetail($listCOAKasBank);
		$totalDetailPiutang = $this->Krs->totalCOADetail($listCOAPiutang);
		$totalDetailAktivaTetap = $this->Krs->totalCOADetail($listCOAAktivaTetap);
		$totalDetailAktivaLancarLainnya = $this->Krs->totalCOADetail($listCOAAktivaLancarLainnya);
		$totalDetailAkumulasiPenyusutan = $this->Krs->totalCOADetail($listCOAAkumulasiPenyusutan);
		
		$grandTotalPercentKasBank = (empty($totalDetailKasBank)) ? 0 : round(array_sum($totalDetailKasBank),2);
		$grandTotalPercentPiutang = (empty($totalDetailPiutang)) ? 0 : round(array_sum($totalDetailPiutang),2);
		$grandTotalPercentAktivaTetap = (empty($totalDetailAktivaTetap)) ? 0 : round(array_sum($totalDetailAktivaTetap),2);
		$grandTotalPercentAktivaLancarLainnya = (empty($totalDetailAktivaLancarLainnya)) ? 0 : round(array_sum($totalDetailAktivaLancarLainnya),2);
		$grandTotalPercentAkumulasiPenyusutan = (empty($totalDetailAkumulasiPenyusutan)) ? 0 : round(array_sum($totalDetailAkumulasiPenyusutan),2);
		$totalPercentAktiva = $grandTotalPercentKasBank+$grandTotalPercentPiutang+$grandTotalPercentAktivaTetap+$grandTotalPercentAktivaLancarLainnya+$grandTotalPercentAkumulasiPenyusutan;


		// Kas Bank
		$grandTotalKasBanks = array();
		foreach ($listCOAKasBank as $idKasBank => $detailKasBank) {
		 	// Keterangan pada Kas serta Bank
		 	if(isset($detailKasBank['Level5']) && $detailKasBank['Level5']) {
				$debetCreditDetailKasBanks = array();
				foreach ($detailKasBank['Level5'] as $dataCOAKasBank) {
					list($codeDetailKasBank, $nameDetailKasBank, $debetCreditDetailKasBank, $beginningBalanceDetailKasBank, $subTotalDetailKasBank) = explode('^', $dataCOAKasBank);
					//$totalKasBanks = $debetCreditDetailKasBank+$beginningBalanceDetailKasBank;
					$debetCreditDetailKasBanks[] = $subTotalDetailKasBank;
					
					$dataPercentGlobalKasBank = $grandTotalPercentKasBank/$totalPercentAktiva*100;
					$percenKasBank = $subTotalDetailKasBank/$grandTotalPercentKasBank*$dataPercentGlobalKasBank;
				}
			}

		 	if(isset($detailKasBank['Level5']) && $detailKasBank['Level4']) {
				list($codeKasBank, $nameKasBank) = explode('^', $detailKasBank['Level4']);

				if(!empty($codeKasBank)) {
					$totalLevel4KasBank = array_sum($debetCreditDetailKasBanks);
					$nominalTotalLevel4KasBank = $this->Krs->cur($totalLevel4KasBank);
					$grandTotalKasBanks[] = $totalLevel4KasBank;
					$percenTotalKasBank = $totalLevel4KasBank/$totalPercentAktiva*100;
					$nominalGrandPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';
				echo '<tr>
						<td>('.$codeKasBank.') '.strtoupper($nameKasBank).'</td>
						<td align="right">'.$nominalTotalLevel4KasBank.'</td>
						<td align="right">'.$nominalGrandPercentKasBank.'</td>
					</tr>';
				}
			}
		}

		// Piutang
		$grandTotalPiutangs = array();
		foreach ($listCOAPiutang as $idPiutang => $detailPiutang) {
		 	// Keterangan pada Kas serta Bank
			if(isset($detailPiutang['Level5']) && $detailPiutang['Level5']) {
				$debetCreditDetailPiutangs = array();
				foreach ($detailPiutang['Level5'] as $dataCOAPiutang) {
					list($codeDetailPiutang, $nameDetailPiutang, $debetCreditDetailPiutang, $beginningBalanceDetailPiutang, $subTotalDetailPiutang) = explode('^', $dataCOAPiutang);
					//$totalPiutangs = $debetCreditDetailPiutang+$beginningBalanceDetailPiutang;
					$debetCreditDetailPiutangs[] = $subTotalDetailPiutang;
					
					$dataPercentGlobalPiutang = $grandTotalPercentPiutang/$totalPercentAktiva*100;
					$percenPiutang = $subTotalDetailPiutang/$grandTotalPercentPiutang*$dataPercentGlobalPiutang;
				}
			}

			if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
				list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

				if(!empty($codePiutang)) {
					$totalLevel4Piutang = array_sum($debetCreditDetailPiutangs);
					$nominalTotalLevel4Piutang = $this->Krs->cur($totalLevel4Piutang);
					$grandTotalPiutangs[] = $totalLevel4Piutang;
					$percenTotalPiutang = $totalLevel4Piutang/$totalPercentAktiva*100;
					$nominalGrandPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';
				echo '<tr>
						<td>('.$codePiutang.') '.strtoupper($namePiutang).'</td>
						<td align="right">'.$nominalTotalLevel4Piutang.'</td>
						<td align="right">'.$nominalGrandPercentPiutang.'</td>
					</tr>';
				}
			}
		}

		// Aktiva Tetap
		$grandTotalAktivaTetaps = array();
		foreach ($listCOAAktivaTetap as $idAktivaTetap => $detailAktivaTetap) {
		 	if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level5']) {
				$debetCreditDetailAktivaTetaps = array();
				foreach ($detailAktivaTetap['Level5'] as $dataCOAAktivaTetap) {
					list($codeDetailAktivaTetap, $nameDetailAktivaTetap, $debetCreditDetailAktivaTetap, $beginningBalanceDetailAktivaTetap, $subTotalDetailAktivaTetap) = explode('^', $dataCOAAktivaTetap);
					//$totalAktivaTetaps = $debetCreditDetailAktivaTetap+$beginningBalanceDetailAktivaTetap;
					$debetCreditDetailAktivaTetaps[] = $subTotalDetailAktivaTetap;
					
					$dataPercentGlobalAktivaTetap = $grandTotalPercentAktivaTetap/$totalPercentAktiva*100;
					$percenAktivaTetap = $subTotalDetailAktivaTetap/$grandTotalPercentAktivaTetap*$dataPercentGlobalAktivaTetap;
				}
			}

			if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level4']) {
				list($codeAktivaTetap, $nameAktivaTetap) = explode('^', $detailAktivaTetap['Level4']);

				if(!empty($codeAktivaTetap)) {
					$totalLevel4AktivaTetap = array_sum($debetCreditDetailAktivaTetaps);
					$nominalTotalLevel4AktivaTetap = $this->Krs->cur($totalLevel4AktivaTetap);
					$grandTotalAktivaTetaps[] = $totalLevel4AktivaTetap;
					$percenTotalAktivaTetap = $totalLevel4AktivaTetap/$totalPercentAktiva*100;
					$nominalGrandPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';
				echo '<tr>
						<td>('.$codeAktivaTetap.') '.strtoupper($nameAktivaTetap).'</td>
						<td align="right">'.$nominalTotalLevel4AktivaTetap.'</td>
						<td align="right">'.$nominalGrandPercentAktivaTetap.'</td>
					</tr>';
				}
			}
		}

		// Aktiva Lancar Lainnya
		$grandTotalAktivaLancarLainnyas = array();
		foreach ($listCOAAktivaLancarLainnya as $idAktivaLancarLainnya => $detailAktivaLancarLainnya) {
		 	if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level5']) {
				$debetCreditDetailAktivaLancarLainnyas = array();
				foreach ($detailAktivaLancarLainnya['Level5'] as $dataCOAAktivaLancarLainnya) {
					list($codeDetailAktivaLancarLainnya, $nameDetailAktivaLancarLainnya, $debetCreditDetailAktivaLancarLainnya, $beginningBalanceDetailAktivaLancarLainnya, $subTotalDetailAktivaLancarLainnya) = explode('^', $dataCOAAktivaLancarLainnya);
					//$totalAktivaLancarLainnyas = $debetCreditDetailAktivaLancarLainnya+$beginningBalanceDetailAktivaLancarLainnya;
					$debetCreditDetailAktivaLancarLainnyas[] = $subTotalDetailAktivaLancarLainnya;
					
					$dataPercentGlobalAktivaLancarLainnya = $grandTotalPercentAktivaLancarLainnya/$totalPercentAktiva*100;
					$percenAktivaLancarLainnya = $subTotalDetailAktivaLancarLainnya/$grandTotalPercentAktivaLancarLainnya*$dataPercentGlobalAktivaLancarLainnya;
				}
			}

			if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level4']) {
				list($codeAktivaLancarLainnya, $nameAktivaLancarLainnya) = explode('^', $detailAktivaLancarLainnya['Level4']);

				if(!empty($codeAktivaLancarLainnya)) {
					$totalLevel4AktivaLancarLainnya = array_sum($debetCreditDetailAktivaLancarLainnyas);
					$nominalTotalLevel4AktivaLancarLainnya = $this->Krs->cur($totalLevel4AktivaLancarLainnya);
					$grandTotalAktivaLancarLainnyas[] = $totalLevel4AktivaLancarLainnya;
					$percenTotalAktivaLancarLainnya = $totalLevel4AktivaLancarLainnya/$totalPercentAktiva*100;
					$nominalGrandPercentAktivaLancarLainnya = $this->Krs->percent($percenTotalAktivaLancarLainnya).'%';
				echo '<tr>
						<td>('.$codeAktivaLancarLainnya.') '.strtoupper($nameAktivaLancarLainnya).'</td>
						<td align="right">'.$nominalTotalLevel4AktivaLancarLainnya.'</td>
						<td align="right">'.$nominalGrandPercentAktivaLancarLainnya.'</td>
					</tr>';
				}
			}
		}
		echo '<tr><th align="left" colspan="3">&nbsp;</th></tr><tr><th align="left" colspan="3">AKTIVA TETAP</th></tr>';

		// Akumulasi Penyusutan
		$grandTotalAkumulasiPenyusutans = array();
		foreach ($listCOAAkumulasiPenyusutan as $idAkumulasiPenyusutan => $detailAkumulasiPenyusutan) {
		 	if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level5']) {
				$debetCreditDetailAkumulasiPenyusutans = array();
				foreach ($detailAkumulasiPenyusutan['Level5'] as $dataCOAAkumulasiPenyusutan) {
					list($codeDetailAkumulasiPenyusutan, $nameDetailAkumulasiPenyusutan, $debetCreditDetailAkumulasiPenyusutan, $beginningBalanceDetailAkumulasiPenyusutan, $subTotalDetailAkumulasiPenyusutan) = explode('^', $dataCOAAkumulasiPenyusutan);
					//$totalAkumulasiPenyusutans = $debetCreditDetailAkumulasiPenyusutan+$beginningBalanceDetailAkumulasiPenyusutan;
					$debetCreditDetailAkumulasiPenyusutans[] = $subTotalDetailAkumulasiPenyusutan;
					
					$dataPercentGlobalAkumulasiPenyusutan = $grandTotalPercentAkumulasiPenyusutan/$totalPercentAktiva*100;
					$percenAkumulasiPenyusutan = $subTotalDetailAkumulasiPenyusutan/$grandTotalPercentAkumulasiPenyusutan*$dataPercentGlobalAkumulasiPenyusutan;
				}
			}

			if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level4']) {
				list($codeAkumulasiPenyusutan, $nameAkumulasiPenyusutan) = explode('^', $detailAkumulasiPenyusutan['Level4']);

				if(!empty($codeAkumulasiPenyusutan)) {
					$totalLevel4AkumulasiPenyusutan = array_sum($debetCreditDetailAkumulasiPenyusutans);
					$nominalTotalLevel4AkumulasiPenyusutan = $this->Krs->cur($totalLevel4AkumulasiPenyusutan);
					$grandTotalAkumulasiPenyusutans[] = $totalLevel4AkumulasiPenyusutan;
					$percenTotalAkumulasiPenyusutan = $totalLevel4AkumulasiPenyusutan/$totalPercentAktiva*100;
					$nominalGrandPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';
				echo '<tr>
						<td>('.$codeAkumulasiPenyusutan.') '.strtoupper($nameAkumulasiPenyusutan).'</td>
						<td align="right">'.$nominalTotalLevel4AkumulasiPenyusutan.'</td>
						<td align="right">'.$nominalGrandPercentAkumulasiPenyusutan.'</td>
					</tr>';
				}
			}
		}

		//TOTAL AKTIVA
		$grandTotalAktivaKasBank = (empty($grandTotalKasBanks)) ? 0 : round(array_sum($grandTotalKasBanks),2);
		$grandTotalAktivaPiutang = (empty($grandTotalPiutangs)) ? 0 : round(array_sum($grandTotalPiutangs),2);
		$grandTotalAktivaAktivaTetap = (empty($grandTotalAktivaTetaps)) ? 0 : round(array_sum($grandTotalAktivaTetaps),2);
		$grandTotalAktivaAktivaLancarLainnya = (empty($grandTotalAktivaLancarLainnyas)) ? 0 : round(array_sum($grandTotalAktivaLancarLainnyas),2);
		$grandTotalAktivaAkumulasiPenyusutan = (empty($grandTotalAkumulasiPenyusutans)) ? 0 : round(array_sum($grandTotalAkumulasiPenyusutans),2);
		
		$totalAktiva = $grandTotalAktivaKasBank+$grandTotalAktivaPiutang+$grandTotalAktivaAktivaTetap+$grandTotalAktivaAktivaLancarLainnya+$grandTotalAktivaAkumulasiPenyusutan;
		
		//$totalAktiva = "";
		echo '<tr>
				<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 10).'<b>TOTAL AKTIVA</b></td>
				<td align="right"><b>'.$this->Krs->cur($totalAktiva).'</b></td>
			</tr>';

		
		
		?>

										</table>
									</div>
								</div>
								<div class="col-md-6">
									<div class="table-responsive">
										<table width="100%" class="table-hover" cellpadding="3" cellspacing="0">
											<tr>
												<th align="left">PASIVA</th>
												<th align="right">&nbsp;</th>
											</tr>
											<tr><th align="left" colspan="3">KAWAJIBAN</th></tr>
											<?php
/***********************************
				PASIVA
***********************************/

//Total Percent
$totalDetailHutang = $this->Krs->totalCOADetail($listCOAHutang);
$totalDetailHutangLancar = $this->Krs->totalCOADetail($listCOAHutangLancar);
$totalDetailModal = $this->Krs->totalCOADetail($listCOAModal);
$totalDetailSaldoDitahan = $this->Krs->totalCOADetail($listCOASaldoDitahan);
$totalDetailPrive = $this->Krs->totalCOADetailBefore($listCOAPrive);
//$totalDetailBeforeSaldoDitahan = $this->Krs->totalCOADetailBefore($listCOABeforeSaldoDitahan);
$totalDetailBeforePrive = $this->Krs->totalCOADetailBefore($listCOABeforePrive);
// pr($listCOASaldoDitahan);


//pr($subTotalBeforeSaldoDitahanss);

$grandTotalPercentHutang = (empty($totalDetailHutang)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutang),2));
$grandTotalPercentHutangLancar = (empty($totalDetailHutangLancar)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutangLancar),2));
$grandTotalPercentModal = (empty($totalDetailModal)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailModal),2));
$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));
$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : round(array_sum($totalDetailPrive),2);
//$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailPrive),2));

//$grandTotalPercentBeforeSaldoDitahan = (empty($totalDetailBeforeSaldoDitahan)) ? 0 : round(array_sum($totalDetailBeforeSaldoDitahan),2);
$grandTotalPercentBeforePrive = (empty($totalDetailBeforePrive)) ? 0 : round(array_sum($totalDetailBeforePrive),2);
//pr($grandTotalPercentPrive);

$grandTotalDetailBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;
//$grandTotalDetailBeforeSaldoDitahan = $grandTotalPercentBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;


$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$totalGrandLabaRugiBerjalan+$grandTotalPercentPrive+$grandTotalDetailBeforeSaldoDitahan;

// Hutang
$grandTotalHutangs = array();
foreach ($listCOAHutang as $idHutang => $detailHutang) {
 	if(isset($detailHutang['Level5']) && $detailHutang['Level5']) {
		$debetCreditDetailHutangs = array();
		foreach ($detailHutang['Level5'] as $dataCOAHutang) {
			list($codeDetailHutang, $nameDetailHutang, $debetCreditDetailHutang, $beginningBalanceDetailHutang, $subTotalDetailHutang) = explode('^', $dataCOAHutang);
			//$totalHutangs = $debetCreditDetailHutang+$beginningBalanceDetailHutang;
			$debetCreditDetailHutangs[] = $subTotalDetailHutang;
			
			$dataPercentGlobalHutang = $grandTotalPercentHutang/$totalPercentPasiva*100;
			$percenHutang = $subTotalDetailHutang/$grandTotalPercentHutang*$dataPercentGlobalHutang;
			//$percenHutang = 0;
			
		}
	}

	if(isset($detailHutang['Level5']) && $detailHutang['Level4']) {
		list($codeHutang, $nameHutang) = explode('^', $detailHutang['Level4']);

		if(!empty($codeHutang)) {
			$totalLevel4Hutang = array_sum($debetCreditDetailHutangs);
			$nominalTotalLevel4Hutang = $this->Krs->cur($totalLevel4Hutang);
			$grandTotalHutangs[] = $totalLevel4Hutang;
			$percenTotalHutang = $totalLevel4Hutang/$totalPercentPasiva*100;
			$nominalGrandPercentHutang = $this->Krs->percent($percenTotalHutang).'%';
		echo '<tr>
				<td>('.$codeHutang.') '.strtoupper($nameHutang).'</td>
				<td align="right">'.$nominalTotalLevel4Hutang.'</td>
				<td align="right">'.$nominalGrandPercentHutang.'</td>
			</tr>';
		}
	}
}

// Hutang Lancar
$grandTotalHutangLancars = array();
foreach ($listCOAHutangLancar as $idHutangLancar => $detailHutangLancar) {
 	if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level5']) {
		$debetCreditDetailHutangLancars = array();
		foreach ($detailHutangLancar['Level5'] as $dataCOAHutangLancar) {
			list($codeDetailHutangLancar, $nameDetailHutangLancar, $debetCreditDetailHutangLancar, $beginningBalanceDetailHutangLancar, $subTotalDetailHutangLancar) = explode('^', $dataCOAHutangLancar);
			//$totalHutangLancars = $debetCreditDetailHutangLancar+$beginningBalanceDetailHutangLancar;
			$debetCreditDetailHutangLancars[] = $subTotalDetailHutangLancar;
			
			$dataPercentGlobalHutangLancar = $grandTotalPercentHutangLancar/$totalPercentPasiva*100;
			$percenHutangLancar = $subTotalDetailHutangLancar/$grandTotalPercentHutangLancar*$dataPercentGlobalHutangLancar;
			
		}
	}

	if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level4']) {
		list($codeHutangLancar, $nameHutangLancar) = explode('^', $detailHutangLancar['Level4']);

		if(!empty($codeHutangLancar)) {
			$totalLevel4HutangLancar = array_sum($debetCreditDetailHutangLancars);
			$nominalTotalLevel4HutangLancar = $this->Krs->cur($totalLevel4HutangLancar);
			$grandTotalHutangLancars[] = $totalLevel4HutangLancar;
			$percenTotalHutangLancar = $totalLevel4HutangLancar/$totalPercentPasiva*100;
			$nominalGrandPercentHutangLancar = $this->Krs->percent($percenTotalHutangLancar).'%';
		echo '<tr>
				<td>('.$codeHutangLancar.') '.strtoupper($nameHutangLancar).'</td>
				<td align="right">'.$nominalTotalLevel4HutangLancar.'</td>
				<td align="right">'.$nominalGrandPercentHutangLancar.'</td>
			</tr>';
		}
	}
}



echo '<tr><th align="left" colspan="3">&nbsp;</th></tr><tr><th align="left" colspan="3">EKUITAS</th></tr>';




// Modal
$grandTotalModals = array();
foreach ($listCOAModal as $idModal => $detailModal) {
 	if(isset($detailModal['Level5']) && $detailModal['Level5']) {
		$debetCreditDetailModals = array();
		foreach ($detailModal['Level5'] as $dataCOAModal) {
			list($codeDetailModal, $nameDetailModal, $debetCreditDetailModal, $beginningBalanceDetailModal, $subTotalDetailModal) = explode('^', $dataCOAModal);
			//$totalModals = $debetCreditDetailModal+$beginningBalanceDetailModal;
			$debetCreditDetailModals[] = $subTotalDetailModal;
			
			$dataPercentGlobalModal = $grandTotalPercentModal/$totalPercentPasiva*100;
			$percenModal = $subTotalDetailModal/$grandTotalPercentModal*$dataPercentGlobalModal;
			
		}
	}

	if(isset($detailModal['Level5']) && $detailModal['Level4']) {
		list($codeModal, $nameModal) = explode('^', $detailModal['Level4']);

		if(!empty($codeModal)) {
			$totalLevel4Modal = array_sum($debetCreditDetailModals);
			$nominalTotalLevel4Modal = $this->Krs->cur($totalLevel4Modal);
			$grandTotalModals[] = $totalLevel4Modal;
			$percenTotalModal = $totalLevel4Modal/$totalPercentPasiva*100;
			$nominalGrandPercentModal = $this->Krs->percent($percenTotalModal).'%';
		echo '<tr>
				<td>('.$codeHutangLancar.') '.strtoupper($nameModal).'</td>
				<td align="right">'.$nominalTotalLevel4Modal.'</td>
				<td align="right">'.$nominalGrandPercentModal.'</td>
			</tr>';
		}
	}
}

// Saldo Laba Ditahan
$grandTotalBeforePrives = array();
foreach ($listCOABeforePrive as $idBeforePrive => $detailBeforePrive) {
 	if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level5']) {
		$debetCreditDetailBeforePrives = array();
		foreach ($detailBeforePrive['Level5'] as $dataCOABeforePrive) {
			list($codeDetailBeforePrive, $nameDetailBeforePrive, $debetCreditDetailBeforePrive, $beginningBalanceDetailBeforePrive, $subTotalDetailBeforePrive) = explode('^', $dataCOABeforePrive);
			$debetCreditDetailBeforePrives[] = $subTotalDetailBeforePrive;
		}
	}

	if(isset($detailBeforePrive['Level5']) && $detailBeforePrive['Level4']) {
		list($codeBeforePrive, $nameBeforePrive) = explode('^', $detailBeforePrive['Level4']);

		if(!empty($codeBeforePrive)) {
			$totalLevel4BeforePrive = array_sum($debetCreditDetailBeforePrives);
			$grandTotalBeforePrives[] = $totalLevel4BeforePrive;			
		}
	}
}
$grandTotalBeforePrive = (empty($grandTotalBeforePrives)) ? 0 : round(array_sum($grandTotalBeforePrives),2);

//pr($listCOASaldoDitahan);
$grandTotalSaldoDitahans = array();
foreach ($listCOASaldoDitahan as $idSaldoDitahan => $detailSaldoDitahan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level5']) {
		$debetCreditDetailSaldoDitahans = array();
		//pr($detailSaldoDitahan['Level5']);
		
		foreach ($detailSaldoDitahan['Level5'] as $dataCOASaldoDitahan) {
			list($codeDetailSaldoDitahan, $nameDetailSaldoDitahan, $debetCreditDetailSaldoDitahan, $beginningBalanceDetailSaldoDitahan, $subTotalDetailSaldoDitahan) = explode('^', $dataCOASaldoDitahan);

			//list($codeDetailBeforeSaldoDitahan, $nameDetailBeforeSaldoDitahan, $debetCreditDetailBeforeSaldoDitahan, $beginningBalanceDetailBeforeSaldoDitahan, $subTotalDetailBeforeSaldoDitahan) = explode('^', $listCOABeforeSaldoDitahan[$idSaldoDitahan]['Level5'][0]);

			//$totalSaldoDitahans = $debetCreditDetailSaldoDitahan+$beginningBalanceDetailSaldoDitahan;
			//pr('data : '.$grandTotalBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive);
			$subTotalBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
			
			//pr($grandTotalBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive);
			//$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
			

			
			//pr("BeforeSaldoDitahanAsli = ".$grandTotalBeforeSaldoDitahan." / BeforeSaldoDitahan =  + BeforeLabaRugiBerjalan = ".$totalGrandBeforeLabaRugiBerjalan.' + BeforePrive = '.$grandTotalBeforePrive);

			$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
			//$debetCreditDetailSaldoDitahans[] = $subTotalDetailSaldoDitahan;
			$totalBeforeSaldoDitahan = $subTotalBeforeSaldoDitahan;
			$nominalDetailSaldoDitahan = $this->Krs->cur($subTotalBeforeSaldoDitahan);
			//$nominalDetailSaldoDitahan = $this->Krs->cur($subTotalDetailSaldoDitahan);

			$dataPercentGlobalSaldoDitahan = $grandTotalPercentSaldoDitahan/$totalPercentPasiva*100;
			$percenSaldoDitahan = ($dataPercentGlobalSaldoDitahan!=0) ? $subTotalBeforeSaldoDitahan/$grandTotalPercentSaldoDitahan*$dataPercentGlobalSaldoDitahan:0;
			//$percenSaldoDitahan = $subTotalDetailSaldoDitahan/$grandTotalPercentSaldoDitahan*$dataPercentGlobalSaldoDitahan;
			//$percenSaldoDitahan = 0;
			$nominalPercenSaldoDitahan = $this->Krs->percent($percenSaldoDitahan).'%';
		}
		
		
	} else {
		// pr($grandTotalBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive);
		$subTotalBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
		$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
	}

	if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level4']) {
		list($codeSaldoDitahan, $nameSaldoDitahan) = explode('^', $detailSaldoDitahan['Level4']);

		if(!empty($codeSaldoDitahan)) {
			$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
			$nominalTotalLevel4SaldoDitahan = $this->Krs->cur($totalLevel4SaldoDitahan);
			$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
			$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
			$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';
		echo '<tr>
				<td>('.$codeSaldoDitahan.') '.strtoupper($nameSaldoDitahan).'</td>
				<td align="right">'.$nominalTotalLevel4SaldoDitahan.'</td>
				<td align="right">'.$nominalGrandPercentSaldoDitahan.'</td>
			</tr>';
		}
	} else {
		$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
		$nominalTotalLevel4SaldoDitahan = $this->Krs->cur($totalLevel4SaldoDitahan);
		$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
		$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
		$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';
		if($totalLevel4SaldoDitahan>0) {
		echo '<tr>
				<td>'.strtoupper('Saldo Laba Ditahan').'</td>
				<td align="right">'.$nominalTotalLevel4SaldoDitahan.'</td>
				<td align="right">'.$nominalGrandPercentSaldoDitahan.'</td>
			</tr>';
		}
	}
}

// Laba/Rugi Berjalan
//pr($totalGrandBeforeLabaRugiBerjalan);
// pr($totalGrandLabaRugiBerjalan.'/'.$totalPercentPasiva);
$percenTotalLabaRugiBerjalan = $totalGrandLabaRugiBerjalan/$totalPercentPasiva*100;
//$percenTotalLabaRugiBerjalan = $totalGrandLabaRugiBerjalan/$totalPercentPasiva*100;
$nominalGrandPercentLabaRugiBerjalan = $this->Krs->percent($percenTotalLabaRugiBerjalan).'%';

echo '<tr>
		<td align="left">LABA/RUGI BERJALAN</td>';
	
		echo '<td align="right">'.$this->Krs->cur($totalGrandLabaRugiBerjalan).'</td><td align="right">'.$nominalGrandPercentLabaRugiBerjalan.'</td>';
echo '</tr>';

// Prive
$grandTotalPrives = array();
foreach ($listCOAPrive as $idPrive => $detailPrive) {
 	if(isset($detailPrive['Level5']) && $detailPrive['Level5']) {
		$debetCreditDetailPrives = array();
		foreach ($detailPrive['Level5'] as $dataCOAPrive) {
			list($codeDetailPrive, $nameDetailPrive, $debetCreditDetailPrive, $beginningBalanceDetailPrive, $subTotalDetailPrive) = explode('^', $dataCOAPrive);
			//$totalPrives = $debetCreditDetailPrive+$beginningBalanceDetailPrive;
			$debetCreditDetailPrives[] = $subTotalDetailPrive;
			
			$dataPercentGlobalPrive = $grandTotalPercentPrive/$totalPercentPasiva*100;
			$percenPrive = $subTotalDetailPrive/$grandTotalPercentPrive*$dataPercentGlobalPrive;
			//$percenPrive = 0;
		}
	}

	if(isset($detailPrive['Level5']) && $detailPrive['Level4']) {
		list($codePrive, $namePrive) = explode('^', $detailPrive['Level4']);

		if(!empty($codePrive)) {
			$totalLevel4Prive = array_sum($debetCreditDetailPrives);
			$nominalTotalLevel4Prive = $this->Krs->cur($totalLevel4Prive);
			$grandTotalPrives[] = $totalLevel4Prive;
			$percenTotalPrive = $totalLevel4Prive/$totalPercentPasiva*100;
			$nominalGrandPercentPrive = $this->Krs->percent($percenTotalPrive).'%';
		echo '<tr>
				<td>('.$codePrive.') '.strtoupper($namePrive).'</td>
				<td align="right">'.$nominalTotalLevel4Prive.'</td>
				<td align="right">'.$nominalGrandPercentPrive.'</td>
			</tr>';
		}
	}
}
//TOTAL PASIVA
$grandTotalPasivaHutang = (empty($grandTotalHutangs)) ? 0 : round(array_sum($grandTotalHutangs),2);
$grandTotalPasivaHutangLancar = (empty($grandTotalHutangLancars)) ? 0 : round(array_sum($grandTotalHutangLancars),2);
$grandTotalPasivaModal = (empty($grandTotalModals)) ? 0 : round(array_sum($grandTotalModals),2);
$grandTotalPasivaSaldoDitahan = (empty($grandTotalSaldoDitahans)) ? 0 : round(array_sum($grandTotalSaldoDitahans),2);
$grandTotalPasivaPrive = (empty($grandTotalPrives)) ? 0 : round(array_sum($grandTotalPrives),2);


$totalPasiva = $grandTotalPasivaHutang+$grandTotalPasivaHutangLancar+$grandTotalPasivaModal+$grandTotalPasivaSaldoDitahan+$grandTotalPasivaPrive+$totalGrandLabaRugiBerjalan;
//pr($grandTotalPasivaHutang.'+'.$grandTotalPasivaHutangLancar.'+'.$grandTotalPasivaModal.'+'.$grandTotalPasivaSaldoDitahan.'+'.$grandTotalPasivaPrive.'+'.$totalGrandLabaRugiBerjalan.'='.$totalPasiva);
echo '<tr>
		<td align="left">'.str_repeat('&nbsp;&nbsp;&nbsp;', 10).'<b>TOTAL PASIVA</b></td>
		<td align="right"><b>'.$this->Krs->cur($totalPasiva).'</b></td>
	</tr>';
											?>
										</table>
										
									</div>
								</div>
								<?php
								//$totalPasiva = "";
								?>
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
		<?php
		}
		?>
	</div>


</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	var confirmTitle = "Apakah anda ingin menampilkan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'triata_acc_journals', 'action' => 'balance_sheet_percent_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalIncomeGlobalReportForm', 'btn-search', confirmTitle, formAction);

    $("#datepicker-autoClose").datepicker({
        todayHighlight: true,
        autoclose: true
    });

	//handleDateRange('filterDateId', 'filterDateReset', 'filterDateClass', 'dd-mm-yyyy');
});
</script>