<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{

    public function index()
    {
        return view("invoices.invoices");
    }

    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));        //
    }

    public function store(Request $request)
    {
        //
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


    public  function  getProducts($id  ){
        $product = DB::table("products")->where("section_id",$id)->pluck("product_name","id");
        return json_decode($product);

    }
}
