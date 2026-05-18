<div id="header" class="header navbar-inverse">
	<div class="navbar-header">
		<a href="" class="navbar-brand"><span>
				<?php
				echo $this->Html->image('/img/logo/logo.png', ['alt' => 'logo', 'border' => 0, 'fullBase' => true]);
				?></span></a>
		<?php
		//<a href="index.html" class="navbar-brand"><span class="navbar-logo"></span> <b>Color</b> Admin</a>
		?>
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
				<input type="text" class="form-control" autocomplete="off" placeholder="Pencarian data ..." name="key"
					value="<?= $this->request->getQuery('key'); ?>">
				<button name="filter" class="btn btn-search" type="submit"><i class="fa fa-search"></i></button>
			</div>
			<?= $this->Form->end() ?>
		</li>
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php
				echo $this->Html->image("/img/logo/avatar-small.png", ["alt" => "", "border" => 0, 'fullBase' => true]);
				// $lastLoginDate = date('d M Y - H:i', strtotime($getUser->created));
				$lastLoginDate = !empty($getUser->last_login)
					? date_format($getUser->last_login, 'd M Y H:i')
					: '-';

				//$lastLoginDate = $getUser->created;
				//pr($getUser);
				//$lastLoginDate = $this->Time->format( $format = "d M Y H:i:s", $getUser->last_login);
				?>
				<span class="d-none d-md-inline"><?= $getUser->name ?></span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:;" class="dropdown-item"><small>Last login :
						<?php echo $lastLoginDate; ?></small></a>
				<div class="dropdown-divider"></div>
				<?php echo $this->Html->link('Keluar', ['controller' => 'auth', 'action' => 'logout', 'full_base' => true], ['escape' => false, 'class' => 'dropdown-item']); ?>
			</div>
		</li>
		<li class="dropdown">
			<?php echo $this->Html->link('<i class="fa fa-power-off"></i>', ['controller' => 'auth', 'action' => 'logout', 'full_base' => true], ['escape' => false, 'class' => 'f-s-14']); ?>
		</li>
	</ul>
</div>
<?php
/*
<a href="javascript:;" class="dropdown-item">Edit Profile</a>
			<a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">2</span> Inbox</a>
			<a href="javascript:;" class="dropdown-item">Calendar</a>
			<a href="javascript:;" class="dropdown-item">Setting</a>


	<a href="javascript:;" class="dropdown-item">Log Out</a>
	<li class="dropdown">
		<a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
			<i class="fa fa-bell"></i>
			<span class="label">5</span>
		</a>
		<div class="dropdown-menu media-list dropdown-menu-right">
			<div class="dropdown-header">NOTIFICATIONS (5)</div>
			<a href="javascript:;" class="dropdown-item media">
				<div class="media-left">
					<i class="fa fa-bug media-object bg-silver-darker"></i>
				</div>
				<div class="media-body">
					<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
					<div class="text-muted f-s-10">3 minutes ago</div>
				</div>
			</a>
			<a href="javascript:;" class="dropdown-item media">
				<div class="media-left">
					<img src="../assets/img/user/user-1.jpg" class="media-object" alt="" />
					<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
				</div>
				<div class="media-body">
					<h6 class="media-heading">John Smith</h6>
					<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
					<div class="text-muted f-s-10">25 minutes ago</div>
				</div>
			</a>
			<a href="javascript:;" class="dropdown-item media">
				<div class="media-left">
					<img src="../assets/img/user/user-2.jpg" class="media-object" alt="" />
					<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
				</div>
				<div class="media-body">
					<h6 class="media-heading">Olivia</h6>
					<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
					<div class="text-muted f-s-10">35 minutes ago</div>
				</div>
			</a>
			<a href="javascript:;" class="dropdown-item media">
				<div class="media-left">
					<i class="fa fa-plus media-object bg-silver-darker"></i>
				</div>
				<div class="media-body">
					<h6 class="media-heading"> New User Registered</h6>
					<div class="text-muted f-s-10">1 hour ago</div>
				</div>
			</a>
			<a href="javascript:;" class="dropdown-item media">
				<div class="media-left">
					<i class="fa fa-envelope media-object bg-silver-darker"></i>
					<i class="fab fa-google text-warning media-object-icon f-s-14"></i>
				</div>
				<div class="media-body">
					<h6 class="media-heading"> New Email From John</h6>
						<div class="text-muted f-s-10">2 hour ago</div>
				</div>
			</a>
			<div class="dropdown-footer text-center">
				<a href="javascript:;">View more</a>
			</div>
		</div>
	</li>

</ul>
*/
?>