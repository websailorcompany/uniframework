<?php
namespace App\Controllers;
use Core\BaseController;
class UniController extends BaseController{
  public function index(){
    echo "sigma";
  }
  public function login(){
    echo "sigma";
  }
  public function teste($id, $request){
    echo "id= ".$id."<br>";
    echo $request->get->nome;
  }
}
