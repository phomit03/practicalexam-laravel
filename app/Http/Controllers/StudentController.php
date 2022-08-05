<?php

namespace App\Http\Controllers;

use App\Events\CreateAStudent;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StudentController extends Controller
{
    private $_GRID_URL = "/admin/students-list";

    public function listStudents(Request $request) {
/*
        //Classes::query()->getQuery()->from: lấy ra bảng table
        $classTable = Classes::query()->getQuery()->from;
        $studentTable = Student::query()->getQuery()->from;

        //lấy tên hiển thị thay cho ID theo kiểu truy vấn database
        $student = Student::leftJoin($classTable, $studentTable.'.classID', '=', $classTable.'.classID')
            ->SELECT($studentTable.'.*', $classTable.'.className as className', $classTable.'.classRoom')
            ->simplePaginate(6); //get all array, phân trang
*/
        $paramName = $request->get('name'); //name input search
        $paramclassID = $request->get('classID'); //name combobox
        $paramBirthStart = $request->get('birth_start');
        $paramBirthEnd = $request->get('birth_end');

        //with: tra ve 1 OBJECT trong relationship, nghia la nhieu student 'chi' tra ve 1 class (obj)...
        //simplePaginate(6): phan trang,  get all database
        //ClassFilter, Filter là func của controller, bỏ scope (khoá phạm vi)
        $student = Student::ClassFilter($paramclassID)
            ->BirthdayFrom($paramBirthStart)
            ->BirthdayTo($paramBirthEnd)
            ->Filter($paramName)
            ->with('getClasses')
            ->simplePaginate(6);

        //dd($student);   //dump();die();

        $classesList = Classes::all();
        return view('pages.tables.listStudents', [
            'student' => $student,
            'classesList'=> $classesList
        ]);
    }

    //form-create
    public function studentForm(){
        $classesList = Classes::all();
        return view('pages.forms.student-forms.student-create', [
            'classesList'=>$classesList
        ]);
    }

    //post-create
    protected function studentCreate(Request $request){
        //validate phía backend (có thể validate string|unique:student)
        $request->validate([
            'studentID'=>'required|string|unique:student',
//            'image'=>'image|mines:jpeg,png,jpg,gif' //validate backend
        ], [
//            'required'=>'vui lòng nhập đầy đủ thông tin'  //required all input
//            'mines'=>'vui lòng nhập đúng định dạng'
        ]);

        //upload file image
        $image = null;
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $path = "uploads/";
            $fileName = time().rand(0,9).$file->getClientOriginalName();    //tránh upload 2 ảnh cùng tên
            $file->move($path,$fileName);
            $image = $path.$fileName;   //link file
        }

        //dd($request->all());
        $student = Student::create(
            [
                'studentID'=>$request->get('studentID'),    //name input
                'studentName'=>$request->get('studentName'),
                'birthday'=>$request->get('birthday'),
                'image'=>$image,
                'classID'=>$request->get('classID')
            ]
        );

        //bat su kien
        event(new CreateAStudent($student));

        //die('done');
        return redirect()->to($this->_GRID_URL);    //điều hướng về list
    }

    //form-edit
    public function studentEdit($id){
        $classesList = Classes::all();

        $student = Student::find($id); //1 obj Student with id

//        dd($student);

        return view('pages.forms.student-forms.student-edit', [
            'student'=>$student,
            'classesList'=>$classesList
        ]);
    }

    /* cách1: truyền vào id
     * public function studentUpdate(Request $request, Student $student){
        $student = Student::find($id); //tim cac sv trong database (truyen id)

        $student->update(
            [
                'studentName'=>$request->get('studentName'),
                'birthday'=>$request->get('birthday'),
                'classID'=>$request->get('classID')
            ]
        );
        return redirect()->to($this->_GRID_URL);    //điều hướng về list
    }*/


    //update(truyen vao 1 object)
    public function studentUpdate(Request $request, Student $student){
        //upload file image
        $image = $student->image;   //get image
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $path = "uploads/";
            $fileName = time().rand(0,9).$file->getClientOriginalName();    //tránh upload 2 ảnh cùng tên
            $file->move($path,$fileName);
            $image = $path.$fileName;   //link file
        }

        $student->update(
            [
                'studentName'=>$request->get('studentName'),
                'birthday'=>$request->get('birthday'),
                'image'=>$image,
                'classID'=>$request->get('classID')
            ]
        );
        return redirect()->to($this->_GRID_URL)->with("success", "Update student successfully");    //điều hướng về list->alert
    }

    //delete
    public function studentDelete(Student $student){
        try {
            $student->delete(); //xoá cứng, thẳng vào database
            return redirect()->to($this->_GRID_URL)->with("success", "Delete student successfully");    //điều hướng về list->alert
        } catch (\Exception $e){
            return redirect()->to($this->_GRID_URL)->with("error", "Delete Failed");
        }
    }

}
