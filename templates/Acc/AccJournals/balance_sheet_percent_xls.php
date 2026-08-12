<?php
/*
 * @file		xls_neraca.php
 * @package		SImAcoTa(System Information Accounting Artama)
 * @since		v 1.09.10
 * @copyright   Copyright 2004-2013, KersenSoft, Inc.
 * @license		Kersen License 
 */
 //$urls = array('url'=>array($uuid));
 //$url_paging = array_merge_recursive($filter_options, $urls);

//pr($views);

$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Kersen Soft")
						 ->setLastModifiedBy("Kersen Soft")
						 ->setTitle("Office 2007 XLSX Test Document")
						 ->setSubject("Office 2007 XLSX Test Document")
						 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
						 ->setKeywords("office 2007 openxml php")
						 ->setCategory("Test result file");

// Set default font	
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

// set values
$objPHPExcel->setActiveSheetIndex(0);
for($a=0;$a<15;$a++){
	$_chr = chr(65+$a);
	$objPHPExcel->getActiveSheet()->getColumnDimension($_chr)->setAutoSize(true);
}

$styleArrayTitle = array(
		'font' => array(
			'bold' => true,
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation' => 90,
			'startcolor' => array(
				'argb' => 'FFA0A0A0',
			),
			'endcolor' => array(
				'argb' => 'FFFFFFFF',
			),
		),
	);

$styleArray = array(
		'font' => array(
			'bold' => true,
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation' => 90,
			'startcolor' => array(
				'argb' => 'FFA0A0A0',
			),
			'endcolor' => array(
				'argb' => 'FFFFFFFF',
			),
		),
	);
	$objPHPExcel->getActiveSheet()->getStyle('A1:G3')->applyFromArray($styleArray);
	
	//$dateJournals = $this->Time->format("d M Y", $filterDate);
	// Add some data, resembling some different data types								
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'NERACA');
	$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
	$objPHPExcel->getActiveSheet()->setCellValue('A2', $this->Krs->companyName);
	$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
	$objPHPExcel->getActiveSheet()->setCellValue('A3', 'PER. '.$this->Time->format("d M Y", $filterDate));
	$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');

	if($filterGlobal=='N') {
		$numberLineAktiva = 4;
$numberAktivaLine = 4;
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
$totalPercentAktiva = $grandTotalPercentKasBank+$grandTotalPercentPiutang+$grandTotalPercentAktivaTetap+$grandTotalPercentAkumulasiPenyusutan;

// Kas Bank
$numberKasBank = $numberLineAktiva+1;
$grandTotalKasBanks = array();
foreach ($listCOAKasBank as $idKasBank => $detailKasBank) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailKasBank['Level5']) && $detailKasBank['Level4']) {
		list($codeKasBank, $nameKasBank) = explode('^', $detailKasBank['Level4']);

		if(!empty($codeKasBank)) {

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, strtoupper($nameKasBank));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}

	if(isset($detailKasBank['Level5']) && $detailKasBank['Level5']) {
		$debetCreditDetailKasBanks = array();
		foreach ($detailKasBank['Level5'] as $dataCOAKasBank) {
			list($codeDetailKasBank, $nameDetailKasBank, $debetCreditDetailKasBank, $beginningBalanceDetailKasBank, $subTotalDetailKasBank) = explode('^', $dataCOAKasBank);
			//$totalKasBanks = $debetCreditDetailKasBank+$beginningBalanceDetailKasBank;

			if(!empty($subTotalDetailKasBank)) {
				$numberKasBank = $numberKasBank+1;
				$debetCreditDetailKasBanks[] = $subTotalDetailKasBank;
				
				$dataPercentGlobalKasBank = $grandTotalPercentKasBank/$totalPercentAktiva*100;
				$percenKasBank = $subTotalDetailKasBank/$grandTotalPercentKasBank*$dataPercentGlobalKasBank;
				//$percenKasBank = 0;
				$nominalPercenKasBank = $this->Krs->percent($percenKasBank).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeDetailKasBank.') '.$nameDetailKasBank);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $subTotalDetailKasBank);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalPercenKasBank);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberAktivaLine++;
			} else {
				$numberKasBank = $numberKasBank-1;
			}
		}
	}

	if(isset($detailKasBank['Level5']) && $detailKasBank['Level4']) {
		list($codeKasBank, $nameKasBank) = explode('^', $detailKasBank['Level4']);

		if(!empty($codeKasBank)) {
			$totalLevel4KasBank = array_sum($debetCreditDetailKasBanks);
			$grandTotalKasBanks[] = $totalLevel4KasBank;
			$percenTotalKasBank = $totalLevel4KasBank/$totalPercentAktiva*100;
			$nominalGrandPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';
		
			$numberKasBank = $numberKasBank+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL '.strtoupper($nameKasBank));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4KasBank);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentKasBank);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
		/*$tbl .= '<tr>
				<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameKasBank).'</b></td>
				<td align="right"><b>'.$nominalTotalLevel4KasBank.'</b></td>
				<td align="right"><b>'.$nominalGrandPercentKasBank.'</b></td>
			</tr>';*/
			$numberAktivaLine++;
		}
	}
	$numberKasBank++;
}

$numberKasBankTotal = $numberKasBank+1;
$grandTotalKasBank = (empty($grandTotalKasBanks)) ? 0 : round(array_sum($grandTotalKasBanks),2);
$percenTotalKasBank = $grandTotalKasBank/$totalPercentAktiva*100;
$nominalGrandTotalPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';
$totalGrandPercentKasBank = ($grandTotalKasBank>0) ? $nominalGrandTotalPercentKasBank:"0%";

$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL KAS & BANK');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $grandTotalKasBank);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $totalGrandPercentKasBank);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);

$numberAktivaLine = $numberAktivaLine+1;
// Piutang
$numberPiutang = $numberKasBankTotal+1;
$grandTotalPiutangs = array();
foreach ($listCOAPiutang as $idPiutang => $detailPiutang) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
		list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

		if(!empty($codePiutang)) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, strtoupper($namePiutang));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}

	if(isset($detailPiutang['Level5']) && $detailPiutang['Level5']) {
		$debetCreditDetailPiutangs = array();
		foreach ($detailPiutang['Level5'] as $dataCOAPiutang) {
			list($codeDetailPiutang, $nameDetailPiutang, $debetCreditDetailPiutang, $beginningBalanceDetailPiutang, $subTotalDetailPiutang) = explode('^', $dataCOAPiutang);

			if(!empty($subTotalDetailPiutang)) {
				$numberPiutang = $numberPiutang+1;
				//$totalPiutangs = $debetCreditDetailPiutang+$beginningBalanceDetailPiutang;
				$debetCreditDetailPiutangs[] = $subTotalDetailPiutang;
				
				$dataPercentGlobalPiutang = $grandTotalPercentPiutang/$totalPercentAktiva*100;
				$percenPiutang = $subTotalDetailPiutang/$grandTotalPercentPiutang*$dataPercentGlobalPiutang;
				//$percenPiutang = 0;
				$nominalPercenPiutang = $this->Krs->percent($percenPiutang).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeDetailPiutang.') '.$nameDetailPiutang);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $subTotalDetailPiutang);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalPercenPiutang);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberAktivaLine++;
			} else {
				$numberPiutang = $numberPiutang-1;
			}
		}
	}

	if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
		list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

		if(!empty($codePiutang)) {
			$totalLevel4Piutang = array_sum($debetCreditDetailPiutangs);
			$grandTotalPiutangs[] = $totalLevel4Piutang;
			$percenTotalPiutang = $totalLevel4Piutang/$totalPercentAktiva*100;
			$nominalGrandPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';

			$numberPiutang = $numberPiutang+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL '.strtoupper($namePiutang));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4Piutang);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentPiutang);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}
	$numberPiutang++;
}

$numberPiutangTotal = $numberPiutang+1;
$grandTotalPiutang = (empty($grandTotalPiutangs)) ? 0 : round(array_sum($grandTotalPiutangs),2);
$percenTotalPiutang = $grandTotalPiutang/$totalPercentAktiva*100;
$nominalGrandTotalPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';
$totalGrandPercentPiutang = ($grandTotalPiutang>0) ? $nominalGrandTotalPercentPiutang:"0%";

$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL PIUTANG');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $grandTotalPiutang);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $totalGrandPercentPiutang);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);


// Aktiva Tetap
$numberAktivaLine = $numberAktivaLine+1;
$numberAktivaTetap = $numberPiutangTotal+1;
$grandTotalAktivaTetaps = array();
foreach ($listCOAAktivaTetap as $idAktivaTetap => $detailAktivaTetap) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level4']) {
		list($codeAktivaTetap, $nameAktivaTetap) = explode('^', $detailAktivaTetap['Level4']);

		if(!empty($codeAktivaTetap)) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, strtoupper($nameAktivaTetap));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}

	if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level5']) {
		$debetCreditDetailAktivaTetaps = array();
		foreach ($detailAktivaTetap['Level5'] as $dataCOAAktivaTetap) {
			list($codeDetailAktivaTetap, $nameDetailAktivaTetap, $debetCreditDetailAktivaTetap, $beginningBalanceDetailAktivaTetap, $subTotalDetailAktivaTetap) = explode('^', $dataCOAAktivaTetap);

			if(!empty($subTotalDetailAktivaTetap)) {
				$numberAktivaTetap = $numberAktivaTetap+1;
			//$totalAktivaTetaps = $debetCreditDetailAktivaTetap+$beginningBalanceDetailAktivaTetap;
				$debetCreditDetailAktivaTetaps[] = $subTotalDetailAktivaTetap;
				
				$dataPercentGlobalAktivaTetap = $grandTotalPercentAktivaTetap/$totalPercentAktiva*100;
				$percenAktivaTetap = $subTotalDetailAktivaTetap/$grandTotalPercentAktivaTetap*$dataPercentGlobalAktivaTetap;
				//$percenAktivaTetap = 0;
				$nominalPercenAktivaTetap = $this->Krs->percent($percenAktivaTetap).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeDetailAktivaTetap.') '.$nameDetailAktivaTetap);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $subTotalDetailAktivaTetap);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalPercenAktivaTetap);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberAktivaLine++;
			} else {
				$numberAktivaTetap = $numberAktivaTetap-1;
			}
		}
	}

	if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level4']) {
		list($codeAktivaTetap, $nameAktivaTetap) = explode('^', $detailAktivaTetap['Level4']);

		if(!empty($codeAktivaTetap)) {
			$totalLevel4AktivaTetap = array_sum($debetCreditDetailAktivaTetaps);
			$nominalTotalLevel4AktivaTetap = $this->Krs->__currency($totalLevel4AktivaTetap);
			$grandTotalAktivaTetaps[] = $totalLevel4AktivaTetap;
			$percenTotalAktivaTetap = $totalLevel4AktivaTetap/$totalPercentAktiva*100;
			$nominalGrandPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';

			$numberAktivaTetap = $numberAktivaTetap+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL '.strtoupper($nameAktivaTetap));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4AktivaTetap);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentAktivaTetap);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}
	$numberAktivaTetap++;
}

$numberAktivaTetapTotal = $numberAktivaTetap+1;
$grandTotalAktivaTetap = (empty($grandTotalAktivaTetaps)) ? 0 : round(array_sum($grandTotalAktivaTetaps),2);
		
$percenTotalAktivaTetap = $grandTotalAktivaTetap/$totalPercentAktiva*100;
$nominalGrandTotalPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';
$totalGrandPercentAktivaTetap = ($grandTotalAktivaTetap>0) ? $nominalGrandTotalPercentAktivaTetap:"0%";

$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'AKTIVA TETAP');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $grandTotalAktivaTetap);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $totalGrandPercentAktivaTetap);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);


// Aktiva Tetap
$numberAktivaLine = $numberAktivaLine+1;
$numberAktivaLancarLainnya = $numberPiutangTotal+1;
$grandTotalAktivaLancarLainnyas = array();
foreach ($listCOAAktivaLancarLainnya as $idAktivaLancarLainnya => $detailAktivaLancarLainnya) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level4']) {
		list($codeAktivaLancarLainnya, $nameAktivaLancarLainnya) = explode('^', $detailAktivaLancarLainnya['Level4']);

		if(!empty($codeAktivaLancarLainnya)) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, strtoupper($nameAktivaLancarLainnya));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}

	if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level5']) {
		$debetCreditDetailAktivaLancarLainnyas = array();
		foreach ($detailAktivaLancarLainnya['Level5'] as $dataCOAAktivaLancarLainnya) {
			list($codeDetailAktivaLancarLainnya, $nameDetailAktivaLancarLainnya, $debetCreditDetailAktivaLancarLainnya, $beginningBalanceDetailAktivaLancarLainnya, $subTotalDetailAktivaLancarLainnya) = explode('^', $dataCOAAktivaLancarLainnya);

			if(!empty($subTotalDetailAktivaLancarLainnya)) {
				$numberAktivaLancarLainnya = $numberAktivaLancarLainnya+1;
			//$totalAktivaLancarLainnyas = $debetCreditDetailAktivaLancarLainnya+$beginningBalanceDetailAktivaLancarLainnya;
				$debetCreditDetailAktivaLancarLainnyas[] = $subTotalDetailAktivaLancarLainnya;
				
				$dataPercentGlobalAktivaLancarLainnya = $grandTotalPercentAktivaLancarLainnya/$totalPercentAktiva*100;
				$percenAktivaLancarLainnya = $subTotalDetailAktivaLancarLainnya/$grandTotalPercentAktivaLancarLainnya*$dataPercentGlobalAktivaLancarLainnya;
				//$percenAktivaLancarLainnya = 0;
				$nominalPercenAktivaLancarLainnya = $this->Krs->percent($percenAktivaLancarLainnya).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeDetailAktivaLancarLainnya.') '.$nameDetailAktivaLancarLainnya);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $subTotalDetailAktivaLancarLainnya);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalPercenAktivaLancarLainnya);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberAktivaLine++;
			} else {
				$numberAktivaLancarLainnya = $numberAktivaLancarLainnya-1;
			}
		}
	}

	if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level4']) {
		list($codeAktivaLancarLainnya, $nameAktivaLancarLainnya) = explode('^', $detailAktivaLancarLainnya['Level4']);

		if(!empty($codeAktivaLancarLainnya)) {
			$totalLevel4AktivaLancarLainnya = array_sum($debetCreditDetailAktivaLancarLainnyas);
			$nominalTotalLevel4AktivaLancarLainnya = $this->Krs->__currency($totalLevel4AktivaLancarLainnya);
			$grandTotalAktivaLancarLainnyas[] = $totalLevel4AktivaLancarLainnya;
			$percenTotalAktivaLancarLainnya = $totalLevel4AktivaLancarLainnya/$totalPercentAktiva*100;
			$nominalGrandPercentAktivaLancarLainnya = $this->Krs->percent($percenTotalAktivaLancarLainnya).'%';

			$numberAktivaLancarLainnya = $numberAktivaLancarLainnya+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL '.strtoupper($nameAktivaLancarLainnya));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4AktivaLancarLainnya);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentAktivaLancarLainnya);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}
	$numberAktivaLancarLainnya++;
}

$numberAkumulasiPenyusutan = $numberAktivaLancarLainnya+1;
$numberAktivaLine = $numberAktivaLine+1;
// Akumulasi Penyusutan
$grandTotalAkumulasiPenyusutans = array();
foreach ($listCOAAkumulasiPenyusutan as $idAkumulasiPenyusutan => $detailAkumulasiPenyusutan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level4']) {
		list($codeAkumulasiPenyusutan, $nameAkumulasiPenyusutan) = explode('^', $detailAkumulasiPenyusutan['Level4']);

		if(!empty($codeAkumulasiPenyusutan)) {
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, strtoupper($nameAkumulasiPenyusutan));
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}

	if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level5']) {
		$debetCreditDetailAkumulasiPenyusutans = array();
		foreach ($detailAkumulasiPenyusutan['Level5'] as $dataCOAAkumulasiPenyusutan) {
			list($codeDetailAkumulasiPenyusutan, $nameDetailAkumulasiPenyusutan, $debetCreditDetailAkumulasiPenyusutan, $beginningBalanceDetailAkumulasiPenyusutan, $subTotalDetailAkumulasiPenyusutan) = explode('^', $dataCOAAkumulasiPenyusutan);
			
			if(!empty($subTotalDetailAkumulasiPenyusutan)) {
				$numberAkumulasiPenyusutan = $numberAkumulasiPenyusutan+1;
				//$totalAkumulasiPenyusutans = $debetCreditDetailAkumulasiPenyusutan+$beginningBalanceDetailAkumulasiPenyusutan;
				$debetCreditDetailAkumulasiPenyusutans[] = $subTotalDetailAkumulasiPenyusutan;
				$nominalDetailAkumulasiPenyusutan = $this->Krs->__currency($subTotalDetailAkumulasiPenyusutan);

				$dataPercentGlobalAkumulasiPenyusutan = $grandTotalPercentAkumulasiPenyusutan/$totalPercentAktiva*100;
				$percenAkumulasiPenyusutan = $subTotalDetailAkumulasiPenyusutan/$grandTotalPercentAkumulasiPenyusutan*$dataPercentGlobalAkumulasiPenyusutan;
				//$percenAkumulasiPenyusutan = 0;
				$nominalPercenAkumulasiPenyusutan = $this->Krs->percent($percenAkumulasiPenyusutan).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeDetailAkumulasiPenyusutan.') '.$nameDetailAkumulasiPenyusutan);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $subTotalDetailAkumulasiPenyusutan);
				$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalPercenAkumulasiPenyusutan);
				$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberAktivaLine++;
			} else {
				$numberAkumulasiPenyusutan = $numberAkumulasiPenyusutan-1;
			}
		}
	}

	if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level4']) {
		list($codeAkumulasiPenyusutan, $nameAkumulasiPenyusutan) = explode('^', $detailAkumulasiPenyusutan['Level4']);

		if(!empty($codeAkumulasiPenyusutan)) {
			$totalLevel4AkumulasiPenyusutan = array_sum($debetCreditDetailAkumulasiPenyusutans);
			$nominalTotalLevel4AkumulasiPenyusutan = $this->Krs->__currency($totalLevel4AkumulasiPenyusutan);
			$grandTotalAkumulasiPenyusutans[] = $totalLevel4AkumulasiPenyusutan;
			$percenTotalAkumulasiPenyusutan = $totalLevel4AkumulasiPenyusutan/$totalPercentAktiva*100;
			$nominalGrandPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';

			$numberAkumulasiPenyusutan = $numberAkumulasiPenyusutan+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL '.strtoupper($nameAkumulasiPenyusutan));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4AkumulasiPenyusutan);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentAkumulasiPenyusutan);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$numberAktivaLine++;

		// echo '<tr>
		// 		<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($nameAkumulasiPenyusutan).'</b></td>
		// 		<td align="right"><b>'.$nominalTotalLevel4AkumulasiPenyusutan.'</b></td>
		// 		<td align="right"><b>'.$nominalGrandPercentAkumulasiPenyusutan.'</b></td>
		// 	</tr>';
		}
	}
	$numberAkumulasiPenyusutan++;
}

$numberAkumulasiPenyusutanTotal = $numberAkumulasiPenyusutan+1;
$grandTotalAkumulasiPenyusutan = (empty($grandTotalAkumulasiPenyusutans)) ? 0 : round(array_sum($grandTotalAkumulasiPenyusutans),2);		
$percenTotalAkumulasiPenyusutan = $grandTotalAkumulasiPenyusutan/$totalPercentAktiva*100;
$nominalGrandTotalPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';
$totalGrandPercentAkumulasiPenyusutan = ($grandTotalAkumulasiPenyusutan>0) ? $nominalGrandTotalPercentAkumulasiPenyusutan:"0%";

$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, 'TOTAL AKUMULASI PENYUSUTAN');
$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $grandTotalAkumulasiPenyusutan);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $totalGrandPercentAkumulasiPenyusutan);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->applyFromArray($styleArrayTitle);

$numberAktivaLine = $numberAktivaLine+1;
$numberTotalAktiva = $numberAkumulasiPenyusutanTotal+1;
//TOTAL AKTIVA
$grandTotalAktivaKasBank = (empty($grandTotalKasBanks)) ? 0 : round(array_sum($grandTotalKasBanks),2);
$grandTotalAktivaPiutang = (empty($grandTotalPiutangs)) ? 0 : round(array_sum($grandTotalPiutangs),2);
$grandTotalAktivaAktivaTetap = (empty($grandTotalAktivaTetaps)) ? 0 : round(array_sum($grandTotalAktivaTetaps),2);
$grandTotalAktivaAktivaLancarLainnya = (empty($grandTotalAktivaLancarLainnyas)) ? 0 : round(array_sum($grandTotalAktivaLancarLainnyas),2);
$grandTotalAktivaAkumulasiPenyusutan = (empty($grandTotalAkumulasiPenyusutans)) ? 0 : round(array_sum($grandTotalAkumulasiPenyusutans),2);

$totalAktiva = $grandTotalAktivaKasBank+$grandTotalAktivaPiutang+$grandTotalAktivaAktivaTetap+$grandTotalAktivaAktivaLancarLainnya+$grandTotalAktivaAkumulasiPenyusutan;

$totalAktivaName = ' TOTAL AKTIVA';

$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, $totalAktivaName);			
$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalAktiva);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);


//PASIVA
$numberPasivaLine = 4;

$totalDetailHutang = $this->Krs->totalCOADetail($listCOAHutang);
$totalDetailHutangLancar = $this->Krs->totalCOADetail($listCOAHutangLancar);
$totalDetailModal = $this->Krs->totalCOADetail($listCOAModal);
$totalDetailSaldoDitahan = $this->Krs->totalCOADetail($listCOASaldoDitahan);
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
//$grandTotalDetailBeforeSaldoDitahan = $grandTotalPercentBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;

$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$totalGrandLabaRugiBerjalan+$grandTotalPercentPrive+$grandTotalDetailBeforeSaldoDitahan;

/*
$totalDetailHutang = $this->Krs->totalCOADetail($listCOAHutang);
$totalDetailHutangLancar = $this->Krs->totalCOADetail($listCOAHutangLancar);
$totalDetailModal = $this->Krs->totalCOADetail($listCOAModal);
$totalDetailSaldoDitahan = $this->Krs->totalCOADetail($listCOASaldoDitahan);
$totalDetailPrive = $this->Krs->totalCOADetail($listCOAPrive);
$totalDetailBeforeSaldoDitahan = $this->Krs->totalCOADetail($listCOABeforeSaldoDitahan);
$totalDetailBeforePrive = $this->Krs->totalCOADetail($listCOABeforePrive);

$grandTotalPercentHutang = (empty($totalDetailHutang)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutang),2));
$grandTotalPercentHutangLancar = (empty($totalDetailHutangLancar)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutangLancar),2));
$grandTotalPercentModal = (empty($totalDetailModal)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailModal),2));
$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));
$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailPrive),2));
//$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));

$grandTotalPercentBeforeSaldoDitahan = (empty($totalDetailBeforeSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailBeforeSaldoDitahan),2));
$grandTotalPercentBeforePrive = (empty($totalDetailBeforePrive)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailBeforePrive),2));

//$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$grandTotalPercentSaldoDitahan+$grandTotalPercentPrive+$totalGrandLabaRugiBerjalan+$grandTotalPercentBeforeSaldoDitahan+$grandTotalPercentBeforePrive+$totalGrandBeforeLabaRugiBerjalan;
$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$totalGrandLabaRugiBerjalan+$grandTotalPercentBeforePrive+$grandTotalPercentBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan;*/

// Hutang
$grandTotalHutangs = array();
foreach ($listCOAHutang as $idHutang => $detailHutang) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailHutang['Level5']) && $detailHutang['Level4']) {
		list($codeHutang, $nameHutang) = explode('^', $detailHutang['Level4']);

		if(!empty($codeHutang)) {
			//$numberPasivaLine++;
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper($nameHutang));
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}

	if(isset($detailHutang['Level5']) && $detailHutang['Level5']) {
		$debetCreditDetailHutangs = array();
		foreach ($detailHutang['Level5'] as $dataCOAHutang) {
			list($codeDetailHutang, $nameDetailHutang, $debetCreditDetailHutang, $beginningBalanceDetailHutang, $subTotalDetailHutang) = explode('^', $dataCOAHutang);

			if(!empty($subTotalDetailHutang)) {
				//$totalHutangs = $debetCreditDetailHutang+$beginningBalanceDetailHutang;
				$debetCreditDetailHutangs[] = $subTotalDetailHutang;
				// $nominalDetailHutang = $this->Krs->__currency($subTotalDetailHutang);

				$dataPercentGlobalHutang = $grandTotalPercentHutang/$totalPercentPasiva*100;
				$percenHutang = $subTotalDetailHutang/$grandTotalPercentHutang*$dataPercentGlobalHutang;
				//$percenHutang = 0;
				$nominalPercenHutang = $this->Krs->percent($percenHutang).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeDetailHutang.') '.$nameDetailHutang);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $subTotalDetailHutang);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalPercenHutang);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberPasivaLine++;
			}
		}
	}

	if(isset($detailHutang['Level5']) && $detailHutang['Level4']) {
		list($codeHutang, $nameHutang) = explode('^', $detailHutang['Level4']);

		if(!empty($codeHutang)) {
			$totalLevel4Hutang = array_sum($debetCreditDetailHutangs);
			$nominalTotalLevel4Hutang = $this->Krs->__currency($totalLevel4Hutang);
			$grandTotalHutangs[] = $totalLevel4Hutang;
			$percenTotalHutang = $totalLevel4Hutang/$totalPercentPasiva*100;
			$nominalGrandPercentHutang = $this->Krs->percent($percenTotalHutang).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL '.strtoupper($nameHutang));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4Hutang);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentHutang);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
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
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper($nameHutangLancar));
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}

	if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level5']) {
		$debetCreditDetailHutangLancars = array();
		foreach ($detailHutangLancar['Level5'] as $dataCOAHutangLancar) {
			list($codeDetailHutangLancar, $nameDetailHutangLancar, $debetCreditDetailHutangLancar, $beginningBalanceDetailHutangLancar, $subTotalDetailHutangLancar) = explode('^', $dataCOAHutangLancar);

			if(!empty($subTotalDetailHutangLancar)) {
				//$totalHutangLancars = $debetCreditDetailHutangLancar+$beginningBalanceDetailHutangLancar;
				$debetCreditDetailHutangLancars[] = $subTotalDetailHutangLancar;
				
				$dataPercentGlobalHutangLancar = $grandTotalPercentHutangLancar/$totalPercentPasiva*100;
				$percenHutangLancar = $subTotalDetailHutangLancar/$grandTotalPercentHutangLancar*$dataPercentGlobalHutangLancar;
				//$percenHutangLancar = 0;
				$nominalPercenHutangLancar = $this->Krs->percent($percenHutangLancar).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeDetailHutangLancar.') '.$nameDetailHutangLancar);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $subTotalDetailHutangLancar);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalPercenHutangLancar);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberPasivaLine++;
			}
		}
	}

	if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level4']) {
		list($codeHutangLancar, $nameHutangLancar) = explode('^', $detailHutangLancar['Level4']);

		if(!empty($codeHutangLancar)) {
			$totalLevel4HutangLancar = array_sum($debetCreditDetailHutangLancars);
			//$nominalTotalLevel4HutangLancar = $this->Krs->__currency($totalLevel4HutangLancar);
			$grandTotalHutangLancars[] = $totalLevel4HutangLancar;
			$percenTotalHutangLancar = $totalLevel4HutangLancar/$totalPercentPasiva*100;
			$nominalGrandPercentHutangLancar = $this->Krs->percent($percenTotalHutangLancar).'%';
		
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL '.strtoupper($nameHutangLancar));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4HutangLancar);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentHutangLancar);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}
	
}

$grandTotalHutang = (empty($grandTotalHutangs)) ? 0 : round(array_sum($grandTotalHutangs),2);
$grandTotalHutangLancar = (empty($grandTotalHutangLancars)) ? 0 : round(array_sum($grandTotalHutangLancars),2);

$percenGrandTotalHutangLancar = $grandTotalHutang+$grandTotalHutangLancar;
$percenTotalHutangLancar = $percenGrandTotalHutangLancar/$totalPercentPasiva*100;
$nominalGrandTotalPercentHutangLancar = $this->Krs->percent($percenTotalHutangLancar).'%';
$totalGrandPercentHutangLancar = ($percenGrandTotalHutangLancar>0) ? $nominalGrandTotalPercentHutangLancar:"0%";

$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL HUTANG LANCAR');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $percenGrandTotalHutangLancar);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $totalGrandPercentHutangLancar);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);

$numberPasivaLine = $numberPasivaLine+1;
// Modal
$grandTotalModals = array();
foreach ($listCOAModal as $idModal => $detailModal) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailModal['Level5']) && $detailModal['Level4']) {
		list($codeModal, $nameModal) = explode('^', $detailModal['Level4']);

		if(!empty($codeModal)) {
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper($nameModal));
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}

	if(isset($detailModal['Level5']) && $detailModal['Level5']) {
		$debetCreditDetailModals = array();
		foreach ($detailModal['Level5'] as $dataCOAModal) {
			list($codeDetailModal, $nameDetailModal, $debetCreditDetailModal, $beginningBalanceDetailModal, $subTotalDetailModal) = explode('^', $dataCOAModal);

			if(!empty($subTotalDetailModal)) {
				//$totalModals = $debetCreditDetailModal+$beginningBalanceDetailModal;
				$debetCreditDetailModals[] = $subTotalDetailModal;

				$dataPercentGlobalModal = $grandTotalPercentModal/$totalPercentPasiva*100;
				$percenModal = $subTotalDetailModal/$grandTotalPercentModal*$dataPercentGlobalModal;
				//$percenModal = 0;
				$nominalPercenModal = $this->Krs->percent($percenModal).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeDetailModal.') '.$nameDetailModal);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $subTotalDetailModal);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalPercenModal);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberPasivaLine++;
			} else {
				$numberModal = $numberModal-1;
			}
		}
	}

	if(isset($detailModal['Level5']) && $detailModal['Level4']) {
		list($codeModal, $nameModal) = explode('^', $detailModal['Level4']);

		if(!empty($codeModal)) {
			$totalLevel4Modal = array_sum($debetCreditDetailModals);
			$grandTotalModals[] = $totalLevel4Modal;
			$percenTotalModal = $totalLevel4Modal/$totalPercentPasiva*100;
			$nominalGrandPercentModal = $this->Krs->percent($percenTotalModal).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL '.strtoupper($nameModal));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4Modal);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentModal);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}
}

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
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper($nameSaldoDitahan));
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
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
			
			$dataPercentGlobalSaldoDitahan = $grandTotalPercentSaldoDitahan/$totalPercentPasiva*100;
			$percenSaldoDitahan = ($dataPercentGlobalSaldoDitahan!=0) ? $subTotalBeforeSaldoDitahan/$grandTotalPercentSaldoDitahan*$dataPercentGlobalSaldoDitahan : 0;
			//$percenSaldoDitahan = $subTotalDetailSaldoDitahan/$grandTotalPercentSaldoDitahan*$dataPercentGlobalSaldoDitahan;
			//$percenSaldoDitahan = 0;
			$nominalPercenSaldoDitahan = $this->Krs->percent($percenSaldoDitahan).'%';
			//.' = '.$subTotalDetailBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive
			
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeDetailSaldoDitahan.') '.$nameDetailSaldoDitahan);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $subTotalBeforeSaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalPercenSaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}

	if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level4']) {
		list($codeSaldoDitahan, $nameSaldoDitahan) = explode('^', $detailSaldoDitahan['Level4']);

		if(!empty($codeSaldoDitahan)) {
			$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
			$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
			$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
			$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL '.strtoupper($nameSaldoDitahan));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4SaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentSaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}else {
		//pr($grandTotalBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive);
		$subTotalBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
		$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;

		$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
		$nominalTotalLevel4SaldoDitahan = $this->Krs->__currency($totalLevel4SaldoDitahan);
		$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
		$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
		$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';
		
		if($totalLevel4SaldoDitahan>0) {
		$titleSaldoDitahan = "Saldo Laba Ditahan";		
		// echo '<tr>
		// 	<td colspan="3"><b>'.strtoupper($titleSaldoDitahan).'</b></td>
		// </tr>';
		// echo '<tr>
		// 		<td>'.$titleSaldoDitahan.'</td>
		// 		<td align="right">'.$nominalTotalLevel4SaldoDitahan.'</td>
		// 		<td align="right">'.$nominalGrandPercentSaldoDitahan.'</td>
		// 	</tr>';
		// echo '<tr>
		// 	<td>'.str_repeat('&nbsp;&nbsp;&nbsp;', 3).'<b>TOTAL '.strtoupper($titleSaldoDitahan).'</b></td>
		// 	<td align="right"><b>'.$nominalTotalLevel4SaldoDitahan.'</b></td>
		// 	<td align="right"><b>'.$nominalGrandPercentSaldoDitahan.'</b></td>
		// </tr>';
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper($titleSaldoDitahan));
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4SaldoDitahan);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentSaldoDitahan);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL '.strtoupper($titleSaldoDitahan));
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4SaldoDitahan);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentSaldoDitahan);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
		
		$numberPasivaLine++;
		}
	}
}


// Laba/Rugi Berjalan
$percenTotalLabaRugiBerjalan = $totalGrandLabaRugiBerjalan/$totalPercentPasiva*100;
$nominalGrandPercentLabaRugiBerjalan = $this->Krs->percent($percenTotalLabaRugiBerjalan).'%';
$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'LABA/RUGI BERJALAN');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'Laba/Rugi Berjalan');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalGrandLabaRugiBerjalan);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentLabaRugiBerjalan);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);

$numberPasivaLine = $numberPasivaLine+1;
// Prive
$grandTotalPrives = array();
foreach ($listCOAPrive as $idPrive => $detailPrive) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPrive['Level5']) && $detailPrive['Level4']) {
		list($codePrive, $namePrive) = explode('^', $detailPrive['Level4']);

		if(!empty($codePrive)) {
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper($namePrive));
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}

	if(isset($detailPrive['Level5']) && $detailPrive['Level5']) {
		$debetCreditDetailPrives = array();
		foreach ($detailPrive['Level5'] as $dataCOAPrive) {
			list($codeDetailPrive, $nameDetailPrive, $debetCreditDetailPrive, $beginningBalanceDetailPrive, $subTotalDetailPrive) = explode('^', $dataCOAPrive);

			if(!empty($subTotalDetailPrive)) {
				//$totalPrives = $debetCreditDetailPrive+$beginningBalanceDetailPrive;
				$debetCreditDetailPrives[] = $subTotalDetailPrive;

				$dataPercentGlobalPrive = $grandTotalPercentPrive/$totalPercentPasiva*100;
				$percenPrive = $subTotalDetailPrive/$grandTotalPercentPrive*$dataPercentGlobalPrive;
				//$percenPrive = 0;
				$nominalPercenPrive = $this->Krs->percent($percenPrive).'%';

				$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeDetailPrive.') '.$nameDetailPrive);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $subTotalDetailPrive);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalPercenPrive);
				$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
				$numberPasivaLine++;
			} else {
				$numberPrive = $numberPrive-1;
			}
		}
	}

	if(isset($detailPrive['Level5']) && $detailPrive['Level4']) {
		list($codePrive, $namePrive) = explode('^', $detailPrive['Level4']);

		if(!empty($codePrive)) {
			$totalLevel4Prive = array_sum($debetCreditDetailPrives);
			$grandTotalPrives[] = $totalLevel4Prive;
			$percenTotalPrive = $totalLevel4Prive/$totalPercentPasiva*100;
			$nominalGrandPercentPrive = $this->Krs->percent($percenTotalPrive).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL '.strtoupper($namePrive));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4Prive);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentPrive);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
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

$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL PASIVA');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalPasiva);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);



} else {

##################################################################################
##################################################################################

//Halaman Global


##################################################################################	
##################################################################################
$numberAktivaLine = 4;
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
			$debetCreditDetailKasBanks[] = $subTotalDetailKasBank;
		}
	}

	if(isset($detailKasBank['Level5']) && $detailKasBank['Level4']) {
		list($codeKasBank, $nameKasBank) = explode('^', $detailKasBank['Level4']);

		if(!empty($codeKasBank)) {
			$totalLevel4KasBank = array_sum($debetCreditDetailKasBanks);
			$grandTotalKasBanks[] = $totalLevel4KasBank;
			$percenTotalKasBank = $totalLevel4KasBank/$totalPercentAktiva*100;
			$nominalGrandPercentKasBank = $this->Krs->percent($percenTotalKasBank).'%';
		
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeKasBank.') '.strtoupper($nameKasBank));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4KasBank);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentKasBank);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			//$numberKasBank++;
			$numberAktivaLine++;
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
			$debetCreditDetailPiutangs[] = $subTotalDetailPiutang;
		}
	}

	if(isset($detailPiutang['Level5']) && $detailPiutang['Level4']) {
		list($codePiutang, $namePiutang) = explode('^', $detailPiutang['Level4']);

		if(!empty($codePiutang)) {
			$totalLevel4Piutang = array_sum($debetCreditDetailPiutangs);
			$grandTotalPiutangs[] = $totalLevel4Piutang;
			$percenTotalPiutang = $totalLevel4Piutang/$totalPercentAktiva*100;
			$nominalGrandPercentPiutang = $this->Krs->percent($percenTotalPiutang).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codePiutang.') '.strtoupper($namePiutang));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4Piutang);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentPiutang);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}
}

// Aktiva Tetap
$grandTotalAktivaTetaps = array();
foreach ($listCOAAktivaTetap as $idAktivaTetap => $detailAktivaTetap) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level5']) {
		$debetCreditDetailAktivaTetaps = array();
		foreach ($detailAktivaTetap['Level5'] as $dataCOAAktivaTetap) {
			list($codeDetailAktivaTetap, $nameDetailAktivaTetap, $debetCreditDetailAktivaTetap, $beginningBalanceDetailAktivaTetap, $subTotalDetailAktivaTetap) = explode('^', $dataCOAAktivaTetap);

			$debetCreditDetailAktivaTetaps[] = $subTotalDetailAktivaTetap;
		}
	}

	if(isset($detailAktivaTetap['Level5']) && $detailAktivaTetap['Level4']) {
		list($codeAktivaTetap, $nameAktivaTetap) = explode('^', $detailAktivaTetap['Level4']);

		if(!empty($codeAktivaTetap)) {
			$totalLevel4AktivaTetap = array_sum($debetCreditDetailAktivaTetaps);
			$nominalTotalLevel4AktivaTetap = $this->Krs->__currency($totalLevel4AktivaTetap);
			$grandTotalAktivaTetaps[] = $totalLevel4AktivaTetap;
			$percenTotalAktivaTetap = $totalLevel4AktivaTetap/$totalPercentAktiva*100;
			$nominalGrandPercentAktivaTetap = $this->Krs->percent($percenTotalAktivaTetap).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeAktivaTetap.') '.strtoupper($nameAktivaTetap));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4AktivaTetap);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentAktivaTetap);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}
}

// Aktiva Lancar Lainnya
$grandTotalAktivaLancarLainnyas = array();
foreach ($listCOAAktivaLancarLainnya as $idAktivaLancarLainnya => $detailAktivaLancarLainnya) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level5']) {
		$debetCreditDetailAktivaLancarLainnyas = array();
		foreach ($detailAktivaLancarLainnya['Level5'] as $dataCOAAktivaLancarLainnya) {
			list($codeDetailAktivaLancarLainnya, $nameDetailAktivaLancarLainnya, $debetCreditDetailAktivaLancarLainnya, $beginningBalanceDetailAktivaLancarLainnya, $subTotalDetailAktivaLancarLainnya) = explode('^', $dataCOAAktivaLancarLainnya);

			$debetCreditDetailAktivaLancarLainnyas[] = $subTotalDetailAktivaLancarLainnya;
		}
	}

	if(isset($detailAktivaLancarLainnya['Level5']) && $detailAktivaLancarLainnya['Level4']) {
		list($codeAktivaLancarLainnya, $nameAktivaLancarLainnya) = explode('^', $detailAktivaLancarLainnya['Level4']);

		if(!empty($codeAktivaLancarLainnya)) {
			$totalLevel4AktivaLancarLainnya = array_sum($debetCreditDetailAktivaLancarLainnyas);
			$nominalTotalLevel4AktivaLancarLainnya = $this->Krs->__currency($totalLevel4AktivaLancarLainnya);
			$grandTotalAktivaLancarLainnyas[] = $totalLevel4AktivaLancarLainnya;
			$percenTotalAktivaLancarLainnya = $totalLevel4AktivaLancarLainnya/$totalPercentAktiva*100;
			$nominalGrandPercentAktivaLancarLainnya = $this->Krs->percent($percenTotalAktivaLancarLainnya).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeAktivaLancarLainnya.') '.strtoupper($nameAktivaLancarLainnya));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4AktivaLancarLainnya);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentAktivaTetap);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
		}
	}
}

// Akumulasi Penyusutan
$grandTotalAkumulasiPenyusutans = array();
foreach ($listCOAAkumulasiPenyusutan as $idAkumulasiPenyusutan => $detailAkumulasiPenyusutan) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level5']) {
		$debetCreditDetailAkumulasiPenyusutans = array();
		foreach ($detailAkumulasiPenyusutan['Level5'] as $dataCOAAkumulasiPenyusutan) {
			list($codeDetailAkumulasiPenyusutan, $nameDetailAkumulasiPenyusutan, $debetCreditDetailAkumulasiPenyusutan, $beginningBalanceDetailAkumulasiPenyusutan, $subTotalDetailAkumulasiPenyusutan) = explode('^', $dataCOAAkumulasiPenyusutan);
			
			$debetCreditDetailAkumulasiPenyusutans[] = $subTotalDetailAkumulasiPenyusutan;
		}
	}

	if(isset($detailAkumulasiPenyusutan['Level5']) && $detailAkumulasiPenyusutan['Level4']) {
		list($codeAkumulasiPenyusutan, $nameAkumulasiPenyusutan) = explode('^', $detailAkumulasiPenyusutan['Level4']);

		if(!empty($codeAkumulasiPenyusutan)) {
			$totalLevel4AkumulasiPenyusutan = array_sum($debetCreditDetailAkumulasiPenyusutans);
			$grandTotalAkumulasiPenyusutans[] = $totalLevel4AkumulasiPenyusutan;
			$percenTotalAkumulasiPenyusutan = $totalLevel4AkumulasiPenyusutan/$totalPercentAktiva*100;
			$nominalGrandPercentAkumulasiPenyusutan = $this->Krs->percent($percenTotalAkumulasiPenyusutan).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, '('.$codeAkumulasiPenyusutan.') '.strtoupper($nameAkumulasiPenyusutan));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalLevel4AkumulasiPenyusutan);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$numberAktivaLine, $nominalGrandPercentAkumulasiPenyusutan);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$numberAktivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
			$numberAktivaLine++;
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

$totalAktivaName = 'TOTAL AKTIVA';

$objPHPExcel->getActiveSheet()->setCellValue('A'.$numberAktivaLine, $totalAktivaName);			
$objPHPExcel->getActiveSheet()->setCellValue('B'.$numberAktivaLine, $totalAktiva);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->getNumberFormat()->setFormatCode('_(#,##0.00_);_(\(#,##0.00\);_("-"??_);_(@_)');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numberAktivaLine)->applyFromArray($styleArrayTitle);
//$numberAktivaLine++;



/***********************************
				PASIVA
***********************************/
$numberPasivaLine = 4;
$totalDetailHutang = $this->Krs->totalCOADetail($listCOAHutang);
$totalDetailHutangLancar = $this->Krs->totalCOADetail($listCOAHutangLancar);
$totalDetailModal = $this->Krs->totalCOADetail($listCOAModal);
$totalDetailSaldoDitahan = $this->Krs->totalCOADetail($listCOASaldoDitahan);
$totalDetailPrive = $this->Krs->totalCOADetailBefore($listCOAPrive);
//$totalDetailBeforeSaldoDitahan = $this->Krs->totalCOADetailBefore($listCOABeforeSaldoDitahan);
$totalDetailBeforePrive = $this->Krs->totalCOADetailBefore($listCOABeforePrive);

$grandTotalPercentHutang = (empty($totalDetailHutang)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutang),2));
$grandTotalPercentHutangLancar = (empty($totalDetailHutangLancar)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutangLancar),2));
$grandTotalPercentModal = (empty($totalDetailModal)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailModal),2));
$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));
$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : round(array_sum($totalDetailPrive),2);

//$grandTotalPercentBeforeSaldoDitahan = (empty($totalDetailBeforeSaldoDitahan)) ? 0 : round(array_sum($totalDetailBeforeSaldoDitahan),2);
$grandTotalPercentBeforePrive = (empty($totalDetailBeforePrive)) ? 0 : round(array_sum($totalDetailBeforePrive),2);

$grandTotalDetailBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;
//$grandTotalDetailBeforeSaldoDitahan = $grandTotalPercentBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalPercentBeforePrive;

$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$totalGrandLabaRugiBerjalan+$grandTotalPercentPrive+$grandTotalDetailBeforeSaldoDitahan;

/*$totalDetailHutang = $this->Krs->totalCOADetail($listCOAHutang);
$totalDetailHutangLancar = $this->Krs->totalCOADetail($listCOAHutangLancar);
$totalDetailModal = $this->Krs->totalCOADetail($listCOAModal);
$totalDetailSaldoDitahan = $this->Krs->totalCOADetail($listCOASaldoDitahan);
$totalDetailPrive = $this->Krs->totalCOADetail($listCOAPrive);
$totalDetailBeforeSaldoDitahan = $this->Krs->totalCOADetail($listCOABeforeSaldoDitahan);
$totalDetailBeforePrive = $this->Krs->totalCOADetail($listCOABeforePrive);

$grandTotalPercentHutang = (empty($totalDetailHutang)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutang),2));
$grandTotalPercentHutangLancar = (empty($totalDetailHutangLancar)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailHutangLancar),2));
$grandTotalPercentModal = (empty($totalDetailModal)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailModal),2));
$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));
$grandTotalPercentPrive = (empty($totalDetailPrive)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailPrive),2));
//$grandTotalPercentSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan = (empty($totalDetailSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailSaldoDitahan),2));

$grandTotalPercentBeforeSaldoDitahan = (empty($totalDetailBeforeSaldoDitahan)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailBeforeSaldoDitahan),2));
$grandTotalPercentBeforePrive = (empty($totalDetailBeforePrive)) ? 0 : $this->Krs->flipTheValue(round(array_sum($totalDetailBeforePrive),2));

//$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$grandTotalPercentSaldoDitahan+$grandTotalPercentPrive+$totalGrandLabaRugiBerjalan+$grandTotalPercentBeforeSaldoDitahan+$grandTotalPercentBeforePrive+$totalGrandBeforeLabaRugiBerjalan;
$totalPercentPasiva = $grandTotalPercentHutang+$grandTotalPercentHutangLancar+$grandTotalPercentModal+$totalGrandLabaRugiBerjalan+$grandTotalPercentBeforePrive+$grandTotalPercentBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan;*/
// Hutang
$grandTotalHutangs = array();
foreach ($listCOAHutang as $idHutang => $detailHutang) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailHutang['Level5']) && $detailHutang['Level5']) {
		$debetCreditDetailHutangs = array();
		foreach ($detailHutang['Level5'] as $dataCOAHutang) {
			list($codeDetailHutang, $nameDetailHutang, $debetCreditDetailHutang, $beginningBalanceDetailHutang, $subTotalDetailHutang) = explode('^', $dataCOAHutang);

			$debetCreditDetailHutangs[] = $subTotalDetailHutang;
		}
	}

	if(isset($detailHutang['Level5']) && $detailHutang['Level4']) {
		list($codeHutang, $nameHutang) = explode('^', $detailHutang['Level4']);

		if(!empty($codeHutang)) {
			$totalLevel4Hutang = array_sum($debetCreditDetailHutangs);
			$nominalTotalLevel4Hutang = $this->Krs->__currency($totalLevel4Hutang);
			$grandTotalHutangs[] = $totalLevel4Hutang;
			$percenTotalHutang = $totalLevel4Hutang/$totalPercentPasiva*100;
			$nominalGrandPercentHutang = $this->Krs->percent($percenTotalHutang).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeHutang.') '.strtoupper($nameHutang));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4Hutang);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentHutang);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}
}


// Hutang Lancar
$grandTotalHutangLancars = array();
foreach ($listCOAHutangLancar as $idHutangLancar => $detailHutangLancar) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level5']) {
		$debetCreditDetailHutangLancars = array();
		foreach ($detailHutangLancar['Level5'] as $dataCOAHutangLancar) {
			list($codeDetailHutangLancar, $nameDetailHutangLancar, $debetCreditDetailHutangLancar, $beginningBalanceDetailHutangLancar, $subTotalDetailHutangLancar) = explode('^', $dataCOAHutangLancar);

			$debetCreditDetailHutangLancars[] = $subTotalDetailHutangLancar;
		}
	}

	if(isset($detailHutangLancar['Level5']) && $detailHutangLancar['Level4']) {
		list($codeHutangLancar, $nameHutangLancar) = explode('^', $detailHutangLancar['Level4']);

		if(!empty($codeHutangLancar)) {
			$totalLevel4HutangLancar = array_sum($debetCreditDetailHutangLancars);
			//$nominalTotalLevel4HutangLancar = $this->Krs->__currency($totalLevel4HutangLancar);
			$grandTotalHutangLancars[] = $totalLevel4HutangLancar;
			$percenTotalHutangLancar = $totalLevel4HutangLancar/$totalPercentPasiva*100;
			$nominalGrandPercentHutangLancar = $this->Krs->percent($percenTotalHutangLancar).'%';
		
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeHutangLancar.') '.strtoupper($nameHutangLancar));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4HutangLancar);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentHutangLancar);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}
}

// Modal
$grandTotalModals = array();
foreach ($listCOAModal as $idModal => $detailModal) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailModal['Level5']) && $detailModal['Level5']) {
		$debetCreditDetailModals = array();
		foreach ($detailModal['Level5'] as $dataCOAModal) {
			list($codeDetailModal, $nameDetailModal, $debetCreditDetailModal, $beginningBalanceDetailModal, $subTotalDetailModal) = explode('^', $dataCOAModal);

			$debetCreditDetailModals[] = $subTotalDetailModal;
		}
	}

	if(isset($detailModal['Level5']) && $detailModal['Level4']) {
		list($codeModal, $nameModal) = explode('^', $detailModal['Level4']);

		if(!empty($codeModal)) {
			$totalLevel4Modal = array_sum($debetCreditDetailModals);
			$grandTotalModals[] = $totalLevel4Modal;
			$percenTotalModal = $totalLevel4Modal/$totalPercentPasiva*100;
			$nominalGrandPercentModal = $this->Krs->percent($percenTotalModal).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeModal.') '.strtoupper($nameModal));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4Modal);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentModal);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}
}

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
		}
	} else {
		//pr($grandTotalBeforeSaldoDitahan.'+'.$totalGrandBeforeLabaRugiBerjalan.'+'.$grandTotalBeforePrive);
		$subTotalBeforeSaldoDitahan = $grandTotalBeforeSaldoDitahan+$totalGrandBeforeLabaRugiBerjalan+$grandTotalBeforePrive;
		$debetCreditDetailSaldoDitahans[] = $subTotalBeforeSaldoDitahan;
	}

	if(isset($detailSaldoDitahan['Level5']) && $detailSaldoDitahan['Level4']) {
		list($codeSaldoDitahan, $nameSaldoDitahan) = explode('^', $detailSaldoDitahan['Level4']);

		if(!empty($codeSaldoDitahan)) {
			$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
			$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
			$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
			$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codeSaldoDitahan.') '.strtoupper($nameSaldoDitahan));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4SaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentSaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	} else {
		$totalLevel4SaldoDitahan = array_sum($debetCreditDetailSaldoDitahans);
		//$nominalTotalLevel4SaldoDitahan = $this->Krs->__currency($totalLevel4SaldoDitahan);
		$grandTotalSaldoDitahans[] = $totalLevel4SaldoDitahan;
		$percenTotalSaldoDitahan = $totalLevel4SaldoDitahan/$totalPercentPasiva*100;
		$nominalGrandPercentSaldoDitahan = $this->Krs->percent($percenTotalSaldoDitahan).'%';
		if($totalLevel4SaldoDitahan>0) {
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, strtoupper('Saldo Laba Ditahan'));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4SaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentSaldoDitahan);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
		}
	}
}


// Laba/Rugi Berjalan
$numberTotalSaldoDitahan = $numberPasivaLine;
$percenTotalLabaRugiBerjalan = $totalGrandLabaRugiBerjalan/$totalPercentPasiva*100;
$nominalGrandPercentLabaRugiBerjalan = $this->Krs->percent($percenTotalLabaRugiBerjalan).'%';
$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'LABA/RUGI BERJALAN');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalGrandLabaRugiBerjalan);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentLabaRugiBerjalan);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);


$numberPasivaLine = $numberPasivaLine+1;
// Prive
$grandTotalPrives = array();
foreach ($listCOAPrive as $idPrive => $detailPrive) {
 	// Keterangan pada Kas serta Bank
	if(isset($detailPrive['Level5']) && $detailPrive['Level5']) {
		$debetCreditDetailPrives = array();
		foreach ($detailPrive['Level5'] as $dataCOAPrive) {
			list($codeDetailPrive, $nameDetailPrive, $debetCreditDetailPrive, $beginningBalanceDetailPrive, $subTotalDetailPrive) = explode('^', $dataCOAPrive);

			$debetCreditDetailPrives[] = $subTotalDetailPrive;
		}
	}

	if(isset($detailPrive['Level5']) && $detailPrive['Level4']) {
		list($codePrive, $namePrive) = explode('^', $detailPrive['Level4']);

		if(!empty($codePrive)) {
			$totalLevel4Prive = array_sum($debetCreditDetailPrives);
			$grandTotalPrives[] = $totalLevel4Prive;
			$percenTotalPrive = $totalLevel4Prive/$totalPercentPasiva*100;
			$nominalGrandPercentPrive = $this->Krs->percent($percenTotalPrive).'%';

			$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, '('.$codePrive.') '.strtoupper($namePrive));
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalLevel4Prive);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$numberPasivaLine, $nominalGrandPercentPrive);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
			$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
			$numberPasivaLine++;
			
		}
	}
}

//$numberTotalPasiva = $numberPrive;
//TOTAL PASIVA
$grandTotalPasivaHutang = (empty($grandTotalHutangs)) ? 0 : round(array_sum($grandTotalHutangs),2);
$grandTotalPasivaHutangLancar = (empty($grandTotalHutangLancars)) ? 0 : round(array_sum($grandTotalHutangLancars),2);
$grandTotalPasivaModal = (empty($grandTotalModals)) ? 0 : round(array_sum($grandTotalModals),2);
$grandTotalPasivaSaldoDitahan = (empty($grandTotalSaldoDitahans)) ? 0 : round(array_sum($grandTotalSaldoDitahans),2);
$grandTotalPasivaPrive = (empty($grandTotalPrives)) ? 0 : round(array_sum($grandTotalPrives),2);


$totalPasiva = $grandTotalPasivaHutang+$grandTotalPasivaHutangLancar+$grandTotalPasivaModal+$grandTotalPasivaSaldoDitahan+$grandTotalPasivaPrive+$totalGrandLabaRugiBerjalan;

$objPHPExcel->getActiveSheet()->setCellValue('E'.$numberPasivaLine, 'TOTAL PASIVA');
$objPHPExcel->getActiveSheet()->setCellValue('F'.$numberPasivaLine, $totalPasiva);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('E'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('F'.$numberPasivaLine)->applyFromArray($styleArrayTitle);
$objPHPExcel->getActiveSheet()->getStyle('G'.$numberPasivaLine)->applyFromArray($styleArrayTitle);




}


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Laporan Neraca');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// redirect output to client browser
// $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

// redirect output to client browser
header("Content-type: application/vnd.ms-excel"); 
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Neraca.xls"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->setTempDir(TMP);
$objWriter->save('php://output');

$objPHPExcel->disconnectWorksheets();
unset($objPHPExcel);
?>