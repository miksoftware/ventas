<?php
require_once('class/class.php');
$accesos = ['administradorS', 'secretaria', 'cajero'];
validarAccesos($accesos) or die();

###################### DETALLE DE SESSION SUCURSAL ######################
$bod         = new Login();
$bod         = $bod->SucursalesSessionPorId();
$simbolo     = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$bod[0]['simbolo']."</strong>");
$ticket_general = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "8" : $bod[0]['ticket_general']);
###################### DETALLE DE SESSION SUCURSAL ######################

###################### DETALLE DE IMPUESTO ######################
$imp           = new Login();
$imp           = $imp->ImpuestosPorId();
$NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
###################### DETALLE DE IMPUESTO ######################

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
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
    $reg = $tra->ActualizarVentas();
    exit;
}  
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregar")
{
    $reg = $tra->AgregarDetallesVentas();
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
    <!-- This Page CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
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

<body onLoad="muestraReloj(); getTime();" class="fix-header">
    
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

    <!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Búsqueda de Productos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                    </div>
                    <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> Productos</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarCombos();"><span class="fa fa-archive"></span> Combos</button>
                        </div>
                    </div><hr>

                    <!-- .div load -->
                    <div id="loading"></div>
                    <!-- /.div load -->

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->

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
                        <input type="hidden" name="formulario" id="formulario" value="forventa"/>
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
                        <option style="color:#000;font-weight:bold;" value="<?php echo $doc[$i]['coddocumento']; ?>"><?php echo $doc[$i]['documento']; ?></option>
                        <?php } } ?>
                        </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                            <input type="hidden" name="proceso" id="proceso" value="nuevocliente"/>
                            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                            <input type="hidden" name="formulario" id="formulario" value="forventa"/>
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
                                <li class="breadcrumb-item">Ventas</li>
                                <li class="breadcrumb-item active" aria-current="page">Ventas</li>
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
               
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Ventas</h4>
            </div>

    <?php if (isset($_GET['codventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
          
    $j = new Login();
    $reg = $j->VentasPorId(); ?>
          
    <form class="form form-material" method="post" action="#" name="updateventa" id="updateventa" data-id="<?php echo $reg[0]["codventa"]; ?>">

    <?php } else if (isset($_GET['codventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") {
          
    $j = new Login();
    $reg = $j->VentasPorId(); ?>
          
    <form class="form form-material" method="post" action="#" name="agregaventa" id="agregaventa" data-id="<?php echo $reg[0]["codventa"]; ?>">
            
    <?php } else { ?>
            
    <form class="form form-material" method="post" action="#" name="saveventa" id="saveventa">

    <!--############################## MODAL PARA COBRAR VENTA ######################################-->
    <!-- sample modal content -->
    <div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                 
            <div id="loadcampos">
            <?php if($arqueo!=""){ ?>
            <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
            <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $arqueo[0]["codcaja"]; ?>">
            <?php } ?>
            </div>

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>

            <div class="modal-body">
            <input type="hidden" name="creditoinicial" id="creditoinicial" value="0.00">
            <input type="hidden" name="creditodisponible" id="creditodisponible" value="0.00">
            <input type="hidden" name="abonototal" id="abonototal" value="0.00">
            <input type="hidden" name="tipoproceso" id="tipoproceso" value="<?php echo '1'; ?>">

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
                        </div>
                    </div>
                </div>
            </div>

            </div><!-- END CONDICION PAGO -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback2">
                            <label class="control-label">Observaciones: </label>
                            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="2" required="" aria-required="true"></textarea>
                            <i class="fa fa-comments form-control-feedback2"></i> 
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
    <!--############################## MODAL PARA COBRAR VENTA ######################################-->

    <?php } ?>
           
    <div class="form-body">

    <div id="save">
        <!-- error will be shown here ! -->
    </div>

    <div class="card-body">

    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <div class="row">
        <div class="col-md-10">
            <label class="control-label">Búsqueda de Cliente: </label>
            <div class="input-group mb-3">
                <div class="input-group-append">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
                </div>
                <input type="hidden" name="proceso" id="proceso" <?php if (isset($_GET['codventa']) && decrypt($_GET["proceso"])=="U") { ?> value="update" <?php } elseif (isset($_GET['codventa']) && decrypt($_GET["proceso"])=="A") { ?> value="agregar" <?php } else { ?> value="save" <?php } ?>>
                <input type="hidden" name="codventa" id="codventa" <?php if (isset($reg[0]['codventa'])) { ?> value="<?php echo encrypt($reg[0]['codventa']); ?>"<?php } ?>>
                <input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>"<?php } ?>>
                <input type="hidden" name="arqueoxventa" id="arqueoxventa" <?php if (isset($reg[0]['codventa'])) { ?> value="<?php echo encrypt($reg[0]['codarqueo']); ?>" <?php } ?>>
                <input type="hidden" name="codcliente" id="codcliente" <?php if (isset($reg[0]['codcliente'])) { ?> value="<?php echo $reg[0]['codcliente'] == '0' ? "0" : $reg[0]['codcliente']; ?>" <?php } else { ?> value="0" <?php } ?>>
                <input type="hidden" name="nrodocumento" id="nrodocumento" <?php if (isset($reg[0]['codcliente'])) { ?> value="<?php echo $reg[0]['codcliente'] == '0' ? "0" : $reg[0]['dnicliente']; ?>" <?php } else { ?> value="0" <?php } ?>>
                <input type="hidden" name="exonerado" id="exonerado" <?php if (isset($reg[0]['exonerado'])) { ?> value="<?php echo $reg[0]['exonerado']; ?>" <?php } else { ?> value="0" <?php } ?>>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para Búsqueda de Cliente" autocomplete="off" <?php if (isset($reg[0]['codcliente'])) { ?> value="<?php echo $reg[0]['codcliente'] == "0" ? "CONSUMIDOR FINAL" : $reg[0]['documento3'].": ".$reg[0]['dnicliente'].": ".$reg[0]['nomcliente']; ?>" <?php } else { ?> value="CONSUMIDOR FINAL" <?php } ?>/>
            </div>
        </div>

        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Limite de Crédito: <span class="symbol required"></span></label>
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="montocredito" id="montocredito" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Limite de Crédito" <?php if (isset($reg[0]['codventa'])) { ?> value="<?php echo $reg[0]['codcliente'] == '0' || $reg[0]['limitecredito'] == '0.00' ? "0.00" : number_format($reg[0]['creditodisponible'], 2, '.', ''); ?>" <?php } ?> autocomplete="off" disabled="" required="" aria-required="true"/>
            <i class="fa fa-usd form-control-feedback"></i> 
          </div>
        </div>
    </div>

<?php if (isset($_GET['codventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

    <div id="detallesventas"><!-- div id update -->

    <!--############################## MODAL PARA COBRAR VENTA ######################################-->
    <!-- sample modal content -->
    <div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                 
            <div id="loadcampos">
            <?php if($arqueo!=""){ ?>
            <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
            <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $arqueo[0]["codcaja"]; ?>">
            <?php } ?>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>

            <div class="modal-body">
            <input type="hidden" name="creditoinicial" id="creditoinicial" value="0.00">
            <input type="hidden" name="creditodisponible" id="creditodisponible" value="0.00">
            <input type="hidden" name="abonototal" id="abonototal" value="0.00">

                <div class="row">
                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total a Pagar</h4>
                       <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte" name="TextImporte"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></h4>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total Recibido</h4>
                       <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado" name="TextPagado"><?php echo number_format(0.00, 2, '.', ''); ?></label></h4>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total Cambio</h4>
                       <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio"><?php echo number_format(0.00, 2, '.', ''); ?></label></h4>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-8">
                       <h4 class="mb-0 font-light">Nombre del Cliente</h4>
                       <h4 class="mb-0 font-medium"> <label id="TextCliente" name="TextCliente"><?php echo $reg[0]['codcliente'] == "0" ? "CONSUMIDOR FINAL" : $reg[0]['documento3'].": ".$reg[0]['dnicliente'].": ".$reg[0]['nomcliente'];?></label></h4>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Limite de Crédito</h4>
                       <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito" name="TextCredito"><?php echo $reg[0]['codcliente'] == '0' || $reg[0]['limitecredito'] == '0.00' ? "0.00" : number_format($reg[0]['creditodisponible'], 2, '.', ''); ?></label></h4>
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
                                  <input type="radio" class="new-control-input" name="tipodocumento" id="notaventa1" value="NOTA_VENTA_5" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "NOTA_VENTA_5") { ?> checked="checked" <?php } ?> disabled="">
                                  <span class="new-control-indicator"></span>NOTA VENTA (58MM)
                                </label>
                                <?php } elseif($ticket_general == 8){ ?>
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento" id="notaventa2" value="NOTA_VENTA_8" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "NOTA_VENTA_8") { ?> checked="checked" <?php } ?> disabled="">
                                  <span class="new-control-indicator"></span>NOTA VENTA (80MM)
                                </label>
                                <?php } ?>

                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento" id="boleta" value="BOLETA_A4" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "BOLETA_A4") { ?> checked="checked" <?php } ?> disabled="">
                                  <span class="new-control-indicator"></span>BOLETA
                                </label>
                            </div>

                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento" id="factura" value="FACTURA_A4" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "FACTURA_A4") { ?> checked="checked" <?php } ?> disabled="">
                                  <span class="new-control-indicator"></span>FACTURA
                                </label>
                                
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipodocumento" id="guia" value="GUIA_REMISION" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "GUIA_REMISION") { ?> checked="checked" <?php } ?> disabled="">
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
                                  <input type="radio" class="new-control-input" name="tipopago" id="contado" value="CONTADO" checked="checked" onClick="CargaCondicionesPagos()" <?php if (isset($reg[0]['tipopago'])) { ?> <?php if($reg[0]['tipopago'] == "CONTADO") { ?> value="CONTADO" checked="checked" <?php } } else { ?> checked="checked"  <?php } ?> disabled="">
                                  <span class="new-control-indicator"></span>CONTADO
                                </label>
                            </div>

                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                                  <input type="radio" class="new-control-input" name="tipopago" id="credito" value="CREDITO" onClick="CargaCondicionesPagos()" <?php if (isset($reg[0]['tipopago']) && $reg[0]['tipopago'] == "CREDITO") { ?> checked="checked" <?php } ?> disabled="">
                                  <span class="new-control-indicator"></span>CRÉDITO
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"/>

                <?php if (isset($reg[0]['codventa']) && $reg[0]['tipopago'] == "CREDITO"){ ?>
                
                <div id="muestra_condiciones"><!-- IF CONDICION PAGO -->

                <div class="row">
                    <div class="col-md-4"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                            <input style="color:#000;font-weight:bold;" type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" value="<?php echo date("d-m-Y",strtotime($reg[0]['fechavencecredito'])); ?>" autocomplete="off" placeholder="Ingrese Fecha Vence Crédito" aria-required="true">
                            <i class="fa fa-calendar form-control-feedback"></i>  
                        </div> 
                    </div> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Forma de Pago: </label>
                            <i class="fa fa-bars form-control-feedback"></i>
                            <select style="color:#000;font-weight:bold;" name="formaabono" id="formaabono" title="Seleccione Forma Pago" class="form-control" required aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $medio = new Login();
                            $medio = $medio->ListarMediosPagos();
                            if($medio==""){ 
                                echo "";
                            } else {
                            for ($i = 0; $i < sizeof($medio); $i++) { ?>
                            <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if(!(strcmp($reg[0]['formapago'],$medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago']; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Abono Crédito: </label>
                            <input style="color:#000;font-weight:bold;" class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Ingrese Monto de Abono" value="<?php echo number_format($reg[0]['xmontopagado'], 2, '.', ''); ?>" required="" aria-required="true"> 
                            <i class="fa fa-tint form-control-feedback"></i>
                        </div> 
                    </div>
                </div>
                    
                </div><!-- END CONDICION PAGO -->

                <?php } else if (isset($reg[0]['codventa']) && $reg[0]['tipopago'] == "CONTADO") { ?>

                <div id="muestra_condiciones"><!-- IF CONDICION PAGO -->
                <?php  
                $explode = explode("<br>",$reg[0]['detalles_pagos']);
                $a = 0;
                for($cont=0; $cont<COUNT($explode); $cont++):
                list($codmediopago,$mediopago,$montopagado,$montodevuelto) = explode("|",$explode[$cont]);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback"> 
                            <?php if($cont==0){ ?>
                            <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                            <i class="fa fa-bars form-control-feedback"></i>
                            <?php } else { ?>
                            <i class="fa fa-bars form-control-feedback4"></i>
                            <?php } ?>
                            <select style="color:#000;font-weight:bold;" name="pagos[<?php echo $cont; ?>][codmediopago]" id="codmediopago" class="form-control" title="Seleccione Forma Pago" required aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $medio = new Login();
                            $medio = $medio->ListarMediosPagos();
                            if($medio==""){ 
                                echo "";
                            } else {
                            for ($i = 0; $i < sizeof($medio); $i++) { ?>
                            <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if(!(strcmp($codmediopago,$medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago']; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <?php if($cont==0){ ?><label class="control-label">Monto Recibido: <span class="symbol required"></span></label><?php } else { ?><?php } ?>
                        <div class="input-group">
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[<?php echo $cont; ?>][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off" value="<?php echo number_format($montopagado, 2, '.', ''); ?>">
                            <div class="input-group-append">
                                <?php if($cont==0){ ?>
                                <div class="btn-group" data-bs-toggle="buttons">
                                    <button type="button" class="btn btn-info waves-effect waves-light" data-placement="left" title="Agregar" data-original-title="" onclick="addRowPago()"><span class="fa fa-plus"></span></button>
                                </div>
                                <?php } else { ?>
                                <div class="btn-group" data-bs-toggle="buttons">
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Quitar" data-original-title="" onclick='rmRowPago(this)'><span class="fa fa-minus"></span></button>
                                </div>    
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endfor; ?>

                </div><!-- END CONDICION PAGO -->

                <?php } ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback2">
                                <label class="control-label">Observaciones: </label>
                                <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="2" required="" aria-required="true"><?php echo $reg[0]['observaciones']; ?></textarea>
                                <i class="fa fa-comments form-control-feedback2"></i> 
                            </div>
                        </div>
                    </div>
                   
                </div>

                <div class="modal-footer">
                    <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button></span>
                    <button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar (F10)</button>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA COBRAR VENTA ######################################-->

    <div class="table-responsive m-t-20">
    <table class="table table-hover">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Cantidad</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Precio Unitario</th>
        <th>Valor Total</th>
        <th>Desc %</th>
        <th>Impuesto</th>
        <th>Valor Neto</th>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
    </tr>
    </thead>
    <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;    
?>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleVenta('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoVenta(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleVenta('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
    <td class="alert-link">
    <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo $detalle[$i]["coddetalleventa"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
    <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca']; ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo']; ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
        <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', '');; ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>

    <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
    <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>
    
    <td class="text-dark alert-link">
    <input type="hidden" name="posicionimpuesto[]" id="posicionimpuesto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["posicionimpuesto"]; ?>">
    <input type="hidden" name="tipoimpuesto[]" id="tipoimpuesto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["tipoimpuesto"]; ?>">
    <input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["ivaproducto"], 2, '.', ''); ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>

    <td class="text-dark alert-link">
    <input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">
    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">
    <input type="hidden" class="subtotaliva" name="subtotaliva[]" id="subtotaliva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">
    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['subtotalimpuestos'], 2, '.', ''); ?>">
    <input type="hidden" class="subtotalgeneral" name="subtotalgeneral[]" id="subtotalgeneral_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>">
    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >
    <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >
    <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>
    <td>
    <?php if($reg[0]['notacredito'] != 1){ ?>
    <?php if($_SESSION['acceso'] == "administradorS" || $reg[0]["codigo"] == $_SESSION['codigo']){ ?>
    <?php if($reg[0]['statusarqueo'] == 1){ ?>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleVenta('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLEVENTA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

    <hr>

    <table id="carritototal" width="100%">
    <tr>
        <td width="250"><h5><label>Total de Items :</label></h5></td>
        <td width="250"><h5><label id="lblitems" name="lblitems"><?php echo number_format($reg[0]['articulos'], 2, '.', ','); ?></label></h5></td>
        <td width="250"><h5><label>Descontado %:</label></h5></td>
        <td width="250"><h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5></td>
    </tr>
    <tr>
       <td><h5><label>Subtotal:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotal'], 2, '.', ','); ?></label></h5></td>
       <td><h5><label>Exento 0%:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label id="lblexento" name="lblexento"><?php echo number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></label></h5></td>
    </tr>
    <tr>
        <td><h5><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lblsubtotaliva" name="lblsubtotaliva"><?php echo number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?></label></h5></td>    
        <td><h5><label><?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?></label></h5></td>
     </tr>
     <tr>
        <td><h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5></td>
        <td class="text-dark alert-link"><h3><label>Importe Total</label></h3></td>
        <td><h3><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></h3></td>
    </tr>
        <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotal'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotal'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtexonerado" id="txtexonerado" value="<?php echo number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ''); ?>"/>
        <input type="hidden" name="txtexonerado2" id="txtexonerado2" value="<?php echo number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ''); ?>"/>
        <input type="hidden" name="txtexento" id="txtexento" value="<?php echo number_format($reg[0]['subtotalexento'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtexento2" id="txtexento2" value="<?php echo number_format($reg[0]['subtotalexento'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtsubtotaliva" id="txtsubtotaliva" value="<?php echo number_format($reg[0]['subtotaliva'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtsubtotaliva2" id="txtsubtotaliva2" value="<?php echo number_format($reg[0]['subtotaliva'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtIva2" id="txtIva2" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
        <input type="hidden" name="iva" id="iva" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>">
        <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
        <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>
    </table>
    </div>
    
    </div><!-- cerrar div id update -->

<?php } else if (isset($_GET['codventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") { ?>

    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles Agregados</h2><hr>

    <div id="detallesventas"><!-- div id agregar -->

    <div class="table-responsive m-t-20">
    <table class="table table-hover">
    <thead>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Nº</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Valor Total</th>
        <th>Desc %</th>
        <th>Impuesto</th>
        <th>Valor Neto</th>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
    </tr>
    </thead>
    <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td class="text-dark alert-link"><?php echo $a++; ?></td>
    <td class="alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca']; ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>
    <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
    <td>
    <?php if($reg[0]['notacredito'] != 1){ ?>
    <?php if($_SESSION['acceso'] == "administradorS" || $reg[0]["codigo"] == $_SESSION['codigo']){ ?>
    <?php if($reg[0]['statusarqueo'] == 1){ ?>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleVenta('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','3','<?php echo encrypt("DETALLEVENTA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </td>
    </tr>
    <?php } ?>
    </tbody>
    </table>

    <hr>

    <table id="carritototal" width="100%">
    <tr>
        <td width="250"><h5><label>Total de Items :</label></h5></td>
        <td width="250"><h5><label><?php echo number_format($reg[0]['articulos'], 2, '.', ','); ?></label></h5></td>
        <td width="250"><h5><label>Descontado %:</label></h5></td>
        <td width="250"><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5></td>
    </tr>
    <tr>
       <td><h5><label>Subtotal:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotal'], 2, '.', ','); ?></label></h5></td>
       <td><h5><label>Exento 0%:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></label></h5></td>
    </tr>
    <tr>
        <td><h5><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?></label></h5></td>    
        <td><h5><label><?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?></label></h5></td>
     </tr>
     <tr>
        <td><h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5></td>
        <td class="text-dark alert-link"><h3><label>Importe Total</label></h3></td>
        <td><h3><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></h3></td>
    </tr>
    </table>
    </div>

    </div></div><!-- cerrar div id agregar -->

    <hr>

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
    <input type="hidden" name="precioconiva" id="precioconiva">
    <input type="hidden" name="posicionimpuesto" id="posicionimpuesto">
    <input type="hidden" name="tipoimpuesto" id="tipoimpuesto">
    <input type="hidden" name="ivaproducto" id="ivaproducto">

    <div class="row">

    <!-- .col -->
    <div class="col-md-10">

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

    <div class="row">
        <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Búsqueda por Lector de Barra: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_barra" id="search_producto_barra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra o Producto">
                <i class="fa fa-barcode form-control-feedback"></i> 
            </div> 
        </div> 
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group has-feedback">
                <label class="control-label">Tipo de Búsqueda: <span class="symbol required"></span></label>
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodetalle" id="1" value="1" checked="checked" onclick="VerificaDetalle()">
                      <span class="new-control-indicator"></span>PRODUCTO
                    </label>

                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodetalle" id="2" value="2" onclick="VerificaDetalle()">
                      <span class="new-control-indicator"></span>COMBO
                    </label>
                </div>

                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodetalle" id="3" value="3" onclick="VerificaDetalle()">
                      <span class="new-control-indicator"></span>SERVICIO
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-10"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Ingrese Criterio para tu Búsqueda: <span class="symbol required"></span></label>
              <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_busqueda" id="search_busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
              <i class="fa fa-search form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
               <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
               <div id="muestra_input">
               <i class="fa fa-bars form-control-feedback"></i>
               <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
               <option value=""> -- SIN RESULTADOS -- </option>
               </select>
               </div>
            </div> 
        </div> 

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
             <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" value="0">
             <i class="fa fa-bolt form-control-feedback"></i> 
          </div> 
        </div>  

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Descuento: <span class="symbol required"></span></label>
                <input class="form-control" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento" value="0.00">
                <i class="fa fa-tint form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Cantidad: <span class="symbol required"></span></label>
             <input type="text" class="form-control" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad" value="1">
             <i class="fa fa-bolt form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    </div>
    <!-- /.col -->
            
    <!-- .col -->  
    <div class="col-md-2">

    <hr><h2 class="card-subtitle m-0 text-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> Foto</h2><hr>
            
        <center><div id="muestra_foto"><img src='fotos/ninguna.png' width='160' height='170'></div></center>

    </div>
    <!-- /.col -->
                                   
        </div>

        <div class="pull-right">
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="MostrarProductos()"><i class="fa fa-search"></i> Búsqueda</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
        </div></br>

    <div class="table-responsive m-t-40">
    <table id="carrito" class="table table-hover">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Cantidad</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Precio Unitario</th>
        <th>Valor Total</th>
        <th>Desc %</th>
        <th>Impuesto</th>
        <th>Valor Neto</th>
        <th>Acción</th>
    </tr>
    </thead>
    <tbody>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
        <td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>
    </tr>
    </tbody>
    </table>
    
    <hr>

    <table id="carritototal" width="100%">
    <tr>
        <td width="250"><h5><label>Total de Items :</label></h5></td>
        <td width="250"><h5><label id="lblitems" name="lblitems">0.00</label></h5></td>
        <td width="250"><h5><label>Descontado %:</label></h5></td>
        <td width="250"><h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5></td>
    </tr>
    <tr>
       <td><h5><label>Subtotal:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5></td>
       <td><h5><label>Exento 0%:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label id="lblexento" name="lblexento">0.00</label></h5></td>
    </tr>
    <tr>
        <td><h5><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lblsubtotaliva" name="lblsubtotaliva">0.00</label></h5></td>    
        <td><h5><label><?php echo $NomImpuesto; ?> <?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5></td>
     </tr>
     <tr>
        <td><h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>">%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5></td>
        <td class="text-dark alert-link"><h3><label>Importe Total</label></h3></td>
        <td><h3><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></h3></td>
    </tr>
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
        <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
    </table> 
    </div>

<?php } else { ?>

    <div id="loadcampos">

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
    <input type="hidden" name="precioconiva" id="precioconiva">
    <input type="hidden" name="posicionimpuesto" id="posicionimpuesto">
    <input type="hidden" name="tipoimpuesto" id="tipoimpuesto">
    <input type="hidden" name="ivaproducto" id="ivaproducto">

    <div class="row">

    <!-- .col -->
    <div class="col-md-10">

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group has-feedback">
                <label class="control-label">Tipo de Búsqueda: <span class="symbol required"></span></label>
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodetalle" id="1" value="1" checked="checked" onclick="VerificaDetalle()">
                      <span class="new-control-indicator"></span>PRODUCTO
                    </label>

                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodetalle" id="2" value="2" onclick="VerificaDetalle()">
                      <span class="new-control-indicator"></span>COMBO
                    </label>
                </div>

                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodetalle" id="3" value="3" onclick="VerificaDetalle()">
                      <span class="new-control-indicator"></span>SERVICIO
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-5"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Búsqueda por Lector de Barra: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_barra" id="search_producto_barra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra o Producto">
                <i class="fa fa-barcode form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-5"> 
            <div class="form-group has-feedback"> 
              <label class="control-label">Ingrese Criterio para tu Búsqueda: <span class="symbol required"></span></label>
              <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_busqueda" id="search_busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
              <i class="fa fa-search form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
               <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
               <div id="muestra_input">
               <i class="fa fa-bars form-control-feedback"></i>
               <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
               <option value=""> -- SIN RESULTADOS -- </option>
               </select>
               </div>
            </div> 
        </div> 

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
             <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" value="0">
             <i class="fa fa-bolt form-control-feedback"></i> 
          </div> 
        </div>  

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Descuento: <span class="symbol required"></span></label>
                <input class="form-control" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento" value="0.00">
                <i class="fa fa-tint form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Cantidad: <span class="symbol required"></span></label>
             <input type="text" class="form-control" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad" value="1">
             <i class="fa fa-bolt form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    </div>
    <!-- /.col -->
            
    <!-- .col -->  
    <div class="col-md-2">

    <hr><h2 class="card-subtitle m-0 text-dark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> Foto</h2><hr>
            
        <center><div id="muestra_foto"><img src='fotos/ninguna.png' width='160' height='170'></div></center>

    </div>
    <!-- /.col -->
                                   
        </div>

       <div class="pull-right">
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="MostrarProductos()"><i class="fa fa-search"></i> Búsqueda</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
        </div>
    
    </div></br>

    <div class="table-responsive m-t-40">
    <table id="carrito" class="table table-hover">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Cantidad</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Precio Unitario</th>
        <th>Valor Total</th>
        <th>Desc %</th>
        <th>Impuesto</th>
        <th>Valor Neto</th>
        <th>Acción</th>
    </tr>
    </thead>
    <tbody>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
        <td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>
    </tr>
    </tbody>
    </table>
    
    <hr>

    <table id="carritototal" width="100%">
    <tr>
        <td width="250"><h5><label>Total de Items :</label></h5></td>
        <td width="250"><h5><label id="lblitems" name="lblitems">0.00</label></h5></td>
        <td width="250"><h5><label>Descontado %:</label></h5></td>
        <td width="250"><h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5></td>
    </tr>
    <tr>
       <td><h5><label>Subtotal:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5></td>
       <td><h5><label>Exento 0%:</label></h5></td>
       <td><h5><?php echo $simbolo; ?><label id="lblexento" name="lblexento">0.00</label></h5></td>
    </tr>
    <tr>
        <td><h5><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lblsubtotaliva" name="lblsubtotaliva">0.00</label></h5></td>    
        <td><h5><label><?php echo $NomImpuesto; ?> <?php echo number_format($ValorImpuesto, 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5></td>
     </tr>
     <tr>
        <td><h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>">%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5></td>
        <td class="text-dark alert-link"><h3><label>Importe Total</label></h3></td>
        <td><h3><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></h3></td>
    </tr>
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
        <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
    </table>
    </div>

<?php } ?> 

<div class="clearfix"></div>
<hr>
        
        <div class="pull-left">
    <button type="button" id="buttonapertura" class="btn btn-info waves-effect waves-light" data-placement="left" title="Aperturar Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalArqueo"><span class="fa fa-desktop"></span> Aperturar Caja</button>
        </div>

        <div class="text-right">
<?php if (isset($_GET['codventa']) && decrypt($_GET["proceso"])=="U") { ?>
<button type="button" id="buttonpago" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Cobrar Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"><span class="fa fa-edit"></span> Actualizar</button>
<a href="ventas"><button class="btn btn-dark" type="button"><span class="fa fa-trash-o"></span> Cancelar</button></a> 
<?php } else if (isset($_GET['codventa']) && decrypt($_GET["proceso"])=="A") { ?>  
<span id="submit_agregar"><button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button></span>
<button class="btn btn-dark" type="button" id="vaciar2" onclick="Refrescar();"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<button type="button" id="buttonpago" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Cobrar Venta" data-original-title="" data-href="#" disabled="" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"><span class="fa fa-calculator"></span> Cobrar (F2)</button>
<button class="btn btn-dark" type="button" id="vaciar" onclick="Refrescar();"><i class="fa fa-trash-o"></i> Limpiar (F4)</button>
<?php } ?>
</div>
          </div>
       </div>
     </form>
   </div>
  </div>
</div>

<!-- End Row -->


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
    <script type="text/javascript" src="assets/script/jsventas.js"></script>
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

</body>
</html>