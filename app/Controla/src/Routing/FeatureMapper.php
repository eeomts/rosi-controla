<?php

namespace Controla\Routing;

use Cubo\Controller;
use Cubo\Exceptions\ControllerNotFoundException;
use Cubo\Routing\Route;

/**
 * Traduz a rota no controlador da feature.
 *
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
final class FeatureMapper
{
    private const NAMESPACE_CONTROLLERS = 'Controla\\Controllers\\';

    /** Feature que responde pela raiz do site enquanto nao existe dashboard. */
    private const FEATURE_HOME = 'Ciclo';

    /**
     * @return class-string<Controller>
     * @throws ControllerNotFoundException Se a feature nao existe ou nao e um Controller.
     */
    public function controllerClass(Route $route): string
    {
        $feature = $this->featureName($route);
        $class = self::NAMESPACE_CONTROLLERS . $feature . 'Controller';

        if (!class_exists($class) || !is_subclass_of($class, Controller::class)) {
            throw ControllerNotFoundException::for($class);
        }

        return $class;
    }

    private function featureName(Route $route): string
    {
        $controller = $route->controller;

        if ($controller === '' || $controller === 'index') {
            return self::FEATURE_HOME;
        }

        return ucfirst($controller);
    }
}
