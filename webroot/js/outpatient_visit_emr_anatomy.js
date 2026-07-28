/* global $, fabric, OUTPATIENT_ANATOMY_CONFIG */

/**
 * Editor anatomi pasien untuk halaman EMR rawat jalan.
 * Canvas memakai Fabric.js dan hasil akhirnya disimpan sebagai PNG base64.
 */
(function () {
    'use strict';

    var canvas = null;
    var activeSide = null;
    var activeDefaultUrl = null;
    var undoStack = [];
    var config = window.OUTPATIENT_ANATOMY_CONFIG || {};
    var loadRequestId = 0;
    var backgroundObject = null;

    /**
     * Tampilkan pesan status singkat pada toolbar modal.
     */
    function setMessage(message, type) {
        var color = type === 'error' ? '#dc3545' : (type === 'success' ? '#28a745' : '#6c757d');
        $('#anatomy-save-message').css('color', color).text(message || '');
    }

    /**
     * Tambahkan cache buster agar browser mengambil gambar versi terbaru.
     */
    function withCacheBuster(url) {
        var separator = url.indexOf('?') === -1 ? '?' : '&';
        return url + separator + 't=' + new Date().getTime();
    }

    /**
     * Buat instance Fabric.js sekali saja dan aktifkan mode gambar bebas.
     */
    function initCanvas() {
        if (canvas) {
            return canvas;
        }

        canvas = new fabric.Canvas('anatomy-canvas', {
            isDrawingMode: false,
            selection: false
        });

        canvas.freeDrawingBrush.color = '#00b050';
        canvas.freeDrawingBrush.width = 4;

        // Fabric memakai canvas atas untuk input mouse; layer ini harus transparan agar gambar anatomi terlihat.
        $(canvas.upperCanvasEl).css('background', 'transparent');
        $(canvas.lowerCanvasEl).css('background', '#ffffff');

        // Simpan object path terbaru untuk kebutuhan undo.
        canvas.on('path:created', function (event) {
            if (event.path) {
                undoStack.push(event.path);
            }
        });

        return canvas;
    }

    /**
     * Muat gambar anatomi sebagai background sehingga dokter bisa menggambar di atasnya.
     */
    function loadBackground(imageUrl) {
        var editor = initCanvas();
        var currentLoadId = ++loadRequestId;

        undoStack = [];
        backgroundObject = null;
        editor.isDrawingMode = false;
        editor.clear();
        editor.setBackgroundColor('#ffffff', editor.renderAll.bind(editor));
        setMessage('Memuat gambar anatomi...', 'info');

        var image = new Image();
        image.onload = function () {
            if (currentLoadId !== loadRequestId) {
                return;
            }

            var img = new fabric.Image(image);
            var canvasWidth = editor.getWidth();
            var canvasHeight = editor.getHeight();
            var scale = Math.min(canvasWidth / img.width, canvasHeight / img.height);
            var left = (canvasWidth - (img.width * scale)) / 2;
            var top = (canvasHeight - (img.height * scale)) / 2;

            // Gambar anatomi dijadikan object paling bawah agar stabil di Fabric.js dan ikut export PNG.
            img.set({
                scaleX: scale,
                scaleY: scale,
                left: left,
                top: top,
                originX: 'left',
                originY: 'top',
                selectable: false,
                evented: false,
                hasControls: false,
                hasBorders: false,
                lockMovementX: true,
                lockMovementY: true,
                lockRotation: true,
                lockScalingX: true,
                lockScalingY: true
            });

            backgroundObject = img;
            editor.add(backgroundObject);
            editor.sendToBack(backgroundObject);
            editor.isDrawingMode = true;
            editor.requestRenderAll();
            setMessage('Siap digambar.', 'success');
        };
        image.onerror = function () {
            if (currentLoadId !== loadRequestId) {
                return;
            }

            editor.isDrawingMode = false;
            setMessage('Gambar anatomi gagal dimuat. Cek file gambar di folder webroot/img/anatomy.', 'error');
        };
        image.src = withCacheBuster(imageUrl);
    }

    /**
     * Buka modal editor berdasarkan thumbnail anatomi yang diklik.
     */
    function openEditor($button) {
        if (typeof fabric === 'undefined') {
            alert('Library Fabric.js belum termuat. Periksa koneksi atau asset Fabric.js.');
            return;
        }

        activeSide = $button.data('side');
        activeDefaultUrl = $button.data('default-url');

        $('#anatomy-modal-title').text($button.data('title') || 'Anatomi Tubuh Pasien');
        setMessage('Memuat gambar anatomi...', 'info');

        // Jika modal sudah terbuka, muat ulang langsung; jika belum, tunggu sampai terlihat.
        if ($('#modal-anatomy-editor').hasClass('in') || $('#modal-anatomy-editor').is(':visible')) {
            loadBackground($button.data('image-url'));
        } else {
            $('#modal-anatomy-editor').one('shown.bs.modal', function () {
                loadBackground($button.data('image-url'));
            });
            $('#modal-anatomy-editor').modal('show');
        }
    }

    /**
     * Kirim PNG base64 ke controller CakePHP melalui AJAX.
     */
    function saveImage() {
        if (!canvas || !activeSide) {
            return;
        }

        var imageData = canvas.toDataURL({
            format: 'png'
        });

        $('#btn-anatomy-save').prop('disabled', true);
        setMessage('Menyimpan gambar...', 'info');

        $.ajax({
            url: config.saveUrl,
            method: 'POST',
            dataType: 'json',
            data: {
                side: activeSide,
                image: imageData,
                _csrfToken: config.csrfToken
            },
            headers: config.csrfToken ? {
                'X-CSRF-Token': config.csrfToken
            } : {},
            success: function (response) {
                if (!response || !response.success) {
                    setMessage((response && response.message) || 'Gagal menyimpan gambar.', 'error');
                    return;
                }

                var freshUrl = withCacheBuster(response.file_url);
                var $thumb = $('.js-open-anatomy[data-side="' + activeSide + '"]');

                // Update thumbnail dan data modal agar edit berikutnya memakai PNG terbaru.
                $thumb.data('image-url', freshUrl);
                $thumb.find('img').attr('src', freshUrl);
                $thumb.find('.anatomy-thumb-status').text('Sudah disimpan');

                setMessage(response.message || 'Gambar anatomi berhasil disimpan.', 'success');
                setTimeout(function () {
                    $('#modal-anatomy-editor').modal('hide');
                }, 600);
            },
            error: function (xhr) {
                var response = xhr.responseJSON || {};
                setMessage(response.message || 'Gagal menyimpan gambar anatomi.', 'error');
            },
            complete: function () {
                $('#btn-anatomy-save').prop('disabled', false);
            }
        });
    }

    $(function () {
        // Klik thumbnail membuka modal Fabric editor.
        $(document).on('click', '.js-open-anatomy', function () {
            openEditor($(this));
        });

        // Tombol Pena memastikan mode gambar aktif.
        $('#btn-anatomy-pen').on('click', function () {
            if (canvas) {
                canvas.isDrawingMode = true;
                setMessage('Mode pena aktif.', 'info');
            }
        });

        // Tombol Undo menghapus coretan terakhir pada sesi edit saat ini.
        $('#btn-anatomy-undo').on('click', function () {
            var lastPath = undoStack.pop();
            if (canvas && lastPath) {
                canvas.remove(lastPath);
                canvas.requestRenderAll();
            }
        });

        // Tombol Reset/Clear mengembalikan anatomi ke gambar default sisi tersebut.
        $('#btn-anatomy-clear').on('click', function () {
            if (activeDefaultUrl) {
                loadBackground(activeDefaultUrl);
            }
        });

        // Tombol Simpan mengekspor canvas sebagai PNG.
        $('#btn-anatomy-save').on('click', saveImage);
    });
}());
