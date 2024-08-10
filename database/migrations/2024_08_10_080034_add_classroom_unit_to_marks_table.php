<?php

use App\Models\ClassRoomUnit;
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
        Schema::table('marks', function (Blueprint $table) {
            $table->foreignIdFor(ClassRoomUnit::class)->constrained()->after('percentage_score');
        });
    }

    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            $table->dropForeign(['class_room_unit_id']); // Adjust column name if necessary
            $table->dropColumn('class_room_unit_id'); // Adjust column name if necessary
        });
    }

};
