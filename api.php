<?php
require_once('./config.php');
header('Cache-Control: store, cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: cache');
header('Last-Modified: '.gmdate('D, d M Y H:i:s'). ' GMT');
header('Content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");

if (!isset($_SESSION['is_logged'])) {
  $_SESSION['is_logged'] = FALSE;
}
if (!isset($_SESSION['user'])) {
  $_SESSION['user'] = (object) [];
}
$P->logged = $_SESSION['is_logged'];
$P->user = $_SESSION['user'];

$db2 = new mysql('localhost','fifi','12345','pruebas2');
$json = new stdClass;
$json->error = 0;

function j_error($msg=FALSE){
  return (object) [
    'error'=>1,
    'errormsg'=> FALSE==$msg?'ERROR: Defina variables':$msg,
  ];
}

if (isset($_GET['t'])) {
  switch ($_GET['t']) {
    case 'eliminarperfil':
      if ($P->logged && $P->user->is_super) {
        $json = $db2->eliminarperfil($_POST);
      }
      else {$json = j_error($P->MSJ->nopermiso);}
      break;
    case 'buscarperfil':
      $html = "";
      $r = $db2->buscar_perfil($_POST);
      foreach ($r as $p) {
        $D->p = $p;
        $html .= load_template('perfiles.li',FALSE);
      }
      $json->form = $html;
      break;
    case 'crearperfil':
      if ($P->logged && $P->user->is_super) {
        $json = $db2->crearperfil($_POST);
      }
      else {$json = j_error($P->MSJ->nopermiso);}
      break;
    case 'getformeditperfil':
      if ($P->logged && $P->user->is_super) {
        $json->form = load_template('form.crear.perfil',FALSE);
      }
      else {$json = j_error($P->MSJ->nopermiso);}
      break;
    case 'getformcrearperfil':
      if ($P->logged && $P->user->is_super) {
        $json->form = load_template('form.crear.perfil',FALSE);
      } else {$json = j_error($P->MSJ->nopermiso);}
      break;
    case 'getlogin':
      $json->form = load_template('login',FALSE);
      break;
    case 'getperfiles':
      if ($P->logged && $P->user->is_super) {
        $json->form = load_template('perfiles',FALSE);
      } else {
        $json = j_error($P->MSJ->nopermiso);
      }
      break;
    case 'getcategorias':
      $json->form = load_template('index',FALSE);
      break;
    case 'getformupdateproducto':
      if (isset($_POST['id']) && ($P->logged && ($P->user->is_super OR $P->user->can_update))) {
        $p = $db2->getproducto($_POST['id']);
        $p->categorias = array_map(function($a){return intval($a->id);},$db2->getcategoriasbyproducto($p->id));
        $D->p = $p;
        $json->form = load_template('form.crear.producto',FALSE);
      }
      else {$json = j_error($P->MSJ->cantupdate);}
      break;
    case 'actualizarproducto':
      if (isset($_POST['id']) && ($P->logged && ($P->user->is_super OR $P->user->can_update))) {
        $json = $db2->actualizarproducto($_POST);
      }
      else {$json = j_error($P->MSJ->cantupdate);}
      break;
    case 'eliminarproducto':
      if (isset($_POST['id']) && ($P->logged && ($P->user->is_super OR $P->user->can_delete))) {
        $json = $db2->eliminarproducto($_POST);
      }
      else {$json = j_error($P->MSJ->cantdelete);}
      break;
    case 'buscarproducto':
      $r = $db2->buscar_producto($_POST);
      $html = "";
      foreach ($r as $p) {
        $D->p = $p;
        $html .= load_template('categorias.productos.tr',FALSE);
      }
      $json->form = $html;
      break;
    case 'crearproducto':
      if (isset($_POST['nombre_producto'])) {
        if ($P->logged && ($P->user->is_super OR $P->user->can_create)) {
          $json = $db2->crearproducto($_POST);
        }
        else{$json = j_error($P->MSJ->cantcreate);}
      }
      else {$json = j_error();}
      break;
    case 'getformcrearproducto':
      if ($P->logged && ($P->user->is_super OR $P->user->can_create)) {

        $json->form = load_template('form.crear.producto',FALSE);

      }
      else{$json = j_error($P->MSJ->cantcreate);}
      break;
    case 'viewcategoria':
      if (isset($_POST['id'])) {
        $r = $db2->getproductosbycategoria($_POST['id']);
        $D->c = $db2->getcategoria($_POST['id']);
        $D->productos = $r;
        $json->form = load_template('categorias.productos',FALSE);
      }
      else {$json = j_error();}
      break;
    case 'actualizarcategoria':
      if (isset($_POST['id'])) {
        $json = ($P->logged && ($P->user->is_super OR $P->user->can_update))?$json = $db2->actualizarcategoria($_POST):j_error($P->MSJ->cantupdate);
      }
      else {$json = j_error();}
      break;
    case 'eliminarcategoria':
      if (isset($_POST['id'])) {
        $json = ($P->logged && ($P->user->is_super OR $P->user->can_delete))?$json = $db2->eliminarcategoria($_POST):j_error($P->MSJ->cantdelete);
      }
      else {$json = j_error();}
      break;
    case 'buscarcategoria':
      $r = $db2->buscar_categoria($_POST);
      $html = "";
      foreach ($r as $c) {
        $D->c = $c;
        $html .= load_template('categorias.li',FALSE);
      }
      $json->form = $html;
      break;
    case 'crearcategoria':
      if (isset($_POST['categoria'])) {
        $json = ($P->logged && ($P->user->is_super OR $P->user->can_create))?$json = $db2->crearcategoria($_POST):j_error($P->MSJ->cantcreate);
      }
      else{$json = j_error();}
      break;
    case 'getformeditcategoria':
      if (isset($_POST['id'])) {
        if ($P->logged && ($P->user->is_super OR $P->user->can_update)) {
          $r = $db2->buscar_categoria($_POST);
          if (count($r)==0) {$json = j_error("La categoira no existe");}
          else{
            $D->c = reset($r);
            $json->form = load_template('form.crear.categoria',FALSE);
          }
        } else {
          $json = j_error($P->MSJ->cantupdate);
        }
      }
      else{$json = j_error();}
      break;
    case 'getformcrearcategoria':
      if ( $P->logged && ($P->user->is_super OR $P->user->can_create)) {
        $json->form = load_template('form.crear.categoria',FALSE);
      }
      else{
        $json = j_error($P->MSJ->cantcreate);
      }
      break;
    case 'logout':
      $r = $db2->logout();
      $json->resp = $r;
      // $json->index = load_template($_SESSION['is_logged']?'index':'login',FALSE);
      break;
    case 'login':
      if (!isset($_POST['dni'],$_POST['password'])) {
        $json->error = 1;
        $json->errormsg = "parametros adicionales";
      }else{
        $r = $db2->login($_POST);
        if ($r->error!==0) {
          $json = $r;
        }else{
          $json = $r;
          $json->index = load_template($_SESSION['is_logged']?'index':'login',FALSE);
        }
      }
      break;
    default:
      $json->error = 1;
      $json->errormsg = "Seleccione accion a realizar";
      break;
  }
  echo json_encode($json);
  return;
}


$json->error = 1;
$json->errormsg = "DEFINA VARIABLE _GET['t']";

echo json_encode($json);
