<?php session_start();
// ログインユーザがIDを入力するとバリデーションがかからない
	if (!isset($_SESSION["user_name"])) {
		header("Location: /index.php");
	}
	require_once(ROOT_PATH."/Controllers/ItemsController.php");
	$item = new ItemsController();
	$item->delete();
	$_SESSION["flash"] = "削除しました";
	header("Location: index.php");
?>