<?= $this->Krs->breadcrumb('HRGA', 'Tanggal Libur', 'Tampilkan') ?>

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
                                <a class="dropdown-item" href="" target="_blank">Pdf File</a>
                                <a class="dropdown-item" href="">Excel File</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="120">Tanggal</th>
                            <th>Keterangan</th>                            
                            <th class="actions text-center" width="120"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // pr($proLabels);
                        $no = 1;
                        if (count($holiday) > 0) {
                            foreach ($holiday as $index => $data) {
                                $linkPreview = array('action' => 'preview', $data->id);
                                $linkEdit = array('action' => 'edit', $data->id);
                                $linkDelete = array('action' => 'delete', $data->id);
                                $dataSts = ($data->is_active == 'Y') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>';
                        ?>
                                <tr>
                                    <td align="center"><?= date_format($data->date, 'd M Y') ?></td>
                                    <td><?= $data->description ?></td>
                                    <td class="actions text-center">
                                        <?= $this->Krs->btn('edit', $linkEdit) ?>
                                        <?= $this->Krs->btn('delete', $linkDelete, $data->name) ?>
                                    </td>
                                </tr>
                            <?php $no++;
                            }
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