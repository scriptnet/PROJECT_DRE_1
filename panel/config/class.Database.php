<?php
// ======================================================
// Clase: class.Database.php
// Funcion: Se encarga del manejo con la base de datos
// Descripcion: Tiene varias funciones muy útiles para
// 				el manejo de registros.
//
// Ultima Modificación: 17 de marzo de 2015
// ======================================================


class Database{

	private $_connection;
	private $_host = "localhost";
	private $_user = "root";
	private $_pass = "";
	private $_db   = "bd_tpyt";


	// Almacenar una unica instancia
	private static $_instancia;



	// ================================================
	// Metodo para obtener instancia de base de datos
	// ================================================
	public static function getInstancia(){

		if(!isset(self::$_instancia)){
			self::$_instancia = new self;
		}


		return self::$_instancia;
	}

	// ================================================
	// Constructor de la clase Base de datos
	// ================================================
	public function __construct(){
		$this->_connection = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);

		// Manejar error en base de datos
		if (mysqli_connect_error()) {
			trigger_error('Falla en la conexion de base de datos'. mysqli_connect_error(), E_USER_ERROR );
		}
	}

	// Metodo vacio __close para evitar duplicacion
	private function __close(){}

	// Metodo para obtener la conexion a la base de datos
	public function getConnection(){
		$this->_connection->set_charset("utf8");
		return $this->_connection;
	}

	// Metodo que revisa el String SQL
	private function es_string($sql){
		if (!is_string($sql)) {
			trigger_error('class.Database.inc: $SQL enviado no es un string: ' .$sql);
			return false;
		}
		return true;
	}

	// ==================================================
	// 	Funcion que ejecuta el SQL y retorna un ROW
	// 		Esta funcion esta pensada para SQLs,
	// 		que retornen unicamente UNA sola línea
	// ==================================================
	public static function get_row($sql){

		if(!self::es_string($sql))
			exit();

		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();
		$resultado = $mysqli->query($sql);

		if($row = $resultado->fetch_assoc()){
			return $row;
		}else{
			return array();
		}
	}

	// ==================================================
	// 	Funcion que ejecuta el SQL y retorna un CURSOR
	// 		Esta funcion esta pensada para SQLs,
	// 		que retornen multiples lineas (1 o varias)
	// ==================================================
	public static function get_cursor($sql){

		if(!self::es_string($sql))
			exit();


		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();

		$resultado = $mysqli->query($sql);
		return $resultado; // Este resultado se puede usar así:  while ($row = $resultado->fetch_assoc()){...}
	}

	// ==================================================
	// 	Funcion que ejecuta el SQL y retorna un jSon
	// 	data: [{...}] con N cantidad de registros
	// ==================================================
	public static function get_json_rows($sql){

		if(!self::es_string($sql))
			exit();

		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();


		$resultado = $mysqli->query($sql);


		// Si hay un error en el SQL, este es el error de MySQL
		if (!$resultado ) {
		    return "class.Database.class: error ". $mysqli->error;
		}

		$i = 0;
		$registros = array();

		while($row = $resultado->fetch_assoc()){
			array_push( $registros, $row );
			// $registros[$i]= $row;
			// $i++;
		};
		return json_encode( $registros );
	}


	// ==================================================
	// 	Funcion que ejecuta el SQL y retorna un Arreglo
	// ==================================================
	public static function get_arreglo($sql){

		if(!self::es_string($sql))
			exit();

		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();


		$resultado = $mysqli->query($sql);


		// Si hay un error en el SQL, este es el error de MySQL
		if (!$resultado ) {
		    return "class.Database.class: error ". $mysqli->error;
		}

		$i = 0;
		$registros = array();

		while($row = $resultado->fetch_assoc()){
			array_push( $registros, $row );
		};
		return $registros;
	}



	// ==================================================
	// 	Funcion que ejecuta el SQL y retorna un jSon
	// 	de una sola linea. Ideal para imprimir un
	// 	Query que solo retorne una linea
	// ==================================================
	public static function get_json_row($sql){

		if(!self::es_string($sql))
			exit();

		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();

		$resultado = $mysqli->query($sql);

		// Si hay un error en el SQL, este es el error de MySQL
		if (!$resultado ) {
		    return "class.Database.class: error ". $mysqli->error;
		}


		if(!$row = $resultado->fetch_assoc()){
			return "{}";
		}
		return json_encode( $row );
	}

	// ====================================================================
	// 	Funcion que ejecuta el SQL y retorna un valor
	// 	Ideal para count(*), Sum, cosas que retornen una fila y una columna
	// ====================================================================
	public static function get_valor_query($sql,$columna){

		if(!self::es_string($sql,$columna))
			exit();

		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();

		$resultado = $mysqli->query($sql);

		// Si hay un error en el SQL, este es el error de MySQL
		if (!$resultado ) {
		    return "class.Database.class: error ". $mysqli->error;
		}

		$Valor = NULL;
		//Trae el primer valor del arreglo
        if ($row = $resultado->fetch_assoc()) {
            // $Valor = array_values($row)[0];
            $Valor = $row[$columna];
        }

        return $Valor;
	}

	// ====================================================================
	// 	Funcion que ejecuta el SQL de inserción, actualización y eliminación
	// ====================================================================
	public static function ejecutar_idu($sql){

		if(!self::es_string($sql))
			exit();

		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();

		if (!$resultado = $mysqli->query($sql) ) {
		    return "class.Database.class: error ". $mysqli->error;
		}else{
			return $mysqli->insert_id;
		}


        return $resultado;
	}

	// ====================================================================
	// 	Funciones para encryptar y desencryptar data:
	// 		crypt_blowfish_bydinvaders
	// ====================================================================
	function crypt($aEncryptar, $digito = 7) {
        $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $salt = sprintf('$2a$%02d$', $digito);
        for($i = 0; $i < 22; $i++)
        {
            $salt .= $set_salt[mt_rand(0, 22)];
        }
        return crypt($aEncryptar, $salt);
    }

    function uncrypt($Evaluar, $Contra){

        if( crypt($Evaluar, $Contra) == $Contra)
            return true;
        else
            return false;

    }

    // ================================================
	//   Funcion que pagina cualquier TABLA
	// ================================================
	Public static function get_todo_paginado( $tabla, $pagina = 1, $por_pagina = 20 ){

		// Core de la funcion
		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();

		$sql = "SELECT count(*) as cuantos from $tabla";

		$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
		$total_paginas = ceil( $cuantos / $por_pagina );

		if( $pagina > $total_paginas ){
			$pagina = $total_paginas;
		}


		$pagina -= 1;  // 0
		$desde   = $pagina * $por_pagina; // 0 * 20 = 0

		if( $pagina >= $total_paginas-1 ){
			$pag_siguiente = 1;
		}else{
			$pag_siguiente = $pagina + 2;
		}

		if( $pagina < 1 ){
			$pag_anterior = $total_paginas;
		}else{
			$pag_anterior = $pagina;
		}

		if( $desde <=0 ){
			$desde = 0;
		}


		$sql = "SELECT * from $tabla limit $desde, $por_pagina";

		$datos = Database::get_arreglo( $sql );

		$resultado = $mysqli->query($sql);

		$arrPaginas = array();
		for ($i=0; $i < $total_paginas; $i++) {
			array_push($arrPaginas, $i+1);
		}


		$respuesta = array(
				'err'     		=> false,
				'conteo' 		=> $cuantos,
				$tabla 			=> $datos,
				'pag_actual'    => ($pagina+1),
				'pag_siguiente' => $pag_siguiente,
				'pag_anterior'  => $pag_anterior,
				'total_paginas' => $total_paginas,
				'paginas'	    => $arrPaginas
				);


		return  $respuesta;

	}

//  // ================================================
//   Funcion que pagina cualquier TABLA_TITULADO
// ================================================
Public static function get_todo_paginado_titulado( $tabla, $pagina = 1, $institucion, $buscar, $por_pagina = 5 ){

	// Core de la funcion
	$db = DataBase::getInstancia();
	$mysqli = $db->getConnection();

	$sql = "SELECT count(*) as cuantos from $tabla DETA INNER JOIN tbl_titulado TI ON DETA.Cod_Dit = TI.T_Dni WHERE DETA.id_institucion = $institucion";

	if($buscar != ''){
		$sql .= " AND (DETA.Cod_Dit like '%".$buscar."%' OR DETA.DIT_Carrera like '%".$buscar."%' OR TI.T_Nombres like '%".$buscar."%' OR TI.T_Apellidos like '%".$buscar."%')";
	}

	$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
	$total_paginas = ceil( $cuantos / $por_pagina );

	if( $pagina > $total_paginas ){
		$pagina = $total_paginas;
	}


	$pagina -= 1;  // 0
	$desde   = $pagina * $por_pagina; // 0 * 20 = 0

	if( $pagina >= $total_paginas-1 ){
		$pag_siguiente = 1;
	}else{
		$pag_siguiente = $pagina + 2;
	}

	if( $pagina < 1 ){
		$pag_anterior = $total_paginas;
	}else{
		$pag_anterior = $pagina;
	}

	if( $desde <=0 ){
		$desde = 0;
	}


	$sql = "SELECT * from $tabla DETA INNER JOIN tbl_titulado TI ON DETA.Cod_Dit = TI.T_Dni WHERE DETA.id_Institucion = $institucion ";
	if($buscar != ''){
		$sql .= " AND (DETA.Cod_Dit like '%".$buscar."%' OR DETA.DIT_Carrera like '%".$buscar."%' OR TI.T_Nombres like '%".$buscar."%' OR TI.T_Apellidos like '%".$buscar."%')";
	}
	$sql .= " order by DETA.id_Detalle_IT DESC limit $desde, $por_pagina ";
	$datos = Database::get_arreglo( $sql );

	$resultado = $mysqli->query($sql);

	$arrPaginas = array();
	for ($i=0; $i < $total_paginas; $i++) {
		array_push($arrPaginas, $i+1);
	}


	$respuesta = array(
			'err'     		=> false,
			'conteo' 		=> $cuantos,
			$tabla 			=> $datos,
			'pag_actual'    => ($pagina+1),
			'pag_siguiente' => $pag_siguiente,
			'pag_anterior'  => $pag_anterior,
			'total_paginas' => $total_paginas,
			'paginas'	    => $arrPaginas
			);


	return  $respuesta;

}
   // ================================================
	//   Funcion que pagina cualquier TABLA usuarios
	// ================================================
	Public static function get_todo_paginado_user( $tabla, $pagina = 1, $por_pagina = 5 ){

		// Core de la funcion
		$db = DataBase::getInstancia();
		$mysqli = $db->getConnection();

		$sql = "SELECT count(*) as cuantos from $tabla";

		$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
		$total_paginas = ceil( $cuantos / $por_pagina );

		if( $pagina > $total_paginas ){
			$pagina = $total_paginas;
		}


		$pagina -= 1;  // 0
		$desde   = $pagina * $por_pagina; // 0 * 20 = 0

		if( $pagina >= $total_paginas-1 ){
			$pag_siguiente = 1;
		}else{
			$pag_siguiente = $pagina + 2;
		}

		if( $pagina < 1 ){
			$pag_anterior = $total_paginas;
		}else{
			$pag_anterior = $pagina;
		}

		if( $desde <=0 ){
			$desde = 0;
		}


		$sql = "SELECT * from $tabla limit $desde, $por_pagina";

		$datos = Database::get_arreglo( $sql );

		$resultado = $mysqli->query($sql);

		$arrPaginas = array();
		for ($i=0; $i < $total_paginas; $i++) {
			array_push($arrPaginas, $i+1);
		}


		$respuesta = array(
				'err'     		=> false,
				'conteo' 		=> $cuantos,
				$tabla 			=> $datos,
				'pag_actual'    => ($pagina+1),
				'pag_siguiente' => $pag_siguiente,
				'pag_anterior'  => $pag_anterior,
				'total_paginas' => $total_paginas,
				'paginas'	    => $arrPaginas
				);


		return  $respuesta;

	}












//  // ================================================
//   Funcion que pagina cualquier TABLA_productos
// ================================================
Public static function get_todo_paginado_productos( $tabla, $pagina = 1, $por_pagina = 5 ){

	// Core de la funcion
	$db = DataBase::getInstancia();
	$mysqli = $db->getConnection();

	$sql = "SELECT count(*) as cuantos from $tabla";

	$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
	$total_paginas = ceil( $cuantos / $por_pagina );

	if( $pagina > $total_paginas ){
		$pagina = $total_paginas;
	}


	$pagina -= 1;  // 0
	$desde   = $pagina * $por_pagina; // 0 * 20 = 0

	if( $pagina >= $total_paginas-1 ){
		$pag_siguiente = 1;
	}else{
		$pag_siguiente = $pagina + 2;
	}

	if( $pagina < 1 ){
		$pag_anterior = $total_paginas;
	}else{
		$pag_anterior = $pagina;
	}

	if( $desde <=0 ){
		$desde = 0;
	}


	$sql = "SELECT * from $tabla order by id_producto DESC limit $desde, $por_pagina";

	$datos = Database::get_arreglo( $sql );

	$resultado = $mysqli->query($sql);

	$arrPaginas = array();
	for ($i=0; $i < $total_paginas; $i++) {
		array_push($arrPaginas, $i+1);
	}


	$respuesta = array(
			'err'     		=> false,
			'conteo' 		=> $cuantos,
			$tabla 			=> $datos,
			'pag_actual'    => ($pagina+1),
			'pag_siguiente' => $pag_siguiente,
			'pag_anterior'  => $pag_anterior,
			'total_paginas' => $total_paginas,
			'paginas'	    => $arrPaginas
			);


	return  $respuesta;

}


// ================================================
//   Funcion que pagina cualquier TABLA detalle cotizacion
// ================================================
Public static function get_todo_paginado_detalle_coti( $tabla, $columna, $pagina = 1, $por_pagina = 200 ){

// Core de la funcion
$db = DataBase::getInstancia();
$mysqli = $db->getConnection();

$sql = "SELECT count(*) as cuantos from $tabla";

$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
$total_paginas = ceil( $cuantos / $por_pagina );

if( $pagina > $total_paginas ){
	$pagina = $total_paginas;
}


$pagina -= 1;  // 0
$desde   = $pagina * $por_pagina; // 0 * 20 = 0

if( $pagina >= $total_paginas-1 ){
	$pag_siguiente = 1;
}else{
	$pag_siguiente = $pagina + 2;
}

if( $pagina < 1 ){
	$pag_anterior = $total_paginas;
}else{
	$pag_anterior = $pagina;
}

if( $desde <=0 ){
	$desde = 0;
}


$sql = "SELECT * from $tabla COD INNER JOIN producto PRO ON COD.id_producto_COD = PRO.id_producto WHERE COD.id_cotizacion = $columna limit $desde, $por_pagina";

$datos = Database::get_arreglo( $sql );

$resultado = $mysqli->query($sql);

$arrPaginas = array();
for ($i=0; $i < $total_paginas; $i++) {
	array_push($arrPaginas, $i+1);
}


$respuesta = array(
		'err'     		=> false,
		'conteo' 		=> $cuantos,
		$tabla 			=> $datos,
		'pag_actual'    => ($pagina+1),
		'pag_siguiente' => $pag_siguiente,
		'pag_anterior'  => $pag_anterior,
		'total_paginas' => $total_paginas,
		'paginas'	    => $arrPaginas
		);


return  $respuesta;

}




// ================================================
//   Funcion que pagina cualquier TABLA verifica detalles de coti
// ================================================
Public static function get_todo_paginado_verifica_detalle( $tabla, $fila, $pagina = 1, $por_pagina = 20 ){

// Core de la funcion
$db = DataBase::getInstancia();
$mysqli = $db->getConnection();

$sql = "SELECT count(*) as cuantos from $tabla";

$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
$total_paginas = ceil( $cuantos / $por_pagina );

if( $pagina > $total_paginas ){
	$pagina = $total_paginas;
}


$pagina -= 1;  // 0
$desde   = $pagina * $por_pagina; // 0 * 20 = 0

if( $pagina >= $total_paginas-1 ){
	$pag_siguiente = 1;
}else{
	$pag_siguiente = $pagina + 2;
}

if( $pagina < 1 ){
	$pag_anterior = $total_paginas;
}else{
	$pag_anterior = $pagina;
}

if( $desde <=0 ){
	$desde = 0;
}


$sql = "SELECT * from $tabla COD WHERE COD.id_cotizacion = $fila limit $desde, $por_pagina";

$datos = Database::get_arreglo( $sql );

$resultado = $mysqli->query($sql);

$arrPaginas = array();
for ($i=0; $i < $total_paginas; $i++) {
	array_push($arrPaginas, $i+1);
}


$respuesta = array(
		'err'     		=> false,
		'conteo' 		=> $cuantos,
		$tabla 			=> $datos,
		'pag_actual'    => ($pagina+1),
		'pag_siguiente' => $pag_siguiente,
		'pag_anterior'  => $pag_anterior,
		'total_paginas' => $total_paginas,
		'paginas'	    => $arrPaginas
		);


return  $respuesta;

}


//  // ================================================
//   Funcion que pagina cualquier TABLA_diseño
// ================================================
Public static function get_todo_paginado_diseño_trabajos( $tabla, $pagina = 1, $por_pagina = 5 ){

	// Core de la funcion
	$db = DataBase::getInstancia();
	$mysqli = $db->getConnection();

	$sql = "SELECT count(*) as cuantos from $tabla";

	$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
	$total_paginas = ceil( $cuantos / $por_pagina );

	if( $pagina > $total_paginas ){
		$pagina = $total_paginas;
	}


	$pagina -= 1;  // 0
	$desde   = $pagina * $por_pagina; // 0 * 20 = 0

	if( $pagina >= $total_paginas-1 ){
		$pag_siguiente = 1;
	}else{
		$pag_siguiente = $pagina + 2;
	}

	if( $pagina < 1 ){
		$pag_anterior = $total_paginas;
	}else{
		$pag_anterior = $pagina;
	}

	if( $desde <=0 ){
		$desde = 0;
	}


	$sql = "SELECT * from $tabla COD
					INNER JOIN cotizacion CO
					ON COD.id_cotizacion = CO.id_coti
					INNER JOIN  producto PRO
					ON COD.id_producto_COD = PRO.id_producto
					INNER JOIN cliente CLI
					ON CO.cliente_id_coti = CLI.id_cliente
					WHERE COD.id_area_temp_COD = 2 AND CO.Autorizado_coti = 'SI'
	 				order by COD.id_COD
					DESC limit $desde, $por_pagina";

	$datos = Database::get_arreglo( $sql );

	$resultado = $mysqli->query($sql);

	$arrPaginas = array();
	for ($i=0; $i < $total_paginas; $i++) {
		array_push($arrPaginas, $i+1);
	}


	$respuesta = array(
			'err'     		=> false,
			'conteo' 		=> $cuantos,
			$tabla 			=> $datos,
			'pag_actual'    => ($pagina+1),
			'pag_siguiente' => $pag_siguiente,
			'pag_anterior'  => $pag_anterior,
			'total_paginas' => $total_paginas,
			'paginas'	    => $arrPaginas
			);


	return  $respuesta;

}





//  // ================================================
//   Funcion que pagina cualquier TABLA_casting
// ================================================
Public static function get_todo_paginado_casting_trabajos( $tabla, $pagina = 1, $por_pagina = 5 ){

	// Core de la funcion
	$db = DataBase::getInstancia();
	$mysqli = $db->getConnection();

	$sql = "SELECT count(*) as cuantos from $tabla";

	$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
	$total_paginas = ceil( $cuantos / $por_pagina );

	if( $pagina > $total_paginas ){
		$pagina = $total_paginas;
	}


	$pagina -= 1;  // 0
	$desde   = $pagina * $por_pagina; // 0 * 20 = 0

	if( $pagina >= $total_paginas-1 ){
		$pag_siguiente = 1;
	}else{
		$pag_siguiente = $pagina + 2;
	}

	if( $pagina < 1 ){
		$pag_anterior = $total_paginas;
	}else{
		$pag_anterior = $pagina;
	}

	if( $desde <=0 ){
		$desde = 0;
	}


	$sql = "SELECT * from $tabla COD
					INNER JOIN cotizacion CO
					ON COD.id_cotizacion = CO.id_coti
					INNER JOIN  producto PRO
					ON COD.id_producto_COD = PRO.id_producto
					INNER JOIN cliente CLI
					ON CO.cliente_id_coti = CLI.id_cliente
					WHERE COD.id_area_temp_COD = 3 AND CO.Autorizado_coti = 'SI'
	 				order by COD.id_COD
					DESC limit $desde, $por_pagina";

	$datos = Database::get_arreglo( $sql );

	$resultado = $mysqli->query($sql);

	$arrPaginas = array();
	for ($i=0; $i < $total_paginas; $i++) {
		array_push($arrPaginas, $i+1);
	}


	$respuesta = array(
			'err'     		=> false,
			'conteo' 		=> $cuantos,
			$tabla 			=> $datos,
			'pag_actual'    => ($pagina+1),
			'pag_siguiente' => $pag_siguiente,
			'pag_anterior'  => $pag_anterior,
			'total_paginas' => $total_paginas,
			'paginas'	    => $arrPaginas
			);


	return  $respuesta;

}



//  // ================================================
//   Funcion que pagina cualquier TABLA_mesa
// ================================================
Public static function get_todo_paginado_mesa_trabajos( $tabla, $pagina = 1, $por_pagina = 5 ){

	// Core de la funcion
	$db = DataBase::getInstancia();
	$mysqli = $db->getConnection();

	$sql = "SELECT count(*) as cuantos from $tabla";

	$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
	$total_paginas = ceil( $cuantos / $por_pagina );

	if( $pagina > $total_paginas ){
		$pagina = $total_paginas;
	}


	$pagina -= 1;  // 0
	$desde   = $pagina * $por_pagina; // 0 * 20 = 0

	if( $pagina >= $total_paginas-1 ){
		$pag_siguiente = 1;
	}else{
		$pag_siguiente = $pagina + 2;
	}

	if( $pagina < 1 ){
		$pag_anterior = $total_paginas;
	}else{
		$pag_anterior = $pagina;
	}

	if( $desde <=0 ){
		$desde = 0;
	}


	$sql = "SELECT * from $tabla COD
					INNER JOIN cotizacion CO
					ON COD.id_cotizacion = CO.id_coti
					INNER JOIN  producto PRO
					ON COD.id_producto_COD = PRO.id_producto
					INNER JOIN cliente CLI
					ON CO.cliente_id_coti = CLI.id_cliente
					WHERE COD.id_area_temp_COD = 4 AND CO.Autorizado_coti = 'SI'
	 				order by COD.id_COD
					DESC limit $desde, $por_pagina";

	$datos = Database::get_arreglo( $sql );

	$resultado = $mysqli->query($sql);

	$arrPaginas = array();
	for ($i=0; $i < $total_paginas; $i++) {
		array_push($arrPaginas, $i+1);
	}


	$respuesta = array(
			'err'     		=> false,
			'conteo' 		=> $cuantos,
			$tabla 			=> $datos,
			'pag_actual'    => ($pagina+1),
			'pag_siguiente' => $pag_siguiente,
			'pag_anterior'  => $pag_anterior,
			'total_paginas' => $total_paginas,
			'paginas'	    => $arrPaginas
			);


	return  $respuesta;

}



//  // ================================================
//   Funcion que pagina cualquier TABLA_mesa
// ================================================
Public static function get_todo_paginado_estados_trabajos( $tabla, $pagina = 1, $por_pagina = 5 ){

	// Core de la funcion
	$db = DataBase::getInstancia();
	$mysqli = $db->getConnection();

	$sql = "SELECT count(*) as cuantos from $tabla";

	$cuantos       = Database::get_valor_query( $sql, 'cuantos' );
	$total_paginas = ceil( $cuantos / $por_pagina );

	if( $pagina > $total_paginas ){
		$pagina = $total_paginas;
	}


	$pagina -= 1;  // 0
	$desde   = $pagina * $por_pagina; // 0 * 20 = 0

	if( $pagina >= $total_paginas-1 ){
		$pag_siguiente = 1;
	}else{
		$pag_siguiente = $pagina + 2;
	}

	if( $pagina < 1 ){
		$pag_anterior = $total_paginas;
	}else{
		$pag_anterior = $pagina;
	}

	if( $desde <=0 ){
		$desde = 0;
	}


	$sql = "SELECT * from $tabla COD
					INNER JOIN cotizacion CO
					ON COD.id_cotizacion = CO.id_coti
					INNER JOIN  producto PRO
					ON COD.id_producto_COD = PRO.id_producto
					INNER JOIN cliente CLI
					ON CO.cliente_id_coti = CLI.id_cliente
					WHERE CO.Autorizado_coti = 'SI' AND COD.id_area_temp_COD < 5
	 				order by COD.id_COD
					DESC limit $desde, $por_pagina";

	$datos = Database::get_arreglo( $sql );

	$resultado = $mysqli->query($sql);

	$arrPaginas = array();
	for ($i=0; $i < $total_paginas; $i++) {
		array_push($arrPaginas, $i+1);
	}


	$respuesta = array(
			'err'     		=> false,
			'conteo' 		=> $cuantos,
			$tabla 			=> $datos,
			'pag_actual'    => ($pagina+1),
			'pag_siguiente' => $pag_siguiente,
			'pag_anterior'  => $pag_anterior,
			'total_paginas' => $total_paginas,
			'paginas'	    => $arrPaginas
			);


	return  $respuesta;

}











	// ================================================
	//   Esta funcion recibe un parametro y retorna
	//   todo lo que coincida en la tabla con ese parametro
	// ================================================
	Public static function get_por_nombre($tabla, $campo, $parametro ){

		$sql = "SELECT * FROM $tabla where ". Database::where_palabras_query($campo, $parametro);;


		$data = Database::get_arreglo($sql);

		$respuesta = array(
				'err' => false,
				$tabla => $data
			);

		// return $respuesta;
		return $respuesta;

	}

	Public static function where_palabras_query( $campo, $parametro ){

		$palabras = explode(" ", $parametro );
		$retorno  = "";

		for ($i=0; $i < count($palabras) ; $i++) {

			if( $i == 0){
				$retorno = "$campo like '%$palabras[0]%'";
			}else{
				$retorno .= " and $campo like '%$palabras[$i]%'";
			}

		}

		return $retorno;

	}

}




?>
