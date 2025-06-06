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
        Schema::table('blogs', function (Blueprint $table) {
            // Mengubah nama kolom 'image' menjadi 'image_url'
            $table->renameColumn('image', 'image_url');
            // Mengubah nama kolom 'video' menjadi 'video_path'
            $table->renameColumn('video', 'video_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            // Kebalikan dari proses di atas, untuk rollback
            $table->renameColumn('image_url', 'image');
            $table->renameColumn('video_path', 'video');
        });
    }
};