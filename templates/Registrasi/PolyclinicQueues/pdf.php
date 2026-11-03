<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue $polyclinicQueue
 */

$created = !empty($polyclinicQueue->created)
    ? $polyclinicQueue->created->format('d-m-Y H:i')
    : date('d-m-Y H:i');
$isMobileJkn = $polyclinicQueue->source === 'Mobile JKN';

if (in_array(strtolower((string)$polyclinicQueue->source), ['wa', 'whatsapp'], true)) {
    $source = 'WhatsApp';
} elseif ($isMobileJkn) {
    $source = 'Mobile JKN';
} else {
    $source = 'Manual';
}

$visitDate = !empty($polyclinicQueue->visit_date)
    ? $polyclinicQueue->visit_date->format('d-m-Y')
    : '-';
$checkinTime = !empty($polyclinicQueue->checkin_time)
    ? $polyclinicQueue->checkin_time->format('d-m-Y H:i')
    : '-';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nomor Antrian <?= h($polyclinicQueue->code) ?></title>
    <style>
        @page {
            size: A5 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #1f2933;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fa;
        }

        .ticket-wrap {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12mm;
        }

        .ticket {
            width: 420px;
            max-width: 100%;
            padding: 24px;
            border: 1px solid #d8e0ea;
            border-radius: 10px;
            background: #fff;
            text-align: center;
        }

        .hospital {
            margin: 0 0 4px;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0;
        }

        .subtitle {
            margin: 0 0 18px;
            color: #667085;
            font-size: 13px;
        }

        .queue-label {
            color: #667085;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .queue-number {
            margin: 8px 0 12px;
            color: #1f6feb;
            font-size: 76px;
            font-weight: 800;
            line-height: 1;
        }

        .queue-code {
            margin: 8px 0 12px;
            color: #1f6feb;
            font-size: 76px;
            font-weight: 800;
            line-height: 1;
        }

        .divider {
            margin: 22px 0;
            border: 0;
            border-top: 1px dashed #b9c4d0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        .info-table th {
            width: 36%;
            padding: 6px 0;
            color: #667085;
            font-weight: 700;
            vertical-align: top;
        }

        .info-table td {
            padding: 6px 0;
            color: #1f2933;
            font-weight: 600;
            vertical-align: top;
        }

        .note {
            margin: 20px 0 0;
            color: #667085;
            font-size: 12px;
            line-height: 1.5;
        }

        .actions {
            margin-top: 18px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 6px;
            background: #1f6feb;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        @media print {
            body {
                background: #fff;
            }

            .ticket-wrap {
                min-height: auto;
                padding: 12mm;
            }

            .ticket {
                width: 100%;
                border: 0;
                border-radius: 0;
                padding: 0;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="ticket-wrap">
        <div class="ticket">
            <h1 class="hospital">SIMRS</h1>
            <p class="subtitle">Nomor Antrian Poliklinik</p>

            <div class="queue-label">No Antrian</div>
            <div class="queue-code"><?= h($polyclinicQueue->code ?: '-') ?></div>

            <hr class="divider">

            <table class="info-table">
                <tr>
                    <th>Poliklinik</th>
                    <td><?= h($polyclinicQueue->poly_name ?: '-') ?></td>
                </tr>
                <tr>
                    <th>Pasien</th>
                    <td><?= h($polyclinicQueue->patients_name ?: '-') ?></td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td><?= h($polyclinicQueue->no_telp ?: '-') ?></td>
                </tr>
                <tr>
                    <th>Sumber</th>
                    <td><?= h($source) ?></td>
                </tr>
                <?php if ($isMobileJkn): ?>
                    <tr>
                        <th>Kode Booking</th>
                        <td><?= h($polyclinicQueue->booking_code ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td><?= h($polyclinicQueue->identity_number ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>No BPJS</th>
                        <td><?= h($polyclinicQueue->bpjs_number ?: '-') ?></td>
                    </tr>
                    <tr>
                        <th>Tgl Periksa</th>
                        <td><?= h($visitDate) ?></td>
                    </tr>
                    <tr>
                        <th>Check-in</th>
                        <td><?= h($polyclinicQueue->checkin_status ?: 'Belum Check-in') ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Check-in</th>
                        <td><?= h($checkinTime) ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th>Waktu</th>
                    <td><?= h($created) ?></td>
                </tr>
            </table>

            <p class="note">Silakan menunggu sampai nomor antrian dipanggil oleh petugas.</p>

            <div class="actions">
                <a href="javascript:window.print();" class="btn">Cetak / Simpan PDF</a>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
