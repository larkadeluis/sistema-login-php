<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

// Si el usuario ya está autenticado, mostrar página principal con su información
// Si no, mostrar página de bienvenida con opciones de login/registro
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureAuth - Sistema Avanzado de Autenticación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Navbar moderno */
        .navbar-modern {
            background: rgba(248, 243, 243, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
        }

        .navbar-modern .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #4a5568;
        }

        .navbar-modern .navbar-brand i {
            color: #667eea;
        }

        .nav-link-modern {
            font-weight: 500;
            color: #2d3748;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link-modern:hover {
            color: #667eea;
            transform: translateY(-2px);
        }

        /* Tarjetas de estadísticas */
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-icon i {
            font-size: 2rem;
            color: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #4a5568;
            font-weight: 500;
        }

        /* Hero section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            animation: fadeInUp 0.8s ease-out;
        }

        .gradient-text {
            background: linear-gradient(135deg, #f9f3f3 0%, #e0d4ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-outline-gradient {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-gradient:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        /* Feature cards */
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .feature-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .feature-card h3 {
            color: #1a202c;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #4a5568;
        }

        /* Dashboard cards */
        .dashboard-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card-icon {
            width: 70px;
            height: 70px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .dashboard-card-icon i {
            font-size: 2rem;
            color: #667eea;
        }

        .dashboard-card h3 {
            color: #1a202c;
            font-weight: 700;
        }

        .dashboard-card p {
            color: #4a5568;
        }

        /* Welcome banner */
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-banner h1 {
            color: white;
        }

        .welcome-banner p {
            color: rgba(243, 243, 243, 0.9);
        }

        /* Profile card */
        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 3rem;
            color: white;
        }

        .profile-card h3 {
            color: #1a202c;
        }

        .profile-card p {
            color: #4a5568;
        }

        .profile-card strong {
            color: #1a202c;
        }

        /* Footer */
        .footer {
            background: #1a202c;
            color: #ecf3f3;
            padding: 3rem 0;
            margin-top: 4rem;
        }

        .footer h4, .footer h5 {
            color: white;
        }

        .footer .text-muted {
            color: #a0aec0 !important;
        }

        /* Text colors for hero */
        .hero-section h1 {
            color: white;
        }

        .hero-section .lead {
            color: rgba(248, 244, 244, 0.9);
        }

        .hero-section .badge {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            backdrop-filter: blur(5px);
        }

        .hero-section .stat-number {
            color: white;
        }

        .hero-section .text-muted {
            color: rgba(14, 14, 14, 0.8) !important;
        }

        /* Floating shapes */
        .floating-shape {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
        }

        .shape-1 {
            top: 10%;
            left: 5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            bottom: 10%;
            right: 5%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite reverse;
        }

        /* Section titles */
        .section-title {
            color: white;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: rgba(246, 243, 243, 0.8);
        }

        /* Container text */
        .text-white-50 {
            color: rgba(253, 250, 250, 0.8) !important;
        }
    </style>
</head>
<body>
    <?php if (estaAutenticado()): ?>
        <!-- Navbar moderno para usuarios autenticados -->
        <nav class="navbar navbar-modern navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-shield-alt me-2"></i>
                    SecureAuth/UTPL
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link nav-link-modern active" href="index.php">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-modern" href="perfil.php">
                                <i class="fas fa-user me-1"></i>Mi Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-modern" href="cambiar_password.php">
                                <i class="fas fa-key me-1"></i>Seguridad
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <div class="dropdown">
                            <button class="btn btn-light rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="perfil.php">
                                    <i class="fas fa-user me-2"></i>Mi Perfil
                                </a></li>
                                <li><a class="dropdown-item" href="cambiar_password.php">
                                    <i class="fas fa-key me-2"></i>Cambiar Contraseña
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Dashboard para usuarios autenticados -->
        <div class="container" style="margin-top: 100px;">
            <!-- Welcome Banner -->
            <div class="welcome-banner mb-5 animate-fadeInUp">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-4 fw-bold mb-3">
                            ¡Bienvenido de vuelta, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>! 👋
                        </h1>
                        <p class="lead mb-0">Gestiona tu cuenta de forma segura y mantén tus datos actualizados.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-smile-wink fa-5x animate-float"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="stat-card animate-fadeInUp" style="animation-delay: 0.1s;">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">
                            <?php 
                                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios");
                                $stmt->execute();
                                $total = $stmt->fetch()['total'];
                                echo $total;
                            ?>
                        </div>
                        <div class="stat-label">Usuarios Registrados</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card animate-fadeInUp" style="animation-delay: 0.2s;">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Soporte Activo</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card animate-fadeInUp" style="animation-delay: 0.3s;">
                        <div class="stat-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Seguro y Encriptado</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <h2 class="section-title mb-4">Acciones Rápidas ⚡</h2>
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="dashboard-card" onclick="window.location.href='perfil.php'">
                        <div class="dashboard-card-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-2">Actualizar Perfil</h3>
                        <p class="mb-0">Mantén tus datos personales actualizados y seguros.</p>
                        <div class="mt-3">
                            <span class="badge bg-primary rounded-pill">Actualizar ahora →</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-card" onclick="window.location.href='cambiar_password.php'">
                        <div class="dashboard-card-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-2">Cambiar Contraseña</h3>
                        <p class="mb-0">Actualiza tu contraseña regularmente por seguridad.</p>
                        <div class="mt-3">
                            <span class="badge bg-warning rounded-pill">Cambiar ahora →</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="row">
                <div class="col-12">
                    <div class="profile-card">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Información de tu Cuenta</h3>
                        <div class="row">
                            <div class="col-md-6 text-start">
                                <p><strong><i class="fas fa-id-card me-2"></i>Cédula:</strong> <?php 
                                    $stmt = $pdo->prepare("SELECT cedula FROM usuarios WHERE id = ?");
                                    $stmt->execute([$_SESSION['usuario_id']]);
                                    $cedula = $stmt->fetch()['cedula'];
                                    echo htmlspecialchars($cedula);
                                ?></p>
                                <p><strong><i class="fas fa-envelope me-2"></i>Correo:</strong> <?php echo htmlspecialchars($_SESSION['usuario_correo']); ?></p>
                            </div>
                            <div class="col-md-6 text-start">
                                <p><strong><i class="fas fa-calendar-check me-2"></i>Miembro desde:</strong> <?php 
                                    $stmt = $pdo->prepare("SELECT fecha_registro FROM usuarios WHERE id = ?");
                                    $stmt->execute([$_SESSION['usuario_id']]);
                                    $fecha = $stmt->fetch()['fecha_registro'];
                                    echo date('d/m/Y', strtotime($fecha));
                                ?></p>
                                <p><strong><i class="fas fa-id-badge me-2"></i>ID de Usuario:</strong> #<?php echo $_SESSION['usuario_id']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Hero section para usuarios NO autenticados -->
        <div class="hero-section">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-6 hero-content">
                        <span class="badge rounded-pill px-4 py-2 mb-4 animate-fadeInUp">
                            ROMERO CALUGUILLIN LUIS FELIPE 101
                        </span>
                        <h1 class="display-3 fw-bold mb-4 animate-fadeInUp" style="animation-delay: 0.1s;">
                            Gestión de <span class="gradient-text">Usuarios</span><br>
                            Segura y Moderna
                        </h1>
                        <p class="lead mb-4 animate-fadeInUp" style="animation-delay: 0.2s;">
                            Plataforma avanzada de autenticación con encriptación de última generación. 
                            Protege tu identidad y gestiona tu perfil de manera inteligente.
                        </p>
                        <div class="d-flex gap-3 animate-fadeInUp" style="animation-delay: 0.3s;">
                            <a href="register.php" class="btn btn-gradient btn-lg px-5">
                                <i class="fas fa-user-plus me-2"></i>Comenzar Ahora
                            </a>
                            <a href="login.php" class="btn btn-outline-gradient btn-lg px-5">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </a>
                        </div>
                        
                        <!-- Stats -->
                        <div class="row mt-5 pt-4 animate-fadeInUp" style="animation-delay: 0.4s;">
                            <div class="col-4">
                                <div class="stat-number">100%</div>
                                <div class="text-muted">Seguro</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-number">24/7</div>
                                <div class="text-muted">Disponible</div>
                            </div>
                            <div class="col-4">
                                <div class="stat-number"><?php 
                                    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios");
                                    $stmt->execute();
                                    $total = $stmt->fetch()['total'];
                                    echo $total;
                                ?>+</div>
                                <div class="text-muted">Usuarios</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 text-center animate-float">
                        <div class="position-relative">
                            <div class="card shadow-lg border-0 rounded-4 p-4" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
                                <i class="fas fa-shield-alt fa-5x mb-3" style="color: #667eea;"></i>
                                <h3 class="h4" style="color: #1a202c;">Protección Avanzada</h3>
                                <p class="text-muted">Tus datos están protegidos con los más altos estándares de seguridad</p>
                                <div class="mt-3">
                                    <span class="badge bg-success me-2">✔ Encriptación AES-256</span>
                                    <span class="badge bg-info">✔ Hash de contraseñas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-white mb-3">Características <span class="gradient-text">Premium</span></h2>
                <p class="lead section-subtitle">Todo lo que necesitas para una gestión segura de usuarios</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp" style="animation-delay: 0.1s;">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3 class="h5">Seguridad Máxima</h3>
                        <p>Contraseñas encriptadas con los algoritmos más seguros del mercado.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp" style="animation-delay: 0.2s;">
                        <div class="feature-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h3 class="h5">Autenticación Sencilla</h3>
                        <p>Proceso de login rápido e intuitivo con protección de sesiones.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card animate-fadeInUp" style="animation-delay: 0.3s;">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="h5">Gestión Completa</h3>
                        <p>Control total sobre tu perfil y datos personales.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h4 class="h5 fw-bold mb-3">SecureAuth</h4>
                        <p>Sistema avanzado de autenticación y gestión de usuarios con los más altos estándares de seguridad.</p>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5 class="fw-bold mb-3">Enlaces Rápidos</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="login.php" class="text-decoration-none" style="color: #a0aec0;">Iniciar Sesión</a></li>
                            <li class="mb-2"><a href="register.php" class="text-decoration-none" style="color: #a0aec0;">Registrarse</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5 class="fw-bold mb-3">Seguridad</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Contraseñas Hasheadas</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Protección SQL Injection</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sesiones Seguras</li>
                        </ul>
                    </div>
                </div>
                <hr class="mt-4 mb-3" style="border-color: #2d3748;">
                <div class="text-center">
                    <small>&copy; 2024 SecureAuth - Todos los derechos reservados</small>
                </div>
            </div>
        </footer>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>