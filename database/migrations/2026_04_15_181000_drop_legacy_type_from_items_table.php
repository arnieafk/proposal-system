<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('items', 'type')) {
            DB::statement('ALTER TABLE items DROP COLUMN type');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('items', 'type')) {
            DB::statement("ALTER TABLE items ADD type VARCHAR(255) NOT NULL DEFAULT 'Found' AFTER description");
        }
    }
};
