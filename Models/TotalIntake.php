<?php
 require_once(ROOT_PATH."/Models/Db.php");
 class TotalIntake extends Db {
 	private $table = "total_intakes";
 	public function __construct($dbh = null){
 		parent::__construct($dbh);
 	}
 	public function calculation_total_intake($intakes) {
 		$total_intake = [];
 		$calorie = 0;
 		$fat = 0;
 		$protein = 0;
 		$carbo = 0;
 		foreach ($intakes as $intake) {
 			$user_id = $intake["user_id"];
 			$quantity = $intake["quantity"] / 100;
 			$calorie += $intake["calorie"] * $quantity;
 			$fat += $intake["fat"] * $quantity;;
 			$protein += $intake["protein"] * $quantity;;
 			$carbo += $intake["carbo"] * $quantity;;
 		}
 		$total_intake["user_id"] = $user_id;
 		$total_intake["calorie"] = $calorie;
 		$total_intake["fat"] = $fat;
 		$total_intake["protein"] = $protein;
 		$total_intake["carbo"] = $carbo;
 		return $total_intake;

 		// データベースに格納する
 	}
 	// データあればupdate,なければinsert
 	public function find_by_user_id($user_id,$current_time) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "SELECT * FROM $this->table WHERE user_id = :user_id AND created_at = :created_at";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":user_id",$user_id, PDO::PARAM_INT);
	 		$stmt->bindValue(":created_at",$current_time, PDO::PARAM_STR);
	 		$stmt->execute();
	 		$id = $stmt->fetchColumn();
	 		return $id;
	 	}catch(PDOExeception $e) {
	 		echo "接続エラー", $e->getMessage();
	 	}
 	}
 	public function insert_total_intake($total_intake,$user_id,$current_time){
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "INSERT INTO $this->table (calorie,protein,carbo,fat,user_id,created_at) VALUES (:calorie, :protein, :carbo, :fat, :user_id, :created_at)";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$params = array(":calorie"=>$total_intake["calorie"] , ":protein"=>$total_intake["protein"] , ":carbo"=>$total_intake["carbo"] , ":fat"=>$total_intake["fat"] , ":user_id"=>$user_id, ":created_at"=>$current_time);
 			$stmt->execute($params);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function reset_total_intake($user_id,$current_time){
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "INSERT INTO $this->table (user_id,created_at) VALUES (:user_id, :created_at)";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$params = array(":user_id"=>$user_id, ":created_at"=>$current_time);
 			$stmt->execute($params);
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function delete_total_intake($user_id,$current_time) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 			$sql = "DELETE FROM $this->table WHERE user_id = :user_id AND created_at = :created_at";
 			$stmt = $this->dbh->prepare($sql);
 			$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
 			$stmt->bindValue(":created_at",$current_time, PDO::PARAM_STR);
 			$stmt->execute();
 		}catch(PDOExeception $e) {
 			echo "接続エラー", $e->getMessage();
 		}
 	}
 	public function find_all_group_day($user_id) {
 		try{
 			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 		$sql = "SELECT calorie FROM $this->table WHERE user_id = :user_id AND created_at>=(NOW()-INTERVAL 7 DAY) ORDER BY created_at DESC";
	 		$stmt = $this->dbh->prepare($sql);
	 		$stmt->bindValue(":user_id",$user_id, PDO::PARAM_INT);
	 		$stmt->execute();
	 		$intake = $stmt->fetchAll(PDO::FETCH_ASSOC);
	 		return $intake;
	 	}catch(PDOExeception $e) {
	 		echo "接続エラー", $e->getMessage();
	 	}
 	}
 }

 ?>