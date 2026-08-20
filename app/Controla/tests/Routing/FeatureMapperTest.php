<?php

namespace Controla\Tests\Routing;

use Controla\Controllers\CicloController;
use Controla\Routing\FeatureMapper;
use Cubo\Exceptions\ControllerNotFoundException;
use Cubo\Routing\Route;
use PHPUnit\Framework\TestCase;

/**
 * @package Controla\Tests
 * @author Mateus - github.com/eeomts
 */
final class FeatureMapperTest extends TestCase
{
    private FeatureMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mapper = new FeatureMapper();
    }

    public function testTraduzAFeatureNoControlador(): void
    {
        $this->assertSame(CicloController::class, $this->classeDe('ciclo'));
    }

    public function testAceitaAFeatureJaCapitalizada(): void
    {
        $this->assertSame(CicloController::class, $this->classeDe('Ciclo'));
    }

    public function testRotaVaziaCaiNaHome(): void
    {
        $this->assertSame(CicloController::class, $this->classeDe(''));
    }

    public function testRotaIndexCaiNaHome(): void
    {
        $this->assertSame(CicloController::class, $this->classeDe('index'));
    }

    public function testFeatureInexistenteReclama(): void
    {
        $this->expectException(ControllerNotFoundException::class);

        $this->classeDe('unicornio');
    }

    /** A URL /feature acha a FeatureController; instanciar o molde seria fatal. */
    public function testMoldeAbstratoNaoEhAlcancavelPelaUrl(): void
    {
        $this->expectException(ControllerNotFoundException::class);

        $this->classeDe('feature');
    }

    /** O CoreController tambem estende Controller, mas nao e feature de URL. */
    public function testNaoConfundeClasseDeOutroNamespace(): void
    {
        $this->expectException(ControllerNotFoundException::class);

        $this->classeDe('Cubo\\Controller');
    }

    private function classeDe(string $controller): string
    {
        return $this->mapper->controllerClass(new Route($controller, 'index'));
    }
}
