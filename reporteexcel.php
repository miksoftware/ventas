<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();

###################### DETALLE DE SESSION SUCURSAL ######################
$bod         = new Login();
$bod         = $bod->SucursalesSessionPorId();
$simbolo     = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$bod[0]['simbolo']."</strong>");
###################### DETALLE DE SESSION SUCURSAL ######################

###################### DETALLE DE IMPUESTO ######################
$imp           = new Login();
$imp           = $imp->ImpuestosPorId();
$NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
###################### DETALLE DE IMPUESTO ######################

$tipo = decrypt($_GET['tipo']);
$documento = decrypt($_GET['documento']);
$extension = $documento == 'EXCEL' ? '.xls' : '.doc';

switch($tipo){
################################## MODULO DE USUARIOS ##################################

case 'USUARIOS': 

$tra = new Login();
$reg = $tra->ListarUsuarios();

$archivo = str_replace(" ", "_","LISTADO DE USUARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($_SESSION['acceso'] == "administradorG" ? "11" : "10"); ?>">REPORTE GENERAL DE USUARIOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE DOCUMENTO</th>
    <th>NOMBRES Y APELLIDOS</th>
    <?php if($documento == "EXCEL"){ ?>
    <th>SEXO</th>
    <th>DIRECCIÓN DOMICILIARIA</th>
    <th>Nº DE TELEFÓNO</th>
    <th>CORREO ELECTRONICO</th>
    <?php } ?>
    <th>USUARIO</th>
    <th>NIVEL</th>
    <th>ESTADO</th>
    <?php if ($_SESSION['acceso'] == "administradorG") { ?>
    <th>SUCURSAL</th>
    <?php } ?>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <?php if ($documento == "EXCEL"){ ?>
    <td><?php echo $reg[$i]['sexo']; ?></td>
    <td><?php echo $reg[$i]['direccion']; ?></td>
    <td><?php echo $reg[$i]['telefono']; ?></td>
    <td><?php echo $reg[$i]['email']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['usuario']; ?></td>
    <td><?php echo $reg[$i]['nivel']; ?></td>
    <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
    <?php if($_SESSION['acceso'] == "administradorG"){ ?>
    <td><?php echo $reg[$i]['nivel'] == 'ADMINISTRADOR(A) GENERAL' ? "*********" : $reg[$i]['nomsucursal']; ?></td>
    <?php } ?>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'LOGS': 

$archivo = str_replace(" ", "_","LISTADO LOGS DE ACCESO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="6">REPORTE GENERAL DE HISTORIAL DE ACCESO</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>IP EQUIPO</th>
    <th>TIEMPO DE ENTRADA</th>
    <th>NAVEGADOR DE ACCESO</th>
    <th>PÁGINAS DE ACCESO</th>
    <th>USUARIOS</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarLogs();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['ip']; ?></td>
    <td><?php echo $reg[$i]['tiempo']; ?></td>
    <td><?php echo $reg[$i]['detalles']; ?></td>
    <td><?php echo $reg[$i]['paginas']; ?></td>
    <td><?php echo $reg[$i]['usuario']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;
################################ MODULO DE USUARIOS ##############################





############################### MODULO DE CONFIGURACIONES ###############################
case 'PROVINCIAS': 

$archivo = str_replace(" ", "_","LISTADO DE PROVINCIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE PROVINCIAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PROVINCIA</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarProvincias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['id_provincia']; ?></td>
    <td><?php echo $reg[$i]['provincia']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'DEPARTAMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DEPARTAMENTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="4">REPORTE GENERAL DE DEPARTAMENTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PROVINCIA</th>
    <th>NOMBRE DE DEPARTAMENTO</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarDepartamentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['id_departamento']; ?></td>
    <td><?php echo $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['departamento']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'DOCUMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DOCUMENTOS TRIBUTARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE TIPOS DOCUMENTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>NOMBRE DE DOCUMENTO</th>
    <th>DESCRIPCIÓN DE DOCUMENTO</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarDocumentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['descripcion']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'TIPOMONEDA': 

$archivo = str_replace(" ", "_","LISTADO DE TIPOS DE MONEDA");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="4">REPORTE GENERAL DE TIPOS DE MONEDA</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>NOMBRE DE MONEDA</th>
    <th>SIGLAS</th>
    <th>SIMBOLO</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarTipoMoneda();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['moneda']; ?></td>
    <td><?php echo $reg[$i]['siglas']; ?></td>
    <td><?php echo $reg[$i]['simbolo']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'TIPOCAMBIO':

$tra = new Login();
$reg = $tra->ListarTipoCambio(); 

$archivo = str_replace(" ", "_","LISTADO DE TIPO CAMBIO DE MONEDA EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="5">REPORTE GENERAL DE TIPOS DE CAMBIO</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DESCRIPCIÓN DE CAMBIO</th>
    <th>MONTO DE CAMBIO</th>
    <th>TIPO DE MONEDA</th>
    <th>FECHA DE INGRESO</th>
  </tr>
<?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
    <td><?php echo $reg[$i]['montocambio']; ?></td>
    <td><?php echo $reg[$i]['moneda']."/".$reg[$i]['siglas']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacambio'])); ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'MEDIOSPAGOS':

$tra = new Login();
$reg = $tra->ListarMediosPagos();

$archivo = str_replace(" ", "_","LISTADO DE FORMAS DE PAGOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");  
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE FORMAS DE PAGOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE MEDIO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmediopago']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'IMPUESTOS': 

$tra = new Login();
$reg = $tra->ListarImpuestos();

$archivo = str_replace(" ", "_","LISTADO DE IMPUESTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="5">REPORTE GENERAL DE IMPUESTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>NOMBRE DE IMPUESTO</th>
    <th>VALOR(%)</th>
    <th>STATUS</th>
    <th>REGISTRO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
    <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
    <td><?php echo $reg[$i]['statusimpuesto']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaimpuesto'])); ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'BANCOS':

$tra = new Login();
$reg = $tra->ListarBancos(); 

$archivo = str_replace(" ", "_","LISTADO DE BANCOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE BANCOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE BANCO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codbanco']; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'BANCOS':

$tra = new Login();
$reg = $tra->ListarBancos(); 

$archivo = str_replace(" ", "_","LISTADO DE BANCOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>NOMBRE DE BANCO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codbanco']; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'FAMILIAS': 

$tra = new Login();
$reg = $tra->ListarFamilias();

$archivo = str_replace(" ", "_","LISTADO DE FAMILIAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE FAMIIAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE FAMILIA</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codfamilia']; ?></td>
      <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'SUBFAMILIAS': 

$tra = new Login();
$reg = $tra->ListarSubfamilias();

$archivo = str_replace(" ", "_","LISTADO DE SUBFAMILIAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="4">REPORTE GENERAL DE SUBFAMILIAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE FAMILIA</th>
    <th>NOMBRE DE SUB-FAMILIA</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codsubfamilia']; ?></td>
      <td><?php echo $reg[$i]['nomfamilia']; ?></td>
      <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'MARCAS':

$tra = new Login();
$reg = $tra->ListarMarcas(); 

$archivo = str_replace(" ", "_","LISTADO DE MARCAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE MARCAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE MARCA</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmarca']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'MODELOS': 
 
$tra = new Login();
$reg = $tra->ListarModelos();

$archivo = str_replace(" ", "_","LISTADO DE MODELOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="4">REPORTE GENERAL DE MODELOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>NOMBRE DE MARCA</th>
      <th>NOMBRE DE MODELO</th>
    </tr>
<?php
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codmodelo']; ?></td>
      <td><?php echo $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['nommodelo']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'PRESENTACIONES':

$tra = new Login();
$reg = $tra->ListarPresentaciones(); 

$archivo = str_replace(" ", "_","LISTADO DE PRESENTACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE PRESENTACIONES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PRESENTACIÓN</th>
  </tr>
<?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codpresentacion']; ?></td>
    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;

case 'COLORES': 

$tra = new Login();
$reg = $tra->ListarColores();

$archivo = str_replace(" ", "_","LISTADO DE COLORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE COLORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>NOMBRE DE COLOR</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codcolor']; ?></td>
      <td><?php echo $reg[$i]['nomcolor']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'ORIGENES': 

$tra = new Login();
$reg = $tra->ListarOrigenes();

$archivo = str_replace(" ", "_","LISTADO DE ORIGENES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">REPORTE GENERAL DE ORIGENES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>NOMBRE DE ORIGEN</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codorigen']; ?></td>
      <td><?php echo $reg[$i]['nomorigen']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'IMEIS': 

$tra = new Login();
$reg = $tra->ListarImei();

$archivo = str_replace(" ", "_","LISTADO DE IMEIS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="4">REPORTE GENERAL DE IMEIS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
      <th>Nº</th>
      <th>Nº DE IMEI</th>
      <th>OBSERVACIONES</th>
      <th>ESTADO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['numeroimei']; ?></td>
    <td><?php echo $observaciones = ($reg[$i]['observaciones'] == "" ? "********" : $reg[$i]['observaciones']); ?></td>
    <td><?php
    $estado = $reg[$i]["estadoimei"];        
    if ($estado == 1) {
        echo "ACTIVO";
    } elseif ($estado == 2) {
        echo "INACTIVO";
    } elseif ($estado == 3) {
        echo "VENDIDO";
    } elseif ($estado == 4) {
        echo "PENDIENTE";
    }
    ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CONFIGURACIONES ##############################




############################### MODULO DE SUCURSALES ###############################
case 'SUCURSALES': 

$archivo = str_replace(" ", "_","LISTADO DE SUCURSALES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "24" : "8"); ?>">REPORTE GENERAL DE SUCURSALES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE SUCURSAL</th>
    <th>Nº DE DOCUMENTO</th>
    <th>NOMBRE DE SUCURSAL</th>
    <th>DEPARTAMENTO</th>
    <th>PROVINCIA</th>
    <th>DIRECCIÓN</th>
    <th>CORREO ELECTRONICO</th>
    <th>Nº DE TELÉFONO</th>
    <th>Nº DE ACTIVIDAD</th>
    <th>Nº DE TICKET</th>
    <th>Nº FACTURA</th>
    <th>Nº NOTA DE VENTA</th>
    <th>Nº NOTA DE CRÉDITO</th>
    <th>FECHA DE AUTORIZACIÓN</th>
    <th>LLEVA CONTABILIDAD</th>
    <th>DESCUENTO GLOBAL</th>
    <th>MONEDA NACIONAL</th>
    <th>MONEDA CAMBIO</th>
    <th>INTERVALO DE CONSULTA</th>
    <th>Nº DOC. ENCARGADO</th>
    <th>NOMBRE DE ENCARGADO</th>
    <th>Nº DE TELÉFONO ENCARGADO</th>
    <th>ESTADO</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarSucursales();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['nrosucursal']; ?></td>
    <td><?php echo $reg[$i]['documento'].": ".$reg[$i]['cuitsucursal']; ?></td>
    <td><?php echo $reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['direcsucursal']; ?></td>
    <td><?php echo $reg[$i]['correosucursal']; ?></td>
    <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['nroactividadsucursal']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['inicioticket']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['iniciofactura']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['inicionotaventa']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['inicionotacredito']; ?></td>
    <td><?php echo $reg[$i]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechaautorsucursal'])); ?></td>
    <td><?php echo $reg[$i]['descsucursal']; ?></td>
    <td><?php echo $reg[$i]['llevacontabilidad']; ?></td>
    <td><?php echo $reg[$i]['codmoneda'] == '0' ? "*********" : $reg[$i]['moneda']; ?></td>
    <td><?php echo $reg[$i]['codmoneda2'] == '0' ? "*********" : $reg[$i]['moneda2']; ?></td>
    <td><?php echo $reg[$i]['intervalo']; ?></td>
    <td><?php echo $reg[$i]['documento2'].": ".$reg[$i]['dniencargado']; ?></td>
    <td><?php echo $reg[$i]['nomencargado']; ?></td>
    <td><?php echo $reg[$i]['tlfencargado'] == '' ? "*********" : $reg[$i]['tlfencargado']; ?></td>
    <td><?php echo $estado = ($reg[$i]['estado'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
  </tr>
<?php } } ?>
</table>
<?php
break;
############################### MODULO DE SUCURSALES ###############################









############################### MODULO DE CLIENTES ###################################
case 'CLIENTES': 

$tra = new Login();
$reg = $tra->ListarClientes();

$archivo = str_replace(" ", "_","LISTADO DE CLIENTES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "6"); ?>">REPORTE GENERAL DE CLIENTES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
      <th>Nº</th>
      <th>TIPO CLIENTE</th>
      <th>TIPO DE DOCUMENTO</th>
      <th>Nº DE DOCUMENTO</th>
      <th>NOMBRES Y APELLIDOS</th>
      <th>Nº DE TELÉFONO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>PROVINCIA</th>
      <th>DEPARTAMENTO</th>
      <th>DIRECCIÓN DOMICILIARIA</th>
      <th>CORREO ELECTRONICO</th>
      <?php } ?>
      <th>LIMITE DE CRÉDITO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['tipocliente']; ?></td>
    <td><?php echo $reg[$i]['documcliente'] == '0' ? "******" : $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']); ?></td>
    <td><?php echo $reg[$i]['tlfcliente'] == '' ? "******" : $reg[$i]['tlfcliente']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['id_provincia'] == '0' ? "******" : $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['id_departamento'] == '0' ? "******" : $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['direccliente']; ?></td>
    <td><?php echo $reg[$i]['emailcliente'] == '' ? "******" : $reg[$i]['emailcliente']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['limitecredito'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CLIENTES ###################################









############################### MODULO DE PROVEDORES ###################################
case 'PROVEEDORES':

$tra = new Login();
$reg = $tra->ListarProveedores(); 

$archivo = str_replace(" ", "_","LISTADO DE PROVEDORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE PROVEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>TIPO DE DOCUMENTO</th>
    <th>Nº DE DOCUMENTO</th>
    <th>NOMBRE DE PROVEEDOR</th>
    <th>Nº DE TELÉFONO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DEPARTAMENTO</th>
    <th>PROVINCIA</th>
    <th>DIRECCIÓN DOMICILIARIA</th>
    <th>CORREO ELECTRONICO</th>
    <?php } ?>
    <th>VENDEDOR</th>
    <th>Nº DE TELÉFONO</th>
    <th>FECHA INGRESO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['documproveedor'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['direcproveedor'] == '' ? "*********" : $reg[$i]['direcproveedor']; ?></td>
    <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['vendedor']; ?></td>
    <td><?php echo $reg[$i]['tlfvendedor']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaingreso'])); ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;
############################### MODULO DE PROVEDORES ###################################










################################ MODULO DE PEDIDOS A PROVEEDORES #################################
case 'PEDIDOS':

$tra = new Login();
$reg = $tra->ListarPedidos(); 

$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "10" : "7"); ?>">REPORTE GENERAL DE PEDIDOS A PROVEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>FECHA DE EMISIÓN</th>   
    <th>OBSERVACIONES</th>       
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>  
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
  <td><?php echo $a++; ?></td>
  <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</strong>"; ?></td>
  <td><?php echo $observaciones = ($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><?php echo$simbolo. number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <?php } ?>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
  <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
  <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
  <?php } ?>
  <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PEDIDOSXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarPedidosxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "9" : "6"); ?>">REPORTE GENERAL DE PEDIDOS POR PROVEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>FECHA DE EMISIÓN</th>   
    <th>OBSERVACIONES</th>       
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>  
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
  <td><?php echo $a++; ?></td>
  <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</strong>"; ?></td>
  <td><?php echo $observaciones = ($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><?php echo$simbolo. number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <?php } ?>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
  <?php echo $documento == "EXCEL" ? '<td colspan="4"></td>' : '<td colspan="4"></td>'; ?>
  <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
  <?php } ?>
  <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PEDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarPedidosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "10" : "7"); ?>">REPORTE GENERAL DE PEDIDOS A PROVEEDORES POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>FECHA DE EMISIÓN</th>   
    <th>OBSERVACIONES</th>       
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>  
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
  <td><?php echo $a++; ?></td>
  <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</strong>"; ?></td>
  <td><?php echo $observaciones = ($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><?php echo$simbolo. number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <?php } ?>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
  <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
  <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
  <?php } ?>
  <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
################################ MODULO DE PEDIDOS A PROVEEDORES #################################















################################# MODULO DE SERVICIOS ################################
case 'SERVICIOS':

$tra = new Login();
$reg = $tra->ListarServicios(); 

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS DE (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="8">REPORTE GENERAL DE SERVICIOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE SERVICIO</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>ESTADO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ','));
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codservicio']; ?></td>
    <td><?php echo $reg[$i]['servicio']; ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivaservicio'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descservicio'], 2, '.', ','); ?></td>
    <?php if($reg[$i]['status'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">ACTIVO</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">INACTIVO</td>
    <?php } ?>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'SERVICIOSCSV': 

$tra = new Login();
$reg = $tra->ListarServicios();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS DE (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>DESCRIPCIÓN DE SERVICIO</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>ESTADO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $reg[$i]['servicio']; ?></td>
    <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioventa'], 2, '.', ''); ?></td>
    <td><?php echo $reg[$i]['ivaservicio']; ?></td>
    <td><?php echo number_format($reg[$i]['descservicio'], 2, '.', ''); ?></td>
    <td><?php echo $reg[$i]['status']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'SERVICIOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");

$tra = new Login();
$reg = $tra->ListarServicios();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y MONEDA ".$cambio[0]['moneda'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="10">REPORTE GENERAL DE SERVICIOS POR MONEDA (<?php echo $cambio[0]['moneda']; ?>) AL CAMBIO (<?php echo number_format($cambio[0]['montocambio'], 2, '.', ','); ?>)</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE SERVICIO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>ESTADO</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>PRECIO COMPRA <?php echo $cambio[0]['siglas']; ?></th>
    <th>PRECIO VENTA <?php echo $cambio[0]['siglas']; ?></th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra       = 0;
$TotalVenta        = 0;
$TotalMonedaCompra = 0;
$TotalMonedaVenta  = 0; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo  = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong> "); 

$TotalCompra       += number_format($reg[$i]['preciocompra'], 2, '.', ',');
$TotalVenta        += number_format($reg[$i]['precioventa'], 2, '.', '');

$TotalMonedaCompra += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
$TotalMonedaVenta  += number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', '');
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codservicio']; ?></td>
    <td><?php echo $reg[$i]['servicio']; ?></td>
    <td><?php echo $reg[$i]['ivaservicio'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descservicio'], 2, '.', ','); ?></td>
    <?php if($reg[$i]['status'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">ACTIVO</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">INACTIVO</td>
    <?php } ?>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="6"></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******"); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ',') : "******"); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaVenta, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'KARDEXSERVICIOS':

$detalle = new Login();
$detalle = $detalle->DetalleKardexServicio();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexServicio();

$archivo = str_replace(" ", "_","KARDEX DEL SERVICIO (".portales($detalle[0]['servicio'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE KARDEX DE SERVICIOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>REALIZADO POR</th>
    <th>MOVIMIENTO</th>
    <th>ENTRADAS</th>
    <th>SALIDAS</th>
    <th>DEVOLUCIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <th>PRECIO</th>
    <th>COSTO</th>
    <?php } ?>
    <th>DOCUMENTO</th>
    <th>FECHA KARDEX</th>
  </tr>
<?php 
if($kardex==""){
echo "";      
} else {

$TotalEntradas   = 0;
$TotalSalidas    = 0;
$TotalDevolucion = 0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>");

$TotalEntradas   += $kardex[$i]['entradas'];
$TotalSalidas    += $kardex[$i]['salidas'];
$TotalDevolucion += $kardex[$i]['devolucion'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
    <td><?php echo $kardex[$i]['movimiento']; ?></td>
    <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
    <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
    <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
    <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
    <?php } else { ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
    <?php } ?>
    <?php } ?>
    <td><?php echo $kardex[$i]['documento']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($kardex[$i]['fechakardex']))."<br><strong>".date("H:i:s",strtotime($kardex[$i]['fechakardex']))."</strong>"; ?></td>
  </tr>
  <?php } } ?>
</table>
<strong>DETALLE DE SERVICIO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $detalle[0]['codservicio']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['servicio']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "******"); ?><br>
<strong>PRECIO VENTA:</strong> <?php echo $simbolo.number_format($detalle[0]['precioventa'], 2, '.', ','); ?>
<?php
break;

case 'SERVICIOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarServiciosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE KARDEX SERVICIOS VALORIZADO POR FECHAS ( DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="11">REPORTE GENERAL DE KARDEX SERVICIOS VALORIZADO POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE SERVICIO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioCompraTotal    = 0;
$PrecioVentaTotal     = 0;
$VendidosTotal        = 0;
$ImpuestosCompraTotal = 0;
$ImpuestosVentaTotal  = 0;
$CompraTotal          = 0;
$VentaTotal           = 0;
$TotalGanancia        = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal     += $reg[$i]['preciocompra'];
$PrecioVentaTotal      += $reg[$i]['precioventa'];
$VendidosTotal         += $reg[$i]['cantidad'];

$Descuento             = $reg[$i]['descproducto']/100;
$PrecioDescuento       = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal           = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorIva = 1 + ($reg[$i]['ivaproducto']/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['cantidad'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorIva;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['cantidad'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['cantidad'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['cantidad'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra; 
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumCompra, 2, '.', ',') : "0.00"); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="7"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "******"); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'SERVICIOSVENDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarServiciosVendidosxFechas();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS VENDIDOS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="8">REPORTE GENERAL DE SERVICIOS VENDIDOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE SERVICIO</th>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$PrecioVentaTotal = 0;
$VendidosTotal    = 0;
$TotalDescuento   = 0;
$TotalImpuesto    = 0;
$TotalGeneral     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal  += $reg[$i]['precioventa'];
$VendidosTotal     += $reg[$i]['cantidad'];

$Descuento         = $reg[$i]['descproducto']/100;
$PrecioDescuento   = $reg[$i]['precioventa']*$Descuento;

$SubtotalDescuento = number_format($reg[$i]['totaldescuentov'], 2, '.', '');
$PrecioFinal       = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg               = $reg[$i]['ivaproducto']/100;
$SubtotalImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

$TotalDescuento   += $SubtotalDescuento; 
$TotalImpuesto    += $SubtotalImpuesto; 
$TotalGeneral     += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($SubtotalDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="4"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
################################# MODULO DE SERVICIOS ################################




















################################# MODULO DE PRODUCTOS ################################
case 'PRODUCTOS':

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "34" : "12"); ?>">REPORTE GENERAL DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PRODUCTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>Nº DE IMEI</th>
    <th>CONDICIÓN DE PRODUCTO</th>
    <th>FABRICANTE</th>
    <th>FAMILIA</th>
    <th>SUBFAMILIA</th>
    <?php } ?>
    <th>MARCA</th>
    <th>MODELO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>PRESENTACIÓN</th>
    <th>COLOR</th>
    <th>ORIGEN</th>
    <th>AÑO</th>
    <th>Nº DE PARTE</th>
    <th>LOTE</th>
    <th>PESO</th>
    <th>STOCK ÓPTIMO</th>
    <th>STOCK MEDIO</th>
    <th>STOCK MINIMO</th>
    <?php } ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>CÓDIGO DE BARRA</th>
    <th>FECHA DE ELABORACIÓN</th>
    <th>FECHA DE EXP. ÓPTIMO</th>
    <th>FECHA DE EXP. MEDIO</th>
    <th>FECHA DE EXP. MINIMO</th>
    <th>PROVEEDOR</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO MAYOR</th>
    <th>PRECIO MENOR</th>
    <th>PRECIO PÚBLICO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a                  = 1;
$TotalCompra        = 0;
$TotalMenor         = 0;
$TotalMayor         = 0;
$TotalPublico       = 0;
$TotalMonedaMenor   = 0;
$TotalMonedaMayor   = 0;
$TotalMonedaPublico = 0;
$TotalArticulos     = 0;

for($i=0;$i<sizeof($reg);$i++){

$simbolo            =  ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2           =  ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");
$TotalCompra        += $reg[$i]['preciocompra'];
$TotalMenor         += $reg[$i]['precioxmenor'];
$TotalMayor         += $reg[$i]['precioxmayor'];
$TotalPublico       += $reg[$i]['precioxpublico'];

$TotalMonedaMayor   += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmayor']/$reg[$i]['montocambio']);
$TotalMonedaMenor   += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmenor']/$reg[$i]['montocambio']);
$TotalMonedaPublico += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxpublico']/$reg[$i]['montocambio']);
$TotalArticulos     += $reg[$i]['existencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['descripcion'] == '' ? "******" : $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei'] == '' ? "******" : $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion'] == '' ? "******" : $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante'] == '' ? "******" : $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "******" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "******" : $reg[$i]['nomsubfamilia']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "******" : $reg[$i]['nomcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "******" : $reg[$i]['nomorigen']; ?></td>
    <td><?php echo $reg[$i]['year'] == '' ? "******" : $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte'] == '' ? "******" : $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "******" : $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso'] == '' ? "******" : $reg[$i]['peso']; ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "******" : number_format($reg[$i]['stockoptimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "******" : number_format($reg[$i]['stockmedio'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "******" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codigobarra'] == '' ? "******" : $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="29"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMayor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMenor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalPublico, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSCSV':

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
  <tr class="even_row">
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "0" : $reg[$i]['codfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "0" : $reg[$i]['codsubfamilia']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "0" : $reg[$i]['codmarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "0" : $reg[$i]['codmodelo']; ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "0" : $reg[$i]['codpresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "0" : $reg[$i]['codcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "0" : $reg[$i]['codorigen']; ?></td>
    <td><?php echo $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso']; ?></td>
    <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioxmenor'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioxmayor'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioxpublico'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "0.00" : number_format($reg[$i]['stockoptimo'], 2, '.', ''); ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "0.00" : number_format($reg[$i]['stockmedio'], 2, '.', ''); ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "0.00" : number_format($reg[$i]['stockminimo'], 2, '.', ''); ?></td>
    <td><?php echo $reg[$i]['ivaproducto']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
    <td><?php echo $reg[$i]['codproveedor']; ?></td>
    <td><?php echo $reg[$i]['stockteorico']; ?></td>
    <td><?php echo $reg[$i]['motivoajuste']; ?></td>
    <td><?php echo $reg[$i]['codsucursal']; ?></td>
  </tr>
  <?php }  } ?>
</table>
<?php
break;

case 'PRODUCTOSXSUCURSAL':

$tra = new Login();
$reg = $tra->ListarProductosxSucursales(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "33" : "11"); ?>">REPORTE GENERAL DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PRODUCTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>Nº DE IMEI</th>
    <th>CONDICIÓN DE PRODUCTO</th>
    <th>FABRICANTE</th>
    <th>FAMILIA</th>
    <th>SUBFAMILIA</th>
    <?php } ?>
    <th>MARCA</th>
    <th>MODELO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>PRESENTACIÓN</th>
    <th>COLOR</th>
    <th>ORIGEN</th>
    <th>AÑO</th>
    <th>Nº DE PARTE</th>
    <th>LOTE</th>
    <th>PESO</th>
    <th>STOCK ÓPTIMO</th>
    <th>STOCK MEDIO</th>
    <th>STOCK MINIMO</th>
    <?php } ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>CÓDIGO DE BARRA</th>
    <th>FECHA DE ELABORACIÓN</th>
    <th>FECHA DE EXP. ÓPTIMO</th>
    <th>FECHA DE EXP. MEDIO</th>
    <th>FECHA DE EXP. MINIMO</th>
    <th>PROVEEDOR</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO MAYOR</th>
    <th>PRECIO MENOR</th>
    <th>PRECIO PÚBLICO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a                  = 1;
$TotalCompra        = 0;
$TotalMenor         = 0;
$TotalMayor         = 0;
$TotalPublico       = 0;
$TotalMonedaMenor   = 0;
$TotalMonedaMayor   = 0;
$TotalMonedaPublico = 0;
$TotalArticulos     = 0;

for($i=0;$i<sizeof($reg);$i++){

$simbolo            =  ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2           =  ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");
$TotalCompra        += $reg[$i]['preciocompra'];
$TotalMenor         += $reg[$i]['precioxmenor'];
$TotalMayor         += $reg[$i]['precioxmayor'];
$TotalPublico       += $reg[$i]['precioxpublico'];

$TotalMonedaMayor   += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmayor']/$reg[$i]['montocambio']);
$TotalMonedaMenor   += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmenor']/$reg[$i]['montocambio']);
$TotalMonedaPublico += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxpublico']/$reg[$i]['montocambio']);
$TotalArticulos     += $reg[$i]['existencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['descripcion'] == '' ? "******" : $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei'] == '' ? "******" : $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion'] == '' ? "******" : $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante'] == '' ? "******" : $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "******" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "******" : $reg[$i]['nomsubfamilia']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "******" : $reg[$i]['nomcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "******" : $reg[$i]['nomorigen']; ?></td>
    <td><?php echo $reg[$i]['year'] == '' ? "******" : $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte'] == '' ? "******" : $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "******" : $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso'] == '' ? "******" : $reg[$i]['peso']; ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "******" : number_format($reg[$i]['stockoptimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "******" : number_format($reg[$i]['stockmedio'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "******" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codigobarra'] == '' ? "******" : $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'PRODUCTOSXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaProductos();

if($_GET["tipobusqueda"] == 1){

  if($_GET["codsubfamilia"] == 0){
    $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (FAMILIA: ".$reg[0]['nomfamilia']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } else {
    $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (FAMILIA: ".$reg[0]['nomfamilia']." Y SUBFAMILIA: ".$reg[0]['nomsubfamilia']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  }

} elseif($_GET["tipobusqueda"] == 2){

  if($_GET["codsubfamilia"] == 0){
    $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (MARCA: ".$reg[0]['nommarca']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } else {
    $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (MARCA: ".$reg[0]['nommarca']." Y MODELO: ".$reg[0]['nommodelo']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  }

} elseif($_GET["tipobusqueda"] == 3){

  $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (PRESENTACION: ".$reg[0]['nompresentacion']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif($_GET["tipobusqueda"] == 4){

  $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (COLOR: ".$reg[0]['nomcolor']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif($_GET["tipobusqueda"] == 5){

  $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (ORIGEN: ".$reg[0]['nomorigen']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif($_GET["tipobusqueda"] == 6){

  $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (PROVEEDOR: ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif($_GET["tipobusqueda"] == 7){

  $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (FAMILIA: ".$reg[0]['nomfamilia']." Y PROVEEDOR: ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif($_GET["tipobusqueda"] == 8){

  $archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS DE (MARCA: ".$reg[0]['nommarca']." Y PROVEEDOR: ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']." EN SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "34" : "12"); ?>">REPORTE GENERAL DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PRODUCTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>Nº DE IMEI</th>
    <th>CONDICIÓN DE PRODUCTO</th>
    <th>FABRICANTE</th>
    <th>FAMILIA</th>
    <th>SUBFAMILIA</th>
    <?php } ?>
    <th>MARCA</th>
    <th>MODELO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>PRESENTACIÓN</th>
    <th>COLOR</th>
    <th>ORIGEN</th>
    <th>AÑO</th>
    <th>Nº DE PARTE</th>
    <th>LOTE</th>
    <th>PESO</th>
    <th>STOCK ÓPTIMO</th>
    <th>STOCK MEDIO</th>
    <th>STOCK MINIMO</th>
    <?php } ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>CÓDIGO DE BARRA</th>
    <th>FECHA DE ELABORACIÓN</th>
    <th>FECHA DE EXP. ÓPTIMO</th>
    <th>FECHA DE EXP. MEDIO</th>
    <th>FECHA DE EXP. MINIMO</th>
    <th>PROVEEDOR</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO MAYOR</th>
    <th>PRECIO MENOR</th>
    <th>PRECIO PÚBLICO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a                  = 1;
$TotalCompra        = 0;
$TotalMenor         = 0;
$TotalMayor         = 0;
$TotalPublico       = 0;
$TotalMonedaMenor   = 0;
$TotalMonedaMayor   = 0;
$TotalMonedaPublico = 0;
$TotalArticulos     = 0;

for($i=0;$i<sizeof($reg);$i++){

$simbolo            =  ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2           =  ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");
$TotalCompra        += $reg[$i]['preciocompra'];
$TotalMenor         += $reg[$i]['precioxmenor'];
$TotalMayor         += $reg[$i]['precioxmayor'];
$TotalPublico       += $reg[$i]['precioxpublico'];

$TotalMonedaMayor   += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmayor']/$reg[$i]['montocambio']);
$TotalMonedaMenor   += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmenor']/$reg[$i]['montocambio']);
$TotalMonedaPublico += (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxpublico']/$reg[$i]['montocambio']);
$TotalArticulos     += $reg[$i]['existencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['descripcion'] == '' ? "******" : $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei'] == '' ? "******" : $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion'] == '' ? "******" : $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante'] == '' ? "******" : $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "******" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "******" : $reg[$i]['nomsubfamilia']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "******" : $reg[$i]['nomcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "******" : $reg[$i]['nomorigen']; ?></td>
    <td><?php echo $reg[$i]['year'] == '' ? "******" : $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte'] == '' ? "******" : $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "******" : $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso'] == '' ? "******" : $reg[$i]['peso']; ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "******" : number_format($reg[$i]['stockoptimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "******" : number_format($reg[$i]['stockmedio'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "******" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codigobarra'] == '' ? "******" : $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="29"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMayor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMenor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalPublico, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'AJUSTEPRODUCTOS':

$tra = new Login();
$reg = $tra->ListarAjustesProductos(); 

$archivo = str_replace(" ", "_","LISTADO DE AJUSTES DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "14"); ?>">REPORTE GENERAL DE AJUSTE DE STOCK DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>PRESENTACIÓN</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA MAYOR</th>
    <th>PRECIO VENTA MENOR</th>
    <th>PRECIO VENTA PÚBLICO</th>
    <th>EXISTENCIA</th>
    <th>CANTIDAD</th>
    <th>STOCK</th>
    <th>FECHA</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo  = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><strong><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? "+" : "-")." ".number_format($reg[$i]['cantidad'], 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? number_format($reg[$i]['existencia']+$reg[$i]['cantidad'], 2, '.', ',') : number_format($reg[$i]['existencia']-$reg[$i]['cantidad'], 2, '.', ',')); ?></strong></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaajuste']))." <strong>".date("H:i:s",strtotime($reg[$i]['fechaajuste']))."</strong>"; ?></td>
  </tr>
  <?php } ?>
  
  <?php } ?>
</table>
<?php
break;

case 'AJUSTEPRODUCTOSXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaAjustesProductos(); 

if($_GET['tipobusqueda'] == 1){
$archivo = str_replace(" ", "_","LISTADO GENERAL DE AJUSTES DE PRODUCTOS (DE SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 2){
$archivo = str_replace(" ", "_","LISTADO DE AJUSTES DE PRODUCTOS POR BÚSQUEDA (".$_GET["search_criterio"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 3){
$archivo = str_replace(" ", "_","LISTADO DE AJUSTES DE PRODUCTOS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "14"); ?>">REPORTE GENERAL DE AJUSTE DE STOCK DE PRODUCTOS POR BÚSQUEDA</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>PRESENTACIÓN</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA MAYOR</th>
    <th>PRECIO VENTA MENOR</th>
    <th>PRECIO VENTA PÚBLICO</th>
    <th>EXISTENCIA</th>
    <th>CANTIDAD</th>
    <th>STOCK</th>
    <th>FECHA</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo  = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><strong><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? "+" : "-")." ".number_format($reg[$i]['cantidad'], 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? number_format($reg[$i]['existencia']+$reg[$i]['cantidad'], 2, '.', ',') : number_format($reg[$i]['existencia']-$reg[$i]['cantidad'], 2, '.', ',')); ?></strong></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaajuste']))." <strong>".date("H:i:s",strtotime($reg[$i]['fechaajuste']))."</strong>"; ?></td>
  </tr>
  <?php } ?>
  
  <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$siglas = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['siglas']."</strong>");
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y MONEDA ".$cambio[0]['moneda'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "34" : "12"); ?>">REPORTE GENERAL DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PRODUCTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>Nº DE IMEI</th>
    <th>CONDICIÓN DE PRODUCTO</th>
    <th>FABRICANTE</th>
    <th>FAMILIA</th>
    <th>SUBFAMILIA</th>
    <?php } ?>
    <th>MARCA</th>
    <th>MODELO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>PRESENTACIÓN</th>
    <th>COLOR</th>
    <th>ORIGEN</th>
    <th>AÑO</th>
    <th>Nº DE PARTE</th>
    <th>LOTE</th>
    <th>PESO</th>
    <th>STOCK ÓPTIMO</th>
    <th>STOCK MEDIO</th>
    <th>STOCK MINIMO</th>
    <?php } ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>CÓDIGO DE BARRA</th>
    <th>FECHA DE ELABORACIÓN</th>
    <th>FECHA DE EXP. ÓPTIMO</th>
    <th>FECHA DE EXP. MEDIO</th>
    <th>FECHA DE EXP. MINIMO</th>
    <th>PROVEEDOR</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA <?php echo $siglas; ?></th>
    <th>PRECIO MAYOR <?php echo $siglas; ?></th>
    <th>PRECIO MENOR <?php echo $siglas; ?></th>
    <th>PRECIO PÚBLICO <?php echo $siglas; ?></th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a                  = 1;
$TotalCompra        = 0;
$TotalMayor         = 0;
$TotalMenor         = 0;
$TotalPublico       = 0;
$TotalMonedaCompra  = 0;
$TotalMonedaMayor   = 0;
$TotalMonedaMenor   = 0;
$TotalMonedaPublico = 0;
$TotalArticulos     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo   = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2  = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");

$TotalCompra        += number_format($reg[$i]['preciocompra'], 2, '.', ',');
$TotalMayor         += number_format($reg[$i]['precioxmayor'], 2, '.', '');
$TotalMenor         += number_format($reg[$i]['precioxmenor'], 2, '.', '');
$TotalPublico       += number_format($reg[$i]['precioxpublico'], 2, '.', '');

$TotalMonedaCompra  += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
$TotalMonedaMayor   += number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaMenor   += number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaPublico += number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', '');
$TotalArticulos     += $reg[$i]['existencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['descripcion'] == '' ? "******" : $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei'] == '' ? "******" : $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion'] == '' ? "******" : $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante'] == '' ? "******" : $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "******" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "******" : $reg[$i]['nomsubfamilia']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "******" : $reg[$i]['nomcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "******" : $reg[$i]['nomorigen']; ?></td>
    <td><?php echo $reg[$i]['year'] == '' ? "******" : $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte'] == '' ? "******" : $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "******" : $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso'] == '' ? "******" : $reg[$i]['peso']; ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "******" : number_format($reg[$i]['stockoptimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "******" : number_format($reg[$i]['stockmedio'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "******" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codigobarra'] == '' ? "******" : $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="29"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaMayor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaMenor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaPublico, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'KARDEXPRODUCTO':

$detalle = new Login();
$detalle = $detalle->DetalleKardexProducto();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();

$archivo = str_replace(" ", "_","KARDEX DEL PRODUCTO (".portales($detalle[0]['producto'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "13" : "9"); ?>">REPORTE GENERAL DE KARDEX DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>REALIZADO POR</th>
    <th>MOVIMIENTO</th>
    <th>ENTRADAS</th>
    <th>SALIDAS</th>
    <th>DEVOLUCIÓN</th>
    <th>STOCK</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <th>PRECIO</th>
    <th>COSTO</th>
    <?php } ?>
    <th>DOCUMENTO</th>
    <th>FECHA KARDEX</th>
  </tr>
<?php 
if($kardex==""){
echo "";      
} else {

$TotalEntradas   = 0;
$TotalSalidas    = 0;
$TotalDevolucion = 0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>");

$TotalEntradas   += $kardex[$i]['entradas'];
$TotalSalidas    += $kardex[$i]['salidas'];
$TotalDevolucion += $kardex[$i]['devolucion'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
    <td><?php echo $kardex[$i]['movimiento']; ?></td>
    <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
    <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
    <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
    <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
    <?php } else { ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
    <?php } ?>
    <?php } ?>
    <td><?php echo $kardex[$i]['documento']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($kardex[$i]['fechakardex']))."<br><strong>".date("H:i:s",strtotime($kardex[$i]['fechakardex']))."</strong>"; ?></td>
  </tr>
  <?php } } ?>
</table>
<strong>DETALLE DE PRODUCTO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['producto']; ?><br>
<strong>PRESENTACIÓN:</strong> <?php echo $detalle[0]['nompresentacion']; ?><br>
<strong>MARCA:</strong> <?php echo $detalle[0]['codmarca'] == '0' ? "******" : $detalle[0]['nommarca']; ?><br>
<strong>MODELO:</strong> <?php echo $detalle[0]['codmodelo'] == '0' ? "******" : $detalle[0]['nommodelo']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
<strong>EXISTENCIA:</strong> <?php echo number_format($detalle[0]['existencia'], 2, '.', ','); ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "******"); ?><br>
<strong>P. VENTA MENOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmenor'], 2, '.', ','); ?><br>
<strong>P. VENTA MAYOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmayor'], 2, '.', ','); ?><br>
<strong>P. VENTA PUBLICO:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxpublico'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXPRODUCTOSVALORIZADO':

$tra = new Login();
$reg = $tra->ListarKardexProductosValorizado(); 

$archivo = str_replace(" ", "_","KARDEX DE PRODUCTOS VALORIZADO DE SUCURSAL: (".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "14"); ?>">REPORTE GENERAL DE KARDEX VALORIZADO PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO PÚBLICO</th>
    <th>IMPUESTO</th>
    <th>DESC.</th>
    <th>EXISTENCIA</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioCompraTotal    = 0;
$PrecioVentaTotal     = 0;
$ExisteTotal          = 0;
$ImpuestosCompraTotal = 0;
$ImpuestosVentaTotal  = 0;
$CompraTotal          = 0;
$VentaTotal           = 0;
$TotalGanancia        = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal    += $reg[$i]['preciocompra'];
$PrecioVentaTotal     += $reg[$i]['precioxpublico'];
$ExisteTotal          += $reg[$i]['existencia'];

$Descuento            = $reg[$i]['descproducto']/100;
$PrecioDescuento      = $reg[$i]['precioxpublico']*$Descuento;
$PrecioFinal          = $reg[$i]['precioxpublico']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorIva = 1 + ($reg[$i]['valorimpuesto']/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorIva;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra; 
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioxpublico"], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</font color>" : "<font color='blue'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</font color>"; ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "0.00"); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="10"></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "0.00"); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "0.00"); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'PRODUCTOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarProductosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE KARDEX PRODUCTOS VALORIZADO POR FECHAS ( DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="14">REPORTE GENERAL DE KARDEX PRODUCTOS VALORIZADO POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioCompraTotal    = 0;
$PrecioVentaTotal     = 0;
$VendidosTotal        = 0;
$ImpuestosCompraTotal = 0;
$ImpuestosVentaTotal  = 0;
$CompraTotal          = 0;
$VentaTotal           = 0;
$TotalGanancia        = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal     += $reg[$i]['preciocompra'];
$PrecioVentaTotal      += $reg[$i]['precioventa'];
$VendidosTotal         += $reg[$i]['cantidad'];

$Descuento             = $reg[$i]['descproducto']/100;
$PrecioDescuento       = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal           = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorIva = 1 + ($reg[$i]['ivaproducto']/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['cantidad'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorIva;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['cantidad'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['cantidad'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['cantidad'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra; 
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumCompra, 2, '.', ',') : "0.00"); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="10"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "0.00"); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "0.00"); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'PRODUCTOSVENDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarProductosVendidosxFechas();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS VENDIDOS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="11">REPORTE GENERAL DE PRODUCTOS VENDIDOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$PrecioVentaTotal = 0;
$VendidosTotal    = 0;
$TotalDescuento   = 0;
$TotalImpuesto    = 0;
$TotalGeneral     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal  += $reg[$i]['precioventa'];
$VendidosTotal     += $reg[$i]['cantidad'];

$Descuento         = $reg[$i]['descproducto']/100;
$PrecioDescuento   = $reg[$i]['precioventa']*$Descuento;

$SubtotalDescuento = number_format($reg[$i]['totaldescuentov'], 2, '.', '');
$PrecioFinal       = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg               = $reg[$i]['ivaproducto']/100;
$SubtotalImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

$TotalDescuento   += $SubtotalDescuento; 
$TotalImpuesto    += $SubtotalImpuesto; 
$TotalGeneral     += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "******" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($SubtotalDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="7"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
################################# MODULO DE PRODUCTOS ################################
















################################ MODULO DE COMBOS ################################
case 'COMBOS':

$tra = new Login();
$reg = $tra->ListarCombos();

$archivo = str_replace(" ", "_","LISTADO DE COMBOS EN (SUCURSAL ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "13" : "10"); ?>">REPORTE GENERAL DE COMBOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE COMBO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>STOCK MINIMO</th>
    <th>STOCK MÁXIMO</th>
    <?php } ?>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DETALLES DE PRODUCTOS</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO MAYOR</th>
    <th>PRECIO MENOR</th>
    <th>PRECIO PÚBLICO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra    = 0;
$TotalMayor     = 0;
$TotalMenor     = 0;
$TotalPublico   = 0;
$TotalArticulos = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo        = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalCompra    += $reg[$i]['preciocompra'];
$TotalMayor     += $reg[$i]['precioxmayor'];
$TotalMenor     += $reg[$i]['precioxmenor'];
$TotalPublico   += $reg[$i]['precioxpublico'];
$TotalArticulos += $reg[$i]['existencia'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>      
    <?php } ?>
    <td><strong><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</font color>" : "<font color='blue'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</font color>"; ?></strong></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******"); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMayor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMenor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalPublico, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMBOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$siglas = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['siglas']."</strong>");
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");

$tra = new Login();
$reg = $tra->ListarCombos();

$archivo = str_replace(" ", "_","LISTADO DE COMBOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y MONEDA ".$cambio[0]['moneda'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE COMBOS POR MONEDA (<?php echo $cambio[0]['moneda']; ?>) AL CAMBIO (<?php echo number_format($cambio[0]['montocambio'], 2, '.', ','); ?>)</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE COMBO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DETALLES DE PRODUCTOS</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA <?php echo $siglas; ?></th>
    <th>PRECIO MAYOR <?php echo $siglas; ?></th>
    <th>PRECIO MENOR <?php echo $siglas; ?></th>
    <th>PRECIO PÚBLICO <?php echo $siglas; ?></th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a                  = 1;
$TotalCompra        = 0;
$TotalMayor         = 0;
$TotalMenor         = 0;
$TotalPublico       = 0;
$TotalMonedaCompra  = 0;
$TotalMonedaMayor   = 0;
$TotalMonedaMenor   = 0;
$TotalMonedaPublico = 0;
$TotalArticulos     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo   = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2  = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");

$TotalCompra        += number_format($reg[$i]['preciocompra'], 2, '.', ',');
$TotalMayor         += number_format($reg[$i]['precioxmayor'], 2, '.', '');
$TotalMenor         += number_format($reg[$i]['precioxmenor'], 2, '.', '');
$TotalPublico       += number_format($reg[$i]['precioxpublico'], 2, '.', '');

$TotalMonedaCompra  += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
$TotalMonedaMayor   += number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaMenor   += number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaPublico += number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', '');
$TotalArticulos     += $reg[$i]['existencia'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>      
    <?php } ?>
    <td><strong><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</font color>" : "<font color='blue'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</font color>"; ?></strong></td>

    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ',') : "******"); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaMayor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaMenor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaPublico, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'KARDEXCOMBO':

$kardex = new Login();
$kardex = $kardex->BuscarKardexCombo(); 

$detalle = new Login();
$detalle = $detalle->DetalleKardexCombo(); 

$archivo = str_replace(" ", "_","KARDEX DEL COMBO (".portales($detalle[0]['nomcombo'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "13" : "9"); ?>">REPORTE GENERAL DE KARDEX DE COMBOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>REALIZADO POR</th>
    <th>MOVIMIENTO</th>
    <th>ENTRADAS</th>
    <th>SALIDAS</th>
    <th>DEVOLUCIÓN</th>
    <th>STOCK</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>IMPUESTO</th>
    <th>DESCUENTO</th>
    <th>PRECIO</th>
    <th>COSTO</th>
    <?php } ?>
    <th>DOCUMENTO</th>
    <th>FECHA KARDEX</th>
  </tr>
<?php 
if($kardex==""){
echo "";      
} else {

$TotalEntradas   = 0;
$TotalSalidas    = 0;
$TotalDevolucion = 0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>");

$TotalEntradas   += $kardex[$i]['entradas'];
$TotalSalidas    += $kardex[$i]['salidas'];
$TotalDevolucion += $kardex[$i]['devolucion'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
    <td><?php echo $kardex[$i]['movimiento']; ?></td>
    <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
    <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
    <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
    <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
    <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
    <?php } else { ?>
    <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
    <?php } ?>
    <?php } ?>
    <td><?php echo $kardex[$i]['documento']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($kardex[$i]['fechakardex']))."<br><strong>".date("H:i:s",strtotime($kardex[$i]['fechakardex']))."</strong>"; ?></td>
  </tr>
  <?php } } ?>
</table>
<strong>DETALLE DE COMBO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $detalle[0]['codcombo']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['nomcombo']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
<strong>EXISTENCIA:</strong> <?php echo number_format($detalle[0]['existencia'], 2, '.', ','); ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "******"); ?><br>
<strong>P. VENTA MENOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmenor'], 2, '.', ','); ?><br>
<strong>P. VENTA MAYOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmayor'], 2, '.', ','); ?><br>
<strong>P. VENTA PUBLICO:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxpublico'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXCOMBOSVALORIZADO':

$tra = new Login();
$reg = $tra->ListarKardexCombosValorizado(); 

$archivo = str_replace(" ", "_","KARDEX DE COMBOS VALORIZADO DE SUCURSAL: (".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "11"); ?>">REPORTE GENERAL DE KARDEX COMBOS VALORIZADO</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO PÚBLICO</th>
    <th>IMPUESTO</th>
    <th>DESC.</th>
    <th>EXISTENCIA</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioCompraTotal    = 0;
$PrecioVentaTotal     = 0;
$ExisteTotal          = 0;
$ImpuestosCompraTotal = 0;
$ImpuestosVentaTotal  = 0;
$CompraTotal          = 0;
$VentaTotal           = 0;
$TotalGanancia        = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal    += $reg[$i]['preciocompra'];
$PrecioVentaTotal     += $reg[$i]['precioxpublico'];
$ExisteTotal          += $reg[$i]['existencia'];

$Descuento            = $reg[$i]['desccombo']/100;
$PrecioDescuento      = $reg[$i]['precioxpublico']*$Descuento;
$PrecioFinal          = $reg[$i]['precioxpublico']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorIva = 1 + ($reg[$i]['valorimpuesto']/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
$SubtotalimpuestosC    = ($reg[$i]['ivacombo'] != '0' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorIva;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
$SubtotalimpuestosV    = ($reg[$i]['ivacombo'] != '0' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra; 
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioxpublico"], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $reg[$i]['desccombo']; ?>%</td>
    <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".$reg[$i]['existencia']."</font color>" : "<font color='blue'>".$reg[$i]['existencia']."</font color>"; ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "0.00"); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="7"></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "0.00"); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "0.00"); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'COMBOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCombosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE KARDEX COMBOS VALORIZADO POR FECHAS ( DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="11">REPORTE GENERAL DE KARDEX COMBOS VALORIZADO POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE COMBO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioCompraTotal    = 0;
$PrecioVentaTotal     = 0;
$VendidosTotal        = 0;
$ImpuestosCompraTotal = 0;
$ImpuestosVentaTotal  = 0;
$CompraTotal          = 0;
$VentaTotal           = 0;
$TotalGanancia        = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal     += $reg[$i]['preciocompra'];
$PrecioVentaTotal      += $reg[$i]['precioventa'];
$VendidosTotal         += $reg[$i]['cantidad'];

$Descuento             = $reg[$i]['descproducto']/100;
$PrecioDescuento       = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal           = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorIva = 1 + ($reg[$i]['ivaproducto']/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['cantidad'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorIva;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['cantidad'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['cantidad'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['cantidad'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra; 
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumCompra, 2, '.', ',') : "0.00"); ?></td>
    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="7"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "0.00"); ?></strong></td>
    <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "0.00"); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'COMBOSVENDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCombosVendidosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMBOS VENDIDOS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="9">REPORTE GENERAL DE COMBOS VENDIDOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE COMBO</th>
    <th>PRECIO VENTA</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>VENDIDO</th>
    <th>IMPUESTO</th>
    <th>DESC %</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$PrecioVentaTotal = 0;
$ExisteTotal      = 0;
$VendidosTotal    = 0;
$TotalDescuento   = 0;
$TotalImpuesto    = 0;
$TotalGeneral     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal  += $reg[$i]['precioventa'];
$ExisteTotal       += $reg[$i]['cantidad'];
$VendidosTotal     += $reg[$i]['cantidad'];

$Descuento         = $reg[$i]['descproducto']/100;
$PrecioDescuento   = $reg[$i]['precioventa']*$Descuento;

$SubtotalDescuento = number_format($reg[$i]['totaldescuentov'], 2, '.', '');
$PrecioFinal       = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg               = $reg[$i]['ivaproducto']/100;
$SubtotalImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

$TotalDescuento   += $SubtotalDescuento; 
$TotalImpuesto    += $SubtotalImpuesto; 
$TotalGeneral     += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($SubtotalDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="5"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
################################# MODULO DE COMBOS ##################################










################################# MODULO DE TRASPASOS #################################
case 'TRASPASOS':

$tra = new Login();
$reg = $tra->ListarTraspasos(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "18" : "10"); ?>">REPORTE GENERAL DE TRASPASOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>Nº DE TRACKING</th>
    <th>SUCURSAL REMITENTE</th>
    <th>SUCURSAL DESTINATARIO</th>
    <th>RESPONSABLE DE TRASLADO</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>OBERVACIONES DE ENVIO</th>
    <th>PERSONA QUE RECIBE</th>
    <th>FECHA RECIBE</th>
    <th>OBERVACIONES DE RECIBIDO</th>
    <th>DETALLES DE ARTICULOS</th>
    <?php } ?>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$tipo_documento = ($reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_8' || $reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_5' ? "TICKET" : "FACTURA");

$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
    <td><?php echo $reg[$i]['nombres_responsable'] == "" ? "*********" : $reg[$i]['nombres_responsable']; ?></td>
    <td><?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <?php if($reg[$i]['estado_traspaso'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">REGISTRADO</td>
    <?php } elseif($reg[$i]['estado_traspaso']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e2a03f;color:#070707;">EN PROCESO</td>
    <?php } elseif($reg[$i]['estado_traspaso']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#1b78a0;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['estado_traspaso']==4) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">RECIBIDO</td>
    <?php } elseif($reg[$i]['estado_traspaso']==5) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">RECHAZADA</td>
    <?php } ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo $reg[$i]['persona_recibe'] == 0 ? "**********" : $reg[$i]['persona_recibe']; ?></td>
    <td><?php echo $reg[$i]['fecha_recibe'] == '' ? "**********" : date("d/m/Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <td><?php echo $reg[$i]['observaciones_recibido'] == '' ? "**********" : $reg[$i]['observaciones_recibido']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } ?>
    <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="13"></td>' : '<td colspan="8"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'TRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarTraspasosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "18" : "10"); ?>">REPORTE GENERAL DE TRASPASOS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>Nº DE TRACKING</th>
    <th>SUCURSAL REMITENTE</th>
    <th>SUCURSAL DESTINATARIO</th>
    <th>RESPONSABLE DE TRASLADO</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>OBERVACIONES DE ENVIO</th>
    <th>PERSONA QUE RECIBE</th>
    <th>FECHA RECIBE</th>
    <th>OBERVACIONES DE RECIBIDO</th>
    <th>DETALLES DE ARTICULOS</th>
    <?php } ?>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$tipo_documento = ($reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_8' || $reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_5' ? "TICKET" : "FACTURA");

$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
    <td><?php echo $reg[$i]['nombres_responsable'] == "" ? "*********" : $reg[$i]['nombres_responsable']; ?></td>
    <td><?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <?php if($reg[$i]['estado_traspaso'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">REGISTRADO</td>
    <?php } elseif($reg[$i]['estado_traspaso']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e2a03f;color:#070707;">EN PROCESO</td>
    <?php } elseif($reg[$i]['estado_traspaso']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#1b78a0;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['estado_traspaso']==4) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">RECIBIDO</td>
    <?php } elseif($reg[$i]['estado_traspaso']==5) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">RECHAZADA</td>
    <?php } ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo $reg[$i]['persona_recibe'] == 0 ? "**********" : $reg[$i]['persona_recibe']; ?></td>
    <td><?php echo $reg[$i]['fecha_recibe'] == '' ? "**********" : date("d/m/Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <td><?php echo $reg[$i]['observaciones_recibido'] == '' ? "**********" : $reg[$i]['observaciones_recibido']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } ?>
    <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="13"></td>' : '<td colspan="8"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESTRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesTraspasosxFechas(); 

$archivo = str_replace(" ", "_","DETALLES DE TRASPASOS PRODUCTOS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES TRASPASOS DE PRODUCTOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>EXISTENCIA</th>
    <th>TRASPASADO</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal   = 0;
$ExisteTotal   = 0;
$VendidosTotal = 0;
$PagoTotal     = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad']; 
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
################################## MODULO DE TRASPASOS ###################################



















############################### MODULO DE COMPRAS ###############################
case 'COMPRAS':

$tra = new Login();
$reg = $tra->ListarCompras(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "15" : "11"); ?>">REPORTE GENERAL DE COMPRAS A PROVEEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>Nº DE ARTICULOS</th>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <th>GASTO DE ENVIO</th>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalGasto      = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalGasto      += $reg[$i]['gastoenvio'];
$TotalImporte    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>   
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMPRASXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaCompras(); 

if($_GET['tipobusqueda'] == 1){
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
} else
if($_GET['tipobusqueda'] == 2){
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES POR BÚSQUEDA (".$_GET["search_criterio"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 3){
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "15" : "11"); ?>">REPORTE GENERAL DE COMPRAS A PROVEEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>Nº DE ARTICULOS</th>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <th>GASTO DE ENVIO</th>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalGasto      = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalGasto      += $reg[$i]['gastoenvio'];
$TotalImporte    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>   
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CUENTASXPAGAR':

$tra = new Login();
$reg = $tra->ListarCuentasxPagar(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES POR PAGAR EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "9"); ?>">REPORTE GENERAL DE COMPRAS POR PAGAR A PROVEEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto   = 0;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalGasto   += $reg[$i]['gastoenvio'];
$TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?> 
</table>
<?php
break;

case 'CUENTASXPAGARXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaCuentasxPagar(); 

if($_GET['tipobusqueda'] == 1){
$archivo = str_replace(" ", "_","LISTADO DE CUENTAS POR PAGAR A PROVEEDORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
} else
if($_GET['tipobusqueda'] == 2){
$archivo = str_replace(" ", "_","LISTADO DE CUENTAS POR PAGAR A PROVEEDORES POR BÚSQUEDA (".$_GET["search_criterio"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 3){
$archivo = str_replace(" ", "_","LISTADO DE CUENTAS POR PAGAR A PROVEEDORES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "9"); ?>">REPORTE GENERAL DE COMPRAS POR PAGAR A PROVEEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto   = 0;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalGasto   += $reg[$i]['gastoenvio'];
$TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?> 
</table>
<?php
break;

case 'COMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarComprasxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES EN (SUCURSAL ".$reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']." Y PROVEEDOR ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "10"); ?>">REPORTE GENERAL DE COMPRAS POR PROVEEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>Nº DE ARTICULOS</th>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <th>GASTO DE ENVIO</th>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalGasto      = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalGasto      += $reg[$i]['gastoenvio'];
$TotalImporte    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>   
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A PROVEEDORES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "15" : "11"); ?>">REPORTE GENERAL DE COMPRAS A PROVEEDORES POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>Nº DE ARTICULOS</th>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <th>GASTO DE ENVIO</th>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalGasto      = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += $reg[$i]['totaliva'];
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalGasto      += $reg[$i]['gastoenvio'];
$TotalImporte    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>   
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'ABONOSCREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarAbonosCreditosComprasxFechas();

$archivo = str_replace(" ", "_","LISTADO ABONOS DE COMPRAS A CREDITOS EN (CONDICIÓN DE PAGO: ".$reg[0]["mediopago"]." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "9" : "9"); ?>">REPORTE GENERAL DE ABONOS DE COMPRAS A CRÉDITOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>Nº DE DOCUMENTO</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>FORMA DE ABONO</th>
    <th>FECHA DE ABONO</th>
    <th>Nº DE COMPROBANTE</th>
    <th>NOMBRE DE BANCO</th>
    <th>MONTO ABONO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos = 0;
$TotalImporte   = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
   
$TotalImporte  += $reg[$i]['montoabono'];
?>
  <tr class="text-center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).":</strong><br> ".$reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechaabono'])); ?></td>
    <td><?php echo $reg[$i]['comprobante'] == "" ? "********" : $reg[$i]['comprobante']; ?></td>
    <td><?php echo $reg[$i]['codbanco'] == 0 ? "********" : $reg[$i]['nombanco']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSCOMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarCreditosComprasxProveedor(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS EN GENERAL DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PAGADAS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PENDIENTES DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "7"); ?>">REPORTE GENERAL DE COMPRAS A CRÉDITOS POR PROVEEDOR</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL ABONO</th>
    <th>TOTAL DEBE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto   = 0;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalGasto   += $reg[$i]['gastoenvio'];
$TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'CREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosComprasxFechas(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE COMPRAS A CRÉDITOS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL ABONO</th>
    <th>TOTAL DEBE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto   = 0;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

$TotalGasto   += $reg[$i]['gastoenvio'];
$TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCREDITOSCOMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosComprasxProveedor(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS EN GENERAL DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PAGADAS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PENDIENTES DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DETALLES COMPRAS A CRÉDITOS POR PROVEEDORES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL ABONO</th>
    <th>TOTAL DEBE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos = 0;
$TotalImporte   = 0;
$TotalAbono     = 0;
$TotalDebe      = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte += $reg[$i]['totalpago']+$reg[$i]["gastoenvio"];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>     
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosComprasxFechas(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "13" : "9"); ?>">REPORTE GENERAL DETALLES COMPRAS A CRÉDITOS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE PROVEEDOR</th>
    <th>OBSERVACIONES</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL ABONO</th>
    <th>TOTAL DEBE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos = 0;
$TotalImporte   = 0;
$TotalAbono     = 0;
$TotalDebe      = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte +=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"];
$TotalAbono   +=$reg[$i]['creditopagado'];
$TotalDebe    +=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statuscompra"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statuscompra"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d/m/Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
    </tr>
</table>
<?php
break;
############################### MODULO DE COMPRAS ###############################














################################## MODULO DE COTIZACIONES ###################################
case 'COTIZACIONES':

$tra = new Login();
$reg = $tra->ListarCotizaciones(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE COTIZACIONES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaCotizaciones();

if($_GET['tipobusqueda'] == 1){
$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
} else
if($_GET['tipobusqueda'] == 2){
$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES POR BÚSQUEDA (".$_GET["search_criterio"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 3){
$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE COTIZACIONES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE COTIZACIONES POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxVendedor();

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE COTIZACIONES POR VENDEDOR</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "10" : "7"); ?>">REPORTE GENERAL DE COTIZACIONES POR CLIENTE</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESCOTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","DETALLES COTIZACIONES POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE COTIZACIONES POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>COTIZADO</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal   = 0;
$ExisteTotal   = 0;
$VendidosTotal = 0;
$PagoTotal     = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCOTIZACIONESXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesCotizacionesxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES COTIZACIONES POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE COTIZACIONES POR VENDEDOR</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>COTIZADO</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal   = 0;
$ExisteTotal   = 0;
$VendidosTotal = 0;
$PagoTotal     = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
################################## MODULO DE COTIZACIONES ###################################















################################## MODULO DE PREVENTAS ###################################
case 'PREVENTAS':

$tra = new Login();
$reg = $tra->ListarPreventas(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE PREVENTAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PREVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarPreventasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE PREVENTAS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PREVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarPreventasxVendedor(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE PREVENTAS POR VENDEDOR</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PREVENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarPreventasxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "10" : "7"); ?>">REPORTE GENERAL DE PREVENTAS POR CLIENTE</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>ESTADO</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURACOTIZACION" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</strong>"; ?></td>
    <?php if($reg[$i]['procesada'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PENDIENTE</td>
    <?php } elseif($reg[$i]['procesada']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">PROCESADA</td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESPREVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesPreventasxFechas(); 

$archivo = str_replace(" ", "_","DETALLES PREVENTAS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE PREVENTAS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>PREVENTA</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal   = 0;
$ExisteTotal   = 0;
$VendidosTotal = 0;
$PagoTotal     = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESPREVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesPreventasxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES PREVENTAS POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE PREVENTAS POR VENDEDOR</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>PREVENTA</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal   = 0;
$ExisteTotal   = 0;
$VendidosTotal = 0;
$PagoTotal     = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
################################## MODULO DE PREVENTAS ###################################















############################### MODULO DE CAJAS ###############################
case 'CAJAS':

$tra = new Login();
$reg = $tra->ListarCajas();  

$archivo = str_replace(" ", "_","LISTADO DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "4" : "4"); ?>">REPORTE GENERAL DE CAJAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE CAJA</th>
    <th>NOMBRE DE CAJA</th>
    <th>RESPONSABLE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['nrocaja']; ?></td>
    <td><?php echo $reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'ARQUEOS':

$tra = new Login();
$reg = $tra->ListarArqueoCaja(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "10"); ?>">REPORTE GENERAL DE APERTURAS DE CAJAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>NOMBRE DE CAJA</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>RESPONSABLE</th>
    <th>APERTURA</th>
    <th>CIERRE</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>MONTO INICIAL</th>
    <th>TOTAL EN VENTAS</th>
    <th>TOTAL EN ABONOS</th>
    <th>OTROS INGRESOS</th>
    <th>TOTAL EN EGRESOS</th>
    <th>EFECTIVO EN CAJA</th>
    <th>EFECTIVO DISPONIBLE</th>
    <th>DIFERENCIA EFECTIVO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalVentas     = 0;
$TotalAbonos     = 0;
$TotalIngresos   = 0; 
$TotalEgresos    = 0;  
$TotalCaja       = 0;
$TotalEfectivo   = 0;
$TotalDiferencia = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalVentas     += $reg[$i]['ingresos']+$reg[$i]['creditos'];
$TotalAbonos     += $reg[$i]['abonos'];
$TotalIngresos   += $reg[$i]['ingresos2'];
$TotalEgresos    += $reg[$i]['egresos']+$reg[$i]['egresonotas'];
$TotalCaja       += $reg[$i]['efectivocaja'];
$TotalEfectivo   += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$reg[$i]['nrocaja'].":</strong><br>".$reg[$i]['nomcaja']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo "<strong>".$reg[$i]['dni'].":</strong><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaapertura']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaapertura']))."</strong>"; ?></td>
    <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechacierre']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacierre']))."</strong>"; ?></td>
    <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos2'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['egresos']+$reg[$i]['egresonotas'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['efectivocaja'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="3"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbonos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></strong></td>
  <?php } ?>
  </tr>
</table>
<?php
break;

case 'ARQUEOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarArqueosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "10"); ?>">REPORTE GENERAL DE APERTURAS DE CAJAS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>NOMBRE DE CAJA</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>RESPONSABLE</th>
    <th>APERTURA</th>
    <th>CIERRE</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>MONTO INICIAL</th>
    <th>TOTAL EN VENTAS</th>
    <th>TOTAL EN ABONOS</th>
    <th>OTROS INGRESOS</th>
    <th>TOTAL EN EGRESOS</th>
    <th>EFECTIVO EN CAJA</th>
    <th>EFECTIVO DISPONIBLE</th>
    <th>DIFERENCIA EFECTIVO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalVentas     = 0;
$TotalAbonos     = 0;
$TotalIngresos   = 0; 
$TotalEgresos    = 0;  
$TotalCaja       = 0;
$TotalEfectivo   = 0;
$TotalDiferencia = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalVentas     += $reg[$i]['ingresos']+$reg[$i]['creditos'];
$TotalAbonos     += $reg[$i]['abonos'];
$TotalIngresos   += $reg[$i]['ingresos2'];
$TotalEgresos    += $reg[$i]['egresos']+$reg[$i]['egresonotas'];
$TotalCaja       += $reg[$i]['efectivocaja'];
$TotalEfectivo   += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$reg[$i]['nrocaja'].":</strong><br>".$reg[$i]['nomcaja']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo "<strong>".$reg[$i]['dni'].":</strong><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaapertura']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaapertura']))."</strong>"; ?></td>
    <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d/m/Y",strtotime($reg[$i]['fechacierre']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechacierre']))."</strong>"; ?></td>
    <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos2'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['egresos']+$reg[$i]['egresonotas'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['efectivocaja'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="3"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbonos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></strong></td>
  <?php } ?>
  </tr>
</table>
<?php
break;

case 'MOVIMIENTOS':

$tra = new Login();
$reg = $tra->ListarMovimientos(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "8" : "8"); ?>">REPORTE GENERAL DE MOVIMIENTOS DE CAJAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>NOMBRE DE CAJA</th>
    <th>RESPONSABLE</th>
    <th>DESCRIPCIÓN</th>
    <th>TIPO</th>
    <th>MONTO</th>
    <th>MEDIO</th>
    <th>FECHA MOVIMIENTO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$reg[$i]['nrocaja'].":</strong><br>".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo "<strong>".$reg[$i]['dni'].":</strong><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <?php if($reg[$i]['tipomovimiento'] == "INGRESO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipomovimiento']; ?></td>
    <?php } elseif($reg[$i]['tipomovimiento'] == "EGRESO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f33155;color:#070707;"><?php echo $reg[$i]['tipomovimiento']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechamovimiento']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechamovimiento']))."</strong>"; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'MOVIMIENTOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarMovimientosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "7" : "7"); ?>">REPORTE GENERAL DE MOVIMIENTOS DE CAJAS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>RESPONSABLE</th>
    <th>DESCRIPCIÓN</th>
    <th>TIPO</th>
    <th>MONTO</th>
    <th>MEDIO</th>
    <th>FECHA MOVIMIENTO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$reg[$i]['dni'].":</strong><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <?php if($reg[$i]['tipomovimiento'] == "INGRESO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipomovimiento']; ?></td>
    <?php } elseif($reg[$i]['tipomovimiento'] == "EGRESO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f33155;color:#070707;"><?php echo $reg[$i]['tipomovimiento']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechamovimiento']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechamovimiento']))."</strong>"; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'INFORMECAJASXFECHAS':

$caja = new Login();
$caja = $caja->CajasPorId();
$simbolo = ($caja[0]['simbolo'] == "" ? "" : "<strong>".$caja[0]['simbolo']."</strong>");

$venta = new Login();
$venta = $venta->SumarVentasCajasxFechas();

$arqueo = new Login();
$arqueo = $arqueo->SumarArqueosCajasxFechas();

$TotalCompras   = $venta[0]['totalcompra'];
$TotalVentas    = $venta[0]['totalventa'];
$TotalImpuestos = $venta[0]['totaliva'];
$TotalIngresos  = $arqueo[0]['totalingresos']+$arqueo[0]['totalabonos'];
$TotalEgresos   = $arqueo[0]['totalegresos'];
$Balance        = ($TotalVentas+$TotalIngresos)-($TotalImpuestos);
$Disponible     = $Balance-$TotalEgresos;

$archivo = str_replace(" ", "_","INFORME DE (CAJA ".$caja[0]['nrocaja'].": ".$caja[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$caja[0]['cuitsucursal'].": ".$caja[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <table border="1" id="default_order" class="table2 table-striped table-bordered border display m-t-10">
  <thead>
  <tr class="warning-element text-left" style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="3">INFORME DE CAJA POR FECHAS</th>
  </tr>
  </thead>
  <tbody>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td style="background:#ece8e9;" colspan="2">TOTAL DE VENTAS</td>
    <td><?php echo $simbolo.number_format($venta[0]['totalventa'], 2, '.', ','); ?></td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td style="background:#ece8e9;" colspan="2">TOTAL DE INGRESOS</td>
    <td><?php echo $simbolo.number_format($arqueo[0]['totalingresos'], 2, '.', ','); ?></td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td style="background:#ece8e9;" colspan="2">ABONOS A CRÉDITOS</td>
    <td><?php echo $simbolo.number_format($arqueo[0]['totalabonos'], 2, '.', ','); ?></td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td style="background:#ece8e9;" colspan="2">TOTAL DE GASTOS (EGRESOS + NOTAS DE CRÉDITOS)</td>
    <td><?php echo $simbolo.number_format($arqueo[0]['totalegresos'], 2, '.', ','); ?></td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td style="background:#ece8e9;" colspan="2">TOTAL DE IMPUESTOS DE VENTAS <?php echo $NomImpuesto; ?> (<?php echo $ValorImpuesto; ?>%)</td>
    <td><?php echo $simbolo.number_format($venta[0]['totaliva'], 2, '.', ','); ?></td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td style="background:#ece8e9;" colspan="2">DISPONIBLE EN CAJA SIN IMPUESTOS</td>
    <td><?php echo $simbolo.number_format($Disponible, 2, '.', ','); ?></td>
  </tr>
  </tbody>
</table>
<?php
break;

case 'GANANCIASXFECHAS':

$ingresos = new Login();
$detalle_ingreso = $ingresos->BuscarIngresosxFechas(); 

$ganancias = new Login();
$reg = $ganancias->BuscarGananciasxFechas();  

$archivo = str_replace(" ", "_","GANANCIAS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>IMPUESTO</th>
    <th>DESC.</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioCompraTotal    = 0;
$PrecioVentaTotal     = 0;
$VendidosTotal        = 0;
$ImpuestosCompraTotal = 0;
$ImpuestosVentaTotal  = 0;
$CompraTotal          = 0;
$VentaTotal           = 0;
$TotalGanancia        = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal   += $reg[$i]['preciocompra'];
$PrecioVentaTotal    += $reg[$i]['precioventa'];
$VendidosTotal       += $reg[$i]['cantidad'];

$Descuento           = $reg[$i]['descproducto']/100;
$PrecioDescuento     = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal         = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorIva = 1 + ($reg[$i]['ivaproducto']/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['cantidad'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorIva;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['cantidad'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['cantidad'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['cantidad'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra;
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>
    <td><?php echo '&nbsp;'.$reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="11"></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
</table>

  <table border="1" id="default_order" class="table2 table-striped table-bordered border display m-t-10">
    <thead>
    <tr class="warning-element text-left" style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
      <th colspan="3">DETALLES DE GANANCIAS / INGRESOS / GASTOS</th>
    </tr>
    </thead>
    <tbody>
    <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
      <td style="background:#ece8e9;" colspan="2">TOTAL DE GANANCIAS</td>
      <td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
    </tr>
    <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
      <td style="background:#ece8e9;" colspan="2">INGRESOS ADICIONALES</td>
      <td><?php echo $simbolo.number_format($detalle_ingreso[0]['totalingresos'], 2, '.', ','); ?></td>
    </tr>
    <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
      <td style="background:#ece8e9;" colspan="2">GASTOS</td>
      <td><?php echo $simbolo.number_format($detalle_ingreso[0]['totalegresos'], 2, '.', ','); ?></td>
    </tr>
    <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
      <td style="background:#ece8e9;" colspan="2">TOTAL</td>
      <td><?php echo $simbolo.number_format($TotalGanancia+$detalle_ingreso[0]['totalingresos']-$detalle_ingreso[0]['totalegresos'], 2, '.', ','); ?></td>
    </tr>
    </tbody>
  </table>
<?php
break;
############################### MODULO DE CAJAS ###############################

















################################## MODULO DE VENTAS ###################################
case 'VENTAS':

$tra = new Login();
$reg = $tra->ListarVentas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "15" : "8"); ?>">REPORTE GENERAL DE VENTAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <?php if($reg[$i]['tipopago'] == "CONTADO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } elseif($reg[$i]['tipopago'] == "CREDITO") { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } ?>

    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <?php } ?>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>

    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'VENTASXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaVentas(); 

if($_GET['tipobusqueda'] == 1){
$archivo = str_replace(" ", "_","LISTADO DE VENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
} else
if($_GET['tipobusqueda'] == 2){
$archivo = str_replace(" ", "_","LISTADO DE VENTAS POR BÚSQUEDA (".$_GET["search_criterio"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 3){
$archivo = str_replace(" ", "_","LISTADO DE VENTAS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "15" : "8"); ?>">REPORTE GENERAL DE VENTAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
}  
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <?php if($reg[$i]['tipopago'] == "CONTADO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } elseif($reg[$i]['tipopago'] == "CREDITO") { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } ?>

    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <?php } ?>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>

    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'VENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarVentasxCajas();

if(decrypt($_GET['tipopago']) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS GENERALES EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "16" : "9"); ?>">REPORTE GENERAL DE VENTAS POR CAJAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>

    <?php if($reg[$i]['tipopago'] == "CONTADO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } elseif($reg[$i]['tipopago'] == "CREDITO") { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } ?>

    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <?php } ?>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'VENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarVentasxFechas(); 

if(decrypt($_GET['tipopago']) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS GENERALES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "16" : "9"); ?>">REPORTE GENERAL DE VENTAS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
}  
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>

    <?php if($reg[$i]['tipopago'] == "CONTADO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } elseif($reg[$i]['tipopago'] == "CREDITO") { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } ?>

    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <?php } ?>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'VENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarVentasxClientes(); 

if(decrypt($_GET['tipopago']) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS GENERALES DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITO DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "15" : "8"); ?>">REPORTE GENERAL DE VENTAS POR CLIENTES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>TIPO DE PAGO</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
  
    <?php if($reg[$i]['tipopago'] == "CONTADO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } elseif($reg[$i]['tipopago'] == "CREDITO") { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } ?>

    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <?php } ?>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'VENTASXCONDICIONES':

$tra = new Login();
$reg = $tra->BuscarVentasxCondiciones(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO EN (FORMA DE PAGO: ".$reg[0]["mediopago"]." DE CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." Y FECHA DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "10"); ?>">REPORTE GENERAL DE VENTAS A CONTADO EN <?php echo $reg[0]["mediopago"]; ?></th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>ESTADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL PAGADO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;
$ImportePagado   = 0;
$TotalPagado     = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
}
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
$ImportePagado   =  $reg[$i]['suma_pagado'];
$TotalPagado     += $reg[$i]['suma_pagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>

    <?php if($reg[$i]['tipopago'] == "CONTADO"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } elseif($reg[$i]['tipopago'] == "CREDITO") { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]['tipopago']; ?></td>
    <?php } ?>

    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <?php } ?>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($ImportePagado, 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalPagado, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMISIONXVENTAS':

$tra = new Login();
$reg = $tra->BuscarComisionxVentas(); 

if(decrypt($_GET['tipopago']) == 1){ 
$archivo = str_replace(" ", "_","LISTADO COMISIÓN DE VENTAS GENERALES DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 2){ 
$archivo = str_replace(" ", "_","LISTADO COMISIÓN DE VENTAS A CONTADO DEL ESPECIALISTA (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 3){ 
$archivo = str_replace(" ", "_","LISTADO COMISIÓN DE VENTAS A CRÉDITO DEL ESPECIALISTA (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "9" : "9"); ?>">REPORTE GENERAL DE COMISIÓN POR VENTAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>FECHA EMISIÓN</th>
    <th>COMISIÓN (%)</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <th>TOTAL FACTURA</th>
    <th>TOTAL COMISIÓN</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos = 0;
$TotalImporte   = 0;
$TotalComision  = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 

$TotalArticulos += $reg[$i]['articulos']; 
$TotalImporte   += $reg[$i]['totalpago'];
$TotalComision  += $reg[$i]['totalpago']*$reg[$i]['comision']/100;
?>
  <tr class="text-center" class="even_row">
    <td><?php echo $a++; ?></td>
     <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <td><?php echo number_format($reg[$i]['comision'], 2, '.', ','); ?>%</td>
    <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['comision'], 2, '.', ','); ?>%</sup></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="6"></td>
    <td><strong><?php echo $TotalArticulos; ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESVENTASXCONDICIONES':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxCondiciones(); 

if(decrypt($_GET['tipopago']) == 1){

  if(decrypt($_GET['tipodetalle']) == 0){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES (POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 1){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES (DE PRODUCTOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 2){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES (DE COMBOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 3){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES (DE SERVICIOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } 

} elseif(decrypt($_GET['tipopago']) == 2){

  if(decrypt($_GET['tipodetalle']) == 0){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO (POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 1){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO (DE PRODUCTOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 2){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO (DE COMBOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 3){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO (DE SERVICIOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  }
 
} elseif(decrypt($_GET['tipopago']) == 3){

  if(decrypt($_GET['tipodetalle']) == 0){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO (POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 1){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO (DE PRODUCTOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 2){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO (DE COMBOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  } elseif(decrypt($_GET['tipodetalle']) == 3){
    $archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO (DE SERVICIOS POR FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
  }   
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE VENTAS POR CONDICIONES</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>FACTURADO</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal     = 0;
$ExisteTotal     = 0;
$VendidosTotal   = 0;
$PagoTotal       = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxFechas(); 

if(decrypt($_GET['tipopago']) == 1){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 2){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 3){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE VENTAS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>FACTURADO</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal     = 0;
$ExisteTotal     = 0;
$VendidosTotal   = 0;
$PagoTotal       = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxVendedor(); 

if(decrypt($_GET['tipopago']) == 1){ 
$archivo = str_replace(" ", "_","DETALLES DE FACTURACIÓN VENTAS POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 2){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
} elseif(decrypt($_GET['tipopago']) == 3){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "12"); ?>">REPORTE GENERAL DETALLES DE VENTAS POR VENDEDOR</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>DETALLE</th>
    <th>DESCRIPCIÓN</th>
    <th>PRESENTACIÓN</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <th>IMPUESTO</th>
    <th>PRECIO VENTA</th>
    <th>STOCK</th>
    <th>FACTURADO</th>
    <th>MONTO TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal     = 0;
$ExisteTotal     = 0;
$VendidosTotal   = 0;
$PagoTotal       = 0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo         = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal     += $reg[$i]['precioventa'];
$ExisteTotal     += $reg[$i]['existencia'];
$VendidosTotal   += $reg[$i]['cantidad']; 

$Descuento       =  $reg[$i]['descproducto']/100;
$PrecioDescuento =  $reg[$i]['precioventa']*$Descuento;
$PrecioFinal     =  $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal       += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <?php if($reg[$i]['tipodetalle'] == 1){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;">PRODUCTO</td>
    <?php } elseif($reg[$i]['tipodetalle']==2) { ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;">COMBO</td>
    <?php } elseif($reg[$i]['tipodetalle']==3) { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#707cd2;color:#070707;">SERVICIO</td>
    <?php } ?>    
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
################################## MODULO DE VENTAS ################################
















################################## MODULO DE CREDITOS #################################
case 'CREDITOS':

$tra = new Login();
$reg = $tra->ListarCreditos(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE VENTAS A CRÉDITOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
}

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>

    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSXBUSQUEDA':

$tra = new Login();
$reg = $tra->BusquedaCreditos(); 

if($_GET['tipobusqueda'] == 1){
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
} else
if($_GET['tipobusqueda'] == 2){
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS POR BÚSQUEDA (".$_GET["search_criterio"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif($_GET['tipobusqueda'] == 3){
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS POR FECHAS (DESDE ".date("d/m/Y", strtotime($_GET["desde"]))." HASTA ".date("d/m/Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE VENTAS A CRÉDITOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
}

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>

    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'ABONOSCREDITOSVENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarAbonosCreditosVentasxCajas();

$archivo = str_replace(" ", "_","LISTADO ABONOS DE VENTAS A CREDITOS EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." CONDICIÓN DE PAGO: ".$reg[0]["mediopago"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "9" : "9"); ?>">REPORTE GENERAL DE ABONOS EN <?php echo $reg[0]["mediopago"]; ?> DE VENTAS A CRÉDITOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>Nº DE DOCUMENTO</th>
    <th>NOMBRE DE CLIENTE</th>
    <th>FORMA DE ABONO</th>
    <th>FECHA DE ABONO</th>
    <th>Nº DE COMPROBANTE</th>
    <th>NOMBRE DE BANCO</th>
    <th>MONTO ABONO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte   = 0;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 

$TotalImporte += $reg[$i]['montoabono'];
?>
  <tr class="text-center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).":</strong><br> ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaabono']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaabono']))."</strong>"; ?></td>
    <td><?php echo $reg[$i]['comprobante'] == '' ? "********" : $reg[$i]['comprobante']; ?></td>
    <td><?php echo $reg[$i]['codbanco'] == '0' ? "********" : $reg[$i]['nombanco']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSVENTASXCONDICIONES':

$tra = new Login();
$reg = $tra->BuscarCreditosVentasxCondiciones();

$tipobusqueda = limpiar($_GET["tipobusqueda"]); 

if(decrypt($tipobusqueda) == 1){
$detalle = "EN GENERAL"; 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN GENERAL (DE SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($tipobusqueda) == 2){ 
$detalle = "PAGADAS";
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PAGADAS (DE SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($tipobusqueda) == 3){ 
$detalle = "PENDIENTES";
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PENDIENTES (DE SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
} elseif(decrypt($tipobusqueda) == 4){ 
$detalle = "VENCIDAS";
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS VENCIDAS (DE SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE VENTAS A CRÉDITOS <?php echo $detalle; ?></th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
}

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosVentasxFechas();

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "8"); ?>">REPORTE GENERAL DE VENTAS A CRÉDITOS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSVENTASXFECHAS_AGRUPADO':

$tra = new Login();
$reg = $tra->BuscarCreditosVentasxFechasAgrupado();

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","LISTADO_DE_CREDITOS_AGRUPADOS_POR_CLIENTE_GENERAL_(DESDE_".date("d-m-Y", strtotime($_GET["desde"]))."_HASTA_".date("d-m-Y", strtotime($_GET["hasta"]))."_SUCURSAL_".$reg[0]['cuitsucursal']."_".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","LISTADO_DE_CREDITOS_AGRUPADOS_POR_CLIENTE_PAGADOS_(DESDE_".date("d-m-Y", strtotime($_GET["desde"]))."_HASTA_".date("d-m-Y", strtotime($_GET["hasta"]))."_SUCURSAL_".$reg[0]['cuitsucursal']."_".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","LISTADO_DE_CREDITOS_AGRUPADOS_POR_CLIENTE_PENDIENTES_(DESDE_".date("d-m-Y", strtotime($_GET["desde"]))."_HASTA_".date("d-m-Y", strtotime($_GET["hasta"]))."_SUCURSAL_".$reg[0]['cuitsucursal']."_".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#dc3545;font-weight:bold;font-size:20px;color:#ffffff;">
    <th colspan="9">REPORTE DE CRÉDITOS AGRUPADOS POR CLIENTE</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:14px;color:#070707;">
    <th colspan="9">
      <?php if ($_SESSION["acceso"]=="administradorG") { ?>Sucursal: <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      Estado: <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; } ?><br>
      Desde: <?php echo date("d/m/Y", strtotime($_GET["desde"])); ?> - Hasta: <?php echo date("d/m/Y", strtotime($_GET["hasta"])); ?>
    </th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']." ");

// Variables para agrupar por cliente
$clienteActual = "";
$totalClienteFactura = 0;
$totalClienteAbonado = 0;
$totalClientePendiente = 0;

// Variables para totales generales
$totalGeneralFactura = 0;
$totalGeneralAbonado = 0;
$totalGeneralPendiente = 0;

for($i=0;$i<sizeof($reg);$i++){

// Identificador único del cliente
$clienteID = $reg[$i]['codcliente'];
$clienteNombre = $reg[$i]['nomcliente'];
$clienteDNI = $reg[$i]['dnicliente'];
$clienteDocumento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']);
$clienteTelefono = $reg[$i]['tlfcliente'];
$clienteDireccion = $reg[$i]['direccliente'];

// Si cambia el cliente, mostrar subtotal del anterior y encabezado del nuevo
if($clienteActual != "" && $clienteActual != $clienteID){
    // Mostrar subtotal del cliente anterior
    ?>
  <tr style="text-align:left;font-weight:bold;font-size:14px;background:#e9ecef;color:#070707;">
    <td colspan="5" style="text-align:right;">SUBTOTAL <?php echo strtoupper($reg[$i-1]['nomcliente']); ?>:</td>
    <td><?php echo $simbolo.number_format($totalClienteFactura, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalClienteAbonado, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalClientePendiente, 2, '.', ','); ?></td>
    <td></td>
  </tr>
    <?php
    // Reiniciar contadores del cliente
    $totalClienteFactura = 0;
    $totalClienteAbonado = 0;
    $totalClientePendiente = 0;
}

// Si es un nuevo cliente, mostrar encabezado
if($clienteActual != $clienteID){
    ?>
  <tr style="background:#f8f9fa;font-weight:bold;font-size:15px;color:#dc3545;">
    <td colspan="9">
      CLIENTE: <?php echo strtoupper($clienteNombre); ?> | 
      <?php echo $clienteDocumento; ?>: <?php echo $clienteDNI; ?>
      <?php if($clienteTelefono != ""){ ?> | Tel: <?php echo $clienteTelefono; ?><?php } ?>
      <?php if($clienteDireccion != ""){ ?> | Dir: <?php echo $clienteDireccion; ?><?php } ?>
    </td>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:13px;color:#070707;">
    <th>N°</th>
    <th>Nº FACTURA</th>
    <th>FECHA EMISIÓN</th>
    <th>FECHA VENC.</th>
    <th>ESTADO</th>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    <th>OBSERVACIONES</th>
  </tr>
    <?php
    $clienteActual = $clienteID;
}

// Determinar tipo de documento
if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
    $tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
    $tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
    $tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
    $tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
    $tipo_documento = "GUIA DE REMISION";
}

// Calcular totales
$totalFactura = $reg[$i]['totalpago'];
$totalAbonado = $reg[$i]['creditopagado'];
$totalPendiente = $totalFactura - $totalAbonado;

// Acumular en subtotales del cliente
$totalClienteFactura += $totalFactura;
$totalClienteAbonado += $totalAbonado;
$totalClientePendiente += $totalPendiente;

// Acumular en totales generales
$totalGeneralFactura += $totalFactura;
$totalGeneralAbonado += $totalAbonado;
$totalGeneralPendiente += $totalPendiente;

// Estado de la venta
if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado_style = "background-color:#2cabe3;";
    $estado_texto = $reg[$i]["statusventa"];
} elseif($reg[$i]["statusventa"] == 'ANULADA'){ 
    $estado_style = "background-color:#f0ad4e;";
    $estado_texto = $reg[$i]["statusventa"];
} elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ 
    $estado_style = "background-color:#e23f1e;";
    $estado_texto = "VENCIDA";
} else { 
    $estado_style = "background-color:#2cd07e;";
    $estado_texto = $reg[$i]["statusventa"];
}

$numero_fila = $i + 1;
?>
  <tr class="even_row">
    <td><?php echo $numero_fila; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:13px;color:#070707;"><?php echo $tipo_documento.": ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))." ".date("H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td style="text-align:center;font-weight:bold;font-size:13px;<?php echo $estado_style; ?>color:#070707;"><?php echo $estado_texto; ?></td>
    <td><?php echo $simbolo.number_format($totalFactura, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalAbonado, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalPendiente, 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***" : $reg[$i]['observaciones']; ?></td>
  </tr>
<?php 
} 

// Mostrar subtotal del último cliente
if($clienteActual != ""){
?>
  <tr style="text-align:left;font-weight:bold;font-size:14px;background:#e9ecef;color:#070707;">
    <td colspan="5" style="text-align:right;">SUBTOTAL <?php echo strtoupper($reg[sizeof($reg)-1]['nomcliente']); ?>:</td>
    <td><?php echo $simbolo.number_format($totalClienteFactura, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalClienteAbonado, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalClientePendiente, 2, '.', ','); ?></td>
    <td></td>
  </tr>
<?php } ?>

  <!-- TOTAL GENERAL -->
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#dc3545;color:#ffffff;">
    <td colspan="5" style="text-align:right;">TOTAL GENERAL:</td>
    <td><?php echo $simbolo.number_format($totalGeneralFactura, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalGeneralAbonado, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($totalGeneralPendiente, 2, '.', ','); ?></td>
    <td></td>
  </tr>
<?php } ?>
</table>
<?php
break;

case 'CREDITOSVENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarCreditosVentasxClientes(); 

$status = limpiar($_GET["status"]); 
if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITOS EN GENERAL DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITOS PAGADAS DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITOS PENDIENTES DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "7"); ?>">REPORTE GENERAL DE VENTAS A CRÉDITOS POR CLIENTE</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESCREDITOSVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosVentasxFechas();

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "14" : "8"); ?>">REPORTE GENERAL DE DETALLES VENTAS A CRÉDITOS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>DETALLES DE ABONOS</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_abonos']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESCREDITOSVENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosVentasxClientes();

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS EN GENERAL DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 2){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PAGADAS DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} elseif(decrypt($status) == 3){ 
$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PENDIENTES DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "13" : "7"); ?>">REPORTE GENERAL DE DETALLES VENTAS A CRÉDITOS POR CLIENTE</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>DETALLES DE ABONOS</th>
    <?php } ?>
    <th>TOTAL FACTURA</th>
    <th>TOTAL ABONADO</th>
    <th>TOTAL PENDIENTE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte = 0;
$TotalAbono   = 0;
$TotalDebe    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

if($reg[$i]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[$i]['tipodocumento'] == 'NOTA_VENTA_A4'){
$tipo_documento = "NOTA DE VENTA";
} elseif($reg[$i]['tipodocumento'] == 'TICKET_8' || $reg[$i]['tipodocumento'] == 'TICKET_5'){
$tipo_documento = "TICKET";
} elseif($reg[$i]['tipodocumento'] == 'BOLETA_8' || $reg[$i]['tipodocumento'] == 'BOLETA_5' || $reg[$i]['tipodocumento'] == 'BOLETA_A4'){
$tipo_documento = "BOLETA";
} elseif($reg[$i]['tipodocumento'] == 'FACTURA_A4' || $reg[$i]['tipodocumento'] == 'FACTURA'){
$tipo_documento = "FACTURA";
} elseif($reg[$i]['tipodocumento'] == 'GUIA_REMISION'){
$tipo_documento = "GUIA DE REMISION";
} 

$TotalImporte += $reg[$i]['totalpago'];
$TotalAbono   += $reg[$i]['creditopagado'];
$TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento.":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><strong>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</strong>"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <?php if($reg[$i]["statusventa"] == 'PAGADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cabe3;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]["statusventa"] == 'ANULADA'){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#f0ad4e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){ ?>
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#e23f1e;color:#070707;">VENCIDA</td>
    <?php } else { ?> 
    <td style="text-align:left;font-weight:bold;font-size:14px;background-color:#2cd07e;color:#070707;"><?php echo $reg[$i]["statusventa"]; ?></td>
    <?php } ?>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_abonos']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
################################# MODULO DE CREDITOS ###################################













############################### MODULO DE CREDITOS ###############################
case 'NOTASCREDITO':

$tra = new Login();
$reg = $tra->ListarNotasCreditos(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITO EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "9"); ?>">REPORTE GENERAL DE NOTAS DE CRÉDITOS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DOCUMENTO DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>FECHA DE EMISIÓN</th>
    <th>MOTIVO DE NOTA</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $reg[$i]['tipofacturaventa'].":<br>".'&nbsp;'.$reg[$i]['facturaventa']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXCAJAS':

$tra = new Login();
$reg = $tra->BuscarNotasCreditosxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "9"); ?>">REPORTE GENERAL DE NOTAS DE CRÉDITOS POR CAJAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DOCUMENTO DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>FECHA DE EMISIÓN</th>
    <th>MOTIVO DE NOTA</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $reg[$i]['tipofacturaventa'].":<br>".'&nbsp;'.$reg[$i]['facturaventa']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarNotasCreditosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "12" : "9"); ?>">REPORTE GENERAL DE NOTAS DE CRÉDITOS POR FECHAS</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DOCUMENTO DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>FECHA DE EMISIÓN</th>
    <th>MOTIVO DE NOTA</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $reg[$i]['tipofacturaventa'].":<br>".'&nbsp;'.$reg[$i]['facturaventa']; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<strong>CONSUMIDOR FINAL</strong>";
    } else {
    echo "<strong>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</strong><br> ".$reg[$i]['nomcliente']; } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarNotasCreditosxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]['nomcliente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr style="background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <th colspan="<?php echo ($documento == "EXCEL" ? "11" : "8"); ?>">REPORTE GENERAL DE NOTAS DE CRÉDITOS POR CLIENTE</th>
  </tr>
  <tr style="background:#ece8e9;font-weight:bold;font-size:16px;color:#070707;">
    <th>Nº</th>
    <th>Nº DE FACTURA</th>
    <th>DOCUMENTO DE VENTA</th>
    <th>FECHA DE EMISIÓN</th>
    <th>MOTIVO DE NOTA</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCONTADO</th>
    <th>SUBTOTAL</th>
    <th>TOTAL <?php echo $NomImpuesto; ?></th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos  += $reg[$i]['articulos'];
$TotalDescontado += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
$TotalSubtotal   += $reg[$i]['subtotal'];
$TotalIva        += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
$TotalDescuento  += $reg[$i]['totaldescuento'];
$TotalImporte    += $reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET").":<br>".'&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:14px;color:#070707;"><?php echo $reg[$i]['tipofacturaventa'].":<br>".'&nbsp;'.$reg[$i]['facturaventa']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr style="text-align:left;font-weight:bold;font-size:16px;background:#ece8e9;color:#070707;">
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalDescontado, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalIva, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
############################### MODULO DE CREDITOS ###############################

}
?>