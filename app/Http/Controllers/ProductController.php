<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(){
        \Gate::authorize('view','products');
        $product = Product::paginate();
        return ProductResource::collection($product);
    }

    public function show($id){
        \Gate::authorize('view','products');
        $product = Product::find($id);
        return new ProductResource($product);
    }

    public function store(Request $request){
        \Gate::authorize('edit','products');
        $product = Product::create($request->only('title','description','image','price'));

        return response($product, Response::HTTP_CREATED);
    }
    public function update(Request $request, $id){
        \Gate::authorize('edit','products');
        $product = Product::find($id);
        $product->update($request->only('title','description','image','price'));

        return response($product, Response::HTTP_ACCEPTED);
    }


}
