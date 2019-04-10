<?php 
  session_start();
  unset ( $_SESSION['user'] ); 
?>
<!DOCTYPE html>
<html ng-app="DREETTP" ng-controller="mainCtrl">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Titulo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="landing/stisla.png">
    <link rel="stylesheet" href="dist/modules/prism/prism.css">
    <link rel="stylesheet" href="dist/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="dist/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="dist/modules/chocolat/dist/css/chocolat.css">
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="dist/css/custom.css">
    <link rel="stylesheet" href="landing/style.css">
    <link rel="stylesheet" href="dist/css/components.css">

    <link rel="stylesheet" href="dist/modules/owlcarousel2/owl.carousel.min.css">
  <link rel="stylesheet" href="dist/modules/owlcarousel2/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/style_edit.css">
    <!-- Importaciones de angular -->
    <script src="angular/lib/angular.min.js"></script>
    <script src="angular/lib/angular-route.min.js"></script>
    <!-- Controladores -->
    <script src="angular/app.js"></script>
    <script src="angular/controladores/Titulos_Ctrl.js"></script>
     <!-- servicios -->
     <script src="angular/servicios/Titulos_Servicio.js"></script>
     <script src="angular/servicios/Login_Servicio.js"></script>

     <!-- recapcha -->
     <!-- Include the ngReCaptcha directive -->
     <script src="dist/modules/angular-recaptcha.js"></script>
    
</head>
<body>
    <body class="body-grey">
      
        <!-- Menu -->
        <nav class="navbar navbar-reverse navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand smooth" href="#">
                    <div class="">
                        <div class="product-image">
                          <img alt="image" src="img/GRC_2019V2.png" class="img-fluid">
                        </div>
                         
                      </div>
                 
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto ml-lg-3 align-items-lg-center">
                           
                        <li class="nav-item d-lg-none d-md-block"><a href="#" class="nav-link smooth" target="_blank">Login</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto align-items-lg-center d-none d-lg-block">
                        <li class="ml-lg-3 nav-item">
                            <a href="#" ng-click="login()" class="btn btn-round smooth btn-icon icon-left">
                                <i class="fas fa-user"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
         <!-- Menu fin-->
        
         <div class="hero-mini">
           
                <div class="container" style="padding-top: 130px;">
                  
                    <div class="row align-items-center">
                      
                        <div class="col-lg-7">
                            <form  ng-submit="submit(buscar)">
                                <h1>¡Bienvenidos!</h1>
                                <p class="lead">Verifica si estás inscrito en el registro nacional de títulos pedagógicos o tecnológicos. 
                                    <a href="#"  id="modal-2" class="text-white">Ayuda</a>
                                </p>
                                <div class="form-group row">
                                    
                                    <div class="col-sm-12 col-md-6">
                                        <br>
                                        <label for="frist_name">DNI:</label>
                                        <input ng-model="buscar" type="text" class="form-control" required>
                                    </div>
                                    
                                    <div class="col-sm-12 col-md-6">
                                        <br>
                                        <div
                                        vc-recaptcha
                                        theme="'light'"
                                        key="model.key"
                                        on-create="setWidgetId(widgetId)"
                                        on-success="setResponse(response)"
                                        on-expire="cbExpiration()"
                                    ></div>
                                    </div>
                                </div>
                                
                                <div class="cta">
                                    <!-- <a class="btn btn-lg btn-warning btn-icon icon-right" href="#" id="my-button2">Verificar Ahora <i class="fas fa-chevron-right"></i></a> -->
                                    <button type="submit" class="btn btn-lg btn-info btn-icon icon-right" ng-click="limpiarVar()">
                                      Verificar Ahora 
                                     
                                      <i class="fas fa-chevron-right">
                                      </i>
                                      <a ng-show="cargando" href="#" class=" btn-progress">Progress</a>
                                      <div ng-show="error" class="badge badge-danger mb-0">Error</div>
                                    </button>
                                    
                                </div>
                                
                            </form>
                        </div>
                        
                        <div class="col-lg-5 pl-lg-5 d-lg-block d-none text-center">
                            <!-- https://getstisla.com/landing/undraw_hello_aeia.svg -->
                            <img src="landing/studiante.svg" alt="image" class="img-fluid img-flip" width="80%">
                        </div>
                        
                    </div>
                    
                    
                </div>
                
            </div>
            <div class="container">
              <div class="row">
              <div class="col-lg-7" style="padding-top: 50px;" >
              <div class="d-sm-none d-lg-inline-block texto_blanco">
                NOTA:</div>
                        </div>  
              </div>
            </div>
            
            <div class="" style="padding-top: 150px">
                <div class="owl-carousel owl-theme" id="products-carousel">
                    <div>
                      <div class="product-item pb-3">
                        <div class="product-image">
                          <img alt="image" src="img/slider_1.jpg" class="img-fluid">
                        </div>
                        
                      </div>
                    </div>
                    <div>
                      <div class="product-item">
                        <div class="product-image">
                          <img alt="image" src="img/slider_2.png" class="img-fluid">
                        </div>
                         
                      </div>
                    </div>
                    <div>
                      <div class="product-item">
                        <div class="product-image">
                          <img alt="image" src="img/slider_3.png" class="img-fluid">
                        </div>
                         
                      </div>
                    </div>
                  </div>
            </div>
            
            <!-- Formulario Login -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form  name="forma" ng-submit="ingresar( datos )">
                        
                          <div class="profile-widget" class="modal-part">
                              <div class="profile-widget-header">                     
                                  <img alt="image" src="img/login.png" class="img-login">
                                </div>
                          </div>
                          <div class="form-group">
                              <label>Usuario</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                  </div>
                                </div>
                                <input
                                  type="text" 
                                  class="form-control" 
                                  placeholder="Usuario"
                                  name="Usuario"
                                  required="required"
                                  ng-model="datos.usuario">
                                  
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Contraseña</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                  </div>
                                </div>
                                <input 
                                  type="password" 
                                  class="form-control" 
                                  placeholder="Contraseña"
                                  name="contrasena"
                                  required="required"
                                  ng-model="datos.contrasena">
                              </div>
                            </div>
                            <div ng-show="invalido" class="alert alert-danger">{{mensaje}} </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="submit" ng-disabled="forma.$invalid || cargandoLogin" class="btn btn-primary">Ingresar</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
           
            <!-- Formulario Login Fin -->
            <!-- Modal Verificando -->
            <!-- Modal -->
            
            <!-- Modal con DNI -->
                  <div class="modal fade" id="resultadosModalDni" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Resultados:</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            
                              <div class="profile-widget" ng-hide="identidad[0] === undefined">
                                  <div class="profile-widget-header">                     
                                    <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                                    <div class="profile-widget-items">
                                      <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Titulos</div>
                                        <div class="profile-widget-item-value">{{Detalle_T.Detalle_T.length}}</div>
                                      </div>
                                      <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Verificado</div>
                                        <div class="profile-widget-item-value">Si</div>
                                      </div>
                                      <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Actualizado</div>
                                        <div class="profile-widget-item-value">30/05/18</div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="profile-widget-description">
                                    <div class="profile-widget-name">{{identidad[1]}} {{identidad[2]}}, {{identidad[3]}} 
                                      <div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> {{identidad[0]}}</div></div>
                                  
                                  </div>
                                  
                                </div>

                                <div class="row" ng-hide="Detalle_T === undefined">
                                      <div class="col-12">
                                        <div class="activities">
                                            <div ng-show="load_dt" style="padding-left: 45%">
                                              <img src="dist/img/spinner.svg" alt="">
                                            </div>
                                            <div style="padding-left: 35%">
                                                <div ng-show="error2" class="badge badge-danger mb-0">
                                                    No encontrado
                                                  </div>
                                            </div>
                                           
                                          
                                          <div ng-show="!load_dt" class="activity" ng-repeat="titulosall in Detalle_T.Detalle_T">
                                            <div class="activity-icon bg-primary text-white shadow-primary">
                                              <i class="fas fa-graduation-cap"></i>
                                            </div>
                                            
                                            <div class="activity-detail">
                                              <div class="mb-2">
                                               
                                                <span class="bullet"></span>
                                                <a class="text-job" href="#">{{titulosall.I_Nombre}}</a>
                                                <div class="float-right dropdown">
                                                  <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                                  <div class="dropdown-menu">
                                                    <div class="dropdown-title">Options</div>
                                                    <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                                    <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a href="#" class="dropdown-item has-icon text-danger" data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?" data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i> Archive</a>
                                                  </div>
                                                </div>
                                              </div>
                                              <p>
                                                <div class="badge badge-warning ">Carrera:</div>
                                                <br>
                                                <div class="Detalles_paddingleft">{{titulosall.DIT_Carrera}}</div>
                                              </p>
                                              <span class="">                                             
                                              <div class="badge badge-info">Fecha de titulación:</div>
                                              <br>
                                              <div class="Detalles_paddingleft">30/05/18</div>
                                            </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                      
                    






<!-- Main Content -->

    
     
      
    
      
           
           
              
           
     
    

 


             
    </body>

    <!-- js -->
    <script src="dist/modules/jquery.min.js"></script>
    <script src="dist/modules/popper.js"></script>
    <script src="dist/modules/tooltip.js"></script>
    <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/modules/prism/prism.js"></script>
    <script src="dist/modules/moment.min.js"></script>
    <script src="dist/js/stisla.js"></script>

    <script src="dist/modules/owlcarousel2/owl.carousel.min.js"></script>
     <!-- Page Specific JS File -->
    <script src="js/js_edit.js"></script>


    <script src="landing/script.js"></script>

    <script>
        $("#my-button2").fireModal({
  title: 'Resultados',
  body: '<p>Verificando....</p>',
  created: function(modal) {
      console.log('Modal has been created');
  },
  buttons: [
    {
      text: 'Cerrar',
      class: 'btn btn-primary btn-shadow',
      handler: function(modal) {
       
      }
    }
  ]
});
    </script>
</body>
</html>