<div id="header" class="header navbar-inverse">
	<div class="navbar-header">
		<a href="" class="navbar-brand">
			<span class="navbar-brand-logo">
				<?php
				echo $this->Html->image('/img/logo_br.png', [
					'alt' => 'logo',
					'border' => 0,
					'fullBase' => true,
					'class' => 'brand-logo-img'
				]);
				?>
			</span>
		</a>
		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<ul class="navbar-nav navbar-right">
		<li class="navbar-form">
			<?= $this->Form->create(null, ['type' => 'get']) ?>
			<div class="input-group">
				<input type="text" class="form-control" autocomplete="off" placeholder="Pencarian data ..." name="key" value="<?= $this->request->getQuery('key'); ?>">
				<button name="filter" class="btn btn-search" type="submit"><i class="fa fa-search"></i></button>
			</div>
			<?= $this->Form->end() ?>
		</li>
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php
				echo $this->Html->image("/img/logo/avatar-small.png", ["alt" => "", "border" => 0, 'fullBase' => true]);
				$lastLoginDate = date_format($getUser->last_login, 'd M Y H:m');
				?>
				<span class="d-none d-md-inline"><?= $getUser->name ?></span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:;" class="dropdown-item"><small>Last login : <?php echo $lastLoginDate; ?></small></a>
				<div class="dropdown-divider"></div>
				<?php echo $this->Html->link('Keluar', ['prefix' => false,'controller' => 'auth', 'action' => 'logout', 'full_base' => true], ['escape' => false, 'class' => 'dropdown-item']); ?>
			</div>
		</li>
		<li class="dropdown"><?php echo $this->Html->link('<i class="fa fa-power-off"></i>', ['prefix' => false, 'controller' => 'auth', 'action' => 'logout', 'full_base' => true], ['escape' => false, 'class' => 'f-s-14']); ?></li>
	</ul>
</div>

<style>
	.header.navbar-inverse .navbar-header .navbar-brand {
		display: flex !important;
		align-items: center !important;
		height: 100% !important;
		padding: 0 15px !important;
		overflow: hidden;
	}

	.header.navbar-inverse .navbar-header .navbar-brand-logo {
		display: inline-flex !important;
		align-items: center !important;
		height: 40px !important;
		overflow: hidden;
	}

	.header.navbar-inverse .navbar-header .brand-logo-img {
		max-height: 140px !important;
		height: 140px !important;
		width: auto !important;
		object-fit: contain !important;
		margin-top: 10px;
	}
</style>