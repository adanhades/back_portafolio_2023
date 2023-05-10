<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }

        parent::__construct();
        // Cargamos el modelo
        $this->load->model('UsuariosModel');
        $data = $this->input->post(NULL, TRUE);
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

    // Método que permite al administrador agregar un usuario
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
        $response = null;
        if ($this->UsuariosModel->verificarSession($token) && $this->UsuariosModel->verificarPerfil('Administrador')) {
            $usuarioId = $this->UsuariosModel->insertarUsuario($nombres, $apellidos, $rut, $dvrut, $logintoken, $telefono, $password, $email, $username);
            $response = array(
                "ok" => true,
                "status" => "success",
                "message" => "usuario agregado",
                "data" => array("idusuario" => $usuarioId)
            );
        } else {
            $response = array(
                "ok" => false,
                "status" => "invalid",
                "message" => "Sessión o perfil inválido"
            );
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
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
        $response = null;
        if ($this->UsuariosModel->verificarSession($token) && $this->UsuariosModel->verificarPerfil('Administrador')) {
            $result = $this->UsuariosModel->actualizarUsuario($id, $nombres, $apellidos, $rut, $dvrut, $telefono, $password, $email, $username);
            $response = array(
                "ok" => true,
                "status" => "success",
                "message" => "usuario modificado",
                "data" => array("filasafectadas" => $result, "id_usuario" => $id)
            );
        } else {
            $response = array(
                "ok" => false,
                "status" => "invalid",
                "message" => "Sessión o perfil inválido"
            );
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function eliminarUsuario() {
        // Obtenemos los datos del usuario a eliminar
        $usuarioId = $this->input->post('id');
        $token = $this->input->post('token');
        $response = null;
        if ($this->UsuariosModel->verificarSession($token) && $this->UsuariosModel->verificarPerfil('Administrador')) {
            $result = $this->UsuariosModel->eliminarUsuario($usuarioId);
            $response = array(
                "ok" => true,
                "status" => "success",
                "message" => "usuario eliminado",
                "data" => array("filasafectadas" => $result, "id_usuario" => $usuarioId)
            );
        } else {
            $response = array(
                "ok" => false,
                "status" => "invalid",
                "message" => "Sessión o perfil inválido"
            );
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function listarUsuarios() {
        // Obtenemos el token de acceso
        $token = $this->input->post('token');
        if ($this->UsuariosModel->verificarSession($token)) {
            $result = $this->UsuariosModel->obtenerTodosUsuarios();
            $response = array(
                "ok" => true,
                "status" => "success",
                "message" => "listado de usuarios",
                "data" => array("usuarios" => $result)
            );
        } else {
            $response = array(
                "ok" => false,
                "status" => "invalid",
                "message" => "Sessión o perfil inválido"
            );
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
 
    }

}
