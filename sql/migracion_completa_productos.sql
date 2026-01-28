-- =====================================================
-- MIGRACIÓN COMPLETA PARA PRODUCTOS
-- Ejecutar en producción ANTES de usar la carga masiva
-- =====================================================

-- PASO 1: Verificar si ya existen los campos (evita errores si ya se ejecutó)

-- Agregar tipo_producto si no existe
SET @exist := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'productos' 
               AND COLUMN_NAME = 'tipo_producto');
SET @query := IF(@exist = 0, 
    "ALTER TABLE productos ADD COLUMN tipo_producto ENUM('SIMPLE', 'PADRE', 'HIJO') NOT NULL DEFAULT 'SIMPLE' AFTER codsucursal",
    'SELECT "tipo_producto ya existe"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar producto_padre_id si no existe
SET @exist := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'productos' 
               AND COLUMN_NAME = 'producto_padre_id');
SET @query := IF(@exist = 0, 
    "ALTER TABLE productos ADD COLUMN producto_padre_id INT(11) NULL DEFAULT NULL AFTER tipo_producto",
    'SELECT "producto_padre_id ya existe"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar cantidad_conversion si no existe
SET @exist := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'productos' 
               AND COLUMN_NAME = 'cantidad_conversion');
SET @query := IF(@exist = 0, 
    "ALTER TABLE productos ADD COLUMN cantidad_conversion DECIMAL(12,2) NOT NULL DEFAULT '1.00' AFTER producto_padre_id",
    'SELECT "cantidad_conversion ya existe"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar usa_inventario si no existe
SET @exist := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'productos' 
               AND COLUMN_NAME = 'usa_inventario');
SET @query := IF(@exist = 0, 
    "ALTER TABLE productos ADD COLUMN usa_inventario ENUM('SI', 'NO') NOT NULL DEFAULT 'SI' AFTER cantidad_conversion",
    'SELECT "usa_inventario ya existe"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar tipo_comision si no existe
SET @exist := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'productos' 
               AND COLUMN_NAME = 'tipo_comision');
SET @query := IF(@exist = 0, 
    "ALTER TABLE productos ADD COLUMN tipo_comision ENUM('NINGUNA', 'PORCENTAJE', 'VALOR') NOT NULL DEFAULT 'NINGUNA' AFTER descproducto",
    'SELECT "tipo_comision ya existe"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar comision_venta si no existe
SET @exist := (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'productos' 
               AND COLUMN_NAME = 'comision_venta');
SET @query := IF(@exist = 0, 
    "ALTER TABLE productos ADD COLUMN comision_venta DECIMAL(12,2) NOT NULL DEFAULT '0.00' AFTER tipo_comision",
    'SELECT "comision_venta ya existe"');
PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- PASO 2: Actualizar productos existentes
UPDATE productos SET tipo_producto = 'SIMPLE' WHERE tipo_producto IS NULL OR tipo_producto = '';
UPDATE productos SET usa_inventario = 'SI' WHERE usa_inventario IS NULL OR usa_inventario = '';
UPDATE productos SET tipo_comision = 'NINGUNA' WHERE tipo_comision IS NULL OR tipo_comision = '';
UPDATE productos SET comision_venta = '0.00' WHERE comision_venta IS NULL;
UPDATE productos SET cantidad_conversion = '1.00' WHERE cantidad_conversion IS NULL OR cantidad_conversion = 0;

-- PASO 3: Crear índices si no existen (ignorar errores si ya existen)
-- ALTER TABLE productos ADD INDEX idx_tipo_producto (tipo_producto);
-- ALTER TABLE productos ADD INDEX idx_usa_inventario (usa_inventario);

SELECT 'MIGRACIÓN COMPLETADA EXITOSAMENTE' AS resultado;
