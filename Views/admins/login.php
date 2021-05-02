<?php session_start();
	require_once(ROOT_PATH."Controllers/UsersController.php");
	$errors="";
	$_SESSION["name"]="";
	$_SESSION["email"]="";
	if (isset($_POST["login"])) {
		$user = new UsersController();
		$errors = $user->login();
		if (count($errors)==0) {
			$_SESSION["user_name"] = $_POST["name"];
			$_SESSION["flash"] = "ログインしました";
			header("Location: index.php");
		}else{
			$_SESSION["name"]=$_POST["name"];
			$_SESSION["email"]=$_POST["email"];
		}
	}
	function xss($val) {
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
				<h1>管理者ログイン</h1>
			</div>
			<form action="login.php" method="post" accept-charset="utf-8">
				<div class="mb-3">
					<?php if (isset($errors["name_empty"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["name_empty"] ?></p>
					<?php elseif(isset($errors["name_length"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["name_length"] ?></p>
					<?php elseif(isset($errors["name_non"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["name_non"] ?></p>
					<?php elseif(isset($errors["email_non"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["email_non"] ?></p>
					<?php endif ?>
					<input type="text" name="name" placeholder="ユーザ名" class="col-12 form-control" value="<?php if(isset($_SESSION["name"])) { xss($_SESSION["name"]); } ?>">
				</div>
				<div class="mb-3">
					<?php if (isset($errors["email_empty"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["email_empty"] ?></p>
					<?php endif ?>
					<input type="email" name="email" placeholder="メールアドレス" class="col-12 form-control" value="<?php if(isset($_SESSION["email"])) { echo xss($_SESSION["email"]); } ?>">
				</div>
				<div class="mb-3">
					<?php if (isset($errors["password_empty"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["password_empty"] ?></p>
					<?php elseif(isset($errors["password_non"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["password_non"] ?></p>
					<?php endif ?>
					<input type="password" name="password" placeholder="パスワード" class="col-12 form-control">
				</div>
				<div class="mb-3">
					<input type="hidden" name="login">
					<input type="submit" class="col-12 form-control btn btn-outline-primary" value="ログイン">
				</div>
			</form>
		</div>
	</div>
</body>
</html>