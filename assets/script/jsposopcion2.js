function Separador(x) {//SEPARADOR CON DECIMAL
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function DoAction(idproducto, codproducto, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle) {
    
    addItem(idproducto, codproducto, 1, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################
function DoActionPrecio(idproducto, codproducto, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle) 
{
    addItem(idproducto, codproducto, 0.00, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

function AsignaPrecio(id, codigo, tipodetalle, producto, opcionimei, imei, cantidad, precio2,descproducto)
{
  $("#agregaprecio #d_id").val(id);
  $("#agregaprecio #d_codigo").val(codigo);
  $("#agregaprecio #agrega_detalle_precio").load("detalles_productos?BuscaDetallesProductoxPrecio=si&variable=2&d_id="+id+"&d_codigo="+codigo+"&d_tipo="+tipodetalle+"&d_producto="+producto.replace(/[.(),;:!?%#$'\"+=\/\-“”’]*/g, "")+"&d_opcionimei="+opcionimei+"&d_imei="+imei+"&d_cantidad="+cantidad+"&d_precio="+precio2+"&d_descproducto="+descproducto);
}
// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################

// ####################### FUNCION PARA ASIGNAR IMEI A DETALLES #######################
function DoActionImei(idproducto, codproducto, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle) 
{
    addItem(idproducto, codproducto, 0.00, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

function AsignaImei(id, codigo, tipodetalle, producto, opcionimei, imei, cantidad, precio2,descproducto)
{
  $("#agregaimei #d_id").val(id);
  $("#agregaimei #d_codigo").val(codigo);
  $("#agregaimei #agrega_detalle_imei").load("detalles_productos?BuscaDetallesProductoxImei=si&variable=1&d_id="+id+"&d_codigo="+codigo+"&d_tipo="+tipodetalle+"&d_producto="+producto.replace(/[.(),;:!?%#$'\"+=\/\-“”’]*/g, "")+"&d_opcionimei="+opcionimei+"&d_imei="+imei+"&d_cantidad="+cantidad+"&d_precio="+precio2+"&d_descproducto="+descproducto);
}
// ####################### FUNCION PARA ASIGNAR IMEI A DETALLES #######################

//FUNCION PARA ENVIAR DETALLES DE IMEI
function CargaDetallesImei(){        

    var categorias = new Array();
    $("input[type=checkbox]:checked").each(function(){
        //cada elemento seleccionado            
        categorias.push($(this).val());
    });
    $("#detalles_imei").val(categorias);
}

$(document).ready(function() {

    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/
    $('#saveposopcion2').keypress(function(e){
        var keycode = (e.keyCode ? e.keyCode : e.which);   
        if (keycode == 13) {
            return false;
        }
    });
    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/

    /*############ FUNCION AGREGA POR CRITERIO ############*/
    $('#search_producto').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
          AgregaVentas();
          e.preventDefault();
          return false;
        }
    });
    /*############ FUNCION AGREGA POR CRITERIO ############*/

    /*############ FUNCION AGREGA POR LECTOR ############*/
    $('#search_producto_barra').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
            AgregaVentas();
            e.preventDefault();
            return false;
        }
    });

    $('#search_producto_barra').change(function(e) {        
        AgregaVentas();
        e.preventDefault();     
    });
    /*############ FUNCION AGREGA POR LECTOR ############*/

    $("#search_producto_barra").change(function(){
        let codeBar=$(this).val();
        $.ajax({    
            url: "class/busqueda_autocompleto.php?Busqueda_Producto_Barcode=si",
            data:{barcode:codeBar},      
            type : 'POST',   
            dataType : 'json',    
            success : function(json) {
                if (JSON.stringify(json[0])==null) {
                    return false;
                } 
                //console.log(json);
                $('#idproducto').val(json[0].idproducto);
                $('#codproducto').val(json[0].txtCodigo);
                $('#producto').val(json[0].producto);
                $('#descripcion').val((json[0].descripcion == "") ? "0" : json[0].descripcion);
                $('#opcionimei').val(json[0].imei);
                $('#imei').val("0");
                $('#condicion').val((json[0].condicion == "") ? "0" : json[0].condicion);
                $('#codmarca').val(json[0].codmarca);
                $('#marcas').val((json[0].codmarca == "0") ? "*****" : json[0].nommarca);
                $('#codmodelo').val(json[0].codmodelo);
                $('#modelos').val((json[0].codmodelo == "0") ? "*****" : json[0].nommodelo);
                $('#codpresentacion').val(json[0].codpresentacion);
                $('#presentacion').val((json[0].codpresentacion == "0") ? "******" : json[0].nompresentacion);
                $('#codcolor').val(json[0].codcolor);
                $('#color').val((json[0].codcolor == "0") ? "******" : json[0].nomcolor);
                $('#preciocompra').val(json[0].preciocompra);
                $('#precioventa').val(json[0].precioxpublico);
                $('#descproducto').val(json[0].descproducto);
                $('#posicionimpuesto').val((json[0].ivaproducto == "0") ? "0" : json[0].posicionimpuesto);
                $('#tipoimpuesto').val((json[0].ivaproducto == "0") ? "EXENTO" : json[0].nomimpuesto);
                $('#ivaproducto').val((json[0].ivaproducto == "0") ? "0" : json[0].valorimpuesto);
                $('#existencia').val(json[0].existencia);
                $('#precioconiva').val((json[0].ivaproducto == "0") ? "0.00" : json[0].precioxpublico);
                $("#tipodetalle").val("1");
                $("#cantidad").val("1");
                //$("#search_producto_barra").focus();
                //AgregaVentas();
                //asigno tiempo de agregar detalle
                setTimeout(function() {
                var e = jQuery.Event("keypress");
                e.which = 13;
                e.keyCode = 13;
                AgregaVentas();
                //e.preventDefault();
                }, 100);
            },
            error : function(error) {
                //console.log(error);
                swal("Oops", "Ha Ocurrido un Error en el procesamiento de informacion!", "error");
                //alert('Disculpe, Ha Ocurrido un Error en el procesamiento de informacion');
            }
        });
    });

function AgregaVentas () {
    var code = $('input#codproducto').val();
    var prod = $('input#producto').val();
    var cantp = $('input#cantidad').val();
    var exist = $('input#existencia').val();
    var prec = $('input#preciocompra').val();
    var prec2 = $('input#precioventa').val();
    var descuen = $('input#descproducto').val();
    var ivgprod = $('input#ivaproducto').val();
    var tipodetalle = $('input#tipodetalle').val();
    var er_num = /^([0-9])*[.]?[0-9]*$/;
    cantp = parseInt(cantp);
    exist = parseInt(exist);
    cantp = cantp;

    if (code == "") {
        $("#search_producto").focus();
        //$("#search_producto").css('border-color', '#ff7676');
        //swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO/SERVICIO CORRECTAMENTE!", "error");
        return false;
        
    } else if(prec2=="" || prec2=="0" || prec2=="0"){
        $("#precioventa").focus();
        $('#precioventa').css('border-color','#ff7676');
        $("#precioventa").val("");
        swal("Oops", "POR FAVOR INGRESE PRECIO DE VENTA VALIDO PARA PRODUCTO!", "error");  
        return false;
        
    } else if(!er_num.test($('#precioventa').val())){
        $("#precioventa").focus();
        $('#precioventa').css('border-color','#ff7676');
        $("#precioventa").val("");
        swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA!", "error");  
        return false;

    } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
        $("#cantidad").focus();
        $("#cantidad").css('border-color', '#ff7676');
        $("#precioventa").val("");
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN VENTAS!", "error");
        return false;

    } else if (isNaN($('#cantidad').val())) {
        $("#cantidad").focus();
        $("#cantidad").css('border-color', '#ff7676');
        $("#cantidad").val("");
        swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE VENTAS!", "error");
        return false;
        
   } else if(cantp > exist){
        $("#cantidad").focus();
        $('#cantidad').css('border-color','#ff7676');
        $("#existencia").focus();
        $('#existencia').css('border-color','#ff7676');
        swal("Oops", "LA CANTIDAD DE PRODUCTOS SOLICITADA NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
        return false;

    } else {

        var Carrito              = new Object();
        Carrito.Id               = $('input#idproducto').val();
        Carrito.Codigo           = $('input#codproducto').val();
        Carrito.Producto         = $('input#producto').val().replace(/[ '"]+/g, ' ');
        Carrito.Descripcion      = $('input#descripcion').val().replace(/[ '"]+/g, ' ');
        Carrito.OpcionImei       = $('input#opcionimei').val();
        Carrito.Imei             = $('input#imei').val();
        Carrito.Condicion        = $('input#condicion').val();
        Carrito.Codmarca         = $('input#codmarca').val();
        Carrito.Marcas           = $('input#marcas').val();
        Carrito.Codmodelo        = $('input#codmodelo').val();
        Carrito.Modelos          = $('input#modelos').val();
        Carrito.Codpresentacion  = $('input#codpresentacion').val();
        Carrito.Presentacion     = $('input#presentacion').val();
        Carrito.Codcolor         = $('input#codcolor').val();
        Carrito.Color            = $('input#color').val();
        Carrito.Precio           = $('input#preciocompra').val();
        Carrito.Precio2          = $('input#precioventa').val();
        Carrito.Descproducto     = $('input#descproducto').val();
        Carrito.PosicionImpuesto = ($('input#ivaproducto').val() == "0" ? "0" : $('input#posicionimpuesto').val());
        Carrito.TipoImpuesto     = $('input#tipoimpuesto').val();
        Carrito.Ivaproducto      = ($('input#ivaproducto').val() == "0" ? "0" : $('input#ivaproducto').val());
        Carrito.Existencia       = $('input#existencia').val();
        Carrito.Precioconiva     = $('input#precioconiva').val();
        Carrito.TipoDetalle      = $('input#tipodetalle').val();
        Carrito.Cantidad         = $('input#cantidad').val();
        Carrito.opCantidad       = '+=';
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritoventa.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var contador        = 0;
            var OperacionItems  = 0;
            var TotalDescuento  = 0;
            var Subtotal        = 0;
            var SubtotalExento  = 0;
            var BaseImpIva      = 0;
            var TotalIvaGeneral = 0;
            var TotalCompra     = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseFloat(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

            //CALCULO DEL TOTAL DE ITEMS
            var Items      = parseFloat(cantsincero);
            OperacionItems = parseFloat(OperacionItems) + parseFloat(Items);

            //CALCULO DEL TOTAL DE COMPRAS
            var OperacionCompra = parseFloat(item.precio) * parseFloat(item.cantidad);
            TotalCompra         = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

            //CALCULO DEL VALOR TOTAL
            var PrecioVenta = parseFloat(item.precio2);
            var ValorTotal  = parseFloat(item.precio2) * parseFloat(item.cantidad);

            //CALCULO DEL TOTAL DEL DESCUENTO %
            var DetalleDescuento = ValorTotal * item.descproducto / 100;
            TotalDescuento       = parseFloat(TotalDescuento) + parseFloat(DetalleDescuento);

            //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
            var descsiniva = item.precio2 * item.descproducto / 100;
            var descconiva = item.precioconiva * item.descproducto / 100;

            //CALCULO DE SUBTOTAL GENERAL
            var Operac    = parseFloat(item.precio2) - parseFloat(descsiniva);
            var Operacion = parseFloat(Operac) * parseFloat(item.cantidad);
            Subtotal      = parseFloat(Subtotal) + parseFloat(Operacion);

            //CALCULO DE BASE IMPONIBLE IVA
            var Operac3         = parseFloat(item.precioconiva) - parseFloat(descconiva);
            var Operacion3      = parseFloat(Operac3) * parseFloat(item.cantidad);
            var SubBaseImponIva = Operacion3.toFixed(2);

            //CALCULO VALOR DISCRIMINADO
            var iva = (item.ivaproducto != "0") ? item.ivaproducto : "0.00";
            var ValorImpuesto        = (iva <= 9) ? "1.0"+parseInt(iva) : "1."+parseInt(iva);
            var Discriminado         = parseFloat(Operac3) / ValorImpuesto;
            var SubtotalDiscriminado = parseFloat(Operac3) - parseFloat(Discriminado);
            var BaseDiscriminado     = parseFloat(SubtotalDiscriminado) * parseFloat(item.cantidad);
            TotalIvaGeneral          = parseFloat(TotalIvaGeneral) + parseFloat(BaseDiscriminado);

            //CALCULO DE SUBTOTAL IVA
            BaseImpIva = (item.ivaproducto != "0") ? parseFloat(BaseImpIva) + parseFloat(SubBaseImponIva) : parseFloat(BaseImpIva);
            SubtotalIva = parseFloat(BaseImpIva) - parseFloat(TotalIvaGeneral);

            //CALCULO DE SUBTOTAL EXENTO
            SubtotalExento = (item.ivaproducto != "0") ? parseFloat(SubtotalExento) : parseFloat(SubtotalExento) + parseFloat(Operacion);
                
            //OBTENGO TIPO DE CLIENTE
            var TipoCliente = $('input#exonerado').val();

            /*###################################################### CALCULO DE DESCUENTO ######################################################*/

            //PORCENTAJE DESCUENTO 
            var Descuento  = $('input#descuento').val();
            Porcentaje     = (Descuento > 100 ? "0.00" : Descuento/100);

            //PORCENTAJE IVA
            var txtIva     = $('input#iva').val();
            PorcentajeIva  = (txtIva > 100 ? "0.00" : txtIva/100);

            //CALCULO DE SUBTOTAL FACTURA
            SubTotalFactura = parseFloat(SubtotalExento) + parseFloat(SubtotalIva);

            /*OBTENGO DESCUENTO DE EXENTO*/
            RestoExento  = parseFloat(SubtotalExento.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
            ValorExento = (Descuento <= 0 ? parseFloat(SubtotalExento) : parseFloat(SubtotalExento) - parseFloat(RestoExento.toFixed(2)));

            /*OBTENGO SUBTOTAL IVA*/
            RestoSubtotalIva = parseFloat(SubtotalIva.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
            ValorSubtotalIva = (Descuento <= 0 ? parseFloat(SubtotalIva) : parseFloat(SubtotalIva) - parseFloat(RestoSubtotalIva.toFixed(2)));
            /*OBTENGO TOTAL IVA*/
            ValorTotalIva    = (Descuento <= 0 ? parseFloat(TotalIvaGeneral) : parseFloat(ValorSubtotalIva.toFixed(2)) * parseFloat(PorcentajeIva.toFixed(2)));

            /*OBTENGO TOTALES DE FACTURA*/
            TotalDescuentoGeneral = parseFloat(RestoExento.toFixed(2)) + parseFloat(RestoSubtotalIva.toFixed(2));
            SubtotalConImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2)) + parseFloat(ValorTotalIva.toFixed(2)); 
            SubtotalSinImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
            ValorSubTotalFactura  = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
            TotalFactura          = (TipoCliente == 2 ? parseFloat(SubtotalSinImpuesto.toFixed(2)) : parseFloat(SubtotalConImpuesto.toFixed(2)));
            /*###################################################### CALCULO DE DESCUENTO ######################################################*/
            
            var nuevaFila =
            "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                "<td>" +
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'-1'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.condicion + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.codcolor + "'," +
                "'" + item.color + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.existencia + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.tipodetalle + "', " +
                "'-'" +
                ')"' +
                " type='button'><span class='fa fa-minus'></span></button>" +
                "<input type='text' id='" + item.cantidad + "' class='bold' style='width:50px;height:28px;' value='" + item.cantidad + "'>" +
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'+1'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.condicion + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.codcolor + "'," +
                "'" + item.color + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.existencia + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.tipodetalle + "', " +
                "'+'" +
                ')"' +
                " type='button'><span class='fa fa-plus'></span></button></td>" +
                "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.codmarca == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.codmodelo == '0' ? '******' : item.modelos) + ")</small></td>" +
                "<td><strong>" + Separador(item.precio2) + "</strong></td>" +
                "<td><strong>" + Separador(DetalleDescuento.toFixed(2)) + "<sup>" + Separador(item.descproducto) + "%</sup></strong></td>" +
                "<td><strong>" + (item.ivaproducto == "0" ? item.tipoimpuesto : item.tipoimpuesto + ' (' + Separador(item.ivaproducto) + '%)') + "</strong></td>" +
                "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                "<td>" +
                
                '<span class="text-info" title="Asignar Imei" style="cursor:pointer;color:#fff;" ' +
                'onclick="AsignaImei(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.tipodetalle + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImei" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span> ' +

                '<span class="text-success" title="Editar Detalle" style="cursor:pointer;color:#fff;" ' +

                'onclick="AsignaPrecio(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.tipodetalle + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></span> ' +
                    
                '<span class="text-danger" title="Eliminar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'0'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.condicion + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.codcolor + "'," +
                "'" + item.color + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.existencia + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.tipodetalle + "', " +
                "'='" +
                ')"' +
                ' title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>' +
                "</td>" +
                "</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                            
                    $("#lblitems").text(Separador(OperacionItems.toFixed(2)));
                    $("#lblsubtotal").text(Separador(ValorSubTotalFactura.toFixed(2)));
                    $("#lblexonerado").text(Separador((TipoCliente == 2 ? ValorSubTotalFactura.toFixed(2) : "0.00")));
                    $("#lblexento").text(Separador((TipoCliente != 2 ? ValorExento.toFixed(2) : "0.00")));
                    $("#lblsubtotaliva").text(Separador((TipoCliente != 2 ? ValorSubtotalIva.toFixed(2) : "0.00")));
                    $("#lbliva").text(Separador((TipoCliente != 2 ? ValorTotalIva.toFixed(2) : "0.00")));
                    $("#lbldescontado").text(Separador(TotalDescuento.toFixed(2)));
                    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
                    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
                    
                    $("#txtsubtotal").val(ValorSubTotalFactura.toFixed(2));
                    $("#txtsubtotal2").val(SubTotalFactura.toFixed(2));
                    $("#txtexonerado").val((TipoCliente == 2 ? ValorSubTotalFactura.toFixed(2) : "0.00"));
                    $("#txtexonerado2").val((TipoCliente == 2 ? SubTotalFactura.toFixed(2) : "0.00"));
                    $("#txtexento").val(ValorExento.toFixed(2));
                    $("#txtexento2").val(SubtotalExento.toFixed(2));
                    $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));
                    $("#txtsubtotaliva2").val(SubtotalIva.toFixed(2));
                    $("#txtIva").val(ValorTotalIva.toFixed(2));
                    $("#txtIva2").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    $("#txtPagado").val(TotalFactura.toFixed(2));
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));
                            
                    /*####### ACTIVAR BOTON DE PAGO #######*/
                    $("#buttonpago").attr('disabled', false);
                    $("#submit_guardar").attr('disabled', false);
                    $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
                    $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
                    $("#montopagado").val(TotalFactura.toFixed(2));

                    }
                });

                $("#search_busqueda").focus();
                //$("#search_producto").focus();
                LimpiarTexto();
            },
            "json"
        );
        return false;
    }
}

/* CANCELAR LOS ITEM AGREGADOS EN REGISTRO */
$("#vaciar").click(function() {
        var Carrito             = new Object();
        Carrito.Id              = "vaciar";
        Carrito.Codigo          = "vaciar";
        Carrito.Producto        = "vaciar";
        Carrito.Descripcion     = "vaciar";
        Carrito.OpcionImei      = "vaciar";
        Carrito.Imei            = "vaciar";
        Carrito.Condicion       = "vaciar";
        Carrito.Codmarca        = "vaciar";
        Carrito.Marcas          = "vaciar";
        Carrito.Codmodelo       = "vaciar";
        Carrito.Modelos         = "vaciar";
        Carrito.Codpresentacion = "vaciar";
        Carrito.Presentacion    = "vaciar";
        Carrito.Codcolor        = "vaciar";
        Carrito.Color           = "vaciar";
        Carrito.Precio          = "0";
        Carrito.Precio2         = "0";
        Carrito.Descproducto    = "0";
        Carrito.PosicionImpuesto= "0";
        Carrito.TipoImpuesto    = "vaciar";
        Carrito.Ivaproducto     = "vaciar";
        Carrito.Existencia      = "vaciar";
        Carrito.Precioconiva    = "0";
        Carrito.TipoDetalle     = "vaciar";
        Carrito.Cantidad        = "0";
        var DatosJson           = JSON.stringify(Carrito);
        $.post('carritoventa.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=7><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });


$(document).ready(function() {
    $('#vaciar').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=7><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#saveposopcion2")[0].reset();
        $("#codcliente").val("0");
        $("#nrodocumento").val("0");
        $("#exonerado").val("0");
        $("#lblitems").text("0.00");
        $("#lblsubtotal").text("0.00");
        $("#lblexento").text("0.00");
        $("#lblsubtotaliva").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");
        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtexonerado").val("0.00");
        $("#txtexonerado2").val("0.00");
        $("#txtexento").val("0.00");
        $("#txtexento2").val("0.00");
        $("#txtsubtotaliva").val("0.00");
        $("#txtsubtotaliva2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtIva2").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
        $("#txtPagado").val("0.00");
        $("#txtTotalCompra").val("0.00");

        /*####### ACTIVAR BOTON DE PAGO #######*/
        $("#buttonpago").attr('disabled', true);
        $("#submit_guardar").attr('disabled', true);
        $("#TextImporte").text("0.00");
        $("#TextPagado").text("0.00");
        $("#TextCambio").text("0.00");
        $('#TextCliente').text("Consumidor Final");
        $('#TextCredito').text("0.00");
        $("#montopagado").val("0.00");
        $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
    });
});

//FUNCION PARA ACTUALIZAR DESCUENTO EN DETALLE
$(document).ready(function(){
    $('#descproducto').keyup(function(){
        
        var MontoDescuento = $('#descproducto').val();
        var MontoLimite    = $('#limite_descuento').val();

        if (parseFloat(MontoDescuento) > parseFloat(MontoLimite)){
          
            $("#descproducto").val("0.00");
            swal("Oops", "NO TIENE AUTORIZACIÓN PARA ASIGNAR ESE PORCENTAJE EN DESCUENTO, SU LIMITE MAXIMO ES "+$('input#limite_descuento').val()+"%, COMUNIQUESE CON EL ADMINISTRADOR PARA SUBIR EL LIMITE!", "error");
            return false;

        } else if (parseFloat(MontoDescuento) > 100) { 
            
            $("#descproducto").val("0.00");
            swal("Oops", "EL DESCUENTO NO PUEDE SER MAYOR A 100% !", "error");
            return false;
        }
    });
});

//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function(){
    $('#descuento').keyup(function(){

        var MontoDescuento  = $('#descuento').val();
        var MontoLimite     = $('#limite_descuento').val();

        if (parseFloat(MontoDescuento) > parseFloat(MontoLimite)){
              
            $("#descuento").val("0.00");
            swal("Oops", "NO TIENE AUTORIZACIÓN PARA ASIGNAR ESE PORCENTAJE EN DESCUENTO, SU LIMITE MAXIMO ES "+$('input#limite_descuento').val()+"%, COMUNIQUESE CON EL ADMINISTRADOR PARA SUBIR EL LIMITE!", "error");

        } else if (parseFloat(MontoDescuento) > 100) { 
                
            $("#descuento").val("0.00");
            swal("Oops", "EL DESCUENTO GLOBAL NO PUEDE SER MAYOR A 100% !", "error");
        }
  
        var TipoCliente    = $('input#exonerado').val();
        var txtSubtotal    = $('input#txtsubtotal2').val();
        var txtExento      = $('input#txtexento2').val();
        
        var txtSubtotalIva = $('input#txtsubtotaliva2').val();
        var txtIva         = $('input#iva').val();
        PorcentajeIva      = (txtIva > 100 ? "0.00" : txtIva/100);
        var txtTotalIva    = $('input#txtIva2').val();

        var Descuento      = $('input#descuento').val();
        Porcentaje         = (Descuento > 100 ? "0.00" : Descuento/100);
                    
        //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
        MontoExento       = parseFloat(txtExento);
        MontoSubtotalIva  = parseFloat(txtSubtotalIva);
        MontoTotalIva     = parseFloat(txtTotalIva);
        
        /*OBTENGO DESCUENTO DE EXENTO*/
        RestoExento  = parseFloat(MontoExento.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
        ValorExento = (Descuento <= 0 ? parseFloat(MontoExento) : parseFloat(MontoExento) - parseFloat(RestoExento.toFixed(2)));

        /*OBTENGO SUBTOTAL IVA*/
        RestoSubtotalIva = parseFloat(MontoSubtotalIva.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
        ValorSubtotalIva = (Descuento <= 0 ? parseFloat(MontoSubtotalIva) : parseFloat(MontoSubtotalIva) - parseFloat(RestoSubtotalIva.toFixed(2)));
        /*OBTENGO TOTAL IVA*/
        ValorTotalIva    = (Descuento <= 0 ? parseFloat(MontoTotalIva) : parseFloat(ValorSubtotalIva.toFixed(2)) * parseFloat(PorcentajeIva.toFixed(2)));

        TotalDescuentoGeneral = parseFloat(RestoExento.toFixed(2)) + parseFloat(RestoSubtotalIva.toFixed(2));
        SubtotalConImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2)) + parseFloat(ValorTotalIva.toFixed(2)); 
        SubtotalSinImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
        TotalFactura          = (TipoCliente == 2 ? parseFloat(SubtotalSinImpuesto.toFixed(2)) : parseFloat(SubtotalConImpuesto.toFixed(2)));  

        /*CALCULO EXONERADO*/
        $("#lblexonerado").text(Separador((TipoCliente == 2 ? SubtotalSinImpuesto.toFixed(2) : "0.00")));
        $("#txtexonerado").val((TipoCliente == 2 ? SubtotalSinImpuesto.toFixed(2) : "0.00"));

        /*CALCULO SUBTOTAL*/
        $("#lblsubtotal").text(Separador(SubtotalSinImpuesto.toFixed(2)));
        $("#txtsubtotal").val(SubtotalSinImpuesto.toFixed(2));

        /*CALCULO EXENTO*/
        $("#lblexento").text(Separador((TipoCliente != 2 ? ValorExento.toFixed(2) : "0.00")));
        $("#txtexento").val(ValorExento.toFixed(2));
        
        /*CALCULO IVA*/
        $("#lblsubtotaliva").text(Separador((TipoCliente != 2 ? ValorSubtotalIva.toFixed(2) : "0.00")));
        $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));

        $("#lbliva").text(Separador((TipoCliente != 2 ? ValorTotalIva.toFixed(2) : "0.00")));
        $("#txtIva").val(ValorTotalIva.toFixed(2));

        /*CALCULO DESCUENTO*/
        $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));

        /*CALCULO TOTAL*/
        $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
        $("#txtTotal").val(TotalFactura.toFixed(2));
        $("#txtPagado").val(TotalFactura.toFixed(2));
        $("#montopagado").val(TotalFactura.toFixed(2));

        $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
        $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
        $("#TextCambio").text("0.00");
    });
});


//MUESTRO MODAL DE PAGO CON F2
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '113' && button == false) {
        $("#myModalPago").modal("toggle");
        $('#myModalPago').on('shown.bs.modal', function() {
        $('#montopagado').focus();
        })
        return false;
        }
    });                    
});

//LIMPIO VALORES DE FORMULARIO CON F4
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '115' && button == false) {
            $('#vaciar').trigger("click");
            return false;
        }
    });                    
});

//MUESTRO MODAL CLIENTE CON F7
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '118') {
        $("#myModalCliente").modal("toggle");
        $('#myModalCliente').on('shown.bs.modal', function() {
        })
        return false;
        }
    });                    
});

//REGISTRO DE COBRO CON F8
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '119' && button == false) {
        $("#btn-submit").trigger("click");
        return false;
        }
    });                    
});

//CIERRO MODAL DE COBRO CON F10
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '121' && button == false) {
            $('.close').trigger("click");
            return false;
        }
    });                    
});

function LimpiarTexto() {
    $("#search_producto").val("");
    $("#search_producto_barra").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#descripcion").val("");
    $("#opcionimei").val("");
    $("#imei").val("");
    $("#condicion").val("");
    $("#codmarca").val("");
    $("#marcas").val("");
    $("#codmodelo").val("");
    $("#modelos").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#codcolor").val("");
    $("#color").val("");
    $("#preciocompra").val("");
    $("#precioventa").val("");
    $("#descproducto").val("");
    $("#posicionimpuesto").val("");
    $("#tipoimpuesto").val("");
    $("#ivaproducto").val("");
    $("#existencia").val("");
    $("#precioconiva").val("");
    $("#cantidad").val("1");
    $("#tipodetalle").val("1");
}

$("#carrito tbody").on('blur', 'input', function(e) {
    var element = $(this);
    var pvalue = element.val();
    /*var code = e.charCode || e.keyCode;
    var avalue = String.fromCharCode(code);*/
    var regx = /^[A-Za-z0-9 _.-]+$/;
    var action = element.siblings('button').first().attr('onclick');
    var params;
    //if (code !== 16 && /[^\d]/ig.test(avalue)) {
    if (!regx.test(e.charCode) || !regx.test(e.keyCode)){
        e.preventDefault();
        return;
    }

    if (element.attr('data-proc') == '1') {
        return true;
    }
    element.attr('data-proc', '1');
    params = action.match(/\'([^\']+)\'/g).map(function(v) {
        return v.replace(/\'/g, '');
    });
    setTimeout(function() {
        if (element.attr('data-proc') == '1') {
            var value = element.val() || 0;
            addItem(
                params[0],
                params[1],
                value,
                params[3],
                params[4],
                params[5],
                params[6],
                params[7],
                params[8],
                params[9],
                params[10],
                params[11],
                params[12],
                params[13],
                params[14],
                params[15],
                params[16],
                params[17],
                params[18],
                params[19],
                params[20],
                params[21],
                params[22],
                params[23],
                params[24],
                '='
            );
            element.attr('data-proc', '0');
            }
        }, 100);
    });
});


//################# PROCESO PARA COBRAR VENTA #################

//FUNCION AGREGAR MEDIO DE PAGO
function addRowPago() {
    const html = $("#rowPago").html().replace(/\$INDEX/g, $("#muestra_condiciones > .row").length);
    $("#muestra_condiciones").append(html);/**/
}

//FUNCION QUITAR MEDIO DE PAGO
function rmRowPago(el) {
    $(el).closest(".row").remove();
    CalculoDevolucion();
}

//FUNCION PARA CALCULAR DEVOLUCION EN VENTA
function CalculoDevolucion() {
      
    if ($('input#txtTotal').val()==0.00 || $('input#txtTotal').val()==0) {
          
    $("#montopagado").val("");
    swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

    return false;

    } else {

        let sumaPagos = 0;
        $("#muestra_condiciones input").map((idx, el) => sumaPagos += +el.value);

        const montopagado = sumaPagos;
        const montototal = +$("input#txtTotal").val();
        const montodevuelto = $("input#montodevuelto").val();

        //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
        const montoVuelto = montopagado - montototal;

        $("#txtPagado").val(montopagado.toFixed(2));
        $("#TextPagado").text(Separador(montopagado.toFixed(2)));
        $("#TextCambio").text((montopagado == "" || montopagado == "0.00") ? "0.00" : Separador(montoVuelto.toFixed(2)));
        $("#montodevuelto").val((montopagado == "" || montopagado == "0.00") ? "0.00" : montoVuelto.toFixed(2));
    }
}

// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagos(){
    
var tipopago = $('input:radio[name=tipopago]:checked').val();
var montototal = $('input#txtTotal').val();

var sumtotal = parseFloat(montototal);
var Sumatoria = parseFloat(sumtotal.toFixed(2));

$("#TextImporte").text(Separador(Sumatoria.toFixed(2)));
$("#TextPagado").text(tipopago == "CREDITO" ? "0.00" : Separador(montototal));
$("#txtPagado").val(tipopago == "CREDITO" ? "0.00" : Separador(montototal));
$("#TextCambio").text("0.00");

var dataString = 'BuscaCondicionesPagos=si&tipopago='+tipopago+"&txtTotal="+montototal;

    $.ajax({
        type: "GET",
            url: "condiciones_pagos.php",
            data: dataString,
            success: function(response) {            
            $('#muestra_condiciones').empty();
            $('#muestra_condiciones').append(''+response+'').fadeIn("slow"); 
        }
    });
}

// FUNCION PARA VERIFICAR CLIENTE EXONERADO
function EjecutarFuncion(){

    var TipoCliente    = $('input#exonerado').val();
    var txtSubtotal    = $('input#txtsubtotal2').val();
    var txtExento      = $('input#txtexento2').val();
        
    var txtSubtotalIva = $('input#txtsubtotaliva2').val();
    var txtIva         = $('input#iva').val();
    PorcentajeIva      = (txtIva > 100 ? "0.00" : txtIva/100);
    var txtTotalIva    = $('input#txtIva2').val();

    var Descuento      = $('input#descuento').val();
    Porcentaje         = (Descuento > 100 ? "0.00" : Descuento/100);


    //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
    MontoExento       = parseFloat(txtExento);
    MontoSubtotalIva  = parseFloat(txtSubtotalIva);
    MontoTotalIva     = parseFloat(txtTotalIva);
    
    /*OBTENGO DESCUENTO DE EXENTO*/
    RestoExento  = parseFloat(MontoExento.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
    ValorExento = (Descuento <= 0 ? parseFloat(MontoExento) : parseFloat(MontoExento) - parseFloat(RestoExento.toFixed(2)));


    /*OBTENGO SUBTOTAL IVA*/
    RestoSubtotalIva = parseFloat(MontoSubtotalIva.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
    ValorSubtotalIva = (Descuento <= 0 ? parseFloat(MontoSubtotalIva) : parseFloat(MontoSubtotalIva) - parseFloat(RestoSubtotalIva.toFixed(2)));
    /*OBTENGO TOTAL IVA*/
    ValorTotalIva    = (Descuento <= 0 ? parseFloat(MontoTotalIva) : parseFloat(ValorSubtotalIva.toFixed(2)));

    TotalDescuentoGeneral = parseFloat(RestoExento.toFixed(2)) + parseFloat(RestoSubtotalIva.toFixed(2));
    SubtotalConImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2)) + parseFloat(ValorTotalIva.toFixed(2)); 
    SubtotalSinImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
    TotalFactura          = (TipoCliente == 2 ? parseFloat(SubtotalSinImpuesto.toFixed(2)) : parseFloat(SubtotalConImpuesto.toFixed(2))); 

    /*CALCULO EXONERADO*/
    $("#lblexonerado").text(Separador((TipoCliente == 2 ? SubtotalSinImpuesto.toFixed(2) : "0.00")));
    $("#txtexonerado").val((TipoCliente == 2 ? SubtotalSinImpuesto.toFixed(2) : "0.00"));

    /*CALCULO SUBTOTAL*/
    $("#lblsubtotal").text(Separador(SubtotalSinImpuesto.toFixed(2)));
    $("#txtsubtotal").val(SubtotalSinImpuesto.toFixed(2));

    /*CALCULO EXENTO*/
    $("#lblexento").text(Separador((TipoCliente != 2 ? ValorExento.toFixed(2) : "0.00")));
    $("#txtexento").val(ValorExento.toFixed(2));
    
    /*CALCULO IVA*/
    $("#lblsubtotaliva").text(Separador((TipoCliente != 2 ? ValorSubtotalIva.toFixed(2) : "0.00")));
    $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));

    $("#lbliva").text(Separador((TipoCliente != 2 ? ValorTotalIva.toFixed(2) : "0.00")));
    $("#txtIva").val(ValorTotalIva.toFixed(2));

    /*CALCULO DESCUENTO*/
    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));

    /*CALCULO TOTAL*/
    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
    $("#txtTotal").val(TotalFactura.toFixed(2));
    $("#txtPagado").val(TotalFactura.toFixed(2));
    $("#montopagado").val(TotalFactura.toFixed(2));

    $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
    $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
    $("#TextCambio").text("0.00");
}

//################# PROCESO PARA COBRAR VENTA #################










//################# PROCESO PARA COBRAR FACTURAS PENDIENTES #################

//FUNCION AGREGAR MEDIO DE PAGO
function addRowPago2() {
    const html = $("#rowPago2").html().replace(/\$INDEX/g, $("#muestra_condiciones2 > .row").length);
    $("#muestra_condiciones2").append(html);/**/
}

//FUNCION QUITAR MEDIO DE PAGO
function rmRowPago2(el) {
    $(el).closest(".row").remove();
    CalculoDevolucion2();
}

//FUNCION PARA CALCULAR DEVOLUCION EN VENTA
function CalculoDevolucion2() {
      
    if ($('input#txtTotal2').val()==0.00 || $('input#txtTotal2').val()==0) {
          
    $("#montopagado2").val("");
    swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

    return false;

    } else {

        let sumaPagos = 0;
        $("#muestra_condiciones2 input").map((idx, el) => sumaPagos += +el.value);

        const montopagado   = sumaPagos;
        const montototal    = +$("input#txtTotal2").val();
        const montodevuelto = $("input#montodevuelto2").val();

        //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
        const montoVuelto   = montopagado - montototal;

        $("#txtPagado2").val(montopagado.toFixed(2));
        $("#TextPagado2").text(Separador(montopagado.toFixed(2)));
        $("#TextCambio2").text((montopagado == "" || montopagado == "0.00") ? "0.00" : Separador(montoVuelto.toFixed(2)));
        $("#montodevuelto2").val((montopagado == "" || montopagado == "0.00") ? "0.00" : montoVuelto.toFixed(2));
    }
}

// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagos2(){
    
var tipopago   = $('input:radio[name=tipopago2]:checked').val();
var montototal = $('input#txtTotal2').val();

var sumtotal   = parseFloat(montototal);
var Sumatoria  = parseFloat(sumtotal.toFixed(2));

$("#TextImporte2").text(Separador(Sumatoria.toFixed(2)));
$("#TextPagado2").text(tipopago == "CREDITO" ? "0.00" : Separador(montototal));
$("#txtPagado2").val(tipopago == "CREDITO" ? "0.00" : Separador(montototal));
$("#TextCambio2").text("0.00");

var dataString = 'BuscaCondicionesPagos2=si&tipopago2='+tipopago+"&txtTotal2="+montototal;

    $.ajax({
        type: "GET",
            url: "condiciones_pagos.php",
            data: dataString,
            success: function(response) {            
            $('#muestra_condiciones2').empty();
            $('#muestra_condiciones2').append(''+response+'').fadeIn("slow"); 
        }
    });
}

// FUNCION PARA VERIFICAR CLIENTE EXONERADO
function EjecutarFuncionFacturaPendiente(){

    var TipoCliente    = $('input#exonerado2').val();
    var txtSubtotal    = $('input#txtsubtotal22').val();
    var txtExento      = $('input#txtexento22').val();
        
    var txtSubtotalIva = $('input#txtsubtotaliva22').val();
    var txtIva         = $('input#iva2').val();
    PorcentajeIva      = (txtIva > 100 ? "0.00" : txtIva/100);
    var txtTotalIva    = $('input#txtIva22').val();

    var Descuento      = $('input#descuento2').val();
    Porcentaje         = (Descuento > 100 ? "0.00" : Descuento/100);


    //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
    MontoExento       = parseFloat(txtExento);
    MontoSubtotalIva  = parseFloat(txtSubtotalIva);
    MontoTotalIva     = parseFloat(txtTotalIva);
    
    /*OBTENGO DESCUENTO DE EXENTO*/
    RestoExento  = parseFloat(MontoExento.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
    ValorExento = (Descuento <= 0 ? parseFloat(MontoExento) : parseFloat(MontoExento) - parseFloat(RestoExento.toFixed(2)));


    /*OBTENGO SUBTOTAL IVA*/
    RestoSubtotalIva = parseFloat(MontoSubtotalIva.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
    ValorSubtotalIva = (Descuento <= 0 ? parseFloat(MontoSubtotalIva) : parseFloat(MontoSubtotalIva) - parseFloat(RestoSubtotalIva.toFixed(2)));
    /*OBTENGO TOTAL IVA*/
    ValorTotalIva    = (Descuento <= 0 ? parseFloat(MontoTotalIva) : parseFloat(ValorSubtotalIva.toFixed(2)));

    TotalDescuentoGeneral = parseFloat(RestoExento.toFixed(2)) + parseFloat(RestoSubtotalIva.toFixed(2));
    SubtotalConImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2)) + parseFloat(ValorTotalIva.toFixed(2)); 
    SubtotalSinImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
    TotalFactura          = (TipoCliente == 2 ? parseFloat(SubtotalSinImpuesto.toFixed(2)) : parseFloat(SubtotalConImpuesto.toFixed(2))); 

    /*CALCULO EXONERADO*/
    $("#lblexonerado2").text(Separador((TipoCliente == 2 ? SubtotalSinImpuesto.toFixed(2) : "0.00")));
    $("#txtexonerado2").val((TipoCliente == 2 ? SubtotalSinImpuesto.toFixed(2) : "0.00"));

    /*CALCULO SUBTOTAL*/
    $("#lblsubtotal2").text(Separador(SubtotalSinImpuesto.toFixed(2)));
    $("#txtsubtotal2").val(SubtotalSinImpuesto.toFixed(2));

    /*CALCULO EXENTO*/
    $("#lblexento2").text(Separador((TipoCliente != 2 ? ValorExento.toFixed(2) : "0.00")));
    $("#txtexento2").val(ValorExento.toFixed(2));
    
    /*CALCULO IVA*/
    $("#lblsubtotaliva2").text(Separador((TipoCliente != 2 ? ValorSubtotalIva.toFixed(2) : "0.00")));
    $("#txtsubtotaliva2").val(ValorSubtotalIva.toFixed(2));

    $("#lbliva2").text(Separador((TipoCliente != 2 ? ValorTotalIva.toFixed(2) : "0.00")));
    $("#txtIva2").val(ValorTotalIva.toFixed(2));

    /*CALCULO DESCUENTO*/
    $("#lbldescuento2").text(Separador(TotalDescuentoGeneral.toFixed(2)));
    $("#txtDescuento2").val(TotalDescuentoGeneral.toFixed(2));

    /*CALCULO TOTAL*/
    $("#lbltotal2").text(Separador(TotalFactura.toFixed(2)));
    $("#txtTotal2").val(TotalFactura.toFixed(2));
    $("#txtPagado2").val(TotalFactura.toFixed(2));
    $("#montopagado2").val(TotalFactura.toFixed(2));

    $("#TextImporte2").text(Separador(TotalFactura.toFixed(2)));
    $("#TextPagado2").text(Separador(TotalFactura.toFixed(2)));
    $("#TextCambio2").text("0.00");
}

//################# PROCESO PARA COBRAR FACTURAS PENDIENTES #################




// FUNCION PARA CAMBIAR PRECIOS PRODUCTOS
function CargaPreciosProductos(){
    
   var tipo_precio = $('input:radio[name=preciop]:checked').val();
   $('#loading').load("familias_productos?CargarProductos=si&tipo_precio="+tipo_precio);
}

// FUNCION PARA CAMBIAR PRECIOS COMBOS
function CargaPreciosCombos(){
    
   var tipo_precio = $('input:radio[name=precioc]:checked').val();
   $('#loading').load("familias_productos?CargarCombos=si&tipo_precio="+tipo_precio);
}

function addItem(id, codigo, cantidad, producto, descripcion, opcionimei, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio2, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, existencia, precioconiva, tipodetalle, opCantidad) {

    var Carrito              = new Object();
    Carrito.Id               = id;
    Carrito.Codigo           = codigo;
    Carrito.Producto         = producto;
    Carrito.Descripcion      = descripcion;
    Carrito.OpcionImei       = opcionimei;
    Carrito.Imei             = imei;
    Carrito.Condicion        = condicion;
    Carrito.Codmarca         = codmarca;
    Carrito.Marcas           = marcas;
    Carrito.Codmodelo        = codmodelo;
    Carrito.Modelos          = modelos;
    Carrito.Codpresentacion  = codpresentacion;
    Carrito.Presentacion     = presentacion;
    Carrito.Codcolor         = codcolor;
    Carrito.Color            = color;
    Carrito.Precio           = precio;
    Carrito.Precio2          = precio2;
    Carrito.Descproducto     = descproducto;
    Carrito.PosicionImpuesto = posicionimpuesto;
    Carrito.TipoImpuesto     = tipoimpuesto;
    Carrito.Ivaproducto      = ivaproducto;
    Carrito.Existencia       = existencia;
    Carrito.Precioconiva     = precioconiva;
    Carrito.TipoDetalle      = tipodetalle;
    Carrito.Cantidad         = cantidad;
    Carrito.opCantidad       = opCantidad;
    var DatosJson            = JSON.stringify(Carrito);
    $.post('carritoventa.php', {
        MiCarrito: DatosJson
    },
    function(data, textStatus) {
        $("#carrito tbody").html("");
        var contador        = 0;
        var OperacionItems  = 0;
        var TotalDescuento  = 0;
        var Subtotal        = 0;
        var SubtotalExento  = 0;
        var BaseImpIva      = 0;
        var TotalIvaGeneral = 0;
        var TotalCompra     = 0;

        $.each(data, function(i, item) {
            var cantsincero = item.cantidad;
            cantsincero = parseFloat(cantsincero);
            if (cantsincero != 0) {
                contador = contador + 1;

                //CALCULO DEL TOTAL DE ITEMS
                var Items      = parseFloat(cantsincero);
                OperacionItems = parseFloat(OperacionItems) + parseFloat(Items);

                //CALCULO DEL TOTAL DE COMPRAS
                var OperacionCompra = parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra         = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                //CALCULO DEL VALOR TOTAL
                var PrecioVenta = parseFloat(item.precio2);
                var ValorTotal  = parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var DetalleDescuento = ValorTotal * item.descproducto / 100;
                TotalDescuento       = parseFloat(TotalDescuento) + parseFloat(DetalleDescuento);

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio2 * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE SUBTOTAL GENERAL
                var Operac    = parseFloat(item.precio2) - parseFloat(descsiniva);
                var Operacion = parseFloat(Operac) * parseFloat(item.cantidad);
                Subtotal      = parseFloat(Subtotal) + parseFloat(Operacion);

                //CALCULO DE BASE IMPONIBLE IVA
                var Operac3         = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3      = parseFloat(Operac3) * parseFloat(item.cantidad);
                var SubBaseImponIva = Operacion3.toFixed(2);

                //CALCULO VALOR DISCRIMINADO
                var iva = (item.ivaproducto != "0") ? item.ivaproducto : "0.00";
                var ValorImpuesto        = (iva <= 9) ? "1.0"+parseInt(iva) : "1."+parseInt(iva);
                var Discriminado         = parseFloat(Operac3) / ValorImpuesto;
                var SubtotalDiscriminado = parseFloat(Operac3) - parseFloat(Discriminado);
                var BaseDiscriminado     = parseFloat(SubtotalDiscriminado) * parseFloat(item.cantidad);
                TotalIvaGeneral          = parseFloat(TotalIvaGeneral) + parseFloat(BaseDiscriminado);

                //CALCULO DE SUBTOTAL IVA
                BaseImpIva = (item.ivaproducto != "0") ? parseFloat(BaseImpIva) + parseFloat(SubBaseImponIva) : parseFloat(BaseImpIva);
                SubtotalIva = parseFloat(BaseImpIva) - parseFloat(TotalIvaGeneral);

                //CALCULO DE SUBTOTAL EXENTO
                SubtotalExento = (item.ivaproducto != "0") ? parseFloat(SubtotalExento) : parseFloat(SubtotalExento) + parseFloat(Operacion);
                    
                //OBTENGO TIPO DE CLIENTE
                var TipoCliente = $('input#exonerado').val();

                /*###################################################### CALCULO DE DESCUENTO ######################################################*/

                //PORCENTAJE DESCUENTO 
                var Descuento  = $('input#descuento').val();
                Porcentaje     = (Descuento > 100 ? "0.00" : Descuento/100);

                //PORCENTAJE IVA
                var txtIva     = $('input#iva').val();
                PorcentajeIva  = (txtIva > 100 ? "0.00" : txtIva/100);

                //CALCULO DE SUBTOTAL FACTURA
                SubTotalFactura = parseFloat(SubtotalExento) + parseFloat(SubtotalIva);

                /*OBTENGO DESCUENTO DE EXENTO*/
                RestoExento  = parseFloat(SubtotalExento.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
                ValorExento = (Descuento <= 0 ? parseFloat(SubtotalExento) : parseFloat(SubtotalExento) - parseFloat(RestoExento.toFixed(2)));

                /*OBTENGO SUBTOTAL IVA*/
                RestoSubtotalIva = parseFloat(SubtotalIva.toFixed(2)) * parseFloat(Porcentaje.toFixed(2));
                ValorSubtotalIva = (Descuento <= 0 ? parseFloat(SubtotalIva) : parseFloat(SubtotalIva) - parseFloat(RestoSubtotalIva.toFixed(2)));
                /*OBTENGO TOTAL IVA*/
                ValorTotalIva    = (Descuento <= 0 ? parseFloat(TotalIvaGeneral) : parseFloat(ValorSubtotalIva.toFixed(2)) * parseFloat(PorcentajeIva.toFixed(2)));

                /*OBTENGO TOTALES DE FACTURA*/
                TotalDescuentoGeneral = parseFloat(RestoExento.toFixed(2)) + parseFloat(RestoSubtotalIva.toFixed(2));
                SubtotalConImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2)) + parseFloat(ValorTotalIva.toFixed(2)); 
                SubtotalSinImpuesto   = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
                ValorSubTotalFactura  = parseFloat(ValorExento.toFixed(2)) + parseFloat(ValorSubtotalIva.toFixed(2));
                TotalFactura          = (TipoCliente == 2 ? parseFloat(SubtotalSinImpuesto.toFixed(2)) : parseFloat(SubtotalConImpuesto.toFixed(2)));
                /*###################################################### CALCULO DE DESCUENTO ######################################################*/

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                "<td>" +
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'-1'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.condicion + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.codcolor + "'," +
                "'" + item.color + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.existencia + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.tipodetalle + "', " +
                "'-'" +
                ')"' +
                " type='button'><span class='fa fa-minus'></span></button>" +
                "<input type='text' id='" + item.cantidad + "' class='bold' style='width:50px;height:28px;' value='" + item.cantidad + "'>" +
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'+1'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.condicion + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.codcolor + "'," +
                "'" + item.color + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.existencia + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.tipodetalle + "', " +
                "'+'" +
                ')"' +
                " type='button'><span class='fa fa-plus'></span></button></td>" +
                "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.codmarca == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.codmodelo == '0' ? '******' : item.modelos) + ")</small></td>" +
                "<td><strong>" + Separador(item.precio2) + "</strong></td>" +
                "<td><strong>" + Separador(DetalleDescuento.toFixed(2)) + "<sup>" + Separador(item.descproducto) + "%</sup></strong></td>" +
                "<td><strong>" + (item.ivaproducto == "0" ? item.tipoimpuesto : item.tipoimpuesto + ' (' + Separador(item.ivaproducto) + '%)') + "</strong></td>" +
                "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                "<td>" +
                
                '<span class="text-info" title="Asignar Imei" style="cursor:pointer;color:#fff;" ' +
                'onclick="AsignaImei(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.tipodetalle + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImei" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></span> ' +
                    
                '<span class="text-success" title="Editar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="AsignaPrecio(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.tipodetalle + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></span> ' +

                '<span class="text-danger" title="Eliminar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'0'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
                "'" + item.opcionimei + "'," +
                "'" + item.imei + "'," +
                "'" + item.condicion + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.codcolor + "'," +
                "'" + item.color + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.existencia + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.tipodetalle + "', " +
                "'='" +
                ')"' +
                ' title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>' +
                "</td>" +
                "</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                                
                    $("#lblitems").text(Separador(OperacionItems.toFixed(2)));
                    $("#lblsubtotal").text(Separador(ValorSubTotalFactura.toFixed(2)));
                    $("#lblexonerado").text(Separador((TipoCliente == 2 ? ValorSubTotalFactura.toFixed(2) : "0.00")));
                    $("#lblexento").text(Separador((TipoCliente != 2 ? ValorExento.toFixed(2) : "0.00")));
                    $("#lblsubtotaliva").text(Separador((TipoCliente != 2 ? ValorSubtotalIva.toFixed(2) : "0.00")));
                    $("#lbliva").text(Separador((TipoCliente != 2 ? ValorTotalIva.toFixed(2) : "0.00")));
                    $("#lbldescontado").text(Separador(TotalDescuento.toFixed(2)));
                    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
                    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
                    
                    $("#txtsubtotal").val(ValorSubTotalFactura.toFixed(2));
                    $("#txtsubtotal2").val(SubTotalFactura.toFixed(2));
                    $("#txtexonerado").val((TipoCliente == 2 ? ValorSubTotalFactura.toFixed(2) : "0.00"));
                    $("#txtexonerado2").val((TipoCliente == 2 ? SubTotalFactura.toFixed(2) : "0.00"));
                    $("#txtexento").val(ValorExento.toFixed(2));
                    $("#txtexento2").val(SubtotalExento.toFixed(2));
                    $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));
                    $("#txtsubtotaliva2").val(SubtotalIva.toFixed(2));
                    $("#txtIva").val(ValorTotalIva.toFixed(2));
                    $("#txtIva2").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    $("#txtPagado").val(TotalFactura.toFixed(2));
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));
                            
                    /*####### ACTIVAR BOTON DE PAGO #######*/
                    $("#buttonpago").attr('disabled', false);
                    $("#submit_guardar").attr('disabled', false);
                    $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
                    $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
                    $("#montopagado").val(TotalFactura.toFixed(2));
                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=7><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#saveposopcion2")[0].reset();
                $("#lblitems").text("0.00");
                $("#lblsubtotal").text("0.00");
                $("#lblexento").text("0.00");
                $("#lblsubtotaliva").text("0.00");
                $("#lbliva").text("0.00");
                $("#lbldescontado").text("0.00");
                $("#lbldescuento").text("0.00");
                $("#lbltotal").text("0.00");
                $("#txtsubtotal").val("0.00");
                $("#txtsubtotal2").val("0.00");
                $("#txtexonerado").val("0.00");
                $("#txtexonerado2").val("0.00");
                $("#txtexento").val("0.00");
                $("#txtexento2").val("0.00");
                $("#txtsubtotaliva").val("0.00");
                $("#txtsubtotaliva2").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtIva2").val("0.00");
                $("#txtdescontado").val("0.00");
                $("#txtDescuento").val("0.00");
                $("#txtTotal").val("0.00");
                $("#txtPagado").val("0.00");
                $("#txtTotalCompra").val("0.00");

                /*####### ACTIVAR BOTON DE PAGO #######*/
                $("#buttonpago").attr('disabled', true);
                $("#submit_guardar").attr('disabled', true);
                $("#TextImporte").text("0.00");
                $("#TextPagado").text("0.00");
                $('#TextCliente').text("Consumidor Final");
                $('#TextCredito').text("0.00");
                $("#montopagado").val("0.00");
                $("#montopagado").text("0.00");
            }
        },
        "json"
    );
    return false;
}