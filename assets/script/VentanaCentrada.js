var ventana;

function VentanaCentrada(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
  
  if(window.screen)if(isCenter)if(isCenter=="true"){
    var myLeft = (screen.width-myWidth)/2;
    var myTop = (screen.height-myHeight)/2;
    features+=(features!='')?',':'';
    features+=',left='+myLeft+',top='+myTop;
  }
  ventana = window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);

  //setTimeout(ImprimirVentana,1000);//configurar tiempo en segundos
  //setTimeout(CerrarVentana,8000);//configurar tiempo en segundos (8 segundos)
}

function ImprimirVentana(){
  ventana.print();
}

function CerrarVentana(){
  ventana.close();
}