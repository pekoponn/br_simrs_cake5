<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$dataChild = $this->Html->link('User', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb('Pengaturan', $dataChild, 'Akses') ?>
<?php
if(!empty($rules)) {

// Branch
$branch = $rules['branches'];
$branchIndex = ($branch['index']==1) ? 'checked' : '';
$branchAdd = ($branch['add']==1) ? 'checked' : '';
$branchEdit = ($branch['edit']==1) ? 'checked' : '';
$branchDelete = ($branch['delete']==1) ? 'checked' : '';

// Customer
$customer = $rules['customers'];
$customerIndex = ($customer['index']==1) ? 'checked' : '';
$customerAdd = ($customer['add']==1) ? 'checked' : '';
$customerEdit = ($customer['edit']==1) ? 'checked' : '';
$customerEditAdmin = ($customer['editAdmin']==1) ? 'checked' : '';
$customerXls = ($customer['xls']==1) ? 'checked' : '';
$customerXlsAll = ($customer['xlsAll']==1) ? 'checked' : '';
$customerXlsRekap = ($customer['xlsRekap']==1) ? 'checked' : '';
$customerDelete = ($customer['delete']==1) ? 'checked' : '';
$customerPreview = ($customer['preview']==1) ? 'checked' : '';
$customerBankData = ($customer['bankData']==1) ? 'checked' : '';
$customerUpload = ($customer['upload']==1) ? 'checked' : '';
$customerStatus = ($customer['status']==1) ? 'checked' : '';
$customerJumlahPengangkutanReport = ($customer['jumlahPengangkutanReport']==1) ? 'checked' : '';
$customerJumlahPengangkutanReportXls = ($customer['jumlahPengangkutanReportXls']==1) ? 'checked' : '';
$customerJumlahPengangkutanReportCs = ($customer['jumlahPengangkutanReportCs']==1) ? 'checked' : '';
$customerJumlahPengangkutanReportXlsCs = ($customer['jumlahPengangkutanReportXlsCs']==1) ? 'checked' : '';
$customerBeginningBalance = ($customer['beginningBalance']==1) ? 'checked' : '';
$customerBeginningBalanceXls = ($customer['beginningBalanceXls']==1) ? 'checked' : '';
$customerStatusPractice = ($customer['statusPractice']==1) ? 'checked' : '';

// User
$user = $rules['users'];
$userIndex = ($user['index']==1) ? 'checked' : '';
$userAdd = ($user['add']==1) ? 'checked' : '';
$userEdit = ($user['edit']==1) ? 'checked' : '';
$userAccess = ($user['access']==1) ? 'checked' : '';
$userResetPassword = ($user['resetPassword']==1) ? 'checked' : '';
$userDelete = ($user['delete']==1) ? 'checked' : '';
$userAddFace = ($user['addFace']==1) ? 'checked' : '';

// Setting
$setting = $rules['settings'];
$settingAdd = ($setting['add']==1) ? 'checked' : '';
$settingEdit = ($setting['edit']==1) ? 'checked' : '';
$settingIndex = ($setting['index']==1) ? 'checked' : '';

}
?>
<?= $this->Form->create($users) ?>
<div class="row">
    <!-- begin col-6 -->
    <div class="col-lg-4">
        <div class="panel panel-inverse">
            <div class="panel-heading">
            <h4 class="panel-title">Perincian</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
            </div>            
            <div class="panel-body">                
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Code</label>
                    <div class="col-md-9">
                    <?php
                    echo $this->Form->control('id', array('type' => 'hidden', 'value' => $users->id));
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                    echo $this->Form->control('code', ['label' => false, 'class'=>'form-control-plaintext', 'placeholder'=>'Kode..', 'value'=>$users->code, 'disabled'=>true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Nama</label>
                    <div class="col-md-9">
                    <?php
                    echo $this->Form->control('name', ['label' => false, 'class'=>'form-control-plaintext', 'placeholder'=>'Nama..', 'value'=>$users->name, 'disabled'=>true]);
                    ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Telp</label>
                    <div class="col-md-9">
                    <?php
                    echo $this->Form->control('telp', ['label' => false, 'class'=>'form-control-plaintext', 'placeholder'=>'Telp..', 'value'=>$users->telp, 'readonly'=>true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Email</label>
                    <div class="col-md-9">
                    <?php
                    echo $this->Form->control('email', ['label' => false, 'class'=>'form-control-plaintext', 'placeholder'=>'Email..', 'value'=>$users->email, 'disabled'=>true]); ?>
                    </div>
                </div>
                <div class="form-group row m-b-15 align-items-center">
                    <label class="col-form-label col-md-3">Aktif</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                        <?php
                        $checkedBlock = ($users->is_active=='Y') ? "checked":false;
                        echo $this->Form->hidden('is_active', array('value' => 'N'));
                        echo $this->Form->input('is_active', array('hiddenField'=>false, 'value' => 'Y', 'id'=>'defaultCheckbox', 'type' => 'checkbox', 'class'=>'form-check-input', 'checked'=>$checkedBlock));
                        ?>
                        <label class="form-check-label" for="defaultCheckbox">&nbsp;</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Staff</label>
                    <div class="col-md-9">
                        <?php
                        $dataStaff = $this->Krs->position();
                        echo $this->Form->control('staff', ['label' => false, 'empty' => false, 'options'=>$dataStaff, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'error' => false, "default"=> $users->staff]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Devisi</label>
                    <div class="col-md-9">
                        <?php
                        $dataDevision = $this->Krs->devision();
                        echo $this->Form->control('devision', ['label' => false, 'empty' => false, 'options'=>$dataDevision, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'error' => false, "default"=> $users->devision]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">UBS SCM</label>
                    <div class="col-md-9">
                        <?php
                        $dataProject = $this->Krs->dataUbs();
                        echo $this->Form->control('ubs', ['label' => false, 'empty' => false, 'options'=>$dataProject, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'error' => false, "default"=> $users->ubs]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">UBS</label>
                    <div class="col-md-9">
                        <?php
                        $dataProject = $this->Krs->businessUnit();
                        echo $this->Form->control('project', ['label' => false, 'empty' => false, 'options'=>$dataProject, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'error' => false, "default"=> $users->project]);
                        ?>
                    </div>
                </div>
                <div class="form-group row m-b-15 align-items-center">
                    <label class="col-form-label col-md-3">UBS Status</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                        <?php
                        $checkedProject = ($users->project_status=='Y') ? "checked":false;
                        echo $this->Form->checkbox('projectStatus', array('hiddenField'=>'N', 'value' => 'Y', 'id'=>'defaultCheckbox', 'class'=>'form-check-input', 'checked'=>$checkedProject));
                        ?>
                        <label class="form-check-label" for="defaultCheckbox">Full Akses</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-md-3 col-form-label">Petty Cash</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedApproved1 = ($users->approved=='Y') ? "checked":false;
                            echo $this->Form->checkbox('approved', array('hiddenField'=>'N', 'value' => 'Y', 'id'=>'checkbox-inline-1', 'class'=>'form-check-input', 'checked'=>$checkedApproved1));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-1">Approved 1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedApproved2 = ($users->approvedCeo=='Y') ? "checked":false;
                            echo $this->Form->checkbox('approvedCeo', array('hiddenField'=>'N', 'value' => 'Y', 'id'=>'checkbox-inline-2', 'class'=>'form-check-input', 'checked'=>$checkedApproved2));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-2">Approved 2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedPayment = ($users->payment=='Y') ? "checked":false;
                            echo $this->Form->checkbox('payment', array('hiddenField'=>'N', 'value' => 'Y', 'id'=>'checkbox-inline-3', 'class'=>'form-check-input', 'checked'=>$checkedPayment));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-3">Pembayaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <?php
                            $checkedFullAccess = ($users->pettycash_full_access=='Y') ? "checked":false;
                            echo $this->Form->checkbox('pettycash_full_access', array('hiddenField'=>'N', 'value' => 'Y', 'id'=>'checkbox-inline-4', 'class'=>'form-check-input', 'checked'=>$checkedFullAccess));
                            ?>
                            <label class="form-check-label" for="checkbox-inline-4">Full Akses</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row m-b-15">
                    <label class="col-form-label col-md-3">Cabang</label>
                    <div class="col-md-9">
                        <?php
                        $dataBranch = explode(",", $users->branch_id);
                        echo $this->Form->control('branch_ids', array('label' => false, 'empty' => false, 'options'=>$rowBranch, 'data-placeholder'=>'Cabang..', 'class'=>'form-control select2Form', 'error' => false, 'multiple' => true, "default"=> $dataBranch));
                        ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right bg-orange">
            <?php
            // Hidden Dashboard
            echo $this->Form->control('Rules.dashboard.index', ['type' => 'hidden', 'value' =>  '1']);

            // Hidden User
            echo $this->Form->control('Rules.auth.index', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.daerahkabupatens.getList', ['type' => 'hidden', 'value' =>  '1']);
            
            echo $this->Form->control('Rules.auth.login', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.auth.logout', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.users.changePassword', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.users.status', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.account.login', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.users.home', ['type' => 'hidden', 'value' =>  '1']);

            // Hidden Branch
            echo $this->Form->control('Rules.branches.getData', ['type' => 'hidden', 'value' =>  '1']);

            //Hidden Customer
            echo $this->Form->control('Rules.customers.getLastNumber', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.customers.getSearch', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.customers.getAjaxType', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.customers.getKabupaten', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.customers.getCustomerForManifest', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.customers.getData', ['type' => 'hidden', 'value' =>  '1']);
            echo $this->Form->control('Rules.customers.jumlahPengangkutanReportCsSave', ['type' => 'hidden', 'value' =>  '1']);

            echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
            ?>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <ul class="nav nav-tabs nav-tabs-inverse">
            <li class="nav-item">
                <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                    <span class="d-sm-none">Data</span>
                    <span class="d-sm-block d-none">Data</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Cetak</span>
                    <span class="d-sm-block d-none">Cetak</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Laporan</span>
                    <span class="d-sm-block d-none">Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Master</span>
                    <span class="d-sm-block d-none">Master</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#default-tab-5" data-toggle="tab" class="nav-link">
                    <span class="d-sm-none">Pengaturan</span>
                    <span class="d-sm-block d-none">Pengaturan</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- begin tab-pane -->
            <div class="tab-pane fade active show" id="default-tab-1">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="default-tab-2">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <!-- end tab-pane -->
            <div class="tab-pane fade" id="default-tab-3">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="default-tab-4">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Customer</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.index', ['value' => '1', 'hiddenField' => true, 'checked' => $customerIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.preview', ['value' => '1', 'hiddenField' => true, 'checked' => $customerPreview, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Tampilkan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.upload', ['value' => '1', 'hiddenField' => true, 'checked' => $customerUpload, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Upload</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.add', ['value' => '1', 'hiddenField' => true, 'checked' => $customerAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $customerEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.editAdmin', ['value' => '1', 'hiddenField' => true, 'checked' => $customerEditAdmin, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah(admin)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.xls', ['value' => '1', 'hiddenField' => true, 'checked' => $customerXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.xlsAll', ['value' => '1', 'hiddenField' => true, 'checked' => $customerXlsAll, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Excel Semua</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.xlsRekap', ['value' => '1', 'hiddenField' => true, 'checked' => $customerXlsRekap, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Rekap Excel</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $customerDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.bankData', ['value' => '1', 'hiddenField' => true, 'checked' => $customerBankData, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">data Bank</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.status', ['value' => '1', 'hiddenField' => true, 'checked' => $customerStatus, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.beginningBalance', ['value' => '1', 'hiddenField' => true, 'checked' => $customerBeginningBalance, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Awal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.beginningBalanceXls', ['value' => '1', 'hiddenField' => true, 'checked' => $customerBeginningBalanceXls, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Saldo Awal (Excel)</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.customers.statusPractice', ['value' => '1', 'hiddenField' => true, 'checked' => $customerStatusPractice, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Status (Hari & Jam Praktek)</label>
                                    </div>

                                </div>
                            </td>
                        </tr>                 
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="default-tab-5">
                <table class="table table-striped m-b-0 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="180">Halaman</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Cabang</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.index', ['value' => '1', 'hiddenField' => true, 'checked' => $branchIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.add', ['value' => '1', 'hiddenField' => true, 'checked' => $branchAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $branchEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.branches.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $branchDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Seting</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.settings.index', ['value' => '1', 'hiddenField' => true, 'checked' => $settingIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.settings.add', ['value' => '1', 'hiddenField' => true, 'checked' => $settingAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.settings.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $settingEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>User</td>
                            <td>
                                <div class="col-md-12">
                                    <div class="form-check form-check-inline">
                                        <?php                                       
                                        echo $this->Form->checkbox('Rules.users.index', ['value' => '1', 'hiddenField' => true, 'checked' => $userIndex, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Daftar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.add', ['value' => '1', 'hiddenField' => true, 'checked' => $userAdd, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Baru</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.edit', ['value' => '1', 'hiddenField' => true, 'checked' => $userEdit, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Ubah</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.access', ['value' => '1', 'hiddenField' => true, 'checked' => $userAccess, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hak Akses</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.resetPassword', ['value' => '1', 'hiddenField' => true, 'checked' => $userResetPassword, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Reset Sandi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.delete', ['value' => '1', 'hiddenField' => true, 'checked' => $userDelete, 'class'=>'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Hapus</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <?php
                                        echo $this->Form->checkbox('Rules.users.addFace', ['value' => '1', 'hiddenField' => true, 'checked' => $userAddFace, 'class' => 'form-check-input']);
                                        ?>
                                        <label class="form-check-label">Menambahkan Wajah</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
<script>
$(document).ready(function () {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['controller'=>'users', 'action' => 'access', $users->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('UserAddForm', 'btn-add', confirmTitle, formAction);

    $(".select2Form").select2();

    $(".select2FormClear").select2({
        allowClear : true,
        placeholder : 'Silakan pilih..'
    });

});
</script>