var app = angular.module( 'DREETTP',[
    'ngRoute','vcRecaptcha', 'DREETTP.LoginService',
    'DREETTP.titulos',
    ]);

app.controller('mainCtrl', ['$scope', '$http', 'Titulos', 'vcRecaptchaService','loginService', function($scope,$http, Titulos, vcRecaptchaService, loginService){
	
	//#################################### iniializamos variables ###################################
	$scope.identidad = {};
	$scope.Detalle_T = {};
	$scope.buscar = '78375004'; // aqui podriamos volocar un valor en el input de Titulos
	$scope.cargando = false;
	$scope.error = false;
	$scope.error2 = false;
	$scope.load_dt = false;


	console.log("this is your app's controller");
	$scope.response = null;
	$scope.widgetId = null;

	$scope.model = {
		key: '6LdUnZsUAAAAALFmOHAI5KQgM9l90-vI8D5aSvUx'
	};
	$scope.setResponse = function (response) {
		console.info('Response available');

		$scope.response = response;
		
	};
	$scope.setWidgetId = function (widgetId) {
		console.info('Created widget ID: %s', widgetId);

		$scope.widgetId = widgetId;
	};
	$scope.cbExpiration = function() {
		console.info('Captcha expired. Resetting response object');

		vcRecaptchaService.reload($scope.widgetId);

		$scope.response = null;
	 };
	 $scope.submit = function (buscar) {
		
		$scope.cargando = true;
		$scope.error = false;
		vcRecaptchaService.reload($scope.widgetId);
		Titulos.validarCapcha($scope.response).then(function(){
			$scope.cargando = false;
				
			
			
				 if (Titulos.valid) {
					
					$scope.titulos = {};
			Titulos.buscar(buscar).then(function(){
				if( isNaN( buscar ) )
				{	
					//si es texto
							$("#resultadosModalDni").modal();
							   $scope.titulos = Titulos.titulo;
							  // console.log($scope.titulos);
					  }else{
							$("#resultadosModalDni").modal();
							  $scope.identidad = Titulos.DNI;
							 
							  
								// $scope.titulos = Titulos.titulo;
								console.log($scope.identidad[0]);
								 $scope.load_dt = true;
								Titulos.detalle_titulado($scope.identidad[0]).then(function(){
									if (Titulos.detalle_T.Detalle_T.length > 0) {
										//console.log("DATO RECIBIDO");
										//console.log(Titulos.detalle_T.Detalle_T.length);
										
										$scope.load_dt = false
										$scope.Detalle_T = Titulos.detalle_T;
										
										
									} else {
										$scope.load_dt = false
										$scope.error2 = true;
										console.log("DATO no RECIBIDO");
										
									}
									
									
									
									
								});
					  }	  
		   });
					
				 }else{
					$scope.error = true;
				 }
				  
	   });

		// console.log('sending the captcha response to the server', $scope.response);

		// if (valid) {
		// 	console.log('Success');
		// } else {
		// 	console.log('Failed validation');

		// 	// In case of a failed validation you need to reload the captcha
		// 	// because each response can be checked just once
		// 	vcRecaptchaService.reload($scope.widgetId);
		// }
	};

	//Fin captcha

    $scope.DESARROLLADOR = {
        nombre:"Alex Yzquierdo"
    }
	$scope.titulo_sel = function(titulo){
		$scope.load_dt = true;
		$scope.titulo = titulo;
		
		Titulos.detalle_titulado($scope.titulo.id_Titulado).then(function(){
			$scope.load_dt = false
			$scope.Detalle_T = Titulos.detalle_T;
			//console.log($scope.Detalle_T);
		});
		
	}
	$scope.limpiarVar = function(){
		$scope.identidad = {};
		$scope.Detalle_T = {};
		$scope.error2 = false;
	}

	//Login controlador
	$scope.login = function (){
		$("#loginModal").modal();
	}
	$scope.invalido = false;
	$scope.cargandoLogin = false;
	$scope.mensaje = "";
	$scope.datos = {
		//objeto
	};

	$scope.ingresar = function (datos){
		$scope.cargandoLogin = true;

		loginService.login( datos ).then( function (data){
				if ( data.err ) {
					$scope.invalido = true;
					$scope.cargandoLogin = false;
					$scope.mensaje = data.mensaje;
				} else {
					window.location = data.url;
				}
		});
	}
}]);