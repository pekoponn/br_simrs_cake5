<div id="header" class="header navbar-inverse">
	<div class="navbar-header">
		<a href="" class="navbar-brand"><span>
		<?php
        echo $this->Html->image('/img/logo/logo.png', ['alt' => 'logo', 'border' => 0, 'fullBase' => true]); 
        ?></span></a>
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
				<?php echo $this->Html->link('Keluar', ['controller'=>'auth', 'action' => 'logout', 'full_base'=>true], ['escape' => false, 'class'=>'dropdown-item']); ?>
			</div>
		</li>
		<li class="dropdown"><?php echo $this->Html->link('<i class="fa fa-power-off"></i>', ['controller'=>'auth', 'action' => 'logout', 'full_base'=>true], ['escape' => false, 'class'=>'f-s-14']); ?></li>
	</ul>
</div>