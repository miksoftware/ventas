# Implementación de Productos Compuestos (Padre-Hijo)

## Descripción General

Este módulo permite crear productos tipo "HIJO" que representan diferentes presentaciones o empaques de un producto base (PADRE). Los productos HIJO no manejan stock propio, sino que su existencia se calcula automáticamente basándose en el stock del producto PADRE.

## Tipos de Productos

| Tipo | Descripción | Maneja Stock | Recibe Compras/Ajustes/Traspasos |
|------|-------------|--------------|----------------------------------|
| **SIMPLE** | Producto normal (comportamiento actual) | ✅ Sí | ✅ Sí |
| **PADRE** | Producto base que maneja el stock físico | ✅ Sí | ✅ Sí |
| **HIJO** | Presentación alternativa, stock virtual | ❌ No (calculado) | ❌ No |

## Ejemplo de Uso

**Escenario:** Medicamento Acetaminofén vendido en diferentes presentaciones

1. **Producto PADRE:** "Acetaminofén x 1 unidad"
   - Existencia real: 120 unidades
   - Precio: $1.00

2. **Producto HIJO 1:** "Acetaminofén x 6 unidades"
   - cantidad_conversion: 6
   - Existencia virtual: 120/6 = 20 cajas
   - Precio: $5.50 (precio propio)

3. **Producto HIJO 2:** "Acetaminofén x 12 unidades"
   - cantidad_conversion: 12
   - Existencia virtual: 120/12 = 10 cajas
   - Precio: $10.00 (precio propio)

**Al vender 2 cajas de "Acetaminofén x 6 unidades":**
- Se descuentan 2 × 6 = 12 unidades del PADRE
- Nuevo stock del PADRE: 108 unidades
- Nueva existencia virtual HIJO 1: 108/6 = 18 cajas
- Nueva existencia virtual HIJO 2: 108/12 = 9 cajas

## Instalación

### Paso 1: Ejecutar Script SQL

Ejecute el script `sql/productos_compuestos.sql` en su base de datos:

```sql
-- Ejecutar en phpMyAdmin o consola MySQL
SOURCE c:/laragon/www/ventas/sql/productos_compuestos.sql;
```

O copie y ejecute manualmente el contenido del archivo.

### Paso 2: Verificar Archivos Modificados

Los siguientes archivos han sido modificados:

1. **`class/class.php`**
   - `RegistrarProductos()` - Agrega campos tipo_producto, producto_padre_id, cantidad_conversion
   - `ActualizarProductos()` - Actualiza con los nuevos campos
   - `ProductosPorId()` - Incluye datos del producto padre en las consultas
   - `RegistrarVentas()` - Descuenta del PADRE cuando se vende un HIJO
   - `RegistrarCompras()` - Bloquea productos HIJO
   - `RegistrarAjusteProducto()` - Bloquea productos HIJO
   - `RegistrarTraspasos()` - Bloquea productos HIJO
   - `CalcularExistenciaVirtual()` - Nueva función para calcular stock virtual
   - `ObtenerExistenciaProducto()` - Nueva función auxiliar

2. **`forproducto.php`**
   - Nueva sección de "Configuración de Producto Compuesto"
   - Selector de tipo de producto
   - Buscador de producto padre
   - Campo de cantidad de conversión
   - JavaScript para mostrar/ocultar campos dinámicamente

3. **`modal_buscar_producto_padre.php`** (NUEVO)
   - Modal para buscar y seleccionar producto padre

## Uso del Sistema

### Crear un Producto PADRE

1. Ir a Gestión de Productos → Nuevo Producto
2. En "Tipo de Producto" seleccionar **PADRE**
3. Completar los datos normalmente
4. Guardar

### Crear un Producto HIJO

1. Ir a Gestión de Productos → Nuevo Producto
2. En "Tipo de Producto" seleccionar **HIJO**
3. Click en **"Buscar"** para seleccionar el producto PADRE
4. Ingresar la **Cantidad de Conversión** (ej: 6 si 6 unidades del padre = 1 de este producto)
5. Configurar los **precios de venta** (son independientes del padre)
6. **Nota:** La existencia se mostrará en 0.00 y estará bloqueada
7. Guardar

### Restricciones de Productos HIJO

Los productos HIJO **NO pueden**:
- ❌ Recibir compras (comprar directamente al PADRE)
- ❌ Recibir ajustes de inventario (ajustar el PADRE)
- ❌ Ser traspasados entre sucursales (traspasar el PADRE)

### Venta de Productos HIJO

Al vender un producto HIJO:
1. El sistema calcula: `cantidad_a_descontar = cantidad_vendida × cantidad_conversion`
2. Se descuenta del stock del producto PADRE
3. Se registra en el Kardex del PADRE con referencia al HIJO vendido

## Códigos de Error Nuevos

| Código | Mensaje | Ubicación |
|--------|---------|-----------|
| 7 | Producto HIJO no puede ser traspasado | Traspasos |
| 8 | Producto HIJO no puede recibir ajustes | Ajustes de Inventario |
| 16 | Producto HIJO no puede recibir compras | Compras |
| 20 | Stock insuficiente en producto PADRE para venta de HIJO | Ventas |

## Campos de Base de Datos

```sql
-- Nuevos campos en tabla `productos`
tipo_producto ENUM('SIMPLE', 'PADRE', 'HIJO') DEFAULT 'SIMPLE'
producto_padre_id INT(11) NULL
cantidad_conversion DECIMAL(12,2) DEFAULT '1.00'
```

## Notas Técnicas

### Cálculo de Existencia Virtual

Para productos HIJO, la existencia se calcula como:
```
existencia_virtual = FLOOR(existencia_padre / cantidad_conversion)
```

### Kardex

- El Kardex se registra **solo** en el producto que maneja el stock (PADRE)
- El documento incluye referencia al producto HIJO vendido
- Formato: `"VENTA: F001-00001 (HIJO: COD-HIJO x 2)"`

### Migración de Datos

- Todos los productos existentes quedan automáticamente como tipo **SIMPLE**
- No se requiere migración adicional
- El sistema es 100% retrocompatible

## Troubleshooting

### Error al guardar producto HIJO
- Verificar que se ha seleccionado una sucursal primero
- Verificar que el producto padre existe y es tipo SIMPLE o PADRE

### Existencia virtual incorrecta
- Verificar que el campo `cantidad_conversion` tiene el valor correcto
- Verificar que el producto padre tiene stock disponible

### No aparece la sección de productos compuestos
- Limpiar caché del navegador
- Verificar que se ejecutó correctamente el SQL

## Contacto

Para soporte técnico, contactar al desarrollador del sistema.
