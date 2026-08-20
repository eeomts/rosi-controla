<?php

namespace Controla\Controllers;

use Controla\Utils\Flash;
use Controla\Utils\Request;
use Controla\Views\PaginaView;
use Cubo\Controller;

/**
 * Molde das features do Controla: o que Ciclo, Cliente e as proximas telas
 * fazem igual -- montar a pagina, ler as fronteiras e devolver o que foi
 * digitado quando a validacao falha.
 *
 * A classe e abstrata de proposito, e o FeatureMapper recusa classe abstrata:
 * sem isso a URL /feature chegaria aqui e o kernel tentaria instanciar o molde.
 *
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
abstract class FeatureController extends Controller
{
    /** @var list<string> Campos que voltam para o form quando a validacao falha. */
    protected const CAMPOS = [];

    protected Request $request;
    protected Flash $flash;

    /**
     * Chamado pelo CoreController. Monta as fronteiras que toda feature usa e
     * deixa o resto para iniciar().
     */
    final public function initialize(): void
    {
        $this->request = Request::daGlobal($this->_route);
        $this->flash = Flash::daGlobal();

        $this->iniciar();
    }

    /** Onde a feature cria o seu service. */
    protected function iniciar(): void
    {
    }

    /**
     * @param array<string,mixed> $params
     */
    protected function pagina(string $titulo, string $template, array $params = []): void
    {
        $this->_view->addParam('titulo', $titulo);

        foreach ($params as $chave => $valor) {
            $this->_view->addParam($chave, $valor);
        }

        $this->_view->addChild(new PaginaView($template));
    }

    /** @return array<string,string> */
    protected function valoresDigitados(): array
    {
        $valores = [];

        foreach (static::CAMPOS as $campo) {
            $valores[$campo] = $this->request->texto($campo);
        }

        return $valores;
    }

    /** @return array<string,string> */
    protected function valoresVazios(): array
    {
        return array_fill_keys(static::CAMPOS, '');
    }
}
