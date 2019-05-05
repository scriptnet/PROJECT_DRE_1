<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../index.php");
  exit;
};
// Incluir el archivo de base de datos
include_once("../config/class.Database.php");

$sql="SELECT id_Institucion FROM tbl_usuario WHERE Us_Codigo = '$user'";
$RESPUESTA  = Database::get_row( $sql ); 
$institucion = $RESPUESTA["id_Institucion"];


if( isset( $_GET["pag"] ) ){
	$pag = $_GET["pag"];
}else{
	$pag = 1;
}

$buscar = $_GET["buscar"];

$respuesta = Database::get_todo_paginado_titulado( 'tbl_detalle_it', $pag, $institucion, $buscar );



echo json_encode( $respuesta );


?>
