<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $primaryKey = 'classID';
    protected $keyType ='string';   //kieu du lieu cua classID

    protected $fillable = [
        "classID",
        "className",
        "classRoom",
        "created_at",
        "updated_at"
    ];

    /*
        relationship in laravel:
        - 1-> 1: hasOne()
        - 1-> nhieu: hasMany()
        - nhieu -> 1: belongsTo()
        - nhieu -> nhieu: belongsToMany()
    */

    public function getStudents(){
        //return 1 array trong relations
        return $this->hasMany(Student::class, 'classID', 'classID');
    }

    public function scopeClassesFilter($query, $search=''){
        if ($search != null && $search != ''){
            return $query->where('className', 'LIKE', '%'.$search.'%');   //nếu ->orWhere('classID') thì sẽ search cả classID
        }
        return $query;
    }
}
