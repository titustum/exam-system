<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    public $fillable = [
        'student_score',
        'maximum_score',
        'percentage_score',
        'student_id',
        'exam_id',
        'class_room_unit_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
