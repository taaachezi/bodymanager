<?php session_start();
	if (!isset($_SESSION["user_name"])) {
		header("Location: /index.php");
	}
	require_once(ROOT_PATH."/Controllers/IntakesController.php");
	$intake = new IntakesController();
 	$params = $intake->delete();
 	$_SESSION["user_id"] = $_POST["user_id"];
 	$_SESSION["flash"] = "削除しました";
 	header("Location: ../users/index.php");
 	// item_id全て消えてしまう　idで検索し削除
?>