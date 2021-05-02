<?php session_start();
	require_once(ROOT_PATH."Controllers/UsersController.php");
	if (isset($_GET["user_name"])) {
		if ($_SESSION["user_name"] != $_GET["user_name"]) {
			header("Location: /index.php");
		}
	}
	$user = new UsersController();
	$params = $user->show();
	// 非会員ユーザの場合$paramsがないので空で入れる
	$_SESSION["height"] = $params["height"] ?? "";
	$_SESSION["weight"] = $params["weight"] ?? "";
	$_SESSION["age"] = $params["age"] ?? "";
	$_SESSION["frequency"] = $params["frequency"] ?? "";
	$_SESSION["gender"] = $params["gender"] ?? "";
	$_SESSION["purpose"] = $params["purpose"] ?? "";
	if (!isset($params["id"])) {
		$_SESSION["non_member_data"] = "";
	}
	$errors = "";
	if (isset($_POST["update_user"])) {
		$params = $user->show();
		$errors = $user->validate();
		if(empty($errors)){
			if (isset($params["id"])) {
				$user->update();
				$_SESSION["flash"] = "ユーザ情報を更新しました";
			}
			if (isset($_SESSION["non_member_data"])) {
				$_SESSION["non_member_data"] = $_POST;
			}
			header("Location: index.php");
		}
		//postしたデータをフォームに保持
		$_SESSION["height"] = $_POST["height"];
		$_SESSION["weight"] = $_POST["weight"];
		$_SESSION["age"] = $_POST["age"];
		$_SESSION["frequency"] = $_POST["frequency"];
		$_SESSION["gender"] = $_POST["gender"];
		$_SESSION["purpose"] = $_POST["purpose"];
	}
	function xss($text) {
		return htmlspecialchars($text);
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
		<div class="row col-10 mx-auto mt-3">
			<div class="text-center mb-3">
				<h1><?php if(isset($_SESSION["user_name"])){echo $_SESSION["user_name"]."様の";} ?>登録情報</h1>
			</div>
			<form action="show.php" method="post" accept-charset="utf-8">
				<?php if (isset($errors["height_empty"])): ?>
					<p class="text-danger fw-bold"><?php echo "(!)".$errors["height_empty"]; ?></p>
				<?php elseif(isset($errors["height_int"])) : ?>
					<p class="text-danger fw-bold"><?php echo "(!)".$errors["height_int"]; ?></p>
				<?php endif ?>
				<div class="mb-3 form-floating">
					<input type="text" name="height" class="col-12 form-control fw-bold" id="height" value="<?= xss($_SESSION["height"]) ?>">
					<label for="height">身長(cm)</label>
				</div>
				<?php if (isset($errors["weight_empty"])): ?>
					<p class="text-danger fw-bold"><?php echo "(!)".$errors["weight_empty"]; ?></p>
				<?php elseif(isset($errors["weight_int"])) : ?>
					<p class="text-danger fw-bold"><?php echo "(!)".$errors["weight_int"]; ?></p>
				<?php endif ?>
				<div class="mb-3 form-floating">
					<input type="text" name="weight" class="col-12 form-control fw-bold" id="weight" value="<?= xss($_SESSION["weight"]) ?>">
					<label for="weight">体重(kg)</label>
				</div>
				<?php if (isset($errors["age_empty"])): ?>
					<p class="text-danger fw-bold"><?php echo "(!)".$errors["age_empty"]; ?></p>
				<?php elseif(isset($errors["age_int"])) : ?>
					<p class="text-danger fw-bold"><?php echo "(!)".$errors["age_int"]; ?></p>
				<?php endif ?>
				<div class="mb-3 form-floating">
					<input type="text" name="age" class="col-12 form-control fw-bold" id="age" value="<?= xss($_SESSION["age"]) ?>">
					<label for="age">年齢</label>
				</div>
				<div class="mb-1 col-12 ">
					<p class="text-muted">運動頻度(日/1週間)</p>
				</div>
				<div class="mb-3 d-flex justify-content-around">
					<div>
						<input type="radio" name="frequency" class="form-check-input" id="f-0" value=0 <?= $_SESSION["frequency"] == 0 ? "checked" : "" ?>>
						<label class="form-check-label" for="f-0">多:5~7
						</label>
					</div>
					<div>
						<input type="radio" name="frequency" class="form-check-input" id="f-1" value=1 <?= $_SESSION["frequency"] == 1 ? "checked" : "" ?>>
						<label class="form-check-label" for="1">普通:3~4</label>
					</div>
					<div>
						<input type="radio" name="frequency" class="form-check-input" id="f-2" value=2 <?= $_SESSION["frequency"] == 2 ? "checked" : "" ?> >
						<label class="form-check-label" for="f-2">少:1~2</label>
					</div>
				</div>
				<div class="mb-1 col-12 ">
					<p class="text-muted">性別</p>
				</div>
				<div class="mb-3 d-flex justify-content-around">
					<div>
						<input type="radio" name="gender" class="form-check-input" id="g-0" value=0 <?= $_SESSION["gender"] == 0 ? "checked" : "" ?> >
						<label class="form-check-label" for="g-0" >男　
						</label>
					</div>
					<div>
						<input type="radio" name="gender" class="form-check-input" id="g-1" value=1 <?= $_SESSION["gender"] == 1 ? "checked" : "" ?>>
						<label class="form-check-label" for="g-1" >女　</label>
					</div>
				</div>
				<div class="mb-1 col-12 ">
					<p class="text-muted">目的</p>
				</div>
				<div class="mb-3 d-flex justify-content-around">
					<div>
						<input type="radio" name="purpose" class="form-check-input" id="p-0" value=0 <?= $_SESSION["purpose"] == 0 ? "checked" : "" ?>>
						<label class="form-check-label" for="p-0">減量
						</label>
					</div>
					<div>
						<input type="radio" name="purpose" class="form-check-input" id="p-1" value=1 <?= $_SESSION["purpose"] == 1 ? "checked" : "" ?>>
						<label class="form-check-label" for="p-1">増量</label>
					</div>
				</div>
				<div class="d-flex justify-content-between row">
					<div class="col-4">
						<?php if (isset($params["id"])): ?>
						<a href="withdraw.php?user_id=<?= $params["id"] ?>">
							<div class="btn btn-outline-danger w-100">
								退会
							</div>
						</a>
						<?php else: ?>
							<button type="button" class="btn btn-outline-danger w-100" disabled>
								退会
							</button>
						<?php endif; ?>
					</div>
					<div class="col-4">
						<input type="hidden" name="update_user" value="update_user">
						<?php if (isset($params["id"])): ?>
							<input type="hidden" name="id" value="<?php echo $params["id"] ?>">
						<?php endif; ?>
						<input type="submit" class="btn btn-outline-primary w-100" value="登録">
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>