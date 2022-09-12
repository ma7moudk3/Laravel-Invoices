<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $invoices = invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('attachments')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return redirect()->back();
    }



    public function showFile($invoice_number, $image_name)
    {
        /// attachments Disk key come from cnofig/fileSystem.php /////////
        $contents = Storage::disk('attachments')->path($invoice_number . '/' . $image_name);
        return response()->file($contents);
    }

    public function downloadFile($invoice_number, $image_name)
    {
        $contents = Storage::disk('attachments')->path($invoice_number . '/' . $image_name);
        return response()->download($contents);
    }

    public function storeAttachment(Request $request){
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments =  new invoices_attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);
        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }
}
