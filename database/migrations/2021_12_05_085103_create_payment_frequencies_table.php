<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentFrequenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_frequencies', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('frequency');
            $table->tinyInteger('coefficient');
            $table->timestamps();
        });

        Schema::create('premium_plan_payment_frequency', function (Blueprint $table) {
            $table->foreignId('premium_plan_id')->constrained();
            $table->foreignId('payment_frequency_id')->constrained();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'PaymentFrequenciesSeeder',
            '--force' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premium_plan_payment_frequency');
        Schema::dropIfExists('payment_frequencies');
    }
}
