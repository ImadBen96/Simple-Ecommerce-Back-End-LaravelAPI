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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string("product_name");
            $table->string("old_price");
            $table->string("current_price");
            $table->string("qty");
            $table->string("main_image");
            $table->string("others_images");
            $table->string("sizes");
            $table->string("colors");
            $table->text("description");
            $table->text("short_description");
            $table->string("is_active");
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
