<style>
        body {
            background-color: black;
        }
        h2 {
            font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
            text-shadow: 1px  0px 0px black,
            5px  2px 5px rgb(0, 0, 0),
            1px  3px 0px red,
            0px  1px 0px red;
            font-size: 250%;
            color: white;
            letter-spacing: 1.5px;

        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: aliceblue;
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
            background-color: #f5f5f5;
        }
    </style>
<?php
// Configuración de errores y mensajes de inicio
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Función para eliminar un piloto por nombre
function eliminarPilotoPorNombre($nombrePiloto) {
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

    // Consulta SQL para eliminar el piloto por nombre
    $sql = "DELETE FROM piloto WHERE Nombre = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta es exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $nombrePiloto);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Piloto eliminado exitosamente.";
    } else {
        echo "Error al intentar eliminar el piloto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Verificar la solicitud POST y ejecutar la eliminación si es necesario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
    $nombrePiloto = $_POST["name"];
    eliminarPilotoPorNombre($nombrePiloto);
}

// Consulta SQL para obtener todos los pilotos después de la eliminación
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

$sql = "SELECT * FROM piloto";
$result = $conn->query($sql);

// Mostrar la tabla si hay resultados
if ($result->num_rows > 0) {
    echo "<h2>LISTA  DE  PILOTOS:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Nombre</th><th>País</th><th>Edad</th><th>ID del Equipo</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Nombre"] . "</td>";
        echo "<td>" . $row["Pais"] . "</td>";
        echo "<td>" . $row["Edad"] . "</td>";
        echo "<td>" . $row["ID_Equipo"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No hay Pilotos registrados.";
}

$conn->close();
?>
