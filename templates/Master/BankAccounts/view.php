<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankAccount $bankAccount
 */
$isView = ($bankAccount->is_view=='Y') ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>";
$isActive = ($bankAccount->is_active=='Y') ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>";
?>
<?php
ini_set('precision', 14);
?>


<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data Akun Bank</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Nama Bank</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankAccount->bank_name ?></div>
                <div class="col-2 col-sm-2">
                    <h6>Nama Rekening</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankAccount->account_holder ?></div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>No. Rekening</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankAccount->account_number ?></div>
                <div class="col-2 col-sm-2">
                    <h6>Aktif</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $isActive ?></div>
                <!-- <div class="col-2 col-sm-2">
                    <h6>Saldo Awal</h6>
                </div>
                <div class="col-4 col-sm-4">
                    : <?= $bankAccount->opening_balance > 0 ? $this->Krs->nom($bankAccount->opening_balance) : '-' ?>
                </div> -->
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Deskripsi</h6>
                </div>
                <div class="col-4 col-sm-4">:</div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12"><?= $bankAccount->description ?> </div>
            </div>
        </div>
    </div>
</div>