<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cargamos el modelo
        $this->load->model('UsuariosModel');
		$data = $this->input->post(NULL,TRUE);

    }

    public function index() {
        // Obtenemos el token desde el POST
        $token = $this->input->post('token');

        // Validamos si el usuario tiene el perfil de administrador
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);
        $es_admin = false;
        foreach ($perfiles as $perfil) {
            if ($perfil->nombre === 'Administrador') {
                $es_admin = true;
                return;
            }
        }

        if (!$es_admin) {
            // Si el usuario no es administrador, lanzamos un error 401
            $this->output->set_status_header(401);
            echo json_encode(array('error' => 'No autorizado'));
            return;
        }

        // Si el usuario es administrador, procesamos la petición
        // Implementar aquí el código para la función deseada
    }

    public function agregarUsuario() {
        // Obtenemos los datos del usuario a agregar
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $rut = $this->input->post('rut');
        $dvrut = $this->input->post('dvrut');
        $logintoken = '';
        $telefono = $this->input->post('telefono');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $token = $this->input->post('token');

        // Validamos el token
        $this->load->model('UsuariosModel');
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);
        $adminEncontrado = false;
        foreach ($perfiles as $perfil) {
            if ($perfil->nombre === 'Administrador') {
                $adminEncontrado = true;
                break;
            }
        }
        if (!$adminEncontrado) {
            $resultado = array('error' => 'Acceso denegado. Solo los administradores pueden agregar usuarios.');
            echo json_encode($resultado);
            return;
        } else {
            // Insertamos el usuario
            $this->load->model('UsuariosModel');
            $usuarioId = $this->UsuariosModel->insertarUsuario($nombres, $apellidos, $rut, $dvrut, $logintoken, $telefono, $password, $email, $username);

            // Respondemos con el id del usuario insertado
            $resultado = array('id' => $usuarioId);
            echo json_encode($resultado);
        }
    }

    public function eliminarUsuario() {
        // Obtenemos los datos del usuario a eliminar
        $usuarioId = $this->input->post('id');
        $token = $this->input->post('token');

        // Validamos el token
        $this->load->model('UsuariosModel');
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);
        $adminEncontrado = false;
        foreach ($perfiles as $perfil) {
            if ($perfil->nombre === 'Administrador') {
                $adminEncontrado = true;
                break;
            }
        }
        if (!$adminEncontrado) {
            $resultado = array('error' => 'Acceso denegado. Solo los administradores pueden eliminar usuarios.');
            echo json_encode($resultado);
            return;
        }

        // Validamos que el usuario no se esté eliminando a sí mismo
        $usuarioActual = $this->UsuariosModel->obtenerUsuarioPorToken($token);
        if ($usuarioActual->id === $usuarioId) {
            $resultado = array('error' => 'No es posible eliminarse a sí mismo.');
            echo json_encode($resultado);
            return;
        }

        // Eliminamos el usuario
        $filasAfectadas = $this->UsuariosModel->eliminarUsuario($usuarioId);

        // Respondemos con la cantidad de filas afectadas
        $resultado = array('filas_afectadas' => $filasAfectadas);
        echo json_encode($resultado);
    }

    public function obtenerPerfilesPorToken() {
        // Obtener token de entrada
        $token = $this->input->post('token');

        // Cargar modelo de usuarios
        $this->load->model('UsuariosModel');

        // Obtener perfiles del usuario por token
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);

        // Si no se encontraron perfiles, responder con un mensaje de error
        if (!$perfiles) {
            $resultado = array('error' => 'No se encontraron perfiles para el token proporcionado.');
            echo json_encode($resultado);
            return;
        }

        // Responder con los perfiles del usuario
        $resultado = array();
        foreach ($perfiles as $perfil) {
            $resultado[] = array(
                'id' => $perfil->id,
                'nombre' => $perfil->nombre
            );
        }
        echo json_encode($resultado);
    }

    public function modificarUsuario() {
        // Obtener los datos del usuario a modificar
        $id = $this->input->post('id');
        $nombres = $this->input->post('nombres');
        $apellidos = $this->input->post('apellidos');
        $rut = $this->input->post('rut');
        $dvrut = $this->input->post('dvrut');
        $telefono = $this->input->post('telefono');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        $token = $this->input->post('token');

        // Validar el token y obtener los perfiles del usuario
        $this->load->model('UsuariosModel');
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);
        $usuario = $this->UsuariosModel->obtenerUsuarioPorId($id);

        // Verificar si el usuario puede modificar su propio perfil
        $puedeModificar = false;
        foreach ($perfiles as $perfil) {
            if ($perfil->nombre === 'Administrador') {
                $puedeModificar = true;
                break;
            }
        }

        // Si el usuario no tiene permiso para modificar, enviar un error
        if (!$puedeModificar) {
            $resultado = array('error' => 'Acceso denegado. Solo los administradores y el propio usuario pueden modificar un perfil.');
            echo json_encode($resultado);
            return;
        }

        // Modificar el usuario
        $this->UsuariosModel->actualizarUsuario($id, $nombres, $apellidos, $rut, $dvrut, $telefono, $password, $email, $username);

        // Responder con el éxito de la operación
        $resultado = array('exito' => true);
        echo json_encode($resultado);
    }

    public function modificarToken() {
        $usuarioId = $this->input->post('usuario_id');
        $token = $this->input->post('token');

        // Validamos el token
        $this->load->model('UsuariosModel');
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);
        $adminEncontrado = false;
        foreach ($perfiles as $perfil) {
            if ($perfil->nombre === 'Administrador') {
                $adminEncontrado = true;
                break;
            }
        }
        if (!$adminEncontrado) {
            $resultado = array('error' => 'Acceso denegado. Solo los administradores pueden modificar tokens de usuario.');
            echo json_encode($resultado);
            return;
        }

        // Modificamos el token del usuario
        $this->UsuariosModel->modificarTokenUsuario($usuarioId);

        $resultado = array('success' => 'Token modificado correctamente.');
        echo json_encode($resultado);
    }

    public function listarUsuarios() {
        // Obtenemos el token de acceso
        $token = $this->input->post('token');

        // Validamos el token
        $this->load->model('UsuariosModel');
        $perfiles = $this->UsuariosModel->obtenerPerfilesPorToken($token);
        $adminEncontrado = false;
        foreach ($perfiles as $perfil) {
            if ($perfil->nombre === 'Administrador') {
                $adminEncontrado = true;
                break;
            }
        }
        if (!$adminEncontrado) {
            $resultado = array('error' => 'Acceso denegado. Solo los administradores pueden obtener todos los usuarios.');
            echo json_encode($resultado);
            return;
        } else {
            // Obtenemos todos los usuarios
            $usuarios = $this->UsuariosModel->obtenerTodosUsuarios();

            // Respondemos con los usuarios obtenidos
            echo json_encode($usuarios);
        }
    }

}
