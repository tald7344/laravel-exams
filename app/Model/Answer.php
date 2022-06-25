<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'title', 'order', 'status', 'examId', 'questionId'
    ];

    public function exam()
    {
        return $this->belongsTo('App\Model\Exam', 'examId', 'id');
    }

    public function question()
    {
        return $this->belongsTo('App\Model\Question', 'questionId', 'id');
    }
}
