<?php

session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../index.php");
  exit;
};
require_once("../config/class.Database.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$request = (array) $request;


if ( isset( $request['id_Usuario'] )) { // verifica si esta definida o no

//     $sql = "UPDATE cliente
//                   SET
//                       nom_cliente    = '". $request['nom_cliente'] ."',
//                       ape_cliente    = '". $request['ape_cliente'] ."',
//                       cel_cliente       = '". $request['cel_cliente'] ."',
//                       dni_cliente = '". $request['dni_cliente'] ."',
//             direc_cliente = '".$request['direc_cliente']."',
//                       email_cliente = '". $request['email_cliente'] ."'
//               WHERE id_cliente=" . $request['id_cliente'];

//     $hecho = Database::ejecutar_idu( $sql );

// if (is_numeric($hecho) OR $hecho === true) {
// $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro actualizado');

// }else {
// $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
// }
// code...
}else { //insertar

	$contrasena = $request['userpassword'];
	$contrasena_crypt = Database::crypt( $contrasena );

    
$sql ="INSERT INTO tbl_usuario(Us_Codigo,id_Institucion, Us_Constrasena)
    VALUES ('".$request['username']."',
            '".$request['institucion']."',
            '$contrasena_crypt')";

            $hecho = Database::ejecutar_idu( $sql );

if (is_numeric($hecho) OR $hecho === true) {
  $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro Insertado');

}else {
  $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
}
}

echo json_encode($respuesta);


?>