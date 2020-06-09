<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsAbsences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_absences', function (Blueprint $table) {
          $table->id();
          $table->integer('student_id')->unsigned();
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
        Schema::dropIfExists('students_absences');
    }
}
