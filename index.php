<?php include("includes/header_front.php") ?>
<?php

//Instanciar base de datos y conexión
$baseDatos = new Basemysql();
$db = $baseDatos->connect();

//Instancimos el objeto
$articulos = new Articulo($db);
$resultado = $articulos->leer();


?>

<div class="container">

    <div class="row">

        <div class="col-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                <h1 class="text-center">Artículos</h1>
            </h3>

                <?php foreach ($resultado as $articulo) : ?>

                    <div class="card mb-4">
                        <img src="<?php echo RUTA_FRONT; ?>img/articulos/<?php echo $articulo->imagen; ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $articulo->titulo; ?></h5>
                            <p><strong><?php echo formatearFecha($articulo->fecha_creacion); ?></strong></p>
                            <p class="card-text"><?php echo textoCorto($articulo->texto); ?></p>
                            <a href="detalle.php?id=<?php echo $articulo->id; ?>" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>

                <?php endforeach; ?>

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-primary" href="#">Older</a>
                <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
            </nav>

        </div>

        <div class="col-4">
            <div class="p-4 mb-3 bg-light rounded">
                <h4 class="fst-italic">About</h4>
                <p class="mb-0">Saw you downtown singing the Blues. Watch you circle the drain. Why don't you let me stop by? Heavy is the head that <em>wears the crown</em>. Yes, we make angels cry, raining down on earth from up above.</p>
            </div>

            <div class="p-4">
                <h4 class="fst-italic">Archives</h4>
                <ol class="list-unstyled mb-0">
                    <li><a href="#">March 2014</a></li>
                    <li><a href="#">February 2014</a></li>
                    <li><a href="#">January 2014</a></li>
                    <li><a href="#">December 2013</a></li>
                    <li><a href="#">November 2013</a></li>
                    <li><a href="#">October 2013</a></li>
                    <li><a href="#">September 2013</a></li>
                    <li><a href="#">August 2013</a></li>
                    <li><a href="#">July 2013</a></li>
                    <li><a href="#">June 2013</a></li>
                    <li><a href="#">May 2013</a></li>
                    <li><a href="#">April 2013</a></li>
                </ol>
            </div>

            <div class="p-4">
                <h4 class="fst-italic">Elsewhere</h4>
                <ol class="list-unstyled">
                    <li><a href="#">GitHub</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Facebook</a></li>
                </ol>
            </div>
        </div>
    </div>




</div>
<?php include("includes/footer.php") ?>