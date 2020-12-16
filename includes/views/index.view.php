<?php
require('includes/templates/header.php');
require('includes/templates/barra.php');
require('includes/templates/footer_barra.php');
?>
<main>
    <div class="contenedor contenedor-main">
        <section class="contenedor-posts">
            <?php foreach ($articulos as $articulo) : ?>
                <article class="post">
                    <div class="header-post">
                        <h3 class="titulo-post"><?php echo $articulo['titulo'] ?></h3>
                        <p class="fecha-publi"><?php echo fecha($articulo['fecha_creacion']) ?></p>
                    </div>
                    <div class="main-post">
                        <div class="contenedor-imagen">
                            <div class="detalle-post">
                                <div class="categorias">
                                    <a href="#">
                                        <p class="badge"><?= $articulo['categoria'] ?></p>
                                    </a>
                                </div>
                                <a href="#">
                                    <p class="badge publicador"><?= $articulo['usuario'] ?></p>
                                </a>
                            </div>
                            <img src="<?php echo RUTA; ?>/img/<?php echo $articulo['thumb']; ?>" alt="">
                        </div>
                        <p class="descr-post"><?php echo $articulo['descripcion']; ?></p>
                    </div>
                    <div class="footer-post">
                        <a href="<?php echo RUTA; ?>/articulo.php?idPost=<?php echo $articulo['id_articulo']; ?>" class="btn ver-mas mls">Ver mas </a>
                    </div>
                </article>
            <?php endforeach ?>
        </section>
        <div class="panel">
            <div class="section_panel ">
                <h3 class="titulo_section_panel">Categorias</h3>
                <div class="contenedor_section_panel">
                    <ul class="f-column">
                        <?php foreach ($categorias as $categoria) { ?>
                            <a href="categoria.php?categoria=<?= $categoria['id_categoria'] ?>">
                                <li class="categoria"><?= ucfirst($categoria['categoria']) ?></li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="section_panel">
                <h3 class="titulo_section_panel">ultimos posts</h3>
            </div>
            <div class="section_panel ">
                <h3 class="titulo_section_panel">Categorias</h3>
                <div class="contenedor_section_panel">
                    <ul class="f-column">
                        <a href="#"><li>Vacio</li></a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    if($articulos){
        require('includes/templates/paginacion.php');
    }
    ?>
</main>
<?php
require('includes/templates/footer.php');
?>