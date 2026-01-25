-- =====================================================
-- SCRIPT PARA CORREGIR CONSECUTIVOS DE FACTURAS
-- Ejecutar en producción con cuidado
-- =====================================================

-- PASO 1: Ver el estado actual (ejecutar primero para diagnosticar)
SELECT 
    idventa,
    codfactura,
    tipodocumento,
    CAST(SUBSTRING_INDEX(codfactura, '-', -1) AS UNSIGNED) as consecutivo_actual
FROM ventas 
WHERE codfactura LIKE 'NV%' 
AND codsucursal = 1
ORDER BY idventa DESC
LIMIT 20;

-- PASO 2: Encontrar el consecutivo máximo correcto (antes del reinicio)
-- Según tu imagen, el máximo correcto era 44 (NV0001-000000044)
SELECT MAX(CAST(SUBSTRING_INDEX(codfactura, '-', -1) AS UNSIGNED)) as max_consecutivo 
FROM ventas 
WHERE codfactura LIKE 'NV%' 
AND codsucursal = 1
AND idventa <= 45;  -- Ajustar este ID según donde empezó el problema

-- =====================================================
-- PASO 3: ACTUALIZAR LOS CONSECUTIVOS INCORRECTOS
-- =====================================================
-- Este UPDATE corrige las facturas que se reiniciaron a 01, 02, etc.
-- Basado en tu imagen: idventa 46 tiene 01, debería ser 45
-- idventa 47 tiene 01, debería ser 46, etc.

-- Primero creamos una variable para el offset
SET @nuevo_consecutivo = 44;  -- El último consecutivo correcto

-- Actualizar cada registro afectado
-- NOTA: Ajusta el WHERE según los IDs que necesites corregir
UPDATE ventas 
SET codfactura = CONCAT(
    SUBSTRING_INDEX(codfactura, '-', 1),  -- Mantiene el prefijo (NV0001)
    '-',
    LPAD(@nuevo_consecutivo := @nuevo_consecutivo + 1, 9, '0')  -- Nuevo consecutivo con padding
)
WHERE idventa >= 46  -- Desde donde empezó el problema
AND codfactura LIKE 'NV%'
AND codsucursal = 1
ORDER BY idventa ASC;

-- =====================================================
-- PASO 4: VERIFICAR LA CORRECCIÓN
-- =====================================================
SELECT 
    idventa,
    codfactura,
    tipodocumento,
    CAST(SUBSTRING_INDEX(codfactura, '-', -1) AS UNSIGNED) as consecutivo
FROM ventas 
WHERE codfactura LIKE 'NV%' 
AND codsucursal = 1
ORDER BY idventa DESC
LIMIT 20;
