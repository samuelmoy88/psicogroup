<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUneasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uneasiness', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
        });

        Schema::create('uneasiness_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uneasiness_id')
                ->references('id')
                ->on('uneasiness')
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profile_type', 100)->index('profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uneasiness_users');
        Schema::dropIfExists('uneasiness');
    }
}
