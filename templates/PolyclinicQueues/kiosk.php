<!-- templates/PolyclinicQueues/kiosk.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Mesin Anjungan Ambil Antrian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(rgba(8, 15, 40, 0.85), rgba(8, 15, 40, 0.85)),
                url('https://images.unsplash.com/photo-1587351021759-3e566b3db4f1?q=80&w=1974&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 40px 15px;
        }

        .main-card {
            border: none;
            border-radius: 35px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .left-side {
            background: linear-gradient(180deg, #0d6efd, #003c99);
            color: white;
            padding: 50px 40px;
            height: 100%;
            position: relative;
        }

        .hospital-logo {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            margin-bottom: 25px;
        }

        .hospital-title {
            font-size: 36px;
            font-weight: bold;
            line-height: 1.2;
        }

        .hospital-subtitle {
            margin-top: 18px;
            font-size: 18px;
            opacity: 0.9;
        }

        .feature-box {
            margin-top: 45px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 22px;
            font-size: 17px;
        }

        .feature-item i {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .right-side {
            padding: 50px 45px;
        }

        .form-title {
            font-size: 32px;
            font-weight: bold;
            color: #0d1b3e;
        }

        .form-subtitle {
            color: #6c757d;
            margin-top: 8px;
            margin-bottom: 35px;
            font-size: 17px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #0d1b3e;
        }

        .form-select {
            height: 58px;
            border-radius: 16px;
            border: 2px solid #e7ebf3;
            font-size: 17px;
            padding-left: 18px;
        }

        .btn-queue {
            width: 100%;
            height: 62px;
            border-radius: 18px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            background: linear-gradient(90deg, #198754, #0f9d58);
        }

        .queue-result {
            margin-top: 40px;
            background: linear-gradient(135deg, #f8fbff, #eef5ff);
            border-radius: 28px;
            padding: 35px;
            text-align: center;
            border: 2px dashed #0d6efd;
        }

        .queue-code {
            font-size: 95px;
            font-weight: 900;
            color: #0d6efd;
            line-height: 1;
            margin: 15px 0;
        }

        .poli-name {
            margin-top: 18px;
            display: inline-block;
            padding: 10px 22px;
            border-radius: 999px;
            background: #198754;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .footer-note {
            margin-top: 20px;
            color: #6c757d;
        }

        @media (max-width: 991px) {
            .right-side {
                padding: 35px 25px;
            }

            .queue-code {
                font-size: 70px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="card main-card">
                    <div class="row g-0">

                        <div class="col-lg-5">
                            <div class="left-side">
                                <div class="hospital-logo">
                                    <i class="fa-solid fa-hospital"></i>
                                </div>

                                <div class="hospital-title">
                                    Mesin Antrian Loket
                                </div>

                                <div class="hospital-subtitle">
                                    Rumah Sakit Bhakti Rahayu
                                </div>

                                <div class="feature-box">
                                    <div class="feature-item">
                                        <i class="fa-solid fa-clock"></i>
                                        <span>Ambil nomor antrian loket</span>
                                    </div>

                                    <div class="feature-item">
                                        <i class="fa-solid fa-ticket"></i>
                                        <span>Nomor antrian otomatis</span>
                                    </div>

                                    <div class="feature-item">
                                        <i class="fa-solid fa-hospital-user"></i>
                                        <span>Lanjut pendaftaran di loket</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="right-side">

                                <?= $this->Flash->render() ?>

                                <div class="form-title">
                                    Ambil Nomor Antrian
                                </div>

                                <div class="form-subtitle">
                                    Pilih tujuan poli awal, lalu ambil nomor antrian loket.
                                </div>

                                <?= $this->Form->create(null) ?>

                                <div class="mb-4">
                                    <label class="form-label">Pilih Poli Tujuan</label>

                                    <?= $this->Form->control('poly_name', [
                                        'type' => 'select',
                                        'options' => $this->Krs->polyclinics(),
                                        'empty' => '-- Pilih Poli --',
                                        'label' => false,
                                        'class' => 'form-select',
                                        'required' => true,
                                        'value' => $this->request->getData('poly_name') ?? ''
                                    ]) ?>
                                </div>

                                <div class="mt-4">
                                    <?= $this->Form->button('Ambil Nomor Sekarang', [
                                        'class' => 'btn btn-success btn-queue'
                                    ]) ?>
                                </div>

                                <?= $this->Form->end() ?>

                                <?php if (!empty($queueNumber)): ?>
                                    <div class="queue-result">
                                        <h4>Nomor Antrian Loket Anda</h4>

                                        <div class="queue-code">
                                            <?= h($queueCode) ?>
                                        </div>

                                        <div class="poli-name">
                                            <?= h($this->request->getData('poly_name')) ?>
                                        </div>

                                        <div class="footer-note">
                                            Silakan menunggu panggilan di loket pendaftaran.
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>