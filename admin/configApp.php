<?php
define('RUTA', 'http://php_blog.test/');

$bd_config = array(
    'bd_nombre' => 'blog_practica',
    'usuario' => 'root',
    'password' => ''
);

$blog_config = array(
    'postPorPagina' => '4',
    'carpetaImagenes' => 'img/'
);

$pagina = htmlspecialchars($_SERVER['PHP_SELF']);
