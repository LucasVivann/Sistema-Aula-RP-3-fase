<?
include("conexao.php");
//require_once("../dompdf084/autoload.inc.php");
//use Dompdf\Dompdf; 
//use Dompdf\Options; 
//use Dompdf\FontMetrics; 

$rusuario   = $_REQUEST["rusuario"];
$rcelular   = $_REQUEST["rcelular"];
$remail  	= $_REQUEST["remail"];
$saida   	= $_REQUEST["saida"];
$tipo    	= $_REQUEST["tipo"];

if (strlen($saida) == 0) {
	$saida = "HTML";
}
if (strlen($tipo) == 0) {
	$tipo = "Usuario";
}

$saidas  = "<select name='saida' id='saida' >";
$saidas .= "<option value='$saida'>$saida</option>";
$saidas .= "<option value='HTML'>HTML</option>";
$saidas .= "<option value='DOC'>DOC</option>";
$saidas .= "<option value='XLS'>XLS</option>";
$saidas .= "<option value='PDF'>PDF</option>";
$saidas .= "<option value='IMP'>IMP</option>";
$saidas .= "</select>";

$tipos  = "<select name='tipo' id='tipo' s>";
$tipos .= "<option value='$tipo'>$tipo</option>";
$tipos .= "<option value='Usuario'>Usuario</option>";
$tipos .= "<option value='empresa'>empresa</option>";
$tipos .= "<option value='Cidades'>Cidades</option>";
$tipos .= "<option value='produtos'>produtos</option>";
$tipos .= "<option value='Transportador'>Transportador</option>";
$tipos .= "</select>";

$html1  = "<html><head><title>AULA</title></head><body>";

$html2 = "<fieldset><Legend>Filtros</legend>";
$html2 .= "<table>";
$html2 .= "<form name='aa' action='menu.php?modulo=relatorio' method='post'>";
$html2 .= "<tr><td>Nome</td><td>Email</td><td>celular</td><td>Saida</td><td>Tipo</td></tr>";
$html2 .= "    <td><input type='text' name='rusuario' id='rusuario' value='$rusuario'></td>";
$html2 .= "    <td><input type='text' name='remail' id='remail' value='$remail'></td>";
$html2 .= "    <td><input type='text' name='rcelular' id='rcelular' value='$rcelular' size='6'></td>";
$html2 .= "    <td>$saidas</td>";
$html2 .= "    <td>$tipos</td>";
$html2 .= "    <td><input type='submit' value='Gerar'></td></tr></form>";
$html2 .= "</table>";
$html2 .= "</fieldset>";

$html = "<html><body><table border width='100%'>";

if ($tipo == "Usuario") {
	$SQL  = " select * from Usuario where 1=1 ";
	if (strlen($rusuario) > 0) {
		$SQL .= " and ds_usuario like '%" . $rusuario . "%' ";
	}
	if (strlen($remail) > 0) {
		$SQL .= " and ds_email like '%" . $remail . "%' ";
	}
	if (strlen($rfone) > 0) {
		$SQL .= " and ds_celular like '%" . $rcelular . "%' ";
	}
	$SQL .= " order by ds_usuario";
	//	echo $SQL;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	while ($RS = mysqli_fetch_array($RSS)) {
		$html .= "<tr><td>" . $RS["cd_usuario"] . "</td>";
		$html .= "<td>" . $RS["ds_usuario"] . "</td>";
		$html .= "<td>" . $RS["ds_celular"] . "</td>";
		$html .= "<td>" . $RS["ds_email"] . "</td>";
		$html .= "</tr>";
		$xx = $xx + 1;
	}
}

if ($tipo == "empresa") {
	$SQL  = " select * from empresa where 1=1 ";
	if (strlen($rusuario) > 0) {
		$SQL .= " and ds_razao_social like '%" . $rusuario . "%' ";
	}
	if (strlen($remail) > 0) {
		$SQL .= " and ds_email like '%" . $remail . "%' ";
	}
	$SQL .= " order by ds_razao_social";
	// 	echo $SQL;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	while ($RS = mysqli_fetch_array($RSS)) {
		$html .= "<tr><td>" . $RS["cd_empresa"] . "</td>";
		$html .= "<td>" . $RS["ds_razao_social"] . "</td>";
		$html .= "<td>" . $RS["ds_cnpj"] . "</td>";
		$html .= "<td>" . $RS["ds_email"] . "</td>";
		$html .= "<td>" . $RS["ds_contato"] . "</td>";
		$html .= "<td>" . $RS["ds_uf"] . "</td>";
		$html .= "<td>" . $RS["ds_cidade"] . "</td>";
		$html .= "</tr>";
		$xx = $xx + 1;
	}
}


if ($tipo == "Cidades") {
	$SQL  = " select * from cidades order by ds_cidade";
	echo $SQL;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	while ($RS = mysqli_fetch_array($RSS)) {
		$html .= "<tr><td>" . $RS["ds_cidade"] . "</td>";
		$html .= "<td>" . $RS["ds_uf"] . "</td>";
		$html .= "</tr>";
		$xx = $xx + 1;
	}
}




if ($tipo == "produtos") {
	$SQL  = " select * from produto where 1=1 ";
	if (strlen($rusuario) > 0) {
		$SQL .= " and nome_do_produto like '%" . $rusuario . "%' ";
	}
	$SQL .= "order by nome_do_produto";
	echo $SQL;
	$RSS = mysqli_query($conexao, $SQL) or print(mysqli_error());
	while ($RS = mysqli_fetch_array($RSS)) {
		$html .= "<tr><td>" . $RS["cd_produto"] . "</td>";
		$html .= "<td>" . $RS["nome_do_produto"] . "</td>";
		$html .= "<td>" . $RS["valor_do_produto"] . "</td>";
		$html .= "<td>" . $RS["fornecedor"] . "</td>";
		$html .= "<td>" . $RS["numero_fornecedor"] . "</td>";
		$html .= "</tr>";
		$xx = $xx + 1;
	}
}

$html .= "</table>";
$html .= "</body>";
$html .= "</html>";

if ($saida == "XLS") {
	$arquivo = "Relatorio_em_" . date("d_m_Y__H_i_s") . ".xls";
	header("Expires: Mon, 26 Jul 2025 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Content-type: application/x-msexcel");
	header("Content-Disposition: attachment;filename=\"{$arquivo}\"");
	header("Content-Description: PHP Generated Data");
	$html = str_replace(",", "", $html);
	$html = str_replace(".", ",", $html);
	echo $html;
}

if ($saida == "DOC") {
	$arquivo = "Relatorio_em_" . date("d_m_Y_H_i_s") . ".doc";
	header("Expires: Mon, 26 Jul 2025 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	header("Content-type: application/x-msword");
	header("Content-Disposition: attachment;filename=\"{$arquivo}\"");
	header("Content-Description: PHP Generated Data");
	echo $html;
}

if ($saida == "HTML") {
	echo "<section class='content'>";
	echo "<div class='container-fluid'>";
	echo "<div class='row'>";
	echo "<div class='col-md-12'>";
	echo $html1 . $html2 . $html;
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
}

if ($saida == "IMP") {
	echo $html;
	echo "<center><form><input type='button' value='Imprimir' OnClick='javascript:DoPrinting()'></form></center>";
	echo "<script type='text/javascript'> function DoPrinting(){ window.print() } </script>";
}

if ($saida == "PDF") {
	$dompdf = new Dompdf();

	$dompdf->load_html($html);
	//	$dompdf->set_paper('letter', 'portrait');
	$dompdf->render();
	$dompdf->stream($tipo . "_em_" . date("d_m_Y__h_n_s") . ".pdf");
}


?>
<script language="JavaScript1.2">
	function DoPrinting() {
		if (!window.print) {
			alert("Use o Internet Explorer \n nas vers�es 4.0 ou superior!")
			return
		}
		window.print()
	}
</script>