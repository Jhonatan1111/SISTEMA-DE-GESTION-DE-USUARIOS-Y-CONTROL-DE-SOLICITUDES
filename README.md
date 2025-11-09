# Sistema de Gestión de Usuarios y Control de Solicitudes

Sistema de laboratorio patológico desarrollado con Laravel para la gestión de usuarios, doctores, pacientes, mascotas, biopsias y citologías.

## 🚀 Inicio Rápido

### Prerrequisitos
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado
- Git

### Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/jhonatan1111/sistema-laboratorio-patologico.git
cd sistema-laboratorio-patologico
```

2. **Configurar entorno**
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

```bash
# Instalar dependencias composer
composer upgrade 

# Instalar dependencias de composer
composer install --no-interaction --prefer-dist

# Generar llave de aplicacion
php artisan key:generate

# Dependecia de dompdf para generar pdf
composer require barryvdh/laravel-dompdf

# Migrar Base de Datos
php artisan migrate --seed

# Instalar Node.js y npm
npm install

# Construir assets de frontend
npm run build

# Iniciar servidor de desarrollo
php artisan serve
```

3. **Levantar el sistema**

**Opción A: Entorno de la base de datos y contenedor** (para modificar backend, database)
```bash
# Levantar servicios de desarrollo, (creacion de imagen mysql , junto a contenedor)
docker-compose up -d 
```

**Opción B: Modo Producción** (solo imagen, aplicacion web)
```bash
docker-compose --profile prod up -d
```
**Opción C: Modo Desarrollo** (solo imagen, aplicacion web)
```bash
docker-compose --profile dev up -d
```


4. **Acceder a la aplicación**
- URL: http://localhost:8081 (produccion)
- URL: http://localhost:8080 (desarrollo)
- Usuario: `admin@gmail.com`
- Contraseña: `123456`

### Comandos Útiles

```bash
# Ver logs
docker-compose logs -f app

# Limpiar volúmenes (si hay problemas con MySQL)
docker-compose down -v

##
```

### Perfiles Disponibles

- **dev**: Monta assets locales para desarrollo frontend
- **prod**: Usa assets compilados de la imagen Docker

### Puertos por perfil
- Dev: `http://localhost:8080` 
- Prod: `http://localhost:8081` 

### Apagar y levantar entre `dev` y `prod`
Nota: al ejecutar `docker-compose down` sin `--profile`, solo se detiene el servicio `mysql`. Para apagar o levantar la aplicación web, usa los comandos con el perfil `dev` o `prod` indicados abajo.
```bash
docker-compose --profile dev down --remove-orphans
# o
docker-compose --profile prod down --remove-orphans

# Levantar el perfil deseado
# produccion
docker-compose --profile prod up -d
# desarrollo
docker-compose --profile dev up -d

# Ver quién usa el puerto 8080 (Windows)
docker ps --format "table {{.Names}}\t{{.Ports}}" | findstr 8080

```
