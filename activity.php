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

