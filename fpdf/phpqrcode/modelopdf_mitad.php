<?php
$utf8_text = iconv("ISO-8859-1", "UTF-8", $iso_8859_1_text);
########################## FUNCION GUIA PREVENTA ##############################
function GuiaPreventaxFechas()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = (empty($imp) ? "IMPUESTO" : $imp[0]['nomimpuesto']);
        
    $tra = new Login();
    $reg = $tra->BuscarProductosPreventas();

    $logo = ( file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png") == "" ? "assets/images/null.png" : "fotos/sucursales/".$reg[0]['cuitsucursal'].".png");
    $logo2 = ( file_exists("fotos/logo_pdf2.png") == "" ? "assets/images/null.png" : "fotos/logo_pdf2.png");

    $this->Ln(2);
    $this->SetFont('Courier','B',12);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(255, 118, 118); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(55,5,$this->Image($logo, $this->GetX()+$GLOBALS['logo1_vertical_X'], $this->GetY()+$GLOBALS['logo1_vertical_Y'], $GLOBALS['logo1_vertical']),0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['nomsucursal'])),0,0,'C');
    $this->Cell(55,5,$this->Image($logo2, $this->GetX()+$GLOBALS['logo2_vertical_X'], $this->GetY()+$GLOBALS['logo2_vertical_Y'], $GLOBALS['logo2_vertical']),0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['documsucursal'] == '0' ? "" : $reg[0]['documento'])." ".utf8_decode($reg[0]['cuitsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    if($reg[0]['id_departamento']!='0'){

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']))),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    }

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,portales(utf8_decode($reg[0]['direcsucursal'])),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,"Nº TLF: ".utf8_decode($reg[0]['tlfsucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');

    $this->Ln();
    $this->Cell(55,5,"",0,0,'C');
    $this->CellFitSpace(80,5,utf8_decode($reg[0]['correosucursal']),0,0,'C');
    $this->Cell(55,5,"",0,0,'C');
    $this->Ln(5);

    $this->SetFont('Courier','B',12);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->Cell(190,14,'GUIA DE REMISIÓN',0,0,'C');

    $this->Ln();
    $this->SetFont('courier','B',9);
    $this->SetTextColor(255,255,255); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(255,118,118); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(25,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(70,8,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(25,8,"PRESENTACIÓN", 1, 0, 'C', True);
    $this->Cell(20,8,'MARCA',1,0,'C', True);
    $this->Cell(20,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,1,'C', True);
    ############################### BLOQUE N° 5 #####################################


    ############################### BLOQUE N° 6 #####################################
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,25,70,25,20,20,20));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){ 
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);
    $cantidad += $reg[$i]['cantidad'];
    $valortotal = $reg[$i]["precioventa"]*$reg[$i]["cantidad"];

    $this->SetX(10);
    $this->SetFont('Courier','B',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($modelo = ($reg[$i]["codmodelo"] == '' ? "*********" : $reg[$i]["nommodelo"])),
        utf8_decode(number_format($reg[$i]["cantidad"], 2, '.', ','))));
    }
    ############################### BLOQUE N° 6 #####################################

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
########################## FUNCION GUIA PREVENTA ##############################

########################## FUNCION GUIA PREVENTA ##############################
function GuiaPreventaxFechas2()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = (empty($imp) ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $con = new Login();
    $con = $con->ConfiguracionPorId();
            
    $tra = new Login();
    $reg = $tra->BuscarProductosPreventas();

    ######################### BLOQUE N° 1 ######################### 
   //Bloque de membrete principal
    $this->SetFillColor(229);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 10, 245, 24, '1.5', '');
    
    //Linea de membrete Nro 1
    $this->SetFont('courier','B',14);
    $this->SetXY(12, 12);
    $this->Cell(20, 5, utf8_decode($reg[0]['nomsucursal']), 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 16);
    $this->Cell(20, 5, 'DIREC. MATRIZ:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(47, 16);
    $this->Cell(20, 5,utf8_decode(utf8_decode($provincia = ($reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'])), 0 , 0);
    
    //Linea de membrete Nro 3
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 20);
    $this->Cell(20, 5, 'DIREC. SUCURSAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(52, 20);
    $this->Cell(20, 5,utf8_decode(utf8_decode($provincia = ($reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal'])), 0 , 0);
    
    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 24);
    $this->Cell(20, 5, 'CONTRIBUYENTE ESPECIAL:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(65, 24);
    $this->Cell(20, 5,utf8_decode($reg[0]['direcsucursal']), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',10);
    $this->SetXY(12, 28);
    $this->Cell(20, 5, 'OBLIGADO A LLEVAR CONTABILIDAD:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(82, 28);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    ######################### BLOQUE N° 1 ######################### 


    ############################### BLOQUE N° 2 ##################################### 
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
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

  //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 41);
    $this->Cell(90, 5, 'RAZÓN SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 41);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 45);
    $this->Cell(90, 5, 'PLACA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 45);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

     //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 45);
    $this->Cell(20, 5, 'N° DE BULTOS :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 45);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

      //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 49);
    $this->Cell(20, 5, 'PUNTO DE PARTIDA:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 49);
    $this->Cell(20, 5,utf8_decode($provincia = ($reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia'])." ".$departamento = ($reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento'])." ".$reg[0]['direcsucursal']), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 53);
    $this->Cell(20, 5, 'FECHA INICIO TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 53);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 53);
    $this->Cell(20, 5, 'FECHA FIN TRANSPORTE:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(220, 53);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    ############################### BLOQUE N° 2 ##################################### 


    ############################### BLOQUE N° 3 ##################################### 
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
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 63);
    $this->Cell(20, 5, 'FECHA EMISIÓN :', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(210, 63);
    $this->Cell(20, 5,utf8_decode(date("d-m-Y")), 0 , 0);

    //Linea de membrete Nro 3
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 67);
    $this->Cell(70, 5, 'NÚMERO DE AUTORIZACIÓN:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 67);
    $this->Cell(75, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 67);
    $this->Cell(20, 5, 'RUTA:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 67);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 4
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 71);
    $this->Cell(90, 5, 'MOTIVO DE TRASLADO:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 71);
    $this->Cell(90, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 71);
    $this->Cell(20, 5, 'CIUDAD:', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(192, 71);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 5
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 75);
    $this->Cell(20, 5, 'RAZÓN SOC / NOMBRE Y APELLIDOS:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 75);
    $this->Cell(20, 5,utf8_decode($reg[0]['nomencargado']), 0 , 0);

    //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(178, 75);
    $this->Cell(20, 5, 'IDENTIF. (DESTINATARIO):', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(227, 75);
    $this->Cell(20, 5,utf8_decode($reg[0]['dniencargado']), 0 , 0);

    //Linea de membrete Nro 6
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 79);
    $this->Cell(20, 5, 'ESTABLECIMIENTO:', 0 , 0);
    $this->SetFont('courier','',9);
    $this->SetXY(78, 79);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

   //Linea de membrete Nro 7
    $this->SetFont('courier','B',9);
    $this->SetXY(12, 83);
    $this->Cell(20, 5, 'DESTINO (PUNTO DE LLEGADA):', 0 , 0);
    $this->SetFont('courier','B',9);
    $this->SetXY(78, 83);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);
    
    ############################### BLOQUE N° 3 #####################################


    ############################### BLOQUE N° 4 ##################################### 
    //Bloque de membrete principal
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(257, 10, 88, 79, '1.5', '');
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 16);
    $this->Cell(20, 5, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetFont('courier','',14);
    $this->SetXY(295, 16);
    $this->Cell(20, 5,utf8_decode($reg[0]['cuitsucursal']), 0 , 0);

    //Linea de membrete Nro 1
    $this->SetFont('courier','B',18);
    $this->SetXY(258, 28);
    $this->Cell(20, 5,"GUIA DE REMISIÓN", 0 , 0);
    
    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 38);
    $this->Cell(20, 5, 'N°:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(268, 38);
    $this->Cell(20, 5,utf8_decode(""), 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 48);
    $this->Cell(20, 5, 'AMBIENTE:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 48);
    $this->Cell(20, 5,"PRODUCCIÓN", 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 54);
    $this->Cell(20, 5, 'EMISIÓN:', 0 , 0);
    $this->SetFont('courier','B',14);
    $this->SetXY(286, 54);
    $this->Cell(20, 5,utf8_decode("NORMAL"), 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 66);
    $this->Cell(20, 5, 'CLAVE ACCESO - N° DE AUTORIZ:', 0 , 0);

    //Linea de membrete Nro 2
    $this->SetFont('courier','B',14);
    $this->SetXY(258, 76);
    $this->Codabar(260,75,utf8_decode(""));
    $this->Ln(10);
    ############################### BLOQUE N° 4 ##################################### 


    ############################### BLOQUE N° 5 ##################################### 
    //Bloque Cuadro de Detalles de Productos
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.1);
    $this->RoundedRect(10, 92, 335, 110, '0', '');

    $this->Ln(6);
    $this->SetFont('courier','B',10);
    $this->SetTextColor(3, 3, 3); // Establece el color del texto (en este caso es Negro)
    $this->SetFillColor(229, 229, 229); // establece el color del fondo de la celda (en este caso es GRIS)
    $this->Cell(10,8,'N°',1,0,'C', True);
    $this->Cell(40,8,'CÓDIGO',1,0,'C', True);
    $this->Cell(130,8,'DESCRIPCIÓN DE PRODUCTO',1,0,'C', True);
    $this->Cell(45, 8,"PRESENTACIÓN", 1, 0, 'C', True);
    $this->Cell(45,8,'MARCA',1,0,'C', True);
    $this->Cell(45,8,'MODELO',1,0,'C', True);
    $this->Cell(20,8,'CANTIDAD',1,1,'C', True);
    ############################### BLOQUE N° 5 #####################################


    ############################### BLOQUE N° 6 #####################################
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(10,40,130,45,45,45,20));

    $a=1;
    for($i=0;$i<sizeof($reg);$i++){
    $simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']); 
    $cantidad += $reg[$i]['cantidad'];
    $valortotal = $reg[$i]["precioventa"]*$reg[$i]["cantidad"];

    $this->SetX(10);
    $this->SetFont('Courier','',8);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,
        utf8_decode($reg[$i]["codproducto"]),
        portales(utf8_decode($reg[$i]["producto"]." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "\n".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "\nIMEI: ".$reg[$i]["imei"] : ""))),
        utf8_decode($reg[$i]["nompresentacion"]),
        utf8_decode($reg[$i]['codmarca'] == '0' ? "******" : $reg[$i]["nommarca"]),
        utf8_decode($modelo = ($reg[$i]["nommodelo"] == '' ? "*********" : $reg[$i]["nommodelo"])),
        utf8_decode(number_format($reg[$i]["cantidad"], 2, '.', ','))));
    }
    ############################### BLOQUE N° 6 #####################################  
}
########################## FUNCION GUIA PREVENTA ##############################

########################### REPORTES DE PREVENTAS ############################





########################## FUNCION FACTURA VENTA (MITAD) #############################
function FacturaVenta2()
{
    $logo = ( file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png") == "" ? "assets/images/null.png" : "fotos/sucursales/".$reg[0]['cuitsucursal'].".png");

    $this->Image($logo, 10, 4.5, 20, 10, "PNG");

    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']); 
        
    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['id_departamento']!='0'){
    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia'])), 0,1);
    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'FACTURA DE VENTA', 0 , 0);


    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE FACTURA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codfactura']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE AUTORIZACIÓN:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codautorizacion']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE SERIE:', 0, 0);
    $this->SetXY(48, 22);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codserie']), 0, 0);

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documcliente'] == '' ? "DOC: " : $reg[0]['documento'].": ").$dni = ($reg[0]['dnicliente'] == '' ? "**********" : $reg[0]['dnicliente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direccliente'] == '' ? "**********" : $reg[0]['direccliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfcliente'] == '' ? "**********" : $reg[0]['tlfcliente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : "").$imei = ($detalle[$i]["imei"] != "" ? "\nIMEI: ".$detalle[$i]["imei"] : ""))),utf8_decode(number_format($detalle[$i]['cantventa'], 2, '.', ',')),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
       
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3.5,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'Nº DE CAJA: '.utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CAJERO(A): '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,$impuesto == '' ? "IMPUESTO" : "".$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CONDICIÓN DE PAGO: '.utf8_decode($reg[0]['tipopago']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['detalles_medios'] : "VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])))),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3.5,'',0,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3.5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,0,'L');
    $this->Ln();
}  
########################## FUNCION FACTURA VENTA (MITAD) ##############################

########################## FUNCION BOLETA VENTA (MITAD) #############################
function BoletaVenta2()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);

    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 10, 4.5, 20, 10, "PNG");
    //$this->Ln(6);

    }

    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['id_departamento']!='0'){
    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($departamento = ($reg[0]['id_departamento'] == '0' ? " " : $reg[0]['departamento'])." ".$provincia = ($reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia'])), 0,1);
    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'BOLETA DE VENTA', 0 , 0);


    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE NOTA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codfactura']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE AUTORIZACIÓN:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codautorizacion']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'NÚMERO DE SERIE:', 0, 0);
    $this->SetXY(48, 22);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['codserie']), 0, 0);

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE VENTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documcliente'] == '' ? "DOC: " : $reg[0]['documento'].": ").$dni = ($reg[0]['dnicliente'] == '' ? "**********" : $reg[0]['dnicliente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direccliente'] == '' ? "**********" : $reg[0]['direccliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfcliente'] == '' ? "**********" : $reg[0]['tlfcliente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : "").$imei = ($detalle[$i]["imei"] != "" ? "\nIMEI: ".$detalle[$i]["imei"] : ""))),utf8_decode(number_format($detalle[$i]['cantventa'], 2, '.', ',')),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3.5,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'Nº DE CAJA: '.utf8_decode($reg[0]['nrocaja']."-".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CAJERO(A): '.utf8_decode($reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CONDICIÓN DE PAGO: '.utf8_decode($reg[0]['tipopago']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,utf8_decode($medio = ($reg[0]['tipopago'] == 'CONTADO' ? $reg[0]['detalles_medios'] : "VENCIMIENTO: ".date("d/m/Y",strtotime($reg[0]['fechavencecredito'])))),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3.5,'',0,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3.5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,0,'L');
    $this->Ln();
}  
########################## FUNCION NOTA VENTA (MITAD) ##############################

########################## FUNCION FACTURA VENTA (PREIMPRESA) #############################
function FacturaVenta_Preimpresa()
{   
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
    $valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

    $tra = new Login();
    $reg = $tra->VentasPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
    $TipoLetra = "Courier";

    //######################### BLOQUE DATOS DE SUCURSAL #############################
    //$this->RoundedRect(10, 26, 190, 0, '0', "");
    
    $this->SetFont($TipoLetra,'B',14);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(8.5,39);
    $this->CellFitSpace(162, 6," ", 0, 0); //Membrete Nro 1
    $this->SetFont($TipoLetra,'B',12);
    $this->CellFitSpace(12, 6,date("d",strtotime($reg[0]['fechaventa'])), 0, 0, 'C'); //Membrete Nro 1
    $this->CellFitSpace(12, 6,date("m",strtotime($reg[0]['fechaventa'])), 0, 0, 'C'); //Membrete Nro 1
    $this->CellFitSpace(12, 6,substr(date("Y",strtotime($reg[0]['fechaventa'])),2), 0, 1, 'C'); //Membrete Nro 1 
    //######################### BLOQUE DATOS DE SUCURSAL #############################

    //######################### BLOQUE DATOS DE CLIENTE #############################
    $this->SetFont($TipoLetra,'B',12);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(8.5,46);
    $this->CellFitSpace(24, 7," ", 0, 0, 'C'); //Membrete Nro 1
    $this->CellFitSpace(175, 7,mb_convert_encoding($reg[0]['nomcliente'] == "" ? " " : $reg[0]['nomcliente'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L'); //Membrete Nro 1
    $this->Setx(8.5);
    $this->CellFitSpace(24, 7," ", 0, 0, 'C'); //Membrete Nro 1
    $this->CellFitSpace(175, 7,mb_convert_encoding($reg[0]['direccliente'] == "" ? " " : $reg[0]['direccliente'], 'ISO-8859-1', 'UTF-8'), 0, 1, 'L'); //Membrete Nro 1
    //######################### BLOQUE DATOS DE CLIENTE #############################

    //######################### BLOQUE DATOS DE PRODUCTOS #############################
    $this->Ln(2);
    $this->SetX(8.5);
    $this->SetFont($TipoLetra,'B',10);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(0,0,0); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(17,7,' ',0,0,'C', False);
    $this->Cell(127.5,7,' ',0,0,'C', False);
    $this->Cell(18,7,' ',0,0,'C', False);
    $this->Cell(25,7,' ',0,0,'C', False);
    $this->Cell(11,7,' ',0,1,'C', False);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesVentas();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(17,127.5,18,25,11));
    $this->SetAligns(array('C','L','R','C'));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->Setx(8.5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetLineWidth(.2);
    $this->SetFont($TipoLetra,"",10);  
    $this->RowFacturePreimpreso(array(number_format($detalle[$i]['cantventa'], 2, '.', ','),
        mb_convert_encoding($detalle[$i]["producto"]." ".$detalle[$i]["condicion"].$descripcion = ($detalle[$i]["producto"] != "" ? "\n".$detalle[$i]["descripcion"] : "").$imei = ($detalle[$i]["imei"] != "" ? "\nIMEI: ".$detalle[$i]["imei"] : ""), 'ISO-8859-1', 'UTF-8'),
        number_format($detalle[$i]["precioventa"], 2, '.', ','),
        number_format($detalle[$i]['valorneto'], 2, '.', ','),""));
    }
    //######################### BLOQUE DATOS DE PRODUCTOS #############################

    //######################### BLOQUE DATOS DE TOTAL #############################
    $this->SetXY(8.5,248);
    $this->SetFont($TipoLetra,'B',14);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->CellFitSpace(164, 6," ", 0, 0, 'R'); //Membrete Nro 1
    $this->SetFont($TipoLetra,'B',12);
    $this->CellFitSpace(35, 6,number_format($reg[0]["totalpago"], 2, '.', ','), 0, 1, 'L'); //Membrete Nro 1
    //######################### BLOQUE DATOS DE TOTAL #############################
}
########################## FUNCION FACTURA VENTA (PREIMPRESA) #############################


########################## FUNCION NOTA DE CREDITO (MITAD) #############################
function NotaCredito2()
{
    $imp = new Login();
    $imp = $imp->ImpuestosPorId();
    $impuesto = (empty($imp) ? "IMPUESTO" : $imp[0]['nomimpuesto']);

    $tra = new Login();
    $reg = $tra->NotaCreditoPorId();
    $simbolo = ($reg[0]['simbolo'] == "" ? "" : $reg[0]['simbolo']);
   
    if (file_exists("fotos/sucursales/".$reg[0]['cuitsucursal'].".png")) {

    $logo = "fotos/sucursales/".$reg[0]['cuitsucursal'].".png";
    $this->Image($logo, 10, 4.5, 20, 10, "PNG");
    $this->Ln(6);

    }
        
    //Bloque datos de empresa
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(5, 15, 42, 25, '1.5', "");
    
    $this->SetFont('Courier','BI',8);
    $this->SetTextColor(3,3,3); // Establece el color del texto (en este caso es Negro)
    $this->SetXY(5, 15);
    $this->CellFitSpace(42, 5,utf8_decode($reg[0]['nomsucursal']), 0, 1); //Membrete Nro 1

    $this->SetFont('Courier','B',6);
    if($reg[0]['id_departamento']!='0'){
    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($departamento = ($reg[0]['departamento'] == '' ? "" : $reg[0]['departamento'])." ".$provincia = ($reg[0]['provincia'] == '' ? "" : $reg[0]['provincia'])), 0,1);
    }

    $this->SetX(5);
    $this->CellFitSpace(42, 3,$reg[0]['direcsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº DE ACTIVIDAD: '.$reg[0]['nroactividadsucursal'], 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'Nº TLF: '.utf8_decode($reg[0]['tlfsucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,utf8_decode($reg[0]['correosucursal']), 0,1);

    $this->SetX(5);
    $this->CellFitSpace(42, 3,'OBLIGADO A LLEVAR CONTABILIDAD: '.utf8_decode($reg[0]['llevacontabilidad']), 0 , 0); 
      
    //Bloque datos de factura
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.3);
    $this->RoundedRect(48, 5, 57, 35, '1.5', "");

    $this->SetFont('Courier','B',10);
    $this->SetXY(48, 4);
    $this->Cell(5, 7, 'NOTA DE CRÉDITO', 0 , 0);


    $this->SetFont('Courier','B',7);
    $this->SetXY(48, 7);
    $this->Cell(5, 7, 'Nº DE '.$documento = ($reg[0]['documsucursal'] == '0' ? "REG.:" : $reg[0]['documento'].":"), 0 , 0);
    $this->SetXY(78, 7);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['cuitsucursal']), 0, 0);

    $this->SetXY(48, 10);
    $this->SetFont('Courier','B',8);
    $this->Cell(5, 7, 'Nº DE NOTA', 0 , 0);
    $this->SetXY(78, 10);
    $this->CellFitSpace(28, 7,utf8_decode($reg[0]['codfactura']), 0, 0);

    $this->SetXY(48, 13);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'Nº DE DOCUMENTO:', 0, 0);
    $this->SetXY(48, 16);
    $this->CellFitSpace(56, 7,utf8_decode($reg[0]['facturaventa']), 0, 0);

    $this->SetXY(48, 19);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'MOTIVO DE NOTA:', 0, 0);
    $this->SetXY(48, 22);
    $this->MultiCell(56,7,$this->SetFont('Courier','',6).utf8_decode($reg[0]["observaciones"]=="" ? "" : $reg[0]["observaciones"]), 0,'J');

    $this->SetXY(48, 25);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE AUTORIZACIÓN:", 0, 0);
    $this->SetXY(78, 25);
    $this->Cell(28, 7,$fecha = ($reg[0]['fechaautorsucursal'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal']))), 0, 0);

    $this->SetXY(48, 28);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,"FECHA DE NOTA:", 0, 0);
    $this->SetXY(78, 28);
    $this->Cell(28, 7,date("d-m-Y H:i:s",strtotime($reg[0]['fechanota'])), 0, 0);


    $this->SetXY(48, 31);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'AMBIENTE: ', 0 , 0);
    $this->SetXY(78, 31);
    $this->Cell(28, 7,'PRODUCCIÓN', 0 , 0);

    $this->SetXY(48, 34);
    $this->SetFont('Courier','B',6);
    $this->Cell(5, 7,'EMISIÓN: ', 0 , 0);
    $this->SetXY(78, 34);
    $this->Cell(28, 7,'NORMAL', 0 , 0);
     
    //Bloque datos de cliente
    $this->SetLineWidth(0.3);
    $this->SetFillColor(192);
    $this->RoundedRect(5, 41, 100, 10, '1.5', "");
    $this->SetFont('Courier','B',6);

    $this->SetXY(6, 40.2);
    $this->CellFitSpace(66, 5,'RAZÓN SOCIAL: '.utf8_decode($reg[0]['codcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE '.$documento = ($reg[0]['documcliente'] == '' ? "DOC: " : $reg[0]['documento'].": ").$dni = ($reg[0]['dnicliente'] == '' ? "**********" : $reg[0]['dnicliente']), 0, 0);

    $this->SetXY(6, 43.2);
    $this->CellFitSpace(66, 5,'DIRECCIÓN: '.utf8_decode($reg[0]['direccliente'] == '' ? "**********" : $reg[0]['direccliente']), 0, 0);
    $this->CellFitSpace(32, 5,'Nº DE TLF: '.($reg[0]['tlfcliente'] == '' ? "**********" : $reg[0]['tlfcliente']), 0, 0);

    $this->SetXY(6, 46.2);
    $this->CellFitSpace(92, 5,'EMAIL: '.utf8_decode($reg[0]['emailcliente'] == '' ? "**********" : $reg[0]['emailcliente']), 0, 0);

    $this->Ln(6);
    $this->SetX(5);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->Cell(5,3,'N°',1,0,'C', True);
    $this->Cell(50,3,'DESCRIPCIÓN',1,0,'C', True);
    $this->Cell(12,3,'CANTIDAD',1,0,'C', True);
    $this->Cell(14,3,'PRECIO',1,0,'C', True);
    $this->Cell(19,3,'IMPORTE',1,1,'C', True);
    
    $tra = new Login();
    $detalle = $tra->VerDetallesNotasCredito();
    $cantidad = 0;
    $SubTotal = 0;

    $this->SetWidths(array(5,50,12,14,19));

    $a=1;
    for($i=0;$i<sizeof($detalle);$i++){ 
    $cantidad += $detalle[$i]['cantventa'];
    $valortotal = $detalle[$i]["precioventa"]*$detalle[$i]["cantventa"];
    $SubTotal += $detalle[$i]['valorneto'];

    $this->SetX(5);
    $this->SetFillColor(192);
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier',"",6);  
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es negro)
    $this->RowFacture(array($a++,portales(utf8_decode($detalle[$i]["producto"])),utf8_decode(number_format($detalle[$i]['cantventa'], 2, '.', ',')),utf8_decode(number_format($detalle[$i]["precioventa"], 2, '.', ',')),utf8_decode(number_format($detalle[$i]['valorneto'], 2, '.', ','))));
       
    }
     
    $this->Ln(1);
    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',8);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'INFORMACIÓN ADICIONAL',1,0,'C');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->CellFitSpace(20,3.5,'SUBTOTAL ',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CANTIDAD DE PRODUCTOS: '.number_format($cantidad, 2, '.', ','),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'GRAVADO ('.number_format($reg[0]["iva"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivasi"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'TIPO DE DOCUMENTO: NOTA DE CRÉDITO',1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'EXENTO (0%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["subtotalivano"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'FECHA DE EMISIÓN: '.date("d-m-Y H:i:s"),1,0,'L');

    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,$impuesto." (".number_format($reg[0]["iva"], 2, '.', ',')."%):",1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaliva"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'Nº DE CAJA: '.$caja = ($reg[0]['codcaja'] == 0 ? "**********" : $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESCONTADO %:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["descontado"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(59,3.5,'CAJERO: '.$cajero = ($reg[0]['codcaja'] == 0 ? "**********" : $reg[0]['nombres']),1,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->CellFitSpace(20,3.5,'DESC % ('.number_format($reg[0]["descuento"], 2, '.', ',').'%):',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totaldescuento"], 2, '.', ','),1,0,'R');
    $this->Ln();

    $this->SetX(5);
    $this->SetFillColor(245,245,245); // establece el color del fondo de la celda (en este caso es AZUL
    $this->SetDrawColor(3,3,3);
    $this->SetLineWidth(.2);
    $this->SetFont('Courier','B',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->Cell(59,3.5,'',0,0,'L');
    $this->Cell(2,3.5,"",0,0,'C');
    $this->SetFont('Courier','B',6);
    $this->Cell(20,3.5,'IMPORTE TOTAL:',1,0,'L', True);
    $this->CellFitSpace(19,3.5,$simbolo.number_format($reg[0]["totalpago"], 2, '.', ','),1,0,'R');
    $this->Ln(4);
    
    $this->SetX(5);
    $this->SetDrawColor(3,3,3);
    $this->SetFont('Courier','BI',6);
    $this->SetTextColor(3,3,3);  // Establece el color del texto (en este caso es blanco)
    $this->CellFitSpace(100,2,'MONTO EN LETRAS: '.utf8_decode(numtoletras(number_format($reg[0]['totalpago'], 2, '.', ''))),0,0,'L');
    $this->Ln();
}  
########################## FUNCION NOTA DE CREDITO (MITAD) ##############################

// FIN Class PDF
}
?>