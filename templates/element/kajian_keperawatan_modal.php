<?php
/**
 * Element: Modal Kajian Keperawatan — IGD
 * Simpan di: templates/element/kajian_keperawatan_modal.php
 *
 * @var iterable $triageNurses
 */
$kkCsrf = $this->request->getAttribute('csrfToken');
$kkBase = $this->Url->build('/');
$triageNurses = $triageNurses ?? [];
?>

<div class="modal fade" id="modal-kajian-keperawatan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1150px; max-width:98%; margin-top:14px;" role="document">
        <div class="modal-content triase-window">
            <div class="triase-title">
                <span><i class="fa fa-user-nurse"></i> Pengkajian Keperawatan</span>
                <button type="button" class="triase-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <form id="form-kajian-keperawatan">
                <input type="hidden" name="_csrfToken" value="<?= h($kkCsrf) ?>">
                <input type="hidden" id="kk-registration-id" name="registration_id" value="">

                <div class="triase-body kk-body">

                    <!-- Identitas -->
                    <div class="row kk-row-tight">
                        <div class="col-sm-3"><label>No. Registrasi</label><input type="text" id="kk-noreg" class="form-control input-sm" readonly></div>
                        <div class="col-sm-2"><label>No. RM</label><input type="text" id="kk-norm" class="form-control input-sm" readonly></div>
                        <div class="col-sm-3"><label>Nama Pasien</label><input type="text" id="kk-nama" class="form-control input-sm" readonly></div>
                        <div class="col-sm-2"><label>Umur / JK</label><input type="text" id="kk-umur-jk" class="form-control input-sm" readonly></div>
                        <div class="col-sm-2"><label>Tanggal</label><input type="text" id="kk-tanggal" class="form-control input-sm" readonly></div>
                    </div>

                    <!-- Cara & Asal Masuk (wajib diisi lebih dulu) -->
                    <div class="kk-section-title">1. Cara &amp; Asal Masuk <span class="kk-required">*</span></div>
                    <div class="row kk-row-tight kk-row-compact">
                        <div class="col-sm-6">
                            <label>Cara Masuk</label>
                            <div class="kk-btn-group">
                                <label class="kk-opt-btn"><input type="radio" name="admission_mode" value="jalan_tanpa_bantuan"> Jalan tanpa bantuan</label>
                                <label class="kk-opt-btn"><input type="radio" name="admission_mode" value="jalan_dengan_bantuan"> Jalan dengan bantuan</label>
                                <label class="kk-opt-btn"><input type="radio" name="admission_mode" value="kursi_roda"> Kursi Roda</label>
                                <label class="kk-opt-btn"><input type="radio" name="admission_mode" value="tempat_tidur_dorong"> Tempat tidur dorong</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>Asal Masuk</label>
                            <div class="kk-btn-group">
                                <label class="kk-opt-btn active"><input type="radio" name="admission_origin" value="non_rujukan" checked> Non Rujukan</label>
                                <label class="kk-opt-btn"><input type="radio" name="admission_origin" value="rujukan"> Rujukan</label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>Nama Perawat Pelaksana Pengkajian <span class="kk-required">*</span></label>
                            <select name="nurse_id" id="kk-perawat" class="form-control input-sm select2-kk">
                                <option value="">-- Pilih Perawat --</option>
                                <?php foreach ($triageNurses as $nurse): ?>
                                    <option value="<?= h($nurse->id) ?>"><?= h($nurse->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Informasi Dari -->
                    <div class="kk-section-title">2. Informasi Dari</div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-4">
                            <label>Sumber Informasi</label><br>
                            <div class="kk-btn-group">
                                <label class="kk-opt-btn active"><input type="radio" name="info_type" value="auto_anamnesa" checked> Auto Anamnesa</label>
                                <label class="kk-opt-btn"><input type="radio" name="info_type" value="hetero_anamnesa"> Hetero Anamnesa</label>
                            </div>
                        </div>
                        <div class="col-sm-4"><label>Nama (bila Hetero)</label><input type="text" name="info_name" class="form-control input-sm"></div>
                        <div class="col-sm-4"><label>Hubungan</label><input type="text" name="info_relation" class="form-control input-sm"></div>
                    </div>

                    <!-- Kondisi Awal -->
                    <div class="kk-section-title">3. Kondisi Awal</div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-8"><label>Riwayat Penyakit Sekarang</label><textarea name="current_illness_history" class="form-control kk-ta-sm"></textarea></div>
                        <div class="col-sm-2"><label>Berat Badan (Kg)</label><input type="number" step="0.1" name="weight" class="form-control input-sm"></div>
                        <div class="col-sm-2"><label>Tinggi Badan (Cm)</label><input type="number" step="0.1" name="height" class="form-control input-sm"></div>
                    </div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-6"><label>Riwayat Penyakit Dahulu</label><textarea name="past_illness_history" class="form-control kk-ta-sm"></textarea></div>
                        <div class="col-sm-6"><label>Riwayat Pengobatan Sebelumnya</label><textarea name="previous_treatment_history" class="form-control kk-ta-sm"></textarea></div>
                    </div>

                    <!-- Pengkajian Nyeri -->
                    <div class="kk-section-title">4. Pengkajian Nyeri</div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-2"><label>Skala Nyeri (0-10)</label><input type="number" name="pain_scale" class="form-control input-sm" min="0" max="10" value="0"></div>
                        <div class="col-sm-4">
                            <label>Frekuensi</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn"><input type="radio" name="pain_frequency" value="jarang"> Jarang</label>
                                <label class="kk-opt-btn"><input type="radio" name="pain_frequency" value="hilang_timbul"> Hilang timbul</label>
                                <label class="kk-opt-btn"><input type="radio" name="pain_frequency" value="terus_menerus"> Terus-menerus</label>
                            </div>
                        </div>
                        <div class="col-sm-3"><label>Lama Nyeri</label><input type="text" name="pain_duration" class="form-control input-sm"></div>
                        <div class="col-sm-3">
                            <label>Menjalar</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn active"><input type="radio" name="pain_radiating" value="tidak" checked> Tidak</label>
                                <label class="kk-opt-btn"><input type="radio" name="pain_radiating" value="ya"> Ya</label>
                            </div>
                            <input type="text" name="pain_radiating_to" class="form-control input-sm" placeholder="Menjalar ke..." style="margin-top:4px;">
                        </div>
                    </div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-4">
                            <label>Kualitas Nyeri</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn"><input type="radio" name="pain_quality" value="nyeri_tumpul"> Tumpul</label>
                                <label class="kk-opt-btn"><input type="radio" name="pain_quality" value="nyeri_tajam"> Tajam</label>
                                <label class="kk-opt-btn"><input type="radio" name="pain_quality" value="panas_terbakar"> Panas/Terbakar</label>
                            </div>
                        </div>
                        <div class="col-sm-4"><label>Faktor Pemicu</label><input type="text" name="pain_trigger_factor" class="form-control input-sm"></div>
                        <div class="col-sm-4"><label>Faktor yang Mengurangi</label><input type="text" name="pain_relieving_factor" class="form-control input-sm"></div>
                    </div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-4">
                            <label>Aktifitas Sehari-hari</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn active"><input type="radio" name="daily_activity" value="mandiri" checked> Mandiri</label>
                                <label class="kk-opt-btn"><input type="radio" name="daily_activity" value="dengan_bantuan"> Dengan bantuan</label>
                            </div>
                        </div>
                    </div>

                    <!-- Resiko Jatuh -->
                    <div class="kk-section-title">5. Pengkajian Resiko Pasien Jatuh</div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-4">
                            <label>Pernah Jatuh 3 bln terakhir</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn"><input type="radio" name="fall_risk_recent" value="ya"> Ya</label>
                                <label class="kk-opt-btn active"><input type="radio" name="fall_risk_recent" value="tidak" checked> Tidak</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Menggunakan Alat Bantu</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn"><input type="radio" name="fall_risk_device" value="ya"> Ya</label>
                                <label class="kk-opt-btn active"><input type="radio" name="fall_risk_device" value="tidak" checked> Tidak</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>Kesulitan Berjalan</label>
                            <div class="kk-btn-group kk-btn-group-sm">
                                <label class="kk-opt-btn"><input type="radio" name="fall_risk_walk_difficulty" value="ya"> Ya</label>
                                <label class="kk-opt-btn active"><input type="radio" name="fall_risk_walk_difficulty" value="tidak" checked> Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-12">
                            <label>Intervensi Pasien Resiko</label>
                            <div class="kk-check-inline">
                                <label><input type="checkbox" name="fall_intervention[]" value="pasang_pagar"> Pasang pagar &amp; kunci roda tempat tidur</label>
                                <label><input type="checkbox" name="fall_intervention[]" value="edukasi_jatuh"> Edukasi Pencegahan Resiko Jatuh</label>
                                <label><input type="checkbox" name="fall_intervention[]" value="sign_clip"> Pasang sign clip fall pada gelang identitas</label>
                            </div>
                        </div>
                    </div>

                    <!-- Resiko Dekubitus -->
                    <div class="kk-section-title">6. Pengkajian Resiko Dekubitus</div>
                    <div class="row kk-row-tight">
                        <div class="col-sm-7">
                            <table class="kk-dekubitus-table">
                                <tr>
                                    <td>Menggunakan kursi roda / butuh bantuan?</td>
                                    <td>
                                        <div class="kk-btn-group kk-btn-group-sm">
                                            <label class="kk-opt-btn"><input type="radio" name="decubitus_wheelchair" value="ya"> Ya</label>
                                            <label class="kk-opt-btn active"><input type="radio" name="decubitus_wheelchair" value="tidak" checked> Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ada inkontinensia uri / alvi?</td>
                                    <td>
                                        <div class="kk-btn-group kk-btn-group-sm">
                                            <label class="kk-opt-btn"><input type="radio" name="decubitus_incontinence" value="ya"> Ya</label>
                                            <label class="kk-opt-btn active"><input type="radio" name="decubitus_incontinence" value="tidak" checked> Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ada riwayat / luka dekubitus?</td>
                                    <td>
                                        <div class="kk-btn-group kk-btn-group-sm">
                                            <label class="kk-opt-btn"><input type="radio" name="decubitus_history" value="ya"> Ya</label>
                                            <label class="kk-opt-btn active"><input type="radio" name="decubitus_history" value="tidak" checked> Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pasien diatas 65 tahun?</td>
                                    <td>
                                        <div class="kk-btn-group kk-btn-group-sm">
                                            <label class="kk-opt-btn"><input type="radio" name="decubitus_over_65" value="ya"> Ya</label>
                                            <label class="kk-opt-btn active"><input type="radio" name="decubitus_over_65" value="tidak" checked> Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ekstremitas/badan tak sesuai usia?</td>
                                    <td>
                                        <div class="kk-btn-group kk-btn-group-sm">
                                            <label class="kk-opt-btn"><input type="radio" name="decubitus_extremity_mismatch" value="ya"> Ya</label>
                                            <label class="kk-opt-btn active"><input type="radio" name="decubitus_extremity_mismatch" value="tidak" checked> Tidak</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-5">
                            <label>Bila salah satu "Ya", Edukasi Pencegahan Dekubitus:</label>
                            <textarea name="decubitus_education" class="form-control" style="height:120px;"></textarea>
                        </div>
                    </div>

                </div>

                <div class="triase-footer">
                    <span id="kk-message" style="font-size:12px; font-weight:600;"></span>
                    <div>
                        <button type="button" class="btn btn-success btn-sm" id="btn-simpan-kk"><i class="fa fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-warning btn-sm" id="btn-edit-kk"><i class="fa fa-edit"></i> Edit</button>
                        <button type="button" class="btn btn-info btn-sm" id="btn-cetak-kk" disabled><i class="fa fa-print"></i> Cetak</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-sign-out-alt"></i> Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.kk-body { padding: 12px 14px !important; max-height: 74vh !important; }
.kk-row-tight { margin-bottom: 6px; }
.kk-row-tight label { font-size: 11px; font-weight: 600; color: #333; margin-bottom: 3px; display: block; }
.kk-row-compact { margin-left: -6px; margin-right: -6px; }
.kk-row-compact > [class*="col-"] { padding-left: 6px; padding-right: 6px; }
.kk-section-title {
    background: #dbe6f4; border: 1px solid #b9cbe0; color: #1e3a5f; font-weight: 700;
    font-size: 11px; padding: 5px 8px; margin: 10px 0 6px;
}
.kk-required { color: #dc3545; }

.kk-ta-sm { height: 42px !important; resize: vertical; font-size: 12px; }

.kk-btn-group { display: flex; flex-wrap: wrap; gap: 5px; }
.kk-btn-group-sm .kk-opt-btn { padding: 4px 8px; font-size: 10px; }
.kk-opt-btn {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px; border-radius: 5px; border: 1.5px solid #ccd5e0;
    cursor: pointer; font-weight: 600; font-size: 11px; background: #fff; color: #444;
    transition: background .15s ease, border-color .15s ease, color .15s ease;
    -webkit-user-select: none; user-select: none;
}
.kk-opt-btn input { display: none; }
.kk-opt-btn:hover { border-color: #1e3a5f; }
.kk-opt-btn.active { background: #1e3a5f; border-color: #1e3a5f; color: #fff; }

.kk-check-inline { display: flex; flex-wrap: wrap; gap: 4px 18px; margin-top: 2px; }
.kk-check-inline label { font-weight: 400; font-size: 11.5px; margin-bottom: 0; }

.kk-dekubitus-table { width: 100%; border-collapse: collapse; font-size: 11px; }
.kk-dekubitus-table td { padding: 5px 4px; border-bottom: 1px solid #e5e9ef; vertical-align: middle; }
.kk-dekubitus-table td:first-child { width: 62%; color: #333; }
</style>

<script>
$(document).on('click', '.btn-buka-kajian-keperawatan', function () {
    var $btn = $(this);

    $('#form-kajian-keperawatan')[0].reset();
    $('#kk-registration-id').val($btn.attr('data-id'));
    $('#kk-noreg').val($btn.attr('data-noreg') || '-');
    $('#kk-norm').val($btn.attr('data-norm') || '-');
    $('#kk-nama').val($btn.attr('data-nama') || '-');
    $('#kk-umur-jk').val((($btn.attr('data-umur') || '-') + ' Th / ' + ($btn.attr('data-gender') || '-')));
    $('#kk-tanggal').val(new Date().toLocaleDateString('id-ID'));
    $('#kk-message').text('');
    $('#btn-cetak-kk').prop('disabled', true);

    $('.kk-opt-btn').removeClass('active');
    $('.kk-opt-btn input:checked').closest('.kk-opt-btn').addClass('active');

    try {
        if (typeof $.fn.select2 === 'function' && !$('#kk-perawat').hasClass('select2-hidden-accessible')) {
            $('.select2-kk').select2({
                dropdownParent: $('#modal-kajian-keperawatan'),
                width: '100%'
            });
        }
    } catch (e) {}
    $('.select2-kk').val('').trigger('change');

    $('#modal-kajian-keperawatan').modal('show');
});

$(document).on('click', '.kk-opt-btn', function () {
    var $btn = $(this);
    var $group = $btn.closest('.kk-btn-group');
    $group.find('.kk-opt-btn').removeClass('active');
    $btn.find('input[type="radio"]').prop('checked', true);
    $btn.addClass('active');
});

$(document).on('click', '#btn-simpan-kk', function () {
    var $btn = $(this);
    var regId = $('#kk-registration-id').val();

    if (!regId) {
        $('#kk-message').text('Data registrasi tidak ditemukan.').css('color', '#b91c1c');
        return;
    }

    var nurseId = $('#kk-perawat').val();
    if (!nurseId) {
        $('#kk-message').text('Pilih perawat pelaksana pengkajian terlebih dahulu.').css('color', '#b91c1c');
        return;
    }

    var admissionMode = $('input[name="admission_mode"]:checked').val();
    if (!admissionMode) {
        $('#kk-message').text('Pilih Cara Masuk terlebih dahulu.').css('color', '#b91c1c');
        return;
    }

    var SIMPAN_KK_URL = <?= json_encode($kkBase) ?> + 'nursing-assessments/add';
    var payload = $('#form-kajian-keperawatan').serialize();

    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: SIMPAN_KK_URL,
        method: 'POST',
        data: payload,
        dataType: 'json'
    }).done(function (res) {
        if (res && res.success) {
            $('#kk-message').text('Pengkajian keperawatan berhasil disimpan.').css('color', '#047857');
            $('#btn-cetak-kk').prop('disabled', false);
        } else {
            $('#kk-message').text((res && res.message) || 'Gagal menyimpan.').css('color', '#b91c1c');
        }
    }).fail(function (xhr) {
        $('#kk-message').text('Gagal menyimpan (' + xhr.status + ').').css('color', '#b91c1c');
    }).always(function () {
        $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan');
    });
});
</script>