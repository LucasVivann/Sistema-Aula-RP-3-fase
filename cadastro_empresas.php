<script type="text/javascript">
	$(function() {
		$('#ds_uf').click(function() {
			if ($(this).val()) {
				$('#ds_cidade').hide();
				$('.carregando').show();
				$.getJSON('ajax_cidade.php?search=', {
					ds_uf: $(this).val(),
					ajax: 'true'
				}, function(j) {
					var options = '<option value="">Escolha uma cidade</option>';
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].ds_cidade + '">' + j[i].ds_cidade + '</option>';
					}
					$('#ds_cidade').html(options).show();
					$('.carregando').hide();
				});
			} else {
				$('#ds_cidade').html('<option value="">– Escolha uma uf –</option>');
			}
		});
	});
</script>
<?

$acao		= $_REQUEST['acao'];
$cd_empresa	= intval($_REQUEST['cd_empresa']);
if ($acao == "excluir") {
	echo "DELETE FROM empresa where cd_empresa=$cd_empresa";
	$RSS = mysqli_query($conexao, "DELETE FROM empresa where cd_empresa=$cd_empresa");
	$cd_empresa = 0;
	echo "<script language='JavaScript'>alert('Cadastro deletado com sucesso.');</script>";
}

if ($acao == "salvar") {
	$SQL = "select * from empresa where cd_empresa=" . $cd_empresa;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS);
	//If ( $RSX["cd_empresa"] == $cd_empresa )
	if ($cd_empresa > 0) {
		$SQL  = "update empresa set ds_razao_social='" . addslashes($_REQUEST['ds_razao_social']) . "',";
		$SQL .= "ds_contato='" . addslashes($_REQUEST['ds_contato']) . "', ";
		$SQL .= "ds_cnpj='" . addslashes($_REQUEST['ds_cnpj']) . "', ";
		$SQL .= "ds_email='" . addslashes($_REQUEST['ds_email']) . "', ";
		$SQL .= "ds_cidade='" . addslashes($_REQUEST['ds_cidade']) . "', ";
		$SQL .= "ds_rua='" . addslashes($_REQUEST['ds_rua']) . "' ";

		$SQL .= "ds_uf='" . addslashes($_REQUEST['ds_uf']) . "' ";
		$SQL .= "ds_pais='" . addslashes($_REQUEST['ds_pais']) . "' ";

		$SQL .= "where cd_empresa = '" . $RSX["cd_empresa"] . "'";
		$RSS = mysqli_query($conexao, $SQL) or die($SQL);
		echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} else {
		$SQL  = "Insert into empresa (ds_razao_social,ds_contato,ds_cnpj,ds_email,ds_cidade,ds_rua,ds_uf,ds_pais) ";
		$SQL .= "VALUES ('" . addslashes($_REQUEST['ds_razao_social']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_contato']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_cnpj']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_email']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_cidade']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_rua']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_uf']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_pais']) . "')";
		$RSS = mysqli_query($conexao, $SQL) or die('erro');

		$SQL = "select * from empresa  order by cd_empresa desc limit 1";
		$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS);
		$cd_empresa = $RSX["cd_empresa"];
		//	echo "<script>alert('Registro Inserido.');</script>";
	}
	echo "<script>window.open('menu.php?modulo=Lista_empresas', '_self');</script>";
}

$SQL = "select * from empresa where cd_empresa = $cd_empresa";
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
						<h3 class="card-title">Cadastro de Empresas <? echo $cd_empresa; ?> </h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form action='menu.php' method='post'>
						<input type='hidden' name='acao' id='acao' value='salvar'>
						<input type='hidden' name='modulo' id='modulo' value='cadastro_empresas'>
						<input type='hidden' name='cd_empresa' id='cd_empresa' value='<? echo intval($cd_empresa); ?>'>
						<div class="card-body">
							<div class="form-group">
								<label for="">Razão Social</label>
								<input type="text" class="form-control" id="ds_razao_social" name="ds_razao_social" placeholder="Nome ..." value='<? echo $RS["ds_razao_social"]; ?>'>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">CNPJ da Empresa</label>
										<input type="text" class="form-control" id="ds_cnpj" name="ds_cnpj" placeholder="CPF ..." value='<? echo $RS["ds_cnpj"]; ?>'>
									</div>
									<div class="col-md-6">
										<label for="exampleInputEmail1">Rua</label>
										<input type="text" class="form-control" id="ds_rua" name="ds_rua" value='<? echo $RS["ds_rua"]; ?>'>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-3">
										<label for="uf" class="form-label">UF</span></label>
										<select id="ds_uf" name="ds_uf" class="form-control">
											<OPTION VALUE="<? echo $RS["ds_uf"]; ?>" SELECTED><? echo $RS["ds_uf"]; ?></OPTION>
											<?
											$RXX = $conexao->query("Select ds_uf from cidades group by ds_uf order by ds_uf") or print(mysqli_error($conexao));
											while ($RX = $RXX->fetch_array()) {
												echo "<option value='" . $RX["ds_uf"] . "' >" . $RX["ds_uf"] . "</option>";
											}
											?>
										</select>
									</div>
									<div class="col-9">
										<label for="cidade" class="form-label">Cidade</label>
										<div>
											<span class="carregando" style='display:none;'>Aguarde, carregando...</span>
											<select id="ds_cidade" name="ds_cidade" class="form-control">
												<OPTION VALUE="<? echo $RS["ds_cidade"]; ?>" SELECTED><? echo $RS["ds_cidade"]; ?></OPTION>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<label for="">Pais</label>
								<input type="text" class="form-control" id="ds_pais" name="ds_pais" value='<? echo $RS["ds_pais"]; ?>'>
							</div>

							<div class="col-md-6">
								<label for="">Celular</label>
								<input type="text" class="form-control" id="ds_contato" name="ds_contato" value='<? echo $RS["ds_contato"]; ?>'>

							</div>
						</div>

						<div class="form-group">
							<label for="exampleInputEmail1">Email</label>
							<input type="email" class="form-control" id="ds_email" name="ds_email" placeholder="Enter email" value='<? echo $RS["ds_email"]; ?>'>
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
					<input type="button" value='Excluir' onclick='exclui(<?= $cd_empresa; ?>);'>
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
		function Clica(cd_empresa) {
			window.open('menu.php?modulo=lista_empresa&cd_empresa=' + cd_empresa, "_self");
		}

		function exclui(cd_empresa) {
			if (confirm('Confirma a exclusao ?')) {
				window.open('menu.php?modulo=cadastro_empresas&acao=excluir&cd_empresa=' + cd_empresa, "_self");


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

			window.location.href = 'menu.php?modulo=lista_empresas'
		}
	</script>