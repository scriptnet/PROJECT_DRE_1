var app = angular.module('scriptnet.tituladosServ',[]);

app.factory('Titulados', ['$http', '$q', function($http, $q){
    var self = {
        'cargando'		: false,
		'err'     		: true,
		'conteo' 		: 0,
		'titulado' 		: [],
		'pag_actual'    : 1,
		'pag_siguiente' : 1,
		'pag_anterior'  : 1,
		'total_paginas' : 1,
        'paginas'	    : [],
        

        cargarPagina: function( pag, searchText ){

			var d = $q.defer();
            if(searchText == undefined){
                searchText = '';
            }
			$http.get('api/get.titulado.php?pag=' + pag +'&buscar='+ searchText)
				.success(function( data ){

					self.err           = data.err;
					self.conteo        = data.conteo;
					self.titulado      = data.tbl_detalle_it;
					self.pag_actual    = data.pag_actual;
					self.pag_siguiente = data.pag_siguiente;
					self.pag_anterior  = data.pag_anterior;
					self.total_paginas = data.total_paginas;
					self.paginas       = data.paginas;

					return d.resolve();
				});



			return d.promise;
        }
        
    };
    return self;
}]);