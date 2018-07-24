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

Class uniFile extends uniData{
  public $arquivo_local;
  public $arquivo_nome;
  public $arquivo_tipo;
  public $arquivo_tam;
  public $docPub;
  public $docPub_table;

	public function __construct(){
    parent::__construct();
    $this->docPub = Uconfig::$docPub_main;
    $this->docPub_table = Uconfig::$docPub_table;
  }

	public function aceita_formato(array $formatos_aceitos, $arquivo){
    $arq = explode('.', $arquivo);
    if(count($arq)>1){
    	$extensao = end($arq);
    	if(in_array($extensao, $formatos_aceitos)) {
    		return $extensao;
    	}else{ return FALSE; }
    }else{ return FALSE; } //obs: o arquivo deve ter extensão ou será recusado, retornando FALSE
	}
  public function uploadSeguro(array $input_type_file_names, array $formatos_aceitos){
    $pasta = $this->docPub .'/';
    $retorno = array();
    foreach($input_type_file_names as $input_name){
      if(isset($_FILES[$input_name])){ // $_FILES como global;
        $file=$_FILES[$input_name];
        $retorno[$input_name]['recebido'] =1;
        if(is_string($file['name'])){ // signifca input type file simples
          $filename = $file['name'];
          $retorno[$input_name]['name'] = $filename;
          if($extensao = $this->aceita_formato($formatos_aceitos, $filename)){//arquivo deve ter extensão
            $retorno[$input_name]['extensao'] = $extensao;
            $hash_file = hash_file('sha256',$file['tmp_name']);

            $result = $this->execQuery("SELECT hashfile FROM ". $this->docPub_table . " WHERE hashfile= '".$hash_file."'");
            if($result['numRows']>0){
              $retorno[$input_name]['err'] =7;  // Arquivo já existe no gerenciador.
              return $retorno;
            }
            if ( move_uploaded_file($file['tmp_name'], $pasta . $hash_file) ){
              $retorno[$input_name]['move_file'] ='OK';
              $query = "INSERT INTO ". $this->docPub_table . " (hashfile, extensao, tamanho, originalname, dataCria, expira, tempoAnos)";
              $query .= "VALUES ('". $hash_file ."', '". $extensao ."',". $file['size'] .",'". $filename ."', now(),FALSE,NULL)";
              $result = $this->execQuery($query);
              if($result['status']){
                $result = $this->execQuery("SELECT id FROM ". $this->docPub_table . " WHERE hashfile='".$hash_file."'");
                if($result['status']){
                  $retorno[$input_name]['save'] =$result['result'][0]['id'];
                }
              }else{ $retorno[$input_name]['err'] = 6; } // salvar dados falhou
            }else{ $retorno[$input_name]['err'] = 5; } // mover arquivo falhou
          }else{ $retorno[$input_name]['err'] = 4; } // formato de arquivo incompativel
        //obs: ou envia [save] ou envia [err], não ambos

        }elseif(is_array($file['name'])){ // signifca input type file multiple
          if(count($file['name'])==count($file['type'])&&count($file['name'])==count($file['tmp_name'])&&count($file['name'])==count($file['error'])&&count($file['name'])==count($file['size'])){
            foreach($file['name'] as $indice => $filename){
              $retorno[$filename]['recebido'] =1;
              if($extensao = $this->aceita_formato($formatos_aceitos, $filename)){//arquivo deve ter extensão
                $retorno[$filename]['aceita_formato'] = $extensao;
                $hash_file = hash_file('sha512', $file['tmp_name'][$indice]);
                if ( move_uploaded_file($file['tmp_name'][$indice], $pasta . $hash_file)){
                  $retorno[$filename]['move_file'] =TRUE;
                  $retorno[$filename]['hash_file'] =$hash_file;
                }else{ $retorno[$filename]['move_file'] =FALSE; } // mover arquivo falhou
              }else{ $retorno[$filename]['extensao'] = FALSE; } // formato de arquivo incompativel
            }
          }else{ $retorno[$filename]['move_file']['err']=3; } // quant atributos em cada indice não foi igualada
        }else{ $retorno[$filename]['move_file']['err']=2; } // não é array nem string
      }else{ $retorno[$filename]['move_file']['err']=1; } // o input_name não existe em $_FILES
    }
    return $retorno;
  }


  public function downloadSeguro($id){
    $result=$this->execQuery("SELECT hashfile, originalname, tamanho FROM " . $this->docPub_table. " WHERE id=" .$id);
    if($result['status']){
      $retorno['id']=$id;
      $caminho_download = $this->docPub ."/".$result['result'][0]['hashfile'];
      $retorno['caminho']=$caminho_download;
      if (file_exists($caminho_download)){
          $retorno['file_exists']=1;
          header('Content-type: octet/stream');
          header('Content-disposition: attachment; filename="'.$result['result'][0]['originalname'].'";');
          header('Content-Length: '.$result['result'][0]['tamanho']);
          readfile($caminho_download);
      }else{
        $retorno['file_exists']=0;
          //se o id existe mas o arquivo não, há uma falha grave no banco de dados
          // return array('status'=>0, 'err'=>'DB');
      }
    }else{
      $retorno['status']=0;
    }
    return $retorno;
  }

}//end of class
