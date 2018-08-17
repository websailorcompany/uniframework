<?php

### SIGMA/admin
$route[] = ['/operacional/teste', 'OperController', 'teste'];
$route[] = ['/operacional/show', 'OperController', 'show'];
$route[] = ['/operacional/boleto', 'OperController', 'boleto'];

$route[] = ['/operacional', 'OperController', 'index'];
$route[] = ['/operacional/login', 'OperController', 'login'];
$route[] = ['/operacional/perfil', 'OperController', 'perfil'];
$route[] = ['/operacional/editar-perfil', 'OperController', 'perfil_alt'];
$route[] = ['/operacional/editar-perfil/ws/{op}', 'OperController', 'perfil_ws'];
// op = salva|exclui|cancela

$route[] = ['/operacional/novo-documento/{tipo}/{estrutura}', 'OperController', 'cria_doc'];
// tipo = licam|parecer|nota|oficio|memorando
// tipo = solicita_licam|solicita_autoriza|solicita_poda|solicita_diranimais|solicita_educambiental
// estrutura = string|form
$route[] = ['/operacional/novo-documento-a-partir-modelo/{tipo}/{estrutura}/{modelo}', 'OperController', 'cria-doc-model'];
//modelo = id_modelo
$route[] = ['/operacional/novo-documento/{tipo}/{estrutura}/ws/{op}/', 'OperController', 'cria_doc_ws'];
//op = salva|salva_modelo|cancela
$route[] = ['/operacional/novo-processo/{tipo}', 'OperController', 'cria_proc'];
//tipo = licam|autoriza|admin
$route[] = ['/operacional/novo-processo/{tipo}/ws/{op}/', 'OperController', 'cria_doc_ws'];
//op = salva|cancela

$route[] = ['/operacional/lista-de-documentos', 'OperController', 'meus_docs'];
$route[] = ['/operacional/lista-de-processos', 'OperController', 'meus_procs'];
$route[] = ['/operacional/mosta-processo/{proc}', 'OperController', 'proc_show']; //busca em modo visualização de docs
$route[] = ['/operacional/mostra-documento/{doc}', 'OperController', 'doc_show']; //busca em modo visualização
$route[] = ['/operacional/timeline-processo/{proc}', 'OperController', 'proc_timeline']; //busca em modo timeline
$route[] = ['/operacional/timeline-documento/{doc}', 'OperController', 'doc_timeline']; //busca em modo timeline
$route[] = ['/operacional/altera-processo/{proc}', 'OperController', 'proc_alt']; //busca em modo edição
$route[] = ['/operacional/altera-documento/{doc}', 'OperController', 'doc_alt']; //busca em modo edição

$route[] = ['/operacional/ws/proc/{proc}/{op}', 'OperController', 'proc_ws']; //executa, op = salvar|delete|insere_doc|arquivar|finalizar|cancela
$route[] = ['/operacional/ws/doc/{doc}/{op}', 'OperController', 'doc_ws']; //executa, op = salvar|delete|salvar_modelo|atribuir_proc|cancela
