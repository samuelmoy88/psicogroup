<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('addresses_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->text('payment_details')->nullable();
            $table->tinyInteger('payment_after_visit')->default(0);
            $table->timestamps();

            $table->foreign('address_id', 'a_id_foreign4')
            ->references('id')
            ->on('addresses')
            ->onDelete('cascade');

            $table->foreign('payment_method_id', 'pm_id_foreign')
            ->references('id')
            ->on('payment_methods')
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
        Schema::dropIfExists('payment_methods');
    }
}
