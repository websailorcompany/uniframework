<?php
/**
 * @package    UNI.Sistema
 *
 * @copyright  Copyright (C) 2016 - 2017 Websailor®. All rights reserved.
 * @license    GNU General Public License version 1 or later; see LICENSE.txt
 * @Developer 	Michel Larrosa [suporte AT michel DOT eng DOT br]
 */

defined('_UNIEXEC') or die;
namespace Uni;

Class uniPublic extends uniFile{ //uniFile temporariamente, no futuro volta para uniData

	public function __construct(){
		parent::__construct();
	}

	function loginExternalUser($email, $password){
		$mail = $this->execQuery("SELECT id FROM ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE email='".$email."'");
		if($mail['status']){
			if($mail['numRows']==1){
				$execLogin = $this->execQuery("SELECT id FROM ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE id='".$mail['result'][0]['id']."' AND password='".hash(UConfig::$UHash_algo, $password)."'");
				if($execLogin['status']){
					if($execLogin['numRows'] == 1){
						$id = $execLogin["result"][0]["id"];
						$sessionid = hash(hash_algos()[mt_rand(0, 45)], mt_rand());
						$this->execQuery("UPDATE ". UConfig::$UDB_Prefixo ."contadeusuario_externo SET sessionid = '$sessionid' , sessiondatetime = now() WHERE id=$id");
						return array("status"=>TRUE,"message"=>"success","session"=>$sessionid); //ok
					}else{return array("status"=>FALSE,"message"=>"Erro00");} //senha ou email incorretos
				}else{return array("status"=>FALSE,"message"=>"Erro02");} //erro interno
			}else{return array("status"=>FALSE,"message"=>"email");} //email não cadastrado
		}else{return array("status"=>FALSE,"message"=>"Erro01");} //erro interno
	}

	function logoutExternalUser(){
		$this->execQuery("UPDATE ". UConfig::$UDB_Prefixo ."contadeusuarioexterno SET session = '' , sessiondatetime = now() WHERE session = '". $_SESSION['session_ext'] ."'");
		unset($_SESSION['session_ext']);
	}

	function verificaExternalUser($sessionid){
		if(isset($sessionid)){
			if(is_string($sessionid) && !empty($sessionid)){
				$session = $this->execQuery("SELECT sessiondatetime FROM ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE sessionid='$sessionid'");
				if($session['numRows'] == 1){
					$hatual = new Datetime(date("Y/m/d H:i:s"));
					$sessionDateTime = new Datetime($session["result"][0]["sessiondatetime"]);
					if(date_diff($hatual, $sessionDateTime)-> h <= 1){
						return 1;
					}else{	return 2;	}
				}else{	return 0; }
			} else{	return NULL; } //parâmetro não é string ou é vazio
		} else{	return NULL; } //falta parâmetro
	}

	function createExternalUser($nome, $CPF, $senha, $email){
		if(isset($email) AND isset($senha) AND isset($CPF) AND isset($nome)){
			if(is_string($email) AND is_string($senha) AND is_string($CPF) AND is_string($nome)){
				if(!empty($email) AND !empty($senha) AND !empty($CPF) AND !empty($nome)){
					if($this->execQuery("SELECT CPF from ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE CPF='$CPF'")['numRows'] == 0){
						if($this->execQuery("SELECT email from ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE email='$email'")['numRows'] == 0){
							$insert = "INSERT INTO ". UConfig::$UDB_Prefixo ."contadeusuario_externo (nome, CPF, password, email) VALUES ('$nome', '$CPF', '".hash(UConfig::$UHash_algo, $senha)."', '$email')";
							if($this->execQuery($insert)['status']){
								$id = execQuery("Select id from ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE CPF='$CPF'")['result'][0]['id'];
								return array("status"=> TRUE, "message"=> $CPF, "id"=>$id);
							}
							// else{ return array("status"=> FALSE, "message"=> 'Erro:00:interno'); }
							else{ return array("status"=> FALSE, "message"=> 'Erro:00'); } // :Falha no Query
						}else{ return array("status"=> FALSE, "message"=> 'Erro:01'); } // :EMAIL em uso
					}else{ return array("status"=> FALSE, "message"=> 'Erro:02'); } // :CPF em uso
				}else{ return array("status"=> FALSE, "message"=> 'Erro:03'); } //:parâmetros inválidos
			}else{ return array("status"=> FALSE, "message"=> 'Erro:04'); } // :parâmetros inválidos
		}else{ return array("status"=> FALSE, "message"=> 'Erro:05'); } // :faltam parâmetros
	}

	function createExternalUserCompleto($nome, $CPF, $senha, $email, $rg, $nascimento, $empresa, $profissao, $end_cep, $end_estado, $end_cidade, $end_bairro, $end_rua, $end_num, $end_compl, $telefone){
		if(isset($email) AND isset($senha) AND isset($CPF) AND isset($nome)){
			if(is_string($email) AND is_string($senha) AND is_string($CPF) AND is_string($nome)){
				if(!empty($email) AND !empty($senha) AND !empty($CPF) AND !empty($nome)){
					if($this->execQuery("SELECT CPF from ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE CPF='$CPF'")['numRows'] == 0){
						if($this->execQuery("SELECT email from ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE email='$email'")['numRows'] == 0){
							$insert = "INSERT INTO ". UConfig::$UDB_Prefixo ."contadeusuario_externo (nome, CPF, password, email, rg, nascimento, empresa, profissao, end_cep, end_estado, end_cidade, end_bairro, end_rua, end_num, end_compl, telefone) VALUES ('$nome', '$CPF', '".hash(UConfig::$UHash_algo, $senha)."', '$email', '$rg', '$nascimento', '$empresa', '$profissao', '$end_cep', '$end_estado', '$end_cidade', '$end_bairro', '$end_rua', '$end_num', '$end_compl', '$telefone')";
							if($this->execQuery($insert)['status']){
								$id = $this->execQuery("Select id from ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE CPF='$CPF'")['result'][0]['id'];
								return array("status"=> TRUE, "message"=> $CPF, "id"=>$id);
							}
							// else{ return array("status"=> FALSE, "message"=> 'Erro:00:interno'); }
							else{ return array("status"=> FALSE, "message"=> $insert); }
						}else{ return array("status"=> FALSE, "message"=> 'Erro:01'); } // :EMAIL em uso
					}else{ return array("status"=> FALSE, "message"=> 'Erro:02'); } // :CPF em uso
				}else{ return array("status"=> FALSE, "message"=> 'Erro:03'); } //:parâmetros inválidos
			}else{ return array("status"=> FALSE, "message"=> 'Erro:04'); } // :parâmetros inválidos
		}else{ return array("status"=> FALSE, "message"=> 'Erro:05'); } // :faltam parâmetros
	}

	function updateExternalUser($CPF, $senha, $novaSenha){
		if(isset($senha) AND isset($CPF)){
			if(is_string($senha) AND is_string($CPF)){
				if(isset($novaSenha)){
					return "update $novaSenha";
				}else{ return "A função precisa de no mínimo 3 parâmetros." ; }
			}else{ return "parâmetros inválidos" ; }
		}else{ return "faltam parâmetros"; }
		//$CPF e $senha obrigatórios
		//o campo que estiver vazio continua inalterado
	}

	function deleteExternalUser($CPF){
		if($this->execQuery("DELETE FROM ". UConfig::$UDB_Prefixo ."contadeusuario_externo WHERE CPF='$CPF'")['status']){
			return "DELETADO";
		}else{
			return "NÃO DELETADO";
		}
	}
}
