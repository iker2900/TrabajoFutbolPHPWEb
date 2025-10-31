# FutbolDef

FutbolDef es una aplicación web sencilla para gestionar información sobre partidos de fútbol y equipos.

## Características

*   **Listar y añadir equipos:** La aplicación permite ver una lista de los equipos de fútbol existentes y añadir nuevos equipos con su nombre y estadio.
*   **Ver partidos por equipo:** Puedes seleccionar un equipo para ver todos los partidos que ha jugado, tanto de local como de visitante.
*   **Filtrar partidos por jornada:** La aplicación permite filtrar los partidos por jornada para ver los resultados de una jornada específica.
*   **Añadir nuevos partidos:** Puedes añadir nuevos partidos especificando los equipos local y visitante, el resultado, la jornada y el estadio.

## Estructura del proyecto

El proyecto sigue una estructura PHP tradicional, separando la lógica de la aplicación, la persistencia de datos y las plantillas.

*   `index.php`: El punto de entrada de la aplicación. Redirige al usuario a la página de equipos o a la última página de equipo visitada.
*   `equipos.php`: Muestra la lista de equipos y un formulario para añadir nuevos.
*   `partidos.php`: Muestra los partidos por jornada y un formulario para añadir nuevos partidos.
*   `partidosEquipo.php`: Muestra los partidos de un equipo específico.
*   `app/`: Contiene la lógica para añadir nuevos equipos y partidos.
    *   `addEquipo.php`: Procesa el formulario para añadir un nuevo equipo.
    *   `addPartido.php`: Procesa el formulario para añadir un nuevo partido.
*   `persistence/`: Contiene la lógica de acceso a datos.
    *   `conf/`: Archivos de configuración para la base de datos.
    *   `DAO/`: Objetos de Acceso a Datos (DAO) para interactuar con la base de datos.
*   `templates/`: Contiene las plantillas de la interfaz de usuario, como la cabecera y el pie de página.
*   `utils/`: Contiene clases de utilidad, como `SessionHelper` para gestionar sesiones.
*   `assets/`: Contiene los recursos estáticos, como archivos CSS y JavaScript.

## Cómo empezar

1.  **Configura tu entorno:** Asegúrate de tener un servidor web con PHP y una base de datos MySQL (u otra compatible) en funcionamiento.
2.  **Importa la base de datos:** El script de la base de datos se encuentra en `persistence/database.sql`. Impórtalo en tu base de datos.
3.  **Configura la conexión a la base de datos:** Edita el archivo `persistence/conf/db.conf` con tus credenciales de la base de datos.
4.  **Inicia la aplicación:** Abre tu navegador y navega a la URL de tu proyecto.

## Contribuir

Las contribuciones son bienvenidas. Si quieres mejorar la aplicación, por favor, abre un _issue_ o envía un _pull request_.