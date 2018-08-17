<?php
// TRATAMENTO DAS VARIÁVEIS

$tituloModulo = "Usuários Cadastrados nos Componentes Externos Sistema UNI-Gespublica";
$conteudoBody = "";
$rodape = "rodape estilo";

$contasdeusuario = $this->execQuery("SELECT * FROM ". UConfig::$UDB_Prefixo ."contadeusuario_externo")[result];

foreach($contasdeusuario as $key=>$value){
	$conteudoBody.=	"<tr> 
						<td>".$value['nome']."</td>
						<td>".$value['email']."</td>
						<td>".$value['cpf']."</td>
					</tr>";
} 
// FIM TRATAMENTO DAS VARIÁVEIS
?>
