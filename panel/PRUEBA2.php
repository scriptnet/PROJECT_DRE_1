<?php
// $EXCEL_DATE = 43588;
// $UNIX_DATE = ($EXCEL_DATE - 25569) * 86400; echo gmdate("d/m/Y H:i:s", $UNIX_DATE); 
//     echo $UNIX_DATE; 
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../index.php");
  exit;
}
require_once("config/class.Database.php");
$dato1= 43588;
$dato2= 25569;
$dato3 = ($dato1-$dato2)*86400;
$EXCEL_DATE = 25569 + ($dato3 / 86400);
echo gmdate("Y/m/d", $dato3);



$sql="SELECT id_Institucion FROM tbl_usuario WHERE Us_Codigo = '$user'";
$RESPUESTA  = Database::get_row( $sql ); 

echo json_encode($RESPUESTA);
echo $RESPUESTA["id_Institucion"];

?>