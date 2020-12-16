<?php
require '../includes/templates/header.php';
require '../includes/templates/barra.php';
?>
<main>
  <div class="contenedor contenedor-main">
    <div class="content-posts">
      <div class="contenedor-opciones">
        <?php if ($nivel_user != 1) : ?>
          <a href="crear-articulo.php" class="btn btn_nuevo"><i class="fas fa-plus f-aw"></i> Nuevo </a>
        <?php endif; ?>
        <a href="cerrar_sesion.php" class="btn btn_cerrar_sesion"><i class="fas fa-sign-out-alt f-aw"></i>Cerrar Sesion</a>
      </div>
      <section class="contenedor-posts">
        <?php foreach ($articulos as $articulo) : /*  print_r($articulo); */  ?>
          <div class="contenedor-post-admin f-row">
            <div class="img-post">
              <img src="<?= RUTA; ?>/img/<?= $articulo['thumb']; ?>" alt="">
            </div>
            <article class="post post-admin">
              <div class="header-post">
                <h3 class="titulo-post"><?php echo $articulo['titulo'] ?></h3>
                <p class="fecha-publi"><?php echo fecha($articulo['fecha_creacion']) ?></p>
              </div>
              <div class="main-post f-row">
                <p class="descr-post"><?php echo $articulo['descripcion']; ?></p>
              </div>
              <div class="footer-post">
                <a href="<?php echo RUTA; ?>/admin/editar-articulo.php?idPost=<?php echo $articulo['id_articulo']; ?>" class="btn ver-mas msl">editar </a>
                <a href="<?php echo RUTA; ?>/admin/borrar_articulo.php?idPost=<?php echo $articulo['id_articulo']; ?>" class="btn ver-mas msl">borrar </a>
              </div>
            </article>
          </div>
        <?php endforeach ?>

      </section>
    </div>
    <div class="ad">
      <div class="section2"></div>
      <div class="section3"></div>
      <div class="section2"></div>
    </div>
  </div>
  <?php
  require('../includes/templates/paginacion.php');
  ?>

</main>
<?php
require('../includes/templates/footer.php');
?>