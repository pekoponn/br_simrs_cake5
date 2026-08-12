<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankIncome $bankIncome
 */
?>
<?php
ini_set('precision', 14);
?>


<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data Dana Masuk</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Nama Bank</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankIncome->payment_type ?></div>
                <!-- <div class="col-2 col-sm-2">
                    <h6>UBS</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankIncome->ubs ?? '-' ?></div> -->
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Tanggal Transaksi</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankIncome->created->format('d-m-Y') ?></div>
                <div class="col-2 col-sm-2">
                    <h6>COA Dana Masuk</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankIncome->acc_chart_of_account->code. ' - ' . $bankIncome->acc_chart_of_account->name ?></div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Nominal</h6>
                </div>
                <div class="col-4 col-sm-4">
                    : Rp. <?= $bankIncome->nominal > 0 ? $this->Krs->nom($bankIncome->nominal) : '-' ?>
                </div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Deskripsi</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankIncome->description ?> </div>
                <!-- <div class="col-2 col-sm-2">
                    <h6>Aktif</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $isActive ?></div> -->
            </div>
        </div>
    </div>
</div>