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

    // Branch
    $branch = $rules['branches'];
    $branchIndex = ($branch['index'] == 1) ? 'checked' : '';
    $branchAdd = ($branch['add'] == 1) ? 'checked' : '';
    $branchEdit = ($branch['edit'] == 1) ? 'checked' : '';
    $branchDelete = ($branch['delete'] == 1) ? 'checked' : '';

    // Supplier
    $supplier = $rules['suppliers'];
    $supplierIndex = ($supplier['index'] == 1) ? 'checked' : '';
    $supplierAdd = ($supplier['add'] == 1) ? 'checked' : '';
    $supplierPreview = ($supplier['preview'] == 1) ? 'checked' : '';
    $supplierEdit = ($supplier['edit'] == 1) ? 'checked' : '';
    //$supplierDelete = ($supplier['delete']==1) ? 'checked' : ''; 
    $supplierDataExportImportXls = ($supplier['dataExportImportXls'] == 1) ? 'checked' : '';
    $supplierDataExportImport = ($supplier['dataExportImport'] == 1) ? 'checked' : '';

    // Barang
    $item = $rules['items'];
    $itemIndex = ($item['index'] == 1) ? 'checked' : '';
    $itemAdd = ($item['add'] == 1) ? 'checked' : '';
    $itemEdit = ($item['edit'] == 1) ? 'checked' : '';
    $itemDelete = ($item['delete'] == 1) ? 'checked' : '';
    $itemDataExportImportXls = ($item['dataExportImportXls'] == 1) ? 'checked' : '';
    $itemDataExportImport = ($item['dataExportImport'] == 1) ? 'checked' : '';

    // Barang UBS
    $itemubs = $rules['itemubs'];
    $itemubsIndex = ($itemubs['index'] == 1) ? 'checked' : '';
    $itemubsAdd = ($itemubs['add'] == 1) ? 'checked' : '';
    $itemubsEdit = ($itemubs['edit'] == 1) ? 'checked' : '';
    $itemubsDelete = ($itemubs['delete'] == 1) ? 'checked' : '';
    $itemUbsDataExportImportXls = ($itemubs['dataExportImportXls'] == 1) ? 'checked' : '';
    $itemUbsDataExportImport = ($itemubs['dataExportImport'] == 1) ? 'checked' : '';

    // Barang UBS Upload
    $itemubsupload = $rules['itemubsuploads'];
    $itemubsuploadIndex = ($itemubsupload['index'] == 1) ? 'checked' : '';
    $itemubsuploadAdd = ($itemubsupload['add'] == 1) ? 'checked' : '';
    $itemubsuploadEdit = ($itemubsupload['edit'] == 1) ? 'checked' : '';
    $itemubsuploadDelete = ($itemubsupload['delete'] == 1) ? 'checked' : '';

    // Purchase of goods
    $purchaseofgood = $rules['purchaseofgoods'];
    $purchaseofgoodIndex = ($purchaseofgood['index'] == 1) ? 'checked' : '';
    $purchaseofgoodAdd = ($purchaseofgood['add'] == 1) ? 'checked' : '';
    $purchaseofgoodEdit = ($purchaseofgood['edit'] == 1) ? 'checked' : '';
    //$purchaseofgoodDelete = ($purchaseofgood['delete']==1) ? 'checked' : ''; 

    // Placement of goods
    $placementofgood = $rules['placementofgoods'];
    $placementofgoodIndex = ($placementofgood['index'] == 1) ? 'checked' : '';
    $placementofgoodAdd = ($placementofgood['add'] == 1) ? 'checked' : '';
    $placementofgoodEdit = ($placementofgood['edit'] == 1) ? 'checked' : '';
    //$placementofgoodDelete = ($placementofgood['delete']==1) ? 'checked' : ''; 

    // Placement
    $placement = $rules['placements'];
    $placementIndex = ($placement['index'] == 1) ? 'checked' : '';
    $placementAdd = ($placement['add'] == 1) ? 'checked' : '';
    $placementEdit = ($placement['edit'] == 1) ? 'checked' : '';
    //$placementDelete = ($placement['delete']==1) ? 'checked' : ''; 

    // Mutation
    $mutation = $rules['mutations'];
    $mutationIndex = ($mutation['index'] == 1) ? 'checked' : '';
    $mutationAdd = ($mutation['add'] == 1) ? 'checked' : '';
    $mutationEdit = ($mutation['edit'] == 1) ? 'checked' : '';
    //$mutationDelete = ($mutation['delete']==1) ? 'checked' : ''; 

    // Warehouse
    $warehouse = $rules['warehouses'];
    $warehouseIndex = ($warehouse['index'] == 1) ? 'checked' : '';
    $warehouseReceive = ($warehouse['receive'] == 1) ? 'checked' : '';
    $warehouseXls = ($warehouse['xls'] == 1) ? 'checked' : '';
    $warehouseAdd = ($warehouse['add'] == 1) ? 'checked' : '';
    // $warehouseEdit = ($warehouse['edit']==1) ? 'checked' : '';
// $warehouseDelete = ($warehouse['delete']==1) ? 'checked' : '';

    // Warehouse Receive
    $warehouseReceive = $rules['warehousereceives'];
    $warehouseReceiveIndex = ($warehouseReceive['index'] == 1) ? 'checked' : '';
    $warehouseReceiveEdit = ($warehouseReceive['edit'] == 1) ? 'checked' : '';
    $warehouseReceivePreview = ($warehouseReceive['preview'] == 1) ? 'checked' : '';
    // $warehouseReceiveXls = ($warehouseReceive['xls']==1) ? 'checked' : '';
    $warehouseReceiveAdd = ($warehouseReceive['add'] == 1) ? 'checked' : '';
    $warehouseReceiveAddDriver = ($warehouseReceive['addDriver'] == 1) ? 'checked' : '';

    // Customer
    $customer = $rules['customers'];
    $customerIndex = ($customer['index'] == 1) ? 'checked' : '';
    $customerAdd = ($customer['add'] == 1) ? 'checked' : '';
    $customerEdit = ($customer['edit'] == 1) ? 'checked' : '';
    $customerEditAdmin = ($customer['editAdmin'] == 1) ? 'checked' : '';
    $customerXls = ($customer['xls'] == 1) ? 'checked' : '';
    $customerXlsAll = ($customer['xlsAll'] == 1) ? 'checked' : '';
    $customerXlsRekap = ($customer['xlsRekap'] == 1) ? 'checked' : '';
    //$customerAddCommission = ($customer['addCommission']==1) ? 'checked' : '';
//$customerIndexCommission = ($customer['indexCommission']==1) ? 'checked' : '';
//$customerEditCommission = ($customer['editCommission']==1) ? 'checked' : '';
    $customerDelete = ($customer['delete'] == 1) ? 'checked' : '';
    $customerPreview = ($customer['preview'] == 1) ? 'checked' : '';
    $customerBankData = ($customer['bankData'] == 1) ? 'checked' : '';
    $customerUpload = ($customer['upload'] == 1) ? 'checked' : '';
    $customerStatus = ($customer['status'] == 1) ? 'checked' : '';
    $customerJumlahPengangkutanReport = ($customer['jumlahPengangkutanReport'] == 1) ? 'checked' : '';
    $customerJumlahPengangkutanReportXls = ($customer['jumlahPengangkutanReportXls'] == 1) ? 'checked' : '';
    $customerJumlahPengangkutanReportCs = ($customer['jumlahPengangkutanReportCs'] == 1) ? 'checked' : '';
    $customerJumlahPengangkutanReportXlsCs = ($customer['jumlahPengangkutanReportXlsCs'] == 1) ? 'checked' : '';
    $customerBeginningBalance = ($customer['beginningBalance'] == 1) ? 'checked' : '';
    $customerBeginningBalanceXls = ($customer['beginningBalanceXls'] == 1) ? 'checked' : '';
    $customerStatusPractice = ($customer['statusPractice'] == 1) ? 'checked' : '';

    //$customerPiutangPerCustomer = ($customer['piutangPerCustomer']==1) ? 'checked' : '';
//$customerPiutangPerCustomerXls = ($customer['piutangPerCustomerXls']==1) ? 'checked' : '';
//Processor
    $processor = $rules['processors'];
    $processorIndex = ($processor['index'] == 1) ? 'checked' : '';
    $processorAdd = ($processor['add'] == 1) ? 'checked' : '';
    $processorEdit = ($processor['edit'] == 1) ? 'checked' : '';
    $processorDelete = ($processor['delete'] == 1) ? 'checked' : '';

    //Transport
    $transporter = $rules['transporters'];
    $transporterIndex = ($transporter['index'] == 1) ? 'checked' : '';
    $transporterAdd = ($transporter['add'] == 1) ? 'checked' : '';
    $transporterEdit = ($transporter['edit'] == 1) ? 'checked' : '';
    $transporterDelete = ($transporter['delete'] == 1) ? 'checked' : '';

    // if(!empty($data['condition']['manifestdirects'])){
//  $manifestdirects = Set::reverse($data['condition']['manifestdirects']);
// }else{
//  $manifestdirects = array('index'=>0, 'add'=>0, 'report_out_excel'=>0, 'xls_out_excel'=>0);
// }
// $manifestDirectIndex = ($manifestdirects['index']==1) ? 'checked' : '';
// $manifestDirectAdd = ($manifestdirects['add']==1) ? 'checked' : '';
// $manifestDirect_report_out_excel = ($manifestdirects['report_out_excel']==1) ? 'checked' : '';
// $manifestDirectXls_out_excel = ($manifestdirects['xls_out_excel']==1) ? 'checked' : '';

    // $manifestDirectEdit = ($manifestdirects['edit']==1) ? 'checked' : '';
// $manifestDirectDelete = ($manifestdirects['delete']==1) ? 'checked' : '';


    // Truck
    $truck = $rules['trucks'];
    $truckIndex = ($truck['index'] == 1) ? 'checked' : '';
    $truckAdd = ($truck['add'] == 1) ? 'checked' : '';
    $truckEdit = ($truck['edit'] == 1) ? 'checked' : '';
    $truckDelete = ($truck['delete'] == 1) ? 'checked' : '';

    // Invoice Masuk
// $invoiceEntry = $rules['invoiceentries'];
// $invoice_entryIndex = ($invoiceEntry['index']==1) ? 'checked' : '';
// $invoice_entryAdd = ($invoiceEntry['add']==1) ? 'checked' : '';
// $invoice_entryEdit = ($invoiceEntry['edit']==1) ? 'checked' : '';
// $invoice_entryPayment = ($invoiceEntry['payment']==1) ? 'checked' : '';
// $invoice_entryPaymentEdit = ($invoiceEntry['paymentEdit']==1) ? 'checked' : '';
// $invoice_entryDelete = ($invoiceEntry['delete']==1) ? 'checked' : '';
// $invoice_entryXls = ($invoiceEntry['xls']==1) ? 'checked' : '';
// $invoice_entryDownloadMyerp = ($invoiceEntrie['downloadMyerp']==1) ? 'checked' : '';
// $invoice_entryXlsDownloadMyerp = ($invoiceEntrie['xlsDownloadMyerp']==1) ? 'checked' : '';

    // Driver
    $driver = $rules['drivers'];
    $driverIndex = ($driver['index'] == 1) ? 'checked' : '';
    $driverAdd = ($driver['add'] == 1) ? 'checked' : '';
    $driverEdit = ($driver['edit'] == 1) ? 'checked' : '';
    $driverDelete = ($driver['delete'] == 1) ? 'checked' : '';

    // Order
    $order = $rules['orders'];
    $orderIndex = ($order['index'] == 1) ? 'checked' : '';
    $orderAdd = ($order['add'] == 1) ? 'checked' : '';
    $orderEdit = ($order['edit'] == 1) ? 'checked' : '';
    $orderXls = ($order['xls'] == 1) ? 'checked' : '';
    $orderPdf = ($order['pdf'] == 1) ? 'checked' : '';
    $orderDelete = ($order['delete'] == 1) ? 'checked' : '';
    $orderStatus = ($order['status'] == 1) ? 'checked' : '';
    $orderStatusApprove = ($order['statusApprove'] == 1) ? 'checked' : '';
    $orderKnowing = ($order['knowing'] == 1) ? 'checked' : '';
    $orderPreview = ($order['preview'] == 1) ? 'checked' : '';
    $orderPrinting = ($order['printing'] == 1) ? 'checked' : '';
    $orderRekap = ($order['rekap'] == 1) ? 'checked' : '';

    // Order PO
    $orderpo = $rules['orderpos'];
    $orderpoIndex = ($orderpo['index'] == 1) ? 'checked' : '';
    $orderpoAdd = ($orderpo['add'] == 1) ? 'checked' : '';
    $orderpoEdit = ($orderpo['edit'] == 1) ? 'checked' : '';
    $orderpoXls = ($orderpo['xls'] == 1) ? 'checked' : '';
    $orderpoPdf = ($orderpo['pdf'] == 1) ? 'checked' : '';
    $orderpoDelete = ($orderpo['delete'] == 1) ? 'checked' : '';
    $orderpoStatus = ($orderpo['status'] == 1) ? 'checked' : '';
    $orderpoStatusApprove = ($orderpo['statusApprove'] == 1) ? 'checked' : '';
    $orderpoKnowing = ($orderpo['knowing'] == 1) ? 'checked' : '';
    $orderpoPreview = ($orderpo['preview'] == 1) ? 'checked' : '';
    $orderpoPrinting = ($orderpo['printing'] == 1) ? 'checked' : '';
    $orderpoRekap = ($orderpo['rekap'] == 1) ? 'checked' : '';

    //Surat Jalan Pengangkutan
    $permit = $rules['permits'];
    $permitIndex = ($permit['index'] == 1) ? 'checked' : '';
    $permitAdd = ($permit['add'] == 1) ? 'checked' : '';
    $permitAddDirect = ($permit['addDirect'] == 1) ? 'checked' : '';
    $permitEdit = ($permit['edit'] == 1) ? 'checked' : '';
    $permitPreview = ($permit['preview'] == 1) ? 'checked' : '';
    $permitPdf = ($permit['pdf'] == 1) ? 'checked' : '';

    // Permit Processor
// $permitProcessor = $rules['permitprocessors'];
// $permitProcessorIndex = ($permitProcessor['index']==1) ? 'checked' : '';
// $permitProcessorAdd = ($permitProcessor['add']==1) ? 'checked' : '';
// $permitProcessorEdit = ($permitProcessor['edit']==1) ? 'checked' : '';
// $permitProcessorPreview = ($permitProcessor['preview']==1) ? 'checked' : '';
// $permitProcessorPdf = ($permitProcessor['pdf']==1) ? 'checked' : '';
// $permitProcessorXls = ($permitProcessor['xls']==1) ? 'checked' : '';

    // Invoice Processor
// $invoiceProcessor = $rules['invoiceprocessors'];
// $invoiceProcessorIndex = ($invoiceProcessor['index']==1) ? 'checked' : '';
// $invoiceProcessorAdd = ($invoiceProcessor['add']==1) ? 'checked' : '';
// $invoiceProcessorEdit = ($invoiceProcessor['edit']==1) ? 'checked' : '';
// $invoiceProcessorPreview = ($invoiceProcessor['preview']==1) ? 'checked' : '';
// $invoiceProcessorPdf = ($invoiceProcessor['pdf']==1) ? 'checked' : '';
// $invoiceProcessorXls = ($invoiceProcessor['xls']==1) ? 'checked' : '';

    //Invoice Hutang
    $invoiceHutang = $rules['invoicehutangs'];
    $invoiceHutangIndex = ($invoiceHutang['index'] == 1) ? 'checked' : '';
    $invoiceHutangAdd = ($invoiceHutang['add'] == 1) ? 'checked' : '';
    $invoiceHutangEdit = ($invoiceHutang['edit'] == 1) ? 'checked' : '';
    $invoiceHutangPreview = ($invoiceHutang['preview'] == 1) ? 'checked' : '';
    $invoiceHutangPayment = ($invoiceHutang['payment'] == 1) ? 'checked' : '';
    $invoiceHutangPaymentEdit = ($invoiceHutang['paymentEdit'] == 1) ? 'checked' : '';
    $invoiceHutangRekap = ($invoiceHutang['rekap'] == 1) ? 'checked' : '';

    //Manifest
    $manifest = $rules['manifests'];
    // $manifestAdd = ($manifest['add']==1) ? 'checked' : '';
    $manifestXls = ($manifest['xls'] == 1) ? 'checked' : '';
    $manifestXlsHutang = ($manifest['xlsHutang'] == 1) ? 'checked' : '';
    // $manifestAddJournal = ($manifest['addJournal']==1) ? 'checked' : '';
// $manifestAddHutang = ($manifest['addHutang']==1) ? 'checked' : '';
// $manifestEditHutang = ($manifest['editHutang']==1) ? 'checked' : '';
// $manifestAddInvoiceName = ($manifest['addInvoiceName']==1) ? 'checked' : '';
// $manifestEdit = ($manifest['edit']==1) ? 'checked' : '';
// $manifestIndex = ($manifest['index']==1) ? 'checked' : '';
// $manifestPreview = ($manifest['preview']==1) ? 'checked' : '';
    $manifestJournalPiutang = ($manifest['journalPiutang'] == 1) ? 'checked' : '';
    $manifestAddJournalPiutang = ($manifest['addJournalPiutang'] == 1) ? 'checked' : '';
    $manifestJournalPiutangPackage = ($manifest['journalPiutangPackage'] == 1) ? 'checked' : '';
    $manifestAddJournalPiutangPackage = ($manifest['addJournalPiutangPackage'] == 1) ? 'checked' : '';
    // $manifestDelete = ($manifest['delete']==1) ? 'checked' : '';
    $manifestViewManifest = ($manifest['viewManifest'] == 1) ? 'checked' : '';
    $manifestPdfManifest = ($manifest['pdfManifest'] == 1) ? 'checked' : '';
    $manifestPdfManifestWarehouse = ($manifest['pdfManifestWarehouse'] == 1) ? 'checked' : '';
    $manifestPdfManifestWarehouseShip = ($manifest['pdfManifestWarehouseShip'] == 1) ? 'checked' : '';
    $manifestRptRekapManifests = ($manifest['rptRekapManifests'] == 1) ? 'checked' : '';
    $manifestXlsRekapManifest = ($manifest['xlsRekapManifest'] == 1) ? 'checked' : '';
    $manifestXlsRekapManifestKlh = ($manifest['xlsRekapManifestKlh'] == 1) ? 'checked' : '';
    $manifestRptRekapManifestProcessor = ($manifest['rptRekapManifestProcessor'] == 1) ? 'checked' : '';
    $manifestXlsRekapManifestProcessor = ($manifest['xlsRekapManifestProcessor'] == 1) ? 'checked' : '';
    // $manifestStatus_fastronik = ($manifest['status_fastronik']==1) ? 'checked' : '';
    $manifestEditReceived = ($manifest['editReceived'] == 1) ? 'checked' : '';
    $manifestCancel = ($manifest['cancel'] == 1) ? 'checked' : '';
    //$manifest_list_print = ($manifest['list_print']==1) ? 'checked' : '';
//$manifestIndexHutang = ($manifest['indexHutang']==1) ? 'checked' : '';
// $manifest_jumlahPengangkutanReport = ($manifest['jumlahPengangkutanReport']==1) ? 'checked' : '';
//$manifestAdd_uniq = ($manifest['add_uniq']==1) ? 'checked' : '';
//$manifestAdd_withoutorder = ($manifest['add_withoutorder']==1) ? 'checked' : '';
//$manifestReinput = ($manifest['reinput']==1) ? 'checked' : '';
//$manifestEdit_reinput = ($manifest['edit_reinput']==1) ? 'checked' : '';
//$manifestXlsManifest = ($manifest['xlsManifest']==1) ? 'checked' : '';
// $manifestCompleteDocument = ($manifest['completeDocument']==1) ? 'checked' : '';
// $manifestEditCompleteDocument = ($manifest['editCompleteDocument']==1) ? 'checked' : '';
// $manifestRptCompleteDocument = ($manifest['rptCompleteDocument']==1) ? 'checked' : '';
// $manifestCompleteDocument_transport = ($manifest['completeDocument_transport']==1) ? 'checked' : '';
// $manifestXlsCompleteDocument_transport = ($manifest['xlsCompleteDocument_transport']==1) ? 'checked' : '';
// $manifestEditCompleteDocument_transport = ($manifest['editCompleteDocument_transport']==1) ? 'checked' : '';
// $manifestRptCompleteDocument_transport = ($manifest['rptCompleteDocument_transport']==1) ? 'checked' : '';

    //Manifest Processor
// $manifestProcessor = $rules['manifestprocessors'];
// $manifestProcessorIndex = ($manifestProcessor['index']==1) ? 'checked' : '';
// $manifestProcessorAdd = ($manifestProcessor['add']==1) ? 'checked' : '';
// $manifestProcessorEdit = ($manifestProcessor['edit']==1) ? 'checked' : '';
// $manifestProcessorPreview = ($manifestProcessor['preview']==1) ? 'checked' : '';
// $manifestProcessorDelivery = ($manifestProcessor['delivery']==1) ? 'checked' : '';
// $manifestProcessorPdf = ($manifestProcessor['pdf']==1) ? 'checked' : '';
// $manifestProcessorDelete = ($manifestProcessor['delete']==1) ? 'checked' : '';
//$manifestAdd_vacancies = ($manifests['add_vacancies']==1) ? 'checked' : '';
//$manifestAddManifest_vacancies = ($manifests['addManifest_vacancies']==1) ? 'checked' : '';
//$manifestEditCancel = ($manifests['editCancel']==1) ? 'checked' : '';
//$manifest_list_printCancel = ($manifests['list_printCancel']==1) ? 'checked' : '';
//$manifestAdd_logbook = ($manifests['add_logbook']==1) ? 'checked' : '';
//manifest_report_logbook_out = ($manifests['report_logbook_out']==1) ? 'checked' : '';
//$manifest_out = ($manifests['out']==1) ? 'checked' : '';
//$manifest_outEdit = ($manifests['outEdit']==1) ? 'checked' : '';

    // if(!empty($data['condition']['manifestinsides'])){
//  $manifestInside = Set::reverse($data['condition']['manifestinsides']);
// }else{
//  $manifestInside = array('add'=>0, 'index'=>0, 'xls'=>0, 'edit'=>0, 'addCart'=>0, 'cart_process'=>0);
// }
//$manifest_insideAdd = ($manifestInside['add']==1) ? 'checked' : '';
//$manifest_insideAdd_internal = ($manifestInside['add_internal']==1) ? 'checked' : '';
//$manifest_insideEdit = ($manifestInside['edit']==1) ? 'checked' : '';
//$manifest_insideIndex = ($manifestInside['index']==1) ? 'checked' : '';
//$manifest_insideCart_process = ($manifestInside['cart_process']==1) ? 'checked' : '';
//$manifest_insideAddCart = ($manifestInside['addCart']==1) ? 'checked' : '';


    //$manifestRpt_jadwal_truck = ($manifests['rpt_jadwal_truck']==1) ? 'checked' : '';

    // Invoice
    $invoice = $rules['invoices'];
    $invoiceAdd = ($invoice['add'] == 1) ? 'checked' : '';
    $invoiceAddCustome = ($invoice['addCustome'] == 1) ? 'checked' : '';
    $invoiceEdit = ($invoice['edit'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangReport = ($invoice['umurPiutangReport'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangXls = ($invoice['umurPiutangXls'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangPdf = ($invoice['umurPiutangPdf'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangGroupReport = ($invoice['umurPiutangGroupReport'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangGroupXls = ($invoice['umurPiutangGroupXls'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangGroupXlsNosa = ($invoice['umurPiutangGroupXlsNosa'] == 1) ? 'checked' : '';
    $invoiceUmurPiutangGroupPdf = ($invoice['umurPiutangGroupPdf'] == 1) ? 'checked' : '';
    $invoiceEditCustome = ($invoice['editCustome'] == 1) ? 'checked' : '';
    $invoiceIndex = ($invoice['index'] == 1) ? 'checked' : '';
    $invoiceEditNew = ($invoice['editNew'] == 1) ? 'checked' : '';
    $invoiceDelete = ($invoice['delete'] == 1) ? 'checked' : '';
    $invoiceJournalPayment = ($invoice['journalPayment'] == 1) ? 'checked' : '';
    $invoicePaymentJournal = ($invoice['paymentJournal'] == 1) ? 'checked' : '';
    $invoicePayment = ($invoice['payment'] == 1) ? 'checked' : '';
    $invoicePaymentEdit = ($invoice['paymentEdit'] == 1) ? 'checked' : '';
    $invoicePaymentCancel = ($invoice['paymentCancel'] == 1) ? 'checked' : '';
    $invoicePdf = ($invoice['pdf'] == 1) ? 'checked' : '';
    $invoicePdfOld = ($invoice['pdfOld'] == 1) ? 'checked' : '';
    $invoicePdfPayment = ($invoice['pdfPayment'] == 1) ? 'checked' : '';
    $invoicePreview = ($invoice['preview'] == 1) ? 'checked' : '';
    $invoiceRekapInvoice = ($invoice['rekapInvoice'] == 1) ? 'checked' : '';
    $invoiceRekapInvoiceXls = ($invoice['rekapInvoiceXls'] == 1) ? 'checked' : '';
    $invoiceRekapInvoiceFull = ($invoice['rekapInvoiceFull'] == 1) ? 'checked' : '';
    $invoiceRekapInvoiceFullXls = ($invoice['rekapInvoiceFullXls'] == 1) ? 'checked' : '';
    $invoiceRptRekapTaxInvoice = ($invoice['rptRekapTaxInvoice'] == 1) ? 'checked' : '';
    $invoiceXlsRekapTaxInvoice = ($invoice['xlsRekapTaxInvoice'] == 1) ? 'checked' : '';
    $invoiceDelivery = ($invoice['delivery'] == 1) ? 'checked' : '';
    $invoiceRptLabaRugi = ($invoice['rptLabaRugi'] == 1) ? 'checked' : '';
    $invoiceXlsLabaRugi = ($invoice['xlsLabaRugi'] == 1) ? 'checked' : '';
    $invoicePiutang = ($invoice['piutang'] == 1) ? 'checked' : '';
    $invoicePiutangXls = ($invoice['piutangXls'] == 1) ? 'checked' : '';
    $invoicePiutangPerCustomer = ($invoice['piutangPerCustomer'] == 1) ? 'checked' : '';
    $invoicePiutangPerCustomerXls = ($invoice['piutangPerCustomerXls'] == 1) ? 'checked' : '';
    $invoiceHistoryDeposit = ($invoice['historyDeposit'] == 1) ? 'checked' : '';
    $invoicePdfHistoryDeposit = ($invoice['pdfHistoryDeposit'] == 1) ? 'checked' : '';
    $invoiceRekapPiutang = ($invoice['rekapPiutang'] == 1) ? 'checked' : '';
    $invoiceRekapPiutangXls = ($invoice['rekapPiutangXls'] == 1) ? 'checked' : '';
    $invoiceRekapPiutangPdf = ($invoice['rekapPiutangPdf'] == 1) ? 'checked' : '';
    $invoiceRekapPiutangRsud = ($invoice['rekapPiutangRsud'] == 1) ? 'checked' : '';
    $invoiceRekapPiutangRsudXls = ($invoice['rekapPiutangRsudXls'] == 1) ? 'checked' : '';
    $invoiceRekapPiutangRsudPdf = ($invoice['rekapPiutangRsudPdf'] == 1) ? 'checked' : '';
    $invoiceReportAccountReceivable = ($invoice['reportAccountReceivable'] == 1) ? 'checked' : '';
    $invoiceXlsAccountReceivable = ($invoice['xlsAccountReceivable'] == 1) ? 'checked' : '';
    $invoiceReportRecordPayment = ($invoice['reportRecordPayment'] == 1) ? 'checked' : '';
    $invoiceSaveRecordPayment = ($invoice['saveRecordPayment'] == 1) ? 'checked' : '';
    $invoiceXlsRecordPayment = ($invoice['xlsRecordPayment'] == 1) ? 'checked' : '';
    $invoicePayPromise = ($invoice['payPromise'] == 1) ? 'checked' : '';
    $invoicePayPromiseXls = ($invoice['payPromiseXls'] == 1) ? 'checked' : '';
    $invoiceEditAll = ($invoice['editAll'] == 1) ? 'checked' : '';
    //$invoiceRpt_berita_acara = ($invoice['rpt_berita_acara']==1) ? 'checked' : '';
//$invoicePdf_berita_acara = ($invoice['pdf_berita_acara']==1) ? 'checked' : '';
//$invoice_view_berita_acara = ($invoice['view_berita_acara']==1) ? 'checked' : '';
//$invoiceRpt_invoice = ($invoice['rpt_invoice']==1) ? 'checked' : '';
//$invoiceRpt_tax_invoice = ($invoice['rpt_tax_invoice']==1) ? 'checked' : '';
//$invoicePdf_tax_invoice = ($invoice['pdf_tax_invoice']==1) ? 'checked' : '';
//$invoice_view_tax_invoice = ($invoice['view_tax_invoice']==1) ? 'checked' : '';
//$invoiceRptRekapInvoice = ($invoice['rptRekapInvoice']==1) ? 'checked' : '';
//$invoiceXlsRekapInvoice = ($invoice['xlsRekapInvoice']==1) ? 'checked' : '';
//$invoiceRpt_keuangan = ($invoice['rpt_keuangan']==1) ? 'checked' : '';
//$invoiceXls_keuangan = ($invoice['xls_keuangan']==1) ? 'checked' : '';
// $invoiceCreate_invoice = ($invoice['create_invoice']==1) ? 'checked' : '';
// $invoiceCreate_invoice_include = ($invoice['create_invoice_include']==1) ? 'checked' : '';
//$invoicePdfLabaRugi = ($invoice['pdfLabaRugi']==1) ? 'checked' : '';
//$invoiceReportLabaRugiMulti = ($invoice['reportLabaRugiMulti']==1) ? 'checked' : '';
//$invoiceXlsLabaRugiMulti = ($invoice['xlsLabaRugiMulti']==1) ? 'checked' : '';
//$invoicePdfLabaRugiMulti = ($invoice['pdfLabaRugiMulti']==1) ? 'checked' : '';
//$invoiceReport_led = ($invoice['report_led']==1) ? 'checked' : '';
//$invoiceReportPayment = ($invoice['reportPayment']==1) ? 'checked' : '';
//$invoiceReport_ar = ($invoice['report_ar']==1) ? 'checked' : '';
//$invoiceXls_ar = ($invoice['xls_ar']==1) ? 'checked' : '';
//$invoice_list = ($invoice['list']==1) ? 'checked' : '';
//$invoiceDownloadMyerp = ($invoice['downloadMyerp']==1) ? 'checked' : '';
//$invoiceXlsDownloadMyerp = ($invoice['xlsDownloadMyerp']==1) ? 'checked' : '';
// $invoiceAddDeposit = ($invoice['addDeposit']==1) ? 'checked' : '';
// $invoiceEditDeposit = ($invoice['editDeposit']==1) ? 'checked' : '';
// $invoicePreviewDeposit = ($invoice['previewDeposit']==1) ? 'checked' : '';
// $invoiceIndexDeposit = ($invoice['indexDeposit']==1) ? 'checked' : '';
// $invoicePdfDeposit = ($invoice['pdfDeposit']==1) ? 'checked' : '';
// $invoiceDeliveryDeposit = ($invoice['deliveryDeposit']==1) ? 'checked' : '';
// $invoicePaymentDeposit = ($invoice['paymentDeposit']==1) ? 'checked' : '';
// $invoicePaymentEditDeposit = ($invoice['paymentEditDeposit']==1) ? 'checked' : '';
// $invoicePaymentCancelDeposit = ($invoice['paymentCancelDeposit']==1) ? 'checked' : '';

    // Invoice Out
    $invoiceOut = $rules['invoiceouts'];
    $invoiceOutIndex = ($invoiceOut['index'] == 1) ? 'checked' : '';
    $invoiceOutAdd = ($invoiceOut['add'] == 1) ? 'checked' : '';
    $invoiceOutEdit = ($invoiceOut['edit'] == 1) ? 'checked' : '';
    $invoiceOutDelivery = ($invoiceOut['delivery'] == 1) ? 'checked' : '';
    $invoiceOutPayment = ($invoiceOut['payment'] == 1) ? 'checked' : '';
    $invoiceOutPaymentEdit = ($invoiceOut['paymentEdit'] == 1) ? 'checked' : '';
    $invoiceOutPaymentCancel = ($invoiceOut['paymentCancel'] == 1) ? 'checked' : '';
    $invoiceOutDelete = ($invoiceOut['delete'] == 1) ? 'checked' : '';

    // Invoice Deposit
    $invoiceDeposit = $rules['invoicedeposits'];
    $invoiceDepositIndex = ($invoiceDeposit['index'] == 1) ? 'checked' : '';
    $invoiceDepositAdd = ($invoiceDeposit['add'] == 1) ? 'checked' : '';
    $invoiceDepositEdit = ($invoiceDeposit['edit'] == 1) ? 'checked' : '';
    $invoiceDepositPreview = ($invoiceDeposit['preview'] == 1) ? 'checked' : '';
    $invoiceDepositPdf = ($invoiceDeposit['pdf'] == 1) ? 'checked' : '';
    $invoiceDepositXls = ($invoiceDeposit['xls'] == 1) ? 'checked' : '';
    $invoiceDepositDelete = ($invoiceDeposit['delete'] == 1) ? 'checked' : '';
    $invoiceDepositDelivery = ($invoiceDeposit['delivery'] == 1) ? 'checked' : '';
    $invoiceDepositPayment = ($invoiceDeposit['payment'] == 1) ? 'checked' : '';
    $invoiceDepositPaymentEdit = ($invoiceDeposit['paymentEdit'] == 1) ? 'checked' : '';
    $invoiceDepositPaymentCancel = ($invoiceDeposit['paymentCancel'] == 1) ? 'checked' : '';
    $invoiceDepositJournalDeposit = ($invoiceDeposit['journalDeposit'] == 1) ? 'checked' : '';

    // Invoice Cutoff
// $invoiceCutoff = $rules['invoicecutoffs'];
// $invoiceCutoffIndex = ($invoiceCutoff['index']==1) ? 'checked' : '';
// $invoiceCutoffAdd = ($invoiceCutoff['add']==1) ? 'checked' : '';
// $invoiceCutoffEdit = ($invoiceCutoff['edit']==1) ? 'checked' : '';
// $invoiceCutoffPreview = ($invoiceCutoff['preview']==1) ? 'checked' : '';
// $invoiceCutoffPdf = ($invoiceCutoff['pdf']==1) ? 'checked' : '';
// $invoiceCutoffXls = ($invoiceCutoff['xls']==1) ? 'checked' : '';
// $invoiceCutoffDelete = ($invoiceCutoff['delete']==1) ? 'checked' : '';
// $invoiceCutoffDelivery = ($invoiceCutoff['delivery']==1) ? 'checked' : '';
// $invoiceCutoffPayment = ($invoiceCutoff['payment']==1) ? 'checked' : '';
// $invoiceCutoffPaymentEdit = ($invoiceCutoff['paymentEdit']==1) ? 'checked' : '';
// $invoiceCutoffPaymentCancel = ($invoiceCutoff['paymentCancel']==1) ? 'checked' : '';
// $invoiceCutoffJournalDeposit = ($invoiceCutoff['journalDeposit']==1) ? 'checked' : '';

    // Waste
    $waste = $rules['wastes'];
    $wasteIndex = ($waste['index'] == 1) ? 'checked' : '';
    $wasteAdd = ($waste['add'] == 1) ? 'checked' : '';
    $wasteEdit = ($waste['edit'] == 1) ? 'checked' : '';
    $wasteEditPrice = ($waste['editPrice'] == 1) ? 'checked' : '';
    $wasteApprove = ($waste['approve'] == 1) ? 'checked' : '';
    $wasteDelete = ($waste['delete'] == 1) ? 'checked' : '';
    $wasteXlsWaste = ($waste['xlsWaste'] == 1) ? 'checked' : '';
    $wasteXlsWasteAll = ($waste['xlsWasteAll'] == 1) ? 'checked' : '';

    // Waste Type
    $wasteType = $rules['wastetypes'];
    $wasteTypeIndex = ($wasteType['index'] == 1) ? 'checked' : '';
    $wasteTypeAdd = ($wasteType['add'] == 1) ? 'checked' : '';
    $wasteTypeEdit = ($wasteType['edit'] == 1) ? 'checked' : '';
    $wasteTypeEditPrice = ($wasteType['editPrice'] == 1) ? 'checked' : '';
    $wasteTypeApprove = ($wasteType['approve'] == 1) ? 'checked' : '';
    $wasteTypeDelete = ($wasteType['delete'] == 1) ? 'checked' : '';
    $wasteTypeXls = ($wasteType['xls'] == 1) ? 'checked' : '';
    $wasteTypeXlsWaste = ($wasteType['xlsWaste'] == 1) ? 'checked' : '';
    $wasteTypeXlsWasteAll = ($wasteType['xlsWasteAll'] == 1) ? 'checked' : '';

    // Waste Price
    $wastePrice = $rules['wasteprices'];
    $wastePriceIndex = ($wastePrice['index'] == 1) ? 'checked' : '';
    $wastePriceAdd = ($wastePrice['add'] == 1) ? 'checked' : '';
    $wastePriceEdit = ($wastePrice['edit'] == 1) ? 'checked' : '';
    $wastePriceDelete = ($wastePrice['delete'] == 1) ? 'checked' : '';
    $wastePriceXls = ($wastePrice['xls'] == 1) ? 'checked' : '';
    $wastePricePdf = ($wastePrice['pdf'] == 1) ? 'checked' : '';

    // Waste Price
    $mou = $rules['mous'];
    $mouIndex = ($mou['index'] == 1) ? 'checked' : '';
    $mouXls = ($mou['xls'] == 1) ? 'checked' : '';
    $mouXlsPrice = ($mou['xlsPrice'] == 1) ? 'checked' : '';
    $mouXlsDueDate = ($mou['xlsDueDate'] == 1) ? 'checked' : '';
    $mouPdf = ($mou['pdf'] == 1) ? 'checked' : '';
    $mouDeposit = ($mou['deposit'] == 1) ? 'checked' : '';
    $mouIndexInvoiceName = ($mou['indexInvoiceName'] == 1) ? 'checked' : '';
    $mouAdd = ($mou['add'] == 1) ? 'checked' : '';
    $mouAddInvoiceName = ($mou['addInvoiceName'] == 1) ? 'checked' : '';
    $mouEdit = ($mou['edit'] == 1) ? 'checked' : '';
    $mouDelivery = ($mou['delivery'] == 1) ? 'checked' : '';
    $mouEditNetto = ($mou['editNetto'] == 1) ? 'checked' : '';
    $mouEditPrice = ($mou['editPrice'] == 1) ? 'checked' : '';
    $mouApprove = ($mou['approve'] == 1) ? 'checked' : '';
    $mouDelete = ($mou['delete'] == 1) ? 'checked' : '';
    $mouXlsWaste = ($mou['xlsWaste'] == 1) ? 'checked' : '';
    $mouXlsWasteAll = ($mou['xlsWasteAll'] == 1) ? 'checked' : '';
    $mouPreview = ($mou['preview'] == 1) ? 'checked' : '';
    $mouStatus = ($mou['status'] == 1) ? 'checked' : '';
    $mou_extension = ($mou['extension'] == 1) ? 'checked' : '';

    // Supplier MOU
    $supplierMou = $rules['suppliermous'];
    $supplierMouIndex = ($supplierMou['index'] == 1) ? 'checked' : '';
    $supplierMouXls = ($supplierMou['xls'] == 1) ? 'checked' : '';
    $supplierMouXlsPrice = ($supplierMou['xlsPrice'] == 1) ? 'checked' : '';
    $supplierMouXlsDueDate = ($supplierMou['xlsDueDate'] == 1) ? 'checked' : '';
    $supplierMouPdf = ($supplierMou['pdf'] == 1) ? 'checked' : '';
    $supplierMouDeposit = ($supplierMou['deposit'] == 1) ? 'checked' : '';
    $supplierMouIndexInvoiceName = ($supplierMou['indexInvoiceName'] == 1) ? 'checked' : '';
    $supplierMouAdd = ($supplierMou['add'] == 1) ? 'checked' : '';
    $supplierMouAddInvoiceName = ($supplierMou['addInvoiceName'] == 1) ? 'checked' : '';
    $supplierMouEdit = ($supplierMou['edit'] == 1) ? 'checked' : '';
    $supplierMouDelivery = ($supplierMou['delivery'] == 1) ? 'checked' : '';
    $supplierMouEditNetto = ($supplierMou['editNetto'] == 1) ? 'checked' : '';
    $supplierMouEditPrice = ($supplierMou['editPrice'] == 1) ? 'checked' : '';
    $supplierMouApprove = ($supplierMou['approve'] == 1) ? 'checked' : '';
    $supplierMouDelete = ($supplierMou['delete'] == 1) ? 'checked' : '';
    $supplierMouXlsWaste = ($supplierMou['xlsWaste'] == 1) ? 'checked' : '';
    $supplierMouXlsWasteAll = ($supplierMou['xlsWasteAll'] == 1) ? 'checked' : '';
    $supplierMouPreview = ($supplierMou['preview'] == 1) ? 'checked' : '';
    $supplierMouStatus = ($supplierMou['status'] == 1) ? 'checked' : '';
    $supplierMouExtension = ($supplierMou['extension'] == 1) ? 'checked' : '';

    // Waste Price
    $template = $rules['templates'];
    $templateIndex = ($template['index'] == 1) ? 'checked' : '';
    $templateAdd = ($template['add'] == 1) ? 'checked' : '';
    $templateEdit = ($template['edit'] == 1) ? 'checked' : '';
    $templateDelete = ($template['delete'] == 1) ? 'checked' : '';

    // // Commission
// if(!empty($data['condition']['commissions'])){
//  $commissions = Set::reverse($data['condition']['commissions']);
// }else{
//  $commissions = array('index'=>0, 'add'=>0, 'edit'=>0, 'delete'=>0, 'rptCommission'=>0);
// }

    // $commissionIndex = ($commissions['index']==1) ? 'checked' : '';
// $commissionAdd = ($commissions['add']==1) ? 'checked' : '';
// $commissionEdit = ($commissions['edit']==1) ? 'checked' : '';
// $commission_rptCommission = ($commissions['rptCommission']==1) ? 'checked' : '';
// $commissionDelete = ($commissions['delete']==1) ? 'checked' : '';
//$commissionCommission = ($commissions['commission']==1) ? 'checked' : '';
//$commissionCreate = ($commissions['create']==1) ? 'checked' : '';

    // User
    $user = $rules['users'];
    $userIndex = ($user['index'] == 1) ? 'checked' : '';
    $userAdd = ($user['add'] == 1) ? 'checked' : '';
    $userEdit = ($user['edit'] == 1) ? 'checked' : '';
    $userAccess = ($user['access'] == 1) ? 'checked' : '';
    $userResetPassword = ($user['resetPassword'] == 1) ? 'checked' : '';
    $userDelete = ($user['delete'] == 1) ? 'checked' : '';


    // Order Regular
    $orderRegular = $rules['orderregulars'];
    $orderRegularIndex = ($orderRegular['index'] == 1) ? 'checked' : '';
    $orderRegularAdd = ($orderRegular['add'] == 1) ? 'checked' : '';
    $orderRegularEdit = ($orderRegular['edit'] == 1) ? 'checked' : '';
    $orderRegularDelete = ($orderRegular['delete'] == 1) ? 'checked' : '';

    // Setting
    $setting = $rules['settings'];
    $settingAdd = ($setting['add'] == 1) ? 'checked' : '';
    $settingEdit = ($setting['edit'] == 1) ? 'checked' : '';
    $settingIndex = ($setting['index'] == 1) ? 'checked' : '';

    // Offer
    $truckSchedule = $rules['truckschedules'];
    $truckScheduleIndex = ($truckSchedule['index'] == 1) ? 'checked' : '';
    $truckScheduleAdd = ($truckSchedule['add'] == 1) ? 'checked' : '';
    $truckScheduleEdit = ($truckSchedule['edit'] == 1) ? 'checked' : '';
    $truckScheduleEditProject = ($truckSchedule['editProject'] == 1) ? 'checked' : '';
    $truckSchedulePreview = ($truckSchedule['preview'] == 1) ? 'checked' : '';
    $truckScheduleRealisasi = ($truckSchedule['realisasi'] == 1) ? 'checked' : '';
    $truckScheduleRealisasiXls = ($truckSchedule['realisasiXls'] == 1) ? 'checked' : '';
    $truckScheduleRealisasiEdit = ($truckSchedule['realisasiEdit'] == 1) ? 'checked' : '';
    $truckScheduleInsentif = ($truckSchedule['insentif'] == 1) ? 'checked' : '';
    $truckScheduleDelete = ($truckSchedule['delete'] == 1) ? 'checked' : '';
    $truckScheduleDeleteSchedule = ($truckSchedule['deleteSchedule'] == 1) ? 'checked' : '';
    $truckSchedulePdf = ($truckSchedule['pdf'] == 1) ? 'checked' : '';
    $truckScheduleXls = ($truckSchedule['xls'] == 1) ? 'checked' : '';
    $truckSchedulePermitPreview = ($truckSchedule['permitPreview'] == 1) ? 'checked' : '';
    $truckSchedulePermitPdf = ($truckSchedule['permitPdf'] == 1) ? 'checked' : '';
    $truckSchedulePermitPdfArtama = ($truckSchedule['permitPdfArtama'] == 1) ? 'checked' : '';
    $truckSchedulePermitPdfTriata = ($truckSchedule['permitPdfTriata'] == 1) ? 'checked' : '';
    $truckSchedulePermitPdfBerseriBw = ($truckSchedule['permitPdfBerseriBw'] == 1) ? 'checked' : '';
    $truckSchedulePermitPdfArtamaBw = ($truckSchedule['permitPdfArtamaBw'] == 1) ? 'checked' : '';
    $truckSchedulePermitPdfTriataBw = ($truckSchedule['permitPdfTriataBw'] == 1) ? 'checked' : '';
    $truckScheduleAddRegular = ($truckSchedule['addRegular'] == 1) ? 'checked' : '';
    // Offer
/*if(!empty($data['condition']['offers'])){
    $offers = Set::reverse($data['condition']['offers']);
}else{
    $offers = array('index'=>0, 'add'=>0, 'edit'=>0, 'delete'=>0, 'approve'=>0, 'pdf'=>0, 'xls'=>0, 'print_list'=>0);
}                       

$offerIndex = ($offers['index']==1) ? 'checked' : '';
$offerAdd = ($offers['add']==1) ? 'checked' : '';
$offerEdit = ($offers['edit']==1) ? 'checked' : '';
$offerDelete = ($offers['delete']==1) ? 'checked' : '';
$offerApprove = ($offers['approve']==1) ? 'checked' : '';
$offer_print_list = ($offers['print_list']==1) ? 'checked' : '';
$offerPdf = ($offers['pdf']==1) ? 'checked' : '';
$offerXls = ($offers['xls']==1) ? 'checked' : '';*/

    //pr($data['condition']);
// PCA
    $submission = $rules['submissions'];
    $submissionApprove = ($submission['approve'] == 1) ? 'checked' : '';
    $submissionApproveAcc = ($submission['approveAcc'] == 1) ? 'checked' : '';
    $submissionApproveCeo = ($submission['approveCeo'] == 1) ? 'checked' : '';
    $submissionAdd = ($submission['add'] == 1) ? 'checked' : '';
    $submissionEdit = ($submission['edit'] == 1) ? 'checked' : '';
    $submissionEditAll = ($submission['editAll'] == 1) ? 'checked' : '';
    $submissionIndex = ($submission['index'] == 1) ? 'checked' : '';
    $submissionPreview = ($submission['preview'] == 1) ? 'checked' : '';
    $submissionPdf = ($submission['pdf'] == 1) ? 'checked' : '';
    $submissionPayment = ($submission['payment'] == 1) ? 'checked' : '';
    $submissionPrinting = ($submission['printing'] == 1) ? 'checked' : '';
    $submissionAccountability = ($submission['accountability'] == 1) ? 'checked' : '';
    $submissionJournal = ($submission['journal'] == 1) ? 'checked' : '';
    $submissionXls = ($submission['xls'] == 1) ? 'checked' : '';


    // PCA Topup
    $pettyCashTopup = $rules['pettycashtopups'];
    $pettyCashTopupApprove = ($pettyCashTopup['approve'] == 1) ? 'checked' : '';
    $pettyCashTopupApproveAcc = ($pettyCashTopup['approveAcc'] == 1) ? 'checked' : '';
    $pettyCashTopupApproveCeo = ($pettyCashTopup['approveCeo'] == 1) ? 'checked' : '';
    $pettyCashTopupAdd = ($pettyCashTopup['add'] == 1) ? 'checked' : '';
    $pettyCashTopupEdit = ($pettyCashTopup['edit'] == 1) ? 'checked' : '';
    $pettyCashTopupEditAll = ($pettyCashTopup['editAll'] == 1) ? 'checked' : '';
    $pettyCashTopupIndex = ($pettyCashTopup['index'] == 1) ? 'checked' : '';
    $pettyCashTopupPreview = ($pettyCashTopup['preview'] == 1) ? 'checked' : '';
    $pettyCashTopupPdf = ($pettyCashTopup['pdf'] == 1) ? 'checked' : '';
    $pettyCashTopupPayment = ($pettyCashTopup['payment'] == 1) ? 'checked' : '';
    $pettyCashTopupPrinting = ($pettyCashTopup['printing'] == 1) ? 'checked' : '';
    $pettyCashTopupAccountability = ($pettyCashTopup['accountability'] == 1) ? 'checked' : '';
    $pettyCashTopupJournal = ($pettyCashTopup['journal'] == 1) ? 'checked' : '';
    $pettyCashTopupXls = ($pettyCashTopup['xls'] == 1) ? 'checked' : '';


    // PCA Bank
    $pettyCashBank = $rules['pettycashbanks'];
    $pettyCashBankApprove = ($pettyCashBank['approve'] == 1) ? 'checked' : '';
    $pettyCashBankApproveAcc = ($pettyCashBank['approveAcc'] == 1) ? 'checked' : '';
    $pettyCashBankApproveCeo = ($pettyCashBank['approveCeo'] == 1) ? 'checked' : '';
    $pettyCashBankAdd = ($pettyCashBank['add'] == 1) ? 'checked' : '';
    $pettyCashBankEdit = ($pettyCashBank['edit'] == 1) ? 'checked' : '';
    $pettyCashBankEditAll = ($pettyCashBank['editAll'] == 1) ? 'checked' : '';
    $pettyCashBankIndex = ($pettyCashBank['index'] == 1) ? 'checked' : '';
    $pettyCashBankPreview = ($pettyCashBank['preview'] == 1) ? 'checked' : '';
    $pettyCashBankPdf = ($pettyCashBank['pdf'] == 1) ? 'checked' : '';
    $pettyCashBankPayment = ($pettyCashBank['payment'] == 1) ? 'checked' : '';
    $pettyCashBankPrinting = ($pettyCashBank['printing'] == 1) ? 'checked' : '';
    $pettyCashBankAccountability = ($pettyCashBank['accountability'] == 1) ? 'checked' : '';
    $pettyCashBankJournal = ($pettyCashBank['journal'] == 1) ? 'checked' : '';
    $pettyCashBankXls = ($pettyCashBank['xls'] == 1) ? 'checked' : '';

    // PCA Bank Topup
    $pettyCashBankTopup = $rules['pettycashbanktopups'];
    $pettyCashBankTopupApprove = ($pettyCashBankTopup['approve'] == 1) ? 'checked' : '';
    $pettyCashBankTopupApproveAcc = ($pettyCashBankTopup['approveAcc'] == 1) ? 'checked' : '';
    $pettyCashBankTopupApproveCeo = ($pettyCashBankTopup['approveCeo'] == 1) ? 'checked' : '';
    $pettyCashBankTopupAdd = ($pettyCashBankTopup['add'] == 1) ? 'checked' : '';
    $pettyCashBankTopupEdit = ($pettyCashBankTopup['edit'] == 1) ? 'checked' : '';
    $pettyCashBankTopupEditAll = ($pettyCashBankTopup['editAll'] == 1) ? 'checked' : '';
    $pettyCashBankTopupIndex = ($pettyCashBankTopup['index'] == 1) ? 'checked' : '';
    $pettyCashBankTopupPreview = ($pettyCashBankTopup['preview'] == 1) ? 'checked' : '';
    $pettyCashBankTopupPdf = ($pettyCashBankTopup['pdf'] == 1) ? 'checked' : '';
    $pettyCashBankTopupPayment = ($pettyCashBankTopup['payment'] == 1) ? 'checked' : '';
    $pettyCashBankTopupPrinting = ($pettyCashBankTopup['printing'] == 1) ? 'checked' : '';
    $pettyCashBankTopupAccountability = ($pettyCashBankTopup['accountability'] == 1) ? 'checked' : '';
    $pettyCashBankTopupJournal = ($pettyCashBankTopup['journal'] == 1) ? 'checked' : '';
    $pettyCashBankTopupXls = ($pettyCashBankTopup['xls'] == 1) ? 'checked' : '';

    /*if(!empty($data['condition']['certificates'])){
        $certificates = Set::reverse($data['condition']['certificates']);
    }else{
        $certificates = array('index'=>0, 'add'=>0, 'edit'=>0, 'delete'=>0);
    }                       

    $certificateIndex = ($certificates['index']==1) ? 'checked' : '';
    $certificateAdd = ($certificates['add']==1) ? 'checked' : '';
    $certificateEdit = ($certificates['edit']==1) ? 'checked' : '';
    $certificateDelete = ($certificates['delete']==1) ? 'checked' : '';
    */

    // Accounting
//COA
    $accChartOfAccount = $rules['accchartofaccounts'];
    $accChartOfAccountIndex = ($accChartOfAccount['index'] == 1) ? 'checked' : '';
    $accChartOfAccountAdd = ($accChartOfAccount['add'] == 1) ? 'checked' : '';
    $accChartOfAccountEdit = ($accChartOfAccount['edit'] == 1) ? 'checked' : '';
    $accChartOfAccountDelete = ($accChartOfAccount['delete'] == 1) ? 'checked' : '';
    $accChartOfAccountMoveup = ($accChartOfAccount['moveup'] == 1) ? 'checked' : '';
    $accChartOfAccountMovedown = ($accChartOfAccount['movedown'] == 1) ? 'checked' : '';
    $accChartOfAccountGroup = ($accChartOfAccount['group'] == 1) ? 'checked' : '';
    $accChartOfAccountGroupAdd = ($accChartOfAccount['groupAdd'] == 1) ? 'checked' : '';
    $accChartOfAccountGroupEdit = ($accChartOfAccount['groupEdit'] == 1) ? 'checked' : '';
    $accChartOfAccountXlsCoa = ($accChartOfAccount['xlsCoa'] == 1) ? 'checked' : '';
    $accChartOfAccountExportImportSaldoAwal = ($accChartOfAccount['exportImportSaldoAwal'] == 1) ? 'checked' : '';
    $accChartOfAccountExportImportSaldoAwalXls = ($accChartOfAccount['exportImportSaldoAwalXls'] == 1) ? 'checked' : '';
    $accChartOfAccountExportImportOldCode = ($accChartOfAccount['exportImportOldCode'] == 1) ? 'checked' : '';
    $accChartOfAccountExportImportOldCodeXls = ($accChartOfAccount['exportImportOldCodeXls'] == 1) ? 'checked' : '';
    $accChartOfAccountStatusPca = ($accChartOfAccount['statusPca'] == 1) ? 'checked' : '';
    $accChartOfAccountStatusPcaCash = ($accChartOfAccount['statusPcaCash'] == 1) ? 'checked' : '';
    $accChartOfAccountStatusBank = ($accChartOfAccount['statusBank'] == 1) ? 'checked' : '';
    $accChartOfAccountStatusBankCash = ($accChartOfAccount['statusBankCash'] == 1) ? 'checked' : '';
    $accChartOfAccountStatusTitipan = ($accChartOfAccount['statusTitipan'] == 1) ? 'checked' : '';

    //Acc Journal
    $accJournal = $rules['accjournals'];
    $accJournalImport = ($accJournal['import'] == 1) ? 'checked' : '';
    $accJournalReportJurnalPaymentInvoiceAdmin = ($accJournal['reportJurnalPaymentInvoiceAdmin'] == 1) ? 'checked' : '';
    $accJournalReportJurnalPiutangManifestAdmin = ($accJournal['reportJurnalPiutangManifestAdmin'] == 1) ? 'checked' : '';
    $accJournalReportJurnalDepositInvoiceAdmin = ($accJournal['reportJurnalDepositInvoiceAdmin'] == 1) ? 'checked' : '';
    $accJournalIndex = ($accJournal['index'] == 1) ? 'checked' : '';
    $accJournalAdd = ($accJournal['add'] == 1) ? 'checked' : '';
    $accJournalAddMany = ($accJournal['addMany'] == 1) ? 'checked' : '';
    $accJournalAddOnlyOne = ($accJournal['addOnlyOne'] == 1) ? 'checked' : '';
    $accJournalExportImportJournalOld = ($accJournal['exportImportJournalOld'] == 1) ? 'checked' : '';
    $accJournalExportImportJournalOldXls = ($accJournal['exportImportJournalOldXls'] == 1) ? 'checked' : '';
    $accJournalExportImportJournal = ($accJournal['exportImportJournal'] == 1) ? 'checked' : '';
    $accJournalExportImportJournalXls = ($accJournal['exportImportJournalXls'] == 1) ? 'checked' : '';
    $accJournalRekapJournal = ($accJournal['rekapJournal'] == 1) ? 'checked' : '';
    $accJournalXlsRekapJournal = ($accJournal['xlsRekapJournal'] == 1) ? 'checked' : '';
    $accJournalPdfRekapJournal = ($accJournal['pdfRekapJournal'] == 1) ? 'checked' : '';
    $accJournalEdit = ($accJournal['edit'] == 1) ? 'checked' : '';
    $accJournalEditMany = ($accJournal['editMany'] == 1) ? 'checked' : '';
    $accJournalPostingSave = ($accJournal['postingSave'] == 1) ? 'checked' : '';
    $accJournalDelete = ($accJournal['delete'] == 1) ? 'checked' : '';
    $accJournalReportPrintCashBank = ($accJournal['reportPrintCashBank'] == 1) ? 'checked' : '';
    $accJournalPreviewPrintCashBank = ($accJournal['previewPrintCashBank'] == 1) ? 'checked' : '';
    $accJournalPrintCashBank = ($accJournal['printCashBank'] == 1) ? 'checked' : '';
    $accJournalReportPosting = ($accJournal['reportPosting'] == 1) ? 'checked' : '';
    $accJournalPreviewPosting = ($accJournal['previewPosting'] == 1) ? 'checked' : '';
    $accJournalEditPosting = ($accJournal['editPosting'] == 1) ? 'checked' : '';
    $accJournalReportSummaryCash = ($accJournal['reportSummaryCash'] == 1) ? 'checked' : '';
    $accJournalReportIncome = ($accJournal['reportIncome'] == 1) ? 'checked' : '';
    $accJournalXlsIncome = ($accJournal['xlsIncome'] == 1) ? 'checked' : '';
    $accJournalPdfIncome = ($accJournal['pdfIncome'] == 1) ? 'checked' : '';
    $accJournalReportIncomeGlobal = ($accJournal['reportIncomeGlobal'] == 1) ? 'checked' : '';
    $accJournalXlsIncomeGlobal = ($accJournal['xlsIncomeGlobal'] == 1) ? 'checked' : '';
    $accJournalPdfIncomeGlobal = ($accJournal['pdfIncomeGlobal'] == 1) ? 'checked' : '';
    $accJournalReportIncomeMulti = ($accJournal['reportIncomeMulti'] == 1) ? 'checked' : '';
    $accJournalXlsIncomeMulti = ($accJournal['xlsIncomeMulti'] == 1) ? 'checked' : '';
    $accJournalPdfIncomeMulti = ($accJournal['pdfIncomeMulti'] == 1) ? 'checked' : '';
    // 2019
    $accJournalReportIncomeGlobal2019 = ($accJournal['reportIncomeGlobal2019'] == 1) ? 'checked' : '';
    $accJournalXlsIncomeGlobal2019 = ($accJournal['xlsIncomeGlobal2019'] == 1) ? 'checked' : '';
    $accJournalPdfIncomeGlobal2019 = ($accJournal['pdfIncomeGlobal2019'] == 1) ? 'checked' : '';
    $accJournalReportIncomeMulti2019 = ($accJournal['reportIncomeMulti2019'] == 1) ? 'checked' : '';
    $accJournalXlsIncomeMulti2019 = ($accJournal['xlsIncomeMulti2019'] == 1) ? 'checked' : '';
    $accJournalPdfIncomeMulti2019 = ($accJournal['pdfIncomeMulti2019'] == 1) ? 'checked' : '';
    $accJournalReportGeneralJournal = ($accJournal['reportGeneralJournal'] == 1) ? 'checked' : '';
    $accJournalReportJournal = ($accJournal['reportJournal'] == 1) ? 'checked' : '';
    $accJournalReportJournalXls = ($accJournal['reportJournalXls'] == 1) ? 'checked' : '';
    $accJournalXlsJournal = ($accJournal['xlsJournal'] == 1) ? 'checked' : '';
    $accJournalReportGeneralLedger = ($accJournal['reportGeneralLedger'] == 1) ? 'checked' : '';
    $accJournalPdfGeneralLedger = ($accJournal['pdfGeneralLedger'] == 1) ? 'checked' : '';
    $accJournalXlsGeneralLedger = ($accJournal['xlsGeneralLedger'] == 1) ? 'checked' : '';
    $accJournalReportBalanceSheet = ($accJournal['reportBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalXlsBalanceSheet = ($accJournal['xlsBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalPdfBalanceSheet = ($accJournal['pdfBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalReportOrdinaryBalanceSheet = ($accJournal['reportOrdinaryBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalXlsOrdinaryBalanceSheet = ($accJournal['xlsOrdinaryBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalPdfOrdinaryBalanceSheet = ($accJournal['pdfOrdinaryBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalReportPercentBalanceSheet = ($accJournal['reportPercentBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalXlsPercentBalanceSheet = ($accJournal['xlsPercentBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalPdfPercentBalanceSheet = ($accJournal['pdfPercentBalanceSheet'] == 1) ? 'checked' : '';
    $accJournalReportBalanceSheetPercent = ($accJournal['reportBalanceSheetPercent'] == 1) ? 'checked' : '';
    $accJournalXlsBalanceSheetPercent = ($accJournal['xlsBalanceSheetPercent'] == 1) ? 'checked' : '';
    $accJournalPdfBalanceSheetPercent = ($accJournal['pdfBalanceSheetPercent'] == 1) ? 'checked' : '';
    $accJournalReportTrialBalance = ($accJournal['reportTrialBalance'] == 1) ? 'checked' : '';
    $accJournalReportTrialBalanceNew = ($accJournal['reportTrialBalanceNew'] == 1) ? 'checked' : '';
    $accJournalXlsTrialBalanceNew = ($accJournal['xlsTrialBalanceNew'] == 1) ? 'checked' : '';
    $accJournalPdfTrialBalanceNew = ($accJournal['pdfTrialBalanceNew'] == 1) ? 'checked' : '';
    $accJournalXlsTrialBalance = ($accJournal['xlsTrialBalance'] == 1) ? 'checked' : '';
    $accJournalReportEkuitas = ($accJournal['reportEkuitas'] == 1) ? 'checked' : '';
    $accJournalXlsEkuitas = ($accJournal['xlsEkuitas'] == 1) ? 'checked' : '';
    $accJournalPrintJournal = ($accJournal['printJournal'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioLiquiditas = ($accJournal['financialRatioLiquiditas'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioLiquiditasXls = ($accJournal['financialRatioLiquiditasXls'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioLiquiditasPdf = ($accJournal['financialRatioLiquiditasPdf'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioSolvabilitas = ($accJournal['financialRatioSolvabilitas'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioSolvabilitasXls = ($accJournal['financialRatioSolvabilitasXls'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioSolvabilitasPdf = ($accJournal['financialRatioSolvabilitasPdf'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioRentabilitas = ($accJournal['financialRatioRentabilitas'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioRentabilitasXls = ($accJournal['financialRatioRentabilitasXls'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioRentabilitasPdf = ($accJournal['financialRatioRentabilitasPdf'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioAktivitas = ($accJournal['financialRatioAktivitas'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioAktivitasXls = ($accJournal['financialRatioAktivitasXls'] == 1) ? 'checked' : '';
    $accJournalFinancialRatioAktivitasPdf = ($accJournal['financialRatioAktivitasPdf'] == 1) ? 'checked' : '';
    $accJournalReportBalance = ($accJournal['reportBalance'] == 1) ? 'checked' : '';
    $accJournalReportBalanceXls = ($accJournal['reportBalanceXls'] == 1) ? 'checked' : '';
    $accJournalReportBalancePdf = ($accJournal['reportBalancePdf'] == 1) ? 'checked' : '';
    $accJournalPreview = ($accJournal['preview'] == 1) ? 'checked' : '';
    $accJournalPreviewXls = ($accJournal['previewXls'] == 1) ? 'checked' : '';
    $accJournalXls = ($accJournal['xls'] == 1) ? 'checked' : '';

    // Acc Beginning Balance
    $accBeginningBalance = $rules['accbeginningbalances'];
    $accBeginningBalanceIndex = ($accBeginningBalance['index'] == 1) ? 'checked' : '';
    $accBeginningBalanceAdd = ($accBeginningBalance['add'] == 1) ? 'checked' : '';
    $accBeginningBalanceEdit = ($accBeginningBalance['edit'] == 1) ? 'checked' : '';

    // Recipient Payer
    $recipientPayer = $rules['recipientpayers'];
    $recipientPayerIndex = ($recipientPayer['index'] == 1) ? 'checked' : '';
    $recipientPayerAdd = ($recipientPayer['add'] == 1) ? 'checked' : '';
    $recipientPayerEdit = ($recipientPayer['edit'] == 1) ? 'checked' : '';

    // Depreciations
    $depreciation = $rules['depreciations'];
    $depreciationIndex = ($depreciation['index'] == 1) ? 'checked' : '';
    $depreciationAdd = ($depreciation['add'] == 1) ? 'checked' : '';
    $depreciationEdit = ($depreciation['edit'] == 1) ? 'checked' : '';

    // ---------- ACC --------------------------------
// Acc Journal Mapping
    $accJournalMapping = $rules['accjournalmappings'];
    $accJournalMappingIndex = ($accJournalMapping['index'] == 1) ? 'checked' : '';
    $accJournalMappingAdd = ($accJournalMapping['add'] == 1) ? 'checked' : '';
    $accJournalMappingEdit = ($accJournalMapping['edit'] == 1) ? 'checked' : '';
    $accJournalMappingDelete = ($accJournalMapping['delete'] == 1) ? 'checked' : '';

    // Acc Chart Of Account
    $accChartOfAccount = $rules['accchartofaccounts'];
    $accChartOfAccountGroup = ($accChartOfAccount['group'] == 1) ? 'checked' : '';
    $accChartOfAccountIndex = ($accChartOfAccount['index'] == 1) ? 'checked' : '';
    $accChartOfAccountAdd = ($accChartOfAccount['add'] == 1) ? 'checked' : '';
    $accChartOfAccountEdit = ($accChartOfAccount['edit'] == 1) ? 'checked' : '';
    $accChartOfAccountAddGroup = ($accChartOfAccount['addGroup'] == 1) ? 'checked' : '';
    $accChartOfAccountEditGroup = ($accChartOfAccount['editGroup'] == 1) ? 'checked' : '';
    $accChartOfAccountDelete = ($accChartOfAccount['delete'] == 1) ? 'checked' : '';
    $accChartOfAccountMoveUp = ($accChartOfAccount['moveUp'] == 1) ? 'checked' : '';
    $accChartOfAccountMoveDown = ($accChartOfAccount['moveDown'] == 1) ? 'checked' : '';
    $accChartOfAccountStatusSubmission = ($accChartOfAccount['statusSubmission'] == 1) ? 'checked' : '';

    $accChartOfAccountBeginningBalanceExportImport = ($accChartOfAccount['beginningBalanceExportImport'] == 1) ? 'checked' : '';
    $accChartOfAccountBeginningBalanceExportImportXls = ($accChartOfAccount['beginningBalanceExportImportXls'] == 1) ? 'checked' : '';
    $accChartOfAccountXls = ($accChartOfAccount['xls'] == 1) ? 'checked' : '';
    $accChartOfAccountPdf = ($accChartOfAccount['pdf'] == 1) ? 'checked' : '';
    // $accChartOfAccount_exampleXls = ($accChartOfAccount['exampleXls'] == 1) ? 'checked' : '';

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
    $accJournalGeneralLedgerPdf = ($accJournal['generalLedgerPdf'] == 1) ? 'checked' : '';
    $accJournalGeneralLedgerXls = ($accJournal['generalLedgerXls'] == 1) ? 'checked' : '';
    $accJournalGeneralLedgerReport = ($accJournal['generalLedgerReport'] == 1) ? 'checked' : '';
    $accJournalEkuitasPdf = ($accJournal['ekuitasPdf'] == 1) ? 'checked' : '';
    $accJournalEkuitasReport = ($accJournal['ekuitasReport'] == 1) ? 'checked' : '';
    $accJournalGeneralJournalReport = ($accJournal['generalJournalReport'] == 1) ? 'checked' : '';
    $accJournalIncomeGlobalReport = ($accJournal['incomeGlobalReport'] == 1) ? 'checked' : '';
    $accJournalIncomeGlobalPdf = ($accJournal['incomeGlobalPdf'] == 1) ? 'checked' : '';
    $accJournalIncomeGlobalXls = ($accJournal['incomeGlobalXls'] == 1) ? 'checked' : '';
    $accJournalIncomeMultiReport = ($accJournal['incomeMultiReport'] == 1) ? 'checked' : '';
    $accJournalIncomeMultiPdf = ($accJournal['incomeMultiPdf'] == 1) ? 'checked' : '';
    $accJournalIncomeMultiXls = ($accJournal['incomeMultiXls'] == 1) ? 'checked' : '';
    $accJournalBalanceSheetPercentReport = ($accJournal['balanceSheetPercentReport'] == 1) ? 'checked' : '';
    $accJournalBalanceSheetPercentXls = ($accJournal['balanceSheetPercentXls'] == 1) ? 'checked' : '';
    $accJournalTrialBalanceReport = ($accJournal['trialBalanceReport'] == 1) ? 'checked' : '';
    $accJournalTrialBalanceXls = ($accJournal['trialBalanceXls'] == 1) ? 'checked' : '';
    $accJournalImport = ($accJournal['import'] == 1) ? 'checked' : '';
    $accJournalImportExampleXls = ($accJournal['importExampleXls'] == 1) ? 'checked' : '';
    $accJournalPostingSave = ($accJournal['postingSave'] == 1) ? 'checked' : '';
    $accJournalWorkSheetBalanceReport = ($accJournal['workSheetBalanceReport'] == 1) ? 'checked' : '';
    $accJournalWorkSheetBalanceReportXls = ($accJournal['workSheetBalanceReportXls'] == 1) ? 'checked' : '';
    //-----------------------------------------------------------------



    // Project
    $project = $rules['projects'];
    $projectIndex = ($project['index'] == 1) ? 'checked' : '';
    $projectRealisasi = ($project['realisasi'] == 1) ? 'checked' : '';
    // $projectAdd = ($project['add']==1) ? 'checked' : '';
// $projectEdit = ($project['edit']==1) ? 'checked' : '';

    // Unidentified Incomes/Pemasukkan tidak teridentifikasi
// $unidentifiedIncome = $rules['unidentifiedincomes'];
// $unidentifiedIncomeIndex = ($unidentifiedIncome['index']==1) ? 'checked' : '';
// $unidentifiedIncomeJournal = ($unidentifiedIncome['journal']==1) ? 'checked' : '';
// $unidentifiedIncomeAdd = ($unidentifiedIncome['add']==1) ? 'checked' : '';
// $unidentifiedIncomeEdit = ($unidentifiedIncome['edit']==1) ? 'checked' : '';
// $unidentifiedIncomePreview = ($unidentifiedIncome['preview']==1) ? 'checked' : '';
// $unidentifiedIncomeDelete = ($unidentifiedIncome['delete']==1) ? 'checked' : '';
// $unidentifiedIncomeEditIdentified = ($unidentifiedIncome['editIdentified']==1) ? 'checked' : '';
//-----------------------------------------------------------------

    // Medicine
    $medicine = $rules['medicines'];
    $medicineIndex = ($medicine['index'] == 1) ? 'checked' : '';
    $medicineAdd = ($medicine['add'] == 1) ? 'checked' : '';
    $medicineEdit = ($medicine['edit'] == 1) ? 'checked' : '';
    $medicineView = ($medicine['view'] == 1) ? 'checked' : '';
    $medicineDelete = ($medicine['delete'] == 1) ? 'checked' : '';
    $medicineDataExportImportXls = ($medicine['dataExportImportXls'] == 1) ? 'checked' : '';
    $medicineDataExportImport = ($medicine['dataExportImport'] == 1) ? 'checked' : '';

    // Medicine UBS
    $medicineUbs = $rules['medicineubs'];
    $medicineUbsIndex = ($medicineUbs['index'] == 1) ? 'checked' : '';
    $medicineUbsAdd = ($medicineUbs['add'] == 1) ? 'checked' : '';
    $medicineUbsEdit = ($medicineUbs['edit'] == 1) ? 'checked' : '';
    $medicineUbsView = ($medicineUbs['view'] == 1) ? 'checked' : '';
    $medicineUbsDelete = ($medicineUbs['delete'] == 1) ? 'checked' : '';
    $medicineUbsDataExportImportXls = ($medicineUbs['dataExportImportXls'] == 1) ? 'checked' : '';
    $medicineUbsDataExportImport = ($medicineUbs['dataExportImport'] == 1) ? 'checked' : '';

    // Medicine UBS Upload
    $medicineUbsUpload = $rules['medicineubsuploads'];
    $medicineUbsUploadIndex = ($medicineUbsUpload['index'] == 1) ? 'checked' : '';
    $medicineUbsUploadAdd = ($medicineUbsUpload['add'] == 1) ? 'checked' : '';
    $medicineUbsUploadEdit = ($medicineUbsUpload['edit'] == 1) ? 'checked' : '';
    $medicineUbsUploadView = ($medicineUbsUpload['view'] == 1) ? 'checked' : '';
    $medicineUbsUploadDelete = ($medicineUbsUpload['delete'] == 1) ? 'checked' : '';
    $medicineUbsUploadDataExportImportXls = ($medicineUbsUpload['dataExportImportXls'] == 1) ? 'checked' : '';
    $medicineUbsUploadDataExportImport = ($medicineUbs['dataExportImport'] == 1) ? 'checked' : '';

    // Medicine Merk
    $medicineMerk = $rules['medicinemerks'];
    $medicineMerkIndex = ($medicineMerk['index'] == 1) ? 'checked' : '';
    $medicineMerkAdd = ($medicineMerk['add'] == 1) ? 'checked' : '';
    $medicineMerkEdit = ($medicineMerk['edit'] == 1) ? 'checked' : '';
    $medicineMerkView = ($medicineMerk['view'] == 1) ? 'checked' : '';
    $medicineMerkDelete = ($medicineMerk['delete'] == 1) ? 'checked' : '';

    // Medicine Group
    $medicineGroup = $rules['medicinegroups'];
    $medicineGroupIndex = ($medicineGroup['index'] == 1) ? 'checked' : '';
    $medicineGroupAdd = ($medicineGroup['add'] == 1) ? 'checked' : '';
    $medicineGroupEdit = ($medicineGroup['edit'] == 1) ? 'checked' : '';
    $medicineGroupView = ($medicineGroup['view'] == 1) ? 'checked' : '';
    $medicineGroupDelete = ($medicineGroup['delete'] == 1) ? 'checked' : '';

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

    //polyclinic
    $polyclinic = $rules['polyclinics'];
    $polyclinicsIndex = ($polyclinic['index'] == 1) ? 'checked' : '';
    $polyclinicsAdd = ($polyclinic['add'] == 1) ? 'checked' : '';
    $polyclinicsEdit = ($polyclinic['edit'] == 1) ? 'checked' : '';
    $polyclinicsView = ($polyclinic['view'] == 1) ? 'checked' : '';
    $polyclinicsDelete = ($polyclinic['delete'] == 1) ? 'checked' : '';

    //patient
    $patient = $rules['patients'];
    $patientsIndex = ($patient['index'] == 1) ? 'checked' : '';
    $patientsAdd = ($patient['add'] == 1) ? 'checked' : '';
    $patientsEdit = ($patient['edit'] == 1) ? 'checked' : '';
    $patientsView = ($patient['view'] == 1) ? 'checked' : '';
    $patientsDelete = ($patient['delete'] == 1) ? 'checked' : '';

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

    //nutritioncombines
    $nutritioncombine = $rules['nutritioncombines'];
    $nutritioncombinesIndex = ($nutritioncombine['index'] == 1) ? 'checked' : '';
    $nutritioncombinesAdd = ($nutritioncombine['add'] == 1) ? 'checked' : '';
    $nutritioncombinesEdit = ($nutritioncombine['edit'] == 1) ? 'checked' : '';
    $nutritioncombinesView = ($nutritioncombine['view'] == 1) ? 'checked' : '';
    $nutritioncombinesDelete = ($nutritioncombine['delete'] == 1) ? 'checked' : '';

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

                // Supplier
                echo $this->Form->input('Rules.suppliers.getList', ['type' => 'hidden', 'value' => '1']);

                // Placement
                echo $this->Form->input('Rules.placements.getList', ['type' => 'hidden', 'value' => '1']);

                // Hidden User
                echo $this->Form->control('Rules.auth.index', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.daerahkabupatens.getList', ['type' => 'hidden', 'value' => '1']);

                echo $this->Form->control('Rules.auth.login', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.auth.logout', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.users.changePassword', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.users.status', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.account.login', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.users.home', ['type' => 'hidden', 'value' => '1']);

                // Hidden Truck Schedule
                echo $this->Form->control('Rules.warehousereceives.getTruckSchedule', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.warehousereceives.getSaveScale', ['type' => 'hidden', 'value' => '1']);


                // Hidden Waste Price
                echo $this->Form->control('Rules.wasteprices.getAjaxData', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.wasteprices.getForOrderRegular', ['type' => 'hidden', 'value' => '1']);

                // All Hidden value 
                // Hidden Customer
                echo $this->Form->control('Rules.customers.getLastNumber', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.customers.getSearch', ['type' => 'hidden', 'value' => '1']);

                // Hidden Processor
                echo $this->Form->control('Rules.processors.getLastNumber', ['type' => 'hidden', 'value' => '1']);

                // Hidden Transporter
                echo $this->Form->control('Rules.transporters.getLastNumber', ['type' => 'hidden', 'value' => '1']);

                // Hidden Order            
                echo $this->Form->control('Rules.orders.getOrderUbs', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.orders.getForManifest', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.orders.getForManifestNopol', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.orders.getAjaxOrderData', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.orders.getForTruckSchedule', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.orders.getAjaxHistoryData', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.orders.getForManifestDirect', ['type' => 'hidden', 'value' => '1']);

                // Hidden Order Regular
                echo $this->Form->control('Rules.orderregulars.getForTruckSchedule', ['type' => 'hidden', 'value' => '1']);

                // Hidden TruckSchedule
                echo $this->Form->control('Rules.truckschedules.addCart', ['type' => 'hidden', 'value' => '1']);

                //Hidden Invoice
                echo $this->Form->control('Rules.invoices.getAjaxInvoiceEdit', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.invoices.getCodeDepositAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.invoices.maxCode', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.invoices.getTotalInvoice', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.invoices.getDataCustomer', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.invoices.getNameInvoice', ['type' => 'hidden', 'value' => '1']);

                //Hidden Invoice Deposit
                

                //Hidden Waste
                echo $this->Form->control('Rules.wastes.getAjaxWasteData', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.wastes.getHistoryCustomeronwaste', ['type' => 'hidden', 'value' => '1']);

                //Hidden Manifest               
                echo $this->Form->control('Rules.manifests.getHistoryManifestAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getPermitManifestInvoiceAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getManifestAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getManifestOrderAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getManifestJadwalTrukAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getManifestPermitAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getInputManifest', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getInputManifestVacancies', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.pdfManifestWarehouse2', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.pdfManifestWarehouseCode', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.pdfManifestWarehouseModa', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.pdfManifestWarehouseShip', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getManifestProcessorAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.getDataForJurnal', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.manifests.addCart', ['type' => 'hidden', 'value' => '1']);

                // Hidden Manifest Inside                       
                echo $this->Form->control('Rules.manifestinsides.getManifestData', ['type' => 'hidden', 'value' => '1']);
                //echo $this->Form->control('Rules.manifestinsides.cart_process', ['type' => 'hidden', 'value' =>  '1']);
                
                // Hidden Manifest Direct                       
                echo $this->Form->control('Rules.manifestdirects.xls', ['type' => 'hidden', 'value' => '1']);

                // Hidden Branch
                echo $this->Form->control('Rules.branches.getData', ['type' => 'hidden', 'value' => '1']);

                //Hidden Permit
                echo $this->Form->control('Rules.permits.getDataAjax', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.permits.checkCodeByBranch', ['type' => 'hidden', 'value' => '1']);

                //Hidden Waste Type
                echo $this->Form->control('Rules.wastetypes.getSelect', ['type' => 'hidden', 'value' => '1']);


                //Hidden Customer
                echo $this->Form->control('Rules.customers.getAjaxType', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.customers.getKabupaten', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.customers.getCustomerForManifest', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.customers.getData', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.customers.jumlahPengangkutanReportCsSave', ['type' => 'hidden', 'value' => '1']);

                //Hidden Operational
                echo $this->Form->control('Rules.operationals.getAjaxNumber', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.operationals.getAjaxPermitData', ['type' => 'hidden', 'value' => '1']);


                echo $this->Form->control('Rules.vehiclerequirements.getNumberMax', ['type' => 'hidden', 'value' => '1']);

                // Hidden Invoice Deposit
                echo $this->Form->control('Rules.invoicedeposits.getCodeAjax', ['type' => 'hidden', 'value' => '1']);

                // Hidden MOU
                //echo $this->Form->control('Rules.mouis.getAjaxMax_number', ['type' => 'hidden', 'value' =>  '1']);
                echo $this->Form->control('Rules.mous.getHistoryData', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.mous.getMouFromManifest', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.mous.getMouFromInvoice', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.mous.getSearch', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.mous.getForSchedule', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.mous.getMouFromTruckSchedule', ['type' => 'hidden', 'value' => '1']);

                // echo $this->Form->control('Rules.mous.getMouFromInvoiceDeposit', ['type' => 'hidden', 'value' =>  '1']);           
                // Hidden Accounting
                echo $this->Form->input('Rules.accchartofaccounts.getCoa', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->input('Rules.accchartofaccounts.getList', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->control('Rules.accchartofaccounts.getSelect', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.accchartofaccounts.getData', ['type' => 'hidden', 'value' => '1']);


                // Acc Journal
                echo $this->Form->input('Rules.accjournals.addCart', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournals.addCartOne', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournals.checkcodeByType', ['type' => 'hidden', 'value' => '1']);

                echo $this->Form->input('Rules.accjournals.getCoaFromJournalEdit', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournallines.editManyDatatable', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournallines.add', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournallines.edit', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournallines.delete', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->input('Rules.accjournallines.getGeneralJournal', ['type' => 'hidden', 'value' => '1']);



                // Hidden Acc Journal
                echo $this->Form->control('Rules.accjournals.checkcode', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.accjournals.addrowgrid', ['type' => 'hidden', 'value' => '1']);
                echo $this->Form->control('Rules.accjournals.addrowgridposting', ['type' => 'hidden', 'value' => '1']);

                echo $this->Form->control('Rules.letters.checkcodebybranch', ['type' => 'hidden', 'value' => '1']);



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
                        <tr>
                            <td>Pembelian Barang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.purchaseofgoods.index', ['value' => '1', 'hiddenField' => true, 'checked' => $purchaseofgoodIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.purchaseofgoods.add', ['value' => '1', 'hiddenField' => true, 'checked' => $purchaseofgoodAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.purchaseofgoods.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $purchaseofgoodEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Penempatan Barang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.placementofgoods.index', ['value' => '1', 'hiddenField' => true, 'checked' => $placementofgoodIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.placementofgoods.add', ['value' => '1', 'hiddenField' => true, 'checked' => $placementofgoodAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.placementofgoods.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $placementofgoodEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Mutasi</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mutations.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mutationIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mutations.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mutationAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mutations.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mutationEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Gudang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehouses.index', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehouses.add', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Input</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehouses.receive', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseReceive, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Penerimaan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehouses.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Excel)</label>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Pengajuan Dana</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.index', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.add', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.editAll', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionEditAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.approveAcc', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionApproveAcc, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju Acc</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.approveCeo', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionApproveCeo, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionPrinting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.accountability', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionAccountability, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pertanggungjawaban</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.submissions.journal', ['value' => '1', 'hiddenField' => true, 'checked' => $submissionJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jurnal</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Order</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.index', ['value' => '1', 'hiddenField' => true, 'checked' => $orderIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.add', ['value' => '1', 'hiddenField' => true, 'checked' => $orderAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $orderEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $orderPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $orderPrinting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.status', ['value' => '1', 'hiddenField' => true, 'checked' => $orderStatus, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.knowing', ['value' => '1', 'hiddenField' => true, 'checked' => $orderKnowing, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Mengetahui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.statusApprove', ['value' => '1', 'hiddenField' => true, 'checked' => $orderStatusApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status (Approve)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $orderXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $orderPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.rekap', ['value' => '1', 'hiddenField' => true, 'checked' => $orderRekap, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orders.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $orderDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Order PO (keSupplier)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.index', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.add', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoPrinting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.status', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoStatus, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.statusApprove', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoStatusApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status (Approve)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.knowing', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoKnowing, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Mengetahui</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.rekap', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoRekap, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.orderpos.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $orderpoDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Gudang (Masuk)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehousereceives.index', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseReceiveIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehousereceives.add', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseReceiveAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru (Nopol)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehousereceives.addDriver', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseReceiveAddDriver, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru (Driver)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehousereceives.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseReceiveEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.warehousereceives.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $warehouseReceivePreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>

                                </div>
                            </td>



                        </tr>
                        <tr>
                            <td>MOU-Supplier</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.index', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.add', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Input</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.deposit', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouDeposit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Deposit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.xlsPrice', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouXlsPrice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Excel - Harga)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.xlsDueDate', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouXlsDueDate, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download Jatuh Tempo (Excel)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.indexInvoiceName', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouIndexInvoiceName, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar dari Nama Invoice</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.addInvoiceName', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouAddInvoiceName, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Input dari Nama Invoice</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouDelivery, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pengiriman</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.editNetto', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouEditNetto, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Netto</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.editPrice', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouEditPrice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Harga</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Menyetujui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.xlsWaste', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouXlsWaste, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel limbah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.xlsWasteAll', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouXlsWasteAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Semua Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.status', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouStatus, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.suppliermous.extension', ['value' => '1', 'hiddenField' => true, 'checked' => $supplierMouExtension, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Perpanjangan</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>MOU</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.index', ['value' => '1', 'hiddenField' => true, 'checked' => $mouIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.add', ['value' => '1', 'hiddenField' => true, 'checked' => $mouAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Input</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.deposit', ['value' => '1', 'hiddenField' => true, 'checked' => $mouDeposit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Deposit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $mouXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.xlsPrice', ['value' => '1', 'hiddenField' => true, 'checked' => $mouXlsPrice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Excel - Harga)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.xlsDueDate', ['value' => '1', 'hiddenField' => true, 'checked' => $mouXlsDueDate, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download Jatuh Tempo (Excel)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $mouPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.indexInvoiceName', ['value' => '1', 'hiddenField' => true, 'checked' => $mouIndexInvoiceName, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar dari Nama Invoice</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.addInvoiceName', ['value' => '1', 'hiddenField' => true, 'checked' => $mouAddInvoiceName, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Input dari Nama Invoice</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $mouEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $mouDelivery, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pengiriman</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.editNetto', ['value' => '1', 'hiddenField' => true, 'checked' => $mouEditNetto, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Netto</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.editPrice', ['value' => '1', 'hiddenField' => true, 'checked' => $mouEditPrice, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Harga</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $mouPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $mouApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Menyetujui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $mouDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.xlsWaste', ['value' => '1', 'hiddenField' => true, 'checked' => $mouXlsWaste, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel limbah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.xlsWasteAll', ['value' => '1', 'hiddenField' => true, 'checked' => $mouXlsWasteAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Semua Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.status', ['value' => '1', 'hiddenField' => true, 'checked' => $mouStatus, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.mous.extension', ['value' => '1', 'hiddenField' => true, 'checked' => $mou_extension, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Perpanjangan</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Jadwal Truk</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.index', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.add', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.addRegular', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleAddRegular, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Regular)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.editProject', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleEditProject, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah (Project)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.realisasi', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleRealisasi, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Realisasi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.realisasiEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleRealisasiEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Realisasi (Ubah)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.realisasiXls', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleRealisasiXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Realisasi - Unduh (Xls)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.insentif', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleInsentif, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Insentif</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.deleteSchedule', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleDeleteSchedule, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus (Jadwal)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $truckScheduleXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPreview', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan (Tampilkan)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan-Berseri (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPdfArtama', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPdfArtama, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan-Artama (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPdfTriata', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPdfTriata, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan-Triata (PDF)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPdfBerseriBw', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPdfBerseriBw, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan-Berseri (PDF BW)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPdfArtamaBw', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPdfArtamaBw, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan-Artama (PDF BW)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.truckschedules.permitPdfTriataBw', ['value' => '1', 'hiddenField' => true, 'checked' => $truckSchedulePermitPdfTriataBw, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Surat Jalan-Triata (PDF BW)</label>
                                    </div>

                                </div>
                            </td>
                        </tr>


                        <?php
                        //-------------------- Accounting -----------------
                        ?>
                        <tr>
                            <td>Perkiraan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.group', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountGroup, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Group</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.index', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.add', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.edit', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.addGroup', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountAddGroup, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Group)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.editGroup', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountEditGroup, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah (Group)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.delete', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.moveUp', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountMoveUp, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Naik Level</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.moveDown', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountMoveDown, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Turun Level</label>
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
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.xls', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.pdf', ['value' => 1, 'hiddenField' => true, 'checked' => $accChartOfAccountPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
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
                                        echo $this->Form->checkbox('Rules.accjournals.indexShort', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIndexShort, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.index', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar (Detail)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.add', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.addMany', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalAddMany, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Banyak)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.editMany', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalEditMany, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah (Banyak)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.addOnlyOne', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalAddOnlyOne, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Satu)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.edit', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.postingSave', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalPostingSave, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Posting</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.delete', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.import', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Import (Melalui Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.importExampleXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalImportExampleXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Import (Contoh Excel)</label>
                                    </div>
                                    <?php
                                    /*
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.exampleXls', ['value' => 1, 'hiddenField' => true, 'checked' =>  $accChartOfAccountExampleXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Unduh COA Excel (Lvl 5)</label>
                                    </div>
                                    */
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Jurnal Mapping</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournalmappings.index', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalMappingIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournalmappings.add', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalMappingAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournalmappings.edit', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalMappingEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournalmappings.delete', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalMappingDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Buku Besar</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.generalLedgerReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalGeneralLedgerReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.generalLedgerPdf', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalGeneralLedgerPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.generalLedgerXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalGeneralLedgerXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
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
                                        echo $this->Form->checkbox('Rules.accjournals.ekuitasReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalEkuitasReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.ekuitasPdf', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalEkuitasPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
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
                                        echo $this->Form->checkbox('Rules.accjournals.generalJournalReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalGeneralJournalReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
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
                            <td>Laba/Rugi</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeGlobalReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIncomeGlobalReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Global (Daftar)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeGlobalPdf', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIncomeGlobalPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Global (Pdf)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeGlobalXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIncomeGlobalXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Global (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeMultiReport', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIncomeMultiReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Multi (Daftar)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeMultiPdf', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIncomeMultiPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Multi (Pdf)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.incomeMultiXls', ['value' => 1, 'hiddenField' => true, 'checked' => $accJournalIncomeMultiXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Multi (Excel)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        //-----------------Accounting End -------------------------
                        
                        ?>






                        <tr>
                            <td>Invoice</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.add', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.addCustome', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceAddCustome, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Tanpa Manifest)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.editAll', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceEditAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah - Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.editCustome', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceEditCustome, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah tnp Manifest</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.editNew', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceEditNew, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah dgn manifest baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDelivery, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pengiriman</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.paymentEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePaymentEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran (Ubah)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.historyDeposit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHistoryDeposit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">History Deposit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.pdfHistoryDeposit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePdfHistoryDeposit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF History Deposit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.paymentCancel', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePaymentCancel, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Batal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.reportAccountReceivable', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceReportAccountReceivable, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Account Receivable (Tagihan)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.xlsAccountReceivable', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceXlsAccountReceivable, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Account Receivable (Tagihan)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.payPromise', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePayPromise, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Janji Bayar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.payPromiseXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePayPromiseXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Janji Bayar (Excel)</label>
                                    </div>



                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Invoice (Tanpa Manifest)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.add', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutDelivery, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pengiriman</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.paymentEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutPaymentEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran (Ubah)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoiceouts.paymentCancel', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceOutPaymentCancel, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Batal</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Invoice (Deposit)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.add', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.delivery', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositDelivery, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pengiriman</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.paymentEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositPaymentEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran (Ubah)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.paymentCancel', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositPaymentCancel, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran (Batal)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>Surat Jalan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.permits.index', ['value' => '1', 'hiddenField' => true, 'checked' => $permitIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.permits.add', ['value' => '1', 'hiddenField' => true, 'checked' => $permitAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.permits.addDirect', ['value' => '1', 'hiddenField' => true, 'checked' => $permitAddDirect, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat Langsung</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.permits.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $permitEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Edit</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.permits.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $permitPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Preview</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.permits.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $permitPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>Petty Cash (Saldo)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.index', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.add', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.editAll', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupEditAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.approveAcc', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupApproveAcc, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju Acc</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.approveCeo', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupApproveCeo, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupPrinting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.accountability', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupAccountability, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pertanggungjawaban</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashtopups.journal', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashTopupJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jurnal</label>
                                    </div>

                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>Petty Cash (Bank)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.index', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.add', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.editAll', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankEditAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.approveAcc', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankApproveAcc, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju Acc</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.approveCeo', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankApproveCeo, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankPrinting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.accountability', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankAccountability, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pertanggungjawaban</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanks.journal', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jurnal</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Petty Cash (Bank Topup Saldo)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.index', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.add', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.editAll', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupEditAll, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.approve', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupApprove, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.approveAcc', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupApproveAcc, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju Acc</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.approveCeo', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupApproveCeo, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Setuju 2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.pdf', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.printing', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupPrinting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.accountability', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupAccountability, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pertanggungjawaban</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.pettycashbanktopups.journal', ['value' => '1', 'hiddenField' => true, 'checked' => $pettyCashBankTopupJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Jurnal</label>
                                    </div>

                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>Project</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.projects.index', ['value' => '1', 'hiddenField' => true, 'checked' => $projectIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.projects.realisasi', ['value' => '1', 'hiddenField' => true, 'checked' => $projectRealisasi, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Realisasi</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

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
                                        echo $this->Form->checkbox('Rules.patients.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $patientsPreview, 'class' => 'form-check-input']);
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
                            <td>nutritioncombines</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombines.index', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinesIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombines.add', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinesAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tambah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombines.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinesEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombines.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinesPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombines.dataExportImport', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinesDataExportImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan (Xls-Import)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.nutritioncombines.dataExportImportXls', ['value' => '1', 'hiddenField' => true, 'checked' => $nutritioncombinesDataExportImportXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Download (Xls-Import-Example)</label>
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
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.index', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.add', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.group', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountGroup, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar (Kelompok)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.groupAdd', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountGroupAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Kelompok)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.groupEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountGroupEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah (Kelompok)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.moveup', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountMoveup, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Naik Level</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.movedown', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountMovedown, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Turun Level</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.xlsCoa', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountXlsCoa, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.exportImportSaldoAwal', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountExportImportSaldoAwal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Export/Import Saldo Awal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.exportImportSaldoAwalXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountExportImportSaldoAwalXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Export/Import Saldo Awal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.exportImportOldCode', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountExportImportOldCode, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Export/Import Kode Lama</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.exportImportOldCodeXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountExportImportOldCodeXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Export/Import Kode Lama</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.statusPca', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountStatusPca, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status Transaksi (PCA)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.statusPcaCash', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountStatusPcaCash, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status Kas (PCA)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.statusBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountStatusBank, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status Transaksi Bank (PCA)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.statusBankCash', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountStatusBankCash, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status Bank (PCA)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accchartofaccounts.statusTitipan', ['value' => '1', 'hiddenField' => true, 'checked' => $accChartOfAccountStatusTitipan, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status Titipan (Bank Piutang)</label>
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
                                        echo $this->Form->checkbox('Rules.accjournals.index', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.add', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.addMany', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalAddMany, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Banyak)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.addOnlyOne', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalAddOnlyOne, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat (Satu)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.journalPiutang', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestJournalPiutang, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan Piutang (Manifest)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.addJournalPiutang', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestAddJournalPiutang, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat Piutang (Manifest)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.journalPiutangPackage', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestJournalPiutangPackage, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan Piutang Paket (Manifest)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.manifests.addJournalPiutangPackage', ['value' => '1', 'hiddenField' => true, 'checked' => $manifestAddJournalPiutangPackage, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat Piutang Paket (Manifest)</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.editMany', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalEditMany, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah Banyak</label>

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.accJournalPostingSave', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPostingSave, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Posting</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalDelete, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournalOld', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournalOld, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Export/Import Journal (Kode Lama)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournalOldXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournalOldXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Export/Import Journal (Kode Lama)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Export/Import Journal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.exportImportJournalXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalExportImportJournalXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Export/Import Journal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.rekapJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalRekapJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Jurnal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfRekapJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfRekapJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Jurnal (PDF)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsRekapJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsRekapJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Jurnal (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.previewXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreviewXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Unduh (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.import', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalImport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Import (Melalui Excel)</label>
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportJurnalPiutangManifestAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJurnalPiutangManifestAdmin, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Manifest (Piutang)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJurnalPaymentInvoiceAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJurnalPaymentInvoiceAdmin, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Invoice (Pembayaran)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJurnalDepositInvoiceAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJurnalDepositInvoiceAdmin, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan Invoice (Deposit)</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Journal Invoice (Pembayaran)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.journalPayment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceJournalPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.paymentJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePaymentJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Untuk Pembayaran</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Journal Invoice (Deposit)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicedeposits.journalDeposit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceDepositJournalDeposit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Invoice (Hutang)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.index', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.add', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangPreview, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.payment', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangPayment, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoicehutangs.paymentEdit', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceHutangPaymentEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Pembayaran (Ubah)</label>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Mapping</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournalmappings.index', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalMappingIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Saldo Awal</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accbeginningbalances.index', ['value' => '1', 'hiddenField' => true, 'checked' => $accBeginningBalanceIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accbeginningbalances.add', ['value' => '1', 'hiddenField' => true, 'checked' => $accBeginningBalanceAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accbeginningbalances.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $accBeginningBalanceEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
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
                                        echo $this->Form->checkbox('Rules.recipientpayers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $recipientPayerIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.recipientpayers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $recipientPayerAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.recipientpayers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $recipientPayerEdit, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Penyusutan</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.depreciations.index', ['value' => '1', 'hiddenField' => true, 'checked' => $depreciationIndex, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.depreciations.add', ['value' => '1', 'hiddenField' => true, 'checked' => $depreciationAdd, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Buat</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.depreciations.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $depreciationEdit, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.postingSave', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPostingSave, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Simpan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportPosting', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportPosting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.previewPosting', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreviewPosting, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.editPosting', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalEditPosting, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.previewPrintCashBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPreviewPrintCashBank, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportPrintCashBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportPrintCashBank, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.printCashBank', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPrintCashBank, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportSummaryCash', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportSummaryCash, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncome', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncome, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncome', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncome, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncome', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncome, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeGlobal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeGlobal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Global)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeGlobal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeGlobal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Global)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeGlobal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeGlobal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Global)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeMulti, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Multi)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeMulti, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Multi)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeMulti', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeMulti, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Multi)</label>
                                    </div>
                                    <?php
                                    //Tahun 2019
                                    ?>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeGlobal2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeGlobal2019, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Global) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeGlobal2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeGlobal2019, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Global) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeGlobal2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeGlobal2019, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF (Global) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportIncomeMulti2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportIncomeMulti2019, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan (Multi) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsIncomeMulti2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsIncomeMulti2019, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Multi) 2019</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfIncomeMulti2019', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfIncomeMulti2019, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportGeneralJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportGeneralJournal, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportJournalXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportJournalXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.printJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPrintJournal, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Cetak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsJournal', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsJournal, 'class' => 'form-check-input']);
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
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportGeneralLedger', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportGeneralLedger, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfGeneralLedger', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfGeneralLedger, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsGeneralLedger', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsGeneralLedger, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportOrdinaryBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportOrdinaryBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsOrdinaryBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsOrdinaryBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfOrdinaryBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfOrdinaryBalanceSheet, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportPercentBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportPercentBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsPercentBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsPercentBalanceSheet, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfPercentBalanceSheet', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfPercentBalanceSheet, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalanceSheetPercent', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalanceSheetPercent, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsBalanceSheetPercent', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsBalanceSheetPercent, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfBalanceSheetPercent', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfBalanceSheetPercent, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalance, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalanceXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalanceXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportBalancePdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportBalancePdf, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioLiquiditas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioLiquiditas, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Liquiditas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioLiquiditasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioLiquiditasXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Liquiditas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioLiquiditasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioLiquiditasPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Liquiditas (PDF)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioSolvabilitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioSolvabilitas, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Solvabilitas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioSolvabilitasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioSolvabilitasXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Solvabilitas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioSolvabilitasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioSolvabilitasPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Solvabilitas (PDF)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioRentabilitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioRentabilitas, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Rentabilitas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioRentabilitasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioRentabilitasXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Rentabilitas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioRentabilitasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioRentabilitasPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Rentabilitas (PDF)</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioAktivitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioAktivitas, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Aktivitas</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioAktivitasXls', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioAktivitasXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rasio Aktivitas (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.financialRatioAktivitasPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalFinancialRatioAktivitasPdf, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportTrialBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportTrialBalance, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsTrialBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsTrialBalance, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.reportTrialBalanceNew', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportTrialBalanceNew, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">(Laporan)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsTrialBalanceNew', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsTrialBalanceNew, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">(Laporan) Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.pdfTrialBalanceNew', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalPdfTrialBalanceNew, 'class' => 'form-check-input']);
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
                                        echo $this->Form->checkbox('Rules.accjournals.reportEkuitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalReportEkuitas, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.accjournals.xlsEkuitas', ['value' => '1', 'hiddenField' => true, 'checked' => $accJournalXlsEkuitas, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Piutang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.piutang', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePiutang, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.piutangXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePiutangXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Piutang (Per-Pelanggan)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.piutangPerCustomer', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePiutangPerCustomer, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.piutangPerCustomerXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoicePiutangPerCustomerXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Umur Piutang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangReport', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Umur Piutang (Per-Kelompok Pelanggan)</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangGroupReport', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangGroupReport, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Laporan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangGroupXls', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangGroupXls, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangGroupXlsNosa', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangGroupXlsNosa, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel (Tnp Saldo Awal)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.invoices.umurPiutangGroupPdf', ['value' => '1', 'hiddenField' => true, 'checked' => $invoiceUmurPiutangGroupPdf, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">PDF</label>
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