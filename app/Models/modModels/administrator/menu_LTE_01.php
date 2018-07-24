<?php
// use Core\BaseDataBase;
use Core\Debugger as d;

$menus = $_SESSION['upages'];
// d::b($menus);
if ($menus) {
  $itens="";
  foreach ($menus as $menu => $menuitem) {
    $itens = $itens."
    <a href='{$menuitem['rota']}' title='{$menuitem['titulo']}'>
      <i class='fa fa-menu'></i> <span>{$menuitem['nome']}</span>
      <span class='pull-right-container'>
      <!-- descomentar quando tiver submenus -->
      <!-- <i class='fa fa-angle-left pull-right'></i> -->
      </span>
    </a>
    ";
  }
}

$r['ws-only-menu'] =
"<ul class='sidebar-menu' id='ws-only-menu-div'>
  <!-- MANDAR MENU AQUI PELA CLASSE WS-->
  <li class='header'>MAIN NAVIGATION</li>
  <li class='treeview'>

  <!-- aqui irão os menus -->

  {$itens}

  <!-- caso necessário aqui irão os sub menus -->
    <!--
    <ul class='treeview-menu' style='display: none;'>
      <li><a href='index1.html'><i class='fa fa-circle-o'></i> Dashboard v1</a></li>
      <li><a href='index2.html'><i class='fa fa-circle-o'></i> Dashboard v2</a></li>
    </ul>
    -->
  </li>
</ul>
";

return $r;
