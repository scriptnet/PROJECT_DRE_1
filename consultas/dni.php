<?php
$dni  = $_GET['p'];
$consulta = file_get_contents('http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni);
 
//LA LOGICA DE LA PAGINAS ES APELLIDO PATERNO | APELLIDO MATERNO | NOMBRES
 
$partes = explode("|", $consulta);
 
$datos = array(
   
        "DNI"  => array(
            0 =>  $dni, 
            1 => $partes[0], 
            2 => $partes[1],
            3 => $partes[2]
        ),

);
 
echo json_encode($datos);

  
?>