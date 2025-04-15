<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ProductRequest;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
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
        return view('products.index', ['products'=>$products, 'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.form', ["categories"=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()->route('products.view', ['id' => $product->id])->with('success', 'Product \''.$product->product_name.'\' created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.view', ["product"=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('products.form', ["product"=>$product, "categories"=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return redirect()->route('products.view', ['id' => $id])->with('success', 'Product \''.$product['product_name'].'\' updated successfully!');
    }

    public function delete(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => Product::STATUS_DELETED]);

        return redirect()->route('home')->with('success', 'Product \''.$product->product_name.'\' deleted successfully!');
    }

    public function bulk_delete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id'
        ]);

        Product::whereIn('id', $request->ids)
           ->update(['status' => Product::STATUS_DELETED]);

        return redirect()->route('home')->with('success', 'Bulk deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }
}
