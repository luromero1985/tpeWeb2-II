# Proyecto
Trabajo Practico Especial - Parte 2 - Web 2

## Introducción
Este Proyecto fue creado para la materia Web 2 de la carrera Tecnicatura Universitaria en Desarrollo de Aplicaciones Informáticas (TUDAI) de  la Universidad Nacional del Centro de la Pcia. de Bs. As. (UNICEN). 

## Descripción
El servicio lista los empleados de un servicio de eventos. Permite editar, agregar, eliminar, consultar un empleado o listar a todos. Buscar por filtros de los diferentes campos (nombre, dni, teléfono, mail y/o puesto), paginar y ordenar en forma ascendente o descendente, según el campo elegido. 
La base de datos que utiliza esta API es "dbproyecto.sql"

# API Métodos
La API esta creada según los principios RESTful, para dar seguridad, confianza y eficiencia en el traspaso de datos. 
Usa los métodos del protocolo HTTP:
* GET para acceder a los empleados,
* POST y PUT para agregar o modificar datos,
* DELETE para eliminar
 Usamos el formato JSON para enviar y recibir respuestas en la API.

## Endpoints
El acceso a los recursos de la API es a traves de los endpoints, con los cuales se podrá consultar, editar, agregar, consultar, filtrar, ordenar y paginar los datos de la base de datos "dbproyecto".

 * *http://localhost/proyectos/tpeWeb2-II/api/empleados*
 * *http://localhost/proyectos/tpeWeb2-II/api/empleados/:ID*


| Request | Método | Endpoint | Status |
|---------|-------|-----------|--------|
| Obtener empleados | GET | http://localhost/proyectos/tpeWeb2-II/api/empleados | 200 |
| Obtener empleado | GET | http://localhost/proyectos/tpeWeb2-II/api/empleados/:ID | 200 |
| Crear empleado | POST | http://localhost/proyectos/tpeWeb2-II/api/empleados | 201 |
| Editar empleado | PUT | http://localhost/proyectos/tpeWeb2-II/api/empleados/:ID | 201 |
| Eliminar empleado | DELETE | http://localhost/proyectos/tpeWeb2-II/api/empleados/:ID | 200 |



# Recursos

## GET Empleados
*http://localhost/proyectos/tpeWeb2-II/api/empleados*

Retorna una lista con todos los empleados registrados en la empresa. 

## GET Empleado
*http://localhost/web/tpe2/api/products/:ID*

Retorna el empleado que está registrado en la empresa con el ID indicado en el endpoint.

## POST Crear Empleado
*ttp://localhost/web/tpe2/api/products*

Permite crear un nuevo empleado y guardarlo en la base de datos.
### Formato para crear un empleado
Para cargar a un nuevo empleado usamos la salida en formato JSON. Se escribe en el cuerpo (body) de la solicitud.
**Esquema**:

     {
        "nombre": "Raúl Gómez",
        "dni": 39554117,
        "celular": "249402000",
        "mail": "RaulitoP@gmail.com",
        "id_categoria_fk": 13
    }

## PUT Editar Empleado
*http://localhost/web/tpe2/api/products/:ID*

Permite editar uno o más campos de un empleado que esté registrado en la base de datos, es necesario indicar su ID en el endpoint. 

### Formato para crear un empleado
Para cargar a un nuevo empleado usamos la salida en formato JSON. Se escribe en el cuerpo (body) de la solicitud.
**Esquema**:

     {
        "nombre": "Raúl Gómez",
        "dni": 39554117,
        "celular": "249402000",
        "mail": "RaulitoP@gmail.com",
        "id_categoria_fk": 13
    }


## tabla de equivalencia de fk y puestos
El puesto de trabajo corresponde a la columna "id_categorias_fk" de la tabla de empleados, ésta está vinculada a la columna "id" de la tabla categorías, donde indica el puesto de trabajo. La relación clave-puesto se muestra en la siguiente tabla:  

| Puesto | id_categoria_fk |
|--------|-----------------|	 
| Servicio de cátering | 3 |	         
| Seguridad | 4 |
| Mozo | 7 |	
| Decoración | 8 |        
| Administración | 9 |         
| Limpieza | 11 |
| Sonidista | 13 |
| Iluminación | 15 |     

# Parámetros
Los parámetros de filtrado utilizados son:

* **column**
En este se pueden registrar los campos de búsqueda, nombre, dni, celular, email, puesto (id_categoria_fk).

* **filtervalue**
Es necesario asignarle a la columna alguno de los valores registrados del empleado seleccionado.

* **orderBy**
Selecciona el campo que se quiere ordenar.

* **order**
Puede ser ascendente o desdendente.

* **page**
Muestra la página que se desea observar.

* **limit**
Muestra la cantidad de registros mostrados en la página.

## Parámetros por defecto
En el caso de que se omitan algunos parámetros de consulta, las solicitudes GET devolverán los valores por defecto establecidos.
Valores por defecto:
* orderBy = nombre,
* order = ascendente,
* page = 1,
* limit =10


## Paginación
Para paginar los resultados se deben agregan los parámetros de consulta limit y page a las solicitudes GET:

El siguiente ejemplo, devuelve la página 2 con 3 empleados:

*http://localhost/proyectos/tpeWeb2-II/api/empleados?page=2&limit=3*

**Observación:** si omite el parámetro pedido, la página predeterminada será 1 y el limite 10.

## Orden
Los empleados pueden ordenarse agregando a la consulta los parámetros orderBy (columna por la que se ordena) y order (asc o desc) a las solicitudes GET:

En el siguiente ejemplo se ordena a la lista de empleados por dni y en forma descendente:

*http://localhost/proyectos/tpeWeb2-II/api/empleados?orderBy=dni&order=desc*


**Observación:** si omite el parámetro pedido, el orden predeterminado será por la columna "nombre" y "asc".

## Filtrado
Los empleados pueden devolverse filtados por columna si se agregan parámetros de consulta column (campo por filtrar) y filtervalue (valor de la columna) a la solicitud GET.

En el ejemplo busca en todos los campos que tienen el id de especificacion 13:

En el siguiente ejemplo se filtra por el campo nombre y el atributo Laura:

*http://localhost/proyectos/tpeWeb2-II/api/empleados?column=nombre&filtervalue=Laura*



# Respuestas

La API REST responde a cada solicitud con un código de respuesta HTTP y un mensaje de error. Los códigos utilizados en este proyecto son:


* Códigos de respuesta de error.

| Status | Código de respuesta | 
|--------|-----------------|
| 400 | “Bad request” | 
| 404 | “Not found” | 
| 500 |	“Internal server error” |

* Los códigos de respuesta de confirmación.

| Status | Código de respuesta | 
|--------|-----------------|
| 200 | “Ok” | 
| 201 | “Created” | 
| 204 |	“No content” |