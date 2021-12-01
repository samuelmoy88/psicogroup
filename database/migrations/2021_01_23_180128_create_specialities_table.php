<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('profiles_specialities', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('speciality_id');
            $table->string('profile_type', 50);
            $table->timestamps();

            $table->foreign('speciality_id', 's_id_foreign')
                ->references('id')
                ->on('specialities')
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
        Schema::dropIfExists('specialities');
        Schema::dropIfExists('profiles_specialities');
    }
}
