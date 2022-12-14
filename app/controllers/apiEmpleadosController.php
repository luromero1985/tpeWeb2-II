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


        //pruebo que orderBy esté seteada, que esté en minuscula y esté dentro del arreglo de columnas.

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
        try {
            $orderBy = $_GET["orderBy"] ?? "nombre";
            $order = $_GET["order"] ?? "asc";
            $limit = $_GET["limit"] ?? 10;
            $page =  $_GET["page"] ?? 1;
            $column =  $_GET["column"] ?? null;
            $filtervalue = $_GET["filtervalue"] ?? null;

            //valido los $_Get[]
            $this->validate($column, $orderBy, $order, $limit, $page);

            $empleados = $this->modelo->getAll($column, $filtervalue, $orderBy, $order, $limit, $page);

            //traigo la lista de empleados que responden a la busqueda de la request
            if ($empleados) {
                return $this->vista->response($empleados, 200);
                
            } else {
            $this->vista->response("En la base de datos, no hay empleados que respondan a su búsqueda", 204);
            $this->vista->response("Si desea, realice una nueva búsqueda", 205);
            }
        } catch (Exception $e) {
            $this->vista->response($e->getMessage(), 500);
        }
    }


    //traigo un empleado
    public function get($params = null)
    {
        try {
            $id = $params[':ID'];
            $empleado = $this->modelo->get($id);
            if (!empty($empleado)) {
                $this->vista->response($empleado);
            } else
                $this->vista->response("Empleado id=$id not found", 404);
        } catch (Exception $e) {
            $this->vista->response($e->getMessage(), 500);
        }
    }



    public function delete($params = null)
    {
        try {
            $id = $params[':ID'];

            $empleado = $this->modelo->get($id);
            if ($empleado) {
                $empleado = $this->modelo->delete($id);
                $this->vista->response("Empleado id=$id remove successfuly");
            } else {
                $this->vista->response("Empleado id=$id not found", 404);
            }
        } catch (Exception $e) {
            $this->vista->response($e->getMessage(), 500);
        }
    }

    //agrego un empleado

    public function insert($params = null)
    {
        try {
            $empleado = $this->getData();
            //controlo que no falte ningún campo
            if (empty($empleado->nombre) || empty($empleado->dni) || empty($empleado->celular) || empty($empleado->mail) || empty($empleado->id_categoria_fk)) {
                $this->vista->response("Complete todos los datos", 400);
            } else {
                //verifico que el dni ingresado no exista en la base de datos
                if (empty($this->modelo->getByDni($empleado->dni))) {

                    //controlo que el dni ingresado sea un número
                    if (!is_numeric($empleado->dni) || (($empleado->dni) < 10)) {
                        $this->vista->response("El dni ingresado no es un valor válido", 400);
                    } else{
                    $nuevoEmpleado = $this->modelo->insert($empleado->nombre, $empleado->dni, $empleado->celular, $empleado->mail, $empleado->id_categoria_fk);
                    $empleadoIngresado = $this->modelo->get($nuevoEmpleado);
                    $this->vista->response($empleadoIngresado, 201);                        
                    }

                } else {
                    $this->vista->response("El dni ingresado ya está registrado en el sistema", 400);
                }
            }
        } catch (Exception $e) {
            $this->vista->response($e->getMessage(), 500);
        }
    }

    //edicion de un empleado

    public function upDate($params = null)
    {
        try {
            $id = $params[':ID'];

            $empleado = $this->modelo->get($id);

            if ($empleado) {
                $empleadoaModificar = $this->getData();

                //controlo que no falte ningun parametro
                if (empty($empleadoaModificar->nombre) || empty($empleadoaModificar->dni) || empty($empleadoaModificar->celular) || empty($empleadoaModificar->mail) || empty($empleadoaModificar->id_categoria_fk)) {
                    $this->vista->response("Complete todos los datos", 400);
                } else {

                    //controlo que el dni no coincida con otro de la base de datos
                    if (($empleado->dni) == ($empleadoaModificar->dni) || empty($this->modelo->getAll("dni", $empleadoaModificar->dni, null, null, null, null))) {

                        //controlo que el dni sea un  valor permitido
                        if (!is_numeric($empleadoaModificar->dni) || (($empleadoaModificar->dni) < 10)) {
                            $this->vista->response("El dni ingresado no es un valor válido", 400);
                        } else { //valido la edición
                            $this->modelo->editar($id, $empleadoaModificar->nombre, $empleadoaModificar->dni, $empleadoaModificar->celular, $empleadoaModificar->mail, $empleadoaModificar->id_categoria_fk);
                            $empleadoEditado = $this->modelo->get($id);

                            $this->vista->response($empleadoEditado, 201);
                        }
                    } else {

                        $this->vista->response("El dni ingresado ya está registrado en el sistema", 400);
                    }
                }
            } else {
                $this->vista->response("Empleado id=$id not found", 404);
            }
        } catch (Exception $e) {
            $this->vista->response($e->getMessage(), 500);
        }
    }
}
