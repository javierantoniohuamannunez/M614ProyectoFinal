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
        Schema::create('alumne_modul', function (Blueprint $table) {
            $table->foreignId('alumne_id')
                ->constrained('alumnes')
                ->onDelete('cascade');

            $table->foreignId('modul_id')
                ->constrained('moduls')
                ->onDelete('cascade');
            
            $table->decimal('nota', 3, 1)->nullable();

            $table->primary(['alumne_id', 'modul_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumne_modul');
    }
};
