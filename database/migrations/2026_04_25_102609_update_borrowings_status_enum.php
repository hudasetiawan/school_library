<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah enum status agar mendukung alur: pending → disetujui → dikembalikan / ditolak
     */
    public function up(): void
    {
        // MySQL requires ALTER COLUMN for enum changes
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'dipinjam', 'dikembalikan', 'terlambat', 'hilang') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'terlambat', 'hilang') DEFAULT 'dipinjam'");
    }
};
