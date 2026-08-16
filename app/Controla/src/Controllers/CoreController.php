<?php

namespace Controla\Controllers;

use Controla\Routing\FeatureMapper;
use Cubo\Controller;
use Cubo\Database\Db;
use Cubo\Routing\Route;
use ReflectionClass;
use RuntimeException;

/**
 * Controlador principal: resolve a feature da rota e delega a acao para ela.
 *
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
final class CoreController extends Controller
{
    private const ACTION_PADRAO = 'index';

    public function initialize(): void
    {
        $this->_db = Db::getInstance();

        $route = $this->_route ?? new Route(self::ACTION_PADRAO, self::ACTION_PADRAO);
        $class = (new FeatureMapper())->controllerClass($route);

        $feature = new $class($route, $this->_view);
        $feature->initialize();

        $this->setModule($feature);
    }

    public function index(): void
    {
        $feature = $this->getModule();
        $action = $this->resolveAction($feature, $this->_route?->method ?? self::ACTION_PADRAO);

        $feature->$action();
    }

    /**
     * @throws RuntimeException Se nem a acao pedida nem a padrao servem.
     */
    private function resolveAction(Controller $feature, string $action): string
    {
        foreach ([$action, self::ACTION_PADRAO] as $candidata) {
            if ($this->ehAction($feature, $candidata)) {
                return $candidata;
            }
        }

        throw new RuntimeException(
            $feature::class . " nao tem a acao '{$action}' nem a acao '" . self::ACTION_PADRAO . "'."
        );
    }
    
    private function ehAction(Controller $feature, string $nome): bool
    {
        $classe = new ReflectionClass($feature);

        if (!$classe->hasMethod($nome)) {
            return false;
        }

        $metodo = $classe->getMethod($nome);

        return $metodo->isPublic()
            && !$metodo->isStatic()
            && $metodo->getNumberOfRequiredParameters() === 0
            && $metodo->getDeclaringClass()->getName() !== Controller::class;
    }
}
