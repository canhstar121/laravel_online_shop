<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        $products = Product::where('is_Featured','Yes')->orderBy('id','DESC')->take(8)->where('status',1)->get();
        $data['featuredproducts']= $products;

        $lastestProduct = Product::orderBy('id','DESC')->where('status',1)->take(8)->get();
        $data['lastestProduct'] = $lastestProduct;
        return view('front.home',$data);
    }
}
