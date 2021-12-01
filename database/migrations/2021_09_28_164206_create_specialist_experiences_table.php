<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_profile_id');
            $table->date('start_year');
            $table->date('end_year')->nullable();
            $table->text('job_title');
            $table->text('company_name');
            $table->text('location');
            $table->boolean('current_job')->nullable();
            $table->timestamps();

            $table->foreign('specialist_profile_id', 'sp_id_foreign_7')
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
        Schema::dropIfExists('specialist_experiences');
    }
}
