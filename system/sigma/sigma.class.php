<?php

/**
 *
 */
class sigma {

  function __construct(){
    # code...
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
}
