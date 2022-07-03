<?php

include_once "config.php";
include_once "entidades/cliente.php";

$pg = "Listado de clientes";

$entidadCliente = new Cliente();
$aClientes = $entidadCliente->obtenerTodos();



include_once ("header.php");

?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Listado de clientes</h1>
          <div class="row">
                <div class="col-12 mb-3">
                    <a href="cliente-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                </div>
            </div>
          <table class="table table-hover border">
            <tr>
                <th>CUIT</th>
                <th>Nombre</th>
                <th>Fecha nac.</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($aClientes as $cliente): ?>
            <tr>
                  <td><?php echo $cliente-> cuit; ?></td>
                  <td><?php echo $cliente-> nombre; ?></td>
                  <td><?php echo date_format(date_create($cliente->fecha_nac), "d/m/Y"); ?></td>
                  <td><?php echo $cliente-> telefono; ?></td>
                  <td><?php echo $cliente-> correo; ?></td>
                  <td style="width: 110px;">
                    <a href="cliente-formulario.php?id=<?php echo $cliente->idcliente; ?>"><i class="fas fa-search"></i></a>   
                  </td>
              </tr>
              <?php endforeach; ?>
          </table>
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