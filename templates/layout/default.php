<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'PT. Cargo';

$session = $this->request->getSession();
$sessionAuth = $session->read('Auth.id');
$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>    
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>
    
    <title>
        <?= $this->Krs->titleDesc.$this->Krs->companyName ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    
    <link href="<?php echo $this->Url->build('/css/fonts.googleapis.css?family=Open+Sans:300,400,600,700', ['fullBase' => true]); ?>" rel="stylesheet" />

    <?php echo $this->Html->css(['vendor.min', 'default/app.min', '/plugins/toastr/toastr', '/plugins/select2/dist/css/select2.min', '/plugins/bootstrap-daterangepicker/daterangepicker', '/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker', '/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min', '/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min', '/plugins/ion-rangeslider/css/ion.rangeSlider.min', '/plugins/tag-it/css/jquery.tagit', '/plugins/fullcalendar/lib/main.min', '/plugins/x-editable-bs4/dist/bootstrap4-editable/css/bootstrap-editable', '/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min', 'default/theme/orange.min', 'krs-ui', '/plugins/datatables2/css/jquery.dataTables.min'], ['fullBase' => true]) ?>
    <?php 
    if($controller=='Dashboard') {
        echo $this->Html->css(['/plugins/jvectormap-next/jquery-jvectormap', '/plugins/nvd3/build/nv.d3'], ['fullBase' => true]);
    }
    ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->script(['jquery.min', '/plugins/moment/min/moment.min'], ['fullBase' => true]) ?>
</head>
<body<?= ($sessionAuth) ? '':' class="pace-top"';?>>

    <?php
    if($sessionAuth) {
    ?>
    <div id="page-container" class="fade page-sidebar-minified page-header-fixed page-sidebar-fixed">        
        <?= $this->element('header') ?>
        <?= $this->element('sidebar') ?>
        <div id="content" class="content">            
            <?= $this->fetch('content') ?>            
        </div>
        <?= $this->element('footer') ?>
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>       
    </div>
   
    <?php
    } else {
    ?>
    <div id="content" class="content">
        <?= $this->fetch('content') ?>
    </div>
    <?php
    }
    ?>
    <?php echo $this->Html->script(['app.min', 'theme/default.min', '/plugins/toastr/toastr.min', '/plugins/sweetalert/dist/sweetalert.min', '/plugins/select2/dist/js/select2.full.min', '/plugins/bootbox/js/bootbox.min', '/plugins/jquery-validation/dist/jquery.validate.min', '/plugins/parsleyjs/dist/parsley.min', '/plugins/highlight.js/highlight.min', '/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker', '/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min', '/plugins/jquery.autoNumeric/jquery.autoNumeric', '/plugins/jquery.number/jquery.number', '/plugins/jquery.maskedinput/src/jquery.maskedinput', 'demo/render.highlight', 'ui-krs','/plugins/bootstrap-daterangepicker/daterangepicker','/plugins/fullcalendar/lib/main', '/plugins/form-plugins', '/plugins/bootstrap-show-password/dist/bootstrap-show-password', '/plugins/x-editable-bs4/dist/bootstrap4-editable/js/bootstrap-editable.min', '/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min', '/plugins/datatables2/js/jquery.dataTables.min', '/plugins/datatables2/js/button/dataTables.buttons.min.js', '/plugins/datatables2/js/button/jszip.min.js', '/plugins/datatables2/js/button/buttons.html5.min.js'], ['fullBase' => true]); ?>


    <?php 
    if($controller=='Dashboard') {
        echo $this->Html->script(['/plugins/d3/d3.min', '/plugins/nvd3/build/nv.d3.min', '/plugins/jvectormap-next/jquery-jvectormap.min', '/plugins/jvectormap-next/jquery-jvectormap-world-mill', '/plugins/apexcharts/dist/apexcharts.min'], ['fullBase' => true]);
    }
    ?>
   
    <?php
    if($action=='changePassword' || $action=='login') {
        echo $this->Html->script(['/plugins/bootstrap-show-password/dist/bootstrap-show-password'], ['fullBase' => true]);
    }
    ?>
    
    <?php
    // Agar terhindar dari Warning kehilangan CSRF Token
    echo $this->Html->scriptBlock(sprintf(
        'var csrfToken = %s;',
        json_encode($this->request->getAttribute('csrfToken'))
    ));
    
    $flashMessages = trim(strip_tags($this->Flash->render()));
    
    if (!empty($flashMessages)) { 
        list($flashTitle, $flashText) = explode(" : ", $flashMessages);
        if($flashTitle=='Berhasil') {
            $imgFlash = 'success.png';
            $statusFlash = 'success';
        } elseif($flashTitle=='Gagal') {
            $imgFlash = 'error.png';
            $statusFlash = 'error';
        } elseif($flashTitle=='Peringatan') {
            $imgFlash = 'warning.png';
            $statusFlash = 'warning';
        }
    ?>
    <script>
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "25000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        toastr["<?php echo $statusFlash; ?>"]("<?php echo $flashText; ?>");

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
</script>
   
<?php } ?> 

</body>
</html>
