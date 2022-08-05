<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';
    protected $primaryKey = 'subjectID';
    protected $keyType = 'string';  //kiểu dữ liệu subjectID

    protected $fillable = [
        'subjectID',    //ID subject không tự động tăng nên cho vào fillable để create
        'subjectName',
        'created_at',
        'updated_at'
    ];

    public function scopeSubjectFilter($query, $search=''){
        if ($search != null && $search != ''){
            return $query->where('subjectName', 'LIKE', '%'.$search.'%');   //nếu ->orWhere('classID') thì sẽ search cả classID
        }
        return $query;
    }
}
