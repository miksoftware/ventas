<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();

###################### DETALLE DE IMPUESTO ######################
$imp           = new Login();
$imp           = $imp->ImpuestosPorId();
$NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
###################### DETALLE DE IMPUESTO ######################
    
$tra = new Login();
?>

<?php
############################# CARGAR USUARIOS ############################
if (isset($_GET['CargaUsuarios'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>N° de Documento</th>
        <th>Nombres y Apellidos</th>
        <th>Nº de Teléfono</th>
        <th>Usuario</th>
        <th>Nivel</th>
        <th>Estado</th>
        <?php if ($_SESSION['acceso'] == "administradorG") { ?>
        <th>Sucursal</th>
        <?php } ?>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarUsuarios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON USUARIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['telefono']; ?></td>
    <td><?php echo $reg[$i]['usuario']; ?></td>
    <td><?php echo $reg[$i]['nivel']; ?></td>
    <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <?php if ($_SESSION['acceso'] == "administradorG") { ?><td class="text-dark alert-link"><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalUser" title="Editar" onClick="UpdateUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["dni"]; ?>','<?php echo $reg[$i]["nombres"]; ?>','<?php echo $reg[$i]["sexo"]; ?>','<?php echo $reg[$i]["direccion"]; ?>','<?php echo $reg[$i]["telefono"]; ?>','<?php echo $reg[$i]["email"]; ?>','<?php echo $reg[$i]["usuario"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["status"]; ?>','<?php echo number_format($reg[$i]["comision"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]['limite_descuento'], 2, '.', ''); ?>','<?php echo $reg[$i]["codsucursal"] == '0' ? encrypt("0") : encrypt($reg[$i]["codsucursal"]); ?>','update'); CargarSucursalesAsignadasxUsuarios('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["gruposid"]; ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <?php if($reg[$i]["status"] == 1){ ?>
    <span class="text-primary" style="cursor: pointer;" title="Inactivar Usuario" onClick="EstadoUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["status"]); ?>','<?php echo encrypt("ESTADOUSUARIO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg></span>
    <?php } else { ?>
    <span class="text-warning" style="cursor: pointer;" title="Activar Usuario" onClick="EstadoUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["status"]); ?>','<?php echo encrypt("ESTADOUSUARIO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg></span>
    <?php } ?>
                                 
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["dni"]); ?>','<?php echo encrypt("USUARIOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR USUARIOS ############################
?>


<?php
############################# CARGAR LOGS DE USUARIOS ############################
if (isset($_GET['CargaLogs'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Ip de Máquina</th>
            <th>Fecha</th>
            <th>Navegador</th>
            <th>Usuario</th>
            <?php if($_SESSION['acceso']=="administradorG"){ ?>
            <th>Sucursal</th><?php } ?>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaLogs();

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS DE ACCESO ACTUALMENTE</center>";
  echo "</div>";
  exit;    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['ip']; ?></td>
    <td><?php echo $reg[$i]['tiempo']; ?></td>
    <td><?php echo $reg[$i]['detalles']; ?></td>
    <td><?php echo $reg[$i]['usuario']; ?></td>
    <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR LOGS DE USUARIOS ############################
?>


<?php
############################# CARGAR PROVINCIAS ############################
if (isset($_GET['CargaProvincias'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Provincias</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarProvincias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVINCIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['id_provincia']; ?></td>
    <td><?php echo $reg[$i]['provincia']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalProvincia" title="Editar" onClick="UpdateProvincia('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["provincia"]; ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarProvincia('<?php echo encrypt($reg[$i]["id_provincia"]); ?>','<?php echo encrypt("PROVINCIAS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PROVINCIAS ############################
?>


<?php
############################# CARGAR DEPARTAMENTOS ############################
if (isset($_GET['CargaDepartamentos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Departamento</th>
            <th>Provincia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDepartamentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DEPARTAMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['id_departamento']; ?></td>
    <td><?php echo $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['provincia']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDepartamento" title="Editar" onClick="UpdateDepartamento('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDepartamento('<?php echo encrypt($reg[$i]["id_departamento"]); ?>','<?php echo encrypt("DEPARTAMENTOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR DEPARTAMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE DOCUMENTOS ############################
if (isset($_GET['CargaDocumentos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">

    <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Nombre</th>
            <th>Descripción de Documento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDocumentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DOCUMENTOS ACTUALMENTE </center>";
    echo "</div>";   

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['descripcion']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDocumento" title="Editar" onClick="UpdateDocumento('<?php echo $reg[$i]["coddocumento"]; ?>','<?php echo $reg[$i]["documento"]; ?>','<?php echo $reg[$i]["descripcion"]; ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDocumento('<?php echo encrypt($reg[$i]["coddocumento"]); ?>','<?php echo encrypt("DOCUMENTOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TIPOS DE DOCUMENTOS ############################
?>






<?php
############################# CARGAR TIPOS DE MONEDA ############################
if (isset($_GET['CargaMonedas'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">

    <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Nombre de Moneda</th>
            <th>Siglas</th>
            <th>Simbolo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoMoneda();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE MONEDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['moneda']; ?></td>
    <td><?php echo $reg[$i]['siglas']; ?></td>
    <td><?php echo $reg[$i]['simbolo']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalMoneda" title="Editar" onClick="UpdateTipoMoneda('<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["moneda"]; ?>','<?php echo $reg[$i]["siglas"]; ?>','<?php echo $reg[$i]["simbolo"]; ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarTipoMoneda('<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo encrypt("TIPOMONEDA"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TIPOS DE MONEDA ############################
?>









<?php
############################# CARGAR TIPOS DE CAMBIO X SUCURSAL ############################
if (isset($_GET['BuscaTiposCambiosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Tipos de Cambio</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Cambio" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalTipoCambio" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxTipoCambio('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("TIPOCAMBIO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TIPOCAMBIO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TIPOCAMBIO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Descripción de Cambio</th>
                    <th>Monto de Cambio</th>
                    <th>Tipo Moneda</th>
                    <th>Fecha Ingreso</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIOS DE MONEDA ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
    <td><?php echo $reg[$i]['montocambio']; ?></td>
    <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
    <td>
    <?php if(date("d-m-Y",strtotime($reg[$i]['fechacambio'])) == date("d-m-Y")) { ?>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalTipoCambio" title="Editar" onClick="UpdateTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo $reg[$i]["montocambio"]; ?>','<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>
    <?php } ?>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("TIPOCAMBIO"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR TIPOS DE CAMBIO X SUCURSAL ############################
?>

<?php
############################# CARGAR TIPOS DE CAMBIO ############################
if (isset($_GET['CargaCambios'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Descripción de Cambio</th>
                <th>Monto de Cambio</th>
                <th>Tipo Moneda</th>
                <th>Fecha Ingreso</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO DE MONEDA ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
    <td><?php echo number_format($reg[$i]['montocambio'], 2, '.', ','); ?></td>
    <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
    <td>
    <?php if(date("d-m-Y",strtotime($reg[$i]['fechacambio'])) == date("d-m-Y")) { ?>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalTipoCambio" title="Editar" onClick="UpdateTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo $reg[$i]["montocambio"]; ?>','<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>
    <?php } ?>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("TIPOCAMBIO"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TIPOS DE CAMBIO ############################
?>

















<?php
############################# CARGAR MEDIOS DE PAGOS X SUCURSAL ############################
if (isset($_GET['BuscaMediosPagosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Formas de Pagos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Medio de Pago" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMedioPago" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMedioPago('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MEDIOSPAGOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MEDIOSPAGOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MEDIOSPAGOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Medio de Pago</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarMediosPagos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIOS DE PAGOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmediopago']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalMedioPago" title="Editar" onClick="UpdateMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo $reg[$i]["mediopago"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MEDIOSPAGOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MEDIOS DE PAGOS X SUCURSAL ############################
?>

<?php
############################# CARGAR MEDIOS DE PAGOS ############################
if (isset($_GET['CargaMediosPagos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Medio de Pago</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMediosPagos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIOS DE PAGOS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmediopago']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalMedioPago" title="Editar" onClick="UpdateMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo $reg[$i]["mediopago"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("MEDIOSPAGOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR MEDIOS DE PAGOS ############################
?>

















<?php
############################# CARGAR IMPUESTOS X SUCURSAL ############################
if (isset($_GET['BuscaImpuestosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Impuestos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Impuesto" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImpuesto" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxImpuesto('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("IMPUESTOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("IMPUESTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("IMPUESTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Impuesto</th>
                    <th>Valor (%)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codimpuesto']; ?></td>
    <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
    <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
    <td><?php echo $status = ($reg[$i]['statusimpuesto'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalImpuesto" title="Editar" onClick="UpdateImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo $reg[$i]["valorimpuesto"]; ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("IMPUESTOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR IMPUESTOS X SUCURSAL ############################
?>

<?php
############################# CARGAR IMPUESTOS ############################
if (isset($_GET['CargaImpuestos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">

        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Nombre de Impuesto</th>
            <th>Valor (%)</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codimpuesto']; ?></td>
    <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
    <td><?php echo number_format($reg[$i]['valorimpuesto'], 2, '.', ','); ?></td>
    <td><?php echo $status = ($reg[$i]['statusimpuesto'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalImpuesto" title="Editar" onClick="UpdateImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo $reg[$i]["valorimpuesto"]; ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("IMPUESTOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>   
<?php 
} 
############################# CARGAR IMPUESTOS ############################
?>


















<?php
############################# CARGAR BANCOS X SUCURSAL ############################
if (isset($_GET['BuscaBancosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Bancos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Banco" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalBanco" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxBanco('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("BANCOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("BANCOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("BANCOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Banco</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarBancos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON BANCOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codbanco']; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalBanco" title="Editar" onClick="UpdateBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo $reg[$i]["nombanco"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("IMPUESTOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
        </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR BANCOS X SUCURSAL ############################
?>

<?php
############################# CARGAR BANCOS ############################
if (isset($_GET['CargaBancos'])) { 
?>
    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Nombre de Banco</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarBancos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON BANCOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codbanco']; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalBanco" title="Editar" onClick="UpdateBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo $reg[$i]["nombanco"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("IMPUESTOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR BANCOS ############################
?>






<?php
############################# CARGAR SUCURSALES ############################
if (isset($_GET['CargaSucursales'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Logo</th>
        <th>N° de Documento</th>
        <th>Razón Social</th>
        <th>Nº de Teléfono</th>
        <th>Email</th>
        <th>Encargado</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarSucursales();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUCURSALES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php if (file_exists("fotos/sucursales/".$reg[$i]["cuitsucursal"].".png")){
    echo "<img src='fotos/sucursales/".$reg[$i]["cuitsucursal"].".png?' class='img-rounded' style='margin:0px;' width='60' height='40'>";
    } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?></td>
    <td><?php echo "<strong>".$documento = ($reg[$i]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).":</strong> ".$reg[$i]['cuitsucursal']; ?></td>
    <td class="text-dark alert-link"><?php echo $reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
    <td><?php echo $reg[$i]['correosucursal']; ?></td>
    <td><?php echo $reg[$i]['nomencargado']; ?></td>
    <td><?php echo $status = ( $reg[$i]['estado'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalSucursal" data-backdrop="static" data-keyboard="false" title="Editar" onClick="UpdateSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["nrosucursal"]; ?>','<?php echo $documento1 = ($reg[$i]["documsucursal"] == 0 ? "" : encrypt($reg[$i]["documsucursal"])); ?>','<?php echo $reg[$i]["cuitsucursal"]; ?>','<?php echo $reg[$i]["nomsucursal"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direcsucursal"]; ?>','<?php echo $reg[$i]["correosucursal"]; ?>','<?php echo $reg[$i]["tlfsucursal"]; ?>','<?php echo $reg[$i]["inicioticket"]; ?>','<?php echo $reg[$i]["iniciofactura"]; ?>','<?php echo $reg[$i]["inicioguia"]; ?>','<?php echo $reg[$i]["inicionotaventa"]; ?>','<?php echo $reg[$i]["inicionotacredito"]; ?>','<?php echo $reg[$i]["nroactividadsucursal"]; ?>','<?php echo date('d-m-Y', strtotime($reg[$i]["fechaautorsucursal"])); ?>','<?php echo $reg[$i]["llevacontabilidad"]; ?>','<?php echo $documento2 = ($reg[$i]["documencargado"] == 0 ? "" : encrypt($reg[$i]["documencargado"])); ?>','<?php echo $reg[$i]["dniencargado"]; ?>','<?php echo $reg[$i]["nomencargado"]; ?>','<?php echo $reg[$i]["tlfencargado"]; ?>','<?php echo number_format($reg[$i]["descsucursal"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["porcentaje"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo encrypt($reg[$i]["codmoneda2"]); ?>','<?php echo preg_replace("/\r\n|\r|\n/",'\n',$reg[$i]['membrete']); ?>','<?php echo $reg[$i]["mostrar_pos"]; ?>','<?php echo $reg[$i]["ticket_general"]; ?>','update'); SelectDepartamento('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

     <?php if($_SESSION['acceso'] == "administradorG" && $reg[$i]["estado"] == 1){ ?>
    <span class="text-primary" style="cursor: pointer;" title="Inactivar Sucursal" onClick="EstadoSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["estado"]); ?>','<?php echo encrypt("ESTADOSUCURSAL") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></span>
    <?php } else if($_SESSION['acceso'] == "administradorG" && $reg[$i]["estado"] == 0){ ?>
    <span class="text-warning" style="cursor: pointer;" title="Activar Sucursal" onClick="EstadoSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["estado"]); ?>','<?php echo encrypt("ESTADOSUCURSAL") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></span>
    <?php } ?>

    <?php if ($_SESSION['acceso'] == "administradorG") { ?><span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("SUCURSALES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span><?php } ?>
            </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR SUCURSALES ############################
?>










<?php
############################# CARGAR FAMILIAS X SUCURSAL ############################
if (isset($_GET['BuscaFamiliasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Familias</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Familia" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalFamilia" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxFamilia('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FAMILIAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("FAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("FAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Familias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarFamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FAMILIAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalFamilia" title="Editar" onClick="UpdateFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo $reg[$i]["nomfamilia"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("FAMILIAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR FAMILIAS X SUCURSAL ############################
?>

<?php
############################# CARGAR FAMILIAS ############################
if (isset($_GET['CargaFamilias'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                    <thead>
                    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                        <th>N°</th>
                        <th>Código</th>
                        <th>Nombre de Familias</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarFamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FAMILIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalFamilia" title="Editar" onClick="UpdateFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo $reg[$i]["nomfamilia"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("FAMILIAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR FAMILIAS ############################
?>











<?php
############################# CARGAR SUBFAMILIAS X SUCURSAL ############################
if (isset($_GET['BuscaSubfamiliasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Subfamilias</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Subfamilia" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSubfamilia" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxSubfamilia('<?php echo $codsucursal; ?>');CargaFamiliasxSucursal('<?php echo $codsucursal; ?>','0');"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("SUBFAMILIAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SUBFAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SUBFAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Familias</th>
                    <th>Nombre de Subfamilias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarSubfamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUBFAMILIAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalSubfamilia" title="Editar" onClick="UpdateSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo $reg[$i]["nomsubfamilia"]; ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); CargaFamiliasxSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("SUBFAMILIAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR SUBFAMILIAS X SUCURSAL ############################
?>

<?php
############################# CARGAR SUBFAMILIAS ############################
if (isset($_GET['CargaSubfamilias'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">

                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Familias</th>
                    <th>Nombre de Subfamilias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarSubfamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUBFAMILIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalSubfamilia" title="Editar" onClick="UpdateSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo $reg[$i]["nomsubfamilia"]; ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); CargaFamiliasxSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("SUBFAMILIAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR SUBFAMILIAS ############################
?>












<?php
############################# CARGAR MARCAS X SUCURSAL ############################
if (isset($_GET['BuscaMarcasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Marcas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Marca" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMarca" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMarca('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MARCAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MARCAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MARCAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Marcas</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarMarcas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmarca']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalMarca" title="Editar" onClick="UpdateMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo $reg[$i]["nommarca"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MARCAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MARCAS X SUCURSAL ############################
?>

<?php
############################# CARGAR MARCAS ############################
if (isset($_GET['CargaMarcas'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Nombre de Marcas</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMarcas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmarca']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalMarca" title="Editar" onClick="UpdateMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo $reg[$i]["nommarca"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo "3"; ?>','<?php echo encrypt("MARCAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR MARCAS ############################
?>












<?php
############################# CARGAR MODELOS X SUCURSAL ############################
if (isset($_GET['BuscaModelosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Modelos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Modelo" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalModelo" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxModelo('<?php echo $codsucursal; ?>');CargaMarcasxSucursal('<?php echo $codsucursal; ?>','0');"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MODELOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MODELOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MODELOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Marcas</th>
                    <th>Nombre de Modelos</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarModelos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MODELOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmodelo']; ?></td>
    <td><?php echo $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalModelo" title="Editar" onClick="UpdateModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo $reg[$i]["nommodelo"]; ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); CargaMarcasxSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MODELOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MODELOS X SUCURSAL ############################
?>

<?php
############################# CARGAR MODELOS ############################
if (isset($_GET['CargaModelos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Nombre de Marcas</th>
            <th>Nombre de Modelos</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarModelos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MODELOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codmodelo']; ?></td>
    <td><?php echo $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalModelo" title="Editar" onClick="UpdateModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo $reg[$i]["nommodelo"]; ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); CargaMarcasxSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("MODELOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR MODELOS ############################
?>















<?php
############################# CARGAR PRESENTACIONES X SUCURSAL ############################
if (isset($_GET['BuscaPresentacionesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Presentaciones</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Presentación" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPresentacion" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxPresentacion('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRESENTACIONES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRESENTACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRESENTACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Presentación</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarPresentaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRESENTACIONES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codpresentacion']; ?></td>
    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalPresentacion" title="Editar" onClick="UpdatePresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo $reg[$i]["nompresentacion"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarPresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("PRESENTACIONES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PRESENTACIONES X SUCURSAL ############################
?>

<?php
############################# CARGAR PRESENTACIONES ############################
if (isset($_GET['CargaPresentaciones'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Código</th>
        <th>Nombre de Presentación</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPresentaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRESENTACIONES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codpresentacion']; ?></td>
    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalPresentacion" title="Editar" onClick="UpdatePresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo $reg[$i]["nompresentacion"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarPresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("PRESENTACIONES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PRESENTACIONES ############################
?>












<?php
############################# CARGAR COLORES X SUCURSAL ############################
if (isset($_GET['BuscaColoresxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Colores</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Color" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalColor" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxColor('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COLORES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COLORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COLORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Color</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarColores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COLORES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcolor']; ?></td>
    <td><?php echo $reg[$i]['nomcolor']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalColor" title="Editar" onClick="UpdateColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo $reg[$i]["nomcolor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("COLORES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COLORES X SUCURSAL ############################
?>

<?php
############################# CARGAR COLORES ############################
if (isset($_GET['CargaColores'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">

        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Código</th>
            <th>Nombre de Color</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarColores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COLORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcolor']; ?></td>
    <td><?php echo $reg[$i]['nomcolor']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalColor" title="Editar" onClick="UpdateColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo $reg[$i]["nomcolor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("COLORES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR COLORES ############################
?>
















<?php
############################# CARGAR ORIGENES X SUCURSAL ############################
if (isset($_GET['BuscaOrigenesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Colores</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Origen" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalOrigen" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxOrigen('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("ORIGENES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ORIGENES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ORIGENES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Código</th>
                <th>Nombre de Origen</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarOrigenes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ORIGENES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codorigen']; ?></td>
    <td><?php echo $reg[$i]['nomorigen']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalOrigen" title="Editar" onClick="UpdateOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo $reg[$i]["nomorigen"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("ORIGENES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR ORIGENES X SUCURSAL ############################
?>

<?php
############################# CARGAR ORIGENES ############################
if (isset($_GET['CargaOrigenes'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombre de Origen</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarOrigenes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ORIGENES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codorigen']; ?></td>
    <td><?php echo $reg[$i]['nomorigen']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalOrigen" title="Editar" onClick="UpdateOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo $reg[$i]["nomorigen"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("ORIGENES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR ORIGENES ############################
?>














<?php
############################# CARGAR IMEIS X SUCURSAL ############################
if (isset($_GET['BuscaImeisxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Imeis</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Cambio" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalTipoCambio" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxImei('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                    <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                        
                        <a class="dropdown-item" href="reportepdf?var=<?php echo encrypt("0") ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("IMEIS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                        <a class="dropdown-item" href="reportepdf?var=<?php echo encrypt("1") ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("IMEIS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Imeis Activos</a>

                        <a class="dropdown-item" href="reportepdf?var=<?php echo encrypt("2") ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("IMEIS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Imeis Inactivos</a>

                        <a class="dropdown-item" href="reportepdf?var=<?php echo encrypt("3") ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("IMEIS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Imeis Vendidos</a>
                    </div>
                </div>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("IMEIS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("IMEIS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Nº de Imei</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarImei();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMEIS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['numeroimei']; ?></td>
    <td><?php echo $observaciones = ($reg[$i]['observaciones'] == "" ? "********" : $reg[$i]['observaciones']); ?></td>
    <td><?php
    $estado = $reg[$i]["estadoimei"];        
    // Si el estado es NULL o vacío
    if ($estado == 1) {
        echo "<span class='badge badge-info alert-link font-12'>ACTIVO</span>";
    } elseif ($estado == 2) {
        echo "<span class='badge badge-danger alert-link font-12'>INACTIVO</span>";
    } elseif ($estado == 3) {
        echo "<span class='badge badge-success alert-link font-12'>VENDIDO</span>";
    } elseif ($estado == 4) {
        echo "<span class='badge badge-warning alert-link font-12'>PENDIENTE</span>";
    }
    ?></td>
    <td>
    <?php if($reg[$i]['estadoimei'] == 1 || $reg[$i]['estadoimei'] == 3) { ?>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalImei" title="Editar" onClick="UpdateImei('<?php echo encrypt($reg[$i]["codimei"]); ?>','<?php echo $reg[$i]["numeroimei"]; ?>','<?php echo $reg[$i]["observaciones"]; ?>','<?php echo $reg[$i]["estadoimei"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarImei('<?php echo encrypt($reg[$i]["codimei"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("IMEI"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } else { ?>
    <span class='badge badge-success alert-link font-12'>VENDIDO</span>
    <?php } ?>
    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR IMEIS X SUCURSAL ############################
?>

<?php
############################# CARGAR IMEIS ############################
if (isset($_GET['CargaImeis'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Nº de Imei</th>
        <th>Observaciones</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarImei();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMEIS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['numeroimei']; ?></td>
    <td><?php echo $observaciones = ($reg[$i]['observaciones'] == "" ? "********" : $reg[$i]['observaciones']); ?></td>
    <td><?php
    $estado = $reg[$i]["estadoimei"];        
    // Si el estado es NULL o vacío
    if ($estado == 1) {
        echo "<span class='badge badge-info alert-link font-12'>ACTIVO</span>";
    } elseif ($estado == 2) {
        echo "<span class='badge badge-danger alert-link font-12'>INACTIVO</span>";
    } elseif ($estado == 3) {
        echo "<span class='badge badge-success alert-link font-12'>VENDIDO</span>";
    } elseif ($estado == 4) {
        echo "<span class='badge badge-warning alert-link font-12'>PENDIENTE</span>";
    }
    ?></td>
    <td>
    <?php if($reg[$i]['estadoimei'] == 1 || $reg[$i]['estadoimei'] == 2 || $reg[$i]['estadoimei'] == 4) { ?>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalImei" title="Editar" onClick="UpdateImei('<?php echo encrypt($reg[$i]["codimei"]); ?>','<?php echo $reg[$i]["numeroimei"]; ?>','<?php echo $reg[$i]["observaciones"]; ?>','<?php echo $reg[$i]["estadoimei"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarImei('<?php echo encrypt($reg[$i]["codimei"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("IMEI"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } else { ?>
    <span class='badge badge-success alert-link font-12'>VENDIDO</span>
    <?php } ?></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR IMEIS ############################
?>










<?php
############################# CARGAR CLIENTES X SUCURSAL ############################
if (isset($_GET['BuscaClientesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMasivaCliente('<?php echo $codsucursal; ?>')"><span class="fa fa-cloud-upload text-dark"></span> Cargar</button>
                    
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxCliente('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CLIENTES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Tipo de Cliente</th>
                    <th>Nº de Documento</th>
                    <th>Nombres</th>
                    <th>Nº de Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarClientes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CLIENTES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td class="text-dark alert-link"><?php echo $reg[$i]['tipocliente']; ?></td>
    <td><?php echo $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']); ?></td>
    <td><?php echo $reg[$i]['tlfcliente'] == '' ? "***********" : $reg[$i]['tlfcliente']; ?></td>
    <td><?php echo $reg[$i]['emailcliente'] == '' ? "***********" : $reg[$i]['emailcliente']; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalCliente" title="Editar" onClick="UpdateCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo $reg[$i]["tipocliente"]; ?>','<?php echo $documento = ($reg[$i]["documcliente"] == 0 ? "" : $reg[$i]["documcliente"]); ?>','<?php echo $reg[$i]["dnicliente"]; ?>','<?php echo $reg[$i]["nomcliente"]; ?>','<?php echo $reg[$i]["razoncliente"]; ?>','<?php echo $reg[$i]["girocliente"]; ?>','<?php echo $reg[$i]["tlfcliente"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direccliente"]; ?>','<?php echo $reg[$i]["emailcliente"]; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>'); CargaTipoCliente('<?php echo $reg[$i]["tipocliente"]; ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("CLIENTES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR CLIENTES X SUCURSAL ############################
?>

<?php
############################# CARGAR CLIENTES ############################
if (isset($_GET['CargaClientes']) && isset($_GET['bclientes'])) {

$criterio = limpiar($_GET['bclientes']);   
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Tipo de Cliente</th>
            <th>Nº de Documento</th>
            <th>Nombres</th>
            <th>Nº de Teléfono</th>
            <th>Correo Electrónico</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">
<?php 
if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaClientes();
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td class="text-dark alert-link"><?php echo $reg[$i]['tipocliente']; ?></td>
    <td><?php echo $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']); ?></td>
    <td><?php echo $reg[$i]['tlfcliente'] == '' ? "***********" : $reg[$i]['tlfcliente']; ?></td>
    <td><?php echo $reg[$i]['emailcliente'] == '' ? "***********" : $reg[$i]['emailcliente']; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalCliente" title="Editar" onClick="UpdateCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo $reg[$i]["tipocliente"]; ?>','<?php echo $documento = ($reg[$i]["documcliente"] == 0 ? "" : $reg[$i]["documcliente"]); ?>','<?php echo $reg[$i]["dnicliente"]; ?>','<?php echo $reg[$i]["nomcliente"]; ?>','<?php echo $reg[$i]["razoncliente"]; ?>','<?php echo $reg[$i]["girocliente"]; ?>','<?php echo $reg[$i]["tlfcliente"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direccliente"]; ?>','<?php echo $reg[$i]["emailcliente"]; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>'); CargaTipoCliente('<?php echo $reg[$i]["tipocliente"]; ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("CLIENTES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR CLIENTES ############################
?>















<?php
############################# CARGAR PROVEEDORES X SUCURSAL ############################
if (isset($_GET['BuscaProveedoresxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Proveedores</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMasivaProveedor('<?php echo $codsucursal; ?>')"><span class="fa fa-cloud-upload text-dark"></span> Cargar</button>
                    
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Proveedor" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxProveedor('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PROVEEDORES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PROVEEDORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PROVEEDORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>N°</th>
                    <th>Nº de Documento</th>
                    <th>Nombres de Proveedor</th>
                    <th>Correo Electrónico</th>
                    <th>Nº de Teléfono</th>
                    <th>Vendedor</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
    <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
    <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalProveedor" title="Editar" onClick="UpdateProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo $documento = ($reg[$i]["documproveedor"] == 0 ? "" : $reg[$i]["documproveedor"]); ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','<?php echo $reg[$i]["tlfvendedor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("PROVEEDORES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PROVEEDORES X SUCURSAL ############################
?>

<?php
############################# CARGAR PROVEEDORES ############################
if (isset($_GET['CargaProveedores'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Nº Documento</th>
            <th>Nombres de Proveedor</th>
            <th>Correo Electrónico</th>
            <th>Nº de Teléfono</th>
            <th>Vendedor</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
    <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
    <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalProveedor" title="Editar" onClick="UpdateProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo $documento = ($reg[$i]["documproveedor"] == 0 ? "" : $reg[$i]["documproveedor"]); ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','<?php echo $reg[$i]["tlfvendedor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("PROVEEDORES"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PROVEEDORES ############################
?>













<?php
############################# CARGAR PEDIDOS X SUCURSAL ############################
if (isset($_GET['BuscaPedidosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Pedidos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Proveedor</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPedidos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td class="text-danger alert-link"><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</span>"; ?></td>
    <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg" title="Ver" onClick="VerPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpedido=<?php echo encrypt($reg[$i]["codpedido"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
                </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PEDIDOS X SUCURSAL ############################
?>

<?php
############################# CARGAR PEDIDOS ############################
if (isset($_GET['CargaPedidos'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Proveedor</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarPedidos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS DE PRODUCTOS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td class="text-danger alert-link"><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</span>"; ?></td>
    <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target=".bs-example-modal-lg" title="Ver" onClick="VerPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION['acceso']=="secretaria" && $reg[$i]["procesada"] == 1){ ?>

    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModalProcesar" title="Procesar a Compra" onClick="ProcesaPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo $reg[$i]["cuitproveedor"].": ".$reg[$i]["nomproveedor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span>

    <span class="text-info" style="cursor: pointer;" title="Editar" onClick="UpdatePedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetallePedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>

    <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PEDIDOS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>

    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpedido=<?php echo encrypt($reg[$i]["codpedido"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PEDIDOS ############################
?>















<?php
############################# CARGAR PRODUCTOS X SUCURSAL ############################
if (isset($_GET['BuscaProductosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);  

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else {
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Productos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            
            <div class="col-md-12">
              <div class="btn-group m-b-20">
              
              <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMasivaProducto('<?php echo $codsucursal; ?>')"><span class="fa fa-cloud-upload"></span> Cargar</font></button>
              
              <div class="btn-group">
              <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
              <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Óptimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Medio</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKCERO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Cero</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FECHASOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Óptimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FECHASMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Medio</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FECHASMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Minimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CODIGOBARRAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-barcode text-dark"></span> Código Barras</a>

              </div>
            </div>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

              </div>
            </div>
        </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Foto</th>
            <th>Código</th>
            <th>Nombre de Producto</th>
            <th>Stock</th>
            <th>Fecha Venc.</th>
            <th>Fecha Elab.</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>P. Mayor</th>
            <th>P. Menor</th>
            <th>P. Público</th>
            <th><?php echo $NomImpuesto; ?> </th>
            <th>Dcto</th>
            <th>Nº de Barra</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php
$monedap = new Login();
$cambio = $monedap->MonedaProductoId();

$reg = $tra->ListarProductos(); 

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

$fecha_actual = date("Y-m-d");
$fecha_optima = $reg[$i]['fechaoptimo'];
$fecha_media = $reg[$i]['fechamedio'];
$fecha_minima = $reg[$i]['fechaminimo'];

if($fecha_optima != '0000-00-00' && $fecha_actual <= $fecha_optima){
$nombre_fecha = "OPTIMA";
$color_fecha  = "<span class='badge badge-success'>".$fecha_optima."</span>";
} else if($fecha_media != '0000-00-00' && $fecha_actual <= $fecha_media){
$nombre_fecha = "MEDIA";
$color_fecha  = "<span class='badge badge-warning'>".$fecha_media."</span>";
} else if($fecha_minima != '0000-00-00' && $fecha_actual >= $fecha_minima){
$nombre_fecha = "MINIMA";
$color_fecha  = "<span class='badge badge-danger'>".$fecha_minima."</span>";
} else if($fecha_optima == '0000-00-00' || $fecha_media == '0000-00-00' || $fecha_minima == '0000-00-00'){
$nombre_fecha = "";
$color_fecha  = "******";
} 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>  
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>

    <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-success'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-warning'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-danger'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } else { echo number_format($reg[$i]['existencia'], 2, '.', ','); } ?>
    </abbr></td>

    <td><abbr title="<?php echo $nombre_fecha; ?>"><?php echo $color_fecha; ?></abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>
                    
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
                    
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $codigobarra = ($reg[$i]['codigobarra'] == "" ? "*********" : $reg[$i]['codigobarra']); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <div class="btn-group">
        <span class="text-info" style="cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="border-radius:20px 20px 20px 20px;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>
        <div class="dropdown-menu dropdown-menu-left" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);border-radius:15px 15px 15px 15px;">
            <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="bottom" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','1')" title="Editar"><span class="fa fa-pencil text-dark"></span> Producto #1</a>
            <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="bottom" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','2')" title="Editar"><span class="fa fa-pencil text-dark"></span> Producto #2</a>
        </div>
    </div> 
    <!--<button type="button" class="btn btn-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','1')" title="Editar"><i class="fa fa-edit"></i></button>-->
    
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("PRODUCTOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>

    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PRODUCTOS X SUCURSAL ############################
?>

<?php
############################# CARGAR PRODUCTOS ############################
if (isset($_GET['CargaProductos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Producto</th>
        <th>Stock</th>
        <th>Fecha Venc.</th>
        <th>Fecha Elab.</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>P. Compra</th>
        <th>P. Mayor</th>
        <th>P. Menor</th>
        <th>P. Público</th>
        <th><?php echo $NomImpuesto; ?> </th>
        <th>Dcto</th>
        <th>Nº de Barra</th>
        <?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>
        <th>Acciones</th>
        <?php } else { ?>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor   = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor   = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo        = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2       = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

$fecha_actual = date("Y-m-d");
$fecha_optima = $reg[$i]['fechaoptimo'];
$fecha_media  = $reg[$i]['fechamedio'];
$fecha_minima = $reg[$i]['fechaminimo'];

if($fecha_optima != '0000-00-00' && $fecha_actual <= $fecha_optima){
$nombre_fecha = "OPTIMA";
$color_fecha  = "<span class='badge badge-success'>".$fecha_optima."</span>";
} else if($fecha_media != '0000-00-00' && $fecha_actual <= $fecha_media){
$nombre_fecha = "MEDIA";
$color_fecha  = "<span class='badge badge-warning'>".$fecha_media."</span>";
} else if($fecha_minima != '0000-00-00' && $fecha_actual >= $fecha_minima){
$nombre_fecha = "MINIMA";
$color_fecha  = "<span class='badge badge-danger'>".$fecha_minima."</span>";
} else if($fecha_optima == '0000-00-00' || $fecha_media == '0000-00-00' || $fecha_minima == '0000-00-00'){
$nombre_fecha = "";
$color_fecha  = "******";
} 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?> 
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-success'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-warning'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-danger'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } else { echo number_format($reg[$i]['existencia'], 2, '.', ','); } ?>
    </abbr></td>

    <td><abbr title="<?php echo $nombre_fecha; ?>"><?php echo $color_fecha; ?></abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>

    <td><?php echo ($_SESSION['acceso'] == "administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : $simbolo.number_format(0.00, 2, '.', ',')); ?></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>          
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>           
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $codigobarra = ($reg[$i]['codigobarra'] == "" ? "*********" : $reg[$i]['codigobarra']); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

    <div class="btn-group">
        <span class="text-info" style="cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="border-radius:20px 20px 20px 20px;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>
        <div class="dropdown-menu dropdown-menu-left" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);border-radius:15px 15px 15px 15px;">
            <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="bottom" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','1')" title="Editar"><span class="fa fa-pencil text-dark"></span> Producto #1</a>
            <a class="dropdown-item" href="#" data-toggle="tooltip" data-placement="bottom" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','2')" title="Editar"><span class="fa fa-pencil text-dark"></span> Producto #2</a>
        </div>
    </div> 

    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModalAjuste" title="Ajuste de Stock" onClick="AjusteProducto('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["idproducto"]); ?>','<?php echo $reg[$i]["codproducto"]; ?>','<?php echo $reg[$i]["producto"]; ?>','<?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]["nommarca"]; ?>','<?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?>','<?php echo $reg[$i]["existencia"]; ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("PRODUCTOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>

    <?php } ?>

    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR PRODUCTOS ############################
?>

<?php
############################# CARGAR PRODUCTOS X SUCURSALES ASOCIADAS ############################
if (isset($_GET['BuscaProductosxSucursalesAsociadas'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);  

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else {

$monedap = new Login();
$cambio = $monedap->MonedaProductoId();

$reg = $tra->ListarProductosxSucursales(); 

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Productos</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-12">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOSXSUCURSAL") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>
             
            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXSUCURSAL") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXSUCURSAL") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Producto</th>
        <th>Stock</th>
        <th>Fecha Venc.</th>
        <th>Fecha Elab.</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>P. Mayor</th>
        <th>P. Menor</th>
        <th>P. Público</th>
        <th><?php echo $NomImpuesto; ?> </th>
        <th>Dcto</th>
        <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>
        <th>Acciones</th>
        <?php } else { ?>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

$fecha_actual = date("Y-m-d");
$fecha_optima = $reg[$i]['fechaoptimo'];
$fecha_media = $reg[$i]['fechamedio'];
$fecha_minima = $reg[$i]['fechaminimo'];

if($fecha_optima != '0000-00-00' && $fecha_actual <= $fecha_optima){
$nombre_fecha = "OPTIMA";
$color_fecha  = "<span class='badge badge-success'>".$fecha_optima."</span>";
} else if($fecha_media != '0000-00-00' && $fecha_actual <= $fecha_media){
$nombre_fecha = "MEDIA";
$color_fecha  = "<span class='badge badge-warning'>".$fecha_media."</span>";
} else if($fecha_minima != '0000-00-00' && $fecha_actual >= $fecha_minima){
$nombre_fecha = "MINIMA";
$color_fecha  = "<span class='badge badge-danger'>".$fecha_minima."</span>";
} else if($fecha_optima == '0000-00-00' || $fecha_media == '0000-00-00' || $fecha_minima == '0000-00-00'){
$nombre_fecha = "";
$color_fecha  = "******";
} 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>

    <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-success'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-warning'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-danger'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } else { echo number_format($reg[$i]['existencia'], 2, '.', ','); } ?>
    </abbr></td>

    <td><abbr title="<?php echo $nombre_fecha; ?>"><?php echo $color_fecha; ?></abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>
                    
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
                    
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PRODUCTOS X SUCURSALES ASOCIADAS ############################
?>

<?php
############################# CARGAR DE PRODUCTOS POR TIPO BUSQUEDA ############################
if (isset($_GET['BuscaProductosxTipoBusqueda']) && isset($_GET['codsucursal']) && isset($_GET['tipobusqueda'])) {

$codsucursal     = limpiar($_GET['codsucursal']);
$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$codfamilia      = limpiar($tipobusqueda == 1 || $tipobusqueda == 7 ? $_GET['codfamilia'] : "");
$codsubfamilia   = limpiar($tipobusqueda == 1 ? $_GET['codsubfamilia'] : "");
$codmarca        = limpiar($tipobusqueda == 2 || $tipobusqueda == 8 ? $_GET['codmarca'] : "");
$codmodelo       = limpiar($tipobusqueda == 2 ? $_GET['codmodelo'] : "");
$codpresentacion = limpiar($tipobusqueda == 3 ? $_GET['codpresentacion'] : "");
$codcolor        = limpiar($tipobusqueda == 4 ? $_GET['codcolor'] : "");
$codorigen       = limpiar($tipobusqueda == 5 ? $_GET['codorigen'] : "");
$codproveedor    = limpiar($tipobusqueda == 6 || $tipobusqueda == 7 || $tipobusqueda == 8 ? $_GET['codproveedor'] : "");

if($tipobusqueda == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else if($tipobusqueda == 1 && $codfamilia == "" || $tipobusqueda == 7 && $codfamilia == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FAMILIA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;    

/*} else if($tipobusqueda == 1 && $codsubfamilia == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUBFAMILIA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;*/    

} else if($tipobusqueda == 2 && $codmarca == "" || $tipobusqueda == 8 && $codmarca == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE MARCA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit; 

/*} else if($tipobusqueda == 2 && $codmodelo == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE MODELO PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;*/   

} else if($tipobusqueda == 3 && $codpresentacion == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PRESENTACIÓN PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else if($tipobusqueda == 4 && $codcolor == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE COLOR PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else if($tipobusqueda == 5 && $codorigen == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE ORIGEN PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;       

} else if($tipobusqueda == 6 && $codproveedor == "" || $tipobusqueda == 7 && $codproveedor == "" || $tipobusqueda == 8 && $codproveedor == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;  

} else {

$reg = $tra->BusquedaProductos();
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">

            <?php if($tipobusqueda == 1){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Familia <?php echo $reg[0]['nomfamilia']; ?> <?php echo $subfamilia = (empty($_GET['codsubfamilia']) ? "" : "y Subfamilia ".$reg[0]['nomsubfamilia']); ?></h4>

            <?php } elseif($tipobusqueda == 2){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Marcas <?php echo $reg[0]['nommarca']; ?> <?php echo $modelos = (empty($_GET['codmodelo']) ? "" : "y Modelos ".$reg[0]['nommodelo']); ?></h4>

            <?php } elseif($tipobusqueda == 3){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Presentación <?php echo $reg[0]['nompresentacion']; ?></h4>

            <?php } elseif($tipobusqueda == 4){ ?>
            
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Color <?php echo $reg[0]['nomcolor']; ?></h4>

            <?php } elseif($tipobusqueda == 5){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Origen <?php echo $reg[0]['nomorigen']; ?></h4>

            <?php } elseif($tipobusqueda == 6){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Proveedor <?php echo $reg[0]['nomproveedor']; ?></h4>

            <?php } elseif($tipobusqueda == 7){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Familia <?php echo $reg[0]['nomfamilia']; ?> y Proveedor <?php echo $reg[0]['nomproveedor']; ?></h4>

            <?php } elseif($tipobusqueda == 8){ ?>

            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos de Marca <?php echo $reg[0]['nommarca']; ?> y Proveedor <?php echo $reg[0]['nomproveedor']; ?></h4>

            <?php } ?>

        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">

            <?php if($tipobusqueda == 1){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codfamilia=<?php echo $codfamilia; ?>&codsubfamilia=<?php echo $codsubfamilia; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codfamilia=<?php echo $codfamilia; ?>&codsubfamilia=<?php echo $codsubfamilia; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codfamilia=<?php echo $codfamilia; ?>&codsubfamilia=<?php echo $codsubfamilia; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 2){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codmarca=<?php echo $codmarca; ?>&codmodelo=<?php echo $codmodelo; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codmarca=<?php echo $codmarca; ?>&codmodelo=<?php echo $codmodelo; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codmarca=<?php echo $codmarca; ?>&codmodelo=<?php echo $codmodelo; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 3){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codpresentacion=<?php echo $codpresentacion; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codpresentacion=<?php echo $codpresentacion; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codpresentacion=<?php echo $codpresentacion; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 4){ ?>
            
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codcolor=<?php echo $codcolor; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codcolor=<?php echo $codcolor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codcolor=<?php echo $codcolor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 5){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codorigen=<?php echo $codorigen; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codorigen=<?php echo $codorigen; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codorigen=<?php echo $codorigen; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 6){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 7){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codfamilia=<?php echo $codfamilia; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codfamilia=<?php echo $codfamilia; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codfamilia=<?php echo $codfamilia; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } elseif($tipobusqueda == 8){ ?>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codmarca=<?php echo $codmarca; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codmarca=<?php echo $codmarca; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&codmarca=<?php echo $codmarca; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

            <?php } ?>

            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Foto</th>
            <th>Código</th>
            <th>Nombre de Producto</th>
            <th>Stock</th>
            <th>Fecha Venc.</th>
            <th>Fecha Elab.</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>P. Mayor</th>
            <th>P. Menor</th>
            <th>P. Público</th>
            <th><?php echo $NomImpuesto; ?> </th>
            <th>Dcto</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo        = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$fecha_actual = date("Y-m-d");
$fecha_optima = $reg[$i]['fechaoptimo'];
$fecha_media  = $reg[$i]['fechamedio'];
$fecha_minima = $reg[$i]['fechaminimo'];

if($fecha_optima != '0000-00-00' && $fecha_actual <= $fecha_optima){
$nombre_fecha = "OPTIMA";
$color_fecha  = "<span class='badge badge-success'>".$fecha_optima."</span>";
} else if($fecha_media != '0000-00-00' && $fecha_actual <= $fecha_media){
$nombre_fecha = "MEDIA";
$color_fecha  = "<span class='badge badge-warning'>".$fecha_media."</span>";
} else if($fecha_minima != '0000-00-00' && $fecha_actual >= $fecha_minima){
$nombre_fecha = "MINIMA";
$color_fecha  = "<span class='badge badge-danger'>".$fecha_minima."</span>";
} else if($fecha_optima == '0000-00-00' || $fecha_media == '0000-00-00' || $fecha_minima == '0000-00-00'){
$nombre_fecha = "";
$color_fecha  = "******";
} 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?> 
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-success'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-warning'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-danger'>".number_format($reg[$i]['existencia'], 2, '.', ',')."</span>"; } else { echo number_format($reg[$i]['existencia'], 2, '.', ','); } ?>
    </abbr></td>

    <td><abbr title="<?php echo $nombre_fecha; ?>"><?php echo $color_fecha; ?></abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>

    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
                    
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>

    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
                    
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
} 
############################# CARGAR DE PRODUCTOS POR TIPO BUSQUEDA ############################
?>








<?php
############################# CARGAR AJUSTES PRODUCTOS X SUCURSAL ############################
if (isset($_GET['BuscaAjusteProductosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else {

$reg = $tra->ListarAjustesProductos(); 
?>

<!-- Row -->
 <div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ajuste de Stock de Productos</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-12">
            <div class="btn-group m-b-20">
                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("AJUSTEPRODUCTOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("AJUSTEPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("AJUSTEPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Código</th>
        <th>Nombre de Producto</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Presentación</th>
        <th>Precio Compra</th>
        <th>Precio V. Mayor</th>
        <th>Precio V. Menor</th>
        <th>Precio V. Público</th>
        <th>Existencia</th>
        <th>Cantidad</th>
        <th>Stock</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">
<?php 
if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON AJUSTES DE PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";   

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td> 
    <td><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? "<i class='fa fa-plus text-info'></i>" : "<i class='fa fa-minus text-success'></i>")." ".number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? number_format($reg[$i]['existencia']+$reg[$i]['cantidad'], 2, '.', ',') : number_format($reg[$i]['existencia']-$reg[$i]['cantidad'], 2, '.', ',')); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaajuste']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaajuste']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerAjusteProducto('<?php echo encrypt($reg[$i]["codajuste"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Comprobante" onClick="VentanaCentrada('reportepdf?numero=<?php echo encrypt($reg[$i]["codajuste"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR AJUSTES PRODUCTOS X SUCURSAL ############################
?>

<?php
############################# CARGAR AJUSTES DE PRODUCTOS ############################
if (isset($_GET['CargaAjusteProductos'])&& isset($_GET['tipobusqueda']) && isset($_GET['search_criterio']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$search_criterio = limpiar($_GET['search_criterio']);
$desde           = limpiar($_GET['desde']);
$hasta           = limpiar($_GET['hasta']); 

if($tipobusqueda == 2 && $search_criterio == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit; 

} elseif($tipobusqueda == 3 && $desde == "" || $tipobusqueda == 3 && $hasta == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE / HASTA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;   

} else {

$reg = $tra->BusquedaAjustesProductos();
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ajuste de Stock de Productos</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("AJUSTEPRODUCTOSXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("AJUSTEPRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("AJUSTEPRODUCTOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Código</th>
        <th>Nombre de Producto</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Presentación</th>
        <th>Precio Compra</th>
        <th>Precio V. Mayor</th>
        <th>Precio V. Menor</th>
        <th>Precio V. Público</th>
        <th>Existencia</th>
        <th>Cantidad</th>
        <th>Stock</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">
<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "**********" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo ($_SESSION['acceso'] == "administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : $simbolo.number_format(0.00, 2, '.', ',')); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td> 
    <td><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? "<i class='fa fa-plus text-info'></i>" : "<i class='fa fa-minus text-success'></i>")." ".number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $tipo = ($reg[$i]['procedimiento'] == 1 ? number_format($reg[$i]['existencia']+$reg[$i]['cantidad'], 2, '.', ',') : number_format($reg[$i]['existencia']-$reg[$i]['cantidad'], 2, '.', ',')); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaajuste']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaajuste']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerAjusteProducto('<?php echo encrypt($reg[$i]["codajuste"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Comprobante" onClick="VentanaCentrada('reportepdf?numero=<?php echo encrypt($reg[$i]["codajuste"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
} 
############################# CARGAR AJUSTES DE PRODUCTOS ############################
?>








<?php
############################# CARGAR KARDEX VALORIZADO PRODUCTOS X SUCURSAL ############################
if (isset($_GET['BuscaKardexProductosValorizadoxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Kardex Valorizado</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">

            <div class="col-md-12">
              <div class="btn-group m-b-20">
                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Foto</th>
                <th>Código</th>
                <th>Nombre de Producto</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio Compra</th>
                <th>Precio Público</th>
                <th>Stock</th>
                <th><?php echo $NomImpuesto; ?></th>
                <th>Desc %</th>
                <th>Total Venta</th>
                <th>Total Compra</th>
                <th>Ganancias</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarKardexProductosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

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
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>  
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumCompra, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SumVenta-$SumCompra, 2, '.', ','); ?></span></td>
        </tr>
        <?php } } ?>
        <tfoot>
        <tr>
          <th colspan="11"></th>
          <th><?php echo $simbolo; ?><span id="total_1"></span></th>
          <th><?php echo $simbolo; ?><span id="total_2"></span></th>
          <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        </tr>
        </tfoot>
        </tbody>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR KARDEX VALORIZADO PRODUCTOS X SUCURSAL ############################
?>

<?php
############################# CARGAR KARDEX PRODUCTOS VALORIZADO ############################
if (isset($_GET['CargaKardexProductosValorizado'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Producto</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Precio Compra</th>
        <th>Precio Público</th>
        <th>Existencia</th>
        <th><?php echo $NomImpuesto; ?></th>
        <th>Desc %</th>
        <th>Total Venta</th>
        <th>Total Compra</th>
        <th>Ganancias</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarKardexProductosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

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
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>  
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo ($_SESSION['acceso'] == "administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : $simbolo.number_format(0.00, 2, '.', ',')); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumCompra, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SumVenta-$SumCompra, 2, '.', ','); ?></span></td>
        </tr>
        <?php } } ?>
        <tfoot>
        <tr>
          <th colspan="11"></th>
          <th><?php echo $simbolo; ?><span id="total_1"></span></th>
          <th><?php echo $simbolo; ?><span id="total_2"></span></th>
          <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        </tr>
        </tfoot>
        </tbody>
        </table></div>
<?php
} 
############################# CARGAR KARDEX PRODUCTOS VALORIZADO ############################
?>












<?php
############################# CARGAR COMBOS X SUCURSAL ############################
if (isset($_GET['BuscaCombosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Productos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">

            <div class="col-md-12">
              <div class="btn-group m-b-20">
              <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                  <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                                
                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMBOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMBOSMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMBOSMAXIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Máximo</a>

                  </div>
              </div> 

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Foto</th>
                <th>Código</th>
                <th>Nombre de Combo</th>
                <th>P. Compra</th>
                <th>P. Mayor</th>
                <th>P. Menor</th>
                <th>P. Público</th>
                <th>Stock</th>
                <th><?php echo $NomImpuesto; ?></th>
                <th>Dcto</th>
                <th>Detalles de Productos</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$monedap = new Login();
$cambio = $monedap->MonedaProductoId();

$reg = $tra->ListarCombos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor   = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor   = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo        = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
$simbolo2       = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']); 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?> 
    </td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td style="font-size:10px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-info" style="cursor: pointer;" title="Editar" onClick="UpdateCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-primary" style="cursor: pointer;" title="Agregar Producto" onClick="AgregaProducto('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("COMBOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>

    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COMBOS X SUCURSAL ############################
?>

<?php
############################# CARGAR COMBOS ############################
if (isset($_GET['CargaCombos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Combo</th>
        <th>P. Compra</th>
        <th>P. Mayor</th>
        <th>P. Menor</th>
        <th>P. Público</th>
        <th>Stock</th>
        <th><?php echo $NomImpuesto; ?></th>
        <th>Dcto</th>
        <th>Detalles de Productos</th>
        <?php echo $perfil = ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><i class='mdi mdi-drag-horizontal'></i></th>"); ?> 
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCombos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor   = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor   = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo        = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
$simbolo2       = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']); 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>
    </td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <td><?php echo ($_SESSION['acceso'] == "administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : $simbolo.number_format(0.00, 2, '.', ',')); ?></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>
    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td style="font-size:10px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") {?>
    <span class="text-info" style="cursor: pointer;" title="Editar" onClick="UpdateCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-primary" style="cursor: pointer;" title="Agregar Producto" onClick="AgregaProducto('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("COMBOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>
    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR COMBOS ############################
?>














<?php
############################# CARGAR KARDEX VALORIZADO COMBOS X SUCURSAL ############################
if (isset($_GET['BuscaKardexCombosValorizadoxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Kardex Valorizado</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
              <div class="btn-group m-b-20">
                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
        </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Foto</th>
                <th>Código</th>
                <th>Nombre de Combo</th>
                <th>Precio Compra</th>
                <th>Precio Público</th>
                <th>Stock</th>
                <th><?php echo $NomImpuesto; ?></th>
                <th>Desc %</th>
                <th>Total Venta</th>
                <th>Total Compra</th>
                <th>Ganancias</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarKardexCombosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

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
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>  
    </td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></abbr></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumCompra, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SumVenta-$SumCompra, 2, '.', ','); ?></span></td>
    </tr>
    <?php } } ?>
    <tfoot>
    <tr>
      <th colspan="9"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
    </tr>
    </tfoot>
    </tbody>
    </table>
    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR KARDEX VALORIZADO COMBOS X SUCURSAL ############################
?>

<?php
############################# CARGAR KARDEX DE COMBOS VALORIZADO ############################
if (isset($_GET['CargaKardexCombosValorizado'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
     <thead>
     <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Combo</th>
        <th>Precio Compra</th>
        <th>Precio Público</th>
        <th>Stock</th>
        <th><?php echo $NomImpuesto; ?></th>
        <th>Desc %</th>
        <th>Total Venta</th>
        <th>Total Compra</th>
        <th>Ganancias</th>
     </tr>
     </thead>
     <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarKardexCombosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE </center>";
    echo "</div>";    

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
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="60" height="60" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else { ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>  
    <?php } ?>
    </td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <td><?php echo ($_SESSION['acceso'] == "administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : $simbolo.number_format(0.00, 2, '.', ',')); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumCompra, 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SumVenta-$SumCompra, 2, '.', ','); ?></span></td>
    </tr>
    <?php } } ?>
    <tfoot>
    <tr>
      <th colspan="9"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
    </tr>
    </tfoot>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR KARDEX DE COMBOS VALORIZADO ############################
?>















<?php
############################# CARGAR TRASPASOS X SUCURSAL ############################
if (isset($_GET['BuscaTrapasosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Traspasos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("TRASPASOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>N° de Tracking</th>
                <th>Sucursal Remitente</th>
                <th>Sucursal Destinatario</th>
                <th>Nº Artículos</th>
                <th>Observaciones</th>
                <th>Fecha Emisión</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTraspasos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS DE PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$tipo_documento = ($reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_8' || $reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_5' ? "TICKET" : "FACTURA"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo $reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>:<br> ".$reg[$i]['nomencargado']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>:<br> ".$reg[$i]['nomencargado2']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechatraspaso']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechatraspaso']))."</span>"; ?></td>
    
    <td><?php if($reg[$i]['estado_traspaso'] == 1){
    echo "<span class='badge badge-info'><i class='fa fa-info'></i> REGISTRADO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 2){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> EN PROCESO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 3){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> PENDIENTE</span>";
    } elseif($reg[$i]['estado_traspaso'] == 4){
    echo "<span class='badge badge-success'><i class='fa fa-check'></i> RECIBIDO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 5){
    echo "<span class='badge badge-danger'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
    } ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codtraspaso=<?php echo encrypt($reg[$i]["codtraspaso"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['sucursal_envia']); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR TRASPASOS X SUCURSAL ############################
?>

<?php
############################# CARGAR TRASPASOS ############################
if (isset($_GET['CargaTraspasos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>N° de Factura</th>
            <th>N° de Tracking</th>
            <th>Sucursal Remitente</th>
            <th>Sucursal Destinatario</th>
            <th>Nº Artículos</th>
            <th>Observaciones</th>
            <th>Fecha Emisión</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTraspasos();

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS DE PRODUCTOS ACTUALMENTE </center>";
  echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$tipo_documento = ($reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_8' || $reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_5' ? "TICKET" : "FACTURA");
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo $reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>:<br> ".$reg[$i]['nomencargado']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>:<br> ".$reg[$i]['nomencargado2']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechatraspaso']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechatraspaso']))."</span>"; ?></td>
    
    <td><?php if($reg[$i]['estado_traspaso'] == 1){
    echo "<span class='badge badge-info'><i class='fa fa-info'></i> REGISTRADO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 2){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> EN PROCESO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 3){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> PENDIENTE</span>";
    } elseif($reg[$i]['estado_traspaso'] == 4){
    echo "<span class='badge badge-success'><i class='fa fa-check'></i> RECIBIDO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 5){
    echo "<span class='badge badge-danger'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
    } ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]['sucursal_envia'] == $_SESSION['codsucursal'] || $_SESSION['acceso']=="secretaria" && $reg[$i]['sucursal_envia'] == $_SESSION['codsucursal']){ ?>

    <?php if($reg[$i]['estado_traspaso'] != 4){ ?>

    <span class="text-info" style="cursor: pointer;" title="Editar Traspaso" onClick="UpdateTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo encrypt("U"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetalleTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo encrypt("A"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo encrypt("TRASPASOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>

    <?php } ?> 

    <?php } ?>

    <?php if($reg[$i]['sucursal_recibe'] == $_SESSION['codsucursal'] && $reg[$i]['estado_traspaso'] == 3){ ?>
    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModalProcesar" title="Procesar Traspaso" onClick="ProcesarTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo $reg[$i]["codfactura"]; ?>','<?php echo $reg[$i]['nomsucursal']; ?>','<?php echo $reg[$i]['nomencargado']; ?>','<?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span>
    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codtraspaso=<?php echo encrypt($reg[$i]["codtraspaso"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['sucursal_envia']); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TRASPASOS ############################
?>










<?php
############################# CARGAR COMPRAS X SUCURSAL ############################
if (isset($_GET['BuscaComprasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Compras</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMPRAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Proveedor</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCompras();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</span><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','1')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COMPRAS X SUCURSAL ############################
?>

<?php
############################# CARGAR COMPRAS ############################
if (isset($_GET['CargaCompras']) && isset($_GET['tipobusqueda']) && isset($_GET['search_criterio']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$search_criterio = limpiar($_GET['search_criterio']);
$desde           = limpiar($_GET['desde']);
$hasta           = limpiar($_GET['hasta']);

if($tipobusqueda == 2 && $search_criterio == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit; 

} elseif($tipobusqueda == 3 && $desde == "" || $tipobusqueda == 3 && $hasta == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE / HASTA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;   

} else {

$reg = $tra->BusquedaCompras();
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Compras</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMPRASXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Proveedor</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</span><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','1')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

    <span class="text-info" style="cursor: pointer;" title="Editar Compra" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo encrypt("1"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetalleCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>','<?php echo encrypt("1"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "P"; ?>','<?php echo encrypt("COMPRAS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
} 
############################# CARGAR COMPRAS ############################
?>











<?php
############################# CARGAR CUENTAS X PAGAR X SUCURSAL ############################
if (isset($_GET['BuscaCuentasxPagarxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Cuentas x Pagar</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
                       
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                    
                    <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("CUENTASXPAGARVENCIDAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Cuentas Vencidas</a>

                </div>
            </div> 
                
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Proveedor</th>
                <th>Total Factura</th>
                <th>Total Abonado</th>
                <th>Tota Pendiente</th>
                <th>Estado</th>
                <th>Fecha Emisión</th>
                <th>Fecha Venc.</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCuentasxPagar();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CUENTAS X PAGAR ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</span><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
    elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','2')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR CUENTAS X PAGAR X SUCURSAL ############################
?>

<?php
############################# CARGAR CUENTAS POR PAGAR ############################
if (isset($_GET['CargaCuentasxPagar']) && isset($_GET['tipobusqueda']) && isset($_GET['search_criterio']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$search_criterio = limpiar($_GET['search_criterio']);
$desde           = limpiar($_GET['desde']);
$hasta           = limpiar($_GET['hasta']);

if($tipobusqueda == 2 && $search_criterio == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit; 

} elseif($tipobusqueda == 3 && $desde == "" || $tipobusqueda == 3 && $hasta == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE / HASTA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;   

} else {

$reg = $tra->BusquedaCuentasxPagar(); 
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Cuentas por Pagar</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <?php if($tipobusqueda == 1){ ?>
            <div class="btn-group">
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                    
                    <a class="dropdown-item" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CUENTASXPAGARXBUSQUEDA"); ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("CUENTASXPAGARVENCIDAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Cuentas Vencidas</a>
                </div>
            </div>
            <?php } else { ?>
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CUENTASXPAGARXBUSQUEDA"); ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>
            <?php } ?>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CUENTASXPAGARXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CUENTASXPAGARXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>N° de Factura</th>
            <th>Descripción de Proveedor</th>
            <th>Total Factura</th>
            <th>Total Abonado</th>
            <th>Tota Pendiente</th>
            <th>Estado</th>
            <th>Fecha Emisión</th>
            <th>Fecha Venc.</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</span><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
    elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','2')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>


    <?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") { ?>

    <span class="text-info" style="cursor: pointer;" title="Editar Compra" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo encrypt("2"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetalleCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>','<?php echo encrypt("2"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>

    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#ModalAbonosCompra" title="Abonar" onClick="AbonoCreditoCompra(
    '<?php echo encrypt($reg[$i]["codcompra"]); ?>',
    '<?php echo $reg[$i]["codfactura"]; ?>',
    '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
    '<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
    '<?php echo $reg[$i]["nomproveedor"]; ?>',
    '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"], 2, '.', ''); ?>',
    '<?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?>',
    '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("D") ?>','<?php echo encrypt("COMPRAS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>

    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
} 
############################# CARGAR CUENTAS POR PAGAR ############################
?>













<?php
############################# CARGAR COTIZACIONES X SUCURSAL ############################
if (isset($_GET['BuscaCotizacionesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Cotizaciones</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COTIZACIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Cliente</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Estado</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCotizaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COTIZACION" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcotizacion=<?php echo encrypt($reg[$i]["codcotizacion"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COTIZACIONES X SUCURSAL ############################
?>

<?php
############################# CARGAR COTIZACIONES ############################
if (isset($_GET['CargaCotizaciones']) && isset($_GET['tipobusqueda']) && isset($_GET['search_criterio']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$search_criterio = limpiar($_GET['search_criterio']);
$desde           = limpiar($_GET['desde']);
$hasta           = limpiar($_GET['hasta']);

if($tipobusqueda == 2 && $search_criterio == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit; 

} elseif($tipobusqueda == 3 && $desde == "" || $tipobusqueda == 3 && $hasta == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE / HASTA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;   

} else {

$reg = $tra->BusquedaCotizaciones();
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Cotizaciones</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXBUSQUEDA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>N° de Factura</th>
            <th>Descripción de Cliente</th>
            <th>Nº Artic</th>
            <th>Descontado</th>
            <th>Subtotal</th>
            <th>Total <?php echo $NomImpuesto; ?></th>
            <th>Imp. Total</th>
            <th>Estado</th>
            <th>Fecha Emisión</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COTIZACION" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td> 
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso'] == "administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION['acceso'] == "secretaria" && $reg[$i]["procesada"] == 1 || $_SESSION["acceso"] == "cajero" && $reg[$i]["procesada"] == 1){ ?>

    <span class="text-info" style="cursor: pointer;" title="Editar Compra" onClick="UpdateCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetalleCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>

    <?php if($_SESSION['acceso'] == "administradorS" && $reg[$i]["procesada"] == 1 || $reg[0]["codigo"] == $_SESSION['codigo'] && $reg[$i]["procesada"] == 1){ ?>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("COTIZACIONES") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>

    <?php } ?>

    <?php if($_SESSION['acceso'] == "administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION["acceso"] == "cajero" && $reg[$i]["procesada"] == 1){ ?>
    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Procesar Cotizacion" 
    onClick="ProcesaCotizacion(
    '<?php echo encrypt($reg[$i]["codcotizacion"]); ?>',
    '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo $reg[$i]["codcliente"]; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "0" : $reg[$i]['dnicliente']; ?>',
    '<?php echo $reg[$i]['exonerado']; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>',
    '<?php echo number_format($reg[$i]['codcliente'] == '0' ? "0.00" : $reg[$i]["limitecredito"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotal"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotalexento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotaliva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["iva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totaliva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["descontado"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["descuento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totaldescuento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totalpago2"], 2, '.', ''); ?>')" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span>
    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcotizacion=<?php echo encrypt($reg[$i]["codcotizacion"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR COTIZACIONES ############################
?>











<?php
############################# CARGAR PREVENTAS X SUCURSAL ############################
if (isset($_GET['BuscaPreventasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Preventas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                    
                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CLIENTESXPREVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Clientes x Preventas</a>
                </div>
            </div>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Descripción de Cliente</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Estado</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPreventas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_PREVENTA" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td> 
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpreventa=<?php echo encrypt($reg[$i]["codpreventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PREVENTAS X SUCURSAL ############################
?>

<?php
############################# CARGAR PREVENTAS ############################
if (isset($_GET['CargaPreventas'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>N° de Factura</th>
            <th>Descripción de Cliente</th>
            <th>Nº Artic</th>
            <th>Descontado</th>
            <th>Subtotal</th>
            <th>Total <?php echo $NomImpuesto; ?></th>
            <th>Imp. Total</th>
            <th>Estado</th>
            <th>Fecha Emisión</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPreventas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS A CLIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_PREVENTA" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td> 
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1){ ?>

    <span class="text-info" style="cursor: pointer;" title="Editar Preventa" onClick="UpdatePreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetallePreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>

    <?php if($_SESSION['acceso'] == "administradorS" && $reg[$i]["procesada"] == 1 || $reg[0]["codigo"] == $_SESSION['codigo'] && $reg[$i]["procesada"] == 1){ ?>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PREVENTAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>

    <?php } ?>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION["acceso"] == "cajero" && $reg[$i]["procesada"] == 1){ ?>
    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Procesar Preventas" 
    onClick="ProcesaPreventa(
    '<?php echo encrypt($reg[$i]["codpreventa"]); ?>',
    '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo $reg[$i]["codcliente"]; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "0" : $reg[$i]['dnicliente']; ?>',
    '<?php echo $reg[$i]['exonerado']; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>',
    '<?php echo number_format($reg[$i]['codcliente'] == '0' ? "0.00" : $reg[$i]["limitecredito"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotal"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotalexento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotaliva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["iva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totaliva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["descontado"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["descuento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totaldescuento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totalpago2"], 2, '.', ''); ?>')" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span>
    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpreventa=<?php echo encrypt($reg[$i]["codpreventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PREVENTAS ############################
?>












<?php
############################# CARGAR DE CAJAS X SUCURSAL ############################
if (isset($_GET['BuscaCajasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Cajas</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxCaja('<?php echo $codsucursal; ?>'); CargaUsuarios('<?php echo $codsucursal; ?>');"><i class="fa fa-plus"></i> Nuevo</button>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Nombre de Caja</th>
                <th>Nº Documento</th>
                <th>Responsable</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalCaja" title="Editar" onClick="UpdateCaja('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["codigo"]; ?>','update'); CargaUsuarios('<?php echo encrypt($reg[$i]["codsucursal"]); ?>'); SelectUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("CAJAS"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR DE CAJAS X SUCURSAL ############################
?>

<?php
############################# CARGAR CAJAS PARA VENTAS ############################
if (isset($_GET['CargaCajas'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
             <thead>
             <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Caja</th>
                <th>Nombre de Caja</th>
                <th>Nº Documento</th>
                <th>Responsable</th>
                <th>Nivel</th>
                <th>Acciones</th>
             </tr>
             </thead>
             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja']; ?></td>
    <td><?php echo $reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['nivel']; ?></td>
    <td>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalCaja" title="Editar" onClick="UpdateCaja('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["codigo"]; ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("CAJAS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>    
<?php 
} 
############################# CARGAR CAJAS PARA VENTAS ############################
?>








<?php
############################# CARGAR ARQUEOS DE CAJAS X SUCURSAL ############################
if (isset($_GET['BuscaArqueosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Arqueos de Cajas</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Caja</th>
                <th>Responsable</th>
                <th>Hora de Apertura</th>
                <th>Hora de Cierre</th>
                <th>Monto Inicial</th>
                <th>Ventas</th>
                <th>Ingresos</th>
                <th>Efectivo</th>
                <th>Diferencia</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarArqueoCaja();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS PARA VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº CAJA: ".$reg[$i]['nrocaja']."</span><br> ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº DOC: ".$reg[$i]['dni']."</span><br> ".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaapertura']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaapertura']))."</span>"; ?></td>
    <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d/m/Y",strtotime($reg[$i]['fechacierre']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacierre']))."</span>"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
    
    <?php if($reg[$i]["statusarqueo"]=='0'){ ?><span class="text-default" style="cursor: pointer;" title="Imprimir Ticket" onClick="VentanaCentrada('reportepdf?codarqueo=<?php echo encrypt($reg[$i]["codarqueo"]); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span><?php } ?>
    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR ARQUEOS DE CAJAS X SUCURSAL ############################
?>

<?php
########################## CARGAR ARQUEOS DE CAJAS PARA VENTAS ##########################
if (isset($_GET['CargaArqueos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Caja</th>
            <th>Responsable</th>
            <th>Hora de Apertura</th>
            <th>Hora de Cierre</th>
            <th>Monto Inicial</th>
            <th>Ventas</th>
            <th>Ingresos</th>
            <th>Efectivo</th>
            <th>Diferencia</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarArqueoCaja();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº CAJA: ".$reg[$i]['nrocaja']."</span><br> ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº DOC: ".$reg[$i]['dni']."</span><br> ".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaapertura']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaapertura']))."</span>"; ?></td>
    <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d/m/Y",strtotime($reg[$i]['fechacierre']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacierre']))."</span>"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModal" title="Ver" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($reg[$i]["statusarqueo"] == '1'){ ?>

    <span class="text-info" style="cursor: pointer;" title="Cerrar" onClick="CerrarArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo encrypt("save"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-aperture"><circle cx="12" cy="12" r="10"></circle><line x1="14.31" y1="8" x2="20.05" y2="17.94"></line><line x1="9.69" y1="8" x2="21.17" y2="8"></line><line x1="7.38" y1="12" x2="13.12" y2="2.06"></line><line x1="9.69" y1="16" x2="3.95" y2="6.06"></line><line x1="14.31" y1="16" x2="2.83" y2="16"></line><line x1="16.62" y1="12" x2="10.88" y2="21.94"></line></svg></span>

    <?php } else { ?>

    <?php if ($_SESSION['acceso'] == "administradorS") { ?>
    <span class="text-info" style="cursor: pointer;" title="Editar" onClick="ActualizarArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo encrypt("update"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>
    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Ticket" onClick="VentanaCentrada('reportepdf?codarqueo=<?php echo encrypt($reg[$i]["codarqueo"]); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
    <?php } ?>
    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
######################### CARGAR ARQUEOS DE CAJAS PARA VENTAS #########################
?>









<?php
############################# CARGAR MOVIMIENTOS DE CAJAS X SUCURSAL ############################
if (isset($_GET['BuscaMovimientosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Movimientos de Cajas</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MOVIMIENTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>Caja</th>
                <th>Responsable</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS PARA VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['nrocaja'].":</span><br>".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['dni'].":</span><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechamovimiento']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechamovimiento']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Ticket" onClick="VentanaCentrada('reportepdf?numero=<?php echo encrypt($reg[$i]["numero"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MOVIMIENTOS DE CAJAS X SUCURSAL ############################
?>

<?php
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
if (isset($_GET['CargaMovimientos'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>Caja</th>
            <th>Responsable</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['nrocaja'].":</span><br>".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['dni'].":</span><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechamovimiento']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechamovimiento']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if ($_SESSION["acceso"] == "administradorS" && $reg[$i]['statusarqueo'] == 1) { ?>
    <span class="text-info" style="cursor: pointer;" data-toggle="modal" data-target="#myModalMovimiento" title="Editar" onClick="UpdateMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo $reg[$i]["tipodocumento"]; ?>','<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo $reg[$i]["tipomovimiento"]; ?>','<?php echo $reg[$i]["descripcionmovimiento"]; ?>','<?php echo number_format($reg[$i]["montomovimiento"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>
                                 
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt("MOVIMIENTOS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>
     

    <span class="text-default" style="cursor: pointer;" title="Imprimir Ticket" onClick="VentanaCentrada('reportepdf?numero=<?php echo encrypt($reg[$i]["numero"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span>

        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
?>






<?php
############################# CARGAR FACTURAS PENDIENTES ############################
if (isset($_GET['CargaFacturasPendientes'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Nº Artic</th>
        <th>Imp. Total</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarFacturasPendientes();

if($reg==""){
    
    echo "";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
    <tr>
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-danger alert-link'> Nº ".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalleFactura" title="Ver" onClick="VerFacturaPendiente('<?php echo encrypt($reg[$i]["codpendiente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModalCobrarFactura" title="Cobrar Factura" 
    onClick="CobrarFactura(
    '<?php echo encrypt($reg[$i]["idpendiente"]); ?>',
    '<?php echo encrypt($reg[$i]["codpendiente"]); ?>',
    '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo $reg[$i]["codcliente"]; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "0" : $reg[$i]['dnicliente']; ?>',
    '<?php echo $reg[$i]['exonerado']; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>',
    '<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>',
    '<?php echo number_format($reg[$i]['codcliente'] == '0' ? "0.00" : $reg[$i]["limitecredito"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotal"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotalexento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["subtotaliva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["iva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totaliva"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["descontado"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["descuento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totaldescuento"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]["totalpago2"], 2, '.', ''); ?>')" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span>

    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarFacturaPendiente('<?php echo encrypt($reg[$i]["codpendiente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PENDIENTES") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>

        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR FACTURAS PENDIENTES ############################
?>







<?php
############################# CARGAR VENTAS X SUCURSAL ############################
if (isset($_GET['BuscaVentasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Ventas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("VENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Venta</th>
                <th>Vendedor</th>
                <th>Descripción de Cliente</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Estado</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarVentas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
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
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><abbr title="CAJA: <?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?>"><?php echo "<strong>".$tipo_documento."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></abbr></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº DOCUMENTO: ".$reg[$i]['dni']."</span><br> ".$reg[$i]['nombres']; ?></td> 
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td> 
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-success'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR VENTAS X SUCURSAL ############################
?>


<?php
############################# CARGAR VENTAS ############################
if (isset($_GET['CargaVentas']) && isset($_GET['tipobusqueda']) && isset($_GET['search_criterio']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$search_criterio = limpiar($_GET['search_criterio']);
$desde           = limpiar($_GET['desde']);
$hasta           = limpiar($_GET['hasta']);

if($tipobusqueda == 2 && $search_criterio == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit; 

} elseif($tipobusqueda == 3 && $desde == "" || $tipobusqueda == 3 && $hasta == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE / HASTA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;   

} else {

$reg = $tra->BusquedaVentas(); 
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Ventas</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <?php if($tipobusqueda == 1){ ?>
            <div class="btn-group">
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                    
                    <a class="dropdown-item" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXBUSQUEDA"); ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("VENTASDIARIAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Ventas del Dia</a>
                </div>
            </div>
            <?php } else { ?>
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXBUSQUEDA"); ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>
            <?php } ?>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>N° de Factura</th>
            <th>Vendedor</th>
            <th>Descripción de Cliente</th>
            <th>Descontado</th>
            <th>Subtotal</th>
            <th>Total <?php echo $NomImpuesto; ?></th>
            <th>Imp. Total</th>
            <th>Estado</th>
            <th>Fecha Emisión</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$a=1;
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
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td class="text-danger alert-link"><abbr title="CAJA: <?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?>"><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></abbr></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº DOCUMENTO: ".$reg[$i]['dni']."</span><br> ".$reg[$i]['nombres']; ?></td> 
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td> 
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
 
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-success'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($reg[$i]['notacredito'] != 1){ ?>

    <?php if($_SESSION['acceso'] == "administradorS" || $reg[$i]["codigo"] == $_SESSION['codigo']){ ?>

    <span class="text-info" style="cursor: pointer;" title="Editar Compra" onClick="UpdateVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></span>

    <!--<span class="text-warning" style="cursor: pointer;" title="Agregar Detalle" onClick="AgregaDetalleVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg></span>-->

    <?php if($reg[$i]['statusarqueo'] == 1){ ?><span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("VENTAS") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span><?php } ?>

    <?php } ?>

    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR VENTAS ############################
?>


<?php
############################# CARGAR VENTAS DIARIAS ############################
if (isset($_GET['CargaVentasDiarias'])) { 
?>
<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>Nº</th>
            <th>N° de Factura</th>
            <th>Caja</th>
            <th>Descripción de Cliente</th>
            <th>Nº Artic</th>
            <th>Descontado</th>
            <th>Subtotal</th>
            <th>Total <?php echo $NomImpuesto; ?></th>
            <th>Imp. Total</th>
            <th>Estado</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BuscarVentasDiarias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
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
?>
    <tr>
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo "<span class='text-dark alert-link'> Nº: ".$reg[$i]['nrocaja']."</span><br><span class='text-danger alert-link'>".$reg[$i]['nomcaja']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='badge badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; } ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerVentaDiaria('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR VENTAS DIARIAS ############################
?>













<?php
############################# CARGAR CREDITOS X SUCURSAL ############################
if (isset($_GET['BuscaCreditosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Créditos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CREDITOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Nombre de Cliente</th>
                <th>Total Factura</th>
                <th>Total Abonado</th>
                <th>Total Pendiente</th>
                <th>Estado</th>
                <th>Dias Venc</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CRÉDITOS DE VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
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
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-success'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_VENTA_8") : encrypt("TICKET_CREDITO_VENTA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR CREDITOS X SUCURSAL ############################
?>

<?php
############################# CARGAR CREDITOS ############################
if (isset($_GET['CargaCreditos']) && isset($_GET['tipobusqueda']) && isset($_GET['search_criterio']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$tipobusqueda    = limpiar($_GET['tipobusqueda']);
$search_criterio = limpiar($_GET['search_criterio']);
$desde           = limpiar($_GET['desde']);
$hasta           = limpiar($_GET['hasta']);

if($tipobusqueda == 2 && $search_criterio == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit; 

} elseif($tipobusqueda == 3 && $desde == "" || $tipobusqueda == 3 && $hasta == ""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE / HASTA PARA TU BÚSQUEDA </center>";
  echo "</div>";
  exit;   

} else {

$reg = $tra->BusquedaCreditos();
?>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
        <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Créditos en Ventas</h4>
        </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <?php if($tipobusqueda == 1){ ?>
            <div class="btn-group">
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                    
                    <a class="dropdown-item" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSXBUSQUEDA"); ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("CREDITOSVENCIDOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Créditos Vencidos</a>
                </div>
            </div>
            <?php } else { ?>
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSXBUSQUEDA"); ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>
            <?php } ?>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?tipobusqueda=<?php echo $tipobusqueda; ?>&search_criterio=<?php echo $search_criterio; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXBUSQUEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>N°</th>
        <th>N° de Factura</th>
        <th>Nombre de Cliente</th>
        <th>Total Factura</th>
        <th>Total Abonado</th>
        <th>Total Pendiente</th>
        <th>Estado</th>
        <th>Dias Venc</th>
        <th>Fecha Emisión</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">

<?php 
$a=1;
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
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-success'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="secretaria" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="cajero" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado']){ ?>        
    <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModalPago" title="Abonar" 
    onClick="AbonoCreditoVenta('<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo $reg[$i]["codcliente"]; ?>',
    '<?php echo encrypt($reg[$i]["codventa"]); ?>',
    '<?php echo $reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["dnicliente"]; ?>',
    '<?php echo $reg[$i]["nomcliente"]; ?>',
    '<?php echo $reg[$i]["codfactura"]; ?>',
    '<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
    '<?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
    '<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>
    <?php } ?>

    <span class="text-default" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_VENTA_8") : encrypt("TICKET_CREDITO_VENTA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
} 
############################# CARGAR CREDITOS ############################
?>













<?php
############################# CARGAR NOTAS DE CREDITO X SUCURSAL ############################
if (isset($_GET['BuscaNotasCreditoxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Notas de Crédito</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("NOTASCREDITO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Documento de Venta</th>
                <th>Descripción de Cliente</th>
                <th>Nº Artic</th>
                <th>Descontado</th>
                <th>Subtotal</th>
                <th>Total <?php echo $NomImpuesto; ?></th>
                <th>Imp. Total</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarNotasCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON NOTAS DE CRÉDITO ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['tipofacturaventa']."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['facturaventa']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', '.'); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerNota('<?php echo encrypt($reg[$i]["codnota"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codnota=<?php echo encrypt($reg[$i]["codnota"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
            </td>
            </tr>
            <?php } } ?>
            </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR NOTAS DE CREDITO X SUCURSAL ############################
?>

<?php
############################# CARGAR NOTAS DE CREDITO ############################
if (isset($_GET['CargaNotas'])) { 
?>

<div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
            <th>N°</th>
            <th>N° de Factura</th>
            <th>Documento de Venta</th>
            <th>Descripción de Cliente</th>
            <th>Nº Artic</th>
            <th>Descontado</th>
            <th>Subtotal</th>
            <th>Total <?php echo $NomImpuesto; ?></th>
            <th>Imp. Total</th>
            <th>Fecha Emisión</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarNotasCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON NOTAS DE CREDITOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['tipofacturaventa']."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['facturaventa']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', '.'); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td>
    <span class="text-success" style="cursor: pointer;" data-toggle="modal" data-target="#myModalDetalle" title="Ver" onClick="VerNota('<?php echo encrypt($reg[$i]["codnota"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codnota=<?php echo encrypt($reg[$i]["codnota"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR NOTAS DE CREDITO ############################
?>

<!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
<script src="assets/plugins/datatables/datatables.js"></script>
<script> 
$(document).ready(function() {       
    $('#html5-extension').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            /*"sInfo": "Mostrar Página _PAGE_ de _PAGES_",*/
            "sInfo": "Mostrar _START_ - _END_ de _TOTAL_ Registros",
            "sInfoEmpty": "Mostrar 0 para 0 de 0 Registros",
            "sInfoFiltered": "(Resultados de _MAX_ Registros)",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Búsqueda...",
           "sLengthMenu": "Mostrar :  _MENU_",
           "sZeroRecords": "NO SE ENCONTRARON REGISTROS ACTUALMENTE",
        },
        "order": [[ 0, "asc" ]],
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50, 100],
        "pageLength": 10,
        drawCallback: function () { 
            $('.dataTables_paginate > .pagination').addClass('pagination-style-13 pagination-bordered mb-5');
            CalcularTotalesDatatable();
        }
    });
    function Separador(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function CalcularTotalesDatatable(){
    
        /*########## BLOQUE #1 /*##########*/
        let TotalSuma1 = 0;
        $(".suma_1").each(function(){
           //TotalPrecioCompra += parseInt($(this).html()) || 0;
           TotalSuma1  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_1").text(Separador(TotalSuma1.toFixed(2)));
        /*########## BLOQUE #1 /*##########*/

        /*########## BLOQUE #2 /*##########*/
        let TotalSuma2  = 0;
        $(".suma_2").each(function(){
            TotalSuma2  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_2").text(Separador(TotalSuma2.toFixed(2)));
        /*########## BLOQUE #2 /*##########*/

        /*########## BLOQUE #3 /*##########*/
        let TotalSuma3  = 0;
        $(".suma_3").each(function(){
            TotalSuma3  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_3").text(Separador(TotalSuma3.toFixed(2)));
        /*########## BLOQUE #3 /*##########*/

        /*########## BLOQUE #4 /*##########*/
        let TotalSuma4  = 0;
        $(".suma_4").each(function(){
            TotalSuma4  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_4").text(Separador(TotalSuma4.toFixed(2)));
        /*########## BLOQUE #4 /*##########*/

        /*########## BLOQUE #5 /*##########*/
        let TotalSuma5  = 0;
        $(".suma_5").each(function(){
            TotalSuma5  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_5").text(Separador(TotalSuma5.toFixed(2)));
        /*########## BLOQUE #5 /*##########*/
    };
});
</script>
<!-- END PAGE LEVEL CUSTOM SCRIPTS -->