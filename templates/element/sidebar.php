<?php
// Memanggil action yang aktif
$action = $this->request->getParam('action');

// Memanggil controller yang aktif
$controller = $this->request->getParam('controller');

$menuDashboard = ($controller=='Dashboard')?' class="active"':'';
$menuUserChangePassword = ($controller=='Users' && $action=='changePassword') ? ' class="active"' : '';

$branch = (isset($checkUrl['branches'])) ? $checkUrl['branches'] : array();
$customer = (isset($checkUrl['customers'])) ? $checkUrl['customers'] : array();
$settings = (isset($checkUrl['settings'])) ? $checkUrl['settings'] : array();
$users = (isset($checkUrl['users'])) ? $checkUrl['users'] : array();
?>
<div class="sidebar-bg"></div>
<div id="sidebar" class="sidebar">
	<div data-scrollbar="true" data-height="100%">
		<ul class="nav">
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			<li<?= $menuDashboard ?>>
				<?= $this->Html->link('<i class="fas fa-home"></i><span>Beranda</span>', ['controller' => 'Dashboard', 'action' => 'index'], ['escape' => false]) ?>
			</li>
			<?php
			
			if($customers['index']==1) {

				$menuDataLink = ($getController=='customers')?'active':'';

				$menuMasterCustomer = ($getController=='customers')?' class="active"':'';				
			?>
			<li class="has-sub <?php echo $menuDataLink; ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fas fa-database"></i>
					<span>Master</span>
				</a>
				<ul class="sub-menu">
					<?php
					if($customers['index']==1) {
					?>
	                    <li <?= $menuMasterCustomer ?>><?= $this->Html->link('Pelanggan', ['controller' => 'Customers', 'action' => 'index'], ['fullBase' => true, 'escape' => false]) ?>
	                    </li>
	                <?php 
	            	}
					?>
				</ul>
			</li>
			<?php
			}

			if($users['changePassword']==1 || $users['resetPassword']==1  || $users['access']==1 || $users['index']==1 || $settings['index']==1 || $branch['index']==1){

				$menuSetting = ($getController=='users' || $getController=='settings' || $getController=='branches')?'active':'';		

				$menuUser = ($getController=='users' && ($getAction=='index' || $getAction=='add' || $getAction=='edit' || $getAction=='resetPassword' || $getAction=='access'))?' class="active"':'';
				$menuChangePassword = ($getController=='users' && $getAction=='changePassword')?' class="active"':'';
				$menuBranches = ($getController=='branches' && $getAction=='index') ? 'class="active"' : '';
				$menuSettings = ($getController=='settings' && $getAction=='index')?' class="active"':'';			
			?>

			<li class="has-sub <?= $menuSetting ?>">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cog"></i>
					<span>Pengaturan</span>
				</a>
				<ul class="sub-menu">
					<li<?= $menuChangePassword ?>><?= $this->Html->link('Ganti Password', ['controller' => 'Users', 'action' => 'changepassword',$getUser->id], ['fullBase'=>true, 'escape' => false]) ?></li>
					<?php
					if($users['index']==1){
					?>
					<li<?= $menuUser ?>><?= $this->Html->link('User', ['controller' => 'Users', 'action' => 'index'], ['fullBase'=>true, 'escape' => false]) ?></li>
					<?php 
					}
					if($branch['index']==1){
					?>
					<li<?= $menuBranches ?>><?= $this->Html->link('Cabang', ['controller' => 'Branches', 'action' => 'index'], ['fullBase'=>true, 'escape' => false]) ?></li>
					<?php 
					}
					if($settings['index']==1){
					?>
					<li<?= $menuSettings ?>><?= $this->Html->link('Perusahaan', ['controller' => 'Settings', 'action' => 'edit/1'], ['fullBase'=>true, 'escape' => false]) ?></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
		</ul>
	</div>
</div>