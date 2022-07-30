<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

    public function index()
    {
        $sections = sections::all();
        return view('products.products',compact('sections'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:sections|max:255',
            'section_id' => 'required',
        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
        ]);

        products::create([
            'product_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),
            'section_id' => $request->section_id,

        ]);
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');
    }


    public function show(products $products)
    {
        //
    }


    public function edit(products $products)
    {
        //
    }


    public function update(Request $request, products $products)
    {
        //
    }

    public function destroy(products $products)
    {
        //
    }
}
