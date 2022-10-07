<?php

namespace App\Http\Controllers\Food;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Food\Product;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    //
    public function index()
    {
        return view('food.product');
    }
    //
    public function rows()
    {
        return Product::paginate(5);
    }
    //
    public function save(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'price' => 'required|numeric',
            'photo' => 'required',
        ]);
        if($request->photo){
            $name = time().$request->name . '.'
                . explode('/'.explode(':',substr($request->photo, 0, strpos($request->photo, ";")))[1])[1];

            Image::make($request->photo)->save(public_path('img/food/').$name);
        }

        $product = Product::create([
            'name' => $request->name,
            'name_kh' => $request->name_kh,
            'price' => $request->price,
            'photo' => $name,
            'dsc' => $request->dsc,
            'category' => $request->category,
        ]);

        return response()->json(['product' => $product]);
    }
}
