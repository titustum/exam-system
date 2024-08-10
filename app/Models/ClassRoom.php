<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'description',
        'department_id', 'course_id'
    ];

    public function units()
    {
        return $this->hasMany(ClassRoomUnit::class, 'class_room_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_room_id', 'id');
    }

}
