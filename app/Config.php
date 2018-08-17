<?php
namespace App;
/**
 * @developer   Michel Larrosa
 * @package     WS.Sistema
 * @version     Websailor-Alfa-2018
 * @copyright   Copyright (C) 2016 - 2018 Websailor®. All rights reserved.
 * @license     Creative Commons License version 4; see LICENSE.txt
 */

// defined('_WS_EXEC') or die;

Class Config{

		public static $docPub_main = "DOC_j4zV5Da8hW5HPUWX";
		public static $docPub_clean = "auto";
		public static $docPub_table = "uni_arquivo";

		public static $Unicode="UTF-8";
		public static $Nome="UNI";
		public static $NomeSufixo="GP";
		public static $Departamento="UNI - Sistema de Gestão Pública";
		public static $Descricao="Sistema de Gestão Pública";
		public static $Tabela="xyz456_";
		public static $Copyright="";
		public static $logfile="/home/ecomp/websailor®/PROJETOS/uniframework.websailor/system/acesso.log";

		public static $SessaoTempo=3600;
		public static $Hash_algo="whirlpool";
		public static $Template="AdminLTE-2.3.7";

		public static $route=[
			"prefixo"=>[
				"sys"=>"sys",
				"adm"=>"adm",
				"cid"=>"cidadao",
			],
			"login"=>[
				"sys"=>"/login/sistema",
				"adm"=>"/login/administrador",
				"cid"=>"/login",
			],
			"index"=>[
				"sys"=>"/sys",
				"adm"=>"/adm",
				"cid"=>"/cidadao"
			]
		];

		public static $Pub=[
			"prefixo"=>"pub",
			"index"=>"/sigma"
		];
		public static $redirect=[
			"inexistente"=>"",
			"invalida"=>""
		];
}
