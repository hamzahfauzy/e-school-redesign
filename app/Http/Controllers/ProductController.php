<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product;

class ProductController extends Controller
{

    function __construct()
    {
        $this->product = new Product;
    }

    public function index()
    {
        //
        $products = $this->product->paginate(20);
        return view('product.index',[
            'products' => $products
        ]);
    }
    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'unit_value' => 'required',
        ]);

        $input = $request->all(); 
        $this->product->create($input);

        return redirect()->route('product.index')->with(['success' => 'Create product success']);;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = $this->product->find($id);
        if($product){
            return view('product.edit', [
                'product' => $product,
            ]);            
        }else{
            return redirect()->route('product.create')->with(['danger' => 'Product is not found, you can create a new Product here']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'unit_value' => 'required',
        ]);

        $product = $this->product->find($id);
        $product->name = $request->input('name'); 
        $product->price = $request->input('price'); 
        $product->unit = $request->input('unit'); 
        $product->unit_value = $request->input('unit_value'); 
        $product->save();
        return redirect()->route('product.index')->with(['success' => 'Data has updated !']);
    }

    public function destroy($id)
    {
        $product = $this->product->find($id);
        $p = $product;
        $product->delete();
        return redirect()->route('product.index')->with(['success' => 'Product "'.$p->name.'" has deleted !']);
    }
}
