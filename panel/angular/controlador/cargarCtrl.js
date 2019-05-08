var app = angular.module('scriptnet.cargarCrtl', []);

app.controller('cargarCtrl', ['$scope', '$http','$routeParams','$uibModal','$log','$document', 'Titulados', function ($scope, $http, $routeParams,$uibModal, $log, $document, Titulados) {  
    // Listar
    $scope.maxSize = 5;
    $scope.bigTotalItems = 200;
    $scope.bigCurrentPage = 1;

    $scope.paginar = [];

    var pag = $routeParams.pag;

	$scope.titulados = {};
    $scope.cargando = false;
    
    $scope.moverA = function( pag ){
    
        $scope.fetchEmployees = function(){
            var searchText = $scope.searchText; 
		Titulados.cargarPagina( pag, searchText ).then( function(){
            $scope.titulados = Titulados;


            // var paginit = 1;
            // var pagend = paginit + 2;

            // var arr = [];
            // while(paginit < pagend){
            //     arr.push(paginit++);
            //   }
            
            //   $scope.paginar = arr;
            
            //   console.log( $scope.titulados);
            // console.log($scope.titulados.paginas);
        });  
        
    }
    $scope.fetchEmployees();
    };

	$scope.moverA(pag);
    // $scope.maspag = function(next){
    //  if (next < $scope.titulados.paginas.length ) {
    //    var inicio =next+1;
    //    var fin = inicio+2;
    //    var res =[];
    //    while(inicio < fin){
    //     res.push(inicio++);
    //   }
    //   $scope.paginar = res;
     
    //  } else {
       
    //  }
     
    //  console.log($scope.paginar.length);
    //   console.log(res);
    // };
    
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
               
                
                $scope.moverA(pag);
            } 
            else {  
                $scope.msg = "Error : Something Wrong";  
                
            }  
        }, function (error) {  
            // $scope.msg = "Error : Something Wrong";  
           
        })  
    };

    // ###################################### Modal
    
    $scope.items = ['item1', 'item2', 'item3'];
    $scope.tituladosSel = {};
    $scope.animationsEnabled = true;
    $scope.open = function (titulado, size, parentSelector) {
     
        angular.copy( titulado, $scope.tituladosSel );
    
        var parentElem = parentSelector ? 
          angular.element($document[0].querySelector('.modal-fade ' + parentSelector)) : undefined;
        var modalInstance = $uibModal.open({
          animation: $scope.animationsEnabled,
          ariaLabelledBy: 'modal-title',
          ariaDescribedBy: 'modal-body',
          templateUrl: 'myModalContent.html',
          controller: 'ModalInstanceCtrl',
          controllerAs: '$scope',
          size: size,
          appendTo: parentElem,
          resolve: {
            tituladosSel: function () {
              return $scope.tituladosSel;
            }
          }
        });
    
        modalInstance.result.then(function (selectedItem) {
          $scope.selected = selectedItem;
        }, function () {
          $log.info('Modal dismissed at: ' + new Date());
        });
      };
      
       
  
}]);

app.controller('ModalInstanceCtrl',['$scope','$uibModalInstance', 'tituladosSel', function($scope, $uibModalInstance,tituladosSel){
   
    $scope.items = tituladosSel;
    console.log($scope.items);
    $scope.selected = {
      item: $scope.items[0]
    };
  
    $scope.ok = function () {
      $uibModalInstance.close($scope.selected.item);
    };
  
    $scope.cancel = function () {
      $uibModalInstance.dismiss('cancel');
    };

}]);

