<?php $dataChild = $this->Html->link('Kehadiran', ['action' => 'index'], ['full_base' => true]); ?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">
    <?= $this->Form->create($hrgaAttendance) ?>
    <div class="panel-body">
        <?php echo $this->Form->control('is_update', ['type' => 'hidden', 'value' => $getUser->id]); ?>
        <div class="table-toolbar">
            <div class="btn-group">
                <div class="portlet-body">
                    <h6 class="text-inverse">ATUR PERODE TANGGAL</h6>
                </div>
            </div>
        </div>
        <br>        
        <div class="row">
            <div class="col-lg-6">
                <label for="">Periode Tanggal *</label>
                <div class="row">
                    <div class="col-md-8">
                        <?php
                        // gunakan $start / $end dari controller (computed dari lines)
                        $startDisplay = isset($start) && $start ? $start->format('d/m/Y') : '';
                        $endDisplay = isset($end) && $end ? $end->format('d/m/Y') : '';
                        $rangeValue = $startDisplay && $endDisplay ? $startDisplay . ' - ' . $endDisplay : $startDisplay;
                        ?>
                        <input type="text" class="form-control range" name="date" placeholder="Tanggal libur" value="<?= h($rangeValue) ?>" readonly>
                    </div>
                    <!-- <div class="col-md-4">
                        <button type="button" class="btn btn-yellow" id="cari" data-toggle="tooltip" data-placement="top" data-original-title="Cari">Cari Data</button>
                    </div> -->
                </div>
            </div>
        </div>
        <hr>
        <div id="detail" class="mt-4">
            <?php if (!empty($hrgaAttendance->hrga_attendance_lines) && count($hrgaAttendance->hrga_attendance_lines)): ?>
                <?php foreach ($hrgaAttendance->hrga_attendance_lines as $i => $line): ?>
                    <?= $this->Form->hidden("lines.$i.id", ['value' => $line->id]) ?>
                    <?= $this->Form->hidden("lines.$i.hrga_employee_id", ['value' => $line->hrga_employee_id]) ?>

                    <div class="row attendance-line mb-3">
                        <div class="col-lg-3">
                            <label>Pegawai</label>
                            <input type="text" class="form-control" value="<?= h($line->hrga_employee->name ?? $line->hrga_employee_id) ?>" readonly>
                        </div>
                        <div class="col-lg-3">
                            <label>Jumlah Hadir</label>
                            <?= $this->Form->control("lines.$i.qty", ['type' => 'text', 'class' => 'form-control', 'value' => $line->qty ?? 0, 'label' => false]) ?>
                        </div>
                        <div class="col-lg-3">
                            <label>Terlambat Masuk</label>
                            <?= $this->Form->control("lines.$i.qty_lateness", ['type' => 'text', 'class' => 'form-control', 'value' => $line->qty_lateness ?? 0, 'label' => false]) ?>
                        </div>
                        <div class="col-lg-3">
                            <label>Lembur</label>
                            <?= $this->Form->control("lines.$i.qty_overtime", ['type' => 'text', 'class' => 'form-control', 'value' => $line->qty_overtime ?? 0, 'label' => false]) ?>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada data kehadiran pada periode ini.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>


<script>
    $(document).ready(() => {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'edit', $hrgaAttendance->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
    });
</script>