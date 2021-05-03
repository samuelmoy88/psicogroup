<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineConsultationPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_consultation_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('addresses_online_consultation_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('online_consultation_platform_id');

            $table->foreign('address_id', 'a_id_foreign5')
                ->references('id')
                ->on('addresses')
                ->onDelete('cascade');

            $table->foreign('online_consultation_platform_id', 'ocp_id_foreign')
                ->references('id')
                ->on('online_consultation_platforms')
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
        Schema::dropIfExists('addresses_online_consultation_platforms');
        Schema::dropIfExists('online_consultation_platforms');
    }
}
