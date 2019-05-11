var app = angular.module('scriptnet.institucionServ',[]);


app.factory('Institucion', [ '$http', '$q', function( $http, $q){
   
   


	var self = {
        'cargando'		: false,
		'err'     		: false,
		'conteo' 		: 0,
		'usuarios' 		: [],
		'pag_actual'    : 1,
		'pag_siguiente' : 1,
		'pag_anterior'  : 1,
		'total_paginas' : 1,
        'paginas'	    : [],
        

		config:{},
		cargar: function(){

			var d = $q.defer();

			$http.get('generado/institucion.json')
				.success(function(data){

					self.config = data;
					d.resolve();


				})
				.error(function(){

					d.reject();
					console.error("No se pudo cargar el archivo de configuración");

				});

			return d.promise;
        },
        
        //guardar usuario
        guardar: function( usuario){
            
            var d = $q.defer();

                    $http({
                        method: 'POST',
                        url: 'api/save.user.php',
                        data: usuario
                  
                      }).then(function successCallback(respuesta) {
                  
                        console.log(respuesta);
						d.resolve();
                  
                      }, function errorCallback(respuesta) {
                  
                        alert("Error al guardar");
                  
                      });


			return d.promise;
        },

        cargarPagina: function( pag ){

			var d = $q.defer();



                $http({
                    method: 'GET',
                    url: 'api/get.usuarios.php?pag=' + pag 
                
                  }).then(function successCallback(data) {
  
                    self.err           = data.data.err;
					self.conteo        = data.data.conteo;
					self.usuarios      = data.data.tbl_usuario;
					self.pag_actual    = data.data.pag_actual;
					self.pag_siguiente = data.data.pag_siguiente;
					self.pag_anterior  = data.data.pag_anterior;
					self.total_paginas = data.data.total_paginas;
					self.paginas       = data.data.paginas;
                   console.log(data);
                    return d.resolve();
                
                  }, function errorCallback(data) {
                
                    alert("Error. Try Again!");
                
                  });



			return d.promise;
		}



	};


	return self;

}])