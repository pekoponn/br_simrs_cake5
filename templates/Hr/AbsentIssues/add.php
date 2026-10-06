<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AbsentIssue $absentIssue
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
$dataChild = $this->Html->link('Laporan Pengaduan Absensi', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('Form', $dataChild, 'Baru') ?>
<div class="panel panel-inverse" data-sortable-id="form-stuff-1">
    <?= $this->Form->create($absentIssue, ['type' => 'file']) ?>
        <!-- panel head  -->
    <input type="hidden" name="is_create" value="<?= $getUser->id ?>">
    <input type="hidden" name="user_id" value="<?= $getUser->id ?>">
    <div class="panel-body">
        <div class="table-toolbar">
            <!-- <div class="btn-group">
                <div class="portlet-body">
                    <h6 class="text-inverse">Laporan Pengaduan Absensi</h6>
                </div>
            </div>
            <hr> -->
            <div>
                <div class="row mb-3">
                    <?php for ($i = 1; $i <= 2; $i++) : ?>
                        <div class="col-md-2">
                            <div class="form3-group">
                                <?= $this->Form->control('file_' . $i, [
                                    'type' => 'file',
                                    'label' => 'Foto Bukti ' . $i,
                                    'class' => 'form-control',
                                    'required' => false
                                ]); ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <?= $this->Form->control('description', [
                    'label' => 'Keterangan',
                    'class' => 'form-control',
                    'placeholder' => 'Keterangan',
                    'type' => 'textarea'
                ]); ?>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?= $this->Form->button('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            const file1 = $('input[name="file_1"]')[0].files.length;
            const file2 = $('input[name="file_2"]')[0].files.length;
            const description = $('textarea[name="description"]').val().trim();
            if (file1 === 0 && file2 === 0) {
                e.preventDefault();
                SwalHelper.warning(
                    "Dokumen Bukti Belum Diunggah",
                    "Minimal 1 dokumen bukti harus diunggah.",
                    "warning"
                );
                return false;
            }
            if (description === '') {
                e.preventDefault();
                SwalHelper.warning(
                    "Keterangan Belum Diisi",
                    "Silakan isi keterangan pengaduan absensi.",
                    "warning"
                );

                return false;
            }
        });
    });
</script>