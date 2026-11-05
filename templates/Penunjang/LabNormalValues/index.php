<?php
$num = fn($v) => $v === null ? '' : rtrim(rtrim(number_format((float)$v, 3, '.', ''), '0'), '.');
?>
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="javascript:;">Penunjang</a></li>
    <li class="breadcrumb-item"><?= $this->Html->link('Laboratorium', ['controller' => 'LabExaminations', 'action' => 'index']) ?></li>
    <li class="breadcrumb-item active">Isi Nilai Normal</li>
</ol>
<h1 class="page-header">Isi Nilai Normal <small>Setting hasil laboratorium</small></h1>

<div class="alert alert-info py-2">
    <i class="fa fa-info-circle"></i>
    Pilih pemeriksaan di kiri, lalu isi rentang normal tiap parameter di kanan.
    Nilai ini dipakai saat input hasil untuk menandai hasil <b>tinggi (H)</b> atau <b>rendah (L)</b>.
</div>

<div class="row">

    <!-- ===== DAFTAR PEMERIKSAAN ===== -->
    <div class="col-lg-3">
        <div class="panel panel-inverse">
            <div class="panel-heading"><h4 class="panel-title"><i class="fa fa-list"></i> Tindakan</h4></div>
            <div class="panel-body p-2">
                <?= $this->Form->create(null, ['type' => 'get', 'valueSources' => ['query']]) ?>
                <div class="input-group input-group-sm mb-2">
                    <?= $this->Form->text('q', ['value' => $q, 'class' => 'form-control', 'placeholder' => 'Cari kode / nama...']) ?>
                    <div class="input-group-append"><button class="btn btn-warning"><i class="fa fa-search"></i></button></div>
                </div>
                <?= $this->Form->end() ?>

                <div class="list-group" style="max-height:560px; overflow-y:auto;">
                <?php foreach ($labs as $l): ?>
                    <?= $this->Html->link(
                        '<small class="text-muted">' . h($l['code']) . '</small><br>' . h($l['name']),
                        ['action' => 'index', '?' => ['lab_id' => $l['id'], 'q' => $q]],
                        ['class' => 'list-group-item list-group-item-action py-1 ' . ((int)$l['id'] === $selectedId ? 'active' : ''), 'escape' => false]
                    ) ?>
                <?php endforeach; ?>
                <?php if (!$labs): ?>
                    <div class="text-muted text-center py-3">Tidak ada data</div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== DETAIL ===== -->
    <div class="col-lg-9">
    <?php if (!$selectedLab): ?>
        <div class="alert alert-warning">Belum ada pemeriksaan yang dipilih.</div>
    <?php else: ?>

        <style>
            .lnv-head { display:flex; align-items:center; gap:10px; flex-wrap:nowrap; background:#f3f4f8; border:1px solid #cfd4e2; padding:6px 8px; margin-bottom:6px; }
            .lnv-head label { margin:0; font-weight:700; font-size:12px; white-space:nowrap; }
            .lnv-head .form-control { height:26px; font-size:12px; padding:2px 6px; }
            .lnv-foot { display:flex; align-items:center; justify-content:space-between; gap:8px; flex-wrap:nowrap; margin-top:6px; }
            .lnv-foot .right { display:flex; gap:6px; flex-wrap:nowrap; }
            .lnv-foot .btn { font-size:12px; padding:3px 14px; white-space:nowrap; }
            .lnv-title { font-weight:700; text-align:center; margin:12px 0 4px; font-size:12px; }
                        /* Tabel dikembalikan putih */
            #form-nilai .table-responsive,
            #form-lembar { background:#fff; }
            #form-nilai table tbody td,
            #form-lembar table tbody td { background:#fff; }
            #form-nilai table tbody td.bg-pria { background:#fdf4ff; }
            #form-nilai table tbody td.bg-wanita { background:#ecfeff; }
            #form-nilai table tbody tr:hover td,
            #form-lembar table tbody tr:hover td { background:#f5f8ff; }
            #form-nilai table, #form-lembar table { border:1px solid #cfd4e2; }
        </style>

        <?= $this->Form->create(null, ['url' => ['action' => 'save'], 'id' => 'form-nilai']) ?>
        <?= $this->Form->hidden('master_laboratory_id', ['value' => $selectedId]) ?>

        <!-- Header: Kode, Golongan, Sub, Tindakan (satu baris) -->
        <div class="lnv-head">
            <label>Kode</label>
            <input type="text" class="form-control" style="width:150px;" value="<?= h($selectedLab['code']) ?>" readonly>
            <label>Golongan</label>
            <input type="text" name="lab_group" class="form-control" style="width:220px;" value="<?= h($selectedLab['lab_group'] ?? '') ?>">
            <label>Sub</label>
            <input type="text" name="lab_subgroup" class="form-control" style="flex:1; min-width:120px;" value="<?= h($selectedLab['lab_subgroup'] ?? '') ?>">
        </div>
        <div class="lnv-head">
            <label style="width:55px;">Tindakan</label>
            <input type="text" class="form-control" style="flex:1;" value="<?= h($selectedLab['name']) ?>" readonly>
        </div>

        <!-- Tabel parameter -->
        <div class="table-responsive">
        <table class="table table-bordered table-sm mb-0" style="font-size:12px; min-width:1300px;">
            <thead class="thead-dark text-center">
                <tr>
                    <th rowspan="2" style="width:30px;"><input type="checkbox" id="chk-all"></th>
                    <th rowspan="2" style="width:90px;">Kode Mesin</th>
                    <th rowspan="2">Keterangan Hasil</th>
                    <th rowspan="2" style="width:80px;">Satuan</th>
                    <th colspan="2">Umum</th>
                    <th colspan="2" style="background:#c026d3;">Pria</th>
                    <th colspan="2" style="background:#0891b2;">Wanita</th>
                    <th colspan="2">Anak</th>
                    <th colspan="2">Uraian</th>
                    <th rowspan="2" style="width:60px;">Desimal</th>
                </tr>
                <tr>
                    <th>Dari</th><th>Sampai</th>
                    <th>Dari</th><th>Sampai</th>
                    <th>Dari</th><th>Sampai</th>
                    <th>Dari</th><th>Sampai</th>
                    <th>Pria</th><th>Wanita</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($values) === 0): ?>
                <tr><td colspan="15" class="text-center text-muted py-4">Belum ada parameter. Klik "Tambah".</td></tr>
            <?php endif; ?>
            <?php foreach ($values as $v):
                $f = fn($field, $w = '70px', $val = null) =>
                    '<input type="text" name="rows[' . $v->id . '][' . $field . ']" value="' . h($val ?? $v->$field) . '" class="form-control form-control-sm" style="min-width:' . $w . ';">';
            ?>
                <tr>
                    <td class="text-center"><input type="checkbox" name="check_ids[]" value="<?= $v->id ?>" class="chk-row"></td>
                    <td><?= $f('machine_code') ?></td>
                    <td><?= $f('parameter_name', '160px') ?></td>
                    <td><?= $f('unit') ?></td>
                    <td><?= $f('general_min', '60px', $num($v->general_min)) ?></td>
                    <td><?= $f('general_max', '60px', $num($v->general_max)) ?></td>
                    <td style="background:#fdf4ff;"><?= $f('male_min', '60px', $num($v->male_min)) ?></td>
                    <td style="background:#fdf4ff;"><?= $f('male_max', '60px', $num($v->male_max)) ?></td>
                    <td style="background:#ecfeff;"><?= $f('female_min', '60px', $num($v->female_min)) ?></td>
                    <td style="background:#ecfeff;"><?= $f('female_max', '60px', $num($v->female_max)) ?></td>
                    <td><?= $f('child_min', '60px', $num($v->child_min)) ?></td>
                    <td><?= $f('child_max', '60px', $num($v->child_max)) ?></td>
                    <td><?= $f('text_male', '90px') ?></td>
                    <td><?= $f('text_female', '90px') ?></td>
                    <td><?= $f('decimals', '45px') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>

        <!-- Satu baris: PROSES COPY (kiri) | Tambah, Hapus, Simpan (kanan) -->
        <div class="lnv-foot">
            <div>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-copy">PROSES COPY</button>
            </div>
            <div class="right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                <button type="submit" class="btn btn-default" formaction="<?= $this->Url->build(['action' => 'addValue']) ?>"><i class="fa fa-plus"></i> Tambah</button>
                <button type="submit" class="btn btn-default" formaction="<?= $this->Url->build(['action' => 'deleteChecked']) ?>"
                        onclick="return confirm('Hapus parameter yang dicentang?');"><i class="fa fa-times"></i> Hapus</button>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <!-- Master Lembar -->
        <div class="lnv-title">Master Lembar</div>
        <?= $this->Form->create(null, ['url' => ['action' => 'addTemplate'], 'id' => 'form-lembar']) ?>
        <?= $this->Form->hidden('master_laboratory_id', ['value' => $selectedId]) ?>
        <table class="table table-bordered table-sm mb-0" style="font-size:12px;">
            <thead class="thead-dark">
                <tr><th style="width:30px;"><input type="checkbox" id="chk-all-tpl"></th><th>Nama Tes</th><th>Hasil Tes Normal</th></tr>
            </thead>
            <tbody>
            <?php foreach ($templates as $t): ?>
                <tr>
                    <td class="text-center"><input type="checkbox" name="tpl_ids[]" value="<?= $t->id ?>" class="chk-tpl"></td>
                    <td><?= h($t->test_name) ?></td>
                    <td><?= h($t->normal_result) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td><?= $this->Form->text('test_name', ['class' => 'form-control form-control-sm', 'placeholder' => 'mis. Warna']) ?></td>
                <td><?= $this->Form->text('normal_result', ['class' => 'form-control form-control-sm', 'placeholder' => 'mis. Kuning jernih']) ?></td>
            </tr>
            </tbody>
        </table>

        <!-- Satu baris: Master Result (kiri) | Tambah, Hapus (kanan) -->
        <div class="lnv-foot">
            <div>
                <button type="button" class="btn btn-default" disabled title="Fitur lanjutan">Master Result</button>
            </div>
            <div class="right">
                <button type="submit" class="btn btn-default"><i class="fa fa-plus"></i> Tambah</button>
                <button type="submit" class="btn btn-default" formaction="<?= $this->Url->build(['action' => 'deleteTemplates']) ?>"
                        onclick="return confirm('Hapus data yang dicentang?');"><i class="fa fa-times"></i> Hapus</button>
            </div>
        </div>
        <?= $this->Form->end() ?>

        <!-- Modal Proses Copy -->
        <div class="modal fade" id="modal-copy" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <?= $this->Form->create(null, ['url' => ['action' => 'copyFrom']]) ?>
                    <?= $this->Form->hidden('master_laboratory_id', ['value' => $selectedId]) ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Proses Copy</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>Salin parameter dari pemeriksaan:</label>
                        <select name="source_laboratory_id" class="form-control">
                            <?php foreach ($labs as $l): if ((int)$l['id'] === $selectedId) continue; ?>
                                <option value="<?= $l['id'] ?>"><?= h($l['code'] . ' - ' . $l['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Salin</button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

                <script>
                $('#chk-all').on('change', function(){ $('.chk-row').prop('checked', this.checked); });
                $('#chk-all-tpl').on('change', function(){ $('.chk-tpl').prop('checked', this.checked); });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>