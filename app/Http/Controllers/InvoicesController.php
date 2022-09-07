<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{

    public function index()
    {
        $invoices = invoices::all();
        return view("invoices.invoices", compact("invoices"));
    }

    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));        //
    }

    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }


    public function show(invoices $invoices)
    {
        //
    }


    public function edit(invoices $invoices)
    {
        //
    }


    public function update(Request $request, invoices $invoices)
    {
        //
    }


    public function destroy(invoices $invoices)
    {
        //
    }

    public function showDetails($id)
    {
        $invoices = invoices::where("id", $id)->first();
        $details = invoices_details::where("id_Invoice", $id)->get();
        $attachments = invoices_attachments::where("invoice_id", $id)->get();
        return view("invoices.invoice_details", compact("invoices", "details", "attachments"));

    }


    public function getProducts($id)
    {
        $product = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_decode($product);

    }

}
