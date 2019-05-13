var app = angular.module('scriptnet.institucionServ',[]);


app.factory('Institucion', [ '$http', '$q', function( $http, $q){
   
   


	var self = {
    'cargando'		: false,
		'err'     		: false,
		'err2'     		: false,
		'conteo' 		: 0,
		'conteo2' 		: 0,
		'usuarios' 		: [],
		'selecInstituto': [],
		'ListInstituto' : [],
		'pag_actual'    : 1,
		'pag_actual2'    : 1,
		'pag_siguiente' : 1,
		'pag_siguiente2' : 1,
		'pag_anterior'  : 1,
		'pag_anterior2'  : 1,
		'total_paginas' : 1,
		'total_paginas2' : 1,
		'paginas'	    : [],
		'paginas2'	    : [],
		'mensaje'				:"",
		

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
												
												self.mensaje = respuesta.data.Mensaje;
												self.err		 = respuesta.data.err;
											
												
												
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
                   
                    return d.resolve();
                
                  }, function errorCallback(data) {
                
                    alert("Error. Try Again!");
                
                  });

			return d.promise;
		},
		SelectInsti: function(){
			var d =$q.defer();
			$http({
				method: 'GET',
				url: 'api/get.selecInstituto.php'
		
			}).then(function successCallback(data) {

			
			
				 self.selecInstituto      = data.data.tbl_institucion;
				
			 
				return d.resolve();
		
			}, function errorCallback(data) {
		
				alert("Error. Try Again!");
		
			});
			return d.promise;
		},
		guardarInstitucion: function(institucion){
			var d = $q.defer();

			$http({
					method: 'POST',
					url: 'api/save.institucion.php',
					data: institucion
		
				}).then(function successCallback(respuesta) {
					
					self.mensaje = respuesta.data.Mensaje;
					self.err		 = respuesta.data.err;

					d.resolve();
		
				}, function errorCallback(respuesta) {
		
					alert("Error al guardar");
		
				});

		return d.promise;
		},
		ListInst: function(pag2){
			var d = $q.defer();
                $http({
                    method: 'GET',
                    url: 'api/get.listInstituto.php?pag2=' + pag2
                
                  }).then(function successCallback(data) {
  
                    self.err2           = data.data.err;
										self.conteo2        = data.data.conteo;
										self.ListInstituto  = data.data.tbl_institucion;
										self.pag_actual2    = data.data.pag_actual;
										self.pag_siguiente2 = data.data.pag_siguiente;
										self.pag_anterior2  = data.data.pag_anterior;
										self.total_paginas2 = data.data.total_paginas;
										self.paginas2      = data.data.paginas;
                   
                    return d.resolve();
                
                  }, function errorCallback(data) {
                
                    alert("Error. Try Again!");
                
                  });

			return d.promise;
		}




	};


	return self;

}])