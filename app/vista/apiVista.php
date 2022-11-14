<?php

class ApiVista
{

    public function response($data, $status = 200) {//doy la rta 200 en caso de que no se envien parámetros, por defecto
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        
        // convierte los datos a un formato json
        echo json_encode($data);
    }


//te devuelve texto asociado al códido de rta.
    private function _requestStatus($code){
        $status = array(
          200 => "OK",
          201 => "Created",
          400 => "Bad request",
          404 => "Not found",
          500 => "Internal Server Error"
        );
        return (isset($status[$code])) ? $status[$code] : $status[500];
      }
}
