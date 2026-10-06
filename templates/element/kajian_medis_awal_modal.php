<?php
/**
 * Element: Modal Kajian Medis Awal — IGD
 * Simpan di: templates/element/kajian_medis_awal_modal.php
 *
 * Cara pakai:
 *   1) Panggil sekali di halaman:
 *        <?= $this->element('kajian_medis_awal_modal') ?>
 *   2) Tombol pemicu (data pasien dikirim lewat atribut data-ctx berisi JSON):
 *        <button type="button" class="btn-open-kajian-awal" data-ctx="<?= h(json_encode($ctx)) ?>">Observasi</button>
 *
 *   Isi $ctx:
 *     id, registration_no, medical_record_no, patient_name, doctor_name,
 *     defaults => [tekanan_darah, nadi, napas, suhu, bb, tb, skala_nyeri,
 *                  keluhan_utama, riwayat_penyakit_sekarang]
 *
 *   Bisa juga dibuka lewat JavaScript: window.KajianMedisAwal.open(ctx)
 *
 * CATATAN: endpoint simpan/muat masih memanggil
 *   /emergency-visit-emr/kajian-awal/{id}  dan  /emergency-visit-emr/simpan-kajian-awal/{id}
 *   (backend belum dibuat, sama seperti di EMR IGD).
 */
$kmaBase = $this->Url->build('/');
$kmaCsrf = $this->request->getAttribute('csrfToken');
?>

<!-- ── MODAL KAJIAN MEDIS AWAL — IGD ── -->
<div class="modal fade" id="modal-kajian-awal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-kajian-dialog" role="document">
        <div class="modal-content hasil-window kajian-window">
            <div class="hasil-title">
                <span><i class="fa fa-file-medical"></i> Kajian Medis Awal — IGD</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form id="form-kajian-awal">
                <input type="hidden" name="_csrfToken" value="<?= h($kmaCsrf) ?>">
                <div class="kajian-header">
                    <div class="row">
                        <div class="col-sm-3"><label>No Registrasi</label><input type="text" class="form-control input-sm" id="kma-registration-no" readonly></div>
                        <div class="col-sm-3"><label>No Rek. Med</label><input type="text" class="form-control input-sm" id="kma-medical-record-no" readonly></div>
                        <div class="col-sm-3"><label>Nama Pasien</label><input type="text" class="form-control input-sm" id="kma-patient-name" readonly></div>
                        <div class="col-sm-3"><label>No Kajian</label><input type="text" class="form-control input-sm" id="kma-assessment-no" value="AUTO" readonly></div>
                    </div>
                    <div class="row" style="margin-top:6px;">
                        <div class="col-sm-3"><label>Tanggal</label><input type="date" class="form-control input-sm" name="assessment_date" id="kma-assessment-date"></div>
                        <div class="col-sm-2"><label>Jam</label><input type="time" class="form-control input-sm" name="assessment_time" id="kma-assessment-time"></div>
                        <div class="col-sm-4"><label>Dokter</label><input type="text" class="form-control input-sm" id="kma-doctor-name" readonly></div>
                        <div class="col-sm-3"><label>Status Simpan</label><input type="text" class="form-control input-sm" id="kma-save-state" value="Belum dimuat" readonly></div>
                    </div>
                </div>

                <ul class="nav nav-tabs kajian-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#kma-tab-data-dasar" data-toggle="tab">Data Dasar</a></li>
                    <li role="presentation"><a href="#kma-tab-subjektif" data-toggle="tab">Subjektif</a></li>
                    <li role="presentation"><a href="#kma-tab-observasi" data-toggle="tab">Observasi</a></li>
                </ul>

                <div class="tab-content kajian-body">
                    <div id="kma-tab-data-dasar" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="kajian-section-title">Rujukan &amp; Triase</div>
                                <div class="kajian-line"><label>Rujukan</label><label><input type="radio" name="data_dasar[rujukan]" value="Datang sendiri"> Datang sendiri</label><label><input type="radio" name="data_dasar[rujukan]" value="Rujukan"> Rujukan</label><label><input type="radio" name="data_dasar[rujukan]" value="Lain-lain"> Lain-lain</label></div>
                                <div class="kajian-line"><label>Triase</label><label><input type="radio" name="data_dasar[triase]" value="Emergency"> Emergency</label><label><input type="radio" name="data_dasar[triase]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[triase]" value="Tidak"> Tidak</label></div>
                                <div class="kajian-line"><label>Level</label><?php foreach (['I','II','III','IV'] as $level): ?><label><input type="radio" name="data_dasar[level]" value="<?= $level ?>"> <?= $level ?></label><?php endforeach; ?></div>
                                <div class="kajian-line kajian-tags-line">
                                    <label>Tags</label>
                                    <?php foreach (['merah' => '#e51f35', 'kuning' => '#f6e23a', 'hijau' => '#16c45b', 'hitam' => '#111111'] as $tag => $color): ?>
                                        <label class="kajian-tag-option">
                                            <input type="radio" name="data_dasar[tags]" value="<?= h($tag) ?>">
                                            <span class="kajian-tag-swatch" style="background:<?= h($color) ?>;"></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                                <div class="kajian-line"><label>Kasus</label><?php foreach (['Trauma','DOA','KLL','KLL tunggal','Self abuse','Kecelakaan lain'] as $case): ?><label><input type="checkbox" name="data_dasar[kasus][]" value="<?= h($case) ?>"> <?= h($case) ?></label><?php endforeach; ?></div>
                                <div class="kajian-line"><label>Pembayaran</label><?php foreach (['Pribadi','BPJS','COB','Lain-lain'] as $pay): ?><label><input type="radio" name="data_dasar[pembayaran]" value="<?= h($pay) ?>"> <?= h($pay) ?></label><?php endforeach; ?></div>
                                <div class="kajian-section-title">Survei Primer</div>
                                <div class="kajian-grid-2">
                                    <div><label>C: Nadi carotis</label><label><input type="radio" name="data_dasar[nadi_carotis]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[nadi_carotis]" value="Tidak"> Tidak</label></div>
                                    <div><label>A: Airway</label><?php foreach (['Bicara/Menangis','Suara tambahan','Diam'] as $v): ?><label><input type="radio" name="data_dasar[airway]" value="<?= h($v) ?>"> <?= h($v) ?></label><?php endforeach; ?></div>
                                    <div><label>B: Breathing</label><?php foreach (['Spontan','Takipneu','Dyspneu','Retraksi intercostal','Retraksi epigastrial','Lambat/tidak adekuat','Retraksi suprasternal'] as $v): ?><label><input type="checkbox" name="data_dasar[breathing][]" value="<?= h($v) ?>"> <?= h($v) ?></label><?php endforeach; ?></div>
                                    <div><label>D: Keadaan Umum</label><?php foreach (['Composmentis','Apatis','Somnolen','Soporus','Comatous'] as $v): ?><label><input type="radio" name="data_dasar[keadaan_umum]" value="<?= h($v) ?>"> <?= h($v) ?></label><?php endforeach; ?></div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="kajian-section-title">Non Trauma</div>
                                <div class="kajian-check-columns"><?php foreach (['Bedah Syaraf','Bedah Umum','Bedah Orthopedi','Bedah Urologi','Bedah Digestif','Peny. Dalam','Kesehatan Anak','Obgyn','Kulit & Kelamin','THT','Saraf','Mata','Jiwa'] as $nt): ?><label><input type="checkbox" name="data_dasar[non_trauma][]" value="<?= h($nt) ?>"> <?= h($nt) ?></label><?php endforeach; ?></div>
                                <div class="kajian-section-title">Polisi &amp; VER</div>
                                <div class="kajian-line"><label>Kasus Polisi</label><label><input type="radio" name="data_dasar[kasus_polisi]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[kasus_polisi]" value="Tidak"> Tidak</label></div>
                                <div class="kajian-line"><label>VER</label><label><input type="radio" name="data_dasar[ver]" value="Ya"> Ya</label><label><input type="radio" name="data_dasar[ver]" value="Tidak"> Tidak</label><label><input type="checkbox" name="data_dasar[ver_belum_diminta]" value="1"> Belum ada permintaan</label></div>
                                <div class="kajian-section-title">Vital Sign</div>
                                <div class="kajian-vitals">
                                    <label>TD <input type="text" name="data_dasar[tekanan_darah]" class="form-control input-sm"></label>
                                    <label>Nadi <input type="number" name="data_dasar[nadi]" class="form-control input-sm"></label>
                                    <label>Napas <input type="number" name="data_dasar[napas]" class="form-control input-sm"></label>
                                    <label>Suhu <input type="text" name="data_dasar[suhu]" class="form-control input-sm"></label>
                                    <label>BB <input type="text" name="data_dasar[bb]" class="form-control input-sm"></label>
                                    <label>TB <input type="text" name="data_dasar[tb]" class="form-control input-sm"></label>
                                    <label>LLA <input type="text" name="data_dasar[lla]" class="form-control input-sm"></label>
                                    <label>Skala Nyeri <input type="text" name="data_dasar[skala_nyeri]" class="form-control input-sm"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="kma-tab-subjektif" class="tab-pane">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kajian-section-title">Data Subjektif</div>
                                <label>Keluhan Utama</label><textarea name="subjektif[keluhan_utama]" class="form-control kajian-textarea"></textarea>
                                <label>Riwayat Penyakit Sekarang</label><textarea name="subjektif[riwayat_penyakit_sekarang]" class="form-control kajian-textarea"></textarea>
                                <label>Riwayat Penyakit Dahulu / Operasi</label><textarea name="subjektif[riwayat_penyakit_dahulu]" class="form-control kajian-textarea"></textarea>
                                <label>Riwayat Penyakit Dalam Keluarga</label><textarea name="subjektif[riwayat_keluarga]" class="form-control kajian-textarea"></textarea>
                                <label>Obat Yang Diminum</label><textarea name="subjektif[obat_diminum]" class="form-control kajian-textarea"></textarea>
                                <label>Kebiasaan Hidup</label>
                                <div class="kajian-line"><label><input type="checkbox" name="subjektif[kebiasaan][]" value="Merokok"> Merokok</label><label><input type="checkbox" name="subjektif[kebiasaan][]" value="Minuman beralkohol"> Minuman beralkohol</label><label><input type="checkbox" name="subjektif[kebiasaan][]" value="Kontak dengan bahan berbahaya"> Kontak bahan berbahaya</label></div>
                                <input type="text" name="subjektif[kebiasaan_lain]" class="form-control input-sm" placeholder="Lain-lain...">
                            </div>
                            <div class="col-md-6">
                                <div class="kajian-section-title">Data Objektif</div>
                                <div class="row"><div class="col-xs-4"><label>GCS E</label><input type="number" name="subjektif[gcs_e]" class="form-control input-sm"></div><div class="col-xs-4"><label>M</label><input type="number" name="subjektif[gcs_m]" class="form-control input-sm"></div><div class="col-xs-4"><label>V</label><input type="number" name="subjektif[gcs_v]" class="form-control input-sm"></div></div>
                                <?php foreach (['kepala' => 'Kepala','leher' => 'Leher','thorax' => 'Thorax','abdomen' => 'Abdomen','genital' => 'Genital','ekstremitas' => 'Ekstremitas'] as $key => $label): ?>
                                    <label><?= h($label) ?></label><input type="text" name="subjektif[pemeriksaan_fisik][<?= h($key) ?>]" class="form-control input-sm">
                                <?php endforeach; ?>
                                <div class="kajian-section-title">Pemeriksaan Penunjang</div>
                                <div class="kajian-line"><?php foreach (['GDS','EKG','USG','X-FOTO','C SCAN','MRI','LABORAT','Lain-lain'] as $support): ?><label><input type="checkbox" name="subjektif[pemeriksaan_penunjang][]" value="<?= h($support) ?>"> <?= h($support) ?></label><?php endforeach; ?></div>
                            </div>
                        </div>
                    </div>
                    <div id="kma-tab-observasi" class="tab-pane">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="kajian-section-title">Observasi</div>
                                <label>Waktu</label><input type="time" name="observasi[waktu]" class="form-control input-sm">
                                <label>Keluhan / Keadaan</label><textarea name="observasi[keluhan_keadaan]" class="form-control kajian-observasi-text"></textarea>
                                <label>Tanda Vital</label><textarea name="observasi[tanda_vital]" class="form-control kajian-observasi-text"></textarea>
                                <label>Penatalaksanaan</label><textarea name="observasi[penatalaksanaan]" class="form-control kajian-observasi-text"></textarea>
                                <div class="kajian-section-title">Alat Yang Terpasang</div>
                                <?php foreach (['iv_line' => 'IV Line','kateter' => 'Kateter (DC)','cvc' => 'CVC','ngt' => 'NGT','ett' => 'ETT','lain' => 'Lain-lain'] as $key => $label): ?>
                                    <div class="row kajian-device-row"><div class="col-xs-3"><label><input type="checkbox" name="observasi[alat][<?= h($key) ?>][checked]" value="1"> <?= h($label) ?></label></div><div class="col-xs-4"><input type="text" name="observasi[alat][<?= h($key) ?>][lokasi]" class="form-control input-sm" placeholder="Lokasi / ukuran"></div><div class="col-xs-5"><input type="text" name="observasi[alat][<?= h($key) ?>][keterangan]" class="form-control input-sm" placeholder="Keterangan"></div></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="kajian-section-title">Hasil Akhir</div>
                                <div class="kajian-line vertical"><label><input type="checkbox" name="observasi[hasil_akhir][]" value="Dipulangkan"> Dipulangkan</label><label><input type="checkbox" name="observasi[hasil_akhir][]" value="Dirawat"> Dirawat, ruangan</label><input type="text" name="observasi[ruangan]" class="form-control input-sm" placeholder="Nama ruangan..."><label><input type="checkbox" name="observasi[hasil_akhir][]" value="Dirujuk untuk tindakan"> Dirujuk untuk tindakan</label></div>
                                <div class="kajian-line vertical" style="margin-left:18px;"><?php foreach (['Kamar Bedah','Hemodialisa','Poli Bedah','Angiografi / Endoskopi','Kemoterapi','THC'] as $target): ?><label><input type="radio" name="observasi[target_tindakan]" value="<?= h($target) ?>"> <?= h($target) ?></label><?php endforeach; ?><input type="text" name="observasi[target_tindakan_lain]" class="form-control input-sm" placeholder="Lain-lain..."></div>
                                <div class="kajian-line vertical"><label><input type="checkbox" name="observasi[dirujuk_rs]" value="1"> Dirujuk ke Rumah Sakit</label><input type="text" name="observasi[rumah_sakit_tujuan]" class="form-control input-sm" placeholder="Rumah sakit tujuan..."><input type="text" name="observasi[alasan_rujuk]" class="form-control input-sm" placeholder="Alasan rujuk..."><label><input type="checkbox" name="observasi[meninggal]" value="1"> Meninggal, pukul</label><input type="time" name="observasi[jam_meninggal]" class="form-control input-sm"><input type="text" name="observasi[penyebab_meninggal]" class="form-control input-sm" placeholder="Penyebab..."></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kajian-footer">
                    <span id="kma-message"></span>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-save-kajian-awal"><i class="fa fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.hasil-window { border: 1px solid #5b78a5; background: #dfe8f7; box-shadow: 0 3px 12px rgba(0,0,0,.25); border-radius: 2px; }
.hasil-title { background: #7b1c1c; color: #fff; padding: 5px 8px; font-size: 12px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; }
.hasil-close { border: 0; background: transparent; color: #fff; font-size: 18px; line-height: 18px; padding: 0 4px; opacity: 1; }

.modal-kajian-dialog { width: 1080px; max-width: 97%; margin-top: 28px; }
.kajian-window { background: #dfe8f7; }
.kajian-header { padding: 8px 10px; border-bottom: 1px solid #9eb2d1; font-size: 11px; }
.kajian-header label, .kajian-body label { font-size: 11px; font-weight: 600; margin-bottom: 2px; }
.kajian-tabs { display: flex; padding: 0; border-bottom: 1px solid #9eb2d1; background: #d7e2f2; }
.kajian-tabs > li { flex: 1 1 0; text-align: center; margin-bottom: 0; }
.kajian-tabs > li > a { display: block; margin-right: 0; border-radius: 0; border: 1px solid #9eb2d1; border-left: 0; border-bottom: 0; font-size: 12px; padding: 7px 14px; font-weight: 700; color: #7b1c1c; background: #ecd9d9; text-decoration: none; }
.kajian-tabs > li:first-child > a { border-left: 1px solid #9eb2d1; }
.kajian-tabs > li.active > a, .kajian-tabs > li.active > a:focus, .kajian-tabs > li.active > a:hover,
.kajian-tabs > li > a.active { background: #fff !important; color: #7b1c1c !important; border-top: 3px solid #7b1c1c !important; border-bottom: 1px solid #fff !important; font-weight: 800; }
.kajian-tabs > li:not(.active) > a:hover { background: #f6e7e7; }
.kajian-body { padding: 10px; min-height: 455px; max-height: 62vh; overflow-y: auto; font-size: 11px; }
.kajian-section-title { background: #f0dada; border: 1px solid #d9b3b3; color: #7b1c1c; font-weight: 700; font-size: 11px; padding: 4px 7px; margin: 6px 0; }
.kajian-line { display: flex; flex-wrap: wrap; gap: 8px 12px; align-items: center; margin-bottom: 6px; }
.kajian-line > label:first-child { min-width: 82px; color: #1f2937; }
.kajian-line.vertical { display: block; }
.kajian-line.vertical label { display: block; margin-bottom: 5px; }
.kajian-tags-line { gap: 10px; }
.kajian-tag-option { display: inline-flex; align-items: center; gap: 4px; margin-right: 6px; }
.kajian-tag-swatch { display: inline-block; width: 18px; height: 18px; border: 1px solid #7f8da3; vertical-align: middle; }
.kajian-grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px 14px; }
.kajian-grid-2 label, .kajian-check-columns label { display: block; font-weight: 500; }
.kajian-check-columns { columns: 2; }
.kajian-vitals { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 6px; }
.kajian-vitals label { display: grid; grid-template-columns: 72px 1fr; gap: 5px; align-items: center; }
.kajian-textarea { height: 46px !important; resize: vertical; margin-bottom: 5px; font-size: 11px; }
.kajian-observasi-text { height: 66px !important; resize: vertical; margin-bottom: 6px; font-size: 11px; }
.kajian-device-row { margin-bottom: 5px; }
.kajian-footer { display: flex; justify-content: space-between; align-items: center; gap: 8px; padding: 8px 10px; border-top: 1px solid #9eb2d1; }
#kma-message { font-size: 12px; font-weight: 600; }
</style>

<script>
window.addEventListener('load', function () {
window.KajianMedisAwal = (function ($) {
    var BASE = <?= json_encode($kmaBase) ?>;
    var currentId = null;

    function pad(n) { return n < 10 ? '0' + n : String(n); }
    function todayStr() {
        var d = new Date();
        return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
    }
    function nowStr() {
        var d = new Date();
        return pad(d.getHours()) + ':' + pad(d.getMinutes());
    }

    function urlGet(id)  { return BASE + 'emergency-visit-emr/kajian-awal/' + id; }
    function urlSave(id) { return BASE + 'emergency-visit-emr/simpan-kajian-awal/' + id; }

    function findByName(name) {
        return $('#form-kajian-awal').find('[name]').filter(function () { return this.name === name; });
    }

    function setField(name, value) {
        var $fields = findByName(name);
        if (!$fields.length && $.isArray(value)) $fields = findByName(name + '[]');
        if (!$fields.length) return;
        var type = ($fields.first().attr('type') || '').toLowerCase();
        if (type === 'radio') {
            $fields.prop('checked', false).filter(function () { return String($(this).val()) === String(value); }).prop('checked', true);
            return;
        }
        if (type === 'checkbox') {
            $fields.prop('checked', false);
            if ($.isArray(value)) {
                $fields.each(function () { $(this).prop('checked', value.map(String).indexOf(String($(this).val())) !== -1); });
            } else {
                $fields.each(function () { $(this).prop('checked', String($(this).val()) === String(value) || String(value) === '1' || value === true); });
            }
            return;
        }
        $fields.val(value == null ? '' : value);
    }

    function fillSection(prefix, data) {
        if (!data) return;
        $.each(data, function (key, value) {
            var name = prefix + '[' + key + ']';
            if ($.isPlainObject(value)) fillSection(name, value); else setField(name, value);
        });
    }

    function activateTab(selector) {
        var $tab = $('#modal-kajian-awal .kajian-tabs a[href="' + selector + '"]');
        $('#modal-kajian-awal .kajian-tabs li').removeClass('active');
        $('#modal-kajian-awal .kajian-tabs a').removeClass('active');
        $('#modal-kajian-awal .tab-pane').removeClass('active in');
        $tab.addClass('active').closest('li').addClass('active');
        $(selector).addClass('active in');
    }

    function resetForm(ctx) {
        var form = document.getElementById('form-kajian-awal');
        if (form) form.reset();

        var def = ctx.defaults || {};
        $('#kma-registration-no').val(ctx.registration_no || '-');
        $('#kma-medical-record-no').val(ctx.medical_record_no || '-');
        $('#kma-patient-name').val(ctx.patient_name || '-');
        $('#kma-doctor-name').val(ctx.doctor_name || '-');
        $('#kma-assessment-no').val('AUTO');
        $('#kma-assessment-date').val(todayStr());
        $('#kma-assessment-time').val(nowStr());

        setField('data_dasar[tekanan_darah]', def.tekanan_darah || '');
        setField('data_dasar[nadi]', def.nadi || '');
        setField('data_dasar[napas]', def.napas || '');
        setField('data_dasar[suhu]', def.suhu || '');
        setField('data_dasar[bb]', def.bb || '');
        setField('data_dasar[tb]', def.tb || '');
        setField('data_dasar[skala_nyeri]', def.skala_nyeri || '');
        setField('subjektif[keluhan_utama]', def.keluhan_utama || '');
        setField('subjektif[riwayat_penyakit_sekarang]', def.riwayat_penyakit_sekarang || '');

        $('#kma-message').text('').css('color', '');
        $('#kma-save-state').val('Memuat...');
        activateTab('#kma-tab-data-dasar');
    }

    function open(ctx) {
        ctx = ctx || {};
        if (!ctx.id) {
            alert('Data registrasi tidak ditemukan.');
            return;
        }
        currentId = ctx.id;
        resetForm(ctx);
        $('#modal-kajian-awal').modal('show');

        var requestedId = ctx.id;
        $.getJSON(urlGet(requestedId))
            .done(function (res) {
                if (currentId !== requestedId) return;
                if (!res || !res.success) {
                    $('#kma-save-state').val('Belum ada data');
                    return;
                }
                var data = res.data || {};
                $('#kma-assessment-no').val(data.assessment_no || 'AUTO');
                if (data.assessment_date) $('#kma-assessment-date').val(data.assessment_date);
                if (data.assessment_time) $('#kma-assessment-time').val(String(data.assessment_time).substring(0, 5));
                fillSection('data_dasar', data.data_dasar || {});
                fillSection('subjektif', data.subjektif || {});
                fillSection('observasi', data.observasi || {});
                $('#kma-save-state').val(data.id ? 'Sudah tersimpan' : 'Baru');
            })
            .fail(function (xhr) {
                if (currentId !== requestedId) return;
                $('#kma-save-state').val('Backend belum tersedia (' + xhr.status + ')');
            });
    }

    // Tombol pemicu di halaman mana pun
    $(document).on('click', '.btn-open-kajian-awal', function (e) {
        e.preventDefault();
        var id = $(this).data('id') || $(this).data('ctx');
        var map = window.KMA_CTX_MAP || {};
        var ctx = map[id] || (typeof $(this).data('ctx') === 'object' ? $(this).data('ctx') : null);

        if (!ctx) {
            console.error('Konteks kajian awal tidak ditemukan untuk id:', id, 'Isi KMA_CTX_MAP:', map);
            alert('Data pasien untuk kajian medis awal tidak ditemukan (id: ' + id + '). Cek console untuk detail.');
            return;
        }

        open(ctx);
    });

    // Pindah tab di dalam modal
    $(document).on('click', '#modal-kajian-awal .kajian-tabs a[data-toggle="tab"]', function (e) {
        e.preventDefault();
        activateTab($(this).attr('href'));
    });

    // Simpan
    $(document).on('click', '#btn-save-kajian-awal', function () {
        var $btn = $(this);
        if (!currentId) return;
        var csrf = $('#form-kajian-awal input[name="_csrfToken"]').val();
        $('#kma-message').text('Menyimpan...').css('color', '#7b1c1c');
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan');
        $.ajax({
            url: urlSave(currentId), method: 'POST',
            data: $('#form-kajian-awal').serialize(), dataType: 'json',
            headers: csrf ? { 'X-CSRF-Token': csrf } : {}
        }).done(function (res) {
            if (res && res.success) {
                $('#kma-assessment-no').val(res.assessment_no || $('#kma-assessment-no').val());
                $('#kma-save-state').val('Sudah tersimpan');
                $('#kma-message').text(res.message || 'Kajian medis awal berhasil disimpan.').css('color', '#047857');
            } else {
                $('#kma-message').text((res && res.message) || 'Gagal menyimpan kajian medis awal.').css('color', '#b91c1c');
            }
        }).fail(function (xhr) {
            $('#kma-message').text('Gagal menyimpan (' + xhr.status + ').').css('color', '#b91c1c');
        }).always(function () {
            $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
        });
    });

    return { open: open };
})(jQuery);
});
</script>