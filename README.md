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
3. Asegúrate de que el usuario tenga permisos de CREATE, INSERT, SELECT, UPDATE, DELETE

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

## 🗄️ Base de Datos

### Estructura de la Base de Datos
- **Nombre:** `chatbot`
- **Motor:** MySQL/MariaDB
- **Charset:** UTF-8

### Tabla Principal: `reclamos_vecinales`

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | INT | Identificador único | AUTO_INCREMENT, PRIMARY KEY |
| `message` | TEXT | Respuesta del bot de validación | NOT NULL |
| `user_message` | TEXT | Mensaje original del usuario | NOT NULL |
| `enabled` | TINYINT(1) | Estado del reclamo (1=válido, 0=inválido) | NOT NULL, DEFAULT 1 |
| `image_path` | VARCHAR(255) | Ruta de la imagen adjunta | NULL |
| `categoria` | VARCHAR(100) | Categoría automática del reclamo | DEFAULT 'Otros Servicios' |
| `created_at` | TIMESTAMP | Fecha y hora de creación | DEFAULT CURRENT_TIMESTAMP |

### Categorías Automáticas del Sistema

El sistema categoriza automáticamente los reclamos en las siguientes categorías:

- **Baches y Pavimento** - Problemas en calles, asfalto, caminos
- **Alumbrado Público** - Postes de luz, faroles, iluminación
- **Semáforos** - Señales de tránsito, luces de cruce
- **Contenedores de Basura** - Tachos, residuos, basureros
- **Limpieza Urbana** - Suciedad, papeles, desechos
- **Aceras y Veredas** - Banquetas, caminos peatonales
- **Alcantarillas y Desagües** - Cloacas, drenajes, alcantarillas
- **Parques y Espacios Verdes** - Plazas, jardines, áreas verdes
- **Transporte Público** - Colectivos, paradas, transporte
- **Señales de Tránsito** - Carteles, señalización vial
- **Otros Servicios** - Agua, gas, electricidad, internet

### Scripts de Base de Datos

#### Crear Base de Datos
```sql
CREATE DATABASE chatbot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Crear Usuario (Opcional)
```sql
CREATE USER 'chatbot_user'@'localhost' IDENTIFIED BY 'tu_password';
GRANT ALL PRIVILEGES ON chatbot.* TO 'chatbot_user'@'localhost';
FLUSH PRIVILEGES;
```

#### Verificar Tabla
```sql
USE chatbot;
SHOW TABLES;
DESCRIBE reclamos_vecinales;
```

## 🔒 Seguridad

- ✅ API keys almacenadas en variables de entorno
- ✅ Credenciales de BD no hardcodeadas
- ✅ Validación de archivos de imagen
- ✅ Sanitización de entrada de usuario
- ✅ Validación de tipos de archivo (solo JPG, PNG)
- ✅ Límite de tamaño de archivo (máximo 5MB)
- ✅ Categorización automática con IA para evitar sesgos

## 📝 Notas

- El sistema requiere una API key válida de OpenAI para funcionar
- Las imágenes se almacenan localmente en la carpeta `uploads/`
- Los reclamos se categorizan automáticamente usando IA
- El sistema valida tanto texto como imágenes para asegurar contenido apropiado
- Las estadísticas se generan en tiempo real desde la base de datos
- Soporte completo para UTF-8 (acentos, ñ, caracteres especiales)

## 🔧 Funcionalidades Técnicas

### Validación de Imágenes
- **Tipos permitidos:** JPG, JPEG, PNG
- **Tamaño máximo:** 5MB
- **Validación:** Análisis con GPT-4 Vision para detectar contenido inapropiado
- **Almacenamiento:** Base64 temporal para procesamiento

### API de OpenAI
- **Modelo:** GPT-4.1 (configurable)
- **Temperatura:** 0.3 (respuestas consistentes)
- **Endpoint:** `/v1/chat/completions`
- **Validación:** Prompt especializado para reclamos vecinales

### Sistema de Categorización
- **Algoritmo:** Palabras clave + contexto semántico
- **Fallback:** Categoría "Otros Servicios" por defecto
- **Extensibilidad:** Fácil agregar nuevas categorías

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

### Áreas de Mejora Sugeridas
- **Nuevas categorías** de reclamos
- **Sistema de notificaciones** por email/SMS
- **API REST** para integración con otras aplicaciones
- **Dashboard móvil** responsive
- **Sistema de prioridades** para reclamos urgentes

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 📞 Soporte

Si tienes problemas o preguntas:
1. Revisa la documentación en este README
2. Verifica la configuración de tu archivo `.env`
3. Revisa los logs de error de PHP
4. Abre un Issue en GitHub con detalles del problema

---

**Desarrollado con ❤️ para mejorar la calidad de vida en las comunidades** 