<?php
require 'admin/configApp.php';
require 'includes/funciones/conexion.php';
require 'includes/funciones/funciones.php';

$conexion = conexion($bd_config);
if (!$conexion) {
  header('Location:index.php');
}
$id = (int)limpiarDatos($_GET['idPost']);
if (empty($id)) {
  header('Location: index.php?Xb4q');
}
$post = obtenerPost($id, $conexion);
if (!$post) {
  header('Location: index.php');
}

require 'includes/views/articulo.view.php';
