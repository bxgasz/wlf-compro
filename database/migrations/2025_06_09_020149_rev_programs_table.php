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
        Schema::table('programs', function (Blueprint $table) {
            $table->datetime('start_date')->nullable()->change();
            $table->datetime('end_date')->nullable()->change();
            $table->string('document')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->string('implementing_partner')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->datetime('start_date')->change();
            $table->datetime('end_date')->change();
            $table->string('document')->change();
            $table->string('location')->change();
            $table->string('implementing_partner')->change();
        });
    }
};
