<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class OutpatientVisitsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('outpatient_visits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // ── Belongs To ───────────────────────────────────────────────────────
        $this->belongsTo('Registrations', [
            'foreignKey' => 'registration_id',
            'joinType'   => 'INNER',
        ]);

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType'   => 'INNER',
        ]);

        $this->belongsTo('Doctors', [
            'foreignKey' => 'doctor_id',
            'joinType'   => 'LEFT',
        ]);

        // ── Has Many ─────────────────────────────────────────────────────────
        $this->hasMany('OutpatientActions', [
            'foreignKey' => 'outpatient_visit_id',
            'dependent'  => true,
            'saveStrategy' => 'replace',
        ]);

        // ── Has One ──────────────────────────────────────────────────────────
        // Data klinis (tanda vital, diagnosa, ICD, resep, dll) dipisah
        // ke tabel outpatient_visit_emr. Tabel ini (outpatient_visits)
        // sekarang hanya berfungsi sebagai index/induk kunjungan.
        $this->hasOne('OutpatientVisitEmr', [
            'foreignKey' => 'outpatient_visit_id',
            'dependent'  => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('registration_id')
            ->notEmptyString('registration_id', 'Registration wajib diisi');

        $validator
            ->integer('patient_id')
            ->notEmptyString('patient_id', 'Pasien wajib diisi');

        $validator
            ->date('visit_date')
            ->notEmptyString('visit_date', 'Tanggal kunjungan wajib diisi');

        $validator
            ->inList('status', ['waiting', 'called', 'in_progress', 'done', 'cancelled'])
            ->notEmptyString('status');

        // Catatan: validasi untuk pain_scale, weight, height, oxygen_saturation,
        // dan total_fee dipindahkan ke OutpatientVisitEmrTable karena kolomnya
        // sudah tidak lagi berada di tabel outpatient_visits.

        return $validator;
    }

    public function syncFromRegistration($registration)
    {
        $schema = $this->getSchema();

        $visit = $this->find()
            ->where(['OutpatientVisits.registration_id' => $registration->id])
            ->first();

        if (!$visit) {
            $visit = $this->newEmptyEntity();
        }

        $data = [
            'registration_id' => $registration->id,
            'registration_no' => $registration->registration_no ?? null,
            'patient_id' => $registration->patient_id,
            'doctor_id' => $registration->doctor_id ?? null,
            'queue_number' => $registration->queue_number ?? null,
            'polyclinic_name' => $registration->polyclinic_name ?? null,
            'visit_date' => !empty($registration->registration_date)
                ? $registration->registration_date
                : date('Y-m-d'),
            'visit_time' => !empty($registration->admission_time)
                ? $registration->admission_time
                : date('H:i:s'),
            'status' => 'waiting',
        ];

        $data = array_intersect_key($data, array_flip($schema->columns()));

        $visit = $this->patchEntity($visit, $data);

        return $this->save($visit);
    }

    // ── Finder: kunjungan hari ini ────────────────────────────────────────────
    public function findToday(\Cake\ORM\Query $query, array $options = []): \Cake\ORM\Query
    {
        return $query->where([
            'OutpatientVisits.visit_date' => date('Y-m-d'),
        ]);
    }

    // ── Finder: berdasarkan poli ──────────────────────────────────────────────
    public function findByPoli(\Cake\ORM\Query $query, array $options = []): \Cake\ORM\Query
    {
        if (!empty($options['polyclinic_name'])) {
            $query->where(['OutpatientVisits.polyclinic_name' => $options['polyclinic_name']]);
        }
        return $query;
    }

    // ── Finder: menunggu (waiting + called) ──────────────────────────────────
    public function findPending(\Cake\ORM\Query $query, array $options = []): \Cake\ORM\Query
    {
        return $query->where([
            'OutpatientVisits.status IN' => ['waiting', 'called'],
        ]);
    }

    // Catatan: beforeSave() untuk auto-hitung BMI (dari weight & height)
    // sudah dipindahkan ke OutpatientVisitEmrTable, karena kolom weight,
    // height, dan bmi sekarang berada di tabel outpatient_visit_emr.
}