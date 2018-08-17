<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset','UTF-8');
//PROCESSAMENTO CARREGADO

	if(isset($_POST['createInputNome'], $_POST['createInputCPF'], $_POST['createInputEmail'], $_POST['createInputPassword'], $_POST['createInputPasswordConfirm'], $_POST['createInputACL'], $_POST['createInputCategoria']) && !empty($_POST['createInputNome']) && !empty($_POST['createInputCPF']) && !empty($_POST['createInputEmail']) && !empty($_POST['createInputPassword']) && !empty($_POST['createInputPasswordConfirm'])&& !empty($_POST['createInputACL'])&& !empty($_POST['createInputCategoria'])){
	
		// if(isset($_FILES))	{
			
			// $uploaddir = './imagens/profile/';
			// $extensao = strtolower(end(explode('.', $_FILES['fotoInputFile']['name'])));
			// $uploadfile = $uploaddir . md5(time()).".".$extensao;

			// if(move_uploaded_file($_FILES['fotoInputFile']['tmp_name'], $uploadfile)) {
				// $warning .= "Arquivo enviado com sucesso.\n";
			// }else{
				// // $warning .= "Não foi possível fazer o upload de arquivo!\n";
				// $warning .= $_FILES['fotoInputFile']['name'];
			// }
		// }
		$create = $this->createUser($_POST['createInputNome'], $_POST['createInputEmail'], $_POST['createInputCPF'], $_POST['createInputPassword'], $_POST['createInputPasswordConfirm'], $_POST['createInputACL'], $_POST['createInputCategoria']);
		if($create['status']){
			$warning = "Novo usuário cadastrado com sucesso em nossa base de dados!";
		}else{
			$warning = $create['message'];
		}
		$warning="
				<div class='callout callout-info'>
					<h4>Informação!</h4>
						". $warning ."
					<br><a href='./'>Analise a documentação</a>
				</div>";
	}else{
		$warning = "";
	}


// TRATAMENTO DAS VARIÁVEIS

$conteudoBody = "Criar Usuários";
$rodape = "<button type='submit' class='btn btn-primary' form='createform'>Criar usuário!</button>";

$contadeusuario = $this->execQuery("SELECT * FROM uni.contadeusuario")[result][0];

// ./administrador/_MODULES/user_create.php

$conteudoBody="
	<form id='createform' action='./' method='post'>
			<input type='hidden' name='menu' value=10>
		<div class='form-group'>
			<label for='createInputNome'>Nome completo</label>
			<input class='form-control' id='createInputNome' name='createInputNome' placeholder='Entre com o nome' type='text'>
		</div>
		<div class='form-group'>
			<label for='createInputCPF'>CPF para identificação</label>
			<input class='form-control' id='createInputCPF' name='createInputCPF' placeholder='Entre com o CPF' type='text'>
		</div>
		<div class='form-group'>
			<label for='createInputEmail'>E-mail para Login/Contato</label>
			<input class='form-control' id='createInputEmail' name='createInputEmail' placeholder='Entre com o email' type='email'>
		</div>
		<div class='form-group'>
			<label for='createInputACL'>ACL</label>
			<select class='form-control' id='createInputACL' name='createInputACL'>
				<option value=2>Admin</option>
				<option value=3>Financeiro</option>
				<option value=4>Recursos Humanos</option>
				<option value=5>Marketing</option>
				<option value=6>Ambiental</option>
			</select>
		</div>
		<div class='form-group'>
			<label for='createInputCategoria'>Categoria</label>
			<select class='form-control' id='createInputCategoria' name='createInputCategoria'>
				<option value=2>Diretor</option>
				<option value=3>Gerencial</option>
				<option value=4>Técnico 1</option>
				<option value=5>Técnico 2</option>
				<option value=6>Operacional 1</option>
				<option value=7>Operacional 2</option>
				<option value=8>Operacional Estágio</option>
			</select>
		</div>
		<div class='form-group'>
			<label for='createInputPassword'>Password</label>
			<input class='form-control' id='createInputPassword' name='createInputPassword' placeholder='Senha' type='password'>
		</div>
		<div class='form-group'>
			<label for='createInputPasswordConfirm'>Password</label>
			<input class='form-control' id='createInputPasswordConfirm' name='createInputPasswordConfirm' placeholder='Confirmação de senha' type='password'>
		</div>
		<div class='form-group'>
			<label for='fotoInputFile'>File input</label>
			<input id='fotoInputFile' name='fotoInputFile' type='file'>

			<p class='help-block'>Arquivos do tipo JPG, JPEG, PNG, GIF com até 300KB.</p>
		</div>
		<div class='checkbox'>
			<label>
				<input type='checkbox'> Enviar dados por email (versão de testes)
			</label>
		</div>
	<form>
";

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
			</div>		
		
		</html>
			";
echo utf8_decode($modReturn);
?>