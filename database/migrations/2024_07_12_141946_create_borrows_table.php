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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->string('book_id');
            $table->timestamp('borrowed_at');
            $table->timestamp('returned_at')->nullable();
            $table->foreign('member_id')->references('code')->on('members');
            $table->foreign('book_id')->references('code')->on('books');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
