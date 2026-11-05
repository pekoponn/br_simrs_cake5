<?php
/**
 * templates/LabSenderDoctors/index.php
 *
 * @var \App\View\AppView $this
 * @var iterable $doctors
 * @var string $q
 */
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Setup Dokter Pengirim</li>
</ol>
<h1 class="page-header">Setup Dokter Pengirim <small>Daftar Dokter Luar (Pengirim Penunjang Medik)</small></h1>

<?= $this->Flash->render() ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-user-md"></i> Daftar Dokter Luar</h4>
    </div>
    <div class="panel-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search"></i> Cari</span></div>
                    <?= $this->Form->text('q', ['value' => $q, 'class' => 'form-control', 'placeholder' => 'Kode / nama / alamat...']) ?>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-warning">Cari</button>
                        <?= $this->Html->link('<i class="fa fa-sync"></i>', ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Reset']) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="btn-add-doctor">
                    <i class="fa fa-plus"></i> Tambah Dokter
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th style="width:120px;">Kode</th>
                        <th>Nama Dokter</th>
                        <th>Alamat</th>
                        <th style="width:150px;">Phone</th>
                        <th style="width:150px;">Handphone</th>
                        <th style="width:80px;" class="text-center">Status</th>
                        <th style="width:120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $hasRow = false; foreach ($doctors as $d): $hasRow = true; ?>
                    <tr>
                        <td><code><?= h($d->code) ?></code></td>
                        <td><b><?= h($d->name) ?></b></td>
                        <td><?= h($d->address) ?></td>
                        <td><?= h($d->phone) ?></td>
                        <td><?= h($d->mobile) ?></td>
                        <td class="text-center">
                            <?= $d->is_active
                                ? '<span class="badge badge-success">Aktif</span>'
                                : '<span class="badge badge-secondary">Nonaktif</span>' ?>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button" class="btn btn-xs btn-primary btn-edit-doctor"
                                data-id="<?= (int)$d->id ?>"
                                data-code="<?= h($d->code) ?>"
                                data-name="<?= h($d->name) ?>"
                                data-address="<?= h($d->address) ?>"
                                data-phone="<?= h($d->phone) ?>"
                                data-mobile="<?= h($d->mobile) ?>"
                                data-active="<?= (int)$d->is_active ?>"
                                title="Ubah"><i class="fa fa-edit"></i></button>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                ['action' => 'delete', $d->id],
                                ['class' => 'btn btn-xs btn-danger', 'escape' => false, 'title' => 'Hapus',
                                 'confirm' => 'Hapus dokter ' . $d->name . '?']
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$hasRow): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data dokter pengirim</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer d-flex justify-content-between align-items-center">
        <small class="text-muted"><?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}, total {{count}} data') ?></small>
        <ul class="pagination pagination-sm mb-0">
            <?= $this->Paginator->prev('« Sebelumnya') ?>
            <?= $this->Paginator->next('Berikutnya »') ?>
        </ul>
    </div>
</div>

<!-- Modal tambah / ubah -->
<div class="modal fade" id="modal-doctor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['url' => ['action' => 'save'], 'id' => 'form-doctor']) ?>
            <div class="modal-header">
                <h5 class="modal-title" id="modal-doctor-title">Tambah Dokter Pengirim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="doc-id" value="">
                <div class="form-group">
                    <label>Kode</label>
                    <input type="text" name="code" id="doc-code" class="form-control" maxlength="30" placeholder="Kosongkan untuk kode otomatis">
                </div>
                <div class="form-group">
                    <label>Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="doc-name" class="form-control" maxlength="150" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="address" id="doc-address" class="form-control" maxlength="255">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" id="doc-phone" class="form-control" maxlength="30">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Handphone</label>
                        <input type="text" name="mobile" id="doc-mobile" class="form-control" maxlength="30">
                    </div>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="is_active" id="doc-active" value="1" class="custom-control-input" checked>
                    <label class="custom-control-label" for="doc-active">Aktif</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
$(function () {
    var $modal = $('#modal-doctor');

    function openModal(d) {
        $('#modal-doctor-title').text(d ? 'Ubah Dokter Pengirim' : 'Tambah Dokter Pengirim');
        $('#doc-id').val(d ? d.id : '');
        $('#doc-code').val(d ? d.code : '');
        $('#doc-name').val(d ? d.name : '');
        $('#doc-address').val(d ? d.address : '');
        $('#doc-phone').val(d ? d.phone : '');
        $('#doc-mobile').val(d ? d.mobile : '');
        $('#doc-active').prop('checked', d ? String(d.active) === '1' : true);
        $modal.modal('show');
    }

    $('#btn-add-doctor').on('click', function () { openModal(null); });

    $('.btn-edit-doctor').on('click', function () {
        var $b = $(this);
        openModal({
            id: $b.data('id'), code: $b.data('code'), name: $b.data('name'),
            address: $b.data('address'), phone: $b.data('phone'),
            mobile: $b.data('mobile'), active: $b.data('active')
        });
    });

    $modal.on('shown.bs.modal', function () { $('#doc-name').trigger('focus'); });
});
</script>