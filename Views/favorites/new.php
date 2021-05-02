<?php session_start();
	require_once(ROOT_PATH."/Controllers/FavoritesController.php");
	$favorite = new FavoritesController();
	$favorite->create($_SESSION["user_id"]);
	$_SESSION["flash"] = "お気に入り登録しました";
	header("Location: ../items/index.php");
?>