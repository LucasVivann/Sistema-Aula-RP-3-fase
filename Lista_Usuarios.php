<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">DataTable with minimal features & hover style</h3>
          </div>
          <input type="button" value='Novo' onclick='Novo()'>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Usuário</th>
                  <th>CPF</th>
                  <th>Celular</th>
                </tr>
              </thead>
              <tbody>
                <?
                $SQL = "select * from usuario order by ds_usuario";
                $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
                while ($RS = mysqli_fetch_array($RSS)) {
                  echo "<tr onClick='Clica(" . $RS["cd_usuario"] . ")' >";
                  echo "<td>" . $RS["cd_usuario"] . "</td>";
                  echo "<td>" . $RS["ds_usuario"] . "</td>";
                  echo "<td>" . $RS["ds_cpf"] . "</td>";
                  echo "<td>" . $RS["ds_celular"] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Codigo</th>
                  <th>Usuário</th>
                  <th>CPF</th>
                  <th>Celular</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
          </div>

          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->



<script>
  function Clica(cd_usuario) {
    window.open('menu.php?modulo=cadastro_usuario&cd_usuario=' + cd_usuario, "_self");
  }

  function Novo() {
    window.location.href = 'menu.php?modulo=cadastro_usuario'
  }
</script>