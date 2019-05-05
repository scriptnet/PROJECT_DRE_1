var myApp = angular.module('scriptnet',['ngRoute','scriptnet.cargarCrtl']);

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
        .when('/cargar',{
            templateUrl:'ruta/cargar.html',
            controller: 'cargarCtrl'
        })
        .otherwise({
            redirectTo: '/'
        })
}]);