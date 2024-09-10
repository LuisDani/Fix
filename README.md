

Este repositorio contiene un proyecto desarrollado con Laravel 11.

## Requisitos Previos

Asegúrate de tener instalado lo siguiente en tu sistema:
- PHP v8.2.12
- Composer v2.7.7
- MySQL
- NodeJS

## Pasos Después de Clonar el Repositorio

   <h2><b>Automática</b></h2>
    
   <p>Ejecuta el archivo .bat que se encuentra en la carpeta raíz del proyecto</p>

   <h2><b>Manual</b></h2>

1. **Instalar Dependencias**
   - Ejecuta los siguientes comandos para instalar las dependencias del proyecto:
     
     ```
     composer i
     ```

     ```
      npm i
     ```

2. **Configurar el Archivo de Entorno**
   - Copia el archivo `.env.example` y renómbralo a `.env`:
     ```
     cp .env.example .env
     ```
   - Modifica el archivo `.env` con la configuración adecuada para tu entorno (base de datos, etc.).

3. **Generar la Clave de la Aplicación**
   - Ejecuta el siguiente comando para generar la clave de la aplicación en el archivo `.env`:
   
     ```
     php artisan key:generate
     ```

4. **Ejecutar Migraciones**
   - Si el proyecto utiliza una base de datos, ejecuta las migraciones para crear las tablas necesarias:
     
     ```
     php artisan migrate
     ```

5. **Ejecutar build**
   - Compilar los assets front-end para producción:
     
     ```
     npm run build
     ```

6. **Iniciar la Aplicación**
   - Inicia el servidor de desarrollo de Laravel ejecutando el siguiente comando:
     
     ```
     php artisan serve
     ```

 7. **Iniciar la Aplicación**
    - Inicia el servidor de desarrollo de Vite ejecutando el siguiente comando:
     
      ```
      npm run dev
      ```
