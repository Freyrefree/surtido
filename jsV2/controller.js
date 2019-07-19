angular.module("mainTablero",[])
.controller("controllerTablero", function($scope, $http){
    $scope.tableros = [];
    $scope.actividades = [];
    $scope.tareas = [];
    $scope.mas = false;
    $scope.idActividad = 0;
    $scope.idTablero = 0;
    $scope.tituloTablero = 0;
    poblarTablero();
    function poblarTablero(){
        $http.get("http://192.168.1.99:81/AppTeam/listarTableros.php")
        .then(function(answer){
            console.log(answer);
            $scope.tableros = answer.data;
        });
    }
    
    $scope.addActv = function(){
        var request = $http({
            method: "post",
            url: "http://192.168.1.99:81/AppTeam/actions.php",//window.location.href + 
            data: {
                titulo: $scope.newActv.titulo,
                descripcion: $scope.newActv.descripcion
            },
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        });
        request.then(function (datos) {
            poblarTablero();
            console.log(datos);//temp
            $scope.newActv = {};
        });
        // $scope.tableros.push($scope.newActv);
        // $scope.newActv = {};
    }
    function poblarActividades(id){
        $http.get("http://192.168.1.99:81/AppTeam/listarActividades.php?id=" + id)
        .then(function(answer){
            console.log(answer);
            $scope.actividades = answer.data;
        });
    }
    $scope.vermas = function(id, tablero){
        $scope.tituloTablero = tablero;
        $scope.idTablero = id;
        $scope.mas = true;
        console.log(id);
        poblarActividades(id);
    }
    $scope.addActivity = function(){
        var request = $http({
            method: "post",
            url: "http://192.168.1.99:81/AppTeam/actionActividades.php",

            data: {
                idtablero: $scope.idTablero,
                nombre: $scope.newActivity.nombre
            },
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        });
        request.then(function (datos) {
            poblarActividades(datos.data);
            console.log(datos.data);//temp
            $scope.newActivity = {};
            $scope.idtablero = datos.data;
        });
    }
    function poblarTareas(id){
        $http.get("http://192.168.1.99:81/AppTeam/listarTareas.php?id=" + id)
        .then(function(answer){
            console.log(answer);
            $scope.tareas = answer.data;
            $scope.idActividad = id;
        });
    }
    $scope.vertareas = function(id){
        console.log(id);
        poblarTareas(id);
    }

    $scope.addTask = function(){
        
            var request = $http({
                method: "post",
                url: "http://192.168.1.99:81/AppTeam/actionTareas.php",
                
                data: {
                    idactividad: $scope.idActividad,
                    descripcion: $scope.newTask.descripcion
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            });
            request.then(function (datos) {
                poblarTareas(datos.data);
                console.log(datos.data);//temp
                $scope.newTask = {};
                $scope.idActividad = datos.data;
                document.getElementById("idTarea").focus();//el idTarea es solo para aplicar el focus
            });     
        // $scope.tableros.push($scope.newActv);
        // $scope.newActv = {};
    }
    $scope.muestraTableros = function(){
        $scope.idActividad = null;
        $scope.idTablero = null;
        $scope.mas = false;
        $scope.newActv = {};
        $scope.newActivity = {};
        $scope.newTask = {};
    }
    $scope.completeTask = function(){
        alert("Tarea terminada");
    }
});
//actionActividades.php
//http://jsonplaceholder.typicode.com/posts