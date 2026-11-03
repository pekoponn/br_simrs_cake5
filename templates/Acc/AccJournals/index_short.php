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
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['action' => 'add_many'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
                        <div class="btn-group dropdown">
                            <a href="javascript:(void);" class="btn btn-lime"><i class="fa fa-download"></i></a>
                            <a href="javascript:(void);" class="btn btn-lime dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?= $this->Html->link('Excel', ['action' => 'xls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                            <?= $this->Html->link('PDF', ['action' => 'pdf'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <th><input type="checkbox" class="group-checkable" data-set="#check-all .checkboxes" /></th>
                            <th>&nbsp;</th>
                            <th colspan="2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <div class="row form-group m-b-5">
                                  <label class="col-md-2 col-form-label">TANGGAL POSTING</label>
                                  <div class="col-md-2">
                                    <?php
                                    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                                    echo $this->Form->input("date_journals", array("class" => "form-control date-picker-posting", "value" => date("d-m-Y"), "id"=>"dateJournal", "error" => false, "required"=>false, 'readonly' => true));
                                    ?>
                                  </div>
                                  <div class="col-md-8"><?php 
                                    echo $this->Form->button('<i class="fas fa-leaf"></i>', ['class'=>'btn btn-primary width-60 m-r-10', 'type'=>'button', 'escape' => false, 'id'=> 'btnPosting', 'escapeTitle' => false]);
                                    ?></div>
                                </div>
                            </td>
                        </tr>

                    <?php 
                    // pr($accJournals);
                    $trcount = 0;
                    foreach ($accJournals as $data) {
                        $accJournalLine = $data->acc_journal_lines;

                        $journalId = $data->id;
                        $journalINoRef = $data->no_ref;
                        $accJournalLineNamed = (isset($accJournalLine)) ? Hash::extract($accJournalLine, '{n}.name') : array();
                        $accJournalLineNamew = array_unique($accJournalLineNamed);
                        $accJournalLineNames = implode("<br>", $accJournalLineNamew);
                        $branchName = $data->branch["name"];
                        $journalType = (empty($data->journal_type)) ? '':$this->Krs->journalType($data->journal_type);
                        $journalFrom = $data->came_from;
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
                                <td align="center" width="40">'.$isCek.$dataJournalId.$dataJournalFrom.'</td>
                                <td align="left" width="200">Cabang : <b>'.$branchName.'</b><br>
                                Kode : <b>'.$data->code.'</b><br>
                                Jenis Jurnal : <b>'.$journalType.'</b><br>
                                Dari : <b>'.$journalFrom.'</b></td>
                                <td align="left">Tanggal : <b>'.$journalDate.'</b><br>Judul : <b><i>'.$data->subject.'</i></b><br>Penanggung Jawab : <b><i>'.$data->recipient_payer_name.'</i></b><br>Total<b> : 
                                    '.$journalGrandTotal.'</b></td>
                                <td width="120" align="right" class="with-btn" nowrap>'.$actionEdit.'&nbsp;&nbsp;'.$actionPrint.$this->Krs->btn('delete', $linkDelete, $data->code).'</td>';
                        echo '</tr>';

                    $trcount++;
                    }
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
    //alert("HI"+$.ui.version);
    
    handleDateRange('date-picker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    // handleCheckAllGrids('date-picker-posting');
    
    $(".select2Form").select2({ allowClear: true });

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'postingSave'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalAddForm', 'btnPosting', confirmTitle, formAction);

    // action for CheckAll
    handleCheckAllGrid('check-all');
    // handleCheckAllGrids('check-all');
    
    $(".nominal").autoNumeric({aSep: "", aDec: "."});
});
</script>




