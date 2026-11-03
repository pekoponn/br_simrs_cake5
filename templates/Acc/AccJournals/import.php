<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount[]|\Cake\Collection\CollectionInterface $accChartOfAccounts
 */
use Cake\Utility\Text;
?>
<?= $this->Krs->breadcrumb('Accounting', 'Jurnal', 'Import (Melalui Excel)') ?>

<div class="panel">
    <div class="panel-body bg-warning-transparent-4">
        <div class="portlet-body form">
            <div class="table-toolbar">
            	<div class="btn-group">
            		<?= $this->Form->create($accJournal, ['type' => 'file', 'url' => ['prefix' => 'Acc', 'action' => 'import', 'preview']]) ?>
					<div class="portlet-body">
						<div class="note note-warning">
							<div class="note-icon"><i class="fas fa-upload"></i></div>
							<div class="note-content text-end">								
								<h4><b>Import Journal melalui file Excel...</b></h4>
								<?php
								echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
								echo $this->Form->file('filename', array('label' => false, 'size' => '50'));							
								
								echo $this->Form->button('Tampilkan', ['class'=>'btn btn-primary', 'type'=>'submit', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Import", 'id'=> 'btn-upload']);
								?>
								<div class="btn-group dropdown">
		                            <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
		                            <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
		                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		                            <?= $this->Html->link('Contoh Excel', ['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'importExampleXls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
		                            <?= $this->Html->link('Contoh COA', ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'beginningBalanceExportImportXls', 'Y'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
                                    <?= $this->Html->link('Contoh Cabang', ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'xls', 'Y'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
		                            </div>
		                        </div>
                                <br>
                                <small class="f-s-12">Dimohon data Excel dibawah 80 baris, agar tidak terjadi gagal Upload.</small>
							</div>
						</div>						
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
            </div>
            <br>
            <?php 
            if($data['show']=='Y') { 
            	// pr($data['showExl']);
                if ((isset($data['showExl']))) {
            ?>
            <?= $this->Form->create($accJournal) ?>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th width="150" colspan="2">Kode COA</th>
                            <th>Uraian</th>
                            <th width="150">Debet</th>
                            <th width="150">Saldo Awal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if (count($data['showExl']) > 0) {
                            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
                            $b = 0;
                            foreach ($data['showExl'] as $dataJournalMany) {
                                list($branchId, $journalType, $date, $penanggungJawab, $judul, $codeCoa, $uraian, $debet, $credit) = explode('^', $dataJournalMany[0]);

                                echo $this->Form->control('datas.'.$b.'.branch_id', ['type' => 'hidden', 'value' => $branchId]);
                                echo $this->Form->control('datas.'.$b.'.dates', ['type' => 'hidden', 'value' => $date]);
                                echo $this->Form->control('datas.'.$b.'.recipient_payer_name', ['type' => 'hidden', 'value' => $penanggungJawab]);
                                echo $this->Form->control('datas.'.$b.'.journal_type', ['type' => 'hidden', 'value' => $journalType]);
                                echo $this->Form->control('datas.'.$b.'.subject', ['type' => 'hidden', 'value' => $judul]);

                            	$debets = array();
                            	$credits = array();
                            	$a = 0;
                                // pr($dataJournalMany);
                                foreach ($dataJournalMany as $keyJournal => $dataJournal) {
                                    

                            		list($branchIdLine, $journalTypeLine, $dateLine, $penanggungJawabLine, $judulLine, $codeCoaLine, $uraianLine, $debetLine, $creditLine) = explode('^', $dataJournal);
                            		$debets[] = $debetLine;
                            		$credits[] = $creditLine;

                            		$debetNominalLine = ($debetLine==0 || empty($debetLine)) ? '0,00' : $this->Krs->nom($debetLine);
                            		$creditNominalLine = ($creditLine==0 || empty($creditLine)) ? '0,00' : $this->Krs->nom($creditLine);
                            		
                            		$debetDisable = ($debetLine==0 || empty($debetLine)) ? true : false;
                            		$creditDisable = ($creditLine==0 || empty($creditLine)) ? true : false;                                  

                            	if($a==0) {
	                            	echo '<tr class="table-warning">
	                            		<td width="20">'.$this->Form->checkbox('datas.'.$b.'.published', ['value' => 'Y', 'hiddenField' => 'N', 'checked'=>true]).'</td>
	                                    <td colspan="4"><b>Cabang</b> : '.$branchIdLine.'<br><b>Tanggal</b> : '.$dateLine.'<br><b>Penanggung Jawab</b> : '.$penanggungJawabLine.'<br><b>Judul</b> : '.$judulLine.'</td>
                                    </tr>';
	                            }

                            	echo '<tr>
                                    <td class="text-right" colspan="2">'.$this->Form->input('datas.'.$b.'.line.'.$keyJournal.'.codecoa', array("autocomplete"=>"off", 'class'=>'form-control', 'placeholder' => 'Kode COA..', 'value'=>$codeCoaLine)).'</td>
                                    <td class="text-right">'.$this->Form->input('datas.'.$b.'.line.'.$keyJournal.'.uraian', array("autocomplete"=>"off", 'class'=>'form-control', 'placeholder' => 'Uraian..', 'value'=>$uraianLine)).'</td>
                                    <td class="text-right">'.$this->Form->input('datas.'.$b.'.line.'.$keyJournal.'.debet', array("autocomplete"=>"off", 'class'=>'form-control nom', 'placeholder' => 'Debit..', 'value'=>$debetNominalLine, 'readonly'=>$debetDisable)).'</td>
                                    <td class="text-right">'.$this->Form->input('datas.'.$b.'.line.'.$keyJournal.'.credit', array("autocomplete"=>"off", 'class'=>'form-control nom', 'placeholder' => 'Kredit..', 'value'=>$creditNominalLine, 'readonly'=>$creditDisable)).'</td>
                                </tr>';
                                $a++;
                            	}
                        		$totalDebet = round(array_sum($debets),2);
                        		$totalCredit = round(array_sum($credits),2);
                        		
                        		$classTotal = ($totalDebet==$totalCredit) ? 'table-success' : 'table-danger';

                            	echo '<tr class="'.$classTotal.'">
                                    <td colspan="3" align="right"><b>TOTAL</b></td>
                                    <td class="text-right"><b>'.$this->Krs->nom($totalDebet).'</b></td>
                                    <td class="text-right"><b>'.$this->Krs->nom($totalCredit).'</b></td>
                                </tr>';
                            $b++;
                            }
                        }
                        

                        
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer text-right bg-orange">
            <?php
            echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add']);
            ?>
            </div>   
            <?= $this->Form->end() ?>
            <?php 
                } else {
                    echo $this->Krs->emptyData();
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var confirmTitle = "Apakah anda memproses data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'import', 'save'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalAddForm', 'btn-add', confirmTitle, formAction);

    $('input.nom').autoNumeric({aSep: '.', aDec: ','});
});
</script>
