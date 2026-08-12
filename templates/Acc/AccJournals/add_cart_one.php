<?php
//$session
// session_start(); //start session
// include_once("config.inc.php"); //include config file
//setlocale(LC_MONETARY,"en_US"); // US national format (see : http://php.net/money_format)
############# add products to session #########################

//pr($_POST);
//pr($condData);

if($condData=='view') {	
	//if(!empty($dataSessionCart)) {
	//$dataAccounts = $this->Krs->_getValueCOA($data['rowAccount']);
	//pr(Set::extract('/AccChartOfAccount[id=1384]', $data['rowAccount']));

	//pr($data['rowAccount']);

		$cartBox = '<thead>
		<tr>
			<th width="60">Hapus</th>
			<th width="350">Nama Perkiraan</th>
			<th>Uraian</th>
			<th width="120">Jumlah Debet</th>
			<th width="120">Jumlah Credit</th>
		</tr>
		</thead>
		<tbody>';

		//echo $cartBox;
	//	pr($dataSessionCart);
	if(!empty($dataSessionCart)) {
		//$dkArray = array("D"=>"Debit", "C"=>"Kredit");
		$cartDebetAmount = array();
		$cartCreditAmount = array();
		/*foreach ($dataSessionCart as $cartId => $dataCarts) {
			//$jsonDecode = json_decode(base64_decode(urldecode(base64_decode($jsonData))));
			$encodeCart = base64_decode(urldecode(base64_decode($dataCarts)));
			$decodeCart = json_decode($encodeCart, true);
			//pr($decodeCart);

			$decodeCarts = Set::combine($decodeCart, '{n}.name', '{n}.value');
			$dataCarts = array_splice($decodeCarts, 8);
			//$dataCarts = array_splice($decodeCarts, 10);
			//pr($dataCarts);
			$dataCart = array();
			foreach ($dataCarts as $keyCart => $valueCart) {
				//$keywords = substr(str_replace( array( ']' ), '', str_replace( array( '[' ), '.', $keyCart)), 10);
				$filterKeywordReplace1 = str_replace( array( '[' ), '.', $keyCart);
				$filterKeywordReplace2 = str_replace( array( ']' ), '', $filterKeywordReplace1);
				$keywords = substr($filterKeywordReplace2, 10);
				list($field, $number) = explode(".", $keywords);
				$dataCart[$cartId.$number]['noCart'] = $number;
				$dataCart[$cartId.$number]['idCart'] = $cartId;
				$dataCart[$cartId.$number][$field] = $valueCart;
				//$dataCart[$cartId][$number][$field] = $valueCart;
			}
		
		//pr($dataCart);

			//foreach ($dataCart as $cartKey => $cartValue) {
				//$cartBox = "";
			
			foreach ($dataCart as $cartValue) {
				$noCart = (isset($cartValue['noCart'])) ? $cartValue['noCart'] : "";
				$idCart = (isset($cartValue['idCart'])) ? $cartValue['idCart'] : "";
				$dcStatus = (isset($cartValue['dc_status'])) ? $cartValue['dc_status'] : "";
				$debetAmount = (isset($cartValue['debet_amount'])) ? $this->Krs->nominalToDecimal($cartValue['debet_amount']) : "";
				$creditAmount = (isset($cartValue['credit_amount'])) ? $this->Krs->nominalToDecimal($cartValue['credit_amount']) : "";
				//$dcStatus = (isset($cartValue['dc_status'])) ? $cartValue['dc_status'] : "";
				$ledgerId = (isset($cartValue['ledger_id'])) ? $cartValue['ledger_id'] : "";
					
				if(isset($ledgerId)) {
					//pr($ledgerId);

					list($dcLedger, $subDC) = explode("^", $ledgerId);
					pr($dcLedger);

					foreach ($data['rowAccount'] as $coaKey => $coaValue) {
						//pr($coaValue);

						$AccCOA = $coaValue['AccChartOfAccount'];
						
						if($AccCOA['id']==$dcLedger) {
							if(empty($AccCOA['name'])) {
								if(empty($coaValue['Customer'])) {
									$AccCustomer =  $coaValue['Customer'];					
									$nameCOA = $AccCustomer['title'].' '.$AccCustomer['name'];
								} else {
									$nameCOA = "";
								}
								
							} else {
								$nameCOA = $AccCOA['name'];
							}
							//pr($nameCOA);
							$coaName = '('.$AccCOA['code'].') '.$nameCOA;
						}
					}
				} else {
					$coaName = '';
				}

				$cartBox .= '<tr>';
				$cartBox .= '<td align="center">';
				if($noCart==0) {
					$cartBox .= '<button class="btn btn-danger m-r-10" type="button" data-code="'.$idCart.'" id="removeCart"><i class="fas fa-trash-alt"></i></button>';
				} else {
					$cartBox .= "";
				}
				$cartBox .= '</td>';
				//$cartBox .= '<td align="center">';
				//$cartBox .= $dkArray[$dcStatus].'</td>';
				$cartBox .= '<td align="left">'.$coaName.'</td>';
				$cartBox .= '<td align="left">'.$cartValue['desc'].'</td>';
				$cartBox .= '<td align="right">'.$this->Krs->__currency($debetAmount).'</td>';
				$cartBox .= '<td align="right">'.$this->Krs->__currency($creditAmount).'</td>';
				$cartBox .= '</tr>';
				$cartDebetAmount[] = $debetAmount;
				$cartCreditAmount[] = $creditAmount;
			}
		}*/

		// pr($dataJurnal);
		foreach ($dataJurnal as $idCart => $coaData) {
			$debetAmount = $coaData['debetAmount'];
			$creditAmount = $coaData['creditAmount'];
			$noCart = $coaData['noCart'];

			$cartBox .= '<tr>';
			$cartBox .= '<td align="center">';
			if($noCart==0) {
				$cartBox .= '<button class="btn btn-danger m-r-10" type="button" data-code="'.$idCart.'" id="removeCart"><i class="fas fa-trash-alt"></i></button>';
			} else {
				$cartBox .= "";
			}
			$cartBox .= '</td>';
			//$cartBox .= '<td align="center">';
			//$cartBox .= $dkArray[$dcStatus].'</td>';
			$cartBox .= '<td align="left">'.$coaData['coaName'].'</td>';
			$cartBox .= '<td align="left">'.$coaData['coaDesc'].'</td>';
			$cartBox .= '<td align="right">'.$this->Krs->__currency($debetAmount).'</td>';
			$cartBox .= '<td align="right">'.$this->Krs->__currency($creditAmount).'</td>';
			$cartBox .= '</tr>';
			$cartDebetAmount[] = $debetAmount;
			$cartCreditAmount[] = $creditAmount;
		}

		//		pr($cartBox);
			//}
		$totalDebetAccount = round(array_sum($cartDebetAmount),2);
		$totalCreditAccount = round(array_sum($cartCreditAmount),2);
		// $cartBox .= '
		// <tr class="success">
		// 	<td colspan="4" align="right"><b>TOTAL</b></td>
		// 	<td><b>'.$this->Krs->__currency($totalDebetAccount).'</b></td>
		// 	<td><b>'.$this->Krs->__currency($totalCreditAccount).'</b></td>
		// </tr>';
			
		
	} else {
		$totalDebetAccount = 0;
		$totalCreditAccount = 0;
		$cartBox .= '<tr><td colspan="6"><i>Data tidak ditemukan..</i></td></tr>';
	}
	
	/*
	$("table tr #grandTotalDebet").css("background-color", "#80FD99");
	$("table tr #grandTotalCredit").css("background-color", "#80FD99");
	*/
	if($totalDebetAccount==$totalCreditAccount) {
		$classTotal = "success";
	} else {
		$classTotal = "danger";
	}
	$selisihTotal = $totalDebetAccount-$totalCreditAccount;
	//pr($totalDebetAccount.' - '.$totalCreditAccount);

	$cartBox .= '
		<tr class="'.$classTotal.'">
			<td colspan="3" align="right"><b>TOTAL</b></td>
			<td id="grandTotalDebet" align="right"><b>'.$this->Krs->__currency($totalDebetAccount).'</b></td>
			<td id="grandTotalCredit" align="right"><b>'.$this->Krs->__currency($totalCreditAccount).'</b></td>
		</tr>
		<tr class="warning">
			<td colspan="3" align="right"><b>SELISIH</b></td>
			<td align="center" colspan="2" id="grandTotalSelisih"><b>'.$this->Krs->__currency($selisihTotal).'</b></td>
		</tr>';
	$cartBox .= '</tbody>';
	echo $cartBox;
	

} else {
	echo json_encode($dataSessionCart);
}

?>