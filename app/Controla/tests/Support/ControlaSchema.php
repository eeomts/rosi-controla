<?php

namespace Controla\Tests\Support;

use Cubo\Database\Db;
use Illuminate\Database\Schema\Blueprint;

/**
 * Tabelas montadas em memoria para os testes.
 *
 * @package Controla\Tests
 * @author Mateus - github.com/eeomts
 */
final class ControlaSchema
{
    /** Registra a conexao sqlite em memoria e monta as tabelas. */
    public static function preparar(): void
    {
        Db::getInstance()->addConnection(Db::DEFAULT_CONNECTION, [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        self::criar();
    }

    public static function criar(): void
    {
        $schema = Db::getInstance()->getConnection()->getSchemaBuilder();

        $schema->dropIfExists('genero_aux');
        $schema->create('genero_aux', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nome', 30);
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->integer('deleted')->default(0);
        });

        $schema->dropIfExists('produto');
        $schema->create('produto', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nome', 160);
            $table->string('codigo_produto', 30)->nullable();
            $table->integer('fk_genero')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->integer('deleted')->default(0);
        });

        $schema->dropIfExists('cliente');
        $schema->create('cliente', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nome', 120);
            $table->string('telefone', 20)->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->integer('deleted')->default(0);
        });

        $schema->dropIfExists('ciclo');
        $schema->create('ciclo', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('nome', 60);
            $table->integer('num_ciclo');
            $table->integer('num_ano');
            $table->date('data_inicio')->nullable();
            $table->date('data_termino')->nullable();
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->integer('deleted')->default(0);
        });

        $schema->dropIfExists('pedido');
        $schema->create('pedido', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('fk_ciclo');
            $table->string('nome', 40);
            $table->date('data_pedido')->nullable();
            $table->decimal('mon_total', 10, 2)->default(0);
            $table->decimal('mon_lucro_estimado', 10, 2)->default(0);
            $table->decimal('mon_lucro_real', 10, 2)->default(0);
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->integer('deleted')->default(0);
        });

        $schema->dropIfExists('variacao_produto');
        $schema->create('variacao_produto', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('fk_produto');
            $table->integer('fk_pedido');
            $table->integer('fk_ciclo');
            $table->date('data_validade')->nullable();
            $table->decimal('mon_custo', 10, 2);
            $table->decimal('mon_venda', 10, 2);
            $table->integer('vendido')->default(0);
            $table->timestamp('created')->nullable();
            $table->timestamp('updated')->nullable();
            $table->integer('deleted')->default(0);
        });
    }
}
