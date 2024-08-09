
# Aplicación de Gestión y Seguimiento de Juegos de Lógica

## Descripción

Esta aplicación web está diseñada para gestionar y jugar a una serie de juegos de lógica. Ofrece una interfaz para que los usuarios se registren, inicien sesión, seleccionen un juego, y sigan su progreso a través de diferentes niveles. Los administradores tienen la capacidad de gestionar los juegos disponibles, incluyendo la creación, edición y eliminación de juegos.

## Características Principales

### Para los Jugadores:

- **Registro y Autenticación:**
  - Los usuarios pueden registrarse con su nombre, apellido, correo electrónico y contraseña.
  - Los jugadores pueden iniciar sesión y ver un saludo personalizado según la hora del día.

- **Selección de Juegos:**
  - Una interfaz visual permite a los jugadores seleccionar juegos disponibles.
  - Cada juego muestra una imagen y el número de niveles disponibles.

- **Seguimiento de Progreso:**
  - Los jugadores pueden marcar niveles como completados.
  - Pueden deshacer niveles previamente completados, cambiando su estado a "pendiente".

### Para los Administradores:

- **Panel de Administración:**
  - Los administradores tienen acceso a un CRUD completo (Crear, Leer, Actualizar, Eliminar) para gestionar los juegos.
  - Los juegos pueden tener un nombre, imagen y número de niveles.

## Estructura del Proyecto

El proyecto está compuesto por los siguientes archivos principales:

- `index.php`: Página principal que incluye formularios de inicio de sesión y registro.
- `config.php`: Configuración de la conexión a la base de datos.
- `crud_juegos.php`: Panel de administración donde los administradores pueden gestionar los juegos.
- `juego.php`: Página donde los jugadores seleccionan un juego y marcan su progreso en los niveles.
- `seleccion_juego.php`: Página donde los jugadores pueden seleccionar un juego de la lista disponible.
- `logout.php`: Script para cerrar sesión.

## Instalación

1. **Requisitos:**
   - Servidor web con soporte para PHP (como Apache).
   - PHP 7.4 o superior.
   - Base de datos MySQL o MariaDB.

2. **Clonar el Repositorio:**
   ```bash
   git clone https://github.com/barrerot/retos.git
   ```

3. **Configurar la Base de Datos:**
   - Crea una base de datos llamada `retos`.
   - Importa el archivo `database.sql` para crear las tablas necesarias.

4. **Configurar la Conexión a la Base de Datos:**
   - Edita el archivo `config.php` con los detalles de tu base de datos:
     ```php
     $servername = "localhost";
     $username = "tu_usuario";
     $password = "tu_contraseña";
     $dbname = "juegos_logica";
     ```

5. **Subir Archivos al Servidor:**
   - Copia todos los archivos del proyecto en el directorio raíz de tu servidor web (`htdocs` para XAMPP).

6. **Acceder a la Aplicación:**
   - Navega a `http://localhost/jl_res/` en tu navegador para iniciar la aplicación.

## Uso

### Iniciar Sesión o Registrarse

- Los nuevos usuarios pueden registrarse a través de la página principal.
- Los usuarios existentes pueden iniciar sesión para acceder a la selección de juegos.

### Seleccionar y Jugar un Juego

- Después de iniciar sesión, los jugadores pueden seleccionar un juego disponible y comenzar a jugar.
- Pueden seguir su progreso marcando los niveles como completados o deshacerlos si es necesario.

### Administrar Juegos

- Los administradores pueden gestionar los juegos a través del panel de administración.
- Pueden crear nuevos juegos, editar los existentes o eliminarlos según sea necesario.

## Contribuir

Si deseas contribuir a este proyecto, realiza un fork del repositorio y envía un pull request con tus mejoras o sugerencias.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.
