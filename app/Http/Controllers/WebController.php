<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Scores;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebController extends Controller
{
    //home (cache: cho user)
    public function home(){
        if (!Cache::has('home_data')){
            $classes = Classes::all();
            $student = Student::all();
            $subject = Subject::all();
            $score = Scores::all();

            $home_data = [
                'classes'=>$classes,
                'student'=>$student,
                'subject'=>$subject,
                'score'=>$score
            ];

            //catching
            //Cache::put('home_data', $home_data, Carbon::now()->addMinutes(3));  //'key', value, time het han/ cache co time

            Cache::forever('home_data', $home_data);    //forever: cache vinh vien, khong thoi han
        }
        return view('welcome', Cache::get('home_data'));
    }


    public function aboutUs(){
        return view('about-us');
    }

    public function apiStudent(Request $request){
        $limit = $request->has('limit') ? $request->has('limit') : 20;
        $page = $request->has('page') ? $request->has('page') : 1;
        $offset = ($page-1)*$limit;
        $student = Student::skip($offset)
            ->limit($limit)
            ->select('*')->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'datas' => $student
        ]);
    }
}
