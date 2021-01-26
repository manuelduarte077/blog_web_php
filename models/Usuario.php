<?php

    class Usuario{
        private $conn;
        private $table = 'usuarios';

        //Propiedades
        public $id;
        public $nombre;
        public $email;
        public $password;
        public $fecha_creacion;


        //Constructor de nuestra clase
        public function __construct($db){
            $this->conn = $db;
        }


        //Obtener los artículos
        public function leer(){
            //Crear query
            $query = 'SELECT u.id AS usuario_id, u.nombre AS usuario_nombre, u.email AS usuario_email, u.fecha_creacion AS usuario_fecha_creacion, r.nombre AS rol  FROM ' . $this->table . ' u INNER JOIN roles r ON r.id = u.rol_id';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Ejecutar query
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $usuarios;
        }

        //Obtener artículo individual
        public function leer_individual($id){
            //Crear query
            $query = 'SELECT u.id AS usuario_id, u.nombre AS usuario_nombre, u.email AS usuario_email, u.fecha_creacion AS usuario_fecha_creacion, r.nombre AS rol  FROM ' . $this->table . ' u INNER JOIN roles r ON r.id = u.rol_id WHERE u.id = ? LIMIT 0,1';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Vincular parámetro
            $stmt->bindParam(1, $id);

            //Ejecutar query
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_OBJ);
            return $usuario;
        }
        

        //Crear un artículo
        public function actualizar($idUsuario, $rol){
         
               //Crear query
                $query = 'UPDATE ' . $this->table . ' SET rol_id = :rol_id WHERE id = :id';

                //Preparar sentencia
                $stmt = $this->conn->prepare($query);

                //Vincular parámetro
                $stmt->bindParam(":rol_id", $rol, PDO::PARAM_INT);              
                $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);

                //Ejecutar query
                if ($stmt->execute()) {
                    return true;

                }
        
                //Si hay error 
                printf("error $s\n", $stmt->error);

        }

        //Crear un artículo
        public function borrar($idUsuario){
            //Crear query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Vincular parámetro
            $stmt->bindParam(":id", $idUsuario, PDO::PARAM_INT);         

            //Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            //Si hay error 
            printf("error $s\n", $stmt->error);

        }


        //Registrarse
        public function registrar($nombre, $email, $password){
            //Crear query
            $query = 'INSERT INTO ' . $this->table . ' (nombre, email, password, rol_id)VALUES(:nombre, :email, :password, 2)';

            //Encriptar el password MD5
            $passwordEncriptado = md5($password);

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Vincular parámetro
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);         
            $stmt->bindParam(":password", $passwordEncriptado, PDO::PARAM_STR);                

            //Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            //Si hay error 
            printf("error $s\n", $stmt->error);

        }

        //Validar si el email existe
        public function validar_email($email){
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $resultado = $stmt->execute();

            $registroEmail = $stmt->fetch(PDO::FETCH_ASSOC);

            if($registroEmail) {
                return false;
            }else{
                return true;
            }
        }

         //Validar si el email existe
         public function acceder($email, $password){
            //Crear query
            $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email AND password = :password';

            //Encriptar el password MD5
            $passwordEncriptado = md5($password);

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $passwordEncriptado, PDO::PARAM_STR);

            $resultado = $stmt->execute();

            $existeUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if($existeUsuario) {
                return true;
            }else{
                return false;
            }
        }

    }