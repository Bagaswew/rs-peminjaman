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
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('PENDING', 'APPROVED', 'BORROWED', 'PENDING_RETURN', 'REJECTED', 'RETURNED') DEFAULT 'PENDING'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('PENDING', 'APPROVED', 'BORROWED', 'REJECTED', 'RETURNED') DEFAULT 'PENDING'");
    }
};
