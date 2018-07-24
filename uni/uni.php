<?php
/**
 * @package    UNI.Sistema
 *
 * @copyright  Copyright (C) 2016 - 2017 Websailor®. All rights reserved.
 * @license    GNU General Public License version 1 or later; see LICENSE.txt
 * @Developer 	Michel Larrosa [suporte AT michel DOT eng DOT br]
 * UNI is a WEBSAILOR.platform fork
 */

defined('_UNIEXEC') or die;
namespace Uni;

Class uni extends uniData{

	public function __construct(){
		parent::__construct();
	}

	function verificaLoginOnLine(){
		// if(isset($_COOKIE['unidan'])){
		if(isset($_SESSION['SESSION'])){
			// $sessionid = addslashes($_COOKIE['unidan']);
			$sessionid = $_SESSION['SESSION'];
			if($sessionid){
				$session = $this->execQuery("SELECT sessiondatetime FROM ". UConfig::$UDB_Prefixo ."contadeusuario WHERE sessionid='$sessionid'");
				if($session['numRows'] == 1){
					$hatual = new Datetime(date("Y-m-d H:i:s"));
					$sessionDateTime = new Datetime($session["result"][0]["sessiondatetime"]);
					if(date_diff($hatual, $sessionDateTime)-> h <= 1){
						return 1;
					}else{	return 2;	}
				}else{return 0;}
			}
		}
		return FALSE;
	}

	function Menu(){
		if($this->verificaLoginOnLine()){
			$menu = array();
			//a opção de conexoes alternadas em loop caiu-por-terra na analise assintótica
			//M F-N-M DQ F F M
			$areas = json_decode($this->execQuery("
			SELECT areas FROM ". UConfig::$UDB_Prefixo ."acl as acl WHERE id = ( SELECT ACL from ". UConfig::$UDB_Prefixo ."contadeusuario 	WHERE sessionid = '". $_SESSION['SESSION'] ."')")['result'][0]['areas']);

			foreach($areas as $key => $value){
				$areaComponente[] = $this->execQuery("SELECT c.nome as componente, m.id as menu, m.nome as pagina, m.titulo as titulo FROM ". UConfig::$UDB_Prefixo ."componentes as c, ". UConfig::$UDB_Prefixo ."menus as m WHERE c.areas=$value AND m.componente=c.id  AND m.nivel=".$_SESSION['USER']['nivel']." ORDER BY menu")['result'];
			}
			foreach($areaComponente as $key => $componenteMenu){
				foreach($componenteMenu as $key => $value){
					$menu[$value['componente']][$value['pagina']] = array("menu"=>$value['menu'], "titulo"=> $value['titulo']);
				}
			}
		}
		return $menu;
	}

	function Modulos(){
		if($this->verificaLoginOnLine()){
			$modulos = $this->execQuery("SELECT m.id, m.modulo, p.posicao FROM ". UConfig::$UDB_Prefixo ."modulos as m, ". UConfig::$UDB_Prefixo ."posicoes as p WHERE m.nivel = ". $_SESSION['USER']['nivel'] ." AND p.id = m.posicao AND m.menu = ". $_SESSION['MENU']['id'] ."")['result'];
			return $modulos;
		}
	}

	function manager($admpath){
		foreach($_REQUEST as $key=>$value){
			$$key=$value;
		}
		if(isset($uni)){
			$this->execLogin($login['user'], $login['password']);
			header("location:" . $_SERVER["PHP_SELF"]);
		}elseif(isset($logout)){
			$this->execLogout();
			header("location:" . $_SERVER["PHP_SELF"]);
		}elseif(!$this->verificaLoginOnLine()){
			include(UNIPATH_ADM . "/login.php");
		}else{
			return TRUE;
		}
	}

	function execute(){
		if($this->verificaLoginOnLine()){
			$unimodel = new \DOMDocument('1.0', 'utf-8');
			// $unimodel->formatOutput = true;
			libxml_use_internal_errors(true); //TOTALMENTE NECESSÁRIO, ÚTIL DESABILITAR SOMENTE PARA VER ERROS HUMANOS
			$unimodel->loadHTMLFile($_SESSION['TEMPLATE']);
			//DADOS DO SISTEMA ##### INICIO #####

			foreach($unimodel->getElementsByTagName('span') as $DOMElement){
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logo-mini')? TRUE : FALSE))
					$DOMElement->appendChild(new DOMElement('b', UConfig::$UNome));
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logo-lg')? TRUE : FALSE))
					$DOMElement->appendChild(new DOMElement('b', UConfig::$UNome));
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logo-lg')? TRUE : FALSE))
					$DOMElement->appendChild(new DOMText(UConfig::$UNomeSufixo));
			}
			//falta breadcrumbs e similares

			//DADOS DO SISTEMA ##### FIM
			//
			//
			//DADOS DO USUARIO ##### INICIO #####

			foreach($unimodel->getElementsByTagName('p') as $DOMElement){
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logedusername')? TRUE : FALSE)) $DOMElement->appendChild(new DOMText($_SESSION['USER']['nome']));
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logeduserpro')? TRUE : FALSE)) $DOMElement->appendChild(new DOMText($_SESSION['USER']['profissao']));
			}

			foreach($unimodel->getElementsByTagName('span') as $DOMElement){
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logedusername')? TRUE : FALSE)) $DOMElement->appendChild(new DOMText($_SESSION['USER']['nome']));
				if((($DOMElement->hasAttribute('class') AND $DOMElement->getAttribute('class')=='logedusercargo')? TRUE : FALSE)) $DOMElement->appendChild(new DOMText($_SESSION['USER']['cargo']));
			}

			//DADOS DO USUARIO ##### FIM
			//
			//
			//DADOS DO MENU ##### INICIO #####

			$unimenu= $unimodel->getElementById('sidebar-menu');

			$menu['capsula']= $unimenu->appendChild(new DOMElement('li', UConfig::$UDepartamento));
			$menu['capsula']->setAttribute('class', 'header');

			foreach( $this->Menu() as $componente=>$menus){
				$menu['capsula'] = $unimenu->appendChild(new DOMElement('li', ''));
				$menu['capsula'] ->setAttribute('class', '');

				$menu['a'] = $menu['capsula']->appendChild(new DOMElement('a', ''));
				$menu['a']->setAttribute('href','#');
				$menu['i'] = $menu['a']->appendChild(new DOMElement('i', ''));
				$menu['i']->setAttribute('class','fa fa-circle-o-notch');
				$menu['a']->appendChild(new DOMElement('span', $componente));

				$menu['span'] = $menu['a']->appendChild(new DOMElement('span',''));
				$menu['span']->setAttribute('class', 'pull-right-container');
				$menu['i'] = $menu['span']->appendChild(new DOMElement('i', ''));
				$menu['i']->setAttribute('class','fa fa-angle-left pull-right');
				$menu['ul'] = $menu['capsula']->appendChild(new DOMElement('ul', ''));
				$menu['ul']->setAttribute('class', 'treeview-menu');

				foreach($menus as $nome=>$atributos){

					$item['li'] = $menu['ul']->appendChild(new DOMElement('li', ''));
					//if(menu ativo) class='active'

					$item['a'] = $item['li']->appendChild(new DOMElement('a'));
					$item['a']->setAttribute('href',"./?menu=". $atributos['menu']);

					$item['i'] = $item['a']->appendChild(new DOMElement('i', ''));
					// $item['i']->setAttribute('class',$atributos['icone']);

					$item['a']->appendChild(new DOMText(" $nome "));

				}
			}
			//DADOS DO MENU ##### FIM
			//
			//
			//DADOS DO CONTEÚDO ##### INICIO #####

			$modulos = $this->Modulos();

			foreach($modulos as $value){
				$construct=$this->modMaze($_SESSION['COMPONENTE'], "_MODULES", $value['modulo']);
				// echo " # ".$value['modulo']." # "; //para testes
				$modelotemp= new DOMDocument();
				$modelotemp->loadHTML($construct);
				$modelotempnode=$modelotemp->getElementById("conteudo");
				$modelotempnode=$unimodel->importNode($modelotempnode, TRUE);
				$unimodel->getElementById($value['posicao'])->appendChild($modelotempnode);
			}

			//DADOS DO CONTEÚDO ##### FIM
			#
			//complementa o libxml_use_internal_errors, liberando a cache
			libxml_clear_errors();
			#
			$unimodel->normalizeDocument();
			echo $unimodel->saveHTML();
		}
	}

	function execLogin($login, $password){
		$execLogin = $this->execQuery("SELECT * FROM ". UConfig::$UDB_Prefixo ."contadeusuario WHERE email='$login' AND password='".hash(UConfig::$UHash_algo, $password)."'");
		if($execLogin['status']){
			if($execLogin['numRows'] == 1){ //evitando problemas
				$id = $execLogin["result"][0]["id"];
				$_SESSION['SESSION'] = hash(hash_algos()[mt_rand(0, 45)], mt_rand());;
				$this->execQuery("UPDATE ". UConfig::$UDB_Prefixo ."contadeusuario SET sessionid = '".$_SESSION['SESSION']."' , sessiondatetime = now() WHERE id=$id");
				return $_SESSION['SESSION']; //ok
			}else{ return NULL;} //senha ou email incorretos
		}else{ return "INTERNAL FAIL";} //erro interno
	}

	function execLogout(){
		$this->execQuery("UPDATE ". UConfig::$UDB_Prefixo ."contadeusuario SET sessionid = '' WHERE sessionid = '". $_SESSION['SESSION'] ."'");
	}

	function createUser($nome, $email, $CPF, $senha, $confirma, $acl, $nivel, $img=""){
		if(isset($nome, $email, $CPF, $senha, $acl, $nivel, $confirma) ){
			if($senha === $confirma){
				if(!empty($nome) && !empty($email) && !empty($CPF) &&!empty($senha) &&!empty($confirma) &&!empty($acl) &&!empty($nivel) && is_string($nome) && is_string($email) && is_string($CPF) && is_string($senha) && is_string($confirma) && is_string($acl) && is_string($nivel)){
					if($this->execQuery("SELECT cpf FROM ". UConfig::$UDB_Prefixo ."contadeusuario WHERE cpf=".$CPF)['numRows']==0){
						if($this->execQuery("SELECT email FROM ". UConfig::$UDB_Prefixo ."contadeusuario WHERE email=".$email)['numRows']==0){
							$insert = $this->execQuery("INSERT INTO ". UConfig::$UDB_Prefixo ."contadeusuario(nome, email, cpf, password, acl, nivel, img) VALUES ('$nome', '$email', '$CPF', '".hash(UConfig::$UHash_algo, $senha)."', '$acl', '$nivel', '$img')");
							if($insert[status]){
								return array("status"=>TRUE, "message"=>"");
							}else{ return array("status"=> FALSE, "message"=> $insert['message']); } // :Falha no Query
						}else{ return array("status"=> FALSE, "message"=> 'Erro:01'); } // :EMAIL em uso
					}else{ return array("status"=> FALSE, "message"=> 'Erro:02'); } // :CPF em uso
				}else{ return array("status"=> FALSE, "message"=> 'Erro:03'); } //:parâmetros inválidos
			}else{ return array("status"=> FALSE, "message"=> 'Erro:04'); } //:senhas diferentes
		}else{ return array("status"=> FALSE, "message"=> 'Erro:05'); } // :faltam parâmetros
	}


	function updateUser($FLAG, $CPF, $novaSenha='', $confirmaSenha='', $email='', $novoEmail='', $confirmaEmail=''){
		if(isset($FLAG, $CPF, $email)){
			if($FLAG == "NEW_PASSWORD"){
				if(isset($novaSenha,$confirmaSenha) && ($novaSenha == $confirmaSenha)){
					if($this->execQuery("SELECT cpf FROM ". UConfig::$UDB_Prefixo ."contadeusuario WHERE cpf='".$CPF."'")['numRows']==1){
						if($this->execQuery("UPDATE ". UConfig::$UDB_Prefixo ."contadeusuario SET password='".hash(UConfig::$UHash_algo,$novaSenha) ."' WHERE cpf='".$CPF."'")[status]){
							return array("status"=>TRUE, "message"=>"");
						}else{ return array("status"=> FALSE, "message"=> "update['message']"); } // :Falha no Query
					}else{ return array("status"=> FALSE, "message"=> 'Erro:01'); } // :CPF não existe
				}else{ return array("status"=> FALSE, "message"=> 'Erro:02'); } //:senhas diferentes
			}else{ return array("status"=> FALSE, "message"=> 'Erro:03'); } //:parâmetros inválidos - FLAG desconhecida
		}else{ return array("status"=> FALSE, "message"=> 'Erro:04'); } // :faltam parâmetros
	}
	function updateExternalUser($CPF, $senha, $novaSenha){
		if(isset($senha) AND isset($CPF)){
			if(is_string($senha) AND is_string($CPF)){
				if(isset($novaSenha) && ($novaSenha == $senha)){
					if($this->execQuery("UPDATE ". UConfig::$UDB_Prefixo ."contadeusuario_externo SET password='".hash(UConfig::$UHash_algo,$novaSenha) ."' WHERE cpf='".$CPF."'")[status]){
						return array("status"=>TRUE, "message"=>"");
					}else{ return array("status"=> FALSE, "message"=> "update['message']"); } // :Falha no Query
				}else{ return array("status"=> FALSE, "message"=> "Erro: 01"); } // :senhas não batem
			}else{ return array("status"=> FALSE, "message"=> "Erro 02:"); } // :dados inválidos
		}else{ return array("status"=> FALSE, "message"=> "Erro:03"); } // :Faltam parâmetros
		//$CPF e $senha obrigatórios
		//o campo que estiver vazio continua inalterado
	}
	function deleteUser(){
		//
	}
}
?>
