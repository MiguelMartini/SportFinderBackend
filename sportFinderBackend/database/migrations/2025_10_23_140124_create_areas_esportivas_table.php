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
        Schema::create('areas_esportivas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_administrador')->constrained('users')->onDelete('cascade');
            $table->string('titulo', 255); // título da área
            $table->string('descricao', 500)->nullable(); // descrição opcional
            $table->string('endereco', 255); // endereço opcional
            $table->string('cidade', 80); // cidade opcional
            $table->string('cep', 20); // CEP opcional
            $table->tinyInteger('nota')->nullable()->comment('Avaliação de 0 a 5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas_esportivas');
    }
};
