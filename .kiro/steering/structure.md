# Project Structure

## Root Directory Layout

```
/
├── class/                  # Core PHP classes
│   ├── class.php          # Main business logic (Login class with all methods)
│   ├── classconexion.php  # Database connection (Db class)
│   ├── funciones_basicas.php  # Utility functions (limpiar, encrypt, decrypt)
│   └── PHPMailer/         # Email library
│
├── assets/                 # Frontend resources
│   ├── css/               # Stylesheets (Bootstrap, custom)
│   ├── js/                # JavaScript libraries
│   ├── script/            # Custom JS (jsventas.js, jscompras.js, etc.)
│   ├── plugins/           # Third-party plugins (DataTables, Chart.js)
│   └── images/            # UI images and icons
│
├── fpdf/                   # PDF generation
│   ├── fpdf.php           # FPDF library
│   ├── phpqrcode/         # QR code generation
│   └── codigos/           # Generated barcode images
│
├── fotos/                  # Uploaded images
│   ├── productos/         # Product images
│   ├── combos/            # Combo images
│   └── sucursales/        # Branch logos
│
├── archivos/               # Generated documents
│   └── facturas/          # Invoice PDFs
│
├── bd-sql/                 # Database files
│   └── *.sql              # Backup and migration scripts
│
├── sql/                    # SQL migration scripts
│   └── productos_compuestos.sql  # Composite products feature
│
└── docs/                   # Documentation
```

## Main PHP Files (Root)

### Entry Points
- `index.php` - Login page
- `panel.php` - Dashboard (post-login)
- `menu.php` - Navigation sidebar

### Module Pattern
Each module follows the naming convention:
- `{module}.php` - List/CRUD view (e.g., `productos.php`, `ventas.php`)
- `for{module}.php` - Form view (e.g., `forproducto.php`, `forventa.php`)
- `carrito{module}.php` - Cart/detail management (e.g., `carritoventa.php`)
- `{module}xfechas.php` - Date-filtered reports
- `{module}x{filter}.php` - Filtered views (e.g., `ventasxclientes.php`)

### Key Modules
| File | Purpose |
|------|---------|
| `productos.php` | Product management |
| `ventas.php` | Sales transactions |
| `compras.php` | Purchase orders |
| `clientes.php` | Customer management |
| `proveedores.php` | Supplier management |
| `arqueos.php` | Cash register management |
| `creditos.php` | Credit management |
| `traspasos.php` | Inter-branch transfers |

### Reports
- `reportepdf.php` - PDF report generator
- `reporteexcel.php` - Excel export handler

## Class Architecture

### Main Class: `Login` (class/class.php)
Single monolithic class containing all business methods:
- Authentication: `Logueo()`, `RecuperarPassword()`
- CRUD operations: `Registrar*()`, `Actualizar*()`, `Eliminar*()`
- Queries: `*PorId()`, `Listar*()`, `Buscar*()`
- Reports: `Contar*()`, various report methods

### Database Class: `Db` (class/classconexion.php)
- PDO connection management
- `execute()` method for prepared statements
- `SetNames()` for UTF-8 encoding

## Coding Conventions

### PHP
- Spanish variable/function names
- `limpiar()` for input sanitization
- `encrypt()`/`decrypt()` for URL parameters
- Session variables prefixed with `$_SESSION['...']`

### JavaScript
- jQuery for DOM manipulation
- AJAX calls to `funciones.php` with GET parameters
- Form validation via jQuery Validate

### Database
- Table names in Spanish (lowercase)
- Primary keys: `id{table}` or `cod{table}`
- Foreign keys: `cod{related_table}`
- All tables use InnoDB with UTF-8
