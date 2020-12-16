<?php
require('includes/templates/header.php');
require('includes/templates/barra.php');
?>
<main>
    <div class="contenedor contenedor-main">
        <section class="section-articulo">
            <div class="_90">
                <div class="header-articulo">
                    <h3 class="titulo-articulo"><?php echo $post['titulo'] ?></h3>
                    <p class="fecha-publi"><?php echo fecha($post['fecha_creacion']) ?></p>
                </div>
                <div class="main-articulo">
                    <div class="contenedor-imagen">
                        <img src="<?php echo RUTA; ?>/img/<?php echo $post['thumb'] ?>" alt="">
                        <div class="prueba_post"></div>
                    </div>
                    <p class="descr-articulo"><?php echo nl2br($post['contenido']); ?></p>
                </div>
            </div>
        </section>
    </div>
</main>
<?php
require('includes/templates/footer.php');
?>