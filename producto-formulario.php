<?php

include_once "config.php";
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";

$pg = "Edición de producto";

$producto = new Producto();
$producto->cargarFormulario($_REQUEST);

if($_POST){
    if(isset($_POST["btnGuardar"])){
        if($_FILES["imagen"]["error"] === UPLOAD_ERR_OK){
          $nombreRandom = date("Ymdhmsi");
          $archivoTmp = $_FILES["imagen"]["tmp_name"];
          $nombreArchivo = $_FILES["imagen"]["name"];
          $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
          $nombreImagen = "$nombreRandom.$extension";
          move_uploaded_file($archivoTmp, "file/$nombreImagen");
        }

        if(isset($_GET["id"]) && $_GET["id"] > 0){
            $productoAnt = new Producto();
            $productoAnt->idproducto = $_GET["id"];
            $productoAnt->obtenerPorId();
            $imagenAnterior = $productoAnt->imagen;

            //Si es una actualizacion y se sube una imagen, elimina la anterior
            if($_FILES["imagen"]["error"] === UPLOAD_ERR_OK){
                if($imagenAnterior != ""){
                        unlink($imagenAnterior);
                }
            } else {
                //Si no viene ninguna imagen, setea como imagen la que habia previamente
                $nombreImagen= $imagenAnterior;
            }

            $producto->imagen = $nombreImagen;
            //Actualizo un cliente existente
            $producto->actualizar();
        } else {
            //Es nuevo
            $producto->imagen = $nombreImagen;
            $producto->insertar();
        }
    } else if(isset($_POST["btnBorrar"])){
        $producto->eliminar();
        header("Location: productos-listado.php");
    }
} 
if(isset($_GET["id"]) && $_GET["id"] > 0){
    $producto->obtenerPorId();
}

$tipoProducto = new Tipoproducto();
$aTipoProductos = $tipoProducto->obtenerTodos();

include_once("header.php"); 
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Productos</h1>
           <div class="row">
                <div class="col-12 mb-3">
                    <a href="productos-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $producto->nombre ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtNombre">Tipo de producto:</label>
                    <select name="lstTipoProducto" id="lstTipoProducto" class="form-control selectpicker" data-live-search="true">
                        <option value="" disabled selected>Seleccionar</option>
                        <?php foreach ($aTipoProductos as $tipo): ?>
                          <?php if($tipo->idtipoproducto == $producto->fk_idtipoproducto): ?>
                            <option selected value="<?php echo $tipo->idtipoproducto; ?>"><?php echo $tipo->nombre; ?></option>
                          <?php else: ?>
                            <option value="<?php echo $tipo->idtipoproducto; ?>"><?php echo $tipo->nombre; ?></option>
                          <?php endif; ?>
                          <?php endforeach; ?>
                    </select>
                </div>        
                <div class="col-6 form-group">
                    <label for="txtCantidad">Cantidad:</label>
                    <input type="number" required="" class="form-control" name="txtCantidad" id="txtCantidad" value="<?php echo $producto->cantidad ?>">
                </div>
                <div class="col-6 form-group">
                    <label for="txtPrecio">Precio:</label>
                    <input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $producto->precio ?>">
                </div>
                <div class="col-12 form-group">
                    <label for="txtCorreo">Descripción:</label>
                    <textarea type="text" name="txtDescripcion" id="txtDescripcion"><?php echo $producto->descripcion ?></textarea>
                </div>
                <div class="col-6 form-group">
                    <label for="fileImagen">Imagen:</label>
                    <input type="file" class="form-control-file" name="imagen" id="imagen">
                    <img src="file/<?php echo $producto->imagen;?>" class="img-thumbnail" style="height: 80px;">
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
        <script>
        ClassicEditor
            .create( document.querySelector( '#txtDescripcion' ) )
            .catch( error => {
            console.error( error );
            } );
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