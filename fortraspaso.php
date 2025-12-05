<?php
require_once('class/class.php');
$accesos = ['administradorS', 'secretaria'];
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

$tra = new Login();

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
   $reg = $tra->RegistrarTraspasos();
   exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
   $reg = $tra->ActualizarTraspasos();
   exit;
}  
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregar") 
{
   $reg = $tra->AgregarDetallesTraspasos();
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
      
    <!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Búsqueda de Productos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                    </div>
                    <div class="modal-body">

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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Traspasos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Traspasos</li>
                                <li class="breadcrumb-item active" aria-current="page">Traspasos</li>
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
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Traspasos</h4>
            </div>

    <?php if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
          
    $j = new Login();
    $reg = $j->TraspasosPorId(); ?>
          
    <form class="form form-material" method="post" action="#" name="updatetraspaso" id="updatetraspaso" data-id="<?php echo $reg[0]["codtraspaso"]; ?>">

    <?php } else if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") {
          
    $j = new Login();
    $reg = $j->TraspasosPorId(); ?>
          
    <form class="form form-material" method="post" action="#" name="agregatraspaso" id="agregatraspaso" data-id="<?php echo $reg[0]["codtraspaso"]; ?>">
            
    <?php } else { ?>
            
     <form class="form form-material" method="post" action="#" name="savetraspaso" id="savetraspaso">

    <?php } ?>
           
    <div class="form-body">

    <div id="save">
    <!-- error will be shown here ! -->
    </div>

    <div class="card-body">

    <input type="hidden" name="proceso" id="proceso" <?php if (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="U") { ?> value="update" <?php } elseif (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="A") { ?> value="agregar" <?php } else { ?> value="save" <?php } ?>>
    <input type="hidden" name="idtraspaso" id="idtraspaso" <?php if (isset($reg[0]['idtraspaso'])) { ?> value="<?php echo $reg[0]['idtraspaso']; ?>"<?php } ?>>
    <input type="hidden" name="codtraspaso" id="codtraspaso" <?php if (isset($reg[0]['codtraspaso'])) { ?> value="<?php echo encrypt($reg[0]['codtraspaso']); ?>"<?php } ?>>
    <input type="hidden" name="sucursal_envia" id="sucursal_envia" <?php if (isset($reg[0]['sucursal_envia'])) { ?> value="<?php echo encrypt($reg[0]['sucursal_envia']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>" <?php } ?>>
     
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group has-feedback">
                <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                <div class="n-chk">
                    <?php if($ticket_general == 5){ ?>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodocumento" id="ticket2" value="TICKET_TRASPASO_5" <?php if (isset($reg[0]['tipodocumento'])) { ?> <?php if($reg[0]['tipodocumento'] == "TICKET_TRASPASO_5") { ?> checked="checked" <?php } } else { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>TICKET (58MM)
                    </label>
                    <?php } elseif($ticket_general == 8){ ?>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodocumento" id="ticket1" value="TICKET_TRASPASO_8" <?php if (isset($reg[0]['tipodocumento'])) { ?> <?php if($reg[0]['tipodocumento'] == "TICKET_TRASPASO_8") { ?> checked="checked" <?php } } else { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>TICKET (80MM)
                    </label>
                    <?php } ?>
                </div>

                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="tipodocumento" id="factura" value="FACTURA_TRASPASO" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "FACTURA_TRASPASO") { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>FACTURA
                    </label>
                </div>
            </div>
        </div>

        <?php if (isset($reg[0]['sucursal_recibe'])) { ?>
        <div class="col-md-4"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Sucursal Destinatario: <span class="symbol required"></span></label> 
                <input type="hidden" name="sucursal_recibe" id="sucursal_recibe" value="<?php echo encrypt($reg[0]['sucursal_recibe']); ?>">
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="nomsucursal" id="nomsucursal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Sucursal que Recibe" value="<?php echo $reg[0]['cuitsucursal2'].": ".$reg[0]['nomsucursal2'] ?>" disabled="" required="" aria-required="true">
                <i class="fa fa-bank form-control-feedback"></i>  
            </div>
        </div>   
        <?php } else { ?>
        <div class="col-md-4"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Sucursal Destinatario: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="sucursal_recibe" id="sucursal_recibe" class="form-control" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $sucursal = new Login();
                $sucursal = $sucursal->ListarSucursalesDiferentes($bod[0]['gruposid']);
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
        <?php } ?>

        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label">Responsable de Traslado: </label>
                <input type="text" class="form-control" name="nombres_responsable" id="nombres_responsable" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Responsable de Traslado" autocomplete="off" <?php if (isset($reg[0]['nombres_responsable'])) { ?> value="<?php echo $reg[0]['nombres_responsable']; ?>" <?php } ?> required="" aria-required="true"/>  
                <i class="fa fa-user form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-2"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Fecha Traspaso: <span class="symbol required"></span></label> 
                <input style="color:#000;font-weight:bold;" type="text" class="form-control calendario" name="fechatraspaso" id="fechatraspaso" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Traspaso" <?php if (isset($reg[0]['fechatraspaso'])) { ?> value="<?php echo date("d-m-Y",strtotime($reg[0]['fechatraspaso'])); ?>" <?php } else { ?> value="<?php echo date("d-m-Y"); ?>" <?php } ?> required="" aria-required="true">
                <i class="fa fa-calendar form-control-feedback"></i>  
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group has-feedback">
                <label class="control-label">Estado de Traspaso: <span class="symbol required"></span></label>
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="estado_traspaso" id="registrado" value="1" <?php if (isset($reg[0]['estado_traspaso'])) { ?> <?php if($reg[0]['estado_traspaso'] == "1") { ?> value="1" checked="checked" <?php } } else { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>REGISTRADO
                    </label>

                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="estado_traspaso" id="enproceso" value="2" <?php if (isset($reg[0]['estado_traspaso']) && $reg[0]['estado_traspaso'] == "2") { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>EN PROCESO
                    </label>
                </div>

                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="estado_traspaso" id="pendiente" value="3" <?php if (isset($reg[0]['estado_traspaso']) && $reg[0]['estado_traspaso'] == "3") { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>PENDIENTE
                    </label>

                    <?php if (isset($reg[0]['estado_traspaso'])) { ?>
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                      <input type="radio" class="new-control-input" name="estado_traspaso" id="rechazado" value="5" <?php if (isset($reg[0]['estado_traspaso']) && $reg[0]['estado_traspaso'] == "5") { ?> checked="checked" <?php } ?>>
                      <span class="new-control-indicator"></span>RECHAZADO
                    </label>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-md-10"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label">Observaciones: </label> 
                <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"><?php if (isset($reg[0]['observaciones'])) { echo $reg[0]['observaciones']; } ?></textarea>
                <i class="fa fa-comment-o form-control-feedback2"></i> 
            </div> 
        </div>
    </div> 

<?php if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

    <div id="detallestraspasos"><!-- div id update -->

    <div class="table-responsive m-t-20">
    <table class="table table-hover">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Cantidad</th>
        <th>Código</th>
        <th>Descripción de Producto</th>
        <th>Precio Unitario</th>
        <th>Valor Total</th>
        <th>Desc %</th>
        <th>Impuesto</th>
        <th>Valor Neto</th>
        <?php if ($_SESSION['acceso'] == "administradorS") { ?>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;   
?>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleTraspaso('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoTraspaso(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleTraspaso('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
      
    <td class="text-dark alert-link">
    <input type="hidden" name="coddetalletraspaso[]" id="coddetalletraspaso" value="<?php echo $detalle[$i]["coddetalletraspaso"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
    <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <?php echo $detalle[$i]['codproducto']; ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
    <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>

    <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
    <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>

    <td class="text-dark alert-link">
    <input type="hidden" name="posicionimpuesto[]" id="posicionimpuesto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["posicionimpuesto"]; ?>">
    <input type="hidden" name="tipoimpuesto[]" id="tipoimpuesto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["tipoimpuesto"]; ?>">
    <input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>


    <td class="text-dark alert-link">
    <input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">
    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">
    <input type="hidden" class="subtotaliva" name="subtotaliva[]" id="subtotaliva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">
    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['subtotalimpuestos'], 2, '.', ''); ?>">
    <input type="hidden" class="subtotalgeneral" name="subtotalgeneral[]" id="subtotalgeneral_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>">
    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>"><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label>
    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >
    <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" ><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>
    <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleTraspaso('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLETRASPASO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
    </tr>
    <?php } ?>
    </tbody>
    </table><hr>

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
       <td><h5><?php echo $simbolo; ?><label id="lblexento" name="lblexento"><?php echo number_format($reg[0]['subtotalexento'], 2, '.', ','); ?></label></h5></td>
    </tr>
    <tr>
        <td><h5><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lblsubtotaliva" name="lblsubtotaliva"><?php echo number_format($reg[0]['subtotaliva'], 2, '.', ','); ?></label></h5></td>    
        <td><h5><label><?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5></td>
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

<?php } else if (isset($_GET['codtraspaso']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") { ?>

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles Agregados</h2><hr>

    <div id="detallestraspasos"><!-- div id agregar -->

    <div class="table-responsive m-t-20">
    <table class="table table-hover">
    <thead>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Nº</th>
        <th>Código</th>
        <th>Descripción de Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Valor Total</th>
        <th>Desc %</th>
        <th>Impuesto</th>
        <th>Valor Neto</th>
        <?php if ($_SESSION['acceso'] == "administradorS") { ?>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td class="text-dark alert-link"><?php echo $a++; ?></td>
    <td class="text-dark alert-link"><?php echo $detalle[$i]['codproducto']; ?></td>
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td class="text-dark alert-link"><?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
    <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleTraspaso('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','3','<?php echo encrypt("DETALLETRASPASO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
        </tr>
        <?php } ?>
        </tbody>
    </table><hr>
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
       <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalexento'], 2, '.', ','); ?></label></h5></td>
    </tr>
    <tr>
        <td><h5><label>Subtotal <?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotaliva'], 2, '.', ','); ?></label></h5></td>    
        <td><h5><label><?php echo $NomImpuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5></td>
     </tr>
     <tr>
        <td><h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5></td>
        <td class="text-dark alert-link"><h3><label>Importe Total</label></h3></td>
        <td><h3><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></h3></td>
    </tr>
    </table>
    </div>

    </div><!-- cerrar div id agregar -->

    <hr>

    <input type="hidden" name="idproducto" id="idproducto">
    <input type="hidden" name="codproducto" id="codproducto">
    <input type="hidden" name="producto" id="producto">
    <input type="hidden" name="descripcion" id="descripcion">
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
    <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">

    <div class="row">

    <!-- .col -->
    <div class="col-md-10">

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

    <div class="row">
        <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
            <label class="control-label">Realice la Búsqueda de Producto: <span class="symbol required"></span></label>
              <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_traspaso" id="search_traspaso" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda por Código, Descripción o Nº de Barra">
              <i class="fa fa-search form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
            <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
            <i class="fa fa-bars form-control-feedback"></i>
            <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
            <option value=""> -- SIN RESULTADOS -- </option>
            </select>
           </div> 
        </div> 

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
             <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" readonly="readonly">
             <i class="fa fa-bolt form-control-feedback"></i> 
          </div> 
        </div>  

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Descuento: <span class="symbol required"></span></label>
                <input class="form-control agregaproducto" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento">
                <i class="fa fa-tint form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Cantidad: <span class="symbol required"></span></label>
             <input type="text" class="form-control agregaproducto" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad">
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
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="CargaProductos()"><i class="fa fa-search"></i> Productos</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
        </div></br>

    <div class="table-responsive m-t-40">
    <table id="carrito" class="table table-hover">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Cantidad</th>
        <th>Código</th>
        <th>Descripción de Producto</th>
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
    </table><hr>

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

    <input type="hidden" name="idproducto" id="idproducto">
    <input type="hidden" name="codproducto" id="codproducto">
    <input type="hidden" name="producto" id="producto">
    <input type="hidden" name="descripcion" id="descripcion">
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
    <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">

    <div class="row">

    <!-- .col -->
    <div class="col-md-10">

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

    <div class="row">
        <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
            <label class="control-label">Realice la Búsqueda de Producto: <span class="symbol required"></span></label>
              <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_traspaso" id="search_traspaso" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda por Código, Descripción o Nº de Barra">
              <i class="fa fa-search form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
            <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
            <i class="fa fa-bars form-control-feedback"></i>
            <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
            <option value=""> -- SIN RESULTADOS -- </option>
            </select>
           </div> 
        </div> 

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
             <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" readonly="readonly">
             <i class="fa fa-bolt form-control-feedback"></i> 
          </div> 
        </div>  

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Descuento: <span class="symbol required"></span></label>
                <input class="form-control agregaproducto" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento">
                <i class="fa fa-tint form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
             <label class="control-label">Cantidad: <span class="symbol required"></span></label>
             <input type="text" class="form-control agregaproducto" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad">
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
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="CargaProductos()"><i class="fa fa-search"></i> Productos</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
        </div></br>

    <div class="table-responsive m-t-40">
    <table id="carrito" class="table table-hover">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
        <th>Cantidad</th>
        <th>Código</th>
        <th>Descripción de Producto</th>
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
    </table><hr>
        
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

<?php } ?> 


<div class="clearfix"></div>
<hr>
              <div class="text-right">
<?php if (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="U") { ?>
<span id="submit_update"><button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button></span>
<a href="traspasos"><button class="btn btn-dark" type="button"><span class="fa fa-trash-o"></span> Cancelar</button></a> 
<?php } else if (isset($_GET['codtraspaso']) && decrypt($_GET["proceso"])=="A") { ?>  
<span id="submit_agregar"><button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button></span>
<button class="btn btn-dark" type="button" id="vaciar2"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button></span>
<button class="btn btn-dark" type="button" id="vaciar"><i class="fa fa-trash-o"></i> Limpiar (F4)</button>
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
    <script type="text/javascript" src="assets/script/jstraspasos.js"></script>
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

</body>
</html>