<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_profile_id');
            $table->smallInteger('level')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('institution', 100);
            $table->year('start');
            $table->year('end');
            $table->text('description')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->timestamps();

            $table->foreign('specialist_profile_id', 'sp_id_foreign_4')
                ->references('id')
                ->on('specialist_profiles')
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
        Schema::dropIfExists('specialist_education');
    }
}
