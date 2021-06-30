<?php
class User{
    private $db;

    public function __construct(){
        $this->db = new Database;

        }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM user WHERE email =:email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($this->db->rowCount() >0){
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($id){
        $this->db->query('SELECT * FROM user WHERE id =:id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

       return $row;
    }
   
    public function register($data){
        $this->db->query('INSERT INTO user (email, password, name, surname, address, city, postalCode, state, country) VALUES (:email, :password, :name, :surname, :address, :city, :postalCode, :state, :country)');
        
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
        $this->db->query('SELECT * FROM user WHERE email =:email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();
     
        $hashed_password = $row->password;
    
        if(password_verify($password, $hashed_password)){ 
            return $row; 
        } else {
            return false; 
        }
    }
}