<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialist_profile_id')->unsigned();
            $table->foreignId('patient_profile_id')->unsigned();
            $table->tinyInteger('rating');
            $table->boolean('is_recommended')->nullable();
            $table->text('remark')->nullable();
            $table->text('specialist_reply')->nullable();
            $table->boolean('can_change')->default(0);
            $table->boolean('has_been_changed')->default(0);
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
        Schema::dropIfExists('ratings');
    }
}
