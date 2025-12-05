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

$tra = new Login();

if(isset($_POST["proceso"]) and $_POST["proceso"]=="cargaproducto")
{
    $reg = $tra->CargarProductos();
    exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="saveajustestock")
{
    $reg = $tra->RegistrarAjusteProducto();
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

    <!--############################## MODAL PARA VER IMAGEN DE PRODUCTO ######################################-->
    <!-- sample modal content -->
    <div id="myModalImg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Foto de Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                    <div id="muestrafotomodal"></div> 

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA VER IMAGEN DE PRODUCTO ######################################-->

    <!--############################## MODAL PARA VER DETALLE DE PRODUCTO ######################################-->
    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                    <div id="muestraproductomodal"></div> 

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA VER DETALLE DE PRODUCTO ######################################-->

    <!--############################## MODAL PARA CARGA MASIVA DE PRODUCTOS ######################################-->
    <!-- sample modal content -->
    <div id="myModalCargaMasiva" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Carga Masiva</h4>
                    <button type="button" onClick="ModalProducto()" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                
                <form class="form form-material" name="cargaproductos" id="cargaproductos" action="#" enctype="multipart/form-data">
                    
                 <div class="modal-body">
                    
                 <div id="carga">
                     <!-- error will be shown here ! -->
                 </div>

                <?php if ($_SESSION["acceso"]=="administradorG") { ?>
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
                <?php } else { ?>
                <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION['codsucursal']); ?>">
                <?php } ?>

                 <div class="row">
                    <div class="col-md-12"> 
                        <div class="form-group has-feedback">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="form-group has-feedback"> 
                                <label class="control-label">Realice la búsqueda del Archivo (CSV): <span class="symbol required"></span></label>
                                <div class="input-group">
                                <div class="form-control" data-trigger="fileinput"><i class="fa fa-file-archive-o fileinput-exists"></i>
                                    <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-success btn-file">
                                <span class="fileinput-new"><i class="fa fa-cloud-upload"></i> Selecciona Archivo</span>
                                <span class="fileinput-exists"><i class="fa fa-file-archive-o"></i> Cambiar</span>
                                <input type="hidden" name="proceso" id="proceso" value="cargaproducto"/>
                                <input type="hidden" name="tipousuario" id="tipousuario" value="<?php echo ($_SESSION["acceso"]=="administradorG" ? 1 : 2) ?>"/>
                                <input type="file" class="btn btn-default" data-original-title="Suba su Archivo CSV" data-rel="tooltip" placeholder="Suba su Imagen" name="sel_file" id="sel_file" autocomplete="off" required="" aria-required="true">
                                </span>
                                <a href="#" class="input-group-addon btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Quitar</a>
                                </div><small><p>Para realizar la Carga masiva de Productos el archivo debe de ser extensión (CSV Delimitado por Comas). Debe de llevar la cantidad de filas y columnas explicadas para la Carga exitosa de los registros.<br></small>
                                <div id="divproducto"></div>   
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" onClick="CargaDivProductos()" class="btn btn-info"><span class="fa fa-eye"></span> Ver Detalles</button>
                <button type="submit" name="btn-cargar" id="btn-cargar" class="btn btn-danger"><span class="fa fa-cloud-upload"></span> Cargar</button>
                <button type="button" onClick="ModalProducto()" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--############################## MODAL PARA CARGA MASIVA DE PRODUCTOS ######################################-->

    <?php if ($_SESSION["acceso"] != "administradorG") { ?>
    <!--############################## MODAL PARA SUMAR STOCK DE PRODUCTO ######################################-->
    <!-- sample modal content -->
    <div id="myModalAjuste" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión Ajuste de Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="saveajusteproducto" id="saveajusteproducto">
                
        <div class="modal-body">

        <div id="save">
            <!-- error will be shown here ! -->
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Código: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="saveajustestock"/>
                    <input type="hidden" name="tipousuario" id="tipousuario" value="<?php echo ($_SESSION["acceso"]=="administradorG" ? 1 : 2) ?>"/>
                    <input type="hidden" name="tipodocumento" id="tipodocumento" value="<?php echo $tipodocumento = ($ticket_general == 8 ? "TICKET_AJUSTE_8" : "TICKET_AJUSTE_5"); ?>">
                    <input type="hidden" name="idproducto" id="idproducto">
                    <input type="hidden" name="codsucursal" id="codsucursal">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Producto" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Producto" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Marca: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="marca" id="marca" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Marca" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Modelo: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="modelo" id="modelo" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Modelo" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="existencia" id="existencia" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Existencia" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Procedimiento: <span class="symbol required"></span></label>
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="procedimiento" id="proceso1" value="1" checked="checked">
                          <span class="new-control-indicator"></span>SUMAR
                        </label>
                    </div>

                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="procedimiento" id="proceso2" value="2">
                          <span class="new-control-indicator"></span>RESTAR
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Cantidad a Sumar/Restar: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Motivo de Ajuste: <span class="symbol required"></span></label> 
                    <textarea style="color:#000;font-weight:bold;" class="form-control" type="text" name="motivoajuste" id="motivoajuste" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Motivo de Ajuste" rows="2"></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>
        </div>
        
        </div>

        <div class="modal-footer">
            <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
            <button class="btn btn-dark" type="button" onclick="
            document.getElementById('proceso').value = 'savestock',
            document.getElementById('codsucursal').value = '',
            document.getElementById('idproducto').value = '',
            document.getElementById('codproducto').value = '',
            document.getElementById('producto').value = '',
            document.getElementById('marca').value = '',
            document.getElementById('modelo').value = '',
            document.getElementById('existencia').value = '',
            document.getElementById('cantidad').value = '',
            document.getElementById('motivoajuste').value = ''
            " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
        </div>
        
        </form>

    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <!--############################## MODAL PARA SUMAR STOCK DE PRODUCTO ######################################-->  
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
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Consulta General</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active" aria-current="page">Productos</li>
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
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos</h4>
            </div>

            <div class="form-body">

            <div class="card-body">

        <form class="form form-material" method="post" action="#" name="productosxsucursal" id="productosxsucursal">

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
                    <button type="button" id="BotonBusqueda" onClick="BuscaProductosxSucursal()" class="btn btn-dark"><span class="fa fa-search"></span> Realizar Búsqueda</button>
                </div>

            </form>


            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->

<div id="muestra_productos"></div>

<?php } else { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos</h4>
            </div>

            <div class="form-body">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-8">
                        <div class="btn-group m-b-20">
                        <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") { ?>
                        <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false"><span class="fa fa-cloud-upload"></span> Cargar</font></button>
                        <?php } ?>

                        <div class="btn-group">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                            <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                                
                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("PRODUCTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("STOCKOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Óptimo</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("STOCKMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Medio</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("STOCKMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("STOCKCERO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Cero</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("FECHASOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Óptimo</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("FECHASMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Medio</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("FECHASMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Minimo</a>

                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("CODIGOBARRAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-barcode text-dark"></span> Código Barras</a>
                            </div>
                        </div> 

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

                        </div>
                    </div>
                </div>

                <div id="productos"></div>

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
    <!-- Custom file upload -->
    <script src="assets/plugins/fileupload/bootstrap-fileupload.min.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/VentanaCentrada.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <!-- script jquery -->

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
    $('#productos').append('<center><p><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</p></center>').fadeIn("slow");
    setTimeout(function() {
    $('#productos').load("consultas?CargaProductos=si");
     }, 200);
    </script>
    <?php } ?>
    <!-- jQuery -->

</body>
</html>