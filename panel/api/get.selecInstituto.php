<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../index.php");
  exit;
};
// Incluir el archivo de base de datos

include_once("../config/class.Database.php");

if( isset( $_GET["pag"] ) ){
	$pag = $_GET["pag"];
}else{
	$pag = 1;
}


$respuesta = Database::get_todo_paginado_SelectInstitucion( 'tbl_institucion', $pag );


echo json_encode( $respuesta );


?>
