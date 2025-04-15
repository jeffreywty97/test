<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', '=', Product::STATUS_ACTIVE);

        if ($request->has('enabled') && in_array($request->enabled, ['0', '1'])) {
            $query->where('enabled', $request->enabled);
        }

        if ($request->has('category_id') && isset($request->category_id) ) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('name') && $request->name !== '') {
            $query->where('product_name', 'like', '%' . $request->name . '%');
        }

        $products = $query->paginate(5);
        $categories = Category::all();
        return view('home', ['products'=>$products, 'categories'=>$categories]);
    }
}
