<?php
header('Contect-Type: application/json');
header('Access-Control-Allow-Origin: *');
//si usas post get update delete necesitas agregar este.
header('Access-Control-Allow-Method: POST, GET, OPTIONS, UPDATE');

$username = "db_test";
$password = "db_test";
$hostname = "localhost";
$db = "db_test";
$table = "test";

$mysqli = mysqli_connect($hostname, $username, $password, $db);

/*
TABLE
CREATE TABLE `test` (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor` varchar(45) DEFAULT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

*/


if (mysqli_connect_errno($mysqli)) {
    echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
}


function mostrarLibros($detalle,$mysqli)
{
$resultad = "No respuesta";

    if ($detalle == "lista"){
    $resultado = $mysqli->query("SELECT titulo FROM test");
    } else 
{
    $resultado = $mysqli->query("SELECT titulo FROM test WHERE id=". $detalle);
}
while ($fila = mysqli_fetch_array($resultado)){
$todosLosTitulos[] = $fila; 
}


    return $todosLosTitulos;
}


function mostrarAutores($detalle, $mysqli)
{
    if ($detalle == "lista") {
        $resultado = $mysqli->query("SELECT autor FROM test");
    } else {
        $resultado = $mysqli->query("SELECT autor FROM test WHERE id=" . $detalle);
    }
    while ($fila = mysqli_fetch_array($resultado)) {
        $todosLosAutores[] = $fila;
    }

    return $todosLosAutores;
}



function crearLibro($autor, $titulo, $mysqli)
{
    $sql = "INSERT INTO test (autor, titulo) VALUES ('$autor', '$titulo');";
    $resultado = $mysqli->query($sql);
    return $mysqli->insert_id;
}

function borrarLibro($titulo, $mysqli)
{
    $sql = "DELETE FROM test WHERE titulo='$titulo';";
    $resultado = $mysqli->query($sql);
    return $mysqli->affected_rows;
}

if (isset($_GET['peticion'])) {

    if ($_GET['peticion'] == 'libros') {
        $resultados =  mostrarLibros($_GET['detalle'], $mysqli);

    } else if ($_GET['peticion'] == 'libro' AND $_GET['detalle'] == 'nuevo') {
        $resultados = crearLibro($_POST['titulo'], $_POST['autor'], $mysqli);

    } else if ($_GET['peticion'] == 'libro' AND $_GET['detalle'] == 'borrar') {
            $resultados = borrarLibro($_POST['titulo'], $mysqli);

        } else if ($_GET['peticion'] == 'autores') {
        $resultados =  mostrarAutores($_GET['detalle'], $mysqli);

    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        
        exit;
    }
    $mysqli->close();
    echo json_encode($resultados);

} else{
    echo "<h1>Rest service</h1>";
    echo "<h2>Biblioteca</h2>";
    echo "<h2>Comandos básicos:</h2>";
    echo "<lu>libros/lista</lu><br>";
    echo "<lu>libros/id</lu><br>";
    echo "<lu>autores/lista</lu><br>";
    echo "<lu>autores/id</lu><br>";
        echo "<h2>Comandos avanzados con Tabla:</h2>";
        echo "<lu>libros/nuevo</lu><br>";
        echo "<lu>libros/borrar</lu><br>";



}
