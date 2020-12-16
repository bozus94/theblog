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

$consultaBD = obtenerPosts($blog_config['postPorPagina'], $conexion);
$articulos = $consultaBD['articulos'];
$categorias = obtenerCategorias($conexion);
$numero_paginas = $consultaBD['paginas'];
$nombre_pagina = $_SERVER['PHP_SELF'];

//comprobamosque haigan articulos
/* if (!$articulos) {
    header('Location: error.php?err_2b0X');
} */

require 'includes/views/index.view.php';
