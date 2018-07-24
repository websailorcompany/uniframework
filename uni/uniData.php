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

Class uniData{
	public $db_user;
	public $db_password;
	public $db_sgdb;
	public $db_host;
	public $db_chosen;
	public $db_port;
	public $db_dsn;
	public $db_charset;
	private $db_connect;

	public function __construct(){
		$this->db_sgdb = Uconfig::$conn_sgdb;
		$this->db_host = Uconfig::$conn_host;
		$this->db_chosen = Uconfig::$conn_db;
		$this->db_port = Uconfig::$conn_port;
		$this->db_user = Uconfig::$conn_user;
		$this->db_password = Uconfig::$conn_password;
		$this->db_charset = "utf8mb4";
		$this->db_dsn="$this->db_sgdb:dbname=$this->db_chosen;host=$this->db_host;port=$this->db_port"; //funciona com pgsql e mysql

		if($this->db_sgdb=="mysql"){$this->db_options=array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");}

		/*CRIAR $connect = new PDO($this->db_dsn, $this->db_user, $this->db_password, $this->db_options);	*/
		/* AQUI, ANTES DA FUNÇÃO EXECQUERY*/
	}

	// FUNÇÕES CÓPIA DA PRATFORMA WEBSAILOR

	public function execQuery($query){
		if(isset($query)){
			if(is_string($query) && !empty($query)){
				try{
					$connect = new PDO($this->db_dsn, $this->db_user, $this->db_password, $this->db_options);
					if(!$connect){
						throw new PDOException();
					}else{
						$result_o = $connect->query($query);
						if($result_o){
							$result= $result_o->fetchAll(PDO::FETCH_ASSOC);
							return array("status"=>1, "result"=>$result, "numRows"=>count($result),"message"=>"$query");
						}else{
							return array("status"=>0, "result"=>NULL, "numRows"=>0,"message"=>"$query");
						}
					}
				}catch(PDOException $e){return array("status"=>0, "result"=>NULL, "numRows"=>0,"message"=>$e->getMessage());}
			}else{return array("status"=>0, "result"=>NULL, "numRows"=>0,"message"=>"Query vazio ou datatype diferente.");	}
		}else{return array("status"=>0, "result"=>NULL, "numRows"=>0,"message"=>"Falta parâmetro Query.");}
	}

	public function uniFileUploader($name, $authorized_extensions, $uploaddir="./", $rename=""){/* $name é o name dentro do form*/
	    $extension = strtolower(end(explode('.', $_FILES[$name]['name'])));
	    if(in_array($extension, $authorized_extensions)){
	        $uploadfile = ($rename==""? $uploaddir.$_FILES[$name]['name']: $uploadfile = $uploaddir.$rename.$extension);
    	    if(move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
    			return "Arquivo enviado com sucesso.\n";
    		}else{  return "Não foi possível fazer o upload de arquivo!\n"; }
	    }else{  return "Arquivo não autorizado";    }
	}

	public function modMaze($componente, $level, $modulo){
		if(isset($componente) && isset($level) && isset($modulo)){
			if(is_string($componente)){
				if(is_string($level)){
					if(is_string($modulo)){
						$modFile = "componentes/" . strtoupper($componente). "/" . $level ."/". $modulo .".php";
						if(file_exists($modFile)){
							ob_start();
							// Imprime a página, mas ela não irá aparecer, porque será guardada no buffer.
							require($modFile);
							// Pega a guardada pelo buffer e salva na variável "$modReturn".
							$modReturn = ob_get_contents();
							// Limpa o buffer.
							ob_end_clean();
							// retorna
							return $modReturn;
						}else{	return $modFile;	}
					}else{	return "ERRO: o terceiro parâmetro espera um dado do tipo STRING";	}
				}else{	return "ERRO: o segundo parâmetro espera um dado do tipo STRING";	}
			}else{	return "ERRO: o primeiro parâmetro espera um dado do tipo STRING";	}
		}else{	return "ERRO: faltam parâmetros";	}
	}

	public function scriptMaze($function, $data){
		if(isset($function) && isset($data)){
			if(is_string($function)){
				if(is_string($data)){
					$scriptFile = "framework/scriptcase/".$function."/".$function.".php";
					if(file_exists($scriptFile)){
						ob_start();
						// Imprime a página, mas ela não irá aparecer, porque será guardada no buffer.
						require($scriptFile);
						// Pega a guardada pelo buffer e salva na variável "$scriptReturn".
						$scriptReturn = ob_get_contents();
						// Limpa o buffer.
						ob_end_clean();
						// retorna
						return $scriptReturn;
					}else{	return $scriptFile;	}
				}else{	return "ERRO: o segundo parâmetro espera um dado do tipo STRING";	}
			}else{	return "ERRO: o primeiro parâmetro espera um dado do tipo STRING"; }
		}else{	return "ERRO: faltam parâmetros";	}
	}

	public function verifyFormat($format, $object){

		if(isset($format) && isset($object)){
			if(is_string($format) && is_string($object)){
				switch($format){

					case "DATE_BIRTHDAY":
						$date = explode("/", $object);
						if(count($date)==3){
							if(ctype_digit($date[0]) && ctype_digit($date[1]) && ctype_digit($date[2]) && (strlen($date[0])==4) && (strlen($date[1])==2) && (strlen($date[2])==2) ){
								if($date[0]<(date('Y')-18) && $date[0]>(date('Y')-150) && $date[1]>0 && $date[1]<13 && $date[2]>0 && $date[2]<31 ){// não trata dias/mes variação anual
									return array("status"=>TRUE,"message"=>$object);
								}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
							}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						break;

					case "DATE_BRAZIL_BIRTHDAY":
						$date = explode("/", $object);
						if(count($date)==3){
							if(ctype_digit($date[0]) && ctype_digit($date[1]) && ctype_digit($date[2]) && (strlen($date[0])==2) && (strlen($date[1])==2) && (strlen($date[2])==4)){
								if($date[0]>0 && $date[0]<31 && $date[1]>0 && $date[1]<13 && $date[2]<(date('Y')-18) && $date[2]>(date('Y')-150) ){
								return array("status"=>TRUE,"message"=>$object);
								}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
							}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						break;

					// case "DATE":
					// break;

					// case "DATE_BRAZIL":
					// break;

					case "CPF":
						$cpf = explode(".", $object);
						if(count($cpf)==3){
							if(ctype_digit($cpf[0]) && ctype_digit($cpf[1]) && (strlen($cpf[0])==3) && (strlen($cpf[1])==3)){
								$cpf = explode("-", $cpf[2]);
								if(count($cpf)==2){
									if(ctype_digit($cpf[0]) && ctype_digit($cpf[1]) && (strlen($cpf[0])==3) && (strlen($cpf[1])==2)){
										return array("status"=>TRUE,"message"=>$object);
									}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
								}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
							}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						break;

					case "PHONE":
						if(($object[0]=='(') && ctype_digit($object[1]) && ctype_digit($object[2]) && ($object[3]==')')){
							$phone=substr($object, 4);
							$phone = explode("-", $phone);
							if(count($phone)==2){
								if((strlen($phone[1])==4) && ctype_digit($phone[1])){
									if((strlen($phone[0])==4) && ( $phone[0][0] == '3') && ctype_digit($phone[0])){
										return array("status"=>TRUE,"message"=>$object);
									}elseif((strlen($phone[0])==5) && ( $phone[0][0] == '9') && ctype_digit($phone[0])){
										return array("status"=>TRUE,"message"=>$object);
									}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
								}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
							}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						break;

					case "EMAIL": //resolveria facilmente se soubesse expressões regulares
						$email = explode("@",$object);
						if(count($email)==2){
							if(!empty($email[0]) && !empty($email[1])){
								if(ctype_alnum(str_replace("-","",str_replace("_","",$email[0]))) && !ctype_digit(str_replace("-","",str_replace("_","",$email[0]))) && ctype_alnum(str_replace(".","",str_replace("-","",str_replace("_","",$email[1])))) && !ctype_digit(str_replace(".","",str_replace("-","",str_replace("_","",$email[1]))))){
									$dominio = explode(".", $email[1]);
									if(count($dominio)>1 && count($dominio)<5){//varias possibilidades
										foreach($dominio as $parte){
											if(strlen($parte)<2 || strlen($parte)>64){
												return array("status"=>FALSE,"message"=>"Formato incorreto 00 para ".$format);
											}
											if($parte[0]=="-" || $parte[0]=="_" || $parte[strlen($parte)-1] == "-" || $parte[strlen($parte)-1] == "_"){
												return array("status"=>FALSE,"message"=>"Formato incorreto 11 para ".$format);
											}
										}
										return array("status"=>TRUE,"message"=>$object);
									}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
								}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
							}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						}else{return array("status"=>FALSE,"message"=>"Formato incorreto para ".$format);}
						break;

					// case "CEP":
					// break;

					// case "CNPJ":
						// break;

					default:
						return FALSE; //"FORMAT NOT SUPORTED"
						break;
				}
			}else{return array("status"=>FALSE,"message"=>"Parâmetros inválidos");}
		}else{return array("status"=>FALSE,"message"=>"Faltam parâmetros");}
	}
}
