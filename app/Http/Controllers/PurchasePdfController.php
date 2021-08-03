<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Dompdf\Dompdf;

use Illuminate\Http\Request;

class PurchasePdfController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Purchase $purchase, Request $request)
    {
        $title = "Order for {$purchase->vendor->name} at {$purchase->expires_at}";
        $view = view('pdf.purchase', compact('purchase', 'title'));
        // reference the Dompdf namespace
        if(0) {
            return $view;
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($title . ".pdf", ['Attachment' => false]);
    }
}
