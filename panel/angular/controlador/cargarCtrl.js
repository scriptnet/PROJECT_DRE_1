var app = angular.module('scriptnet.cargarCrtl', []);

app.controller('cargarCtrl', ['$scope', '$http','$routeParams','Titulados', function ($scope, $http, $routeParams, Titulados) {  
    // Listar
    var pag = $routeParams.pag;

	$scope.titulados = {};
	$scope.tituladosSel = {};

    $scope.moverA = function( pag ){
        $scope.fetchEmployees = function(){
            var searchText = $scope.searchText;
               
            
		Titulados.cargarPagina( pag, searchText ).then( function(){
			$scope.titulados = Titulados;
        console.log($scope.titulados);
        });
        
    }
    $scope.fetchEmployees();
    };
    
	$scope.moverA(pag);
    // ######################################buscaremos al titulado
       
            //Obtener datos
            // $scope.fetchEmployees = function(){
                
            //     var searchText = $scope.searchText;
            //     if(searchText == undefined){
            //         searchText = '';
            //     }

            //     $http({
            //     method: 'post',
            //     url: 'post.buscar.titulado.php',
            //     data: {searchText:searchText, request: 2}
            //     }).then(function successCallback(response) {
            //         $scope.employees = response.data;
            //     });
            // }
            // $scope.fetchEmployees();
       
    // ###################################### cargar exel

    $scope.selectedFile = null;  
    $scope.msg = "";  
    $scope.loadFile = function (files) {  
        $scope.$apply(function () {  
            $scope.selectedFile = files[0];  
        })  
    }  
        $scope.handleFile = function (user) {  
        var file = $scope.selectedFile;  
        if (file) {  
            var reader = new FileReader();  
            reader.onload = function (e) {  
                var data = e.target.result;  
                var workbook = XLSX.read(data, { type: 'binary' });  
                var first_sheet_name = workbook.SheetNames[0];  
                var dataObjects = XLSX.utils.sheet_to_json(workbook.Sheets[first_sheet_name]);   
                if (dataObjects.length > 0) {  
                    $scope.save(dataObjects,user);  
                } else {  
                    $scope.msg = "Error : Something Wrong !";  
                }  
            }  
            reader.onerror = function (ex) {  
            }  
            reader.readAsBinaryString(file);  
        }  
    }  
    $scope.save = function (data, user) {
       
        $http({  
            method: "POST",  
            url: "api/egresados.php",  
            data:  JSON.stringify(data, user),  
            headers: {  
                'Content-Type': 'application/json'  
            }
        }).then(function (data) {
            if (data.status) {  
                $scope.msg = "Cargado! ";  
                var pag = $routeParams.pag;

                $scope.titulados = {};
                $scope.tituladosSel = {};
            
                $scope.moverA = function( pag ){
            
                    Titulados.cargarPagina( pag ).then( function(){
                        $scope.titulados = Titulados;
                    console.log($scope.titulados);
                    });
            
                };
                
                $scope.moverA(pag);
            } 
            else {  
                $scope.msg = "Error : Something Wrong";  
                
            }  
        }, function (error) {  
            // $scope.msg = "Error : Something Wrong";  
           
        })  
    }  
  
}]);