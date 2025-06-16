<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicos', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->text('descricao')->nullable();
        $table->decimal('preco', 8, 2);
        $table->integer('duracao'); // em minutos
        $table->timestamps();
    });

     DB::table('servicos')->insert([
        [
            'nome' => 'Corte de Cabelo',
            'descricao' => 'Corte feminino ou masculino.',
            'preco' => 50.00,
            'duracao' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'nome' => 'Escova',
            'descricao' => 'Corte feminino ou masculino.',
            'preco' => 40.00,
            'duracao' => 45,
            'created_at' => now(),
            'updated_at' => now(),
        ],
     ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
