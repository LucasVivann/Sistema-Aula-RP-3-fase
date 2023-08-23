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
                  <th>Produto</th>
                  <th>Descrição do Produto</th>
                  <th>Valor</th>
                  <th>data de compra</th>
                  <th>Numero do fornecedor</th>

                </tr>
              </thead>
              <tbody>
                <?
                $SQL = "select * from produto order by nome_do_produto";
                $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
                while ($RS = mysqli_fetch_array($RSS)) {
                  echo "<tr onClick='Clica(" . $RS["cd_produto"] . ")' >";
                  echo "<td>" . $RS["cd_produto"] . "</td>";
                  echo "<td>" . $RS["nome_do_produto"] . "</td>";
                  echo "<td>" . $RS["fornecedor"] . "</td>";
                  echo "<td>" . $RS["valor_do_produto"] . "</td>";
                  echo "<td>" . $RS["valor_de_venda"] . "</td>";
                  echo "<td>" . $RS["data_de_compra"] . "</td>";
                  echo "<td>" . $RS["numero_fornecedor"] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
              <tfoot>
                <tr>

                  <th>Codigo</th>
                  <th>nome do produto</th>
                  <th>Fornecedor</th>
                  <th>Valor_do_produto</th>
                  <th></th>
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



          <!-- /.card-header -->

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
  function Clica(cd_produto) {
    window.open('menu.php?modulo=cadastro_produtos&cd_produto=' + cd_produto, "_self");
  }

  function Novo() {
    window.location.href = 'menu.php?modulo=cadastro_produtos'
  }
</script>