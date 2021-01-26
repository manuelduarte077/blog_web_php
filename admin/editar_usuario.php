<?php include("../includes/header.php") ?>
<?php
     //Instanciar base de datos y conexión
     $baseDatos = new Basemysql();
     $db = $baseDatos->connect();

     //Validar si se envío el id
     if (isset($_GET['id'])) {
        $id = $_GET['id'];
     }
 
     //Instancimos el objeto
     $usuario = new Usuario($db);
     $resultado = $usuario->leer_individual($id);

     //Actualizar el rol
     if (isset($_POST["editarUsuario"])) {
         //Obtenemos valores de los campos
         $idUsuario = $_POST["id"];
         $rol = $_POST["rol"];

         //Validamo que los campos no estén vacíos
         if (empty($idUsuario) || $idUsuario == '' || empty($rol) || $rol == '') {
            $error = "Error, algunos campos están vacíos";
        }else{
            //Crear usuario
            if ($usuario->actualizar($idUsuario, $rol)) {
                $mensaje = "Usuario actualizado correctamente";
                header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
                exit();
            }else{
                $error = "Error, no se pudo actualizar"; 
            }
        }

     }

     //borrar el usuario
     if (isset($_POST["borrarUsuario"])) {
        //Obtenemos valores de los campos
        $idUsuario = $_POST["id"];

        //Instanciamos objeto usuario
        $usuario = new Usuario($db);

        //Crear usuario
        if ($usuario->borrar($idUsuario)) {
            $mensaje = "Usuario borrado correctamente";
            header("Location:usuarios.php?mensaje=" . urlencode($mensaje));
            exit();
        }else{
            $error = "Error, no se pudo actualizar"; 
        }


    }

?>

    <div class="row">
        <div class="col-sm-6">
            <h3>Editar Usuario</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $resultado->usuario_id; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" value="<?php echo $resultado->usuario_nombre; ?>" readonly>              
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa el email" value="<?php echo $resultado->usuario_email; ?>" readonly>               
            </div>
            <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select class="form-select" aria-label="Default select example" name="rol">
                <option value="">--Selecciona un rol--</option>
                <option value="1" <?php if($resultado->rol == "Administrador") {echo "selected"; }?>>Administrador</option>  
                <option value="2" <?php if($resultado->rol == "Registrado") {echo "selected"; }?>>Registrado</option>
                             
            </select>             
            </div>          
        
            <br />
            <button type="submit" name="editarUsuario" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Usuario</button>

            <button type="submit" name="borrarUsuario" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Usuario</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>
       