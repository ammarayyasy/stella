<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Category $category){
        $categories = Category::all();
        $products = Product::where('category_id', $category->id)->latest()->get();
        return view('product', compact('products', 'categories', 'category'));
    }
}
