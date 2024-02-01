<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('borrowed_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')
                ->constrained('books')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->dateTime('start_date')->default(now());
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrowed_books');
    }
};
