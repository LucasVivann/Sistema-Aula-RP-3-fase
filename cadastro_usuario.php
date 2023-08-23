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
$cd_usuario	= intval($_REQUEST['cd_usuario']);
if ($acao == "excluir") {
	echo "DELETE FROM usuario where cd_usuario=$cd_usuario";
	$RSS = mysqli_query($conexao, "DELETE FROM usuario where cd_usuario=$cd_usuario");
	$cd_usuario = 0;
	echo "<script language='JavaScript'>alert('Cadastro deletado com sucesso.');</script>";
}

if ($acao == "salvar") {
	$SQL = "select * from usuario where cd_usuario=" . $cd_usuario;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS);
	//If ( $RSX["cd_usuario"] == $cd_usuario )
	if ($cd_usuario > 0) {
		$SQL  = "update usuario set ds_usuario='" . addslashes($_REQUEST['ds_usuario']) . "',";
		$SQL .= "ds_celular='" . addslashes($_REQUEST['ds_celular']) . "', ";
		$SQL .= "ds_cpf='" . addslashes($_REQUEST['ds_cpf']) . "', ";
		$SQL .= "ds_email='" . addslashes($_REQUEST['ds_email']) . "', ";
		$SQL .= "ds_senha='" . addslashes($_REQUEST['ds_senha']) . "', ";
		$SQL .= "ds_senha='" . addslashes($_REQUEST['ds_senha']) . "', ";
		$SQL .= "ds_uf='" . addslashes($_REQUEST['ds_uf']) . "', ";
		$SQL .= "ds_cidade='" . addslashes($_REQUEST['ds_cidade']) . "', ";
		$SQL .= "dt_nascimento='" . addslashes($_REQUEST['dt_nascimento']) . "' ";
		$SQL .= "where cd_usuario = '" . $RSX["cd_usuario"] . "'";
		$RSS = mysqli_query($conexao, $SQL) or die($SQL);
		echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} else {
		$SQL  = "Insert into usuario (ds_usuario,ds_celular,ds_cpf,ds_email,ds_senha,dt_nascimento,ds_uf,ds_cidade) ";
		$SQL .= "VALUES ('" . addslashes($_REQUEST['ds_usuario']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_celular']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_cpf']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_email']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_senha']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['dt_nascimento']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_uf']) . "',";
		$SQL .= "'" . addslashes($_REQUEST['ds_cidade']) . "')";
		$RSS = mysqli_query($conexao, $SQL) or die('erro');

		$SQL = "select * from usuario  order by cd_usuario desc limit 1";
		$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS);
		$cd_usuario = $RSX["cd_usuario"];
		//	echo "<script>alert('Registro Inserido.');</script>";
	}
	echo "<script>window.open('menu.php?modulo=lista_usuarios', '_self');</script>";
}

$SQL = "select * from usuario where cd_usuario = $cd_usuario";
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
						<h3 class="card-title">Cadastro do Usuario Nº <? echo $cd_usuario; ?> </h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form action='menu.php' method='post'>
						<input type='hidden' name='acao' id='acao' value='salvar'>
						<input type='hidden' name='modulo' id='modulo' value='cadastro_usuario'>
						<input type='hidden' name='cd_usuario' id='cd_usuario' value='<? echo intval($cd_usuario); ?>'>
						<div class="card-body">
							<div class="form-group">
								<label for="">Nome do usuário</label>
								<input type="text" class="form-control" id="ds_usuario" name="ds_usuario" placeholder="Nome ..." value='<? echo $RS["ds_usuario"]; ?>'>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="">CPF usuário</label>
										<input type="text" class="form-control" id="ds_cpf" name="ds_cpf" placeholder="CPF ..." value='<? echo $RS["ds_cpf"]; ?>'>
									</div>
									<div class="col-md-6">
										<label for="exampleInputEmail1">Nascimento</label>
										<input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value='<? echo $RS["dt_nascimento"]; ?>'>
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

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="exampleInputPassword1">Senha</label>
										<input type="password" class="form-control" id="ds_senha" name="ds_senha" placeholder="Password" value='<? echo $RS["ds_senha"]; ?>'>
									</div>
									<div class="col-md-6">
										<label for="">Celular</label>
										<input type="text" class="form-control" id="ds_celular" name="ds_celular" value='<? echo $RS["ds_celular"]; ?>'>
									</div>
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
							<input type="button" value='Excluir' onclick='exclui(<?= $cd_usuario; ?>);'>
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
		function Clica(cd_usuario) {
			window.open('menu.php?modulo=lista_usuarios&cd_usuario=' + cd_usuario, "_self");
		}

		function exclui(cd_usuario) {
			if (confirm('Confirma a exclusao ?')) {
				window.open('menu.php?modulo=cadastro_usuario&acao=excluir&cd_usuario=' + cd_usuario, "_self");


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

			window.location.href = 'menu.php?modulo=lista_usuarios'
		}
	</script>