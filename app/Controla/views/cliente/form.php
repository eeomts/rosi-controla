<?php

/**
 * Formulario de cliente: mesmo template para nova e para edicao.
 *
 * @var Cubo\View\View $view
 */

use Cubo\Security;

$id = $view->getParam('id');
$valores = (array) $view->getParam('valores', []);
$erros = (array) $view->getParam('erros', []);

$valor = static fn(string $campo): string => Security::escape((string) ($valores[$campo] ?? ''));
$erro = static fn(string $campo): string => (string) ($erros[$campo] ?? '');

// o JSON vai dentro de um atributo HTML: aspas, & e <> escapados, senao o
// navegador decodifica entidade antes de o Alpine ler
$emAtributo = JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG | JSON_UNESCAPED_UNICODE;
$json = static fn(string $campo): string => json_encode((string) ($valores[$campo] ?? ''), $emAtributo);

?>
<!--
  A mascara e SO da tela: o que trafega no POST pode ir com parenteses e traco,
  porque o ClienteService joga fora tudo que nao e digito antes de gravar.
-->
<form class="cartao form" method="post" action="/cliente/salvar" x-data='{
  telefone: <?= $json('telefone') ?>,
  get digitos() { return this.telefone.replace(/\D/g, "") },
  get telefoneCurto() { return this.digitos.length > 0 && this.digitos.length !== 10 && this.digitos.length !== 11 },
  mascarar() {
    const d = this.digitos.slice(0, 11)
    const ddd = d.slice(0, 2)
    const resto = d.slice(2)
    const corte = d.length > 10 ? 5 : 4

    if (d.length === 0) { this.telefone = ""; return }
    if (resto.length === 0) { this.telefone = "(" + ddd; return }

    this.telefone = resto.length > corte
      ? "(" + ddd + ") " + resto.slice(0, corte) + "-" + resto.slice(corte)
      : "(" + ddd + ") " + resto
  }
}'>

       <?php if ($id !== null): ?>
              <input type="hidden" name="id" value="<?= (int) $id ?>">
       <?php endif; ?>

       <div class="campo <?= $erro('nome') !== '' ? 'campo-invalido' : '' ?>">
              <label for="nome">Nome</label>
              <input id="nome" name="nome" type="text" maxlength="120"
                     value="<?= $valor('nome') ?>" required autofocus>
              <?php if ($erro('nome') !== ''): ?>
                     <p class="erro"><?= Security::escape($erro('nome')) ?></p>
              <?php endif; ?>
       </div>

       <div class="campo <?= $erro('telefone') !== '' ? 'campo-invalido' : '' ?>">
              <label for="telefone">Telefone</label>
              <input id="telefone" name="telefone" type="tel" inputmode="tel" maxlength="15"
                     placeholder="(11) 99999-8888"
                     value="<?= $valor('telefone') ?>" x-model="telefone" @input="mascarar()">
              <p class="dica">Opcional. Fixo ou celular, sempre com DDD.</p>
              <?php if ($erro('telefone') !== ''): ?>
                     <p class="erro"><?= Security::escape($erro('telefone')) ?></p>
              <?php else: ?>
                     <!-- espelho do ClienteService::validar(); o else evita dois avisos iguais -->
                     <p class="erro" x-show="telefoneCurto" x-cloak>Faltam digitos nesse telefone.</p>
              <?php endif; ?>
       </div>

       <div class="barra">
              <button class="botao botao-primario" type="submit">Salvar</button>
              <a class="botao botao-contorno" href="/cliente">Cancelar</a>
       </div>

</form>
