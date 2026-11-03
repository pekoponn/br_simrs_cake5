param([string[]]$Only)

$modules = [ordered]@{
  'RawatJalan' = 'OutpatientVisits','OutpatientVisitEmr','OutpatientActions','OutpatientCpptNotes','OutpatientLetters'
  'RekamMedis' = 'MedicalRecords','MedicalRecordDiagnoses','MedicalRecordInpatients','MedicalRecordOutpatientIgds','MedicalResumes','NursingAssessments','PatientHistories'
  'Igd'        = 'EmergencyEntries','TriageEntries'
  'Kasir'      = 'OutpatientBillings','OutpatientBillingItems','OutpatientBillingPayments','PaymentHistories'
  'Farmasi'    = 'Orders','OrderPrescriptions','OrderPembelians','RencanaPembelians','ReturPembelians','Invoices','InvoiceDetails','MedicineStocks','KartuStok','Medicines','MedicineGroups','MedicineMerks'
  'Penunjang'  = 'OrderLaboratories','OrderRadiologies','OrderMcus','OrdersMcus','OrderSupports','OrderSurgeries','OrderStatuses','LabRoResults'
  'Master'     = 'Doctors','DoctorSchedules','HealthFacilities','Insurances','Rooms','Beds','BedHistories','PharmacyItems','NutritionCombine','NutritionMenus','Customers','MasterIcd9','MasterIcd10','MasterLaboratories','MasterMcuTypes','MasterOperationTypes','MasterPatientReferrers','MasterPenjamins','MasterRadiologies','MasterSupports','MasterSurgeryOperators','MasterTenagaMedis','MasterTindakan','MasterTreatmentPackages','DaerahJenis','DaerahKabupatens','DaerahKecamatans','DaerahKelurahans','DaerahProvinsis'
  'Pengaturan' = 'Branches','Settings'
  'Registrasi' = 'PersonResponsibles'
}

$utf8 = New-Object System.Text.UTF8Encoding $false

foreach ($m in $modules.GetEnumerator()) {
  if ($Only -and $Only -notcontains $m.Key) { continue }
  $ctrlDir = "src\Controller\$($m.Key)"
  New-Item -ItemType Directory -Force $ctrlDir | Out-Null
  New-Item -ItemType Directory -Force "templates\$($m.Key)" | Out-Null

  foreach ($c in $m.Value) {
    $src = "src\Controller\${c}Controller.php"
    $dst = "$ctrlDir\${c}Controller.php"
    if (Test-Path $src) {
      git mv $src $dst
      $path = (Resolve-Path $dst).Path
      $t = [System.IO.File]::ReadAllText($path)
      $new = "namespace App\Controller\$($m.Key);`n`nuse App\Controller\AppController;"
      $t = $t.Replace('namespace App\Controller;', $new)
      [System.IO.File]::WriteAllText($path, $t, $utf8)
      Write-Host "OK controller: $c -> $($m.Key)"
    }
    if (Test-Path "templates\$c") {
      git mv "templates\$c" "templates\$($m.Key)\$c"
      Write-Host "OK template:   $c"
    }
  }
}