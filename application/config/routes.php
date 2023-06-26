<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['translate_uri_dashes'] = FALSE;
//todo lo relevante a usuarios
$route['autorizar'] = 'AutenticacionController/autenticar';
$route['validar-session'] = 'AutenticacionController/validarSession';
$route['agregar-usuario'] = 'UsuariosController/agregarUsuario';
$route['modificar-usuario'] = 'UsuariosController/modificarUsuario';
$route['eliminar-usuario'] = 'UsuariosController/eliminarUsuario';
$route['listar-usuarios'] = 'UsuariosController/listarUsuarios';
$route['asignar-perfil'] = 'UsuariosController/asignarPerfilUsuario';
$route['desasignar-perfil'] = "UsuariosController/eliminarPerfilUsuario";
$route['listado-perfiles'] = "UsuariosController/getTodosPerfiles";
$route['perfiles-usuario'] = "UsuariosController/getPerfilesUsuario";
$route['perfiles-actual-usuario'] = "UsuariosController/perfilesActualUsuario";
$route['restaurar-usuario'] = "UsuariosController/restaurarUsuario";
$route['datos-usuario'] = "UsuariosController/getDatosUsuario";

// todo lo relevante a productos
$route['listar-categorias'] = "ProductosController/getCategorias";
$route['agregar-categoria'] = "ProductosController/insertarCategoria";
//modificarCategoria
$route['modificar-categoria'] = "ProductosController/modificarCategoria";

// clientes
$route['agregar-cliente'] = "ClientesController/agregarCliente";
//autenticarCliente
$route['autenticar-cliente'] = "ClientesController/autenticarCliente";
$route['actualizar-cliente'] = "ClientesController/actualizarCliente";
$route['activar-cliente'] = "ClientesController/activarCliente";
$route['desactivar-cliente'] = "ClientesController/desactivarCliente";
$route['obtener-clientes'] = "ClientesController/obtenerClientes";
//getDatosUsuario
$route['datos-cliente'] = "ClientesController/getDatosCliente";

$route['obtener-productos'] = "ProductosController/obtenerProductos";
$route['obtener-productos-por-categoria'] = "ProductosController/obtenerProductosPorCategoria";
$route['insertar-producto'] = "ProductosController/insertarProducto";
$route['actualizar-producto'] = "ProductosController/actualizarProducto";
$route['activar-producto'] = "ProductosController/activarProducto";
$route['desactivar-producto'] = "ProductosController/desactivarProducto";
//obtenerProductoPorId
$route['obtener-producto-por-id'] = "ProductosController/obtenerProductoPorId";

$route['listar-categorias'] = 'ProductosController/getCategorias';
//getMarcas
$route['listar-marcas'] = 'ProductosController/getMarcas';


/// preparaciones
$route['obtener-preparaciones'] = "PreparacionesController/obtenerPreparaciones";
$route['insertar-preparacion'] = "PreparacionesController/insertarPreparacion";
$route['actualizar-preparacion'] = "PreparacionesController/actualizarPreparacion";
$route['activar-preparacion'] = "PreparacionesController/activarPreparacion";
$route['desactivar-preparacion'] = "PreparacionesController/desactivarPreparacion";
$route['obtener-preparaciones-con-relacion'] = 'PreparacionesController/obtenerPreparacionesConRelacion'; 
$route['obtener-menu'] = 'PreparacionesController/getMenu'; 
$route['set-producto-preparacion'] = 'PreparacionesController/relacionProductoPreparacion';
$route['unset-producto-preparacion'] = 'PreparacionesController/unsetrelacionProductoPreparacion';
$route['obtener-productos-preparacion'] = 'PreparacionesController/obtenerProductosPreparacion';
//activarRelPreparacion
$route['activar-producto-preparacion'] = 'PreparacionesController/activarRelPreparacion';
$route['desactivar-producto-preparacion'] = 'PreparacionesController/desactivarRelPreparacion';



