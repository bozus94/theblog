<?php
function limpiarDatos($dt)
//Retorna el valor $datos ya limpio sin riesgo de inyeccion de codigo
{
    //trim => Elimina espacio en blanco del inicio y el final de la cadena
    $dt = trim($dt);
    //stripslashes => Quita las barras de un string con comillas escapadas /\
    $dt = stripslashes($dt);
    //htmlspecialchars => Convierte caracteres especiales en entidades HTML
    $dt = htmlspecialchars($dt);
    return $dt;
}
function paginaActual()
//Retorna en que numero de pagina nos encontramos
{
    return isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
}

function buscar($conexion, $postPorPagina, $termino)
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($termino)) {
        $inicio = (paginaActual() > 1) ? (paginaActual() * $postPorPagina - $postPorPagina) : 0;
        $respuesta = array();

        $busqueda = limpiarDatos($termino);
        $resultado['busqueda'] = $busqueda;

        $sql = " SELECT SQL_CALC_FOUND_ROWS id_articulo, titulo, descripcion, contenido, thumb, fecha_creacion, categoria, usuario FROM articulos ";
        $sql .= " INNER JOIN categorias ON articulos.id_categoria = categorias.id_categoria ";
        $sql .= " INNER JOIN usuarios ON articulos.id_usuario = usuarios.id_usuario ";
        $sql .= " WHERE titulo LIKE :busqueda or descripcion LIKE :busqueda ";
        $sql .= " LIMIT $inicio, $postPorPagina ";
        $sentencia = $conexion->prepare($sql);
        /*   para que la sentencia busque titulos o textos que contenga el termino se debe agregar 
        el simbolo % al princpio y al final de la variable en la declaracion de los placeholder */
        $sentencia->execute(array(':busqueda' => "%$busqueda%"));
        $filas = $sentencia->rowCount();
        $resultado['articulos'] =  $sentencia->fetchAll();

        if (empty($resultado['articulos'])) {
            $titulo = 'No se encontraron articulos con el resultado: ' . $busqueda;
        } else {
            $titulo = $filas . ' Resultados de la busqueda: ' . $busqueda;
        }
        $resultado['paginas'] = numeroPaginas($conexion, $postPorPagina);
        $resultado['titulo'] = $titulo;

        return $resultado;
    } else {
        header('Location: index.php');
    }
}

function articulosPorCategoria($conexion, $postPorPagina, $id_categoria)
{
    $inicio = (paginaActual() > 1) ? (paginaActual() * $postPorPagina - $postPorPagina) : 0;

    $sql = " SELECT SQL_CALC_FOUND_ROWS id_articulo, titulo, descripcion, contenido, thumb, fecha_creacion, usuario FROM articulos ";
    $sql .= " INNER JOIN usuarios ON articulos.id_usuario = usuarios.id_usuario ";
    $sql .= " WHERE id_categoria = :categoria ";
    $sql .= " ORDER BY fecha_actualizacion DESC LIMIT $inicio, $postPorPagina ";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute(array(
        ':categoria' => $id_categoria
    ));

    $filas = $sentencia->rowCount();
    $resultado['articulos'] =  $sentencia->fetchAll();

    if (empty($resultado['articulos'])) {
        $resultado['titulo'] = 'No se encontraron articulos con la categoria: ';
    } else {
        $resultado['titulo'] = $filas . ' Resultado de la busqueda: ';
    }

    $resultado['paginas'] = numeroPaginas($conexion, $postPorPagina);

    return $resultado;
}

function obtenerPosts($postPorPagina, $conexion, $usuario = null, $nivel = null)
//Ejecuta la sentencia sql y retorna los articulos de la BD
{
    $inicio = (paginaActual() > 1) ? (paginaActual() * $postPorPagina - $postPorPagina) : 0;
    //SQL_CALC_FOUND_ROWS => nos ayuda con el calculo del total de registros de la tabla
    if ($usuario !== null) {
        $sql = " SELECT SQL_CALC_FOUND_ROWS id_articulo, titulo, descripcion, contenido, thumb, fecha_creacion, categoria, id_usuario FROM articulos ";
        $sql .= " INNER JOIN categorias ON articulos.id_categoria = categorias.id_categoria ";
        $sql .= ($nivel != 1) ? " WHERE id_usuario = :id_usuario " : " ";
        $sql .= " ORDER BY fecha_actualizacion DESC LIMIT $inicio, $postPorPagina ";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute(array(
            ':id_usuario' => $usuario
        ));
    } else {
        $sql = " SELECT SQL_CALC_FOUND_ROWS id_articulo, titulo, descripcion, contenido, thumb, fecha_creacion, categoria, usuario FROM articulos ";
        $sql .= " INNER JOIN categorias ON articulos.id_categoria = categorias.id_categoria ";
        $sql .= " INNER JOIN usuarios ON articulos.id_usuario = usuarios.id_usuario ";
        $sql .= " ORDER BY fecha_actualizacion DESC LIMIT $inicio, $postPorPagina ";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
    }
    $resultado['articulos'] =  $sentencia->fetchAll();

    $resultado['paginas'] = numeroPaginas($conexion, $postPorPagina);
    
    return $resultado;
}

function numeroPaginas($conexion, $postPorPagina)
//nos retorna el numero de paginas para la paginacion
{
    $totalPost = $conexion->prepare("SELECT FOUND_ROWS() AS total");
    $totalPost->execute();
    $totalPost = $totalPost->fetch()['total'];

    $numeroPaginas = ceil($totalPost / $postPorPagina);
    return $numeroPaginas;
}

function obtenerPost($idPost, $conexion)
//retorna el post con el id deseado
{
    $sentencia = $conexion->query("SELECT * FROM articulos WHERE id_articulo = $idPost");
    $articulo = $sentencia->fetch();
    return ($articulo) ? $articulo : false;
}

function fecha($fecha)
//Retorna la fecha en formato mas legible
{
    //strtotime() - Convierte una descripción de fecha/hora textual en Inglés a una fecha Unix
    $timestamp = strtotime($fecha);
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'noviembre', 'Diciembre'];
    //date() - Devuelve una cadena formateada según el formato dado 
    $dia = date('d', $timestamp);
    $mes = date('m', $timestamp) - 1;
    $año = date('Y', $timestamp);
    $fecha = "$dia de " . $meses[$mes] . " del $año";
    return $fecha;
}

function inicioSesion($conexion, $datos)
{
    $respuesta = array();
    if (empty($datos['usuario']) or empty($datos['password'])) {
        $respuesta['errores'] .= '<li>Todos campos son obligatorios</li>';
    } else {
        $usuario = (limpiarDatos($datos['usuario']));
        $password = (limpiarDatos($datos['password']));
        $respuesta['usuario'] = $usuario;
        $respuesta['password'] = $password;
        $consulta = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password');
        $consulta->execute(array(':usuario' => $usuario, ':password' => $password));
        $resultado = $consulta->fetch();
        if ($resultado['usuario'] !== $usuario || $resultado['password'] !== $password) {
            $respuesta['errores'] .= '<li>Los datos son incorrectos</li>';
        } else {
            session_start();
            $respuesta['resultado'] = $resultado;
            $_SESSION['usuario'] = $resultado['usuario'];
            $_SESSION['status'] = true;
        }
    }
    return $respuesta;
}

function obtenerCategorias($conexionBD)
{
    $sql_cat = $conexionBD->query(" SELECT * FROM categorias ");
    $categorias = $sql_cat->fetchAll();

    return $categorias;
}

function obtenerCategoria($conexionBD, $id_categoria)
{
    $sql = " SELECT * FROM categorias WHERE id_categoria = $id_categoria";
    $sql_cat = $conexionBD->query($sql);
    $categoria = $sql_cat->fetch();

    return $categoria;
}

function obtenerUsuarioActual($conexionBD)
{
    $user_name = $_SESSION['usuario'];
    $sql_user = $conexionBD->prepare(" SELECT id_usuario, usuario, nivel FROM usuarios WHERE usuario = :user");
    $sql_user->execute(['user' => $user_name]);
    $usuario = $sql_user->fetch();

    return $usuario;
}

function comprobarSesion()
{
    return isset($_SESSION['usuario']);
}

function autenticarSession()
{
    if (!comprobarSesion()) {
        header('location: ../login.php');
    }
}
