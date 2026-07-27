<?php
// Memanggil action yang aktif
$action = $this->request->getParam('action');

// Memanggil controller yang aktif
$controller = $this->request->getParam('controller');

$menuDashboard = ($controller == 'Dashboard') ? ' class="active"' : '';
//$menuSetting = ($controller=='Users')?'active':'';
// $menuUser = ($controller=='Users' && $action=='index') ? ' class="active"' : '';
$menuUserChangePassword = ($controller == 'Users' && $action == 'changePassword') ? ' class="active"' : '';
//$menuCompany = ($controller=='Settings' && $action=='edit') ? ' class="active"' : '';

// pr($getController);
//pr($checkUrl);
// $branch = $checkUrl['branchs'];
$branch = (isset($checkUrl['branches'])) ? $checkUrl['branches'] : array();
$item = (isset($checkUrl['items'])) ? $checkUrl['items'] : array();
$itemubs = (isset($checkUrl['itemubs'])) ? $checkUrl['itemubs'] : array();
$itemubsupload = (isset($checkUrl['itemubsuploads'])) ? $checkUrl['itemubsuploads'] : array();
$warehouse = (isset($checkUrl['warehouses'])) ? $checkUrl['warehouses'] : array();
$placement = (isset($checkUrl['placements'])) ? $checkUrl['placements'] : array();
$mutation = (isset($checkUrl['mutations'])) ? $checkUrl['mutations'] : array();
$purchaseOfGood = (isset($checkUrl['purchaseofgoods'])) ? $checkUrl['purchaseofgoods'] : array();
$placementOfGood = (isset($checkUrl['placementofgoods'])) ? $checkUrl['placementofgoods'] : array();
$submission = (isset($checkUrl['submissions'])) ? $checkUrl['submissions'] : array();
$order = (isset($checkUrl['orders'])) ? $checkUrl['orders'] : array();
$orderpo = (isset($checkUrl['orderpos'])) ? $checkUrl['orderpos'] : array();
$rencanaPembelian = (isset($checkUrl['rencanapembelians'])) ? $checkUrl['rencanapembelians'] : array();
$orderPembelian = (isset($checkUrl['orderpembelians'])) ? $checkUrl['orderpembelians'] : array();
$returPembelian = (isset($checkUrl['returpembelians'])) ? $checkUrl['returpembelians'] : array();
$supplier = (isset($checkUrl['suppliers'])) ? $checkUrl['suppliers'] : array();
$suppliermou = (isset($checkUrl['suppliermous'])) ? $checkUrl['suppliermous'] : array();
$medicine = (isset($checkUrl['medicines'])) ? $checkUrl['medicines'] : array();
$medicineUbs = (isset($checkUrl['medicineubs'])) ? $checkUrl['medicineubs'] : array();
$medicineUbsUpload = (isset($checkUrl['medicineubsuploads'])) ? $checkUrl['medicineubsuploads'] : array();
$medicineMerk = (isset($checkUrl['medicinemerks'])) ? $checkUrl['medicinemerks'] : array();
$medicineGroup = (isset($checkUrl['medicinegroups'])) ? $checkUrl['medicinegroups'] : array();
$medicineStock = (isset($checkUrl['medicinestocks'])) ? $checkUrl['medicinestocks'] : array();
$kartuStok = (isset($checkUrl['kartustok'])) ? $checkUrl['kartustok'] : array();

$warehouseReceive = (isset($checkUrl['warehousereceives'])) ? $checkUrl['warehousereceives'] : array();
$patient = (isset($checkUrl['patients'])) ? $checkUrl['patients'] : array();
$medicine = (isset($checkUrl['medicines'])) ? $checkUrl['medicines'] : array();
$doctor = (isset($checkUrl['doctors'])) ? $checkUrl['doctors'] : array();
$doctorSchedule = (isset($checkUrl['doctorschedules'])) ? $checkUrl['doctorschedules'] : array();
$healthFacility = (isset($checkUrl['healthfacilities'])) ? $checkUrl['healthfacilities'] : array();
$insurance = (isset($checkUrl['insurances'])) ? $checkUrl['insurances'] : array();
$nutritionCombine = (isset($checkUrl['nutritioncombine'])) ? $checkUrl['nutritioncombine'] : array();
$nutritionMenu = (isset($checkUrl['nutritionmenus'])) ? $checkUrl['nutritionmenus'] : array();
$outpatientBilling = (isset($checkUrl['outpatientbillings'])) ? $checkUrl['outpatientbillings'] : array();
$pharmacyItem = (isset($checkUrl['pharmacyitems'])) ? $checkUrl['pharmacyitems'] : array();
$polyclinic = (isset($checkUrl['polyclinics'])) ? $checkUrl['polyclinics'] : array();
$masterTindakan = (isset($checkUrl['mastertindakan'])) ? $checkUrl['mastertindakan'] : array();
$masterIcd9 = (isset($checkUrl['mastericd9'])) ? $checkUrl['mastericd9'] : array();
$masterIcd10 = (isset($checkUrl['mastericd10'])) ? $checkUrl['mastericd10'] : array();
$masterLaboratories = (isset($checkUrl['masterlaboratories'])) ? $checkUrl['masterlaboratories'] : array();
$masterRadiologies = (isset($checkUrl['masterradiologies'])) ? $checkUrl['masterradiologies'] : array();
$masterPenjamins = (isset($checkUrl['masterpenjamins'])) ? $checkUrl['masterpenjamins'] : array();
$masterPatientReferrers = (isset($checkUrl['masterpatientreferrers'])) ? $checkUrl['masterpatientreferrers'] : array();
$masterTreatmentPackages = (isset($checkUrl['mastertreatmentpackages'])) ? $checkUrl['mastertreatmentpackages'] : array();

$rooms = (isset($checkUrl['rooms'])) ? $checkUrl['rooms'] : array();
$beds = (isset($checkUrl['beds'])) ? $checkUrl['beds'] : array();
$polyclinicQueue = (isset($checkUrl['polyclinicqueues'])) ? $checkUrl['polyclinicqueues'] : array();
$registration = (isset($checkUrl['registrations'])) ? $checkUrl['registrations'] : array();
$patientAdmission = (isset($checkUrl['patientadmissions'])) ? $checkUrl['patientadmissions'] : array();
$outpatientVisit = (isset($checkUrl['outpatientvisits'])) ? $checkUrl['outpatientvisits'] : array();
$outpatientLetter = (isset($checkUrl['outpatientletters'])) ? $checkUrl['outpatientletters'] : array();
$emergencyEntry = (isset($checkUrl['emergencyentries'])) ? $checkUrl['emergencyentries'] : array();
$inpatientEntry = (isset($checkUrl['inpatiententries'])) ? $checkUrl['inpatiententries'] : array();
$medicalRecord = (isset($checkUrl['medicalrecords'])) ? $checkUrl['medicalrecords'] : array();
$service = (isset($checkUrl['services'])) ? $checkUrl['services'] : array();
$laboratoryService = (isset($checkUrl['laboratoryservices'])) ? $checkUrl['laboratoryservices'] : array();
$icd_service = (isset($checkUrl['icd_services'])) ? $checkUrl['icd_services'] : array();

$customer = (isset($checkUrl['customers'])) ? $checkUrl['customers'] : array();
$processor = (isset($checkUrl['processors'])) ? $checkUrl['processors'] : array();
$transporter = (isset($checkUrl['transporters'])) ? $checkUrl['transporters'] : array();
$truck = (isset($checkUrl['trucks'])) ? $checkUrl['trucks'] : array();
$driver = (isset($checkUrl['drivers'])) ? $checkUrl['drivers'] : array();
$waste = (isset($checkUrl['wastes'])) ? $checkUrl['wastes'] : array();
$wasteType = (isset($checkUrl['wastetypes'])) ? $checkUrl['wastetypes'] : array();
$wastePrice = (isset($checkUrl['wasteprices'])) ? $checkUrl['wasteprices'] : array();
$mou = (isset($checkUrl['mous'])) ? $checkUrl['mous'] : array();
$template = (isset($checkUrl['templates'])) ? $checkUrl['templates'] : array();
$manifest = (isset($checkUrl['manifests'])) ? $checkUrl['manifests'] : array();
$manifestProcessor = (isset($checkUrl['manifestprocessors'])) ? $checkUrl['manifestprocessors'] : array();
$manifestInside = (isset($checkUrl['manifestinsides'])) ? $checkUrl['manifestinsides'] : array();

$manifestDirect = (isset($checkUrl['manifestdirects'])) ? $checkUrl['manifestdirects'] : array();
$order = (isset($checkUrl['orders'])) ? $checkUrl['orders'] : array();
$invoice = (isset($checkUrl['invoices'])) ? $checkUrl['invoices'] : array();
$invoiceDeposit = (isset($checkUrl['invoicedeposits'])) ? $checkUrl['invoicedeposits'] : array();
$invoiceCutoff = (isset($checkUrl['invoicecutoffs'])) ? $checkUrl['invoicecutoffs'] : array();
$invoiceOut = (isset($checkUrl['invoiceouts'])) ? $checkUrl['invoiceouts'] : array();
$settings = (isset($checkUrl['settings'])) ? $checkUrl['settings'] : array();
$project = (isset($checkUrl['projects'])) ? $checkUrl['projects'] : array();
$users = (isset($checkUrl['users'])) ? $checkUrl['users'] : array();
$operational = (isset($checkUrl['operationals'])) ? $checkUrl['operationals'] : array();
$permit = (isset($checkUrl['permits'])) ? $checkUrl['permits'] : array();
$truckSchedule = (isset($checkUrl['truckschedules'])) ? $checkUrl['truckschedules'] : array();
$truckInspection = (isset($checkUrl['truckinspections'])) ? $checkUrl['truckinspections'] : array();
$vehicleRequirement = (isset($checkUrl['vehiclerequirements'])) ? $checkUrl['vehiclerequirements'] : array();

$pettyCash = (isset($checkUrl['pettycashes'])) ? $checkUrl['pettycashes'] : array();
$pettyCashTopup = (isset($checkUrl['pettycashtopups'])) ? $checkUrl['pettycashtopups'] : array();
$pettyCashBank = (isset($checkUrl['pettycashbanks'])) ? $checkUrl['pettycashbanks'] : array();
$pettyCashBankTopup = (isset($checkUrl['pettycashbanktopups'])) ? $checkUrl['pettycashbanktopups'] : array();

$unidentifiedIncome = (isset($checkUrl['unidentifiedincomes'])) ? $checkUrl['unidentifiedincomes'] : array();
$orderRegular = (isset($checkUrl['orderregulars'])) ? $checkUrl['orderregulars'] : array();

$invoiceHutang = (isset($checkUrl['invoicehutangs'])) ? $checkUrl['invoicehutangs'] : array();
$accJournal = (isset($checkUrl['accjournals'])) ? $checkUrl['accjournals'] : array();
$accBeginningBalance = (isset($checkUrl['accbeginningbalances'])) ? $checkUrl['accbeginningbalances'] : array();
$accChartOfAccount = (isset($checkUrl['accchartofaccounts'])) ? $checkUrl['accchartofaccounts'] : array();
$accJournalMapping = (isset($checkUrl['accjournalmappings'])) ? $checkUrl['accjournalmappings'] : array();
$recipientPayer = (isset($checkUrl['recipientpayers'])) ? $checkUrl['recipientpayers'] : array();
$depreciations = (isset($checkUrl['depreciations'])) ? $checkUrl['depreciations'] : array();
$permitProcessor = (isset($checkUrl['permitprocessors'])) ? $checkUrl['permitprocessors'] : array();
$invoiceProcessor = (isset($checkUrl['invoiceprocessors'])) ? $checkUrl['invoiceprocessors'] : array();

?>
<div class="sidebar-bg"></div>
<div id="sidebar" class="sidebar">
	<div data-scrollbar="true" data-height="100%">
		<?php

		// <ul class="nav">
		// 	<li class="nav-profile">
		// 		<a href="javascript:;" data-toggle="nav-profile">
		// 			<div class="cover with-shadow"></div>
		// 			<div class="image">
		// 				<img src="../assets/img/user/user-13.jpg" alt="" />
		// 			</div>
		// 			<div class="info">
		// 				<b class="caret pull-right"></b>Sean Ngu
		// 				<small>Front end developer</small>
		// 			</div>
		// 		</a>
		// 	</li>
		// 	<li>
		// 		<ul class="nav nav-profile">
		// 			<li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
		// 			<li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a></li>
		// 			<li><a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a></li>
		// 		</ul>
		// 	</li>
		// </ul>

		?>
		<ul class="nav"><?php //<li class="nav-header">Navigation</li> 
						?>
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
						class="fa fa-angle-double-left"></i></a></li>
			<li<?= $menuDashboard ?>>
				<?= $this->Html->link('<i class="fas fa-home"></i><span>Beranda</span>', ['controller' => 'Dashboard', 'action' => 'index'], ['escape' => false]) ?>
				</li>
				<?php
				//$pettyCash['index']==1 || 
				// $getController=='pettycashes' || 
				// $menuPettyCashIndex = ($getController=='pettycashes' && $getAction=='index')?' class="active"':'';
				if ($accChartOfAccount['index'] == 1 || $accChartOfAccount['group'] == 1 || $accJournal['index'] == 1 || $accJournal['indexShort'] == 1 || $accJournal['generalJournalReport'] == 1 || $accJournal['import'] == 1) {
					$menuAccounting = ($getController == 'accjournals' || $getController == 'accchartofaccounts') ? 'active' : '';


					$menuAcc = ($getController == 'accjournals' || $getController == 'accchartofaccounts') ? 'active' : '';

					$menuAccCoa = ($getController == 'accchartofaccounts' && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit' || $getAction == 'group')) ? 'active' : '';

					$menuAccJournal = ($getController == 'accjournals' && ($getAction == 'index' || $getAction == 'indexShort' || $getAction == 'addMany' || $getAction == 'editMany' || $getAction == 'import')) ? 'active' : '';

					$menuAccReport = ($getController == 'accjournals' && ($getAction == 'generalLedgerReport' || $getAction == 'ekuitasReport' || $getAction == 'generalJournalReport' || $getAction == 'incomeGlobalReport' || $getAction == 'incomeMultiReport' || $getAction == 'trialBalanceReport' || $getAction == 'balanceSheetPercentReport' || $getAction == 'workSheetBalanceReport')) ? 'active' : '';
					$menuReportGeneralLedger = ($getAction == 'generalLedgerReport') ? 'class="active"' : '';
					$menuReportGeneralJournal = ($getAction == 'generalJournalReport') ? 'class="active"' : '';

					$menuAccReportBalanceSheet = ($getController == 'accjournals' && ($getAction == 'trialBalanceReport' || $getAction == 'balanceSheetPercentReport' || $getAction == 'workSheetBalanceReport')) ? 'active' : '';
					$menuTrialBalanceReport = ($getAction == 'trialBalanceReport') ? 'class="active"' : '';
					$menuBalanceSheetReport = ($getAction == 'balanceSheetPercentReport') ? 'class="active"' : '';
					$menuWorkSheetBalanceReport = ($getAction == 'workSheetBalanceReport') ? 'class="active"' : '';

					$menuAccReportLR = ($getController == 'accjournals' && ($getAction == 'incomeGlobalReport' || $getAction == 'incomeMultiReport')) ? 'active' : '';
					$menuIncomeGlobalReport = ($getAction == 'incomeGlobalReport') ? 'class="active"' : '';
					$menuIncomeMultiReport = ($getAction == 'incomeMultiReport') ? 'class="active"' : '';

					$menuReportEkuitas = ($getAction == 'ekuitasReport') ? 'class="active"' : '';


					$menuAccCoaGroup = ($getController == 'accchartofaccounts' && ($getAction == 'group')) ? ' class="active"' : '';
					$menuAccCoaIndex = ($getController == 'accchartofaccounts' && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit')) ? ' class="active"' : '';
					$menuAccCoaBeginningBalanceExportImport = ($getController == 'accchartofaccounts' && ($getAction == 'beginningBalanceExportImport')) ? ' class="active"' : '';

					$menuAccJournalIndex = ($getController == 'accjournals' && ($getAction == 'index' || $getAction == 'addMany')) ? ' class="active"' : '';
					$menuAccJournalIndexShort = ($getController == 'accjournals' && ($getAction == 'indexShort' || $getAction == 'addMany' || $getAction == 'editMany')) ? ' class="active"' : '';
					$menuAccJournalImport = ($getController == 'accjournals' && ($getAction == 'import')) ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuAccounting ?>">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-money-bill-alt"></i>
							<span>ACC</span>
						</a>
						<ul class="sub-menu">
							<li class="has-sub <?= $menuAccJournal ?>">
								<a href="javascript:;">
									<b class="caret"></b>
									<span>Jurnal</span>
								</a>
								<ul class="sub-menu">
									<?php
									if ($accJournal['indexShort'] == 1) {
									?>
										<li <?= $menuAccJournalIndexShort ?>>
											<?= $this->Html->link('Daftar', ['controller' => 'AccJournals', 'action' => 'indexShort'], ['fullBase' => true, 'escape' => false]) ?>
										</li>
									<?php
									}
									if ($accJournal['index'] == 1) {
									?>
										<li <?= $menuAccJournalIndex ?>>
											<?= $this->Html->link('Daftar (Detail)', ['controller' => 'AccJournals', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
										</li>
									<?php
									}
									if ($accJournal['import'] == 1) {
									?>
										<li <?= $menuAccJournalImport ?>>
											<?= $this->Html->link('Import (Melaui Excel)', ['controller' => 'AccJournals', 'action' => 'import'], ['fullBase' => true, 'escape' => false]) ?>
										</li>
									<?php
									}
									?>
								</ul>
							</li>
							<?php
							if ($accChartOfAccount['index'] == 1) {
							?>
								<li <?= $menuAccCoaIndex ?>>
									<?= $this->Html->link('Perkiraan (COA)', ['controller' => 'AccChartOfAccounts', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if ($accChartOfAccount['beginningBalanceExportImport'] == 1) {
							?>
								<li <?= $menuAccCoaBeginningBalanceExportImport ?>>
									<?= $this->Html->link('Saldo Awal', ['controller' => 'AccChartOfAccounts', 'action' => 'beginningBalanceExportImport'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							?>

							<li class="has-sub <?= $menuAccReport ?>">
								<a href="javascript:;">
									<b class="caret"></b>
									<span>Laporan</span>
								</a>
								<ul class="sub-menu">
									<li class="has-sub <?= $menuAccReportBalanceSheet ?>">
										<a href="javascript:;">
											<b class="caret"></b>
											<span>Neraca</span>
										</a>
										<ul class="sub-menu">
											<li <?= $menuTrialBalanceReport ?>>
												<?= $this->Html->link('Neraca Saldo', ['controller' => 'AccJournals', 'action' => 'trial_balance_report'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
											<li <?= $menuBalanceSheetReport ?>>
												<?= $this->Html->link('Neraca %', ['controller' => 'AccJournals', 'action' => 'balance_sheet_percent_report'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
											<li <?= $menuWorkSheetBalanceReport ?>>
												<?= $this->Html->link('Neraca Lajur', ['controller' => 'AccJournals', 'action' => 'work_sheet_balance_report'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										</ul>
									</li>
									<li class="has-sub <?= $menuAccReportLR ?>">
										<a href="javascript:;">
											<b class="caret"></b>
											<span>Laba/Rugi</span>
										</a>
										<ul class="sub-menu">
											<li <?= $menuIncomeGlobalReport ?>>
												<?= $this->Html->link('L/R Global', ['controller' => 'AccJournals', 'action' => 'income_global_report'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
											<li <?= $menuIncomeMultiReport ?>>
												<?= $this->Html->link('L/R Multi', ['controller' => 'AccJournals', 'action' => 'income_multi_report'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										</ul>
									</li>
									<li <?= $menuReportGeneralJournal ?>>
										<?= $this->Html->link('Jurnal Umum', ['controller' => 'AccJournals', 'action' => 'general_journal_report'], ['fullBase' => true, 'escape' => false]) ?>
									</li>
									<li <?= $menuReportGeneralLedger ?>>
										<?= $this->Html->link('Buku Besar', ['controller' => 'AccJournals', 'action' => 'generalLedgerReport'], ['fullBase' => true, 'escape' => false]) ?>
									</li>
									<?php
									// <li <?= $menuReportEkuitas><?= $this->Html->link('Ekuitas', ['controller' => 'AccJournals', 'action' => 'ekuitasReport'], ['fullBase' => true, 'escape' => false])</li>

									?>
								</ul>
							</li>
							<?php
							/* if($pettyCash['index']==1){
							?>
							<li<?= $menuPettyCashIndex ?>><?= $this->Html->link('Petty Cash', ['controller' => 'petty_cashes', 'action' => 'index'], ['fullBase'=>true, 'escape' => false]) ?></li>
							<?php
							} */

							?>
						</ul>
					</li>
				<?php } ?>
				<?php
				if ($purchaseOfGood['index'] == 1 || $placementOfGood['index'] == 1 || $mutation['index'] == 1 || $truckSchedule['index'] == 1 || $warehouseReceive['index'] == 1 || $submission['index'] == 1) {

					$menuDataLink = ($getController == 'purchaseofgoods' || $getController == 'placementofgoods' || $getController == 'mutations' || $getController == 'submissions' || $getController == 'warehousereceives' || $getController == 'truckschedules') ? 'active' : '';

					//Menu Data-Warehouse
					$menuLinkWarehouseReceives = ($getController == 'warehousereceives') ? 'active' : '';
					$menuDataWarehouseReceiveIndex = ($getController == 'warehousereceives' && ($getAction == 'index' || $getAction == 'add' || $getAction == 'addDriver' || $getAction == 'edit')) ? ' class="active"' : '';
					$menuDataTruckSchedule = ($getController == 'truckschedules') ? ' class="active"' : '';
					$menuDataPurchaseOfGood = ($getController == 'purchaseofgoods') ? ' class="active"' : '';
					$menuDataPlacementOfGood = ($getController == 'placementofgoods') ? ' class="active"' : '';
					$menuDataMutation = ($getController == 'mutations') ? ' class="active"' : '';
					$menuDataSubmission = ($getController == 'submissions') ? ' class="active"' : '';
				?>
					<li class="has-sub <?php echo $menuDataLink; ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fas fa-gem"></i>
							<span>Data</span>
						</a>
						<ul class="sub-menu">
							<?php
							if ($purchaseOfGood['index'] == 1) {
							?>
								<li <?= $menuDataPurchaseOfGood ?>>
									<?= $this->Html->link('Pembelian Barang', ['controller' => 'PurchaseOfGoods', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if ($placementOfGood['index'] == 1) {
							?>
								<li <?= $menuDataPlacementOfGood ?>>
									<?= $this->Html->link('Penempatan Barang', ['controller' => 'PlacementOfGoods', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if ($mutation['index'] == 1) {
							?>
								<li <?= $menuDataMutation ?>>
									<?= $this->Html->link('Mutasi', ['controller' => 'Mutations', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if ($submission['index'] == 1) {
							?>
								<li <?= $menuDataSubmission ?>>
									<?= $this->Html->link('Permintaan Dana', ['controller' => 'Submissions', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							/*
							if($truckSchedule['index']==1) {
							?>
								<li <?= $menuDataTruckSchedule ?>><?= $this->Html->link('Jadwal Pengangkutan', ['controller' => 'TruckSchedules', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php 
							}
							if($warehouseReceive['index']==1) {
							?>
							<li class="has-sub <?= $menuLinkWarehouseReceives; ?>">
								<a href="javascript:;">
									<b class="caret"></b>Gudang (Masuk)
								</a>
								<ul class="sub-menu">
									<?php
									if($warehouseReceive['index']==1) {
									?>
									<li <?= $menuDataWarehouseReceiveIndex; ?>><?= $this->Html->link('Penerimaan', ['controller'=>'WarehouseReceives', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
									</li>
									<?php
									}

									?>
								</ul>
							</li>					
							<?php
							}
							*/
							?>
						</ul>
					</li>
				<?php
				}
				if ($order['index'] == 1 || $orderpo['index'] == 1) {

					$menuScmLink = (($getController == 'orders' && !in_array($getAction, ['antrianFarmasi', 'proses'], true)) || $getController == 'orderpos') ? 'active' : '';

					$menuDataOrder = ($getController == 'orders' && !in_array($getAction, ['antrianFarmasi', 'proses'], true)) ? ' class="active"' : '';
					$menuDataOrderPo = ($getController == 'orderpos') ? ' class="active"' : '';
				?>
					<li class="has-sub <?php echo $menuScmLink; ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fas fa-cogs"></i>
							<span>SCM</span>
						</a>
						<ul class="sub-menu">
							<?php
							if ($order['index'] == 1) {
							?>
								<li <?= $menuDataOrder ?>>
									<?= $this->Html->link('Order', ['controller' => 'Orders', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if ($orderpo['index'] == 1) {
							?>
								<li <?= $menuDataOrderPo ?>>
									<?= $this->Html->link('Order (Supplier)', ['controller' => 'OrderPos', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							/*
							if($truckSchedule['index']==1) {
							?>
								<li <?= $menuDataTruckSchedule ?>><?= $this->Html->link('Jadwal Pengangkutan', ['controller' => 'TruckSchedules', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php 
							}
							if($warehouseReceive['index']==1) {
							?>
							<li class="has-sub <?= $menuLinkWarehouseReceives; ?>">
								<a href="javascript:;">
									<b class="caret"></b>Gudang (Masuk)
								</a>
								<ul class="sub-menu">
									<?php
									if($warehouseReceive['index']==1) {
									?>
									<li <?= $menuDataWarehouseReceiveIndex; ?>><?= $this->Html->link('Penerimaan', ['controller'=>'WarehouseReceives', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
									</li>
									<?php
									}

									?>
								</ul>
							</li>					
							<?php
							}
							*/
							?>
						</ul>
					</li>
				<?php
				}
				if (
					!empty($order['antrianFarmasi']) ||
					!empty($order['proses']) ||
					!empty($rencanaPembelian['index']) ||
					!empty($orderPembelian['index']) ||
					!empty($returPembelian['index']) ||
					!empty($invoice['index']) ||
					!empty($medicineStock['index']) ||
					!empty($kartuStok['index'])
				) {

					$menuFarmasi = (
						($getController == 'orders' && in_array($getAction, ['antrianFarmasi', 'proses'], true))
						|| in_array($getController, [
							'rencanapembelians',
							'orderpembelians',
							'returpembelians',
							'invoices',
							'medicinestocks',
							'kartustok',
						], true)
					) ? 'active' : '';

					$menuAntrianFarmasi = ($getController == 'orders' && $getAction == 'antrianFarmasi') ? ' class="active"' : '';
					$menuProsesFarmasi = ($getController == 'orders' && $getAction == 'proses') ? ' class="active"' : '';
					$menuRencanaPembelian = ($getController == 'rencanapembelians') ? ' class="active"' : '';
					$menuOrderPembelian = ($getController == 'orderpembelians') ? ' class="active"' : '';
					$menuReturPembelian = ($getController == 'returpembelians') ? ' class="active"' : '';
					$menuInvoiceFarmasi = ($getController == 'invoices') ? ' class="active"' : '';
					$menuMedicineStock = ($getController == 'medicinestocks') ? ' class="active"' : '';
					$menuKartuStok = ($getController == 'kartustok') ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuFarmasi ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-prescription-bottle-alt"></i>
							<span>Farmasi</span>
						</a>

						<ul class="sub-menu">
							<?php if (!empty($order['antrianFarmasi'])) { ?>
								<li <?= $menuAntrianFarmasi ?>>
									<?= $this->Html->link('Antrian Farmasi', ['controller' => 'Orders', 'action' => 'antrianFarmasi'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($order['proses'])) { ?>
								<li <?= $menuProsesFarmasi ?>>
									<?= $this->Html->link('Proses Resep Luar', ['controller' => 'Orders', 'action' => 'proses'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($rencanaPembelian['index'])) { ?>
								<li <?= $menuRencanaPembelian ?>>
									<?= $this->Html->link('Rencana Pembelian', ['controller' => 'RencanaPembelians', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($orderPembelian['index'])) { ?>
								<li <?= $menuOrderPembelian ?>>
									<?= $this->Html->link('Order Pembelian', ['controller' => 'OrderPembelians', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($invoice['index'])) { ?>
								<li <?= $menuInvoiceFarmasi ?>>
									<?= $this->Html->link('BAPB / Invoice', ['controller' => 'Invoices', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($returPembelian['index'])) { ?>
								<li <?= $menuReturPembelian ?>>
									<?= $this->Html->link('Retur Pembelian', ['controller' => 'ReturPembelians', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($medicineStock['index'])) { ?>
								<li <?= $menuMedicineStock ?>>
									<?= $this->Html->link('Informasi Stok', ['controller' => 'MedicineStocks', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($kartuStok['index'])) { ?>
								<li <?= $menuKartuStok ?>>
									<?= $this->Html->link('Kartu Stok', ['controller' => 'KartuStok', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php
				}
				if (!empty($polyclinicQueue['index']) || !empty($registration['index']) || !empty($patientAdmission['index'])) {

					$menuPolyclinicQueue = ($getController == 'polyclinicqueues' || $getController == 'registrations' || $getController == 'patientadmissions') ? 'active' : '';
					$menuPolyclinicQueueIndex = ($getController == 'polyclinicqueues') ? ' class="active"' : '';
					$menuRegistrationIndex = ($getController == 'registrations') ? ' class="active"' : '';
					$menuPatientAdmissionIndex = ($getController == 'patientadmissions') ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuPolyclinicQueue ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-user-plus"></i>
							<span>Pendaftaran Pasien</span>
						</a>

						<ul class="sub-menu">

							<li <?= $menuPolyclinicQueueIndex ?>>
								<?= $this->Html->link(
									'Antrian Pasien',
									[
										'controller' => 'PolyclinicQueues',
										'action' => 'index'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>

							<li>
								<?= $this->Html->link(
									'Kiosk',
									[
										'controller' => 'PolyclinicQueues',
										'action' => 'kiosk'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>

							<li <?= $menuRegistrationIndex ?>>
								<?= $this->Html->link(
									'Registration',
									[
										'controller' => 'Registrations',
										'action' => 'index'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>

							<?php
							if (!empty($patientAdmission['index'])) {
							?>
								<li <?= $menuPatientAdmissionIndex ?>>
									<?= $this->Html->link(
										'Pendaftaran Pasien',
										[
											'controller' => 'PatientAdmissions',
											'action' => 'index'
										],
										[
											'fullBase' => true,
											'escape' => false
										]
									) ?>
								</li>
							<?php
							}
							?>

						</ul>
					</li>
				<?php
				}

				if (!empty($outpatientVisit['index']) || !empty($outpatientBilling['index']) || !empty($medicalRecord['index']) || !empty($outpatientLetter['index'])) {

					$menuOutpatientVisit = ($getController == 'outpatientvisits' || $getController == 'outpatientbillings' || $getController == 'medicalrecords' || $getController == 'outpatientletters') ? 'active' : '';
					$menuOutpatientVisitIndex = ($getController == 'outpatientvisits') ? ' class="active"' : '';
					$menuOutpatientBillingIndex = ($getController == 'outpatientbillings') ? ' class="active"' : '';
					$menuMedicalRecordIndex = ($getController == 'medicalrecords') ? ' class="active"' : '';
					$menuOutpatientLetterIndex = ($getController == 'outpatientletters') ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuOutpatientVisit ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-stethoscope"></i>
							<span>Rawat Jalan</span>
						</a>

						<ul class="sub-menu">
							<li <?= $menuOutpatientVisitIndex ?>>
								<?= $this->Html->link(
									'Kunjungan Rawat Jalan',
									[
										'controller' => 'OutpatientVisits',
										'action' => 'index'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>

							<?php
							if (!empty($outpatientBilling['index'])) {
							?>
								<li <?= $menuOutpatientBillingIndex ?>>
									<?= $this->Html->link(
										'Kasir Rawat Jalan',
										[
											'controller' => 'OutpatientBillings',
											'action' => 'index'
										],
										[
											'fullBase' => true,
											'escape' => false
										]
									) ?>
								</li>
							<?php
							}

							if (!empty($medicalRecord['index'])) {
							?>
								<li <?= $menuMedicalRecordIndex ?>>
									<?= $this->Html->link(
										'Rekam Medis',
										[
											'controller' => 'MedicalRecords',
											'action' => 'index'
										],
										[
											'fullBase' => true,
											'escape' => false
										]
									) ?>
								</li>
							<?php
							}

							if (!empty($outpatientLetter['index'])) {
							?>
								<li <?= $menuOutpatientLetterIndex ?>>
									<?= $this->Html->link(
										'Surat Rawat Jalan',
										[
											'controller' => 'OutpatientLetters',
											'action' => 'index'
										],
										[
											'fullBase' => true,
											'escape' => false
										]
									) ?>
								</li>
							<?php
							}
							?>
						</ul>
					</li>
				<?php
				}

				if (!empty($emergencyEntry['index'])) {

					$menuEmergencyEntry = ($getController == 'emergencyentries') ? 'active' : '';
					$menuEmergencyEntryIndex = ($getController == 'emergencyentries') ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuEmergencyEntry ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-ambulance"></i>
							<span>Rawat IGD</span>
						</a>

						<ul class="sub-menu">
							<li <?= $menuEmergencyEntryIndex ?>>
								<?= $this->Html->link(
									'Instansi Rawat IGD',
									[
										'controller' => 'EmergencyEntries',
										'action' => 'index'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>
						</ul>
					</li>
				<?php
				}

				if (!empty($inpatientEntry['index'])) {

					$menuInpatientEntry = ($getController == 'inpatiententries') ? 'active' : '';
					$menuInpatientEntryIndex = ($getController == 'inpatiententries') ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuInpatientEntry ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-bed"></i>
							<span>Rawat Inap</span>
						</a>

						<ul class="sub-menu">
							<li <?= $menuInpatientEntryIndex ?>>
								<?= $this->Html->link(
									'Pasien Rawat Inap',
									[
										'controller' => 'InpatientEntries',
										'action' => 'index'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>
						</ul>
					</li>
				<?php
				}

				if (
					$medicine['index'] == 1 ||
					$medicineMerk['index'] == 1 ||
					$medicineGroup['index'] == 1 ||
					$patient['index'] == 1 ||
					$doctor['index'] == 1 ||
					$doctorSchedule['index'] == 1 ||
					$healthFacility['index'] == 1 ||
					$insurance['index'] == 1 ||
					$nutritionCombine['index'] == 1 ||
					$nutritionMenu['index'] == 1 ||
					$outpatientBilling['index'] == 1 ||
					$pharmacyItem['index'] == 1 ||
					$polyclinic['index'] == 1 ||
					!empty($masterTindakan['index']) ||
					!empty($masterIcd9['index']) ||
					!empty($masterIcd10['index']) ||
					!empty($masterRadiologies['index']) ||
					!empty($masterLaboratories['index']) ||
					!empty($masterPenjamins['index']) ||
					!empty($masterPatientReferrers['index']) ||
					!empty($masterTreatmentPackages['index']) ||
					$rooms['index'] == 1 ||
					$beds['index'] == 1
				) {

					$menuDataLink = (
						$getController == 'medicines' ||
						$getController == 'medicinemerks' ||
						$getController == 'medicinegroups' ||
						$getController == 'patients' ||
						$getController == 'mastertindakan' ||
						$getController == 'mastericd9' ||
						$getController == 'mastericd10' ||
						$getController == 'masterradiologies' ||
						$getController == 'masterlaboratories' ||
						$getController == 'masterpenjamins' ||
						$getController == 'masterpatientreferrers' ||
						$getController == 'mastertreatmentpackages' ||
						$getController == 'outpatientbillings' ||
						$getController == 'beds' ||
						$getController == 'rooms'
					) ? 'active' : '';

					$menuMedicine = (
						$getController == 'medicines' ||
						$getController == 'medicinemerks' ||
						$getController == 'medicinegroups'
					) ? 'active' : '';

					$menuMasterMedicine = ($getController == 'medicines') ? ' class="active"' : '';
					$menuMasterMedicineMerk = ($getController == 'medicinemerks') ? ' class="active"' : '';
					$menuMasterMedicineGroup = ($getController == 'medicinegroups') ? ' class="active"' : '';
					$menuMasterRadiologies = ($getController == 'masterradiologies') ? ' class="active"' : '';
					$menuMasterLaboratories = ($getController == 'masterlaboratories') ? ' class="active"' : '';
					$menuMasterPenjamins = ($getController == 'masterpenjamins') ? ' class="active"' : '';
					$menuMasterPatientReferrers = ($getController == 'masterpatientreferrers') ? ' class="active"' : '';
					$menuMasterTreatmentPackages = ($getController == 'mastertreatmentpackages') ? ' class="active"' : '';
					$menuOutpatientBilling = ($getController == 'outpatientbillings') ? ' class="active"' : '';
					$menuPatientIndex = ($getController == 'patients') ? ' class="active"' : '';
					$menuDoctorIndex = ($getController == 'doctors') ? ' class="active"' : '';
					$menuDoctorScheduleIndex = ($getController == 'doctorschedules') ? ' class="active"' : '';
					$menuHealthFacilityIndex = ($getController == 'healthfacilities') ? ' class="active"' : '';
					$menuInsuranceIndex = ($getController == 'insurance') ? ' class="active"' : '';
					$menuNutritionCombineIndex = ($getController == 'nutritioncombines') ? ' class="active"' : '';
					$menuNutritionMenuIndex = ($getController == 'nutritionmenus') ? ' class="active"' : '';
					$menuPharmacyItemIndex = ($getController == 'pharmacyitems') ? ' class="active"' : '';
					$menuPolyclinicIndex = ($getController == 'polyclinics') ? ' class="active"' : '';
					$menuMasterTindakanIndex = ($getController == 'mastertindakan') ? ' class="active"' : '';
					$menuMasterIcd9Index = ($getController == 'mastericd9') ? ' class="active"' : '';
					$menuMasterIcd10Index = ($getController == 'mastericd10') ? ' class="active"' : '';
					$menuMasterRadiologiesIndex = ($getController == 'masterradiologies') ? ' class="active"' : '';
					$menuMasterLaboratoriesIndex = ($getController == 'masterlaboratories') ? ' class="active"' : '';
					$menuMasterPenjaminsIndex = ($getController == 'masterpenjamins') ? ' class="active"' : '';
					$menuMasterPatientReferrersIndex = ($getController == 'masterpatientreferrers') ? ' class="active"' : '';
					$menuMasterTreatmentPackagesIndex = ($getController == 'mastertreatmentpackages') ? ' class="active"' : '';
					$menuRoomIndex = ($getController == 'rooms') ? ' class="active"' : '';
					$menuBedIndex = ($getController == 'beds') ? ' class="active"' : '';

				?>
					<li class="has-sub <?php echo $menuDataLink; ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fas fa-database"></i>
							<span>Master</span>
						</a>

						<ul class="sub-menu">

							<?php
							if (
								$medicine['index'] == 1 ||
								$medicineMerk['index'] == 1 ||
								$medicineGroup['index'] == 1
							) {
							?>
								<li class="has-sub <?= $menuMedicine ?>">
									<a href="javascript:;">
										<b class="caret"></b>
										<span>Obat</span>
									</a>

									<ul class="sub-menu">
										<?php
										if ($medicine['index'] == 1) {
										?>
											<li <?= $menuMasterMedicine ?>>
												<?= $this->Html->link('Daftar', ['controller' => 'Medicines', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										<?php
										}

										if ($medicineMerk['index'] == 1) {
										?>
											<li <?= $menuMasterMedicineMerk ?>>
												<?= $this->Html->link('Merk', ['controller' => 'MedicineMerks', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										<?php
										}

										if ($medicineGroup['index'] == 1) {
										?>
											<li <?= $menuMasterMedicineGroup ?>>
												<?= $this->Html->link('Group', ['controller' => 'MedicineGroups', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										<?php
										}
										?>
									</ul>
								</li>
							<?php
							}

							if ($patient['index'] == 1) {
							?>
								<li <?= $menuPatientIndex ?>>
									<?= $this->Html->link('Patients', ['controller' => 'Patients', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($doctor['index'] == 1) {
							?>
								<li <?= $menuDoctorIndex ?>>
									<?= $this->Html->link('Doctor', ['controller' => 'Doctors', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($doctorSchedule['index'] == 1) {
							?>
								<li <?= $menuDoctorScheduleIndex ?>>
									<?= $this->Html->link('Doctor Schedules', ['controller' => 'DoctorSchedules', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($healthFacility['index'] == 1) {
							?>
								<li <?= $menuHealthFacilityIndex ?>>
									<?= $this->Html->link('Health Facilities', ['controller' => 'HealthFacilities', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($insurance['index'] == 1) {
							?>
								<li <?= $menuInsuranceIndex ?>>
									<?= $this->Html->link('Insurances', ['controller' => 'Insurances', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($nutritionCombine['index'] == 1) {
							?>
								<li <?= $menuNutritionCombineIndex ?>>
									<?= $this->Html->link('Nutrition Combine', ['controller' => 'NutritionCombine', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($nutritionMenu['index'] == 1) {
							?>
								<li <?= $menuNutritionMenuIndex ?>>
									<?= $this->Html->link('Nutrition Menus', ['controller' => 'NutritionMenus', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($outpatientBilling['index'] == 1) {
							?>
								<li <?= $menuOutpatientBilling ?>>
									<?= $this->Html->link('Outpatient Billing', ['controller' => 'OutpatientBillings', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($pharmacyItem['index'] == 1) {
							?>
								<li <?= $menuPharmacyItemIndex ?>>
									<?= $this->Html->link('Pharmacy Items', ['controller' => 'PharmacyItems', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if (!empty($masterTindakan['index'])) {
							?>
								<li <?= $menuMasterTindakanIndex ?>>
									<?= $this->Html->link('Master Tindakan', ['controller' => 'MasterTindakan', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if (!empty($masterIcd9['index'])) {
							?>
								<li <?= $menuMasterIcd9Index ?>>
									<?= $this->Html->link('Master ICD-9 CM', ['controller' => 'MasterIcd9', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if (!empty($masterIcd10['index'])) {
							?>
								<li <?= $menuMasterIcd10Index ?>>
									<?= $this->Html->link('Master ICD-10', ['controller' => 'MasterIcd10', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if (!empty($masterRadiologies['index'])) {
							?>
								<li <?= $menuMasterRadiologiesIndex ?>>
									<?= $this->Html->link('Radiologi', ['controller' => 'MasterRadiologies', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if (!empty($masterLaboratories['index'])) {
							?>
								<li <?= $menuMasterLaboratoriesIndex ?>>
									<?= $this->Html->link('Laboratory', ['controller' => 'MasterLaboratories', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if (!empty($masterPenjamins['index'])) {
							?>
								<li <?= $menuMasterPenjaminsIndex ?>>
									<?= $this->Html->link('Jenis Asuransi', ['controller' => 'MasterPenjamins', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if (!empty($masterPatientReferrers['index'])) {
							?>
								<li <?= $menuMasterPatientReferrersIndex ?>>
									<?= $this->Html->link('Master Patient Referrers', ['controller' => 'MasterPatientReferrers', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							if (!empty($masterTreatmentPackages['index'])) {
							?>
								<li <?= $menuMasterTreatmentPackagesIndex ?>>
									<?= $this->Html->link('Master Treatment Packages', ['controller' => 'MasterTreatmentPackages', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}
							
							

							if ($polyclinic['index'] == 1) {
							?>
								<li <?= $menuPolyclinicIndex ?>>
									<?= $this->Html->link('Polyclinics', ['controller' => 'Polyclinics', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($rooms['index'] == 1) {
							?>
								<li <?= $menuRoomIndex ?>>
									<?= $this->Html->link('Rooms', ['controller' => 'Rooms', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							if ($beds['index'] == 1) {
							?>
								<li <?= $menuBedIndex ?>>
									<?= $this->Html->link('Bed Management', ['controller' => 'Beds', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
							}

							?>

						</ul>
					</li>
				<?php
				}

				if ($users['changePassword'] == 1 || $users['resetPassword'] == 1 || $users['access'] == 1 || $users['index'] == 1 || $settings['index'] == 1 || $branch['index'] == 1) {

					$menuSetting = ($getController == 'users' || $getController == 'settings' || $getController == 'branches') ? 'active' : '';

					$menuUser = ($getController == 'users' && ($getAction == 'index' || $getAction == 'add' || $getAction == 'edit' || $getAction == 'resetPassword' || $getAction == 'access')) ? ' class="active"' : '';
					$menuChangePassword = ($getController == 'users' && $getAction == 'changePassword') ? ' class="active"' : '';
					$menuBranches = ($getController == 'branches' && $getAction == 'index') ? 'class="active"' : '';
					$menuSettings = ($getController == 'settings' && $getAction == 'index') ? ' class="active"' : '';
				?>

					<li class="has-sub <?= $menuSetting ?>">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-cog"></i>
							<span>Pengaturan</span>
						</a>
						<ul class="sub-menu">
							<li<?= $menuChangePassword ?>>
								<?= $this->Html->link('Ganti Password', ['controller' => 'Users', 'action' => 'changepassword', $getUser->id], ['fullBase' => true, 'escape' => false]) ?>
					</li>
					<?php
					if ($users['index'] == 1) {
					?>
						<li<?= $menuUser ?>>
							<?= $this->Html->link('User', ['controller' => 'Users', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
							</li>
						<?php
					}
					if ($branch['index'] == 1) {
						?>
							<li<?= $menuBranches ?>>
								<?= $this->Html->link('Cabang', ['controller' => 'Branches', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php
						}
						if ($settings['index'] == 1) {
							?>
								<li<?= $menuSettings ?>>
									<?= $this->Html->link('Perusahaan', ['controller' => 'Settings', 'action' => 'edit/1'], ['fullBase' => true, 'escape' => false]) ?>
									</li>
								<?php } ?>
		</ul>
		</li>
	<?php } ?>
	<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
				class="fa fa-angle-double-left"></i></a></li>
	</ul>
	</div>
</div>
