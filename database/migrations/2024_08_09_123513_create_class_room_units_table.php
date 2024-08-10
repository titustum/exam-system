<?php

use App\Models\ClassRoom;
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
        Schema::create('class_room_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');//basic, common, core
            $table->text('description')->nullable();
            $table->foreignIdFor(ClassRoom::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_room_units');
    }
};
