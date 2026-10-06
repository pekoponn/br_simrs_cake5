<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<?= $this->Krs->breadcrumb('User', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Halaman</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['controller' => 'users', 'action' => 'add'], ['class'=>'btn btn-inverse', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Add', 'escape' => false, 'fullBase'=>true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'templateExcel']); ?>">Contoh Excel</a>
                                <!-- <a class="dropdown-item" href="javascript:void(0);" id="btnDownloadExcel">Excel</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="btn-group pull-right">
                    <div class="portlet-body">
                        <?= $this->Form->create(null, ['type' => 'get']) ?>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari..." name="key" value="<?= $this->request->getQuery('key'); ?>">
                            <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>    -->
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-aqua">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->text('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->text('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Status...', 'empty' => 'Pilih status...','options' => $this->Krs->status() ,'value' => $this->request->getQuery('filterstatus')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Krs->btnSeach(); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="100">Kode</th>
                            <th width="120">Devisi</th>
                            <th width="120">Jabatan</th>
                            <th width="200">Nama</th>
                            <th width="150">Terakhir Login</th>
                            <th width="80">Status</th>
                            <th width="80">Kunjungan</th>
                            <th width="100">Pembuat</th>
                            <th width="200">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user):
                            $linkPreview = array('action' => 'access', $user->id);
                            //$linkPreview = array('action' => 'view', $user->id);
                            $linkEdit = array('action' => 'edit', $user->id);
                            $linkDelete = array('action' => 'delete', $user->id);
                            $linkResetPassword = array('action' => 'reset_password', $user->id);
                            $linkResetPin = array('action' => 'reset_pin', $user->id);
                            $userLastLogin = (empty($user->last_login)) ? '' : date_format($user->last_login, 'd-m-Y (H:m:i)');
                            $linkAddFace = array('action' => 'add_face', $user->id);
                            if($user->is_active == 'Y') {
                                $user->is_active = '<i class="fas fa-check text-success"></i>';
                            } else {
                                $user->is_active = '<i class="fas fa-times text-danger"></i>';
                            }

                            $btnAction = $this->Krs->btn('access', $linkPreview);
                            // $btnAction .= $this->Krs->btn('edit', $linkEdit);
                            $btnAction .= $this->Krs->btn('resetPassword', $linkResetPassword, $user->name);
                            // $btnAction .= $this->Krs->btn('resetPin', $linkResetPin, $user->name);
                            // $btnAction .= $this->Krs->btn('addFace', $linkAddFace, $user->name);
                            $btnAction .= $this->Html->link('<i class="fa fa-user-times"></i>', ['action' => 'resetFace', $user->id], ['class' => 'btn btn-pink btn-sm m-r-5 p-l-15 p-r-15 btn-reset-face', 'escape' => false, 'data-name' => $user->name, 'data-url' => $this->Url->build(['action' => 'resetFace', $user->id]), 'title' => 'Reset Wajah','data-original-title' => 'Reset Wajah']);
                            if ($checkUrl['users']['delete'] == '1') {
                                $btnAction .= $this->Krs->btn('delete', $linkDelete, $user->name);
                            }
                            ?>
                        <tr>
                            <td><?= h($user->code) ?></td>
                            <td><?= h($user->devision).'-'.h($user->sub_devision) ?></td>
                            <td align="center"><?= h($user->staff) ?></td>
                            <td><?= h($user->name) ?></td>                        
                            <td align="center"><?= $userLastLogin ?></td>
                            <td align="center"><?= $user->is_active ?></td>
                            <td align="center"><?= $this->Number->format($user->visited) ?></td>
                            <td align="center"><?= h($user->created_user->name ?? '-') ?> - <?= $user->created ? $user->created->format('d-m-Y (H:i:s)') : '-' ?></td>
                            <td class="actions text-center">
                                <?= $btnAction ?>                                   
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?= $this->Krs->paginators() ?>
        </div>
        <?php
        /*
        <?= $this->Krs->btn('delete', $linkDelete, $user->name) ?>
            <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>






        <div class="paginator">
            <ul class="pagination pagination-lg m-t-0 m-b-5">
                <li class="page-item"><?= $this->Paginator->first('<< ' . __('first')) ?></li>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
        */
        ?>
    </div>
</div>

<div class="table-toolbar">
    <div class="btn-group">
        <?= $this->Form->create($user, ['type' => 'file', 'url' => ['action' => 'exportExcel', 'save']]) ?>
        <?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
        <div class="portlet-body">
            <div class="note note-cyan">
                <div class="note-icon"><i class="fas fa-upload"></i></div>
                <div class="note-content text-end">                             
                    <h4><b>Upload <u>Data Users</u> melalui file Excel...</b></h4>
                    <?php
                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                    echo $this->Form->file('filename', array('label' => false, 'size' => '50'));                            
                    
                    echo $this->Form->button('Upload', ['class' => 'btn btn-primary', 'type' => 'button', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);
                    // echo $this->Form->button('Upload', ['class'=>'btn btn-primary', 'type'=>'submit', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);

                    // echo $this->Form->button('Upload', array('class'=>'btn btn-success', 'type'=>'button', 'escape' => false, 'id'=> 'btn-upload'));
                    // if(count($invoices) != 0){
                    //, $data['filterLink']
                    ?>
        
                    <div class="stats-desc text-danger"><i>Perhatian: Proses data akan disimpan langsung tanpa melalui filter.</i></div>
                    <?php
                    // }
                    ?>
                </div>
            </div> 
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script>
$(document).ready(function () {
    var confirmTitleUpload = "Apakah anda ingin mengupload data tersebut ?";
    var formActionUpload = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Users', 'action' => 'exportExcel', 'save'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupUploadForm', 'btn-upload', confirmTitleUpload, formActionUpload);
    $('.slc').select2({
        allowClear : true
    });
    $('.btn-reset-face').click(function (e) {
        e.preventDefault();
        let url = $(this).data('url');
        let name = $(this).data('name');
        SwalHelper.confirm('Apakah Anda yakin ingin menyimpan?', '', 'Ya, simpan', 'Batal').then((willDelete) => {
            if (willDelete) {
                window.location.href = url;
            }
        });
    });
});
</script>
