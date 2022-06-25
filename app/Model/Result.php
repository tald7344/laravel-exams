<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'studentId', 'examId', 'questionId', 'answerId', 'degree'
    ];

    public function student()
    {
        return $this->belongsTo('App\Model\Student', 'studentId', 'id');
    }
}
