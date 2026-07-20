<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PolyclinicQueue[]|\Cake\Collection\CollectionInterface $polyclinicQueues
 */

$normalizeWhatsAppNumber = function ($phone): string {
    $number = preg_replace('/\D+/', '', (string)$phone);

    if ($number === '') {
        return '';
    }

    if (strpos($number, '0') === 0) {
        return '62' . substr($number, 1);
    }

    return $number;
};

$buildWhatsAppLink = function ($queue) use ($normalizeWhatsAppNumber): ?string {
    $phone = $normalizeWhatsAppNumber($queue->no_telp ?? '');

    if ($phone === '') {
        return null;
    }

    $message = 'Halo, nomor antrian Anda adalah ' . ($queue->code ?? '-') . ".\n"
        . 'Tujuan poli: ' . ($queue->poly_name ?? '-') . ".\n"
        . 'Silakan menunggu panggilan petugas.';

    return 'https://wa.me/' . $phone . '?text=' . rawurlencode($message);
};

$isMobileJknQueue = function ($queue): bool {
    return (string)($queue->source ?? '') === 'Mobile JKN';
};

$isReferralQueue = function ($queue): bool {
    $source = strtolower(trim((string)($queue->source ?? '')));

    return in_array($source, ['rujukan', 'emr rujuk', 'emr_rujuk', 'emr rujukan'], true);
};

$getQueueSession = function ($queue): string {
    $queueSession = strtolower(trim((string)($queue->queue_session ?? '')));
    $queueCode = strtoupper(trim((string)($queue->code ?? '')));

    if ($queueSession === 'afternoon' || strpos($queueCode, 'B-') === 0) {
        return 'afternoon';
    }

    return 'morning';
};

$getQueueVisitDate = function ($queue): string {
    foreach (['visit_date', 'created'] as $dateField) {
        if (empty($queue->{$dateField})) {
            continue;
        }

        if (is_object($queue->{$dateField}) && method_exists($queue->{$dateField}, 'format')) {
            return $queue->{$dateField}->format('Y-m-d');
        }

        $timestamp = strtotime((string)$queue->{$dateField});

        if ($timestamp) {
            return date('Y-m-d', $timestamp);
        }
    }

    return date('Y-m-d');
};

$currentQueueSession = date('H:i') > '14:00' ? 'afternoon' : 'morning';
$today = date('Y-m-d');

$canRegisterQueue = function ($queue) use ($currentQueueSession, $getQueueSession, $getQueueVisitDate, $today): bool {
    return $getQueueVisitDate($queue) === $today
        && $getQueueSession($queue) === $currentQueueSession;
};

$morningQueues = [];
$afternoonQueues = [];
$allQueues = is_array($polyclinicQueues) ? $polyclinicQueues : $polyclinicQueues->toArray();

foreach ($allQueues as $queue) {
    if ($getQueueSession($queue) === 'afternoon') {
        $afternoonQueues[] = $queue;
        continue;
    }

    $morningQueues[] = $queue;
}
?>

<?= $this->Krs->breadcrumb('Polyclinic Queue', 'Data Antrian') ?>

<style>
    .queue-index-page .alert-primary {
        padding: 12px 16px;
        border: 0;
        border-radius: 4px;
        background: #cfe5f8;
        color: #0b3d75;
        font-size: 13px;
    }

    .queue-toolbar {
        margin: 16px 0 18px;
    }

    .queue-toolbar .btn {
        margin-right: 8px;
    }

    .queue-filter {
        padding: 10px 12px;
        background: #49b6d6;
        border-radius: 0;
    }

    .queue-filter .form-control {
        height: 36px;
        border: 0;
        border-radius: 4px;
        font-size: 13px;
    }

    .queue-filter .btn {
        height: 36px;
        min-width: 48px;
        border-radius: 4px;
        font-size: 14px;
    }

    .queue-table {
        margin-bottom: 0;
        background: #fff;
    }

    .queue-section {
        margin-top: 18px;
    }

    .queue-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: #f1f3f5;
        border: 1px solid #e5e9ef;
        border-bottom: 0;
    }

    .queue-section-heading h5 {
        margin: 0;
        color: #172033;
        font-size: 14px;
        font-weight: 800;
    }

    .queue-section-heading .badge {
        font-size: 12px;
    }

    .queue-table thead th {
        padding: 10px 9px;
        border-color: #2d353c !important;
        background: #2d353c;
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        vertical-align: middle;
    }

    .queue-table tbody td {
        padding: 9px 9px;
        border-top: 1px solid #e5e9ef;
        color: #172033;
        font-size: 13px;
        vertical-align: middle;
    }

    .queue-table tbody tr:nth-child(odd) td {
        background: #f1f3f5;
    }

    .queue-table tbody tr:nth-child(even) td {
        background: #fff;
    }

    .queue-code {
        color: #172033;
        font-weight: 800;
    }

    .queue-patient {
        font-weight: 700;
        line-height: 1.25;
    }

    .queue-subtle {
        display: block;
        margin-top: 2px;
        color: #6c757d;
        font-size: 11px;
        font-weight: 600;
    }

    .queue-actions {
        white-space: nowrap;
    }

    .queue-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        min-height: 30px;
        margin: 1px;
        border-radius: 4px;
        padding: 5px 8px;
    }

    .queue-actions .btn-text {
        padding-left: 10px;
        padding-right: 10px;
        gap: 6px;
    }

    .label-mobile-jkn {
        background: #4338ca;
        color: #fff;
    }

    .label-checkin-pending {
        background: #f59c1a;
        color: #fff;
    }

    .label-checkin-done {
        background: #00acac;
        color: #fff;
    }

    .label-checkin-cancel {
        background: #ff5b57;
        color: #fff;
    }

    .queue-pagination {
        padding-top: 12px;
    }

    @media (max-width: 991px) {
        .queue-filter .row > div {
            margin-bottom: 10px;
        }

        .queue-toolbar .btn {
            margin-bottom: 8px;
        }
    }
</style>

<div class="panel panel-inverse queue-index-page">
    <div class="panel-heading">
        <h4 class="panel-title">
            Perincian
        </h4>

        <div class="panel-heading-btn">
            <a href="javascript:;"
                class="btn btn-xs btn-icon btn-circle btn-default"
                data-click="panel-expand">
                <i class="fa fa-expand"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div class="alert alert-primary">
            Halaman <strong>Data Antrian Poliklinik</strong>, digunakan untuk mengelola antrian Manual, WhatsApp, dan Mobile JKN.
        </div>

        <div class="portlet-body form">
            <div class="table-toolbar queue-toolbar">
                <div class="btn-group">
                    <?= $this->Html->link(
                        '<i class="fa fa-plus"> Tambah Antrian WA</i>',
                        ['action' => 'add'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Tambah Antrian WhatsApp'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-mobile-alt"> Tambah Antrian Mobile JKN</i>',
                        ['action' => 'mobileJkn'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Tambah Antrian Mobile JKN'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-desktop"> Mesin Anjungan</i>',
                        ['action' => 'kiosk'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Mesin Anjungan / Manual'
                        ]
                    ) ?>

                    <?= $this->Html->link(
                        '<i class="fa fa-tv"> Display TV</i>',
                        ['action' => 'display'],
                        [
                            'class' => 'btn btn-inverse',
                            'escape' => false,
                            'target' => '_blank',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Tampilan layar TV antrian poli'
                        ]
                    ) ?>
                </div>
            </div>

            <?= $this->Form->create(null, ['type' => 'get']) ?>
                <div class="queue-filter">
                    <div class="row row-space-10">
                        <div class="col-md-3 m-b-10">
                            <?= $this->Form->text('key', [
                                'class' => 'form-control',
                                'placeholder' => 'Kode / booking...',
                                'value' => $this->request->getQuery('key')
                            ]) ?>
                        </div>

                        <div class="col-md-5 m-b-10">
                            <?= $this->Form->text('key_label', [
                                'class' => 'form-control',
                                'placeholder' => 'Nama pasien / poli / no HP / BPJS...',
                                'value' => $this->request->getQuery('key'),
                                'oninput' => 'document.getElementById("key").value = this.value;'
                            ]) ?>
                        </div>

                        <div class="col-md-1">
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?= $this->Form->end() ?>

            <?= $this->element('polyclinic_queue_index_table', [
                'title' => 'Antrian Pagi',
                'queues' => $morningQueues,
                'emptyMessage' => 'Data antrian pagi tidak ditemukan',
                'buildWhatsAppLink' => $buildWhatsAppLink,
                'isMobileJknQueue' => $isMobileJknQueue,
                'isReferralQueue' => $isReferralQueue,
                'canRegisterQueue' => $canRegisterQueue,
            ]) ?>

            <?= $this->element('polyclinic_queue_index_table', [
                'title' => 'Antrian Sore',
                'queues' => $afternoonQueues,
                'emptyMessage' => 'Data antrian sore tidak ditemukan',
                'buildWhatsAppLink' => $buildWhatsAppLink,
                'isMobileJknQueue' => $isMobileJknQueue,
                'isReferralQueue' => $isReferralQueue,
                'canRegisterQueue' => $canRegisterQueue,
            ]) ?>

            <?php foreach ($allQueues as $queue): ?>
                <?= $this->element('polyclinic_queue_index_modal', [
                    'queue' => $queue,
                    'isMobileJknQueue' => $isMobileJknQueue,
                    'isReferralQueue' => $isReferralQueue,
                ]) ?>
            <?php endforeach; ?>

            <div class="row queue-pagination">
                <div class="col-md-6">
                    <p>
                        <?= $this->Paginator->counter('Menampilkan {{current}} data dari {{count}} total data') ?>
                    </p>
                </div>

                <div class="col-md-6 text-right">
                    <ul class="pagination pagination-sm m-t-0 m-b-0 pull-right">
                        <?= $this->Paginator->first('<<') ?>
                        <?= $this->Paginator->prev('<') ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next('>') ?>
                        <?= $this->Paginator->last('>>') ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
