<?php

include_once "config.php";
include_once "entidades/tipoproducto.php";


$tipoproducto = new Tipoproducto();
$tipoproducto->cargarFormulario($_REQUEST);

if($_POST){

  if(isset($_POST["btnGuardar"])){
    if(isset($_GET["id"]) && $_GET["id"] > 0){
      //Actualizo un cliente existente
      $tipoproducto->actualizar();
    } else {
      //Es nuevo
      $tipoproducto->insertar();
    }
  } else if(isset($_POST["btnBorrar"])){
    $tipoproducto->eliminar();
    header("Location: tipoproductos-listado.php");
  } 
}  

if(isset($_GET["id"]) && $_GET["id"] > 0){
    $tipoproducto->obtenerPorId();
 
  }

include_once ("header.php");

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Tipo de productos</h1>
           <div class="row">
                <div class="col-12 mb-3">
                    <a href="tipoproductos-listado.php" class="btn btn-primary mr-2">Listado</a>
                    <a href="tipoproducto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                    <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                    <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre" value="<?php echo $tipoproducto->nombre;?>">
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


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