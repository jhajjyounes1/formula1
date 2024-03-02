<style>
        body {
            background-image: url(img/CIRCUITO.png);
        }
        h2 {
            font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            font-size: 250%;

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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function buscarPiloto($nombreBuscar) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "formula1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL
    $sql = "SELECT * FROM piloto WHERE Nombre LIKE ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación de la consulta es exitosa
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $nombreBuscar = "%" . $nombreBuscar . "%"; // Agregar % para búsqueda parcial
    $stmt->bind_param("s", $nombreBuscar);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>Resultados de la búsqueda:</h2>";
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
            echo "No se encontraron resultados para la búsqueda.";
        }
    } else {
        echo "Error en la ejecución de la consulta: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Verificar la solicitud GET y ejecutar la búsqueda si es necesario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
    $nombreBuscar = $_POST["name"];
    buscarPiloto($nombreBuscar);
}
?>
