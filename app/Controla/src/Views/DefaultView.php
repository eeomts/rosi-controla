<?php

namespace Controla\Views;

use Cubo\View\View;

/**
 * View padrao da aplicacao: carrega o layout e serve de raiz do Composite.
 *
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
final class DefaultView extends View
{
    private static ?self $instance = null;

    private function __construct()
    {
        $this->setTemplate('layout.php');
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Params que todo template usa, para nenhum controlador precisar reenviar.
     */
    protected function _setDefaultParams(): void
    {
        $this->addParam('sistema', 'Controla');
        $this->addParam('titulo', $this->getParam('titulo', 'Controla'));
        $this->addParam('conteudo', $this->getParam('conteudo', ''));
    }
}
