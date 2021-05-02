<?php session_start();
	if (!isset($_POST["user_id"])) {
		header("Location: /index.php");
	}
	require_once(ROOT_PATH."/Controllers/UsersController.php");
	$user = new UsersController();
	$user->delete();
	header("Location: /index.php");
?>