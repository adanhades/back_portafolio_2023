<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PreparacionesController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cargamos el modelo
        $this->load->model('UsuariosModel');
        $this->load->model('CategoriaProductoModel');
        $this->load->model('ProductosModel');
        $this->load->model('PreparacionesModel');
    }

    // Método que permite al administrador agregar un usuario
    public function obtenerPreparaciones() {
        // Obtener el token y el estado de la preparación
        $token = $this->input->post('token');
        $estadoPreparacion = $this->input->post('estado_preparacion');

        // Llamar a la función obtenerPreparaciones del modelo
        $response = $this->PreparacionesModel->obtenerPreparaciones($token, $estadoPreparacion);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function insertarPreparacion() {
        // Obtener los datos enviados en la solicitud
        $token = $this->input->post('token');
        $nombre = $this->input->post('nombre');
        $precio = $this->input->post('precio');
        $descripcion = $this->input->post('descripcion');
        $categoria = $this->input->post('categoria');

        // Llamar a la función insertarPreparacion del modelo
        $response = $this->PreparacionesModel->insertarPreparacion($token, $nombre, $descripcion, $precio, $categoria);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function actualizarPreparacion() {
        // Obtener los datos enviados en la solicitud
        $token = $this->input->post('token');
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $precio = $this->input->post('precio');
        $categoria = $this->input->post('categoria');
        $descripcion = $this->input->post('descripcion');

        // Llamar a la función actualizarPreparacion del modelo
        $response = $this->PreparacionesModel->actualizarPreparacion($token, $id, $nombre, $precio, $descripcion, $categoria);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function activarPreparacion() {
        // Obtener los datos enviados en la solicitud
        $token = $this->input->post('token');
        $id = $this->input->post('id');

        // Llamar a la función activarPreparacion del modelo
        $response = $this->PreparacionesModel->activarPreparacion($token, $id);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function desactivarPreparacion() {
        // Obtener los datos enviados en la solicitud
        $token = $this->input->post('token');
        $id = $this->input->post('id');

        // Llamar a la función activarPreparacion del modelo
        $response = $this->PreparacionesModel->desactivarPreparacion($token, $id);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function relacionProductoPreparacion() {
        // Obtener los datos enviados en la solicitud
        $token = $this->input->post('token');
        $idProducto = $this->input->post('id_producto');
        $idPreparacion = $this->input->post('id_preparacion');

        // Llamar a la función relacionProductoPreparacion del modelo
        $response = $this->PreparacionesModel->relacionProductoPreparacion($token, $idProducto, $idPreparacion);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function obtenerPreparacionesConRelacion() {
        // Obtener el token
        $token = $this->input->post('token');

        // Llamar a la función obtenerProductosConRelacion del controlador
        $response = $this->PreparacionesModel->obtenerProductosConRelacion($token);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function getMenu() {
        // Obtener el token
        $token = $this->input->post('token');

        // Llamar a la función obtenerProductosConRelacion del controlador
        $response = $this->PreparacionesModel->obtenerMenu($token);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function obtenerProductosPreparacion() {
        // Obtener el token
        $token = $this->input->post('token');
        $idPreparacion = $this->input->post('id_preparacion');
        // Llamar a la función obtenerProductosConRelacion del controlador
        $response = $this->PreparacionesModel->obtenerProductosDePreparacion($token, $idPreparacion);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }
    
    public function activarRelPreparacion(){
                // Obtener el token
        $token = $this->input->post('token');
        $idPreparacion = $this->input->post('id');
        // Llamar a la función obtenerProductosConRelacion del controlador
        $response = $this->PreparacionesModel->activarRelPreparacion($token, $idPreparacion);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }
    
    public function desactivarRelPreparacion(){
                // Obtener el token
        $token = $this->input->post('token');
        $idPreparacion = $this->input->post('id');
        // Llamar a la función obtenerProductosConRelacion del controlador
        $response = $this->PreparacionesModel->desactivarRelPreparacion($token, $idPreparacion);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

}
