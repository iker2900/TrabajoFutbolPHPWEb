# Gestor de Competición (PHP)

Proyecto académico de un gestor simple de una competición de fútbol, desarrollado íntegramente en PHP sin frameworks. El objetivo principal es aplicar una arquitectura limpia basada en la separación de responsabilidades (Vistas, Lógica y Persistencia de Datos), siguiendo el modelo del proyecto `ArteanV1` y los conceptos de "Clean Code".

## 🚀 Funcionalidades Principales

* **Gestión de Equipos:**
    * Listar todos los equipos registrados.
    * Añadir nuevos equipos a la base de datos (Nombre y Estadio).
* **Gestión de Partidos:**
    * Filtrar y mostrar partidos por jornada.
    * Añadir nuevos partidos (Equipo Local, Visitante, Resultado, Estadio, Jornada).
    * **Validación:** El sistema impide registrar un partido si los dos equipos ya han jugado entre sí (basado en la `UNIQUE KEY` de la BBDD).
* **Navegación Específica:**
    * Al hacer clic en un equipo, se accede a una página que muestra todos los partidos (locales y visitantes) de ese equipo.
* **Lógica de Sesión:**
    * El `index.php` actúa como un "router".
    * Si el usuario no ha visitado nada, se le redirige a `equipos.php`.
    * Si el usuario ha visitado la página de un equipo, la web lo "recuerda" (`$_SESSION['last_team_viewed']`) y su página de inicio será la de ese equipo.

## 🛠️ Stack Tecnológico

* **Backend:** PHP (Enfoque procedural y Orientado a Objetos).
* **Base de Datos:** MySQL / MariaDB.
* **Conector BBDD:** `mysqli` (con Prepared Statements para evitar inyección SQL).
* **Frontend:** HTML5 y Bootstrap 5 (instalado localmente en `assets/`).
* **Entorno de Desarrollo:** XAMPP (Apache + MySQL).

## 📁 Arquitectura del Proyecto

El proyecto sigue una estricta separación de responsabilidades inspirada en `ArteanV1`:

* `index.php`: Punto de entrada que gestiona la lógica de sesión y redirige.
* **Vistas (Raíz):** (`equipos.php`, `partidos.php`, `partidosEquipo.php`). Son los archivos que contienen el HTML de Bootstrap y la lógica de *presentación* (bucles `foreach` para pintar datos).
* `app/`: **Lógica de Aplicación (Controladores).**
    * Scripts que procesan peticiones `$_POST` de los formularios.
    * No contienen HTML, solo procesan datos y redirigen (`header("Location: ...")`).
    * Ej: `app/addEquipo.php`, `app/addPartido.php`.
* `persistence/`: **Capa de Persistencia (Modelo).**
    * `conf/PersistentManager.php`: Clase que gestiona la conexión y desconexión con `mysqli`.
    * `DAO/`: (Data Access Objects). Clases que contienen **exclusivamente** las consultas SQL (`SELECT`, `INSERT`, etc.) usando `Prepared Statements`.
* `utils/`:
    * `SessionHelper.php`: Clase de utilidad para centralizar el `session_start()` y el manejo de `$_SESSION`.
* `templates/`:
    * `header.php`: Plantilla HTML reutilizable que incluye el `navbar` de Bootstrap y la cabecera del HTML.
* `assets/`:
    * Contiene los archivos locales de `css/` y `js/` de Bootstrap.

## ⚙️ Instalación y Puesta en Marcha (XAMPP)

1.  Clona o descarga este repositorio.
2.  Mueve la carpeta completa del proyecto (ej: `Futbol`) a tu directorio `htdocs` de XAMPP (ej: `C:\xampp\htdocs\Futbol`).
3.  Inicia los servicios de **Apache** y **MySQL** desde el panel de control de XAMPP.
4.  Abre un gestor de BBDD (HeidiSQL, phpMyAdmin) y conéctate a tu servidor local (Usuario: `root`, Contraseña: *vacía*).
5.  Ejecuta el script SQL completo (`CREATE DATABASE...`) proporcionado en el proyecto para crear la BBDD `competicion` y sus tablas (`equipos`, `partidos`).
6.  Abre tu navegador web y accede a:
    ```
    http://localhost/Futbol/
    ```
7.  El `index.php` te redirigirá automáticamente a la página de `equipos.php`.
