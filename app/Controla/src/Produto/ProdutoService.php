<?php

namespace Controla\Produto;

use Controla\Comum\Exceptions\DadosInvalidosException;
use Controla\Produto\Models\Genero;
use Controla\Produto\Models\Produto;
use RuntimeException;

/**
 * Cadastro da base do produto: monta, valida e grava.
 *
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
final class ProdutoService
{
    /**
     * Cria (id null) ou atualiza um produto.
     *
     * @param array<string,mixed> $dados Campos crus vindos do formulario.
     * @throws DadosInvalidosException Com o mapa campo => mensagem.
     * @throws RuntimeException Se o id informado nao existe.
     */
    public function salvar(?int $id, array $dados): Produto
    {
        $produto = $this->encontrarOuCriar($id);

        $produto->fill($this->normalizar($dados));

        $this->validar($produto);

        $produto->save();

        return $produto;
    }

    /**
     * Cadastro rapido feito de dentro de outra tela (pedido, amostra, venda),
     * onde ela so tem o nome do produto em maos.
     *
     * @throws DadosInvalidosException
     */
    public function cadastroRapido(string $nome): Produto
    {
        return $this->salvar(null, ['nome' => $nome]);
    }

    private function encontrarOuCriar(?int $id): Produto
    {
        if ($id === null) {
            return new Produto();
        }

        $produto = Produto::findById($id);

        if ($produto === null) {
            throw new RuntimeException("Produto {$id} nao encontrado.");
        }

        return $produto;
    }

    /**
     * @param array<string,mixed> $dados
     * @return array<string,mixed>
     */
    private function normalizar(array $dados): array
    {
        foreach (['nome', 'codigo_produto'] as $campo) {
            if (array_key_exists($campo, $dados)) {
                $dados[$campo] = trim((string) $dados[$campo]);
            }
        }

        // select vazio chega como '' e nao pode virar 0
        if (array_key_exists('fk_genero', $dados)) {
            $dados['fk_genero'] = ($dados['fk_genero'] === '' || $dados['fk_genero'] === null)
                ? null
                : (int) $dados['fk_genero'];
        }

        if (($dados['codigo_produto'] ?? null) === '') {
            $dados['codigo_produto'] = null;
        }

        return $dados;
    }

    /**
     * @throws DadosInvalidosException
     */
    private function validar(Produto $produto): void
    {
        $erros = [];

        if (trim((string) $produto->nome) === '') {
            $erros['nome'] = 'Informe o nome do produto.';
        }

        if ($produto->fk_genero !== null && Genero::findById($produto->fk_genero) === null) {
            $erros['fk_genero'] = 'O genero selecionado nao existe.';
        }

        if ($produto->codigo_produto !== null && $this->codigoRepetido($produto)) {
            $erros['codigo_produto'] = "O codigo {$produto->codigo_produto} ja esta em outro produto.";
        }

        if ($erros !== []) {
            throw DadosInvalidosException::com($erros);
        }
    }

    /** O scope de exclusao logica ja tira os apagados da conferencia. */
    private function codigoRepetido(Produto $produto): bool
    {
        return Produto::query()
            ->where('codigo_produto', $produto->codigo_produto)
            ->when($produto->exists, fn($query) => $query->where('id', '!=', $produto->getKey()))
            ->exists();
    }
}
