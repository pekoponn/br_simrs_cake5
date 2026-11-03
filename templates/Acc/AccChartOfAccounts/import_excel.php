<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount $accChartOfAccount
 * @var array $rows
 * @var string $show
 */

// Daftar pilihan untuk dropdown di halaman preview — diambil langsung
// dari KrsHelper (satu sumber, sama dengan yang dipakai di tempat lain).
$journalTypeOptions   = $this->Krs->selectCOAType(); // ['kas_setara_kas' => 'Kas dan Setara Kas', ...]
$normalBalanceOptions = $this->Krs->statusDC();      // ['D' => 'Debit', 'C' => 'Kredit']
$postOptions          = $this->Krs->statusPost();    // ['neraca' => 'Neraca', 'laba-rugi' => 'Laba/Rugi']
?>
<?= $this->Krs->breadcrumb('Accounting', 'Chart of Account', 'Import (Melalui Excel)') ?>

<div class="panel">
    <div class="panel-body bg-warning-transparent-4">
        <div class="portlet-body form">
            <div class="table-toolbar">
                <div class="btn-group">
                    <?= $this->Form->create($accChartOfAccount, ['type' => 'file', 'url' => ['action' => 'importExcel', 'preview']]) ?>
                    <div class="portlet-body">
                        <div class="note note-warning">
                            <div class="note-icon"><i class="fas fa-upload"></i></div>
                            <div class="note-content text-end">
                                <h4><b>Import Chart of Account melalui file Excel...</b></h4>
                                <?php
                                echo $this->Form->file('filename', array('label' => false, 'size' => '50'));
                                echo $this->Form->button('Tampilkan', ['class' => 'btn btn-primary', 'type' => 'submit', 'escapeTitle' => false, 'data-toggle' => 'tooltip', 'data-original-title' => "Import", 'id' => 'btn-upload']);
                                ?>
                                <div class="btn-group dropdown">
                                    <a href="javascript:(void);" class="btn btn-inverse"><i class="fa fa-download"></i></a>
                                    <a href="javascript:(void);" class="btn btn-inverse dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <?= $this->Html->link('Contoh Excel COA', ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'templateExcel'], ['class' => 'dropdown-item', 'escape' => false, 'fullBase' => true]) ?>
                                    </div>
                                </div>
                                <br>
                                <small class="f-s-12">
                                    Kolom Excel: <b>Header</b> (angka, wajib), <b>Sub Header</b> (2 digit), <b>Group</b> (2 digit), <b>Detail</b> (4 digit), <b>Nama COA</b> (wajib),
                                    <b>Jenis Jurnal</b>, <b>Saldo Normal</b>, <b>Post</b>.
                                    Isi kolom sesuai level akun — lihat sheet "Petunjuk" pada template.
                                    Kalau salah ketik / kosong, 3 kolom terakhir bisa dipilih ulang lewat dropdown di tabel preview di bawah — tersedia di semua level.
                                </small>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
            <br>
            <?php if ($show == 'Y' && !empty($rows)) : ?>
            <?= $this->Form->create($accChartOfAccount, ['url' => ['action' => 'importExcel', 'save']])?>
            <div class="table-responsive">
                <table class="table table-hover table-td-valign-middle">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th width="30">
                                <input type="checkbox" id="chk-all" checked>
                            </th>
                            <th width="80">Level</th>
                            <th width="150">Kode COA</th>
                            <th>Nama COA</th>
                            <th width="90">Header</th>
                            <th width="100">Sub Header</th>
                            <th width="90">Group</th>
                            <th width="90">Detail</th>
                            <th width="200">Jenis Jurnal</th>
                            <th width="120">Saldo Normal</th>
                            <th width="120">Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $row) :
                            $rowClass = $row['is_duplicate'] ? 'table-danger' : '';
                            $indent   = ($row['level'] - 1) * 16; 
                            $selectedJournal = null;
                            foreach ($journalTypeOptions as $key => $label) {
                                if (strcasecmp(trim($label), trim($row['journal_type'])) === 0) {
                                    $selectedJournal = $key;
                                    break;
                                }
                            }

                            $selectedDC = null;
                            foreach ($normalBalanceOptions as $key => $label) {
                                if (strcasecmp(trim($label), trim($row['normal_balance'])) === 0) {
                                    $selectedDC = $key;
                                    break;
                                }
                            }

                            $selectedPost = null;
                            foreach ($postOptions as $key => $label) {
                                if (strcasecmp(trim($label), trim($row['groups'] ?? '')) === 0) {
                                    $selectedPost = $key;
                                    break;
                                }
                            }
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td class="text-center">
                                <input type="checkbox"
                                       class="row-check"
                                       id="chk_<?= $i ?>"
                                       <?= !$row['is_duplicate'] ? 'checked' : '' ?>
                                       <?= $row['is_duplicate'] ? 'disabled' : '' ?>>
                            </td>
                            <td class="text-center"><?= $row['level'] ?></td>
                            <td style="padding-left: <?= $indent ?>px;">
                                <input type="text" class="form-control" value="<?= h($row['code']) ?>" readonly>
                                <?php if ($row['is_duplicate']) : ?>
                                    <small class="text-danger">Kode sudah ada, dilewati</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <input type="text" class="form-control name-input" id="name_<?= $i ?>" value="<?= h($row['name']) ?>">
                            </td>
                            <td class="text-center"><?= h($row['header']) ?></td>
                            <td class="text-center"><?= h($row['sub_header']) ?: '-' ?></td>
                            <td class="text-center"><?= h($row['group']) ?: '-' ?></td>
                            <td class="text-center"><?= h($row['detail']) ?: '-' ?></td>

                            <!-- Jenis Jurnal — sekarang tampil di SEMUA level -->
                            <td>
                                <select class="form-control select2Form" id="jurnal_<?= $i ?>">
                                    <option value="">-- Pilih Jenis Jurnal --</option>

                                    <?php if (!empty($row['journal_type']) && $selectedJournal === null) : ?>
                                        <option value="" selected>
                                            <?= h($row['journal_type']) ?> (tidak dikenali, cek lagi)
                                        </option>
                                    <?php endif; ?>

                                    <?php foreach ($journalTypeOptions as $key => $label) : ?>
                                        <option value="<?= h($key) ?>"
                                            <?= $selectedJournal === $key ? 'selected' : '' ?>>
                                            <?= h($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2Form" id="saldo_<?= $i ?>">
                                    <option value="">-- Pilih --</option>

                                    <?php if (!empty($row['normal_balance']) && $selectedDC === null) : ?>
                                        <option value="" selected>
                                            <?= h($row['normal_balance']) ?> (cek lagi)
                                        </option>
                                    <?php endif; ?>

                                    <?php foreach ($normalBalanceOptions as $key => $label) : ?>
                                        <option value="<?= h($key) ?>"
                                            <?= $selectedDC === $key ? 'selected' : '' ?>>
                                            <?= h($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <!-- Post — sekarang tampil di SEMUA level -->
                            <td>
                                <select class="form-control select2Form" id="post_<?= $i ?>">
                                    <option value="">-- Pilih --</option>

                                    <?php if (!empty($row['groups']) && $selectedPost === null) : ?>
                                        <option value="" selected>
                                            <?= h($row['groups']) ?> (cek lagi)
                                        </option>
                                    <?php endif; ?>

                                    <?php foreach ($postOptions as $key => $label) : ?>
                                        <option value="<?= h($key) ?>"
                                            <?= $selectedPost === $key ? 'selected' : '' ?>>
                                            <?= h($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!--
                Semua data baris (level, code, parent_id, dst) dikirim lewat
                SATU field JSON ini, bukan puluhan hidden input per baris.
                Ini untuk menghindari warning "Input variables exceeded 1000"
                kalau Excel-nya berisi ratusan baris COA.
            -->
            <?= $this->Form->hidden('rows_json', ['id' => 'rows-json']) ?>

            <div class="panel-footer text-right bg-orange">
                <?php
                echo $this->Form->button('Simpan', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
                ?>
            </div>
            <?= $this->Form->end() ?>
            <?php elseif ($show == 'Y') : ?>
                <?= $this->Krs->emptyData() ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($show == 'Y' && !empty($rows)) : ?>
<script>
// Data mentah hasil hitung dari controller (level, code, parent_id, dll)
// Ini TIDAK dikirim langsung sebagai input form, cuma dipakai JS untuk
// digabung dengan nilai terbaru (nama yang diedit user, checkbox tercentang,
// dan pilihan dropdown Jenis Jurnal/Saldo Normal/Post) sesaat sebelum form di-submit.
var previewRowsData = <?= json_encode(array_map(function ($row) {
    return [
        'code'               => $row['code'],
        'level'              => $row['level'],
        'parent_id'          => $row['parent_id'],
        'parent_account'     => $row['parent_account'],
        'header_account'     => $row['header_account'],
        'sub_header_account' => $row['sub_header_account'],
    ];
}, $rows)) ?>;
$(document).ready(function() {
    // centang/hilangkan centang semua sekaligus
    $('#chk-all').on('change', function() {
        $('.row-check:not(:disabled)').prop('checked', $(this).is(':checked'));
    });
    $('.select2Form').select2({ width: '100%' });

    // Bind lebih dulu supaya jalan sebelum handleFormConfirmSubmitValid
    // memproses submit form-nya.
    $('#btn-add').on('click', function() {
        var datas = previewRowsData.map(function(row, i) {
            return {
                published: $('#chk_' + i).is(':checked') ? 'Y' : 'N',
                name: $('#name_' + i).val(),
                code: row.code,
                level: row.level,
                parent_id: row.parent_id,
                parent_account: row.parent_account,
                header_account: row.header_account,
                sub_header_account: row.sub_header_account,
                journal_type: $('#jurnal_' + i).val(),
                normal_balance: $('#saldo_' + i).val(),
                groups: $('#post_' + i).val()
            };
        });
        $('#rows-json').val(JSON.stringify(datas));
        console.log(datas);
    });

    var confirmTitle = "Apakah anda yakin ingin mengimpor data COA tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'importExcel', 'save'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccChartOfAccountAddForm', 'btn-add', confirmTitle, formAction);
});
</script>
<?php endif; ?>