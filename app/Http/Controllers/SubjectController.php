<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $_GRID_URL = "/admin/subjects-list";

    public function listSubjects(Request $request){
        $paramName = $request->get('subjectName'); //name input search

        $subject = Subject::SubjectFilter($paramName)->simplePaginate(6);

//        dd($subject);

        return view('pages.tables.listSubjects', [
            'subject' => $subject,
        ]);
    }

    public function subjectForm(){
        return view('pages.forms.subject-forms.subject-create');
    }

    public function subjectCreate(Request $request){
        Subject::create(
            [
                'subjectID'=>$request->get('subjectID'),    //name input
                'subjectName'=>$request->get('subjectName')
            ]
        );
        return redirect()->to($this->_GRID_URL);    //điều hướng về list
    }

    public function subjectEdit($id){
        $subject = Subject::find($id);

        return view('pages.forms.subject-forms.subject-edit', [
            'subject'=>$subject
        ]);
    }

    public function subjectUpdate(Request $request, Subject $subject){
        $subject->update(
            [
                'subjectName'=>$request->get('subjectName') //name input
            ]
        );
        return redirect()->to($this->_GRID_URL)->with("success", "Update subject successfully");    //điều hướng về list->alert
    }

    public function subjectDelete(Subject $subject){
        try {
            $subject->delete(); //xoá cứng, thẳng vào database
            return redirect()->to($this->_GRID_URL)->with("success", "Delete subject successfully");    //điều hướng về list->alert
        } catch (\Exception $e){
            return redirect()->to($this->_GRID_URL)->with("error", "Delete Failed");
        }
    }
}
