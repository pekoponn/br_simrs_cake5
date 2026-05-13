<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\I18n\Number;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

class KrsHelper extends Helper
{
    public $helpers = ['Html', 'Paginator', 'Form'];

    //Klinik
	public $company = 'Portal';
	public $titleLogin = 'Sistem Informasi Bhakti Rahayu Group';
	public $titleDesc = 'SiP (Sistem Informasi Bhakti Rahayu Group)&nbsp;&ouml;&ouml;&ouml;&nbsp;--&nbsp;';
	public $footer = 'SIBR-Group&#8482; v.2 &copy; 2024&#126;';
	public $titleManifest = 'AAH';
	public $codeMOU = 'PKS/TMI/DPS';
	public $invoiceCode = 'TMI-DPS';
	public $companyName = "PT. Bhakti Rahayu Group";
	public $bankAn = "PT. Bhakti Rahayu Group";
	public $bankName = "Bank Mandiri";
	public $bankBranch = "KCP Pahlawan Surabaya - Jawa Timur";
	public $cityInvoice = "Surabaya";
	public $loginBg = "login-bg.jpg";
	public $nettoPrice = "N";
	public $signInvoice = 1;

	public function footer(){
    	$result = $this->footer.date("Y");

	 	return $result;
	}

    public function btn($type=null, $btnLink=null, $btnId =null) {
    	if($type=="add") {
			$btnAttribute = ['name'=>'<i class="fa fa-plus"></i>', 'color'=>'inverse', 'title'=>'Baru'];
		} elseif($type=="preview") {
			$btnAttribute = ['name'=>'<i class="fa fa-desktop"></i>', 'color'=>'yellow', 'title'=>'Tampilkan'];
		} elseif($type=="edit") {
			$btnAttribute = ['name'=>'<i class="fa fa-pencil-alt"></i>', 'color'=>'info', 'title'=>'Ubah'];
		} elseif($type=="edit_admin") {
			$btnAttribute = ['name'=>'<i class="fa fa-pencil-alt"></i>', 'color'=>'indigo', 'title'=>'Ubah--'];
		} elseif($type=="delete") {
			$btnAttribute = ['name'=>'<i class="fa fa-trash-alt"></i>', 'color'=>'danger', 'title'=>'Hapus'];
		} elseif($type=="cancel") {
			$btnAttribute = ['name'=>'<i class="fa fa-ban"></i>', 'color'=>'lime', 'title'=>'Batal'];
		} elseif($type=="download") {
			$btnAttribute = ['name'=>'<i class="fa fa-download"></i>', 'color'=>'primary', 'title'=>'Unduh'];
		} elseif($type=="print") {
			$btnAttribute = ['name'=>'<i class="fa fa-print"></i>', 'color'=>'lime', 'title'=>'Cetak'];
		} elseif($type=="payment") {
			$btnAttribute = ['name'=>'<i class="fa fa-dollar-sign"></i>', 'color'=>'purple', 'title'=>'Pembayaran'];
		} elseif($type=="access") {
			$btnAttribute = ['name'=>'<i class="fa fa-sitemap"></i>', 'color'=>'purple', 'title'=>'Hak Akses'];
		} elseif($type=="resetPassword") {
			$btnAttribute = ['name'=>'<i class="fa fa-unlock-alt"></i>', 'color'=>'lime', 'title'=>'Reset Password'];
		} elseif ($type == "addFace") {
			$btnAttribute = ['name' => '<i class="fa fa-camera"></i>', 'color' => 'pink', 'title' => 'Tambah Wajah'];
		}
		
		if($type=="delete") {
			$view = $this->Form->postLink($btnAttribute['name'], $btnLink, ['confirm' => __('Apakah anda ingin menghapus data tersebut # {0}?', $btnId), 'class'=>'btn btn-'.$btnAttribute['color'].' btn-sm m-r-5 p-l-15 p-r-15', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>$btnAttribute['title'], 'escape' => false, 'fullBase'=>true]);
		} elseif($type=='preview') {
			$btnLink = "javascript:void(0)";
            $view = $this->Html->link($btnAttribute['name'], $btnLink, ['class'=>'btn btn-'.$btnAttribute['color'].' btn-sm btn-preview m-r-5 p-l-15 p-r-15', 'data-id'=>$btnId, 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>$btnAttribute['title'], 'id'=>'btn-preview'.$btnId, 'escape' => false, 'fullBase'=>true]);
		} else {
			$view = $this->Html->link($btnAttribute['name'], $btnLink, ['class'=>'btn btn-'.$btnAttribute['color'].' btn-sm m-r-5 p-l-15 p-r-15', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>$btnAttribute['title'], 'escape' => false, 'fullBase'=>true]);
		}

		return $view;
	}

	public function breadcrumb($dataParent=null, $dataChild=null, $dataGrandChild=null) {
		$view ='<ol class="breadcrumb float-xl-right">';
		if(!empty($dataChild)) {
			$view .= (isset($dataParent)) ? '<li class="breadcrumb-item">'.$dataParent.'</li>':'';
		}
		if(!empty($dataChild)) {
			$view .= (isset($dataChild)) ? '<li class="breadcrumb-item">'.$dataChild.'</li>' : '<li class="breadcrumb-item active">'.$dataChild.'</li>';
		}
		if(!empty($dataGrandChild)) {
			$view .= (isset($dataGrandChild)) ? '<li class="breadcrumb-item active">'.$dataGrandChild.'</li>' : '';
		}
			$view .= '</ol>';
			$view .= '<h1 class="page-header">'.trim(strip_tags($dataChild)).' <small>kumpulan beberapa data...</small></h1>';

		return $view;
	}

	// Mata Uang
	public  function _currency($value)
	{
		return Number::format($value, ['places' => 0, 'locale' => 'id_ID']);
	}

	public  function truncate($value){
		$view = (!empty($value)) ? substr(str_pad($value,5),0,5).'...' : "...";
		return $view;
	}

	public function _packing($value=null){
		$data = array('Drum logam (MD)' => 'Drum logam (MD)', 'Drum plastik (FC)' => 'Drum plastik (FC)', 'Jumbo Bag (JB)' => 'Jumbo Bag (JB)', 'Wheel Bin (WB)' => 'MD', 'Jerygan (JC)' => 'Jerygan (JC)',  'Karung Plastik (BA)' => 'Karung Plastik (BA)', 'Kemasan Karton atau plastik (FC)' => 'Kemasan Karton atau plastik (FC)');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function devision(){
		$view = array('KEU'=>'Accounting', 'WWH' => 'Gudang', 'HSE' => 'HSE', 'MKT'=>'Marketing', 'TRS'=>'Transport', 'GA'=>'HRD & GA', 'IT'=>'IT', 'FNC'=>'Finance');
		return $view;
	}

	public function position($data=null){
		$view = array('Admin'=>'Admin', 'Staff' => 'Staff', 'Supervisor' => 'Supervisor', 'Manager' => 'Manager', 'Direktur' => 'Direktur');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function warehouse($value=null){
		$data = array('DENPASAR'=>'DENPASAR', 'GIANYAR'=>'GIANYAR', 'BULELENG'=>'BULELENG');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function nom($value=null){
		$values = (empty($value))?0:$value;
		$view = ($values==0) ? 0 : number_format((float)$values, 2, ',', '.');
		return $view;
	}

	public function qty($value=null){
		$values = (empty($value))?0:$value;
		$view = ($values==0) ? 0 : number_format((float)$values, 0, ',', '.');
		return $view;
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

	
	public function percent($data=null) {
		$result = (empty($data)) ? 0 : str_replace(",000", "", (string)number_format($data, 3, ",", ""));
		
		return $result;
	}

	public function emptyData($value='')
	{
		
		$value = (empty($value)) ? 'Data tidak ditemukan' : $value;
		$result = '<div class="table-responsive">
		<table class="table table-td-valign-middle">
		<tbody>
		<tr style="text-align: center;">
		<td>
		<br>
		<br>
		<i class="fa fa-chalkboard" style="font-size:48px; color: rgb(29, 34, 38, 0.1);"> '.$value.'</i>
		<br>
		<br>
		</td>
		</tr>                      
		</tbody>
		</table>
		</div>';
		return $result;
	}

	public function paginators(){
		$view = '<div class="result-container">
				<div class="pull-left m-t-3 m-b-20">';
       	$view .= $this->Paginator->counter('Halaman {{page}} sampai {{pages}}, mulai baris ke {{start}} sampai dengan baris ke {{end}} <br />Menampilkan {{current}} baris dengan jumlah total {{count}} baris');
		$view .= '</div>';
		$view .= '<div class="pull-right m-t-3 m-b-20">';
		$view .= '<div>
                <ul class="pagination m-t-0 m-b-5">';
        	$view .= $this->Paginator->first('&laquo;', ['escape' => false]);
			$view .= $this->Paginator->numbers(['first' => 0, 'last' => 0, 'ellipsis' => '<li><a  class="page-link">...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus'=>4, 'class'=>'page-item']);
			$view .= $this->Paginator->last('&raquo;', ['escape' => false]);
		$view .= '</ul></div></div></div>';

		return $view;
	}

	public function titleCustomer($data=null){
		$view = array('PT'=>'PT', 'CV' => 'CV', 'UD' => 'UD', 'INSTALASI FARMASI'=>'INSTALASI FARMASI', 'DINAS KESEHATAN'=>'DINAS KESEHATAN', 'PMI' => 'PMI', 'BIDAN' => 'BIDAN', 'RS' => 'RS', 'RSI' => 'RSI', 'RSIA' => 'RSIA', 'RSAD'=>'RSAD', 'RSAL'=>'RSAL', 'RSAU'=>'RSAU', 'RSB'=>'RSB', 'RSGM'=>'RSGM', 'RSJ'=>'RSJ', 'RSK'=>'RSK', 'RSKB'=>'RSKB', 'RSKM'=>'RSKM', 'RSM'=>'RSM', 'RSNU'=>'RSNU', 'RSPM'=>'RSPM', 'RSUH'=>'RSUH', 'RSUI'=>'RSUI', 'RSUM'=>'RSUM', 'RSUP'=>'RSUP', 'PRAKTEK DRG'=>'PRAKTEK DRG', 'PRAKTEK DR'=>'PRAKTEK DR', 'POLIKLINIK'=>'POLIKLINIK', 'PKM' => 'PKM', 'PG' => 'PG', 'KLINIK' => 'KLINIK', 'HOTEL' => 'HOTEL', 'DR' => 'DR', 'RSUD'=>'RSUD', 'RSU'=>'RSU', 'UPT'=>'UPT', 'UPTD'=>'UPTD', 'PLTU'=>'PLTU', 'UTD'=>'UTD', 'PUSKESMAS'=>'PUSKESMAS', 'YAYASAN'=>'YAYASAN', 'RESORT'=>'RESORT', 'VILLA'=>'VILLA', 'BENGKEL'=>'BENGKEL', 'SALON'=>'SALON', 'PEMERINTAH'=>'PEMERINTAH', 'APOTEK'=>'APOTEK', 'PERAWAT'=>'PERAWAT');
	
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function projectStatus($data=null){
		$view = array("Bali"=>"Bali", "Surabaya"=>"Surabaya");
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function numToRome($month){
		$hasil = "";

		$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
		60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
		800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
		if(array_key_exists($month,$iromawi)){
		$hasil = $iromawi[$month];
		}elseif($month >= 11 && $month <= 99){
		$i = $month % 10;
		$hasil = $iromawi[$month-$i] . $this->numToRome($month % 10);
		}elseif($month >= 101 && $month <= 999){
		$i = $month % 100;
		$hasil = $iromawi[$month-$i] . $this->numToRome($month % 100);
		}else{
		$i = $month % 1000;
		$hasil = $iromawi[$month-$i] . $this->numToRome($month % 1000);
		}
		return $hasil;
	}

	public function generateRandomString($length = 10) {
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;        
	}

	public function postingStatus($data=null)
	{
		$view = array(""=>"Semua", "draft"=>"Draft", "posting"=>"Posting", "closing"=>"Closing");
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function inputDateRange($nameFrom, $arrayFrom=array(), $nameTo, $arrayTo=array(), $separator, $reset) {
		$input = '<div class="input-group input-daterange">';
		$input .= $this->Form->input($nameFrom, $arrayFrom);
		$input .= '<div class="input-group-prepend">';
	    $input .=   '<span class="input-group-text">'.$separator.'</span>';
	    $input .= '</div>';
	    $input .= $this->Form->input($nameTo, $arrayTo);
	    $input .= '<div class="input-group-append">';
	    $input .= '<button class="btn btn-inverse '.$reset.'" type="button"><i class="fa fa-times"></i></button>';
	    $input .= '</div></div>';

        return $input;
    }

    //________Tanggal Indonesia
    public function date_indo($date){
		$split = explode("-", $date);
	    $date = $split[2];
	    $month = $this->get_month($split[1]);
	    $year = $split[0];
	    $result = $date.' '.$month.' '.$year;

	    return $result;
	}

	public function get_month($bln){

		switch($bln){
			case 1:
				return "Januari";
			break;

			case 2:
				return "Februari";
			break;

			case 3:
				return "Maret";
			break;

			case 4:
				return "April";
			break;

			case 5:
				return "Mei";
			break;

			case 6:
				return "Juni";
			break;

			case 7:
				return "Juli";
			break;

			case 8:
				return "Agustus";
			break;

			case 9:
				return "September";
			break;

			case 10:
				return "Oktober";
			break;

			case 11:
				return "November";
			break;

			case 12:
				return "Desember";
			break;

		}

	}

	public function fDate($value = null, $formats = 'd-m-Y')
	{
		if (empty($value)) {
			return '';
		}

		// Jika sudah objek DateTimeInterface, langsung format
		if ($value instanceof \DateTimeInterface) {
			return $value->format($formats);
		}

		// Jika string, ubah dulu menjadi FrozenDate atau FrozenTime
		try {
			$dateObj = new FrozenTime($value); // atau FrozenDate jika hanya tanggal
			return $dateObj->format($formats);
		} catch (\Exception $e) {
			return ''; // fallback jika format tidak valid
		}
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

	public function dateIndo($date, $showAll=true){
		$split = explode("-", $date);
	    $date = $split[2];
	    $month = $this->getMonth($split[1]);
	    $year = $split[0];

	    if($showAll==true) {
	    	$result = $date.' '.$month.' '.$year;
		} else {
			$result = $month.' '.$year;
		}

	    return $result;
	}

	public function getMonth($bln){
		switch($bln){
			case 1:
				return "Januari";
			break;

			case 2:
				return "Februari";
			break;

			case 3:
				return "Maret";
			break;

			case 4:
				return "April";
			break;

			case 5:
				return "Mei";
			break;

			case 6:
				return "Juni";
			break;

			case 7:
				return "Juli";
			break;

			case 8:
				return "Agustus";
			break;

			case 9:
				return "September";
			break;

			case 10:
				return "Oktober";
			break;

			case 11:
				return "November";
			break;

			case 12:
				return "Desember";
			break;
		}
	}
	
    public function status($data = null)
    {
        $view = array('Y' => 'Aktif', 'N' => 'Non-Aktif');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

    public function btnSeach($value='')
	{
		$view = $this->Form->button('<i class="fas fa-search"></i>', array('class'=>'btn btn-warning width-60 m-r-10', 'type'=>'submit', 'id'=> 'btnSearch', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Cari"));

		return $view;
	}

	public function btnSave($title='Simpan')
	{
		$result = '<div class="panel-footer text-right bg-warning">'.$this->Form->button($title, ["class" => "btn btn-primary", "type" => "button", "escape" => false, "id" => "btn-add"]).'</div>';
		return $result;
	}

	public function dataNull($desc=null, $type='warning')
    {
   		$result = '<tr>
                    	<td colspan="20">
                        	<div class="note note-warning">
                                <div class="note-icon"><i class="fas fa-exclamation-circle"></i></div>
                                <div class="note-content">
                                	<h4><b>Maaf... data tidak ditemukan!</b></h4>
                            	    <p>Silakan masukkan data dengan benar...</p>
                                </div>
                            </div>
                        </td>
                    </tr>';
        return $result;
    }

    public function heading($title=null)
	{
		$result = '<div class="panel-heading">
	        <h4 class="panel-title">'.$title.'</h4>
	        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>    
	    </div>';
	    
		return $result;
	}
	
	public function submission($data = null)
    {
        $view = array("Biaya SDM" => "Biaya SDM", "Biaya Marketing/Penjualan" => "Biaya Marketing/Penjualan", "Biaya Operasional" => "Biaya Operasional", "Pembelian Aset/Inventaris" => "Pembelian Aset/Inventaris", "Bayar Hutang Dagang" => "Bayar Hutang Dagang", "Bayar Kredit Bank" => "Bayar Kredit Bank", "Pindah Dana" => "Pindah Dana", "Kasbon" => "Kasbon", "Pety Cash" => "Pety Cash", "Hutang/Piutang Group" => "Hutang/Piutang Group");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }
	
	public function dataUbs($data = null)
    {
        $view = array("RS-TABANAN" => "RS-TABANAN", "RS-SURABAYA" => "RS-SURABAYA", "RS-AMBON" => "RS-AMBON");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function placement(){
		
		$view = array('BWC'=>'BWC', 'KARFA' => 'KARFA', 'PRATAMA' => 'PRATAMA', 'UNILAB' => 'UNILAB', 'WILWA' => 'WILWA', 'TRIATA' => 'TRIATA', 'ARTAMA BALI' => 'ARTAMA BALI', 'ARTAMA AMBON' => 'ARTAMA AMBON', 'BERSERI' => 'BERSERI', 'KOPERASI' => 'KOPERASI', 'CTBL' => 'CTBL', 'MENITINI' => 'MENITINI', 'DAMAR' => 'DAMAR', 'CMC' => 'CMC', 'BWA' => 'BWA', 'EINSTEINS' => 'EINSTEINS', 'RSB DPS' => 'RSB DPS', 'RSB SBY' => 'RSB SBY', 'RSB TNN' => 'RSB TNN', 'BHAKSENA' => 'BHAKSENA', 'KLINIK' => 'KLINIK', 'GUDANG' => 'GUDANG');

		return $view;
	}

	public function categoryAsset($data=null)
	{
		$view = array('ASSET'=>'ASSET', 'NON ASSET'=>'NON ASSET/INVENTARIS', 'SEWA'=>'SEWA');
		$result = (empty($data)) ? $view : $view[$data];
		
		return $result;
	}

	public function typeAsset($data=null)
	{
		$view = array('OBAT'=>'OBAT', 'ALKES'=>'ALKES', 'ALAT MEDIS'=>'ALAT MEDIS', 'PERLENGKAPAN'=>'PERLENGKAPAN', 'FURNITURE'=>'FURNITURE', 'KOMPUTER'=>'KOMPUTER', 'KENDARAAN'=>'KENDARAAN', 'BANGUNAN'=>'BANGUNAN', 'MESIN'=>'MESIN', 'OTHERS'=>'OTHERS');
		$result = (empty($data)) ? $view : $view[$data];
		
		return $result;
	}

	public function typeScm($data=null)
	{
		$view = array('OBAT'=>'OBAT', 'ALKES'=>'ALKES', 'ALAT MEDIS'=>'ALAT MEDIS');
		$result = (empty($data)) ? $view : $view[$data];
		
		return $result;
	}
	

	public function unitAsset($value=null){
		$data = array('ml'=>'ml', 'mg'=>'mg', 'pcs'=>'Pcs', 'botol'=>'Botol', 'box'=>'Box', 'tube'=>'Tube', 'roll'=>'Roll', 'unit'=>'Unit');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function fPayment($data=null)
	{
		$view = array('Y'=>'Lunas', 'N'=>'Blm Dibayar', 'NP'=>'Kurang Bayar');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function typeCost($value = null)
	{
		$data = array('Pengolahan Limbah' => 'Pengolahan Limbah', 'Transporter' => 'Transporter', 'Sewa' => 'Sewa', 'GPS' => 'GPS', 'Gas' => 'Gas', 'Perawatan dan Pemeliharaan' => 'Perawatan dan Pemeliharaan', 'Service' => 'Service', 'Pembelian' => 'Pembelian', 'Loading' => 'Loading', 'Lain-lain' => 'Lain-lain');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function statusPca($data = null)
    {
        $view = array('Y' => 'Setuju', 'W' => 'Tunggu', 'N' => 'Ditolak');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function fTextPlain($dataText) {
		$view ='<input type="text" readonly class="form-control-plaintext" value="'.$dataText.'" />';
		return $view;
	}

	public function regex($value=null)
	{
		$result = preg_replace('/[^a-zA-Z0-9 ]/', '', $value);
		return $result;
	}
}


?>