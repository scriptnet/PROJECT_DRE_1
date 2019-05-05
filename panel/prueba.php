<?php
require_once("config/class.Database.php");
$sql = "SELECT count(*) as cuantos from tbl_titulado";
$cuantos  = Database::get_valor_query( $sql, 'cuantos' );





$respuestas = Database::get_todo_paginado( 'tbl_titulado', 1 );
//echo  json_encode ($respuestas["tbl_titulado"]["0"]["T_Nombres"]);
for ($i=0; $i < $respuestas['conteo']; $i++) {
		echo $respuestas["tbl_titulado"][$i]["id_Titulado"];
	}
	
//echo json_encode( $tabla );
//for ($i=0; $i < $respuestas['conteo']; $i++) {
	//	echo $tabla["holo"][$i]["id_Titulado"];
	//}
//echo $tabla["holo"]["0"]["T_Dni"];


//echo json_encode ($fila["0"]["T_Dni"]);

?>