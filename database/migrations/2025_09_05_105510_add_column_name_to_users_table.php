<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->string('first_name')->nullable()->after('name');
             $table->string('last_name')->nullable()->after('first_name');
             $table->string('profile_name')->nullable()->after('last_name');
        
             $table->string('country_code')->nullable()->after('profile_name');
             $table->string('mobile_no')->nullable()->after('country_code');
             $table->string('password')->nullable()->after('mobile_no');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
