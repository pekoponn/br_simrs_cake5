<?php
use Cake\Chronos\Date;
$dataChild = $this->Html->link('Form Lembur', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Menyetujui') ?>

<div class="panel panel-inverse">
    <?= $this->Form->create($overtime) ?>
    <?= $this->Form->control('approved', ['type' => 'hidden', 'value' => $getUser->id]); ?>
    <?= $this->Form->control('approved_date', ['type' => 'hidden', 'value' => new Date()]); ?>
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Form Lembur</h4>
                    <hr>
                    <div class="row m-b-15">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Nama Pemohon</b></div>
                                <div class="col-4 col-sm-4">: <span><?= $overtime->user->name ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Tanggal</b></div>
                                <div class="col-4 col-sm-4">: <span><?php echo $overtime->date != null ? date_format($overtime->date, 'd F Y') : 'null   ' ?></span></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <h5 class="card-title">Detail Jam Lembur</h5>
                                        <thead class="thead-dark">
                                            <tr>
                                                <th colspan="2">SPKL</th>
                                                <th colspan="2">Realisasi</th>
                                                <th colspan="2">Jam yang di Approve</th>
                                            </tr>
                                            <tr>
                                                <th>Jam Mulai</th>
                                                <th>Jam Akhir</th>
                                                <th>Jam Mulai</th>
                                                <th>Jam Akhir</th>
                                                <th>Jam Mulai</th>
                                                <th>Jam Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?= !empty($overtime->work_order->work_order_lines) ? $overtime->work_order->work_order_lines[0]->time_from : '-' ?></td>
                                                <td><?= !empty($overtime->work_order->work_order_lines) ? $overtime->work_order->work_order_lines[0]->time_end : '-' ?></td>

                                                <td><?=  $overtime->time_from ?></td>
                                                <td><?=  $overtime->time_end ?></td>

                                                <td>
                                                    <?= $this->Form->control('time_from_approve', ['label' => false, 'class' => 'form-control clockpicker', 'value' => $overtime->time_from]) ?>
                                                </td>
                                                <td>
                                                    <?= $this->Form->control('time_end_approve', ['label' => false, 'class' => 'form-control clockpicker', 'value' => $overtime->time_end]) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Deskripsi</b></div>
                                <div class="col-4 col-sm-4">:</div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <span><?= $overtime->description ? $this->Krs->fDecode($overtime->description) : '-' ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="form-check">
                                <?= $this->Form->checkbox('status_approve', [
                                    'value' => 'Y',
                                    'hiddenField' => 'N',
                                    'checked' => true,
                                    'id' => 'checkbox-approve',
                                    'class' => 'form-check-input'
                                ]); ?>

                                <label for="checkbox-approve" class="form-check-label ml-1">
                                    Setujui Surat Perintah Kerja Lembur ini
                                </label>
                            </div>

                            <small class="text-muted d-block ml-4 mt-1">
                                Centang untuk menyetujui, hapus centang untuk menolak
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <?= $this->Form->control('approved_description', ['label' => 'Catatan Menyetujui', 'class' => 'form-control', 'type' => 'textarea']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Menyetujui', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>


<script>
    $(document).ready(() => {
        // var confirmTitle = "Apakah anda ingin menyetujui data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'Overtimes', 'action' => 'approve', $overtime->id], ['fullBase' => true]); ?>";
        // handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
        $('.clockpicker').clockpicker({
            'default': 'now',
            vibrate: true,
            placement: 'bottom',
            // align: "left",
            autoclose: true,
        });
        $('#btn-add').on('click', function (e) {
            e.preventDefault();

            const isChecked = $('#checkbox-approve').is(':checked');
            const message = isChecked 
                ? 'Apakah Anda yakin ingin menyetujui Lembur ini?' 
                : 'Apakah Anda yakin ingin menolak Lembur ini?';

            SwalHelper.confirm(message, '', 'Ya, simpan', 'Batal').then((result) => {
                if (result.isConfirmed) {
                    $('form').submit();
                }
            }); 
        });
    });
</script>