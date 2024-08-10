<?php

use App\Models\Course;
use App\Models\ClassRoom;
use App\Models\Department;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('admission_number');
            $table->string('gender');
            $table->foreignIdFor(Department::class)->constrained();
            $table->foreignIdFor(Course::class)->constrained();
            $table->foreignIdFor(ClassRoom::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
