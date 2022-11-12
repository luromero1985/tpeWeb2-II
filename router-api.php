<?php
require_once 'libreria/Router.php';
require_once 'app/controllers/apiEmpleadosController.php';

//creo el router

$router= new Router();

//tabla de ruteo

$router-> addRoute('empleados', 'GET', 'apiEmpleadosController', 'getAll');
$router-> addRoute('empleados/:ID', 'GET', 'apiEmpleadosController', 'get');
$router-> addRoute('empleados/:ID', 'DELETE', 'apiEmpleadosController', 'delete');
$router-> addRoute('empleados', 'POST', 'apiEmpleadosController', 'insert');
$router-> addRoute('empleados/:ID', 'PUT', 'apiEmpleadosController', 'upDate');


//hago la acción de rutear

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
?>