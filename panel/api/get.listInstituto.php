<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../index.php");
  exit;
};
// Incluir el archivo de base de datos

include_once("../config/class.Database.php");

if( isset( $_GET["pag2"] ) ){
	$pag2 = $_GET["pag2"];
}else{
	$pag2 = 1;
}


$respuesta = Database::get_todo_paginado_listinstituto( 'tbl_institucion', $pag2 );

echo json_encode( $respuesta );


?>
