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
                  <th>Código</th>
                  <th>Razao Social</th>
                  <th>CNPJ</th>
                  <th>Celular</th>
                  <th>Rua</th>
                  <th>Cidade</th>
                  <th>UF</th>
                  <th>pais</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <?
                $SQL = "select * from empresa order by ds_razao_social";
                $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
                while ($RS = mysqli_fetch_array($RSS)) {
                  echo "<tr onClick='Clica(" . $RS["cd_empresa"] . ")' >";
                  echo "<td>" . $RS["cd_empresa"] . "</td>";
                  echo "<td>" . $RS["ds_razao_social"] . "</td>";
                  echo "<td>" . $RS["ds_cnpj"] . "</td>";
                  echo "<td>" . $RS["ds_celular"] . "</td>";
                  echo "<td>" . $RS["ds_rua"] . "</td>";
                  echo "<td>" . $RS["ds_cidade"] . "</td>";
                  echo "<td>" . $RS["ds_uf"] . "</td>";
                  echo "<td>" . $RS["ds_pais"] . "</td>";
                  echo "<td>" . $RS["ds_email"] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>Código</th>
                  <th>Razao Social</th>
                  <th>CNPJ</th>
                  <th>Celular</th>
                  <th>Rua</th>
                  <th>Cidade</th>
                  <th>UF</th>
                  <th>pais</th>
                  <th>Email</th>
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
  function Clica(cd_empresa) {
    window.open('menu.php?modulo=cadastro_empresas&cd_empresa=' + cd_empresa, "_self");
  }

  function Novo() {
    window.location.href = 'menu.php?modulo=cadastro_empresas'
  }
</script>