<?php

namespace App\Http\Controllers\Food;

use App\Food\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){
        return view('food.category');
    }
    public function rows()
    {
        return Category::paginate(5);
    }
}
