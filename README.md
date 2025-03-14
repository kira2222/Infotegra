# Infotegra

Este proyecto es una aplicación Laravel que consume la API de Rick and Morty, almacena los datos en una base de datos y permite visualizarlos, editarlos y gestionarlos.

## Características

- Consume la API de Rick and Morty para obtener información de personajes.
- Almacena hasta 100 registros en la base de datos.
- Permite visualizar los registros almacenados en una tabla.
- Incluye funcionalidad para editar los registros directamente desde la interfaz.

## Requisitos previos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos:

- PHP >= 8.0
- Composer
- Node.js y npm
- MySQL o cualquier base de datos compatible con Laravel

## Instalación

Sigue estos pasos para configurar el proyecto en tu máquina local:

1. Clona este repositorio:

   ```bash
   git clone https://github.com/tu-usuario/Infotegra.git
   cd Infotegra

2. Instala las dependencias de PHP:
     ```bash
    composer install
4. Instala las dependencias de Node.js:
    ```bash
    npm install
5. Copia el archivo de configuración .env.example y renómbralo a .env:
   ```bash
   cp .env.example .env

5. Configura la conexión a la base de datos en el archivo .env:
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=infotegra
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña

6. Genera la clave de la aplicación:
   ```bash
   php artisan key:generate

7. Ejecuta las migraciones para crear las tablas necesarias:
   ```bash
   php artisan key:generate
   
8. Compila los activos de frontend:
   ```bash
   npm run dev

9. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   
10. Accede a la aplicación en tu navegador en http://localhost:8000.

Uso
1. En la página principal, haz clic en el botón Guardar en Base de Datos para almacenar los registros consumidos de la API en la base de datos.

2. Navega a la página /characters para visualizar los registros almacenados en una tabla.
   
3. Usa el botón Editar para modificar los registros directamente desde la interfaz.
   
Estructura del proyecto
- Componente Livewire:

  ApiComponent: Consume la API y permite guardar los datos en la base de datos.
  
  CharacterTable: Muestra los registros almacenados y permite editarlos.
  
- Base de datos:
  Tabla characters para almacenar los datos de los personajes.
