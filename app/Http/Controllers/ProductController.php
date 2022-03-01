<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $viewBag['products'] = DB::table('products')->join('categories', 'categories.id', 'products.category_id')->select('categories.category_name', 'products.*')->get();
        return view('products.index', $viewBag);
    }


    public function create()
    {
        $viewBag['categories'] = DB::table('categories')->get();
        return  view('products.create', $viewBag);
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $data = array();
            $data['category_id'] = $request->category_id;
            $data['name'] = $request->name;
            $data['price'] = $request->price;
            $data['stock'] = $request->stock;
            $data['description'] = $request->description;
            DB::table('products')->insert($data);
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function show($id)
    {
        $viewBag['product'] = DB::table('products')->join('categories', 'products.category_id', 'categories.id')->select('categories.category_name', 'products.*')->first();
        return view('products.show', $viewBag);
    }


    public function edit($id)
    {
        $viewBag['categories'] = DB::table('categories')->get();
        $viewBag['product'] = DB::table('products')->where('id', $id)->first();
        return view('products.edit', $viewBag);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $data = array();
        $data['category_id'] = $request->category_id;
        $data['name'] = $request->name;
        $data['price'] = $request->price;
        $data['stock'] = $request->stock;
        $data['description'] = $request->description;
        DB::table('products')->where('id', $id)->update($data);
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', $id)->delete();
        return redirect()->route('products.index');
    }
}
