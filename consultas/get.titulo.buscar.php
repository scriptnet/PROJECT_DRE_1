<?php
// Incluir el archivo de base de datos
include_once("../config/class.Database.php");


$parametro = $_GET['p'];


if(is_numeric($parametro)){

	$sql = "SELECT * FROM tbl_titulado where T_Dni = $parametro";

	$respuesta = array(
				'err' => false,
				'tbl_titulado' => Database::get_arreglo( $sql )
			);

}else{

	$respuesta = Database::get_por_nombre( 'tbl_titulado', 'T_Nombres', $parametro );

}

echo json_encode( $respuesta );


?>
