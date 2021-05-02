<?php session_start();
	unset($_SESSION["non_member_data"]);
	require_once(ROOT_PATH."Public/recaptcha_key.php");
	$site_key = SITEKEY;
	$secret_key = SECRETKEY;
	$result_message = "";
	// チェックボックス押下時
	if (isset($_POST["g-recaptcha-response"])) {
		// リクエスト送信先のurl
		$url = "https://www.google.com/recaptcha/api/siteverify";
		// 送信パラメータの指定
		$data = ["secret"=>$secret_key, "response"=>$_POST["g-recaptcha-response"]];
		$option = [
			"http" => [
				"method" => "POST",
				// implede 文字連結関数　第一引数に連結間の文字指定
				// explode 文字分割関数 第一引数に分割文字指定
				"header" => implode("\r\n",["Content-Type:application/x-www-form-urlencoded",]),
				// $dataの文字列をエンコードする
				"content" => http_build_query($data)
			]
		];
		// ストリームコンテキスト データを指定したオプションでフィルターにかける
		$context = stream_context_create($option);
		// file_get_contents 指定したファイル(url)を読み込む $contextで指定したオプションで取得する
		$api_response = file_get_contents($url,false,$context);
		// jsonデータをデコード
		$result = json_decode($api_response);
		// 認証成功の場合
		if ($result->success) {
			$result_message = "成功";
		}else {// 認証失敗
			$result_message = "失敗: ";
			// エラー文の表示連結　最初のメッセージを取得
			$result_message .= $result->{"error-codes"}[0];
		}

	}

	require_once(ROOT_PATH."Controllers/UsersController.php");
	$errors="";
	$_SESSION["name"]="";
	$_SESSION["email"]="";
	if (isset($_POST["login"])||isset($_POST["guest"])) {
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
	$flash = $_SESSION["pass_flash"] ?? null ;
	unset($_SESSION["pass_flash"]);
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
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script type="text/javascript">
		setTimeout(function (){
			$(".flash").fadeOut();
		},1000);
		// rechaptcha　チェック認証時のコールバック関数
		var check = function (response){
			document.getElementById("warning").textContent = "";
			document.getElementById("login").disabled = false;
		};
		// 認証後時間経過時のコールバック関数
		var reset_check = function (){
			document.getElementById("warning").textContent = "ログインするにはチェックを入れてください";
			document.getElementById("login").disabled = true;
		};
	</script>
</head>
<body>
	<?php if (isset($flash)): ?>
	<div class="alert alert-primary flash offset-2 col-8" role="alert position-absolute mt-2" style="opacity: 0.7; top: 10px;">
		<h5 class="text-center"><?= $flash ?? null ?></h5>
	</div>
	<?php endif ?>
	<?php require_once("../Views/bg_img.php"); ?>
	<div class="container">
		<?php require_once("../Views/header.php") ?>
	</div>
	<div class="container">
		<div class="row col-8 mx-auto mt-3">
			<div class="text-center mb-3">
				<h1>ログイン</h1>
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
				<div class="text-center mb-3">
					<a href="password_reset.php" title="">パスワードを忘れた方はこちら</a>
				</div>
				<div class="mb-3">
					<input type="submit" class="col-12 form-control btn btn-outline-primary" value="はじめる" id="login" name="login" disabled>
				</div>
			</form>
			<!-- recaptcha api -->
			<form action="?" method="post" accept-charset="utf-8">
					<div class="g-recaptcha my-3" data-sitekey="6LdifLcaAAAAAMCtf1MOlFRasw5Js5tXIP2znQvv" data-callback="check" data-expired-callback="reset_check" style="opacity: 0.8;"></div>
					<p id="warning" class="text-danger">※ログインするにはチェックを入れてください</p>
					<p><?= $result_message; ?></p>
			</form>
		</div>
	</div>
</body>
</html>