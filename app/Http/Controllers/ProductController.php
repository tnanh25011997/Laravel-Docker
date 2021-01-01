<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(){
        $product = Product::paginate();
        return ProductResource::collection($product);
    }

    public function show($id){
        $product = Product::find($id);
        return new ProductResource($product);
    }

    public function store(Request $request){

        $product = Product::create($request->only('title','description','image','price'));

        return response($product, Response::HTTP_CREATED);
    }
    public function update(Request $request, $id){
        $product = Product::find($id);
        $product->update($request->only('title','description','image','price'));

        return response($product, Response::HTTP_ACCEPTED);
    }


}
