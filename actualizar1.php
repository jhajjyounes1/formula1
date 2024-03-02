<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar piloto</title>

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
    <hr>
    <h1 style="color: #f9f9f9;">Actualizar piloto</h1>

    <?php
    // Mostrar errores y mensajes de inicio
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Realizar la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "formula1";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar la solicitud POST y ejecutar la actualización si es necesario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
        $nombrepiloto = $_POST["nombre"];
        $nuevoNombre = $_POST["nuevo_nombre"];
        $nuevoPais = $_POST["nuevo_pais"];
        $nuevaEdad = $_POST["nueva_edad"];
        $nuevoEquipo = $_POST["nuevo_equipo"];

        // Llamada a la función para actualizar el piloto
        actualizarpiloto($nombrepiloto, $nuevoNombre, $nuevoPais, $nuevaEdad, $nuevoEquipo);
    }

    // Realizar la consulta para obtener la lista de pilotos actualizada
    $sql = "SELECT * FROM piloto";
    $result = $conn->query($sql);

    // Mostrar la tabla si hay resultados
    if ($result->num_rows > 0) {
        echo "<h2>Lista de pilotos:</h2>";
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
        echo "No hay pilotos registrados.";
    }

    $conn->close();

    function actualizarpiloto($nombrepiloto, $nuevoNombre, $nuevoPais, $nuevaEdad, $nuevoEquipo) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "formula1";

        // Intentar conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta SQL para actualizar el piloto
        $sql = "UPDATE piloto SET Nombre=?, Pais=?, Edad=?, ID_Equipo=? WHERE Nombre=?";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta es exitosa
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("ssiss", $nuevoNombre, $nuevoPais, $nuevaEdad, $nuevoEquipo, $nombrepiloto);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "piloto actualizado exitosamente.";
        } else {
            echo "Error al intentar actualizar el piloto: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
