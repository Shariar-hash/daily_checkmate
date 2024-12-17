<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHabitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->string('title'); // Add title column
            $table->string('frequency');
            $table->text('description')->nullable();// Add frequency column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('frequency');
            $table->text('description')->nullable();
        });
    }
}
