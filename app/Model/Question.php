<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'title', 'order', 'degree', 'examId'
    ];

    public function exam()
    {
        return $this->belongsTo('App\Model\Exam', 'examId', 'id');
    }

    public function answers()
    {
        return $this->hasMany('App\Model\Answer', 'questionId', 'id')->orderBy('order');
    }
}
