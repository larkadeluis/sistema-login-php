# Sistema de Autenticación PHP con MySQL

**Autor:** ROMERO CALUGUILLIN LUIS FELIPE | **ID:** 101

---

## 📋 Descripción

Sistema completo de autenticación de usuarios, gestión de perfiles y cambio de contraseña desarrollado en PHP con MySQL.

Este proyecto fue desarrollado como parte de una actividad académica para demostrar los conceptos de autenticación, manejo de sesiones y actualización segura de datos de usuario en PHP.

---

## 👨‍💻 Autor

| Campo | Información |
|-------|-------------|
| **Nombre completo** | ROMERO CALUGUILLIN LUIS FELIPE |
| **ID** | 101 |
| **Proyecto** | Sistema de Autenticación PHP con MySQL |
| **Año** | 2024 |

---

## 🚀 Características del Sistema

| # | Característica | Descripción |
|---|----------------|-------------|
| 1 | Registro de usuarios | Crear cuenta con cédula, nombre, correo y contraseña |
| 2 | Inicio de sesión | Login con correo y contraseña |
| 3 | Perfil personal | Ver datos del usuario (cédula, nombre, correo, fecha registro) |
| 4 | Actualizar perfil | Modificar nombre y correo |
| 5 | Cambiar contraseña | Cambio seguro verificando contraseña actual |
| 6 | Cerrar sesión | Destruir sesión y redirigir al login |
| 7 | Protección de rutas | Páginas protegidas solo accesibles con sesión activa |
| 8 | Diseño responsive | Adaptable a dispositivos móviles |

---

## 🔒 Medidas de Seguridad Implementadas

| Medida de Seguridad | Implementación | ¿Para qué sirve? |
|---------------------|----------------|------------------|
| Hash de contraseñas | `password_hash()` y `password_verify()` | Protege las contraseñas, no se guardan en texto plano |
| Prepared Statements | `$pdo->prepare()` y `$stmt->execute()` | Previene Inyección SQL |
| Sanitización de salida | `htmlspecialchars()` | Previene ataques XSS |
| Verificación de sesión | `requiereAutenticacion()` | Protege páginas privadas |
| Validación servidor | Validación en PHP antes de procesar | Evita datos incorrectos o maliciosos |
| Correo único | Restricción UNIQUE en base de datos | Evita correos duplicados |
| Cédula única | Restricción UNIQUE en base de datos | Evita cédulas duplicadas |

---

## 📋 Requisitos del Sistema

### Software necesario:
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache recomendado)
- XAMPP / WAMP / LAMP

### Extensiones PHP necesarias:
- PDO MySQL
- session
- hash

---

## 🛠️ Instalación Paso a Paso

### Paso 1: Instalar XAMPP
1. Descargar XAMPP desde https://www.apachefriends.org/
2. Ejecutar el instalador
3. Instalar en `C:\xampp\`
4. Siguiente, siguiente, finalizar

### Paso 2: Iniciar servicios en XAMPP
1. Abrir XAMPP Control Panel
2. Hacer clic en **Start** en Apache (debe ponerse verde)
3. Hacer clic en **Start** en MySQL (debe ponerse verde)

### Paso 3: Descargar o clonar el proyecto
```bash
git clone https://github.com/larkadeluis/sistema-login-php.git
