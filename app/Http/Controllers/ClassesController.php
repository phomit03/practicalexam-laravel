<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    private $_GRID_URL = "/admin/classes-list";

    public function listClasses(Request $request){
/*
        //$classes = Classes::all();    //lấy tất cả select * from

        //$classes = Classes::where('classID','LIKE', 'C8%')->get();  //lọc những ID có chữ C8 đầu tiên

        $classes = Classes::orderBy('className', 'asc')
            ->select('classID', 'className', 'classRoom', 'created_at', 'updated_at')
            //->limit(5)  //lấy 5 thằng đầu
            //->skip(5)   //bỏ qua 5 thằng đầu, lấy 5 thằng tiếp theo
            ->get();
*/

        /*
        with: tra ve 1 ARRAY cac phan tu trong relationship, nghia la 1 class 'co the' tra ve nhieu student (array)... day laf hasMany
        withCount: khong phai relationship, se tra ve mot column la get_students_count(ten-ham_count): da xu li viec dem luon. cung la hasMany nhung tra ve count
        */

        /*
        simplePaginate(6): phan trang, get all database
        */

        $paramName = $request->get('className'); //name input search

        //$classes = Classes::with('getStudents')->simplePaginate(6);
        $classes = Classes::ClassesFilter($paramName)
            ->withCount('getStudents')
            ->simplePaginate(6);

        //dd($classes); //dump();die();

        return view('pages.tables.listClasses', [
            'classes'=>$classes
        ]);
    }

    public function classesForm(){
        return view('pages.forms.classes-forms.classes-create');
    }

    public function classesCreate(Request $request){
        //validate phía backend (có thể validate string|unique:student)
        $request->validate([
            'classID'=>'required|string|unique:classes',
//            'image'=>'image|mines:jpeg,png,jpg,gif' //validate backend
        ]);
        Classes::create(
            [
                'classID'=>$request->get('classID'),    //name input
                'className'=>$request->get('className'),
                'classRoom'=>$request->get('classRoom'),
            ]
        );
        return redirect()->to($this->_GRID_URL); //dieu huong ve list
    }

    public function classesEdit($id){
        $classes = Classes::find($id); //1 obj Student with id

//        dd($classes);

        return view('pages.forms.classes-forms.classes-edit', [
            'classes'=>$classes,
        ]);
    }

    public function classesUpdate(Request $request, Classes $classes){
        $classes->update(
            [
                'className'=>$request->get('className'),    //name input
                'classRoom'=>$request->get('classRoom')
            ]
        );
        return redirect()->to($this->_GRID_URL)->with("success", "Update classes successfully");    //điều hướng về list->alert
    }

    public function classesDelete(Classes $classes){
        try {
            $classes->delete(); //xoá cứng, thẳng vào database
            return redirect()->to($this->_GRID_URL)->with("success", "Delete classes successfully");    //điều hướng về list->alert
        } catch (\Exception $e){
            return redirect()->to($this->_GRID_URL)->with("error", "Delete Failed");
        }
    }
}
