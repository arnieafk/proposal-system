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
        $driver = DB::getDriverName();

        if ($driver !== 'mysql') {
            return;
        }

        if (Schema::hasColumn('items', 'status') === false) {
            DB::statement("ALTER TABLE items ADD status VARCHAR(20) NULL AFTER description");
        }

        if (Schema::hasColumn('items', 'type')) {
            DB::statement("UPDATE items SET status = LOWER(type) WHERE status IS NULL OR status = ''");
        }

        DB::statement("UPDATE items SET status = 'lost' WHERE status IS NULL OR status = '' OR LOWER(status) NOT IN ('lost', 'found')");
        DB::statement("ALTER TABLE items MODIFY status VARCHAR(20) NOT NULL");

        if (Schema::hasColumn('items', 'description')) {
            DB::statement("UPDATE items SET description = '' WHERE description IS NULL");
            DB::statement('ALTER TABLE items MODIFY description TEXT NOT NULL');
        }

        if (Schema::hasColumn('items', 'price')) {
            DB::statement('ALTER TABLE items DROP COLUMN price');
        }

        if (Schema::hasColumn('items', 'type')) {
            DB::statement('ALTER TABLE items DROP COLUMN type');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver !== 'mysql') {
            return;
        }

        if (! Schema::hasColumn('items', 'type')) {
            DB::statement("ALTER TABLE items ADD type VARCHAR(255) NOT NULL DEFAULT 'Found' AFTER description");
        }

        if (Schema::hasColumn('items', 'status')) {
            DB::statement("UPDATE items SET type = CASE WHEN LOWER(status) = 'lost' THEN 'Lost' ELSE 'Found' END");
            DB::statement('ALTER TABLE items DROP COLUMN status');
        }

        if (! Schema::hasColumn('items', 'price')) {
            DB::statement('ALTER TABLE items ADD price DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER item_name');
        }
    }
};
