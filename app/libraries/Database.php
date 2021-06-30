
<?php
/**
 * PDO database class
 * conecta  a la db
 * crea prepared statements
 * bind values
 * return rows and results
 * Clase PDO
 */

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        //definir el DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true, //conexión persistente
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //lanzaro excepciones
        );

        //Creamos una instancia del objeto PDO
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //1º prepara sentencia con consulta
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql); 
     }

     //2º enlazar valores
     public function bind($param, $value, $type=null){
         //si no se pasa el valor de $type, se ejecuta el switch
        if(is_null($type)){
             switch(true){
                case is_int($value): //si el valor es un integer 
                    $type = PDO::PARAM_INT;
                    break; 
                case is_bool($value): //si el valor es un booleano 
                    $type = PDO::PARAM_BOOL;
                    break; 
                case is_null($value): //si el valor es null 
                    $type = PDO::PARAM_NULL;
                    break; 
                default: //si el valor es un string 
                    $type = PDO::PARAM_STR;
                }
         }
         //enlazamos los valores
        $this->stmt->bindValue($param, $value, $type); 
    }

    //3º ejecutamos la sentencia preparada
    public function execute(){
        return $this->stmt->execute();
    }
 
    //4.1. obtenemos los resultados como un array de objetos
    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ); 
    }

    //4.2. obtenemos un sólo registro
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ); 
    }

    //contar columnas
    public function rowCount(){
        return $this->stmt->rowCount();
    }

    //obtener último id añadido
    public function getId(){
        return $this->dbh->lastInsertId();
    }
}