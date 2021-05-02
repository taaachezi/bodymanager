<?php session_start();
	if (!isset($_SESSION["user_name"])) {
		header("Location: /index.php");
	}
	require_once(ROOT_PATH."/Controllers/IntakesController.php");
	$intake = new IntakesController();
 	$errors = $intake->create();
 	$_SESSION["intake_errors"] = $errors ?? null;
 	if (!isset($_SESSION["intake_errors"])) {
 		$_SESSION["flash"] = "摂取しました";
 	}
 	header("Location: ../users/index.php");
?>