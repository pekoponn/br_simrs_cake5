<?php
if(is_array(!empty($dataBeginningBalance))){
	$accBeginingBalance = $dataBeginningBalance["AccBeginningBalance"];
	$dates = $accBeginingBalance["dates"];
}

ini_set('precision', 14);
$dataDate = $this->Krs->decode_arr($dateFilter);
list($filterDateStarts, $filterDateEnds) = explode("^", $dataDate);
$totalMonth = $monthEnd-$monthFrom;
//pr($totalMonth);
//pr($filterDateStarts);
list($monthFrom, $yearFrom) = explode("-", $filterDateStarts);
list($monthEnd, $yearEnd) = explode("-", $filterDateEnds);

$filterDateStart = $this->Krs->get_month($monthFrom);
$filterDateEnd = $this->Krs->get_month($monthEnd);

// $filterDateStart = (empty($filterDateStarts)) ? "":strtoupper($this->Krs->date_indo($filterDateStarts,false));
// $filterDateEnd = (empty($filterDateEnds)) ? "":strtoupper($this->Krs->date_indo($filterDateEnds));

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

	// ---------------------------------------------------------
	// add a page
	//$pdf->AddPage();
	$typePaper = ($totalMonth>=2) ? 'L' : 'P';
	$pdf->AddPage($typePaper, 'A4');
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
						<td align="center" style="font-weight:bold;font-size:11pt;">'.$this->Krs->companyName.'</td>
					</tr>
					<tr>
						<td align="center" style="font-weight:bold;font-size:11pt;">LAPORAN LABA / RUGI</td>
					</tr>
					<tr>
						<td align="center" style="font-weight:bold;font-size:11pt;">BULAN '.$filterDateStart.' s/d '.$filterDateEnd.'</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" cellpadding="3" cellspacing="3">';
$widthDesc = ($totalMonth>=2) ? "30%" : "46%";
$widthMonthNominal = ($totalMonth>=2) ? "12%" : "16%";
$widthPercent = ($totalMonth>=2) ? "8%" : "10%";

$tbl .= '<tr>
	<td align="center" width="'.$widthDesc.'" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>Keterangan</b></td>';
	for ($i=$monthFrom; $i <= $monthEnd; $i++) {
		$monthIndo = $this->Krs->get_month($i);

	$tbl .= '<td align="center" width="'.$widthMonthNominal.'" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$monthIndo.'</b></td>
	<td align="center" width="'.$widthPercent.'" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">%</td>';
	}
$tbl .= '</tr>';

//pr($listCOAPendapatan);
$dataMonth = $monthFrom.'^'.$monthEnd;
$listCOASubTotalPendapatan = $this->Krs->incomeMultiPercentNew($listCOAPendapatan, $dataMonth, 'pendapatan');
$listCOASubTotalPotonganPenjualan = $this->Krs->incomeMultiPercentNew($listCOAPotonganPenjualan, $dataMonth, 'potongan_penjualan');
$listCOASubTotalBeban = $this->Krs->incomeMultiPercentNew($listCOABeban, $dataMonth, 'beban');
$listCOASubTotalPendapatanLain = $this->Krs->incomeMultiPercentNew($listCOAPendapatanLain, $dataMonth, 'pendapatan_lain');
$listCOASubTotalHargaPokokPenjualan = $this->Krs->incomeMultiPercentNew($listCOAHargaPokokPenjualan, $dataMonth, 'hpp');
$listCOASubTotalBebanPemasaran = $this->Krs->incomeMultiPercentNew($listCOABebanPemasaran, $dataMonth, 'beban_pemasaran');
$listCOASubTotalBebanLainLain = $this->Krs->incomeMultiPercentNew($listCOABebanLainLain, $dataMonth, 'beban_lain_lain');
// $subTotalCOA = array_merge_recursive($listCOASubTotalPendapatan, $listCOASubTotalBeban, $listCOASubTotalPendapatanLain, $listCOASubTotalHargaPokokPenjualan, $listCOASubTotalBebanPemasaran, $listCOASubTotalBebanLainLain);
// $subTotalBebanCOA = array_merge_recursive($listCOASubTotalBeban, $listCOASubTotalBebanPemasaran, $listCOASubTotalBebanLainLain);

$subTotalCOA = array();
for ($ttCOA=$monthFrom; $ttCOA <= $monthEnd; $ttCOA++) {
	$monthDataz = str_pad($ttCOA, 2, '0', STR_PAD_LEFT);
	$subTotalCOA[$monthDataz]['pendapatan'] = $listCOASubTotalPendapatan[$monthDataz]['pendapatan'];
	$subTotalCOA[$monthDataz]['potongan_penjualan'] = $listCOASubTotalPotonganPenjualan[$monthDataz]['potongan_penjualan'];
	$subTotalCOA[$monthDataz]['beban'] = $listCOASubTotalBeban[$monthDataz]['beban'];
	$subTotalCOA[$monthDataz]['pendapatan_lain'] = $listCOASubTotalPendapatanLain[$monthDataz]['pendapatan_lain'];
	$subTotalCOA[$monthDataz]['hpp'] = $listCOASubTotalHargaPokokPenjualan[$monthDataz]['hpp'];
	$subTotalCOA[$monthDataz]['beban_pemasaran'] = $listCOASubTotalBebanPemasaran[$monthDataz]['beban_pemasaran'];
	$subTotalCOA[$monthDataz]['beban_lain_lain'] = $listCOASubTotalBebanLainLain[$monthDataz]['beban_lain_lain'];
}

$subTotalBebanCOA = array();
for ($ttBeban=$monthFrom; $ttBeban <= $monthEnd; $ttBeban++) {
	$monthDataz = str_pad($ttBeban, 2, '0', STR_PAD_LEFT);
	$subTotalBebanCOA[$monthDataz]['beban'] = $listCOASubTotalBeban[$monthDataz]['beban'];
	$subTotalBebanCOA[$monthDataz]['beban_pemasaran'] = $listCOASubTotalBebanPemasaran[$monthDataz]['beban_pemasaran'];
	$subTotalBebanCOA[$monthDataz]['beban_lain_lain'] = $listCOASubTotalBebanLainLain[$monthDataz]['beban_lain_lain'];
}

$totalPercent = array();
$totalPendapatanPercent = array();
$totalPotonganPenjualanPercent = array();
$totalPendapatanLainPercent = array();
$totalHargaPokokPenjualanPercent = array();
$totalBebanPercent = array();
for ($ttl=$monthFrom; $ttl <= $monthEnd; $ttl++) {
	$monthData = str_pad($ttl, 2, '0', STR_PAD_LEFT);
	$totalPercent[$monthData] = array_sum($subTotalCOA[$monthData]);
	$totalPendapatanPercent[$monthData] = array_sum($listCOASubTotalPendapatan[$monthData]);
	$totalPotonganPenjualanPercent[$monthData] = array_sum($listCOASubTotalPotonganPenjualan[$monthData]);
	$totalPendapatanLainPercent[$monthData] = array_sum($listCOASubTotalPendapatanLain[$monthData]);
	$totalHargaPokokPenjualanPercent[$monthData] = array_sum($listCOASubTotalHargaPokokPenjualan[$monthData]);
	
	$totalBebanPercent[$monthData] = array_sum($subTotalBebanCOA[$monthData]);	
}
//pr($totalPercent);

/*for ($i=$monthFrom; $i <= $monthEnd; $i++) {
	$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);
pr(array_sum($dataBebanLainLainCOALevel5Value[$monthData]));
}*/
//pr($dataBebanLainLainCOALevel5Values);

$grandTotalPendapatans = array();
foreach ($listCOAPendapatan as $idPendapatanLevel4 => $detailPendapatan) {
 	// Keterangan pada Kas serta Bank
	/*if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatan).'</b></td>
			</tr>';
		}
	}*/

	if(isset($detailPendapatan['Level5Name']) && $detailPendapatan['Level5Name']) {
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
				/*$tbl .= '<tr>
						<td>('.$codeDetailPendapatan.') '.$nameDetailPendapatan.'</td>';*/
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							//pr($detailPendapatan['Level5'][$monthData][$idDetailPendapatan]);

							if(isset($detailPendapatan['Level5'][$monthData][$idDetailPendapatan])) {
								$dataCOALevel5Values = $detailPendapatan['Level5'][$monthData][$idDetailPendapatan];
								list($codePendapatan, $debetCreditPendapatan, $beginningBalancePendapatan, $totalPendapatan) = explode('^', $dataCOALevel5Values);
								$percenTotalPendapatan = $debetCreditPendapatan/$totalPendapatanPercent[$monthData]*100;

								$debetCreditPendapatans[$monthData][] = $debetCreditPendapatan;
								$percentPendapatans[$monthData][] = $percenTotalPendapatan;
								$percenPendapatan = $this->Krs->percent($percenTotalPendapatan).'%';
								$dataCOALevel5Value = $this->Krs->__currency($debetCreditPendapatan);
							} else {
								$debetCreditPendapatans[99] = 0;
								$dataCOALevel5Value = 0;
								$percenPendapatan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
					/*	$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenPendapatan.'</td>';*/
						}
				//$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPendapatan['Level5']) && $detailPendapatan['Level4']) {
		list($codePendapatan, $namePendapatan) = explode('^', $detailPendapatan['Level4']);

		if(!empty($codePendapatan)) {
			//pr($debetCreditPendapatans['02']);

		$tbl .= '<tr>
				<td>('.$codePendapatan.') '.strtoupper($namePendapatan).'</td>';
				for ($pendapatan=$monthFrom; $pendapatan <= $monthEnd; $pendapatan++) {
					$monthPendapatan = str_pad($pendapatan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4Pendapatan = isset($debetCreditPendapatans[$monthPendapatan]) ? array_sum($debetCreditPendapatans[$monthPendapatan]) : 0;
					$totalPercentLevel4Pendapatan = isset($percentPendapatans[$monthPendapatan]) ? array_sum($percentPendapatans[$monthPendapatan]) : 0;
					//pr($totalLevel4Pendapatan);
					// $totalLevel4Pendapatan = (isset($monthPendapatan) && $monthPendapatan!='99') ? array_sum($debetCreditPendapatans[$monthPendapatan]) : array();
					$nominalTotalLevel4Pendapatan = $this->Krs->__currency($totalLevel4Pendapatan);
					$nominalTotalpercenPendapatan = $this->Krs->percent($totalPercentLevel4Pendapatan).'%';
					$grandTotalPendapatans[$monthPendapatan][] = $totalLevel4Pendapatan;
					
					$tbl .= '<td align="right">'.$nominalTotalLevel4Pendapatan.'</td>
					<td align="right">'.$nominalTotalpercenPendapatan.'</td>';
				}
			$tbl .= '</tr>';
		}
	}
}

$tbl .= '<tr>
	<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL PENDAPATAN</b></td>';
	for ($totalPendapatan=$monthFrom; $totalPendapatan <= $monthEnd; $totalPendapatan++) {
		$monthTotalPendapatan = str_pad($totalPendapatan, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalPendapatan = isset($grandTotalPendapatans[$monthTotalPendapatan]) ? array_sum($grandTotalPendapatans[$monthTotalPendapatan]) : 0;
		$grandTotalPendapatan = $dataGrandTotalPendapatan;

		$nominalGrandTotalPendapatan = $this->Krs->__currency($grandTotalPendapatan);
		$grandTotalPendapatanData[$monthTotalPendapatan] = $grandTotalPendapatan;
		
		$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalGrandTotalPendapatan.'</b></td>
		<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">100%</td>';
	}
$tbl .= '</tr>';


$grandTotalPendapatanLains = array();
foreach ($listCOAPendapatanLain as $idPendapatanLainLevel4 => $detailPendapatanLain) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPendapatanLain['Level5']) && $detailPendapatanLain['Level4']) {
		list($codePendapatanLain, $namePendapatanLain) = explode('^', $detailPendapatanLain['Level4']);

		if(!empty($codePendapatanLain)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($namePendapatanLain).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPendapatanLain['Level5Name']) && $detailPendapatanLain['Level5Name']) {
		$level5NamePendapatanLain = array_unique($detailPendapatanLain['Level5Name']);
		
		$a = 0;
		$debetCreditPendapatanLains = array();
		$percentPendapatanLains = array();
		foreach ($level5NamePendapatanLain as $dataLevelCOAPendapatanLain) {
			//pr($dataLevelCOAPendapatanLain);
			if(isset($dataLevelCOAPendapatanLain)) {
				list($idDetailPendapatanLain, $codeDetailPendapatanLain, $nameDetailPendapatanLain) = explode('^', $dataLevelCOAPendapatanLain);
				$tbl .= '<tr>
						<td>('.$codeDetailPendapatanLain.') '.$nameDetailPendapatanLain.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailPendapatanLain['Level5'][$monthData][$idDetailPendapatanLain]))) {
								$dataCOALevel5Values = $detailPendapatanLain['Level5'][$monthData][$idDetailPendapatanLain];
								list($codePendapatanLain, $debetCreditPendapatanLain, $beginningBalancePendapatanLain, $totalPendapatanLain) = explode('^', $dataCOALevel5Values);
								$percenTotalPendapatanLain = $debetCreditPendapatanLain/$totalPendapatanLainPercent[$monthData]*100;

								$debetCreditPendapatanLains[$monthData][] = $debetCreditPendapatanLain;
								$percentPendapatanLains[$monthData][] = $percenTotalPendapatanLain;

								$percenPendapatanLain = $this->Krs->percent($percenTotalPendapatanLain).'%';

								$dataCOALevel5Value = $this->Krs->__currency($debetCreditPendapatanLain);
							} else {
								$dataCOALevel5Value = 0;
								$percenPendapatanLain = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenPendapatanLain.'</td>';
						}
				$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPendapatanLain['Level5']) && $detailPendapatanLain['Level4']) {
		list($codePendapatanLain, $namePendapatanLain) = explode('^', $detailPendapatanLain['Level4']);

		if(!empty($codePendapatanLain)) {
			//pr($debetCreditPendapatanLains['02']);

		$tbl .= '<tr>
				<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePendapatanLain).'</b></td>';
				for ($pendapatanLain=$monthFrom; $pendapatanLain <= $monthEnd; $pendapatanLain++) {
					$monthPendapatanLain = str_pad($pendapatanLain, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4PendapatanLain = isset($debetCreditPendapatanLains[$monthPendapatanLain]) ? array_sum($debetCreditPendapatanLains[$monthPendapatanLain]) : 0;
					$totalPercentLevel4PendapatanLain = isset($percentPendapatanLains[$monthPendapatanLain]) ? array_sum($percentPendapatanLains[$monthPendapatanLain]) : 0;
					//pr($totalLevel4PendapatanLain);
					// $totalLevel4PendapatanLain = (isset($monthPendapatanLain) && $monthPendapatanLain!='99') ? array_sum($debetCreditPendapatanLains[$monthPendapatanLain]) : array();
					$nominalTotalLevel4PendapatanLain = $this->Krs->__currency($totalLevel4PendapatanLain);
					$nominalTotalpercenPendapatanLain = $this->Krs->percent($totalPercentLevel4PendapatanLain).'%';
					$grandTotalPendapatanLains[$monthPendapatanLain][] = $totalLevel4PendapatanLain;
					
					$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalLevel4PendapatanLain.'</b></td>
					<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalpercenPendapatanLain.'</b></td>';
				}
			$tbl .= '</tr>';
		}
	}
}


$grandTotalPotonganPenjualans = array();
foreach ($listCOAPotonganPenjualan as $idPotonganPenjualanLevel4 => $detailPotonganPenjualan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPotonganPenjualan['Level5']) && $detailPotonganPenjualan['Level4']) {
		list($codePotonganPenjualan, $namePotonganPenjualan) = explode('^', $detailPotonganPenjualan['Level4']);

		if(!empty($codePotonganPenjualan)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($namePotonganPenjualan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailPotonganPenjualan['Level5Name']) && $detailPotonganPenjualan['Level5Name']) {
		$level5NamePotonganPenjualan = array_unique($detailPotonganPenjualan['Level5Name']);
		
		$a = 0;
		$debetCreditPotonganPenjualans = array();
		$percentPotonganPenjualans = array();
		foreach ($level5NamePotonganPenjualan as $dataLevelCOAPotonganPenjualan) {
			//pr($dataLevelCOAPotonganPenjualan);
			if(isset($dataLevelCOAPotonganPenjualan)) {
				list($idDetailPotonganPenjualan, $codeDetailPotonganPenjualan, $nameDetailPotonganPenjualan) = explode('^', $dataLevelCOAPotonganPenjualan);
				$tbl .= '<tr>
						<td>('.$codeDetailPotonganPenjualan.') '.$nameDetailPotonganPenjualan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailPotonganPenjualan['Level5'][$monthData][$idDetailPotonganPenjualan]))) {
								$dataCOALevel5Values = $detailPotonganPenjualan['Level5'][$monthData][$idDetailPotonganPenjualan];
								list($codePotonganPenjualan, $debetCreditPotonganPenjualan, $beginningBalancePotonganPenjualan, $totalPotonganPenjualan) = explode('^', $dataCOALevel5Values);
								$percenTotalPotonganPenjualan = $debetCreditPotonganPenjualan/$totalPotonganPenjualanPercent[$monthData]*100;

								$debetCreditPotonganPenjualans[$monthData][] = $debetCreditPotonganPenjualan;
								$percentPotonganPenjualans[$monthData][] = $percenTotalPotonganPenjualan;

								$percenPotonganPenjualan = $this->Krs->percent($percenTotalPotonganPenjualan).'%';

								$dataCOALevel5Value = $this->Krs->__currency($debetCreditPotonganPenjualan);
							} else {
								$dataCOALevel5Value = 0;
								$percenPotonganPenjualan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenPotonganPenjualan.'</td>';
						}
				$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailPotonganPenjualan['Level5']) && $detailPotonganPenjualan['Level4']) {
		list($codePotonganPenjualan, $namePotonganPenjualan) = explode('^', $detailPotonganPenjualan['Level4']);

		if(!empty($codePotonganPenjualan)) {
			//pr($debetCreditPotonganPenjualans['02']);

		$tbl .= '<tr>
				<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($namePotonganPenjualan).'</b></td>';
				for ($potonganPenjualan=$monthFrom; $potonganPenjualan <= $monthEnd; $potonganPenjualan++) {
					$monthPotonganPenjualan = str_pad($potonganPenjualan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4PotonganPenjualan = isset($debetCreditPotonganPenjualans[$monthPotonganPenjualan]) ? array_sum($debetCreditPotonganPenjualans[$monthPotonganPenjualan]) : 0;
					$totalPercentLevel4PotonganPenjualan = isset($percentPotonganPenjualans[$monthPotonganPenjualan]) ? array_sum($percentPotonganPenjualans[$monthPotonganPenjualan]) : 0;
					//pr($totalLevel4PotonganPenjualan);
					// $totalLevel4PotonganPenjualan = (isset($monthPotonganPenjualan) && $monthPotonganPenjualan!='99') ? array_sum($debetCreditPotonganPenjualans[$monthPotonganPenjualan]) : array();
					$nominalTotalLevel4PotonganPenjualan = $this->Krs->__currency($totalLevel4PotonganPenjualan);
					$nominalTotalpercenPotonganPenjualan = $this->Krs->percent($totalPercentLevel4PotonganPenjualan).'%';
					$grandTotalPotonganPenjualans[$monthPotonganPenjualan][] = $totalLevel4PotonganPenjualan;
					
					$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalLevel4PotonganPenjualan.'</b></td>
					<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalpercenPotonganPenjualan.'</b></td>';
				}
			$tbl .= '</tr>';
		}
	}
}

//pr($grandTotalPendapatans);

$tbl .= '<tr>
	<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>TOTAL PENDAPATAN</b></td>';
	for ($totalPendapatan=$monthFrom; $totalPendapatan <= $monthEnd; $totalPendapatan++) {
		$monthTotalPendapatan = str_pad($totalPendapatan, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalPendapatan = isset($grandTotalPendapatans[$monthTotalPendapatan]) ? array_sum($grandTotalPendapatans[$monthTotalPendapatan]) : 0;
		$dataGrandTotalPotonganPenjualan = isset($grandTotalPotonganPenjualans[$monthTotalPendapatan]) ? array_sum($grandTotalPotonganPenjualans[$monthTotalPendapatan]) : 0;
		$dataGrandTotalPendapatanLain = isset($grandTotalPendapatanLains[$monthTotalPendapatan]) ? array_sum($grandTotalPendapatanLains[$monthTotalPendapatan]) : 0;

		$grandTotalPendapatan = ($dataGrandTotalPendapatan+$dataGrandTotalPendapatanLain)-$dataGrandTotalPotonganPenjualan;

		$nominalGrandTotalPendapatan = $this->Krs->__currency($grandTotalPendapatan);
		$grandTotalPendapatanData[$monthTotalPendapatan] = $grandTotalPendapatan;
		
		$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalGrandTotalPendapatan.'</b></td>
		<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">&nbsp;</td>';
	}
$tbl .= '</tr>';

// Harga Pokok Penjualan
$grandTotalHargaPokokPenjualans = array();
foreach ($listCOAHargaPokokPenjualan as $idHargaPokokPenjualanLevel4 => $detailHargaPokokPenjualan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailHargaPokokPenjualan['Level5']) && $detailHargaPokokPenjualan['Level4']) {
		list($codeHargaPokokPenjualan, $nameHargaPokokPenjualan) = explode('^', $detailHargaPokokPenjualan['Level4']);

		if(!empty($codeHargaPokokPenjualan)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($nameHargaPokokPenjualan).'</b></td>
			</tr>';
		}
	}

	if(isset($detailHargaPokokPenjualan['Level5Name']) && $detailHargaPokokPenjualan['Level5Name']) {
		$level5NameHargaPokokPenjualan = array_unique($detailHargaPokokPenjualan['Level5Name']);
		
		$a = 0;
		$debetCreditHargaPokokPenjualans = array();
		$percentHargaPokokPenjualans = array();
		foreach ($level5NameHargaPokokPenjualan as $dataLevelCOAHargaPokokPenjualan) {
			//pr($dataLevelCOAHargaPokokPenjualan);
			if(isset($dataLevelCOAHargaPokokPenjualan)) {
				list($idDetailHargaPokokPenjualan, $codeDetailHargaPokokPenjualan, $nameDetailHargaPokokPenjualan) = explode('^', $dataLevelCOAHargaPokokPenjualan);
				$tbl .= '<tr>
						<td>('.$codeDetailHargaPokokPenjualan.') '.$nameDetailHargaPokokPenjualan.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailHargaPokokPenjualan['Level5'][$monthData][$idDetailHargaPokokPenjualan]))) {
								$dataCOALevel5Values = $detailHargaPokokPenjualan['Level5'][$monthData][$idDetailHargaPokokPenjualan];
								list($codeHargaPokokPenjualan, $debetCreditHargaPokokPenjualan, $beginningBalanceHargaPokokPenjualan, $totalHargaPokokPenjualan) = explode('^', $dataCOALevel5Values);
								$percenTotalHargaPokokPenjualan = $debetCreditHargaPokokPenjualan/$totalHargaPokokPenjualanPercent[$monthData]*100;

								$debetCreditHargaPokokPenjualans[$monthData][] = $debetCreditHargaPokokPenjualan;
								$percentHargaPokokPenjualans[$monthData][] = $percenTotalHargaPokokPenjualan;

								$percenHargaPokokPenjualan = $this->Krs->percent($percenTotalHargaPokokPenjualan).'%';

								$dataCOALevel5Value = $this->Krs->__currency($debetCreditHargaPokokPenjualan);
							} else {
								$dataCOALevel5Value = 0;
								$percenHargaPokokPenjualan = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenHargaPokokPenjualan.'</td>';
						}
				$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailHargaPokokPenjualan['Level5']) && $detailHargaPokokPenjualan['Level4']) {
		list($codeHargaPokokPenjualan, $nameHargaPokokPenjualan) = explode('^', $detailHargaPokokPenjualan['Level4']);

		if(!empty($codeHargaPokokPenjualan)) {
			//pr($debetCreditHargaPokokPenjualans['02']);

		$tbl .= '<tr>
				<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameHargaPokokPenjualan).'</b></td>';
				for ($HargaPokokPenjualan=$monthFrom; $HargaPokokPenjualan <= $monthEnd; $HargaPokokPenjualan++) {
					$monthHargaPokokPenjualan = str_pad($HargaPokokPenjualan, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4HargaPokokPenjualan = isset($debetCreditHargaPokokPenjualans[$monthHargaPokokPenjualan]) ? array_sum($debetCreditHargaPokokPenjualans[$monthHargaPokokPenjualan]) : 0;
					$totalPercentLevel4HargaPokokPenjualan = isset($percentHargaPokokPenjualans[$monthHargaPokokPenjualan]) ? array_sum($percentHargaPokokPenjualans[$monthHargaPokokPenjualan]) : 0;
					//pr($totalLevel4HargaPokokPenjualan);
					// $totalLevel4HargaPokokPenjualan = (isset($monthHargaPokokPenjualan) && $monthHargaPokokPenjualan!='99') ? array_sum($debetCreditHargaPokokPenjualans[$monthHargaPokokPenjualan]) : array();
					$nominalTotalLevel4HargaPokokPenjualan = $this->Krs->__currency($totalLevel4HargaPokokPenjualan);
					$nominalTotalpercenHargaPokokPenjualan = $this->Krs->percent($totalPercentLevel4HargaPokokPenjualan).'%';
					$grandTotalHargaPokokPenjualans[$monthHargaPokokPenjualan][] = $totalLevel4HargaPokokPenjualan;
					
					$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalLevel4HargaPokokPenjualan.'</b></td>
					<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalpercenHargaPokokPenjualan.'</b></td>';
				}
			$tbl .= '</tr>';
		}
	}
}


$tbl .= '<tr>
	<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA KOTOR</b></td>';
	for ($totalLabaKotor=$monthFrom; $totalLabaKotor <= $monthEnd; $totalLabaKotor++) {
		$monthTotalHPP = str_pad($totalLabaKotor, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalHargaKotorPenjualan = isset($grandTotalHargaPokokPenjualans[$monthTotalHPP]) ? array_sum($grandTotalHargaPokokPenjualans[$monthTotalHPP]) : 0;
		
		$grandTotalLabaKotorPenjualan = $grandTotalPendapatanData[$monthTotalHPP]-$dataGrandTotalHargaKotorPenjualan;

		$nominalGrandTotalLabaKotorPenjualan = $this->Krs->__currency($grandTotalLabaKotorPenjualan);
		$grandTotalLabaKotorPenjualanData[$monthTotalHPP] = $grandTotalLabaKotorPenjualan;
		
		$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalGrandTotalLabaKotorPenjualan.'</b></td>
		<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">&nbsp;</td>';
	}
$tbl .= '</tr>';

//Beban
$grandTotalBebans = array();
foreach ($listCOABeban as $idBebanLevel4 => $detailBeban) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBeban['Level5']) && $detailBeban['Level4']) {
		list($codeBeban, $nameBeban) = explode('^', $detailBeban['Level4']);

		if(!empty($codeBeban)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($nameBeban).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBeban['Level5Name']) && $detailBeban['Level5Name']) {
		$level5NameBeban = array_unique($detailBeban['Level5Name']);
		
		$a = 0;
		$debetCreditBebans = array();
		$percentBebans = array();
		foreach ($level5NameBeban as $dataLevelCOABeban) {
			//pr($dataLevelCOABeban);
			if(isset($dataLevelCOABeban)) {
				list($idDetailBeban, $codeDetailBeban, $nameDetailBeban) = explode('^', $dataLevelCOABeban);
				$tbl .= '<tr>
						<td>('.$codeDetailBeban.') '.$nameDetailBeban.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBeban['Level5'][$monthData][$idDetailBeban]))) {
								$dataCOALevel5Values = $detailBeban['Level5'][$monthData][$idDetailBeban];
								list($codeBeban, $debetCreditBeban, $beginningBalanceBeban, $totalBeban) = explode('^', $dataCOALevel5Values);
								$percenTotalBeban = $debetCreditBeban/$totalBebanPercent[$monthData]*100;

								$debetCreditBebans[$monthData][] = $debetCreditBeban;
								$percentBebans[$monthData][] = $percenTotalBeban;

								$percenBeban = $this->Krs->percent($percenTotalBeban).'%';
								$dataCOALevel5Value = $this->Krs->__currency($debetCreditBeban);
							} else {
								$dataCOALevel5Value = 0;
								$percenBeban = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenBeban.'</td>';
						}
				$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBeban['Level5']) && $detailBeban['Level4']) {
		list($codeBeban, $nameBeban) = explode('^', $detailBeban['Level4']);

		if(!empty($codeBeban)) {
			//pr($debetCreditBebans['02']);

		$tbl .= '<tr>
				<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBeban).'</b></td>';
				for ($Beban=$monthFrom; $Beban <= $monthEnd; $Beban++) {
					$monthBeban = str_pad($Beban, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4Beban = isset($debetCreditBebans[$monthBeban]) ? array_sum($debetCreditBebans[$monthBeban]) : 0;
					$totalPercentLevel4Beban = isset($percentBebans[$monthBeban]) ? array_sum($percentBebans[$monthBeban]) : 0;
					$nominalTotalLevel4Beban = $this->Krs->__currency($totalLevel4Beban);
					$nominalTotalpercenBeban = $this->Krs->percent($totalPercentLevel4Beban).'%';
					$grandTotalBebans[$monthBeban][] = $totalLevel4Beban;
					
					$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalLevel4Beban.'</b></td>
					<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalpercenBeban.'</b></td>';
				}
			$tbl .= '</tr>';
		}
	}
}

//Beban Pemasaran
$grandTotalBebanPemasarans = array();
foreach ($listCOABebanPemasaran as $idBebanPemasaranLevel4 => $detailBebanPemasaran) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBebanPemasaran['Level5']) && $detailBebanPemasaran['Level4']) {
		list($codeBebanPemasaran, $nameBebanPemasaran) = explode('^', $detailBebanPemasaran['Level4']);

		if(!empty($codeBebanPemasaran)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanPemasaran).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanPemasaran['Level5Name']) && $detailBebanPemasaran['Level5Name']) {
		$level5NameBebanPemasaran = array_unique($detailBebanPemasaran['Level5Name']);
		
		$a = 0;
		foreach ($level5NameBebanPemasaran as $dataLevelCOABebanPemasaran) {
			//pr($dataLevelCOABebanPemasaran);
			if(isset($dataLevelCOABebanPemasaran)) {
				list($idDetailBebanPemasaran, $codeDetailBebanPemasaran, $nameDetailBebanPemasaran) = explode('^', $dataLevelCOABebanPemasaran);
				$tbl .= '<tr>
						<td>('.$codeDetailBebanPemasaran.') '.$nameDetailBebanPemasaran.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBebanPemasaran['Level5'][$monthData][$idDetailBebanPemasaran]))) {
								$dataCOALevel5Values = $detailBebanPemasaran['Level5'][$monthData][$idDetailBebanPemasaran];
								list($codeBebanPemasaran, $debetCreditBebanPemasaran, $beginningBalanceBebanPemasaran, $totalBebanPemasaran) = explode('^', $dataCOALevel5Values);
								$percenTotalBebanPemasaran = $debetCreditBebanPemasaran/$totalBebanPercent[$monthData]*100;

								$debetCreditBebanPemasarans[$monthData][] = $debetCreditBebanPemasaran;
								$percentBebanPemasarans[$monthData][] = $percenTotalBebanPemasaran;

								$percenBebanPemasaran = $this->Krs->percent($percenTotalBebanPemasaran).'%';
								$dataCOALevel5Value = $this->Krs->__currency($debetCreditBebanPemasaran);
							} else {
								$dataCOALevel5Value = 0;
								$percenBebanPemasaran = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenBebanPemasaran.'</td>';
						}
				$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBebanPemasaran['Level5']) && $detailBebanPemasaran['Level4']) {
		list($codeBebanPemasaran, $nameBebanPemasaran) = explode('^', $detailBebanPemasaran['Level4']);

		if(!empty($codeBebanPemasaran)) {
			//pr($debetCreditBebanPemasarans['02']);

		$tbl .= '<tr>
				<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanPemasaran).'</b></td>';
				for ($BebanPemasaran=$monthFrom; $BebanPemasaran <= $monthEnd; $BebanPemasaran++) {
					$monthBebanPemasaran = str_pad($BebanPemasaran, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4BebanPemasaran = isset($debetCreditBebanPemasarans[$monthBebanPemasaran]) ? array_sum($debetCreditBebanPemasarans[$monthBebanPemasaran]) : 0;
					$totalPercentLevel4BebanPemasaran = isset($percentBebanPemasarans[$monthBebanPemasaran]) ? array_sum($percentBebanPemasarans[$monthBebanPemasaran]) : 0;
					$nominalTotalLevel4BebanPemasaran = $this->Krs->__currency($totalLevel4BebanPemasaran);
					$nominalTotalpercenBebanPemasaran = $this->Krs->percent($totalPercentLevel4BebanPemasaran).'%';
					$grandTotalBebanPemasarans[$monthBebanPemasaran][] = $totalLevel4BebanPemasaran;
					
					$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalLevel4BebanPemasaran.'</b></td>
					<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalpercenBebanPemasaran.'</b></td>';
				}
			$tbl .= '</tr>';
		}
	}
}

$tbl .= '<tr>
	<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA OPERASIONAL</b></td>';
	for ($totalLabaOperasional=$monthFrom; $totalLabaOperasional <= $monthEnd; $totalLabaOperasional++) {
		$monthTotalLabaOperasional = str_pad($totalLabaOperasional, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalBeban = isset($grandTotalBebans[$monthTotalLabaOperasional]) ? array_sum($grandTotalBebans[$monthTotalLabaOperasional]) : 0;
		$dataGrandTotalBebanPemasaran = isset($grandTotalBebanPemasarans[$monthTotalLabaOperasional]) ? array_sum($grandTotalBebanPemasarans[$monthTotalLabaOperasional]) : 0;
		
		$grandTotalLabaOperasional = $grandTotalLabaKotorPenjualanData[$monthTotalLabaOperasional]-($dataGrandTotalBeban+$dataGrandTotalBebanPemasaran);

		$nominalGrandTotalLabaOperasional = $this->Krs->__currency($grandTotalLabaOperasional);
		$grandTotalLabaOperasionalData[$monthTotalLabaOperasional] = $grandTotalLabaOperasional;
		
		$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalGrandTotalLabaOperasional.'</b></td>
		<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">&nbsp;</td>';
	}
$tbl .= '</tr>';

$grandTotalBebanLainLains = array();
//Beban Lain-lain
foreach ($listCOABebanLainLain as $idBebanLainLainLevel4 => $detailBebanLainLain) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailBebanLainLain['Level5']) && $detailBebanLainLain['Level4']) {
		list($codeBebanLainLain, $nameBebanLainLain) = explode('^', $detailBebanLainLain['Level4']);

		if(!empty($codeBebanLainLain)) {
		$tbl .= '<tr>
				<td colspan="3"><b>'.strtoupper($nameBebanLainLain).'</b></td>
			</tr>';
		}
	}

	if(isset($detailBebanLainLain['Level5Name']) && $detailBebanLainLain['Level5Name']) {
		$level5NameBebanLainLain = array_unique($detailBebanLainLain['Level5Name']);
		
		$a = 0;
		$debetCreditBebanLainLains = array();
		$percentBebanLainLains = array();
		foreach ($level5NameBebanLainLain as $dataLevelCOABebanLainLain) {
			//pr($dataLevelCOABebanLainLain);
			if(isset($dataLevelCOABebanLainLain)) {
				list($idDetailBebanLainLain, $codeDetailBebanLainLain, $nameDetailBebanLainLain) = explode('^', $dataLevelCOABebanLainLain);
				$tbl .= '<tr>
						<td>('.$codeDetailBebanLainLain.') '.$nameDetailBebanLainLain.'</td>';
						for ($i=$monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad($i, 2, '0', STR_PAD_LEFT);

							if((isset($detailBebanLainLain['Level5'][$monthData][$idDetailBebanLainLain]))) {
								$dataCOALevel5Values = $detailBebanLainLain['Level5'][$monthData][$idDetailBebanLainLain];
								list($codeBebanLainLain, $debetCreditBebanLainLain, $beginningBalanceBebanLainLain, $totalBebanLainLain) = explode('^', $dataCOALevel5Values);

								$percenTotalBebanLainLain = $debetCreditBebanLainLain/$totalBebanPercent[$monthData]*100;

								$debetCreditBebanLainLains[$monthData][] = $debetCreditBebanLainLain;
								$percentBebanLainLains[$monthData][] = $percenTotalBebanLainLain;

								$percenBebanLainLain = $this->Krs->percent($percenTotalBebanLainLain).'%';
								$dataCOALevel5Value = $this->Krs->__currency($debetCreditBebanLainLain);
							} else {
								$dataCOALevel5Value = 0;
								$percenBebanLainLain = '0%';
							}
							//$monthIndo = $this->Krs->get_month($i);
						$tbl .= '<td align="right">'.$dataCOALevel5Value.'</td>';
						$tbl .= '<td align="right">'.$percenBebanLainLain.'</td>';
						}
				$tbl .= '</tr>';
				$a++;
			}
		}
	}

	if(isset($detailBebanLainLain['Level5']) && $detailBebanLainLain['Level4']) {
		list($codeBebanLainLain, $nameBebanLainLain) = explode('^', $detailBebanLainLain['Level4']);

		if(!empty($codeBebanLainLain)) {
			//pr($debetCreditBebanLainLains['02']);

		$tbl .= '<tr>
				<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameBebanLainLain).'</b></td>';
				for ($BebanLainLain=$monthFrom; $BebanLainLain <= $monthEnd; $BebanLainLain++) {
					$monthBebanLainLain = str_pad($BebanLainLain, 2, '0', STR_PAD_LEFT);
					
					$totalLevel4BebanLainLain = isset($debetCreditBebanLainLains[$monthBebanLainLain]) ? array_sum($debetCreditBebanLainLains[$monthBebanLainLain]) : 0;
					$totalPercentLevel4BebanLainLain = isset($percentBebanLainLains[$monthBebanLainLain]) ? array_sum($percentBebanLainLains[$monthBebanLainLain]) : 0;
					$nominalTotalLevel4BebanLainLain = $this->Krs->__currency($totalLevel4BebanLainLain);
					$nominalTotalpercenBebanLainLain = $this->Krs->percent($totalPercentLevel4BebanLainLain).'%';
					$grandTotalBebanLainLains[$monthBebanLainLain][] = $totalLevel4BebanLainLain;
					
					$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalLevel4BebanLainLain.'</b></td>
					<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalTotalpercenBebanLainLain.'</b></td>';
				}
			$tbl .= '</tr>';
		}
	}
}

$tbl .= '<tr>
	<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.str_repeat('&nbsp;&nbsp;&nbsp;', 5).'<b>LABA BERSIH</b></td>';
	for ($totalLabaBersih=$monthFrom; $totalLabaBersih <= $monthEnd; $totalLabaBersih++) {
		$monthTotalLabaBersih = str_pad($totalLabaBersih, 2, '0', STR_PAD_LEFT);
		
		$dataGrandTotalBebanLainLain = isset($grandTotalBebanLainLains[$monthTotalLabaBersih]) ? array_sum($grandTotalBebanLainLains[$monthTotalLabaBersih]) : 0;		
		
		$grandTotalLabaBersih = $grandTotalLabaOperasionalData[$monthTotalLabaBersih]-$dataGrandTotalBebanLainLain;

		$nominalGrandTotalLabaBersih = $this->Krs->__currency($grandTotalLabaBersih);
		$grandTotalLabaBersihData = $grandTotalLabaBersih;
		
		$tbl .= '<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$nominalGrandTotalLabaBersih.'</b></td>
		<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">&nbsp;</td>';
	}
$tbl .= '</tr>';
					

	$tbl .= '</table>';
						
				
	$tbl .= '</td>
		</tr>
	</table>';
	//pr($tbl);
	$pdf->writeHTML($tbl, true, false, false, false, '');
	//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
	

	//pr($tbl);

	//$pdf->writeHTML($footers, true, false, false, false, '');
	$pdf->Output('LabaRugiMulti_'.$filterDateStart.'.pdf', 'D');
	//$pdf->Output('LabaRugiMulti_'.$filterDateStart.'.pdf', 'D');

?>
