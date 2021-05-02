
<?php session_start(); 
	if (!isset($_SESSION["user_name"])&&!isset($_SESSION["non_member_data"])){
	  	header("Location: /index.php");
	}
	$flash = $_SESSION["flash"] ?? null;
	if (isset($_SESSION["non_member_data"])) {
		require_once(ROOT_PATH."Controllers/TargetIntakesController.php");
		$target_intakes = new TargetIntakesController();
		$target_intake = $target_intakes->index();
		$current_user["purpose"] = $_SESSION["non_member_data"]["purpose"];
	}else{
		require_once(ROOT_PATH."Controllers/UsersController.php");
		require_once(ROOT_PATH."Controllers/ItemsController.php");
		require_once(ROOT_PATH."Controllers/FavoritesController.php");
		$user = new UsersController();
		$item = new ItemsController();
		$favorite = new FavoritesController();
		// 現在日時の取得
		$time = new DateTime();
	 	$current_time = $time->format("Y-m-d");
	 	$_SESSION["current_time"] = $current_time ?? "";
	 	// ログインユーザIDの取得　graph.phpに渡す
		$current_user = $user->show();
		$_SESSION["user_id"] = $current_user["id"] ?? "";
		// 取得アイテムの取得
		$items = $item->index($current_user["id"]) ?? "";
		// お気に入り登録食材のアイテム摂取
		$favorite_items = $favorite->index($current_user["id"]);
		// 目標摂取カロリーの表示
		$target_intake["calorie"] = "";
		$target_intake["fat"] = "";
		$target_intake["protein"] = "";
		$target_intake["carbo"] = "";
		// ユーザ情報が登録されていなければ登録画面に遷移
		if (!isset($current_user["height"])&&!isset($_SESSION["non_member_data"])) {
	 		header("Location: show.php");
	 	}else{
	 		$target_intake = $user->index($current_user,$current_time);
	 	}
	 	$errors = $_SESSION["intake_errors"] ?? null;
	 	unset($_SESSION["intake_errors"]);
	 	unset($_SESSION["flash"]);
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
	<script src="https://kit.fontawesome.com/f1ab325230.js" crossorigin="anonymous"></script>
	<!-- 時間指定 -->
	<script type="text/javascript">
		setTimeout(function (){
			$(".flash").fadeOut();
		},1000);

	</script>
</head>
<body>
	<?php if (isset($flash)): ?>
	<div class="alert alert-primary flash offset-2 col-8  position-absolute" role="alert" style="opacity: 0.7; top: 10px;">
		<h5 class="text-center"><?= $flash ?? null ?></h5>
	</div>
	<?php endif ?>
	<?php require_once("../Views/bg_img.php"); ?>
	<div class="container">
		<?php require_once("../Views/header.php") ?>
	</div>
	<div class="container">
		<div class="row col-10 mx-auto my-3 fw-bold">
			<div class="row col-12 mx-auto text-center mt-3">
				<h1><?php echo isset($_SESSION["user_name"]) ? $_SESSION["user_name"]."様" : "Non Member"; ?></h1>
				<br><h3>~ 本日の摂取目標 ~</h3>
			</div>
			<div class="row mx-auto d-flex justify-content-around fs-3">
				<div class="col text-center fw-bold">
					<?php if($current_user["purpose"] == 0): ?>
					減量中<span class="mx-2"><i class="fas fa-level-down-alt"></i></span>
					<?php else: ?>
					増量中<span class="mx-2"><i class="fas fa-level-up-alt"></i></span>
					<?php endif ?>
				</div>
				<div class="col text-center fw-bold <?php if($target_intake["protein"] < 0){echo "text-danger"; }?>">
					<?= $target_intake["calorie"] ?>kcal
				</div>
			</div>
			<div class="row mx-auto justify-content-between text-center fs-3">
				<div class="col-12 text-center fw-bold border-bottom border-top">
					PFC
				</div>
			</div>
			<div class="row mx-auto justify-content-between text-center fs-4">
				<div class="col-6 text-start">
					Protein
				</div>
				<div class="col-6 text-end fw-bold <?php if($target_intake["protein"] < 0){echo "text-danger"; }?>">
					<?= $target_intake["protein"] ?>g
				</div>
			</div>
			<div class="row mx-auto justify-content-between text-center fs-4">
				<div class="col-6 text-start">
					Carbohydrate
				</div>
				<div class="col-6 text-end fw-bold <?php if($target_intake["carbo"] < 0){echo "text-danger"; }?>">
					<?= $target_intake["carbo"] ?>g
				</div>
			</div>
			<div class="row mx-auto justify-content-between text-center fs-4">
				<div class="col-6 text-start">
					Fat
				</div>
				<div class="col-6 text-end fw-bold <?php if($target_intake["fat"] < 0){echo "text-danger"; }?>">
					<?= $target_intake["fat"] ?>g
				</div>
			</div>
			<!-- 非会員ユーザは非表示 -->
			<?php if (isset($_SESSION["non_member_data"])): ?>
			<div style="pointer-events: none; background-color:rgba(0,41,69,0.1);padding: 50px;">
			<h4 class="position-relative text-center text-muted" style="">ユーザ会員のみご利用可能</h4>
			<i class="fas fa-user-lock position-relative d-flex justify-content-center" style="top: 120px; font-size: 80px;"></i>
			<?php endif ?>

			<form action="../intakes/new.php" method="post" accept-charset="utf-8" class="mt-3">
				<input type="hidden" name="user_id" value="<?= $current_user["id"] ?? ""; ?>">
				<div class="col-12 mb-2">
					<p class="text-danger"><?= $errors["quantity_empty"] ?? ""; ?></p>
					<select name="quantity" class="col-12 form-select text-muted shadow-sm">
						<option value="" disabled selected>数量選択</option>
						<?php for($i=100; $i<=500; $i+=50): ?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php endfor ?>
					</select>
				</div>
				<div class="row">
					<p class="text-danger"><?= $errors["item_empty"] ?? ""; ?></p>
					<div class="col-9 mb-2">
							<select name="favorite_item" class="col-12 form-select text-muted shadow-sm">
								<option value=""disabled selected>お気に入り食材から選択</option>
								<?php if (isset($favorite_items)): ?>
									<?php foreach ($favorite_items as $favorite_item): ?>
									<option value="<?= $favorite_item["item_id"] ?>"><?= $favorite_item["name"] ?></option>
									<?php endforeach; ?>
								<?php endif ?>
							</select>
					</div>
					<div class="col-3">
						<input type="hidden" name="created" value="<?= $current_time ?? ""; ?>">
						<input type="submit" class="btn btn-outline-secondary w-100 shadow" value="摂取"  name="favorite">
					</div>
				</div>
				<div class="row">
					<div class="col-9 mb-2">
							<select name="all_item" class="col-12 form-select text-muted shadow-sm">
								<option value=""disabled selected>食材一覧から選択</option>
								<?php if(isset($items)): ?>
									<?php foreach ($items as $item): ?>
									<option value="<?= $item["id"] ?>"><?= $item["name"] ?></option>
									<?php endforeach; ?>
								<?php endif ?>
							</select>
					</div>
					<!-- ボタンごとに送るデータを変えたい -->
					<div class="col-3">
						<input type="hidden" name="created" value="<?= $current_time ?? "" ?>">
						<input type="submit" class="btn btn-outline-secondary w-100 shadow" value="摂取" name="all">
					</div>
				</div>
			</form>
			<div class="d-flex justify-content-between mt-3">
				<a href="../intakes/index.php?user_id=<?= $current_user["id"] ?? "" ?>" title="" class="col-5">
					<div class="btn btn-outline-secondary w-100 shadow">
						履歴確認
					</div>
				</a>
				<a href="../items/new.php?user_id=<?= $current_user["id"] ?? "" ?>" title="" class="col-5">
					<div class="btn btn-outline-primary w-100 shadow">
						食材登録
					</div>
				</a>
			</div>
		</div>
		<div class="container mx-auto my-4">
			<div class="row">
				<!-- vh:画面幅に対しての割合の高さ指定　親要素に関与しない -->
				<div class="col-10 mx-auto text-center">
					<?php if (!isset($_SESSION["non_member_data"])): ?>
					<img src="graph.php" alt="" class="w-75" style="opacity: 0.6">
					<a href="https://asial.co.jp/jpgraph/" title=""><p>produced by JpGraph</p></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if (isset($_SESSION["non_member_data"])): ?>
		</div>
		<?php endif; ?>
	</div>
</body>
</html>