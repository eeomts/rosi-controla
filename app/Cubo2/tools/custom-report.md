# Customizacoes por cliente

Gerado por tools/check-models.php. Core = o que existe igual em TODOS os 4 bancos de cliente (netflex_v8_306, netflex_v8_344, netflex_v8_345, netflex_v8_347).
Tudo que aparece aqui e customizacao e NAO entra no model base (pertence a pasta do cliente: `clientes/<id>/models/`).

## Tabelas que so alguns clientes tem

- `business_contratante` -> netflex_v8_306, netflex_v8_345, netflex_v8_347
- `custom_data_limite_logs` -> netflex_v8_306
- `custom_netflex_usuario_pontuacao` -> netflex_v8_306
- `custom_pontos_complexidade` -> netflex_v8_306
- `custom_pontos_qualidade` -> netflex_v8_306
- `custom_protocolo` -> netflex_v8_306
- `monitora_processo_copy` -> netflex_v8_306
- `business_contratos_original` -> netflex_v8_344
- `business_entrevistas` -> netflex_v8_344
- `business_entrevistas_copy` -> netflex_v8_344
- `business_ligacoes_last_copy` -> netflex_v8_344
- `business_ligacoes_motivos` -> netflex_v8_344
- `custom_comissao` -> netflex_v8_344
- `custom_importacoes_realizadas` -> netflex_v8_344
- `custom_lista_fria` -> netflex_v8_344
- `custom_lista_fria_original` -> netflex_v8_344
- `custom_modalidade_assinatura` -> netflex_v8_344
- `empresa_orignal` -> netflex_v8_344, netflex_v8_345, netflex_v8_347
- `fidelidade_modalidade` -> netflex_v8_344, netflex_v8_345, netflex_v8_347
- `netflex_estado_civil` -> netflex_v8_344
- `netflex_menu_original` -> netflex_v8_344
- `netflex_rel_menu_permissao_original` -> netflex_v8_344
- `business_negociacoes_produtosxxx` -> netflex_v8_345
- `business_negociacoes_produtos_copy_copy` -> netflex_v8_345
- `botmail_send_control` -> netflex_v8_347
- `custom_banners` -> netflex_v8_347
- `custom_candidato_vaga` -> netflex_v8_347
- `custom_categorias` -> netflex_v8_347
- `custom_contrata_usuario` -> netflex_v8_347
- `custom_contrata_usuario_copy` -> netflex_v8_347
- `custom_faccoes` -> netflex_v8_347
- `custom_faccoes_especialidades` -> netflex_v8_347
- `custom_faccoes_maquinas` -> netflex_v8_347
- `custom_faccoes_rel` -> netflex_v8_347
- `custom_faccoes_servicos` -> netflex_v8_347
- `custom_habilidades` -> netflex_v8_347
- `custom_horarios_dias` -> netflex_v8_347
- `custom_horarios_turnos` -> netflex_v8_347
- `custom_regiao` -> netflex_v8_347
- `custom_softwares` -> netflex_v8_347
- `custom_tipo_certificacao` -> netflex_v8_347
- `custom_usuario_area` -> netflex_v8_347
- `custom_usuario_cargo` -> netflex_v8_347
- `custom_usuario_certificacao` -> netflex_v8_347
- `custom_usuario_experiencia` -> netflex_v8_347
- `custom_usuario_habilidades` -> netflex_v8_347
- `custom_usuario_horarios` -> netflex_v8_347
- `custom_usuario_softwares` -> netflex_v8_347
- `custom_usuario_tipo` -> netflex_v8_347
- `custom_vagas` -> netflex_v8_347
- `custom_vagas_adicional_pagamento` -> netflex_v8_347
- `custom_vagas_areas` -> netflex_v8_347
- `custom_vagas_beneficios` -> netflex_v8_347
- `custom_vagas_cargos` -> netflex_v8_347
- `custom_vagas_favoritos` -> netflex_v8_347
- `custom_vagas_log` -> netflex_v8_347
- `custom_vagas_rel` -> netflex_v8_347
- `custom_vagas_rel_original-deletar` -> netflex_v8_347
- `custom_vagas_rel_originalxx` -> netflex_v8_347
- `custom_vagas_rel_original_copy` -> netflex_v8_347
- `custom_vagas_tipo` -> netflex_v8_347
- `custom_vagas_tipo_remuneracao` -> netflex_v8_347
- `netflex_cliente_online` -> netflex_v8_347
- `netflex_porte` -> netflex_v8_347
- `netflex_segmento` -> netflex_v8_347

## Colunas extras em tabelas core

### netflex_v8_344

- `business_ligacoes_last.cep_cep`
- `business_ligacoes_last.endereco`
- `business_ligacoes_last.bairro`
- `business_ligacoes_last.fk_cidade`
- `business_ligacoes_last.num_numero`
- `business_ligacoes_last.complemento`
- `business_ligacoes_last.fk_regiao`
- `business_ligacoes_last.endereco_referencia`
- `business_ligacoes_status.liberar_followup`
- `business_ligacoes_tarefas.fk_business_ligacoes_status`
- `business_negociacoes_contratos.fk_custom_usuario_indicacao`
- `business_negociacoes_contratos.fk_cliente`
- `business_negociacoes_contratos.fk_custom_modalidade_assinatura`
- `business_negociacoes_contratos.fk_custom_comissao`
- `business_negociacoes_contratos.fk_financeiro_banco`
- `business_negociacoes_contratos.data_assinatura`
- `business_negociacoes_contratos.data_rescisao`
- `business_negociacoes_contratos.data_prescricao`
- `business_negociacoes_contratos.nome_empresa`
- `business_negociacoes_contratos_status.color_cor`
- `empresa.smtp_username`
- `empresa.smtp_sender`
- `empresa.smtp_password`
- `empresa.site`
- `empresa.key`
- `financeiro_entrada.fk_custom_cliente_empreendimento`
- `monitora_empreendimento.contato_nome`
- `monitora_empreendimento.contato_telefone`
- `monitora_empreendimento.contato_email`
- `monitora_empreendimento.contato_cargo`
- `monitora_empreendimento.observacao`
- `netflex_cliente.rg`
- `netflex_cliente.orgao_emissor`
- `netflex_cliente.fk_estado_civil`
- `netflex_cliente.url_drive`
- `netflex_cliente_prospeccoes.fk_financeiro_banco`
- `netflex_cliente_prospeccoes.fk_netflex_cargo`
- `netflex_cliente_prospeccoes.agencia_bancaria`
- `netflex_cliente_prospeccoes.razao_social`
- `netflex_cliente_prospeccoes.json`
- `netflex_filiais.fk_fidelidade_modalidade`
- `netflex_setor.meta_normal`
- `netflex_setor.meta_premium`
- `netflex_setor.mon_meta_normal`
- `netflex_setor.mon_meta_premium`
- `netflex_usuario.email_notificacao`
- `netflex_usuario.meta_normal`
- `netflex_usuario.meta_premium`
- `netflex_usuario.mon_meta_normal`
- `netflex_usuario.mon_meta_premium`

### netflex_v8_347

- `business_ligacoes_tarefas.fk_business_ligacoes_status`
- `empresa.smtp_username`
- `empresa.smtp_sender`
- `empresa.smtp_password`
- `empresa.site`
- `empresa.key`
- `financeiro_entrada.fk_custom_cliente_empreendimento`
- `financeiro_produto.chamada`
- `financeiro_produto.html_descricao`
- `netflex_cliente.nome_responsavel`
- `netflex_cliente.facebook`
- `netflex_cliente.linkedin`
- `netflex_cliente.instagram`
- `netflex_cliente.token`
- `netflex_cliente.url_amigavel`
- `netflex_cliente.aceite_termo`
- `netflex_cliente.pass_senha`
- `netflex_cliente.tiktok`
- `netflex_cliente_prospeccoes.fk_financeiro_banco`
- `netflex_cliente_prospeccoes.agencia_bancaria`
- `netflex_cliente_prospeccoes.razao_social`
- `netflex_cliente_prospeccoes.json`
- `netflex_filiais.fk_fidelidade_modalidade`
- `netflex_usuario.email_notificacao`

### netflex_v8_345

- `empresa.smtp_username`
- `empresa.smtp_sender`
- `empresa.smtp_password`
- `empresa.site`
- `empresa.key`
- `financeiro_entrada.fk_custom_cliente_empreendimento`
- `monitora_empreendimento.observacao`
- `netflex_cliente_prospeccoes.fk_financeiro_banco`
- `netflex_cliente_prospeccoes.razao_social`
- `netflex_cliente_prospeccoes.json`
- `netflex_filiais.fk_fidelidade_modalidade`
- `netflex_usuario.email_notificacao`

### netflex_v8_306

- `financeiro_produto.fk_nivel`
- `financeiro_produto.num_pontos_antes_prazo`
- `financeiro_produto.num_pontos_no_prazo`
- `financeiro_saida.fk_monitora_processo`
- `financeiro_saida.fk_financeiro_banco`
- `monitora_empreendimento.observacao`
- `monitora_processo.id_processo`
- `monitora_processo.nr_processo_orgao`
- `netflex_cliente.id_entidade`
- `tarefas_movimentacao.fk_exige_analise`
- `tarefas_movimentacao.exigir_anexo`
- `tarefas_movimentacao.fk_custom_protocolo`
- `tarefas_movimentacao.fk_custom_tarefa_pai`
- `tarefas_movimentacao.data_limite`
- `tarefas_status.num_dias`

## Mesma coluna, tipo diferente entre clientes

Ficam no core (existem em todos), mas o schema esta fora de sincronia:

- `business_negociacoes_produtos.detalhes_item`: {"netflex_v8_306":"varchar(255)","netflex_v8_344":"varchar(255)","netflex_v8_345":"longtext","netflex_v8_347":"varchar(255)"}
- `fidelidade_lancamentos.total_pontos`: {"netflex_v8_306":"int(11)","netflex_v8_344":"float(11,2)","netflex_v8_345":"float(11,2)","netflex_v8_347":"float(11,2)"}
- `fidelidade_lancamentos.pontos`: {"netflex_v8_306":"int(11)","netflex_v8_344":"float(11,2)","netflex_v8_345":"float(11,2)","netflex_v8_347":"float(11,2)"}
- `fidelidade_lancamentos.resgate`: {"netflex_v8_306":"int(11)","netflex_v8_344":"float(11,2)","netflex_v8_345":"float(11,2)","netflex_v8_347":"float(11,2)"}
- `fidelidade_rel_resgates_brindes.qtde`: {"netflex_v8_306":"int(11)","netflex_v8_344":"float(11,2)","netflex_v8_345":"float(11,2)","netflex_v8_347":"float(11,2)"}
- `fidelidade_rel_resgates_lancamentos.pontos_resgate`: {"netflex_v8_306":"int(11)","netflex_v8_344":"float(11,2)","netflex_v8_345":"float(11,2)","netflex_v8_347":"float(11,2)"}
- `fidelidade_resgates.total_pontos`: {"netflex_v8_306":"int(11)","netflex_v8_344":"float(11,2)","netflex_v8_345":"float(11,2)","netflex_v8_347":"float(11,2)"}
- `financeiro_banco.id`: {"netflex_v8_306":"tinyint(4)","netflex_v8_344":"int(11)","netflex_v8_345":"int(11)","netflex_v8_347":"int(11)"}
- `financeiro_banco.nome`: {"netflex_v8_306":"varchar(30)","netflex_v8_344":"varchar(200)","netflex_v8_345":"varchar(200)","netflex_v8_347":"varchar(200)"}
- `financeiro_entrada.emitir_nf`: {"netflex_v8_306":"tinyint(1)","netflex_v8_344":"int(11)","netflex_v8_345":"int(11)","netflex_v8_347":"int(11)"}
- `financeiro_entrada.num_documento`: {"netflex_v8_306":"varchar(100)","netflex_v8_344":"varchar(10)","netflex_v8_345":"varchar(10)","netflex_v8_347":"varchar(10)"}
- `financeiro_produto_tipo.nome`: {"netflex_v8_306":"varchar(255)","netflex_v8_344":"varchar(45)","netflex_v8_345":"varchar(45)","netflex_v8_347":"varchar(45)"}
- `monitora_atividade.nome`: {"netflex_v8_306":"varchar(45)","netflex_v8_344":"varchar(255)","netflex_v8_345":"varchar(255)","netflex_v8_347":"varchar(255)"}
- `netflex_cliente.data_nascimento`: {"netflex_v8_306":"datetime","netflex_v8_344":"date","netflex_v8_345":"datetime","netflex_v8_347":"datetime"}
- `netflex_cliente_prospeccoes.nome`: {"netflex_v8_306":"varchar(45)","netflex_v8_344":"varchar(150)","netflex_v8_345":"varchar(150)","netflex_v8_347":"varchar(150)"}
- `netflex_menu.ordem`: {"netflex_v8_306":"int(11)","netflex_v8_344":"tinyint(4)","netflex_v8_345":"tinyint(4)","netflex_v8_347":"tinyint(4)"}
- `netflex_usuario.email`: {"netflex_v8_306":"varchar(80)","netflex_v8_344":"varchar(150)","netflex_v8_345":"varchar(150)","netflex_v8_347":"varchar(150)"}
