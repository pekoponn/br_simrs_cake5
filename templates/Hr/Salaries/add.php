<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary $salary
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
$dataChild = $this->Html->link('Slip Gaji', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('Form', $dataChild, 'Baru') ?>

<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($salary) ?>
        <!-- panel head  -->
    <input type="hidden" name="is_create" value="<?= $getUser->id ?>">
    <input type="hidden" name="user_id" value="<?= $getUser->id ?>">
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="btn-group">
                <div class="portlet-body">
                    <h6 class="text-inverse">Slip Gaji</h6>
                </div>
            </div>
            <hr>
            <div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('hrga_employee_id', [
                                'label' => 'User', 
                                'class' => 'form-control select2',
                                'options' => $hrgaEmployees, 
                                'empty' => 'Pilih Nama Pegawai',
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('gaji_pokok', [
                                'label' => 'Gaji Pokok', 
                                'class' => 'form-control auto',
                                'placeholder' => 'Gaji Pokok',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('tunjangan_harian', [
                                'label' => 'Tunjangan Harian', 
                                'class' => 'form-control auto',
                                'placeholder' => 'Tunjangan Harian',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('tunjangan_jabatan', [
                            'label' => 'Tunjangan Jabatan',
                            'class' => 'form-control auto',
                            'type' => 'text',
                            'autocomplete' => 'off',
                            'placeholder' => 'Tunjangan Jabatan'
                        ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('tunjangan_makan', [
                            'label' => 'Tunjangan Makan',
                            'class' => 'form-control auto',
                            'type' => 'text',
                            'autocomplete' => 'off',
                            'placeholder' => 'Tunjangan Makan'
                        ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('tunjangan_produktifitas', [
                            'label' => 'Tunjangan Produktifitas',
                            'class' => 'form-control auto',
                            'type' => 'text',
                            'autocomplete' => 'off',
                            'placeholder' => 'Tunjangan Produktifitas'
                        ]); ?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('tunjangan_struktural', [
                                'label' => 'Tunjangan Struktural', 
                                'class' => 'form-control auto',
                                'placeholder' => 'Tunjangan Struktural',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div>
                    <!-- <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('bpjs_kesehatan', [
                                'label' => 'BPJS Kesehatan', 
                                'class' => 'form-control auto',
                                'placeholder' => 'BPJS Kesehatan',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('bpjs_ketenagakerjaan', [
                                'label' => 'BPJS Ketenagakerjaan', 
                                'class' => 'form-control auto',
                                'placeholder' => 'BPJS Ketenagakerjaan',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('bpjs_pensiun', [
                                'label' => 'BPJS Pensiun', 
                                'class' => 'form-control auto',
                                'placeholder' => 'BPJS Pensiun',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div> -->
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form3-group">
                            <label><h4><strong>Total Gaji Bersih</strong></h4></label>
                            <h4 id="totalGajiDisplay" class="text-success">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?= $this->Form->button('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<?php if ($salary->getErrors()) : ?>
    <div class="alert alert-danger">
        <?php foreach ($salary->getErrors() as $field => $errors) : ?>
            <strong><?= h($field) ?>:</strong>
            <?= implode(', ', $errors) ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $('.date1').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            orientation: 'bottom'
        });
        $('.select2').select2({
            allowClear: true
        });

        function autoNumber() {
            $('input.auto').autoNumeric({aSep: '.', aDec: ',', mDec: 0, vMax: '999999999'});
            $('input.qty').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000'});
            $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});
        }
        autoNumber();

        // Function untuk format Rupiah
        function formatRupiah(num) {
            if (!num || isNaN(num)) return '0';
            return parseInt(num, 10).toLocaleString('id-ID');
        }

        // Function untuk extract angka dari input dengan format
        function extractNumber(str) {
            return str ? parseInt(str.toString().replace(/[^\d]/g, ''), 10) || 0 : 0;
        }

        // Function untuk hitung total gaji
        function hitungTotalGaji() {
            const gajiPokok = extractNumber($('input[name="gaji_pokok"]').val());
            const tunjanganHarian = extractNumber($('input[name="tunjangan_harian"]').val());
            const tunjanganJabatan = extractNumber($('input[name="tunjangan_jabatan"]').val());
            const tunjanganMakan = extractNumber($('input[name="tunjangan_makan"]').val());
            const tunjanganProduktifitas = extractNumber($('input[name="tunjangan_produktifitas"]').val());
            const tunjanganStruktural = extractNumber($('input[name="tunjangan_struktural"]').val());
            const bpjsKesehatan = extractNumber($('input[name="bpjs_kesehatan"]').val());
            const bpjsKetenagakerjaan = extractNumber($('input[name="bpjs_ketenagakerjaan"]').val());
            const bpjsPensiun = extractNumber($('input[name="bpjs_pensiun"]').val());

            const total = gajiPokok + tunjanganHarian + tunjanganJabatan + tunjanganMakan 
                        + tunjanganProduktifitas + tunjanganStruktural - bpjsKesehatan - bpjsKetenagakerjaan - bpjsPensiun;

            // Update hidden field dan display
            $('input[name="total_gaji"]').val(total);
            $('#totalGajiDisplay').text(formatRupiah(total));
        }

        // Trigger hitung saat input berubah
        $('input[name="gaji_pokok"], input[name="tunjangan_harian"], input[name="tunjangan_jabatan"], ' +
          'input[name="tunjangan_makan"], input[name="tunjangan_produktifitas"], input[name="tunjangan_struktural"]' +
          ', input[name="bpjs_kesehatan"], input[name="bpjs_ketenagakerjaan"], input[name="bpjs_pensiun"]')
            .on('input change', function() {
                hitungTotalGaji();
            });

        // Hitung saat form pertama kali load
        hitungTotalGaji();

        // Validasi sebelum submit form
        $('form').on('submit', function(e) {
            e.preventDefault();

            let isValid = true;
            let errorMessage = '';

            if ($('select[name="hrga_employee_id"]').val() === '' || $('select[name="hrga_employee_id"]').val() === null) {
                isValid = false;
                errorMessage += 'User harus dipilih.\n';
            }

            if (extractNumber($('input[name="gaji_pokok"]').val()) === 0) {
                isValid = false;
                errorMessage += 'Gaji Pokok harus diisi.\n';
            }

            if (!isValid) {
                alert(errorMessage);
                return;
            }

            SwalHelper.confirm('Apakah Anda yakin ingin menyimpan data ini?', '', 'Ya, simpan', 'Batal')
                .then((result) => {
                    if (result.isConfirmed) {
                        $('input.auto').each(function() {
                            $(this).val(extractNumber($(this).val()));
                        });

                        this.submit();
                    }
                });
        });
    });
</script>