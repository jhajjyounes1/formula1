<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Equipos</title>
    <style>
        body {
            background-color: black;
            color: white; /* Añadido para asegurar un texto legible en el fondo negro */
        }

        h2 {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            text-shadow: 1px 0px 0px black,
            5px 2px 5px rgb(0, 0, 0),
            1px 3px 0px red,
            0px 1px 0px red;
            font-size: 250%;
            color: white;
            letter-spacing: 1.5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            color: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: red;
            color: white;
        }

        tr:hover {
            background-color: red;
        }
    </style>
</head>
<body>

<?php
// Configuración de errores y mensajes de inicio
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Función para eliminar un equipo por nombre
function eliminarEquipoPorNombre($nombreEquipo) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "formula1";

    // Intentar conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para eliminar el equipo por nombre
    $sql = "DELETE FROM equipo WHERE Nombre = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta es exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $nombreEquipo);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Equipo eliminado exitosamente.";
    } else {
        echo "Error al intentar eliminar el equipo: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Verificar la solicitud POST y ejecutar la eliminación si es necesario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
    $nombreEquipo = $_POST["name"];
    eliminarEquipoPorNombre($nombreEquipo);
}

// Consulta SQL para obtener todos los equipos después de la eliminación
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formula1";

// Intentar conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM equipo";
$result = $conn->query($sql);

// Mostrar la tabla si hay resultados
if ($result->num_rows > 0) {
    echo "<h2>LISTA DE EQUIPOS:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID del equipo</th><th>Nombre</th><th>Patrocinador</th><th>Director</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["ID_Equipo"] . "</td>";
        echo "<td>" . $row["Nombre"] . "</td>";
        echo "<td>" . $row["Patrocinador"] . "</td>";
        echo "<td>" . $row["Director"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No hay Equipos registrados.";
}

$conn->close();
?>

</body>
</html>
