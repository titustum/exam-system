<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoomUnit extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'type', 'class_room_id',
    ];
}
