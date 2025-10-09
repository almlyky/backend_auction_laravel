<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropForeign(['sub_category_id']);
            $table->renameColumn('sub_category_id', 'category_id');
             $table->unsignedBigInteger('category_id')->nullable()->change();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropForeign(['category_id']);
            $table->renameColumn('category_id', 'sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');


        });
    }
};
