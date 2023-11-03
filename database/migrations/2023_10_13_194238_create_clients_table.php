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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps(); // Isso já cria as colunas 'created_at' e 'updated_at'.
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp');
            $table->date('birthdate')->nullable();
            $table->string('adress');
            $table->rememberToken();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
