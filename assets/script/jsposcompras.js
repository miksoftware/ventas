function Separador(x) {//SEPARADOR CON DECIMAL
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function DoAction(idproducto, codproducto, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio1, precio2, precio3, descproductofact, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, precioconiva, lote, fechaelaboracion, fechaexpiracion1, fechaexpiracion2, fechaexpiracion3, optimo, medio, minimo) {
    
    addItem(idproducto, codproducto, 1, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio1, precio2, precio3, descproductofact, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, precioconiva, lote, fechaelaboracion, fechaexpiracion1, fechaexpiracion2, fechaexpiracion3, optimo, medio, minimo, '+=');
}

// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################
function DoActionPrecio(idproducto, codproducto, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio1, precio2, precio3, descproductofact, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, precioconiva, lote, fechaelaboracion, fechaexpiracion1, fechaexpiracion2, fechaexpiracion3, optimo, medio, minimo) 
{
    addItem(idproducto, codproducto, 0.00, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio1, precio2, precio3, descproductofact, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, precioconiva, lote, fechaelaboracion, fechaexpiracion1, fechaexpiracion2, fechaexpiracion3, optimo, medio, minimo, '+=');
}

function AsignaPrecio(id, codigo, producto, cantidad, precio, descproductofact)
{
  $("#agregaprecio #d_id").val(id);
  $("#agregaprecio #d_codigo").val(codigo);
  $("#agregaprecio #agrega_detalle_precio").load("detalles_productos?BuscaDetallesProductoCompraxPrecio=si&variable=0&d_id="+id+"&d_codigo="+codigo+"&d_producto="+producto.replace(/[.(),;:!?%#$'\"+=\/\-“”’]*/g, "")+"&d_cantidad="+cantidad+"&d_precio="+precio+"&d_descproducto="+descproductofact);
}
// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################

$(document).ready(function() {

    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/
    $('#saveposcompra').keypress(function(e){
        var keycode = (e.keyCode ? e.keyCode : e.which);   
        if (keycode == 13) {
            return false;
        }
    });
    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/

    /*############ FUNCION AGREGA POR CRITERIO ############*/
    $('#search_producto_compra').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
          AgregaProductos();
          e.preventDefault();
          return false;
        }
    });
    /*############ FUNCION AGREGA POR CRITERIO ############*/

    /*############ FUNCION AGREGA POR LECTOR ############*/
    $('#search_producto_compra_barra').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
            AgregaProductos();
            e.preventDefault();
            return false;
        }
    });

    $('#search_producto_compra_barra').change(function(e) {        
        AgregaProductos();
        e.preventDefault();     
    });
    /*############ FUNCION AGREGA POR LECTOR ############*/

    $("#search_producto_compra_barra").change(function(){
        let codeBar=$(this).val();
        $.ajax({    
            url: "class/busqueda_autocompleto.php?Busqueda_Producto_Compra_Barcode=si",
            data:{barcodec:codeBar},      
            type : 'POST',   
            dataType : 'json',    
            success : function(json) {
                if (JSON.stringify(json[0])==null) {
                    return false;
                } 
                //console.log(json);
                $('#idproducto').val(json[0].idproducto);
                $('#codproducto').val(json[0].codproducto);
                $('#producto').val(json[0].producto);
                $('#descripcion').val((json[0].descripcion == "") ? "0" : json[0].descripcion);
                $('#imei').val((json[0].imei == "") ? "0" : json[0].imei);
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
                $('#precioxmayor').val(json[0].precioxmayor);
                $('#precioxmenor').val(json[0].precioxmenor);
                $('#precioxpublico').val(json[0].precioxpublico);
                $('#descfactura').val("0.00");
                $('#descproducto').val(json[0].descproducto);
                $('#posicionimpuesto').val((json[0].ivaproducto == "0") ? "0" : json[0].posicionimpuesto);
                $('#tipoimpuesto').val((json[0].ivaproducto == "0") ? "EXENTO" : json[0].nomimpuesto);
                $('#ivaproducto').val(json[0].ivaproducto);
                $('#precioconiva').val((json[0].ivaproducto == "0") ? "0.00" : json[0].preciocompra);
                $('#lote').val("0");
                $('#fechaelaboracion').val(json[0].fechaelaboracion);
                $('#fechaoptimo').val(json[0].fechaoptimo);
                $('#fechamedio').val(json[0].fechamedio);
                $('#fechaminimo').val(json[0].fechaminimo);
                $('#stockoptimo').val(json[0].stockoptimo);
                $('#stockmedio').val(json[0].stockmedio);
                $('#stockminimo').val(json[0].stockminimo);
                $("#cantidad").val("1");
                $("#search_producto_compra_barra").focus();
                //AgregaVentas();
                //asigno tiempo de agregar detalle
                setTimeout(function() {
                var e = jQuery.Event("keypress");
                e.which = 13;
                e.keyCode = 13;
                AgregaProductos();
                //e.preventDefault();
                }, 100);
            },
            error : function(error) {
                console.log(error);
                swal("Oops", "Ha Ocurrido un Error en el procesamiento de informacion!", "error");
                //alert('Disculpe, Ha Ocurrido un Error en el procesamiento de informacion');
            }
        });
    });

    function AgregaProductos () {
        var code        = $('input#codproducto').val();
        var prod        = $('input#producto').val();
        var cantp       = $('input#cantidad').val();
        var exist       = $('input#existencia').val();
        var prec        = $('input#preciocompra').val();
        var prec1       = $('input#precioxmayor').val();
        var prec2       = $('input#precioxmenor').val();
        var prec3       = $('input#precioxpublico').val();
        var descuenfact = $('input#descfactura').val();
        var descuen     = $('input#descproducto').val();
        var ivgprod     = $('input#ivaproducto').val();
        var lote        = $('input#lote').val();
        var er_num      = /^([0-9])*[.]?[0-9]*$/;
        cantp           = parseInt(cantp);
        exist           = parseInt(exist);
        cantp          = cantp;

        if (code == "") {
            $("#search_producto_compra").focus();
            //$("#search_producto").css('border-color', '#ff7676');
            //swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO/SERVICIO CORRECTAMENTE!", "error");
            return false;
            
        } else if(prec=="" || prec=="0" || prec=="0.00"){
        $("#preciocompra").focus();
        $('#preciocompra').css('border-color','#ff7676');
        swal("Oops", "POR FAVOR INGRESE PRECIO DE COMPRA VALIDO PARA PRODUCTO!", "error");  
        return false;
        
        } else if(!er_num.test($('#preciocompra').val())){
            $("#preciocompra").focus();
            $('#preciocompra').css('border-color','#ff7676');
            $("#preciocompra").val("");
            swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO COMPRA!", "error");  
            return false;

        } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN COMPRAS!", "error");
            return false;

        } else if (isNaN($('#cantidad').val())) {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            $("#cantidad").val("");
            swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE COMPRAS!", "error");
            return false;

        } else {

            var Carrito              = new Object();
            Carrito.Id               = $('input#idproducto').val();
            Carrito.Codigo           = $('input#codproducto').val();
            Carrito.Producto         = $('input#producto').val().replace(/[ '"]+/g, ' ');
            Carrito.Descripcion      = $('input#descripcion').val().replace(/[ '"]+/g, ' ');
            Carrito.Imei             = $('input#imei').val();
            Carrito.Condicion        = $('input#condicion').val();
            Carrito.Codmarca         = $('input#codmarca').val();
            Carrito.Marcas           = $('input#marcas').val();
            Carrito.Codmodelo        = $('input#codmodelo').val();
            Carrito.Modelos          = $('input#modelos').val();
            Carrito.Codpresentacion  = $('input#codpresentacion').val();
            Carrito.Presentacion     = $('input#presentacion').val();
            Carrito.Codcolor         = $('input#codcolor').val();
            Carrito.Color            = $('input#codcolor').val();
            Carrito.Precio           = $('input#preciocompra').val();
            Carrito.Precio1          = $('input#precioxmayor').val();
            Carrito.Precio2          = $('input#precioxmenor').val();
            Carrito.Precio3          = $('input#precioxpublico').val();
            Carrito.DescproductoFact = $('input#descfactura').val();
            Carrito.Descproducto     = $('input#descproducto').val();
            Carrito.PosicionImpuesto = ($('input#ivaproducto').val() == "0" ? "0" : $('input#posicionimpuesto').val());
            Carrito.TipoImpuesto     = $('input#tipoimpuesto').val();
            Carrito.Ivaproducto      = ($('input#ivaproducto').val() == "0" ? "0" : $('input#ivaproducto').val());
            Carrito.Precioconiva     = ($('input#ivaproducto').val() == "0" ? "0.00" : $('input#precioconiva').val());
            Carrito.Lote             = $('input#lote').val();
            Carrito.Fechaelaboracion = $('input#fechaelaboracion').val();
            Carrito.Fechaexpiracion1 = $('input#fechaoptimo').val();
            Carrito.Fechaexpiracion2 = $('input#fechamedio').val();
            Carrito.Fechaexpiracion3 = $('input#fechaminimo').val();
            Carrito.Optimo           = $('input#stockoptimo').val();
            Carrito.Medio            = $('input#stockmedio').val();
            Carrito.Minimo           = $('input#stockminimo').val();
            Carrito.Cantidad         = $('input#cantidad').val();
            Carrito.opCantidad       = '+=';
            var DatosJson            = JSON.stringify(Carrito);
            $.post('carritocompra.php', {
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

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseFloat(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

            //CALCULO DEL TOTAL DE ITEMS
            var Items      = parseFloat(cantsincero);
            OperacionItems = parseFloat(OperacionItems) + parseFloat(Items);

            //CALCULO DEL VALOR TOTAL
            var ValorTotal  = parseFloat(item.precio) * parseFloat(item.cantidad);

            //CALCULO DEL TOTAL DEL DESCUENTO %
            var DetalleDescuento = ValorTotal * item.descproductofact / 100;
            TotalDescuento       = parseFloat(TotalDescuento) + parseFloat(DetalleDescuento);

            //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
            var descsiniva = item.precio * item.descproductofact / 100;
            var descconiva = item.precioconiva * item.descproductofact / 100;

            //CALCULO DE SUBTOTAL GENERAL
            var Operac    = parseFloat(item.precio) - parseFloat(descsiniva);
            var Operacion = parseFloat(Operac) * parseFloat(item.cantidad);
            Subtotal      = parseFloat(Subtotal) + parseFloat(Operacion);

            //CALCULO DE BASE IMPONIBLE IVA
            var Operac3         = parseFloat(item.precioconiva) - parseFloat(descconiva);
            var Operacion3      = parseFloat(Operac3) * parseFloat(item.cantidad);
            var SubBaseImponIva = Operacion3;

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
            TotalFactura          = parseFloat(SubtotalConImpuesto.toFixed(2));
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
                "'" + item.precio1 + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.precio3 + "', " +
                "'" + item.descproductofact + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.lote + "', " +
                "'" + item.fechaelaboracion + "', " +
                "'" + item.fechaexpiracion1 + "', " +
                "'" + item.fechaexpiracion2 + "', " +
                "'" + item.fechaexpiracion3 + "', " +
                "'" + item.optimo + "', " +
                "'" + item.medio + "', " +
                "'" + item.minimo + "', " +
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
                "'" + item.precio1 + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.precio3 + "', " +
                "'" + item.descproductofact + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.lote + "', " +
                "'" + item.fechaelaboracion + "', " +
                "'" + item.fechaexpiracion1 + "', " +
                "'" + item.fechaexpiracion2 + "', " +
                "'" + item.fechaexpiracion3 + "', " +
                "'" + item.optimo + "', " +
                "'" + item.medio + "', " +
                "'" + item.minimo + "', " +
                "'+'" +
                ')"' +
                " type='button'><span class='fa fa-plus'></span></button></td>" +
                "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.codmarca == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.codmodelo == '0' ? '******' : item.modelos) + ")</small></td>" +
                "<td><strong>" + Separador(item.precio) + "</strong></td>" +
                "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                "<td>" +
                
                '<span class="text-success" title="Editar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="AsignaPrecio(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio + "', " +
                "'" + item.descproductofact + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></span> ' +
                    
                '<span class="text-danger" title="Eliminar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'0'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
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
                "'" + item.precio1 + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.precio3 + "', " +
                "'" + item.descproductofact + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.lote + "', " +
                "'" + item.fechaelaboracion + "', " +
                "'" + item.fechaexpiracion1 + "', " +
                "'" + item.fechaexpiracion2 + "', " +
                "'" + item.fechaexpiracion3 + "', " +
                "'" + item.optimo + "', " +
                "'" + item.medio + "', " +
                "'" + item.minimo + "', " +
                "'='" +
                ')"' +
                ' title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>' +
                "</td>" +
                "</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                            
                    $("#lblitems").text(Separador(OperacionItems.toFixed(2)));
                    $("#lblsubtotal").text(Separador(ValorSubTotalFactura.toFixed(2)));
                    $("#lblexento").text(Separador(ValorExento.toFixed(2)));
                    $("#lblsubtotaliva").text(Separador(ValorSubtotalIva.toFixed(2)));
                    $("#lbliva").text(Separador(ValorTotalIva.toFixed(2)));
                    $("#lbldescontado").text(Separador(TotalDescuento.toFixed(2)));
                    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
                    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));

                    $("#txtsubtotal").val(ValorSubTotalFactura.toFixed(2));
                    $("#txtsubtotal2").val(SubTotalFactura.toFixed(2));
                    $("#txtexento").val(ValorExento.toFixed(2));
                    $("#txtexento2").val(SubtotalExento.toFixed(2));
                    $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));
                    $("#txtsubtotaliva2").val(SubtotalIva.toFixed(2));
                    $("#txtIva").val(ValorTotalIva.toFixed(2));
                    $("#txtIva2").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
    
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
        var Carrito               = new Object();
        Carrito.Id                = "vaciar";
        Carrito.Codigo            = "vaciar";
        Carrito.Producto          = "vaciar";
        Carrito.Descripcion       = "vaciar";
        Carrito.Imei              = "vaciar";
        Carrito.Condicion         = "vaciar";
        Carrito.Codmarca          = "vaciar";
        Carrito.Marcas            = "vaciar";
        Carrito.Codmodelo         = "vaciar";
        Carrito.Modelos           = "vaciar";
        Carrito.Codpresentacion   = "vaciar";
        Carrito.Presentacion      = "vaciar";
        Carrito.Codcolor          = "vaciar";
        Carrito.Color             = "vaciar";
        Carrito.Precio            = "vaciar";
        Carrito.Precio1           = "0";
        Carrito.Precio2           = "0";
        Carrito.Precio3           = "0";
        Carrito.DescproductoFact  = "0";
        Carrito.Descproducto      = "0";
        Carrito.PosicionImpuesto  = "0";
        Carrito.TipoImpuesto      = "vaciar";
        Carrito.Ivaproducto       = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.Lote              = "0";
        Carrito.Fechaelaboracion  = "vaciar";
        Carrito.Fechaexpiracion1  = "vaciar";
        Carrito.Fechaexpiracion2  = "vaciar";
        Carrito.Fechaexpiracion3  = "vaciar";
        Carrito.Optimo            = "vaciar";
        Carrito.Medio             = "vaciar";
        Carrito.Minimo            = "vaciar";
        Carrito.Cantidad          = "0";
        var DatosJson             = JSON.stringify(Carrito);
        $.post('carritocompra.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var nuevaFila = "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
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
        var nuevaFila = "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#saveposcompra")[0].reset();
        $("#formacompra").val("").attr('disabled', false);
        $("#fechavencecredito").val("").attr('disabled', true);
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
        $("#txtexento").val("0.00");
        $("#txtexento2").val("0.00");
        $("#txtsubtotaliva").val("0.00");
        $("#txtsubtotaliva2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtIva2").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
    });
});

//FUNCION PARA ACTUALIZAR DESCUENTO EN DETALLE
$(document).ready(function(){
    $('#descfactura').keyup(function(){
        if ($('input#descfactura').val() > 100) { 
            $("#descfactura").val("0.00");
            swal("Oops", "EL DESCUENTO NO PUEDE SER MAYOR A 100%!", "error");
            return false;
        }
    });
});

//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function(){
    //$('#descuento').on('blur', function(){
    $('#descuento').keyup(function(){

        if ($('input#descuento').val() > 100) {
              
            $("#descuento").val("0.00");
            swal("Oops", "EL DESCUENTO GLOBAL NO PUEDE SER MAYOR A 100%!", "error");
            //return false;
        }
    
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
        TotalFactura          = parseFloat(SubtotalConImpuesto.toFixed(2));  

        /*CALCULO SUBTOTAL*/
        $("#lblsubtotal").text(Separador(SubtotalSinImpuesto.toFixed(2)));
        $("#txtsubtotal").val(SubtotalSinImpuesto.toFixed(2));

        /*CALCULO EXENTO*/
        $("#lblexento").text(Separador(ValorExento.toFixed(2)));
        $("#txtexento").val(ValorExento.toFixed(2));
        
        /*CALCULO IVA*/
        $("#lblsubtotaliva").text(Separador(ValorSubtotalIva.toFixed(2)));
        $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));

        $("#lbliva").text(Separador(ValorTotalIva.toFixed(2)));
        $("#txtIva").val(ValorTotalIva.toFixed(2));

        /*CALCULO DESCUENTO*/
        $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));

        /*CALCULO TOTAL*/
        $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
        $("#txtTotal").val(TotalFactura.toFixed(2));
    });
});


//AGREGA DETALLE DE PRODUCTO CON ENTER
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            $('#AgregaProducto').trigger("click");
            return false;
        }
    });                    
});

//MUESTRO MODAL DE PAGO CON F2
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '113') {
        $("#btn-submit").trigger("click");
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
        $("#myModalProveedor").modal("toggle");
        $('#myModalProveedor').on('shown.bs.modal', function() {
        })
        return false;
        }
    });                    
});

function LimpiarTexto() {
    $("#search_producto_compra").val("");
    $("#search_producto_compra_barra").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codmarca").val("");
    $("#marcas").val("");
    $("#codmodelo").val("");
    $("#modelos").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#preciocompra").val("");
    $("#precioxmenor").val("0.00");
    $("#precioxmayor").val("0.00");
    $("#precioxpublico").val("0.00");
    $("#descfactura").val("0.00");
    $("#descproducto").val("0.00");
    $("#posicionimpuesto").val("");
    $("#tipoimpuesto").val("");
    $("#ivaproducto").val("");
    $("#precioconiva").val("0.00");
    $("#lote").val("0");
    $("#fechaelaboracion").val("");
    $("#fechaoptimo").val("");
    $("#fechamedio").val("");
    $("#fechaminimo").val("");
    $("#stockoptimo").val("");
    $("#stockmedio").val("");
    $("#stockminimo").val("");
    $("#cantidad").val("1");
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
                params[25],
                params[26],
                params[27],
                params[28],
                params[29],
                params[30],
                params[31],
                params[32],
                '='
            );
            element.attr('data-proc', '0');
            }
        }, 100);
    });
});


// FUNCION PARA MOSTRAR FORMA DE PAGO EN COMPRAS
function CargaFormaPagosCompras(){

    //var valor = $("#tipocompra").val();
    var valor = $('input:radio[name=tipocompra]:checked').val();

    if (valor === "" || valor === true) {
        $("#formacompra").attr('disabled', true);
        $("#fechavencecredito").attr('disabled', true);
    } else if (valor === "CONTADO" || valor === true) {
        $("#formacompra").attr('disabled', false);
        $("#fechavencecredito").attr('disabled', true);
    } else {
        $("#formacompra").attr('disabled', true);
        $("#fechavencecredito").attr('disabled', false);
    }
}

function addItem(id, codigo, cantidad, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio1, precio2, precio3, descproductofact, descproducto, posicionimpuesto, tipoimpuesto, ivaproducto, precioconiva, lote, fechaelaboracion, fechaexpiracion1, fechaexpiracion2, fechaexpiracion3, optimo, medio, minimo, opCantidad) {
    var Carrito              = new Object();
    Carrito.Id               = id;
    Carrito.Codigo           = codigo;
    Carrito.Producto         = producto;
    Carrito.Descripcion      = descripcion;
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
    Carrito.Precio1          = precio1;
    Carrito.Precio2          = precio2;
    Carrito.Precio3          = precio3;
    Carrito.DescproductoFact = descproductofact;
    Carrito.Descproducto     = descproducto;
    Carrito.PosicionImpuesto = posicionimpuesto;
    Carrito.TipoImpuesto     = tipoimpuesto;
    Carrito.Ivaproducto      = ivaproducto;
    Carrito.Precioconiva     = precioconiva;
    Carrito.Lote             = lote;
    Carrito.Fechaelaboracion = fechaelaboracion;
    Carrito.Fechaexpiracion1 = fechaexpiracion1;
    Carrito.Fechaexpiracion2 = fechaexpiracion2;
    Carrito.Fechaexpiracion3 = fechaexpiracion3;
    Carrito.Optimo           = optimo;
    Carrito.Medio            = medio;
    Carrito.Minimo           = minimo;
    Carrito.Cantidad         = cantidad;
    Carrito.opCantidad       = opCantidad;
    var DatosJson            = JSON.stringify(Carrito);
    $.post('carritocompra.php', {
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

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseFloat(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

                //CALCULO DEL TOTAL DE ITEMS
                var Items      = parseFloat(cantsincero);
                OperacionItems = parseFloat(OperacionItems) + parseFloat(Items);

                //CALCULO DEL VALOR TOTAL
                var ValorTotal  = parseFloat(item.precio) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var DetalleDescuento = ValorTotal * item.descproductofact / 100;
                TotalDescuento       = parseFloat(TotalDescuento) + parseFloat(DetalleDescuento);

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio * item.descproductofact / 100;
                var descconiva = item.precioconiva * item.descproductofact / 100;

                //CALCULO DE SUBTOTAL GENERAL
                var Operac    = parseFloat(item.precio) - parseFloat(descsiniva);
                var Operacion = parseFloat(Operac) * parseFloat(item.cantidad);
                Subtotal      = parseFloat(Subtotal) + parseFloat(Operacion);

                //CALCULO DE BASE IMPONIBLE IVA
                var Operac3         = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3      = parseFloat(Operac3) * parseFloat(item.cantidad);
                var SubBaseImponIva = Operacion3;

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
                TotalFactura          = parseFloat(SubtotalConImpuesto.toFixed(2));
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
                "'" + item.precio1 + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.precio3 + "', " +
                "'" + item.descproductofact + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.lote + "', " +
                "'" + item.fechaelaboracion + "', " +
                "'" + item.fechaexpiracion1 + "', " +
                "'" + item.fechaexpiracion2 + "', " +
                "'" + item.fechaexpiracion3 + "', " +
                "'" + item.optimo + "', " +
                "'" + item.medio + "', " +
                "'" + item.minimo + "', " +
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
                "'" + item.precio1 + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.precio3 + "', " +
                "'" + item.descproductofact + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.lote + "', " +
                "'" + item.fechaelaboracion + "', " +
                "'" + item.fechaexpiracion1 + "', " +
                "'" + item.fechaexpiracion2 + "', " +
                "'" + item.fechaexpiracion3 + "', " +
                "'" + item.optimo + "', " +
                "'" + item.medio + "', " +
                "'" + item.minimo + "', " +
                "'+'" +
                ')"' +
                " type='button'><span class='fa fa-plus'></span></button></td>" +
                "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.codmarca == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.codmodelo == '0' ? '******' : item.modelos) + ")</small></td>" +
                "<td><strong>" + Separador(item.precio) + "</strong></td>" +
                "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                "<td>" +
                
                '<span class="text-success" title="Editar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="AsignaPrecio(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio + "', " +
                "'" + item.descproductofact + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></span> ' +

                '<span class="text-danger" title="Eliminar Detalle" style="cursor:pointer;color:#fff;" ' +
                'onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'0'," +
                "'" + item.producto + "'," +
                "'" + item.descripcion + "'," +
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
                "'" + item.precio1 + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.precio3 + "', " +
                "'" + item.descproductofact + "', " +
                "'" + item.descproducto + "', " +
                "'" + item.posicionimpuesto + "', " +
                "'" + item.tipoimpuesto + "', " +
                "'" + item.ivaproducto + "', " +
                "'" + item.precioconiva + "', " +
                "'" + item.lote + "', " +
                "'" + item.fechaelaboracion + "', " +
                "'" + item.fechaexpiracion1 + "', " +
                "'" + item.fechaexpiracion2 + "', " +
                "'" + item.fechaexpiracion3 + "', " +
                "'" + item.optimo + "', " +
                "'" + item.medio + "', " +
                "'" + item.minimo + "', " +
                "'='" +
                ')"' +
                ' title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>' +
                "</td>" +
                "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                                
                    $("#lblitems").text(Separador(OperacionItems.toFixed(2)));
                    $("#lblsubtotal").text(Separador(ValorSubTotalFactura.toFixed(2)));
                    $("#lblexento").text(Separador(ValorExento.toFixed(2)));
                    $("#lblsubtotaliva").text(Separador(ValorSubtotalIva.toFixed(2)));
                    $("#lbliva").text(Separador(ValorTotalIva.toFixed(2)));
                    $("#lbldescontado").text(Separador(TotalDescuento.toFixed(2)));
                    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
                    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));

                    $("#txtsubtotal").val(ValorSubTotalFactura.toFixed(2));
                    $("#txtsubtotal2").val(SubTotalFactura.toFixed(2));
                    $("#txtexento").val(ValorExento.toFixed(2));
                    $("#txtexento2").val(SubtotalExento.toFixed(2));
                    $("#txtsubtotaliva").val(ValorSubtotalIva.toFixed(2));
                    $("#txtsubtotaliva2").val(SubtotalIva.toFixed(2));
                    $("#txtIva").val(ValorTotalIva.toFixed(2));
                    $("#txtIva2").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila = "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#saveposcompra")[0].reset();
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
                $("#txtexento").val("0.00");
                $("#txtexento2").val("0.00");
                $("#txtsubtotaliva").val("0.00");
                $("#txtsubtotaliva2").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtIva2").val("0.00");
                $("#txtdescontado").val("0.00");
                $("#txtDescuento").val("0.00");
                $("#txtTotal").val("0.00");
            }
        },
        "json"
    );
    return false;
}