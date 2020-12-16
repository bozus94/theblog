<?php
include '../includes/templates/header.php';
include '../includes/templates/barra.php';
?>

<main>
  <div class="contenedor contenedor-main">
    <form action="<?php echo $pagina; ?>" method="post" enctype="multipart/form-data">
      <div class="contenedor-post">
        <input type="text" name="titulo_post" placeholder="Titulo" class="form_item" <?= ($_POST['titulo_post']) ? "value=$_POST[titulo_post] " : "" ?> >

        <input type="text" name="descripcion_post" placeholder="Descripcion" class="form_item" <?= ($_POST['descripcion_post']) ? "value= $_POST[descripcion_post] " : "" ?>>

        <select name="categoria" id="categoria" class="form_item">
          <?php foreach ($categorias as $categoria) : ?>
          <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['categoria'] ?></option>
          <?php endforeach; ?>
        </select>

        <textarea name="contenido_post" id="" class="form_item texa_item" placeholder="Contenido del post (maximo 1000 palabras)"><?= ($_POST['descripcion_post']) ? $_POST['contenido_post'] : "" ?></textarea>

        <input type="file" name="thumb" id="file" class="inputFile">

        <div class="footer-form">
          <?php if (!empty($errores)) : ?>
          <ul class="errores">
            <?php echo $errores ?>
          </ul>
          <?php endif ?>
          <input type="submit" name="submit" class="btn btn_form" value="crear">
        </div>
        
      </div>
    </form>
  </div>
</main>
<?php
include '../includes/templates/footer.php';
?>