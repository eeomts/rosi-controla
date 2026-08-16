<?php

namespace Controla\Comum\Models;

use Cubo\Database\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Base das tabelas _aux: lista fechada de id + nome
 *
 * @package Controla
 * @author Mateus - github.com/eeomts
 */
abstract class Auxiliar extends Model
{
    protected $fillable = ['nome'];

    public function scopeOrdenado(Builder $query): Builder
    {
        return $query->orderBy('nome');
    }

    /**
     * @return array<int,string> id => nome, pronto para montar um select.
     */
    public static function paraSelect(): array
    {
        return static::query()->ordenado()->pluck('nome', 'id')->all();
    }
}
