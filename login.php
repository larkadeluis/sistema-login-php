<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (estaAutenticado()) {
    header('Location: perfil.php');
    exit();
}

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($correo) || empty($password)) {
        $tipo_mensaje = 'error';
        $mensaje = 'Por favor complete todos los campos';
    } else {
        $stmt = $pdo->prepare("SELECT id, nombre, correo, password FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_correo'] = $usuario['correo'];
            
            header('Location: perfil.php');
            exit();
        } else {
            $tipo_mensaje = 'error';
            $mensaje = '❌ Correo o contraseña incorrectos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>🔐 Iniciar Sesión</h2>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>📧 Correo electrónico:</label>
                <input type="email" name="correo" required>
            </div>
            
            <div class="form-group">
                <label>🔒 Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">🚪 Ingresar</button>
            
            <!-- NUEVO BOTÓN PARA VOLVER AL INDEX -->
            <div class="mt-3 text-center">
                <a href="index.php" style="display: inline-block; margin-top: 10px; color: #667eea; text-decoration: none;">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Inicio
                </a>
            </div>
        </form>
        
        <div class="nav">
            <a href="register.php">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
</body>
</html>