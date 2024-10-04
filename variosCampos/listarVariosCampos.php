<?php
require_once 'conexionVariosCampos.php';
class ListarRegistros
{
    private $conexionDB;

    public function __construct()
    {
        $this->conexionDB = new Conexion();
    }
    public function obtenerDatos()
    {
        try {
            $stmt = $this->conexionDB->conect->prepare("SELECT * FROM datosAprendiz");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al registrar información" . $e->getMessage();
            return [];
        }
    }
}

$nuevoRegistros = new ListarRegistros();
$mostrarRegistros = $nuevoRegistros->obtenerDatos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Registros</title>
</head>

<body>
    <h1>Registros Creados</h1>

    <a href="crearVariosCampos.php">Crear un nuevo registro</a><br>
    <br>
    <table border 1>
        <tr>
            <th>Id</th>
            <th>Identificacion</th>
            <th>Nombre(s)</th>
            <th>Apellido(s)</th>
            <th>Programa</th>
            <th>Fecha de Ingreso</th>
            <th>Fecha de salida</th>
            <th>Acción</th>
        </tr>
        <?php if (!empty($mostrarRegistros)): ?>
            <?php foreach ($mostrarRegistros as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['id']); ?> </td>
                    <td><?php echo htmlspecialchars($registro['identificacion']); ?></td>
                    <td><?php echo htmlspecialchars($registro['nombre']); ?> </td>
                    <td><?php echo htmlspecialchars($registro['apellido']); ?> </td>
                    <td><?php echo htmlspecialchars($registro['programa']); ?> </td>
                    <td><?php echo htmlspecialchars($registro['fechaingreso']); ?> </td>
                    <td><?php echo htmlspecialchars($registro['fechasalida']); ?> </td>
                    <td>
                        <a href="actualizarVariosCampos.php?id=<?php echo $registro['id']; ?>">Actualizar</a>
                        <a href="eliminarVariosCampos.php?id=<?php echo $registro['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No se encontraron registros.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>