<?php
require_once("class/class.php");
header('Content-Type: application/json');

######################## GRAFICO POR SUCURSALES ########################
if (isset($_GET['ProcesosxSucursales'])):

$grafico = new Login();
$reg = $grafico->GraficoxSucursal();

$data = array();
if (is_array($reg)) {

	foreach ($reg as $row) {
		$data[] = $row;
	}
}
echo json_encode($data);

endif;
######################## GRAFICO POR SUCURSALES ########################

######################## GRAFICO POR VENTAS DIARIAS ########################
if (isset($_GET['ProcesosxVentasDiarias'])):

$grafico = new Login();
$reg = $grafico->GraficoxVentasDiarias();

$data = array();
if (is_array($reg)) {

	foreach ($reg as $row) {
		$data[] = $row;
	}
}
echo json_encode($data);

endif;
######################## GRAFICO POR VENTAS DIARIAS ########################

######################## GRAFICO PRODUCTOS MAS VENDIDOS ########################
if (isset($_GET['ProductosVendidos'])):

$prod = new Login();
$p = $prod->ProductosMasVendidos();

$data = array();
if (is_array($p)) {

	foreach ($p as $row) {
		$data[] = $row;
	}
}
echo json_encode($data);

endif;
######################## GRAFICO PRODUCTOS MAS VENDIDOS ########################

######################## GRAFICO VENTAS POR USUARIOS ########################
if (isset($_GET['VentasxUsuarios'])):

$user = new Login();
$u = $user->VentasxUsuarios();

$data = array();
if (is_array($u)) {

	foreach ($u as $row) {
		$data[] = $row;
	}
}
echo json_encode($data);

endif;
######################## GRAFICO VENTAS POR USUARIOS ########################

######################## GRAFICO COMPRAS POR PROVEEDOR ########################
if (isset($_GET['ComprasxProveedor'])):

$prov = new Login();
$p = $prov->ComprasxProveedores();

$data = array();
if (is_array($p)) {

	foreach ($p as $row) {
		$data[] = $row;
	}
}
echo json_encode($data);

endif;
######################## GRAFICO COMPRAS POR PROVEEDOR ########################
?>