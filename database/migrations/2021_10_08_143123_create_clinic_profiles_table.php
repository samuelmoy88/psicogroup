<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('city', 50);
            $table->string('specialists_volume', 50);
            $table->text('about')->nullable();
            $table->text('our_offer')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_premium')->default(0);
            $table->timestamp('premium_until')->nullable();
            $table->timestamps();
        });

        Schema::create('clinic_specialists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('specialist_id');
            $table->boolean('is_premium')->default(0);
            $table->string('state', 50);
            $table->string('invitation_token', 50);
            $table->string('started_by', 50);
            $table->timestamps();

            $table->foreign('clinic_id')
                ->references('id')
                ->on('clinic_profiles')
                ->onDelete('cascade');

            $table->foreign('specialist_id')
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
        Schema::dropIfExists('clinic_profiles');
    }
}
