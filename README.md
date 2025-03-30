# SysVentas

SysVentas es un sistema de gestión de ventas e inventario desarrollado en PHP, diseñado para pequeñas y medianas empresas que necesitan administrar sus ventas, inventario, compras, clientes y proveedores de manera eficiente.

## Características principales

- **Gestión de ventas**: Registro de ventas, generación de facturas, historial de ventas y anulaciones.
- **Control de inventario**: Administración de productos, control de stock, alertas de inventario bajo.
- **Gestión de compras**: Registro de compras a proveedores, historial de compras.
- **Administración de clientes y proveedores**: Registro y mantenimiento de información de clientes y proveedores.
- **Control de caja**: Registro de movimientos diarios, balance de caja, reportes.
- **Gestión de usuarios**: Sistema de usuarios con roles y permisos personalizables.
- **Reportes y estadísticas**: Informes de ventas, productos más vendidos, estadísticas de rendimiento.
- **Dashboard interactivo**: Visualización gráfica de ventas, compras y productos.

## Tecnologías utilizadas

- PHP 7.4+
- MySQL/MariaDB
- HTML5, CSS3, JavaScript
- Bootstrap 5
- jQuery
- Chart.js (para gráficos)
- FPDF (para generación de PDFs)

## Requisitos del sistema

- Servidor web (Apache, Nginx, etc.)
- PHP 7.4 o superior
- MySQL 5.7 o superior / MariaDB 10.2 o superior
- Extensiones PHP: mysqli, mbstring, gd, json

## Instalación

1. **Clonar o descargar el repositorio**:
   ```
   git clone https://github.com/usuario/sysventas6.git
   ```
   o descargar y descomprimir el archivo ZIP.

2. **Configurar la base de datos**:
   - Crear una base de datos MySQL llamada `sis_venta`
   - Importar el archivo `sis_venta.sql` ubicado en la raíz del proyecto

3. **Configurar la conexión a la base de datos**:
   - Editar el archivo `config/config.php` con los datos de tu servidor y base de datos:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'sis_venta');
   ```

4. **Configurar el acceso web**:
   - Ubicar los archivos en el directorio de tu servidor web (por ejemplo, en xampp: `C:/xampp/htdocs/Sysventas`)
   - Acceder mediante: `http://localhost/Sysventas`

## Acceso al sistema

Usuario predeterminado:
- **Usuario**: admin
- **Contraseña**: admin

## Estructura del proyecto

```
SysVentas/
├── assets/             # Recursos (CSS, JS, imágenes)
├── config/             # Archivos de configuración
├── controllers/        # Controladores MVC
├── models/             # Modelos MVC
├── views/              # Vistas MVC
├── src/                # Código fuente adicional
│   ├── pdf/            # Generación de PDFs
│   └── ...
├── index.php           # Punto de entrada
├── .htaccess           # Configuración de Apache
└── sis_venta.sql       # Archivo SQL de la base de datos
```

## Sistema de permisos y roles

SysVentas incluye un sistema completo de gestión de usuarios basado en roles:

- **Roles**: Define grupos de usuarios con diferentes niveles de acceso
- **Permisos**: Capacidades específicas que pueden asignarse a roles
- **Usuarios**: Cuentas de acceso que pueden tener roles asignados

El administrador puede crear roles personalizados y asignar permisos específicos según las necesidades de la empresa.

## Licencia

Este proyecto está bajo la Licencia MIT - consulta el archivo LICENSE para más detalles.

## Contacto y soporte

Para soporte técnico, contactar a: [Josefovelez22@gmail.com] 
