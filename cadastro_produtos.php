<?
$acao		= $_REQUEST['acao'];
$cd_produto	= intval($_REQUEST['cd_produto']);
if ($acao == "excluir") {
	echo "DELETE FROM produto where cd_produto=$cd_produto";
	$RSS = mysqli_query($conexao, "DELETE FROM produto where cd_produto=$cd_produto");
	$cd_produto = 0;
}

if ($acao == "salvar") {
	$SQL = "select * from produto where cd_produto=" . $cd_produto;
	echo $SQL;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS);
	//	if ($RSX["cd_produto"] == $cd_produto) {
	if ($cd_produto > 0) {
		$SQL  = "update produto set nome_do_produto='" . addslashes($_REQUEST['nome_do_produto']) . "',";
		//$SQL .= "nome_do_produto='" . addslashes($_REQUEST['nome_do_produto']) . "', ";
		$SQL .= "fornecedor='" . addslashes($_REQUEST['fornecedor']) . "', ";
		$SQL .= "vl_estoque='" . addslashes($_REQUEST['vl_estoque']) . "', ";
		$SQL .= "valor_de_venda='" . addslashes($_REQUEST['valor_de_venda']) . "', ";
		$SQL .= "numero_fornecedor='" . addslashes($_REQUEST['numero_fornecedor']) . "', ";
		$SQL .= "data_de_compra='" . addslashes($_REQUEST['data_de_compra']) . "', ";
		$SQL .= "ds_unidade='" . addslashes($_REQUEST['ds_unidade']) . "' ";
		$SQL .= "where cd_produto = '" . $RSX["cd_produto"] . "'";
		echo $SQL;
		$RSS = mysqli_query($conexao, $SQL) or die($SQL);

		echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} else {
		$SQL  = "Insert into produto (nome_do_produto, vl_estoque, data_de_compra, fornecedor, numero_fornecedor,  ds_unidade, valor_de_venda) ";
		$SQL .= "VALUES ('" . addslashes($_REQUEST['nome_do_produto']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['vl_estoque']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['data_de_compra']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['fornecedor']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['numero_fornecedor']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_unidade']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['valor_de_venda']) . "')";
		echo $SQL;
		$RSS = mysqli_query($conexao, $SQL) or die('erro');
		echo $SQL;

		$SQL = "select * from produto order by cd_produto desc ";
		$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS);
		$cd_produto = $RSX["cd_produto"];
		echo "<script>alert('Registro Inserido.');</script>";
	}
	echo "<script>window.open('menu.php?modulo=lista_produtos', '_self');</script>";
}

$SQL = "select * from produto where cd_produto = $cd_produto";
$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);

?>

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Cadastro de produto<? echo $cd_produto; ?> </h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form action='menu.php' method='post'>
						<input type='hidden' name='acao' id='acao' value='salvar'>
						<input type='hidden' name='modulo' id='modulo' value='cadastro_produtos'>
						<input type='hidden' name='cd_produto' id='cd_produto' value='<? echo intval($cd_produto); ?>'>
						<div class="card-body">
							<div class="form-group">
								<label for="">Nome do Produto</label>
								<input type="text" class="form-control" id="nome_do_produto" name="nome_do_produto" placeholder="Nome ..." value='<? echo $RS["nome_do_produto"]; ?>'>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">Quantidade</label>
										<input type="text" class="form-control" id="vl_estoque" name="vl_estoque" placeholder="quantidade..." value='<? echo $RS["valor"]; ?>'>
									</div>
									<div class="col-md-6">
										<label for="exampleInputEmail1">data de compra</label>
										<input type="date" class="form-control" id="data_de_compra" name="data_de_compra" value='
							 <? echo $RS["data_de_compra"]; ?>'>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">Fornecedor</label>
										<input type="text" class="form-control" id="fornecedor" name="fornecedor" placeholder="Nome do fornecedor" value='<? echo $RS["fornecedor"]; ?>'>
									</div>
									<div class="col-md-6">
										<label for="">numero fornecedor</label>
										<input type="number" class="form-control" id="numero_fornecedor" name="numero_fornecedor" value='<? echo $RS["numero_fornecedor"]; ?>'>
									</div>

									<div class="col-md-6">
										<label for="">unidade</label>
										<input type="text" class="form-control" id="ds_unidade" name="ds_unidade" value='<? echo $RS["ds_unidade"]; ?>'>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label for="exampleInputEmail1">Valor De Venda</label>
								<input type="numeric" class="form-control" id="valor_de_venda" name="valor_de_venda" placeholder="valor_de_venda" value='<? echo $RS["valor_de_venda"]; ?>'>
							</div>

							<div class="form-group">
								<label for="exampleInputFile">Carregar Foto</label>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="exampleInputFile">
										<label class="custom-file-label" for="exampleInputFile">Escolher arquivo</label>
									</div>
									<div class="input-group-append">
										<span class="input-group-text">Upload</span>
									</div>
								</div>
							</div>
						</div>
						<!-- /.card-body -->

						<div align="center">

							<input type="submit" value='Salvar' onclick='salvar()'>
							<input type="button" value='Excluir' onclick='exclui(<?= $cd_produto; ?>);'>
							<input type="button" value='Tabela' onclick='tabela()'>
						</div>


					</form>
				</div>
			</div>

		</div>
	</div>
</section>
<div>


	<script language="javascript">
		function Clica(cd_produto) {
			window.open('menu.php?modulo=lista_produtos&cd_produto=' + cd_produto, "_self");
		}

		function exclui(cd_produto) {
			if (confirm('Confirma a exclusao ?')) {
				window.open('menu.php?modulo=cadastro_produtos&acao=excluir&cd_produto=' + cd_produto, "_self");


			}
		}

		function salvar() {
			if (forma.tb_aluno.value.length == 0) {
				alert('Prencher nome ');
			} else if (forma.tb_diciplina.value.length == 0) {
				alert('Preencha cidade');
			} else {
				forma.submit();
			}
		}

		function tabela() {

			window.location.href = 'menu.php?modulo=lista_produtos'
		}
	</script>