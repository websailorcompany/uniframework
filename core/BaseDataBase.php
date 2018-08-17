<?php
namespace Core;
use App\Config;
use Storage\DBConf;
use Core\Debugger as d;
use PDO;
/**
* @developer 	Michel Larrosa
* @package    WS.Sistema
* @version    Websailor-Alfa-2018
* @copyright  Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
* @license    Creative Commons License version 4; see LICENSE.txt
*/
class BaseDataBase{
  protected $dsn;
  private $DBConf;
  private $DBOptions;
  public function __construct(){
		if(DBConf::$SGDB=="mysql"){
      # configuração principal dsn
      //funciona com pgsql e mysql
      $this->dsn = DBConf::$SGDB.":dbname=".DBConf::$DB.";host=".DBConf::$HOST.";port=".DBConf::$PORT;
      # altere como quiser
      $this->DBOptions = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
    }

		/*CRIAR $connect = new PDO($this->db_dsn, $this->db_user, $this->db_password, $this->db_options);	*/
		/* AQUI, ANTES DA FUNÇÃO EXECQUERY*/
  }
  public function execQuery($query){
		if(isset($query)){
			if(is_string($query) && !empty($query)){
				try{
					$connect = new PDO($this->dsn , DBConf::$USER, DBConf::$PASS, $this->DBOptions);
					if(!$connect){
						throw new PDOException();
					}else{
            // d::ulog("BaseDataBase new PDO ok");
						$result_o = $connect->query($query);
						if($result_o){
							$result= $result_o->fetchAll(PDO::FETCH_ASSOC);
              $insert_id = (isset($result_o->insert_id) ? $result_o->insert_id : NULL);
							return array("status"=>1, "result"=>$result, "numRows"=>count($result),"message"=>"$query", "insert_id"=>$insert_id);
						}else{
							return array("status"=>0, "result"=>NULL, "numRows"=>0,"message"=>"$query", "insert_id"=>NULL);
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
}
