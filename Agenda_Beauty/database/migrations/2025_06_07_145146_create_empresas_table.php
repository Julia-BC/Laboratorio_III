<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // Criação da tabela 'empresas'
    Schema::create('empresas', function (Blueprint $table) {
        $table->id(); // Cria a coluna 'id' como chave primária e auto-incremento
        $table->string('nome');
        $table->string('cnpj')->unique();
        $table->string('email')->unique();
        $table->string('telefone');
        $table->string('cep');
        $table->string('cidade');
        $table->string('bairro');
        $table->string('complemento')->nullable();
        $table->string('senha');
        $table->rememberToken(); // habilitar opção de "lembrar de mim"
        $table->timestamp('email_verified_at')->nullable(); // registra quando o e-mail foi verificado
        $table->timestamps(); // cria as colunas 'created_at' e 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
