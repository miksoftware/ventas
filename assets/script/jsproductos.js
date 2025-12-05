function Separador(x) {//SEPARADOR CON DECIMAL
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready(function() {

    $('#AgregaProducto').click(function() {
        AgregaProductos();
    });

    $('.agregaproducto').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
          AgregaProductos();
          e.preventDefault();
          return false;
        }
    });

    function AgregaProductos () {

        var code   = $('input#codproducto').val();
        var prod   = $('input#search_producto_sucursal').val();
        var cantp  = $('input#cantidad').val();
        var prec   = $('input#preciocompradet').val();
        var prec2  = $('input#precioventadet').val();
        var er_num = /^([0-9])*[.]?[0-9]*$/;
        cantp      = parseInt(cantp);
        cantp      = cantp;

        if (code == "") {
            $("#search_producto_sucursal").focus();
            $("#search_producto_sucursal").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE!", "error");
            return false;
        
        } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
            return false;

        } else if (isNaN($('#cantidad').val())) {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD!", "error");
            return false;
            
        } else {

        var Carrito             = new Object();
        Carrito.Id              = $('input#idproducto').val();
        Carrito.Codigo          = $('input#codproducto').val();
        Carrito.Producto        = $('input#producto').val();
        Carrito.Codmarca        = $('input#codmarca').val();
        Carrito.Marcas          = $('input#marcas').val();
        Carrito.Codmodelo       = $('input#codmodelo').val();
        Carrito.Modelos         = $('input#modelos').val();
        Carrito.Codpresentacion = $('input#codpresentacion').val();
        Carrito.Presentacion    = $('input#presentacion').val();
        Carrito.Precio          = $('input#preciocompradet').val();
        Carrito.Precio2         = $('input#precioventadet').val();
        Carrito.Cantidad        = $('input#cantidad').val();
        Carrito.opCantidad      = '+=';
        var DatosJson           = JSON.stringify(Carrito);
        $.post('carritoproducto.php', {
                MiCarrito: DatosJson
            },
        function(data, textStatus) {
        $("#carrito tbody").html("");
        var TotalDescuento = 0;
        var PrecioCompra   = 0;
        var PrecioVenta    = 0;
        var contador       = 0;

        $.each(data, function(i, item) {
            var cantsincero = item.cantidad;
            cantsincero     = parseFloat(cantsincero);
            if (cantsincero != 0) {
                contador = contador + 1;

                //CALCULO DEL PRECIO COMPRA
                var TotalCompra     = parseFloat(item.precio) * parseFloat(item.cantidad);
                PrecioCompra        = parseFloat(PrecioCompra) + parseFloat(TotalCompra);
                var OperacionCompra = parseFloat(item.precio) * parseFloat(item.cantidad);

                //CALCULO DEL PRECIO VENTA
                var TotalVenta      = parseFloat(item.precio2) * parseFloat(item.cantidad);
                PrecioVenta         = parseFloat(PrecioVenta) + parseFloat(TotalVenta);
                var OperacionVenta  = parseFloat(item.precio2) * parseFloat(item.cantidad);

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                "<td>" +
                '<button class="btn btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;background-color:#23a0d7;color:#ffffff;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'-1'," +
                "'" + item.producto + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'-'" +
                ')"' +
                " type='button'><span class='fa fa-minus'></span></button>" +
                "<input type='text' id='" + item.cantidad + "' class='bold' style='width:40px;height:34px;border:#f9d655;' value='" + item.cantidad + "'>" +
                '<button class="btn btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;background-color:#23a0d7;color:#ffffff;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'+1'," +
                "'" + item.producto + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'+'" +
                ')"' +
                " type='button'><span class='fa fa-plus'></span></button></td>" +
                "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") - MODELO (" + (item.modelos == '' ? '****' : item.modelos) + ")</small></td>" +
                "<td><strong>" + item.presentacion + "</strong></td>" +
                "<td><strong>" + Separador(OperacionCompra.toFixed(2)) + "</strong></td>" +
                "<td><strong>" + Separador(OperacionVenta.toFixed(2)) + "</strong></td>" +
                "<td>" +
                '<span class="text-danger" style="cursor:pointer;color:#fff;" ' +
                'onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'0'," +
                "'" + item.producto + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'='" +
                ')"' +
                ' title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>' +
                "</td>" +
                "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                    //$("#preciocompra").val(PrecioCompra.toFixed(2));
                    //$("#precioventa").val(PrecioVenta.toFixed(2));
                
                    }
                });

                $("#search_producto_sucursal").focus();
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
    Carrito.Codmarca        = "vaciar";
    Carrito.Marcas          = "vaciar";
    Carrito.Codmodelo       = "vaciar";
    Carrito.Modelos         = "vaciar";
    Carrito.Codpresentacion = "vaciar";
    Carrito.Presentacion    = "vaciar";
    Carrito.Precio          = "vaciar";
    Carrito.Precio2         = "0.00";
    Carrito.Cantidad        = "0";
    var DatosJson           = JSON.stringify(Carrito);
    $.post('carritoproducto.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var nuevaFila = "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
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
        var nuevaFila = "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#preciocompra").val("");
        $("#precioventa").val("");
    });
});

function LimpiarTexto() {
    $("#search_producto_combos").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#codmarca").val("");
    $("#marcas").val("");
    $("#codmodelo").val("");
    $("#modelos").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#preciocompradet").val("");
    $("#precioventadet").val("");
    $("#cantidad").val("1.00");
}


$("#carrito tbody").on('blur', 'input', function(e) {
    var element = $(this);
    var pvalue = element.val();
    /*var code = e.charCode || e.keyCode;
    var avalue = String.fromCharCode(code);*/
    var regx = /^[A-Za-z0-9 _.-]+$/;
    var action = element.siblings('button').first().attr('onclick');
    var params;
    //if (code !== 11 && /[^\d]/ig.test(avalue)) {
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
                params[10],
                params[11],
                '='
                );
                element.attr('data-proc', '0');
            }
        }, 100);
    });
});


function addItem(id, codigo, cantidad, producto, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, precio, precio2, opCantidad) {
    var Carrito             = new Object();
    Carrito.Id              = id;
    Carrito.Codigo          = codigo;
    Carrito.Producto        = producto;
    Carrito.Codmarca        = codmarca;
    Carrito.Marcas          = marcas;
    Carrito.Codmodelo       = codmodelo;
    Carrito.Modelos         = modelos;
    Carrito.Codpresentacion = codpresentacion;
    Carrito.Presentacion    = presentacion;
    Carrito.Precio          = precio;
    Carrito.Precio2         = precio2;
    Carrito.Cantidad        = cantidad;
    Carrito.opCantidad      = opCantidad;
    var DatosJson           = JSON.stringify(Carrito);
    $.post('carritoproducto.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var TotalDescuento = 0;
            var PrecioCompra   = 0;
            var PrecioVenta    = 0;
            var contador       = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero     = parseFloat(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

                //CALCULO DEL PRECIO COMPRA
                var TotalCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                PrecioCompra = parseFloat(PrecioCompra) + parseFloat(TotalCompra);
                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);

                //CALCULO DEL PRECIO VENTA
                var TotalVenta     = parseFloat(item.precio2) * parseFloat(item.cantidad);
                PrecioVenta        = parseFloat(PrecioVenta) + parseFloat(TotalVenta);
                var OperacionVenta = parseFloat(item.precio2) * parseFloat(item.cantidad);

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                "<td>" +
                '<button class="btn btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;background-color:#23a0d7;color:#ffffff;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'-1'," +
                "'" + item.producto + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'-'" +
                ')"' +
                " type='button'><span class='fa fa-minus'></span></button>" +
                "<input type='text' id='" + item.cantidad + "' class='bold' style='width:40px;height:34px;border:#f9d655;' value='" + item.cantidad + "'>" +
                '<button class="btn btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;background-color:#23a0d7;color:#ffffff;" onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'+1'," +
                "'" + item.producto + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'+'" +
                ')"' +
                " type='button'><span class='fa fa-plus'></span></button></td>" +
                "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") - MODELO (" + (item.modelos == '' ? '****' : item.modelos) + ")</small></td>" +
                "<td><strong>" + item.presentacion + "</strong></td>" +
                "<td><strong>" + Separador(OperacionCompra.toFixed(2)) + "</strong></td>" +
                "<td><strong>" + Separador(OperacionVenta.toFixed(2)) + "</strong></td>" +
                "<td>" +
                '<span class="text-danger" style="cursor:pointer;color:#fff;" ' +
                'onclick="addItem(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'0'," +
                "'" + item.producto + "'," +
                "'" + item.codmarca + "'," +
                "'" + item.marcas + "'," +
                "'" + item.codmodelo + "'," +
                "'" + item.modelos + "'," +
                "'" + item.codpresentacion + "'," +
                "'" + item.presentacion + "'," +
                "'" + item.precio + "', " +
                "'" + item.precio2 + "', " +
                "'='" +
                ')"' +
                ' title="Eliminar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 icon"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span>' +
                "</td>" +
                "</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                //$("#preciocompra").val(PrecioCompra.toFixed(2));
                //$("#precioventa").val(PrecioVenta.toFixed(2));
                             
                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila = "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                //$("#preciocompra").val("");
                //$("#precioventa").val("");
            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}