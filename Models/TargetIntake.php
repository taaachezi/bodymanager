<?php
 require_once(ROOT_PATH."/Models/Db.php");
 class TargetIntake extends Db {
 	private $table = "target_intakes";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 	public function find_by_user_id($user_id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "SELECT id FROM $this->table WHERE user_id = :user_id";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$stmt->execute();
 			$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
 			return $user;
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function calculation_target($current_user){
	 	$target_intake = [];
	 	$target_intake["user_id"] = $current_user["id"] ?? "";
	 	$height = $current_user["height"];
	 	$weight = $current_user["weight"];
	 	$age = $current_user["age"];
	 	$frequency = $current_user["frequency"];
	 	$gender = $current_user["gender"];
	 	$purpose = $current_user["purpose"];
	 	// 基礎代謝
	 	if ($gender == 0) {
	 		$metabolism = ((0.0481*$weight) + (0.0234*$height) - (0.0138*$age) - 0.4235) * 1000/4.186;
	 		$metabolism= floor($metabolism);
	 	}elseif ($gender == 1) {
	 		$metabolism = ((0.0481*$weight) + (0.0234*$height) - (0.0138*$age) - 0.9708) * 1000/4.186;
	 		$metabolism =  floor($metabolism);
	 	}
	 	// 消費カロリー
	 	switch ($frequency) {
	 		case 0:
	 			$consumption = floor($metabolism*1.72);
	 			break;
	 		case 1:
	 			$consumption = floor($metabolism*1.55);
	 			break;
	 		case 2:
	 			$consumption = floor($metabolism*1.35);
	 			break;
	 		default:
	 			break;
	 	}
	 	// 目標摂取
	 	switch ($purpose) {
	 		case 0:
	 			$target_intake["calorie"] = $consumption-500;
	 			$target_intake["protein"] = round($weight*2.5,1);
	 			$target_intake["fat"] = round($weight*0.25,1);
	 			$protein_cal = $target_intake["protein"]*4;
	 			$fat_cal = $target_intake["fat"]*9;
	 			$carbo_cal = $target_intake["calorie"]- $protein_cal - $fat_cal;
	 			$target_intake["carbo"] = round($carbo_cal/4,1);
	 			break;
	 		case 1:
	 			$target_intake["calorie"] = $consumption+500;
	 			$target_intake["protein"] = round($weight*2.5,1);
	 			$target_intake["fat"] = round($weight*0.9,1);
	 			$protein_cal = $target_intake["protein"]*4;
	 			$fat_cal = $target_intake["fat"]*9;
	 			$carbo_cal = $target_intake["calorie"]- $protein_cal - $fat_cal;
	 			$target_intake["carbo"] = round($carbo_cal/4,1);
	 		default:
	 			break;
	 	}
	 	if (!isset($current_user["id"])) {
	 		return $target_intake;
	 	}
	 	$check_user = $this->find_by_user_id($current_user["id"]);
	 		try{
				$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				if (empty($check_user)) {
					$sql = "INSERT INTO $this->table (user_id,calorie,protein,fat,carbo) VALUES (:user_id, :calorie, :protein, :carbo, :fat)";
					$stmt = $this->dbh->prepare($sql);
					$stmt->bindValue(":user_id", $target_intake["user_id"], PDO::PARAM_INT);
					$params = array(":calorie"=>$target_intake["calorie"], ":protein"=>$target_intake["protein"], ":carbo"=>$target_intake["carbo"], ":fat"=>$target_intake["fat"], ":user_id"=>$target_intake["user_id"]);
					$stmt->execute($params);
				}else{
		 			$sql = "UPDATE $this->table SET protein=:protein, carbo = :carbo, fat = :fat, calorie = :calorie WHERE user_id = :user_id";
		 			$stmt = $this->dbh->prepare($sql);
		 			$stmt->bindValue(":user_id", $target_intake["user_id"], PDO::PARAM_INT);
		 			$stmt->execute(array("protein"=>$target_intake["protein"], "carbo"=>$target_intake["carbo"] , "fat"=>$target_intake["fat"] , "calorie"=>$target_intake["calorie"] , "user_id"=>$target_intake["user_id"] ));
		 		}
			}catch(PDOExeception $e) {
				echo "接続エラー", $e->getMessage();
			}
		return $target_intake;
	}
	public function calculation_diff_intake($target,$total) {
 		// where user_idでtarget_intakesからcalorie,fat,protein,carboを取得
 		// 取得情報から$totalの値を引き変数に格納⇨変数をreturnする
		$diff_intake["calorie"] = $target["calorie"]-$total["calorie"];
		$diff_intake["protein"] = $target["protein"]-$total["protein"];
		$diff_intake["fat"] = $target["fat"]-$total["fat"];
		$diff_intake["carbo"] = $target["carbo"]-$total["carbo"];
 		return $diff_intake;
 	}
}
?>