<?php
namespace Core;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */
class BaseValidator{

  function __construct(){
    # code...
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
