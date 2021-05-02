<?php session_start(); 
if (!isset($_SESSION["user_name"])) {
	header("Location: /index.php");
}
require_once(ROOT_PATH."/Controllers/IntakesController.php");
$intake = new IntakesController();
$items = $intake->index();
$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
function total($quantity){
	$total = $quantity / 100;
	return $total;
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
	<script src="/js/application.js" type="text/javascript"></script>
	<script type="text/javascript">
		setTimeout(function (){
			$(".flash").fadeOut();
		},1000);
	</script>
</head>
<body>
	<?php if (isset($flash)): ?>
	<div class="alert alert-danger flash offset-2 col-8  position-absolute" role="alert" style="opacity: 0.6; top: 10px;">
		<h5 class="text-center"><?= $flash ?? null ?></h5>	</div>
	<?php endif ?>
	<?php require_once("../Views/bg_img.php"); ?>
	<div class="container">
		<?php require_once("../Views/header.php") ?>
	</div>
	<div class="container">
		<div class="row col-12 mx-auto mt-3">
			<div class="text-center mb-3">
				<h1>摂取履歴</h1>
			</div>
			<div class="row">
				<!-- vh:画面幅に対しての割合の高さ指定　親要素に関与しない -->
				<div class="col-10 mx-auto text-center">
					<img src="../users/graph.php" alt="" class="w-75" style="opacity: 0.6">
					<a href="https://asial.co.jp/jpgraph/" title=""><p>produced by JpGraph</p></a>
				</div>
			</div>
			<div class="col-12 text-center mt-3">
				<h3>本日の摂取履歴</h3>
			</div>
			<?php if (empty($items)): ?>
				<p class="text-center">摂取履歴はありません</p>
			<?php else: ?>
			<div class="col-12">
				<table class="table table-borderless">
					<thead>
						<tr>
							<th scope="col"></th>
							<th scope="col">食材名</th>
							<th scope="col">カロリー</th>
							<th scope="col">グラム</th>
							<th scope="col">たんぱく質</th>
							<th scope="col">炭水化物</th>
							<th scope="col">脂質</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php $item_count = 1 ?>
						<?php foreach ($items as $item): ?>
						<tr>
							<th scope="row"><?= $item_count ?></th>
							<td><?= $item["name"] ?></td>
							<td><?= $item["calorie"] * total($item["quantity"]) ?>kcal</td>
							<td><?= $item["quantity"] ?>g</td>
							<td><?= $item["protein"] * total($item["quantity"]) ?>g</td>
							<td><?= $item["carbo"] * total($item["quantity"]) ?>g</td>
							<td><?= $item["fat"] * total($item["quantity"]) ?>g</td>
							<td>
								<form action="delete.php" method="post">
								<input type="hidden" name="user_id" value="<?=  $item["user_id"]; ?>">
								<input type="hidden" name="id" value="<?=  $item["id"]; ?>">
								<input type="submit" value="削除" class="btn btn-outline-danger col-12 intake_delete">
								</a>
							</td>
						</tr>
						<?php $item_count ++ ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php endif ?>
		</div>
	</div>
</body>
</html>