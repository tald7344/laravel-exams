<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $table = 'to_do';
    public $fillable = [
        'content_ar',
        'content_en',
        'description_ar',
        'description_en',
        'isDone',
        'deadline',
    ];
}
