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
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cover_img');
            $table->text('body');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('time');
            $table->integer('price');
            $table->string('location');
            $table->string('exhibition_map');
            $table->boolean('status')->default(0);
            $table->integer('number_of_stands')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exhibitions');
    }
};
