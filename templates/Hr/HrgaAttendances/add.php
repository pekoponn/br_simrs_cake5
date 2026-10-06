<?php $dataChild = $this->Html->link('Kehadiran', ['action' => 'index'], ['full_base' => true]); ?>
<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Buat') ?>

<div class="panel panel-inverse">
    <?= $this->Form->create($hrgaAttendance) ?>
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="btn-group">
                <div class="portlet-body">
                    <h6 class="text-inverse">DATA KEHADIRAN</h6>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                <label for="">Periode Tanggal *</label>
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control range" name="date" placeholder="Tanggal libur">                        
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-yellow" id="cari" data-toggle="tooltip" data-placement="top" data-original-title="Cari">Cari Data</button>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="detail">
            <h6 class="text-inverse">HARI LIBUR NASIONAL</h6>
            <br>
            <div class="row" id="isi">
            </div>
            <hr>
            <h6 class="text-inverse">KEHADIRAN PEGAWAI</h6>
            <div class="row">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th width="120">NIP</th>
                            <th>Nama</th>
                            <th width="120">Devisi</th>
                            <th width="120">Posisi</th>
                            <th width="80">Jumlah Hadir</th>
                            <th width="80">Jumlah Terlambat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo $this->Form->control('is_create', ['type' => 'hidden', 'value' => $getUser->id]);
                        // pr($this->Krs->uuidv4());
                        foreach ($dataEmployee as $keyRow => $dataRow) {
                            echo '<tr>
                                    <td class="text-center">'.$dataRow->pin.$this->Form->control('dataRow.'.$keyRow.'.is_create', ['type' => 'hidden', 'value' => $getUser->id]).'</td>
                                    <td>'.$dataRow->name.'</td>
                                    <td class="text-center">'.$this->Krs->devision($dataRow->devisi).'</td>
                                    <td class="text-center">'.$this->Krs->position($dataRow->position).'</td>
                                    '.$this->Form->control('hrga_attendance_lines.'.$keyRow.'.hrga_employee_id', ['type' => 'hidden', 'value' => $dataRow->id]).'
                                    <td class="text-center">'.$this->Form->control('hrga_attendance_lines.'.$keyRow.'.qty', ['label' => false, 'class' => 'form-control jumlah qty', 'autocomplete' => 'off', 'data-user-id' => $dataRow->user_id]).'</td>
                                    <td class="text-center">'.$this->Form->control('hrga_attendance_lines.'.$keyRow.'.qty_lateness', ['label' => false, 'class' => 'form-control terlambat qty', 'autocomplete' => 'off', 'value' => 0, 'data-user-id' => $dataRow->user_id]).'</td>
                                </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?= $this->Krs->paginators() ?>       
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add', 'disabled'=>true]);
        ?>
    </div>
    <?= $this->Form->end() ?>
    
</div>


<script>
    $(document).ready(() => {
        var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'add'], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

        $('input.qty').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '30', mDec: '0'});

        // $('#detail').hide();
        $('.select').select2({
            placeholder: 'Masukkan 2 digit huruf pegawai',
            minimumInputLength: 2,
            ajax: {
                dataType: 'json',
                url: '<?php echo $this->url->build(['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'getemployee']); ?>',
                delay: 200,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data, page) {
                    return {
                        results: data
                    };
                },
                cache: true,
            }
        });

        $('.range').daterangepicker({
            startDate: moment(),
            endDate: moment().add(30, 'day'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).on('click', '#cari', () => {
            $.ajax({
                url: "<?php echo $this->url->build(['prefix' => 'Hr', 'controller' => 'HrgaAttendances', 'action' => 'getdatetotal']); ?>",
                method: "get",
                data: {
                    date: $('.range').val()
                },
                success: function(data) {
                    $('#isi').html('');
                    $('#detail').show();
                    // $('.jumlah').val(data[0]);
                    $.each(data[1], (i, val) => {
                        let ex_date = Date.parse(val.date);
                        $('#isi').append('<br><br><br><div class="col-sm-3"><div class="card bg-dark border-0 text-white"><div class="card-body"><h5 class="card-title text-warning">' + val.description + '</h5><p class="card-text"><i class="fa fa-calendar"></i>&nbsp; ' + moment(ex_date).format('D MMM YYYY') + '</p></div></div></div><br><br><br>');
                    });
                    $('#btn-add').prop("disabled", false);
                    $.ajax({
                        url: "<?= $this->Url->build([
                            'prefix' => 'Hr',
                            'controller' => 'HrgaAttendances',
                            'action' => 'getAbsences'
                        ]) ?>",
                        method: "GET",
                        data: {
                            date: $('.range').val()
                        },
                        success: function(attendanceData) {
                            var attendMap = (attendanceData.attendance) ? attendanceData.attendance : {};
                            var lateMap = (attendanceData.late) ? attendanceData.late : {};

                            $('.jumlah').each(function() {
                                let userId = $(this).data('user-id');
                                if (attendMap[userId] !== undefined) {
                                    $(this).val(attendMap[userId]);
                                } else {
                                    $(this).val(0);
                                }
                            });

                            $('.terlambat').each(function() {
                                let userId = $(this).data('user-id');
                                if (lateMap[userId] !== undefined) {
                                    $(this).val(lateMap[userId]);
                                } else {
                                    $(this).val(0);
                                }
                            });
                        }
                    });
                    //$('#btn-add').show();
                    
                },
                error: function(err) {
                    console.log(err, 'error get data');
                }
            });
        });
    });
</script>