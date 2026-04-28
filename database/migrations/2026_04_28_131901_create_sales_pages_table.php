<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('product_name');
            $table->text('description')->nullable();
            $table->text('key_features')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('price')->nullable();
            $table->text('unique_selling_points')->nullable();

            $table->string('headline')->nullable();
            $table->string('subheadline')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('features_breakdown')->nullable();
            $table->longText('social_proof')->nullable();
            $table->text('cta')->nullable();

            $table->longText('full_output')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_pages');
    }
};