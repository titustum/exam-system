<?php

namespace App\Models;

use App\Models\Course;
use App\Models\ClassRoom;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'admission_number', 'gender',
        'department_id', 'course_id', 'class_room_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function class()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'student_id', 'id');
    }
}
