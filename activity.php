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