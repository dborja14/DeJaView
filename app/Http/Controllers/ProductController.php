<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Chat;
use App\Models\ChatContent;
use App\Models\Order;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index($productName)
    {
        $userId = Session::get('loginId');
        $product = Product::where('productName', $productName)->firstOrFail();
        $photos = Photo::where('productId', $product->id)->get();
        $products = Product::with('shoeSizes')->get();

        $addr = Address::where('userId', $userId)->first();

        return view('product', compact('product', 'photos', 'products', 'addr'));
    }



    public function cart(Request $request)

    {

        $productId = $request->input('productId');
        $product = Product::find($productId);



        if ($product) {
            $price = $product->productPrice;


            $cart = new Cart();
            $cart->userId = Session::get('user.id');
            $cart->productId = $productId;
            $cart->addressId = $request->input('addr');
            $cart->size = $request->input('selectedSize');
            $cart->price = $price;
            $cart->quantity = $request->input('quantity');


            // Save the cart entry
            $cart->save();

            return redirect('collection')->with('Success', 'Added to Cart!');;
        } else {
            return redirect()->back()->with('error', 'Product not added to cart.');
        }
    }
}
