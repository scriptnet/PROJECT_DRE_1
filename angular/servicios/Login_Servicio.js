var app = angular.module('DREETTP.LoginService',[]);

app.factory('loginService', ['$http','$q', function($http, $q){

    var self = {
        login: function ( datos ){
            var d = $q.defer();
            $http.post('consultas/post.verificar.php', datos)
                .success(function(data){
                    console.log(data);
                d.resolve( data );
                    
                });
            return d.promise;
        }
    };

    return self;
}])
