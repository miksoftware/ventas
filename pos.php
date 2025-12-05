<?php
require_once('class/class.php');
$accesos = ['administradorS', 'secretaria', 'cajero'];
validarAccesos($accesos) or die();

###################### DETALLE DE SESSION SUCURSAL ######################
$bod         = new Login();
$bod         = $bod->SucursalesSessionPorId();
$simbolo     = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$bod[0]['simbolo']."</strong>");
$mostrar_pos = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "0" : $bod[0]['mostrar_pos']);
$ticket_general = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "8" : $bod[0]['ticket_general']);
###################### DETALLE DE SESSION SUCURSAL ######################

###################### DETALLE DE IMPUESTO ######################
$imp           = new Login();
$imp           = $imp->ImpuestosPorId();
$NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
###################### DETALLE DE IMPUESTO ######################

$cambiomoneda = new Login();
$cambiomoneda = $cambiomoneda->MonedaProductoId(); 
$montocambio = ($cambiomoneda == "" ? "0.00" : $cambiomoneda[0]['montocambio']);

$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario();

$tra = new Login();
$muestra_factura = 0; 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="apertura")
{
    $reg = $tra->RegistrarArqueoCaja();
    exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
    $reg = $tra->RegistrarVentas();
    exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevocliente")
{
    $reg = $tra->RegistrarClientes();
    exit;
} 
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="cobrarfactura")
{
    $reg = $tra->CobrarFactura();
    exit;
}         
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Daniel David Chavarro">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>

    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/datatables.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/dt-global_style.css">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <!--Bootstrap Horizontal CSS -->
    <link href="assets/css/bootstrap-horizon.css" rel="stylesheet">
    <!--Detalles Productos CSS -->
    <link href="assets/css/style_all.css" rel="stylesheet">
    <!-- color alert -->
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">
    <!-- checkbox -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body onLoad="muestraReloj(); getTime(); document.getElementById('search_producto_barra').focus(); MostrarFacturasPendientes();" class="fix-header">
    
   <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">                                     
    
    <!--############################## MODAL PARA LISTAR DETALLE FACTURA PENDIENTE ######################################-->
    <div id="myModalDetalleFactura" class="modal fade" tabindex="-1" role="dialog" style="overflow-y: scroll;" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Facturas Pendientes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                <div id="muestradetallesfacturapendiente"></div> 

                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--############################## MODAL PARA LISTAR DETALLE FACTURA PENDIENTE ######################################-->

    <!--############################## MODAL PARA COBRAR FACTURA PENDIENTE ######################################-->
    <!-- sample modal content -->
    <div id="myModalCobrarFactura" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                 
                <div id="loadcampos2">
                <?php if($arqueo != ""){ ?>
                  <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
                <?php } ?>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>

                <form class="form form-material" name="procesarfactura" id="procesarfactura" action="#">

                <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Búsqueda de Cliente: </label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i></button>
                            </div>
                            <input type="hidden" name="proceso" id="proceso" value="cobrarfactura">
                            <input type="hidden" name="formulario" id="formulario" value="pos">
                            <input type="hidden" name="idpendiente" id="idpendiente">
                            <input type="hidden" name="codpendiente" id="codpendiente">
                            <input type="hidden" name="codsucursal2" id="codsucursal2">
                            <input type="hidden" name="codcliente2" id="codcliente2">
                            <input type="hidden" name="nrodocumento2" id="nrodocumento2" value="0">
                            <input type="hidden" name="exonerado2" id="exonerado2" value="0">
                            <input type="hidden" name="limitecredito2" id="limitecredito2" value="0.00"/>
                            <input type="hidden" name="creditoinicial2" id="creditoinicial2" value="0.00">
                            <input type="hidden" name="abonototal2" id="abonototal2" value="0.00">
                            <input type="hidden" name="creditodisponible2" id="creditodisponible2" value="0.00">
                            <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
                            <input type="hidden" name="txtsubtotal22" id="txtsubtotal22" value="0.00"/>
                            <input type="hidden" name="txtexonerado2" id="txtexonerado2" value="0.00"/>
                            <input type="hidden" name="txtexonerado22" id="txtexonerado22" value="0.00"/>
                            <input type="hidden" name="txtexento2" id="txtexento2" value="0.00"/>
                            <input type="hidden" name="txtexento22" id="txtexento22" value="0.00"/>
                            <input type="hidden" name="txtsubtotaliva2" id="txtsubtotaliva2" value="0.00"/>
                            <input type="hidden" name="txtsubtotaliva22" id="txtsubtotaliva22" value="0.00"/>
                            <input type="hidden" name="iva2" id="iva2" value="0.00">
                            <input type="hidden" name="txtIva2" id="txtIva2" value="0.00"/>
                            <input type="hidden" name="txtIva22" id="txtIva22" value="0.00"/>
                            <input type="hidden" name="txtdescontado2" id="txtdescontado2" value="0.00"/>
                            <input type="hidden" name="descuento2" id="descuento2" value="0.00"/>
                            <input type="hidden" name="txtDescuento2" id="txtDescuento2" value="0.00"/>
                            <input type="hidden" name="txtTotal2" id="txtTotal2" value="0.00"/>
                            <input type="hidden" name="txtPagado2" id="txtPagado2" value="0.00"/>
                            <input type="hidden" name="txtTotalCompra2" id="txtTotalCompra2" value="0.00"/>
                            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_cliente" id="search_cliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para Búsqueda de Cliente" autocomplete="off"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total a Pagar</h4>
                       <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte2" name="TextImporte2">0.00</label></h3>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total Recibido</h4>
                       <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado2" name="TextPagado2">0.00</label></h3>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total Cambio</h4>
                       <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio2" name="TextCambio2">0.00</label></h3>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-8">
                       <h4 class="mb-0 font-light">Nombre del Cliente</h4>
                       <h4 class="mb-0 font-medium"> <label id="TextCliente2" name="TextCliente2">Consumidor Final</label></h4>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Limite de Crédito</h4>
                       <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito2" name="TextCredito2">0.00</label></h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                            <div class="n-chk">
                                <?php if($ticket_general == 5){ ?>
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento2" id="notaventa11" value="NOTA_VENTA_5" checked="checked">
                                  <span class="new-control-indicator"></span>NOTA VENTA (58MM)
                                </label>
                                <?php } elseif($ticket_general == 8){ ?>
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento2" id="notaventa22" value="NOTA_VENTA_8" checked="checked">
                                  <span class="new-control-indicator"></span>NOTA VENTA (80MM)
                                </label>
                                <?php } ?>

                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento2" id="boleta2" value="BOLETA_A4">
                                  <span class="new-control-indicator"></span>BOLETA
                                </label>
                            </div>

                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento2" id="factura2" value="FACTURA_A4">
                                  <span class="new-control-indicator"></span>FACTURA
                                </label>
                                
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento2" id="guia2" value="GUIA_REMISION">
                                  <span class="new-control-indicator"></span>GUIA REMISIÓN
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipopago2" id="contado2" value="CONTADO" checked="checked" onClick="CargaCondicionesPagos2()">
                                  <span class="new-control-indicator"></span>CONTADO
                                </label>
                            </div>

                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipopago2" id="credito2" value="CREDITO" onClick="CargaCondicionesPagos2()">
                                  <span class="new-control-indicator"></span>CRÉDITO
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="montodevuelto2" id="montodevuelto2" value="0.00"/>

            <div id="muestra_condiciones2"><!-- IF CONDICION PAGO -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                            <i class="fa fa-bars form-control-feedback"></i>
                            <select style="color:#000;font-weight:bold;" name="pagos2[0][codmediopago]" id="codmediopago2" class="form-control" title="Seleccione Forma Pago" required aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $medio = new Login();
                            $medio = $medio->ListarMediosPagos();
                            if($medio==""){ 
                                echo "";
                            } else {
                            for ($i = 0; $i < sizeof($medio); $i++) { ?>
                            <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if ( ! (strcmp('1',
                                    $medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago']; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">Monto Recibido: <span class="symbol required"></span></label>
                        <div class="input-group">
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos2[0][montopagado]" id="montopagado2" onKeyUp="CalculoDevolucion2();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off" value="0.00">
                            <div class="input-group-append">
                                <div class="btn-group" data-bs-toggle="buttons">
                                    <button type="button" class="btn btn-info waves-effect waves-light" data-placement="left" title="Agregar" data-original-title="" onclick="addRowPago2()"><span class="fa fa-plus"></span></button>
                                </div>
                            </div><!---->
                        </div>
                    </div>
                </div>

            </div><!-- END CONDICION PAGO -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Observaciones: </label>
                            <textarea class="form-control" type="text" name="observaciones2" id="observaciones2" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1" required="" aria-required="true"></textarea>
                            <i class="fa fa-comments form-control-feedback"></i> 
                        </div>
                    </div>
                </div>
                 
            </div>

            <div class="modal-footer">
                <button type="submit" name="submit_pendiente" id="submit_pendiente" class="btn btn-primary"><span class="fa fa-print"></span> Facturar e Imprimir</button>
                <button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar </button>
            </div>

            </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <!--############################## MODAL PARA COBRAR FACTURA PENDIENTE ######################################-->

    <!--############################## MODAL PARA AGREGAR IMEI EN DETALLE ##############################-->
    <!-- sample modal content -->
    <div id="myModalImei" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Agregar Imei</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>

            <form class="form form-material" method="post" action="#" name="agregaimei" id="agregaimei">
                    
                <div class="modal-body">

                <div id="agrega_detalle_imei"></div><!-- detalle observacion -->

                </div>

            </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA AGREGAR IMEI EN DETALLE ##############################-->

    <!--############################## MODAL PARA AGREGAR PRECIO VENTA EN DETALLE ##############################-->
    <!-- sample modal content -->
    <div id="myModalPrecio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Actualizar Detalle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>

            <form class="form form-material" method="post" action="#" name="agregaprecio" id="agregaprecio">
                    
                <div class="modal-body">

                <div id="agrega_detalle_precio"></div><!-- detalle observacion -->

                </div>

            </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA AGREGAR PRECIO VENTA EN DETALLE ##############################-->

    <!--############################## MODAL PARA REGISTRO DE ARQUEO ######################################-->
    <!-- sample modal content -->
    <div id="myModalArqueo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Arqueos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                
            <form class="form form-material" method="post" action="#" name="savearqueo" id="savearqueo">
            
            <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Caja: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codcaja" id="codcaja" class='form-control' required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $caja = new Login();
                            $caja = $caja->ListarCajas();
                            if($caja==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($caja);$i++){
                            ?>
                        <option value="<?php echo encrypt($caja[$i]['codcaja']); ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>         
                        <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label class="control-label">Hora de Apertura: <span class="symbol required"></span></label>
                        <input type="hidden" name="proceso" id="proceso" value="apertura"/>
                        <input type="hidden" name="formulario" id="formulario" value="pos"/>
                        <input type="hidden" name="codarqueo" id="codarqueo">
                        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                        <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Hora de Apertura" autocomplete="off" readonly="" aria-required="true"/> 
                        <i class="fa fa-clock-o form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group has-feedback">
                        <label class="control-label">Monto Inicial: <span class="symbol required"></span></label>
                        <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="montoinicial" id="montoinicial" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Monto Inicial" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-tint form-control-feedback"></i> 
                    </div>
                </div>
            </div>
        </div>

                <div class="modal-footer">
                    <button type="submit" name="btn-arqueo" id="btn-arqueo" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                    <button class="btn btn-dark" type="button" onclick="
                    document.getElementById('proceso').value = 'apertura',
                    document.getElementById('codsucursal').value = '',
                    document.getElementById('codcaja').value = '',
                    document.getElementById('codarqueo').value = '',
                    document.getElementById('fecharegistro').value = '',
                    document.getElementById('montoinicial').value = ''
                    " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <!--############################## MODAL PARA REGISTRO DE ARQUEO ######################################-->   

    <!--############################## MODAL PARA REGISTRO DE NUEVO CLIENTE ######################################-->
    <!-- sample modal content -->
    <div id="myModalCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Cientes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                
            <form class="form form-material" method="post" action="#" name="savecliente" id="savecliente"> 

                    
            <div class="modal-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tipo de Cliente: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="tipocliente" id="tipocliente" class="form-control" onChange="CargaTipoCliente(this.form.tipocliente.value);" required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <option value="NATURAL">NATURAL</option>
                        <option value="JURIDICO">JURIDICO</option>
                        <option value="CONTRIBUYENTE EXONERADO">CONTRIBUYENTE EXONERADO</option>
                        </select> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tipo de Documento: </label>
                        <i class="fa fa-bars form-control-feedback"></i> 
                        <select style="color:#000;font-weight:bold;" name="documcliente" id="documcliente" class='form-control' required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $documento = new Login();
                            $documento = $documento->ListarDocumentos();
                            if($documento==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($documento);$i++){ ?>
                            <option value="<?php echo $documento[$i]['coddocumento']; ?>"><?php echo $documento[$i]['documento']; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                            <input type="hidden" name="proceso" id="proceso" value="nuevocliente"/>
                            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                            <input type="hidden" name="formulario" id="formulario" value="pos"/>
                            <input type="text" class="form-control" name="dnicliente" id="dnicliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-bolt form-control-feedback"></i> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Cliente: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="nomcliente" id="nomcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Cliente" disabled="" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Razón Social: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="razoncliente" id="razoncliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Razón Social" disabled="" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Giro de Cliente: </label>
                            <input type="text" class="form-control" name="girocliente" id="girocliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Giro de Cliente" disabled="" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nº de Teléfono: </label>
                            <input type="text" class="form-control phone-inputmask" name="tlfcliente" id="tlfcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-phone form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Correo de Cliente: </label>
                            <input type="text" class="form-control" name="emailcliente" id="emailcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-envelope-o form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Provincia: </label>
                            <i class="fa fa-bars form-control-feedback"></i> 
                            <select style="color:#000;font-weight:bold;" name="id_provincia" id="id_provincia" onChange="CargaDepartamentos(this.form.id_provincia.value);" class='form-control' required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $provincia = new Login();
                            $provincia = $provincia->ListarProvincias();
                            if($provincia==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($provincia);$i++){ ?>
                            <option value="<?php echo $provincia[$i]['id_provincia']; ?>"><?php echo $provincia[$i]['provincia']; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Departamento: </label>
                            <i class="fa fa-bars form-control-feedback"></i>
                            <select style="color:#000;font-weight:bold;" class="form-control" id="id_departamento" name="id_departamento" required="" aria-required="true">
                                <option value=""> -- SIN RESULTADOS -- </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="direccliente" id="direccliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección Domiciliaria" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-map-marker form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Limite de Crédito: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="limitecredito" id="limitecredito" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Limite de Crédito" value="0.00" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-usd form-control-feedback"></i>
                        </div>
                    </div>
                </div>
            </div>

                <div class="modal-footer">
                    <button type="submit" name="btn-cliente" id="btn-cliente" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                    <button class="btn btn-dark" type="button" onclick="ResetCliente2()" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <!--############################## MODAL PARA REGISTRO DE NUEVO CLIENTE ######################################-->

        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->
   

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Ventas</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">POS Terminal</li>
                                <li class="breadcrumb-item active" aria-current="page">POS</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="page-content container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
 
<?php if($mostrar_pos == 1){ ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> POS Terminal </h4>
            </div>

        <div id="save">
        <!-- error will be shown here ! -->
        </div>
            
        <div class="form-body">

        <div class="card-body">

    <div class="row">

        <!-- .col -->
        <div class="col-md-6">

        <div class="customizer-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"> 
                    <a class="nav-link active text-dark font-20" data-toggle="tab" href="#pills-form1" role="tab"><span class="hidden-sm-up"><i class="font-20 mdi mdi-cart-plus"></i> Nueva Venta</span></a> 
                </li>
                <li class="nav-item" role="presentation"> 
                    <a class="nav-link text-dark font-20" data-toggle="tab" href="#pills-form2" onclick="MostrarFacturasPendientes();" role="tab"><span class="hidden-sm-up"><i class="font-20 mdi mdi-file-multiple"></i> Facturas Pendientes</span></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" id="pills-tabContent">
               
            <!-- Tab 1 -->
            <div class="tab-pane fade p-3 show active" id="pills-form1" role="tabpanel" aria-labelledby="pills-home-tab">


            <form class="form form-horizontal" method="post" action="#" name="saveposopcion1" id="saveposopcion1">

            <!--############################## MODAL PARA COBRO ######################################-->
            <div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                         
                        <div id="loadcampos">
                        <?php if($arqueo != ""){ ?>
                          <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
                        <?php } ?>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                        </div>

                        <div class="modal-body">
                        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                        <input type="hidden" name="pagado" id="pagado" value="0.00">
                        <input type="hidden" name="creditoinicial" id="creditoinicial" value="0.00">
                        <input type="hidden" name="creditodisponible" id="creditodisponible" value="0.00">
                        <input type="hidden" name="abonototal" id="abonototal" value="0.00">
                        <input type="hidden" name="proceso" id="proceso" value="save">
                        <input type="hidden" name="tipoproceso" id="tipoproceso" value="<?php echo '1'; ?>">

                        <div class="row">
                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Total a Pagar</h4>
                               <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte" name="TextImporte">0.00</label></h3>
                            </div>

                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Total Recibido</h4>
                               <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado" name="TextPagado">0.00</label></h3>
                            </div>

                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Total Cambio</h4>
                               <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio">0.00</label></h3>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-8">
                               <h4 class="mb-0 font-light">Nombre del Cliente</h4>
                               <h4 class="mb-0 font-medium"> <label id="TextCliente" name="TextCliente">Consumidor Final</label></h4>
                            </div>

                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Limite de Crédito</h4>
                               <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito" name="TextCredito">0.00</label></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                                    <div class="n-chk">
                                        <?php if($ticket_general == 5){ ?>
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="notaventa1" value="NOTA_VENTA_5" checked="checked">
                                          <span class="new-control-indicator"></span>NOTA VENTA (58MM)
                                        </label>
                                        <?php } elseif($ticket_general == 8){ ?>
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="notaventa2" value="NOTA_VENTA_8" checked="checked">
                                          <span class="new-control-indicator"></span>NOTA VENTA (80MM)
                                        </label>
                                        <?php } ?>

                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="boleta" value="BOLETA_A4">
                                          <span class="new-control-indicator"></span>BOLETA
                                        </label>
                                    </div>

                                    <div class="n-chk">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="factura" value="FACTURA_A4">
                                          <span class="new-control-indicator"></span>FACTURA
                                        </label>
                                        
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="guia" value="GUIA_REMISION">
                                          <span class="new-control-indicator"></span>GUIA REMISIÓN
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                                    <div class="n-chk">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipopago" id="contado" value="CONTADO" checked="checked" onClick="CargaCondicionesPagos()">
                                          <span class="new-control-indicator"></span>CONTADO
                                        </label>
                                    </div>

                                    <div class="n-chk">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipopago" id="credito" value="CREDITO" onClick="CargaCondicionesPagos()">
                                          <span class="new-control-indicator"></span>CRÉDITO
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"/>

                        <div id="muestra_condiciones"><!-- IF CONDICION PAGO -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback"> 
                                    <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select style="color:#000;font-weight:bold;" name="pagos[0][codmediopago]" id="codmediopago" class="form-control" title="Seleccione Forma Pago" required aria-required="true">
                                    <option value=""> -- SELECCIONE -- </option>
                                    <?php
                                    $medio = new Login();
                                    $medio = $medio->ListarMediosPagos();
                                    if($medio==""){ 
                                        echo "";
                                    } else {
                                    for ($i = 0; $i < sizeof($medio); $i++) { ?>
                                    <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if ( ! (strcmp('1',
                                            $medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago']; ?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Monto Recibido: <span class="symbol required"></span></label>
                                <div class="input-group">
                                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[0][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off" value="0.00">
                                    <div class="input-group-append">
                                        <div class="btn-group" data-bs-toggle="buttons">
                                            <button type="button" class="btn btn-info waves-effect waves-light" data-placement="left" title="Agregar" data-original-title="" onclick="addRowPago()"><span class="fa fa-plus"></span></button>
                                        </div>
                                    </div><!---->
                                </div>
                            </div>
                        </div>

                        </div><!-- END CONDICION PAGO -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Observaciones: </label>
                                    <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1" required="" aria-required="true"></textarea>
                                    <i class="fa fa-comments form-control-feedback"></i> 
                                </div>
                            </div>
                        </div>
                             
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="submit_cobrar" id="submit_cobrar" class="btn btn-primary"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>
                            <button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar (F10)</button>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!--############################## MODAL PARA COBRO ######################################-->

        <?php if($arqueo==""){ ?>

        <div id="muestra_mensaje" class='alert alert-danger text-center'>
        <span class='fa fa-info-circle'></span> POR FAVOR REALICE LA APERTURA DE CAJA PARA PROCESAR VENTAS
        </div>

        <?php } ?>

        <input type="hidden" name="idproducto" id="idproducto">
        <input type="hidden" name="codproducto" id="codproducto">
        <input type="hidden" name="producto" id="producto">
        <input type="hidden" name="descripcion" id="descripcion">
        <input type="hidden" name="opcionimei" id="opcionimei">
        <input type="hidden" name="imei" id="imei">
        <input type="hidden" name="condicion" id="condicion">
        <input type="hidden" name="codmarca" id="codmarca">
        <input type="hidden" name="marcas" id="marcas">
        <input type="hidden" name="codmodelo" id="codmodelo">
        <input type="hidden" name="modelos" id="modelos">
        <input type="hidden" name="codpresentacion" id="codpresentacion">
        <input type="hidden" name="presentacion" id="presentacion">
        <input type="hidden" name="codcolor" id="codcolor">
        <input type="hidden" name="color" id="color">
        <input type="hidden" name="preciocompra" id="preciocompra"> 
        <input type="hidden" name="precioventa" id="precioventa">
        <input type="hidden" name="precioconiva" id="precioconiva">
        <input type="hidden" name="posicionimpuesto" id="posicionimpuesto">
        <input type="hidden" name="tipoimpuesto" id="tipoimpuesto">
        <input type="hidden" name="ivaproducto" id="ivaproducto">
        <input type="hidden" name="descproducto" id="descproducto">
        <input type="hidden" name="cantidad" id="cantidad" value="1">
        <input type="hidden" name="existencia" id="existencia">
        <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">

        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Búsqueda de Cliente: </label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
                    </div>
                    <input type="hidden" name="codcliente" id="codcliente" value="0">
                    <input type="hidden" name="nrodocumento" id="nrodocumento" value="0">
                    <input type="hidden" name="exonerado" id="exonerado" value="0">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" autocomplete="off" value="CONSUMIDOR FINAL"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Búsqueda por Lector de Barra: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_barra" id="search_producto_barra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra o Producto">
                    <i class="fa fa-barcode form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-6"> 
                <div class="form-group has-feedback"> 
                  <label class="control-label">Búsqueda por Criterio: <span class="symbol required"></span></label>
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto" id="search_producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="table-responsive m-t-10 scroll">
            <table id="carrito" class="table">
                <thead>
                </thead>
                <tbody>
                    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
                        <td class="text-center" colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
            </table> 
        </div>

        <div class="table-responsive m-t-10">

        <table id="carritototal" class="table-responsive">
        <tr>
        <td></td>
        <td width="250">
        <h5 class="text-left">
          <label>Descontado:</label>
        </h5>    </td>
        <td width="250">
        <h5 class="text-left"><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>    </td>
        <td width="250">
        <h5 class="text-left">
          <label>Subtotal:</label>
        </h5>    </td>
        <td width="250">
        <h5 class="text-right"><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>    </td>
        <td></td>
        </tr>

        <tr>
        <td></td>
        <td>
        <h5 class="text-left">
          <label>Exonerado:</label></h5>    </td>
        <td>
        <h5 class="text-left"><?php echo $simbolo; ?><label id="lblexonerado" name="lblexonerado">0.00</label></h5>
        <td width="180">
        <h5 class="text-left">
          <label>Exento:</label>
        </h5>    </td>
        <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lblexento" name="lblexento">0.00</label></h5>    </td>
        <td width="10"></td>      
        </tr>
        
        <tr>
        <td></td>
        <td>
        <h5 class="text-left">
          <label>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%):</label></h5>    </td>
        <td>
        <h5 class="text-left"><?php echo $simbolo; ?><label id="lblsubtotaliva" name="lblsubtotaliva">0.00</label></h5>    </td>
        <td width="180">
        <h5 class="text-left">
          <label><?php echo $NomImpuesto; ?> (<?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%):</label>
        </h5>    </td>
        <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>    </td>
        <td width="10"></td>      
        </tr>

        <tr>
        <td></td>
        <td colspan="2">
        <h5 class="text-left"><label>Descuento Global :</label> <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:28px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>"> %</h5>    </td>
        <td colspan="2">
        <h5 class="text-right"><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5></td>
        <td width="10"></td>
        </tr>
        <tr>
        <td></td>
        <td colspan="2"><h4><span class="text-right text-dark alert-link">TOTAL A PAGAR EN :</span> <?php echo $simbolo; ?></h4></td>
        <td colspan="2"><h4 class="text-right"><label id="lbltotal" name="lbltotal">0.00</label></h4></td>
        <td></td>
        </tr>
        <input type="hidden" name="formulario" id="formulario" value="pos"/>
        <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
        <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
        <input type="hidden" name="txtexonerado" id="txtexonerado" value="0.00"/>
        <input type="hidden" name="txtexonerado2" id="txtexonerado2" value="0.00"/>
        <input type="hidden" name="txtexento" id="txtexento" value="0.00"/>
        <input type="hidden" name="txtexento2" id="txtexento2" value="0.00"/>
        <input type="hidden" name="txtsubtotaliva" id="txtsubtotaliva" value="0.00"/>
        <input type="hidden" name="txtsubtotaliva2" id="txtsubtotaliva2" value="0.00"/>
        <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
        <input type="hidden" name="txtIva2" id="txtIva2" value="0.00"/>
        <input type="hidden" name="iva" id="iva" value="<?php echo number_format($ValorImpuesto, 2, '.', ''); ?>">
        <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
        <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
        <input type="hidden" name="txtPagado" id="txtPagado" value="0.00"/>
        <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/></td>
        </table>
        </div>

        <div class="pull-left">
    <button type="button" id="buttonapertura" class="btn btn-info waves-effect waves-light" data-placement="left" title="Aperturar Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalArqueo"><span class="fa fa-desktop"></span> Aperturar Caja</button>
        </div>

        <div class="pull-right">
    <button type="submit" name="submit_guardar" id="submit_guardar" class="btn btn-success" disabled="" onclick="AgregaProceso('<?php echo '2'; ?>')"><span class="fa fa-save"></span> Guardar</button>
    <button type="button" id="buttonpago" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Cobrar Venta" data-original-title="" data-href="#" disabled="" data-toggle="modal" data-target="#myModalPago" onclick="AgregaProceso('<?php echo '1'; ?>')"><span class="fa fa-calculator"></span> Cobrar (F2)</button>

    <button class="btn btn-dark" type="button" id="vaciar"><span class="fa fa-trash-o"></span> Limpiar (F4)</button>
        </div> 


            </form>


            </div>
            <!-- End Tab 1 -->


            <!-- Tab 2 -->
            <div class="tab-pane fade p-3 show" id="pills-form2" role="tabpanel" aria-labelledby="pills-profile-tab">

            <div id="muestrafacturaspendientes"></div>
        
            </div>
            <!-- End Tab 2 -->

            </div>
        </div>
       
        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">

        <span class="pull-right">

        <button type="button" class="btn btn-info waves-effect waves-light" style="cursor: pointer;" title="Productos" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> </button>
                        
        <button type="button" class="btn btn-success waves-effect waves-light" style="cursor: pointer;" title="Combos" onClick="MostrarCombos();"><span class="fa fa-archive"></span> </button>
        
        </span>

            <div id="loading"></div>

        </div>
       <!-- /.col -->
                                   
    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Row -->

<?php } elseif($mostrar_pos == 2){ ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> POS Terminal</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>
            
            <div class="form-body">

              <div class="card-body">

    <form class="form form-material" method="post" action="#" name="saveposopcion2" id="saveposopcion2"> 

    <div class="row">

        <!-- .col -->
        <div class="col-md-8">

        <div class="customizer-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"> 
                    <a class="nav-link active text-dark font-20" data-toggle="tab" href="#pills-form1" role="tab"><span class="hidden-sm-up"><i class="font-20 mdi mdi-cart-plus"></i> Nueva Venta</span></a> 
                </li>
                <li class="nav-item" role="presentation"> 
                    <a class="nav-link text-dark font-20" data-toggle="tab" href="#pills-form2" onclick="MostrarFacturasPendientes();" role="tab"><span class="hidden-sm-up"><i class="font-20 mdi mdi-file-multiple"></i> Facturas Pendientes</span></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content" id="pills-tabContent">
               
            <!-- Tab 1 -->
            <div class="tab-pane fade p-3 show active" id="pills-form1" role="tabpanel" aria-labelledby="pills-home-tab">

            <!--############################## MODAL PARA COBRO ######################################-->
            <div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                         
                        <div id="loadcampos">
                        <?php if($arqueo != ""){ ?>
                          <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
                        <?php } ?>
                        </div>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                        </div>

                        <div class="modal-body">
                        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                        <input type="hidden" name="pagado" id="pagado" value="0.00">
                        <input type="hidden" name="creditoinicial" id="creditoinicial" value="0.00">
                        <input type="hidden" name="creditodisponible" id="creditodisponible" value="0.00">
                        <input type="hidden" name="abonototal" id="abonototal" value="0.00">
                        <input type="hidden" name="proceso" id="proceso" value="save">
                        <input type="hidden" name="tipoproceso" id="tipoproceso" value="<?php echo '1'; ?>">

                        <div class="row">
                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Total a Pagar</h4>
                               <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte" name="TextImporte">0.00</label></h3>
                            </div>

                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Total Recibido</h4>
                               <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado" name="TextPagado">0.00</label></h3>
                            </div>

                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Total Cambio</h4>
                               <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio">0.00</label></h3>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-8">
                               <h4 class="mb-0 font-light">Nombre del Cliente</h4>
                               <h4 class="mb-0 font-medium"> <label id="TextCliente" name="TextCliente">Consumidor Final</label></h4>
                            </div>

                            <div class="col-md-4">
                               <h4 class="mb-0 font-light">Limite de Crédito</h4>
                               <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito" name="TextCredito">0.00</label></h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                                    <div class="n-chk">
                                        <?php if($ticket_general == 5){ ?>
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="notaventa1" value="NOTA_VENTA_5" checked="checked">
                                          <span class="new-control-indicator"></span>NOTA VENTA (58MM)
                                        </label>
                                        <?php } elseif($ticket_general == 8){ ?>
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="notaventa2" value="NOTA_VENTA_8" checked="checked">
                                          <span class="new-control-indicator"></span>NOTA VENTA (80MM)
                                        </label>
                                        <?php } ?>

                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="boleta" value="BOLETA_A4">
                                          <span class="new-control-indicator"></span>BOLETA
                                        </label>
                                    </div>

                                    <div class="n-chk">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="factura" value="FACTURA_A4">
                                          <span class="new-control-indicator"></span>FACTURA
                                        </label>
                                        
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipodocumento" id="guia" value="GUIA_REMISION">
                                          <span class="new-control-indicator"></span>GUIA REMISIÓN
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                                    <div class="n-chk">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipopago" id="contado" value="CONTADO" checked="checked" onClick="CargaCondicionesPagos()">
                                          <span class="new-control-indicator"></span>CONTADO
                                        </label>
                                    </div>

                                    <div class="n-chk">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                          <input type="radio" class="new-control-input" name="tipopago" id="credito" value="CREDITO" onClick="CargaCondicionesPagos()">
                                          <span class="new-control-indicator"></span>CRÉDITO
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"/>

                        <div id="muestra_condiciones"><!-- IF CONDICION PAGO -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback"> 
                                    <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select style="color:#000;font-weight:bold;" name="pagos[0][codmediopago]" id="codmediopago" class="form-control" title="Seleccione Forma Pago" required aria-required="true">
                                    <option value=""> -- SELECCIONE -- </option>
                                    <?php
                                    $medio = new Login();
                                    $medio = $medio->ListarMediosPagos();
                                    if($medio==""){ 
                                        echo "";
                                    } else {
                                    for ($i = 0; $i < sizeof($medio); $i++) { ?>
                                    <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if ( ! (strcmp('1',
                                            $medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago']; ?></option>
                                    <?php } } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Monto Recibido: <span class="symbol required"></span></label>
                                <div class="input-group">
                                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[0][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off" value="0.00">
                                    <div class="input-group-append">
                                        <div class="btn-group" data-bs-toggle="buttons">
                                            <button type="button" class="btn btn-info waves-effect waves-light" data-placement="left" title="Agregar" data-original-title="" onclick="addRowPago()"><span class="fa fa-plus"></span></button>
                                        </div>
                                    </div><!---->
                                </div>
                            </div>
                        </div>

                        </div><!-- END CONDICION PAGO -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Observaciones: </label>
                                    <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1" required="" aria-required="true"></textarea>
                                    <i class="fa fa-comments form-control-feedback"></i> 
                                </div>
                            </div>
                        </div>
                             
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="submit_cobrar" id="submit_cobrar" class="btn btn-primary"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button>
                            <button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar (F10)</button>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!--############################## MODAL PARA COBRO ######################################-->

            <?php if($arqueo==""){ ?>
            <div id="muestra_mensaje" class='alert alert-danger text-center'>
            <span class='fa fa-info-circle'></span> POR FAVOR REALICE LA APERTURA DE CAJA PARA PROCESAR VENTAS
            </div>
            <?php } ?>

            <input type="hidden" name="idproducto" id="idproducto">
            <input type="hidden" name="codproducto" id="codproducto">
            <input type="hidden" name="producto" id="producto">
            <input type="hidden" name="descripcion" id="descripcion">
            <input type="hidden" name="opcionimei" id="opcionimei">
            <input type="hidden" name="imei" id="imei">
            <input type="hidden" name="condicion" id="condicion">
            <input type="hidden" name="codmarca" id="codmarca">
            <input type="hidden" name="marcas" id="marcas">
            <input type="hidden" name="codmodelo" id="codmodelo">
            <input type="hidden" name="modelos" id="modelos">
            <input type="hidden" name="codpresentacion" id="codpresentacion">
            <input type="hidden" name="presentacion" id="presentacion">
            <input type="hidden" name="codcolor" id="codcolor">
            <input type="hidden" name="color" id="color">
            <input type="hidden" name="preciocompra" id="preciocompra"> 
            <input type="hidden" name="precioventa" id="precioventa">
            <input type="hidden" name="precioconiva" id="precioconiva">
            <input type="hidden" name="posicionimpuesto" id="posicionimpuesto">
            <input type="hidden" name="tipoimpuesto" id="tipoimpuesto">
            <input type="hidden" name="ivaproducto" id="ivaproducto">
            <input type="hidden" name="descproducto" id="descproducto">
            <input type="hidden" name="cantidad" id="cantidad" value="1">
            <input type="hidden" name="existencia" id="existencia">
            <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">

            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Búsqueda por Lector de Barra: </label>
                        <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_barra" id="search_producto_barra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra o Producto">
                        <i class="fa fa-barcode form-control-feedback"></i> 
                    </div> 
                </div>

                <div class="col-md-6"> 
                    <div class="form-group has-feedback"> 
                      <label class="control-label">Búsqueda por Criterio: <span class="symbol required"></span></label>
                      <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto" id="search_producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                      <i class="fa fa-search form-control-feedback"></i> 
                    </div> 
                </div>
            </div>

            <div class="table-responsive m-t-10" style="overflow:scroll;scrollbar-width:thin;white-space:nowrap;height:400px;">
                <table id="carrito" class="table border display">
                    <thead>
                    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                        <th>Cantidad</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Descuento %</th>
                        <th><?php echo $NomImpuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
                            <td class="text-center" colspan=7><h4>NO HAY DETALLES AGREGADOS</h4></td>
                        </tr>
                    </tbody>
                </table> 
            </div>

            </div>
            <!-- End Tab 1 -->

            <!-- Tab 2 -->
            <div class="tab-pane fade p-3 show" id="pills-form2" role="tabpanel" aria-labelledby="pills-profile-tab">

            <div id="muestrafacturaspendientes"></div>
        
            </div>
            <!-- End Tab 2 -->

            </div>
        </div>

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-4">

        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-file"></i> Detalle de Factura</h3><hr>

        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Búsqueda de Cliente: </label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
                    </div>
                    <input type="hidden" name="codcliente" id="codcliente" value="0">
                    <input type="hidden" name="nrodocumento" id="nrodocumento" value="0">
                    <input type="hidden" name="exonerado" id="exonerado" value="0">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" autocomplete="off" value="CONSUMIDOR FINAL"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback2">
                    <label class="control-label">Observaciones: </label>
                    <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="2" required="" aria-required="true"></textarea>
                    <i class="fa fa-comments form-control-feedback2"></i> 
                </div>
            </div>
        </div>

        <hr>

        <div class="table-responsive m-t-10">

        <table id="carritototal" width="100%">
        <tr>
            <td><h5 class="text-left"><label>Total de Items:</label></h5></td>
            <td><h5 class="text-right"><label id="lblitems" name="lblitems">0.00</label></h5></td>
        </tr>
        <tr>
            <td><h5 class="text-left"><label>Descontado %:</label></h5></td>
            <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5></td>
        </tr>
        <tr>
            <td width="40%"><h5 class="text-left"><label>Subtotal:</label></h5></td>
            <td width="60%"><h5 class="text-right"><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5></td>
        </tr>
        <tr>
            <td><h5 class="text-left"><label>Exento 0.00%:</label></h5></td>
            <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lblexento" name="lblexento">0.00</label></h5></td>
        </tr>
        <tr>
            <td width="40%"><h5 class="text-left"><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%:</label></h5></td>
            <td width="60%"><h5 class="text-right"><?php echo $simbolo; ?><label id="lblsubtotaliva" name="lblsubtotaliva">0.00</label></h5></td>
        </tr>
        <tr>
            <td><h5 class="text-left"><label><?php echo $NomImpuesto; ?> <?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($ValorImpuesto, 2, '.', ''); ?>"></label></h5></td>
            <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5></td>
        </tr>
        <tr>
            <td><h5 class="text-left"><label>DESC: <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:25px;width:40px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>">%</label></h5></td>
            <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5></td>
        </tr>
        <tr>
            <td><h3><span class="text-right text-dark alert-link">TOTAL A PAGAR :</span> <?php echo $simbolo; ?></h3></td>
            <td><h3 class="text-right"> <label id="lbltotal" name="lbltotal">0.00</label></h3></td>
        </tr>
        <input type="hidden" name="formulario" id="formulario" value="pos"/>
        <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
        <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
        <input type="hidden" name="txtexonerado" id="txtexonerado" value="0.00"/>
        <input type="hidden" name="txtexonerado2" id="txtexonerado2" value="0.00"/>
        <input type="hidden" name="txtexento" id="txtexento" value="0.00"/>
        <input type="hidden" name="txtexento2" id="txtexento2" value="0.00"/>
        <input type="hidden" name="txtsubtotaliva" id="txtsubtotaliva" value="0.00"/>
        <input type="hidden" name="txtsubtotaliva2" id="txtsubtotaliva2" value="0.00"/>
        <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
        <input type="hidden" name="txtIva2" id="txtIva2" value="0.00"/>
        <input type="hidden" name="iva" id="iva" value="<?php echo number_format($ValorImpuesto, 2, '.', ''); ?>">
        <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
        <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
        <input type="hidden" name="txtPagado" id="txtPagado" value="0.00"/>
        <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/></td>
        </table>
        </div>

        <hr>

        <div class="pull-left">
            <button type="button" id="buttonapertura" class="btn btn-info waves-effect waves-light" data-placement="left" title="Aperturar Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalArqueo"><span class="fa fa-desktop"></span> Aperturar Caja</button>
        </div>

        <div class="pull-right">
            <button type="submit" name="submit_guardar" id="submit_guardar" class="btn btn-success" disabled="" onclick="AgregaProceso('<?php echo '2'; ?>')"><span class="fa fa-save"></span> Guardar</button>
            <button type="button" id="buttonpago" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Cobrar Venta" data-original-title="" data-href="#" disabled="" data-toggle="modal" data-target="#myModalPago" onclick="AgregaProceso('<?php echo '1'; ?>')"><span class="fa fa-calculator"></span> Cobrar (F2)</button>
            <button class="btn btn-dark" type="button" id="vaciar"><span class="fa fa-trash-o"></span> Limpiar (F4)</button>
        </div>

        </div>
        <!-- /.col -->
                                   
    </div>

    </form>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Row -->

<?php } ?>


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/script/jquery.min.js"></script> 
    <script src="assets/js/bootstrap.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!-- Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/VentanaCentrada.js"></script>
    <?php if($mostrar_pos == 1){ ?>
    <script type="text/javascript" src="assets/script/jsposopcion1.js"></script>
    <?php } elseif($mostrar_pos == 2){ ?>
    <script type="text/javascript" src="assets/script/jsposopcion2.js"></script>
    <?php } ?>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script src="assets/plugins/noty/themes/relax.js"></script>
    <script type="text/jscript">
    $('#loading').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#loading').load("familias_productos?CargarProductos=si&tipo_precio=3");
    }, 200);
    </script>
    <!-- jQuery -->

    <script id='rowPago' type="text/html">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback4"> 
                <i class="fa fa-bars form-control-feedback4"></i> 
                <select style="color:#000;font-weight:bold;" name="pagos[$INDEX][codmediopago]" id="codmediopago" title="Seleccione Forma Pago" class="form-control" required>
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $medio = new Login();
                $medio = $medio->ListarMediosPagos();
                if($medio==""){ 
                    echo "";
                } else {
                for ($i = 0; $i < sizeof($medio); $i++) { ?>
                <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>">
                <?php echo $medio[$i]['mediopago']; ?>
                </option>
                <?php } } ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group">
                <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[$INDEX][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off">
                <div class="input-group-append">
                    <div class="btn-group" data-bs-toggle="buttons">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Quitar" data-original-title="" onclick='rmRowPago(this)'><span class="fa fa-minus"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </script>

    <script id='rowPago2' type="text/html">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback4"> 
                <i class="fa fa-bars form-control-feedback4"></i> 
                <select style="color:#000;font-weight:bold;" name="pagos2[$INDEX][codmediopago]" id="codmediopago2" title="Seleccione Forma Pago" class="form-control" required>
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $medio = new Login();
                $medio = $medio->ListarMediosPagos();
                if($medio==""){ 
                    echo "";
                } else {
                for ($i = 0; $i < sizeof($medio); $i++) { ?>
                <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>">
                <?php echo $medio[$i]['mediopago']; ?>
                </option>
                <?php } } ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group">
                <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos2[$INDEX][montopagado]" id="montopagado2" onKeyUp="CalculoDevolucion2();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off">
                <div class="input-group-append">
                    <div class="btn-group" data-bs-toggle="buttons">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Quitar" data-original-title="" onclick='rmRowPago2(this)'><span class="fa fa-minus"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </script>

</body>
</html>