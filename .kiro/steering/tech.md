# Technology Stack

## Backend
- **Language**: PHP 8.x (compatible with PHP 8.0+)
- **Database**: MySQL/MariaDB (tested with MariaDB 10.4)
- **Architecture**: Procedural PHP with OOP class structure

## Frontend
- **Framework**: Bootstrap 4 with custom styling
- **JavaScript**: jQuery 2.x, vanilla JS
- **UI Components**: 
  - DataTables for data grids
  - Select2 for enhanced dropdowns
  - SweetAlert for notifications
  - Chart.js for dashboards

## Key Libraries
- **FPDF**: PDF generation for reports and invoices
- **PHPMailer**: Email functionality (password recovery, invoice sending)
- **PHPQRCode**: QR code generation for documents

## Database Connection
- PDO with prepared statements
- Connection class: `class/classconexion.php`
- Database name: `ventas` (configurable)
- Charset: UTF-8

## Authentication
- Session-based authentication
- Password hashing: `password_hash()` / `password_verify()`
- Custom encryption for URL parameters: `encrypt()` / `decrypt()` functions

## Server Requirements
- Apache with mod_rewrite (URL rewriting via .htaccess)
- PHP extensions: PDO, PDO_MySQL, mbstring, gd
- Timezone: America/Caracas (configurable)

## Common Commands

### Database
```bash
# Import database backup
mysql -u root -p ventas < bd-sql/softventas_backup_10-12-2024.sql

# Create backup (via system backup.php)
# Access: /backup.php (admin only)
```

### Development
```bash
# Start local server (Laragon/XAMPP/WAMP)
# Place project in www/htdocs folder
# Access: http://localhost/ventas/
```

## Configuration Files
- Database credentials: `class/classconexion.php`
- System config: `configuracion` table in database
- URL rewriting: `.htaccess`
