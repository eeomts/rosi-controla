<?php

namespace Controla\Comum\Exceptions;

use RuntimeException;

/**
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
class DadosInvalidosException extends RuntimeException
{
    /** @param array<string,string> $erros campo => mensagem */
    public function __construct(private readonly array $erros)
    {
        parent::__construct(implode(' ', $erros));
    }

    /** @param array<string,string> $erros */
    public static function com(array $erros): self
    {
        return new self($erros);
    }

    /** @return array<string,string> */
    public function erros(): array
    {
        return $this->erros;
    }

    public function temErroEm(string $campo): bool
    {
        return isset($this->erros[$campo]);
    }
}
