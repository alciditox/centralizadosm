<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class Pdf
{
    function createPDF($html, $filename = '', $download = FALSE, $paper = 'A4', $orientation = 'portrait')
    {

        $options = new Dompdf\Options();
        $options->setChroot(__DIR__);
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf\Dompdf($options);

        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        //if ($download)
        //    $dompdf->stream($filename . '.pdf', array('Attachment' => 1));
        //else
        //    $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=documento.pdf");
        echo $dompdf->output();
    }
}
