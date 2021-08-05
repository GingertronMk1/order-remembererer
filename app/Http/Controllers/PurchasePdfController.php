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
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Purchase $purchase, Request $request)
    {
        if ($request->get('timezone')) {
            $expiry = $purchase->expires_at->setTimezone($request->get('timezone'));
            $title = "Order for {$purchase->vendor->name} at {$expiry}";
            $view = view('pdf.purchase', compact('purchase', 'title'));
            // reference the Dompdf namespace
            if (0) {
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
            return $dompdf->stream($title.'.pdf', ['Attachment' => false]);
        }

        return inertia('PurchasePdf/Redirect', ['purchase-id' => $purchase->id]);
    }
}
