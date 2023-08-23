<?
	include "conexao.php";
	$ds_uf = $_REQUEST['ds_uf'];  
	$cidades = array();
	$SQL = "select * from cidades where ds_uf = '".$ds_uf."' order by ds_cidade asc";
	$RCC = $conexao->query($SQL) or print(mysqli_connect_error());
	while($RC = $RCC->fetch_array()) { $cidades[] = array(	'ds_cidade'	=> $RC['ds_cidade'], ); }
	echo( json_encode( $cidades ) );
?>