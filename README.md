# 📚 Bookclub Hub

Una plataforma completa de gestión de clubes de lectura con tienda integrada, sistema de pago, panel administrativo, discusiones comunitarias y votaciones democráticas.

---

## 🎯 Descripción del Proyecto

**Bookclub Hub** es una aplicación web moderna diseñada para conectar a lectores apasionados. Los usuarios pueden:

- 🛍️ **Navegar y comprar libros** desde una tienda integrada
- 💳 **Procesar pagos seguro** con Stripe
- 👥 **Crear y gestionar clubs de lectura** privados o públicos
- 📖 **Planificar lecturas** con fechas y seguimiento de progreso
- 💬 **Discutir libros** con respuestas anidadas y comunidad
- 🗳️ **Votar democráticamente** el próximo libro a leer
- 📊 **Acceder a dashboard administrativo** para gestionar contenido

---

## 🚀 Tecnologías Utilizadas

### Backend
- **Laravel 12** - Framework PHP moderno y elegante
- **Livewire v3** - Componentes reactivos sin escribir JavaScript
- **MySQL** - Base de datos relacional robusta
- **Laravel Sail** - Entorno de desarrollo Docker

### Frontend
- **Blade Templating** - Motor de plantillas nativo de Laravel
- **Tailwind CSS** - Framework CSS utilitario para diseño responsivo
- **Vite** - Bundler de módulos moderno y rápido
- **Alpine.js** - Librería JavaScript ligera (incluida con Livewire)

### Herramientas de Desarrollo
- **Composer** - Gestor de dependencias PHP
- **npm** - Gestor de paquetes JavaScript
- **PHPUnit** - Framework de testing para PHP
- **Laravel Breeze** - Kit de autenticación
- **Stripe API** - Procesamiento de pagos

### Servicios Externos
- **Stripe** - Procesamiento seguro de pagos con tarjeta
- **GitHub** - Control de versiones

---

## 📁 Estructura de Carpetas

```
livewire-app/
├── app/
│   ├── Console/
│   │   ├── Commands/              # Comandos artisan personalizados
│   │   │   └── CloseExpiredVotings.php
│   │   └── Kernel.php
│   ├── Http/
│   │   ├── Controllers/           # Controladores REST
│   │   ├── Middleware/
│   │   └── Requests/              # Form requests y validación
│   ├── Livewire/
│   │   ├── Clubs/                 # Componentes de clubs
│   │   ├── Discussions/           # Componentes de discusiones
│   │   ├── Voting/                # Componentes de votación
│   │   ├── Admin/                 # Dashboard administrativo
│   │   └── ...
│   ├── Models/                    # Modelos Eloquent
│   │   ├── User.php
│   │   ├── Club.php
│   │   ├── Book.php
│   │   ├── VotingPeriod.php
│   │   ├── Discussion.php
│   │   └── ...
│   ├── Policies/                  # Políticas de autorización
│   │   ├── ClubPolicy.php
│   │   └── VotingPolicy.php
│   └── Providers/
├── bootstrap/                     # Configuración de bootstrap
├── config/                        # Archivos de configuración
│   ├── app.php
│   ├── database.php
│   ├── livewire.php
│   └── ...
├── database/
│   ├── migrations/                # Migraciones de BD
│   ├── factories/                 # Factories para testing
│   └── seeders/                   # Seeders con datos de prueba
├── public/
│   ├── index.php
│   └── build/                     # Assets compilados
├── resources/
│   ├── css/
│   │   └── app.css               # Estilos principales
│   ├── js/
│   │   └── app.js                # JavaScript principal
│   └── views/
│       ├── livewire/             # Componentes Blade Livewire
│       ├── layouts/
│       └── ...
├── routes/
│   ├── web.php                   # Rutas web
│   ├── auth.php                  # Rutas de autenticación
│   └── console.php
├── storage/                       # Archivos compilados, logs, sesiones
├── tests/                         # Tests automatizados
├── vendor/                        # Dependencias PHP
├── .env.example                   # Variables de entorno (ejemplo)
├── composer.json                  # Dependencias PHP
├── package.json                   # Dependencias JavaScript
├── tailwind.config.js            # Configuración Tailwind
├── vite.config.js                # Configuración Vite
└── phpunit.xml                   # Configuración PHPUnit
```

---

## 📋 Fases Completadas

### ✅ Fase 0: Configuración Inicial
- Configuración de Laravel 12 + Sail + Vite
- Autenticación con Laravel Breeze
- Setup de base de datos MySQL

### ✅ Fase 1: Tienda de Libros
- Catálogo de libros con búsqueda
- Detalles de libros con reseñas
- Carrito de compras
- Sistema de wishlist

### ✅ Fase 2: Sistema de Pago
- Integración con Stripe
- Checkout seguro
- Órdenes y recibos en PDF
- Historial de compras

### ✅ Fase 3: Panel Administrativo
- Dashboard de estadísticas
- Gestión de libros (CRUD)
- Gestión de órdenes
- Reportes

### ✅ Fase 4: Sistema de Clubs
- Crear/unirse a clubs
- Gestionar miembros y roles
- Planificar lecturas con fechas
- Seguimiento de progreso

### ✅ Fase 5: Foro de Discusiones
- Crear discusiones por club
- Comentarios anidados y respuestas
- Búsqueda y filtrado
- Cierre de discusiones

### ✅ Fase 6: Sistema de Votación (NUEVО)
- Crear períodos de votación
- Agregar candidatos (libros)
- Votación democrática (1 voto por usuario)
- Cierre automático por scheduler
- Historial de votaciones
- Banner de votación activa en dashboard

---

## ⚙️ Comandos de Ejecución

### Instalación Inicial

```bash
# 1. Clonar el repositorio
git clone https://github.com/DarkoneSeinen/Bookclub-hub-laravel.git
cd Livewire-Laravel/livewire-app

# 2. Instalar dependencias PHP
composer install

# 3. Copiar archivo .env
cp .env.example .env

# 4. Generar clave de aplicación
php artisan key:generate

# 5. Instalar Sail (si no está instalado)
php artisan sail:install --with=mysql,redis

# 6. Instalar dependencias JavaScript
npm install
```

### Desarrollo

```bash
# Iniciar Sail (Docker)
./vendor/bin/sail up -d

# Detener Sail
./vendor/bin/sail down

# Ver logs en tiempo real
./vendor/bin/sail logs -f

# Ejecutar migraciones
./vendor/bin/sail artisan migrate

# Ejecutar seeders (datos de prueba)
./vendor/bin/sail artisan db:seed

# Compilar assets en modo desarrollo
./vendor/bin/sail npm run dev

# Compilar assets para producción
./vendor/bin/sail npm run build

# Limpiar caché
./vendor/bin/sail artisan optimize:clear

# Abrir Tinker (REPL interactivo)
./vendor/bin/sail artisan tinker
```

### Base de Datos

```bash
# Ejecutar migraciones
./vendor/bin/sail artisan migrate

# Revertir última migración
./vendor/bin/sail artisan migrate:rollback

# Reset completo de BD
./vendor/bin/sail artisan migrate:fresh

# Seeders
./vendor/bin/sail artisan db:seed

# Seeder específico
./vendor/bin/sail artisan db:seed --class=UserSeeder
```

### Comandos Especiales

```bash
# Cerrar votaciones expiradas (manual)
./vendor/bin/sail artisan voting:close-expired

# Rutas disponibles
./vendor/bin/sail artisan route:list

# Modelos
./vendor/bin/sail artisan make:model ModelName -mcr

# Crear migración
./vendor/bin/sail artisan make:migration create_table_name

# Crear controlador
./vendor/bin/sail artisan make:controller ControllerName

# Crear componente Livewire
./vendor/bin/sail artisan make:livewire ComponentName
```

### Testing

```bash
# Ejecutar todos los tests
./vendor/bin/sail artisan test

# Tests específicos
./vendor/bin/sail artisan test --filter=TestName

# Con coverage
./vendor/bin/sail artisan test --coverage
```

---

## 🔧 Configuración del Proyecto

### Variables de Entorno (.env)

```env
# Aplicación
APP_NAME=BookclubHub
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Base de datos
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=bookclub_db
DB_USERNAME=sail
DB_PASSWORD=password

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

# Stripe (para pagos)
STRIPE_PUBLIC_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...

# Mail
MAIL_MAILER=log
MAIL_FROM_ADDRESS=no-reply@bookclub.local
```

---

## 🚀 Cómo Iniciar el Proyecto

1. **Clonar y configurar:**
   ```bash
   git clone https://github.com/tu-usuario/Livewire-Laravel.git
   cd Livewire-Laravel/livewire-app
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   ```

2. **Iniciar containers Docker:**
   ```bash
   ./vendor/bin/sail up -d
   ```

3. **Ejecutar migraciones:**
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

4. **Compilar assets:**
   ```bash
   ./vendor/bin/sail npm run build
   ```

5. **Acceder a la aplicación:**
   - URL: `http://localhost`
   - Panel Admin: `/admin` (usuario: admin@example.com)
   - Credenciales de prueba en `database/seeders/`

---

## 📊 Estadísticas del Proyecto

- **7 Fases completadas** (60% del roadmap)
- **25+ Componentes Livewire** funcionales
- **10+ Migraciones** de base de datos
- **15+ Modelos Eloquent** con relaciones
- **8+ Políticas** de autorización
- **Responsive Design** en Tailwind CSS
- **0 JavaScript personalizado** (Livewire + Alpine)

---

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo [LICENSE](./LICENSE) para más detalles.

---

## 👨‍💻 Desarrollo

Desarrollado como proyecto educativo demostrando:
- Arquitectura Laravel moderna
- Componentes reactivos con Livewire
- Diseño responsivo con Tailwind
- Buenas prácticas de seguridad
- Validación y autorización granular

---

## 📞 Contacto y Soporte

Para dudas, reportar bugs o sugerencias, abrir un issue en el repositorio.

Happy reading! 📚✨
