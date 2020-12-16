<?php
require('includes/templates/header.php');
require('includes/templates/barra.php');
?>

<main>
  <div class="contenedor contenedor-main">
    <div class="formulario">
      <h2>Inicio Sesion</h2>
      <form action="<?php echo RUTA; ?>/login.php" method="post">
        <?php if (isset($respuesta)) : ?>
          <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo $respuesta['usuario'] ?>">
          <input type="password" name="password" id="password" class="form-control" value="<?php echo $respuesta['password'] ?>">
        <?php else : ?>
          <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <?php endif ?>

        <div class="footer-form">
          <input type="submit" value="Iniciar Sesion" class="btn-submit" name="iniciar-sesion">
          <?php if (!empty($respuesta['errores'])) : ?>
            <div class="error">
              <ul>
                <?php echo $respuesta['errores']; ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</main>
<?php
require('includes/templates/footer.php');
?>