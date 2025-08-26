# Sistema de Reclamos Vecinales

Sistema web para gestionar y validar reclamos vecinales y de servicios públicos utilizando inteligencia artificial.

## 🚀 Instalación

### 1. Requisitos
- PHP 7.4 o superior
- MySQL/MariaDB
- Servidor web (Apache/Nginx)
- API key de OpenAI

### 2. Configuración

#### Base de Datos
1. Crea una base de datos llamada `chatbot`
2. El sistema creará automáticamente las tablas necesarias

#### Variables de Entorno
1. Copia el archivo `.env.example` como `.env`
2. Configura las siguientes variables:

```bash
# Base de datos
DB_HOST=localhost
DB_NAME=chatbot
DB_USER=root
DB_PASSWORD=tu_password

# OpenAI API
OPENAI_API_KEY=tu_api_key_de_openai
```

### 3. Permisos
- Asegúrate de que la carpeta `uploads/` tenga permisos de escritura

## 🔧 Uso

### Validación de Reclamos
- El sistema valida automáticamente los reclamos usando GPT-4
- Categoriza automáticamente por tipo de problema
- Valida imágenes para asegurar contenido apropiado

### Panel de Administración
- Accede a `/admin_reclamos.php` para gestionar reclamos
- Estadísticas en tiempo real en `/estadisticas_reclamos.php`

## 📁 Estructura del Proyecto

```
assistant/
├── config.php              # Configuración y conexión a BD
├── index.php               # Interfaz principal
├── turbo.php               # Validación con OpenAI
├── validarImagen.php       # Validación de imágenes
├── saveClaim.php           # Guardar reclamos
├── get_reclamos.php        # Obtener reclamos
├── get_estadisticas.php    # Estadísticas
├── admin_reclamos.php      # Panel de administración
├── estadisticas_reclamos.php # Vista de estadísticas
├── uploads/                # Imágenes subidas
└── .env                    # Variables de entorno (no incluir en git)
```

## 🔒 Seguridad

- ✅ API keys almacenadas en variables de entorno
- ✅ Credenciales de BD no hardcodeadas
- ✅ Validación de archivos de imagen
- ✅ Sanitización de entrada de usuario

## 📝 Notas

- El sistema requiere una API key válida de OpenAI para funcionar
- Las imágenes se almacenan localmente en la carpeta `uploads/`
- Los reclamos se categorizan automáticamente usando IA

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature
3. Commit tus cambios
4. Push a la rama
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. 