<?php session_start();
	if ($_SESSION["user_name"]!= "admin") {
		header("Location: /index.php");
	}
	require_once(ROOT_PATH."Controllers/UsersController.php");
	$user = new UsersController();
	if (isset($_POST["delete"])) {
		$user->delete();
	}elseif (isset($_POST["return"])) {
		$user->return();
	}
	$users = $user->admin_index();
	$flash = $_SESSION["flash"] ?? null;
	unset($_SESSION["flash"]);
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
	<script type="text/javascript">
		$(function (){
			$("#delete").click(function (){
				if(confirm("本当に退会しますか？")){
					return true;
				}else{
					return false;
				}
			});
		});
		setTimeout(function (){
			$(".flash").fadeOut();
		},1000);
	</script>
</head>
<body>
	<?php if (isset($flash)): ?>
	<div class="alert alert-primary flash offset-2 col-8" role="alert position-absolute mt-2"  style="opacity: 0.7; top: 10px;">
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
				<h1>ユーザ一覧</h1>
			</div>
			<div class="col-12">
				<table class="table table-borderless">
					<thead>
						<tr>
							<th scope="col"></th>
							<th scope="col">ユーザ名</th>
							<th scope="col">メールアドレス</th>
							<th scope="col">会員状況</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php $user_count = 1 ?>
						<?php foreach ($users as $user): ?>
						<tr>
							<th scope="row"><?= $user_count ?></th>
							<td><?= $user["name"] ?></td>
							<td><?= $user["email"] ?></td>
							<?php if ($user["role"] == 0): ?>
							<td>有効</td>
							<?php else: ?>
							<td>無効</td>
							<?php endif ?>
							<td class="row">
								<div class="col-5">
									<form action="index.php" method="post" accept-charset="utf-8">
									<input type="hidden" name="user_id" value="<?= $user["id"] ?>">
									<input type="submit" name="delete" value="削除" class="btn btn-outline-danger w-100 mx-1">
									</form>
								</div>
								<div class="col-5">
									<form action="index.php" method="post" accept-charset="utf-8">
									<input type="hidden" name="user_id" value="<?= $user["id"] ?>">
									<input type="submit" name="return" value="復活" class="btn btn-outline-primary w-100 mx-1">
									</form>
								</div>
							</td>
						</tr>
						<?php $user_count ++ ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>