<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('confirmation_details')) {
            return;
        }

        Schema::table('confirmation_details', function (Blueprint $table) {
            if (! Schema::hasColumn('confirmation_details', 'godparents')) {
                $table->json('godparents')->nullable()->after('godparent4');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('confirmation_details')) {
            return;
        }

        Schema::table('confirmation_details', function (Blueprint $table) {
            if (Schema::hasColumn('confirmation_details', 'godparents')) {
                $table->dropColumn('godparents');
            }
        });
    }
};
