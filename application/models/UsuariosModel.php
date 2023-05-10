<?php

class UsuariosModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function verificarToken() {
        
    }

    public function verificarUsuario($email, $password) {
        $arraySearch = array('email' => $email, 'password' => $password);
        $resultadoAuth = $this->db->get_where('usuarios', $arraySearch)->row(0);
        $retorno = array();
        $token_data = array(
            "email" => $email,
            "userId" => $resultadoAuth->id,
            "userName" => $resultadoAuth->username
        );
        $token = $this->token($token_data);

        if ($resultadoAuth == null) {
            return array('ok' => false, 'status' => 'error', 'message' => 'Usuario o contraseña incorrectos');
        } else {
            $perfiles = $this->db->query('select perfiles.* from perfiles join usuarios_perfiles on usuarios_perfiles.perfiles_id = perfiles.id where usuarios_id = ' . $resultadoAuth->id);
            $this->db->where('id', $resultadoAuth->id)->update('usuarios', array('logintoken' => $token));
            $this->session->token = $token;
            $this->session->idusuario = $resultadoAuth->id;
            $this->session->perfil = $perfiles->result_array();

            $usuario = array(
                "id_usuario" => $resultadoAuth->id,
                "nombres" => $resultadoAuth->nombres,
                "apellidos" => $resultadoAuth->apellidos,
                "fullName" => $resultadoAuth->nombres . " " . $resultadoAuth->apellidos,
                "userName" => $resultadoAuth->username,
                "telefono" => $resultadoAuth->telefono,
                "email" => $email,
                "perfil" => $perfiles->result_array(),
                "token" => $token
            );
            $response = array(
                "ok" => true,
                "status" => "success",
                "message" => "Login Exitoso",
                "data" => $usuario
            );
        }
        return $response;
        // return array('perfiles' => $perfiles->result(), 'usuario' => $resultadoAuth, 'token' => $this->generarToken($arraySearch));
    }
    
    

    public function insertarUsuario($nombres, $apellidos, $rut, $dvrut, $telefono, $password, $email, $username) {
        $data = array(
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'rut' => $rut,
            'dvrut' => $dvrut,
            'telefono' => $telefono,
            'password' => $password,
            'email' => $email,
            'username' => $username,
        );
        $token = $this->token($data);

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

    public function getTokenUsuario($id) {
       return $this->db->select('logintoken')->from('usuarios')->where('id', $id)->get()->row(0)->logintoken;
    }
    
    public function tokenValidoBBDD($token){
         if($this->db->select('logintoken')->from('usuarios')->where('logintoken', $token)->get()->num_rows()){
             return true;
         } else {
             return false;
         }
    }

    public function generarToken() {
        return bin2hex(random_bytes(16) . uniqid('token'));
    }

    public function token($data) {
        $jwt = new JWT();

        $JwtSecretKey = "MySecretKey_Siglo21.Portafolio";
        // $data = array(
        // 	"email" => $this->input->post('email'),
        // 	"password" => $this->input->post('password')
        // );

        $token = $jwt->encode($data, $JwtSecretKey, 'HS256');
        return $token;
    }

    public function decode_token($token) {
        // $token =$this->uri->segment(3);
        // $token = $this->input->post('token');
        $jwt = new JWT();
        $JwtSecretKey = "MySecretKey_Siglo21.Portafolio";
        $decoded_token = $jwt->decode($token, $JwtSecretKey, array('HS256'));

        echo '<pre>';
        print_r($decoded_token);
        $token1 = $jwt->jsonEncode($decoded_token);
        print_r($token1);
        return $token1;
    }
    
    public function verificarPerfil($perfilSearch){
        $retorno = false;
        foreach($this->session->perfil as $perfil){
            if($perfil["nombre"] == $perfilSearch){
                $retorno = true;
            }
        }
        return $retorno;
    }
    
    public function verificarSession($tokenRequest){
        if ($this->tokenValidoBBDD($tokenRequest) && $this->session->token == $tokenRequest){
            return true;
        } else {
            return false;
        }
    }

}
