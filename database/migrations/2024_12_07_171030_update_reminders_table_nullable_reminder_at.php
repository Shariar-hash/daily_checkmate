<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;




class UpdateRemindersTableNullableReminderAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Alter the reminder_at column to be nullable
            $table->dateTime('reminder_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reminders', function (Blueprint $table) {
            // Revert the reminder_at column to not nullable
            $table->dateTime('reminder_at')->nullable(false)->change();
        });
    }
}
