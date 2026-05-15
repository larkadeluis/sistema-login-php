<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

requiereAutenticacion();

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_actual = $_POST['password_actual'] ?? '';
    $password_nueva = $_POST['password_nueva'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? '';
    
    $errores = [];
    if (empty($password_actual)) $errores[] = 'La contraseña actual es obligatoria';
    if (empty($password_nueva)) $errores[] = 'La nueva contraseña es obligatoria';
    elseif (strlen($password_nueva) < 6) $errores[] = 'La nueva contraseña debe tener al menos 6 caracteres';
    if ($password_nueva !== $confirmar_password) $errores[] = 'Las contraseñas nuevas no coinciden';
    
    if (empty($errores)) {
        $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $usuario = $stmt->fetch();
        
        if (password_verify($password_actual, $usuario['password'])) {
            $nuevo_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
            $stmt->execute([$nuevo_hash, $_SESSION['usuario_id']]);
            
            $tipo_mensaje = 'success';
            $mensaje = '✅ Contraseña actualizada correctamente';
        } else {
            $tipo_mensaje = 'error';
            $mensaje = '❌ La contraseña actual es incorrecta';
        }
    } else {
        $tipo_mensaje = 'error';
        $mensaje = implode('<br>', $errores);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>🔑 Cambiar Contraseña</h2>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>🔒 Contraseña actual:</label>
                <input type="password" name="password_actual" required>
            </div>
            
            <div class="form-group">
                <label>🆕 Nueva contraseña:</label>
                <input type="password" name="password_nueva" required>
                <small>Mínimo 6 caracteres</small>
            </div>
            
            <div class="form-group">
                <label>✅ Confirmar nueva contraseña:</label>
                <input type="password" name="confirmar_password" required>
            </div>
            
            <button type="submit">💾 Cambiar Contraseña</button>
        </form>
        
        <div class="nav">
            <a href="perfil.php">← Volver al Perfil</a>
            <a href="logout.php">🚪 Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>