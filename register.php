<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = trim($_POST['cedula'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? '';
    
    $errores = [];
    
    if (empty($cedula)) $errores[] = 'La cédula es obligatoria';
    if (empty($nombre)) $errores[] = 'El nombre es obligatorio';
    if (empty($correo)) $errores[] = 'El correo es obligatorio';
    elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = 'El correo no es válido';
    if (empty($password)) $errores[] = 'La contraseña es obligatoria';
    elseif (strlen($password) < 6) $errores[] = 'La contraseña debe tener al menos 6 caracteres';
    if ($password !== $confirmar_password) $errores[] = 'Las contraseñas no coinciden';
    
    if (empty($errores)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ? OR cedula = ?");
            $stmt->execute([$correo, $cedula]);
            
            if ($stmt->fetch()) {
                $tipo_mensaje = 'error';
                $mensaje = 'El correo o la cédula ya están registrados';
            } else {
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, correo, password) VALUES (?, ?, ?, ?)");
                $stmt->execute([$cedula, $nombre, $correo, $hash_password]);
                
                $tipo_mensaje = 'success';
                $mensaje = '¡Registro exitoso! Ahora puedes iniciar sesión.';
                $cedula = $nombre = $correo = '';
            }
        } catch (PDOException $e) {
            $tipo_mensaje = 'error';
            $mensaje = 'Error al registrar';
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
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>📝 Registro de Usuario</h2>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>📄 Cédula:</label>
                <input type="text" name="cedula" value="<?php echo htmlspecialchars($cedula ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>👤 Nombre completo:</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>📧 Correo electrónico:</label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($correo ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>🔒 Contraseña:</label>
                <input type="password" name="password" required>
                <small>Mínimo 6 caracteres</small>
            </div>
            
            <div class="form-group">
                <label>🔒 Confirmar contraseña:</label>
                <input type="password" name="confirmar_password" required>
            </div>
            
            <button type="submit">✅ Registrarse</button>
        </form>
        
        <div class="nav">
            <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>