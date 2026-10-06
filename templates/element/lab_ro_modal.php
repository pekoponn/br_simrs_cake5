<?php
/**
 * Element: Modal View Hasil Pemeriksaan (Lab/RO) — IGD
 * Simpan di: templates/element/lab_ro_modal.php
 *
 * Cara pakai: <?= $this->element('lab_ro_modal') ?>
 * Tombol pemicu: class="btn-buka-lab-ro" data-id="..." data-noreg="..." data-norm="..." data-nama="..."
 */
$lrBase = $this->Url->build('/');
?>

<div class="modal fade" id="modal-lab-ro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-hasil-dialog" role="document">
        <div class="modal-content hasil-window">
            <div class="hasil-title">
                <span><i class="fa fa-list"></i> VIEW HASIL PEMERIKSAAN</span>
                <button type="button" class="hasil-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>

            <div class="hasil-body">
                <input type="hidden" id="lr-registration-id" value="">

                <div class="row hasil-row">
                    <label class="col-xs-2">No. Registrasi</label>
                    <div class="col-xs-3">
                        <input type="text" id="lr-noreg" class="form-control input-sm" readonly>
                    </div>

                    <label class="col-xs-1">Rekmed</label>
                    <div class="col-xs-2">
                        <input type="text" id="lr-rekmed" class="form-control input-sm" readonly>
                    </div>

                    <label class="col-xs-1">View By</label>
                    <div class="col-xs-3 hasil-radio">
                        <label><input type="radio" name="lr_view_by" value="noreg" checked> Noreg</label>
                        <label><input type="radio" name="lr_view_by" value="rekmed"> Rekmed</label>
                    </div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-2">Nama Pasien</label>
                    <div class="col-xs-6">
                        <input type="text" id="lr-nama" class="form-control input-sm" readonly>
                    </div>
                </div>

                <div class="row hasil-row">
                    <label class="col-xs-2">Hasil Pemeriksaan</label>
                    <div class="col-xs-5 hasil-radio">
                        <label><input type="radio" name="lr_jenis" value="laboratorium" checked> Laboratorium</label>
                        <label><input type="radio" name="lr_jenis" value="radiologi"> Radiologi</label>
                        <label><input type="radio" name="lr_jenis" value="penunjang"> Penunjang</label>
                    </div>

                    <div class="col-xs-5 text-right hasil-actions">
                        <button type="button" class="btn btn-xs btn-default" id="btn-lr-proses">
                            <i class="fa fa-cog"></i> Proses
                        </button>
                        <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">
                            <i class="fa fa-sign-out-alt"></i> KELUAR
                        </button>
                    </div>
                </div>

                <div class="table-responsive hasil-table-wrap">
                    <table class="table table-bordered hasil-table">
                        <thead>
                            <tr>
                                <th style="width:150px;">No. Pemeriksaan</th>
                                <th style="width:120px;">Tanggal</th>
                                <th>Hasil</th>
                                <th style="width:170px;">Nama Dokter</th>
                            </tr>
                        </thead>
                        <tbody id="lr-result-body">
                            <tr>
                                <td colspan="4" style="text-align:center; color:#888; padding:18px;">
                                    Klik <strong>Proses</strong> untuk menampilkan hasil pemeriksaan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.modal-hasil-dialog { width: 760px; max-width: 95%; margin-top: 90px; }
.hasil-window { border: 1px solid #5b78a5; background: #dfe8f7; box-shadow: 0 3px 12px rgba(0,0,0,.25); border-radius: 2px; }
.hasil-title { background: #2c64b7; color: #fff; padding: 5px 8px; font-size: 12px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; }
.hasil-close { border: 0; background: transparent; color: #fff; font-size: 18px; line-height: 18px; padding: 0 4px; opacity: 1; }
.hasil-body { padding: 10px; font-size: 12px; }
.hasil-row { margin-bottom: 6px; }
.hasil-row label { font-size: 12px; font-weight: 600; padding-top: 4px; }
.hasil-radio label { margin-right: 10px; font-weight: 500; }
.hasil-actions .btn { margin-left: 3px; }
.hasil-table-wrap { max-height: 320px; overflow: auto; border: 1px solid #9eb2d1; background: #eef3ff; }
.hasil-table { background: #eef3ff; margin: 0; font-size: 12px; }
.hasil-table th { background: #c8d8f0 !important; text-align: center; font-weight: 700; padding: 5px; color: #1f2937; }
.hasil-table td { height: 34px; background: #f7f9ff; vertical-align: top; padding: 5px; }
</style>

<script>
$(document).on('click', '.btn-buka-lab-ro', function () {
    var $btn = $(this);

    $('#lr-registration-id').val($btn.attr('data-id'));
    $('#lr-noreg').val($btn.attr('data-noreg') || '-');
    $('#lr-rekmed').val($btn.attr('data-norm') || '-');
    $('#lr-nama').val($btn.attr('data-nama') || '-');

    $('input[name="lr_view_by"][value="noreg"]').prop('checked', true);
    $('input[name="lr_jenis"][value="laboratorium"]').prop('checked', true);

    $('#lr-result-body').html(
        '<tr><td colspan="4" style="text-align:center; color:#888; padding:18px;">' +
        'Klik <strong>Proses</strong> untuk menampilkan hasil pemeriksaan.</td></tr>'
    );

    $('#modal-lab-ro').modal('show');
});

$(document).on('click', '#btn-lr-proses', function () {
    var regId = $('#lr-registration-id').val();
    var jenis = $('input[name="lr_jenis"]:checked').val();

    if (!regId) {
        $('#lr-result-body').html(
            '<tr><td colspan="4" style="text-align:center; color:#b91c1c; padding:18px;">Data registrasi tidak ditemukan.</td></tr>'
        );
        return;
    }

    $('#lr-result-body').html(
        '<tr><td colspan="4" style="text-align:center; color:#888; padding:18px;">' +
        '<i class="fa fa-spinner fa-spin"></i> Memuat hasil pemeriksaan...</td></tr>'
    );

    var HASIL_URL = <?= json_encode($lrBase) ?> + 'lab-ro-results/get/' + regId + '?jenis=' + jenis;

    $.getJSON(HASIL_URL, function (res) {
        if (!res || !res.success || !res.data || !res.data.length) {
            $('#lr-result-body').html(
                '<tr><td colspan="4" style="text-align:center; color:#888; padding:18px;">Belum ada hasil pemeriksaan.</td></tr>'
            );
            return;
        }

        var html = '';
        $.each(res.data, function (i, row) {
            html += '<tr>';
            html += '<td>' + (row.no_pemeriksaan || '-') + '</td>';
            html += '<td>' + (row.tanggal || '-') + '</td>';
            html += '<td>' + (row.hasil || '-') + '</td>';
            html += '<td>' + (row.dokter || '-') + '</td>';
            html += '</tr>';
        });
        $('#lr-result-body').html(html);
    }).fail(function (xhr) {
        $('#lr-result-body').html(
            '<tr><td colspan="4" style="text-align:center; color:#b91c1c; padding:18px;">Gagal memuat data (' + xhr.status + ').</td></tr>'
        );
    });
});
</script>