<?php
require_once('class/class.php');
$accesos = ['administradorG', 'administradorS', 'secretaria'];
validarAccesos($accesos) or die();

$tra = new Login();

// Obtener parámetros
$codsucursal = isset($_GET['codsucursal']) ? decrypt($_GET['codsucursal']) : '';
$busqueda = isset($_GET['busqueda']) ? limpiar($_GET['busqueda']) : '';

// Si es petición AJAX para búsqueda
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    header('Content-Type: application/json');
    
    if (empty($codsucursal)) {
        echo json_encode(['error' => 'No se especificó la sucursal']);
        exit;
    }
    
    $productos = $tra->BuscarProductosPadre($codsucursal, $busqueda);
    echo json_encode($productos);
    exit;
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Producto Padre</title>
    
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    
    <style>
        body { padding: 20px; background: #fff; }
        .tabla-productos { width: 100%; }
        .btn-seleccionar { cursor: pointer; }
        .search-box { margin-bottom: 15px; }
        .search-box input { 
            width: 100%; 
            padding: 10px 15px; 
            border: 2px solid #ddd; 
            border-radius: 5px;
            font-size: 14px;
        }
        .search-box input:focus {
            border-color: #ef5350;
            outline: none;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <h4 class="text-danger"><i class="fa fa-cubes"></i> Seleccionar Producto Padre</h4>
        <hr>
        
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> Seleccione el producto <strong>PADRE</strong> que manejará el stock físico de este producto hijo.
        </div>
        
        <div class="search-box">
            <input type="text" id="inputBusqueda" placeholder="Escriba para buscar por código o nombre de producto..." autofocus>
        </div>
        
        <div class="table-container">
            <table class="table table-bordered table-striped tabla-productos">
                <thead class="bg-danger text-white">
                    <tr>
                        <th width="15%">Código</th>
                        <th width="45%">Producto</th>
                        <th width="15%">Existencia</th>
                        <th width="15%">Precio</th>
                        <th width="10%">Acción</th>
                    </tr>
                </thead>
                <tbody id="tbodyProductos">
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            <i class="fa fa-keyboard-o"></i> Escriba en el campo de búsqueda para encontrar productos
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="assets/script/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    
    <script type="text/javascript">
    var codsucursal = '<?php echo isset($_GET['codsucursal']) ? $_GET['codsucursal'] : ''; ?>';
    var timeoutBusqueda = null;
    
    $(document).ready(function() {
        // Cargar productos iniciales
        buscarProductos('');
        
        // Búsqueda en tiempo real
        $('#inputBusqueda').on('keyup', function() {
            var busqueda = $(this).val();
            
            // Cancelar búsqueda anterior
            if (timeoutBusqueda) {
                clearTimeout(timeoutBusqueda);
            }
            
            // Esperar 300ms antes de buscar
            timeoutBusqueda = setTimeout(function() {
                buscarProductos(busqueda);
            }, 300);
        });
    });
    
    function buscarProductos(busqueda) {
        $('#tbodyProductos').html('<tr><td colspan="5" class="loading"><i class="fa fa-spinner fa-spin"></i> Buscando productos...</td></tr>');
        
        $.ajax({
            url: 'modal_buscar_producto_padre.php',
            type: 'GET',
            data: {
                ajax: 1,
                codsucursal: codsucursal,
                busqueda: busqueda
            },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    $('#tbodyProductos').html('<tr><td colspan="5" class="text-center text-danger">' + data.error + '</td></tr>');
                    return;
                }
                
                if (data.length === 0) {
                    $('#tbodyProductos').html('<tr><td colspan="5" class="no-results"><i class="fa fa-search"></i> No se encontraron productos</td></tr>');
                    return;
                }
                
                var html = '';
                $.each(data, function(i, prod) {
                    var existencia = parseFloat(prod.existencia).toFixed(2);
                    var precio = parseFloat(prod.precioxpublico).toFixed(2);
                    var nombreEscapado = prod.producto.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    
                    html += '<tr>';
                    html += '<td>' + prod.codproducto + '</td>';
                    html += '<td>' + prod.producto + '</td>';
                    html += '<td class="text-right">' + existencia + '</td>';
                    html += '<td class="text-right">' + precio + '</td>';
                    html += '<td class="text-center">';
                    html += '<button type="button" class="btn btn-sm btn-danger" onclick="seleccionarProducto(\'' + prod.idproducto + '\', \'' + prod.codproducto + '\', \'' + nombreEscapado + '\')">';
                    html += '<i class="fa fa-check"></i>';
                    html += '</button>';
                    html += '</td>';
                    html += '</tr>';
                });
                
                $('#tbodyProductos').html(html);
            },
            error: function(xhr, status, error) {
                $('#tbodyProductos').html('<tr><td colspan="5" class="text-center text-danger">Error al buscar productos: ' + error + '</td></tr>');
            }
        });
    }

    function seleccionarProducto(idproducto, codproducto, nomproducto) {
        // Enviar datos a la ventana padre
        if (window.opener && !window.opener.closed) {
            window.opener.document.getElementById('producto_padre_id').value = idproducto;
            window.opener.document.getElementById('producto_padre_nombre').value = codproducto + ' - ' + nomproducto;
            window.close();
        } else {
            alert('No se pudo comunicar con la ventana principal. Por favor cierre esta ventana y vuelva a intentar.');
        }
    }
    </script>
</body>
</html>
