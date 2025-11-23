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
        Schema::table('areas_esportivas', function (Blueprint $table) {

            // Remover campos antigos relacionados ao endereço
            $table->dropColumn(['endereco', 'cidade', 'cep']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas_esportivas', function (Blueprint $table) {

            // Recolocar campos caso haja rollback
            $table->string('endereco', 255);
            $table->string('cidade', 80);
            $table->string('cep', 20);
        });
    }
};
