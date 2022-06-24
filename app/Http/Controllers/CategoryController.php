<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {

    }

    public function getCategory()
    {
        $catig= category::with('filmss')->get();
        return response()->json($catig);

    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'CategoriesName' => 'required|unique:categories',
        ], [],[
            'CategoriesName'=> 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }
        $category = new category();
        $category->CategoriesName = $request->CategoriesName;
        $category->save();
        return response()->json(['msg' => 'تمت الاضافة بنجاح']);
    }

    public function delete($id)
    {
        $del=category::Find($id);
        $res=$del->delete();
        if ($res){
            return response()->json(['msg' => 'تم الحذف']);
        }else{
            return response()->json(['msg' => 'لم يتم الحذف']);
        }
    }


    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'CategoriesName' => 'sometimes|required|unique:categories,CategoriesName, '.$id,
        ], [],[
            'CategoriesName'=> 'اسم التصنيف',
        ]);

        if ($validated->fails()) {
            $msg = "تاكد من البيانات المدخلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }
        $category =category::Find($id);
        $category->CategoriesName = $request->CategoriesName;
        $category->save();
        return response()->json(['msg' => 'تمت عملية التعديل بنجاح']);
    }


    public function destroy($id)
    {
        //
    }
}
