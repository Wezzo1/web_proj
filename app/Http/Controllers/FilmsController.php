<?php

namespace App\Http\Controllers;

use App\Models\Films;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmsController extends Controller
{

    public function getFilm(Request $request)
    {
        $filmcs = Films::with('categoryFilms')->where('FilmName','like','%'.$request->FilmName.'%')->where('show','like','%'.$request->show.'%')->get();
        return response()->json($filmcs);
    }


    public function create()
    {
        //
    }

    public function Login(Request $request)
    {
        $person= User::where('email',$request->email)->first();
        if (!$person){
            return response()->json(['msg' => 'الايميل خاطئ '],401);
        }
        $person= User::where('password',$request->password)->first();
        if ($person){
            $token=$person->createToken('Laravel Password Grant Client')->accessToken;
            $response =['token'=>$token];
            return  response($response,200);
        }else{
            $response =   ['msg' => ' كلمة المرور خاطئة '];
            return  response($response,422);
        }

    }


    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'FilmName' => 'required|unique:films',
            'categoryid' => 'required|numeric',
            'FilmDetails' => 'required',
            'show' => 'required|date',
            'img' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
        ], [],[
            'FilmName'=> 'اسم الفيلم',
            'categoryid'=>'رقم التصنيف',
            'FilmDetails'=>'التفاصيل :',
            'show'=>'تاريخ العرض',
            'img' => 'صورة الفيلم',

        ]);

        if ($validated->fails()) {
            $msg = "تاكد من صحة البيانات المرسلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }


        if ($request->hasFile('img')){
            $file=$request->file('img');
            $image_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$image_name;
            $file->move(public_path('images'),$image_name);
        }
        $film = new Films();
        $film->FilmName = $request->FilmName;
        $film->categoryid  = $request->categoryid;
        $film->FilmDetails = $request->FilmDetails;
        $film->FilmRatting = $request->FilmRatting;
        $film->img = $path;
        $film->show = $request->show;
        $film->save();
        return response()->json(['msg' => 'تمت الاضافة بحمد الله']);
    }




    public function show($id)
    {

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'FilmName' => 'sometimes|required|unique:films,FilmName, '.$id,
            'categoryid' => 'required|numeric',
            'FilmDetails' => 'required',
            'show' => 'required|date',
            'img' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000',
        ], [],[
            'FilmName'=> 'اسم الفيلم',
            'categoryid'=>'رقم التصنيف',
            'FilmDetails'=>'التفاصيل :',
            'show'=>'تاريخ العرض',
            'img' => 'صورة الفيلم',

        ]);

        if ($validated->fails()) {
            $msg = "تاكد من صحة البيانات المرسلة";
            $data = $validated->errors();
            return response()->json(compact('msg', 'data'), 422);
        }


        if ($request->hasFile('img')){
            $file=$request->file('img');
            $image_name=time().'.'.$file->getClientOriginalExtension();
            $path='images'.'/'.$image_name;
            $file->move(public_path('images'),$image_name);
        }
        $film = Films::Find($id);
        $film->FilmName = $request->FilmName;
        $film->categoryid  = $request->categoryid;
        $film->FilmDetails = $request->FilmDetails;
        $film->FilmRatting = $request->FilmRatting;
        $film->img = $path;
        $film->show = $request->show;
        $film->save();
        return response()->json(['msg' => 'تمت التعديل بحمد الله']);
    }

    public function delete($id)
    {
        $del=Films::Find($id);
        $result=$del->delete();
        if ($result){
            return response()->json(['result' => 'نجحت المهمة']);
        }else{
            return response()->json(['result' => 'فشلت المهمة ']);
        }
    }

    public function destroy($id)
    {
        //
    }
}
