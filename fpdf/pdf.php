<?php
header("Content-Type: text/html;charset=utf-8");
define('FPDF_FONTPATH','fpdf/font/');
define('EURO', chr(128));
require 'pdf_js.php';

############## VARIABLE PARA TAMA�O DE LOGO ##############
$GLOBALS['logo1_vertical'] = 30;
$GLOBALS['logo1_vertical_X'] = 8;
$GLOBALS['logo1_vertical_Y'] = 2;

$GLOBALS['logo2_vertical'] = 30;
$GLOBALS['logo2_vertical_X'] = 10;
$GLOBALS['logo2_vertical_Y'] = 2;

$GLOBALS['logo1_horizontal'] = 32;
$GLOBALS['logo1_horizontal_X'] = 25;
$GLOBALS['logo1_horizontal_Y'] = 1;

$GLOBALS['logo2_horizontal'] = 32;
$GLOBALS['logo2_horizontal_X'] = 15;
$GLOBALS['logo2_horizontal_Y'] = 1;

$GLOBALS['logo1_letter_X'] = 18;
$GLOBALS['logo1_letter_Y'] = 2;
$GLOBALS['logo1_letter'] = 24;

$GLOBALS['logo2_letter_X'] = 18;
$GLOBALS['logo2_letter_Y'] = 2;
$GLOBALS['logo2_letter'] = 24;
############## VARIABLE PARA TAMA�O DE LOGO ##############

############## VARIABLE PARA TEXTO DE GARANTIA ##############
$GLOBALS['texto_global'] = "";
############## VARIABLE PARA TEXTO DE GARANTIA ##############
 

class PDF_AutoPrint extends PDF_JavaScript
{
    var $widths;
    var $aligns;
    var $flowingBlockAttr;
    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';
    //$Tamhoriz = 88;

######################## FUNCION PARA CARGAR AUTOPRINTF ########################
function AutoPrint($printer='')
{
    // Open the print dialog
    if($printer)
    {
        $printer = str_replace('\\', '\\\\', $printer);
        $script = "var pp = getPrintParams();";
        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
        $script .= "pp.printerName = '$printer'";
        $script .= "print(pp);";
    }
    else
        $script = 'print(true);';
    $this->IncludeJS($script);
}
######################## FUNCION PARA CARGAR AUTOPRINT ########################

########################### FUNCION PARA MOSTRAR EL FOOTER ###########################
function Footer() 
{
    if(!in_array(decrypt($_GET['tipo']), ['TICKET_AJUSTE_8', 'TICKET_AJUSTE_5', 'TICKET_TRASPASO_8', 'TICKET_TRASPASO_5', 'TICKET_COMPRA_8', 'TICKET_COMPRA_5', 'TICKET_CREDITO_COMPRA_8', 'TICKET_CREDITO_COMPRA_5', 'TICKET_COTIZACION_8', 'TICKET_COTIZACION_5', 'TICKET_PREVENTA_8', 'TICKET_PREVENTA_5', 'TICKET_CIERRE_8', 'TICKET_CIERRE_5', 'TICKET_MOVIMIENTO_8', 'TICKET_MOVIMIENTO_5', 'TICKET_5', 'TICKET_8', 'NOTA_VENTA_8', 'NOTA_VENTA_5', 'TICKET_CREDITO_VENTA_8', 'TICKET_CREDITO_VENTA_5', 'TICKET_NOTACREDITO_8', 'TICKET_NOTACREDITO_5'])){

        //footer code
        $this->Ln();
        $this->SetY(-12);
        //Courier B 10
        $this->SetFont('courier','B',10);
        //Titulo de Footer
        $this->Cell(190,5,'FACTURACI. E INVENTARIOS (Administraci., Compras y Ventas)','T',0,'L');
        //$this->AliasNbPages();
        //Numero de Pagina
        $this->Cell(0,5,'Pagina '.$this->PageNo(),'T',1,'R'); 
    }
}
########################## FUNCION PARA MOSTRAR EL FOOTER ############################

########################### FUNCION PARA MOSTRAR CODIGO QR ###########################
function QR($reg, $xpos, $ypos){
    require_once("phpqrcode/qrlib.php");
    //echo json_encode($reg[0]); exit;

    $con = new Login();
    $con = $con->ConfiguracionPorId();
    //$simbolo = $con[0]['simbolo'] ?? $con[0]['simbolo'];

    $jo      = new StdClass();
    $textoQR = 'No Tracking: '.$reg[0]['codfactura'];

    $tempfile = tempnam(sys_get_temp_dir(), '');
    try {
        QRcode::png($textoQR, $tempfile);
        $this->Image($tempfile, $xpos, $this->GetY() + 0, 30, 30, "png");
    } finally {
        unlink($tempfile);
    }
}
########################### FUNCION PARA MOSTRAR CODIGO QR ###########################

########################### FUNCION PARA MOSTRAR EL HEADER ###########################
function Header()
{
    if(in_array(decrypt($_GET['tipo']), ['USUARIOS', 'LOGS', 'SUCURSALES', 'CLIENTES', 'CLIENTESXCREDITOS', 'PROVEEDORES', 'PEDIDOS', 'PEDIDOSXPROVEEDOR', 'PEDIDOSXFECHAS',
        'SERVICIOS', 'SERVICIOSXMONEDA', 'KARDEXSERVICIOS', 'SERVICIOSVALORIZADOXFECHAS', 'SERVICIOSVENDIDOSXFECHAS', 
        'PRODUCTOS', 'PRODUCTOSXSUCURSAL', 'PRODUCTOSXBUSQUEDA', 'STOCKOPTIMO', 'STOCKMEDIO', 'STOCKMINIMO', 'STOCKCERO', 'FECHASOPTIMO', 'FECHASMEDIO', 'FECHASMINIMO', 'PRODUCTOSXMONEDA', 'KARDEXPRODUCTO', 'KARDEXPRODUCTOSVALORIZADO', 'PRODUCTOSVALORIZADOXFECHAS', 'PRODUCTOSVENDIDOSXFECHAS', 'AJUSTEPRODUCTOS', 'AJUSTEPRODUCTOSXBUSQUEDA', 
        'COMBOS', 'COMBOSMINIMO', 'COMBOSMAXIMO', 'COMBOSXMONEDA', 'KARDEXCOMBO', 'KARDEXCOMBOSVALORIZADO', 'COMBOSVALORIZADOXFECHAS', 'COMBOSVENDIDOSXFECHAS', 
        'TRASPASOS', 'TRASPASOSXFECHAS', 'DETALLESTRASPASOSXFECHAS', 
        'COMPRAS', 'COMPRASXBUSQUEDA', 'CUENTASXPAGAR', 'CUENTASXPAGARXBUSQUEDA', 'CUENTASXPAGARVENCIDAS', 'COMPRASXPROVEEDOR', 'COMPRASXFECHAS', 'ABONOSCREDITOSCOMPRASXFECHAS', 'CREDITOSCOMPRASXPROVEEDOR', 'CREDITOSCOMPRASXFECHAS', 'DETALLESCREDITOSCOMPRASXPROVEEDOR', 'DETALLESCREDITOSCOMPRASXFECHAS', 
        'COTIZACIONES', 'COTIZACIONESXBUSQUEDA', 'COTIZACIONESXFECHAS', 'COTIZACIONESXVENDEDOR', 'DETALLESCOTIZACIONESXFECHAS', 'DETALLESCOTIZACIONESXVENDEDOR', 
        'PREVENTAS', 'CLIENTESXPREVENTAS', 'PREVENTASXFECHAS', 'PREVENTASXVENDEDOR', 'DETALLESPREVENTASXFECHAS', 'DETALLESPREVENTASXVENDEDOR',
        'ARQUEOS', 'ARQUEOSXFECHAS', 'GANANCIASXFECHAS', 
        'VENTAS', 'VENTASXBUSQUEDA', 'VENTASDIARIAS', 'LIBROVENTASXFECHAS', 'VENTASXCAJAS', 'VENTASXFECHAS', 'VENTASXCLIENTES', 'VENTASXCONDICIONES', 'COMISIONXVENTAS', 'DETALLESVENTASXCONDICIONES', 'DETALLESVENTASXFECHAS', 'DETALLESVENTASXVENDEDOR', 
        'CREDITOS', 'CREDITOSXBUSQUEDA', 'CREDITOSXBUSQUEDA', 'CREDITOSVENCIDOS', 'ABONOSCREDITOSVENTASXCAJAS', 'CREDITOSVENTASXCONDICIONES', 'CREDITOSVENTASXFECHAS', 'CREDITOSVENTASXCLIENTES', 'DETALLESCREDITOSVENTASXFECHAS', 'DETALLESCREDITOSVENTASXCLIENTES', 
        'NOTASCREDITO', 'NOTASCREDITOXCAJAS', 'NOTASCREDITOXFECHAS', 'NOTASCREDITOXCLIENTES'])){

        if($this->page==1){

        ################################# MEMBRETE LEGAL #################################
        if($_SESSION['acceso'] == "administradorG"){

            $logo = ( file_exists("fotos/logo_pdf.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf.png");
            $logo2 = ( file_exists("fotos/logo_pdf2.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf2.png");
                
            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->Ln(2);
            $this->SetFont('Courier','B',14);
            $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
            $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es AZUL
            $this->Cell(85,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($con[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$con[0]['cuit'],0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            if($con[0]['id_departamento']!='0'){

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($departamento = ($con[0]['id_departamento'] == '0' ? " " : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? " " : $con[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            }

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($con[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,"N.TLF: ".$con[0]['tlfsucursal'],0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($con[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,"",0,0,'C');
            $this->Ln(10);

        } else { 

            $js   = new Login();
            $suc   = $js->SucursalesSessionPorId();

            $logo  = ( file_exists("fotos/sucursales/".$suc[0]['cuitsucursal'].".png") == "" ? "assets/images/null.png" : "fotos/sucursales/".$suc[0]['cuitsucursal'].".png");
            $logo2 = ( file_exists("fotos/logo_pdf.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf.png");

            $this->Ln(2);
            $this->SetFont('Courier','B',14);
            $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
            $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es AZUL
            $this->Cell(85,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_horizontal_X'], $this->GetY()+$GLOBALS['logo1_horizontal_Y'], $GLOBALS['logo1_horizontal']),0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($suc[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_horizontal_X'], $this->GetY()+$GLOBALS['logo2_horizontal_Y'], $GLOBALS['logo2_horizontal']),0,0,'C');

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($suc[0]['documsucursal'] == '0' ? "" : $suc[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$suc[0]['cuitsucursal'],0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            if($suc[0]['id_departamento']!='0'){

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($departamento = ($suc[0]['id_departamento'] == '0' ? " " : $suc[0]['departamento'])." ".$provincia = ($suc[0]['id_provincia'] == '0' ? " " : $suc[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            }

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($suc[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,"N.TLF: ".$suc[0]['tlfsucursal'],0,0,'C');
            $this->Cell(85,5,"",0,0,'C');

            $this->Ln();
            $this->Cell(85,5,"",0,0,'C');
            $this->Cell(165,5,mb_convert_encoding($suc[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(85,5,"",0,0,'C');
            $this->Ln(10);
        }
        ################################# MEMBRETE LEGAL #################################
        }

    } elseif(in_array(decrypt($_GET['tipo']), ['PROVINCIAS', 'DEPARTAMENTOS', 'DOCUMENTOS', 'TIPOMONEDA', 'TIPOCAMBIO', 'MEDIOSPAGOS', 'IMPUESTOS', 'BANCOS', 'FAMILIAS', 'SUBFAMILIAS', 'MARCAS', 'MODELOS', 'PRESENTACIONES', 'COLORES', 'ORIGENES', 'IMEIS', 'CODIGOBARRAS', 'CAJAS', 'MOVIMIENTOS', 'MOVIMIENTOSXFECHAS', 'INFORMECAJASXFECHAS'])){

        if($this->page==1){

        ################################# MEMBRETE A4 #################################
        if($_SESSION['acceso'] == "administradorG"){

            $logo = ( file_exists("fotos/logo_pdf.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf.png");
            $logo2 = ( file_exists("fotos/logo_pdf2.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf2.png");
                
            $con = new Login();
            $con = $con->ConfiguracionPorId();

            $this->Ln(2);
            $this->SetFont('Courier','B',12);
            $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
            $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es AZUL
            $this->Cell(50,4,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($con[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($con[0]['documsucursal'] == '0' ? "" : $con[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$con[0]['cuit'],0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            if($con[0]['id_departamento']!='0'){

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($departamento = ($con[0]['id_departamento'] == '0' ? " " : $con[0]['departamento'])." ".$provincia = ($con[0]['id_provincia'] == '0' ? " " : $con[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            }

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($con[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,"N.TLF: ".$con[0]['tlfsucursal'],0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($con[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,"",0,0,'C');
            $this->Ln(10);

        } else { 

            $js   = new Login();
            $suc   = $js->SucursalesSessionPorId();

            $logo  = ( file_exists("fotos/sucursales/".$suc[0]['cuitsucursal'].".png") == "" ? "assets/images/null.png" : "fotos/sucursales/".$suc[0]['cuitsucursal'].".png");
            $logo2 = ( file_exists("fotos/logo_pdf.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf.png");

            $this->Ln(2);
            $this->SetFont('Courier','B',12);
            $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
            $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es AZUL
            $this->Cell(50,4,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($suc[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($suc[0]['documsucursal'] == '0' ? "" : $suc[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$suc[0]['cuitsucursal'],0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            if($suc[0]['id_departamento']!='0'){

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($departamento = ($suc[0]['id_departamento'] == '0' ? " " : $suc[0]['departamento'])." ".$provincia = ($suc[0]['id_provincia'] == '0' ? " " : $suc[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            }

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($suc[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,"N.TLF: ".$suc[0]['tlfsucursal'],0,0,'C');
            $this->Cell(50,4,"",0,0,'C');

            $this->Ln();
            $this->Cell(50,4,"",0,0,'C');
            $this->Cell(90,4,mb_convert_encoding($suc[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,0,'C');
            $this->Cell(50,4,"",0,0,'C');
            $this->Ln(10);
        }
        ################################# MEMBRETE A4 #################################

        }
    }
}
########################### FUNCION PARA MOSTRAR EL HEADER ###########################




############################################ REPORTES DE CONFIGURACION ############################################

########################## FUNCION LISTAR PROVINCIAS ##############################
function TablaListarProvincias()
{
    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE PROVINCIAS',0,0,'C');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(150,8,'NOMBRE DE PROVINCIA',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarProvincias();

    if($reg==""){
    echo "";      
    } else {
 
    /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,150));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,$reg[$i]["id_provincia"],utf8_decode($reg[$i]["provincia"])));
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PROVINCIAS ##############################

########################## FUNCION LISTAR DEPARTAMENTOS ##############################
function TablaListarDepartamentos()
{
    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE DEPARTAMENTOS',0,0,'C');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE PROVINCIA',1,0,'C', True);
    $this->Cell(75,8,'NOMBRE DE DEPARTAMENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarDepartamentos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,75));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,$reg[$i]["id_departamento"],utf8_decode($reg[$i]["provincia"]),utf8_decode($reg[$i]["departamento"])));
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DEPARTAMENTOS ##############################

########################## FUNCION LISTAR TIPOS DE DOCUMENTOS ##########################
function TablaListarDocumentos()
{
    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE DOCUMENTOS TRIBUTARIOS',0,0,'C');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'NOMBRE DE DOCUMENTO',1,0,'C', True);
    $this->Cell(105,8,'DESCRIPCI. DE DOCUMENTO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarDocumentos();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,50,105));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["coddocumento"]),utf8_decode($reg[$i]["documento"]),utf8_decode($reg[$i]["descripcion"])));
      
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE DOCUMENTOS ##########################

########################## FUNCION LISTAR TIPOS DE MONEDA ##############################
function TablaListarTiposMonedas()
{
    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE TIPOS DE MONEDA',0,0,'C');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(65,8,'NOMBRE DE MONEDA',1,0,'C', True);
    $this->Cell(45,8,'SIGLAS',1,0,'C', True);
    $this->Cell(45,8,'SIMBOLO',1,1,'C', True);
    
    $tra = new Login();
    $reg = $tra->ListarTipoMoneda();

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,65,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codmoneda"]),utf8_decode($reg[$i]["moneda"]),utf8_decode($reg[$i]["siglas"]),utf8_decode($reg[$i]["simbolo"])));
      
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE MONEDA ##############################

########################## FUNCION LISTAR TIPOS DE CAMBIO ##############################
function TablaListarTiposCambio()
{
    $tra = new Login();
    $reg = $tra->ListarTipoCambio();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE TIPOS DE CAMBIO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CAMBIO',1,0,'C', True);
    $this->Cell(35,8,'MONTO DE CAMBIO',1,0,'C', True);
    $this->Cell(35,8,'TIPO DE MONEDA',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE INGRESO',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,70,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["descripcioncambio"]),utf8_decode(number_format($reg[$i]["montocambio"], 2, '.', ',')),utf8_decode($reg[$i]['moneda'].":".$reg[$i]['siglas']),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechacambio'])))));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TIPOS DE CAMBIO ##############################

########################## FUNCION LISTAR MEDIOS DE PAGO ##############################
function TablaListarMediosPagos()
{
    $tra = new Login();
    $reg = $tra->ListarMediosPagos();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE FORMAS DE PAGO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE PAGO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codmediopago"]),utf8_decode($reg[$i]["mediopago"])));
      }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MEDIOS DE PAGO ##############################

########################## FUNCION LISTAR IMPUESTOS ##############################
function TablaListarImpuestos()
{
    $tra = new Login();
    $reg = $tra->ListarImpuestos();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE IMPUESTOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE IMPUESTO',1,0,'C', True);
    $this->Cell(35,8,'VALOR(%)',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA DE INGRESO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,60,35,25,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codimpuesto"]),utf8_decode($reg[$i]["nomimpuesto"]),utf8_decode(number_format($reg[$i]["valorimpuesto"], 2, '.', ',')),utf8_decode($status = ($reg[$i]['statusimpuesto'] == 1 ? "ACTIVO" : "INACTIVO")),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaimpuesto'])))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR IMPUESTOS ##############################

########################## FUNCION LISTAR BANCOS ##############################
function TablaListarBancos()
{
    $tra = new Login();
    $reg = $tra->ListarBancos();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE BANCOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE BANCO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codbanco"]),utf8_decode($reg[$i]["nombanco"])));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR BANCOS ##############################

########################## FUNCION LISTAR FAMILIAS ##############################
function TablaListarFamilias()
{
    $tra = new Login();
    $reg = $tra->ListarFamilias();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE FAMILIAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE FAMILIA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfamilia"]),portales(utf8_decode($reg[$i]["nomfamilia"]))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR FAMILIAS ##############################

########################## FUNCION LISTAR SUB-FAMILIAS ##############################
function TablaListarSubfamilias()
{
    $tra = new Login();
    $reg = $tra->ListarSubfamilias();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE SUB-FAMILIAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE FAMILIA',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE SUBFAMILIA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,20,80,80));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codsubfamilia"]),portales(utf8_decode($reg[$i]["nomfamilia"])),portales(utf8_decode($reg[$i]["nomsubfamilia"]))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SUB-FAMILIAS ##############################

########################## FUNCION LISTAR MARCAS ##############################
function TablaListarMarcas()
{
    $tra = new Login();
    $reg = $tra->ListarMarcas();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE MARCAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE MARCA',1,1,'C', True);
    

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codmarca"]),utf8_decode($reg[$i]["nommarca"])));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MARCAS ##############################

########################## FUNCION LISTAR MODELOS ##############################
function TablaListarModelos()
{
    $tra = new Login();
    $reg = $tra->ListarModelos();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE MODELOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE MARCA',1,0,'C', True);
    $this->Cell(80,8,'NOMBRE DE MODELO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,20,80,80));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codmodelo"]),portales(utf8_decode($reg[$i]["nommarca"])),portales(utf8_decode($reg[$i]["nommodelo"]))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR MODELOS ##############################

########################## FUNCION LISTAR PRESENTACIONES ##############################
function TablaListarPresentaciones()
{
    $tra = new Login();
    $reg = $tra->ListarPresentaciones();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE PRESENTACIONES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE PRESENTACI.',1,1,'C', True);
    

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codpresentacion"]),utf8_decode($reg[$i]["nompresentacion"])));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRESENTACIONES ##############################

########################## FUNCION LISTAR COLORES ##############################
function TablaListarColores()
{
    $tra = new Login();
    $reg = $tra->ListarColores();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE COLORES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE COLOR',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codcolor"]),portales(utf8_decode($reg[$i]["nomcolor"]))));
       }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COLORES ##############################

########################## FUNCION LISTAR ORIGENES ##############################
function TablaListarOrigenes()
{
    $tra = new Login();
    $reg = $tra->ListarOrigenes();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE ORIGENES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(155,8,'NOMBRE DE ORIGEN',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,20,155));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codorigen"]),portales(utf8_decode($reg[$i]["nomorigen"]))));
       }
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ORIGENES ##############################

########################## FUNCION LISTAR IMEIS ##############################
function TablaListarImeis()
{
    $tra = new Login();
    $reg = $tra->ListarImeixBusqueda();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['var']) == 0){ 
    $this->Cell(190,14,'LISTADO GENERAL DE IMEIS',0,0,'C');
    } elseif(decrypt($_GET['var']) == 1){ 
    $this->Cell(190,14,'LISTADO DE IMEIS ACTIVOS',0,0,'C');
    } elseif(decrypt($_GET['var']) == 2){ 
    $this->Cell(190,14,'LISTADO DE IMEIS INACTIVOS',0,0,'C');
    } elseif(decrypt($_GET['var']) == 3){ 
    $this->Cell(190,14,'LISTADO DE IMEIS VENDIDOS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,1,'L'); 
    }

    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(50,8,'N.DE IMEI',1,0,'C', True);
    $this->Cell(90,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'ESTADO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,50,90,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){

    if ($reg[$i]["estadoimei"] == 1) {
        $estado = "ACTIVO";
    } elseif ($reg[$i]["estadoimei"] == 2) {
        $estado = "INACTIVO";
    } elseif ($reg[$i]["estadoimei"] == 3) {
        $estado = "VENDIDO";
    } elseif ($reg[$i]["estadoimei"] == 4) {
        $estado = "PENDIENTE";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["numeroimei"]),portales(utf8_decode($observaciones = ($reg[$i]['observaciones'] == "" ? "********" : $reg[$i]['observaciones']))),portales(utf8_decode($estado))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR IMEIS ##############################

############################################ REPORTES DE CONFIGURACION ############################################









############################################ REPORTES DE USUARIOS ############################################

########################## FUNCION LISTAR USUARIOS ##############################
function TablaListarUsuarios()
{
    $tra = new Login();
    $reg = $tra->ListarUsuarios();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE USUARIOS',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln(10);
        $this->SetFont('courier','B',10);
        $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
        $this->Cell(10,8,'N�',1,0,'C', True);
        $this->Cell(35,8,'N.DOCUMENTO',1,0,'C', True);
        $this->Cell(70,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
        $this->Cell(25,8,'N.TEL�FONO',1,0,'C', True);
        $this->Cell(60,8,'EMAIL',1,0,'C', True);
        $this->Cell(40,8,'USUARIO',1,0,'C', True);
        $this->Cell(45,8,'NIVEL',1,0,'C', True);
        $this->Cell(50,8,'SUCURSAL',1,1,'C', True);

        if($reg==""){
        echo "";      
        } else {
     
         /* AQUI DECLARO LAS COLUMNAS */
        $this->SetWidths(array(10,35,70,25,60,40,45,50));

        /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
        $a=1;
        for($i=0;$i<sizeof($reg);$i++){ 
        $this->SetFont('Courier','',10);  
        $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
        $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["telefono"]),utf8_decode($reg[$i]["email"]),utf8_decode($reg[$i]["usuario"]),utf8_decode($reg[$i]["nivel"]),utf8_decode($reg[$i]['codsucursal'] == '0' ? "******" : $reg[$i]['nomsucursal'])));
       }
    }

    } else {

        $this->Ln(10);
        $this->SetFont('courier','B',10);
        $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
        $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
        $this->Cell(10,8,'N�',1,0,'C', True);
        $this->Cell(30,8,'N.DOCUMENTO',1,0,'C', True);
        $this->Cell(80,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
        $this->Cell(25,8,'SEXO',1,0,'C', True);
        $this->Cell(45,8,'N.DE TEL�FONO',1,0,'C', True);
        $this->Cell(60,8,'EMAIL',1,0,'C', True);
        $this->Cell(45,8,'USUARIO',1,0,'C', True);
        $this->Cell(40,8,'NIVEL',1,1,'C', True);

        if($reg==""){
        echo "";      
        } else {
     
        /* AQUI DECLARO LAS COLUMNAS */
        $this->SetWidths(array(10,30,80,25,45,60,45,40));

        /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
        $a=1;
        for($i=0;$i<sizeof($reg);$i++){ 
        $this->SetFont('Courier','',10);  
        $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
        $this->Row(array($a++,utf8_decode($reg[$i]["dni"]),utf8_decode($reg[$i]["nombres"]),utf8_decode($reg[$i]["sexo"]),utf8_decode($reg[$i]["telefono"]),utf8_decode($reg[$i]["email"]),utf8_decode($reg[$i]["usuario"]),utf8_decode($reg[$i]["nivel"])));
       }
    }
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR USUARIOS ##############################

########################## FUNCION LISTAR LOGS DE USUARIOS ##############################
function TablaListarLogs()
{
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE LOGS DE ACCESO DE USUARIOS',0,0,'C');
    
    $this->Ln(10);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'IP EQUIPO',1,0,'C', True);
    $this->Cell(45,8,'TIEMPO ENTRADA',1,0,'C', True);
    $this->Cell(145,8,'NAVEGADOR DE ACCESO',1,0,'C', True);
    $this->Cell(60,8,'P�GINAS DE ACCESO',1,0,'C', True);
    $this->Cell(40,8,'USUARIO',1,1,'C', True);

    $tra = new Login();
    $reg = $tra->ListarLogs();

    if($reg==""){
    echo "";      
    } else {
    
    /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,45,145,60,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["ip"]),utf8_decode($reg[$i]["tiempo"]),utf8_decode($reg[$i]["detalles"]),utf8_decode($reg[$i]["paginas"]),utf8_decode($reg[$i]["usuario"])));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR LOGS DE USUARIOS ##############################

############################################ REPORTES DE USUARIOS ############################################







############################################ REPORTES DE SUCURSALES ############################################

########################## FUNCION LISTAR SUCURSALES ##############################
function TablaListarSucursales()
{
    $tra = new Login();
    $reg = $tra->ListarSucursales();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE SUCURSALES',0,0,'C');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE REGISTRO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE SUCURSAL',1,0,'C', True);
    $this->Cell(25,8,'PROVINCIA',1,0,'C', True);
    $this->Cell(30,8,'DEPARTAMENTO',1,0,'C', True);
    $this->Cell(55,8,'DIRECCI.',1,0,'C', True);
    $this->Cell(40,8,'CORREO ELECTRONICO',1,0,'C', True);
    $this->Cell(35,8,'N.DE TEL�FONO',1,0,'C', True);
    $this->Cell(45,8,'ENCARGADO',1,1,'C', True);
    

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,60,25,30,55,40,35,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["cuitsucursal"]),utf8_decode($reg[$i]["nomsucursal"]),utf8_decode($reg[$i]['id_provincia'] == '0' ? "********" : $reg[$i]['provincia']),utf8_decode($reg[$i]['id_departamento'] == '0' ? "********" : $reg[$i]['departamento']),utf8_decode($reg[$i]["direcsucursal"]),utf8_decode($reg[$i]["correosucursal"]),utf8_decode($reg[$i]["tlfsucursal"]),utf8_decode($reg[$i]["nomencargado"])));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SUCURSALES ##############################

############################################ REPORTES DE SUCURSALES ############################################








############################################ REPORTES DE CLIENTES ############################################

########################## FUNCION LISTAR CLIENTES ##############################
function TablaListarClientes()
{
    $tra = new Login();
    $reg = $tra->ListarClientes();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE CLIENTES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(35,8,'N.DE TELEFONO',1,0,'C', True);
    $this->Cell(70,8,'DIRECCI. DOMICILIARIA',1,0,'C', True);
    $this->Cell(65,8,'CORREO ELECTRONICO',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'CR�DITO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,35,70,65,30,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["documento"]." ".$reg[$i]["dnicliente"]),
        portales(utf8_decode($cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']))),
        utf8_decode($reg[$i]["tlfcliente"]),
        utf8_decode($direccliente = ($reg[$i]['direccliente'] == '' ? "******" : $reg[$i]['direccliente']).$departamento = ($reg[$i]['id_departamento'] == '0' ? "" : ", ".$reg[$i]['departamento']).$provincia = ($reg[$i]['id_provincia'] == '0' ? "" : " - ".$reg[$i]['provincia'])),
        utf8_decode($reg[$i]['emailcliente']),
        utf8_decode($reg[$i]["tipocliente"]),
        utf8_decode(number_format($reg[$i]["limitecredito"], 2, '.', ','))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CLIENTES ##############################

########################## FUNCION LISTAR CLIENTES X CREDITOS ACTIVOS ##############################
function TablaListarClientesxCreditos()
{
    $tra = new Login();
    $reg = $tra->ListarClientesxCreditosActivos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CR�DITOS ACTIVOS A CLIENTES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln();
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRES Y APELLIDOS',1,0,'C', True);
    $this->Cell(35,8,'N.DE TELEFONO',1,0,'C', True);
    $this->Cell(60,8,'DIRECCI. DOMICILIARIA',1,0,'C', True);
    $this->Cell(60,8,'CORREO ELECTRONICO',1,0,'C', True);
    $this->Cell(30,8,'TIPO',1,0,'C', True);
    $this->Cell(40,8,'CR�DITO PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,35,60,60,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalCredito=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCredito+=$reg[$i]['montocredito'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["documento"]." ".$reg[$i]["dnicliente"]),
        portales(utf8_decode($reg[$i]["nomcliente"])),
        utf8_decode($reg[$i]["tlfcliente"]),
        utf8_decode($direccliente = ($reg[$i]['direccliente'] == '' ? "******" : $reg[$i]['direccliente']).$departamento = ($reg[$i]['id_departamento'] == '0' ? "" : ", ".$reg[$i]['departamento']).$provincia = ($reg[$i]['id_provincia'] == '0' ? "" : " - ".$reg[$i]['provincia'])),
        utf8_decode($email = ($reg[$i]['emailcliente'] == '' ? "*******" : $reg[$i]['emailcliente'])),
        utf8_decode($reg[$i]["tipocliente"]),
        utf8_decode(number_format($reg[$i]["montocredito"], 2, '.', ','))));
    }
   
    $this->Cell(295,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode(number_format($TotalCredito, 2, '.', ',')),0,0,'L');
    $this->Ln();
        
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CLIENTES X CREDITOS ACTIVOS ##############################

############################################ REPORTES DE CLIENTES ############################################









############################################ REPORTES DE PROVEEDORES ############################################

########################## FUNCION LISTAR PROVEEDORES ##############################
function TablaListarProveedores()
{
    $tra = new Login();
    $reg = $tra->ListarProveedores();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO GENERAL DE PROVEEDORES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){
        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(60,8,'NOMBRE DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'N.DE TLF',1,0,'C', True);
    $this->Cell(75,8,'DIRECCI. DOMICILIARIA',1,0,'C', True);
    $this->Cell(60,8,'CORREO ELECTRONICO',1,0,'C', True);
    $this->Cell(40,8,'VENDEDOR',1,0,'C', True);
    $this->Cell(25,8,'N.DE TLF',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,25,75,60,40,25));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["documento"]." ".$reg[$i]["cuitproveedor"]),portales(utf8_decode($reg[$i]["nomproveedor"])),utf8_decode($reg[$i]["tlfproveedor"]),utf8_decode($direcproveedor = ($reg[$i]['direcproveedor'] == '' ? "******" : $reg[$i]['direcproveedor']).$departamento = ($reg[$i]['id_departamento'] == '0' ? "" : ", ".$reg[$i]['departamento']).$provincia = ($reg[$i]['id_provincia'] == '0' ? "" : " - ".$reg[$i]['provincia'])),utf8_decode($reg[$i]['emailproveedor']),utf8_decode($reg[$i]["vendedor"]),utf8_decode($reg[$i]["tlfvendedor"])));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PROVEEDORES ##############################

########################## FUNCION FACTURA PEDIDO ##############################
function FacturaPedido()
{   
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
        
    $tra = new Login();
    $reg = $tra->PedidosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

           $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
           $this->Image($logo, 15, 11, 30, 16, "PNG");

        } else {

           $logo = "fotos/logo_principal.png";
           $this->Image($logo, 15, 10, 40, 16, "PNG");                         
        }                                      
    }

    ######################## BLOQUE N.1 FACTURA ##########################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 17, '1.5', '');
    
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', 'F');

    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(98, 12, 12, 12, '1.5', '');

    $this->SetFont($TipoLetra,'B',16);
    $this->SetXY(101, 14);
    $this->Cell(20, 5, 'P', 0 , 0);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(98, 19);
    $this->Cell(20, 5, 'Pedido', 0, 0);
    
    $this->SetFont($TipoLetra,'B',11);
    $this->SetXY(124, 12);
    $this->Cell(20, 5, 'N.DE FACTURA ', 0, 0);
    $this->SetFont($TipoLetra,'B',11);
    $this->SetXY(176, 12);
    $this->Cell(22, 5,utf8_decode($reg[0]['codfactura']), 0, 0, "R");

    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(124, 16);
    $this->Cell(20, 5, 'FECHA DE PEDIDO ', 0, 0);
    $this->SetFont($TipoLetra,'',9);
    $this->SetXY(177, 16);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y H:i:s",strtotime($reg[0]['fechapedido']))), 0, 0, "R");

    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(124, 20);
    $this->Cell(20, 5, 'FECHA DE EMISI.', 0, 0);
    $this->SetFont($TipoLetra,'',9);
    $this->SetXY(177, 20);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y H:i:s")), 0, 0, "R");
    ############################### BLOQUE N.1 FACTURA ############################### 

    ############################### BLOQUE N.2 SUCURSAL ##############################   
    //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(10, 30);
    $this->Cell(190, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(10, 34);
    $this->Cell(25, 4, 'RAZ. SOCIAL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(35, 34);
    $this->CellFitSpace(60, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(95, 34);
    $this->Cell(40, 4, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(135, 34);
    $this->CellFitSpace(20, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(155, 34);
    $this->Cell(20, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(175, 34);
    $this->CellFitSpace(25, 4,utf8_decode($tlf = ($reg[0]['tlfsucursal'] == '' ? " " : $reg[0]['tlfsucursal'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(10, 38);
    $this->Cell(25, 4, 'DIRECCI.:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(35, 38);
    $this->CellFitSpace(100, 4,utf8_decode($provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento']." ").$reg[0]['direcsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(135, 38);
    $this->Cell(20, 4, 'EMAIL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(155, 38);
    $this->CellFitSpace(45, 4,utf8_decode($correo = ($reg[0]['correosucursal'] == '' ? " " : $reg[0]['correosucursal'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(10, 42);
    $this->Cell(25, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(35, 42);
    $this->CellFitSpace(60, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(95, 42);
    $this->CellFitSpace(40, 4, 'N.DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(135, 42);
    $this->CellFitSpace(20, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(155, 42);
    $this->Cell(20, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(175, 42);
    $this->CellFitSpace(25, 4,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? " " : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################# BLOQUE N.2 SUCURSAL ##############################   

    ############################# BLOQUE N.3 PROVEEDOR #################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 49, 190, 14, '1.5', '');

    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(10, 50);
    $this->Cell(190, 4, 'DATOS DEL PROVEEDOR', 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(10, 54);
    $this->Cell(20, 4, 'PROVEEDOR:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(30, 54);
    $this->Cell(65, 4,utf8_decode($reg[0]['nomproveedor']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(95, 54);
    $this->CellFitSpace(30, 4, 'N.DE '.$documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(125, 54);
    $this->Cell(30, 4,utf8_decode($reg[0]['cuitproveedor']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(155, 54);
    $this->Cell(20, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(175, 54);
    $this->Cell(25, 4,utf8_decode($reg[0]['tlfproveedor']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(10, 58);
    $this->Cell(20, 4, 'DIRECCI.:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(30, 58);
    $this->CellFitSpace(65, 4,getSubString(utf8_decode($provincia = ($reg[0]['id_provincia2'] == '' ? "" : $reg[0]['provincia2']." ").$departamento = ($reg[0]['id_departamento2'] == '' ? "" : $reg[0]['departamento2']." ").$reg[0]['direcproveedor']),38), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(95, 58);
    $this->Cell(15, 4, 'EMAIL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(110, 58);
    $this->CellFitSpace(40, 4,utf8_decode($email = ($reg[0]['emailproveedor'] == '' ? "" : $reg[0]['emailproveedor'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(150, 58);
    $this->Cell(18, 4, 'VENDEDOR:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(168, 58);
    $this->CellFitSpace(32, 4,getSubString(utf8_decode($reg[0]['vendedor']),22), 0, 0); 
    ############################## BLOQUE N.3 PROVEEDOR ###############################  

    ################################# BLOQUE N.4 #######################################   
    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(10, 65);
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->CellFitSpace(8, 10,"N�", 1, 0, 'C', True);
    $this->CellFitSpace(55, 10,"DESCRIPCI. DE PRODUCTO", 1, 0, 'C', True);
    $this->CellFitSpace(20, 10,"MARCA", 1, 0, 'C', True);
    $this->CellFitSpace(20, 10,"MODELO", 1, 0, 'C', True);
    $this->CellFitSpace(12, 10,"CANT", 1, 0, 'C', True);
    $this->MultiAlignCell2(20, 10,"PRECIO UNITARIO", 1, 0, 'C', True);
    $this->MultiAlignCell2(20, 10,"VALOR TOTAL", 1, 0, 'C', True);
    $this->CellFitSpace(15, 10,"DESC %", 1, 0, 'C', True);
    $this->MultiAlignCell2(20, 10,"VALOR NETO", 1, 1, 'C', True);
    ################################# BLOQUE N.4 ####################################### 

    ################################# BLOQUE N.5 #######################################
    $tra = new Login();
    $detalle = $tra->VerDetallesPedidos();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(8,55,20,20,12,20,20,15,20));
    $this->SetAligns(array('L','L','L','C','C','C','C','C','C'));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["preciocompra"]*$detalle[$i]["cantidad"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(10);
    $this->SetFont($TipoLetra,'',7);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture(array($a++,
        portales(utf8_decode($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : "").$imei = ($detalle[$i]["imei"] != "" ? "\nIMEI: ".$detalle[$i]["imei"] : ""))),
        utf8_decode($detalle[$i]["codmarca"] == '0' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["codmodelo"] == '0' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode(number_format($detalle[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ',')),
        utf8_decode(number_format($detalle[$i]['descfactura'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N.5 ####################################### 

    ########################### BLOQUE N.6 #############################
    $this->Ln();
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'INFORMACI. ADICIONAL',1,0,'C', True);
    $this->Cell(2,5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(45,5,'DESCONTADO:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]['totaldescuento'], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'SUBTOTAL:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'TIPO DE DOCUMENTO: FACTURA',1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'REALIZADO: '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'FECHA DE EMISI.: '.date("d/m/Y"),1,0,'L');

    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'HORA DE EMISI.: '.date("H:i:s"),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(6);
    
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(196,8,$this->SetFont($TipoLetra,'B',10).'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'J');
    $this->Ln();

    if($reg[0]['observaciones'] != ''){
    //Linea de membrete Nro 4
    $this->SetFont($TipoLetra,'B',10);
    $this->MultiCell(190,5,$this->SetFont($TipoLetra,'',10).'OBSERVACIONES: '.utf8_decode($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']),1,'J');
    }
    ########################### BLOQUE N.6 #############################
    $this->Ln();
}
########################## FUNCION FACTURA PEDIDO ##############################

########################## FUNCION LISTAR PEDIDOS A PROVEEDORES ##############################
function TablaListarPedidos()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->ListarPedidos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PEDIDOS A PROVEEDORES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,80,30,25,35,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'])." ".$reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechapedido']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PEDIDOS A PROVEEDORES ##############################

########################## FUNCION LISTAR PEDIDOS POR PROVEEDORES ##############################
function TablaListarPedidosxProveedor()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarPedidosxProveedor();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PEDIDOS POR PROVEEDORES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.DE ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']).": ".$reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".utf8_decode($reg[0]['nomproveedor']),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"N.DE TELEFONO: ".utf8_decode($reg[0]['tlfproveedor'] == "" ? "********" : $reg[0]['tlfproveedor']),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DIRECCI. DOMICILIARIA: ".portales(utf8_decode($reg[0]['direcproveedor'] == "" ? "********" : $reg[0]['direcproveedor'])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,65,45,25,35,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($observaciones = ($reg[$i]["observaciones"] == "" ? "********" : $reg[$i]["observaciones"]))),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechapedido']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PEDIDOS POR PROVEEDORES ##############################

########################## FUNCION LISTAR PEDIDOS POR FECHAS ##############################
function TablaListarPedidosxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarPedidosxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PEDIDOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,80,30,25,35,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($documproveedor = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'])." ".$reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechapedido']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PEDIDOS POR FECHAS ##############################

############################################ REPORTES DE PROVEEDORES ############################################











############################################ REPORTES DE SERVICIOS ############################################

########################## FUNCION LISTAR SERVICIOS ##############################
function TablaListarServicios()
{
    $tra = new Login();
    $reg = $tra->ListarServicios();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE SERVICIOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(125,8,'DESCRIPCI. DE SERVICIO',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'ESTADO',1,0,'C', True);
    $this->Cell(40,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(40,8,'PRECIO VENTA',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,125,30,30,30,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalCompra=0;
    $TotalVenta=0;
    for($i=0;$i<sizeof($reg);$i++){ 
    $TotalCompra+=$reg[$i]['preciocompra'];
    $TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descservicio']/100;
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']." ");

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codservicio"]),utf8_decode($reg[$i]["servicio"]),utf8_decode($reg[$i]['ivaservicio'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),utf8_decode($reg[$i]['descservicio']),utf8_decode($reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"),utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','))));
    }

    $this->Cell(255,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS ##############################

########################## FUNCION LISTAR SERVICIOS POR MONEDA ##############################
function TablaListarServiciosxMoneda()
{
    $cambio = new Login();
    $cambio = $cambio->BuscarTiposCambios();
    $tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['simbolo']);

    $tra = new Login();
    $reg = $tra->ListarServicios();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE SERVICIOS POR MONEDA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"MONEDA: ".utf8_decode($cambio[0]["moneda"]),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(85,8,'DESCRIPCI. DE SERVICIO',1,0,'C', True);
    $this->Cell(35,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(20,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO C. '.$cambio[0]['siglas'],1,0,'C', True);
    $this->Cell(30,8,'PRECIO V. '.$cambio[0]['siglas'],1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,85,35,25,20,35,35,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalCompra       = 0;
    $TotalVenta        = 0;
    $TotalMonedaCompra = 0;
    $TotalMonedaVenta  = 0; 
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo  = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 

    $TotalCompra       += number_format($reg[$i]['preciocompra'], 2, '.', ',');
    $TotalVenta        += number_format($reg[$i]['precioventa'], 2, '.', '');

    $TotalMonedaCompra += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
    $TotalMonedaVenta  += number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', '');  
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codservicio"]),
        portales(utf8_decode($reg[$i]["servicio"])),
        utf8_decode($reg[$i]['ivaservicio'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode($reg[$i]['descservicio']),
        utf8_decode($reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',') : "******")),
        utf8_decode($tipo_simbolo.number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','))));
    }

    $this->Cell(205,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaVenta, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS POR MONEDA ##############################

########################## FUNCION LISTAR KARDEX POR SERVICIO ##############################
function TablaListarKardexServicios()
{
    $detalle = new Login();
    $detalle = $detalle->DetalleKardexServicio();

    $kardex = new Login();
    $kardex = $kardex->BuscarKardexServicio();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE KARDEX POR SERVICIO ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($detalle[0]['documento']).": ".utf8_decode($detalle[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($detalle[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($detalle[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(50,8,'REALIZADO POR',1,0,'C', True);
    $this->Cell(25,8,'MOVIMIENTO',1,0,'C', True);
    $this->Cell(25,8,'ENTRADAS',1,0,'C', True);
    $this->Cell(25,8,'SALIDAS',1,0,'C', True);
    $this->Cell(25,8,'DEVOLUCI.',1,0,'C', True);
    $this->Cell(20,8,'STOCK',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'PRECIO',1,0,'C', True);
    $this->Cell(40,8,'DOCUMENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA KARDEX',1,1,'C', True);

    if($kardex==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,50,25,25,25,25,20,30,20,30,40,30));

    $TotalEntradas   = 0;
    $TotalSalidas    = 0;
    $TotalDevolucion = 0;
    $a=1;
    for($i=0;$i<sizeof($kardex);$i++){ 
    $simbolo = ($detalle[0]['simbolo'] == "" ? "" : $detalle[0]['simbolo']);
    $TotalEntradas   += $kardex[$i]['entradas'];
    $TotalSalidas    += $kardex[$i]['salidas'];
    $TotalDevolucion += $kardex[$i]['devolucion'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres'])),
        utf8_decode($kardex[$i]["movimiento"]),
        utf8_decode(number_format($kardex[$i]["entradas"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]["salidas"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]["devolucion"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]['stockactual'], 2, '.', ',')),
        utf8_decode($kardex[$i]['ivaproducto']),
        utf8_decode(number_format($kardex[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($kardex[$i]['precio'], 2, '.', ',')),
        portales(utf8_decode($kardex[$i]['documento'])),
        utf8_decode(date("d/m/Y H:i:s",strtotime($kardex[$i]['fechakardex'])))));
        }
    }

    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(120,5,'DETALLES DEL SERVICIO',1,0,'C', True);
    $this->Ln();
    
    $this->Cell(35,5,'C�DIGO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['codservicio']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DESCRIPCI.',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['servicio']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalEntradas, 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalSalidas, 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DEVOLUCI.',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalDevolucion, 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "******")),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO VENTA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioventa'], 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX POR SERVICIO ##############################

########################## FUNCION LISTAR SERVICIOS VALORIZADO POR FECHAS ##############################
function TablaListarKardexServiciosValorizadoxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarServiciosValorizadoxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX SERVICIOS VALORIZADO POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(25,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(30,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(35,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,60,25,20,30,30,20,40,40,35));

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
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"])),
        utf8_decode($reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),        
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta, 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumCompra, 2, '.', ',') : "0.00")),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "******"))));
    }
   
    $this->Cell(200,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "******")),0,0,'L');
    $this->Ln();
   }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX SERVICIOS VALORIZADO POR FECHAS ##############################

########################## FUNCION LISTAR SERVICIOS VENDIDOS POR FECHAS ##############################
function TablaListarServiciosVendidos()
{
    $tra = new Login();
    $reg = $tra->BuscarServiciosVendidosxFechas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE SERVICIOS VENDIDOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    } 

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(130,8,'DESCRIPCI. DE SERVICIO',1,0,'C', True);
    $this->Cell(40,8,'PRECIO VENTA',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'VENDIDO',1,0,'C', True);
    $this->Cell(40,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,25,130,40,30,30,30,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $PrecioVentaTotal = 0;
    $VendidosTotal    = 0;
    $TotalDescuento   = 0;
    $TotalImpuesto    = 0;
    $TotalGeneral     = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codproducto"]),utf8_decode($reg[$i]["producto"]),utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),utf8_decode($SubtotalImpuesto),utf8_decode($SubtotalDescuento),utf8_decode($reg[$i]['cantidad']),utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(205,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalGeneral, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR SERVICIOS VENDIDOS POR FECHAS ##############################

############################################ REPORTES DE SERVICIOS ############################################










############################################ REPORTES DE PRODUCTOS ############################################

########################## FUNCION LISTAR PRODUCTOS ##############################
function TablaListarProductos()
{
    $tra = new Login();
    $reg = $tra->ListarProductos(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(25,8,'MARCA',1,0,'C', True);
    $this->Cell(25,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,60,25,25,20,20,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS ##############################

########################## FUNCION LISTAR PRODUCTOS ASOCIADOS ##############################
function TablaListarProductosxSucursales()
{
    $tra = new Login();
    $reg = $tra->ListarProductosxSucursales(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS POR SUCURSAL',0,0,'C');

    $this->Ln();
    $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(25,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,70,30,30,25,25,25,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS ASOCIADOS ##############################

########################## FUNCION LISTAR PRODUCTOS POR BUSQUEDA ##############################
function TablaListarProductosxBusqueda()
{
    $tra = new Login();
    $reg = $tra->BusquedaProductos(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    if($_GET["tipobusqueda"] == 1){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR FAMILIA/SUBFAMILIA',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 2){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR MARCA/MODELO',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 3){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR PRESENTACI.',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 4){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR COLOR',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 5){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR ORIGEN',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 6){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR PROVEEDOR',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 7){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR FAMILIA/PROVEEDOR',0,0,'C');
    } elseif($_GET["tipobusqueda"] == 8){
        $this->Cell(335,10,'LISTADO DE PRODUCTOS POR MARCA/PROVEEDOR',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    if($_GET["tipobusqueda"] == 1){

    $this->Ln();
    $this->Cell(335,6,"FAMILIA: ".portales(utf8_decode($reg[0]["nomfamilia"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUBFAMILIA: ".portales(utf8_decode($subfamilia = ($_GET["codsubfamilia"] == 0 ? "******" : $reg[0]["nomsubfamilia"]))),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 2){

    $this->Ln();
    $this->Cell(335,6,"MARCA: ".portales(utf8_decode($reg[0]["nomcolor"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"MODELO: ".portales(utf8_decode($modelo = ($_GET["codmodelo"] == 0 ? "******" : $reg[0]["nommodelo"]))),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 3){

    $this->Ln();
    $this->Cell(335,6,"PRESENTACI.: ".portales(utf8_decode($reg[0]["nompresentacion"])),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 4){

    $this->Ln();
    $this->Cell(335,6,"COLOR: ".portales(utf8_decode($reg[0]["nomcolor"])),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 5){

    $this->Ln();
    $this->Cell(335,6,"ORIGEN: ".portales(utf8_decode($reg[0]["nomorigen"])),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 6){

    $this->Ln();
    $this->Cell(335,6,"N.".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'])).": ".portales(utf8_decode($reg[0]["cuitproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 7){

    $this->Ln();
    $this->Cell(335,6,"FAMILIA: ".portales(utf8_decode($reg[0]["nomfamilia"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"N.".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'])).": ".portales(utf8_decode($reg[0]["cuitproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L');

    } elseif($_GET["tipobusqueda"] == 8){

    $this->Ln();
    $this->Cell(335,6,"MARCA: ".portales(utf8_decode($reg[0]["nommarca"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"N.".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'])).": ".portales(utf8_decode($reg[0]["cuitproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L');

    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(25,8,'MARCA',1,0,'C', True);
    $this->Cell(25,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,60,25,25,20,20,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS POR BUSQUEDA ##############################

########################## FUNCION LISTAR PRODUCTOS EN STOCK OPTIMO ##############################
function TablaListarProductosOptimo()
{
    $tra = new Login();
    $reg = $tra->ListarProductosOptimo(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN STOCK �PTIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'STOCK �PT.',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,20,20,20,20,25,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockoptimo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK OPTIMO ##############################

########################## FUNCION LISTAR PRODUCTOS EN STOCK MEDIO ##############################
function TablaListarProductosMedio()
{
    $tra = new Login();
    $reg = $tra->ListarProductosMedio(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN STOCK MEDIO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'STOCK MED.',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,20,20,20,20,25,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockmedio'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MEDIO ##############################

########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ##############################
function TablaListarProductosMinimo()
{
    $tra = new Login();
    $reg = $tra->ListarProductosMinimo(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN STOCK MINIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'STOCK MIN.',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,20,20,20,20,25,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockminimo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK MINIMO ##############################

########################## FUNCION LISTAR PRODUCTOS EN STOCK CERO ##############################
function TablaListarProductosCero()
{
    $tra = new Login();
    $reg = $tra->ListarProductosCero(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS SIN EXISTENCIA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(25,8,'MARCA',1,0,'C', True);
    $this->Cell(25,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,65,25,25,20,20,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN STOCK CERO ##############################

########################## FUNCION LISTAR PRODUCTOS EN FECHA OPTIMO ##############################
function TablaListarProductosFechasOptimo()
{
    $tra = new Login();
    $reg = $tra->ListarProductosFechasOptimo(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN FECHA OPTIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'STOCK �PT.',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,20,20,20,20,25,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockoptimo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN FECHA OPTIMO ##############################

########################## FUNCION LISTAR PRODUCTOS EN FECHA MEDIO ##############################
function TablaListarProductosFechasMedio()
{
    $tra = new Login();
    $reg = $tra->ListarProductosFechasMedio(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN FECHA MEDIO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'STOCK MED.',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,20,20,20,20,25,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockmedio'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN FECHA MEDIO ##############################

########################## FUNCION LISTAR PRODUCTOS EN FECHA MINIMO ##############################
function TablaListarProductosFechasMinimo()
{
    $tra = new Login();
    $reg = $tra->ListarProductosFechasMinimo(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS EN FECHA MINIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(50,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(25,8,'STOCK MIN.',1,0,'C', True);
    $this->Cell(25,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(30,8,'P. COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'P. MENOR',1,0,'C', True);
    $this->Cell(30,8,'P. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,50,20,20,20,20,25,25,30,30,30,30));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;
    
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockminimo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalCompra, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS EN FECHA MINIMO ##############################

##################### FUNCION LISTAR CODIGO DE BARRAS DE PRODUCTOS #####################
function TablaListarCodigoBarras()
{
    $tra = new Login();
    $reg = $tra->ListarCodigoBarra();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO DE C�DIGO DE BARRAS DE PRODUCTOS',0,0,'C');
    $this->Ln();

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    $this->Ln(10);

    }

    if($reg==""){
    echo "";      
    } else {

    $rows = 0;
    for($i=0;$i<sizeof($reg);$i++){
    $this->SetDrawColor(3,3,3);
    //$this->DashedRect(10,50,65,64);

    $code = ($reg[$i]['codigobarra']);

    barcode('fpdf/codigos/'.$code.'.png', $code, 20, 'horizontal', 'code128', true);

    $this->MultiAlignCell(63,18,$this->Image('fpdf/codigos/'.$code.'.png',14, $this->GetY()+4, 58), 1, 0, "PNG" );
    $this->MultiAlignCell(63,18,$this->Image('fpdf/codigos/'.$code.'.png',76, $this->GetY()+4, 58), 1, 0, "PNG" );
    $this->MultiAlignCell(63,18,$this->Image('fpdf/codigos/'.$code.'.png',140, $this->GetY()+4, 58), 1, 0, "PNG" );
    $this->Ln(18);

        $rows++;
     
        if ($rows>=11) {
            $rows = 0;
            $this->AddPage();
        }
        }
    }
}
##################### FUNCION LISTAR CODIGO DE BARRAS DE PRODUCTOS ###################

########################## FUNCION LISTAR PRODUCTOS POR MONEDA ##############################
function TablaListarProductosxMoneda()
{
    $cambio = new Login();
    $cambio = $cambio->BuscarTiposCambios();
    $siglas = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['siglas']);
    $tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['simbolo']);

    $tra = new Login();
    $reg = $tra->ListarProductos(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PRODUCTOS POR MONEDA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"MONEDA: ".utf8_decode($cambio[0]["moneda"]),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DCTO %',1,0,'C', True);
    $this->Cell(30,8,'EXIST.',1,0,'C', True);
    $this->Cell(30,8,'PREC. MAYOR',1,0,'C', True);
    $this->Cell(30,8,'PREC. MENOR',1,0,'C', True);
    $this->Cell(30,8,'PREC. P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,25,70,30,30,25,20,30,30,30,30));

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

    $TotalCompra        += number_format($reg[$i]['preciocompra'], 2, '.', ',');
    $TotalMayor         += number_format($reg[$i]['precioxmayor'], 2, '.', '');
    $TotalMenor         += number_format($reg[$i]['precioxmenor'], 2, '.', '');
    $TotalPublico       += number_format($reg[$i]['precioxpublico'], 2, '.', '');

    $TotalMonedaCompra  += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
    $TotalMonedaMayor   += number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', '');
    $TotalMonedaMenor   += number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', '');
    $TotalMonedaPublico += number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', '');
    $TotalArticulos     += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codproducto"]),portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),utf8_decode($reg[$i]['codmodelo'] == '0' ? "******" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $tipo_simbolo).utf8_decode(number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ',')),
        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $tipo_simbolo).utf8_decode(number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ',')),
        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $tipo_simbolo).utf8_decode(number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','))));
    }

    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS POR MONEDA ##############################

########################## FUNCION LISTAR KARDEX POR PRODUCTOS ##############################
function TablaListarKardexProducto()
{
    $detalle = new Login();
    $detalle = $detalle->DetalleKardexProducto();

    $kardex = new Login();
    $kardex = $kardex->BuscarKardexProducto();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE KARDEX POR PRODUCTO ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($detalle[0]['documento']).": ".utf8_decode($detalle[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($detalle[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($detalle[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(50,8,'REALIZADO POR',1,0,'C', True);
    $this->Cell(25,8,'MOVIMIENTO',1,0,'C', True);
    $this->Cell(25,8,'ENTRADAS',1,0,'C', True);
    $this->Cell(25,8,'SALIDAS',1,0,'C', True);
    $this->Cell(25,8,'DEVOLUCI.',1,0,'C', True);
    $this->Cell(20,8,'STOCK',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'PRECIO',1,0,'C', True);
    $this->Cell(40,8,'DOCUMENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA KARDEX',1,1,'C', True);

    if($kardex==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,50,25,25,25,25,20,30,20,30,40,30));

    $TotalEntradas   = 0;
    $TotalSalidas    = 0;
    $TotalDevolucion = 0;
    $a=1;
    for($i=0;$i<sizeof($kardex);$i++){ 
    $simbolo = ($detalle[0]['simbolo'] == "" ? "" : $detalle[0]['simbolo']);
    $TotalEntradas   += $kardex[$i]['entradas'];
    $TotalSalidas    += $kardex[$i]['salidas'];
    $TotalDevolucion += $kardex[$i]['devolucion'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres'])),
        utf8_decode($kardex[$i]["movimiento"]),
        utf8_decode(number_format($kardex[$i]["entradas"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]["salidas"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]["devolucion"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]['stockactual'], 2, '.', ',')),
        utf8_decode($kardex[$i]['ivaproducto']),
        utf8_decode(number_format($kardex[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($kardex[$i]['precio'], 2, '.', ',')),
        portales(utf8_decode($kardex[$i]['documento'])),
        utf8_decode(date("d/m/Y H:i:s",strtotime($kardex[$i]['fechakardex'])))));
        }
    }

    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(120,5,'DETALLES DEL PRODUCTO',1,0,'C', True);
    $this->Ln();
    
    $this->Cell(35,5,'C�DIGO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['codproducto']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DESCRIPCI.',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,portales(utf8_decode($detalle[0]['producto'])),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalEntradas, 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalSalidas, 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'DEVOLUCI.',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalDevolucion, 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,'STOCK',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($detalle[0]['existencia'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "******")),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P. VENTA MAYOR',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxmayor'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P.VENTA MENOR',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxmenor'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P. VENTA P�BLICO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxpublico'], 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX POR PRODUCTO ##############################

########################## FUNCION LISTAR PRODUCTOS KARDEX VALORIZADO ##############################
function TablaListarKardexProductosValorizado()
{
    $tra = new Login();
    $reg = $tra->ListarKardexProductosValorizado(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX PRODUCTOS VALORIZADO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(25,8,'STOCK',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(30,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,65,30,30,25,15,25,40,40,30));

    $a=1;
    $PrecioCompraTotal    = 0;
    $PrecioVentaTotal     = 0;
    $ExisteTotal          = 0;
    $ImpuestosCompraTotal = 0;
    $ImpuestosVentaTotal  = 0;
    $CompraTotal          = 0;
    $VentaTotal           = 0;
    $TotalGanancia        = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioCompraTotal    += $reg[$i]['preciocompra'];
    $PrecioVentaTotal     += $reg[$i]['precioxpublico'];
    $ExisteTotal          += $reg[$i]['existencia'];

    $Descuento            = $reg[$i]['descproducto']/100;
    $PrecioDescuento      = $reg[$i]['precioxpublico']*$Descuento;
    $PrecioFinal          = $reg[$i]['precioxpublico']-$PrecioDescuento;

    //VALOR DE IMPUESTO
    $ValorIva = 1 + ($reg[$i]['valorimpuesto']/100);

    //CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
    $DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
    $SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
    $BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
    $SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

    //CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
    $DiscriminadoV         = $PrecioFinal/$ValorIva;
    $SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
    $BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
    $SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

    $SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
    $SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

    $CompraTotal          += $SumCompra;
    $ImpuestosCompraTotal += $SubtotalimpuestosC;
    $VentaTotal           += $SumVenta;
    $ImpuestosVentaTotal  += $SubtotalimpuestosV;
    $TotalGanancia        += $SumVenta-$SumCompra;

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "0.00")),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"))));
    }
   
    $this->Cell(200,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "******")),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS KARDEX VALORIZADO ##############################

########################## FUNCION LISTAR PRODUCTOS KARDEX VALORIZADO POR FECHAS ##############################
function TablaListarProductosValorizadoxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarProductosValorizadoxFechas(); 

    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX PRODUCTOS VALORIZADO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(25,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(25,8,'VENDIDO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(30,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,65,30,30,25,15,25,40,40,30));

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
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode($reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta, 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumCompra, 2, '.', ',') : "0.00")),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"))));
    }
   
    $this->Cell(200,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "******")),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS KARDEX VALORIZADO POR FECHAS ##############################

########################## FUNCION LISTAR PRODUCTOS VENDIDOS POR FECHAS ##############################
function TablaListarProductosVendidosxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarProductosVendidosxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO PRODUCTOS VENDIDOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(40,8,'MARCA',1,0,'C', True);
    $this->Cell(40,8,'MODELO',1,0,'C', True);
    $this->Cell(30,8,'VENDIDO',1,0,'C', True);
    $this->Cell(35,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(30,8,'DESC %',1,0,'C', True);
    $this->Cell(50,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,75,40,40,30,35,30,50));

    $a=1;
    $PrecioVentaTotal = 0;
    $VendidosTotal    = 0;
    $TotalDescuento   = 0;
    $TotalImpuesto    = 0;
    $TotalGeneral     = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode(number_format($SubtotalImpuesto, 2, '.', ',')),
        utf8_decode(number_format($SubtotalDescuento, 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalGeneral, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PRODUCTOS VENDIDOS POR FECHAS ##############################

############################################ REPORTES DE PRODUCTOS ############################################


















############################## REPORTES DE AJUSTES DE PRODUCTOS ##############################

########################## FUNCION TICKET AJUSTES STOCK (8MM) ##############################
function TicketAjuste_8()
{  
    $tra = new Login();
    $reg = $tra->AjustesProductosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 15, 3, 45, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(2);
    $this->SetFont('Courier','B',12);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE AJUSTE", 0, 0, 'C');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".$reg[0]['documento']." ".mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(24,4,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(46,4,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,4,"RESPONSABLE:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechaajuste'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechaajuste'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,3,"DETALLE DE PRODUCTO",0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(20,3,"C�DIGO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,mb_convert_encoding($reg[0]['codproducto'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'',9).mb_convert_encoding($reg[0]['producto'], 'ISO-8859-1', 'UTF-8'),0,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"MARCA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,mb_convert_encoding($reg[0]['codmarca'] == '0' ? "**********" : $reg[0]['nommarca'], 'ISO-8859-1', 'UTF-8'),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"MODELO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(50,3,mb_convert_encoding($reg[0]['codmodelo'] == '0' ? "**********" : $reg[0]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"PRESENTACI.:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,mb_convert_encoding($reg[0]['codpresentacion'] == '0' ? "**********" : $reg[0]['nompresentacion'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"P. COMPRA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,$simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"P.V. MAYOR:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,$simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"P.V. MENOR:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,$simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"P.V. P�BLICO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,$simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"EXISTENCIA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,number_format($reg[0]['existencia'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,3,"DETALLE DE AJUSTE",0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"CANT. AJUSTE:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,number_format($reg[0]['cantidad'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"STOCK:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,$reg[0]['procedimiento'] == 1 ? number_format($reg[0]['existencia']+$reg[0]['cantidad'], 2, '.', ',') : number_format($reg[0]['existencia']-$reg[0]['cantidad'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"PROCESO:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,$reg[0]['procedimiento'] == 1 ? "SUMA" : "RESTA",0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(25,3,"FECHA:",0,0,'L');
    $this->SetFont('Courier','',8);
    $this->CellFitSpace(45,3,date("d/m/Y H:i:s",strtotime($reg[0]['fechaajuste'])),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->MultiCell(70,4,$this->SetFont('Courier','B',8)."MOTIVO DE AJUSTE: ".mb_convert_encoding($reg[0]['motivoajuste'], 'ISO-8859-1', 'UTF-8'),0,'J');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetFont('Courier','BI',9);
    $this->SetX(4);
    $this->SetFillColor(3, 3, 3);
    $this->Cell(66,3,"",0,1,'C');
    $this->Ln(3);/**/
}
########################## FUNCION TICKET AJUSTES STOCK (8MM) ##############################

########################## FUNCION TICKET AJUSTES STOCK (5MM) ##############################
function TicketAjuste_5()
{  
    $tra = new Login();
    $reg = $tra->AjustesProductosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 8, 3, 30, 15, "PNG");
    $this->Ln(8);

    }
  
    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE AJUSTE", 0, 0, 'C');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".$reg[0]['documento']." ".mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,3,"RESPONSABLE:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechaajuste'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechaajuste'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(42,3,"DETALLE DE PRODUCTO",0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"C�DIGO:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,mb_convert_encoding($reg[0]['codproducto'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'',6).mb_convert_encoding($reg[0]['producto'], 'ISO-8859-1', 'UTF-8'),0,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"MARCA:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,mb_convert_encoding($reg[0]['codmarca'] == '0' ? "**********" : $reg[0]['nommarca'], 'ISO-8859-1', 'UTF-8'),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"MODELO:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,mb_convert_encoding($reg[0]['codmodelo'] == '0' ? "**********" : $reg[0]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"PRESENTACI.:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,mb_convert_encoding($reg[0]['codpresentacion'] == '0' ? "**********" : $reg[0]['nompresentacion'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"P. COMPRA:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,$simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"P.V. MAYOR:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,$simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"P.V. MENOR:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,$simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"P.V. P�BLICO:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,$simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"EXISTENCIA:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,number_format($reg[0]['existencia'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(42,3,"DETALLE DE AJUSTE",0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"CANT. AJUSTE:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,number_format($reg[0]['cantidad'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"STOCK:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,$reg[0]['procedimiento'] == 1 ? number_format($reg[0]['existencia']+$reg[0]['cantidad'], 2, '.', ',') : number_format($reg[0]['existencia']-$reg[0]['cantidad'], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"PROCESO:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,$reg[0]['procedimiento'] == 1 ? "SUMA" : "RESTA",0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3,"FECHA:",0,0,'L');
    $this->SetFont('Courier','',6);
    $this->CellFitSpace(22,3,date("d/m/Y H:i:s",strtotime($reg[0]['fechaajuste'])),0,1,'L');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->MultiCell(42,4,$this->SetFont('Courier','B',6)."MOTIVO DE AJUSTE: ".mb_convert_encoding($reg[0]['motivoajuste'], 'ISO-8859-1', 'UTF-8'),0,'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetFont('Courier','BI',9);
    $this->SetX(4);
    $this->SetFillColor(3, 3, 3);
    $this->Cell(66,3,"",0,1,'C');
    $this->Ln(3);/**/
}
########################## FUNCION TICKET AJUSTES STOCK (5MM) ##############################

####################### FUNCION LISTAR AJUSTES DE PRODUCTOS ##########################
function TablaListarAjustesProductos()
{
    $tra = new Login();
    $reg = $tra->ListarAjustesProductos();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE AJUSTES DE PRODUCTOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACI.',1,0,'C', True);
    $this->Cell(30,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P.V. P�BLICO',1,0,'C', True);
    $this->Cell(25,8,"EXISTENCIA",1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,0,'C', True);
    $this->Cell(25,8,'STOCK',1,0,'C', True);
    $this->Cell(55,8,'MOTIVO AJUSTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA AJUSTE ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,55,30,30,30,25,20,25,55,30));

    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);   

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"].$marca = ($reg[$i]['codmarca'] == '0' ? "" : " ".$reg[$i]['nommarca']).$modelo = ($reg[$i]['codmodelo'] == '0' ? "" : " ".$reg[$i]['nommodelo']))),
        utf8_decode($reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($tipo = ($reg[$i]['procedimiento'] == 1 ? "+" : "-")." ".number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($tipo = ($reg[$i]['procedimiento'] == 1 ? number_format($reg[$i]['existencia']+$reg[$i]['cantidad'], 2, '.', ',') : number_format($reg[$i]['existencia']-$reg[$i]['cantidad'], 2, '.', ','))),
        utf8_decode($reg[$i]["motivoajuste"]),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaajuste'])))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR AJUSTES DE PRODUCTOS #########################

####################### FUNCION LISTAR AJUSTES DE PRODUCTOS POR BUSQUEDA ##########################
function TablaListarAjustesProductosxBusqueda()
{
    $tra = new Login();
    $reg = $tra->BusquedaAjustesProductos();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if($_GET['tipobusqueda'] == 1){
    $this->Cell(335,10,'LISTADO GENERAL DE AJUSTES DE PRODUCTOS',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 2){
    $this->Cell(335,10,'LISTADO DE AJUSTES DE PRODUCTOS POR B�SQUEDA',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Cell(335,10,'LISTADO DE AJUSTES DE PRODUCTOS POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    if($_GET['tipobusqueda'] == 2){
    $this->Ln();
    $this->Cell(335,6,"B�SQUEDA: ".utf8_decode($_GET["search_criterio"]),0,0,'L');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'PRESENTACI.',1,0,'C', True);
    $this->Cell(30,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(30,8,'P.V. P�BLICO',1,0,'C', True);
    $this->Cell(25,8,"EXISTENCIA",1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,0,'C', True);
    $this->Cell(25,8,'STOCK',1,0,'C', True);
    $this->Cell(55,8,'MOTIVO AJUSTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA AJUSTE ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,55,30,30,30,25,20,25,55,30));

    $a=1;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);   

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        portales(utf8_decode($reg[$i]["producto"].$marca = ($reg[$i]['codmarca'] == '0' ? "" : " ".$reg[$i]['nommarca']).$modelo = ($reg[$i]['codmodelo'] == '0' ? "" : " ".$reg[$i]['nommodelo']))),
        utf8_decode($reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']),
        utf8_decode($simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($tipo = ($reg[$i]['procedimiento'] == 1 ? "+" : "-")." ".number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($tipo = ($reg[$i]['procedimiento'] == 1 ? number_format($reg[$i]['existencia']+$reg[$i]['cantidad'], 2, '.', ',') : number_format($reg[$i]['existencia']-$reg[$i]['cantidad'], 2, '.', ','))),
        utf8_decode($reg[$i]["motivoajuste"]),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaajuste'])))));
       }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR AJUSTES DE PRODUCTOS POR BUSQUEDA #########################

############################## REPORTES DE AJUSTES DE PRODUCTOS ##############################












############################################ REPORTES DE COMBOS ############################################

########################## FUNCION LISTAR COMBOS ##############################
function TablaListarCombos()
{
    $tra = new Login();
    $reg = $tra->ListarCombos();  

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COMBOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,5,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,5,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,5,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(25,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'STOCK',1,0,'C', True);
    $this->Cell(35,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO MAYOR',1,0,'C', True);
    $this->Cell(35,8,'PRECIO MENOR',1,0,'C', True);
    $this->Cell(35,8,'PRECIO P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,75,30,25,30,35,35,35,35));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo  = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];
    $detalles       = str_replace("<br>","\n", $reg[$i]['detalles_productos']);

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codcombo']),
        portales(utf8_decode($reg[$i]["nomcombo"])),
        utf8_decode($reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['desccombo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }


    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS ##############################

########################## FUNCION LISTAR COMBOS EN STOCK MINIMO ##############################
function TablaListarCombosMinimo()
{
    $tra = new Login();
    $reg = $tra->ListarCombosMinimo();  

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COMBOS EN STOCK MINIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,5,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,5,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,5,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(20,8,'MINIMO',1,0,'C', True);
    $this->Cell(30,8,'STOCK',1,0,'C', True);
    $this->Cell(35,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO MAYOR',1,0,'C', True);
    $this->Cell(35,8,'PRECIO MENOR',1,0,'C', True);
    $this->Cell(35,8,'PRECIO P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,60,30,20,20,30,35,35,35,35));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo  = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];
    $detalles       = str_replace("<br>","\n", $reg[$i]['detalles_productos']);

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codcombo']),
        portales(utf8_decode($reg[$i]["nomcombo"])),
        utf8_decode($reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['desccombo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['stockminimo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS EN STOCK MINIMO ##############################

########################## FUNCION LISTAR COMBOS EN STOCK MAXIMO ##############################
function TablaListarCombosMaximo()
{
    $tra = new Login();
    $reg = $tra->ListarCombosMaximo();  

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COMBOS EN STOCK MAXIMO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,5,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,5,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,5,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(20,8,'M�XIMO',1,0,'C', True);
    $this->Cell(30,8,'STOCK',1,0,'C', True);
    $this->Cell(35,8,'PRECIO COMPRA',1,0,'C', True);
    $this->Cell(35,8,'PRECIO MAYOR',1,0,'C', True);
    $this->Cell(35,8,'PRECIO MENOR',1,0,'C', True);
    $this->Cell(35,8,'PRECIO P�BLICO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,60,30,20,20,30,35,35,35,35));

    $a=1;
    $TotalCompra    = 0;
    $TotalMenor     = 0;
    $TotalMayor     = 0;
    $TotalPublico   = 0;
    $TotalArticulos = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo  = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

    $TotalCompra    += $reg[$i]['preciocompra'];
    $TotalMayor     += $reg[$i]['precioxmayor'];
    $TotalMenor     += $reg[$i]['precioxmenor'];
    $TotalPublico   += $reg[$i]['precioxpublico'];
    $TotalArticulos += $reg[$i]['existencia'];
    $detalles       = str_replace("<br>","\n", $reg[$i]['detalles_productos']);

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codcombo']),
        portales(utf8_decode($reg[$i]["nomcombo"])),
        utf8_decode($reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['desccombo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','))));
    }
   
    $this->Cell(165,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalPublico, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS EN STOCK MAXIMO ##############################

########################## FUNCION LISTAR COMBOS POR MONEDA ##############################
function TablaListarCombosxMoneda()
{
    $cambio = new Login();
    $cambio = $cambio->BuscarTiposCambios();
    $siglas = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['siglas']);
    $tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['simbolo']);

    $tra = new Login();
    $reg = $tra->ListarCombos();  

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COMBOS POR MONEDA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,5,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,5,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,5,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"MONEDA: ".utf8_decode($cambio[0]["moneda"]),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(100,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'STOCK',1,0,'C', True);
    $this->Cell(40,8,'PREC. MAYOR '.$siglas,1,0,'C', True);
    $this->Cell(40,8,'PREC. MENOR '.$siglas,1,0,'C', True);
    $this->Cell(40,8,'PREC. P�BLICO '.$siglas,1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,100,30,20,30,40,40,40));

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
    $detalles  = str_replace("<br>","\n", $reg[$i]['detalles_productos']);

    $TotalCompra        += number_format($reg[$i]['preciocompra'], 2, '.', ',');
    $TotalMayor         += number_format($reg[$i]['precioxmayor'], 2, '.', '');
    $TotalMenor         += number_format($reg[$i]['precioxmenor'], 2, '.', '');
    $TotalPublico       += number_format($reg[$i]['precioxpublico'], 2, '.', '');

    $TotalMonedaCompra  += number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
    $TotalMonedaMayor   += number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', '');
    $TotalMonedaMenor   += number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', '');
    $TotalMonedaPublico += number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', '');
    $TotalArticulos     += $reg[$i]['existencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codcombo']),
        portales(utf8_decode($reg[$i]["nomcombo"])),
        utf8_decode($reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['desccombo'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $tipo_simbolo).utf8_decode(number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ',')),
        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $tipo_simbolo).utf8_decode(number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ',')),
        $tipo = ($cambio[0]['moneda'] == "EURO" ? chr(128) : $tipo_simbolo).utf8_decode(number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','))));
        /*utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "******")),
        utf8_decode($simbolo.number_format($reg[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',') : "******")),
        utf8_decode($tipo_simbolo.number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','))));*/
    }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaMayor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaMenor, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaPublico, 2, '.', ',')),0,0,'L');
    /*$this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalVenta, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($tipo_simbolo.number_format($TotalMonedaVenta, 2, '.', ',')),0,0,'L');*/
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS POR MONEDA ##############################

########################## FUNCION LISTAR KARDEX POR COMBO ##############################
function TablaListarKardexCombo()
{
    $kardex = new Login();
    $kardex = $kardex->BuscarKardexCombo(); 

    $detalle = new Login();
    $detalle = $detalle->DetalleKardexCombo(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE KARDEX POR COMBO ',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($detalle[0]['documento']).": ".utf8_decode($detalle[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($detalle[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($detalle[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(50,8,'REALIZADO POR',1,0,'C', True);
    $this->Cell(25,8,'MOVIMIENTO',1,0,'C', True);
    $this->Cell(25,8,'ENTRADAS',1,0,'C', True);
    $this->Cell(25,8,'SALIDAS',1,0,'C', True);
    $this->Cell(25,8,'DEVOLUCI.',1,0,'C', True);
    $this->Cell(20,8,'STOCK',1,0,'C', True);
    $this->Cell(30,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,'PRECIO',1,0,'C', True);
    $this->Cell(40,8,'DOCUMENTO',1,0,'C', True);
    $this->Cell(30,8,'FECHA KARDEX',1,1,'C', True);

    if($kardex==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,50,25,25,25,25,20,30,20,30,40,30));

    $TotalEntradas   = 0;
    $TotalSalidas    = 0;
    $TotalDevolucion = 0;
    $a=1;
    for($i=0;$i<sizeof($kardex);$i++){
    $simbolo = ($detalle[0]['simbolo'] == "" ? "" : $detalle[0]['simbolo']);

    $TotalEntradas   += $kardex[$i]['entradas'];
    $TotalSalidas    += $kardex[$i]['salidas'];
    $TotalDevolucion += $kardex[$i]['devolucion'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres'])),
        utf8_decode($kardex[$i]["movimiento"]),
        utf8_decode(number_format($kardex[$i]["entradas"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]["salidas"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]["devolucion"], 2, '.', ',')),
        utf8_decode(number_format($kardex[$i]['stockactual'], 2, '.', ',')),
        utf8_decode($kardex[$i]['ivaproducto']),
        utf8_decode(number_format($kardex[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($kardex[$i]['precio'], 2, '.', ',')),
        portales(utf8_decode($kardex[$i]['documento'])),
        utf8_decode(date("d/m/Y H:i:s",strtotime($kardex[$i]['fechakardex'])))));
        }
    }

    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(120,5,'DETALLES DEL COMBO',1,0,'C', True);
    $this->Ln();
    
    $this->Cell(35,5,'C�DIGO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($detalle[0]['codcombo']),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'DESCRIPCI.',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,portales(utf8_decode($detalle[0]['nomcombo'])),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'ENTRADAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalEntradas, 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'SALIDAS',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($TotalSalidas, 2, '.', ',')),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'DEVOLUCI.',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(85,5,utf8_decode(number_format($TotalDevolucion, 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'EXISTENCIA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode(number_format($detalle[0]['existencia'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'PRECIO COMPRA',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "******")),1,0,'C');
    $this->Ln();

    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P. VENTA MAYOR',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxmayor'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P.VENTA MENOR',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxmenor'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(35,5,'P. VENTA P�BLICO',1,0,'C', True);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle[0]['precioxpublico'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR KARDEX POR COMBO ##############################

########################## FUNCION LISTAR COMBOS KARDEX VALORIZADO ##############################
function TablaListarKardexCombosValorizado()
{
    $tra = new Login();
    $reg = $tra->ListarKardexCombosValorizado(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX COMBOS VALORIZADO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(45,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(25,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(15,8,'DESC%',1,0,'C', True);
    $this->Cell(90,8,'DETALLES PRODUCTOS',1,0,'C', True);
    $this->Cell(25,8,'STOCK',1,0,'C', True);
    $this->Cell(35,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(35,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(30,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,45,25,15,90,25,35,35,30));

    $a=1;
    $PrecioCompraTotal    = 0;
    $PrecioVentaTotal     = 0;
    $ExisteTotal          = 0;
    $ImpuestosCompraTotal = 0;
    $ImpuestosVentaTotal  = 0;
    $CompraTotal          = 0;
    $VentaTotal           = 0;
    $TotalGanancia        = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $detalles = str_replace("<br>","\n", $reg[$i]['detalles_productos']);

    $PrecioCompraTotal    += $reg[$i]['preciocompra'];
    $PrecioVentaTotal     += $reg[$i]['precioxpublico'];
    $ExisteTotal          += $reg[$i]['existencia'];

    $Descuento            = $reg[$i]['desccombo']/100;
    $PrecioDescuento      = $reg[$i]['precioxpublico']*$Descuento;
    $PrecioFinal          = $reg[$i]['precioxpublico']-$PrecioDescuento;

    //VALOR DE IMPUESTO
    $ValorIva = 1 + ($reg[$i]['valorimpuesto']/100);

    //CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
    $DiscriminadoC         = $reg[$i]['preciocompra']/$ValorIva;
    $SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
    $BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
    $SubtotalimpuestosC    = ($reg[$i]['ivacombo'] != '0' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

    //CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
    $DiscriminadoV         = $PrecioFinal/$ValorIva;
    $SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
    $BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
    $SubtotalimpuestosV    = ($reg[$i]['ivacombo'] != '0' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

    $SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
    $SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

    $CompraTotal          += $SumCompra;
    $ImpuestosCompraTotal += $SubtotalimpuestosC;
    $VentaTotal           += $SumVenta;
    $ImpuestosVentaTotal  += $SubtotalimpuestosV;
    $TotalGanancia        += $SumVenta-$SumCompra;

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codcombo']),
        utf8_decode($reg[$i]["nomcombo"]),
        utf8_decode($reg[$i]['ivacombo'] != '0' ? $reg[$i]['nomimpuesto']." (".number_format($reg[$i]['valorimpuesto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['desccombo'], 2, '.', ',')),
        portales(utf8_decode($detalles)),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "0.00")),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"))));
    }
   
    $this->Cell(210,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "******")),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS KARDEX VALORIZADO ##############################

########################## FUNCION LISTAR COMBOS KARDEX VALORIZADO POR FECHAS ##############################
function TablaListarCombosValorizadoxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarCombosValorizadoxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO KARDEX COMBOS VALORIZADO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(100,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(35,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(20,8,'DESC%',1,0,'C', True);
    $this->Cell(25,8,'VENDIDO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(40,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,100,35,20,25,40,40,40));

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
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        utf8_decode($reg[$i]["producto"]),
        utf8_decode($reg[$i]['ivaproducto'] != '0.00' ? $reg[$i]['tipoimpuesto']." (".number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO"),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta, 2, '.', ',')),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumCompra, 2, '.', ',') : "0.00")),
        utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ',') : "0.00"))));
    }
   
    $this->Cell(190,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "******")),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" ? $simbolo.number_format($TotalGanancia, 2, '.', ',') : "******")),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS KARDEX VALORIZADO POR FECHAS ##############################

########################## FUNCION LISTAR COMBOS VENDIDOS POR FECHAS ##############################
function TablaListarCombosVendidosxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarCombosVendidosxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO COMBOS VENDIDOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(140,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'VENDIDO',1,0,'C', True);
    $this->Cell(40,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(40,8,'DESC %',1,0,'C', True);
    $this->Cell(50,8,'MONTO TOTAL ',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,140,30,40,40,50));

    $a=1;
    $PrecioVentaTotal = 0;
    $VendidosTotal    = 0;
    $TotalDescuento   = 0;
    $TotalImpuesto    = 0;
    $TotalGeneral     = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['codproducto']),
        utf8_decode($reg[$i]["producto"]),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode(number_format($SubtotalImpuesto, 2, '.', ',')),
        utf8_decode(number_format($SubtotalDescuento, 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }
   
    $this->Cell(175,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalGeneral, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMBOS VENDIDOS POR FECHAS ##############################

############################################ REPORTES DE COMBOS ############################################














############################################ REPORTES DE TRASPASOS ############################################

########################## FUNCION TICKET TRASPASOS (8MM) ##############################
function TicketTraspaso_8()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->TraspasosPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if($reg[0]['estado_traspaso'] == 1){
    $estado = "REGISTRADO";
    } elseif($reg[0]['estado_traspaso'] == 2){
    $estado = "EN PROCESO";
    } elseif($reg[0]['estado_traspaso'] == 3){
    $estado = "PENDIENTE";
    } elseif($reg[0]['estado_traspaso'] == 4){
    $estado = "RECIBIDO"; 
    } elseif($reg[0]['estado_traspaso'] == 5){
    $estado = "RECHAZADA";
    }

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 15, 3, 45, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE TRASPASO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".$reg[0]['documento']." ".mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(24,4,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(46,4,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(24,4,"Nro Tracking:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(46,4,$reg[0]['numero_tracking'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(24,4,"ESTADO:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(46,4,mb_convert_encoding($estado, 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechatraspaso'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechatraspaso'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DATOS DE SUCURSAL DESTINATARIO", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documsucursal = ($reg[0]['documsucursal2'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8')).": ".$reg[0]['cuitsucursal2'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['nomsucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : $reg[0]['provincia2'])." ".$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2'])." ".$reg[0]['direcsucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).'TLF: '.mb_convert_encoding($reg[0]['tlfsucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).'EMAIL: '.mb_convert_encoding($reg[0]['correosucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).'RESPONSABLE: '.mb_convert_encoding($reg[0]['nomencargado2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesTraspasos();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["producto"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"DESCONTADO %",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXENTO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(34,4,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(70,4,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(30,4,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(40,4,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET TRASPASOS (8MM) ##############################

########################## FUNCION TICKET TRASPASOS (5MM) ##############################
function TicketTraspaso_5()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->TraspasosPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if($reg[0]['estado_traspaso'] == 1){
    $estado = "REGISTRADO";
    } elseif($reg[0]['estado_traspaso'] == 2){
    $estado = "EN PROCESO";
    } elseif($reg[0]['estado_traspaso'] == 3){
    $estado = "PENDIENTE";
    } elseif($reg[0]['estado_traspaso'] == 4){
    $estado = "RECIBIDO"; 
    } elseif($reg[0]['estado_traspaso'] == 5){
    $estado = "RECHAZADA";
    }

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 8, 3, 30, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE TRASPASO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Tracking:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['numero_tracking'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"ESTADO:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,mb_convert_encoding($estado, 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechatraspaso'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechatraspaso'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"SUCURSAL DESTINATARIO", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,$documsucursal = ($reg[0]['documsucursal2'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8')).": ".$reg[0]['cuitsucursal2'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['nomsucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : $reg[0]['provincia2'])." ".$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2'])." ".$reg[0]['direcsucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).'TLF: '.mb_convert_encoding($reg[0]['tlfsucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).'EMAIL: '.mb_convert_encoding($reg[0]['correosucursal2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).'RESPONSABLE: '.mb_convert_encoding($reg[0]['nomencargado2'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesTraspasos();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["producto"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"DESCONTADO %",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXENTO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(42,3,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(21,3,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET TRASPASOS (5MM) ##############################

########################## FUNCION FACTURA TRASPASOS (A4) ##############################
function FacturaTraspaso()
{  
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
    
    $tra       = new Login();
    $reg       = $tra->TraspasosPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
           $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
           $this->Image($logo, 15, 11, 45, 18, "PNG");
        } else {
           $logo = "fotos/logo_principal.png";
           $this->Image($logo, 15, 10, 45, 18, "PNG");                         
        }                                      
    }

    if($reg[0]['estado_traspaso'] == 1){
    $estado = "REGISTRADO";
    } elseif($reg[0]['estado_traspaso'] == 2){
    $estado = "EN PROCESO";
    } elseif($reg[0]['estado_traspaso'] == 3){
    $estado = "PENDIENTE";
    } elseif($reg[0]['estado_traspaso'] == 4){
    $estado = "RECIBIDO"; 
    } elseif($reg[0]['estado_traspaso'] == 5){
    $estado = "RECHAZADA";
    }

    ############################# BLOQUE N.1 FACTURA ###############################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 21, '1.5', '');
    
    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 12);
    $this->Cell(40, 4, 'N.DE FACTURA', 0, 0);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(155, 12);
    $this->CellFitSpace(45, 4,utf8_decode($reg[0]['codfactura']), 0, 0, "R");


    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 16);
    $this->Cell(40, 4, 'FECHA DE REGISTRO', 0, 0);
    $this->SetFont($TipoLetra,'',10);
    $this->SetXY(155, 16);
    $this->CellFitSpace(45, 4,utf8_decode(date("d/m/Y",strtotime($reg[0]['fechatraspaso']))), 0, 0, "R");

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 20);
    $this->Cell(40, 4, 'HORA DE REGISTRO', 0, 0);
    $this->SetFont($TipoLetra,'',10);
    $this->SetXY(155, 20);
    $this->CellFitSpace(45, 4,utf8_decode(date("H:i:s",strtotime($reg[0]['fechatraspaso']))), 0, 0, "R");

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 24);
    $this->Cell(40, 4, 'ESTADO', 0, 0);
    $this->SetFont($TipoLetra,'',10);
    $this->SetXY(155, 24);
    $this->CellFitSpace(45, 4,utf8_decode($estado), 0, 0, "R");
    ################################# BLOQUE N.1 FACTURA ################################

    ############################# BLOQUE N.2 SUCURSAL ENVIA ###############################   
    //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 32, 190, 17, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(12, 32);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL REMITENTE', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 36);
    $this->Cell(24, 4, 'RAZ. SOCIAL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 36);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(102, 36);
    $this->CellFitSpace(22, 4, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(124, 36);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(152, 36);
    $this->Cell(18, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(170, 36);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 40);
    $this->Cell(24, 4, 'DIRECCI.:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 40);
    $this->CellFitSpace(96, 4,utf8_decode($reg[0]['direcsucursal'].", ".$departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(132, 40);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(144, 40);
    $this->Cell(54, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 44);
    $this->Cell(24, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 44);
    $this->CellFitSpace(116, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(152, 44);
    $this->Cell(18, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(170, 44);
    $this->Cell(28, 4,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "******" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################ BLOQUE N.2 SUCURSAL ENVIA ###############################

    ############################# BLOQUE N.3 SUCURSAL RECIBE ###############################   
    //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 50, 190, 17, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(12, 50);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL DESTINATARIO', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 54);
    $this->Cell(24, 4, 'RAZ. SOCIAL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 54);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal2']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(102, 54);
    $this->CellFitSpace(22, 4, 'N.DE '.$documento = ($reg[0]['documsucursal2'] == '0' ? "REG.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(124, 54);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal2']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(152, 54);
    $this->Cell(18, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(170, 54);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal2']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 58);
    $this->Cell(24, 4, 'DIRECCI.:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 58);
    $this->CellFitSpace(96, 4,utf8_decode($reg[0]['direcsucursal2'].", ".$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2']).", ".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : $reg[0]['provincia2'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(132, 58);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(144, 58);
    $this->Cell(54, 4,utf8_decode($reg[0]['correosucursal2']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 62);
    $this->Cell(24, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 62);
    $this->CellFitSpace(116, 4,utf8_decode($reg[0]['nomencargado2']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(152, 62);
    $this->Cell(18, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(170, 62);
    $this->Cell(28, 4,utf8_decode($tlf = ($reg[0]['tlfencargado2'] == '' ? "******" : $reg[0]['tlfencargado2'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################ BLOQUE N.3 SUCURSAL RECIBE ###############################

    ################################# BLOQUE N.4 #######################################   
    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(10, 68);
    $this->SetTextColor(3,3,3);
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(8, 8,"N�", 1, 0, 'C', True);
    $this->Cell(64, 8,"DESCRIPCI. DE PRODUCTO", 1, 0, 'C', True);
    $this->Cell(32, 8,"MARCA", 1, 0, 'C', True);
    $this->Cell(26, 8,"MODELO", 1, 0, 'C', True);
    $this->Cell(15, 8,"CANT", 1, 0, 'C', True);
    $this->Cell(20, 8,"PRECIO", 1, 0, 'C', True);
    $this->Cell(25, 8,"IMPORTE", 1, 1, 'C', True);
    ################################# BLOQUE N.4 ####################################### 

    ################################# BLOQUE N.5 ####################################### 
    $tra = new Login();
    $detalle = $tra->VerDetallesTraspasos();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(8,64,32,26,15,20,25));
    $this->SetAligns(array('C','L','C','C','C','C','C','C','C','C'));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad   += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal   += $detalle[$i]['valorneto'];

    $this->SetX(10);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255,255,255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture(array($a++,
        portales(utf8_decode($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : ""))),
        utf8_decode($detalle[$i]["codmarca"] == '0' ? "******" : $detalle[$i]["nommarca"]),
        utf8_decode($detalle[$i]["codmodelo"] == '0' ? "******" : $detalle[$i]["nommodelo"]),
        utf8_decode(number_format($detalle[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    ################################# BLOQUE N.5 ####################################### */

    ########################### BLOQUE N.6 #############################
    $this->Ln();
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'INFORMACI. ADICIONAL',1,0,'C', True);
    $this->Cell(2,5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(45,5,'DESCONTADO:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'SUBTOTAL:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'REALIZADO: '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'FECHA/HORA DE EMISI.: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'RESPONSABLE: '.utf8_decode($nombres_responsable = ($reg[0]["nombres_responsable"] == "" ? "******" : $reg[0]['nombres_responsable'])),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,"IVA (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'RECIBIDO: '.$recibido = ($reg[0]["persona_recibe"] == 0 ? "******" : $reg[0]["nombres2"]),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,"IMPORTE TOTAL:",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'FECHA/HORA RECIBIDO: '.$recibido = ($reg[0]['fecha_recibe'] == "" ? "******" : utf8_decode(date("d/m/Y H:i:s",strtotime($reg[0]['fecha_recibe'])))),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,"  ",1,0,'L', True);
    $this->CellFitSpace(40,5," ",1,0,'R');
    $this->Ln(4);
    
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(196,8,$this->SetFont($TipoLetra,'B',10).'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'J');
    $this->Ln();

    if($reg[0]['observaciones'] != ''){
    //Linea de membrete Nro 4
    $this->SetFont($TipoLetra,'B',10);
    $this->MultiCell(190,5,$this->SetFont($TipoLetra,'',10).'OBSERVACIONES ENVIA: '.utf8_decode($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']),1,'J');
    }

    if($reg[0]['observaciones_recibido'] != ''){
    //Linea de membrete Nro 4
    $this->SetFont($TipoLetra,'B',10);
    $this->MultiCell(190,5,$this->SetFont($TipoLetra,'',10).'OBSERVACIONES RECIBIDO: '.utf8_decode($reg[0]['observaciones_recibido'] == '' ? "**********" : $reg[0]['observaciones_recibido']),1,'J');
    }

    $this->SetXY(10,250);
    $this->QR($reg,170, 0);
}
########################## FUNCION FACTURA TRASPASOS (A4) ##############################

########################## FUNCION LISTAR TRASPASOS ##############################
function TablaListarTraspasos()
{
    $tra = new Login();
    $reg = $tra->ListarTraspasos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE TRASPASOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'SUCURSAL REMITENTE',1,0,'C', True);
    $this->Cell(60,8,'SUCURSAL DESTINATARIO',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,60,40,35,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $tipo_documento = ($reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_8' || $reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_5' ? "TICKET" : "FACTURA"); 

    if($reg[$i]['estado_traspaso'] == 1){
    $estado = "REGISTRADO";
    } elseif($reg[$i]['estado_traspaso'] == 2){
    $estado = "EN PROCESO";
    } elseif($reg[$i]['estado_traspaso'] == 3){
    $estado = "PENDIENTE";
    } elseif($reg[$i]['estado_traspaso'] == 4){
    $estado = "RECIBIDO"; 
    } elseif($reg[$i]['estado_traspaso'] == 5){
    $estado = "RECHAZADA";
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalImporte   += $reg[$i]['totalpago'];
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['cuitsucursal'].": ".$reg[$i]["nomsucursal"]),utf8_decode($reg[$i]['cuitsucursal2'].": ".$reg[$i]["nomsucursal2"]),utf8_decode($reg[$i]['observaciones'] == '' ? "******" : $reg[$i]["observaciones"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(270,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS ##############################

########################## FUNCION LISTAR TRASPASOS POR FECHAS ##############################
function TablaListarTraspasosxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarTraspasosxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE TRASPASOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'SUCURSAL REMITENTE',1,0,'C', True);
    $this->Cell(60,8,'SUCURSAL DESTINATARIO',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,60,60,40,35,25,25,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $tipo_documento = ($reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_8' || $reg[$i]['tipodocumento'] == 'TICKET_TRASPASO_5' ? "TICKET" : "FACTURA");

    if($reg[$i]['estado_traspaso'] == 1){
    $estado = "REGISTRADO";
    } elseif($reg[$i]['estado_traspaso'] == 2){
    $estado = "EN PROCESO";
    } elseif($reg[$i]['estado_traspaso'] == 3){
    $estado = "PENDIENTE";
    } elseif($reg[$i]['estado_traspaso'] == 4){
    $estado = "RECIBIDO"; 
    } elseif($reg[$i]['estado_traspaso'] == 5){
    $estado = "RECHAZADA";
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalImporte   += $reg[$i]['totalpago'];
 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['cuitsucursal'].": ".$reg[$i]["nomsucursal"]),utf8_decode($reg[$i]['cuitsucursal2'].": ".$reg[$i]["nomsucursal2"]),utf8_decode($reg[$i]['observaciones'] == '' ? "******" : $reg[$i]["observaciones"]),utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(270,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR TRASPASOS POR FECHAS ##############################

########################## FUNCION LISTAR DETALLES TRASPASOS POR FECHAS ##############################
function TablaListarDetallesTraspasosxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesTraspasosxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES PRODUCTOS TRASPASADOS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(90,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(35,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'TRASPASADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,90,35,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo        = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal       +=$PrecioFinal*$reg[$i]['cantidad'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES TRASPASOS POR FECHAS ##############################

############################################ REPORTES DE TRASPASOS ############################################













############################################ REPORTES DE COMPRAS ############################################

########################## FUNCION FACTURA COMPRA ##############################
function FacturaCompra()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->ComprasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
       if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 11, 45, 18, "PNG");

        } else {

        $logo = "fotos/logo_principal.png";                         
        $this->Image($logo, 15, 11, 45, 18, "PNG");  
       }                                      
    }

    ######################### BLOQUE N.1 ######################### 
    //BLOQUE DE DATOS DE PRINCIPAL
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 335, 20, '1.5', '');
    
    $this->SetFont('courier','B',14);
    $this->SetXY(250, 12);
    $this->Cell(50, 5, 'N.DE COMPRA ', 0, 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(300, 12);
    $this->CellFitSpace(42, 5,$reg[0]['codfactura'], 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(250, 16);
    $this->Cell(50, 5, 'FECHA DE EMISI.', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(300, 16);
    $this->CellFitSpace(42, 5,date("d/m/Y",strtotime($reg[0]['fechaemision'])), 0, 0, "R");
    
    $this->SetFont('courier','B',10);
    $this->SetXY(250, 20);
    $this->Cell(50, 5, 'FECHA DE RECEPCI.', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(300, 20);
    $this->CellFitSpace(42, 5,date("d/m/Y",strtotime($reg[0]['fecharecepcion'])), 0, 0, "R");

    $this->SetFont('courier','B',10);
    $this->SetXY(250, 24);
    $this->Cell(50, 5, 'ESTADO DE COMPRA', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(300, 24);
    
    if($reg[0]['fechavencecredito']== '0000-00-00') { 
    $this->Cell(42, 5,$reg[0]['statuscompra'], 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] >= date("Y-m-d")) { 
    $this->Cell(42, 5,$reg[0]['statuscompra'], 0, 0, "R");
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $this->Cell(42, 5,"VENCIDA", 0, 0, "R");
    }
    ######################### BLOQUE N.1 ######################### 

    ############################## BLOQUE N.2 #####################################   
    //BLOQUE DE DATOS DE PROVEEDOR
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 32, 335, 34, '1.5', '');

    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 33);
    $this->Cell(335, 5, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 38);
    $this->CellFitSpace(32, 4, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8').":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(44, 38);
    $this->CellFitSpace(30, 4,$reg[0]['cuitsucursal'], 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(74, 38);
    $this->Cell(30, 4, 'RAZ. SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(104, 38);
    $this->CellFitSpace(85, 4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(189, 38);
    $this->Cell(24, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(213, 38);
    $this->CellFitSpace(74, 4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(287, 38);
    $this->Cell(25, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 38);
    $this->CellFitSpace(32, 4,$reg[0]['tlfsucursal'], 0, 0);
    //DATOS DE SUCURSAL LINEA 2


    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 42);
    $this->Cell(32, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(44, 42);
    $this->CellFitSpace(145, 4,mb_convert_encoding($reg[0]['nomencargado'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(189, 42);
    $this->CellFitSpace(40, 4,'N.DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : mb_convert_encoding($reg[0]['documento2'], 'ISO-8859-1', 'UTF-8').":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(229, 42);
    $this->CellFitSpace(58, 4,$reg[0]['dniencargado'], 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(287, 42);
    $this->Cell(25, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 42);
    $this->CellFitSpace(32, 4,$tlf = ($reg[0]['tlfencargado'] == '' ? "******" : $reg[0]['tlfencargado']), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ################################# BLOQUE N.2 #######################################   

    ################################# BLOQUE N.3 #######################################   
    //DATOS DE SUCURSAL LINEA 5
    $this->SetFont('courier','B',12);
    $this->SetXY(12, 52);
    $this->Cell(335, 4, 'DATOS DE PROVEEDOR', 0, 0);
    //DATOS DE SUCURSAL LINEA 5

    //DATOS DE SUCURSAL LINEA 6
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 56);
    $this->CellFitSpace(32, 4, 'N.DE '.$documento = ($reg[0]['documproveedor'] == '0' ? "DOC.:" : mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').":"), 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(44, 56);
    $this->CellFitSpace(30, 4,$reg[0]['cuitproveedor'], 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(74, 56);
    $this->Cell(30, 4, 'RAZ. SOCIAL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(104, 56);
    $this->CellFitSpace(85, 4,mb_convert_encoding($reg[0]['nomproveedor'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(189, 56);
    $this->Cell(24, 4, 'EMAIL:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(213, 56);
    $this->CellFitSpace(74, 4,mb_convert_encoding($reg[0]['emailproveedor'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(287, 56);
    $this->Cell(25, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(312, 56);
    $this->CellFitSpace(32, 4,$reg[0]['tlfproveedor'], 0, 0);

    $this->SetFont('courier','B',10);
    $this->SetXY(12, 60);
    $this->Cell(32, 4, 'DIRECCI.:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(44, 60);
    $this->CellFitSpace(190, 4,mb_convert_encoding($provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : $reg[0]['provincia2'])." ".$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : $reg[0]['departamento2'])." ".$reg[0]['direcproveedor'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    //DATOS DE SUCURSAL LINEA 6

    //DATOS DE SUCURSAL LINEA 7
    $this->SetFont('courier','B',10);
    $this->SetXY(234, 60);
    $this->Cell(24, 4, 'VENDEDOR:', 0, 0);
    $this->SetFont('courier','',10);
    $this->SetXY(258, 60);
    $this->CellFitSpace(86, 4,mb_convert_encoding($reg[0]['vendedor'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    //DATOS DE SUCURSAL LINEA 7
    ################################# BLOQUE N.3 #######################################  

    ################################# BLOQUE N.4 #######################################   
    $this->SetFont('courier','B',9);
    $this->SetXY(10, 68);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'C�DIGO',1,0,'C', True);
    $this->Cell(15,8,'LOTE',1,0,'C', True);
    $this->Cell(23,8,'FEC. EXP.',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(27,8,'MARCA',1,0,'C', True);
    $this->Cell(25,8,'MODELO',1,0,'C', True);
    $this->Cell(15,8,'CANT',1,0,'C', True);
    $this->Cell(26,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(25,8,'PRECIO UNIT',1,0,'C', True);
    $this->Cell(28,8,'VALOR TOTAL',1,0,'C', True);
    $this->Cell(18,8,'DESC %',1,0,'C', True);
    $this->Cell(32,8,'VALOR NETO',1,1,'C', True);
    ################################# BLOQUE N.4 ####################################### 

    ################################# BLOQUE N.5 ####################################### 
    $tra      = new Login();
    $detalle  = $tra->VerDetallesCompras();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,20,15,23,70,27,25,15,26,25,28,18,32));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad   += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["preciocompra"]*$detalle[$i]["cantidad"];
    $SubTotal   += $detalle[$i]['valorneto'];

    $this->SetX(10);
    $this->SetFont('Courier','',9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255,255,255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture(array($a++,
        mb_convert_encoding($detalle[$i]["codproducto"], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($detalle[$i]["lote"], 'ISO-8859-1', 'UTF-8'),
        $detalle[$i]["fechaoptimo"] == '0000-00-00' ? "******" : $detalle[$i]["fechaoptimo"],
        mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : ""), 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),
        number_format($detalle[$i]['cantidad'], 2, '.', ','),
        mb_convert_encoding($detalle[$i]['ivaproducto'] != '0.00' ? $detalle[$i]['tipoimpuesto']." (".number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%)" : "EXENTO", 'ISO-8859-1', 'UTF-8'),
        $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','),
        $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','),
        number_format($detalle[$i]['descfactura'], 2, '.', ','),
        $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ',')));
    }
    ################################# BLOQUE N.5 ####################################### 

    ########################### BLOQUE N.6 #############################
    $this->Ln(2);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',14);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'INFORMACI. ADICIONAL',1,0,'C', True);
    $this->Cell(5,5,"",0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(50,5,'DESCONTADO ',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,'SUBTOTAL',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'TIPO DE DOCUMENTO: FACTURA',1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,'EXENTO (0.00%):',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] >= date("Y-m-d")) {
    $estado = $reg[0]['statuscompra'];
    $dias_vencidos = "0";
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $estado = "VENCIDA";
    $dias_vencidos = Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']);
    }

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'TIPO DE PAGO: '.mb_convert_encoding($reg[0]['tipocompra'], 'ISO-8859-1', 'UTF-8')." ".$vencimiento = ($reg[0]['tipocompra'] == "CREDITO" ? " | FECHA VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])) : "")." ".$dias = ($reg[0]['tipocompra'] == "CREDITO" ? " | DIAS VENCIDOS: ".$dias_vencidos : ""),1,0,'L');

    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'FORMA DE PAGO: '.mb_convert_encoding($variable = ($reg[0]['tipocompra'] == 'CONTADO' ? $reg[0]['mediopago'] : $reg[0]['formacompra']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)

    $this->CellFitSpace(220,5,'REALIZADO: '.mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,"GASTO DE ENVIO:",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["gastoenvio"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)

    $this->CellFitSpace(220,5,'FECHA DE EMISI. (IMPRESO): '.date("d/m/Y H:i:s"),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,"IMPORTE TOTAL:",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["totalpago"]+$reg[0]["gastoenvio"], 2, '.', ','),1,0,'R');
    $this->Ln(6);

    if($reg[0]['observaciones'] != ''){
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->MultiCell(330,5,$this->SetFont('Courier','B',10).'OBSERVACIONES: '.mb_convert_encoding($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,'J');
    }
    ################################# BLOQUE N.6 #######################################
}
########################## FUNCION FACTURA COMPRA ##############################

########################## FUNCION TICKET COMPRA (8MM) ##############################
function TicketCompra_8()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->ComprasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 15, 3, 45, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE COMPRA", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,"REGISTRADO POR:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"EMISI.: ".date("d/m/Y",strtotime($reg[0]['fechaemision'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"RECEPCI.: ".date("d/m/Y",strtotime($reg[0]['fecharecepcion'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DATOS DE PROVEEDOR", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documproveedor'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['cuitproveedor']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['nomproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['direcproveedor'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2']), 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['emailproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['vendedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,"N.TLF: ".$reg[0]['tlfproveedor'],0,1,'L');


    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesCompras();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["preciocompra"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"DESCONTADO %",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXONERADO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXENTO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"GASTO DE ENVIO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['gastoenvio'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(34,4,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(70,4,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    
    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(25,4,"TIPO COMPRA",0,0,'L');
    $this->Cell(45,4,mb_convert_encoding($reg[0]['tipocompra'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    if($reg[0]['tipocompra'] == "CONTADO"){

    $this->SetX(2);
    $this->SetFont('Courier','B',9);
    $this->CellFitSpace(20,4,"MEDIO",0,0,'L');
    $this->Cell(50,4,mb_convert_encoding($reg[0]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    }

    ############# MUESTRO ABONOS Y PENDIENTE #############
    if($reg[0]['tipocompra']=="CREDITO"){

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(30,4,"ABONADO",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(30,4,"PENDIENTE",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(30,4,"VENCIMIENTO",0,0,'L');
    $this->Cell(40,4,date("d/m/Y",strtotime($reg[0]["fechavencecredito"])),0,1,'R');
    }
    ############# MUESTRO ABONOS Y PENDIENTE #############

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(30,4,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(40,4,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET COMPRA (8MM) ##############################

########################## FUNCION TICKET COMPRA (5MM) ##############################
function TicketCompra_5()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->ComprasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 8, 3, 30, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE COMPRA", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,"REGISTRADO POR:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"EMISI.: ".date("d/m/Y",strtotime($reg[0]['fechaemision'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"RECEPC.: ".date("d/m/Y",strtotime($reg[0]['fecharecepcion'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DATOS DE PROVEEDOR", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documproveedor'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['cuitproveedor']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['nomproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['direcproveedor'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2']), 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['emailproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['vendedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,"N.TLF: ".$reg[0]['tlfproveedor'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesCompras();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["preciocompra"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"DESCONTADO %",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXENTO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"GASTO DE ENVIO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['gastoenvio'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(42,3,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(1);
    
    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(21,3,"TIPO COMPRA",0,0,'L');
    $this->Cell(21,3,mb_convert_encoding($reg[0]['tipocompra'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    if($reg[0]['tipocompra'] == "CONTADO"){

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(21,3,"MEDIO",0,0,'L');
    $this->Cell(21,3,mb_convert_encoding($reg[0]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    }

    ############# MUESTRO ABONOS Y PENDIENTE #############
    if($reg[0]['tipocompra']=="CREDITO"){

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(21,3,"ABONADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(21,3,"PENDIENTE",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(21,3,"VENCIMIENTO",0,0,'L');
    $this->Cell(21,3,date("d/m/Y",strtotime($reg[0]["fechavencecredito"])),0,1,'R');
    }
    ############# MUESTRO ABONOS Y PENDIENTE #############

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(21,3,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET COMPRA (5MM) ##############################

########################## FUNCION TICKET CREDITO COMPRA (8MM) ##############################
function TicketCreditoCompra_8()
{  
    $tra       = new Login();
    $reg       = $tra->ComprasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 20, 3, 35, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE CR�DITO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".$reg[0]['documento']." ".mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');

    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,3,$reg[0]['codfactura'], 0, 1, 'R');
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(33,3,"EMISI.: ".date("d/m/Y",strtotime($reg[0]['fechaemision'])), 0, 0, 'J');
    $this->CellFitSpace(37,3,"RECEPCI.: ".date("d/m/Y",strtotime($reg[0]['fecharecepcion'])), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(33,3,"VENCE: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])), 0, 0, 'J');
    if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] >= date("Y-m-d")) {
    $this->CellFitSpace(37,3,"DIAS VENC: "."0", 0, 0, 'R');  
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) {
    $this->CellFitSpace(37,3,"DIAS VENC: ".Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']), 0, 0, 'R'); 
    }
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLE DE PROVEEDOR", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documproveedor'] == '0' ? "N.DOC:" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['cuitproveedor']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['nomproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9)."N.DE TLF: ".$reg[0]['tlfproveedor'],0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['direcproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE ABONOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonosCompras();
    if($detalle==""){
        echo "";      
    } else {
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','),0,1,'R');

    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(30,3,mb_convert_encoding($detalle[$i]['comprobante'] == "" || $detalle[$i]['comprobante'] == "0" ? "******" : "#".$detalle[$i]['comprobante'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(40,3,mb_convert_encoding($detalle[$i]['codbanco'] == 0 ? "******" : $detalle[$i]['nombanco'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,date("d/m/Y H:i:s",strtotime($detalle[$i]['fechaabono'])),0,1,'L');
    $this->Ln(2);

    endfor; 
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(20,4,"TOTAL",0,0,'L');
    $this->Cell(50,4,$simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio'], 2, '.', ','),0,1,'R');  

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"ABONADO",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"PENDIENTE",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3," ",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET CREDITO COMPRA (8MM) ##############################

########################## FUNCION TICKET CREDITO COMPRA (5MM) ##############################
function TicketCreditoCompra_5()
{  
    $tra       = new Login();
    $reg       = $tra->ComprasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 8, 3, 30, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE CR�DITO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".$reg[0]['documento']." ".mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');

    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['codfactura'], 0, 1, 'R');
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"EMISI.: ".date("d/m/Y",strtotime($reg[0]['fechaemision'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"RECEPCI.: ".date("d/m/Y",strtotime($reg[0]['fecharecepcion'])), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"VENCE: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])), 0, 0, 'J');
    if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] >= date("Y-m-d")) {
    $this->CellFitSpace(21,3,"DIAS VENC: "."0", 0, 0, 'R');  
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) {
    $this->CellFitSpace(21,3,"DIAS VENC: ".Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']), 0, 0, 'R'); 
    }
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLE DE PROVEEDOR", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documproveedor'] == '0' ? "N.DOC:" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['cuitproveedor']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6).mb_convert_encoding($reg[0]['nomproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6)."N.DE TLF: ".$reg[0]['tlfproveedor'],0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6).mb_convert_encoding($reg[0]['direcproveedor'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE ABONOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonosCompras();
    if($detalle==""){
        echo "";      
    } else {
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','),0,1,'R');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['comprobante'] == "" || $detalle[$i]['comprobante'] == "0" ? "******" : "#".$detalle[$i]['comprobante'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codbanco'] == "0" ? "******" : $detalle[$i]['nombanco'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,3,date("d/m/Y H:i:s",strtotime($detalle[$i]['fechaabono'])),0,1,'L');
    $this->Ln(1);

    endfor; 
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"TOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');  

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"ABONADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"PENDIENTE",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3," ",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET CREDITO COMPRA (5MM) ##############################

########################## FUNCION LISTAR COMPRAS ##############################
function TablaListarCompras()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->ListarCompras();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COMPRAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(30,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(35,8,'GASTO ENVIO',1,0,'C', True);
    $this->Cell(45,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,35,30,40,35,35,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalGasto     = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalGasto     += $reg[$i]['gastoenvio'];
    $TotalImporte   += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]["nomproveedor"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','))));
   }
   
    $this->Cell(150,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalGasto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS ##############################

########################## FUNCION LISTAR COMPRAS POR BUSQUEDA ##############################
function TablaListarComprasxBusqueda()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BusquedaCompras();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if($_GET['tipobusqueda'] == 1){
    $this->Cell(335,10,'LISTADO GENERAL DE COMPRAS A PROVEEDORES',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 2){
    $this->Cell(335,10,'LISTADO DE COMPRAS A PROVEEDORES POR B�SQUEDA',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Cell(335,10,'LISTADO DE COMPRAS A PROVEEDORES POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    if($_GET['tipobusqueda'] == 2){
    $this->Ln();
    $this->Cell(335,6,"B�SQUEDA: ".utf8_decode($_GET["search_criterio"]),0,0,'L');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(30,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(35,8,'GASTO ENVIO',1,0,'C', True);
    $this->Cell(45,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,35,30,40,35,35,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalGasto     = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalGasto     += $reg[$i]['gastoenvio'];
    $TotalImporte   += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]["nomproveedor"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','))));
   }
   
    $this->Cell(150,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalGasto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS POR BUSQUEDA ##############################

######################### FUNCION LISTAR CUENTAS POR PAGAR ###########################
function TablaListarCuentasxPagar()
{
    $tra = new Login();
    $reg = $tra->ListarCuentasxPagar();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE CUENTAS POR PAGAR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(30,8,'FECHA VENCE',1,0,'C', True);
    $this->Cell(45,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(45,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(45,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,65,25,30,30,45,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto   = 0;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto   += $reg[$i]['gastoenvio'];
    $TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),
        utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']),
        utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(200,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CUENTAS POR PAGAR ##########################

######################### FUNCION LISTAR CUENTAS POR PAGAR POR BUSQUEDA ###########################
function TablaListarCuentasxPagarxBusqueda()
{
    $tra = new Login();
    $reg = $tra->BusquedaCuentasxPagar();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if($_GET['tipobusqueda'] == 1){
    $this->Cell(335,10,'LISTADO GENERAL DE CUENTAS POR PAGAR A PROVEEDORES',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 2){
    $this->Cell(335,10,'LISTADO DE CUENTAS POR PAGAR A PROVEEDORES POR B�SQUEDA',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Cell(335,10,'LISTADO DE CUENTAS POR PAGAR A PROVEEDORES POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    if($_GET['tipobusqueda'] == 2){
    $this->Ln();
    $this->Cell(335,6,"B�SQUEDA: ".utf8_decode($_GET["search_criterio"]),0,0,'L');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(30,8,'FECHA VENCE',1,0,'C', True);
    $this->Cell(45,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(45,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(45,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,65,25,30,30,45,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto   = 0;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto   += $reg[$i]['gastoenvio'];
    $TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),
        utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']),
        utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(200,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CUENTAS POR PAGAR POR BUSQUEDA ##########################

######################### FUNCION LISTAR CUENTAS POR PAGAR VENCIDAS ###########################
function TablaListarCuentasxPagarVencidas()
{
    $tra = new Login();
    $reg = $tra->ListarCuentasxPagarVencidas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CUENTAS POR PAGAR VENCIDAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(30,8,'FECHA VENCE',1,0,'C', True);
    $this->Cell(45,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(45,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(45,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,65,25,30,30,45,45,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto=0;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto+=$reg[$i]['gastoenvio'];
    $TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),
        utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']),
        utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(200,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CUENTAS POR PAGAR VENCIDAS ##########################

####################### FUNCION LISTAR COMPRAS POR PROVEEDORES #########################
function TablaListarComprasxProveedor()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarComprasxProveedor();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COMPRAS POR PROVEEDOR',0,0,'C');
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"N.TEL�FONO: ".portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "******" : $reg[0]["tlfproveedor"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'ESTADO',1,0,'C', True);
    $this->Cell(40,8,'FECHA VENCE',1,0,'C', True);
    $this->Cell(30,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(45,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(50,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,40,40,40,30,45,40,50));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalGasto     = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalGasto     += $reg[$i]['gastoenvio'];
    $TotalImporte   += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
  
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($reg[$i]['fechavencecredito']== '0000-00-00' || $reg[$i]['fechavencecredito'] >= date("Y-m-d") ? $reg[$i]['statuscompra'] : "VENCIDA"),utf8_decode($reg[$i]['fechavencecredito'] == '0000-00-00' ? "******" : date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','))));
        }
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(50,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR COMPRAS POR PROVEEDORES #########################

########################## FUNCION LISTAR COMPRAS POR FECHAS ##############################
function TablaListarComprasxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarComprasxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COMPRAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(28,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(30,8,'GASTO ENVIO',1,0,'C', True);
    $this->Cell(45,8,'IMPORTE TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,65,35,22,28,35,30,30,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalGasto     = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);  
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += $reg[$i]['totaliva'];
    $TotalGasto     += $reg[$i]['gastoenvio'];
    $TotalImporte   += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]["nomproveedor"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($reg[$i]['fechavencecredito']== '0000-00-00' || $reg[$i]['fechavencecredito'] >= date("Y-m-d") ? $reg[$i]['statuscompra'] : "VENCIDA"),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','))));
   }
   
    $this->Cell(167,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(28,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalGasto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMPRAS POR FECHAS ##############################

######################## FUNCION LISTAR ABONOS CREDITOS POR FECHAS #########################
function TablaListarAbonosCreditosComprasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarAbonosCreditosComprasxFechas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,"LISTADO DE ABONOS DE COMPRAS A CR�DITOS POR FECHAS",0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

        $this->Ln();
        $this->Cell(335,5,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,5,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,5,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"FORMA DE ABONO: ".$reg[0]["mediopago"],0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(45,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(45,8,'FECHA DE ABONO',1,0,'C', True);
    $this->Cell(40,8,'N.DE COMPROBANTE',1,0,'C', True);
    $this->Cell(40,8,'NOMBRE DE BANCO',1,0,'C', True);
    $this->Cell(45,8,'MONTO ABONO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,45,75,45,40,40,45));

    $a=1;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalImporte+=$reg[$i]['montoabono'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),
        utf8_decode($reg[$i]['documento3'].": ".$reg[$i]['cuitproveedor']),
        portales(utf8_decode($reg[$i]['nomproveedor'])),
        utf8_decode(date("d-m-Y H:i:s",strtotime($reg[$i]['fechaabono']))),
        portales(utf8_decode($reg[$i]['comprobante'] == "" ? "********" : $reg[$i]['comprobante'])),
        portales(utf8_decode($reg[$i]['codbanco'] == 0 ? "********" : $reg[$i]['nombanco'])),
        utf8_decode($simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','))
       ));
        }
    }
   
    $this->Cell(290,5,'',0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR ABONOS CREDITOS POR FECHAS #########################

######################## FUNCION LISTAR CREDITOS POR PROVEEDOR ########################
function TablaListarCreditosComprasxProveedor()
{
    $tra = new Login();
    $reg = $tra->BuscarCreditosComprasxProveedor();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'LISTADO DE COMPRAS A CR�DITOS EN GENERAL POR PROVEEDOR',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'LISTADO DE COMPRAS A CR�DITOS PAGADOS POR PROVEEDOR',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'LISTADO DE COMPRAS A CR�DITOS PENDIENTES POR PROVEEDOR',0,0,'C');
    }
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']))." PROVEEDOR: ".utf8_decode($reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".portales(utf8_decode($reg[0]["nomproveedor"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"N.TEL�FONO: ".portales(utf8_decode($reg[0]['tlfproveedor'] == '' ? "******" : $reg[0]["tlfproveedor"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(80,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(30,8,'ESTADO',1,0,'C', True);
    $this->Cell(20,8,'DIAS VENC',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,80,30,20,40,40,40,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto   = 0;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto   += $reg[$i]['gastoenvio'];
    $TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    if($reg[$i]['fechavencecredito'] == '0000-00-00'){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00"){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00"){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00"){
        $vencecredito = Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']);
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00"){
        $vencecredito = Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']);
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['observaciones'] == "" ? "********" : $reg[$i]['observaciones']),utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode($vencecredito),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','))));
        }
    }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR PROVEEDOR ########################

########################## FUNCION LISTAR CREDITOS DE COMPRAS POR FECHAS #########################
function TablaListarCreditosComprasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarCreditosComprasxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'LISTADO DE COMPRAS A CR�DITOS EN GENERAL POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'LISTADO DE COMPRAS A CR�DITOS PAGADOS POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'LISTADO DE COMPRAS A CR�DITOS PENDIENTES POR FECHAS',0,0,'C');
    }
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(30,8,'ESTADO',1,0,'C', True);
    $this->Cell(20,8,'DIAS VENC',1,0,'C', True);
    $this->Cell(40,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,80,30,20,40,40,40,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto   = 0;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto   += $reg[$i]['gastoenvio'];
    $TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    if($reg[$i]['fechavencecredito'] == '0000-00-00'){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00"){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00"){
        $vencecredito = "0";
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00"){
        $vencecredito = Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']);
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00"){
        $vencecredito = Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']);
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']),utf8_decode($reg[$i]["statuscompra"]),
        utf8_decode($vencecredito),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','))));
       }
    }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS DE COMPRAS POR FECHAS #########################

########################## FUNCION LISTAR DETALLES CREDITOS COMPRAS POR PROVEEDOR #########################
function TablaListarDetallesCreditosComprasxProveedor()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesCreditosComprasxProveedor();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'DETALLES DE COMPRAS A CR�DITOS GENERAL POR PROVEEDOR',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'DETALLES DE COMPRAS A CR�DITOS PAGADOS POR PROVEEDOR',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'DETALLES DE COMPRAS A CR�DITOS PENDIENTES POR PROVEEDOR',0,0,'C');
    }
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.DE ".utf8_decode($documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']).": ".$reg[0]["cuitproveedor"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"PROVEEDOR: ".utf8_decode($reg[0]['nomproveedor']),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"N.DE TELEFONO: ".utf8_decode($reg[0]['tlfproveedor'] == "" ? "********" : $reg[0]['tlfproveedor']),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DIRECCI. DOMICILIARIA: ".portales(utf8_decode($reg[0]['direcproveedor'] == "" ? "********" : $reg[0]['direcproveedor'])),0,0,'L');
 
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(33,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(100,8,'DETALLES DE PRODUCTOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,35,33,22,30,100,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto   = 0;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto   += $reg[$i]['gastoenvio'];
    $TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones'])),utf8_decode($reg[$i]["statuscompra"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles_productos'])),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','))));
        }
    }
   
    $this->Cell(235,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES CREDITOS COMPRAS POR PROVEEDOR #########################

########################## FUNCION LISTAR DETALLES CREDITOS COMPRAS POR FECHAS #########################
function TablaListarDetallesCreditosComprasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesCreditosComprasxFechas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'DETALLES DE COMPRAS A CR�DITOS EN GENERAL POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'DETALLES DE COMPRAS A CR�DITOS PAGADOS POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'DETALLES DE COMPRAS A CR�DITOS PENDIENTES POR FECHAS',0,0,'C');
    }
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
 
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(53,8,'DESCRIPCI. DE PROVEEDOR',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(80,8,'DETALLES DE PRODUCTOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(35,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,53,22,30,80,35,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalGasto   = 0;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    
    $TotalGasto   += $reg[$i]['gastoenvio'];
    $TotalImporte += $reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_COMPRA" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),portales(utf8_decode($reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor'])),utf8_decode($reg[$i]["statuscompra"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaemision']))),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles_productos'])),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','))));
        }
    }
   
    $this->Cell(230,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES CREDITOS COMPRAS POR FECHAS #########################

############################################ REPORTES DE COMPRAS ############################################
















############################################ REPORTES DE COTIZACIONES ############################################

########################## FUNCION TICKET COTIZACION (8MM) ##############################
function TicketCotizacion_8()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->CotizacionesPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 15, 3, 45, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE COTIZACI.", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(18,4,"VENDEDOR:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(52,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechacotizacion'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechacotizacion'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding("A CONSUMIDOR FINAL", 'ISO-8859-1', 'UTF-8'), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['dnicliente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['direccliente'].$departamento = ($reg[0]['id_departamento'] == '0' ? "" : " ".$reg[0]['departamento'])."".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : " ".$reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,'L');

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesCotizaciones();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"DESCONTADO %",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXONERADO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXENTO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(34,4,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(70,4,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(30,4,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(40,4,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET COTIZACION (8MM) ##############################

########################## FUNCION TICKET COTIZACION (5MM) ##############################
function TicketCotizacion_5()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->CotizacionesPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 8, 3, 30, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE COTIZACI.", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"VENDEDOR:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechacotizacion'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechacotizacion'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding("A CONSUMIDOR FINAL", 'ISO-8859-1', 'UTF-8'), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['dnicliente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['direccliente'].$departamento = ($reg[0]['id_departamento'] == '0' ? "" : " ".$reg[0]['departamento'])."".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : " ".$reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,'L');

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesCotizaciones();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"DESCONTADO %",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXONERADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXENTO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(42,3,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(21,3,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET COTIZACION (5MM) ##############################

########################## FUNCION FACTURA COTIZACION ##############################
function FacturaCotizacion()
{     
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->CotizacionesPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (isset($reg[0]['cuitsucursal'])) {
        if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
           $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
           $this->Image($logo, 15, 11, 45, 16, "PNG");
        } else {
           $logo = "fotos/logo_principal.png";
           $this->Image($logo, 15, 10, 45, 16, "PNG");                         
        }                                      
    }

    if($reg[0]['procesada'] == 1){
    $estado = "PENDIENTE";
    } elseif($reg[0]['procesada'] == 2){
    $estado = "PROCESADA"; 
    }

    ############################# BLOQUE N.1 FACTURA ###############################   
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 190, 18, '1.5', '');
    
    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 12);
    $this->Cell(40, 4, 'N.DE FACTURA', 0, 0);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(155, 12);
    $this->CellFitSpace(45, 4,utf8_decode($reg[0]['codfactura']), 0, 0, "R");


    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 16);
    $this->Cell(40, 4, 'FECHA DE REGISTRO', 0, 0);
    $this->SetFont($TipoLetra,'',10);
    $this->SetXY(155, 16);
    $this->CellFitSpace(45, 4,utf8_decode(date("d/m/Y",strtotime($reg[0]['fechacotizacion']))), 0, 0, "R");

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 20);
    $this->Cell(40, 4, 'HORA DE REGISTRO', 0, 0);
    $this->SetFont($TipoLetra,'',10);
    $this->SetXY(155, 20);
    $this->CellFitSpace(45, 4,utf8_decode(date("H:i:s",strtotime($reg[0]['fechacotizacion']))), 0, 0, "R");

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(115, 24);
    $this->Cell(40, 4, 'ESTADO', 0, 0);
    $this->SetFont($TipoLetra,'',10);
    $this->SetXY(155, 24);
    $this->CellFitSpace(45, 4,utf8_decode($estado), 0, 0, "R");
    ################################# BLOQUE N.1 FACTURA ################################ 

    ############################# BLOQUE N.2 SUCURSAL ###############################   
    //Bloque de datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 29, 190, 18, '1.5', '');
    //DATOS DE SUCURSAL LINEA 1
    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(12, 30);
    $this->Cell(186, 4, 'DATOS DE SUCURSAL ', 0, 0);
    //DATOS DE SUCURSAL LINEA 1

    //DATOS DE SUCURSAL LINEA 2
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 34);
    $this->Cell(24, 4, 'RAZ. SOCIAL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 34);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(102, 34);
    $this->CellFitSpace(22, 4, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(124, 34);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(152, 34);
    $this->Cell(18, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(170, 34);
    $this->Cell(28, 4,utf8_decode($reg[0]['tlfsucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 2

    //DATOS DE SUCURSAL LINEA 3
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 38);
    $this->Cell(24, 4, "DIRECCI.: ", 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 38);
    $this->CellFitSpace(96, 4,utf8_decode($reg[0]['direcsucursal'].", ".$departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(132, 38);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(144, 38);
    $this->Cell(54, 4,utf8_decode($reg[0]['correosucursal']), 0, 0);
    //DATOS DE SUCURSAL LINEA 3

    //DATOS DE SUCURSAL LINEA 4
    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 42);
    $this->Cell(24, 4, 'RESPONSABLE:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(36, 42);
    $this->CellFitSpace(66, 4,utf8_decode($reg[0]['nomencargado']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(102, 42);
    $this->CellFitSpace(22, 4, 'N.DE '.$documento = ($reg[0]['documencargado'] == '0' ? "DOC.:" : $reg[0]['documento2'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(124, 42);
    $this->CellFitSpace(28, 4,utf8_decode($reg[0]['dniencargado']), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(152, 42);
    $this->Cell(18, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(170, 42);
    $this->Cell(28, 4,utf8_decode($tlf = ($reg[0]['tlfencargado'] == '' ? "******" : $reg[0]['tlfencargado'])), 0, 0);
    //DATOS DE SUCURSAL LINEA 4
    ############################ BLOQUE N.2 SUCURSAL ############################### 

    ############################## BLOQUE N.3 CLIENTE #################################  
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 48, 190, 14, '1.5', '');

    $this->SetFont($TipoLetra,'B',9);
    $this->SetXY(12, 49);
    $this->Cell(186, 4, 'DATOS DE CLIENTE ', 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 53);
    $this->Cell(20, 4, 'NOMBRES:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(32, 53);
    $this->CellFitSpace(70, 4,utf8_decode($nombre = ($reg[0]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(102, 53);
    $this->CellFitSpace(20, 4, 'N.DE '.$documento = ($reg[0]['documcliente'] == '0' ? "DOC.:" : $reg[0]['documento3'].":"), 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(122, 53);
    $this->CellFitSpace(20, 4,utf8_decode($nombre = ($reg[0]['dnicliente'] == '' ? "******" : $reg[0]['dnicliente'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(142, 53);
    $this->Cell(20, 4, 'N.DE TLF:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(162, 53);
    $this->CellFitSpace(36, 4,utf8_decode($tlf = ($reg[0]['tlfcliente'] == '' ? "******" : $reg[0]['tlfcliente'])), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(12, 57);
    $this->Cell(20, 4, 'DIRECCI.:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(32, 57);
    $this->CellFitSpace(110, 4,getSubString(utf8_decode($provincia = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2'])."".$departamento = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])." ".$reg[0]['direccliente']), 70), 0, 0);

    $this->SetFont($TipoLetra,'B',8);
    $this->SetXY(142, 57);
    $this->Cell(12, 4, 'EMAIL:', 0, 0);
    $this->SetFont($TipoLetra,'',8);
    $this->SetXY(154, 57);
    $this->CellFitSpace(44, 4,utf8_decode($email = ($reg[0]['emailcliente'] == '' ? "******" : $reg[0]['emailcliente'])), 0, 0); 
    ############################## BLOQUE N.3 CLIENTE #################################

    //######################### BLOQUE DATOS DE PRODUCTOS #############################
    $this->Ln(3);
    $this->SetXY(10, 63);
    $this->SetFont($TipoLetra,'B',11);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,5,'N�',1,0,'C', True);
    $this->Cell(115,5,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,5,'CANTIDAD',1,0,'C', True);
    $this->Cell(20,5,'PRECIO',1,0,'C', True);
    $this->Cell(25,5,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesCotizaciones();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,115,20,20,25));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad   += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal   += $detalle[$i]['valorneto'];

    $this->SetX(10);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,"",9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : ""))),utf8_decode($detalle[$i]['cantidad']),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
    //######################### BLOQUE DATOS DE PRODUCTOS #############################

    ########################### BLOQUE N.6 #############################
    $this->Ln(2);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'INFORMACI. ADICIONAL',1,0,'C', True);
    $this->Cell(2,5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(45,5,'DESCONTADO:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]['totaldescuento'], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'SUBTOTAL:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'TIPO DE DOCUMENTO: FACTURA DE COTIZACI.',1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'EXONERADO:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'REALIZADO: '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'FECHA DE EMISI.: '.date("d/m/Y"),1,0,'L');

    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(103,5,'HORA DE EMISI.: '.date("H:i:s"),1,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->CellFitSpace(45,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(103,5,'',0,0,'L');
    $this->Cell(2,5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(45,5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(40,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(196,8,$this->SetFont($TipoLetra,'B',10).'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,'J');
    $this->Ln();

    if($reg[0]['observaciones'] != ''){
    //Linea de membrete Nro 4
    $this->SetFont($TipoLetra,'B',10);
    $this->MultiCell(190,5,$this->SetFont($TipoLetra,'',10).'OBSERVACIONES: '.utf8_decode($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']),1,'J');
    }
    ########################### BLOQUE N.6 #############################
}
########################## FUNCION FACTURA COTIZACION ##############################


########################## FUNCION LISTAR COTIZACIONES ##############################
function TablaListarCotizaciones()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->ListarCotizaciones();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE COTIZACIONES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES ##############################

########################## FUNCION LISTAR COTIZACIONES POR BUSQUEDA ##############################
function TablaListarCotizacionesxBusqueda()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BusquedaCotizaciones();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if($_GET['tipobusqueda'] == 1){
    $this->Cell(335,10,'LISTADO GENERAL DE COTIZACIONES A CLIENTES',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 2){
    $this->Cell(335,10,'LISTADO DE COTIZACIONES A CLIENTES POR B�SQUEDA',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Cell(335,10,'LISTADO DE COTIZACIONES A CLIENTES POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    if($_GET['tipobusqueda'] == 2){
    $this->Ln();
    $this->Cell(335,6,"B�SQUEDA: ".utf8_decode($_GET["search_criterio"]),0,0,'L');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR BUSQUEDA ##############################

########################## FUNCION LISTAR COTIZACIONES POR FECHAS ##############################
function TablaListarCotizacionesxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COTIZACIONES POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR FECHAS ##############################

########################## FUNCION LISTAR COTIZACIONES POR VENDEDOR ##############################
function TablaListarCotizacionesxVendedor()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarCotizacionesxVendedor();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE COTIZACIONES POR VENDEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechacotizacion']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COTIZACIONES POR VENDEDOR ##############################

########################## FUNCION LISTAR DETALLES COTIZACIONES POR FECHAS ##############################
function TablaListarDetallesCotizacionesxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesCotizacionesxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES COTIZACIONES POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'COTIZADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES COTIZACIONES POR FECHAS ##############################

########################## FUNCION LISTAR DETALLES COTIZACIONES POR VENDEDOR ##############################
function TablaListarDetallesCotizacionesxVendedor()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesCotizacionesxVendedor(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES COTIZACIONES POR VENDEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'COTIZADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo         = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES COTIZACIONES POR VENDEDOR ##############################

############################################ REPORTES DE COTIZACIONES ############################################
















############################################ REPORTES DE PREVENTAS ############################################

########################## FUNCION TICKET PREVENTAS (8MM) ##############################
function TicketPreventa_8()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->PreventasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo , 15, 3, 45, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE PREVENTA", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(18,4,"VENDEDOR:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(52,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechapreventa'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechapreventa'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding("A CONSUMIDOR FINAL", 'ISO-8859-1', 'UTF-8'), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['dnicliente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direccliente'].$departamento = ($reg[0]['id_departamento'] == '0' ? "" : " ".$reg[0]['departamento'])."".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : " ".$reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,'L');

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesPreventas();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"DESCONTADO %",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXONERADO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXENTO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(34,4,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(70,4,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(30,4,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(40,4,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET PREVENTAS (8MM) ##############################

########################## FUNCION TICKET PREVENTAS (5MM) ##############################
function TicketPreventa_5()
{       
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->PreventasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 8, 3, 30, 15, "PNG");
    $this->Ln(8);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE PREVENTA", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['codfactura'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"VENDEDOR:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechapreventa'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechapreventa'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding("A CONSUMIDOR FINAL", 'ISO-8859-1', 'UTF-8'), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['dnicliente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',6.5).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',6.5).mb_convert_encoding($reg[0]['direccliente'].$departamento = ($reg[0]['id_departamento'] == '0' ? "" : " ".$reg[0]['departamento'])."".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : " ".$reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,'L');

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle   = $tra->VerDetallesPreventas();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');
    $this->Ln(1);

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"DESCONTADO %",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXONERADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXENTO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(42,3,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(21,3,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont('Courier','BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET PREVENTAS (5MM) ##############################

########################## FUNCION LISTAR PREVENTAS ##############################
function TablaListarPreventas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->ListarPreventas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE PREVENTAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechapreventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PREVENTAS ##############################

########################## FUNCION LISTAR CLIENTES EN PREVENTAS ##############################
function ClientesxPreventas()
{
    $tra = new Login();
    $reg = $tra->ListarClientesxPreventas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(330,10,'LISTADO DE CLIENTES CON PREVENTAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.FACTURA',1,0,'C', True);
    $this->Cell(40,8,'N.DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'NOMBRE DE CLIENTE',1,0,'C', True);
    $this->Cell(130,8,'DIRECCI.',1,0,'C', True);
    $this->Cell(40,8,'TELEFONO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,40,40,70,130,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["documento"]." ".$reg[$i]["dnicliente"]),portales(utf8_decode($reg[$i]["nomcliente"])),
        utf8_decode($direccliente = ($reg[$i]['direccliente'] == '' ? "******" : $reg[$i]['direccliente']).$departamento = ($reg[$i]['id_departamento2'] == '0' ? "" : ", ".$reg[$i]['departamento2']).$provincia = ($reg[$i]['id_provincia2'] == '0' ? "" : " - ".$reg[$i]['provincia2'])),utf8_decode($reg[$i]["tlfcliente"])));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CLIENTES EN PREVENTAS ##############################

########################## FUNCION LISTAR PREVENTAS POR FECHAS ##############################
function TablaListarPreventasxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarPreventasxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PREVENTAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechapreventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PREVENTAS POR FECHAS ##############################

########################## FUNCION LISTAR PREVENTAS POR VENDEDOR ##############################
function TablaListarPreventasxVendedor()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarPreventasxVendedor();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE PREVENTAS POR VENDEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,70,30,25,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    if($reg[$i]['procesada']==1) { 
    $estado = 'PENDIENTE'; 
    } elseif($reg[$i]['procesada']==2) {  
    $estado = 'PROCESADA'; 
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechapreventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR PREVENTAS POR VENDEDOR ##############################

########################## FUNCION LISTAR DETALLES PREVENTAS POR FECHAS ##############################
function TablaListarDetallesPreventasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesPreventasxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES PREVENTAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'PREVENTA',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo        = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES PREVENTAS POR FECHAS ##############################

########################## FUNCION LISTAR DETALLES PREVENTAS POR VENDEDOR ##############################
function TablaListarDetallesPreventasxVendedor()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesPreventasxVendedor(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DETALLES PREVENTAS POR VENDEDOR',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'PREVENTA',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo         = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES PREVENTAS POR VENDEDOR ##############################

############################################ REPORTES DE PREVENTAS ############################################





















############################################ REPORTES DE CAJAS ############################################

########################## FUNCION LISTAR CAJAS ASIGNADAS ##############################
function TablaListarCajas()
{
    $tra = new Login();
    $reg = $tra->ListarCajas();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'LISTADO GENERAL DE CAJAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(35,8,'N.DE CAJA',1,0,'C', True);
    $this->Cell(55,8,'NOMBRE DE CAJA',1,0,'C', True);
    $this->Cell(90,8,'RESPONSABLE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,35,55,90));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["nrocaja"]),utf8_decode($reg[$i]['nomcaja']),utf8_decode($reg[$i]["nombres"])));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CAJAS ASIGNADAS ##############################

########################## FUNCION TICKET CIERRE ARQUEO (8MM) ##############################
function TicketCierre_8()
{  
    $tra = new Login();
    $reg = $tra->ArqueoCajaPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    $detalleabonos = (new Login)->DetallesAbonosArqueoCajaPorId();

    $detallemovimientos = (new Login)->DetallesMovimientosArqueoCajaPorId();

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 15, 3, 45, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE CIERRE", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(20,3,"CAJA N�:",0,0,'L');
    $this->CellFitSpace(50,3,mb_convert_encoding($reg[0]['nrocaja']."-".$reg[0]['nomcaja'], 'ISO-8859-1', 'UTF-8'),0,1,'L');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(20,3,"CAJERO:",0,0,'L');
    $this->CellFitSpace(50,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(20,3,"FECHA EMISI.:",0,0,'L');
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s"),0,1,'L');

    $this->SetFont('Courier','B',12);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(30,3,"HORA APERTURA:",0,0,'L');
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura'])),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(30,3,"HORA CIERRE:",0,0,'L');
    $this->CellFitSpace(40,3,date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre'])),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(30,3,"MONTO APERTURA:",0,0,'L');
    $this->CellFitSpace(40,3,$simbolo.number_format($reg[0]["montoinicial"], 2, '.', ','),0,1,'L');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,3,"DESGLOSE EN VENTAS",0,1,'C');
    $this->Ln(1);

    $a=1;
    $Ventas_Efectivo = 0;
    for($i=0;$i<sizeof($reg);$i++):
    $Ventas_Efectivo += ($reg[$i]['mediopago'] == "EFECTIVO" ? $reg[$i]['montopagado'] : 0);
       if($reg[$i]['mediopago'] != ""){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,mb_convert_encoding($reg[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[$i]['montopagado'], 2, '.', ','),0,1,'R');

       }
    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"CR�DITOS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]["creditos"], 2, '.', ','),0,1,'R');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(70,3,"DESGLOSE EN ABONOS CR�DITOS",0,1,'C');
    $this->Ln(1);

    $a=1;
    $Abonos_Efectivo = 0;
    for($i=0;$i<sizeof($detalleabonos);$i++):
    $Abonos_Efectivo += ($detalleabonos[$i]['mediopago'] == "EFECTIVO" ? $detalleabonos[$i]['monto_abonado'] : 0);
    if($detalleabonos[$i]['mediopago'] != ""){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,mb_convert_encoding($detalleabonos[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($detalleabonos[$i]['monto_abonado'], 2, '.', ','),0,1,'R');

    }
    endfor;

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,3,"MOVIMIENTOS EN CAJA",0,1,'C');
    $this->Ln(1);

    $a=1;
    $Movimientos_Efectivo = 0;
    for($i=0;$i<sizeof($detallemovimientos);$i++):
    $Movimientos_Efectivo += ($detallemovimientos[$i]['mediopago'] == "EFECTIVO" ? $detallemovimientos[$i]['movimientos_efectivo'] : 0);
    if($detallemovimientos[$i]['mediopago'] != ""){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,mb_convert_encoding($detallemovimientos[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($detallemovimientos[$i]['movimientos_efectivo'], 2, '.', ','),0,1,'R');

    }
    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"EGRESOS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]["egresos"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"EGRESOS(NC):",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]["egresonotas"], 2, '.', ','),0,1,'R');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(70,3,"REPORTE DE CAJA",0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"TOTAL EN VENTAS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]["ingresos"]+$reg[0]["creditos"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"TOTAL DE ABONOS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]['abonos'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"EFECTIVO EN CAJA:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format(($reg[0]["montoinicial"]+$Ventas_Efectivo+$Abonos_Efectivo+$Movimientos_Efectivo)-($reg[0]["egresos"]+$reg[0]["egresonotas"]), 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"EFECTIVO DISPONIBLE:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]["dineroefectivo"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(34,3,"DIF. EFECTIVO:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(30,3,number_format($reg[0]["diferencia"], 2, '.', ','),0,1,'R');


    if($reg[0]["comentarios"]==""){

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

   } else { 

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->MultiCell(70,4,$this->SetFont($TipoLetra,"",7).utf8_decode($reg[0]["comentarios"]),0,'L');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(13,4,"FIRMA:",0,0,'L');
    $this->Cell(55,5,utf8_decode("_____________________"),0,1,'L');
 
    $this->SetFont($TipoLetra,'BI',9);
    $this->SetFillColor(3, 3, 3);
    $this->SetX(2);
    $this->CellFitSpace(70,3,"N.DE DOC ".mb_convert_encoding($reg[0]['dni'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'),0,'C');
    $this->Ln(3);  
}
########################## FUNCION TICKET CIERRE ARQUEO (8MM) ##############################

########################## FUNCION TICKET CIERRE ARQUEO (5MM) ##############################
function TicketCierre_5()
{  
    $tra = new Login();
    $reg = $tra->ArqueoCajaPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    $detalleabonos = (new Login)->DetallesAbonosArqueoCajaPorId();

    $detallemovimientos = (new Login)->DetallesMovimientosArqueoCajaPorId();

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 8, 3, 30, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE CIERRE", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"CAJA:",0,0,'L');
    $this->CellFitSpace(26,3,mb_convert_encoding($reg[0]['nrocaja']."-".$reg[0]['nomcaja'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"CAJERO:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"EMISI.:",0,0,'L');
    $this->CellFitSpace(26,3,date("d/m/Y H:i:s"),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"APERTURA:",0,0,'L');
    $this->CellFitSpace(26,3,date("d/m/Y H:i:s",strtotime($reg[0]['fechaapertura'])),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"CIERRE:",0,0,'L');
    $this->CellFitSpace(26,3,date("d/m/Y H:i:s",strtotime($reg[0]['fechacierre'])),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(16,3,"MONTO:",0,0,'L');
    $this->CellFitSpace(26,3,$simbolo.number_format($reg[0]["montoinicial"], 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,"DESGLOSE EN VENTAS",0,1,'C');
    $this->Ln(1);

    $a=1;
    $Ventas_Efectivo = 0;
    for($i=0;$i<sizeof($reg);$i++):
    $Ventas_Efectivo += ($reg[$i]['mediopago'] == "EFECTIVO" ? $reg[$i]['montopagado'] : 0);
       if($reg[$i]['mediopago'] != ""){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,mb_convert_encoding($reg[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[$i]['montopagado'], 2, '.', ','),0,1,'R');

       }
    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"CR�DITOS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]["creditos"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,"DESGLOSE EN ABONOS CR�DITOS",0,1,'C');
    $this->Ln(1);

    $a=1;
    $Abonos_Efectivo = 0;
    for($i=0;$i<sizeof($detalleabonos);$i++):
    $Abonos_Efectivo += ($detalleabonos[$i]['mediopago'] == "EFECTIVO" ? $detalleabonos[$i]['monto_abonado'] : 0);
    if($detalleabonos[$i]['mediopago'] != ""){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,mb_convert_encoding($detalleabonos[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($detalleabonos[$i]['monto_abonado'], 2, '.', ','),0,1,'R');

    }
    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,"MOVIMIENTOS EN CAJA",0,1,'C');
    $this->Ln(1);

    $a=1;
    $Movimientos_Efectivo = 0;
    for($i=0;$i<sizeof($detallemovimientos);$i++):
    $Movimientos_Efectivo += ($detallemovimientos[$i]['mediopago'] == "EFECTIVO" ? $detallemovimientos[$i]['movimientos_efectivo'] : 0);
    if($detallemovimientos[$i]['mediopago'] != ""){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,mb_convert_encoding($detallemovimientos[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($detallemovimientos[$i]['movimientos_efectivo'], 2, '.', ','),0,1,'R');

    }
    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"EGRESOS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]["egresos"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"EGRESOS(NC):",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]["egresonotas"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->CellFitSpace(42,3,"REPORTE DE CAJA",0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"TOTAL EN VENTAS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]["ingresos"]+$reg[0]["creditos"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"TOTAL DE ABONOS:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]['abonos'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"EFECTIVO EN CAJA:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format(($reg[0]["montoinicial"]+$Ventas_Efectivo+$Abonos_Efectivo+$Movimientos_Efectivo)-($reg[0]["egresos"]+$reg[0]["egresonotas"]), 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"EFECTIVO DISP.:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]["dineroefectivo"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(20,3,"DIF. EFECTIVO:",0,0,'L');
    $this->CellFitSpace(6,3,$simbolo,0,0,'R');
    $this->CellFitSpace(16,3,number_format($reg[0]["diferencia"], 2, '.', ','),0,1,'R');


    if($reg[0]["comentarios"]==""){

    $this->SetFont($TipoLetra,'B',10);
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

   } else { 

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->MultiCell(42,4,$this->SetFont($TipoLetra,"",7).utf8_decode($reg[0]["comentarios"]),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(10,4,"FIRMA:",0,0,'L');
    $this->Cell(32,5,utf8_decode("___________________"),0,1,'L');
 
    $this->SetFont($TipoLetra,'B',6.5);
    $this->SetFillColor(3, 3, 3);
    $this->SetX(2);
    $this->CellFitSpace(42,3,"N.DE DOC ".mb_convert_encoding($reg[0]['dni'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',6.5).mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'),0,'C');
    $this->Ln(3);  
}
########################## FUNCION TICKET CIERRE ARQUEO (5MM) ##############################

########################## FUNCION LISTAR ARQUEOS DE CAJAS ##############################
function TablaListarArqueos()
{
    $tra = new Login();
    $reg = $tra->ListarArqueoCaja();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE ARQUEOS EN CAJAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(70,8,'N.DE CAJA',1,0,'C', True);
    $this->Cell(25,8,'INICIO',1,0,'C', True);
    $this->Cell(25,8,'CIERRE',1,0,'C', True);
    $this->Cell(25,8,'INICIAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTAS',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONOS',1,0,'C', True);
    $this->Cell(40,8,'EFECTIVO EN CAJA',1,0,'C', True);
    $this->Cell(40,8,'EFECTIVO DISPON',1,0,'C', True);
    $this->Cell(30,8,'DIF EFECTIVO',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,70,25,25,25,40,30,40,40,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalVentas     = 0;
    $TotalAbonos     = 0;
    $TotalIngresos   = 0; 
    $TotalEgresos    = 0;  
    $TotalCaja       = 0;
    $TotalEfectivo   = 0;
    $TotalDiferencia = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalVentas     += $reg[$i]['ingresos']+$reg[$i]['creditos'];
    $TotalAbonos     += $reg[$i]['abonos'];
    $TotalIngresos   += $reg[$i]['ingresos2'];
    $TotalEgresos    += $reg[$i]['egresos']+$reg[$i]['egresonotas'];
    $TotalCaja       += $reg[$i]['efectivocaja'];
    $TotalEfectivo   += $reg[$i]['dineroefectivo'];
    $TotalDiferencia += $reg[$i]['diferencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja'].":".$reg[$i]['nombres']),
        utf8_decode( date("d/m/Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
        utf8_decode($reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "******" : date("d/m/Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['abonos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['efectivocaja'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
    }

    $this->Cell(155,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalVentas, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbonos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalCaja, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalEfectivo, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDiferencia, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ARQUEOS DE CAJAS ##############################

########################## FUNCION LISTAR ARQUEOS DE CAJAS POR FECHAS ##############################
function TablaListarArqueosxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarArqueosxFechas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE ARQUEOS EN CAJAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.DE CAJA: ".utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"RESPONSABLE: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(25,8,'INICIO',1,0,'C', True);
    $this->Cell(25,8,'CIERRE',1,0,'C', True);
    $this->Cell(25,8,'INICIAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL VENTAS',1,0,'C', True);
    $this->Cell(30,8,'TOTAL ABONOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL INGRESOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL EGRESOS',1,0,'C', True);
    $this->Cell(40,8,'EFECTIVO EN CAJA',1,0,'C', True);
    $this->Cell(40,8,'EFECTIVO DISPON',1,0,'C', True);
    $this->Cell(30,8,'DIF EFECTIVO',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,25,25,25,40,30,35,35,40,40,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalVentas     = 0;
    $TotalAbonos     = 0;
    $TotalIngresos   = 0; 
    $TotalEgresos    = 0;  
    $TotalCaja       = 0;
    $TotalEfectivo   = 0;
    $TotalDiferencia = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $TotalVentas     += $reg[$i]['ingresos']+$reg[$i]['creditos'];
    $TotalAbonos     += $reg[$i]['abonos'];
    $TotalIngresos   += $reg[$i]['ingresos2'];
    $TotalEgresos    += $reg[$i]['egresos']+$reg[$i]['egresonotas'];
    $TotalCaja       += $reg[$i]['efectivocaja'];
    $TotalEfectivo   += $reg[$i]['dineroefectivo'];
    $TotalDiferencia += $reg[$i]['diferencia'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode( date("d/m/Y H:i:s",strtotime($reg[$i]['fechaapertura']))),
        utf8_decode($reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "******" : date("d/m/Y H:i:s",strtotime($reg[$i]['fechacierre']))),
        utf8_decode($simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['abonos'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['ingresos2'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['egresos']+$reg[$i]['egresonotas'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['efectivocaja'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','))));
    }

    $this->Cell(85,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalVentas, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbonos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIngresos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalEgresos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalCaja, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalEfectivo, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDiferencia, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR ARQUEOS DE CAJAS POR FECHAS ##############################

########################## FUNCION TICKET MOVIMIENTOS (8MM) ##############################
function TicketMovimiento_8()
{  
    $tra = new Login();
    $reg = $tra->MovimientosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
       $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
       $this->Image($logo, 15, 3, 45, 15, "PNG");
       $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE MOVIMIENTO", 0, 0, 'C');
    $this->Ln(5);
  
    //######################### BLOQUE DATOS DE SUCURSAL #############################
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');
    //######################### BLOQUE DATOS DE SUCURSAL #############################

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,mb_convert_encoding($reg[0]['numero'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(18,4,"CAJA:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(52,4,mb_convert_encoding($reg[0]['nrocaja'].":".$reg[0]['nomcaja'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(18,4,"CAJERO:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(52,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechamovimiento'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechamovimiento'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"TIPO:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,mb_convert_encoding($reg[0]['tipomovimiento'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"MONTO:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,$simbolo.number_format($reg[0]["montomovimiento"], 2, '.', ','), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"MEDIO:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,4,mb_convert_encoding($reg[0]['mediopago'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DESCRIPCI. DE MOVIMIENTO", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'',8).mb_convert_encoding($reg[0]['descripcionmovimiento'] == "" ? "SIN OBSERVACIONES" : $reg[0]['descripcionmovimiento'], 'ISO-8859-1', 'UTF-8'),0,'J');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln();

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'BI',10)." ",0,'C');
    $this->Ln(3);   
}
########################## FUNCION TICKET MOVIMIENTOS (8MM) ##############################

########################## FUNCION TICKET MOVIMIENTOS (5MM) ##############################
function TicketMovimiento_5()
{  
    $tra = new Login();
    $reg = $tra->MovimientosPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
       $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
       $this->Image($logo, 8, 3, 30, 15, "PNG");
       $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE MOVIMIENTO", 0, 0, 'C');
    $this->Ln(5);
  
    //######################### BLOQUE DATOS DE SUCURSAL #############################
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');
    //######################### BLOQUE DATOS DE SUCURSAL #############################

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,mb_convert_encoding($reg[0]['numero'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"CAJA:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,mb_convert_encoding($reg[0]['nrocaja'].":".$reg[0]['nomcaja'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"CAJERO:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechamovimiento'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechamovimiento'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"TIPO:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['tipomovimiento'], 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"MONTO:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$simbolo.number_format($reg[0]["montomovimiento"], 2, '.', ','), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"MEDIO:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,mb_convert_encoding($reg[0]['mediopago'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DESCRIPCI. MOVIMIENTO", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'',8).mb_convert_encoding($reg[0]['descripcionmovimiento'] == "" ? "SIN OBSERVACIONES" : $reg[0]['descripcionmovimiento'], 'ISO-8859-1', 'UTF-8'),0,'J');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'BI',10)." ",0,'C');
    $this->Ln(3);   
}
########################## FUNCION TICKET MOVIMIENTOS (5MM) ##############################

####################### FUNCION LISTAR MOVIMIENTOS EN CAJA ##########################
function TablaListarMovimientos()
{
    $tra = new Login();
    $reg = $tra->ListarMovimientos();

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'LISTADO GENERAL DE MOVIMIENTOS EN CAJA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE CAJA',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(30,8,'MONTO',1,0,'C', True);
    $this->Cell(35,8,'MEDIO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,40,20,55,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']),utf8_decode($reg[$i]["tipomovimiento"]),utf8_decode($reg[$i]['descripcionmovimiento']),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ',')),utf8_decode($reg[$i]["mediopago"])));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR MOVIMIENTOS EN CAJAS #########################

##################### FUNCION LISTAR MOVIMIENTOS EN CAJA POR FECHAS #####################
function TablaListarMovimientosxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarMovimientosxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,"LISTADO DE MOVIMIENTOS EN CAJA POR FECHAS",0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(190,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(190,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(190,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(190,6,"N.DE CAJA: ".utf8_decode($reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"RESPONSABLE: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(75,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(40,8,'MONTO',1,0,'C', True);
    $this->Cell(45,8,'MEDIO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,20,75,40,45));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($reg[$i]["tipomovimiento"]),utf8_decode($reg[$i]['descripcionmovimiento']),utf8_decode($simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ',')),utf8_decode($reg[$i]["mediopago"])));
        }
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
##################### FUNCION LISTAR MOVIMIENTOS EN CAJAS POR FECHAS ###################

########################## FUNCION INFORME DE CAJAS POR FECHAS ##############################
function InformeCajasxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $caja = new Login();
    $caja = $caja->CajasPorId();
    $simbolo = ($caja[0]['simbolo'] == "" ? "" : $caja[0]['simbolo']);

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

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,10,'INFORME DE CAJAS POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(190,5,"N.".utf8_decode($caja[0]['documento'])." SUCURSAL: ".utf8_decode($caja[0]["cuitsucursal"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,5,"SUCURSAL: ".portales(utf8_decode($caja[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(190,5,"ENCARGADO: ".portales(utf8_decode($caja[0]["nomencargado"])),0,1,'L'); 

    }

    $this->Ln();
    $this->Cell(190,5,"CAJA N�: ".utf8_decode($caja[0]["nrocaja"].": ".$caja[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(190,5,"RESPONSABLE: ".utf8_decode($caja[0]["nombres"]),0,1,'L');
    $this->Ln();
    $this->Cell(190,5,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(190,5,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,1,'L');

    $this->Ln();
    $this->SetFont('courier','B',12);
    $this->Cell(120,8,'TOTAL DE VENTAS',0,0,'L', false);
    $this->SetFont('courier','B',14);
    $this->Cell(70,8,utf8_decode($simbolo.number_format($venta[0]['totalventa'], 2, '.', ',')),0,0,'R');
    $this->Ln();

    $this->SetFont('courier','B',12);
    $this->Cell(120,8,'TOTAL DE INGRESOS',0,0,'L', false);
    $this->SetFont('courier','B',14);
    $this->Cell(70,8,utf8_decode($simbolo.number_format($arqueo[0]['totalingresos'], 2, '.', ',')),0,0,'R');
    $this->Ln();

    $this->SetFont('courier','B',12);
    $this->Cell(120,8,'ABONOS A CR�DITOS',0,0,'L', false);
    $this->SetFont('courier','B',14);
    $this->Cell(70,8,utf8_decode($simbolo.number_format($arqueo[0]['totalabonos'], 2, '.', ',')),0,0,'R');
    $this->Ln();
   

    $this->SetFont('courier','B',12);
    $this->Cell(120,8,'TOTAL DE GASTOS (EGRESOS + NOTAS DE CR�DITOS)',0,0,'L', false);
    $this->SetFont('courier','B',14);
    $this->Cell(70,8,utf8_decode($simbolo.number_format($arqueo[0]['totalegresos'], 2, '.', ',')),0,0,'R');
    $this->Ln();
  
    $this->SetFont('courier','B',12);
    $this->Cell(120,8,'TOTAL DE IMPUESTOS VENTAS '.$NomImpuesto.' ('.$ValorImpuesto.'%)',0,0,'L', false);
    $this->SetFont('courier','B',14);
    $this->Cell(70,8,utf8_decode($simbolo.number_format($venta[0]['totaliva'], 2, '.', ',')),0,0,'R');
    $this->Ln();

    $this->SetFont('courier','B',12);
    $this->Cell(120,8,'DISPONIBLE EN CAJA SIN IMPUESTOS',0,0,'L', false);
    $this->SetFont('courier','B',14);
    $this->Cell(70,8,utf8_decode($simbolo.number_format($Disponible, 2, '.', ',')),0,0,'R');
    $this->Ln();


    $this->Ln(12); 
    $this->SetFont('Courier','B',10);
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(86,6,'RECIBIDO:____________________________',0,0,'');
    $this->Ln();
    $this->Cell(4,6,'',0,0,'');
    $this->Cell(100,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(86,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION INFORME DE CAJAS POR FECHAS ##############################

############################################ REPORTES DE CAJAS ############################################













############################################ REPORTES DE VENTAS ############################################

########################## FUNCION NOTA DE VENTA (8MM) ##############################
function NotaVenta_8()
{  
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->VentasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 3, 45, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->Ln(2);
    $this->SetX(2);
    $this->MultiCell(70,4,$this->SetFont($TipoLetra,'B',10).mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? " " : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "NOTA DE VENTA", 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,$reg[0]['codfactura'], 0, 1, 'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->CellFitSpace(18,3,"CAJA N�",0,0,'J');
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(52,3,mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(18,4,"CAJERO:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(52,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechaventa'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,utf8_decode("A CONSUMIDOR FINAL"), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".$reg[0]['documento3']).": ".$reg[0]['dnicliente'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).utf8_decode($reg[0]['nomcliente']),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).utf8_decode($reg[0]['direccliente'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2'])),0,'L');
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra       = new Login();
    $detalle   = $tra->VerDetallesVentas();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    if($detalle[$i]["descripcion"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["descripcion"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    if($detalle[$i]["imei"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(70,3,"N.DE IMEI: ".mb_convert_encoding($detalle[$i]["imei"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(22,4,"TIPO PAGO",0,0,'L');
    $this->Cell(48,4,mb_convert_encoding($reg[0]['tipopago'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"DESCONTADO %",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXONERADO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXENTO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(34,4,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    if($reg[0]['tipopago'] == "CONTADO"){ 

    $explode = explode("<br>",$reg[0]['detalles_pagos']);
    $contador = 1;
    for($cont=0; $cont<COUNT($explode); $cont++):
    list($codmediopago,$mediopago,$montopagado,$montodevuelto) = explode("|",$explode[$cont]);

        if(COUNT($explode) == 1) {

            $this->SetX(2);
            $this->SetFont($TipoLetra,'B',9);
            $this->CellFitSpace(20,4,"PAGO",0,0,'L');
            $this->Cell(50,4,mb_convert_encoding($mediopago, 'ISO-8859-1', 'UTF-8'),0,1,'R');

            $this->SetX(2);
            $this->SetFont($TipoLetra,'',9);
            $this->CellFitSpace(30,4,"SUMA DE SUS PAGOS",0,0,'L');
            $this->Cell(40,4,$simbolo.number_format($montopagado, 2, '.', ','),0,1,'R');

            $this->SetX(2);
            $this->SetFont($TipoLetra,'',9);
            $this->CellFitSpace(30,4,"SU VUELTO",0,0,'L');
            $this->Cell(40,4,$simbolo.number_format($montodevuelto, 2, '.', ','),0,1,'R');

        } else {

            $this->SetX(2);
            $this->SetFont($TipoLetra,'B',9);
            $this->CellFitSpace(20,4,"PAGO  #".$contador++,0,0,'L');
            $this->Cell(50,4,mb_convert_encoding($mediopago, 'ISO-8859-1', 'UTF-8'),0,1,'R');

            $this->SetX(2);
            $this->SetFont($TipoLetra,'',9);
            $this->CellFitSpace(30,4,"SUMA DE SUS PAGOS",0,0,'L');
            $this->Cell(40,4,$simbolo.number_format($montopagado, 2, '.', ','),0,1,'R');

        }

    endfor;

    }

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(70,4,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    ############# MUESTRO ABONOS Y PENDIENTE #############
    if($reg[0]['tipopago']=="CREDITO"){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"ABONADO",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"PENDIENTE",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"VENCIMIENTO",0,0,'L');
    $this->Cell(40,4,date("d/m/Y",strtotime($reg[0]["fechavencecredito"])),0,1,'R');
    }
    ############# MUESTRO ABONOS Y PENDIENTE #############

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(30,4,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(40,4,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln();

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',6).portales($GLOBALS['texto_global']),0,'J');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont($TipoLetra,'BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION NOTA DE VENTA (8MM) ##############################

########################## FUNCION NOTA DE VENTA (5MM) ##############################
function NotaVenta_5()
{  
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->VentasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 8, 3, 30, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->Ln(2);
    $this->SetX(2);
    $this->MultiCell(42,4,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? " " : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 4, "NOTA DE VENTA", 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(42,3,$reg[0]['codfactura'], 0, 1, 'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"CAJA N�",0,0,'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,"CAJERO:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechaventa'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,utf8_decode("A CONSUMIDOR FINAL"), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".$reg[0]['documento3']).": ".$reg[0]['dnicliente'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).utf8_decode($reg[0]['nomcliente']),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).utf8_decode($reg[0]['direccliente'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2'])),0,'L');
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra       = new Login();
    $detalle   = $tra->VerDetallesVentas();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    if($detalle[$i]["descripcion"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["descripcion"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    if($detalle[$i]["imei"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(42,3,"N.DE IMEI: ".mb_convert_encoding($detalle[$i]["imei"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',7);
    $this->CellFitSpace(21,3,"TIPO PAGO",0,0,'L');
    $this->Cell(21,3,mb_convert_encoding($reg[0]['tipopago'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"DESCONTADO %",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXONERADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXENTO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',7);
    $this->CellFitSpace(21,3,"TOTAL A PAGAR",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    if($reg[0]['tipopago'] == "CONTADO"){ 

    $explode = explode("<br>",$reg[0]['detalles_pagos']);
    $contador = 1;
    for($cont=0; $cont<COUNT($explode); $cont++):
    list($codmediopago,$mediopago,$montopagado,$montodevuelto) = explode("|",$explode[$cont]);

        if(COUNT($explode) == 1) {

            $this->SetX(2);
            $this->SetFont($TipoLetra,'B',6);
            $this->CellFitSpace(21,3,"PAGO",0,0,'L');
            $this->Cell(21,3,mb_convert_encoding($mediopago, 'ISO-8859-1', 'UTF-8'),0,1,'R');

            $this->SetX(2);
            $this->SetFont($TipoLetra,'',6);
            $this->CellFitSpace(21,3,"SUMA DE SUS PAGOS",0,0,'L');
            $this->Cell(21,3,$simbolo.number_format($montopagado, 2, '.', ','),0,1,'R');

            $this->SetX(2);
            $this->SetFont($TipoLetra,'',6);
            $this->CellFitSpace(21,3,"SU VUELTO",0,0,'L');
            $this->Cell(21,3,$simbolo.number_format($montodevuelto, 2, '.', ','),0,1,'R');

        } else {

            $this->SetX(2);
            $this->SetFont($TipoLetra,'B',6);
            $this->CellFitSpace(21,3,"PAGO  #".$contador++,0,0,'L');
            $this->Cell(21,3,mb_convert_encoding($mediopago, 'ISO-8859-1', 'UTF-8'),0,1,'R');

            $this->SetX(2);
            $this->SetFont($TipoLetra,'',6);
            $this->CellFitSpace(21,3,"SUMA DE SUS PAGOS",0,0,'L');
            $this->Cell(21,3,$simbolo.number_format($montopagado, 2, '.', ','),0,1,'R');
        }
    endfor;

    }

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(42,3,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    ############# MUESTRO ABONOS Y PENDIENTE #############
    if($reg[0]['tipopago']=="CREDITO"){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"ABONADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"PENDIENTE",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"VENCIMIENTO",0,0,'L');
    $this->Cell(21,3,date("d/m/Y",strtotime($reg[0]["fechavencecredito"])),0,1,'R');
    }
    ############# MUESTRO ABONOS Y PENDIENTE #############

    if($reg[0]['observaciones']!=""){
    ########################### OBSERVACIONES #############################
    $this->Ln(2);  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->MultiCell(70,3,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
    $this->Ln(2);
    ########################### OBSERVACIONES #############################    
    }

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(21,3,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',6).portales($GLOBALS['texto_global']),0,'J');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont($TipoLetra,'BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION NOTA DE VENTA (5MM) ##############################

########################## FUNCION BOLETA VENTA (A4) #############################
function BoletaVenta_a4()
{   
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->VentasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
       $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
       $this->Image($logo, 12, 10, 40, 12, "PNG");
    }

    //######################### BLOQUE DATOS DE SUCURSAL #############################
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 24, 100, 40, '1.5', "");
    
    $this->SetFont($TipoLetra,'BI',14);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(7, 25);
    $this->CellFitSpace(100, 5,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1); //Membrete Nro 1

    $this->SetFont($TipoLetra,'B',10);
    if($reg[0]['id_provincia']!='0'){
    $this->SetX(7);
    $this->CellFitSpace(100, 5,mb_convert_encoding($provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento']." "), 'ISO-8859-1', 'UTF-8'), 0,1);
    }

    $this->SetX(7);
    $this->MultiCell(100,5,$this->SetFont($TipoLetra,'B',10).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(7);
    $this->CellFitSpace(100, 5,'N.ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 5,'N.TLF: '.$reg[0]['tlfsucursal'], 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 5,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'), 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 5,'OBLIGADO A LLEVAR CONTABILIDAD: '.$reg[0]['llevacontabilidad'], 0, 0); 
    //######################### BLOQUE DATOS DE SUCURSAL #############################

    //######################### BLOQUE DATOS DE FACTURA #############################
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(110, 8, 93, 56, '1.5', "");

    $this->SetFont($TipoLetra,'B',12);
    $this->SetXY(110, 9);
    $this->Cell(93, 5, 'BOLETA DE VENTA', 0, 0, 'C');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(110, 14);
    $this->Cell(38, 5, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8').":"), 0, 0);
    $this->SetXY(148, 14);
    $this->CellFitSpace(55, 5,$reg[0]['cuitsucursal'], 0, 0);

    $this->SetXY(110, 19);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5, 'N.DE BOLETA:', 0, 0);
    $this->SetXY(148, 19);
    $this->CellFitSpace(55, 5,$reg[0]['codfactura'], 0, 0);

    $this->SetXY(110, 24);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5, 'N.DE SERIE:', 0, 0);
    $this->SetXY(148, 24);
    $this->CellFitSpace(55, 5,$reg[0]['codserie'], 0, 0);

    $this->SetXY(110, 29);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(93, 5,'N.DE AUTORIZACI.', 0, 0);
    $this->SetXY(110, 34);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(93, 5,$reg[0]['codautorizacion'], 0, 0);

    $this->SetXY(110, 39);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(93, 5,"FECHA DE AUTORIZACI.:", 0, 0);

    $this->SetXY(110, 44);
    $this->CellFitSpace(93, 5,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d/m/Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(110, 49);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(148, 49);
    $this->CellFitSpace(55, 5,date("d/m/Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);

    $this->SetXY(110, 54);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,'AMBIENTE: ', 0, 0);
    $this->SetXY(148, 54);
    $this->Cell(55, 5,'PRODUCCI.', 0, 0);

    $this->SetXY(110, 59);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,'EMISI.: ', 0, 0);
    $this->SetXY(148, 59);
    $this->Cell(55, 5,'NORMAL', 0, 0);
    //######################### BLOQUE DATOS DE FACTURA #############################

    //######################### BLOQUE DATOS DE CLIENTE #############################
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(7, 65, 196, 20, '1.5', "");
    $this->SetFont($TipoLetra,'B',6);

    $this->SetXY(7,65);
    $this->SetFont($TipoLetra,'B',11);
    $this->CellFitSpace(196, 5,'RAZ. SOCIAL: '.mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $this->SetX(7);
    $this->CellFitSpace(98, 5,"N.".$documento = ($reg[0]['documcliente'] == "" ? "DOC: " : mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ").$dni = ($reg[0]['dnicliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['dnicliente']), 0, 0);

    $this->CellFitSpace(98, 5,"N.TLF: ".$phone = ($reg[0]['tlfcliente'] == "" ? "**********" : $reg[0]['tlfcliente']), 0, 1);
    
    $this->SetX(7);
    $this->CellFitSpace(98, 5,"GIRO: ".mb_convert_encoding($reg[0]['girocliente'] == "" ? "**********" : $reg[0]['girocliente'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    $this->CellFitSpace(98, 5,"CORREO: ".mb_convert_encoding($var = ($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 'ISO-8859-1', 'UTF-8'), 0, 1);

    $this->SetX(7);
    $this->CellFitSpace(196, 5,"DIRECCI.: ".mb_convert_encoding($reg[0]['direccliente'] == "" ? "**********" : $reg[0]['direccliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    //######################### BLOQUE DATOS DE CLIENTE #############################

    //######################### BLOQUE DATOS DE PRODUCTOS #############################
    $this->Ln(3);
    $this->SetX(7);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,5,'N�',1,0,'C', True);
    $this->Cell(106,5,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(25,5,'CANTIDAD',1,0,'C', True);
    $this->Cell(25,5,'PRECIO',1,0,'C', True);
    $this->Cell(30,5,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,106,25,25,30));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(7);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,"",9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array(
    $a++,
    utf8_decode($detalle[$i]["producto"]),
    number_format($detalle[$i]['cantidad'], 2, '.', ','),
    utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),
    number_format($detalle[$i]['valorneto'], 2, '.', ',')
));
    }
    //######################### BLOQUE DATOS DE PRODUCTOS #############################

    //######################### BLOQUE DATOS DE TOTALES #############################
    $this->Ln(2);
    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'INFORMACI. ADICIONAL',1,0,'C');
    $this->Cell(2,4,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(40,5,"DESCONTADO %:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]['totaldescuento'], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'N.DE CAJA: '.mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"SUBTOTAL:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'CAJERO(A): '.mb_convert_encoding($cajero = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nombres']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,'EXONERADO:',1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'FECHA DE EMISI.: '.date("d/m/Y H:i:s"),1,0,'L');

    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"EXENTO:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'CONDICI. DE PAGO: '.mb_convert_encoding($reg[0]['tipopago'], 'ISO-8859-1', 'UTF-8')."          ".$vencimiento = ($reg[0]['tipopago'] == 'CONTADO' ? "" : "VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito']))),1,0,'L');

    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['detalles_medios'] : "VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])))),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(110,5,'',0,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(40,5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(7);
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(196,8,$this->SetFont($TipoLetra,'B',10).'MONTO EN LETRAS: '.mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,'J');
       $this->Ln();
    //######################### BLOQUE DATOS DE TOTALES #############################

    $this->SetX(7);
    $this->MultiCell(196,3,$this->SetFont('Courier','B',7).portales($GLOBALS['texto_global']),0,'J');
    $this->Ln(3);
}
########################## FUNCION BOLETA VENTA (A4) #############################

########################## FUNCION FACTURA VENTA (A4) #############################
function FacturaVenta_a4()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->VentasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    
    // Cambio a Arial para un look más moderno y limpio
    $TipoLetra = "Arial";
    
    // Colores minimalistas
    $colorPrimario = array(33, 37, 41);     // Gris oscuro (#212529)
    $colorSecundario = array(108, 117, 125); // Gris medio (#6c757d)
    $colorFondo = array(248, 249, 250);      // Gris muy claro (#f8f9fa)
    $colorAcento = array(13, 110, 253);      // Azul moderno (#0d6efd)
    
    //######################### ENCABEZADO MINIMALISTA #############################
    // Título principal
    $this->SetFont($TipoLetra,'',24);
    $this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $this->SetXY(15, 15);
    $this->Cell(0, 10, 'FACTURA', 0, 1, 'L');
    
    // Línea sutil de separación
    $this->SetDrawColor(230, 230, 230);
    $this->SetLineWidth(0.5);
    $this->Line(15, 26, 195, 26);
    
    //######################### INFORMACIÓN DE LA FACTURA #############################
    // Número de factura destacado
    $this->SetFont($TipoLetra,'B',11);
    $this->SetTextColor($colorAcento[0], $colorAcento[1], $colorAcento[2]);
    $this->SetXY(15, 30);
    $this->Cell(60, 6, $reg[0]['codfactura'], 0, 0, 'L');
    
    // Fecha
    $this->SetFont($TipoLetra,'',10);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $this->SetXY(140, 30);
    $this->Cell(55, 6, date("d/m/Y", strtotime($reg[0]['fechaventa'])), 0, 1, 'R');
    
    //######################### DATOS DE LA EMPRESA #############################
    /*
    $this->SetXY(15, 40);
    $this->SetFont($TipoLetra,'B',11);
    $this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $this->Cell(90, 6, mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    $this->SetX(15);
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    
    // Información de la empresa en columna
    $this->SetX(15);
    $this->Cell(90, 5, mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    if($reg[0]['id_provincia']!='0'){
        $this->SetX(15);
        $ubicacion = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']." ")
                    .($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento']);
        $this->Cell(90, 5, mb_convert_encoding($ubicacion, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    }
    
    $this->SetX(15);
    $this->Cell(90, 5, 'Tel: '.$reg[0]['tlfsucursal'], 0, 1, 'L');
    
    $this->SetX(15);
    $this->Cell(90, 5, mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    // Información fiscal en la derecha
    $this->SetXY(120, 45);
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    
    $doc_label = ($reg[0]['documsucursal'] == '0' ? "REG" : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8'));
    $this->Cell(35, 5, $doc_label.':', 0, 0, 'L');
    $this->SetFont($TipoLetra,'',9);
    $this->Cell(40, 5, mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    $this->SetX(120);
    $this->SetFont($TipoLetra,'',9);
    $this->Cell(35, 5, 'Serie:', 0, 0, 'L');
    $this->Cell(40, 5, $reg[0]['codserie'], 0, 1, 'L');
    
    $this->SetX(120);
   $this->Cell(35, 5, '', 0, 0, 'L');
    $this->SetFont($TipoLetra,'',8);
    $this->Cell(40, 5,'', 0, 1, 'L');
    */
    //######################### DATOS DEL CLIENTE #############################
    $this->Ln(2);
    
    // Título de sección con línea
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $this->SetX(15);
    $this->Cell(30, 6, 'FACTURAR A', 0, 0, 'L');
    
    // Línea decorativa
    $this->SetDrawColor(230, 230, 230);
    $this->Line(45, $this->GetY()+3, 195, $this->GetY()+3);
    $this->Ln(8);
    
    // Información del cliente
    $this->SetX(15);
    $this->SetFont($TipoLetra,'B',11);
    $this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    $this->Cell(180, 6, mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    
    // Documento del cliente
    $this->SetX(15);
    $doc_cliente = ($reg[0]['documcliente'] == "" ? "DOC" : mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8'));
    $dni_cliente = ($reg[0]['dnicliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['dnicliente']);
    $this->Cell(90, 5, $doc_cliente.': '.$dni_cliente, 0, 0, 'L');
    
    // Teléfono
    $telefono = ($reg[0]['tlfcliente'] == "" ? "Sin teléfono" : $reg[0]['tlfcliente']);
    $this->Cell(90, 5, 'Tel: '.$telefono, 0, 1, 'L');
    
    // Dirección
    $this->SetX(15);
    $direccion = ($reg[0]['direccliente'] == "" ? "Sin dirección" : $reg[0]['direccliente']);
    $this->Cell(180, 5, mb_convert_encoding($direccion, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    // Email
    $this->SetX(15);
    $email = ($reg[0]['emailcliente'] == '' ? "Sin email" : $reg[0]['emailcliente']);
    $this->Cell(180, 5, mb_convert_encoding($email, 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    //######################### TABLA DE PRODUCTOS - MINIMALISTA #############################
    $this->Ln(8);
    
    // Encabezados de tabla con fondo sutil
    $this->SetX(15);
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $this->SetFillColor($colorFondo[0], $colorFondo[1], $colorFondo[2]);
    $this->SetDrawColor(255, 255, 255);
    
    $this->Cell(10, 8, '#', 0, 0, 'C', true);
    $this->Cell(95, 8, 'DESCRIPCION', 0, 0, 'L', true);
    $this->Cell(25, 8, 'CANTIDAD', 0, 0, 'C', true);
    $this->Cell(25, 8, 'PRECIO', 0, 0, 'R', true);
    $this->Cell(25, 8, 'TOTAL', 0, 1, 'R', true);
    
    // Línea bajo encabezados
    $this->SetDrawColor(230, 230, 230);
    $this->Line(15, $this->GetY(), 195, $this->GetY());
    
    // Detalles de productos
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;
    
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
    
    $a = 1;
    for($i = 0; $i < sizeof($detalle); $i++){ 
        $cantidad += $detalle[$i]['cantidad'];
        $valortotal = $detalle[$i]["precioventa"] * $detalle[$i]["cantidad"];
        $SubTotal += $detalle[$i]['valorneto'];
        
        $this->SetX(15);
        
        // Alternar color de fondo para mejor legibilidad
        if($i % 2 == 0) {
            $this->SetFillColor(252, 252, 252);
        } else {
            $this->SetFillColor(255, 255, 255);
        }
        
        $this->Cell(10, 7, $a++, 0, 0, 'C', true);
        $this->Cell(95, 7, utf8_decode($detalle[$i]["producto"]), 0, 0, 'L', true);
        $this->Cell(25, 7, number_format($detalle[$i]['cantidad'], 2, '.', ','), 0, 0, 'C', true);
        $this->Cell(25, 7, $simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','), 0, 0, 'R', true);
        $this->Cell(25, 7, $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','), 0, 1, 'R', true);
    }
    
    // Línea de separación antes de totales
    $this->SetDrawColor(230, 230, 230);
    $this->Line(15, $this->GetY()+2, 195, $this->GetY()+2);
    
    //######################### TOTALES - DISEÑO LIMPIO #############################
    
    //######################### INFORMACIÓN DE PAGO #############################
    $this->Ln(5);
    
    // Cuadro de información de pago con borde sutil
    //========================  CONTENEDOR PRINCIPAL  ========================//
$this->SetDrawColor(230, 230, 230);
$this->SetFillColor($colorFondo[0], $colorFondo[1], $colorFondo[2]);
$this->RoundedRect(15, $this->GetY(), 180, 25, 2, 'DF');

// Ajuste de posición inicial
$this->SetY($this->GetY() + 3);
$this->SetX(20);

// Fuente y color base
$this->SetFont($TipoLetra, '', 9);
$this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);

//========================  INFORMACIÓN DE PAGO  ========================//

//========================  INFORMACION DE PAGO Y SUBTOTAL  ========================//

$this->SetY($this->GetY() + 3);
$this->SetFont($TipoLetra, '', 9);
$this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);

// Condicion de pago (columna izquierda)
$this->SetX(20);
$this->Cell(
    85,
    5,
    'Condicion de pago: ' . $reg[0]['tipopago'],
    0,
    0,
    'L'
);

// Subtotal (columna derecha, misma linea)
$this->SetX(120);
$this->Cell(45, 5, 'Subtotal:', 0, 0, 'L');
$this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
$this->Cell(
    30,
    5,
    $simbolo . number_format($reg[0]["subtotal"], 2, '.', ','),
    0,
    1,
    'R'
);

//========================  VENCIMIENTO Y DESCUENTO/IVA  ========================//

$this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);

// Vence
$this->SetX(20);
if ($reg[0]['tipopago'] == 'CONTADO') {
    $this->Cell(85, 5, $reg[0]['detalles_medios'], 0, 0, 'L');
} else {
    $this->Cell(
        85,
        5,
        'Vence: ' . date("d/m/Y", strtotime($reg[0]['fechavencecredito'])),
        0,
        0,
        'L'
    );
}

// IVA (derecha)
$this->SetX(120);
$this->Cell(
    45,
    5,
    'IVA (' . number_format($reg[0]["iva"], 0, '.', '') . '%):',
    0,
    0,
    'L'
);
$this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
$this->Cell(
    30,
    5,
    $simbolo . number_format($reg[0]["totaliva"], 2, '.', ','),
    0,
    1,
    'R'
);

//========================  EMITIDO Y TOTAL  ========================//

$this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);

// Emitido (izquierda)
$this->SetX(20);
$this->Cell(85, 5, 'Emitido: ' . date("d/m/Y H:i:s"), 0, 0, 'L');

// Total (derecha destacado)
$this->SetX(120);
$this->SetFont($TipoLetra, 'B', 11);
$this->SetTextColor($colorPrimario[0], $colorPrimario[1], $colorPrimario[2]);
$this->Cell(45, 8, 'TOTAL:', 0, 0, 'L');

$this->SetTextColor($colorAcento[0], $colorAcento[1], $colorAcento[2]);
$this->Cell(
    30,
    8,
    $simbolo . number_format($reg[0]["totalpago"], 2, '.', ','),
    0,
    1,
    'R'
);

//========================  MONTO EN LETRAS  ========================//

$this->Ln(3);
$this->SetX(20);
$this->SetFont($TipoLetra, '', 8);
$this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);

$this->Cell(
    180,
    5,
    'Monto en letras: ' . numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')),
    0,
    1,
    'L'
);


    
    //######################### INFORMACIÓN DE PAGO #############################
    $this->Ln(5);
    /*
    
    // Cuadro de información de pago con borde sutil
    $this->SetDrawColor(230, 230, 230);
    $this->SetFillColor($colorFondo[0], $colorFondo[1], $colorFondo[2]);
    $this->RoundedRect(15, $this->GetY(), 180, 25, 2, 'DF');
    
    $this->SetY($this->GetY() + 3);
    $this->SetX(20);
    $this->SetFont($TipoLetra,'',9);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    
    // Información de pago en dos columnas
    $this->Cell(85, 5, 'Condicion de pago: '.mb_convert_encoding($reg[0]['tipopago'], 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
    $this->Cell(85, 5, 'Cajero: '.mb_convert_encoding($cajero = ($reg[0]['codcaja'] == "0" ? "Sin asignar" : $reg[0]['nombres']), 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    $this->SetX(20);
    if($reg[0]['tipopago'] == 'CONTADO') {
        $this->Cell(85, 5, utf8_decode($reg[0]['detalles_medios']), 0, 0, 'L');
    } else {
        $this->Cell(85, 5, 'Vence: '.date("d/m/Y", strtotime($reg[0]['fechavencecredito'])), 0, 0, 'L');
    }
    $this->Cell(85, 5, 'Caja: '.mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "Sin asignar" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
    
    $this->SetX(20);
    $this->Cell(170, 5, 'Emitido: '.date("d/m/Y H:i:s"), 0, 1, 'L');
    */
    
    //######################### PIE DE PÁGINA #############################
    $this->Ln(10);
    
    // Mensaje final centrado
    $this->SetFont($TipoLetra,'I',8);
    $this->SetTextColor($colorSecundario[0], $colorSecundario[1], $colorSecundario[2]);
    $this->SetX(15);
    $this->Cell(180, 5, 'Gracias por su preferencia', 0, 1, 'C');
} 


function FacturaVenta_a4_v1()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->VentasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";
/*
    //Logo
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
       $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
       $this->Image($logo, 12, 10, 40, 12, "PNG");
    }
*/
    //######################### BLOQUE DATOS DE SUCURSAL #############################
/*
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 24, 100, 40, '1.5', "");
    
    $this->SetFont($TipoLetra,'BI',14);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(7, 25);
    $this->CellFitSpace(100, 5,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1); //Membrete Nro 1

    $this->SetFont($TipoLetra,'B',10);
    if($reg[0]['id_provincia']!='0'){
    $this->SetX(7);
    $this->CellFitSpace(100, 5,mb_convert_encoding($provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento']." "), 'ISO-8859-1', 'UTF-8'), 0,1);
    }

    $this->SetX(7);
    $this->MultiCell(100,5,$this->SetFont($TipoLetra,'B',10).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(7);
    $this->CellFitSpace(100, 5,'N.ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 5,'N.TLF: '.$reg[0]['tlfsucursal'], 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 5,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'), 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 5,'OBLIGADO A LLEVAR CONTABILIDAD: '.$reg[0]['llevacontabilidad'], 0, 0); 
    */
    //######################### BLOQUE DATOS DE SUCURSAL #############################

    //######################### BLOQUE DATOS DE FACTURA #############################
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(110, 8, 93, 56, '1.5', "");

    $this->SetFont($TipoLetra,'B',12);
    $this->SetXY(110, 9);
    $this->Cell(93, 5, 'FACTURA DE VENTA', 0, 0, 'C');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(110, 14);
    $this->Cell(38, 5, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8').":"), 0, 0);
    $this->SetXY(148, 14);
    $this->CellFitSpace(55, 5,mb_convert_encoding($reg[0]['cuitsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 0);

    $this->SetXY(110, 19);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5, 'N.DE FACTURA:', 0, 0);
    $this->SetXY(148, 19);
    $this->CellFitSpace(55, 5,$reg[0]['codfactura'], 0, 0);

    $this->SetXY(110, 24);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5, 'N.DE SERIE:', 0, 0);
    $this->SetXY(148, 24);
    $this->CellFitSpace(55, 5,$reg[0]['codserie'], 0, 0);

    $this->SetXY(110, 29);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(93, 5,'N.DE AUTORIZACI.', 0, 0);
    $this->SetXY(110, 34);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(93, 5,$reg[0]['codautorizacion'], 0, 0);

    $this->SetXY(110, 39);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(93, 5,"FECHA DE AUTORIZACI.:", 0, 0);

    $this->SetXY(110, 44);
    $this->CellFitSpace(93, 5,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d/m/Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(110, 49);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(148, 49);
    $this->CellFitSpace(55, 5,date("d/m/Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);

    $this->SetXY(110, 54);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,'AMBIENTE: ', 0, 0);
    $this->SetXY(148, 54);
    $this->Cell(55, 5,'PRODUCCI.', 0, 0);

    $this->SetXY(110, 59);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,'EMISI.: ', 0, 0);
    $this->SetXY(148, 59);
    $this->Cell(55, 5,'NORMAL', 0, 0);
    //######################### BLOQUE DATOS DE FACTURA #############################

    //######################### BLOQUE DATOS DE CLIENTE #############################
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(7, 65, 196, 20, '1.5', "");
    $this->SetFont($TipoLetra,'B',6);

    $this->SetXY(7,65);
    $this->SetFont($TipoLetra,'B',11);
    $this->CellFitSpace(196, 5,'RAZ. SOCIAL: '.mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $this->SetX(7);
    $this->CellFitSpace(98, 5,"N.".$documento = ($reg[0]['documcliente'] == "" ? "DOC: " : mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ").$dni = ($reg[0]['dnicliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['dnicliente']), 0, 0);

    $this->CellFitSpace(98, 5,"N.TLF: ".$phone = ($reg[0]['tlfcliente'] == "" ? "**********" : $reg[0]['tlfcliente']), 0, 1);
    
    $this->SetX(7);
    $this->CellFitSpace(98, 5,"GIRO: ".mb_convert_encoding($reg[0]['girocliente'] == "" ? "**********" : $reg[0]['girocliente'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    $this->CellFitSpace(98, 5,"CORREO: ".mb_convert_encoding($var = ($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 'ISO-8859-1', 'UTF-8'), 0, 1);

    $this->SetX(7);
    $this->CellFitSpace(196, 5,"DIRECCI.: ".mb_convert_encoding($reg[0]['direccliente'] == "" ? "**********" : $reg[0]['direccliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    //######################### BLOQUE DATOS DE CLIENTE #############################

    //######################### BLOQUE DATOS DE PRODUCTOS #############################
    $this->Ln(2);
    $this->SetX(7);
    $this->SetFont($TipoLetra,'B',11);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,5,'N�',1,0,'C', True);
    $this->Cell(116,5,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,5,'CANTIDAD',1,0,'C', True);
    $this->Cell(20,5,'PRECIO',1,0,'C', True);
    $this->Cell(30,5,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,116,20,20,30));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad   += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal   += $detalle[$i]['valorneto'];

    $this->SetX(7);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,"",9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array(
    $a++,
    utf8_decode($detalle[$i]["producto"]),
    number_format($detalle[$i]['cantidad'], 2, '.', ','),
    utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),
    number_format($detalle[$i]['valorneto'], 2, '.', ',')
));

    }
    //######################### BLOQUE DATOS DE PRODUCTOS #############################
     
    //######################### BLOQUE DATOS DE TOTALES #############################
    $this->Ln(2);
    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'INFORMACI. ADICIONAL',1,0,'C');
    $this->Cell(2,4,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(40,5,"DESCONTADO %:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]['totaldescuento'], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'N.DE CAJA: '.mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"SUBTOTAL:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'CAJERO(A): '.mb_convert_encoding($cajero = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nombres']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,'EXONERADO:',1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'FECHA DE EMISI.: '.date("d/m/Y H:i:s"),1,0,'L');

    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"EXENTO:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'CONDICI. DE PAGO: '.mb_convert_encoding($reg[0]['tipopago'], 'ISO-8859-1', 'UTF-8')."          ".$vencimiento = ($reg[0]['tipopago'] == 'CONTADO' ? "" : "VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito']))),1,0,'L');

    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['detalles_medios'] : "VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])))),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(110,5,'',0,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(40,5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(7);
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(196,8,$this->SetFont($TipoLetra,'B',10).'MONTO EN LETRAS: '.mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,'J');
       $this->Ln();
    //######################### BLOQUE DATOS DE TOTALES #############################
}  
########################## FUNCION FACTURA VENTA (A4) ##############################

########################## FUNCION GUIA VENTA ##############################
function GuiaVenta()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->VentasPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    ######################### BLOQUE N.1 ######################### 
    //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 245, 24, '1.5', '');
    
    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(12, 12);
    $this->Cell(20, 5, mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 16);
    $this->Cell(20, 5, 'DIREC. MATRIZ:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(47, 16);
    $this->Cell(20, 5,mb_convert_encoding($provincia = ($reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'), 0 , 0);
    
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 20);
    $this->Cell(20, 5, 'DIREC. SUCURSAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(52, 20);
    $this->Cell(20, 5,mb_convert_encoding($provincia = ($reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'), 0 , 0);
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 24);
    $this->Cell(20, 5, 'CONTRIBUYENTE ESPECIAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(65, 24);
    $this->Cell(20, 5,mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 28);
    $this->Cell(20, 5, 'OBLIGADO A LLEVAR CONTABILIDAD:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(82, 28);
    $this->Cell(20, 5,$reg[0]['llevacontabilidad'], 0 , 0);
    ######################### BLOQUE N.1 ######################### 

    ############################### BLOQUE N.2 ##################################### 
    //Bloque de datos de chofer
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 36, 245, 24, '1.5', '');

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 37);
    $this->Cell(20, 5, 'IDENTIF (TRANSPORTISTA):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 37);
    $this->Cell(20, 5,"", 0 , 0);

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 41);
    $this->Cell(90, 5, 'RAZ. SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 41);
    $this->Cell(90, 5,"", 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 45);
    $this->Cell(90, 5, 'PLACA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 45);
    $this->Cell(90, 5,"", 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 45);
    $this->Cell(20, 5, 'N.DE BULTOS :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 45);
    $this->Cell(20, 5,"", 0 , 0);

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 49);
    $this->Cell(20, 5, 'PUNTO DE PARTIDA:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 49);
    $this->Cell(20, 5,mb_convert_encoding($provincia = ($reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 53);
    $this->Cell(20, 5, 'FECHA INICIO TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 53);
    $this->Cell(20, 5,"", 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 53);
    $this->Cell(20, 5, 'FECHA FIN TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(220, 53);
    $this->Cell(20, 5,"", 0 , 0);
    ############################### BLOQUE N.2 ##################################### 

    ############################### BLOQUE N.3 ##################################### 
    //Bloque de datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 62, 245, 27, '1.5', '');

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 63);
    $this->Cell(20, 5, 'COMPROBANTE DE VENTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 63);
    $this->Cell(20, 5,$reg[0]['tipodocumento']." ".$reg[0]['codfactura'], 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 63);
    $this->Cell(20, 5, 'FECHA EMISI. :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 63);
    $this->Cell(20, 5,date("d/m/Y"), 0 , 0);

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 67);
    $this->Cell(70, 5, 'N�MERO DE AUTORIZACI.:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 67);
    $this->Cell(75, 5,$reg[0]['codautorizacion'], 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 67);
    $this->Cell(20, 5, 'RUTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 67);
    $this->Cell(20, 5,"", 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 71);
    $this->Cell(90, 5, 'MOTIVO DE TRASLADO:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 71);
    $this->Cell(90, 5,"", 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 71);
    $this->Cell(20, 5, 'CIUDAD:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 71);
    $this->Cell(20, 5,"", 0 , 0);

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 75);
    $this->Cell(20, 5, 'RAZ. SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 75);
    $this->Cell(20, 5,$reg[0]['nomencargado'], 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 75);
    $this->Cell(20, 5, 'IDENTIF. (DESTINATARIO):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(227, 75);
    $this->Cell(20, 5,mb_convert_encoding($reg[0]['dniencargado'], 'ISO-8859-1', 'UTF-8'), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 79);
    $this->Cell(20, 5, 'ESTABLECIMIENTO:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 79);
    $this->Cell(20, 5,"", 0 , 0);

   //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 83);
    $this->Cell(20, 5, 'DESTINO (PUNTO DE LLEGADA):', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 83);
    $this->Cell(20, 5,"", 0 , 0);
    ############################### BLOQUE N.3 #####################################

    ############################### BLOQUE N.4 ##################################### 
    //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(257, 10, 88, 79, '1.5', '');
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 16);
    $this->Cell(20, 5, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8').":"), 0 , 0);
    $this->SetFont('courier','',14);
    $this->SetXY(295, 16);
    $this->Cell(20, 5,$reg[0]['cuitsucursal'], 0 , 0);

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',18);
    $this->SetXY(258, 28);
    $this->Cell(20, 5,"GUIA DE REMISI.", 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 38);
    $this->Cell(20, 5, 'N�:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(268, 38);
    $this->Cell(20, 5,$reg[0]['codfactura'], 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 48);
    $this->Cell(20, 5, 'AMBIENTE:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 48);
    $this->Cell(20, 5,"PRODUCCI.", 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 54);
    $this->Cell(20, 5, 'EMISI.:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 54);
    $this->Cell(20, 5,"NORMAL", 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 66);
    $this->Cell(20, 5, 'CLAVE ACCESO - N.DE AUTORIZ:', 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 76);
    $this->Codabar(260,75,$reg[0]['codautorizacion']);
    $this->Ln(10);
    ############################### BLOQUE N.4 ##################################### 

    ############################### BLOQUE N.5 ##################################### 
    //Bloque Cuadro de Detalles de Productos
    $this->Ln(6);
    $this->SetFont('courier','B',9);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,0,'C', True);
    $this->Cell(30, 8,"PRECIO/UNIT", 1, 0, 'C', True);
    $this->Cell(30, 8,"VALOR/TOTAL", 1, 0, 'C', True);
    $this->Cell(20, 8,"DESC %", 1, 0, 'C', True);
    $this->Cell(20, 8,"IMPUESTO", 1, 0, 'C', True);
    $this->Cell(30, 8,"VALOR/NETO", 1, 0, 'C', True);
    $this->Cell(35,8,'TIPO',1,1,'C', True);
    ############################### BLOQUE N.5 #####################################

    ############################### BLOQUE N.6 #####################################
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,30,70,20,20,20,30,30,20,20,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(10);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->SetFillColor(255, 255, 255); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->RowFacture(array($a++,
        $detalle[$i]["codproducto"],
        mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : "").$imei = ($detalle[$i]["imei"] != "" ? "\nIMEI: ".$detalle[$i]["imei"] : ""), 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($detalle[$i]["codmarca"] == '0' ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),
        mb_convert_encoding($modelo = ($detalle[$i]["codmodelo"] == '0' ? "*********" : $detalle[$i]["nommodelo"]), 'ISO-8859-1', 'UTF-8'),
        number_format($detalle[$i]['cantidad'], 2, '.', ','),
        $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','),
        $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','),
        number_format($detalle[$i]['descproducto'], 2, '.', ','),
        $ivaproducto = ($detalle[$i]["ivaproducto"] != '0.00' ? number_format($detalle[$i]["ivaproducto"] , 2, '.', ',')."%" : "(E)"),
        $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','),
        mb_convert_encoding($modelo = ($detalle[$i]["codpresentacion"] == '0' ? "*********" : $detalle[$i]["nompresentacion"]), 'ISO-8859-1', 'UTF-8')));
    }
    ############################### BLOQUE N.6 #####################################

    ########################### BLOQUE N.6 #############################
    $this->Ln();
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',14);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'INFORMACI. ADICIONAL',1,0,'C', True);
    $this->Cell(5,5,"",0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->CellFitSpace(50,5,'DESCONTADO %',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]['totaldescuento'], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,'SUBTOTAL:',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'TIPO DE DOCUMENTO: GUIA DE REMISI.',1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,'EXONERADO:',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),1,0,'R');
    $this->Ln();

    if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] >= date("Y-m-d")) {
    $estado = $reg[0]['statusventa'];
    $dias_vencidos = "0";
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) { 
    $estado = "VENCIDA";
    $dias_vencidos = Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']);
    }

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'TIPO DE PAGO: '.mb_convert_encoding($reg[0]['tipopago'], 'ISO-8859-1', 'UTF-8')." ".$vencimiento = ($reg[0]['tipopago'] == "CREDITO" ? " | FECHA VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])) : "")." ".$dias = ($reg[0]['tipopago'] == "CREDITO" ? " | DIAS VENCIDOS: ".$dias_vencidos : ""),1,0,'L');

    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,"EXENTO:",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(220,5,'FORMA DE PAGO: '.mb_convert_encoding($variable = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['detalles_medios'] : $reg[0]['formacompra']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)

    $this->CellFitSpace(220,5,'REALIZADO: '.mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->CellFitSpace(50,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(220,5,'FECHA DE EMISI.: '.date("d-m-Y"),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->Cell(50,5,'IMPORTE TOTAL::',1,0,'L', True);
    $this->CellFitSpace(60,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(220,5,'HORA DE EMISI.: '.date("H:i:s"),1,0,'L');
    $this->Cell(5,5,"",0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->Cell(50,5,' ',1,0,'L', True);
    $this->CellFitSpace(60,5," ",1,0,'R');
    $this->Ln(6);

    if($reg[0]['observaciones'] != ''){
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->MultiCell(330,5,$this->SetFont('Courier','B',10).'OBSERVACIONES: '.mb_convert_encoding($reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,'J');
    }
    ################################# BLOQUE N.6 #######################################     
}
########################## FUNCION GUIA VENTA ##############################

########################## FUNCION LISTAR VENTAS ##############################
function TablaListarVentas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->ListarVentas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE VENTAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(38,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,38,65,30,22,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS ##############################

########################## FUNCION LISTAR VENTAS POR BUSQUEDA ##############################
function TablaListarVentasxBusqueda()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BusquedaVentas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if($_GET['tipobusqueda'] == 1){
    $this->Cell(335,10,'LISTADO GENERAL DE VENTAS A CLIENTES',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 2){
    $this->Cell(335,10,'LISTADO DE COMPRAS A VENTAS POR B�SQUEDA',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Cell(335,10,'LISTADO DE COMPRAS A VENTAS POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    if($_GET['tipobusqueda'] == 2){
    $this->Ln();
    $this->Cell(335,6,"B�SQUEDA: ".utf8_decode($_GET["search_criterio"]),0,0,'L');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(38,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,38,65,30,22,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR BUSQUEDA ##############################

########################## FUNCION LISTAR VENTAS DEL DIA ##############################
function TablaListarVentasDiarias()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarVentasDiarias();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE VENTAS DEL DIA',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,5,"FECHA ACTUAL: ".utf8_decode(date("d-m-Y")),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(38,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,38,65,30,22,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS DEL DIA ##############################

########################## FUNCION LISTAR LIBRO DE VENTAS POR FECHAS ##############################
function TablaListarLibroVentasxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarLibroVentasxFechas(); 

    $nt = new Login();
    $nc = $nt->BuscarLibroVentasNCxFechas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,7,'LIBRO DE VENTAS RESUMIDO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,5,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"MONEDA: ".utf8_decode($reg[0]["simbolo"]),0,1,'L');

    $this->Ln();
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(230, 231, 232); // establece el color del fondo de la celda (en este caso es NARANJA)
    //$this->SetFillColor(230, 126, 34); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(10,8,'N�',1,0,'C', True);
    $this->Cell(24,8,'EMISI.',1,0,'C', True);
    $this->Cell(34,8,'FACT.INICIAL',1,0,'C', True);
    $this->Cell(34,8,'FACT.FINAL',1,0,'C', True);
    $this->Cell(22,8,'PROPINAS',1,0,'C', True);
    $this->Cell(30,8,'TOTAL/NETO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL+IMPUESTO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL/RETENIDO',1,0,'C', True);
    $this->Cell(25,8,'EXONERACI.',1,0,'C', True);
    $this->Cell(22,8,'BASE 0%',1,0,'C', True);
    $this->Cell(22,8,'IMPUESTO',1,0,'C', True);
    $this->Cell(26,8,'BASE '.number_format($ValorImpuesto, 0, '.', ',').'%',1,0,'C', True);
    $this->Cell(26,8,'IMPUESTO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(10,24,34,34,22,30,30,30,25,22,22,26,26));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
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
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $explode = explode(", ",$reg[$i]['detalles_facturas']);
    sort($explode);
    $inicio = reset($explode); // Primero
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

    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechaventa']))),
        utf8_decode($inicio),
        utf8_decode($fin),
        "0.00",
        utf8_decode(number_format($reg[$i]['subtotal'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['subtotal']+$reg[$i]['totaliva'], 2, '.', ',')),
        utf8_decode(number_format("0.00", 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['totalexonerado'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['subtotalexento'], 2, '.', ',')),
        utf8_decode(number_format("0.00", 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['subtotaliva'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['totaliva'], 2, '.', ','))
       ));
    }
   
    $this->Cell(80,5,'',0,0,'C');
    $this->SetFont('Courier','B',9);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(22,5,"TOTALES",0,0,'L');
    $this->SetFont('Courier','B',8);
    $this->CellFitSpace(22,5,utf8_decode(number_format($TotalPropina, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalNeto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalConImpuesto, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($TotalRetenido, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalExoneracion, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(22,5,utf8_decode(number_format($TotalExento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(22,5,utf8_decode(number_format($ImpuestoExento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(26,5,utf8_decode(number_format($TotalBaseIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(26,5,utf8_decode(number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Cell(325,5,'',0,0,'C');
    $this->Ln();
    
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3, 3, 3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(335,8,'RESUMEN LIBRO DE VENTAS',1,0,'l', True);
    $this->Ln();
    
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFont('Courier','B',10);
    $this->Cell(100,5,'',1,0,'L');
    $this->CellFitSpace(40,5,"BASE",1,0,'C', True);
    $this->CellFitSpace(40,5,"IMPUESTO",1,0,'C', True);
    $this->CellFitSpace(40,5,"IMP/RETENIDO",1,0,'C', True);
    $this->CellFitSpace(15,5," ",0,0,'C');
    $this->Cell(40,5,'',1,0,'C');
    $this->CellFitSpace(30,5,"BASE",1,0,'C', True);
    $this->CellFitSpace(30,5,"IMPUESTO",1,0,'C', True);
    $this->Ln();

    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFont('Courier','B',10);
    $this->Cell(100,5,'TOTAL VENTAS EXENTAS (0,00%)',1,0,'L');
    $this->SetFont('Courier','',10);
    $this->CellFitSpace(40,5,number_format($TotalExento, 2, '.', ','),1,0,'C');
    $this->CellFitSpace(40,5,"0.00",1,0,'C');
    $this->CellFitSpace(40,5,"0.00",1,0,'C');
    $this->CellFitSpace(15,5," ",0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->Cell(40,5,'N/C 0.00%',1,0,'L');
    $this->SetFont('Courier','',10);
    $this->CellFitSpace(30,5,number_format(empty($nc[0]['subtotalexentonc']) ? "0.00" : $nc[0]['subtotalexentonc'], 2, '.', ','),1,0,'C');
    $this->CellFitSpace(30,5,"0.00",1,0,'C');
    $this->Ln();

    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFont('Courier','B',10);
    $this->Cell(100,5,'TOTAL VENTAS GRAVADAS '.$NomImpuesto.' ('.number_format($ValorImpuesto, 0, '.', ',').'%)',1,0,'L');
    $this->SetFont('Courier','',10);
    $this->CellFitSpace(40,5,number_format($TotalBaseIva, 2, '.', ','),1,0,'C');
    $this->CellFitSpace(40,5,number_format($TotalIva, 2, '.', ','),1,0,'C');
    $this->CellFitSpace(40,5,"0.00",1,0,'C');
    $this->CellFitSpace(15,5," ",0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->Cell(40,5,'N/C ('.number_format($ValorImpuesto, 0, '.', ',').'%)',1,0,'L');
    $this->SetFont('Courier','',10);
    $this->CellFitSpace(30,5,number_format(empty($nc[0]['subtotalivanc']) ? "0.00" : $nc[0]['subtotalivanc'], 2, '.', ','),1,0,'C');
    $this->CellFitSpace(30,5,number_format(empty($nc[0]['totalivanc']) ? "0.00" : $nc[0]['totalivanc'], 2, '.', ','),1,0,'C');
    $this->Ln();

    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFont('Courier','B',10);
    $this->Cell(100,5,'TOTAL RETENCIONES IMPUESTO',1,0,'L');
    $this->SetFont('Courier','',10);
    $this->CellFitSpace(40,5," ",1,0,'C');
    $this->CellFitSpace(40,5," ",1,0,'C');
    $this->CellFitSpace(40,5,"0.00",1,0,'C');
    $this->Ln(4);
}
########################## FUNCION LISTAR LIBRO DE VENTAS POR FECHAS ##############################

########################## FUNCION LISTAR VENTAS POR CAJAS ##############################
function TablaListarVentasxCajas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarVentasxCajas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,7,'LISTADO DE VENTAS GENERALES POR CAJAS',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,7,'LISTADO DE VENTAS A CONTADO POR CAJAS',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,7,'LISTADO DE VENTAS A CR�DITO POR CAJAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.CAJA: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"RESPONSABLE DE CAJA: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(38,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,38,65,30,22,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR CAJAS ##############################

########################## FUNCION LISTAR VENTAS POR FECHAS ##############################
function TablaListarVentasxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarVentasxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,7,'LISTADO DE FACTURACI. GENERALES POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,7,'LISTADO DE FACTURACI. A CONTADO POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,7,'LISTADO DE FACTURACI. A CR�DITO POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(38,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(65,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(22,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(35,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,38,65,30,22,25,30,35,35,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(170,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR FECHAS ##############################

########################## FUNCION LISTAR VENTAS POR CLIENTES ##############################
function TablaListarVentasxClientes()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarVentasxClientes();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,7,'LISTADO DE VENTAS GENERALES POR CLIENTES',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,7,'LISTADO DE VENTAS A CONTADO POR CLIENTES',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,7,'LISTADO DE VENTAS A CR�DITO POR CLIENTES',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(330,6,"N.DE ".utf8_decode($documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']).": ".$reg[0]["dnicliente"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"NOMBRE DE CLIENTE: ".utf8_decode($reg[0]['nomcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"N.DE TELEFONO: ".utf8_decode($reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DIRECCI. DOMICILIARIA: ".utf8_decode($reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"CORREO ELECTRONICO: ".portales(utf8_decode($reg[0]["emailcliente"] == "" ? "********" : $reg[0]["emailcliente"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(75,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(45,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(40,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(40,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,75,45,25,25,30,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($estado),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(160,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR CLIENTES ##############################

########################## FUNCION LISTAR VENTAS POR CONDICIONES ##############################
function TablaListarVentasxCondiciones()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
    $tra = new Login();
    $reg = $tra->BuscarVentasxCondiciones();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE VENTAS POR FORMA DE PAGO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"CAJA N�: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"RESPONSABLE: ".utf8_decode($reg[0]["nombres"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"FORMA DE PAGO: ".$reg[0]["mediopago"],0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(40,8,'IMPORTE TOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL PAGADO',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,30,25,30,35,30,40,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos  = 0;
    $TotalDescuento  = 0;
    $TotalSubtotal   = 0;
    $TotalIva        = 0;
    $TotalImporte    = 0;
    $ImportePagado   = 0;
    $TotalPagado     = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];
    $ImportePagado  =  $reg[$i]['suma_pagado'];
    $TotalPagado    += $reg[$i]['suma_pagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($ImportePagado, 2, '.', ','))));
    }
   
    $this->Cell(145,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalPagado, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR VENTAS POR CONDICIONES ##############################

########################## FUNCION LISTAR COMISION POR VENTAS ##############################
function TablaListarComisionxVentas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra = new Login();
    $reg = $tra->BuscarComisionxVentas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,10,'LISTADO DE COMISI. DE VENTAS GENERALES POR VENDEDOR',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,10,'LISTADO DE COMISI. DE VENTAS A CONTADO POR VENDEDOR',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,10,'LISTADO DE COMISI. DE VENTAS A CR�DITO POR VENDEDOR',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"N.DE DOCUMENTO: ".utf8_decode($reg[0]["dni"]),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"NOMBRE DE VENDEDOR: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(100,8,'DETALLES DE PRODUCTOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL SERVICIO',1,0,'C', True);
    $this->Cell(35,8,'TOTAL COMISI.',1,1,'C', True);
    
    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,55,30,25,100,35,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a               = 1;
    $TotalArticulos  = 0;
    $TotalImporte    = 0;
    $TotalComision   = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo            = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $detalles_productos = str_replace("<br>","\n", $reg[$i]['detalles_productos']);

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

    $TotalArticulos += $reg[$i]['articulos']; 
    $TotalImporte   += $reg[$i]['totalpago'];
    $TotalComision  += $reg[$i]['totalpago']*$reg[$i]['comision']/100;

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),
        utf8_decode($estado),
        utf8_decode($detalles_productos),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','))));
    }
   
    $this->Cell(265,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    //$this->CellFitSpace(30,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalComision, 2, '.', ',')),0,0,'L');
    $this->Ln();
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR COMISION POR VENTAS ##############################

########################## FUNCION LISTAR DETALLES VENTAS POR CONDICIONES ##############################
function TablaListarDetallesVentasxCondiciones()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesVentasxCondiciones(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS GENERALES POR CONDICIONES',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS A CONTADO POR CONDICIONES',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS A CR�DITO POR CONDICIONES',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    if(decrypt($_GET['tipodetalle']) == 0){ 
    $this->Cell(335,6,'TIPO DETALLE: GENERAL',0,0,'L');
    } elseif(decrypt($_GET['tipodetalle']) == 1){ 
    $this->Cell(335,6,'TIPO DETALLE: PRODUCTOS',0,0,'L');
    } elseif(decrypt($_GET['tipodetalle']) == 2){ 
    $this->Cell(335,6,'TIPO DETALLE: COMBOS',0,0,'L');
    } elseif(decrypt($_GET['tipodetalle']) == 3){ 
    $this->Cell(335,6,'TIPO DETALLE: SERVICIOS',0,0,'L');
    }
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'FACTURADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES VENTAS POR CONDICIONES ##############################

########################## FUNCION LISTAR DETALLES VENTAS POR FECHAS ##############################
function TablaListarDetallesVentasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesVentasxFechas(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS GENERALES POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS A CONTADO POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS A CR�DITO POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'FACTURADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES VENTAS POR FECHAS ##############################

########################## FUNCION LISTAR DETALLES VENTAS POR VENDEDOR ##############################
function TablaListarDetallesVentasxVendedor()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesVentasxVendedor(); 
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipopago']) == 1){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS GENERALES POR VENDEDOR',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 2){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS A CONTADO POR VENDEDOR',0,0,'C');
    } elseif(decrypt($_GET['tipopago']) == 3){ 
    $this->Cell(335,10,'LISTADO DETALLES DE VENTAS A CR�DITO POR VENDEDOR',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.".utf8_decode($reg[0]['documento']).": ".utf8_decode($reg[0]["cuitsucursal"]),0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".utf8_decode($reg[0]["nomsucursal"]),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO: ".utf8_decode($reg[0]["nomencargado"]),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"VENDEDOR: ".portales(utf8_decode($reg[0]['nombres'])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(20,8,'TIPO',1,0,'C', True);
    $this->Cell(25,8,'C�DIGO',1,0,'C', True);
    $this->Cell(80,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'DESC %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(30,8,'EXISTENCIA',1,0,'C', True);
    $this->Cell(25,8,'FACTURADO',1,0,'C', True);
    $this->Cell(30,8,'MONTO TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,20,25,80,30,30,20,30,30,25,30));

    $a              = 1;
    $PrecioTotal    = 0;
    $ExisteTotal    = 0;
    $VendidosTotal  = 0;
    $PagoTotal      = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioTotal    += $reg[$i]['precioventa'];
    $ExisteTotal    += $reg[$i]['existencia'];
    $VendidosTotal  += $reg[$i]['cantidad']; 

    $Descuento       = $reg[$i]['descproducto']/100;
    $PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal     = $reg[$i]['precioventa']-$PrecioDescuento;
    $PagoTotal      += $PrecioFinal*$reg[$i]['cantidad'];

    if($reg[$i]['tipodetalle'] == 1){
    $tipodetalle = "PRODUCTO";
    } elseif($reg[$i]['tipodetalle']==2){
    $tipodetalle = "COMBO";
    } elseif($reg[$i]['tipodetalle']==3){ 
    $tipodetalle = "SERVICIO";
    }

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipodetalle),
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['existencia'], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','))));
    }

    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PrecioTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode(number_format($ExisteTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($PagoTotal, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES VENTAS POR VENDEDOR ##############################

####################### FUNCION LISTAR GANANCIAS POR FECHAS ###########################
function TablaListarGananciasxFechas()
{
    $ingresos = new Login();
    $detalle_ingreso = $ingresos->BuscarIngresosxFechas(); 

    $ganancias = new Login();
    $reg = $ganancias->BuscarGananciasxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,"LISTADO DE DE GANANCIAS POR FECHAS",0,0,'C'); 

    if($_SESSION['acceso'] == "administradorG"){

    $this->Ln();
    $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    } 

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L'); 

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'C�DIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE PRODUCTO',1,0,'C', True);
    $this->Cell(30,8,'MARCA',1,0,'C', True);
    $this->Cell(30,8,'MODELO',1,0,'C', True);
    $this->Cell(15,8,'DCTO %',1,0,'C', True);
    $this->Cell(30,8,"PRECIO VENTA",1,0,'C', True);
    $this->Cell(20,8,'VENDIDO',1,0,'C', True);
    $this->Cell(30,8,'TOTAL VENTA',1,0,'C', True);
    $this->Cell(30,8,'TOTAL COMPRA',1,0,'C', True);
    $this->Cell(30,8,'GANANCIAS',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,30,70,30,30,15,30,20,30,30,30));

    $a                   = 1;
    $PrecioCompraTotal   = 0;
    $PrecioVentaTotal    = 0;
    $ExisteTotal         = 0;
    $VendidosTotal       = 0;
    $CompraTotal         = 0;
    $VentaTotal          = 0;
    $TotalGanancia       = 0;

    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

    $PrecioCompraTotal   += $reg[$i]['preciocompra'];
    $PrecioVentaTotal    += $reg[$i]['precioventa'];
    $ExisteTotal         += $reg[$i]['existencia'];
    $VendidosTotal       += $reg[$i]['cantidad']; 

    $Descuento            = $reg[$i]['descproducto']/100;
    $PrecioDescuento      = $reg[$i]['precioventa']*$Descuento;
    $PrecioFinal          = $reg[$i]['precioventa']-$PrecioDescuento;

    //CALCULO SUBTOTAL IMPUESTOS
    $ValorIva             = 1 + ($reg[$i]['ivaproducto']/100);
    $Discriminado         = $reg[$i]['precioventa']/$ValorIva;
    $SubtotalDiscriminado = $reg[$i]['precioventa'] - $Discriminado;
    $BaseDiscriminado     = $SubtotalDiscriminado * $reg[$i]['cantidad'];
    $Subtotalimpuestos    = number_format($BaseDiscriminado, 2, '.', '');

    $SumVenta             = $PrecioFinal*$reg[$i]['cantidad']; 
    $SumCompra            = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];

    $CompraTotal         += $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
    $VentaTotal          += $PrecioFinal*$reg[$i]['cantidad'];
    $TotalGanancia       += $SumVenta-$SumCompra;

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]["nommarca"]),
        utf8_decode($reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']),
        utf8_decode(number_format($reg[$i]['descproducto'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]["precioventa"], 2, '.', ',')),
        utf8_decode(number_format($reg[$i]['cantidad'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta, 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumCompra, 2, '.', ',')),
        utf8_decode($simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','))));
        }
    }
   
    $this->Cell(220,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(20,5,utf8_decode(number_format($VendidosTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($VentaTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($CompraTotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->SetFont('courier','B',14);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(150,6,'DETALLES DE GANANCIAS / INGRESOS / GASTOS',1,0,'C', True);
    $this->Ln();
    
    $this->SetFont('courier','B',12);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(65,5,'TOTAL DE GANANCIAS',1,0,'C', True);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($TotalGanancia, 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',12);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(65,5,'INGRESOS ADICIONALES',1,0,'C', True);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle_ingreso[0]['totalingresos'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',12);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(65,5,'GASTOS',1,0,'C', True);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($detalle_ingreso[0]['totalegresos'], 2, '.', ',')),1,0,'C');
    $this->Ln();
    
    $this->SetFont('courier','B',12);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(65,5,'TOTAL',1,0,'C', True);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(85,5,utf8_decode($simbolo.number_format($TotalGanancia+$detalle_ingreso[0]['totalingresos']-$detalle_ingreso[0]['totalegresos'], 2, '.', ',')),1,0,'C');
    $this->Ln();
   
    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
###################### FUNCION LISTAR GANANCIAS POR FECHAS ##########################

############################################ REPORTES DE VENTAS ############################################














############################################ REPORTES DE CREDITOS ############################################

########################## FUNCION TICKET CREDITO VENTA (8MM) ##############################
function TicketCreditoVenta_8()
{  
    $tra       = new Login();
    $reg       = $tra->CreditosPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 20, 3, 35, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "TICKET DE CR�DITO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".mb_convert_encoding($reg[0]['dnicliente'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');

    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(70,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(35,3,$reg[0]['codfactura'], 0, 1, 'R');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechaventa'])), 0, 0, 'J');
    $this->CellFitSpace(35,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechaventa'])), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(33,3,"VENCE: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])), 0, 0, 'J');
    if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] >= date("Y-m-d")) {
    $this->CellFitSpace(37,3,"DIAS VENC: "."0", 0, 0, 'R');  
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) {
    $this->CellFitSpace(37,3,"DIAS VENC: ".Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']), 0, 0, 'R'); 
    }
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLE DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC:" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['dnicliente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9)."N.DE TLF: ".$reg[0]['tlfcliente'],0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['direccliente'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2']), 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE ABONOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonosVentas();
    if($detalle==""){
        echo "";      
    } else {
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','),0,1,'R');

    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(30,3,mb_convert_encoding($detalle[$i]['comprobante'] == "" || $detalle[$i]['comprobante'] == "0" ? "******" : "#".$detalle[$i]['comprobante'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(40,3,mb_convert_encoding($detalle[$i]['codbanco'] == "0" ? "******" : $detalle[$i]['nombanco'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,date("d/m/Y H:i:s",strtotime($detalle[$i]['fechaabono'])),0,1,'L');
    $this->Ln(2);

    endfor; 
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(20,4,"TOTAL",0,0,'L');
    $this->Cell(50,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');  

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"ABONADO",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(30,4,"PENDIENTE",0,0,'L');
    $this->Cell(40,4,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3," ",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET CREDITO VENTA (8MM) ##############################

########################## FUNCION TICKET CREDITO VENTA (5MM) ##############################
function TicketCreditoVenta_5()
{  
    $tra       = new Login();
    $reg       = $tra->CreditosPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo , 8, 3, 30, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5, "TICKET DE CR�DITO", 0, 0, 'C');
    $this->Ln(5);
  
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,4,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? "" : "N.".mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".mb_convert_encoding($reg[0]['dnicliente'], 'ISO-8859-1', 'UTF-8'),0,1,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');

    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    
    $this->SetX(2);
    $this->CellFitSpace(42,3,"EMISI.: NORMAL",0,1,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"Nro Ticket:  ", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,$reg[0]['codfactura'], 0, 1, 'R');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechaventa'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechaventa'])), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"VENCE: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])), 0, 0, 'J');
    if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] >= date("Y-m-d")) {
    $this->CellFitSpace(21,3,"DIAS VENC: "."0", 0, 0, 'R');  
    } elseif($reg[0]['fechavencecredito'] < date("Y-m-d")) {
    $this->CellFitSpace(21,3,"DIAS VENC: ".Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']), 0, 0, 'R'); 
    }
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLE DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC:" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ".$reg[0]['dnicliente']),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6)."N.DE TLF: ".$reg[0]['tlfcliente'],0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6).mb_convert_encoding($reg[0]['direccliente'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2']), 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DETALLES DE ABONOS", 0, 0, 'L');
    $this->Ln(5);

    $tra = new Login();
    $detalle = $tra->VerDetallesAbonosVentas();
    if($detalle==""){
        echo "";      
    } else {
    $cantidad = 0;
    $SubTotal = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['mediopago'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','),0,1,'R');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['comprobante'] == "" || $detalle[$i]['comprobante'] == "0" ? "******" : "#".$detalle[$i]['comprobante'], 'ISO-8859-1', 'UTF-8'),0,0,'L');
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codbanco'] == "0" ? "******" : $detalle[$i]['nombanco'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,3,date("d/m/Y H:i:s",strtotime($detalle[$i]['fechaabono'])),0,1,'L');
    $this->Ln(1);

    endfor; 
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"TOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');  

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"ABONADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,"PENDIENTE",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'BI',10);
    $this->SetFillColor(3, 3, 3);
    $this->CellFitSpace(70,3," ",0,1,'C');
    $this->Ln(3);
}
########################## FUNCION TICKET CREDITO VENTA (5MM) ##############################

########################## FUNCION LISTAR CREDITOS ##############################
function TablaListarCreditos()
{
    $tra = new Login();
    $reg = $tra->ListarCreditos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,40,25,35,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($estado),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS ##############################

########################## FUNCION LISTAR CREDITOS POR BUSQUEDA ##############################
function TablaListarCreditosxBusqueda()
{
    $tra = new Login();
    $reg = $tra->BusquedaCreditos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if($_GET['tipobusqueda'] == 1){
    $this->Cell(335,10,'LISTADO GENERAL DE VENTAS A CR�DITOS',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 2){
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS POR B�SQUEDA',0,0,'C');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS POR FECHAS',0,0,'C');
    }

    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    if($_GET['tipobusqueda'] == 2){
    $this->Ln();
    $this->Cell(335,6,"B�SQUEDA: ".utf8_decode($_GET["search_criterio"]),0,0,'L');
    } elseif($_GET['tipobusqueda'] == 3){
    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,40,25,35,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    
    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($estado),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR BUSQUEDA ##############################

########################## FUNCION LISTAR CREDITOS VENCIDOS ##############################
function TablaListarCreditosVencidos()
{
    $tra = new Login();
    $reg = $tra->ListarCreditosVencidos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS VENCIDAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'FECHA VENCIMIENTO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,25,35,40,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode($estado),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS VENCIDOS ##############################

######################## FUNCION LISTAR ABONOS CREDITOS POR CAJAS #########################
function TablaListarAbonosCreditosVentasxCajas()
{
    $tra = new Login();
    $reg = $tra->BuscarAbonosCreditosVentasxCajas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,"LISTADO DE ABONOS EN VENTAS A CR�DITOS POR CAJAS",0,0,'C');
    $this->Ln();

    if($_SESSION['acceso'] == "administradorG" && $reg != ""){

    $this->Ln();
    $this->Cell(260,5,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
    $this->Ln();
    $this->Cell(260,5,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(260,5,"ENCARGADO: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 

    }

    $this->Ln();
    $this->Cell(260,5,"CAJA N�: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(260,5,"RESPONSABLE: ".utf8_decode($reg[0]["nombres"]),0,0,'L');
    $this->Ln();
    $this->Cell(260,5,"FORMA DE ABONO: ".$reg[0]["mediopago"],0,0,'L');
    $this->Ln();
    $this->Cell(260,5,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(260,5,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,1,'L');
    
    $this->Ln();
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es NARANJA)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(40,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(45,8,'FECHA DE ABONO',1,0,'C', True);
    $this->Cell(40,8,'N.DE COMPROBANTE',1,0,'C', True);
    $this->Cell(40,8,'NOMBRE DE BANCO',1,0,'C', True);
    $this->Cell(45,8,'MONTO ABONO',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
    $this->SetWidths(array(15,40,40,70,45,40,40,45));

    $a=1;
    $TotalImporte=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),
        utf8_decode($reg[$i]['documento3'].": ".$reg[$i]['dnicliente']),
        portales(utf8_decode($reg[$i]['nomcliente'])),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaabono']))),
        portales(utf8_decode($reg[$i]['comprobante'] == "" ? "********" : $reg[$i]['comprobante'])),
        portales(utf8_decode($reg[$i]['codbanco'] == 0 ? "********" : $reg[$i]['nombanco'])),
        utf8_decode($simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','))
       ));
        }
    }
   
    $this->Cell(290,5,'',0,0,'C');
    $this->SetFont('Courier','B',10);
    $this->SetTextColor(255, 255, 255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(45,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
######################## FUNCION LISTAR ABONOS CREDITOS POR CAJAS #########################

########################## FUNCION LISTAR CREDITOS POR CONDICIONES ##############################
function TablaListarCreditosVentasxCondiciones()
{
    $tra = new Login();
    $reg = $tra->BuscarCreditosVentasxCondiciones();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['tipobusqueda']) == 1){ 
    $this->Cell(335,10,'LISTADO  DE VENTAS A CR�DITOS GENERALES',0,0,'C');
    } elseif(decrypt($_GET['tipobusqueda']) == 2){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS PAGADAS',0,0,'C');
    } elseif(decrypt($_GET['tipobusqueda']) == 3){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS PENDIENTES',0,0,'C');
    } elseif(decrypt($_GET['tipobusqueda']) == 4){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS VENCIDAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'FECHA VENCIMIENTO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,25,35,40,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode($estado),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR CONDICIONES ##############################

########################## FUNCION LISTAR CREDITOS POR FECHAS ##############################
function TablaListarCreditosVentasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarCreditosVentasxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS GENERALES POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS PAGADAS POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS PENDIENTES POR FECHAS',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(40,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,40,25,35,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),utf8_decode($estado),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR FECHAS ##############################

########################## FUNCION LISTAR CREDITOS POR CLIENTES ##############################
function TablaListarCreditosVentasxClientes()
{
    $tra = new Login();
    $reg = $tra->BuscarCreditosVentasxClientes();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS GENERALES POR CLIENTES',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS PAGADAS POR CLIENTES',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'LISTADO DE VENTAS A CR�DITOS PENDIENTES POR CLIENTES',0,0,'C');
    }

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(330,6,"N.DE ".utf8_decode($documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']).": ".$reg[0]["dnicliente"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"NOMBRE DE CLIENTE: ".utf8_decode($reg[0]['nomcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"N.DE TELEFONO: ".utf8_decode($reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DIRECCI. DOMICILIARIA: ".utf8_decode($reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"CORREO ELECTRONICO: ".portales(utf8_decode($reg[0]["emailcliente"] == "" ? "********" : $reg[0]["emailcliente"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(60,8,'OBSERVACIONES',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(40,8,'FECHA VENCIMIENTO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(40,8,'TOTAL ABONADO',1,0,'C', True);
    $this->Cell(40,8,'TOTAL PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,60,25,35,40,40,40,40));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte+=$reg[$i]['totalpago'];
    $TotalAbono+=$reg[$i]['creditopagado'];
    $TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    if($reg[$i]["statusventa"] == 'PAGADA'){ 
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]["statusventa"] == 'ANULADA'){
    $estado = $reg[$i]["statusventa"];
    } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE"){
    $estado = 'VENCIDA';
    } else { 
    $estado = $reg[$i]["statusventa"];
    }
    

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,
        utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),
        utf8_decode($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']),
        utf8_decode($estado),
        utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),
        utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechavencecredito']))),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),
        utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
    }
   
    $this->Cell(215,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(40,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    
    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR CREDITOS POR CLIENTES ##############################

########################## FUNCION LISTAR DETALLES CREDITOS POR FECHAS #########################
function TablaListarDetallesCreditosVentasxFechas()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesCreditosVentasxFechas();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'DETALLES DE VENTAS A CR�DITOS EN GENERAL POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'DETALLES DE VENTAS A CR�DITOS PAGADOS POR FECHAS',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'DETALLES DE VENTAS A CR�DITOS PENDIENTES POR FECHAS',0,0,'C');
    }
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,6,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,6,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');
 
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(40,8,'NOMBRE DE CLIENTE',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(90,8,'DETALLES DE PRODUCTOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(30,8,'ABONADO',1,0,'C', True);
    $this->Cell(30,8,'PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,40,25,30,90,35,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte=0;
    $TotalAbono=0;
    $TotalDebe=0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte += $reg[$i]['totalpago'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode($reg[$i]["statusventa"]),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles_productos'])),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
        }
    }
   
    $this->Cell(240,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES CREDITOS POR FECHAS #########################

########################## FUNCION LISTAR DETALLES CREDITOS POR CLIENTES #########################
function TablaListarDetallesCreditosVentasxClientes()
{
    $tra = new Login();
    $reg = $tra->BuscarDetallesCreditosVentasxClientes();

    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    if(decrypt($_GET['status']) == 1){ 
    $this->Cell(335,10,'DETALLES DE VENTAS A CR�DITOS EN GENERAL POR CLIENTES',0,0,'C');
    } elseif(decrypt($_GET['status']) == 2){ 
    $this->Cell(335,10,'DETALLES DE VENTAS A CR�DITOS PAGADOS POR CLIENTES',0,0,'C');
    } elseif(decrypt($_GET['status']) == 3){ 
    $this->Cell(335,10,'DETALLES DE VENTAS A CR�DITOS PENDIENTES POR CLIENTES',0,0,'C');
    }
    
    if($_SESSION['acceso'] == "administradorG"){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(330,6,"N.DE ".utf8_decode($documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']).": ".$reg[0]["dnicliente"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"NOMBRE DE CLIENTE: ".utf8_decode($reg[0]['nomcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"N.DE TELEFONO: ".utf8_decode($reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DIRECCI. DOMICILIARIA: ".utf8_decode($reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"CORREO ELECTRONICO: ".portales(utf8_decode($reg[0]["emailcliente"] == "" ? "********" : $reg[0]["emailcliente"])),0,0,'L');
 
    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(25,8,'ESTADO',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(70,8,'DETALLES DE PRODUCTOS',1,0,'C', True);
    $this->Cell(60,8,'DETALLES DE ABONOS',1,0,'C', True);
    $this->Cell(35,8,'TOTAL FACTURA',1,0,'C', True);
    $this->Cell(30,8,'ABONADO',1,0,'C', True);
    $this->Cell(30,8,'PENDIENTE',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,25,30,70,60,35,30,30));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalImporte = 0;
    $TotalAbono   = 0;
    $TotalDebe    = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

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
    
    $TotalImporte += $reg[$i]['totalpago'];
    $TotalAbono   += $reg[$i]['creditopagado'];
    $TotalDebe    += $reg[$i]['totalpago']-$reg[$i]['creditopagado'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento)." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]["statusventa"]),utf8_decode(date("d/m/Y H:i:s",strtotime($reg[$i]['fechaventa']))),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles_productos'])),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles_abonos'])),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','))));
        }
    }
   
    $this->Cell(240,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalAbono, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDebe, 2, '.', ',')),0,0,'L');
    $this->Ln();
    

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR DETALLES CREDITOS POR CLIENTES #########################

############################################ REPORTES DE CREDITOS ############################################















############################################ REPORTES DE NOTAS CREDITOS ############################################

########################## FUNCION NOTA DE CREDITO (8MM) ##############################
function TicketNotaCredito_8()
{  
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->NotaCreditoPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 15, 3, 45, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->Ln(2);
    $this->SetX(2);
    $this->MultiCell(70,4,$this->SetFont($TipoLetra,'B',10).mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$reg[0]['documsucursal'] == '0' ? " " : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',9).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(70,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5, "NOTA DE CR�DITO", 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(70,4,$reg[0]['codfactura'], 0, 1, 'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->CellFitSpace(18,3,"CAJA N�",0,0,'J');
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(52,3,mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(18,4,"CAJERO:", 0, 0, 'J');
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(52,4,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(35,4,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechanota'])), 0, 0, 'J');
    $this->CellFitSpace(35,4,"HORA: ".date("H:i:s",strtotime($reg[0]['fechanota'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,utf8_decode("A CONSUMIDOR FINAL"), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->CellFitSpace(70,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8')).": ".$reg[0]['dnicliente'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',9);
    $this->MultiCell(70,3,$this->SetFont('Courier','B',9).mb_convert_encoding($reg[0]['direccliente'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2']), 'ISO-8859-1', 'UTF-8'),0,'L');
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra       = new Login();
    $detalle   = $tra->VerDetallesNotasCredito();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',8);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(35,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    if($detalle[$i]["descripcion"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(70,3,mb_convert_encoding($detalle[$i]["descripcion"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    if($detalle[$i]["imei"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(70,3,"N.DE IMEI: ".mb_convert_encoding($detalle[$i]["imei"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,3,'---------------------------',0,0,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"DESCONTADO %",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXONERADO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"EXENTO",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(34,4,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(34,4,"TOTAL",0,0,'L');
    $this->Cell(36,4,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',7);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(70,4,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->Ln(2);
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',7);
    $this->CellFitSpace(70,4,"DOCUMENTO QUE MODIFICA",0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',7);
    $this->Cell(70,4,$reg[0]['tipofacturaventa']." N.".$reg[0]['facturaventa'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',7);
    $this->CellFitSpace(70,4,"OBSERVACIONES",0,1,'L');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',7);
    $this->MultiCell(70,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(30,4,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(40,4,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(70,4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',9);
    $this->CellFitSpace(10,4,"TEL:",0,0,'L');
    $this->CellFitSpace(60,4,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(70,0.5,'---------------------------',0,1,'C');
    $this->Ln();

    $this->SetX(2);
    $this->MultiCell(70,3,$this->SetFont($TipoLetra,'B',6).portales($GLOBALS['texto_global']),0,'J');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont($TipoLetra,'BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION NOTA DE CREDITO (8MM) ##############################

########################## FUNCION NOTA DE CREDITO (5MM) ##############################
function TicketNotaCredito_5()
{  
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->NotaCreditoPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 
    $TipoLetra = "Courier"; 

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

        $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
        $this->Image($logo, 8, 3, 30, 15, "PNG");
        $this->Ln(8);
    }
  
    $this->Ln(2);
    $this->SetX(2);
    $this->MultiCell(42,4,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->CellFitSpace(42,3,$reg[0]['documsucursal'] == '0' ? " " : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8')." ".$reg[0]['cuitsucursal'],0,1,'C');

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',8).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'C');

    if($reg[0]['id_provincia']!='0'){

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento']).", ".$provincia = ($reg[0]['id_provincia'] == '0' ? " " : $reg[0]['provincia']), 'ISO-8859-1', 'UTF-8'),0,1,'C');
    }

    $this->SetX(2);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 4, "NOTA DE CR�DITO", 0, 1, 'C');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(42,3,$reg[0]['codfactura'], 0, 1, 'C');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(16,3,"CAJA N�",0,0,'J');
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(26,3,mb_convert_encoding($caja = ($reg[0]['codcaja'] == "0" ? "********" : $reg[0]['nrocaja']."-".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,"CAJERO:", 0, 1, 'J');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['nombres'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(21,3,"FECHA: ".date("d/m/Y",strtotime($reg[0]['fechanota'])), 0, 0, 'J');
    $this->CellFitSpace(21,3,"HORA: ".date("H:i:s",strtotime($reg[0]['fechanota'])), 0, 0, 'R');
    $this->Ln();

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(42, 5,"DATOS DE CLIENTE", 0, 0, 'L');
    $this->Ln(5);
    
    if($reg[0]['codcliente'] == '0'){

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6.5);
    $this->CellFitSpace(42,3,utf8_decode("A CONSUMIDOR FINAL"), 0, 1, 'J');   

    } else {

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->CellFitSpace(42,3,$documento = ($reg[0]['documcliente'] == '0' ? "N.DOC" : "N.".mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8')).": ".$reg[0]['dnicliente'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6.5);
    $this->MultiCell(42,3,$this->SetFont('Courier','B',6.5).mb_convert_encoding($reg[0]['direccliente'].$departamento2 = ($reg[0]['id_departamento2'] == '0' ? "" : " ".$reg[0]['departamento2'])."".$provincia2 = ($reg[0]['id_provincia2'] == '0' ? "" : " ".$reg[0]['provincia2']), 'ISO-8859-1', 'UTF-8'),0,'L');
    }

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',8);
    $this->SetFillColor(2,157,116);
    $this->Cell(70, 5,"DETALLES DE PRODUCTOS", 0, 0, 'L');
    $this->Ln(5);

    $tra       = new Login();
    $detalle   = $tra->VerDetallesNotasCredito();
    $cantidad  = 0;
    $SubTotal  = 0;
    $Articulos = 0;
    $a=1;
    for($i=0;$i<sizeof($detalle);$i++):
    $SubTotal  += $detalle[$i]['valortotal'];
    $Articulos += $detalle[$i]['cantidad'];

    $this->SetX(2);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'',6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,number_format($detalle[$i]['cantidad'], 2, '.', ',')." X ".$simbolo.number_format($detalle[$i]["precioventa"], 2, '.', ','),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,$simbolo.number_format($detalle[$i]["valortotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"], 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]["codmarca"] == 0 ? "******" : $detalle[$i]["nommarca"], 'ISO-8859-1', 'UTF-8'),0,0,'J');

    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(21,3,mb_convert_encoding($detalle[$i]['codmodelo'] == 0 ? "******" : $detalle[$i]['nommodelo'], 'ISO-8859-1', 'UTF-8'),0,1,'R');

    if($detalle[$i]["descripcion"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(42,3,mb_convert_encoding($detalle[$i]["descripcion"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    if($detalle[$i]["imei"] != ""){
    $this->SetX(2);
    $this->SetFont('Courier','',6);
    $this->MultiCell(42,3,"N.DE IMEI: ".mb_convert_encoding($detalle[$i]["imei"], 'ISO-8859-1', 'UTF-8'),0,1,'');
    }

    endfor;

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,3,'-------------------',0,0,'C');
    $this->Ln(2);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"DESCONTADO %",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['descontado']+$reg[0]['totaldescuento'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXONERADO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"EXENTO",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%)",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',7);
    $this->CellFitSpace(21,3,"TOTAL",0,0,'L');
    $this->Cell(21,3,$simbolo.number_format($reg[0]['totalpago'], 2, '.', ','),0,1,'R');

    $this->SetX(2);
    $this->SetDrawColor(3,3,3);
    $this->SetFont($TipoLetra,'',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(42,3,mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,1,'');

    $this->Ln(2);
    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,4,"DOCUMENTO QUE MODIFICA",0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->Cell(42,4,$reg[0]['tipofacturaventa']." N.".$reg[0]['facturaventa'],0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',6);
    $this->CellFitSpace(42,4,"OBSERVACIONES",0,1,'L');
    
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->MultiCell(42,4,mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),0,1,'');
   
    $this->Ln();
    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(21,3,"CANTIDAD TOTAL:",0,0,'L');
    $this->CellFitSpace(21,3,number_format($Articulos, 2, '.', ','),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(42,3,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'),0,1,'L');

    $this->SetX(2);
    $this->SetFont($TipoLetra,'',6);
    $this->CellFitSpace(10,3,"TEL:",0,0,'L');
    $this->CellFitSpace(32,3,$reg[0]['tlfsucursal'],0,1,'L');
    $this->Ln(1);

    $this->SetX(2);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->SetX(2);
    $this->Cell(42,0.5,'-------------------',0,1,'C');
    $this->Ln(3);

    $this->SetX(2);
    $this->MultiCell(42,3,$this->SetFont($TipoLetra,'B',6).portales($GLOBALS['texto_global']),0,'J');
    $this->Ln(3);

    $this->SetX(2);
    //$this->MultiCell(70,3,$this->SetFont($TipoLetra,'BI',10).portales(utf8_decode($reg[0]['membrete'])),0,'C');
    $this->Ln(3);
}
########################## FUNCION NOTA DE CREDITO (5MM) ##############################

########################## FUNCION NOTA CREDITO (A4) #############################
function FacturaNotaCredito_a4()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################

    $tra       = new Login();
    $reg       = $tra->NotaCreditoPorId();
    $simbolo   = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //Logo
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {
       $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
       $this->Image($logo, 12, 10, 40, 12, "PNG");
    }
        
    //######################### BLOQUE DATOS DE SUCURSAL #############################
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(7, 24, 100, 32, '1.5', "");
    
    $this->SetFont($TipoLetra,'BI',14);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(7, 25);
    $this->CellFitSpace(100, 5,mb_convert_encoding($reg[0]['nomsucursal'], 'ISO-8859-1', 'UTF-8'), 0, 1); //Membrete Nro 1

    $this->SetFont($TipoLetra,'B',10);
    if($reg[0]['id_provincia']!='0'){
    $this->SetX(7);
    $this->CellFitSpace(100, 4,mb_convert_encoding($provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']." ").$departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento']), 'ISO-8859-1', 'UTF-8'), 0,1);
    }

    $this->SetX(7);
    $this->MultiCell(100,5,$this->SetFont($TipoLetra,'B',10).mb_convert_encoding($reg[0]['direcsucursal'], 'ISO-8859-1', 'UTF-8'),0,'L');

    $this->SetX(7);
    $this->CellFitSpace(100, 4,'N.ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 4,'N.TLF: '.$reg[0]['tlfsucursal'], 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 4,mb_convert_encoding($reg[0]['correosucursal'], 'ISO-8859-1', 'UTF-8'), 0,1);

    $this->SetX(7);
    $this->CellFitSpace(100, 4,'OBLIGADO A LLEVAR CONTABILIDAD: '.$reg[0]['llevacontabilidad'], 0, 0); 
    //######################### BLOQUE DATOS DE SUCURSAL #############################

    //######################### BLOQUE DATOS DE FACTURA #############################
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(110, 8, 93, 48, '1.5', "");

    $this->SetFont($TipoLetra,'B',12);
    $this->SetXY(110, 9);
    $this->Cell(93, 6, 'NOTA DE CR�DITO', 0, 0, 'C');

    $this->SetFont($TipoLetra,'B',10);
    $this->SetXY(110, 15);
    $this->Cell(38, 5, 'N.DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : mb_convert_encoding($reg[0]['documento'], 'ISO-8859-1', 'UTF-8').":"), 0, 0);
    $this->SetXY(148, 15);
    $this->CellFitSpace(55, 5,$reg[0]['cuitsucursal'], 0, 0);

    $this->SetXY(110, 20);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5, 'N.DE NOTA', 0, 0);
    $this->SetXY(148, 20);
    $this->CellFitSpace(55, 5,$reg[0]['codfactura'], 0, 0);

    $this->SetXY(110, 25);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5, 'N.ACTIVIDAD:', 0, 0);
    $this->SetXY(148, 25);
    $this->CellFitSpace(55, 5,$reg[0]['nroactividadsucursal'], 0, 0);

    $this->SetXY(110, 30);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(93, 5,"FECHA DE AUTORIZACI.:", 0, 0);

    $this->SetXY(110, 35);
    $this->CellFitSpace(93, 5,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d/m/Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(110, 40);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,"FECHA DE NOTA:", 0, 0);
    $this->SetXY(148, 40);
    $this->CellFitSpace(55, 5,date("d/m/Y H:i:s",strtotime($reg[0]['fechanota'])), 0, 0);

    $this->SetXY(110, 45);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,'AMBIENTE: ', 0, 0);
    $this->SetXY(148, 45);
    $this->Cell(55, 5,'PRODUCCI.', 0, 0);

    $this->SetXY(110, 50);
    $this->SetFont($TipoLetra,'B',10);
    $this->Cell(38, 5,'EMISI.: ', 0, 0);
    $this->SetXY(148, 50);
    $this->Cell(55, 5,'NORMAL', 0, 0);
    //######################### BLOQUE DATOS DE FACTURA #############################
     
    //######################### BLOQUE DATOS DE CLIENTE #############################
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(7, 58, 196, 20, '1.5', "");
    $this->SetFont($TipoLetra,'B',6);

    $this->SetXY(7,58);
    $this->SetFont($TipoLetra,'B',11);
    $this->CellFitSpace(196, 5,'RAZ. SOCIAL: '.mb_convert_encoding($reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    
    $this->SetX(7);
    $this->CellFitSpace(98, 5,"N.".$documento = ($reg[0]['documcliente'] == "" ? "DOC: " : mb_convert_encoding($reg[0]['documento3'], 'ISO-8859-1', 'UTF-8').": ").$dni = ($reg[0]['dnicliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['dnicliente']), 0, 0);

    $this->CellFitSpace(98, 5,"N.TLF: ".$phone = ($reg[0]['tlfcliente'] == "" ? "**********" : $reg[0]['tlfcliente']), 0, 1);
    
    $this->SetX(7);
    $this->CellFitSpace(98, 5,"GIRO: ".mb_convert_encoding($reg[0]['girocliente'] == "" ? "**********" : $reg[0]['girocliente'], 'ISO-8859-1', 'UTF-8'), 0, 0);
    $this->CellFitSpace(98, 5,"CORREO: ".mb_convert_encoding($var = ($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 'ISO-8859-1', 'UTF-8'), 0, 1);

    $this->SetX(7);
    $this->CellFitSpace(196, 5,"DIRECCI.: ".mb_convert_encoding($reg[0]['direccliente'] == "" ? "**********" : $reg[0]['direccliente'], 'ISO-8859-1', 'UTF-8'), 0, 1);
    //######################### BLOQUE DATOS DE CLIENTE #############################

    //######################### BLOQUE DATOS DE PRODUCTOS #############################
    $this->Ln(2);
    $this->SetX(7);
    $this->SetFont($TipoLetra,'B',11);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(10,5,'N�',1,0,'C', True);
    $this->Cell(116,5,'DESCRIPCI.',1,0,'C', True);
    $this->Cell(20,5,'CANTIDAD',1,0,'C', True);
    $this->Cell(20,5,'PRECIO',1,0,'C', True);
    $this->Cell(30,5,'IMPORTE',1,1,'C', True);
    
    $tra      = new Login();
    $detalle  = $tra->VerDetallesNotasCredito();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,116,20,20,30));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad   += $detalle[$i]['cantidad'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantidad"];
    $SubTotal   += $detalle[$i]['valorneto'];

    $this->SetX(7);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,"",9);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : "").$imei = ($detalle[$i]["imei"] != "" ? "\nIMEI: ".$detalle[$i]["imei"] : ""), 'ISO-8859-1', 'UTF-8'),number_format($detalle[$i]['cantidad'], 2, '.', ','),number_format($detalle[$i]["precioventa"], 2, '.', ','),number_format($detalle[$i]['valorneto'], 2, '.', ',')));
    }
    //######################### BLOQUE DATOS DE PRODUCTOS #############################
     
    //######################### BLOQUE DATOS DE TOTALES #############################
    $this->Ln(2);
    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'INFORMACI. ADICIONAL',1,0,'C', True);
    $this->Cell(2,4,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(40,5,"DESCONTADO %:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["descontado"]+$reg[0]['totaldescuento'], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"SUBTOTAL:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["subtotal"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'FECHA DE EMISI.: '.date("d/m/Y H:i:s"),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,'EXONERADO:',1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? $reg[0]["subtotal"] : "0.00", 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,'DOCUMENTO MODIFICA: '.$reg[0]['tipofacturaventa']." N.".$reg[0]['facturaventa'],1,0,'L');

    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"EXENTO:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotalexento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,"DETALLE: ".mb_convert_encoding($reg[0]['observaciones'], 'ISO-8859-1', 'UTF-8'),1,0,'L');

    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,"SUBTOTAL ".$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["subtotaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,"N.DE CAJA: ".mb_convert_encoding($caja = ($reg[0]['codcaja'] == 0 ? "**********" : $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']), 'ISO-8859-1', 'UTF-8'),1,0,'L');
    $this->Cell(2,4,"",0,0,'C');
    $this->CellFitSpace(40,5,$NomImpuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["exonerado"] == 2 ? "0.00" : $reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(7);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(110,5,"CAJERO: ".mb_convert_encoding($cajero = ($reg[0]['codcaja'] == 0 ? "**********" : $reg[0]['nombres']), 'ISO-8859-1', 'UTF-8'),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont($TipoLetra,'B',10);
    $this->CellFitSpace(40,5,"IMPORTE TOTAL:",1,0,'L', True);
    $this->CellFitSpace(44,5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(7);
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->MultiCell(196,8,$this->SetFont($TipoLetra,'B',10).'MONTO EN LETRAS: '.mb_convert_encoding(numtoletras(number_format($reg[0]['totalpago'], 2, '.', '')), 'ISO-8859-1', 'UTF-8'),0,'J');
       $this->Ln();
    //######################### BLOQUE DATOS DE TOTALES #############################
}  
########################## FUNCION NOTA CREDITO (A4) ##############################

########################## FUNCION LISTAR NOTAS DE CREDITO ##############################
function TablaListarNotasCredito()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
    
    $tra = new Login();
    $reg = $tra->ListarNotasCreditos();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO GENERAL DE NOTAS DE CR�DITO',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(40,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,40,55,30,25,30,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipofacturaventa'])." N�: ".utf8_decode($reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechanota']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO ##############################

########################## FUNCION LISTAR NOTAS DE CREDITO POR CAJAS ##############################
function TablaListarNotasxCajas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
    
    $tra = new Login();
    $reg = $tra->BuscarNotasCreditosxCajas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE NOTAS DE CR�DITO POR CAJAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,5,"N.CAJA: ".utf8_decode($reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"RESPONSABLE DE CAJA: ".portales(utf8_decode($reg[0]["nombres"])),0,0,'L'); 
    $this->Ln();
    $this->Cell(335,5,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(40,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,40,55,30,25,30,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipofacturaventa'])." N�: ".utf8_decode($reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechanota']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO POR CAJAS ##############################

########################## FUNCION LISTAR NOTAS DE CREDITO POR FECHAS ##############################
function TablaListarNotasxFechas()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
    
    $tra = new Login();
    $reg = $tra->BuscarNotasCreditosxFechas();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE NOTAS DE CR�DITO POR FECHAS',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(335,5,"DESDE: ".date("d/m/Y", strtotime($_GET["desde"])),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"HASTA: ".date("d/m/Y", strtotime($_GET["hasta"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(40,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(40,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(55,8,'DESCRIPCI. DE CLIENTE',1,0,'C', True);
    $this->Cell(30,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(30,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,40,40,55,30,25,30,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipofacturaventa'])." N�: ".utf8_decode($reg[$i]["facturaventa"]),utf8_decode($reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechanota']))),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(180,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO POR FECHAS ##############################

########################## FUNCION LISTAR NOTAS DE CREDITO POR CLIENTES ##############################
function TablaListarNotasxClientes()
{
    ###################### DETALLE DE IMPUESTO ######################
    $imp           = new Login();
    $imp           = $imp->ImpuestosPorId();
    $NomImpuesto   = (empty($imp) ? "IMP." : $imp[0]['nomimpuesto']);
    $ValorImpuesto = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    ###################### DETALLE DE IMPUESTO ######################
    
    $tra = new Login();
    $reg = $tra->BuscarNotasCreditosxClientes();
    
    $this->SetFont('Courier','B',14);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(335,10,'LISTADO DE NOTAS DE CR�DITO POR CLIENTES',0,0,'C');

    if($_SESSION['acceso'] == "administradorG" && !empty($reg)){

        $this->Ln();
        $this->Cell(335,6,"N.DE SUCURSAL: ".$reg[0]["cuitsucursal"],0,0,'L');
        $this->Ln();
        $this->Cell(335,6,"SUCURSAL: ".portales(utf8_decode($reg[0]["nomsucursal"])),0,0,'L'); 
        $this->Ln();
        $this->Cell(335,6,"ENCARGADO SUCURSAL: ".portales(utf8_decode($reg[0]["nomencargado"])),0,0,'L'); 
    }

    $this->Ln();
    $this->Cell(330,6,"N.DE ".utf8_decode($documento = ($reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']).": ".$reg[0]["dnicliente"]),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"NOMBRE DE CLIENTE: ".utf8_decode($reg[0]['nomcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"N.DE TELEFONO: ".utf8_decode($reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']),0,0,'L');
    $this->Ln();
    $this->Cell(330,6,"DIRECCI. DOMICILIARIA: ".utf8_decode($reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']),0,0,'L');
    $this->Ln();
    $this->Cell(335,5,"CORREO ELECTRONICO: ".portales(utf8_decode($reg[0]["emailcliente"] == "" ? "********" : $reg[0]["emailcliente"])),0,0,'L');

    $this->Ln(10);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es BLANCO)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es AZUL)
    $this->Cell(15,8,'N�',1,0,'C', True);
    $this->Cell(30,8,'N.DE FACTURA',1,0,'C', True);
    $this->Cell(35,8,'N.DE DOCUMENTO',1,0,'C', True);
    $this->Cell(35,8,'FECHA EMISI.',1,0,'C', True);
    $this->Cell(70,8,'DETALLES DE PRODUCTOS',1,0,'C', True);
    $this->Cell(25,8,'N.ARTIC.',1,0,'C', True);
    $this->Cell(25,8,'DESCONTADO',1,0,'C', True);
    $this->Cell(35,8,'SUBTOTAL',1,0,'C', True);
    $this->Cell(30,8,'TOTAL '.$NomImpuesto,1,0,'C', True);
    $this->Cell(35,8,'TOTAL',1,1,'C', True);

    if($reg==""){
    echo "";      
    } else {
 
     /* AQUI DECLARO LAS COLUMNAS */
    $this->SetWidths(array(15,30,35,35,70,25,25,35,30,35));

    /* AQUI AGREGO LOS VALORES A MOSTRAR EN COLUMNAS */
    $a=1;
    $TotalArticulos = 0;
    $TotalDescuento = 0;
    $TotalSubtotal  = 0;
    $TotalIva       = 0;
    $TotalImporte   = 0;

    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    
    $TotalArticulos += $reg[$i]['articulos'];
    $TotalDescuento += $reg[$i]['descontado']+$reg[$i]['totaldescuento'];
    $TotalSubtotal  += $reg[$i]['subtotal'];
    $TotalIva       += ($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva']);
    $TotalImporte   += $reg[$i]['totalpago'];

    $this->SetFont('Courier','',10);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Row(array($a++,utf8_decode($tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_NOTACREDITO" ? "FACTURA" : "TICKET"))." N�: ".utf8_decode($reg[$i]["codfactura"]),utf8_decode($reg[$i]['tipofacturaventa'])." N�: ".utf8_decode($reg[$i]["facturaventa"]),utf8_decode(date("d/m/Y",strtotime($reg[$i]['fechanota']))),utf8_decode(str_replace("<br>","\n", $reg[$i]['detalles_productos'])),utf8_decode(number_format($reg[$i]["articulos"], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['descontado']+$reg[$i]['totaldescuento'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['subtotal'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]["exonerado"] == 2 ? "0.00" : $reg[$i]['totaliva'], 2, '.', ',')),utf8_decode($simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','))));
    }
   
    $this->Cell(185,5,'',0,0,'C');
    $this->SetFont('courier','B',10);
    $this->SetTextColor(255,255,255);  // Establece el color del texto (en este caso es blanco)
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(25,5,utf8_decode(number_format($TotalArticulos, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(25,5,utf8_decode($simbolo.number_format($TotalDescuento, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalSubtotal, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(30,5,utf8_decode($simbolo.number_format($TotalIva, 2, '.', ',')),0,0,'L');
    $this->CellFitSpace(35,5,utf8_decode($simbolo.number_format($TotalImporte, 2, '.', ',')),0,0,'L');
    $this->Ln();

    }

    $this->Ln(12); 
    $this->SetFont('courier','B',10);
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'ELABORADO: '.utf8_decode($_SESSION["nombres"]),0,0,'');
    $this->Cell(125,6,'RECIBIDO:_____________________________________',0,0,'');
    $this->Ln();
    $this->Cell(5,6,'',0,0,'');
    $this->Cell(200,6,'FECHA/HORA: '.date('d-m-Y H:i:s'),0,0,'');
    $this->Cell(125,6,'',0,0,'');
    $this->Ln(4);
}
########################## FUNCION LISTAR NOTAS DE CREDITO POR CLIENTES ##############################

############################################ REPORTES DE NOTAS CREDITOS ############################################


 // FIN Class PDF
}
?>