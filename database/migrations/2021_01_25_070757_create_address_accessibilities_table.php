<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressAccessibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_accessibilities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('addresses_address_accessibilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('address_accessibility_id');

            $table->foreign('address_id', 'a_id_foreign')
            ->references('id')
            ->on('addresses')
            ->onDelete('cascade');

            $table->foreign('address_accessibility_id', 'aa_id_foreign')
                ->references('id')
                ->on('address_accessibilities')
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
        Schema::dropIfExists('addresses_address_accessibilities');
        Schema::dropIfExists('address_accessibilities');
    }
}
