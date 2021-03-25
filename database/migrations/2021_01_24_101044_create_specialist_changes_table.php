<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_profile_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialist_profile_id')->constrained();
            $table->foreignId('admin_profile_id')->nullable()->constrained();
            $table->string('field');
            $table->string('old_value')->nullable();
            $table->string('new_value');
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialist_profile_changes');
    }
}
