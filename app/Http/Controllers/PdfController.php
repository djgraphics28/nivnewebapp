<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Product;
use App\Models\Productout;
use Illuminate\Http\Request;
use App\Models\ProductTracking;

class PdfController extends Controller
{
    public function generateDeliveryReceipt($id)
    {
        // $data['items'] = Productout::with('product_tracking')
        //     ->where('id','=', $id)->get();

        $data['items'] = Productout::with('product')->where('id','=', $id)->get();

        // dd($data);
        $pdf = PDF::loadView('staff.pdf.delivery_receipt', $data)->setPaper('a4', 'landscape')->setWarnings(false);

        // download PDF file with download method
        return $pdf->stream('delivery_receipt.pdf');
    }
}
