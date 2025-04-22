# 🍽️ Sistema de Reserva de Restaurantes

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel&logoColor=%23ffff&logoSize=auto)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php&logoColor=%23ffff&logoSize=auto)](https://www.php.net/)
[![POSTGRESQL](https://img.shields.io/badge/PostgreSQL-17.2-4169E1?style=for-the-badge&logo=postgresql&logoColor=%23ffff&logoSize=auto)](https://www.postgresql.org/)
![JWT](https://img.shields.io/badge/JWT-000000?style=for-the-badge&logo=json-web-tokens&logoColor=%23ffff&logoSize=auto)
[![CC BY-NC-ND 4.0](https://img.shields.io/badge/License-CC%20BY--NC--ND%204.0-EF9421?logo=creative-commons&logoColor=white&style=for-the-badge)](https://creativecommons.org/licenses/by-nc-nd/4.0/)

## 🧾 Descripción

**Sistema de Reserva de Restaurantes** es una API RESTful desarrollada en Laravel que permite gestionar reservas, clientes y mesas para un restaurant. Este sistema está desarrollado con Laravel 11, utiliza JWT en la autenticación y PostgreSQL para almacenar la inforación.

## 🚀 Características

- Gestión de reservas con control de disponibilidad y estados.
- Administración de clientes y sus datos de contacto.
- Control de mesas y su estado (disponible, reservada, ocupada).
- API RESTful con autenticación basada en tokens (JWT).
- Validaciones y manejo de errores.
- Estructura escalable y mantenible utilizando el patron repositorio.
- Sistema de filtros para precisar la busqueda.
- Implementado Swagger como interfaz para la prueba y revisión de la API.

## 🛠️ Requisitos

- PHP >= 8.2
- Composer
- Laravel 11.x
- PostgreSQL
- Paquetes utilizados  y L5-Swagger

## 📚 Paquetes utilizados

| Paquete                     | Funcion                     |
|-----------------------------|-----------------------------|
| `tymon/jwt-auth`            | Autenticación JWT           |
| `spatie/laravel-permission` | Roles y Permisos            |
| `darkaonline/l5-swagger`    | Documentacion y Prueba API  |


## ⚙️ Instalación

1. **Clonar el repositorio:**

    ```bash
    git clone https://github.com/vfaundez-dev/sistema_reserva_restaurantes.git
    cd sistema_reserva_restaurantes
    ```

2. **Instalar dependencias de PHP:**

    ```bash
    composer install
    ```

3. **Configurar archivo .env:**

    ```bash
    cp .env.example .env
    ```

4. **Generar clave de aplicación:**

    ```bash
    php artisan key:generate
    ```

5. **Modificar las credenciales de la base de datos en el archivo `.env`:**

    ```env
    DB_CONNECTION=pgsql
    DB_HOST=your_host
    DB_PORT=5432
    DB_DATABASE=sistema_reservas_restaurant
    DB_USERNAME=username
    DB_PASSWORD=password
    ```

6. **Generar llave secreta (JWT):**

    ```bash
    php artisan jwt:secret
    ```

7. **Ejecutar migraciones y seeders:**

    ```bash
    php artisan migrate --seed
    ```

8. **Levantar el servidor:**

    ```bash
    php artisan serve
    ```

## 🔐 Usuarios predefinidos

| Rol           | Email                         | Contraseña  |
|---------------|-------------------------------|-------------|
| Administrator | admin@reservation.com         | asdf1234    |
| Manager       | manager@reservation.com       | asdf1234    |
| Receptionist  | receptionist@reservation.com  | asdf1234    |
| Waiter        | waiter@reservation.com        | asdf1234    |


## 📡 Endpoints de la API

> Todas las rutas están bajo el prefijo `/api`  
> Los endpoints protegidos requieren autenticación con **Bearer Token**

---

### 🔐 Autenticación

| Método | Ruta                | Descripción                         |
|--------|---------------------|-------------------------------------|
| POST   | /api/auth/login     | Iniciar sesión y obtener token      |
| POST   | /api/auth/logout    | Cerrar Sesión                       |
| POST   | /api/auth/register  | Registrar un usuario                |
| POST   | /api/auth/refresh   | Generar nuevo token actualizado     |
| POST   | /api/auth/me        | Obtener datos de usuario registrado |

---

### 👤 Usuarios

| Método    | Ruta                             | Descripción                   |
|-----------|----------------------------------|-------------------------------|
| GET       | /api/users                       | Listar usuarios               |
| POST      | /api/users                       | Crear nuevo usuario           |
| GET       | /api/users/{id}                  | Ver detalles de un usuario    |
| PUT/PATCH | /api/users/{id}                  | Actualizar un usuario         |
| DELETE    | /api/users/{id}                  | Eliminar un usuario           |
| PATCH     | /api/users/{id}/change-password  | Cambiar contraseña            |
| POST      | /api/users/{id}/get-by-email     | Obtener usuario por correo    |

---

### 👥 Clientes

| Método    | Ruta                | Descripción                    |
|-----------|---------------------|--------------------------------|
| GET       | /api/customers      | Listar clientes                |
| POST      | /api/customers      | Crear cliente                  |
| GET       | /api/customers/{id} | Ver detalles de un cliente     |
| PUT/PATCH | /api/customers/{id} | Actualizar un cliente          |
| DELETE    | /api/customers/{id} | Eliminar un cliente            |

---

### 🍽️ Mesas

| Método    | Ruta                   | Descripción                    |
|-----------|------------------------|--------------------------------|
| GET       | /api/tables            | Listar mesas                   |
| POST      | /api/tables            | Crear mesa                     |
| GET       | /api/tables/{id}       | Ver detalles de una mesa       |
| PUT/PATCH | /api/tables/{id}       | Actualizar mesa                |
| DELETE    | /api/tables/{id}       | Eliminar mesa                  |
| GET       | /api/tables/availables | Listar mesas disponibles       |
| PATCH     | /api/tables/release    | Liberar una mesa ocupada       |
| PATCH     | /api/tables/occupied   | Ocupar una mesa libre          |

---

### 📆 Reservas

| Método    | Ruta                             | Descripción                       |
|-----------|----------------------------------|-----------------------------------|
| GET       | /api/reservations                | Listar reservas                   |
| POST      | /api/reservations                | Crear nueva reserva               |
| GET       | /api/reservations/{id}           | Ver detalles de una reserva       |
| PUT/PATCH | /api/reservations/{id}           | Actualizar reserva                |
| DELETE    | /api/reservations/{id}           | Eliminar reserva                  |
| PATCH     | /api/reservations/{id}/completed | Finalizar una reserva             |
| PATCH     | /api/reservations/{id}/cancelled | Cancelar una reserva              |

---

## 👥 Roles y Permisos

| Permiso               | 🛡️ Administrator  | 📋 Manager | 🧾 Receptionist | 🍽️ Waiter |
|-----------------------|:-----------------:|:----------:|:---------------:|:---------:|
| **Clientes**          |                   |            |                 |           |
| view customers        | ✅               | ✅         | ✅              | ❌        |
| create customers      | ✅               | ✅         | ✅              | ❌        |
| edit customers        | ✅               | ✅         | ✅              | ❌        |
| delete customers      | ✅               | ✅         | ✅              | ❌        |
| **Mesas**             |                  |             |                 |           |
| view tables           | ✅               | ✅         | ✅              | ✅        |
| create tables         | ✅               | ✅         | ✅              | ❌        |
| edit tables           | ✅               | ✅         | ✅              | ❌        |
| delete tables         | ✅               | ✅         | ✅              | ❌        |
| release tables        | ✅               | ✅         | ✅              | ❌        |
| occupy tables         | ✅               | ✅         | ✅              | ❌        |
| view available tables | ✅               | ✅         | ✅              | ✅        |
| **Reservas**          |                  |             |                 |           |
| view reservations     | ✅               | ✅         | ✅              | ✅        |
| create reservations   | ✅               | ✅         | ✅              | ✅        |
| edit reservations     | ✅               | ✅         | ✅              | ❌        |
| delete reservations   | ✅               | ✅         | ✅              | ❌        |
| complete reservations | ✅               | ✅         | ✅              | ❌        |
| cancel reservations   | ✅               | ✅         | ✅              | ❌        |
| **Usuarios**          |                  |             |                 |           |
| view users            | ✅               | ✅         | ❌              | ❌        |
| create users          | ✅               | ✅         | ❌              | ❌        |
| edit users            | ✅               | ❌         | ❌              | ❌        |
| delete users          | ✅               | ❌         | ❌              | ❌        |
| change user password  | ✅               | ❌         | ❌              | ❌        |


## 🔎 Peticiones de ejemplo

### Authorization: Bearer {token}

Peticion:
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "usuario@ejemplo.com",
    "password": "password123"
}
```
Respuesta:
```json
  {
    "success": true,
    "data": {
      "access_token": "token_jwt",
      "token_type": "bearer",
      "expires_in": 3600
    }
  }
```

### Clientes

#### Obtener todos los clientes:
```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers
```

#### Crear un cliente:
```http
POST /api/customers
Authorization: Bearer {token}
Content-Type: application/json

{
  "name":  "John Doe",
  "email": "john@email.com",
  "phone": "1234567890"
}
```

## 📌 Ejemplos de Consultas GET con Filtros

### 🔍 Filtrar por campos exactos

```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers/?email=example@email.com
```

### 🔍 Busqueda textual (Solo a campos disponibles)

```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers/?search=John%20Doe
```

### 🗂️ Ordenamiento ascendente o descendente

```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers/?sort_by=id&sort_dir=desc
```

### 📆 Filtro por rango de fechas

```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers/?date_field=registration_date&date_from=2025-01-01&date_to=2025-12-31
```

### 🔗 Cargar relaciones opcionales (Eager Loading)

```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers/?include=reservations
```

### 📄 Paginación personalizada

```http
Content-Type: application/json
Authorization: Bearer {token}

GET /api/customers/?per_page=10&page=2
```

## 🧯 Manejo de Errores y Excepciones

Todos los errores y excepciones en esta API REST son devueltos en un formato consistente, siguiendo la estructura:

```json
{
  "success": false,
  "message": "Descripción del error",
  "data": null
}
```

### 🔎 Recurso no encontrado (ModelNotFoundException)
```json
{
  "success": false,
  "message": "User not found",
  "data": null
}
```

### 🚫 Ruta no encontrada (NotFoundHttpException)
```json
{
  "success": false,
  "message": "Endpoint not found",
  "data": null
}
```

### 🛑 Acción no autorizada (AccessDeniedHttpException)
```json
{
  "success": false,
  "message": "Unauthorized action!",
  "data": {
    "error": "This action is unauthorized."
  }
}
```

### 💥 Excepciones Personalizadas (ApiResponse::exception())
Cuando ocurre una excepción interna no controlada, se responde así:
```json
{
  "success": false,
  "message": "Operation failed",
  "error": "SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row..."
}
```



## 📌 Consideraciones

- No se pueden utilizar mesas que no se encuentren habilitadas o esten ya ingresadas en una reservación activa.
- No se pueden eliminar reservaciones que se encuentren activas y mesas ocupadas.
- Al crear una reserva, la mesa se marca automáticamente como no disponible.
- Se recomienda usar herramientas como Postman o Insomnia para probar la API.


## 📄 Licencia

![Creative Commons License](https://i.creativecommons.org/l/by-nc-nd/4.0/88x31.png)  
Este proyecto está licenciado bajo la [Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License](https://creativecommons.org/licenses/by-nc-nd/4.0/).

### Resumen
- **Atribución**: Debe proporcionar crédito adecuado al autor original.
- **No Comercial**: No puede utilizar el material para fines comerciales.
- **Sin Derivados**: Si remezcla, transforma o crea a partir del material, no puede distribuir el material modificado.

Para más detalles, consulte el archivo `LICENSE` incluido en este repositorio.

---

### 🤝 Contribuciones

¡Contribuciones, issues y pull requests son bienvenidos! Si deseas mejorar el proyecto, siéntete libre de clonar, modificar y enviar tus mejoras.

---

💻 Desarrollado y mantenido por **© 2025 Vladimir Faundez Hernández. Todos los derechos reservados.**
