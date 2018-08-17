<?php
require("../app/routes.php");
require("static/static-routes.php");
### WS-ADMIN
// lista dados principais, estatísticas
$route[]=['/ws-admin', 'WSController', 'index'];
$route[]=['/ws-admin/', 'WSController', 'index'];
// login
$route[]=['/adm/login', 'WSController', 'admlogin'];
// $route[]=['/ws/adm/login', 'WSController', 'ws_admlogin'];
$route[]=['/job/login', 'WSController', 'joblogin'];
// $route[]=['/ws/job/login', 'WSController', 'ws_joblogin'];
$route[]=['/reg/login', 'WSController', 'reglogin'];
// $route[]=['/ws/reg/login', 'WSController', 'ws_reglogin'];

// mostra rotas divididas por escopo, pronto para edição
$route[]=['/ws-admin/rotas', 'WSController', 'rotas'];
$route[]=['/ws-admin/rotas/', 'WSController', 'rotas'];
// rota + categorias
$route[]=['/ws-admin/rotas/ws/alterar', 'WSController', 'rotas'];
// mostra paginas divididas por escopo
$route[]=['/ws-admin/paginas', 'WSController', 'paginas'];
// mostra pagina, pronto para edição
$route[]=['/ws-admin/edita-pagina/', 'WSController', 'edita_pagina'];
//envio de edição
$route[]=['/ws-admin/edita-pagina/ws', 'WSController', 'edita_pagina_ws'];

// mostra componentes divididas por área, pronto para edição
$route[]=['/ws-admin/componentes', 'WSController', 'componentes'];
$route[]=['/ws-admin/componentes/', 'WSController', 'componentes'];

// mostra categorias divididas por escopo, pronto para edição
$route[]=['/ws-admin/categorias', 'WSController', 'categorias'];
$route[]=['/ws-admin/categorias/', 'WSController', 'categorias'];
// mostra modulos divididos por categoria, pronto para edição
$route[]=['/ws-admin/modulos', 'WSController', 'modulos'];
$route[]=['/ws-admin/modulos/', 'WSController', 'modulos'];
// mostra usuarios divididos por escopo
// operacionais divididos por área e categoria
// registrados divididos por categoria
$route[]=['/ws-admin/usuarios', 'WSController', 'usuarios'];
$route[]=['/ws-admin/usuarios/', 'WSController', 'usuarios'];
// matriz de controle de acesso operacional
$route[]=['/ws-admin/mca/oper/{uid}', 'WSController', 'mca_oper'];
// matriz de controle de acesso registrados
$route[]=['/ws-admin/mca/reg/{uid}', 'WSController', 'mca_reg'];

return $route;
