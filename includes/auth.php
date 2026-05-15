<?php
session_start();

function estaAutenticado() {
    return isset($_SESSION['usuario_id']);
}

function requiereAutenticacion() {
    if (!estaAutenticado()) {
        header('Location: login.php');
        exit();
    }
}

function obtenerUsuarioActual($pdo) {
    if (estaAutenticado()) {
        $stmt = $pdo->prepare("SELECT id, cedula, nombre, correo, fecha_registro FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        return $stmt->fetch();
    }
    return null;
}
?>