var app = angular.module('scriptnet.institucionCrtl', []);



app.controller('institucionCtrl', ['$scope','$routeParams','$uibModal','$log','$document', 'Institucion','$timeout','cfpLoadingBar',  function($scope, $routeParams, $uibModal, $log, $document,  Institucion, $timeout, cfpLoadingBar){

    $scope.start = function() {
        cfpLoadingBar.start();
      };
  
      $scope.complete = function () {
        cfpLoadingBar.complete();
      };

    $scope.start();
    $scope.fakeIntro = true;
    $timeout(function() {
      $scope.complete();
      $scope.fakeIntro = false;
    }, 250);

    //creamos el usuario
    $scope.crearUsuario = function(usuario){
        Institucion.guardar( usuario ).then(function(){
            cfpLoadingBar.complete();
                $scope.users = {};
        });

    };
    //traemos data PARA select instituciones
    $scope.data = {
        model: null,
        availableOptions: [
          {id: '1', name: 'Senati'},
          {id: '2', name: 'Victorino Elorz Goicoechea'}
        ]
       };
    //traemos la data de todos lo usuarios
   
    var pag = $routeParams.pag;

	$scope.listUser = {};
    $scope.cargando = false;
    
    $scope.moverA = function( pag ){

           Institucion.cargarPagina( pag ).then( function(){
            $scope.listUser = Institucion;
            console.log($scope.listUser);

        });  
    };
	$scope.moverA(pag);
}]);