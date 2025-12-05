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
    
$new = new Login();
?>



<?php
########################## BUSQUEDA PEDIDOS POR PROVEEDORES ##########################
if (isset($_GET['BuscaPedidosxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPedidosxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Pedidos del Proveedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
      <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Proveedor</th>
        <th>Fecha Emisión</th>
        <th>Nº de Articulos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
      </thead>
      <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-danger alert-link"><?php echo $reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</span>"; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td>
  <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpedido=<?php echo encrypt($reg[$i]["codpedido"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
  </tr>
  <?php } ?>
    <tfoot>
    <tr>
      <th colspan="4"></th>
      <th><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
      <th><?php echo $simbolo; ?><span id="total_5"></span></th>
    </tr>
    </tfoot>
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
########################## BUSQUEDA PEDIDOS POR PROVEEDORES ##########################
?>

<?php
########################## BUSQUEDA PEDIDOS POR FECHAS ##########################
if (isset($_GET['BuscaPedidosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']); 
  $hasta = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

  } else {

$pre = new Login();
$reg = $pre->BuscarPedidosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Pedidos del Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PEDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
      <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Proveedor</th>
        <th>Fecha Emisión</th>
        <th>Nº de Articulos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
      </thead>
      <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-danger alert-link"><?php echo $reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapedido']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapedido']))."</span>"; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td>
  <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpedido=<?php echo encrypt($reg[$i]["codpedido"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
  </tr>
  <?php } ?>
    <tfoot>
    <tr>
      <th colspan="4"></th>
      <th><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
      <th><?php echo $simbolo; ?><span id="total_5"></span></th>
    </tr>
    </tfoot>
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
########################## BUSQUEDA PEDIDOS POR FECHAS ##########################
?>










<?php 
########################### BUSQUEDA DE SERVICIOS POR MONEDA ##########################
if (isset($_GET['BuscaServiciosxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");
  
$reg = $new->ListarServicios();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Servicios al Cambio de Moneda</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("SERVICIOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
            
            <label class="control-label">Moneda de Cambio: </label> <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?><br>

            <label class="control-label">Monto de Cambio: </label> <?php echo number_format($cambio[0]['montocambio'], 2, '.', ','); ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>N°</th>
            <th>Descripción de Servicio</th>
            <th>Impuesto</th>
            <th>Desc %</th>
            <th>Estado</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Precio Compra <?php echo $cambio[0]['siglas']; ?></th>
            <th>Precio Venta <?php echo $cambio[0]['siglas']; ?></th>
          </tr>
        </thead>
        <tbody>
<?php 
if($reg==""){ 

} else {
 
$a=1;
$TotalCompra       = 0;
$TotalVenta        = 0;
$TotalMonedaCompra = 0;
$TotalMonedaVenta  = 0; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo  = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong> "); 
$simbolo2 = ($cambio[0]['simbolo'] == "" ? "" : "<strong>".$cambio[0]['simbolo']."</strong> ");

$TotalCompra       += number_format($reg[$i]['preciocompra'], 2, '.', ',');
$TotalVenta        += number_format($reg[$i]['precioventa'], 2, '.', '');

$TotalMonedaCompra += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
$TotalMonedaVenta  += number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', '');
?>
    <tr id="servicios_moneda">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['servicio']; ?></td>
      <td><?php echo $reg[$i]['ivaservicio'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
      <td><?php echo number_format($reg[$i]['descservicio'], 2, '.', ','); ?></td>
      <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-success alert-link'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
      <td><?php echo $simbolo; ?><span class="suma_1"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($reg[$i]['preciocompra'], 2, '.', ',') : "0.00"); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
      <td><?php echo $tipo_simbolo; ?><span class="suma_3"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',') : "0.00"); ?></span></td>
      <td><?php echo $tipo_simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
    <tfoot>
          <tr>
            <th colspan="5"></th>
            <th><?php echo $simbolo; ?><span id="total_1"></span></th>
            <th><?php echo $simbolo; ?><span id="total_2"></span></th>
            <th><?php echo $tipo_simbolo; ?><span id="total_3"></span></th>
            <th><?php echo $tipo_simbolo; ?><span id="total_4"></span></th>
          </tr>
        </tfoot>
    <?php } ?>
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
########################### BUSQUEDA DE SERVICIOS POR MONEDA ##########################
?>

<?php 
######################## BUSQUEDA DE KARDEX POR SERVICIO ########################
if (isset($_GET['BuscaKardexServicio']) && isset($_GET['codsucursal']) && isset($_GET['codservicio'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codservicio = limpiar($_GET['codservicio']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codservicio=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL SERVICIO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
} else {

$detalle = new Login();
$detalle = $detalle->DetalleKardexServicio();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexServicio();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Servicio <?php echo $detalle[0]['servicio']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-7">
                <div class="btn-group m-b-20">
                  <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codservicio=<?php echo $codservicio; ?>&tipo=<?php echo encrypt("KARDEXSERVICIOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                  <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codservicio=<?php echo $codservicio; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXSERVICIOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                  <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codservicio=<?php echo $codservicio; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXSERVICIOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Realizado por</th>
                <th>Movimiento</th>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Devolución</th>
                <th>Impuesto</th>
                <th>Desc %</th>
                <th>Precio Costo</th>
                <th>Costo Movimiento</th>
                <th>Documento</th>
                <th>Fecha de Kardex</th>
              </tr>
            </thead>
            <tbody>
<?php
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
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
      <td><?php echo $kardex[$i]['movimiento']; ?></td>
      <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
      <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
      <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
      <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
      <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
      <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
      <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
      <?php } else { ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
      <?php } ?>
      <td><?php echo $kardex[$i]['documento']; ?></td>
      <td><?php echo date("d/m/Y",strtotime($kardex[$i]['fechakardex']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($kardex[$i]['fechakardex']))."</span>"; ?></td>
    </tr>
    <?php } ?>
    </tbody>
    </table>            
    <strong>Detalles de Servicio</strong><br>
    <strong>Código:</strong> <?php echo $detalle[0]['codservicio']; ?><br>
    <strong>Descripción:</strong> <?php echo $detalle[0]['servicio']; ?><br>
    <strong>Total Entradas:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
    <strong>Total Salidas:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
    <strong>Total Devolución:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
    <strong>Precio Compra:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********"); ?><br>
    <strong>Precio Venta:</strong> <?php echo $simbolo.$detalle[0]['precioventa']; ?>
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
######################## BUSQUEDA DE KARDEX POR SERVICIO ########################
?>

<?php 
########################### BUSQUEDA KARDEX SERVICIOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
if (isset($_GET['BuscaServiciosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
//$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarServiciosValorizadoxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Servicios Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("SERVICIOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

        <div class="row">
            <div class="col-md-12">
                <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
          
                <!--<label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>-->

                <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

                <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
            </div>
       </div>

       <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Código</th>
                <th>Descripción de Servicio</th>
                <th>Impuesto</th>
                <th>Desc %</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Vendido</th>
                <th>Total Venta</th>
                <th>Total Compra</th>
                <th>Ganancias</th>
              </tr>
            </thead>
            <tbody>
<?php
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
      <tr>
        <td><?php echo $a++; ?></div></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']; ?></td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
        <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******"); ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
        <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_3"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################### BUSQUEDA KARDEX SERVICIOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
?>

<?php 
########################### BUSQUEDA DE SERVICIOS VENDIDOS X FECHAS ##########################
if (isset($_GET['BuscaServiciosVendidosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarServiciosVendidosxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Servicios Vendidos por Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("SERVICIOSVENDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
          <thead>
            <tr>
              <th>Nº</th>
              <th>Código</th>
              <th>Descripción de Servicio</th>
              <th>Precio de Venta</th>
              <th>Vendido</th>
              <th>Impuesto</th>
              <th>Desc %</th>
              <th>Monto Total</th>
            </tr>
          </thead>
          <tbody>
<?php
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
      <tr>
        <td><?php echo $a++; ?></div></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']; ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
        <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SubtotalImpuesto, 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
        <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SubtotalDescuento, 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      </tr>
      <?php } ?>
        <tfoot>
          <tr>
            <th colspan="4"></th>
            <th><span id="total_1"></span></th>
            <th><?php echo $simbolo; ?><span id="total_2"></span></th>
            <th><?php echo $simbolo; ?><span id="total_3"></span></th>
            <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################### BUSQUEDA DE SERVICIOS VENDIDOS X FECHAS ##########################
?>













<?php 
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
if (isset($_GET['BuscaProductosxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");
  
$reg = $new->ListarProductos();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos al Cambio de Moneda</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Moneda de Cambio: </label> <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?><br>

            <label class="control-label">Monto de Cambio: </label> <?php echo number_format($cambio[0]['montocambio'], 2, '.', ','); ?>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row">
          <th>N°</th>
          <th>Código</th>
          <th>Nombre de Producto</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Impuesto</th>
          <th>Desc %</th>
          <th>Existencia</th>
          <th>P. Compra <?php echo $cambio[0]['siglas']; ?></th>
          <th>P. Mayor <?php echo $cambio[0]['siglas']; ?></th>
          <th>P. Menor <?php echo $cambio[0]['siglas']; ?></th>
          <th>P. Público <?php echo $cambio[0]['siglas']; ?></th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">
<?php 
if($reg==""){ 

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
    <tr role="row" class="odd">
        <td><?php echo $a++; ?></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : ""); ?></td>
        <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
        <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
        <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
        <td><?php echo $tipo_simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
        <td><?php echo $tipo_simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
    <tfoot>
      <tr>
        <th colspan="8"></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_1"></span></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_4"></span></th>
      </tr>
    </tfoot>
    <?php } ?>
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
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
?>

<?php 
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codsucursal']) && isset($_GET['codproducto'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codproducto = limpiar($_GET['codproducto']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codproducto=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {

$detalle = new Login();
$detalle = $detalle->DetalleKardexProducto();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos por Producto</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-7">
                <div class="btn-group m-b-20">
                  <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                  <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                  <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Realizado por</th>
                <th>Movimiento</th>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Devolución</th>
                <th>Precio Costo</th>
                <th>Costo Movimiento</th>
                <th>Stock Actual</th>
                <th>Documento</th>
                <th>Fecha de Kardex</th>
              </tr>
            </thead>
            <tbody>
<?php
$TotalEntradas   = 0;
$TotalSalidas    = 0;
$TotalDevolucion =0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>");

$TotalEntradas   += $kardex[$i]['entradas'];
$TotalSalidas    += $kardex[$i]['salidas'];
$TotalDevolucion += $kardex[$i]['devolucion'];
$Descuento       =  $kardex[$i]['descproducto']/100;
$PrecioDescuento =  $kardex[$i]['precio']*$Descuento;
$PrecioFinal     =  $kardex[$i]['precio']-$PrecioDescuento;
?>
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
        <td><?php echo $kardex[$i]['movimiento']; ?></td>
        <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
        <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
        <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
        <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
          <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
        <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
          <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
        <?php } else { ?>
          <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
        <?php } ?>
        <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
        <td><?php echo $kardex[$i]['documento']; ?></td>
        <td><?php echo date("d/m/Y",strtotime($kardex[$i]['fechakardex']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($kardex[$i]['fechakardex']))."</span>"; ?></td>
      </tr>
      <?php  }  ?>
      </tbody>
      </table>              
        <strong>Detalles de Producto</strong><br>
        <strong>Código:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
        <strong>Descripción:</strong> <?php echo $detalle[0]['producto']; ?><br>
        <strong>Marca:</strong> <?php echo $detalle[0]['nommarca']; ?><br>
        <strong>Modelo:</strong> <?php echo $detalle[0]['codmodelo'] == '0' ? "******" : $detalle[0]['nommodelo']; ?><br>
        <strong>Total Entradas:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
        <strong>Total Salidas:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
        <strong>Total Devolución:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
        <strong>Existencia:</strong> <?php echo number_format($detalle[0]['existencia'], 2, '.', ','); ?><br>
        <strong>Precio Compra:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********"); ?><br>
        <strong>Precio Venta Mayor:</strong> <?php echo $simbolo.$detalle[0]['precioxmayor']; ?><br>
        <strong>Precio Venta Menor:</strong> <?php echo $simbolo.$detalle[0]['precioxmenor']; ?><br>
        <strong>Precio Venta Público:</strong> <?php echo $simbolo.$detalle[0]['precioxpublico']; ?>
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
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
?>

<?php 
########################### BUSQUEDA PRODUCTOS VALORIZADO POR FECHAS ##########################
if (isset($_GET['BuscaProductosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
//$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  /*} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;*/
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosValorizadoxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

        <div class="row">
            <div class="col-md-12">
                <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

                <!--<label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>-->
          
                <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

                <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
          <thead>
            <tr>
              <th>N°</th>
              <th>Código</th>
              <th>Nombre de Producto</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Impuesto</th>
              <th>Desc %</th>
              <th>Precio Compra</th>
              <th>Precio Venta</th>
              <th>Vendido</th>
              <th>Total Venta</th>
              <th>Total Compra</th>
              <th>Ganancias</th>
            </tr>
          </thead>
          <tbody>
<?php
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
      <tr>
        <td><?php echo $a++; ?></div></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
          <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
        <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
        <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_3"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
      </tr>
      <?php } ?>
      <tfoot>
        <tr>
          <th colspan="9"></th>
          <th><span id="total_1"></span></th>
          <th><?php echo $simbolo; ?><span id="total_2"></span></th>
          <th><?php echo $simbolo; ?><span id="total_3"></span></th>
          <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################### BUSQUEDA PRODUCTOS VALORIZADO POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS VENDIDOS X FECHAS ##########################
if (isset($_GET['BuscaProductosVendidosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde       = limpiar($_GET['desde']); 
$hasta       = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosVendidosxFechas();  
?>
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Vendidos por Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

        <div class="row">
            <div class="col-md-12">
                <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
          
                <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

                <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
          <thead>
            <tr>
              <th>Nº</th>
              <th>Código</th>
              <th>Descripción</th>
              <th>Marca</th>
              <th>Modelo</th>
              <th>Precio de Venta</th>
              <th>Vendido</th>
              <th>Impuesto</th>
              <th>Desc %</th>
              <th>Monto Total</th>
            </tr>
          </thead>
          <tbody>
<?php
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
    <tr>
      <td><?php echo $a++; ?></div></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo $simbolo; ?><?php echo number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
      <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SubtotalImpuesto, 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SubtotalDescuento, 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
    <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################### BUSQUEDA DE PRODUCTOS VENDIDOS X FECHAS ##########################
?>











<?php 
########################### BUSQUEDA DE COMBOS POR MONEDA ##########################
if (isset($_GET['BuscaCombosxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda   = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");
  
$reg = $new->ListarCombos();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos al Cambio de Moneda</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Moneda de Cambio: </label> <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?><br>

            <label class="control-label">Monto de Cambio: </label> <?php echo number_format($cambio[0]['montocambio'], 2, '.', ','); ?>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row">
            <th>N°</th>
            <th>Código</th>
            <th>Nombre de Combo</th>
            <th>Impuesto</th>
            <th>Desc %</th>
            <th>Detalles de Productos</th>
            <th>Existencia</th>
            <th>P. Compra <?php echo $cambio[0]['siglas']; ?></th>
            <th>P. Mayor <?php echo $cambio[0]['siglas']; ?></th>
            <th>P. Menor <?php echo $cambio[0]['siglas']; ?></th>
            <th>P. Público <?php echo $cambio[0]['siglas']; ?></th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">
<?php 
if($reg==""){ 

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
    <tr role="row" class="odd">
        <td><?php echo $a++; ?></td>
        <td><?php echo $reg[$i]['codcombo']; ?></td>
        <td><?php echo $reg[$i]['nomcombo']; ?></td>
        <td><?php echo $reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo number_format($reg[$i]['desccombo'],2, '.', ','); ?></td>
        <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
        <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
        <td><?php echo $tipo_simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
        <td><?php echo $tipo_simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
    <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_1"></span></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $tipo_simbolo; ?><span id="total_4"></span></th>
      </tr>
    </tfoot>
    <?php } ?>
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
########################### BUSQUEDA DE COMBOS POR MONEDA ##########################
?>

<?php 
######################## BUSQUEDA DE KARDEX POR COMBOS ########################
if (isset($_GET['BuscaKardexCombo']) && isset($_GET['codsucursal']) && isset($_GET['codcombo'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codcombo    = limpiar($_GET['codcombo']); 

  if($codsucursal=="") {

    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
    echo "</div>";
    exit;
   
  } else if($codcombo=="") {

    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL COMBO CORRECTAMENTE</center>";
    echo "</div>";
    exit;
   
  } else {
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexCombo(); 

$detalle = new Login();
$detalle = $detalle->DetalleKardexCombo(); 
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos por Combo</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-7">
                <div class="btn-group m-b-20">
                  <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcombo=<?php echo $codcombo; ?>&tipo=<?php echo encrypt("KARDEXCOMBO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                  <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcombo=<?php echo $codcombo; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                  <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcombo=<?php echo $codcombo; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXCOMBO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Realizado por</th>
                <th>Movimiento</th>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Devolución</th>
                <th>Precio Costo</th>
                <th>Costo Movimiento</th>
                <th>Stock Actual</th>
                <th>Documento</th>
                <th>Fecha de Kardex</th>
              </tr>
            </thead>
            <tbody>
<?php
$TotalEntradas   = 0;
$TotalSalidas    = 0;
$TotalDevolucion = 0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>"); 

$TotalEntradas   += $kardex[$i]['entradas'];
$TotalSalidas    += $kardex[$i]['salidas'];
$TotalDevolucion += $kardex[$i]['devolucion'];
$Descuento       =  $kardex[$i]['descproducto']/100;
$PrecioDescuento =  $kardex[$i]['precio']*$Descuento;
$PrecioFinal     =  $kardex[$i]['precio']-$PrecioDescuento;
?>
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
        <td><?php echo $kardex[$i]['movimiento']; ?></td>
        <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
        <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
        <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
        <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
          <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
        <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
          <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
        <?php } else { ?>
          <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
        <?php } ?>
        <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
        <td><?php echo $kardex[$i]['documento']; ?></td>
        <td><?php echo date("d/m/Y",strtotime($kardex[$i]['fechakardex']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($kardex[$i]['fechakardex']))."</span>"; ?></td>
      </tr>
      <?php  }  ?>
      </tbody>
      </table>

        <strong>Detalles de Combo</strong><br>
        <strong>Código:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
        <strong>Descripción:</strong> <?php echo $detalle[0]['nomcombo']; ?><br>
        <strong>Total Entradas:</strong> <?php echo number_format($TotalEntradas, 2, '.', ','); ?><br>
        <strong>Total Salidas:</strong> <?php echo number_format($TotalSalidas, 2, '.', ','); ?><br>
        <strong>Total Devolución:</strong> <?php echo number_format($TotalDevolucion, 2, '.', ','); ?><br>
        <strong>Existencia:</strong> <?php echo number_format($detalle[0]['existencia'], 2, '.', ','); ?><br>
        <strong>Precio Compra:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********"); ?><br>
        <strong>Precio Venta Mayor:</strong> <?php echo $simbolo.$detalle[0]['precioxmayor']; ?><br>
        <strong>Precio Venta Menor:</strong> <?php echo $simbolo.$detalle[0]['precioxmenor']; ?><br>
        <strong>Precio Venta Público:</strong> <?php echo $simbolo.$detalle[0]['precioxpublico']; ?>
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
######################## BUSQUEDA DE KARDEX POR COMBOS ########################
?>

<?php 
########################### BUSQUEDA KARDEX COMBOS VALORIZADO POR FECHAS ##########################
if (isset($_GET['BuscaCombosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde       = limpiar($_GET['desde']); 
$hasta       = limpiar($_GET['hasta']);
   
  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarCombosValorizadoxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
          <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMBOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
          </div>
        </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr>
            <th>N°</th>
            <th>Código</th>
            <th>Descripción de Combo</th>
            <th>Impuesto</th>
            <th>Desc %</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Vendido</th>
            <th>Total Venta</th>
            <th>Total Compra</th>
            <th>Ganancias</th>
        </tr>
        </thead>
        <tbody>
<?php
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

$PrecioCompraTotal    += $reg[$i]['preciocompra'];
$PrecioVentaTotal     += $reg[$i]['precioventa'];
$VendidosTotal        += $reg[$i]['cantidad'];

$Descuento            = $reg[$i]['descproducto']/100;
$PrecioDescuento      = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal          = $reg[$i]['precioventa']-$PrecioDescuento;

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
        <tr>
          <td><?php echo $a++; ?></div></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
          <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
          <td><?php echo $simbolo; ?><span class="suma_3"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
          <td><?php echo $simbolo; ?><span class="suma_4"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
        </tr>
        <?php } ?>
        <tfoot>
          <tr>
            <th colspan="7"></th>
            <th><?php echo $simbolo; ?><span id="total_1"></span></th>
            <th><?php echo $simbolo; ?><span id="total_2"></span></th>
            <th><?php echo $simbolo; ?><span id="total_3"></span></th>
            <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################### BUSQUEDA KARDEX PRODUCTOS VALORIZADO POR FECHAS ##########################
?>

<?php 
######################## BUSQUEDA DE COMBOS VENDIDOS ########################
if (isset($_GET['BuscaCombosVendidosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde       = limpiar($_GET['desde']); 
$hasta       = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarCombosVendidosxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos Vendidos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMBOSVENDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

    <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
      <thead>
      <tr>
          <th>Nº</th>
          <th>Código</th>
          <th>Descripción de Combo</th>
          <th>Detalles de Productos</th>
          <th>Precio de Venta</th>
          <th>Vendido</th>
          <th>Impuesto</th>
          <th>Desc %</th>
          <th>Monto Total</th>
      </tr>
      </thead>
      <tbody>
<?php
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
  <tr>
    <td><?php echo $a++; ?></div></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo $simbolo; ?><?php echo number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SubtotalImpuesto, 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($SubtotalDescuento, 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
  </tr>
  <?php } ?>
  <tfoot>
    <tr>
      <th colspan="5"></th>
      <th><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
######################## BUSQUEDA DE COMBOS VENDIDOS ########################
?>














<?php
######################## BUSQUEDA TRASPASOS POR FECHAS ########################
if (isset($_GET['BuscaTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarTraspasosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Traspasos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>N° de Factura</th>
            <th>N° de Tracking</th>
            <th>Sucursal Remitente</th>
            <th>Sucursal Destinatario</th>
            <th>Fecha Emisión</th>
            <th>Estado</th>
            <th>Nº de Articulos</th>
            <th>Descontado</th>
            <th>Subtotal</th>
            <th>Total <?php echo $NomImpuesto; ?></th>
            <th>Imp. Total</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
          </tr>
        </thead>
        <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php echo $reg[$i]['numero_tracking']; ?></td>
  <td><?php echo $reg[$i]['cuitsucursal'].": <strong><br>".$reg[$i]['nomsucursal']."</strong>"; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong><br>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
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

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codtraspaso=<?php echo encrypt($reg[$i]["codtraspaso"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['sucursal_envia']); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
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
######################## BUSQUEDA TRASPASOS POR FECHAS ########################
?>

<?php
########################## BUSQUEDA DETALLES TRASPASOS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesTraspasosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Traspasos por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Desc %</th>
                <th>Impuesto</th>
                <th>Precio de Venta</th>
                <th>Existencia</th>
                <th>Traspasado</th>
                <th>Monto Total</th>
              </tr>
            </thead>
            <tbody>
<?php
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
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
        <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
        <td><?php echo $reg[$i]['codmodelo'] == '' ? "******" : $reg[$i]['nommodelo']; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
        <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
        <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      </tr>
      <?php } ?>
       <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><span id="total_2"></span></th>
        <th><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES TRASPASOS POR FECHAS ##########################
?>















<?php
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
if (isset($_GET['BuscaComprasxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal  = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxProveedor();
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Estado</th>
        <th>Dias Venc.</th>
        <th>Fecha de Emisión</th>
        <th>Fecha de Recepción</th>
        <th>Nº de Articulos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Gasto Envio</th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td>
  <?php 
  if($reg[$i]["statuscompra"] == 'PAGADA'){ 
      echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ 
      echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>";
  } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { 
      echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; 
  } else { 
      echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } ?>
  </td>
  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>     
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_6"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th><?php echo $simbolo; ?><span id="total_6"></span></th>
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
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
?>


<?php
######################### BUSQUEDA COMPRAS POR FECHAS ########################
if (isset($_GET['BuscaComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Proveedor</th>
        <th>Estado</th>
        <th>Dias Venc.</th>
        <th>Fecha de Emisión</th>
        <th>Fecha de Recepción</th>
        <th>Nº de Articulos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Gasto Envio</th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td>
  <?php 
  if($reg[$i]["statuscompra"] == 'PAGADA'){ 
      echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ 
      echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>";
  } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { 
      echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; 
  } else { 
      echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } ?>
  </td>
  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
          
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_6"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th><?php echo $simbolo; ?><span id="total_6"></span></th>
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
########################## BUSQUEDA COMPRAS POR FECHAS ##########################
?>

<?php
######################## BUSQUEDA ABONOS CREDITOS DE COMPRAS POR FECHAS ########################
if (isset($_GET['BuscaAbonosCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codmediopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal  = limpiar($_GET['codsucursal']);
  //$codbanco   = limpiar($_GET['codbanco']);
  $codmediopago = limpiar($_GET['codmediopago']);
  $desde        = limpiar($_GET['desde']);
  $hasta        = limpiar($_GET['hasta']);

 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codmediopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

 } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


 } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

 } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarAbonosCreditosComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Abonos Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ABONOSCREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Forma de Pago: </label> <?php echo $reg[0]['mediopago']; ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
          <thead>
          <tr>
            <th>Nº</th>
            <th>N° de Factura</th>
            <th>N° de Documento</th>
            <th>Descripción de Proveedor</th>
            <th>Fecha de Abono</th>
            <th>Nº de Comprobante</th>
            <th>Nombre de Banco</th>
            <th>Monto de Abono</th>
          </tr>
          </thead>
          <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

$TotalImporte+=$reg[$i]['montoabono'];
?>
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
      <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).":</strong><br> ".$reg[$i]['cuitproveedor']; ?></td>
      <td><?php echo $reg[$i]['nomproveedor']; ?></td>
      <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaabono']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaabono']))."</span>"; ?></td>
      <td><?php echo $reg[$i]['comprobante'] == '' ? "********" : $reg[$i]['comprobante']; ?></td>
      <td><?php echo $reg[$i]['codbanco'] == '0' ? "********" : $reg[$i]['nombanco']; ?></td>
      <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['montoabono'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
    <tfoot>
    <tr>
      <th colspan="7"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
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
######################## BUSQUEDA ABONOS CREDITOS DE COMPRAS POR FECHAS ########################
?>

<?php
########################## BUSQUEDA CREDITOS DE COMPRAS POR PROVEEDOR ##########################
if (isset($_GET['BuscaCreditosComprasxProveedor']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['codproveedor'])) {
  
  $codsucursal  = limpiar($_GET['codsucursal']);
  $status       = limpiar($_GET['status']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else {

$pre = new Login();
$reg = $pre->BuscarCreditosComprasxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos Compras por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>N° de Factura</th>
            <th>Estado</th>
            <th>Dias Venc</th>
            <th>Fecha Emisión</th>
            <th>Imp. Total</th>
            <th>Total Abono</th>
            <th>Total Debe</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
          </tr>
        </thead>
        <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td>
  <?php 
  if($reg[$i]["statuscompra"] == 'PAGADA'){ 
      echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ 
      echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>";
  } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { 
      echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; 
  } else { 
      echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } ?>
  </td>
  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td>
  <?php if($_SESSION['acceso'] != "administradorG") { ?>
  <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#ModalAbonosCompra" title="Abonar" onClick="
  AbonoCreditoCompra(
  '<?php echo encrypt($reg[$i]["codcompra"]); ?>',
  '<?php echo $reg[$i]["codfactura"]; ?>',
  '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
  '<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
  '<?php echo $reg[$i]["nomproveedor"]; ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"], 2, '.', ''); ?>',
  '<?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>
  <?php } ?>

    <span class="text-warning" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
    </td>
    </tr>
    <?php } ?>
    <tfoot>
      <tr>
        <th colspan="5"></th>
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
########################## BUSQUEDA CREDITOS DE COMPRAS POR PROVEEDOR ##########################
?>

<?php
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

 } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


 } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

 } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

 } else {

$pre = new Login();
$reg = $pre->BuscarCreditosComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

     <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>N° de Factura</th>
            <th>Descripción de Proveedor</th>
            <th>Estado</th>
            <th>Dias Venc</th>
            <th>Fecha Emisión</th>
            <th>Imp. Total</th>
            <th>Total Abono</th>
            <th>Total Debe</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
          </tr>
        </thead>
        <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td>
  <?php 
  if($reg[$i]["statuscompra"] == 'PAGADA'){ 
      echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ 
      echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>";
  } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { 
      echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; 
  } else { 
      echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } ?>
  </td>
  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td>
  <?php if($_SESSION['acceso'] != "administradorG") { ?>
  <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#ModalAbonosCompra" title="Abonar" onClick="
  AbonoCreditoCompra(
  '<?php echo encrypt($reg[$i]["codcompra"]); ?>',
  '<?php echo $reg[$i]["codfactura"]; ?>',
  '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
  '<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
  '<?php echo $reg[$i]["nomproveedor"]; ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"], 2, '.', ''); ?>',
  '<?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>
  <?php } ?>

    <span class="text-warning" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
    </td>
      </tr>
      <?php } ?>
       <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      </tr>
      </tfoot>
      </tbody>
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
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR PROVEEDOR ##########################
if (isset($_GET['BuscaDetallesCreditosComprasxProveedor']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['codproveedor'])){
  
  $codsucursal  = limpiar($_GET['codsucursal']);
  $status       = limpiar($_GET['status']);
  $codproveedor = limpiar($_GET['codproveedor']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($codproveedor=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PROVEEDOR CORRECTAMENTE</center>";
  echo "</div>";   
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosComprasxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Compras a Créditos por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
           <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?><br>
            
            <label class="control-label">Nº de Telefono: </label> <?php echo $reg[0]['tlfproveedor'] == "" ? "********" : $reg[0]['tlfproveedor']; ?><br>

            <label class="control-label">Dirección Domiciliaria: </label> <?php echo $reg[0]['direcproveedor'] == "" ? "********" : $reg[0]['direcproveedor']; ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
              <tr>
                <th>Nº</th>
                <th>N° de Factura</th>
                <th>Detalles Productos</th>
                <th>Estado</th>
                <th>Dias Venc</th>
                <th>Fecha Emisión</th>
                <th>Imp. Total</th>
                <th>Total Abono</th>
                <th>Total Debe</th>
                <th><span class="mdi mdi-drag-horizontal"></span></th>
              </tr>
            </thead>
            <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td>
  <?php 
  if($reg[$i]["statuscompra"] == 'PAGADA'){ 
      echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ 
      echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>";
  } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { 
      echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; 
  } else { 
      echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } ?>
  </td>
  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td>
  <?php if($_SESSION['acceso'] != "administradorG") { ?>
  <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#ModalAbonosCompra" title="Abonar" onClick="
  AbonoCreditoCompra(
  '<?php echo encrypt($reg[$i]["codcompra"]); ?>',
  '<?php echo $reg[$i]["codfactura"]; ?>',
  '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
  '<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
  '<?php echo $reg[$i]["nomproveedor"]; ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"], 2, '.', ''); ?>',
  '<?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>
  <?php } ?>

    <span class="text-warning" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
    </td>
    </tr>
    <?php } ?>
    <tfoot>
      <tr>
        <th colspan="6"></th>
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
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR PROVEEDOR ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosComprasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Compras a Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
            
            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>N° de Factura</th>
            <th>Descripción de Proveedor</th>
            <th>Detalles Productos</th>
            <th>Estado</th>
            <th>Dias Venc</th>
            <th>Fecha Emisión</th>
            <th>Imp. Total</th>
            <th>Total Abono</th>
            <th>Total Debe</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
          </tr>
        </thead>
        <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td>
  <?php 
  if($reg[$i]["statuscompra"] == 'PAGADA'){ 
      echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } elseif($reg[$i]["statuscompra"] == 'ANULADA'){ 
      echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>";
  } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { 
      echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; 
  } else { 
      echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; 
  } ?>
  </td>
  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td>
  <?php if($_SESSION['acceso'] != "administradorG") { ?>
  <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#ModalAbonosCompra" title="Abonar" onClick="
  AbonoCreditoCompra(
  '<?php echo encrypt($reg[$i]["codcompra"]); ?>',
  '<?php echo $reg[$i]["codfactura"]; ?>',
  '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
  '<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
  '<?php echo $reg[$i]["nomproveedor"]; ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"], 2, '.', ''); ?>',
  '<?php echo date("d/m/Y",strtotime($reg[$i]['fechaemision'])); ?>',
  '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>
  <?php } ?>

    <span class="text-warning" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

    <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[$i]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
    </td>
    </tr>
    <?php } ?>
    <tfoot>
      <tr>
        <th colspan="7"></th>
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
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR FECHAS ##########################
?>
















<?php
######################### BUSQUEDA COTIZACIONES POR FECHAS ########################
if (isset($_GET['BuscaCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COTIZACION" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
  <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</span>"; ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcotizacion=<?php echo encrypt($reg[$i]["codcotizacion"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
?>

<?php
######################### BUSQUEDA COTIZACIONES POR VENDEDOR ########################
if (isset($_GET['BuscaCotizacionesxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codigo      = limpiar($_GET['codigo']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxVendedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COTIZACION" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
  <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</span>"; ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcotizacion=<?php echo encrypt($reg[$i]["codcotizacion"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA COTIZACIONES POR VENDEDOR ##########################
?>

<?php
######################### BUSQUEDA COTIZACIONES POR CLIENTES ########################
if (isset($_GET['BuscaCotizacionesxClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcliente  = limpiar($_GET['codcliente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxClientes();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("COTIZACIONESXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Cliente: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COTIZACION" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechacotizacion']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechacotizacion']))."</span>"; ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codcotizacion=<?php echo encrypt($reg[$i]["codcotizacion"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="4"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA COTIZACIONES POR CLIENTES ##########################
?>

<?php
########################## BUSQUEDA DETALLES COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCotizacionesxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Cotizaciones por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Stock</th>
            <th>Cotizado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
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
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php 
      if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
      } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
      } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
      } ?></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
      <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
      <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
      <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
      <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
     <tfoot>
    <tr>
      <th colspan="8"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
      <th><span id="total_2"></span></th>
      <th><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES COTIZACIONES POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES COTIZACIONES POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesCotizacionesxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codigo      = limpiar($_GET['codigo']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCotizacionesxVendedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Cotizaciones por Vendedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Existencia</th>
            <th>Cotizado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
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
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php 
      if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
      } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
      } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
      } ?></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
      <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
      <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
      <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
      <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
     <tfoot>
    <tr>
      <th colspan="8"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
      <th><span id="total_2"></span></th>
      <th><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES COTIZACIONES POR VENDEDOR ##########################
?>





















<?php
######################### BUSQUEDA PREVENTAS POR FECHAS ########################
if (isset($_GET['BuscaPreventasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPreventasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Preventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_PREVENTA" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
  <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</span>"; ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpreventa=<?php echo encrypt($reg[$i]["codpreventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA PREVENTAS POR FECHAS ##########################
?>

<?php
######################### BUSQUEDA PREVENTAS POR VENDEDOR ########################
if (isset($_GET['BuscaPreventasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codigo      = limpiar($_GET['codigo']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPreventasxVendedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Preventas por Vendedor</h4>
      </div>

    <div class="form-body">
      <div class="card-body">

        <div class="row">
          <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PREVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
            </div>
          </div>
        </div>

    <div class="row">
      <div class="col-md-12">
          <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

          <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
    
          <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

          <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
      </div>
    </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_PREVENTA" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
  <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</span>"; ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpreventa=<?php echo encrypt($reg[$i]["codpreventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA PREVENTAS POR VENDEDOR ##########################
?>

<?php
######################### BUSQUEDA PREVENTAS POR CLIENTES ########################
if (isset($_GET['BuscaPreventasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcliente = limpiar($_GET['codcliente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPreventasxClientes();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Preventas por Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("PREVENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Cliente: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_PREVENTA" ? "FACTURA" : "TICKET").":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]['procesada'] == 1){
    echo "<span class='badge badge-success alert-link'><i class='fa fa-info'></i> PENDIENTE</span>";
    } elseif($reg[$i]['procesada'] == 2){
    echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> PROCESADA</span>"; 
    } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechapreventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechapreventa']))."</span>"; ?></td>

  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codpreventa=<?php echo encrypt($reg[$i]["codpreventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="4"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA PREVENTAS POR CLIENTES ##########################
?>

<?php
########################## BUSQUEDA DETALLES PREVENTAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesPreventasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesPreventasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Preventas por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Stock</th>
            <th>Cotizado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
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
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php 
      if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
      } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
      } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
      } ?></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
      <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
      <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
      <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
      <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
     <tfoot>
    <tr>
      <th colspan="8"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
      <th><span id="total_2"></span></th>
      <th><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES PREVENTAS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES PREVENTAS POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesPreventasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codigo      = limpiar($_GET['codigo']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesPreventasxVendedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Preventas por Vendedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Existencia</th>
            <th>Cotizado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
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
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php 
      if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
      } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
      } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
      } ?></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
      <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
      <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
      <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
      <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
    </tr>
    <?php } ?>
     <tfoot>
    <tr>
      <th colspan="8"></th>
      <th><?php echo $simbolo; ?><span id="total_1"></span></th>
      <th><span id="total_2"></span></th>
      <th><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES PREVENTAS POR VENDEDOR ##########################
?>
















<?php
########################## BUSQUEDA ARQUEOS DE CAJA POR FECHAS ##########################
if (isset($_GET['BuscaArqueosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarArqueosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Arqueos de Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
          <thead>
          <tr>
            <th>Nº</th>
            <th>Caja</th>
            <th>Hora de Apertura</th>
            <th>Hora de Cierre</th>
            <th>Monto Inicial</th>
            <th>Total en Ventas</th>
            <th>Total en Ingresos</th>
            <th>Total en Egresos</th>
            <th>Efectivo en Caja</th>
            <th>Efectivo Disponible</th>
            <th>Diferencia Efectivo</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
          </tr>
          </thead>
          <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['nrocaja'].":</span><br>".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaapertura']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaapertura']))."</span>"; ?></td>
    <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d/m/Y",strtotime($reg[$i]['fechatraspaso']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechatraspaso']))."</span>"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['ingresos2']+$reg[$i]['abonos'], 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['egresos']+$reg[$i]['egresonotas'], 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]['efectivocaja'], 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_6"><?php echo number_format($reg[$i]['diferencia'], 2, '.', ','); ?></span></td>
    <td>
    <?php if($reg[$i]["statusarqueo"] == '0'){ ?>
    <span class="text-default" style="cursor: pointer;" title="Imprimir Ticket" onClick="VentanaCentrada('reportepdf?codarqueo=<?php echo encrypt($reg[$i]["codarqueo"]); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
    <?php } ?></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th><?php echo $simbolo; ?><span id="total_6"></span></th>
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
########################## BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ##########################
?>

<?php
######################### BUSQUEDA MOVIMIENTOS DE CAJA POR FECHAS ########################
if (isset($_GET['BuscaMovimientosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarMovimientosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos en Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
          <thead>
          <tr>
            <th>Nº</th>
            <th>Nº de Caja</th>
            <th>Responsable</th>
            <th>Tipo Movimiento</th>
            <th>Descripción</th>
            <th>Forma de Movimiento</th>
            <th>Fecha Movimiento</th>
            <th>Monto Ingresos</th>
            <th>Monto Egresos</th>
            <th><span class="mdi mdi-drag-horizontal"></span></th>
          </tr>
          </thead>
          <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
    <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['nrocaja'].":</span><br>".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['dni'].":</span><br>".$reg[$i]['nombres']; ?></td>
    <td><?php echo $status = ($reg[$i]['tipomovimiento'] == 'INGRESO' ? "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]['tipomovimiento']."</span>" : "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> ".$reg[$i]['tipomovimiento']."</span>"); ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechamovimiento']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechamovimiento']))."</span>"; ?></td>
    <td><?php echo $simbolo; ?><span class="suma_1"><?php echo $ingreso = ($reg[$i]['tipomovimiento'] == 'INGRESO' ? number_format($reg[$i]['montomovimiento'], 2, '.', ',') : "0.00"); ?></span></td>
    <td><?php echo $simbolo; ?><span class="suma_2"><?php echo $ingreso = ($reg[$i]['tipomovimiento'] == 'EGRESO' ? number_format($reg[$i]['montomovimiento'], 2, '.', ',') : "0.00"); ?></span></td>
    <td><span class="text-default" style="cursor: pointer;" title="Imprimir Ticket" onClick="VentanaCentrada('reportepdf?numero=<?php echo encrypt($reg[$i]["numero"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]["tipodocumento"]); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
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
####################### BUSQUEDA MOVIMIENTOS DE CAJAS POR FECHAS ########################
?>

<?php
######################## BUSQUEDA INFORMES CAJAS POR FECHAS ########################
if (isset($_GET['BuscaInformesCajasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

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
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Informe de Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("INFORMECAJASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("INFORMECAJASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("INFORMECAJASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
                <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $caja[0]['nomsucursal']; ?><br><?php } ?>

                <label class="control-label">Descripción de Caja: </label> <?php echo $caja[0]['nrocaja'].": ".$caja[0]['nomcaja']; ?><br>

                <label class="control-label">Responsable de Caja: </label> <?php echo $caja[0]['nombres']; ?><br>

                <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

                <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
            </div>
          </div><hr>

          <div class="row">
            <table border="0" class="table table-striped table-bordered border display">
              <tr>
                <td class="text-left text-dark alert-link">TOTAL DE VENTAS</td>
                <td class="text-left text-dark alert-link"><?php echo $simbolo.number_format($venta[0]['totalventa'], 2, '.', ','); ?></td>
              </tr>
              <tr>
                <td class="text-left text-dark alert-link">TOTAL DE INGRESOS</td>
                <td class="text-left text-dark alert-link"><?php echo $simbolo.number_format($arqueo[0]['totalingresos'], 2, '.', ','); ?></td>
              </tr>
              <tr>
                <td class="text-left text-dark alert-link">ABONOS A CRÉDITOS</td>
                <td class="text-left text-dark alert-link"><?php echo $simbolo.number_format($arqueo[0]['totalabonos'], 2, '.', ','); ?></td>
              </tr>
              <tr>
                <td class="text-left text-dark alert-link">TOTAL DE GASTOS (EGRESOS + NOTAS DE CRÉDITOS)</td>
                <td class="text-left text-dark alert-link"><?php echo $simbolo.number_format($arqueo[0]['totalegresos'], 2, '.', ','); ?></td>
              </tr>

              <tr>
                <td class="text-left text-dark alert-link">TOTAL DE IMPUESTOS DE VENTAS <?php echo $NomImpuesto; ?> (<?php echo $ValorImpuesto; ?>%)</td>
                <td class="text-left text-dark alert-link"><?php echo $simbolo.number_format($venta[0]['totaliva'], 2, '.', ','); ?></td>
              </tr>
              <tr>
                <td class="text-left text-dark alert-link">DISPONIBLE EN CAJA SIN IMPUESTOS</td>
                <td class="text-left text-dark alert-link"><?php echo $simbolo.number_format($Disponible, 2, '.', ','); ?></td>
              </tr>
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
######################## BUSQUEDA INFORMES CAJAS POR FECHAS ########################
?>



















<?php
######################## BUSQUEDA LIBRO DE VENTAS POR FECHAS ########################
if (isset($_GET['BuscaLibroVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$nt = new Login();
$nc = $nt->BuscarLibroVentasNCxFechas();

$ven = new Login();
$reg = $ven->BuscarLibroVentasxFechas();
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Libro de Facturación por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("LIBROVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Exportar a Pdf</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">

          <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

          <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive">
      <table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Emisión</th>
            <th>Fact. Inicial</th>
            <th>Fact. Final</th>
            <th>Propinas</th>
            <th>Total/Neto</th>
            <th>Total+Impuesto</th>
            <th>Total/Retenido</th>
            <th>Exoneración</th>
            <th>Base 0%</th>
            <th>Impuesto</th>
            <th>Base <?php echo number_format($ValorImpuesto, 2, '.', ','); ?>%</th>
            <th>Impuesto</th>
          </tr>
        </thead>
        <tbody>
<?php
$a=1;
$TotalPropina     = 0;
$TotalNeto        = 0;
$TotalConImpuesto = 0;
$TotalRetenido    = 0;
$TotalExoneracion = 0;
$TotalExento      = 0;
$ImpuestoExento   = 0;
$TotalBaseIva     = 0;
$TotalIva         = 0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$explode = explode(", ",$reg[$i]['detalles_facturas']);
sort($explode);
//print_r($explode);
$inicio = current($explode); // Primero
$fin = end($explode); // Ultimo

$TotalPropina     += "0.00";
$TotalNeto        += $reg[$i]['subtotal'];
$TotalConImpuesto += $reg[$i]['subtotal']+$reg[$i]['totaliva'];
$TotalRetenido    += "0.00";
$TotalExoneracion += $reg[$i]['totalexonerado'];
$TotalExento      += $reg[$i]['subtotalexento'];
$ImpuestoExento   += "0.00";
$TotalBaseIva     += $reg[$i]['subtotaliva'];
$TotalIva         += $reg[$i]['totaliva'];
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td>FACT <?php echo $inicio; ?></td>
    <td>FACT <?php echo $fin; ?></td>
    <td><span class="suma_1">0.00</span></td>
    <td><span class="suma_2"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
    <td><span class="suma_3"><?php echo number_format($reg[$i]['subtotal']+$reg[$i]['totaliva'], 2, '.', ','); ?></span></td>
    <td><span class="suma_4"><?php echo number_format("0.00", 2, '.', ','); ?></span></td>
    <td><span class="suma_5"><?php echo number_format($reg[$i]['totalexonerado'], 2, '.', ','); ?></span></td>
    <td><span class="suma_6"><?php echo number_format($reg[$i]['subtotalexento'], 2, '.', ','); ?></span></td>
    <td><span class="suma_7"><?php echo number_format("0.00", 2, '.', ','); ?></span></td>
    <td><span class="suma_8"><?php echo number_format($reg[$i]['subtotaliva'], 2, '.', ','); ?></span></td>
    <td><span class="suma_9"><?php echo number_format($reg[$i]['totaliva'], 2, '.', ','); ?></span></td>
  </tr>
  <?php  }  ?>
    <tfoot>
    <tr>
      <th colspan="3"></th>
      <th class="text-dark alert-link">Totales</th>
      <th><span id="total_1"></span></th>
      <th><span id="total_2"></span></th>
      <th><span id="total_3"></span></th>
      <th><span id="total_4"></span></th>
      <th><span id="total_5"></span></th>
      <th><span id="total_6"></span></th>
      <th><span id="total_7"></span></th>
      <th><span id="total_8"></span></th>
      <th><span id="total_9"></span></th>
    </tr>
    </tfoot>
  </tbody>
  </table>
  </div>

  <hr>

  <div class="table-responsive">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
  <tr class="warning-element text-left" style="border-left:2px solid #ff5050 !important;background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
    <td colspan="8">RESUMEN DE LIBRO DE VENTA</td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td>&nbsp;</td>
    <td>BASE</td>
    <td>IMPUESTO</td>
    <td>IMP/RETENIDO</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>BASE</td>
    <td>IMPUESTO</td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td>TOTAL VENTAS EXENTAS (0,00%)</td>
    <td><?php echo number_format($TotalExento, 2, '.', ','); ?></td>
    <td><?php echo number_format($ImpuestoExento, 2, '.', ','); ?></td>
    <td>0.00</td>
    <td>&nbsp;</td>
    <td>N/C 0.00% </td>
    <td><?php echo number_format(empty($nc[0]['subtotalexentonc']) ? "0.00" : $nc[0]['subtotalexentonc'], 2, '.', ','); ?></td>
    <td>0.00</td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td>TOTAL VENTAS GRAVADAS <?php echo $NomImpuesto; ?> (<?php echo number_format($ValorImpuesto, 2, '.', ','); ?>% )</td>
    <td><?php echo number_format($TotalBaseIva, 2, '.', ','); ?></td>
    <td><?php echo number_format($TotalIva, 2, '.', ','); ?></td>
    <td>0.00</td>
    <td>&nbsp;</td>
    <td>N/C <?php echo number_format($ValorImpuesto, 2, '.', ','); ?>%</td>
    <td><?php echo number_format(empty($nc[0]['subtotalivanc']) ? "0.00" : $nc[0]['subtotalivanc'], 2, '.', ','); ?></td>
    <td><?php echo number_format(empty($nc[0]['totalivanc']) ? "0.00" : $nc[0]['totalivanc'], 2, '.', ','); ?></td>
  </tr>
  <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
    <td>TOTAL RETENCIONES IMPUESTO</td>
    <td></td>
    <td></td>
    <td>0.00</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
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
######################## BUSQUEDA LIBRO DE VENTAS POR FECHAS ########################
?>

<?php
######################### BUSQUEDA VENTAS POR CAJAS ########################
if (isset($_GET['BuscaVentasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $codcaja     = limpiar($_GET['codcaja']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCajas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Cajas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Nombre de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Detalles Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]['codcliente'] == '0'){
  echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
  } else {
  echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
  } ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>

  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA VENTAS POR CAJAS ##########################
?>

<?php
######################### BUSQUEDA VENTAS POR FECHAS ########################
if (isset($_GET['BuscaVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Detalles Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>

  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA VENTAS POR FECHAS ##########################
?>

<?php
######################### BUSQUEDA VENTAS POR CLIENTES ########################
if (isset($_GET['BuscaVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codcliente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $codcliente  = limpiar($_GET['codcliente']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxClientes();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Cliente: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Detalles Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>

  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th></th>
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
########################## BUSQUEDA VENTAS POR CLIENTES ##########################
?>

<?php
########################## BUSQUEDA VENTAS POR CONDICIONES DE PAGO ##########################
if (isset($_GET['BuscaVentasxCondiciones']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['formapago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $formapago = limpiar($_GET['formapago']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($formapago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCondiciones();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Facturación por Condición de Pago</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>

            <label class="control-label">Forma de Pago: </label> <?php echo $reg[0]['mediopago']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripción de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Detalles Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th>Total Pagado</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
      </tr>
    </thead>
    <tbody>
<?php
$a=1;
$TotalArticulos  = 0;
$TotalDescontado = 0;
$TotalSubtotal   = 0;
$TotalIva        = 0;
$TotalDescuento  = 0;
$TotalImporte    = 0;
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]['codcliente'] == '0'){
    echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
    } else {
    echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
    } ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>

  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_6"><?php echo number_format($ImportePagado, 2, '.', ','); ?></span></td>
  <td><span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
        <th><?php echo $simbolo; ?><span id="total_5"></span></th>
        <th><?php echo $simbolo; ?><span id="total_6"></span></th>
        <th></th>
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
########################## BUSQUEDA VENTAS POR CONDICIONES DE PAGO ##########################
?>

<?php
######################### BUSQUEDA COMISIONES POR VENTAS ########################
if (isset($_GET['BuscaComisionxVentas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $codigo      = limpiar($_GET['codigo']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codigo=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComisionxVentas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Comisión por Ventas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>

            <label class="control-label">Monto de Comisión: </label> <?php echo number_format($reg[0]['comision'], 2, '.', ','); ?>%<br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>Nº</th>
        <th>N° de Factura</th>
        <th>Descripcuón de Cliente</th>
        <th>Estado</th>
        <th>Fecha Emisión</th>
        <th>Detalles Articulos</th>
        <th>Total Factura</th>
        <th>Total Comisión</th>
      </tr>
    </thead>
    <tbody>
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php if($reg[$i]['codcliente'] == '0'){
  echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
  } else {
  echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
  } ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['comision'], 2, '.', ','); ?>%</sup></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
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
########################## BUSQUEDA COMISION POR VENTAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES VENTAS POR CONDICIONES ##########################
if (isset($_GET['BuscaDetallesVentasxCondiciones']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['tipodetalle']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $tipodetalle = limpiar($_GET['tipodetalle']);
  $desde       = limpiar($_GET['desde']); 
  $hasta       = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($tipodetalle=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DETALLE PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesVentasxCondiciones();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas por Condiciones </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&tipodetalle=<?php echo $tipodetalle; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXCONDICIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&tipodetalle=<?php echo $tipodetalle; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&tipodetalle=<?php echo $tipodetalle; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Tipo de Detalle: </label> <?php if(decrypt($_GET['tipodetalle']) == 0){ echo "GENERAL"; }elseif(decrypt($_GET['tipodetalle']) == 1){ echo "PRODUCTOS"; }elseif(decrypt($_GET['tipodetalle']) == 2){ echo "COMBOS"; } elseif(decrypt($_GET['tipodetalle']) == 3){ echo "SERVICIOS"; }  ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Existencia</th>
            <th>Facturado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
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
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php 
        if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
        } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
        } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
        } ?></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
        <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
        <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
        <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
        <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      </tr>
      <?php } ?>
       <tfoot>
      <tr>
        <th colspan="8"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><span id="total_2"></span></th>
        <th><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES VENTAS POR CONDICIONES ##########################
?>

<?php
########################## BUSQUEDA DETALLES VENTAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesVentasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Facturación por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Existencia</th>
            <th>Facturado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
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
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php 
        if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
        } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
        } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
        } ?></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
        <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
        <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
        <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
        <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      </tr>
      <?php } ?>
       <tfoot>
      <tr>
        <th colspan="8"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><span id="total_2"></span></th>
        <th><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES VENTAS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES VENTAS POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesVentasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago    = limpiar($_GET['tipopago']);
  $codigo      = limpiar($_GET['codigo']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesVentasxVendedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Facturación por Vendedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Detalle</th>
            <th>Código</th>
            <th>Descripción</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Desc %</th>
            <th>Impuesto</th>
            <th>Precio de Venta</th>
            <th>Existencia</th>
            <th>Facturado</th>
            <th>Monto Total</th>
          </tr>
        </thead>
        <tbody>
<?php
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
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
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php 
        if($reg[$i]['tipodetalle'] == 1){ 
        echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
        } elseif($reg[$i]['tipodetalle'] == 2){ 
        echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
        } else { 
        echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
        } ?></td>
        <td><?php echo $reg[$i]['codproducto']; ?></td>
        <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
        <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
        <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
        <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
        <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['precioventa'], 2, '.', ','); ?></span></td>
        <td><span class="suma_2"><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></span></td>
        <td><span class="suma_3"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
        <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      </tr>
      <?php } ?>
       <tfoot>
      <tr>
        <th colspan="8"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
        <th><span id="total_2"></span></th>
        <th><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
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
########################## BUSQUEDA DETALLES VENTAS POR VENDEDOR ##########################
?>

<?php 
########################### BUSQUEDA GANANCIAS POR FECHAS ##########################
if (isset($_GET['BuscaGananciasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$ingresos = new Login();
$detalle_ingreso = $ingresos->BuscarIngresosxFechas(); 

$ganancias = new Login();
$reg = $ganancias->BuscarGananciasxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ganancias por Fechas</h4>
      </div>

    <div class="form-body">
      <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("GANANCIASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>
          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("GANANCIASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>
          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("GANANCIASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
          <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

          <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive">
      <table id="html5-extension" class="table table-striped table-bordered border display">
      <thead>
        <tr>
          <th>N°</th>
          <th>Detalle</th>
          <th>Código</th>
          <th>Nombre de Producto</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Impuesto</th>
          <th>Desc %</th>
          <th>Precio Compra</th>
          <th>Precio Venta</th>
          <th>Vendido</th>
          <th>Total Venta</th>
          <th>Total Compra</th>
          <th>Ganancias</th>
        </tr>
      </thead>
      <tbody>
<?php
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
    <tr>
      <td><?php echo $a++; ?></div></td>
      <td><?php 
      if($reg[$i]['tipodetalle'] == 1){ 
      echo "<span class='badge badge-success alert-link'>PRODUCTO</span>";
      } elseif($reg[$i]['tipodetalle'] == 2){ 
      echo "<span class='badge badge-info alert-link'>COMBO</span>"; 
      } else { 
      echo "<span class='badge badge-primary alert-link'>SERVICIO</span>";
      } ?></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"; ?></td>
      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
      <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
      <td><span class="suma_1"><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($SumVenta, 2, '.', ','); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_3"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
      <td><?php echo $simbolo; ?><span class="suma_4"><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"); ?></span></td>
    </tr>
    <?php } ?>
    <tfoot class="text-dark alert-link">
      <tr>
        <th colspan="10"></th>
        <th><span id="total_1"></span></th>
        <th><?php echo $simbolo; ?><span id="total_2"></span></th>
        <th><?php echo $simbolo; ?><span id="total_3"></span></th>
        <th><?php echo $simbolo; ?><span id="total_4"></span></th>
      </tr>
    </tfoot>
    </tbody>
    </table>
    </div>

    <hr>

    <div class="table-responsive">
      <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
      <thead>
      <tr class="warning-element text-left" style="border-left:2px solid #ff5050 !important;background:#ece8e9;font-weight:bold;font-size:20px;color:#070707;">
        <th colspan="3">DETALLES DE GANANCIAS / INGRESOS / GASTOS</th>
      </tr>
      </thead>
      <tbody>
      <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
        <td colspan="2">TOTAL DE GANANCIAS</td>
        <td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
      </tr>
      <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
        <td colspan="2">INGRESOS ADICIONALES</td>
        <td><?php echo $simbolo.number_format($detalle_ingreso[0]['totalingresos'], 2, '.', ','); ?></td>
      </tr>
      <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
        <td colspan="2">GASTOS</td>
        <td><?php echo $simbolo.number_format($detalle_ingreso[0]['totalegresos'], 2, '.', ','); ?></td>
      </tr>
      <tr style="text-align:left;font-weight:bold;font-size:18px;color:#070707;">
        <td colspan="2">TOTAL</td>
        <td><?php echo $simbolo.number_format($TotalGanancia+$detalle_ingreso[0]['totalingresos']-$detalle_ingreso[0]['totalegresos'], 2, '.', ','); ?></td>
      </tr>
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
########################### BUSQUEDA GANANCIAS POR FECHAS ##########################
?>

















<?php
######################## BUSQUEDA ABONOS CREDITOS POR CAJAS ########################
if (isset($_GET['BuscaAbonosCreditosVentasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['codmediopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal  = limpiar($_GET['codsucursal']);
  $codcaja      = limpiar($_GET['codcaja']);
  $codmediopago = limpiar($_GET['codmediopago']);
  $desde        = limpiar($_GET['desde']);
  $hasta        = limpiar($_GET['hasta']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codmediopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarAbonosCreditosVentasxCajas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Abonos Créditos por Cajas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ABONOSCREDITOSVENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSVENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSVENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
          <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

          <label class="control-label">Nº de Caja: </label> <?php echo $reg[0]['nrocaja']; ?><br>

          <label class="control-label">Nombre de Caja: </label> <?php echo $reg[0]['nomcaja']; ?><br>

          <label class="control-label">Forma de Pago: </label> <?php echo $reg[0]['mediopago']; ?><br>
            
          <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

          <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
            <thead>
            <tr>
              <th>Nº</th>
              <th>N° de Venta</th>
              <th>Nº de Documento</th>
              <th>Descripción de Cliente</th>
              <th>Fecha de Abono</th>
              <th>Nº de Comprobante</th>
              <th>Nombre de Banco</th>
              <th>Monto de Abono</th>
            </tr>
            </thead>
            <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalImporte=0;

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

$TotalImporte+=$reg[$i]['montoabono'];
?>
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento.":</span><br><span class='text-danger alert-link'>".$reg[$i]['codfactura']."</span>"; ?></td>
        <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?></td>
        <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
        <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaabono']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaabono']))."</span>"; ?></td>
        <td><?php echo $reg[$i]['comprobante'] == '' ? "********" : $reg[$i]['comprobante']; ?></td>
        <td><?php echo $reg[$i]['codbanco'] == '0' ? "********" : $reg[$i]['nombanco']; ?></td>
        <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['montoabono'], 2, '.', ','); ?></span></td>
      </tr>
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="7"></th>
        <th><?php echo $simbolo; ?><span id="total_1"></span></th>
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
######################## BUSQUEDA ABONOS CREDITOS POR CAJAS ########################
?>

<?php
########################## BUSQUEDA CREDITOS POR CONDICIONES ##########################
if (isset($_GET['BuscaCreditosVentasxCondiciones']) && isset($_GET['codsucursal']) && isset($_GET['tipobusqueda'])){
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipobusqueda = limpiar($_GET['tipobusqueda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";   
  exit;
   
  } else if($tipobusqueda=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else {

$pre = new Login();
$reg = $pre->BuscarCreditosVentasxCondiciones();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Condiciones</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCONDICIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipobusqueda=<?php echo $tipobusqueda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Tipo de Búsqueda: </label> <?php if(decrypt($tipobusqueda) == 1){ echo "GENERAL"; }elseif(decrypt($tipobusqueda) == 2){ echo "PAGADAS"; } elseif(decrypt($tipobusqueda) == 3){ echo "PENDIENTES"; } elseif(decrypt($tipobusqueda) == 4){ echo "VENCIDAS"; }  ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr>
          <th>N°</th>
          <th>N° de Factura</th>
          <th>Descripción de Cliente</th>
          <th>Fecha Emisión</th>
          <th>Fecha Venc.</th>
          <th>Estado</th>
          <th>Total Factura</th>
          <th>Total Abonado</th>
          <th>Total Pendiente</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";

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
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente']; ?></td>
      
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>                         
  <td>
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
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
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
########################## BUSQUEDA CREDITOS POR CONDICIONES ##########################
?>

<?php
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr>
          <th>N°</th>
          <th>N° de Factura</th>
          <th>Descripción de Cliente</th>
          <th>Fecha Emisión</th>
          <th>Fecha Venc.</th>
          <th>Estado</th>
          <th>Total Factura</th>
          <th>Total Abonado</th>
          <th>Total Pendiente</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";

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
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente']; ?></td>
      
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>                         
  <td>
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
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="6"></th>
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
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA CREDITOS AGRUPADOS POR CLIENTE Y FECHAS ##########################
if (isset($_GET['BuscaCreditosVentasxFechasAgrupado']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosVentasxFechasAgrupado();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-users"></i> Créditos Agrupados por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-success" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS_AGRUPADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Descargar Excel"><span class="fa fa-file-excel-o"></span> Descargar Excel</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered border">
        <thead class="bg-danger text-white">
        <tr>
          <th>N° Factura</th>
          <th>Fecha Emisión</th>
          <th>Fecha Venc.</th>
          <th>Estado</th>
          <th>Total Factura</th>
          <th>Total Abonado</th>
          <th>Total Pendiente</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
<?php
$simbolo = "<strong>".$reg[0]['simbolo']."</strong> ";

// Variables para agrupar por cliente
$clienteActual = "";
$totalClienteFactura = 0;
$totalClienteAbonado = 0;
$totalClientePendiente = 0;

// Variables para totales generales
$totalGeneralFactura = 0;
$totalGeneralAbonado = 0;
$totalGeneralPendiente = 0;

$numeroFactura = 1;

for($i=0;$i<sizeof($reg);$i++){

// Identificador único del cliente
$clienteID = $reg[$i]['codcliente'];
$clienteNombre = $reg[$i]['nomcliente'];
$clienteDNI = $reg[$i]['dnicliente'];
$clienteDocumento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']);

// Si cambia el cliente, mostrar subtotal del anterior y encabezado del nuevo
if($clienteActual != "" && $clienteActual != $clienteID){
    // Mostrar subtotal del cliente anterior
    ?>
    <tr class="subtotal-row">
        <td colspan="4" class="text-right"><strong>SUBTOTAL <?php echo strtoupper($reg[$i-1]['nomcliente']); ?>:</strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalClienteFactura, 2, '.', ','); ?></strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalClienteAbonado, 2, '.', ','); ?></strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalClientePendiente, 2, '.', ','); ?></strong></td>
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
    <tr class="cliente-group">
        <td colspan="8">
            <div class="cliente-header">
                <i class="fa fa-user"></i> CLIENTE: <?php echo strtoupper($clienteNombre); ?>
            </div>
            <div class="cliente-info">
                <strong><?php echo $clienteDocumento; ?>:</strong> <?php echo $clienteDNI; ?>
                <?php if($reg[$i]['tlfcliente'] != ""){ ?>
                | <strong>Teléfono:</strong> <?php echo $reg[$i]['tlfcliente']; ?>
                <?php } ?>
                <?php if($reg[$i]['direccliente'] != ""){ ?>
                | <strong>Dirección:</strong> <?php echo $reg[$i]['direccliente']; ?>
                <?php } ?>
            </div>
        </td>
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
?>
  <tr class="factura-row">
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo $simbolo; ?><?php echo number_format($totalFactura, 2, '.', ','); ?></td>
  <td><?php echo $simbolo; ?><?php echo number_format($totalAbonado, 2, '.', ','); ?></td>
  <td><?php echo $simbolo; ?><?php echo number_format($totalPendiente, 2, '.', ','); ?></td>                         
  <td>
  <?php if($_SESSION['acceso']=="administradorS" && $totalPendiente > 0 || $_SESSION["acceso"]=="secretaria" && $totalPendiente > 0 || $_SESSION["acceso"]=="cajero" && $totalPendiente > 0){ ?>

  <span class="text-primary" style="cursor: pointer;" data-toggle="modal" data-target="#myModalPago" title="Abonar" 
  onClick="AbonoCreditoVenta('<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo $reg[$i]["codcliente"]; ?>',
  '<?php echo encrypt($reg[$i]["codventa"]); ?>',
  '<?php echo $clienteDocumento.": ".$clienteDNI; ?>',
  '<?php echo $clienteNombre; ?>',
  '<?php echo $reg[$i]["codfactura"]; ?>',
  '<?php echo number_format($totalFactura, 2, '.', ''); ?>',
  '<?php echo date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
  '<?php echo number_format($totalPendiente, 2, '.', ''); ?>',
  '<?php echo number_format($totalAbonado, 2, '.', ''); ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></span>

  <?php } ?>

  <span class="text-default" style="cursor: pointer;" title="Ticket Abonos" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo $reg[$i]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_VENTA_8") : encrypt("TICKET_CREDITO_VENTA_5"); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg></span>

  <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[$i]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
      </td>
      </tr>
<?php 
} 

// Mostrar subtotal del último cliente
if($clienteActual != ""){
?>
    <tr class="subtotal-row">
        <td colspan="4" class="text-right"><strong>SUBTOTAL <?php echo strtoupper($reg[sizeof($reg)-1]['nomcliente']); ?>:</strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalClienteFactura, 2, '.', ','); ?></strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalClienteAbonado, 2, '.', ','); ?></strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalClientePendiente, 2, '.', ','); ?></strong></td>
        <td></td>
    </tr>
<?php } ?>

      <!-- TOTAL GENERAL -->
      <tr class="total-general-row">
        <td colspan="4" class="text-right"><strong><i class="fa fa-calculator"></i> TOTAL GENERAL:</strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalGeneralFactura, 2, '.', ','); ?></strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalGeneralAbonado, 2, '.', ','); ?></strong></td>
        <td><strong><?php echo $simbolo; ?><?php echo number_format($totalGeneralPendiente, 2, '.', ','); ?></strong></td>
        <td></td>
      </tr>
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
########################## BUSQUEDA CREDITOS AGRUPADOS POR CLIENTE Y FECHAS ##########################
?>

<?php
########################## BUSQUEDA CREDITOS POR CLIENTES ##########################
if (isset($_GET['BuscaCreditosVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $codcliente = limpiar($_GET['codcliente']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosVentasxClientes();
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Cliente: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
            
            <label class="control-label">Nº de Telefono: </label> <?php echo $reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']; ?><br>

            <label class="control-label">Dirección Domiciliaria: </label> <?php echo $reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']; ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr>
          <th>N°</th>
          <th>N° de Factura</th>
          <th>Fecha Emisión</th>
          <th>Fecha Venc.</th>
          <th>Estado</th>
          <th>Total Factura</th>
          <th>Total Abonado</th>
          <th>Total Pendiente</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong>";

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
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>                         
  <td>
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
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="5"></th>
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
########################## BUSQUEDA CREDITOS POR CLIENTES ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCreditosVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosVentasxFechas();
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr>
          <th>N°</th>
          <th>N° de Factura</th>
          <th>Descripción de Cliente</th>
          <th>Fecha Emisión</th>
          <th>Fecha Venc.</th>
          <th>Estado</th>
          <th>Detalles Productos</th>
          <th>Detalles Abonos</th>
          <th>Total Factura</th>
          <th>Total Abonado</th>
          <th>Total Pendiente</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong>";

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
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente']; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_abonos']; ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>                         
  <td>
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
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="8"></th>
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
########################## BUSQUEDA DETALLES CREDITOS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS POR CLIENTES ##########################
if (isset($_GET['BuscaDetallesCreditosVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status      = limpiar($_GET['status']);
  $codcliente = limpiar($_GET['codcliente']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($codcliente=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
  echo "</div>";   
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosVentasxClientes();
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Créditos por Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Estado de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Cliente: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
            
            <label class="control-label">Nº de Telefono: </label> <?php echo $reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']; ?><br>

            <label class="control-label">Dirección Domiciliaria: </label> <?php echo $reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']; ?>
        </div>
      </div>

    <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
        <thead>
        <tr>
          <th>N°</th>
          <th>N° de Factura</th>
          <th>Fecha Emisión</th>
          <th>Fecha Venc.</th>
          <th>Estado</th>
          <th>Detalles Productos</th>
          <th>Detalles Abonos</th>
          <th>Total Factura</th>
          <th>Total Abonado</th>
          <th>Total Pendiente</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong>";

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
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechaventa']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($reg[$i]['fechaventa']))."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-info alert-link'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger alert-link'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-success alert-link'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_abonos']; ?></td>
  <td><?php echo $simbolo; ?><span class="suma_1"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></span></td>                         
  <td>
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
      <?php } ?>
      <tfoot>
      <tr>
        <th colspan="7"></th>
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
########################## BUSQUEDA DETALLES CREDITOS POR CLIENTES ##########################
?>















<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ##########################
if (isset($_GET['BuscaNotasCreditosxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja     = limpiar($_GET['codcaja']);
  $desde       = limpiar($_GET['desde']);
  $hasta       = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasCreditosxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Caja</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>

            <label class="control-label">Nº de Caja: </label> <?php echo $reg[0]['nrocaja']; ?><br>

            <label class="control-label">Nombre de Caja: </label> <?php echo $reg[0]['nomcaja']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>N°</th>
        <th>N° de Factura</th>
        <th>Documento de Venta</th>
        <th>Descripción de Cliente</th>
        <th>Fecha Emisión</th>
        <th>Detalles de Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['tipofacturaventa']."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['facturaventa']."</span>"; ?></td>
  <td><?php if($reg[$i]['codcliente'] == '0'){
  echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
  } else {
  echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
  } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td>
  <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codnota=<?php echo encrypt($reg[$i]["codnota"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
  </td>
  </tr>
  <?php } ?>
    <tfoot>
    <tr>
      <th colspan="6"></th>
      <th><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
      <th><?php echo $simbolo; ?><span id="total_5"></span></th>
      <th></th>
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
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ########################
?>

<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaNotasCreditosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasCreditosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <?php if ($_SESSION["acceso"]=="administradorG") { ?><label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br><?php } ?>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d/m/Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d/m/Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>N°</th>
        <th>N° de Caja</th>
        <th>N° de Factura</th>
        <th>Documento de Venta</th>
        <th>Descripción de Cliente</th>
        <th>Fecha Emisión</th>
        <th>Detalles de Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['tipofacturaventa']."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['facturaventa']."</span>"; ?></td>
  <td><?php if($reg[$i]['codcliente'] == '0'){
  echo "<span class='text-dark alert-link'>CONSUMIDOR FINAL</span>";
  } else {
  echo "<span class='text-dark alert-link'>Nº ".$documcliente = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']."</span><br> ".$reg[$i]['nomcliente'];
  } ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td>
  <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codnota=<?php echo encrypt($reg[$i]["codnota"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
  </td>
  </tr>
  <?php } ?>
    <tfoot>
    <tr>
      <th colspan="7"></th>
      <th><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
      <th><?php echo $simbolo; ?><span id="total_5"></span></th>
      <th></th>
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
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ########################
?>

<?php
######################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ########################
if (isset($_GET['BuscaNotasCreditosxClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcliente  = limpiar($_GET['codcliente']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasCreditosxClientes();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos del Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Cliente: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
            
            <label class="control-label">Nº de Telefono: </label> <?php echo $reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']; ?><br>

            <label class="control-label">Dirección Domiciliaria: </label> <?php echo $reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']; ?>
        </div>
      </div>

  <div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>N°</th>
        <th>N° de Caja</th>
        <th>N° de Factura</th>
        <th>Documento de Venta</th>
        <th>Fecha Emisión</th>
        <th>Detalles de Productos</th>
        <th>Nº Artículos</th>
        <th>Descontado</th>
        <th>Subtotal</th>
        <th>Total <?php echo $NomImpuesto; ?></th>
        <th>Imp. Total</th>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
  <td><?php echo "<span class='text-dark alert-link'>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET")."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<span class='text-dark alert-link'>".$reg[$i]['tipofacturaventa']."</span><br><span class='text-danger alert-link'> Nº: ".$reg[$i]['facturaventa']."</span>"; ?></td>
  <td><?php echo date("d/m/Y",strtotime($reg[$i]['fechanota'])); ?></td>
  <td style="font-size:9px;background:#e3edf0;color:#0b1379;font-weight:bold;"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><span class="suma_1"><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_2"><?php echo number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_3"><?php echo number_format($reg[$i]['subtotal'], 2, '.', ','); ?></span></td>
  <td><?php echo $simbolo; ?><span class="suma_4"><?php echo number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ','); ?></span><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo; ?><span class="suma_5"><?php echo number_format($reg[$i]['totalpago'], 2, '.', ','); ?></span></td>
  <td>
  <span class="text-default" style="cursor: pointer;" title="Imprimir Factura" onClick="VentanaCentrada('reportepdf?codnota=<?php echo encrypt($reg[$i]["codnota"]); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></span></span>
  </td>
  </tr>
  <?php } ?>
    <tfoot>
    <tr>
      <th colspan="6"></th>
      <th><span id="total_1"></span></th>
      <th><?php echo $simbolo; ?><span id="total_2"></span></th>
      <th><?php echo $simbolo; ?><span id="total_3"></span></th>
      <th><?php echo $simbolo; ?><span id="total_4"></span></th>
      <th><?php echo $simbolo; ?><span id="total_5"></span></th>
      <th></th>
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
########################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ##########################
?>


<!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
<script src="assets/plugins/datatables/datatables.js"></script>
<script src="assets/plugins/datatables/sum().js"></script>
<script>
$(document).ready(function() {
    $('#html5-extension, #default-ordering').DataTable({
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
    "lengthMenu": [15, 40, 80, 150],
    "pageLength": 15,
        drawCallback: function(){ 
            $('.dataTables_paginate > .pagination').addClass('pagination-style-13 pagination-bordered mb-5');
            CalcularTotalesDatatable();
        }/*,
        footerCallback: function(row, data, start, end, display){
            total = this.api()
            .column(6)//numero de columna a sumar
            //.column(1, {page: 'current'})//para sumar solo la pagina actual
            .data()
            .reduce(function (a, b) {
                return parseInt(a) + parseInt(b);
            }, 0);
            $(this.api().column(6).footer()).html(total);
        }*/    
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

        /*########## BLOQUE #6 /*##########*/
        let TotalSuma6  = 0;
        $(".suma_6").each(function(){
            TotalSuma6  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_6").text(Separador(TotalSuma6.toFixed(2)));
        /*########## BLOQUE #6 /*##########*/

        /*########## BLOQUE #7 /*##########*/
        let TotalSuma7  = 0;
        $(".suma_7").each(function(){
            TotalSuma7  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_7").text(Separador(TotalSuma7.toFixed(2)));
        /*########## BLOQUE #7 /*##########*/

        /*########## BLOQUE #8 /*##########*/
        let TotalSuma8  = 0;
        $(".suma_8").each(function(){
            TotalSuma8  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_8").text(Separador(TotalSuma8.toFixed(2)));
        /*########## BLOQUE #8 /*##########*/

        /*########## BLOQUE #9 /*##########*/
        let TotalSuma9  = 0;
        $(".suma_9").each(function(){
            TotalSuma9  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_9").text(Separador(TotalSuma9.toFixed(2)));
        /*########## BLOQUE #9 /*##########*/

        /*########## BLOQUE #10 /*##########*/
        let TotalSuma10  = 0;
        $(".suma_10").each(function(){
            TotalSuma10  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_10").text(Separador(TotalSuma10.toFixed(2)));
        /*########## BLOQUE #7 /*##########*/

        /*########## BLOQUE #11 /*##########*/
        let TotalSuma11  = 0;
        $(".suma_11").each(function(){
            TotalSuma11  += parseFloat($(this).html().replace(/,/g, ''), 10) || 0;
        });
        $("#total_11").text(Separador(TotalSuma11.toFixed(2)));
        /*########## BLOQUE #11 /*##########*/
    };
});
</script>
<!-- END PAGE LEVEL CUSTOM SCRIPTS -->