<?php

$r['box-title'] = "Usuários Cadastrados no Sistema";
// $r['box-footer'] = "rodape"; // testar validação de existencia, um dia
$r['box-body'] = " ";
$usuario = $this->execQuery("SELECT * FROM usuario")['result'];
$tableBody = '';
foreach($usuario as $key=>$value){
	$tableBody .=	"<tr>
						<td>".$value['nome']."</td>
						<td>".$value['email']."</td>
						<td>".$value['cpf']."</td>
						<td>".$value['categoria']."</td>
						<td>".$value['session_time']."</td>
					</tr>";
}
$r['table-body'] = $tableBody;

return $r;
