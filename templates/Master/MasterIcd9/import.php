<?php
/**
 * @var \App\View\AppView $this
 * @var array|null $result
 */
?>

<?= $this->Krs->breadcrumb('Master', 'ICD-9 CM', 'Import') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Import ICD-9 CM</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="alert alert-info">
            Upload file CSV/XLSX dari SATUSEHAT dengan kolom <strong>CODE</strong> dan <strong>DISPLAY</strong>.
            Kode yang sudah ada akan diperbarui, kode baru akan ditambahkan.
        </div>

        <?= $this->Form->create(null, ['type' => 'file']) ?>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">File <span class="text-danger">*</span></label>
            <div class="col-md-6">
                <?= $this->Form->file('file', [
                    'class' => 'form-control',
                    'accept' => '.csv,.txt,.xlsx',
                    'required' => true,
                ]) ?>
                <small class="form-text text-muted">
                    Format yang dibaca: CSV/TXT/XLSX. Header wajib: CODE dan DISPLAY.
                </small>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-10 offset-md-2">
                <?= $this->Form->button('<i class="fa fa-upload"></i> Import Data', [
                    'class' => 'btn btn-primary',
                    'escapeTitle' => false,
                ]) ?>
                <?= $this->Html->link(
                    '<i class="fa fa-arrow-left"></i> Kembali',
                    ['action' => 'index'],
                    ['class' => 'btn btn-default', 'escape' => false]
                ) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <?php if (!empty($result)): ?>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <div class="alert alert-success text-center">
                        <strong><?= h($result['inserted'] ?? 0) ?></strong><br>Baru
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-primary text-center">
                        <strong><?= h($result['updated'] ?? 0) ?></strong><br>Update
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-warning text-center">
                        <strong><?= h($result['skipped'] ?? 0) ?></strong><br>Dilewati
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-danger text-center">
                        <strong><?= h($result['failed'] ?? 0) ?></strong><br>Gagal
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-secondary text-center">
                        <strong><?= h($result['duplicates'] ?? 0) ?></strong><br>Duplikat File
                    </div>
                </div>
            </div>

            <?php if (!empty($result['errors'])): ?>
                <div class="alert alert-danger">
                    <strong>Detail gagal:</strong>
                    <ul class="m-b-0">
                        <?php foreach ($result['errors'] as $error): ?>
                            <li><?= h($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
