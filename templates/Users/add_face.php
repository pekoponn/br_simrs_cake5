<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$currentFace = !empty($user->face) ? $this->Url->build('/' . ltrim($user->face, '/'), ['fullBase' => true]) : null;
// $previewPlaceholder = 'https://via.placeholder.com/420x320?text=Belum+Ada+Face';
$previewPlaceholder = $this->Url->build('/webroot/files/face-placeholder.png', ['fullBase' => true]);
?>

<div class="panel panel-inverse">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-dark text-white">
                        <strong>Tambah Face</strong>
                    </div>
                    <div class="card-body">
                        <div class="card-header bg-secondary text-white">
                            <strong>Informasi User</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><b>Nama:</b> <?= h($user->name) ?></p>
                            <p class="mb-1"><b>Kode:</b> <?= h($user->code) ?></p>
                            <p class="mb-1"><b>Divisi:</b> <?= h($user->devision) ?></p>
                            <p class="mb-1"><b>Jabatan:</b> <?= h($user->staff) ?></p>
                            <p class="mb-0"><b>Face:</b> <?= !empty($user->face) ? 'Sudah ada' : 'Belum ada' ?></p>
                        </div>
                        <p class="mb-2 text-muted">Arahkan kamera ke wajah user, lalu ambil foto untuk disimpan ke kolom face.</p>

                        <div class="mb-3 text-center">
                            <video id="camera" autoplay playsinline style="width: 100%; max-width: 520px; border-radius: 12px; background: #111; transform: scaleX(-1);"></video>
                            <canvas id="snapshot" style="display:none; width: 100%; max-width: 520px; border-radius: 12px;"></canvas>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <button type="button" class="btn btn-warning rounded-circle" id="btn-capture" style="width:60px; height:60px;">
                                <i class="fa fa-camera"></i>
                            </button>

                            <!-- <button type="button" class="btn btn-danger" id="btn-retake">
                                🔄 Ulangi
                            </button> -->
                        </div>

                        <?= $this->Form->create($user, ['id' => 'face-form']) ?>
                        <?= $this->Form->control('face_image', ['type' => 'hidden', 'id' => 'face-image']) ?>
                        <?= $this->Form->control('id', ['type' => 'hidden', 'value' => $user->id]) ?>
                        <div class="text-right">
                            <?= $this->Form->button('Simpan Face', ['type' => 'submit', 'class' => 'btn btn-success', 'id' => 'btn-save-face', 'disabled' => true]) ?>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-5">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-secondary text-white">
                        <strong>Informasi User</strong>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><b>Nama:</b> <?= h($user->name) ?></p>
                        <p class="mb-1"><b>Kode:</b> <?= h($user->code) ?></p>
                        <p class="mb-1"><b>Divisi:</b> <?= h($user->staff) ?></p>
                        <p class="mb-0"><b>Face:</b> <?= !empty($user->face) ? 'Sudah ada' : 'Belum ada' ?></p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <strong>Preview Tersimpan</strong>
                    </div>
                    <div class="card-body text-center">
                        <img id="face-preview" src="<?= $currentFace ?: $previewPlaceholder ?>" alt="Preview face" class="img-fluid rounded" style="max-height: 360px; object-fit: cover;">
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<style>
    #btn-capture {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    #btn-capture:hover {
        transform: scale(1.1);
    }
</style>
<script>
    (function () {
        const video = document.getElementById('camera');
        const canvas = document.getElementById('snapshot');
        const faceImage = document.getElementById('face-image');
        const facePreview = document.getElementById('face-preview');
        // const btnStartCamera = document.getElementById('btn-start-camera');
        const btnCapture = document.getElementById('btn-capture');
        // const btnRetake = document.getElementById('btn-retake');
        const btnSaveFace = document.getElementById('btn-save-face');
        const previewPlaceholder = '<?= $previewPlaceholder ?>';

        let stream = null;

        async function startCamera() {
            try {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }

                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user'
                    },
                    audio: false
                });

                video.srcObject = stream;
                video.style.transform = 'scaleX(-1)';
            } catch (error) {
                alert('Kamera tidak bisa dibuka. Pastikan izin kamera sudah diberikan.');
            }
        }

        // function captureFace() {
        //     if (!video.srcObject) {
        //         alert('Kamera belum aktif.');
        //         return;
        //     }

        //     canvas.width = video.videoWidth || 640;
        //     canvas.height = video.videoHeight || 480;

        //     const context = canvas.getContext('2d');
        //     context.translate(canvas.width, 0);
        //     context.scale(-1, 1);
        //     context.drawImage(video, 0, 0, canvas.width, canvas.height);

        //     const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
        //     faceImage.value = dataUrl;
        //     facePreview.src = dataUrl;
        //     btnSaveFace.disabled = false;
        // }
        function captureFace() {
            if (!video.srcObject) {
                alert('Kamera belum aktif.');
                return;
            }

            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;

            const context = canvas.getContext('2d');

            // reset transform biar gak numpuk
            context.setTransform(1, 0, 0, 1, 0, 0);

            // mirror selfie
            context.translate(canvas.width, 0);
            context.scale(-1, 1);

            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/jpeg', 0.92);

            faceImage.value = dataUrl;

            // FREEZE EFFECT
            video.style.display = 'none';
            canvas.style.display = 'block';

            btnSaveFace.disabled = false;
        }

        function retakeFace() {
            faceImage.value = '';
            btnSaveFace.disabled = true;
            facePreview.src = '<?= $currentFace ?: $previewPlaceholder ?>';
        }

        // btnStartCamera.addEventListener('click', startCamera);
        btnCapture.addEventListener('click', captureFace);
        // btnRetake.addEventListener('click', retakeFace);

        document.getElementById('face-form').addEventListener('submit', function (event) {
            if (!faceImage.value) {
                event.preventDefault();
                alert('Silakan ambil foto wajah terlebih dahulu.');
            }
        });

        startCamera();
    })();
</script>