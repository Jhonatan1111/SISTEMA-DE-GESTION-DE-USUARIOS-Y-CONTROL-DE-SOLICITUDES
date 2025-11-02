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