<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Cubo\Tools\Str;

$valor = $argv[1] ?? null;

if ($valor === null) {
    fwrite(STDERR, "uso: php deploy/cubo-encode.php \"valor\"\n");
    exit(1);
}

$codificado = Str::cuboEncode($valor);

echo $codificado, "\n";

if (Str::cuboDecode($codificado) !== $valor) {
    fwrite(STDERR, "ATENCAO: o valor nao volta igual no decode (caracter especial?).\n");
    exit(2);
}