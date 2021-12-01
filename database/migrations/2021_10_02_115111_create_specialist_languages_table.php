<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('profile_type', 50);
            $table->string('language', 3);
            $table->tinyInteger('proficiency')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->timestamps();

            $table->foreign('profile_id', 'sp_id_foreign_8')
                ->references('profile_id')
                ->on('users')
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
        Schema::dropIfExists('specialist_languages');
    }
}
