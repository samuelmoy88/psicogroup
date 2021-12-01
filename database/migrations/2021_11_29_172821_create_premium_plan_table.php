<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiumPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('payment_mode');
            $table->integer('price');
            $table->tinyInteger('order')->nullable();
            $table->timestamps();
        });

        Schema::create('premium_plan_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('premium_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('premium_id')
                ->on('premium_plans')
                ->references('id')
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
        Schema::dropIfExists('premium_plan_features');
        Schema::dropIfExists('premium_plan');
    }
}
