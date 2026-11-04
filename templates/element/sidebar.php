<?php
$medicineMerk = (isset($checkUrl['medicinemerks'])) ? $checkUrl['medicinemerks'] : array();
$medicineGroup = (isset($checkUrl['medicinegroups'])) ? $checkUrl['medicinegroups'] : array();
?>

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
$kartuStok = (isset($checkUrl['kartustok'])) ? $checkUrl['kartustok'] : array();

// ----------------------------------ACC----------------------------//
$accJournal = (isset($checkUrl['accjournals'])) ? $checkUrl['accjournals'] : array();
$accBeginningBalance = (isset($checkUrl['accbeginningbalances'])) ? $checkUrl['accbeginningbalances'] : array();
$accChartOfAccount = (isset($checkUrl['accchartofaccounts'])) ? $checkUrl['accchartofaccounts'] : array();
$recipientPayer = (isset($checkUrl['recipientpayers'])) ? $checkUrl['recipientpayers'] : array();
$banktopups = (isset($checkUrl['banktopups'])) ? $checkUrl['banktopups'] : array();
$reportsubmissions = (isset($checkUrl['reportsubmissions'])) ? $checkUrl['reportsubmissions'] : array();
$bankincomes = (isset($checkUrl['bankincomes'])) ? $checkUrl['bankincomes'] : array();

// $warehouseReceive = (isset($checkUrl['warehousereceives'])) ? $checkUrl['warehousereceives'] : array();
$patient = (isset($checkUrl['patients'])) ? $checkUrl['patients'] : array();
$medicine = (isset($checkUrl['medicines'])) ? $checkUrl['medicines'] : array();
$order = (isset($checkUrl['orders'])) ? $checkUrl['orders'] : array();
$rencanaPembelian = (isset($checkUrl['rencanapembelians'])) ? $checkUrl['rencanapembelians'] : array();
$orderPembelian = (isset($checkUrl['orderpembelians'])) ? $checkUrl['orderpembelians'] : array();
$returPembelian = (isset($checkUrl['returpembelians'])) ? $checkUrl['returpembelians'] : array();
$invoice = (isset($checkUrl['invoices'])) ? $checkUrl['invoices'] : array();
$medicineStock = (isset($checkUrl['medicinestocks'])) ? $checkUrl['medicinestocks'] : array();
$doctor = (isset($checkUrl['doctors'])) ? $checkUrl['doctors'] : array();
$doctorSchedule = (isset($checkUrl['doctorschedules'])) ? $checkUrl['doctorschedules'] : array();
$healthFacility = (isset($checkUrl['healthfacilities'])) ? $checkUrl['healthfacilities'] : array();
$insurance = (isset($checkUrl['insurances'])) ? $checkUrl['insurances'] : array();
$nutritionCombine = (isset($checkUrl['nutritioncombine'])) ? $checkUrl['nutritioncombine'] : array();
$nutritionMenu = (isset($checkUrl['nutritionmenus'])) ? $checkUrl['nutritionmenus'] : array();
$outpatientBilling = (isset($checkUrl['outpatientbillings'])) ? $checkUrl['outpatientbillings'] : array();
$paymentHistory = (isset($checkUrl['paymenthistories'])) ? $checkUrl['paymenthistories'] : array();
$pharmacyItem = (isset($checkUrl['pharmacyitems'])) ? $checkUrl['pharmacyitems'] : array();
$polyclinic = (isset($checkUrl['polyclinics'])) ? $checkUrl['polyclinics'] : array();
$masterTindakan = (isset($checkUrl['mastertindakan'])) ? $checkUrl['mastertindakan'] : array();
$masterTenagaMedis = (isset($checkUrl['mastertenagamedis'])) ? $checkUrl['mastertenagamedis'] : array();
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
$praregistrations = (isset($checkUrl['praregistrations'])) ? $checkUrl['praregistrations'] : array();
$patientAdmission = (isset($checkUrl['patientadmissions'])) ? $checkUrl['patientadmissions'] : array();
$outpatientVisit = (isset($checkUrl['outpatientvisits'])) ? $checkUrl['outpatientvisits'] : array();
$outpatientLetter = (isset($checkUrl['outpatientletters'])) ? $checkUrl['outpatientletters'] : array();
$labExamination = (isset($checkUrl['labexaminations'])) ? $checkUrl['labexaminations'] : array();
$emergencyEntry = (isset($checkUrl['emergencyentries'])) ? $checkUrl['emergencyentries'] : array();
$inpatientEntry = (isset($checkUrl['inpatiententries'])) ? $checkUrl['inpatiententries'] : array();
$medicalRecord = (isset($checkUrl['medicalrecords'])) ? $checkUrl['medicalrecords'] : array();
$service = (isset($checkUrl['services'])) ? $checkUrl['services'] : array();
$laboratoryService = (isset($checkUrl['laboratoryservices'])) ? $checkUrl['laboratoryservices'] : array();
$icd_service = (isset($checkUrl['icd_services'])) ? $checkUrl['icd_services'] : array();

$bankaccounts = (isset($checkUrl['bankaccounts'])) ? $checkUrl['bankaccounts'] : array();

$settings = (isset($checkUrl['settings'])) ? $checkUrl['settings'] : array();
$users = (isset($checkUrl['users'])) ? $checkUrl['users'] : array();

//-------------------- HR --------------------//
$absences =  (isset($checkUrl['absences'])) ? $checkUrl['absences'] : array();
$hrgaemployees = (isset($checkUrl['hrgaemployees'])) ? $checkUrl['hrgaemployees'] : array();
$leaves = (isset($checkUrl['leaves'])) ? $checkUrl['leaves'] : array();
$licenseabsents =  (isset($checkUrl['licenseabsents'])) ? $checkUrl['licenseabsents'] : array();
$licenseearlyleaves =  (isset($checkUrl['licenseearlyleaves'])) ? $checkUrl['licenseearlyleaves'] : array();
$overtimes =  (isset($checkUrl['overtimes'])) ? $checkUrl['overtimes'] : array();
$workorders = (isset($checkUrl['workorders'])) ? $checkUrl['workorders'] : array();
$hrgaattendances = (isset($checkUrl['hrgaattendances'])) ? $checkUrl['hrgaattendances'] : array();
$hrgaholidays = (isset($checkUrl['hrgaholidays'])) ? $checkUrl['hrgaholidays'] : array();
$salaries =  (isset($checkUrl['salaries'])) ? $checkUrl['salaries'] : array();
$permissionlates =  (isset($checkUrl['permissionlates'])) ? $checkUrl['permissionlates'] : array();
$assignments = (isset($checkUrl['assignments'])) ? $checkUrl['assignments'] : array();
$outpermits = (isset($checkUrl['outpermits'])) ? $checkUrl['outpermits'] : array();
$absentissues = (isset($checkUrl['absentissues'])) ? $checkUrl['absentissues'] : array();
$payrolls = (isset($checkUrl['payrolls'])) ? $checkUrl['payrolls'] : array();
$reportattendances = (isset($checkUrl['reportattendances'])) ? $checkUrl['reportattendances'] : array();

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
				<?= $this->Html->link('<i class="fas fa-home"></i><span>Beranda</span>', ['prefix' => false,'controller' => 'Dashboard', 'action' => 'index'], ['escape' => false]) ?>
				</li>
				<?php
				//$pettyCash['index']==1 || 
				// $getController=='pettycashes' || 
				// $menuPettyCashIndex = ($getController=='pettycashes' && $getAction=='index')?' class="active"':'';
				if($accChartOfAccount['index'] == 1 || $accChartOfAccount['group'] == 1 || $accJournal['index'] == 1  || $accJournal['indexShort'] == 1 || $accJournal['generalJournalReport']==1 || $accJournal['import']==1 || $bankincomes['index'] == 1 || $banktopups['index'] == 1){
					$menuAccounting = ($getController=='accjournals' || $getController=='accchartofaccounts' || $getController == 'bankincomes' || $getController == 'reportsubmissions' || $getController == 'banktopups')?'active':'';
					

					$menuAcc = ($getController == 'accjournals' || $getController == 'accchartofaccounts') ? 'active' : '';

					$menuAccCoa = ($getController == 'accchartofaccounts' && ($getAction=='index' || $getAction=='add' || $getAction=='edit' || $getAction=='group')) ? 'active' : '';
					
					$menuAccJournal = ($getController == 'accjournals' && ($getAction=='index' || $getAction=='indexShort' || $getAction=='addMany' || $getAction=='editMany' || $getAction=='import')) ? 'active' : '';

					$menuAccReport = ($getController == 'accjournals' && ($getAction=='generalLedgerReport' || $getAction=='ekuitasReport' || $getAction=='generalJournalReport' || $getAction == 'incomeGlobalReport' || $getAction == 'incomeMultiReport' || $getAction == 'trialBalanceReport' || $getAction == 'balanceSheetPercentReport' || $getAction == 'workSheetBalanceReport')) ? 'active' : '';
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

					$menuAccCoa = ($getController == 'accchartofaccounts' && ($getAction=='index' || $getAction=='beginningBalanceExportImport' || $getAction=='importExcel') || $getController == 'banktopups') ? 'active' : '';
					$menuAccCoaGroup = ($getController == 'accchartofaccounts' && ($getAction=='group')) ? ' class="active"' : '';
					$menuAccCoaIndex = ($getController == 'accchartofaccounts' && ($getAction=='index' || $getAction=='add' || $getAction=='edit')) ? ' class="active"' : '';
					$menuAccCoaBeginningBalanceExportImport = ($getController == 'accchartofaccounts' && ($getAction=='beginningBalanceExportImport')) ? ' class="active"' : '';
					$menuAccCoaImportExcel = ($getController == 'accchartofaccounts' && ($getAction=='importExcel')) ? ' class="active"' : '';
					$menuBankTopup = ($getController == 'banktopups') ? 'class="active"' : '';

					$menuAccJournalIndex= ($getController == 'accjournals' && ($getAction=='index' || $getAction=='addMany')) ? ' class="active"' : '';
					$menuAccJournalIndexShort= ($getController == 'accjournals' && ($getAction=='indexShort' || $getAction=='addMany' || $getAction=='editMany')) ? ' class="active"' : '';
					$menuAccJournalImport= ($getController == 'accjournals' && ($getAction=='import')) ? ' class="active"' : '';
					$menuReportSubmissions = ($getController == 'reportsubmissions') ? 'class="active"' : '';
					$menuBankIncomes = ($getController == 'bankincomes') ? 'class="active"' : '';
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
								<li <?= $menuAccJournalIndexShort ?>><?= $this->Html->link('Daftar', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'indexShort'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($accJournal['index'] == 1) {
								?>
								<li <?= $menuAccJournalIndex ?>><?= $this->Html->link('Daftar (Detail)', ['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($accJournal['import'] == 1) {
								?>
								<li <?= $menuAccJournalImport ?>><?= $this->Html->link('Import (Melaui Excel)', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'import'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								?>
							</ul>
						</li>
						<li class="has-sub <?= $menuAccCoa ?>">
							<a href="javascript:;">
								<b class="caret"></b>
								<span>Perkiraan (COA)</span>
							</a>
							<ul class="sub-menu">
								<?php if ($accChartOfAccount['index'] == 1) {
								?>
								<li <?= $menuAccCoaIndex ?>><?= $this->Html->link('Perkiraan (COA)', ['prefix' => 'Acc','controller' => 'AccChartOfAccounts', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($accChartOfAccount['beginningBalanceExportImport'] == 1) {
								?>
								<li <?= $menuAccCoaBeginningBalanceExportImport ?>><?= $this->Html->link('Saldo Awal', ['prefix' => 'Acc','controller' => 'AccChartOfAccounts', 'action' => 'beginningBalanceExportImport'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($accChartOfAccount['importExcel'] == 1) {
								?>
								<li <?= $menuAccCoaImportExcel ?>><?= $this->Html->link('Import Excel', ['prefix' => 'Acc','controller' => 'AccChartOfAccounts', 'action' => 'importExcel'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($banktopups['index'] == 1) {
								?>
								<li <?= $menuBankTopup ?>><?= $this->Html->link('Pindah Buku', ['prefix' => 'Acc','controller' => 'BankTopups', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								?>
							</ul>
						</li>
						<!-- <?php
						if ($accChartOfAccount['index'] == 1) {
						?>
						<li <?= $menuAccCoaIndex ?>><?= $this->Html->link('Perkiraan (COA)', ['prefix' => 'Acc','controller' => 'AccChartOfAccounts', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if ($accChartOfAccount['beginningBalanceExportImport'] == 1) {
						?>
						<li <?= $menuAccCoaBeginningBalanceExportImport ?>><?= $this->Html->link('Saldo Awal', ['prefix' => 'Acc','controller' => 'AccChartOfAccounts', 'action' => 'beginningBalanceExportImport'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						?>
						-->
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
										<li <?= $menuTrialBalanceReport ?>><?= $this->Html->link('Neraca Saldo', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'trial_balance_report'], ['fullBase' => true, 'escape' => false]) ?></li>
										<li <?= $menuBalanceSheetReport ?>><?= $this->Html->link('Neraca %', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'balance_sheet_percent_report'], ['fullBase' => true, 'escape' => false]) ?></li>
										<li <?= $menuWorkSheetBalanceReport ?>><?= $this->Html->link('Neraca Lajur', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'work_sheet_balance_report'], ['fullBase' => true, 'escape' => false]) ?></li>
									</ul>
								</li>
								<li class="has-sub <?= $menuAccReportLR ?>">
									<a href="javascript:;">
										<b class="caret"></b>
										<span>Laba/Rugi</span>
									</a>
									<ul class="sub-menu">
										<li <?= $menuIncomeGlobalReport ?>><?= $this->Html->link('L/R Global', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'income_global_report'], ['fullBase' => true, 'escape' => false]) ?></li>
										<li <?= $menuIncomeMultiReport ?>><?= $this->Html->link('L/R Multi', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'income_multi_report'], ['fullBase' => true, 'escape' => false]) ?></li>
									</ul>
								</li>
								<li <?= $menuReportGeneralJournal ?>><?= $this->Html->link('Jurnal Umum', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'general_journal_report'], ['fullBase' => true, 'escape' => false]) ?></li>
								<li <?= $menuReportGeneralLedger ?>><?= $this->Html->link('Buku Besar', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'generalLedgerReport'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								// <li <?= $menuReportEkuitas><?= $this->Html->link('Ekuitas', ['prefix' => 'Acc','controller' => 'AccJournals', 'action' => 'ekuitasReport'], ['fullBase' => true, 'escape' => false])</li>
								
								?>
							</ul>
						</li>
						<?php
						if ($bankincomes['index'] == 1) {
						?>
						<li <?= $menuBankIncomes ?>><?= $this->Html->link('Bank Income', ['prefix' => 'Acc','controller' => 'BankIncomes', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						?>
					</ul>
				</li>
				<?php  
				}
				if($hrgaemployees['index'] == 1 || $leaves['index'] == 1 || $licenseabsents['index'] == 1 || $licenseearlyleaves['index'] == 1 || $overtimes['index'] == 1 || $hrgaattendances['index'] == 1 || $hrgaholidays['index'] == 1 || $salaries['index'] == 1 || $payrolls['index'] == 1 || ($reportattendances['index'] ?? 0) == 1 || $permissionlates['index'] == 1 || ($assignments['index'] ?? 0) == 1 || $outpermits['index'] == 1|| $absences['add']==1 || $workorders['index']==1 || $absentissues['index']==1) {
					$menuHr = ($getController=='hrgaemployees' || $getController=='leaves' || $getController=='licenseabsents' || $getController=='licenseearlyleaves' || $getController=='overtimes' || $getController=='hrgaattendances' || $getController=='hrgaholidays' || $getController=='salaries'|| $getController=='payrolls' || $getController=='reportattendances' || $getController=='permissionlates' || $getController=='assignments' || $getController=='outpermits'|| $getController=='absences' || $getController=='workorders' || $getController=='absentissues') ? 'active' :'';

					$menuHrgaEmployees = ($getController == 'hrgaemployees') ? 'class="active"' : '';

					// $menuHrIjin = ($getController == 'licenseabsents' || $getController == 'licenseearlyleaves' || $getController == 'permissionlates' || $getController == 'outpermits') ? 'class="active"' : '';
					$menuHrIjin = ($getController == 'licenseabsents' || $getController == 'licenseearlyleaves' || $getController == 'permissionlates' || $getController == 'outpermits') ? 'active' : '';
					$menuHrLicenseAbsents = ($getController == 'licenseabsents') ? 'class="active"' : '';
					$menuHrLicenseEarlyLeaves = ($getController == 'licenseearlyleaves') ? 'class="active"' : '';
					$menuPermissionLates = ($getController == 'permissionlates') ? 'class="active"' : '';
					$menuOutPermits = ($getController == 'outpermits') ? 'class="active"' : '';

					$menuHrgaAttendances = ($getController == 'hrgaattendances') ? 'class="active"' : '';
					$menuHrgaHolidays = ($getController == 'hrgaholidays') ? 'class="active"' : '';
					$menuSalaries = ($getController == 'salaries') ? 'class="active"' : '';
					$menuPayrolls = ($getController == 'payrolls') ? 'class="active"' : '';
					$menuReportAttendances = ($getController == 'reportattendances') ? 'class="active"' : '';
					$menuHrOvertimes = ($getController == 'overtimes') ? 'class="active"' : '';
					$menuHrLeaves = ($getController == 'leaves') ? 'class="active"' : '';
					$menuAssignments = ($getController == 'assignments') ? 'class="active"' : '';
					$menuAbsencesAdd = ($getController == 'absences' && $getAction == 'add') ? ' class="active"' : '';
					$menuAbsences = ($getController == 'absences' && $getAction == 'index') ? ' class="active"' : '';
					$menuDataWorkOrder = ($getController == 'workorders') ? 'class="active"' : '';
					$menuAbsenceIssues = ($getController == 'absentissues') ? 'class="active"' : '';
				?>
				<li class="has-sub <?= $menuHr ?>">
					<a href="javascript:;">
						<b class="caret pull-right"></b>
						<i class="fas fa-users"></i>
						<span>HR</span>
					</a>
					<ul class="sub-menu">
						<?php
						if($absences['add'] == 1) {
						?>
						<li <?= $menuAbsencesAdd?>><?= $this->Html->link('Absensi', ['prefix' => 'Hr', 'controller' => 'Absences', 'action' => 'add'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($absences['index'] == 1) {
						?>
						<li <?= $menuAbsences?>><?= $this->Html->link('Daftar Absensi', ['prefix' => 'Hr', 'controller' => 'Absences', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($hrgaemployees['index'] == 1) {
						?>
						<li <?= $menuHrgaEmployees ?>><?= $this->Html->link('Karyawan', ['prefix' => 'Hr', 'controller' => 'HrgaEmployees', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if ($leaves['index'] == 1) {
						?>
						<li <?= $menuHrLeaves ?>><?= $this->Html->link('Cuti', ['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if ($overtimes['index'] == 1) {
						?>
						<li <?= $menuHrOvertimes ?>><?= $this->Html->link('Lembur', ['prefix' => 'Hr', 'controller' => 'Overtimes', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						?>
						<li class="has-sub <?= $menuHrIjin ?>">
							<a href="javascript:;">
							<b class="caret"></b>
							Ijin
							</a>
							<ul class="sub-menu">
								<?php
								if ($licenseabsents['index'] == 1) {
								?>
								<li <?= $menuHrLicenseAbsents ?>><?= $this->Html->link('Tidak Masuk', ['prefix' => 'Hr', 'controller' => 'LicenseAbsents', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($licenseearlyleaves['index'] == 1) {
								?>
								<li <?= $menuHrLicenseEarlyLeaves ?>><?= $this->Html->link('Pulang Cepat', ['prefix' => 'Hr', 'controller' => 'LicenseEarlyLeaves', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($permissionlates['index'] == 1) {
								?>
								<li <?= $menuPermissionLates ?>><?= $this->Html->link('Terlambat', ['prefix' => 'Hr', 'controller' => 'PermissionLates', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								if ($outpermits['index'] == 1) {
								?>
								<li <?= $menuOutPermits ?>><?= $this->Html->link('Izin Keluar Sementara', ['prefix' => 'Hr', 'controller' => 'OutPermits', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
								<?php
								}
								?>
							</ul>
						</li>
						<?php
						if($hrgaattendances['index'] == 1) {
						?>
						<li <?= $menuHrgaAttendances ?>><?= $this->Html->link('Kehadiran', ['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($hrgaholidays['index'] == 1) {
						?>
						<li <?= $menuHrgaHolidays ?>><?= $this->Html->link('Tanggal Libur', ['prefix' => 'Hr', 'controller' => 'HrgaHolidays', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($salaries['index'] == 1) {
						?>
						<li <?= $menuSalaries ?>><?= $this->Html->link('Gaji Pegawai', ['prefix' => 'Hr', 'controller' => 'Salaries', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($payrolls['index'] == 1) {
						?>
						<li <?= $menuPayrolls ?>><?= $this->Html->link('Payroll', ['prefix' => false, 'controller' => 'Payrolls', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if(($reportattendances['index'] ?? 0) == 1) {
						?>
						<li <?= $menuReportAttendances ?>><?= $this->Html->link('Report Kehadiran', ['prefix' => 'Hr', 'controller' => 'ReportAttendances', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if(($assignments['index'] ?? 0) == 1) {
						?>
						<li <?= $menuAssignments ?>><?= $this->Html->link('Penugasan', ['prefix' => 'Hr', 'controller' => 'Assignments', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($workorders['index']==1) {
						?>
						<li <?= $menuDataWorkOrder ?>><?= $this->Html->link('Surat Perintah Kerja Lembur', ['prefix' => 'Hr', 'controller' => 'WorkOrders', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
						if($absentissues['index']==1) {
						?>
						<li <?= $menuAbsenceIssues ?>><?= $this->Html->link('Pengaduan Absensi', ['prefix' => 'Hr', 'controller' => 'AbsentIssues', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?></li>
						<?php
						}
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
									<?= $this->Html->link('Antrian Farmasi', ['prefix' => 'Farmasi','controller' => 'Orders', 'action' => 'antrianFarmasi'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($order['proses'])) { ?>
								<li <?= $menuProsesFarmasi ?>>
									<?= $this->Html->link('Proses Resep Luar', ['prefix' => 'Farmasi','controller' => 'Orders', 'action' => 'proses'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($rencanaPembelian['index'])) { ?>
								<li <?= $menuRencanaPembelian ?>>
									<?= $this->Html->link('Rencana Pembelian', ['prefix' => 'Farmasi','controller' => 'RencanaPembelians', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($orderPembelian['index'])) { ?>
								<li <?= $menuOrderPembelian ?>>
									<?= $this->Html->link('Order Pembelian', ['prefix' => 'Farmasi','controller' => 'OrderPembelians', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($invoice['index'])) { ?>
								<li <?= $menuInvoiceFarmasi ?>>
									<?= $this->Html->link('BAPB / Invoice', ['prefix' => 'Farmasi','controller' => 'Invoices', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($returPembelian['index'])) { ?>
								<li <?= $menuReturPembelian ?>>
									<?= $this->Html->link('Retur Pembelian', ['prefix' => 'Farmasi','controller' => 'ReturPembelians', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($medicineStock['index'])) { ?>
								<li <?= $menuMedicineStock ?>>
									<?= $this->Html->link('Informasi Stok', ['prefix' => 'Farmasi','controller' => 'MedicineStocks', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
							<?php if (!empty($kartuStok['index'])) { ?>
								<li <?= $menuKartuStok ?>>
									<?= $this->Html->link('Kartu Stok', ['prefix' => 'Farmasi','controller' => 'KartuStok', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
								</li>
							<?php } ?>
						</ul>
					</li>
				<?php
				}
				if (!empty($polyclinicQueue['index']) || !empty($polyclinicQueue['kiosk']) || !empty($polyclinicQueue['kioskNew']) || !empty($registration['index']) || !empty($praregistrations['index']) || !empty($patientAdmission['index'])) {

					$menuPolyclinicQueue = ($getController == 'polyclinicqueues' || $getController == 'registrations' || $getController == 'praregistrations' || $getController == 'patientadmissions') ? 'active' : '';
					$menuPolyclinicQueueIndex = ($getController == 'polyclinicqueues') ? ' class="active"' : '';
					$menuRegistrationIndex = ($getController == 'registrations') ? ' class="active"' : '';
					$menuPraRegistrationIndex = ($getController == 'praregistrations') ? ' class="active"' : '';
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
										'prefix' => 'Registrasi',
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
										'prefix' => 'Registrasi',
										'controller' => 'PolyclinicQueues',
										'action' => 'kiosk'
									],
									[
										'fullBase' => true,
										'escape' => false
									]
								) ?>
							</li>

							<?php if (!empty($polyclinicQueue['kioskNew'])): ?>
								<li <?= ($getController == 'polyclinicqueues' && $action == 'kioskNew') ? 'class="active"' : '' ?>>
									<?= $this->Html->link(
										'Kiosk New',
										[
											'prefix' => 'Registrasi',
											'controller' => 'PolyclinicQueues',
											'action' => 'kioskNew'
										],
										['fullBase' => true, 'escape' => false]
									) ?>
								</li>
							<?php endif; ?>

							<li <?= $menuRegistrationIndex ?>>
								<?= $this->Html->link(
									'Registration',
									[
										'prefix' => 'Registrasi',
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
							if (!empty($praregistrations['index'])) {
							?>
								<li <?= $menuPraRegistrationIndex ?>>
									<?= $this->Html->link(
										'Pra Registration',
										[
											'prefix' => 'Registrasi',
											'controller' => 'PraRegistrations',
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

							<?php
							if (!empty($patientAdmission['index'])) {
							?>
								<li <?= $menuPatientAdmissionIndex ?>>
									<?= $this->Html->link(
										'Pendaftaran Pasien',
										[
											'prefix' => 'Registrasi',
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

				if (!empty($outpatientVisit['index']) || !empty($outpatientVisit['doctorQueue']) || !empty($outpatientVisit['display']) || !empty($outpatientVisit['displaySettings']) || !empty($medicalRecord['index']) || !empty($outpatientLetter['index'])) {

					$menuOutpatientVisit = ($getController == 'outpatientvisits' || $getController == 'medicalrecords' || $getController == 'outpatientletters') ? 'active' : '';
					$menuOutpatientVisitIndex = ($getController == 'outpatientvisits' && $action == 'index') ? ' class="active"' : '';
					$menuOutpatientVisitDisplay = ($getController == 'outpatientvisits' && $action == 'display') ? ' class="active"' : '';
					$menuOutpatientVisitDisplaySettings = ($getController == 'outpatientvisits' && $action == 'displaySettings') ? ' class="active"' : '';
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
							<?php
							if (!empty($outpatientVisit['index'])) {
							?>
								<li <?= $menuOutpatientVisitIndex ?>>
									<?= $this->Html->link(
										'Kunjungan Rawat Jalan',
										[
											'prefix' => 'RawatJalan',
											'controller' => 'OutpatientVisits',
											'action' => 'index'
										],
										[
											'fullBase' => true,
											'escape' => false
										]
									) ?>
								</li>
								<?php if (!empty($outpatientVisit['doctorQueue'])): ?><li <?= ($getController == 'outpatientvisits' && $action == 'doctorQueue') ? ' class="active"' : '' ?>>
									<?= $this->Html->link('Menu Dokter - Daftar Pasien', ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'doctorQueue'], ['fullBase' => true]) ?>
								</li>
								<?php endif; ?>
							<?php
							}
							?>

							<?php if (!empty($outpatientVisit['display'])) { ?>
								<li <?= $menuOutpatientVisitDisplay ?>>
									<?= $this->Html->link(
										'Display Antrean Poli',
										['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'display'],
										['fullBase' => true, 'escape' => false]
									) ?>
								</li>
							<?php } ?>
							<?php if (!empty($outpatientVisit['displaySettings'])) { ?>
								<li <?= $menuOutpatientVisitDisplaySettings ?>><?= $this->Html->link('Pengaturan Display', ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits','action'=>'displaySettings']) ?></li>
							<?php } ?>

							<?php
							if (!empty($medicalRecord['index'])) {
							?>
								<li <?= $menuMedicalRecordIndex ?>>
									<?= $this->Html->link(
										'Rekam Medis',
										[
											'prefix' => 'RekamMedis',
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
											'prefix' => 'RawatJalan',
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

				if (!empty($outpatientBilling['index']) || !empty($paymentHistory['index'])) {

					$menuKasir = ($getController == 'outpatientbillings' || $getController == 'paymenthistories') ? 'active' : '';
					$menuKasirSentralIndex = ($getController == 'outpatientbillings') ? ' class="active"' : '';
					$menuHistorisKasirIndex = ($getController == 'paymenthistories') ? ' class="active"' : '';
				?>
					<li class="has-sub <?= $menuKasir ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-cash-register"></i>
							<span>Kasir</span>
						</a>

						<ul class="sub-menu">
							<?php
							if (!empty($outpatientBilling['index'])) {
							?>
								<li <?= $menuKasirSentralIndex ?>>
									<?= $this->Html->link(
										'Kasir Sentral',
										[
											'prefix' => 'Kasir',
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

							if (!empty($paymentHistory['index'])) {
							?>
								<li <?= $menuHistorisKasirIndex ?>>
									<?= $this->Html->link(
										'Historis Kasir',
										[
											'prefix' => 'Kasir',
											'controller' => 'PaymentHistories',
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
							<span>IGD</span>
						</a>

						<ul class="sub-menu">
							<li <?= $menuEmergencyEntryIndex ?>>
								<?= $this->Html->link(
									'Daftar Pasien IGD',
									[
										'prefix' => 'Igd',
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
										'prefix' => 'Registrasi',
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

				// ===== LABORATORIUM (baru) =====
				if (!empty($labExamination['index'])) {
				$menuLab = ($getController == 'labexaminations') ? 'active' : '';
				?>
					<li class="has-sub <?= $menuLab ?>">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-flask"></i>
							<span>Laboratorium</span>
						</a>
						<ul class="sub-menu">
							<li <?= ($getController == 'labexaminations') ? 'class="active"' : '' ?>>
								<?= $this->Html->link('Daftar Pemeriksaan', ['prefix' => 'Penunjang', 'controller' => 'LabExaminations', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
							</li>
						</ul>
					</li>
				<?php
				}

				if (
					$medicine['index'] == 1 ||
					($medicineMerk['index'] ?? 0) == 1 ||
					($medicineGroup['index'] ?? 0) == 1 ||
					$patient['index'] == 1 ||
					$doctor['index'] == 1 ||
					$doctorSchedule['index'] == 1 ||
					$healthFacility['index'] == 1 ||
					$insurance['index'] == 1 ||
					$nutritionCombine['index'] == 1 ||
					$nutritionMenu['index'] == 1 ||
					$pharmacyItem['index'] == 1 ||
					$polyclinic['index'] == 1 ||
					!empty($masterTindakan['index']) ||
					!empty($masterTenagaMedis['index']) ||
					!empty($masterIcd9['index']) ||
					!empty($masterIcd10['index']) ||
					!empty($masterRadiologies['index']) ||
					!empty($masterLaboratories['index']) ||
					!empty($masterPenjamins['index']) ||
					!empty($masterPatientReferrers['index']) ||
					!empty($masterTreatmentPackages['index']) ||
					$rooms['index'] == 1 ||
					$beds['index'] == 1 || $bankaccounts['index']==1
				) {

					$menuDataLink = (
						$getController == 'medicines' ||
						$getController == 'medicinemerks' ||
						$getController == 'medicinegroups' ||
						$getController == 'patients' ||
						$getController == 'mastertindakan' ||
						$getController == 'mastertenagamedis' ||
						$getController == 'mastericd9' ||
						$getController == 'mastericd10' ||
						$getController == 'masterradiologies' ||
						$getController == 'masterlaboratories' ||
						$getController == 'masterpenjamins' ||
						$getController == 'masterpatientreferrers' ||
						$getController == 'mastertreatmentpackages' ||
						$getController == 'beds' ||
						$getController == 'rooms' || $getController=='bankaccounts'
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
					$menuMasterTenagaMedisIndex = ($getController == 'mastertenagamedis') ? ' class="active"' : '';
					$menuMasterIcd9Index = ($getController == 'mastericd9') ? ' class="active"' : '';
					$menuMasterIcd10Index = ($getController == 'mastericd10') ? ' class="active"' : '';
					$menuMasterRadiologiesIndex = ($getController == 'masterradiologies') ? ' class="active"' : '';
					$menuMasterLaboratoriesIndex = ($getController == 'masterlaboratories') ? ' class="active"' : '';
					$menuMasterPenjaminsIndex = ($getController == 'masterpenjamins') ? ' class="active"' : '';
					$menuMasterPatientReferrersIndex = ($getController == 'masterpatientreferrers') ? ' class="active"' : '';
					$menuMasterTreatmentPackagesIndex = ($getController == 'mastertreatmentpackages') ? ' class="active"' : '';
					$menuRoomIndex = ($getController == 'rooms') ? ' class="active"' : '';
					$menuBedIndex = ($getController == 'beds') ? ' class="active"' : '';

					$menuBankAccounts = ($getController=='bankaccounts') ? 'class="active"' : '';

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
								($medicineMerk['index'] ?? 0) == 1 ||
								($medicineGroup['index'] ?? 0) == 1
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
												<?= $this->Html->link('Daftar', ['prefix' => 'Farmasi','controller' => 'Medicines', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										<?php
										}

										if (($medicineMerk['index'] ?? 0) == 1) {
										?>
											<li <?= $menuMasterMedicineMerk ?>>
												<?= $this->Html->link('Merk', ['prefix' => 'Farmasi','controller' => 'MedicineMerks', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										<?php
										}

										if (($medicineGroup['index'] ?? 0) == 1) {
										?>
											<li <?= $menuMasterMedicineGroup ?>>
												<?= $this->Html->link('Group', ['prefix' => 'Farmasi','controller' => 'MedicineGroups', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
											</li>
										<?php
										}
										?>
									</ul>
								</li>
							<?php
							}

							$masterGroups = [
									'Pasien & Dokter' => [
										['Patients',               'Patients',              'Registrasi', !empty($patient['index']),                 'patients'],
										['Doctor',                 'Doctors',               'Master',        !empty($doctor['index']),                  'doctors'],
										['Doctor Schedules',       'DoctorSchedules',       'Master',        !empty($doctorSchedule['index']),          'doctorschedules'],
										['Master Tenaga Medis',    'MasterTenagaMedis',     'Master',        !empty($masterTenagaMedis['index']),       'mastertenagamedis'],
										['Master Patient Referrers','MasterPatientReferrers','Master',       !empty($masterPatientReferrers['index']),  'masterpatientreferrers'],
									],
									'Fasilitas' => [
										['Health Facilities',      'HealthFacilities',      'Master',        !empty($healthFacility['index']),          'healthfacilities'],
										['Polyclinics',            'Polyclinics',           'Registrasi', !empty($polyclinic['index']),              'polyclinics'],
										['Rooms',                  'Rooms',                 'Master',        !empty($rooms['index']),                   'rooms'],
										['Bed Management',         'Beds',                  'Master',        !empty($beds['index']),                    'beds'],
									],
									'Penjamin' => [
										['Insurances',             'Insurances',            'Master',        !empty($insurance['index']),               'insurances'],
										['Jenis Asuransi',         'MasterPenjamins',       'Master',        !empty($masterPenjamins['index']),         'masterpenjamins'],
									],
									'Gizi' => [
										['Nutrition Combine',      'NutritionCombine',      'Master',        !empty($nutritionCombine['index']),        'nutritioncombine'],
										['Nutrition Menus',        'NutritionMenus',        'Master',        !empty($nutritionMenu['index']),           'nutritionmenus'],
									],
									'Penunjang Medis' => [
										['Pharmacy Items',         'PharmacyItems',         'Master',        !empty($pharmacyItem['index']),            'pharmacyitems'],
										['Radiologi',              'MasterRadiologies',     'Master',        !empty($masterRadiologies['index']),       'masterradiologies'],
										['Laboratory',             'MasterLaboratories',    'Master',        !empty($masterLaboratories['index']),      'masterlaboratories'],
									],
									'Tindakan & Diagnosa' => [
										['Master Tindakan',        'MasterTindakan',        'Master',        !empty($masterTindakan['index']),          'mastertindakan'],
										['Master ICD-9 CM',        'MasterIcd9',            'Master',        !empty($masterIcd9['index']),              'mastericd9'],
										['Master ICD-10',          'MasterIcd10',           'Master',        !empty($masterIcd10['index']),             'mastericd10'],
										['Master Treatment Packages','MasterTreatmentPackages','Master',     !empty($masterTreatmentPackages['index']), 'mastertreatmentpackages'],
									],
									'Keuangan' => [
										['Akun Bank',              'BankAccounts',          'Master',     !empty($bankaccounts['index']),            'bankaccounts'],
									],
								];

								foreach ($masterGroups as $groupName => $groupItems):
									$visibleItems = array_filter($groupItems, fn($i) => $i[3]);
									if (empty($visibleItems)) {
										continue;
									}
									$groupActive = in_array($getController, array_column($visibleItems, 4), true) ? 'active' : '';
									?>
									<li class="has-sub <?= $groupActive ?>">
										<a href="javascript:;">
											<b class="caret"></b>
											<span><?= h($groupName) ?></span>
										</a>
										<ul class="sub-menu">
											<?php foreach ($visibleItems as $i): ?>
												<li <?= ($getController === $i[4]) ? 'class="active"' : '' ?>>
													<?= $this->Html->link($i[0], ['prefix' => $i[2], 'controller' => $i[1], 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
												</li>
											<?php endforeach; ?>
										</ul>
									</li>
									<?php
								endforeach;
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
					$menuAddFace = ($getController=='users' && $getAction=='addFace')?' class="active"':'';	
					$menuChangePin = ($getController == 'users' && $getAction == 'changePin') ? ' class="active"' : '';
				?>

					<li class="has-sub <?= $menuSetting ?>">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-cog"></i>
							<span>Pengaturan</span>
						</a>
						<ul class="sub-menu">
							<li<?= $menuChangePassword ?>>
								<?= $this->Html->link('Ganti Password', ['prefix' => false,'controller' => 'Users', 'action' => 'changePassword', $getUser->id], ['fullBase' => true, 'escape' => false]) ?>
					</li>
					<?php
					if ($users['index'] == 1) {
					?>
						<li<?= $menuUser ?>>
						<?= $this->Html->link('User', ['prefix'=>false, 'controller' => 'Users', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
						</li>
					<?php
					}
					if($users['addFace']==1 && (empty($getUser->face) || $getUser->face == null)){
					?>
					<li<?= $menuAddFace ?>><?= $this->Html->link('Tambah Wajah', ['prefix'=>false, 'controller' => 'Users', 'action' => 'addFace',$getUser->id], ['fullBase'=>true, 'escape' => false]) ?></li>
					<?php
					}
					if ($branch['index'] == 1) {
					?>
						<li<?= $menuBranches ?>>
							<?= $this->Html->link('Cabang', ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
							</li>
						<?php
					}
					if (false && $settings['index'] == 1) {
					?>
					<li<?= $menuSettings ?>>
						<?= $this->Html->link('Perusahaan', ['prefix' => 'Pengaturan', 'controller' => 'Settings', 'action' => 'edit', 1], ['fullBase' => true, 'escape' => false]) ?>
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
