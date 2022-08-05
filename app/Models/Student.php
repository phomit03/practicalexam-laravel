<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';
    protected $primaryKey = 'studentID';
    protected $keyType ='string';

    protected $fillable = [
        'studentID',    //do key: string -> add ID vào fillable để post dữ liệu từ input
        'studentName',
        'birthday',
        'image',
        'classID',
        'created_at',
        'updated_at'
    ];

    /* relationship in laravel:
        - 1 -> 1: hasOne()
        - 1 -> nhieu: hasMany()
        - nhieu -> 1: belongsTo()
        - nhieu -> nhieu: belongsToMany() */

    public function getClasses(){
        //return 1 object trong relationship
        return $this->belongsTo(Classes::class, 'classID', 'classID');
    }

    //search sẽ xử lí việc lọc, nếu phải lọc nhiều cái
    public function scopeFilter($query, $search=''){  //name giá trị mặc định ban đầu
        if ($search != null && $search != ''){
            return $query->where('studentName', 'LIKE', '%'.$search.'%');   //nếu ->orWhere('studentID') thì sẽ search cả studentID
        }
        return $query;
    }

    //filter select
    public function scopeClassFilter($query, $select=''){
        if ($select != null && $select != ''){
            return $query->where('classID', $select);
        }
        return $query;
    }

    //filter form date (date duoc filter -> )
    public function scopeBirthdayFrom($query, $from_date=''){
        if ($from_date != null && $from_date != '') {
            return $query->where('birthday', '>=', $from_date);
        }
        return $query;
    }

    //filter to date ( <- date duoc filter)
    public function scopeBirthdayTo($query, $to_date=''){
        if ($to_date != null && $to_date != '') {
            return $query->where('birthday', '<=', $to_date);
        }
        return $query;
    }

    //img default
    public function getImage(){
        if ($this->image){
            return $this->image;
        }
        return 'uploads/img_default.png';
    }
}
