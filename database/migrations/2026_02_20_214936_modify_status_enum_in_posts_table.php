<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            DB::statement("
        ALTER TABLE posts 
        MODIFY status ENUM(
            'available',
            'sold',
            'expired'
        ) DEFAULT 'available'
");
            $table->softDeletes();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('sold_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            DB::statement("
        ALTER TABLE posts 
        MODIFY status ENUM(
            'available',
            'sold',
        ) DEFAULT 'available'
    ");

            $table->dropColumn('expires_at');
            $table->dropColumn('sold_at');
            $table->dropSoftDeletes();
        });
    }
};
