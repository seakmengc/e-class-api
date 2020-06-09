<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAbsences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('students_absences', function (Blueprint $table) {
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');
         $table->boolean('has_permission');
         $table->foreignId('class_attendance_id')
              ->constrained()
              ->onDelete('cascade');
         $table->text('reason');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_absences');
    }
}