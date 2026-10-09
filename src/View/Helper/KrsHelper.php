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
	public $titleLogin = 'SIM-RS RS Bhakti Rahayu Surabaya ';
	public $titleDesc = 'SIM-RS (Sistem Informasi & Manajemen Rumah Sakit)';
	public $footer = 'SIBR-Group&#8482; v.2 &copy; 2026&#126;';
	public $titleManifest = 'AAH';
	public $codeMOU = 'PKS/TMI/DPS';
	public $invoiceCode = 'TMI-DPS';
	public $companyName = "PT. Bhakti Rahayu Group";
	public $bankAn = "PT. Bhakti Rahayu Group";
	public $bankName = "Bank Mandiri";
	public $bankBranch = "KCP Pahlawan Surabaya - Jawa Timur";
	public $cityInvoice = "Surabaya";
	public $waInvoice = "087701168290";
	//public $waInvoice = "087864429747";	
	//public $emailInvoice = "triatabali@gmail.com";
	public $emailInvoice = "triatamuliaindonesiabali2@gmail.com";
	public $headerManifestProcessor = "header-triata.jpg";
	public $footerManifestProcessor = "footer-triata.jpg";
	public $loginBg = "login-bg2.png";
	public $nettoPrice = "N";
	public $signInvoice = 1;

	//Artama Bali
	//public $company = 'ArtamaBali';
	//public $titleLogin = 'Sistem Informasi admin Artama';
	//public $titleManifest = 'ALL';
	//public $codeMOU = 'PKS/ARSI/AMQ';
	//public $invoiceCode = 'ARSI-DPS';
	//public $companyName = "PT. ARTAMA SENTOSA INDONESIA";
	//public $bankAn = "PT. Artama Sentosa Indonesia";
	//public $bankName = "Bank Mandiri";
	//public $bankBranch = "KCP Gatot Subroto Denpasar - Ambon";
	//public $cityInvoice = "Gresik";
	//public $waInvoice = "087864429747";
	//public $emailInvoice = "triatamuliaindonesiabali2@gmail.com";
	//public $headerManifestProcessor = "header-artama.jpg";
	//public $footerManifestProcessor = "footer-artama.jpg";
	//public $nettoPrice = "Y";
	//public $signInvoice = 1;

	//Artama
	//public $company = 'Artama';
	//public $titleLogin = 'Sistem Informasi admin Artama';
	//public $titleManifest = 'ALL';
	//public $codeMOU = 'PKS/ARSI/AMQ';
	//public $invoiceCode = 'ARSI-DPS';
	//public $companyName = "PT. ARTAMA SENTOSA INDONESIA";
	//public $bankAn = "PT. Artama Sentosa Indonesia";
	//public $bankName = "Bank Mandiri";
	//public $bankBranch = "KCP Gatot Subroto Denpasar - Ambon";
	//public $cityInvoice = "Gresik";
	//public $waInvoice = "087864429747";
	//public $emailInvoice = "triatamuliaindonesiabali2@gmail.com";
	//public $headerManifestProcessor = "header-artama.jpg";
	//public $footerManifestProcessor = "footer-artama.jpg";
	//public $nettoPrice = "Y";
	//public $signInvoice = 1;

	// BBB
	// public $company = 'BBB';
	// public $titleLogin = 'Sistem Informasi admin BBB';
	// public $titleManifest = 'BBB';
	// public $codeMOU = 'MOU/BBB/BDG';
	// public $invoiceCode = 'BBB-BDG';
	// public $companyName = "PT. Bumi Bali Berkarya";
	// public $bankAn = "PT. Bumi Bali Berkarya";
	// public $bankName = "Bank Mandiri";
	// public $bankBranch = "KCP Gatot Subroto Denpasar - Bali";
	// public $cityInvoice = "Denpasar";
	// public $waInvoice = "087701168290";
	// public $emailInvoice = "triatamuliaindonesiabali2@gmail.com";
	// public $headerManifestProcessor = "header-bbb.jpg";
	// public $footerManifestProcessor = "footer-bbb.jpg";
	// public $nettoPrice = "N";
	// public $signInvoice = 1;

	// Berseri
	// public $company = 'Berseri';
	// public $titleLogin = 'Sistem Informasi admin Berseri';
	// public $titleManifest = 'BBB2';
	// public $codeMOU = 'MOU/BBB2/DPS';
	// public $invoiceCode = 'BBB2-DPS';
	// public $companyName = "PT. Bhakti Bumi Berseri";
	// public $bankAn = "PT. Bhakti Bumi Berseri";
	// public $bankName = "Bank Mandiri";
	// public $bankBranch = "KCP Gatot Subroto Denpasar - Bali";
	// public $cityInvoice = "Denpasar";
	// public $waInvoice = "087701168290";
	// public $emailInvoice = "ptbhaktibumiberseri@gmail.com";
	// public $headerManifestProcessor = "header-berseri.jpg";
	// public $footerManifestProcessor = "footer-berseri.jpg";
	// public $nettoPrice = "N";
	// public $signInvoice = 2;

	/*public function makeEdit($title, $url)
	{
		// Use the HTML helper to output
		// Formatted data:

		$link = $this->Html->link($title, $url, ['class' => 'edit']);

		return '<div class="editOuter">' . $link . '</div>';
	}*/

	public function footer()
	{
		$result = $this->footer . date("Y");

		// $result = 'iIjjo&#8482; v.8 #kopitiadahenti &copy; 2020&#126;'.date("Y");
		return $result;
	}

	public function btn($type = null, $btnLink = null, $btnId = null)
	{
		//$view = '';
		if ($type == "add") {
			$btnAttribute = ['name' => '<i class="fa fa-plus"></i>', 'color' => 'inverse', 'title' => 'Baru'];
		} elseif ($type == "preview") {
			$btnAttribute = ['name' => '<i class="fa fa-desktop"></i>', 'color' => 'yellow', 'title' => 'Tampilkan'];
		} elseif ($type == "editCustome") {
			$btnAttribute = ['name' => '<i class="fa fa-pencil-alt"></i>', 'color' => 'purple', 'title' => 'Ubah'];
		} elseif ($type == "edit") {
			$btnAttribute = ['name' => '<i class="fa fa-pencil-alt"></i>', 'color' => 'info', 'title' => 'Ubah'];
		} elseif ($type == "edit_admin") {
			$btnAttribute = ['name' => '<i class="fa fa-pencil-alt"></i>', 'color' => 'indigo', 'title' => 'Ubah--'];
		} elseif ($type == "delete") {
			$btnAttribute = ['name' => '<i class="fa fa-trash-alt"></i>', 'color' => 'danger', 'title' => 'Hapus'];
		} elseif ($type == "cancel") {
			$btnAttribute = ['name' => '<i class="fa fa-ban"></i>', 'color' => 'lime', 'title' => 'Batal'];
		} elseif ($type == "download") {
			$btnAttribute = ['name' => '<i class="fa fa-download"></i>', 'color' => 'primary', 'title' => 'Unduh'];
		} elseif ($type == "print") {
			$btnAttribute = ['name' => '<i class="fa fa-print"></i>', 'color' => 'lime', 'title' => 'Cetak'];
		} elseif ($type == "payment") {
			$btnAttribute = ['name' => '<i class="fa fa-dollar-sign"></i>', 'color' => 'purple', 'title' => 'Pembayaran'];
		} elseif ($type == "access") {
			$btnAttribute = ['name' => '<i class="fa fa-sitemap"></i>', 'color' => 'purple', 'title' => 'Hak Akses'];
		} elseif ($type == "resetPassword") {
			$btnAttribute = ['name' => '<i class="fa fa-unlock-alt"></i>', 'color' => 'lime', 'title' => 'Reset Password'];
		} elseif ($type == "addFace") {
			$btnAttribute = ['name' => '<i class="fa fa-camera"></i>', 'color' => 'pink', 'title' => 'Tambah Wajah'];
		} elseif ($type == "approve") {
			$btnAttribute = ['name' => '<i class="fa fa-check"></i>', 'color' => 'success', 'title' => 'Menyetujui'];
		}  elseif ($type == "knowing") {
			$btnAttribute = ['name' => '<i class="fa fa-thumbs-up"></i>', 'color' => 'pink', 'title' => 'Mengetahui'];
		} elseif ($type == "resetPin") {
			$btnAttribute = ['name' => '<i class="fa fa-unlock-alt"></i>', 'color' => 'grey', 'title' => 'Reset Pin'];
		}

		if ($type == "delete") {
			$view = $this->Form->postLink($btnAttribute['name'], $btnLink, ['confirm' => __('Apakah anda ingin menghapus data tersebut # {0}?', $btnId), 'class' => 'btn btn-' . $btnAttribute['color'] . ' btn-sm m-r-5 p-l-15 p-r-15', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => $btnAttribute['title'], 'escape' => false, 'fullBase' => true]);
		} elseif ($type == 'preview') {

			$btnLink = "javascript:void(0)";

			$view = $this->Html->link(
				$btnAttribute['name'],
				$btnLink,
				[
					'class' => 'btn btn-' . $btnAttribute['color'] . ' btn-sm btn-preview m-r-5 p-l-15 p-r-15',
					'data-id' => $btnId,
					'data-toggle' => 'tooltip',
					'data-placement' => 'top',
					'data-original-title' => $btnAttribute['title'],
					'id' => 'btn-preview' . $btnId,
					'escape' => false,
					'fullBase' => true
				]
			);
		} else {
			$view = $this->Html->link($btnAttribute['name'], $btnLink, ['class' => 'btn btn-' . $btnAttribute['color'] . ' btn-sm m-r-5 p-l-15 p-r-15', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => $btnAttribute['title'], 'escape' => false, 'fullBase' => true]);
		}

		return $view;

		//$this->Form->button('<i class="fas fa-plus"></i> (BARU)', array('class'=>'btn btn-sm btn-inverse width-120 m-r-5 m-b-5', 'escape' => false));
	}

	// public function breadcrumb($dataParent = null, $dataChild = null, $dataGrandChild = null, $showBreadcrumb = false, $showTitle = false)
	// {
	// 	$view = '';
	// 	if ($showBreadcrumb) {
	// 		$view .= '<ol class="breadcrumb float-xl-right">';
	// 		if (!empty($dataChild)) {
	// 			$view .= (isset($dataParent)) ? '<li class="breadcrumb-item">' . $dataParent . '</li>' : '';
	// 		}
	// 		if (!empty($dataChild)) {
	// 			$view .= (isset($dataChild)) ? '<li class="breadcrumb-item">' . $dataChild . '</li>' : '<li class="breadcrumb-item active">' . $dataChild . '</li>';
	// 		}
	// 		if (!empty($dataGrandChild)) {
	// 			$view .= (isset($dataGrandChild)) ? '<li class="breadcrumb-item active">' . $dataGrandChild . '</li>' : '';
	// 		}
	// 		$view .= '</ol>';
	// 	}

	// 	if ($showTitle) {
	// 		$view .= '<h1 class="page-header">' . trim(strip_tags($dataChild)) . '</h1>';
	// 	}

	// 	return $view;
	// }

	public function breadcrumb($dataParent = null, $dataChild = null, $dataGrandChild = null)
	{
		$view = '<ol class="breadcrumb float-xl-right">';
		if (!empty($dataChild)) {
			$view .= isset($dataParent) ? '<li class="breadcrumb-item">' . $dataParent . '</li>' : '';
			$view .= '<li class="breadcrumb-item">' . $dataChild . '</li>';
		}
		if (!empty($dataGrandChild)) {
			$view .= '<li class="breadcrumb-item active">' . $dataGrandChild . '</li>';
		}
		$view .= '</ol>';
		$view .= '<h1 class="page-header">' . trim(strip_tags((string)$dataChild)) . ' <small>kumpulan beberapa data...</small></h1>';

		return $view;
	}

	// Mata Uang
	public function _currency($value)
	{
		return Number::format($value, ['places' => 0, 'locale' => 'id_ID']);
	}

	public function truncate($value)
	{
		$view = (!empty($value)) ? substr(str_pad($value, 5), 0, 5) . '...' : "...";
		return $view;
	}

	public function _packing($value = null)
	{
		$data = array('Drum logam (MD)' => 'Drum logam (MD)', 'Drum plastik (FC)' => 'Drum plastik (FC)', 'Jumbo Bag (JB)' => 'Jumbo Bag (JB)', 'Wheel Bin (WB)' => 'MD', 'Jerygan (JC)' => 'Jerygan (JC)', 'Karung Plastik (BA)' => 'Karung Plastik (BA)', 'Kemasan Karton atau plastik (FC)' => 'Kemasan Karton atau plastik (FC)');
		//$data = array('karung'=>'Karung', 'pcs'=>'PCS', 'box'=>'Box', 'md'=>'MD', 'jirigen'=>'Jirigen');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	// public function devision()
	// {
	// 	$view = array('KEU' => 'Accounting', 'WWH' => 'Gudang', 'HSE' => 'HSE', 'MKT' => 'Marketing', 'TRS' => 'Transport', 'GA' => 'HRD & GA', 'IT' => 'IT', 'FNC' => 'Finance');
	// 	return $view;
	// }

	public function position($data = null)
	{
		$view = array('MANAGER' => 'MANAGER', 'KEPALA UNIT' => 'KEPALA UNIT', 'STAF' => 'STAF', 'PELAKSANA' => 'PELAKSANA');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
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

	public function workingHoursSchedule($type, bool $isSaturday = false)
	{
		$weekday = [
			'1' => ['in' => '07:00', 'out' => '15:00'],
			'2' => ['in' => '08:00', 'out' => '16:00'],
			'3' => ['in' => '09:00', 'out' => '17:00'],
		];
		$saturday = [
			'1' => ['in' => '07:00', 'out' => '12:00'],
			'2' => ['in' => '08:00', 'out' => '13:00'],
			'3' => ['in' => '09:00', 'out' => '14:00'],
		];
		$data = $isSaturday ? $saturday : $weekday;
		return $data[$type] ?? null;
	}

	public function truck($value = null)
	{
		$data = array('DK 8868 QQ' => 'DK 8868 QQ', 'DK 8776 BT' => 'DK 8776 BT', 'DK 9136 CW' => 'DK 8776 BT', 'Lain-lain' => 'Lain-lain');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function warehouse($value = null)
	{
		$data = array('DENPASAR' => 'DENPASAR', 'GIANYAR' => 'GIANYAR', 'BULELENG' => 'BULELENG');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function typePca($value = null)
	{
		$data = array('ATK' => 'ATK', 'BEVERAGE' => 'BEVERAGE', 'CASH PURCHASE' => 'CASH PURCHASE', 'OPERATIONAL' => 'OPERATIONAL', 'TRANSPORT' => 'TRANSPORT');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function nom($value = null)
	{
		$values = (empty($value)) ? 0 : $value;
		$view = ($values == 0) ? 0 : number_format((float) $values, 2, ',', '.');
		return $view;
	}

	public function qty($value = null)
	{
		$values = (empty($value)) ? 0 : $value;
		$view = ($values == 0) ? 0 : number_format((float) $values, 0, ',', '.');
		return $view;
	}

	public function cur($value = null)
	{
		$values = (empty($value)) ? 0 : $value;
		if ($values < 0) {
			$result = str_replace('-', '', $values);
			$view = '(' . number_format((float) $result, 2, ',', '.') . ')';
		} elseif ($values == 0) {
			$view = 0;
		} else {
			// pr(number_format((float)$values, 2, '.', ','));
			// $view = number_format((float)$values, 2, '.', ',');
			$view = number_format((float) $values, 2, ',', '.');
		}

		// $values = (!empty($value)) ? number_format($value, 2, '.', ',') : '';
		return $view;
	}

	public function nom2Dec($number)
	{
		if (empty($number)) {
			$number = 0;
		} else {
			$number = str_replace(".", "", $number);
			$number = str_replace(",", ".", $number);
		}
		return $number;
	}


	public function percent($data = null)
	{
		$result = (empty($data)) ? 0 : str_replace(",000", "", (string) number_format($data, 3, ",", ""));

		return $result;
	}

	public function emptyData($value = '')
	{

		$value = (empty($value)) ? 'Data tidak ditemukan' : $value;
		$result = '<div class="table-responsive">
		<table class="table table-td-valign-middle">
		<tbody>
		<tr style="text-align: center;">
		<td>
		<br>
		<br>
		<i class="fa fa-chalkboard" style="font-size:48px; color: rgb(29, 34, 38, 0.1);"> ' . $value . '</i>
		<br>
		<br>
		</td>
		</tr>                      
		</tbody>
		</table>
		</div>';
		return $result;
	}

	public function paginators()
	{
		/*<div class="paginator">
			<ul class="pagination pagination-lg m-t-0 m-b-5">
				<li class="page-item"><?= $this->Paginator->first('<< ' . __('first')) ?></li>
				<?= $this->Paginator->prev('< ' . __('previous')) ?>
				<?= $this->Paginator->numbers() ?>
				<?= $this->Paginator->next(__('next') . ' >') ?>
				<?= $this->Paginator->last(__('last') . ' >>') ?>
			</ul>
			<p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
		</div>*/
		$view = '<div class="result-container">
				<div class="pull-left m-t-3 m-b-20">';
		$view .= $this->Paginator->counter('Halaman {{page}} sampai {{pages}}, mulai baris ke {{start}} sampai dengan baris ke {{end}} <br />Menampilkan {{current}} baris dengan jumlah total {{count}} baris');
		$view .= '</div>';
		$view .= '<div class="pull-right m-t-3 m-b-20">';
		$view .= '<div>
                <ul class="pagination m-t-0 m-b-5">';
		$view .= $this->Paginator->first('&laquo;', ['escape' => false]);
		//$view .= $this->Paginator->prev('< ');
		$view .= $this->Paginator->numbers(['first' => 0, 'last' => 0, 'ellipsis' => '<li><a  class="page-link">...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus' => 4, 'class' => 'page-item']);
		//$view .= $this->Paginator->next(' >');
		$view .= $this->Paginator->last('&raquo;', ['escape' => false]);
		$view .= '</ul></div></div></div>';
		return $view;
		// <li class="page-item disabled"><a href="javascript:;" class="page-link">«</a></li>';
		//$view .= $this->Paginator->first('&laquo;', ['tag' => 'li', 'escape' => false], ['class'=>'page-item']);
		// $view .= $this->Paginator->prev('« ');
		//          $view .= $this->Paginator->numbers(['class'=>'page-item', 'first' => 0, 'last' => 0, 'ellipsis' => '<li><a class="page-link">...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus'=>4]);
		//          $view .= $this->Paginator->last('&raquo;', ['tag' => 'li', 'escape' => false]);


		//$view .= '<div><ul class="pagination pagination-sm m-t-0 m-b-5">';

		//$view .= $this->Paginator->first('&laquo;');
		//    <ul class="pagination pagination-lg m-t-0 m-b-5">';
		//$view .= '</div><div class="pagination pull-right m-t-3 m-b-20">
		//			<ul class="pagination">';
		//$view .= $this->Paginator->options(array('url' => array('direction' => 'desc', 'page' => 6)));
		//$view .= $this->Paginator->options($urlPaging);
		/*

		//$view .= $this->Paginator->prev(' &laquo; ', array(), null, array('class' => 'prev disabled'));
		$view .= $this->Paginator->numbers(array('first' => 0, 'last' => 0, 'ellipsis' => '<li><a>...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus'=>4));
		//$view .= $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'ellipsis' => '<li><a>...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus'=>1));

		$view .= $this->Paginator->last('&raquo;', array('tag' => 'li', 'escape' => false));*/

		/*

		//$urlPaging = (empty($uuid)) ? array() : array('url'=> $uuid);
		$view = '<div class="result-container">
				<div class="pagination pull-left m-t-3 m-b-20">';
		$view .= $this->Paginator->counter('Halaman {:page} sampai {:pages}, mulai baris ke {:start} sampai dengan baris ke {:end} <br />Menampilkan {:current} baris dengan jumlah total {:count} baris');
		$view .= '</div><div class="pagination pull-right m-t-3 m-b-20">
					<ul class="pagination">';
		//$view .= $this->Paginator->options(array('url' => array('direction' => 'desc', 'page' => 6)));
		$view .= $this->Paginator->options($urlPaging);
		$view .= $this->Paginator->first('&laquo;', array('tag' => 'li', 'escape' => false));
		//$view .= $this->Paginator->prev(' &laquo; ', array(), null, array('class' => 'prev disabled'));
		$view .= $this->Paginator->numbers(array('first' => 0, 'last' => 0, 'ellipsis' => '<li><a>...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus'=>4));
		//$view .= $this->Paginator->numbers(array('first' => 1, 'last' => 1, 'ellipsis' => '<li><a>...</a></li>', 'separator' => false, 'tag' => 'li', 'currentTag' => 'a', 'currentClass' => 'active', 'modulus'=>1));

		$view .= $this->Paginator->last('&raquo;', array('tag' => 'li', 'escape' => false));
		$view .= '</ul></div></div>';
		return $view;		*/
	}

	public function titleCustomer($data = null)
	{
		$view = array('PT' => 'PT', 'CV' => 'CV', 'UD' => 'UD', 'INSTALASI FARMASI' => 'INSTALASI FARMASI', 'DINAS KESEHATAN' => 'DINAS KESEHATAN', 'PMI' => 'PMI', 'BIDAN' => 'BIDAN', 'RS' => 'RS', 'RSI' => 'RSI', 'RSIA' => 'RSIA', 'RSAD' => 'RSAD', 'RSAL' => 'RSAL', 'RSAU' => 'RSAU', 'RSB' => 'RSB', 'RSGM' => 'RSGM', 'RSJ' => 'RSJ', 'RSK' => 'RSK', 'RSKB' => 'RSKB', 'RSKM' => 'RSKM', 'RSM' => 'RSM', 'RSNU' => 'RSNU', 'RSPM' => 'RSPM', 'RSUH' => 'RSUH', 'RSUI' => 'RSUI', 'RSUM' => 'RSUM', 'RSUP' => 'RSUP', 'PRAKTEK DRG' => 'PRAKTEK DRG', 'PRAKTEK DR' => 'PRAKTEK DR', 'POLIKLINIK' => 'POLIKLINIK', 'PKM' => 'PKM', 'PG' => 'PG', 'KLINIK' => 'KLINIK', 'HOTEL' => 'HOTEL', 'DR' => 'DR', 'RSUD' => 'RSUD', 'RSU' => 'RSU', 'UPT' => 'UPT', 'UPTD' => 'UPTD', 'PLTU' => 'PLTU', 'UTD' => 'UTD', 'PUSKESMAS' => 'PUSKESMAS', 'YAYASAN' => 'YAYASAN', 'RESORT' => 'RESORT', 'VILLA' => 'VILLA', 'BENGKEL' => 'BENGKEL', 'SALON' => 'SALON', 'PEMERINTAH' => 'PEMERINTAH', 'APOTEK' => 'APOTEK', 'PERAWAT' => 'PERAWAT');

		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function projectStatus($data = null)
	{
		$view = array("Bali" => "Bali", "Surabaya" => "Surabaya");
		//$view = array('Wait'=>'Menunggu', 'Yes' => 'Diproses', 'Cancel'=>'Batal');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function numToRome($month)
	{
		$hasil = "";

		$iromawi = array(
			"",
			"I",
			"II",
			"III",
			"IV",
			"V",
			"VI",
			"VII",
			"VIII",
			"IX",
			"X",
			20 => "XX",
			30 => "XXX",
			40 => "XL",
			50 => "L",
			60 => "LX",
			70 => "LXX",
			80 => "LXXX",
			90 => "XC",
			100 => "C",
			200 => "CC",
			300 => "CCC",
			400 => "CD",
			500 => "D",
			600 => "DC",
			700 => "DCC",
			800 => "DCCC",
			900 => "CM",
			1000 => "M",
			2000 => "MM",
			3000 => "MMM"
		);
		if (array_key_exists($month, $iromawi)) {
			$hasil = $iromawi[$month];
		} elseif ($month >= 11 && $month <= 99) {
			$i = $month % 10;
			$hasil = $iromawi[$month - $i] . $this->numToRome($month % 10);
		} elseif ($month >= 101 && $month <= 999) {
			$i = $month % 100;
			$hasil = $iromawi[$month - $i] . $this->numToRome($month % 100);
		} else {
			$i = $month % 1000;
			$hasil = $iromawi[$month - $i] . $this->numToRome($month % 1000);
		}
		return $hasil;
	}

	public function generateRandomString($length = 10)
	{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;


		// var result           = '';
		// //var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		// var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		// var charactersLength = characters.length;
		// for ( var i = 0; i < length; i++ ) {
		//     result += characters.charAt(Math.floor(Math.random() * charactersLength));
		// }
		// return result;

	}

	public function postingStatus($data = null)
	{
		$view = array("" => "Semua", "draft" => "Draft", "posting" => "Posting", "closing" => "Closing");
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function inputDateRange($nameFrom, $arrayFrom = array(), $nameTo, $arrayTo = array(), $separator, $reset)
	{
		$input = '<div class="input-group input-daterange">';
		$input .= $this->Form->input($nameFrom, $arrayFrom);
		$input .= '<div class="input-group-prepend">';
		$input .= '<span class="input-group-text">' . $separator . '</span>';
		$input .= '</div>';
		$input .= $this->Form->input($nameTo, $arrayTo);
		$input .= '<div class="input-group-append">';
		$input .= '<button class="btn btn-inverse ' . $reset . '" type="button"><i class="fa fa-times"></i></button>';
		$input .= '</div></div>';

		return $input;
	}

	//________Tanggal Indonesia
	public function date_indo($date)
	{
		$split = explode("-", $date);
		$date = $split[2];
		$month = $this->get_month($split[1]);
		$year = $split[0];
		$result = $date . ' ' . $month . ' ' . $year;

		return $result;
		// $tanggal = substr($date,8,2);
		// $bulan = $this->get_month(substr($date,5,2));
		// $tahun = substr($date,0,4);
		// return $tanggal.' '.$bulan.' '.$tahun;
	}

	public function get_month($bln)
	{

		switch ($bln) {
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


	//  public function fDate($value=null, $formats='')
	// {
	// 	$format = (empty($formats)) ? 'd-m-Y' : $formats;
	// 	// $dateCreate = date_create($value);

	// 	$result = (empty($value) && empty($format)) ? '' : date_format($value, $format);
	// 	return $result;
	// }


	public function fEncode($data)
	{
		return $this->base64_encode(serialize($data));
	}

	public function fDecode($data)
	{
		return unserialize($this->base64_decode($data));
	}

	public function base64_encode($input)
	{
		return strtr(base64_encode($input), '+/=', '-_~');
	}

	public function base64_decode($input)
	{
		return base64_decode(strtr($input, '-_~', '+/='));
	}

	public function dateIndo($date, $showAll = true)
	{
		$split = explode("-", $date);
		$date = $split[2];
		$month = $this->getMonth($split[1]);
		$year = $split[0];

		if ($showAll == true) {
			$result = $date . ' ' . $month . ' ' . $year;
		} else {
			$result = $month . ' ' . $year;
		}

		return $result;
	}

	public function getMonth($bln)
	{
		switch ($bln) {
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

	// -----------------------
	// Accounting
	// ----------------------
	public function selectCOAType($data = null)
	{
		//Aktiva 
		//'aset'=>'Aset', 'aset_lancar'=>'Aset Lancar', 'kas_setara_kas'=>'Kas dan Setara Kas', 'investasi'=>'Investasi', 'piutang'=>'Piutang', 'piutang_pemegang_saham'=>'Piutang Pemegang Saham', 'piutang_afiliasi'=>'Piutang Afiliasi', 'piutang_karyawan'=>'Piutang Karyawan', 'piutang_lain_lain'=>'Piutang Lain-Lain', 'piutang_pajak'=>'Piutang Pajak', 'persediaan_barang'=>'Persediaan Barang', 'uang_muka_pembelian'=>'Uang Muka Pembelian', 'pajak_dibayar_dimuka'=>'Pajak Dibayar Dimuka', 'beban_dibayar_dimuka'=>'Beban Dibayar Dimuka', 'aset_tidak_lancar'=>'Aset Tidak Lancar', 'aset_tetap'=>'Aset Tetap', 'akumulasi_depresiasi'=>'Akumulasi Depresiasi', 'aset_lain_lain'=>'Aset Lain-Lain', 
		//Pasiva
		//'kewajiban'=>'Kewajiban', 'kewajiban_lancar'=>'Kewajiban Lancar', 'hutang_usaha'=>'Hutang Usaha', 'hutang_afiliasi'=>'Hutang Afiliasi', 'pendapatan_diterima'=>'Pendapatan Diterima', 'biaya_yang_masih_harus_dibayar'=>'Biaya yang Masih Harus Dibayar', 'hutang_pajak'=>'Hutang Pajak', 'hutang_bank'=>'Hutang Bank', 'hutang_leasing'=>'Hutang Leasing', 'hutang_pemegang_saham'=>'Hutang Pemegang Saham', 'hutang_karyawan'=>'Hutang Karyawan', 'hutang_lain_lain'=>'Hutang Lain-Lain', 'kewajiban_tidak_lancar'=>'Kewajiban Tidak Lancar', 'kewajiban_pajak_tangguhan'=>'Kewajiban Pajak Tangguhan', 'ekuitas'=>'Ekuitas'

		$view = array('aset' => 'Aset', 'aset_lancar' => 'Aset Lancar', 'kas_setara_kas' => 'Kas dan Setara Kas', 'investasi' => 'Investasi', 'investasi_jangka_panjang' => 'Investasi Jangka Panjang', 'piutang' => 'Piutang', 'piutang_pemegang_saham' => 'Piutang Pemegang Saham', 'piutang_afiliasi' => 'Piutang Afiliasi', 'piutang_karyawan' => 'Piutang Karyawan', 'piutang_lain_lain' => 'Piutang Lain-Lain', 'piutang_pajak' => 'Piutang Pajak', 'persediaan_barang' => 'Persediaan Barang', 'uang_muka_pembelian' => 'Uang Muka Pembelian', 'pajak_dibayar_dimuka' => 'Pajak Dibayar Dimuka', 'beban_dibayar_dimuka' => 'Beban Dibayar Dimuka', 'aset_tidak_lancar' => 'Aset Tidak Lancar', 'aset_tetap' => 'Aset Tetap', 'akumulasi_depresiasi' => 'Akumulasi Depresiasi', 'aset_lain_lain' => 'Aset Lain-Lain', 'kewajiban' => 'Kewajiban', 'kewajiban_lancar' => 'Kewajiban Lancar', 'hutang_usaha' => 'Hutang Usaha', 'hutang_afiliasi' => 'Hutang Afiliasi', 'pendapatan_diterima_dimuka' => 'Pendapatan Diterima Dimuka', 'biaya_yang_masih_harus_dibayar' => 'Biaya yang Masih Harus Dibayar', 'hutang_pajak' => 'Hutang Pajak', 'hutang_bank' => 'Hutang Bank', 'hutang_leasing' => 'Hutang Leasing', 'hutang_pemegang_saham' => 'Hutang Pemegang Saham', 'hutang_karyawan' => 'Hutang Karyawan', 'hutang_lain_lain' => 'Hutang Lain-Lain', 'kewajiban_tidak_lancar' => 'Kewajiban Tidak Lancar', 'kewajiban_pajak_tangguhan' => 'Kewajiban Pajak Tangguhan', 'ekuitas' => 'Ekuitas', 'pendapatan' => 'Pendapatan', 'retur_pendapatan' => 'Retur Pendapatan', 'potongan_pendapatan' => 'Potongan Pendapatan', 'beban_pokok_pendapatan' => 'Beban Pokok Pendapatan', 'beban_pendapatan' => 'Beban Pendapatan', 'beban_administrasi_umum' => 'Beban Administrasi & Umum', 'pendapatan_non_operasional' => 'Pendapatan Non Operasional', 'beban_non_operasional' => 'Beban Non Operasional');
		$result = (!empty($data)) ? $view[$data] : $view;
		return $result;
	}

	public function selectCOATypeOld($data = null)
	{
		$view = array('kas_bank' => 'Kas/Bank', 'penyesuaian' => 'Penyesuaian', 'akun_piutang' => 'Akun Piutang', 'piutang_usaha' => 'Piutang Usaha', 'persediaan' => 'Persediaan', 'aktiva_lancar_lainnya' => 'Aktiva Lancar Lainnya', 'aktiva_tetap' => 'Aktiva Tetap', 'akumulasi_penyusutan' => 'Akumulasi Penyusutan', 'aktiva_lainnya' => 'Aktiva Lainnya', 'akun_hutang' => 'Akun Hutang', 'cadangan_kerugian_piutang' => 'Cadangan Kerugian Piutang', 'hutang_lancar_lainnya' => 'Hutang Lancar Lainnya', 'hutang_jangka_pendek' => 'Hutang Jangka Pendek', 'hutang_jangka_panjang' => 'Hutang Jangka Panjang', 'ekuitas' => 'Ekuitas', 'pendapatan' => 'Pendapatan', 'harga_pokok_penjualan' => 'Harga Pokok Penjualan', 'beban' => 'Beban', 'beban_pemasaran' => 'Beban Pemasaran', 'beban_lain_lain' => 'Beban Lain-Lain', 'potongan_penjualan' => 'Potongan Penjualan', 'pendapatan_lain' => 'Pendapatan Lain', 'saldo_ditahan' => 'Saldo Ditahan', 'modal' => 'Modal', 'pajak' => 'Pajak', 'prive' => 'Prive');
		//$view = array('kas_bank^debet'=>'Kas/Bank', 'akun_piutang^debet'=>'Akun Piutang', 'piutang_usaha^debet'=>'Piutang Usaha', 'persediaan^debet'=>'Persediaan', 'aktiva_lancar_lainnya^debet'=>'Aktiva Lancar Lainnya', 'aktiva_tetap^debet'=>'Aktiva Tetap', 'akumulasi_penyusutan^credit'=>'Akumulasi Penyusutan', 'aktiva_lainnya^credit'=>'Aktiva Lainnya', 'akun_hutang^credit'=>'Akun Hutang', 'hutang_lancar_lainnya^credit'=>'Hutang Lancar Lainnya', 'hutang_jangka_panjang^credit'=>'Hutang Jangka Panjang', 'ekuitas^credit'=>'Ekuitas', 'pendapatan^credit'=>'Pendapatan', 'harga_pokok_penjualan^credit'=>'Harga Pokok Penjualan', 'beban^debet'=>'Beban', 'beban_pemasaran^debet'=>'Beban Pemasaran', 'beban_lain_lain^debet'=>'Beban Lain-Lain', 'potongan_penjualan^debet'=>'Potongan Penjualan', 'pendapatan_lain^credit'=>'Pendapatan Lain', 'saldo_ditahan^credit'=>'Saldo Ditahan', 'modal^credit'=>'Modal', 'pajak^debet'=>'Pajak', 'prive^debet'=>'Prive');
		$result = (!empty($data)) ? $view[$data] : $view;
		return $result;
	}

	public function _kelompok($value = null)
	{
		$data = array(
			'' => '',
			'Bangunan' => array(
				'Permanen' => 'Permanen (Tarif 5%)',
				'Non-Permanen' => 'Non Permanen (Tarif 10%)',
				'Proses' => 'Dalam Proses (Tarif 0%)',
			),
			'Non Bangunan' => array(
				'1' => 'Kelompok 1 (Tarif 25%)',
				'2' => 'Kelompok 2 (Tarif 12,5%)',
				'3' => 'Kelompok 3 (Tarif 6,25%)',
				'4' => 'Kelompok 4 (Tarif 5%)'
			)
		);
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function statusDC($value = null)
	{
		$data = array('D' => 'Debit', 'C' => 'Kredit');
		$view = (!empty($value)) ? $data[$value] : $data;
		return $view;
	}

	public function statusPost($value = null)
	{
		$data = array('neraca' => 'Neraca', 'laba-rugi' => 'Laba/Rugi');
		$view = (!empty($value)) ? $data[$value] : $data;
		return $view;
	}

	public function journalTypeCode($value = null)
	{
		$data = array('BKM' => 'C', 'BKK' => 'C', 'Bank Debet' => 'B', 'Bank Credit' => 'B', 'Memorial' => 'M');
		$view = (!empty($value)) ? $data[$value] : $data;
		return $view;
	}

	public function journalTypePrintCashBank()
	{
		$result = array('BKM', 'BKK', 'Bank Debet', 'Bank Credit');
		return $result;
	}

	public function journalTypePrintPosting()
	{
		$result = array('BKM', 'BKK', 'Bank Debet', 'Bank Credit', 'Memorial', 'Beginning Balance', 'Invoice', 'Operational');
		return $result;
	}

	public function journalType($value = null)
	{
		$data = array('BKM' => 'BKM', 'BKK' => 'BKK', 'Bank Debet' => 'Bank Debet', 'Bank Credit' => 'Bank Credit', 'Memorial' => 'Umum', 'Adjustment' => 'Penyesuaian', 'Closing' => 'Penutup', 'Beginning Balance' => 'Saldo Awal', 'Invoice' => 'Invoice', 'Invoice Masuk' => 'Invoice Masuk', 'Operational' => 'Operasional');
		$view = (!empty($value)) ? $data[$value] : $data;
		return $view;
	}

	public function status($data = null)
	{
		$view = array('Y' => 'Aktif', 'N' => 'Non-Aktif');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function statusTidakMasuk($data = null)
    {
        $view = array('Sesuai' => 'Sesuai', 'Tidak Sesuai' => 'Tidak Sesuai');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function btnSeach($value = '')
	{
		$view = $this->Form->button('<i class="fas fa-search"></i>', array('class' => 'btn btn-warning width-60 m-r-10', 'type' => 'submit', 'id' => 'btnSearch', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Cari"));

		return $view;
	}

	public function btnSave($title = 'Simpan')
	{
		$result = '<div class="panel-footer text-right bg-warning">' . $this->Form->button($title, ["class" => "btn btn-primary", "type" => "button", "escape" => false, "id" => "btn-add"]) . '</div>';
		return $result;
	}

	public function dataNull($desc = null, $type = 'warning')
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

	public function heading($title = null)
	{
		$result = '<div class="panel-heading">
	        <h4 class="panel-title">' . $title . '</h4>
	        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>    
	    </div>';
		// <div class="panel-heading-btn">
		//         <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
		//         <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
		//         <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
		//         <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
		//     </div>
		return $result;
	}

	public function incomeMultiPercentNew($data = null, $dataMonth = null, $name = null)
	{
		list($monthFrom, $monthEnd) = explode('^', $dataMonth);

		$dataCOALevel5Value = array();
		foreach ($data as $idLevel4 => $detail) {
			if (isset($detail['Level5Name']) && $detail['Level5Name']) {
				$level5Name = array_unique($detail['Level5Name']);

				$a = 0;
				foreach ($level5Name as $dataLevelCOA) {
					if (isset($dataLevelCOA)) {
						list($idDetail, $codeDetail, $nameDetail) = explode('^', $dataLevelCOA);

						for ($i = $monthFrom; $i <= $monthEnd; $i++) {
							$monthData = str_pad(strval($i), 2, '0', STR_PAD_LEFT);

							if ((isset($detail['Level5'][$monthData][$idDetail]))) {
								$dataCOALevel5Values = $detail['Level5'][$monthData][$idDetail];
								list($code, $debetCredit, $beginningBalance, $total) = explode('^', $dataCOALevel5Values);
								$dataCOALevel5Value[$monthData][$code] = $debetCredit;
							} else {
								$dataCOALevel5Value[$monthData][] = 0;
							}
						}
						$a++;
					}
				}
			}
		}
		for ($zz = $monthFrom; $zz <= $monthEnd; $zz++) {
			$monthData = str_pad(strval($zz), 2, '0', STR_PAD_LEFT);
			$dataCOATotalValue[$monthData][$name] = (isset($dataCOALevel5Value[$monthData])) ? array_sum($dataCOALevel5Value[$monthData]) : 0;
		}
		return $dataCOATotalValue;
	}

	// Kategori Limbah
	public function groupCategory($value = null)
	{
		$data = array('Pemanfaat' => 'Pemanfaat', 'Pengolah' => 'Pengolah', 'Pengumpul' => 'Pengumpul');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function typeDriver($data = null)
	{
		$view = array('Driver' => 'SUPIR', 'Helper' => 'KERNET', 'Nakhoda' => 'NAKHODA');
		$result = (empty($data)) ? $view : $view[$data];

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

	public function businessUnit($data = null)
	{
		$view = array("Triata" => "Triata", "Artama Bali" => "Artama Bali", "Artama Ambon" => "Artama Ambon", "Bhakti Bumi Berseri" => "Bhakti Bumi Berseri", "RSU Bhakti Rahayu (Tabanan)" => "RSU Bhakti Rahayu (Tabanan)", "RSU Bhakti Rahayu (Denpasar)" => "RSU Bhakti Rahayu (Denpasar)", "Wilwatikta" => "Wilwatikta", "Pratama Jaya" => "Pratama Jaya", "BWC" => "BWC", "CTBL" => "CTBL", "Damar" => "Damar", "KARFA" => "KARFA", "Koperasi" => "Koperasi", "MBDU" => "MBDU", "Citra Gama Sakti" => "Citra Gama Sakti", "Klin" => "Klin", "Satria Buana Cemerlang" => "Satria Buana Cemerlang", "Unilab" => "Unilab");
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function placement()
	{

		$view = array('BWC' => 'BWC', 'KARFA' => 'KARFA', 'PRATAMA' => 'PRATAMA', 'UNILAB' => 'UNILAB', 'WILWA' => 'WILWA', 'TRIATA' => 'TRIATA', 'ARTAMA BALI' => 'ARTAMA BALI', 'ARTAMA AMBON' => 'ARTAMA AMBON', 'BERSERI' => 'BERSERI', 'KOPERASI' => 'KOPERASI', 'CTBL' => 'CTBL', 'MENITINI' => 'MENITINI', 'DAMAR' => 'DAMAR', 'CMC' => 'CMC', 'BWA' => 'BWA', 'EINSTEINS' => 'EINSTEINS', 'RSB DPS' => 'RSB DPS', 'RSB SBY' => 'RSB SBY', 'RSB TNN' => 'RSB TNN', 'BHAKSENA' => 'BHAKSENA', 'KLINIK' => 'KLINIK', 'GUDANG' => 'GUDANG');

		return $view;
	}

	public function categoryAsset($data = null)
	{
		$view = array('ASSET' => 'ASSET', 'NON ASSET' => 'NON ASSET/INVENTARIS', 'SEWA' => 'SEWA');
		$result = (empty($data)) ? $view : $view[$data];

		return $result;
	}

	public function typeAsset($data = null)
	{
		$view = array('OBAT' => 'OBAT', 'ALKES' => 'ALKES', 'ALAT MEDIS' => 'ALAT MEDIS', 'PERLENGKAPAN' => 'PERLENGKAPAN', 'FURNITURE' => 'FURNITURE', 'KOMPUTER' => 'KOMPUTER', 'KENDARAAN' => 'KENDARAAN', 'BANGUNAN' => 'BANGUNAN', 'MESIN' => 'MESIN', 'OTHERS' => 'OTHERS');
		$result = (empty($data)) ? $view : $view[$data];

		return $result;
	}

	public function typeScm($data = null)
	{
		$view = array('OBAT' => 'OBAT', 'ALKES' => 'ALKES', 'ALAT MEDIS' => 'ALAT MEDIS');
		$result = (empty($data)) ? $view : $view[$data];

		return $result;
	}


	public function unitAsset($value = null)
	{
		$data = array('ml' => 'ml', 'mg' => 'mg', 'pcs' => 'Pcs', 'botol' => 'Botol', 'box' => 'Box', 'tube' => 'Tube', 'roll' => 'Roll', 'unit' => 'Unit');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function fPayment($data = null)
	{
		$view = array('Y' => 'Lunas', 'N' => 'Blm Dibayar', 'NP' => 'Kurang Bayar');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function typeCost($value = null)
	{
		$data = array('Pengolahan Limbah' => 'Pengolahan Limbah', 'Transporter' => 'Transporter', 'Sewa' => 'Sewa', 'GPS' => 'GPS', 'Gas' => 'Gas', 'Perawatan dan Pemeliharaan' => 'Perawatan dan Pemeliharaan', 'Service' => 'Service', 'Pembelian' => 'Pembelian', 'Loading' => 'Loading', 'Lain-lain' => 'Lain-lain');
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function bankSubmission()
	{
		$view = array('1450101055487' => 'Bank Mandiri (Putu Ivan Yunatana)');
		return $view;
	}

	public function statusPca($data = null)
	{
		$view = array('Y' => 'Setuju', 'W' => 'Tunggu', 'N' => 'Ditolak');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function fTextPlain($dataText)
	{
		$view = '<input type="text" readonly class="form-control-plaintext" value="' . $dataText . '" />';
		return $view;
	}

	public function methodPayment($value = null)
	{
		$data = array('Permata Syariah - TMI' => 'Permata Syariah - TMI', 'Permata Syariah - Artama' => 'Permata Syariah - Artama', 'Bank Jateng - Artama (1056006831)' => 'Bank Jateng - Artama (1056006831)', 'Cash' => 'Cash', 'Pajak' => 'Pajak', 'BCA' => 'BCA', 'Buwono Himawan - Mandiri' => 'Buwono Himawan - Mandiri', 'BSM' => 'BSM', 'Bank Jatim' => 'Bank Jatim', 'Mandiri' => 'Mandiri', 'Bank Mandiri' => 'Bank Mandiri', 'Bank Mandiri Artama' => 'Bank Mandiri Artama', 'Muamalat - Artama' => 'Muamalah - Artama', 'Permata - GNJ' => 'Permata - GNJ', 'Permata - TMI' => 'Permata - TMI', 'Permata - Numara' => 'Permata - Numara', 'Permata - Nusa Saraya' => 'Permata - Nusa Saraya', 'BTPN - Triata' => 'BTPN - Triata', 'BNI Syariah - Triata' => 'BNI Syariah - Triata', 'BNI Syariah - Artama' => 'BNI Syariah - Artama', 'Bank Jatim Syariah' => 'Bank Jatim Syariah', 'BSI - Triata' => 'BSI - Triata', 'BSI - Artama' => 'BSI - Artama', 'BCA Madu Mozaik' => 'BCA Madu Mozaik', 'BSI Mozaik' => 'BSI Mozaik', 'BSI - MPP' => 'BSI - MPP', 'BSI - NJK' => 'BSI - NJK', 'BSI - Numara' => 'BSI - Numara', 'Permata - 8sisi' => 'Permata - 8sisi', 'Permata - Sagara' => 'Permata - Sagara', 'Marketing' => 'Marketing', 'Mas Ruchi' => 'Mas Ruchi');

		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function regex($value = null)
	{
		$result = preg_replace('/[^a-zA-Z0-9 ]/', '', $value);
		return $result;
	}

	public function mealTime($value = null)
	{
		$data = array(
			'1' => 'Makan Pagi',
			'2' => 'Snack Pagi',
			'3' => 'Makan Siang',
			'4' => 'Snack Sore',
			'5' => 'Makan Sore',
			'6' => 'Snack Malam'
		);

		$result = ($value !== null)
			? $data[$value]
			: $data;

		return $result;
	}

	public function occupations()
	{
		return [
			'PNS' => 'PNS',
			'TNI' => 'TNI',
			'POLRI' => 'POLRI',
			'Pegawai Swasta' => 'Pegawai Swasta',
			'Wiraswasta' => 'Wiraswasta',
			'Petani' => 'Petani',
			'Nelayan' => 'Nelayan',
			'Buruh' => 'Buruh',
			'Guru' => 'Guru',
			'Dosen' => 'Dosen',
			'Pelajar/Mahasiswa' => 'Pelajar/Mahasiswa',
			'Ibu Rumah Tangga' => 'Ibu Rumah Tangga',
			'Pensiunan' => 'Pensiunan',
			'Tidak Bekerja' => 'Tidak Bekerja',
			'Lainnya' => 'Lainnya',
		];
	}

	public function nutritionTexture($value = null)
	{
		$data = array(
			'MC' => 'Makanan Cair',
			'MS' => 'Makanan Saring',
			'ML' => 'Makanan Lunak',
			'NT' => 'Nasi Tim',
			'NB' => 'Nasi Biasa',
			'PSA' => 'Puasa'
		);

		$result = ($value !== null)
			? $data[$value]
			: $data;

		return $result;
	}

	public function nutritionDiet($value = null)
	{
		$data = array(
			'ETPT' => 'Diet Energi Tinggi Protein Tinggi',
			'RG' => 'Diet Rendah Garam',
			'DM' => 'Diet Diabetes Mellitus',
			'DL' => 'Diet Lambung',
			'TS' => 'Diet Tinggi Serat',
			'RS' => 'Diet Rendah Serat',
			'SN' => 'Diet Sindrom Nefrotik',
			'RL' => 'Diet Rendah Lemak',
			'DPR' => 'Diet Purin Rendah',
			'DPRR' => 'Diet Protein Rendah',
			'DRK' => 'Diet Rendah Kalori',
			'DH' => 'Diet Hiperemesis',
			'DPE' => 'Diet Pre Eklamsi',
			'DD' => 'Diet Dislipidemia'
		);

		$result = ($value !== null)
			? $data[$value]
			: $data;

		return $result;
	}

	public function nutritionContent($value = null)
	{
		$data = array(
			'ENERGI' => 'Energi',
			'PROTEIN' => 'Protein',
			'LEMAK' => 'Lemak',
			'KARBOHIDRAT' => 'Karbohidrat',
			'KALSIUM' => 'Kalsium',
			'VITAMIN_A' => 'Vitamin A',
			'IRON' => 'Iron'
		);

		$result = ($value !== null)
			? $data[$value]
			: $data;

		return $result;
	}

	public function nutritionContentUnit($value = null)
	{
		$data = array(
			'ENERGI' => 'kkal',
			'PROTEIN' => 'gram',
			'LEMAK' => 'gram',
			'KARBOHIDRAT' => 'gram',
			'KALSIUM' => 'mg',
			'VITAMIN_A' => 'µg',
			'IRON' => 'mg'
		);

		$result = ($value !== null)
			? $data[$value]
			: $data;

		return $result;
	}

	public function polyclinics($value = null)
	{
		$view = [
			'Poli Umum' => 'Poli Umum',
			'Poli Kandungan' => 'Poli Kandungan',
			'Poli Anak' => 'Poli Anak',
			'Poli Penyakit Dalam' => 'Poli Penyakit Dalam (Internis)',
			'Poli Bedah Umum' => 'Poli Bedah Umum',
			'Poli Rehab Medik' => 'Poli Rehab Medik',
			'Poli Saraf' => 'Poli Saraf',
			'Poli THT' => 'Poli THT',
			'Poli Urologi' => 'Poli Urologi',
			'Poli Paru' => 'Poli Paru',
			'Poli Orthopedi' => 'Poli Orthopedi',
			'Poli Gigi Konservasi' => 'Poli Gigi Konservasi / Endodonsi',
			'Poli Gigi Bedah Mulut' => 'Poli Gigi & Bedah Mulut',
			'Poli Jantung' => 'Poli Jantung & Pembuluh Darah',
			'Poli Jiwa' => 'Poli Jiwa',
			'Poli Kulit Kelamin' => 'Poli Kulit & Kelamin',
			'Poli Mata' => 'Poli Mata',
			'PPDP' => 'PPDP',
			'Executive' => 'Executive',
			'Bidan/KIA' => 'Bidan/KIA',
		];
		$result = (empty($value)) ? $view : ($view[$value] ?? $value);
		return $result;
	}

	// public function religions()
	// {
	// 	return [
	// 		'Islam' => 'Islam',
	// 		'Kristen' => 'Kristen',
	// 		'Katolik' => 'Katolik',
	// 		'Hindu' => 'Hindu',
	// 		'Buddha' => 'Buddha',
	// 		'Konghucu' => 'Konghucu',
	// 		'Lainnya' => 'Lainnya',
	// 	];
	// }

	public function classes()
	{
		return [
			'VIP' => 'VIP',
			'Kelas I' => 'Kelas I',
			'Kelas II' => 'Kelas II',
			'Kelas III' => 'Kelas III',
			'ICU' => 'ICU',
			'NICU' => 'NICU',
			'PICU' => 'PICU',
			'HCU' => 'HCU',
			'Isolasi' => 'Isolasi',
			'Rawat Khusus' => 'Rawat Khusus',
		];
	}

	public function floors()
	{
		return [
			'1' => 'Lantai 1',
			'2' => 'Lantai 2',
			'3' => 'Lantai 3',
		];
	}

	public function syncFromRegistration($registration)
	{
		$schema = $this->getSchema();

		$visit = $this->find()
			->where(['OutpatientVisits.registration_id' => $registration->id])
			->first();

		if (!$visit) {
			$visit = $this->newEmptyEntity();
		}

		$data = [
			'registration_id' => $registration->id,
			'registration_no' => $registration->registration_no ?? null,
			'patient_id' => $registration->patient_id,
			'doctor_id' => $registration->doctor_id ?? null,
			'queue_number' => $registration->queue_number ?? null,
			'polyclinic_name' => $registration->polyclinic_name ?? null,
			'visit_date' => !empty($registration->registration_date)
				? $registration->registration_date
				: date('Y-m-d'),
			'visit_time' => !empty($registration->admission_time)
				? $registration->admission_time
				: date('H:i:s'),
			'status' => 'waiting',
			'payment_method' => $registration->payment_method ?? null,
			'paid' => 0,
			'total_fee' => 0,
		];

		$data = array_intersect_key($data, array_flip($schema->columns()));

		$visit = $this->patchEntity($visit, $data);

		return $this->save($visit);
	}

	public function outpatientRooms($value = null)
	{
		$data = [
			' Poli Umum 01' => ' Poli Umum 01',
			' Poli Gigi 01' => ' Poli Gigi 01',
			' Poli Anak 01' => ' Poli Anak 01',
			' Poli Kandungan 01' => ' Poli Kandungan 01',
			' Poli Penyakit Dalam 01' => ' Poli Penyakit Dalam 01',
			' Poli Mata 01' => ' Poli Mata 01',
			' Poli THT 01' => ' Poli THT 01',
			' Poli Bedah 01' => ' Poli Bedah 01',
			' Poli Saraf 01' => ' Poli Saraf 01',
			' Poli Kulit 01' => ' Poli Kulit 01',
			' Poli Jantung 01' => ' Poli Jantung 01',
			' IGD 01' => ' IGD 01',
			' IGD 02' => ' IGD 02',
			' Triage IGD' => ' Triage IGD',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}

	public function surgeryOperatorSpecialists(): array
	{
		return [
			'Sp.B' => 'Sp.B - Bedah Umum',
			'Sp.OG' => 'Sp.OG - Kandungan',
			'Sp.M' => 'Sp.M - Mata',
			'Sp.OT' => 'Sp.OT - Ortopedi',
			'Sp.U' => 'Sp.U - Urologi',
			'Sp.BS' => 'Sp.BS - Bedah Saraf',
			'Sp.BTKV' => 'Sp.BTKV - Bedah Toraks Kardiovaskular',
			'Sp.BP-RE' => 'Sp.BP-RE - Bedah Plastik',
			'Lainnya' => 'Lainnya',
		];
	}

	public function operationTypeCategories(): array
	{
		return [
			'Bedah Umum' => 'Bedah Umum',
			'Bedah Mata' => 'Bedah Mata',
			'Bedah Kandungan' => 'Bedah Kandungan',
			'Bedah Ortopedi' => 'Bedah Ortopedi',
			'Bedah Urologi' => 'Bedah Urologi',
			'Bedah Saraf' => 'Bedah Saraf',
			'Bedah Plastik' => 'Bedah Plastik',
			'Bedah THT' => 'Bedah THT',
			'Lainnya' => 'Lainnya',
		];
	}

	public function nutritionDietOptions(): array
	{
		return [
			'Diet Energi Tinggi Protein Tinggi' => 'Diet Energi Tinggi Protein Tinggi',
			'Diet Rendah Garam' => 'Diet Rendah Garam',
			'Diet Diabetes Mellitus' => 'Diet Diabetes Mellitus',
			'Diet Lambung' => 'Diet Lambung',
			'Diet Tinggi Serat' => 'Diet Tinggi Serat',
			'Diet Rendah Serat' => 'Diet Rendah Serat',
			'Diet Sindrom Nefrotik' => 'Diet Sindrom Nefrotik',
			'Diet Rendah Lemak' => 'Diet Rendah Lemak',
			'Diet Purin Rendah' => 'Diet Purin Rendah',
			'Diet Protein Rendah' => 'Diet Protein Rendah',
			'Diet Rendah Kalori' => 'Diet Rendah Kalori',
			'Diet Hiperemesis' => 'Diet Hiperemesis',
			'Diet Pre eklamsi' => 'Diet Pre eklamsi',
			'Diet Dislipidemia' => 'Diet Dislipidemia',
		];
	}
	public function laboratoryCategories(): array
	{
		return [
			'ALERGI' => 'Alergi',
			'ANALISA CAIRAN' => 'Analisa Cairan',
			'ANALISA CSF' => 'Analisa CSF',
			'ANEMIA' => 'Anemia',
			'BIOMOLEKULER' => 'Biomolekuler',
			'BMP' => 'BMP',
			'ENDOKRINOLOGI' => 'Endokrinologi',
			'FEACES' => 'Feaces',
			'HEMATOLOGI' => 'Hematologi',
			'IMUNO-SEROLOGI' => 'Imuno-Serologi',
			'IMUNOHISTOKIMIA' => 'Imunohistokimia',
			'JANTUNG' => 'Jantung',
			'KESMAS' => 'Kesmas',
			'KIMIA KLINIK' => 'Kimia Klinik',
			'KIMIA LAIN' => 'Kimia Lain',
			'MIKROBIOLOGI' => 'Mikrobiologi',
			'PATOLOGI ANATOMI' => 'Patologi Anatomi',
			'TRANFUSI' => 'Tranfusi',
			'URINALISIS' => 'Urinalisis',
		];
	}

	public function gudangFarmasi($value = null)
	{
		$data = [
			'DRIVER'   => 'DRIVER DEPO',
			'EXPDATE'  => 'EXPIRE DATE / REJECT DEPO',
			'FARMASI1' => 'FARMASI 1 RAWAT + ICU DEPO',
			'FARMASI2' => 'FARMASI 2 RAJAL DEPO',
			'GBHP'     => 'GUDANG BHP',
			'GFARMA'   => 'GUDANG OBAT/ALKES',
		];
	
		$result = ($value !== null) ? ($data[$value] ?? $value) : $data;
		return $result;
	}
	public function kirimVia($value = null)
	{
		$data = array(
			'Kurir Internal' => 'Kurir Internal',
			'Ekspedisi' => 'Ekspedisi / Jasa Pengiriman',
			'Diambil Sendiri' => 'Diambil Sendiri',
			'Sales Supplier' => 'Diantar Sales Supplier',
		);
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}

	public function jenisOrderPembelian($value = null)
	{
		$data = array(
			'Reguler' => 'Reguler',
			'Urgent' => 'Urgent / CITO',
			'Konsinyasi' => 'Konsinyasi',
			'Tender' => 'Tender / Kontrak',
		);
		$result = ($value) ? $data[$value] : $data;
		return $result;
	}
	public function specialists($value = null)
	{
		$data = [
			'Anak'                          => 'Anak',
			'Anestesi'                      => 'Anestesi',
			'Bedah Umum'                    => 'Bedah Umum',
			'Bedah Plastik'                 => 'Bedah Plastik',
			'Bedah Saraf'                   => 'Bedah Saraf',
			'Bedah Toraks Kardiovaskular'   => 'Bedah Toraks Kardiovaskular',
			'THT'                           => 'THT',
			'Forensik'                      => 'Forensik',
			'Jantung & Pembuluh Darah'      => 'Jantung & Pembuluh Darah',
			'Kulit & Kelamin'               => 'Kulit & Kelamin',
			'Kedokteran Jiwa'               => 'Kedokteran Jiwa',
			'Kedokteran Fisik & Rehabilitasi' => 'Kedokteran Fisik & Rehabilitasi',
			'Mata'                          => 'Mata',
			'Kandungan'                     => 'Kandungan',
			'Ortopedi'                      => 'Ortopedi',
			'Patologi Anatomi'              => 'Patologi Anatomi',
			'Patologi Klinik'               => 'Patologi Klinik',
			'Penyakit Dalam'                => 'Penyakit Dalam',
			'Paru'                          => 'Paru',
			'Radiologi'                     => 'Radiologi',
			'Saraf'                         => 'Saraf',
			'Urologi'                       => 'Urologi',
			'Gizi Klinik'                   => 'Gizi Klinik',
			'Dermatovenereologi'            => 'Dermatovenereologi',
			'Dokter Umum'                   => 'Dokter Umum',
			'Dokter Gigi'                   => 'Dokter Gigi',
			'Lainnya'                       => 'Lainnya',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}

	public function entryProcessOptions(): array
	{
		return [
			'Melalui Unit Rawat Jalan' => 'Melalui Unit Rawat Jalan',
			'Melalui Unit Darurat' => 'Melalui Unit Darurat',
			'Langsung Ke Radiologi' => 'Langsung Ke Radiologi',
			'Langsung Ke Laboratorium' => 'Langsung Ke Laboratorium',
			'Melalui Instansi Gawat Kebidanan' => 'Melalui Instansi Gawat Kebidanan',
		];
	}

	public function entryMethodOptions(): array
	{
		return [
			'RSU/RSK/RB' => 'RSU/RSK/RB',
			'PUSKESMAS' => 'PUSKESMAS',
			'DR/DR G' => 'DR/DR G',
			'TENAGA KESEHATAN' => 'TENAGA KESEHATAN',
			'KASUS POLISI' => 'KASUS POLISI',
			'DATANG SENDIRI' => 'DATANG SENDIRI',
			'KECELAKAAN LALU LINTAS' => 'KECELAKAAN LALU LINTAS',
		];
	}

	public function tindakanKategori($value = null)
	{
		$data = [
			'Konsultasi'    => 'Konsultasi',
			'Tindakan Medis' => 'Tindakan Medis',
			'Tindakan Bedah' => 'Tindakan Bedah',
			'Laboratorium'  => 'Laboratorium',
			'Radiologi'     => 'Radiologi',
			'Fisioterapi'   => 'Fisioterapi',
			'Farmasi'       => 'Farmasi',
			'Keperawatan'   => 'Keperawatan',
			'Gizi'          => 'Gizi',
			'Administrasi'  => 'Administrasi',
			'Lainnya'       => 'Lainnya',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}

	public function regions($value = null)
	{
		$data = [
			'Surabaya' => 'Surabaya',
			'Ambon' => 'Ambon',
			'Denpasar' => 'Denpasar',
			'Tabanan' => 'Tabanan',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}

	public function bankName($data=null)
	{
		$view = array('BNI'=>'BNI', 'MANDIRI'=>'MANDIRI', 'PERMATA'=>'PERMATA','BTN'=>'BTN','BRI'=>'BRI','BSI'=>'BSI','CIMB NIAGA'=>'CIMB NIAGA','DANAMON'=>'DANAMON','MAYBANK'=>'MAYBANK','BANK JATIM'=>'BANK JATIM','PANIN'=>'PANIN','UOB'=>'UOB','BCA'=>'BCA', 'CAD'=>'CAD', 'CASH'=>'CASH', 'ARTHA GRAHA INTERNASIONAL' => 'ARTHA GRAHA INTERNASIONAL', 'BPD BALI' => 'BPD BALI');
		
		$result = (empty($data)) ? $view : $view[$data];
		
		return $result;
	}
	public function referralTypes($value = null)
	{
		$data = [
			'rujukan_fktp' => 'Rujukan FKTP',
			'rujukan_internal' => 'Rujukan Internal',
			'kontrol' => 'Kontrol',
			'rujukan_antar_rs' => 'Rujukan Antar RS',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}

	/**
	 * Pilihan "Melalui" (kanal masuknya pra registrasi/antrian) pada modul
	 * Pra Registrasi / Antrian Poliklinik. Dipakai lewat $this->Krs->referralChannels()
	 * untuk mengisi opsi dropdown.
	 */
	public function referralChannels($value = null)
	{
		$data = [
			'telepon' => 'Telepon',
			'sms' => 'SMS',
			'website' => 'Website',
			'poli_spesialis' => 'Poli Spesialis',
			'wa' => 'WA',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}
	public function tenagaMedisKategori($value = null)
	{
		$data = [
			'PERAWAT/SUSTER'   => 'Perawat/Suster',
			'BIDAN'            => 'Bidan',
			'ANALIS LABORATORIUM' => 'Analis Laboratorium',
			'PENUNJANG MEDIS'  => 'Penunjang Medis',
			'RADIOGRAFER'      => 'Radiografer',
			'FISIOTERAPIS'     => 'Fisioterapis',
			'AHLI GIZI'        => 'Ahli Gizi',
			'APOTEKER'         => 'Apoteker',
			'TENAGA TEKNIS KEFARMASIAN' => 'Tenaga Teknis Kefarmasian',
			'UMUM'             => 'Umum',
		];

		return $value !== null ? ($data[$value] ?? $value) : $data;
	}

	public function tenagaMedisKodePrefix($value = null)
	{
		$data = [
			'PERAWAT/SUSTER'   => 'PWT',
			'BIDAN'            => 'BDN',
			'ANALIS LABORATORIUM' => 'ANL',
			'PENUNJANG MEDIS'  => 'PNJ',
			'RADIOGRAFER'      => 'RAD',
			'FISIOTERAPIS'     => 'FIS',
			'AHLI GIZI'        => 'GZI',
			'APOTEKER'         => 'APT',
			'TENAGA TEKNIS KEFARMASIAN' => 'TTK',
			'UMUM'             => 'UMM',
		];

		return $value !== null ? ($data[$value] ?? 'TMD') : $data;
	}

	protected $hariIndo = [
		'Sunday'    => 'Minggu',
		'Monday'    => 'Senin',
		'Tuesday'   => 'Selasa',
		'Wednesday' => 'Rabu',
		'Thursday'  => 'Kamis',
		'Friday'    => 'Jumat',
		'Saturday'  => 'Sabtu',
	];

	protected $bulanIndoFull = [
		'January'   => 'Januari',
		'February'  => 'Februari',
		'March'     => 'Maret',
		'April'     => 'April',
		'May'       => 'Mei',
		'June'      => 'Juni',
		'July'      => 'Juli',
		'August'    => 'Agustus',
		'September' => 'September',
		'October'   => 'Oktober',
		'November'  => 'November',
		'December'  => 'Desember',
	];

	public function dayNameIndo($timestampOrString)
	{
		$ts = is_int($timestampOrString) ? $timestampOrString : strtotime((string)$timestampOrString);
		return $this->hariIndo[date('l', $ts)] ?? date('l', $ts);
	}

	public function monthNameIndo($timestampOrString)
	{
		$ts = is_int($timestampOrString) ? $timestampOrString : strtotime((string)$timestampOrString);
		return $this->bulanIndoFull[date('F', $ts)] ?? date('F', $ts);
	}

	public function tanggalIndoLengkap($timestampOrString, $withDay = true)
	{
		$ts = is_int($timestampOrString) ? $timestampOrString : strtotime((string)$timestampOrString);
		$hari  = $this->dayNameIndo($ts);
		$bulan = $this->monthNameIndo($ts);
		$tgl   = date('d', $ts);
		$thn   = date('Y', $ts);

		return $withDay
			? "{$hari}, {$tgl} {$bulan} {$thn}"
			: "{$tgl} {$bulan} {$thn}";
	}

	public function zona ($data = null)
    {
        $view = array('WIB' => 'WIB', 'WITA' => 'WITA', 'WIT' => 'WIT');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }
	public function longlat($data=null)
	{
		$view = array('-7.311801688608039, 112.7229403294435' => 'RS Bhakti Rahayu Surabaya', '-7.3681686992348405, 112.69680335232351' => 'PT Aksata Nusantara Infosysjaya');
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function religions($data = null)
    {
        $view = array("Islam" => "Islam", "Kristen" => "Kristen", "Katolik" => "Katolik", "Hindu" => "Hindu", "Buddha" => "Buddha", "Khonghucu" => "Khonghucu");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }
	public function family($value = null)
    {
        $data = array('Suami' => 'Suami', 'Istri' => 'Istri', 'Anak 1' => 'Anak 1', 'Anak 2' => 'Anak 2', 'Anak 3' => 'Anak 3', 'Anak 4' => 'Anak 4', 'Anak 5' => 'Anak 5', 'Anak 6' => 'Anak 6');
        $result = ($value) ? $data[$value] : $data;
        return $result;
    }

    public function statusTanggungan($data = null)
    {
        $view = array('TK/0' => 'Tidak Kawin', 'K/0' => 'Kawin Tidak Punya Anak', 'K/1' => 'Kawin Anak 1', 'K/2' => 'Kawin Anak 2', 'K/3' => 'Kawin Anak 3', 'K/4' => 'Kawin Anak 4', 'K/5' => 'Kawin Anak 5', 'K/6' => 'Kawin Anak 6');
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function employeeStatus($data = null)
    {
        $view = array("1" => "Kontrak 1 (3 bulan)", "2" => "Kontrak 1 (6 bulan)", "3" => "Kontrak 1 (12 bulan)", "4" => "Kontrak 2 (3 bulan)", "5" => "Kontrak 2 (6 bulan)", "6" => "Kontrak 2 (12 bulan)", "7" => "Kontrak 3 (3 bulan)", "8" => "Kontrak 3 (6 bulan)", "9" => "Kontrak 3 (12 bulan)", "tetap" => "Tetap", "Non-Aktif" => "Non-Aktif", "Resign" => "Resign", "PHK" => "PHK", "Pensiun" => "Pensiun");
        //$view = array("tetap" => "Tetap", "1-3" => "Kontrak Ke-1 ( 3 Bulan)", "1-6" => "Kontrak Ke-1 ( 6 Bulan)", "1-12" => "Kontrak Ke-1 ( 12 Bulan)", "2-3" => "Kontrak Ke-2 ( 3 Bulan)", "2-6" => "Kontrak Ke-2 ( 6 Bulan)", "2-12" => "Kontrak Ke-2 ( 12 Bulan)", "3-3" => "Kontrak Ke-3 ( 3 Bulan)", "3-6" => "Kontrak Ke-3 ( 6 Bulan)", "3-12" => "Kontrak Ke-3 ( 12 Bulan)");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function subDivision($data = null)
	{
		$view = [
			'PAJAK' => [
				'PAJAK^Pajak' => 'PAJAK',
			],
			'SEKPEM GROUP NUSANTARA'=> [
				'SEKPEM GROUP NUSANTARA^ADMIN' => 'ADMIN',
				'SEKPEM GROUP NUSANTARA^OPERASIONAL' => 'OPERASIONAL'
			], 
			'SEKPEM GROUP WILAYAH TIMUR (SG-Tim)'=> [
				'SEKPEM GROUP WILAYAH TIMUR (SG-Tim)^ADMIN' => 'ADMIN',
				'SEKPEM GROUP WILAYAH TIMUR (SG-Tim)^OPERASIONAL' => 'OPERASIONAL'
			],
			'SEKPEM GROUP WILAYAH (SG-Teng)'=> [
				'SEKPEM GROUP WILAYAH (SG-Teng)^ADMIN' => 'ADMIN',
				'SEKPEM GROUP WILAYAH (SG-Teng)^OPERASIONAL' => 'OPERASIONAL'
			],
			'SEKPEM GROUP WILAYAH BARAT (SG-B)'=> [
				'SEKPEM GROUP WILAYAH BARAT (SG-B)^ADMIN' => 'ADMIN',
				'SEKPEM GROUP WILAYAH BARAT (SG-B)^OPERASIONAL' => 'OPERASIONAL'
			],
			'SPI GROUP NUSANTARA'=> [
				'SPI GROUP NUSANTARA^SPI GROUP NUSANTARA' => 'SPI GROUP NUSANTARA',
			],
			'SPI GROUP WILAYAH TIMUR (SPI G-Tim)'=> [
				'SPI GROUP WILAYAH TIMUR (SPI G-Tim)^SPI GROUP WILAYAH TIMUR (SPI G-Tim)' => 'SPI GROUP WILAYAH TIMUR (SPI G-Tim)',
			],
			'SPI GROUP WILAYAH TENGAH (SPI G-Teng)'=> [
				'SPI GROUP WILAYAH TENGAH (SPI G-Teng)^SPI GROUP WILAYAH TENGAH (SPI G-Teng)' => 'SPI GROUP WILAYAH TENGAH (SPI G-Teng)',
			],
			'SPI GROUP WILAYAH BARAT (SPI G-B)'=> [
				'SPI GROUP WILAYAH BARAT (SPI G-B)^SPI GROUP WILAYAH BARAT (SPI G-B)' => 'SPI GROUP WILAYAH BARAT (SPI G-B)',
			],
			'LIMBAH PADAT'=> [
				'LIMBAH PADAT^KADIV SAMPAH SPESIFIK' => 'KADIV SAMPAH SPESIFIK',
				'LIMBAH PADAT^KADIV SAMPAH DOMESTIK / RUMAH TANGGA' => 'KADIV SAMPAH DOMESTIK / RUMAH TANGGA',
			],'BIDANG CAIR, UDARA & PENUNJANG'=> [
				'BIDANG CAIR, UDARA & PENUNJANG^KADIV CAIR & UDARA ' => 'KADIV CAIR & UDARA',
				'BIDANG CAIR, UDARA & PENUNJANG^KADIV SAMPAH UDARA' => 'KADIV SAMPAH UDARA',
				'BIDANG CAIR, UDARA & PENUNJANG^KADIV PENUNJANG' => 'KADIV PENUNJANG',
			], 
			'SDM & UMUM'=> [
				'SDM & UMUM^PERSONALIA' => 'PERSONALIA',
				'SDM & UMUM^HUMAN RESOURCE (HR)' => 'HUMAN RESOURCE (HR)',
				'SDM & UMUM^UMUM' => 'UMUM'
			],
			'KEUANGAN'=> [
				'KEUANGAN^KEUANGAN' => 'KEUANGAN',
				'KEUANGAN^LOGISTIK' => 'LOGISTIK',
				'KEUANGAN^ACCOUNTING & HUTANG PIUTANG' => 'ACCOUNTING & HUTANG PIUTANG',
			], 
			'TEKNIK'=> [
				'TEKNIK^TEKNIK' => 'TEKNIK',
			],
			'BUSSINESS DEVELOPMENT'=> [
				'BUSSINESS DEVELOPMENT^WILAYAH TIMUR (Marketing)' => 'WILAYAH TIMUR (Marketing)',
				'BUSSINESS DEVELOPMENT^WILAYAH TIMUR (Customer Care)' => 'WILAYAH TIMUR (Customer Care)',
				'BUSSINESS DEVELOPMENT^WILAYAH TENGAH (Marketing)' => 'WILAYAH TENGAH (Marketing)',
				'BUSSINESS DEVELOPMENT^WILAYAH TENGAH (Customer Care)' => 'WILAYAH TENGAH (Customer Care)',
				'BUSSINESS DEVELOPMENT^WILAYAH BARAT (Marketing)' => 'WILAYAH BARAT (Marketing)',
				'BUSSINESS DEVELOPMENT^WILAYAH BARAT (Customer Care)' => 'WILAYAH BARAT (Customer Care)',
			],
			'KONSULTAN LEGAL'=> [
				'KONSULTAN LEGAL^KONSULTAN LEGAL' => 'KONSULTAN LEGAL',
			]
		];

		if (empty($data)) {
			return $view;
		}

		foreach ($view as $key => $val) {
			if (is_array($val)) {
				if (isset($val[$data])) {
					return $val[$data];
				}
			} elseif ($key === $data) {
				return $val;
			}
		}

		return null;
	}

	public function devision($data=null){
		// $view = array('PAJAK'=>'PAJAK', 'SEKPEM GROUP NUSANTARA' => 'SEKPEM GROUP NUSANTARA', 'SEKPEM GROUP WILAYAH TIMUR (SG-Tim)' => 'SEKPEM GROUP WILAYAH TIMUR (SG-Tim)', 'SEKPEM GROUP WILAYAH (SG-Teng)' => 'SEKPEM GROUP WILAYAH (SG-Teng)', 'SEKPEM GROUP WILAYAH BARAT (SG-B)' => 'SEKPEM GROUP WILAYAH BARAT (SG-B)', 'SPI GROUP NUSANTARA' => 'SPI GROUP NUSANTARA', 'SPI GROUP WILAYAH TIMUR (SPI G-Tim)'=>'SPI GROUP WILAYAH TIMUR (SPI G-Tim)', 'SPI GROUP WILAYAH TENGAH (SPI G-Teng)'=>'SPI GROUP WILAYAH TENGAH (SPI G-Teng)','SPI GROUP WILAYAH BARAT (SPI G-B)'=>'SPI GROUP WILAYAH BARAT (SPI G-B)', 'LIMBAH PADAT'=> 'LIMBAH PADAT', 'BIDANG CAIR, UDARA & PENUNJANG' => 'BIDANG CAIR, UDARA & PENUNJANG', 'SDM & UMUM' => 'SDM & UMUM', 'KEUANGAN' => 'KEUANGAN', 'TEKNIK' => 'TEKNIK', 'BUSSINESS DEVELOPMENT' => 'BUSSINESS DEVELOPMENT', 'KONSULTAN LEGAL' => 'KONSULTAN LEGAL', "Triata" => "Triata", "Artama Bali" => "Artama Bali", "Artama Ambon" => "Artama Ambon", "Bhakti Bumi Berseri" => "Bhakti Bumi Berseri", "RSU Bhakti Rahayu (Tabanan)" => "RSU Bhakti Rahayu (Tabanan)", "RSU Bhakti Rahayu (Denpasar)" => "RSU Bhakti Rahayu (Denpasar)", "Wilwatikta" => "Wilwatikta", "Pratama Jaya" => "Pratama Jaya", "BWC" => "BWC", "CTBL" => "CTBL", "Damar" => "PT. Damar", "CV Damar"=>"CV Damar", "KARFA" => "KARFA", "Koperasi" => "Koperasi", "MBDU" => "MBDU Bali", "Citra Gama Sakti" => "Citra Gama Sakti", "Klin" => "Klin", "Satria Buana Cemerlang Transportasi" => "Satria Buana Cemerlang Transportasi", "Satria Buana Cemerlang Dokling" => "Satria Buana Cemerlang Dokling & Ipal", "Satria Buana Cemerlang Makassar" => "Satria Buana Cemerlang Makassar", "Satria Buana Cemerlang Ambon" => "Satria Buana Cemerlang Ambon","Unilab" => "Unilab", "ANI" =>"Aksata Nusantara Infosysjaya", "Manunggal Bumi Lestari" => "Manunggal Bumi Lestari", "Satya Pratama Jaya" => "Satya Pratama Jaya", "Wilwa Developer" => "Wilwa Developer", "MBDU Surabaya" => "MBDU Surabaya", "PT. Satya Pratama Jaya Surabaya" => "PT. Satya Pratama Jaya Surabaya", "CV. Gotong Royong Jaya" => "CV. Gotong Royong Jaya", "CV. Angin Selatan" => "CV. Angin Selatan", "PT Unitlab Adi Cakra" => "PT Unitlab Adi Cakra", "Investasi" => "Investasi", "CV. Bakti Bumi Berseri" => "CV. Bakti Bumi Berseri");
		$view = array(
			'FARMASI' => 'FARMASI', 'SECURITY' => 'SECURITY', 'LABORATORIUM' => 'LABORATORIUM',
			'REKAM MEDIS' => 'REKAM MEDIS', 'PARKIR' => 'PARKIR', 'RAWAT JALAN' => 'RAWAT JALAN',
			'UGD' => 'UGD', 'CLEANING SERVICE' => 'CLEANING SERVICE', 'DRIVER' => 'DRIVER',
			'KASIR' => 'KASIR', 'RADIOLOGI' => 'RADIOLOGI', 'UBS' => 'UBS', 'KLAMER' => 'KLAMER',
			'KEBIDANAN & PERINATOLOGI' => 'KEBIDANAN & PERINATOLOGI', 'UPI' => 'UPI',
			'RAWAT INAP' => 'RAWAT INAP', 'GIZI' => 'GIZI', 'AHLI GIZI' => 'AHLI GIZI',
			'LAUNDRY' => 'LAUNDRY', 'LOGISTIK' => 'LOGISTIK', 'KEUANGAN' => 'KEUANGAN',
			'ATEM' => 'ATEM', 'KESLING' => 'KESLING', 'PROMKES' => 'PROMKES',
			'CASE MANAGER' => 'CASE MANAGER', 'TEKNISI' => 'TEKNISI', 'PUJASERA' => 'PUJASERA',
			'PT. BHAKTI RAHAYU' => 'PT. BHAKTI RAHAYU', 'MANAGERIAL' => 'MANAGERIAL', 'IT' => 'IT',
		);
		return (empty($data)) ? $view : ($view[$data] ?? null);
		// ,"Satria Buana Cemerlang Surabaya" => "Satria Buana Cemerlang Surabaya"
	}
	

	public function level($data = null)
    {
        $view = array("Basic" => "Basic", "Intermediate" => "Intermediate", "Advance" => "Advance", "Pro" => "Pro");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function sized($data = null)
    {
        $view = array("XS" => "XS", "S" => "S", "M" => "M", "L" => "L", "XL" => "XL", "XXL" => "XXL");
        $result = (empty($data)) ? $view : $view[$data];
        return $result;
    }

	public function descLeaves($data=null)
	{
		$view = array(
			'Pernikahan karyawan sendiri^3' => 'Pernikahan karyawan sendiri (3 hari)',
			'Pernikahan anak karyawan^2' => 'Pernikahan anak karyawan (2 hari)',
			'Pernikahan saudara kandung karyawan^1' => 'Pernikahan saudara kandung karyawan (1 hari)',
			'Istri karyawan melahirkan^2' => 'Istri karyawan melahirkan (2 hari)',
			'Suami / istri / anak / orang tua kandung / mertua / saudara kandung meninggal dunia^2' => 'Suami / istri / anak / orang tua kandung / mertua / saudara kandung meninggal dunia (2 hari)',
			'Kakek / nenek kandung karyawan meninggal^1' => 'Kakek / nenek kandung karyawan meninggal (1 hari)',
			'Pengkhitanan anak kandung karyawan^2' => 'Pengkhitanan anak kandung karyawan (2 hari)',
			'Pembaptisan anak kandung karyawan^2' => 'Pembaptisan anak kandung karyawan (2 hari)',
			'Lain-lain^1' => 'Lain-lain (1 hari)',
		);
		// $view = array('Pernikahan^3'=>'Pernikahan (3 hari)', 'Baptis Khitan^2'=>'Baptis/Khitan anak (2 hari)', 'Meninggal^2'=>'Orang tua/anak/istri/suami/mertua meninggal (2 hari)', 'Anggota lain meninggal^1'=>'Anggota keluarga lainnya yang serumah meninggal (1 hari)', 'Pernikahan Anak^2'=>'Pernikahan anak (2 hari)', 'Istri Melahirkan Keguguran^2'=>'Istri melahirkan/keguguran (2 hari)', 'Jaga Sakit^3'=>'Menjaga Orang tua/anak/istri/suami/mertua (3 hari)', 'Lain Lain^1'=>'Lain-lain');
		
		$result = (empty($data)) ? $view : $view[$data];
		return $result;
	}

	public function leaveTypes($data = null)
	{
		$view = array(
			'Umroh^14' => 'Umroh (14 hari)',
			'Haji^30' => 'Haji (1 bulan / 30 hari)',
			'Melahirkan^90' => 'Cuti Melahirkan (90 hari)',
			'Keguguran^45' => 'Cuti Keguguran (45 hari)'
		);

		return empty($data) ? $view : ($view[$data] ?? null);
	}

}
