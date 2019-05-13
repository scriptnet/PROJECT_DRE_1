var app = angular.module('scriptnet.institucionCrtl', []);



app.controller('institucionCtrl', ['$scope','$routeParams','$uibModal','$log','$document', 'toasty', 'Institucion','$timeout','cfpLoadingBar',  function($scope, $routeParams, $uibModal, $log, $document,toasty, Institucion, $timeout, cfpLoadingBar){

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

    // alerta
    $scope.button = 'ping';



    $scope.themes = [{
      name: 'Default Theme',
      code: 'default'
    }, {
      name: 'Material Design',
      code: 'material'
    }, {
      name: 'Bootstrap 3',
      code: 'bootstrap'
    }];
  
    $scope.types = [{
      name: 'Default',
      code: 'default',
    }, {
      name: 'Info',
      code: 'info'
    }, {
      name: 'Success',
      code: 'success'
    }, {
      name: 'Wait',
      code: 'wait'
    }, {
      name: 'Error',
      code: 'error'
    }, {
      name: 'Warning',
      code: 'warning'
    }];



    
    $scope.options = {
      title: 'Éxito',
      msg: '',
      showClose: true,
      clickToClose: false,
      limit: 10,
      timeout: 5000,
      sound: false,
      html: false,
      shake: false,
      theme: $scope.themes[0].code,
      type: $scope.types[2].code
    };


    $scope.newToast = function() {

      $scope.button = $scope.button == 'ping' ? 'pong' : 'ping';
  
      toasty[$scope.options.type]({
        title: $scope.options.title,
        msg: $scope.options.msg,
        showClose: $scope.options.showClose,
        clickToClose: $scope.options.clickToClose,
        limit: $scope.options.limit,
        sound: $scope.options.sound,
        shake: $scope.options.shake,
        timeout: $scope.options.timeout || false,
        html: $scope.options.html,
        theme: $scope.options.theme,

        onAdd: function() {
          console.log('Toasty ' + this.id + ' has been added!');
        },
        onRemove: function() {
          console.log('Toasty ' + this.id + ' has been removed!');
        },
        onClick: function() {
          console.log('Toasty ' + this.id + ' has been clicked!');
        }
      });
    };


    //creamos el usuario
    $scope.cargandoUsuario = false;
    $scope.crearUsuario = function(usuario){
     
        Institucion.guardar( usuario ).then(function(){
            cfpLoadingBar.complete();
           
            if (Institucion.err) {
              $scope.mensaje = "Este Usuario ya esta creado"
              $scope.status = $scope.types[4].code;
            } else {
              $scope.mensaje = Institucion.mensaje;
              $scope.status = $scope.types[2].code;
            }
            
            $scope.options.msg = $scope.mensaje;
            $scope.options.type = $scope.status;
            $scope.newToast();
            $scope.moverA(pag);
           
            $scope.users = {};
        });

    };
  
    //traemos la data de todos lo usuarios
   
    var pag = $routeParams.pag;

	$scope.listUser = {};
    $scope.cargando = false;
    
    $scope.moverA = function( pag ){

           Institucion.cargarPagina( pag ).then( function(){
            $scope.listUser = Institucion;
        });  
    };
  $scope.moverA(pag);
  
    //traemos data PARA select instituciones
  $scope.SelectInst = {};
  $scope.SelectsCall = function( ){
    Institucion.SelectInsti().then( function(){
      $scope.SelectInst = Institucion;
    });
  };
  $scope.SelectsCall();
  //listar Instituciones
  var pag2 = $routeParams.pag2;
  $scope.ListInst = {};

  $scope.ListInstFunc = function (pag2){
    Institucion.ListInst(pag2).then( function(){
      $scope.ListInst = Institucion;
      
      
    });
  };
  $scope.ListInstFunc(pag2);

  //modal Registrar nueva Institución
 
  $scope.abrirmodal = function( size, parentSelector){  
    
    var parentElem = parentSelector ?
    angular.element($document[0].querySelector('.modal-fade ' + parentSelector)) : undefined;
    var modalInstance = $uibModal.open({
      animation: $scope.animationsEnabled,
      ariaLabelledBy: 'modal-title',
      ariaDescribedBy: 'modal-body',
      templateUrl: 'modal/myModalInstitucion.html',
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
      $scope.SelectsCall();
      $scope.ListInstFunc(pag2);
      $log.info('Modal dismissed at: ' + new Date());
    });
  };
}]);

















app.controller('ModalInstanceCtrl',['$scope','$uibModalInstance', 'Institucion','toasty','cfpLoadingBar', function($scope, $uibModalInstance, Institucion, toasty, cfpLoadingBar){

  
  
  $scope.themes = [{
    name: 'Default Theme',
    code: 'default'
  }, {
    name: 'Material Design',
    code: 'material'
  }, {
    name: 'Bootstrap 3',
    code: 'bootstrap'
  }];

  $scope.types = [{
    name: 'Default',
    code: 'default',
  }, {
    name: 'Info',
    code: 'info'
  }, {
    name: 'Success',
    code: 'success'
  }, {
    name: 'Wait',
    code: 'wait'
  }, {
    name: 'Error',
    code: 'error'
  }, {
    name: 'Warning',
    code: 'warning'
  }];



  
  $scope.options = {
    title: 'Éxito',
    msg: '',
    showClose: true,
    clickToClose: false,
    limit: 10,
    timeout: 5000,
    sound: false,
    html: false,
    shake: false,
    theme: $scope.themes[0].code,
    type: $scope.types[2].code
  };


  $scope.newToast = function() {

    $scope.button = $scope.button == 'ping' ? 'pong' : 'ping';

    toasty[$scope.options.type]({
      title: $scope.options.title,
      msg: $scope.options.msg,
      showClose: $scope.options.showClose,
      clickToClose: $scope.options.clickToClose,
      limit: $scope.options.limit,
      sound: $scope.options.sound,
      shake: $scope.options.shake,
      timeout: $scope.options.timeout || false,
      html: $scope.options.html,
      theme: $scope.options.theme,

      onAdd: function() {
        console.log('Toasty ' + this.id + ' has been added!');
      },
      onRemove: function() {
        console.log('Toasty ' + this.id + ' has been removed!');
      },
      onClick: function() {
        console.log('Toasty ' + this.id + ' has been clicked!');
      }
    });
  };

  $scope.cargandoInstitucion = false;
  $scope.crearInstitucion = function(institucion){
    Institucion.guardarInstitucion(institucion).then(function(){
      if (Institucion.err) {
        $scope.titulo = 'ERROR';
        $scope.mensaje = Institucion.mensaje;
        $scope.status = $scope.types[4].code;
      } else {
        $scope.titulo = 'Todo Bien';
        $scope.mensaje = Institucion.mensaje;
        $scope.status = $scope.types[2].code;
        
      }
      $scope.options.title = $scope.titulo;
      $scope.options.msg = $scope.mensaje;
      $scope.options.type = $scope.status;
      $scope.newToast();
    });
    
  };


 

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

}]);