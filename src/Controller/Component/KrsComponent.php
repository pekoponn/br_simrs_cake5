<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry; //Memanggil table model

class KrsComponent extends Component
{	
    // Add your code to override the core AuthComponent
	public function _unit($value=null){
		$data = array('pcs'=>'Pcs', 'ton'=>'Ton', 'drum'=>'Drum', 'm3'=>'M3', 'kg'=>'Kg', 'liter'=>'Liter', 'truk'=>'Truk', 'hari'=>'Hari', 'lumpsum'=>'Lumpsum', '1 bulan'=>'1 Bulan', '2 bulan'=>'2 Bulan', '3 bulan'=>'3 Bulan', '4 bulan'=>'4 Bulan', 'bulan'=>'Bulan', 'tahun'=>'Tahun');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}
	
	public function uploadXls($_filename, $_usingdate, $_fields, &$strConfirmUpload){
		$testAgainstFormats = [
		    \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS,
		    \PhpOffice\PhpSpreadsheet\IOFactory::READER_HTML,
		];

		/** Load $inputFileName to a Spreadsheet Object  **/
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName, 0, $testAgainstFormats);
	}

	public function auditLog($table=null, $id=null, $userId=null, $key=null) {
		if(empty($id) || $id == null || $id=='N') {
		 	$dataOld = array();
		} else {
			$model = \Cake\ORM\TableRegistry::getTableLocator()->get($table);
						
			$dataRows = $model->find('all', conditions: ['id' => $id])->first();

			$dataOlds = (isset($dataRows->is_log)) ? $dataRows->is_log : '';
			$dataOld = (empty($dataOlds)) ? array():json_decode($dataOlds, true);		
		}

		$dateNow = $this->dateNow();
		
		$dataCount = (!empty($dataOld)) ? count($dataOld)+1 : 0;
		
		$dataNews = array($dataCount=>array("page"=>$table, "user_id"=>$userId, "key"=>$key, "date"=>$dateNow));
		
		$result = (empty($dataOld)) ? $dataNews[0] : array_merge_recursive($dataOld, $dataNews);
		
	    return json_encode($result);
	} 

	// Memisahkan kondisi pada rule
	public function _rule($data=null)
	{
		$dataRule = explode(';', $data);
        $result = array();
        if(count($dataRule)>1) {
        	foreach ($dataRule as $idRule => $valRule) {
				$dataAction = explode('=', $valRule);
				$controlRule = array($dataAction[0] => $dataAction[1]);
				$_act = array();
				foreach ($controlRule as $keyControlRule => $valControlRule) {
					$getAction = explode(',', $valControlRule);
					foreach ($getAction as $key => $act) {
						$splitAct = explode(':', $act);
						$_act[$splitAct[0]] = $splitAct[1];
					}
					$result[$dataAction[0]] = $_act;
				}
			}
		} else {
			$result = array();
		}
		return $result;
	}

	// Membuat kondisi pada rule
	public function createRule($data=null)
	{
		$rules  =array();
        foreach($data as $_rule => $_action){
            $actions = array();
            foreach($_action as $_actions => $action){
                $actions[] = $_actions.':'.$action;
            }
            $rules[] = $_rule.'='.implode(',', $actions);
        }
        $result = implode(';', $rules);
        return $result;
	}
   
	public function titleCustomer($data=null){
		$view = array('PT'=>'PT', 'CV' => 'CV', 'UD' => 'UD', 'INSTALASI FARMASI'=>'INSTALASI FARMASI', 'DINAS KESEHATAN'=>'DINAS KESEHATAN', 'PMI' => 'PMI', 'BIDAN' => 'BIDAN', 'RS' => 'RS', 'RSI' => 'RSI', 'RSIA' => 'RSIA', 'RSAD'=>'RSAD', 'RSAL'=>'RSAL', 'RSAU'=>'RSAU', 'RSB'=>'RSB', 'RSGM'=>'RSGM', 'RSJ'=>'RSJ', 'RSK'=>'RSK', 'RSKB'=>'RSKB', 'RSKM'=>'RSKM', 'RSM'=>'RSM', 'RSNU'=>'RSNU', 'RSPM'=>'RSPM', 'RSUH'=>'RSUH', 'RSUI'=>'RSUI', 'RSUM'=>'RSUM', 'RSUP'=>'RSUP', 'PRAKTEK DRG'=>'PRAKTEK DRG', 'PRAKTEK DR'=>'PRAKTEK DR', 'POLIKLINIK'=>'POLIKLINIK', 'PKM' => 'PKM', 'PG' => 'PG', 'KLINIK' => 'KLINIK', 'HOTEL' => 'HOTEL', 'DR' => 'DR', 'RSUD'=>'RSUD', 'RSU'=>'RSU', 'UPT'=>'UPT', 'UPTD'=>'UPTD', 'PLTU'=>'PLTU', 'UTD'=>'UTD', 'PUSKESMAS'=>'PUSKESMAS', 'YAYASAN'=>'YAYASAN', 'RESORT'=>'RESORT', 'VILLA'=>'VILLA', 'BENGKEL'=>'BENGKEL', 'SALON'=>'SALON', 'PEMERINTAH'=>'PEMERINTAH', 'APOTEK'=>'APOTEK', 'PERAWAT'=>'PERAWAT');
	
		$result = (empty($data)) ? $view : $view[$data];
		return $result;

	}

	public function fDate($value='', $format='')
    {
    	$result = (empty($value) && empty($format)) ? '' : date_format(date_create($value), $format);
    	return $result;
    }
	
	public function fEncode($data) {
		return $this->base64_encode(serialize($data));
	}

	public function fDecode($data) {
		return unserialize($this->base64_decode($data));
	}

	public function base64_encode($input) {
		return strtr(base64_encode($input), '+/=', '-_~');
	}

	public function base64_decode($input) {
		return base64_decode(strtr($input, '-_~', '+/='));
	}

	public function dataSelectGroup($data=null){
		$result = array();
		foreach ($data as $level1) {
			if($level1->level==1) {
				foreach ($data as $level2) {
					if($level2->level==2 && ($level2->parent_id==$level1->id)) {
						$result[$level1->name][$level2->id] = $level2->name;
					}
				}
			}
		}
		// pr($result);
		return $result;
	}

	public function cur($value=null){
		$values = (empty($value))?0:$value;
		if($values<0) {
			$result = str_replace('-','',$values);
			$view = '('.number_format((float)$result, 2, ',', '.').')';
		} elseif($values==0) {
			$view = 0;
		} else {
			$view = number_format((float)$values, 2, ',', '.');
		}
		
		return $view;
	}
	
	public function qty($value=null){
		$values = (empty($value))?0:$value;
		$view = ($values==0) ? 0 : number_format((float)$values, 0, ',', '.');
		return $view;
	}
	
	public function nom2Dec($number) {
		if(empty($number))
		{
			$number = 0;
		} 
		else
		{
			$number = str_replace(".", "", $number);
			$number = str_replace(",", ".", $number);
		}
		return $number;
	}

	public function dateTo($date, $time=null){
		$day = substr($date, 0, 2);
		$month = substr($date, 3, 2);
		$year = substr($date, 6, 4);
		$times = substr($date, 11);
	
		if($date==''){
			$result = '';
		} else {
			if(empty($time)) {
				$result = $year.'-'.$month.'-'.$day;
			} elseif($time=='Y') {
				$result = $year.'-'.$month.'-'.$day.' '.$times;
			} elseif($time=='A') {
				$result = substr($year, -2).$month.$day;
			} else {
				$result = $year.'-'.$month.'-'.$day.' '.$times;
			}
			
		}
		
		return $result;
	}
	
	public function dateNow(){
		$result = date("Y-m-d H:i:s");
		return $result;
	}

	public function noOfRome($month){
		$hasil = "";

		$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
		60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
		800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
		if(array_key_exists($month,$iromawi)){
		$hasil = $iromawi[$month];
		}elseif($month >= 11 && $month <= 99){
		$i = $month % 10;
		$hasil = $iromawi[$month-$i] . $this->noOfRome($month % 10);
		}elseif($month >= 101 && $month <= 999){
		$i = $month % 100;
		$hasil = $iromawi[$month-$i] . $this->noOfRome($month % 100);
		}else{
		$i = $month % 1000;
		$hasil = $iromawi[$month-$i] . $this->noOfRome($month % 1000);
		}
		return $hasil;
	}

	public function nom($value=null){
		$values = (empty($value))?0:$value;
		$view = ($values==0) ? 0 : number_format((float)$values, 2, ',', '.');
		return $view;
	}

	public  function truncate($value){
		$view = (!empty($value)) ? substr(str_pad($value,5),0,5).'...' : "...";
		return $view;
	}

	public function generateRandomString($length = 10) {
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;        
	}

	public function regex($value=null)
	{
		$result = preg_replace('/[^a-zA-Z0-9 ]/', '', $value);
		return $result;
	}

	function getTimezoneUser($zona = 'WIB')
	{
		switch ($zona) {
			case 'WITA':
				return 'Asia/Makassar';
			case 'WIT':
				return 'Asia/Jayapura';
			default:
				return 'Asia/Jakarta';
		}
	}
	public function workingHours($data = null)
	{
		$view = [
			'1' => '07.00 - 15.00 (Sabtu 07.00 - 12.00)',
			'2' => '08.00 - 16.00 (Sabtu 08.00 - 13.00)',
			'3' => '09.00 - 17.00 (Sabtu 09.00 - 14.00)',
		];
		return (empty($data)) ? $view : ($view[$data] ?? null);
	}

	/**
	 * Jam masuk & pulang per tipe. Tipe kosong/tidak valid -> tipe 2 (08.00).
	 */
	public function workingHoursSchedule($type = null, bool $isSaturday = false): array
	{
		$weekday = [
			1 => ['in' => '07:00:00', 'out' => '15:00:00'],
			2 => ['in' => '08:00:00', 'out' => '16:00:00'],
			3 => ['in' => '09:00:00', 'out' => '17:00:00'],
		];
		$saturday = [
			1 => ['in' => '07:00:00', 'out' => '12:00:00'],
			2 => ['in' => '08:00:00', 'out' => '13:00:00'],
			3 => ['in' => '09:00:00', 'out' => '14:00:00'],
		];
		$list = $isSaturday ? $saturday : $weekday;
		return $list[(int)$type] ?? $list[2];
	}
}
