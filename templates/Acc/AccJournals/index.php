<?php
use Cake\Utility\Hash;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal[]|\Cake\Collection\CollectionInterface $accJournals
 */
?>
<?= $this->Krs->breadcrumb('Accounting', 'Jurnal', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <?= $this->Krs->heading('Daftar Jurnal'); ?>
    <div class="panel-body bg-gray-100">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                  <div class="portlet-body">
                    <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add_many'], ['class'=>'btn btn-inverse', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'Add', 'escape' => false, 'fullBase'=>true]) ?>
                    <div class="btn-group dropdown">
                        <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                        <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?= $this->Html->link('Pdf', ['action' => 'pdf'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                        <?= $this->Html->link('Excel', ['action' => 'xls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                        </div>
                    </div>                    
                  </div>
                </div>
                <?php
                /*
                <div class="btn-group m-r-5 m-b-5">
                    <a href="javascript:;" class="btn btn-inverse"><i class="fa fa-plus"></i></a>
                    <a href="#" data-toggle="dropdown" class="btn btn-inverse dropdown-toggle"><b class="caret"></b></a>
                    <div class="dropdown-menu dropdown-menu">
                        <?php
                        echo $this->Html->link('Tambah', ['action' => 'add_many'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]);
                        //echo $this->Html->link('Tambah (Satu)', ['action' => 'add_only_one'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]);
                        ?>
                    </div>
                </div>
                <div class="btn-group pull-right">
                    <a href="javascript:;" class="btn btn-primary"><i class="fa fa-download"></i></a>
                    <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><b class="caret"></b></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php
                        echo $this->Html->link('Excel', ['action' => 'xls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]);
                        echo $this->Html->link('PDF', ['action' => 'pdf'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]);
                        ?>
                    </div>
                </div>
                */
                ?>
            </div>
            <br>
            <?= $this->Form->create(null, ['type' => 'post']) ?>
            <div class="panel-footer bg-aqua text-white p-t-10">
                <div class="row row-space-10">                    
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterBranch', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Cabang..', 'empty'=>true, 'value'=>$dataLink['filterBranch']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                            <?php 
                            echo $this->Form->input('filterCode', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Kode..', 'value'=>$dataLink['filterCode']));
                            ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterJournalType', ['empty'=>true, 'options'=>$this->Krs->journalType(), 'data-placeholder'=>'Jenis Jurnal..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$dataLink['filterJournalType']]);
                        ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Jurnal...'), 'filterDateEnd', array("class"=>"form-control date-picker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Jurnal...'), 's/d', 'resetDate');
                        ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->input('filterCustomer', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Penanggung Jawab..', 'empty'=>true, 'value'=>$dataLink['filterCustomer']));
                        ?>
                        </div>
                    </div>
                    <?php
                    /*             
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterGrandTotal', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Total..', 'empty'=>true, 'value'=>$dataLink['filterGrandTotal']));
                        ?>
                        </div>
                    </div>
                    */
                    ?>
                    <div class="col-md-4">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->input('filterDesc', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Uraian..', 'empty'=>true, 'value'=>$dataLink['filterDesc']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->input('filterSubject', array('class' => 'form-control', 'required' => false, 'placeholder'=>'Judul..', 'empty'=>true, 'value'=>$dataLink['filterSubject']));
                        ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group m-b-10">
                        <?php
                        echo $this->Form->input('filterStatusPosting', ['empty'=>true, 'options'=>$this->Krs->postingStatus(), 'data-placeholder'=>'Status..', 'class'=>'form-control select2Form', 'type'=>'select', 'default'=>$dataLink['filterStatusPosting']]);
                        ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group m-b-10">
                        <?php 
                        echo $this->Form->button('<i class="fas fa-search"></i>', array('class'=>'btn btn-warning width-60 m-r-10', 'type'=>'submit', 'id'=> 'btnSearch', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Cari"));
                        ?>
                        </div>
                    </div>

                </div>
            </div>
            <?= $this->Form->end() ?>
            <?= $this->Form->create(null, ['type' => 'post']) ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-td-valign-middle" id="check-all">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="50"><input type="checkbox" class="group-checkable" data-set="#check-all .checkboxes" /></th>
                            <th width="180">&nbsp;</th>
                            <th>Keterangan</th>
                            <th width="120">Total</th>
                            <th width="80"><?php
                            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                            ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" align="right">
                                <p class="form-control-static"><b>TANGGAL POSTING</b></p>
                            </td>
                            <td><?php
                            echo $this->Form->input("date_journals", array("class" => "form-control date-picker-posting", "value" => date("d-m-Y"), "id"=>"dateJournal", "error" => false, "required"=>false, 'readonly' => true));
                            ?></td>
                            <td align="right" class="with-btn" nowrap><?php 
                            echo $this->Form->button('<i class="fas fa-leaf"></i>', ['class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'escape' => false, 'id'=> 'btnPosting', 'escapeTitle' => false]);

                            // echo $this->Form->button('<i class="fas fa-leaf"></i>', array('class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'id'=> 'btnPosting', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Posting"));
                            // echo $this->Form->button('<i class="fas fa-trash-alt"></i>', array('class'=>'btn btn-danger width-60 m-r-10', 'type'=>'submit', 'id'=> 'btnDelete', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Hapus"));
                            ?></td>
                        </tr>

                    <?php 
                    // pr($accJournals);
                    $trcount = 0;
                    foreach ($accJournals as $data) {
                        $accJournalLine = $data->artama_acc_journal_lines;
                        if(!empty($accJournalLine)) {

                        
                        $journalId = $data->id;
                        $journalINoRef = $data->no_ref;
                        $accJournalLineNamed = (isset($accJournalLine)) ? Hash::extract($accJournalLine, '{n}.name') : array();
                        $accJournalLineNamew = array_unique($accJournalLineNamed);
                        $accJournalLineNames = implode("<br>", $accJournalLineNamew);
                        $branchName = $data->branch["name"];
                        $journalType = (empty($data->journal_type)) ? '':$this->Krs->journalType($data->journal_type);
                        $journalFrom = $data->from;
                        $journalDate = (empty($data->date)) ? "-":$this->Krs->fDate($data->date, 'd-m-Y');
                        $accJournalIsDelete = $data->is_delete;
                        $accJournalStatus = $data->status;

                        $dataLinkEditMany = array('action' => 'edit_many', $journalId);

                        $accJournalLineDebets = Hash::extract($accJournalLine, '{n}.debet');
                        $accJournalLineDebet = (isset($accJournalLineDebets)) ? round(array_sum($accJournalLineDebets),2) : "";
                        $journalGrandTotal = $this->Krs->cur($accJournalLineDebet);

                        // pr($accJournalIsDelete);
                        if(empty($accJournalIsDelete) && $accJournalStatus!='posting') {
                            $actionEdit = $this->Krs->btn('editCustome', $dataLinkEditMany);
                            $isCek = $this->Form->checkbox('dataGrid.'.$journalId.'.cek', array('value' => 'y', 'hiddenField' => 'n', 'class' => 'checkboxes'));                             

                            $classCondition = '';
                        } elseif($accJournalStatus=='posting') {
                            // pr('asf');
                            $actionEdit = $this->Krs->btn('editCustome', $dataLinkEditMany);
                            $isCek = $this->Form->input('dataGrid.'.$journalId.'.cek', array('type' => 'hidden', 'value' => 'n'));
                            $classCondition = ' class="table-warning"';
                        } else {
                            $actionEdit = "";
                            $isCek = $this->Form->input('dataGrid.'.$journalId.'.cek', array('type' => 'hidden', 'value' => 'd'));
                            $classCondition = ' class="table-danger"';
                        }

                        // pr($isCek);

                        $dataLinkEdit = array('action' => 'edit', $journalId);

                        $urlOpen = $this->Url->build(['action' => 'print_journal'], ['fullBase' => true]);
                        // $urlOpen = $this->Html->url(array("action" => "print_journal", "full_base" => true));
                        $actionPrint =  ($journalType=='BKK' || $journalType=='BKM') ? $this->Html->tag("a", '<i class="fas fa-print"></i>', array("onclick" => "window.open('".$urlOpen."/".$journalId."', 'page', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=780,height=750,left=50,top=50,titlebar=yes');", 'escape'=>false, 'class'=>'btn btn-sm btn-lime width-50 m-r-5', "data-trigger"=>"hover", "data-container"=>"body", "data-placement"=>"top", "data-content"=>"Cetak data..")) : '';

                        $dataJournalId = $this->Form->input('dataGrid.'.$journalId.'.journalId', array('type' => 'hidden', 'value' => $journalId));
                        $dataJournalFrom = $this->Form->input('dataGrid.'.$journalId.'.from', array('type' => 'hidden', 'value' => $journalFrom));

                        $linkDelete = array('action' => 'delete', $journalId);
                        echo '<tr'.$classCondition.'>
                                <td align="center">'.$isCek.$dataJournalId.$dataJournalFrom.'</td>
                                <td align="left">Cabang : <b>'.$branchName.'</b><br>
                                Kode : <b>'.$data->code.'</b><br>
                                Jenis Jurnal : <b>'.$journalType.'</b><br>
                                Dari : <b>'.$journalFrom.'</b><br>
                                Tanggal : <b>'.$journalDate.'</b><br>'
                                .$actionEdit.'&nbsp;&nbsp;'.$actionPrint.$this->Krs->btn('delete', $linkDelete, $data->code).'
                                </td>
                                <td align="left" colspan="3"><b>Judul : </b><i>'.$data->subject.'</i><br><b>Penanggung Jawab : </b><i>'.$data->recipient_payer_name.'</i><br>
                                    <table width="100%">
                                        <tr class="table-info text-center">
                                            <th width="250">Nama Perkiraan</th>
                                            <th>Uraian</th>
                                            <th width="100">Debet</th>
                                            <th width="100">Kredit</th>
                                        </tr>';
                                        //<th width="50">D/K</th>
                                        $totalDebet = array();
                                        $totalCredit = array();
                                        foreach ($accJournalLine as $dataAJL) {
                                            // pr($dataAJL->artama_acc_chart_of_account);
                                            $nameSpaceCredit = ($dataAJL->ledger_dc=='C') ? str_repeat('&nbsp;&nbsp;&nbsp;', 3) : '';
                                            $nameCoa = (isset($dataAJL->artama_acc_chart_of_account->code)) ? '('.$dataAJL->artama_acc_chart_of_account->code.') '.$dataAJL->artama_acc_chart_of_account->name : '-';
                                            //<td>'.$dataAJL->ledger_dc.'</td>
                                            
                                        echo '<tr>
                                            <td><i>'.$nameSpaceCredit.$nameCoa.'</i></td>
                                            <td>'.$nameSpaceCredit.$dataAJL->name.'</td>
                                            <td align="right">'.$this->Krs->cur($dataAJL->debet).'</td>
                                            <td align="right">'.$this->Krs->cur($dataAJL->credit).'</td>
                                        </tr>';
                                            $totalDebet[] = $dataAJL->debet;
                                            $totalCredit[] = $dataAJL->credit;
                                        }
                                        $grandTotalDebet = $this->Krs->cur(array_sum($totalDebet));
                                        $grandTotalCredit = $this->Krs->cur(array_sum($totalCredit));
                                    echo '<tr class="table-warning">
                                            <td colspan="2" align="right"><b>TOTAL</b></td>
                                            <td width="100"><b>'.$grandTotalDebet.'</b></td>
                                            <td width="100"><b>'.$grandTotalCredit.'</b></td>
                                        </tr>';
                                echo '</table>
                                </td>
                            </tr>';

                    $trcount++;
                        }
                    //<td align="right" class="with-btn" nowrap>'.$actionEdit.$actionPrint.'</td>
                    //<td align="center"><b>'.$journalGrandTotal.'</b></td>
                                
                    //<td align="left">'.$accJournalLineNames.'</td>
                    }
                     // pr($accJournalLineNames);
                        /*
                        //pr($accJournalLineDebet);
                        //pr();                        
                        $journalBranchId = $accJournal["branch_id"];
                        $journalIdCekBg = $accJournal["cek_bg"];
                        // Mengambil data branch
                        $dataBranchName = $dataSessionSetting["branch_data"][$journalBranchId];
                    */
                    ?>
                    </tbody>
                </table>
            </div>

        <?= $this->Krs->paginators() ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    handleDateRange('date-picker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    handleDatePicker('date-picker-posting');
    
    $(".select2Form").select2({ allowClear: true });

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'postingSave'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalAddForm', 'btnPosting', confirmTitle, formAction);

    // var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    // var formAction = "<?php //echo $this->Url->build(['controller'=>'AccJournals', 'action' => 'postingSave'], ['fullBase' => true]); ?>";
    // handleFormConfirmSubmitValid('AccJournalAddForm', 'btnPosting', confirmTitle, formAction);

    // var confirmTitleDelete = "Apakah anda ingin menghapus data tersebut ?";
    // var formActionDelete = "<?php //echo $this->Url->build(['controller'=>'AccJournals', 'action' => 'postingDelete'], ['fullBase' => true]); ?>";
    // handleFormConfirmSubmitValid('AccJournalAddForm', 'btnDelete', confirmTitleDelete, formActionDelete);

    // action for CheckAll
    handleCheckAllGrid('check-all');
    
    //handleFormSelect2('filterJournalType','clear');

    $(".nominal").autoNumeric({aSep: "", aDec: "."});

    // var confirmPosting = "Apakah anda yakin mem-Posting data tersebut?";
    // var formActionPosting = "<?php //echo $this->Html->url(array('event_id' => $uuid, 'controller' => 'acc_journals', 'action' => 'posting_save'.$pages, 'full_base' => true)); ?>";
    // submitForm('btnPosting', confirmPosting, formActionPosting);
    // handleFormConfirmSubmitValid
    // var confirmDelete = "Apakah anda yakin ingin menghapus data tersebut?";
    // var formActionDelete = "<?php //echo $this->Html->url(array('event_id' => $uuid, 'controller' => 'acc_journals', 'action' => 'delete'.$pages, 'full_base' => true)); ?>";
    // submitForm('btnDelete', confirmDelete, formActionDelete);
});
</script>
