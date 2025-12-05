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
    $reg = $tra->RegistrarCompras();
    exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="newproducto")
{
    $reg = $tra->RegistrarNuevoProducto();
    exit;
} 
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="newproveedor")
{
    $reg = $tra->RegistrarProveedores();
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
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
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

<body onLoad="muestraReloj(); getTime(); document.getElementById('search_producto_compra_barra').focus();" class="fix-header">
    
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

        <!--############################## MODAL PARA REGISTRO DE NUEVO PROVEEDOR ######################################-->
    <!-- sample modal content -->
    <div id="myModalProveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Proveedores</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                
            <form class="form form-material" method="post" action="#" name="saveproveedor" id="saveproveedor"> 

            <div id="save">
            <!-- error will be shown here ! -->
            </div>
                    
            <div class="modal-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tipo de Documento: </label>
                        <i class="fa fa-bars form-control-feedback"></i> 
                        <select style="color:#000;font-weight:bold;" name="documproveedor" id="documproveedor" class='form-control' required="" aria-required="true">
                            <option value="0"> -- SELECCIONE -- </option>
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
                            <input type="hidden" name="proceso" id="proceso" value="newproveedor"/>
                            <input type="hidden" name="formulario" id="formulario" value="poscompra"/>
                            <input type="hidden" name="tipousuario" id="tipousuario" value="<?php echo ($_SESSION["acceso"]=="administradorG" ? 1 : 2) ?>"/>
                            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                            <input type="text" class="form-control" name="cuitproveedor" id="cuitproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-bolt form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Proveedor: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="nomproveedor" id="nomproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Proveedor" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                            <input type="text" class="form-control phone-inputmask" name="tlfproveedor" id="tlfproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-phone form-control-feedback"></i> 
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

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Departamento: </label>
                            <i class="fa fa-bars form-control-feedback"></i>
                            <select style="color:#000;font-weight:bold;" class="form-control" id="id_departamento" name="id_departamento" required="" aria-required="true">
                                <option value=""> -- SIN RESULTADOS -- </option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Dirección de Proveedor: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="direcproveedor" id="direcproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección de Proveedor" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-map-marker form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Correo de Proveedor: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="emailproveedor" id="emailproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-envelope-o form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Vendedor: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="vendedor" id="vendedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Vendedor" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                            <input type="text" class="form-control phone-inputmask" name="tlfvendedor" id="tlfvendedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                            <i class="fa fa-phone form-control-feedback"></i> 
                        </div>
                    </div>
                </div>

            </div>

                <div class="modal-footer">
                    <button type="submit" name="btn-proveedor" id="btn-proveedor" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                    <button class="btn btn-dark" type="button" onclick="ResetProveedor2();" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <!--############################## MODAL PARA REGISTRO DE NUEVO PROVEEDOR ######################################-->


    <!--############################## MODAL PARA REGISTRO DE NUEVO PRODUCTO ######################################-->
    <!-- sample modal content -->
    <div id="myModalNuevo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Producto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                
            <form class="form form-material" method="post" action="#" name="nuevoproducto" id="nuevoproducto" enctype="multipart/form-data"> 

            <div id="save">
            <!-- error will be shown here ! -->
            </div>
                    
            <div class="modal-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Código de Producto: <span class="symbol required"></span></label>
                        <input type="hidden" name="formulario" id="formulario" value="poscompra">
                        <input type="hidden" name="modulo" id="modulo" value="3">
                        <input type="hidden" name="proceso" id="proceso" value="newproducto"/>
                        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                        <input type="text" class="form-control" name="codproducto2" id="codproducto2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Producto" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-bolt form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="producto2" id="producto2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Producto" autocomplete="off" required="" aria-required="true"/>
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4"> 
                    <div class="form-group has-feedback2"> 
                        <label class="control-label">Descripción de Producto: </label> 
                        <textarea class="form-control" type="text" name="descripcion2" id="descripcion2" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripción de Producto" rows="1"></textarea>
                        <i class="fa fa-comment-o form-control-feedback2"></i> 
                    </div> 
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"> 
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Tiene Imei: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="imei2" id="imei2" class="form-control" required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <option value="SI">SI</option>
                        <option value="NO" selected>NO</option>
                        </select>
                   </div> 
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Condición de Producto: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="condicion2" id="condicion2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Condición" autocomplete="off" <?php if (isset($reg[0]['condicion'])) { ?> value="<?php echo $reg[0]['condicion']; ?>" <?php } ?> required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Familia: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codfamilia2" id="codfamilia2" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $familia = new Login();
                        $familia = $familia->ListarFamilias();
                        if($familia==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($familia);$i++){ ?>
                        <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"><?php echo $familia[$i]['nomfamilia']; ?></option>        
                        <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Marca: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codmarca2" id="codmarca2" onChange="CargaModelos2(this.form.codmarca2.value);" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $marca = new Login();
                        $marca = $marca->ListarMarcas();
                        if($marca==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($marca);$i++){ ?>
                        <option value="<?php echo encrypt($marca[$i]['codmarca']); ?>"><?php echo $marca[$i]['nommarca']; ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Modelo: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codmodelo2" id="codmodelo2" class='form-control' required="" aria-required="true">
                        <option value=""> -- SIN RESULTADOS -- </option>
                        </select> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Presentación: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codpresentacion2" id="codpresentacion2" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $presentacion = new Login();
                        $presentacion = $presentacion->ListarPresentaciones();
                        if($presentacion==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($presentacion);$i++){ ?>
                        <option value="<?php echo encrypt($presentacion[$i]['codpresentacion']); ?>"><?php echo $presentacion[$i]['nompresentacion']; ?></option>        
                        <?php } } ?>
                        </select> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Color: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codcolor2" id="codcolor2" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $color = new Login();
                        $color = $color->ListarColores();
                        if($color==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($color);$i++){ ?>
                        <option value="<?php echo encrypt($color[$i]['codcolor']); ?>"><?php echo $color[$i]['nomcolor']; ?></option><?php } } ?>
                        </select> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                        <input type="text" class="form-control calculoprecio" name="preciocompra2" id="preciocompra2" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio de Compra" value="0.00" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-tint form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Precio Venta x Público: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="precioxpublico2" id="precioxpublico2" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio Venta x Público" value="0.00" autocomplete="off"  required="" aria-required="true"/>  
                        <i class="fa fa-tint form-control-feedback"></i>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Existencia: <span class="symbol required"></span></label>
                         <input type="text" class="form-control" name="existencia2" id="existencia2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Existencia" autocomplete="off" value="0.00" required="" aria-required="true"/>  
                        <i class="fa fa-bolt form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Código de Barra: </label>
                        <input type="text" class="form-control" name="codigobarra2" id="codigobarra2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Barra" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-barcode form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Impuesto de Producto: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="ivaproducto2" id="ivaproducto2" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <option value="<?php echo encrypt("0"); ?>"> EXENTO 0% </option>
                        <?php
                        $impuesto = new Login();
                        $impuesto = $impuesto->ListarImpuestosActivos();
                        if($impuesto==""){
                            echo "";    
                        } else {
                        for($i=0;$i<sizeof($impuesto);$i++){ ?>
                        <option value="<?php echo encrypt($impuesto[$i]['codimpuesto']); ?>"><?php echo $impuesto[$i]['nomimpuesto']." (".$impuesto[$i]['valorimpuesto']." %)"; ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Descuento de Producto: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="descproducto2" id="descproducto2" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Descuento" value="0.00" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-tint form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Proveedor: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codproveedor2" id="codproveedor2" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $proveedor = new Login();
                        $proveedor = $proveedor->ListarProveedores();
                        if($proveedor==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($proveedor);$i++){ ?>
                        <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>"><?php echo $proveedor[$i]['nomproveedor']; ?></option>        
                        <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>

            </div>

                <div class="modal-footer">
                    <button type="submit" name="btn-save" id="btn-save" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                    <button class="btn btn-dark" type="reset" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 
    <!--############################## MODAL PARA REGISTRO DE NUEVO PRODUCTO ######################################-->

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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Compras</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">POS Terminal</li>
                                <li class="breadcrumb-item active" aria-current="page">POS Compras </li>
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
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> POS Compras</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>
            
            <div class="form-body">

              <div class="card-body">

    <div class="row">

        <!-- .col -->
        <div class="col-md-6">
        
        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-cart-plus"></i> Detalle de Compras</h3><hr>

        <form class="form form-horizontal" method="post" action="#" name="saveposcompra" id="saveposcompra"> 

        <?php if($arqueo==""){ ?>

        <div id="muestra_mensaje" class='alert alert-danger text-center'>
        <span class='fa fa-info-circle'></span> POR FAVOR REALICE LA APERTURA DE CAJA PARA PROCESAR VENTAS
        </div>

        <?php } ?>

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
        <input type="hidden" name="precioconiva" id="precioconiva" value="0.00"> 
        <input type="hidden" name="precioxmayor" id="precioxmayor" value="0.00">
        <input type="hidden" name="precioxmenor" id="precioxmenor" value="0.00">
        <input type="hidden" name="precioxpublico" id="precioxpublico" value="0.00">
        <input type="hidden" name="lote" id="lote">
        <input type="hidden" name="fechaelaboracion" id="fechaelaboracion">
        <input type="hidden" name="fechaoptimo" id="fechaoptimo">
        <input type="hidden" name="fechamedio" id="fechamedio">
        <input type="hidden" name="fechaminimo" id="fechaminimo">
        <input type="hidden" name="stockoptimo" id="stockoptimo">
        <input type="hidden" name="stockmedio" id="stockmedio">
        <input type="hidden" name="stockminimo" id="stockminimo">
        <input type="hidden" name="posicionimpuesto" id="posicionimpuesto">
        <input type="hidden" name="tipoimpuesto" id="tipoimpuesto">
        <input type="hidden" name="ivaproducto" id="ivaproducto">
        <input type="hidden" name="descfactura" id="descfactura" value="0.00">
        <input type="hidden" name="descproducto" id="descproducto" value="0.00">
        <input type="hidden" name="cantidad" id="cantidad" value="1">
        <input type="hidden" name="proceso" id="proceso" value="save">    
        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="tipodocumento" id="factura" value="FACTURA_COMPRA" checked="checked">
                          <span class="new-control-indicator"></span>FACTURA
                        </label>
                    </div>

                    <div class="n-chk">
                        <?php if($ticket_general == 5){ ?>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="tipodocumento" id="ticket2" value="TICKET_COMPRA_5">
                          <span class="new-control-indicator"></span>TICKET (58MM)
                        </label>
                        <?php } elseif($ticket_general == 8){ ?>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="tipodocumento" id="ticket1" value="TICKET_COMPRA_8">
                          <span class="new-control-indicator"></span>TICKET (80MM)
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">N° de Factura: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="codfactura" id="codfactura" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="N° de Factura" required="" aria-required="true">
                    <i class="fa fa-flash form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Fecha de Emisión: <span class="symbol required"></span></label> 
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control calendario" name="fechaemision" id="fechaemision" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Emisión" value="<?php echo date("d-m-Y"); ?>" required="" aria-required="true">
                    <i class="fa fa-calendar form-control-feedback"></i>  
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Fecha de Recepción: <span class="symbol required"></span></label> 
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control calendario" name="fecharecepcion" id="fecharecepcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Recepción" value="<?php echo date("d-m-Y"); ?>" required="" aria-required="true">
                    <i class="fa fa-calendar form-control-feedback"></i>  
                </div> 
            </div>

            <div class="col-md-4">
                <label class="control-label">Seleccione Proveedor: <span class="symbol required"></span></label>
                <div class="input-group mb-3">
                <div class="input-group-append">
                <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Proveedor" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
                </div>
                <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $proveedor = new Login();
                $proveedor = $proveedor->ListarProveedores();
                if($proveedor==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($proveedor);$i++){ ?>
                <option value="<?php echo $proveedor[$i]['codproveedor'] ?>"><?php echo $proveedor[$i]['nomproveedor'] ?></option>
                <?php } } ?>
                </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Compra: <span class="symbol required"></span></label>
                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="tipocompra" id="contado" value="CONTADO" checked="checked" onClick="CargaFormaPagosCompras()">
                          <span class="new-control-indicator"></span>CONTADO
                        </label>
                    </div>

                    <div class="n-chk">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                          <input type="radio" class="new-control-input" name="tipocompra" id="credito" value="CREDITO" onClick="CargaFormaPagosCompras()">
                          <span class="new-control-indicator"></span>CRÉDITO
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="formacompra" id="formacompra" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $pago = new Login();
                    $pago = $pago->ListarMediosPagos();
                    if($pago==""){ 
                       echo "";
                    } else {
                    for($i=0;$i<sizeof($pago);$i++){  ?>
                    <option value="<?php echo encrypt($pago[$i]['codmediopago']); ?>"><?php echo $pago[$i]['mediopago']; ?></option>       
                    <?php } } ?> 
                    </select>
                </div> 
            </div>

            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                   <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                   <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vence Crédito" disabled="" required="" aria-required="true">
                   <i class="fa fa-calendar form-control-feedback"></i>  
                </div> 
            </div>  

            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Gasto de Envio: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="gastoenvio" id="gastoenvio" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Gasto de Envio" <?php if (isset($reg[0]['gastoenvio'])) { ?> value="<?php echo $reg[0]['gastoenvio']; ?>" readonly="" <?php } else { ?> value="0.00" required="" aria-required="true" <?php } ?>>
                    <i class="fa fa-flash form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Observaciones: </label> 
                    <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="2"><?php if (isset($reg[0]['observaciones'])) { echo $reg[0]['observaciones']; } ?></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Búsqueda por Lector de Barra: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_compra_barra" id="search_producto_compra_barra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra">
                    <i class="fa fa-barcode form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-6">
                <label class="control-label">Búsqueda por Criterio: </label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Producto" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalNuevo" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i></button>
                    </div>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_compra" id="search_producto_compra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                </div>
            </div>
        </div>

        <div class="table-responsive m-t-10 scrollcompra">
            <table id="carrito" class="table table-hover">
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
    </table>
    </div>

    <div class="pull-right">
<span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button></span>
<button class="btn btn-dark" type="button" id="vaciar"><span class="fa fa-trash-o"></span> Limpiar (F4)</button>
    </div>

        </form>

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">

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
    <script type="text/javascript" src="assets/script/jsposcompras.js"></script>
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
    $('#loading').load("familias_productos?CargarProductosCompras=si");
    }, 200);
    </script>
    <!-- jQuery -->

</body>
</html>