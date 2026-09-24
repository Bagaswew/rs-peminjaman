<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, the safest way to update an ENUM column without losing data
        // is to use a raw ALTER TABLE query.
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('PENDING', 'APPROVED', 'BORROWED', 'REJECTED', 'RETURNED') DEFAULT 'PENDING'");
        DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('AVAILABLE', 'BORROWED', 'MAINTENANCE', 'BROKEN', 'LOST') DEFAULT 'AVAILABLE'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('PENDING', 'APPROVED', 'REJECTED', 'RETURNED') DEFAULT 'PENDING'");
        DB::statement("ALTER TABLE assets MODIFY COLUMN status ENUM('AVAILABLE', 'BORROWED', 'MAINTENANCE') DEFAULT 'AVAILABLE'");
    }
};
