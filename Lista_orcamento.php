<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orçamentos</h1>
      </div>

    <table id="example"  style="width:100%">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Dia</th>
                <th>Cliente</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
        <?php
          include "conecta.php";
          //  $SQL = "select * from orcamentos,clientes where cd_cliente_orcamento=cd_cliente order by cd_orcamento";
          $SQL = "select * from orcamentos order by cd_orcamento";
          $RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
          while($RS = mysqli_fetch_array($RSS))
          {
            echo "<tr onClick='Clica(".$RS["cd_orcamento"].")' >";
            echo "<td>".$RS["cd_orcamento"]."</td>";
            echo "<td>".$RS["dt_orcamento"]."</td>";

            $RRR = mysqli_query($conexao,"Select ds_razao_social from empresa where cd_empresa = ".$RS["cd_cliente_orcamento"]);
            $RR = mysqli_fetch_assoc($RRR); 	

            echo "<td>".$RR["ds_razao_social"]."</td>";
            echo "<td>".$RS["vl_valor"]."</td>";
            echo "</tr>";
          }
        ?>
        </tbody>
    </table>

  </main>

<script>
  $(document).ready(function () {
    $('#example').DataTable();
  });


function Clica(cd_orcamento)
{
	window.open('menu.php?modulo=cadastro_orcamento&cd_orcamento='+cd_orcamento, "_self"); 
}  
</script>
