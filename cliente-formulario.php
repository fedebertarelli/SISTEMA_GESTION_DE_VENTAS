<?php

include_once "config.php";
include_once "entidades/cliente.php";

$cliente = new Cliente();
$cliente->cargarFormulario($_REQUEST);

if($_POST){

  if(isset($_POST["btnGuardar"])){
    if(isset($_GET["id"]) && $_GET["id"] > 0){
      //Actualizo un cliente existente
      $cliente->actualizar();
    } else {
      //Es nuevo
      $cliente->insertar();
    }
  } else if(isset($_POST["btnBorrar"])){
    $cliente->eliminar();
    header("Location: clientes-listado.php");
  } 
}  

if(isset($_GET["id"]) && $_GET["id"] > 0){
    $cliente->obtenerPorId();
 
  }

include_once ("header.php");

?>

        <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Cliente</h1>
            <div class="row">
              <div class="col-12 mb-3">
                  <a href="clientes-listado.php" class="btn btn-primary mr-2">Listado</a>
                  <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                  <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
                  <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
              </div>
            </div>
            <div class="row">
              <div class="col-6 form-group">
                  <label for="txtNombre">Nombre:</label>
                  <input type="text" required class="form-control" name="txtNombre" id="txtNombre"
                  value="<?php echo  $cliente->nombre ?>">
              </div>
              <div class="col-6 form-group">
                  <label for="txtCuit">CUIT:</label>
                  <input type="text" required class="form-control" name="txtCuit" id="txtCuit" value="<?php echo  $cliente->cuit ?>" maxlength="11">
              </div>
              <div class="col-6 form-group">
                  <label for="txtCorreo">Correo:</label>
                  <input type="" class="form-control" name="txtCorreo" id="txtCorreo" required value="<?php echo  $cliente->correo ?>">
              </div>
              <div class="col-6 form-group">
                  <label for="txtTelefono">Teléfono:</label>
                  <input type="number" class="form-control" name="txtTelefono" id="txtTelefono" value="<?php echo  $cliente->telefono ?>">
              </div>
              <div class="col-6 form-group">
                  <label for="txtFechaNac" class="d-block">Fecha de nacimiento:</label>
                  <select class="form-control d-inline"  name="txtDiaNac" id="txtDiaNac" style="width: 80px">
                      <option selected="" disabled="">DD</option>
                      <?php for($i=1; $i <= 31; $i++): ?>
                          <?php if($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "d")): ?>
                          <option selected><?php echo $i; ?></option>
                          <?php else: ?>
                          <option><?php echo $i; ?></option>
                          <?php endif; ?>
                      <?php endfor; ?>
                  </select>
                  <select class="form-control d-inline"  name="txtMesNac" id="txtMesNac" style="width: 80px">
                      <option selected="" disabled="">MM</option>
                      <?php for($i=1; $i <= 12; $i++): ?>
                          <?php if($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "m")): ?>
                          <option selected><?php echo $i; ?></option>
                          <?php else: ?>
                          <option><?php echo $i; ?></option>
                          <?php endif; ?>
                      <?php endfor; ?>
                  </select>
                  <select class="form-control d-inline"  name="txtAnioNac" id="txtAnioNac" style="width: 100px">
                      <option selected="" disabled="">YYYY</option>
                      <?php for($i=1900; $i <= date("Y"); $i++): ?>
                        <?php if($cliente->fecha_nac != "" && $i == date_format(date_create($cliente->fecha_nac), "Y")): ?>
                          <option selected><?php echo $i; ?></option>
                          <?php else: ?>
                          <option><?php echo $i; ?></option>
                          <?php endif; ?>
                      <?php endfor; ?>
                  </select>
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