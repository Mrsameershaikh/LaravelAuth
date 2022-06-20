<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;

class WishlistController extends Controller
{
    //this "create" function is used to create/add the product in the wishlist.
    
    public function create($product_id, Request $request)
    {
        if($product_id !=null)  //this "if" condition will check whether user has already added this product to his/her wishlist
            {
                $user=$request->user();
                $result=Wishlist::where('product_id',$product_id)->
                where('user_id',$user->id)->first();
                 if($result)
                 {
                return response()->json(['message'=>'Product already exist in whishlist']);
                 }
            }
        //if above condition fails then below where clause will execute and check, provided Product Id is present in the product list or not
        $product=Product::where('product_id',$product_id)->first(); 

        if($product)   //if above condition is true then this "if" condition will be executed
        {
            
            //storing the data into database
            $wishlist=Wishlist::create([
                'product_id'=>$product->product_id,
                'user_id'=>$request->user()->id
            ]);
            $wishlist->load('user');
            return response()->json([
                'message'=>'Product added to wishlist',
                'data'=>$wishlist
            ],200);
        }
        else{                             //if product ID does't find in the product list then "else" condition will execute.
            return response()->json([
                'message'=>'No product found',
            ],400);
        }
    }

    //below function is to delete/remove the product from the wishlist.
    public function delete($product_id,Request $request)
    {
        $product=Product::where('product_id',$product_id)->first();
        if($product)
        {
            $user=$request->user();
            $wishlist=Wishlist::where('product_id',$product->product_id)->
            where('user_id',$user->id)->first();
            if($wishlist)
            {
                $wishlist->delete();
                return response()->json(['message'=>'Product removed successfully from wishlist']);
            }
            else{
                return response()->json([
                    'message'=>'Either product id or user not matched with database'
                ]);
            }
        }
    }
}
