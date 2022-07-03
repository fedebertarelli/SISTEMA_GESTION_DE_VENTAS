<?php

include_once "config.php";
include_once "entidades/venta.php";
include_once "entidades/cliente.php";
include_once "entidades/producto.php";

$venta = new Venta();
$venta->cargarFormulario($_REQUEST);

$entidadCliente = new Cliente();
$aClientes = $entidadCliente->obtenerTodos();

$entidadProducto = new Producto();
$aProductos = $entidadProducto->obtenerTodos();


if($_POST){

  if(isset($_POST["btnGuardar"])){
    if(isset($_GET["id"]) && $_GET["id"] > 0){
      //Actualizo un cliente existente
      $venta->actualizar();
    } else {
      //Es nuevo
      $producto = new Producto();
      $producto-> idproducto = $venta->fk_idproducto;
      $producto->obtenerPorId();
      if($venta->cantidad <= $producto->cantidad){
        $total = $venta -> cantidad * $producto -> precio;
        $venta->total = $total;
        $venta->insertar();
      } else{
        $msg = "No hay stcko suficiente";
      }
    }
  } else if(isset($_POST["btnBorrar"])){
    $venta->eliminar();
    header("Location: ventas-listado.php");
  } 
}  

if(isset($_GET["id"]) && $_GET["id"] > 0){
    $venta->obtenerPorId();
 
  }

if(isset($_GET["do"]) && $_GET["do"] =="buscarProducto"){
  $aResultado = array();
  $idProducto = $_GET["id"];
  $producto = new Producto();
  $producto-> idproducto = $idProducto;
  $producto->obtenerPorId();
  $aResultado["precio"] = $producto->precio;
  $aResultado["cantidad"] = $producto->cantidad;
  $aResultado["stock"] = $producto->actualizarStock($idProducto);

  echo json_encode($aResultado);
  exit;
}

include_once ("header.php");

?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Venta</h1>
            <div class="row">
                <div class="col-12 mb-3">
                    <a href="ventas-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="venta-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <label for="txtFechaNac" class="d-block">Fecha y hora:</label>
                    <select class="form-control d-inline" name="txtDia" id="txtDia" style="width: 80px">
                        <option selected="" disabled="">DD</option>
                        <?php for($i=1; $i <= 31; $i++): ?>
                          <?php if($venta->fecha != "" && $i == date_format(date_create($venta->fecha), "d")): ?>
                          <option selected><?php echo $i; ?></option>
                          <?php else: ?>
                          <option><?php echo $i; ?></option>
                          <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control d-inline" name="txtMes" id="txtMes" style="width: 80px">
                        <option selected="" disabled="">MM</option>
                        <?php for($i=1; $i <= 12; $i++): ?>
                          <?php if($venta->fecha != "" && $i == date_format(date_create($venta->fecha), "m")): ?>
                          <option selected><?php echo $i; ?></option>
                          <?php else: ?>
                          <option><?php echo $i; ?></option>
                          <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <select class="form-control d-inline" name="txtAnio" id="txtAnio" style="width: 100px">
                        <option selected="" disabled="">YYYY</option>
                        <?php for($i=1900; $i <= date("Y"); $i++): ?>
                          <?php if($venta->fecha != "" && $i == date_format(date_create($venta->fecha), "Y")): ?>
                          <option selected><?php echo $i; ?></option>
                          <?php else: ?>
                          <option><?php echo $i; ?></option>
                          <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    <input type="time" required="" class="form-control d-inline" style="width: 120px" name="txtHora" id="txtHora" value="<?php echo date_format(date_create($venta->fecha), "H:i"); ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="lstCliente">Cliente:</label>
                    <select required="" class="form-control selectpicker" data-live-search="true" name="lstCliente" id="lstCliente">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach ($aClientes as $cliente): ?>
                          <?php if($cliente->idcliente == $venta->fk_idcliente): ?>
                            <option selected value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                          <?php else: ?>
                            <option value="<?php echo $cliente->idcliente; ?>"><?php echo $cliente->nombre; ?></option>
                          <?php endif; ?>
                          <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 form-group">
                    <label for="lstProducto">Producto:</label>
                    <select required="" class="form-control selectpicker" data-live-search="true" name="lstProducto" id="lstProducto" onchange="fBuscarPrecio();">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach ($aProductos as $producto): ?>
                          <?php if($producto->idproducto == $venta->fk_idproducto): ?>
                            <option selected value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
                          <?php else: ?>
                            <option value="<?php echo $producto->idproducto; ?>"><?php echo $producto->nombre; ?></option>
                          <?php endif; ?>
                          <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 form-group">
                    <label for="txtPrecioUni">Precio unitario:</label>
                    <input type="text" class="form-control" id="txtPrecioUniCurrency" value="<?php echo $venta->preciounitario; ?>" disabled>
                    <input type="hidden" class="form-control" name="txtPrecioUni" id="txtPrecioUni" value="<?php echo $venta->preciounitario; ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="text" class="form-control" name="txtCantidad" id="txtCantidad" value="0" onchange="fCalcularTotal();">
                    <span id="msgStock" class="text-danger" style="display:none;">No hay stock suficiente</span>
                </div>
                <div class="col-6 form-group">
                    <label for="txtTotal">Total:</label>
                    <input type="text" class="form-control" name="txtTotal" id="txtTotal" value="0">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<script>

function fBuscarPrecio(){
    var idProducto = $("#lstProducto option:selected").val();
      $.ajax({
            type: "GET",
            url: "venta-formulario.php?do=buscarProducto",
            data: { id:idProducto },
            async: true,
            dataType: "json",
            success: function (respuesta) {
                strResultado = Intl.NumberFormat("es-AR", {style: 'currency', currency: 'ARS'}).format(respuesta.precio);
                $("#txtPrecioUniCurrency").val(strResultado);
                $("#txtPrecioUni").val(respuesta.precio);
            }
        });

}

function fCalcularTotal(){
    var idProducto = $("#lstProducto option:selected").val();
    var precio = parseFloat($('#txtPrecioUni').val());
    var cantidad = parseInt($('#txtCantidad').val());
    

     $.ajax({
            type: "GET",
            url: "venta-formulario.php?do=buscarProducto",
            data: { id:idProducto },
            async: true,
            dataType: "json",
            success: function (respuesta) {
                let resultado = 0;
                if(cantidad <= respuesta.stock){
                    resultado = precio * cantidad;
                     $("#msgStock").hide();
                } else {
                    $("#msgStock").show();
                }
                strResultado = Intl.NumberFormat("es-AR", {style: 'currency', currency: 'ARS'}).format(resultado);
                $("#txtTotal").val(strResultado);
            }
        });
    
  } 


</script>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span><a href="https://depcsuite.com" target="_blank">Patrocinado por DePC Suite</a></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <form action="" method="POST">>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Desea salir del sistema?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Hacer clic en "Cerrar sesión" si deseas finalizar tu sesión actual.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" name="btnCerrar">Cerrar sesión</button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
  </form>
</body>

</html>
