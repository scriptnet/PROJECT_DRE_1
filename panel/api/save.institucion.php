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

$respuesta = array(
    'err' => true,
    'Mensaje' => 'Usuario/Contraseña incorrectos',
);

if (isset($request['nombre'])) {
    
    $nombre = addslashes( $request['nombre'] );
    $nombre = strtoupper($nombre);

    // Verificar que el usuario exista
	$sql = "SELECT count(*) as existe FROM tbl_institucion where I_Nombre = '$nombre'";
    $existe = Database::get_valor_query( $sql, 'existe' );
    if (!$existe == 1) {
        $sql ="INSERT INTO tbl_institucion(I_Nombre)
        VALUES ('$nombre')";
            $hecho = Database::ejecutar_idu( $sql );
            if (is_numeric($hecho) OR $hecho === true) {
                $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro Insertado');
              
              }else {
                $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
              }

    } else {

        $respuesta = array(
            'err' => true,
            'Mensaje' => "Esta Institución ya existe"
        );

       
    }
    
    
} else {
    # code...
}

echo json_encode($respuesta);

?>