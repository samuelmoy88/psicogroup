<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rating_id')->constrained();
            $table->string('requested_by', 100);
            $table->string('state', 15);
            $table->text('user_feedback')->nullable();
            $table->text('admin_feedback')->nullable();
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
        Schema::dropIfExists('rating_disputes');
    }
}
