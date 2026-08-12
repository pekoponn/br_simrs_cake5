<?php
ini_set('precision', 14);?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                Data Cabang : <?= h($branch->name) ?>
            </h4>
            <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-hidden="true">
                ×
            </button>
        </div>
        <div class="modal-body">
            <div class="row m-b-15">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <h6>Kode</h6>
                        </div>
                        <div class="col-4 col-sm-4">
                            : <span><?= h($branch->code) ?></span>
                        </div>
                        <div class="col-2 col-sm-2">
                            <h6>Nama Cabang</h6>
                        </div>
                        <div class="col-4 col-sm-4">
                            : <span><?= h($branch->name) ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <h6>Perusahaan</h6>
                        </div>
                        <div class="col-4 col-sm-4">
                            : <span><?= h($branch->company_name) ?></span>
                        </div>
                        <div class="col-2 col-sm-2">
                            <h6>Email</h6>
                        </div>
                        <div class="col-4 col-sm-4">
                            : <span><?= h($branch->email) ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <h6>Telepon</h6>
                        </div>
                        <div class="col-4 col-sm-4">
                            : <span><?= h($branch->company_telp) ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2 col-sm-2">
                            <h6>Alamat</h6>
                        </div>
                        <div class="col-10 col-sm-10">
                            : <span><?= h($branch->company_address) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>