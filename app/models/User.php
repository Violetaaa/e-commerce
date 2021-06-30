<?php
class User{
    private $db;

    public function __construct(){
        $this->db = new Database;

        }
    //comproueba si un usuario existe por medio de su email
    public function findUserByEmail($email){
        //consulta
        $this->db->query('SELECT * FROM user WHERE email =:email');
        //enlazar valores
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        //Si la consulta devuleve algún registro, el ususario existe y devolvemos true. En caso contrario, false.
        if($this->db->rowCount() >0){
            return true;
        } else {
            return false;
        }
    }

    //devuelve un usuario por su id
    public function getUserById($id){
        //consulta
        $this->db->query('SELECT * FROM user WHERE id =:id');
        //enlazar valores
        $this->db->bind(':id', $id);

        $row = $this->db->single();

       return $row;
    }
   
    //registra un nuevo usuario. Recibe como parámetro un array con sus datos.
    public function register($data){
        //consulta
        $this->db->query('INSERT INTO user (email, password, name, surname, address, city, postalCode, state, country) VALUES (:email, :password, :name, :surname, :address, :city, :postalCode, :state, :country)');
        
        //enlazar valores
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['pass']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':postalCode', $data['postalCode']);
        $this->db->bind(':state', $data['state']);
        $this->db->bind(':country', $data['country']);
      
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password){
        //consulta
        $this->db->query('SELECT * FROM user WHERE email =:email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        //recuperamos la contraseña hasheada
        $hashed_password = $row->password;
        //comprobamos que la contraseña coincide con el  dato almacenado
        if(password_verify($password, $hashed_password)){ 
            return $row; 
        } else {
            return false; 
        }
    }
}