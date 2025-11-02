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

3. **Levantar el sistema**

**Opción A: Modo Desarrollo** (para modificar frontend)
```bash
# Compilar assets (opcional)
npm ci
npm run build

# Levantar contenedores
docker-compose --profile dev up -d
```

**Opción B: Modo Producción** (solo imagen)
```bash
docker-compose --profile prod up -d
```

4. **Acceder a la aplicación**
- URL: http://localhost:8080
- Usuario: `admin@admin.com`
- Contraseña: `password`

### Comandos Útiles

```bash
# Ver logs
docker-compose logs -f app

# Verificar migraciones
docker exec <container-name> php artisan migrate:status

# Parar servicios
docker-compose down

# Reinicio limpio
docker-compose down
docker-compose --profile dev up -d

# Limpiar volúmenes (si hay problemas con MySQL)
docker-compose down -v
```

### Perfiles Disponibles

- **dev**: Monta assets locales para desarrollo frontend
- **prod**: Usa assets compilados de la imagen Docker

### Puertos por perfil
- Dev: `http://localhost:8080` (mapea `8080:80`)
- Prod: `http://localhost:8081` (mapea `8081:80`)

### Cambiar de perfil sin choques
Para alternar entre `dev` y `prod` sin conflictos de puerto:
```bash
docker-compose --profile dev down --remove-orphans
# o
docker-compose --profile prod down --remove-orphans

# Levantar el perfil deseado
docker-compose --profile prod up -d
# o
docker-compose --profile dev up -d

# Ver quién usa el puerto 8080 (Windows)
docker ps --format "table {{.Names}}\t{{.Ports}}" | findstr 8080

# Si queda un contenedor ocupando 8080, eliminarlo
# (reemplaza <nombre> por el contenedor listado)
docker rm -f <nombre>
```

Si persiste el conflicto de red/puerto:
```bash
docker-compose down -v --remove-orphans
docker network prune -f
```

### Solución de Problemas

**Error 500:**
```bash
# Verificar assets
docker exec <container-name> ls -la public/build
docker exec <container-name> cat public/build/manifest.json
```

**MySQL no arranca:**
```bash
docker-compose down -v
docker-compose --profile dev up -d
```