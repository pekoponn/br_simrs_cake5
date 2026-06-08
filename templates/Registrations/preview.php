<?php
/**
 * @var \App\Model\Entity\Registration $registration
 */
?>

<div class="table-responsive">

    <table class="table table-bordered">

        <tr>
            <th width="200">No Registrasi</th>
            <td><?= h($registration->registration_no) ?></td>
        </tr>

        <tr>
            <th>Nama Pasien</th>
            <td>
                <?= $registration->has('patient')
                    ? h($registration->patient->full_name)
                    : '-' ?>
            </td>
        </tr>

        <tr>
            <th>Tanggal Registrasi</th>
            <td><?= h($registration->registration_date) ?></td>
        </tr>

        <tr>
            <th>Pelayanan</th>
            <td><?= h($registration->service_type) ?></td>
        </tr>

        <tr>
            <th>Dokter</th>
            <td>
                <?= $registration->has('doctor')
                    ? h($registration->doctor->full_name)
                    : '-' ?>
            </td>
        </tr>

        <tr>
            <th>Pembayaran</th>
            <td><?= h($registration->payment_method) ?></td>
        </tr>

    </table>

</div>