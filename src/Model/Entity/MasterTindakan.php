<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MasterTindakan Entity
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property string $jenis_layanan
 * @property string $harga_umum
 * @property string $persen_dokter_umum
 * @property string $harga_bpjs
 * @property string $persen_dokter_bpjs
 * @property string $harga_reimbes
 * @property string $persen_dokter_reimbes
 * @property bool $applies_rawat_jalan
 * @property bool $applies_rawat_inap
 * @property bool $applies_igd
 * @property string|null $satuan
 * @property string|null $keterangan
 * @property bool $is_active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property float $komisi_dokter_umum Nilai komisi dokter (Rp), dihitung otomatis dari harga_umum × persen_dokter_umum
 * @property float $jasa_rs_umum Sisa jasa RS (Rp) = harga_umum − komisi_dokter_umum
 * @property float $komisi_dokter_bpjs
 * @property float $jasa_rs_bpjs
 * @property float $komisi_dokter_reimbes
 * @property float $jasa_rs_reimbes
 *
 * @property \App\Model\Entity\OutpatientAction[] $outpatient_actions
 */
class MasterTindakan extends Entity
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
    protected array $_accessible = [
        'kode' => true,
        'nama' => true,
        'kategori' => true,
        'jenis_layanan' => true,
        'harga_umum' => true,
        'persen_dokter_umum' => true,
        'harga_bpjs' => true,
        'persen_dokter_bpjs' => true,
        'harga_reimbes' => true,
        'persen_dokter_reimbes' => true,
        'applies_rawat_jalan' => true,
        'applies_rawat_inap' => true,
        'applies_igd' => true,
        'satuan' => true,
        'keterangan' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
        'outpatient_actions' => true,
    ];

    protected array $_virtual = [
        'komisi_dokter_umum', 'jasa_rs_umum',
        'komisi_dokter_bpjs', 'jasa_rs_bpjs',
        'komisi_dokter_reimbes', 'jasa_rs_reimbes',
    ];

    protected function _getKomisiDokterUmum(): float
    {
        return round((float)($this->harga_umum ?? 0) * (float)($this->persen_dokter_umum ?? 0) / 100, 2);
    }

    protected function _getJasaRsUmum(): float
    {
        return round((float)($this->harga_umum ?? 0) - $this->komisi_dokter_umum, 2);
    }

    protected function _getKomisiDokterBpjs(): float
    {
        return round((float)($this->harga_bpjs ?? 0) * (float)($this->persen_dokter_bpjs ?? 0) / 100, 2);
    }

    protected function _getJasaRsBpjs(): float
    {
        return round((float)($this->harga_bpjs ?? 0) - $this->komisi_dokter_bpjs, 2);
    }

    protected function _getKomisiDokterReimbes(): float
    {
        return round((float)($this->harga_reimbes ?? 0) * (float)($this->persen_dokter_reimbes ?? 0) / 100, 2);
    }

    protected function _getJasaRsReimbes(): float
    {
        return round((float)($this->harga_reimbes ?? 0) - $this->komisi_dokter_reimbes, 2);
    }
}
