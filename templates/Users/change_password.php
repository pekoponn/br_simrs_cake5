<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$dataChild = $this->Html->link('User', ['action' => 'index'], ['full_base'=>true]);
//pr($user);
?>

<?= $this->Krs->breadcrumb('Pengaturan', $dataChild, 'Ganti Password') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <?= $this->Form->create($user, ['data-parsley-validate'=>'true']) ?>
    <div class="panel-body">        
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kode</label>
            <div class="col-md-2">
            <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
            echo $this->Form->control('code', ['label' => false, 'class'=>'form-control-plaintext', 'placeholder'=>'Kode..', 'value'=>$user->code, 'disabled'=>true]); ?>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Nama</label>
            <div class="col-md-4">
            <?php 
            echo $this->Form->control('name', ['label' => false, 'class'=>'form-control-plaintext', 'placeholder'=>'Nama..', 'value'=>$user->name, 'disabled'=>true]); ?>
            </div>            
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Sandi</label>
            <div class="col-md-4">
            <?php 
            echo $this->Form->control('passwordNew', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Sandi..', 'value'=>'', 'data-parsley-required'=>'true', 'type'=>'password', 'id'=>'password', 'data-toggle'=>'password', 'data-placement'=>'after']); ?>
            </div>
        </div> 
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Ulangi Sandi</label>
            <div class="col-md-4">
            <?php 
            echo $this->Form->control('retype_password', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Ulangi Sandi..', 'value'=>'', 'data-parsley-required'=>'true', 'type'=>'password', 'id'=>'confirm_password', 'data-toggle'=>'password', 'data-placement'=>'after']); ?>
            <small class="f-s-12 text-orange" id='message'></small>
            </div>            
        </div>
        <p class="text-success">*Setelah <b>Ganti Password</b> harap Logout dan Login kembali dengan password yang baru untuk menghindari kesalahan <b>Password</b>*</p>   
    </div>
    <div class="panel-footer text-right bg-orange">
        <?php
        echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
        ?>        
    </div>
    <?= $this->Form->end() ?>
</div>
<script>
$(document).ready(function() {
    "use strict";

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'users', 'action' => 'change_password', $user->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

    $('#confirm_password').on('keyup', function () {
        if (document.getElementById('password').value ==document.getElementById('confirm_password').value) {
            document.getElementById("confirm_password").style.borderColor = "lime";
            document.getElementById('btn-add').disabled = false;
            document.getElementById('message').innerHTML = 'Terima kasih, sandi sesuai';
        } else{
            document.getElementById("confirm_password").style.borderColor = "red";
            document.getElementById('btn-add').disabled = true;
            document.getElementById('message').innerHTML = 'Maaf, sandi tidak cocok!!';
        }
    });

});
</script>