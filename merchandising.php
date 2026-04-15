<?php
session_start();
include("conexion.php");

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

// Si se pulsa comprar
if (isset($_POST["comprar"])) {

    $producto_id = $_POST["producto_id"];

    // Comprobar stock
    $consulta_stock = "SELECT stock FROM productos WHERE id = '$producto_id'";
    $resultado_stock = $conn->query($consulta_stock);
    $producto = $resultado_stock->fetch_assoc();

    if ($producto["stock"] > 0) {

        // Insertar compra
        $insertar = "INSERT INTO compras (usuario_id, producto_id) 
                     VALUES ('$usuario_id', '$producto_id')";

        if ($conn->query($insertar) === TRUE) {

            // Restar stock
            $actualizar = "UPDATE productos 
                           SET stock = stock - 1 
                           WHERE id = '$producto_id'";

            $conn->query($actualizar);

            echo "Compra realizada correctamente.";
        } else {
            echo "Error al realizar la compra.";
        }

    } else {
        echo "Producto sin stock.";
    }
}

// Mostrar productos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Merchandising - RunClub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include("navbar.php"); ?>

<div class="container mt-4">

<h2 class="fw-bold mb-4">Tienda oficial</h2>

<?php
if ($resultado->num_rows > 0) {

    echo "<div class='row'>";

while ($producto = $resultado->fetch_assoc()) {

    echo "<div class='col-md-4'>";

    echo "<div class='card mb-4 shadow-sm'>";

    echo "<img src='imagenes/productos/" . $producto["imagen"] . "' class='card-img-top' style='height:350px; object-fit:cover;'>";

    echo "<div class='card-body'>";

    echo "<h3 class='card-title'>" . $producto["nombre"] . "</h3>";

    echo "<p class='card-text'>" . $producto["descripcion"] . "</p>";

    echo "<p><strong>Precio:</strong> " . $producto["precio"] . " €</p>";

    echo "<p><strong>Stock:</strong> " . $producto["stock"] . "</p>";

        if ($producto["stock"] > 0) {

            echo "<form method='POST'>";
            echo "<input type='hidden' name='producto_id' value='" . $producto["id"] . "'>";
            echo "<button class='btn btn-success w-100' type='submit' name='comprar'>Comprar</button>";
            echo "</form>";

        } else {
            echo "<p class='text-danger'><strong>Sin stock</strong></p>";
        }


        echo "<hr>";
        echo "</div>"; // card-body
        echo "</div>"; // card
        echo "</div>"; // col

    }

    echo "</div>"; // row

} else {
    echo "No hay productos disponibles.";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
