<?php
/*
 * @file		xls_coa.php
 * @package		SImAcoTa(System Information Accounting Artama)
 * @since		v 1.09.10
 * @copyright   Copyright 2004-2013, KersenSoft, Inc.
 * @license		Kersen License 
 */
 //$urls = array('url'=>array($uuid));
 //$url_paging = array_merge_recursive($filter_options, $urls);

// pr($data);
/*
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
	$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);

// Add some data, resembling some different data types								
	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID(kolom jangan dihapus)');
	$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Kode Perkiraan');
	$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Nama Perkiraan');
	$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Saldo Awal');

	$a = 1;
	foreach ($datas as $views){
		$view = $views['AccChartOfAccount'];
		$customer = $views["Customer"];

		$customerId = $customer["id"];
		$customerName = $customer["title"].' '.$customer["name"];
		$COAId = $view["id"];
		$code = $view["code"];
		$beginningBalance = (empty($view["beginning_balance"])) ? 0 : $view["beginning_balance"];
		$name = (empty($view["name"]) && !empty($customerName)) ? $customerName : $view["name"];
		$level = $view["level"];
		$transaction = $view["transaction"];
		$contraAccount = $view['contra_account'];

		$nameCoa = ($level==5) ? $name : $name;
		$codeCoa = ($level==5) ? $code : $code;
		$journalType = (empty($view["journal_type"])) ? "" : $this->Krs->selectCOAType($view["journal_type"]);

		$COAId = $view['id'];
		$COALevel = $view['level'];
		$COAType = (empty($view['type'])) ? '': $view['type'];

		if($COALevel==2){
			$COACode = ' '.$view['code'];
			$COAName = ' '.$view['name'];
		} elseif($COALevel==3) {
			$COACode = '   '.$view['code'];
			$COAName = '   '.$view['name'];
		} elseif($COALevel==4){
			$COACode = '      '.$view['code'];
			$COAName = '      '.$view['name'];
		} else {
			$COACode = $view['code'];
			$COAName = $view['name'];
		}
		
		$line = $a+1;

		if($COALevel==1){
			$styleCOA = array('font' => array('bold' => true, 'size' => 12), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
		} elseif($COALevel==2 || $COALevel==3) {
			$styleCOA = array('font' => array('bold' => true, 'italic' => true, 'size' => 11), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
		} else {
			$styleCOA = array('font' => array('size' => 11), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
		}
		
		//pr($COACode.$COAName.$beginningBalance);

		$objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $COAId);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $codeCoa);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $nameCoa);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $beginningBalance);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$line)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->getStyle('B'.$line)->applyFromArray($styleCOA);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$line)->applyFromArray($styleCOA);

		$a++;
	}
//


// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle('Daftar Perkiraan');
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	
	// redirect output to client browser
	// $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	

	header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=\"daftar_perkiraan.xls" );
	header ("Content-Description: Generated Report" );
	// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	// $excel->_output('newFilename'); 
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	$objWriter->setTempDir(TMP);
	$objWriter->save('php://output');
	*/
?>