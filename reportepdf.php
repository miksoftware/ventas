<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();
require_once 'fpdf/pdf.php';
require_once 'fpdf/barcode.php';

$casos = [
  'PROVINCIAS'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarProvincias',
    'output'  => ['Listado de Provincias.pdf', 'I'],
  ],
  'DEPARTAMENTOS'                => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarDepartamentos',
    'output'  => ['Listado de Departamentos.pdf', 'I'],
  ],
  'DOCUMENTOS'             => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarDocumentos',
    'output'  => ['Listado de Tipos de Documentos.pdf', 'I'],
  ],
  'TIPOMONEDA'             => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarTiposMonedas',
    'output'  => ['Listado de Tipos de Moneda.pdf', 'I'],
  ],
  'TIPOCAMBIO'             => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarTiposCambio',
    'output'  => ['Listado de Tipos de Cambio.pdf', 'I'],
  ],
  'MEDIOSPAGOS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMediosPagos',
    'output'  => ['Listado de Medios de Pago.pdf', 'I'],
  ],
  'IMPUESTOS'              => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarImpuestos',
    'output'  => ['Listado de Impuestos.pdf', 'I'],
  ],
  'BANCOS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarBancos',
    'output'  => ['Listado de Bancos.pdf', 'I'],
  ],
  'FAMILIAS'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarFamilias',
    'output'  => ['Listado de Familias.pdf', 'I'],
  ],
  'SUBFAMILIAS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarSubfamilias',
    'output'  => ['Listado de Sub-Familias.pdf', 'I'],
  ],
  'MARCAS'                 => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMarcas',
    'output'  => ['Listado de Marcas.pdf', 'I'],
  ],
  'MODELOS'                => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarModelos',
    'output'  => ['Listado de Modelos.pdf', 'I'],
  ],
  'PRESENTACIONES'         => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarPresentaciones',
    'output'  => ['Listado de Presentaciones.pdf', 'I'],
  ],
  'COLORES'                => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarColores',
    'output'  => ['Listado de Colores.pdf', 'I'],
  ],
  'ORIGENES'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarOrigenes',
    'output'  => ['Listado de Origenes.pdf', 'I'],
  ],
  'IMEIS'               => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarImeis',
    'output'  => ['Listado de Imeis.pdf', 'I'],
  ],
  'SUCURSALES'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarSucursales',
    'output'  => ['Listado de Sucursales.pdf', 'I'],
  ],
  'USUARIOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarUsuarios',
    'output'  => ['Listado de Usuarios.pdf', 'I'],
  ],
  'LOGS'                   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarLogs',
    'output'  => ['Listado Logs de Acceso.pdf', 'I'],
  ],
  'CLIENTES'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarClientes',
    'output'  => ['Listado de Clientes.pdf', 'I'],
  ],
  'CLIENTESXCREDITOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarClientesxCreditos',
    'output'  => ['Listado de Creditos Activos de Clientes.pdf', 'I'],
  ],
  'PROVEEDORES'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProveedores',
    'output'  => ['Listado de Proveedores.pdf', 'I'],
  ],
  'FACTURAPEDIDO'          => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'FacturaPedido',
    'output'  => ['Factura de Pedido.pdf', 'I'],
  ],
  'PEDIDOS'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPedidos',
    'output'  => ['Listado de Pedidos.pdf', 'I'],
  ],
  'PEDIDOSXPROVEEDOR'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPedidosxProveedor',
    'output'  => ['Listado de Pedidos x Proveedor.pdf', 'I'],
  ],
  'PEDIDOSXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPedidosxFechas',
    'output'  => ['Listado de Pedidos x Fechas.pdf', 'I'],
  ],
  'PRODUCTOS'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductos',
    'output'  => ['Listado de Productos.pdf', 'I'],
  ],
  'PRODUCTOSXSUCURSAL'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosxSucursales',
    'output'  => ['Listado de Productos por Sucursal.pdf', 'I'],
  ],
  'PRODUCTOSXBUSQUEDA'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosxBusqueda',
    'output'  => ['Listado de Productos por Busqueda.pdf', 'I'],
  ],
  'STOCKOPTIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosOptimo',
    'output'  => ['Listado de Productos en Stock Optimo.pdf', 'I'],
  ],
  'STOCKMEDIO'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosMedio',
    'output'  => ['Listado de Productos en Stock Medio.pdf', 'I'],
  ],
  'STOCKMINIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosMinimo',
    'output'  => ['Listado de Productos en Stock Minimo.pdf', 'I'],
  ],
  'STOCKCERO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosCero',
    'output'  => ['Listado de Productos en Stock Cero.pdf', 'I'],
  ],
  'FECHASOPTIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosFechasOptimo',
    'output'  => ['Listado de Productos en Fechas Optimo.pdf', 'I'],
  ],
  'FECHASMEDIO'             => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosFechasMedio',
    'output'  => ['Listado de Productos en Fechas Medio.pdf', 'I'],
  ],
  'FECHASMINIMO'            => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosFechasMinimo',
    'output'  => ['Listado de Productos en Fechas Minimo.pdf', 'I'],
  ],
  'CODIGOBARRAS'           => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarCodigoBarras',
    'output'  => ['Listado de Codigo de Barras.pdf', 'I'],
  ],
  'PRODUCTOSXSUCURSALES'   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosxSucursal',
    'output'  => ['Listado de Productos.pdf', 'I'],
  ],
  'PRODUCTOSXMONEDA'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosxMoneda',
    'output'  => ['Listado de Productos por Moneda.pdf', 'I'],
  ],
  'KARDEXPRODUCTO'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexProducto',
    'output'  => ['Listado de Kardex de Producto.pdf', 'I'],
  ],
  'KARDEXPRODUCTOSVALORIZADO'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexProductosValorizado',
    'output'  => ['Listado de Kardex Productos Valorizado.pdf', 'I'],
  ],
  'PRODUCTOSVALORIZADOXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosValorizadoxFechas',
    'output'  => ['Listado de Productos Valorizado por Fechas.pdf', 'I'],
  ],
  'PRODUCTOSVENDIDOSXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarProductosVendidosxFechas',
    'output'  => ['Listado de Productos Vendidos por Fechas.pdf', 'I'],
  ],

  'TICKET_AJUSTE_8'      => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketAjuste_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Ajuste Stock.pdf', 'I'],
  ],
  'TICKET_AJUSTE_5'      => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketAjuste_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Ajuste Stock.pdf', 'I'],
  ],
  'AJUSTEPRODUCTOS'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarAjustesProductos',
    'output'  => ['Listado de Ajustes de Productos.pdf', 'I'],
  ],
  'AJUSTEPRODUCTOSXBUSQUEDA'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarAjustesProductosxBusqueda',
    'output'  => ['Listado de Ajustes Productos por Busqueda.pdf', 'I'],
  ],

  'COMBOS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombos',
    'output'  => ['Listado de Combos.pdf', 'I'],
  ],
  'COMBOSMINIMO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosMinimo',
    'output'  => ['Listado de Combos en Stock Minimo.pdf', 'I'],
  ],
  'COMBOSMAXIMO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosMaximo',
    'output'  => ['Listado de Combos en Stock Maximo.pdf', 'I'],
  ],
  'COMBOSXMONEDA'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosxMoneda',
    'output'  => ['Listado de Combos por Moneda.pdf', 'I'],
  ],
  'KARDEXCOMBO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexCombo',
    'output'  => ['Listado de Kardex de Combo.pdf', 'I'],
  ],
  'KARDEXCOMBOSVALORIZADO'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarKardexCombosValorizado',
    'output'  => ['Listado de Kardex Combos Valorizado.pdf', 'I'],
  ],
  'COMBOSVALORIZADOXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosValorizadoxFechas',
    'output'  => ['Listado de Combos Valorizado por Fechas.pdf', 'I'],
  ],
  'COMBOSVENDIDOSXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCombosVendidosxFechas',
    'output'  => ['Listado de Combos Vendidos por Fechas.pdf', 'I'],
  ],

  'TICKET_TRASPASO_8'      => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketTraspaso_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Traspaso.pdf', 'I'],
  ],
  'TICKET_TRASPASO_5'      => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketTraspaso_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Traspaso.pdf', 'I'],
  ],
  'FACTURA_TRASPASO'        => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'FacturaTraspaso',
    'output'  => ['Factura de Traspaso.pdf', 'I'],
  ],
  'TRASPASOS'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarTraspasos',
    'output'  => ['Listado de Traspasos.pdf', 'I'],
  ],
  'TRASPASOSXSUCURSAL'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarTraspasosxSucursal',
    'output'  => ['Listado de Traspasos por Sucursal.pdf', 'I'],
  ],
  'TRASPASOSXFECHAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarTraspasosxFechas',
    'output'  => ['Listado de Traspasos por Fechas.pdf', 'I'],
  ],
  'DETALLESTRASPASOSXFECHAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesTraspasosxFechas',
    'output'  => ['Listado de Detalles Traspasos por Fechas.pdf', 'I'],
  ],


  'FACTURA_COMPRA'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'FacturaCompra',
    'output'  => ['Factura de Compra.pdf', 'I'],
  ],
  'TICKET_COMPRA_8'      => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketCompra_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Compra.pdf', 'I'],
  ],
  'TICKET_COMPRA_5'      => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketCompra_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Compra.pdf', 'I'],
  ],
  'COMPRAS'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCompras',
    'output'  => ['Listado de Compras.pdf', 'I'],
  ],
  'COMPRASXBUSQUEDA'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComprasxBusqueda',
    'output'  => ['Listado de Compras.pdf', 'I'],
  ],
  'CUENTASXPAGAR'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCuentasxPagar',
    'output'  => ['Listado de Cuentas por Pagar.pdf', 'I'],
  ],
  'CUENTASXPAGARXBUSQUEDA'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCuentasxPagarxBusqueda',
    'output'  => ['Listado de Cuentas por Pagar.pdf', 'I'],
  ],
  'CUENTASXPAGARVENCIDAS'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCuentasxPagarVencidas',
    'output'  => ['Listado de Cuentas por Pagar Vencidas.pdf', 'I'],
  ],
  'COMPRASXPROVEEDOR'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComprasxProveedor',
    'output'  => ['Listado de Compras por Proveedor.pdf', 'I'],
  ],
  'COMPRASXFECHAS'         => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComprasxFechas',
    'output'  => ['Listado de Compras por Fechas.pdf', 'I'],
  ],
  'TICKET_CREDITO_COMPRA_8'           => [
    'medidas'        => ['P', 'mm', 'ticket_credito_8mm'],
    'func'           => 'TicketCreditoCompra_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Abonos en Compras.pdf', 'I'],
  ],
  'TICKET_CREDITO_COMPRA_5'           => [
    'medidas'        => ['P', 'mm', 'ticket_credito_5mm'],
    'func'           => 'TicketCreditoCompra_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Abonos en Compras.pdf', 'I'],
  ],
  'ABONOSCREDITOSCOMPRASXFECHAS'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarAbonosCreditosComprasxFechas',
    'output'  => ['Listado de Abonos Compras a Creditos por Fechas.pdf', 'I'],
  ],
  'CREDITOSCOMPRASXPROVEEDOR'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosComprasxProveedor',
    'output'  => ['Listado de Creditos por Proveedor.pdf', 'I'],
  ],
  'CREDITOSCOMPRASXFECHAS' => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosComprasxFechas',
    'output'  => ['Listado de Creditos de Compras por Fechas.pdf', 'I'],
  ],
  'DETALLESCREDITOSCOMPRASXPROVEEDOR'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosComprasxProveedor',
    'output'  => ['Listado Detalles Compras a Creditos por Proveedor.pdf', 'I'],
  ],
  'DETALLESCREDITOSCOMPRASXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosComprasxFechas',
    'output'  => ['Listado Detalles Compras a Creditos por Fechas.pdf', 'I'],
  ],


  'TICKET_COTIZACION_8'      => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketCotizacion_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Cotizacion.pdf', 'I'],
  ],
  'TICKET_COTIZACION_5'      => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketCotizacion_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Cotizacion.pdf', 'I'],
  ],
  'FACTURA_COTIZACION'      => [
    'medidas'        => ['P', 'mm', 'A4'],
    'func'           => 'FacturaCotizacion',
    'setPrintFooter' => 'true',
    'output'         => ['Factura de Cotizacion.pdf', 'I'],
  ],
  'COTIZACIONES'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCotizaciones',
    'output'  => ['Listado de Cotizaciones.pdf', 'I'],
  ],
  'COTIZACIONESXBUSQUEDA'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCotizacionesxBusqueda',
    'output'  => ['Listado de Cotizaciones.pdf', 'I'],
  ],
  'COTIZACIONESXFECHAS'    => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCotizacionesxFechas',
    'output'  => ['Listado de Cotizaciones x Fechas.pdf', 'I'],
  ],
  'COTIZACIONESXVENDEDOR'    => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCotizacionesxVendedor',
    'output'  => ['Listado de Cotizaciones x Vendedor.pdf', 'I'],
  ],
  'DETALLESCOTIZACIONESXFECHAS'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCotizacionesxFechas',
    'output'  => ['Listado de Detalles Cotizados por Fechas.pdf', 'I'],
  ],
  'DETALLESCOTIZACIONESXVENDEDOR'  => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCotizacionesxVendedor',
    'output'  => ['Listado de Detalles Cotizados por Vendedor.pdf', 'I'],
  ],


  'TICKET_PREVENTA_8'      => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketPreventa_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Preventa.pdf', 'I'],
  ],
  'TICKET_PREVENTA_5'      => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketPreventa_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Preventa.pdf', 'I'],
  ],
  'PREVENTAS'              => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPreventas',
    'output'  => ['Listado de Preventas.pdf', 'I'],
  ],
  'CLIENTESXPREVENTAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'ClientesxPreventas',
    'output'  => ['Listado de Preventas a Clientes.pdf', 'I'],
  ],
  'PREVENTASXFECHAS'       => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPreventasxFechas',
    'output'  => ['Listado de Preventas x Fechas.pdf', 'I'],
  ],
  'PREVENTASXVENDEDOR'    => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarPreventasxVendedor',
    'output'  => ['Listado de Preventas x Vendedor.pdf', 'I'],
  ],
  'DETALLESPREVENTASXFECHAS'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesPreventasxFechas',
    'output'  => ['Listado de Detalles Preventas por Fechas.pdf', 'I'],
  ],
  'DETALLESPREVENTASXVENDEDOR'     => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesPreventasxVendedor',
    'output'  => ['Listado de Detalles Preventas por Vendedor.pdf', 'I'],
  ],
  'GUIAPREVENTAXFECHAS'    => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas' => array('L', 'mm', 'LEGAL'),
    'func'           => 'GuiaPreventaxFechas',
    'setPrintFooter' => 'true',
    'output'         => ['Guia de Remision.pdf', 'I'],
  ],


  'CAJAS'                  => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarCajas',
    'output'  => ['Listado de Cajas.pdf', 'I'],
  ],
  'ARQUEOS'                => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarArqueos',
    'output'  => ['Listado de Arqueos de Cajas.pdf', 'I'],
  ],
  'TICKET_CIERRE_8'           => [
    'medidas'        => ['P', 'mm', 'ticket_cierre_8mm'],
    'func'           => 'TicketCierre_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Cierre.pdf', 'I'],
  ],
  'TICKET_CIERRE_5'           => [
    'medidas'        => ['P', 'mm', 'ticket_cierre_5mm'],
    'func'           => 'TicketCierre_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Cierre.pdf', 'I'],
  ],

  'TICKET_MOVIMIENTO_8'           => [
    'medidas'        => ['P', 'mm', 'ticket_movimiento_8mm'],
    'func'           => 'TicketMovimiento_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Movimiento.pdf', 'I'],
  ],
  'TICKET_MOVIMIENTO_5'           => [
    'medidas'        => ['P', 'mm', 'ticket_movimiento_5mm'],
    'func'           => 'TicketMovimiento_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Movimiento.pdf', 'I'],
  ],


  'MOVIMIENTOS'            => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMovimientos',
    'output'  => ['Listado de Movimientos en Caja.pdf', 'I'],
  ],
  'ARQUEOSXFECHAS'         => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarArqueosxFechas',
    'output'  => ['Listado de Arqueos por Fechas.pdf', 'I'],
  ],
  'MOVIMIENTOSXFECHAS'     => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'TablaListarMovimientosxFechas',
    'output'  => ['Listado de Movimientos por Fechas.pdf', 'I'],
  ],
  'INFORMECAJASXFECHAS'     => [
    'medidas' => ['P', 'mm', 'A4'],
    'func'    => 'InformeCajasxFechas',
    'output'  => ['Informe de Caja x Fechas.pdf', 'I'],
  ],
  'GANANCIASXFECHAS'         => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarGananciasxFechas',
    'output'  => ['Listado de Ganancias por Fechas.pdf', 'I'],
  ],

  'NOTA_VENTA_8'                 => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'NotaVenta_8',
    'setPrintFooter' => 'true',
    'output'         => ['Nota de Venta.pdf', 'I'],
  ],
  'NOTA_VENTA_5'                 => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'NotaVenta_5',
    'setPrintFooter' => 'true',
    'output'         => ['Nota de Venta.pdf', 'I'],
  ],
  'NOTA_VENTA_A4'                => [
    'medidas'        => ['P', 'mm', 'A4'],
    'func'           => 'NotaVenta_a4',
    'setPrintFooter' => 'true',
    'output'         => ['Boleta de Venta.pdf', 'I'],
  ],

  'TICKET_5'                => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketVenta_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Venta.pdf', 'I'],
  ],
  'TICKET_8'                => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketVenta_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Venta.pdf', 'I'],
  ],
  'BOLETA_A4'                => [
    'medidas'        => ['P', 'mm', 'A4'],
    'func'           => 'BoletaVenta_a4',
    'setPrintFooter' => 'true',
    'output'         => ['Boleta de Venta.pdf', 'I'],
  ],

  'FACTURA_A4'                => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas'        => ['P', 'mm', 'mitad'],
    'func'           => 'FacturaVenta_a4',
    'setPrintFooter' => 'true',
    'output'         => ['Factura de Venta.pdf', 'I'],
  ],
  'FACTURA'                => [
    'medidas'        => ['P', 'mm', 'Letter'],
    'func'           => 'FacturaVenta_Preimpresa',
    'setPrintFooter' => 'true',
    'output'         => ['Factura de Venta.pdf', 'I'],
  ],
  'GUIA_REMISION'                => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    //'medidas'        => ['P', 'mm', 'ticket'],
    'func'           => 'GuiaVenta',
    'setPrintFooter' => 'true',
    'output'         => ['Guia de Remision.pdf', 'I'],
  ],
  'VENTAS'                 => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentas',
    'output'  => ['Listado de Ventas.pdf', 'I'],
  ],
  'VENTASXBUSQUEDA'                 => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxBusqueda',
    'output'  => ['Listado de Ventas.pdf', 'I'],
  ],
  'VENTASDIARIAS'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasDiarias',
    'output'  => ['Listado de Ventas del Dia.pdf', 'I'],
  ],
  'LIBROVENTASXFECHAS'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarLibroVentasxFechas',
    'output'  => ['Libro de Ventas por Fechas.pdf', 'I'],
  ],
  'VENTASXCAJAS'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxCajas',
    'output'  => ['Listado de Ventas por Cajas.pdf', 'I'],
  ],
  'VENTASXFECHAS'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxFechas',
    'output'  => ['Listado de Ventas por Fechas.pdf', 'I'],
  ],
  'VENTASXCLIENTES'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxClientes',
    'output'  => ['Listado de Ventas por Clientes.pdf', 'I'],
  ],
  'VENTASXCONDICIONES'          => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarVentasxCondiciones',
    'output'  => ['Listado de Ventas por Formas de Pago.pdf', 'I'],
  ],
  'COMISIONXVENTAS'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarComisionxVentas',
    'output'  => ['Listado de Comisión por Ventas.pdf', 'I'],
  ],
  'VENTASGENERAL'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TicketVentasGeneral',
    'setPrintFooter' => 'true',
    'output'         => ['Ventas General.pdf', 'I'],
  ],
  'DETALLESVENTASXCONDICIONES'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TablaListarDetallesVentasxCondiciones',
    'setPrintFooter' => 'true',
    'output'         => ['Listado de Detalles Ventas por Condiciones.pdf', 'I'],
  ],
  'DETALLESVENTASXFECHAS'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TablaListarDetallesVentasxFechas',
    'output'         => ['Listado de Detalles Ventas por Fechas.pdf', 'I'],
  ],
  'DETALLESVENTASXVENDEDOR'          => [
    'medidas'        => ['L', 'mm', 'LEGAL'],
    'func'           => 'TablaListarDetallesVentasxVendedor',
    'output'         => ['Listado de Detalles Ventas por Vendedor.pdf', 'I'],
  ],

  'TICKET_CREDITO_VENTA_8'           => [
    'medidas'        => ['P', 'mm', 'ticket_credito_8mm'],
    'func'           => 'TicketCreditoVenta_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Abonos en Ventas.pdf', 'I'],
  ],
  'TICKET_CREDITO_VENTA_5'           => [
    'medidas'        => ['P', 'mm', 'ticket_credito_5mm'],
    'func'           => 'TicketCreditoVenta_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Abonos en Ventas.pdf', 'I'],
  ],
  'CREDITOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditos',
    'output'  => ['Listado Ventas a Creditos.pdf', 'I'],
  ],
  'CREDITOSXBUSQUEDA'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosxBusqueda',
    'output'  => ['Listado Ventas a Creditos.pdf', 'I'],
  ],
  'CREDITOSVENCIDOS'               => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosVencidos',
    'output'  => ['Listado Ventas a Creditos Vencidos.pdf', 'I'],
  ],
  'ABONOSCREDITOSVENTASXCAJAS'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarAbonosCreditosVentasxCajas',
    'output'  => ['Listado de Abonos Ventas a Creditos por Cajas.pdf', 'I'],
  ],
  'CREDITOSVENTASXCONDICIONES'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosVentasxCondiciones',
    'output'  => ['Listado Ventas a Creditos por Condiciones.pdf', 'I'],
  ],
  'CREDITOSVENTASXFECHAS'        => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosVentasxFechas',
    'output'  => ['Listado Ventas a Creditos por Fechas.pdf', 'I'],
  ],
  'CREDITOSVENTASXCLIENTES'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarCreditosVentasxClientes',
    'output'  => ['Listado Ventas a Creditos por Clientes.pdf', 'I'],
  ],
  'DETALLESCREDITOSVENTASXFECHAS'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosVentasxFechas',
    'output'  => ['Listado Detalles Ventas a Creditos por Fechas.pdf', 'I'],
  ],
  'DETALLESCREDITOSVENTASXCLIENTES'      => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarDetallesCreditosVentasxClientes',
    'output'  => ['Listado Detalles Ventas a Creditos por Clientes.pdf', 'I'],
  ],

  'TICKET_NOTACREDITO_8'      => [
    'medidas'        => ['P', 'mm', 'ticket_8mm'],
    'func'           => 'TicketNotaCredito_8',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Nota Credito.pdf', 'I'],
  ],
  'TICKET_NOTACREDITO_5'      => [
    'medidas'        => ['P', 'mm', 'ticket_5mm'],
    'func'           => 'TicketNotaCredito_5',
    'setPrintFooter' => 'true',
    'output'         => ['Ticket de Nota Credito.pdf', 'I'],
  ],
  'FACTURA_NOTACREDITO_A4'            => [
    'medidas'        => ['P', 'mm', 'A4'],
    //'medidas'        => ['P', 'mm', 'mitad'],
    'func'           => 'FacturaNotaCredito_a4',
    'setPrintFooter' => 'true',
    'output'         => ['Nota de Credito.pdf', 'I'],
  ],
  'NOTASCREDITO'           => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasCredito',
    'output'  => ['Listado de Notas de Creditos.pdf', 'I'],
  ],
  'NOTASCREDITOXCAJAS'   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasxCajas',
    'output'  => ['Listado de Notas de Creditos x Cajas.pdf', 'I'],
  ],
  'NOTASCREDITOXFECHAS'    => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasxFechas',
    'output'  => ['Listado de Notas de Creditos x Fechas.pdf', 'I'],
  ],
  'NOTASCREDITOXCLIENTES'   => [
    'medidas' => ['L', 'mm', 'LEGAL'],
    'func'    => 'TablaListarNotasxClientes',
    'output'  => ['Listado de Notas de Creditos x Clientes.pdf', 'I'],
  ],
];


ob_start();
$tipo      = decrypt($_GET['tipo']);
$codventa  = (isset($_GET["codventa"]) ? decrypt($_GET["codventa"]) : "");
$caso_data = $casos[$tipo];
$pdf       = new PDF_AutoPrint(
  $caso_data['medidas'][0],
  $caso_data['medidas'][1],
  $caso_data['medidas'][2]
);
if (in_array($tipo, ['TICKET_TRASPASO_8', 'TICKET_TRASPASO_5', 'TICKET_COTIZACION_8', 'TICKET_COTIZACION_5', 'TICKET_PREVENTA_8', 'TICKET_PREVENTA_5', 'TICKET_CIERRE_8', 'TICKET_CIERRE_5', 'TICKET_MOVIMIENTO_8', 'TICKET_MOVIMIENTO_5', 'NOTA_VENTA_8', 'NOTA_VENTA_5', 'BOLETA_A4', 'FACTURA_A4', 'GUIA_REMISION', 'TICKET_CREDITO_VENTA', 'TICKET_NOTACREDITO_8', 'TICKET_NOTACREDITO_5', 'FACTURA_NOTACREDITO_A4'])) {
  $pdf->AutoPrint();
} 
$pdf->AddPage();
$pdf->{$caso_data['func']}();
$pdf->Output($caso_data['output'][0], $caso_data['output'][1]);

if (in_array($tipo, ['TICKET', 'BOLETA', 'FACTURA', 'NOTA DE VENTA'])) {
//$pdf->Output("archivos/".$tipo."_".$documento.".pdf","F");
//$pdf->Output("archivos/".$tipo."_".$documento.".pdf","I");
$pdf->Output("archivos/".$codventa.".pdf","F");
$doc = "archivos/".$codventa.".pdf";

$envia = (new Login)->EnviarFacturaCorreo($codventa,$doc);

}
ob_end_flush();