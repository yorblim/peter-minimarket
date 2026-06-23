# 🏪 Peter Market

E-commerce construido con **Laravel 12**, **Tailwind CSS 4**, **MySQL** y **Docker (Sail)**.

## Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Windows/macOS) o Docker Engine (Linux)
- Git
- WSL2 (solo Windows) — [Guía de instalación](https://docs.docker.com/desktop/wsl/)

## Levantar el proyecto desde cero

```bash
# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd Peter-Market

# 2. Copiar archivo de entorno
cp .env.example .env

# 3. Iniciar contenedores Docker con Laravel Sail
./vendor/bin/sail up -d

# 4. Generar clave de aplicación
./vendor/bin/sail artisan key:generate

# 5. Ejecutar migraciones y seeders
./vendor/bin/sail artisan migrate:fresh --seed

# 6. Compilar assets frontend
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

La aplicación estará disponible en **http://localhost**.

## Credenciales de prueba

| Rol       | Email                  | Contraseña    |
|-----------|------------------------|---------------|
| Admin     | admin@example.com      | admin123      |
| Empleado  | empleado@example.com   | empleado123   |
| Cliente   | cliente@example.com    | cliente123    |

## Servicios incluidos (Docker)

| Servicio     | Puerto | Descripción                    |
|--------------|--------|--------------------------------|
| `laravel.test` | 80    | Aplicación PHP (Laravel)       |
| MySQL        | 3306   | Base de datos                  |
| Redis        | 6379   | Caching / sesiones             |
| Mailpit      | 1025   | Captura de correos SMTP        |
| Mailpit UI   | 8025   | Panel web para ver correos     |

## Comandos útiles

```bash
# Detener contenedores
./vendor/bin/sail down

# Ver logs en tiempo real
./vendor/bin/sail logs -f

# Ejecutar comandos Artisan
./vendor/bin/sail artisan <comando>

# Ejecutar npm
./vendor/bin/sail npm <comando>

# Acceder a la terminal del contenedor
./vendor/bin/sail shell

# Ejecutar tests
./vendor/bin/sail test
```
