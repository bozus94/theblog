<?php
require 'admin/configApp.php';
require 'includes/funciones/conexion.php';
require 'includes/funciones/funciones.php';

$conexion = conexion($bd_config);
//verificamos si se creo la conexion
//si no se creo lo redirigimos a la pagina de error
if (!$conexion) {
    header('Location: error.php?err_1A0X');
}
$categoria_actual = $_GET['categoria'];
$categoria = obtenerCategoria($conexion, $categoria_actual);
$nombre_pagina = $_SERVER['PHP_SELF'];
$consultaBD = articulosPorCategoria($conexion, $blog_config['postPorPagina'], $categoria_actual);
$categorias = obtenerCategorias($conexion);
$numero_paginas = ($consultaBD['paginas']) ? ($consultaBD['paginas']) : 1;
$titulo = $consultaBD['titulo'];
$articulos = $consultaBD['articulos'];



//comprobamosque haigan articulos
if (!$articulos) {
    header('Location: error.php?err_2b0X');
}

require 'includes/views/categoria.view.php';
