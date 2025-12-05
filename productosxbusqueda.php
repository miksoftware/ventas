<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();
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
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Búsqueda de Productos</h5>
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

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Productos</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

        <div class="form-body">

        <div class="card-body">

    <form class="form form-material" method="post" action="#" name="busquedaproductosxtipo" id="busquedaproductosxtipo">

    <?php if($_SESSION['acceso'] == "administradorG") { ?>
    <div class="row">
        <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" class="form-control" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0); CargaMarcasxSucursal(this.form.codsucursal.value,0); CargaPresentacionesxSucursal(this.form.codsucursal.value); CargaColoresxSucursal(this.form.codsucursal.value); CargaOrigenesxSucursal(this.form.codsucursal.value); CargaProveedoresxSucursal(this.form.codsucursal.value);" required="" aria-required="true">
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
    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
    <?php } ?>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Tipo de Búsqueda: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" name="tipobusqueda" id="tipobusqueda" class="form-control" onChange="SeleccionaTipoBusqueda(this.form.tipobusqueda.value);" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="<?php echo "1"; ?>">FAMILIA/SUBFAMILIA</option>
                    <option value="<?php echo "2"; ?>">MARCA/MODELO</option>
                    <option value="<?php echo "3"; ?>">PRESENTACIÓN</option>
                    <option value="<?php echo "4"; ?>">COLOR</option>
                    <option value="<?php echo "5"; ?>">ORIGEN</option>
                    <option value="<?php echo "6"; ?>">PROVEEDOR</option>
                    <option value="<?php echo "7"; ?>">FAMILIA/PROVEEDOR</option>
                    <option value="<?php echo "8"; ?>">MARCA/PROVEEDOR</option>
                </select>         
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Familia: </label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codfamilia" id="codfamilia" onChange="CargaSubfamilias(this.form.codfamilia.value);" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
                <?php } else { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codfamilia" id="codfamilia" onChange="CargaSubfamilias(this.form.codfamilia.value);" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $familia = new Login();
                $familia = $familia->ListarFamilias();
                if($familia==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($familia);$i++){ ?>
                <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"><?php echo $familia[$i]['nomfamilia'] ?></option>        
                <?php } } ?>
                </select>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione SubFamilia: </label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codsubfamilia" id="codsubfamilia" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Marca: </label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codmarca" id="codmarca" onChange="CargaModelos(this.form.codmarca.value);" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
                <?php } else { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codmarca" id="codmarca" onChange="CargaModelos(this.form.codmarca.value);" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $marca = new Login();
                $marca = $marca->ListarMarcas();
                if($marca==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($marca);$i++){ ?>
                <option value="<?php echo encrypt($marca[$i]['codmarca']); ?>"><?php echo $marca[$i]['nommarca'] ?></option>
                <?php } } ?>
                </select>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Modelo: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codmodelo" id="codmodelo" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Presentación: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codpresentacion" id="codpresentacion" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
                <?php } else { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codpresentacion" id="codpresentacion" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $presentacion = new Login();
                $presentacion = $presentacion->ListarPresentaciones();
                if($presentacion==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($presentacion);$i++){ ?>
                <option value="<?php echo encrypt($presentacion[$i]['codpresentacion']); ?>"><?php echo $presentacion[$i]['nompresentacion'] ?></option>        
                <?php } } ?>
                </select>
                <?php } ?> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Color: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codcolor" id="codcolor" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
                <?php } else { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codcolor" id="codcolor" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $color = new Login();
                $color = $color->ListarColores();
                if($color==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($color);$i++){ ?>
                <option value="<?php echo encrypt($color[$i]['codcolor']); ?>"><?php echo $color[$i]['nomcolor'] ?></option><?php } } ?>
                </select>
                <?php } ?> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Origen: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codorigen" id="codorigen" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
                <?php } else { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codorigen" id="codorigen" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $origen = new Login();
                $origen = $origen->ListarOrigenes();
                if($origen==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($origen);$i++){ ?>
                <option value="<?php echo encrypt($origen[$i]['codorigen']); ?>"><?php echo $origen[$i]['nomorigen'] ?></option>        
                <?php } } ?>
                </select>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Seleccione Proveedor: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codproveedor" id="codproveedor" disabled="" required="" aria-required="true">
                <option value=""> -- SIN RESULTADOS -- </option>
                </select>
                <?php } else { ?>
                <select style="color:#000;font-weight:bold;" class="form-control" name="codproveedor" id="codproveedor" disabled="" required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $proveedor = new Login();
                $proveedor = $proveedor->ListarProveedores();
                if($proveedor==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($proveedor);$i++){ ?>
                <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>"><?php echo $proveedor[$i]['nomproveedor'] ?></option>        
                <?php } } ?>
                </select>
                <?php } ?> 
            </div>
        </div>
    </div>

    <div class="text-right">
        <button type="button" id="BotonBusqueda" onClick="BuscarProductosxTipoBusqueda()" class="btn btn-dark"><span class="fa fa-search"></span> Realizar Búsqueda</button>
    </div>

    </form>


            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->

<div id="muestra_detalles"></div>


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
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <!-- script jquery -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
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
    <!-- jQuery -->
    
</body>
</html>