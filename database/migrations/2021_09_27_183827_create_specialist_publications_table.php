<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->string('profile_type', 50);
            $table->year('year')->nullable();
            $table->text('title');
            $table->string('url', 100)->nullable();
            $table->tinyInteger('order')->nullable();
            $table->timestamps();

            $table->foreign('profile_id', 'sp_id_foreign_5')
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
        Schema::dropIfExists('specialist_publications');
    }
}
