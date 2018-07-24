<?php

//#principais
$r['box-body'] = "
		<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal-info'>
			Modal-Editar-Rotas
		</button>";
$select = "SELECT r.rota, r.escopo, c.nome as categoria FROM rotas r LEFT outer JOIN acessibilidade a ON a.rota = r.rota LEFT outer JOIN categorias c ON c.id = a.categoria ";
$resultado = $this->execQuery($select)['result'];
$tableBody = '';
foreach($resultado as $key=>$value){
	$tableBody .=	"<tr>
						<td>".$value['rota']."</td>
						<td>".$value['escopo']."</td>
						<td>".$value['categoria']."</td>

					</tr>";
}
$r['table-body'] = $tableBody;


$r['box-title'] = "Lista de Rotas";
return $r;
