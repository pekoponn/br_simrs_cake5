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
				<i class="fa fa-lock"></i>
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



<?php
/*
<div class="login login-with-news-feed">

	<div class="news-feed">
		<div class="news-image" style="background-image: url(<?= $this->Url->build(["controller" => "img", "action" => "login-bg", "login-bg1.jpg"], ['fullBase' => true]) ?>)"></div>
		<div class="news-caption">
			<h4 class="caption-title"><b><?= $this->Krs->companyName; ?></b></h4>
			<p>
			<?= $this->Krs->titleDesc; ?>
			</p>
		</div>
	</div>


	<div class="right-content bg-dark-darker">
		<div class="login-header">
			<div class="brand">
				<?php
		        echo $this->Html->image('/img/logo/logo.png', array('alt' => 'logo', 'border' => 0, 'fullBase' => true)); 
		        ?>				
				<small><?= $this->Krs->titleLogin; ?></small>
			</div>
			<div class="icon">
				<i class="fa fa-box-open"></i>
			</div>
		</div>
		<div class="login-content">
			<?= $this->Form->create(null, ['class'=>'margin-bottom-0']) ?>
			<div class="form-group m-b-15">
				<?= $this->Form->control('code', ['required' => true, 'class'=>'form-control form-control-lg',  'placeholder'=>'Kode', 'label' => false, 'title' => false, 'autocomplete' => 'off', 'autofocus'=>true]) ?>
			</div>
			<div class="form-group m-b-15">
				<?= $this->Form->control('password', ['required' => true, 'class'=>'form-control form-control-lg', 'label' => false, 'title' => false, 'placeholder'=>'Password', 'data-toggle'=>'password', 'data-placement'=>'after']) ?>
			</div>
			<div class="login-buttons">
				<?= $this->Form->submit('Login',['class'=>'btn btn-success btn-block btn-lg']); ?>
			</div>
			<hr />
			<p class="text-center text-grey-darker mb-0">
				<?= $this->Krs->footer(); ?>
			</p>
			<?= $this->Form->end() ?>
		</div>

	</div>

</div>
*/
?>