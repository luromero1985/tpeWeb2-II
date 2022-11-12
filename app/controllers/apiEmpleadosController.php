<?php
require_once './app/modelo/modeloEmpleado.php';
require_once './app/vista/apiVista.php';



class ApiEmpleadosController
{
    private $modelo;
    private $vista;
    // $data trae el string del body de Postman
    private $data;


    function __construct()
    {
        $this->modelo = new ModeloEmpleado();
        $this->vista = new ApiVista();
        // lee el body del request que usamos en postman, lee texto plano (raw)
        $this->data = file_get_contents("php://input");
    }

    //con esta función convierto texto plano (raw) en json
    private function getData()
    {
        return json_decode($this->data);
    }

    private function validate($column, $orderBy, $order, $limit, $page)
    {
        $columns = [
            "id" => "id",
            "nombre" => "nombre",
            "dni" => "dni",
            "celular" => "celular",
            "mail" => "mail",
            "id_categoria_fk" => "puesto"
        ];
        /*
        *haago los controles
        *pruebo que la columna esté seteada, que esté en minuscula y esté dentro del arreglo de columnas.
         */

        if ((isset($column)) && (!in_array(strtolower($column), $columns))) {
            $this->vista->response("la columna buscada no existe", 400);
            die();
        }


        //ruebo que orderBy esté seteada, que esté en minuscula y esté dentro del arreglo de columnas.

        if ((isset($orderBy)) && (!in_array(strtolower($orderBy), $columns))) {
            $this->vista->response("No es posible ordenar de la forma indicada", 400);
            die();
        }


        //pruebo que order esté seteada, que esté en minuscula y esté dentro del arreglo de tipo de orden.

        $typeOrders = ["asc", "desc"];
        if ((isset($order)) && (!in_array(strtolower($order), $typeOrders))) {
            $this->vista->response("No existe la forma de ordenamiento indicada", 400);
            die();
        }


        //pruebo que page esté seteada, que sea numérico y mayor que cero.

        if ((isset($page)) && ((!is_numeric($page)) || ($page < 0))) {
            $this->vista->response("No existe el número de página solicitado", 400);
            die();
        }


        //controlo que limit esté seteado, que sea numérico y mayor o igual a cero
        if ((isset($limit)) && ((!is_numeric($limit)) || ($limit <= 0))) {
            $this->vista->response("El límite indicado no es posible", 400);
            die();
        }
    }

    //traigo la lista de todos los empleados
    public function getAll($params = null)
    {
        $orderBy = $_GET["orderBy"] ?? null;
        $order = $_GET["order"] ?? null;
        $limit = $_GET["limit"] ?? null;
        $page =  $_GET["page"] ?? null;
        $column =  $_GET["column"] ?? null;
        $filtervalue = $_GET["filtervalue"] ?? null;

        //valido los $_Get[]
        $this->validate($column, $orderBy, $order, $limit, $page);

        $empleados = $this->modelo->getAll($column, $filtervalue, $orderBy, $order, $limit, $page);
       
       if ($empleados){
        return $this->vista->response($empleados, 200);
        } else{
            $this->vista->response("No es posible hacer esa búsqueda", 404);
        }
    }




    //traigo un empleado
    public function get($params = null)
    {
        $id = $params[':ID'];
        $empleado = $this->modelo->get($id);
        if (!empty($empleado)) {
            $this->vista->response($empleado);
        } else
            $this->vista->response("Empleado id=$id not found", 404);
    }



    public function delete($params = null)
    {
        $id = $params[':ID'];

        $empleado = $this->modelo->get($id);
        if ($empleado) {
            $empleado = $this->modelo->delete($id);
            $this->vista->response("Empleado id=$id remove successfuly");
        } else {
            $this->vista->response("Empleado id=$id not found", 404);
        }
    }

    //agrego un empleado

    public function insert($params = null)
    {
        $empleado = $this->getData();

 
     if (empty($empleado->nombre) || empty($empleado->dni) || empty($empleado->celular) || empty($empleado->mail) || empty($empleado->id_categoria_fk)) {
         $this->vista->response("Complete todos los datos", 400);

       } else {
    
      if (empty($this->modelo->getByDni($empleado->dni))) {
                $nuevoEmpleado = $this->modelo->insert($empleado->nombre, $empleado->dni, $empleado->celular, $empleado->mail, $empleado->id_categoria_fk);
                $empleadoIngresado = $this->modelo->get($nuevoEmpleado);
                $this->vista->response($empleadoIngresado, 201);

          } else {
               $this->vista->response("El dni ingresado ya está registrado en el sistema", 400);
           }
        
    }
}

    //edito un empleado

    public function upDate($params = null)
    {
        $id = $params[':ID'];
        $empleado = $this->modelo->get($id);

        if ($empleado) {
            $empleado = $this->getData();
            $this->modelo->editar($id, $empleado->nombre, $empleado->dni, $empleado->celular, $empleado->mail, $empleado->id_categoria_fk);
            $empleadoEditado = $this->modelo->get($id);
           
            $this->vista->response($empleadoEditado, 201);
        } else {
            $this->vista->response("Empleado id=$id not found", 404);
        }
    }
}

//http://localhost/proyectos/tpeWeb2-II/api/empleados
//http://localhost/proyectos/tpeWeb2-II/api/empleados?column=nombre&filtervalue=Luana Valenzuela

/*filtro orden por nombre
http://localhost/proyectos/tpeWeb2-II/api/empleados?orderBy=nombre&order=asc
*/

/*filtro orden por dni
http://localhost/proyectos/tpeWeb2-II/api/empleados?orderBy=dni&order=asc
*/


/*filtro por paginado
http://localhost/proyectos/tpeWeb2-II/api/empleados?page=10&limit=20
*/

/*
http://localhost/proyectos/tpeWeb2-II/api/empleados?column=nombre&filtervalue=Lu&orderBy=nombre&order=desc
*/


/*
  para insertar o editar un empleado uso la fk
     {
        "nombre": "Amya Payes",
        "dni": 31701220,
        "celular": "2494026102",
        "mail": "ami@gmail.com",
        "id_categoria_fk": 3
    }
 */