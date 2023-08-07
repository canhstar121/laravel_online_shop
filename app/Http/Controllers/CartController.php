<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
class CartController extends Controller
{
    public function addToCart(Request $request) {
        $product = Product::with('product_images')->find($request->id);
        // Cart::add('293ad', 'Product 1', 1, 9.99);    

        if($product == null) {
            return response()->json([
                'status' =>false,
                'message' => 'Product  not found'
            ]);
        }

        if(Cart::count() > 0 ) {
            $cartContent = Cart::content();

            $productAlreadyExits = false;

            foreach($cartContent as $item) {
                if($item->id == $product->id) {
                    $productAlreadyExits = true;

                }
            }
            if($productAlreadyExits == false) {
            Cart::add($product->id,$product->title, 1 , $product->price, ['productImage' =>(!empty($product->product_images)) ? $product->product_images->first() : '' ]);
            $status = true;
            $message = $product->title.' added in cart';
            } else {
                $status = false;
                $message = $product->title.'already added in cart';
            }


        } else {
            echo "Cart is empty nơ adding aproduct in cart";
            // Cart is empty 
            Cart::add($product->id,$product->title, 1 , $product->price, ['productImage' =>(!empty($product->product_images)) ? $product->product_images->first() : '' ]);
            $status = true;
            $message = $product->title.' added in cart';
        }
        return response()->json([
            'status' =>$status,
            'message' =>  $message
        ]);
    }
    public function cart() {
        $cartContent = Cart::content();
        // dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('front.cart',$data);
    }
}
