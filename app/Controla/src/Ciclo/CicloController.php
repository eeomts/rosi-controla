<?php

namespace Controla\Ciclo;

use Cubo\Controller;

/**
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
final class CicloController extends Controller
{
    public function index(): void
    {
        $this->_view->addParam('titulo', 'Ciclos');
        $this->_view->addParam('conteudo', '<p>Bootstrap de pe. A tela de ciclos entra aqui.</p>');
    }
}
