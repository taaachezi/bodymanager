<?php session_start();
// session_destroy()ではリロードしないと発動されないので明示的にからにする
	$_SESSION = array();
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
	<script src="/js/application.js" type="text/javascript"></script>
</head>
<body>
	<div class="back_video">
		<video  src="/img/main.mp4"autoplay loop preload="auto" style="z-index: -1; position: absolute; top: 0; width: 100%; opacity: 0.7;">
		</video>
	</div>
		<?php require_once("header.php") ?>
		<div class="container my-5">
			<div class="row mt-5">
				<div class="col-9 mx-auto my-5 registration">
					<a href="users/registration.php" title="" class="btn btn-lg btn-outline-primary rounded-pill w-100">New Registration</a>
				</div>
				<div class="col-9 mx-auto my-5 registration">
					<a href="users/login.php" title="" class="btn btn-lg btn-outline-primary w-100 rounded-pill">Member</a>
				</div>
				<div class="col-9 mx-auto my-5 registration">
					<form action="users/login.php" method="post" accept-charset="utf-8">
						<input type="hidden" name="guest" value="guest">
						<input type="hidden" name="name" value="guest">
						<input type="hidden" name="email" value="guest@guest">
						<input type="hidden" name="password" value="guestlogin">
						<input type="submit" name="" class="btn btn-lg btn-outline-secondary w-100 rounded-pill" value="Guest">
					</form>
				</div>
				<div class="col-9 mx-auto my-5 registration">
					<a href="users/show.php?non_member" title="" class="btn btn-lg btn-outline-secondary w-100 rounded-pill">Non Member</a>
				</div>
			</div>
		</div>
		<div class="row mx-auto">
			<div class="text-center col-12">
				<h2 class="text-center" id="menu">Change Life In Eating !!</h2>
			</div>
		</div>
		<div class="container" id="menu-item" style="display: none;">
			<div class="row text-center mt-4">
				<h3>あなたの健康を守ります</h3>
			</div>
			<div class="row mx-auto col-12">
			<div class="row mt-5">
				<div class="col-6">
					<h4 style="transform: rotate(-10deg);">バルクアップ</h4>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-6 offset-6 text-end">
					<h4 style="transform: rotate(-10deg);">ダイエット</h4>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-6">
					<h4 style="transform: rotate(-10deg);">カロリー自動計算</h4>
				</div>
			</div>
			<div class="row mt-5 text-end">
				<div class="col-6 offset-6">
					<h4 style="transform: rotate(-10deg);">摂取登録</h4>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-6">
					<h4 style="transform: rotate(-10deg);">摂取履歴表示</h4>
				</div>
			</div>
			<div class="row mt-5 text-end">
				<div class="col-6 offset-6">
					<h4 style="transform: rotate(-10deg);">登録食材のカスタマイズ</h4>
				</div>
			</div>
		</div>
		</div>
	</div>
</body>
</html>