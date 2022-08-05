<?php

namespace App\Http\Controllers;

use App\Models\Scores;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ScoresController extends Controller
{
    private $_GRID_URL = "/admin/scores-list";

    public function listScores(Request $request){
        $paramResult = $request->get('result');
        $paramStudentID = $request->get('studentID'); //name combobox
        $paramSubjectID = $request->get('subjectID'); //name combobox

        $scores = Scores::ResultSearch($paramResult)
            ->StudentFilter($paramStudentID)
            ->SubjectFilter($paramSubjectID)
            ->simplePaginate(6);

        $studentsList = Student::all();
        $subjectsList = Subject::all();

        return view('pages.tables.listScores', [
            'scores' => $scores,
            'studentsList'=>$studentsList,
            'subjectsList'=>$subjectsList
        ]);

    }

    public function scoreForm(){
        $studentsList = Student::all();
        $subjectsList = Subject::all();

        return view('pages.forms.score-forms.score-create',[
            'studentsList'=>$studentsList,
            'subjectsList'=>$subjectsList
        ]);
    }

    public function scoreCreate(Request $request){
        //validate phía backend (có thể validate string|unique:student)
        $request->validate([
            'score'=>'required|integer|',
        ]);
        Scores::create(
            [
                'score'=>$request->get('score'),    //name input
                'result'=>$request->get('result'),
                'studentID'=>$request->get('studentID'),
                'subjectID'=>$request->get('subjectID'),
            ]
        );
        return redirect()->to($this->_GRID_URL);  //điều hướng về list
    }

    public function scoreEdit($id){
        $studentsList = Student::all();
        $subjectsList = Subject::all();
        $score = Scores::find($id);

        return view('pages.forms.score-forms.score-edit', [
            'score'=>$score,
            'studentsList'=>$studentsList,
            'subjectsList'=>$subjectsList
        ]);
    }

    public function scoreUpdate(Request $request, Scores $score){
        //validate phía backend (có thể validate string|unique:student)
        $request->validate([
            'score'=>'required|integer|',
        ]);

        $score->update(
            [
                'score'=>$request->get('score'),    //name input
                'result'=>$request->get('result'),
                'studentID'=>$request->get('studentID'),
                'subjectID'=>$request->get('subjectID'),
            ]
        );
        return redirect()->to($this->_GRID_URL)->with("success", "Update score successfully");    //điều hướng về list->alert
    }

    public function scoreDelete(Scores $score){
        try {
            $score->delete(); //xoá cứng, thẳng vào database
            return redirect()->to($this->_GRID_URL)->with("success", "Delete score successfully");    //điều hướng về list->alert
        } catch (\Exception $e){
            return redirect()->to($this->_GRID_URL)->with("error", "Delete Failed");
        }
    }
}
