<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();

$tra  = new Login();
$tipo = decrypt($_GET['tipo']);

switch($tipo)
{
	
case 'ESTADOUSUARIO':
$tra->EstadoUsuarios();
break;

case 'USUARIOS':
$tra->EliminarUsuarios();
break;

case 'PROVINCIAS':
$tra->EliminarProvincias();
break;

case 'DEPARTAMENTOS':
$tra->EliminarDepartamentos();
break;

case 'DOCUMENTOS':
$tra->EliminarDocumentos();
break;

case 'TIPOMONEDA':
$tra->EliminarTipoMoneda();
break;

case 'TIPOCAMBIO':
$tra->EliminarTipoCambio();
break;

case 'MEDIOSPAGOS':
$tra->EliminarMediosPagos();
break;

case 'IMPUESTOS':
$tra->EliminarImpuestos();
break;

case 'BANCOS':
$tra->EliminarBancos();
break;

case 'FAMILIAS':
$tra->EliminarFamilias();
break;

case 'SUBFAMILIAS':
$tra->EliminarSubfamilias();
break;

case 'MARCAS':
$tra->EliminarMarcas();
break;

case 'MODELOS':
$tra->EliminarModelos();
break;

case 'PRESENTACIONES':
$tra->EliminarPresentaciones();
break;

case 'COLORES':
$tra->EliminarColores();
break;

case 'ORIGENES':
$tra->EliminarOrigenes();
break;

case 'IMEI':
$tra->EliminarImei();
break;

case 'ESTADOIMEI':
$tra->EstadoImei();
break;

case 'ESTADOSUCURSAL':
$tra->EstadoSucursales();
break;

case 'SUCURSALES':
$tra->EliminarSucursales();
break;

case 'CLIENTES':
$tra->EliminarClientes();
break;

case 'PROVEEDORES':
$tra->EliminarProveedores();
break;

case 'PEDIDOS':
$tra->EliminarPedidos();
break;

case 'DETALLEPEDIDO':
$tra->EliminarDetallesPedidos();
break;

case 'PRODUCTOS':
$tra->EliminarProductos();
break;

case 'COMBOS':
$tra->EliminarCombos();
break;

case 'ELIMINADETALLECOMBO':
$tra->EliminarDetalleCombo();
break;

case 'TRASPASOS':
$tra->EliminarTraspasos();
break;

case 'DETALLETRASPASO':
$tra->EliminarDetallesTraspasos();
break;

case 'COMPRAS':
$tra->EliminarCompras();
break;

case 'PAGARFACTURA':
$tra->PagarCompras();
break;

case 'DETALLECOMPRA':
$tra->EliminarDetallesCompras();
break;

case 'COTIZACIONES':
$tra->EliminarCotizaciones();
break;

case 'DETALLECOTIZACION':
$tra->EliminarDetallesCotizaciones();
break;

case 'PREVENTAS':
$tra->EliminarPreventas();
break;

case 'DETALLEPREVENTA':
$tra->EliminarDetallesPreventas();
break;

case 'CAJAS':
$tra->EliminarCajas();
break;

case 'MOVIMIENTOS':
$tra->EliminarMovimientos();
break;

case 'PENDIENTES':
$tra->EliminarFacturasPendientes();
break;

case 'DETALLEPENDIENTE':
$tra->EliminarDetallesFacturasPendientes();
break;

case 'VENTAS':
$tra->EliminarVentas();
break;

case 'DETALLEVENTA':
$tra->EliminarDetallesVentas();
break;
}
?>