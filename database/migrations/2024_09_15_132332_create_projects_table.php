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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->longText(column: 'tags')->nullable();

            $table->string(column: 'name');

            $table->longText(column: 'content')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->default('#');
            $table->date(column: 'finish_time')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
