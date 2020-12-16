<?php
session_start();
require 'configApp.php';
include '../includes/funciones/funciones.php';
autenticarSession();
include '../includes/funciones/conexion.php';
$conexion = conexion($bd_config);

if (!$conexion) {
  header('Location:' .  RUTA . '/error.php?Xwe46');
}

$usuario = obtenerUsuarioActual($conexion);
$id_usuario = $usuario['id_usuario'];
$nivel_user = $usuario['nivel'];

$consultaBD = obtenerPosts($blog_config['postPorPagina'], $conexion, $id_usuario, $nivel_user);
$articulos = $consultaBD['articulos'];

//comprobamosque hayan articulos
if (!$articulos) {
  header('Location: ../error.php?err_2b0X');
}

$numero_paginas = $consultaBD['paginas'];
$nombre_pagina = $_SERVER['PHP_SELF'];

require '../includes/views/admin_index.view.php';
