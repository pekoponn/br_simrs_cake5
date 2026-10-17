<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Leave $leave
 * @var \Cake\Collection\CollectionInterface|string[] $branches
 */
echo $this->Html->script(['/plugins/tinymce/tinymce.min', '/plugins/tinymce/tinymce.setting'], ['fullBase' => true]);
$dataChild = $this->Html->link('Absen', ['action' => 'index'], ['full_base' => true]);
$facePath = '';
$rawFacePath = !empty($userFacePath) ? (string)$userFacePath : (!empty($getUser->face) ? (string)$getUser->face : '');

if (!empty($rawFacePath)) {
    $facePath = str_replace('\\', '/', ltrim($rawFacePath, '/'));
    $normalizedLower = strtolower($facePath);

    $uploadsMarkerPos = strpos($normalizedLower, 'uploads/faces/');
    if ($uploadsMarkerPos !== false) {
        $facePath = substr($facePath, $uploadsMarkerPos);
    } elseif (strpos($facePath, 'uploads/faces/') !== 0) {
        $facePath = 'uploads/faces/' . basename($facePath);
    }
}
$faceReferenceUrl = !empty($facePath) ? $this->Url->build('/' . $facePath, ['fullBase' => true]) : '';
$hasEarlyLeave = !empty($checkLicenseToday);
$modelsBaseUrl = $this->Url->build('/models', ['fullBase' => false]);

$userTimezone = $getUser->zona ?? 'WIB';
$timezoneMap = [
    'WIB' => 'Asia/Jakarta',
    'WITA' => 'Asia/Makassar',
    'WIT' => 'Asia/Jayapura'
];
$jsTimezone = $timezoneMap[$userTimezone] ?? 'Asia/Jakarta';
// pr($dataRow);
?>
<script>const USER_TIMEZONE = '<?= $jsTimezone ?>';</script>
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<div class="col-xl-5 col-lg-6">
    <?= $this->Form->create($absence) ?>
    <div class="card border-0 mb-3 bg-dark text-white">
        <div class="card-body">
            <?php if (!empty($checkAssignmentToday)) : ?>
            <div class="alert alert-info">
                <strong><i class="fas fa-briefcase"></i>Surat Tugas Aktif</strong>
                <br>
                Berlaku:<?= date('d M Y', strtotime($checkAssignmentToday->date_from)) ?> s/d <?= date('d M Y', strtotime($checkAssignmentToday->date_end)) ?>
            </div>
            <?php endif; ?>
            <div id="alertGeo"></div>
            <div class="mb-3 text-grey"><b>Absensi Hari Ini</b>
                <span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Absensi.." data-placement="top" data-content="Pengambilan data absensi."></i></span>
            </div>
            <div class="row align-items-center p-b-1">
                <div class="col-10">
                    <div class="m-b-2 text-grey f-s-18"><span id="currentDateTime"></span> <span id="statusSpin"></span></div>
                    <div class="text-grey f-s-11 m-b-15 text-truncate">Lat: <span id="latitude"></span><br>Lang: <span id="longitude"></span></div>
                    <div class="m-b-2 text-truncate">Hai.. <?= $getUser->name ?>, bagaimana harimu saat ini?</div>
                    <div id="alertFace" class="m-b-10"></div>
                    <div class="m-b-10">
                        <video id="face-video" autoplay muted playsinline style="width:100%;max-height:220px;border-radius:10px;background:#111;transform:scaleX(1);"></video>
                        <canvas id="face-canvas" style="display:none;"></canvas>
                    </div>
                    <div class="m-b-10 text-center">
                        Similarity: <b id="face-similarity">-</b>%
                    </div>
                    <!-- <div class="row m-b-2">
                        <div class="col-12 text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condition_type" id="condPulang" value="Pulang" disabled>
                                    <label class="form-check-label" for="condPulang">
                                        Pulang
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="condition_type" id="condKembali" value="Kembali" disabled>
                                    <label class="form-check-label" for="condKembali">
                                        Kembali
                                    </label>
                                </div>
                            </div>
                            <small class="text-danger d-block mt-2">
                                * Tombol hanya dapat dipilih setelah user membuat izin pulang.
                            </small>
                        </div>
                    </div> -->
                    <div class="row m-b-2">
                        <div class="col-6">
                            <?php
                            echo $this->Form->control('userId', ['type' => 'hidden', 'id' => 'userId', 'value' => $getUser->id]);
                            echo $this->Form->control('dataLatitude', ['type' => 'hidden', 'id' => 'hideLatitude']);
                            echo $this->Form->control('dataLongitude', ['type' => 'hidden', 'id' => 'hideLongitude']);
                            echo $this->Form->control('dataSimilarity', ['type' => 'hidden', 'id' => 'hideSimilarity', 'value' => 0]);
                            // echo $this->Form->control('conditions', ['type' => 'hidden', 'id' => 'conditionField', 'value' => '']);
                            echo $this->Form->button('IN', ['class' => 'btn btn-indigo m-r-5 m-b-5', 'type' => 'button', 'escape' => false, 'id' => 'btn-happy', 'disabled'=>true, 'onclick'=>"btnCond('I')"]);
                            ?>
                        </div>
                        <div class="col-6 text-right">
                        <?php
                        echo $this->Form->button('OUT', ['class' => 'btn btn-warning m-r-5 m-b-5', 'type' => 'button', 'escape' => false, 'id' => 'btn-indifferent', 'disabled'=>true, 'onclick'=>"btnCond('O')"]);
                        ?>
                        </div>
                        <div class="m-b-2 text-truncate">
                        <small class="text-danger">
                            * Jika mengalami kendala absensi, silahkan screenshot halaman ini dan isi kendala pada <br> <a href="<?= $this->Url->build(['prefix' => false, 'controller' => 'AbsentIssues', 'action' => 'add']) ?>" class="btn btn-warning btn-sm"><i class="fas fa-exclamation-triangle"></i>Kendala Absensi</a>
                        </small>
                    </div>
                    </div>
                </div>
            </div>          
        </div>
    </div>
    <div class="card border-0 mb-3 bg-dark text-white">
        <div class="card-body">
            <div class="m-b-2 text-grey"><b>Riwayat Absensi</b>
                <span class="ml-2"><i class="fa fa-info-circle" data-toggle="popover" data-trigger="hover" data-title="Riwayat Absensi.." data-placement="top" data-content="Riwayat absensi yang sudah dilakukan."></i></span>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Jam</th>
                        </tr>
                    </thead>
                            <tbody id="attendance-history-body">
                        <?php if (!empty($historyAbsences)) : ?>
                            <?php foreach ($historyAbsences as $history) : ?>
                                <tr>
                                    <td><?= date('d-m-Y') ?></td>
                                    <td>
                                        <i class="fa fa-circle <?= $history['type'] === 'I' ? 'text-lime' : 'text-red' ?> f-s-8 mr-2"></i>
                                        <?= h($history['mode']) ?>
                                    </td>
                                    <td><?= h($history['time']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center">Belum ada absensi hari ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>          
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
<?php
$urlGetData = $this->Url->build(['prefix' => 'Hr', 'controller' => 'Absences', 'action' => 'saveData', '_full'=>true]);
$officeLat = 0;
$officeLong = 0;
$hasRadius = false;

if (!empty($getUser->radius_id) && $getUser->radius_id != '0') {
    $parts = explode(',', $getUser->radius_id);
    $officeLat = $parts[0] ?? 0;
    $officeLong = $parts[1] ?? 0;
    $hasRadius = true;
}
?>
<script>
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371000; // meter
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) *
        Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}
var geoReady = false;
var faceReady = false;
var faceSimilarity = 0;
var faceStream = null;
var registeredDescriptor = null;
var FACE_THRESHOLD = 50;
const hasRadius = <?= $hasRadius ? 'true' : 'false' ?>;
const officeLat = parseFloat("<?= $officeLat ?>");
const officeLong = parseFloat("<?= $officeLong ?>");
const officeRadius = 15; // radius dalam meter
const hasEarlyLeave = <?= $hasEarlyLeave ? 'true' : 'false' ?>;
const isDynamicUser = !hasRadius || hasEarlyLeave;

// ===== Suara absen =====
var soundIn  = new Audio('<?= $this->Url->build('/audio/in.mpeg') ?>');
var soundOut = new Audio('<?= $this->Url->build('/audio/out.mpeg') ?>');
soundIn.preload  = 'auto';
soundOut.preload = 'auto';

function playAttendanceSound(cond) {
    var snd = (cond === 'I') ? soundIn : soundOut;
    try {
        soundIn.pause();  soundIn.currentTime  = 0;
        soundOut.pause(); soundOut.currentTime = 0;
        snd.play().catch(function (e) { console.log('Audio diblokir:', e); });
    } catch (e) {
        console.log(e);
    }
}

function getUserNow() {
    return new Date(
        new Date().toLocaleString("en-US", {
            timeZone: USER_TIMEZONE
        })
    );
}

// function isConditionSelected() {
//     return $('input[name="condition_type"]:checked').length > 0;
// }

function updateAttendanceButtons() {
    // if (hasEarlyLeave) {
    //     $('input[name="condition_type"]').prop('disabled', false);
    // } else {
    //     $('input[name="condition_type"]').prop('disabled', true);
    // }
    updateButtonByTime();
}

function setFaceAlert(message, type) {
    var alertClass = 'alert-warning';
    if (type === 'success') {
        alertClass = 'alert-success';
    } else if (type === 'danger') {
        alertClass = 'alert-danger';
    }
    $('#alertFace').html('<div class="alert ' + alertClass + ' fade show"><strong>' + message + '</strong></div>');
}

function refreshAttendanceHistory() {
    $.getJSON('<?= $this->Url->build(['prefix' => 'Hr', 'controller' => 'Absences', 'action' => 'todayHistory']) ?>', function (rows) {
        var $body = $('#attendance-history-body').empty();
        if (!rows || !rows.length) {
            $body.append('<tr><td colspan="3" class="text-center">Belum ada absensi hari ini.</td></tr>');
            return;
        }
        rows.forEach(function (row) {
            var color = row.type === 'I' ? 'text-lime' : 'text-red';
            var mode = $('<div>').text(row.mode).html();
            var time = $('<div>').text(row.time).html();
            $body.append('<tr><td><?= date('d-m-Y') ?></td><td><i class="fa fa-circle ' + color + ' f-s-8 mr-2"></i>' + mode + '</td><td>' + time + '</td></tr>');
        });
    });
}

function appendAttendanceHistory(type) {
    var now = getUserNow();
    var pad = function (value) { return String(value).padStart(2, '0'); };
    var date = pad(now.getDate()) + '-' + pad(now.getMonth() + 1) + '-' + now.getFullYear();
    var time = pad(now.getHours()) + ':' + pad(now.getMinutes());
    var mode = type === 'I' ? 'Masuk' : 'Pulang';
    var color = type === 'I' ? 'text-lime' : 'text-red';
    var $body = $('#attendance-history-body');

    $body.find('td[colspan="3"]').closest('tr').remove();
    $body.append(
        '<tr><td>' + date + '</td><td><i class="fa fa-circle ' + color +
        ' f-s-8 mr-2"></i>' + mode + '</td><td>' + time + '</td></tr>'
    );
}

function btnCond(cond) {
    $('#statusSpin').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
        // alert(cond);
    if (!faceReady || faceSimilarity < FACE_THRESHOLD) {
        setFaceAlert('Wajah belum diverifikasi. Silakan verifikasi wajah terlebih dahulu.', 'danger');
        $('#statusSpin').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
        return;
    }

    if(cond.length != 0) {
        var dataUserId = $('#userId').val();
        var dataLat = $('#hideLatitude').val();
        var dataLong = $('#hideLongitude').val();
        var dataSimilarity = $('#hideSimilarity').val();
        // var dataCondition = $('#conditionField').val() || $('input[name="condition_type"]:checked').val();
        $.ajax({
            type: 'POST', // Metode pengiriman data menggunakan POST
            url: '<?php echo $urlGetData; ?>', // File pemroses data
            data: {
                id:dataUserId, status:cond, lat:dataLat, long:dataLong, similarity:dataSimilarity
                // , conditions:dataCondition
            }, 
            headers: {
                'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
            },
            //Data yang akan dikirim ke file pemroses                
            cache: false,
            async: true,
            // processData: false,
            // contentType: false,
            success: function(response) {
                var responseCode = (typeof response === 'string') ? response.replace(/"/g, '') : response;
                if(responseCode=='Y') {
                playAttendanceSound(cond);
                SwalHelper.success("Terimakasih, Selamat beraktivitas", "Absen sudah masuk");
                appendAttendanceHistory(cond);
                }else if(responseCode=='S') {
                SwalHelper.warning("Absen sudah dilakukan", "Maaf... anda sudah melakukan absensi...", "warning");
                refreshAttendanceHistory();
                }else if(responseCode=='F') {
                SwalHelper.warning("Informasi", "Wajah tidak sesuai. Silakan verifikasi ulang.", "warning");
                }else if(responseCode=='NF') {
                SwalHelper.warning("Informasi", "Data wajah user belum terdaftar. Silakan isi face di menu users.", "warning");
                }else {
                SwalHelper.warning("Informasi", "Proses absensi gagal. Silakan coba lagi.", "warning");
                }
                $('#statusSpin').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
            },
            error: function() {
                // alert('gagal');
                SwalHelper.error("Error", "Maaf, terjadi kesalahan!!", "error");

                $('#statusSpin').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
                console.log('error');
            }
            // SwalHelper.success('Data Berhasil Ditambahkan')
        }); 
    } else {
        $('#statusSpin').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
    }
//   element.style.color = color;
}
function updateButtonByTime() {
    $('#btn-happy').prop('disabled', !(geoReady && faceReady));
    $('#btn-indifferent').prop('disabled', !(geoReady && faceReady));
}

$(document).ready(function() {
    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix' => false, 'controller' => 'Absences', 'action' => 'add'], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
    // $('input[name="condition_type"]').on('change', function () {
    //     $('#conditionField').val($(this).val());
    //     updateButtonByTime();
    // });
    async function initFaceVerification() {
        if (typeof faceapi === 'undefined') {
            setFaceAlert('Library face-api gagal dimuat.', 'danger');
            return;
        }
        var referenceImageUrl = '<?= $faceReferenceUrl ?>';
        if (!referenceImageUrl) {
            setFaceAlert('Face belum terdaftar untuk user ini. Tambahkan face di menu users.', 'danger');
            return;
        }
        try {
            setFaceAlert('Memuat model face recognition...', 'warning');
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('<?= $modelsBaseUrl ?>'),
                faceapi.nets.faceLandmark68Net.loadFromUri('<?= $modelsBaseUrl ?>'),
                faceapi.nets.faceRecognitionNet.loadFromUri('<?= $modelsBaseUrl ?>')
            ]);
            var refImage = await faceapi.fetchImage(referenceImageUrl);
            var refDetection = await faceapi .detectSingleFace(refImage, new faceapi.TinyFaceDetectorOptions()) .withFaceLandmarks() .withFaceDescriptor();
            if (!refDetection) {
                setFaceAlert('Foto face terdaftar tidak valid. Ulangi pendaftaran face.', 'danger');
                return;
            }
            registeredDescriptor = refDetection.descriptor;
            faceStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                },
                audio: false
            });
            var faceVideo = document.getElementById('face-video');
            faceVideo.srcObject = faceStream;
            faceVideo.style.transform = 'scaleX(-1)';

            faceVideo.addEventListener('play', () => {
                setFaceAlert('Kamera aktif. Verifikasi wajah otomatis berjalan...', 'success');
                setInterval(async () => {
                    if (faceReady) {
                        return;
                    }
                    await verifyFaceNow();
                }, 2000); // cek tiap 2 detik
            });
        } catch (error) {
            setFaceAlert('Gagal inisialisasi face recognition: ' + error.message, 'danger');
        }
    }
    async function verifyFaceNow() {
        var faceVideo = document.getElementById('face-video');
        var faceCanvas = document.getElementById('face-canvas');

        if (!registeredDescriptor || !faceVideo.srcObject) {
            setFaceAlert('Kamera atau data face belum siap.', 'danger');
            return;
        }
        try {
            setFaceAlert('Memverifikasi wajah...', 'warning');
            $('#btn-verify-face').prop('disabled', true);
            faceCanvas.width = faceVideo.videoWidth || 640;
            faceCanvas.height = faceVideo.videoHeight || 480;
            faceCanvas.getContext('2d').drawImage(faceVideo, 0, 0, faceCanvas.width, faceCanvas.height);
            var detection = await faceapi .detectSingleFace(faceVideo, new faceapi.TinyFaceDetectorOptions()) .withFaceLandmarks() .withFaceDescriptor();
            if (!detection) {
                faceReady = false;
                faceSimilarity = 0;
                $('#face-similarity').text('-');
                $('#hideSimilarity').val(0);
                setFaceAlert('Wajah tidak terdeteksi. Pastikan wajah terlihat jelas.', 'danger');
                updateAttendanceButtons();
                return;
            }

            var distance = faceapi.euclideanDistance(detection.descriptor, registeredDescriptor);
            var similarity = Math.round((1 - distance) * 100);
            similarity = Math.max(0, similarity);

            faceSimilarity = similarity;
            $('#face-similarity').text(similarity);
            $('#hideSimilarity').val(similarity);

            if (similarity >= FACE_THRESHOLD) {
                faceReady = true;
                setFaceAlert('Verifikasi berhasil. Similarity ' + similarity + '%.', 'success');
            } else {
                faceReady = false;
                setFaceAlert('Verifikasi gagal. Similarity ' + similarity + '% (minimum ' + FACE_THRESHOLD + '%).', 'danger');
            }
            updateAttendanceButtons();
        } catch (error) {
            faceReady = false;
            setFaceAlert('Gagal verifikasi wajah: ' + error.message, 'danger');
            updateAttendanceButtons();
        } finally {
            // $('#btn-verify-face').prop('disabled', false);
        }
    }

    $('#btn-verify-face').on('click', verifyFaceNow);
    initFaceVerification();
    
    function updateDateTime() {
        const dateTimeSpan = document.getElementById('currentDateTime');
        // const now = new Date();
        const now = getUserNow();
        // Format the date and time in 24-hour format
        const options = {
            timeZone: USER_TIMEZONE,
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false // Ensures 24-hour format
        };
        const formattedDateTime = now.toLocaleString('en-US', options);
        dateTimeSpan.textContent = formattedDateTime;
    }
    // Call the function once to display immediately
    updateDateTime();
    // Update the time every second
    setInterval(updateDateTime, 1000);
    setInterval(updateButtonByTime, 30000);
    //________Mengambil nilai GPS pada client.
	if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(geoSucc, geoErr, geoOpt);
    } else {
      $("#alertGeo").html('Geolocation is not supported by this browser.');
    }
    function geoSucc(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        var hideLatitude = document.getElementById('hideLatitude');
        var hideLongitude = document.getElementById('hideLongitude');
        hideLatitude.value = latitude;
        hideLongitude.value = longitude;
        $("#latitude").html(latitude);
        $("#longitude").html(longitude);
        if (hasEarlyLeave) {
            // $('#alertGeo').html(`
            //     <div class="alert alert-success fade show">
            //         <strong>Mode dinamis aktif ✅</strong><br>
            //         Area kantor tidak dibatasi karena izin keluar hari ini.
            //     </div>
            // `);
            geoReady = true;
            updateAttendanceButtons();
            return;
        }
        if (!hasRadius) {
            geoReady = true;
            updateAttendanceButtons();
            return;
        }

        var distance = calculateDistance(latitude, longitude, officeLat, officeLong);
        // console.log("Distance:", distance);
        if (distance > officeRadius) {
            geoReady = false;

            $('#alertGeo').html(`
                <div class="alert alert-danger fade show">
                    <strong>Anda di luar area kantor ❌</strong><br>
                    Jarak: ${Math.round(distance)} meter (maks ${officeRadius} m)
                </div>
            `);
            updateAttendanceButtons();
            if (faceStream) {
                faceStream.getTracks().forEach(track => track.stop());
            }
            return;
        }
        $('#alertGeo').html(`
            <div class="alert alert-success fade show">
                <strong>Dalam area kantor ✅</strong><br>
                Jarak: ${Math.round(distance)} meter
            </div>
        `);
        geoReady = true;
        updateAttendanceButtons();
    }
	function geoErr(error) {
		switch(error.code) {
		  case error.PERMISSION_DENIED:
		    var errorMsg = 'Pengguna menolak permintaan Geolocation, silakan menghidupkan GPS.';
		    //$("#demo").html('User denied the request for Geolocation.');
		    break;
		  case error.POSITION_UNAVAILABLE:
		    var errorMsg = 'Maaf, Informasi lokasi tidak tersedia.';
		    //$("#demo").html('Location information is unavailable.');
		    break;
		  case error.TIMEOUT:
		    var errorMsg = 'Permintaan untuk mendapatkan lokasi pengguna telah habis waktunya.';
		    //$("#demo").html('The request to get user location timed out.');
		    break;
		  case error.UNKNOWN_ERROR:
		    var errorMsg = 'Maaf, Terjadi kesalahan yang tidak diketahui.';
		    //$("#demo").html('An unknown error occurred.');
		    break;
		}

		$("#alertGeo").html('<div class="alert alert-danger fade show"><span class="close" data-dismiss="alert">×</span><strong>'+errorMsg+'</strong></div>');
        geoReady = false;
        updateAttendanceButtons();
	}
	var geoOpt = {
		// timeout: 1000,
		// maximumAge: 30
	}
	//________End GPS    
});
</script>
