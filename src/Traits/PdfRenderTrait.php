<?php
declare(strict_types=1);

namespace App\Traits;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Trait PdfRenderTrait
 *
 * Render sebuah view CakePHP (template + layout) menjadi file PDF sungguhan
 * (bukan hanya HTML yang di-print manual dari browser), pakai dompdf.
 *
 * Install dulu:
 *   composer require dompdf/dompdf
 *
 * Cara pakai di controller:
 *   use App\Traits\PdfRenderTrait;
 *   class OutpatientLettersController extends AppController
 *   {
 *       use PdfRenderTrait;
 *
 *       public function cetakSuratSakit($letterId = null)
 *       {
 *           $letter = $this->OutpatientLetters->get($letterId, [
 *               'contain' => ['Patients', 'Doctors', 'OutpatientVisits'],
 *           ]);
 *
 *           return $this->streamPdf(
 *               'cetak_surat_sakit',                       // nama template (tanpa .php)
 *               compact('letter'),                          // variabel untuk view
 *               'Surat-Keterangan-Sakit-' . $letter->letter_no . '.pdf',
 *               'A5',
 *               'portrait',
 *               'attachment'                                 // 'attachment' = download, 'inline' = buka di tab
 *           );
 *       }
 *   }
 */
trait PdfRenderTrait
{
    /**
     * Render template + layout 'print' menjadi PDF dan kirim sebagai response.
     *
     * @param string $template Nama file template di templates/{Controller}/ (tanpa ekstensi)
     * @param array $vars Variabel yang di-set ke view, misal ['letter' => $letter]
     * @param string $filename Nama file PDF yang akan didownload user
     * @param string $paperSize Ukuran kertas dompdf, misal 'A5', 'A4', 'letter'
     * @param string $orientation 'portrait' atau 'landscape'
     * @param string $disposition 'attachment' (paksa download) atau 'inline' (buka di tab browser)
     * @return \Cake\Http\Response
     */
    protected function streamPdf(
        string $template,
        array $vars,
        string $filename,
        string $paperSize = 'A5',
        string $orientation = 'portrait',
        string $disposition = 'attachment'
    ) {
        // Render template + layout 'print' jadi string HTML tanpa mengirim response.
        // templatePath di-set eksplisit (bukan mengandalkan default) supaya CakePHP
        // pasti mencari file di templates/{NamaController}/{template}.php,
        // bukan langsung di root templates/.
        $this->viewBuilder()
            ->setTemplatePath($this->getName())
            ->setTemplate($template)
            ->setLayout('print');
        $this->set($vars);
        $html = $this->createView()->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);   // izinkan load gambar/logo dari URL/absolute path
        $options->set('defaultFont', 'DejaVu Sans'); // font yang support karakter umum + simbol °, dsb.
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper($paperSize, $orientation);
        $dompdf->render();

        $this->autoRender = false;

        return $this->response
            ->withType('application/pdf')
            ->withHeader(
                'Content-Disposition',
                $disposition . '; filename="' . $filename . '"'
            )
            ->withStringBody($dompdf->output());
    }
}
