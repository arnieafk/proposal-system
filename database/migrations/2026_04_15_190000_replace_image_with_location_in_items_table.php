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
        if (! Schema::hasColumn('items', 'location')) {
            DB::statement("ALTER TABLE items ADD location VARCHAR(255) NULL AFTER status");
        }

        DB::statement("UPDATE items SET location = 'Location not specified' WHERE location IS NULL OR location = ''");
        DB::statement('ALTER TABLE items MODIFY location VARCHAR(255) NOT NULL');

        if (Schema::hasColumn('items', 'image')) {
            DB::statement('ALTER TABLE items DROP COLUMN image');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('items', 'image')) {
            DB::statement('ALTER TABLE items ADD image VARCHAR(255) NULL AFTER location');
        }

        if (Schema::hasColumn('items', 'location')) {
            DB::statement('ALTER TABLE items DROP COLUMN location');
        }
    }
};
