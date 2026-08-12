<?php
use Cake\Utility\Hash;

//$session
// session_start(); //start session
// include_once("config.inc.php"); //include config file
//setlocale(LC_MONETARY,"en_US"); // US national format (see : http://php.net/money_format)
############# add products to session #########################

//pr($_POST);
// pr($condData);
// pr($data);
if($condData=='view') {	
	// pr($data);
	//if(!empty($dataSessionCart)) {
	//$dataAccounts = $this->Krs->_getValueCOA($data['rowAccount']);
	//pr(Set::extract('/AccChartOfAccount[id=1384]', $data['rowAccount']));

	//pr($data['rowAccount']);

		$cartBox = '<thead>
		<tr class="table-info">
			<th width="60">Hapus</th>
			<th width="60">D/K</th>
			<th width="350">Nama Perkiraan</th>
			<th>Uraian</th>
			<th width="60">Jumlah Debet</th>
			<th width="60">Jumlah Credit</th>
		</tr>
		</thead>
		<tbody>';

		//echo $cartBox;
	// pr($dataSessionCart);
	if(!empty($dataSessionCart)) {
		// pr($data);
		$dkArray = array("D"=>"Debit", "C"=>"Kredit");
		$cartDebetAmount = array();
		$cartCreditAmount = array();
		foreach ($dataSessionCart as $cartId => $dataCarts) {
			//$jsonDecode = json_decode(base64_decode(urldecode(base64_decode($jsonData))));
			$encodeCart = base64_decode(urldecode(base64_decode($dataCarts)));
			$decodeCart = json_decode($encodeCart, true);
			// pr($decodeCart);

			$decodeCarts = Hash::combine($decodeCart, '{n}.name', '{n}.value');
			$dataCarts = array_splice($decodeCarts, 8);
			//$dataCarts = array_splice($decodeCarts, 10);
			// pr($dataCarts);
			$dataCart = array();
			foreach ($dataCarts as $keyCart => $valueCart) {
				//$keywords = substr(str_replace( array( ']' ), '', str_replace( array( '[' ), '.', $keyCart)), 10);
				$filterKeywordReplace1 = str_replace( array( '[' ), '.', $keyCart);
				$filterKeywordReplace2 = str_replace( array( ']' ), '', $filterKeywordReplace1);
				// sementara ga dipake @office michael 220617 $keywords = substr($filterKeywordReplace2, 10);
				// pr($filterKeywordReplace2);
				list($nameCart, $field, $number) = explode(".", $filterKeywordReplace2);


				// list($field, $number) = explode(".", $keywords);
				$dataCart[$cartId.$number]['noCart'] = $number;
				$dataCart[$cartId.$number]['idCart'] = $cartId;
				$dataCart[$cartId.$number][$field] = $valueCart;
				//$dataCart[$cartId][$number][$field] = $valueCart;
			}
		
		// pr($dataCart);

			//foreach ($dataCart as $cartKey => $cartValue) {
				//$cartBox = "";
			
			foreach ($dataCart as $cartValue) {
				$noCart = (isset($cartValue['noCart'])) ? $cartValue['noCart'] : "";
				$idCart = (isset($cartValue['idCart'])) ? $cartValue['idCart'] : "";
				$dcStatus = (isset($cartValue['dc_status'])) ? $cartValue['dc_status'] : "";
				// $debetAmount = (isset($cartValue['debet_amount'])) ? $cartValue['debet_amount'] : "";
				// $creditAmount = (isset($cartValue['credit_amount'])) ? $cartValue['credit_amount'] : "";
				$debetAmount = (isset($cartValue['debet_amount'])) ? $this->Krs->nom2Dec($cartValue['debet_amount']) : "";
				$creditAmount = (isset($cartValue['credit_amount'])) ? $this->Krs->nom2Dec($cartValue['credit_amount']) : "";
				//$dcStatus = (isset($cartValue['dc_status'])) ? $cartValue['dc_status'] : "";
				$ledgerId = (isset($cartValue['ledger_id'])) ? $cartValue['ledger_id'] : "";
				// pr($cartValue);
				if(!empty($ledgerId)) {
					// pr($ledgerId);

					//9^1.01.1.01.0001^1^^neraca^(1.01.1.01.0001) Kas Surabaya
					list($coaId, $coaCode, $coaHeaderCode, $coaSubHeaderCode, $coaGroup, $coaName) = explode("^", $ledgerId);

					// if(!empty($ledgerId)) {
					//	list($dcLedger, $subDC) = explode("^", $ledgerId);

					// } else {
					// 	$dcLedger = "";
					// 	$subDC = "";
					// }
						// $dataAccount = $data['rowAccount'];
						// pr($dataAccount);
						// pr($dataAccount->getAttribute());
					/*sementara ga pake ini terlalu lama nantinya
					@office 220617
					foreach ($data['rowAccount'] as $coaKey => $coaValue) {
						$AccCOA = $coaValue['AccChartOfAccount'];
						
						if($AccCOA['id']==$dcLedger) {
							if(empty($AccCOA['name'])) {
								//$AccCustomer = $coaValue['Customer'];					
								$nameCOA = $AccCOA['customer_name'];
								//$nameCOA = $AccCustomer['title'].' '.$AccCustomer['name'];
							} else {
								$nameCOA = $AccCOA['name'];
							}
							//pr($nameCOA);
							$coaName = '('.$AccCOA['code'].') '.$nameCOA;
						}
					}*/
				} else {
					$coaName = '';
				}

				// pr($cartValue);
				$showDCStatus = (empty($dcStatus)) ? '' : $dkArray[$dcStatus];
				$showDesc = (empty($cartValue['desc'])) ? '' : $cartValue['desc'];

				$cartBox .= '<tr>';
				$cartBox .= '<td align="center">';
				if($noCart==0) {
					$cartBox .= '<button class="btn btn-danger m-r-10" type="button" data-code="'.$idCart.'" id="removeCart"><i class="fas fa-trash-alt"></i></button>';
				} else {
					$cartBox .= "";
				}
				$cartBox .= '</td>';
				$cartBox .= '<td align="center">';
				//$cartBox .=  $this->Form->input('dataCart', array('type' => 'hidden', 'value' => $data['branchId'][0]));
				$cartBox .= $showDCStatus.'</td>';
				$cartBox .= '<td align="left">'.$coaName.'</td>';
				$cartBox .= '<td align="left">'.$showDesc.'</td>';
				$cartBox .= '<td align="right">'.$this->Krs->nom($debetAmount).'</td>';
				$cartBox .= '<td align="right">'.$this->Krs->nom($creditAmount).'</td>';
				$cartBox .= '</tr>';
				$cartDebetAmount[] = $debetAmount;
				$cartCreditAmount[] = $creditAmount;
			}
		}
		//		pr($cartBox);
			//}
		$totalDebetAccount = round(array_sum($cartDebetAmount),2);
		$totalCreditAccount = round(array_sum($cartCreditAmount),2);
		$cartBox .= '
		<tr class="success">
			<td colspan="4" align="right"><b>TOTAL</b></td>
			<td><b>'.$this->Krs->cur($totalDebetAccount).'</b></td>
			<td><b>'.$this->Krs->cur($totalCreditAccount).'</b></td>
		</tr>';
			
		
	} else {
		// $cartBox .= '<tr class="table-danger"><td colspan="6" align="center"><h5><i>Maaf, Data tidak ditemukan..</i></h5></td></tr>';
		$cartBox .= '<tr><td colspan="6" align="center">'.$this->Krs->emptyData().'</td></tr>';

	}
		//<a href="" id="removeCart" data-code="'.$orderId.'"><i class="fa fa-times"></i></a>
		$cartBox .= '</tbody>';
		echo $cartBox;
	// 	echo json_encode($dataSessionCart);
	// } else {
	// 	echo json_encode($dataSessionCart);
	// }
	// die($cartBox);
// } elseif($condData=='delete') {	

} else {
	echo json_encode($dataSessionCart);
}
// pr($dataSessionCart);
// echo json_encode($dataSessionCart);
?>