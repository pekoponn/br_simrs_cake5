<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salary $salary
 */
// pr($salary);
// die;
$dataChild = $this->Html->link('Slip Gajian', ['action' => 'index'], ['full_base' => true]);
?>
<?= $this->Krs->breadcrumb('Form', $dataChild, 'Edit') ?>


<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($salary) ?>
    <input type="hidden" name="is_update" value="<?= $getUser->id ?>">
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
                                'disabled' => true
                            ]); ?>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form3-group">
                            <?= $this->Form->control('gaji_pokok', [
                                'label' => 'Gaji Pokok',
                                'class' => 'form-control auto gaji',
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
                                'class' => 'form-control auto gaji',
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
                                'class' => 'form-control auto gaji',
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
                                'class' => 'form-control auto gaji',
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
                                'class' => 'form-control auto gaji',
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
                                'class' => 'form-control auto gaji',
                                'placeholder' => 'Tunjangan Struktural',
                                'type' => 'text',
                                'autocomplete' => 'off'
                            ]); ?>
                        </div>
                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script>
$(document).ready(function () {
    // confirm handler kept if helper exists
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build([
        'prefix' => 'Hr',
        'controller' => 'Salaries',
        'action' => 'edit',
        $salary->id
    ], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);

    $('.select2').select2({
        allowClear: true,
    });

    // init AutoNumeric for visible inputs
    AutoNumeric.multiple('.auto', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        decimalPlaces: 0,
        modifyValueOnWheel: false,
        unformatOnSubmit: true
    });

    function getNumericValue(el) {
        try {
            return AutoNumeric.getNumber(el) || 0;
        } catch (e) {
            return 0;
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function totalGaji() {
        let total = 0;
        $('.gaji').each(function () {
            total += getNumericValue(this);
        });
        $('#totalGajiDisplay').text(formatRupiah(total));
        return total;
    }

    // wire change events
    $('.auto').on('keyup change', function () {
        totalGaji();
    });

    // initial compute
    totalGaji();

    // before submit: AutoNumeric config already includes unformatOnSubmit, but ensure values are raw numbers
    $('form').on('submit', function () {
        $('.auto').each(function () {
            try {
                var raw = AutoNumeric.getNumber(this);
                if (raw === null || raw === undefined) raw = 0;
                // set input value to raw numeric so backend receives normalized number
                $(this).val(raw);
            } catch (e) {
                // fallback: remove thousand separators and convert comma to dot
                var v = $(this).val();
                v = String(v).replace(/\./g, '').replace(/,/g, '.');
                $(this).val(v || 0);
            }
        });
        return true;
    });

});
</script>
