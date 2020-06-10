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
            $table->foreignId('class_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->float('possible');
            $table->longText('description')->nullable();
            $table->json('qa');
            $table->unsignedInteger('attempts')->default(1);

            $table->timestamp('publishes_at')->useCurrent();
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