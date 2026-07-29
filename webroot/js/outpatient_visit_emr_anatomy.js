/* global $, fabric, OUTPATIENT_ANATOMY_CONFIG */

/**
 * Editor anatomi untuk EMR dan Kajian Medis Awal.
 * Keduanya memakai canvas Fabric terpisah, tetapi menyimpan file anatomi yang sama.
 */
(function () {
    'use strict';

    var config = window.OUTPATIENT_ANATOMY_CONFIG || {};
    var editors = {
        emr: createEditor({
            modal: '#modal-anatomy-editor',
            canvas: 'anatomy-canvas',
            title: '#anatomy-modal-title',
            message: '#anatomy-save-message',
            pen: '#btn-anatomy-pen',
            undo: '#btn-anatomy-undo',
            clear: '#btn-anatomy-clear',
            save: '#btn-anatomy-save'
        }),
        kma: createEditor({
            modal: '#modal-kma-anatomy-editor',
            canvas: 'kma-anatomy-canvas',
            title: '#kma-anatomy-modal-title',
            message: '#kma-anatomy-save-message',
            pen: '#btn-kma-anatomy-pen',
            undo: '#btn-kma-anatomy-undo',
            clear: '#btn-kma-anatomy-clear',
            save: '#btn-kma-anatomy-save'
        })
    };

    /** Buat state independen untuk setiap modal anatomi. */
    function createEditor(options) {
        return {
            options: options,
            canvas: null,
            side: null,
            defaultUrl: null,
            undoStack: [],
            loadRequestId: 0,
            returnToKajian: false
        };
    }

    function setMessage(editor, message, type) {
        var color = type === 'error' ? '#dc3545' : (type === 'success' ? '#28a745' : '#6c757d');
        $(editor.options.message).css('color', color).text(message || '');
    }

    function withCacheBuster(url) {
        var separator = url.indexOf('?') === -1 ? '?' : '&';
        return url + separator + 't=' + new Date().getTime();
    }

    function initCanvas(editor) {
        if (editor.canvas) {
            return editor.canvas;
        }

        editor.canvas = new fabric.Canvas(editor.options.canvas, {
            isDrawingMode: false,
            selection: false
        });
        editor.canvas.freeDrawingBrush.color = '#0057ff';
        editor.canvas.freeDrawingBrush.width = 4;
        $(editor.canvas.upperCanvasEl).css('background', 'transparent');
        $(editor.canvas.lowerCanvasEl).css('background', '#ffffff');
        editor.canvas.on('path:created', function (event) {
            if (event.path) {
                editor.undoStack.push(event.path);
            }
        });

        return editor.canvas;
    }

    /** Muat gambar anatomi sebagai object paling bawah pada canvas yang sesuai. */
    function loadBackground(editor, imageUrl) {
        var canvas = initCanvas(editor);
        var currentLoadId = ++editor.loadRequestId;

        editor.undoStack = [];
        canvas.isDrawingMode = false;
        canvas.clear();
        canvas.setBackgroundColor('#ffffff', canvas.renderAll.bind(canvas));
        setMessage(editor, 'Memuat gambar anatomi...', 'info');

        var image = new Image();
        image.onload = function () {
            if (currentLoadId !== editor.loadRequestId) {
                return;
            }

            var anatomyImage = new fabric.Image(image);
            var scale = Math.min(canvas.getWidth() / anatomyImage.width, canvas.getHeight() / anatomyImage.height);
            anatomyImage.set({
                scaleX: scale,
                scaleY: scale,
                left: (canvas.getWidth() - (anatomyImage.width * scale)) / 2,
                top: (canvas.getHeight() - (anatomyImage.height * scale)) / 2,
                originX: 'left',
                originY: 'top',
                selectable: false,
                evented: false,
                hasControls: false,
                hasBorders: false
            });
            canvas.add(anatomyImage);
            canvas.sendToBack(anatomyImage);
            canvas.isDrawingMode = true;
            canvas.requestRenderAll();
            setMessage(editor, 'Siap digambar.', 'success');
        };
        image.onerror = function () {
            if (currentLoadId === editor.loadRequestId) {
                setMessage(editor, 'Gambar anatomi gagal dimuat.', 'error');
            }
        };
        image.src = withCacheBuster(imageUrl);
    }

    function openEditor(editor, $button) {
        if (typeof fabric === 'undefined') {
            alert('Library Fabric.js belum termuat.');
            return;
        }

        editor.side = $button.data('side');
        editor.defaultUrl = $button.data('default-url');
        $(editor.options.title).text($button.data('title') || 'Anatomi Tubuh Pasien');

        function showAnatomyModal() {
            $(editor.options.modal).one('shown.bs.modal', function () {
                loadBackground(editor, $button.data('image-url'));
            }).modal('show');
        }

        // Hindari dua Bootstrap modal aktif bersamaan agar backdrop dan input mouse tetap benar.
        if (editor === editors.kma && (
            $('#modal-kajian-awal').hasClass('in') ||
            $('#modal-kajian-awal').hasClass('show') ||
            $('#modal-kajian-awal').is(':visible')
        )) {
            editor.returnToKajian = true;
            $('#modal-kajian-awal').one('hidden.bs.modal', showAnatomyModal).modal('hide');
            return;
        }

        showAnatomyModal();
    }

    /** Simpan PNG lalu perbarui seluruh thumbnail EMR dan Kajian Medis Awal. */
    function saveImage(editor) {
        if (!editor.canvas || !editor.side) {
            return;
        }

        $(editor.options.save).prop('disabled', true);
        setMessage(editor, 'Menyimpan gambar...', 'info');
        $.ajax({
            url: config.saveUrl,
            method: 'POST',
            dataType: 'json',
            data: {
                side: editor.side,
                image: editor.canvas.toDataURL({ format: 'png' }),
                _csrfToken: config.csrfToken
            },
            headers: config.csrfToken ? { 'X-CSRF-Token': config.csrfToken } : {},
            success: function (response) {
                if (!response || !response.success) {
                    setMessage(editor, (response && response.message) || 'Gagal menyimpan gambar.', 'error');
                    return;
                }

                var freshUrl = withCacheBuster(response.file_url);
                var selector = '[data-side="' + editor.side + '"]';
                $('.js-open-anatomy' + selector + ', .js-open-kma-anatomy' + selector).each(function () {
                    $(this).data('image-url', freshUrl).find('img').attr('src', freshUrl);
                });
                $('.js-open-anatomy' + selector).find('.anatomy-thumb-status').text('Sudah disimpan');
                setMessage(editor, response.message || 'Gambar anatomi berhasil disimpan.', 'success');
                setTimeout(function () {
                    $(editor.options.modal).modal('hide');
                }, 450);
            },
            error: function (xhr) {
                setMessage(editor, (xhr.responseJSON || {}).message || 'Gagal menyimpan gambar anatomi.', 'error');
            },
            complete: function () {
                $(editor.options.save).prop('disabled', false);
            }
        });
    }

    function bindEditor(editor) {
        $(editor.options.pen).on('click', function () {
            if (editor.canvas) {
                editor.canvas.isDrawingMode = true;
                setMessage(editor, 'Mode pena aktif.', 'info');
            }
        });
        $(editor.options.undo).on('click', function () {
            var lastPath = editor.undoStack.pop();
            if (editor.canvas && lastPath) {
                editor.canvas.remove(lastPath);
                editor.canvas.requestRenderAll();
            }
        });
        $(editor.options.clear).on('click', function () {
            if (editor.defaultUrl) {
                loadBackground(editor, editor.defaultUrl);
            }
        });
        $(editor.options.save).on('click', function () {
            saveImage(editor);
        });

        $(editor.options.modal).on('hidden.bs.modal', function () {
            if (editor.returnToKajian) {
                editor.returnToKajian = false;
                $('#modal-kajian-awal').modal('show');
            }
        });
    }

    $(function () {
        bindEditor(editors.emr);
        bindEditor(editors.kma);
        $(document).on('click', '.js-open-anatomy', function () {
            openEditor(editors.emr, $(this));
        });
        $(document).on('click', '.js-open-kma-anatomy', function () {
            openEditor(editors.kma, $(this));
        });
    });
}());
