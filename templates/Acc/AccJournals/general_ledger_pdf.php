<?php
/*if(is_array(!empty($dataBeginningBalance))){
	$accBeginingBalance = $dataBeginningBalance["AccBeginningBalance"];
	$dates = $accBeginingBalance["dates"];
}*/
//pr($data['rows']);

//pr($tbl);
	// <th width="150">Keterangan</th>
	// $result = Set::combine($beginningBalanceJournal, array('debet', '{n}.ArtamaAccJournalLine.debet'), array('credit', '{n}.ArtamaAccJournalLine.credit'), '{n}.ArtamaAccJournalLine.artama_acc_chart_of_account_id');



ini_set('precision', 14);
//list($dateFroms, $dateTos) = explode("^", $dates);
//$dateFrom = (empty($dateFroms)) ? "":strtoupper($this->Krs->date_indo($dateFroms,false));
//$dateTo = (empty($dateTos)) ? "":strtoupper($this->Krs->date_indo($dateTos));

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
	$marginRight = 5;
	
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
	$pdf->AddPage('P', 'A4');
	//-------------------- EOR -----------------------------------------
	// set font
	// set font
	//$pdf->SetFont('helvetica', '', 12);
	$pdf->SetFont('helvetica', '', 8);
	

	$tbl = '<table width="100%" cellspacing="1" cellpadding="4" border="0">
			<tr>
				<td width="100" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">No. Ref</td>
				<td width="80" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Tanggal</td>
				<td width="180" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Uraian</td>
				<td width="40" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">D/K</td>
				<td width="85" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Debit</td>
				<td width="85" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Kredit</td>
				<td width="85" align="center" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Keterangan</td>
			</tr>';
			$dataSessionSetting = $this->Krs->sessionSetting();

			$COA = Set::combine($data['rows'], '{n}.ArtamaAccChartOfAccount.id', array('{0}^{1}^{2} {3}^{4}^{5}^{6}', '{n}.ArtamaAccChartOfAccount.code', '{n}.ArtamaAccChartOfAccount.name', '{n}.CustomerCoa.title', '{n}.CustomerCoa.name', '{n}.ArtamaAccChartOfAccount.beginning_balance', '{n}.ArtamaAccChartOfAccount.group', '{n}.ArtamaAccChartOfAccount.journal_type'));

			// $COA = Set::combine($data['rows'], '{n}.ArtamaAccChartOfAccount.id', array('{0}^{1}^{2} {3}^{4}^{6}', '{n}.ArtamaAccChartOfAccount.code', '{n}.ArtamaAccChartOfAccount.name', '{n}.CustomerCoa.title', '{n}.CustomerCoa.name', '{n}.ArtamaAccChartOfAccount.beginning_balance'));
				//pr($COA);
		// pr($data);
			if(is_array($data['rows'])){
				// Mengambil data session Setting
				$dataSessionSetting = $this->Krs->sessionSetting();

				foreach ($COA as $COAId => $COAData) {
					list($COACode, $COAName, $COACustomerName, $COABeginningBalance, $COAGroup, $COAJournalType) = explode('^', $COAData);
					//pr($COAData);

					// list($COACode, $COAName, $COACustomerName, $COABeginningBalance) = explode('^', $COAData);
					//$dateAfter = "";
					$beginningBalanceData = $COABeginningBalance;
					$beginningBalanceValue = $this->Krs->__currency($beginningBalanceData);
					$beginningBalanceDate = $this->Time->format($format = 'd M Y', $dateAfter);

					if($COAGroup=='laba-rugi'){
						$beginningBalanceJournalData = Set::extract('/ArtamaAccJournalLine[artama_acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournalLabaRugi);
					} else {											
						$beginningBalanceJournalData = Set::extract('/ArtamaAccJournalLine[artama_acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournal);
					}

					//pr($beginningBalanceJournalData);

					//$beginningBalanceJournalData = Set::extract('/ArtamaAccJournalLine[artama_acc_chart_of_account_id='.$COAId.']', $beginningBalanceJournal);
					if(!empty($beginningBalanceJournalData) && !empty($dateAfter)) {
						if($COAJournalType=="prive") {
							$beginningBalanceJournalTotal = 0;
						} else {
							$beginningBalanceJournalDatas = $beginningBalanceJournalData[0]['ArtamaAccJournalLine'];
							$beginningBalanceDebet = $beginningBalanceJournalDatas['debet'];
							$beginningBalanceCredit = $beginningBalanceJournalDatas['credit'];
							$beginningBalanceJournalTotal = $beginningBalanceDebet-$beginningBalanceCredit;
						}
					} else {
						$beginningBalanceJournalTotal = 0;
					}

					//pr(round($beginningBalanceJournalTotal, 2).'+'.round($beginningBalanceData,2));

					$totalBeginningBalance = round($beginningBalanceJournalTotal, 2)+round($beginningBalanceData,2);
					$totalBeginningBalanceValue = $this->Krs->__currency($totalBeginningBalance);
					$COAOfName = (empty($COAName)) ? $COACustomerName : $COAName;

					$tbl .= '<tr>
							<td style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">No Perkiraan</td>
							<td colspan="6" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">: '.$COACode.'</td>
						</tr>
						<tr>
							<td  style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Nama Perkiraan</td>
							<td colspan="3"  style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">: '.$COAOfName.'</td>
							<td colspan="2"  style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Saldo Awal : '.$beginningBalanceDate.'</td>
							<td align="right"  style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">'.$totalBeginningBalanceValue.'</td>
						</tr>';

				$rows = array();
				$totalDebets = array();
				$totalCredits = array();
				$totalTransaksis = array();
				foreach ($data['rows'] as $view){
					$coa = $view["ArtamaAccChartOfAccount"];
					$coaId = $coa['id'];
					if($coaId==$COAId) {
						$journal = $view["ArtamaAccJournal"];
						$journalLine = $view['ArtamaAccJournalLine'];
						
						$journalBranchId = $journal["branch_id"];
						// Mengambil data branch
						//$dataBranchName = $dataSessionSetting["branch_data"][$journalBranchId];

						$journalId = $journal['id'];
						$journalCode = $journal['code'];
						$journalDate = (empty($journal['date'])) ? '' : $this->Time->format($format = 'd M Y', $journal['date']);
						$journalLineName = $journalLine['name'];
						$journalLineLedgerDC = $journalLine['ledger_dc'];
						$journalLineDebet = $this->Krs->__currency($journalLine['debet']);
						$journalLineCredit = $this->Krs->__currency($journalLine['credit']);
						
						$coaCode = $coa['code'];
						$coaName = $coa['name'];
						$totalDebets[] = $journalLine['debet'];
						$totalCredits[] = $journalLine['credit'];
						$totalTransaksis[] = 1;
						//<td align="center">'.$dataBranchName.'</td>
						$tbl .= '<tr>
								
								<td align="center">'.$journalCode.'</td>
								<td align="center">'.$journalDate.'</td>
								<td>'.$journalLineName.'</td>
								<td align="center">'.$journalLineLedgerDC.'</td>
								<td align="right">'.$journalLineDebet.'</td>
								<td align="right">'.$journalLineCredit.'</td>
								<td>&nbsp;</td>
							</tr>';
					}
				}

				$totalTransaksi = count($totalTransaksis);
				$totalDebet = (int)array_sum($totalDebets);
				$totalCredit = (int)array_sum($totalCredits);
				
				//$totalDC = $totalBeginningBalance+$totalDebet-$totalCredit;
				$totalDCs = ($totalBeginningBalance+$totalDebet)-$totalCredit;
				$totalDC = round($totalDCs,2);
				//$totalDC = $beginningBalanceData+$beginningBalanceJournalTotal+$totalDebet-$totalCredit;

				//$totalDC = $beginningBalanceData+$totalDebet-$totalCredit;
				$grandTotalDebet = $this->Krs->__currency($totalDebet);
				$grandTotalCredit = $this->Krs->__currency($totalCredit);
				$grandTotalDC = $this->Krs->__currency($totalDC);
				$tbl .= '<tr>
						<td align="left" colspan="4" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Jumlah transaksi sebanyak : '.$totalTransaksi.'</td>
						<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$grandTotalDebet.'</b></td>
						<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$grandTotalCredit.'</b></td>
						<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$grandTotalDC.'</b></td>
					</tr>
					<tr>
						<td align="right" colspan="4" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">Net Activity : </td>
						<td align="right" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;"><b>'.$grandTotalDC.'</b></td>
						<td align="right" colspan="2" style="border-bottom-style: dashed;border-bottom-width: 1px;font-weight:bold;">&nbsp;</td>
					</tr>
					<tr><td colspan="7"></td></tr>';
				}
				
			}


	$tbl .= '</table>';
	//pr($tbl);

	
	$pdf->writeHTML($tbl, true, false, false, false, '');
	//$pdf->Cell(0, 0, 'A4 LANDSCAPE', 1, 1, 'C');
	

	//pr($tbl);

	//$pdf->writeHTML($footers, true, false, false, false, '');
	$pdf->Output('BukuBesar.pdf', 'D');
	$pdf->Output('BukuBesar.pdf', 'D');
	
?>
