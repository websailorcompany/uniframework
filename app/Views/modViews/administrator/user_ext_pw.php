<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset','UTF-8');
//VARIÁVEIS INICIAIS
$warning;
$conteudoHeader="";
$conteudoBody="";
$rodape="";

//PROCESSAMENTO CARREGADO

if(isset($_GET['warning_edit'])){
	if($_GET['warning_edit']=='ok'){
		$warning = "Usuário/Servidor atualizado com êxito!";
	}
	else{
		$warning = "Alteração de Usuário/Servidor falhou!";
	}
}
if(isset($_POST['inputServidorCPF'], $_POST['inputPassword'], $_POST['inputPasswordConfirm']) && !empty($_POST['inputPassword']) && !empty($_POST['inputPasswordConfirm']) && !empty($_POST['inputServidorCPF'])){
	$update = $this->updateExternalUser($_POST['inputServidorCPF'], $_POST['inputPassword'], $_POST['inputPasswordConfirm']);
	if($update[status]){
		header("location: ./?menu=13&warning_edit=ok");
	}else{
		// header("location: ./?menu=9&warning_edit=".$update['message']); //debugger
		header("location: ./?menu=13&warning_edit=fail-".$update['message']);
	}
}

// TRATAMENTO DAS VARIÁVEIS

$contasdeusuario_ext = $this->execQuery("SELECT * FROM ". UConfig::$UDB_Prefixo ."contadeusuario_externo ORDER BY id")['result'];
$cadastrados="";
foreach($contasdeusuario_ext as $cadastro){
	$cadastrados.="<option value=".$cadastro['cpf'].">".$cadastro['nome']."</option>";
}

// TRATAMENTO DAS VARIÁVEIS PRINCIPAIS
$warning = 	(	empty($warning)? "":
				"<div class='callout callout-info'>
					<h4>Informação!</h4>
						". $warning ."
					<br><a href='./'>Analise a documentação</a>
				</div>"
			);
$conteudoHeader = "Alteração de senhas de cidadãos/cidadãs cadastrados(as) externamente ";
$conteudoBody="
	<form class='form-horizontal' id='renewsenha' action='./' method='post'>
		<input type='hidden' name='menu' value='13'>
		<div class='form-group'>
			<label for='inputServidorCPF' class='col-sm-2 control-label'>Servidor Público</label>
			<div class='col-sm-10'>
				<select class='form-control' id='inputServidorCPF' name='inputServidorCPF'>
					<option>--cadastrados--</option>
					". $cadastrados ."
				</select>
			</div>
		</div>
		<div class='form-group'>
			<label for='inputPassword' class='col-sm-2 control-label'>Email</label>
			<div class='col-sm-10'>
				<input class='form-control' id='inputEmail' name='inputPassword' placeholder='Senha' type='password'>
			</div>
		</div>
		<div class='form-group'>
			<label for='inputPasswordConfirm' class='col-sm-2 control-label'>Password</label>
			<div class='col-sm-10'>
				<input class='form-control' id='inputPasswordConfirm' name='inputPasswordConfirm' placeholder='Confirmação' type='password'>
			</div>
		</div>
	</form>";
	
$rodape = "	<button type='submit' class='btn btn-default'>Cancelar</button>
            <button type='submit' class='btn btn-info pull-right' form='renewsenha'>Sign in</button>";

// FIM TRATAMENTO DAS VARIÁVEIS

$modReturn ="
	<html>
		<div id='conteudo'>
			<section class='col-sm-12 col-lg-12 col-md-12 col-xs-12 table-responsive connectedSortable ui-sortable' id='mod'>
					". $warning ."
					<div class='box box-success' id='box'>
						<div id='box-header' class='box-header with-border'>
						<h3 id='box-title' class='box-title'>" . 
						
						$conteudoHeader
						
						. "</h3>
						<div id='box-tools' class='box-tools pull-right'>
							<span id='label' class='label label-primary'></span>
						</div>
						
						</div>
						<div id='box-body' class='box-body'>".
						
						$conteudoBody
						
						."</div>
						<div id='box-footer' class='box-footer'>".
						
						$rodape
						
						."</div>
					</div>
				</section>
		</div><!-- /#conteudo -->
	</html>
			";
echo utf8_decode($modReturn);
?>