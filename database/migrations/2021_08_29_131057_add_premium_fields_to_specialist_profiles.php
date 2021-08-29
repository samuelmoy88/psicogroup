<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPremiumFieldsToSpecialistProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specialist_profiles', function (Blueprint $table) {
            $table->boolean('is_premium')->default(0)->after('is_verified');
            $table->timestamp('premium_until')->nullable()->after('is_premium');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specialist_profiles', function (Blueprint $table) {
            $table->dropColumn('is_premium');
            $table->dropColumn('premium_until');
        });
    }
}
