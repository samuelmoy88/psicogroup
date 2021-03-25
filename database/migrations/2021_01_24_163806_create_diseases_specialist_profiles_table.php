<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseasesSpecialistProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases_specialist_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_profile_id');
            $table->unsignedBigInteger('disease_id');
            $table->timestamps();

            $table->foreign('specialist_profile_id', 'sp_id_foreign_2')
                ->references('id')
                ->on('specialist_profiles')
                ->onDelete('cascade');

            $table->foreign('disease_id', 'd_id_foreign')
                ->references('id')
                ->on('diseases')
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
        Schema::dropIfExists('diseases_specialist_profiles');
    }
}
