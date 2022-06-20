<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,200',
            'price'=>'required|min:1',
            'category'=>'required|string'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $result=$request->file('image')->store('public/products');
        $product=new Product;
        $product->name=$request->name;
        $product->price=$request->price;
        $product->category=$request->category; //Electronics/Mobiles/Furniture/books/
        $product->image=$request->file('image')->hashName();
        $productAdded=$product->save();
        if($productAdded)
        {
            return ['result'=>"Product Added"];
        }
        else
        {
            return ['result'=>"Product Not Added"];
        }
    }
}
