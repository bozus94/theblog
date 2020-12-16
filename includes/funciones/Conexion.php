<?php

function conexion($bd_config)
{
    try {
        $conn = new PDO('mysql:host=localhost;port=3306;dbname=' . $bd_config['bd_nombre'], $bd_config['usuario'], $bd_config['password']);
        return $conn; 
    } catch (PDOException $e) {
        return  'Falló la conexión: ' . $e->getMessage();
    }
}
