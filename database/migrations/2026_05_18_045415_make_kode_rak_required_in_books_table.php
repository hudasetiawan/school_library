<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing NULL values to '-'
        DB::table('books')->whereNull('kode_rak')->update(['kode_rak' => '-']);

        Schema::table('books', function (Blueprint $table) {
            $table->string('kode_rak', 50)->default('-')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('kode_rak', 50)->nullable()->change();
        });
    }
};
