<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer[]|\Cake\Collection\CollectionInterface $customers
 */
?>
<?= $this->Krs->breadcrumb('Master', 'Pelanggan', 'Tampilkan') ?>
<div class="panel">
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime">Download</a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-download"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdf']); ?>">Excel File</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="panel-body bg-aqua">
                <div class="row">
                    <div class="col-md-2">
                        <?= $this->Form->text('filtercode', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Kode...', 'value' => $this->request->getQuery('filtercode')]); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->text('filtername', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Nama...', 'value' => $this->request->getQuery('filtername')]); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $this->Form->control('filtermarketing', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Marketing...', 'empty' => 'Pilih status...', 'options' => $marketings, 'value' => $this->request->getQuery('filtermarketing')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->control('filterpajak', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Pajak...', 'empty' => 'Pilih pajak...', 'options' => $this->Krs->statustax(), 'value' => $this->request->getQuery('filterpajak')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->control('filterstatus', ['label' => false, 'class' => 'form-control slc', 'data-placeholder' => 'Status...', 'empty' => 'Pilih status...', 'options' => $this->Krs->status(), 'value' => $this->request->getQuery('filterstatus')]); ?>
                    </div>
                    <div class="col-md-1">
                        <?= $this->Form->button('Cari', ['class' => 'btn btn-yellow btn-block', 'type' => 'submit']); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle cs">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Kode</th>
                            <th width="300">Nama<br>(Nama Invoice)<br>(Saldo Awal)</th>
                            <th width="170">No. Virtual Account</th>
                            <th>Marketing</th>
                            <th class="text-center">Pajak</th>
                            <th class="text-center">Status</th>
                            <th class="with-btn text-center" nowrap width="150"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (count($customers) > 0) {
                            foreach ($customers as $index => $data) :
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $dataSts = ($data->is_active == 'Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                                $customerName = $data->title.' '.$data->name;
                                $beginningBalance = ($data->beginning_balance>0) ? '<br><b>Saldo Awal : </b><i>'.$this->Krs->nominal($data->beginning_balance).'</i>' : '';
                                $dataNameInvoice = $data->name_invoice;
                                $mouName  = (!empty($data->mouses->name)) ? $data->mouses->name : '-';
                                $mouDateExpired = (!empty($data->mouses->date_expired)) ? $this->Time->format('d M Y', $data->mouses->date_expired) : '-';
                                ///$mouDateExpired = (!empty($data->mouses->date_expired) : '-';

                                $dataVa = (empty($data->va)) ? "" : '<b>VA : </b><i>'.$data->va.'</i>';
                                $mouCode = $mouName." (<b>Exp: </b>".$mouDateExpired.")";
                        ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td><?= $data->code ?></td>
                                    <td><?php echo '<b>'.$customerName.'</b>'.$beginningBalance.'<br><b>Nama Invoice : </b><i>'.$dataNameInvoice.'</i><br><b>No.MOU : </b>'.$mouCode.'<br>'.$dataVa.$showPractice.$hidePractice.$statusPractice.$showDataPractice; ?></td>
                                    <td><?= $data->va_no ?></td>
                                    <td><?= $data->user->name ?></td>
                                    <td class="text-center"><?= $data->name_tax_invoice != "" ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
                                    <td class="text-center">
                                        <div id='statusSpin<?= $data->id ?>'></div>
                                        <div id='statusActive<?= $data->id ?>' style=""><a href="javascript:;" id="link<?= $data->id ?>" onclick="changeStatus({'id' : <?= $data->id ?>, 'status' : <?= $data->active ?>, 'is_update' : <?= $getUser->id ?> })" class="btn <?= $data->active ==  "1" ? "btn-lime" : "btn-danger"; ?> btn-icon btn-circle btn-sm"><i id="icon<?= $data->id ?>" class="<?= $data->active ==  "1" ? "fa fa-check" : "fa fa-times"; ?>"></i></a></div>
                                    </td>
                                    <td class="with-btn" nowrap>
                                        <?= $this->Krs->btn('preview', $linkPreview, $data['id']); ?>
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                        <?= $this->Krs->btn('delete', $linkDelete, $data->name) ?>
                                    </td>
                                </tr>
                        <?php $no++;
                            endforeach;
                        } else {
                            echo $this->Krs->dataNull();
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?= $this->Krs->paginators() ?>
        </div>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                  <div class="portlet-body">
                    <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add'], ['class'=>'btn btn-inverse', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Add', 'escape' => false, 'fullBase'=>true]) ?>
                    <?= $this->Html->link('<i class="fa fa-download"></i>', ['action' => 'pdf'], ['class'=>'btn btn-green', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Download', 'escape' => false, 'fullBase'=>true]) ?>
                  </div>
                </div>
                <div class="btn-group pull-right">
                    <div class="portlet-body">
                       <?= $this->Form->create(null, ['type' => 'get']) ?>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari..." name="key" value="<?= $this->request->getQuery('key'); ?>">
                            <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div> 

            </div>
            <br>
            <?php
            /*echo $this->Form->create("Customer", array(
                "url" => array('event_id' => $uuid, "controller"=>"customers", "action" => "index"), "class" => "form-horizontal", "inputDefaults" => array(
                "label" => false, "div" => false
                    )
                ));*/
            ?>

            <?php /*echo $this->Search->create(); ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                            <div class="input-group">
                            <?php 
                            echo $this->Search->input('filterCode', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Kode..'));
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-b-10">
                            <?php
                            echo $this->Search->input('filterName', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Nama..'));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                            <?php
                            //echo $this->Search->input('title', array('options'=>$this->Krs->titleCustomer(), 'class'=>'form-control select2', 'data-placeholder'=>'Title..', 'title'=>"Title tidak boleh kosong!", 'required'=>true, "data-parsley-required"=>true));

                            echo $this->Search->input('filterTitle', array('class' => 'form-control select2FormClear', 'required' => false, 'data-placeholder'=>'Jenis..', 'empty'=>true));
                            //echo $this->Search->input('filterMarketing', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Marketing..', 'empty'=>true));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                            <?php
                            echo $this->Search->input('filterTitleGroup', array('class' => 'form-control select2FormClear', 'required' => false, 'data-placeholder'=>'Cari Jenis Pelanggan..', 'empty'=>true));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                            <?php
                            echo $this->Search->input('filterMarketing', array('class' => 'form-control select2FormClear', 'required' => false, 'data-placeholder'=>'Marketing..', 'empty'=>true));
                            //echo $this->Search->input('filterMarketing', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Marketing..', 'empty'=>true));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Search->input('filterTax', array('class' => 'form-control select2FormClear', 'required' => false, 'data-placeholder'=>'Pajak..', 'empty'=>true));

                        //echo $this->Search->input('filterTax', array('class' => 'form-control select2-clear', 'required' => false, 'data-placeholder'=>'Pajak..', 'empty'=>true));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Search->input('filterKab', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Kabupaten..'));

                        //echo $this->Search->input('filterTax', array('class' => 'form-control select2-clear', 'required' => false, 'data-placeholder'=>'Pajak..', 'empty'=>true));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Search->input('filterIsActive', array('class' => 'form-control select2FormClear', 'required' => false, 'data-placeholder'=>'Status..', 'empty'=>true));
                        //echo $this->Search->input('filterIsActive', array('class' => 'form-control select2-clear', 'id' => 'maxlength_defaultconfigwW', 'required' => false, 'data-placeholder'=>'Aktif..', 'empty'=>true));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Search->button('<i class="fas fa-search"></i>', array('name' => 'filter', 'class' => 'btn btn-warning width-60 m-r-10', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Cari', 'type' => 'submit'), array('escape' => 'false'));

                        //echo $this->Search->button('<i class="fash-60 m-r-10', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Cari', 'type' => 'submit'), array('escape' => 'false'));
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $this->Search->end(); 
            */
            ?>


            <!-- begin table-responsive -->
            <div class="table-responsive">
                <table class="table table-striped m-b-5 table-advance table-hover">
                    <thead>
                        <tr>
                            <th width="60">Kode</th>
                            <th>Nama<br>(Nama Invoice)<br>(Saldo Awal)</th>
                            <th width="120">Pajak</th>
                            <th width="50">Aktif</th>
                            <th width="150">Admin<br>Marketing</th>
                            <th width="150">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //pr($data['rows']);
                        // pr($customers);
                        if(is_array($customers)){
                            $rows = array();
                            foreach ($customers as $views){
                               pr($views);
                                $row = $views->customers;
                                $mou = $views->mouses;
                                $userAdmin = $views->users;

                                // $dataMous = Set::combine($mou, '{n}.date_contract', array('{0}^{1}^{2}', '{n}.name', '{n}.date_contract', '{n}.date_expired'));
                                // if(!empty($dataMous)) {
                                //  $dataKeyMou = max(array_keys($dataMous));
                                //  $dataMou = $dataMous[$dataKeyMou];

                                //  list($mouName, $mouDateContracts, $mouDateExpireds) = explode('^', $dataMou);
                                //  $mouDateContract = $this->Time->format('d M Y', $mouDateContracts);
                                //  $mouDateExpired = $this->Time->format('d M Y', $mouDateExpireds);
                                // } else {
                                //  $mouName = "";
                                //  $mouDateContract = "";
                                //  $mouDateExpired = "";
                                // }
                                
                                $mouName  = (!empty($mou['name'])) ? $mou['name'] : '-';
                                $mouDateExpired = (!empty($mou['date_expired'])) ? $this->Time->format('d M Y', $mou['date_expired']) : '-';

                                //$mouDateContract = $this->Time->format('d M Y', $mouDateContracts);
                                //$mouDateExpired = $this->Time->format('d M Y', $mouDateExpireds);

                                // pr($dataMous);
                                // pr($dataMou);
                                $userAdminCode = $this->Krs->truncate($userAdmin['code']);
                                $dataId = $row['id'];
                                $dataCode = $row['code'];
                                $dataTitle = $row['title'];

                                $dataPracticeDay = (empty($row['practice_day'])) ? '':$row['practice_day'];
                                $dataPracticeDayHourStart = (empty($row['practice_hours_start'])) ? '':$row['practice_hours_start'];
                                $dataPracticeDayHourEnd = (empty($row['practice_hours_end'])) ? '':$row['practice_hours_end'];

                                $dataPPh = ($row['pph']=='N') ? '<i class="fa fa-times"></i>' : $this->Krs->statusTaxPPh($row['pph']);
                                //$dataPPh23 = ($row['pph23']=='Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                                $dataVa = (empty($row['va'])) ? "" : '<b>VA : </b><i>'.$row['va'].'</i>';
                                $customerName = $row['title'].' '.$row['name'];
                                $dataNameInvoice = $row['name_invoice'];
                                $dataMarketingId = $row['marketing_id'];
                                //$mouCode = $mou['name'];
                                $mouCode = $mouName." (<b>Exp: </b>".$mouDateExpired.")";

                                if($dataMarketingId) {
                                    $marketingSelect = Set::extract('/User[id='.$dataMarketingId.']', $data['marketingData']);
                                    
                                    $marketing = (isset($marketingSelect) && !empty($marketingSelect)) ? $marketingSelect[0]['User'] : '';
                                    $marketingName = (empty($marketing)) ? '-' : $marketing['name'];
                                } else {
                                    $marketingName = '-';
                                }

                                $dataIsActive = $row['is_active'];
                                $dataDepositMou = ($row['deposit_mou']=='Y') ? '<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>';
                                $dataBranch = ($row['branch_id']==0) ? "-":$data['branch'][$row['branch_id']];

                                $dataLinkPreview = array('event_id' => $uuid, 'controller' => 'customers', 'action' => 'preview/'.$dataId, 'full_base'=>true);
                                $dataLinkEdit = array('event_id' => $uuid, 'controller' => 'customers', 'action' => 'edit/'.$dataId.$pages, 'full_base'=>true);
                                $dataLinkEditAdmin = array('event_id' => $uuid, 'controller' => 'customers', 'action' => 'edit_admin/'.$dataId.$pages, 'full_base'=>true);
                                //$dataLinkDataBank = array('event_id' => $uuid, 'controller' => 'customers', 'action' => 'bank_data/'.$dataId, 'full_base'=>true);
                                //$dataLinkDelete = array('event_id' => $uuid, 'controller' => 'customers', 'action' => 'delete/'.$dataId.'/'.$session['id'], 'full_base'=>true);

                                $actions = $this->Krs->btnPreview($dataId, $customerName);
                                $actions .= $this->Krs->btnEdit($dataLinkEdit, $customerName);
                                $actions .= $this->Krs->btnEditCustome($dataLinkEditAdmin, $customerName);
                                
                                //$actions .= $this->Krs->btnDataBank($dataLinkDataBank, $customerName);
                                //$actions .= $this->Krs->btnDelete($dataLinkDelete, $dataName);
                                

                                // $actions = $this->Html->link('<i class="fas fa-edit"></i> Ubah', array('event_id' => $uuid, 'controller' => 'customers', 'action' => 'edit/'.$dataId, 'full_base'=>true), array('class' => 'btn btn-sm btn-info width-80 m-r-10', 'escape' => false));
                                
                                $linkStatusYes = array('event_id' => $uuid, 'controller' => 'customers', 'action'=>'status/'.$dataId.'/N'.'/'.$session['id'].$pages, "full_base"=>true);
                                $linkStatusNo = array('event_id' => $uuid, 'controller' => 'customers', 'action'=>'status/'.$dataId.'/Y'.'/'.$session['id'].$pages, "full_base"=>true);

                                $actives = $this->Krs->btnStatus($dataIsActive, $linkStatusYes, $linkStatusNo);

                                //$active = ($dataIsActive=='Y') ? $this->Html->link('<i class="fa fa-check"></i>', $linkStatusYes, array("escape"=>false, "class"=>"btn btn-lime btn-icon btn-circle btn-sm", 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Aktif')) : $this->Html->link('<i class="fa fa-times"></i>', $linkStatusNo, array("escape"=>false, "class"=>"btn btn-danger btn-icon btn-circle btn-sm", 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Tidak Aktif'));
                                //$active = ($dataIsActive=='Y') ? "<div id='status".$dataId."'>".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatus('".$dataId."', 'N')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm", 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Aktif'))."</div>" : "<div id='status".$dataId."'>".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatus('".$dataId."', 'Y')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm", 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Tidak Aktif'))."</div>";

                                //$active = ($dataIsActive=='Y') ? "<div id='status".$dataId."'>".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatus('".$dataId."', 'N')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>" : "<div id='status".$dataId."'>".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatus('".$dataId."', 'Y')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";
                                //$active = '<input type="checkbox" data-render="switchery" data-theme="default" checked />';
                                $statusHiddenActive = ($dataIsActive=='Y') ? "": ' style="display: none;"';
                                $statusHiddenInactive = ($dataIsActive=='N') ? "": ' style="display: none;"';
                                $active = "<div id='statusSpin".$dataId."'></div>";
                                $active .= "<div id='statusActive".$dataId."'".$statusHiddenActive.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusActive('".$dataId."', 'N', '".$session['id']."')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm"))."</div>";

                                $active .= "<div id='statusInactive".$dataId."'".$statusHiddenInactive.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatusInactive('".$dataId."', 'Y', '".$session['id']."')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm"))."</div>";

                                $viewTax = ($row['tax']=='I') ? $row['taxing'].'%' : '<i class="fa fa-times"></i>';
                                //$viewTax = $this->Krs->statusTax($row['tax']);
                                //($row['tax']=="Y") ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                                $beginningBalance = ($row['beginning_balance']>0) ? '<br><b>Saldo Awal : </b><i>'.$this->Krs->nominal($row['beginning_balance']).'</i>' : '';

                                
                                $showPractice = '<a href="javascript:;" class="text-dark text-decoration-none show"><i class="fa fa-calendar-alt fa-fw me-1 text-dark text-opacity-50"></i> <b>Hari & Jam Praktek</b> <b class="caret"></b></a>';
                                $hidePractice = '<a href="javascript:;" class="text-dark text-decoration-none hides"><i class="fa fa-calendar-alt fa-fw me-1 text-dark text-opacity-50"></i> <b>Hari & Jam Praktek</b> <b class="caret"></b></a>';
                                // data-pk="'.$manifestId.'"
                                //<form action="" class="form-horizontal showPractice" id="CustomerAddForm" method="post" accept-charset="utf-8">
                                $showDataPractice = '<table class="table table-td-valign-middle widget-table widget-table-rounded showPractice" data-id="widget" id="showPractice'.$dataId.'">
                                    <tbody class="table-info">
                                        <tr>
                                            <td width="60">Hari</td>
                                            <td width="180">'.$this->Form->input('practice_day', array('label'=>false, 'div'=>false, 'empty'=>true, 'options'=>$this->Krs->practiceDay(), 'data-placeholder'=>'Hari Praktek..', 'id'=>'practiceDay'.$dataId, 'class'=>'form-control select2Form practice_day', 'title'=>"Hari Praktek tidak boleh kosong!", 'default'=>$dataPracticeDay)).'
                                            </td>
                                            <td>'.$this->Form->button('Simpan', array('class'=>'btn btn-inverse width-80 btn-save-practice', 'type'=>'button', 'escape' => false, 'id'=> $dataId)).'<span id="practiceSpin'.$dataId.'"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Jam</td>
                                            <td colspan="2">
                                            <div class="row">
                                               <div class="col-md-5">
                                                        <div class="input-group clockpicker">'.$this->Form->input('timeFrom', array('label'=>false, 'div'=>false, 'class' => 'form-control', 'error' => false, 'placeholder' => 'Jam Buka..', 'id'=>'practiceTimeFrom'.$dataId, 'value'=>$dataPracticeDayHourStart, 'readonly'=>true)).'
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-clock"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" align="center"><input type="text" readonly class="form-control-plaintext" value="Sampai"></div>
                                                    <div class="col-md-5">
                                                        <div class="input-group clockpicker">'.$this->Form->input('timeEnd', array('label'=>false, 'div'=>false, 'class' => 'form-control', 'error' => false, 'placeholder' => 'Jam Tutup..', 'value'=>$dataPracticeDayHourEnd, 'readonly'=>true, 'id'=>'practiceTimeEnd'.$dataId)).'
                                                            <span class="input-group-addon">
                                                                <span class="fa fa-clock"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>';
                                    //</form>
                                //.$statusDayPractice.' '.$statusTimePractice.'<br>'
//.$nyet
                                    $statusPractice = (empty($dataPracticeDay)) ? '':' <i>(Praktek: <b>'.$dataPracticeDay.'</b>, Jam: <b>'.$dataPracticeDayHourStart.'-'.$dataPracticeDayHourEnd.'</b>)</i>';
                                echo '<tr>
                                        <td><b>'.$dataCode.'</b></td>
                                        <td><b>'.$customerName.'</b>'.$beginningBalance.'<br><b>Nama Invoice : </b><i>'.$dataNameInvoice.'</i><br><b>No.MOU : </b>'.$mouCode.'<br>'.$dataVa.$showPractice.$hidePractice.$statusPractice.$showDataPractice.'</td>
                                        <td align="left"><b>PPn : '.$viewTax.'<br>PPh : '.$dataPPh.'<br>Deposit : '.$dataDepositMou.'</b></td>
                                        <td align="center">'.$active.'</td>
                                        <td align="center">Adm : '.$userAdminCode.'<br>(Mkt : <i>'.$marketingName.')</i></td>
                                        <td align="right" class="with-btn" nowrap>'.$actions.'</td>
                                    </tr>';


                                // $statusHiddenNo = ($dataIsActive=='N') ? "": ' style="display: none;"';

                                // $active .= "<div id='status".$dataId."'".$statusHiddenYes.">".$this->Html->link('<i class="fa fa-check"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatus('".$dataId."', 'N')", "class"=>"btn btn-lime btn-icon btn-circle btn-sm", 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Aktif'))."</div>";
                                // $active .= "<div id='status".$dataId."'".$statusHiddenNo.">".$this->Html->link('<i class="fa fa-times"></i>', 'javascript:;', array("escape"=>false, "onClick"=>"changeStatus('".$dataId."', 'Y')", "class"=>"btn btn-danger btn-icon btn-circle btn-sm", 'data-toggle'=>'tooltip', 'data-placement'=>'left', 'title'=>'Tidak Aktif'))."</div>"; 

                                //<div id="divCheckbox" style="display: none;">

                                //<div id="status"> 
                                //<a href="#" onClick="changestatus(' echo $status; ')">Deactive</a>                                 
                                //</div>


                                //$active = ($dataIsActive=='Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';

                                //$viewTax = ($row['tax']=="Y") ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                                //$active = ($view['is_active']=="Y") ? $tick : $cross;


                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!-- #modal-dialog -->
                <div class="modal fade" tabindex="-1" role="dialog" id="ajax-modal"></div>
                    
            <!-- end table-responsive -->
            <?= $this->Krs->paginators() ?>
        </div>
    </div>  
</div>
<?php
//echo $this->Html->url(array("event_id" => $uuid, "controller" => "customers", "action" =>  'status/'.$pages, "full_base" => true), true);
//data: 'status=' + status + '&values=' + values, // Data yang akan dikirim ke file pemroses
$urlStatusData = $this->Html->url(array('event_id' => $uuid, "controller" => "customers", "action" => "status"));

$urlStatusPractice = $this->Html->url(array('event_id' => $uuid, "controller" => "customers", "action" => "status_practice"));
?>
<script type="text/javascript"> 
jQuery(function($) {
    $('.clockpicker').clockpicker({
        align: 'right',
        autoclose: true,
        'default': 'now'
    });


    $(".btn-save-practice").click(function(){
        var element = $(this);
        var dataId = element.attr("id");
        var practiceDay = $("#practiceDay"+dataId).val();
        var practiceTimeFrom = $("#practiceTimeFrom"+dataId).val();
        var practiceTimeEnd = $("#practiceTimeEnd"+dataId).val();
        
        // alert(dataId.length+' : '+dataId+' = '+practiceDay+' --> '+practiceTimeFrom+' - '+practiceTimeEnd);

        if(dataId.length != 0) {
            $('#practiceSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();

            // alert(dataId.length+' : '+dataId+' = '+practiceDay+' --> '+practiceTimeFrom+' - '+practiceTimeEnd);
            $.ajax({
                type: 'POST', // Metode pengiriman data menggunakan POST
                url: '<?php echo $urlStatusPractice; ?>', // File pemroses data
                data: 'id=' + dataId + '&day=' + practiceDay + '&timeStart=' + practiceTimeFrom + '&timeEnd=' + practiceTimeEnd + '&userId=' + <?php echo $session['id']; ?> , // Data yang akan dikirim ke file pemroses               
                cache: false,
                success: function(response) { // Jika berhasil
                    // alert(response);
                    swal({
                      title: "Berhasil",
                      text: "Hari & Jam Praktek berhasil disimpan!",
                      timer: 3000,
                      showConfirmButton: false,
                      type: 'success',
                      customClass: 'facebook',
                    });

                    $("#showPractice"+dataId).hide();
                    // if(response=='Y') {
                    //  $('#statusActive'+status).show();
                    // } 
                    // if(response=='N') {
                    //  $('#statusInactive'+status).show();
                    // }
                    //$('#statusActive'+status).html('<i class="fa fa-times"></i>').show();
                  // $('#selectPermitData').html(response); // Berikan hasilnya ke id kurir
                    $('#practiceSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').hide();
                }
            }).done(function( msg ) {
                $('#practiceSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').hide();
                // alert(msg);
                // if(response=='Y') {
             //         $('#status'+status).html('<i class="fa fa-check"></i>').show();
             //     } else {
             //         $('#status'+status).html('<i class="fa fa-times"></i>').show();
             //     }
                //$('#status'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            }).fail(function() {
                alert( "Maaf ada kesalahan program, silakan hubungi admin.." );
                $('#practiceSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').hide();
            });
        } else {
            $('#practiceSpin'+dataId).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').hide();
        }
        

    });

    $(".select2Form").select2();

    $("table.showPractice, .hides").hide();

    $(".show").click(function() {
        $(this).parents('tr').find("table.showPractice, .hides").show();
        //$(this).parents('tr').find("form,.hides").show();
        $(this).parents('tr').find(".show").hide();
    });

    $(".hides").click(function() {
        $(this).parents('tr').find("table.showPractice, .hides").hide();
        //$(this).parents('tr').find("form, .hides").hide();
        $(this).parents('tr').find(".show").show();
    });

    $(".select2FormClear").select2({ allowClear: true });
    
    window.changeStatusActive = function(status, values, userId){
    //function changeStatusActive(status, values, userId) {
        if (!$('#statusActive'+status).attr('complete')) {
            $('#statusSpin'+status).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
            $('#statusActive'+status).hide();
        }       
        
        if(status.length != 0) {
            $.ajax({
                type: 'POST', // Metode pengiriman data menggunakan POST
                url: '<?php echo $urlStatusData; ?>', // File pemroses data
                data: 'status=' + status + '&values=' + values + '&userId=' + userId, // Data yang akan dikirim ke file pemroses
                
                cache: false,
                success: function(response) { // Jika berhasil
                    //alert(response);
                    if(response=='Y') {
                        $('#statusActive'+status).show();
                    } 
                    if(response=='N') {
                        $('#statusInactive'+status).show();
                    }
                    //$('#statusActive'+status).html('<i class="fa fa-times"></i>').show();
                  // $('#selectPermitData').html(response); // Berikan hasilnya ke id kurir
                    $('#statusSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                }
            }).done(function( msg ) {
                // alert(msg);
                // if(response=='Y') {
             //         $('#status'+status).html('<i class="fa fa-check"></i>').show();
             //     } else {
             //         $('#status'+status).html('<i class="fa fa-times"></i>').show();
             //     }
                //$('#status'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            }).fail(function() {
                alert( "Maaf ada kesalahan program, silakan hubungi admin.." );
                $('#statusSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            }); 
        } else {
             $('#statusSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
        }
    }

    window.changeStatusInactive = function(status, values, userId){
    //function changeStatusInactive(status, values, userId) {
        //alert(status + values);
        if (!$('#statusInactive'+status).attr('complete')) {
            $('#statusSpin'+status).html('<i class="fas fa-spinner fa-pulse fa-fw"></i>').show();
            $('#statusInactive'+status).hide();
        }

        if(status.length != 0) {
            $.ajax({
                type: 'POST', // Metode pengiriman data menggunakan POST
                url: '<?php echo $urlStatusData; ?>', // File pemroses data
                data: 'status=' + status + '&values=' + values + '&userId=' + userId, // Data yang akan dikirim ke file pemroses
                cache: false,
                success: function(response) { // Jika berhasil
                    //alert(response);
                    if(response=='Y') {
                        $('#statusActive'+status).show();
                    } 
                    if(response=='N') {
                        $('#statusInactive'+status).show();
                    }
                  // $('#selectPermitData').html(response); // Berikan hasilnya ke id kurir
                    //$('#status'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                    $('#statusSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                }
            }).done(function( msg ) {
            }).fail(function() {
                alert( "Maaf ada kesalahan program, silakan hubungi admin.." );
                $('#statusSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            }); 
        } else {
             $('#statusSpin'+status).html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
        }
    }


});
</script>

<div class="customers index content">
    <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Customers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('code_ori') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('marketing_id') ?></th>
                    <th><?= $this->Paginator->sort('data_invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('data_tax_id') ?></th>
                    <th><?= $this->Paginator->sort('mou_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('title_old') ?></th>
                    <th><?= $this->Paginator->sort('nickname') ?></th>
                    <th><?= $this->Paginator->sort('nickname_old') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('name_old') ?></th>
                    <th><?= $this->Paginator->sort('name_fake') ?></th>
                    <th><?= $this->Paginator->sort('check_fake') ?></th>
                    <th><?= $this->Paginator->sort('deposit_mou') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('group') ?></th>
                    <th><?= $this->Paginator->sort('practice_day') ?></th>
                    <th><?= $this->Paginator->sort('practice_hours_start') ?></th>
                    <th><?= $this->Paginator->sort('practice_hours_end') ?></th>
                    <th><?= $this->Paginator->sort('tax') ?></th>
                    <th><?= $this->Paginator->sort('taxing') ?></th>
                    <th><?= $this->Paginator->sort('pph') ?></th>
                    <th><?= $this->Paginator->sort('va') ?></th>
                    <th><?= $this->Paginator->sort('treatment') ?></th>
                    <th><?= $this->Paginator->sort('contact_person') ?></th>
                    <th><?= $this->Paginator->sort('dept_person') ?></th>
                    <th><?= $this->Paginator->sort('telp_person') ?></th>
                    <th><?= $this->Paginator->sort('warehouse_address') ?></th>
                    <th><?= $this->Paginator->sort('warehouse_telp') ?></th>
                    <th><?= $this->Paginator->sort('supplier') ?></th>
                    <th><?= $this->Paginator->sort('phone_supplier') ?></th>
                    <th><?= $this->Paginator->sort('fax_supplier') ?></th>
                    <th><?= $this->Paginator->sort('name_invoice') ?></th>
                    <th><?= $this->Paginator->sort('phone_invoice') ?></th>
                    <th><?= $this->Paginator->sort('fax_invoice') ?></th>
                    <th><?= $this->Paginator->sort('name_tax_invoice') ?></th>
                    <th><?= $this->Paginator->sort('phone_tax_invoice') ?></th>
                    <th><?= $this->Paginator->sort('fax_tax_invoice') ?></th>
                    <th><?= $this->Paginator->sort('bank_an_ori') ?></th>
                    <th><?= $this->Paginator->sort('bank_name_ori') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek_ori') ?></th>
                    <th><?= $this->Paginator->sort('bank_an') ?></th>
                    <th><?= $this->Paginator->sort('bank_name') ?></th>
                    <th><?= $this->Paginator->sort('bank_norek') ?></th>
                    <th><?= $this->Paginator->sort('va_an') ?></th>
                    <th><?= $this->Paginator->sort('va_name') ?></th>
                    <th><?= $this->Paginator->sort('va_no') ?></th>
                    <th><?= $this->Paginator->sort('giro_no') ?></th>
                    <th><?= $this->Paginator->sort('rek_name') ?></th>
                    <th><?= $this->Paginator->sort('rek_no') ?></th>
                    <th><?= $this->Paginator->sort('rek_bank') ?></th>
                    <th><?= $this->Paginator->sort('npwp') ?></th>
                    <th><?= $this->Paginator->sort('ppn') ?></th>
                    <th><?= $this->Paginator->sort('city') ?></th>
                    <th><?= $this->Paginator->sort('province') ?></th>
                    <th><?= $this->Paginator->sort('district') ?></th>
                    <th><?= $this->Paginator->sort('postal') ?></th>
                    <th><?= $this->Paginator->sort('country') ?></th>
                    <th><?= $this->Paginator->sort('phone3') ?></th>
                    <th><?= $this->Paginator->sort('phone4') ?></th>
                    <th><?= $this->Paginator->sort('phone5') ?></th>
                    <th><?= $this->Paginator->sort('email1') ?></th>
                    <th><?= $this->Paginator->sort('email2') ?></th>
                    <th><?= $this->Paginator->sort('email3') ?></th>
                    <th><?= $this->Paginator->sort('email4') ?></th>
                    <th><?= $this->Paginator->sort('email5') ?></th>
                    <th><?= $this->Paginator->sort('fb1') ?></th>
                    <th><?= $this->Paginator->sort('fb2') ?></th>
                    <th><?= $this->Paginator->sort('ym1') ?></th>
                    <th><?= $this->Paginator->sort('ym2') ?></th>
                    <th><?= $this->Paginator->sort('ym3') ?></th>
                    <th><?= $this->Paginator->sort('ym4') ?></th>
                    <th><?= $this->Paginator->sort('ym5') ?></th>
                    <th><?= $this->Paginator->sort('system') ?></th>
                    <th><?= $this->Paginator->sort('website') ?></th>
                    <th><?= $this->Paginator->sort('beginning_balance') ?></th>
                    <th><?= $this->Paginator->sort('platform') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('who_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('who_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= $this->Number->format($customer->id) ?></td>
                    <td><?= $customer->has('branch') ? $this->Html->link($customer->branch->name, ['controller' => 'Branches', 'action' => 'view', $customer->branch->id]) : '' ?></td>
                    <td><?= h($customer->code_ori) ?></td>
                    <td><?= h($customer->code) ?></td>
                    <td><?= $customer->has('user') ? $this->Html->link($customer->user->name, ['controller' => 'Users', 'action' => 'view', $customer->user->id]) : '' ?></td>
                    <td><?= $this->Number->format($customer->marketing_id) ?></td>
                    <td><?= $customer->has('data_invoice') ? $this->Html->link($customer->data_invoice->name, ['controller' => 'DataInvoices', 'action' => 'view', $customer->data_invoice->id]) : '' ?></td>
                    <td><?= $customer->has('data_tax') ? $this->Html->link($customer->data_tax->name, ['controller' => 'DataTaxes', 'action' => 'view', $customer->data_tax->id]) : '' ?></td>
                    <td><?= $this->Number->format($customer->mou_id) ?></td>
                    <td><?= h($customer->title) ?></td>
                    <td><?= h($customer->title_old) ?></td>
                    <td><?= h($customer->nickname) ?></td>
                    <td><?= h($customer->nickname_old) ?></td>
                    <td><?= h($customer->name) ?></td>
                    <td><?= h($customer->name_old) ?></td>
                    <td><?= h($customer->name_fake) ?></td>
                    <td><?= h($customer->check_fake) ?></td>
                    <td><?= h($customer->deposit_mou) ?></td>
                    <td><?= h($customer->type) ?></td>
                    <td><?= h($customer->group) ?></td>
                    <td><?= h($customer->practice_day) ?></td>
                    <td><?= h($customer->practice_hours_start) ?></td>
                    <td><?= h($customer->practice_hours_end) ?></td>
                    <td><?= h($customer->tax) ?></td>
                    <td><?= $this->Number->format($customer->taxing) ?></td>
                    <td><?= h($customer->pph) ?></td>
                    <td><?= h($customer->va) ?></td>
                    <td><?= h($customer->treatment) ?></td>
                    <td><?= h($customer->contact_person) ?></td>
                    <td><?= h($customer->dept_person) ?></td>
                    <td><?= h($customer->telp_person) ?></td>
                    <td><?= h($customer->warehouse_address) ?></td>
                    <td><?= h($customer->warehouse_telp) ?></td>
                    <td><?= h($customer->supplier) ?></td>
                    <td><?= h($customer->phone_supplier) ?></td>
                    <td><?= h($customer->fax_supplier) ?></td>
                    <td><?= h($customer->name_invoice) ?></td>
                    <td><?= h($customer->phone_invoice) ?></td>
                    <td><?= h($customer->fax_invoice) ?></td>
                    <td><?= h($customer->name_tax_invoice) ?></td>
                    <td><?= h($customer->phone_tax_invoice) ?></td>
                    <td><?= h($customer->fax_tax_invoice) ?></td>
                    <td><?= h($customer->bank_an_ori) ?></td>
                    <td><?= h($customer->bank_name_ori) ?></td>
                    <td><?= h($customer->bank_norek_ori) ?></td>
                    <td><?= h($customer->bank_an) ?></td>
                    <td><?= h($customer->bank_name) ?></td>
                    <td><?= h($customer->bank_norek) ?></td>
                    <td><?= h($customer->va_an) ?></td>
                    <td><?= h($customer->va_name) ?></td>
                    <td><?= h($customer->va_no) ?></td>
                    <td><?= h($customer->giro_no) ?></td>
                    <td><?= h($customer->rek_name) ?></td>
                    <td><?= h($customer->rek_no) ?></td>
                    <td><?= h($customer->rek_bank) ?></td>
                    <td><?= h($customer->npwp) ?></td>
                    <td><?= h($customer->ppn) ?></td>
                    <td><?= h($customer->city) ?></td>
                    <td><?= h($customer->province) ?></td>
                    <td><?= h($customer->district) ?></td>
                    <td><?= $this->Number->format($customer->postal) ?></td>
                    <td><?= h($customer->country) ?></td>
                    <td><?= h($customer->phone3) ?></td>
                    <td><?= h($customer->phone4) ?></td>
                    <td><?= h($customer->phone5) ?></td>
                    <td><?= h($customer->email1) ?></td>
                    <td><?= h($customer->email2) ?></td>
                    <td><?= h($customer->email3) ?></td>
                    <td><?= h($customer->email4) ?></td>
                    <td><?= h($customer->email5) ?></td>
                    <td><?= h($customer->fb1) ?></td>
                    <td><?= h($customer->fb2) ?></td>
                    <td><?= h($customer->ym1) ?></td>
                    <td><?= h($customer->ym2) ?></td>
                    <td><?= h($customer->ym3) ?></td>
                    <td><?= h($customer->ym4) ?></td>
                    <td><?= h($customer->ym5) ?></td>
                    <td><?= h($customer->system) ?></td>
                    <td><?= h($customer->website) ?></td>
                    <td><?= $this->Number->format($customer->beginning_balance) ?></td>
                    <td><?= $this->Number->format($customer->platform) ?></td>
                    <td><?= h($customer->is_active) ?></td>
                    <td><?= h($customer->who_create) ?></td>
                    <td><?= h($customer->created) ?></td>
                    <td><?= h($customer->who_update) ?></td>
                    <td><?= h($customer->modified) ?></td>
                    <td><?= h($customer->active) ?></td>
                    <td><?= h($customer->status) ?></td>
                    <td><?= h($customer->is_create) ?></td>
                    <td><?= h($customer->is_update) ?></td>
                    <td><?= h($customer->is_delete) ?></td>
                    <td><?= h($customer->deleted) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $customer->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customer->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
