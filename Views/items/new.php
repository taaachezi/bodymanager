<?php session_start(); 
if (!isset($_SESSION["user_name"])) {
	header("Location: /index.php");
}
$errors = null;
$name = "";
$protein = "";
$carbo = "";
$fat = "";
if (isset($_GET["user_id"])) {
	$user_id = $_GET["user_id"];
}
if (isset($_POST["user_id"])) {
	require_once(ROOT_PATH."Controllers/ItemsController.php");
	$item = new ItemsController();
	$user_id = $_POST["user_id"];
	$errors = $item->validate();
	if (!empty($errors)) {
		$name = $_POST["name"];
		$protein = $_POST["protein"];
		$carbo = $_POST["carbo"];
		$fat = $_POST["fat"];
	}else{
		$params = $item->create();
		$_SESSION["flash"] = "登録しました";
	}
}
$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

function xss($val){
	echo htmlspecialchars($val);
}
// スクレイピング実装予定
// require_once("phpQuery.php");
// $html = file_get_contents("https://ja.wikipedia.org/wiki/%E4%B8%89%E5%9B%BD%E5%BF%97");
// echo phpQuery::newDocument($html)->find("h3")->text();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>bodymanager</title>
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="/js/application.js"></script>
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript">
		setTimeout(function (){
			$(".flash").fadeOut();
		},1000);
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
		<div class="row col-12 mx-auto mt-3">
			<div class="text-center mb-3">
				<h1>食材登録</h1>
			</div>
			<p class="text-center mb-3">※100gあたりの数値を入力して下さい</p>
			<form action="new.php" method="post" accept-charset="utf-8">
				<p class="text-danger fw-bold">
					<?= $errors["name_empty"] ?? $errors["name_have"] ?? ""; ?>
				</p>
				<div class="mb-3 form-floating shadow-sm">
					<input type="text" name="name" class="col-12 form-control" id="name" value="<?= xss($name) ?>">
					<label for="name">食材名</label>
				</div>
				<p class="text-danger fw-bold">
					<?= $errors["protein_empty"] ?? $errors["protein_num"] ?? "" ; ?>
				</p>
				<div class="mb-3 form-floating shadow-sm">
					<input type="text" name="protein" class="col-12 form-control pc" id="protein" value="<?= xss($protein) ?>">
					<label for="protein">たんぱく質(g)</label>
				</div>
				<p class="text-danger fw-bold">
					<?= $errors["carbo_empty"] ?? $errors["carbo_num"] ?? "" ; ?>
				</p>
				<div class="mb-3 form-floating shadow-sm">
					<input type="text" name="carbo" class="col-12 form-control pc" id="carbo" value="<?= xss($carbo) ?>">
					<label for="carbo">炭水化物(g)</label>
				</div>
				<p class="text-danger fw-bold">
					<?= $errors["fat_empty"] ?? $errors["fat_num"] ?? "" ; ?>
				</p>
				<div class="mb-3 form-floating shadow-sm">
					<input type="text" name="fat" class="col-12 form-control f" id="fat" value="<?= xss($fat) ?>">
					<label for="fat">脂質(g)</label>
				</div>
				<h1 class="text-center">TOTAL <span class="result ml-3"></span>kcal</h1>
				<div class="d-flex justify-content-between mt-5">
					<a href="https://fooddb.mext.go.jp/" title="" class="btn btn-outline-secondary col-6">調べる(外部リンク)</a>
					<input type="hidden" name="user_id" value="<?= $user_id ?>">
					<input type="submit" value="登録" class="btn btn-outline-primary col-5">
				</div>
			</form>
			<div class="mt-3 mb-2">
				<a href="index.php?user_id=<?= $user_id ?>" title="" class="btn btn-primary col-12">食材一覧</a>
			</div>
		</div>
	</div>
</body>
</html>