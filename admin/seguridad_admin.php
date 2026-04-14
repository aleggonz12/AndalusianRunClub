<?php
session_start();
// Si no hay sesión o el rol no es admin, fuera
if (!isset($_SESSION["id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../login.php"); // Volver al login un nivel atrás
    exit();
}
?>