-- =====================================================
-- Script SQL para agregar campo de Comisión por Venta
-- Fecha: 06-01-2026
-- Descripción: Agrega el campo comision_venta a la tabla productos
-- =====================================================

-- Agregar la columna comision_venta a la tabla productos
-- El campo almacena el porcentaje de comisión por venta del producto
ALTER TABLE productos 
ADD COLUMN comision_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00 
COMMENT 'Porcentaje de comisión por venta del producto'
AFTER descproducto;

-- =====================================================
-- NOTAS:
-- - El campo es de tipo DECIMAL(10,2) para almacenar porcentajes con 2 decimales
-- - El valor por defecto es 0.00 (sin comisión)
-- - Se ubica después del campo descproducto para mantener orden lógico
-- - El valor representa un porcentaje (ej: 5.00 = 5%)
-- 
-- Si necesitas verificar que se agregó correctamente:
-- DESCRIBE productos;
-- 
-- Para ver el valor de comisión de todos los productos:
-- SELECT codproducto, producto, comision_venta FROM productos;
--
-- Ejemplo de consulta para calcular comisión de una venta:
-- SELECT p.producto, dv.cantidad, dv.precioventa, 
--        (dv.cantidad * dv.precioventa * p.comision_venta / 100) as comision_calculada
-- FROM detalleventas dv
-- INNER JOIN productos p ON dv.codproducto = p.codproducto
-- =====================================================
