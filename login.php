<?php
session_start();
require 'includes/funciones/conexion.php';
require 'includes/funciones/funciones.php';
require 'admin/configApp.php';
if (isset($_SESSION['usuario'])) {
  header('Location:' . RUTA . '/admin');
}
$conexion = conexion($bd_config);
//verificamos si se creo la conexion
//si no se creo lo redirigimos a la pagina de error
if (!$conexion) {
  header('Location: error.php?err_1A0X');
}

if ($_POST) {
  $respuesta = inicioSesion($conexion, $_POST);
  if (isset($respuesta['resultado'])) {
    header('Location:' . RUTA . '/admin');
  }
}
require 'includes/views/login.view.php';