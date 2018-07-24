<?php
namespace Core;
use Core\Debugger as d;
use Core\BaseDataBase;
use Core\Session;
use Core\Redirect;
use Storage\DBConf;
use App\Config;
use DateTime;
/**
* @developer 	Michel Larrosa
* @package    WS.Sistema
* @version    Websailor-Alfa-2018
* @copyright  Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
* @license    Creative Commons License version 4; see LICENSE.txt
*/
class BaseAuth extends BaseDataBase{

  public function __construct(){
    parent::__construct();
  }
  public function getMenuList($u_categoria, $u_email){
    ### MENUS - acessíveis pelo atual usuário
    echo "here";
    $select = "SELECT DISTINCT p.rota, p.nome, p.titulo
      FROM paginas as p, composicao as c, visibilidade as v, usuario as u,
      atuacao as a, componentes as ct, modulos as m
      WHERE v.categorias = {$u_categoria}
      AND u.email = '{$u_email}' AND c.modulos = v.modulos AND p.id = c.paginas
      AND a.usuario = u.id AND ct.areas = a.areas AND m.componente = ct.id";
    $exec=$this->execQuery($select);
    // d::b($exec);
    if($exec['status']) {
      if($exec['numRows']>0) {
        d::b($exec['result']);
        return $exec['result'];
      }else{
        return NULL;
      }
    }else{
      return NULL;
      // query errado
    }
  }
  public function execLogin($email, $password){
    // Debugger::p_r($_SESSION);
    $exec = $this->execQuery("SELECT categoria FROM usuario WHERE email='{$email}' AND password='".hash(Config::$Hash_algo, $password)."'");
    if($exec['status']){
      if($exec['numRows'] == 1 && isset($exec['result'][0]['categoria'])){ //evitando problemas
        $_SESSION['email'] = $email;
        $_SESSION['categoria'] = $exec['result'][0]['categoria'];
        $_SESSION['usession'] = hash(hash_algos()[mt_rand(0, 45)], mt_rand());;
        $_SESSION['upages']=$this->getMenuList($exec['result'][0]['categoria'], $email);
        $upQuery="UPDATE usuario SET session = '".$_SESSION['usession']."', session_time = now() WHERE email='{$email}'";
        $exec=$this->execQuery($upQuery);
        if($exec['status']){
          // d::b($this->getMenuList($exec['result'][0]['categoria'], $email));
          Redirect::route($_SESSION['last_url']);
          // return $_SESSION['SESSION']; //ok
        }else{
            echo $upQuery;
        }
      }else{
        echo 'Senha e/ou Email incorretos!';
        // Redirect::route(Config::$login_route[$escopo], array('login_message'=>'Senha e/ou Email incorretos!'));
      }
    }else{
      echo "INTERNAL FAIL";
    } //erro interno
  }

  public function verificaLogin($escopo, $url){
    // PRIMEIRO VERIFICO ESCOPO DA ROTA
    // $exec = $this->execQuery("SELECT escopo FROM rotas WHERE rota='{$rota}'");
    // if ($exec['numRows']==1 && isset($exec['result'][0]['escopo'])) {
    //   $escopo = $exec['result'][0]['escopo'];
    // }else {
    //   echo file_get_contents("../system/administrator/static/nao_encontrada_db.html");
    //   return;
    // }

    if ($escopo == 'operacional' || $escopo == 'admin' || $escopo== 'registrado') { // página é acessível somente pela equipe operacional ou registrados
      // SEGUNDO VERIFICO ESCOPO DA CATEGORIA DO USUARIO
      // VERIFICO SE EXISTE ALGUÉM LOGADO
      if(isset($_SESSION['usession']) && isset($_SESSION['categoria'])){ // se estiver logado ambos devem estar setados e não nulos
        if($_SESSION['usession']!= NULL && !empty($_SESSION['usession']) && $_SESSION['categoria']!= NULL && !empty($_SESSION['categoria'])) {

          // DESCUBRO SE O ESCOPO É O MESMO E SE A SESSION É VALIDA
          $query = "SELECT u.session_time, u.categoria, c.escopo
          FROM usuario as u, categorias as c WHERE u.session= '{$_SESSION['usession']}' AND u.categoria = c.id";
          $exec = $this->execQuery($query);
          if($exec['numRows'] == 1 && isset($exec['result'][0]['escopo'])){
            // existe usuário utilizando essa session
            // comparo o escopo
            if ($exec['result'][0]['escopo'] == $escopo) {
              //agora vamos ver se essa session é temporalmente válida
              if (isset($exec['result'][0]['session_time'])) {
                $hatual = new Datetime(date("Y-m-d H:i:s"));
                $sessionDateTime = new Datetime($exec["result"][0]["session_time"]);
                if(date_diff($hatual, $sessionDateTime)-> h <= 24){
                  return TRUE;
                }else{
                  Redirect::route(Config::$login_route[$escopo], array('last_url'=>$url));
                }
              }
            }else { // está logado mas em um escopo diferente, sair e entrar com outro login, se tiver
              echo file_get_contents("../system/administrator/static/acesso_indisponivel.html");
            }
          }else{ // session não existe no BD, provavel foi feito loggout
            Redirect::route(Config::$loginRoute[$escopo], array('last_url'=>$url));
          }
        }else{ // não está logado
          Redirect::route(Config::$loginRoute[$escopo], array('last_url'=>$url));
        }
      }else{ // não está logado
        Redirect::route(Config::$loginRoute[$escopo], array('last_url'=>$url));
      }
    }else{
      return TRUE;
    }// É PUBLICO, siga em frente
  }



  function execLogout(){
    $query = "SELECT c.escopo
      FROM usuario as u, categorias as c
      WHERE u.session= '{$_SESSION['usession']}' AND c.id=u.categoria";
    $exec = $this->execQuery($query);
    if($exec['numRows'] == 1 && isset($exec['result'][0]['escopo'])){
      $escopo = $exec['result'][0]['escopo'];
      $update="UPDATE usuario SET session = '' WHERE session = '{$_SESSION['usession']}'";
      if ($this->execQuery($update)) {
        Redirect::route(Config::$login_route[$escopo]);
      }else {
        //return FALSE;
      }
    }
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

}
