<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_profile_id');
            $table->date('expedition_date');
            $table->date('expiration_date')->nullable();
            $table->text('name');
            $table->text('company_name');
            $table->text('location')->nullable();
            $table->boolean('expires')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->timestamps();

            $table->foreign('specialist_profile_id', 'sp_id_foreign_9')
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
        Schema::dropIfExists('specialist_certificates');
    }
}
