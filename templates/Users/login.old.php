<div class="login-cover">
	<div class="login-cover-image" style="background-image: url(<?= $this->Url->build(["controller" => "img", "action" => "login-bg", "login-bg1.jpg"], ['fullBase' => true]) ?>)" data-id="login-cover-image"></div>
	<div class="login-cover-bg"></div>
</div>

<!--  class="fade" -->
<div id="page-container">
	<div class="login login-v2 users form" data-pageload-addclass="animated fadeIn">
		<div class="login-header">
			<div class="brand">
				<?php
		        echo $this->Html->image('/img/logo/logo.png', array('alt' => 'logo', 'border' => 0, 'fullBase' => true)); 
		        ?>
				
				<small>Sistem Informasi DBU</small>
			</div>
			<div class="icon">
				<i class="fa fa-unlock"></i>
			</div>
		</div>

<?php
//<span class="logo"></span> <b>BDU</b> Cpanel
// $name = $this->request->getSession()->read('User.name');
// // If you are accessing the session multiple times,
// // you will probably want a local variable.
// $session = $this->request->getSession();
// $name = $session->read('User.name');

// $session = $this->request->getSession();
// pr($name);
//echo '<div class="alert alert-danger fade show m-b-15"><strong>Info :</strong>'.$this->Flash->render().'</div>';
?>
<div class="login-content">
	
	<?= $this->Form->create(null, ['class'=>'margin-bottom-0']) ?>
	<!-- <form action="https://seantheme.com/color-admin/admin/html/index.html" method="GET" class="margin-bottom-0"> -->
	<div class="form-group m-b-20">
		<?= $this->Form->control('code', ['required' => true, 'class'=>'form-control form-control-lg',  'placeholder'=>'Kode', 'label' => false, 'title' => false, 'autocomplete' => 'off', 'autofocus'=>true]) ?>
	</div>
	<div class="form-group m-b-20">
		<?= $this->Form->control('password', ['required' => true, 'class'=>'form-control form-control-lg', 'label' => false, 'title' => false, 'placeholder'=>'Password', 'data-toggle'=>'password', 'data-placement'=>'after']) ?>
	</div>
<div class="login-buttons">
	<?= $this->Form->submit(__('Login'),['class'=>'btn btn-success btn-block btn-lg']); ?>
</div>
<div class="m-t-20">
	BDU&#8482; sib v.2 &copy; <?php echo "2020&#126;".date("Y"); ?>
</div>
<?= $this->Form->end() ?>
</div>