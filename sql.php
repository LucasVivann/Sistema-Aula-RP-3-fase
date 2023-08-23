<?
include_once "conexao.php";
if ($_POST["acao"] == "atualiza_oi") {
    $SQL = "update orcamento_itens set vl_quantidade = " . $_POST["vl_qu"] . ", vl_unitario =" . $_POST["vl_un"] . " where cd_oi = " . $_POST["cd_oi"];
    $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());

    $SQL = "update orcamentos set vl_valor = (Select sum(vl_quantidade*vl_unitario) from orcamento_itens where cd_orcamento_oi = " . $_POST["cd_or"] . ") where cd_orcamento = " . $_POST["cd_or"];
    $RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());

    $SQL = "Select * from orcamentos where cd_orcamento = " . $_POST["cd_or"];
    $RDD = mysqli_query($conexao, $SQL) or print(mysqli_error());
    $RD = mysqli_fetch_assoc($RDD);
}
echo "<script>parent.document.getElementById('vl_valor').value='" . $RD["vl_valor"] . "';</script>";
