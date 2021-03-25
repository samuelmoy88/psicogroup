<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('services_specialist_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialist_profile_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('price_from')->default(0);
            $table->integer('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('specialist_profile_id', 'sp_id_foreign3')
                ->references('id')
                ->on('specialist_profiles')
                ->onDelete('cascade');

            $table->foreign('service_id', 's_id_foreign2')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });

        Schema::create('addresses_services_specialist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('specialist_profile_service_id');

            $table->foreign('address_id', 'a_id_foreign2')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');

            $table->foreign('specialist_profile_service_id', 'ssp_id_foreign')
                ->references('id')
                ->on('services_specialist_profiles')
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
        Schema::dropIfExists('addresses_services_specialist_profiles');
        Schema::dropIfExists('services_specialist_profiles');
        Schema::dropIfExists('services');
    }
}
