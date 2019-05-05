<?php
require_once("config/class.Database.php");


$array = "[{'Nombres':'Erik','Apellidos':'Regalado Alva','Dni':78375004,'Carrera':'Prueba','Fecha':43588},{'Nombres':'Maria','Apellidos':'calva','Dni':65478521,'Carrera':'dasarrollo','Fecha':43589}]";



$array = [ 'otros', 'Senati', 'otros2', 'otros3', 'otros4' ];

foreach( $array as $value ){
   
    $sql="SELECT I_Nombre FROM tbl_detalle_it WHERE I_Nombre = '$value' AND id_Institucion = '2'";
    $RESPUESTA  = Database::get_row( $sql ); 
    
 
   if(isset($RESPUESTA["I_Nombre"])){
    echo "Esta definida";
   }else{
       echo "No esta definida";
   }
    
}
// $array ahora es array(2, 4, 6, 8)


?>