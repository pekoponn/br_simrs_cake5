// INI ACTIVITY REVO //

ALTER TABLE registrations
ADD insurance_category VARCHAR(100) NULL AFTER insurance_type,
ADD skdp_no VARCHAR(50) NULL AFTER refferal_no,
ADD reference_type VARCHAR(50) NULL AFTER sep_no,
ADD bpjs_nik VARCHAR(30) NULL AFTER reference_type,
ADD bpjs_name VARCHAR(255) NULL AFTER bpjs_nik,
ADD bpjs_group VARCHAR(100) NULL AFTER bpjs_name,
ADD bpjs_type VARCHAR(100) NULL AFTER bpjs_group,
ADD bpjs_class VARCHAR(50) NULL AFTER bpjs_type,
ADD provider VARCHAR(255) NULL AFTER bpjs_class;
ADD admission_time TIME NULL AFTER registration_date;
ADD doctor_schedule_id INT NULL AFTER doctor_id,
ADD polyclinic_queue_id INT NULL AFTER doctor_schedule_id,
ADD queue_number VARCHAR(50) NULL AFTER polyclinic_queue_id;

ALTER TABLE `registrations`
	CHANGE COLUMN `class_name` `class_name` VARCHAR(255) NULL DEFAULT NULL COMMENT 'nama kelas' COLLATE 'utf8mb4_0900_ai_ci' AFTER `bed_id`;

CREATE TABLE `person_responsibles` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`registration_id` INT NOT NULL DEFAULT '0' COMMENT 'fk ke registration',
	`name` VARCHAR(255) NOT NULL COMMENT 'nama' COLLATE 'utf8mb4_0900_ai_ci',
	`identity_type` VARCHAR(255) NOT NULL COMMENT 'jenis identitas' COLLATE 'utf8mb4_0900_ai_ci',
	`identity_no` VARCHAR(255) NOT NULL COMMENT 'no identitas' COLLATE 'utf8mb4_0900_ai_ci',
	`relation` VARCHAR(50) NOT NULL COMMENT 'hubungan' COLLATE 'utf8mb4_0900_ai_ci',
	`age` INT NOT NULL COMMENT 'umur',
	`job` VARCHAR(100) NOT NULL COMMENT 'pekerjaan' COLLATE 'utf8mb4_0900_ai_ci',
	`address` TEXT NOT NULL COMMENT 'alamat' COLLATE 'utf8mb4_0900_ai_ci',
	`phone` VARCHAR(20) NOT NULL COMMENT 'nomor telepon' COLLATE 'utf8mb4_0900_ai_ci',
	`is_create` INT NOT NULL DEFAULT '0',
	`created` DATETIME NULL DEFAULT NULL,
	`is_update` INT NOT NULL DEFAULT '0',
	`modified` DATETIME NULL DEFAULT NULL,
	`is_delete` INT NOT NULL DEFAULT '0',
	`deleted` DATETIME NULL DEFAULT NULL,
	`delete_log` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`is_active` ENUM('Y','N') NOT NULL DEFAULT 'Y' COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COMMENT='penanggung jawab pasien'
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=MyISAM
AUTO_INCREMENT=14
;

ALTER TABLE registrations
MODIFY room_id INT NULL,
MODIFY bed_id INT NULL;

ALTER TABLE `registrations`
  ADD COLUMN `referral_type`   VARCHAR(20)  NULL DEFAULT NULL COMMENT 'Intern/Extern/None' AFTER `treatment_type`,
  ADD COLUMN `referral_doctor` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Dokter pengirim'    AFTER `referral_type`,
  ADD COLUMN `referral_origin` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Asal rujuk'         AFTER `referral_doctor`,
  ADD COLUMN `referral_name`   VARCHAR(255) NULL DEFAULT NULL COMMENT 'Nama perujuk'       AFTER `referral_origin`;

  ALTER TABLE `polyclinic_queues`
    ADD COLUMN `status`    VARCHAR(20)  NOT NULL DEFAULT 'waiting'
        COMMENT 'waiting | called | examining | done'
        AFTER `is_active`,
    ADD COLUMN `called_at` DATETIME     NULL DEFAULT NULL
        COMMENT 'Waktu pasien dipanggil'
        AFTER `status`,
    ADD COLUMN `done_at`   DATETIME     NULL DEFAULT NULL
        COMMENT 'Waktu selesai diperiksa'
        AFTER `called_at`;

		ALTER TABLE `beds` 
    MODIFY COLUMN `status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=Tersedia, 1=Terisi, 2=Dibersihkan, 3=Maintenance',
    ADD COLUMN `check_in_date` DATE NULL COMMENT 'Tanggal masuk pasien',
    ADD COLUMN `check_out_date` DATE NULL COMMENT 'Tanggal keluar pasien',
    ADD COLUMN `patient_name` VARCHAR(255) NULL COMMENT 'Nama pasien sementara';

-- Tabel riwayat pindah kamar
CREATE TABLE `bed_histories` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `bed_id` INT(11) NOT NULL,
    `room_id` INT(11) NOT NULL,
    `patient_name` VARCHAR(255) NULL,
    `registration_no` VARCHAR(100) NULL,
    `check_in_date` DATE NULL,
    `check_out_date` DATE NULL,
    `status_before` TINYINT(1) NULL,
    `status_after` TINYINT(1) NULL,
    `notes` TEXT NULL,
    `created_by` VARCHAR(100) NULL,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `bed_id` (`bed_id`),
    KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ngubah status bed agar bisa 4 value (tersedia,terisi,dibesikan,Maintenance)
ALTER TABLE beds MODIFY COLUMN status TINYINT(4) NOT NULL DEFAULT 0;

-- Jalankan query ini di HeidiSQL / phpMyAdmin / MySQL CLI
-- untuk menambah kolom notes ke tabel beds

ALTER TABLE `beds`
    ADD COLUMN `notes` TEXT NULL DEFAULT NULL COMMENT 'Catatan perubahan status'
    AFTER `patient_name`;

ALTER TABLE `beds`
    ADD COLUMN `patient_id` INT NULL DEFAULT NULL COMMENT 'FK ke tabel patients' AFTER `patient_name`,
    ADD COLUMN `notes_patient` TEXT NULL DEFAULT NULL COMMENT 'Catatan perubahan status' AFTER `patient_id`,
    MODIFY COLUMN `check_in_date` DATETIME NULL DEFAULT NULL COMMENT 'Tanggal & jam masuk (auto)',
    MODIFY COLUMN `check_out_date` DATETIME NULL DEFAULT NULL COMMENT 'Tanggal & jam keluar (auto)';
ALTER TABLE patients
ADD title VARCHAR(20) NULL AFTER `code`;

ALTER TABLE polyclinic_queues
ADD COLUMN booking_code VARCHAR(100) NULL DEFAULT NULL COMMENT 'Kode booking simulasi Mobile JKN' AFTER source,
ADD COLUMN bpjs_number VARCHAR(50) NULL DEFAULT NULL COMMENT 'No kartu BPJS simulasi Mobile JKN' AFTER booking_code,
ADD COLUMN identity_number VARCHAR(50) NULL DEFAULT NULL COMMENT 'NIK pasien simulasi Mobile JKN' AFTER bpjs_number,
ADD COLUMN visit_date DATE NULL DEFAULT NULL COMMENT 'Tanggal periksa simulasi Mobile JKN' AFTER identity_number,
ADD COLUMN checkin_status VARCHAR(50) NULL DEFAULT 'Belum Check-in' COMMENT 'Status check-in Mobile JKN' AFTER visit_date,
ADD COLUMN checkin_time DATETIME NULL DEFAULT NULL COMMENT 'Waktu check-in Mobile JKN' AFTER checkin_status;


ALTER TABLE polyclinic_queues
ADD COLUMN call_status VARCHAR(50) NULL DEFAULT 'Menunggu' COMMENT 'Status panggilan antrian' AFTER checkin_time,
ADD COLUMN called_time DATETIME NULL DEFAULT NULL COMMENT 'Waktu terakhir nomor dipanggil' AFTER call_status,
ADD COLUMN call_count INT NOT NULL DEFAULT 0 COMMENT 'Jumlah nomor dipanggil ulang' AFTER called_time;

CREATE INDEX idx_polyclinic_queues_call_status ON polyclinic_queues (call_status);
CREATE INDEX idx_polyclinic_queues_called_time ON polyclinic_queues (called_time);

CREATE TABLE `medical_records` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`registration_id` INT NOT NULL,
	`status` VARCHAR(50) NULL DEFAULT 'Draft' COLLATE 'utf8mb4_0900_ai_ci',
	`is_create` INT NOT NULL DEFAULT '0',
	`created` DATETIME NULL DEFAULT NULL,
	`is_update` INT NOT NULL DEFAULT '0',
	`modified` DATETIME NULL DEFAULT NULL,
	`is_delete` INT NOT NULL DEFAULT '0',
	`deleted` DATETIME NULL DEFAULT NULL,
	`delete_log` TEXT NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`is_active` ENUM('Y','N') NOT NULL DEFAULT 'Y' COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `idx_medical_records_registration_id` (`registration_id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;


CREATE TABLE medical_record_prescriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
);


CREATE TABLE medical_record_laboratories (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
);

CREATE TABLE medical_record_radiologies (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
);

CREATE TABLE medical_record_examinations (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',

    note TEXT NULL DEFAULT NULL,

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,

    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE medical_record_surgeries (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',
    note TEXT NULL DEFAULT NULL,

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE medical_record_integrations (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',
    note TEXT NULL DEFAULT NULL,

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE medical_record_icares (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',
    note TEXT NULL DEFAULT NULL,

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE medical_record_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    document_name VARCHAR(255) NULL,
    file_name VARCHAR(255) NULL,
    file_path TEXT NULL,
    file_type VARCHAR(100) NULL,

    note TEXT NULL DEFAULT NULL,

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE medical_record_referrals (
    id INT AUTO_INCREMENT PRIMARY KEY,

    medical_record_id INT NOT NULL,

    referral_no VARCHAR(100) NULL,
    referral_type VARCHAR(100) NULL,

    note TEXT NULL DEFAULT NULL,

    status VARCHAR(50) NULL DEFAULT 'Draft',

    is_create INT NOT NULL DEFAULT 0,
    created DATETIME NULL DEFAULT NULL,

    is_update INT NOT NULL DEFAULT 0,
    modified DATETIME NULL DEFAULT NULL,

    is_delete INT NOT NULL DEFAULT 0,
    deleted DATETIME NULL DEFAULT NULL,

    delete_log TEXT NULL DEFAULT NULL,
    is_active ENUM('Y','N') NOT NULL DEFAULT 'Y',

    INDEX idx_medical_record_id (medical_record_id)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `patients`
    ADD COLUMN `medical_record_no` VARCHAR(50) NULL AFTER `code`;

ALTER TABLE `rooms`
    ADD COLUMN `tarif_hari`      DECIMAL(15,2) NOT NULL DEFAULT 0.00
        COMMENT 'Tarif per hari (Rp)' AFTER `capacity`,
    ADD COLUMN `tarif_plus_hari` DECIMAL(15,2) NOT NULL DEFAULT 0.00
        COMMENT 'Tarif tambahan per hari (Rp)' AFTER `tarif_hari`;

ALTER TABLE `beds`
    -- Tanggal rencana keluar pasien (diisi saat status → Terisi)
    ADD COLUMN `planned_check_out_date` DATE NULL DEFAULT NULL
        COMMENT 'Rencana tanggal keluar pasien'
        AFTER `check_out_date`,

    -- Jenis penjamin: BPJS / Umum / Asuransi / dll
    ADD COLUMN `payer_type` VARCHAR(30) NULL DEFAULT NULL
        COMMENT 'Jenis penjamin: BPJS, Umum, Asuransi'
        AFTER `planned_check_out_date`,

    -- Batas hari tanggungan BPJS (default 3 hari, bisa diubah per pasien)
    ADD COLUMN `bpjs_limit_days` TINYINT UNSIGNED NULL DEFAULT NULL
        COMMENT 'Batas hari tanggungan BPJS (hari)'
        AFTER `payer_type`;

ALTER TABLE `outpatient_visits`
    ADD COLUMN `queue_id` INT UNSIGNED NULL DEFAULT NULL
        COMMENT 'FK ke polyclinic_queues jika kunjungan berasal dari antrian'
        AFTER `doctor_id`;

UPDATE `outpatient_visits` ov
INNER JOIN `registrations` r ON r.`id` = ov.`registration_id`
SET ov.`queue_id` = r.`polyclinic_queue_id`
WHERE ov.`queue_id` IS NULL
  AND r.`polyclinic_queue_id` IS NOT NULL;

ALTER TABLE `outpatient_visits`
    ADD UNIQUE KEY `uq_outpatient_visits_registration_id` (`registration_id`),
    ADD KEY `idx_outpatient_visits_queue_id` (`queue_id`),
    ADD KEY `idx_outpatient_visits_patient_visit` (`patient_id`, `visit_date`);

ALTER TABLE `medical_records`
    ADD COLUMN `outpatient_visit_id` INT UNSIGNED NULL DEFAULT NULL
        COMMENT 'FK ke outpatient_visits sebagai kunjungan rawat jalan'
        AFTER `registration_id`;

UPDATE `medical_records` mr
INNER JOIN `outpatient_visits` ov ON ov.`registration_id` = mr.`registration_id`
SET mr.`outpatient_visit_id` = ov.`id`
WHERE mr.`outpatient_visit_id` IS NULL;

ALTER TABLE `medical_records`
    ADD KEY `idx_medical_records_outpatient_visit_id` (`outpatient_visit_id`);

ALTER TABLE `medical_record_prescriptions`
    ADD COLUMN IF NOT EXISTS `note` TEXT NULL AFTER `status`;

ALTER TABLE `medical_record_laboratories`
    ADD COLUMN IF NOT EXISTS `note` TEXT NULL AFTER `status`;

ALTER TABLE `medical_record_radiologies`
    ADD COLUMN IF NOT EXISTS `note` TEXT NULL AFTER `status`;

ALTER TABLE `medical_record_examinations`
    ADD COLUMN IF NOT EXISTS `payload_json` LONGTEXT NULL AFTER `note`;

ALTER TABLE `outpatient_visits`
    ADD COLUMN `queue_id` INT UNSIGNED NULL DEFAULT NULL
        COMMENT 'FK ke polyclinic_queues jika kunjungan berasal dari antrian'
        AFTER `doctor_id`;

UPDATE `outpatient_visits` ov
INNER JOIN `registrations` r ON r.`id` = ov.`registration_id`
SET ov.`queue_id` = r.`polyclinic_queue_id`
WHERE ov.`queue_id` IS NULL
  AND r.`polyclinic_queue_id` IS NOT NULL;

ALTER TABLE `outpatient_visits`
    ADD UNIQUE KEY `uq_outpatient_visits_registration_id` (`registration_id`),
    ADD KEY `idx_outpatient_visits_queue_id` (`queue_id`),
    ADD KEY `idx_outpatient_visits_patient_visit` (`patient_id`, `visit_date`);

ALTER TABLE `medical_records`
    ADD COLUMN `outpatient_visit_id` INT UNSIGNED NULL DEFAULT NULL
        COMMENT 'FK ke outpatient_visits sebagai kunjungan rawat jalan'
        AFTER `registration_id`;

UPDATE `medical_records` mr
INNER JOIN `outpatient_visits` ov ON ov.`registration_id` = mr.`registration_id`
SET mr.`outpatient_visit_id` = ov.`id`
WHERE mr.`outpatient_visit_id` IS NULL;

ALTER TABLE `medical_records`
    ADD KEY `idx_medical_records_outpatient_visit_id` (`outpatient_visit_id`);

ALTER TABLE `medical_record_integrations`
    ADD COLUMN IF NOT EXISTS `noted_at` DATETIME NULL AFTER `medical_record_id`,
    ADD COLUMN IF NOT EXISTS `user_id` INT NULL AFTER `noted_at`,
    ADD COLUMN IF NOT EXISTS `health_worker_name` VARCHAR(255) NULL AFTER `user_id`,
    ADD COLUMN IF NOT EXISTS `profession` VARCHAR(100) NULL AFTER `health_worker_name`,
    ADD COLUMN IF NOT EXISTS `doctor_id` INT NULL AFTER `profession`,
    ADD COLUMN IF NOT EXISTS `doctor_name` VARCHAR(255) NULL AFTER `doctor_id`,
    ADD COLUMN IF NOT EXISTS `soap_sbar` TEXT NULL AFTER `doctor_name`,
    ADD COLUMN IF NOT EXISTS `instruction` TEXT NULL AFTER `soap_sbar`,
    ADD COLUMN IF NOT EXISTS `payload_json` LONGTEXT NULL AFTER `note`;

ALTER TABLE `orders`
    ADD COLUMN `laboratory_note` TEXT NULL AFTER `catatan`;

ALTER TABLE `master_tindakan`
    MODIFY COLUMN `kategori`
        ENUM('Konsultasi', 'Tindakan Medis', 'Administrasi', 'Laboratorium')
        NOT NULL DEFAULT 'Tindakan Medis';

CREATE TABLE IF NOT EXISTS `order_laboratories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT NOT NULL,
    `master_tindakan_id` INT UNSIGNED NULL DEFAULT NULL,
    `code` VARCHAR(50) NULL DEFAULT NULL,
    `examination_name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `approval_note` VARCHAR(255) NULL DEFAULT NULL,
    `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_order_laboratories_order_id` (`order_id`),
    KEY `idx_order_laboratories_master_tindakan_id` (`master_tindakan_id`),
    CONSTRAINT `fk_order_laboratories_order`
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_order_laboratories_master_tindakan`
        FOREIGN KEY (`master_tindakan_id`) REFERENCES `master_tindakan` (`id`)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `orders`
    ADD COLUMN `radiology_note` TEXT NULL AFTER `laboratory_note`;

ALTER TABLE `master_tindakan`
    MODIFY COLUMN `kategori`
        ENUM('Konsultasi', 'Tindakan Medis', 'Administrasi', 'Laboratorium', 'Radiologi')
        NOT NULL DEFAULT 'Tindakan Medis';

CREATE TABLE IF NOT EXISTS `order_radiologies` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id` INT NOT NULL,
    `master_tindakan_id` INT UNSIGNED NULL DEFAULT NULL,
    `code` VARCHAR(50) NULL DEFAULT NULL,
    `examination_name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(14,2) NOT NULL DEFAULT 0,
    `approval_note` VARCHAR(255) NULL DEFAULT NULL,
    `created` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_order_radiologies_order_id` (`order_id`),
    KEY `idx_order_radiologies_master_tindakan_id` (`master_tindakan_id`),
    CONSTRAINT `fk_order_radiologies_order`
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT `fk_order_radiologies_master_tindakan`
        FOREIGN KEY (`master_tindakan_id`) REFERENCES `master_tindakan` (`id`)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `master_icd10` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`kode` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`nama` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`is_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
	`created` DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP),
	`modified` DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP) ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `uq_kode` (`kode`) USING BTREE,
	FULLTEXT INDEX `ft_nama` (`nama`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=18544
;

CREATE TABLE `master_icd9` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`kode` VARCHAR(10) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`nama` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`is_active` TINYINT UNSIGNED NOT NULL DEFAULT '1',
	`created` DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP),
	`modified` DATETIME NOT NULL DEFAULT (CURRENT_TIMESTAMP) ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `uq_kode` (`kode`) USING BTREE,
	FULLTEXT INDEX `ft_nama` (`nama`)
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4627
;

alter table `orders`
add column `pesan` text null after `lokasi_depo`;

ALTER TABLE medicines
ADD COLUMN gol VARCHAR(255) NULL AFTER code_ifrs,
ADD COLUMN therapy_class VARCHAR(255) NULL AFTER gol,
ADD COLUMN golongan VARCHAR(255) NULL AFTER therapy_class,
ADD COLUMN pabrik VARCHAR(255) NULL AFTER golongan,
ADD COLUMN sediaan VARCHAR(255) NULL AFTER pabrik,
ADD COLUMN supplier VARCHAR(255) NULL AFTER sediaan,
ADD COLUMN lead_time INT NULL DEFAULT 0 AFTER supplier,
ADD COLUMN depkes_link VARCHAR(100) NULL AFTER lead_time,
ADD COLUMN ppn_status ENUM('Y','N') NOT NULL DEFAULT 'Y' AFTER hna,
ADD COLUMN jenis_harga ENUM('PROSENTASE','MANUAL') NOT NULL DEFAULT 'PROSENTASE' AFTER hna_ppn;

CREATE TABLE `inpatient_entries` (
  `id` INT NOT NULL AUTO_INCREMENT,

  `registration_id` INT NULL,
  `registration_no` VARCHAR(50) NULL,

  `patient_id` INT NULL,
  `patient_name` VARCHAR(255) NULL,
  `patient_rm` VARCHAR(50) NULL,

  `doctor_id` INT NULL,
  `doctor_name` VARCHAR(255) NULL,

  `room_id` INT NULL,
  `room_name` VARCHAR(100) NULL,

  `bed_id` INT NULL,
  `bed_no` VARCHAR(50) NULL,

  `check_in_date` DATETIME NULL,
  `planned_discharge_date` DATE NULL,
  `check_out_date` DATETIME NULL,

  `notes` TEXT NULL,

  `status` VARCHAR(30) NOT NULL DEFAULT 'dirawat',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,

  `created` DATETIME NULL,
  `modified` DATETIME NULL,

  PRIMARY KEY (`id`),
  KEY `idx_inpatient_registration_id` (`registration_id`),
  KEY `idx_inpatient_patient_id` (`patient_id`),
  KEY `idx_inpatient_doctor_id` (`doctor_id`),
  KEY `idx_inpatient_room_id` (`room_id`),
  KEY `idx_inpatient_bed_id` (`bed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `emergency_entries` (
  `id` INT NOT NULL AUTO_INCREMENT,

  `registration_id` INT NULL,
  `registration_no` VARCHAR(50) NULL,

  `patient_id` INT NULL,
  `patient_rm` VARCHAR(50) NULL,
  `patient_name` VARCHAR(255) NULL,

  `doctor_id` INT NULL,
  `doctor_name` VARCHAR(255) NULL,

  `service_date` DATE NULL,
  `service_time` TIME NULL,

  `chief_complaint` TEXT NULL,
  `triage_category` VARCHAR(50) NULL,
  `triage_notes` TEXT NULL,

  `blood_pressure` VARCHAR(50) NULL,
  `temperature` VARCHAR(50) NULL,
  `pulse` VARCHAR(50) NULL,
  `respiration` VARCHAR(50) NULL,
  `spo2` VARCHAR(50) NULL,

  `diagnosis` TEXT NULL,
  `notes` TEXT NULL,

  `status` VARCHAR(30) NOT NULL DEFAULT 'waiting',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,

  `created` DATETIME NULL,
  `modified` DATETIME NULL,

  PRIMARY KEY (`id`),
  KEY `idx_emergency_registration_id` (`registration_id`),
  KEY `idx_emergency_patient_id` (`patient_id`),
  KEY `idx_emergency_doctor_id` (`doctor_id`),
  KEY `idx_emergency_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `outpatient_billings` (
    `id`                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `billing_no`            VARCHAR(30)     NOT NULL COMMENT 'Nomor tagihan, contoh: BILL-20260613-00001',
    `outpatient_visit_id`   INT UNSIGNED    NOT NULL,
    `registration_id`       INT UNSIGNED    NULL,
    `patient_id`            INT UNSIGNED    NOT NULL,
    `doctor_id`             INT UNSIGNED    NULL,

    -- Info kunjungan
    `visit_date`            DATE            NOT NULL,
    `polyclinic_name`       VARCHAR(100)    NULL,
    `insurance_type`        VARCHAR(50)     NULL DEFAULT 'Umum' COMMENT 'Umum, BPJS, Asuransi, dll',
    `insurance_no`          VARCHAR(50)     NULL COMMENT 'No kartu BPJS / asuransi',

    -- Status billing
    `status`                ENUM('draft','waiting_payment','paid','cancelled','void')
                            NOT NULL DEFAULT 'draft',

    -- Rincian biaya
    `total_action`          DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Total biaya tindakan',
    `total_medicine`        DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Total biaya obat/resep',
    `total_lab`             DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Total biaya laboratorium',
    `total_radiology`       DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Total biaya radiologi',
    `total_other`           DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Biaya lain-lain',
    `subtotal`              DECIMAL(15,2)   NOT NULL DEFAULT 0,

    -- Diskon & pembayaran
    `discount_type`         ENUM('nominal','percent') NULL DEFAULT 'nominal',
    `discount_value`        DECIMAL(15,2)   NOT NULL DEFAULT 0,
    `discount_amount`       DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Hasil kalkulasi diskon',
    `grand_total`           DECIMAL(15,2)   NOT NULL DEFAULT 0,

    -- Pembayaran
    `payment_method`        ENUM('tunai','transfer','bpjs','asuransi','piutang','lainnya')
                            NULL DEFAULT 'tunai',
    `paid_amount`           DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Jumlah yang dibayarkan',
    `change_amount`         DECIMAL(15,2)   NOT NULL DEFAULT 0 COMMENT 'Kembalian',
    `paid_at`               DATETIME        NULL,
    `cashier_id`            INT UNSIGNED    NULL COMMENT 'User kasir yang memproses',
    `cashier_name`          VARCHAR(100)    NULL,

    -- Rujukan / Rawat Inap
    `is_referred`           TINYINT(1)      NOT NULL DEFAULT 0,
    `referred_to`           VARCHAR(100)    NULL,
    `is_inpatient`          TINYINT(1)      NOT NULL DEFAULT 0,
    `inpatient_referral_no` VARCHAR(50)     NULL,

    -- Catatan
    `notes`                 TEXT            NULL,
    `void_reason`           VARCHAR(255)    NULL,
    `voided_at`             DATETIME        NULL,
    `voided_by`             INT UNSIGNED    NULL,

    -- Audit
    `is_create`             TINYINT(1)      DEFAULT 1,
    `is_update`             TINYINT(1)      DEFAULT 0,
    `is_delete`             TINYINT(1)      DEFAULT 0,
    `is_active`             CHAR(1)         DEFAULT 'Y',
    `created`               DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified`              DATETIME        NULL ON UPDATE CURRENT_TIMESTAMP,
    `created_by`            INT UNSIGNED    NULL,
    `modified_by`           INT UNSIGNED    NULL,

    INDEX `idx_visit`       (`outpatient_visit_id`),
    INDEX `idx_patient`     (`patient_id`),
    INDEX `idx_billing_no`  (`billing_no`),
    INDEX `idx_status`      (`status`),
    INDEX `idx_visit_date`  (`visit_date`),
    UNIQUE KEY `uq_billing_no` (`billing_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Tagihan rawat jalan per kunjungan';

CREATE TABLE `outpatient_billing_items` (
    `id`                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `billing_id`        INT UNSIGNED    NOT NULL,
    `item_type`         ENUM('tindakan','obat','laboratorium','radiologi','administrasi','lainnya')
                        NOT NULL DEFAULT 'tindakan',
    `item_code`         VARCHAR(50)     NULL,
    `item_name`         VARCHAR(255)    NOT NULL,
    `quantity`          DECIMAL(10,2)   NOT NULL DEFAULT 1,
    `unit`              VARCHAR(20)     NULL DEFAULT 'kali',
    `unit_price`        DECIMAL(15,2)   NOT NULL DEFAULT 0,
    `total_price`       DECIMAL(15,2)   NOT NULL DEFAULT 0,
    `discount_amount`   DECIMAL(15,2)   NOT NULL DEFAULT 0,
    `final_price`       DECIMAL(15,2)   NOT NULL DEFAULT 0,
    `notes`             VARCHAR(255)    NULL,
    `is_covered`        TINYINT(1)      NOT NULL DEFAULT 0 COMMENT '1=ditanggung asuransi/BPJS',
    `sort_order`        INT             NOT NULL DEFAULT 0,

    `is_delete`         TINYINT(1)      DEFAULT 0,
    `created`           DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX `idx_billing` (`billing_id`),
    CONSTRAINT `fk_billing_items_billing`
        FOREIGN KEY (`billing_id`) REFERENCES `outpatient_billings`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Rincian item tagihan rawat jalan';


-- ============================================================
-- 3. Riwayat pembayaran (support cicilan / multi-payment)
-- ============================================================
CREATE TABLE `outpatient_billing_payments` (
    `id`                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `billing_id`        INT UNSIGNED    NOT NULL,
    `payment_no`        VARCHAR(30)     NOT NULL COMMENT 'Nomor transaksi pembayaran',
    `payment_method`    ENUM('tunai','transfer','bpjs','asuransi','debit','kredit','qris','lainnya')
                        NOT NULL DEFAULT 'tunai',
    `bank_name`         VARCHAR(50)     NULL COMMENT 'Nama bank jika transfer/debit/kredit',
    `account_no`        VARCHAR(50)     NULL COMMENT 'No rekening / no kartu (masked)',
    `amount`            DECIMAL(15,2)   NOT NULL DEFAULT 0,
    `verified`          TINYINT(1)      NOT NULL DEFAULT 0,
    `verified_at`       DATETIME        NULL,
    `verified_by`       INT UNSIGNED    NULL,
    `notes`             VARCHAR(255)    NULL,
    `created`           DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_by`        INT UNSIGNED    NULL,

    INDEX `idx_billing` (`billing_id`),
    UNIQUE KEY `uq_payment_no` (`payment_no`),
    CONSTRAINT `fk_billing_payments_billing`
        FOREIGN KEY (`billing_id`) REFERENCES `outpatient_billings`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Riwayat pembayaran tagihan rawat jalan';


-- ============================================================
-- 4. Tambah kolom di outpatient_visits untuk link ke billing
-- ============================================================
ALTER TABLE `outpatient_visits`
    ADD COLUMN `billing_id`     INT UNSIGNED NULL DEFAULT NULL
        COMMENT 'FK ke outpatient_billings.id'
        AFTER `status`,
    ADD COLUMN `billing_status` VARCHAR(30)  NULL DEFAULT NULL
        COMMENT 'Cache status billing: draft/waiting_payment/paid'
        AFTER `billing_id`,
    ADD INDEX `idx_billing_id` (`billing_id`);
    
    CREATE TABLE master_laboratories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(150) NOT NULL,
    tariff DECIMAL(15,2) DEFAULT 0,
    category VARCHAR(100) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);

CREATE TABLE order_laboratories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    registration_id INT NULL,
    patient_id INT NULL,
    doctor_id INT NULL,

    lab_code VARCHAR(50) NULL,
    lab_name VARCHAR(150) NOT NULL,
    tariff DECIMAL(15,2) DEFAULT 0,
    approval_note TEXT NULL,
    notes TEXT NULL,

    status VARCHAR(30) DEFAULT 'draft',
    is_active TINYINT(1) DEFAULT 1,
    is_delete TINYINT(1) DEFAULT 0,

    created DATETIME NULL,
    modified DATETIME NULL,

    INDEX idx_order_id (order_id),
    INDEX idx_registration_id (registration_id),
    INDEX idx_patient_id (patient_id),
    INDEX idx_doctor_id (doctor_id)
);

CREATE TABLE master_radiologies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(150) NOT NULL,
    tariff DECIMAL(15,2) DEFAULT 0,
    category VARCHAR(100) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);

CREATE TABLE order_radiologies (
    id INT AUTO_INCREMENT PRIMARY KEY,

    order_id INT NOT NULL,
    registration_id INT NULL,
    patient_id INT NULL,
    doctor_id INT NULL,

    master_radiology_id INT NULL,

    code VARCHAR(50) NULL,
    examination_name VARCHAR(150) NOT NULL,

    tariff DECIMAL(15,2) DEFAULT 0,
    qty INT DEFAULT 1,
    total DECIMAL(15,2) DEFAULT 0,

    approval_note TEXT NULL,
    notes TEXT NULL,

    status VARCHAR(30) DEFAULT 'draft',

    is_active TINYINT(1) DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);



CREATE TABLE master_penjamins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NULL,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(100) NULL,
  is_active CHAR(1) DEFAULT 'Y',
  created DATETIME NULL,
  modified DATETIME NULL
);

CREATE TABLE master_treatment_packages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NULL,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(15,2) DEFAULT 0,
  is_active CHAR(1) DEFAULT 'Y',
  created DATETIME NULL,
  modified DATETIME NULL
);

CREATE TABLE master_patient_referrers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NULL,
  name VARCHAR(255) NOT NULL,
  type VARCHAR(50) NULL,
  phone VARCHAR(50) NULL,
  address TEXT NULL,
  is_active CHAR(1) DEFAULT 'Y',
  created DATETIME NULL,
  modified DATETIME NULL
);

ALTER TABLE master_patient_referrers
DROP COLUMN phone,
DROP COLUMN type,
DROP COLUMN address;

ALTER TABLE master_patient_referrers
ADD COLUMN referral_origin VARCHAR(255) NULL AFTER name;

ALTER TABLE master_patient_referrers
ADD COLUMN doctor_sender VARCHAR(255) NULL AFTER referral_origin;

CREATE TABLE IF NOT EXISTS `outpatient_cppt_notes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `outpatient_visit_id` int unsigned NOT NULL,
  `registration_id` int unsigned DEFAULT NULL,
  `patient_id` int unsigned DEFAULT NULL,
  `doctor_id` int unsigned DEFAULT NULL,
  `noted_at` datetime DEFAULT NULL,
  `health_worker_name` varchar(100) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `nurse_name` varchar(100) DEFAULT NULL,
  `assessment_text` text,
  `instruction` text,
  `created_by` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_outpatient_visit_id` (`outpatient_visit_id`),
  KEY `idx_registration_id` (`registration_id`),
  KEY `idx_patient_id` (`patient_id`),
  KEY `idx_doctor_id` (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE medical_resumes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    outpatient_visit_id INT UNSIGNED NOT NULL,
    registration_id INT UNSIGNED NULL,
    patient_id INT UNSIGNED NULL,

    doctor1_id INT UNSIGNED NULL,
    doctor2_name VARCHAR(150) NULL,
    doctor3_name VARCHAR(150) NULL,
    doctor4_name VARCHAR(150) NULL,

    consultant1_name VARCHAR(150) NULL,
    consultant2_name VARCHAR(150) NULL,

    summary_history TEXT NULL,
    inpatient_indication TEXT NULL,
    physical_exam TEXT NULL,
    supporting_exam TEXT NULL,
    therapy_during_treatment TEXT NULL,
    consultation_result TEXT NULL,
    admission_diagnosis TEXT NULL,

    lab_unfinished TEXT NULL,
    diet TEXT NULL,
    education_instruction TEXT NULL,
    primary_diagnosis TEXT NULL,
    secondary_diagnosis TEXT NULL,
    medical_action TEXT NULL,

    condition_on_discharge VARCHAR(100) NULL,
    prognosis VARCHAR(100) NULL,
    follow_up_treatment VARCHAR(100) NULL,
    control_date DATE NULL,
    control_note TEXT NULL,
    control_plan TEXT NULL,
    return_reason TEXT NULL,

    print_classic TINYINT(1) NOT NULL DEFAULT 0,
    send_digital_claim TINYINT(1) NOT NULL DEFAULT 0,

    created DATETIME NULL,
    modified DATETIME NULL,

    INDEX idx_outpatient_visit_id (outpatient_visit_id),
    INDEX idx_registration_id (registration_id),
    INDEX idx_patient_id (patient_id)
);

ALTER TABLE outpatient_visits
    ADD COLUMN icd10_items TEXT NULL AFTER diagnosis_desc,
    ADD COLUMN icd9_items TEXT NULL AFTER icd10_items;

CREATE TABLE master_supports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(30) NOT NULL,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(100) NULL,
    tariff DECIMAL(12,2) NOT NULL DEFAULT 0,
    unit VARCHAR(50) NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);

CREATE TABLE order_supports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    registration_id INT NULL,
    patient_id INT NULL,
    doctor_id INT NULL,
    support_code VARCHAR(30) NULL,
    support_name VARCHAR(150) NOT NULL,
    tariff DECIMAL(12,2) NOT NULL DEFAULT 0,
    qty INT NOT NULL DEFAULT 1,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    unit VARCHAR(50) NULL,
    approval_note VARCHAR(255) NULL,
    notes TEXT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    is_delete TINYINT(1) NOT NULL DEFAULT 0,
    created DATETIME NULL,
    modified DATETIME NULL,
    INDEX idx_order_id (order_id),
    INDEX idx_patient_id (patient_id),
    INDEX idx_registration_id (registration_id)
);

CREATE TABLE order_surgeries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    registration_id INT NULL,
    patient_id INT NULL,
    doctor_id INT NULL,

    surgery_date DATE NULL,
    surgery_time TIME NULL,
    operator_name VARCHAR(150) NULL,
    surgery_code VARCHAR(30) NULL,
    surgery_name VARCHAR(150) NULL,
    tariff DECIMAL(12,2) NOT NULL DEFAULT 0,
    unit VARCHAR(50) NULL,
    approval_note VARCHAR(255) NULL,
    notes TEXT NULL,

    approved_queue_no VARCHAR(30) NULL,
    approved_date DATE NULL,
    approved_time TIME NULL,
    operating_room VARCHAR(100) NULL,
    approved_operator VARCHAR(150) NULL,
    approved_surgery_name VARCHAR(150) NULL,
    anesthesia_type VARCHAR(100) NULL,
    approved_by VARCHAR(100) NULL,

    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    is_delete TINYINT(1) NOT NULL DEFAULT 0,
    created DATETIME NULL,
    modified DATETIME NULL,

    INDEX idx_order_id (order_id),
    INDEX idx_patient_id (patient_id),
    INDEX idx_registration_id (registration_id)
);

CREATE TABLE master_surgery_operators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(30) NOT NULL,
    doctor_id INT NULL,
    name VARCHAR(150) NOT NULL,
    specialist VARCHAR(100) NULL,
    phone VARCHAR(30) NULL,
    notes TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);

CREATE TABLE master_operation_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(30) NOT NULL,
    name VARCHAR(200) NOT NULL,
    category VARCHAR(100) NULL,
    tariff DECIMAL(12,2) DEFAULT 0,
    unit VARCHAR(50) NULL,
    description TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created DATETIME NULL,
    modified DATETIME NULL
);

ALTER TABLE order_surgeries
ADD operator_id INT NULL AFTER surgery_time,
ADD operation_type_id INT NULL AFTER operator_name;

ALTER TABLE master_operation_types
ADD jasa_rs DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER tariff,
ADD jasa_dr DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER jasa_rs,
ADD jasa_paramedis DECIMAL(12,2) NOT NULL DEFAULT 0 AFTER jasa_dr;

CREATE TABLE order_mcus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    registration_id INT NULL,
    patient_id INT NULL,
    doctor_id INT NULL,

    mcu_date DATE NULL,
    mcu_time TIME NULL,
    mcu_type VARCHAR(150) NULL,
    notes TEXT NULL,

    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    is_delete TINYINT(1) NOT NULL DEFAULT 0,
    created DATETIME NULL,
    modified DATETIME NULL,

    INDEX idx_order_id (order_id),
    INDEX idx_registration_id (registration_id),
    INDEX idx_patient_id (patient_id)
);

-- BACKUP dulu
CREATE TABLE medical_records_backup AS SELECT * FROM medical_records;
CREATE TABLE medical_record_documents_backup AS SELECT * FROM medical_record_documents;
CREATE TABLE medical_record_examinations_backup AS SELECT * FROM medical_record_examinations;
CREATE TABLE medical_record_prescriptions_backup AS SELECT * FROM medical_record_prescriptions;
CREATE TABLE medical_record_laboratories_backup AS SELECT * FROM medical_record_laboratories;
CREATE TABLE medical_record_radiologies_backup AS SELECT * FROM medical_record_radiologies;
CREATE TABLE medical_record_integrations_backup AS SELECT * FROM medical_record_integrations;
CREATE TABLE medical_record_icares_backup AS SELECT * FROM medical_record_icares;


-- RENAME TABLE RIWAYAT PASIEN
RENAME TABLE medical_records TO patient_histories;

RENAME TABLE medical_record_documents TO patient_history_documents;
RENAME TABLE medical_record_examinations TO patient_history_examinations;
RENAME TABLE medical_record_prescriptions TO patient_history_prescriptions;
RENAME TABLE medical_record_laboratories TO patient_history_laboratories;
RENAME TABLE medical_record_radiologies TO patient_history_radiologies;
RENAME TABLE medical_record_integrations TO patient_history_integrations;
RENAME TABLE medical_record_icares TO patient_history_icares;


-- RENAME FIELD FOREIGN KEY DETAIL
ALTER TABLE patient_history_documents
CHANGE medical_record_id patient_history_id INT NOT NULL;

ALTER TABLE patient_history_examinations
CHANGE medical_record_id patient_history_id INT NOT NULL;

ALTER TABLE patient_history_prescriptions
CHANGE medical_record_id patient_history_id INT NOT NULL;

ALTER TABLE patient_history_laboratories
CHANGE medical_record_id patient_history_id INT NOT NULL;

ALTER TABLE patient_history_radiologies
CHANGE medical_record_id patient_history_id INT NOT NULL;

ALTER TABLE patient_history_integrations
CHANGE medical_record_id patient_history_id INT NOT NULL;

ALTER TABLE patient_history_icares
CHANGE medical_record_id patient_history_id INT NOT NULL;

RENAME TABLE medical_records_backup TO medical_records;

RENAME TABLE medical_record_documents_backup TO medical_record_documents;

RENAME TABLE medical_record_examinations_backup TO medical_record_examinations;

RENAME TABLE medical_record_prescriptions_backup TO medical_record_prescriptions;

RENAME TABLE medical_record_laboratories_backup TO medical_record_laboratories;

RENAME TABLE medical_record_radiologies_backup TO medical_record_radiologies;

RENAME TABLE medical_record_integrations_backup TO medical_record_integrations;

RENAME TABLE medical_record_icares_backup TO medical_record_icares;

ALTER TABLE medical_records
ADD COLUMN patient_id INT NULL AFTER registration_id,
ADD COLUMN outpatient_visit_id INT NULL AFTER patient_id,
ADD COLUMN doctor_id INT NULL AFTER outpatient_visit_id,
ADD COLUMN medical_record_no VARCHAR(50) NULL AFTER doctor_id,
ADD COLUMN service_type VARCHAR(50) NULL AFTER medical_record_no,
ADD COLUMN allergy TEXT NULL AFTER service_type;

ALTER TABLE registrations
ADD doctor_schedule_id INT NULL AFTER doctor_id,
ADD skdp_no VARCHAR(50) NULL AFTER sep_no;

ALTER TABLE registrations
ADD COLUMN room_name VARCHAR(100) NULL AFTER polyclinic_name;

ALTER TABLE medical_record_examinations
ADD COLUMN history_no VARCHAR(30) NULL AFTER patient_history_id;


ALTER TABLE medical_records
DROP COLUMN no_rm;

-- 1. Buat tabel baru untuk data klinis EMR
CREATE TABLE outpatient_visit_emr (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    outpatient_visit_id INT UNSIGNED NOT NULL,

    blood_pressure VARCHAR(20) NULL,
    pulse INT UNSIGNED NULL,
    temperature DECIMAL(4,1) UNSIGNED NULL,
    respiratory_rate INT UNSIGNED NULL,
    oxygen_saturation INT UNSIGNED NULL,
    weight DECIMAL(5,2) UNSIGNED NULL,
    height DECIMAL(5,2) UNSIGNED NULL,
    bmi DECIMAL(5,2) UNSIGNED NULL,

    chief_complaint TEXT NULL,
    illness_history TEXT NULL,
    admission_diagnosis VARCHAR(255) NULL,
    allergy VARCHAR(255) NULL,
    pain_scale INT UNSIGNED NULL,

    diagnosis_primary VARCHAR(100) NULL,
    diagnosis_secondary VARCHAR(255) NULL,
    diagnosis_desc TEXT NULL,
    icd10_items TEXT NULL,
    icd9_items TEXT NULL,

    action_notes TEXT NULL,
    doctor_notes TEXT NULL,
    prescription_notes TEXT NULL,

    follow_up_date DATE NULL,
    referral_to VARCHAR(100) NULL,
    referral_reason TEXT NULL,

    payment_method VARCHAR(30) NULL,
    total_fee DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    paid TINYINT(1) NOT NULL DEFAULT 0,

    created DATETIME NULL,
    modified DATETIME NULL,

    UNIQUE KEY uq_outpatient_visit_emr_visit (outpatient_visit_id),
    CONSTRAINT fk_emr_outpatient_visit
        FOREIGN KEY (outpatient_visit_id) REFERENCES outpatient_visits(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Pindahkan data lama dari outpatient_visits ke outpatient_visit_emr
INSERT INTO outpatient_visit_emr (
    outpatient_visit_id, blood_pressure, pulse, temperature, respiratory_rate,
    oxygen_saturation, weight, height, bmi, chief_complaint, illness_history,
    admission_diagnosis, allergy, pain_scale, diagnosis_primary, diagnosis_secondary,
    diagnosis_desc, icd10_items, icd9_items, action_notes, doctor_notes,
    prescription_notes, follow_up_date, referral_to, referral_reason,
    payment_method, total_fee, paid, created, modified
)
SELECT
    id, blood_pressure, pulse, temperature, respiratory_rate,
    oxygen_saturation, weight, height, bmi, chief_complaint, illness_history,
    admission_diagnosis, allergy, pain_scale, diagnosis_primary, diagnosis_secondary,
    diagnosis_desc, icd10_items, icd9_items, action_notes, doctor_notes,
    prescription_notes, follow_up_date, referral_to, referral_reason,
    payment_method, total_fee, paid, created, modified
FROM outpatient_visits;

-- 3. Setelah dicek datanya sudah pindah dengan benar, baru hapus kolom lama dari outpatient_visits
-- ⚠️ JALANKAN INI SETELAH VERIFIKASI DATA AMAN (backup dulu!)
ALTER TABLE outpatient_visits
    DROP COLUMN blood_pressure,
    DROP COLUMN pulse,
    DROP COLUMN temperature,
    DROP COLUMN respiratory_rate,
    DROP COLUMN oxygen_saturation,
    DROP COLUMN weight,
    DROP COLUMN height,
    DROP COLUMN bmi,
    DROP COLUMN chief_complaint,
    DROP COLUMN illness_history,
    DROP COLUMN admission_diagnosis,
    DROP COLUMN allergy,
    DROP COLUMN pain_scale,
    DROP COLUMN diagnosis_primary,
    DROP COLUMN diagnosis_secondary,
    DROP COLUMN diagnosis_desc,
    DROP COLUMN icd10_items,
    DROP COLUMN icd9_items,
    DROP COLUMN action_notes,
    DROP COLUMN doctor_notes,
    DROP COLUMN prescription_notes,
    DROP COLUMN follow_up_date,
    DROP COLUMN referral_to,
    DROP COLUMN referral_reason,
    DROP COLUMN payment_method,
    DROP COLUMN total_fee,
    DROP COLUMN paid;

-- 1. Lepas foreign key yang menahan index unique
ALTER TABLE outpatient_visit_emr DROP FOREIGN KEY fk_emr_outpatient_visit;

-- 2. Sekarang index unique-nya boleh dihapus
ALTER TABLE outpatient_visit_emr DROP INDEX uq_outpatient_visit_emr_visit;

-- 3. Buat index biasa (non-unique) di kolom yang sama
ALTER TABLE outpatient_visit_emr ADD INDEX idx_outpatient_visit_emr_visit (outpatient_visit_id);

ALTER TABLE outpatient_visit_emr
    ADD CONSTRAINT fk_emr_outpatient_visit
    FOREIGN KEY (outpatient_visit_id) REFERENCES outpatient_visits(id)
    ON DELETE CASCADE;
    

ALTER TABLE `patient_histories`
ADD COLUMN `user_id` INT NULL DEFAULT NULL AFTER `registration_id`;

ALTER TABLE medicines ENGINE = InnoDB;
CREATE TABLE `medicine_stocks` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `branch_id` INT NOT NULL DEFAULT 1,
    `medicine_id` INT NOT NULL,
    `last_so_date` DATE NULL DEFAULT NULL COMMENT 'Tgl SO terakhir',
    `hasil_so` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `adjustment` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `terima` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `keluar` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `saldo_akhir` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `max_stock` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `is_valid` ENUM('Y','N') NOT NULL DEFAULT 'N' COMMENT 'Status validasi stock',
    `created` DATETIME NULL DEFAULT NULL,
    `modified` DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_branch_medicine` (`branch_id`, `medicine_id`),
    KEY `fk_medicine_stocks_medicine` (`medicine_id`),
    CONSTRAINT `fk_medicine_stocks_medicine`
        FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci
COMMENT='Informasi stock per obat, relasi ke master medicines';

ALTER TABLE `master_laboratories`
    ADD COLUMN `jasa_rs` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `tariff`,
    ADD COLUMN `jasa_dr` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `jasa_rs`,
    ADD COLUMN `jasa_perawat` DECIMAL(15,2) NOT NULL DEFAULT 0.00 AFTER `jasa_dr`;

UPDATE `master_laboratories` SET `jasa_rs` = `tariff` WHERE `jasa_rs` = 0;

CREATE TABLE `order_pembelians` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_id` INT UNSIGNED NOT NULL,
  `po_no` VARCHAR(30) NOT NULL,
  `tgl_po` DATE NOT NULL,
  `ref_no` VARCHAR(50) DEFAULT NULL,
  `tgl_kirim` DATE DEFAULT NULL,
  `barang_dikirim_ke` TEXT DEFAULT NULL,
  `kirim_via` VARCHAR(50) DEFAULT NULL,
  `jenis` VARCHAR(50) DEFAULT NULL,
  `total` DECIMAL(18,2) NOT NULL DEFAULT 0,
  `status` VARCHAR(20) NOT NULL DEFAULT 'draft',
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_order_pembelians_po_no` (`po_no`),
  KEY `idx_order_pembelians_supplier_id` (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `order_pembelian_details` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_pembelian_id` INT UNSIGNED NOT NULL,
  `barang_id` INT UNSIGNED DEFAULT NULL,   
  `kode_barang` VARCHAR(30) DEFAULT NULL,  
  `nama_barang` VARCHAR(200) DEFAULT NULL, 
  `qty_rencana` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `qty_po` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `satuan` VARCHAR(20) DEFAULT NULL,
  `harga` DECIMAL(18,2) NOT NULL DEFAULT 0,
  `discount` DECIMAL(18,2) NOT NULL DEFAULT 0,
  `tax` DECIMAL(18,2) NOT NULL DEFAULT 0,
  `total_harga` DECIMAL(18,2) NOT NULL DEFAULT 0,
  `created` DATETIME DEFAULT NULL,
  `modified` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_opd_order_pembelian_id` (`order_pembelian_id`),
  KEY `idx_opd_barang_id` (`barang_id`),
  CONSTRAINT `fk_opd_order_pembelian`
    FOREIGN KEY (`order_pembelian_id`) REFERENCES `order_pembelians` (`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE rencana_pembelians (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    no_perencanaan VARCHAR(30) NOT NULL,
    tgl_perencanaan DATE NOT NULL,
    no_dokumen VARCHAR(50) DEFAULT NULL,
    status ENUM('draft','diajukan','disetujui','ditolak') NOT NULL DEFAULT 'draft',
    supplier_id INT UNSIGNED DEFAULT NULL,
    nama_supplier VARCHAR(150) DEFAULT NULL,
    diminta_oleh VARCHAR(150) DEFAULT NULL,
    total_qty_permintaan DECIMAL(14,2) NOT NULL DEFAULT 0,
    total_permintaan DECIMAL(14,2) NOT NULL DEFAULT 0,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_no_perencanaan (no_perencanaan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE rencana_pembelian_details (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    rencana_pembelian_id INT UNSIGNED NOT NULL,
    medicine_id INT UNSIGNED DEFAULT NULL,
    kode_barang VARCHAR(50) DEFAULT NULL,
    nama_barang VARCHAR(200) DEFAULT NULL,
    qty DECIMAL(14,2) NOT NULL DEFAULT 0,
    harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    satuan VARCHAR(30) DEFAULT NULL,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,
    total_approv DECIMAL(14,2) NOT NULL DEFAULT 0,
    is_obat ENUM('Y','N') NOT NULL DEFAULT 'Y',
    keterangan VARCHAR(255) DEFAULT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_rencana_pembelian_id (rencana_pembelian_id),
    KEY idx_medicine_id (medicine_id),
    CONSTRAINT fk_rpd_rencana FOREIGN KEY (rencana_pembelian_id)
        REFERENCES rencana_pembelians (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE retur_pembelians (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    retur_no VARCHAR(30) NOT NULL,
    tgl_retur DATE NOT NULL,
    bapb_no VARCHAR(50) DEFAULT NULL,
    no_faktur VARCHAR(50) DEFAULT NULL,
    gudang_depo VARCHAR(100) DEFAULT NULL,
    supplier_id INT UNSIGNED DEFAULT NULL,
    nama_supplier VARCHAR(150) DEFAULT NULL,
    catatan VARCHAR(255) DEFAULT NULL,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_retur_no (retur_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE retur_pembelian_details (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    retur_pembelian_id INT UNSIGNED NOT NULL,
    medicine_id INT UNSIGNED DEFAULT NULL,
    kode_barang VARCHAR(50) DEFAULT NULL,
    nama_barang VARCHAR(200) DEFAULT NULL,
    qty DECIMAL(14,2) NOT NULL DEFAULT 0,
    unit VARCHAR(30) DEFAULT NULL,
    harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    tax DECIMAL(14,2) NOT NULL DEFAULT 0,
    ppn_rp DECIMAL(14,2) NOT NULL DEFAULT 0,
    discount DECIMAL(14,2) NOT NULL DEFAULT 0,
    total_harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    tgl_kadaluarsa DATE DEFAULT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_retur_pembelian_id (retur_pembelian_id),
    KEY idx_medicine_id (medicine_id),
    CONSTRAINT fk_rpbd_retur FOREIGN KEY (retur_pembelian_id)
        REFERENCES retur_pembelians (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE invoices (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    bapb_no VARCHAR(30) NOT NULL,
    nama_supplier VARCHAR(150) DEFAULT NULL,
    supplier_id INT UNSIGNED DEFAULT NULL,
    tgl_terima DATE NOT NULL,
    no_faktur VARCHAR(50) DEFAULT NULL,
    sj_no VARCHAR(50) DEFAULT NULL,
    tgl_tukar_faktur DATE DEFAULT NULL,
    kurs VARCHAR(10) NOT NULL DEFAULT 'IDR',
    rate DECIMAL(14,4) NOT NULL DEFAULT 1,
    pembayaran ENUM('cash','kredit') NOT NULL DEFAULT 'cash',
    tgl_jatuh_tempo DATE DEFAULT NULL,
    diterima_lokasi_gudang VARCHAR(100) DEFAULT NULL,
    materai ENUM('3000','6000','tanpa') NOT NULL DEFAULT 'tanpa',
    discount_percent DECIMAL(5,2) NOT NULL DEFAULT 0,
    discount_rp DECIMAL(14,2) NOT NULL DEFAULT 0,
    ongkos_kirim DECIMAL(14,2) NOT NULL DEFAULT 0,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,
    grand_total DECIMAL(14,2) NOT NULL DEFAULT 0,
    catatan VARCHAR(255) DEFAULT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_bapb_no (bapb_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE invoice_details (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    invoice_id INT UNSIGNED NOT NULL,
    medicine_id INT UNSIGNED DEFAULT NULL,
    kode_barang VARCHAR(50) DEFAULT NULL,
    nama_barang VARCHAR(200) DEFAULT NULL,
    qty DECIMAL(14,2) NOT NULL DEFAULT 0,
    satuan VARCHAR(30) DEFAULT NULL,
    harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    discount_percent DECIMAL(5,2) NOT NULL DEFAULT 0,
    discount_rp DECIMAL(14,2) NOT NULL DEFAULT 0,
    tax DECIMAL(14,2) NOT NULL DEFAULT 0,
    total_harga DECIMAL(14,2) NOT NULL DEFAULT 0,
    tgl_kadaluarsa DATE DEFAULT NULL,
    po_no VARCHAR(50) DEFAULT NULL,
    histori VARCHAR(100) DEFAULT NULL,
    nilai_diskon DECIMAL(14,2) NOT NULL DEFAULT 0,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    PRIMARY KEY (id),
    KEY idx_invoice_id (invoice_id),
    KEY idx_medicine_id (medicine_id),
    CONSTRAINT fk_invd_invoice FOREIGN KEY (invoice_id)
        REFERENCES invoices (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `outpatient_initial_medical_assessments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outpatient_visit_id` int(11) NOT NULL,
  `registration_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `assessment_no` varchar(50) DEFAULT NULL,
  `assessment_date` date DEFAULT NULL,
  `assessment_time` time DEFAULT NULL,
  `data_dasar` longtext DEFAULT NULL,
  `subjektif` longtext DEFAULT NULL,
  `observasi` longtext DEFAULT NULL,
  `created_by_user_id` int(11) DEFAULT NULL,
  `modified_by_user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_oima_outpatient_visit_id` (`outpatient_visit_id`),
  KEY `idx_oima_registration_id` (`registration_id`),
  KEY `idx_oima_patient_id` (`patient_id`),
  KEY `idx_oima_doctor_id` (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE outpatient_letters
ADD COLUMN notes LONGTEXT NULL AFTER diagnosis,
ADD COLUMN consultation_answer LONGTEXT NULL AFTER notes;

ALTER TABLE `registrations` DROP COLUMN `insurance_category`;

ALTER TABLE doctor_schedules
ADD COLUMN quota_reset_at DATE NULL DEFAULT NULL AFTER quota_used;

CREATE TABLE doctor_schedule_quota_histories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_schedule_id INT NOT NULL,
    cycle_date DATE NOT NULL COMMENT 'Tanggal praktik pada minggu tsb (mis. Senin 20-07-2026)',
    quota INT NOT NULL DEFAULT 0,
    quota_used INT NOT NULL DEFAULT 0,
    created DATETIME NOT NULL,
    modified DATETIME NULL,
    INDEX idx_schedule_cycle (doctor_schedule_id, cycle_date)
);


ALTER TABLE outpatient_visit_emr
ADD COLUMN action_notes_secondary TEXT NULL AFTER action_notes;

ALTER TABLE `outpatient_visit_emr`
    ADD COLUMN `anatomy_front` VARCHAR(255) NULL AFTER `icd9_items`,
    ADD COLUMN `anatomy_back` VARCHAR(255) NULL AFTER `anatomy_front`;

ALTER TABLE `outpatient_letters`
    ADD COLUMN `anamnesa` TEXT NULL AFTER `examined_at`,
    ADD COLUMN `diagnosis_primary_text` TEXT NULL AFTER `anamnesa`,
    ADD COLUMN `diagnosis_secondary_text` TEXT NULL AFTER `diagnosis_primary_text`,
    ADD COLUMN `action_primary_text` TEXT NULL AFTER `diagnosis_secondary_text`,
    ADD COLUMN `action_secondary_text` TEXT NULL AFTER `action_primary_text`,
    ADD COLUMN `supporting_diagnosis` TEXT NULL AFTER `action_secondary_text`,
    ADD COLUMN `is_autopsy` TINYINT(1) NOT NULL DEFAULT 0 AFTER `supporting_diagnosis`,
    ADD COLUMN `special_actions` TEXT NULL AFTER `is_autopsy`,
    ADD COLUMN `prescription` TEXT NULL AFTER `special_actions`,
    ADD COLUMN `advice_notes` TEXT NULL AFTER `prescription`,
    ADD COLUMN `discharged_by_doctor_id` INT UNSIGNED NULL AFTER `advice_notes`,
    ADD COLUMN `completing_doctor_id` INT UNSIGNED NULL AFTER `discharged_by_doctor_id`,
    ADD COLUMN `patient_or_family_name` VARCHAR(150) NULL AFTER `completing_doctor_id`;

    ALTER TABLE patients
ADD COLUMN title VARCHAR(10) NULL AFTER full_name;

ALTER TABLE registrations
ADD COLUMN admission_time TIME NULL AFTER registration_date;

ALTER TABLE patients
ADD COLUMN allergy TEXT NULL DEFAULT NULL
COMMENT 'Riwayat alergi pasien' AFTER blood_type;

ALTER TABLE registrations ADD COLUMN patient_title VARCHAR(10) NULL AFTER patient_id;