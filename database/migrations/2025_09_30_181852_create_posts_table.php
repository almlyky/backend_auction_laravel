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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->text('discribtion');
            $table->integer('price');
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->enum('product_status', ['new', 'used'])->default('used');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
