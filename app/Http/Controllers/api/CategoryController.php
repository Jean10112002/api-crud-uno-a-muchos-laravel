<?php

namespace App\Http\Controllers\api;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CategoryController extends Controller
{
    public function index(){
        $categorys = Category::all();
        return response()->json([
            "results" => $categorys
        ], Response::HTTP_OK);
    }
    public function store(Request $request){
        $request->validate([
            "descripcion"=>"required"
        ]);
        $category=Category::create([
            "descripcion"=>$request->descripcion
        ]);
        return response()->json([
            "result"=>$category
        ],Response::HTTP_OK);
    }
    public function show($id){
        $category=Category::findOrFail($id);
        return $category;
    }
    public function update(Request $request,$id){
        $request->validate([
            "descripcion"=>"required"
        ]);
        $category=Category::find($id);
        $category->descripcion=$request->descripcion;
        $category->save();
        return response()->json([
            "result"=>$category
        ],Response::HTTP_OK);
    }
    public function destroy($id){
        $category=Category::findOrFail($id)->delete();
        return response()->json([
            "result"=>"category delete"
        ],Response::HTTP_OK);
    }
}
