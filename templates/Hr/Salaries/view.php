<?php
ini_set('precision', 14);
$total = (float)$salary->gaji_pokok
       + (float)$salary->tunjangan_harian
       + (float)$salary->tunjangan_jabatan
       + (float)$salary->tunjangan_makan
       + (float)$salary->tunjangan_produktifitas
       + (float)$salary->tunjangan_struktural;
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Rincian penghasilan : <?php echo $salary->hrga_employee->name ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        
        <div class="modal-body">
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Gaji Pokok</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->gaji_pokok) ?>
                </div>
                <div class="col-2 col-sm-2">
                    <h6>Tunjangan Harian</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->tunjangan_harian) ?>
                </div>               
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">    
                    <h6>Tunjangan Jabatan</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->tunjangan_jabatan) ?>
                </div>
                <div class="col-2 col-sm-2">
                    <h6>Tunjangan Makan</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->tunjangan_makan) ?>
                </div>           
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">    
                    <h6>Tunjangan Produktifitas</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->tunjangan_produktifitas) ?>
                </div>
                <div class="col-2 col-sm-2">
                    <h6>Tunjangan Struktural</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->tunjangan_struktural) ?>
                </div>           
            </div>
            <hr>
            <div class="row">
                <div class="col-2 col-sm-2">    
                    <h4><strong>Total Gaji</strong></h4>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($total) ?>
                </div>
                <!-- <div class="col-2 col-sm-2">    
                    <h6>BPJS Kesehatan</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->bpjs_kesehatan) ?>
                </div> -->
                <!-- <div class="col-2 col-sm-2">
                    <h6>BPJS Ketenagakerjaan</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->bpjs_ketenagakerjaan) ?>
                </div>           
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">    
                    <h6>BPJS Pensiun</h6>
                </div>
                <div class="col-4 col-sm-4">: 
                    <?= $this->Krs->nom($salary->bpjs_pensiun) ?>
                </div> -->

            </div>
        </div>
    </div>
</div>