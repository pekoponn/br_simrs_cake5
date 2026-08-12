<?= $this->Krs->breadcrumb('Accounting', 'Neraca (Saldo)', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    
    <div class="panel-body bg-warning-transparent-4">
    	<?= $this->Form->create($artamaAccJournal) ?>
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
										<th width="150" align="center"><b>No Perkiraan</b></th>
										<th><b>Keterangan</b></th>
										<th width="150" align="center"><b>Debit</b></th>
										<th width="150" align="center"><b>Kredit</b></th>
										<th width="150" align="center"><b>Saldo Awal</b></th>
										<th width="150" align="center"><b>Saldo</b></th>

										<?php
										/*for ($i=$monthFrom; $i <= $monthEnd; $i++) {
											$monthIndo = $this->Krs->getMonth($i);

										echo '<th align="center"><b>'.$monthIndo.'</b></th>
										<th align="center" width="85">%</th>';
										}*/
										?>
									</tr>
								</tr>
							</thead>
							<tbody>
							<?php
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
										list($codeDetailKasBank, $nameDetailKasBank, $totalDebetCreditDetailKasBank, $debetDetailKasBank, $creditDetailKasBank, $beginningBalanceDetailKasBank, $subTotalDetailKasBank) = explode('^', $dataCOAKasBank);

										// 1.02.1.01.0002^ Artama Mulia Indonesia  Pt- 141-00-2825077-7^13096476856.47^13096476856.4700^0^10714807.44^13107191663.91

										//$totalKasBanks = $debetCreditDetailKasBank+$beginningBalanceDetailKasBank;
										$debetDetailKasBanks[] = $debetDetailKasBank;
										$creditDetailKasBanks[] = $creditDetailKasBank;
										$beginningDetailKasBanks[] = $beginningBalanceDetailKasBank;
										$totalDetailKasBanks[] = $subTotalDetailKasBank;
										$nominalDebetDetailKasBank = $this->Krs->cur($debetDetailKasBank);
										$nominalCreditDetailKasBank = $this->Krs->cur($creditDetailKasBank);
										$nominalBeginningDetailKasBank = $this->Krs->cur($beginningBalanceDetailKasBank);
										$nominalTotalDetailKasBank = $this->Krs->cur($subTotalDetailKasBank);

										echo '<tr>
												<td>'.$codeDetailKasBank.'</td>
												<td>'.$nameDetailKasBank.'</td>
												<td align="right">'.$nominalDebetDetailKasBank.'</td>
												<td align="right">'.$nominalCreditDetailKasBank.'</td>
												<td align="right">'.$nominalBeginningDetailKasBank.'</td>
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
										list($codeDetailPiutang, $nameDetailPiutang, $totalDebetCreditDetailPiutang, $debetDetailPiutang, $creditDetailPiutang, $beginningBalanceDetailPiutang, $subTotalDetailPiutang) = explode('^', $dataCOAPiutang);
										//$totalPiutangs = $debetCreditDetailPiutang+$beginningBalanceDetailPiutang;
										$debetDetailPiutangs[] = $debetDetailPiutang;
										$creditDetailPiutangs[] = $creditDetailPiutang;
										$beginningDetailPiutangs[] = $beginningBalanceDetailPiutang;
										$totalDetailPiutangs[] = $subTotalDetailPiutang;
										$nominalDebetDetailPiutang = $this->Krs->cur($debetDetailPiutang);
										$nominalCreditDetailPiutang = $this->Krs->cur($creditDetailPiutang);
										$nominalBeginningDetailPiutang = $this->Krs->cur($beginningBalanceDetailPiutang);
										$nominalTotalDetailPiutang = $this->Krs->cur($subTotalDetailPiutang);

										echo '<tr>
												<td>'.$codeDetailPiutang.'</td>
												<td>'.$nameDetailPiutang.'</td>
												<td align="right">'.$nominalDebetDetailPiutang.'</td>
												<td align="right">'.$nominalCreditDetailPiutang.'</td>
												<td align="right">'.$nominalBeginningDetailPiutang.'</td>
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
										list($codeDetailAktivaTetap, $nameDetailAktivaTetap, $totalDebetCreditDetailAktivaTetap, $debetDetailAktivaTetap, $creditDetailAktivaTetap, $beginningBalanceDetailAktivaTetap, $subTotalDetailAktivaTetap) = explode('^', $dataCOAAktivaTetap);
										//$totalAktivaTetaps = $debetCreditDetailAktivaTetap+$beginningBalanceDetailAktivaTetap;
										$debetDetailAktivaTetaps[] = $debetDetailAktivaTetap;
										$creditDetailAktivaTetaps[] = $creditDetailAktivaTetap;
										$beginningDetailAktivaTetaps[] = $beginningBalanceDetailAktivaTetap;
										$totalDetailAktivaTetaps[] = $subTotalDetailAktivaTetap;
										$nominalDebetDetailAktivaTetap = $this->Krs->cur($debetDetailAktivaTetap);
										$nominalCreditDetailAktivaTetap = $this->Krs->cur($creditDetailAktivaTetap);
										$nominalBeginningDetailAktivaTetap = $this->Krs->cur($beginningBalanceDetailAktivaTetap);
										$nominalTotalDetailAktivaTetap = $this->Krs->cur($subTotalDetailAktivaTetap);

										echo '<tr>
												<td>'.$codeDetailAktivaTetap.'</td>
												<td>'.$nameDetailAktivaTetap.'</td>
												<td align="right">'.$nominalDebetDetailAktivaTetap.'</td>
												<td align="right">'.$nominalCreditDetailAktivaTetap.'</td>
												<td align="right">'.$nominalBeginningDetailAktivaTetap.'</td>
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
										list($codeDetailAkumulasiPenyusutan, $nameDetailAkumulasiPenyusutan, $totalDebetCreditDetailAkumulasiPenyusutan, $debetDetailAkumulasiPenyusutan, $creditDetailAkumulasiPenyusutan, $beginningBalanceDetailAkumulasiPenyusutan, $subTotalDetailAkumulasiPenyusutan) = explode('^', $dataCOAAkumulasiPenyusutan);
										//$totalAkumulasiPenyusutans = $debetCreditDetailAkumulasiPenyusutan+$beginningBalanceDetailAkumulasiPenyusutan;
										$debetDetailAkumulasiPenyusutans[] = $debetDetailAkumulasiPenyusutan;
										$creditDetailAkumulasiPenyusutans[] = $creditDetailAkumulasiPenyusutan;
										$beginningDetailAkumulasiPenyusutans[] = $beginningBalanceDetailAkumulasiPenyusutan;
										$totalDetailAkumulasiPenyusutans[] = $subTotalDetailAkumulasiPenyusutan;
										$nominalDebetDetailAkumulasiPenyusutan = $this->Krs->cur($debetDetailAkumulasiPenyusutan);
										$nominalCreditDetailAkumulasiPenyusutan = $this->Krs->cur($creditDetailAkumulasiPenyusutan);
										$nominalBeginningDetailAkumulasiPenyusutan = $this->Krs->cur($beginningBalanceDetailAkumulasiPenyusutan);
										$nominalTotalDetailAkumulasiPenyusutan = $this->Krs->cur($subTotalDetailAkumulasiPenyusutan);

										echo '<tr>
												<td>'.$codeDetailAkumulasiPenyusutan.'</td>
												<td>'.$nameDetailAkumulasiPenyusutan.'</td>
												<td align="right">'.$nominalDebetDetailAkumulasiPenyusutan.'</td>
												<td align="right">'.$nominalCreditDetailAkumulasiPenyusutan.'</td>
												<td align="right">'.$nominalBeginningDetailAkumulasiPenyusutan.'</td>
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
										list($codeDetailHutang, $nameDetailHutang, $totalDebetCreditDetailHutang, $debetDetailHutang, $creditDetailHutang, $beginningBalanceDetailHutang, $subTotalDetailHutang) = explode('^', $dataCOAHutang);
										//$totalHutangs = $debetCreditDetailHutang+$beginningBalanceDetailHutang;
										$debetDetailHutangs[] = $debetDetailHutang;
										$creditDetailHutangs[] = $creditDetailHutang;
										$beginningDetailHutangs[] = $beginningBalanceDetailHutang;
										$totalDetailHutangs[] = $subTotalDetailHutang;
										$nominalDebetDetailHutang = $this->Krs->cur($debetDetailHutang);
										$nominalCreditDetailHutang = $this->Krs->cur($creditDetailHutang);
										$nominalBeginningDetailHutang = $this->Krs->cur($beginningBalanceDetailHutang);
										$nominalTotalDetailHutang = $this->Krs->cur($subTotalDetailHutang);

										echo '<tr>
												<td>'.$codeDetailHutang.'</td>
												<td>'.$nameDetailHutang.'</td>
												<td align="right">'.$nominalDebetDetailHutang.'</td>
												<td align="right">'.$nominalCreditDetailHutang.'</td>
												<td align="right">'.$nominalBeginningDetailHutang.'</td>
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
										list($codeDetailHutangLancar, $nameDetailHutangLancar, $totalDebetCreditDetailHutangLancar, $debetDetailHutangLancar, $creditDetailHutangLancar, $beginningBalanceDetailHutangLancar, $subTotalDetailHutangLancar) = explode('^', $dataCOAHutangLancar);
										//$totalHutangLancars = $debetCreditDetailHutangLancar+$beginningBalanceDetailHutangLancar;
										$debetDetailHutangLancars[] = $debetDetailHutangLancar;
										$creditDetailHutangLancars[] = $creditDetailHutangLancar;
										$beginningDetailHutangLancars[] = $beginningBalanceDetailHutangLancar;
										$totalDetailHutangLancars[] = $subTotalDetailHutangLancar;
										$nominalDebetDetailHutangLancar = $this->Krs->cur($debetDetailHutangLancar);
										$nominalCreditDetailHutangLancar = $this->Krs->cur($creditDetailHutangLancar);
										$nominalBeginningDetailHutangLancar = $this->Krs->cur($beginningBalanceDetailHutangLancar);
										$nominalTotalDetailHutangLancar = $this->Krs->cur($subTotalDetailHutangLancar);

										echo '<tr>
												<td>'.$codeDetailHutangLancar.'</td>
												<td>'.$nameDetailHutangLancar.'</td>
												<td align="right">'.$nominalDebetDetailHutangLancar.'</td>
												<td align="right">'.$nominalCreditDetailHutangLancar.'</td>
												<td align="right">'.$nominalBeginningDetailHutangLancar.'</td>
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
										list($codeDetailModal, $nameDetailModal, $totalDebetCreditDetailModal, $debetDetailModal, $creditDetailModal, $beginningBalanceDetailModal, $subTotalDetailModal) = explode('^', $dataCOAModal);
										//$totalModals = $debetCreditDetailModal+$beginningBalanceDetailModal;
										$debetDetailModals[] = $debetDetailModal;
										$creditDetailModals[] = $creditDetailModal;
										$beginningDetailModals[] = $beginningBalanceDetailModal;
										$totalDetailModals[] = $subTotalDetailModal;
										$nominalDebetDetailModal = $this->Krs->cur($debetDetailModal);
										$nominalCreditDetailModal = $this->Krs->cur($creditDetailModal);
										$nominalBeginningDetailModal = $this->Krs->cur($beginningBalanceDetailModal);
										$nominalTotalDetailModal = $this->Krs->cur($subTotalDetailModal);

										echo '<tr>
												<td>'.$codeDetailModal.'</td>
												<td>'.$nameDetailModal.'</td>
												<td align="right">'.$nominalDebetDetailModal.'</td>
												<td align="right">'.$nominalCreditDetailModal.'</td>
												<td align="right">'.$nominalBeginningDetailModal.'</td>
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
										list($codeDetailBeforePrive, $nameDetailBeforePrive, $totalDebetCreditDetailBeforePrive, $debetDetailBeforePrive, $creditDetailBeforePrive, $beginningBalanceDetailBeforePrive, $subTotalDetailBeforePrive) = explode('^', $dataCOABeforePrive);

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
										list($codeDetailSaldoDitahan, $nameDetailSaldoDitahan, $totalDebetCreditDetailSaldoDitahan, $debetDetailSaldoDitahan, $creditDetailSaldoDitahan, $beginningBalanceDetailSaldoDitahan, $subTotalDetailSaldoDitahan) = explode('^', $dataCOASaldoDitahan);

										list($codeDetailBeforeSaldoDitahan, $nameDetailBeforeSaldoDitahan, $totalDebetCreditDetailBeforeSaldoDitahan, $debetDetailBeforeSaldoDitahan, $creditDetailBeforeSaldoDitahan, $beginningBalanceDetailBeforeSaldoDitahan, $subTotalDetailBeforeSaldoDitahan) = explode('^', $listCOABeforeSaldoDitahan[$idSaldoDitahan]['Level5'][0]);
										
										$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
										//pr($debetDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeDebetLabaRugiBerjalan.'+'.$grandTotalBeforeDebetPrive);

										$debetSaldoDitahan = ((int)$debetDetailBeforeSaldoDitahan+(int)$totalGrandBeforeDebetLabaRugiBerjalan+(int)$grandTotalBeforeDebetPrive);
										$creditSaldoDitahan = ((int)$creditDetailBeforeSaldoDitahan+(int)$totalGrandBeforeCreditLabaRugiBerjalan+(int)$grandTotalBeforeCreditPrive);
										//totalGrandBeforeCreditLabaRugiBerjalan
										$totalkus = ((int)$debetSaldoDitahan+(int)$beginningBalanceDetailSaldoDitahan-(int)$creditSaldoDitahan);
										$totalku = $this->Krs->cur($totalkus);

										$debetDetailSaldoDitahans[] = $debetSaldoDitahan;
										$creditDetailSaldoDitahans[] = $creditSaldoDitahan;
										$beginningDetailSaldoDitahans[] = $beginningBalanceDetailSaldoDitahan;
										$totalDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
										$nominalDebetDetailSaldoDitahan = $this->Krs->cur($debetSaldoDitahan);
										$nominalCreditDetailSaldoDitahan = $this->Krs->cur($creditSaldoDitahan);
										$nominalBeginningDetailSaldoDitahan = $this->Krs->cur($beginningBalanceDetailSaldoDitahan);
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
												<td align="right">'.$nominalBeginningDetailSaldoDitahan.'</td>
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
										list($codeDetailPrive, $nameDetailPrive, $totalDebetCreditDetailPrive, $debetDetailPrive, $creditDetailPrive, $beginningBalanceDetailPrive, $subTotalDetailPrive) = explode('^', $dataCOAPrive);
										//$totalPrives = $debetCreditDetailPrive+$beginningBalanceDetailPrive;
										$debetDetailPrives[] = $debetDetailPrive;
										$creditDetailPrives[] = $creditDetailPrive;
										$beginningDetailPrives[] = $beginningBalanceDetailPrive;
										$totalDetailPrives[] = $subTotalDetailPrive;
										$nominalDebetDetailPrive = $this->Krs->cur($debetDetailPrive);
										$nominalCreditDetailPrive = $this->Krs->cur($creditDetailPrive);
										$nominalBeginningDetailPrive = $this->Krs->cur($beginningBalanceDetailPrive);
										$nominalTotalDetailPrive = $this->Krs->cur($subTotalDetailPrive);

										echo '<tr>
												<td>'.$codeDetailPrive.'</td>
												<td>'.$nameDetailPrive.'</td>
												<td align="right">'.$nominalDebetDetailPrive.'</td>
												<td align="right">'.$nominalCreditDetailPrive.'</td>
												<td align="right">'.$nominalBeginningDetailPrive.'</td>
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
										list($codeDetailPendapatanShow, $nameDetailPendapatanShow, $totalDebetCreditDetailPendapatanShow, $debetDetailPendapatanShow, $creditDetailPendapatanShow, $beginningBalanceDetailPendapatanShow, $subTotalDetailPendapatanShow) = explode('^', $dataCOAPendapatanShow);
										//$totalPendapatanShows = $debetCreditDetailPendapatanShow+$beginningBalanceDetailPendapatanShow;
										$debetDetailPendapatanShows[] = $debetDetailPendapatanShow;
										$creditDetailPendapatanShows[] = $creditDetailPendapatanShow;
										$beginningDetailPendapatanShows[] = $beginningBalanceDetailPendapatanShow;
										$totalDetailPendapatanShows[] = $subTotalDetailPendapatanShow;
										$nominalDebetDetailPendapatanShow = $this->Krs->cur($debetDetailPendapatanShow);
										$nominalCreditDetailPendapatanShow = $this->Krs->cur($creditDetailPendapatanShow);
										$nominalBeginningDetailPendapatanShow = $this->Krs->cur($beginningBalanceDetailPendapatanShow);
										$nominalTotalDetailPendapatanShow = $this->Krs->cur($subTotalDetailPendapatanShow);

										echo '<tr>
												<td>'.$codeDetailPendapatanShow.'</td>
												<td>'.$nameDetailPendapatanShow.'</td>
												<td align="right">'.$nominalDebetDetailPendapatanShow.'</td>
												<td align="right">'.$nominalCreditDetailPendapatanShow.'</td>
												<td align="right">'.$nominalBeginningDetailPendapatanShow.'</td>
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
										list($codeDetailPendapatanLain, $nameDetailPendapatanLain, $totalDebetCreditDetailPendapatanLain, $debetDetailPendapatanLain, $creditDetailPendapatanLain, $beginningBalanceDetailPendapatanLain, $subTotalDetailPendapatanLain) = explode('^', $dataCOAPendapatanLain);
										//$totalPendapatanLains = $debetCreditDetailPendapatanLain+$beginningBalanceDetailPendapatanLain;
										$debetDetailPendapatanLains[] = $debetDetailPendapatanLain;
										$creditDetailPendapatanLains[] = $creditDetailPendapatanLain;
										$beginningDetailPendapatanLains[] = $beginningBalanceDetailPendapatanLain;
										$totalDetailPendapatanLains[] = $subTotalDetailPendapatanLain;
										$nominalDebetDetailPendapatanLain = $this->Krs->cur($debetDetailPendapatanLain);
										$nominalCreditDetailPendapatanLain = $this->Krs->cur($creditDetailPendapatanLain);
										$nominalBeginningDetailPendapatanLain = $this->Krs->cur($beginningBalanceDetailPendapatanLain);
										$nominalTotalDetailPendapatanLain = $this->Krs->cur($subTotalDetailPendapatanLain);

										echo '<tr>
												<td>'.$codeDetailPendapatanLain.'</td>
												<td>'.$nameDetailPendapatanLain.'</td>
												<td align="right">'.$nominalDebetDetailPendapatanLain.'</td>
												<td align="right">'.$nominalCreditDetailPendapatanLain.'</td>
												<td align="right">'.$nominalBeginningDetailPendapatanLain.'</td>
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
										list($codeDetailBeban, $nameDetailBeban, $totalDebetCreditDetailBeban, $debetDetailBeban, $creditDetailBeban, $beginningBalanceDetailBeban, $subTotalDetailBeban) = explode('^', $dataCOABeban);
										//$totalBebans = $debetCreditDetailBeban+$beginningBalanceDetailBeban;
										$debetDetailBebans[] = $debetDetailBeban;
										$creditDetailBebans[] = $creditDetailBeban;
										$beginningDetailBebans[] = $beginningBalanceDetailBeban;
										$totalDetailBebans[] = $subTotalDetailBeban;
										$nominalDebetDetailBeban = $this->Krs->cur($debetDetailBeban);
										$nominalCreditDetailBeban = $this->Krs->cur($creditDetailBeban);
										$nominalBeginningDetailBeban = $this->Krs->cur($beginningBalanceDetailBeban);
										$nominalTotalDetailBeban = $this->Krs->cur($subTotalDetailBeban);

										echo '<tr>
												<td>'.$codeDetailBeban.'</td>
												<td>'.$nameDetailBeban.'</td>
												<td align="right">'.$nominalDebetDetailBeban.'</td>
												<td align="right">'.$nominalCreditDetailBeban.'</td>
												<td align="right">'.$nominalBeginningDetailBeban.'</td>
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
										list($codeDetailBebanPemasaran, $nameDetailBebanPemasaran, $totalDebetCreditDetailBebanPemasaran, $debetDetailBebanPemasaran, $creditDetailBebanPemasaran, $beginningBalanceDetailBebanPemasaran, $subTotalDetailBebanPemasaran) = explode('^', $dataCOABebanPemasaran);
										//$totalBebanPemasarans = $debetCreditDetailBebanPemasaran+$beginningBalanceDetailBebanPemasaran;
										$debetDetailBebanPemasarans[] = $debetDetailBebanPemasaran;
										$creditDetailBebanPemasarans[] = $creditDetailBebanPemasaran;
										$beginningDetailBebanPemasarans[] = $beginningBalanceDetailBebanPemasaran;
										$totalDetailBebanPemasarans[] = $subTotalDetailBebanPemasaran;
										$nominalDebetDetailBebanPemasaran = $this->Krs->cur($debetDetailBebanPemasaran);
										$nominalCreditDetailBebanPemasaran = $this->Krs->cur($creditDetailBebanPemasaran);
										$nominalBeginningDetailBebanPemasaran = $this->Krs->cur($beginningBalanceDetailBebanPemasaran);
										$nominalTotalDetailBebanPemasaran = $this->Krs->cur($subTotalDetailBebanPemasaran);

										echo '<tr>
												<td>'.$codeDetailBebanPemasaran.'</td>
												<td>'.$nameDetailBebanPemasaran.'</td>
												<td align="right">'.$nominalDebetDetailBebanPemasaran.'</td>
												<td align="right">'.$nominalCreditDetailBebanPemasaran.'</td>
												<td align="right">'.$nominalBeginningDetailBebanPemasaran.'</td>
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
										list($codeDetailBebanLainLain, $nameDetailBebanLainLain, $totalDebetCreditDetailBebanLainLain, $debetDetailBebanLainLain, $creditDetailBebanLainLain, $beginningBalanceDetailBebanLainLain, $subTotalDetailBebanLainLain) = explode('^', $dataCOABebanLainLain);
										//$totalBebanLainLains = $debetCreditDetailBebanLainLain+$beginningBalanceDetailBebanLainLain;
										$debetDetailBebanLainLains[] = $debetDetailBebanLainLain;
										$creditDetailBebanLainLains[] = $creditDetailBebanLainLain;
										$beginningDetailBebanLainLains[] = $beginningBalanceDetailBebanLainLain;
										$totalDetailBebanLainLains[] = $subTotalDetailBebanLainLain;
										$nominalDebetDetailBebanLainLain = $this->Krs->cur($debetDetailBebanLainLain);
										$nominalCreditDetailBebanLainLain = $this->Krs->cur($creditDetailBebanLainLain);
										$nominalBeginningDetailBebanLainLain = $this->Krs->cur($beginningBalanceDetailBebanLainLain);
										$nominalTotalDetailBebanLainLain = $this->Krs->cur($subTotalDetailBebanLainLain);

										echo '<tr>
												<td>'.$codeDetailBebanLainLain.'</td>
												<td>'.$nameDetailBebanLainLain.'</td>
												<td align="right">'.$nominalDebetDetailBebanLainLain.'</td>
												<td align="right">'.$nominalCreditDetailBebanLainLain.'</td>
												<td align="right">'.$nominalBeginningDetailBebanLainLain.'</td>
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
										list($codeDetailHargaPokokPenjualan, $nameDetailHargaPokokPenjualan, $totalDebetCreditDetailHargaPokokPenjualan, $debetDetailHargaPokokPenjualan, $creditDetailHargaPokokPenjualan, $beginningBalanceDetailHargaPokokPenjualan, $subTotalDetailHargaPokokPenjualan) = explode('^', $dataCOAHargaPokokPenjualan);
										//$totalHargaPokokPenjualans = $debetCreditDetailHargaPokokPenjualan+$beginningBalanceDetailHargaPokokPenjualan;
										$debetDetailHargaPokokPenjualans[] = $debetDetailHargaPokokPenjualan;
										$creditDetailHargaPokokPenjualans[] = $creditDetailHargaPokokPenjualan;
										$beginningDetailHargaPokokPenjualans[] = $beginningBalanceDetailHargaPokokPenjualan;
										$totalDetailHargaPokokPenjualans[] = $subTotalDetailHargaPokokPenjualan;
										$nominalDebetDetailHargaPokokPenjualan = $this->Krs->cur($debetDetailHargaPokokPenjualan);
										$nominalCreditDetailHargaPokokPenjualan = $this->Krs->cur($creditDetailHargaPokokPenjualan);
										$nominalBeginningDetailHargaPokokPenjualan = $this->Krs->cur($beginningBalanceDetailHargaPokokPenjualan);
										$nominalTotalDetailHargaPokokPenjualan = $this->Krs->cur($subTotalDetailHargaPokokPenjualan);

										echo '<tr>
												<td>'.$codeDetailHargaPokokPenjualan.'</td>
												<td>'.$nameDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalDebetDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalCreditDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalBeginningDetailHargaPokokPenjualan.'</td>
												<td align="right">'.$nominalTotalDetailHargaPokokPenjualan.'</td>';
										echo '</tr>';
									}
								}
							}
								
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<table class="table">
						<?php
						
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
    var formAction = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'artama_acc_journals', 'action' => 'trial_balance_report'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalIncomeGlobalReportForm', 'btn-search', confirmTitle, formAction);

	handleDateRange('filterDateId', 'filterDateReset', 'filterDateClass', 'dd-mm-yyyy');
});
</script>