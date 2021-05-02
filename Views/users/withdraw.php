<?php session_start(); 
	if (!isset($_SESSION["user_name"])) {
		header("Location: /index.php");
	}
	if ($_GET["user_id"] == 1) {
		header("Location: index.php");
	}
	$user_id =  $_GET["user_id"];
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
		<div class="row col-12 mx-auto mt-3">
			<div class="text-center mb-3">
				<h1>退会確認</h1>
			</div>
			<div class="shadow-lg bg-white rounded-3 p-4">
				<div class="text-center text-danger mb-3 ">
					<p>手続き前にご確認ください</p>
				</div>
				<div class="mt-3">
					<p>1.退会後同じメールアドレスで登録はできません</p>
					<p>2.退会後も下記の情報は保持されます</p>
					<p>・ユーザ情報・登録食材</p>
					<p>3.再度同じアカウントで会員復活する際は管理者（xxxxx@xxx.com）までお問い合わせください</p>
				</div>
				<div class="d-flex justify-content-between mt-5">
					<a href="index.php" title="" class="col-5">
						<div class="btn btn-secondary w-100">
							戻る
						</div>
					</a>
					<div class="col-5">
						<form action="delete.php" method="post" accept-charset="utf-8">
						<!-- useridをhiddenに格納 -->
						<input type="hidden" name="user_id" value="<?= $user_id ?>">
						<input type="submit" name="" class="btn btn-danger w-100" value="退会">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>