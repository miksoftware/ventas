<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria', 'cajero', 'vendedor'];
validarAccesos($accesos) or die();

###################### DETALLE DE SESSION SUCURSAL ######################
$bod         = new Login();
$bod         = $bod->SucursalesSessionPorId();
$simbolo     = (empty($bod) || $_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$bod[0]['simbolo']."</strong>");
###################### DETALLE DE SESSION SUCURSAL ######################

$new = new Login();
$stringReplace = array("'", "&", '"','(',')');
?>

<?php
######################## BUSQUEDA DETALLE DE PRODUCTO EN COMPRA PARA PRECIO #######################
if (isset($_GET['BuscaDetallesProductoCompraxPrecio']) && isset($_GET['variable']) && isset($_GET['d_id']) && isset($_GET['d_codigo']) && isset($_GET['d_producto']) && isset($_GET['d_cantidad']) && isset($_GET['d_precio']) && isset($_GET['d_descproducto'])){

$variable = limpiar($_GET['variable']);
$reg = $new->DetallesProductoPorId();
?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Producto"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-10">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Producto: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Producto"><label id="d_producto" name="d_producto"><?php echo $reg[0]['producto']." ".$reg[0]["condicion"].$descripcion = ($reg[0]["descripcion"] != "" ? "<br>".$reg[0]["descripcion"] : "").$imei = ($reg[0]["imei"] != "" ? "<br>IMEI: ".$reg[0]["imei"] : ""); ?></label></abbr>
          </div>
        </div>
      </div>

      <div class="row m-t-5">
        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Precio de Compra: <span class="symbol required"></span></label> 
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="preciocompra" id="preciocompra" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Compra" required="" aria-required="true">
            <i class="fa fa-pencil form-control-feedback"></i> 
          </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Descuento de Producto: <span class="symbol required"></span></label> 
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproductofact" id="descproductofact" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
            <i class="fa fa-pencil form-control-feedback"></i> 
          </div> 
        </div>
      </div> 

      <div class="modal-footer">
        <button type="button" onClick="DoActionPrecio(
        '<?php echo $reg[0]['idproducto']; ?>',
        '<?php echo $reg[0]['codproducto']; ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['producto']); ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['descripcion'] == '' ? "0" : $reg[0]['descripcion']); ?>',
        '<?php echo $reg[0]['imei'] == '' ? "0" : $reg[0]['imei']; ?>',
        '<?php echo $reg[0]['condicion'] == '' ? "******" : $reg[0]['condicion']; ?>',
        '<?php echo $reg[0]['codmarca']; ?>',
        '<?php echo $reg[0]['codmarca'] == 0 ? "******" : $reg[0]['nommarca']; ?>',
        '<?php echo $reg[0]['codmodelo']; ?>',
        '<?php echo $reg[0]['codmodelo'] == 0 ? "******" : $reg[0]['nommodelo']; ?>',
        '<?php echo $reg[0]['codpresentacion']; ?>',
        '<?php echo $reg[0]['codpresentacion'] == 0 ? "******" : $reg[0]['nompresentacion']; ?>',
        '<?php echo $reg[0]['codcolor']; ?>',
        '<?php echo $reg[0]['codcolor'] == 0 ? "******" : $reg[0]['nomcolor']; ?>',
        document.getElementById('preciocompra').value,
        '<?php echo number_format($reg[0]['precioxmayor'], 2, '.', ''); ?>',
        '<?php echo number_format($reg[0]['precioxmenor'], 2, '.', ''); ?>',
        '<?php echo number_format($reg[0]['precioxpublico'], 2, '.', ''); ?>',
        document.getElementById('descproductofact').value,
        '<?php echo number_format($reg[0]['descproducto'], 2, '.', ''); ?>',
        '<?php echo $posicionimpuesto = ($reg[0]['ivaproducto'] != '0' ? $reg[0]['posicionimpuesto'] : "0"); ?>',
        '<?php echo $tipoimpuesto = ($reg[0]['ivaproducto'] != '0' ? $reg[0]['nomimpuesto'] : "EXENTO"); ?>',
        '<?php echo $ivaproducto = ($reg[0]['ivaproducto'] != '0' ? number_format($reg[0]['valorimpuesto'], 2, '.', '') : "0"); ?>',
        '<?php echo number_format($reg[0]['existencia'], 2, '.', ''); ?>',
        '<?php if($reg[0]['ivaproducto'] != '0'){ ?>'+document.getElementById('preciocompra').value+'<?php } else { echo "0.00"; } ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0000-00-00"; ?>',
        '<?php echo "0000-00-00"; ?>',
        '<?php echo "0000-00-00"; ?>',
        '<?php echo "0000-00-00"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
      </div>
<?php 
######################## BUSQUEDA DETALLE DE PRODUCTO EN COMPRA PARA PRECIO #######################
} 
?>


<?php
######################## BUSQUEDA DETALLE DE PRODUCTO PARA PRECIO #######################
if (isset($_GET['BuscaDetallesProductoxPrecio']) && isset($_GET['variable']) && isset($_GET['d_id']) && isset($_GET['d_codigo']) && isset($_GET['d_tipo']) && isset($_GET['d_producto']) && isset($_GET['d_opcionimei']) && isset($_GET['d_imei']) && isset($_GET['d_cantidad']) && isset($_GET['d_precio']) && isset($_GET['d_descproducto'])) {

$variable = limpiar($_GET['variable']); 

if(limpiar($_GET['d_tipo'] == 1)){ 

$reg = $new->DetallesProductoPorId();
?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Producto"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-10">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Producto: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Producto"><label id="d_producto" name="d_producto"><?php echo $reg[0]['producto']." ".$reg[0]["condicion"].$descripcion = ($reg[0]["descripcion"] != "" ? "<br>".$reg[0]["descripcion"] : ""); ?></label></abbr>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label class="control-label">Precio Mayorista: <span class="symbol required"></span></label>
            <br /><abbr title="Precio Mayorista"><label id="d_precioventa"><?php echo number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label class="control-label">Precio Minorista: <span class="symbol required"></span></label>
            <br /><abbr title="Precio Minorista"><label id="d_precioventa"><?php echo number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label class="control-label">Precio Público: <span class="symbol required"></span></label>
            <br /><abbr title="Precio Público"><label id="d_precioventa"><?php echo number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>

      <div class="row m-t-5">
        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Nuevo Precio de Venta: <span class="symbol required"></span></label> 
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Venta" required="" aria-required="true">
            <i class="fa fa-pencil form-control-feedback"></i> 
          </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Nuevo Descuento de Producto: <span class="symbol required"></span></label> 
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
            <i class="fa fa-pencil form-control-feedback"></i> 
          </div> 
        </div>
      </div> 

      <div class="modal-footer">
        <button type="button" onClick="DoActionPrecio(
        '<?php echo $reg[0]['idproducto']; ?>',
        '<?php echo $reg[0]['codproducto']; ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['producto']); ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['descripcion'] == '' ? "0" : $reg[0]['descripcion']); ?>',
        '<?php echo $_GET['d_opcionimei']; ?>',
        '<?php echo $_GET['d_imei']; ?>',
        '<?php echo $reg[0]['condicion'] == '' ? "******" : $reg[0]['condicion']; ?>',
        '<?php echo $reg[0]['codmarca']; ?>',
        '<?php echo $reg[0]['codmarca'] == 0 ? "******" : $reg[0]['nommarca']; ?>',
        '<?php echo $reg[0]['codmodelo']; ?>',
        '<?php echo $reg[0]['codmodelo'] == 0 ? "******" : $reg[0]['nommodelo']; ?>',
        '<?php echo $reg[0]['codpresentacion']; ?>',
        '<?php echo $reg[0]['codpresentacion'] == 0 ? "******" : $reg[0]['nompresentacion']; ?>',
        '<?php echo $reg[0]['codcolor']; ?>',
        '<?php echo $reg[0]['codcolor'] == 0 ? "******" : $reg[0]['nomcolor']; ?>',
        '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $posicionimpuesto = ($reg[0]['ivaproducto'] != '0' ? $reg[0]['posicionimpuesto'] : "0"); ?>',
        '<?php echo $tipoimpuesto = ($reg[0]['ivaproducto'] != '0' ? $reg[0]['nomimpuesto'] : "EXENTO"); ?>',
        '<?php echo $ivaproducto = ($reg[0]['ivaproducto'] != '0' ? number_format($reg[0]['valorimpuesto'], 2, '.', '') : "0"); ?>',
        '<?php echo number_format($reg[0]['existencia'], 2, '.', ''); ?>',
        '<?php if($reg[0]['ivaproducto'] != '0'){ ?>'+document.getElementById('precioventa').value+'<?php } else { echo "0.00"; } ?>',
        '<?php echo "1"; ?>');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
      </div>

<?php } elseif(limpiar($_GET['d_tipo'] == 2)){ 

$reg = $new->DetallesComboPorId();
?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Combo: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $reg[0]['nomcombo']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Precio: <span class="symbol required"></span></label>
            <br /><abbr title="Precio de Combo"><label id="d_precioventa"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>
<?php 
$tru = new Login();
$a=1;
$busq = $tru->DetallesProductosxCombo(); 

if($busq==""){
  echo "";      
} else {
?>
<!----><div id="div">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10" width="100%">
    <thead>
    <tr>
    <th colspan="6" data-priority="1"><center>Productos del Combo</center></th>
    </tr>
    <tr>
      <th>Nº</th>
      <th>Producto</th>
      <th>Cantidad</th>
    </tr>
    </thead>
    <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
?>
    <tr>
    <th><?php echo $a++; ?></th>
      <td><?php echo $busq[$i]["producto"]; ?></td>
      <td><?php echo $busq[$i]["cantidad"]; ?></td>
    </tr> 
    <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>

    <div class="row m-t-5">
      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Precio de Venta: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Venta" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>

      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Descuento de Producto: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>
    </div> 

    <div class="modal-footer">
      <button type="button" onClick="DoActionPrecio(
        '<?php echo $reg[0]['idcombo']; ?>',
        '<?php echo $reg[0]['codcombo']; ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['nomcombo']); ?>',
        '<?php echo $_GET['d_opcionimei']; ?>',
        '<?php echo $_GET['d_imei']; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $posicionimpuesto = ($reg[0]['ivacombo'] != '0' ? $reg[0]['posicionimpuesto'] : "0"); ?>',
        '<?php echo $tipoimpuesto = ($reg[0]['ivacombo'] != '0' ? $reg[0]['nomimpuesto'] : "EXENTO"); ?>',
        '<?php echo $ivaproducto = ($reg[0]['ivacombo'] != '0' ? number_format($reg[0]['valorimpuesto'], 2, '.', '') : "0"); ?>',
        '<?php echo number_format($reg[0]['existencia'], 2, '.', ''); ?>',
        '<?php if($reg[0]['ivacombo'] != '0'){ ?>'+document.getElementById('precioventa').value+'<?php } else { echo "0.00"; } ?>',
        '2');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>

<?php } elseif(limpiar($_GET['d_tipo'] == 3)){ ?>

    <div class="row">
      <div class="col-md-2">
        <div class="form-group has-feedback">
          <label class="control-label">Cantidad: <span class="symbol required"></span></label>
          <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
        </div>
      </div>

      <div class="col-md-10">
        <div class="form-group has-feedback">
          <label class="control-label">Descripción de Servicio: <span class="symbol required"></span></label>
          <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $_GET['d_producto']; ?></label></abbr>
        </div>
      </div>
    </div>

    <div class="row m-t-5">
      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Precio de Venta: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Venta" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>

      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Descuento de Servicio: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>
    </div> 

    <div class="modal-footer">
      <button type="button" onClick="DoActionPrecio(
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo str_replace($stringReplace, '', $_GET['d_producto']); ?>',
        '<?php echo $_GET['d_opcionimei']; ?>',
        '<?php echo $_GET['d_imei']; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0.00"; ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $posicionimpuesto = ("0"); ?>',
        '<?php echo $tipoimpuesto = ("EXENTO"); ?>',
        '<?php echo $ivaproducto = ("0"); ?>',
        '<?php echo number_format(0.00, 2, '.', ''); ?>',
        '<?php echo "0.00"; ?>',
        '3');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>

<?php } //fin de if ?>

<!--<?php if($variable == 0){ ?>
<script type="text/javascript" src="assets/script/jsposcompras.js"></script>
<?php } else if($variable == 1){ ?>
<script type="text/javascript" src="assets/script/jsposopcion1.js"></script>
<?php } else if($variable == 2){ ?>
<script type="text/javascript" src="assets/script/jsposopcion2.js"></script>
<?php } else if($variable == 3){ ?>
<script type="text/javascript" src="assets/script/jscotizaciones.js"></script>
<?php } else if($variable == 4){ ?>
<script type="text/javascript" src="assets/script/jspreventas.js"></script>
<?php } else if($variable == 5){ ?>
<script type="text/javascript" src="assets/script/jsventas.js"></script>
<?php } ?>-->

<?php
} 
######################## BUSQUEDA DETALLE DE PRODUCTO PARA PRECIO ########################
?>


<?php
######################## BUSQUEDA DETALLE DE PRODUCTO PARA IMEI #######################
if (isset($_GET['BuscaDetallesProductoxImei']) && isset($_GET['variable']) && isset($_GET['d_id']) && isset($_GET['d_codigo']) && isset($_GET['d_tipo']) && isset($_GET['d_producto']) && isset($_GET['d_opcionimei']) && isset($_GET['d_imei']) && isset($_GET['d_cantidad']) && isset($_GET['d_precio']) && isset($_GET['d_descproducto'])) {

$variable = limpiar($_GET['variable']); 
$explode  = explode(",", $_GET['d_imei']);

if(limpiar($_GET['d_tipo'] == 1)){ 

$reg = $new->DetallesProductoPorId();
?>
    <div class="row">
      <div class="col-md-2">
        <div class="form-group has-feedback">
          <label class="control-label">Cantidad: <span class="symbol required"></span></label>
          <br /><abbr title="Cantidad de Producto"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
        </div>
      </div>

      <div class="col-md-10">
        <div class="form-group has-feedback">
          <label class="control-label">Descripción de Producto: <span class="symbol required"></span></label>
          <br /><abbr title="Descripción de Producto"><label id="d_producto" name="d_producto"><?php echo $reg[0]['producto']." ".$reg[0]["condicion"].$descripcion = ($reg[0]["descripcion"] != "" ? "<br>".$reg[0]["descripcion"] : ""); ?></label></abbr>
        </div>
      </div>
    </div>

    <?php if($_GET['d_opcionimei'] == 'NO' || $_GET['d_opcionimei'] == '0'){ 

      echo "<div class='alert alert-danger'>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
      echo "<center><span class='fa fa-info-circle'></span> ESTE DETALLE NO SE PUEDE ASIGNAR IMEI, VERIFIQUE NUEVAMENTE POR FAVOR</center>";
      echo "</div>";   
      exit;

    } else { ?>

    <hr><div class="table-responsive"><table id="html5-extension" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row" class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
      <th>...</th>
      <th>Nº</th>
      <th>Imei</th>
      <th>Estado</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">
    <?php 
    $imei = new Login();
    $busq = $imei->ListarImeiActivos();

    if($busq==""){
        
      echo "";

    } else {
     
    $a=1;
    $v=1;
    for($i=0;$i<sizeof($busq);$i++){ 
    $v++; 
    ?>
    <tr role="row" class="odd">
    <td><div class="n-chk">
            <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
            <input type="checkbox" class="new-control-input" name="nomimei[]" id="nomimei_<?php echo $v; ?>" value="<?php echo $nombre = str_replace(" ", "_", $busq[$i]['numeroimei']); ?>" <?php echo $var = in_array($nombre, $explode) ? "checked=\"checked\"" : ""; ?> onClick="CargaDetallesImei(document.getElementById('nomimei_<?php echo $v; ?>').value); EnviaCheckbox('<?php echo $v; ?>','<?php echo encrypt($busq[$i]['codimei']); ?>','<?php echo encrypt("ESTADOIMEI") ?>');">
              <span class="new-control-indicator"></span><span class="text-white"><?php echo $busq[$i]['codimei']; ?></span>
            </label>
        </div>
    </td>
    <td><?php echo $a++; ?></td>
    <td class="text-dark alert-link"><?php echo $busq[$i]['numeroimei']; ?></td>
    <td><?php
    $estado = $busq[$i]["estadoimei"];        
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
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
    <hr>
    <?php } ?>
    <input type="hidden" name="detalles_imei" id="detalles_imei" value="<?php echo $_GET['d_imei']; ?>" />

    <div class="modal-footer">
      <button type="button" onClick="DoActionImei(
      '<?php echo $reg[0]['idproducto']; ?>',
      '<?php echo $reg[0]['codproducto']; ?>',
      '<?php echo str_replace($stringReplace, '', $reg[0]['producto']); ?>',
      '<?php echo str_replace($stringReplace, '', $reg[0]['descripcion'] == '' ? "0" : $reg[0]['descripcion']); ?>',
      '<?php echo $_GET['d_opcionimei']; ?>',
      document.getElementById('detalles_imei').value,
      '<?php echo $reg[0]['condicion'] == '' ? "******" : $reg[0]['condicion']; ?>',
      '<?php echo $reg[0]['codmarca']; ?>',
      '<?php echo $reg[0]['codmarca'] == 0 ? "******" : $reg[0]['nommarca']; ?>',
      '<?php echo $reg[0]['codmodelo']; ?>',
      '<?php echo $reg[0]['codmodelo'] == 0 ? "******" : $reg[0]['nommodelo']; ?>',
      '<?php echo $reg[0]['codpresentacion']; ?>',
      '<?php echo $reg[0]['codpresentacion'] == 0 ? "******" : $reg[0]['nompresentacion']; ?>',
      '<?php echo $reg[0]['codcolor']; ?>',
      '<?php echo $reg[0]['codcolor'] == 0 ? "******" : $reg[0]['nomcolor']; ?>',
      '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
      '<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>',
      '<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>',
      '<?php echo $posicionimpuesto = ($reg[0]['ivaproducto'] != '0' ? $reg[0]['posicionimpuesto'] : "0"); ?>',
      '<?php echo $tipoimpuesto = ($reg[0]['ivaproducto'] != '0' ? $reg[0]['nomimpuesto'] : "EXENTO"); ?>',
      '<?php echo $ivaproducto = ($reg[0]['ivaproducto'] != '0' ? number_format($reg[0]['valorimpuesto'], 2, '.', '') : "0"); ?>',
      '<?php echo number_format($reg[0]['existencia'], 2, '.', ''); ?>',
      '<?php echo $precioconiva = ($reg[0]['ivaproducto'] != '0' ? number_format($_GET['d_precio'], 2, '.', '') : "0.00"); ?>',
      '<?php echo "1"; ?>');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>

<?php } elseif(limpiar($_GET['d_tipo'] == 2)){ 

$reg = $new->DetallesComboPorId();
?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Combo: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $reg[0]['nomcombo']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Precio: <span class="symbol required"></span></label>
            <br /><abbr title="Precio de Combo"><label id="d_precioventa"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>

      <?php if($_GET['d_opcionimei'] == 'NO' || $_GET['d_opcionimei'] == '0'){ 
        echo "<div class='alert alert-danger'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
        echo "<center><span class='fa fa-info-circle'></span> ESTE DETALLE NO SE PUEDE ASIGNAR IMEI, VERIFIQUE NUEVAMENTE POR FAVOR</center>";
        echo "</div>";   
        exit;
      } ?>

    <div class="modal-footer">
      <button type="button" onClick="DoActionImei(
        '<?php echo $reg[0]['idcombo']; ?>',
        '<?php echo $reg[0]['codcombo']; ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['nomcombo']); ?>',
        '<?php echo $_GET['d_opcionimei']; ?>',
        '<?php echo $_GET['d_imei']; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $posicionimpuesto = ($reg[0]['ivacombo'] != '0' ? $reg[0]['posicionimpuesto'] : "0"); ?>',
        '<?php echo $tipoimpuesto = ($reg[0]['ivacombo'] != '0' ? $reg[0]['nomimpuesto'] : "EXENTO"); ?>',
        '<?php echo $ivaproducto = ($reg[0]['ivacombo'] != '0' ? number_format($reg[0]['valorimpuesto'], 2, '.', '') : "0"); ?>',
        '<?php echo number_format($reg[0]['existencia'], 2, '.', ''); ?>',
        '<?php if($reg[0]['ivacombo'] != '0'){ ?>'+document.getElementById('precioventa').value+'<?php } else { echo "0.00"; } ?>',
        '2');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>

<?php } elseif(limpiar($_GET['d_tipo'] == 3)){ ?>

    <div class="row">
      <div class="col-md-2">
        <div class="form-group has-feedback">
          <label class="control-label">Cantidad: <span class="symbol required"></span></label>
          <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
        </div>
      </div>

      <div class="col-md-10">
        <div class="form-group has-feedback">
          <label class="control-label">Descripción de Servicio: <span class="symbol required"></span></label>
          <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $_GET['d_producto']; ?></label></abbr>
        </div>
      </div>
    </div>

    <?php if($_GET['d_opcionimei'] == 'NO' || $_GET['d_opcionimei'] == '0'){ 
      echo "<div class='alert alert-danger'>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
      echo "<center><span class='fa fa-info-circle'></span> ESTE DETALLE NO SE PUEDE ASIGNAR IMEI, VERIFIQUE NUEVAMENTE POR FAVOR</center>";
      echo "</div>";   
      exit;
    } ?>

    <div class="modal-footer">
      <button type="button" onClick="DoActionImei(
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo str_replace($stringReplace, '', $_GET['d_producto']); ?>',
        '<?php echo $_GET['d_opcionimei']; ?>',
        '<?php echo $_GET['d_imei']; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0.00"; ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $posicionimpuesto = ("0"); ?>',
        '<?php echo $tipoimpuesto = ("EXENTO"); ?>',
        '<?php echo $ivaproducto = ("0"); ?>',
        '<?php echo number_format(0.00, 2, '.', ''); ?>',
        '<?php echo "0.00"; ?>',
        '3');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>

<?php 
  } //fin de if
} 
######################## BUSQUEDA DETALLE DE PRODUCTO PARA IMEI ########################
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
        "lengthMenu": [15, 20, 50, 100],
        "pageLength": 15,
        drawCallback: function () { 
            $('.dataTables_paginate > .pagination').addClass('pagination-style-13 pagination-bordered mb-5');
        }
    });
});
</script>
<!-- END PAGE LEVEL CUSTOM SCRIPTS -->