<?php
include_once("../config/class.Database.php");

$parametro = $_GET['p'];

// $sql = "SELECT * from $tabla CO INNER JOIN cliente Cl ON CO.cliente_id_coti = Cl.id_cliente order by CO.id_coti DESC limit $desde, $por_pagina";
$sql = "SELECT * FROM tbl_detalle_it DT 
    INNER JOIN tbl_institucion COLE 
    ON DT.id_Institucion = COLE.id_Institucion
    where id_Titulado = $parametro";

$respuesta = array(
            'err' => false,
            'Detalle_T' => Database::get_arreglo( $sql )
        );
        echo json_encode( $respuesta );
?>