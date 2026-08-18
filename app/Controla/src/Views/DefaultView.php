<?php

namespace Controla\Views;

use Controla\Utils\Flash;
use Cubo\View\View;

/**
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


    protected function _setDefaultParams(): void
    {
        $this->addParam('sistema', 'Controla');
        $this->addParam('titulo', $this->getParam('titulo', 'Controla'));
        $this->addParam('conteudo', $this->getParam('conteudo', ''));

        // aqui, e nao em cada controlador: o recado tem de aparecer venha de onde vier
        $recado = Flash::daGlobal()->consumir();

        $this->addParam('flash', $recado['mensagem'] ?? null);
        $this->addParam('flash_tipo', $recado['tipo'] ?? '');
    }
}
