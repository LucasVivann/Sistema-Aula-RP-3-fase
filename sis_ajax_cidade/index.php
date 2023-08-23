<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>STE | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
</head>
<?
$ds_senha = addslashes($_REQUEST["ds_senha"]);
$ds_email = addslashes($_REQUEST["ds_email"]);

if ($_REQUEST["desconecta"]=="sim") { session_start(); $_SESSION["CD_USUARIO"] = ""; session_destroy(); }

if ((strlen($ds_senha)>=3)&&(strlen($ds_email)>=3))
{
	session_start();
	include "conexao.php";
	$SQL = "select * from usuarios where ds_email='$ds_email' and ds_senha='$ds_senha'";
	$RSS = mysqli_query($conexao,$SQL) or print(mysqli_error());
	$RS = mysqli_fetch_assoc($RSS); 	
	if (intval($RS["cd_usuario"])>0)
	{
		$_SESSION["CD_USUARIO"] = $RS["cd_usuario"];
		$_SESSION["DS_USUARIO"] = $RS["ds_usuario"];
		echo "<meta http-equiv='refresh' content='0; url=menu.php'>";
	}
}

?>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Sis LTE</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Conecte-se</p>

      <form action="index.php" method="post">
        <div class="input-group mb-3">
          <input type="email" id='ds_email' name='ds_email' class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id='ds_senha' name='ds_senha' class="form-control" placeholder="Senha">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Conectar-se via Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Conectar-se via Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">Esqueci a senha</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Novo Registro</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
</body>
</html>
