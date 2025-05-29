<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFHelper
{
    public static function htmlToPdf($html, $filename = 'document.pdf')
    {
        // Use the Laravel DomPDF facade if available
        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait','landscape' );
            return $pdf->output();
        }
        // Fallback to direct Dompdf usage
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait', 'landscape');
        $dompdf->render();
        return $dompdf->output();
    }
}
