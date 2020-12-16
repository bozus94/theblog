<?php
require 'includes/funciones/conexion.php';
require 'includes/funciones/funciones.php';
require 'admin/configApp.php';

$conexion = conexion($bd_config);
if (!$conexion) {
  header('Location: error.php?err_1A0X');
}

$busqueda = $_GET['buscar'];
$consultaBD = buscar($conexion, $blog_config['postPorPagina'], $busqueda);
$nombre_pagina = $_SERVER['PHP_SELF'];
$numero_paginas = ($consultaBD['paginas']) ? ($consultaBD['paginas']) : 1;
$articulos = $consultaBD['articulos'];
$titulo = $consultaBD['titulo'];
$categorias = obtenerCategorias($conexion);

//comprobamosque haigan articulos
if (!$articulos) {
  header('Location: error.php?err_2b0X');
}

require 'includes/views/buscar.view.php';
