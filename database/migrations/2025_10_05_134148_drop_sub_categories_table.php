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
        //
        Schema::dropIfExists('sub_categories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
       Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
};
