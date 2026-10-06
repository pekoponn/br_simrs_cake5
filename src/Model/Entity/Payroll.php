<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payroll Entity
 *
 * @property int $id
 * @property int $hrga_employee_id
 * @property int $hrga_attendance_id
 * @property \Cake\I18n\FrozenDate|null $date
 * @property string $gaji_pokok
 * @property string $tujungan_harian
 * @property string $tunjangan_jabatan
 * @property string $tunjangan_makan
 * @property string $tunjangan_produktifitas
 * @property string $tunjangan_struktural
 * @property string $lembur
 * @property string $komisi
 * @property string $thr
 * @property string $bpjs_kesehatan
 * @property string $bpjs_ketenagakerjaan
 * @property string $bpjs_pensiun
 * @property string $lain_lain
 * @property string $bpjs_medical
 * @property string $bpjs_naker
 * @property string $bpjs_pension
 * @property string $bpjs_ditanggung_perusahaan
 * @property string $potongan_keterlambatan
 * @property string $pph_21
 * @property string $tabungan_pph_21
 * @property int $qty
 * @property int $qty_lateness
 * @property int $qty_overtime
 * @property \Cake\I18n\FrozenDate|null $start_date
 * @property \Cake\I18n\FrozenDate|null $end_date
 * @property string $jml_pinjaman
 * @property string $bonus
 * @property string|null $description
 * @property int $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $status
 * @property string|null $is_log
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\HrgaEmployee $hrga_employee
 * @property \App\Model\Entity\HrgaAttendance $hrga_attendance
 */
class Payroll extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'hrga_employee_id' => true,
        'hrga_attendance_id' => true,
        'date' => true,
        'gaji_pokok' => true,
        'tunjangan_harian' => true,
        'tunjangan_jabatan' => true,
        'tunjangan_makan' => true,
        'tunjangan_produktifitas' => true,
        'tunjangan_struktural' => true,
        'lembur' => true,
        'komisi' => true,
        'thr' => true,
        'bpjs_kesehatan' => true,
        'bpjs_ketenagakerjaan' => true,
        'bpjs_pensiun' => true,
        'ket_lain_lain' => true,
        'lain_lain' => true,
        'ket_lain_lain_2' => true,
        'lain_lain_2' => true,
        'ket_lain_lain_3' => true,
        'lain_lain_3' => true,
        'bpjs_medical' => true,
        'bpjs_naker' => true,
        'bpjs_pension' => true,
        'bpjs_ditanggung_perusahaan' => true,
        'potongan_keterlambatan' => true,
        'pph_21' => true,
        'tabungan_pph_21' => true,
        'ket_lain_lain_pengurangan' => true,
        'lain_lain_pengurangan' => true,
        'ket_lain_lain_pengurangan_2' => true,
        'lain_lain_pengurangan_2' => true,
        'ket_lain_lain_pengurangan_3' => true,
        'lain_lain_pengurangan_3' => true,
        'qty' => true,
        'qty_lateness' => true,
        'qty_overtime' => true,
        'start_date' => true,
        'end_date' => true,
        'jml_pinjaman' => true,
        'bonus' => true,
        'description' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'status' => true,
        'is_log' => true,
        'is_active' => true,
        'hrga_employee' => true,
        'hrga_attendance' => true,
    ];
}
