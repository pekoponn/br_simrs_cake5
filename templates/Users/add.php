<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$dataChild = $this->Html->link('User', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb('Master', $dataChild, 'Baru') ?>
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
            echo $this->Form->control('code', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Kode..', 'value'=>'', 'data-parsley-required'=>'true']); ?>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Nama</label>
            <div class="col-md-4">
            <?php 
            echo $this->Form->control('name', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Nama..', 'value'=>'', 'data-parsley-required'=>'true']); ?>
            </div>
            <label class="col-form-label col-md-2">Sandi</label>
            <div class="col-md-4">
            <?php 
            echo $this->Form->control('passwordNew', ['label' => false, 'class'=>'form-control', 'placeholder'=>'Sandi..', 'value'=>'', 'data-parsley-required'=>'true', 'type'=>'password']); ?>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Cabang</label>
            <div class="col-md-3"><?php 
            echo $this->Form->control('branchId', ['empty'=>true, 'options' => $branches, 'label' => false, 'class'=>'form-control select2Form', 'multiple'=>true, 'data-placeholder'=>'Cabang..', 'data-parsley-required'=>'true', ' data-parsley-required-message'=>'Cabang tidak boleh kosong.']); ?><span id="custom-parsley-error"></span>
            </div>
        </div>        
    </div>
    <div class="panel-footer text-right bg-orange">
        <?php
        echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
        ?>        
    </div>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script(['jquery.min'], ['fullBase' => true]); ?>  
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'users', 'action' => 'add'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

    $(".select2Form").select2();
});
</script>
<?php
/*

var parsley_valiation_options = {
      errorTemplate: '<span class="error-msg"></span>',
      errorClass: 'error'
    }
    $('form').parsley(parsley_valiation_options)

    window.Parsley.on('field:error', function() {
      var element = $(this.$element);
      // This global callback will be called for any field that fails validation.
      //console.log('Validation failed for: ', this.$element);
      //If the select element is a dropkick select, then add error class to dropkick generated custom <div> element
      if ($(this.$element).hasClass('dropkick_select')) {
        //var el = $(element).siblings('div.dk-select').first();
        $('.dk-selected').addClass('error');
      }
    });
    //Initialize dropkick on the form select elements
    $(".dropkick_select").dropkick({
      change: function() {
        var select_elem = this.data.elem;
        var selected_value = this.value;
        //console.log("selected_value = "+selected_value);
        //if selected value is not blank and if validation error message is currently being displayed under the select element, then remove the error message
        if (selected_value != "" && $(select_elem).siblings('ul.parsley-errors-list').length > 0) {
          $(select_elem).siblings('ul.parsley-errors-list').children('span').remove();
        }
      }
    });


    
<?= $this->Html->script(['jquery.min', '/plugins/jquery-validation/dist/jquery.validate.min'], ['fullBase' => true]); ?>  
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'users', 'action' => 'add'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);
});
</script>
<script type="text/javascript">
$(function () {
  Parsley.addValidator('checkChildren', {
    messages: {en: 'You must correctly fill at least one of these blocks!'},
    requirementType: 'integer',
    validate: function(_value, requirement, instance) {
      for(var i = 1; i <= requirement; i++)
        if (instance.parent.isValid({group: 'block-' + i, force: true}))
          return true; // One section is filled, this check is valid
      return false; // No section is filled, this validation fails
    }
  });

  Parsley.on('form:submit', function() {
    alert("The form would be submitted at this point. " +
      "For this demo, we interrupt the processing.");
    return false; // Don't submit for this demo
  });

  $('.demo-form').parsley({
    inputs: Parsley.options.inputs + ',[data-parsley-check-children]'
  });
});
</script>
*/
?>


