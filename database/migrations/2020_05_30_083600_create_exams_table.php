<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_category_id');
            // $table->foreignId('class_category_id')
            //     ->constrained()
            //     ->cascadeOnDelete();

            $table->string('name');
            $table->float('possible');
            $table->longText('description')->nullable();
            $table->json('qa')->nullable();
            $table->unsignedTinyInteger('attempt')->default(0);

            $table->timestamp('publishes_at')->nullable();
            $table->timestamp('due_at')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
