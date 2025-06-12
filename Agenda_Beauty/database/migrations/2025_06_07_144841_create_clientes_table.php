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
    // Criação da tabela 'clientes'
    Schema::create('clientes', function (Blueprint $table) {
        $table->id(); // Cria a coluna 'id' como chave primária e auto-incremento
        $table->string('nome');
        $table->string('cpf')->unique();
        $table->string('email')->unique();
        $table->string('telefone');
        $table->string('senha');
        $table->string('verification_token')->nullable();// Token para verificação de e-mail
        $table->rememberToken(); // Habilitar opção de "lembrar de mim"
        $table->timestamp('email_verified_at')->nullable(); // Registra quando o e-mail foi verificado
        $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        $table->string('password_reset_token')->nullable(); // Token para redefinição de senha
        $table->timestamp('password_reset_sent_at')->nullable(); // Data de envio do token de redefinição de senha
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes'); // Remove a tabela 'clientes' se ela existir
    }
};
