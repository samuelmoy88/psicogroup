<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_feedback', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->boolean('status')->default(1);
            $table->string('type', 15);
            $table->integer('order')->nullable();
            $table->timestamps();
        });

        Schema::create('rating_rating_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rating_id');
            $table->unsignedBigInteger('rating_feedback_id');

            $table->foreign('rating_id')
                ->references('id')
                ->on('ratings')
                ->onDelete('cascade');

            $table->foreign('rating_feedback_id')
                ->references('id')
                ->on('rating_feedback')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_rating_feedback');
        Schema::dropIfExists('rating_feedback');
    }
}
