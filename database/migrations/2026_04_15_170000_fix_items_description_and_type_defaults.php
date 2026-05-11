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
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE items MODIFY description TEXT NULL');
            DB::statement("ALTER TABLE items MODIFY type VARCHAR(255) NOT NULL DEFAULT 'Found'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("UPDATE items SET description = '' WHERE description IS NULL");
            DB::statement('ALTER TABLE items MODIFY description TEXT NOT NULL');
            DB::statement('ALTER TABLE items MODIFY type VARCHAR(255) NOT NULL');
        }
    }
};
