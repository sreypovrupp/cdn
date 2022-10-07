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
        return Product::orderBy('id','desc')->paginate(5);
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
            $name = now()->format('dmY.His'). '-' . time().$request->name . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ";")))[1])[1];

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
    //
    public function update(Request $request, $id){
        $product = Product::find($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'name_kh' => 'required|string|max:255',
            'price' => 'required|numeric',
            'photo' => 'required',
        ]);

        $curPhoto = $product->photo;

        if($request->photo != $curPhoto){
            $name = now()->format('dmY.His'). '-' . time().$request->name . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ";")))[1])[1];
            Image::make($request->photo)->save(public_path('img/food/').$name);
            $request->merge(['photo' => $name]);

            $photo = public_path('img/food/').$curPhoto;
            if (file_exists($photo)){
                @unlink($photo);
            }
        }

        $product->update($request->all());

        return response()->json(['product' => $product]);
    }
}
