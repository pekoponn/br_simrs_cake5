<?php

ini_set('precision', 14);

//define("Invoice_number", $invoiceNumber);
// Extend the TCPDF class to create custom Header and Footer
class XTCPDF extends TCPDF {
	
	public $headerImage;
 	public $footerImage;

    public function setDataHeader($headerImage){
    	$this->headerImage = $headerImage;
    }
	
	public function setDataFooter($footerImage) {
		$this->footerImage = $footerImage;
	}

	function Header() {
		
		// pr($headerImage);
		//global $delivery_to_camper_string;

		// Logo
		//$image_file = 'img/'.$branch["header"];
		//$headerImg = "img/".$this->headerImage;
		//$this->Image($headerImg, 0, -1, 210, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	}

	// Page footer
	function Footer() {
		// Position at 15 mm from bottom
		// $pdf->SetXY(110, 200);
		// $pdf->Image('img/kop-surat-footer-artama.jpg', '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 1, false, false, false);

		$this->SetY(-15);
		// Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Hal : '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 10, 'Hal : '.date('d m Y'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        
		//$footerImg = "img/".$this->footerImage;

		// if($this->footerImage=='footer-artama.jpg') {
		// 	$this->Image($footerImg, 0, 270, 210, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// } elseif($this->footerImage=='footer-artama.jpg') {
		// 	$this->Image($footerImg, 0, 284, 210, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// }

	}
	
}

//$pdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
//$pdf = new XTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// $pdf->getPageSizeFromFormat('A5');

//$pdf->setDataHeader($branch['header']);
//$pdf->setDataFooter($branch['footer']);
//$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('KersenSoft');
$pdf->SetTitle('Neraca');
$pdf->SetSubject('Neraca');
$pdf->SetKeywords('Neraca');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$marginLeft = 15;
$marginTop = 15;
$marginRight = 15;

$pdf->SetMargins($marginLeft, $marginTop, $marginRight, true);
// $pdf->SetHeaderMargin(0);
// $pdf->SetFooterMargin(0);
$marginBottom = 15;

// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetFooterMargin(0);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, $marginBottom);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//set margins
	// $marginLeft = 12;
	// $marginTop = 0;
	// $marginRight = 0;
	
	// $pdf->SetMargins($marginLeft, $marginTop, $marginRight, true);
	// $pdf->SetHeaderMargin(0);
	// $pdf->SetFooterMargin(0);
	// $marginBottom = 25;
	// $marginTop = 45;
	
	// $pdf->SetMargins(PDF_MARGIN_LEFT, $marginTop, PDF_MARGIN_RIGHT);
	// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	// //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	// $pdf->SetFooterMargin(0);

	// //set auto page breaks
	// $pdf->SetAutoPageBreak(TRUE, $marginBottom);

	// //set image scale factor
	// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//set some language-dependent strings
	//$pdf->setLanguageArray($l);

	// ---------------------------------------------------------
	// add a page
	//$pdf->AddPage();
	$pdf->AddPage('L', 'A4');
	//-------------------- EOR -----------------------------------------
	// set font
	// set font
	//$pdf->SetFont('helvetica', '', 12);
	$pdf->SetFont('helvetica', '', 9);
	$tbl = '<table width="100%" cellspacing="0" cellpadding="1" border="0">	
		<tr>
			<td>
				<table cellspacing="0" cellpadding="1" width="100%" border="0">
					<tr>
						<td align="center" style="font-weight:bold;font-size:12pt;">NERACA SALDO</td>

					</tr>
					<tr>
						<td align="center" style="font-weight:bold;font-size:12pt;">'.$this->Krs->companyName.'</td>

					</tr>
					<tr>
						<td align="center" style="font-weight:bold;font-size:12pt;">'.$this->Time->format("d M Y", $filterDate).'</td>
					</tr>
				</table>
			</td>
		</tr>';
	
$tbl .= '<tr>
			<td>
				<table cellspacing="0" cellpadding="1" width="100%" border="0">
					<tr>
						<td>
							<table width="100%" cellpadding="3" cellspacing="1">
							<tr>
								<td align="left" width="12%" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>NO. PERKIRAAN</b></td>
								<td align="left" width="36%" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>KETERANGAN</b></td>
								<td align="right" width="13%" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">DEBIT</td>
								<td align="right" width="13%" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">KREDIT</td>
								<td align="right" width="13%" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">SALDO AWAL</td>
								<td align="right" width="13%" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">SALDO</td>
							</tr>';

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
			//$totalKasBanks = $debetCreditDetailKasBank+$beginningBalanceDetailKasBank;
			$debetDetailKasBanks[] = $debetDetailKasBank;
			$creditDetailKasBanks[] = $creditDetailKasBank;
			$beginningDetailKasBanks[] = $beginningBalanceDetailKasBank;
			$totalDetailKasBanks[] = $subTotalDetailKasBank;
			$nominalDebetDetailKasBank = $this->Krs->__currency($debetDetailKasBank);
			$nominalCreditDetailKasBank = $this->Krs->__currency($creditDetailKasBank);
			$nominalBeginningDetailKasBank = $this->Krs->__currency($beginningBalanceDetailKasBank);
			$nominalTotalDetailKasBank = $this->Krs->__currency($subTotalDetailKasBank);

			$tbl .= '<tr>
					<td>'.$codeDetailKasBank.'</td>
					<td>'.$nameDetailKasBank.'</td>
					<td align="right">'.$nominalDebetDetailKasBank.'</td>
					<td align="right">'.$nominalCreditDetailKasBank.'</td>
					<td align="right">'.$nominalBeginningDetailKasBank.'</td>
					<td align="right">'.$nominalTotalDetailKasBank.'</td>
				</tr>';
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
			$nominalDebetDetailPiutang = $this->Krs->__currency($debetDetailPiutang);
			$nominalCreditDetailPiutang = $this->Krs->__currency($creditDetailPiutang);
			$nominalBeginningDetailPiutang = $this->Krs->__currency($beginningBalanceDetailPiutang);
			$nominalTotalDetailPiutang = $this->Krs->__currency($subTotalDetailPiutang);

			$tbl .= '<tr>
					<td>'.$codeDetailPiutang.'</td>
					<td>'.$nameDetailPiutang.'</td>
					<td align="right">'.$nominalDebetDetailPiutang.'</td>
					<td align="right">'.$nominalCreditDetailPiutang.'</td>
					<td align="right">'.$nominalBeginningDetailPiutang.'</td>
					<td align="right">'.$nominalTotalDetailPiutang.'</td>
				</tr>';
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
			$nominalDebetDetailAktivaTetap = $this->Krs->__currency($debetDetailAktivaTetap);
			$nominalCreditDetailAktivaTetap = $this->Krs->__currency($creditDetailAktivaTetap);
			$nominalBeginningDetailAktivaTetap = $this->Krs->__currency($beginningBalanceDetailAktivaTetap);
			$nominalTotalDetailAktivaTetap = $this->Krs->__currency($subTotalDetailAktivaTetap);

			$tbl .= '<tr>
					<td>'.$codeDetailAktivaTetap.'</td>
					<td>'.$nameDetailAktivaTetap.'</td>
					<td align="right">'.$nominalDebetDetailAktivaTetap.'</td>
					<td align="right">'.$nominalCreditDetailAktivaTetap.'</td>
					<td align="right">'.$nominalBeginningDetailAktivaTetap.'</td>
					<td align="right">'.$nominalTotalDetailAktivaTetap.'</td>
				</tr>';
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
			$nominalDebetDetailAkumulasiPenyusutan = $this->Krs->__currency($debetDetailAkumulasiPenyusutan);
			$nominalCreditDetailAkumulasiPenyusutan = $this->Krs->__currency($creditDetailAkumulasiPenyusutan);
			$nominalBeginningDetailAkumulasiPenyusutan = $this->Krs->__currency($beginningBalanceDetailAkumulasiPenyusutan);
			$nominalTotalDetailAkumulasiPenyusutan = $this->Krs->__currency($subTotalDetailAkumulasiPenyusutan);

			$tbl .= '<tr>
					<td>'.$codeDetailAkumulasiPenyusutan.'</td>
					<td>'.$nameDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalDebetDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalCreditDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalBeginningDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalTotalDetailAkumulasiPenyusutan.'</td>
				</tr>';
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
			$nominalDebetDetailHutang = $this->Krs->__currency($debetDetailHutang);
			$nominalCreditDetailHutang = $this->Krs->__currency($creditDetailHutang);
			$nominalBeginningDetailHutang = $this->Krs->__currency($beginningBalanceDetailHutang);
			$nominalTotalDetailHutang = $this->Krs->__currency($subTotalDetailHutang);

			$tbl .= '<tr>
					<td>'.$codeDetailHutang.'</td>
					<td>'.$nameDetailHutang.'</td>
					<td align="right">'.$nominalDebetDetailHutang.'</td>
					<td align="right">'.$nominalCreditDetailHutang.'</td>
					<td align="right">'.$nominalBeginningDetailHutang.'</td>
					<td align="right">'.$nominalTotalDetailHutang.'</td>
				</tr>';
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
			$nominalDebetDetailHutangLancar = $this->Krs->__currency($debetDetailHutangLancar);
			$nominalCreditDetailHutangLancar = $this->Krs->__currency($creditDetailHutangLancar);
			$nominalBeginningDetailHutangLancar = $this->Krs->__currency($beginningBalanceDetailHutangLancar);
			$nominalTotalDetailHutangLancar = $this->Krs->__currency($subTotalDetailHutangLancar);

			$tbl .= '<tr>
					<td>'.$codeDetailHutangLancar.'</td>
					<td>'.$nameDetailHutangLancar.'</td>
					<td align="right">'.$nominalDebetDetailHutangLancar.'</td>
					<td align="right">'.$nominalCreditDetailHutangLancar.'</td>
					<td align="right">'.$nominalBeginningDetailHutangLancar.'</td>
					<td align="right">'.$nominalTotalDetailHutangLancar.'</td>
				</tr>';
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
			$nominalDebetDetailModal = $this->Krs->__currency($debetDetailModal);
			$nominalCreditDetailModal = $this->Krs->__currency($creditDetailModal);
			$nominalBeginningDetailModal = $this->Krs->__currency($beginningBalanceDetailModal);
			$nominalTotalDetailModal = $this->Krs->__currency($subTotalDetailModal);

			$tbl .= '<tr>
					<td>'.$codeDetailModal.'</td>
					<td>'.$nameDetailModal.'</td>
					<td align="right">'.$nominalDebetDetailModal.'</td>
					<td align="right">'.$nominalCreditDetailModal.'</td>
					<td align="right">'.$nominalBeginningDetailModal.'</td>
					<td align="right">'.$nominalTotalDetailModal.'</td>
				</tr>';
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
			$debetSaldoDitahan = $debetDetailBeforeSaldoDitahan+$totalGrandBeforeDebetLabaRugiBerjalan+$grandTotalBeforeDebetPrive;
			$creditSaldoDitahan = $creditDetailBeforeSaldoDitahan+$totalGrandBeforeCreditLabaRugiBerjalan+$grandTotalBeforeCreditPrive;
			//totalGrandBeforeCreditLabaRugiBerjalan
			
			$debetDetailSaldoDitahans[] = $debetSaldoDitahan;
			$creditDetailSaldoDitahans[] = $creditSaldoDitahan;
			$beginningDetailSaldoDitahans[] = $beginningBalanceDetailSaldoDitahan;
			$totalDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
			$nominalDebetDetailSaldoDitahan = $this->Krs->__currency($debetSaldoDitahan);
			$nominalCreditDetailSaldoDitahan = $this->Krs->__currency($creditSaldoDitahan);
			$nominalBeginningDetailSaldoDitahan = $this->Krs->__currency($beginningBalanceDetailSaldoDitahan);
			$nominalTotalDetailSaldoDitahan = $this->Krs->__currency($subTotalBeforeSaldoDitahan);

			$tbl .= '<tr>
					<td>'.$codeDetailSaldoDitahan.'</td>
					<td>'.$nameDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalDebetDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalCreditDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalBeginningDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalTotalDetailSaldoDitahan.'</td>
				</tr>';
		}
	}
}


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
			$nominalDebetDetailPrive = $this->Krs->__currency($debetDetailPrive);
			$nominalCreditDetailPrive = $this->Krs->__currency($creditDetailPrive);
			$nominalBeginningDetailPrive = $this->Krs->__currency($beginningBalanceDetailPrive);
			$nominalTotalDetailPrive = $this->Krs->__currency($subTotalDetailPrive);

			$tbl .= '<tr>
					<td>'.$codeDetailPrive.'</td>
					<td>'.$nameDetailPrive.'</td>
					<td align="right">'.$nominalDebetDetailPrive.'</td>
					<td align="right">'.$nominalCreditDetailPrive.'</td>
					<td align="right">'.$nominalBeginningDetailPrive.'</td>
					<td align="right">'.$nominalTotalDetailPrive.'</td>
				</tr>';
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
			$nominalDebetDetailPendapatanShow = $this->Krs->__currency($debetDetailPendapatanShow);
			$nominalCreditDetailPendapatanShow = $this->Krs->__currency($creditDetailPendapatanShow);
			$nominalBeginningDetailPendapatanShow = $this->Krs->__currency($beginningBalanceDetailPendapatanShow);
			$nominalTotalDetailPendapatanShow = $this->Krs->__currency($subTotalDetailPendapatanShow);

			$tbl .= '<tr>
					<td>'.$codeDetailPendapatanShow.'</td>
					<td>'.$nameDetailPendapatanShow.'</td>
					<td align="right">'.$nominalDebetDetailPendapatanShow.'</td>
					<td align="right">'.$nominalCreditDetailPendapatanShow.'</td>
					<td align="right">'.$nominalBeginningDetailPendapatanShow.'</td>
					<td align="right">'.$nominalTotalDetailPendapatanShow.'</td>
				</tr>';
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
			$nominalDebetDetailPendapatanLain = $this->Krs->__currency($debetDetailPendapatanLain);
			$nominalCreditDetailPendapatanLain = $this->Krs->__currency($creditDetailPendapatanLain);
			$nominalBeginningDetailPendapatanLain = $this->Krs->__currency($beginningBalanceDetailPendapatanLain);
			$nominalTotalDetailPendapatanLain = $this->Krs->__currency($subTotalDetailPendapatanLain);

			$tbl .= '<tr>
					<td>'.$codeDetailPendapatanLain.'</td>
					<td>'.$nameDetailPendapatanLain.'</td>
					<td align="right">'.$nominalDebetDetailPendapatanLain.'</td>
					<td align="right">'.$nominalCreditDetailPendapatanLain.'</td>
					<td align="right">'.$nominalBeginningDetailPendapatanLain.'</td>
					<td align="right">'.$nominalTotalDetailPendapatanLain.'</td>
				</tr>';
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
			$nominalDebetDetailBeban = $this->Krs->__currency($debetDetailBeban);
			$nominalCreditDetailBeban = $this->Krs->__currency($creditDetailBeban);
			$nominalBeginningDetailBeban = $this->Krs->__currency($beginningBalanceDetailBeban);
			$nominalTotalDetailBeban = $this->Krs->__currency($subTotalDetailBeban);

			$tbl .= '<tr>
					<td>'.$codeDetailBeban.'</td>
					<td>'.$nameDetailBeban.'</td>
					<td align="right">'.$nominalDebetDetailBeban.'</td>
					<td align="right">'.$nominalCreditDetailBeban.'</td>
					<td align="right">'.$nominalBeginningDetailBeban.'</td>
					<td align="right">'.$nominalTotalDetailBeban.'</td>
				</tr>';
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
			$nominalDebetDetailBebanPemasaran = $this->Krs->__currency($debetDetailBebanPemasaran);
			$nominalCreditDetailBebanPemasaran = $this->Krs->__currency($creditDetailBebanPemasaran);
			$nominalBeginningDetailBebanPemasaran = $this->Krs->__currency($beginningBalanceDetailBebanPemasaran);
			$nominalTotalDetailBebanPemasaran = $this->Krs->__currency($subTotalDetailBebanPemasaran);

			$tbl .= '<tr>
					<td>'.$codeDetailBebanPemasaran.'</td>
					<td>'.$nameDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalDebetDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalCreditDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalBeginningDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalTotalDetailBebanPemasaran.'</td>
				</tr>';
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
			$nominalDebetDetailBebanLainLain = $this->Krs->__currency($debetDetailBebanLainLain);
			$nominalCreditDetailBebanLainLain = $this->Krs->__currency($creditDetailBebanLainLain);
			$nominalBeginningDetailBebanLainLain = $this->Krs->__currency($beginningBalanceDetailBebanLainLain);
			$nominalTotalDetailBebanLainLain = $this->Krs->__currency($subTotalDetailBebanLainLain);

			$tbl .= '<tr>
					<td>'.$codeDetailBebanLainLain.'</td>
					<td>'.$nameDetailBebanLainLain.'</td>
					<td align="right">'.$nominalDebetDetailBebanLainLain.'</td>
					<td align="right">'.$nominalCreditDetailBebanLainLain.'</td>
					<td align="right">'.$nominalBeginningDetailBebanLainLain.'</td>
					<td align="right">'.$nominalTotalDetailBebanLainLain.'</td>
				</tr>';
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
			$nominalDebetDetailHargaPokokPenjualan = $this->Krs->__currency($debetDetailHargaPokokPenjualan);
			$nominalCreditDetailHargaPokokPenjualan = $this->Krs->__currency($creditDetailHargaPokokPenjualan);
			$nominalBeginningDetailHargaPokokPenjualan = $this->Krs->__currency($beginningBalanceDetailHargaPokokPenjualan);
			$nominalTotalDetailHargaPokokPenjualan = $this->Krs->__currency($subTotalDetailHargaPokokPenjualan);

			$tbl .= '<tr>
					<td>'.$codeDetailHargaPokokPenjualan.'</td>
					<td>'.$nameDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalDebetDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalCreditDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalBeginningDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalTotalDetailHargaPokokPenjualan.'</td>
				</tr>';
		}
	}
}


/*
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
			//$totalKasBanks = $debetCreditDetailKasBank+$beginningBalanceDetailKasBank;
			$debetDetailKasBanks[] = $debetDetailKasBank;
			$creditDetailKasBanks[] = $creditDetailKasBank;
			$beginningDetailKasBanks[] = $beginningBalanceDetailKasBank;
			$totalDetailKasBanks[] = $subTotalDetailKasBank;
			$nominalDebetDetailKasBank = $this->Krs->__currency($debetDetailKasBank);
			$nominalCreditDetailKasBank = $this->Krs->__currency($creditDetailKasBank);
			$nominalBeginningDetailKasBank = $this->Krs->__currency($beginningBalanceDetailKasBank);
			$nominalTotalDetailKasBank = $this->Krs->__currency($subTotalDetailKasBank);

			$tbl .= '<tr>
					<td>'.$codeDetailKasBank.'</td>
					<td>'.$nameDetailKasBank.'</td>
					<td align="right">'.$nominalDebetDetailKasBank.'</td>
					<td align="right">'.$nominalCreditDetailKasBank.'</td>
					<td align="right">'.$nominalBeginningDetailKasBank.'</td>
					<td align="right">'.$nominalTotalDetailKasBank.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailPiutang = $this->Krs->__currency($debetDetailPiutang);
			$nominalCreditDetailPiutang = $this->Krs->__currency($creditDetailPiutang);
			$nominalBeginningDetailPiutang = $this->Krs->__currency($beginningBalanceDetailPiutang);
			$nominalTotalDetailPiutang = $this->Krs->__currency($subTotalDetailPiutang);

			$tbl .= '<tr>
					<td>'.$codeDetailPiutang.'</td>
					<td>'.$nameDetailPiutang.'</td>
					<td align="right">'.$nominalDebetDetailPiutang.'</td>
					<td align="right">'.$nominalCreditDetailPiutang.'</td>
					<td align="right">'.$nominalBeginningDetailPiutang.'</td>
					<td align="right">'.$nominalTotalDetailPiutang.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailAktivaTetap = $this->Krs->__currency($debetDetailAktivaTetap);
			$nominalCreditDetailAktivaTetap = $this->Krs->__currency($creditDetailAktivaTetap);
			$nominalBeginningDetailAktivaTetap = $this->Krs->__currency($beginningBalanceDetailAktivaTetap);
			$nominalTotalDetailAktivaTetap = $this->Krs->__currency($subTotalDetailAktivaTetap);

			$tbl .= '<tr>
					<td>'.$codeDetailAktivaTetap.'</td>
					<td>'.$nameDetailAktivaTetap.'</td>
					<td align="right">'.$nominalDebetDetailAktivaTetap.'</td>
					<td align="right">'.$nominalCreditDetailAktivaTetap.'</td>
					<td align="right">'.$nominalBeginningDetailAktivaTetap.'</td>
					<td align="right">'.$nominalTotalDetailAktivaTetap.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailAkumulasiPenyusutan = $this->Krs->__currency($debetDetailAkumulasiPenyusutan);
			$nominalCreditDetailAkumulasiPenyusutan = $this->Krs->__currency($creditDetailAkumulasiPenyusutan);
			$nominalBeginningDetailAkumulasiPenyusutan = $this->Krs->__currency($beginningBalanceDetailAkumulasiPenyusutan);
			$nominalTotalDetailAkumulasiPenyusutan = $this->Krs->__currency($subTotalDetailAkumulasiPenyusutan);

			$tbl .= '<tr>
					<td>'.$codeDetailAkumulasiPenyusutan.'</td>
					<td>'.$nameDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalDebetDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalCreditDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalBeginningDetailAkumulasiPenyusutan.'</td>
					<td align="right">'.$nominalTotalDetailAkumulasiPenyusutan.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailHutang = $this->Krs->__currency($debetDetailHutang);
			$nominalCreditDetailHutang = $this->Krs->__currency($creditDetailHutang);
			$nominalBeginningDetailHutang = $this->Krs->__currency($beginningBalanceDetailHutang);
			$nominalTotalDetailHutang = $this->Krs->__currency($subTotalDetailHutang);

			$tbl .= '<tr>
					<td>'.$codeDetailHutang.'</td>
					<td>'.$nameDetailHutang.'</td>
					<td align="right">'.$nominalDebetDetailHutang.'</td>
					<td align="right">'.$nominalCreditDetailHutang.'</td>
					<td align="right">'.$nominalBeginningDetailHutang.'</td>
					<td align="right">'.$nominalTotalDetailHutang.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailHutangLancar = $this->Krs->__currency($debetDetailHutangLancar);
			$nominalCreditDetailHutangLancar = $this->Krs->__currency($creditDetailHutangLancar);
			$nominalBeginningDetailHutangLancar = $this->Krs->__currency($beginningBalanceDetailHutangLancar);
			$nominalTotalDetailHutangLancar = $this->Krs->__currency($subTotalDetailHutangLancar);

			$tbl .= '<tr>
					<td>'.$codeDetailHutangLancar.'</td>
					<td>'.$nameDetailHutangLancar.'</td>
					<td align="right">'.$nominalDebetDetailHutangLancar.'</td>
					<td align="right">'.$nominalCreditDetailHutangLancar.'</td>
					<td align="right">'.$nominalBeginningDetailHutangLancar.'</td>
					<td align="right">'.$nominalTotalDetailHutangLancar.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailModal = $this->Krs->__currency($debetDetailModal);
			$nominalCreditDetailModal = $this->Krs->__currency($creditDetailModal);
			$nominalBeginningDetailModal = $this->Krs->__currency($beginningBalanceDetailModal);
			$nominalTotalDetailModal = $this->Krs->__currency($subTotalDetailModal);

			$tbl .= '<tr>
					<td>'.$codeDetailModal.'</td>
					<td>'.$nameDetailModal.'</td>
					<td align="right">'.$nominalDebetDetailModal.'</td>
					<td align="right">'.$nominalCreditDetailModal.'</td>
					<td align="right">'.$nominalBeginningDetailModal.'</td>
					<td align="right">'.$nominalTotalDetailModal.'</td>';
			$tbl .= '</tr>';
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
			//$totalModals = $debetCreditDetailModal+$beginningBalanceDetailModal;

			//$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan;
			//$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;

			$subTotalBeforeSaldoDitahan = $subTotalDetailBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
			//$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
			//$totalBeforeSaldoDitahan = $subTotalBeforeSaldoDitahan;
			//$nominalDetailSaldoDitahan = $this->Krs->__currency($subTotalBeforeSaldoDitahan);

			//$debetSaldoDitahan = $debetDetailBeforeSaldoDitahan;
			//$creditSaldoDitahan = $creditDetailBeforeSaldoDitahan;
			//+$debetDetailSaldoDitahan
			//+$creditDetailSaldoDitahan
			$debetSaldoDitahan = $debetDetailBeforeSaldoDitahan+$totalGrandBeforeDebetLabaRugiBerjalan+$grandTotalBeforeDebetPrive;
			$creditSaldoDitahan = $creditDetailBeforeSaldoDitahan+$totalGrandBeforeCreditLabaRugiBerjalan+$grandTotalBeforeCreditPrive;
			//totalGrandBeforeCreditLabaRugiBerjalan
			$totalkus = $debetSaldoDitahan+$beginningBalanceDetailSaldoDitahan-$creditSaldoDitahan;
			$totalku = $this->Krs->__currency($totalkus);
			// $debetSaldoDitahan = $totalGrandBeforeDebetLabaRugiBerjalan+$debetDetailBeforeSaldoDitahan+$debetDetailSaldoDitahan+$grandTotalBeforeDebetPrive;
			// $creditSaldoDitahan = $totalGrandBeforeCreditLabaRugiBerjalan+$creditDetailBeforeSaldoDitahan+$creditDetailSaldoDitahan+$grandTotalBeforeCreditPrive;
			//$debetDetailSaldoDitahans[] = 0;
			//$creditDetailSaldoDitahans[] = 0;
			$debetDetailSaldoDitahans[] = $debetSaldoDitahan;
			$creditDetailSaldoDitahans[] = $creditSaldoDitahan;
			$beginningDetailSaldoDitahans[] = $beginningBalanceDetailSaldoDitahan;
			$totalDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
			$nominalDebetDetailSaldoDitahan = $this->Krs->__currency($debetSaldoDitahan);
			$nominalCreditDetailSaldoDitahan = $this->Krs->__currency($creditSaldoDitahan);
			$nominalBeginningDetailSaldoDitahan = $this->Krs->__currency($beginningBalanceDetailSaldoDitahan);
			$nominalTotalDetailSaldoDitahan = $this->Krs->__currency($subTotalBeforeSaldoDitahan);

			//$totalBeforeDebetLabaRugiBerjalanInfo = $grandTotalBeforeCreditPendapatan.'^'.$grandTotalBeforeCreditPendapatanLain.'^'.$grandTotalBeforeCreditHargaPokokPenjualan.'^'.$grandTotalBeforeCreditBeban.'^'.$grandTotalBeforeCreditBebanPemasaran.'^'.$grandTotalBeforeCreditBebanLainLain;
			// list($lrPendapatan, $lrPendapatanLain, $lrHargaPokokPenjualan, $lrBeban, $lrBebanPemasaran, $lrBebanLainLain) = explode('^', $totalBeforeLabaRugiBerjalanInfo);

			// list($lrDebetPendapatan, $lrDebetPendapatanLain, $lrDebetHargaPokokPenjualan, $lrDebetBeban, $lrDebetBebanPemasaran, $lrDebetBebanLainLain) = explode('^', $totalBeforeDebetLabaRugiBerjalanInfo);
			// list($lrCreditPendapatan, $lrCreditPendapatanLain, $lrCreditHargaPokokPenjualan, $lrCreditBeban, $lrCreditBebanPemasaran, $lrCreditBebanLainLain) = explode('^', $totalBeforeCreditLabaRugiBerjalanInfo);

			// $infoLR = "Pendapatan = ".$lrPendapatan."<br>"."Pendapatan Lain = ".$lrPendapatanLain."<br>"."HPP = ".$lrHargaPokokPenjualan."<br>"."Beban = ".$lrBeban."<br>"."Beban Pemasaran = ".$lrBebanPemasaran."<br>"."Beban Lain-lain = ".$lrBebanLainLain;

			// $infoLRDebet = "Pendapatan = ".$lrDebetPendapatan."<br>"."Pendapatan Lain = ".$lrDebetPendapatanLain."<br>"."HPP = ".$lrDebetHargaPokokPenjualan."<br>"."Beban = ".$lrDebetBeban."<br>"."Beban Pemasaran = ".$lrDebetBebanPemasaran."<br>"."Beban Lain-lain = ".$lrDebetBebanLainLain;
			// $infoLRCredit = "Pendapatan = ".$lrCreditPendapatan."<br>"."Pendapatan Lain = ".$lrCreditPendapatanLain."<br>"."HPP = ".$lrCreditHargaPokokPenjualan."<br>"."Beban = ".$lrCreditBeban."<br>"."Beban Pemasaran = ".$lrCreditBebanPemasaran."<br>"."Beban Lain-lain = ".$lrCreditBebanLainLain;
			//.' = '.$debetDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeDebetLabaRugiBerjalan.'+'.$grandTotalBeforeDebetPrive
			//.' = '.$creditDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeCreditLabaRugiBerjalan.'+'.$grandTotalBeforeCreditPrive.

			$tbl .= '<tr>
					<td>'.$codeDetailSaldoDitahan.'</td>
					<td>'.$nameDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalDebetDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalCreditDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalBeginningDetailSaldoDitahan.'</td>
					<td align="right">'.$nominalTotalDetailSaldoDitahan.'</td>';
			$tbl .= '</tr>';
		}
	}
}

//$tbl .= '</tr>';

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
			$nominalDebetDetailPrive = $this->Krs->__currency($debetDetailPrive);
			$nominalCreditDetailPrive = $this->Krs->__currency($creditDetailPrive);
			$nominalBeginningDetailPrive = $this->Krs->__currency($beginningBalanceDetailPrive);
			$nominalTotalDetailPrive = $this->Krs->__currency($subTotalDetailPrive);

			$tbl .= '<tr>
					<td>'.$codeDetailPrive.'</td>
					<td>'.$nameDetailPrive.'</td>
					<td align="right">'.$nominalDebetDetailPrive.'</td>
					<td align="right">'.$nominalCreditDetailPrive.'</td>
					<td align="right">'.$nominalBeginningDetailPrive.'</td>
					<td align="right">'.$nominalTotalDetailPrive.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailPendapatanShow = $this->Krs->__currency($debetDetailPendapatanShow);
			$nominalCreditDetailPendapatanShow = $this->Krs->__currency($creditDetailPendapatanShow);
			$nominalBeginningDetailPendapatanShow = $this->Krs->__currency($beginningBalanceDetailPendapatanShow);
			$nominalTotalDetailPendapatanShow = $this->Krs->__currency($subTotalDetailPendapatanShow);

			$tbl .= '<tr>
					<td>'.$codeDetailPendapatanShow.'</td>
					<td>'.$nameDetailPendapatanShow.'</td>
					<td align="right">'.$nominalDebetDetailPendapatanShow.'</td>
					<td align="right">'.$nominalCreditDetailPendapatanShow.'</td>
					<td align="right">'.$nominalBeginningDetailPendapatanShow.'</td>
					<td align="right">'.$nominalTotalDetailPendapatanShow.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailPendapatanLain = $this->Krs->__currency($debetDetailPendapatanLain);
			$nominalCreditDetailPendapatanLain = $this->Krs->__currency($creditDetailPendapatanLain);
			$nominalBeginningDetailPendapatanLain = $this->Krs->__currency($beginningBalanceDetailPendapatanLain);
			$nominalTotalDetailPendapatanLain = $this->Krs->__currency($subTotalDetailPendapatanLain);

			$tbl .= '<tr>
					<td>'.$codeDetailPendapatanLain.'</td>
					<td>'.$nameDetailPendapatanLain.'</td>
					<td align="right">'.$nominalDebetDetailPendapatanLain.'</td>
					<td align="right">'.$nominalCreditDetailPendapatanLain.'</td>
					<td align="right">'.$nominalBeginningDetailPendapatanLain.'</td>
					<td align="right">'.$nominalTotalDetailPendapatanLain.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailBeban = $this->Krs->__currency($debetDetailBeban);
			$nominalCreditDetailBeban = $this->Krs->__currency($creditDetailBeban);
			$nominalBeginningDetailBeban = $this->Krs->__currency($beginningBalanceDetailBeban);
			$nominalTotalDetailBeban = $this->Krs->__currency($subTotalDetailBeban);

			$tbl .= '<tr>
					<td>'.$codeDetailBeban.'</td>
					<td>'.$nameDetailBeban.'</td>
					<td align="right">'.$nominalDebetDetailBeban.'</td>
					<td align="right">'.$nominalCreditDetailBeban.'</td>
					<td align="right">'.$nominalBeginningDetailBeban.'</td>
					<td align="right">'.$nominalTotalDetailBeban.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailBebanPemasaran = $this->Krs->__currency($debetDetailBebanPemasaran);
			$nominalCreditDetailBebanPemasaran = $this->Krs->__currency($creditDetailBebanPemasaran);
			$nominalBeginningDetailBebanPemasaran = $this->Krs->__currency($beginningBalanceDetailBebanPemasaran);
			$nominalTotalDetailBebanPemasaran = $this->Krs->__currency($subTotalDetailBebanPemasaran);

			$tbl .= '<tr>
					<td>'.$codeDetailBebanPemasaran.'</td>
					<td>'.$nameDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalDebetDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalCreditDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalBeginningDetailBebanPemasaran.'</td>
					<td align="right">'.$nominalTotalDetailBebanPemasaran.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailBebanLainLain = $this->Krs->__currency($debetDetailBebanLainLain);
			$nominalCreditDetailBebanLainLain = $this->Krs->__currency($creditDetailBebanLainLain);
			$nominalBeginningDetailBebanLainLain = $this->Krs->__currency($beginningBalanceDetailBebanLainLain);
			$nominalTotalDetailBebanLainLain = $this->Krs->__currency($subTotalDetailBebanLainLain);

			$tbl .= '<tr>
					<td>'.$codeDetailBebanLainLain.'</td>
					<td>'.$nameDetailBebanLainLain.'</td>
					<td align="right">'.$nominalDebetDetailBebanLainLain.'</td>
					<td align="right">'.$nominalCreditDetailBebanLainLain.'</td>
					<td align="right">'.$nominalBeginningDetailBebanLainLain.'</td>
					<td align="right">'.$nominalTotalDetailBebanLainLain.'</td>';
			$tbl .= '</tr>';
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
			$nominalDebetDetailHargaPokokPenjualan = $this->Krs->__currency($debetDetailHargaPokokPenjualan);
			$nominalCreditDetailHargaPokokPenjualan = $this->Krs->__currency($creditDetailHargaPokokPenjualan);
			$nominalBeginningDetailHargaPokokPenjualan = $this->Krs->__currency($beginningBalanceDetailHargaPokokPenjualan);
			$nominalTotalDetailHargaPokokPenjualan = $this->Krs->__currency($subTotalDetailHargaPokokPenjualan);

			$tbl .= '<tr>
					<td>'.$codeDetailHargaPokokPenjualan.'</td>
					<td>'.$nameDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalDebetDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalCreditDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalBeginningDetailHargaPokokPenjualan.'</td>
					<td align="right">'.$nominalTotalDetailHargaPokokPenjualan.'</td>';
			$tbl .= '</tr>';
		}
	}
}

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

$totalDebetSum = $totalDebetKasBankSums+$totalDebetPiutangSums+$totalDebetAktivaTetapSums+$totalDebetAkumulasiPenyusutanSums+$totalDebetHutangSums+$totalDebetHutangLancarSums+$totalDebetModalSums+$totalDebetSaldoDitahanSums+$totalDebetPriveSums+$totalDebetPendapatanShowSums+$totalDebetPendapatanLainSums+$totalDebetHargaPokokPenjualanSums+$totalDebetBebanLainLainSums+$totalDebetBebanSums+$totalDebetBebanPemasaranSums;

$totalCreditSum = $totalCreditKasBankSums+$totalCreditPiutangSums+$totalCreditAktivaTetapSums+$totalCreditAkumulasiPenyusutanSums+$totalCreditHutangSums+$totalCreditHutangLancarSums+$totalCreditModalSums+$totalCreditSaldoDitahanSums+$totalCreditPriveSums+$totalCreditPendapatanShowSums+$totalCreditPendapatanLainSums+$totalCreditHargaPokokPenjualanSums+$totalCreditBebanLainLainSums+$totalCreditBebanSums+$totalCreditBebanPemasaranSums;

$totalBeginningSum = $totalBeginningKasBankSums+$totalBeginningPiutangSums+$totalBeginningAktivaTetapSums+$totalBeginningAkumulasiPenyusutanSums+$totalBeginningHutangSums+$totalBeginningHutangLancarSums+$totalBeginningModalSums+$totalBeginningSaldoDitahanSums+$totalBeginningPriveSums+$totalBeginningPendapatanShowSums+$totalBeginningPendapatanLainSums+$totalBeginningHargaPokokPenjualanSums+$totalBeginningBebanLainLainSums+$totalBeginningBebanSums+$totalBeginningBebanPemasaranSums;

$totalGrandSum = $totalGrandKasBankSums+$totalGrandPiutangSums+$totalGrandAktivaTetapSums+$totalGrandAkumulasiPenyusutanSums+$totalGrandHutangSums+$totalGrandHutangLancarSums+$totalGrandModalSums+$totalGrandSaldoDitahanSums+$totalGrandPriveSums+$totalGrandLabaRugiBerjalan+$totalGrandPendapatanShowSums+$totalGrandPendapatanLainSums+$totalGrandHargaPokokPenjualanSums+$totalGrandBebanLainLainSums+$totalGrandBebanSums+$totalGrandBebanPemasaranSums;

//$totalGrandBalances = $totalBeginningSum+$totalDebetSum-$totalCreditSum-$totalGrandSum;
$totalGrandBalances = $totalBeginningSum+$totalDebetSum-$totalCreditSum;
$totalGrandBalance = $this->Krs->nominal($totalGrandBalances);

$totalDebetNominal = $this->Krs->nominal($totalDebetSum);
$totalCreditNominal = $this->Krs->nominal($totalCreditSum);
$totalBeginningNominal = $this->Krs->nominal($totalBeginningSum);
$totalGrandNominal = $this->Krs->nominal($totalGrandSum);
//$totalGrandBalance = 0;
$tbl .= '<tr>
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
	*/


				$tbl .= '</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>';


	//pr($tbl);
	$pdf->writeHTML($tbl, true, false, false, false, '');
	//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
	

	//pr($tbl);

	//$pdf->writeHTML($footers, true, false, false, false, '');
	$pdf->Output('Neraca_'.$filterDate.'.pdf', 'D');
	// $pdf->Output('Neraca_'.$dateJournals.'.pdf', 'D');

?>
