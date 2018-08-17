<?php

//#principais
$r['box-body'] = "
		<button type='button' class='btn btn-primary btn-lg' data-toggle='modal' data-target='#myModal'>
 		 	EDITAR PÁGINAS
		</button>";
$r['box-title'] = "Lista de Rotas";

$paginas = $this->execQuery("SELECT * FROM paginas");
if($paginas['status']){
	$paginas = $paginas['result'];
	$tableBody = '';
	foreach($usuario as $key=>$value){
		$tableBody .=	"<tr>
		<td>".$value['rota']."</td>
		<td>".$value['escopo']."</td>
		<td> Página </td>
		</tr>";
	}
	$r['table-body'] = $tableBody;
}


return $r;
