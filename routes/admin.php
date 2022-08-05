<?php
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScoresController;

use Illuminate\Support\Facades\Route;

//routing form create
Route::get('/classes-create', [ClassesController::class, 'classesForm']);   //hiển thị giao diện
Route::post('/classes-create', [ClassesController::class, 'classesCreate']);    //post dữ liệu từ input

Route::get('/student-create', [StudentController::class, 'studentForm']);
Route::post('/student-create', [StudentController::class, 'studentCreate']);

Route::get('/subject-create', [SubjectController::class, 'subjectForm']);
Route::post('/subject-create', [SubjectController::class, 'subjectCreate']);

Route::get('/score-create', [ScoresController::class, 'scoreForm']);
Route::post('/score-create', [ScoresController::class, 'scoreCreate']);

//edit-delete
Route::get('/classes-edit/{id}', [ClassesController::class, 'classesEdit']);
Route::put('/classes-edit/{classes:classID}', [ClassesController::class, 'classesUpdate']);
Route::delete('/classes-delete/{classes}', [ClassesController::class, 'classesDelete']);

Route::get('/student-edit/{id}', [StudentController::class, 'studentEdit']);    //truyen vao id lay studentID
//Route::put('/student-edit/{id}', [StudentController::class, 'studentUpdate']);    //c1: truyen id
Route::put('/student-edit/{student:studentID}', [StudentController::class, 'studentUpdate']);   //c2: truyen vao obj
Route::delete('/student-delete/{student}', [StudentController::class, 'studentDelete']);

Route::get('/subject-edit/{id}', [SubjectController::class, 'subjectEdit']);
Route::put('/subject-edit/{subject:subjectID}', [SubjectController::class, 'subjectUpdate']);
Route::delete('/subject-delete/{subject}', [SubjectController::class, 'subjectDelete']);

Route::get('/score-edit/{id}', [ScoresController::class, 'scoreEdit']);
Route::put('/score-edit/{score:scoreID}', [ScoresController::class, 'scoreUpdate']);
Route::delete('/score-delete/{score}', [ScoresController::class, 'scoreDelete']);

//routing tables
Route::get('/classes-list', [ClassesController::class, 'listClasses']);//->middleware("isAdmin");//nếu không dùng middle ngoài
Route::get('/students-list', [StudentController::class, 'listStudents']);
Route::get('/subjects-list', [SubjectController::class, 'listSubjects']);
Route::get('/scores-list', [ScoresController::class, 'listScores']);

//student group dùng cho route: student/student-edit, student/student-create...
//prefix=>student:
//middleware: cho group
/*
    Route::group(['prefix'=>'student', 'middleware'=>'isAdmin'], function() {

    });
*/
