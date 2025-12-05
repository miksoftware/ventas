<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();

###################### DETALLE DE SESSION SUCURSAL ######################
$bod         = new Login();
$bod         = $bod->SucursalesSessionPorId();
$simbolo     = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$bod[0]['simbolo']."</strong>");
$ticket_general = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "8" : $bod[0]['ticket_general']);
###################### DETALLE DE SESSION SUCURSAL ######################

$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario();

$tra = new Login();
$muestra_factura = 0; 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="procesar")
{
    $reg = $tra->ProcesarPreventas();
    exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevocliente")
{
    $reg = $tra->RegistrarClientes();
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

<body onLoad="muestraReloj()" class="fix-header">
    
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

    <!--############################## MODAL PARA VER DETALLE DE PREVENTA ######################################-->
    <div id="myModalDetalle" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Preventa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                    </div>
                    <div class="modal-body">

                    <div id="muestrapreventamodal"></div> 
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA VER DETALLE DE PREVENTA ######################################-->                 
                        
    <?php if ($_SESSION['acceso'] != "administradorG"){ ?>
    <!--############################## MODAL PARA PROCESAR PREVENTA A VENTA ######################################-->
    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Detalle de Preventa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                
            <form class="form form-material" name="procesarpreventa" id="procesarpreventa" action="#">
                    
                   <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Búsqueda de Cliente: </label>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
                                </div>
                                <input type="hidden" name="proceso" id="proceso" value="procesar"/>
                                <input type="hidden" name="codpreventa" id="codpreventa"/>
                                <input type="hidden" name="codsucursal" id="codsucursal"/>
                                <input type="hidden" name="codcliente" id="codcliente" value="0"/>
                                <input type="hidden" name="nrodocumento" id="nrodocumento" value="0">
                                <input type="hidden" name="exonerado" id="exonerado" value="0">
                                <input type="hidden" name="limitecredito" id="limitecredito" value="0.00"/>
                                <input type="hidden" name="creditoinicial" id="creditoinicial" value="0.00">
                                <input type="hidden" name="abonototal" id="abonototal" value="0.00">
                                <input type="hidden" name="creditodisponible" id="creditodisponible" value="0.00">
                                <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
                                <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
                                <input type="hidden" name="txtexonerado" id="txtexonerado" value="0.00"/>
                                <input type="hidden" name="txtexonerado2" id="txtexonerado2" value="0.00"/>
                                <input type="hidden" name="txtexento" id="txtexento" value="0.00"/>
                                <input type="hidden" name="txtexento2" id="txtexento2" value="0.00"/>
                                <input type="hidden" name="txtsubtotaliva" id="txtsubtotaliva" value="0.00"/>
                                <input type="hidden" name="txtsubtotaliva2" id="txtsubtotaliva2" value="0.00"/>
                                <input type="hidden" name="iva" id="iva" value="0.00">
                                <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
                                <input type="hidden" name="txtIva2" id="txtIva2" value="0.00"/>
                                <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
                                <input type="hidden" name="descuento" id="descuento" value="0.00"/>
                                <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
                                <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
                                <input type="hidden" name="txtPagado" id="txtPagado" value="0.00"/>
                                <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
                                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" autocomplete="off" value="CONSUMIDOR FINAL"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                           <h4 class="mb-0 font-light">Total a Pagar</h4>
                           <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte" name="TextImporte">0.00</label></h4>
                        </div>

                        <div class="col-md-4">
                           <h4 class="mb-0 font-light">Total Recibido</h4>
                           <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado" name="TextPagado">0.00</label></h4>
                        </div>

                        <div class="col-md-4">
                           <h4 class="mb-0 font-light">Total Cambio</h4>
                           <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio">0.00</label></h4>
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
                                        $medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago'] ?></option>
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
                                </div>
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
                    <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button></span>
                    <button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->  
    <!--############################## MODAL PARA PROCESAR PREVENTA A VENTA ######################################-->

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

                <div id="save">
                    <!-- error will be shown here ! -->
                </div>
                    
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
                            $doc = new Login();
                            $doc = $doc->ListarDocumentos();
                            if($doc==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($doc);$i++){ ?>
                            <option value="<?php echo $doc[$i]['coddocumento']; ?>"><?php echo $doc[$i]['documento']; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                            <input type="hidden" name="proceso" id="proceso" value="nuevocliente"/>
                            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                            <input type="hidden" name="formulario" id="formulario" value="preventas"/>
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
    <?php } ?>

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
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Preventas</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Preventas</li>
                                <li class="breadcrumb-item active" aria-current="page">Preventas</li>
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
               
<?php if ($_SESSION['acceso'] == "administradorG"){ ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Preventas</h4>
            </div>

            <div class="form-body">

            <div class="card-body">

        <form class="form form-material" method="post" action="#" name="preventasxsucursal" id="preventasxsucursal">

            <div class="row">
                <div class="col-md-12"> 
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" class="form-control" required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $sucursal = new Login();
                        $sucursal = $sucursal->ListarSucursales();
                        if($sucursal==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($sucursal);$i++){
                        ?>
                        <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>       
                        <?php } } ?>
                        </select>
                    </div> 
                </div>
            </div>

            <div class="text-right">
                <button type="button" id="BotonBusqueda" onClick="BuscaPreventasxSucursal()" class="btn btn-dark"><span class="fa fa-search"></span> Realizar Búsqueda</button>
            </div>

            </form>

            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->

<div id="muestra_detalles"></div>

<?php } else { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Preventas</h4>
            </div>

            <div class="form-body">

                <div class="card-body">

                    <div id="save">
                    <!-- error will be shown here ! -->
                    </div>

                    <div class="row">

                    <div class="col-md-6">
                        <div class="btn-group m-b-20">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                            <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                                
                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("PREVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("CLIENTESXPREVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Clientes x Preventas</a>
                            </div>
                        </div>

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                        </div>
                    </div>
                </div>

                <div id="preventas"></div>

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
    <script src="assets/js/popper.min.js"></script> 
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
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/VentanaCentrada.js"></script>
    <?php if ($_SESSION['acceso'] != "administradorG"){ ?>
    <script type="text/javascript" src="assets/script/jspreventas.js"></script>
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
    <?php if ($_SESSION['acceso'] == "administradorG"){ ?>
    <script type="text/javascript">
    $(document).ready(function(){
        $(document).keypress(function(e) {        
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
            $("#BotonBusqueda").trigger("click");
            return false;
            }
        });                    
    }); 
    </script>
    <?php } else { ?>
    <script type="text/jscript">
    $('#preventas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#preventas').load("consultas?CargaPreventas=si");
     }, 200);
    </script>
    <?php } ?>
    <!-- jQuery -->

    <?php if ($_SESSION['acceso'] != "administradorG"){ ?>
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
                <?php echo $medio[$i]['mediopago'] ?>
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
    <?php } ?>

</body>
</html>