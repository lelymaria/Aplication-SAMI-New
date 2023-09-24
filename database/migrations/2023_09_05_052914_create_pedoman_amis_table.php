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
        Schema::create('pedoman_ami', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('histori_ami_id')->references('id')->on('histori_ami')->cascadeOnDelete();
            $table->text('deskripsi');
            $table->string('file_pedoman_ami');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedoman_ami');
    }
};
