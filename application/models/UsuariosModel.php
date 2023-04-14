<?php

class UsuariosModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function verificarUsuario($email, $password) {
        $arraySearch = array('email' => $email, 'password' => $password);
        $resultadoAuth = $this->db->get_where('usuarios', $arraySearch)->row(0);
        $retorno = array();
        if ($resultadoAuth == null) {
            return array('error' => 'Usuario o contraseña incorrectos');
        } else {
            $perfiles = $this->db->query('select perfiles.* from perfiles join usuarios_perfiles on usuarios_perfiles.perfiles_id = perfiles.id where usuarios_id = ' . $resultadoAuth->id);
            return array('perfiles' => $perfiles->result(), 'usuario' => $resultadoAuth);
        }
    }

    public function insertarUsuario($nombres, $apellidos, $rut, $dvrut, $logintoken, $telefono, $password, $email, $username) {
        $data = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'rut' => $rut,
            'dvrut' => $dvrut,
            'logintoken' => $this->generarToken(),
            'telefono' => $telefono,
            'password' => $password,
            'email' => $email,
            'username' => $username
        );
        $this->db->insert('usuarios', $data);
        return $this->db->insert_id();
    }

    public function eliminarUsuario($id) {
        $this->db->where('id', $id);
        $this->db->delete('usuarios');
        return $this->db->affected_rows();
    }

    public function actualizarUsuario($id, $nombres, $apellidos, $rut, $dvrut, $telefono, $password, $email, $username) {
        $data = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'rut' => $rut,
            'dvrut' => $dvrut,
            'telefono' => $telefono,
            'password' => $password,
            'email' => $email,
            'username' => $username
        );
        $this->db->where('id', $id);
        $this->db->update('usuarios', $data);
        return $this->db->affected_rows();
    }

    public function obtenerUsuarioPorId($id) {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function obtenerTodosUsuarios() {
        $this->db->select('*');
        $this->db->from('usuarios');
        $query = $this->db->get();
        return $query->result();
    }

    public function asignarPerfilAUsuario($usuario_id, $perfil_id) {
        $data = array(
            'usuarios_id' => $usuario_id,
            'perfiles_id' => $perfil_id
        );

        $this->db->insert('usuarios_perfiles', $data);
    }

    public function eliminarPerfilDeUsuario($usuario_id, $perfil_id) {
        $this->db->where('usuarios_id', $usuario_id);
        $this->db->where('perfiles_id', $perfil_id);
        $this->db->delete('usuarios_perfiles');
    }

    public function obtenerPerfilesPorToken($token) {
        $this->db->select('p.*');
        $this->db->from('usuarios u');
        $this->db->join('usuarios_perfiles up', 'u.id = up.usuarios_id');
        $this->db->join('perfiles p', 'up.perfiles_id = p.id');
        $this->db->where('u.logintoken', $token);
        $query = $this->db->get();
        return $query->result();
    }

    public function modificarTokenUsuario($usuarioId) {
        $logintoken = $this->generarToken();
        $data = array('logintoken' => $logintoken);
        $this->db->where('id', $usuarioId);
        $this->db->update('usuarios', $data);
    }

    public function generarToken() {
        return bin2hex(random_bytes(16). uniqid('token'));
    }

}
