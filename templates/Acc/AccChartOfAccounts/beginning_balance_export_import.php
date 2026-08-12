<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount[]|\Cake\Collection\CollectionInterface $accChartOfAccounts
 */
use Cake\Utility\Text;
?>
<?= $this->Krs->breadcrumb('Accounting', 'Saldo Awal', 'Tampilkan') ?>

<div class="panel">
    <div class="panel-body bg-gray-100">
        <div class="portlet-body form">
            <div class="table-toolbar">
            	<div class="btn-group">
            		<?= $this->Form->create($accChartOfAccounts, ['type' => 'file', 'url' => ['action' => 'beginningBalanceExportImport', 'save']]) ?>
					<?php //echo $this->Form->create('UploadExcel',array('id'=>'fileupload', 'type'=>'file', 'enctype'=>'multipart/form-data', 'url' => array('controller' => 'acc_chart_of_accounts', 'action' => 'export_import_saldo_awal/save'))); ?>
					<div class="portlet-body">
						<div class="note note-warning">
							<div class="note-icon"><i class="fas fa-upload"></i></div>
							<div class="note-content text-end">								
								<h4><b>Upload file Excel...</b></h4>
								<?php
								echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
								echo $this->Form->file('filename', array('label' => false, 'size' => '50'));							
								
								echo $this->Form->button('Upload', ['class'=>'btn btn-primary', 'type'=>'submit', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>"Upload", 'id'=> 'btn-upload']);

								// echo $this->Form->button('Upload', array('class'=>'btn btn-success', 'type'=>'button', 'escape' => false, 'id'=> 'btn-upload'));
								?>
								<div class="btn-group dropdown">
		                            <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
		                            <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
		                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		                            <?= $this->Html->link('Contoh Excel', ['action' => 'beginningBalanceExportImportXls'], ['class'=>'dropdown-item', 'escape' => false, 'fullBase'=>true]) ?>
		                            </div>
		                        </div>
							</div>
						</div>						
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
				<?php
				/*
                <div class="btn-group">
                    <div class="portlet-body">
                        <?= $this->Html->link('<i class="fa fa-plus"></i>', ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'add'], ['class' => 'btn btn-inverse', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'data-original-title' => 'Add', 'escape' => false, 'fullBase' => true]) ?>
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
                */
                ?>
                <div class="btn-group pull-right">
                    <div class="portlet-body">
                        <?= $this->Form->create(null, ['type' => 'get']) ?>
                        <div class="input-group md-form form-sm form-2 pl-0">
                            <input class="form-control my-0 py-1" type="text" placeholder="Cari data ..." aria-label="Search" name="key" value="<?= $this->request->getQuery('key'); ?>">
                            <div class="input-group-append">
                                <button name="filter" class="btn btn-yellow" data-toggle="tooltip" data-placement="top" title="" type="submit" data-original-title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle table-striped">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>Nama</th>
                            <th width="120">Tanggal</th>
                            <th width="150">Jenis Junal</th>
                            <th width="150">Saldo Awal-Debit</th>
                            <th width="150">Saldo Awal-Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // pr($accChartOfAccounts);
                        
                        $no = 1;
                        if (count($accChartOfAccounts) > 0) {
                            foreach ($accChartOfAccounts as $index => $data) :
                                $customer = $data['Customer'];

                                $codeCoa = ($data->level==4) ? "<b>".$data->code."</b>" : $data->code;
                                $statusTransaction = ($data->transaction=="y")? '<i class="fa fa-check"></i>':'';
                                $journalType = (empty($data->journal_type)) ? "" : $this->Krs->selectCOAType($data->journal_type);
                                $dataLevel = $data->level;
                                
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $dataSts = ($data->is_active == 'Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';

                                if($dataLevel==1){
                                    $classCondition = "";
                                }elseif($dataLevel==4){
                                    $classCondition = 'class="table-success"';
                                } else {
                                    $classCondition = "";
                                }

                                $beginningBalanceDebet = (empty($data->beginning_balance_debet)) ? "" : $this->Krs->cur($data->beginning_balance_debet);
                                $beginningBalanceCredit = (empty($data->beginning_balance_credit)) ? "" : $this->Krs->cur($data->beginning_balance_credit);

                                $dataName = (empty($data->name)) ? "" : $this->Text->truncate($data->name, 100, array('ellipsis' => '...', 'exact' => false));
                                $dataDate = (empty($data->beginning_balance_date)) ? '-' : $this->Krs->fDate($data->beginning_balance_date, 'd-m-Y');
                        ?>	
                                <tr <?= $classCondition ?>>
                                    <td><?= '('.$codeCoa.') '.$dataName; ?></td>
                                    <td class="text-center"><?= $dataDate ?></td>
                                    <td class="text-center"><?= $journalType ?></td>
                                    <td class="text-right"><b><?= $beginningBalanceDebet ?></b></td>
                                    <td class="text-right"><b><?= $beginningBalanceCredit ?></b></td>
                                </tr>
                            <?php $no++;
                            endforeach;
                        } else {
                            ?>

                        <?php
                        }
                        
                        
                        ?>
                    </tbody>
                </table>
            </div>
            <?= $this->Krs->paginators() ?>
            
        </div>
    </div>
</div>

