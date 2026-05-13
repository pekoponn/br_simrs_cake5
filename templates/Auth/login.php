<div class="login-cover">
	<div class="login-cover-image" style="background-image: url(<?= $this->Url->build(["controller" => "img", "action" => "login-bg", $this->Krs->loginBg], ['fullBase' => true]) ?>)" data-id="login-cover-image"></div>
	<div class="login-cover-bg"></div>
</div>

<div id="page-container" class="fade">
	<div class="login login-v2" data-pageload-addclass="animated fadeIn">
		<div class="login-header">
			<div class="brand">
				<?php
		        echo $this->Html->image('/img/logo/logo.png', array('alt' => 'logo', 'border' => 0, 'fullBase' => true)); 
		        //<span class="logo"></span> <b><?= $this->Krs->companyName; ?>
				<small><?= $this->Krs->titleLogin; ?></small>
			</div>
			<div class="icon">
				<i class="fa fa-unlock"></i>
			</div>
		</div>
		<div class="login-content">
			<?= $this->Form->create(null, ['class'=>'margin-bottom-0']) ?>
			<div class="form-group m-b-20">
				<?= $this->Form->control('code', ['required' => true, 'class'=>'form-control form-control-lg',  'placeholder'=>'Kode', 'label' => false, 'title' => false, 'autocomplete' => 'off', 'autofocus'=>true]) ?>
			</div>
			<div class="form-group m-b-20">
				<?= $this->Form->control('password', ['required' => true, 'class'=>'form-control form-control-lg', 'label' => false, 'title' => false, 'placeholder'=>'Password', 'data-toggle'=>'password', 'data-placement'=>'after']) ?>
			</div>
			<div class="login-buttons">
				<?= $this->Form->submit('Login',['class'=>'btn btn-success btn-block btn-lg']); ?>
			</div>
			<div class="text-center text-grey-darker m-t-20">
				<?= $this->Krs->footer(); ?>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>