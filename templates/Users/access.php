<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$dataChild = $this->Html->link('User', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Pengaturan', $dataChild, 'Akses') ?>
<?php
// pr($rules);
// Branch

if (!empty($rules)) {
    $ruleChecked = function (string $controller, string $action) use ($rules): string {
        return (($rules[$controller][$action] ?? 0) == 1) ? 'checked' : '';
    };

    $ruleCheckbox = function (string $controller, string $action, string $label) use ($ruleChecked): string {
        return '<div class="form-check form-check-inline">'
            . $this->Form->checkbox("Rules.{$controller}.{$action}", [
                'value' => '1',
                'hiddenField' => true,
                'checked' => $ruleChecked($controller, $action),
                'class' => 'form-check-input',
            ])
            . '<label class="form-check-label">' . h($label) . '</label>'
            . '</div>';
    };

    $ruleRow = function (string $title, string $controller, array $actions) use ($ruleCheckbox): string {
        $checkboxes = '';
        foreach ($actions as $action => $label) {
            $checkboxes .= $ruleCheckbox($controller, $action, $label);
        }

        return '<tr><td>' . h($title) . '</td><td><div class="col-md-12">' . $checkboxes . '</div></td></tr>';
    };

    // Branch
    $branch = $rules['branches'];
    $branchIndex = ($branch['index'] == 1) ? 'checked' : '';
    $branchAdd = ($branch['add'] == 1) ? 'checked' : '';
    $branchEdit = ($branch['edit'] == 1) ? 'checked' : '';
    $branchDelete = ($branch['delete'] == 1) ? 'checked' : '';

    // User
    $user = $rules['users'];
    $userIndex = ($user['index'] == 1) ? 'checked' : '';
    $userAdd = ($user['add'] == 1) ? 'checked' : '';
    $userEdit = ($user['edit'] == 1) ? 'checked' : '';
    $userAccess = ($user['access'] == 1) ? 'checked' : '';
    $userResetPassword = ($user['resetPassword'] == 1) ? 'checked' : '';
    $userDelete = ($user['delete'] == 1) ? 'checked' : '';


    // Setting
    $setting = $rules['settings'];
    $settingAdd = ($setting['add'] == 1) ? 'checked' : '';
    $settingEdit = ($setting['edit'] == 1) ? 'checked' : '';
    $settingIndex = ($setting['index'] == 1) ? 'checked' : '';


    // ---------- ACC --------------------------------
// Acc Chart Of Account
$accChartOfAccount = $rules['accchartofaccounts'];
$accChartOfAccountIndex = ($accChartOfAccount['index'] == 1) ? 'checked' : '';
$accChartOfAccountEdit = ($accChartOfAccount['edit']==1) ? 'checked' : '';
$accChartOfAccountAdd = ($accChartOfAccount['add'] == 1) ? 'checked' : '';
$accChartOfAccountAddGroup = ($accChartOfAccount['addGroup'] == 1) ? 'checked' : '';
$accChartOfAccountGroup = ($accChartOfAccount['group']==1) ? 'checked' : '';
// $accChartOfAccountEditGroup = ($accChartOfAccount['editGroup'] == 1) ? 'checked' : '';
$accChartOfAccountDelete = ($accChartOfAccount['delete'] == 1) ? 'checked' : '';
$accChartOfAccountMoveUp = ($accChartOfAccount['moveUp'] == 1) ? 'checked' : '';
$accChartOfAccountMoveDown = ($accChartOfAccount['moveDown'] == 1) ? 'checked' : '';
$accChartOfAccountStatusSubmission = ($accChartOfAccount['statusSubmission'] == 1) ? 'checked' : '';
$accChartOfAccountBeginningBalanceExportImport = ($accChartOfAccount['beginningBalanceExportImport'] == 1) ? 'checked' : '';
$accChartOfAccountBeginningBalanceExportImportXls = ($accChartOfAccount['beginningBalanceExportImportXls'] == 1) ? 'checked' : '';
$accChartOfAccountXls = ($accChartOfAccount['xls'] == 1) ? 'checked' : '';
// $accChartOfAccountPdf = ($accChartOfAccount['pdf'] == 1) ? 'checked' : '';
// $accChartOfAccount_exampleXls = ($accChartOfAccount['exampleXls'] == 1) ? 'checked' : '';
$accChartOfAccountTemplateExcel = ($accChartOfAccount['templateExcel'] == 1) ? 'checked' : '';
$accChartOfAccountImportExcel = ($accChartOfAccount['importExcel'] == 1) ? 'checked' : '';
$accChartOfAccountEndingBalance = ($accChartOfAccount['endingBalance'] == 1) ? 'checked' : '';

// Acc Journal
$accJournal = $rules['accjournals'];
$accJournalIndex = ($accJournal['index'] == 1) ? 'checked' : '';
$accJournalIndexShort = ($accJournal['indexShort'] == 1) ? 'checked' : '';
$accJournalAdd = ($accJournal['add'] == 1) ? 'checked' : '';
$accJournalAddMany = ($accJournal['addMany'] == 1) ? 'checked' : '';
$accJournalEditMany = ($accJournal['editMany'] == 1) ? 'checked' : '';
$accJournalAddOnlyOne = ($accJournal['addOnlyOne'] == 1) ? 'checked' : '';
$accJournalEdit = ($accJournal['edit'] == 1) ? 'checked' : '';
$accJournalDelete = ($accJournal['delete'] == 1) ? 'checked' : '';
// $accJournalGeneralLedgerPdf = ($accJournal['generalLedgerPdf'] == 1) ? 'checked' : '';
// $accJournalGeneralLedgerXls = ($accJournal['generalLedgerXls'] == 1) ? 'checked' : '';
$accJournalGeneralLedgerReport = ($accJournal['generalLedgerReport'] == 1) ? 'checked' : '';
// $accJournalEkuitasPdf = ($accJournal['ekuitasPdf'] == 1) ? 'checked' : '';
// $accJournalEkuitasReport = ($accJournal['ekuitasReport'] == 1) ? 'checked' : '';
$accJournalGeneralJournalReport = ($accJournal['generalJournalReport'] == 1) ? 'checked' : '';
$accJournalIncomeGlobalReport = ($accJournal['incomeGlobalReport'] == 1) ? 'checked' : '';
// $accJournalIncomeGlobalPdf = ($accJournal['incomeGlobalPdf'] == 1) ? 'checked' : '';
// $accJournalIncomeGlobalXls = ($accJournal['incomeGlobalXls'] == 1) ? 'checked' : '';
$accJournalIncomeMultiReport = ($accJournal['incomeMultiReport'] == 1) ? 'checked' : '';
// $accJournalIncomeMultiPdf = ($accJournal['incomeMultiPdf'] == 1) ? 'checked' : '';
// $accJournalIncomeMultiXls = ($accJournal['incomeMultiXls'] == 1) ? 'checked' : '';
$accJournalBalanceSheetPercentReport = ($accJournal['balanceSheetPercentReport'] == 1) ? 'checked' : '';
$accJournalBalanceSheetPercentXls = ($accJournal['balanceSheetPercentXls'] == 1) ? 'checked' : '';
$accJournalTrialBalanceReport = ($accJournal['trialBalanceReport'] == 1) ? 'checked' : '';
$accJournalTrialBalanceXls = ($accJournal['trialBalanceXls'] == 1) ? 'checked' : '';
$accJournalImport = ($accJournal['import'] == 1) ? 'checked' : '';
$accJournalImportExampleXls = ($accJournal['importExampleXls'] == 1) ? 'checked' : '';
$accJournalPostingSave = ($accJournal['postingSave'] == 1) ? 'checked' : '';
$accJournalWorkSheetBalanceReport = ($accJournal['workSheetBalanceReport'] == 1) ? 'checked' : '';
$accJournalWorkSheetBalanceReportXls = ($accJournal['workSheetBalanceReportXls'] == 1) ? 'checked' : '';

$accJournalReportJurnalPaymentInvoiceAdmin = ($accJournal['reportJurnalPaymentInvoiceAdmin']==1) ? 'checked' : '';
$accJournalReportJurnalPiutangManifestAdmin = ($accJournal['reportJurnalPiutangManifestAdmin']==1) ? 'checked' : '';
$accJournalReportJurnalDepositInvoiceAdmin = ($accJournal['reportJurnalDepositInvoiceAdmin']==1) ? 'checked' : '';
$accJournalExportImportJournalOld = ($accJournal['exportImportJournalOld']==1) ? 'checked' : '';
$accJournalExportImportJournalOldXls = ($accJournal['exportImportJournalOldXls']==1) ? 'checked' : '';
$accJournalExportImportJournal = ($accJournal['exportImportJournal']==1) ? 'checked' : '';
$accJournalExportImportJournalXls = ($accJournal['exportImportJournalXls']==1) ? 'checked' : '';
$accJournalRekapJournal = ($accJournal['rekapJournal']==1) ? 'checked' : '';
$accJournalXlsRekapJournal = ($accJournal['xlsRekapJournal']==1) ? 'checked' : '';
$accJournalPdfRekapJournal = ($accJournal['pdfRekapJournal']==1) ? 'checked' : '';
$accJournalReportPrintCashBank = ($accJournal['reportPrintCashBank']==1) ? 'checked' : '';
$accJournalPreviewPrintCashBank = ($accJournal['previewPrintCashBank']==1) ? 'checked' : '';
$accJournalPrintCashBank = ($accJournal['printCashBank']==1) ? 'checked' : '';
$accJournalReportPosting = ($accJournal['reportPosting']==1) ? 'checked' : '';
$accJournalPreviewPosting = ($accJournal['previewPosting']==1) ? 'checked' : '';
$accJournalEditPosting = ($accJournal['editPosting']==1) ? 'checked' : '';
$accJournalReportSummaryCash = ($accJournal['reportSummaryCash']==1) ? 'checked' : '';
$accJournalReportIncome = ($accJournal['reportIncome']==1) ? 'checked' : '';
$accJournalXlsIncome = ($accJournal['xlsIncome']==1) ? 'checked' : '';
$accJournalPdfIncome = ($accJournal['pdfIncome']==1) ? 'checked' : '';
// $accJournalReportIncomeGlobal = ($accJournal['reportIncomeGlobal']==1) ? 'checked' : '';
$accJournalXlsIncomeGlobal = ($accJournal['xlsIncomeGlobal']==1) ? 'checked' : '';
$accJournalPdfIncomeGlobal = ($accJournal['pdfIncomeGlobal']==1) ? 'checked' : '';
// $accJournalReportIncomeMulti = ($accJournal['reportIncomeMulti']==1) ? 'checked' : '';
$accJournalXlsIncomeMulti = ($accJournal['xlsIncomeMulti']==1) ? 'checked' : '';
$accJournalPdfIncomeMulti = ($accJournal['pdfIncomeMulti']==1) ? 'checked' : '';
// 2019
$accJournalReportIncomeGlobal2019 = ($accJournal['reportIncomeGlobal2019']==1) ? 'checked' : '';
$accJournalXlsIncomeGlobal2019 = ($accJournal['xlsIncomeGlobal2019']==1) ? 'checked' : '';
$accJournalPdfIncomeGlobal2019 = ($accJournal['pdfIncomeGlobal2019']==1) ? 'checked' : '';
$accJournalReportIncomeMulti2019 = ($accJournal['reportIncomeMulti2019']==1) ? 'checked' : '';
$accJournalXlsIncomeMulti2019 = ($accJournal['xlsIncomeMulti2019']==1) ? 'checked' : '';
$accJournalPdfIncomeMulti2019 = ($accJournal['pdfIncomeMulti2019']==1) ? 'checked' : '';
// $accJournalReportGeneralJournal = ($accJournal['reportGeneralJournal']==1) ? 'checked' : '';
$accJournalReportJournal = ($accJournal['reportJournal']==1) ? 'checked' : '';
$accJournalReportJournalXls = ($accJournal['reportJournalXls']==1) ? 'checked' : '';
$accJournalXlsJournal = ($accJournal['xlsJournal']==1) ? 'checked' : '';
// $accJournalReportGeneralLedger = ($accJournal['reportGeneralLedger']==1) ? 'checked' : '';
$accJournalPdfGeneralLedger = ($accJournal['pdfGeneralLedger']==1) ? 'checked' : '';
$accJournalXlsGeneralLedger = ($accJournal['xlsGeneralLedger']==1) ? 'checked' : '';
// $accJournalReportBalanceSheet = ($accJournal['reportBalanceSheet']==1) ? 'checked' : '';
// $accJournalXlsBalanceSheet = ($accJournal['xlsBalanceSheet']==1) ? 'checked' : '';
// $accJournalPdfBalanceSheet = ($accJournal['pdfBalanceSheet']==1) ? 'checked' : '';
$accJournalReportOrdinaryBalanceSheet = ($accJournal['reportOrdinaryBalanceSheet']==1) ? 'checked' : '';
$accJournalXlsOrdinaryBalanceSheet = ($accJournal['xlsOrdinaryBalanceSheet']==1) ? 'checked' : '';
$accJournalPdfOrdinaryBalanceSheet = ($accJournal['pdfOrdinaryBalanceSheet']==1) ? 'checked' : '';
$accJournalReportPercentBalanceSheet = ($accJournal['reportPercentBalanceSheet']==1) ? 'checked' : '';
$accJournalXlsPercentBalanceSheet = ($accJournal['xlsPercentBalanceSheet']==1) ? 'checked' : '';
$accJournalPdfPercentBalanceSheet = ($accJournal['pdfPercentBalanceSheet']==1) ? 'checked' : '';
$accJournalReportBalanceSheetPercent = ($accJournal['reportBalanceSheetPercent']==1) ? 'checked' : '';
$accJournalXlsBalanceSheetPercent = ($accJournal['xlsBalanceSheetPercent']==1) ? 'checked' : '';
$accJournalPdfBalanceSheetPercent = ($accJournal['pdfBalanceSheetPercent']==1) ? 'checked' : '';
$accJournalReportTrialBalance = ($accJournal['reportTrialBalance']==1) ? 'checked' : '';
$accJournalReportTrialBalanceNew = ($accJournal['reportTrialBalanceNew']==1) ? 'checked' : '';
$accJournalXlsTrialBalanceNew = ($accJournal['xlsTrialBalanceNew']==1) ? 'checked' : '';
$accJournalPdfTrialBalanceNew = ($accJournal['pdfTrialBalanceNew']==1) ? 'checked' : '';
$accJournalXlsTrialBalance = ($accJournal['xlsTrialBalance']==1) ? 'checked' : '';
$accJournalReportEkuitas = ($accJournal['reportEkuitas']==1) ? 'checked' : '';
$accJournalXlsEkuitas = ($accJournal['xlsEkuitas']==1) ? 'checked' : '';
$accJournalPrintJournal = ($accJournal['printJournal']==1) ? 'checked' : '';
$accJournalFinancialRatioLiquiditas = ($accJournal['financialRatioLiquiditas']==1) ? 'checked' : '';
$accJournalFinancialRatioLiquiditasXls = ($accJournal['financialRatioLiquiditasXls']==1) ? 'checked' : '';
$accJournalFinancialRatioLiquiditasPdf = ($accJournal['financialRatioLiquiditasPdf']==1) ? 'checked' : '';
$accJournalFinancialRatioSolvabilitas = ($accJournal['financialRatioSolvabilitas']==1) ? 'checked' : '';
$accJournalFinancialRatioSolvabilitasXls = ($accJournal['financialRatioSolvabilitasXls']==1) ? 'checked' : '';
$accJournalFinancialRatioSolvabilitasPdf = ($accJournal['financialRatioSolvabilitasPdf']==1) ? 'checked' : '';
$accJournalFinancialRatioRentabilitas = ($accJournal['financialRatioRentabilitas']==1) ? 'checked' : '';
$accJournalFinancialRatioRentabilitasXls = ($accJournal['financialRatioRentabilitasXls']==1) ? 'checked' : '';
$accJournalFinancialRatioRentabilitasPdf = ($accJournal['financialRatioRentabilitasPdf']==1) ? 'checked' : '';
$accJournalFinancialRatioAktivitas = ($accJournal['financialRatioAktivitas']==1) ? 'checked' : '';
$accJournalFinancialRatioAktivitasXls = ($accJournal['financialRatioAktivitasXls']==1) ? 'checked' : '';
$accJournalFinancialRatioAktivitasPdf = ($accJournal['financialRatioAktivitasPdf']==1) ? 'checked' : '';
$accJournalReportBalance = ($accJournal['reportBalance']==1) ? 'checked' : '';
$accJournalReportBalanceXls = ($accJournal['reportBalanceXls']==1) ? 'checked' : '';
$accJournalReportBalancePdf = ($accJournal['reportBalancePdf']==1) ? 'checked' : '';
$accJournalPreview = ($accJournal['preview']==1) ? 'checked' : '';
$accJournalPreviewXls = ($accJournal['previewXls']==1) ? 'checked' : '';
$accJournalXls = ($accJournal['xls']==1) ? 'checked' : '';

//Bank Topupus
$banktopups = $rules['banktopups'];
$banktopupsIndex = ($banktopups['index'] == 1) ? 'checked' : '';
$banktopupsAdd = ($banktopups['add'] == 1) ? 'checked' : '';
$banktopupsEdit = ($banktopups['edit'] == 1) ? 'checked' : '';
$banktopupsDelete = ($banktopups['delete'] == 1) ? 'checked' : '';
$banktopupsView = ($banktopups['view'] == 1) ? 'checked' : '';
$banktopupsXls = ($banktopups['xls'] == 1) ? 'checked' : '';

//Bank Incomes
$bankincomes = $rules['bankincomes'];
$bankincomesIndex = ($bankincomes['index'] == 1) ? 'checked' : '';
$bankincomesAdd = ($bankincomes['add'] == 1) ? 'checked' : '';
$bankincomesEdit = ($bankincomes['edit'] == 1) ? 'checked' : '';
$bankincomesDelete = ($bankincomes['delete'] == 1) ? 'checked' : '';
$bankincomesView = ($bankincomes['view'] == 1) ? 'checked' : '';
$bankincomesXls = ($bankincomes['xls'] == 1) ? 'checked' : '';
//-----------------------------------------------------------------


    //doctor
    $doctor = $rules['doctors'];
    $doctorsIndex = ($doctor['index'] == 1) ? 'checked' : '';
    $doctorsAdd = ($doctor['add'] == 1) ? 'checked' : '';
    $doctorsEdit = ($doctor['edit'] == 1) ? 'checked' : '';
    $doctorsView = ($doctor['view'] == 1) ? 'checked' : '';
    $doctorsDelete = ($doctor['delete'] == 1) ? 'checked' : '';

    //doctorschedules
    $doctorschedule = $rules['doctorschedules'];
    $doctorschedulesIndex = ($doctorschedule['index'] == 1) ? 'checked' : '';
    $doctorschedulesAdd = ($doctorschedule['add'] == 1) ? 'checked' : '';
    $doctorschedulesEdit = ($doctorschedule['edit'] == 1) ? 'checked' : '';
    $doctorschedulesView = ($doctorschedule['view'] == 1) ? 'checked' : '';
    $doctorschedulesDelete = ($doctorschedule['delete'] == 1) ? 'checked' : '';

    //room
    $room = $rules['rooms'];
    $roomsIndex = ($room['index'] == 1) ? 'checked' : '';
    $roomsAdd = ($room['add'] == 1) ? 'checked' : '';
    $roomsEdit = ($room['edit'] == 1) ? 'checked' : '';
    $roomsView = ($room['view'] == 1) ? 'checked' : '';
    $roomsDelete = ($room['delete'] == 1) ? 'checked' : '';
    $roomsMonitoring = ($room['monitoring'] == 1) ? 'checked' : '';

    //polyclinic
    $polyclinic = $rules['polyclinics'];
    $polyclinicsIndex = ($polyclinic['index'] == 1) ? 'checked' : '';
    $polyclinicsAdd = ($polyclinic['add'] == 1) ? 'checked' : '';
    $polyclinicsEdit = ($polyclinic['edit'] == 1) ? 'checked' : '';
    $polyclinicsView = ($polyclinic['view'] == 1) ? 'checked' : '';
    $polyclinicsDelete = ($polyclinic['delete'] == 1) ? 'checked' : '';

    //patient
    $patient = $rules['patients'];
    $patientsIndex = (($patient['index'] ?? 0) == 1) ? 'checked' : '';
    $patientsAdd = (($patient['add'] ?? 0) == 1) ? 'checked' : '';
    $patientsEdit = (($patient['edit'] ?? 0) == 1) ? 'checked' : '';
    $patientsView = (($patient['view'] ?? 0) == 1) ? 'checked' : '';
    $patientsDelete = (($patient['delete'] ?? 0) == 1) ? 'checked' : '';
    $patientsDataExportImport = (($patient['dataExportImport'] ?? 0) == 1) ? 'checked' : '';
    $patientsDataExportImportXls = (($patient['dataExportImportXls'] ?? 0) == 1) ? 'checked' : '';

    //healthfacilities
    $healthfacilities = $rules['healthfacilities'];
    $healthfacilitiesIndex = ($healthfacilities['index'] == 1) ? 'checked' : '';
    $healthfacilitiesAdd = ($healthfacilities['add'] == 1) ? 'checked' : '';
    $healthfacilitiesEdit = ($healthfacilities['edit'] == 1) ? 'checked' : '';
    $healthfacilitiesPreview = ($healthfacilities['preview'] == 1) ? 'checked' : '';
    $healthfacilitiesDelete = ($healthfacilities['delete'] == 1) ? 'checked' : '';
    $healthfacilitiesDataExportImport = ($healthfacilities['dataExportImport'] == 1) ? 'checked' : '';
    $healthfacilitiesDataExportImportXls = ($healthfacilities['dataExportImportXls'] == 1) ? 'checked' : '';

    //insurances
    $insurance = $rules['insurances'];
    $insurancesIndex = ($insurance['index'] == 1) ? 'checked' : '';
    $insurancesAdd = ($insurance['add'] == 1) ? 'checked' : '';
    $insurancesEdit = ($insurance['edit'] == 1) ? 'checked' : '';
    $insurancesView = ($insurance['view'] == 1) ? 'checked' : '';
    $insurancesDelete = ($insurance['delete'] == 1) ? 'checked' : '';

    //pharmacyitems
    $pharmacyitem = $rules['pharmacyitems'];
    $pharmacyitemsIndex = ($pharmacyitem['index'] == 1) ? 'checked' : '';
    $pharmacyitemsAdd = ($pharmacyitem['add'] == 1) ? 'checked' : '';
    $pharmacyitemsEdit = ($pharmacyitem['edit'] == 1) ? 'checked' : '';
    $pharmacyitemsView = ($pharmacyitem['view'] == 1) ? 'checked' : '';
    $pharmacyitemsDelete = ($pharmacyitem['delete'] == 1) ? 'checked' : '';

    //nutritionMenus
    $nutritionmenu = $rules['nutritionmenus'];
    $nutritionmenusIndex = ($nutritionmenu['index'] == 1) ? 'checked' : '';
    $nutritionmenusAdd = ($nutritionmenu['add'] == 1) ? 'checked' : '';
    $nutritionmenusEdit = ($nutritionmenu['edit'] == 1) ? 'checked' : '';
    $nutritionmenusView = ($nutritionmenu['view'] == 1) ? 'checked' : '';
    $nutritionmenusDelete = ($nutritionmenu['delete'] == 1) ? 'checked' : '';

    //nutritioncombine
    $nutritioncombine = $rules['nutritioncombine'];
    $nutritioncombineIndex = ($nutritioncombine['index'] == 1) ? 'checked' : '';
    $nutritioncombineAdd = ($nutritioncombine['add'] == 1) ? 'checked' : '';
    $nutritioncombineEdit = ($nutritioncombine['edit'] == 1) ? 'checked' : '';
    $nutritioncombineView = ($nutritioncombine['view'] == 1) ? 'checked' : '';
    $nutritioncombineDelete = ($nutritioncombine['delete'] == 1) ? 'checked' : '';

    //nutritionmenutypes
    $nutritionmenutype = $rules['nutritionmenutypes'];
    $nutritionmenutypesIndex = ($nutritionmenutype['index'] == 1) ? 'checked' : '';
    $nutritionmenutypesAdd = ($nutritionmenutype['add'] == 1) ? 'checked' : '';
    $nutritionmenutypesEdit = ($nutritionmenutype['edit'] == 1) ? 'checked' : '';
    $nutritionmenutypesView = ($nutritionmenutype['view'] == 1) ? 'checked' : '';
    $nutritionmenutypesDelete = ($nutritionmenutype['delete'] == 1) ? 'checked' : '';

    //polyclinics
    $polyclinicqueues = $rules['polyclinicqueues'];
    $polyclinicqueuesIndex = ($polyclinicqueues['index'] == 1) ? 'checked' : '';
    $polyclinicqueuesAdd = ($polyclinicqueues['add'] == 1) ? 'checked' : '';
    $polyclinicqueuesEdit = ($polyclinicqueues['edit'] == 1) ? 'checked' : '';
    $polyclinicqueuesDelete = ($polyclinicqueues['delete'] == 1) ? 'checked' : '';
    $polyclinicqueuesKiosk = ($polyclinicqueues['kiosk'] == 1) ? 'checked' : '';
    $polyclinicqueuesWa = ($polyclinicqueues['wa'] == 1) ? 'checked' : '';

    //registrations
    $registrations = $rules['registrations'];
    $registrationsIndex = ($registrations['index'] == 1) ? 'checked' : '';
    $registrationsAdd = ($registrations['add'] == 1) ? 'checked' : '';
    $registrationsEdit = ($registrations['edit'] == 1) ? 'checked' : '';
    $registrationsDelete = ($registrations['delete'] == 1) ? 'checked' : '';

    //medicalrecords
    $medicalrecords = $rules['medicalrecords'] ?? ['history' => 0];
    $medicalrecordsHistory = (!empty($medicalrecords['history'])) ? 'checked' : '';

    //outpatientvisits
    $outpatientvisits = $rules['outpatientvisits'] ?? [];
    $outpatientvisitsIndex = (($outpatientvisits['index'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsView = (($outpatientvisits['view'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsAdd = (($outpatientvisits['add'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsEdit = (($outpatientvisits['edit'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsCppt = (($outpatientvisits['cppt'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsEmr = (($outpatientvisits['emr'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsSelesai = (($outpatientvisits['selesai'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsPanggil = (($outpatientvisits['panggil'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsBatal = (($outpatientvisits['batal'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsGetSummary = (($outpatientvisits['getSummary'] ?? 0) == 1) ? 'checked' : '';
    $outpatientvisitsDelete = (($outpatientvisits['delete'] ?? 0) == 1) ? 'checked' : '';

    //inpatiententries
    $inpatiententries = $rules['inpatiententries'] ?? [];
    $inpatiententriesIndex = (($inpatiententries['index'] ?? 0) == 1) ? 'checked' : '';
    $inpatiententriesView = (($inpatiententries['view'] ?? 0) == 1) ? 'checked' : '';
    $inpatiententriesAdd = (($inpatiententries['add'] ?? 0) == 1) ? 'checked' : '';
    $inpatiententriesEdit = (($inpatiententries['edit'] ?? 0) == 1) ? 'checked' : '';
    $inpatiententriesDelete = (($inpatiententries['delete'] ?? 0) == 1) ? 'checked' : '';

    //mastertindakan
    $mastertindakan = $rules['mastertindakan'] ?? [];
    $mastertindakanIndex = (($mastertindakan['index'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanView = (($mastertindakan['view'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanAdd = (($mastertindakan['add'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanEdit = (($mastertindakan['edit'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanToggleActive = (($mastertindakan['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanSearch = (($mastertindakan['search'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanSearchDebug = (($mastertindakan['searchDebug'] ?? 0) == 1) ? 'checked' : '';
    $mastertindakanDelete = (($mastertindakan['delete'] ?? 0) == 1) ? 'checked' : '';

    //mastericd9
    $mastericd9 = $rules['mastericd9'] ?? [];
    $mastericd9Index = (($mastericd9['index'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9View = (($mastericd9['view'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9Add = (($mastericd9['add'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9Edit = (($mastericd9['edit'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9Import = (($mastericd9['import'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9ToggleActive = (($mastericd9['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9Search = (($mastericd9['search'] ?? 0) == 1) ? 'checked' : '';
    $mastericd9Delete = (($mastericd9['delete'] ?? 0) == 1) ? 'checked' : '';

    //mastericd10
    $mastericd10 = $rules['mastericd10'] ?? [];
    $mastericd10Index = (($mastericd10['index'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10View = (($mastericd10['view'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10Add = (($mastericd10['add'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10Edit = (($mastericd10['edit'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10Import = (($mastericd10['import'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10ToggleActive = (($mastericd10['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10Search = (($mastericd10['search'] ?? 0) == 1) ? 'checked' : '';
    $mastericd10Delete = (($mastericd10['delete'] ?? 0) == 1) ? 'checked' : '';

    //masterlaboratories
    $masterlaboratories = $rules['masterlaboratories'] ?? [];
    $masterlaboratoriesIndex = (($masterlaboratories['index'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesView = (($masterlaboratories['view'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesAdd = (($masterlaboratories['add'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesEdit = (($masterlaboratories['edit'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesImport = (($masterlaboratories['import'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesToggleActive = (($masterlaboratories['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesSearch = (($masterlaboratories['search'] ?? 0) == 1) ? 'checked' : '';
    $masterlaboratoriesDelete = (($masterlaboratories['delete'] ?? 0) == 1) ? 'checked' : '';

    //masterradiologies
    $masterradiologies = $rules['masterradiologies'] ?? [];
    $masterradiologiesIndex = (($masterradiologies['index'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesView = (($masterradiologies['view'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesAdd = (($masterradiologies['add'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesEdit = (($masterradiologies['edit'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesImport = (($masterradiologies['import'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesToggleActive = (($masterradiologies['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesSearch = (($masterradiologies['search'] ?? 0) == 1) ? 'checked' : '';
    $masterradiologiesDelete = (($masterradiologies['delete'] ?? 0) == 1) ? 'checked' : '';

    //masterpenjamins
    $masterpenjamins = $rules['masterpenjamins'] ?? [];
    $masterpenjaminsIndex = (($masterpenjamins['index'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsView = (($masterpenjamins['view'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsAdd = (($masterpenjamins['add'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsEdit = (($masterpenjamins['edit'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsImport = (($masterpenjamins['import'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsToggleActive = (($masterpenjamins['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsSearch = (($masterpenjamins['search'] ?? 0) == 1) ? 'checked' : '';
    $masterpenjaminsDelete = (($masterpenjamins['delete'] ?? 0) == 1) ? 'checked' : '';

    //masterpatientreferrers
    $masterpatientreferrers = $rules['masterpatientreferrers'] ?? [];
    $masterpatientreferrersIndex = (($masterpatientreferrers['index'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersView = (($masterpatientreferrers['view'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersAdd = (($masterpatientreferrers['add'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersEdit = (($masterpatientreferrers['edit'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersImport = (($masterpatientreferrers['import'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersToggleActive = (($masterpatientreferrers['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersSearch = (($masterpatientreferrers['search'] ?? 0) == 1) ? 'checked' : '';
    $masterpatientreferrersDelete = (($masterpatientreferrers['delete'] ?? 0) == 1) ? 'checked' : '';

    //mastertreatmentpackages
    $mastertreatmentpackages = $rules['mastertreatmentpackages'] ?? [];
    $mastertreatmentpackagesIndex = (($mastertreatmentpackages['index'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesView = (($mastertreatmentpackages['view'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesAdd = (($mastertreatmentpackages['add'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesEdit = (($mastertreatmentpackages['edit'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesImport = (($mastertreatmentpackages['import'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesToggleActive = (($mastertreatmentpackages['toggleActive'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesSearch = (($mastertreatmentpackages['search'] ?? 0) == 1) ? 'checked' : '';
    $mastertreatmentpackagesDelete = (($mastertreatmentpackages['delete'] ?? 0) == 1) ? 'checked' : '';

    //registrations
    $beds = $rules['beds'];
    $bedsIndex = ($beds['index'] == 1) ? 'checked' : '';
    $bedsAdd = ($beds['add'] == 1) ? 'checked' : '';
    $bedsEdit = ($beds['edit'] == 1) ? 'checked' : '';
    $bedsDelete = ($beds['delete'] == 1) ? 'checked' : '';

    //personresponsibles
    $personresponsibles = $rules['personresponsibles'];
    $personresponsiblesIndex = ($personresponsibles['index'] == 1) ? 'checked' : '';
    $personresponsiblesAdd = ($personresponsibles['add'] == 1) ? 'checked' : '';
    $personresponsiblesEdit = ($personresponsibles['edit'] == 1) ? 'checked' : '';
    $personresponsiblesDelete = ($personresponsibles['delete'] == 1) ? 'checked' : '';

}
?>
<?= $this->Form->create($users) ?>
<div class="row">
    <!-- begin col-6 -->
    <div class="col-lg-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Perincian</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                        data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Code</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('id', array('type' => 'hidden', 'value' => $users->id));
                        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                        echo $this->Form->control('code', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Kode..', 'value' => $users->code, 'disabled' => true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Nama</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('name', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Nama..', 'value' => $users->name, 'disabled' => true]);
                        $person = [
                            'name' => 'Michael',
                            'age' => '3 mau tau aja',
                            'city' => 'London',
                            'country' => 'England'
                        ];
                        $string = 'Hi my name is {{country}}, I am {{age}} years old,tinggal di {{city}} negara yang keren {{name}}';

                        $string = preg_replace_callback('/\G((?:[^{\\]|\\.|{[^{])*){{((?:[^}\\]|\\.|}[^}])+)}}/', function ($match) use ($person) {
                            return $match[1] . $person[$match[2]];
                        }, $string);

                        echo $string . "\n";

                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Telp</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('telp', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Telp..', 'value' => $users->telp, 'readonly' => true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Email</label>
                    <div class="col-md-9">
                        <?php
                        echo $this->Form->control('email', ['label' => false, 'class' => 'form-control-plaintext', 'placeholder' => 'Email..', 'value' => $users->email, 'disabled' => true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15 align-items-center">
                    <label class="col-form-label col-md-3">Aktif</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedBlock = ($users->is_active == 'Y') ? "checked" : false;
                            echo $this->Form->hidden('is_active', array('value' => 'N'));
                            echo $this->Form->input('is_active', array('hiddenField' => false, 'value' => 'Y', 'id' => 'defaultCheckbox', 'type' => 'checkbox', 'class' => 'form-check-input', 'checked' => $checkedBlock));
                            ?>
                            <label class="form-check-label" for="defaultCheckbox">&nbsp;</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Staff</label>
                    <div class="col-md-9">
                        <?php
                        $dataStaff = $this->Krs->position();
                        echo $this->Form->control('staff', ['label' => false, 'empty' => false, 'options' => $dataStaff, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2Form', 'error' => false, "default" => $users->staff]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Devisi</label>
                    <div class="col-md-9">
                        <?php
                        $dataDevision = $this->Krs->devision();
                        echo $this->Form->control('devision', ['label' => false, 'empty' => false, 'options' => $dataDevision, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2Form', 'error' => false, "default" => $users->devision]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">UBS SCM</label>
                    <div class="col-md-9">
                        <?php
                        $dataProject = $this->Krs->dataUbs();
                        echo $this->Form->control('ubs', ['label' => false, 'empty' => false, 'options' => $dataProject, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2Form', 'error' => false, "default" => $users->ubs]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">UBS</label>
                    <div class="col-md-9">
                        <?php
                        $dataProject = $this->Krs->businessUnit();
                        echo $this->Form->control('project', ['label' => false, 'empty' => false, 'options' => $dataProject, 'data-placeholder' => 'Silakan pilih..', 'class' => 'form-control select2Form', 'error' => false, "default" => $users->project]);
                        ?>
                    </div>
                </div>

                <div class="form-group row m-b-15 align-items-center">
                    <label class="col-form-label col-md-3">UBS Status</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedProject = ($users->project_status == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('projectStatus', array('hiddenField' => 'N', 'value' => 'Y', 'id' => 'defaultCheckbox', 'class' => 'form-check-input', 'checked' => $checkedProject));
                            ?>
                            <label class="form-check-label" for="defaultCheckbox">Full Akses</label>
                        </div>
                    </div>
                </div>


                <div class="form-group row m-b-15">
                    <label class="col-md-3 col-form-label">Petty Cash</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedApproved1 = ($users->approved == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('approved', array('hiddenField' => 'N', 'value' => 'Y', 'id' => 'checkbox-inline-1', 'class' => 'form-check-input', 'checked' => $checkedApproved1));

                            // echo $this->Form->hidden('approved', array('value' => 'N'));
                            // echo $this->Form->input('approved', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-1', 'checked'=>$checkedApproved1));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-1">Approved 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedApproved2 = ($users->approvedCeo == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('approvedCeo', array('hiddenField' => 'N', 'value' => 'Y', 'id' => 'checkbox-inline-2', 'class' => 'form-check-input', 'checked' => $checkedApproved2));

                            // echo $this->Form->hidden('approvedCeo', array('value' => 'N'));
                            // echo $this->Form->input('approvedCeo', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-2', 'checked'=>$checkedApproved2));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-2">Approved 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedPayment = ($users->payment == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('payment', array('hiddenField' => 'N', 'value' => 'Y', 'id' => 'checkbox-inline-3', 'class' => 'form-check-input', 'checked' => $checkedPayment));

                            // echo $this->Form->hidden('payment', array('value' => 'N'));
                            // echo $this->Form->input('payment', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-2', 'checked'=>$checkedPayment));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-3">Pembayaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedFullAccess = ($users->pettycash_full_access == 'Y') ? "checked" : false;
                            echo $this->Form->checkbox('pettycash_full_access', array('hiddenField' => 'N', 'value' => 'Y', 'id' => 'checkbox-inline-4', 'class' => 'form-check-input', 'checked' => $checkedFullAccess));

                            // echo $this->Form->hidden('pettycash_full_access', array('value' => 'N'));
                            // echo $this->Form->input('pettycash_full_access', array('hiddenField'=>false, 'value' => 'Y', 'type' => 'checkbox', 'class'=>'form-check-input', 'id'=>'checkbox-inline-2', 'checked'=>$checkedFullAccess));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-4">Full Akses</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Cabang</label>
                    <div class="col-md-9">
                        <?php
                        $dataBranch = explode(",", $users->branch_id);
                        // pr($rowBranch);
                        // pr($users->branch_id);
                        // $dataBranch = explode(",", $users["branch_id"]);
                        echo $this->Form->control('branch_ids', array('label' => false, 'empty' => false, 'options' => $rowBranch, 'data-placeholder' => 'Cabang..', 'class' => 'form-control select2Form', 'error' => false, 'multiple' => true, "default" => $dataBranch));
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right bg-orange">
                <?php
                // Hidden Dashboard
                echo $this->Form->control('Rules.dashboard.index', ['type' => 'hidden', 'value' => '1']);

                // Item
                echo $this->Form->input('Rules.items.getList', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.items.getSupplier', ['type' => 'hidden', 'value' => '1']);

                // Medicine
                echo $this->Form->input('Rules.medicines.getList', ['type' => 'hidden', 'value' => '1']);

                // Hidden User
                echo $this->Form->control('Rules.auth.index', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.daerahkabupatens.getList', ['type' => 'hidden', 'value' => '1']);

                echo $this->Form->control('Rules.auth.login', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.auth.logout', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.users.changePassword', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.users.status', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.account.login', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.users.home', ['type' => 'hidden', 'value' => '1']);

                // Hidden Branch
                echo $this->Form->control('Rules.branches.getData', ['type' => 'hidden', 'value' => '1']);

                // Hidden Accounting
                echo $this->Form->input('Rules.accchartofaccounts.getCoa', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->input('Rules.accchartofaccounts.getList', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->control('Rules.accchartofaccounts.getSelect', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.accchartofaccounts.getData', ['type' => 'hidden', 'value' => '1']);


                // Hidden Accounting
                echo $this->Form->input('Rules.accchartofaccounts.getCoa', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->input('Rules.accchartofaccounts.getList', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->control('Rules.accchartofaccounts.getSelect', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.accchartofaccounts.getData', ['type' => 'hidden', 'value' => '1']);

                echo $this->Form->control('Rules.banktopups.getList', ['type' => 'hidden', 'value' => '1']);

                // Acc Journal
                echo $this->Form->input('Rules.accjournals.addCart', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournals.addCartOne', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournals.checkcodeByType', ['type' => 'hidden', 'value' =>  '1']);

                echo $this->Form->input('Rules.accjournals.getCoaFromJournalEdit', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournallines.editManyDatatable', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournallines.add', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournallines.edit', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournallines.delete', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->input('Rules.accjournallines.getGeneralJournal', ['type' => 'hidden', 'value' =>  '1']);

                //Hidden Bank Accounts
                echo $this->Form->control('Rules.bankaccounts.getBankAccount', ['type' => 'hidden', 'value' =>  '1']);

                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <ul class="nav nav-tabs nav-tabs-inverse">
            <li class="nav-item">
                <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                    <span class="d-sm-none">Data</span>
                    <span class="d-sm-block d-none">Data</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Pendaftaran Pasien</span>
                    <span class="d-sm-block d-none">Pendaftaran Pasien</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Laporan</span>
                    <span class="d-sm-block d-none">Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Master</span>
                    <span class="d-sm-block d-none">Master</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-5" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Pengaturan</span>
                    <span class="d-sm-block d-none">Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-6" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">ACC</span>
                    <span class="d-sm-block d-none">ACC</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- begin tab-pane -->
            <div class="tab-pane fade active show" id="default-tab-1">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?= $ruleRow('Order MCU', 'ordermcus', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Orders MCU', 'ordersmcus', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Order Penunjang', 'ordersupports', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Order Operasi', 'ordersurgeries', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Rencana Pembelian Farmasi', 'rencanapembelians', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                            'ambilDetail' => 'Ambil Detail',
                        ]) ?>
                        <?= $ruleRow('Order Pembelian Farmasi', 'orderpembelians', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('BAPB / Invoice Farmasi', 'invoices', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                            'cariBapb' => 'Cari BAPB',
                        ]) ?>
                        <?= $ruleRow('Detail BAPB / Invoice', 'invoicedetails', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Retur Pembelian Farmasi', 'returpembelians', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Informasi Stok Obat', 'medicinestocks', [
                            'index' => 'Daftar',
                            'toggleValid' => 'Validasi',
                        ]) ?>
                        <?= $ruleRow('Kartu Stok Obat', 'kartustok', [
                            'index' => 'Daftar',
                            'searchMedicine' => 'Cari Obat',
                        ]) ?>

                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="default-tab-2">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Manifest</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.viewManifest', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestViewManifest, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.pdfManifest', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestPdfManifest, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.pdfManifestWarehouse', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestPdfManifestWarehouse, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF Gudang</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.pdfManifestWarehouseShip', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestPdfManifestWarehouseShip, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF Kapal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.xlsHutang', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestXlsHutang, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Hutang)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.cancel', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestCancel, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Batal</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Invoice</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdfOld', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdfOld, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF Lama</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdfPayment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdfPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Antrian</td>
                            <td>
                                <div class="col-md-12">

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinicqueues.index', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $polyclinicqueuesIndex,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinicqueues.add', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $polyclinicqueuesAdd,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinicqueues.edit', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $polyclinicqueuesEdit,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinicqueues.delete', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $polyclinicqueuesDelete,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinicqueues.kiosk', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $polyclinicqueuesKiosk,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Kiosk</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinicqueues.wa', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $polyclinicqueuesWa,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Wa</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Pendaftaran pasien</td>
                            <td>
                                <div class="col-md-12">

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.registrations.index', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $registrationsIndex,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.registrations.add', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $registrationsAdd,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.registrations.edit', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $registrationsEdit,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.registrations.delete', [
                                            'value' => '1',
                                            'hiddenField' => true,
                                            'checked' => $registrationsDelete,
                                            'class' => 'form-check-input'
                                        ]);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <?= $ruleCheckbox('registrations', 'getSummary', 'Ringkasan') ?>
                                    <?= $ruleCheckbox('patientadmissions', 'index', 'Admission') ?>
                                </div>
                            </td>
                        </tr>
                        <?= $ruleRow('Riwayat Pasien', 'patienthistories', [
                            'index' => 'Daftar',
                            'searchPatients' => 'Cari Pasien',
                            'periksa' => 'Periksa',
                            'history' => 'Riwayat',
                        ]) ?>
                        <?= $ruleRow('Rekam Medis', 'medicalrecords', [
                            'index' => 'Daftar',
                            'history' => 'Riwayat',
                            'searchPatients' => 'Cari Pasien',
                            'backfillNoRm' => 'Backfill No RM',
                        ]) ?>
                        <?= $ruleRow('Diagnosa Rekam Medis', 'medicalrecorddiagnoses', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('RM Rawat Inap', 'medicalrecordinpatients', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('RM Rawat Jalan/IGD', 'medicalrecordoutpatientigds', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Resume Medis', 'medicalresumes', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <tr>
                            <td>Rawat Jalan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.index', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.view', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.add', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.cppt', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsCppt, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">CPPT</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.emr', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsEmr, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">EMR</label>
                                    </div>
                                    <?= $ruleCheckbox('outpatientvisits', 'resumeMedis', 'Resume Medis') ?>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.selesai', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsSelesai, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Selesai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.panggil', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsPanggil, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Panggil</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.batal', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsBatal, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Batal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.getSummary', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsGetSummary, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ringkasan</label>
                                    </div>
                                    <?= $ruleCheckbox('outpatientvisits', 'searchIcd10', 'Cari ICD-10') ?>
                                    <?= $ruleCheckbox('outpatientvisits', 'searchIcd9', 'Cari ICD-9') ?>
                                    <?= $ruleCheckbox('outpatientvisits', 'selesaiPeriksa', 'Selesai Periksa') ?>
                                    <?= $ruleCheckbox('outpatientvisits', 'hasilPemeriksaan', 'Hasil Pemeriksaan') ?>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.outpatientvisits.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $outpatientvisitsDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?= $ruleRow('Catatan CPPT', 'outpatientcpptnotes', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('EMR Rawat Jalan', 'outpatientvisitemr', [
                            'emr' => 'EMR',
                        ]) ?>
                        <?= $ruleRow('Surat Rawat Jalan', 'outpatientletters', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                            'getSuratSakit' => 'Ambil Surat Sakit',
                            'simpanSuratSakit' => 'Simpan Surat Sakit',
                            'getSuratKonsultasi' => 'Ambil Surat Konsultasi',
                            'simpanSuratKonsultasi' => 'Simpan Surat Konsultasi',
                            'getSuratJawabanKonsultasi' => 'Ambil Jawaban Konsultasi',
                            'simpanSuratJawabanKonsultasi' => 'Simpan Jawaban Konsultasi',
                            'cetakSuratKonsultasi' => 'Cetak Surat Konsultasi',
                            'cetakSuratSakit' => 'Cetak Surat Sakit',
                        ]) ?>
                        <tr>
                            <td>Rawat Inap</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.inpatiententries.index', ['value' => '1', 'hiddenField' => true, 'checked' => $inpatiententriesIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.inpatiententries.view', ['value' => '1', 'hiddenField' => true, 'checked' => $inpatiententriesView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.inpatiententries.add', ['value' => '1', 'hiddenField' => true, 'checked' => $inpatiententriesAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.inpatiententries.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $inpatiententriesEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.inpatiententries.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $inpatiententriesDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        /*
                        <tr>
                            <td>Berita Acara</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rpt_berita_acara', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRpt_berita_acara, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdf_berita_acara', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdf_berita_acara, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.view_berita_acara', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_view_berita_acara, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Faktur Pajak</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rpt_tax_invoice', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRpt_tax_invoice, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdf_tax_invoice', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdf_tax_invoice, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.view_tax_invoice', ['value' => '1', 'hiddenField' => true, 'checked' => $invoice_view_tax_invoice, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Surat Penawaran</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.offers.print_list', ['value' => '1', 'hiddenField' => true, 'checked' => $offer_print_list, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.offers.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $offerPdf, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        */
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- end tab-pane -->
            <div class="tab-pane fade" id="default-tab-3">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Laporan Record Pembayaran</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.reportRecordPayment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceReportRecordPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.saveRecordPayment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceSaveRecordPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xlsRecordPayment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXlsRecordPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Manifest</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.rptRekapManifests', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestRptRekapManifests, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.xlsRekapManifest', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestXlsRekapManifest, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.xlsRekapManifestKlh', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestXlsRekapManifestKlh, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel KLH</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.rptRekapManifestProcessor', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestRptRekapManifestProcessor, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Manifest & Pengolah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.xlsRekapManifestProcessor', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestXlsRekapManifestProcessor, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Manifest & Pengolah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.editReceived', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestEditReceived, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Tgl Terima</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.jumlahPengangkutanReport', ['value' => '1', 'hiddenField' => true, 'checked' => $customerJumlahPengangkutanReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jumlah Pengangkutan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.jumlahPengangkutanReportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $customerJumlahPengangkutanReportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jumlah Pengangkutan (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.jumlahPengangkutanReportCs', ['value' => '1', 'hiddenField' => true, 'checked' => $customerJumlahPengangkutanReportCs, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jumlah Pengangkutan-CS</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.jumlahPengangkutanReportXlsCs', ['value' => '1', 'hiddenField' => true, 'checked' => $customerJumlahPengangkutanReportXlsCs, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jumlah Pengangkutan-CS (Excel)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Invoice Hutang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.rekap', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangRekap, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Hutang Limbah</label>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Invoice</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapInvoice', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapInvoice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapInvoiceXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapInvoiceXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rptRekapTaxInvoice', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRptRekapTaxInvoice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Faktur</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xlsRekapTaxInvoice', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXlsRekapTaxInvoice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Faktur</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rptLabaRugi', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRptLabaRugi, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laba/Rugi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xlsLabaRugi', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXlsLabaRugi, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Laba/Rugi</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapInvoiceFull', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapInvoiceFull, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Full</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapInvoiceFullXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapInvoiceFullXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Full</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapPiutang', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapPiutang, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Piutang</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapPiutangXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapPiutangXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Piutang (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapPiutangPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapPiutangPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Piutang (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapPiutangRsud', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapPiutangRsud, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Piutang RSUD</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapPiutangRsudXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapPiutangRsudXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Piutang RSUD (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rekapPiutangRsudPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRekapPiutangRsudPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Piutang RSUD (PDF)</label>
                                    </div>
                                    <?php
                                    /*
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdfLabaRugi', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdfLabaRugi, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF Laba/Rugi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.reportLabaRugiMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdfLabaRugiMulti, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laba/Rugi (Multi)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xlsLabaRugiMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXlsLabaRugiMulti, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Laba/Rugi (Multi)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdfLabaRugiMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdfLabaRugiMulti, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF Laba/Rugi (Multi)</label>
                                    </div>
                                    */
                                    ?>





                                </div>
                            </td>
                        </tr>
                        <?php
                        /*
                        <tr>
                            <td>Keuangan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.rpt_keuangan', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceRpt_keuangan, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xls_keuangan', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXls_keuangan, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <?php
                                    //<div class="form-check form-check-inline">
                                    //  <?php
                                    //  echo $this->Form->checkbox('Rules.commissions.rptCommission', ['value' => '1', 'hiddenField' => true, 'checked' => $commission_rptCommission, 'class'=>'form-check-input']); 
                                    //  ?>
                                    //  <label class="form-check-label">Komisi</label>
                                    //</div>

                                    ?>
                                </div>
                            </td>
                        </tr>
                        */
                        ?>
                        <?php
                        /*
                        <tr>
                            <td>Pelunasan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.reportPayment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceReportPayment, 'class'=>'form-check-input']); 
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Laporan AR</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.report_ar', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceReport_ar, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xls_ar', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXls_ar, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        */
                        ?>
                        <?php
                        /*
                        <tr>
                            <td>Biaya Operasional</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.operationals.rpt_biaya', ['value' => '1', 'hiddenField' => true, 'checked' => $operational_rpt_biaya, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.operationals.xls_biaya', ['value' => '1', 'hiddenField' => true, 'checked' => $operationalXls_biaya, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>LED</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.report_led', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceReport_led, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Manifest Keluar</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.report_logbook_out', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestReport_logbook_out, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Logbook</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        */
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="default-tab-4">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Supplier</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliers.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliers.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliers.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Doctor</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctors.index', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctors.add', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctors.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctors.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorsPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctors.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctors.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Doctor Schedule</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctorschedules.index', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorschedulesIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctorschedules.add', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorschedulesAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctorschedules.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorschedulesEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctorschedules.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorschedulesPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctorschedules.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorschedulesDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.doctorschedules.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $doctorschedulesDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Room</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.index', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.add', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.monitoring', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsMonitoring, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Monitoring</label>
                                    </div>

                                    <!-- <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.rooms.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $roomsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div> -->
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Beds</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.beds.index', ['value' => '1', 'hiddenField' => true, 'checked' => $bedsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.beds.add', ['value' => '1', 'hiddenField' => true, 'checked' => $bedsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.beds.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $bedsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.beds.delete',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $bedsDelete,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Polyclinics</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinics.index', ['value' => '1', 'hiddenField' => true, 'checked' => $polyclinicsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinics.add', ['value' => '1', 'hiddenField' => true, 'checked' => $polyclinicsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinics.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $polyclinicsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinics.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $polyclinicsPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinics.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $polyclinicsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.polyclinics.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $polyclinicsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>patients</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.patients.index', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.patients.add', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.patients.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.patients.view', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsView, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.patients.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.patients.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Health Facilities</td>

                            <td>
                                <div class="col-md-12">

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.index',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesIndex,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.add',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesAdd,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.edit',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesEdit,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.view',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesView,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.delete',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesDelete,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.dataExportImport',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesDataExportImport,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">
                                            Simpan (Xls-Import)
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?=
                                            $this->Form->checkbox(
                                                'Rules.healthfacilities.dataExportImportXls',
                                                [
                                                    'value' => '1',
                                                    'hiddenField' => true,
                                                    'checked' => $healthfacilitiesDataExportImportXls,
                                                    'class' => 'form-check-input'
                                                ]
                                            );
                                        ?>
                                        <label class="form-check-label">
                                            Download (Xls-Import-Example)
                                        </label>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>insurances</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.insurances.index', ['value' => '1', 'hiddenField' => true, 'checked' => $insurancesIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.insurances.add', ['value' => '1', 'hiddenField' => true, 'checked' => $insurancesAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.insurances.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $insurancesEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.insurances.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $insurancesPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.insurances.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $insurancesDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.insurances.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $insurancesDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Pharmacy Items</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pharmacyitems.index', ['value' => '1', 'hiddenField' => true, 'checked' => $pharmacyitemsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pharmacyitems.add', ['value' => '1', 'hiddenField' => true, 'checked' => $pharmacyitemsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pharmacyitems.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $pharmacyitemsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pharmacyitems.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $pharmacyitemsPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pharmacyitems.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $pharmacyitemsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pharmacyitems.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $pharmacyitemsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master Tindakan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.view', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.search', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanSearch, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.searchDebug', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanSearchDebug, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Debug</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertindakan.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertindakanDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master Laboratories</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.index', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.view', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Lihat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.add', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.import', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesImport, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.search', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesSearch, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterlaboratories.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $masterlaboratoriesDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master Radiologies</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.index', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.view', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Lihat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.add', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.import', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesImport, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.search', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesSearch, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterradiologies.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $masterradiologiesDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master Penjamins</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.index', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsIndex, 'class' =>'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.view', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Lihat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.add', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.import', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsImport, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.search', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsSearch, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpenjamins.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpenjaminsDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master Perujuk Pasien</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.view', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Lihat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.import', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersImport, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.search', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersSearch, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.masterpatientreferrers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $masterpatientreferrersDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master Paket Tindakan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesIndex, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.view', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesView, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Lihat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesAdd, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesEdit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.import', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesImport, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.search', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesSearch, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastertreatmentpackages.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $mastertreatmentpackagesDelete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master ICD-9 CM</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd9.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd9Index, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd9.view', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd9View, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Lihat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd9.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd9Add, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd9.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd9Edit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd9.import', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd9Import, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd9.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd9ToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.search', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Search, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Delete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Master ICD-10</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Index, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.view', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10View, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Add, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Edit, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.import', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Import, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Import</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.toggleActive', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10ToggleActive, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.search', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Search, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Cari</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php echo $this->Form->checkbox('Rules.mastericd10.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $mastericd10Delete, 'class' => 'form-check-input']); ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?= $ruleRow('Master Jenis MCU', 'mastermcutypes', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Master Jenis Operasi', 'masteroperationtypes', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Master Penunjang', 'mastersupports', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <?= $ruleRow('Master Operator Bedah', 'mastersurgeryoperators', [
                            'index' => 'Daftar',
                            'view' => 'Tampilkan',
                            'add' => 'Tambah',
                            'edit' => 'Ubah',
                            'delete' => 'Hapus',
                        ]) ?>
                        <tr>
                            <td>nutritionmenus</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenus.index', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenusIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenus.add', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenusAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenus.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenusEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenus.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenusPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenus.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenusDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenus.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenusDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>nutritioncombine</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombine.index', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombineIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombine.add', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombineAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombine.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombineEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombine.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinePreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>nutritionmenutypes</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenutypes.index', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenutypesIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenutypes.add', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenutypesAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenutypes.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenutypesEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenutypes.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenutypesPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenutypes.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenutypesDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritionmenutypes.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritionmenutypesDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Person Responsibles</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.personresponsibles.index', ['value' => '1', 'hiddenField' => true, 'checked' => $personresponsiblesIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.personresponsibles.add', ['value' => '1', 'hiddenField' => true, 'checked' => $personresponsiblesAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.personresponsibles.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $personresponsiblesEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.personresponsibles.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $personresponsiblesPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.personresponsibles.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $personresponsiblesDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.personresponsibles.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $personresponsiblesDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Obat</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.index', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.add', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.view', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineView, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicines.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Obat (UBS)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.index', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.add', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.view', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsView, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubs.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Obat (UBS) Upload</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.index', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.add', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.view', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadView, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicineubsuploads.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineUbsUploadDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Obat (Merk)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinemerks.index', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineMerkIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinemerks.add', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineMerkAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinemerks.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineMerkEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinemerks.view', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineMerkView, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinemerks.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineMerkDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Obat (Group)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinegroups.index', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineGroupIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinegroups.add', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineGroupAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinegroups.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineGroupEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinegroups.view', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineGroupView, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.medicinegroups.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $medicineGroupDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>

                                </div>
                            </td>
                        </tr>



















                        <tr>
                            <td>Barang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.items.index', ['value' => '1', 'hiddenField' => true, 'checked' => $itemIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.items.add', ['value' => '1', 'hiddenField' => true, 'checked' => $itemAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.items.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $itemEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.items.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $itemDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.items.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $itemDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.items.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $itemDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Barang (UBS)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubs.index', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubs.add', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubs.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubs.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubs.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $itemUbsDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubs.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $itemUbsDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Barang (UBS) Upload</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubsuploads.index', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsuploadIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubsuploads.add', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsuploadAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubsuploads.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsuploadEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.itemubsuploads.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $itemubsuploadDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Lokasi Penempatan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.placements.index', ['value' => '1', 'hiddenField' => true, 'checked' => $placementIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.placements.add', ['value' => '1', 'hiddenField' => true, 'checked' => $placementAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.placements.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $placementEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $customerIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $customerPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.upload', ['value' => '1', 'hiddenField' => true, 'checked' => $customerUpload, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Upload</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $customerAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $customerEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.editAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $customerEditAdmin, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah(admin)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $customerXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.xlsAll', ['value' => '1', 'hiddenField' => true, 'checked' => $customerXlsAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.xlsRekap', ['value' => '1', 'hiddenField' => true, 'checked' => $customerXlsRekap, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $customerDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.bankData', ['value' => '1', 'hiddenField' => true, 'checked' => $customerBankData, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">data Bank</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.status', ['value' => '1', 'hiddenField' => true, 'checked' => $customerStatus, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.beginningBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $customerBeginningBalance, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Awal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.beginningBalanceXls', ['value' => '1', 'hiddenField' => true, 'checked' => $customerBeginningBalanceXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Awal (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.statusPractice', ['value' => '1', 'hiddenField' => true, 'checked' => $customerStatusPractice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status (Hari & Jam Praktek)</label>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Pengolah</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.processors.index', ['value' => '1', 'hiddenField' => true, 'checked' => $processorIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.processors.add', ['value' => '1', 'hiddenField' => true, 'checked' => $processorAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.processors.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $processorEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.processors.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $processorDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Transport</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.transporters.index', ['value' => '1', 'hiddenField' => true, 'checked' => $transporterIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.transporters.add', ['value' => '1', 'hiddenField' => true, 'checked' => $transporterAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.transporters.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $transporterEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.transporters.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $transporterDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Truk</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.trucks.index', ['value' => '1', 'hiddenField' => true, 'checked' => $truckIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.trucks.add', ['value' => '1', 'hiddenField' => true, 'checked' => $truckAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.trucks.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $truckEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.trucks.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $truckDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Driver & Helper</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.drivers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $driverIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.drivers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $driverAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.drivers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $driverEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.drivers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $driverDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Limbah</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.index', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.add', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.editPrice', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteEditPrice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Harga</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Menyetujui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.xlsWaste', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteXlsWaste, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastes.xlsWasteAll', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteXlsWasteAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Semua Excel</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Limbah</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.index', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.add', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.editPrice', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeEditPrice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Harga</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Menyetujui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Unduh (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.xlsWaste', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeXlsWaste, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wastetypes.xlsWasteAll', ['value' => '1', 'hiddenField' => true, 'checked' => $wasteTypeXlsWasteAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Semua Excel</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Harga Limbah</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wasteprices.index', ['value' => '1', 'hiddenField' => true, 'checked' => $wastePriceIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wasteprices.add', ['value' => '1', 'hiddenField' => true, 'checked' => $wastePriceAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wasteprices.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $wastePriceEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wasteprices.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $wastePriceDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wasteprices.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $wastePriceXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.wasteprices.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $wastePricePdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Order Regular</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderregulars.index', ['value' => '1', 'hiddenField' => true, 'checked' => $orderRegularIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderregulars.add', ['value' => '1', 'hiddenField' => true, 'checked' => $orderRegularAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderregulars.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $orderRegularEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderregulars.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $orderRegularDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Tema</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.templates.index', ['value' => '1', 'hiddenField' => true, 'checked' => $templateIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.templates.add', ['value' => '1', 'hiddenField' => true, 'checked' => $templateAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.templates.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $templateEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.templates.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $templateDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="default-tab-5">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cabang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.index', ['value' => '1', 'hiddenField' => true, 'checked' => $branchIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.add', ['value' => '1', 'hiddenField' => true, 'checked' => $branchAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $branchEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $branchDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Seting</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.settings.index', ['value' => '1', 'hiddenField' => true, 'checked' => $settingIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.settings.add', ['value' => '1', 'hiddenField' => true, 'checked' => $settingAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.settings.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $settingEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.index', ['value' => '1', 'hiddenField' => true, 'checked' => $userIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.add', ['value' => '1', 'hiddenField' => true, 'checked' => $userAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $userEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.access', ['value' => '1', 'hiddenField' => true, 'checked' => $userAccess, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hak Akses</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.resetPassword', ['value' => '1', 'hiddenField' => true, 'checked' => $userResetPassword, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Reset Sandi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $userDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="default-tab-6">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Perkiraan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.index', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.add', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.addGroup', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountAddGroup, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Kelompok)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.group', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountGroup, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar (Kelompok)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.moveUp', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountMoveUp, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Naik Level</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.moveDown', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountMoveDown, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Turun Level</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.statusSubmission', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountStatusSubmission, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status (Permintaan Dana)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.beginningBalanceExportImport', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountBeginningBalanceExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Awal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.beginningBalanceExportImportXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountBeginningBalanceExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Awal - Unduh (Xls)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.templateExcel', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountTemplateExcel, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Template Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.importExcel', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountImportExcel, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Import Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.endingBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountEndingBalance, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Akhir (COA)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Jurnal</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.index', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar (Detail)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.indexShort', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalIndexShort, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.add', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.addMany', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalAddMany, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Banyak)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.addOnlyOne', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalAddOnlyOne, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Satu)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.editMany', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalEditMany, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Banyak</label>
                                        
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.accJournalPostingSave', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPostingSave, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Posting</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournalOld', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournalOld, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Export/Import Journal (Kode Lama)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournalOldXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournalOldXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Export/Import Journal (Kode Lama)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Export/Import Journal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournalXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournalXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Export/Import Journal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.rekapJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalRekapJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Jurnal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfRekapJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfRekapJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Jurnal (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsRekapJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsRekapJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Jurnal (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreview, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.previewXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreviewXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Unduh (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.import', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalImport, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Import (Melalui Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.importExampleXls', ['value' => 1, 'hiddenField' => true, 'checked' =>  $accJournalImportExampleXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Import (Contoh Excel)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Jurnal (Admin)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJurnalPiutangManifestAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJurnalPiutangManifestAdmin, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Manifest (Piutang)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJurnalPaymentInvoiceAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJurnalPaymentInvoiceAdmin, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Invoice (Pembayaran)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJurnalDepositInvoiceAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJurnalDepositInvoiceAdmin, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Invoice (Deposit)</label>
                                    </div>                              
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Penyetor/Penerima</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.recipientpayers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $recipientPayerIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.recipientpayers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $recipientPayerAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.recipientpayers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $recipientPayerEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Posting</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.postingSave', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPostingSave, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportPosting', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportPosting, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.previewPosting', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreviewPosting, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.editPosting', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalEditPosting, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Kas/Bank</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.previewPrintCashBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreviewPrintCashBank, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportPrintCashBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportPrintCashBank, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.printCashBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPrintCashBank, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Kas</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportSummaryCash', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportSummaryCash, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Rekap</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Laba/Rugi</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncome', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncome, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncome', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncome, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncome', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncome, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeGlobalReport', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalIncomeGlobalReport, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Global)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeGlobal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeGlobal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Global)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeGlobal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeGlobal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Global)</label>
                                    </div>
                                    <!-- <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeMulti, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Multi)</label>
                                    </div> -->
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeMultiReport', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalIncomeMultiReport, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Multi)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeMulti, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Multi)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeMulti, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Multi)</label>
                                    </div>
                                    <?php 
                                    //Tahun 2019
                                    ?>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeGlobal2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeGlobal2019, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Global) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeGlobal2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeGlobal2019, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Global) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeGlobal2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeGlobal2019, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Global) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeMulti2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeMulti2019, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Multi) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeMulti2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeMulti2019, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Multi) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeMulti2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeMulti2019, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Multi) 2019</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Jurnal Umum</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.generalJournalReport', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalGeneralJournalReport, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Jurnal</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJournalXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJournalXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.printJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPrintJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsJournal, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Buku Besar</td>
                            <td>
                                <div class="col-md-12">
                                    <!-- <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportGeneralLedger', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportGeneralLedger, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div> -->
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.generalLedgerReport', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalGeneralLedgerReport, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfGeneralLedger', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfGeneralLedger, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsGeneralLedger', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsGeneralLedger, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Neraca</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.balanceSheetPercentReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalBalanceSheetPercentReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.balanceSheetPercentXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalBalanceSheetPercentXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar (Xls)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.trialBalanceReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalTrialBalanceReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo (Daftar)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.trialBalanceXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalTrialBalanceXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.workSheetBalanceReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalWorkSheetBalanceReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Neraca Lajur</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.workSheetBalanceReportXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalWorkSheetBalanceReportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Neraca Lajur (Excel)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Neraca Biasa</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportOrdinaryBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportOrdinaryBalanceSheet, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsOrdinaryBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsOrdinaryBalanceSheet, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfOrdinaryBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfOrdinaryBalanceSheet, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Neraca % (2019)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportPercentBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportPercentBalanceSheet, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsPercentBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsPercentBalanceSheet, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfPercentBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfPercentBalanceSheet, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Neraca % (2020)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalanceSheetPercent', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalanceSheetPercent, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsBalanceSheetPercent', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsBalanceSheetPercent, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfBalanceSheetPercent', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfBalanceSheetPercent, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Laporan Neraca</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalance, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalanceXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalanceXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalancePdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalancePdf, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Analisa Keuangan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioLiquiditas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioLiquiditas, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Liquiditas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioLiquiditasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioLiquiditasXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Liquiditas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioLiquiditasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioLiquiditasPdf, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Liquiditas (PDF)</label>
                                    </div>
                                    
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioSolvabilitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioSolvabilitas, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Solvabilitas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioSolvabilitasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioSolvabilitasXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Solvabilitas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioSolvabilitasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioSolvabilitasPdf, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Solvabilitas (PDF)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioRentabilitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioRentabilitas, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Rentabilitas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioRentabilitasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioRentabilitasXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Rentabilitas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioRentabilitasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioRentabilitasPdf, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Rentabilitas (PDF)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioAktivitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioAktivitas, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Aktivitas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioAktivitasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioAktivitasXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Aktivitas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioAktivitasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioAktivitasPdf, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Aktivitas (PDF)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Neraca Saldo</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportTrialBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportTrialBalance, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsTrialBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsTrialBalance, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportTrialBalanceNew', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportTrialBalanceNew, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">(Laporan)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsTrialBalanceNew', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsTrialBalanceNew, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">(Laporan) Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfTrialBalanceNew', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfTrialBalanceNew, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">(Laporan) PDF</label>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Ekuitas</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportEkuitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportEkuitas, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsEkuitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsEkuitas, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Pindah Buku</td>
                            <td>
                                <div class="col-md-12">                                 
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.banktopups.index', ['value' => '1', 'hiddenField' => true, 'checked' => $banktopupsIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.banktopups.add', ['value' => '1', 'hiddenField' => true, 'checked' => $banktopupsAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.banktopups.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $banktopupsEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.banktopups.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $banktopupsDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.banktopups.view', ['value' => '1', 'hiddenField' => true, 'checked' => $banktopupsView, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.banktopups.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $banktopupsXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>                                                 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Bank Income</td>
                            <td>
                                <div class="col-md-12">                                 
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.bankincomes.index', ['value' => '1', 'hiddenField' => true, 'checked' => $bankincomesIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.bankincomes.add', ['value' => '1', 'hiddenField' => true, 'checked' => $bankincomesAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.bankincomes.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $bankincomesEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.bankincomes.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $bankincomesDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.bankincomes.view', ['value' => '1', 'hiddenField' => true, 'checked' => $bankincomesView, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.bankincomes.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $bankincomesXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>                                                 
                                </div>
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?= $this->Form->end() ?>
<script>
    $(document).ready(function () {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['controller' => 'users', 'action' => 'access', $users->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

        $(".select2Form").select2();

    });
</script>
