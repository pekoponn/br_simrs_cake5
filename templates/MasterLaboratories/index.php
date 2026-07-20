<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MasterLaboratory[]|\Cake\Collection\CollectionInterface $masterLaboratories
 * @var string|null $q
 * @var string|null $isActive
 */
$q = $q ?? $this->request->getQuery('q', '');
$isActive = $isActive ?? $this->request->getQuery('is_active', '');
?>
<?= $this->Krs->breadcrumb('Master Data', 'Master Laboratories') ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title"><i class="fa fa-flask"></i> Master Laboratories</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="lab-filter-box">
            <?= $this->Form->create(null, ['type' => 'get', 'style' => 'margin:0;']) ?>
            <div class="row" style="display:flex; align-items:flex-end; flex-wrap:wrap;">
                <div class="col-md-5 col-sm-6">
                    <label class="lab-filter-label"><i class="fa fa-search"></i> Cari Kode / Nama / Kategori</label>
                    <input type="text" name="q" class="form-control input-sm" placeholder="Contoh: HB, Hemoglobin, Hematologi..." value="<?= h($q) ?>">
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="lab-filter-label"><i class="fa fa-filter"></i> Status</label>
                    <select name="is_active" class="form-control input-sm">
                        <option value="">Semua Status</option>
                        <option value="1" <?= (string)$isActive === '1' ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= (string)$isActive === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6">
                    <label>&nbsp;</label>
                    <div style="display:flex; gap:4px;">
                        <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-search"></i> Cari</button>
                        <?= $this->Html->link('<i class="fa fa-times"></i> Reset', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-default btn-sm']) ?>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 text-right">
                    <label>&nbsp;</label>
                    <?= $this->Html->link('<i class="fa fa-plus"></i> Tambah Lab', ['action' => 'add'], ['escape' => false, 'class' => 'btn btn-inverse btn-sm btn-block']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
        <div style="margin-bottom:10px; display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap;">
            <h5 class="section-title"><i class="fa fa-flask"></i> DAFTAR MASTER LABORATORIUM</h5>
            <span style="font-size:12px; color:#6c757d;"><?= $this->Paginator->counter('Menampilkan {{current}} dari {{count}} data') ?></span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-master-lab" style="font-size:12px;">
                <thead>
                    <tr class="text-center">
                        <th width="45"><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th width="100"><?= $this->Paginator->sort('code', 'Kode') ?></th>
                        <th><?= $this->Paginator->sort('name', 'Nama Pemeriksaan') ?></th>
                        <th width="140"><?= $this->Paginator->sort('tariff', 'Tarif Rp') ?></th>
                        <th width="90"><?= $this->Paginator->sort('jasa_rs', 'Jasa RS') ?></th>
                        <th width="90"><?= $this->Paginator->sort('jasa_dr', 'Jasa DR') ?></th>
                        <th width="90"><?= $this->Paginator->sort('jasa_perawat', 'Perawat') ?></th>
                        <th width="150"><?= $this->Paginator->sort('category', 'Kategori') ?></th>
                        <th width="100"><?= $this->Paginator->sort('is_active', 'Status') ?></th>
                        <th width="135"><?= $this->Paginator->sort('created', 'Created') ?></th>
                        <th width="135"><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($masterLaboratories) || !count($masterLaboratories)): ?>
                        <tr><td colspan="12" style="text-align:center; padding:38px; color:#9ca3af;"><div style="font-size:34px; margin-bottom:8px;">🧪</div><div style="font-weight:600;">Data master laboratorium tidak ditemukan</div></td></tr>
                    <?php else: ?>
                        <?php foreach ($masterLaboratories as $masterLaboratory): ?>
                            <?php $active = (int)($masterLaboratory->is_active ?? 0) === 1; ?>
                            <tr>
                                <td class="text-center"><?= $this->Number->format($masterLaboratory->id) ?></td>
                                <td class="text-center"><span class="lab-code"><?= h($masterLaboratory->code ?? '-') ?></span></td>
                                <td><strong><?= h($masterLaboratory->name ?? '-') ?></strong></td>
                                <td class="text-right" style="font-weight:800; color:#1e3a5f;">Rp <?= number_format((float)($masterLaboratory->tariff ?? 0), 0, ',', '.') ?></td>
                                <td class="text-right">Rp <?= number_format((float)($masterLaboratory->jasa_rs ?? 0), 0, ',', '.') ?></td>
                                <td class="text-right">Rp <?= number_format((float)($masterLaboratory->jasa_dr ?? 0), 0, ',', '.') ?></td>
                                <td class="text-right">Rp <?= number_format((float)($masterLaboratory->jasa_perawat ?? 0), 0, ',', '.') ?></td>
                                <td class="text-center"><?= !empty($masterLaboratory->category) ? '<span class="category-badge">' . h($masterLaboratory->category) . '</span>' : '<span style="color:#d1d5db;">—</span>' ?></td>
                                <td class="text-center">
                                    <?php if ($active): ?><span class="status-badge status-active"><span class="status-dot"></span> Aktif</span>
                                    <?php else: ?><span class="status-badge status-off"><span class="status-dot"></span> Tidak Aktif</span><?php endif; ?>
                                </td>
                                <td class="text-center" style="font-size:11px;"><?= !empty($masterLaboratory->created) && is_object($masterLaboratory->created) ? $masterLaboratory->created->format('d-m-Y H:i') : h($masterLaboratory->created ?? '-') ?></td>
                                <td class="text-center" style="font-size:11px;"><?= !empty($masterLaboratory->modified) && is_object($masterLaboratory->modified) ? $masterLaboratory->modified->format('d-m-Y H:i') : h($masterLaboratory->modified ?? '-') ?></td>
                                <td class="text-center" style="white-space:nowrap;">
                                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $masterLaboratory->id], ['escape' => false, 'class' => 'btn btn-xs btn-info']) ?>
                                    <?= $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $masterLaboratory->id], ['escape' => false, 'class' => 'btn btn-xs btn-warning']) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-ban"></i>', ['action' => 'delete', $masterLaboratory->id], ['escape' => false, 'class' => 'btn btn-xs btn-danger', 'confirm' => __('Nonaktifkan master lab # {0}?', $masterLaboratory->id)]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-top:10px;">
            <p style="margin:0; font-size:12px; color:#6c757d;"><?= $this->Paginator->counter('Halaman {{page}} dari {{pages}}') ?></p>
            <ul class="pagination pagination-sm" style="margin:0;">
                <?= $this->Paginator->first('<< Pertama') ?>
                <?= $this->Paginator->prev('< Sebelumnya') ?>
                <?= $this->Paginator->numbers(['modulus' => 4]) ?>
                <?= $this->Paginator->next('Berikutnya >') ?>
                <?= $this->Paginator->last('Terakhir >>') ?>
            </ul>
        </div>
    </div>
</div>
<style>
.lab-filter-box{background:#f8f9fa;border:1px solid #dee2e6;border-radius:8px;padding:10px 12px;margin-bottom:14px}.lab-filter-label{font-size:11px;font-weight:600;color:#555}.section-title{font-weight:800;color:#1e3a5f;margin:0;text-transform:uppercase;font-size:13px}.table-master-lab>thead>tr>th{background:#1e3a5f!important;color:#fff!important;border-color:#2d4f7f!important;padding:8px 6px!important;vertical-align:middle!important;font-size:11px;font-weight:600;text-align:center;white-space:nowrap}.table-master-lab td{vertical-align:middle!important;padding:6px 6px!important;white-space:nowrap}.table-master-lab>tbody>tr:hover{background:#f0f9ff!important}.btn-xs{padding:3px 7px;font-size:11px;line-height:1.5;border-radius:4px}.lab-code{background:#e0f2fe;color:#0369a1;border-radius:20px;padding:3px 9px;font-weight:700;font-size:10px;font-family:monospace}.category-badge{background:#e0f2fe;color:#0369a1;border-radius:20px;padding:2px 8px;font-weight:600;font-size:10px}.status-badge{border-radius:20px;padding:3px 9px;font-size:10px;font-weight:700;display:inline-flex;align-items:center;gap:4px}.status-dot{width:7px;height:7px;border-radius:50%;display:inline-block;background:currentColor}.status-active{background:#d4edda;color:#155724}.status-off{background:#f8d7da;color:#721c24}
@media(max-width:768px){.lab-filter-box .row{display:block!important}.lab-filter-box .col-md-2,.lab-filter-box .col-md-3,.lab-filter-box .col-md-5{margin-bottom:7px}}
</style>