<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

requiereAutenticacion();

$usuario = obtenerUsuarioActual($pdo);
$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_perfil'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    
    $errores = [];
    if (empty($nombre)) $errores[] = 'El nombre es obligatorio';
    if (empty($correo)) $errores[] = 'El correo es obligatorio';
    elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = 'El correo no es válido';
    
    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ? AND id != ?");
            $stmt->execute([$correo, $_SESSION['usuario_id']]);
            
            if ($stmt->fetch()) {
                $tipo_mensaje = 'error';
                $mensaje = 'El correo ya está en uso';
            } else {
                $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, correo = ? WHERE id = ?");
                $stmt->execute([$nombre, $correo, $_SESSION['usuario_id']]);
                
                $_SESSION['usuario_nombre'] = $nombre;
                $_SESSION['usuario_correo'] = $correo;
                
                $tipo_mensaje = 'success';
                $mensaje = '✅ Perfil actualizado correctamente';
                $usuario = obtenerUsuarioActual($pdo);
            }
        } catch (PDOException $e) {
            $tipo_mensaje = 'error';
            $mensaje = 'Error al actualizar';
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
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container container-wide">
        <h2>👋 ¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</h2>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <div class="usuario-info">
            <p><strong>📄 Cédula:</strong> <?php echo htmlspecialchars($usuario['cedula']); ?></p>
            <p><strong>📅 Fecha de registro:</strong> <?php echo htmlspecialchars($usuario['fecha_registro']); ?></p>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>👤 Nombre completo:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>📧 Correo electrónico:</label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
            </div>
            
            <button type="submit" name="actualizar_perfil">💾 Actualizar Perfil</button>
        </form>
        
        <div class="nav">
            <a href="cambiar_password.php">🔑 Cambiar Contraseña</a>
            <a href="logout.php">🚪 Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>