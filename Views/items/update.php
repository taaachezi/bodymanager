<?php session_start();
	require_once(ROOT_PATH."/Controllers/ItemsController.php");
	$item = new ItemsController();
	$errors = $item->validate();
	if (empty($errors)) {
		$item->update();
		$_SESSION["flash"] = "更新しました";
	}else{
		$_SESSION["errors"]=$errors;
		$_SESSION["errors"]["id"] = $_POST["id"];
	}
	header("Location: index.php");
?>