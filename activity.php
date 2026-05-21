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