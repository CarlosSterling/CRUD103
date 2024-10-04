<?php

require_once 'conexion.php';

class ListarRegistros
{

    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }

    public function obtenerDatos()
    {
        $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datos");
        $stmt->execute();
        return $stmt->fetchAll(pdo::FETCH_ASSOC);
    }
}

$mostrarDAtos = new ListarRegistros();
$datosPersonales = $mostrarDAtos->obtenerDatos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Registros</title>
</head>

<body>
    <h1>Resgistros</h1>
    <table border 1>
        <a href="create.php">Crear un nuevo registro</a>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
        </tr>
        <?php foreach ($datosPersonales as $datosPersonalesCliente): ?>
            <tr>
                <td><?php echo $datosPersonalesCliente['nombre']; ?></td>

                <td>
                    <a href="update.php">Editar</a>
                    <a href="delete.php">Eliminar</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>

</body>

</html>