-- =====================================================
-- SCRIPT PARA IMPLEMENTAR PRODUCTOS COMPUESTOS (PADRE-HIJO)
-- Ejecutar en la base de datos del sistema de ventas
-- Fecha: 2024-12-05
-- =====================================================

-- =====================================================
-- PASO 1: Agregar nuevos campos a la tabla productos
-- =====================================================

-- tipo_producto: SIMPLE (productos normales actuales), PADRE (producto base que maneja stock), HIJO (presentación sin stock propio)
ALTER TABLE `productos` ADD COLUMN `tipo_producto` ENUM('SIMPLE', 'PADRE', 'HIJO') NOT NULL DEFAULT 'SIMPLE' AFTER `codsucursal`;

-- producto_padre_id: ID del producto padre (solo aplica para productos HIJO)
ALTER TABLE `productos` ADD COLUMN `producto_padre_id` INT(11) NULL DEFAULT NULL AFTER `tipo_producto`;

-- cantidad_conversion: Cantidad de unidades del padre que equivalen a 1 unidad del hijo
-- Ejemplo: Si el padre es "Acetaminofen x 1 unidad" y el hijo es "Acetaminofen x 6 unidades"
-- entonces cantidad_conversion = 6 (se necesitan 6 unidades del padre para 1 hijo)
ALTER TABLE `productos` ADD COLUMN `cantidad_conversion` DECIMAL(12,2) NOT NULL DEFAULT '1.00' AFTER `producto_padre_id`;

-- =====================================================
-- PASO 2: Crear índice para mejorar consultas
-- =====================================================

ALTER TABLE `productos` ADD INDEX `idx_tipo_producto` (`tipo_producto`);
ALTER TABLE `productos` ADD INDEX `idx_producto_padre` (`producto_padre_id`);

-- =====================================================
-- PASO 3: Agregar restricción de clave foránea (opcional)
-- Esto asegura integridad referencial entre padre e hijo
-- =====================================================

-- ALTER TABLE `productos` 
-- ADD CONSTRAINT `fk_producto_padre` 
-- FOREIGN KEY (`producto_padre_id`) 
-- REFERENCES `productos`(`idproducto`) 
-- ON DELETE SET NULL ON UPDATE CASCADE;

-- =====================================================
-- PASO 4: Actualizar productos existentes como SIMPLE
-- (Esto ya está cubierto por el DEFAULT, pero por seguridad)
-- =====================================================

UPDATE `productos` SET `tipo_producto` = 'SIMPLE' WHERE `tipo_producto` IS NULL OR `tipo_producto` = '';

-- =====================================================
-- NOTAS DE IMPLEMENTACIÓN:
-- =====================================================
-- 
-- PRODUCTO SIMPLE: Comportamiento actual, maneja su propio stock
-- 
-- PRODUCTO PADRE: 
--   - Maneja el stock físico real
--   - Puede venderse directamente
--   - Recibe compras, ajustes y traspasos
--   - tipo_producto = 'PADRE'
--   - producto_padre_id = NULL
--   - cantidad_conversion = 1.00
--
-- PRODUCTO HIJO:
--   - NO maneja stock propio (existencia siempre = 0)
--   - Su existencia "virtual" = existencia_padre / cantidad_conversion
--   - Tiene sus propios precios de venta
--   - Al venderse, descuenta del stock del padre
--   - NO puede recibir compras, ajustes ni traspasos
--   - tipo_producto = 'HIJO'
--   - producto_padre_id = ID del padre
--   - cantidad_conversion = cantidad de unidades padre por 1 hijo
--
-- EJEMPLO:
--   Padre: "Acetaminofen x 1 und" (idproducto=100, existencia=120)
--   Hijo1: "Acetaminofen x 6 und" (producto_padre_id=100, cantidad_conversion=6)
--          Existencia virtual = 120/6 = 20 unidades disponibles
--   Hijo2: "Acetaminofen x 12 und" (producto_padre_id=100, cantidad_conversion=12)
--          Existencia virtual = 120/12 = 10 unidades disponibles
--
--   Si se vende 1 "Acetaminofen x 6 und":
--   - Se descuentan 6 unidades del padre
--   - Padre queda con existencia = 114
--   - Hijo1 existencia virtual = 114/6 = 19
--   - Hijo2 existencia virtual = 114/12 = 9.5 (se muestra 9)
-- =====================================================
