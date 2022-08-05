<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scores extends Model
{
    use HasFactory;

    protected $table = 'score';
    protected $primaryKey = 'scoreID';
    protected $keyType ='integer';

    protected $fillable = [
        'score',
        'result',
        'studentID',
        'subjectID',
        'created_at',
        'updated_at'
    ];

    /*
        relationship in laravel:
        - 1-> 1: hasOne()
        - 1-> nhieu: hasMany()
        - nhieu -> 1: belongsTo()
        - nhieu -> nhieu: belongsToMany()
    */

    //relationship: tra ve name hien thi
    public function getStudents(){
        //return 1 object trong relationship
        return $this->belongsTo(Student::class, 'studentID', 'studentID');
    }

    public function getSubjects(){
        //return 1 object trong relationship
        return $this->belongsTo(Subject::class, 'subjectID', 'subjectID');
    }

    //filter select
    public function scopeStudentFilter($query, $select=''){
        if ($select != null && $select != ''){
            return $query->where('studentID', $select);
        }
        return $query;
    }

    public function scopeSubjectFilter($query, $select=''){
        if ($select != null && $select != ''){
            return $query->where('subjectID', $select);
        }
        return $query;
    }

    //search
    public function scopeResultSearch($query, $search=''){
        if ($search != null && $search != ''){
            return $query->where('result', 'LIKE', '%'.$search.'%');
        }
        return $query;
    }
}
