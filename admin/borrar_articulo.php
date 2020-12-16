<?php
session_start();
require 'configApp.php';
include '../includes/funciones/funciones.php';
autenticarSession();
include '../includes/funciones/conexion.php';
$conexion = conexion($bd_config);
if (!$conexion) {
  header('Location:' . RUTA . '/error.php');
}
if (isset($_GET['idPost'])) {
  $id = (int)limpiarDatos($_GET['idPost']);
  echo $id;
  $consulta = $conexion->prepare('DELETE FROM articulos WHERE id_articulo = :id');
  $respuesta = $consulta->execute(array(':id' => $id));
  if ($respuesta) {
    header('Location:' . RUTA . '/admin');
  } else {
    echo '<h3>Se ha producido un error</h3>';
  }
} else {
  header('Location:' . RUTA . '/admin');
}
