<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    public function index(){
        $products=Product::all();
        return response()->json([
            "results"=>$products
        ],Response::HTTP_OK);
    }
    public function store(Request $request){
        $request->validate([
            "descripcion"=>"required|string",
            "stock"=>"required|numeric|min:0",
            "category_id"=>"required",
        ]);
        $category=Category::findOrFail($request->category_id);
        $product=$category->productos()->create([
            'descripcion'=>$request->descripcion,
            'stock'=>$request->stock
        ]);
        return response()->json([
            "result"=>$product
        ],Response::HTTP_OK);
    }
    public function show($id){
        $product=Product::findOrFail($id);
        return response()->json([
            "result" => [$product,$product->categorias]
        ], Response::HTTP_OK);
    }
    public function update(Request $request,$id){
        $request->validate([
            "descripcion"=>"required|string",
            "stock"=>"required|numeric|min:0",
            "category_id"=>"required"
        ]);
        $category=Category::findOrFail($request->category_id);
        $product=$category->productos()->where('id',$id)->update([
            'descripcion'=>$request->descripcion,
            'stock'=>$request->stock
        ]);
        return response()->json([
            "message"=>"product update",
            "result"=>$product
        ],Response::HTTP_OK);
    }
    public function destroy($id){
        Product::findOrFail($id)->delete();
        return response()->json([
            "message" => "¡Product deleted!"
        ], Response::HTTP_OK);
    }
}
