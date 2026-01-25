-- =====================================================
-- Script SQL para agregar campos de Comisión por Venta
-- Fecha: 06-01-2026
-- Descripción: Agrega campos tipo_comision y comision_venta a la tabla productos
-- =====================================================

-- Agregar la columna tipo_comision a la tabla productos
-- Define si la comisión es por porcentaje o valor fijo
ALTER TABLE productos 
ADD COLUMN tipo_comision VARCHAR(20) NOT NULL DEFAULT 'NINGUNA' 
COMMENT 'Tipo de comisión: NINGUNA, PORCENTAJE o VALOR'
AFTER descproducto;

-- Agregar la columna comision_venta a la tabla productos
-- El campo almacena el valor de comisión (porcentaje o valor fijo según tipo_comision)
ALTER TABLE productos 
ADD COLUMN comision_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00 
COMMENT 'Valor de comisión por venta del producto (porcentaje o valor fijo)'
AFTER tipo_comision;

-- =====================================================
-- NOTAS:
-- - tipo_comision puede ser: 'NINGUNA', 'PORCENTAJE' o 'VALOR'
-- - comision_venta es DECIMAL(10,2) para almacenar valores con 2 decimales
-- - Si tipo_comision = 'PORCENTAJE': comision_venta representa % (ej: 5.00 = 5%)
-- - Si tipo_comision = 'VALOR': comision_venta es el monto fijo en moneda
-- - IMPORTANTE: Si tipo_comision = 'VALOR', el valor no puede ser mayor al precio de venta
-- 
-- Si necesitas verificar que se agregó correctamente:
-- DESCRIBE productos;
-- 
-- Para ver el tipo y valor de comisión de todos los productos:
-- SELECT codproducto, producto, tipo_comision, comision_venta FROM productos;
--
-- Ejemplo de consulta para calcular comisión de una venta según el tipo:
-- SELECT p.producto, dv.cantidad, dv.precioventa, p.tipo_comision, p.comision_venta,
--        CASE 
--          WHEN p.tipo_comision = 'PORCENTAJE' THEN (dv.cantidad * dv.precioventa * p.comision_venta / 100)
--          WHEN p.tipo_comision = 'VALOR' THEN (dv.cantidad * p.comision_venta)
--          ELSE 0
--        END as comision_calculada
-- FROM detalleventas dv
-- INNER JOIN productos p ON dv.codproducto = p.codproducto
-- =====================================================
