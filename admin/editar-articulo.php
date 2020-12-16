<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include '../includes/funciones/funciones.php';
autenticarSession();
require 'configApp.php';
include '../includes/funciones/conexion.php';

$conexion = conexion($bd_config);
if (!$conexion) {
  header('Location: error.php?err_1A0X');
}

$categorias = obtenerCategorias($conexion);
$usuario = obtenerUsuarioActual($conexion);

$id = $_GET['idPost'];
$errores = array();

if (isset($_GET['idPost'])) {
  $id = $_GET['idPost'];
  $post = obtenerPost($id, $conexion);
}

if (isset($_POST['submit'])) {
  if (empty($_POST['titulo_post']) or empty($_POST['descripcion_post']) or empty($_POST['contenido_post'])) {
    $errores .= '<li>todos los campos son obligatorios</li>';
  } else {

    $titulo = limpiarDatos($_POST['titulo_post']);
    $descripcion = limpiarDatos($_POST['descripcion_post']);
    $contenido = limpiarDatos($_POST['contenido_post']);
    $id = limpiarDatos($_POST['id']);
    $id_usuario = (int) limpiarDatos($usuario['id_usuario']);
    $id_categoria = (int) limpiarDatos($_POST['categoria']);
    $thumb_guardada = limpiarDatos($_POST['thumb-guardada']);
    $thumb = $_FILES['thumb'];
    if (empty($thumb['name'])) {
      $thumb_name = $thumb_guardada;
    } else {
      $archivo_subido = '../' . $blog_config['carpetaImagenes'] .  $thumb['name'];
      if (move_uploaded_file($thumb['tmp_name'], $archivo_subido)) {
        $thumb_name = $_FILES['thumb']['name'];
      }
    }

    $consulta = $conexion->prepare('UPDATE articulos SET titulo = :titulo, descripcion = :descripcion, contenido = :contenido, thumb = :thumb, id_usuario = :id_usuario, id_categoria = :id_categoria WHERE id_articulo = :id');
    $consulta->execute(array(
      ':titulo' => $titulo,
      ':descripcion' => $descripcion,
      ':contenido' => $contenido,
      ':thumb' => $thumb_name,
      'id_usuario' => $id_usuario,
      'id_categoria' => $id_categoria,
      ':id' => $id
    ));
  }
  if ($resultado = $consulta->rowCount() > 0) {
    header('Location:' . RUTA . '/admin');
  } else {
    header('Location:' . RUTA . '/error.php?err_upp_X04');
  }
}



include '../includes/views/editar-articulo.view.php';
