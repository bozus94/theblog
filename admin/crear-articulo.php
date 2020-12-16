<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require 'configApp.php';
include '../includes/funciones/funciones.php';
autenticarSession();
include '../includes/funciones/conexion.php';

$conexion = conexion($bd_config);
if (!$conexion) {
  header('Location: ../error.php');
}
$errores = array();

$categorias = obtenerCategorias($conexion);
$usuario = obtenerUsuarioActual($conexion);

if (isset($_POST['submit']) == 'crear') {
  if (empty($_POST['titulo_post']) or empty($_POST['descripcion_post']) or empty($_POST['contenido_post']) or $_FILES['thumb']['name'] == "") {
    $errores .= '<li>todos los campos son obligatorios</li>';
  } else {
    $titulo = limpiarDatos($_POST['titulo_post']);
    $descripcion = limpiarDatos($_POST['descripcion_post']);
    $contenido = limpiarDatos($_POST['contenido_post']);
    $id_usuario = (int) limpiarDatos($usuario['id_usuario']);
    $id_categoria = (int) limpiarDatos($_POST['categoria']);
    $thumb = $_FILES['thumb']['tmp_name'];
    $thumb_name = $_FILES['thumb']['name'];
    $archivo_subido = '../' .  $blog_config['carpetaImagenes'] .  $thumb_name;

    $consulta = $conexion->prepare('INSERT INTO articulos (titulo, descripcion, contenido, thumb, id_usuario, id_categoria) VALUES (:titulo, :descripcion, :contenido, :thumb, :id_usuario, :id_categoria)');
    $consulta->execute(array(
      ':titulo' => $titulo,
      ':descripcion' => $descripcion,
      ':contenido' => $contenido,
      ':thumb' => $thumb_name,
      ':id_usuario' => $id_usuario,
      ':id_categoria' => $id_categoria
    ));
    $resultado = $consulta;
    if ($resultado->rowCount() > 0) {
      move_uploaded_file($thumb, $archivo_subido);
      header('Location:' . RUTA . '/admin');
    } else {
      header('Location:' . RUTA . '/error.php?err_caX01');
    }
  }
}

include '../includes/views/crear-articulo.view.php';
