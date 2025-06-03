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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->string('video')->nullable(); // Tambahkan kolom video untuk menyimpan path video
            $table->string('author')->nullable(); // Tambahkan kolom author untuk menyimpan nama penulis
            $table->string('slug')->unique()->nullable(); // Tambahkan kolom slug untuk SEO
            $table->string('kategori'); // Tambahkan kolom kategori untuk klasifikasi blog
            $table->string('subkategori')->nullable(); // Tambahkan kolom subkategori untuk klasifikasi blog
            // $table->string('status')->default('draft'); // Tambahkan kolom status untuk mengelola status blog (draft, published, etc.)
            // $table->dateTime('published_at')->nullable(); // Tambahkan kolom published_at untuk tanggal publikasi

            //user_id
            // Tambahkan kolom user_id untuk mengaitkan blog dengan pengguna
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
