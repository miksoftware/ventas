-- =====================================================
-- Script para agregar soporte de productos tipo servicio
-- (productos que no manejan inventario)
-- Fecha: 2026-01-24
-- =====================================================

-- Agregar campo usa_inventario a la tabla productos
-- SI = producto normal con inventario
-- NO = servicio sin inventario (no valida existencia, no registra kardex)
ALTER TABLE productos 
ADD COLUMN usa_inventario ENUM('SI', 'NO') NOT NULL DEFAULT 'SI' 
AFTER cantidad_conversion;

-- Índice para mejorar consultas
ALTER TABLE productos ADD INDEX idx_usa_inventario (usa_inventario);

-- =====================================================
-- NOTAS DE IMPLEMENTACIÓN:
-- 
-- 1. Cuando usa_inventario = 'NO':
--    - No se valida existencia al vender
--    - No se descuenta stock al vender
--    - No se registra movimiento en kardex
--    - Los campos de stock se ocultan en el formulario
--
-- 2. Los productos existentes quedan con usa_inventario = 'SI'
--    por defecto, sin afectar su funcionamiento actual.
-- =====================================================
