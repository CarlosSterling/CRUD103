<?php

//incluir la conexion.
require_once 'conexion.php';

//crear la clase par agregar los valore
class CrearRegistro
{

    private $conexionDB;

    //inicializamos el constructor

    public function __construct()
    {
        //creamos la intancia de la clase Conexion
        $this->conexionDB = new Conexion();
    }
    // metodo para registrar los datos ($nombre hace referencia al campo en el qiue se va a ingresar la información) 
    public function registrarDatos($nombre)
    {
        //boque Try
        try {
            $stmt = $this->conexionDB->conect->prepare("INSERT INTO datos (nombre) VALUES (:nombre)");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            //redirigimos al script de mostrar
            header("Location: read.php");
            // finalizamos la ejecucion 
            exit();

            //bloque catch    
        } catch (PDOException $error) {

            //mensaje de error    
            echo "Error al ingresar los datos" . $error->getMessage();
        }
    }
}

//procesar la informacion GET
if ($_POST) {
    //se iguala el nombre a campo del formulario   
    $nombre = $_POST['nombre'];
    //crear instacia de la clase crear registro
    $nuevoRegistro = new CrearRegistro();
    //se iguala al registro
    $nuevoRegistro->registrarDatos($nombre);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Registro</title>
</head>

<body>
    <h1>Crear registro</h1>

    <form action="create.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" placeholder="Ingrese el nombre" required>
        <button type="submit">Guardar</button>
    </form>

</body>

</html>