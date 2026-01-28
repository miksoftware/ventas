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

######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
if (isset($_GET['MuestraDatosProductos']) && isset($_GET['sucursal']) && isset($_GET['barcode'])) { 

$reg = $new->VerificadorProductosPorId();

if(empty(!$reg)){
?>
    <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png")){   
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png?' style='margin:0px;' width='300' height='200'>";
        } else {
          echo "<img src='fotos/default.png' style='margin:0px;' width='300' height='200'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1 class="text-danger alert-link"># <?php echo $reg[0]['codproducto']; ?></h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link"><?php echo $reg[0]['producto']; ?></h2>
        <h4 class="text-danger alert-link"><?php echo $marca = ($reg[0]['codmarca'] == 0 ? "": $reg[0]['nommarca']); ?> <?php echo $modelo = ($reg[0]['codmodelo'] == 0 ? "": " - ".$reg[0]['nommodelo']); ?></h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 class="text-dark alert-link">P.V.MIN: <?php echo number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 class="text-dark alert-link">P.V.MAY: <?php echo number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 class="text-dark alert-link">P.V.P: <?php echo number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></h3>
      </div>
    </div>

    </center>

<?php 
  }
}
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
?>



<?php 
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
if (isset($_GET['MuestraDatosProductos2']) && isset($_GET['sucursal']) && isset($_GET['barcode'])) { 

$reg = $new->VerificadorProductosPorId();

if(empty(!$reg)){
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de Producto</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

    <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png")){   
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png?' style='margin:0px;' width='300' height='200'>";
        } else {
          echo "<img src='fotos/default.png' style='margin:0px;' width='300' height='200'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1 class="text-danger alert-link"># <?php echo $reg[0]['codproducto']; ?></h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1 class="text-dark alert-link"><?php echo $reg[0]['producto']; ?></h1>
        <h3 class="text-danger alert-link"><?php echo $marca = ($reg[0]['codmarca'] == 0 ? "": $reg[0]['nommarca']); ?> <?php echo $modelo = ($reg[0]['codmodelo'] == 0 ? "": " - ".$reg[0]['nommodelo']); ?></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link">P.V.MIN: <?php echo number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link">P.V.MAY: <?php echo number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link">P.V.P: <?php echo number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></h2>
      </div>
    </div>

    </center>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php 
  }
}
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
?>


<?php 
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['BuscaDepartamentos']) && isset($_GET['id_provincia'])) {
  
  $departamento = $new->ListarDepartamentoXProvincias();
  $id_provincia = limpiar($_GET['id_provincia']);

  if($id_provincia == "" || empty($departamento)){ ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>

  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($departamento);$i++){
  ?>
  <option style="color:#000;font-weight:bold;" value="<?php echo $departamento[$i]['id_departamento']; ?>" ><?php echo $departamento[$i]['departamento']; ?></option>
    <?php 
    }
  }
}
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
?>

<?php 
######################## SELECCIONE DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['SeleccionaDepartamento']) && isset($_GET['id_provincia']) && isset($_GET['id_departamento'])) {
  
  $departamento = $new->SeleccionaDepartamento();
  ?>
  </div>
  </div>
  <option value="">SELECCIONE</option>
  <?php for($i=0;$i<sizeof($departamento);$i++){ ?>
  <option value="<?php echo $departamento[$i]['id_departamento']; ?>"<?php if (!(strcmp($_GET['id_departamento'], htmlentities($departamento[$i]['id_departamento'])))) {echo "selected=\"selected\"";} ?>><?php echo $departamento[$i]['departamento']; ?></option>
<?php
  } 
}
######################## SELECCIONE DEPARTAMENTOS POR PROVINCIAS ########################
?>





<?php 
######################## BUSCA SUBFAMILIAS POR FAMILIAS ########################
if (isset($_GET['BuscaSubfamilias']) && isset($_GET['codfamilia'])) {
  
$subfamilia = $new->ListarSubfamilias2();

$codfamilia = limpiar($_GET['codfamilia']);

 if($codfamilia=="" || empty($subfamilia)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($subfamilia);$i++){
  ?>
  <option value="<?php echo encrypt($subfamilia[$i]['codsubfamilia']); ?>" ><?php echo $subfamilia[$i]['nomsubfamilia']; ?></option>
<?php 
    } 
  }
}
######################## BUSCA SUBFAMILIAS POR FAMILIAS ########################
?>




<?php 
######################## BUSCA MARCAS X SUCURSAL ########################
if (isset($_GET['BuscaMarcasxSucursal']) && isset($_GET['codsucursal']) && isset($_GET['codmarca'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codmarca = limpiar($_GET['codmarca']);
  $marca = $new->ListarMarcas();

  if($codsucursal == "" || $codmarca == "" || empty($marca)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($marca);$i++){
  ?>
  <option value="<?php echo encrypt($marca[$i]['codmarca']); ?>"<?php if (!(strcmp(decrypt($_GET['codmarca']), htmlentities($marca[$i]['codmarca'])))) { echo "selected=\"selected\"";} ?>><?php echo $marca[$i]['nommarca']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MARCAS X SUCURSAL #############################
?>

<?php 
######################## BUSCA MODELOS POR MARCAS ########################
if (isset($_GET['BuscaModelos']) && isset($_GET['codmarca'])) {
  
  $codmarca = limpiar($_GET['codmarca']);
  $modelo = $new->ListarModelosxMarcas();

  if($codmarca == "" || empty($modelo)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($modelo);$i++){
  ?>
  <option value="<?php echo encrypt($modelo[$i]['codmodelo']); ?>" ><?php echo $modelo[$i]['nommodelo']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MODELOS POR MARCAS #############################
?>

<?php 
######################## BUSCA MODELOS #2 POR MARCAS ########################
if (isset($_GET['BuscaModelos2']) && isset($_GET['codmarca2'])) {
  
  $codmarca = limpiar($_GET['codmarca2']);
  $modelo = $new->ListarModelos2xMarcas();

  if($codmarca == "" || empty($modelo)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($modelo);$i++){
  ?>
  <option value="<?php echo encrypt($modelo[$i]['codmodelo']); ?>" ><?php echo $modelo[$i]['nommodelo']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MODELOS #2 POR MARCAS #############################
?>


<?php 
######################## BUSCA FAMILIAS X SUCURSAL ########################
if (isset($_GET['BuscaFamiliasxSucursal']) && isset($_GET['codsucursal']) && isset($_GET['codfamilia'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codfamilia = limpiar($_GET['codfamilia']);
  $familia = $new->ListarFamilias();

  if($codsucursal == "" || $codfamilia == "" || empty($familia)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($familia);$i++){
  ?>
  <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"<?php if (!(strcmp(decrypt($_GET['codfamilia']), htmlentities($familia[$i]['codfamilia'])))) { echo "selected=\"selected\"";} ?>><?php echo $familia[$i]['nomfamilia']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA FAMILIAS X SUCURSAL #############################
?>

<?php 
######################## BUSCA PRESENTACIONES X SUCURSAL ########################
if (isset($_GET['BuscaPresentacionesxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $presentacion = $new->ListarPresentaciones();

  if($codsucursal == "" || empty($presentacion)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($presentacion);$i++){
  ?>
  <option value="<?php echo encrypt($presentacion[$i]['codpresentacion']); ?>"><?php echo $presentacion[$i]['nompresentacion']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA PRESENTACIONES X SUCURSAL #############################
?>

<?php 
######################## BUSCA COLORES X SUCURSAL ########################
if (isset($_GET['BuscaColoresxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $color = $new->ListarColores();

  if($codsucursal == "" || empty($color)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($color);$i++){
  ?>
  <option value="<?php echo encrypt($color[$i]['codcolor']); ?>"><?php echo $color[$i]['nomcolor']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA COLORES X SUCURSAL #############################
?>

<?php 
######################## BUSCA ORIGENES X SUCURSAL ########################
if (isset($_GET['BuscaOrigenesxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $origen = $new->ListarOrigenes();

  if($codsucursal == "" || empty($origen)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($origen);$i++){
  ?>
  <option value="<?php echo encrypt($origen[$i]['codorigen']); ?>"><?php echo $origen[$i]['nomorigen']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA ORIGENES X SUCURSAL #############################
?>

<?php 
######################## BUSCA IMPUESTOS X SUCURSAL ########################
if (isset($_GET['BuscaImpuestosxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $impuesto = $new->ListarImpuestos();

  if($codsucursal == "" || empty($impuesto)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <option value="<?php echo encrypt("0"); ?>"> EXENTO 0% </option>
  <?php
  for($i=0;$i<sizeof($impuesto);$i++){
  ?>
  <option value="<?php echo encrypt($impuesto[$i]['codimpuesto']); ?>"><?php echo $impuesto[$i]['nomimpuesto']." (".$impuesto[$i]['valorimpuesto']." %)"; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA IMPUESTOS X SUCURSAL #############################
?>

<?php 
######################## BUSCA PROVEEDORES X SUCURSAL ########################
if (isset($_GET['BuscaProveedoresxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $proveedor = $new->ListarProveedores();

  if($codsucursal == "" || empty($proveedor)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($proveedor);$i++){
  ?>
  <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>"><?php echo $proveedor[$i]['nomproveedor']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA PROVEEDORES X SUCURSAL #############################
?>

<?php 
######################## BUSCA PROVEEDORES ########################
if (isset($_GET['BuscaProveedores'])) {
  
$proveedor = $new->ListarProveedores();
?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($proveedor);$i++){
  ?>
  <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>" ><?php echo $proveedor[$i]['nomproveedor']; ?></option>
<?php 
  } 
}
######################## BUSCA PROVEEDORES ########################
?>

<?php 
######################## BUSCA MEDIOS PAGOS X SUCURSAL ########################
if (isset($_GET['BuscaMediosPagosxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $mediopago = $new->ListarMediosPagos();

  if($codsucursal == "" || empty($mediopago)) { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($mediopago);$i++){
  ?>
  <option value="<?php echo encrypt($mediopago[$i]['codmediopago']); ?>"><?php echo $mediopago[$i]['mediopago']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MEDIOS PAGOS X SUCURSAL #############################
?>

<?php 
######################## BUSCA PRECIOS DE PRODUCTO ########################
if (isset($_GET['BuscaPreciosProductos']) && isset($_GET['idproducto'])) {
  
$idproducto = limpiar($_GET['idproducto']);
$producto   = $new->BuscarPrecioProductoxCodigo();

if($idproducto=="" || empty($producto)) { ?>

<option style="color:#000;font-weight:bold;" value=""> -- SIN RESULTADOS -- </option>
  
<?php } else { ?>

<option style="color:#000;font-weight:bold;" value=""> -- SELECCIONE -- </option>

<?php
$explode     = explode("|",$producto[0]['precioventa']);
$listaSimple = array_values(array_unique($explode));
# Recorremos el array para despues separar en 2 partes.
for($cont=0; $cont<COUNT($listaSimple); $cont++):
list($nombre,$precio) = explode("_",$listaSimple[$cont]);
?>
<option style="color:#000;font-weight:bold;" value="<?php echo number_format($precio, 2, '.', ''); ?>"<?php if (!(strcmp("PRECIO PUBLICO", htmlentities($nombre)))) { echo "selected=\"selected\""; } ?>><?php echo $nombre.": ".number_format($precio, 2, '.', ''); ?></option>
    <?php 
    endfor;
    //}
  }
}
######################## BUSCA PRECIOS DE PRODUCTO ########################
?>


<?php 
######################## BUSCA PRECIOS DE COMBO ########################
if (isset($_GET['BuscaPreciosCombos']) && isset($_GET['idcombo'])) {
  
$idcombo = limpiar($_GET['idcombo']);
$combo = $new->BuscarPrecioComboxCodigo();

if($idcombo == "" || empty($combo)) { ?>

<option style="color:#000;font-weight:bold;" value=""> -- SIN RESULTADOS -- </option>
  
<?php } else { ?>

<option style="color:#000;font-weight:bold;" value=""> -- SELECCIONE -- </option>

<?php
$explode     = explode("|",$combo[0]['precioventa']);
$listaSimple = array_values(array_unique($explode));
# Recorremos el array para despues separar en 2 partes.
for($cont=0; $cont<COUNT($listaSimple); $cont++):
list($nombre,$precio) = explode("_",$listaSimple[$cont]);
?>
<option style="color:#000;font-weight:bold;" value="<?php echo number_format($precio, 2, '.', ''); ?>"<?php if (!(strcmp("PRECIO PUBLICO", htmlentities($nombre)))) { echo "selected=\"selected\""; } ?>><?php echo $nombre.": ".number_format($precio, 2, '.', ''); ?></option>
    <?php 
    endfor;
    //}
  }
}
######################## BUSCA PRECIOS DE COMBO ########################
?>


<?php
########################## MOSTRAR USUARIO EN VENTANA MODAL ###########################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) { 
$reg = $new->UsuariosPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nº de Documento:</strong> <?php echo $reg[0]['dni']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres y Apellidos:</strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo:</strong> <?php echo $reg[0]['sexo']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria:</strong>  <?php echo $reg[0]['direccion']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono:</strong>  <?php echo $reg[0]['telefono']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico:</strong>  <?php echo $reg[0]['email']; ?></td>
  </tr>
  <tr>
    <td><strong>Usuario de Acceso: </strong> <?php echo $reg[0]['usuario']; ?></td>
  </tr>
  <tr>
    <td><strong>Nivel de Acceso:</strong>  <?php echo $reg[0]['nivel']; ?></td>
  </tr>
  <?php if($_SESSION['acceso']=="administradorG"){ ?>
  <tr>
    <td><strong>Sucursal Asignada:</strong>  <?php echo $reg[0]['codsucursal'] == '' ? "******" : $reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
  <tr>
  <td><strong>Status de Acceso: </strong> <?php echo $status = ( $reg[0]['status'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
</table>  

  <?php
   } 
######################### MOSTRAR USUARIO EN VENTANA MODAL ############################
?>

<?php 
########################## BUSCA USUARIOS POR SUCURSALES #############################
if (isset($_GET['BuscaUsuariosxSucursal']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"><?php echo $usuario[$i]['dni'].": ".$usuario[$i]['nombres'].": ".$usuario[$i]['nivel']; ?></option>
    <?php 
   } 
}
############################# BUSCA USUARIOS POR SUCURSALES ##########################
?>


<?php 
######################## SELECCIONE USUARIOS POR SUCURSALES ########################
if (isset($_GET['MuestraUsuario']) && isset($_GET['codigo']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"<?php if (!(strcmp($_GET['codigo'], htmlentities($usuario[$i]['codigo'])))) { echo "selected=\"selected\"";} ?>><?php echo $usuario[$i]['nombres'].": ".$usuario[$i]['nivel']; ?></option>
<?php
   } 
}
######################## SELECCIONE USUARIOS POR SUCURSALES #######################
?>

<!--########################### LISTAR SUCURSALES ##########################-->
<?php if (isset($_GET['MuestraSucursalesUsuarios']) && isset($_GET['nivel'])): ?>

<?php 
$sucursal = new Login();
$suc = $sucursal->ListarSucursales();

if($suc==""){  

} else if($_SESSION['acceso'] == "administradorG" && $_GET['nivel'] == "ADMINISTRADOR(A) SUCURSAL"){  
?>

<h2 class="card-subtitle text-dark"><i class="font-22 mdi mdi-bank"></i> Sucursales Asociadas para Traspasos</h2><hr>

<div class="row"> 
              
<?php
$a=1;
for($i=0;$i<sizeof($suc);$i++){ 
?>

    <div class="col-md-4 m-t-10">
        <div class="form-check">
            <div class="custom-control custom-radio">
                <input type="checkbox" class="custom-control-input" name="gruposid[]" id="gruposid_<?php echo $suc[$i]['codsucursal']; ?>" value="<?php echo $suc[$i]['codsucursal']; ?>">
                <label class="custom-control-label" for="gruposid_<?php echo $suc[$i]['codsucursal']; ?>">
                <?php echo $suc[$i]['nomsucursal']; ?>
                </label>
            </div>
        </div>
    </div>
    <?php } ?>
    </div> 
<?php } ?>

<?php endif; ?>
<!--########################### LISTAR SUCURSALES ##########################-->

<!--########################### LISTAR SUCURSALES ASIGNADAS POR USUARIO ##########################-->
<?php if (isset($_GET['MuestraSucursalesAsignadasxUsuarios']) && isset($_GET['codigo']) && isset($_GET['nivel']) && isset($_GET['gruposid'])): ?>

<?php 
$sucursal = new Login();
$suc = $sucursal->ListarSucursales();

if($suc==""){  

} else if($_SESSION['acceso'] == "administradorG" && $_GET['nivel'] == "ADMINISTRADOR(A) SUCURSAL"){  
?>

<h2 class="card-subtitle text-dark"><i class="font-22 mdi mdi-bank"></i> Sucursales Asociadas para Traspasos</h2><hr>

<div class="row"> 
              
<?php
$a=1;
for($i=0;$i<sizeof($suc);$i++){ 
?>
    <div class="col-md-4 m-t-10">
        <div class="form-check">
            <div class="custom-control custom-radio">
                <input type="checkbox" class="custom-control-input" name="gruposid[]" id="gruposid_<?php echo $suc[$i]['codsucursal'] ?>" value="<?php echo $suc[$i]['codsucursal']; ?>" <?php 
                  $explode = explode(", ", $_GET['gruposid']);
                  foreach($explode as $meschecked){
                  echo $meschecked == $suc[$i]['codsucursal'] ? "checked=\"checked\"":'';  } ?>>
                <label class="custom-control-label" for="gruposid_<?php echo $suc[$i]['codsucursal']; ?>">
                <?php echo $suc[$i]['nomsucursal']; ?>
                </label>
            </div>
        </div>
    </div>
    <?php } ?>
</div> 
<?php } ?>

<?php endif; ?>
<!--########################### LISTAR SUCURSALES ASIGNADAS POR USUARIO ##########################-->








<?php
######################### MOSTRAR SUCURSAL EN VENTANA MODAL ##########################
if (isset($_GET['BuscaSucursalModal']) && isset($_GET['codsucursal'])) { 

$reg = $new->SucursalesPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documsucursal'] == '0' ? "Documento" : $reg[0]['documento'] ?>: </strong> <?php echo $reg[0]['cuitsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Sucursal:</strong>  <?php echo $reg[0]['nomsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Provincia:</strong>  <?php echo $reg[0]['id_provincia'] == '0' ? "******" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Departamento:</strong>  <?php echo $reg[0]['id_departamento'] == '0' ? "******" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Sucursal:</strong>  <?php echo $reg[0]['direcsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico:</strong>  <?php echo $reg[0]['correosucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Teléfono:</strong>  <?php echo $reg[0]['tlfsucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Ticket:</strong>  <?php echo $reg[0]['inicioticket']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Factura:</strong>  <?php echo $reg[0]['iniciofactura']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Guia:</strong>  <?php echo $reg[0]['inicioguia']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio Nota Venta:</strong>  <?php echo $reg[0]['inicionotaventa']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio Nota Credito: </strong> <?php echo $reg[0]['inicionotacredito']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Actividad:</strong>  <?php echo $reg[0]['nroactividadsucursal']; ?></td>
  </tr>  
  <tr>
    <td><strong>Fecha de Autorización: </strong> <?php echo $reg[0]['fechaautorsucursal'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal'])); ?></td>
  </tr> 
  <tr>
    <td><strong>Lleva Contabilidad:</strong>  <?php echo $reg[0]['llevacontabilidad']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº <?php echo $reg[0]['documencargado'] == '0' ? "Documento" : $reg[0]['documento2'] ?> de Encargado:</strong> <?php echo $reg[0]['dniencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Encargado:</strong> <?php echo $reg[0]['nomencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono:</strong> <?php echo $reg[0]['tlfencargado'] == '' ? "******" : $reg[0]['tlfencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Descuento Global en Ventas:</strong>  <?php echo number_format($reg[0]['descsucursal'], 2, '.', ','); ?>%</td>
  </tr> 
  <tr>
    <td><strong>Porcentaje para Calcular Precio Venta:</strong>  <?php echo number_format($reg[0]['porcentaje'], 2, '.', ','); ?>%</td>
  </tr>   
  <tr>
    <td><strong>Moneda Nacional:</strong>  <?php echo $reg[0]['codmoneda'] == '0' ? "******" : $reg[0]['moneda']; ?></td>
  </tr> 
  <tr>
    <td><strong>Moneda Tipo de Cambio:</strong> <?php echo $reg[0]['codmoneda2'] == '0' ? "******" : $reg[0]['moneda2']; ?></td>
  </tr>
  <td><strong>Estado:</strong> <?php echo $status = ($reg[0]['estado'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVA</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> INACTIVA</span>"); ?></td>
  </tr> 
</table>
<?php 
} 
######################### MOSTRAR SUCURSAL EN VENTANA MODAL #########################
?>






<?php 
############################# MUESTRA DIV CLIENTE #############################
if (isset($_GET['BuscaDivCliente'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"> Para poder realizar la Carga Masiva de Clientes, el archivo Excel, debe estar estructurado de 12 columnas, la cuales tendrán las siguientes especificaciones:</font><br>

  1. Tipo de Cliente (Opciones: NATURAL/JURIDICO).<br>
  2. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  3. Nº de Documento.<br>
  4. Nombre de Cliente (Ingresar Nombre completo con Apellidos).<br>
  5. Razón Social (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  6. Giro de Cliente (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  7. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  8. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  9. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  10. Dirección Domiciliaria.<br>
  11. Correo Electronico.<br>
  12. Limite de Crédito en Ventas.<br><br>

  <font color="red"> NOTA:</font><br>
  a) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  b) Descargar Plantilla de Formato para Carga Masiva de Clientes <a class="text-info" href="fotos/clientes.csv">AQUI</a><br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Clientes, deben de ser cargados como se explica, para evitar problemas de datos del cliente dentro del Sistema.<br><br>
   </div>
</div>                               
<?php 
  }
############################ MUESTRA DIV CLIENTE ############################
?>

<?php
########################### MOSTRAR CLIENTE EN VENTANA MODAL ############################
if (isset($_GET['BuscaClienteModal']) && isset($_GET['codcliente'])) { 

$reg = $new->ClientesPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Cliente:</strong>  <?php echo $reg[0]['tipocliente']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documcliente'] == '0' ? "Documento" : $reg[0]['documento'] ?>:</strong> <?php echo $reg[0]['dnicliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres/Razón Social:</strong> <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Giro de Cliente: </strong><?php echo $reg[0]['tipocliente'] == 'NATURAL' ? "******" : $reg[0]['girocliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono:</strong>  <?php echo $reg[0]['tlfcliente'] == '' ? "******" : $reg[0]['tlfcliente'] ?></td>
  </tr>
  <tr>
    <td><strong>Provincia:</strong>  <?php echo $reg[0]['id_provincia'] == '0' ? "******" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Departamento:</strong>  <?php echo $reg[0]['id_departamento'] == '0' ? "******" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria:</strong>  <?php echo $reg[0]['direccliente']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['emailcliente'] == '' ? "******" : $reg[0]['emailcliente'] ?></td>
  </tr>
  <tr>
    <td><strong>Limite de Crédito:</strong>  <?php echo number_format($reg[0]['limitecredito'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Cantidad de Compras:</strong> <?php echo number_format($reg[0]['cantidad'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td><strong>Total en Compras:</strong> <?php echo number_format($reg[0]['totalcompras'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td><strong>Fecha de Ingreso:</strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR CLIENTE EN VENTANA MODAL ###########################
?>













<?php 
############################# MUESTRA DIV PROVEEDOR #############################
if (isset($_GET['BuscaDivProveedor'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"> Para poder realizar la Carga Masiva de Proveedores, el archivo Excel, debe estar estructurado de 10 columnas, la cuales tendrán las siguientes especificaciones:</font><br>

  1. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  2. Nº de Documento.<br>
  3. Nombre de Proveedor (Ingresar Nombre de Proveedor).<br>
  4. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  5. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  6. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  7. Dirección de Proveedor.<br>
  8. Correo Electronico.<br>
  9. Nombre de Vendedor.<br>
  10. Nº de Teléfono de Vendedor. (Formato: (9999) 9999999).<br><br>

  <font color="red"> NOTA:</font><br>
  a) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  b) Descargar Plantilla de Formato para Carga Masiva de Proveedores <a class="text-info" href="fotos/proveedores.csv">AQUI</a>.<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Proveedores, deben de ser cargados como se explica, para evitar problemas de datos del proveedor dentro del Sistema.<br><br>
   </div>
</div>
<?php 
}
############################ MUESTRA DIV PROVEEDOR #############################
?>

<?php
########################### MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) { 

$reg = $new->ProveedoresPorId();
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "Documento" : $reg[0]['documento'] ?>:</strong> <?php echo $reg[0]['cuitproveedor']; ?>:</td>
  </tr>
  <tr>
    <td><strong>Nombres de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono:</strong>  <?php echo $reg[0]['tlfproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['id_provincia'] == '0' ? "******" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Departamento:</strong>  <?php echo $reg[0]['id_departamento'] == '0' ? "******" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Proveedor:</strong>  <?php echo $reg[0]['direcproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico:</strong>  <?php echo $reg[0]['emailproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Vendedor:</strong>  <?php echo $reg[0]['vendedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Teléfono:</strong>  <?php echo $reg[0]['tlfvendedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Ingreso:</strong>  <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
?>





















<?php
########################### MOSTRAR PEDIDOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaPedidoModal']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){ 
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">PEDIDO</b></h4>
  <p class="text-dark alert-link m-l-5">Nº DE FACTURA: #<?php echo $reg[0]['codfactura']; ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechapedido'])); ?>
  <br> OBSERVACIONES: <?php echo $reg[0]['observaciones']; ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">PROVEEDOR</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "******" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "******" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "******" : $reg[0]['departamento']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor'] == '' ? "*******" : $reg[0]['vendedor']; ?>
  <br>TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                </address>
            </div>
        </div>

        <div class="col-md-12">
          <div class="table-responsive m-t-10" style="clear: both;">
              <table class="table">
              <thead>
                  <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                  <th>#</th>
                  <th>Descripción de Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Valor Total</th>
                  <th>Desc %</th>
                  <th>Impuesto</th>
                  <th>Valor Neto</th>
                  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?>
                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPedidos();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo $detalle[$i]['cantidad']; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetallesPedido('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLEPEDIDO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
                  <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                    <div class="clearfix"></div>
                    <hr>

                    <div class="col-md-12">
                        <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codpedido=<?php echo encrypt($reg[0]["codpedido"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO"); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
  <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                        </div>
                      </div>
                  </div>
                <!-- .row -->

<?php
  }
} 
########################## MOSTRAR PEDIDOS EN VENTANA MODAL ############################
?>


<?php
########################## MOSTRAR DETALLES DE PEDIDOS UPDATE ############################
if (isset($_GET['MuestraDetallesPedidoUpdate']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg     = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>

<div class="table-responsive m-t-20">
    <table class="table table-hover">
    <thead>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
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
$detalle = $tra->VerDetallesPedidos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePedido('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedido(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePedido('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
    
  <td class="text-dark alert-link">
  <input type="hidden" name="coddetallepedido[]" id="coddetallepedido" value="<?php echo $detalle[$i]["coddetallepedido"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <?php echo $detalle[$i]['codproducto']; ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link"><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['preciocompra'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
  <td class="text-dark alert-link">
  <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ','); ?>">
  <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
  <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>

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
  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>"><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetallePedido('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','1','<?php echo encrypt("DETALLEPEDIDO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
  </table>
  </div>
<?php
} 
########################## MOSTRAR DETALLES DE PEDIDOS UPDATE #########################
?>

<?php
########################## MOSTRAR DETALLES DE PEDIDOS AGREGAR #########################
if (isset($_GET['MuestraDetallesPedidoAgregar']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
  <table class="table table-hover">
  <thead>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
      <th>Nº</th>
      <th>Código</th>
      <th>Descripción</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Valor Total</th>
      <th>Desc %</th>
      <th>Impuesto</th>
      <th>Valor Neto</th>
      <?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
  </tr>
  </thead>
  <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPedidos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td class="text-dark alert-link"><?php echo $a++; ?></td> 
  <td class="text-danger alert-link"><?php echo $detalle[$i]['codproducto']; ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
  <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetallePedido('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLEPEDIDO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td></td><?php } ?>
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
<?php
} 
########################## MOSTRAR DETALLES DE PEDIDOS AGREGRA #########################
?>

<?php
########################## MOSTRAR DETALLES PARA PROCESAR PEDIDO ############################
if (isset($_GET['MuestraDetallesPedidos']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
  <table class="table">
    <thead>
    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
      <th width="10%;">Cantidad</th>
      <th>Descripción de Producto</th>
      <th>Precio Unitario</th>
      <th>Valor Total</th>
      <th>Desc %</th>
      <th>Total Desc %</th>
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
$detalle = $tra->VerDetallesPedidos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePedidoProcesado('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:40px;height:30px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedidoProcesado(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePedidoProcesado('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
  <td class='text-left'>
  <input type="hidden" name="coddetallepedido[]" id="coddetallepedido" value="<?php echo $detalle[$i]["coddetallepedido"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="producto[]" id="producto" value="<?php echo $detalle[$i]["producto"]; ?>">
  <input type="hidden" name="descripcion[]" id="descripcion" value="<?php echo $detalle[$i]["descripcion"]; ?>">
  <input type="hidden" name="imei[]" id="imei" value="<?php echo $detalle[$i]["imei"]; ?>">
  <input type="hidden" name="condicion[]" id="condicion" value="<?php echo $detalle[$i]["condicion"]; ?>">
  <input type="hidden" name="codmarca[]" id="codmarca" value="<?php echo $detalle[$i]["codmarca"]; ?>">
  <input type="hidden" name="codmodelo[]" id="codmodelo" value="<?php echo $detalle[$i]["codmodelo"]; ?>">
  <input type="hidden" name="codpresentacion[]" id="codpresentacion" value="<?php echo $detalle[$i]["codpresentacion"]; ?>">
  <input type="hidden" name="codcolor[]" id="codcolor" value="<?php echo $detalle[$i]["codcolor"]; ?>">
  <input type="hidden" name="precioxmayor[]" id="precioxmayor" value="<?php echo number_format($detalle[$i]["precioxmayor"], 2, '.', ''); ?>">
  <input type="hidden" name="precioxmenor[]" id="precioxmenor" value="<?php echo number_format($detalle[$i]["precioxmenor"], 2, '.', ''); ?>">
  <input type="hidden" name="precioxpublico[]" id="precioxpublico" value="<?php echo number_format($detalle[$i]["precioxpublico"], 2, '.', ''); ?>">
  <input type="hidden" name="descproducto[]" id="descproducto" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
  <h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
  <td class="text-dark alert-link">
  <input type="text" class="cantidad bold" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedidoProcesado(<?php echo $count; ?>);" autocomplete="off" placeholder="Precio Compra" style="width:80px;height:40px;background:#e7f8fc;border-radius:5px 5px 5px 5px;padding:7px 12px;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc');" title="Ingrese Precio Compra" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>" required="" aria-required="true">
  </td>

  <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
      
  <td class="text-dark alert-link">
  <input type="text" class="cantidad bold" name="descfactura[]" id="descfactura_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedidoProcesado(<?php echo $count; ?>);" autocomplete="off" placeholder="Descuento" style="width:80px;height:40px;background:#e7f8fc;border-radius:5px 5px 5px 5px;padding:7px 12px;" onfocus="this.style.background=('#e7f8fc')" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc');" title="Ingrese Descuento" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ''); ?>" required="" aria-required="true">
  </td>

  <td class="text-dark alert-link">
  <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
  <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?> 
  </td>

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
  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>"><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleProcesarPedido('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','3','<?php echo encrypt("DETALLEPEDIDO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
  </table>
  </div>
<?php
} 
########################## MOSTRAR DETALLES PARA PROCESAR PEDIDO #########################
?>



















<?php 
########################## MOSTRAR FOTO PRODUCTO EN FORMULARIO ##########################
if (isset($_GET['CargaFotoProducto']) && isset($_GET['codproducto'])) { 

  if (file_exists("fotos/productos/".$_SESSION["codsucursal"]."/".$_GET["codproducto"].".jpg")){
    echo "<img src='fotos/productos/".$_SESSION["codsucursal"]."/".$_GET['codproducto'].".jpg?' width='160' height='170'>";
  } else if (file_exists("fotos/productos/".$_SESSION["codsucursal"]."/".$_GET["codproducto"].".jpeg")){
    echo "<img src='fotos/productos/".$_SESSION["codsucursal"]."/".$_GET['codproducto'].".jpeg?' width='160' height='170'>";
  } else if (file_exists("fotos/productos/".$_SESSION["codsucursal"]."/".$_GET["codproducto"].".png")){
    echo "<img src='fotos/productos/".$_SESSION["codsucursal"]."/".$_GET['codproducto'].".png?' width='160' height='170'>";
  } else {
    echo "<img src='fotos/ninguna.png' width='160' height='170'>";  
  }
}
############################# MOSTRAR FOTO PRODUCTO EN FORMULARIO #############################
?>

<?php 
############################# MUESTRA DIV PRODUCTO ############################
if (isset($_GET['BuscaDivProducto'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<div class="alert alert-warning">
<strong><i class="fa fa-info-circle"></i> PLANTILLA SIMPLIFICADA (13 columnas)</strong>
</div>

<p>El archivo CSV debe tener las siguientes columnas separadas por punto y coma (;):</p>

<table class="table table-bordered table-sm">
<thead class="bg-dark text-white">
<tr>
<th>#</th>
<th>Campo</th>
<th>Descripción</th>
<th>Ejemplo</th>
</tr>
</thead>
<tbody>
<tr><td>1</td><td><strong>CODIGO</strong></td><td>Código único del producto</td><td>PROD001</td></tr>
<tr><td>2</td><td><strong>NOMBRE</strong></td><td>Nombre del producto</td><td>ACETAMINOFEN 500MG</td></tr>
<tr><td>3</td><td><strong>DESCRIPCION</strong></td><td>Descripción (puede estar vacío)</td><td>TABLETAS X 10</td></tr>
<tr><td>4</td><td><strong>COD_FAMILIA</strong></td><td>ID de la familia (número)</td><td>1</td></tr>
<tr><td>5</td><td><strong>COD_MARCA</strong></td><td>ID de la marca (0 si no aplica)</td><td>1</td></tr>
<tr><td>6</td><td><strong>PRECIO_COMPRA</strong></td><td>Precio de compra</td><td>10.00</td></tr>
<tr><td>7</td><td><strong>PRECIO_VENTA</strong></td><td>Precio de venta al público</td><td>15.00</td></tr>
<tr><td>8</td><td><strong>EXISTENCIA</strong></td><td>Cantidad inicial (0 para servicios)</td><td>100</td></tr>
<tr><td>9</td><td><strong>COD_IVA</strong></td><td>ID del impuesto (0 = exento)</td><td>1</td></tr>
<tr><td>10</td><td><strong>USA_INVENTARIO</strong></td><td>SI = producto, NO = servicio</td><td>SI</td></tr>
<tr><td>11</td><td><strong>TIPO_COMISION</strong></td><td>NINGUNA, PORCENTAJE o VALOR</td><td>NINGUNA</td></tr>
<tr><td>12</td><td><strong>COMISION_VENTA</strong></td><td>Valor de comisión</td><td>0.00</td></tr>
<tr><td>13</td><td><strong>CODIGO_BARRAS</strong></td><td>Código de barras (opcional, si vacío usa CODIGO)</td><td>7501234567890</td></tr>
</tbody>
</table>

<div class="alert alert-info">
<strong>Notas importantes:</strong><br>
• El archivo debe ser CSV delimitado por punto y coma (;)<br>
• La primera fila debe contener los encabezados<br>
• Para servicios: USA_INVENTARIO=NO y EXISTENCIA=0<br>
• Todos los textos en MAYÚSCULAS para mejor visualización
</div>

<a class="btn btn-success" href="bd-sql/plantilla_productos_simplificada.csv" download><i class="fa fa-download"></i> Descargar Plantilla de Ejemplo</a>

    </div>
</div>                                 
<?php 
}
############################# MUESTRA DIV PRODUCTO #############################
?>

<?php 
########################## MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL ##########################
if (isset($_GET['BuscaFotoProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
  <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."/".$reg[0]["codproducto"].".jpg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."/".$reg[0]["codproducto"].".jpg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."/".$reg[0]["codproducto"].".jpeg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."/".$reg[0]["codproducto"].".jpeg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."/".$reg[0]["codproducto"].".png")){   
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."/".$reg[0]["codproducto"].".png?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else {
          echo "<img src='fotos/img.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Nombre de Producto" class="alert-link"><?php echo $reg[0]['producto']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Código de Producto" class="alert-link"><?php echo $reg[0]['codproducto']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Precio Venta Minorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Mayorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Público" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></abbr>
      </div>
    </div><hr> 
  <?php
  include('fpdf/barcode.php');
  $codigo = $reg[0]["codigobarra"];
  barcode('fpdf/codigos/'.$codigo.'.png', $codigo, 50, 'horizontal', 'code128', true);
  ?>
  <img src="fpdf/codigos/<?php echo $codigo.'.png'; ?>"> 
  </center> 
<?php 
}
############################# MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL #############################
?>

<?php
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Código: <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
    <td>Producto: <?php echo $reg[0]['producto']; ?></td>
  </tr> 
  <tr>
    <td>Descripción: <?php echo $reg[0]['descripcion'] == '' ? "******" : $reg[0]['descripcion']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Imei: <?php echo $reg[0]['imei'] == '' ? "******" : $reg[0]['imei']; ?></td>
  </tr> 
  <tr>
    <td>Condición: <?php echo $reg[0]['condicion'] == '' ? "******" : $reg[0]['condicion']; ?></td>
  </tr>
  <tr>
    <td>Fabricante: <?php echo $reg[0]['fabricante'] == '' ? "******" : $reg[0]['fabricante']; ?></td>
  </tr>
  <tr>
    <td>Familia: <?php echo $reg[0]['nomfamilia']; ?></td>
  </tr>
  <tr>
    <td>Subfamilia: <?php echo $reg[0]['codsubfamilia'] == '0' ? "******" : $reg[0]['nomsubfamilia']; ?></td>
  </tr>
  <tr>
    <td>Marca: <?php echo $reg[0]['codmarca'] == '0' ? "******" : $reg[0]['nommarca']; ?></td>
  </tr>
  <tr>
    <td>Modelo: <?php echo $reg[0]['codmodelo'] == '0' ? "******" : $reg[0]['nommodelo']; ?></td>
  </tr>
  <tr>
    <td>Presentación: <?php echo $reg[0]['nompresentacion']; ?></td>
  </tr> 
  <tr>
    <td>Color: <?php echo $reg[0]['codcolor'] == '0' ? "******" : $reg[0]['nomcolor']; ?></td>
  </tr> 
  <tr>
    <td>Origen: <?php echo $reg[0]['codorigen'] == '0' ? "******" : $reg[0]['nomorigen']; ?></td>
  </tr>
  <tr>
    <td>Año de Fábrica: <?php echo $reg[0]['year'] == '' ? "******" : $reg[0]['year']; ?></td>
  </tr> 
  <tr>
    <td>Part Number: <?php echo $reg[0]['nroparte'] == '' ? "******" : $reg[0]['nroparte']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Lote: <?php echo $reg[0]['lote'] == '' ? "******" : $reg[0]['lote']; ?></td>
  </tr> 
  <tr>
    <td>Peso: <?php echo $reg[0]['peso'] == '' ? "******" : $reg[0]['peso']; ?></td>
  </tr>  
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
  <tr>
    <td>Precio de Compra: <?php echo $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td>Precio de Venta Mayor: <?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?> <?php echo $var2 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxmayor']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr> 
  <tr>
    <td>Precio de Venta Menor: <?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?> <?php echo $var1 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxmenor']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr>  
  <tr>
    <td>Precio de Venta Publico: <?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?> <?php echo $var3 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxpublico']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr> 
  <tr>
    <td>Existencia: <?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Óptimo: <?php echo $reg[0]['stockoptimo'] == '0' ? "******" : number_format($reg[0]['stockoptimo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Medio: <?php echo $reg[0]['stockmedio'] == '0' ? "******" : number_format($reg[0]['stockmedio'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Minimo: <?php echo $reg[0]['stockminimo'] == '0' ? "******" : number_format($reg[0]['stockminimo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><?php echo $NomImpuesto; ?>: <?php echo $reg[0]['ivaproducto'] == 'SI' ? number_format($ValorImpuesto, 2, '.', ',')."%" : "EXENTO"; ?></td>
  </tr> 
  <tr>
    <td>Descuento: <?php echo number_format($reg[0]['descproducto'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
    <td>Código de Barra: <?php echo $reg[0]['codigobarra'] == '' ? "******" : $reg[0]['codigobarra']; ?></td>
  </tr> 
  <tr>
    <td>Fecha de Elaboración: <?php echo $reg[0]['fechaelaboracion'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[0]['fechaelaboracion'])); ?></td>
  </tr> 
  <tr>
    <td>Fecha de Exp. Óptimo: <?php echo $reg[0]['fechaoptimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[0]['fechaoptimo'])); ?></td>
  </tr>
  <tr>
    <td>Fecha de Exp. Medio: <?php echo $reg[0]['fechamedio'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[0]['fechamedio'])); ?></td>
  </tr>
  <tr>
    <td>Fecha de Exp. Minimo: <?php echo $reg[0]['fechaminimo'] == '0000-00-00' ? "******" : date("d-m-Y",strtotime($reg[0]['fechaminimo'])); ?></td>
  </tr>
  <tr>
    <td>Status: <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr> 
  <tr>
    <td>Proveedor: <?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></td>
  </tr> 
  <?php if ($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td>Sucursal: <?php echo $reg[0]['nomsucursal']; ?></td>  
  </tr>
  <?php } ?>
</table>
<?php 
} 
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
?>






<?php
########################## MOSTRAR AJUSTES DE PRODUCTOS EN VENTANA MODAL ##########################
if (isset($_GET['BuscaAjusteProductoModal']) && isset($_GET['numero']) && isset($_GET['codsucursal'])) { 

$reg = $new->AjustesProductosPorId();  
$simbolo = ($reg[0]['simbolo'] == "" ? "" : " <strong>".$reg[0]['simbolo']."</strong>");
?>
  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
    <td><strong>Producto:</strong> <?php echo $reg[0]['producto']; ?></td>
  </tr> 
  <tr>
    <td><strong>Marca: </strong> <?php echo $reg[0]['codmarca'] == '0' ? "*********" : $reg[0]['nommarca']; ?></td>
  </tr>
  <tr>
    <td><strong>Modelo: </strong> <?php echo $reg[0]['codmodelo'] == '0' ? "*********" : $reg[0]['nommodelo']; ?></td>
  </tr> 
  <tr>
    <td><strong>Presentación: </strong> <?php echo $reg[0]['codpresentacion'] == '0' ? "*********" : $reg[0]['nompresentacion']; ?></td>
  </tr>
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio Venta Mayor: </strong> <?php echo $reg[0]['simbolo'].number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Precio Venta Menor: </strong> <?php echo $reg[0]['simbolo'].number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Precio Venta Público: </strong> <?php echo $reg[0]['simbolo'].number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Existencia: </strong> <?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong>Cantidad: </strong> <?php echo  $tipo = ($reg[0]['procedimiento'] == 1 ? "<i class='fa fa-plus text-info'></i>" : "<i class='fa fa-minus text-success'></i>")." ".$reg[0]['cantidad']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock: </strong> <?php echo $reg[0]['procedimiento'] == 1 ? number_format($reg[0]['existencia']+$reg[0]['cantidad'], 2, '.', ',') : number_format($reg[0]['existencia']-$reg[0]['cantidad'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td><strong>Motivo Ajuste: </strong> <?php echo $reg[0]['motivoajuste']; ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Ajuste: </strong> <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechaajuste'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR AJUSTE DE PRODUCTOS EN VENTANA MODAL ##########################
?>








<?php 
########################## MOSTRAR FOTO COMBO EN FORMULARIO ##########################
if (isset($_GET['CargaFotoCombo']) && isset($_GET['codcombo'])) { 

  if (file_exists("fotos/combos/".$_SESSION["codsucursal"]."/".$_GET["codcombo"].".jpg")){
    echo "<img src='fotos/combos/".$_SESSION["codsucursal"]."/".$_GET['codcombo'].".jpg?' width='160' height='170'>";
  } else if (file_exists("fotos/combos/".$_SESSION["codsucursal"]."/".$_GET["codcombo"].".jpeg")){
    echo "<img src='fotos/combos/".$_SESSION["codsucursal"]."/".$_GET['codcombo'].".jpeg?' width='160' height='170'>";
  } else if (file_exists("fotos/combos/".$_SESSION["codsucursal"]."/".$_GET["codcombo"].".png")){
    echo "<img src='fotos/combos/".$_SESSION["codsucursal"]."/".$_GET['codcombo'].".png?' width='160' height='170'>";
  } else {
    echo "<img src='fotos/ninguna.png' width='160' height='170'>";  
  }
}
############################# MOSTRAR FOTO COMBO EN FORMULARIO #############################
?>

<?php 
########################## MOSTRAR FOTO DE COMBO EN VENTANA MODAL ##########################
if (isset($_GET['BuscaFotoComboModal']) && isset($_GET['codcombo']) && isset($_GET['codsucursal'])) { 

$new = new Login();
$reg = $new->CombosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
    <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/combos/".$reg[0]["codsucursal"]."/".$reg[0]["codcombo"].".jpg")){
          echo "<img src='fotos/combos/".$reg[0]["codsucursal"]."/".$reg[0]["codcombo"].".jpg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/combos/".$reg[0]["codsucursal"]."/".$reg[0]["codcombo"].".jpeg")){
          echo "<img src='fotos/combos/".$reg[0]["codsucursal"]."/".$reg[0]["codcombo"].".jpeg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/combos/".$reg[0]["codsucursal"]."/".$reg[0]["codcombo"].".png")){   
          echo "<img src='fotos/combos/".$reg[0]["codsucursal"]."/".$reg[0]["codcombo"].".png?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else {
          echo "<img src='fotos/img.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Nombre de Combo" class="alert-link"><?php echo $reg[0]['nomcombo']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Código de Combo" class="alert-link"><?php echo $reg[0]['codcombo']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Precio Venta Minorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Mayorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Público" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></abbr>
      </div>
    </div>
    </center>                          
<?php 
}
############################# MOSTRAR FOTO DE COMBO EN VENTANA MODAL #############################
?>

<?php
######################## MOSTRAR COMBOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaComboModal']) && isset($_GET['codcombo']) && isset($_GET['codsucursal'])) { 

$reg = $new->CombosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Código: <?php echo $reg[0]['codcombo']; ?></td>
  </tr>
  <tr>
    <td>Nombre de Combo: <?php echo $reg[0]['nomcombo']; ?></td>
  </tr>
  <tr>
    <td>Familia:  <?php echo $reg[0]['nomfamilia']; ?></td>
  </tr> 
  <tr>
    <td>Precio de Compra:  <?php echo $preciocompra = ($_SESSION['acceso'] == "cajero" || $_SESSION["acceso"]=="cocinero" ? "**********" : $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ',')); ?></td>
  </tr> 
  <tr>
    <td>Precio de Venta Mayor: <?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?> <?php echo $var2 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxmayor']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr> 
  <tr>
    <td>Precio de Venta Menor: <?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?> <?php echo $var1 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxmenor']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr>  
  <tr>
    <td>Precio de Venta Publico: <?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?> <?php echo $var3 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxpublico']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr>
  <tr>
    <td>Existencia:  <?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Minimo:  <?php echo $reg[0]['stockminimo'] == '0.00' ? "******" : number_format($reg[0]['stockminimo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Máximo:  <?php echo $reg[0]['stockmaximo'] == '0.00' ? "******" : number_format($reg[0]['stockmaximo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><?php echo $NomImpuesto; ?>:  <?php echo $reg[0]['ivacombo'] == 'SI' ? number_format($ValorImpuesto, 2, '.', ',')."%" : "EXENTO"; ?></td>
  </tr> 
  <tr>
    <td>Descuento:  <?php echo number_format($reg[0]['desccombo'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
    <td>Status:  <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
    
  <?php if($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td>Sucursal Asignada:  <?php echo $reg[0]['codsucursal'] == "0" ? "**********" : $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>

<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductos(); 

if($busq==""){

  echo "";      
    
} else {
?>
<div id="div1">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
        <thead>
        <tr>
        <th colspan="6" data-priority="1"><center>Productos Agregados</center></th>
        </tr>
        <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
          <th>Nº</th>
          <th>Producto</th>
          <th>Presentación</th>
          <th>Existencia</th>
          <th>Cantidad</th>
          <th>P.V.P</th>
        </tr>
        </thead>
        <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
$TotalCosto+=($busq[$i]['precioventa']-$busq[$i]['descproducto']/100)*$busq[$i]["cantidad"];
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td class="text-left"><h5 class="text-dark alert-link"><?php echo $busq[$i]['producto']; ?></h5>
    <small>MARCA (<?php echo $busq[$i]['codmarca'] == '0' ? "******" : $busq[$i]['nommarca'] ?>) - MODELO (<?php echo $busq[$i]['codmodelo'] == '0' ? "******" : $busq[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo $busq[$i]["codpresentacion"] == 0 ? "******" : $busq[$i]["nompresentacion"]; ?></td>
    <td><?php echo number_format($busq[$i]["existencia"], 2, '.', ','); ?></td>
    <td><?php echo number_format($busq[$i]["cantidad"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($busq[$i]["precioventa"], 2, '.', ','); ?></td>
  </tr> 
  <?php } ?> 
  <tr class="text-dark alert-link">
    <td colspan="4"></td>
    <td><label>Total Gasto</label></td>
    <td><label><?php echo $simbolo.number_format($TotalCosto, 2, '.', ','); ?></label></td>
  </tr>
  </tbody>
  </table>
  </div>
<?php  
  }
} 
######################## MOSTRAR COMBOS EN VENTANA MODAL ########################
?>


















<?php
######################## MOSTRAR TRASPASOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaTraspasoModal']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
  <h4><b class="text-danger">SUCURSAL REMITENTE</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/><?php echo $reg[0]['direcsucursal'] == '' ? "" : $reg[0]['direcsucursal']; ?> <?php echo $reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "" : $reg[0]['departamento']; ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal'] == '' ? "**********" : $reg[0]['correosucursal']; ?></p>

  <h4><b class="text-danger">TRASPASO</b></h4>
  <p class="text-dark alert-link m-l-5">Nº DE FACTURA: #<?php echo $reg[0]['codfactura']; ?>
  <br>Nº DE TRACKING: <?php echo $reg[0]['numero_tracking']; ?>
  <br>FECHA DE TRASPASO: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso'])); ?>
  
  <br>ESTADO DE TRASPASO: 
  <?php if($reg[0]['estado_traspaso'] == 1){
  echo "<span class='badge badge-info'><i class='fa fa-info'></i> REGISTRADO</span>";
  } elseif($reg[0]['estado_traspaso'] == 2){
  echo "<span class='badge badge-info'><i class='fa fa-truck'></i> EN PROCESO</span>";
  } elseif($reg[0]['estado_traspaso'] == 3){
  echo "<span class='badge badge-info'><i class='fa fa-truck'></i> PENDIENTE</span>";
  } elseif($reg[0]['estado_traspaso'] == 4){
  echo "<span class='badge badge-success'><i class='fa fa-check'></i> RECIBIDO</span>";
  } elseif($reg[0]['estado_traspaso'] == 5){
  echo "<span class='badge badge-danger'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
  } ?>
  <br/> OBSERVACIONES DE ENVIO: <?php echo $reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']; ?>
  <br/> RESPONSABLE DE TRASLADO POR: <?php echo $reg[0]['nombres_responsable'] == "" ? "**********" : $reg[0]['nombres_responsable']; ?>
  <br/> RECIBIDO POR: <?php echo $reg[0]['persona_recibe'] == 0 ? "**********" : $reg[0]['persona_recibe']; ?>
  <br/> FECHA DE RECIBO: <?php echo $reg[0]['fecha_recibe'] == '' ? "**********" : date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso'])); ?>
  <br/> OBSERVACIONES DE RECIBIDO: <?php echo $reg[0]['observaciones_recibido'] == '' ? "**********" : $reg[0]['observaciones_recibido']; ?>

  <?php if($reg[0]['sucursal_recibe'] == $_SESSION["codsucursal"]){ ?>
  <br/> SUMADO A STOCK AL RECIBIR: <?php echo $reg[0]['agregar_stock'] == '1' ? "<span class='badge badge-info alert-link font-16'> SI</span>" : "<span class='badge badge-warning alert-link font-16'> NO</span>"; ?>
  <?php } ?>

</p>
                                   </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
  <h4><b class="text-danger">SUCURSAL DESTINATARIO</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomsucursal2']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal2'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitsucursal2']; ?> - TLF: <?php echo $reg[0]['tlfsucursal2']; ?>
  <br><?php echo $reg[0]['direcsucursal2'] == '' ? "" : $reg[0]['direcsucursal2']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal2'] == '' ? "**********" : $reg[0]['correosucursal2'] ?></p>
                                    </address>
                                </div>
                            </div>

            <div class="col-md-12">
              <div class="table-responsive m-t-10" style="clear: both;">
              <table class="table">
              <thead>
              <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>#</th>
                <th>Descripción de Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Valor Total</th>
                <th>Desc %</th>
                <th>Impuesto</th>
                <th>Valor Neto</th>
                <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]['sucursal_envia'] == $_SESSION['codsucursal']) { ?>
                <th><i class="mdi mdi-drag-horizontal"></i></th>
                <?php } ?>
              </tr>
              </thead>
              <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]['sucursal_envia'] == $_SESSION['codsucursal']) { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleTraspaso('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','1','<?php echo encrypt("DETALLETRASPASO") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
                                 </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>

                  <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
                  <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                    <div class="clearfix"></div>
                    <hr>

                    <div class="col-md-12">
                        <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codtraspaso=<?php echo encrypt($reg[0]["codtraspaso"]); ?>&codsucursal=<?php echo encrypt($reg[0]['sucursal_envia']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
  <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                        </div>
                      </div>
                  </div>
                <!-- .row -->
<?php
  }
} 
######################## MOSTRAR TRASPASOS EN VENTANA MODAL ########################
?>


<?php
######################## MOSTRAR DETALLES DE TRASPASOS UPDATE ########################
if (isset($_GET['MuestraDetallesTraspasoUpdate']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
<?php
} 
######################## MOSTRAR DETALLES DE TRASPASOS UPDATE ########################
?>

<?php
######################## MOSTRAR DETALLES DE TRASPASOS AGREGAR ########################
if (isset($_GET['MuestraDetallesTraspasoAgregar']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
<?php
} 
######################## MOSTRAR DETALLES DE TRASPASOS AGREGRA ########################
?>




















<?php
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCompraPagadaModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){ 
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">COMPRA</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $tipo_documento = ($reg[0]['tipodocumento'] == "FACTURA_COMPRA" ? "Nº DE FACTURA" : "Nº DE TICKET").": ".$reg[0]['codfactura']; ?>
  <br>STATUS: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
  elseif($reg[0]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito'] != "0000-00-00") { ?>
  <br>DIAS VENCIDOS:
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d/m/Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d/m/Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                      </address>
                          </div>
                              <div class="pull-right text-right">
                                <address>
  <h4><b class="text-danger">PROVEEDOR</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <?php echo $reg[0]['direcproveedor'] == '' ? "" : "<br/>".$reg[0]['direcproveedor']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?></p>
                                            
                                </address>
                              </div>
                          </div>

        <div class="col-md-12">
            <div class="table-responsive m-t-10" style="clear: both;">
              <table class="table">
              <thead>
              <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
              <th>#</th>
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
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleCompra('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','1','<?php echo encrypt("DETALLECOMPRA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
                                      </tr>
                                      <?php } ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>

                <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
                      <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                    <div class="clearfix"></div>
                    <hr>

                    <div class="col-md-12">
                        <div class="text-right">
 <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[0]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                        </div>
                      </div>
                  </div>
                <!-- .row -->
<?php
  }
} 
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
?>

<?php
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL #######################
if (isset($_GET['BuscaCompraPendienteModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                <div class="row">
                        <div class="col-md-12">
                          <div class="pull-left">
                            <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/>Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">COMPRA</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $tipo_documento = ($reg[0]['tipodocumento'] == "FACTURA_COMPRA" ? "Nº DE FACTURA" : "Nº DE TICKET").": ".$reg[0]['codfactura']; ?>
  <br>ESTADO: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
  elseif($reg[0]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <br>TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio']-$reg[0]['creditopagado'], 2, '.', ','); ?>
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d/m/Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA VENCIMIENTO: <?php echo date("d/m/Y",strtotime($reg[0]['fechavencecredito'])); ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d/m/Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                </address>
                            </div>
                            
                            <div class="pull-right text-right">
                              <address>
<h4><b class="text-danger">PROVEEDOR</b></h4>
<p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
<?php echo $reg[0]['direcproveedor'] == '' ? "" : "<br/>".$reg[0]['direcproveedor']; ?>
<?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
<?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
<br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
<br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
<br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?></p>
                                    
                              </address>
                            </div>
                        </div>

                      <div class="col-md-12">
                          <div class="table-responsive m-t-10" style="clear: both;">
                      <table class="table table-hover">
                      <thead>
                        <tr><th colspan="4">Detalles de Abonos</th></tr>
                        <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                        <th>#</th>
                        <th>Forma de Abono</th>
                        <th>Nombre de Banco</th>
                        <th>Nº de Comprobante</th>
                        <th>Monto de Abono</th>
                        <th>Fecha de Abono</th>
                      </tr>
                      </thead>
                      <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonosCompras();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
  <tr class="text-dark text-center">
    <td><?php echo $a++; ?></td>
    <td><?php echo $detalle[$i]['mediopago']; ?></td>
    <td><?php echo $banco = ($detalle[$i]['codbanco'] == 0 ? "******" : $detalle[$i]['nombanco']); ?></td>
    <td><?php echo $comprobante = ($detalle[$i]['comprobante'] == "" ? "******" : $detalle[$i]['comprobante']); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($detalle[$i]['fechaabono']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($detalle[$i]['fechaabono']))."</span>"; ?></td>
  </tr>
  <?php } } ?>
  </tbody>
  </table>
  </div>
  <hr>

            <div class="col-md-12">
              <div class="text-right">
 <button id="print" class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codcompra=<?php echo encrypt($reg[0]["codcompra"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo $reg[0]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_COMPRA_8") : encrypt("TICKET_CREDITO_COMPRA_5"); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-folder-open-o"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
              </div>
            </div>
          </div>                     
<?php
  }
} 
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL ######################
?>


<?php
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
if (isset($_GET['MuestraDetallesCompraUpdate']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
$detalle = $tra->VerDetallesCompras();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
  <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleCompra('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCompra(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleCompra('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
  <td class="text-dark alert-link">
  <input type="hidden" name="coddetallecompra[]" id="coddetallecompra" value="<?php echo $detalle[$i]["coddetallecompra"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <?php echo $detalle[$i]['codproducto']; ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    
  <td class="text-dark alert-link"><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
      <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['preciocompra'], 2, '.', ''); ?></td>

  <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
    
  <td class="text-dark alert-link">
  <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ','); ?>">
  <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ''); ?>">
  <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>

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
  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>"><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleCompra('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLECOMPRA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
  </table>
</div>
<?php
} 
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
?>

<?php
####################### MOSTRAR DETALLES DE COMPRAS AGREGAR #######################
if (isset($_GET['MuestraDetallesCompraAgregar']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
  <table class="table table-hover">
  <thead>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
      <th>Nº</th>
      <th>Código</th>
      <th>Descripción</th>
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
$detalle = $tra->VerDetallesCompras();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td class="text-dark alert-link"><?php echo $a++; ?></td>
  <td class="text-danger alert-link"><?php echo $detalle[$i]['codproducto']; ?></td>
   <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
  <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleCompra('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','3','<?php echo encrypt("DETALLECOMPRA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
<?php
} 
######################## MOSTRAR DETALLES DE COMPRAS AGREGRA #######################
?>



















<?php
######################## MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
if (isset($_GET['BuscaCotizacionModal']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){ 
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">COTIZACIÓN</b></h4>
  <p class="text-dark alert-link m-l-5">Nº DE FACTURA: #<?php echo $reg[0]['codfactura']; ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechacotizacion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                          </address>
                        </div>
                    </div>

                <div class="col-md-12">
                  <div class="table-responsive m-t-10" style="clear: both;">
                    <table class="table">
                    <thead>
                    <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                    <th>#</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Valor Total</th>
                    <th>Desc %</th>
                    <th>Impuesto</th>
                    <th>Valor Neto</th>
                    <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?>
                    <th><i class="mdi mdi-drag-horizontal"></i></th>
                    <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleCotizacion('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','1','<?php echo encrypt("DETALLECOTIZACION") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
                                  </tr>
                                  <?php } ?>
                                  </tbody>
                                  </table>
                                </div>
                            </div>


                  <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exonerado:</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?> </p>
                      <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                      <div class="clearfix"></div>
                      <hr>

                <div class="col-md-12">
                    <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codcotizacion=<?php echo encrypt($reg[0]["codcotizacion"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                    </div>
                  </div>
              </div>   
            <!-- .row -->
  <?php
  }
} 
######################### MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
if (isset($_GET['MuestraDetallesCotizacionUpdate']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) {

$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
      <?php if ($_SESSION['acceso'] == "administradorS") { ?>
      <th><i class="mdi mdi-drag-horizontal"></i></th>
      <?php } ?>
  </tr>
  </thead>
  <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
  <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleCotizacion('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCotizacion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleCotizacion('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
    
  <td class="alert-link">
  <input type="hidden" name="coddetallecotizacion[]" id="coddetallecotizacion" value="<?php echo $detalle[$i]["coddetallecotizacion"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
  <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>
    
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td> 
  <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
  <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>
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
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleCotizacion('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLECOTIZACION") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
  </td><?php } ?>
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
<?php
} 
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE COTIZACIONES AGREGAR #######################
if (isset($_GET['MuestraDetallesCotizacionAgregar']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
      <?php if ($_SESSION['acceso'] == "administradorS") { ?>
      <th><i class="mdi mdi-drag-horizontal"></i></th>
      <?php } ?>
  </tr>
  </thead>
  <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td class="text-dark alert-link"><?php echo $a++; ?></td>
  <td class="alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
  <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleCotizacion('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','3','<?php echo encrypt("DETALLECOTIZACION") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
<?php
} 
######################## MOSTRAR DETALLES DE COTIZACIONES AGREGRA #######################
?>

















<?php
######################## MOSTRAR PREVENTAS EN VENTANA MODAL #########################
if (isset($_GET['BuscaPreventaModal']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="pull-left">
                              <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger"> PREVENTA</b></h4>
  <p class="text-dark alert-link m-l-5">Nº DE FACTURA: #<?php echo $reg[0]['codfactura']; ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechapreventa'])); ?></p>
                              </address>
                          </div>
                          <div class="pull-right text-right">
                              <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>          
                              </address>
                          </div>
                      </div>

          <div class="col-md-12">
            <div class="table-responsive m-t-10" style="clear: both;">
              <table class="table">
              <thead>
              <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
              <th>#</th>
              <th>Descripción</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Valor Total</th>
              <th>Desc %</th>
              <th>Impuesto</th>
              <th>Valor Neto</th>
              <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?>
              <th><i class="mdi mdi-drag-horizontal"></i></th>
              <?php } ?>
              </tr>
              </thead>
              <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetallePreventa('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','1','<?php echo encrypt("DETALLEPREVENTA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exonerado:</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?> </p>
                      <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                      <div class="clearfix"></div>
                      <hr>

                <div class="col-md-12">
                    <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codpreventa=<?php echo encrypt($reg[0]["codpreventa"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                    </div>
                  </div>
              </div>
                <!-- .row -->
<?php
  }
} 
######################### MOSTRAR PREVENTAS EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE PREVENTAS UPDATE #########################
if (isset($_GET['MuestraDetallesPreventaUpdate']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
      <?php if ($_SESSION['acceso'] == "administradorS") { ?>
      <th><i class="mdi mdi-drag-horizontal"></i></th>
      <?php } ?>
  </tr>
  </thead>
  <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
  <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePreventa('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPreventa(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePreventa('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
    
  <td class="alert-link">
  <input type="hidden" name="coddetallepreventa[]" id="coddetallepreventa" value="<?php echo $detalle[$i]["coddetallepreventa"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
  <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>
    
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca']; ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo']; ?>)</small></td>
    
  <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
  <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

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
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetallePreventa('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','2','<?php echo encrypt("DETALLEPREVENTA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
<?php
} 
####################### MOSTRAR DETALLES DE PREVENTAS UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE PREVENTAS AGREGAR #######################
if (isset($_GET['MuestraDetallesPreventaAgregar']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
      <?php if ($_SESSION['acceso'] == "administradorS") { ?>
      <th><i class="mdi mdi-drag-horizontal"></i></th>
      <?php } ?>
  </tr>
  </thead>
  <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td class="text-dark alert-link"><?php echo $a++; ?></td>
  <td class="alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
  <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca']; ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo']; ?>)</small></td>
  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetallePreventa('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','3','<?php echo encrypt("DETALLEPREVENTA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></td><?php } ?>
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
<?php
} 
######################## MOSTRAR DETALLES DE PREVENTAS AGREGRA #######################
?>















<?php
####################### MOSTRAR CAJA DE VENTA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCajaModal']) && isset($_GET['codcaja'])) { 

$reg = $new->CajasPorId();
?>
  <table class="table-responsive" border="0" align="center"> 
  <tr>
    <td><strong>Nº de Caja:</strong> <?php echo $reg[0]['nrocaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable de Caja:</strong>  <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php 
} 
######################## MOSTRAR CAJA DE VENTA EN VENTANA MODAL #########################
?>

<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->BuscarCajasxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
<?php
for($i=0;$i<sizeof($caja);$i++){
?>
<option value="<?php echo encrypt($caja[$i]['codcaja']); ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
<?php 
  } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>

<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasAbiertasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->ListarCajasAbiertas();
?>
<option value=""> -- SELECCIONE -- </option>
<?php
for($i=0;$i<sizeof($caja);$i++){
?>
<option value="<?php echo encrypt($caja[$i]['codarqueo']); ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
<?php 
  } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>

<?php
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL #######################
if (isset($_GET['BuscaArqueoModal']) && isset($_GET['codarqueo'])) { 

$reg = $new->ArqueoCajaPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

$detalleabonos = (new Login)->DetallesAbonosArqueoCajaPorId();

$detallemovimientos = (new Login)->DetallesMovimientosArqueoCajaPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-desktop"></i> Cajero</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Hora Apertura:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura'])); ?></td>
  </tr>
  <tr>
    <td><strong>Hora Cierre:</strong> <?php echo $cierre = ( $reg[0]['statusarqueo'] == '1' ? $reg[0]['fechacierre'] : date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))); ?></td>
  </tr>
  <tr>
    <td><strong>Monto Inicial:</strong> <?php echo $simbolo.number_format($reg[0]['montoinicial'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-cart-plus"></i> Desglose en Ventas</h4><hr></td>
  </tr>
  <tr>
    <td><strong>CRÉDITOS:</strong> <?php echo $simbolo.number_format($reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>

  <?php
  $a=1;
  $Ventas_Efectivo = 0;
  for($i=0;$i<sizeof($reg);$i++){
  $Ventas_Efectivo += ($reg[$i]['mediopago'] == "EFECTIVO" ? $reg[$i]['montopagado'] : 0);   
  if($reg[$i]['mediopago'] != ""){
  ?>
  <tr>
    <td><strong><?php echo $reg[$i]['mediopago']; ?>:</strong>  <?php echo $simbolo.number_format($reg[$i]['montopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-cart-plus"></i> Desglose en Abonos a Créditos</h4><hr></td>
  </tr>

  <?php
  $b=1;
  $Abonos_Efectivo = 0;
  for($i=0;$i<sizeof($detalleabonos);$i++){
  $Abonos_Efectivo += ($detalleabonos[$i]['mediopago'] == "EFECTIVO" ? $detalleabonos[$i]['monto_abonado'] : 0);
  if($detalleabonos[$i]['mediopago'] != ""){
  ?>
  <tr>
    <td><strong><?php echo $detalleabonos[$i]['mediopago']; ?>:</strong>  <?php echo $simbolo.number_format($detalleabonos[$i]['monto_abonado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-usd"></i> Movimientos de Caja</h4><hr></td>
  </tr>

  <?php
  $c=1;
  $Movimientos_Efectivo = 0;
  for($i=0;$i<sizeof($detallemovimientos);$i++){
  $Movimientos_Efectivo += ($detallemovimientos[$i]['mediopago'] == "EFECTIVO" ? $detallemovimientos[$i]['movimientos_efectivo'] : 0);
  if($detallemovimientos[$i]['mediopago'] != ""){
  ?>
  <tr>
    <td><strong><?php echo $detallemovimientos[$i]['mediopago']; ?>:</strong>  <?php echo $simbolo.number_format($detallemovimientos[$i]['movimientos_efectivo'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <td><strong>Egresos:</strong> <?php echo $simbolo.number_format($reg[0]['egresos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Egresos (Notas Crédito):</strong> <?php echo $simbolo.number_format($reg[0]['egresonotas'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-scale-balance"></i> Balance en Caja</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Total Ventas:</strong> <?php echo $simbolo.number_format($reg[0]['ingresos']+$reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total de Abonos:</strong> <?php echo $simbolo.number_format($reg[0]['abonos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Efectivo en Caja:</strong> <?php echo $simbolo.number_format(($reg[0]["montoinicial"]+$Ventas_Efectivo+$Abonos_Efectivo+$Movimientos_Efectivo)-($reg[0]["egresos"]+$reg[0]["egresonotas"]), 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Efectivo Disponible:</strong> <?php echo $simbolo.number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Diferencia en Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Observaciones:</strong> <?php echo $reg[0]['comentarios'] == "" ? "******" : $reg[0]['comentarios']; ?></td>
  </tr>
  <?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php
} 
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL ########################
?>


<?php
###################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL #####################
if (isset($_GET['BuscaMovimientoModal']) && isset($_GET['numero']) && isset($_GET['codsucursal'])) { 

$reg = $new->MovimientosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<table class="table-responsive" border="0" align="center">
  <tr>
    <td><strong>Nombre de Caja: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Movimiento:</strong> <?php echo $reg[0]['tipomovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Pago:</strong> <?php echo $reg[0]['mediopago']; ?></td>
  </tr>
  <tr>
    <td><strong>Monto de Movimiento:</strong> <?php echo $simbolo.number_format($reg[0]['montomovimiento'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Descripción de Movimiento:</strong> <?php echo $reg[0]['descripcionmovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha Movimiento:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechamovimiento'])); ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
  <?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>
<?php
} 
##################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL ######################
?>








<?php
############################# MOSTRAR FACTURA PENDIENTE EN VENTANA MODAL ############################
if (isset($_GET['BuscaFacturaPendienteModal']) && isset($_GET['codpendiente']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->FacturaPendientePorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">PEDIDO</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo "Nº: ".$reg[0]['codfactura']; ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechapendiente'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>

              <div class="col-md-12">
                <div class="table-responsive m-t-10" style="clear: both;">
                <table class="table">
                <thead>
                <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                  <th>#</th>
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
$detalle = $tra->VerDetallesFacturaPendientes();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
    <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
    <td>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleFacturaPendiente('<?php echo encrypt($detalle[$i]["coddetallependiente"]); ?>','<?php echo encrypt($detalle[$i]["codpendiente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLEPENDIENTE") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    </td>
                          </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                  </div>

                  <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exonerado:</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?> </p>
                      <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                    <div class="clearfix"></div>
                    <hr>
              </div>    
              <!-- .row -->
<?php
  }
} 
############################# MOSTRAR FACTURA PENDIENTE EN VENTANA MODAL ############################
?>


<?php
############################# MOSTRAR VENTAS DEL DIA EN VENTANA MODAL ############################
if (isset($_GET['BuscaVentaDiariaModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg[0]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_A4'){
  $tipo_documento = "NOTA DE VENTA";
} elseif($reg[0]['tipodocumento'] == 'TICKET_8' || $reg[0]['tipodocumento'] == 'TICKET_5'){
  $tipo_documento = "TICKET";
} elseif($reg[0]['tipodocumento'] == 'BOLETA_8' || $reg[0]['tipodocumento'] == 'BOLETA_5' || $reg[0]['tipodocumento'] == 'BOLETA_A4'){
  $tipo_documento = "BOLETA";
} elseif($reg[0]['tipodocumento'] == 'FACTURA_A4' || $reg[0]['tipodocumento'] == 'FACTURA'){
  $tipo_documento = "FACTURA";
} elseif($reg[0]['tipodocumento'] == 'GUIA_REMISION'){
  $tipo_documento = "GUIA DE REMISION";
}

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
<p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
<br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
<br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">VENTA</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $tipo_documento.": ".$reg[0]['codfactura']; ?>
  <br>Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>

  <br>ESTADO: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
  elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d/m/Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>

              <div class="col-md-12">
                <div class="table-responsive m-t-10" style="clear: both;">
                <table class="table">
                <thead>
                <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                  <th>#</th>
                  <th>Descripción</th>
                  <th>Cantidad</th>
                  <th>Precio Unitario</th>
                  <th>Valor Total</th>
                  <th>Desc %</th>
                  <th>Impuesto</th>
                  <th>Valor Neto</th>
                </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
    <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
                          </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                  </div>

                  <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exonerado:</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?> </p>
                      <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                    <div class="clearfix"></div>
                    <hr>

                    <div class="col-md-12">
                        <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[0]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                    </div>
                  </div>
              </div>    
              <!-- .row -->
<?php
  }
} 
############################# MOSTRAR VENTAS DEL DIA EN VENTANA MODAL ############################
?>

<?php
############################# MOSTRAR VENTAS EN VENTANA MODAL ############################
if (isset($_GET['BuscaVentaModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg[0]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_A4'){
  $tipo_documento = "NOTA DE VENTA";
} elseif($reg[0]['tipodocumento'] == 'TICKET_8' || $reg[0]['tipodocumento'] == 'TICKET_5'){
  $tipo_documento = "TICKET";
} elseif($reg[0]['tipodocumento'] == 'BOLETA_8' || $reg[0]['tipodocumento'] == 'BOLETA_5' || $reg[0]['tipodocumento'] == 'BOLETA_A4'){
  $tipo_documento = "BOLETA";
} elseif($reg[0]['tipodocumento'] == 'FACTURA_A4' || $reg[0]['tipodocumento'] == 'FACTURA'){
  $tipo_documento = "FACTURA";
} elseif($reg[0]['tipodocumento'] == 'GUIA_REMISION'){
  $tipo_documento = "GUIA DE REMISION";
}

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";
} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
<p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
<br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
<br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">VENTA</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $tipo_documento.": ".$reg[0]['codfactura']; ?>
  <br>Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>

  <br>ESTADO: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
  elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d/m/Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>

              <div class="col-md-12">
                <div class="table-responsive m-t-10" style="clear: both;">
                <table class="table">
                <thead>
                <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                  <th>#</th>
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

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
    <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
    <td>
    <?php if($reg[0]['notacredito'] != 1){ ?>
    <?php if($_SESSION['acceso'] == "administradorS" || $reg[0]["codigo"] == $_SESSION['codigo']){ ?>
    <?php if($reg[0]['statusarqueo'] == 1){ ?>
    <span class="text-danger" style="cursor: pointer;" title="Eliminar" onClick="EliminarDetalleVenta('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','1','<?php echo encrypt("DETALLEVENTA") ?>')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                  </div>

                  <div class="col-md-12">
                    <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exonerado:</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?> </p>
                      <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                    <div class="clearfix"></div>
                    <hr>

                    <div class="col-md-12">
                        <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[0]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                    </div>
                  </div>
              </div>    
              <!-- .row -->
<?php
  }
} 
############################# MOSTRAR VENTAS EN VENTANA MODAL ############################
?>

<?php
######################### MOSTRAR DETALLES DE VENTAS UPDATE ############################
if (isset($_GET['MuestraDetallesVentaUpdate']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario();

$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
                      <div class="form-group">
                          <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label><br>
                          <div class="form-check form-check-inline">
                              <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="notaventa1" name="tipodocumento" value="NOTA_VENTA_8" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "NOTA_VENTA_8") { ?> checked="checked" <?php } ?> disabled="">
                              <label class="custom-control-label" for="notaventa1">NOTA VENTA (8MM)</label>
                              </div>
                          </div>

                          <div class="form-check form-check-inline">
                              <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="notaventa2" name="tipodocumento" value="NOTA_VENTA_5" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "NOTA_VENTA_5") { ?> checked="checked" <?php } ?> disabled="">
                              <label class="custom-control-label" for="notaventa2">NOTA VENTA (5MM)</label>
                              </div>
                          </div><br>

                          <div class="form-check form-check-inline">
                              <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="boleta" name="tipodocumento" value="BOLETA_A4" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "BOLETA_A4") { ?> checked="checked" <?php } ?> disabled="">
                              <label class="custom-control-label" for="boleta">BOLETA</label>
                              </div>
                          </div>

                          <div class="form-check form-check-inline">
                              <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="factura" name="tipodocumento" value="FACTURA_A4" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "FACTURA_A4") { ?> checked="checked" <?php } ?> disabled="">
                              <label class="custom-control-label" for="factura">FACTURA</label>
                              </div>
                          </div><br>

                          <div class="form-check form-check-inline">
                              <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="guia" name="tipodocumento" value="GUIA_REMISION" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "GUIA_REMISION") { ?> checked="checked" <?php } ?> disabled="">
                              <label class="custom-control-label" for="guia">GUIA REMISIÓN</label>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                          <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="contado" name="tipopago" value="CONTADO" onClick="CargaCondicionesPagos()" 
                          <?php if (isset($reg[0]['tipopago'])) { ?> <?php if($reg[0]['tipopago'] == "CONTADO") { ?> value="CONTADO" checked="checked" <?php } } else { ?> checked="checked"  <?php } ?> disabled="">
                          <label class="custom-control-label" for="contado">CONTADO</label>
                          </div>

                          <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="credito" name="tipopago" value="CREDITO" onClick="CargaCondicionesPagos()" <?php if (isset($reg[0]['tipopago']) && $reg[0]['tipopago'] == "CREDITO") { ?> checked="checked" <?php } ?> disabled="">
                          <label class="custom-control-label" for="credito">CRÉDITO</label>
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
<?php
} 
########################### MOSTRAR DETALLES DE VENTAS UPDATE ##########################
?>

<?php
########################### MOSTRAR DETALLES DE VENTAS AGREGAR ##########################
if (isset($_GET['MuestraDetallesVentaAgregar']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>

<?php
} 
########################## MOSTRAR DETALLES DE VENTAS AGREGRAR #########################
?>














<?php
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
if (isset($_GET['BuscaCreditoModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CreditosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg[0]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_A4'){
  $tipo_documento = "NOTA DE VENTA";
} elseif($reg[0]['tipodocumento'] == 'TICKET_8' || $reg[0]['tipodocumento'] == 'TICKET_5'){
  $tipo_documento = "TICKET";
} elseif($reg[0]['tipodocumento'] == 'BOLETA_8' || $reg[0]['tipodocumento'] == 'BOLETA_5' || $reg[0]['tipodocumento'] == 'BOLETA_A4'){
  $tipo_documento = "BOLETA";
} elseif($reg[0]['tipodocumento'] == 'FACTURA_A4' || $reg[0]['tipodocumento'] == 'FACTURA'){
  $tipo_documento = "FACTURA";
} elseif($reg[0]['tipodocumento'] == 'GUIA_REMISION'){
  $tipo_documento = "GUIA DE REMISION";
}
?>
              <div class="row">
                  <div class="col-md-12">
                      <div class="pull-left">
                          <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/>Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-danger">VENTA</b></h4>
  <p class="text-dark alert-link m-l-5"><?php echo $tipo_documento.": ".$reg[0]['codfactura']; ?>
  <br>ESTADO: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
  elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>

  <br>TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?>
  <br>TOTAL ABONADO: <?php echo $simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','); ?>
  <br>TOTAL PENDIENTE: <?php echo $simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','); ?>
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d/m/Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>
  <br>FECHA VENCIMIENTO: <?php echo date("d/m/Y",strtotime($reg[0]['fechavencecredito'])); ?>
  <br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
                        </address>
                      </div>
                            
                      <div class="pull-right text-right">
                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                    
                        </address>
                      </div>
                  </div>
                                
              <div class="col-md-12">
                <div class="table-responsive m-t-10" style="clear: both;">
                  <table class="table">
                      <thead>
                        <tr><th colspan="4">Detalles de Abonos</th></tr>
                        <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                        <th>#</th>
                        <th>Nº de Caja</th>
                        <th>Forma de Abono</th>
                        <th>Nombre de Banco</th>
                        <th>Nº de Comprobante</th>
                        <th>Monto de Abono</th>
                        <th>Fecha de Abono</th>
                      </tr>
                      </thead>
                      <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonosVentas();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
  <tr class="text-dark text-center">
    <td><?php echo $a++; ?></td>
    <td><?php echo $detalle[$i]['nrocaja'].": ".$detalle[$i]['nomcaja']; ?></td>
    <td><?php echo $detalle[$i]['mediopago']; ?></td>
    <td><?php echo $banco = ($detalle[$i]['codbanco'] == 0 ? "******" : $detalle[$i]['nombanco']); ?></td>
    <td><?php echo $comprobante = ($detalle[$i]['comprobante'] == "" ? "******" : $detalle[$i]['comprobante']); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
    <td><?php echo date("d/m/Y",strtotime($detalle[$i]['fechaabono']))."<br><span class='text-dark alert-link'>".date("H:i:s",strtotime($detalle[$i]['fechaabono']))."</span>"; ?></td>
  </tr>
  <?php } } ?>
  </tbody>
  </table>
                  </div>
                  <hr>
                  <div class="col-md-12">
                      <div class="text-right">
<button id="print" class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codventa=<?php echo encrypt($reg[0]["codventa"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo $reg[0]['ticket_general'] == 8 ? encrypt("TICKET_CREDITO_VENTA_8") : encrypt("TICKET_CREDITO_VENTA_5"); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-folder-open-o"></i> Imprimir</span></button>
<button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                      </div>
                  </div>
                </div>
                <!-- .row -->
<?php
} 
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
?>













<?php
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
if (isset($_GET['ProcesaNotaCredito']) && isset($_GET['codventa']) && isset($_GET['codsucursal']) && isset($_GET['descontar'])) { 
 
  $codventa = limpiar($_GET['codventa']);
  $codsucursal = limpiar($_GET['codsucursal']);
  $descontar = limpiar($_GET['descontar']);
  $codarqueo = limpiar(isset($_GET['codarqueo']) ? $_GET["codarqueo"] : "");

 if($codventa=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL Nº DE DOCUMENTO CORRECTAMENTE</center>";
  echo "</div>";   
  exit;

 } else if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if(isset($_GET['codarqueo']) && $codarqueo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
  echo "</div>";   
  exit;  

} else {

$reg = $new->BuscarVentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg[0]['tipodocumento'] == 'NOTA_VENTA_8' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_5' || $reg[0]['tipodocumento'] == 'NOTA_VENTA_A4'){
  $tipo_documento = "NOTA DE VENTA";
} elseif($reg[0]['tipodocumento'] == 'TICKET_8' || $reg[0]['tipodocumento'] == 'TICKET_5'){
  $tipo_documento = "TICKET";
} elseif($reg[0]['tipodocumento'] == 'BOLETA_8' || $reg[0]['tipodocumento'] == 'BOLETA_5' || $reg[0]['tipodocumento'] == 'BOLETA_A4'){
  $tipo_documento = "BOLETA";
} elseif($reg[0]['tipodocumento'] == 'FACTURA_A4' || $reg[0]['tipodocumento'] == 'FACTURA'){
  $tipo_documento = "FACTURA";
} elseif($reg[0]['tipodocumento'] == 'GUIA_REMISION'){
  $tipo_documento = "GUIA DE REMISION";
}
?>
<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de <?php echo $tipo_documento." Nº: ".$reg[0]['codfactura']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="table-responsive m-t-20">
          <table class="table table-hover">
          <thead>
            <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
              <th>Devolución</th>
              <th>Vendido</th>
              <th>Tipo</th>
              <th>Descripción de Producto</th>
              <th>Precio Unitario</th>
              <th>Valor Total</th>
              <th>Desc %</th>
              <th>Impuesto</th>
              <th>Valor Neto</th>
          </tr>
          </thead>
          <tbody>
<?php 
$tra = new Login();
$detalle = $tra->BuscarDetallesVentas();

$SubTotal = 0;
$a=1;
$b=0;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
$c = $b++; 
$count++; 
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleDevolucion('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="devuelto[]" id="devuelto_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoDevolucion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="0.00" title="Ingrese Cantidad">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleDevolucion('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>

  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?></td>

  <td class="alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "<span class='badge badge-success'>PRODUCTO</span>"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "<span class='badge badge-info'>COMBO</span>"; } else { echo "<span class='badge badge-primary'>SERVICIO</span>"; } ?></td>

  <td class="text-left">
  <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
  <input type="hidden" name="producto[]" id="producto" value="<?php echo $detalle[$i]["producto"]; ?>">
  <input type="hidden" name="descripcion[]" id="descripcion" value="<?php echo $detalle[$i]["descripcion"]; ?>">
  <input type="hidden" name="imei[]" id="imei" value="<?php echo $detalle[$i]["imei"]; ?>">
  <input type="hidden" name="condicion[]" id="condicion" value="<?php echo $detalle[$i]["condicion"]; ?>">
  <input type="hidden" name="codmarca[]" id="codmarca" value="<?php echo $detalle[$i]["codmarca"]; ?>">
  <input type="hidden" name="codmodelo[]" id="codmodelo" value="<?php echo $detalle[$i]["codmodelo"]; ?>">
  <input type="hidden" name="codpresentacion[]" id="codpresentacion" value="<?php echo $detalle[$i]["codpresentacion"]; ?>">
  <input type="hidden" name="codcolor[]" id="codcolor" value="<?php echo $detalle[$i]["codcolor"]; ?>">
  <input type="hidden" name="cantidad[]" id="cantidad_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <h5 class="text-dark alert-link"><?php echo $detalle[$i]['producto']; ?></h5>
  <small >MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link">
  <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
    <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link">
  <input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="0.00">
  <label id="txtvalortotal_<?php echo $count; ?>">0.00</label></td>
  
  <td class="text-dark alert-link">
  <input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
  <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="0.00">
  <?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup>0.00%</sup></td>

  <td class="text-dark alert-link">
  <input type="hidden" name="posicionimpuesto[]" id="posicionimpuesto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["posicionimpuesto"]; ?>">
  <input type="hidden" name="tipoimpuesto[]" id="tipoimpuesto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["tipoimpuesto"]; ?>">
  <input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["ivaproducto"], 2, '.', ''); ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td></td>

  <td class="text-dark alert-link">
  <input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="0.00">
  <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="0.00">
  <input type="hidden" class="subtotaliva" name="subtotaliva[]" id="subtotaliva_<?php echo $count; ?>" value="0.00">
  <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="0.00">
  <input type="hidden" class="subtotalgeneral" name="subtotalgeneral[]" id="subtotalgeneral_<?php echo $count; ?>" value="0.00">
  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="0.00" >
  <?php echo $simbolo; ?><label id="txtvalorneto_<?php echo $count; ?>">0.00</label></td>
    </tr>
    <?php } ?>
    </tbody>
    </table><hr>
    <input type="hidden" name="idventa" id="idventa" value="<?php echo encrypt($reg[0]['idventa']); ?>">
    <input type="hidden" name="codventa" id="codventa" value="<?php echo encrypt($reg[0]['codventa']); ?>">
    <input type="hidden" name="tipofacturaventa" id="tipofacturaventa" value="<?php echo $tipo_documento; ?>"/>
    <input type="hidden" name="facturaventa" id="facturaventa" value="<?php echo $reg[0]['codfactura']; ?>">
    <input type="hidden" name="tipopago" id="tipopago" value="<?php echo $reg[0]['tipopago']; ?>"/>
    <input type="hidden" name="abonototal" id="abonototal" value="<?php echo number_format($reg[0]["creditopagado"], 2, '.', ''); ?>"/>
    <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $codigo = ($reg[0]['codcliente'] == "" ? "0" : $reg[0]['codcliente']); ?>"/>
    <input type="hidden" name="exonerado" id="exonerado" value="<?php echo $reg[0]['exonerado']; ?>"/>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
    <input type="hidden" name="txtexonerado" id="txtexonerado" value="0.00"/>
    <input type="hidden" name="txtexento" id="txtexento" value="0.00"/>
    <input type="hidden" name="txtsubtotaliva" id="txtsubtotaliva" value="0.00"/>
    <input type="hidden" name="iva" id="iva" value="<?php echo number_format($ValorImpuesto, 2, '.', ''); ?>">
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    <input type="hidden" name="descuento" id="descuento" value="0.00">
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>

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
        <td><h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%:</label></h5></td>
        <td><h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5></td>
        <td class="text-dark alert-link"><h3><label>Importe Total</label></h3></td>
        <td><h3><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></h3></td>
    </tr>
    </table>
    </div>
    <div class="text-right">
      <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar Nota</button>
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
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
?>

<?php
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
if (isset($_GET['BuscaNotaModal']) && isset($_GET['codnota']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->NotaCreditoPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    
} else {
?>
              <div class="row">
                  <div class="col-md-12">
                      <div class="pull-left">
                          <address>
<h4><b class="text-danger">SUCURSAL</b></h4>
<p class="text-dark alert-link m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
<br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento']; ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
<br/> ENCARGADO: <?php echo $reg[0]['nomencargado']; ?></p>

<h4><b class="text-danger">NOTA CRÉDITO</b></h4>
<p class="text-dark alert-link m-l-5"><?php echo $tipo_documento = ($reg[0]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "Nº DE FACTURA" : "Nº DE TICKET").": ".$reg[0]['codfactura']; ?>
<br>DOCUMENTO DE VENTA: <?php echo $reg[0]['tipofacturaventa']." ".$reg[0]['facturaventa']; ?>
<br>MOTIVO DE NOTA: <?php echo $reg[0]["observaciones"]; ?>
<br>FECHA DE EMISIÓN: <?php echo date("d/m/Y H:i:s",strtotime($reg[0]['fechanota'])); ?></p>
                          </address>
                      </div>
                                    
                     <div class="pull-right text-right">
                        <address>
  <h4><b class="text-danger">CLIENTE</b></h4>
  <p class="text-dark alert-link m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['id_provincia2'] == '0' ? "" : "<br/>".$reg[0]['provincia2']; ?> 
  <?php echo $reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                        </address>
                      </div>
                    </div>

          <div class="col-md-12">
            <div class="table-responsive m-t-10" style="clear: both;">
              <table class="table">
              <thead>
              <tr class="warning-element text-center" style="border-left: 2px solid #ff5050 !important; background: #ece8e9;">
                <th>#</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Valor Total</th>
                <th>Desc %</th>
                <th>Impuesto</th>
                <th>Valor Neto</th>
              </tr>
              </thead>
              <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesNotasCredito();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td><h5><?php echo $detalle[$i]['producto']; ?></h5>
    <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "******" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "******" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%)" : "EXENTO"; ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                      </div>
                  </div>

                <div class="col-md-12">
                  <div class="pull-right text-right">
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]['subtotal'], 2, '.', ','); ?></p>
<p><b>Exonerado:</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]['subtotal'] : "0.00", 2, '.', ','); ?></p>
<p><b>Exento (0%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotalexento'], 2, '.', ','); ?></p>
<p><b>Subtotal <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['subtotaliva'], 2, '.', ','); ?><p>
<p><b>Total <?php echo $NomImpuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]['totaliva'], 2, '.', ','); ?> </p>
                    <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                  <div class="clearfix"></div>
                  <hr>

                  <div class="col-md-12">
                    <div class="text-right">
  <button class="btn waves-light btn-light" type="button" onClick="VentanaCentrada('reportepdf?codnota=<?php echo encrypt($reg[0]["codnota"]); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>', '', '', '1024', '568', 'true');"><span><i class="fa fa-print"></i> Imprimir</span></button>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                    </div>
                  </div>
              </div>
            <!-- .row -->
<?php
  }
} 
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
?>