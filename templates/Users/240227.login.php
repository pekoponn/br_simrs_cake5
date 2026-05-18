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