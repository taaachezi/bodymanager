<?php session_start();
	unset($_SESSION["non_member_data"]);
	require_once(ROOT_PATH."Controllers/UsersController.php");
	$errors=array();
	$_SESSION["name"]="";
	$_SESSION["email"]="";
	if (isset($_POST["registration"])) {
		$user = new UsersController();
		$errors = $user->validate();
		if (count($errors)==0) {
			$user->create();
			$_SESSION["user_name"] = $_POST["name"];
			$_SESSION["flash"] = "ログインしました";
			header("Location: index.php");
		}else{
			$_SESSION["name"]=$_POST["name"];
			$_SESSION["email"]=$_POST["email"];
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
	<link rel="stylesheet" type="text/css" href="/css/base.css?v=2">
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
				<h1>新規登録</h1>
			</div>
			<form action="registration.php" method="post" accept-charset="utf-8">
				<input type="hidden" name="registration" value="registration">
				<div class="mb-3">
					<?php if (isset($errors["name_empty"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["name_empty"] ?></p>
					<?php elseif(isset($errors["name_length"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["name_length"] ?></p>
					<?php elseif(isset($errors["name"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["name"] ?></p>
					<?php endif ?>
					<input type="text" name="name" placeholder="ユーザ名" class="col-12 form-control" value="<?php if(isset($_SESSION["name"])) { echo xss($_SESSION["name"]); } ?>">
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
					<?php elseif(isset($errors["password_length"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["password_length"] ?></p>
					<?php endif ?>
					<input type="password" name="password" placeholder="パスワード" class="col-12 form-control">
				</div>
				<div class="mb-3">
					<?php if (isset($errors["password_conf"])): ?>
						<p class="text-danger"><?php echo "(!)".$errors["password_conf"] ?></p>
					<?php endif ?>
					<input type="password" name="password_conf" placeholder="パスワード確認" class="col-12 form-control">
				</div>
				<div class="mb-3">
					<input type="submit" class="col-12 form-control btn btn-outline-primary" value="はじめる">
				</div>
			</form>
		</div>
	</div>
</body>
</html>