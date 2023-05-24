<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductosController extends CI_Controller {

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
        $this->load->model('CategoriaProductoModel');
        $this->load->model('ProductosModel');
    }

    // Método que permite al administrador agregar un usuario
    public function obtenerProductos() {
        // Obtener el token y el estatus de la solicitud
        $token = $this->input->post('token');
        $estatus = $this->input->post('estado_producto');

        // Llamar a la función obtenerProductos del modelo
        $response = $this->ProductosModel->obtenerProductos($token, $estatus);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function actualizarProducto() {
        // Obtener los datos del producto a actualizar
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $marca = $this->input->post('marca');
        $link_imagen = $this->input->post('link_imagen');
        $id_categoria = $this->input->post('id_categoria');
        $token = $this->input->post('token');

        $response = $this->ProductosModel->actualizarProducto($token, $id, $nombre, $marca, $link_imagen, $id_categoria);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function insertarProducto() {
        // Obtener los datos del producto a insertar
        $nombre = $this->input->post('nombre');
        $marca = $this->input->post('marca');
        $link_imagen = $this->input->post('link_imagen');
        $id_categoria = $this->input->post('id_categoria');
        $token = $this->input->post('token');

        // Llamar a la función insertarProducto del modelo
        $response = $this->ProductosModel->insertarProducto($token, $nombre, $marca, $link_imagen, $id_categoria);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function activarProducto() {
        // Obtener el ID del producto a activar
        $id = $this->input->post('id');
        $token = $this->input->post('token');

        // Llamar a la función activarProducto del modelo
        $response = $this->ProductosModel->activarProducto($token, $id);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function desactivarProducto() {
        // Obtener el ID del producto a desactivar
        $id = $this->input->post('id');
        $token = $this->input->post('token');

        // Llamar a la función desactivarProducto del modelo
        $response = $this->ProductosModel->desactivarProducto($token, $id);

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function obtenerProductosPorCategoria() {
        // Obtener los parámetros de la solicitud
        $token = $this->input->post('token');
        $id_categoria = $this->input->post('id_categoria');
        $estatus = $this->input->post('estado_producto');

        // Llamar al modelo para obtener los productos por categoría
        $response = $this->ProductosModel->obtenerProductosPorCategoria($token, $id_categoria, $estatus);

        // Devolver la respuesta como JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function obtenerProductoPorId() {
        $token = $this->input->post('token');
        $id_producto = $this->input->post('id');

        $response = $this->ProductosModel->obtenerProductoPorId($token, $id_producto);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function getCategorias() {
        $token = $this->input->post('token');
        $response = $this->ProductosModel->getCategorias($token);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    //getMarcas

    public function getMarcas() {
        $token = $this->input->post('token');
        $response = $this->ProductosModel->getMarcas($token);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

}
