var app = angular.module('DREETTP.titulos',[]);


app.factory('Titulos', ['$http', '$q', function($http, $q){

	var self = {

		'cargando'		: false,
		'err'     		: false,
		'conteo' 		: 0,
		'DNI'			: [],
		'titulo' 		: [],
		'valid' 		: [],
		'detalle_T' 		: [],
		'pag_actual'    : 1,
		'pag_siguiente' : 1,
		'pag_anterior'  : 1,
		'total_paginas' : 1,
		'paginas'	    : [],


		// ############################### Buscar a los titulo que considan

		buscar: function( parametro ){
			var d = $q.defer();
			self.cargando = true;
			$http.post('consultas/dni.php?p=' + parametro )
				.success(function( respuesta ){
					self.cargando = false;
					self.DNI = respuesta.DNI;
					
					d.resolve();
				});
			return d.promise;
		},
		
		// Fin
		// validamos el capcha
		validarCapcha: function( parametro ){
			var d = $q.defer();
			self.cargando = true;
			$http.post('consultas/get.captcha.php?cap=' + parametro )
				.success(function( respuesta ){
					self.cargando = false;
					self.valid = respuesta.success;
					d.resolve();	
				});
			return d.promise;
		},
		//Titulado
		detalle_titulado: function(parametro){
			
			var d = $q.defer();
			self.cargando = true;
			$http.post('consultas/get.detalle_titulado.php?p=' + parametro)
				.success(function( respuesta ){
					console.log(respuesta);
					self.cargando = false;
					self.detalle_T = respuesta;
					
					
					
					
					d.resolve();
					
					
				});
				return d.promise;
				}
		
	};


	return self;


}]);
