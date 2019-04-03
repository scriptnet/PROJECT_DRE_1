var app = angular.module('DREETTP.titulosCrtl', []);

// ================================================
//   Controlador de Titulos
// ================================================
app.controller('titulosCtrl', ['$scope', 'Titulos', function($scope, Titulos){

//#################################### iniializamos variables ###################################
$scope.titulado = {};
$scope.buscar = 'alex'; // aqui podriamos volocar un valor en el input de Titulos
//#################################### vamos a buscar el titulo ###################################
$scope.buscarTitulo = function(buscar){
	$scope.titulos = {};

	Titulos.buscar(buscar).then(function(){
		   if( isNaN( buscar ) )
		{
				   $("#modal_buscar_titulo").modal();
					   $scope.titulos = Titulos.titulo;
			  }else{
					  $scope.titulo = Titulos.titulo[0];
			  		  $scope.titulos = Titulos.titulo;
			  }
   });

}
}]);
