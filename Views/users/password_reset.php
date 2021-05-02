<?php session_start(); 
	require_once(ROOT_PATH."Controllers/UsersController.php");
	$errors="";
	$error_massage="";
	$_SESSION["name"]="";
	$_SESSION["email"]="";
	if (isset($_POST["password_reset"])) {
		$user = new UsersController();
		$errors = $user->password_reset();
		if ($errors != "入力に誤りがあります") {
			$_SESSION["pass_flash"] = "パスワードをリセットしました";
			header("Location: login.php");
		}else{
			$error_massage = $errors;
			$_SESSION["name"] = $_POST["name"];
			$_SESSION["email"] = $_POST["email"];
		}
	}
	function xss($val){
		echo htmlspecialchars($val);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>bodymanager</title>
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<?php require_once("../Views/bg_img.php"); ?>
	<div class="container">
		<?php require_once("../Views/header.php") ?>
	</div>
	<div class="container">
		<div class="row col-8 mx-auto mt-3">
			<div class="text-center mb-3">
				<h1>パスワードリセット</h1>
			</div>
			<form action="password_reset.php" method="post" accept-charset="utf-8">
				<div class="mb-3">
					<?php if (isset($error_massage)): ?>
					<p class="text-danger"><?php echo $error_massage ?></p>
					<?php endif ?>
					<input type="text" name="name" placeholder="ユーザ名" class="col-12 form-control" value="<?php if(isset($_SESSION["name"])) { echo xss($_SESSION["name"]); } ?>">
				</div>
				<div class="mb-3">
					<input type="email" name="email" placeholder="メールアドレス" class="col-12 form-control" value="<?php if(isset($_SESSION["email"])) { echo xss($_SESSION["email"]); } ?>">
				</div>
				<div class="mb-3">
					<input type="password" name="password" placeholder="パスワード" class="col-12 form-control">
				</div>
				<div class="mb-3">
					<input type="password" name="password_conf" placeholder="パスワード確認" class="col-12 form-control">
				</div>
				<div class="mb-3">
					<input type="hidden" name="password_reset" value="password_reset">
					<input type="submit" class="col-12 form-control btn btn-primary" value="パスワードリセット">
				</div>
			</form>
		</div>
	</div>
</body>
</html>