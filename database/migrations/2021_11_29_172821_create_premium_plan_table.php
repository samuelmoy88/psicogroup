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
            $table->integer('price');
            $table->string('currency');
            $table->float('discount')->nullable();
            $table->timestamp('discount_until')->nullable();
            $table->tinyInteger('order')->nullable();
            $table->tinyInteger('status')->default(1);
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

        \Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--class' => 'PremiumPlanSeeder',
            '--force' => true
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('premium_plan_features');
        Schema::dropIfExists('premium_plans');
    }
}
