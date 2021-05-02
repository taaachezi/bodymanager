<?php session_start(); 
if (!isset($_SESSION["user_name"])) {
	header("Location: /index.php");
}elseif (isset($_GET["user_id"])) {
	if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] != $_GET["user_id"]) {
		header("Location: /index.php");
	}
}
require_once(ROOT_PATH."Controllers/ItemsController.php");
$item = new ItemsController();
if (isset($_GET["user_id"])) {
	$_SESSION["user_id"] = $_GET["user_id"] ?? null;
}
$user_id = $_SESSION["user_id"];
if (isset($_POST["search"])) {
	$search = $_POST["search"] == "" ? "全件" : $_POST["search"];
}
if (isset($_SESSION["errors"])) {
	$id = $_SESSION["errors"]["id"];
	unset($_SESSION["errors"]["id"]);
	$errors = $_SESSION["errors"];
	unset($_SESSION["errors"]);
}
$items = $item->index($user_id);

require_once(ROOT_PATH."Controllers/FavoritesController.php");
$favorite = new FavoritesController();
$favorites_id = $favorite->index($_SESSION["user_id"]);
$favorites_id = $favorites_id ?? "";
$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
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
	<link rel="stylesheet" type="text/css" href="/css/base.css">
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="/js/application.js" type="text/javascript"></script>
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="https://kit.fontawesome.com/f1ab325230.js" crossorigin="anonymous"></script>
	<script type="text/javascript">
		setTimeout(function (){
			$(".flash").fadeOut();
		},1000);
	</script>
</head>
<body>
	<?php if (isset($flash)): ?>
	<div class="alert <?php if($flash=="削除しました"){echo "alert-danger";}elseif($flash=="お気に入り解除しました"){echo "alert-warning";}else{echo "alert-primary";} ?> flash offset-2 col-8 position-absolute mt-2" role="alert" style="opacity: 0.7; top: 10px;">
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
				<h1>食材一覧</h1>
			</div>
			<div class="row mb-5">
				<div class="col-4">
					<a href="new.php?user_id=<?= $user_id ?>" class="btn btn-outline-secondary w-100">食材追加</a>
				</div>
				<div class="col-8">
					<form action="index.php" method="post" accept-charset="utf-8">
						<div class="col-12 d-flex">
							<input type="hidden" name="user_id" value="<?= $user_id ?>">
							<input type="text" name="search" class="form-control" placeholder="食材を検索">
							<input type="submit" value="&#xf002;検索" class="d-block fas">
						</div>
					</form>
				</div>
			</div>
			<?php if (isset($search)): ?>
				<div class="row fw-bold">
					<p>検索結果：<?= $search."(".count($items)."件)"; ?></p>
				</div>
			<?php endif; ?>
			<?php foreach ($items as $item): ?>
			<div class="row mb-3 shadow rounded-3" style="background-color:rgba(255,255, 255, 0.4);">
				<?php if(isset($errors) && $id == $item["id"]):?>
		 			<?php foreach ($errors as $error): ?>
		 				<p class="text-danger fw-bold pt-2" style="font-size: 13px;"><?= "(!)".$error ?></p>
		 			<?php endforeach ?>
				<?php endif; ?>
				<form action="update.php" method="post" accept-charset="utf-8">
					<div class="row d-flex justify-content-around pt-2" style="font-size: 11px">
						<div class="col">
							<label for="protein" class="form-label">たんぱく質(g)</label>
							<input type="text" name="protein" id="protein" class="col-12 form-control" value="<?= xss($item["protein"]) ?>">
						</div>
						<div class="col">
							<label for="carbo" class="form-label">炭水化物(g)</label>
							<input type="text" name="carbo" id="carbo"  class="col-12 form-control" value="<?= xss($item["carbo"]) ?>">
						</div>
						<div class="col">
							<label for="fat" class="form-label">脂質(g)</label>
							<input type="text" name="fat" id="fat"  class="col-12 form-control" value="<?= xss($item["fat"]) ?>">
						</div>
					</div>
					<div class="row d-flex justify-content-around mt-2 align-items-end pb-2">
						<div class="col">
							<label for="name" class="form-label" style="font-size: 11px;">食材名</label>
							<input type="text" name="name" placeholder="食材名" value="<?= xss($item["name"]) ?>" class="form-control fw-bold" id="name">
						</div>
						<div class="col">
							<input type="hidden" name="user_id" value="<?= $item["user_id"] ?>">
							<input type="hidden" name="id" value="<?= xss($item["id"]) ?>">
							<input type="submit" value="更新" class="btn btn-outline-primary rounded-pill col-12" name="update">
						</div>
						<div class="col">
							<a href="delete.php?id=<?= $item["id"] ?>" title="" class="btn btn-outline-danger rounded-pill item_delete col-12">削除</a>
						</div>
						<div class="col text-center">
							<?php $is_favorite = 0 ?>
							<?php foreach ($favorites_id as $favorite_id):?>
								<?php if ($item["id"] == $favorite_id["item_id"]): ?>
									<a href="../favorites/delete.php?id=<?= $item["id"] ?>" title="" class=" favorite_delete"><i class="fas fa-heart fs-2 text-danger"></i></a>
								<?php $is_favorite ++ ?>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php if ($is_favorite == 0): ?>
								<a href="../favorites/new.php?id=<?= $item["id"] ?>" title="" class=" favorite_create"><i class="far fa-heart fs-2 text-danger"></i></a>
							<?php endif; ?>
						</div>
					</div>
				</form>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</body>
</html>