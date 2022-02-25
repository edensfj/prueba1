<?php
$P = new stdClass;
$D = new stdClass;
$P->SUB_DIRECTORY = "";
$P->logged = FALSE;
if (PHP_SAPI=='apache2handler') {
  $P->REQUEST_SCHEME = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']))?$_SERVER['HTTP_X_FORWARDED_PROTO']:$_SERVER['REQUEST_SCHEME'];
  $P->DOMAIN = $_SERVER['SERVER_NAME'];
  if(isset($_SERVER['HTTP_HOST'])){$P->DOMAIN = $_SERVER['HTTP_HOST'];}
  $P->SITE_URL = $P->REQUEST_SCHEME.'://'.$P->DOMAIN.'/'.$P->SUB_DIRECTORY;
  if(isset($_SERVER['SERVER_PORT'])){
    $port = $_SERVER['SERVER_PORT'];
    if($port!=80){
      if(isset($_SERVER['HTTP_HOST'])){$P->SITE_URL = $P->REQUEST_SCHEME.'://'.$P->DOMAIN.'/'.$P->SUB_DIRECTORY;}
      else{$P->SITE_URL = $P->REQUEST_SCHEME.'://'.$P->DOMAIN.':'.$port.'/'.$P->SUB_DIRECTORY;}
    }else{
      $P->SITE_URL = $P->REQUEST_SCHEME.'://'.$P->DOMAIN.'/'.$P->SUB_DIRECTORY;
    }
  }
} else {
  $P->PORT = $_SERVER['SERVER_PORT'];
  $P->DOMAIN = (isset($_SERVER['HTTP_HOST']))?$_SERVER['HTTP_HOST']:gethostbyname(gethostname()).':'.$P->PORT;
  if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {$REQUEST_SCHEME = $_SERVER['HTTP_X_FORWARDED_PROTO'];}
  else{$REQUEST_SCHEME = isset($_SERVER["HTTPS"]) ? 'https' : 'http';}
  $P->SITE_URL =   $REQUEST_SCHEME.'://'.$P->DOMAIN.'/';
}
$P->INCPATH = dirname(__file__).DIRECTORY_SEPARATOR;
$P->CSS = $P->SITE_URL.implode(DIRECTORY_SEPARATOR,['css','']);
$P->JS = $P->SITE_URL.implode(DIRECTORY_SEPARATOR,['js','']);
$P->HTML = $P->INCPATH.implode(DIRECTORY_SEPARATOR,['html','']);

$P->MSJ = (object) [
  'cantcreate'=>'USTED NO TIENE PERMISO PARA CREAR',
  'cantdelete'=>'USTED NO TIENE PERMISO PARA ELIMINAR',
  'cantupdate'=>'USTED NO TIENE PERMISO PARA ACTUALIZAR',
  'nopermiso'=>'USTED NO TIENE PERMISO PARA EJECUTAR ESTA ACCION',
];

$P->JSONVAR = (object) ['error'=>0,'errormsg'=>''];

function Eserialize($var=FALSE){
  if (FALSE==$var) {return FALSE;}
  foreach ($var as $k => $v) {
    if (in_array(gettype($v),['array','object'])) {continue;}
    $var->{$k} =  preg_match("/[a-z]/i", strval($v))?$v:floatval($v);
  }
  return $var;
}
function vdump($msj){
	$html = "";
	if (is_bool($msj)) {
		ob_start();
		var_dump($msj);
		$html .= ob_get_contents();
		ob_end_clean();
	} else {
		ob_start();
		echo "<pre>";
		print_r($msj);
		echo "</pre>";
		$html .= ob_get_contents();
		ob_end_clean();
	}
	return $html;
}
function setvarpost($variable=FALSE){
  $post = new stdClass;
  if (FALSE==$variable) {return $post;}
  if (in_array(gettype($variable),['string','integer','double'])) {
    $post = new stdClass;
    $post->id = $variable;
  }
  elseif (in_array(gettype($variable),['array','object'])) {
    $post = (object) $variable;
  }
  return $post;
}
function Ptrim($oldstr=""){
	$str = preg_replace('/\s+/', ' ', $oldstr);
	$str = trim($str);
	$str = str_replace([
		' id=""',
		' id=" "',
		" id=''",
		" id=' '",
		' class=""',
		' class=" "',
		" class=''",
		" class=' '",
		' style=""',
		' style=" "',
		" style=''",
		" style=' '",
	],'',$str);
	$str = str_replace([
		'> <',
	],'><',$str);
	$str = preg_replace('/<!--(?!<!)[^\[>].*?-->/', '', $str);
  $str = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $str);
	return $str;
}
function load_template($file=FALSE,$output=TRUE){
  if (FALSE==$file) {return "";}
  $P = $GLOBALS['P'];
  $D = $GLOBALS['D'];
  $abs = "{$P->HTML}{$file}.php";
  if (!file_exists($abs)) {
    echo vdump("El template. {$abs} no existe");
  }
  $db2 = new mysql('localhost','fifi','12345','pruebas2');
  if( $output ) {
    require($abs);
    return TRUE;
  }
  else {
    ob_start();
    require($abs);
    $cnt	= ob_get_contents();
    ob_end_clean();
    return $cnt;
  }
}
function toMoney($val,$symbol='$',$r=2,$trim=false){
  $n = $val;
  $n = is_null($val)?0:$n;
  $r = (null===$r)?2:$r;
  $c = is_float($n) ? 1 : number_format($n,$r);
  $d = ',';
  $t = '.';
  $sign = ($n < 0) ? '-' : '';
  $i = $n=number_format(abs($n),$r);
  $j = count(str_split($i));
  $j = ($j  > 3) ? $j % 3 : 0;
  $num = ((null===$symbol)?'$':$symbol).''.$sign.$i;
  if (!!intval($trim)) {
    $num = rtrim(rtrim($num,'0'),'.');
  }
  return $num;
}


class mysql
{
  private $connection	= FALSE;
  private $dbhost;
  private $dbuser;
  private $dbpass;
  private $dbname;

  public $table_ = "";
  public $where_ = "";

  function __construct($h=FALSE,$u=FALSE,$p=FALSE,$db=FALSE){
    $this->P = $GLOBALS['P'];
    $this->dbhost = $h;
    $this->dbuser = $u;
    $this->dbpass = $p;
    $this->dbname = $db;

    $this->init();
  }
  public function connect(){
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
      $this->connection = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
      $this->connection->query("SET NAMES utf8");
    }
    catch (\Exception $e) {
      echo vdump("ERROR: {$this->connection->connect_errno},  {$this->connection->connect_error}");
      exit;
    }
    return $this->connection;
  }
  private function init(){
    if (!$this->check_table('categorias')) {
      $this->query("create table categorias(
        id int unsigned not null primary key auto_increment,
        categoria varchar(100) not null default '',
        estado tinyint(1) unsigned not null default 1
      );");
    }
    if (!$this->check_table('productos')) {
      $this->query("create table productos(
        id int unsigned not null primary key auto_increment,
        nombre_producto varchar(250) not null default '',
        estado tinyint(1) unsigned not null default 1,
        precio decimal(20,5) unsigned not null default 0,
        img varchar(250) not null default '',
        descripcion text not null default ''
      );");
    }
    if (!$this->check_table('productos_categorias')) {
      $this->query("create table productos_categorias(
        idcategoria int unsigned not null,
        idproducto int unsigned not null,
        foreign key (idcategoria) references categorias(id),
        foreign key (idproducto) references productos(id)
      );");
    }
    if (!$this->check_table('perfiles')) {
      $this->query("create table perfiles(
        id int unsigned not null primary key auto_increment,
        perfil varchar(100) not null default '',
        is_super tinyint(1) unsigned not null default 0,
        can_delete tinyint(1) unsigned not null default 0,
        can_update tinyint(1) unsigned not null default 0,
        can_create tinyint(1) unsigned not null default 0
      );");
      $this->query("INSERT INTO perfiles(perfil,is_super) VALUES('ADMINISTRADOR',1)");
      $this->query("INSERT INTO perfiles(perfil,can_create,can_update,can_delete) VALUES('DIGITADOR',1,1,1)");
      $this->query("INSERT INTO perfiles(perfil) VALUES('USUARIO')");
    }
    if (!$this->check_table('usuarios')) {
      $this->query("create table usuarios(
        id int unsigned not null primary key auto_increment,
        idperfil int unsigned not null default 0,
        nombre varchar(250) not null default '',
        dni varchar(250) not null default '',
        password varchar(300) not null default '',
        tel varchar(13) not null default '',
        direccion varchar(150) not null default '',
        email varchar(150) not null default ''
      );");
      $passadmin = md5('admin');
      $this->query("INSERT INTO usuarios(nombre,dni,password,idperfil) VALUES('SUPER ADMINISTRADOR','55555','$passadmin',1)");
    }
  }
  public function query($query=FALSE){
    if (FALSE==$query) {return FALSE;}
    if(FALSE == $this->connection) {$this->connect();}
    try {
      $result	= $this->connection->query($query);
    } catch (\Exception $e) {
      return $this->connection->error;
    }
    return $result;
  }
  public function fetch_object($res=FALSE){
    if(FALSE == $res) {return FALSE;}
    return $res->fetch_object();
  }
  public function fetch_field($query) {
    $res	= $this->query($query, FALSE);
    if(FALSE == $res) {return FALSE;}
    if(!$row = mysqli_fetch_row($res)) {return FALSE;}
    $this->free_result($res);
    return reset($row);
  }

  private function check_column($column,$t=FALSE){
    if (FALSE==$t) {$t = $this->table_;}
    return intval($this->fetch_field("SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$this->dbname}' AND TABLE_NAME='{$t}' AND COLUMN_NAME='$column';"));
  }
  private function check_table($table){
    return intval($this->fetch_field("SELECT 1 FROM INFORMATION_SCHEMA.TABLES where TABLE_SCHEMA='{$this->dbname}' AND TABLE_NAME='$table' LIMIT 1;"));
  }


  public function table($table){
    $this->table_ = FALSE;
    if ($this->check_table($table)) {
      $this->table_ = $table;
    }
    return $this;
  }
  public function where($where='',$logica='AND'){
    $logica = strtoupper($logica);
    if(!in_array($logica,array('AND','OR'))){$logica='AND'; }
     $vars = setvarpost($where);
     $this->where_ = '';

     foreach ($vars as $k => $v) {
       $v = $this->escape($v);
       $this->coass[$k] = $this->check_column($k);
     }


    // if(is_array($where)){
    //   $this->where_ = '';
    //   $where = (array) $where;
    //   foreach($where as $k => $v){$v = $this->escape($v);if($this->check_column($k)===0){array_splice($where, array_search($k,array_keys($where)));}}
    //   foreach($where as $k => $v) {
    //     $v = $this->escape($v);
    //     if(array_search($k,array_keys($where))===0){$this->where_ .= ' WHERE ';}
    //     if(next($where)===false){$this->where_ .= "$k='$v' ";}
    //     else{$this->where_ .= "$k='$v' $logica ";}
    //   }
    // }

    return $this;


  }
  public function update($post){
    if(empty($this->where_)){$this->where();}
    $post = (array) $post;
    if(count($post) === 0){return FALSE;}
    if(FALSE === $this->table_){return FALSE;}
    $sets = [];
    foreach( $post as $k => $v){if($this->check_column($k)){
      $v = $this->escape($v);
      if($k==='id'){continue;}
      if(in_array('id',array_keys($post))){$this->where_ = " WHERE id=$post[id] ";}
      else{$this->where_ = $this->where_;}
      if (is_float($v)) {$v = str_replace(",",".",$v);}
      $v = Ptrim($v);
      $k = Ptrim($k);
      $sets[] = "$k='$v'";
    };}
    $implo = implode(', ',$sets);
    $sql = "UPDATE {$this->table_} SET $implo {$this->where_}";
    $this->query($sql);
    $this->where_ = '';
    return $post;
  }
  public function create($post){
    if(empty($this->where_)){$this->where();}
    if(count((array) $post) === 0){return FALSE;}
    $post = (array) $post;
    $new_arr = array();
    foreach($post as $k => $v){
      $v = $this->escape($v);
      if($this->check_column($k)){$new_arr[$k] = $v;}
    }
    $post = $new_arr; unset($new_arr);
    if(FALSE === $this->table_){return FALSE;}
    $columns = '';
    $values = '';
    foreach ($post as $k => $v) {
      if($this->check_column($k)){
        if(array_search($k,array_keys($post))===0){$columns .= '(';$values .= '(';}
        if (is_float($v)) {$v = str_replace(",",".",$v);}
        $v = Ptrim($v);
        $k = Ptrim($k);
        if(next($post)===false){
          $columns .= "$k)";
          $values .= "'$v')";
        }else{
          $columns .= "$k,";
          $values .= "'$v',";
        }
      }
    }
    $sql = Ptrim("INSERT INTO {$this->table_}$columns VALUES$values");
    if($this->query($sql)){
      if ($this->connection->errno!=0) {return FALSE;}
      else {
        $post['id'] = strval($this->insert_id());
      }
    }
    else{return FALSE;}
    return $post;
  }
  public function delete($post,$logica='AND') {
    $post = (array) $post;
    $logica = strtoupper($logica);
    if(count( (array) $post) === 0){return FALSE;}
    if(FALSE === $this->table_){return FALSE;}
    if(!in_array($logica,array('AND','OR'))){$logica='AND'; }
    $consult = "DELETE FROM {$this->table_} WHERE ";
    foreach ($post as $k => $v) {
      $v = $this->e($v);
      if(next($post)===false){$consult .= "$k='$v'";}
      else{$consult .= "$k='$v' $logica ";}
    }
    if($this->query($consult)){
      if ($this->connection->errno!=0) {return FALSE;}
      else {return TRUE;}
    }
    else{return FALSE;}
    return $consult;
  }


  public function fetch_all($query) {
    $res	= $this->query($query, FALSE);
    if(FALSE == $res) {return FALSE;}
    $data	= array();
    while( $obj = $this->fetch_object($res) ) {
      $data[]	= Eserialize((object) $obj);
    }
    $this->free_result($res);
    return $data;
  }
  public function insert_id() {
    if(FALSE == $this->connection) {$this->connect();}
    return intval($this->connection->insert_id);
  }
  public function free_result($res=FALSE) {
    if(FALSE == $res) {return FALSE;}
    return $res->free_result();
  }
  public function escape($string) {
    if (in_array(gettype($string),['array','object','NULL','boolean'])) {return $string;}
    if(FALSE == $this->connection) {$this->connect();}
    return mysqli_real_escape_string($this->connection, $string);
  }
  public function e($string){
    return $this->escape($string);
  }
  // funciones adicionales
  public function login($post=FALSE){
    if (FALSE==$post) {return FALSE;}
    $post = setvarpost($post);
    $post->password = md5($post->password);
    $json = new stdClass;
    $json->error = 0;
    $has = intval($this->fetch_field("SELECT id FROM usuarios WHERE dni='{$post->dni}' AND password='{$post->password}' LIMIT 1;"));
    if (!!!$has) {
      $json->error = 1;
      $json->errormsg = "El usuario no existe.";
      return $json;
    }
    $_SESSION['is_logged'] = TRUE;
    $_SESSION['user'] = $this->get_user($has);
    $json->login = TRUE;
    return $json;
  }
  public function logout(){
    $_SESSION['is_logged'] = FALSE;
    $_SESSION['user'] = (object) [];
    return true;
  }
  public function get_user($id=FALSE){
    $u = new stdClass;
    if (FALSE==$id) {return $u;}
    $sql = "SELECT
    p.perfil,
    p.is_super,
    p.can_delete,
    p.can_update,
    p.can_create,
    u.nombre,
    u.dni,
    u.tel,
    u.direccion,
    u.email,
    u.id
    FROM usuarios u
    INNER JOIN perfiles p ON p.id = u.idperfil
    WHERE u.id = '$id'
    ";
    $r = $this->query($sql);
    $o = $this->fetch_object($r);
    return Eserialize($o);
  }

  public function eliminarperfil($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('perfiles')->delete($post)) {
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function crearperfil($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('perfiles')->create($post)) {
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function get_perfiles(){
    $sql = "SELECT * from perfiles";
    return $this->fetch_all($sql);
  }

  public function getproducto($id=FALSE){
    if (FALSE==$id) {return (object) [];}
    $sql = "SELECT
    *
    FROM productos
    WHERE id = '$id'
    LIMIT 1
    ";
    $r = $this->query($sql);
    if ($o = $this->fetch_object($r)) {
      return $o;
    }
    return (object) [];
  }
  public function crearproducto($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('productos')->create($post)) {
      $r = (object) $r;
      foreach ($post->categorias as $c) {
        $this->table('productos_categorias')->create([
          'idcategoria'=>$c,
          'idproducto'=>$r->id,
        ]);
      }
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function eliminarproducto($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    $this->table('productos_categorias')->delete(['idproducto'=>$post->id]);
    if ($r = $this->table('productos')->delete($post)) {
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function actualizarproducto($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('productos')->where($post->id)->update($post)) {
      if (isset($post->categorias)) {
        $this->table('productos_categorias')->delete(['idproducto'=>$post->id]);
        foreach ($post->categorias as $c) {
          $this->table('productos_categorias')->create([
            'idcategoria'=>$c,
            'idproducto'=>$post->id,
          ]);
        }
      }
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function getcategoriasbyproducto($idp=FALSE){
    if (FALSE == $idp) {return [];}
    $sql = "SELECT
    c.*
    FROM productos_categorias pc
    INNER JOIN categorias c ON c.id = pc.idcategoria
    WHERE pc.idproducto = '$idp'
    ";
    return $this->fetch_all($sql);
  }

  public function getproductosbycategoria($idc=FALSE){
    if (FALSE == $idc) {return [];}

    $sql = "SELECT
    p.*
    FROM productos_categorias pc
    INNER JOIN productos p ON p.id = pc.idproducto
    WHERE pc.idcategoria = '$idc'
    ";
    return $this->fetch_all($sql);
  }
  public function getcategoria($id=FALSE){
    if (FALSE==$id) {return (object) [];}
    $sql = "SELECT
    IF(c.estado,'Activa','Inactiva') as estadotext,
    c.*
    FROM categorias c
    WHERE c.id = '$id'
    ORDER BY c.categoria ASC
    LIMIT 1
    ";
    $r = $this->query($sql);
    $o = $this->fetch_object($r);
    return $o;
  }

  public function buscar_categoria($post=FALSE){
    if (FALSE==$post OR (is_array($post) && count($post)==0)  ) {$post = ['val'=>''];}
    $post = setvarpost($post);
    $where = "";
    if (isset($post->val)) {$where .= " c.categoria LIKE '%{$post->val}%' ";}
    elseif(isset($post->id)) {$where .= " c.id=$post->id ";}
    else{return [];}
    $sql = "SELECT
    IF(c.estado,'Activa','Inactiva') as estadotext,
    c.*
    FROM categorias c
    WHERE $where
    ORDER BY c.categoria ASC
    LIMIT 100
    ";
    return $this->fetch_all($sql);
  }
  public function buscar_producto($post=FALSE){
    if (FALSE==$post OR (is_array($post) && count($post)==0)  ) {$post = ['val'=>''];}
    $post = setvarpost($post);
    $where = "";
    if (isset($post->val)) {$where .= " p.nombre_producto LIKE '%{$post->val}%' ";}
    elseif(isset($post->id)) {$where .= " p.id=$post->id ";}
    else{return [];}
    if (isset($post->idcategoria)) {
      $arr = [];
      if (gettype($post->idcategoria)!=='array') {
        $arr[] = $post->idcategoria;
      }
      else{
        $arr = $post->idcategoria;
      }
      $arr = array_values($arr);
      $imp = implode(',',$arr);
      $where .= " AND IFNULL(pc.idcategoria,0) IN($imp)";
    }
    $sql = "SELECT
    p.*
    FROM productos p
    LEFT JOIN productos_categorias pc ON pc.idproducto = p.id
    WHERE $where
    GROUP BY p.id
    ORDER BY p.nombre_producto ASC
    LIMIT 100
    ";
    return $this->fetch_all($sql);
  }
  public function buscar_perfil($post=FALSE){
    if (FALSE==$post OR (is_array($post) && count($post)==0)  ) {$post = ['val'=>''];}
    $post = setvarpost($post);
    $where = "";
    if (isset($post->val)) {$where .= " p.perfil LIKE '%{$post->val}%' ";}
    // elseif(isset($post->id)) {$where .= " p.id=$post->id ";}
    else{return [];}
    $sql = "SELECT
    *
    FROM perfiles p
    WHERE
    $where
    LIMIT 100
    ";
    return $this->fetch_all($sql);
  }

  public function actualizarcategoria($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('categorias')->where($post->id)->update($post)) {
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function eliminarcategoria($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('categorias')->delete($post)) {
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }
  public function crearcategoria($post=FALSE){
    $json = $this->P->JSONVAR;
    if (FALSE==$post) {return $json;}
    $post = setvarpost($post);
    if ($r = $this->table('categorias')->create($post)) {
      $json->resp = $r;
    } else {
      $json->error = $this->connection->errno;
      $json->errormsg = $this->connection->error;
    }
    return $json;
  }



  public function __destruct(){
    if( $this->connection ) {
      $this->connection->close();
    }
  }



}
