<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

// Consulta para obtener compras del usuario
$sql = "SELECT productos.nombre, productos.precio, compras.fecha
        FROM compras
        INNER JOIN productos 
        ON compras.producto_id = productos.id
        WHERE compras.usuario_id = '$usuario_id'
        ORDER BY compras.fecha DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis compras - RunClub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Mis compras</h2>

<a href="dashboard.php" class="btn btn-secondary mb-4">Volver al menú</a>

<hr>

<?php
if ($resultado->num_rows > 0) {

    echo "<div class='row'>";

    while ($compra = $resultado->fetch_assoc()) {

        $fecha_formateada = date("d/m/Y H:i", strtotime($compra["fecha"]));

           echo "<div class='col-md-4'>";

         echo "<div class='card mb-4 shadow-sm'>";

        echo "<div class='card-body'>";

        echo "<h3 class='card-title'>" . $compra["nombre"] . "</h3>";
        echo "<p><strong>Precio:</strong> " . $compra["precio"] . " €</p>";
        echo "<p><strong>Fecha de compra:</strong> " . $fecha_formateada . "</p>";
        
        echo "<hr>";
        echo "</div>"; // card-body
        echo "</div>"; // card
        echo "</div>"; // col

    }

    echo "</div>"; // row

} else {
    echo "Aún no has realizado ninguna compra.";
}
?>

</body>
</html>
