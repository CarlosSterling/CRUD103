<?php
require_once 'conexionVariosCampos.php';

class CrearRegistro
{

    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    public function insertarDatos($datos)
    {

        try {

            $stmt = $this->conexionDB->conect->prepare("INSERT INTO datosAprendiz (identificacion, nombre, apellido, programa, fechaingreso, fechasalida) VALUES (:identificacion, :nombre, :apellido, :programa, :fechaingreso, :fechasalida)");
            $stmt->execute([
                ':identificacion' => $datos['identificacion'],
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':programa' => $datos['programa'],
                ':fechaingreso' => $datos['fechaingreso'],
                ':fechasalida' => $datos['fechasalida'],
            ]);
            header("Location: lostarVariosCampos.php");
            exit();
        } catch (PDOException $error) {
            echo "Error al conectar con la base de datos: " . $error->getMessage();
        }
    }
}

if (isset($_POST['identificacion'], $_POST['nombre'], $_POST['apellido'], $_POST['programa'], $_POST['fechaingreso'], $_POST['fechasalida'],)) {
    $datosPersonales = [
        'identificacion' => $_POST['identificacion'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'programa' => $_POST['programa'],
        'fechaingreso' => $_POST['fechaingreso'],
        'fechasalida' => $_POST['fechasalida']
    ];
    $nuevoUsuario   = new CrearRegistro();
    $nuevoUsuario->insertarDatos($datosPersonales);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear usuario</title>
</head>

<body>

    <h1>Crear nuevos usuarios</h1>
    <form action="crearVariosCampos.php" method="post">
        <label for="identificacion">Identificación</label>
        <input type="text" name="identificacion" placeholder="Ingrese su identificación" required><br>
        <label for="nombre">Nombre(s)</label>
        <input type="text" name="nombre" placeholder="Ingrese su nombre" required><br>
        <label for="apellido">Apellidos(s)</label>
        <input type="text" name="apellido" placeholder="Ingrese su apellido" required><br>
        <label for="programa">Programa</label>
        <input type="text" name="programa" placeholder="Ingrese el programa" required><br>
        <label for="fechaingreso">Fecha de ingreso al programa:</label>
        <input type="date" name="fechaingreso" placeholder="Ingrese la fecha de inicio" required><br>
        <label for="fechasalida">Fecha de salida al programa:</label>
        <input type="date" name="fechasalida" placeholder="Ingrese la fecha de salida" required><br>
        <button type="submit">Guardar</button>
        <br>
        <a href="listarVariosCampos.php">Ver Registros</a>
    </form>

</body>

</html>