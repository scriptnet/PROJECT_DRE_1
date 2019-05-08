var myApp = angular.module('scriptnet',['ngRoute','ngSanitize','ui.bootstrap','scriptnet.cargarCrtl','scriptnet.tituladosServ']);

myApp.controller('panelControlador', ['$scope', function($scope){
    $scope.hola = 'Hosla';
    $scope.load = false;
}]);

// Rutas

myApp.config(['$routeProvider', function($routeProvider){
    $routeProvider
        .when('/',{
            templateUrl:'ruta/index.html'
        })
        .when('/perfil',{
            templateUrl:'ruta/perfil.html'
        })
        .when('/titulados',{
            templateUrl:'ruta/titulados.html'
        })
        .when('/cargar/:pag',{
            templateUrl:'ruta/cargar.html',
            controller: 'cargarCtrl'
        })
        .when('/institucion/:pag',{
            templateUrl:'ruta/institucion.html',
            //controller: 'institucionCtrl'
        })
        .otherwise({
            redirectTo: '/'
        })
}]);