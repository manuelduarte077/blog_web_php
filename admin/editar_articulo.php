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
     $articulos = new Articulo($db);
     $resultado = $articulos->leer_individual($id);

     //Actualizamos artículo
     if (isset($_POST['editarArticulo'])) {
        //Obtener los valores
        $idArticulo = $_POST["id"];
        $titulo = $_POST["titulo"];
        $texto = $_POST["texto"];

        if ($_FILES["imagen"]["error"] > 0) {
            //No se sube imagen pero deja actualizar demás campos
            if (empty($titulo) || $titulo == '' || empty($texto) || $texto == '') {
                $error = "Error, algunos campos están vacíos";
            }else{              
              
                //Instanciamos el articulo
                $articulo = new Articulo($db);

                $newImageName = "";

                if ($articulo->actualizar($idArticulo, $titulo, $texto, $newImageName)) {
                    $mensaje = "Artículo actualizado correctamente";
                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                    exit();
                }else{
                    $error = "Error, no se pudo actualizar"; 
                }
            }
        }else{
            //Si entra es porque si se subio la imagen
            //Validar los demás campos
            if (empty($titulo) || $titulo == '' || empty($texto) || $texto == '') {
                $error = "Error, algunos campos están vacíos";
            }else{
                //Si entra es porque se enviaron los datos
                //Subida de archivo
                $image = $_FILES['imagen']['name'];
                $imageArr = explode('.', $image);
                $rand = rand(1000, 99999);
                $newImageName = $imageArr[0] . $rand . '.' . $imageArr[1];
                $rutaFinal = "../img/articulos/" . $newImageName;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaFinal);

                //Instanciamos el articulo
                $articulo = new Articulo($db);

                if ($articulo->actualizar($idArticulo, $titulo, $texto, $newImageName)) {
                    $mensaje = "Artículo acutalizado correctamente";
                    header("Location:articulos.php?mensaje=" . urlencode($mensaje));
                }else{
                    $error = "Error, no se pudo actualizar"; 
                }
            }
        }

     }


     if (isset($_POST['borrarArticulo'])) {
        //Obtener el id
        $idArticulo = $_POST['id'];

        //Instanciamos el articulo
        $articulo = new Articulo($db);

        if ($articulo->borrar($idArticulo)) {
            $mensaje = "Artículo borrado correctamente";
            header("Location:articulos.php?mensaje=" . urlencode($mensaje));
        }else{
            $error = "Error, no se pudo borrar"; 
        }
    }

?>

<div class="row">
        <div class="col-sm-12">
            <?php if(isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?php echo $error; ?></strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php endif; ?>
        </div>  
    </div>

<div class="row">
        <div class="col-sm-6">
            <h3>Editar Artículo</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $resultado->id; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo $resultado->titulo; ?>">               
            </div>

            <div class="mb-3">
                <img class="img-fluid img-thumbnail" src="<?php echo RUTA_FRONT . "img/articulos/" . $resultado->imagen; ?>">
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Selecciona una imagen">               
            </div>
            <div class="mb-3">
                <label for="texto">Texto</label>   
                <textarea class="form-control" placeholder="Escriba el texto de su artículo" name="texto" style="height: 200px">
                <?php echo $resultado->texto; ?>
                </textarea>              
            </div>          
        
            <br />
            <button type="submit" name="editarArticulo" class="btn btn-success float-left"><i class="bi bi-person-bounding-box"></i> Editar Artículo</button>

            <button type="submit" name="borrarArticulo" class="btn btn-danger float-right"><i class="bi bi-person-bounding-box"></i> Borrar Artículo</button>
            </form>
        </div>
    </div>
<?php include("../includes/footer.php") ?>