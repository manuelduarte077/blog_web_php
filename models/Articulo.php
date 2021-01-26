<?php

    class Articulo{
        private $conn;
        private $table = 'articulos';

        //Propiedades
        public $id;
        public $titulo;
        public $imagen;
        public $texto;
        public $fecha_creacion;


        //Constructor de nuestra clase
        public function __construct($db){
            $this->conn = $db;
        }


        //Obtener los artículos
        public function leer(){
            //Crear query
            $query = 'SELECT id, titulo, imagen, texto, fecha_creacion FROM ' . $this->table;

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Ejecutar query
            $stmt->execute();
            $articulos = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $articulos;
        }

        //Obtener artículo individual
        public function leer_individual($id){
            //Crear query
            $query = 'SELECT id, titulo, imagen, texto, fecha_creacion FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Vincular parámetro
            $stmt->bindParam(1, $id);

            //Ejecutar query
            $stmt->execute();
            $articulo = $stmt->fetch(PDO::FETCH_OBJ);
            return $articulo;
        }

        //Crear un artículo
        public function crear($titulo, $newImageName, $texto){
            //Crear query
            $query = 'INSERT INTO ' . $this->table . ' (titulo, imagen, texto)VALUES(:titulo, :imagen, :texto)';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Vincular parámetro
            $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $newImageName, PDO::PARAM_STR);
            $stmt->bindParam(":texto", $texto, PDO::PARAM_STR);

            //Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            //Si hay error 
            printf("error $s\n", $stmt->error);

        }

        //Crear un artículo
        public function actualizar($id, $titulo, $texto, $newImageName){
            
            if ($newImageName == "") {
               //Crear query
                $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, texto = :texto WHERE id = :id';

                //Preparar sentencia
                $stmt = $this->conn->prepare($query);

                //Vincular parámetro
                $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);               
                $stmt->bindParam(":texto", $texto, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);

                //Ejecutar query
                if ($stmt->execute()) {
                    return true;
                }
            }else{
                //Crear query
                $query = 'UPDATE ' . $this->table . ' SET titulo = :titulo, texto = :texto, imagen = :imagen WHERE id = :id';

                //Preparar sentencia
                $stmt = $this->conn->prepare($query);

                //Vincular parámetro
                $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);               
                $stmt->bindParam(":texto", $texto, PDO::PARAM_STR);
                $stmt->bindParam(":imagen", $newImageName, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);

                //Ejecutar query
                if ($stmt->execute()) {
                    return true;
                }
            }            

            //Si hay error 
            printf("error $s\n", $stmt->error);

        }

        //Crear un artículo
        public function borrar($idArticulo){
            //Crear query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Preparar sentencia
            $stmt = $this->conn->prepare($query);

            //Vincular parámetro
            $stmt->bindParam(":id", $idArticulo, PDO::PARAM_INT);         

            //Ejecutar query
            if ($stmt->execute()) {
                return true;
            }

            //Si hay error 
            printf("error $s\n", $stmt->error);

        }

    }