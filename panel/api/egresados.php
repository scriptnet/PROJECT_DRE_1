<?php
session_start();
$user = $_SESSION['user'];

if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: ../index.php");
  exit;
};
require_once("../config/class.Database.php");
$sql="SELECT id_Institucion FROM tbl_usuario WHERE Us_Codigo = '$user'";
$RESPUESTA  = Database::get_row( $sql ); 
$institucion = $RESPUESTA["id_Institucion"];


$postdata = file_get_contents("php://input");
$jsonarray = json_decode($postdata, true);

// $request = (array) $request;
foreach ($jsonarray as $row) {
  $Nombres = $row['Nombres'];
  $Apellidos = $row['Apellidos'];
  $Dni = $row['Dni'];
  $Cod = $row['Dni'];
  $Fecha = $row['Fecha'];
  $Carrera = $row['Carrera'];
  $fechaUnix= 25569;
  $formula = ($Fecha-$fechaUnix)*86400;
  $resultadoFecha = gmdate("Y/m/d", $formula);
// verificamos su ya existe el titulado
  $sql4="SELECT T_Dni FROM tbl_titulado WHERE T_Dni = '$Cod'";
    $RESPUESTA1  = Database::get_row( $sql4 );
    if (isset($RESPUESTA1["T_Dni"])) {
      $hecho = true;
    } else {
      $sql = "INSERT INTO tbl_titulado (T_Nombres, T_Apellidos, T_Dni)
      VALUES('$Nombres', '$Apellidos', '$Dni')";
       $hecho = Database::ejecutar_idu( $sql );
    }
    

  $sql3="SELECT id_Titulado FROM tbl_detalle_it WHERE id_Titulado = '$Cod' AND id_Institucion = '$institucion' AND DIT_Carrera = '$Carrera'";
    $RESPUESTA  = Database::get_row( $sql3 ); 
    if(isset($RESPUESTA["id_Titulado"])){
      $hecho = true;
     }else{
       
       $sql2 = "INSERT INTO tbl_detalle_it (id_Institucion,id_Titulado,DIT_Fecha, DIT_Carrera)
      VALUES('$institucion','$Cod','$resultadoFecha', '$Carrera')";
       $hecho2 = Database::ejecutar_idu( $sql2 );
     }

 
    
}
if (is_numeric($hecho) OR $hecho === true) {
  $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro Insertado');
  
  // foreach ($jsonarray as $row) {
  //   $Cod = $row['Dni'];
  //   $Fecha = $row['Fecha'];
    
  //   $Carrera = $row['Carrera'];
  //   $sql2 = "INSERT INTO tbl_detalle_it (id_Institucion,id_Titulado,DIT_Fecha, DIT_Carrera)
  //   VALUES('$institucion','$Cod','$resultadoFecha', '$Carrera')";
  //    $hecho2 = Database::ejecutar_idu( $sql2 );
  // }
}else {
  $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
}

// if ($conn->query($sql) === TRUE) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . $conn->error;
// }

// $conn->close();

// for ($i=0; $i < 2; $i++) { 
//  $sql = "INSERT INTO usuarios (Usuario, Contraseña) VALUES ('".$request['Usuario']."')"
// }

// $sql ="INSERT INTO usuarios (Usuario, Contrasena)
//     VALUES ('".$request['Usuario']."',
//             '".$request['Contrasena']."')";
//             $hecho = Database::ejecutar_idu( $sql );
// if (is_numeric($hecho) OR $hecho === true) {
//   $respuesta = array ( 'err'=>false, 'Mensaje'=>'Registro Insertado');
// }else {
//   $respuesta = array ( 'err'=>true, 'Mensaje'=>$hecho);
// }

echo json_encode($respuesta);
?>
